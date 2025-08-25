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
            /* Center horizontally */
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
            <h2 class="text-center bold fs-20 pt-2">Congratulations!!!</h2>
            <h5 class="semibold py-2">Dear {{ $user->name }},</h5>
            <p class="pb-2">We want to take you this time to congratulate you on creating your {{ $user->type }}
                account
                with us.</p>
            <p class="pb-2">Login to your account and start recording.</p>
            <p class="pb-2">If you have not done so yet, download our app from the app stores</p>
            <div class="text-center py-3">
                <a href="{{ support_setting('apple_store_link') }}" class="btn-genix decoration-none">Apple</a>
                <a href="{{ support_setting('play_store_link') }}" class="btn-genix decoration-none">Android</a>
            </div>
            <p class="pb-2">After you have download the app, check out some of our features</p>
            <ul class="pl-5 pb-2">
                <li>Book Services</li>
                <li>Book Repairs</li>
                <li>Book Recoveries</li>
                <li>Request work to be completed</li>
            </ul>
            <p class="pb-2">So much more to do, what are you waiting for</p>
            <p class="">Kind regards,</p>
            <h5 class="semibold">Mr M Asim</h5>
            <p>Founder, {{ $company }} Limited</p>
        </main>

    </div>

</body>

</html>
