<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Security Big Data Analytic</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/jquery-ui.css') }}">
    <!-- jQuery -->
    <script src="{{ asset('assets/dist/js/jquery.min.js') }}"></script>

    <!-- <script src="https://code.jquery.com/jquery-3.6.0.js"
			integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script> -->
    <script src="{{ asset('assets/dist/js/sweetalert2.all.min.js') }}"></script>


    <!-- DataTables -->

    <link rel="stylesheet" href="{{ asset('assets/dist/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />

    <!-- pagination freeze -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/fixedColumns.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/fixedHeader.dataTables.min.css ') }}">
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"> -->

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/dist/select2/css/select2.min.css') }}">

    <!-- <link rel="stylesheet" href="{{ asset('assets/dist/datetimepicker/jquery.datetimepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/datetimerange/daterangepicker.css') }}"> -->

    <!--  -->
    <script src="{{ asset('assets/dist/js/jquery.dataTables.min.js') }} "></script>
    <script src="{{ asset('assets/dist/js/dataTables.fixedColumns.min.js') }}"></script>
    <!-- filtter -->
    <script src="{{ asset('assets/dist/js/dataTables.fixedHeader.min.js') }}"></script>

    <!-- tags input -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/dist/css/jquery-tagsinput.min.css') }}" />
    <script src="{{ asset('assets/dist/js/jquery-tagsinput.min.js') }}" defer></script>

    <script src='https://cdn.plot.ly/plotly-2.16.1.min.js'></script>
    <script src='https://cdn.plot.ly/plotly-2.16.1.min.js'></script>

    <!-- TEMPLATE SRS CUSTOM -->
    <link rel="stylesheet" href="{{ asset('assets/css/soa.css') }}<?= '?' . date('H:i:s') ?>">

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/dist/js/kuma-gauge.jquery.js ') }}"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <style>
        /* Absolute Center Spinner */
        .loading {
            position: fixed;
            z-index: 999;
            height: 2em;
            width: 2em;
            overflow: show;
            margin: auto;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
        }

        /* Transparent Overlay */
        .loading:before {
            content: '';
            display: block;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(rgba(20, 20, 20, .4), rgba(0, 0, 0, .4));

            background: -webkit-radial-gradient(rgba(20, 20, 20, .4), rgba(0, 0, 0, .4));
        }

        /* :not(:required) hides these rules from IE9 and below */
        .loading:not(:required) {
            /* hide "loading..." text */
            font: 0/0 a;
            color: transparent;
            text-shadow: none;
            background-color: transparent;
            border: 0;
        }

        .loading:not(:required):after {
            content: '';
            display: block;
            font-size: 10px;
            width: 1em;
            height: 1em;
            margin-top: -0.5em;
            -webkit-animation: spinner 150ms infinite linear;
            -moz-animation: spinner 150ms infinite linear;
            -ms-animation: spinner 150ms infinite linear;
            -o-animation: spinner 150ms infinite linear;
            animation: spinner 150ms infinite linear;
            border-radius: 0.5em;
            -webkit-box-shadow: rgba(255, 255, 255, 0.75) 1.5em 0 0 0, rgba(255, 255, 255, 0.75) 1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) 0 1.5em 0 0, rgba(255, 255, 255, 0.75) -1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) -1.5em 0 0 0, rgba(255, 255, 255, 0.75) -1.1em -1.1em 0 0, rgba(255, 255, 255, 0.75) 0 -1.5em 0 0, rgba(255, 255, 255, 0.75) 1.1em -1.1em 0 0;
            box-shadow: rgba(255, 255, 255, 0.75) 1.5em 0 0 0, rgba(255, 255, 255, 0.75) 1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) 0 1.5em 0 0, rgba(255, 255, 255, 0.75) -1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) -1.5em 0 0 0, rgba(255, 255, 255, 0.75) -1.1em -1.1em 0 0, rgba(255, 255, 255, 0.75) 0 -1.5em 0 0, rgba(255, 255, 255, 0.75) 1.1em -1.1em 0 0;
        }

        /* Animation */

        @-webkit-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @-moz-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @-o-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        .modal-fullscreen-xl .modal-dialog {
            width: 100% !important;
            height: 100% !important;
        }

        .modal-fullscreen-xl .modal-content {
            height: 100% !important;
            width: 100% !important;
        }

        #map2 {
            height: 400px;
        }

        #map {
            height: 400px;
        }

        #map_karawang {
            height: 400px;
        }

        .row>* {
            padding: 10px 0;
        }

        .cardIn {
            border: none;
            border-width: 1px 1px 1px 1px;
            border-color: #ccc;
            border-style: solid;
            border-radius: 0
        }

        .cardIn2 {
            border: none;
            border-width: 1px 0px 1px 1px;
            border-color: #ccc;
            border-style: solid;
            border-radius: 0
        }

        ul .first {
            margin-right: 10px;
        }

        ul .five,
        .third {
            margin-left: 14px;
        }

        .first::marker {
            content: url('https://www.securityadm.my.id/isec/assets/img/info/list_icon.png');
            padding-left: 20px;
            position: relative;
        }

        .second::marker {
            content: url('https://www.securityadm.my.id/isec/assets/img/info/list_icon_2.png');
        }

        .third::marker {
            content: url('https://www.securityadm.my.id/isec/assets/img/info/list_icon_3.png');
        }

        .four::marker {
            content: url('https://www.securityadm.my.id/isec/assets/img/info/list_icon_4.png');
        }

        .five::marker {
            content: url('https://www.securityadm.my.id/isec/assets/img/info/list_icon_5.png');
        }

        .dropbtn {
            background-color: #04AA6D;
            color: white;
            padding: 16px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        .dropbtn:hover,
        .dropbtn:focus {
            background-color: #3e8e41;
        }

        #myDropdown2 a:hover,
        #myDropdown a:hover {
            background-color: #3e8e41;
            cursor: pointer;

        }

        #myInput {
            box-sizing: border-box;
            background-image: url('searchicon.png');
            background-position: 14px 12px;
            background-repeat: no-repeat;
            font-size: 16px;
            padding: 14px 20px 12px 45px;
            border: none;
            border-bottom: 1px solid #ddd;
        }

        #myInput:focus {
            outline: 3px solid #ddd;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f6f6f6;
            min-width: 230px;
            overflow: auto;
            border: 1px solid #ddd;
            z-index: 999;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        /* .dropdown a:hover {
      background-color: #ddd;
    } */

        .show {
            display: block;
        }

        .show_hide {
            display: none;
        }
    </style>
