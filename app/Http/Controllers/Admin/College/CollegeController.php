<?php

namespace App\Http\Controllers\Admin\College;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Str;
use DB;

use App\Models\College;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class CollegeController extends Controller
{

    public function collegeAdd(Request $req){
        if($req->isMethod('get')){
            return view('admin.college.add');
        }else{
            // dd($req->all());
            try{
                DB::beginTransaction();

                $validator = Validator::make($req->all(), [
                    'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                    'name' => 'required|max:255',
                    'year' => 'nullable|digits:4|integer|min:1800|max:' . date('Y'),
                    'website_link' => 'nullable|url',
                    'affilated_university' => 'nullable|string|max:255',
                    'email' => 'nullable|email|max:255|unique:colleges,email',
                    'mobile_no' => 'nullable|digits:10',
                    'landline_no' => 'nullable|digits_between:6,12',
                    'grade' => 'nullable|in:A++,A+,A,B++,B+,B,none',
                    'director_name' => 'required|string|max:255',
                    'pin_code' => 'nullable|digits_between:5,10',
                    'state' => 'required',
                    'city' => 'required',
                    'location_url' => 'nullable|url',
                    'address' => 'nullable|string|max:1000',
                    'description' => 'nullable|string|max:5000',
                    'video_url' => 'nullable|string|max:5000',
                ]);
                

                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                }

                $college = new College();
                $college->name = $req->name;
                $college->year = $req->year;
                $college->website_link = $req->website_link;
                $college->affilated_university = $req->affilated_university;
                $college->email = $req->email;
                $college->mobile_no = $req->mobile_no;
                $college->landline_no = $req->landline_no;
                $college->grade = $req->grade;
                $college->director_name = $req->director_name;
                $college->pin_code = $req->pin_code;
                $college->state = $req->state;
                $college->city = $req->city;
                $college->location_url = $req->location_url;
                $college->address = $req->address;
                $college->description = $req->description;
                $college->video_url = $req->video_url ?? null;

                if($req->logo != null){
                    $file = $req->logo;
                    $filename = time(). '.' . $file->getClientOriginalExtension();
                    $year = now()->year;
                    $month = now()->format('M');
                    $folderPath = public_path("app/college-logo/{$year}/{$month}");
                    if (!file_exists($folderPath)) {
                        mkdir($folderPath, 0777, true);  
                    }
                    $file->move($folderPath, $filename);
                    $college->logo = "app/college-logo/{$year}/{$month}/" . $filename;
                }


                $college->save();
                DB::commit();
                return redirect('admin/college-list')->with('success', 'College Details Added Successfully!');

            }catch(\Exception $e){
                DB::rollBack();
            }
                
        }
    }

    public function collegeList(Request $req){
        $colleges = College::paginate(10);
        return view('admin.college.list',compact('colleges'));
    }

    public function collegeUpdateStatus(Request $req){
        // dd($req->all());
        $req->validate([
            'college_id' => 'required|numeric',  
            'status' => 'required|boolean',  
        ]);
        $college = College::findOrFail($req->college_id);
        $college->status = $req->status;
        $college->save();

        return response()->json([
            'success' => true,
            'message' => 'College status updated successfully',
        ]);   
    }

    public function collegeEdit($id){
        $college = College::findOrFail($id);
        return view('admin.college.edit',compact('college'));
    }

    public function collegeUpdate(Request $req){
        try{
            // dd($req->all());
            DB::beginTransaction();

            $validator = Validator::make($req->all(), [
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'name' => 'required|max:255',
                'year' => 'nullable|digits:4|integer|min:1800|max:' . date('Y'),
                'website_link' => 'nullable|url',
                'affilated_university' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255|unique:colleges,email,' . $req->id,
                'mobile_no' => 'nullable|digits:10',
                'landline_no' => 'nullable|digits_between:6,12',
                'grade' => 'nullable|in:A++,A+,A,B++,B+,B,none',
                'director_name' => 'required|string|max:255',
                'pin_code' => 'nullable|digits_between:5,10',
                'state' => 'required',
                'city' => 'required',
                'location_url' => 'nullable|url',
                'address' => 'nullable|string|max:1000',
                'description' => 'nullable|string|max:5000',
                'video_url' => 'nullable|string|max:5000',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $college = College::findOrFail($req->id);
            $college->name = $req->name;
            $college->year = $req->year;
            $college->website_link = $req->website_link;
            $college->affilated_university = $req->affilated_university;
            $college->email = $req->email;
            $college->mobile_no = $req->mobile_no;
            $college->landline_no = $req->landline_no;
            $college->grade = $req->grade;
            $college->director_name = $req->director_name;
            $college->pin_code = $req->pin_code;
            $college->state = $req->state;
            $college->city = $req->city;
            $college->location_url = $req->location_url;
            $college->address = $req->address;
            $college->description = $req->description;
            $college->video_url = $req->video_url;

            if ($req->hasFile('logo')) {
                if ($college->logo && file_exists(public_path($college->logo))) {
                    unlink(public_path($college->logo));
                }
                $file = $req->file('logo');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $year = now()->year;
                $month = now()->format('M');
                $folderPath = public_path("app/college-logo/{$year}/{$month}");
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0777, true);
                }
                $file->move($folderPath, $filename);
                $college->logo = "app/college-logo/{$year}/{$month}/" . $filename;
            }
            $college->save();
            DB::commit();
            return redirect('admin/college-list')->with('success', 'College Details Updated Successfully!');

        }catch(\Exception $e){
            DB::rollBack();
            return back()->with('error', 'Warning : ' .$e->getMessage());
        }
    }
        

    

   

}