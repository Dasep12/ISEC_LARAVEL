@extends('srs::layouts.template')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>HUMINT Source</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="">Security Risk Survey</a></li>
                    <li class="breadcrumb-item"><a href="">HUMINT Source</a></li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            
            @if($msgSuccess = Session::get('success'))
                <div class="col-12">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success </strong>{!! $msgSuccess !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif

            @if($msgError = Session::get('error'))
                <div class="col-12">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error </strong>{!! $msgError !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif

            <div class="col-md-12">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <?php if(AuthHelper::is_access_privilege($isModuleCode, 'crt') || AuthHelper::is_super_admin()) { ?>
                        <button class="nav-link <?= AuthHelper::is_author() || AuthHelper::is_access_privilege($isModuleCode, 'crt') ? 'active' : ''; ?>" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Input Data</button>
                        <?php } ?>

                        <button class="nav-link <?= AuthHelper::is_access_privilege($isModuleCode, 'crt') == false ? 'active' : ''; ?>" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">View Data</button>

                        <button class="nav-link " id="nav-searchdata-tab" data-toggle="tab" data-target="#nav-searchdata" type="button" role="tab" aria-controls="nav-searchdata" aria-selected="false">Search Data</button>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade <?= AuthHelper::is_access_privilege($isModuleCode, 'crt') ? 'show active' : ''; ?>" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="card">

                            <form action="humint_source/save" method="post" enctype="multipart/form-data">
                            @csrf
                                <div class="card-body px-lg-4">
                                    <div class="form-row mt-2 mb-4">
                                        <div class="form-group col-lg-3">
                                            <label for="">Date</label>
                                            <input type="text" id="datetimepicker" class="form-control" name="tanggal" autocomplete="off" required>
                                        </div>

                                        <div class="form-group col-lg-4">
                                            <label for="event">Event Name</label>
                                            <input id="event" class="form-control" name="event_name" autocomplete="off" required>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="reporter">Reporter</label>
                                            <input id="reporter" class="form-control" name="reporter" autocomplete="off" >
                                        </div>
                                    </div>

                                    <div class="form-row mt-2 mb-4">
                                        <div class="form-group col-3">
                                            <label for="area">Area</label>
                                            <?= $select_area; ?>
                                        </div>

                                        <div class="form-group col-3">
                                            <label for="subArea1">Sub Area</label>
                                            <?= $select_subarea1; ?>
                                        </div>

                                        <div class="form-group col-3">
                                            <label for="subArea2">-</label>
                                            <select id="subArea2" class="form-control" name="sub_area2" disabled required></select>
                                        </div>
                                    </div>

                                    <div class="form-row mt-2 mb-4">
                                        <div class="form-group col-3">
                                            <label for="assets">Target Assets</label>
                                            <?= $select_ass; ?>
                                        </div>
                                    </div>

                                    <div class="form-row mt-2 mb-4">
                                        <div class="form-group col-3">
                                            <label for="riskSource">Risk Source</label>
                                            <?= $select_rso; ?>
                                        </div>
                                    </div>

                                    <div class="form-row mt-2 mb-4 col-12-OFF">
                                        <div class="form-group col-3">
                                            <label for="risk">Risk</label>
                                            <?= $select_ris; ?>
                                        </div>

                                        <div class="form-group col-3">
                                            <label for="riskLevel">Risk Level</label>
                                            <!-- <?= $select_rle; ?> -->
                                            <input id="riskLevel" class="form-control" type="text" name="risk_level" readonly required>
                                        </div>
                                    </div>

                                    <fieldset class="border p-4 mt-2 mb-4">
                                        <legend class="w-auto h5">Vulnerability Lost</legend>

                                        <div class="form-row">
                                            <div class="form-group col-3">
                                                <label for="financial" class="font-weight-normal">Financial</label>
                                                <?= $select_fin; ?>
                                            </div>

                                            <div class="form-group col-3">
                                                <label for="sdm" class="font-weight-normal">SDM</label>
                                                <?= $select_sdm; ?>
                                            </div>

                                            <div class="form-group col-3">
                                                <label for="operational" class="font-weight-normal">Operational</label>
                                                <?= $select_ope; ?>
                                            </div>

                                            <div class="form-group col-3">
                                                <label for="reputation" class="font-weight-normal">Reputation / Image</label>
                                                <?= $select_rep; ?>
                                            </div>

                                            <div class="form-group col-3">
                                                <label for="impactLevel" class="font-weight-normal">Impact Level</label>
                                                <input id="impactLevel" class="form-control" type="text" name="impact" required readonly>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <div class="form-row mt-2 mb-4">
                                        <div class="form-group col-7">
                                            <label for="chronology">Chronology</label>
                                            <textarea id="chronology" class="form-control" name="chronology" rows="3"></textarea>
                                        </div>

                                        <div class="form-group col-3">
                                            <label for="attach">Attach</label>
                                            <style type="text/css">
                                                .field-wrapper input[type=file]::file-selector-button 
                                                {
                                                    border: 1px solid #bbbebf;
                                                    padding: .2em .4em;
                                                    border-radius: .2em;
                                                    background-color: rgb(48 67 108 / 70%);
                                                    color: #fff;
                                                }
                                            </style>
                                            <div class="field-wrapper mb-2">
                                                <div class="mb-2">
                                                    <input class="" type="file" accept="image/*,.pdf,.xls,.xlsx,.doc,.docx,.mp4" id="attach" name="attach[]">
                                                    <span class="d-inline-block text-warning">* Max. Image & Video 20MB</span>
                                                </div>
                                            </div>
                                            
                                            <button class="btn btn-info add-button mt-3" type="button" href="javascript:void(0);">Add More</button>

                                        </div>
                                    </div>

                                    <div class="form-row mt-2 mb-4">
                                        <button class="btn btn-primary px-4" type="submit">SAVE</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                    <div class="tab-pane fade <?= !AuthHelper::is_access_privilege($isModuleCode, 'crt') ? 'show active' : ''; ?>" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                       <div class="card">
                            <div class="card-body px-lg-4">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                      <form id="form-filter" class="form-horizontal">
                                            <div class="form-row">
                                                <div class="form-group col-md-2">
                                                    <label for="area">Area</label>
                                                    <?= $select_area_filter; ?>
                                                </div>
                                                
                                                <div class="form-group col-md-2">
                                                    <label for="yearFilter">Year</label>
                                                    <?= $select_year_filter; ?>
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label for="">Date Range</label>
                                                    <input type="text" id="datePickerFilter" class="form-control" name="date_filter" autocomplete="off" required>
                                                </div>
                                                
                                                <div class="form-group col-md-2">
                                                    <label for="statusFilter">Status</label>
                                                    <?= $select_status_filter; ?>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <button type="button" id="btn-filter" class="btn btn-primary px-4 mr-2">Filter</button>
                                                    <button type="button" id="btn-reset" class="btn btn-secondary px-4">Reset</button>
                                                </div>
                                            </div>
                                      </form>
                                    </div>
                                </div>

                                <div class="row mt-5">
                                    <div class="col-lg-12 mb-3">
                                        <div class="d-flex flex-row-reverse">
                                            <button id="exportExcel" class="btn btn-primary">Export Excel</button>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table id="tableIso" style="width:100%" class="table table-striped table-sm text-center">
                                              <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Event Title</th>
                                                    <th>Event Date</th>
                                                    <th>Area</th>
                                                    <th>Assets</th>
                                                    <th>Risk Source</th>
                                                    <th>Risk</th>
                                                    <th>Impact Level</th>
                                                    <th>Status</th>
                                                    <th style="width:200px">Action</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                                
                                              </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-searchdata" role="tabpanel" aria-labelledby="nav-profile-tab">
                       <div class="card">
                            <div class="card-body px-lg-4 py-5">
                                <form id="formSearch" method="post" action="#">
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <h1 class="text-white">SEARCH</h1>
                                        </div>
                                        <div class="col-8 mx-auto">
                                            <!-- <input class="form-control" type="text" name="" placeholder="Type something..."> -->
                                            <div class="input-group">
                                                <input type="search" class="form-control rounded" name="keyword" placeholder="Search" aria-label="Search" aria-describedby="search-addon" required />
                                                <button type="submit" class="btn btn-primary">search</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 700px;">
        <div class="modal-content">
            <div class="modal-header border-0">
                <!-- <h5 class="modal-title" id="detailModalLabel"></h5> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Detail Search Data Modal -->
<div class="modal fade" id="detailSearchModal" tabindex="-1" aria-labelledby="detailSearchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 700px;">
        <div class="modal-content">
            <div class="modal-header border-0">
                <!-- <h5 class="modal-title" id="detailModalLabel"></h5> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Notif Modal -->
<div class="modal fade" id="notifModal" tabindex="-1" aria-labelledby="notifModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <!-- <h5 id="notifMsg" class="modal-title"></h5> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body border-0 text-center">
                <div class="bg-white d-inline-block mb-3 p-2 rounded-circle">
                    <i class="icon fas fa-check px-1 text-success" style="font-size: 2.5rem;"></i>
                </div>
                <h5 id="notifMsg">Berhasil menyetujui data.</h5>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Notif Modal -->

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="frm-approve">
                @csrf
                <div class="modal-body">
                    <h5>Are you sure to Approve?</h5>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <input id="idApprove" type="text" name="id" hidden>
                    <button type="button" id="btn-approve" class="btn btn-success px-4">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Approve Modal -->

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="humint_source/delete" method="POST">
                @csrf
                <!-- <div class="modal-header border-0">
                    <h5 class="modal-title" id="deleteModalLabel">Are you sure to Delete?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div> -->

                <div class="modal-body">
                    <h5>Are you sure to Delete?</h5>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <input id="idDelete" type="text" name="id" hidden>
                    <button type="submit" class="btn btn-danger px-4">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ url('assets/vendor/tinymce/tinymce.min.js') }}"></script>

