<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExcelLog extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function adminInfo(){
        return $this->belongsTo(Admin::class,'admin_id');
    }
}
