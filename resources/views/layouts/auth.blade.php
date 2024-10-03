<!DOCTYPE html>
<html lang="en" class="light">
<!-- BEGIN: Head -->

<head>
    <meta charset="utf-8">
    <link href="{{ asset('dist/images/favicon.png') }}" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <title>@yield('title') | My Affirmation</title>
    <!-- BEGIN: CSS Assets-->
    <link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" />
    {{-- toastr css --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <!-- END: CSS Assets-->
</head>
<!-- END: Head -->

<body class="login">

    @yield('content')
    <!-- END: Dark Mode Switcher-->

    <!-- BEGIN: JS Assets-->
    <script src="{{ asset('dist/js/app.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    {{-- Client side validation-jquery --}}
    <script src="https://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
    <script src="https://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>

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
    <!-- END: JS Assets-->
</body>

</html>
