<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;
    protected $table = 'documents';
    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(Student::class,'student_id');
    }
 
}
