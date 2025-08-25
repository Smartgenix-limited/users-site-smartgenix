<div class="row justify-content-center">
    @if (!$is_type_selected)
        <div class="col-md-10 mb-2">
            <ul class="list-group">
                <li class="list-group-item cursor-pointer" wire:click="selectDepartment('support')">
                    <span class="h4">{{ trans('general.support') }}</span>
                    <span class="d-block">{{ trans('general.what_support') }}</span>
                </li>
                <li class="list-group-item cursor-pointer" wire:click="selectDepartment('billing')">
                    <span class="h4">{{ trans('general.billing') }}</span>
                    <span class="d-block">{{ trans('general.what_billing') }}</span>
                </li>
                <li class="list-group-item cursor-pointer" wire:click="selectDepartment('sales')">
                    <span class="h4">{{ trans('general.sales') }}</span>
                    <span class="d-block">{{ trans('general.what_sales') }}</span>
                </li>
                <li class="list-group-item cursor-pointer" wire:click="selectDepartment('feature')">
                    <span class="h4">{{ trans('general.feature') }}</span>
                    <span class="d-block">{{ trans('general.what_feature') }}</span>
                </li>
            </ul>
        </div>
    @else
        <div class="col-md-10 border rounded p-3">
            <h5>{{ trans('general.ticket_info') }}</h5>
            <div class="d-flex justify-content-between my-3">
                <div class="">
                    <h6>{{ trans('general.name') }}</h6>
                    <span>{{ auth()->user()->name }}</span>
                </div>
                <div class="">
                    <h6>{{ trans('general.email') }}</h6>
                    <span>{{ auth()->user()->email }}</span>
                </div>
            </div>
            <!-- general information -->
            <form wire:submit.prevent="createTicket">
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <div class="form-group">
                            <label for="department">{{ trans('general.department') }}</label>
                            <select wire:model="department" id="department"
                                class="form-control form-control-sm text-capitalize">
                                @foreach ($departments as $item)
                                    <option {{ $item === $department ? 'selected' : '' }} value="{{ $item }}">
                                        {{ trans('general.' . $item) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="form-group">
                            <label for="service_type">{{ trans('general.related_service') }}</label>
                            <select wire:model="service_type" id="service_type"
                                class="form-control form-control-sm text-capitalize">
                                @foreach ($services as $service)
                                    <option value="{{ $service->service }}">
                                        {{ $service->service }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="form-group">
                            <label for="priority">{{ trans('general.priority') }}</label>
                            <select wire:model="priority" id="priority"
                                class="form-control form-control-sm text-capitalize">
                                @foreach ($periorities as $item)
                                    <option {{ $item === $priority ? 'selected' : '' }} value="{{ $item }}">
                                        {{ trans('general.' . $item) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- subject and information -->
                <div class="form-group mb-2">
                    <label for="subject">{{ trans('general.subject') }}</label>
                    <input id="subject" class="form-control" type="text" wire:model="subject"
                        placeholder="{{ trans('general.subject') }}">
                    @error('subject')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-2">
                    <label for="message">{{ trans('general.message') }}</label>
                    <textarea class="form-control" id="message" wire:model="message" rows="5"
                        placeholder="{{ trans('general.message_placeholder') }}"></textarea>
                    @error('message')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-2">
                    <label for="attachment{{ $iteration }}">{{ trans('general.attachment') }}</label>
                    <input id="attachment{{ $iteration }}" class="form-control" type="file"
                        wire:model="attachments" multiple>
                </div>
                <div class="d-flex flex-wrap align-items-center support">
                    @foreach ($files as $file)
                        {{-- <div class="position-relative"> --}}
                        @if ($file['type'] === 'image')
                            {{-- <img src="{{ $file['file'] }}" alt="image" class="img-fluid mb-3 mx-2 rounded"> --}}
                            <div class="position-relative mb-3">
                                <img src="{{ $file['file'] }}" alt="image" class="img-fluid mb-2 mx-2 rounded">
                                <span wire:click="delete_file({{ $loop->index }},'{{ $file['file'] }}')"
                                    class="cursor-pointer fs-25"><i
                                        class="bi bi-x text-danger position-absolute delete-task"></i></span>
                            </div>
                        @elseif ($file['type'] === 'video')
                            {{-- <video src="{{ $file['file'] }}" controls class="mb-3 mx-2 rounded">
                            </video> --}}
                            <div class="position-relative mb-3">
                                <video src="{{ $file['file'] }}" controls class="mb-2 mx-2 rounded">
                                </video>
                                <span wire:click="delete_file({{ $loop->index }},'{{ $file['file'] }}')"
                                    class="cursor-pointer fs-25"><i
                                        class="bi bi-x text-danger position-absolute delete-task-video"></i></span>
                            </div>
                        @else
                            <div class="position-relative mb-3">
                                <a href="{{ $file['file'] }}" class="text-genix text-decoration-none fs-40 mb-3 mx-2"
                                    download=""><i class="bi bi-cloud-arrow-down"></i></a>
                                <span wire:click="delete_file({{ $loop->index }},'{{ $file['file'] }}')"
                                    class="cursor-pointer fs-25"><i
                                        class="bi bi-x text-danger position-absolute delete-task-video"></i></span>
                            </div>
                        @endif

                        {{-- <span wire:click="delete_file({{ $loop->index }},'{{ $file['file'] }}')"
                            class="cursor-pointer fs-30 z-9 position-relative"><i
                                class="bi bi-x text-danger position-absolute delete-task"></i></span> --}}
                    @endforeach
                </div>

                <div class="mt-2">
                    <button type="submit" class="btn btn-genix">{{ trans('general.create', ['type' => '']) }}</button>
                    <button wire:click="clearFields" type="button"
                        class="btn btn-genix">{{ trans('general.cancel', ['type' => '']) }}</button>
                </div>
            </form>

        </div>
    @endif
</div>
