<?php

namespace App\Auth\Domains\Auth;

use Laravel\Sanctum\NewAccessToken;
use Laravel\Sanctum\PersonalAccessToken;

interface Repository
{
    public function createToken(?string $key = null): NewAccessToken;
    public function getToken(): PersonalAccessToken;
    public function deleteAllTokens(): void;
    public function findByEmail(Email $email): Auth;
}
