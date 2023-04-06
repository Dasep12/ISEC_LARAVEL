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
                    <li class="breadcrumb-item"><a href="">Master Zona</a></li>
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
                        <h3 class="card-title">Data Zona</h3>
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
                        <a class="btn btn-sm btn-primary" href="{{ route('zona.form_add') }}"><i class="fa fa-plus"></i>
                            Tambah Zona
                        </a>

                        <table id="example2" class="table-sm  mt-1 table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>WILAYAH</th>
                                    <th>PLANT</th>
                                    <th>KODE ZONA</th>
                                    <th>NAMA ZONA</th>
                                    <th>STATUS</th>
                                    <th>OPSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php ($key = 1)
                                @foreach($zona as $z)
                                <tr>
                                    <td>{{ $key++ }}</td>
                                    <td>{{ $z->site_name }}</td>
                                    <td>{{ $z->plant_name }}</td>
                                    <td>{{ $z->kode_zona }}</td>
                                    <td>{{ $z->zone_name }}</td>
                                    <td>{{ $z->status == 1 ? 'ACTIVE' :  'INACTIVE'  }}</td>
                                    <td>
                                        <a href="{{ route('zona.destroy',['d' => $z->zone_id ]) }}" onclick="return confirm('Yakin Hapus ?')" class='text-danger' title="hapus data"><i class="fa fa-trash"></i></a>

                                        <a href='' data-toggle="modal" data-target="#edit-data" class="text-primary ml-2" title="lihat data" data-backdrop="static" data-keyboard="false" data-id="{{ $z->zone_id }}" data-zone_name="{{ $z->zone_name }}" data-plant="{{ $z->plant_name }}" data-kodezona="{{ $z->kode_zona }}" data-others="{{ $z->others }}" data-status="{{ $z->status }}"><i class="fa fa-eye"></i></a>

                                        <a href="{{ route('zona.form_edit',['d' => $z->zone_id ]) }}" class='ml-2 text-success' title="edit data"><i class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                        <label for="">NAMA ZONA</label>
                        <input type="text" readonly autocomplete="off" id="zone_name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">KODE ZONA</label>
                        <input type="text" readonly autocomplete="off" id="kode_zona" class="form-control">
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
            modal.find("#plant").attr("value", div.data("plant"));
            modal.find("#zone_name").attr("value", div.data("zone_name"));
            modal.find("#kode_zona").attr("value", div.data("kodezona"));
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
    });
</script>
@endsection