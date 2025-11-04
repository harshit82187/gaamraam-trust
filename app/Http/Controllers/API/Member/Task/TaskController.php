<?php

namespace App\Http\Controllers\API\Member\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Task;
use App\Models\TaskUpdate;

use Hash;
use Str;
use Mail;
use DB;
use Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Razorpay\Api\Api;

class TaskController extends Controller
{
    protected $assetUrl;

    public function __construct(){
        $this->assetUrl = env('ASSET_URL', '');
    }

    public function tasks(Request $request){
        try{
            $user = $request->get('auth_user');
            $tasks = Task::orderBy('created_at','desc')->where('assign_to',$user->id)->get()->map(function ($task) {
                        $task->assign_by = $task->adminDetail ? $task->adminDetail->name : 'N/A';
                        $status = match($task->status) {
                            0 => 'Rejected',
                            1 => 'Accepted',
                            2 => 'Pending',
                            3 => 'Completed',
                            default => 'N/A'
                        };
                        $task->status = $status;
                        unset($task->adminDetail);  
                        return $task;
                        });
            if ($tasks->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tasks not found!'
                ],404);
            }            
            return response()->json([
                'status' => true,
                'message' => 'Member tasks fetched successfully!',
                'member_name' => $user->name,
                'count'   => count($tasks),
                'tasks'   => $tasks,
            ]);
        }catch (\Throwable  $e) {
                return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
      
    }

    public function taskStatusChange(Request $request){
        try {
            $user = $request->get('auth_user');
            $taskId = $request->input('task_id');
            $status = $request->input('status');
            if (!in_array($status, [0, 1])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid status value. Only 0 or 1 is allowed!'
                ], 422);
            }
            $note = $request->input('note');
            if ($status == 0 && empty($note)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Note is required when status is rejected!'
                ], 422);
            }

            $task = Task::where('id', $taskId)->where('assign_to', $user->id)->first();
            if (!$task) {
                return response()->json([
                    'success' => false,
                    'message' => 'Task not found!'
                ], 404);
            }
            $task->status = $status;
            if ($status == 0) {
                $task->note = $note; 
            }
            $task->save();
            return response()->json([
                'status' => true,
                'message' => 'Task status updated successfully!',
                'task' => $task
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function taskInfo(Request $request){
        try {
            $user = $request->get('auth_user');
            $taskId = $request->input('task_id');         
            if ($taskId == 0 && empty($taskId)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Task Id is required!'
                ], 422);
            }
            $task = Task::with(['taskDetails' => function ($query) {$query->orderBy('id', 'desc'); }])->where('id', $taskId)->where('assign_to', $user->id)->first();
            if (!$task) {
                return response()->json([
                    'success' => false,
                    'message' => 'Task not found!'
                ], 404);
            }     
            foreach ($task->taskDetails as $detail) {
                $detail->image = $detail->image ? ($this->assetUrl ? rtrim($this->assetUrl, '/') . '/' . ltrim($detail->image, '/') : $detail->image) : 'Image Not Available';
            }      
            return response()->json([
                'status' => true,
                'message' => 'Member task fetch successfully!',
                'task' => $task
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function taskInfoUpdate(Request $request){
        try {
            $user = $request->get('auth_user');
            $taskId = $request->input('task_id');
            $updates = $request->input('updates'); // Will be an array if updates[] is used
            $images = $request->file('image');    // Optional images[] input

            if (empty($taskId) || empty($updates)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Task ID and updates are required!'
                ], 422);
            }

            $task = Task::where('id', $taskId)->where('assign_to', $user->id)->first();
            if (!$task) {
                return response()->json([
                    'success' => false,
                    'message' => 'Task not found!'
                ], 404);
            }
            $savedUpdates = [];
            foreach ($updates as $index => $updateText) {
                $taskUpdate = new TaskUpdate();
                $taskUpdate->task_id = $taskId;
                $taskUpdate->member_id = $user->id;
                $taskUpdate->updates = $updateText;
                if ($images && isset($images[$index])) {
                    $image = $images[$index];
                    $year = now()->year;
                    $month = now()->format('M');
                    $folderPath = public_path("app/task/{$year}/{$month}");
                    if (!file_exists($folderPath)) {
                        mkdir($folderPath, 0777, true);
                    }
                    $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                    $image->move($folderPath, $filename);
                    $taskUpdate->image = "app/task/{$year}/{$month}/" . $filename;
                } else {
                    $taskUpdate->image = null;
                }
                $taskUpdate->save();
                $savedUpdates[] = $taskUpdate;
            }
            return response()->json([
                'status' => true,
                'message' => 'Task updates saved successfully!',
                'task_name' => $task->task,
                'task_updates' => $savedUpdates
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

       


}
