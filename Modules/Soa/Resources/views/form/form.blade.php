@extends('soa::layouts.template')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Daily Report</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="">Analytic</a></li>
                    <li class="breadcrumb-item"><a href="">Operational Index</a></li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        @if ($message = Session::get('failed'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="row information" id="information"></div>
        <div class="row">

            <div class="col-12">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Input Data</button>
                        <button class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">View Data</button>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="card">
                            <form action="saveSoa" method="post">
                                @csrf
                                <div class="card-body px-lg-4">
                                    <div class="form-row mt-2 mb-4">
                                        <div class="form-group col-3">
                                            <label for="reportDate">Report Date</label>
                                            <input type="text" id="reportDate" class="form-control" name="report_date" autocomplete="off" required>
                                        </div>

                                        <div class="form-group col-3">
                                            <label for="shift">Shift</label>
                                            <select name="shift" id="shift" class="form-control">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-3">
                                            <label for="area">Area</label>
                                            <select name="area" id="area" class="form-control">
                                                <option value="">Select Plant</option>
                                                <?php
                                                foreach ($plant as $pl) { ?>
                                                    <option value="<?= $pl->id ?>"><?= ucwords(strtolower($pl->title)) ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <fieldset class="border p-4 mt-2 mb-4">
                                        <legend class="w-auto h5">People</legend>
                                        <div class="form-row">
                                            <div class="form-group col-3">
                                                <label for="employee" class="font-weight-normal">Employee Attendance</label>
                                                <div class="input-group">
                                                    <input id="employee" class="form-control mask-int" name="employee" autocomplete="off" required>
                                                </div>
                                            </div>

                                            <div class="form-group col-3">
                                                <label for="contractor" class="font-weight-normal">Contractor Attendance</label>
                                                <div class="input-group">
                                                    <input id="contractor" class="form-control mask-int" name="contractor" autocomplete="off" required>
                                                </div>
                                            </div>

                                            <div class="form-group col-3">
                                                <label for="visitor" class="font-weight-normal">Visitor Attendance</label>
                                                <div class="input-group">
                                                    <input id="visitor" class="form-control mask-int" name="visitor" autocomplete="off" required>
                                                </div>
                                            </div>

                                            <div class="form-group col-3">
                                                <label for="businessPartner" class="font-weight-normal">Business Partner Attendance</label>
                                                <div class="input-group">
                                                    <input id="businessPartner" class="form-control mask-int" name="business_partner" autocomplete="off" required>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <fieldset class="border p-4 mt-2 mb-4">
                                        <legend class="w-auto h5">Document</legend>
                                        <div class="form-row">
                                            <div class="form-group col-3">
                                                <label for="employee" class="font-weight-normal">PKB</label>
                                                <div class="input-group">
                                                    <input id="pkb" class="form-control mask-int" name="pkb" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="form-group col-3">
                                                <label for="employee" class="font-weight-normal">PKO</label>
                                                <div class="input-group">
                                                    <input id="pko" class="form-control mask-int" name="pko" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="form-group col-3">
                                                <label for="employee" class="font-weight-normal">Surat Jalan</label>
                                                <div class="input-group">
                                                    <input id="surat_jalan" class="form-control mask-int" name="surat_jalan" autocomplete="off" required>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <fieldset class="border p-4 mt-2 mb-4">
                                        <legend class="w-auto h5">Vehicle</legend>

                                        <div class="form-row">
                                            <div class="form-group col-12">
                                                <div class="row">
                                                    <div class="col-2">
                                                        <div class="nav flex-column nav-pills people" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                                            <button class="nav-link active" id="v-pills-employee-tab" data-toggle="pill" data-target="#v-pills-employee" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Employee</button>
                                                            <button class="nav-link" id="v-pills-visitor-tab" data-toggle="pill" data-target="#v-pills-visitor" type="button" role="tab" aria-controls="v-pills-visitor" aria-selected="false">Visitor</button>
                                                            <button class="nav-link" id="v-pills-bp-tab" data-toggle="pill" data-target="#v-pills-bp" type="button" role="tab" aria-controls="v-pills-bp" aria-selected="false">Business Partner</button>
                                                            <button class="nav-link" id="v-pills-contractor-tab" data-toggle="pill" data-target="#v-pills-contractor" type="button" role="tab" aria-controls="v-pills-contractor" aria-selected="false">Contractor</button>
                                                            <button class="nav-link" id="v-pills-pool-tab" data-toggle="pill" data-target="#v-pills-pool" type="button" role="tab" aria-controls="v-pills-pool" aria-selected="false">Pool</button>
                                                        </div>
                                                    </div>


                                                    <div class="col-10">
                                                        <div class="tab-content" id="v-pills-tabContent">
                                                            <div class="tab-pane fade show active" id="v-pills-employee" role="tabpanel" aria-labelledby="v-pills-employee-tab">
                                                                <div class="form-row">
                                                                    <div class="form-group col-3">
                                                                        <label for="car" class="font-weight-normal">Car</label>
                                                                        <div class="input-group">
                                                                            <input id="car_employee" class="form-control mask-int" name="car_employee" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-3">
                                                                        <label for="Motorcycle" class="font-weight-normal">Motorcycle</label>
                                                                        <div class="input-group">
                                                                            <input id="motorcycle_employee" class="form-control mask-int" name="motorcycle_employee" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-3">
                                                                        <label for="bicycle" class="font-weight-normal">Bicycle</label>
                                                                        <div class="input-group">
                                                                            <input id="bicycle_employee" class="form-control mask-int" name="bicycle_employee" autocomplete="off" required>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <div class="tab-pane fade" id="v-pills-visitor" role="tabpanel" aria-labelledby="v-pills-visitor-tab">
                                                                <div class="form-row">
                                                                    <div class="form-group col-3">
                                                                        <label for="car_visitor" class="font-weight-normal">Car</label>
                                                                        <div class="input-group">
                                                                            <input id="car_visitor" class="form-control mask-int" name="car_visitor" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-3">
                                                                        <label for="Motorcycle_visitor" class="font-weight-normal">Motorcycle</label>
                                                                        <div class="input-group">
                                                                            <input id="motorcycle_visitor" class="form-control mask-int" name="motorcycle_visitor" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-3">
                                                                        <label for="bicycle_visitor" class="font-weight-normal">Bicycle</label>
                                                                        <div class="input-group">
                                                                            <input id="bicycle_visitor" class="form-control mask-int" name="bicycle_visitor" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-3">
                                                                        <label for="truck_visitor" class="font-weight-normal">Truck</label>
                                                                        <div class="input-group">
                                                                            <input id="truck_visitor" class="form-control mask-int" name="truck_visitor" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="tab-pane fade" id="v-pills-bp" role="tabpanel" aria-labelledby="v-pills-bp-tab">
                                                                <div class="form-row">
                                                                    <div class="form-group col-3">
                                                                        <label for="car_bp" class="font-weight-normal">Car</label>
                                                                        <div class="input-group">
                                                                            <input id="car_bp" class="form-control mask-int" name="car_bp" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-3">
                                                                        <label for="Motorcycle_bp" class="font-weight-normal">Motorcycle</label>
                                                                        <div class="input-group">
                                                                            <input id="motorcycle_bp" class="form-control mask-int" name="motorcycle_bp" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-3">
                                                                        <label for="bicycle_bp" class="font-weight-normal">Bicycle</label>
                                                                        <div class="input-group">
                                                                            <input id="bicycle_bp" class="form-control mask-int" name="bicycle_bp" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-3">
                                                                        <label for="truck_bp" class="font-weight-normal">Truck</label>
                                                                        <div class="input-group">
                                                                            <input id="truck_bp" class="form-control mask-int" name="truck_bp" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="tab-pane fade" id="v-pills-contractor" role="tabpanel" aria-labelledby="v-pills-contractor-tab">
                                                                <div class="form-row">
                                                                    <div class="form-group col-3">
                                                                        <label for="car_contractor" class="font-weight-normal">Car</label>
                                                                        <div class="input-group">
                                                                            <input id="car_contractor" class="form-control mask-int" name="car_contractor" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-3">
                                                                        <label for="Motorcycle_contractor" class="font-weight-normal">Motorcycle</label>
                                                                        <div class="input-group">
                                                                            <input id="motorcycle_contractor" class="form-control mask-int" name="motorcycle_contractor" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-3">
                                                                        <label for="bicycle_contractor" class="font-weight-normal">Bicycle</label>
                                                                        <div class="input-group">
                                                                            <input id="bicycle_contractor" class="form-control mask-int" name="bicycle_contractor" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-3">
                                                                        <label for="truck_contractor" class="font-weight-normal">Truck</label>
                                                                        <div class="input-group">
                                                                            <input id="truck_contractor" class="form-control mask-int" name="truck_contractor" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="tab-pane fade" id="v-pills-pool" role="tabpanel" aria-labelledby="v-pills-pool-tab">
                                                                <div class="form-row">
                                                                    <div class="form-group col-3">
                                                                        <label for="car_pool" class="font-weight-normal">Car</label>

                                                                        <div class="input-group">
                                                                            <input id="car_pool" class="form-control mask-int" name="car_pool" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-3">
                                                                        <label for="Motorcycle_pool" class="font-weight-normal">Motorcycle</label>

                                                                        <div class="input-group">
                                                                            <input id="motorcycle_pool" class="form-control mask-int" name="motorcycle_pool" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-3">
                                                                        <label for="bicycle_pool" class="font-weight-normal">Bicycle</label>
                                                                        <div class="input-group">
                                                                            <input id="bicycle_pool" class="form-control mask-int" name="bicycle_pool" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-3">
                                                                        <label for="truck_pool" class="font-weight-normal">Truck</label>
                                                                        <div class="input-group">
                                                                            <input id="truck_pool" class="form-control mask-int" name="truck_pool" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <fieldset class="border p-4 mt-2 mb-4">
                                        <legend class="w-auto h5">Chronology</legend>
                                        <div class="form-row">
                                            <div class="form-group col-7">
                                                <label for="chronology">Chronology</label>
                                                <textarea id="chronology" class="form-control" name="chronology" rows="3" required></textarea>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="form-row mt-2 mb-4 justify-content-end">
                                        <button class="btn btn-primary px-4" type="submit">SAVE</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                    <div class="tab-pane fade " id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="card">
                            <div class="card-body px-lg-4">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <form id="form-filter" class="form-horizontal">
                                            <div class="form-row">
                                                <div class="form-group col-2">
                                                    <label for="areaFilter">Area</label>
                                                    <select name="areaFilter" id="areaFilter" class="form-control">
                                                        <option value="" selected>Choose Area</option>
                                                        <?php
                                                        foreach ($plant as $pl) { ?>
                                                            <option value="<?= $pl->id ?>"><?= ucwords(strtolower($pl->title)) ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-3">
                                                    <label for="">Tanggal</label>
                                                    <input type="text" id="datePickerFilter" class="form-control" name="date_filter" autocomplete="off" required>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-4">
                                                    <button type="button" id="btn-filter" class="btn btn-primary px-4 mr-2">Filter</button>
                                                    <button type="button" id="btn-reset" class="btn btn-secondary px-4">Reset</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="table-responsive mt-5">

                                    <table id="tableSoa" style="width:100%" class="table table-striped table-bordered table-sm">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Plant</th>
                                                <th>Date</th>
                                                <th>Vehicle</th>
                                                <th>People</th>
                                                <th>Document</th>
                                                <th style="width:250px">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableDataSoa"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 700px;">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detailSoaModal">
            </div>
            <div class="row justify-content-center mb-2">
                <div class="spinner-border text-danger" id="loadSoaDetail" style="display: none;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-sm btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <h5>Are you sure to Approve?</h5>
            </div>

            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <input id="idApprove" type="text" name="id" hidden>
                <button type="submit" class="btn btn-danger px-4">Yes</button>
            </div>
        </div>
    </div>
</div>
<!-- Approve Modal -->

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="deleteData" action="">
                <div class="modal-body">
                    <h5>Are you sure to delete?</h5>
                    <input id="idArea" type="text" name="idArea" hidden>
                    <input id="idDate" type="text" name="idDate" hidden>
                    <div class="row justify-content-center mb-2">
                        <div class="spinner-border text-danger" id="loadSoaDetail" style="display: none;" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger px-4">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }} "></script>

<script type="text/javascript">
    $(document).ready(function() {
        moment.locale('id');

        $('.mask-decimal').mask("#.##", {
            reverse: true
        }).attr('maxlength', 3);
        $('.mask-int').mask("###", {
            reverse: true
        }).attr('maxlength', 4);

        $("#reportDate").datepicker();

        // TinyMCE //
        tinymce.init({
            selector: '#chronology',
            setup: function(editor) {
                editor.on('change', function() {
                    tinymce.triggerSave();
                });
            },
            height: 300,
            extended_valid_elements: "script[src|async|defer|type|charset]",
            plugins: [
                "advlist code autolink link image lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking spellchecker",
                "table contextmenu directionality emoticons paste textcolor fullscreen"
            ],
            fullscreen_native: true,
            toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect ",
            toolbar2: "| print preview "
        });



        moment.locale('id');
        var start = moment().subtract(1, 'days');
        var end = moment();
        $('#datePickerFilter').daterangepicker({
            autoUpdateInput: false,
            timePicker: false,
            timePicker24Hour: false,
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
                "format": "YYYY-MM-DD",
                "format": "LL",
                "separator": " - ",
                "applyLabel": "Apply",
                "cancelLabel": "Cancel",
                "weekLabel": "W",
                "daysOfWeek": [
                    "Min",
                    "Sen",
                    "Sel",
                    "Rab",
                    "Kam",
                    "Jum",
                    "Sab"
                ],
                "monthNames": [
                    "Januari",
                    "Februari",
                    "Maret",
                    "April",
                    "Mei",
                    "Juni",
                    "Juli",
                    "Agustus",
                    "September",
                    "Oktober",
                    "November",
                    "Desember"
                ],
                "firstDay": 1
            },
        });
        let s = "";
        let e = ""

        $('input[name="date_filter"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
            s = picker.startDate.format('YYYY-MM-DD');
            e = picker.endDate.format('YYYY-MM-DD');
        });


        table = $('#tableSoa').DataTable({
            paging: true,
            // scrollX: true,
            searching: false,
            ordering: false,
            autoWidth: true,
            processing: true,
            language: {
                'loadingRecords': '&nbsp;',
                'processing': 'Loading...'
            },
            serverSide: false,
            orderCellsTop: true,
            fixedHeader: true,
            ajax: {
                url: "dataTables",
                "type": "POST",
                "data": function() {
                    var params = {
                        'areafilter': $('#areaFilter').val(),
                        'start': s,
                        'end': e,
                        "_token": "{{ csrf_token() }}",
                    }
                    return params;
                }
            },
            pageLength: 10,
            columns: [{
                    data: 0
                }, {
                    data: 1
                }, {
                    data: 2
                }, {
                    data: 3
                }, {
                    data: 4
                }, {
                    data: 5
                },
                {
                    data: '',
                    render: function(data, type, row) {

                        return '<button data-toggle="modal" data-target="#detailModal" data-date="' + row[2] + '" data-area_id ="' + row[6] + '" class="btn btn-sm btn-primary text-white"><i class="fas fa-eye" "></i></button>' +
                            ' <button data-date="' + row[2] + '" data-area_id ="' + row[6] + '" data-toggle="modal" data-target="#deleteModal" class="btn btn-sm btn-danger text-white"><i class="fas fa-trash text-white"></i></button> ' +
                            '<button type="button" class="btn btn-info btn-sm dropdown-toggle edit-icon" data-toggle="dropdown"><i class= "fas fa-edit"></i></button><div class ="dropdown-menu" role= "menu" ><a class ="dropdown-item" href ="formEditSoa?tanggal=' + row[2] + '&area=' + row[6] + '&shift=1 "> Shift 1 </a><a class = "dropdown-item" href ="formEditSoa?tanggal=' + row[2] + '&area=' + row[6] + '&shift=2 "> Shift 2 </a><a class = "dropdown-item" href ="formEditSoa?tanggal=' + row[2] + '&area=' + row[6] + '&shift=3 "> Shift 3 </a></div>'

                    }
                },
            ],
        });

        $('#deleteData').on('submit', function(event) {
            event.preventDefault();
            let area = $("#idArea").val();
            let date = $("#idDate").val();
            $.ajax({
                url: "deleteData",
                method: "POST",
                data: {
                    area: area,
                    date: date,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(e) {
                    if (e == 1) {
                        table.ajax.reload();
                        $('#deleteModal').modal('hide');
                        document.getElementById("information").innerHTML = '<div class="col-12">' +
                            '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                            '<strong>Success! </strong> Data Terhapus' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> </div> </div>';
                    } else {
                        $('#deleteModal').modal('hide');
                        document.getElementById("information").innerHTML = '<div class="col-12">' +
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                            '<strong>Failed ! </strong> Data Gagal Terhapus' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> </div> </div>';
                    }
                }
            })
        })


        $('#btn-filter').click(function() {
            table.ajax.reload(); //just reload table
        });

        $('#btn-reset').click(function() {
            $('#form-filter')[0].reset();
            s = "";
            e = "";
            table.ajax.reload(); //just reload table
        });



        $('#detailModal').on('shown.bs.modal', function(e) {
            const target = $(e.relatedTarget);
            const modal = $(this);
            const date = target.data('date')
            const area = target.data('area_id')
            $.ajax({
                url: "detailSoa",
                method: "POST",
                data: {
                    tanggal: date,
                    area: area,
                    "_token": "{{ csrf_token() }}",
                },
                beforeSend: function() {
                    document.getElementById("loadSoaDetail").style.display = "block";
                    document.getElementById("detailSoaModal").innerHTML = "";
                },
                complete: function() {
                    document.getElementById("loadSoaDetail").style.display = "none";
                },
                cache: false,
                success: function(e) {
                    document.getElementById("detailSoaModal").innerHTML = e;
                }
            })
        });

        $('#deleteModal').on('shown.bs.modal', function(e) {
            const target = $(e.relatedTarget);
            const modal = $(this);
            const date = target.data('date')
            const area = target.data('area_id')
            $('#idDate').val(date)
            $('#idArea').val(area)

        })

        $('#approveModal').on('shown.bs.modal', function(e) {
            $('#approveModal .modal-body .title-approve').remove()

            const target = $(e.relatedTarget);
            const modal = $(this);
            const id = target.data('id')
            const title = target.data('title')

            $('#idApprove').val(id)
            $('#approveModal .modal-body h5').after(`
            <span class="font-weight-bold title-approve">${title}</span> 
        `)
        })
    });
</script>

@endsection