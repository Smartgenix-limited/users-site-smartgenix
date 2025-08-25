<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ScrapeService
{
    // creating stripe user
    public function scrapping($reg_number)
    {
        try {
            $response = Http::get('https://scrape.smartgenix.co.uk/insert.php?number_plate=' . $reg_number)->json();

            if ($response) {
                $response['last_mot_date'] = '';
                $response['tax_paid_at'] = '';

                $mots = Http::get('https://scrape.smartgenix.co.uk/insert_mot.php?number_plate=' . $reg_number)->json();
                if ($mots && isset($mots['mot_test_detail']) && count($mots['mot_test_detail']) > 0) {
                    $last_mot_expiry = str_replace('.', '-', $mots['mot_test_detail'][0]['mot_expiry_date']);
                    if ($last_mot_expiry !== 'N/A') {
                        $response['last_mot_date'] = carbon($last_mot_expiry)->subYear()->format('Y-m-d');
                    }
                }

                $tax_date = $response['TAXExpiresDate'];
                if ($tax_date) {
                    if (str()->of($tax_date)->contains('✗')) {
                        $days = (int) substr($tax_date, -12, 3);
                        $response['tax_paid_at'] = now()->subDays($days)->subYear()->format('Y-m-d');
                    } else {
                        $days = (int) substr($tax_date, -13, 3);
                        $response['tax_paid_at'] = now()->addDays($days)->subYear()->format('Y-m-d');
                    }
                }

                return $response;
            }

            return false;
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }

    }
}
