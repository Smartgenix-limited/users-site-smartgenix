@props(['product', 'currency'])

<div class="col-md-10 bg-white p-2 mb-2">
    <a href="{{ route('marketplace.show', $product->slug) }}" class="text-genix text-decoration-none ">
        <div class="row">
            <div class="col-md-4">
                <img src="{{ $product->images[0] }}" alt="product image" class="img-fluid rounded" />
            </div>
            <div class="col-md-8">
                <p class="pt-2 mb-1 text-md">{{ $product->title }}</p>
                <p class="text-muted">{{ str()->limit($product->description, 100) }}</p>
                <span
                    class="font-weight-bolder d-block pb-1">{{ $currency }}{{ number_format($product->price, 2, '.', ',') }}</span>
            </div>
        </div>
    </a>

</div>
