<?php 

namespace App\Http\Controllers\API\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Student;
use App\Models\Ticket;
use App\Models\BussinessSetting;
use App\Models\TicketReply;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Mail\Student\SupportTicketNotification;
use Illuminate\Support\Facades\File;
use Mail;
use Log;

class SupportTicketController extends Controller
{
    public function ticket(Request $request){
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
        $assetUrl = env('ASSET_URL', '');
        $tickets = Ticket::where('type', 1)->where('user_id', $student->id)->orderBy('id', 'desc')->get()
                    ->map(function ($ticket) use ($assetUrl) {
                        return [
                            'id'          => $ticket->id,
                            'ticket_id'   => $ticket->ticket_id,
                            'type'        => $ticket->type,
                            'user_id'     => $ticket->user_id,
                            'subject'     => $ticket->subject,
                            'priority'    => match ((int) $ticket->priority) {
                                1 => 'Low',
                                2 => 'Medium',
                                3 => 'High',
                                4 => 'Urgent',
                                default => 'Unknown',
                            },
                            'description' => $ticket->description,
                            'attachments' => collect(json_decode($ticket->attachments ?? '[]'))
                                ->map(fn ($path) => $assetUrl . ltrim($path, '/'))
                                ->toArray(),
                            'rating'      => $ticket->rating,
                            'feedback'    => $ticket->feedback,
                            'status'      => match ((int) $ticket->status) {
                                1 => 'Open',
                                2 => 'Closed',
                                default => 'Unknown',
                            },
                            'admin_id'    => $ticket->admin_id,
                            'created_at'  => $ticket->created_at,
                            'updated_at'  => $ticket->updated_at,
                        ];
                    });
        return response()->json([
            'status' => true,
            'message' => 'Student ticket fetch successfully',
            'count'   => count($tickets),
            'tickets' => $tickets
        ]);
    }

