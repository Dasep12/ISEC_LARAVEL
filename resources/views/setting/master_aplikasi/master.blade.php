<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Event</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
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
                @elseif ($message = Session::get('failed'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <a href="" data-toggle="modal" data-target="#add-data" data-backdrop="static" data-keyboard="false" class="btn btn-sm btn-success mb-2">
                    <i class="fa fa-plus"></i> Tambah Data
                </a>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-white">Data Aplikasi</h3>
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
                        <table id="example2" class="table-sm  mt-1 table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>APLIKASI</th>
                                    <th>CODE</th>
                                    <th>STATUS</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($aplikasi as $zn) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= strtoupper($zn->name) ?></td>
                                        <td><?= strtoupper($zn->code) ?></td>
                                        <td>
                                            <?php if ($zn->status == 1) { ?>
                                                ACTIVE
                                            <?php } else if ($zn->status == 0) { ?>
                                                INACTIVE
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <a href="#" data-id="<?= $zn->id ?>" data-code="<?= $zn->code ?>" data-name="<?= $zn->name ?>" data-toggle="modal" data-target="#edit-data" data-backdrop="static" data-keyboard="false" class='text-success ml-2 '><i class="fas fa-edit"></i></a>

                                            <a onclick="return confirm('Yakin Hapus ?')" href="/setting/masterApp/delete?d={{ $zn->id }}" class='ml-2 '><i class="text-danger fas fa-trash "></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
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


<!-- modal add -->
<div class="modal fade" id="add-data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>

            <div class="modal-body">
                <form method="post" action="/setting/masterApp/insert">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>NAMA APLIKASI</label>
                                <input type="text" name="name_apps" class="form-control" id="name_apps">
                            </div>
                            <div class="form-group">
                                <label>KODE APLIKASI</label>
                                <input type="text" name="code_apps" class="form-control" id="code_apps">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- edit -->


<div class="modal fade" id="edit-data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <form method="post" action="/setting/masterApp/update">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>NAMA APLIKASI</label>
                        <input type="text" name="id_apps" id="id_apps">
                        <input type="text" name="name_apps1" class="form-control" id="name_apps1">
                    </div>
                    <div class="form-group">
                        <label>KODE APLIKASI</label>
                        <input type="text" name="code_apps1" class="form-control" id="code_apps1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $("#edit-data").on("show.bs.modal", function(event) {
        var div = $(event.relatedTarget); // Tombol dimana modal di tampilkan
        var modal = $(this);
        // Isi nilai pada field
        modal.find("#code_apps1").attr("value", div.data("code"));
        modal.find("#name_apps1").attr("value", div.data("name"));
        modal.find("#id_apps").attr("value", div.data("id"));
    });
</script>