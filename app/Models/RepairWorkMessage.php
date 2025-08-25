<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepairWorkMessage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'repair_appointment_id',
        'task',
        'description',
        'images',
        'videos',
    ];

    // protected $with = ['repair_appointment'];

    protected $casts = [
        'images' => 'array',
        'videos' => 'array',
    ];

    public function repair_appointment()
    {
        return $this->belongsTo(RepairAppointment::class);
    }
}
