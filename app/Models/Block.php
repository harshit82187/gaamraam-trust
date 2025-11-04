<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Block extends Model
{
    use HasFactory;
    protected $table = 'blocks';
    protected $guarded = [];


    public function blocks()
    {
        return $this->hasMany(Block::class);
    }
 
}
