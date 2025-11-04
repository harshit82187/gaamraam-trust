<?php

namespace App\Http\Controllers\API\Member\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use App\Models\User;
use App\Models\Payment;
use App\Models\Block;
use App\Models\BussinessSetting;
use App\Models\Referral;
use App\Models\Task;
use App\Models\TaskUpdate;
use App\Models\Subscription;

use App\Mail\MemberVerification;
use App\Mail\SendDonationInvoiceMail;


use Hash;
use Str;
use Mail;
use DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;
use Razorpay\Api\Api;

class MemberAuthController extends Controller
{
    protected $assetUrl;

    public function __construct(){
        $this->assetUrl = env('ASSET_URL', '');
    }

    public function login(Request $request){
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['status' => false, 'message' => 'Invalid credentials'], 401);
        }
        if ($user->deleted_at !== null) {
            return response()->json([
                'status' => false,
                'message' => 'You are no longer a member of this application.'
            ], 403);
        }
        if ($user->status == 0) {
            return response()->json([
                'status' => false,
                'message' => 'Your login is disabled, Please connect with admin!'
            ], 403);
        }
        if($user->api_token == null){
            $user->api_token  = Str::random(250);
            $user->save();
        }
        $user->save();  
        return response()->json([
            'status' => true,
            'message' => 'Member Login successfully!',
            'token' => $user->api_token,
            'user' => $user,
        ]);
    }

    public function profile(Request $request){
        try{
            $user = $request->get('auth_user');
            $user->profile_image = $user->profile_image ? ($this->assetUrl ? rtrim($this->assetUrl, '/') . '/' . ltrim($user->profile_image, '/') : $user->profile_image) : 'Image Not Available';
            $user->id_card_pdf_path = $user->id_card_pdf_path ? ($this->assetUrl ? rtrim($this->assetUrl, '/') . '/' . ltrim($user->id_card_pdf_path, '/') : $user->id_card_pdf_path) : 'ID Card Not Available';
            $user->qr_code_path = $user->qr_code_path ? ($this->assetUrl ? rtrim($this->assetUrl, '/') . '/' . ltrim($user->qr_code_path, '/') : $user->qr_code_path) : 'QR Code Not Available';
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized or invalid token!'
                ], 401);
            }
            return response()->json([
                'status' => true,
                'message' => 'Member profile fetched successfully!',
                'email'   => $user->email,
                'user' => $user
            ]);
        }catch (\Throwable  $e) {
                return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
      
    }

    public function passwordUpdate(Request $request){
        try{
            $user = $request->get('auth_user');
            $data = $request->all(); 
            $validator = Validator::make($data, [
                'password' => 'required|string|max:255',
                'cpassword' => 'required|string|max:255',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()], 422);
            }
            $password = $data['password'];
            $cpassword = $data['cpassword'];
            if($password !== $cpassword){
                return response()->json(['status' => false, 'message' => 'Password and confirm password do not match'], 422);
            }
            $user->password = Hash::make($password);          
            $user->save();
            return response()->json([
                'status' => true,
                'message' => 'Member password updated successfully!',
            ]);
        }catch (\Throwable  $e) {
                return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request){    
        try{
            $user = $request->get('auth_user');
            $user->api_token = null;
            $user->save();
            return response()->json([
                'status' => true,
                'message' => 'Logout successfully!'
            ]);

        }catch (\Throwable  $e) {
                return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }    
    }




 
   


   


   


   



}
