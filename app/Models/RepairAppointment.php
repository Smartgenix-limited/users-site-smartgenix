<?php

namespace App\Models;

use App\Traits\ActiveGarage;
use App\Traits\AddGarage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepairAppointment extends Model
{
    use HasFactory, AddGarage, SoftDeletes;

    protected $fillable = [
        'user_id', 'datetime', 'car_id', 'status', 'job_approval', 'payment', 'payment_id', 'price',
    ];

    protected $casts = [
        'datetime' => 'datetime',
    ];

    protected $with = ['car'];

    public function garage()
    {
        return $this->belongsTo(Garage::class);
    }

    public function repair_work_details()
    {
        return $this->hasMany(RepairWorkDetail::class);
    }

    public function repair_work_message()
    {
        return $this->hasOne(RepairWorkMessage::class)->latest();
    }

    public function tasks()
    {
        return $this->hasMany(RepairTask::class);
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
