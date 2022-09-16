<?php

namespace App\Auth\Presentations\Api\TwoFactorChallenge;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\FailedTwoFactorLoginResponse;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;
use Laravel\Fortify\Contracts\TwoFactorLoginResponse;
use Laravel\Fortify\Events\RecoveryCodeReplaced;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController as FortifyTwoFactorAuthenticatedSessionController;

class TwoFactorAuthenticatedSessionController extends FortifyTwoFactorAuthenticatedSessionController
{
    /**
     * @return mixed
     */
    public function store(Request $request)
    {
        if (!$this->guard->attempt(
            $request->only(Fortify::username(), 'password'),
            $request->boolean('remember')
        )) {
            return app(FailedTwoFactorLoginResponse::class)->toResponse($request);
        }

        /** @var User */
        $user = auth()->user();


        if ($request->recovery_code) {
            $code = collect($user->recoveryCodes())->first(function (mixed $code) use ($request) {
                return hash_equals(strval($request->recovery_code), strval($code));
            });
            if ($code) {
                $user->replaceRecoveryCode($code);

                event(new RecoveryCodeReplaced($user, $code));
            }
        } elseif ($request->code) {
            $result = app(TwoFactorAuthenticationProvider::class)->verify(
                strval(decrypt(strval($user->two_factor_secret))),
                strval($request->code)
            );
            if (!$result) {
                return app(FailedTwoFactorLoginResponse::class)->toResponse($request);
            }
        } else {
            return app(FailedTwoFactorLoginResponse::class)->toResponse($request);
        }

        $this->guard->login($user, false);

        return app(TwoFactorLoginResponse::class);
    }
}
