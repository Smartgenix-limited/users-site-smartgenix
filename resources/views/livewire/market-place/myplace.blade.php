<div class="row justify-content-center">
    <div class="col-md-6 offset-md-3 cursor-pointer">
        <span class="@if ($type === 'buying') pb-1 text-info border-bottom-genix @endif"
            wire:click="changeType('buying')">{{ trans('marketplace.buying') }}</span>
        <span class="@if ($type === 'bought') pb-1 text-info border-bottom-genix @endif mx-3"
            wire:click="changeType('bought')">{{ trans('marketplace.bought') }}</span>
        <span class="@if ($type === 'selling') pb-1 text-info border-bottom-genix @endif"
            wire:click="changeType('selling')">{{ trans('marketplace.selling') }}</span>
        <span class="@if ($type === 'sold') pb-1 text-info border-bottom-genix @endif ml-3"
            wire:click="changeType('sold')">{{ trans('marketplace.sold') }}</span>
    </div>

    <div class="col-12 mt-5">
        @forelse ($products as $product)
            <div class="row align-items-center mb-3">
                <div class="col-3">
                    <img src="{{ $product->images[0] }}" alt="{{ $product->titile }}" class="img-fluid rounded">
                </div>
                <div class="col-5">
                    @if ($product->product_id)
                        <h6 class="">{{ $product->product->name }}</h6>
                        <h6 class="">{{ $product->product->brand }}</h6>
                        <h6 class="">{{ $product->product->grade }}</h6>
                        <h6 class=" text-capitalize">{{ $product->product->sub_category }}</h6>
                    @else
                        <h6 class="">{{ $product->car->make . ' ' . $product->car->model }}</h6>
                        <h6 class="text-capitalize">{{ $product->car->varient }}</h6>
                        <h6 class="text-capitalize">{{ $product->car->engine_size }}</h6>
                        <h6 class="text-capitalize">{{ $product->car->fuel_type }}</h6>
                    @endif
                </div>
                <div class="col-3">
                    <h6 class="text-capitalize">
                        @if ($type === 'buying')
                            {{ buyer_request($product->id)->created_at->format('d/m/Y h:i A') }}
                        @elseif ($type === 'bought')
                            {{ bought($product->id)->created_at->format('d/m/Y h:i A') }}
                        @else
                            {{ $product->created_at->format('d/m/Y h:i A') }}
                            @if ($type === 'selling')
                                <div class="mt-2">
                                    <a href="{{ route('marketplace.edit', $product) }}"
                                        class="btn btn-sm btn-genix">{{ trans('general.edit', ['type' => '']) }}</a>
                                </div>
                            @endif
                        @endif
                    </h6>
                </div>
                <div class="col-1">
                    <a href="{{ route('marketplace.show', $product) }}" class="fs-25 text-genix">
                        <i class="bi bi-arrow-right-short"></i>
                    </a>
                </div>
            </div>
        @empty
            <h6 class="text-center">No product found</h6>
        @endforelse
    </div>

</div>
