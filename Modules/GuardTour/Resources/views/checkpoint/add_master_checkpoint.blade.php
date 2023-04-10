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
                    <li class="breadcrumb-item"><a href="{{ route('checkpoint.master')}}">Master Checkpoint</a></li>
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
                    <form onsubmit="return cek()" action="{{ route('checkpoint.insert') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">PLANT</label>
                                        <select class="form-control" name="plant_id" id="plant_id">
                                            <option selected value="">Pilih Plant</option>
                                            @foreach($plants as $p)
                                            <option value="{{ $p->plant_id }}">{{ $p->plant_name }}</option>
                                            @endforeach
                                        </select>
                                        <span id="info" style="display: none;" class="text-danger font-italic small">load data zone . . .</span>
                                    </div>
                                    <div class="form-group" id="list_zona">
                                        <label for="">ZONA</label>
                                        <select class="form-control" name="zone_id" id="zone_id">
                                            <option selected value="">Pilih Zona</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="">ID CHECKPOINT</label>
                                        <input type="text" name="check_no" autocomplete="off" id="check_no" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="">NAMA CHECKPOINT</label>
                                        <input type="text" name="check_name" autocomplete="off" id="check_name" class="form-control">
                                    </div>

                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">DURASI BATAS BAWAH</label>
                                        <input type="number" name="durasi_batas_bawah" autocomplete="off" id="durasi" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="">DURASI BATAS ATAS</label>
                                        <input type="number" name="durasi_batas_atas" autocomplete="off" id="durasi2" class="form-control">
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

                                    <a href="{{ route('checkpoint.master') }}" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
        } else if (document.getElementById("check_name").value == "") {
            alert('masukan nama check');
            $("#check_name").addClass('is-invalid');
            return false
        } else if (document.getElementById("check_no").value == "") {
            alert('masukan kode nfc');
            $("#check_no").addClass('is-invalid');
            return false
        }
        return;
    }

    function getZona(id) {
        $.ajax({
            url: "{{ route('checkpoint.getZona') }}",
            method: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            beforeSend: function() {
                document.getElementById('info').style.display = "block"
            },
            complete: function() {
                document.getElementById('info').style.display = "none"
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

    $(function() {
        $('select[name=plant_id').on('change', function() {
            var id = $("select[name=plant_id] option:selected").val();
            getZona(id)
        });
    })
</script>
@endsection