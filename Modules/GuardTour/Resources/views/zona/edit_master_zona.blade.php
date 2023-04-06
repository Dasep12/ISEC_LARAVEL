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
                    <li class="breadcrumb-item"><a href="{{ route('zona.master')}}">Master Zona</a></li>
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
                    <form onsubmit="return cek()" action="{{ route('zona.update') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" name="zone_id" value="{{ $data->zone_id }}" id="">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">WILAYAH</label>
                                        <select class="form-control" name="site_id" id="site_id">
                                            <option selected value="">Pilih Wilayah</option>
                                            @foreach($site as $s)
                                            <option {{ $data->plantDetails->admisecsgp_mstsite_site_id == $s->site_id ? 'selected' : '' }} value="{{ $s->site_id }}">{{ $s->site_name }}</option>
                                            @endforeach
                                        </select>
                                        <span id="info" style="display: none;" class="text-danger font-italic small">load data plant . . .</span>
                                    </div>
                                    <div class="form-group" id="list_wilayah">
                                        <label for="">PLANT</label>
                                        <select class="form-control" name="plant_id" id="plant_id">
                                            <option selected value="">Pilih plant</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="">NAMA ZONA</label>
                                        <input type="text" value="{{ $data->zone_name }}" name="zone_name" autocomplete="off" id="zone_name" class="form-control">
                                    </div>


                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">KODE ZONA</label>
                                        <input type="text" value="{{ $data->kode_zona }}" name="kode_zona" autocomplete="off" id="kode_zona" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="">STATUS</label>
                                        <select name="status" class="form-control" id="">
                                            <option {{ $data->status == 1 ? 'selected' : '' }} value="1">ACTIVE</option>
                                            <option {{ $data->status == 0 ? 'selected' : '' }} value="0">INACTIVE</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="">KETERANGAN</label>
                                        <textarea name="others" class="form-control" id="others">{{ $data->others }}</textarea>
                                    </div>

                                    <a href="{{ route('zona.master') }}" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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

    function getPlant(id) {
        $.ajax({
            url: "{{ route('zona.getPlant') }}",
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
                    var plant_id_ = "{{ $data->admisecsgp_mstplant_plant_id }}";
                    $("select option[value='" + plant_id_ + "']").attr('selected', 'selected');
                }
            }
        })
    }

    getPlant('{{ $data->plantDetails->admisecsgp_mstsite_site_id }}')

    $(function() {
        $('select[name=site_id').on('change', function() {
            var id = $("select[name=site_id] option:selected").val();
            getPlant(id)
        });
    })
</script>
@endsection