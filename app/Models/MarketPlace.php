<?php

namespace App\Models;

use App\Traits\AddGarage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Builder;

class MarketPlace extends Model
{
    use HasFactory, HasSlug;

    protected static function booted()
    {
        static::addGlobalScope('location', function (Builder $builder) {
            $builder->where('location', code_to_country(user_log()->country));
        });
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'product_id', 'car_product_id', 'payment_id', 'price', 'title', 'description', 'is_promoted', 'is_search_promoted', 'end_promotion', 'status', 'images', 'slug', 'location', 'quantity', 'show_number'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'end_promotion' => 'date',
        'sold_at' => 'datetime',
        'images' => 'array',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function car()
    {
        return $this->belongsTo(CarProduct::class, 'car_product_id');
    }

    public function buyer_requests()
    {
        return $this->hasMany(BuyerRequest::class);
    }

    public function buyers()
    {
        return $this->hasMany(MarketPlaceBuyer::class);
    }
}
