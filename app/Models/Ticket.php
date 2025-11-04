<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Ticket extends Model
{
    use HasFactory;
    protected $table="tickets";
    protected $guarded = [];    

    public function student(){
        return $this->belongsTo(Student::class, 'user_id');
    }

    public function member(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function collegeMember(){
        return $this->belongsTo(Institute::class, 'user_id');
    }

    

    public function replies(){
        return $this->hasMany(TicketReply::class, 'ticket_id');
    }

    
}
