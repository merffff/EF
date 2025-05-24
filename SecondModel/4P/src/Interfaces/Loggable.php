<?php

namespace App\Interfaces;


interface Loggable
{
    public function log(string $message):void;
}
