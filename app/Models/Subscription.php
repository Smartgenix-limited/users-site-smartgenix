<?php

namespace App\Models;

use App\Traits\ActiveGarage;
use App\Traits\AddGarage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory, AddGarage, ActiveGarage;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['garage_id', 'user_id', 'membership_id', 'mots', 'services', 'repairs', 'expired_at', 'payment_id', 'recoveries'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'create_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Membership::class, 'membership_id');
    }
}
