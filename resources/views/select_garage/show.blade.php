@extends('layouts.app')

@section('content')
    <div class="container page-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center p-1">
                        {{-- <a href="{{ route('mots.index') }}" class="float-left fs-30 pl-2 text-primary"><i class="bi bi-arrow-left-short"></i></a> --}}
                        <h4 class="pt-2">{{ $garage->name }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h6>{{ $garage->name }}</h6>
                                        <h6>{{ $garage->address }}</h6>
                                        <h6>{{ country($garage->country)?->code . $garage->telephone }}</h6>
                                    </div>
                                    <div class="col-md-4">
                                        <h4>{{ round($garage->reviews_avg_rating, 1) ?? 0 }}/5</h4>
                                    </div>
                                </div>
                            </div>

                            {{-- what they offer --}}
                            <div class="col-12 mt-3">
                                <h4>{{ trans('general.what_offers', ['garage' => $garage->name]) }}</h4>
                                <div class="d-flex justify-content-center pt-3">
                                    @if ($garage->is_mot)
                                        <div class="circle-md center fw-semibold mr-2 text-capitalize">
                                            {{ trans('general.mots') }}
                                        </div>
                                    @endif
                                    @if ($garage->is_services)
                                        <div class="circle-md center fw-semibold mr-2 text-capitalize">
                                            {{ trans('general.services') }}
                                        </div>
                                    @endif
                                    @if ($garage->is_repairs)
                                        <div class="circle-md center fw-semibold mr-2 text-capitalize">
                                            {{ trans('general.repairs') }}
                                        </div>
                                    @endif
                                    @if ($garage->is_recovery)
                                        <div class="circle-md center fw-semibold mr-2 text-capitalize">
                                            {{ trans('general.recovery') }}
                                        </div>
                                    @endif

                                </div>
                            </div>

                            {{-- opening and closing --}}
                            <div class="col-12 mt-3">
                                <h4>{{ trans('general.opening_hours') }}</h4>
                                <p class="fw-semibold">{{ $garage->opening->format('h:i A') }} -
                                    {{ $garage->closing->format('h:i A') }}
                                </p>
                            </div>

                            {{-- contact garage --}}
                            <div class="col-12 mt-3">
                                <h4 class="fw-semibold">{{ trans('general.contact_garage') }}</h4>
                                <a href="tel:{{ country($garage->country)?->code . $garage->telephone }}"
                                    class="btn btn-sm btn-genix">{{ trans('general.telephone') }}</a>
                                <a href="mailto:{{ $garage->user?->email }}"
                                    class="btn btn-sm btn-genix">{{ trans('general.email') }}</a>
                            </div>

                            {{-- reviews --}}
                            <div class="col-12 mt-3">
                                <h3 class="mb-3">{{ trans('general.read_reviews') }}</h3>

                                @forelse ($garage->reviews as $item)
                                    <div class="row align-items-center border-bottom py-2 pl-3">
                                        <div class="col-sm-9">
                                            <h5>{{ $item->user->name }}</h5>
                                            <p class="mb-0 pb-0">{{ $item->review }}</p>
                                            <small>{{ $item->created_at->format('d/m/Y h:i A') }}</small>
                                            @if ($item->replied_by)
                                                <div class="pl-3">
                                                    <h5 class="pt-2">{{ trans('general.reply_from') }}
                                                        {{ $item->replied_by->name }}
                                                    </h5>
                                                    <p class="mb-0 pb-0">{{ $item->reply }}</p>
                                                    <small
                                                        class="d-block">{{ $item->replied_at->format('d/m/Y h:i A') }}</small>
                                                </div>
                                            @endif

                                        </div>
                                        <div class="col-sm-3 mt-3 mt-sm-0 text-center">
                                            <h3>{{ $item->rating }}/5</h3>
                                            {{-- <small>{{ $item->created_at->format('d/m/Y h:i A') }}</small>
                                    @if ($item->replied_by)
                                    <small class="d-block pt-4">{{ $item->replied_at->format('d/m/Y h:i A') }}</small>
                                    @endif --}}
                                        </div>
                                    </div>
                                @empty
                                    <p>{{ trans('general.no_review') }}</p>
                                @endforelse

                            </div>

                            {{-- garage select button --}}
                            <div class="col-12 text-center mt-4 pb-4">
                                <form action="{{ route('garages.update', $garage) }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <button type="submit"
                                        class="btn btn-genix">{{ trans('general.select_garage', ['garage' => $garage->name]) }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
