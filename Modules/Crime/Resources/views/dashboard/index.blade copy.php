@extends('crime::layouts.master')

@section('content')
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

    .tooltiptext {
        width: 120px;
        background-color: black;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px 0;
        font-size: 10px;
        position: absolute;
        z-index: 1;
    }

    .tooltiptext::after {
        content: " ";
        position: absolute;
        text-align: wordwrap;
        top: 100%;
        /* At the bottom of the tooltip */
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: black transparent transparent transparent;
    }

    .marker_map_karawang .tooltiptext {
        width: 100px;
        background-color: black;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px 0;
        font-size: 10px;
        position: absolute;
        z-index: 1;
    }

    .marker_map_karawang .teljambar {
        margin-left: -50px;
    }



    .marker_map_karawang .tooltiptext::after {
        content: " ";
        position: absolute;
        text-align: wordwrap;
        top: 100%;
        /* At the bottom of the tooltip */
        left: 50%;
        margin-left: 5px;
        border-width: 5px;
        border-style: solid;
        border-color: black transparent transparent transparent;
    }

    .marker_map_karawang .teljambar::after {
        margin-left: 35px !important;
        content: " ";
        position: absolute;
        text-align: wordwrap;
        top: 100%;
        /* At the bottom of the tooltip */
        left: 50%;
        margin-left: 5px;
        border-width: 5px;
        border-style: solid;
        border-color: black transparent transparent transparent;
    }

    .marker_map_karawang .majalaya::after {
        content: " ";
        position: absolute;
        text-align: wordwrap;
        top: 100%;
        /* At the bottom of the tooltip */
        left: 50%;
        margin-left: -25px;
        border-width: 5px;
        border-style: solid;
        border-color: black transparent transparent transparent;
    }

    .lab {
        position: absolute;
        top: 25px;
        text-align: center;
        left: -20px;
        color: #FFF;
    }

    .pademangan_map {
        position: relative;
        display: wrap;
        margin-left: 38% !important;
        top: 90px;
    }

    .penjaringan_map {
        position: relative;
        top: 30px;
        left: 90px !important;
    }

    .priok_map {
        position: relative;
        display: wrap;
        margin-left: 55% !important;
        top: 90px;
    }

    .koja_map {
        position: relative;
        display: wrap;
        margin-left: 66% !important;
        top: 30px;
    }

    .gading_map {
        position: relative;
        display: wrap;
        margin-left: 65% !important;
        top: 180px;
    }

    .cilincing_map {
        position: relative;
        display: wrap;
        margin-left: 82% !important;
        top: 70px;
    }

    .teljamba_map {
        position: relative;
        display: wrap;
        margin-left: 27% !important;
        top: 140px;
    }

    .teljamti_map {
        position: relative;
        display: wrap;
        margin-left: 35% !important;
        top: 150px;
    }

    .klari_map {
        position: relative;
        display: wrap;
        margin-left: 50% !important;
        top: 210px;
    }

    .ciampel_map {
        position: relative;
        display: wrap;
        margin-left: 42% !important;
        top: 240px;
    }

    .majalaya_map {
        position: relative;
        display: wrap;
        margin-left: 47% !important;
        top: 110px;
    }

    .karaba_map {
        position: relative;
        display: wrap;
        margin-left: 35% !important;
        top: 40px;
    }

    .karatim_map {
        position: relative;
        display: wrap;
        margin-left: 43% !important;
        top: 70px;
    }

    #marker_map_karawang {
        margin-left: 50px;
    }

    @media screen and (min-width: 1920px) {
        .pademangan_map {
            position: relative;
            display: wrap;
            margin-left: 37% !important;
            top: -20px;
        }

        .penjaringan_map {
            position: relative;
            display: wrap;
            margin-left: 15% !important;
            top: -10px;
        }

        .priok_map {
            position: relative;
            display: wrap;
            margin-left: 50% !important;
            top: 10px;
        }

        .koja_map {
            position: relative;
            display: wrap;
            margin-left: 57% !important;
            top: -30px;
        }

        .gading_map {
            position: relative;
            display: wrap;
            margin-left: 57% !important;
            top: 90px;
        }

        .cilincing_map {
            position: relative;
            display: wrap;
            margin-left: 68% !important;
            top: -20px;
        }

        .teljamba_map {
            position: relative;
            display: wrap;
            margin-left: 68% !important;
            top: -20px;
        }

        .nkb_jakut {
            margin-left: 8px;
        }

        .kks_jakut {
            margin-right: -10px;
        }

        #map_jakut_img {
            margin-left: 150px !important;
            height: 600px !important;
            margin-top: -140px !important;
            height: 600px;
        }
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
                        <div id="jakartaUtaraSetahun"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card cardIn">
                    <div class="card-body">
                        <div id="karawangSetahun"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="">
            <div class="col-lg-6">
                <div class="card cardIn2">
                    <div class="card-body">
                        <div id="CrimeperAreaJakut"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card cardIn">
                    <div class="card-body">
                        <div id="CrimeperAreaKarawang"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="">
            <div class="col-lg-8">
                <div class="card cardIn2" style="height:560px;">
                    <div class="row justify-content-center">
                        <div class="col-lg-11">
                            <div class="form-group text-center">
                                <h3 class="ml-2 text-center">Mapping Crime Index Jakarta Utara</h3>
                                <span class="text-center">Periode <span id="monthly_jakut">September</span> <span id="year_jakut"><?= date('Y') ?></span></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- <div id="maps_jakarta"></div> -->
                        <div class="marker_map" style="position: relative;">
                            <div class="penjaringan_map">
                                <span style="top:80px" class="tooltiptext">Penjaringan <span id="total_penjaringan">(0)</span></span>
                                <img height="60px" id="penjaringan_image" width="60px" src="{{ asset('assets/img/info/marker1.png') }}" alt="" style="position: absolute;top: 120px;left: 30px;">
                            </div>

                            <div class="pademangan_map">
                                <span style="top:80px" class="tooltiptext">Pademangan <span id="total_pademangan">(0)</span></span>
                                <img height="60px" id="pademangan_image" width="60px" src="{{ asset('assets/img/info/marker1.png') }}" alt="" style="position: absolute;top: 120px;left: 30px;">
                            </div>


                            <div class="priok_map">
                                <span style="top:80px" class="tooltiptext">Tanjung Priok<span id="total_priok">(0)</span></span>
                                <img height="60px" id="priok_image" width="60px" src="{{ asset('assets/img/info/marker1.png') }}" alt="" style="position: absolute;top: 120px;left: 30px;">
                            </div>

                            <div class="koja_map">
                                <span style="top:80px" class="tooltiptext">Koja<span id="total_koja">(0)</span></span>
                                <img height="60px" id="koja_image" width="60px" src="{{ asset('assets/img/info/marker1.png') }}" alt="" style="position: absolute;top: 120px;left: 30px;">
                            </div>

                            <div class="gading_map">
                                <span style="top:80px" class="tooltiptext">Kelapa Gading<span id="total_gading">(0)</span></span>
                                <img height="60px" id="gading_image" width="60px" src="{{ asset('assets/img/info/marker1.png') }}" alt="" style="position: absolute;top: 120px;left: 30px;">
                            </div>

                            <div class="cilincing_map">
                                <span style="top:80px" class="tooltiptext">Cilincing<span id="total_cilincing">(0)</span></span>
                                <img height="60px" id="cilincing_image" width="60px" src="{{ asset('assets/img/info/marker1.png') }}" alt="" style="position: absolute;top: 120px;left: 30px;">
                            </div>


                            <img height="600px" id="map_jakut_img" style="margin-top: -50px;" width="800px" src="{{ asset('assets/img/info/JAKUT.png') }}" alt="">
                        </div>
                        <!--  -->
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card cardIn" style="height:560px;">
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

        <div class="row" style="">
            <div class="col-lg-4">
                <div class="card cardIn" style="height:620px;">
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
                <div class="card cardIn2" style="height:620px;">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="form-group text-center">
                                <h3 class="ml-2 text-center">Mapping Crime Index Karawang</h3>
                                <span class="text-center">Periode <span id="monthly_karawang"></span> 2022</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- <div id="map_karawang"></div> -->
                        <div class="marker_map_karawang" style="position: absolute;">
                            <div class="teljamba_map">
                                <span style="top:85px" class="tooltiptext teljambar">Teluk Jambe Barat<span id="total_teljamba">(0)</span></span>
                                <img height="50px" id="teljamba_image" width="50px" src="{{ asset('assets/img/info/marker6.png') }}" alt="" style="position: absolute;top: 120px;left: 30px;">
                            </div>

                            <div class="teljamti_map">
                                <span style="top:85px" class="tooltiptext">Teluk Jambe Timur<span id="total_teljamti">(0)</span></span>
                                <img height="50px" id="teljamti_image" width="50px" src="{{ asset('assets/img/info/marker2.png') }}" alt="" style="position: absolute;top: 120px;left: 30px;">
                            </div>


                            <div class="klari_map">
                                <span style="top:85px" class="tooltiptext">Klari<span id="total_klari">(0)</span></span>
                                <img height="50px" id="klari_image" width="50px" src="{{ asset('assets/img/info/marker5.png') }}" alt="" style="position: absolute;top: 120px;left: 30px;">
                            </div>

                            <div class="ciampel_map">
                                <span style="top:85px" class="tooltiptext">Ciampel<span id="total_ciampel">(0)</span></span>
                                <img height="50px" id="ciampel_image" width="50px" src="{{ asset('assets/img/info/marker1.png') }}" alt="" style="position: absolute;top: 120px;left: 30px;">
                            </div>

                            <div class="majalaya_map">
                                <span style="top:85px;margin-left:40px" class="tooltiptext majalaya">Majalaya<span id="total_majalaya">(0)</span></span>
                                <img height="50px" id="majalaya_image" width="50px" src="{{ asset('assets/img/info/marker1.png') }}" alt="" style="position: absolute;top: 120px;left: 30px;">
                            </div>

                            <div class="karaba_map">
                                <span style="top:85px" class="tooltiptext ">Karawang Barat<span id="total_karaba">(0)</span></span>
                                <img height="50px" id="karaba_image" width="50px" src="{{ asset('assets/img/info/marker1.png') }}" alt="" style="position: absolute;top: 120px;left: 30px;">
                            </div>

                            <div class="karatim_map">
                                <span style="top:85px" class="tooltiptext">Karawang Timur<span id="total_karatim">(0)</span></span>
                                <img height="50px" id="karatim_image" width="50px" src="{{ asset('assets/img/info/marker1.png') }}" alt="" style="position: absolute;top: 120px;left: 30px;">
                            </div>


                            <img height="600px" id="map_karawang_img" style="margin-top: -80px;margin-left:-40px" width="100%" src="{{ asset('assets/img/info/map_karawang.png') }}" alt="">
                        </div>
                    </div>
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




