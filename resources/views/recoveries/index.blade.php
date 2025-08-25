@extends('layouts.app')

@section('content')
    <div class="container page-container">

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    @include('partials.header-create', [
                        'title' => trans('recoveries.title'),
                        'url' => route('recoveries.create'),
                    ])
                    <div class="card-body">
                        @include('partials.message')

                        @livewire('recoveries')
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <script>
        function deleteRecovery(id) {
            let form = document.getElementById(`recovery-${id}`);
            if (confirm("Are you sure?")) {
                form.submit();
            }
        }
    </script>
@endpush
