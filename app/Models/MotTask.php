<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'mot_appointment_id', 'tasks', 'mot_status', 'dangerous', 'majors', 'minors', 'advisories'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tasks' => 'json',
        'dangerous' => 'json',
        'majors' => 'json',
        'minors' => 'json',
        'advisories' => 'json',
    ];


    public static function drop_down()
    {
        $data = [
            [
                'name' => 'Horn',
                'value' => 'horn',
            ],
            [
                'name' => 'Front Lights',
                'value' => 'front_lights',
            ],
            [
                'name' => 'Rear Lights',
                'value' => 'rear_lights',
            ],
            [
                'name' => 'Brake Lights',
                'value' => 'brake_lights',
            ],
            [
                'name' => 'Fog Lights',
                'value' => 'fog_lights',
            ],
            [
                'name' => 'Registration Lights',
                'value' => 'registration_lights',
            ],
            [
                'name' => 'Indicators',
                'value' => 'indicators',
            ],
            [
                'name' => 'Mirrors',
                'value' => 'mirrors',
            ],
            [
                'name' => 'Battery',
                'value' => 'battery',
            ],
            [
                'name' => 'Electrical Wiring',
                'value' => 'electrical_wiring',
            ],
            [
                'name' => 'Towbar',
                'value' => 'towbar',
            ],
            [
                'name' => 'Steering wheel',
                'value' => 'steering_wheel',
            ],
            [
                'name' => 'Suspension',
                'value' => 'suspension',
            ],
            [
                'name' => 'Brakes',
                'value' => 'brakes',
            ],
            [
                'name' => 'Tyres and Spare wheel',
                'value' => 'tyres_and_spare_wheel',
            ],
            [
                'name' => 'Seat Belts',
                'value' => 'seat_belts',
            ],
            [
                'name' => 'Car body',
                'value' => 'car_body',
            ],
            [
                'name' => 'Engine mountings',
                'value' => 'engine_mountings',
            ],
            [
                'name' => 'Seats',
                'value' => 'seats',
            ],
            [
                'name' => 'Bonnet',
                'value' => 'bonnet',
            ],
            [
                'name' => 'Boot',
                'value' => 'boot',
            ],
            [
                'name' => 'Doors',
                'value' => 'doors',
            ],
            [
                'name' => 'Registration plate',
                'value' => 'registration_plate',
            ],
            [
                'name' => 'Vin number',
                'value' => 'vin_number',
            ],
            [
                'name' => 'Speedometer',
                'value' => 'speedometer',
            ],
            [
                'name' => 'Exhaust',
                'value' => 'exhaust',
            ],
            [
                'name' => 'Emissions',
                'value' => 'emissions',
            ],
            [
                'name' => 'Wipers',
                'value' => 'wipers',
            ],
            [
                'name' => 'Windscreen washers',
                'value' => 'windscreen_washers',
            ],
            [
                'name' => 'Windscreen',
                'value' => 'windscreen',
            ],
        ];

        return $data;
    }
}
