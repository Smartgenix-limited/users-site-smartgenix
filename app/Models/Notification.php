<?php

namespace App\Models;

use App\Traits\ActiveGarage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory, ActiveGarage;

    protected $fillable = ['title', 'message', 'image', 'promocode', 'start_date', 'end_date', 'discountAmount', 'user_id'];
}
