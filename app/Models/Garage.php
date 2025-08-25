<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Garage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', 'user_role', 'name', 'country', 'city', 'address', 'telephone', 'postcode', 'opening', 'closing', 'out_of_hour_response', 'status', 'vehicles', 'services'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'opening' => 'datetime',
        'closing' => 'datetime',
        'vehicles' => 'array',
        'services' => 'array',
    ];


    /**
     * get user of garage
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * get reviews of garage
     *
     */
    public function reviews()
    {
        return $this->hasMany(Review::class)->latest();
    }

    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }
}
