@extends('layouts.app')

@section('content')
    <div class="container page-container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                {{-- car history --}}
                <div class="card">
                    <div class="card-header center-between align-items-center">
                        <span class="h4 mb-0">{{ trans('general.my_garage') }}</span>
                        <a href="{{ route('garage.create') }}" class="btn btn-sm btn-primary">{{ trans('general.add') }}</a>
                    </div>
                    <div class="card-body">
                        @include('partials.message')
                        @livewire('garage')
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
