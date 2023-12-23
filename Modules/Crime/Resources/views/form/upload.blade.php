@extends('crime::layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
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
                    <strong>{{ $message }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                @if ($message = Session::get('failed'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ $message }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                @if(Session('role') == 'SUPERADMIN')
                <a href="{{ asset('assets/format_upload/upload_checkpoint.xlsx') }}" class="ml-2 btn btn-primary btn-sm"> <i class="fas fa-download"></i> Download Format Upload</a>
                <div class="card mt-2">
                    <div class="card-body">
                        <form method="post" action="upload_data" onsubmit="return cekExe()" enctype="multipart/form-data">
                            @csrf
                            <div class="form group">
                                <label for="">Upload File</label>
                                <input onchange="return exe()" id="file" accept=".xlsx" type="file" name="file" class="form-control form-control-sm">
                                <span class="text-danger font-italic small">* hanya file dengan ekstensi xlsx yang boleh di upload *</span>
                            </div>

                            <div class="form-inline mt-2">
                                <input type="submit" value="Upload Crime" name="view" class="btn btn-danger btn-sm"></input>
                            </div>
                        </form>
                    </div>
                </div>
                @endif
                <!-- /.card -->
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="crime_data" class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Wilayah</th>
                                    <th>Kecamatan</th>
                                    <th>Kasus</th>
                                    <th>Kategori</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- <tr></tr> -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--  Payment Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl " role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="staticBackdropLabel">Detail</h5>
            </div>
            <form action="/isecurity_laravel/crime/update" enctype="multipart/form-data" method="post" class="needs-validation" novalidate>
                <div class="modal-body">
                    <input type="text" hidden name="idx" id="idx">
                    @csrf
                    <label for="">Tanggal</label>
                    <input type="text" class="form-control" name="tanggal" id="tanggal">

                    <label for="">Wilayah</label>
                    <input type="text" class="form-control" name="wilayah" id="wilayah">

                    <label for="">Kecamatan</label>
                    <input type="text" class="form-control" name="kecamatan" id="kecamatan">

                    <label for="">Kasus</label>
                    <input type="text" class="form-control" name="kasus" id="kasus">

                    <label for="">Kategori</label>
                    <input type="text" class="form-control" name="kategori" id="kategori">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- payment modal -->
<script>
    function cekExe() {
        var fi = document.getElementById('file');
        if (fi.value == '' || fi.value == null) {
            Swal.fire({
                title: 'Perhatian!',
                text: 'Pilih file yang akan di upload',
                icon: 'error',
            })
            return false;
        }
        return
    }

    function exe() {
        const file = document.getElementById('file');
        const path = file.value;
        const exe = /(\.xlsx)$/i;
        if (!exe.exec(path)) {
            Swal.fire({
                title: 'Perhatian!',
                text: 'File tidak diijinkan',
                icon: 'error',
            })
            // alert('File tidak diijinkan');
            file.value = "";
        }
    }

    let table = $('#crime_data').DataTable({
        paging: true,
        orderCellsTop: true,
        fixedHeader: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: false,
        autoWidth: false,
        responsive: true,
        // processing: true,
        serverSide: false,
        pageLength: 10,
        ajax: {
            url: "getList_crime",
            dataSrc: '',
        },
        columns: [{
            data: 'tanggal',
        }, {
            data: 'kota'
        }, {
            data: 'kec'
        }, {
            data: 'jenis_kasus'
        }, {
            data: 'kategori'
        }, {
            data: 'id',
            render: function(data, type, row) {

                <?php if (Session('role') === 'SUPERADMIN') { ?>
                    return `<a class="btn btn-sm btn-danger" onclick="return confirm('Yakin Hapus ?')" href='/crime/delete?id=${data}'><i class="fas fa-trash " ></i></a> 
                <a class="btn btn-sm btn-success" data-toggle="modal" data-target="#staticBackdrop" data-kecamatan=${row.kec} data-wilayah=${row.kota} data-kasus=${row.jenis_kasus} data-kategori=${row.kategori} data-tanggal=${row.tanggal} data-id="${ data }"><i class="fas fa-edit  waves-effect waves-light"></i></a>`;
                <?php } else { ?>
                    return `-`;
                <?php  } ?>
            }
        }],
    });

    $("#staticBackdrop").on("show.bs.modal", function(event) {
        var div = $(event.relatedTarget); // Tombol dimana modal di tampilkan
        var modal = $(this);
        // Isi nilai pada field
        modal.find("#idx").attr("value", div.data("id"));
        modal.find("#tanggal").attr("value", div.data("tanggal"));
        modal.find("#kecamatan").attr("value", div.data("kecamatan"));
        modal.find("#wilayah").attr("value", div.data("wilayah"));
        modal.find("#kasus").attr("value", div.data("kasus"));
        modal.find("#kategori").attr("value", div.data("kategori"));
    })
</script>

@endsection