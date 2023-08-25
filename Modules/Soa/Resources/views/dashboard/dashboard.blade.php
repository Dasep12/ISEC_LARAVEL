@extends('soa::layouts.template')

@section('content')
<style>
    .modal-dialog {
        max-width: 100% !important;
        max-height: auto !important;
    }

    .modal {
        padding-right: 20px !important;
        padding-left: 20px !important;
    }

    .modal-body {
        position: relative;
        overflow-y: auto;
    }

    .modal-fullscreen-xl .card-hor {
        height: 350px !important;
    }
</style>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">

            </div>
        </div>
    </div>
</section>


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card cardIn2">
                    <div class="card-body">
                        <form id="form-filter" class="form-horizontal">
                            <div class="form-row">
                                <div class="form-group col-2">
                                    <label for="areaFilter">Area</label>
                                    <select name="areaFilter" id="areaFilter" class="form-control">
                                        <option value="">Select Plant</option>
                                        <?php
                                        foreach ($plant as $pl) { ?>
                                            <option value="<?= $pl->id ?>"><?= $pl->title ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group col-2">
                                    <label for="yearFilter">Year</label>
                                    <select name="yearFilter" id="yearFilter" class="form-control">
                                        <?php for ($i = 2022; $i <= date('Y') + 3; $i++) : ?>
                                            <option <?= $i == (int) date('Y') ? 'selected' : '' ?> value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor ?>
                                    </select>
                                </div>
                                <div class="form-group col-2">
                                    <label for="monthFilter">Month</label>
                                    <select name="monthFilter" id="monthFilter" class="form-control">
                                        <option selected value="">Select Month</option>
                                        <?php for ($i = 1; $i <= count($month); $i++) : ?>
                                            <option value="<?= $i ?>"><?= $month[$i] ?></option>
                                        <?php endfor ?>
                                    </select>
                                </div>

                                <div class="form-group col d-flex align-items-end justify-content-end">
                                    <span class="h3 ff-fugazone title-dashboard">Security Operational Analytic</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-ver">
                            <div class="card-body people" style="cursor:pointer">
                                <div style="position: absolute;left:50%;top:40%" class="row justify-content-center loader">
                                    <div class="overlay" style="display:block" id="totalPeople">
                                        <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                    </div>
                                </div>
                                <div class="img">
                                    <img src="{{ asset('assets/images/icon/soa/ancestors.png') }}">
                                </div>
                                <div class="text">
                                    <span class="title">PEOPLE</span>
                                    <span id="peopleTotal" class="value">0</span>
                                    <span>Visit</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card card-ver">
                            <div class="card-body vehicle" style="cursor:pointer">
                                <div style="position: absolute;left:50%;top:40%" class="row justify-content-center loader">
                                    <div class="overlay" style="display:block" id="totalVehicle">
                                        <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                    </div>
                                </div>
                                <div class="img">
                                    <img src="{{ asset('assets/images/icon/soa/pollution.png') }}">
                                </div>
                                <div class="text">
                                    <span class="title">VEHICLE</span>
                                    <span id="vehicleTotal" class="value">0</span>
                                    <span>Unit</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card card-ver">
                            <div class="card-body document" style="cursor:pointer">
                                <div style="position: absolute;left:50%;top:40%" class="row justify-content-center loader">
                                    <div class="overlay" style="display:block" id="totalDocument">
                                        <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                    </div>
                                </div>
                                <div class="img">
                                    <img src="{{ asset('assets/images/icon/soa/folder.png') }}">
                                </div>
                                <div class="text">
                                    <span class="title">DOCUMENT</span>
                                    <span id="materialTotal" class="value">0</span>
                                    <span>Document</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="card people-perday" style="height: 363px;">
                    <div class="card-header">
                        <h5></h5>
                    </div>
                    <div class="card-body">
                        <div style="position: absolute;left:50%;top:40%" class="row justify-content-center loader">
                            <div class="overlay" style="display:block" id="traficAllLoader">
                                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                            </div>
                        </div>
                        <div id="traficAll"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card people-perday" style="height: 363px;">
                    <div class="card-header">
                        <h5 id="headerDay">Traffic people per day</h5>
                    </div>
                    <div class="card-body">
                        <div style="position: absolute;left:50%;top:40%" class="row justify-content-center loader">
                            <div class="overlay" style="display:block" id="traficdayLoader">
                                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                            </div>
                        </div>
                        <div id="traficDay"></div>
                    </div>
                </div>
            </div>


            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card card-hor">
                            <div class="card-body text-center">
                                <div style="position: absolute;left:50%;top:50%" class="row justify-content-center loader">
                                    <div class="overlay" style="display:block" id="trafikVehicle">
                                        <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                    </div>
                                </div>
                                <div id="vehicle"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card card-hor">
                            <div class="card-body text-center">
                                <div style="position: absolute;left:50%;top:50%" class="row justify-content-center loader">
                                    <div class="overlay" style="display:block" id="traficpeople">
                                        <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                    </div>
                                </div>
                                <div id="people"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card card-hor">
                            <div class="card-body text-center">
                                <div style="position: absolute;left:50%;top:50%" class="row justify-content-center loader">
                                    <div class="overlay" style="display:block" id="trafikmaterial">
                                        <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                    </div>
                                </div>
                                <div id="material"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade modal-fullscreen-xl" id="myModal" tabindex="-1" role="dialog" aria-labelledby="detailGrapLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailGrapLabel">Graphic Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card card-hor" style="">
                                <div class="card-body text-center">
                                    <div style="position: absolute;left:50%;top:30%" class="row justify-content-center loader">
                                        <div class="overlay" style="display:block" id="yearAdmLoader">
                                            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                        </div>
                                    </div>
                                    <div id="yearAdmPlant"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="card card-hor" style="">
                                <div class="card-body text-center">
                                    <div style="position: absolute;left:40%;top:40%" class="row justify-content-center loader">
                                        <div class="overlay" style="display:block" id="monthlyADMLoader">
                                            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                        </div>
                                    </div>
                                    <div id="pkbSetahun"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card card-hor" style="">
                                <div class="card-body text-center">
                                    <div style="position: absolute;left:50%;top:30%" class="row justify-content-center loader">
                                        <div class="overlay" style="display:block" id="yearAdmLoader">
                                            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                        </div>
                                    </div>
                                    <div id="bydepartement"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card card-hor" style="">
                                <div class="card-body text-center">
                                    <div style="position: absolute;left:40%;top:40%" class="row justify-content-center loader">
                                        <div class="overlay" style="display:block" id="monthlyADMLoader">
                                            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                        </div>
                                    </div>
                                    <div id="byuserCreate"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<script>
    $(function(e) {
        let isTraffic = 'people';
        var field = [
            area = $("#areaFilter").val(),
            year = $("#yearFilter").val(),
            month = $("#monthFilter").val(),
            peopleTotal = $("#peopleTotal"),
            vehicleTotal = $("#vehicleTotal"),
            materialTotal = $("#materialTotal"),
            employeeTotal = $("#employeeTotal"),
            visitorTotal = $("#visitorTotal"),
            bpTotal = $("#bpTotal"),
            contractorTotal = $("#contractorTotal"),
            peoplePerDay = $("#peoplePerDay"),
        ];
        people(field)
        vehicle(field)
        material(field)
        FpeopleCategori(field)
        FvehiclePie(field)
        FpiePeople(field)
        FpieMaterial(field)

        FtraficAll(field)

        $("#areaFilter, #yearFilter, #monthFilter").change(function(e) {
            var field = [
                area = $("#areaFilter").val(),
                year = $("#yearFilter").val(),
                month = $("#monthFilter").val()
            ];
            people(field);
            vehicle(field)
            material(field)
            FvehiclePie(field)
            FpiePeople(field)
            FpieMaterial(field)
            FtraficAll(field)

            if (isTraffic == 'people') {
                FpeopleCategori(field);
            } else if (isTraffic == 'vehicle') {
                FvehicleCategori(field)
            }
        })

        // Trafice Days Update
        $(".people").on('click', function() {
            var field = [
                year = $("#yearFilter").val(),
                month = $("#monthFilter").val(),
                area = $("#areaFilter").val(),
            ]

            isTraffic = 'people';
            FpeopleCategori(field)
        })

        $(".vehicle").on('click', function() {
            var field = [
                year = $("#yearFilter").val(),
                month = $("#monthFilter").val(),
                area = $("#areaFilter").val(),
            ]
            isTraffic = 'vehicle';
            FvehicleCategori(field)
        })

        $(".document").on('click', function() {
            var field = [
                year = $("#yearFilter").val(),
                month = $("#monthFilter").val(),
                area = $("#areaFilter").val(),
            ]
            isTraffic = 'document';
            FdocumentCategori(field)
        })
    })

    function people(field) {
        $.ajax({
            url: 'peopleAll',
            type: 'POST',
            data: {
                area_fil: area,
                year_fil: year,
                month_fil: month,
                "_token": "{{ csrf_token() }}",
            },
            cache: false,
            beforeSend: function() {
                document.getElementById("totalPeople").style.display = "block";
            },
            complete: function() {
                document.getElementById("totalPeople").style.display = "none";
            },
            success: function(res) {
                peopleTotal.text(res[0].total_people)
            }
        });
    }

    function vehicle(field) {
        $.ajax({
            url: 'vehicleAll',
            type: 'POST',
            data: {
                area_fil: area,
                year_fil: year,
                month_fil: month,
                "_token": "{{ csrf_token() }}",
            },
            cache: false,
            beforeSend: function() {
                // $(".lds-ring").show();
                document.getElementById("totalVehicle").style.display = "block";
            },
            complete: function() {
                document.getElementById("totalVehicle").style.display = "none";
            },
            success: function(res) {
                // var json = JSON.parse(res)
                vehicleTotal.text(res[0].total)
            }
        });
    }

    function material(field) {
        $.ajax({
            url: 'documentAll',
            type: 'POST',
            data: {
                area_fil: area,
                year_fil: year,
                month_fil: month,
                "_token": "{{ csrf_token() }}",
            },
            cache: false,
            beforeSend: function() {
                // $(".lds-ring").show();
                document.getElementById("totalDocument").style.display = "block";
            },
            complete: function() {
                document.getElementById("totalDocument").style.display = "none";
            },
            success: function(res) {
                materialTotal.text(res[0].total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'))
                // materialTotal.text(300)
            }
        });
    }

    var traficAll = Highcharts.chart('traficAll', {
        chart: {
            type: 'spline',
            backgroundColor: 'transparent',
            height: 320,
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        credits: {
            enabled: false
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        legend: {
            itemStyle: {
                color: '#000000',
                fontWeight: 'bold'
            }
        },
        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                },
                marker: {
                    fillColor: '#FFFFFF',
                    lineWidth: 4,
                    lineColor: null // inherit from series
                }
            }
        },
        series: [{
            name: 'People',
            data: [12, 12, 31, 4, 26, 72, 82, 51, 8, 4, 22, 23],
            // data: [],
        }, {
            name: 'Vehicle',
            // data: [],
            data: [12, 12, 31, 4, 26, 72, 82, 51, 8, 4, 22, 23],
        }, {
            name: 'Document',
            // data: [],
            data: [12, 12, 31, 4, 26, 72, 82, 51, 8, 4, 22, 23],
        }]
    });

    function FtraficAll(field) {
        $.ajax({
            url: "grapichSetahun",
            method: "POST",
            data: {
                year: year,
                plant: area,
                "_token": "{{ csrf_token() }}",
            },
            cache: false,
            beforeSend: function() {
                document.getElementById("traficAllLoader").style.display = "block";
            },
            complete: function() {
                document.getElementById("traficAllLoader").style.display = "none";
            },
            success: function(res) {
                let data = res;
                // console.log(data)
                let color = ["#bf061e", "#10d5eb", "#c9c016"];
                for (let i = 0; i < data.length; i++) {
                    traficAll.series[i].update({
                        name: data[i].label,
                        data: data[i].data,
                        color: color[i],
                        lineWidth: 2.5
                    });
                }
            }
        })
    }



    let cate = [];
    for (let i = 1; i <= 31; i++) {
        cate.push(i);
    }

    var traficLine = Highcharts.chart('traficDay', {
        chart: {
            type: 'spline',
            backgroundColor: 'transparent',
            height: 320,
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: cate
        },
        credits: {
            enabled: false
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        legend: {
            itemStyle: {
                color: '#000000',
                fontWeight: 'bold'
            }
        },
        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                },
                marker: {
                    fillColor: '#FFFFFF',
                    lineWidth: 4,
                    lineColor: null // inherit from series
                }
            }
        },
        series: [{
            name: 'Business Partner',
            data: [],
        }, {
            name: 'Contractor',
            data: [],
        }, {
            name: 'Visitor',
            data: [],
        }]
    });

    // trafic days people
    function FpeopleCategori(field) {
        $.ajax({
            url: 'peopleDays',
            type: 'POST',
            data: {
                area_fil: area,
                year_fil: year,
                month_fil: month,
                "_token": "{{ csrf_token() }}",
            },
            cache: false,
            beforeSend: function() {
                document.getElementById("traficdayLoader").style.display = "block";
            },
            complete: function() {
                document.getElementById("traficdayLoader").style.display = "none";
            },
            success: function(res) {
                var seriesLength = traficLine.series.length;
                for (var i = seriesLength - 1; i > -1; i--) {
                    traficLine.series[i].remove();
                }

                document.getElementById("headerDay").innerHTML = "Traffic People";
                let data = res;
                let datas = [];
                for (let i = 0; i < data.length; i++) {
                    traficLine.addSeries({
                        name: data[i].label,
                        data: []
                    });
                    traficLine.series[i].update({
                        data: data[i].data,
                        name: data[i].label,
                        lineWidth: 2.5
                    });
                }
            }
        });
    }

    // trafic days vehicle
    function FvehicleCategori(field) {
        $.ajax({
            url: 'vehicleDays',
            type: 'POST',
            data: {
                area_fil: area,
                year_fil: year,
                month_fil: month,
                "_token": "{{ csrf_token() }}",
            },
            cache: false,
            beforeSend: function() {
                document.getElementById("traficdayLoader").style.display = "block";
            },
            complete: function() {
                document.getElementById("traficdayLoader").style.display = "none";
            },
            success: function(res) {
                var seriesLength = traficLine.series.length;
                for (var i = seriesLength - 1; i > -1; i--) {
                    traficLine.series[i].remove();
                }
                document.getElementById("headerDay").innerHTML = "Traffic Vehicle";
                let data = res;
                let datas = [];
                for (let i = 0; i < data.length; i++) {

                    traficLine.addSeries({
                        name: data[i].label,
                        data: []
                    });
                    traficLine.series[i].update({
                        data: data[i].data,
                        name: data[i].label,
                        lineWidth: 2.5
                    });
                }
            }
        });
    }

    // trafic days document
    function FdocumentCategori(field) {
        $.ajax({
            url: 'documentDays',
            type: 'POST',
            data: {
                area_fil: area,
                year_fil: year,
                month_fil: month,
                "_token": "{{ csrf_token() }}",
            },
            cache: false,
            beforeSend: function() {
                document.getElementById("traficdayLoader").style.display = "block";
            },
            complete: function() {
                document.getElementById("traficdayLoader").style.display = "none";
            },
            success: function(res) {

                let data = res;
                var seriesLength = traficLine.series.length;
                for (var i = seriesLength - 1; i > -1; i--) {
                    traficLine.series[i].remove();
                }

                document.getElementById("headerDay").innerHTML = "Traffic Document";
                let datas = [];
                for (let i = 0; i < data.length; i++) {
                    traficLine.addSeries({
                        name: data[i].label,
                        data: []
                    });
                    traficLine.series[i].update({
                        data: data[i].data,
                        name: data[i].label,
                        lineWidth: 2.5
                    });
                }
            }
        });
    }


    var vehiclePie = Highcharts.chart('vehicle', {
        chart: {
            type: 'pie',
            // options3d: {
            //     enabled: true,
            //     alpha: 45
            // },
            backgroundColor: 'transparent',
            // size: 200,

        },
        title: {
            text: 'VEHICLE',
            align: 'center',
            useHTML: true,
            style: {
                color: '#000',
                fontWeight: 'bold',
            }
        },
        credits: {
            enabled: false
        },
        subtitle: {
            text: '',
            align: 'left'
        },
        plotOptions: {
            pie: {
                size: 170,
                showInLegend: true,
                depth: 30,
                allowPointSelect: true,
                cursor: "pointer",
                dataLabels: {
                    enabled: true,
                    // distance: -60,
                    color: "white",
                    formatter: function() {
                        return '<b>' + Highcharts.numberFormat(this.point.y, 0, '.', ',') + '<b>';
                    }
                }
            },
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px"></span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
        },
        series: [{
            data: [{
                name: 'D',
                y: 10
            }]
        }]
    });

    function FvehiclePie(field) {
        $.ajax({
            url: 'vehicleCategory',
            type: 'POST',
            data: {
                area_fil: area,
                year_fil: year,
                month_fil: month,
                "_token": "{{ csrf_token() }}",
            },
            cache: false,
            beforeSend: function() {
                document.getElementById("trafikVehicle").style.display = "block";
            },
            complete: function() {
                document.getElementById("trafikVehicle").style.display = "none";
            },
            success: function(res) {
                let data = res;
                var seriesLength = vehiclePie.series.length;
                for (var i = seriesLength - 1; i > -1; i--) {
                    vehiclePie.series[i].remove();
                }
                let datas = [];
                for (let i = 0; i < data.length; i++) {
                    datas.push({
                        name: data[i].label,
                        y: parseInt(data[i].total)
                    });
                }
                vehiclePie.addSeries({
                    data: datas
                });

            }
        });
    }

    var piePeople = Highcharts.chart('people', {
        chart: {
            type: 'pie',
            // options3d: {
            //     enabled: true,
            //     alpha: 45
            // },
            backgroundColor: 'transparent',
            // size: 200,

        },
        title: {
            text: 'PEOPLE',
            align: 'center',
            useHTML: true,
            style: {
                color: '#000',
                fontWeight: 'bold',
            }
        },
        credits: {
            enabled: false
        },
        subtitle: {
            text: '',
            align: 'left'
        },
        plotOptions: {
            pie: {
                showInLegend: true,
                size: 170,
                depth: 30,
                allowPointSelect: true,
                cursor: "pointer",
                dataLabels: {
                    enabled: true,
                    // distance: -60,
                    color: "white",
                    formatter: function() {
                        return '<b>' + Highcharts.numberFormat(this.point.y, 0, '.', ',') + '<b>';
                    }
                }
            },
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px"></span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
        },
        series: [{
            name: 'Medals',
            data: [{
                name: 'D',
                y: 10
            }]
        }]
    });

    function FpiePeople(field) {
        $.ajax({
            url: 'peopleCategory',
            type: 'POST',
            data: {
                area_fil: area,
                year_fil: year,
                month_fil: month,
                "_token": "{{ csrf_token() }}",
            },
            cache: false,
            beforeSend: function() {
                document.getElementById("traficpeople").style.display = "block";
            },
            complete: function() {
                document.getElementById("traficpeople").style.display = "none";
            },
            success: function(res) {

                let data = res;
                var seriesLength = piePeople.series.length;
                for (var i = seriesLength - 1; i > -1; i--) {
                    piePeople.series[i].remove();
                }
                let datas = [];
                for (let i = 0; i < data.length; i++) {
                    datas.push({
                        name: data[i].title,
                        y: parseInt(data[i].total_kehadiran)
                    });
                }
                piePeople.addSeries({
                    data: datas
                });

            }
        });
    }

    var pieMaterial = Highcharts.chart('material', {
        chart: {
            type: 'pie',
            // options3d: {
            //     enabled: true,
            //     alpha: 45
            // },
            backgroundColor: 'transparent',
            size: 200,

        },
        credits: {
            enabled: false
        },
        title: {
            text: 'DOCUMENT',
            align: 'center',
            useHTML: true,
            style: {
                color: '#000',
                fontWeight: 'bold',
            }
        },
        subtitle: {
            text: '',
            align: 'left'
        },
        plotOptions: {
            pie: {
                showInLegend: true,
                size: 170,
                depth: 30,
                allowPointSelect: true,
                cursor: "pointer",
                dataLabels: {
                    enabled: true,
                    // distance: -60,
                    color: "white",
                    formatter: function() {
                        return '<b>' + Highcharts.numberFormat(this.point.y, 0, '.', ',') + '<b>';
                    }
                },
            },
            series: {
                point: {
                    events: {
                        click: function() {
                            if (this.name.toLowerCase() == 'pkb') {
                                $('#myModal').modal({
                                    backdrop: 'static',
                                    keyboard: false
                                }, 'show');
                            }
                        }
                    }
                }
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px"></span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
        },
        series: [{
            name: 'Medals',
            data: [{
                name: 'PKO',
                y: 10,
                id: 'pko'
            }, {
                name: 'PKB',
                y: 20,
                id: 'pkb'
            }, {
                name: 'Surat Jalan',
                y: 5,
                id: 'sj'
            }],
            point: {
                events: {
                    click: function(event) {
                        console.log(this.id)
                        // if (this.id == 'pkb') {
                        //     $('#myModal').modal('show');
                        // }
                    }
                }
            }
        }]
    });

    function FpieMaterial(field) {
        $.ajax({
            url: 'documentCategory',
            type: 'POST',
            data: {
                area_fil: area,
                year_fil: year,
                month_fil: month,
                "_token": "{{ csrf_token() }}",
            },
            cache: false,
            beforeSend: function() {
                document.getElementById("trafikmaterial").style.display = "block";
            },
            complete: function() {
                document.getElementById("trafikmaterial").style.display = "none";
            },
            success: function(res) {
                let data = res;
                console.log(data)
                var seriesLength = pieMaterial.series.length;
                for (var i = seriesLength - 1; i > -1; i--) {
                    pieMaterial.series[i].remove();
                }
                let datas = [];
                for (let i = 0; i < data.length; i++) {
                    datas.push({
                        name: data[i].title,
                        y: parseInt(data[i].total),
                        id: data[i].title.toLowerCase
                    });
                }
                pieMaterial.addSeries({
                    data: datas
                });

            }
        });
    }


    // PKB

    var traficPKB = Highcharts.chart('pkbSetahun', {
        chart: {
            type: 'line',
            backgroundColor: 'transparent',
            height: 320,
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        credits: {
            enabled: false
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        legend: {
            itemStyle: {
                color: '#000000',
                fontWeight: 'bold'
            }
        },
        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                },
                marker: {
                    fillColor: '#FFFFFF',
                    lineWidth: 4,
                    lineColor: null // inherit from series
                }
            }
        },
        series: [{
            name: 'P1',
            data: [12, 12, 32, 4, 26, 12, 13, 51, 8, 3, 20, 40],
        }, {
            name: 'P2',
            data: [19, 12, 11, 20, 26, 75, 20, 51, 8, 41, 34, 10],
        }, {
            name: 'P3',
            data: [25, 18, 19, 35, 26, 22, 19, 51, 8, 32, 40, 23],
        }, {
            name: 'P4',
            data: [80, 16, 20, 67, 26, 20, 10, 51, 8, 11, 90, 15],
        }, {
            name: 'P5',
            data: [19, 13, 60, 32, 26, 30, 40, 51, 8, 18, 12, 70],
        }, {
            name: 'HO',
            data: [12, 12, 30, 14, 26, 72, 32, 51, 8, 27, 29, 23],
        }]
    });

    function FtraficPKB() {
        var seriesLength = traficPKB.series.length;
        for (var i = seriesLength - 1; i > -1; i--) {
            traficPKB.series[i].remove();
        }
        let res = [{
            label: 'P1',
            data: [1, 2, 3, 4, 5, 7, 25, 3, 21]
        }, {
            label: 'P2',
            data: [3, 6, 3, 9, 15, 7, 15, 23, 24]
        }]
        document.getElementById("headerDay").innerHTML = "Traffic People";
        let data = res;
        let datas = [];
        for (let i = 0; i < data.length; i++) {
            traficPKB.addSeries({
                name: data[i].label,
                data: []
            });
            traficPKB.series[i].update({
                data: data[i].data,
                name: data[i].label,
                lineWidth: 2.5
            });
        }
    }
    FtraficPKB()

    var yearPKB = new Highcharts.Chart({
        chart: {
            renderTo: 'yearAdmPlant',
            type: 'pie',
            height: 320,
        },
        plotOptions: {
            pie: {
                innerSize: '60%',
                showInLegend: true,
                dataLabels: {
                    enabled: true,
                    color: "white",
                    formatter: function() {
                        return '<b>' + Highcharts.numberFormat(this.point.y, 0, '.', ',') + '<b>';
                    }
                },
            },
        },
        title: {
            verticalAlign: 'middle',
            // floating: true,
            text: '4000',
            x: -4,
            y: -15
        },
        credits: {
            enabled: false
        },
        series: [{
            data: [{
                    name: 'P1',
                    y: 2262
                },
                {
                    name: 'P2',
                    y: 3800
                },
                {
                    name: 'P3',
                    y: 1000
                },
                {
                    name: 'P4',
                    y: 1986
                },
                {
                    name: 'P4',
                    y: 1986
                }, {
                    name: 'P5',
                    y: 2006
                }, {
                    name: 'HO',
                    y: 2020
                },
            ],
        }, ],
    });


    var departementGraph = new Highcharts.Chart({
        chart: {
            renderTo: 'bydepartement',
            type: 'column',
        },
        xAxis: {
            categories: ['DPT PE KARAWANG ASSY', 'DPT LOGISTIC ASSY', 'DPT GA Operation 1', 'DPT GA Operation 2', 'DPT WARRANTY & QUALITY SYSTEM']
        },
        yAxis: {
            title: {
                enabled: false
            }
        },
        credits: {
            enabled: false
        },
        tooltip: {
            headerFormat: '<b>{point.key}</b><br>',
            pointFormat: '{point.y}'
        },
        title: {
            text: 'By Departement',
            align: 'center'
        },
        subtitle: {
            text: '',
            align: 'left'
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            column: {
                depth: 25
            }
        },
        series: [{
            data: [1318, 1073, 1010, 813, 775],
            colorByPoint: true
        }]
    });

    var userGraph = new Highcharts.Chart({
        chart: {
            renderTo: 'byuserCreate',
            type: 'column',
        },
        xAxis: {
            categories: ['ANGGA ERI MUHARA ', 'MULYADI', 'HARI AKHWANUDIN  ', 'RIDWAN TAUFIK ', 'TRIANDIKA ALVIANTO']
        },
        yAxis: {
            title: {
                enabled: false
            }
        },
        credits: {
            enabled: false
        },
        tooltip: {
            headerFormat: '<b>{point.key}</b><br>',
            pointFormat: '{point.y}'
        },
        title: {
            text: 'By User',
            align: 'center'
        },
        subtitle: {
            text: '',
            align: 'left'
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            column: {
                depth: 25,
                borderRadius: '25%'
            }
        },
        series: [{
            data: [1318, 1073, 1010, 813, 775],
            colorByPoint: true
        }]
    });
    // 
</script>
@endsection