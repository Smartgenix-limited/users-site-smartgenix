<div class="@if ($notices->count() > 0) mb-4 @endif">
    @foreach ($notices as $item)
        <div class="alert alert-success alert-dismissible mb-2">
            <h3 class="alert-heading mb-3 text-black">{{ $item->title }}</h3>
            <p class="text-black">{!! $item->notice !!}</p>
            <button type="button" class="close" wire:click="readNotice({{ $item->id }})">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endforeach
</div>
