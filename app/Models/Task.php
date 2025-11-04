<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;
    protected $table = 'tasks';
    protected $guarded = [];

    public function member(){
        return $this->belongsTo(User::class,'assign_to');
    }

    public function adminDetail(){
        return $this->belongsTo(Admin::class,'assign_by');
    }

    public function taskDetails(){
        return $this->hasMany(TaskUpdate::class, 'task_id', 'id');
    }
 
}
