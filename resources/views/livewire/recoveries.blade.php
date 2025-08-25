<div class="row">
    @php
        $currency = support_setting('currency_symbol');
    @endphp
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">{{ trans('recoveries.car_name') }}</th>
                        <th scope="col">{{ trans('recoveries.recovery_to') }}</th>
                        <th scope="col">{{ trans('general.price') }}</th>
                        <th scope="col">{{ trans('general.status') }}</th>
                        <th scope="col">{{ trans('general.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recoveries as $recovery)
                        <tr>
                            <td>{{ $recovery->car->model }}</td>
                            <td class="text-capitalize">{{ $recovery->type }}</td>
                            <td>{{ $recovery->completer ? $currency . $recovery->completer->price : '-' }}
                            </td>
                            <td class="text-capitalize">{{ $recovery->status }}</td>
                            <td>
                                <a href="{{ route('recoveries.show', $recovery) }}"
                                    class="text-genix fs-18 text-decoration-none pr-3"
                                    title="{{ trans('general.show', ['type' => 'Recovery']) }}">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <a href="{{ route('recoveries.edit', $recovery) }}"
                                    class="text-genix fs-18 pr-3 text-decoration-none"
                                    title="{{ trans('general.edit', ['type' => 'Recovery']) }}">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <span class="text-danger cursor-pointer fs-18"
                                    title="{{ trans('general.delete', ['type' => 'Recovery']) }}"
                                    onclick="deleteRecovery({{ $recovery->id }})">
                                    <i class="bi bi-x-circle"></i>
                                </span>
                                <form id="recovery-{{ $recovery->id }}"
                                    action="{{ route('recoveries.destroy', $recovery) }}" method="Post">
                                    @csrf
                                    @method('delete')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">{{ trans('general.no_record') }}</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
</div>
