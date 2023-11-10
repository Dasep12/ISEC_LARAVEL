@extends('crime::layouts.master')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<style type="text/css">
    #preloader2 {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background-color: #fff;
        opacity: 0.9;
        display: none;
    }

    #preloader2 .loading {
        position: absolute;
        /* left: 40%; */
        /* top: 50%; */
        /* transform: translate(-50%, -50%); */
        font: 14px arial;
    }

    .pin2 {
        position: absolute;
        top: 40%;
        left: 50%;
        margin-left: 115px;
        border-radius: 50%;
        border: 8px solid #000;
        width: 8px;
        height: 8px;
    }

    .pin2::after {
        position: absolute;
        content: '';
        width: 0px;
        height: 0px;
        bottom: -30px;
        left: -6px;
        border: 10px solid transparent;
        border-top: 17px solid #000;
    }

    .info {
        padding: 6px 8px;
        font: 14px/16px Arial, Helvetica, sans-serif;
        background: white;
        background: rgba(255, 255, 255, 0.8);
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        border-radius: 5px;
    }

    .info1 {
        padding: 6px 8px;
        font: 14px/16px Arial, Helvetica, sans-serif;
        background: white;
        background: rgba(255, 255, 255, 0.8);
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        border-radius: 5px;
    }

    /* .leaflet-right .leaflet-control {
        margin-right: 340px !important;
    } */

    .info h4,
    .info1 h4 {
        margin: 0 0 5px;
        color: #777;
    }

    .legend {
        text-align: left;
        line-height: 18px;
        color: #555;
    }

    .legend i {
        width: 18px;
        height: 18px;
        float: left;
        margin-right: 8px;
        opacity: 0.7;
    }

    .labels {
        color: #FFF;
    }

    .leaflet-control-attribution a {
        display: none !important;
    }
</style>

<section class="content-header">
    <div class="container-fluid">

    </div>
</section>
<div id="preloader2">
    <div class="loading">
    </div>
</div>

