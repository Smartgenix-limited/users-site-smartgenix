<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-size: 1rem;
            font-family: "Nunito", sans-serif;
            font-weight: initial;
            line-height: normal;
        }

        .main-content {
            padding: 1.5rem;
        }

        .text-center {
            text-align: center;
        }

        .semibold {
            font-weight: 600;
        }

        .bold {
            font-weight: bold;
        }

        .btn-genix {
            display: inline-block;
            font-weight: 400;
            color: #212529;
            text-align: center;
            border: 1px solid transparent;
            padding: 0.34rem 0.5rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            color: #fff;
            background-color: #1d345e;
            border-color: #1d345e !important;
        }

        .decoration-none {
            text-decoration: none;
        }

        .py-1 {
            padding: 0.5rem 0;
        }

        .py-2 {
            padding: 0.75rem 0;
        }

        .py-3 {
            padding: 1rem 0;
        }

        .pb-1 {
            padding-bottom: 0.5rem;
        }

        .pb-2 {
            padding-bottom: 0.75rem;
        }

        .pb-3 {
            padding-bottom: 1rem;
        }

        .pt-1 {
            padding-top: 0.5rem;
        }

        .pt-2 {
            padding-top: 0.75rem;
        }

        .pt-3 {
            padding-top: 1rem;
        }

        .pl-3 {
            padding-left: 1rem;
        }

        .pl-4 {
            padding-left: 1.5rem;
        }

        .pl-5 {
            padding-left: 2rem;
        }

        .fs-18 {
            font-size: 18px;
        }

        .fs-20 {
            font-size: 20px;
        }

        .fs-25 {
            font-size: 25px;
        }

        ul>li {
            list-style-type: disc;
        }

        .center {
            display: flex;
            justify-content: center;
        }

        .logo {
            max-width: 100%;
            height: 45px;
            margin: auto;
            vertical-align: middle;
        }

        .bg-genix {
            background-color: #1d345e;
        }

        .p-1 {
            padding: 0.50rem;
        }

        .flex-col {
            flex-direction: column;
        }

        .items-center {
            align-items: center
        }
    </style>
</head>

<body>
    <div>
        @php
            $company = support_setting('app_name');
        @endphp
        @include('mails.header')

        <main class="main-content">
            @php
                $garage = $repair->garage?->name;
            @endphp
            <h5 class="semibold py-2">Dear {{ $user->name }},</h5>
            <p class="pb-2">We've created a repair job for your vehicle:</p>
            <div class="py-3 text-center">
                <h5 class="fs-18 pb-2">Garage: {{ $garage }}</h5>
                <h5 class="fs-18 pb-2">Vehicle: {{ $car?->name }}</h5>
                <h5 class="fs-18 pb-2">Registration: {{ $car?->reg }}</h5>
                <h5 class="fs-18 pb-2">Description: {{ $repair->repair_work_message->description }}</h5>

            </div>
            <p class="pb-2">The details have been sent to {{ $garage }}, who will provide you with a quote for
                the
                requested work soon. For a more accurate estimate, you may want to take your vehicle to
                {{ $garage }}
                for further inspection. We recommend doing this as soon as possible to get the work started.</p>
            <p class="pb-2">After examining your vehicle, {{ $garage }} will send you a quote, which you can
                review
                and approve on our app or website. Once you've made the payment, {{ $garage }} will provide a date
                and
                time for you to drop off your vehicle. All work completed will be logged in our system for your
                convenience
                and future reference.</p>
            <p class="pb-2">If you have any questions, please contact {{ $garage }} at
                {{ $repair->garage?->telephone }}.</p>

            @include('mails.footer', ['company' => $company])
        </main>

    </div>

</body>

</html>
