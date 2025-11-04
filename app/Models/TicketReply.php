<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class TicketReply extends Model
{
    use HasFactory;
    protected $table="ticket_replies";
    protected $guarded = [];    

    public function ticket(){
        return $this->belongsTo(Ticket::class,'ticket_id');
    }

    public function adminDetail(){
        return $this->belongsTo(Admin::class,'user_id');
    }

    public function studentDetail(){
        return $this->belongsTo(Student::class,'user_id');
    }

    public function memberDetail(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function collegeDetail(){
        return $this->belongsTo(Institute::class,'user_id');
    }
    
}
