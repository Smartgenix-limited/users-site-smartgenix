<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// implements MustVerifyEmail
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type', 'first_name', 'last_name', 'username', 'email', 'password', 'company', 'mobile', 'fcm_token', 'status', 'country', 'city', 'stripe_user_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }


    public function authentic_user()
    {
        return $this->type === UserType::Solo || $this->type === UserType::Trader;
    }
    /**
     * user garage
     */
    public function garage()
    {
        return $this->hasOne(GarageUser::class);
    }

    /**
     * user logs
     */
    public function user_logs()
    {
        return $this->hasMany(UserLog::class)->latest();
    }

    /**
     * user cars
     */
    public function cars()
    {
        return $this->hasMany(CarInfo::class);
    }

    // user mots
    public function mots()
    {
        return $this->hasMany(MotAppointment::class);
    }

    // user services
    public function services()
    {
        return $this->hasMany(ServiceAppointment::class);
    }

    // user repairs
    public function repairs()
    {
        return $this->hasMany(RepairAppointment::class);
    }

    // user recoveries
    public function recoveries()
    {
        return $this->hasMany(Recovery::class);
    }

    // user communities
    public function communities()
    {
        return $this->hasMany(Community::class);
    }

    // user communities
    public function comments()
    {
        return $this->hasMany(CommunityComment::class);
    }

    // user communities
    public function markets()
    {
        return $this->hasMany(MarketPlace::class);
    }

    // user tickets
    public function tickets()
    {
        return $this->hasMany(Support::class);
    }

    // user membership subscription
    public function subscription()
    {
        return $this->hasOne(Subscription::class)->where('expired_at', '>', now());
    }

    // user block period
    public function block_period()
    {
        return $this->hasOne(BlockPeriod::class);
    }

    // user quotes
    // public function quotes()
    // {
    //     return $this->hasMany(RepairAppointment::class)->where('job_approval', 'pending');
    // }
}
