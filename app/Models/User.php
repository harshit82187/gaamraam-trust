<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function referrals() {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

    public function stateName(){
        return $this->belongsTo(State::class,'state');
    }

    public function cityName(){
        return $this->belongsTo(City::class,'city');
    }

    public function blockName(){
        return $this->belongsTo(Block::class,'block');
    }

    public function countryInfo(){
        return $this->belongsTo(Country::class,'country');
    }

    public function donationInfo(){
         return $this->hasMany(Payment::class,'user_id','id');
    }

    public function taskInfo(){
         return $this->hasMany(Task::class,'assign_to','id');
    }

    public function referralInfo(){
         return $this->hasMany(Referral::class,'referrer_id','id');
    }
    
}
