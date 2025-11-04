<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskUpdate extends Model
{
    use HasFactory;
    protected $table = 'task_updates';
    protected $guarded = [];

    public function task(){
        return $this->belongsTo(Task::class);
    }

 
}
