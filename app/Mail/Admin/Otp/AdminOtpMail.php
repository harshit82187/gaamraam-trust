<?php
namespace App\Mail\Admin\Otp;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class AdminOtpMail extends Mailable implements ShouldQueue // Ensure it implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $otp;
    public $email;
    public $subject;

    /**
     * Create a new message instance.
     */
    public function __construct($otp, $email)
    {
        $this->otp = $otp;
        $this->email = $email;
        $this->subject = "🔔 Admin Email Verification OTP | 🗓️ " . \Carbon\Carbon::today()->format('d-M-Y') . " | 🕒 " . \Carbon\Carbon::now()->format('h:i A');

    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->view('mail-template.admin.login.otp')
                    ->with([
                        'otp' => $this->otp,
                        'email' => $this->email,
                    ]);
    }
}
