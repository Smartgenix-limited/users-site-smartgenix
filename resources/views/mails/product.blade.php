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

        .pt-4 {
            padding-top: 1.5rem;
        }

        .pt-5 {
            padding-top: 2rem;
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

        .img-fluid {
            width: 100%;
            height: auto;
        }

        .w-50 {
            width: 50% !important;
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
            <p class="pb-2">Congratulating you on {{ $type }} a product on our marketplace,</p>
            <div class="text-center py-3">
                <h3 class="fs-25 semibold pb-2">{{ $type === 'buying' ? 'Buying' : 'Selling' }}</h3>
                <h5 class="fs-18 pb-2">{{ $product->title }}</h5>
                <h5 class="fs-18 pb-2">
                    {{ support_setting('currency_symbol') . number_format($product->price, 2, '.', ',') }}
                </h5>
                <h5 class="fs-18 pb-2">{{ $product->created_at->format('d F Y h:i A') }}</h5>
            </div>
            <div class="text-center py-3">
                <img src="{{ imageToBase64($product->images[0]) }}" alt="Product Image" class="w-50 img-fluid">
            </div>

            <p class="pb-2">You can view more information on this product by logging into our app or our website.</p>

            @include('mails.footer', ['company' => $company])
        </main>

    </div>

</body>

</html>
