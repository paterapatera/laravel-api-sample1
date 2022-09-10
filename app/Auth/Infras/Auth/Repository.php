<?php

namespace App\Auth\Infras\Auth;

use App\Auth\Domains\Auth\Auth;
use App\Auth\Domains\Auth\Email;
use App\Auth\Domains\Auth\Repository as AuthRepository;
use App\Models\User;
use Illuminate\Validation\UnauthorizedException;
use Laravel\Sanctum\NewAccessToken;
use Laravel\Sanctum\PersonalAccessToken;

class Repository implements AuthRepository
{
    public function createToken(string $key): NewAccessToken
    {
        /** @var ?User */
        $user = auth()->user();
        throw_if(is_null($user), new UnauthorizedException());

        return $user->createToken($key);
    }

    public function getToken(): PersonalAccessToken
    {
        /** @var ?User */
        $user = auth()->user();
        throw_if(is_null($user), new UnauthorizedException('user not found'));

        /** @var ?PersonalAccessToken */
        $token = $user->tokens()->first();
        throw_if(is_null($token), new UnauthorizedException('token not found'));

        return $token;
    }

    public function deleteAllTokens(): void
    {
        /** @var ?User */
        $user = auth()->user();
        throw_if(is_null($user), new UnauthorizedException());

        $user->tokens()->delete();
    }

    public function findByEmail(Email $email): Auth
    {
        return User::toDomain(User::where('email', $email->value())->firstOrFail());
    }
}
