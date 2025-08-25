<div>
    @include('partials.message')
    {{-- overall --}}
    <h6 class="fw-semibold">{{ trans('general.overall') }}</h6>
    <div class="center-between">
        <div class="mt-1">
            @foreach ($rating_numbers as $item)
                {{-- bi bi-star-fill --}}
                <span class="{{ !$loop->first ? 'mx-3' : 'mr-3' }} cursor-pointer fs-18"
                    wire:click="changeRating('overall',{{ $item }})"><i
                        class="bi {{ $overall == $item ? 'bi-star-fill text-warning' : 'bi-star' }}"></i></span>
            @endforeach
        </div>
        <span>{{ $overall }}/5</span>
    </div>

    {{-- facilities --}}
    <h6 class="fw-semibold mt-4">{{ trans('general.facilities') }}</h6>
    <div class="center-between">
        <div class="mt-1">
            @foreach ($rating_numbers as $item)
                {{-- bi bi-star-fill --}}
                <span class="{{ !$loop->first ? 'mx-3' : 'mr-3' }} cursor-pointer fs-18"
                    wire:click="changeRating('facility',{{ $item }})"><i
                        class="bi {{ $facility == $item ? 'bi-star-fill text-warning' : 'bi-star' }}"></i></span>
            @endforeach
        </div>
        <span>{{ $facility }}/5</span>
    </div>

    {{-- Appointment Availability --}}
    <h6 class="fw-semibold mt-4">{{ trans('general.availability') }}</h6>
    <div class="center-between">
        <div class="mt-1">
            @foreach ($rating_numbers as $item)
                {{-- bi bi-star-fill --}}
                <span class="{{ !$loop->first ? 'mx-3' : 'mr-3' }} cursor-pointer fs-18"
                    wire:click="changeRating('appointment',{{ $item }})"><i
                        class="bi {{ $appointment == $item ? 'bi-star-fill text-warning' : 'bi-star' }}"></i></span>
            @endforeach
        </div>
        <span>{{ $appointment }}/5</span>
    </div>

    {{-- how long to get car back --}}
    <h6 class="fw-semibold mt-4">{{ trans('general.how_long_car_back') }}</h6>
    <div class="center-between">
        <div class="mt-1">
            @foreach ($rating_numbers as $item)
                {{-- bi bi-star-fill --}}
                <span class="{{ !$loop->first ? 'mx-3' : 'mr-3' }} cursor-pointer fs-18"
                    wire:click="changeRating('car_back',{{ $item }})"><i
                        class="bi {{ $car_back == $item ? 'bi-star-fill text-warning' : 'bi-star' }}"></i></span>
            @endforeach
        </div>
        <span>{{ $car_back }}/5</span>
    </div>

    <div class="form-group mt-2">
        <label for="comment">{{ trans('general.other_comment') }}</label>
        <textarea id="comment" class="form-control" wire:model="comment" rows="4"
            placeholder="{{ trans('general.comment') }}"></textarea>
    </div>
    <div class="text-center mt-3">
        <h4>{{ $rating }}/20</h4>
        <button class="btn btn-primary mt-3"
            wire:click="saveRating">{{ $review ? trans('general.update', ['type' => '']) : trans('general.submit') }}</button>
    </div>
</div>
