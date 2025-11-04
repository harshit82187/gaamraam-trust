<?php 

namespace App\Mail\Admin\Ticket;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketClosedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $isAdmin;
    public $recipientName;

    public function __construct($ticket, $isAdmin = false)
    {
        $this->ticket = $ticket;
        $this->isAdmin = $isAdmin;

        if ($isAdmin) {
            $this->recipientName = 'Admin';
        } else {            
             if($ticket->type == 1){
                $this->recipientName = $ticket->student->name ?? 'Student';
            }elseif($ticket->type == 2){
                $this->recipientName = $ticket->member->name ?? 'Member' ;
            }elseif($ticket->type == 3){
                $this->recipientName = $ticket->collegeMember->name ?? 'Member' ;
            }
        }

    }

    public function build()
    {
        $subject = $this->isAdmin 
            ? "🎉 Ticket #{$this->ticket->ticket_id} Closed | Admin Notification"
            : "🎉 Your Support Ticket #{$this->ticket->ticket_id} Has Been Resolved";

        return $this->subject($subject)
                    ->view('mail-template.admin.support-ticket.ticket-closed-notification')
                    ->with([
                        'ticket' => $this->ticket,
                        'isAdmin' => $this->isAdmin,
                        'recipientName' => $this->recipientName,
                    ]);
    }
}
