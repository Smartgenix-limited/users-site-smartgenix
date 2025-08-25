<div class="container page-container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center p-1">
                    <a href="{{ route('garage.show', $car->id) }}" class="float-left fs-30 pl-2 text-primary"><i
                            class="bi bi-arrow-left-short"></i></a>
                    <h4 class="pt-2">{{ trans('general.car_transfer') }}</h4>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="findUser">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <div class="form-group">
                                    <label for="email">{{ trans('general.user_email') }}</label>
                                    <input id="email" class="form-control form-control-sm" type="email"
                                        placeholder="Email Address" wire:model='email'>
                                    @error('email')
                                        <span class="text-danger fw-semibold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-3">
                                <button type="submit"
                                    class="btn btn-primary @error('email') mb-3 @else mt-2 @enderror">{{ trans('general.find') }}</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    {{-- user details --}}
                    @if (session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if ($user)
                        <div class="d-flex align-items-center mb-2">
                            <span class="h5">{{ trans('general.name') }}:&nbsp&nbsp</span>
                            <span class="h5 pl-4">{{ $user->name }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <span class="h5">{{ trans('general.email') }}:&nbsp&nbsp</span>
                            <span class="h5 pl-4">{{ $user->email }}</span>
                        </div>

                        <button class="btn btn-sm btn-primary"
                            wire:click="confirmTransfer">{{ trans('general.confirm_transfer') }}</button>
                    @endif
                    {{-- user details end --}}
                </div>
            </div>
        </div>
    </div>
</div>
