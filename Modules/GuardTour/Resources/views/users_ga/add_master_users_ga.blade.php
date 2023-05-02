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
                    <li class="breadcrumb-item"><a href="{{ route('users.master')}}">Master Users</a></li>
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
                        </div>
                    </div>
                    <form onsubmit="return cek()" action="{{ route('users_ga.insert') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">PLANT</label>
                                        <select class="form-control" name="plant_id" id="plant_id" required>
                                            <option selected value="">Pilih Plant</option>
                                            @foreach ($plants as $plant)
                                            <option value="{{ $plant->plant_id }}">{{ $plant->plant_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">NAMA</label>
                                        <input type="text" name="nama" autocomplete="off" id="nama" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">EMAIL</label>
                                        <input type="text" name="email" autocomplete="off" id="email" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">

                                    <div class="form-group">
                                        <label for="">TYPE</label>
                                        <select name="type" class="form-control" id="" required>
                                            <option value="1">GA</option>
                                            <option value="0">CC</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">STATUS</label>
                                        <select name="status" class="form-control" id="" required>
                                            <option value="1">ACTIVE</option>
                                            <option value="0">INACTIVE</option>
                                        </select>
                                    </div>

                                    <a href="{{ route('users_ga.master') }}" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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

    function getPlant(id) {
        $.ajax({
            url: "{{ route('users_ga.getPlant') }}",
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
                const data = e.plant;
                var select1 = $('#plant_id');
                select1.empty();
                var added2 = document.createElement('option');
                added2.value = "";
                added2.innerHTML = "Pilih Plant";
                select1.append(added2);
                for (var i = 0; i < data.length; i++) {
                    var added = document.createElement('option');
                    added.value = data[i].plant_id;
                    added.innerHTML = data[i].plant_name;
                    select1.append(added);
                }
            }
        })
    }

    $(function() {
        $('select[name=site_id').on('change', function() {
            var id = $("select[name=site_id] option:selected").val();
            getPlant(id)
        });
    })
</script>
@endsection