@extends('srs::layouts.template')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Security Operational Index</h1>
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

            <div class="col-12">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <?php if(AuthHelper::is_access_privilege($isModuleCode, 'crt')) { ?>
                        <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Input Data</button>
                        <?php } ?>
                        <button class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">View Data</button>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                    <?php if(AuthHelper::is_access_privilege($isModuleCode, 'crt')) { ?>
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="card">
                            <!-- <div class="card-header">
                                <h3 class="card-title">Input Data Internal Source</h3>
                            </div> -->

                            <form action="soi/save" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body px-lg-4">

                                <div class="form-row mt-2 mb-4">
                                    <!-- <div class="form-group col-12 mb-2">
                                        <h5>Area</h5>
                                    </div> -->

                                    <div class="form-group col-3">
                                        <label for="area">Area</label>
                                        <?= $select_area; ?>
                                    </div>

                                    <div class="form-group col-3">
                                        <label for="years">Year</label>
                                        <?= $select_years; ?>
                                    </div>

                                    <div class="form-group col-3">
                                        <label for="years">Month</label>
                                        <?= $select_month; ?>
                                    </div>
                                </div>

                                <fieldset class="border p-4 mt-2 mb-4">
                                    <legend class="w-auto h6 font-weight-bold">Security Operational Index</legend>

                                    <div class="form-row">
                                        <div class="form-group col-3">
                                            <div class="form-group col-12">
                                                <label for="knowlage" class="font-weight-normal">Knowledge</label>
                                                <div class="input-group">
                                                    <input id="knowlage" class="form-control mask-decimal" name="knowlage" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="form-group col-12">
                                                <label for="attitude" class="font-weight-normal">Attitude</label>
                                                <div class="input-group">
                                                    <input id="attitude" class="form-control mask-decimal" name="attitude" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="form-group col-12">
                                                <label for="skill" class="font-weight-normal">Skill</label>
                                                <div class="input-group">
                                                    <input id="skill" class="form-control mask-decimal" name="skill" autocomplete="off" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-3">
                                            <div class="form-group col-12">
                                                <label for="asms" class="font-weight-normal">ASMS</label>
                                                <div class="input-group">
                                                    <input id="asms" class="form-control mask-percent" name="asms" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="form-group col-12">
                                                <label for="guardtour" class="font-weight-normal">Guard Tour Performance</label>
                                                <div class="input-group">
                                                    <input id="guardtour" class="form-control mask-percent" name="guardtour" autocomplete="off" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        
                                    <div class="form-row">
                                        <div class="form-group col-3">
                                            <label for="people" class="font-weight-normal">People</label>
                                            <div class="input-group">
                                                <input id="people" class="form-control mask-decimal" name="people" autocomplete="off" required>
                                            </div>
                                        </div>

                                        <div class="form-group col-3">
                                            <label for="system" class="font-weight-normal">System</label>
                                            <div class="input-group">
                                                <input id="system" class="form-control mask-decimal" name="system" autocomplete="off" readonly required>
                                            </div>
                                        </div>

                                        <div class="form-group col-3">
                                            <label for="device" class="font-weight-normal">Device</label>
                                            <div class="input-group">
                                                <input id="device" class="form-control mask-decimal" name="device" autocomplete="off" required>
                                            </div>
                                        </div>

                                        <div class="form-group col-3">
                                            <label for="network" class="font-weight-normal">Network</label>
                                            <div class="input-group">
                                                <input id="network" class="form-control mask-decimal" name="network" autocomplete="off" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-7">
                                            <label for="note">Note</label>
                                            <textarea id="note" class="form-control" name="note" rows="3" required></textarea>
                                        </div>
                                    </div>
                                </fieldset>

                               <!--  <div class="form-row mt-2 mb-4">
                                    <div class="form-group col-7">
                                        <label for="note">Note</label>
                                        <textarea id="note" class="form-control" name="note" rows="3"></textarea required>
                                    </div>
                                </div> -->

                                <div class="form-row mt-2 mb-4">
                                    <button class="btn btn-primary px-4" type="submit">SAVE</button>
                                </div>
                            </div>
                            </form>

                        </div>
                    </div>
                    <?php } ?>

                    <div class="tab-pane fade <?= !AuthHelper::is_access_privilege($isModuleCode, 'crt') ? 'show active' : ''; ?>" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                       <div class="card">
                            <div class="card-body px-lg-4">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                      <form id="form-filter" class="form-horizontal">
                                            <div class="form-row">
                                                <div class="form-group col-2">
                                                    <label for="areaFilter">Area</label>
                                                    <?= $select_area_filter; ?>
                                                </div>

                                                <div class="form-group col-2">
                                                    <label for="yearFilter">Year</label>
                                                    <?= $select_years_filter; ?>
                                                </div>

                                                <div class="form-group col-2">
                                                    <label for="monthFilter">Month</label>
                                                    <?= $select_month_filter; ?>
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
                                    <table id="tableIso" style="width:100%" class="table table-striped table-sm text-center">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Area</th>
                                                <th>Year</th>
                                                <th>Month</th>
                                                <th>People</th>
                                                <th>System</th>
                                                <th>Device</th>
                                                <th>Network</th>
                                                <th style="width:200px">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
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

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="soi/approve" method="POST">
            @csrf
            <!-- <div class="modal-header border-0">
                <h5 class="modal-title" id="deleteModalLabel">Are you sure to Delete?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div> -->

            <div class="modal-body">
                <h5>Are you sure to Approve?</h5>
            </div>

            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <input id="idApprove" type="text" name="id" hidden>
                <button type="submit" class="btn btn-danger px-4">Yes</button>
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
            <form action="soi/delete" method="POST">
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

