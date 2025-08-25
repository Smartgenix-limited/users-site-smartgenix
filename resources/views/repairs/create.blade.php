@extends('layouts.app')

@section('content')
    <div class="container page-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center p-1">
                        {{-- <a href="{{ route('repairs.index') }}" class="float-left fs-30 pl-2 text-primary"><i
                                class="bi bi-arrow-left-short"></i></a> --}}
                        <h4 class="pt-2">{{ trans('general.request_quote') }}</h4>
                    </div>
                    <div class="card-body">
                        @include('partials.message')
                        @include('partials.errors')
                        {{-- @if (is_subscription())
                            <div class="alert alert-success">
                                {{ trans('general.you_left_resourses', ['resourses' => subscription()?->repairs, 'type' => 'Repairs']) }}
                            </div>
                        @endif --}}
                        <form id="form" action="{{ route('repairs.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @livewire('select-car', ['type' => 'repair'])

                            <div class="form-group">
                                <label for="message">{{ trans('general.your_issue') }}</label>
                                <textarea name="message" id="message" rows="5" class="form-control form-control-sm"
                                    placeholder="{{ trans('general.your_issue') }}"></textarea>
                            </div>

                            @livewire('create-quote')
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
