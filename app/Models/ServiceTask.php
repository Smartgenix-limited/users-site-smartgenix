<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceTask extends Model
{
    use HasFactory;

    // protected $fillable = ['service_id', 'tasks', 'images', 'videos', 'message'];
    protected $fillable = ['service_appointment_id', 'task', 'files'];

    protected $casts = [
        'files' => 'array',
    ];

    public function service_appointment()
    {
        return $this->belongsTo(ServiceAppointment::class, 'service_appointment_id');
    }
}
