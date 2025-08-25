<div>
    <div class="form-group">
        @if ($type === 'account')
            <label for="country">{{ trans('general.country') }}</label>
        @endif
        <select id="country"
            class="form-control @if ($type === 'register') form-control-select h-100 @endif @error('country') is-invalid @enderror"
            wire:model="country" name="country">
            <option value="">{{ trans('general.select_country') }}</option>
            @foreach ($countries as $item)
                <option value="{{ $item->name }}">{{ $item->name }}</option>
            @endforeach
        </select>

        @error('country')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        @if ($type === 'account')
            <label for="city">{{ trans('general.city') }}</label>
        @endif
        <select id="city"
            class="form-control @if ($type === 'register') form-control-select h-100 @endif @error('city') is-invalid @enderror"
            wire:model="city" {{ !$is_country ? 'disabled' : '' }} name="city">
            <option value="">{{ trans('general.select_city') }}</option>
            @foreach ($cities as $city)
                <option value="{{ $city->name }}">{{ $city->name }}</option>
            @endforeach
        </select>

        @error('city')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
