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
                    <li class="breadcrumb-item"><a href="{{ route('event.master')}}">Master Event</a></li>
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
                    <form onsubmit="return cek()" action="{{ route('event.update') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" name="event_id" value="{{ $data->event_id }}" id="">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">KATEGORI OBJEK</label>
                                        <select class="form-control" name="kategori_id" id="kategori_id">
                                            <option value="">Pilih Kategori Objek</option>
                                            @foreach ($kategori as $kt)
                                            <option {{ $data->admisecsgp_mstkobj_kategori_id == $kt->kategori_id ? 'selected' : '' }} value="{{ $kt->kategori_id }}">{{ $kt->kategori_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="">NAMA EVENT</label>
                                        <input type="text" value="{{ $data->event_name }}" data-role='tags-input' name="event_name" autocomplete="off" id="event_name" value="" class="form-control">
                                    </div>


                                </div>
                                <div class="col-lg-6">

                                    <div class="form-group">
                                        <label for="">STATUS</label>
                                        <select name="status" class="form-control">
                                            <option value="1">ACTIVE</option>
                                            <option value="0">INACTIVE</option>
                                        </select>
                                    </div>
                                    <a href="{{ route('event.master') }}" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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