<?php

namespace App\Auth\Presentations\Api\Login;

use App\Auth\Applications\Login\Service;
use App\Http\Controllers\ApiController;
use App\Http\Responses\Api;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Pipeline;
use Laravel\Fortify\Actions\AttemptToAuthenticate;
use Laravel\Fortify\Actions\EnsureLoginIsNotThrottled;
use Laravel\Fortify\LoginRateLimiter;

class Controller extends ApiController
{
    public function __construct(
        private Service $service,
        private LoginRateLimiter  $limiter
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        /** @var JsonResponse */
        return (new Pipeline(app()))->send($request)->through(array_filter([
            EnsureLoginIsNotThrottled::class,
            ResponseIfTwoFactorAuthenticatable::class,
            AttemptToAuthenticate::class,
            [$this, 'clearLimiter'],
        ]))->then(function () {
            return Api::ok(ResponseMapper::toResponse($this->service->run()));
        });
    }

    public function clearLimiter(Request $request, callable $next): mixed
    {
        $this->limiter->clear($request);
        return $next($request);
    }
}