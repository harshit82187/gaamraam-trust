<?php

namespace App\Http\Controllers\Institute\student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Mail;
use Hash;

use App\Models\Institute;
use App\Models\Notification;


use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class NotificationController extends Controller
{
    public function notification(Request $req){
        $institute = Auth::guard('institute')->user();
        // dd($institute);
        $notifications = Notification::whereJsonContains('user_id', (string) $institute->id)->orWhereJsonContains('user_id', "0")->orderBy('created_at', 'desc')->paginate(10);
        return view('institute.notification.list',compact('notifications'));
    }

}