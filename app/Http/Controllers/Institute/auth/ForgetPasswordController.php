<?php

namespace App\Http\Controllers\Institute\auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Auth;
use Hash;

use App\Models\Institute;
use App\Models\ForgetPassword;
use Mail; 
use Carbon\Carbon;


use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ForgetPasswordController extends Controller
{


    public function forgetPassword(Request $req)
    {     
            // dd($req->all());
              $req->validate([
                'email' => 'required|email',
              ]);              
              $institute = Institute::where('email',$req->email)->first();   
              if($institute != null){
                  $token = Str::random(64);
                  $subject = 'Password Forget Email For Institue Member | ' . \Carbon\Carbon::today()->format('d-M-Y') . ' | ' . \Carbon\Carbon::now()->format('h:i A');
                  $email = $req->email;
                  ForgetPassword::insert([
                      'email' => $email,
                      'token' => $token,
                      'type'  => 3,
                      'created_at' => now(),
                      'updated_at' => now(),
                  ]);
                  $data =[
                      'name' => $institute->name,
                      'email' => $email,
                      'token' => $token,
                      'type'  => 3,
                  ];              

                  try {
                      Mail::send('mail-template.member.forget-password-link', ['data' => $data], function($message) use ($subject, $email) {
                          $message->to($email);
                          $message->subject($subject);
                      });    
                      Log::channel('email')->info('Email sent successfully to ' . $email);    
                  } catch (\Exception $mailException) {
                      Log::channel('email')->info('Failed to send email to ' . $email . '. Error: ' . $mailException->getMessage());
                      return response()->json([
                          'status' => false,
                          'message' => 'Warning: ' . $mailException->getMessage(),
                      ], 500);
                  }
                  return response()->json([
                      'status' => "success",
                      'message' => 'Password reset link has been sent successfully to your registered email address!',
                  ]);
              }else{
                  return response()->json([
                      'status' => false,
                      'message' => 'This Mail Does Not Exist in The Database.',
                  ], 404);
              }             
             
       
    }

    public function showResetPasswordForm($token, $email){
      // dd($token,$email);
        $existingToken = ForgetPassword::where('email', $email)->where('type',3)->where('created_at', '>=', now()->subMinutes(20))->latest()->first();
        // dd($token, $email,$existingToken);
        if(!$existingToken){
          return redirect()->route('our-institutions')->with('error', 'Password Token Expired');
        }
        $type = 3;
        return view('student.auth.forget-password.update-form', ['token' => $token , 'email' => $email,'type' => 3]);
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
            'type'  => 3,
          ])->first();
        //   dd($updatePassword);

          if(!$updatePassword){
            return back()->with('error','Invalid Token');
          }

          Institute::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
          ]);
          ForgetPassword::where([
            'email' => $request->email,
            'type'  => 3,
            ])->delete();
          return redirect()->route('our-institutions')->with('success','Your Password Has Been Changed');
    }
   

}