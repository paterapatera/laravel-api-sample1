<?php

namespace App\Auth\Presentations\Api\TwoFactorChallenge;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\TwoFactorLoginResponse;

class Response implements TwoFactorLoginResponse
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        /** @var User */
        $user = auth()->user();
        return new JsonResponse(['token' => $user->createToken('login')->plainTextToken], 200);
    }
}
