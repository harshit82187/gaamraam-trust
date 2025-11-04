<?php 

namespace App\Mail\Student;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentPunchOutMail extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $punchOutTime;
    public $subjectLine;
    public $attendance;
    public $note;

    public function __construct($student, $punchOutTime, $subjectLine, $attendance, $note = null)
    {
        $this->student = $student;
        $this->punchOutTime = $punchOutTime;
        $this->subjectLine = $subjectLine;
        $this->attendance = $attendance;
        $this->note = $note;
    }

    public function build()
    {
        return $this->subject($this->subjectLine)
                    ->view('mail-template.student.student_punch_out');
    }
}
