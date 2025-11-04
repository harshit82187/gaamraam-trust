<?php 

namespace App\Http\Controllers\API\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Student;
use App\Models\Document;
use App\Models\Notification;
use App\Models\Meeting;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Mail\Student\DocumentVerificationMail;
use Illuminate\Support\Facades\File;

class StudentAuthController extends Controller
{
    // Student Registration
    public function register(Request $request)
    {
        // dd($request->all());
        $rules = [
            'name' => 'required|string|max:250',
            'mobile' => 'required|digits:10|unique:students,mobile',
            'email' => 'required|email|unique:students,email',
            'password' => 'required|string|min:8',
            'course'  => 'required|in:UPSC,SSC',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $student = Student::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'mobile'    => $request->mobile,
            'course'    => $request->course,
            'password' => Hash::make($request->password),
            'api_token'=> Str::random(60),
            'state'    => 13,
            'college_id' => 0,
            'mode' => 1,
            'created_by' => 0,
            'email_verified_at' => now(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Student registered successfully',
            'token' => $student->api_token,
            'student' => $student,
        ],200);
    }

    // Student Login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $student = Student::where('email', $request->email)->first();

        if (!$student || !Hash::check($request->password, $student->password)) {
            return response()->json(['status' => false, 'message' => 'Invalid credentials'], 401);
        }

