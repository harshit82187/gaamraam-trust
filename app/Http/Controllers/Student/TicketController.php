<?php

namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Auth;
use Hash;
use Mail;

use App\Models\Ticket;
use App\Models\BussinessSetting;
use App\Models\TicketReply;
use App\Mail\Student\SupportTicketNotification;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
class TicketController extends Controller
{
    public function view(Request $req){
        $student = Auth::guard('student')->user();
        $query = Ticket::query()->where('user_id', $student->id);
        if ($req->filled('ticket_id') && $req->ticket_id != null ) {
            $query->where('ticket_id', 'like', '%' . $req->ticket_id . '%');
        }
        if ($req->has('status') && $req->status != null && $req->status != 'null') {
            $query->where('status', $req->status); 
        }
        $tickets = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('student.ticket.list',compact('tickets'));
    }

    public function add(Request $req){
        if($req->isMethod('get')){
            return view('student.ticket.add');
        }else{
            // dd($req->all());
            $user = Auth::guard('student')->user();
            $req->validate([
                'subject' => 'required|string|max:255',
                'priority' => 'required|in:1,2,3,4', 
                'description' => 'required|string',
                'attachments.*' => 'nullable|mimes:jpeg,jpg,png,pdf,webp|max:4096', 
            ]);       
            $ticketNumber = now()->format('Ym') . rand(100000, 999999);
            $ticket = new Ticket();
            $ticket->type = 1;
            $ticket->ticket_id = $ticketNumber;
            $ticket->user_id = $user->id;
            $ticket->subject = $req->subject;
            $ticket->priority = $req->priority;
            $ticket->description = $req->description;
            $ticket->status = 1;
            $ticket->save();
            if ($req->hasFile('attachments')) {
                $uploadedFiles = $req->file('attachments');
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
            $email = $user->email;
            $adminEmail = BussinessSetting::where('type','email')->value('value');
            try {
                Mail::to($email)->queue(new SupportTicketNotification($ticket, $userSubject, false));  
                Mail::to($adminEmail)->queue(new SupportTicketNotification($ticket, $adminSubject, true));    
                Log::channel('email')->info('Email sent successfully to ' . $email . ' and Admin: ' . $adminEmail);
            } catch (\Exception $mailException) {
                Log::channel('email')->error('Failed to send email to ' . $email . '. Error: ' . $mailException->getMessage());
            }
            return redirect()->route('student.tickets.view')->with('success', 'Ticket submitted successfully!');
        }
    }

    public function info($id){
        $student = Auth::guard('student')->user();
        $ticket = Ticket::where('id',decrypt($id))->where('user_id',$student->id)->where('type',1)->first();
        if($ticket == null){
        return back()->with('error','Ticket not found!');
        }
        return view('student.ticket.view', compact('ticket'));
    }

    public function reply(Request $request, $id){
        //  dd($request->all(),decrypt($id));
        $request->validate([
            'reply' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $student = Auth::guard('student')->user();
        $ticket = Ticket::where('id',decrypt($id))->where('user_id', $student->id)->where('type', 1)->first();

        if (!$ticket || $ticket->status != 1) {
            return back()->with('error', 'Ticket not found or is closed.');
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
        return back()->with('success', 'Reply sent successfully.');
    }

    public function feedback(Request $request){
        //  dd($request->all());
        $request->validate([
            'id' => 'required|string',
            'rating' => 'required|numeric',
            'feedback' => 'required|string',
        ]);
        $ticket = Ticket::where('id',decrypt($request->id))->first();
        if (!$ticket) {
            return back()->with('error', 'Ticket not found or is closed.');
        }
        $ticket->update([
            'feedback' => $request->feedback,
            'rating' => $request->rating,
        ]); 
         return back()->with('success', 'feedback saved successfully.');
    }

}