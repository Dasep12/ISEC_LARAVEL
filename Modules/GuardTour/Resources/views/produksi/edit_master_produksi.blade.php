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
                    <li class="breadcrumb-item"><a href="{{ route('produksi.master')}}">Master Produksi</a></li>
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
                        <h3 class="card-title">Edit Data</h3>

                        <div class="card-tools">

                        </div>
                    </div>
                    <form onsubmit="return cek()" action="{{ route('produksi.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="produksi_id" value="{{ $data->produksi_id }}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">NAMA</label>
                                        <input value="{{ $data->name }}" type="text" name="name" autocomplete="off" id="name" class="form-control">
                                    </div>

                                    <a href="{{ route('produksi.master') }}" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Simpan Data</button>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">STATUS</label>
                                        <select name="status" class="form-control">
                                            <option value="1">ACTIVE</option>
                                            <option value="0">INACTIVE</option>
                                        </select>
                                    </div>
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
        if (document.getElementById("kategori_id").value == "") {
            alert('pilih kategori');
            $("#kategori_id").addClass('is-invalid');
            return false
        } else if (document.getElementById("event_name").value == "") {
            alert('isi nama event');
            $("#event_name").addClass('is-invalid');
            return false
        }
        return;
    }
</script>
@endsection