        // Generate new token
        if($student->api_token == null){
            $student->api_token  = Str::random(60);
            $student->save();
        }

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'token' => $student->api_token,
            'email'   => $student->email,
            'student' => $student,
        ]);
    }

    public function profile(Request $request)
    {
        //  dd($request->all());
        $token =  $request->bearerToken();
        $student = Student::where('api_token', $token)->first();
        \Log::info("Incoming token: " . $token);
        // dd($student,$token);
        $assetUrl = env('ASSET_URL', '');
        $student->image = $student->image 
            ? ($assetUrl ? rtrim($assetUrl, '/') . '/' . ltrim($student->image, '/') : $student->image) 
            : 'Image Not Available';
        if (!$student) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized or invalid token'
            ], 401);
        }
        return response()->json([
            'status' => true,
            'message' => 'Student profile fetched successfully',
            'email'   => $student->email,
            'student' => $student
        ]);
    }

    public function profileUpdate(Request $request)
    {
        $token =  $request->bearerToken();
        $student = Student::where('api_token', $token)->first();
        if (app()->environment('local')) {
            \Log::info("Incoming token: " . $token);
        }
        if (!$student) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized or invalid token'
            ], 401);
        }
        $rules = [
            'name' => 'required|string|max:250',
            'mobile' => 'required|digits:10|unique:students,mobile,' .$student->id,
            'email' => 'required|email|unique:students,email,' .$student->id,
            'dob' => 'required|date',
            'course' => 'required|in:UPSC,SSC',
            'gender' => 'required|in:male,female',
            'state' => 'required|numeric',
            'city' => 'required|numeric',
            'block' => 'required|numeric',
            'address' => 'required|string|max:250',
            'image'   => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = [
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'dob' => $request->dob,
            'course' => $request->course,
            'gender' => $request->gender,
            'state' => $request->state,
            'city' => $request->city,
            'block' => $request->block,
            'address' => $request->address,
        ];

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($student->image && File::exists(public_path($student->image))) {
                File::delete(public_path($student->image));
            }
            $file = $request->file('image');
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
        $assetUrl = env('ASSET_URL', '');
        $student->image = $student->image 
            ? ($assetUrl ? rtrim($assetUrl, '/') . '/' . ltrim($student->image, '/') : $student->image) 
            : 'Image Not Available';
        return response()->json([
            'status' => true,
            'message' => 'Student profile update successfully',
            'email'   => $student->email,
            'student' => $student
        ]);
    }


    // Student Logout (optional)
    public function logout(Request $request)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json([
                'status' => false,
                'message' => 'Token not provided'
            ], 401);
        }
        $student = Student::where('api_token', $token)->first();
        if ($student) {
            $student->api_token = null;
            $student->save();
            return response()->json(['status' => true, 'message' => 'Logged out successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Invalid token'], 401);
    }

    public function document(Request $request){
        try {
            $token =  $request->bearerToken();
            if(!$token) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token not provided'
                ], 401);
            }
            $student = Student::where('api_token', $token)->first();
            if(!$student) {
                return response()->json([
                    'status' => false,
                    'message' => 'Student not found!'
                ], 401);
            }
            $documents = Document::where('student_id',$student->id)->get()->map(function ($document) {
                            $assetUrl = env('ASSET_URL', '');
                            $document->name = match ($document->name) {
                                '1' => '10th Marksheet',
                                '2' => '12th Marksheet',
                                '3' => 'Graduation 1st Year Marksheet',
                                '4' => 'Graduation 2nd Year Marksheet',
                                '5' => 'Graduation 3rd Year Marksheet',
                                '6' => 'Character Certificate',
                                '7' => 'Domicile Certificate',
                                default => 'Unknown',
                            };
                            $document->marksheet = $assetUrl ? rtrim($assetUrl, '/') . '/' . ltrim($document->marksheet, '/') : $document->marksheet;
                            return $document;
                        });
            if ($documents->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No documents found.'
                ],404);
            }
            return response()->json([
                'success' => true,
                'message' => 'Documents retrieved successfully.',
                'total'   => count($documents),
                'documents' => $documents
            ],200);
        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }

    }

    public function documentStore(Request $req){
        try {
                // dd($req->all());
                $token =  $req->bearerToken();
                if(!$token) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Token not provided'
                    ], 401);
                }
                $student = Student::where('api_token', $token)->first();
                if(!$student) {
                return response()->json([
                        'status' => false,
                        'message' => 'Student not found!'
                    ], 401);
                }
                $rules = [
                    'name' => 'required|in:1,2,3,4,5,6,7',
                    'marksheet' => 'required|file|mimetypes:application/pdf,mimes:pdf|max:2048',
                ];
                $validator = Validator::make($req->all(), $rules);
                if ($validator->fails()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validation errors',
                        'errors' => $validator->errors()
                    ], 422);
                }

                $marksheet_exists = Document::where('student_id',$student->id)->where('name',$req->name)->first();
                if($marksheet_exists != null){
                    return response()->json([
                        'status' => false,
                        'message' => 'Marksheet Already Exists!'
                    ], 401);
                }
                $document = new Document();
                $document->name = $req->name;
                $document->student_id = $student->id;
                $document->status = $req->status ?? '1';

                if($req->marksheet != null){
                    $file = $req->marksheet;
                    $filename = time(). '.' . $file->getClientOriginalExtension();
                    $year = now()->year;
                    $month = now()->format('M');
                    $folderPath = public_path("app/student-marksheets/{$year}/{$month}");
                    if (!file_exists($folderPath)) {
                        mkdir($folderPath, 0777, true);  
                    }
                    $file->move($folderPath, $filename);
                    $document->marksheet = "app/student-marksheets/{$year}/{$month}/" . $filename;
                }
                $document->save();
                $documentCount = Document::where('student_id', $student->id)->count();
                if ($documentCount == 3) {
                    // $this->sendWhatsAppNotification($student);
                    try {
                        $studentName = $student->name;
                        $studentNumber = $student->mobile;
                        \Log::channel('student')->info('Student Name in Mail: ' . $studentName . ' WhatsApp No : ' . $studentNumber );
                        Mail::to($student->email)->queue(new DocumentVerificationMail($student, $studentName));    
                        Log::channel('student')->info(' Student Doucment Verification Step : Send Mail For Enroll Verification, Success to send email to :' . $student->email . 'Name : ' . $studentName);
                        } catch (\Exception $mailException) {
                            Log::channel('student')->error('Student Doucment Verification Step : Failed to send email to ' . $student->email . '. Error: ' . $mailException->getMessage());
                        }
                }
                return response()->json([
                    'success' => true,
                    'message' => 'Documents upload successfully!',
                ],200);
        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function notification(Request $request){
        try {
            $token =  $request->bearerToken();
            if(!$token) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token not provided'
                ], 401);
            }
            $student = Student::where('api_token', $token)->first();
            if(!$student) {
                return response()->json([
                    'status' => false,
                    'message' => 'Student not found!'
                ], 401);
            }
            $notifications = Notification::where('type','1')->whereJsonContains('user_id', (string) $student->id)->orWhereJsonContains('user_id', "0")->get()->map(function ($notification) {
                            $assetUrl = env('ASSET_URL', '');                           
                           if ($notification->image) {
                                $notification->image = $assetUrl ? rtrim($assetUrl, '/') . '/' . ltrim($notification->image, '/') : $notification->image;
                            } else {
                                $notification->image = 'Image Not Available';
                            }
                            return $notification;
                        });
            if ($notifications->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No notifications found.'
                ],404);
            }
            return response()->json([
                'success' => true,
                'message' => 'Notifications retrieved successfully.',
                'total'   => count($notifications),
                'notifications' => $notifications
            ],200);
        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function passwordUpdate(Request $request){
        try {
            $token =  $request->bearerToken();
            if(!$token) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token not provided'
                ], 401);
            }
            $student = Student::where('api_token', $token)->first();
            if(!$student) {
                return response()->json([
                    'status' => false,
                    'message' => 'Student not found!'
                ], 401);
            }
            $rules = [
               'password' => 'required|string|min:6' 
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }
            $student->password = Hash::make($request->password);
            $student->save();            
            return response()->json([
                'success' => true,
                'message' => 'Password update successfully!',
            ],200);
        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function card(Request $request){
        try {
            $token =  $request->bearerToken();
            if(!$token) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token not provided'
                ], 401);
            }
            $student = Student::where('api_token', $token)->first();
            if(!$student) {
                return response()->json([
                    'status' => false,
                    'message' => 'Student not found!'
                ], 401);
            }
            if($student->student_id == null && $student->qr_code_path){
                 return response()->json([
                    'status' => false,
                    'message' => 'Your profile not complete, First you complete your profile then you able to download your i-card!'
                ], 401);
            }
            $assetUrl = env('ASSET_URL', '');     
            $idCard =  $assetUrl ? rtrim($assetUrl, '/') . '/' . ltrim($student->id_card_path, '/') : $student->id_card_path;           
            return response()->json([
                'success' => true,
                'message' => 'ID-Card fetch successfully.',
                'idCard'   => $idCard,
                'profile' => $student
            ],200);
        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getMeetingInfo(Request $req){
        $teacher = $req->get('auth_user');
        $meetings = Meeting::orderBy('created_at','desc')->get();
        if ($meetings->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No Meetings found!'
            ],404);
        }
         return response()->json([
            'status' => true,
            'message' => 'Meetings fetch successfully!',
            'count'   =>count($meetings),
            'meetings' => $meetings
        ]);
    }
}
