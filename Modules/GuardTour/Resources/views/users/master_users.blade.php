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
                    <li class="breadcrumb-item"><a href="">Master Users</a></li>
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
                        <h3 class="card-title">Data Users</h3>
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
                        <a class="btn btn-sm btn-primary" href="{{ route('users.form_add') }}"><i class="fa fa-plus"></i>
                            Tambah Users
                        </a>

                        <form method="post" action="">
                            <div class="row justify-content-end">
                                <button onclick="return confirm('Yakin Hapus Data ?')" id="btn_delete_all" style="display:none ;" class="btn btn-danger btn-sm mb-2 mr-2"> <i class="fas fa-trash"></i> HAPUS DATA TERPILIH</button>
                            </div>
                            <table id="example" class="table-sm  mt-1 table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">NO</th>
                                        <th>NPK</th>
                                        <th>NAMA</th>
                                        <th>GRUP PATROLI</th>
                                        <th>EMAIL</th>
                                        <th>ROLE AKSES</th>
                                        <th>LEVEL</th>
                                        <th>STATUS</th>
                                        <th>OPSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php ($key = 1)
                                    @foreach($users as $u)
                                    <tr>
                                        <td>{{ $key++ }}</td>
                                        <td>{{ $u->npk }}</td>
                                        <td>{{ $u->name }}</td>
                                        <td>{{ $u->patrol_group }}</td>
                                        <td>{{ $u->email }}</td>
                                        <td>
                                            {{ $u->level == 'ADMIN' ? $u->site_name : $u->plant_name }}
                                        </td>
                                        <td>{{ $u->level }}</td>
                                        <td>{{ $u->status == 1 ? 'ACTIVE' :  'INACTIVE'  }}</td>
                                        <td>
                                            <a href="{{ route('users.destroy',['d' => $u->npk ]) }}" onclick="return confirm('Yakin Hapus ?')" class='text-danger' title="hapus data"><i class="fa fa-trash"></i></a>

                                            <a href='' data-toggle="modal" data-target="#edit-data" class="text-primary ml-2" title="lihat data" data-backdrop="static" data-keyboard="false" data-level="{{ $u->level }}" data-npk="{{ $u->npk }}" data-email="{{ $u->email }}" data-grup="{{ $u->patrol_group }}" data-status="{{ $u->status }}" data-plant="{{ strtoupper($u->plant_name)  }}" data-site="{{ strtoupper($u->site_name) }}" data-nama="{{ strtoupper($u->name) }}"><i class="fa fa-eye"></i></a>

                                            <a href="{{ route('users.form_edit',['d' => $u->npk]) }}" class='ml-2 text-success' title="edit data"><i class="fa fa-edit"></i></a>
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
                        <input readonly type="text" class="form-control" id="nama">
                    </div>

                    <div class="form-group">
                        <label>NPK</label>
                        <input type="text" readonly class="form-control" id="npk">
                    </div>
                    <div class="form-group">
                        <label>EMAIL</label>
                        <input type="text" readonly class="form-control" id="email">
                    </div>

                    <div class="form-group">
                        <label>WILAYAH</label>
                        <input readonly type="text" class="form-control" id="site">
                    </div>

                    <div class="form-group">
                        <label>PLANT</label>
                        <input readonly type="text" class="form-control" id="plant">
                    </div>

                    <div class="form-group">
                        <label>LEVEL</label>
                        <input readonly type="text" class="form-control" id="level">
                    </div>
                    <div class="form-group">
                        <label>GRUP PATROLI</label>
                        <input readonly type="text" class="form-control" id="grup">
                    </div>
                    <div class="form-group">
                        <label>STATUS</label>
                        <input readonly type="text" class="form-control" id="status">
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
            modal.find("#nama").attr("value", div.data("nama"));
            modal.find("#email").attr("value", div.data("email"));
            modal.find("#npk").attr("value", div.data("npk"));
            modal.find("#site").attr("value", div.data("site"));
            modal.find("#plant").attr("value", div.data("plant"));
            modal.find("#level").attr("value", div.data("level"));
            modal.find("#grup").attr("value", div.data("grup"));
            if (div.data("status") == 1) {
                modal.find("#status").attr("value", "ACTIVE");
            } else {
                modal.find("#status").attr("value", "INACTIVE");
            }
        });
    });
</script>
@endsection