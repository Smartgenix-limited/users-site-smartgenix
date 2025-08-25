<?php

namespace App\Models;

use App\Traits\ActiveGarage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory, ActiveGarage;

    protected $fillable = ['name', 'value'];
}
