<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Auth;

use App\Models\Course;
use App\Models\City;
use App\Models\Student;
use App\Models\College;
use App\Models\Payment;
use App\Models\BussinessSetting;
use App\Models\Contact;
use App\Models\User;
use App\Models\Subscriber;
use App\Models\LogDetails;
use App\Models\Teacher;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use DB;
use Mail;
use Hash;
use Carbon\Carbon;
use App\Traits\MyLoggerTrait;

class HomeController extends Controller
{
    use MyLoggerTrait;

    public function index(){
        $this->logMessage('This is a custom log message.');
        $courses = Course::where('status', '1')->get();
        $colleges = College::where('status','1')->get();
        $teachers = Teacher::get();
        $students = Student::count();
        $total_amount = number_format(Payment::sum('amount'));
        $latest_payment = Payment::latest()->first();
        $members = User::where('status', '1')->orderBy('points', 'desc')->get();
        $citys = City::where('state_id',13)->get();
    
        // dd($total_amount);
        return view('front.index', compact('courses','colleges','total_amount','latest_payment','members','students','citys','teachers'));
    }

 
    public function contact(){
        return view('front.pages.contact');
    }

    public function submitContactForm(Request $request){    
        // dd($request->all()); 
        $secretKey = "6LcdiiIrAAAAAPt3btL1JKybe8cNEuDtExyobWPG"; 
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secretKey,
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);
        $responseData = $response->json();
        if (!$responseData['success']) {
            session()->flash('error', 'reCAPTCHA verification failed. Please try again.');
            return back()->withErrors(['captcha' => 'reCAPTCHA verification failed. Please try again.']);
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'phone' => 'nullable|digits_between:10,15',
            'message' => 'required|string',
        ]);

    
        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'mobile' => $request->phone,
            'message' => $request->message,
        ]);

    
        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
    public function about(){
        return view('front.pages.about');
    }

    public function donation_detail(){
        $donations = Payment::orderBy('id','desc')->paginate(10);
        return view('front.pages.donation-detail', compact('donations'));
    }
    public function member(){
        return view('front.pages.member');
    }
  
    public function studentRegister(Request $req){
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
      
            $validatedData = $req->validate([
                'name' => 'required|string|max:250',
                'phone' => 'required|digits:10|unique:students,mobile',
                'email' => 'required|email|unique:students,email',
                'course' => 'required|string',
                'password' => 'required|string|min:8',
            ], [
                'email.unique' => 'This Email Already Exists in the Database. Try Another Email.',
                'phone.unique' => 'This Mobile Number Already Exists in the Database. Try Another Number.',
                'password.min' => 'Password Must Be At Least 8 Characters Long.',
            ]);
            $student = Student::create([
                'name' => $validatedData['name'],
                'mobile' => $validatedData['phone'],
                'email' => $validatedData['email'],
                'course' => $validatedData['course'],
                'password' => Hash::make($req->password),
                'state'    => 13,
                'college_id' => 0,
                'mode' => 1,
                'created_by' => 0,
                'student_id'=> "GMT". now()->format('Ym') . rand(100000, 999999),
                'email_verified_at' => now(),
            ]);

            $data = [
                'user_id' => $student->id,
                'ip' => $req->ip(),
                'time' => Carbon::now(),
                'type' => 'student_registration',
            ];
            LogDetails::create($data);
            $subject = "Enrollment Confirmation";
            $email = $validatedData['email'];
                try {
                    Mail::send('mail-template.student.verification', ['data' => $validatedData, 'email' => $email], function ($message) use ($subject, $email) {
                        $message->to($email)->subject($subject);
                    });
        
                    Log::channel('email')->info('Send Mail For Enroll Verification, Success to send email to ' . $email);
                    } catch (\Exception $mailException) {
                        Log::channel('email')->error('Failed to send email to ' . $email . '. Error: ' . $mailException->getMessage());
                }

                $Name = $req->input('name');
                $MobileNo = $req->input('phone');
                
                // WhatsApp message with newline characters
                $message = "Dear " . ($Name ?? 'Aspirant') . ",\n\n".
                           "✅ Your sign-up is complete! Now, move to the next step—Document Upload & Verification.\n\n" .
                           "📌 What’s Next?\n" .
                           "✔ Log In: Click on “Student Login” on our website and enter your email ID and password.\n" .
                           "✔ Upload Documents: Go to the “Upload Documents” section in your Student Dashboard and submit the required files.\n" .
                           "✔ Verification: Our team will review them, and you’ll receive an email once your documents are verified.\n\n" .
                           "⏳ Complete this step on time to avoid delays in your enrollment.\n\n" .
                           "🚀 Start now!\n\n" .
                           "Best regards,\nGaamRaam NGO Team";
                
                if (!str_starts_with($MobileNo, '+91')) {
                    $MobileNo = '+91' . $MobileNo;
                }
                
                $apiKey = 'eGyZ9B45gSXn'; 
                $whatsappApiUrl = 'http://api.textmebot.com/send.php';
                
                $response = Http::get($whatsappApiUrl, [
                    'recipient' => $MobileNo,
                    'apikey' => $apiKey,
                    'text' => $message
                ]);
                
                if ($response->successful()) {
                    Log::channel('student')->info('Student Enrool Verification Step : WhatsApp message sent successfully.' .$MobileNo);
                    Log::channel('whatsapp')->info('Student Enrool Verification Step : WhatsApp message sent successfully.' .$MobileNo);
                } else {
                    Log::channel('student')->error('Student Enrool Verification Step : Failed to send WhatsApp message. Response: ' . $response->body());
                    Log::channel('whatsapp')->error('Student Enrool Verification Step : Failed to send WhatsApp message. Response: ' . $response->body());

                }
                
            
            return back()->with('success','Your enrollment has been submitted successfully. Please check your email!');

        
       
    }

    
    
    
    public function fetchQRCOde($student_id){
       $student = Student::where('student_id',$student_id)->first();
       $count = 1;
       return view('student.auth.download-id-card',compact('student','count'));
    }

    public function getCity($id){
        $states = City::where('state_id', $id)->get(['id', 'name']);
        return response()->json($states);
    }



    public function ourTeacher(){
        $teachers = Teacher::get();
        return view('front.pages.our-teacher',compact('teachers'));
    }

