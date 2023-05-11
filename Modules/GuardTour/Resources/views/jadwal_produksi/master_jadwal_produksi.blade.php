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
                    <li class="breadcrumb-item"><a href="">Jadwal Produksi</a></li>
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
                <!-- <a class="mb-2 btn btn-sm btn-success" href="{{ route('jadpatroli.form_edit_jadpatrol') }}"><i class="fa fa-file-excel"></i>
                    Koreksi Jadwal Produksi
                </a> -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Jadwal Produksi</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">

                        <form method="post" enctype="multipart/form-data" action="{{ route('jadproduksi.master') }}">
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
                                    <input type="text" value="<?= $date ?>" class="form-control" name="date" id="date">
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
                            <table class="table table-sm" style="width:30%">
                                <tr>
                                    <td>Plant</td>
                                    <td>:</td>
                                    <td>{{ $header[0]->plant }}</td>
                                </tr>
                                <tr>
                                    <td>Periode</td>
                                    <td>:</td>
                                    <td> <?= $month . ' ' . explode('-', $date)[0] ?></td>
                                </tr>
                            </table>
                            <table id="jadwal_patroli" class="table-wrapped table table-bordered small table-sm">
                                <thead>
                                    <tr>
                                        <th>ZONA</th>
                                        <th width="120px">SHIFT</th>
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
                                            <td style="z-index:2">{{ $d->zone }}</td>
                                            <td style="z-index:2">{{ $d->shift }}</td>
                                            <?php
                                            for ($j = 1; $j <= $day; $j++) {
                                                $produksi = \Modules\GuardTour\Entities\JadwalProduksi::jadwalProduksi($date . '-' . $j, $d->plant_id, $d->zona_id, $d->shift_id);
                                            ?>
                                                <td>
                                                    <label class="toggle">
                                                        <input id="{{ $produksi[0]->id }}" value="{{ $produksi[0]->status_zona }}" name="produksi_status" data-id="{{ $produksi[0]->id }}" {{ $produksi[0]->status_zona == 1 ? 'checked' : '' }} name="id_produksi" type="checkbox">
                                                        <span class="slider"></span>
                                                        <span class="labels" data-on="ON" data-off="OFF"></span>
                                                    </label>
                                                </td>
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

    $("input[name='produksi_status']").click(function(e) {
        var d = $(this).val();
        var status = $(this).is(':checked');
        var id = $(this).attr('id');
        var confirmBox = confirm(status == false ? "Yakin Matikan Zona ? " : 'Aktifkan Zona Kembali ?');
        if (confirmBox == true) {

            $.ajax({
                url: "{{ route('jadproduksi.updateProduksi') }}",
                method: "POST",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}",
                    status: status == true ? 1 : 0,
                },
                success: function(e) {
                    // console.log(e)
                    if (e == 1) {
                        if (status) {
                            document.getElementById(id).checked = true;
                            alert('Berhasil update');
                        } else {
                            document.getElementById(id).checked = false;
                            alert('Berhasil update');
                        }
                    } else {
                        alert('gagal');
                    }
                }
            })

        } else {

            document.getElementById(id).checked = !status;
        };
    })

    $(document).ready(function() {
        $('#jadwal_patroli').DataTable({
            fixedHeader: true,
            scrollX: "200px",
            scrollCollapse: true,
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
</script>
@endsection