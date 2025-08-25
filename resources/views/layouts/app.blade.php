<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="smartgenix description">

    <title>{{ config('app.name', 'Smart Genix') }}</title>

    <link rel="icon" type="image/x-icon" href="{{ file_url(support_setting('favicon')) }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vertical-layout-light/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/utils.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    @stack('style')
    @livewireStyles
</head>

<body class="sidebar-icon-only">
    <div id="app" class="container-scroller">
        <!-- navbar start -->
        @include('layouts.header')
        <!-- navbar end -->
        <div class="container-fluid page-body-wrapper">
            <!-- sidebar start -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                @include('layouts.menu')
            </nav>
            <!-- partial -->
            <div class="main-panel">
                <!-- content-wrapper starts -->
                <div class="content-wrapper">
                    @yield('content')
                    <!-- The Modal -->
                    <div id="imageModel" class="popup-modal">
                        <span class="close text-danger" onclick="closeImageModel()">&times;</span>
                        <img class="popup-modal-content" id="image" />
                        <div id="caption"></div>
                    </div>
                    <!-- card body end -->
                </div>
                <!-- content-wrapper ends -->
                <!-- footer -->
                <footer class="footer">
                    <div class="d-flex justify-content-center">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">{{ trans('general.copyright') }}
                            ©
                            {{ date('Y') }}.
                            <a href="http://smartgenix.co.uk/" class="text-genix" target="_blank">{{ config('app.name') }}</a>
                            {{ trans('general.rights_reserved') }}.</span>
                    </div>
                </footer>
                <!-- footer end-->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    @vite(['resources/js/app.js'])
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    @stack('scripts')
    {{-- <script>
        document.getElementById("startInput").addEventListener("changeDate", function(e) {
            Livewire.emit('changeDate', e.detail.datepicker.inputField.value)
        });
    </script> --}}
    <script>
        function garageChange(id) {
            document.getElementById('garage_id').value = id;
            document.getElementById('selectGarage').submit();
        }

        let modal = document.getElementById("imageModel");

        function showImage(image) {
            let modalImg = document.getElementById("image");
            modal.style.display = "block";
            modalImg.src = image;
        }

        function closeImageModel() {
            modal.style.display = "none";
        }

        // remove error if car selected
        function carSelected() {
            if (!$('#errorMesg').hasClass('d-none')) {
                $('#errorMesg').addClass('d-none');
            }
        }

        $('#form').on('submit', function(e) {
            $('#subBtn').attr("disabled", 'disabled');
        });
    </script>
    @livewireScripts
</body>

</html>