<script type="text/javascript">
    $( document ).ready(function() {
        $('.mask-decimal').mask("#.##", {reverse: true}).attr('maxlength', 3);
        $('.mask-percent').mask("###", {reverse: true}).attr('maxlength', 3);

        $('#knowlage,#attitude,#skill').keyup(function (e) {
            var kno = $('#knowlage').val();
            var att = $('#attitude').val();
            var ski = $('#skill').val();

            var arrAvg = [];
            if(kno.length != 0)
            {
                arrAvg.push(kno);
            }

            if(att.length != 0)
            {
                arrAvg.push(att);
            }

            if(ski.length != 0)
            {
                arrAvg.push(ski);
            }

            // const arrAvg = [kno, att, ski];

            var total=arrAvg.map(function(n){
                return n*100;
            }).reduce(function(a, b){
                return a+(b || 0);
            });

            const resAvg =  Math.round((total/arrAvg.length))/100;

            $('#people').val(resAvg);
        });

        $('#asms,#guardtour').keyup(function (e) {
            var asm = $('#asms').val();
            var gto = $('#guardtour').val();

            // dibagi
            var asmB = (asm / 20);
            var gtoB = (gto / 20);

            if(gto.length === 0)
            {
                var arrAvg = [asmB];
            }
            else
            {
                var arrAvg = [asmB, gtoB];
            }

            // console.log(arrAvg)

            var total=arrAvg.map(function(n){
                return n*100;
            }).reduce(function(a, b){
                return a+(b || 0);
            });

            const resAvg =  Math.round((total/arrAvg.length))/100;

            $('#system').val(resAvg); //asm+' - '+gto
        });

        //datatables
        table = $('#tableIso').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": true,
            "order": [],
            "autoWidth": false,

            "ajax": {
                "url": "<?=url('srs/soi/list_table');?>",
                "type": "POST",
                "data": function ( data ) {
                    data._token = "{{ csrf_token() }}";
                    data.areafilter = $('#areaFilter').val();
                    data.yearfilter = $('#yearFilter').val();
                    data.monthfilter = $('#monthFilter').val();
                }
            },
            "columnDefs": [
            {
                "targets": [ 0, 8 ],
                "orderable": false
            }
            ],
        });

        $('#btn-filter').click(function(){
            table.ajax.reload();  //just reload table
        });

        $('#btn-reset').click(function(){
            $('#form-filter')[0].reset();
            table.ajax.reload();  //just reload table
        });

        // mengambil julmah rata Guard Tour
        $("#area, #years, #month").change(function(e) {
            var area = $("#area").val()
            var year = $("#years").val()
            var month = $("#month").val()
            var asm = $('#asms').val();

            if(area.length !=0 && year.length !=0 && month.length)
            {
                $.ajax({
                    url: '<?= url('srs/soi/get_performance_gt'); ?>',
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        area: area,
                        year: year,
                        month: month,
                    },
                    cache: false,
                    beforeSend: function() {
                        // document.getElementById("loader").style.display = "block";
                    },
                    complete: function() {
                        // document.getElementById("loader").style.display = "none";
                    },
                    success: function(res) {
                        var json = JSON.parse(res)

                        // jika plant 4
                        if(area === '4')
                        {
                            var pefGt = Math.round(json.performance_gt / 2)
                        }
                        else
                        {
                            var pefGt = Math.round(json.performance_gt / 20)
                        }

                        var arrAvg = [(pefGt / 20)]

                        if(asm.length != 0)
                        {
                            arrAvg.push((asm / 20));
                        }

                        var total=arrAvg.map(function(n){
                            return n*100;
                        }).reduce(function(a, b){
                            return a+(b || 0);
                        });

                        const resAvg =  Math.round((total/arrAvg.length))/100;

                        $('#guardtour').val(pefGt)
                        $('#system').val(resAvg)
                    }
                });
            }
        });

        $('#detailModal').on('shown.bs.modal', function (e) {
            const target = $(e.relatedTarget);
            const modal = $(this);
            const id = target.data('id')
            const row = $(target).closest("tr");
            const title = row.find("td:nth-child(2)");

            // console.log(title)
            // modal.find('#detailModalLabel').text(tds.text());

            $.ajax({
                url: '<?= url('srs/soi/detail'); ?>',
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                cache: false,
                beforeSend: function() {
                  $(".lds-ring").show();
                },
                success : function(data){
                    $(".lds-ring").hide();
                    $('#detailModal .modal-body').html(data);//menampilkan data ke dalam modal
                }
            });
        });
        
        $('#deleteModal').on('shown.bs.modal', function (e) {
            $('#deleteModal .modal-body .title-approve').remove()
            
            const target = $(e.relatedTarget);
            const modal = $(this);
            const id = target.data('id')
            const title = target.data('title')

            $('#idDelete').val(id)
            $('#deleteModal .modal-body h5').after(`
               <span class="font-weight-bold title-approve">${title}</span> 
            `)
        })

        $('#approveModal').on('shown.bs.modal', function (e) {
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