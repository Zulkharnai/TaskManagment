<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DualSysco | Dashboard</title>

    {{-- datatable --}}
    <link rel="stylesheet" href="{{url('public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{url('public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{url('public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('public/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{url('public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{url('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{url('public/plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('public/dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{url('public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{url('public/plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{url('public/plugins/summernote/summernote-bs4.min.css')}}">
   <!-- SweetAlert2 -->
   <link rel="stylesheet" href="{{ url('public/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
  <!-- jQuery -->
<script src="{{url('public/plugins/jquery/jquery.min.js')}}"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <h1>DualSysco</h1>
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('Dashboard')}}" class="brand-link">
                <img src="{{ url('public/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Task Manager</span>
            </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="{{url('public/Admin')}}/{{$profile[0]->user_image}}" width="60px" height="60px" alt="User Image" style="width: 40px; height: 40px;">
            </div>
            <div class="info">
              <a href="#" class="d-block">{{$profile[0]->user_first_name}} {{$profile[0]->user_last_name}}</a>
            </div>
          </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <li class="nav-item">
            <a href="{{route('EmployeeDashboard')}}" class="nav-link">
              {{-- <i class="nav-icon fas fa-th"></i> --}}
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-check"></i>
              <p>
                Task
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('EmployeeTask')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Task</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('Completed')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Completed Task</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('Pending')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pending Task</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{route('EmployeeProfile')}}" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Profile
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        @yield('content')
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<script>
    function alertmsg(msg, type) {
    $("#error").removeClass().html('').show();
    $("#error").addClass(`alert alert-${type} text-center`).html(msg);
    $("#error").fadeOut(3000);
    }
    </script>


<!-- jQuery UI 1.11.4 -->
<script src="{{url('public/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <!-- datatable -->
<script src="{{url('public/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{url('public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{url('public/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{url('public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{url('public/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{url('public/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{url('public/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{url('public/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{url('public/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>{{-- colvis --}}
<script src="{{url('public/plugins/jszip/jszip.min.js')}}"></script>{{-- excel --}}
<script src="{{url('public/plugins/pdfmake/pdfmake.min.js')}}"></script>{{-- pdf --}}
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{url('public/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{url('public/plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{url('public/plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{url('public/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{url('public/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{url('public/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{url('public/plugins/moment/moment.min.js')}}"></script>
<script src="{{url('public/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{url('public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{url('public/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{url('public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url('public/dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{url('public/dist/js/demo.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{url('public/dist/js/pages/dashboard.js')}}"></script>

  <!-- //sweet Alert -->
  <script src="{{ url('public/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <!-- Sweet Aleert Toast -->
  <script src="{{ url('public/plugins/toastr/toastr.min.js') }}"></script>
  <script src="{{ url('public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.1/js/bootstrap-colorpicker.min.js">

</body>
</html>