<section class="content" style="margin-top:-60px">
    <div class="container-fluid">

        <div class="row  mt-5 md-2">
            <div class="col-lg-2">
                <select name="tahun" id="tahun" class="form-control">
                    <option value="">Pilih Tahun</option>
                    <?php for ($i = 2022; $i <= 2025; $i++) : ?>
                        <option <?= $i == date('Y') ? 'selected' : '' ?>><?= $i ?></option>
                    <?php endfor ?>
                </select>
            </div>
            <div class="col-lg-2">
                <select name="bulan" id="bulan" class="form-control">
                    <option value="">Pilih Bulan</option>
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-lg-6">
                <div class="card cardIn2">

                    <div class="card-body">
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border" id="LoadjakartaUtaraSetahun" style="display:none;position:absolute;z-index:9999;top:50%" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <div id="jakartaUtaraSetahun">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card cardIn">
                    <div class="card-body">
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border" id="LoadkarawangSetahun" style="display:none;position:absolute;z-index:9999;top:50%" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <div id="karawangSetahun"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top:-40px !important">
            <div class="col-lg-6">
                <div class="card cardIn2">
                    <div class="card-body">
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border" id="LoadCrimeperAreaJakut" style="display:none;position:absolute;z-index:9999;top:50%" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <div id="CrimeperAreaJakut"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card cardIn">
                    <div class="card-body">
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border" id="LoadCrimeperAreaKarawang" style="display:none;position:absolute;z-index:9999;top:50%" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <div id="CrimeperAreaKarawang"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top:-20px!important">
            <div class="col-lg-8">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" id="LoadMapsJakut" style="display:block;position:absolute;z-index:9999;top:50%" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="card" id="mapJakut" style="height:560px">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card cardIn" style="height:560px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border" id="LoadKategoriJakut" style="display:block;position:absolute;z-index:9999;top:50%" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>

                        <div class="form-group ml-4">
                            <ul class="nav">
                                <li class="nav-item first">
                                    <span class="nav-link">Perjudian</span>
                                </li>
                                <li class="nav-item second">
                                    <span class="nav-link"> Pencurian</span>
                                </li>
                                <li class="nav-item third">
                                    <span class="nav-link">Penggelapan</span>
                                </li>
                                <li class="nav-item four nkb_jakut">
                                    <span class="nav-link">Narkoba</span>
                                </li>
                                <li class="nav-item five kks_jakut">
                                    <span class="nav-link"> Kekerasan</span>
                                </li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <label for="">Penjaringan</label>
                            <span id="sample"></span>
                            <div class="progress" style="max-width: 100%">
                                <div class="progress-bar" id="penjaringan_perjudian" style="width:<?= 5 <= 2 ? 5 : 5 + 5 ?>%">
                                    <?= 5 ?>
                                </div>
                                <div class="progress-bar bg-success" id="penjaringan_pencurian" style="width:<?= 5 <= 2 ? 5 : 5 + 5 ?>%">
                                    <?= 5 ?>
                                </div>
                                <div class="progress-bar bg-danger progress-bar-stripped" id="penjaringan_penggelapan" style="width:<?= 5 <= 2 ? 5 : 5 + 5 ?>%">
                                    <?= 5 ?>
                                </div>
                                <div class="progress-bar bg-warning progress-bar-stripped" id="penjaringan_narkoba" style="width:<?= 5 <= 2 ? 5 : 5 + 5 ?>%">
                                    <?= 5 ?>
                                </div>
                                <div class="progress-bar bg-dark progress-bar-stripped" id="penjaringan_kekerasan" style="width:<?= 5 <= 2 ? 5 : 5 + 5 ?>%">
                                    <?= 5 ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Koja</label>
                            <div class="progress" style="max-width: 100%">
                                <div class="progress-bar" id="koja_perjudian" style="width:<?= 5 <= 2 ? 5 : 5 + 5 ?>%">
                                    <?= 5 ?>
                                </div>
                                <div class="progress-bar bg-success" id="koja_pencurian" style="width:<?= 5 <= 2 ? 5 : 5 + 5 ?>%">
                                    <?= 5 ?>
                                </div>
                                <div class="progress-bar bg-danger progress-bar-stripped" id="koja_penggelapan" style="width:<?= 5 <= 2 ? 5 : 5 + 5 ?>%">
                                    <?= 5 ?>
                                </div>
                                <div class="progress-bar bg-warning progress-bar-stripped" id="koja_narkoba" style="width:<?= 5 <= 2 ? 5 : 5 + 5 ?>%">
                                    <?= 5 ?>
                                </div>
                                <div class="progress-bar bg-dark progress-bar-stripped" id="koja_kekerasan" style="width:<?= 5 <= 2 ? 5 : 5 + 5 ?>%">
                                    <?= 5 ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Tanjung Priok</label>
                            <div class="progress" style="max-width: 100%">
                                <div class="progress-bar" id="tanjung_priok_perjudian" style="width:<?= 5 <= 2 ? 5 : 5 + 5 ?>%">
                                    <?= 5 ?>
                                </div>
                                <div class="progress-bar  bg-success" id="tanjung_priok_pencurian" style="width:<?= 5 <= 2 ? 5 : 5 + 5 ?>%">
                                    <?= 5 ?>
                                </div>
                                <div class="progress-bar bg-danger progress-bar-stripped" id="tanjung_priok_penggelapan" style="width:<?= 5 <= 2 ? 5 : 5 + 5 ?>%">
                                    <?= 5 ?>
                                </div>
                                <div class="progress-bar bg-warning progress-bar-stripped" id="tanjung_priok_narkoba" style="width:<?= 6 <= 2 ? 5 : 6 + 5 ?>%">
                                    <?= 6 ?>
                                </div>
                                <div class="progress-bar bg-dark progress-bar-stripped" id="tanjung_priok_kekerasan" style="width:<?= 6 <= 2 ? 5 : 6 + 5 ?>%">
                                    <?= 6 ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Pademangan</label>
                            <div class="progress" style="max-width: 100%">
                                <div class="progress-bar" id="pademangan_perjudian" style="width:<?= 4 <= 2 ? 5 : 4 + 5 ?>%">
                                    <?= 4 ?>
                                </div>
                                <div class="progress-bar bg-success" id="pademangan_pencurian" style="width:<?= 7 <= 2 ? 5 : 7 + 5 ?>%">
                                    <?= 7 ?>
                                </div>
                                <div class="progress-bar bg-danger progress-bar-stripped" id="pademangan_penggelapan" style="width:<?= 4 <= 2 ? 5 : 4 + 5 ?>%">
                                    <?= 4 ?>
                                </div>
                                <div class="progress-bar bg-warning progress-bar-stripped" id="pademangan_narkoba" style="width:<?= 4 <= 2 ? 5 : 4 + 5 ?>%">
                                    <?= 4 ?>
                                </div>
                                <div class="progress-bar bg-dark progress-bar-stripped" id="pademangan_kekerasan" style="width:<?= 8 <= 2 ? 5 : 8 + 5 ?>%">
                                    <?= 8 ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Cilincing</label>
                            <div class="progress" style="max-width: 100%">
                                <div class="progress-bar" id="cilincing_perjudian" style="width:<?= 3 <= 2 ? 5 : 3 + 5 ?>%">
                                    <?= 3 ?>
                                </div>
                                <div class="progress-bar bg-success" id="cilincing_pencurian" style="width:<?= 6 <= 2 ? 5 : 6 + 5 ?>%">
                                    <?= 6 ?>
                                </div>
                                <div class="progress-bar bg-danger progress-bar-stripped" id="cilincing_penggelapan" style="width:<?= 4 <= 2 ? 5 : 4 + 5 ?>%">
                                    <?= 4 ?>
                                </div>
                                <div class="progress-bar bg-warning progress-bar-stripped" id="cilincing_narkoba" style="width:<?= 6 <= 2 ? 5 : 6 + 5 ?>%">
                                    <?= 6 ?>
                                </div>
                                <div class="progress-bar bg-dark progress-bar-stripped" id="cilincing_kekerasan" style="width:<?= 4 <= 2 ? 5 : 4 + 5 ?>%">
                                    <?= 4 ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="">Kelapa Gading</label>
                            <div class="progress" style="max-width: 100%">
                                <div class="progress-bar" id="kelapa_gading_perjudian" style="width:<?= 4 <= 2 ? 5 : 4 + 5 ?>%">
                                    <?= 4 ?>
                                </div>
                                <div class="progress-bar bg-success" id="kelapa_gading_pencurian" style="width:<?= 4 <= 2 ? 5 : 4 + 5 ?>%">
                                    <?= 4 ?>
                                </div>
                                <div class="progress-bar bg-danger progress-bar-stripped" id="kelapa_gading_penggelapan" style="width:<?= 4 <= 2 ? 5 : 4 + 5 ?>%">
                                    <?= 4 ?>
                                </div>
                                <div class="progress-bar bg-warning progress-bar-stripped" id="kelapa_gading_narkoba" style="width:<?= 4 <= 2 ? 5 : 4 + 5 ?>%">
                                    <?= 4 ?>
                                </div>
                                <div class="progress-bar bg-dark progress-bar-stripped" id="kelapa_gading_kekerasan" style="width:<?= 44 <= 2 ? 5 : 44 + 5 ?>%">
                                    <?= 44 ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <div class="row" style="margin-top:-20px!important">
            <div class="col-lg-4">
                <div class="card cardIn" style="height:620px;">
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border" id="LoadKategoriKarawangs" style="display:block;position:absolute;z-index:9999;top:50%" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group ml-4">
                            <ul class="nav">
                                <li class="nav-item first">
                                    <span class="nav-link">Perjudian</span>
                                </li>
                                <li class="nav-item second">
                                    <span class="nav-link"> Pencurian</span>
                                </li>
                                <li class="nav-item third">
                                    <span class="nav-link">Penggelapan</span>
                                </li>
                                <li class="nav-item four">
                                    <span class="nav-link">Narkoba</span>
                                </li>
                                <li class="nav-item five">
                                    <span class="nav-link">Kekerasan</span>
                                </li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <label for="">Teluk Jambe Barat</label>
                            <div class="progress" style="max-width: 100%">
                                <div class="progress-bar" id="teluk_jambe_barat_perjudian" id="teluk_jambe_barat_perjudian" style="width:<?= 5 <= 2 ? 5 : 5 + 5 ?>%">
                                    <?= 5 ?>
                                </div>
                                <div class="progress-bar bg-success" id="teluk_jambe_barat_pencurian" style="width:<?= 7 <= 2 ? 5 : 7 + 5 ?>%">
                                    <?= 7 ?>
                                </div>
                                <div class="progress-bar bg-danger progress-bar-stripped" id="teluk_jambe_barat_penggelapan" style="width:<?= 5 <= 2 ? 5 : 5 + 5 ?>%">
                                    <?= 5 ?>
                                </div>
                                <div class="progress-bar bg-warning progress-bar-stripped" id="teluk_jambe_barat_narkoba" style="width:<?= 4 <= 2 ? 5 : 4 + 5 ?>%">
                                    <?= 4 ?>
                                </div>
                                <div class="progress-bar bg-dark progress-bar-stripped" id="teluk_jambe_barat_kekerasan" style="width:<?= 6 <= 2 ? 5 : 6 + 5 ?>%">
                                    <?= 6 ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Teluk Jambe Timur</label>
                            <div class="progress" style="max-width: 100%">
                                <div class="progress-bar" id="teluk_jambe_timur_perjudian" s style="width:<?= 7 <= 2 ? 5 : 7 + 5 ?>%">
                                    <?= 7 ?>
                                </div>
                                <div class="progress-bar bg-success" id="teluk_jambe_timur_pencurian" style="width:<?= 6 <= 2 ? 5 : 6 + 5 ?>%">
                                    <?= 6 ?>
                                </div>
                                <div class="progress-bar bg-danger progress-bar-stripped" id="teluk_jambe_timur_penggelapan" style="width:<?= 5 <= 2 ? 5 : 5 + 5 ?>%">
                                    <?= 5 ?>
                                </div>
                                <div class="progress-bar bg-warning progress-bar-stripped" id="teluk_jambe_timur_narkoba" style="width:<?= 4 <= 2 ? 5 : 4 + 5 ?>%">
                                    <?= 4 ?>
                                </div>
                                <div class="progress-bar bg-dark progress-bar-stripped" id="teluk_jambe_timur_kekerasan" style="width:<?= 7 <= 2 ? 5 : 7 + 5 ?>%">
                                    <?= 7 ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Klari</label>
                            <div class="progress" style="max-width: 100%">
                                <div class="progress-bar" id="klari_perjudian" style="width:<?= 7 <= 2 ? 5 : 7 + 5 ?>%">
                                    <?= 7 ?>
                                </div>
                                <div class="progress-bar bg-success" id="klari_pencurian" style="width:<?= 5 <= 2 ? 5 : 5 + 5 ?>%">
                                    <?= 5 ?>
                                </div>
                                <div class="progress-bar bg-danger progress-bar-stripped" id="klari_penggelapan" style="width:<?= 4 <= 2 ? 5 : 4 + 5 ?>%">
                                    <?= 4 ?>
                                </div>
                                <div class="progress-bar bg-warning progress-bar-stripped" id="klari_narkoba" style="width:<?= 9 <= 2 ? 5 : 9 + 5 ?>%">
                                    <?= 9 ?>
                                </div>
                                <div class="progress-bar bg-dark progress-bar-stripped" id="klari_kekerasan" style="width:<?= 6 <= 2 ? 5 : 6 + 5 ?>%">
                                    <?= 6 ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Ciampel</label>
                            <div class="progress" style="max-width: 100%">
                                <div class="progress-bar" id="ciampel_perjudian" style="width:<?= 6 <= 2 ? 5 : 6 + 5 ?>%">
                                    <?= 6 ?>
                                </div>
                                <div class="progress-bar bg-success" id="ciampel_pencurian" style="width:<?= 5 <= 2 ? 5 : 5 + 5 ?>%">
                                    <?= 5 ?>
                                </div>
                                <div class="progress-bar bg-danger progress-bar-stripped" id="ciampel_penggelapan" style="width:<?= 4 <= 2 ? 5 : 4 + 5 ?>%">
                                    <?= 4 ?>
                                </div>
                                <div class="progress-bar bg-warning progress-bar-stripped" id="ciampel_narkoba" style="width:<?= 7 <= 2 ? 5 : 7 + 5 ?>%">
                                    <?= 7 ?>
                                </div>
                                <div class="progress-bar bg-dark progress-bar-stripped" id="ciampel_kekerasan" style="width:<?= 5 <= 2 ? 5 : 5 + 5 ?>%">
                                    <?= 5 ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Majalaya</label>
                            <div class="progress" style="max-width: 100%">
                                <div class="progress-bar" id="majalaya_perjudian" style="width:<?= 5 <= 2 ? 5 : 5 + 5 ?>%">
                                    <?= 5 ?>
                                </div>
                                <div class="progress-bar bg-success" id="majalaya_pencurian" style="width:<?= 4 <= 2 ? 5 : 4 + 5 ?>%">
                                    <?= 4 ?>
                                </div>
                                <div class="progress-bar bg-danger progress-bar-stripped" id="majalaya_penggelapan" style="width:<?= 6 <= 2 ? 5 : 6 + 5 ?>%">
                                    <?= 6 ?>
                                </div>
                                <div class="progress-bar bg-warning progress-bar-stripped" id="majalaya_narkoba" style="width:<?= 5 <= 2 ? 5 : 5 + 5 ?>%">
                                    <?= 5 ?>
                                </div>
                                <div class="progress-bar bg-dark progress-bar-stripped" id="majalaya_kekerasan" style="width:<?= 6 <= 2 ? 5 : 6 + 5 ?>%">
                                    <?= 6 ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="">Karawang Barat</label>
                            <div class="progress" style="max-width: 100%">
                                <div class="progress-bar" id="karawang_barat_perjudian" style="width:<?= 5 <= 2 ? 5 : 5 + 5 ?>%">
                                    <?= 5 ?>
                                </div>
                                <div class="progress-bar bg-success" id="karawang_barat_pencurian" style="width:<?= 5 <= 2 ? 5 : 5 + 5 ?>%">
                                    <?= 5 ?>
                                </div>
                                <div class="progress-bar bg-danger progress-bar-stripped" id="karawang_barat_penggelapan" style="width:<?= 5 <= 2 ? 5 : 5 + 5 ?>%">
                                    <?= 5 ?>
                                </div>
                                <div class="progress-bar bg-warning progress-bar-stripped" id="karawang_barat_narkoba" style="width:<?= 4 <= 2 ? 5 : 4 + 5 ?>%">
                                    <?= 4 ?>
                                </div>
                                <div class="progress-bar bg-dark progress-bar-stripped" id="karawang_barat_kekerasan" style="width:<?= 4 <= 2 ? 5 : 4 + 5 ?>%">
                                    <?= 4 ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="">Karawang Timur</label>
                            <div class="progress" style="max-width: 100%">
                                <div class="progress-bar" id="karawang_timur_perjudian" style="width:<?= 5 <= 2 ? 5 : 5 + 5 ?>%">
                                    <?= 5 ?>
                                </div>
                                <div class="progress-bar bg-success" id="karawang_timur_pencurian" style="width:<?= 5 <= 2 ? 5 : 5 + 5 ?>%">
                                    <?= 5 ?>
                                </div>
                                <div class="progress-bar bg-danger progress-bar-stripped" id="karawang_timur_penggelapan" style="width:<?= 5 <= 2 ? 5 : 5 + 5 ?>%">
                                    <?= 5 ?>
                                </div>
                                <div class="progress-bar bg-warning progress-bar-stripped" id="karawang_timur_narkoba" style="width:<?= 7 <= 2 ? 5 : 7 + 5 ?>%">
                                    <?= 7 ?>
                                </div>
                                <div class="progress-bar bg-dark progress-bar-stripped" id="karawang_timur_kekerasan" style="width:<?= 4 <= 2 ? 5 : 4 + 5 ?>%">
                                    <?= 4 ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" id="LoadMapsKarawangs" style="display:block;position:absolute;z-index:9999;top:50%" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="card" id="mapKarawang" style="height:620px">
                </div>
            </div>

        </div>

    </div>
