<?php

namespace App\Http\Controllers\Member\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Mail;
use Hash;

use App\Models\Document;
use App\Models\Referral;
use App\Models\Student;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class StudentController extends Controller
{
  
    public function enroolStudent(Request $req){
        $member = Auth::user();
        // dd($institute);
        $query = Student::where('mode',4)->where('created_by',$member->id);
        if($req->has('name') && $req->name != null){
            $query->where('name','like','%' .$req->name . '%');
        }
        $students = $query->orderBy('created_at', 'desc')->paginate(10);
        // dd($students);
        return view('member.student.list', compact('students'));
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
        $member = Auth::user();
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
            'state'    => 13,
            'college_id' => 0,
            'mode' => 4,
            'created_by' => $member->id,
        ]);
        $points = 20;
        Referral::create([
            'referrer_id' => $member->id,  
            'referred_id' => $student->id,
            'points' => $points,
            'type'   => 2,
        ]);
        $referrer = Auth::user();
        $referrer->points += $points;
        $referrer->save();   

           
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

   

}