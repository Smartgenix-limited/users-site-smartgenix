@extends('layouts.app')

@section('content')
    <div class="container page-container">

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    @php
                        if ($type === 'sponsered') {
                            $title = 'Sponsered';
                        } elseif ($type === 'sponsered_cars') {
                            $title = 'Sponsered Cars';
                        } elseif ($type === 'likes') {
                            $title = 'Products you may like';
                        } else {
                            $title = ucfirst($type);
                        }
                        $currency = support_setting('currency_symbol');
                    @endphp

                    @include('partials.card-header', ['title' => $title])
                    <div class="card-body">
                        @include('partials.message')

                        <div class="row">

                            @foreach ($products as $product)
                                <div class="col-sm-12 col-md-6 col-lg-4 mb-2">
                                    <div class="border rounded p-2 d-flex h-100 pb-4">
                                        <a href="{{ route('marketplace.show', $product->slug) }}"
                                            class="text-genix text-decoration-none">
                                            <img src="{{ $product->images[0] }}" alt="product image"
                                                class="img-fluid h-75 rounded">
                                            <p class="pt-3 mb-0 lead">{{ $product->title }}</p>
                                            <span class="fw-semibold lead">{{ $currency }}{{ $product->price }}</span>
                                        </a>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
