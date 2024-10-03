<!DOCTYPE html>
<html lang="en" class="light">
<!-- BEGIN: Head -->

<head>
    <meta charset="utf-8">
    <link href="{{ asset('dist/images/favicon.png') }}" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="LEFT4CODE">
    <title>@yield('title') | My Affirmation</title>
    <!-- BEGIN: CSS Assets-->
    <link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" />
    @vite(['resources/css/app.css'])
    {{-- toastr css --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <!-- END: CSS Assets-->
    @stack('styles')
</head>
<!-- END: Head -->

<body class="main">
    
    <!-- BEGIN: Top Bar -->
    @include('partials.header')
    <!-- END: Top Bar -->
    <div class="wrapper">
        <div class="wrapper-box">
            <!-- BEGIN: Side Menu -->
            @include('partials.sidebar')
            <!-- END: Side Menu -->
            <!-- BEGIN: Content -->
            @yield('content')
            <!-- END: Content -->
        </div>
    </div>

    @include('partials.footer')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    {{-- datatable js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    {{-- toastr js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <script>
        $(document).ready(function() {

            toastr.options = {
                "toastClass": "toastr-custom",
                "timeOut": 30000,
                "extendedTimeOut": 0,
                "positionClass": "toast-top-right"
            };

            @if (Session::has('error'))
                toastr.error("{{ Session('error') }}");
            @elseif (Session::has('success'))
                toastr.success("{{ session('success') }}");
            @endif
        });
    </script>
    @stack('scripts')
</body>

</html>
