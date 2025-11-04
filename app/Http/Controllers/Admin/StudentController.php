<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Mail;
use Hash;

use App\Models\Document;
use App\Models\Notification;
use App\Models\Student;
use App\Models\City;
use App\Models\StudentCreation;
use App\Models\BussinessSetting;
use App\Models\Referral;
use App\Models\Admin;
use App\Models\Sarpanch;
use App\Models\SarpanchMeta;
use App\Models\ExcelLog;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\IOFactory;

class StudentController extends Controller
{
  
    public function enroolStudent(Request $req)
    {
        $admin = Auth::guard('admin')->user();
        $citys = City::where('state_id', 13)->get();
        $query = Student::query();
        if ($admin->admin_role_id != 1) {
            $createdStudentIds = StudentCreation::where('employee_id', $admin->id)->pluck('student_id');
            $query->whereIn('id', $createdStudentIds);
        }
        if ($req->filled('name')) {
            $query->where('name', 'like', '%' . $req->name . '%');
        }
        if ($req->filled('city')) {
            $query->where('city', $req->city);
        }
        $students = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.student.index', compact('students', 'citys'));
    }

    public function create(){
        return view('admin.student.create');
    }

    public function sendNotification(Request $req){
        // dd($req->all());
        $notification = new Notification();
        $notification->subject = $req->subject;
        $notification->user_id = $req->student_id;
        $notification->description = $req->description;

        if($req->image != null){
            $file = $req->image;
            $filename = time(). '.' . $file->getClientOriginalExtension();
            $year = now()->year;
            $month = now()->format('M');
            $folderPath = public_path("notification/{$year}/{$month}");
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);  
            }
            $file->move($folderPath, $filename);
            $notification->image = "notification/{$year}/{$month}/" . $filename;
        }
        $notification->save();
        return back()->with('success','Notification Send Successfully!');

    }

    public function enroolStudentInfo($id){
        // dd($id);
        $student = Student::find($id);
        if(!$student){
            return back()->with('error','Student Not Found!');
        }
        $documents = Document::where('student_id',$student->id)->paginate(10);
        return view('admin.student.info', compact('student','documents'));
    }

    public function enroolStudentSave(Request $req){
        // dd($req->all());
        $admin = Auth::guard('admin')->user();
        $validatedData = $req->validate([
            'name' => 'required|string|max:250',
            'mobile' => 'required|digits:10|unique:students,mobile',
            'email' => 'required|email|unique:students,email',
            'course' => 'required|string',
            'blood_group' => 'required|string',
            'password' => 'required|string|min:8',
        ], [
            'email.unique' => 'This Email Already Exists in the Database. Try Another Email.',
            'mobile.unique' => 'This Mobile Number Already Exists in the Database. Try Another Number.',
            'password.min' => 'Password Must Be At Least 8 Characters Long.',
        ]);

        $image = null;
        if($req->image != null){
            $file = $req->image;
            $filename = time(). '.' . $file->getClientOriginalExtension();
            $year = now()->year;
            $month = now()->format('M');
            $folderPath = public_path("app/student-profile/{$year}/{$month}");
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);  
            }
            $file->move($folderPath, $filename);
            $image = "app/student-profile/{$year}/{$month}/" . $filename;
        }

        $student = Student::create([
            'name' => $validatedData['name'],
            'mobile' => $validatedData['mobile'],
            'email' => $validatedData['email'],
            'course' => $validatedData['course'],
            'blood_group' => $validatedData['blood_group'],
            'password' => Hash::make($req->password),
            'image' => $image,
            'email_verified_at' => now(),
            'state'    => 13,
            'college_id' => 0,
            'mode' => 5,
            'created_by' => $admin->id,
        ]);

        $points = 5;
        Referral::create([
            'user_type' => 2, 
            'referrer_id' => $admin->id,  
            'referred_id' => $student->id,
            'points' => $points,
            'type'   => 6,
        ]); 

        $admin->points += $points;
        $admin->save();

        StudentCreation::create([
            'employee_id' => $admin->id, 
            'student_id' => $student->id,
            'created_at' => now(),
        ]);

        $this->sendEmail($student);
        $this->sendWhatsappMessage($student);
        return back()->with('success', 'Student enrollment completed successfully. Login details have been sent to the student registered email address.');
    }

    private function sendEmail(Student $student)
    {
        // dd($student);
        try {
            $email = $student->email;
            $subject = 'Student Enrollment Confirmation ' .' | ' . now()->format('d-M-Y h:i A');
            try {
                Mail::send('mail-template.student.verification', ['data' => $student, 'email' => $email], function ($message) use ($subject, $email) {
                    $message->to($email)->subject($subject);
                });
    
                Log::channel('email')->info('Send Mail For Enroll Verification, Success to send email to ' . $email);
                } catch (\Exception $mailException) {
                    Log::channel('email')->error('Failed to send email to ' . $email . '. Error: ' . $mailException->getMessage());
            }
            Log::channel('email')->info('📧 Email queued to ' . $email);
        } catch (\Exception $mailException) {
            Log::channel('email')->error('Failed to send email to ' . $email . '. Error: ' . $mailException->getMessage());
        }
    }

    private function sendWhatsappMessage(Student $student)
    {
        $name = $student->name;
        $MobileNo = $student->mobile ?? '0000000000';
        $email = $student->email;

        $message = "👋 *Dear $name,*\n\n" .
                "🎉 *Congratulations!* Your sign-up is complete, and you are now ready for *Step 2: Document Upload & Verification*.\n\n" .
                "📋 *What You Need to Do Next:*\n" .
                "✔️ *Log In:* Go to our website, click on *“Student Login”*, and use your registered email ID and password.\n" .
                "✔️ *Upload Documents:* Navigate to the *“Upload Documents”* section in your Student Dashboard and upload the required files.\n" .
                "✔️ *Verification:* Our team will verify your documents and notify you via email once approved.\n\n" .
                "⏳ *Please complete this step promptly to avoid any delays in your enrollment.*\n\n" .
                "🧑‍💻 *Login Username:* {$email}\n" .
               "🚀 *Proceed now by logging into your dashboard:*\nClick to login: " . route('student.login') . "\n\n".
                "If you have any questions, feel free to contact us.\n\n" .
                "🙏 *Warm Regards,*\n" .
                "*GaamRaam NGO Team*";

        if (!str_starts_with($MobileNo, '+91')) {
            $MobileNo = '+91' . $MobileNo;
        }

        try {
            $apiKey = BussinessSetting::find(14)->value;
            $response = Http::get('http://api.textmebot.com/send.php', [
                'recipient' => $MobileNo,
                'apikey' => $apiKey,
                'text' => $message,
            ]);

            if ($response->successful()) {
                $body = strtolower($response->body());
                Log::channel('whatsapp')->error('Whatsapp send successfully: ' . $response->body());
                if (str_contains($body, 'error') || str_contains($body, 'failed')) {
                    Log::channel('whatsapp')->error('Whatsapp responded but failed: ' . $response->body());
                }
            } else {
                Log::channel('whatsapp')->error('Whatsapp API Error: ' . $response->status() . ' - ' . $response->body());
            }           

        } catch (Exception $e) {
            Log::channel('whatsapp')->error('WhatsApp API Exception', ['error' => $e->getMessage()]);
        }
    }

    public function bulkImport(){
        $admin = Auth::guard('admin')->user();
        $excels = ExcelLog::where('type', 2)
                ->when($admin->admin_role_id != 1, function ($query) use ($admin) {
                    $query->where('admin_id', $admin->id);
                })
                ->paginate(10);
        return view('admin.student.import.index', compact('excels','admin'));
    }

    public function bulkImportStore(Request $request){
        $login_admin = Auth::guard('admin')->user();
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
            $name                    = isset($row['A']) ? trim($row['A']) : null;
            $f_name                  = isset($row['B']) ? trim($row['B']) : null;
            $current_college_name    = isset($row['C']) ? trim($row['C']) : null;
            $address                 = isset($row['D']) ? trim($row['D']) : null;
            $mobile_no               = isset($row['E']) ? preg_replace('/\D/', '', trim($row['E'])) : null;     
            Log::channel('import-excel')->info('Student :- Cleaned Mobile No: ' . $mobile_no . ' for row ' . $index);
            if (!$mobile_no || !$name) {
                continue;
            }
            if (!preg_match('/^\d{10}$/', $mobile_no)) {
                $invalidMobileNos[] = $mobile_no;
                continue;
            }
            if (
                Student::where('mobile', $mobile_no)->exists() ||  in_array($mobile_no, $duplicateMobileNos) ||  in_array($mobile_no, $importedMobileNos)
            ) {
                $duplicateMobileNos[] = $mobile_no;
                Log::channel('import-excel')->info('Student :- Duplicate found: ' . $mobile_no);
                Log::channel('import-excel')->info('Student :- Duplicate Mobile No Array found: ' . implode(', ', $duplicateMobileNos));
                continue;
            }
            Sarpanch::create([
                'type'                     => 2,
                'name'                     => $name,
                'mobile_no'                => $mobile_no,
                'f_name'                   => $f_name,
                'current_college_name'     => $current_college_name,
                'address'                  => $address,
                'created_at'               => now(),
                'updated_at'               => now(),
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
                                'type'        => 2,
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

         if($request->file != null){            
            $file = $request->file;
            $filename = time(). '.' . $file->getClientOriginalExtension();
            $year = now()->year;
            $month = now()->format('M');
            $folderPath = public_path("app/import/student/{$year}/{$month}");
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);  
            }
            $file->move($folderPath, $filename);
            $excelFilePath = "app/import/student/{$year}/{$month}/" . $filename;
            Log::channel('import-excel')->info("Student :- Excel file uploaded by Admin ID: {$login_admin->id}, Path: {$excelFilePath}");
        }

        $pointsToAdd = 0; 
        if ($importedCount > 0) {
            $pointsToAdd = floor($importedCount / 10);
            if ($pointsToAdd > 0) {
                $oldPoints = $login_admin->points;
                $login_admin->increment('points', $pointsToAdd);
                $newPoints = $login_admin->fresh()->points;
                Log::channel('import-excel')->info("Student :- Referral log created for Admin ID {$login_admin->id}. Previous Points: {$oldPoints}, Added: {$pointsToAdd}, New Points: {$newPoints}.");
                Referral::create([
                    'user_type'    => 2,                          
                    'referrer_id'  => $login_admin->id,
                    'referred_id'  => 0,
                    'points'       => $pointsToAdd,
                    'type'         => 7,    
                ]);
            }
        }               
        ExcelLog::create([
            'admin_id' => $login_admin->id,
            'type'      =>2,
            'file_path' => $excelFilePath ?? null,
            'imported_count' => $importedCount,
            'points'        => $pointsToAdd,  
        ]);
        Log::channel('import-excel')->info("Student :- ExcelLog entry created for Admin ID {$login_admin->id}, Imported Count: {$importedCount}, Points: {$pointsToAdd}.");
        if (!empty($duplicateMobileNos)) {
            Log::channel('import-excel')->warning('Student :- Duplicate mobile numbers skipped: ' . implode(', ', array_unique($duplicateMobileNos)));
            Session::flash('warning', 'Duplicate mobile numbers skipped: ' . implode(', ', array_unique($duplicateMobileNos)));
        }
        if (!empty($invalidMobileNos)) {
            Log::channel('import-excel')->error('Student :- Invalid mobile numbers (not 10 digits) skipped: ' . implode(', ', array_unique($invalidMobileNos)));
            Session::flash('error', 'Invalid mobile numbers (not 10 digits) skipped: ' . implode(', ', array_unique($invalidMobileNos)));
        }
        Session::flash('success', "$importedCount Students entries imported successfully!");
        return redirect()->back();
    }



   

}