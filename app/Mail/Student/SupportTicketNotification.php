<?php 

namespace App\Mail\Student;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupportTicketNotification  extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $subjectLine; 
    public $isAdmin; 
    
    public function __construct($ticket, $subjectLine, $isAdmin = false)
    {
        $this->ticket = $ticket;
        $this->subjectLine = $subjectLine;
        $this->isAdmin = $isAdmin;

    }

    public function build()
    {
        return $this->subject($this->subjectLine)
                    ->view('mail-template.student.support.ticket')
                    ->with([
                        'ticket' => $this->ticket,
                        'isAdmin' => $this->isAdmin
                    ]);
    }
}
