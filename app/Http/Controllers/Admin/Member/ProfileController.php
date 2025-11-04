<?php

namespace App\Http\Controllers\Admin\Member;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use App\Models\User;
use App\Models\Payment;
use App\Models\Task;
use App\Models\Referral;
use App\Models\MemberCreation;


use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function indianMemberList(Request $request){
        $admin = Auth::guard('admin')->user(); 
        $query = User::query()->where('member_type', '1')->where('status', '1');
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($admin->admin_role_id != 1) {
            $createdUserIds = MemberCreation::where('employee_id', $admin->id)->pluck('user_id');
            $query->whereIn('id', $createdUserIds);
        }
        $indianMembers = $query->orderBy('id', 'desc')->paginate(10);
        return view('admin.member.profile.indian-list', compact('indianMembers', 'admin'));
    }


   public function nriMemberList(){
     $admin = Auth::guard('admin')->user(); 
     $nriMembers = User::where('member_type','2')->orderBy('id','desc')->where('status','1')->paginate(10);
     return view('admin.member.profile.nri-list', compact('nriMembers','admin'));
   }

   public function memberUpdateStatus(Request $request){
       // dd($request->all());
       $request->validate([
          'member_id' => 'required|numeric',  
          'status' => 'required|boolean',  
      ]);
      $member = User::findOrFail($request->member_id);
      $member->status = $request->status;
      $member->save();
      return response()->json([
          'success' => true,
          'message' => 'Member status updated successfully',
      ]);
   }

    public function memberEmailVerifyUpdateStatus(Request $request){
        // dd($request->all());
        $request->validate([
          'member_id' => 'required|numeric',  
          'email_verified_at' => 'required|boolean',  
      ]);
      $member = User::findOrFail($request->member_id);
      $member->email_verified_at = $request->email_verified_at ? now() : null;
      $member->save();
      return response()->json([
          'success' => true,
          'message' => 'Member email verification status updated successfully',
      ]);
    }

    public function memberInfo($id){
        $member = User::findOrFail(decrypt($id));
        $donation = Payment::where('user_id', $member->id)->sum('amount');
        $employee = MemberCreation::where('user_id', $member->id)->first();
        return view('admin.member.profile.other-info.info', compact('member','donation','employee'));
    }

    public function memberDonationOnline(Request $req, $id){
        // dd($req->all(),$id);
        $admin = Auth::guard('admin')->user(); 
        $member = User::with('donationInfo')->findOrFail(decrypt($id));
        $query = Payment::where('user_id', $member->id)->orderBy('created_at','desc')->whereIn('mode',[1,4,5]);
        if ($req->filled('invoice_no')) {
            $query->where('invoice_no', 'like', '%' . $req->invoice_no . '%');
        }
        $donations = $query->paginate(10)->appends($req->all());
        return view('admin.member.profile.other-info.donation', compact('member','donations','admin'));
    }

     public function memberDonationOffline(Request $req, $id){
        // dd($req->all(),decrypt($id));
        $admin = Auth::guard('admin')->user(); 
        $member = User::with('donationInfo')->findOrFail(decrypt($id));
        $query = Payment::where('user_id', $member->id)->orderBy('created_at','desc')->whereIn('mode',[3]);
        if ($req->filled('invoice_no')) {
            $query->where('invoice_no', 'like', '%' . $req->invoice_no . '%');
        }
        $donations = $query->paginate(10)->appends($req->all());
        return view('admin.member.profile.other-info.donation', compact('member','donations','admin'));
    }

    public function memberTask(Request $req, $id){
        // dd($req->all(),$id);
        $member = User::with('taskInfo')->findOrFail(decrypt($id));
        $query = Task::where('assign_to', $member->id);
        if ($req->filled('task')) {
            $query->where('task', 'like', '%' . $req->task . '%');
        }
        $tasks = $query->paginate(10)->appends($req->all());
        return view('admin.member.profile.other-info.task', compact('member','tasks'));
    }

      public function memberRefferal(Request $req, $id){
        // dd($req->all(),$id);
        $member = User::with('referralInfo')->findOrFail(decrypt($id));
        $query = Referral::where('referrer_id', $member->id);        
        $referrals = $query->paginate(10);
        return view('admin.member.profile.other-info.referral', compact('member','referrals'));
    }

    public function memberAdd(){
        return view('admin.member.create');
    }

    public function verifyDonation(Request $request, $id){
        // dd($request->all(),$id);
        $donation = Payment::findOrFail($id);
        if ($donation->mode != 3) {
            return back()->with('error', 'Only offline donations can be verified.');
        }
        $donation->is_verified = true;
        $donation->save();
        return back()->with('success', 'Donation marked as verified successfully.');
    }



       


   

}