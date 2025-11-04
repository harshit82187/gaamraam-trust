<?php

namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use App\Models\User;
use App\Models\Task;
use App\Models\Referral;


use Hash;
use Str;
use Mail;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\File;


class PointController extends Controller
{
    public function socialPoint(){
        $member = Auth::user();
        $referrals = Referral::where('referrer_id',$member->id)->paginate(10);
        // dd($member,$referrals);
        return view('member.referral.list',compact('member','referrals'));
    }

    



}
