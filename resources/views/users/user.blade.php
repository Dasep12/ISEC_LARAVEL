@extends('template.template_first')

@section('content')
<?php

use Illuminate\Support\Facades\DB;

?>
<section class="content-header">
    <div class="container-fluid">
        <!-- <div class="row mb-2">
			<div class="col-sm-6">
				<h1>Dashboard</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Dashboard</a></li>
				</ol>
			</div>
		</div> -->
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 filter sticky-top-OFF">
                <a href="/Setting/Pengguna/register" class="mb-2 btn btn-sm btn-primary" data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-plus"></i> Tambah User
                </a>
                <div class="card cardIn2">
                    <div class="card-body">
                        <div class="card-body">
                            <table id="example2" class="mt-1 table table-sm   table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">NO</th>
                                        <th>NPK</th>
                                        <th>NAMA</th>
                                        <th>GRUP PATROLI</th>
                                        <th>PLANT</th>
                                        <th>LEVEL</th>
                                        <th>STATUS</th>
                                        <th>OPSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($key = 1)
                                    @foreach($users as $us)
                                    <tr>
                                        <td>{{ $key++ }}</td>
                                        <td>{{ $us->npk }}</td>
                                        <td>{{ $us->name }}</td>
                                        <td>{{ strtoupper($us->patrol_group) == "" ? 'NON-GROUP' : strtoupper($us->patrol_group)  }}</td>
                                        <td>
                                            <?php


                                            $plant = DB::select("select plant_name from admisecsgp_mstplant where admisecsgp_mstsite_site_id = '" . $us->site_id . "'");
                                            if ($us->level == 'SUPERADMIN') {
                                                echo 'ALL PLANT';
                                            } else if ($us->level == 'ADMIN') {
                                                foreach ($plant as $pln) {
                                                    echo $pln->plant_name . '<br>';
                                                }
                                            } else if ($us->level == 'SECURITY') {
                                                echo $us->plant_name;
                                            } else if ($us->level == 'SECTION HEAD 1') {
                                                echo $us->plant_name;
                                            }
                                            ?>
                                        </td>
                                        <td>{{ $us->level }}</td>
                                        <td>{{ $us->status == 1 ? 'ACTIVE' : 'INACTIVE' }}</td>
                                        <td>

                                            <a href="/Setting/Pengguna/delete?npk=<?= $us->npk ?>" onclick="return confirm('Yakin Hapus ?')" class='text-danger' title="hapus data"><i class="fa fa-trash"></i></a>

                                            <a href='' data-toggle="modal" data-target="#edit-data" class="text-primary ml-2 " title="lihat data" data-backdrop="static" data-keyboard="false" data-level="<?= $us->level ?>" data-npk="<?= $us->npk ?>" data-email="<?= $us->email ?>" data-grup="<?= $us->patrol_group ?>" data-status="<?= $us->status ?>" data-plant="<?= strtoupper($us->plant_name)  ?>" data-site="<?= strtoupper($us->site_name) ?>" data-nama="<?= strtoupper($us->name) ?>"><i class="fa fa-eye"></i></a>

                                            <a href="" class='text-success  ml-2 ' title="edit data" data-backdrop="static" data-keyboard="false" data-id=""><i class="fa fa-edit"></i></a>

                                            <a href="" class="text-warning  ml-2 " title="rubah password"><i class="fas fa-lock"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</section>

<!-- modal edit data user -->
<div class="modal fade" id="edit-data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
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

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <!-- edit data object -->


    <!-- modal edit password -->
    <div class="modal fade" id="edit-password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" onsubmit="return cekpassword()" action="Setting/Pengguna/resetPasword">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" id="id_user2" name="id_3">
                            <label for="">NEW PASSWORD</label>
                            <input type="password" class="form-control" id="password3" name="password3">
                        </div>

                        <div class="form-group">
                            <label for="">REWRITE NEW PASSWORD</label>
                            <input type="password" class="form-control" id="password4" name="password4">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Simpan</button>
                    </div>
            </div>
        </div>
    </div>
    </form>
</div>
<script>
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
</script>
@endsection