public function teacherInfo($id)
{
    try {
        $teacherId = decrypt($id);
    } catch (\Exception $e) {
        return redirect()->route('index')->with('error', 'Invalid or tampered URL.');
    }
    $teacher = Teacher::find($teacherId);

    if ($teacher) {
        $teachers = Teacher::get();
        return view('front.pages.teacher-info', compact('teacher','teachers'));
    }
    return redirect()->route('index')->with('error', 'Teacher not found.');
}

    public function blog(){
        return view('front.pages.blog');
    }

    public function studentReview(){
        return view('front.pages.student-review');
    }

    public function faq(){
        return view('front.pages.faq');
    }

    public function ourCollege(){
        $colleges = College::where('status','1')->get();
        return view('front.pages.our-college', compact('colleges'));
    }

    public function privacyPolicy(){
        $privacy_policy = BussinessSetting::find(2);
        return view('front.pages.privacy-policy',compact('privacy_policy'));
    }

    public function termCondition(){
        $term_condition = BussinessSetting::find(1);
        return view('front.pages.term-condition', compact('term_condition'));
    }

    public function stepForEnroll(){
        return view('front.pages.step-for-enroll');
    }

    public function becomeMember(){
        $members = User::where('status','1')->get();
        // dd($members);
        return view('front.pages.become-a-member', compact('members'));
    }

    public function donateNow(){
         $total_amount = number_format(Payment::sum('amount'));
        return view('front.pages.donate-now', compact('total_amount'));
    }

    public function donatdonateAmountDetailseNow(){
        // dd(121);
        $details = Payment::orderBy('created_at','desc')->paginate(10);
        return view('front.pages.donate-amount-details', compact('details'));
    }

    public function subscriber(Request $req){
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
        $validatedData = $req->validate([
            'email' => [
                'required',
                'email',
                'unique:subscribers,email',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z.-]+\.[a-zA-Z]{2,}$/'
            ],
        ], [
            'email.unique' => 'This Email Already Exists in the Database. Try Another Email.',
            'email.regex' => 'Please enter a valid email address.',
        ]);
        $subscriber = Subscriber::create([
            'email' => $validatedData['email'],
        ]);
        return back()->with('success','You have been successfully subscribed to our newsletter!');
    }

    public function fetchMemberByCity($city_id){
        $members = User::where('city', $city_id)
                    ->where('status', '1')
                    ->orderBy('points', 'desc')
                    ->get();
        // dd($city_id,$members);
        $html = view('front.components.district-members', compact('members'))->render();
        return response()->json(['html' => $html]);
    }

    public function trust(){
        return view('front.pages.trust');
    }


   

}