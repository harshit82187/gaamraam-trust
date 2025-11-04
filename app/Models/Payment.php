<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';
    protected $guarded = [];

    public function member(){
        return $this->belongsTo(User::class,'user_id');
    }
 
}
