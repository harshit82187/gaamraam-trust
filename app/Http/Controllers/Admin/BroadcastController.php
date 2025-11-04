<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Broadcast;
use Illuminate\Http\Request;

use Auth;
use Str;
use DB;
use Mail;
use Hash;
use Carbon\Carbon;

use App\Models\Institute;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class BroadcastController extends Controller
{

    public function broadcastList(){
        $broadcasts = Broadcast::with('teacher')->paginate(10);
        return view('admin.broadcast.broadcast', compact('broadcasts'));

    }

    public function broadcastAdd(Request $req){
      
        $validatedData = $req->validate([
            'teacher_id' => 'required',
            'datetime'   => 'required|date_format:Y-m-d\TH:i',
        ]);

        Broadcast::create([
            'teacher_id' => $validatedData['teacher_id'],
            'datetime' => $validatedData['datetime'],
           
        ]);

        return back()->with('success', 'Broadcast added succesfully');
    }

    public function broadcastDelete($id)
{
    $broadcast = Broadcast::find($id);

    if (!$broadcast) {
        return back()->with('error', 'Broadcast not found');
    }

    $broadcast->delete();

    return back()->with('success', 'Broadcast deleted successfully');
}




   
        

    

   

}