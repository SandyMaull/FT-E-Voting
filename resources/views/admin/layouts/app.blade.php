<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/hokusei-logo.png') }}" sizes="16x16">


    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('admin_asset/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('admin_asset/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('admin_asset/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    @yield('css')
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin_asset/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        @include('admin.layouts.navbar')
        @include('admin.layouts.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('breadcrumb')
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                    {{-- {{dd(session('message'))}} --}}
                </div>
                <!--/. container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        @include('admin.layouts.footer')
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ asset('admin_asset/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('admin_asset/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('admin_asset/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

    @yield('script')
    
    <!-- AdminLTE App -->
    <script src="{{ asset('admin_asset/dist/js/adminlte.js') }}"></script>

    {{-- <!-- OPTIONAL SCRIPTS -->
    <script src="{{ asset('admin/dist/js/demo.js') }}"></script> --}}

    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->
    <script src="{{ asset('admin_asset/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
    <script src="{{ asset('admin_asset/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('admin_asset/plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
    <script src="{{ asset('admin_asset/plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('admin_asset/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('admin_asset/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- PAGE SCRIPTS -->
    {{-- <script src="{{ asset('admin/dist/js/pages/dashboard2.js') }}"></script> --}}
    @if (session('status') == 'sukses')
    <script type="text/javascript">
      $(function() {
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });
    
        Toast.fire({
          icon: 'success',
          title: '{{session('message')}}'
        })
            
        
      });
    
    </script>
    @endif
    @if (session('status') == 'error')
    <script type="text/javascript">
      $(function() {
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });
    
        Toast.fire({
          icon: 'error',
          title: '{{session('message')}}'
        })
            
        
      });
      
    
    </script>
    @endif
    @if ($errors->count() > 0)
        @foreach ($errors->all() as $error)
        <script type="text/javascript">
            var error = '{{ $error }}';
            $(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'error',
                title: error
            });
            });
        </script>
        @endforeach
    @endif
</body>

</html>
