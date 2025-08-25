@extends('layouts.app')

@section('content')
    <div class="container page-container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @include('partials.card-header', ['title' => 'View thread'])
                    <div class="card-body">
                        @include('partials.message')

                        {{-- community and comments --}}
                        @livewire('community-comments', ['community' => $community])

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
