<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['keys', 'value'];

    public static function get($key)
    {
        return self::where('keys', $key)->value('value');
    }

    public static function set($key, $value)
    {
        return self::updateOrCreate(['keys' => $key], ['value' => $value]);
    }
}
