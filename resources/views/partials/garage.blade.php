<div class="d-flex justify-content-between mt-2">
    <a href="tel:{{ country(garage()->country)?->code . garage()->telephone }}"
        class="btn btn-sm btn-genix">{{ trans('general.contact_garage') }}</a>
    <a href="https://www.google.com/maps/place/{{ garage()->latitude }}+{{ garage()->longitude }}/data=!4m2!3m1!7e2"
        target="_blank" class="btn btn-sm btn-genix">{{ trans('general.direction_garage') }}</a>
</div>
{{-- {{ dd(garage()) }} --}}
