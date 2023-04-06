<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Information Data Analityc</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url('assets') ?>/dist/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url('assets') ?>/dist/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url('assets') ?>/dist/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets') ?>/dist/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets') ?>/dist/css/adminlte.min.css?<?= date('Y-m-d H:i:s') ?>">
    <link rel="stylesheet" href="<?= base_url('assets') ?>/dist/css/jquery-ui.css">
    <!-- jQuery -->
    <script src="<?= base_url('assets') ?>/dist/js/jquery.min.js"></script>

    <!-- <script src="https://code.jquery.com/jquery-3.6.0.js"
			integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script> -->
    <script src="<?= base_url('assets') ?>/dist/js/sweetalert2.all.min.js"></script>

    <link rel="stylesheet" href="<?= base_url('assets') ?>/dist/css/jquery.timepicker.min.css">
    <script src="<?= base_url('assets') ?>/dist/js/jquery.timepicker.min.js"></script>

    <!-- pagination freeze -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>dist/css/fixedColumns.dataTables.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>dist/css/fixedHeader.dataTables.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"> -->

    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>dist/select2/css/select2.min.css">

    <!--  -->
    <script src="<?= base_url('assets/dist/js') ?>/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets/dist/js') ?>/dataTables.fixedColumns.min.js"></script>
    <!-- filtter -->
    <script src="<?= base_url('assets/dist/js') ?>/dataTables.fixedHeader.min.js"></script>

    <!-- tags input -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets') ?>/dist/css/jquery-tagsinput.min.css" />
    <script src="<?= base_url('assets') ?>/dist/js/jquery-tagsinput.min.js" defer></script>

</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <!-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li> -->
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item mr-2">
                    <span class="font-italic font-bold">Welcome <?= $this->session->userdata('name') ?></span>
                </li>
                <li class="nav-item">
                    <a class=" btn btn-sm btn-info" href="<?= base_url('Logout') ?>">
                        <i class="fas fa-user"></i> LOGOUT
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <!-- <aside class="main-sidebar sidebar-dark-primary elevation-4"> -->
        <aside class="main-sidebar sidebar-dark-info elevation-4">
            <!-- Brand Logo -->
            <a href="<?= base_url('assets') ?>/index3.html" class="brand-link">
                <img src="<?= base_url('assets') ?>/dist/img/logo.jpeg" alt="AdminLTE Logo" style='margin-left:2px' class="brand-image img-square elevation-5" style="opacity: .8">

                <label class="brand-text font-bold font-weight-light" style="font-size: 14px"><b>ASTRA DAIHATSU MOTOR</b></label>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= base_url('assets') ?>/dist/img/security.png" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block" style="font-size: 14px">Information & Data Analityc</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item ">
                            <a href="<?= base_url('Dashboard') ?>" class="nav-link
                            <?php if ($link == 'Dashboard' || $link == '') {
                                echo 'active';
                            } ?>">
                                <i class="nav-icon fas fa-tachometer-alt "></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <!-- <i class="fas fa-building-shield"></i> -->
                                <p>
                                    Crime
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Upload Data</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Dashboard</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <!-- <i class="fas fa-building-shield"></i> -->
                                <p>
                                    Information
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Upload Data</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Dashboard</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>
                                    Aplikasi
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Security Guard Tour</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Analityc</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <?= $contents ?>

            <!-- Main content -->

            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer fixed">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; 2022 <a href="#">Information & Data Analityc</a></strong>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->


    <!-- Bootstrap 4 -->
    <script src="<?= base_url('assets') ?>/dist/js/bootstrap.min.js"></script>
    <!--<script src="<?= base_url('assets') ?>/dist/js/bootstrap.bundle.min.js"></script>-->
    <!-- AdminLTE App -->
    <script src="<?= base_url('assets') ?>/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?= base_url('assets') ?>/dist/js/demo.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="<?= base_url('assets') ?>/dist/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets') ?>/dist/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url('assets') ?>/dist/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url('assets') ?>/dist/js/responsive.bootstrap4.min.js"></script>
    <script src="<?= base_url('assets') ?>/dist/js/dataTables.buttons.min.js"></script>
    <script src="<?= base_url('assets') ?>/dist/js/buttons.bootstrap4.min.js"></script>
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
</script>

</html>