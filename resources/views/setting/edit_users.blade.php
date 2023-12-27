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
                        <h3 class="card-title text-white">Edit Data</h3>
                        <div class="card-tools">
                        </div>
                    </div>
                    <form onsubmit="return cek()" action="/setting/update" method="POST">
                        @csrf
                        <input type="text" hidden value="{{ $data->npk }}" name="npk" autocomplete="off" id="npk" class="form-control">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="">WILAYAH</label>
                                        <select class="form-control" name="site_id" id="site_id">
                                            <option selected value="">Pilih Wilayah</option>
                                            @foreach ($site as $cmp)
                                            <option {{ $data->admisecsgp_mstsite_site_id == $cmp->site_id ? 'selected' : '' }} value="{{ $cmp->site_id }} ">{{ $cmp->site_name }}</option>
                                            @endforeach
                                        </select>
                                        <span id="info" style="display: none;" class="text-danger font-italic small">load data plant . . .</span>
                                    </div>


                                    <div class="form-group">
                                        <label for="">NPK</label>
                                        <input type="text" disabled value="{{ $data->npk }}" autocomplete="off" id="npk" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="">GROUP PATROLI</label>
                                        <select name="group" class="form-control" id="">
                                            <option {{ $data->patrol_group == 'REGU_A' ? 'selected' : '' }}>REGU_A</option>
                                            <option {{ $data->patrol_group == 'REGU_B' ? 'selected' : '' }}>REGU_B</option>
                                            <option {{ $data->patrol_group == 'REGU_C' ? 'selected' : '' }}>REGU_C</option>
                                            <option {{ $data->patrol_group == 'REGU_D' ? 'selected' : '' }}>REGU_D</option>
                                            <option {{ $data->patrol_group == '' ? 'selected' : '' }} value="">NON GROUP</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">PASSWORD</label>
                                        <input type="password" name="password" autocomplete="off" id="password" class="form-control">
                                    </div>

                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group" id="list_plant">
                                        <label for="">PLANT</label>
                                        <select class="form-control" name="plant_id" id="plant_id">
                                            <option selected value="">Pilih Plant</option>
                                            @foreach ($plant as $cmp)
                                            <option {{ $data->admisecsgp_mstplant_plant_id == $cmp->plant_id ? 'selected' : '' }} value="{{ $cmp->plant_id }} ">{{ $cmp->plant_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="">NAMA LENGKAP</label>
                                        <input type="text" value="{{ $data->name }}" name="nama" autocomplete="off" id="nama" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="email">EMAIL</label>
                                        <input type="text" value="{{ $data->email }}" name="email" autocomplete="off" id="email" class="form-control">
                                    </div>

                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="">LEVEL</label>
                                        <select name="level" class="form-control" id="">
                                            @foreach ($role as $rl)
                                            <option {{ $data->admisecsgp_mstroleusr_role_id == $rl->role_id ? 'selected' : '' }} value="<?= $rl->role_id ?>"><?= $rl->level ?></option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="">USERNAME</label>
                                        <input type="text" value="{{ $data->user_name }}" name="user_name" autocomplete="off" id="user_name" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="">STATUS</label>
                                        <select name="status" class="form-control" id="">
                                            <option {{ $data->status == 1 ? 'selected' : '' }} value="1">ACTIVE</option>
                                            <option {{ $data->status == 0 ? 'selected' : '' }} value="0">INACTIVE</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <a href="/setting/users" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
            url: "{{ route('users.getPlant') }}",
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