<?php

namespace App\Models;

use App\Traits\ActiveGarage;
use App\Traits\AddGarage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarHistoryRequest extends Model
{
    use HasFactory, ActiveGarage, AddGarage;

    protected $fillable = [
        'garage_id', 'user_id', 'car_id', 'payment_id', 'datetime', 'status',
    ];


    protected function serializeDate($date)
    {
        return $date->format('Y-m-d');
    }

    public function car()
    {
        return $this->belongsTo(CarInfo::class, 'car_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
