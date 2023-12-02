@extends('guardtour::layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Company</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="">Master Checkpoint</a></li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Default box -->
                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check"></i>
                    {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Checkpoint</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <!-- <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i>
                            </button> -->
                        </div>
                    </div>
                    <div class="card-body">
                        <a class="btn btn-sm btn-primary" href="{{ route('checkpoint.form_add') }}"><i class="fa fa-plus"></i>
                            Tambah Checkpoint
                        </a>
                        <a href="" class="btn btn-sm btn-success"><i class="fa fa-file-excel"></i> Upload Checkpoint</a>

                        <form method="post" action="">
                            <div class="row justify-content-end">
                                <button onclick="return confirm('Yakin Hapus Data ?')" id="btn_delete_all" style="display:none ;" class="btn btn-danger btn-sm mb-2 mr-2"> <i class="fas fa-trash"></i> HAPUS DATA TERPILIH</button>
                            </div>
                            <table id="example5" class="table-sm  mt-1 table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px;">
                                            <input id="check-all" type="checkbox">
                                        </th>
                                        <th>NO</th>
                                        <th>PLANT</th>
                                        <th>ZONA</th>
                                        <th>NAMA CHECKPOINT</th>
                                        <th>ID CHECKPOINT</th>
                                        <th>STATUS</th>
                                        <th>OPSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php ($key = 1)
                                    @foreach($checkpoint as $c)
                                    <tr>
                                        <td><input id="check-item" class="check-item" type="checkbox" name="id_check[]" value=""></td>
                                        <td>{{ $key++ }}</td>
                                        <td>{{ $c->plant_name }}</td>
                                        <td>{{ $c->zone_name }}</td>
                                        <td>{{ $c->check_name }}</td>
                                        <td>{{ $c->check_no }}</td>
                                        <td>{{ $c->status == 1 ? 'ACTIVE' :  'INACTIVE'  }}</td>
                                        <td>
                                            <a href="{{ route('checkpoint.destroy',['d' => $c->checkpoint_id ]) }}" onclick="return confirm('Yakin Hapus ?')" class='text-danger' title="hapus data"><i class="fa fa-trash"></i></a>

                                            <a href='' data-toggle="modal" data-target="#edit-data" class="text-primary ml-2" title="lihat data" data-backdrop="static" data-keyboard="false" data-id="{{ $c->checkpoint_id }}" data-check="{{ $c->check_name }}" data-check_no="{{ $c->check_no }}" data-zone="{{ $c->zone_name }}" data-others="{{ $c->others }}" data-status="{{ $c->status }}" data-durasi="{{ $c->durasi_batas_atas }}" data-durasi2="{{ $c->durasi_batas_bawah }}" data-plant="{{ $c->plant_name }}"><i class="fa fa-eye"></i></a>

                                            <a href="{{ route('checkpoint.form_edit',['d' => $c->checkpoint_id , 'z' => $c->plant_id ]) }}" class='ml-2 text-success' title="edit data"><i class="fa fa-edit"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</section>



<!-- modal lihat data company -->
<div class="modal fade" id="edit-data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body">

                <div class="card-body">

                    <div class="form-group">
                        <label for="">PLANT</label>
                        <input type="text" readonly autocomplete="off" id="plant" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">ZONA</label>
                        <input type="text" readonly autocomplete="off" id="zona" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">ID CHECKPOINT</label>
                        <input type="text" readonly autocomplete="off" id="check_no" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">NAMA CHECKPOINT</label>
                        <input type="text" readonly autocomplete="off" id="check" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">DURASI BATAS ATAS</label>
                        <input type="text" readonly autocomplete="off" id="durasi" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">DURASI BATAS BAWAH</label>
                        <input type="text" readonly autocomplete="off" id="durasi2" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">STATUS</label>
                        <input type="text" readonly class="form-control" id="status">
                    </div>

                    <div class="form-group">
                        <label for="">Keterangan</label>
                        <textarea class="form-control" readonly id="others" cols="4" rows="2"></textarea>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- lihat data company -->



<script>
    $(document).ready(function() {
        // Untuk sunting modal data edit zona
        $("#edit-data").on("show.bs.modal", function(event) {
            var div = $(event.relatedTarget); // Tombol dimana modal di tampilkan
            var modal = $(this);
            // Isi nilai pada field
            modal.find("#zona").attr("value", div.data("zone"));
            modal.find("#check").attr("value", div.data("check"));
            modal.find("#check_no").attr("value", div.data("check_no"));
            modal.find("#plant").attr("value", div.data("plant"));
            modal.find("#durasi").attr("value", div.data("durasi") + ' menit');
            modal.find("#durasi2").attr("value", div.data("durasi2") + ' menit');
            if (div.data("status") == 1) {
                modal.find("#status").attr("value", "ACTIVE");
            } else {
                modal.find("#status").attr("value", "INACTIVE");
            }
            document.getElementById("others").value = div.data("others");
        });

        //input data wilayah berdasarkan
        $('select[name=comp_id').on('change', function() {
            var id = $("select[name=comp_id] option:selected").val();
            if (id == null || id == "") {
                document.getElementById('list_wilayah').innerHTML = "";
            } else {
                $.ajax({
                    url: "",
                    method: "POST",
                    processData: false,
                    contentType: false,
                    data: "id=" + id,
                    success: function(e) {
                        document.getElementById('list_wilayah').innerHTML = e;
                    }
                })
            }
        });

        $(".check-item").click(function() {
            var panjang = $('[name="id_check[]"]:checked').length;
            if (panjang > 0) {
                document.getElementById('btn_delete_all').style.display = "block";
            } else {
                document.getElementById('btn_delete_all').style.display = "none";

            }
        })

        $("#check-all").click(function() {
            if ($(this).is(":checked")) {
                $(".check-item").prop("checked", true);
                document.getElementById('btn_delete_all').style.display = "block";
                var panjang = $('[name="id_check[]"]:checked').length;
            } else {
                $(".check-item").prop("checked", false);
                document.getElementById('btn_delete_all').style.display = "none";
            }
        })

        $('#example5 thead tr')
            .clone(true)
            .addClass('filters')
            .appendTo('#example5 thead');

        var table = $('#example5').DataTable({
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
    });
</script>
@endsection