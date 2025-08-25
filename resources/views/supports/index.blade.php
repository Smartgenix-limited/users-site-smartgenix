@extends('layouts.app')

@section('content')
    <div class="container page-container">
        <div class="row">
            <div class="col-md-12">
                <!-- support ticket start -->
                <div class="card mb-2 border-0">
                    <div class="card-header d-flex justify-content-between align-items-center bg-genix text-white">
                        <h5 class="p-0 m-0">{{ trans('general.my_support_ticket') }}</h5>
                        <a href="{{ route('supports.create') }}"
                            class="btn btn-sm btn-genix">{{ trans('general.create_ticket') }}</a>
                    </div>
                    <div class="card-body">
                        @include('partials.message')
                        <div class="row">
                            <div class="col-md-12">
                                @livewire('tickets')
                            </div>
                        </div>
                    </div>
                </div>
                <!-- support ticket start -->
            </div>
        </div>


    </div>
@endsection
