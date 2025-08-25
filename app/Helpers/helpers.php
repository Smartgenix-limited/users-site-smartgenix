<?php

// latest previous service

use App\Enums\UserType;
use App\Models\BuyerRequest;
use App\Models\Country;
use App\Models\ExchangeRate;
use App\Models\Garage;
use App\Models\GarageReport;
use App\Models\MarketPlaceBuyer;
use App\Models\Report;
use App\Models\Setting;
use App\Models\SupportSetting;
use Carbon\Carbon;
use Illuminate\Support\Str;

if (!function_exists('setting')) {
    function setting($setting_name = Null)
    {
        $setting = Setting::where('name', $setting_name)->first();

        return $setting ? $setting->value : null;
    }
}

// support setting
if (!function_exists('support_setting')) {
    function support_setting($setting_name = Null)
    {
        if ($setting_name === 'currency_symbol') {
            $exchange = ExchangeRate::where('country_code', user_log()?->country)->first();
            if ($exchange) {
                return $exchange->currency_sign;
            }
        }

        if ($setting_name === 'currency_name') {
            $exchange = ExchangeRate::where('country_code', user_log()?->country)->first();
            if ($exchange) {
                return $exchange->currency_code;
            }
        }

        $setting = SupportSetting::where('key', $setting_name)->first();
        return $setting ? $setting->value : null;
    }
}

// active garage id
if (!function_exists('active_garage')) {
    function active_garage()
    {
        return auth()->user()->garage?->garage_id;
    }
}

// active garage
if (!function_exists('garage')) {
    function garage()
    {
        return auth()->user()->garage?->garage;
    }
}

if (!function_exists('hours')) {
    function hours()
    {
        return ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00'];
    }
}

// check weather user has request to buy product
if (!function_exists('is_requested')) {
    function is_requested($market_id)
    {
        $buyer_request = BuyerRequest::where('market_place_id', $market_id)->where('request_user_id', auth()->id())->first();

        return $buyer_request ? true : false;
    }
}

// check weather user has reported
if (!function_exists('is_reported')) {
    function is_reported($type, $id, $other = null)
    {
        $model = '';
        if ($type === 'garage') {
            $model = 'App\Models\Garage';
        } elseif ($type === 'community') {
            $model = 'App\Models\Community';
        } elseif ($type === 'comment') {
            $model = 'App\Models\CommunityComment';
        }

        $result = Report::where('reportable_type', $model)->where('reportable_id', $id)->when(!$other, fn ($q) => $q->where('user_id', auth()->id()))->first();

        return $result ? true : false;
    }
}


// user report reason
if (!function_exists('report_reason')) {
    function report_reason($type, $Id)
    {
        $model = '';
        if ($type === 'garage') {
            $model = 'App\Models\Garage';
        } elseif ($type === 'community') {
            $model = 'App\Models\Community';
        } elseif ($type === 'comment') {
            $model = 'App\Models\CommunityComment';
        }

        return Report::where('reportable_type', $model)->where('reportable_id',  $Id)->where('user_id', auth()->id())->first()->reason;
    }
}

// get the buyer request of user against market place id
if (!function_exists('buyer_request')) {
    function buyer_request($market_id)
    {
        return BuyerRequest::where('market_place_id', $market_id)->where('request_user_id', auth()->id())->first();
    }
}

// get the bought product
if (!function_exists('bought')) {
    function bought($market_id)
    {
        return MarketPlaceBuyer::where('market_place_id', $market_id)->where('buyer_id', auth()->id())->first();
    }
}

// get user logs
if (!function_exists('user_logs')) {
    function user_log()
    {
        return request()->user()?->user_logs()->latest()->first();
    }
}

// check weather has membership subscription
if (!function_exists('is_subscription')) {
    function is_subscription()
    {
        return request()->user()?->subscription ? true : false;
    }
}

// check user subscription
if (!function_exists('subscription')) {
    function subscription()
    {
        return request()->user()?->subscription;
    }
}

// check weather subscriptions has valid mot remaining
if (!function_exists('can_mot')) {
    function can_mot()
    {
        if (is_subscription() && request()->user()?->subscription?->mots != 0) {
            return true;
        } else {
            return false;
        }
    }
}

// check weather subscriptions has valid service remaining
if (!function_exists('can_service')) {
    function can_service()
    {
        if (is_subscription() && request()->user()?->subscription?->services != 0) {
            return true;
        } else {
            return false;
        }
    }
}

