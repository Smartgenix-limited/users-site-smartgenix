<div class="container page-container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center p-1">
                    <a href="{{ route('dashboard') }}" class="float-left fs-30 pl-2 text-primary"><i
                            class="bi bi-arrow-left-short"></i></a>
                    <h4 class="pt-2">{{ trans('general.notifications') }}</h4>
                </div>
                <div class="card-body">
                    @forelse ($notifications as $notification)
                        <div class="row align-items-center">
                            <div class="col-4 col-sm-3">
                                <img src="{{ $notification->image ? $notification->image : asset('images/logo-white.png') }}"
                                    alt="Notification Image" class="img-fluid rounded">
                            </div>
                            <div class="col-8 col-sm-9">
                                <h5>{{ $notification->title }}</h5>
                                <p>{{ $notification->message }}</p>
                                @if ($notification->promocode)
                                    <p class="font-weight-bold">{{ trans('general.use_code') }}:
                                        {{ $notification->promocode }}</p>
                                @endif

                            </div>
                        </div>
                        <hr>
                    @empty
                        <h5>{{ trans('general.no_notification') }}</h5>
                    @endforelse
                    <div class="mt-3">
                        {!! $notifications->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
