<?php

namespace App\Auth\Applications\Login;

use App\Auth\Domains\Auth\Repository;

class Service
{
    public function __construct(
        private Repository $authRepository,
    ) {
    }

    public function run(): Output
    {
        return new Output(
            token: $this->authRepository->getToken()
        );
    }
}
