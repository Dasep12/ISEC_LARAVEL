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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Jadwal Patroli</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">

                        <form method="post" enctype="multipart/form-data" action="{{ route('jadpatroli.form_edit_jadpatrol') }}">
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
                                    <input type="text" value="{{ $date }}" class="form-control" name="date" id="date">
                                </div>

                                <div class="col-lg-6 mt-2">
                                    <a href="{{ route('jadpatroli.master') }}" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                    <button type="submit" name="submit" class="btn btn-sm btn-primary"><i class="fas fa-search"></i> Cari Jadwal</button>
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
                            <table id="jadwal_patroli" class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th width="90px">PLANT</th>
                                        <th>NPK</th>
                                        <th>NAMA</th>
                                        <th>TANGGAL</th>
                                        <th>SHIFT</th>
                                        <th>UBAH</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $d)
                                    <?php
                                    $date_sistem = $d->date_patroli;
                                    $today       = date('Y-m-d H:i:s');

                                    $tanggal_terpilih = strtotime($date_sistem . "23:59:59");
                                    $tanggal_sekarang = strtotime($today);

                                    ?>
                                    <tr>
                                        <td>{{ $d->plant_name }}</td>
                                        <td>{{ $d->npk }}</td>
                                        <td>{{ $d->name }}</td>
                                        <td>{{ $d->date_patroli }}</td>
                                        <td>{{ $d->nama_shift }}</td>
                                        <td>
                                            <?php
                                            if ($tanggal_terpilih >= $tanggal_sekarang) { ?>
                                                <a href="#" data-toggle="modal" data-target="#edit-data" class=" ml-2 text-primary" title="lihat data" data-backdrop="static" data-keyboard="false" data-nama="{{ $d->name }}" data-npk="{{ $d->npk }}" data-date="{{ $d->date_patroli }}" data-id="{{ $d->id }}" data-shiftid="{{ $d->shift_id }}"><i class="fas fa-edit"></i></a>
                                            <?php } else { ?>
                                                <span class="font-italic text-danger">exp-date</span>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="edit-data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="card-body">
                        <form action="#" method="post" id="formUpdate">
                            <div class="form-group">
                                <input type="hidden" name="idjadwal" id="idjadwal">
                                <label for="">NAMA</label>
                                <input type="text" readonly autocomplete="off" id="nama" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">NPK</label>
                                <input type="text" readonly autocomplete="off" id="npk" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">TANGGAL</label>
                                <input type="text" readonly autocomplete="off" id="date" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">SHIFT</label>
                                <select class="form-control" name="shift_id" id="shift_id">
                                </select>
                            </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm" id="btnUpdate">Update</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                </div>
                </form>

            </div>
        </div>
    </div>
    <!-- edit data zona -->
</div>
<script>
    $("#date").datepicker({
        format: "yyyy-mm-dd",
        // startView: "months",
        // minViewMode: "months",
        autoclose: true
    });

    $("#edit-data").on("show.bs.modal", function(event) {
        var div = $(event.relatedTarget); // Tombol dimana modal di tampilkan
        var modal = $(this);
        // Isi nilai pada field
        modal.find("#nama").attr("value", div.data("nama"));
        modal.find("#npk").attr("value", div.data("npk"));
        modal.find("#date").attr("value", div.data("date"));
        modal.find("#idjadwal").attr("value", div.data("id"));

        var select1 = $('#shift_id');
        select1.empty();
        var added2 = document.createElement('option');
        var result = <?= json_encode($shift) ?>;
        for (var i = 0; i < result.length; i++) {
            var added = document.createElement('option');
            added.value = result[i].shift_id;
            added.innerHTML = result[i].nama_shift;
            $("select[name=shift_id] option[value=" + div.data("shiftid") + "]").prop("selected", true);
            select1.append(added);
        }
    });

    $("#btnUpdate").on('click', function(e) {
        e.preventDefault();
        var shift = $("#shift_id").val();
        var id = $("#idjadwal").val();
        $.ajax({
            url: "{{ route('jadpatroli.updateJadwal') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                shift: shift,
                id: id
            },
            success: function(e) {
                if (e == 0) {
                    alert('Gagal update Data');
                    location.reload();
                } else {
                    alert('Berhasil rubah shift petugas');
                    location.reload();
                }
            }
        })
    })

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