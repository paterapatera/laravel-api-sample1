<?php

namespace App\Http\Controllers\Auth\Api\Login;

use App\Auth\Applications\Login\Output;

class ResponseMapper
{
    static public function toResponse(Output $output): array
    {
        return [
            'token' => $output->token->token,
            'twoFactor' => $output->twoFactor,
        ];
    }
}
