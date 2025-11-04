<?php

namespace App\Mail\Member;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendTaskMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $data;
    public $subjectLine;

    public function __construct($data, $subjectLine)
    {
        $this->data = $data;
        $this->subjectLine = $subjectLine;
    }
    
    public function build()
    {
        return $this->subject($this->subjectLine)
                    ->view('mail-template.member.send-task')
                    ->with('data', $this->data);
    }
}
