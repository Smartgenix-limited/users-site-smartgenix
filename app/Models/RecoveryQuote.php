<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecoveryQuote extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'recovery_id', 'quote_user_id', 'price', 'time_to_come',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'quote_user_id');
    }

    public function recovery()
    {
        return $this->belongsTo(Recovery::class, 'recovery_id');
    }
}
