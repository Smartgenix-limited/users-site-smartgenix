<?php

namespace App\Services;

use Stevebauman\Location\Facades\Location;
use Stripe;

class UserService
{
    // creating stripe user
    public function create_stripe_user($data)
    {
        Stripe\Stripe::setApiKey(support_setting('stripe_secret'));
        $customer = Stripe\Customer::create(array(
            "address" => [
                "city" => $data['city'],
                "country" => $data['country'],
            ],
            "email" => $data['email'],
            "phone" => $data['mobile'],
            "name" => $data['first_name'] . ' ' . $data['last_name'],
            "source" => $data['token'],
        ));

        return $customer->id;
    }

    // create user log
    public function create_log()
    {
        $requestIP = request()->ip();
        // UK=>31.28.95.255,USA=>100.42.239.255,'Qatar=>80.76.175.255,KSA=>102.177.190.255
        $ip = str_contains($requestIP, '::') ? '100.42.239.255' : $requestIP;
        $position = Location::get($ip);

        request()->user()->user_logs()->create([
            'ip' => $position ? $position->ip : $ip,
            'country' => $position ? $position->countryCode : 'GB',
            'region' => $position ? $position->regionName : 'England',
            'city' => $position ? $position->cityName : 'Stevenage',
            'postal' => $position ? $position->zipCode : 'SG1',
            'latitude' => $position ? $position->latitude : '51.9022',
            'longitude' => $position ? $position->longitude : '-0.2026',
            'timezone' => $position ? $position->timezone : 'Europe/London',
        ]);

        return true;
    }
}
