<?php

namespace App\Exceptions;

use Exception;

class VerificationException extends Exception
{

    public function __construct($message = 'کد احراز هویت اشتباه است.')
    {
        $this->message = $message;
    }

    public function render($request)
    {
        return response()->json([
            'message' => $this->getMessage()
        ], 400);

    }
}
