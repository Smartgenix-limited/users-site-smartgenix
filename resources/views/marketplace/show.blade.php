@extends('layouts.app')

@section('content')
    <div class="container page-container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @include('partials.card-header', ['title' => $market->title])
                    <div class="card-body">
                        @include('partials.message')
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        @foreach ($market->images as $image)
                                            <li data-target="#carouselExampleIndicators" data-slide-to="{{ $loop->index }}"
                                                class="{{ $loop->first ? 'active' : '' }}"></li>
                                        @endforeach

                                    </ol>
                                    <div class="carousel-inner">
                                        @foreach ($market->images as $image)
                                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                <img src="{{ $image }}" class="d-block w-50 mx-auto rounded"
                                                    alt="{{ $market->title }}">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            @if ($market->status !== 'sold')
                                <div class="col-12 text-center mt-5">
                                    <a href="#seller"
                                        class="btn btn-sm btn-genix">{{ trans('marketplace.contact_seller') }}</a>
                                    <a href="#buyNow" class="btn btn-sm btn-genix">{{ trans('marketplace.buy') }}</a>
                                </div>
                            @endif

                            @if ($market->product_id)
                                {{-- product view --}}
                                <div class="col-12 mt-2">
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="center-between">
                                                <h4 class="fw-semibold">{{ trans('marketplace.overview') }}</h4>
                                                @if ($market->status === 'sold')
                                                    <h4 class="fw-semibold text-success">
                                                        {{ trans('marketplace.sold') }}</h4>
                                                @else
                                                    @if (is_requested($market->id))
                                                        <h4 class="fw-semibold text-info">
                                                            {{ trans('marketplace.requested') }}</h4>
                                                    @endif
                                                @endif
                                            </div>

                                            <div class="mb-1 d-flex">
                                                <span
                                                    class="fw-semibold d-block w-25 pl-0">{{ trans('marketplace.name') }}:
                                                </span>
                                                <span class="">{{ $market->product->name }}</span>
                                            </div>
                                            <div class="mb-1 d-flex">
                                                <span
                                                    class="fw-semibold d-block w-25 pl-0">{{ trans('marketplace.price') }}:
                                                </span>
                                                <span
                                                    class="lead font-weight-bold">{{ support_setting('currency_symbol') }}{{ $market->price }}</span>
                                            </div>
                                            <div class="mb-1 d-flex">
                                                <span
                                                    class="fw-semibold d-block w-25 pl-0">{{ trans('marketplace.condition') }}:
                                                </span>
                                                <span class="text-capitalize">{{ $market->product->condition }}</span>
                                            </div>
                                            <div class="mb-1 d-flex">
                                                <span
                                                    class="fw-semibold d-block w-25 pl-0">{{ trans('marketplace.manufacture') }}:
                                                </span>
                                                <span class="">{{ $market->product->brand }}</span>
                                            </div>
                                            <div class="mb-1 d-flex">
                                                <span
                                                    class="fw-semibold d-block w-25 pl-0">{{ trans('marketplace.category') }}:
                                                </span>
                                                <span class="">{{ $market->product->category }}</span>
                                            </div>
                                            <div class="mb-1 d-flex">
                                                <span
                                                    class="fw-semibold d-block w-25 pl-0">{{ trans('marketplace.sub_category') }}:
                                                </span>
                                                <span class="">{{ $market->product->sub_category }}</span>
                                            </div>
                                            <div class="mb-1">
                                                <span
                                                    class="fw-semibold d-block w-25 pl-0 d-block">{{ trans('marketplace.description') }}:
                                                </span>
                                                <span class="">{{ $market->description }}</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @else
                                {{-- car view --}}
                                <div class="col-12 mt-5">
                                    <div class="row align-items-center">
                                        <div class="col-12 text-right">
                                            @if ($market->status === 'sold')
                                                <h3 class="fw-semibold text-success">
                                                    {{ trans('marketplace.sold') }}</h3>
                                            @else
                                                @if (is_requested($market->id))
                                                    <h3 class="fw-semibold text-info">
                                                        {{ trans('marketplace.requested') }}</h3>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="col-sm-4">
                                            <h5 class="text-capitalize">{{ $market->car->condition }}</h5>
                                            <h4>{{ $market->car->make }} {{ $market->car->model }}</h4>
                                            <h5>{{ $market->car->engine_size }} {{ trans('marketplace.engine') }}</h5>
                                        </div>
                                        <div class="col-sm-3">
                                            <h5>{{ trans('marketplace.price') }}:
                                                <span
                                                    class="lead font-weight-bold">{{ support_setting('currency_symbol') }}{{ $market->price }}</span>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <h4 class="fw-semibold">{{ trans('marketplace.overview') }}</h4>
                                            <div class="mb-1 d-flex">
                                                <span
                                                    class="fw-semibold d-block w-25 pl-0">{{ trans('marketplace.mileage') }}:
                                                </span>
                                                <span class="">{{ $market->car->mileage }}</span>
                                            </div>
                                            <div class="mb-1 d-flex">
                                                <span
                                                    class="fw-semibold d-block w-25 pl-0">{{ trans('marketplace.transmition') }}:
                                                </span>
                                                <span class="text-capitalize">{{ $market->car->transmition }}</span>
                                            </div>
                                            <div class="mb-1 d-flex">
                                                <span
                                                    class="fw-semibold d-block w-25 pl-0">{{ trans('marketplace.body_type') }}:
                                                </span>
                                                <span class="text-capitalize">{{ $market->car->body_type }}</span>
                                            </div>
                                            <div class="mb-1 d-flex">
                                                <span
                                                    class="fw-semibold d-block w-25 pl-0">{{ trans('marketplace.fuel_type') }}:
                                                </span>
                                                <span class="text-capitalize">{{ $market->car->fuel_type }}</span>
                                            </div>
                                            <div class="mb-1 d-flex">
                                                <span
                                                    class="fw-semibold d-block w-25 pl-0">{{ trans('marketplace.colour') }}:
                                                </span>
                                                <span class="text-capitalize">{{ $market->car->colour }}</span>
                                            </div>
                                            <div class="mb-1 d-flex">
                                                <span class="fw-semibold d-block w-25 pl-0">{{ trans('marketplace.reg') }}:
                                                </span>
                                                <span class="">{{ $market->car->reg_date }}</span>
                                            </div>
                                            <div class="mb-1">
                                                <span
                                                    class="fw-semibold d-block w-25 pl-0 d-block">{{ trans('marketplace.features') }}:
                                                </span>
                                                @if ($market->car->features)
                                                    <ul class="ml-3">
                                                        @foreach ($market->car->features as $feature)
                                                            <li>{{ $feature }}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                            <div class="mb-1">
                                                <span
                                                    class="fw-semibold d-block w-25 pl-0 d-block">{{ trans('marketplace.description') }}:
                                                </span>
                                                <span class="">{{ $market->description }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- seller information --}}
                            @if ($market->user_id !== auth()->id())
                                <div class="col-12 mt-3" id="seller">
                                    <h4 class="fw-semibold">{{ trans('marketplace.seller') }}</h4>
                                    <div class="mb-1 d-flex">
                                        <span class="fw-semibold d-block w-25 pl-0">{{ trans('marketplace.name') }}:
                                        </span>
                                        <span class="">{{ $market->user?->name }}</span>
                                    </div>
                                    <div class="mb-1 d-flex">
                                        <span class="fw-semibold d-block w-25 pl-0">{{ trans('marketplace.email') }}:
                                        </span>
                                        <span class="">{{ $market->user?->email }}</span>
                                    </div>
                                    <div class="mb-1 d-flex">
                                        <span class="fw-semibold d-block w-25 pl-0">{{ trans('marketplace.mobile') }}:
                                        </span>
                                        <span class="">{{ $market->user?->mobile }}</span>
                                    </div>
                                    <div class="mb-1 d-flex">
                                        <span class="fw-semibold d-block w-25 pl-0">{{ trans('marketplace.location') }}:
                                        </span>
                                        <span class="text-capitalize">{{ $market->location }}</span>
                                    </div>
                                </div>

                                {{-- if user buy already this product --}}
                                @php
                                    $buyer_query = $market
                                        ->buyers()
                                        ->where('buyer_id', auth()->id())
                                        ->latest();
                                @endphp
                                @if ($buyer_query->count() > 0)
                                    <div class="col-12 mt-3">
                                        <h4 class="fw-semibold">{{ trans('marketplace.already_bought') }}</h4>
                                        <div class="row">
                                            @foreach ($buyer_query->get() as $buyer)
                                                <div class="col-md-4 mb-1">
                                                    <div class="mb-1 d-flex">
                                                        <span
                                                            class="fw-semibold d-block pl-0">{{ trans('marketplace.quantity') }}:&nbsp&nbsp
                                                        </span>
                                                        <span class="">{{ $buyer->quantity }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 mb-1">
                                                    <div class="mb-1 d-flex">
                                                        <span
                                                            class="fw-semibold d-block pl-0">{{ trans('marketplace.bought_at') }}:&nbsp&nbsp
                                                        </span>
                                                        <span
                                                            class="">{{ $buyer->created_at->format('d/m/Y h:i A') }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                            @endif

                            @if ($market->user_id != auth()->id() && $market->status !== 'sold')
                                {{-- if product is not own by user --}}
                                <div class="col-12 text-center mt-4">
                                    <a href="tel:{{ $market->user?->mobile }}"
                                        class="btn btn-sm btn-genix">{{ trans('marketplace.contact_seller') }}</a>
                                    <a href="mailto:{{ $market->user?->email }}"
                                        class="btn btn-sm btn-genix">{{ trans('marketplace.email_sellar') }}</a>
                                </div>

                                @if (!is_requested($market->id) && $market->status !== 'sold')
                                    <div id="buyNow" class="mt-3 col-12 text-center">
                                        <button id="buyNowBtn"
                                            class="btn btn-sm btn-genix">{{ trans('marketplace.buy') }}</button>
                                    </div>

                                    <div id="buyNowForm" class="col-md-6 mt-3 d-none">
                                        <form action="{{ route('marketplace.buy') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="market_id" value="{{ $market->id }}">
                                            <div class="form-group">
                                                <label for="quanitity">{{ trans('marketplace.quantity') }}</label>
                                                <input id="quanitity" class="form-control" type="number"
                                                    name="quantity" min="1"
                                                    max="{{ $market->product_id ? $market->product->quantity : 1 }}"
                                                    value="1" {{ $market->car_product_id ? 'readonly' : '' }}
                                                    required>
                                            </div>
                                            <div class="col-12 text-center mt-4">
                                                <button type="submit"
                                                    class="btn btn-sm btn-genix">{{ trans('marketplace.buy') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            @endif

                            {{-- if product sold --}}
                            @if ($market->user_id == auth()->id() && count($market->buyers) > 0)
                                <div class="col-12 mt-3">
                                    <h4 class="fw-semibold">{{ trans('marketplace.sold_to') }}</h4>
                                </div>
                                @foreach ($market->buyers as $buyer)
                                    <div class="col-12 row mt-1 @if (!$loop->last) border-bottom @endif">
                                        <div class="col-md-6">
                                            <div class="mb-1 d-flex">
                                                <span
                                                    class="fw-semibold d-block w-25 pl-0">{{ trans('marketplace.name') }}:
                                                </span>
                                                <span class="">{{ $buyer->buyer?->name }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-1 d-flex">
                                                <span
                                                    class="fw-semibold d-block w-25 pl-0">{{ trans('marketplace.email') }}:
                                                </span>
                                                <span class="">{{ $buyer->buyer?->email }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-1 d-flex">
                                                <span
                                                    class="fw-semibold d-block w-25 pl-0">{{ trans('marketplace.mobile') }}:
                                                </span>
                                                <span class="">{{ $buyer->buyer?->mobile }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-1 d-flex">
                                                <span
                                                    class="fw-semibold d-block w-25 pl-0">{{ trans('marketplace.quantity') }}:
                                                </span>
                                                <span class="">{{ $buyer->quantity }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            {{-- if product own by user --}}
                            @if ($market->user_id == auth()->id() && $market->buyer_requests->count() > 0)
                                <div class="col-12 mt-4">
                                    <h4 class="fw-semibold">{{ trans('marketplace.buyer_request') }}</h4>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead class="thead-genix">
                                                <tr>
                                                    <th style="width:15%;" scope="col">#</th>
                                                    <th style="width:20%;" scope="col">{{ trans('marketplace.name') }}
                                                    </th>
                                                    <th scope="col">{{ trans('marketplace.email') }}</th>
                                                    <th scope="col">{{ trans('marketplace.quantity') }}</th>
                                                    <th scope="col">{{ trans('marketplace.price') }}</th>
                                                    <th style="width:15%;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $currency = support_setting('currency_symbol');
                                                @endphp
                                                @foreach ($market->buyer_requests as $request)
                                                    <tr>
                                                        <th scope="row">{{ $loop->iteration }}</th>
                                                        <td>{{ $request->request_user?->name }}</td>
                                                        <td>{{ $request->request_user?->email }}</td>
                                                        <td>{{ $request->quantity }}</td>
                                                        <td>{{ $currency . '' . $request->quantity * $market->price }}
                                                        </td>
                                                        <td>
                                                            <form action="{{ route('marketplace.sold', $market) }}"
                                                                method="POST"
                                                                onsubmit="if(confirm('{{ trans('marketplace.approve_warning') }}')){return true}else{return false};">
                                                                @csrf
                                                                <input type="hidden" name="request_id"
                                                                    value="{{ $request->id }}">
                                                                <input type="hidden" name="buyer_id"
                                                                    value="{{ $request->request_user->id }}">
                                                                <input type="hidden" name="quantity"
                                                                    value="{{ $request->quantity }}">
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-genix">{{ trans('marketplace.approve') }}</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $('#buyNowBtn').on('click', function() {
            $('#buyNowForm').removeClass('d-none');
            $('#buyNow').addClass('d-none');
        })
        $('#buyNowForm').on('submit', function() {
            $(this).find(":submit").prop('disabled', true);
        })
    </script>
@endpush
