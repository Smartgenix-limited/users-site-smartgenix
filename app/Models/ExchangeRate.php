<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    use HasFactory;

    protected $connection = 'support';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['country', 'country_code', 'currency_code', 'currency_sign', 'rate'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'rate' => 'float',
    ];
}
