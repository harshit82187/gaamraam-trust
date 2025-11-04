<?php

namespace App\Http\Controllers\Institute\attendance;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Mail;
use Hash;

use App\Models\Institute;
use App\Models\Student;
use App\Models\Attendance;

use App\Mail\Student\StudentPunchOutMail;
use Maatwebsite\Excel\Facades\Excel;


use Illuminate\Support\Facades\Log;
use App\Models\College;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class AttendanceController extends Controller
{
    
    public function studentAttendance(Request $req){
        $institute = Auth::guard('institute')->user();
        $query = Attendance::where('college_id', $institute->college_id);
        if($req->has('name') && $req->name != null){
            $query->where('name','like','%' .$req->name . '%');
        }
        $attendances = $query->orderBy('created_at', 'desc')->paginate(10);
        $students = Student::where('mode',2)->where('college_id',$institute->college_id)->orderBy('name')->get();
        // dd($attendances,$institute);
        return view('institute.attendance.list', compact('institute','attendances','students'));
    }

    public function studentAttendanceMark(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'student_id' => ['required', 'array'],
        ]);

        $punchInTime = $request->date . ' ' . $request->time;
        $institute = Auth::guard('institute')->user();

        $studentIds = $request->student_id;
        if (in_array('all', $studentIds)) {
            $studentIds = Student::where('college_id', $institute->college_id)->pluck('id')->toArray();
        }

        $alreadyMarkedStudents = [];
        foreach ($studentIds as $studentId) {
            $existing = Attendance::where('student_id', $studentId)
                ->whereDate('punch_in', $request->date)
                ->exists();

            if ($existing) {
                $student = Student::find($studentId);
                $alreadyMarkedStudents[] = $student->name ?? 'Unknown Student';
                continue;
            }

            Attendance::create([
                'student_id' => $studentId,
                'punch_in' => $punchInTime,
                'created_by' => $institute->id,
                'college_id' => $institute->college_id,
                'note'       => null,
            ]);
        }

        if (!empty($alreadyMarkedStudents)) {
            return back()->with([
                'error' => 'Attendance already marked for: ' . implode(', ', $alreadyMarkedStudents) . ".\n Attendance marked successfully for the remaining students.",
            ]);
            
            
        }

        return back()->with('success', 'Attendance marked successfully.');
    }

    public function studentAttendancePunchOut(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'student_id' => ['required', 'array'],
        ]);

        $punchOutTime = $request->date . ' ' . $request->time;
        $institute = Auth::guard('institute')->user();
        $studentIds = $request->student_id;
        if (in_array('all', $studentIds)) {
            $studentIds = Student::where('college_id', $institute->college_id)->pluck('id')->toArray();
        }
        $notMarkedStudents = [];
        $alreadyPunchedOutStudents = [];
        $successfulPunchOutStudents = [];
        foreach ($studentIds as $studentId) {
            $attendance = Attendance::where('student_id', $studentId)
                ->whereDate('punch_in', $request->date)
                ->first();

            $student = Student::find($studentId);
            $studentName = $student->name ?? 'Unknown Student';

            if (!$attendance) {
                $notMarkedStudents[] = $studentName;
                continue;
            }

            if ($attendance->punch_out) {
                $alreadyPunchedOutStudents[] = $studentName;
                continue;
            }

            $attendance->update([
                'punch_out' => $punchOutTime,
                'note'      => $request->note ?? null,
            ]);

            $successfulPunchOutStudents[] = $studentName;
            if (!empty($student->email)) {
                try {
                    $note = $request->note;
                    $formattedDate = \Carbon\Carbon::parse($punchOutTime)->format('d M Y');
                    $today = \Carbon\Carbon::today()->format('d-M-Y');
                    $now = \Carbon\Carbon::now()->format('h:i A');
                    $subject = "📋 Attendance Update: 🕒 Punch In & Out Details for {$formattedDate} | {$today} | {$now}";
                    Mail::to($student->email)->queue(new StudentPunchOutMail($student, $punchOutTime, $subject, $attendance, $note));
                    Log::channel('email')->info('Attendance Update email sent successfully.', ['to' => $student->email, 'subject' => $subject]);
                }catch (\Exception $e) {
                    Log::channel('email')->error('Failed to send Attendance Update email.', ['error' => $e->getMessage(), 'to' => $student->email]);
                }
            }
        }

        $messages = [];
        if (!empty($successfulPunchOutStudents)) {
            $messages[] = 'Punch Out successfully marked for: ' . implode(', ', $successfulPunchOutStudents);
        }
        if (!empty($alreadyPunchedOutStudents)) {
            $messages[] = 'Already punched out: ' . implode(', ', $alreadyPunchedOutStudents);
        }
        if (!empty($notMarkedStudents)) {
            $messages[] = 'Punch In not found for: ' . implode(', ', $notMarkedStudents);
        }
        $status = !empty($successfulPunchOutStudents) ? 'success' : 'error';
        return back()->with($status, implode("\n", $messages));
    }



    

  

}