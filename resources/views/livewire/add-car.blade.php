<div>
    {{-- @include('partials.errors') --}}
    @if (is_uk() && !$show_reg_form)
        <div class="center-between mb-3">
            <div class="input-group mr-3">
                <div class="input-group-prepend">
                    <span class="input-group-text input-group-text-sm" id="regNumber">{{ trans('car.gb') }}</span>
                </div>
                <input type="text" class="form-control form-control-sm @error('reg_number') is-invalid @enderror"
                    placeholder="{{ trans('car.enter_reg') }}" aria-label="RegNumber" aria-describedby="regNumber"
                    wire:model.lazy="reg_number">
                @error('reg_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <button type="button" class="btn btn-sm btn-genix w-15 h-100 @error('reg_number') mb-4 @enderror"
                wire:click="searchResult" wire:loading.attr="disabled">{{ trans('car.check_now') }}</button>
        </div>
        <div wire:loading wire:target="searchResult">
            <span class="d-block text-info">{{ __('general.car_fetching_info') }}</span>
        </div>
    @endif

    @if (session('no_car'))
        <div class="alert alert-danger" role="alert">
            {{ session('no_car') }}
        </div>
    @endif

    @if ($show_reg_form)
        <div class="form-group">
            <label for="car_name">{{ trans('car.car_name') }}</label>
            <input id="car_name" class="form-control form-control-sm @error('car_name') is-invalid @enderror"
                type="text" name="car_name" wire:model.lazy="car_name">
            @error('car_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="model">{{ trans('car.model') }}</label>
            <input id="model" class="form-control form-control-sm @error('model') is-invalid @enderror"
                type="text" name="model" wire:model.lazy="model">
            @error('model')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="year">{{ trans('car.year') }}</label>
            <input id="year" class="form-control form-control-sm @error('year') is-invalid @enderror"
                type="number" name="year" wire:model.lazy="year">
            @error('year')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="colour">{{ trans('car.colour') }}</label>
            <input id="colour" class="form-control form-control-sm @error('colour') is-invalid @enderror"
                type="text" name="colour" wire:model.lazy="colour">
            @error('colour')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="reg">{{ trans('car.registration') }}</label>
            <input id="reg" class="form-control form-control-sm @error('reg') is-invalid @enderror" type="text"
                name="reg" wire:model.lazy="reg">
            @error('reg')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="mileage">{{ trans('car.mileage') }}</label>
            <input id="mileage" class="form-control form-control-sm @error('mileage') is-invalid @enderror"
                type="number" name="mileage" wire:model.lazy="mileage">
            @error('mileage')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        @if (garage()?->is_mot && is_uk())
            <div class="form-group">
                <label for="last_mot_date">{{ trans('car.last_mot') }}</label>
                <input id="last_mot_date"
                    class="form-control form-control-sm @error('last_mot_date') is-invalid @enderror" type="date"
                    name="last_mot_date" max="{{ now()->format('Y-m-d') }}" wire:model.lazy="last_mot_date">
                @error('last_mot_date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        @endif

        <div class="form-group">
            <label for="last_service_date">{{ trans('car.last_service') }}</label>
            <input id="last_service_date"
                class="form-control form-control-sm @error('last_service_date') is-invalid @enderror" type="date"
                name="last_service_date" max="{{ now()->format('Y-m-d') }}" wire:model.lazy="last_service_date">
            @error('last_service_date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="mb-3">
            <div class="form-group">
                <label for="image">{{ trans('car.image') }}</label>
                <input id="image" class="form-control form-control-sm" type="file" name="image"
                    wire:model.lazy="image">
                @error('image')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="w-25">
                @if ($photo || $image)
                    <img src="{{ $image ? $image->temporaryUrl() : $photo }}" alt="car image" class="img-thumbnail">
                @endif

            </div>
        </div>
        {{-- <button type="submit" id="subBtn" class="btn btn-primary">{{ trans('car.save') }}</button> --}}
        <button wire:click="validateInputs" id="subBtn" type="button"
            class="btn btn-primary">{{ trans('car.save') }}</button>
    @endif
</div>
