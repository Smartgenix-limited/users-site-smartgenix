<div>
    @include('partials.errors')
    <div class="form-group">
        <label for="upload{{ $iteration }}">{{ trans('general.images_videos') }}</label>
        <input type="file" id="upload{{ $iteration }}" class="form-control form-control-sm mt-1 mb-2"
            wire:model="attachments" multiple>
    </div>
    <input type="hidden" name="images" wire:model="images_files">
    <input type="hidden" name="videos" wire:model="videos_files">

    <!-- showing files -->
    @if (count($files) > 0)
        <div class="support d-flex flex-wrap">
            @foreach ($files as $index => $file)
                @if ($file['type'] === 'image')
                    <div class="position-relative mb-3">
                        <img src="{{ $file['file'] }}" alt="image" class="img-fluid mb-2 mx-2 rounded">
                        <span wire:click="delete_file({{ $loop->index }},'{{ $file['file'] }}')"
                            class="cursor-pointer fs-25"><i
                                class="bi bi-x text-danger position-absolute delete-task"></i></span>
                    </div>
                @else
                    <div class="position-relative mb-3">
                        <video src="{{ $file['file'] }}" controls class="mb-2 px-4 rounded">
                        </video>
                        <span wire:click="delete_file({{ $loop->index }},'{{ $file['file'] }}')"
                            class="cursor-pointer fs-25"><i
                                class="bi bi-x text-danger position-absolute delete-task-video"></i></span>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
    <div class="text-center mt-4">
        {{-- wire:target="attachments" --}}
        <button type="submit" id="subBtn" class="btn btn-primary"
            wire:loading.attr="disabled">{{ trans('general.submit') }}</button>
    </div>
</div>
