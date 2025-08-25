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
    </style>
</head>

<body>
    <div>
        @php
            $company = support_setting('app_name');
        @endphp
        @include('mails.header')

        <main class="main-content">
            <h5 class="semibold py-2">Dear {{ $user->name }},</h5>
            <p class="pb-2">Congratulations on choosing {{ $garage->name }} as your provider for all your vehicle
                needs!
                Here are the details for your selected garage:</p>
            <div class="py-3 items-center">
                <h5 class="pb-2 semibold">Name: {{ $garage->name }}</h5>
                <h5 class="pb-2 semibold">Address: {{ $garage->address }}</h5>
                <h5 class="pb-2 semibold">City: {{ $garage->city }}</h5>
                <h5 class="pb-2 semibold">Postcode: {{ $garage->postcode }}</h5>
                <h5 class="pb-2 semibold">Country: {{ $garage->country }}</h5>
                <h5 class="pb-2 semibold">Telephone: {{ $garage->telephone }}</h5>
            </div>
            <p class="pb-2">From now on, all the jobs you create will be sent to this company. You may also explore
                membership options they offer to enjoy loyalty discounts. To check out {{ $garage->name }}'s
                memberships,
                simply log in to our app or website.</p>
            <p class="pb-2">If you wish to change your selected garage later, you can do so at any time by logging in
                and
                clicking on "Selected Garage." You can also leave a review for the company to help other users.</p>
            <p class="pb-2">If you have any questions or concerns, please don't hesitate to reach out by raising a
                support
                ticket or emailing queries@smartgenx.co.uk.</p>

            @include('mails.footer', ['company' => $company])
        </main>

    </div>

</body>

</html>
