<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory;

    protected $connection = 'support';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'type', 'department', 'priority', 'service_type', 'subject', 'status', 'is_flag'];


    /**
     * Get the user of support.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the replies for support tickets.
     */
    public function replies()
    {
        return $this->hasMany(SupportReply::class);
    }


    public static function departments()
    {
        return ['support', 'billing', 'sales', 'feature'];
    }

    public static function periorities()
    {
        return ['low', 'medium', 'high'];
    }
}
