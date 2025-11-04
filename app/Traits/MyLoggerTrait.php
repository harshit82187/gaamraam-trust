<?php 

namespace App\Traits;

trait MyLoggerTrait
{
    public function logMessage($msg)
    {
        \Log::info('[CustomLog]: ' . $msg);
    }
}
