<div class="row">
    @if (count($sponsered_products) == 0 &&
            count($sponsered_cars) == 0 &&
            count($car_products) == 0 &&
            count($other_products) == 0)
        <div class="col-12">
            <span class="fw-semibold">{{ trans('marketplace.no_product') }}</span>
        </div>
    @else
        <div class="col-12">
            <div class="row justify-content-center">
                <div class="col-md-9 d-flex align-items-center border rounded position-relative bg-white">
                    <span class="">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control form-control-sm border-0" placeholder="Search for a product"
                        wire:model="search">
                    {{-- @if ($this->cannot_search()) text-danger @endif --}}
                    <span class="cursor-pointer fs-18 " title="Filters" wire:click="toggleShowFilters">
                        <i class="bi bi-list"></i>
                    </span>
                </div>
                <div class="dropdown-menu-search @if ($show_filters) show search-show @endif">
                    @foreach ($search_filters as $filter)
                        <span class="dropdown-item d-block">
                            <div class="custom-control custom-checkbox small">
                                <input type="checkbox" class="custom-control-input" value="{{ $filter }}"
                                    id="{{ $filter }}" wire:model="filters">
                                <label class="custom-control-label" for="{{ $filter }}"
                                    style="padding-top:4px;">{{ trans('marketplace.' . $filter) }}</label>
                            </div>
                        </span>
                    @endforeach
                </div>
                {{-- @if ($this->cannot_search())
                    <div class="col-md-9">
                        <small class="text-danger">{{ trans('marketplace.select_filter') }}</small>
                    </div>
                @endif --}}
            </div>
        </div>

        <div wire:click="closeFiltersIfShow" class="col-12">
            @if ($search === '')
                {{-- sponsered products --}}
                @if (count($sponsered_products) > 0)
                    <div class="center-between mt-4 mb-2 px-0">
                        <h4>{{ trans('marketplace.sponsered') }}</h4>
                        <a href="{{ route('marketplace.details', 'sponsered') }}" class="fs-25 text-genix">
                            <i class="bi bi-arrow-right-short"></i>
                        </a>
                    </div>
                    <div class="col-md-12">
                        <div class="row gap-5">
                            @foreach ($sponsered_products as $product)
                                <x-product-show :product="$product" :currency="$currency" />
                            @endforeach
                        </div>
                    </div>
                @endif

                @if (count($sponsered_cars) > 0)
                    {{-- sponsered car products --}}
                    <div class="center-between mt-4 mb-2 px-0">
                        <h4>{{ trans('marketplace.spon_car') }}</h4>
                        <a href="{{ route('marketplace.details', 'sponsered_cars') }}" class="fs-25 text-genix">
                            <i class="bi bi-arrow-right-short"></i>
                        </a>
                    </div>
                    <div class="col-md-12">
                        <div class="row gap-5">
                            @foreach ($sponsered_cars as $car)
                                <x-product-show :product="$car" :currency="$currency" />
                            @endforeach
                        </div>
                    </div>
                @endif

                @if (count($car_products) > 0)
                    {{-- may like products --}}
                    <div class="center-between mt-4 mb-2 px-0">
                        <h4>{{ trans('marketplace.may_like') }}</h4>
                        <a href="{{ route('marketplace.details', 'likes') }}" class="fs-25 text-genix">
                            <i class="bi bi-arrow-right-short"></i>
                        </a>
                    </div>
                    <div class="col-md-12">
                        <div class="row gap-5">
                            @foreach ($car_products as $other)
                                <x-product-show :product="$other" :currency="$currency" />
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- other products by sub category base --}}
                @foreach ($other_products as $name => $products)
                    @if (count($products) > 0)
                        <div class="center-between mt-4 mb-2 px-0">
                            <h4 class="text-capitalize">{{ $name }}</h4>
                            <a href="{{ route('marketplace.details', $name) }}" class="fs-25 text-genix">
                                <i class="bi bi-arrow-right-short"></i>
                            </a>
                        </div>
                        <div class="col-md-12">
                            <div class="row gap-5">
                                @foreach ($products as $product)
                                    @if ($loop->index < 7)
                                        <x-product-show :product="$product->market" :currency="$currency" />
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                {{-- search products --}}
                <div class="col-12 mt-5">
                    <div class="row justify-content-center">
                        <div class="col-md-9">
                            <div class="row">
                                @forelse ($search_products as $product)
                                    <x-search-product :product="$product" :currency="$currency" />

                                @empty

                                    <div class="col-md-10 offset-md-1">
                                        <span
                                            class="fw-semibold pl-md-2">{{ trans('marketplace.no_product_found') }}</span>
                                    </div>
                                @endforelse
                            </div>
                        </div>


                    </div>
                </div>
            @endif
        </div>
    @endif

</div>