</head>
<!-- <div style="display:none;" id="loader" class="loading">Loading&#8230;</div> -->

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
            <a href="/isecurity_laravel/menu" class="btn btn-primary btn-sm"><i class="fas fa-home"></i></a>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item mr-2">
                    <span class="font-italic font-bold">Welcome {{ session('name') }} </span>
                </li>
                <li class="nav-item">
                    <a class=" btn btn-sm btn-info" href="/logout">
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
            <a href="" class="brand-link">
                <img src="{{ asset('assets/dist/img/logo.jpeg') }}" alt="AdminLTE Logo" style='margin-left:2px' class="brand-image img-square elevation-5" style="opacity: .8">

                <label class="brand-text font-bold font-weight-light" style="font-size: 14px"><b>ASTRA DAIHATSU MOTOR</b></label>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div style="padding-left:0" class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center justify-content-center">
                    <div class="image pr-2">
                        <img style="width: 2.8rem;" src="{{ asset('assets/dist/img/security.png') }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block font-weight-bold" style="font-size: 17px">Security<br>Operation Analytic</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item ">
                            <a href="dashboard" class="nav-link 
                            @if($uri == 'dashboard')
                                active  
                            @endif">
                                <i class="nav-icon fas fa-tachometer-alt "></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a href="upload" class="nav-link 
                            @if($uri == 'upload')
                                active  
                            @endif">
                                <i class="nav-icon fas fa-file-excel "></i>
                                <p>
                                    Upload
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
            <strong>Copyright &copy; 2023 <a href="#">Security Big Data Analytic</a></strong>
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


    <!-- <script src="/dist/js/bootstrap.bundle.min.js"></script> -->
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="/dist/js/demo.js"></script> -->
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('assets/dist/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/buttons.bootstrap4.min.js') }}"></script>
    <!-- date-range-picker -->

    <script type="text/javascript" src="{{ asset('assets/dist/js/jquery-ui.js') }}"></script>

    <!-- Date Time Picker -->
    <!-- <script type="text/javascript" src="{{ asset('assets/dist/datetimepicker/jquery.datetimepicker.js') }}"></script> -->
    <script type="text/javascript" src="{{ asset('assets/dist/datetimerange/moment.min.js') }}"></script>
    <!-- <script type="text/javascript" src="{{ asset('assets/dist/datetimerange/daterangepicker.min.js') }}"></script> -->
    <script type="text/javascript" src="{{ asset('assets/dist/select2/js/select2.min.js') }}"></script>
</body>
<script>
    $(document).ready(function() {

    });
</script>

</html>