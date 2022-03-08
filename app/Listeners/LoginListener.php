<?php

namespace App\Listeners;

use Aacotroneo\Saml2\Events\Saml2LoginEvent;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginListener
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
    public function handle(Saml2LoginEvent $event)
    {
        $user = $event->getSaml2User();
        $userData = [
            'id' => $user->getUserId(),
            'attributes' => $user->getAttributes(),
            'assertion' => $user->getRawSamlAssertion(),
            'sessionIndex' => $user->getSessionIndex(),
            'nameId' => $user->getNameId(),
        ];

        // check if email already exists and fetch user
        $user = User::where('email', $userData['attributes']['EmailAddress'][0])->first();

        // if email doesn't exist, create new user
        if (null === $user) {
            $user = new User();
            $user->name = sprintf('%s %s', $userData['attributes']['FirstName'][0], $userData['attributes']['LastName'][0]);
            $user->email = $userData['attributes']['EmailAddress'][0];
            $user->password = Hash::make(Str::random(12));
            $user->save();
        }

        // insert sessionIndex and nameId into session
        session(['sessionIndex' => $userData['sessionIndex']]);
        session(['nameId' => $userData['nameId']]);

        // login user
        \Auth::login($user);
    }
}
