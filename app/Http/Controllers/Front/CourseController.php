<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use App\Models\Course;
use App\Models\Document;
use App\Models\Student;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;

class CourseController extends Controller
{
    public function course(){
        $courses = Course::where('status','1')->paginate(10);
        return view('front.course.index', compact('courses'));
    }

    public function courseDetail($slug){
        $course = Course::where('slug',$slug)->first();
        if(!$course){
            return back()->with('error','Course Not Found!');
        }
        $courseDetails = json_decode($course->details,true);
        $tagsDetails =  json_decode($course->tag,true);
        $why_join_usDetails =  json_decode($course->why_join_us,true);
        $programsDetails =  json_decode($course->programs,true);
        $test_seriesDetails =  json_decode($course->test_series,true);
        $criteriaDetails =  json_decode($course->criteria,true);
        $otherCourses = Course::whereNotIn('id',[$course->id])->where('status','1')->get();
        // dd($courseDetails,$tagsDetails);
        return view('front.course.view', compact('course','courseDetails','tagsDetails','otherCourses','why_join_usDetails',
                    'programsDetails','test_seriesDetails','criteriaDetails','otherCourses'));
    }
   
  
 

    

   

}