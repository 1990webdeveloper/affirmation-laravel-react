<!DOCTYPE html>
<html lang="en" class="light">
<!-- BEGIN: Head -->

<head>
    <meta charset="utf-8">
    <link href="dist/images/logo.svg" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Icewall admin is super flexible, powerful, clean & modern responsive tailwind admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Icewall Admin Template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="LEFT4CODE">
    <title>@yield('title')</title>
    <!-- BEGIN: CSS Assets-->
    <link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" />
    <!-- END: CSS Assets-->
</head>
<!-- END: Head -->

<body class="main error-main" style="padding: 0px;">
    <div class="container">
        <!-- BEGIN: Error Page -->
        <div class="error-page flex flex-col items-center justify-center h-screen text-center">
            <div class="p-5 rounded-full error-rounded flex flex-col items-center justify-center">
                <div class="-intro-x">
                    <img alt="img" class="w-5 mx-auto" src="{{ asset('dist/images/404.svg') }}">
                </div>
                <div class="text-white mt-10 lg:mt-5">
                    {{-- <div class="intro-x text-8xl font-medium">@yield('code')</div> --}}
                    @yield('message')
                    <a href="{{ route('dashboard') }}"
                        class="intro-x btn py-3 px-4 border-0 bg-theme mt-10">Back
                        to Home</a>
                </div>
            </div>
        </div>
        <!-- END: Error Page -->
    </div>

    <!-- BEGIN: JS Assets-->
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=[" your-google-map-api"]&libraries=places"></script>
    <script src="{{ asset('dist/js/app.js') }}"></script>
    <!-- END: JS Assets-->
</body>

</html>
