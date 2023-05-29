<style>
    .table td {
        vertical-align: middle !important;
        padding: 5px 12px;
    }

    .table thead th {
        vertical-align: middle !important;
        /*padding: 0;*/
    }

    /* Timeline */
    .timeline {
        list-style: none;
        padding: 0;
        position: relative;
    }

    .timeline:before {
        top: 0;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 3px;
        background-color: #6c7293;
        left: 50%;
        margin-left: -1.5px;
    }

    .timeline .timeline-wrapper {
        display: block;
        margin-bottom: 35px;
        position: relative;
        width: 100%;
        padding-right: 90px;
    }

    .timeline .timeline-wrapper:before {
        content: " ";
        display: table;
    }

    .timeline .timeline-wrapper:after {
        content: " ";
        display: table;
        clear: both;
    }

    .timeline .timeline-wrapper .timeline-panel {
        padding: 20px;
        position: relative;
        background: #ffffff;
        border-radius: 6px;
        box-shadow: 1px 2px 35px 0 rgba(1, 1, 1, 0.1);
        width: 40%;
        margin-left: 11%;
    }

    .timeline .timeline-wrapper .timeline-panel:before {
        position: absolute;
        top: 0;
        width: 100%;
        height: 5px;
        content: "";
        left: 0;
        right: 0;
    }

    .timeline .timeline-wrapper .timeline-panel:after {
        position: absolute;
        top: 10px;
        right: -14px;
        display: inline-block;
        border-top: 14px solid transparent;
        border-left: 14px solid #ffffff;
        border-right: 0 solid #ffffff;
        border-bottom: 14px solid transparent;
        content: " ";
    }

    .timeline .timeline-wrapper .timeline-panel .timeline-title {
        margin-top: 0;
        color: #001737;
        text-transform: uppercase;
    }

    .timeline .timeline-wrapper .timeline-panel .timeline-body p+p {
        margin-top: 5px;
    }

    .timeline .timeline-wrapper .timeline-panel .timeline-body ul {
        margin-bottom: 0;
    }

    .timeline .timeline-wrapper .timeline-panel .timeline-footer span {
        font-size: .6875rem;
    }

    .timeline .timeline-wrapper .timeline-panel .timeline-footer i {
        font-size: 1.5rem;
    }

    .timeline .timeline-wrapper .timeline-badge {
        width: 30px;
        height: 30px;
        position: absolute;
        top: 6px;
        text-align: center;
        font-weight: 700;
        left: calc(50% - 15px);
        z-index: 10;
        border-radius: 50%;
        border: 2px solid #6c7293;
    }

    .timeline .timeline-wrapper .timeline-badge i {
        color: #ffffff;
    }

    .timeline-badge.timeline-duration {
        /*margin-top: 100px;*/
        background: #fff !important;
        border: 2px solid #28a745 !important;
        width: 115px !important;
        height: unset !important;
        border-radius: 30px !important;
        /*left: calc(50% - 30px) !important;*/
        left: 52% !important;
        font-size: 12px;
        padding: 5px;
    }

    .timeline-inverted .timeline-badge.timeline-duration {
        left: calc(39% - 16px) !important;
        font-size: 12px;
    }

    .timeline .timeline-wrapper.timeline-inverted {
        padding-right: 0;
        padding-left: 90px;
    }

    .timeline .timeline-wrapper.timeline-inverted .timeline-panel {
        margin-left: auto;
        margin-right: 11%;
    }

    .timeline .timeline-wrapper.timeline-inverted .timeline-panel:after {
        border-left-width: 0;
        border-right-width: 14px;
        left: -14px;
        right: auto;
    }

    @media (max-width: 767px) {
        .timeline .timeline-wrapper {
            padding-right: 150px;
        }

        .timeline .timeline-wrapper.timeline-inverted {
            padding-left: 150px;
        }

        .timeline .timeline-wrapper .timeline-panel {
            width: 60%;
            margin-left: 0;
            margin-right: 0;
        }
    }

    @media (max-width: 576px) {
        .timeline .timeline-wrapper .timeline-panel {
            width: 68%;
        }
    }

    .timeline-wrapper-primary .timeline-panel:before {
        background: #464dee;
    }

    .timeline-wrapper-primary .timeline-badge {
        background: #464dee;
    }

    .timeline-wrapper-secondary .timeline-panel:before {
        background: #6c7293;
    }

    .timeline-wrapper-secondary .timeline-badge {
        background: #6c7293;
    }

    .timeline-wrapper-success .timeline-panel:before {
        background: #0ddbb9;
    }

    .timeline-wrapper-success .timeline-badge {
        background: #0ddbb9;
    }

    .timeline-wrapper-info .timeline-panel:before {
        background: #0ad7f7;
    }

    .timeline-wrapper-info .timeline-badge {
        background: #0ad7f7;
    }

    .timeline-wrapper-warning .timeline-panel:before {
        background: #fcd539;
    }

    .timeline-wrapper-warning .timeline-badge {
        background: #fcd539;
    }

    .timeline-wrapper-danger .timeline-panel:before {
        background: #ef5958;
    }

    .timeline-wrapper-danger .timeline-badge {
        background: #ef5958;
    }

    .timeline-wrapper-light .timeline-panel:before {
        background: #eaeaea;
    }

    .timeline-wrapper-light .timeline-badge {
        background: #eaeaea;
    }

    .timeline-wrapper-dark .timeline-panel:before {
        background: #001737;
    }

    .timeline-wrapper-dark .timeline-badge {
        background: #001737;
    }
</style>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<!-- START SECTION HEADER -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Laporan Patroli</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Laporan</a></li>
                    <li class="breadcrumb-item"><a href="">Laporan Patroli</a></li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- END SECTION HEADER -->

<!--START SECTION CONTENT-->
<section class="content">
    <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-md-4">
                <!-- TABLE: LATEST ORDERS -->
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Detail Laporan Patroli</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-4">
                        <table class="table table-sm table-striped">
                            <tbody>

                            </tbody>
                        </table>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-8">
                <!-- TABLE: LATEST ORDERS -->
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Detail Timeline</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-4 overflow-auto" style="height: 75vh">

                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
</section>
<!--END SECTION CONTENT-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js" integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $(function() {
        moment.locale('id'); // id
        var start = moment().subtract(3, 'days');
        var end = moment();

    });
</script>