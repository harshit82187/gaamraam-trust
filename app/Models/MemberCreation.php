<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberCreation extends Model
{
    use HasFactory;
    protected $table = 'member_creations';
    protected $guarded = [];

    public function MemberInfo(){
         return $this->belongsTo(User::class, 'member_id', 'id');
    }

    public function EmployeeInfo(){
        return $this->belongsTo(Admin::class, 'employee_id', 'id');
    }
}
