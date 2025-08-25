<?php

namespace App\Http\Controllers;

use App\Enums\ProductStatus;
use App\Mail\Product;
use App\Models\BuyerRequest;
use App\Models\MarketPlace;
use App\Models\User;
use App\Notifications\BuyerRequestApprovedNotification;
use App\Notifications\BuyerRequestNotification;
use App\Services\MarketPlaceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MarketPlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('marketplace.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('marketplace.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, MarketPlaceService $service)
    {
        $service->create($request);

        return back()->with('success', trans('marketplace.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($market)
    {
        $market = MarketPlace::withoutGlobalScope('location')->whereSlug($market)->first();
        if (!$market) {
            abort(404);
        }

        // dd($market->product_id);
        if ($market->product_id) {
            $market->load(['product', 'user', 'buyer_requests', 'buyers']);
        } else {
            $market->load(['car', 'user', 'buyer_requests', 'buyers']);
        }

        return view('marketplace.show', compact('market'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function details($type)
    {
        if ($type === 'sponsered') {
            $products = MarketPlace::where('status', ProductStatus::UnSold)->where('is_promoted', true)->whereNotNull('product_id')->get();
        } elseif ($type === 'sponsered_cars') {
            $products = MarketPlace::where('status', ProductStatus::UnSold)->where('is_promoted', true)->whereNotNull('car_product_id')->get();
        } elseif ($type === 'likes') {
            $products = MarketPlace::where('status', ProductStatus::UnSold)->where('is_promoted', false)->whereNull('product_id')->get();
        } else {
            $products = MarketPlace::whereRelation('product', 'sub_category', $type)->where('status', ProductStatus::UnSold)->where('is_promoted', false)->whereNull('car_product_id')->get();
        }

        return view('marketplace.details', compact('products', 'type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($market)
    {
        $market = MarketPlace::withoutGlobalScope('location')->whereSlug($market)->first();
        if (!$market) {
            abort(404);
        }

        $market->load(['car', 'product']);
        return view('marketplace.edit', compact('market'));
    }

    /**
     * Update the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $market, MarketPlaceService $service)
    {
        $market = MarketPlace::withoutGlobalScope('location')->whereSlug($market)->first();
        if (!$market) {
            abort(404);
        }

        $market->load(['car', 'product']);
        $service->update($market, $request);

        return to_route('marketplace.edit', $market)->with('success', trans('marketplace.update_success'));
    }

    /**
     * Buy the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function buy(Request $request)
    {
        $market = MarketPlace::find($request->market_id);

        BuyerRequest::create([
            'market_place_id' => $market->id,
            'request_user_id' => auth()->id(),
            'quantity' => $request->quantity
        ]);
        $market->user->notify(new BuyerRequestNotification($market->user->name, $market));
        Mail::to(request()->user())->send(new Product($market, 'buying', request()->user()));

        return back()->with('success', trans('marketplace.buyer'));
    }

    /**
     * Sold the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MarketPlace $market
     * @return \Illuminate\Http\Response
     */
    public function sold(Request $request, MarketPlace $market)
    {
        $market->buyers()->create([
            'seller_id' => $market->user_id,
            'buyer_id' => $request->buyer_id,
            'quantity' => $request->quantity,
            'price' => $request->quantity * $market->price,
        ]);

        if ($market->product_id) {
            $market->product()->update([
                'quantity' => $market->product->quantity - $request->quantity
            ]);
        }

        // check weather product is completely sold or not
        $total_sold_quantities = (int)$market->buyers()->sum('quantity');
        $product_quantities = $market->product_id ? (int)$market->product->quantity : 1;

        if ($total_sold_quantities === $product_quantities) {
            $market->update([
                'status' => ProductStatus::Sold,
            ]);
        }

        $buyer = User::select(['id', 'first_name', 'last_name', 'type', 'email'])->find($request->buyer_id);
        $url = reply_url($buyer->type, $market->slug, 'marketplace');
        $buyer->notify(new BuyerRequestApprovedNotification($buyer->name, $url));

        BuyerRequest::find($request->request_id)->delete();

        return back()->with('success', trans('marketplace.solded'));
    }

    public function myplace()
    {
        return view('marketplace.myplace');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
