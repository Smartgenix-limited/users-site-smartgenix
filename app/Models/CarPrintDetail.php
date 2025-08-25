<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarPrintDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        // 'user_id',
        'car_id',
        'payment_id',
        'datetime',
        'details',
        // 'status',
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
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}