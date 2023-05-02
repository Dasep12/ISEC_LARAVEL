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
                    <li class="breadcrumb-item"><a href="">Master Event</a></li>
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
                        <h3 class="card-title">Data Event</h3>
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
                        <a class="btn btn-sm btn-primary" href="{{ route('settings.form_add') }}"><i class="fa fa-plus"></i>
                            Tambah Settings
                        </a>
                        <form method="post" action="">

                            <table id="example" class="table-sm  mt-1 table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>NAMA SETTING</th>
                                        <th>NILAI</th>
                                        <th>TYPE</th>
                                        <th>UNIT</th>
                                        <th>STATUS</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php ($key = 1)
                                    @foreach($setting as $s)
                                    <tr>
                                        <td>{{ $key++ }}</td>
                                        <td>{{ $s->nama_setting }}</td>
                                        <td>
                                            <pre>{{ $s->nilai_setting }}</pre>
                                        </td>
                                        <td>{{ $s->type }}</td>
                                        <td>{{ $s->unit }}</td>
                                        <td>{{ $s->status == 1 ? 'ACTIVE' :  'INACTIVE'  }}</td>
                                        <td>

                                            <a href='' data-toggle="modal" data-target="#view-data" class="text-primary ml-2" title="lihat data" data-backdrop="static" data-keyboard="false" data-id="{{ $s->id_setting }}" data-status="{{ $s->status }}" data-nama-setting="{{ $s->nama_setting }}" data-nilai-setting="{{ $s->nilai_setting }}" data-type="{{ $s->type }}" data-unit="{{ $s->unit }}"><i class="fa fa-eye"></i></a>

                                            <a href="{{ route('settings.form_edit',['d' => $s->id_setting ]) }}" class='ml-2 text-success' title="edit data"><i class="fa fa-edit"></i></a>
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
<div class="modal fade" id="view-data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>NAMA SETTING</label>
                    <input type="text" readonly class="form-control" id="nama-setting">
                </div>
                <div class="form-group">
                    <label>NILAI SETTING</label>
                    <textarea type="text" readonly class="form-control" id="nilai-setting"></textarea>
                </div>

                <div class="form-group">
                    <label>TYPE</label>
                    <input type="text" readonly class="form-control" id="type">
                </div>

                <div class="form-group">
                    <label>UNIT</label>
                    <input type="text" readonly class="form-control" id="unit">
                </div>
                <div class="form-group">
                    <label>STATUS</label>
                    <input type="text" readonly class="form-control" id="status">
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
    // Untuk sunting modal data edit zona
    $("#view-data").on("show.bs.modal", function(event) {
        var div = $(event.relatedTarget); // Tombol dimana modal di tampilkan
        var modal = $(this);
        modal.find("#nama-setting").attr("value", div.data("nama-setting"));
        modal.find("#nilai-setting").text("'" + div.data("nilai-setting") + "'");
        modal.find("#type").attr("value", div.data("type"));
        modal.find("#unit").attr("value", div.data("unit"));
        if (div.data("status") === 1) {
            modal.find("#status").attr("value", "ACTIVE");
        } else {
            modal.find("#status").attr("value", "INACTIVE");
        }

        console.log(JSON.stringify(div.data("nilai-setting")));
    });
</script>
@endsection