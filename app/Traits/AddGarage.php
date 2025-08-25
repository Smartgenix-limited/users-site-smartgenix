<?php

namespace App\Traits;

trait AddGarage
{
    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->garage_id = active_garage();
        });
    }
}
