@extends('layouts.app')

@section('content')
    <div class="container page-container">

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    @include('partials.header-create', [
                        'title' => trans('general.services'),
                        'url' => route('services.create'),
                    ])
                    <div class="card-body">
                        @include('partials.message')
                        @livewire('services')
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <script>
        function deleteService(id) {
            let form = document.getElementById(`service-${id}`);
            if (confirm("Are you sure?")) {
                form.submit();
            }
        }
    </script>
@endpush
