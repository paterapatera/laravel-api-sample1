<?php

namespace App\Auth\Presentations\Api\Login;

use App\Auth\Applications\Login\Output;

class ResponseMapper
{
    static public function toResponse(Output $output): array
    {
        return [
            'token' => $output->token,
            'twoFactor' => $output->twoFactor,
        ];
    }
}
