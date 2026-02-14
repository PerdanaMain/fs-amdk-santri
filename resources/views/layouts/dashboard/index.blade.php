<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        @yield('title') | {{ config('app.name') }}
    </title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('dashboards/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboards/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboards/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboards/vendors/typicons/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboards/vendors/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboards/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    {{-- Data tables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

    <link href="{{ asset('dashboards/vendors/select2-bootstrap-theme/select2.bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dashboards/vendors/select2/select2.min.css') }}" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('dashboards/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />
</head>

<body>
    <div class="container-scroller">
        @include('layouts.dashboard.navbar')

        <div class="container-fluid page-body-wrapper">
            @include('layouts.dashboard.setting')

            @include('layouts.dashboard.sidebar')

            <div class="main-panel">
                @yield('content.dashboard')
                <!-- content-wrapper ends -->

                @include('layouts.dashboard.footer')
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- plugins:js -->
    <script src="{{ asset('dashboards/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('dashboards/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('dashboards/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('dashboards/vendors/progressbar.js/progressbar.min.js') }}"></script>

    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('dashboards/js/off-canvas.js') }}"></script>
    <script src="{{ asset('dashboards/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('dashboards/js/template.js') }}"></script>
    <script src="{{ asset('dashboards/js/settings.js') }}"></script>
    <script src="{{ asset('dashboards/js/todolist.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{ asset('dashboards/js/dashboard.js') }}"></script>
    <script src="{{ asset('dashboards/js/Chart.roundedBarCharts.js') }}"></script>
    <!-- End custom js for this page-->

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="{{ asset('dashboards/vendors/select2/select2.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    @stack('dashboard.script')
</body>

</html>
