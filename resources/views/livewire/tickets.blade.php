<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">{{ trans('general.department') }}</th>
                <th scope="col">{{ trans('general.subject') }}</th>
                <th scope="col">{{ trans('general.status') }}</th>
                <th scope="col">{{ trans('general.last_updated') }}</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tickets as $ticket)
                <tr>
                    <td class="text-capitalize">{{ $ticket->department }}</td>
                    <td>{{ $ticket->subject }}</td>
                    <td class="text-capitalize">{{ $ticket->status }}</td>
                    <td>{{ $ticket->updated_at->format('m/d/Y') }}</td>
                    <td>
                        <a href="{{ route('supports.show', $ticket) }}" class="btn btn-sm btn-genix"
                            title="{{ trans('general.view_ticket') }}">
                            {{ trans('general.view_ticket') }}
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">{{ trans('general.no_support_ticket') }} <a
                            href="{{ route('supports.create') }}"
                            class="btn-link">{{ trans('general.create_support_ticket') }}</a>
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>
    <div class="mt-2">
        {{ $tickets->links() }}
    </div>
</div>
