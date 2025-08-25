    <div class="row justify-content-center">
        {{-- @include('partials.errors') --}}
        @if (!request()->user()->can_market)
            <div class="col-12 alert alert-danger">
                {{ trans('general.denied_market', ['date' => request()->user()?->block_period?->unblock_at->format('d F Y')]) }}
            </div>
        @endif
        <div class="col-md-12 text-center">
            <button type="button"
                class="btn btn-sm @if ($type === 'car') btn-genix @else btn-outline-genix @endif"
                wire:click="changeType('car')">{{ trans('marketplace.add_car') }}</button>
            <button type="button"
                class="btn btn-sm @if ($type === 'product') btn-genix @else btn-outline-genix @endif ml-2"
                wire:click="changeType('product')">{{ trans('marketplace.add_product') }}</button>
        </div>
        <input type="hidden" name="type" value="{{ $type }}">
        <input type="hidden" name="images" value="{{ json_encode($files) }}">
        <input type="hidden" name="promote" value="{{ $promote }}">
        <input type="hidden" name="search_promote" value="{{ $search_promote }}">
        @if ($type === 'car')
            <div class="col-md-12 mt-3">
                <div class="form-group">
                    <label for="make">{{ trans('marketplace.make') }}</label>
                    <input id="make" class="form-control form-control-sm @error('make') is-invalid @enderror"
                        type="text" name="make" placeholder="{{ trans('marketplace.make') }}" wire:model="make">
                    @error('make')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="model">{{ trans('marketplace.model') }}</label>
                    <input id="model" class="form-control form-control-sm @error('model') is-invalid @enderror"
                        type="text" name="model" placeholder="{{ trans('marketplace.model') }}"
                        wire:model="model">
                    @error('model')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="varient">{{ trans('marketplace.varient') }}</label>
                    <input id="varient" class="form-control form-control-sm @error('varient') is-invalid @enderror"
                        type="text" name="varient" placeholder="{{ trans('marketplace.varient') }}"
                        wire:model="varient">
                    @error('varient')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="engine_size">{{ trans('marketplace.engine_size') }}</label>
                    <select name="engine_size" id="engine_size"
                        class="form-control form-control-sm @error('engine_size') is-invalid @enderror"
                        wire:model="engine_size">
                        <option value="">{{ trans('marketplace.choose_engine_size') }}</option>
                        @foreach ($engine_sizes as $size)
                            <option @selected($engine_size === $size) value="{{ $size }}">{{ $size }}
                            </option>
                        @endforeach
                    </select>
                    @error('engine_size')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="body_type">{{ trans('marketplace.body_type') }}</label>
                    <input id="body_type" class="form-control form-control-sm @error('body_type') is-invalid @enderror"
                        type="text" name="body_type" placeholder="{{ trans('marketplace.body_type') }}"
                        wire:model="body_type">
                    @error('body_type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="transmition">{{ trans('marketplace.transmition') }}</label>
                    <select name="transmition" id="transmition"
                        class="form-control form-control-sm @error('transmition') is-invalid @enderror"
                        wire:model="transmition">
                        <option value="">{{ trans('marketplace.choose_transmition') }}</option>
                        @foreach ($transmitions as $item)
                            <option @selected($transmition === $item) value="{{ $item }}">{{ $item }}
                            </option>
                        @endforeach
                    </select>
                    @error('transmition')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="fuel_type">{{ trans('marketplace.fuel_type') }}</label>
                    <select name="fuel_type" id="fuel_type"
                        class="form-control form-control-sm @error('fuel_type') is-invalid @enderror"
                        wire:model="fuel_type">
                        <option value="">{{ trans('marketplace.choose_fuel_type') }}</option>
                        <option @selected($fuel_type === 'petrol') value="petrol">{{ trans('marketplace.petrol') }}</option>
                        <option @selected($fuel_type === 'diesel') value="diesel">{{ trans('marketplace.diesel') }}</option>
                    </select>
                    @error('fuel_type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="colour">{{ trans('marketplace.colour') }}</label>
                    <input id="colour" class="form-control form-control-sm @error('colour') is-invalid @enderror"
                        type="text" name="colour" placeholder="{{ trans('marketplace.colour') }}"
                        wire:model="colour">
                    @error('colour')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="reg">{{ trans('marketplace.reg') }}</label>
                    <input id="reg"
                        class="form-control form-control-sm @error('reg_date') is-invalid @enderror" type="date"
                        name="reg_date" placeholder="{{ trans('marketplace.reg') }}" wire:model="reg_date"
                        max="{{ now()->subDays(1)->format('Y-m-d') }}">
                    @error('reg_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="mileage">{{ trans('marketplace.mileage') }}</label>
                    <input id="mileage" class="form-control form-control-sm @error('mileage') is-invalid @enderror"
                        type="number" name="mileage" placeholder="{{ trans('marketplace.mileage') }}"
                        wire:model="mileage">
                    @error('mileage')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="advert_title">{{ trans('marketplace.advert_title') }}</label>
                    <input id="advert_title"
                        class="form-control form-control-sm @error('title') is-invalid @enderror" type="text"
                        name="title" placeholder="{{ trans('marketplace.advert_title') }}" wire:model="title">
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="advert_des">{{ trans('marketplace.advert_des') }}</label>
                    <textarea id="advert_des" class="form-control form-control-sm @error('description') is-invalid @enderror"
                        name="description" placeholder="{{ trans('marketplace.advert_des') }}" wire:model="description"></textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="price">{{ trans('marketplace.price') }}</label>
                    <input id="price" class="form-control form-control-sm @error('price') is-invalid @enderror"
                        type="text" name="price" placeholder="{{ trans('marketplace.price') }}"
                        wire:model="price">
                    @error('price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="vehicle_location">{{ trans('marketplace.vehicle_location') }}</label>
                    <select name="location"
                        class="form-control form-control-sm @error('location') is-invalid @enderror"
                        id="vehicle_location" wire:model="location">
                        <option value="">{{ trans('marketplace.choose_location') }}</option>
                        @foreach ($countries as $country)
                            <option @selected($location === $country->name) value="{{ $country->name }}">{{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('location')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="condition">{{ trans('marketplace.condition') }}</label>
                    <select name="condition" id="condition"
                        class="form-control form-control-sm @error('condition') is-invalid @enderror"
                        wire:model="condition">
                        <option value="">{{ trans('marketplace.choose_condition') }}</option>
                        <option @selected($condition === 'new') value="new">{{ trans('marketplace.new') }}</option>
                        <option @selected($condition === 'used') value="used">{{ trans('marketplace.used') }}</option>
                        <option @selected($condition === 'spare parts') value="spare parts">
                            {{ trans('marketplace.spare_parts') }}</option>
                    </select>
                    @error('condition')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="vehicle_type">{{ trans('marketplace.vehicle_type') }}</label>
                    <select name="vehicle_type" id="vehicle_type"
                        class="form-control form-control-sm @error('vehicle_type') is-invalid @enderror"
                        wire:model="vehicle_type">
                        <option value="">{{ trans('marketplace.choose_vehicle_type') }}</option>
                        <option @selected($vehicle_type === 'car') value="car">{{ trans('marketplace.car') }}</option>
                        <option @selected($vehicle_type === 'van') value="van">{{ trans('marketplace.van') }}</option>
                        <option @selected($vehicle_type === 'minibus') value="minibus">{{ trans('marketplace.minibus') }}
                        </option>
                        <option @selected($vehicle_type === 'lorry') value="lorry">{{ trans('marketplace.lorry') }}
                        <option @selected($vehicle_type === 'other') value="other">{{ trans('marketplace.other') }}
                        </option>
                    </select>
                    @error('vehicle_type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="vehicle_seats">{{ trans('marketplace.vehicle_seats') }}</label>
                    <select name="vehicle_seats" id="vehicle_seats"
                        class="form-control form-control-sm @error('vehicle_seats') is-invalid @enderror"
                        wire:model="vehicle_seats">
                        <option value="">{{ trans('marketplace.choose_vehicle_seats') }}</option>
                        <option @selected($vehicle_seats === '2') value="2">2</option>
                        <option @selected($vehicle_seats === '4') value="4">4</option>
                        <option @selected($vehicle_seats === '5') value="5">5</option>
                        <option @selected($vehicle_seats === '6') value="6">6</option>
                        <option @selected($vehicle_seats === '7') value="7">7</option>
                        <option @selected($vehicle_seats === '7+') value="7+">7+</option>
                    </select>
                    @error('vehicle_seats')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="upload{{ $iteration }}">{{ trans('marketplace.images') }}</label>
                    <input type="file" id="upload{{ $iteration }}"
                        class="form-control form-control-sm @error('files') is-invalid @enderror mt-1 mb-2"
                        wire:model="attachments" multiple>
                    @error('files')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <!-- showing files -->
                @if (count($files) > 0)
                    <div class="support d-flex flex-wrap">
                        @foreach ($files as $file)
                            <div class="position-relative mb-3">
                                <img src="{{ $file }}" alt="image" class="img-fluid mb-2 mx-2 rounded">
                                <span wire:click="delete_file({{ $loop->index }},'{{ $file }}')"
                                    class="cursor-pointer fs-25"><i
                                        class="bi bi-x text-danger position-absolute delete-task"></i></span>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="form-group mb-2">
                    <div class="center-between mb-2">
                        <label for="feature">{{ trans('marketplace.features') }}</label>
                        <button type="button" class="btn btn-xs btn-primary" wire:click="addFeature"
                            title="Add New Feature">{{ trans('marketplace.add_new') }}</button>
                    </div>
                    @foreach ($features as $idx => $item)
                        <div class="d-flex center-between mb-2">
                            <input id="{{ $idx }}feature" class="form-control form-control-sm"
                                type="text" name="features[{{ $idx }}]"
                                placeholder="{{ trans('marketplace.feature') }}"
                                value="{{ $product ? $item : $item['feature'] }}" required>
                            <span class="cursor-pointer text-danger fs-25 pl-2"
                                wire:click="deleteFeature({{ $idx }})" title="Delete">
                                <i class="bi bi-x"></i>
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="col-md-12 mt-3">
                <div class="form-group">
                    <label for="product_name">{{ trans('marketplace.product_name') }}</label>
                    <input id="product_name"
                        class="form-control form-control-sm @error('product_name') is-invalid @enderror"
                        type="text" name="product_name" placeholder="{{ trans('marketplace.product_name') }}"
                        wire:model="product_name">
                    @error('product_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="condition">{{ trans('marketplace.condition') }}</label>
                    <select name="condition" id="condition"
                        class="form-control form-control-sm @error('condition') is-invalid @enderror"
                        wire:model="condition">
                        <option value="">{{ trans('marketplace.choose_condition') }}</option>
                        <option @selected($condition === 'new') value="new">{{ trans('marketplace.new') }}</option>
                        <option @selected($condition === 'new other') value="new other">{{ trans('marketplace.new_other') }}
                        </option>
                        <option @selected($condition === 'used') value="used">{{ trans('marketplace.used') }}</option>
                        <option @selected($condition === 'spare parts') value="spare parts">
                            {{ trans('marketplace.spare_parts') }}</option>
                        <option @selected($condition === 'not working') value="not working">
                            {{ trans('marketplace.not_working') }}</option>
                    </select>
                    @error('condition')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="brand">{{ trans('marketplace.brand') }}</label>
                    <input id="brand" class="form-control form-control-sm @error('brand') is-invalid @enderror"
                        type="text" name="brand" placeholder="{{ trans('marketplace.brand') }}"
                        wire:model="brand">
                    @error('brand')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="brand_number">{{ trans('marketplace.brand_number') }}</label>
                    <input id="brand_number"
                        class="form-control form-control-sm @error('brand_number') is-invalid @enderror"
                        type="text" name="brand_number" placeholder="{{ trans('marketplace.brand_number') }}"
                        wire:model="brand_number">
                    @error('brand_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="grade">{{ trans('marketplace.grade') }}</label>
                    <input id="grade" class="form-control form-control-sm @error('grade') is-invalid @enderror"
                        type="text" name="grade" placeholder="{{ trans('marketplace.grade') }}"
                        wire:model="grade">
                    @error('grade')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="category">{{ trans('marketplace.category') }}</label>
                    <select name="category" id="category"
                        class="form-control form-control-sm @error('category') is-invalid @enderror"
                        wire:model="category">
                        <option value="">{{ trans('marketplace.choose_category') }}</option>
                        <option @selected($category === 'car parts') value="car parts">{{ trans('marketplace.car_parts') }}
                        </option>
                    </select>
                    @error('category')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="sub_category">{{ trans('marketplace.sub_category') }}</label>
                    <select name="sub_category" id="sub_category"
                        class="form-control form-control-sm @error('sub_category') is-invalid @enderror"
                        wire:model="sub_category">
                        <option value="">{{ trans('marketplace.choose_sub_category') }}</option>
                        <option @selected($sub_category === 'lights') value="lights">{{ trans('marketplace.lights') }}
                        </option>
                        <option @selected($sub_category === 'speaker') value="speaker">{{ trans('marketplace.speaker') }}
                        </option>
                        <option @selected($sub_category === 'horn') value="horn">{{ trans('marketplace.horn') }}</option>
                        <option @selected($sub_category === 'tyres') value="tyres">{{ trans('marketplace.tyres') }}
                        </option>
                    </select>
                    @error('sub_category')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="advert_title">{{ trans('marketplace.advert_title') }}</label>
                    <input id="advert_title"
                        class="form-control form-control-sm @error('title') is-invalid @enderror" type="text"
                        name="title" placeholder="{{ trans('marketplace.advert_title') }}" wire:model="title">
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="advert_des">{{ trans('marketplace.advert_des') }}</label>
                    <textarea id="advert_des" class="form-control form-control-sm @error('description') is-invalid @enderror"
                        name="description" placeholder="{{ trans('marketplace.advert_des') }}" wire:model="description"></textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="price">{{ trans('marketplace.price') }}</label>
                    <input id="price" class="form-control form-control-sm @error('price') is-invalid @enderror"
                        type="text" name="price" placeholder="{{ trans('marketplace.price') }}"
                        wire:model="price">
                    @error('price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="ean">{{ trans('marketplace.ean') }}</label>
                    <input id="ean" class="form-control form-control-sm @error('ean') is-invalid @enderror"
                        type="text" name="ean" placeholder="{{ trans('marketplace.ean') }}"
                        wire:model="ean">
                    @error('ean')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="location">{{ trans('marketplace.location') }}</label>
                    <select name="location"
                        class="form-control form-control-sm @error('location') is-invalid @enderror"
                        id="vehicle_location" wire:model="location">
                        <option value="">{{ trans('marketplace.choose_location') }}</option>
                        @foreach ($countries as $country)
                            <option @selected($location === $country->name) value="{{ $country->name }}">{{ $country->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('location')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="quantity">{{ trans('marketplace.quantity') }}</label>
                    <input id="quantity"
                        class="form-control form-control-sm @error('quantity') is-invalid @enderror" type="text"
                        name="quantity" placeholder="{{ trans('marketplace.quantity') }}" wire:model="quantity">
                    @error('quantity')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="upload{{ $iteration }}">{{ trans('marketplace.images') }}</label>
                    <input type="file" id="upload{{ $iteration }}"
                        class="form-control form-control-sm @error('files') is-invalid @enderror mt-1 mb-2"
                        wire:model="attachments" multiple>
                    @error('files')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <!-- showing files -->
                @if (count($files) > 0)
                    <div class="support d-flex flex-wrap">
                        @foreach ($files as $file)
                            <div class="position-relative mb-3">
                                <img src="{{ $file }}" alt="image" class="img-fluid mb-2 mx-2 rounded">
                                <span wire:click="delete_file({{ $loop->index }},'{{ $file }}')"
                                    class="cursor-pointer fs-25"><i
                                        class="bi bi-x text-danger position-absolute delete-task"></i></span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif

        <div class="col-md-12 mt-2">
            <div class="form-group border rounded px-3 pt-1">
                <div class="custom-control custom-checkbox small">
                    <input type="checkbox" class="custom-control-input" id="show_number" wire:model="show_number"
                        name="show_number">
                    <label class="custom-control-label" for="show_number"
                        style="padding-top:2px;">{{ trans('marketplace.show_number') }}</label>
                </div>
            </div>

            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            @if (!$is_search_promote)
                <div class="border rounded px-3 d-sm-flex align-items-center mb-3">
                    <span>{{ trans('marketplace.promote') }}</span>
                    <span class="cursor-pointer fs-16 px-1" data-toggle="modal" data-target="#promoModel"><i
                            class="bi bi-info-circle"></i></span>
                    <span>{{ trans('marketplace.promote_price') }}
                        {{ support_setting('currency_symbol') . convert_price($homepage_promotion_fee) }}</span>
                    <div class="form-group mb-0 pt-sm-2 pl-sm-3">
                        <label for="promote" class="@if ($promote) text-danger @endif"
                            style="padding-top: 2px;">{{ trans('marketplace.no') }}</label>
                        <div class="custom-control custom-switch d-inline ml-1">
                            <input type="checkbox" class="custom-control-input" id="promote"
                                {{ $checkbox_disable ? 'disabled' : '' }} wire:model="promote">
                            <label class="custom-control-label @if ($promote) text-success @endif"
                                for="promote" style="padding-top: 2px;">{{ trans('marketplace.yes') }}</label>
                        </div>
                    </div>
                </div>
            @else
                <div class="border rounded px-3 d-sm-flex align-items-center mb-3">
                    <span>{{ trans('marketplace.search_promote') }}
                        {{ support_setting('currency_symbol') . convert_price($search_promotion_fee) }}</span>
                    <div class="form-group mb-0 pt-sm-2 pl-sm-3">
                        <label for="promote" style="padding-top: 2px;">{{ trans('marketplace.no') }}</label>
                        <div class="custom-control custom-switch d-inline ml-1">
                            <input type="checkbox" class="custom-control-input" id="promote"
                                {{ $checkbox_disable ? 'disabled' : '' }} wire:model="search_promote">
                            <label class="custom-control-label" for="promote"
                                style="padding-top: 2px;">{{ trans('marketplace.yes') }}</label>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @if (!$is_validated)
            <div class="col-md-12 text-center mt-3">
                <button type="button" class="btn btn-genix" wire:click="validateInputs"
                    wire:loading.attr="disabled"
                    {{ !request()->user()->can_market ? 'disabled' : '' }}>{{ $is_promoted ? trans('general.continue') : trans('general.update', ['type' => '']) }}</button>
            </div>
        @endif
        {{-- @endif --}}


    </div>
