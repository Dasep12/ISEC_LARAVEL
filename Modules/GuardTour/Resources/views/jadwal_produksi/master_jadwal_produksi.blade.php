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
                                    <input type="hidden" value="<?= $date ?>" id="hidden_input" name="date">
                                    <select name="plant" id="plant" class="form-control">
                                        @foreach($plants as $p)
                                        <option {{ $p->plant_id  == $plant_id ? 'selected' : '' }} value="{{ $p->plant_id }}">{{ $p->plant_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-4">
                                    <label for="">Bulan</label>
                                    <input type="text" value="<?= $date2 ?>" class="form-control" name="date_var" id="date">
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

                    @if(count($header) > 0)
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
                                    <td> <?= $date2 ?></td>
                                </tr>
                            </table>
                            <table id="jadwal_patroli" class="table-wrapped table table-bordered small table-sm">
                                <thead>
                                    <tr>
                                        <th>ZONA</th>
                                        <th>SHIFT</th>
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
                                            $days = cal_days_in_month($kal, explode('-', $date)[1], date('Y'));
                                            for ($j = 1; $j <= $days; $j++) {
                                                $produksi = \Modules\GuardTour\Entities\JadwalProduksi::jadwalProduksi($date . '-' . $j, $d->plant_id, $d->zona_id, $d->shift_id);

                                                $date_sistem = $date . '-' . $j;
                                                $today       = date('Y-m-d H:i:s');

                                                $tanggal_terpilih = strtotime($date_sistem . "23:59:59");
                                                $tanggal_sekarang = strtotime($today);
                                            ?>
                                                <td>
                                                    <label class="toggle">
                                                        <input <?= $tanggal_terpilih > $tanggal_sekarang ? '' : 'disabled' ?> id="{{ $produksi[0]->id }}" value="{{ $produksi[0]->status_zona }}" name="produksi_status" data-id="{{ $produksi[0]->id }}" {{ $produksi[0]->status_zona == 1 ? 'checked' : '' }} name="id_produksi" type="checkbox">
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
                    @else
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-close"></i>
                        Jadwal Tidak Tersedia
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<script>
    $("#date").datepicker({
        format: "MM, yyyy",
        startView: "months",
        minViewMode: "months",
        autoclose: true,
    }).on('changeDate', function(ev) {
        $("#hidden_input").val(ev.format('yyyy-mm'));
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