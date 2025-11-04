<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $hidden = [
        'email',
        'password',
    ];
    protected $guarded = [];

    public function documents(){
        return $this->hasMany(Document::class);
    }   

    public function notifications(){
        return $this->hasMany(Notification::class);
    }

    public function stateName(){
        return $this->belongsTo(State::class,'state');
    }

    public function cityName(){
        return $this->belongsTo(City::class,'city');
    }

    public function studentLogDetail(){
        return $this->hasOne(LogDetails::class, 'user_id', 'id');
    }
}
