<?php

namespace App\Auth\Domains;

trait ValueObjectable
{
    public function toJson($options = 0): string
    {
        return json_encode($this) ?: '';
    }
}
