<?php

namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Student;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Mail\Student\OtpMail;
use DB;

class EmailVerificationController extends Controller
{
    // Send OTP
    public function sendOtp(Request $request)
    {
        // dd($request->all());
        $request->validate(['email' => 'required|email']);
        $studentExist = Student::where('email', $request->email)->first();
        if($studentExist){
            return response()->json(['success' => false, 'message' => 'This Email already exists! please try another email.']);
        }

        $otp = rand(100000, 999999);
        DB::table('otps')->updateOrInsert(
            ['email' => $request->email],
            ['otp' => $otp, 'type' => 2, 'updated_at' => now(), 'created_at' => now()]
        );
        Mail::to($request->email)->queue(new OtpMail($otp, $request->email));
        Log::channel('email-verify')->info('Email sent successfully to: ' . json_encode($request->all()));
        return response()->json(['success' => true, 'message' => 'OTP Sent Successfully']);
    }

    public function verifyOtp(Request $request)
    {
        // dd($request->all());
        $request->validate(['otp' => 'required|digits:6']);
        $otpEntry = DB::table('otps')->where('email', $request->email)->where('type', 2)->first();       
        if ($otpEntry && $otpEntry->otp == $request->otp) {            
            Log::channel('email-verify')->info("OTP verified successfully for email: $request->email");
            DB::table('otps')->where('email', $request->email)->delete();
            return response()->json(['status' => true, 'message' => 'Email verified successfully']);
        }
        Log::channel('email-verify')->warning("Failed OTP verification attempt for email: $request->email with OTP: {$request->otp}");
        return response()->json(['status' => false, 'message' => 'Invalid OTP']);
    }
}
