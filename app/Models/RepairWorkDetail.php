<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepairWorkDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'repair_appointment_id',
        'task',
        'description',
        'price',
        'images',
        'videos',
    ];

    protected $casts = [
        'datetime' => 'datetime',
        'images' => 'array',
        'videos' => 'array',
    ];


    public function repair_appointment()
    {
        return $this->belongsTo(RepairAppointment::class);
    }
}
