<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Models\Student;
use App\Models\State;
use App\Models\City;
use App\Models\Block;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Mail\Student\OtpMail;
use DB;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    // Send OTP
    public function sendOtp(Request $request)
    {
    
        $rules = [
            'email' => 'required|email'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }
        $studentExist = Student::where('email', $request->email)->first();
        if($studentExist){
            return response()->json(['success' => false, 'message' => 'Email already exists']);
        }

        $otp = rand(100000, 999999);
        DB::table('otps')->updateOrInsert(
            ['email' => $request->email],
            ['otp' => $otp, 'updated_at' => now(), 'created_at' => now()]
        );
        Mail::to($request->email)->queue(new OtpMail($otp, $request->email));
        Log::channel('email-verify')->info('Email sent successfully to: ' . json_encode($request->all()));
        return response()->json(['success' => true, 'message' => 'OTP Sent Successfully, Please Check Your Inbox.']);
    }

    public function verifyOtp(Request $request)
    {
        $rules = [
            'otp' => 'required|digits:6',
            'email' => 'required|email',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }
        $otpEntry = DB::table('otps')->where('email', $request->email)->first();       
        if ($otpEntry && $otpEntry->otp == $request->otp) {            
            Log::channel('email-verify')->info("OTP verified successfully for email: $request->email");
            DB::table('otps')->where('email', $request->email)->delete();
            return response()->json(['status' => true, 'message' => 'Email verified successfully']);
        }
        Log::channel('email-verify')->warning("Failed OTP verification attempt for email: $request->email with OTP: {$request->otp}");
        return response()->json(['status' => false, 'message' => 'Invalid OTP']);
    }

    public function getState(){
        $states = State::all();
        return response()->json([
            'status' => true,
            'message' => 'States fecth successfully',
            'total states' => count($states),
            'states' => $states,
        ],200);
    }

    public function getDistrict(){
        $districts = City::where('state_id',13)->get();
        if($districts->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No districts found!'
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'Districts fecth successfully',
            'total districts' => count($districts),
            'districts' => $districts,
        ],200);
    }

    public function getBlock($district_id){
        $blocks = Block::where('city_id',$district_id)->get();
        if($blocks->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No Blocks found!'
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'Blocks fecth successfully',
            'total blocks' => count($blocks),
            'blocks' => $blocks,
        ],200);
    }


}
