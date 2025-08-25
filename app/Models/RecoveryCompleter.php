<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecoveryCompleter extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'recovery_id', 'quote_user_id', 'completed_at', 'price', 'time_to_come'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function recovery()
    {
        return $this->belongsTo(Recovery::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'quote_user_id');
    }
}
