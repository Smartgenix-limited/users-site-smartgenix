<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyerRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['market_place_id', 'request_user_id', 'quantity'];

    protected $with = ['request_user'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function market_place()
    {
        return $this->belongsTo(MarketPlace::class, 'market_place_id');
    }

    public function request_user()
    {
        return $this->belongsTo(User::class, 'request_user_id');
    }
}
