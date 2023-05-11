<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Security Guard Tour</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/dist/img/logo.jpeg') }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/buttons.bootstrap4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <!-- jQuery -->
    <script src="{{ asset('assets/dist/js/jquery.min.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/dist/js/sweetalert2.all.min.js') }}"></script>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

    <!-- pagination freeze -->
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.0.2/css/fixedColumns.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.dataTables.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"> -->

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/dist/select2/css/select2.min.css') }}">

    <!--  -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.0.2/js/dataTables.fixedColumns.min.js"></script>
    <!-- filtter -->
    <script src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js"></script>

    <!-- tags input -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/dist/css/jquery-tagsinput.min.css') }}" />
    <script src="{{ asset('assets/dist/js/jquery-tagsinput.min.js ') }}" defer></script>
    <!-- <link rel="stylesheet" type="text/css" href="assets/dist/newStyle.css" /> -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/dist/css/gt.css') }}" />

    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
    <script src="{{ asset('assets/dist/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>

    <style>

    </style>
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
            <a href="#" class="btn btn-primary btn-sm"><i class="fas fa-home"></i></a>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto text-white">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item mr-2">
                    <span class="font-italic font-bold">Welcome <?= 'DASEP' ?></span>
                </li>
                <li class="nav-item">
                    <a class=" btn btn-sm btn-info" href="#">
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
            <a href="#" class="brand-link">
                <img src="{{ asset('assets/dist/img/logo.jpeg') }}" alt="AdminLTE Logo" style='margin-left:2px' class="brand-image img-square elevation-5" style="opacity: .8">

                <label style="margin-left:-5px" class="brand-text font-bold font-weight-light"><b>Astra Daihatsu
                        Motor</b></label>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('assets/dist/img/security.png') }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">GUARD PATROL</a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <!-- <div class="form-inline">
				<div class="input-group" data-widget="sidebar-search">
					<input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
					<div class="input-group-append">
						<button class="btn btn-sidebar">
							<i class="fas fa-search fa-fw"></i>
						</button>
					</div>
				</div>
			</div> -->

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
		   with font-awesome or any other icon font library -->
                        <li class="nav-item ">
                            <a href="#" class="nav-link 
                                @if($uri == 'dashboard' )
                                active  
                             @endif">
                                <i class="nav-icon fas fa-tachometer-alt "></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-exclamation-circle"></i>
                                <p>
                                    Abnormality <span class="right badge badge-primary" id="badge_total_temuan">0</span>
                                </p>
                            </a>
                        </li>

                        <li class="nav-item 
                            @if($uri == 'site/master' || $uri == 'site/form_add' || $uri == 'site/form_edit' || $uri == 'plant/master' || $uri == 'plant/form_add' || $uri == 'plant/form_edit' || $uri == 'company/master' || $uri == 'company/form_add' || $uri == 'company/form_edit' || $uri == 'zona/master' || $uri == 'zona/form_add' || $uri == 'zona/form_edit' || $uri == 'checkpoint/master' || $uri == 'checkpoint/form_add' || $uri == 'checkpoint/form_edit' || $uri == 'kategori_objek/master' || $uri == 'kategori_objek/form_add' || $uri == 'kategori_objek/form_edit' || $uri == 'objek/master' || $uri == 'objek/form_add' || $uri == 'objek/form_edit'  || $uri == 'event/master' || $uri == 'event/form_add' || $uri == 'event/form_edit' || $uri == 'shift/master' || $uri == 'shift/form_add' || $uri == 'shift/form_edit' || $uri == 'produksi/master' || $uri == 'produksi/form_add' || $uri == 'produksi/form_edit' || $uri == 'users/master' || $uri == 'users/form_add' || $uri == 'users/form_edit' || $uri == 'role/master' || $uri == 'role/form_add' || $uri == 'role/form_edit' || $uri == 'users_ga/master' || $uri == 'users_ga/form_add' || $uri == 'users_ga/form_edit' || $uri == 'settings/master' || $uri == 'settings/form_add' || $uri == 'settings/form_edit')
                                menu-open  
                             @endif">
                            <a href="#" class="nav-link
                            @if($uri == 'site/master' || $uri == 'site/form_add' || $uri == 'site/form_edit' || $uri == 'plant/master' || $uri == 'plant/form_add' || $uri == 'plant/form_edit' || $uri == 'company/master' || $uri == 'company/form_add' || $uri == 'company/form_edit' || $uri == 'zona/master' || $uri == 'zona/form_add' || $uri == 'zona/form_edit' || $uri == 'checkpoint/master' || $uri == 'checkpoint/form_add' || $uri == 'checkpoint/form_edit'  || $uri == 'kategori_objek/master' || $uri == 'kategori_objek/form_add' || $uri == 'kategori_objek/form_edit' || $uri == 'objek/master' || $uri == 'objek/form_add' || $uri == 'objek/form_edit'  || $uri == 'event/master' || $uri == 'event/form_add' || $uri == 'event/form_edit' || $uri == 'shift/master' || $uri == 'shift/form_add' || $uri == 'shift/form_edit' || $uri == 'produksi/master' || $uri == 'produksi/form_add' || $uri == 'produksi/form_edit' || $uri == 'users/master' || $uri == 'users/form_add' || $uri == 'users/form_edit' || $uri == 'role/master' || $uri == 'role/form_add' || $uri == 'role/form_edit' || $uri == 'users_ga/master' || $uri == 'users_ga/form_add' || $uri == 'users_ga/form_edit' || $uri == 'settings/master' || $uri == 'settings/form_add' || $uri == 'settings/form_edit')
                                active  
                             @endif
                             ">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    Master
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('company.master') }}" class="nav-link 
                                    @if($uri == 'company/master' || $uri == 'company/form_add' || $uri == 'company/form_edit')
                                        active
                                    @endif">
                                        <i class="fas fa-minus-circle nav-icon"></i>
                                        <p>
                                            Master Company
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('site.master') }}" class="nav-link 
                                        @if($uri == 'site/master' || $uri == 'site/form_add' || $uri == 'site/form_edit' )
                                            active  
                                        @endif">
                                        <i class="fas fa-minus-circle nav-icon"></i>
                                        <p>Master Wilayah</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('plant.master') }}" class="nav-link
                                    @if($uri == 'plant/master' || $uri == 'plant/form_add' || $uri == 'plant/form_edit'  )
                                            active  
                                    @endif">
                                        <i class="fas fa-minus-circle nav-icon"></i>
                                        <p>Master Plant</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('zona.master') }}" class="nav-link
                                    @if($uri == 'zona/master' || $uri == 'zona/form_add' || $uri == 'zona/form_edit'  )
                                            active  
                                    @endif">
                                        <i class="fas fa-minus-circle nav-icon"></i>
                                        <p>Master Zona</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('checkpoint.master') }}" class="nav-link
                                    @if($uri == 'checkpoint/master' || $uri == 'checkpoint/form_add' || $uri == 'checkpoint/form_edit'  )
                                            active  
                                    @endif">
                                        <i class="fas fa-minus-circle nav-icon"></i>
                                        <p>Master Check Point</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('objek.master')  }}" class="nav-link
                                    @if($uri == 'objek/master' || $uri == 'objek/form_add' || $uri == 'objek/form_edit'  )
                                            active  
                                    @endif">
                                        <i class="fas fa-minus-circle nav-icon"></i>
                                        <p>Master Objek</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('kategori_objek.master')  }}" class="nav-link
                                    @if($uri == 'kategori_objek/master' || $uri == 'kategori_objek/form_add' || $uri == 'kategori_objek/form_edit'  )
                                            active  
                                    @endif">
                                        <i class="fas fa-minus-circle nav-icon"></i>
                                        <p>Master Kategori Objek</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('event.master')  }}" class="nav-link
                                    @if($uri == 'event/master' || $uri == 'event/form_add' || $uri == 'event/form_edit'  )
                                            active  
                                    @endif">
                                        <i class="fas fa-minus-circle nav-icon"></i>
                                        <p>Master Event</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('shift.master')  }}" class="nav-link
                                    @if($uri == 'shift/master' || $uri == 'shift/form_add' || $uri == 'shift/form_edit'  )
                                            active  
                                    @endif">
                                        <i class=" fas fa-minus-circle nav-icon"></i>
                                        <p>Master Shift</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('produksi.master')  }}" class="nav-link
                                    @if($uri == 'produksi/master' || $uri == 'produksi/form_add' || $uri == 'produksi/form_edit'  )
                                        active  
                                    @endif">
                                        <i class="fas fa-minus-circle nav-icon"></i>
                                        <p>Master Produksi</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('users.master')  }}" class="nav-link
                                    @if($uri == 'users/master' || $uri == 'users/form_add' || $uri == 'users/form_edit'  )
                                        active  
                                    @endif">
                                        <i class="fas fa-minus-circle nav-icon"></i>
                                        <p>Master User</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('users_ga.master')  }}" class="nav-link
                                    @if($uri == 'users_ga/master' || $uri == 'users_ga/form_add' || $uri == 'users_ga/form_edit'  )
                                        active  
                                    @endif">
                                        <i class="fas fa-minus-circle nav-icon"></i>
                                        <p>Master User GA</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('role.master')  }}" class="nav-link
                                    @if($uri == 'role/master' || $uri == 'role/form_add' || $uri == 'role/form_edit'  )
                                        active  
                                    @endif">
                                        <i class="fas fa-minus-circle nav-icon"></i>
                                        <p>Master Role User</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('settings.master')  }}" class="nav-link
                                    @if($uri == 'settings/master' || $uri == 'settings/form_add' || $uri == 'settings/form_edit'  )
                                        active  
                                    @endif">
                                        <i class=" fas fa-minus-circle nav-icon"></i>
                                        <p>Master Settings</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item
                        @if($uri == 'jadpatroli/master' || $uri == 'jadpatroli/form_upload' || $uri == 'jadpatroli/form_edit_jadpatrol' || $uri == 'jadproduksi/master' || $uri == 'jadproduksi/form_upload')
                                menu-open  
                             @endif">
                            <a href="#" class="nav-link
                            @if($uri == 'jadpatroli/master' || $uri == 'jadpatroli/form_upload' || $uri == 'jadpatroli/form_edit_jadpatrol' || $uri == 'jadproduksi/master' || $uri == 'jadproduksi/form_upload' )
                                active  
                             @endif">
                                <i class="nav-icon fas fa-calendar-alt"></i>
                                <p>
                                    Jadwal
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('jadpatroli.master')  }}" class="nav-link
                                    @if($uri == 'jadpatroli/master' || $uri == 'jadpatroli/form_edit_jadpatrol' )
                                        active  
                                    @endif">
                                        <i class="fas fa-minus-circle nav-icon"></i>
                                        <p>Jadwal Patroli</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('jadproduksi.master')  }}" class="nav-link
                                    @if($uri == 'jadproduksi/master')
                                        active  
                                    @endif">
                                        <i class="fas fa-minus-circle nav-icon"></i>
                                        <p>Jadwal Produksi</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('jadpatroli.form_upload') }}" class="nav-link
                                    @if($uri == 'jadpatroli/form_upload' )
                                        active  
                                    @endif">
                                        <i class=" fas fa-minus-circle nav-icon"></i>
                                        <p>Upload Jadwal Patroli</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('jadproduksi.form_upload') }}" class="nav-link
                                    @if($uri == 'jadproduksi/form_upload' )
                                        active  
                                    @endif">
                                        <i class="fas fa-minus-circle nav-icon"></i>
                                        <p>Upload Jadwal Produksi</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>
                                    Laporan
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="fas fa-minus-circle nav-icon"></i>
                                        <p>Laporan Patroli</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="fas fa-minus-circle nav-icon"></i>
                                        <p>Laporan Temuan</p>
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

            <body>
                @yield('content')

                {{-- Laravel Vite - JS File --}}
                {{-- {{ module_vite('build-guardtour', 'Resources/assets/js/app.js') }} --}}
            </body>

            <!-- Main content -->

            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class=" main-footer fixed">
            <div class="float-right d-none d-sm-block">
                <b> Version </b> 1.0.0
            </div>
            <strong> Copyright &copy; 2022 <a href="#"> Security Guard Tour </a></strong>
        </footer>

    </div>
    <!--. / wrapper-->


    <!--Bootstrap 4 -->
    <script src="{{ asset('assets/dist/js/bootstrap.min.js') }}">
    </script>
    <script src="{{ asset('assets/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('assets/dist/js/demo.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <!-- <script src="{{ asset('assets/dist/js/vendor/jszip/jszip.min.js') }}"></script> -->
    <script src="{{ asset('assets/dist/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/buttons.print.js') }}"></script>
    <script src="{{ asset('assets/dist/js/buttons.html5.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('assets/dist/select2/js/select2.full.min.js') }}"></script>
    <!-- date-range-picker -->
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
</body>
<script>
    //Initialize Select2 Elements
    $('.select2').select2()
    $("#example2").DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": false,
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

    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#example thead tr')
            .clone(true)
            .addClass('filters')
            .appendTo('#example thead');

        var table = $('#example').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            initComplete: function() {
                var api = this.api();

                // For each column
                api
                    .columns()
                    .eq(0)
                    .each(function(colIdx) {
                        // Set the header cell to contain the input element
                        var cell = $('.filters th').eq(
                            $(api.column(colIdx).header()).index()
                        );
                        var title = $(cell).text();
                        $(cell).html('<input type="text" class="form-control form-control-sm" placeholder="' + title + '" />');

                        // On every keypress in this input
                        $(
                                'input',
                                $('.filters th').eq($(api.column(colIdx).header()).index())
                            )
                            .off('keyup change')
                            .on('change', function(e) {
                                // Get the search value
                                $(this).attr('title', $(this).val());
                                var regexr = '({search})'; //$(this).parents('th').find('select').val();

                                var cursorPosition = this.selectionStart;
                                // Search the column for that value
                                api
                                    .column(colIdx)
                                    .search(
                                        this.value != '' ?
                                        regexr.replace('{search}', '(((' + this.value + ')))') :
                                        '',
                                        this.value != '',
                                        this.value == ''
                                    )
                                    .draw();
                            })
                            .on('keyup', function(e) {
                                e.stopPropagation();

                                $(this).trigger('change');
                                $(this)
                                    .focus()[0]
                                    .setSelectionRange(cursorPosition, cursorPosition);
                            });
                    });
            },
        });

        $.ajax({
            url: "#",
            type: 'GET',
            dataType: 'json', // added data type
            success: function(res) {
                $('#badge_total_temuan').text(res['total_temuan'])
            }
        });
    });
</script>

</html>