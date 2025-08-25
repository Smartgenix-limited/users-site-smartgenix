<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarProduct extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['make', 'model', 'varient', 'engine_size', 'body_type', 'transmition', 'fuel_type', 'colour', 'reg_date', 'mileage', 'condition', 'vehicle_type', 'vehicle_seats', 'features'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'reg_date' => 'date',
        'features' => 'array'
    ];
}
