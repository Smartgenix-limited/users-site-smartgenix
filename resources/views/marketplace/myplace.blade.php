@extends('layouts.app')

@section('content')
    <div class="container page-container">

        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    @include('partials.card-header', ['title' => trans('marketplace.my-place')])
                    <div class="card-body">
                        @include('partials.message')

                        @livewire('market-place.myplace')
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
