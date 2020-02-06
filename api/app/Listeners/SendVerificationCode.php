<?php

namespace App\Listeners;

use App\Classes\SMS\KavenegarProvider;
use App\Events\UserRegistered;

class SendVerificationCode
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $provider = new KavenegarProvider();

        $provider->sendVerification($event->user->mobile, $event->user->verification_code);
    }
}
