<div class="table-responsive">
    <table class="table table-hover">
        <thead class="bg-genix text-white">
            <tr>
                <th scope="col"></th>
                <th scope="col">{{ trans('general.name') }}</th>
                <th scope="col">{{ trans('general.mileage') }}</th>
                <th scope="col">{{ trans('general.reg') }}</th>
                <th scope="col" style="width: 10%;"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cars as $car)
                <tr>
                    <td>
                        <img src="{{ $car->image ?? asset('assets/images/car.png') }}" alt="Car Image"
                            class="img-circle-sm">
                    </td>
                    <td>{{ $car->car_name }}</td>
                    <td>{{ $car->mileage }}</td>
                    <td>{{ $car->reg }}</td>
                    <td style="width: 10%;">
                        <a href="{{ route('garage.edit', $car) }}" class="pr-3 btn btn-sm btn-primary"
                            title="{{ trans('general.edit', ['type' => 'Car']) }}">
                            {{ trans('general.edit', ['type' => '']) }}
                            {{-- <i class="bi bi-pencil-square fs-18"></i> --}}
                        </a>
                        <a href="{{ route('garage.show', $car) }}" class="btn btn-sm btn-primary"
                            title="{{ trans('general.view', ['type' => 'Car']) }}">{{ trans('general.view', ['type' => '']) }}</i></a>
                        {{-- <i class="bi bi-eye-fill fs-20"> --}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">{{ trans('general.no_record') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $cars->links() }}
</div>