</section>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/variable-pie.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>

<script src="https://unpkg.com/leaflet@1.9.0/dist/leaflet.js" integrity="sha256-oH+m3EWgtpoAmoBO/v+u8H/AdwB/54Gc/SgqjUKbb4Y=" crossorigin=""></script>
<script src="{{ asset('geojson/jakarta-utara-geojson.js') }}"></script>
<script src="{{ asset('geojson/karawang_geo.js') }}"></script>



<script>
    var thn = <?= date('Y') ?>;
    var blan = <?= date('m') ?>;

    document.getElementById("mapJakut").innerHTML = "<div style='height: 560px' id='map'></div>";
    document.getElementById("mapKarawang").innerHTML = "<div style='height: 620px' id='map2'></div>";

    const map = L.map('map').setView([-6.125976186640234, 106.84136805372526], 12);
    const map2 = L.map('map2').setView([-6.336561017973876, 107.34963071891251], 11);

    const tiles = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '',
        background: 'red'
    }).addTo(map);

    // add an OpenStreetMap tile layer
    const tiles2 = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '',
        background: 'red'
    }).addTo(map2);
    // 



    // control that shows state info on hover
    const info = L.control();
    const info2 = L.control();
    // Jakut
    info.onAdd = function(map) {
        this._div = L.DomUtil.create('div', 'info');
        this.update();
        return this._div;
    };

    // Karawang 
    info2.onAdd = function(map2) {
        this._div = L.DomUtil.create('div', 'info1');
        this.update();
        return this._div;
    };

    // Jakut
    info.update = function(props) {
        const contents = props ? `<b>${props.name}</b><br />${props.density} Case` : '';
        this._div.innerHTML = `<h4 class="tes">Jakarta Utara</h4>${contents}`;
    };
    // Jakut
    info.addTo(map);

    // Karawang
    info2.update = function(props) {
        const contents = props ? `<b>${props.name}</b><br />${props.density} Case` : '';
        this._div.innerHTML = `<h4 class="tes">Karawang</h4>${contents}`;
    };

    // Karawang
    info2.addTo(map2);


    // get color depending on population density value
    function getColor(d) {
        // return d > 1000 ? '#800026' :
        //     d > 500 ? '#BD0026' :
        //     d > 200 ? '#E31A1C' :
        //     d > 100 ? '#FC4E2A' :
        //     d > 50 ? '#FD8D3C' :
        //     d > 20 ? '#FEB24C' :
        //     d > 10 ? '#FED976' : '#FFEDA0';

        return d > 60 ? '#800026' :
            d > 40 ? '#BD0026' :
            d > 30 ? '#E31A1C' :
            d > 25 ? '#FC4E2A' :
            d > 20 ? '#FD8D3C' :
            d > 10 ? '#FEB24C' :
            d > 5 ? '#FED976' : '#FFEDA0';
    }

    function style(feature) {
        return {
            weight: 2,
            opacity: 1,
            color: '#ccc',
            dashArray: '1',
            fillOpacity: 10,
            fillColor: getColor(feature.properties.density)
        };
    }

    function highlightFeature(e) {
        const layer = e.target;

        layer.setStyle({
            weight: 5,
            color: '#666',
            dashArray: '',
            fillOpacity: 0.7
        });

        layer.bringToFront();

        // Jakut
        info.update(layer.feature.properties);
        info2.update(layer.feature.properties);
    }

    const geojson = L.geoJson(statesData, {
        style,
        onEachFeature
    }).addTo(map);

    // Karawang state kecamatan
    const geojson2 = L.geoJson(statesKarawang, {
        style,
        onEachFeature
    }).addTo(map2);

    // 
    function setMapJakutValues(thn, blan) {
        $.ajax({
            url: "mapJakut",
            method: "POST",
            data: {
                tahun: thn,
                bulan: blan,
                "_token": "{{ csrf_token() }}",
            },
            beforeSend: function() {
                document.getElementById("LoadMapsJakut").style.display = "block";
            },
            complete: function() {
                document.getElementById("LoadMapsJakut").style.display = "none";
            },
            success: function(e) {
                let data = e;
                for (let i = 0; i < data.length; i++) {
                    // console.log(statesData.features[i].properties.name + ':' + data[i].label)
                    if (statesData.features[i].properties.name == data[i].label) {
                        statesData.features[i].properties.density = data[i].data;
                    }
                }
                /* Jakut state kecamatan */
                const geojson = L.geoJson(statesData, {
                    style,
                    onEachFeature
                }).addTo(map);

                L.geoJson(statesData, {
                    onEachFeature: function(feature, layer) {
                        let marker = [90, 40];
                        if (feature.properties.name == 'Penjaringan') {
                            marker = [90, 10]
                        } else if (feature.properties.name == 'Pademangan') {
                            marker = [120, 10]
                        } else if (feature.properties.name == 'Tanjung Priok') {
                            marker = [90, -20]
                        } else if (feature.properties.name == 'Koja') {
                            marker = [50, -20]
                        } else if (feature.properties.name == 'Kelapa Gading') {
                            marker = [50, 10]
                        }
                        var label = L.marker(layer.getBounds().getCenter(), {
                            icon: L.divIcon({
                                className: 'labels',
                                html: '<b style="color:#000 !important">' + feature.properties.name + '</b>',
                                iconSize: marker
                            })
                        }).addTo(map);
                    }
                });


            }

        })
    }
    setMapJakutValues(thn, "");
    // 

    // 
    function setMapKarawangValues(thn, blan) {
        $.ajax({
            url: "mapKarawang",
            method: "POST",
            data: {
                tahun: thn,
                bulan: blan,
                "_token": "{{ csrf_token() }}",
            },
            beforeSend: function() {
                document.getElementById("LoadMapsKarawangs").style.display = "block";
            },
            complete: function() {
                document.getElementById("LoadMapsKarawangs").style.display = "none";
            },
            success: function(e) {
                let data = e;
                for (let i = 0; i < data.length; i++) {
                    // console.log(data[i].label + ':' + data[i].data)
                    var kecamatan = statesKarawang.features[i].properties.name;
                    kecamatan = kecamatan.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                        return letter.toUpperCase();
                    });
                    // console.log(statesData.features[i].properties.name + ':' + data[i].label)
                    if (kecamatan == data[i].label) {
                        statesKarawang.features[i].properties.density = data[i].data;
                    }
                }
                // Karawang state kecamatan
                const geojson2 = L.geoJson(statesKarawang, {
                    style,
                    onEachFeature
                }).addTo(map2);

                L.geoJson(statesKarawang, {
                    onEachFeature: function(feature, layer) {
                        let marker = [90, 40];
                        var kec = "";
                        var kecamatan = feature.properties.name;
                        kecamatan = kecamatan.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                            return letter.toUpperCase();
                        });

                        if (kecamatan == 'Ciampel') {
                            kec = kecamatan;
                            marker = [90, 90]
                        }
                        if (kecamatan == 'Teluk Jambe Barat') {
                            kec = kecamatan;
                            marker = [40, 40, 90]
                        }
                        if (kecamatan == 'Teluk Jambe Timur') {
                            kec = kecamatan;
                            marker = [40, 40, 90]
                        }

                        if (kecamatan == 'Karawang Timur') {
                            kec = kecamatan;
                            marker = [50, -10, 90]
                        }

                        if (kecamatan == 'Karawang Barat') {
                            kec = kecamatan;
                            marker = [50, 40, 90]
                        }

                        if (kecamatan == 'Majalaya') {
                            kec = kecamatan;
                            marker = [60, -20, 90]
                        }

                        if (kecamatan == 'Klari') {
                            kec = kecamatan;
                            marker = [60, 90, 90]
                        }

                        // console.log(feature.properties.name)
                        var label = L.marker(layer.getBounds().getCenter(), {
                            icon: L.divIcon({
                                className: 'labels',
                                html: '<b style="color:#000 !important">' + kec + '</b>',
                                iconSize: marker
                            })
                        }).addTo(map2);
                    }
                });
            }
        })
    }
    setMapKarawangValues(thn, "");
    // 

    function resetHighlight(e) {
        geojson.resetStyle(e.target);
        geojson2.resetStyle(e.target);
        info.update();
        info2.update();
    }

    function zoomToFeature(e) {
        map.fitBounds(e.target.getBounds());
        map2.fitBounds(e.target.getBounds());
    }

    function onEachFeature(feature, layer) {
        layer.on({
            mouseover: highlightFeature,
            mouseout: resetHighlight,
            click: zoomToFeature
        });
    }

    // Jakut
    map.attributionControl.addAttribution('');
    // Karawang
    map2.attributionControl.addAttribution('');

    // Jakut
    const legend = L.control({
        position: 'bottomleft'
    });
    // Karawang
    const legend2 = L.control({
        position: 'bottomleft'
    });

    // Jakut
    legend.onAdd = function(map) {
        const div = L.DomUtil.create('div', 'info legend');
        const grades = [0, 5, 15, 30, 50, 80];
        // const grades = [0, 10, 20, 30, 100, 200, 500, 1000];
        const labels = [];
        let from, to;

        for (let i = 0; i < grades.length; i++) {
            from = grades[i];
            to = grades[i + 1];
            labels.push(`<i style="background:${getColor(from + 1)}"></i> ${from}${to ? `&ndash;${to}` : '+'}`);
        }

        div.innerHTML = labels.join('<br>');
        return div;
    };

    // Karawang
    legend2.onAdd = function(map2) {

        const div = L.DomUtil.create('div', 'info legend');
        const grades = [0, 5, 15, 30, 50, 80];
        const labels = [];
        let from, to;

        for (let i = 0; i < grades.length; i++) {
            from = grades[i];
            to = grades[i + 1];
            labels.push(`<i style="background:${getColor(from + 1)}"></i> ${from}${to ? `&ndash;${to}` : '+'}`);
        }

        div.innerHTML = labels.join('<br>');
        return div;
    };

    // Jakut
    legend.addTo(map);
    // Karawang
    legend2.addTo(map2);






    function bulanConvert(bulan) {
        var bln = "";
        switch (bulan) {
            case '01':
                bln = "Januari";
                break;
            case '02':
                bln = "Februari";
                break;
            case '03':
                bln = "Maret";
                break;
            case '04':
                bln = "April";
                break;
            case '05':
                bln = "Mei";
                break;
            case '06':
                bln = "Juni";
                break;
            case '07':
                bln = "Juli";
                break;
            case '08':
                bln = "Agustus";
                break;
            case '09':
                bln = "September";
                break;
            case '10':
                bln = "Oktober";
                break;
            case '11':
                bln = "November";
                break;
            case '12':
                bln = "Desember";
                break;
        }

        return bln;
    }


    $(document).ready(function() {
        // karawang setahun
        var kar = Highcharts.chart({
            chart: {
                renderTo: 'karawangSetahun',
                type: 'column',
                options3d: {
                    enabled: true,
                    alpha: 10,
                    beta: 25,
                    depth: 70
                }
            },
            title: {
                text: 'Crime Index Karawang',
                align: 'center'
            },
            subtitle: {
                text: 'Periode Tahun ' + <?= date('Y') ?>
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total'
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: ( // theme
                            Highcharts.defaultOptions.title.style &&
                            Highcharts.defaultOptions.title.style.color
                        ) || 'gray',
                        textOutline: 'none'
                    }
                }
            },
            legend: {
                align: 'center',
                x: -10,
                verticalAlign: 'top',
                y: 10,
                // floating: true,
                backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || 'white',
                // borderColor: '#CCC',
                // borderWidth: 1,
                shadow: false
            },
            tooltip: {
                headerFormat: '<b>{point.x}</b><br/>',
                pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'KEKERASAN',
                data: []
            }, {
                name: 'NARKOBA',
                data: []
            }, {
                name: 'PERJUDIAN',
                data: []
            }, {
                name: 'PENCURIAN',
                data: []
            }, {
                name: 'PENGGELAPAN',
                data: []
            }]
        });


        function FkarawangSetahun(year, month) {
            $.ajax({
                url: "graphicKarawangSetahun",
                method: "POST",
                data: {
                    year: year,
                    month: month,
                    "_token": "{{ csrf_token() }}",
                },
                beforeSend: function() {
                    document.getElementById("LoadkarawangSetahun").style.display = "block";
                },
                complete: function() {
                    document.getElementById("LoadkarawangSetahun").style.display = "none";
                },
                success: function(e) {
                    var karawang = $('#karawangSetahun').highcharts();
                    let data = e;

                    karawang.subtitle.update({
                        text: 'Periode Tahun ' + year
                    });
                    for (let i = 0; i < data.length; i++) {
                        karawang.series[i].update({
                            name: data[i].label,
                            data: data[i].data
                        });
                    }
                    karawang.redraw();
                }
            });
        }
        FkarawangSetahun(thn, blan)


        // jakut setahun kategori
        var jak = Highcharts.chart({
            chart: {
                renderTo: 'jakartaUtaraSetahun',
                type: 'column',
                options3d: {
                    enabled: true,
                    alpha: 10,
                    beta: 25,
                    depth: 70
                }
            },

            title: {
                text: 'Crime Index Jakarta Utara',
                align: 'center'
            },
            subtitle: {
                text: 'Periode Tahun ' + <?= date('Y') ?>
            },
            credits: {
                enabled: false
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total'
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: ( // theme
                            Highcharts.defaultOptions.title.style &&
                            Highcharts.defaultOptions.title.style.color
                        ) || 'gray',
                        textOutline: 'none'
                    }
                }
            },
            legend: {
                align: 'center',
                x: -10,
                verticalAlign: 'top',
                y: 20,
                // floating: true,
                backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || 'white',
                // borderColor: '#CCC',
                // borderWidth: 1,
                shadow: false
            },
            tooltip: {
                headerFormat: '<b>{point.x}</b><br/>',
                pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            exporting: {
                enabled: false
            },
            series: [{
                name: 'KEKERASAN',
                data: []
            }, {
                name: 'NARKOBA',
                data: []
            }, {
                name: 'PERJUDIAN',
                data: []
            }, {
                name: 'PENCURIAN',
                data: []
            }, {
                name: 'PENGGELAPAN',
                data: []
            }]
        });

        function FjakartaSetahuan(year, month) {
            $.ajax({
                url: "graphicJakartaSetahun",
                method: "POST",
                data: {
                    year: year,
                    month: month,
                    "_token": "{{ csrf_token() }}",
                },
                beforeSend: function() {
                    document.getElementById("LoadjakartaUtaraSetahun").style.display = "block";
                },
                complete: function() {
                    document.getElementById("LoadjakartaUtaraSetahun").style.display = "none";
                },
                success: function(e) {
                    var jakut = $('#jakartaUtaraSetahun').highcharts();
                    let data = e;

                    jakut.subtitle.update({
                        text: 'Periode Tahun ' + year
                    });
                    for (let i = 0; i < data.length; i++) {
                        jakut.series[i].update({
                            name: data[i].label,
                            data: data[i].data
                        });
                    }
                    jakut.redraw();
                }
            });
        }
        FjakartaSetahuan(thn, blan)
        // 


        var crimeAreaJakut = Highcharts.chart('CrimeperAreaJakut', {
            title: {
                text: 'Crime Index Per Area Jakarta Utara',
                align: 'center'
            },
            subtitle: {
                text: 'Periode ' + <?= date('Y') ?>
                // text: 'Jumlah Kasus 2022'
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
            },
            yAxis: {
                // max: 150,
                title: {
                    text: ''
                }
            },
            labels: {
                items: [{
                    html: '',
                    style: {
                        left: '50px',
                        top: '18px',
                        color: ( // theme
                            Highcharts.defaultOptions.title.style &&
                            Highcharts.defaultOptions.title.style.color
                        ) || 'black'
                    }
                }]
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true
                    },
                    options3d: {
                        enabled: true,
                        alpha: 10,
                        beta: 25,
                        depth: 70
                    }
                },
            },
            exporting: {
                enabled: false
            },
            series: [{
                    type: 'column',
                    name: 'PENJARINGAN',
                    data: []
                }, {
                    type: 'column',
                    name: 'CILINCING',
                    data: []
                }, {
                    type: 'column',
                    name: 'KOJA',
                    data: []
                }, {
                    type: 'column',
                    name: 'PADEMANGAN',
                    data: []
                }, {
                    type: 'column',
                    name: 'TANJUNG PRIOK',
                    data: []
                }, {
                    type: 'column',
                    name: 'KELAPA GADING',
                    data: []
                },
                // {
                //     type: 'spline',
                //     name: 'TOTAL',
                //     data: [],
                //     marker: {
                //         lineWidth: 2,
                //         lineColor: Highcharts.getOptions().colors[3],
                //         fillColor: 'white'
                //     }
                // }
            ]
        });

        function FcrimeAreaJakut(year, month) {
            $.ajax({
                url: "graphicKecJakartaSetahun",
                method: "POST",
                data: {
                    year: year,
                    month: month,
                    "_token": "{{ csrf_token() }}",
                },
                beforeSend: function() {
                    document.getElementById("LoadCrimeperAreaJakut").style.display = "block";
                },
                complete: function() {
                    document.getElementById("LoadCrimeperAreaJakut").style.display = "none";
                },
                success: function(e) {
                    // console.log(e)
                    var kecJakut = $('#CrimeperAreaJakut').highcharts();
                    let data = e;
                    kecJakut.subtitle.update({
                        text: 'Periode Tahun ' + year
                    });
                    for (let i = 0; i < data[1].length; i++) {
                        kecJakut.series[i].update({
                            type: 'column',
                            name: data[1][i].label,
                            data: data[1][i].data
                        });
                    }
                    kecJakut.redraw();
                }
            });
        }
        FcrimeAreaJakut(thn, blan)



        var crimeAreaKarawang = Highcharts.chart('CrimeperAreaKarawang', {
            title: {
                text: 'Crime Index Per Area Karawang',
                align: 'center'
            },
            subtitle: {
                text: 'Periode ' + <?= date('Y') ?>
                // text: 'Jumlah Kasus 2022'
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
            },
            yAxis: {
                // max: 150,
                title: {
                    text: ''
                }
            },
            labels: {
                items: [{
                    html: '',
                    style: {
                        left: '50px',
                        top: '18px',
                        color: ( // theme
                            Highcharts.defaultOptions.title.style &&
                            Highcharts.defaultOptions.title.style.color
                        ) || 'black'
                    }
                }]
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            exporting: {
                enabled: false
            },
            series: [{
                    type: 'column',
                    name: 'TELUK JAMBE BARAT',
                    data: []
                }, {
                    type: 'column',
                    name: 'TELUK JAMBE TIMUR',
                    data: []
                }, {
                    type: 'column',
                    name: 'KLARI',
                    data: []
                }, {
                    type: 'column',
                    name: 'CIAMPEL',
                    data: []
                }, {
                    type: 'column',
                    name: 'MAJALAYA',
                    data: []
                }, {
                    type: 'column',
                    name: 'KARAWANG TIMUR',
                    data: []
                }, {
                    type: 'column',
                    name: 'KARAWANG BARAT',
                    data: []
                },
                //  {
                //     type: 'spline',
                //     name: 'TOTAL',
                //     data: [],
                //     marker: {
                //         lineWidth: 2,
                //         lineColor: Highcharts.getOptions().colors[3],
                //         fillColor: 'white'
                //     }
                // }
            ]
        });

        function FcrimeAreaKarawang(year, month) {
            $.ajax({
                url: "graphicKecKarawangSetahun",
                method: "POST",
                data: {
                    year: year,
                    month: month,
                    "_token": "{{ csrf_token() }}",
                },
                beforeSend: function() {
                    document.getElementById("LoadCrimeperAreaKarawang").style.display = "block";
                },
                complete: function() {
                    document.getElementById("LoadCrimeperAreaKarawang").style.display = "none";
                },
                success: function(e) {
                    var kecKarawang = $('#CrimeperAreaKarawang').highcharts();
                    let data = e;
                    // console.log(data);
                    kecKarawang.subtitle.update({
                        text: 'Periode Tahun ' + year
                    });
                    for (let i = 0; i < data[1].length; i++) {
                        kecKarawang.series[i].update({
                            type: 'column',
                            name: data[1][i].label,
                            data: data[1][i].data
                        });
                    }
                    kecKarawang.redraw();
                }
            });
        }
        FcrimeAreaKarawang(thn, blan);


        function FmapingKategoriJakut(year, month) {
            $.ajax({
                url: "mapingKategoriJakut",
                method: "POST",
                data: {
                    tahun: year,
                    bulan: month,
                    "_token": "{{ csrf_token() }}",
                },
                beforeSend: function() {
                    document.getElementById("LoadKategoriJakut").style.display = "block";
                },
                complete: function() {
                    document.getElementById("LoadKategoriJakut").style.display = "none";
                },
                success: function(e) {
                    let data = e;
                    const kecamatan = ['pademangan', 'koja', 'tanjung_priok', 'penjaringan', 'cilincing', 'kelapa_gading'];

                    for (let i = 0; i < data.length; i++) {
                        document.getElementById(kecamatan[i] + '_perjudian').innerHTML = data[i][1].perjudian;
                        document.getElementById(kecamatan[i] + '_pencurian').innerHTML = data[i][1].pencurian;
                        document.getElementById(kecamatan[i] + '_penggelapan').innerHTML = data[i][1].penggelapan;
                        document.getElementById(kecamatan[i] + '_narkoba').innerHTML = data[i][1].narkoba;
                        document.getElementById(kecamatan[i] + '_kekerasan').innerHTML = data[i][1].kekerasan;

                        document.getElementById(kecamatan[i] + "_perjudian").style.width = data[i][1].perjudian < 5 ? 5 + '%' : data[i][1].perjudian + 5 + '%'
                        document.getElementById(kecamatan[i] + "_pencurian").style.width = data[i][1].pencurian < 5 ? 5 + '%' : data[i][1].pencurian + 5 + '%'
                        document.getElementById(kecamatan[i] + "_penggelapan").style.width = data[i][1].penggelapan < 5 ? 5 + '%' : data[i][1].penggelapan + 5 + '%'
                        document.getElementById(kecamatan[i] + "_narkoba").style.width = data[i][1].narkoba < 5 ? 5 + '%' : data[i][1].narkoba + 5 + '%'
                        document.getElementById(kecamatan[i] + "_penggelapan").style.width = data[i][1].penggelapan < 5 ? 5 + '%' : data[i][1].penggelapan + 5 + '%'
                    }
                }
            });
        }
        FmapingKategoriJakut(thn, "")


        // update kategori mapping karawang 
        function FmapingKategoriKarawang(year, month) {
            $.ajax({
                url: "mapingKategoriKarawang",
                method: "POST",
                data: {
                    tahun: year,
                    bulan: month,
                    "_token": "{{ csrf_token() }}",
                },
                beforeSend: function() {
                    document.getElementById("LoadKategoriKarawangs").style.display = "block";
                },
                complete: function() {
                    document.getElementById("LoadKategoriKarawangs").style.display = "none";
                },
                success: function(e) {
                    let data = e;
                    // console.log(data);
                    const kecamatan = ['teluk_jambe_barat', 'teluk_jambe_timur', 'klari', 'ciampel', 'majalaya', 'karawang_barat', 'karawang_timur'];

                    for (let i = 0; i < data.length; i++) {

                        document.getElementById(kecamatan[i] + '_perjudian').innerHTML = data[i][1].perjudian;
                        document.getElementById(kecamatan[i] + '_pencurian').innerHTML = data[i][1].pencurian;
                        document.getElementById(kecamatan[i] + '_penggelapan').innerHTML = data[i][1].penggelapan;
                        document.getElementById(kecamatan[i] + '_narkoba').innerHTML = data[i][1].narkoba;
                        document.getElementById(kecamatan[i] + '_kekerasan').innerHTML = data[i][1].kekerasan;

                        document.getElementById(kecamatan[i] + "_perjudian").style.width = data[i][1].perjudian < 5 ? 5 + '%' : data[i][1].perjudian + 5 + '%'
                        document.getElementById(kecamatan[i] + "_pencurian").style.width = data[i][1].pencurian < 5 ? 5 + '%' : data[i][1].pencurian + 5 + '%'
                        document.getElementById(kecamatan[i] + "_penggelapan").style.width = data[i][1].penggelapan < 5 ? 5 + '%' : data[i][1].penggelapan + 5 + '%'
                        document.getElementById(kecamatan[i] + "_narkoba").style.width = data[i][1].narkoba < 5 ? 5 + '%' : data[i][1].narkoba + 5 + '%'
                        document.getElementById(kecamatan[i] + "_penggelapan").style.width = data[i][1].penggelapan < 5 ? 5 + '%' : data[i][1].penggelapan + 5 + '%'
                    }
                }
            });
        }
        FmapingKategoriKarawang(thn, "")



        $("#tahun,#bulan").change(function() {
            var tahun = $("#tahun").val();
            var bulan = $("#bulan").val();

            // Jakarta setahun
            FjakartaSetahuan(tahun, bulan)

            // Karawang setahun
            FkarawangSetahun(tahun, bulan)

            // Kecamatan Jakut Setahun
            FcrimeAreaJakut(tahun, bulan)

            // Kecamatan Karawang setahun
            FcrimeAreaKarawang(tahun, bulan)

            // Maps Jakut
            setMapJakutValues(tahun, bulan);

            // Maps Karawang
            setMapKarawangValues(tahun, bulan)

            // Kategori Area Jakut
            FmapingKategoriJakut(tahun, bulan);

            // Kategori Karawang
            FmapingKategoriKarawang(tahun, bulan)

        });


    })
</script>
@endsection