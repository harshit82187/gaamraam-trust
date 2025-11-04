<?php

namespace App\Http\Controllers\Admin\Member;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use App\Models\User;
use App\Models\Task;
use App\Models\TaskUpdate;
use App\Models\BussinessSetting;

use App\Mail\Member\SendTaskMail;
use App\Mail\Member\TaskCompleteMarkMail;

use Hash;
use Mail;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;

class TaskController extends Controller
{
    public function taskList(){
        $members = User::where('status','1')->get();
        $tasks = Task::with('member')->where('assign_by',Auth::guard('admin')->user()->id)->orderBy('created_at','desc')->paginate(10);
        return view('admin.member.task.index',compact('members','tasks'));
    }

    public function taskAdd(Request $req){
        // dd($req->all());
        $req->validate([
            'member_id' => 'required|array',
            'task' => 'required',
        ]);
        $admin = Auth::guard('admin')->user();
       

        foreach ($req->member_id as $member_id) {
            $email = User::where('id', $member_id)->value('email');
            $name = User::where('id', $member_id)->value('name');
            
            $task = new Task();
            $task->assign_to = $member_id; 
            $task->task = $req->task;
            $task->assign_by = $admin->id;
            $task->status = 2;
            $task->save(); 
    
            $data = [
                'task' => $req->task,
                'name' => $name,
                'adminName' => $admin->name,
            ];
    
            try {
                $subject = 'A New Task is assigned to you ' . $req->task . ' | ' . \Carbon\Carbon::today()->format('d-M-Y') . ' | ' . \Carbon\Carbon::now()->format('h:i A');
                Mail::to($email)->queue(new SendTaskMail($data, $subject));
                Log::channel('member')->info('Task Mail :: Success to send email to ' . $email);
            } catch (\Exception $mailException) {
                Log::channel('member')->error('Task Mail :: Failed to send email to ' . $email . '. Error: ' . $mailException->getMessage());
            }
        }

        return back()->with('success','Task Added Successfully');
    }

    public function checkReport(Request $request)
    {
        // dd($request->all());
        $taskId = $request->task_id;
        $memberId = $request->member_id;
        $task = Task::find($taskId);
        $taskUpdates = TaskUpdate::where('task_id',$taskId)->where('member_id',$memberId)->paginate(10);
        $member = User::find($memberId);

        if (!$task || !$member) {
            return redirect()->back()->with('error', 'Invalid Task or Member.');
        }

        return view('admin.member.task.report.view', compact('task', 'member','taskUpdates'));
    }

    public function taskCompleteMark($task_id, $member_id){
        // dd($task_id,$member_id);
        $task = Task::findOrFail($task_id);
        $email = User::where('id', $member_id)->value('email');
        $adminEmail = BussinessSetting::where('type','email')->value('value');        
        try {
            $year = now()->year;
            $month = now()->format('M');
            $today = Carbon::now()->format('d-M-Y'); 
            $randomNumber = now()->format('Ym') . rand(100000, 999999);
            $fileName = "invoice_{$randomNumber}.pdf";
            $directoryPath = public_path("app/task/complete-mark/{$year}/{$month}");
            Log::channel('razorpay')->info("Generating task complete PDF", ['randomNumber' => $randomNumber]);
            if (!File::exists($directoryPath)) {
                File::makeDirectory($directoryPath, 0777, true);
            }
            $filePath = "{$directoryPath}/{$fileName}";
            $pdf = PDF::loadView('pdf.member.employee-of-the-month', compact('task'));
            $pdf->save($filePath);
            $task->update([
                'attachment' => "app/task/complete-mark/{$year}/{$month}/invoice_{$randomNumber}.pdf",
                'complete' => 100,
                 'complete_mark_date' => Carbon::now()->format('d-m-Y'),
                'status' => 3,
               
            ]);
            Log::channel('razorpay')->info("Task PDF generated successfully", ['file_path' => $filePath]);
        }catch (\Exception $e) {
            Log::channel('razorpay')->error("Task PDF generation failed", ['error' => $e->getMessage()]);
            return null;
        }
        try {
            $subject = '👉 Congratulations ! Your Task (' . $task->task . ') | has been completed on | ' . \Carbon\Carbon::today()->format('d-M-Y') . ' | ' . \Carbon\Carbon::now()->format('h:i A');
           Mail::to($email)
            ->cc($adminEmail)
            ->send((new TaskCompleteMarkMail($task, $subject))->attach($filePath));
            Log::channel('member')->info('Task Complete Mark Mail :: Success to send email to ' . $email);
        } catch (\Exception $mailException) {
            Log::channel('member')->error('Task Mail :: Failed to send email to ' . $email . '. Error: ' . $mailException->getMessage());
        }
         return back()->with('success','Task complete mark successfully!');

    }



}
