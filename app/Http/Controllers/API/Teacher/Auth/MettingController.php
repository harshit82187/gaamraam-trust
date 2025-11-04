<?php

namespace App\Http\Controllers\API\Teacher\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Meeting;
use Illuminate\Support\Facades\Validator;


class MettingController extends Controller
{
    public function store(Request $req){
        // dd($req->all());
        try{
            $teacher = $req->get('auth_user');
            $rules = [
                'name' => 'required|string|max:250',
                'date' => 'required|date',
                'time' => 'required|date_format:H:i',
            ];
            $validator = Validator::make($req->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }
            $scheduledAt = $req->date . ' ' . $req->time;
            $meeting = Meeting::create([
                'name'        => $req->name,
                'scheduled_at'=> $scheduledAt,
                'created_by'  => $teacher->id, 
            ]);
            
            return response()->json([
                'status' => true,
                'message' => 'Meeting registered successfully',
                'meeting' => $meeting,
            ],200);
        }catch (\Throwable  $e) {
                    return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ], 500);
            }
    }

    public function index(Request $req){
        $teacher = $req->get('auth_user');
        $meetings = Meeting::where('created_by',$teacher->id)->orderBy('created_at','desc')->get();
        if ($meetings->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No Meetings found!'
            ],404);
        }
         return response()->json([
            'status' => true,
            'message' => 'Meetings fetch successfully!',
            'count'   =>count($meetings),
            'meetings' => $meetings
        ]);
    }
}
