@extends('layouts.app')

@section('content')
    <div class="container page-container">

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    @include('partials.header-create', [
                        'title' => trans('general.repairs'),
                        'url' => route('repairs.create'),
                    ])
                    <div class="card-body">
                        @include('partials.message')

                        @livewire('repairs')
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <script>
        function deleteRepair(id) {
            if (confirm("Are you sure?")) {
                document.getElementById(`repair-${id}`).submit();
            }
        }
    </script>
@endpush
