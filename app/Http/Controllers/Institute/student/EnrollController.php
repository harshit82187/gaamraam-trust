<?php

namespace App\Http\Controllers\Institute\student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Mail;
use Hash;

use App\Models\Institute;
use App\Models\Student;

use App\Exports\Institute\StudentDataDistrictWiseExport;
use Maatwebsite\Excel\Facades\Excel;


use Illuminate\Support\Facades\Log;
use App\Models\College;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class EnrollController extends Controller
{
    
    public function enroolStudent(Request $req){
        $institute = Auth::guard('institute')->user();
        // dd($institute);
        $query = Student::where('mode',2)->where('college_id', $institute->college_id);
        if($req->has('name') && $req->name != null){
            $query->where('name','like','%' .$req->name . '%');
        }
        $students = $query->orderBy('created_at', 'desc')->paginate(10);
        // dd($students);
        return view('institute.student.list', compact('students','institute'));
    }

    public function enroolStudentSave(Request $req){
        $institute = Auth::guard('institute')->user();
        $validatedData = $req->validate([
            'name' => 'required|string|max:250',
            'phone' => 'required|digits:10|unique:students,mobile',
            'email' => 'required|email|unique:students,email',
            'course' => 'required|string',
            'password' => 'required|string|min:8',
        ], [
            'email.unique' => 'This Email Already Exists in the Database. Try Another Email.',
            'phone.unique' => 'This Mobile Number Already Exists in the Database. Try Another Number.',
            'password.min' => 'Password Must Be At Least 8 Characters Long.',
        ]);
        $student = Student::create([
            'name' => $validatedData['name'],
            'mobile' => $validatedData['phone'],
            'email' => $validatedData['email'],
            'course' => $validatedData['course'],
            'password' => Hash::make($req->password),
            'email_verified_at' => now(),
            'college_id' => $institute->college_id,
            'mode' => 2,
            'created_by' => $institute->id,
        ]);
        $subject = "Enrollment Confirmation";
        $email = $validatedData['email'];
            try {
                Mail::send('mail-template.student.verification', ['data' => $validatedData, 'email' => $email], function ($message) use ($subject, $email) {
                    $message->to($email)->subject($subject);
                });
    
                Log::channel('email')->info('Send Mail For Enroll Verification, Success to send email to ' . $email);
                } catch (\Exception $mailException) {
                    Log::channel('email')->error('Failed to send email to ' . $email . '. Error: ' . $mailException->getMessage());
            }

            $Name = $req->input('name');
            $MobileNo = $req->input('phone');
            
            // WhatsApp message with newline characters
            $message = "Dear " . ($Name ?? 'Aspirant') . ",\n\n".
                       "✅ Your sign-up is complete! Now, move to the next step—Document Upload & Verification.\n\n" .
                       "📌 What’s Next?\n" .
                       "✔ Log In: Click on “Student Login” on our website and enter your email ID and password.\n" .
                       "✔ Upload Documents: Go to the “Upload Documents” section in your Student Dashboard and submit the required files.\n" .
                       "✔ Verification: Our team will review them, and you’ll receive an email once your documents are verified.\n\n" .
                       "⏳ Complete this step on time to avoid delays in your enrollment.\n\n" .
                       "🚀 Start now!\n\n" .
                       "Best regards,\nGaamRaam NGO Team";
            
            if (!str_starts_with($MobileNo, '+91')) {
                $MobileNo = '+91' . $MobileNo;
            }
            
            $apiKey = 'eGyZ9B45gSXn'; 
            $whatsappApiUrl = 'http://api.textmebot.com/send.php';
            
            $response = Http::get($whatsappApiUrl, [
                'recipient' => $MobileNo,
                'apikey' => $apiKey,
                'text' => $message
            ]);
            
            if ($response->successful()) {
                Log::channel('student')->info('Student Enrool Verification Step : WhatsApp message sent successfully.' .$MobileNo);
                Log::channel('whatsapp')->info('Student Enrool Verification Step : WhatsApp message sent successfully.' .$MobileNo);
            } else {
                Log::channel('student')->error('Student Enrool Verification Step : Failed to send WhatsApp message. Response: ' . $response->body());
                Log::channel('whatsapp')->error('Student Enrool Verification Step : Failed to send WhatsApp message. Response: ' . $response->body());

            }          
            return back()->with('success', 'Student enrollment completed successfully. Login details have been sent to the registered email address.');
    }
   
    public function studentDataDistrictWise(){
        return Excel::download(new StudentDataDistrictWiseExport, 'student-data-district-wise.xlsx');
    }


    public function disctrictStudent(){
        $instituteMember = Auth::guard('institute')->user();
        $college_detail = College::find($instituteMember->college_id);
        $city_id = $college_detail->city; 
        $students = Student::where('city', $city_id)->get();

      

        return view('institute.student.disctrict-student',compact('students'));
    }

    public function AllStudent(){

        $students = Student::where('status', '1')->get();

        return view('institute.student.all-student',compact('students'));
    }

}