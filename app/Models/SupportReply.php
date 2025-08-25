<?php

namespace App\Models;

use App\Enums\SupportType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportReply extends Model
{
    use HasFactory;

    protected $connection = 'support';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['type', 'user_id', 'support_id', 'message', 'attachments'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'attachments' => 'array',
    ];

    protected $with = ['user:id,first_name,last_name', 'support_user:id,role_id,first_name,last_name'];

    /**
     * Get the user of reply.
     */
    public function user()
    {
        return $this->setConnection('mysql')->belongsTo(User::class);
    }

    /**
     * Get the user of reply.
     */
    public function support_user()
    {
        return $this->belongsTo(SupportUser::class, 'user_id');
    }

    /**
     * Get the support of reply.
     */
    public function support()
    {
        return $this->belongsTo(Support::class);
    }
}
