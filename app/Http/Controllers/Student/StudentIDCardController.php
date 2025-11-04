<?php

namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Auth;
use Hash;
use Mail;

use App\Models\Document;
use App\Models\Student;




use App\Mail\Student\DocumentVerificationMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentIDCardController extends Controller
{
  public function index(){
    $student = auth()->guard('student')->user();
    $count = 0;
    return view('student.auth.download-id-card', compact('student','count'));
  }


  public function downloadIdCard(){
      $student = auth()->guard('student')->user();
      $pdf = PDF::loadView('student.auth.id-card', compact('student'));
      $directory = public_path('app/student-profile/id-card');
      if (!File::exists($directory)) {
          File::makeDirectory($directory, 0755, true);
      }
      if (!empty($student->id_card_path)) {
          $previousPath = public_path($student->id_card_path);
          if (File::exists($previousPath)) {
              File::delete($previousPath);
          }
      }
      $fileName = 'student_id_card_' . $student->student_id .'.pdf';
      $filePath = $directory . '/' . $fileName;
      $pdf->save($filePath);
      $student->id_card_path = 'app/student-profile/id-card/' . $fileName;
      $student->save();
      return response()->download($filePath);
  }



    public function testView()
    {
        $student = auth()->guard('student')->user();
        return view('student.auth.id-card', compact('student'));
    }
   

}