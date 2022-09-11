<?php

namespace App\Auth\Presentations\Api\Login;

use Laravel\Fortify\Events\TwoFactorAuthenticationChallenged;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable as FortifyRedirectIfTwoFactorAuthenticatable;

class ResponseIfTwoFactorAuthenticatable extends FortifyRedirectIfTwoFactorAuthenticatable
{
    protected function twoFactorChallengeResponse($request, $user)
    {
        TwoFactorAuthenticationChallenged::dispatch($user);

        return response()->json(['two_factor' => true]);
    }
}
