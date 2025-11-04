<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use App\Models\User;
use App\Models\Document;
use App\Models\Student;
use App\Models\StudentCreation;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;

class DocumentController extends Controller
{
  
    public function document(Request $req){
        $admin = Auth::guard('admin')->user(); 
        $query = Document::query();
        if ($admin->admin_role_id != 1) {
            $createdStudentIds = StudentCreation::where('employee_id', $admin->id)->pluck('student_id');
            $query->whereIn('id', $createdStudentIds);
        }
        if($req->has('name') && $req->name != null){
            $student = Student::where('name',$req->name)->first();
            $query->where('student_id',$student->id);
        }
        $documents = $query->orderBy('created_at', 'desc')->paginate(10);
        // dd($documents);
        return view('admin.document.index', compact('documents'));
    }



    public function updateApproved(Request $request, $id)
    {
        $request->validate([
            'approved' => 'required|in:0,1,2',
        ]);

        $document = Document::findOrFail($id);
        $document->approved = $request->approved;
        $document->save();

        return redirect()->back()->with('success', 'Approval status updated successfully.');
    }

    

   

}