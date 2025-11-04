<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Models\User;
use App\Models\Admin;
use App\Models\Student;
use App\Models\College;
use App\Models\Payment;
use App\Models\Task;
use App\Models\Document;
use App\Models\Ticket;
use App\Models\BussinessSetting;
use App\Models\Referral;
use App\Models\MemberCreation;
use App\Models\StudentCreation;
use App\Models\ExcelLog;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use PDF;
use Illuminate\Support\Facades\File;
use DB;
use Mail;
use App\Mail\Admin\Otp\AdminOtpMail;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function login(Request $req){
        try{
            if($req->isMethod('get')){
                // dd(Auth::guard('admin')->check());
                return view('admin.auth.login');
    
            }else{
                $req->validate([
                    'email' => 'required|email',
                    'password' => 'required'
                ]);
                $email = $req->email;
                $password = $req->password;
                $admin = Admin::where('email',$email)->first();
                // dd($admin,$req->all());
                if($admin){
                    if(Auth::guard('admin')->attempt([ 'email' => $email, 'password' => $password ])){
                        $admin = Auth::guard('admin')->user();
                        if ($admin->admin_role_id == 1) {
                            $otp = rand(100000, 999999);
                            DB::table('otps')->updateOrInsert(
                                ['email' => $admin->email],
                                ['otp' => $otp, 'type' =>1,'updated_at' => now(), 'created_at' => now()]
                            );
                            Mail::to($admin->email)->queue(new AdminOtpMail($otp, $admin->email));
                            $this->sendWhatsappOtp($admin->name,$admin->email,$admin->mobile_no,$otp);
                            $encryptedEmail = encrypt($admin->email);
                            Auth::guard('admin')->logout();
                            return redirect()->route('admin.otp.verify',['email' => $encryptedEmail])->with('success', 'OTP sent to your registered email.');
                        }
                        return redirect()->route('admin.dashboard')->with('success','Login Successfully!');
                    }else{
                        return back()->with('error','Wrong Credentials!');
                    }    
                }else{
                    return back()->with('error','Record Not Found!');
                }   
                
            }

        }catch (ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        }catch(\Exception $e){
            return back()->with('error', 'Warning : ' .$e->getMessage());
        }        
    }

    public function showOtpForm(){
        return view('admin.auth.verify-otp');
    }

    
    public function verifyOtp(Request $req){
        // dd($req->all());
        $req->validate([
            'otp' => 'required|digits:6',
            'email' => 'required|string',
        ]);
        $decryptEmail = decrypt($req->email);
        // dd($decryptEmail);
        $otpEntry = DB::table('otps')->where('type',1)->where('email', $decryptEmail)->first();  
        if ($otpEntry && $otpEntry->otp == $req->otp) {   
            $admin = Admin::where('email', $decryptEmail)->first();
            Auth::guard('admin')->login($admin);
            DB::table('otps')->where('type',1)->where('email', $decryptEmail)->delete();
            return redirect()->route('admin.dashboard')->with('success', 'OTP Verified. Welcome!');
        }
        return back()->with('error', 'Invalid OTP!');
    }

    private function sendWhatsappOtp($name, $email, $mobile_no,$otp)
    {       
        $message = 
            "🔐 *Login Verification OTP*\n\n" .
            "Hi *$name*,\n\n" .
            "Your one-time password (OTP) for secure login is:\n" .
            "👉 *$otp*\n\n" .
            "Please enter this OTP to complete your login process.\n\n" .
            "⏳ *Note:* This OTP is valid for a short time only. Do not share it with anyone for your security.\n\n" .
            "🔒 Stay safe,\n" .
            "*GaamRaam NGO Team*";
        if (!str_starts_with($mobile_no, '+91')) {
            $MobileNo = '+91' . $mobile_no;
        }
        try {
            $apiKey = BussinessSetting::find(14)->value;
            $response = Http::get('http://api.textmebot.com/send.php', [
                'recipient' => $MobileNo,
                'apikey'    => $apiKey,
                'text'      => $message,
                // 'document' => $pdfPath,
            ]);
            if ($response->successful()) {
                $body = strtolower($response->body());
                if (str_contains($body, 'error') || str_contains($body, 'failed')) {
                    Log::channel('order')->error('API responded but failed to send message : ' . $response->body());
                }
            } else {
                Log::channel('order')->error('API Error: ' . $response->status() . ' - ' . $response->body());
            }
        } catch (Exception $e) {
            Log::channel('order')->error('WhatsApp API Exception', ['error' => $e->getMessage()]);
        }
    }


    public function dashboard(Request $request){
        // dd(Auth::guard('admin')->user());        
        $admin = Auth::guard('admin')->user();        

        if(in_array($admin->admin_role_id, [1,2,3])){
             // Super Admin → all data
            $member = User::where('member_type','1')->where('status','1')->count();
            $nriMember = User::where('member_type','2')->where('status','1')->count();
            $student = Student::where('status','1')->count();
            $college = College::where('status','1')->count();
            $ticket = Ticket::where('status','1')->count();
            $task = Task::count();
            $donation = Payment::sum('amount');
            $monthlyData = [];
            for ($month = 1; $month <= 12; $month++) {
                $monthlyData['student'][] = Student::where('status', '1')
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', date('Y'))
                    ->count();
        
                $monthlyData['member'][] = User::where('status', '1')->where('member_type','1')
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', date('Y'))
                    ->count();
        
                $monthlyData['nriMember'][] = User::where('member_type','2')->whereMonth('created_at', $month)
                    ->whereYear('created_at', date('Y'))
                    ->count();
            }
            $pointsChartLabels = [];
            $pointsChartValues = [];
            $excel = 0;
            $selectedCity = 0;
        }else {
            $selectedCity = $request->get('city') ?? $admin->city;

            $today = now()->format('Y-m-d');
            $admins = Admin::select('id', 'name', 'points', 'city')->where(function ($query) use ($selectedCity, $admin) {
                            $query->where('city', $selectedCity)
                                ->orWhere('id', $admin->id);
                        })
                        ->orderBy('id', 'asc')
                        ->get();

            $pointsChartLabels = [];
            $pointsChartValues = [];

            foreach ($admins as $adm) {
                $label = ($adm->id == $admin->id) ? "You ({$adm->name})" : $adm->name;
                $pointsChartLabels[] = $label;
                $pointsChartValues[] = $adm->points ?? 0;
            }

            // Dashboard data (unchanged)
            $member = MemberCreation::where('employee_id',$admin->id)->count();
            $student = StudentCreation::where('employee_id',$admin->id)->count();
            $excel = ExcelLog::where('admin_id',$admin->id)->count();
            $nriMember  = $college = $ticket = $task = $donation = 0;
            $monthlyData = ['student' => [], 'member' => [], 'nriMember' => []];
        }
        $permissions = json_decode($admin->role->module);
        session(['role_permissions' => $permissions,'admin_id' => $admin->id]);
        // dd($permissions,$admin->id);
        return view('admin.dashboard', compact('member','nriMember','student','monthlyData','college','task','donation','ticket','admin','excel','pointsChartLabels', 'pointsChartValues','selectedCity'));
    }

    public function dataFilter(Request $req) {
        // dd($req->all());
        $dateRange = $req->input('filter_values'); 
        $startDate = now()->startOfDay();
        $endDate = now()->endOfDay();
        $admin = Auth::guard('admin')->user();
        switch ($dateRange) {
            case 'yesterday':
                $startDate = now()->subDay()->startOfDay();
                $endDate = now()->subDay()->endOfDay();
                break;
            case 'last7days':
                $startDate = now()->subDays(6)->startOfDay(); // Start from 6 days ago to today
                $endDate = now()->endOfDay();
                break;
            case 'last30days':
                $startDate = now()->subDays(29)->startOfDay(); // Start from 29 days ago to today
                $endDate = now()->endOfDay();
                break;
            case 'thisMonth':
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
                break;
            case 'lastMonth':
                $startDate = now()->subMonth()->startOfMonth();
                $endDate = now()->subMonth()->endOfMonth();
                break;
            case 'custom':
                $startDate = Carbon::parse($req->input('startDate', now()->startOfDay()->toDateString()))->startOfDay();
                $endDate = Carbon::parse($req->input('endDate', now()->endOfDay()->toDateString()))->endOfDay();
                break;
            default:
                break;
        }
    
         
        $top_members = Admin::where('admin_role_id', '!=', 1)->orderByRaw('CAST(points AS UNSIGNED) DESC')->take(5)->get(['name', 'points', 'image']);
        $student_count = Student::where('status', '1')->whereBetween('created_at', [$startDate, $endDate])->count();         
        $document_count = Document::whereBetween('created_at', [$startDate, $endDate])->count();    
        $college_count = College::where('status', '1')->whereBetween('created_at', [$startDate, $endDate])->count();    
        $task_count = Task::whereBetween('created_at', [$startDate, $endDate])->count();    
        $donation_sum = Payment::whereBetween('created_at', [$startDate, $endDate])->sum('amount');
       
    
        // dd([
        //     'student_count' => $student_count,
        //     'document_count' => $document_count,
        //     'college_count' => $college_count,
        //     'task_count' => $task_count,
        //     'donation_sum' => $donation_sum,
        //     'startDate' => $startDate,
        //     'endDate' => $endDate,
        //     'top_members' => $top_members,
        // ]);
    
        return response()->json([
            'data' => [
                'student_count' => $student_count,
                'document_count' => $document_count,
                'college_count' => $college_count,
                'task_count' => $task_count,
                'donation_sum' => $donation_sum,
                'top_members'  => $top_members ?? 0,
            ],
            'admin_role_id' => $admin->admin_role_id 
        ]);
    }

    public function users(){
        return view('backend.user.index');
    }

    public function profile(){
        $admin = Auth::guard('admin')->user();
        // dd($admin);
        return view('admin.profile', compact('admin'));
    }

    public function profileUpdate(Request $req){
        // dd($req->all());
        $admin = Auth::guard('admin')->user();
        if($req->type == 2){
            $req->validate([
                'new_password' => 'required|string',
                'new_password_confirmation' => 'required|string',
            ]);
            $admin->password = Hash::make($req->new_password);
            $admin->save();
            return back()->with('success', 'Password Update Successfully successfully!');
        }
        $req->validate([
            'name' => 'required|string',
            'mobile_no' => 'required|numeric|digits:10',
            'email' => 'required|email|unique:admins,email,' .$admin->id,
            'blood_group' => 'required|string',
        ]);
        if($req->image != null){
            if ($admin->image && File::exists(public_path($admin->image))) {
                File::delete(public_path($admin->image));
            }
            $file = $req->image;
            $filename = time(). '.' . $file->getClientOriginalExtension();
            $year = now()->year;
            $month = now()->format('M');
            $folderPath = public_path("app/admin-profile/{$year}/{$month}");
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);  
            }
            $file->move($folderPath, $filename);
            $admin->image = "app/admin-profile/{$year}/{$month}/" . $filename;
        }
        $admin->name = $req->name;
        $admin->mobile_no = $req->mobile_no;
        $admin->email = $req->email;
        $admin->blood_group = $req->blood_group;
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
        
        return back()->with('success', 'Profile Update Successfully successfully!');
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
        // dd($id);
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
            Log::channel('email')->info("profile PDF generated successfully", ['file_path' => $filePath]);
            return "app/admin/identity-image/id-cards/{$year}/{$month}/{$fileName}";
        } catch (\Exception $e) {
            Log::channel('email')->error("profile PDF generation failed", ['error' => $e->getMessage()]);
            return null;
        }
    }

    public function downloadIdCard($id){
        $admin = Admin::where('id', decrypt($id))->first();
        
        $pdfPath = public_path($admin->id_card_pdf_path);
        if (!file_exists($pdfPath)) {
            abort(404, 'ID Card PDF not found.');
        }
        return response()->download($pdfPath, 'Employee-ID-Card-' . $admin->id . '.pdf', [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="Employee-ID-Card-' . $admin->id . '.pdf"'
        ]);
    }

    public function IdCardInfo($id){
        $admin = Admin::where('id', $id)->first();
        return view('admin.auth.profile.website-id-card', compact('admin'));
    }

    public function earnPoint(Request $req){
        $admin = Auth::guard('admin')->user();       
        $query = Referral::where([
            'user_type' => 2,
            'referrer_id' => $admin->id,
        ]);

        if (request()->filled('start_date')) {
            $query->whereDate('created_at', '>=', request('start_date'));
        }
        if (request()->filled('end_date')) {
            $query->whereDate('created_at', '<=', request('end_date'));
        }
        $referrals = $query->orderBy('id', 'desc')->paginate(10);
        return view('admin.auth.profile.earn-point', compact('referrals'));   
    }


    public function logout(){
        Auth::guard('admin')->logout();
        session()->flush();
        // dd('Logged out');
        return redirect()->route('admin.login')->with('error','Logout Successfully!');
    }



   

}