<?php

use App\Models\LogDetails;
use App\Models\BussinessSetting;

use Illuminate\Support\Facades\Request;
use Carbon\Carbon; 

if (!function_exists('fetchIp')) {
    function fetchIp($student) {
        $data = [
            'user_id' => $student->id,
            'ip' => Request::ip(),
            'time' => Carbon::now(),
            'type' => 'student_registration',
        ];
        LogDetails::create($data);
    }
}

if (!function_exists('get_business_setting')) {
    function get_business_setting($type)
    {
        return BussinessSetting::where('type', $type)->value('value');
    }
}
