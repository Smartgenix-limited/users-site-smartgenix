<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ asset('assets/css/print.css') }}" media="all" />
</head>

<body>
    <header class="clearfix">
        <div id="logo">
            <img src="{{ asset('images/logo-small-black.png') }}">
        </div>
        <div id="company">
            @php
                $garage = garage();
            @endphp
            <h2 class="name">{{ $garage?->name }}</h2>
            <div>{{ $garage?->address }}</div>
            <div>{{ $garage?->telephone }}</div>
            <div>{{ $garage?->user?->email }}</div>
        </div>
        </div>
    </header>
    <main>
        @php
            $currency = support_setting('currency_symbol');
        @endphp
        <div id="details" class="clearfix">
            <div id="client">
                <div class="to">INVOICE TO:</div>
                <h2 class="name">{{ $car->user->name }}</h2>
                <div class="address">{{ $car->user->mobile }}</div>
                <div class="email">{{ $car->user->email }}</div>
            </div>
            <!-- pt-10 -->
            <div id="invoice">
                <div class="date">Car Name: {{ $car->car_name }}</div>
                <div class="date">Reg#: {{ $car->reg }}</div>
                <div class="date">Colour: {{ $car->colour }}</div>
                <div class="date">Mileage: {{ $car->mileage }}</div>
            </div>
        </div>
        <!-- mot history -->
        @if (count($car->mots) > 0)
            <h3 class="underline mt-3 mb-3">Mot History</h3>
            @foreach ($car->mots as $mot)
                <div class="d-flex justify-content-between mb-2">
                    <span class="h5">Date: {{ $mot->datetime->format('d/m/Y') }}</span>
                    <span class="h5 float-right">Time: {{ $mot->datetime->format('H:i A') }}</span>
                </div>
                {{-- <div class="d-flex justify-content-between">
                    <span class="h5">Price: {{ $currency }}{{ $mot->price }}</span>
                    <span class="h5 float-right">Test Number: {{ $mot->test_number }}</span>
                </div> --}}
                @if ($mot->mot_task)
                    <h4 class="text-center text-capitalize underline">Result : {{ $mot->mot_task->mot_status }}</h4>
                    <div class="px-md-4">
                        @foreach ($mot->mot_task->tasks as $task)
                            <div class="d-flex mb-2">
                                <span class="h6">{{ trans('general.task_comment') }}:</span>
                                <span class="h6 pl-3">{{ $task['comment'] ?? '' }}</span>
                            </div>
                            <div class="d-flex mb-2">
                                <span class="h6">{{ trans('general.task_type') }}:</span>
                                <span class="h6 pl-3 text-capitalize">{{ $task['type'] ?? '' }}</span>
                            </div>
                            <hr>
                        @endforeach
                    </div>
                @else
                    <h4 class="text-center text-capitalize underline">Result : Not Started</h4>
                @endif
                <hr>
                @if ($loop->last)
                    <hr class="last">
                @endif
            @endforeach
        @endif

        <!-- mot history end -->

        <!-- service history -->
        @if (count($car->services) > 0)
            <h3 class="underline mt-3 mb-3">Service History</h3>
            @foreach ($car->services as $service)
                <div class="d-flex justify-content-between mb-2">
                    <span class="h5">Date: {{ $service->datetime->format('d/m/Y') }}</span>
                    <span class="h5 float-right">Time: {{ $service->datetime->format('H:i A') }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="h5">Price: {{ $currency }}{{ $service->price }}</span>
                    <span class="h5 text-capitalize float-right">Type: {{ $service->type_of_service }}</span>
                </div>

                @if ($service->tasks->count() > 0)
                    <div style="">
                        <h4>Tasks Carried Out</h4>
                        <ol>
                            @foreach ($service->tasks as $task)
                                <li>{{ $task->task }}</li>
                            @endforeach
                        </ol>

                    </div>
                    <h4 class="text-center text-capitalize mt-5 underline">Status : {{ $service->status }}</h4>
                @else
                    <h4 class="text-center text-capitalize underline">Result : Not Started</h4>
                @endif

                <hr>
                @if ($loop->last)
                    <hr class="last">
                @endif
            @endforeach
            <!-- service history end -->
        @endif



        <!-- repairs history -->
        @if (count($car->repairs) > 0)
            <h3 class="underline mt-3 mb-3">Repairs History</h3>
            @foreach ($car->repairs as $repair)
                <div class="d-flex justify-content-between mb-2">
                    <span class="h5">Date: {{ $repair->datetime?->format('d/m/Y') }}</span>
                    <span class="h5 float-right">Time: {{ $repair->datetime?->format('H:i A') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="h5">Price: {{ $currency }}{{ $repair->price }}</span>
                </div>

                @if ($repair->tasks->count() > 0)
                    <div style="">
                        <h4>Tasks Carried Out</h4>
                        <ol>
                            @foreach ($repair->tasks as $task)
                                <li>{{ $task->task }}</li>
                            @endforeach
                        </ol>
                    </div>
                    <h4 class="text-center text-capitalize mt-5 underline">Status : {{ $repair->status }}</h4>
                @else
                    <h4 class="text-center text-capitalize underline">Result : Not Started</h4>
                @endif
                <hr>
                @if ($loop->last)
                    <hr class="last">
                @endif
            @endforeach
        @endif
        <!-- repairs history end -->

        <!-- recoveries history -->
        @if (count($car->recoveries) > 0)
            <h3 class="underline mt-3 mb-3">Recoveries History</h3>
            @foreach ($car->recoveries as $recovery)
                <div class="d-flex justify-content-between mb-2">
                    <span class="h5">Recovery To: <span
                            style="text-transform: capitalize;">{{ $recovery->type }}</span></span>
                    <span class="h5 float-right">Status: <span
                            style="text-transform: capitalize;">{{ $recovery->status }}</span></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="h5">Location: <span
                            style="text-transform: capitalize;">{{ $recovery->location }}</span></span>
                    <span class="h5 float-right">Price:
                        {{ $recovery->completer ? $currency . $recovery->completer->price : $currency . $recovery->price }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="h5">Date: {{ $recovery->created_at?->format('d/m/Y') }}</span>
                    <span class="h5 float-right">Time: {{ $recovery->created_at?->format('H:i A') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="h5">Roadside Assistance:
                        <span
                            style="text-transform: capitalize;">{{ $recovery->roadside_assistance ? 'Yes' : 'No' }}</span></span>
                </div>

                <hr>
                @if ($loop->last)
                    <hr class="last">
                @endif
            @endforeach
        @endif
        <!-- recoveries history end -->
    </main>
    {{-- <footer>
        Invoice was created on a computer and is valid without the signature and seal.
    </footer> --}}
</body>

</html>
