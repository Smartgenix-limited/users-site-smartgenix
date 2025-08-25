<?php

namespace App\Models;

use App\Traits\ActiveGarage;
use App\Traits\AddGarage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory, ActiveGarage;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['garage_id', 'name', 'mots', 'services', 'repairs', 'recoveries', 'features', 'price'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'create_at' => 'datetime',
        'features' => 'array',
    ];

    public function subscribers()
    {
        return $this->hasMany(Subscription::class)->where('expired_at', '>', now());
    }
}
