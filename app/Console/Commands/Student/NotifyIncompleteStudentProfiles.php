<?php

namespace App\Console\Commands\Student;

use Illuminate\Console\Command;
use App\Models\Student;
use App\Models\Document;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use App\Models\BussinessSetting;

class NotifyIncompleteStudentProfiles extends Command
{
    protected $signature = 'notify:incomplete-student-profiles';

    protected $description = 'Notify students with incomplete profile or missing documents';

    // Mapping of document codes to names
    private $documentTypes = [
        1 => '10th Marksheet',
        2 => '12th Marksheet',
        3 => 'Graduation 1st Year Marksheet',
        4 => 'Graduation 2nd Year Marksheet',
        5 => 'Graduation 3rd Year Marksheet',
        6 => 'Character Certificate',
        7 => 'Domicile Certificate',
    ];

    public function handle(): int
    {
        try {
            Log::channel('cron-job')->info('Start NotifyIncompleteStudentProfiles Cron');
            // Fetch students with any NULL profile field
            $students = Student::where(function ($query) {
                $query->whereNull('image')
                      ->orWhereNull('state')
                      ->orWhereNull('city')
                      ->orWhereNull('block')
                      ->orWhereNull('address');
            })->get();

            foreach ($students as $student) {
                $missingFields = [];

                foreach (['image', 'state', 'city', 'block', 'address'] as $field) {
                    if (is_null($student->$field)) {
                        $missingFields[] = ucfirst($field);
                    }
                }

                // Get uploaded document names
                $uploadedDocs = Document::where('student_id', $student->id)->pluck('name')->toArray();
                $uploadedDocs = array_map('intval', $uploadedDocs); // convert to int

                // Calculate missing document names
                $missingDocs = array_diff(array_keys($this->documentTypes), $uploadedDocs);
                $missingDocNames = array_map(function ($docKey) {
                    return $this->documentTypes[$docKey];
                }, $missingDocs);

                // If either missing fields or documents found, send email
                if (!empty($missingFields) || !empty($missingDocNames)) {
                    $emailData = [
                        'student' => $student,
                        'missingFields' => $missingFields,
                        'missingDocuments' => $missingDocNames,
                    ];
                    $subject = 'Reminder: Complete Your Profile and Upload Missing Documents |'. \Carbon\Carbon::today()->format('d-M-Y').' | '.\Carbon\Carbon::now()->format('h:i A');
                    Mail::send('mail-template.student.incomplete-profile', $emailData, function ($message) use ($student, $subject) {
                        $message->to($student->email)
                        ->bcc(['gaamraam.ngo@gmail.com'])->subject($subject);
                    });

                    Log::channel('cron-job')->info("Reminder sent to student ID {$student->id}");
                }
            }

            $this->info('Notification process completed successfully.');
            return 0;

        } catch (\Exception $e) {
            Log::channel('cron-job')->error('Error in NotifyIncompleteStudentProfiles: ' . $e->getMessage());
            $this->error('Failed to notify students. Check logs for details.');
            return 1;
        }
    }
}
