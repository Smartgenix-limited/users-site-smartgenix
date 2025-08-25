<?php

namespace App\Traits;

use App\Scopes\ActiveGarageScope;

trait ActiveGarage
{
    public static function bootActiveGarage()
    {
        static::addGlobalScope(new ActiveGarageScope);
    }
}
