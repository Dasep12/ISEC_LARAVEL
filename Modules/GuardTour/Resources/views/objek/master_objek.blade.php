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
                    <li class="breadcrumb-item"><a href="">Master Objek</a></li>
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
                        <h3 class="card-title">Data Objek</h3>
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
                        <a class="btn btn-sm btn-primary" href="{{ route('objek.form_add') }}"><i class="fa fa-plus"></i>
                            Tambah Objek
                        </a>
                        <a href="" class="btn btn-sm btn-success"><i class="fa fa-file-excel"></i> Upload Objek</a>
                        <form method="post" action="">
                            <div class="row justify-content-end">
                                <button onclick="return confirm('Yakin Hapus Data ?')" id="btn_delete_all" style="display:none ;" class="btn btn-danger btn-sm mb-2 mr-2"> <i class="fas fa-trash"></i> HAPUS DATA TERPILIH</button>
                            </div>
                            <table id="example" class="table-sm  mt-1 table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px;">
                                            <input id="check-all" type="checkbox">
                                        </th>
                                        <th style="width: 50px;">NO</th>
                                        <th>PLANT</th>
                                        <th>ZONA</th>
                                        <th>NAMA CHECKPOINT</th>
                                        <th>KATEGORI</th>
                                        <th>NAMA OBJEK</th>
                                        <th>STATUS</th>
                                        <th>OPSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php ($key = 1)
                                    @foreach($objek as $o)
                                    <tr>
                                        <td><input id="check-item" class="check-item" type="checkbox" name="id_check[]" value=""></td>
                                        <td>{{ $key++ }}</td>
                                        <td>{{ $o->plant_name }}</td>
                                        <td>{{ $o->zone_name }}</td>
                                        <td>{{ $o->check_name }}</td>
                                        <td>{{ $o->kategori_name }}</td>
                                        <td>{{ $o->nama_objek }}</td>
                                        <td>{{ $o->status == 1 ? 'ACTIVE' :  'INACTIVE'  }}</td>
                                        <td>
                                            <a href="{{ route('objek.destroy',['d' => $o->objek_id ]) }}" onclick="return confirm('Yakin Hapus ?')" class='text-danger' title="hapus data"><i class="fa fa-trash"></i></a>

                                            <a href='' data-toggle="modal" data-target="#edit-data" class="text-primary ml-2" title="lihat data" data-backdrop="static" data-keyboard="false" data-id="{{ $o->objek_id }}" data-plant="{{ $o->plant_name }}" data-check="{{ $o->check_name }}" data-zone="{{ $o->zone_name }}" data-others="{{ $o->others }}" data-status="{{ $o->status }}" data-objek_name="{{ $o->nama_objek }}" data-kategori="{{ $o->kategori_name }}"><i class="fa fa-eye"></i></a>

                                            <a href="{{ route('objek.form_edit',['d' => $o->objek_id ]) }}" class='ml-2 text-success' title="edit data"><i class="fa fa-edit"></i></a>
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
                        <input type="text" readonly autocomplete="off" id="plant_name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">ZONA</label>
                        <input type="text" readonly autocomplete="off" id="zona" class="form-control">
                    </div>


                    <div class="form-group">
                        <label for="">NAMA CHECKPOINT</label>
                        <input type="text" readonly autocomplete="off" id="check" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">NAMA OBJEK</label>
                        <input type="text" readonly autocomplete="off" id="objek" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">KATEGORI</label>
                        <input type="text" readonly autocomplete="off" id="kategori" class="form-control">
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
            modal.find("#kategori").attr("value", div.data("kategori"));
            modal.find("#objek").attr("value", div.data("objek_name"));
            modal.find("#plant_name").attr("value", div.data("plant"));
            if (div.data("status") == 1) {
                modal.find("#status").attr("value", "ACTIVE");
            } else {
                modal.find("#status").attr("value", "INACTIVE");
            }
            document.getElementById("others").value = div.data("others");
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
    });
</script>
@endsection