<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepairTask extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['repair_appointment_id', 'task', 'note', 'files'];

    protected $casts = [
        'files' => 'array',
    ];
}
