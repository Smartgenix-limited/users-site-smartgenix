<div class="row">
    @if (!request()->user()->can_comment)
        <div class="col-12 alert alert-danger">
            {{ trans('general.denied_comment', ['date' => request()->user()?->block_period?->unblock_at->format('d F Y')]) }}
        </div>
    @endif
    <div class="col-md-12">
        <p class="">
            {{-- <span class="fw-semibold">{{ trans('community.title') }}: </span> --}}
            <span class="fw-semibold lead">{{ $community->title }}</span>
        </p>
    </div>

    <div class="col-md-12 d-flex justify-content-between">
        <p class="col-md-6 px-0">
            <span class="fw-semibold">{{ trans('community.category') }}: </span>
            <span class="text-capitalize">{{ $community->category }}</span>
        </p>
        <p class="col-md-6">
            <span class="fw-semibold">{{ trans('community.datetime') }}: </span>
            <span class="">{{ $community->created_at->format('d/m/Y h:i A') }}</span>
        </p>
    </div>

    <div class="col-md-12">
        @php
            $community_reported = is_reported('community', $community->id);
        @endphp
        <div class="flex-between mb-2">
            <span class="fw-semibold">{{ trans('community.message') }}: </span>
            <button class="btn btn-sm btn-genix @if ($community->user_id === auth()->id()) d-none @endif"
                wire:click="toggleReportModel('community',{{ $community->id }})"
                {{ $community_reported ? 'disabled' : '' }}>
                {{ $community_reported ? trans('community.reported') : trans('community.report') }}
            </button>
        </div>
        <p>{{ $community->message }}</p>
    </div>

    @if ($community->files)
        @php
            $files = is_string($community->files) ? json_decode($community->files, true) : $community->files;
        @endphp
        <div class="col-md-12 service-task d-flex flex-wrap mt-3">
            @foreach ($files as $file)
                @if ($file['type'] === 'image')
                    <img src="{{ $file['file'] }}" alt="image"
                        class="img-fluid mb-2 mx-2 rounded cursor-pointer model-img"
                        onclick="showImage('{{ $file['file'] }}')">
                @else
                    <video src="{{ $file['file'] }}" class="img-fluid mb-2 mx-2 rounded cursor-pointer"
                        controls></video>
                @endif
            @endforeach
        </div>
    @endif



    {{-- comments --}}
    <div class="col-12 mt-2">
        <div class="flex-between">
            <h4>{{ trans('community.comments') }} ({{ $comments_count }})</h4>
            @if (request()->user()->can_comment)
                <span class="cursor-pointer fs-20" title="New Comment" wire:click="toggleShowComment"><i
                        class="bi bi-plus-circle"></i></span>
            @endif
        </div>
        @if ($comment_show)
            <div class="d-flex mt-2">
                <div class="form-group flex-1 w-100 mb-0">
                    <input id="comment" type="text" class="form-control form-control-sm shadow-none"
                        wire:model='comment' placeholder="{{ __('Comment') }}">
                </div>
                <button class="btn btn-genix ml-2" wire:click="addComment"
                    wire:loading.attr="disabled">{{ trans('community.comment') }}</button>
            </div>
        @endif


        {{-- comments --}}
        @foreach ($comments as $comment)
            @php
                $comment_reported = is_reported('comment', $comment->id);
            @endphp
            <div class="border-bottom py-2">
                <p class="mb-0 lead">{{ $comment->comment }}</p>

                @if ($is_edit && $edit_id == $comment->id)
                    <div class="d-flex my-2">
                        <div class="form-group flex-1 w-100 mb-0">
                            <input id="comment" type="text" class="form-control form-control-xs shadow-none"
                                wire:model='comment' placeholder="{{ __('Comment') }}">
                        </div>
                        <button class="btn btn-xs btn-genix ml-2" wire:click="updateComment({{ $comment->id }})"
                            wire:loading.attr="disabled">{{ trans('community.update') }}</button>
                    </div>
                @endif


                <div class="flex-between">
                    <small class="">{{ $comment->user->name }}</small>
                    <small class="">{{ $comment->created_at->format('d/m/Y H:i A') }}</small>
                    @if (!is_reported('comment', $comment->id, 'other'))
                        <small class="text-genix cursor-pointer @if ($comment->user_id !== auth()->id()) invisible @endif"
                            wire:click="editComment({{ $comment->id }})">{{ trans('community.edit') }}</small>
                        <small class="text-genix cursor-pointer @if ($comment->user_id !== auth()->id()) invisible @endif"
                            wire:click="deleteComment({{ $comment->id }})">{{ trans('community.delete') }}</small>
                    @endif
                    <button class="btn btn-sm btn-genix @if ($comment->user_id === auth()->id()) invisible @endif"
                        wire:click="toggleReportModel('comment',{{ $comment->id }})"
                        {{ $comment_reported ? 'disabled' : '' }}>
                        {{ $comment_reported ? trans('community.reported') : trans('community.report') }}
                    </button>
                    @if (request()->user()->can_comment)
                        <span class="cursor-pointer fs-20" title="Reply"
                            wire:click="toggleSubComment({{ $comment->id }})"><i class="bi bi-reply"></i></span>
                    @endif
                </div>

                {{-- sub comment add show --}}
                @if ($sub_comment_show && $sub_comment_id === $comment->id)
                    <div class="d-flex mt-2">
                        <div class="form-group flex-1 w-100 mb-0">
                            <input id="comment" type="text" class="form-control form-control-xs shadow-none"
                                wire:model='comment' placeholder="{{ __('Comment') }}">
                        </div>
                        <button class="btn btn-xs btn-genix ml-2" wire:click="addSubComment"
                            wire:loading.attr="disabled">{{ trans('community.reply') }}</button>
                    </div>
                @endif

                {{-- sub comments show --}}
                <div class="pl-3">
                    @foreach ($comment->sub_comments as $item)
                        @php
                            $sub_report = is_reported('comment', $item->id);
                        @endphp
                        <div class="@if (!$loop->last) border-bottom @endif py-2">
                            <p class="mb-0">{{ $item->comment }}</p>

                            @if ($is_edit && $edit_id == $item->id)
                                <div class="d-flex my-2">
                                    <div class="form-group flex-1 w-100 mb-0">
                                        <input id="comment" type="text"
                                            class="form-control form-control-xs shadow-none" wire:model='comment'
                                            placeholder="{{ __('Comment') }}">
                                    </div>
                                    <button class="btn btn-xs btn-genix ml-2"
                                        wire:click="updateComment({{ $item->id }})">{{ trans('community.update') }}</button>
                                </div>
                            @endif

                            <div class="col-md-8 pl-0 flex-between mt-2">
                                <small class="">{{ $item->user->name }}</small>
                                <small class="">{{ $item->created_at->format('d/m/Y H:i A') }}</small>
                                @if (!is_reported('comment', $item->id, 'other'))
                                    <small
                                        class="text-genix cursor-pointer @if ($item->user_id !== auth()->id()) invisible @endif"
                                        wire:click="editComment({{ $item->id }})">{{ trans('community.edit') }}</small>
                                    <small
                                        class="text-genix cursor-pointer @if ($item->user_id !== auth()->id()) invisible @endif"
                                        wire:click="deleteComment({{ $item->id }})">{{ trans('community.delete') }}</small>
                                @endif
                                <button class="btn btn-sm btn-genix @if ($item->user_id === auth()->id()) invisible @endif"
                                    wire:click="toggleReportModel('comment',{{ $item->id }})"
                                    {{ $sub_report ? 'disabled' : '' }}>
                                    {{ $sub_report ? trans('community.reported') : trans('community.report') }}
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <!-- Report model -->
    <div class="modal fade @if ($is_report) show @endif"
        style="display: @if ($is_report) block @else none @endif;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header px-3 py-2">
                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('garage.reasons_to_report') }}</h5>
                    <button type="button" class="close" style="margin-top: -87px; margin-right:-35px;"
                        wire:click="toggleReportModel">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body py-2 px-3">
                    <form wire:submit.prevent="reportComment">
                        <div class="form-group text-left">
                            <label for="reason">{{ trans('garage.reason') }}</label>
                            <textarea id="reason" class="form-control" rows="4"
                                placeholder="{{ trans('community.reason_to_report') }}" required wire:model="reason"></textarea>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-genix">{{ trans('garage.report') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show" id="backdrop"
        style="display: @if ($is_report) block @else none @endif;">
    </div>

</div>
