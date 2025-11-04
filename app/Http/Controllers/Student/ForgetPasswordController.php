<?php

namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Auth;
use Hash;

use App\Models\Student;
use App\Models\ForgetPassword;
use Mail; 



use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ForgetPasswordController extends Controller
{

    public function forgetPasswordForm(){
        return view('student.auth.forget-password.view');
    }
 
    public function forgetPassword(Request $req)
    {     
      // dd($req->all());
      
        $req->validate([
          'email' => 'required|email',
        ]);              
        $student = Student::where('email',$req->email)->first();   
        if($student != null){
            $token = Str::random(64);
            $subject = "Password Forget Email";
            $email = $req->email;
            ForgetPassword::insert([
                'email' => $email,
                'token' => $token,
                'type'  => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $data =[
                'name' => $student->name,
                'email' => $email,
                'token' => $token,
                'type'  => 1,
            ];              

            try {
                Mail::send('mail-template.member.forget-password-link', ['data' => $data], function($message) use ($subject, $email) {
                    $message->to($email);
                    $message->subject($subject);
                });    
                Log::channel('email')->info('Email sent successfully to ' . $email);    
            } catch (\Exception $mailException) {
                Log::channel('email')->info('Failed to send email to ' . $email . '. Error: ' . $mailException->getMessage());
                return redirect()->back()->with('error', 'Warning :'. $mailException->getMessage());
            }
            return back()->with('success', 'Password reset link has been sent successfully to your registered email address!');
        }else{
            return back()->with('error','This Mail Does Not Exist in The Database.');
              }             
             
       
    }

    public function showResetPasswordForm($token, $email){
      // dd($token,$email);
        $existingToken = ForgetPassword::where('email', $email)->where('type',1)->where('created_at', '>=', now()->subMinutes(20))->latest()->first();
        // dd($token, $email,$existingToken);
        if(!$existingToken){
          return redirect('student/login')->with('error', 'Password Token Expired');
        }
        $type = 1;
        return view('student.auth.forget-password.update-form', ['token' => $token , 'email' => $email, ], compact('type'));
    }

    public function submitResetPasswordForm(Request $request){
        // dd($request->all());
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'cpassword' => 'required'
          ]);

          $updatePassword = ForgetPassword::where([
            'email' => $request->email,
            'token' => $request->token,
            'type'  => 1,
          ])->first();
        //   dd($updatePassword);

          if(!$updatePassword){
            return back()->with('error','Invalid Token');
          }

          Student::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
          ]);
          ForgetPassword::where([
            'email' => $request->email,
            'type'  => 1,
            ])->delete();
          return redirect()->route('student.login')->with('success','Your Password Has Been Changed');
    }
   

}