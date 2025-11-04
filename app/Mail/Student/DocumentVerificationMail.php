<?php 

namespace App\Mail\Student;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DocumentVerificationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $student;
    public $studentName;

    public function __construct($student, $studentName)
    {
        $this->student = $student;
        $this->studentName = $studentName;

    }

    public function build()
    {
        return $this->subject('✅ Step 2: Your Documents are Verified! Next Step: Aptitude Test')
            ->view('mail-template.student.document-verification')
            ->with([
                'student' => $this->student,
                'studentName' => $this->studentName,
                'currentYear' => date('Y'),
            ]);
    }
}
