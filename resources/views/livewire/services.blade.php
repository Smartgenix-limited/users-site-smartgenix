<div class="table-responsive">
    <table class="table table-hover">
        <thead class="bg-primary text-white">
            <tr>
                <th scope="col">{{ trans('general.garage') }}</th>
                <th scope="col">{{ trans('general.car') }}</th>
                <th scope="col">{{ trans('general.service_type') }}</th>
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
            @forelse ($services as $service)
                <tr>
                    <td>{{ $service->garage->name }}</td>
                    <td>{{ $service->car->car_name }}</td>
                    <td class="text-capitalize">{{ $service->type_of_service }}</td>
                    <td>{{ $sign }}{{ $service->price }}</td>
                    <td class="text-capitalize">{{ $service->payment }}</td>
                    <td class="text-capitalize">{{ $service->status }}</td>
                    <td>{{ $service->datetime }}</td>
                    <td>
                        <a href="{{ route('services.show', $service) }}"
                            class="text-genix fs-18 text-decoration-none pr-3"
                            title="{{ trans('general.show', ['type' => 'Service']) }}">
                            <i class="bi bi-eye-fill"></i>
                        </a>
                        @if ($service->datetime > now())
                            @if ($service->status !== 'completed')
                                <a href="{{ route('services.edit', $service) }}"
                                    class="text-genix fs-18 pr-3 text-decoration-none"
                                    title="{{ trans('general.edit', ['type' => 'Service']) }}">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            @endif
                        @endif
                        <span class="text-danger cursor-pointer fs-18"
                            title="{{ trans('general.delete', ['type' => 'Service']) }}"
                            onclick="deleteService({{ $service->id }})">
                            <i class="bi bi-x-circle"></i>
                        </span>
                        <form id="service-{{ $service->id }}" action="{{ route('services.destroy', $service) }}"
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
    {{ $services->links() }}
</div>
