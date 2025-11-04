<?php

namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Student;
use App\Models\BussinessSetting;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class WhatAppNumberVerificationController extends Controller
{
    

    public function sendWhatsappOtp(Request $request)
    {
       
        $request->validate([
            'mobile' => 'required'
        ]);	
    
        $mobile = $request->mobile;
        $student = Student::where('mobile', $mobile)->first();
        if ($student != null) {
            Log::channel('whatsapp-verify')->error("Failed to send OTP to $mobile. Reason: This mobile number already exists in the database.");
            return response()->json(['status' => false, 'message' => 'This mobile number is already registered. Please try a different number.']);
        }
    
        $otp = rand(100000, 999999);
        $message = 
            "🔐 *WhatsApp Number Verification*\n\n" .
            "Your one-time password (OTP) for secure verification is:\n" .
            "👉 *$otp*\n\n" .
            "Please enter this OTP to complete your verification process.\n\n" .
            "⏳ *Note:* This OTP is valid for a limited time only.\n" .
            "❗ Do not share this OTP with anyone for your security.\n\n" .
            "🔒 Stay safe,\n" .
            "*GaamRaam NGO Team*";

    
        if (!str_starts_with($mobile, '+91')) {
            $phone = '+91' . $mobile;
        }
    
     
        // Store in database
        DB::table('otps')->updateOrInsert(
            ['whatsapp_no' => $mobile],
            ['otp' => $otp,'type' => 2, 'updated_at' => now(), 'created_at' => now()]
        );
    
        $apiKey = BussinessSetting::find(14)->value;
        $whatsappApiUrl = 'http://api.textmebot.com/send.php';
    
        $response = Http::get($whatsappApiUrl, [
            'recipient' => $phone,
            'apikey' => $apiKey,
            'text' => $message
        ]);
    
        if ($response->successful()) {
            Log::channel('whatsapp-verify')->info("OTP sent successfully to $phone. OTP: $otp");
            return response()->json(['status' => true, 'message' => 'OTP sent successfully']);
        } else {
            Log::channel('whatsapp-verify')->error("Failed to send OTP to $phone. Response: " . $response->body());
            return response()->json(['status' => false, 'message' => 'Failed to send OTP']);
        }
    }

    public function verifyWhatsappOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required',
            'otp' => 'required'
        ]);
        $phone = $request->mobile;
        $otpEntry = DB::table('otps')->where('whatsapp_no', $phone)->where('type',2)->first();
        if ($otpEntry && $otpEntry->otp == $request->otp) {
            DB::table('otps')->where('whatsapp_no', $phone)->delete();
            Log::channel('whatsapp-verify')->info("OTP verified and record deleted for $phone.");
            return response()->json([
                'status' => true,
                'message' => 'OTP verified successfully'
            ]);
        }

        Log::channel('whatsapp-verify')->warning("OTP verification failed for $phone. Entered OTP: {$request->otp}, Expected OTP: " . ($otpEntry->otp ?? 'none'));
        return response()->json(['status' => false, 'message' => 'Invalid OTP']);
    }

    
}
