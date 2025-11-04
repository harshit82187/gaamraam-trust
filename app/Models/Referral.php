<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model {
    use HasFactory;

    protected $guarded = [];
    protected $table = 'referrals';

    public function referrer() {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    public function referred() {
        return $this->belongsTo(User::class, 'referred_id');
    }

    public function referredStudent() {
        return $this->belongsTo(Student::class, 'referred_id');
    }


    
}
