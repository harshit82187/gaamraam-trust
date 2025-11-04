<?php

namespace App\Http\Controllers\Admin\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use App\Models\LogDetails;
use App\Models\VisitorToken;


use Hash;
use Str;
use Mail;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;

class LogController extends Controller
{
  
    public function showStudentLog(Request $req){
        $query = LogDetails::query();
        $logs = $query->where('type','student_registration')->orderBy('created_at','desc')->paginate(10);
        return view('admin.setting.log.student.list', compact('logs'));
    }

    public function showVisitorLog(Request $req){
        $query = VisitorToken::query();
        if ($req->filled('start_date') && $req->filled('end_date')) {
            $query->whereBetween('created_at', [
                $req->start_date . ' 00:00:00',
                $req->end_date . ' 23:59:59'
            ]);
        }
        $logs = $query->orderBy('created_at','desc')->paginate(10);
        return view('admin.setting.log.visitor.list', compact('logs'));
    }

   

 



}
