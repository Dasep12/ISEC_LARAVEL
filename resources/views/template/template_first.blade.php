<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ISECURITY</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/buttons.bootstrap4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::asset('assets/dist/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}?') }}{{date('Y-m-d H:i:s')}}">
    <link rel="stylesheet" href="{{ URL::asset('assets/dist/css/jquery-ui.css') }}">
    <!-- jQuery -->
    <script src="{{ asset('assets/dist/js/jquery.min.js') }}"></script>

    <!-- <script src="https://code.jquery.com/jquery-3.6.0.js') }}"
            integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script> -->
    <script src="{{ asset('assets/dist/js/sweetalert2.all.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('assets/dist/css/jquery.timepicker.min.css') }}">
    <script src="{{ asset('assets/dist/js/jquery.timepicker.min.js') }}"></script>

    <!-- pagination freeze -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/fixedColumns.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/fixedHeader.dataTables.min.css') }}">
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css') }}"> -->

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/dist/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <!--  -->
    <script src="{{ asset('assets/dist/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/dataTables.fixedColumns.min.js') }}"></script>
    <!-- filtter -->
    <script src="{{ asset('assets/dist/js/dataTables.fixedHeader.min.js') }}"></script>

    <!-- tags input -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/dist/css/jquery-tagsinput.min.css') }}" />

    <!-- TEMPLATE SRS CUSTOM -->
    <link rel="stylesheet" href="{{ asset('assets/css/gt.css') }}?') }}{{ date('Y-m-d H:i:s') }}">
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/dist/newStyle.css') }}" /> -->

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

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto text-white">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item mr-2">
                    <span class="font-italic font-bold">Welcome {{ session('name') }}</span>
                </li>
                <li class="nav-item">
                    <a class=" btn btn-sm btn-info" href="Logout">
                        <i class="fas fa-user"></i> LOGOUT
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <!-- <aside class="main-sidebar sidebar-dark-primary elevation-4"> -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <img src="{{ asset('assets/dist/img/logo.jpeg') }}" alt="AdminLTE Logo" style='margin-left:2px' class="brand-image img-square elevation-5" style="opacity: .8">
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
                        <a href="#" class="d-block" style="font-size: 14px">ISECURITY</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2 ">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item ">
                            <a href="Menu" class="nav-link
                            <?php if ($link == 'Menu' || $link == '') {
                                echo 'active';
                            } ?>">
                                <i class="nav-icon fas fa-tachometer-alt "></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        <!-- user_role() == 'ADMIN' -->
                        <?php if (AuthHelper::is_super_admin() || AuthHelper::is_app('SOP')) { ?>
                            <li class="nav-header">Security</li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <!-- <i class="nav-icon fas fa-coeg"></i> -->
                                    <i class="nav-icon fas fa-layer-group"></i>
                                    <p>
                                        Security Operation
                                        <i class="right fas fa-angle-right"></i>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    <i class="nav-icon fas fa-columns"></i>
                                    <p>
                                        Security Admin
                                        <i class="right fas fa-angle-right"></i>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    <i class="nav-icon fas fa-book"></i>
                                    <p>
                                        Security Information
                                        <i class="right fas fa-angle-right"></i>
                                    </p>
                                </a>
                            </li>
                        <?php } ?>

                        <li class="nav-header">Data Analytic</li>

                        <?php if (AuthHelper::is_super_admin() || AuthHelper::is_app('SRS')) { ?>
                            <li class="nav-item">
                                <a href="analitic/srs/dashboard" class="nav-link">
                                    <i class="nav-icon fas fa-chart-pie"></i>
                                    <p>
                                        Security Risk Survey
                                        <i class="right fas fa-angle-right"></i>
                                    </p>
                                </a>
                            </li>
                        <?php  } ?>
                        <?php if (AuthHelper::is_super_admin() || AuthHelper::is_app('CRI')) { ?>
                            <li class="nav-item">
                                <a href="analitic/crime/Crime/dashboard" class="nav-link">
                                    <i class="nav-icon fas fa-chart-pie"></i>
                                    <p>
                                        Crime Index
                                        <i class="right fas fa-angle-right"></i>
                                    </p>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (AuthHelper::is_super_admin() || AuthHelper::is_app('ALTA')) { ?>
                            <li class="nav-item">
                                <a href="analitic/information/Anggota/dashboard" class="nav-link">
                                    <i class="nav-icon fas fa-chart-pie"></i>
                                    <p>
                                        Analytic Anggota
                                        <i class="right fas fa-angle-right"></i>
                                    </p>
                                </a>
                            </li>
                            <!--  -->
                        <?php } ?>

                        <!-- user_role() == 'ADMIN' is_app('SGT') -->
                        <?php if (AuthHelper::is_super_admin() || AuthHelper::is_app('SGT')) { ?>
                            <li class="nav-header">Aplikasi</li>
                            <li class="nav-item">
                                <a href="guardtour/dashboard" class="nav-link">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        Security Guard Tour
                                        <i class="right fas fa-angle-right"></i>
                                    </p>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (AuthHelper::is_super_admin()) { ?>
                            <li class="nav-header">Settings</li>
                            <li class="nav-item
                        <?php if (Request::segment(3) == 'register' || Request::segment(3) == 'list_app' || Request::segment(3) == 'list_user' || Request::segment(3) == 'list_app_user' || Request::segment(3) == 'edit_pwd' || Request::segment(3) == 'edit' || Request::segment(3) == 'list_module' || Request::segment(3) == 'list_role' || Request::segment(3) == 'list_role_app' || Request::segment(3) == 'list_user_role_app') {
                                echo 'menu-open active';
                            } ?>
                         ">
                                <a href="#" class="nav-link
                            ">
                                    <i class="nav-icon fas fa-copy"></i>
                                    <p>
                                        Settings
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="Setting/Pengguna/list_user" class="nav-link
                                    <?php if (Request::segment(3) == 'list_user' || Request::segment(3) == 'register' || Request::segment(3) == 'edit_pwd' || Request::segment(3) == 'edit') {
                                        echo 'active';
                                    } ?>
                                    "><i class="fas fa-minus-circle nav-icon"></i>
                                            <p>User</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="Setting/MasterRole/list_role" class="nav-link 
                                        <?php if (Request::segment(3) == 'list_role') {
                                            echo 'active';
                                        } ?>">
                                            <i class="fas fa-minus-circle nav-icon"></i>
                                            <p>Master Roles</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="Setting/UserRoleApp/list_user_role_app" class="nav-link 
                                        <?php if (Request::segment(3) == 'list_user_role_app') {
                                            echo 'active';
                                        } ?>">
                                            <i class="fas fa-minus-circle nav-icon"></i>
                                            <p>Master Role User App</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="Setting/MasterAplikasi/list_app" class="nav-link 
                                        <?php if (Request::segment(3) == 'list_app') {
                                            echo 'active';
                                        } ?>">
                                            <i class="fas fa-minus-circle nav-icon"></i>
                                            <p>Master Aplikasi</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="Setting/MasterModule/list_module" class="nav-link 
                                        <?php if (Request::segment(3) == 'list_module') {
                                            echo 'active';
                                        } ?>">
                                            <i class="fas fa-minus-circle nav-icon"></i>
                                            <p>Master Modules</p>
                                        </a>
                                    </li>



                                    <li class="nav-item">
                                        <a href="Setting/MasterRoleApp/list_role_app" class="nav-link 
                                        <?php if (Request::segment(3) == 'list_role_app') {
                                            echo 'active';
                                        } ?>">
                                            <i class="fas fa-minus-circle nav-icon"></i>
                                            <p>Master Roles Apps</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="Setting/AksesApp/list_app_user" class="nav-link 
                                        <?php if (Request::segment(3) == 'list_app_user') {
                                            echo 'active';
                                        } ?>">
                                            <i class="fas fa-minus-circle nav-icon"></i>
                                            <p>Akses Aplikasi</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>

                        <!--  -->
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->

            @include($contents)

            <!-- Main content -->

            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer fixed">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; 2022 <a href="#">ISECURITY</a></strong>
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
    <!--<script src="{{ asset('assets/dist/js/bootstrap.bundle.min.js') }}"></script>-->
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('assets/dist/js/demo.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('assets/dist/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/dist/select2/js/select2.min.js') }}"></script>
    <!-- date-range-picker -->
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
</body>
<script>
    $("#example2").DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    })

    $('#tgl1,#tgl2').datepicker({
        dateFormat: 'yy-mm-dd',
        autoclose: true
    });
    $('#tgl13').datepicker({
        dateFormat: 'yy-mm-dd',
        autoclose: true
    });
    $('#tgl23').datepicker({
        dateFormat: 'yy-mm-dd',
        autoclose: true
    });

    $('#name_apps,#level_name,#module_name,#level_id,#npk').select2();
</script>

</html>