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
                    <li class="breadcrumb-item"><a href="">Master Company</a></li>
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
                    {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Perusahaan</h3>
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
                        <a class="btn btn-sm btn-primary" href="{{ route('plant.form_add') }}"><i class="fa fa-plus"></i>
                            Tambah Plant
                        </a>

                        <table class="table-sm  mt-1 table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>PERUSAHAAN</th>
                                    <th>WILAYAH</th>
                                    <th>KODE PLANT</th>
                                    <th>NAMA PLANT</th>
                                    <th>STATUS</th>
                                    <th>OPSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php ($key = 1)
                                @foreach($plant as $p)
                                <tr>
                                    <td>{{ $key++ }}</td>
                                    <td>{{ $p->comp_name }}</td>
                                    <td>{{ $p->site_name }}</td>
                                    <td>{{ $p->plant_name }}</td>
                                    <td>{{ $p->kode_plant }}</td>
                                    <td>{{ $p->status == 1 ? 'ACTIVE' :  'INACTIVE'  }}</td>
                                    <td>
                                        <a href="{{ route('plant.destroy',['d' => $p->plant_id ]) }}" onclick="return confirm('Yakin Hapus ?')" class='text-danger' title="hapus data"><i class="fa fa-trash"></i></a>

                                        <a href='' data-toggle="modal" data-target="#edit-data" class="text-primary ml-2" title="lihat data" data-backdrop="static" data-keyboard="false" data-id="{{ $p->plant_id }}" data-plant_name="{{ $p->plant_name }}" data-site_no="{{ $p->admisecsgp_mstsite_site_id }} " data-status="{{ $p->status }}" data-ket="{{ $p->others }}" data-comp_name="{{ $p->comp_name }}" data-site_name="{{ $p->site_name }}" data-plantkode="{{ $p->kode_plant}} "><i class="fa fa-eye"></i></a>

                                        <a href="{{ route('plant.form_edit',['d' => $p->plant_id ]) }}" class='ml-2 text-success' title="edit data"><i class="fa fa-edit"></i></a>
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

                    <label for="">PERUSAHAAN</label>
                    <input type="text" readonly autocomplete="off" id="comp_" class="form-control">

                    <label for="">WILAYAH</label>
                    <input type="text" readonly autocomplete="off" id="wil_" class="form-control">

                    <label for="">NAMA PLANT</label>
                    <input type="text" readonly autocomplete="off" id="plant_name2" class="form-control">
                    <label for="">KODE PLANT</label>
                    <input type="text" readonly autocomplete="off" id="kodeplant" class="form-control">

                    <label for="">STATUS</label>
                    <input type="text" readonly autocomplete="off" id="status2" class="form-control">

                    <label for="">KETERANGAN</label>
                    <textarea name="others2" readonly class="form-control" id="others2"></textarea>

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
            modal.find("#plant_name2").attr("value", div.data("plant_name"));
            modal.find("#comp_").attr("value", div.data("comp_name"));
            modal.find("#wil_").attr("value", div.data("site_name"));
            modal.find("#kodeplant").attr("value", div.data("plantkode"));
            if (div.data("status") == 1) {
                modal.find("#status2").attr("value", "ACTIVE");
            } else {
                modal.find("#status2").attr("value", "INACTIVE");
            }

            document.getElementById("others2").value = div.data("ket")
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