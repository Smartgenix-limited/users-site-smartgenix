@extends('layouts.app')

@section('content')
    <div class="container page-container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    {{-- @include('partials.card-header', ['title' => 'Market Place']) --}}
                    <div class="card-header center-between align-items-center">
                        <span class="h4 mb-0">{{ trans('marketplace.market-place') }}</span>
                        <div>
                            <a href="{{ route('marketplace.create') }}"
                                class="btn btn-sm btn-primary">{{ trans('marketplace.add_pro') }}</a>
                            <a href="{{ route('marketplace.myplace') }}"
                                class="btn btn-sm btn-primary">{{ trans('marketplace.my-place') }}</a>
                        </div>

                    </div>
                    <div class="card-body bg-light">
                        @include('partials.message')

                        @livewire('market-place.homepage')
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
