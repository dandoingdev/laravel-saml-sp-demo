<?php

namespace App\Listeners;

use Aacotroneo\Saml2\Events\Saml2LogoutEvent;

class LogoutListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(Saml2LogoutEvent $event)
    {
        \Auth::logout();
    }
}
