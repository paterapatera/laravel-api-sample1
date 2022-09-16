<?php

namespace App\Auth\Presentations\Api\Logout;

use App\Http\Controllers\ApiController;
use App\Http\Responses\Api;
use App\Models\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\JsonResponse;

class Controller extends ApiController
{
    public function __construct(
        private StatefulGuard $guard
    ) {
    }

    public function __invoke(): JsonResponse
    {
        /** @var User */
        $user = auth()->user();
        $user->tokens()->delete();
        $this->guard->logout();
        return Api::noContent();
    }
}
