<?php

namespace App\Http\Controllers\Admin\Import;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use App\Models\Sarpanch;
use App\Models\SarpanchMeta;
use App\Models\Admin; 
use App\Models\FollowUp; 

use Hash;
use Str;
use Mail;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\IOFactory;


class SarpanchDetailImportController extends Controller
{
 
    public function view(Request $req){
        $query = Sarpanch::query();
        if($req->has('name') && $req->name != null){
            $query->where('name','like','%' .$req->name . '%');
        }
         if($req->has('district_name') && $req->district_name != null  && $req->district_name != 'null'){
            $query->where('district_name','like','%' .$req->district_name . '%');
        }
        $sarpanches = $query->orderBy('id', 'desc')->paginate(10);
        $districts = Sarpanch::distinct()->pluck('district_name');
        return view('admin.import.sarpanch.list', compact('sarpanches','districts'));
    }

    public function import(Request $request){
        $admins = Admin::where('admin_role_id', 6)->pluck('id')->toArray();
        if (empty($admins)) {
            Session::flash('error', 'No Teller Caller found. Please add at least one Teller Caller before importing.');
            return redirect()->back();
        }
        $request->validate([
            'file' => 'required|mimes:xlsx'
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        $duplicateMobileNos = [];
        $invalidMobileNos = [];
        $importedMobileNos = [];
        $importedCount = 0;
        foreach ($rows as $index => $row) {
            if ($index === 1) {
                continue; 
            }
            $name        = isset($row['A']) ? trim($row['A']) : null;
            $mobile_no   = isset($row['B']) ? preg_replace('/\D/', '', trim($row['B'])) : null;
            $district    = isset($row['C']) ? trim($row['C']) : null;
            $village     = isset($row['D']) ? trim($row['D']) : null;
            $block       = isset($row['E']) ? trim($row['E']) : null;
            $occupation  = isset($row['F']) ? trim($row['F']) : null;
            $work_type   = isset($row['G']) ? trim($row['G']) : null;
            Log::channel('import-excel')->info('Cleaned Mobile No: ' . $mobile_no . ' for row ' . $index);
            if (!$mobile_no || !$name) {
                continue;
            }
            if (!preg_match('/^\d{10}$/', $mobile_no)) {
                $invalidMobileNos[] = $mobile_no;
                continue;
            }
            if (
                Sarpanch::where('mobile_no', $mobile_no)->exists() ||  in_array($mobile_no, $duplicateMobileNos) ||  in_array($mobile_no, $importedMobileNos)
            ) {
                $duplicateMobileNos[] = $mobile_no;
                Log::channel('import-excel')->info('Duplicate found: ' . $mobile_no);
                Log::channel('import-excel')->info('Duplicate Mobile No Array found: ' . implode(', ', $duplicateMobileNos));
                continue;
            }
            Sarpanch::create([
                'name'          => $name,
                'mobile_no'     => $mobile_no,
                'district_name' => $district,
                'village_name'  => $village,
                'block'         => $block,
                'occupation'    => $occupation,
                'work_type'     => $work_type,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
            $importedMobileNos[] = $mobile_no;
            $importedCount++;
        }
        

        // equally divide follow-up sarpanch id  
        $adminsData = Admin::where('admin_role_id', 6)->select('id', 'working_hour')->get();
        $totalWorkingHours = $adminsData->sum('working_hour');
        $distribution = [];
        foreach ($adminsData as $admin) {
            $ratio = $admin->working_hour / $totalWorkingHours;
            $distribution[$admin->id] = [
                'quota' => round($ratio * count($importedMobileNos)),
                'assigned' => 0
            ];
        }
        if (!empty($distribution) && !empty($importedMobileNos)) {
            foreach ($importedMobileNos as $mobileNo) {
                $sarpanch = Sarpanch::where('mobile_no', $mobileNo)->latest()->first();
                if ($sarpanch) {
                    foreach ($distribution as $adminId => $data) {
                        if ($data['assigned'] < $data['quota']) {
                            SarpanchMeta::create([
                                'sender_id'   => auth()->guard('admin')->id(),
                                'reciever_id' => $adminId,
                                'sarpanch_id' => $sarpanch->id,
                                'created_at'  => now(),
                                'updated_at'  => now(),
                            ]);
                            $distribution[$adminId]['assigned']++;
                            break; 
                        }
                    }
                }
            }
        }
        if (!empty($duplicateMobileNos)) {
            Log::channel('import-excel')->warning('Duplicate mobile numbers skipped: ' . implode(', ', array_unique($duplicateMobileNos)));
            Session::flash('warning', 'Duplicate mobile numbers skipped: ' . implode(', ', array_unique($duplicateMobileNos)));
        }
        if (!empty($invalidMobileNos)) {
            Log::channel('import-excel')->error('Invalid mobile numbers (not 10 digits) skipped: ' . implode(', ', array_unique($invalidMobileNos)));
            Session::flash('error', 'Invalid mobile numbers (not 10 digits) skipped: ' . implode(', ', array_unique($invalidMobileNos)));
        }
        Session::flash('success', "$importedCount Sarpanch entries imported successfully!");
        return redirect()->back();
    }


    public function viewFollowUp($id){
        $query = FollowUp::query();
        $sarpanch = Sarpanch::findOrFail(decrypt($id));
        $followups = $query->orderBy('id','desc')->where('sarpanch_id',decrypt($id))->paginate(10);
        return view('admin.import.sarpanch.follow-up-view', compact('followups','sarpanch'));
    }




}
