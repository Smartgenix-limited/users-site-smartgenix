<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recovery extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'garage_id', 'user_id', 'car_id', 'description', 'location', 'latitude', 'longitude', 'nearby_places', 'type', 'roadside_assistance', 'payment_type', 'status', 'approved', 'price', 'payment_id'
    ];

    protected $with = ['car'];

    public function car()
    {
        return $this->belongsTo(CarInfo::class, 'car_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quotes()
    {
        return $this->hasMany(RecoveryQuote::class);
    }

    public function completer()
    {
        return $this->hasOne(RecoveryCompleter::class);
    }

    public function comments()
    {
        return $this->hasMany(RecoveryComment::class)->latest();
    }
}
