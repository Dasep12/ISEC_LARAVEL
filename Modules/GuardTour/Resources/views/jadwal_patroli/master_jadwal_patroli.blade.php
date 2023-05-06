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
                    <li class="breadcrumb-item"><a href="">Jadwal Patroli</a></li>
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
                    <i class="fas fa-check"></i>
                    {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @elseif ($message = Session::get('failed'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-close"></i>
                    {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <a class="mb-2 btn btn-sm btn-success" href="{{ route('jadpatroli.form_edit_jadpatrol') }}"><i class="fa fa-file-excel"></i>
                    Koreksi Jadwal Patroli
                </a>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Jadwal Patroli</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">

                        <form method="post" enctype="multipart/form-data" action="{{ route('jadpatroli.master') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for="">Plant</label>
                                    <select name="plant" id="plant" class="form-control">
                                        @foreach($plants as $p)
                                        <option {{ $p->plant_id  == $plant_id ? 'selected' : '' }} value="{{ $p->plant_id }}">{{ $p->plant_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-4">
                                    <label for="">Bulan</label>
                                    <input type="text" value="<?= date('Y-m') ?>" class="form-control" name="date" id="date">
                                </div>


                                <div class="col-lg-6 mt-2">
                                    <button type="submit" name="submit" class="btn btn-sm btn-primary"><i class="fas fa-search"></i> Lihat Jadwal</button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <?php

                if (isset($_POST['submit'])) { ?>
                    <div class="card">
                        <div class="card-body">
                            <table id="jadwal_patroli" class="table table-bordered small table-sm">
                                <thead>
                                    <tr>
                                        <th width="90px">PLANT</th>
                                        <th>NPK</th>
                                        <th width="120px">NAMA</th>
                                        <?php

                                        $kal = CAL_GREGORIAN;
                                        $day = cal_days_in_month($kal, explode('-', $date)[1], date('Y'));
                                        for ($i = 1; $i <= $day; $i++) {  ?>
                                            <th><?= $i ?></th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($header as $d) { ?>
                                        <tr>
                                            <td>{{ $d->plant_name}}</td>
                                            <td>{{ $d->npk }}</td>
                                            <td>{{ $d->name }}</td>
                                            <?php
                                            for ($j = 1; $j <= $day; $j++) {
                                                $shift = \Modules\GuardTour\Entities\JadwalPatroli::shiftPatroli($date . '-' . $j, $d->npk); ?>
                                                <td><span class="{{ $shift->shift == 'LIBUR' ? 'text-danger' : '' }}"><?= $shift->shift ?></span></td>
                                            <?php } ?>
                                        </tr>
                                    <?php  } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<script>
    $("#date").datepicker({
        format: "yyyy-mm",
        startView: "months",
        minViewMode: "months",
        autoclose: true
    });
    $(document).ready(function() {
        $('#jadwal_patroli').DataTable({
            fixedHeader: true,
            scrollX: "200px",
            scrollCollapse: false,
            paging: false,
            ordering: false,
            searching: false,
            info: false,
            fixedColumns: {
                left: 3,
                right: 2
            }
        });
    });

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