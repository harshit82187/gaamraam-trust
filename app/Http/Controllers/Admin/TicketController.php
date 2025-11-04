<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Str;

use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\BussinessSetting;
use App\Models\admin;
use Illuminate\Support\Facades\Log;
use App\Mail\Admin\Ticket\TicketClosedNotification;
use Mail;
use PDF;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $admin = Admin::find(session('admin_id'));
            $permissions = session('role_permissions', []);
            if (!in_array('support_ticket', $permissions)) {
                abort(403, 'You are not an authorized member.');
            }
            return $next($request);
        });
    }
    
    public function list(Request $req, $typeSlug)
    {   
        // dd($typeSlug,$req->all());   
        $typeMap = [
            'student' => 1,
            'member' => 2,
            'college-member' => 3,
        ];     
        if (!array_key_exists($typeSlug, $typeMap)) {
            abort(404); 
        } 
        $type = $typeMap[$typeSlug];
        $query = Ticket::query()->where('type', $type);
        if ($req->filled('ticket_id') && $req->ticket_id != null ) {
            $query->where('ticket_id', 'like', '%' . $req->ticket_id . '%');
        }
        if ($req->has('status') && $req->status != null && $req->status != 'null') {
            $query->where('status', $req->status); 
        }
        $tickets = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.ticket.list', compact('tickets', 'typeSlug'));
    }

    public function info($id)
    {
        $ticket = Ticket::find(decrypt($id));
        if ($ticket == null) {
            return back()->with('error','Ticket Details Not Found!');
        }
        $type = $ticket->type; 
        return view('admin.ticket.view', compact('ticket', 'type'));
    }

    public function reply(Request $request, $id)
    {
        // dd($request->all(),decrypt($id));
        $ticket = Ticket::findOrFail(decrypt($id));
        $admin = Auth::guard('admin')->user();
        $request->validate([
            'reply' => 'required|string',
            'attachment' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        $data = [
            'ticket_id' => $ticket->id,
            'user_id' => $admin->id,
            'type' => 1,
            'reply' => $request->reply,
        ];

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
            $data['attachment'] = "app/support-attachments/reply/{$year}/{$month}/" . $filename;
        }
        TicketReply::create($data);
        return back()->with('success', 'Reply sent successfully.');
    }

    public function close($id)
    {
        // dd(decrypt($id));
        $admin = Auth::guard('admin')->user();
        $ticket = Ticket::findOrFail(decrypt($id));
        $replyExists = TicketReply::where('ticket_id', decrypt($id))->exists();
        if (!$replyExists) {
            return back()->with('error', 'Ticket Not Closed yet, please take communication!');
        }
        $ticket->update([
            'status' => 2, 
            'admin_id' => $admin->id  
        ]);
        $adminEmail = BussinessSetting::where('type','email')->value('value');
        $type = $ticket->type;
        if($type == 1){
            $email = $ticket->student->email;
        }elseif($type == 2){
            $email = $ticket->member->email;
        }elseif($type == 3){
            $email = $ticket->collegeMember->email;
        }

        try {
            Mail::to($email)->queue(new TicketClosedNotification($ticket, false));
            Mail::to($adminEmail)->queue(new TicketClosedNotification($ticket, true));
            \Log::channel('email')->info("Closed ticket email sent to {$email} and {$adminEmail}");
        } catch (\Exception $e) {
            \Log::channel('email')->error("Failed to send closed ticket email: " . $e->getMessage());
        }
        return back()->with('success', 'Ticket Closed Successfully!');
    }

    public function chatExport($id){
        $ticket = Ticket::find(decrypt($id));
        if(!$ticket){
            return back()->with('error', 'Ticket Not Found!');
        }
        $ticketNo = $ticket->ticket_id;        
        $pdf = PDF::loadView('pdf.admin.ticket.ticket-chat', compact('ticket','ticketNo'));
        return $pdf->download("ticket-chat-$ticketNo.pdf");
    }

    

   

}