<?php

namespace App\Services;

use App\Mail\Product as MailProduct;
use App\Models\CarProduct;
use App\Models\MarketPlace;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MarketPlaceService
{
    public function create(Request $request)
    {
        // dd($request->all());
        if ($request->type === 'car') {
            $product = CarProduct::create($request->except(['_token']));
        } else {
            $product = Product::create(['name' => $request->product_name] + $request->except(['_token']));
        }

        if ($request->promote === '1' || $request->search_promote === '1') {
            $end_promotion = now()->addDays(7);
        } else {
            $end_promotion = null;
        }

        $market = MarketPlace::create([
            'user_id' => auth()->id(),
            'product_id' => $request->type !== 'car' ? $product->id : null,
            'car_product_id' => $request->type === 'car' ? $product->id : null,
            'payment_id' => $request->payment_id,
            'price' => $request->price,
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'is_promoted' => $request->promote === '1' ? true : false,
            'is_search_promoted' => $request->search_promote === '1' ? true : false,
            'end_promotion' => $end_promotion,
            'show_number' => $request->show_number === 'on' ? true : false,
            'images' => json_decode($request->images)
        ]);

        Mail::to(request()->user())->send(new MailProduct($market, 'selling', request()->user()));

        return true;
    }


    public function update($market, $request)
    {
        if ($market->product) {
            $market->product()->update(['name' => $request->product_name] + $request->only(['brand', 'brand_number', 'grade', 'category', 'sub_category', 'ean', 'quantity', 'condition']));
        } else {
            $market->car()->update($request->only(['make', 'model', 'varient', 'engine_size', 'body_type', 'transmition', 'fuel_type', 'colour', 'reg_date', 'mileage', 'condition', 'vehicle_type', 'vehicle_seats', 'features']));
        }

        if ($request->promote === '1' || $request->search_promote === '1') {
            if ($market->is_promoted || $market->is_search_promoted) {
                $end_promotion = $market->end_promotion;
            } else {
                $end_promotion = now()->addDays(7);
            }
        } else {
            $end_promotion = null;
        }

        $market->update([
            'user_id' => auth()->id(),
            'product_id' => $request->type !== 'car' ? $market->product_id : null,
            'car_product_id' => $request->type === 'car' ? $market->car_product_id : null,
            'payment_id' => $request->payment_id ?? $market->payment_id,
            'price' => $request->price,
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'is_promoted' => $request->promote === '1' ? true : false,
            'is_search_promoted' => $request->search_promote === '1' ? true : false,
            'end_promotion' => $end_promotion,
            'show_number' => $request->show_number === 'on' ? true : false,
            'images' => json_decode($request->images)
        ]);

        return true;
    }
}
