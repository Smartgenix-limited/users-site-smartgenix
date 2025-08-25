<div class="col-12 mt-4" wire:poll>
    {{-- wire:poll --}}
    @if ($recovery->status !== App\Enums\RecoveryStatus::Completed || !$recovery->approved)
        <div class="d-flex">
            <div class="form-group flex-1 w-100 mb-0">
                <input id="comment" type="text" class="form-control form-control-sm shadow-none" wire:model='comment'
                    placeholder="{{ __('Comment') }}">
            </div>
            <button class="btn btn-genix ml-2" wire:click="addComment">{{ trans('general.add') }}</button>
        </div>
    @endif
    <!---- message shows here ---->
    <hr />
    @if ($recovery->status === App\Enums\RecoveryStatus::Completed && $recovery->approved)
        <h5 class="mt-3">{{ trans('community.comments') }}</h5>
    @endif
    @foreach ($comments as $comment)
        @if ($comment->sender_id !== auth()->id())
            <div class="d-flex">
                <p class="border rounded p-1">{{ $comment->comment }}</p>
            </div>
        @else
            <div class="d-flex flex-row-reverse">
                <p class="border rounded p-1">{{ $comment->comment }}</p>
            </div>
        @endif
    @endforeach
</div>
