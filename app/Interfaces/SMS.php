<?php

namespace App\Interfaces;

interface SMS
{   public function connect($message, $phone);
    public function send($message, $phone);
}
