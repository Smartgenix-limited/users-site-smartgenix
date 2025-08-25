@if ($type === 'mot')
    <button class="btn btn-xs btn-genix mb-2" wire:click="setReminder('{{ $reminder_type }}')"
        {{ $car->$reminder_type ? 'disabled' : '' }}>{{ trans('garage.set_reminder') }}</button>
@else
    <button class="btn btn-xs btn-genix mb-2" wire:click="setReminder('{{ $reminder_type }}')"
        {{ $car->$reminder_type ? 'disabled' : '' }}>{{ trans('garage.set_reminder') }}</button>
@endif
