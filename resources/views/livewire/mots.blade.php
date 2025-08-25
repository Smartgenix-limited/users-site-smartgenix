<div class="table-responsive">
    <table class="table table-hover">
        <thead class="bg-genix text-white">
            <tr>
                <th scope="col">{{ trans('general.garage') }}</th>
                <th scope="col">{{ trans('general.car') }}</th>
                <th scope="col">{{ trans('general.price') }}</th>
                <th scope="col">{{ trans('general.payment') }}</th>
                <th scope="col">{{ trans('general.status') }}</th>
                <th scope="col">{{ trans('general.datetime') }}</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @php
                $sign = support_setting('currency_symbol');
            @endphp
            @forelse ($mots as $mot)
                <tr>
                    <td>{{ $mot->garage->name }}</td>
                    <td>{{ $mot->car->car_name }}</td>
                    <td>{{ $sign }}{{ $mot->price }}</td>
                    <td class="text-capitalize">{{ $mot->payment }}</td>
                    <td class="text-capitalize">{{ $mot->status }}</td>
                    <td>{{ $mot->datetime }}</td>
                    <td>
                        <a href="{{ route('mots.show', $mot) }}" class="text-genix fs-18 text-decoration-none pr-3"
                            title="{{ trans('general.show', ['type' => 'MOT']) }}">
                            <i class="bi bi-eye-fill"></i>
                        </a>
                        @if ($mot->datetime > now())
                            @if ($mot->status !== 'completed')
                                <a href="{{ route('mots.edit', $mot) }}"
                                    class="text-genix fs-18 pr-3 text-decoration-none"
                                    title="{{ trans('general.edit', ['type' => 'MOT']) }}">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            @endif
                        @endif

                        <span class="text-danger cursor-pointer fs-18"
                            title="{{ trans('general.delete', ['type' => 'MOT']) }}"
                            onclick="deleteMot({{ $mot->id }})">
                            <i class="bi bi-x-circle"></i>
                        </span>
                        <form id="mot-{{ $mot->id }}" action="{{ route('mots.destroy', $mot) }}" method="Post">
                            @csrf
                            @method('delete')
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">{{ trans('general.no_record') }}</td>
                </tr>
            @endforelse

        </tbody>
    </table>
    {{ $mots->links() }}
</div>
