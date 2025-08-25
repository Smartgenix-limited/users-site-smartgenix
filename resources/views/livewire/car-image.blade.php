<div class="mb-3">
    <div class="form-group">
        <label for="image">{{ trans('car.image') }}</label>
        <input id="image" class="form-control form-control-sm" type="file" name="image" wire:model="image">
        @error('image')
            <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="w-25">
        @if ($photo)
            <img src="{{ $image ? $image->temporaryUrl() : $photo }}" alt="car image" class="img-thumbnail">
        @else
            <img src="{{ $image ? $image->temporaryUrl() : asset('assets/images/user.png') }}" alt="car image"
                class="img-thumbnail">
        @endif

    </div>
</div>
