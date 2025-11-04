<?php

namespace App\Http\Controllers\Student\Test;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



use App\Models\TestSeries;
use App\Models\QuestionBank;
use App\Models\TestResult;


use Auth;
use Hash;
use Str;
use Mail;
use DB;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class TestSeriesController extends Controller
{
    public function list(Request $req){
        $testSeries = TestSeries::orderBy('created_at','desc')->paginate(10);
        return view('student.test-series.list',compact('testSeries'));
    }

    public function attemptSeriesTest($slug)
    {
        $student = Auth::guard('student')->user();    
        $testSeries = TestSeries::where('slug', $slug)->firstOrFail();
        // dd($student->id,$testSeries->id);
        $testResultExists = TestResult::where([
            'student_id' => $student->id,
            'test_series_id' => $testSeries->id
        ])->exists();    
        if ($testResultExists) {
            return back()->with('error', "You have already attempted the '{$testSeries->name}' series!");
        }    
        $questions = QuestionBank::where('test_series_id', $testSeries->id)->get();    
        return view('student.test-series.attempt', compact('testSeries', 'questions'));
    }
    

    public function saveAnswer(Request $request)
    {
        // dd($request->all());
        $student = Auth::guard('student')->user();    
        $validated = $request->validate([
            'question_id' => 'required|exists:question_banks,id',
            'answer' => 'required|string',
            'test_series_id' => 'required|exists:test_series,id',
        ]);    
        $question = QuestionBank::findOrFail($request->question_id);
        $status = ($question->correct == $request->answer) ? 1 : 0;    
        TestResult::create([
            'student_id' => Auth::guard('student')->user()->id,
            'question_id' => $validated['question_id'],
            'student_mark_option' => $validated['answer'],
            'test_series_id' => $validated['test_series_id'],
            'status' => $status,
        ]);
    
        $totalQuestions = QuestionBank::where('test_series_id',$request->test_series_id)->count();     
        $attemptedQuestions = TestResult::where('student_id', Auth::guard('student')->user()->id)->count();
    
        // If all questions are attempted, redirect to results page
        if ($attemptedQuestions >= $totalQuestions) {
            $this->sendWhatsAppNotification($student);
            return response()->json([
                'message' => 'Test completed successfully!',
                'redirect' => route('student.test-result', ['testSeriesId' => $question->test_series_id])
            ]);
        }    
        return response()->json(['message' => 'Answer saved successfully']);
    }

    private function sendWhatsAppNotification($student)
    {
        \Log::channel('student')->info('Student Doucment Verification Step : Enter WhatsAppNotification Function...');
        $mobileNo = $student->mobile;
        if (!str_starts_with($mobileNo, '+91')) {
            $mobileNo = '+91' . $mobileNo;
        }

        $message = "Dear {$student->name},\n\n"
                . "Congratulations! 🎉\n\n"
                . "You have successfully cleared the Aptitude Test & Institution Selection process. "
                . "Now, you're all set to begin your Physical Classes at your selected institution. 💼\n\n"
                
                . "Here are some important details you need to know:\n\n"

                . "🔑 **Important Details:**\n\n"
                . "✔ **Student I-Card:** You will receive your official Student I-Card, which is mandatory for attending classes.\n"
                . "✔ **Class Start Date:** April 30, 2025.\n\n"
                . "✔ **Class Location:** Your selected institution\n"
                . "✔ **Class Timings:**\n"
                . "   • **SSC:** 2:30 PM - 5:30 PM\n"
                . "   • **UPSC:** 2:30 PM - 5:30 PM\n\n"

                . "📚 **Class Guidelines:**\n\n"
                . "   📌 **Attendance** is mandatory\n"
                . "   📌 Strict **discipline** must be followed\n"
                . "   📌 Live classes by **expert faculty** from Mukherjee Nagar\n\n"

                . "⏳ Be prepared and complete all formalities on time to begin your journey!\n\n"

                . "Stay tuned! You'll receive an email with further details soon.\n\n"
                
                . "Best regards,\n"
                . "GaamRaam NGO Team\n\n"
                . "----------------------------------------------------\n"
                . "📞 For any queries, contact us at: 9053903100\n"
                . "🌐 Visit our website: <a href=\"{{ url('/') }}\">GaamRaam</a>\n";


        $apiKey = 'eGyZ9B45gSXn'; 
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

    public function testResult($testSeriesId){
        $studentId = Auth::guard('student')->id();
        $testSeries = TestSeries::findOrFail($testSeriesId);
        $totalQuestions = QuestionBank::where('test_series_id', $testSeriesId)->count();
        $totalCorrect = TestResult::where('student_id', $studentId)
        ->whereHas('question', function ($query) use ($testSeriesId) {
            $query->where('test_series_id', $testSeriesId);
        })
        ->where('status', 1)
        ->count();
        return view('student.test-series.result', compact('testSeries', 'totalQuestions', 'totalCorrect'));
    }

    public function attemptTestList(Request $req){
        // dd(121);
        $student = Auth::guard('student')->user();  
        $testSeriesIds  = TestResult::where('student_id',$student->id)->distinct('test_series_id')->pluck('test_series_id'); 
        $testSeries = TestSeries::whereIn('id', $testSeriesIds)->paginate(10);
        // dd($student,$testSeries,$testSeries);
        return view('student.test-series.attempt-list', compact('testSeries'));
    }

    public function downloadPDF($id)
    {
        $student = Auth::guard('student')->user();   
        $testSeries = TestSeries::find($id); 
        $testResults  = TestResult::where('student_id',$student->id)->where('test_series_id',$id)->get();
        $resultData = [];
        // dd($testResults);
        foreach ($testResults as $testResult) {
            $question = QuestionBank::find($testResult->question_id);
            $correctAnswers = explode(',', $question->correct);
            $options = json_decode($question->options, true); 
            $correctAnswerNames = [];
            foreach ($correctAnswers as $answer) {
                if (isset($options[$answer])) {
                    $correctAnswerNames[] = $options[$answer]; 
                }
            }
            $isCorrect = in_array($testResult->student_mark_option, $correctAnswers);
            $marks = $isCorrect ? 1 : 0;
            $resultData[] = [
                'question_name' => $question->name,
                'correct_answer' => implode(', ', $correctAnswerNames), 
                'student_choice' => $options[$testResult->student_mark_option], 
                'marks' => $marks,
                'is_correct' => $isCorrect,
            ];
        }
        $pdf = PDF::loadView('pdf.student.test-series.result', compact('resultData','student','testSeries'));
        return $pdf->download('test-result-' . $id . '.pdf');
    }
    


    

}
