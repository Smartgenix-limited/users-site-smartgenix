<div>
    <div class="form-group">
        <label for="car">{{ trans('general.select_car') }}</label>
        <select id="car" class="form-control form-control-sm @error('cars') is-invalid @enderror" wire:model='car'
            onchange="carSelected()">
            <option value="">{{ trans('general.select_car') }}</option>
            @foreach ($cars as $item)
                <option value="{{ $item->id }}">{{ $item->car_name }} ({{ $item->model }}) ({{ $item->reg }})
                </option>
            @endforeach
        </select>
        @error('cars')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <!-- Selected cars ---->
    @if (count($selected_cars) > 0)
        <h4>Selected {{ count($selected_cars) <= 1 ? 'Car' : 'Cars' }}</h4>
        <div class="d-flex flex-wrap mt-2">
            @foreach ($selected_cars as $car)
                <div class="border rounded p-3 mr-2 mb-2">
                    <div class="d-flex align-items-center mb-2">
                        <span class="h6">{{ trans('general.name') }}:&nbsp&nbsp</span>
                        <span class="h6 pl-4">{{ $car->car_name }}</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <span class="h6">{{ trans('general.colour') }}:&nbsp</span>
                        <span class="h6 pl-4">{{ $car->colour }}</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <span class="h6">{{ trans('general.reg') }}:&nbsp&nbsp&nbsp</span>
                        <span class="h6 pl-4">{{ $car->reg }}</span>
                    </div>
                    {{-- <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-sm btn-primary"
                            wire:click='removeCar({{ $loop->index }},{{ $car->id }})'>Remove</button>
                    </div> --}}
                </div>
            @endforeach
        </div>
    @endif
    <!-- Selected cars end ---->

    <input type="hidden" id="cars" name="cars" wire:model='car_ids'>
    <input type="hidden" id="carsLength" value="{{ count($selected_cars) }}">
    <span id="type" data-type="{{ $type }}"></span>
</div>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            Livewire.hook('element.updated', (el, component) => {
                if (document.getElementById("type").getAttribute('data-type') !== 'repair') {
                    let length = document.getElementById('carsLength')?.value;
                    length = length == 0 ? 1 : length;
                    let type = document.getElementById("motPrice")?.getAttribute('data-type');
                    if (type === 'mot') {
                        let price = document.getElementById("motPrice")?.getAttribute('data-price');
                        document.getElementById("payAmount").value = price * length;
                    }
                }

            });
        });
    </script>
@endpush
