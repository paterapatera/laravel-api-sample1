<?php

namespace App\Auth\Applications\TwoFactorChallenge;

use Laravel\Sanctum\PersonalAccessToken;

class Output
{
    public function __construct(public PersonalAccessToken $token)
    {
    }
}
