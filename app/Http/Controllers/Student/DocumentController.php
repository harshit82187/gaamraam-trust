<?php

namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Auth;
use Hash;
use Mail;

use App\Models\Document;



use App\Mail\Student\DocumentVerificationMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;

class DocumentController extends Controller
{
    public function document()
    {
        $student = Auth::guard('student')->user();
        $documents = Document::where('student_id',$student->id)->paginate(10);
        // dd(count($documents));
        // dd($student, $documents->total(), $documents->items()); 
        return view('student.document.index',compact('documents'));
    }

    public function documentUpload(Request $req){
        // dd($req->all());
        $student = Auth::guard('student')->user();
        $req->validate([
            'name' => 'required|in:1,2,3,4,5,6,7',
            'marksheet' => 'required|mimes:pdf|max:2048',
        ]);

        $marksheet_exists = Document::where('student_id',$student->id)->where('name',$req->name)->first();
        if($marksheet_exists != null){
            return back()->with('error', 'Marksheet Already Exists!');
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
            $this->sendWhatsAppNotification($student);
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
        return back()->with('success', 'Marksheet Uploaded Successfully!');
    }

    private function sendWhatsAppNotification($student)
    {
        \Log::channel('student')->info('Student Doucment Verification Step : Enter WhatsAppNotification Function...');
        $mobileNo = $student->mobile;
        if (!str_starts_with($mobileNo, '+91')) {
            $mobileNo = '+91' . $mobileNo;
        }

        $message = "Dear {$student->name},\n\n"
                . "Congratulations! Your document verification is complete. You are now eligible for the next step – the Aptitude Test & Institution Selection.\n\n"
                . "📌 Aptitude Test: This test will assess your problem-solving and analytical skills.\n"
                . "📌 Institution Selection: Top-ranked students will get the first opportunity to select their preferred institution.\n\n"
                . "📅 Test Date: [Insert Date]\n"
                . "⏳ Complete this step on time to secure your seat!\n\n"
                . "Stay tuned! You’ll receive an email with further details.\n\n"
                . "Best regards,\n"
                . "GaamRaam NGO Team\n\n"
                . "----------------------------------------------------\n"
                . "📞 For any queries, contact us at: 9053903100\n"
                . "🌐 Visit our website: <a href=\"{{ url('/') }}\">GaamRaam</a>\n";

        $apiKey = 'eGyZ9B45gSXn'; // Replace with actual API key
        $whatsappApiUrl = 'http://api.textmebot.com/send.php';

        $response = Http::get($whatsappApiUrl, [
            'recipient' => $mobileNo,
            'apikey' => $apiKey,
            'text' => $message
        ]);

        if ($response->successful()) {
            Log::channel('student')->info('Student Doucment Verification Step : WhatsApp message sent successfully.' .$mobileNo);
            Log::channel('whatsapp')->info('Student Doucment Verification Step : WhatsApp message sent successfully.' .$mobileNo);

        } else {
            Log::channel('student')->error('Student Doucment Verification Step : Failed to send WhatsApp message. Response: ' . $response->body());
            Log::channel('whatsapp')->error('Student Doucment Verification Step : Failed to send WhatsApp message. Response: ' . $response->body());

        }
    }


    public function approve(Request $request, $id)
    {
        $document = Document::findOrFail($id);
        $document->approved = $request->approved;
        $document->save();

        $message = $request->approved ? 'Document approved successfully!' : 'Document unapproved successfully!';
       
        // session()->flash('success', $message);

       
        return response()->json([
            'success' => true,
            // 'message' => $message
        ]);
    }

   

}