// check weather subscriptions has valid repair remaining
if (!function_exists('can_repair')) {
    function can_repair()
    {
        if (is_subscription() && request()->user()?->subscription?->repairs != 0) {
            return true;
        } else {
            return false;
        }
    }
}

// check weather subscriptions has valid recovery remaining
if (!function_exists('can_recovery')) {
    function can_recovery()
    {
        if (is_subscription() && request()->user()?->subscription?->recoveries != 0) {
            return true;
        } else {
            return false;
        }
    }
}

// change the subscription when use
if (!function_exists('update_subscription')) {
    function update_subscription($type)
    {
        request()->user()->subscription()->update([
            $type => --request()->user()->subscription->$type
        ]);
    }
}

// get the quote price
if (!function_exists('quote_price')) {
    function quote_price($price, $quote_by, $percetage)
    {
        $currency = support_setting('currency_symbol');

        if ($percetage != 0 && request()->user()->subscription->garage_id == $quote_by) {
            $discount = $price - $price * ($percetage / 100);
            return "<del>" . $currency . $price . "</del> " . $currency . number_format($discount, 2) . " (" . trans('general.off_price', ['value' => $percetage]) . ")";
        }

        return $currency . $price;
    }
}
// get the discountquote price
if (!function_exists('discount_price')) {
    function discount_price($price)
    {
        $percentage = request()->user()?->subscription?->package?->recovery_percentage;

        if ($percentage != 0) {
            $discount = $price - $price * ($percentage / 100);
            return number_format($discount, 2);
        }

        return $price;
    }
}

// get file path of website files
if (!function_exists('file_url')) {
    function file_url($file)
    {
        return support_setting('app_url') . $file;
    }
}

// get reply sending url
if (!function_exists('reply_url')) {
    function reply_url($user_type, $id, $type = 'communities')
    {
        $support_url = support_setting('app_url');

        if ($user_type === UserType::Solo || $user_type === UserType::Trader) {
            $site_url = str_replace('support', 'users', $support_url);
        }

        if ($user_type === UserType::Admin) {
            $site_url = str_replace('support', 'dashboard', $support_url);
            $type = "admin/" . $type;
        }

        if ($user_type === UserType::Recovery) {
            $site_url = str_replace('support', 'recovery', $support_url);
        }

        if ($user_type === UserType::Enterprise) {
            $site_url = str_replace('support', 'enterprise', $support_url);
        }
        return $site_url . $type . '/' . $id;
    }
}

// get file path of website files
if (!function_exists('hideEmailAddress')) {
    function hideEmailAddress($email)
    {

        $em   = explode("@", $email);
        $em_brand = explode(".", end($em));

        $name = implode('@', array_slice($em, 0, count($em) - 1));
        $brand_name = implode('.', array_slice($em_brand, 0, count($em_brand) - 1));

        $len  = strlen($name);
        $brand_len  = strlen($brand_name);

        return substr($name, 0, 3) . str_repeat('*', $len) . substr($name, 0, 1) . "@" . str_repeat('*', $brand_len) . '.' . end($em_brand);
    }
}
// convert image to base64
if (!function_exists('imageToBase64')) {
    function imageToBase64($image)
    {
        $type = pathinfo($image, PATHINFO_EXTENSION);
        $data = file_get_contents($image);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }
}

// corbon object
if (!function_exists('corbon')) {
    function carbon($date)
    {
        return Carbon::parse($date);
    }
}

// price converter from pound to user local currency
if (!function_exists('convert_price')) {
    function convert_price($price)
    {
        $exchange = ExchangeRate::where('country_code', user_log()->country)->first();
        if ($exchange) {
            $total = $price * $exchange->rate;
            return number_format($total, 2);
        } else {
            return $price;
        }
    }
}

// price reconvert to pound
if (!function_exists('reconvert_price')) {
    function reconvert_price($price)
    {
        $exchange = ExchangeRate::where('country_code', user_log()->country)->first();

        if (!$exchange || is_uk()) {
            return $price;
        } else {
            $total = $price / $exchange->rate;
            return number_format($total, 2);
        }
    }
}

// fetch location with lat and lang
if (!function_exists('fetch_location')) {
    function fetch_location($lat, $lang)
    {
        $apiKey = support_setting('google_map_api_key');

        // Create a stream context to add HTTP headers to the request
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => "Accept-language: en\r\n" .
                    "User-Agent: My PHP Script\r\n"
            ]
        ]);

        // Send the request
        $response = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lang&key=$apiKey", false, $context);

        if ($response === false) {
            die('Error occurred!');
        }

        // Decode the response
        return json_decode($response, true);
    }
}
