@extends('template.template_first')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Company</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Setting</a></li>
                    <li class="breadcrumb-item"><a href="#">Pengguna</a></li>
                    <li class="breadcrumb-item"><a href="">Register</a></li>
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
                    {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @elseif ($message = Session::get('failed'))
                <div class="alert text-white  bg-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-check"></i>
                    {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-white">Register User</h3>

                        <div class="card-tools">
                        </div>
                    </div>
                    <form onsubmit="return cek()" action="/Setting/Pengguna/input" method="post" id="inputPlant">
                        @csrf
                        <div class="card-body">
                            <div class="row">

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="">WILAYAH</label>
                                        <select class="form-control" name="site_id" id="site_id">
                                            <option selected value="">Pilih Wilayah</option>
                                            <?php foreach ($wilayah as $cmp) : ?>
                                                <option value="<?= $cmp->site_id ?>"><?= $cmp->site_name ?></option>
                                            <?php endforeach ?>
                                        </select>
                                        <span id="info" style="display: none;" class="text-danger font-italic small">load data plant . . .</span>
                                    </div>

                                    <div id="list_plant">
                                        <div class="form-group">
                                            <label for="">PLANT</label>
                                            <select name="plant_id" id="plant_id" class="form-control">
                                                <option value="">Pilih Plant</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="">LEVEL</label>
                                        <select name="level" class="form-control" id="">
                                            <?php foreach ($role  as $rl) : ?>
                                                <option value="<?= $rl->role_id ?>"><?= $rl->level ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="">GROUP PATROLI</label>
                                        <select name="group" class="form-control" id="">
                                            <option value="">NON GROUP</option>
                                            <?php foreach ($groups as $group) : ?>
                                                <option value="<?= $group ?>"><?= $group ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>


                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="">NPK</label>
                                        <input type="text" name="npk" value="{{ old('npk')}}" autocomplete="off" id="npk" class="form-control">
                                        @error('npk')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">NAMA LENGKAP</label>
                                        <input type="text" name="nama" value="{{ old('nama')}}" autocomplete="off" id="nama" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="">USERNAME</label>
                                        <input type="text" name="user_name" value="{{ old('user_name')}}" autocomplete="off" id="user_name" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="">PASSWORD</label>
                                        <input type="password" name="password" autocomplete="off" id="password" class="form-control">
                                    </div>

                                </div>
                                <div class="col-lg-4">

                                    <div class="form-group">
                                        <label for="email">EMAIL</label>
                                        <input type="text" value="{{ old('email')}}" name="email" autocomplete="off" id="email" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="">STATUS</label>
                                        <select name="status" class="form-control" id="">
                                            <option value="1">ACTIVE</option>
                                            <option value="0">INACTIVE</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12  justify-content-center">
                                    <a href="/Setting/Pengguna/list_user" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                    <button type="submit" class="ml-1 btn btn-sm btn-primary"><i class="fas fa-save"></i> Simpan Data</button>
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
        if (document.getElementById("site_id").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'pilih wilayah',
                icon: 'error',
            }).then((result) => {})

            return false
        } else if (document.getElementById("plant_id").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'plant harus di pilih',
                icon: 'error',
            }).then((result) => {})
            // alert("nama plant harus di isi");
            // $("#plant_name").focus();
            return false
        } else if (document.getElementById("npk").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'npk user harus di isi',
                icon: 'error',
            }).then((result) => {})
            // alert("nama plant harus di isi");
            // $("#plant_name").focus();
            return false
        } else if (document.getElementById("nama").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'nama user harus di isi',
                icon: 'error',
            });
            return false
        } else if (document.getElementById("password").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'password harus di isi',
                icon: 'error',
            })
            return false
        }
        return;
    }

    $("select[name=site_id").on('change', function() {
        var id = $("select[name=site_id] option:selected").val();
        if (id == null || id == "") {
            document.getElementById('list_plant').innerHTML = "";
        } else {
            $.ajax({
                url: "/Setting/Pengguna/getPlants",
                method: "POST",
                data: {
                    "site_id": id,
                    "_token": "{{ csrf_token() }}",
                },
                beforeSend: function() {
                    document.getElementById('info').style.display = "block"
                },
                complete: function() {
                    document.getElementById('info').style.display = "none"
                },
                success: function(e) {
                    // document.getElementById('list_plant').innerHTML = e;
                    var select1 = $('#plant_id');
                    select1.empty();
                    var added2 = document.createElement('option');
                    added2.value = "";
                    added2.innerHTML = "Pilih Plant";
                    select1.append(added2);
                    var result = e;
                    for (var i = 0; i < result.length; i++) {
                        var added = document.createElement('option');
                        added.value = result[i].plant_id;
                        added.innerHTML = result[i].plant_name;
                        select1.append(added);
                    }
                }
            })
        }
    });
</script>
@endsection