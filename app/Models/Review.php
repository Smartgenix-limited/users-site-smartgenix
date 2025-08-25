<?php

namespace App\Models;

use App\Traits\AddGarage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory, AddGarage;

    protected $fillable = [
        'user_id', 'garage_id', 'overall', 'facility', 'appointment', 'car_back', 'rating', 'review', 'reply_by', 'reply', 'replied_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i A',
        'replied_at' => 'datetime:d/m/Y H:i A',
    ];

    /**
     * get user of review
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * get user of review
     *
     */
    public function replied_by()
    {
        return $this->belongsTo(User::class, 'reply_by');
    }
}
