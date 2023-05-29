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
                    <li class="breadcrumb-item"><a href="{{ route('shift.master')}}">Master Shift</a></li>
                    <li class="breadcrumb-item"><a href="">Tambah Data</a></li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Data</h3>

                        <div class="card-tools">
                            <!-- <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i>
                            </button> -->
                        </div>
                    </div>
                    <form onsubmit="return cek()" action="{{ route('shift.insert') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">NAMA SHIFT</label>
                                        <input type="text" name="shift" autocomplete="off" id="shift" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="">JAM MASUK</label>
                                        <input type="text" name="jam_masuk" autocomplete="off" id="jam_masuk" class="form-control">
                                    </div>

                                </div>
                                <div class="col-lg-6">

                                    <div class="form-group">
                                        <label for="">JAM PULANG</label>
                                        <input type="text" name="jam_pulang" autocomplete="off" id="jam_pulang" class="form-control">
                                    </div>


                                    <div class="form-group">
                                        <label for="">STATUS</label>
                                        <select name="status" class="form-control">
                                            <option value="1">ACTIVE</option>
                                            <option value="0">INACTIVE</option>
                                        </select>
                                    </div>
                                    <a href="{{ route('shift.master') }}" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Simpan Data</button>
                                </div>


                            </div>

                        </div>
                        <!-- /.card-body -->
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</section>

<script>
    function cek() {
        if (document.getElementById("shift").value == "") {
            alert('pilih nama shift');
            $("#shift").addClass('is-invalid');
            return false
        } else if (document.getElementById("jam_masuk").value == "") {
            alert('isi jam masuk');
            $("#jam_masuk").addClass('is-invalid');
            return false
        } else if (document.getElementById("jam_pulang").value == "") {
            alert('isi jam pulang');
            $("#jam_pulang").addClass('is-invalid');
            return false
        }
        return;
    }

    $('#jam_masuk').timepicker({
        uiLibrary: 'bootstrap4'
    });
    $('#jam_pulang').timepicker({
        uiLibrary: 'bootstrap4'
    });
</script>
@endsection