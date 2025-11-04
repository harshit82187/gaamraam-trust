<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendDonationInvoiceMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $payment_table;
    public $isAdmin;
    public $subjectLine;
    public $count;   

    public function __construct($payment_table, $isAdmin, $subjectLine, $count)
    {
        $this->payment_table = $payment_table;
        $this->isAdmin = $isAdmin;
        $this->subjectLine = $subjectLine;
        $this->count = $count;
    }

    public function build()
    {
        return $this->subject($this->subjectLine) 
                    ->view('mail-template.member.donation-invoice')
                    ->with([
                            'payment_table' => $this->payment_table,
                            'isAdmin' => $this->isAdmin,  
                            'count'   => $this->count,
                  ]);
    }
}
