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
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Upload File</label>
                            <input type="file" class="form-control" id="file" name="file">
                        </div>
                        <button class="btn btn-sm btn-info">Upload File</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>

</script>
@endsection