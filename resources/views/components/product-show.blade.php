@props(['product', 'currency'])

<div class="col-sm-4 col-md-3 col-lg-2 bg-white p-2 mb-2">
    <a href="{{ route('marketplace.show', $product->slug) }}"
        class="text-genix text-decoration-none d-flex justify-content-center align-content-center flex-column product ">
        <img src="{{ $product->images[0] }}" alt="product image" class="img-75 rounded" />
        <p class="pt-2 mb-1 text-center text-md">{{ str()->limit($product->title, 50, '-') }}</p>
        <span
            class="fw-semibold d-block pb-1 text-center">{{ $currency }}{{ number_format($product->price, 2, '.', ',') }}</span>
    </a>
</div>
