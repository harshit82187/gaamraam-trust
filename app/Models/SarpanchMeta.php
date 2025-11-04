<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SarpanchMeta extends Model
{
    use HasFactory;
    protected $table = 'sarpanche_metas';
    protected $guarded = [];


    public function sarpanch(){
        return $this->belongsTo(Sarpanch::class, 'sarpanch_id');
    }

    public function followUps(){
        return $this->hasMany(FollowUp::class, 'sarpanch_id', 'sarpanch_id');
    }


    public function telleCaller(){
        return $this->belongsTo(Admin::class, 'reciever_id');
    }
 
    public function latestFollowUp(){
        return $this->hasOne(FollowUp::class, 'sarpanch_id', 'sarpanch_id')->latestOfMany();
    }

    public function adminInfo(){
         return $this->belongsTo(Admin::class, 'sender_id');
    }

}
