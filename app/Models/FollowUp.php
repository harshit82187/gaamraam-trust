<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FollowUp extends Model
{
    use HasFactory;
    protected $table = 'follow_ups';
    protected $guarded = [];

    public function telleCaller(){
        return $this->belongsTo(Admin::class, 'user_id');
    }

    public function sarpanch(){
        return $this->belongsTo(Sarpanch::class, 'sarpanch_id');
    }

 
}
