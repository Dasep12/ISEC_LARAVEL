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
                    <li class="breadcrumb-item"><a href="">Edit Data</a></li>
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
                            <!-- <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i>
                            </button> -->
                        </div>
                    </div>
                    <form onsubmit="return cek()" action="{{ route('company.update') }}" method="POST" id="inputCompany">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" name="comp_id" id="id" value="{{ $data->company_id }}">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">NAMA PERUSAHAAN</label>
                                        <input type="text" value="{{ strtoupper($data->comp_name) }}" name="comp_name" autocomplete="off" id="comp_name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="">TELEPON</label>
                                        <input type="text" value="{{ $data->comp_phone }}" name="comp_phone" autocomplete="off" id="comp_phone" class="form-control">
                                    </div>


                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">STATUS</label>
                                        <select name="status" class="form-control" id="">
                                            <option {{ $data->status==1 ? 'selected' : '' }} value="1">ACTIVE</option>
                                            <option value="0" {{ $data->status==0 ? 'selected' : '' }}>INACTIVE</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="">ALAMAT</label>
                                        <textarea name="address1" autocomplete="off" class="form-control" id="address1" cols="4" rows="2">{{ strtoupper($data->address1) }}</textarea>
                                    </div>

                                    <a href="{{ route('company.master') }}" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
        if (document.getElementById("comp_name").value == "") {
            alert('Nama Perusahaan Tidak Boleh Kosong');
            $("#comp_name").addClass('is-invalid');
            return false
        } else if (document.getElementById("comp_phone").value == "") {
            alert('Isi No Telepon Perusahaan');
            $("#comp_phone").addClass('is-invalid');
            return false
        } else if (document.getElementById("address1").value == "") {
            alert('Isi Alamat Perusahaan');
            $("#address1").addClass('is-invalid');
            return false
        }
        return;
    }
</script>
@endsection