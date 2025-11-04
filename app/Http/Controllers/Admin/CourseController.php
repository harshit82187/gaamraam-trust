<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Str;

use App\Models\Course;
use App\Models\Document;
use App\Models\Student;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;

class CourseController extends Controller
{
    public function courses(){
        $courses = Course::paginate(10);
        return view('admin.course.index', compact('courses'));
    }

    public function addCourse(Request $req){
        // dd($req->all());
        $req->validate([
            'name' => 'required|string|max:250',
            'image' => 'required|mimes:jpeg,png,jpg|max:2048',
        ]);
        $course = new Course();
        $course->name = $req->name;
        $course->status = '1';
        $course->slug = Str::slug($req->name);

        if($req->image != null){
            $file = $req->image;
            $filename = time(). '.' . $file->getClientOriginalExtension();
            $year = now()->year;
            $month = now()->format('M');
            $folderPath = public_path("app/courses/{$year}/{$month}");
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);  
            }
            $file->move($folderPath, $filename);
            $course->image = "app/courses/{$year}/{$month}/" . $filename;
        }
        $course->save();
        return back()->with('success','Couse Saved Successfully!');
    }

    public function editCourse($id){
        $course = Course::find($id);
        if(!$course){
            return back()->with('error','Course Not Found!');
        }
        $courseDetails = json_decode($course->details,true);
        $tagsDetails =  json_decode($course->tag,true);
        $whyJoinUs   = json_decode($course->why_join_us,true);
        $programs   = json_decode($course->programs,true);
        $preparation_plans   = json_decode($course->preparation_plans,true);
        $test_series   = json_decode($course->test_series,true);
        $criterias   = json_decode($course->criteria,true);   
        // dd($whyJoinUs,$programs,$course->why_join_us);   
        return view('admin.course.edit', compact('course','courseDetails','tagsDetails','whyJoinUs','programs','preparation_plans','test_series','criterias'));
    }

    public function updateCourse(Request $req){
        // dd($req->all());
        $req->validate([
            'course_id' => 'required|exists:courses,id',
            'tab_one' => 'nullable|string',
            'tab_two' => 'nullable|string',
            'tab_three' => 'nullable|string',
            'tab_four' => 'nullable|string',
            'why_join_us' => 'required|array',
            'why_join_us.*.en' => 'required|string',
            'why_join_us.*.hi' => 'required|string',
            'programs' => 'required|array',
            'programs.*.en' => 'required|string',
            'programs.*.hi' => 'required|string',
            'test_series' => 'nullable|array',
            'test_series.*.en' => 'nullable|string',
            'test_series.*.hi' => 'nullable|string',
            'criteria' => 'nullable|array',
            'criteria.*.en' => 'nullable|string',
            'criteria.*.hi' => 'nullable|string',  
            'preparation_plans' => 'nullable|string',
            'name' => 'required|string|max:250',
            'image' => 'nullable|mimes:jpeg,png,jpg|max:2048',
        ]);
        $course = Course::find($req->course_id);
        if(!$course){
            return back()->with('error','Course Not Found!');
        }
        

        $dataToUpdate = [
            'tab_one' => $req->tab_one,
            'tab_one_hi' => $req->tab_one_hi,
            'tab_two' => $req->tab_two,
            'tab_two_hi' => $req->tab_two_hi,
            'tab_three' => $req->tab_three,
            'tab_three_hi' => $req->tab_three_hi,
            'tab_four' => $req->tab_four,
            'tab_four_hi' => $req->tab_four_hi,
            'why_join_us' => json_encode(array_values($req->why_join_us), JSON_UNESCAPED_UNICODE),
            'programs' => json_encode(array_values($req->programs), JSON_UNESCAPED_UNICODE),
            'test_series' => json_encode(array_values($req->test_series ?? []), JSON_UNESCAPED_UNICODE),
            'criteria' => json_encode(array_values($req->criteria ?? []), JSON_UNESCAPED_UNICODE),
            'preparation_plans' => $req->preparation_plans,
            'preparation_plans_hi' => $req->preparation_plans_hi,
            'name' => $req->name,
            'name_hi' => $req->name_hi,
            'slug' => Str::slug($req->name),
        ];
        if($req->image != null){
            $req->validate([
                'image' => 'mimes:jpeg,png,jpg|max:2048', 
            ]);
            $file = $req->image;
            $filename = time(). '.' . $file->getClientOriginalExtension();
            $year = now()->year;
            $month = now()->format('M');
            $folderPath = public_path("app/courses/{$year}/{$month}");
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);  
            }
            $file->move($folderPath, $filename);
            $dataToUpdate['image'] = "app/courses/{$year}/{$month}/" . $filename;
        }    
      
        $course->update($dataToUpdate);
        return back()->with('success', 'Course details updated  successfully.');

    }

    public function updateStatus(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'course_id' => 'required|numeric',  
            'status' => 'required|boolean',  
        ]);
      

        $course = Course::findOrFail($request->course_id);
        $course->status = $request->status;
        $course->save();
        return response()->json([
            'success' => true,
            'message' => 'Course status updated successfully',
        ]);
    }
  
 

    

   

}