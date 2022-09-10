<?php

namespace App\Auth\Domains;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

interface ValueObject extends Jsonable, JsonSerializable
{
}
