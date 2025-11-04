<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogDetails extends Model
{
    use HasFactory;
    protected $table = 'log_details';
    protected $guarded = [];
 
    public function student(){
        return $this->belongsTo(Student::class,'user_id');
    }
}



