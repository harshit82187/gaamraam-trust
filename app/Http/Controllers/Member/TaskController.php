<?php

namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use App\Models\User;
use App\Models\Task;
use App\Models\TaskUpdate;


use Hash;
use Str;
use Mail;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\File;


class TaskController extends Controller
{
    public function taskList(){
        $member = Auth::user();
        $tasks = Task::where('assign_to',$member->id)->orderBy('created_at','desc')->paginate(10);
        // dd($member,$tasks);
        return view('member.task.index',compact('member','tasks'));
    }

    public function rejectTaskList(){
       
        $member = Auth::user();
        $tasks = Task::where('assign_to',$member->id)->where('status',0)->paginate(10);
        // dd($member,$tasks);
        return view('member.task.reject-task-list',compact('member','tasks'));
    }

    public function taskUpdate($id){
        // dd($id);
        $member = Auth::user();
        $task = Task::where('assign_to',$member->id)->where('id',$id)->first();
        if(!$task){
            return back()->with('error','Task Not Found!');
        }
        $taskUpdates = TaskUpdate::where('member_id',$member->id)->where('task_id',$task->id)->orderBy('created_at','desc')->paginate(10);
        return view('member.task.update',compact('task','taskUpdates'));
    }

    public function taskUpdates(Request $req){
        // dd($req->all());
        $req->validate([
            'updates' => 'required|array',
            'task_id' => 'required|numeric',
            'image' => 'array',
        ]);
        $member = Auth::user();
        foreach ($req->updates as $index => $updates) {
            $taskUpdate = new TaskUpdate();
            $taskUpdate->task_id = $req->task_id;
            $taskUpdate->member_id = $member->id;
            $taskUpdate->updates = $updates;

            if (isset($req->image[$index]) && $req->image[$index] instanceof \Illuminate\Http\UploadedFile) {
                $file = $req->image[$index];
                $filename = time() . '_' . $index . '.' . $file->getClientOriginalExtension();
                $year = now()->year;
                $month = now()->format('M');
                $folderPath = public_path("app/task/{$year}/{$month}");        
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0777, true);
                }        
                $file->move($folderPath, $filename);
                $taskUpdate->image = "app/task/{$year}/{$month}/" . $filename;
            }
            $taskUpdate->save();           
        }   
        return back()->with('success','Task Update Successfully');
    }

    public function taskReject(Request $req){
        // dd($req->all());
        $req->validate([
            'id' => 'required|numeric',
            'note' => 'required|string',
        ]);
        $task = Task::find($req->id);
        if($task == null){
            return back()->with('error','Task Not Found!');
        }
        $task->update([
            'status' => 0,
            'note' => $req->note,
        ]);
        return back()->with('error','Task Reject Successfully!');
    }

    public function taskAccept($id){
        // dd($id);
        $task = Task::find($id);
        if($task == null){
            return back()->with('error','Task Not Found!');
        }
        $task->update([
            'status' => 1,
        ]);
        return back()->with('success','Task Accept Successfully!');
    }

    public function achievement(){
        $member = Auth::user();
        $tasks = Task::where('status',3)->where('complete',100)->where('assign_to',$member->id)->paginate(10);
        return view('member.achievement.index', compact('tasks','member'));    
    }

    



}
