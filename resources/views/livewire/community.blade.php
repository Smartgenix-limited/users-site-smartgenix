<div class="row">
    <div class="col-md-6 offset-md-3 cursor-pointer d-flex flex-wrap" style="gap:5px;">
        <span class="@if ($type === 'all') pb-1 text-info border-bottom-genix @endif"
            wire:click="changeType('all')">{{ trans('community.all_question') }}</span>
        <span class="@if ($type === 'my') pb-1 text-info border-bottom-genix @endif mx-3"
            wire:click="changeType('my')">{{ trans('community.my_question') }}</span>
        <span class="@if ($type === 'comments') pb-1 text-info border-bottom-genix @endif"
            wire:click="changeType('comments')">{{ trans('community.my_comments') }}</span>

    </div>

    <div class="col-12 my-4">
        <input type="text" class="form-control form-control-sm" placeholder="{{ trans('general.search') }}"
            wire:model="search">
    </div>

    {{-- thread will show here --}}
    <div class="col-12">
        @if ($type !== 'comments')
            @forelse ($communities as $community)
                <a href="{{ route('communities.show', $community) }}"
                    class="text-genix text-decoration-none d-block d-flex justify-content-between align-items-center {{ $type === 'all' ? 'mb-3' : '' }}">
                    <div class="pr-4 d-flex flex-column flex-col">
                        <h5>{{ $community->title }}</h5>
                        <p class="pb-0 mb-0">{{ str()->limit($community->message, 100) }}</p>
                        <small>{{ $community->created_at->format('d/m/Y h:i A') }}</small>
                    </div>
                    <span class="fs-30"><i class="bi bi-arrow-right-short"></i></span>
                </a>
                @if ($type === 'my' && !is_reported('community', $community->id, 'other'))
                    <div class="mb-3">
                        <a href="{{ route('communities.edit', $community) }}"
                            class="text-genix text-decoration-none">{{ __('general.edit', ['type' => '']) }}</a>
                        <span class="text-genix cursor-pointer ml-2" onclick="deleteCommunity({{ $community->id }})">
                            {{ __('general.delete', ['type' => '']) }}
                        </span>
                        <form id="community-{{ $community->id }}"
                            action="{{ route('communities.destroy', $community) }}" method="post">
                            @csrf
                            @method('delete')
                        </form>
                    </div>
                @endif
            @empty
                <p>{{ trans('community.no_question') }}</p>
            @endforelse
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" style="width:70%;">{{ trans('community.comment') }}</th>
                            <th scope="col">{{ trans('community.posted_at') }}</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($communities as $comment)
                            <tr>
                                <td style="width:70%;">{{ str()->limit($comment->comment, 40) }}</td>
                                <td>{{ $comment->created_at->format('d-m-Y h:i A') }}</td>
                                <td>
                                    <a href="{{ route('communities.show', $comment->community_id) }}"
                                        class="text-genix fs-18 text-decoration-none pr-1">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    @if (!is_reported('comment', $comment->id, 'other'))
                                        <span class="text-genix fs-18 cursor-pointer text-danger"
                                            wire:click="deleteComment({{ $comment->id }})">
                                            <i class="bi bi-x-circle"></i>
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">{{ trans('community.no_comments') }}</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

        @endif

        {{-- categories --}}
        @if ($type === 'all')
            <div class="text-center">
                <h6>{{ trans('community.choose_category') }}</h6>
                <div class="btn-group btn-group-toggle d-flex flex-wrap d-md-inline" style="gap:5px;"
                    data-toggle="buttons">
                    @foreach ($categories as $item)
                        <button
                            class="btn custom-btn text-capitalize fw-semibold @if ($item === $category) btn-genix @else btn-outline-genix @endif"
                            wire:click="changeCategory('{{ $item }}')">{{ $item }}</button>
                    @endforeach
                </div>
            </div>
        @endif

        {!! $communities->links() !!}
    </div>
</div>
