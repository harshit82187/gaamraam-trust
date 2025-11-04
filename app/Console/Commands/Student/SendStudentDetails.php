<?php

namespace App\Console\Commands\Student;

use Illuminate\Console\Command;
use App\Models\Student;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class SendStudentDetails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:student-details';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send student table details (name and mobile number)';

    /**
     * Execute the console command.
     */
     public function handle()
        {
            try {
                // Fetch Student details
                Log::channel('cron-job')->info("Strat Cron-Job");
                $students = Student::select('name', 'mobile')->get();
                 $emailData = [
                    'students' => $students,
                ];
                $subject = 'Students Details |'. \Carbon\Carbon::today()->format('d-M-Y').' | '.\Carbon\Carbon::now()->format('h:i A');
                Mail::send('mail-template.student.student-details', $emailData, function($message) use ($subject) {
                    $message->to('harshitk@pearlorganisation.com')
                    ->bcc(['gaamraam.ngo@gmail.com']) ->subject($subject);
                });
    
                
                $this->info('students details have been logged successfully.');
            } catch (\Exception $e) {
                Log::channel('cron-job')->error('Error sending user details: ' . $e->getMessage());
                $this->error('Failed to send students details. Check the logs for more information.');
            }
        }
}

