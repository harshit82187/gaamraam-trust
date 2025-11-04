<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Str;

use App\Models\FollowUp;
use App\Models\SarpanchMeta;
use App\Models\Sarpanch;
use Carbon\Carbon;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class FollowUpController extends Controller
{
 
    public function view(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $today = \Carbon\Carbon::today();

        $query = SarpanchMeta::query()->with(['sarpanch', 'latestFollowUp']);

        // Role-based filtering
        if ($admin->admin_role_id != 1) {
            $query->where('reciever_id', $admin->id);
        }

        // Name filter
        if ($request->filled('name')) {
            $query->whereHas('sarpanch', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        // District filter
        if ($request->filled('district_name') && $request->district_name != 'null') {
            $query->whereHas('sarpanch', function ($q) use ($request) {
                $q->where('district_name', 'like', '%' . $request->district_name . '%');
            });
        }

        // Case 2: If specific next_date is passed
        if ($request->filled('next_date')) {
            $query->whereHas('followUps', function ($q) use ($request) {
                $q->whereDate('next_date', $request->next_date);
            });

            $allMetas = $query->orderBy('id', 'desc')->get();
        } else {
            // Case 1: Default view
            $allMetas = $query->orderBy('id', 'desc')->get();

            // Apply next_date filter only if name filter is NOT applied
            if ($admin->admin_role_id != 1 && !$request->filled('name')) {
                $allMetas = $allMetas->filter(function ($meta) use ($today) {
                    $nextDate = optional($meta->latestFollowUp)->next_date;
                    return !$nextDate || \Carbon\Carbon::parse($nextDate)->lte($today);
                })->sortByDesc(function ($meta) use ($today) {
                    $nextDate = optional($meta->latestFollowUp)->next_date;
                    return $nextDate && \Carbon\Carbon::parse($nextDate)->lte($today) ? 1 : 0;
                })->values(); // reset keys
            }
        }

        // Paginate manually
        $page = $request->get('page', 1);
        $perPage = 10;
        $metas = new \Illuminate\Pagination\LengthAwarePaginator(
            $allMetas->forPage($page, $perPage),
            $allMetas->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $districts = Sarpanch::distinct()->pluck('district_name');

        if ($admin->admin_role_id == 1) {
            return view('admin.follow-up.list', compact('metas', 'districts'));
        }
        // dd($metas);

        return view('admin.follow-up.member.list', compact('metas', 'districts'));
    }



    public function save(Request $req){
        // dd($req->all());
        try{   
            $rules = [
                'sarpanch_id' => 'required|integer',
                'status' => 'string|required',
                'remark' => 'required|string',
                'next_date' => 'date|required',
                'time' => 'required',
            ];
            $messages = [
                'status.required' => 'Please select a follow-up status.',
                'remark.required' => 'Remarks are required.',
                'remark.string' => 'Remarks are required.',
                'next_date.required' => 'Please select next follow-up date.',
                'next_date.date' => 'Date format is invalid.',
                'time.required' => 'Please select  next follow-up time.',
            ];
            $validator = Validator::make($req->all(), $rules, $messages);
            $admin = Auth::guard('admin')->user();            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $today = new \DateTime();
            $followEntry = FollowUp::where('sarpanch_id',$req->sarpanch_id)->where('user_id',$admin->id)->first();
            if($followEntry){
                // dd($today);
                $latestEntry = FollowUp::where('sarpanch_id',$req->sarpanch_id)->where('user_id',$admin->id)->latest('created_at')->first();
                // dd($latestEntry);
                $currentFollowUpDate = new \DateTime($latestEntry->next_date);
                // dd($currentFollowUpDate);
                $delayDays = $currentFollowUpDate->diff($today)->days;
                // dd($delayDays);
                $data = [
                    'user_id'          => $admin->id,
                    'status'           => $req->status,
                    'sarpanch_id'      => $req->sarpanch_id,
                    'remark'           => $req->remark,
                    'next_date'        => $req->next_date,
                    'time'             => $req->time,
                    'delay_in_day'     => $delayDays > 0 ? $delayDays  : '0',
                    'is_complete'      => '0',
                    'is_delay'         => $delayDays > 0 ? '1' : '0',
                ];
                $latestEntry->update([
                    'is_complete' => '1',
                ]);         
            }else{
                $data = [
                    'user_id'          => $admin->id,
                    'status'           => $req->status,
                    'sarpanch_id'      => $req->sarpanch_id,
                    'remark'           => $req->remark,
                    'next_date'        => $req->next_date,
                    'time'             => $req->time,
                    ];                    
            }
            FollowUp::create($data);            
            return response()->json([
                'success' => true,
                'message' => 'Follow Up Added Successfully!'
            ],201);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'Message' => $e->getMessage()
            ],500);
        }
    }

    public function show($sarpanchId, Request $request)
    {
        try {
            $admin = Auth::guard('admin')->user();
            $type = $request->query('type');
            $query = FollowUp::query();
            if ($type !== 'admin') {
                $query->where('user_id', $admin->id);
            }
            $followups = $query->where('sarpanch_id', $sarpanchId)
                            ->orderBy('created_at', 'desc')
                            ->get();
            if ($followups->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No Follow Up Found',
                ], 404);
            }
            return response()->json([
                'success' => true,
                'followups' => $followups
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    

   

}