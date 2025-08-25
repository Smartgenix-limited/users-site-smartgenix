<?php

namespace App\Models;

use App\Traits\ActiveGarage;
use App\Traits\AddGarage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MotAppointment extends Model
{
    use HasFactory, AddGarage, SoftDeletes;

    protected $fillable = [
        'user_id',
        'car_id',
        'datetime',
        'payment',
        'payment_id',
        'status',
        'price',
        'test_number', 'is_reminder', 'completed_at'
    ];

    protected $casts = [
        'datetime' => 'datetime',
        'completed_at' => 'datetime',
    ];

    protected $with = ['car'];

    public function garage()
    {
        return $this->belongsTo(Garage::class);
    }

    public function car()
    {
        return $this->belongsTo(CarInfo::class, 'car_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mot_task()
    {
        return $this->hasOne(MotTask::class);
    }
}
