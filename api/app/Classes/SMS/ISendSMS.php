<?php

namespace App\Classes\SMS;

interface ISendSMS
{
    public function sendVerification($receptor, $code);
}
