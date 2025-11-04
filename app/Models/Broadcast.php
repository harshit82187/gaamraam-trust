<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Broadcast extends Model
{
    use HasFactory;
    protected $table = 'broadcast';
    protected $guarded = [];

    public function teacher(){
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

 
}
