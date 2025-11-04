<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $hidden = [
        'email',
        'password',
    ];

    protected $guarded = [];

    public function role(){
        return $this->belongsTo(AdminRole::class, 'admin_role_id');
    }

    public function referrals(){
        return $this->hasMany(Referral::class, 'referrer_id');
    }
}
