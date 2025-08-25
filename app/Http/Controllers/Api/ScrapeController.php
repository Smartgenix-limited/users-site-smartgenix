<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ScrapeService;
use Illuminate\Http\Request;

class ScrapeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $response = (new ScrapeService())->scrapping($request->reg_number);

        return response()->json([
            'data' => $response
        ]);
    }
}
