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
                        <button class="nav-link active" id="nav-edit-tab" data-toggle="tab" data-target="#nav-edit" type="button" role="tab" aria-controls="nav-edit" aria-selected="true">Edit Data</button>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-edit" role="tabpanel" aria-labelledby="nav-edit-tab">
                        <div class="card">

                            <form action="{{ url('srs/soi/update') }}" method="POST">
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
                                                    <input id="knowlage" class="form-control mask-decimal" name="knowlage" autocomplete="off" value="<?=$data_edit->knowlage;?>" required>
                                                </div>
                                            </div>
                                            <div class="form-group col-12">
                                                <label for="attitude" class="font-weight-normal">Attitude</label>
                                                <div class="input-group">
                                                    <input id="attitude" class="form-control mask-decimal" name="attitude" value="<?=$data_edit->attitude;?>" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="form-group col-12">
                                                <label for="skill" class="font-weight-normal">Skill</label>
                                                <div class="input-group">
                                                    <input id="skill" class="form-control mask-decimal" name="skill" value="<?=$data_edit->skill;?>" autocomplete="off" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-3">
                                            <div class="form-group col-12">
                                                <label for="asms" class="font-weight-normal">ASMS</label>
                                                <div class="input-group">
                                                    <input id="asms" class="form-control mask-percent" name="asms" value="<?=$data_edit->asms_value;?>" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="form-group col-12">
                                                <label for="guardtour" class="font-weight-normal">Guard Tour Performance</label>
                                                <div class="input-group">
                                                    <input id="guardtour" class="form-control mask-percent" name="guardtour" value="<?=$data_edit->perform_gt;?>" autocomplete="off" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        
                                    <div class="form-row">
                                        <div class="form-group col-3">
                                            <label for="people" class="font-weight-normal">People</label>
                                            <div class="input-group">
                                                <input id="people" class="form-control mask-decimal" name="people" value="<?=$data_edit->people;?>" autocomplete="off" readonly required>
                                            </div>
                                        </div>

                                        <div class="form-group col-3">
                                            <label for="system" class="font-weight-normal">System</label>
                                            <div class="input-group">
                                                <input id="system" class="form-control mask-decimal" name="system" value="<?=$data_edit->system;?>" autocomplete="off" readonly required>
                                            </div>
                                        </div>

                                        <div class="form-group col-3">
                                            <label for="device" class="font-weight-normal">Device</label>
                                            <div class="input-group">
                                                <input id="device" class="form-control mask-decimal" name="device" value="<?=$data_edit->device;?>" autocomplete="off" required>
                                            </div>
                                        </div>

                                        <div class="form-group col-3">
                                            <label for="network" class="font-weight-normal">Network</label>
                                            <div class="input-group">
                                                <input id="network" class="form-control mask-decimal" name="network" value="<?=$data_edit->network;?>" autocomplete="off" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-7">
                                            <label for="note">Note</label>
                                            <textarea id="note" class="form-control" name="note" rows="3" required><?=$data_edit->note;?></textarea>
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
                                    <input type="text" name="id" value="<?= $data_edit->id; ?>" hidden>
                                    <button class="btn btn-primary px-4" type="submit">UPDATE</button>
                                </div>
                            </div>
                            </form>

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
            
            var total=arrAvg.map(function(n){
                return n*100;
            }).reduce(function(a, b){
                return a+(b || 0);
            });

            const resAvg =  Math.round((total/arrAvg.length))/100;

            $('#system').val(resAvg); //asm+' - '+gto
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
                "targets": [ 0 ],
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

        $('#detailModal').on('shown.bs.modal', function (e) {
            const target = $(e.relatedTarget);
            const modal = $(this);
            const id = target.data('id')
            const row = $(target).closest("tr");
            const title = row.find("td:nth-child(2)");

            console.log(title)
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