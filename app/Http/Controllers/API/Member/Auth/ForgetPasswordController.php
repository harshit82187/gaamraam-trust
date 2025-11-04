<?php

namespace App\Http\Controllers\Member\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Models\User;
use App\Models\ForgetPassword;
use Mail; 
use Hash;
use Auth;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ForgetPasswordController extends Controller
{
    public function forgetPassword(Request $req)
    {     
            // dd($req->all());
            $secretKey = "6LcdiiIrAAAAAPt3btL1JKybe8cNEuDtExyobWPG"; 
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secretKey,
                'response' => $req->input('g-recaptcha-response'),
                'remoteip' => $req->ip(),
            ]);
            $responseData = $response->json();
            if (!$responseData['success']) {
                    session()->flash('error', 'reCAPTCHA verification failed. Please try again.');
                    return back()->withErrors(['captcha' => 'reCAPTCHA verification failed. Please try again.']);
            }
              $req->validate([
                'email' => 'required|email',
              ]);              
              $user = User::where('email',$req->email)->first();   
              if($user != null){
                  $token = Str::random(64);
                  $subject = "Password Forget Email For NGO Member | " . \Carbon\Carbon::today()->format('d-M-Y') . " | 🕒 " . \Carbon\Carbon::now()->format('h:i A');
                  $email = $req->email;
                  ForgetPassword::insert([
                      'email' => $email,
                      'token' => $token,
                      'type'  => 2,
                      'created_at' => now(),
                      'updated_at' => now(),
                  ]);
                  $data =[
                      'name' => $user->name,
                      'email' => $email,
                      'token' => $token,
                      'type'   => 2,
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
                  return back()->with('success','Password Reset Link Send Successfully, Please Check Your Email');

              }else{
                  return back()->with('error','This Mail Does Not Exist in The Database.');
              }             
             
       
    }

    public function showResetPasswordForm($token, $email){
      // dd($token,$email);
        $existingToken = ForgetPassword::where('email', $email)->where('type',2)->where('created_at', '>=', now()->subMinutes(20))->latest()->first();
        // dd($existingToken);
        if(!$existingToken){
          return redirect()->route('member-register')->with('error', 'Password Token Expired');
        }
        $type = 2;
        return view('member.auth.forget-password-update-form', ['token' => $token , 'email' => $email], compact('type'));
    }

    public function submitResetPasswordForm(Request $request){
        // dd($request->all());
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'cpassword' => 'required'
          ]);

          $updatePassword = ForgetPassword::where([
            'token' => $request->token,
            'type'   => 2,
          ])->first();
          // dd($updatePassword);

          if(!$updatePassword){
            return back()->with('error','Invalid Token');
          }

          User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
          ]);
          ForgetPassword::where([
            'email' => $request->email,
            'type'  => 1,
            ])->delete();
          return redirect()->route('member-register')->with('success','Your Password Has Been Changed');
    }
}