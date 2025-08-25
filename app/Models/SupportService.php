<?php

namespace App\Models;

use App\Enums\SupportDepartment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportService extends Model
{
    use HasFactory;

    protected $connection = 'support';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['department', 'service'];

    public static function departments()
    {
        return [SupportDepartment::Billing, SupportDepartment::Feature, SupportDepartment::Sales, SupportDepartment::Support];
    }
}
