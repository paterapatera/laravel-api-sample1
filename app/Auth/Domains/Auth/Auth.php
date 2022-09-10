<?php

namespace App\Auth\Domains\Auth;

use App\Models\User;
use RuntimeException;

class Auth
{
    public ?TwoFactorRecoveryCodes $twoFactorRecoveryCodes;
    public ?TwoFactorSecret $twoFactorSecret;

    public function __construct(
        public Email $email,
        public Password $password,
        public User $user,
    ) {
    }

    public function replaceRecoveryCode(TwoFactorRecoveryCode $code, TwoFactorRecoveryCode $newCode): self
    {
        if (!is_null($this->twoFactorRecoveryCodes)) {
            $this->twoFactorRecoveryCodes = $this->twoFactorRecoveryCodes->replaceRecoveryCode($code, $newCode);
        }

        return $this;
    }

    /**
     * @return array{TwoFactorSecret, TwoFactorRecoveryCodes}
     */
    public function getTwoFactor(): array
    {
        if (is_null($this->twoFactorRecoveryCodes) || is_null($this->twoFactorSecret)) {
            throw new RuntimeException('2段階認証が無効になっているので取得できません');
        }

        return [$this->twoFactorSecret, $this->twoFactorRecoveryCodes];
    }
}
