@extends('layouts.app')

@section('content')
    <div class="container page-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- support ticket start -->
                <div class="card">
                    <div class="card-header text-center bg-genix text-white">
                        <h5 class="p-0 m-0 pt-1">{{ trans('general.open_support_ticket') }}</h5>
                    </div>
                    <div class="card-body">
                        @livewire('create-ticket')
                    </div>
                </div>
                <!-- support ticket start -->
            </div>
        </div>


    </div>
@endsection
