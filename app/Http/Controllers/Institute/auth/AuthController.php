<?php

namespace App\Http\Controllers\Institute\auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Hash;
use App\Models\Institute;
use App\Models\Student;
use App\Models\College;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        if (Auth::guard('institute')->attempt($request->only('email', 'password'))) {
            $institute = Auth::guard('institute')->user();

            // Check if account is inactive
            if ($institute->status == '0') {
                Auth::guard('institute')->logout();
                return response()->json([
                    'status' => 'error',
                    'message' => 'Your account is not active! Please contact admin.'
                ], 403);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Login Successfully!',
                'redirect_url' => route('institute.dashboard')
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Wrong Credentials!'
        ]);       
    }

    public function dashboard(){        
        $institute = Auth::guard('institute')->user();
        $enrolstudents = Student::where('mode',2)->where('college_id', $institute->college_id)->count();     
        $college_detail = College::find($institute->college_id);
        $city_id = $college_detail->city; 
        $disctrictStudent = Student::where('city', $city_id)->count();
        $allStudent = Student::where('status', '1')->count();
        return view('institute.dashboard', compact('institute','enrolstudents','disctrictStudent','allStudent'));
    }

    
    public function profile(Request $request)
    {
        if ($request->isMethod('get')) {
            $institute = Auth::guard('institute')->user();
            return view('institute.profile', compact('institute'));
        }

        $institute = Auth::guard('institute')->user();

        if ($request->form_type === 'profile_update') {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:institutes,email,' . $institute->id,
                'mobile_no' => 'required|digits_between:10,20|unique:institutes,mobile_no,' . $institute->id,
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $institute->name = $request->name;
            $institute->email = $request->email;
            $institute->mobile_no = $request->mobile_no;
            if ($request->hasFile('profile_image')) {
                $file = $request->file('profile_image');
                $filename = time(). '.' . $file->getClientOriginalExtension();
                $year = now()->year;
                $month = now()->format('M');
                $folderPath = public_path("app/college-member-profile/{$year}/{$month}");
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0777, true);
                }
                $file->move($folderPath, $filename);
                $institute->profile_image = "app/college-member-profile/{$year}/{$month}/" . $filename;
            }
            $institute->save();
            return back()->with('success', 'Profile Updated Successfully!');

        } elseif ($request->form_type === 'password_update') {
            $validator = Validator::make($request->all(), [
                'password' => 'required|confirmed|min:6',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $institute->password = Hash::make($request->password);
            $institute->save();
            return back()->with('success', 'Password Updated Successfully!');
        }
        return back()->with('error', 'Invalid form submission.');
    }



    public function logout(){
        Auth::guard('institute')->logout();
        // session()->flush();
        // dd('Logged out');
        return redirect()->route('our-institutions')->with('error','Logout Successfully!');
    }

   

}