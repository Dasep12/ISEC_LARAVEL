<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Security Risk Survey - ISECURITY</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('assets/dist/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/dist/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/dist/css/buttons.bootstrap4.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('assets/dist/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css?') }}{{ date('Y-m-d H:i:s') }}">
        <link rel="stylesheet" href="{{ asset('assets/dist/css/jquery-ui.css') }}">
        <!-- jQuery -->
        <script src="{{ asset('assets/dist/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/dist/js/sweetalert2.all.min.js') }}"></script>

        <link rel="stylesheet" href="{{ asset('assets/dist/css/jquery.timepicker.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/dist/css/bootstrap-datepicker.css') }}">
        <script src="{{ asset('assets/dist/js/jquery.timepicker.min.js') }}"></script>

        <!-- pagination freeze -->
        <link rel="stylesheet" href="{{ asset('assets/dist/css/fixedColumns.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/dist/css/fixedHeader.dataTables.min.css') }}">
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ asset('assets/dist/select2/css/select2.min.css') }}">

        <link rel="stylesheet" href="{{ asset('assets/dist/datetimepicker/jquery.datetimepicker.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/dist/datetimerange/daterangepicker.css') }}">

        <script src="{{ asset('assets/dist/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/dist/js/dataTables.fixedColumns.min.js') }}"></script>
        <!-- filtter -->
        <script src="{{ asset('assets/dist/js/dataTables.fixedHeader.min.js') }}"></script>

        <!-- tags input -->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/dist/css/jquery-tagsinput.min.css') }}" />
        <script src="{{ asset('assets/dist/js/jquery-tagsinput.min.js') }}" defer></script>

        <script src='https://cdn.plot.ly/plotly-2.16.1.min.js'></script>

        <!-- TEMPLATE SRS CUSTOM -->
        <link rel="stylesheet" href="{{ asset('assets/css/srs.css?')}}{{ date('Y-m-d H:i:s') }}">

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
        <script type="text/javascript" src="{{ asset('assets/dist/js/kuma-gauge.jquery.js') }}"></script>

    </head>
    
<body class="hold-transition sidebar-mini sidebar-collapse layout-navbar-fixed">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <a href="{{ URL('menu') }}" class="btn btn-primary btn-sm"><i class="fas fa-home"></i></a>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto text-white">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item mr-2">
                    <span class="font-italic font-bold">Welcome {{ session('name') }}</span>
                </li>
                <li class="nav-item">
                    <a class=" btn btn-sm btn-info" href="{{ URL::route('auth.logout') }}">
                        <i class="fas fa-user"></i> LOGOUT
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <!-- <aside class="main-sidebar sidebar-dark-primary elevation-4"> -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4 position-fixed" style="padding-top: 8vh;">
            <!-- Brand Logo -->
            <a href="" class="brand-link">
                <img src="{{ asset('assets/dist/img/logo.jpeg') }}" alt="Logo" style='margin-left:2px' class="brand-image img-square elevation-5" style="opacity: .8">

                <label class="brand-text font-bold font-weight-light" style="font-size: 14px"><b>ASTRA DAIHATSU MOTOR</b></label>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('assets/dist/img/security.png') }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block" style="font-size: 14px">SECURITY RISK SURVEY</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item ">
                            <a href="{{ url('srs/dashboard') }}" class="nav-link
                            <?php if ($link == 'dashboard') {
                                echo 'active';
                            } ?>">
                                <i class="nav-icon fas fa-tachometer-alt "></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        <?php if (AuthHelper::is_module('SRSISO')) { ?>
                            <li class="nav-item {{ ($link !== '' && $link == 'dashboard_humint' || $link == 'humint_source') ? 'menu-open' : ''; }}">
                                <a href="#" class="nav-link ">
                                    <i class="nav-icon fas fa-share-alt-square"></i>
                                    <p>HUMINT Source</p>
                                </a>
                               <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('srs/dashboard_humint') }}" class="nav-link {{ ($link !== '' && $link == 'dashboard_humint') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Dashboard</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ url('srs/humint_source') }}" class="nav-link {{ ($link == 'humint_source') ? 'active' : ''; }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Input & View</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>

                        <?php if (AuthHelper::is_super_admin() || AuthHelper::is_module('SRSOSI')) { ?>
                        <li class="nav-item {{ ($link !== '' && $link == 'dashboard_osint' || $link == 'osint_source') ? 'menu-open' : '' }}">
                            <a href="{{ url('srs/osint') }}" class="nav-link">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    <!-- External Source -->
                                    OSINT Source
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('srs/dashboard_osint') }}" class="nav-link {{ ($link !== '' && $link == 'dashboard_osint') ? 'active' : ''; }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Dashboard</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('srs/osint_source') }}" class="nav-link {{ ($link == 'osint_source' &&  $sub_link != 'osint_source') ? 'active' : ''; }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Input & View</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php } ?>

                        <?php if (AuthHelper::is_module('SRSSOI')) { ?>
                            <li class="nav-item {{ ($link == 'dashboard_soi' || $link == 'soi') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-shield-alt"></i>
                                    <p>SOI</p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('srs/dashboard_soi') }}" class="nav-link {{ ($link !== '' && $link == 'dashboard_soi') ? 'active' : ''; }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Dashboard</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('srs/soi') }}" class="nav-link {{ ($link !== '' && $link == 'soi') ? 'active' : ''; }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Input & View</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        <?php } ?>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            
            @yield('content')

            <!-- Main content -->

            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer fixed">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; 2023 <a href="#">Security BigData Analytic</a></strong>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->


    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/dist/js/bootstrap.min.js') }}"></script>
    <!-- <script src="{{ asset('assets/dist/js/bootstrap.bundle.min.js') }}"></script> -->
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="{{ asset('assets/dist/js/demo.js') }}"></script> -->
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('assets/dist/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/buttons.bootstrap4.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/dist/js/jquery-ui.js') }}"></script>

    <!-- Date Time Picker -->
    <!-- <script type="text/javascript" src="{{ asset('assets/dist/datetimepicker/jquery.js') }}"></script> -->
    <script type="text/javascript" src="<?= asset('assets/dist/js/bootstrap-datepicker.min.js') ?>"></script>
    <script type="text/javascript" src="{{ asset('assets/dist/datetimepicker/jquery.datetimepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/dist/datetimerange/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/dist/datetimerange/daterangepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/dist/datetimerange/jquery.mask.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/dist/select2/js/select2.min.js') }}"></script>

        {{-- Laravel Vite - JS File --}}
        {{-- {{ module_vite('build-srs', 'Resources/assets/js/app.js') }} --}}

    <script>
        $(document).ready(function() {

            $('#datetimepicker2').datepicker({
                format: 'yyyy-mm-dd',
                defaultDate: true,
                autoclose: true,
            });

            $('#tgl13').datepicker({
                dateFormat: 'yy-mm-dd',
                autoclose: true
            });
            $('#tgl23').datepicker({
                dateFormat: 'yy-mm-dd',
                autoclose: true
            });

            $('#datetimepicker').datetimepicker({
                defaultDate: true,
                defaultTime: true,
            });

            $(".js-select2").select2({
                closeOnSelect: false,
                placeholder: "-- Choose --",
                allowHtml: true,
                allowClear: true,
                tags: true
            });
        });
    </script>
    </body>
</html>
