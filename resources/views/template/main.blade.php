<!DOCTYPE html>
<html lang="en" data-layout-mode="detached" data-topbar-color="dark" data-menu-color="light" data-sidenav-user="true">

<head>
    <meta charset="utf-8" />
    <title>{{ $title }} | {{ env('APP_NAME') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ url('/') }}/assets/images/favicon.ico">

    @yield('pluginsCSS')
    <!-- Theme Config Js -->
    <script src="{{ url('/') }}/assets/js/hyper-config.js"></script>

    <!-- App css -->
    <link href="{{ url('/') }}/assets/css/app-modern.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="{{ url('/') }}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">


        @include('template.topbar')
        @include('template.sidebar')
        {{-- @method("DELETE") --}}
        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        @yield('content')

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    @include('template.themeSetting')
    <!-- Vendor js -->
    <script src="{{ url('/') }}/assets/js/vendor.min.js"></script>

    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
    </script>

    @yield('pluginsJS')
    <!-- App js -->
    <script src="{{ url('/') }}/assets/js/app.min.js"></script>


    @if ($errors->any())
        <script>
            var htmlData = "";

            $.each(@json($errors->all()), function(indexInArray, valueOfElement) {
                htmlData += "<li>" + valueOfElement + "</li>";
            });
            Toast.fire({
                icon: "error",
                html: htmlData
            });
        </script>
    @endif

    @if (session('success'))
        <script>
            Toast.fire({
                icon: "success",
                title: "{{ session('success') }}"
            });
        </script>
    @endif
</body>

</html>
