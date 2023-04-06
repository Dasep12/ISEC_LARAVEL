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
                    <li class="breadcrumb-item"><a href="{{ route('company.master')}}">Master Company</a></li>
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
                    <form onsubmit="return cek()" action="{{ route('plant.insert') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">PERUSAHAAN</label>
                                        <select class="form-control" name="comp_id" id="comp_id">
                                            <option value="">Pilih Perusahaan</option>
                                            @foreach($company as $c)
                                            <option value="{{ $c->company_id }}">{{ $c->comp_name }}</option>
                                            @endforeach
                                        </select>
                                        <span id="info" style="display: none;" class="text-danger font-italic small">load data wilayah . . .</span>
                                    </div>
                                    <div class="form-group" id="list_wilayah">
                                        <label for="">WILAYAH</label>
                                        <select class="form-control" name="site_id" id="site_id">
                                            <option selected value="">Pilih Wilayah</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">NAMA PLANT</label>
                                        <input type="text" name="plant_name" autocomplete="off" id="plant_name" class="form-control">
                                    </div>

                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">KODE PLANT</label>
                                        <input type="text" name="kodeplant" autocomplete="off" id="kodeplant" class="form-control">
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

                                    <a href="{{ route('plant.master') }}" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
        if (document.getElementById("comp_id").value == "") {
            alert('pilih perusahaan');
            $("#comp_id").addClass('is-invalid');
            return false
        } else if (document.getElementById("site_id").value == "") {
            alert('pilih wilayah');
            $("#site_id").addClass('is-invalid');
            return false
        } else if (document.getElementById("plant_name").value == "") {
            alert('masukan nama plant');
            $("#plant_name").addClass('is-invalid');
            return false
        } else if (document.getElementById("kodeplant").value == "") {
            alert('masukan kode plant');
            $("#kodeplant").addClass('is-invalid');
            return false
        }
        return;
    }
    $(function() {
        $('select[name=comp_id').on('change', function() {
            var id = $("select[name=comp_id] option:selected").val();
            $.ajax({
                url: "{{ route('plant.getWilayah') }}",
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
                    const data = e.wilayah;
                    var select1 = $('#site_id');
                    select1.empty();
                    var added2 = document.createElement('option');
                    added2.value = "";
                    added2.innerHTML = "Pilih Wilayah";
                    select1.append(added2);
                    for (var i = 0; i < data.length; i++) {
                        var added = document.createElement('option');
                        added.value = data[i].site_id;
                        added.innerHTML = data[i].site_name;
                        select1.append(added);
                    }
                }
            })
        });
    })
</script>
@endsection