<script>
    var thn = <?= date('Y') ?>;
    var blan = <?= date('m') ?>;



    function loadMapJakut(thn, blan) {
        $.ajax({
            url: "mapJakut",
            method: "POST",
            data: {
                tahun: thn,
                bulan: blan,
                "_token": "{{ csrf_token() }}",
            },
            success: function(e) {
                let data = e;
                var pademangan = data[0].total;
                var cilincing = data[1].total;
                var penjaringan = data[2].total;
                var priok = data[3].total;
                var koja = data[4].total;
                var gading = data[5].total;
                var dangerIcon = "{{ asset('assets/img/info/marker5.png') }}";
                var mediumIcon = "{{ asset('assets/img/info/marker3.png') }}";
                var veryDangerIcon = "{{ asset('assets/img/info/marker2.png') }}";
                document.getElementById("total_penjaringan").innerHTML = '(' + penjaringan + ')';
                document.getElementById("total_pademangan").innerHTML = '(' + pademangan + ')';
                document.getElementById("total_priok").innerHTML = '(' + priok + ')';
                document.getElementById("total_koja").innerHTML = '(' + koja + ')';
                document.getElementById("total_gading").innerHTML = '(' + gading + ')';
                document.getElementById("total_cilincing").innerHTML = '(' + cilincing + ')';
                var iconPenjaringan = penjaringan <= 3 ? mediumIcon : (penjaringan <= 7 ? dangerIcon : veryDangerIcon);
                var iconPademangan = pademangan <= 3 ? mediumIcon : (pademangan <= 7 ? dangerIcon : veryDangerIcon);
                var iconPriok = priok <= 3 ? mediumIcon : (priok <= 7 ? dangerIcon : veryDangerIcon);
                var iconKoja = koja <= 3 ? mediumIcon : (koja <= 7 ? dangerIcon : veryDangerIcon);
                var iconGading = gading <= 3 ? mediumIcon : (gading <= 7 ? dangerIcon : veryDangerIcon);
                var iconCilincing = cilincing <= 3 ? mediumIcon : (cilincing <= 7 ? dangerIcon : veryDangerIcon);
                $('#penjaringan_image').attr('src', iconPenjaringan);
                $('#pademangan_image').attr('src', iconPademangan);
                $('#koja_image').attr('src', iconKoja);
                $('#cilincing_image').attr('src', iconCilincing);
                $('#priok_image').attr('src', iconPriok);
                $('#gading_image').attr('src', iconGading);
            }

        })
    }
    loadMapJakut(thn, "");



    function loadMapKarawang(thn, bln) {
        $.ajax({
            url: "mapKarawang",
            method: "POST",
            data: {
                tahun: thn,
                bulan: bln,
                "_token": "{{ csrf_token() }}",
            },
            success: function(e) {
                let data = e
                // console.log(e);
                var teljambar = data[0].total;
                var teljamtim = data[1].total;
                var klari = data[2].total;
                var ciampel = data[3].total;
                var majalaya = data[4].total;
                var karaba = data[5].total;
                var karatim = data[6].total;
                var dangerIcon = "{{ asset('assets/img/info/marker5.png') }}";
                var mediumIcon = "{{ asset('assets/img/info/marker3.png') }}";
                var veryDangerIcon = "{{ asset('assets/img/info/marker2.png') }}";
                document.getElementById("total_teljamba").innerHTML = '(' + teljambar + ')';
                document.getElementById("total_teljamti").innerHTML = '(' + teljamtim + ')';
                document.getElementById("total_klari").innerHTML = '(' + klari + ')';
                document.getElementById("total_ciampel").innerHTML = '(' + ciampel + ')';
                document.getElementById("total_majalaya").innerHTML = '(' + majalaya + ')';
                document.getElementById("total_karaba").innerHTML = '(' + karaba + ')';
                document.getElementById("total_karatim").innerHTML = '(' + karatim + ')';
                var iconTeljambar = teljambar <= 3 ? mediumIcon : (teljambar <= 7 ? dangerIcon : veryDangerIcon);
                var iconTeljamtim = teljamtim <= 3 ? mediumIcon : (teljamtim <= 7 ? dangerIcon : veryDangerIcon);
                var iconKlari = klari <= 3 ? mediumIcon : (klari <= 7 ? dangerIcon : veryDangerIcon);
                var iconCiampel = ciampel <= 3 ? mediumIcon : (ciampel <= 7 ? dangerIcon : veryDangerIcon);
                var iconMajalaya = majalaya <= 3 ? mediumIcon : (majalaya <= 7 ? dangerIcon : veryDangerIcon);
                var iconKaraba = karaba <= 3 ? mediumIcon : (karaba <= 7 ? dangerIcon : veryDangerIcon);
                var iconKaratim = karatim <= 3 ? mediumIcon : (karatim <= 7 ? dangerIcon : veryDangerIcon);
                $('#teljamba_image').attr('src', iconTeljambar);
                $('#teljamti_image').attr('src', iconTeljamtim);
                $('#klari_image').attr('src', iconKlari);
                $('#ciampel_image').attr('src', iconCiampel);
                $('#majalaya_image').attr('src', iconMajalaya);
                $('#karaba_image').attr('src', iconKaraba);
                $('#karatim_image').attr('src', iconKaratim);
            }

        })
    }
    loadMapKarawang(thn, "");





    document.getElementById("monthly_jakut").innerHTML = bulanConvert("<?= date('m') ?>")
    document.getElementById("monthly_karawang").innerHTML = bulanConvert("<?= date('m') ?>")

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
        var kar;
        var karawangSetahun = {
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
        }
        kar = Highcharts.chart(karawangSetahun);

        function FkarawangSetahun(year, month) {
            $.ajax({
                url: "graphicKarawangSetahun",
                method: "POST",
                data: {
                    year: year,
                    month: month,
                    "_token": "{{ csrf_token() }}",
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
        // 

        // jakut setahun kategori
        var jak
        var jakartaSetahuan = {
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
        }
        jak = Highcharts.chart(jakartaSetahuan);

        function FjakartaSetahuan(year, month) {
            $.ajax({
                url: "graphicJakartaSetahun",
                method: "POST",
                data: {
                    year: year,
                    month: month,
                    "_token": "{{ csrf_token() }}",
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

        var CrimeperAreaJakut
        var crimeAreaJakut
        CrimeperAreaJakut = {
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
        }
        crimeAreaJakut = Highcharts.chart('CrimeperAreaJakut', CrimeperAreaJakut);

        function FcrimeAreaJakut(year, month) {
            $.ajax({
                url: "graphicKecJakartaSetahun",
                method: "POST",
                data: {
                    year: year,
                    month: month,
                    "_token": "{{ csrf_token() }}",
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



        var CrimeperAreaKarawang
        var crimeAreaKarawang
        CrimeperAreaKarawang = {
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
        }
        crimeAreaKarawang = Highcharts.chart('CrimeperAreaKarawang', CrimeperAreaKarawang);

        function FcrimeAreaKarawang(year, month) {
            $.ajax({
                url: "graphicKecKarawangSetahun",
                method: "POST",
                data: {
                    year: year,
                    month: month,
                    "_token": "{{ csrf_token() }}",
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


        function updateGraphic(tahun, bulan) {
            $.ajax({
                url: "graphicJakartaSetahun",
                type: 'post',
                data: {
                    tahun: tahun,
                    bulan: bulan,
                    "_token": "{{ csrf_token() }}",
                },
                beforeSend: function() {
                    document.getElementById("preloader2").style.display = "block";
                },
                complete: function() {
                    document.getElementById("preloader2").style.display = "none";
                },
                success: function(e) {
                    // const data = JSON.parse(e);
                    // document.getElementById("monthly_jakut").innerHTML = bulanConvert(bulan);
                    // document.getElementById("year_jakut").innerHTML = tahun;
                }
            })
        }
        // updateGraphic(thn, blan)



        // update kategori mapping jakarta utara
        function FmapingKategoriJakut(year, month) {
            $.ajax({
                url: "mapingKategoriJakut",
                method: "POST",
                data: {
                    tahun: year,
                    bulan: month,
                    "_token": "{{ csrf_token() }}",
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

            // // update graphic
            updateGraphic(tahun, bulan)

            // update kategori mapping 
            FmapingKategoriJakut(tahun, bulan)
            FmapingKategoriKarawang(tahun, bulan)

            loadMapJakut(tahun, bulan);
            loadMapKarawang(tahun, bulan);
        });


    })
</script>
@endsection