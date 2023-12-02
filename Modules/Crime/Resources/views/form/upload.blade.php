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
                                    <th>Wilayah</th>
                                    <th>Kecamatan</th>
                                    <th>Kasus</th>
                                    <th>Kategori</th>
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
        processing: true,
        serverSide: false,
        pageLength: 10,
        ajax: {
            url: "getList_crime",
            dataSrc: '',
        },
        columns: [{
            data: 'kota'
        }, {
            data: 'kec'
        }, {
            data: 'jenis_kasus'
        }, {
            data: 'kategori'
        }, ],
    });
</script>

@endsection