<script type="text/javascript">
    $( document ).ready(function() {
        var maxField = 5;
        var addButton = $('.add-button');
        var wrapper = $('.field-wrapper');
        var fieldHTML = `<div class="parent-delete mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <input type="file" accept="image/*,.pdf,.xls,.xlsx,.doc,.docx,.mp4" id="attach" name="attach[]">
                    <a class="remove-attach" href="javascript:void(0);"><i class="fa fa-trash"></i></a>
                </div>
                <span class="d-block text-warning">* Max. Image & Video 20MB</span>
            </div>`;
        var x = 1;
        
        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){ 
                x++; //Increment field counter
                $(wrapper).append(fieldHTML);
            }
        });
        
        //Once remove button is clicked
        $(wrapper).on('click', '.remove-attach', function(e){
            e.preventDefault();
            $(this).parents('.parent-delete').remove();
            x--;
        });

        //datatables
        table = $('#tableIso').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": true,
            // "order": [],
            "autoWidth": false,
            "stateSave": true,
            "ajax": {
                url: "{{ url('srs/humint_source/list_table') }}",
                type: "POST",
                data: function ( data ) {
                    data._token = "{{ csrf_token() }}";
                    data.areafilter = $('#areaFilter').val();
                    data.yearfilter = $('#yearFilter').val();
                    data.datefilter = $('#datePickerFilter').val();
                    data.statusfilter = $('#statusFilter').val();
                }
            },
            "columnDefs": [
                {
                    "targets": [0, 9],
                    "orderable": false
                }
            ],
            createdRow: function(row, data, index) {
                // console.log(data)
                if (data[7] == 1) {
                  $('td:eq(7)', row).attr('style', 'background-color: #06a506; color: #000;');
                } else if (data[7] == 2) {
                  $('td:eq(7)', row).attr('style', 'background-color: #f3ec03; color: #000;');
                } else if (data[7] == 3) {
                  $('td:eq(7)', row).attr('style', 'background-color: #f7a91a; color: #000;');
                } else if (data[7] == 4) {
                  $('td:eq(7)', row).attr('style', 'background-color: #ff1818; color: #000;');
                } else if (data[7] == 5) {
                  $('td:eq(7)', row).attr('style', 'background-color: #c30505; color: #000;');
                } else {
                  $('td:eq(4)', row).css('background-color', 'White'); 
                }
            },
        });

        $(function () {
            moment.locale('id');
            var start = moment().subtract(1, 'days');
            var end = moment();
            $('#datePickerFilter').daterangepicker({
                autoUpdateInput: false,
                timePicker: true,
                timePicker24Hour: true,
                startDate: start,
                endDate: end,
                ranges: {
                   'Today': [moment(), moment()],
                   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                   'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                   'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                   'This Month': [moment().startOf('month'), moment().endOf('month')],
                   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                locale: {
                    "format": "YYYY-MM-DD HH:mm",
                    // "format": "LL",
                    // "separator": " - ",
                    // "applyLabel": "Apply",
                    // "cancelLabel": "Cancel",
                    // "weekLabel": "W",
                    // "daysOfWeek": [
                    //     "Min",
                    //     "Sen",
                    //     "Sel",
                    //     "Rab",
                    //     "Kam",
                    //     "Jum",
                    //     "Sab"
                    // ],
                    // "monthNames": [
                    //     "Januari",
                    //     "Februari",
                    //     "Maret",
                    //     "April",
                    //     "Mei",
                    //     "Juni",
                    //     "Juli",
                    //     "Augustus",
                    //     "September",
                    //     "Oktober",
                    //     "November",
                    //     "Desember"
                    // ],
                    // "firstDay": 1
                },
            });
        });

        $('input[name="date_filter"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm') + ' - ' + picker.endDate.format('YYYY-MM-DD HH:mm'));
        });

        $('#btn-filter').click(function(){
            table.ajax.reload();  //just reload table
        });

        $('#btn-reset').click(function(){
            $('#form-filter')[0].reset();
            table.ajax.reload();  //just reload table
        });

        $('#attach').change(function(e) {
            var fileName = $(this).val().match(/[^\\/]*$/)[0];
            $('#attach').parent().children('label').text(fileName);
            // $('#attach').after('<span class="d-block w-100 mt-2">'+fileName+'</span>');
        });

        $('#btn-approve').click(function() {
            var id = $('#idApprove').val()
            
            $.ajax({
                url: '{{ url("srs/humint_source/approve") }}',
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                cache: false,
                beforeSend: function() {
                    
                },
                success : function(data){
                    var res = JSON.parse(data);
                    
                    if(res.code == '00')
                    {
                        $('#approveModal').modal('hide');
                        table.ajax.reload()
                        $('#notifModal').modal('show');
                        $('#notifMsg').text(res.msg)
                    }
                    else
                    {
                        alert('Terjadi kesalahan')
                    }
                }
            });
        });

        $('#detailModal').on('shown.bs.modal', function (e) {
            const target = $(e.relatedTarget);
            const modal = $(this);
            const id = target.data('id')
            const row = $(target).closest("tr");
            const title = row.find("td:nth-child(2)");

            // modal.find('#detailModalLabel').text(tds.text());

            $.ajax({
                url: '{{ url("srs/humint_source/detail") }}',
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                cache: false,
                beforeSend: function() {
                    $('#detailModal .modal-body').html(`
                        <div id="loadingProgress" class="row justify-content-center">
                            <div class="spinner-grow text-primary" role="status">
                                <span class="visually-hidden"></span>
                            </div>
                            <div class="spinner-grow text-secondary" role="status">
                                <span class="visually-hidden"></span>
                            </div>
                            <div class="spinner-grow text-success" role="status">
                                <span class="visually-hidden"></span>
                            </div>
                        </div>
                    `);
                },
                success : function(data){
                    $('#detailModal .modal-body').html(data);//menampilkan data ke dalam modal
                }
            });
        })

        $('#detailModal').on('hidden.bs.modal', function () {
            $('#detailModal .modal-body').html('')
        });

        $('#detailSearchModal').on('shown.bs.modal', function (e) {
            const target = $(e.relatedTarget);
            const modal = $(this);
            const id = target.data('id')
            const row = $(target).closest("tr");
            const title = row.find("td:nth-child(2)");

            // modal.find('#detailModalLabel').text(tds.text());

            $.ajax({
                url: '{{ url("srs/humint_source/detail_search") }}',
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                cache: false,
                beforeSend: function() {
                    $('#detailSearchModal .modal-body').html(`
                        <div id="loadingProgress" class="row justify-content-center">
                            <div class="spinner-grow text-primary" role="status">
                                <span class="visually-hidden"></span>
                            </div>
                            <div class="spinner-grow text-secondary" role="status">
                                <span class="visually-hidden"></span>
                            </div>
                            <div class="spinner-grow text-success" role="status">
                                <span class="visually-hidden"></span>
                            </div>
                        </div>
                    `);
                },
                success : function(data){
                    $(".lds-ring").hide();
                    $('#detailSearchModal .modal-body').html(data);//menampilkan data ke dalam modal
                }
            });
        })

        $('#detailSearchModal').on('hidden.bs.modal', function () {
            $('#detailSearchModal .modal-body').html('')
        });

        $('#approveModal').on('shown.bs.modal', function (e) {
            const target = $(e.relatedTarget);
            const modal = $(this);
            const id = target.data('id')
            const title = target.data('title')

            $('.appr-title').remove()
            $('#idApprove').val(id)
            $(this).find('.modal-body h5').after(`<h6 class="appr-title">${title}</h6>`)
        })

        $('#deleteModal').on('shown.bs.modal', function (e) {
            const target = $(e.relatedTarget);
            const modal = $(this);
            const id = target.data('id')

            $('#idDelete').val(id)
        })

        $('#area').change(function (e) {
            const val = $(this).val();
            const subArea1 = $(this).parent().parent().find('.subArea1')
            subArea1.attr('disabled', true)

            if (val) {
                subArea1.removeAttr('disabled');
            }
            else
            {
                subArea1.prop('selectedIndex', 0) // reset position
            }
        });

        $('#subArea1').change(function (e) {
            const val = $(this).val();
            const valTxt = $(this).find('option:selected').text();
            const subArea2 = $('#subArea2')
            const subArea3 = $('#subArea3')
            const subArea2Label = subArea2.parents().children('label')
            // const subArea = $(this).next();
            // console.log(val)

            subArea2.empty();
            subArea2.attr('disabled', true);
            subArea2Label.empty();
            subArea2Label.append('-');

            if(subArea2.find('option:selected').text() !== 'production') {
                const subArea2 = $('#subArea2')
                subArea3.parents('.form-group').remove()
            }

            if (val) {
                $.ajax({
                    url: '{{ url("srs/humint_source/get_sub_area2") }}',
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        idcateg: val,
                    },
                    cache: false
                }).done(function(data) {
                    subArea2Label.empty();
                    subArea2.removeAttr('disabled');
                    subArea2Label.append(valTxt);
                    subArea2.append(data);
                    // subArea.html(data);
                });
            }
        });

        $('#subArea2').change(function (e) {
            const val = $(this).val();
            const valTxt = $(this).find('option:selected').text();
            const subArea2 = $('#subArea2')
            const subArea3 = $('#subArea3')
            
            subArea3.parents('.form-group').remove()
            
            $.ajax({
                url: '{{ url("srs/humint_source/get_sub_area3") }}',
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                  idcateg: val,
                },
                cache: false
            }).done(function(data) {
                if (data) {
                    subArea2.parents('.form-group').after(data);
                }
            });
        });

        $('#assets').change(function (e) {
            const val = $(this).val();
            const valTxt = $(this).find('option:selected').text();
            const assets = $('#assets')
            const subAssets = $('#subAssets')
            const subAssetsLabel = subAssets.parents().children('label')
            const subAssets2 = $('#subAssets2')
            
            subAssets.parents('.form-group').remove()
            subAssets2.parents('.form-group').remove()

            $.ajax({
                url: '{{ url("srs/humint_source/get_sub_assets") }}',
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    idcateg: val,
                },
                cache: false
            }).done(function(data) {

                if(data) {
                    assets.parents('.form-group').after(data);
                    
                    $('#subAssets').change(function (e) {
                        const val = $(this).val();
                        const valTxt = $(this).find('option:selected').text();
                        const subAssets = $('#subAssets')
                        const subAssets2 = $('#subAssets2')
                        
                        subAssets2.parents('.form-group').remove()

                        $.ajax({
                            url: '{{ url("srs/humint_source/get_sub_assets2") }}',
                            type: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}",
                                idcateg: val,
                            },
                            cache: false
                        }).done(function(data) {
                            if(data) {
                                subAssets.parents('.form-group').after(data);
                            }
                            else
                            {
                                subAssets2.empty()
                                subAssets2.parents('.form-group').remove()
                            }
                        });
                    });
                }
                else
                {
                    subAssets.empty()
                    subAssets.parents('.form-group').remove()
                }
            });
        });

        $('#riskSource').change(function (e) {
            const val = $(this).val();
            const riskSource = $('#riskSource')
            const subRiskSource = $('#subRiskSource')
            const subRiskSource2 = $('#subRiskSource2')

            subRiskSource.parents('.form-group').remove()
            subRiskSource2.parents('.form-group').remove()

            $.ajax({
                url: '{{ url("srs/humint_source/get_sub_risksource") }}',
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    idcateg: val,
                },
                cache: false
            })
            .done(function(data) {
                if(data) {
                    const subRiskSource = $('#subRiskSource')
                    
                    subRiskSource.parents('.form-group').remove()

                    riskSource.parents('.form-group').after(data);

                    $('#subRiskSource').change(function (e) {
                        const val = $(this).val();
                        const valTxt = $(this).find('option:selected').text();
                        const subRiskSource = $('#subRiskSource')
                        const subRiskSource2 = $('#subRiskSource2')
                        
                        subRiskSource2.parents('.form-group').remove()
                        
                        $.ajax({
                            url: '{{ url("srs/humint_source/get_sub_risksource2") }}',
                            type: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}",
                                idcateg: val,
                            },
                            cache: false
                        }).done(function(data) {
                            if(data) {
                                subRiskSource.parents('.form-group').after(data);
                                const subLabel = $('#subRiskSource2').parents().children('label')
                                subLabel.append(valTxt);
                            }
                            else
                            {
                                subRiskSource2.parents('.form-group').remove()
                            }
                        });
                    })
                }
                else
                {
                    subRiskSource.empty()
                }
            });
        })
        
        $('#risk').change(function (e) {
            const val = $(this).val();
            const risk = $('#risk')
            const subRisk = $('#subRisk')
            const subRisk2 = $('#subRisk2')
            const riskLevelId = val.split(":")[1]

            $('#riskLevel').val(val.split(":")[1])
            // $('#riskLevel').find(":selected").text(val.split(":")[1])

            riskLevelBg(riskLevelId)

            subRisk.parents('.form-group').remove()
            subRisk2.parents('.form-group').remove()

            $.ajax({
                url: '{{ url("srs/humint_source/get_sub_risk") }}',
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    idcateg: val.split(":")[0],
                },
                cache: false
            })
            .done(function(data) {
                if(data) {
                    risk.parents('.form-group').after(data);

                    $('#subRisk').change(function (e) {
                        const val = $(this).val();
                        const valTxt = $(this).find('option:selected').text();
                        const subRisk = $('#subRisk')
                        const subRisk2 = $('#subRisk2')
                        
                        subRisk2.parents('.form-group').remove()
                        
                        $.ajax({
                            url: '{{ url("srs/humint_source/get_sub_risk2") }}',
                            type: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}",
                                idcateg: val,
                            },
                            cache: false
                        }).done(function(data) {
                            if(data) {
                                subRisk.parents('.form-group').after(data);
                                const subLabel = $('#subRisk2').parents().children('label')
                                subLabel.append(valTxt);
                            }
                        });
                    })
                }
                else
                {
                    // subRisk.parents('.form-group').remove()
                }
            })
        })
        
        $('#financial,#sdm,#operational,#reputation,#impactLevel').change(function (e) {
            const fin = $('#financial').val();
            const sdm = $('#sdm').val();
            const ope = $('#operational').val();
            const rep = $('#reputation').val();

            const arr = [fin.split(":")[0],sdm.split(":")[0],ope.split(":")[0],rep.split(":")[0]];
            // console.log(Math.max.apply(Math,arr))
            $('#impactLevel').val(Math.max.apply(Math,arr));
        })

        $('#exportExcel').click(function(e) {
            var area = $('#areaFilter').val();
            var year = $('#yearFilter').val();
            var datefilter = $('#datePickerFilter').val();
            var param = "area="+area+"&year="+year+"&daterange="+datefilter;
            var link = '{{ url("srs/humint_source/export_excel?") }}'+param;
            // console.log(area)
            window.open(link, '_blank');
            // fetch('analitic/srs/humint_source/export_excel')
            // .then(resp => resp.blob())
            // .then(blob => {
            //     const url = window.URL.createObjectURL(blob);
            //     const a = document.createElement('a');
            //     a.style.display = 'none';
            //     a.href = url;
            //     // the filename you want
            //     a.download = 'todo-1.xlsx';
            //     document.body.appendChild(a);
            //     a.click();
            //     window.URL.revokeObjectURL(url);
            //     alert('your file has downloaded!'); // or you know, something with better UX...
            // })
            // .catch(() => alert('oh no!'));
        });

        $('#formSearch').on('submit', function (e) {
            e.preventDefault();

            var data = $(this).serialize();
            var keyword = $("input[name='keyword']").val();
            
            if(keyword != '')
            {
                $.ajax({
                    url: '{{ url("srs/humint_source/search") }}',
                    type: 'POST',
                    data: {
                        keyword: keyword,
                        _token: "{{ csrf_token() }}"
                    },
                    cache: false,
                    beforeSend: function() {
                        $('#formSearch input').parents('.col-8').after(animateLoading());
                    },
                    success : function(data){
                        $('#loadingProgress').remove();
                        $(".lds-ring").hide();
                        $('#searchResult').remove();
                        $('#formSearch input').parents('.col-8').after(data);
                    }
                });
            }

        })

        function riskLevelBg(riskLevelId) {
            switch (riskLevelId) {
                case '1':
                    $('#riskLevel').attr('style', 'background-color: #06a506 !important; color: #000;');
                    break;
                case '2':
                    $('#riskLevel').attr('style', 'background-color: #f3ec03 !important; color: #000;');
                    break;
                case '3':
                    $('#riskLevel').attr('style', 'background-color: #f7a91a !important; color: #000;');
                    break;
                case '4':
                    $('#riskLevel').attr('style', 'background-color: #ff1818 !important; color: #000;');
                    break;
                case '5':
                    $('#riskLevel').attr('style', 'background-color: #c30505 !important; color: #000;');
                    break;
                default:
                    $('#riskLevel').removeAttr('style')
                    break;
            }
        }

        function animateLoading(mode='') {
            return `
                <div id="loadingProgress" class="loader d-flex w-100 justify-content-center py-3 `+mode+`">
                    <div class="spinner-grow text-primary " role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="spinner-grow text-secondary ml-1" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="spinner-grow text-success ml-1 " role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="spinner-grow text-danger ml-1" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="spinner-grow text-warning ml-1" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="spinner-grow text-info ml-1" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="spinner-grow text-dark ml-1" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            `;
        }
    });
    
    // TinyMCE //
    tinymce.init({ 
        selector: '#chronology',
        height: 300,
        extended_valid_elements : "script[src|async|defer|type|charset]",
        plugins: [
            "advlist code autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking spellchecker",
            "table contextmenu directionality emoticons paste textcolor fullscreen"
        ],
        fullscreen_native: true,
        toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect ",
        toolbar2: "| print preview "
    });
</script>
@endsection