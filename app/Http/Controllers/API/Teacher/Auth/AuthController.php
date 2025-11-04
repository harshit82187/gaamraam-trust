<?php

namespace App\Http\Controllers\API\Teacher\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Teacher;

use Hash;
use Str;
use Mail;
use DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class AuthController extends Controller
{

    protected $assetUrl;

    public function __construct(){
        $this->assetUrl = env('ASSET_URL', '');
    }

    public function login(Request $request){
        $rules = [
            'email'    => 'required|email',
            'password' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }
        $teacher = Teacher::where('email', $request->email)->first();
        if (!$teacher || !Hash::check($request->password, $teacher->password)) {
            return response()->json(['status' => false, 'message' => 'Invalid credentials'], 401);
        }       
        if ($teacher->status == 0) {
            return response()->json([
                'status' => false,
                'message' => 'Your login is disabled, Please connect with admin!'
            ], 403);
        }
        if($teacher->api_token == null){
            $teacher->api_token  = Str::random(250);
            $teacher->save();
        }
        $teacher->save();  
        return response()->json([
            'status' => true,
            'message' => 'Teacher Login successfully!',
            'token' => $teacher->api_token,
            'teacher' => $teacher,
        ]);
    }

    public function profile(Request $request){
        try{
            $teacher = $request->get('auth_user');
            $teacher->image = $teacher->image ? ($this->assetUrl ? rtrim($this->assetUrl, '/') . '/' . ltrim($teacher->image, '/') : $teacher->image) : 'Image Not Available';
            if (!$teacher) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized or invalid token!'
                ], 401);
            }
            return response()->json([
                'status' => true,
                'message' => 'Teacher profile fetched successfully!',
                'email'   => $teacher->email,
                'teacher' => $teacher
            ]);
        }catch (\Throwable  $e) {
                return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
      
    }
    
}
