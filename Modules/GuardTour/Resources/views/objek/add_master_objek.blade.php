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
                    <li class="breadcrumb-item"><a href="{{ route('objek.master')}}">Master Objek</a></li>
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
                    <form onsubmit="return cek()" action="{{ route('objek.insert') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">PLANT</label>
                                        <select class="form-control" name="plant_id" id="plant_id">
                                            <option selected value="">Pilih Plant</option>
                                            @foreach($plant as $p)
                                            <option value="{{ $p->plant_id }}">{{ $p->plant_name }}</option>
                                            @endforeach
                                        </select>
                                        <span id="info_zona" style="display: none;" class="text-danger font-italic small">load data zona . . .</span>
                                    </div>

                                    <div class="form-group ">
                                        <label for="">ZONA</label>
                                        <select class="form-control" name="zone_id" id="zone_id">
                                            <option value="">Pilih Zona</option>
                                        </select>
                                        <span id="info_checkpoint" style="display: none;" class="text-danger font-italic small">load data kategori objek . . .</span>
                                    </div>

                                    <div class="form-group mt-2 ">
                                        <label for="">CHECKPOINT</label>
                                        <select class="form-control" name="check_id" id="check_id">
                                            <option value="">Pilih Checkpoint</option>
                                        </select>
                                    </div>

                                    <div class="form-group mt-2 ">
                                        <label for="">KATEGORI OBJEK</label>
                                        <select class="form-control" name="kategori_id" id="kategori_id">
                                            <option value="">Pilih Kategori Objek</option>
                                            @foreach($kategori as $k)
                                            <option value="{{ $k->kategori_id }}">{{ $k->kategori_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="col-lg-6">



                                    <div class="form-group">
                                        <label for="">NAMA OBJEK</label>
                                        <input type="text" name="nama_objek" autocomplete="off" id="nama_objek" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="">STATUS</label>
                                        <select name="status" class="form-control" id="">
                                            <option value="1">ACTIVE</option>
                                            <option value="0">INACTIVE</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="">KETERANGAN</label>
                                        <textarea name="others" class="form-control" id="others"></textarea>
                                    </div>
                                    <a href="{{ route('objek.master') }}" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
        if (document.getElementById("plant_id").value == "") {
            alert('pilih wilayah');
            $("#plant_id").addClass('is-invalid');
            return false
        } else if (document.getElementById("zone_id").value == "") {
            alert('pilih zone');
            $("#zone_id").addClass('is-invalid');
            return false
        } else if (document.getElementById("check_id").value == "") {
            alert('masukan nama checkpoint');
            $("#check_id").addClass('is-invalid');
            return false
        } else if (document.getElementById("kategori_id").value == "") {
            alert('masukan kategori objek');
            $("#kategori_id").addClass('is-invalid');
            return false
        } else if (document.getElementById("nama_objek").value == "") {
            alert('masukan nama objek');
            $("#nama_objek").addClass('is-invalid');
            return false
        }
        return;
    }

    function getZona(id) {
        $.ajax({
            url: "{{ route('objek.getZona') }}",
            method: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            beforeSend: function() {
                document.getElementById('info_zona').style.display = "block"
            },
            complete: function() {
                document.getElementById('info_zona').style.display = "none"
            },
            success: function(e) {
                const data = e.zona;
                var select1 = $('#zone_id');
                select1.empty();
                var added2 = document.createElement('option');
                added2.value = "";
                added2.innerHTML = "Pilih Zona";
                select1.append(added2);
                for (var i = 0; i < data.length; i++) {
                    var added = document.createElement('option');
                    added.value = data[i].zone_id;
                    added.innerHTML = data[i].zone_name;
                    select1.append(added);
                }
            }
        })
    }

    function getCheckpoint(id) {
        $.ajax({
            url: "{{ route('objek.getCheckpoint') }}",
            method: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            beforeSend: function() {
                document.getElementById('info_checkpoint').style.display = "block"
            },
            complete: function() {
                document.getElementById('info_checkpoint').style.display = "none"
            },
            success: function(e) {
                const data = e.check;
                var select1 = $('#check_id');
                select1.empty();
                var added2 = document.createElement('option');
                added2.value = "";
                added2.innerHTML = "Pilih Checkpoint";
                select1.append(added2);
                for (var i = 0; i < data.length; i++) {
                    var added = document.createElement('option');
                    added.value = data[i].checkpoint_id;
                    added.innerHTML = data[i].check_name;
                    select1.append(added);
                }
            }
        })
    }

    $(function() {
        $('select[name=plant_id').on('change', function() {
            var id = $("select[name=plant_id] option:selected").val();
            getZona(id)
        });

        $('select[name=zone_id').on('change', function() {
            var id = $("select[name=zone_id] option:selected").val();
            getCheckpoint(id)
        });
    })
</script>
@endsection