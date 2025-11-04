<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    protected $guarded = [];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'students', 'id', 'id')
                    ->whereIn('id', $this->student_id);
    }

    public function institutes()
    {
        return $this->belongsToMany(Institute::class, 'students', 'id', 'id')
                    ->whereIn('id', $this->user_id);
    }
 
}
