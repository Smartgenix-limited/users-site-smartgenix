@extends('layouts.app')

@section('content')
    <div class="container page-container">

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    @include('partials.header-create', [
                        'title' => trans('community.community'),
                        'url' => route('communities.create'),
                    ])
                    <div class="card-body">
                        @include('partials.message')
                        @livewire('community')
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <script>
        function deleteCommunity(id) {
            let form = document.getElementById(`community-${id}`);
            if (confirm("Are you sure?")) {
                form.submit();
            }
        }
    </script>
@endpush
