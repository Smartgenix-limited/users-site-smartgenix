@extends('layouts.app')

@section('content')
    <div class="container page-container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @include('partials.card-header', ['title' => 'Review Garage'])
                    <div class="card-body">
                        @livewire('review-garage')
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