    public function ticketStore(Request $request){
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
            'subject' => 'required|string|max:250',
            'priority' => 'required|in:1,2,3,4', 
            'description' => 'required|string',
            'attachments.*' => 'nullable|mimes:jpeg,jpg,png,pdf,webp|max:4096', 
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }
        $ticketNumber = now()->format('Ym') . rand(100000, 999999);
        $ticket = new Ticket();
        $ticket->type = 1;
        $ticket->ticket_id = $ticketNumber;
        $ticket->user_id = $student->id;
        $ticket->subject = $request->subject;
        $ticket->priority = $request->priority;
        $ticket->description = $request->description;
        $ticket->status = 1;
        $ticket->save();
        if ($request->hasFile('attachments')) {
            $uploadedFiles = $request->file('attachments');
            $images = [];
            $year = now()->year;
            $month = now()->format('M');    
            foreach ($uploadedFiles as $file) {
                $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
                $folderPath = public_path("app/support-attachments/{$year}/{$month}");    
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0777, true);
                }    
                $file->move($folderPath, $filename);
                $images[] = "app/support-attachments/{$year}/{$month}/" . $filename;
            }    
            $ticket->attachments = json_encode($images);
            $ticket->save(); 
        }
        $userSubject = "📩 New Support Ticket Notification | #$ticketNumber | " . \Carbon\Carbon::today()->format('d-M-Y') . " | " . \Carbon\Carbon::now()->format('h:i A');
        $adminSubject = "🔔 New Support Ticket Received (Admin) | #$ticketNumber | " . \Carbon\Carbon::today()->format('d-M-Y') . " | " . \Carbon\Carbon::now()->format('h:i A');
        $email = $student->email;
        $adminEmail = BussinessSetting::where('type','email')->value('value');
        try {
            Mail::to($email)->queue(new SupportTicketNotification($ticket, $userSubject, false));  
            Mail::to($adminEmail)->queue(new SupportTicketNotification($ticket, $adminSubject, true));    
            Log::channel('email')->info('Email sent successfully to ' . $email . ' and Admin: ' . $adminEmail);
        } catch (\Throwable $mailException) {
            return response()->json([
                'status' => false,
                'message' => 'Mail sending failed',
                'error' => $mailException->getMessage()
            ], 500);
            Log::channel('email')->error('Failed to send email to ' . $email . '. Error: ' . $mailException->getMessage());
        }
        return response()->json([
            'status' => true,
            'message' => 'Student ticket submit successfully',
            'email'   => $student->email,
            'ticket' => $ticket
        ]);
    }

    public function ticketInfo(Request $request){
        // dd($request->all());
        $token =  $request->bearerToken();
        $student = Student::where('api_token', $token)->first();
         \Log::info("Incoming token: " . $token);
       
        if (!$student) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized or invalid token'
            ], 401);
        }
        $rules = [
            'ticket_id' => 'required|string'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }
        try{
            $ticket = Ticket::where('type', 1)->where('user_id', $student->id)->where('ticket_id', $request->ticket_id)->first();
            if (!$ticket) {
                return response()->json([
                    'status' => false,
                    'message' => 'Ticket Not Found!'
                ], 401);
            }
            $ticket->priority = match ($ticket->priority) {
                1 => 'Low',
                2 => 'Medium',
                3 => 'High',
                4 => 'Urgent',
                default => 'Unknown',
            };
            $ticket->status = match ($ticket->status) {
                1 => 'Open',
                2 => 'Closed',               
                default => 'Unknown',
            };
            $ticket->created_at = $ticket->created_at->format('Y-m-d H:i:s');
            $ticket->updated_at = $ticket->updated_at->format('Y-m-d H:i:s');
            $assetUrl = env('ASSET_URL', '');
            $attachments = json_decode($ticket->attachments, true); // decode as array
            $ticket->attachments = array_map(function($path) use ($assetUrl) {
                return $assetUrl . $path;
            }, $attachments);
            return response()->json([
                'status' => true,
                'message' => 'Ticket fetched successfully',
                'email'   => $student->email,
                'created_at' => $ticket->created_at,
                'ticket' => $ticket
            ]);

        }catch (Exception $e) {
                return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
       

    }

    public function ticketChat(Request $request){
        // dd($request->all());
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
            'ticket_id' => 'required|string'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }
        try{
            $ticket = Ticket::where('type', 1)->where('user_id', $student->id)->where('ticket_id', $request->ticket_id)->first();
            if (!$ticket) {
                return response()->json([
                    'status' => false,
                    'message' => 'Ticket Not Found!'
                ], 401);
            }
            $chats = TicketReply::where('ticket_id', $ticket->id)->with('adminDetail')->get()->map(function ($chat) {
                        $assetUrl = env('ASSET_URL', '');                           
                        if ($chat->attachment) {
                            $chat->attachment = $assetUrl
                                ? rtrim($assetUrl, '/') . '/' . ltrim($chat->attachment, '/')
                                : $chat->attachment;
                        } else {
                            $chat->attachment = 'Attachment not found';
                        }
                        $chat->reply_by = $chat->type == 1 && $chat->adminDetail
                                ? $chat->adminDetail->name
                                : 'Student';
                        if ($chat->type == 1 && $chat->adminDetail && $chat->adminDetail->image) {
                            $chat->admin_logo = $assetUrl
                                ? rtrim($assetUrl, '/') . '/' . ltrim($chat->adminDetail->image, '/')
                                : $chat->adminDetail->image;
                        } else {
                            $chat->admin_logo = null;
                        }
                        $chat->makeHidden(['admin_detail']);
                        return $chat;
                    });      
            
            return response()->json([
                'status' => true,
                'message' => 'chat fetched successfully',
                'ticket_id' => $ticket->ticket_id,
                'email'   => $student->email,
                'count'   => count($chats),
               'chats' => $chats->map(function ($chat) {
                            return collect($chat)->except('admin_detail');
                        })->values()
            ]);
        }catch (Exception $e) {
                return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
       

    }

    public function ticketChatStore(Request $request){
        // dd($request->all());
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
            'ticket_id' => 'required|string',
            'reply' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }
        try{
            $ticket = Ticket::where('type', 1)->where('user_id', $student->id)->where('ticket_id', $request->ticket_id)->first();
            if (!$ticket) {
                return response()->json([
                    'status' => false,
                    'message' => 'Ticket Not Found!'
                ], 401);
            }
            if (!$ticket || $ticket->status != 1) {
                return response()->json([
                    'status' => false,
                    'message' => 'Ticket not found or is closed!'
                ], 401);
            }
            $reply = new TicketReply();
            $reply->ticket_id = $ticket->id;
            $reply->reply = $request->reply;
            $reply->user_id = $student->id;
            $reply->type = 2;

            if($request->attachment != null){
                $file = $request->attachment;
                $filename = time(). '.' . $file->getClientOriginalExtension();
                $year = now()->year;
                $month = now()->format('M');
                $folderPath = public_path("app/support-attachments/reply/{$year}/{$month}");
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0777, true);  
                }
                $file->move($folderPath, $filename);
                $reply->attachment = "app/support-attachments/reply/{$year}/{$month}/" . $filename;
            }
            $reply->save();     
            $assetUrl = env('ASSET_URL', '');
            $reply->attachment = $reply->attachment
                    ? ($assetUrl ? rtrim($assetUrl, '/') . '/' . ltrim($reply->attachment, '/') : $reply->attachment)
                    : 'Attachment not found';                     
            return response()->json([
                'status' => true,
                'message' => 'Reply sent successfully',
                'email'   => $student->email,
                'reply' => $reply
            ]);
        }catch (\Throwable  $e) {
                return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
       

    }

    public function storeFeddback(Request $request){
        // dd($request->all());        
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
            'rating' => 'required|string',
            'feedback' => 'required|string',
            'ticket_id' => 'required|string',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }        
        try{
            $ticket = Ticket::where('type',1)->where('user_id', $student->id)->where('ticket_id', $request->ticket_id)->first();
            if (!$ticket) {
                return response()->json([
                    'status' => false,
                    'message' => 'Ticket Not Found!'
                ], 401);
            }
            if (!$ticket || $ticket->status != 1) {
                return response()->json([
                    'status' => false,
                    'message' => 'Ticket not found or is closed!'
                ], 401);
            }
            $ticket->update([
                'rating' => $request->rating,
                'feedback' => $request->feedback,
            ]);                 
            return response()->json([
                'status' => true,
                'message' => 'Ticket feedback add successfully!',
                'email'   => $student->email,
                'ticket' => $ticket
            ]);
        }catch (\Throwable  $e) {
                return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
       

    }
}
