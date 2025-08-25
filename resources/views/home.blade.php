@extends('layouts.app')

@section('content')
    <div class="container page-container">

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    @include('partials.card-header', ['title' => 'Test Page'])
                    <div class="card-body">
                        @include('partials.message')
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
