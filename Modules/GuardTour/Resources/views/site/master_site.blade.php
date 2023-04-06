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
                    <i class="fas fa-check"></i>
                    {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Wilayah</h3>
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
                        <a class="btn btn-sm btn-primary" href="{{ route('site.form_add') }}"><i class="fa fa-plus"></i>
                            Tambah Wilayah
                        </a>
                        <table class="table-sm  mt-1 table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>PERUSAHAAN</th>
                                    <th>WILAYAH</th>
                                    <th>STATUS</th>
                                    <th>OPSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($key = 1)
                                @foreach($site as $s)
                                <tr>
                                    <td>{{ $key++ }}</td>
                                    <td>{{ $s->company->comp_name }}</td>
                                    <td>{{ $s->site_name }}</td>
                                    <td>{{ $s->status == 1 ? 'ACTIVE' :  'INACTIVE' }}</td>
                                    <td>

                                        <a href='' title="lihat data" data-toggle="modal" data-target="#edit-data" class="ml-2 text-primary" data-backdrop="static" data-keyboard="false" data-id="{{ $s->site_id }}" data-ket="{{ $s->others }}" data-site_name="{{ $s->site_name }}" data-comp_name="{{ $s->company->comp_name }}" data-status="{{ $s->status }}"><i class="fa fa-eye"></i></a>

                                        <a title="hapus data" href="{{ route('site.destroy',['d' => $s->site_id ]) }}" onclick="return confirm('Yakin Hapus ?')" class='text-danger'><i class="fa fa-trash"></i></a>

                                        <a title="edit data" href="{{ route('site.form_edit',['d' => $s->site_id .'&'. md5('company') ]) }}" class='ml-2  text-success'><i class="fa fa-edit"></i></a>
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

                <div class="form-group">
                    <label for="">PERUSAHAAN</label>
                    <input type="text" readonly class="form-control" id="comp">
                </div>
                <div class="form-group">
                    <label for="">NAMA WILAYAH</label>
                    <input type="text" readonly autocomplete="off" id="site_name2" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">STATUS</label>
                    <input type="text" readonly autocomplete="off" id="status2" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">KETERANGAN</label>
                    <textarea readonly class="form-control" id="others2"></textarea>
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
            modal.find("#id_comp").attr("value", div.data("id"));
            modal.find("#site_name2").attr("value", div.data("site_name"));
            modal.find("#site_name3").attr("value", div.data("site_name"));
            modal.find("#site_no2").attr("value", div.data("site_no"));
            modal.find("#comp").attr("value", div.data("comp_name"));
            if (div.data("status") == 1) {
                modal.find("#status2").attr("value", "ACTIVE");
            } else {
                modal.find("#status2").attr("value", "INACTIVE");
            }
            document.getElementById("others2").value = div.data("ket");
        });
    });
</script>
@endsection