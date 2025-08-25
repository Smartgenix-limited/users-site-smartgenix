<div class="row" wire:poll>
    <div class="col-md-9 mb-2">
        <h4 class="mb-3 text-center"><span>{{ trans('general.subject') }}: </span> {{ $ticket->subject }}</h4>
        <!-- replies start -->

        @foreach ($replies as $reply)
            {{-- {{ dd($reply->user, auth()->user()->name) }} --}}
            <div class="@if ($reply->type == 'garage') text-right @endif">
                <h5>{{ $reply->type == 'garage' ? trans('general.you') : $reply->support_user->name . ($reply->support_user->role_id == 1 || $reply->support_user->role_id == 2 ? '(' . trans('general.admin') . ')' : '(' . trans('general.support') . ')') }}
                </h5>
                <p class="">{{ $reply->message }}</h5>
                <div id="imgWrapper"
                    class="support-ticket d-flex flex-wrap @if ($reply->type == 'garage') justify-content-end @endif">
                    @if (count($reply->attachments) > 0)
                        @foreach ($reply->attachments as $file)
                            @php
                                $total += $total++;
                            @endphp
                            @if ($file['type'] === 'image')
                                <img id="myImg{{ $total }}"
                                    src="{{ $reply->user_id === auth()->id() ? asset($file['file']) : file_url($file['file']) }}"
                                    alt="image" class="img-fluid mb-2 rounded cursor-pointer model-img"
                                    onclick="showImage('{{ $reply->user_id === auth()->id() ? asset($file['file']) : file_url($file['file']) }}')">
                            @elseif ($file['type'] === 'video')
                                <video
                                    src="{{ $reply->user_id === auth()->id() ? asset($file['file']) : file_url($file['file']) }}"
                                    controls class="mb-2 rounded">
                                </video>
                            @else
                                <a href="{{ $reply->user_id === auth()->id() ? asset($file['file']) : file_url($file['file']) }}"
                                    class="text-genix text-decoration-none fs-40 mb-2" download=""><i
                                        class="bi bi-cloud-arrow-down"></i></a>
                            @endif
                        @endforeach
                    @endif

                </div>
                <hr class="mt-1">
            </div>
        @endforeach
        <!-- new reply -->
        <form wire:submit.prevent="createReply" class="@if ($ticket->status === 'resolved') d-none @endif">
            <div class="form-group mb-2">
                <label for="reply">{{ trans('general.reply') }}</label>
                <textarea id="reply" class="form-control form-control-sm" placeholder="{{ trans('general.reply') }}..."
                    rows="5" wire:model="message"></textarea>
            </div>

            <div class="form-group mb-2">
                <label for="attachment{{ $iteration }}">{{ trans('general.attachment') }}</label>
                <input id="attachment{{ $iteration }}" class="form-control form-control-sm" type="file"
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
            <button type="submit" class="btn btn-genix">{{ trans('general.submit', ['type' => '']) }}</button>
        </form>

    </div>
    <div class="col-md-3 mb-2">
        <div class="d-flex justify-content-between mb-2">
            <h6>{{ trans('general.department') }}:</h6>
            <h6 class="text-capitalize">{{ $ticket->department }}</h6>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <h6>{{ trans('general.submitted') }}:</h6>
            <h6>{{ $ticket->created_at->format('d/m/Y') }}</h6>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <h6>{{ trans('general.time') }}:</h6>
            <h6>{{ $ticket->created_at->format('H:i A') }}</h6>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <h6>{{ trans('general.last_updated') }}:</h6>
            <h6>{{ $ticket->updated_at->format('d/m/Y') }}</h6>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <h6>{{ trans('general.time') }}:</h6>
            <h6>{{ $ticket->updated_at->format('H:i A') }}</h6>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <h6>{{ trans('general.priority') }}:</h6>
            <h6 class="text-capitalize">{{ $ticket->priority }}</h6>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <h6>{{ trans('general.status') }}:</h6>
            <h6 class="text-capitalize">{{ $ticket->status }}</h6>
        </div>
        @if (!$complete)
            <button wire:click="completeTicket"
                class="btn btn-sm btn-genix">{{ trans('general.complete_ticket') }}</button>
            {{-- <div class="custom-control custom-switch">
                <input type="checkbox" wire:model="complete" class="custom-control-input" id="completeTicket">
                <label class="custom-control-label" for="completeTicket">Complete Ticket</label>
            </div> --}}
        @endif
    </div>
</div>
