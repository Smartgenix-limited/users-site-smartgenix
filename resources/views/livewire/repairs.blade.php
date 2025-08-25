<div class="table-responsive">
    {{-- quotes --}}
    @if ($quotes->count() > 0)
        <table class="table table-hover mb-3">
            <thead class="bg-primary text-white">
                <tr>
                    <th scope="col">{{ trans('general.garage') }}</th>
                    <th scope="col">{{ trans('general.car') }}</th>
                    <th scope="col">{{ trans('general.price') }}</th>
                    <th scope="col">{{ trans('general.payment') }}</th>
                    <th scope="col">{{ trans('general.status') }}</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sign = support_setting('currency_symbol');
                @endphp
                @foreach ($quotes as $repair)
                    <tr>
                        <td>{{ $repair->garage->name }}</td>
                        <td>{{ $repair->car->car_name }}</td>
                        <td>{{ $sign }}{{ $repair->price ?? 0 }}</td>
                        <td class="text-capitalize">{{ $repair->payment }}</td>
                        <td class="text-capitalize">{{ $repair->status }}</td>
                        <td>
                            <a href="{{ route('repairs.show', $repair) }}"
                                class="text-genix fs-18 text-decoration-none pr-3"
                                title="{{ trans('general.show', ['type' => 'Quote']) }}">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                            <span class="text-danger cursor-pointer fs-18"
                                title="{{ trans('general.delete', ['type' => 'Quote']) }}"
                                onclick="deleteRepair({{ $repair->id }})">
                                <i class="bi bi-x-circle"></i>
                            </span>
                            <form id="repair-{{ $repair->id }}" action="{{ route('repairs.destroy', $repair) }}"
                                method="Post">
                                @csrf
                                @method('delete')
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    @endif

    {{-- repairs --}}
    <table class="table table-hover">
        <thead class="bg-primary text-white">
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
            @forelse ($repairs as $repair)
                <tr>
                    <td>{{ $repair->garage->name }}</td>
                    <td>{{ $repair->car->car_name }}</td>
                    <td>{{ $sign }}{{ $repair->price ?? 0 }}</td>
                    <td class="text-capitalize">{{ $repair->payment }}</td>
                    <td class="text-capitalize">{{ $repair->status }}</td>
                    <td>{{ $repair->datetime }}</td>
                    <td>
                        <a href="{{ route('repairs.show', $repair) }}"
                            class="text-genix fs-18 text-decoration-none pr-3" title="Show">
                            <i class="bi bi-eye-fill"></i>
                        </a>
                        {{-- @if ($repair->status !== 'completed')
                            <a href="{{ route('repairs.edit', $repair) }}"
                                class="text-genix fs-18 pr-3 text-decoration-none" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        @endif --}}
                        <span class="text-danger cursor-pointer fs-18" title="Delete"
                            onclick="deleteRepair({{ $repair->id }})">
                            <i class="bi bi-x-circle"></i>
                        </span>
                        <form id="repair-{{ $repair->id }}" action="{{ route('repairs.destroy', $repair) }}"
                            method="Post">
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
    {{ $repairs->links() }}
</div>
