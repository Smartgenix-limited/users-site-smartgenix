<?php

namespace App\Models;

use App\Traits\AddGarage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarInfo extends Model
{
    use HasFactory, AddGarage;

    protected $fillable = [
        'user_id', 'garage_id', 'car_name', 'model', 'year', 'reg', 'colour', 'mileage', 'image', 'last_service_date', 'last_mot_date', 'mot_reminder', 'service_reminder', 'tax_paid_at'
    ];

    protected $casts = [
        'last_service_date' => 'date',
        'last_mot_date' => 'date',
        'tax_paid_at' => 'date',
    ];

    public function getNameAttribute()
    {
        return $this->car_name . ' ' . $this->model;
    }

    public function garage()
    {
        return $this->belongsTo(Garage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // car mots
    public function mots()
    {
        return $this->hasMany(MotAppointment::class, 'car_id');
    }

    // car services
    public function services()
    {
        return $this->hasMany(ServiceAppointment::class, 'car_id');
    }

    // car repairs
    public function repairs()
    {
        return $this->hasMany(RepairAppointment::class, 'car_id');
    }

    // car recoveries
    public function recoveries()
    {
        return $this->hasMany(Recovery::class, 'car_id');
    }
}
