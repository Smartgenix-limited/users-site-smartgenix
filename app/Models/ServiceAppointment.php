<?php

namespace App\Models;

use App\Traits\ActiveGarage;
use App\Traits\AddGarage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceAppointment extends Model
{
    use HasFactory, AddGarage, SoftDeletes;

    protected $fillable = [
        'user_id',
        'datetime',
        'car_id',
        'payment',
        'payment_id',
        'status',
        'price',
        'type_of_service', 'is_reminder', 'completed_at'
    ];

    protected $casts = [
        'datetime' => 'datetime',
        'completed_at' => 'datetime',
    ];

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

    // service tasks
    public function tasks()
    {
        return $this->hasMany(ServiceTask::class);
    }
}
