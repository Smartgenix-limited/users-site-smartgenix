<?php

namespace App\Models;

use App\Traits\ActiveGarage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory, ActiveGarage;

    protected $fillable = [
        'user_id', 'garage_id', 'type', 'amount', 'stripe_id', 'transaction_id', 'promo_code', 'currency'
    ];

    protected $casts = [
        'datetime' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
