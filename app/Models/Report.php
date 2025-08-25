<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'reportable_id', 'reportable_type', 'reason', 'action_type', 'review'];

    public function reportable()
    {
        return $this->morphTo();
    }
}
