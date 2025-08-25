@extends('layouts.app')

@section('content')
    <div class="container page-container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @include('partials.card-header', ['title' => 'Edit Question'])
                    <div class="card-body">
                        @include('partials.message')
                        @if (!request()->user()->can_community)
                            <div class="col-12 alert alert-danger">
                                {{ trans('general.denied_community', ['date' => request()->user()?->block_period?->unblock_at->format('d F Y')]) }}
                            </div>
                        @endif
                        <form action="{{ route('communities.update', $community) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="title">{{ __('community.title') }}</label>
                                <input id="title" class="form-control @error('title') is-invalid @enderror"
                                    type="text" name="title" value="{{ old('title', $community->title) }}"
                                    placeholder="{{ __('community.title') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="category">{{ __('community.category') }}</label>
                                <select id="category"
                                    class="form-control text-capitalize @error('category') is-invalid @enderror"
                                    name="category" required>
                                    <option value="">{{ trans('community.choose_category') }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category }}" @selected(old('category', $community->category) === $category)>{{ $category }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="message">{{ __('community.message') }}</label>
                                <textarea id="message" class="form-control @error('message') is-invalid @enderror" name="message"
                                    placeholder="{{ __('community.message') }}" rows="7" required>{{ old('message', $community->message) }}</textarea>
                                @error('message')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            @livewire('files', ['files' => json_decode($community->files, true)])

                            <div id="submitBtn" class="text-center mt-4">
                                <button type="submit" class="btn btn-primary"
                                    {{ !request()->user()->can_community ? 'disabled' : '' }}>{{ trans('general.update', ['type' => 'Question']) }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
