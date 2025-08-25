@extends('layouts.app')

@section('content')
    <div class="container page-container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-uppercase">{{ trans('general.choose_garage') }}</h3>
                <hr />
            </div>

            {{-- garages list show here --}}
            @livewire('garages')
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        window.addEventListener('draw_map', event => {
            drawMap(event.detail.garages)
        })
    </script>
@endpush
