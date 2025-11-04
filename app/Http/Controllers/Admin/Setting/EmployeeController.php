<?php

namespace App\Http\Controllers\Admin\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use App\Models\AdminRole;
use App\Models\Admin;
use App\Models\FollowUp;
use App\Models\SarpanchMeta;
use App\Models\City;
use App\Models\MemberCreation;
use App\Models\User;
use App\Models\Referral;

use Hash;
use Str;
use Mail;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use App\Exports\Admin\RoleExport;
use App\Exports\Admin\EmployeeExport;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class EmployeeController extends Controller
{
  
    public function roleView(Request $req){
        $query = AdminRole::query();
        if($req->has('name') && $req->name != null){
            $query->where('name','like','%' .$req->name . '%');
        }
        if ($req->has('export')) {
            return Excel::download(new RoleExport($query->get()), 'role_list.xlsx');
        }
        $roles = $query->where('id', '!=', 1)->orderBy('id','desc')->paginate(10);
        return view('admin.role.add',compact('roles'));
    }

    public function roleStore(Request $req){
        // dd($req->all());
        $req->validate([
            'name' => 'required|string|unique:admin_roles,name',
            'module' => 'required|array',
        ], [
            'name.required' => 'This role name is required.',
            'name.string' => 'This role name must be a valid string.',
            'name.unique' => 'This role name already exists. Please enter a different one.',
            'module.required' => 'At least one module must be selected.',
            'module.array' => 'Invalid format for modules.',
        ]);
        

        $adminRole = new AdminRole();
        $adminRole->name = $req->name;
        $adminRole->module = json_encode($req->module);
        $adminRole->save();
        return back()->with('success','Role Setup Successfully!');
    }

    
    public function statusChange(Request $request)
    {
        $request->validate([
            'role_id' => 'required|numeric',  
            'status' => 'required|boolean',  
        ]);    
    
        try {
            $adminRole = AdminRole::findOrFail($request->role_id);
            $adminRole->status = $request->status;
    
            if ($adminRole->save()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Role status updated successfully',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update review status.',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function roleEdit($id){
        $role = AdminRole::findOrFail($id);
        if(!$role){
            return back()->with('error','Role Not Found!');
        }
        $selectedModules = json_decode($role->module, true) ?? [];
        return view('admin.role.edit', compact('role','selectedModules'));
    }

    public function roleUpdate(Request $req){
        // dd($req->all());
        $id = $req->id;
        $role = AdminRole::findOrFail($id);
        if(!$role){
            return back()->with('error','Role Not Found!');
        }
        $req->validate([
           'name' => 'required|string|unique:admin_roles,name,' . $id,
            'module' => 'required|array',
        ], [
            'name.required' => 'This role name is required.',
            'name.string' => 'This role name must be a valid string.',
            'name.unique' => 'This role name already exists. Please enter a different one.',
            'module.required' => 'At least one module must be selected.',
            'module.array' => 'Invalid format for modules.',
        ]);
        
        $role->name = $req->name;
        $role->module = json_encode($req->module);
        $role->save();
        return redirect()->route('admin.custom-role.add')->with('success', 'Role Update Successfully!');
    }

    public function roleDelete($id){
        // dd($id);
        $role = AdminRole::findOrFail($id);
        if(!$role){
            return back()->with('error','Role Not Found!');
        }
        $role->delete();
        return back()->with('error','Role Delete Successfully!');
    }


    public function employeeView(Request $req){
        // dd($req->all());
        $query = Admin::query();
        if($req->has('name') && $req->name != null){
            $query->where('name','like','%' .$req->name . '%');
        }
        if ($req->has('admin_role_id') && $req->admin_role_id !== 'null' && $req->admin_role_id !== null) {
            $query->where('admin_role_id',$req->admin_role_id);
        }
        if ($req->has('export')) {
            return Excel::download(new EmployeeExport($query->get()), 'employee_list.xlsx');
        }
        $employees = $query->where('id', '!=', 1)->orderBy('id','desc')->paginate(10);
        $roles = AdminRole::where('id', '!=', 1)->orderBy('id','desc')->get();
        $districts = City::where('state_id',13)->get();
        // dd($roles);
        return view('admin.employee.add',compact('employees','roles','districts'));
    }

    public function employeeStore(Request $req){
        // dd($req->all());
        $rules = [
            'name' => 'required|string',
            'mobile_no' => 'required|digits:10|unique:admins,mobile_no',
            'email' => 'required|email|unique:admins,email',
            'admin_role_id' => 'required|numeric',
            'identify_type' => 'required|numeric',
            'identify_number' => 'required|string',
            'password' => 'required|string',
            'image' => 'required|image|mimes:jpeg,jpg,png',
            'identity_image' => 'required|image|mimes:jpeg,jpg,png',
        ];
        if ($req->admin_role_id == 6) {
            $rules['working_hour'] = 'required|numeric';
        }
         if ($req->admin_role_id == 8) {
            $rules['city'] = 'required|numeric';
        }
        $messages = [
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a valid string.',
            'mobile_no.required' => 'Mobile number is required.',
            'mobile_no.digits' => 'Mobile number must be exactly 10 digits.',
            'mobile_no.unique' => 'This mobile number is already taken.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'This email is already registered.',
            'admin_role_id.required' => 'Please select an admin role.',
            'admin_role_id.numeric' => 'Admin role must be numeric.',
            'identify_type.required' => 'Identification type is required.',
            'identify_type.numeric' => 'Identification type must be numeric.',
            'identify_number.required' => 'Identification number is required.',
            'identify_number.string' => 'Identification number must be a string.',
            'password.required' => 'Password is required.',
            'password.string' => 'Password must be a string.',
            'image.required' => 'Profile image is required.',
            'image.image' => 'Profile image must be a valid image file.',
            'image.mimes' => 'Profile image must be a JPEG or PNG file.',
            'identity_image.required' => 'Identity image is required.',
            'identity_image.image' => 'Identity image must be a valid image file.',
            'identity_image.mimes' => 'Identity image must be a JPEG or PNG file.',
            'working_hour.required' => 'Working hour is required when role is 6.',
            'working_hour.numeric' => 'Working hour must be numeric.',
            'city.required' => 'District Name is required ',
            'city.numeric' => 'District Name must be numeric.',
        ];
        $req->validate($rules, $messages);  
        $admin = new Admin();
        $admin->name = $req->name;
        $admin->mobile_no = $req->mobile_no;
        $admin->email = $req->email;
        $admin->admin_role_id = $req->admin_role_id;
        $admin->identify_type = $req->identify_type;
        $admin->identify_number = $req->identify_number;
        $admin->password = Hash::make($req->password);
        $admin->working_hour = $req->working_hour ?? null;
        $admin->city = $req->city ?? null;
        $admin->status = 1;
        if($req->identity_image != null){
            $file = $req->identity_image;
            $filename = time(). '.' . $file->getClientOriginalExtension();
            $year = now()->year;
            $month = now()->format('M');
            $folderPath = public_path("app/admin/identity-image/{$year}/{$month}");
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);  
            }
            $file->move($folderPath, $filename);
            $admin->identity_image = "app/admin/identity-image/{$year}/{$month}/" . $filename;
        }

        if($req->image != null){
            $file = $req->image;
            $filename = time(). '.' . $file->getClientOriginalExtension();
            $year = now()->year;
            $month = now()->format('M');
            $folderPath = public_path("app/admin/image/{$year}/{$month}");
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);  
            }
            $file->move($folderPath, $filename);
            $admin->image = "app/admin/image/{$year}/{$month}/" . $filename;
        }
        $admin->save();
        $admin->referral_code = 'EMP' . $admin->id;
        $admin->save();
        $qrCodePath = $this->generateIdCardQRCode($admin->id);
        if ($qrCodePath) {
            $admin->qr_code_path = $qrCodePath;
            $admin->save();
        }
        $pdfPath = $this->generateIdCardPdf($admin->id, $qrCodePath);
        if ($pdfPath) {
            $admin->id_card_pdf_path = $pdfPath;
            $admin->save();
        }       
        return back()->with('success','Employee Add Successfully!');
    }

    private function generateIdCardQRCode($id){
        $year = now()->year;
        $month = now()->format('M');
        $qrCodeDirectory = public_path("app/admin/identity-image/qr-codes/{$year}/{$month}");
        Log::channel('email')->info("Generating QR code for id-card", ['id' => $id]);
        if (!File::exists($qrCodeDirectory)) {
            File::makeDirectory($qrCodeDirectory, 0777, true);
        }
          try {
            $qrCode = new QrCode(route('employee-id-card-info', ['id' => $id]));
            $writer = new PngWriter();
            $qrCodeContent = $writer->write($qrCode)->getString();
            $qrCodeFilePath = "{$qrCodeDirectory}/{$id}-qr.jpg";
            file_put_contents($qrCodeFilePath, $qrCodeContent);
            Log::channel('email')->info("QR code generated successfully", ['file_path' => $qrCodeFilePath]);
            return "app/admin/identity-image/qr-codes/{$year}/{$month}/{$id}-qr.jpg";
        } catch (\Exception $e) {
            Log::channel('email')->error("QR code generation failed", ['error' => $e->getMessage()]);
            return null;
        }
    }

    private function generateIdCardPdf($id, $qrCodeFilePath)
    {
        $year = now()->year;
        $month = now()->format('M');
        $fileName = "{$id}.pdf";
        $directoryPath = public_path("app/admin/identity-image/id-cards/{$year}/{$month}");
        Log::channel('email')->info("Generating id-card PDF", ['id' => $id]);
        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0777, true);
        }
        try {
            $filePath = "{$directoryPath}/{$fileName}";
            $admin = Admin::where('id',$id)->first();
            if($admin == null){
                Log::channel('email')->error("admin Not Found for this admin id :", ['id' => $id]);
                return null;
            }
            $pdf = Pdf::loadView('admin.auth.profile.id-card', compact('id','admin','qrCodeFilePath'));
            $pdf->save($filePath);
            Log::channel('email')->info("Invoice PDF generated successfully", ['file_path' => $filePath]);
            return "app/admin/identity-image/id-cards/{$year}/{$month}/{$fileName}";
        } catch (\Exception $e) {
            Log::channel('email')->error("Invoice PDF generation failed", ['error' => $e->getMessage()]);
            return null;
        }
    }

    public function employeeEdit($id){
        $admin = Admin::findOrFail($id);
        if(!$admin){
            return back()->with('error','Admin Not Found!');
        }
        return view('admin.employee.edit', compact('admin'));
    }

    
    public function employeeViews($id){
        $admin = Admin::findOrFail(decrypt($id));
        $roles = json_decode($admin->role->module,true);
        $working_hour = 0;
        $followUps = 0;
        $sarpanchs = 0;
        $followupSummary = [];
        $months = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
        if($admin->admin_role_id  == 6){
            $working_hour = $admin->working_hour ?? 0;
            $followUps = FollowUp::where('user_id', $admin->id)->count();
            $sarpanchs = SarpanchMeta::where('reciever_id', $admin->id)->count();
            $rawData = FollowUp::select(
                        DB::raw('MONTH(created_at) as month'),
                        'status',
                        DB::raw('COUNT(*) as total')
                    )
                    ->where('user_id', $admin->id)
                    ->groupBy(DB::raw('MONTH(created_at)'), 'status')
                    ->get();
            
            for ($m = 1; $m <= 12; $m++) {
                $followupSummary[$m] = [
                    'month' => date('F', mktime(0, 0, 0, $m, 1)),
                    'Call Back Later' => 0,
                    'Not Interested' => 0,
                    'Not Picked Up' => 0,
                    'Other' => 0,
                ];
            }
            foreach ($rawData as $row) {
                $month = $row->month;
                $status = $row->status;
                $count = $row->total;

                if (in_array($status, ['Call Back Later', 'Not Interested', 'Not Picked Up', 'Other'])) {
                    $followupSummary[$month][$status] = $count;
                }
            }
        }
        $name = request()->query('name');
        $createdUserIds = MemberCreation::where('employee_id', $admin->id)->pluck('user_id');
        $members = User::where('member_type', '1')->whereIn('id', $createdUserIds)->when($name, function ($query, $name) {
                        $query->where('name', 'like', '%' . $name . '%');
                    })->orderBy('id', 'desc')->paginate(10);
        return view('admin.employee.view', compact('admin','roles','working_hour','followUps','sarpanchs','followupSummary','months','members'));
    }

    public function employeeStatusChange(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|numeric',  
            'status' => 'required|boolean',  
        ]);    
    
        try {
            $admin = Admin::findOrFail($request->employee_id);
            $admin->status = $request->status;
    
            if ($admin->save()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Employee status updated successfully',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update review status.',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function filterFollowUpReport(Request $request)
    {
        //  dd($request->all());
        $query = FollowUp::where('user_id',$request->admin_id);
        if ($request->filter_values == 'this_year') {
            $query->whereYear('created_at', date('Y'));
            $groupedQuery = (clone $query)
                ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->groupByRaw('MONTH(created_at)');
            $monthlyCounts = $groupedQuery->pluck('count', 'month');
            $monthlyData = array_fill(0, 12, 0); 
            foreach ($monthlyCounts as $month => $count) {
                $monthlyData[$month - 1] = $count;
            }
            $totalCount = $query->count();
            return response()->json([
                'monthlyData' => array_values($monthlyData),
                'totalCount' => $totalCount
            ]);
        }

        elseif ($request->filter_values == 'this_month') {
            $query->whereYear('created_at', date('Y'))
                ->whereMonth('created_at', date('m'));
            $groupedQuery = (clone $query)
                ->selectRaw('DAY(created_at) as day, COUNT(*) as count')
                ->groupByRaw('DAY(created_at)');
            $dailyCounts = $groupedQuery->pluck('count', 'day');
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
            $dailyData = array_fill(0, $daysInMonth, 0);
            foreach ($dailyCounts as $day => $count) {
                $dailyData[$day - 1] = $count;
            }
            $totalCount = $query->count();
            return response()->json([
                'monthlyData' => array_values($dailyData),
                'totalCount' => $totalCount
            ]);
        }

       elseif ($request->filter_values == 'this_week') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            $groupedQuery = (clone $query)
                ->selectRaw('DAYOFWEEK(created_at) as day, COUNT(*) as count') 
                ->groupBy('day');
            $dailyCounts = $groupedQuery->pluck('count', 'day');
            $weeklyData = array_fill(0, 7, 0); 
            foreach ($dailyCounts as $day => $count) {
                $weeklyData[$day - 1] = $count;
            }
            $totalCount = $query->count();
            return response()->json([
                'monthlyData' => array_values($weeklyData),
                'totalCount' => $totalCount
            ]);
        }


        // Filter by Today
        elseif ($request->filter_values == 'today') {
            $query->whereDate('created_at', today());
            $count = $query->count(); 
            return response()->json([
                'monthlyData' => [$count],
                'totalCount' => $count
            ]);
        }
         // Filter by Custom Date Range (Show Data by Date)
        elseif ($request->filter_values == 'custom' && $request->startDate && $request->endDate) {
            $query->whereBetween('created_at', [$request->startDate, $request->endDate]);
            $counts = $query
                ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
                ->groupBy('date')
                ->pluck('total', 'date');
            $dateRange = [];
            $currentDate = strtotime($request->startDate);
            $endDate = strtotime($request->endDate);
            while ($currentDate <= $endDate) {
                $formattedDate = date('Y-m-d', $currentDate);
                $dateRange[$formattedDate] = 0; // Default value if no records found
                $currentDate = strtotime("+1 day", $currentDate);
            }
            foreach ($counts as $date => $total) {
                $dateRange[$date] = $total;
            }
            $totalCount = array_sum($dateRange);
            return response()->json([
                'monthlyData' => array_values($dateRange),
                'totalCount' => $totalCount
            ]);
        }



        return response()->json(['monthlyData' => []]);
    }

    public function filterFollowUpReportMonthWise($month,$adminId)
    {
        $month = $month;
        $followups = FollowUp::with('sarpanch')->where('user_id', $adminId)->whereMonth('created_at', $month)->orderBy('created_at', 'desc')->get();
        $admin = Admin::findOrFail($adminId);
        $pdf = PDF::loadView('pdf.admin.employee.followup-monthly-pdf', compact('followups', 'month', 'admin'));
        return $pdf->download("followUp-report-month-$month.pdf");
    }

    public function employeeReferral($id, Request $request)    {
        $admin = Admin::findOrFail(decrypt($id));
        $query = Referral::where('user_type', 2)->where('referrer_id', $admin->id);
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        $referrals = $query->orderByDesc('id')->paginate(10);
        return view('admin.employee.referral', compact('admin', 'referrals'));
    }

   

 



}
