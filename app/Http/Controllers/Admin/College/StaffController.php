<?php

namespace App\Http\Controllers\Admin\College;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Str;
use DB;
use Mail;
use Hash;
use Carbon\Carbon;

use App\Models\Institute;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class StaffController extends Controller
{

    public function collegeStaffList(Request $req){
        $staffs = Institute::paginate(10);
        return view('admin.college.staff.list', compact('staffs'));

    }

    public function collegeStaffAdd(Request $req){
        // dd($req->all());
        $validatedData = $req->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|unique:institutes,email',
            'college_id' => 'required|numeric',
            'password' => 'required|string|min:8',
            'mobile_no'  => 'required|numeric|digits:10|unique:institutes,mobile_no',
        ], [
            'email.unique' => 'This Email Already Exists in the Database. Try Another Email.',
            'password.min' => 'Password Must Be At Least 8 Characters Long.',
            'mobile_no.unique' => 'This Mobile No Already Exists in the Database. Try Another Mobile No.',
        ]);
        $institute = Institute::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'mobile_no' => $validatedData['mobile_no'],
            'password' => Hash::make($req->password),
            'status' => 1,
            'college_id' => $req->college_id,
        ]);
        $subject = "Staff Registration Confirmation | " . \Carbon\Carbon::today()->format('d-M-Y') . " | " . \Carbon\Carbon::now()->format('h:i A');
        $email = $validatedData['email'];
            try {
                Mail::send('mail-template.college.staff.confirmation', ['data' => $validatedData, 'email' => $email], function ($message) use ($subject, $email) {
                    $message->to($email)->subject($subject);
                });
    
                Log::channel('email')->info('Send Mail For Enroll Verification, Success to send email to ' . $email);
                } catch (\Exception $mailException) {
                    Log::channel('email')->error('Failed to send email to ' . $email . '. Error: ' . $mailException->getMessage());
            }
        return back()->with('success', 'Staff enrollment completed successfully. Login details have been sent to the registered email address.');
    }

    public function collegeStaffStatus(Request $req){
        // dd($req->all());
        $req->validate([
            'staff_id' => 'required|numeric',  
            'status' => 'required|boolean',  
        ]);
        $institute = Institute::findOrFail($req->staff_id);
        $institute->status = $req->status;
        $institute->save();

        return response()->json([
            'success' => true,
            'message' => 'Statff member status updated successfully!',
        ]);   
    }


   
        

    

   

}