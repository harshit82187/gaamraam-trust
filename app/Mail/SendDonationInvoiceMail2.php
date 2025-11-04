<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendDonationInvoiceMail2 extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $payment_table;
    public $subjectLine;

    public function __construct($payment_table, $subjectLine)
    {
        $this->payment_table = $payment_table;
        $this->subjectLine = $subjectLine;
    }

    public function build()
    {
        return $this->subject($this->subjectLine)
                    ->view('mail-template.member.donation-invoice2')
                    ->with([
                            'payment_table' => $this->payment_table,
                  ]);
    }
}