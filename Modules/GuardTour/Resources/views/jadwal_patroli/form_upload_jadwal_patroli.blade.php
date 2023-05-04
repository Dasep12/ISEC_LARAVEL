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
                    <li class="breadcrumb-item"><a href="">Jadwal Patroli</a></li>
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
                @elseif ($message = Session::get('failed'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-close"></i>
                    {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Upload Jadwal Patroli</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">

                        <form method="post" enctype="multipart/form-data" action="{{ route('jadpatroli.upload') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for="">Plant</label>
                                    <select name="plant" id="plant" class="form-control">
                                        @foreach($plants as $p)
                                        <option value="{{ $p->plant_id }}">{{ $p->plant_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-4">
                                    <label for="">Bulan</label>
                                    <input type="text" value="<?= date('Y-m') ?>" class="form-control" name="date" id="date">
                                </div>


                                <div class="col-lg-4">
                                    <label for="">File</label>
                                    <input onchange="return cekFile()" type="file" class="form-control" name="file" id="file">
                                </div>

                                <div class="col-lg-6 mt-2">
                                    <a href="{{ route('jadpatroli.master') }}" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Upload Jadwal</button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</section>

<script>
    $("#date").datepicker({
        format: "yyyy-mm",
        startView: "months",
        minViewMode: "months",
        autoclose: true
    });

    function cekFile() {
        const file = document.getElementById('file');
        const path = file.value;
        const exe = /(\.xlsx)$/i;
        if (!exe.exec(path)) {
            alert('File tidak diijinkan');
            file.value = "";
        }
    }
</script>
@endsection