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
                        <a class="btn btn-sm btn-primary" href="{{ route('company.form_add') }}"><i class="fa fa-plus"></i>
                            Tambah Perusahaan
                        </a>

                        <table class="table-sm  mt-1 table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>NAMA PERUSAHAAN</th>
                                    <th>ALAMAT</th>
                                    <th>TELEPON</th>
                                    <th>STATUS</th>
                                    <th>OPSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($company as $c)
                                @php($key = 1)
                                <tr>
                                    <td>{{ $key++ }}</td>
                                    <td>{{ $c->comp_name }}</td>
                                    <td>{{ $c->address1 }}</td>
                                    <td>{{ $c->comp_phone }}</td>
                                    <td>{{ $c->status == 1 ? 'ACTIVE' :  'INACTIVE' }}</td>
                                    <td>
                                        <a href='' title="lihat data" data-toggle="modal" data-target="#edit-data" class="ml-2 text-primary" data-backdrop="static" data-keyboard="false" data-id="{{ $c->company_id }}" data-comp_name="{{ $c->comp_name }}" data-address="{{ $c->address1 }}" data-telepon="{{ $c->comp_phone }}"><i class="fa fa-eye"></i></a>

                                        <a title="hapus data" href="{{ route('company.destroy',['d' => $c->company_id ]) }}" onclick="return confirm('Yakin Hapus ?')" class='text-danger'><i class="fa fa-trash"></i></a>

                                        <a title="edit data" href="{{ route('company.form_edit',['d' => $c->company_id .'&'. md5('company') ]) }}" class='ml-2  text-success'><i class="fa fa-edit"></i></a>
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
                    <label for="">NAMA PERUSAHAAN</label>
                    <input type="text" readonly autocomplete="off" id="comp_name2" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">TELEPON</label>
                    <input type="text" readonly autocomplete="off" id="comp_phone2" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">ALAMAT</label>
                    <textarea readonly autocomplete="off" class="form-control" id="address1a" cols="4" rows="2"></textarea>
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
            modal.find("#comp_id2").attr("value", div.data("id"));
            modal.find("#comp_no2").attr("value", div.data("comp_no"));
            modal.find("#comp_name2").attr("value", div.data("comp_name"));
            modal.find("#comp_phone2").attr("value", div.data("telepon"));
            document.getElementById("address1a").value = div.data("address");
        });
    });
</script>
@endsection