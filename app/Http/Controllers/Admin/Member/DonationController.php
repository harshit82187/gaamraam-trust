<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DonationCollection;

class DonationController extends Controller
{
    public function donation(Request $req){
        $members = User::select('id', 'name', 'mobile')->get();
        // dd($members);
        return view('admin.donation.index', compact('members'));
    }
}
