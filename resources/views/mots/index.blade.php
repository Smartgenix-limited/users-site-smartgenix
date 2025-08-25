@extends('layouts.app')

@section('content')
    <div class="container page-container">

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    @include('partials.header-create', [
                        'title' => trans('general.mots'),
                        'url' => route('mots.create'),
                    ])
                    <div class="card-body">
                        @include('partials.message')
                        @livewire('mots')
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <script>
        function deleteMot(id) {
            let form = document.getElementById(`mot-${id}`);
            if (confirm("{{ trans('general.are_you_sure') }}")) {
                form.submit();
            }
        }
    </script>
@endpush
