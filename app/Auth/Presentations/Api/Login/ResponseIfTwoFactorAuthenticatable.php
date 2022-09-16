<?php

namespace App\Auth\Presentations\Api\Login;

use App\Models\User;
use Laravel\Fortify\Events\TwoFactorAuthenticationChallenged;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable as FortifyRedirectIfTwoFactorAuthenticatable;

class ResponseIfTwoFactorAuthenticatable extends FortifyRedirectIfTwoFactorAuthenticatable
{
    /**
     * @param User $user
     */
    protected function twoFactorChallengeResponse($request, $user)
    {
        TwoFactorAuthenticationChallenged::dispatch($user);

        return response()->json(['two_factor' => true]);
    }
}
