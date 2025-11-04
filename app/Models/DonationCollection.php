<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationCollection extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function employee() {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function member() {
        return $this->belongsTo(User::class, 'user_id');
    }

}
