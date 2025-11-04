<?php

namespace App\Http\Controllers\Admin\College;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Teacher;
use Illuminate\Support\Facades\File;

class TeacherController extends Controller
{
    public function index(Request $req){
        $query = Teacher::query();
        if($req->has('name') && $req->name != null){
            $query->where('name','like','%' .$req->name . '%');
        }
        $teachers = $query->paginate(10);
        return view('admin.college.teacher.index', compact('teachers'));
    }

    public function create(){
        return view('admin.college.teacher.create');
    }

    public function store(Request $request){
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'education' => 'required|string|max:255',
            'experience' => 'required|integer',
            'about' => 'required|string',
            'image' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);
        $image = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $year = now()->year;
            $month = now()->format('M');
            $folderPath = public_path("app/teacher/{$year}/{$month}");
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);  
            }
            $file->move($folderPath, $filename);
            $image = "app/teacher/{$year}/{$month}/" . $filename;
        }
        Teacher::create([
            'name' => $request->name,
            'education' => $request->education,
            'about' => $request->about,
            'image' => $image,  
            'experience' => $request->experience,  
        ]);
        return redirect()->route('admin.teacher.index')->with('success', 'Teacher created successfully.');
    }

    public function edit($id){
        $teacher = Teacher::findOrFail($id);
        return view('admin.college.teacher.edit', compact('teacher'));
    }

    public function update(Request $request, $id){
        $teacher = Teacher::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'education' => 'required|string|max:255',
            'experience' => 'required|integer',
            'about' => 'required|string',
            'image' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);
        $image = $teacher->image;
        if ($request->hasFile('image')) {
            if ($teacher->image && File::exists(public_path($teacher->image))) {
                File::delete(public_path($teacher->image));
            }
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $year = now()->year;
            $month = now()->format('M');
            $folderPath = public_path("app/teacher/{$year}/{$month}");
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);  
            }
            $file->move($folderPath, $filename);
            $image = "app/teacher/{$year}/{$month}/" . $filename;
        }
        $teacher->update([
            'name' => $request->name,
            'education' => $request->education,
            'about' => $request->about,
            'image' => $image,  
            'experience' => $request->experience,  
        ]);
        return redirect()->route('admin.teacher.index')->with('success', 'Teacher updated successfully.');
    }

    public function show($id){
        $teacher = Teacher::findOrFail($id);
        return view('admin.college.teacher.show', compact('teacher'));
    }

    public function destroy($id){
        $teacher = Teacher::findOrFail($id);
        if ($teacher->image && File::exists(public_path($teacher->image))) {
            File::delete(public_path($teacher->image));
        }
        $teacher->delete();
        return redirect()->route('admin.teacher.index')->with('success', 'Teacher deleted successfully.');
    }
}
