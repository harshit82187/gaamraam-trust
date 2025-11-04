<?php

namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use App\Models\Block;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Auth;
use Hash;

use App\Models\User;
use App\Models\Document;
use App\Models\Student;
use App\Models\Notification;
use App\Models\Meeting;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;


class AuthController extends Controller
{
    public function login(Request $req){
        try{
            if($req->isMethod('get')){
                // dd(121);
                return view('student.auth.login');
            }else{
    
                $req->validate([
                    'email' => 'required|email',
                    'password' => 'required'
                ]);    
                $email = $req->email;
                $password = $req->password;    
                $student = Student::where('email',$email)->first();
                if($student){
                    if(Auth::guard('student')->attempt([ 'email' => $email, 'password' => $password ])){
                        if($student->status == 0){
                            Auth::guard('student')->logout();
                            return back()->with('error','Your account is not active! Please contact to admin.');
                        }
                        // elseif($student->state == null || $student->city == null || $student->address == null ){
                        //     Auth::guard('student')->login($student);
                        //     return redirect()->route('student.profile')->with('success','Login Successfully, Please Complete Your Profile!');
                        // }
                        return redirect()->route('student.dashboard')->with('success','Login Successfully!');
                    }else{
                        return back()->with('error','Wrong Credentials!');
                    }    
                }else{
                    return back()->with('error','Record Not Found!');
                } 
            }
        }catch (ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        }catch(\Exception $e){
            return back()->with('error', 'Warning : ' .$e->getMessage());
        }        
    }

    public function dashboard(){
        // dd(Auth::guard('student')->user());
        $student = Auth::guard('student')->user();
        $documents = Document::where('student_id',$student->id)->count();
        $notifications = Notification::whereJsonContains('user_id', (string) $student->id)->orWhereJsonContains('user_id', "0")->count();
        return view('student.dashboard',compact('notifications','documents'));
    }

    public function notification(){
        $student = Auth::guard('student')->user();
        // dd($student);
        $notifications = Notification::whereJsonContains('user_id', (string) $student->id)->orWhereJsonContains('user_id', "0")->orderBy('created_at', 'desc')->paginate(10);
        return view('student.notification.index',compact('notifications'));
    }

    public function profile(){
        $student = Auth::guard('student')->user();
        return view('student.profile.index',compact('student'));

    } 

    public function profileUpdate(Request $req){
        // dd($req->all());
        $req->validate([
            'name' => 'required|string|max:255',
            'course' => 'required|string|max:255',
        ]);
        $student = Auth::guard('student')->user();
        $data = [
            'name' => $req->name,
            'course' => $req->course,
            'blood_group' => $req->blood_group,
            'state' => $req->state,
            'city' => $req->city,
            'address' => $req->address,
            'gender' => $req->gender,
            'block'=>$req->block,
           
        ];
        if (is_null($student->student_id)) {
            $data['student_id'] = "GMT". now()->format('Ym') . rand(100000, 999999);
        }

        if($student->email != $req->email){
            $req->validate([
                'email' => 'required|email|unique:students,email',
            ]);
            $data['email'] = $req->email;
        }

        if($student->dob != $req->dob){
            $req->validate([
                'dob' => 'required|date|before:today',
            ]);
            $data['dob'] = $req->dob;
        }

        if($student->mobile != $req->mobile){
            $req->validate([
                'mobile' => 'required|numeric|unique:students,mobile',
            ]);
            $data['mobile'] = $req->mobile;
        }

        if($req->has('password') && $req->password != null){
            $data['password'] = Hash::make($req->password);
        }

        if($req->image != null){
            $file = $req->image;
            $filename = time(). '.' . $file->getClientOriginalExtension();
            $year = now()->year;
            $month = now()->format('M');
            $folderPath = public_path("app/student-profile/{$year}/{$month}");
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);  
            }
            $file->move($folderPath, $filename);
            $data['image'] = "app/student-profile/{$year}/{$month}/" . $filename;
        }
        $student->update($data);
        $student_id = $student->student_id;
        $qrCodePath = $this->generateQRCode($student_id);
        $student->update([
            'qr_code_path' => $qrCodePath
        ]);
        $documentExist = Document::where('student_id',$student->id)->first();
        if(!$documentExist){
            return redirect(route('student.document-list'))->with('success', 'Profile updated successfully! Now you can upload your documents.');
        }
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    private function generateQRCode($student_id)
    {
        $year = now()->year;
        $month = now()->format('M');
        $qrCodeDirectory = public_path("app/student-profile/qr-codes/{$year}/{$month}");
        Log::channel('email')->info("Generating QR code for student", ['invoiceNumber' => $student_id]);
        if (!File::exists($qrCodeDirectory)) {
            File::makeDirectory($qrCodeDirectory, 0777, true);
        }
        try {
            $qrCode = new QrCode(route('fetch-qr-code', ['student_id' => $student_id]));
            $writer = new PngWriter();
            $qrCodeContent = $writer->write($qrCode)->getString();
            $qrCodeFilePath = "{$qrCodeDirectory}/{$student_id}-qr.jpg";
            file_put_contents($qrCodeFilePath, $qrCodeContent);
            Log::channel('email')->info("QR code generated successfully", ['file_path' => $qrCodeFilePath]);
            return "app/student-profile/qr-codes/{$year}/{$month}/{$student_id}-qr.jpg";
        } catch (\Exception $e) {
            Log::channel('email')->error("QR code generation failed", ['error' => $e->getMessage()]);
            return null;
        }
    }


    public function changePasswordForm(){
        return view('student.change-password.index');
    }


    public function changePassword(Request $req){
      

        $student = Auth::guard('student')->user();
       
        if($req->has('password') && $req->password != null){
            $data['password'] = Hash::make($req->password);
        }


        $student->update($data);

        return redirect()->back()->with('success', 'Password updated successfully!');
    }

    public function logout(){
        Auth::guard('student')->logout();
        session()->flush();
        // dd('Logged out');
        return redirect()->route('student.login')->with('error','Logout Successfully!');
    }

    public function autoLogout(Request $request)
    {
        Auth::guard('student')->logout();
        session()->flush();
        return response()->json(['status' => 'logged_out']);
    }

    



    public function getBlocksByCity(Request $request)
    {
        $cityId = $request->query('city_id');
        $blocks = Block::where('city_id', $cityId)->get(['id', 'name']);
        return response()->json($blocks);
    }

    public function studentValidateEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'email:rfc,dns',
                'unique:students,email',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],[
                'email.required' => 'Email is required.',
                'email.email' => 'Please enter a valid email address.',
                'email.regex' => 'Email format is invalid.',
                'email.unique' => 'This email is already registered. Please try a different one.',
            ]
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first('email')
            ]);
        }
    }


    
   

}