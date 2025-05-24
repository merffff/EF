<?php

namespace App\Traits;

trait Logger
{

    public function log(string $message):void
    {
        echo "[LOG]: $message \n";
    }
}