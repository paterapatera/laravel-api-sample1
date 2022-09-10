<?php

namespace App\Auth\Applications\Login;

use Laravel\Sanctum\PersonalAccessToken;

class Output
{
    public bool $twoFactor = false;
    public function __construct(public PersonalAccessToken $token)
    {
    }
}
