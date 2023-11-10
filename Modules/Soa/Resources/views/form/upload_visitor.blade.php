@extends('soa::layouts.template')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">

            </div>
        </div>
    </div>
</section>


<section class="content">
    <div class="container-fluid">
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        @if ($message = Session::get('failed'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="row">

            <div class="col-lg-12">
                <form action="{{ route('egate.uploadedVisitor') }}" method="post" enctype="multipart/form-data">
                    <div class="card">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Upload File Visitor</label>
                                <input type="file" onchange="return cekFile()" class="form-control" id="file" name="file">
                                <span class="small font-italic"> <a class="text-danger" target="_blank" href="{{ asset('assets/upload_egate/FORMAT_UPLOAD_VISITOR.xlsx') }}">* download format upload visitor</a></span>
                            </div>
                            <button type="submit" class="btn btn-sm btn-info"> Upload File Visitor</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
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