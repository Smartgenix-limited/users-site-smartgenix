<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ServiceNotice extends Model
{
    use HasFactory;

    protected $connection = 'support';

    protected static function booted()
    {
        static::addGlobalScope('no_user', function (Builder $builder) {
            $builder->whereNull('user_id');
        });
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['notice'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function read()
    {
        return $this->setConnection('mysql')->hasMany(ReadNotice::class, 'service_notice_id');
    }
}
