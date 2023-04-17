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
                    <li class="breadcrumb-item"><a href="">Master Produksi</a></li>
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
                        <h3 class="card-title">Data Produksi</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <a class="btn btn-sm btn-primary" href="{{ route('produksi.form_add') }}"><i class="fa fa-plus"></i>
                            Tambah Data
                        </a>
                        <form method="post" action="">
                            <table id="example2" class="table-sm  mt-1 table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>NAMA</th>
                                        <th>STATUS</th>
                                        <th>OPSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php ($key = 1)
                                    @foreach($produksi as $p)
                                    <tr>
                                        <td>{{ $key++ }}</td>
                                        <td>{{ $p->name }}</td>
                                        <td>{{ $p->status == 1 ? 'ACTIVE' :  'INACTIVE'  }}</td>
                                        <td>
                                            <a href="{{ route('produksi.destroy',['d' => $p->produksi_id ]) }}" onclick="return confirm('Yakin Hapus ?')" class='text-danger' title="hapus data"><i class="fa fa-trash"></i></a>

                                            <a href='' data-toggle="modal" data-target="#edit-data" class="text-primary ml-2" title="lihat data" data-backdrop="static" data-keyboard="false" data-id="{{ $p->produksi_id }}" data-status="{{ $p->status }}" data-production="{{ $p->name }}"><i class="fa fa-eye"></i></a>

                                            <a href="{{ route('produksi.form_edit',['d' => $p->produksi_id ]) }}" class='ml-2 text-success' title="edit data"><i class="fa fa-edit"></i></a>
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
                        <label>NAMA</label>
                        <input type="text" readonly class="form-control" id="produksi">
                    </div>

                    <div class="form-group">
                        <label>STATUS</label>
                        <input type="text" readonly class="form-control" id="status">
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
            modal.find("#name").attr("value", div.data("name"));
            modal.find("#produksi").attr("value", div.data("production"));
            if (div.data("status") == 1) {
                modal.find("#status").attr("value", "ACTIVE");
            } else {
                modal.find("#status").attr("value", "INACTIVE");
            }
        });
    });
</script>
@endsection