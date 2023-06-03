@extends('guardtour::layouts.master')

@section('content')
<style xmlns="http://www.w3.org/1999/html">
    .ui-datepicker-calendar {
        display: none;
    }

    .ui-datepicker {
        padding-bottom: 0.2em !important;
        font-size: 10px;
    }

    .boderSelect {
        border: 1px solid #007bff;
        color: #007bff;
    }

    .hidden {
        display: none
    }

    .table-condensed thead .prev,
    .table-condensed thead .next {
        display: none !important;
    }
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Analityc Security Guard Tour</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#"></a></li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card3">
                    <div class="card-body">
                        <form id="form-filter" class="form-horizontal">
                            <div class="form-row text-white">
                                <div class="form-group col-2">
                                    <label for="yearFilter">Year</label>
                                    <select class="form-control" name="yearFilter" id="yearFilter">
                                        <?php for ($i = 22; $i <= 26; $i++) : ?>
                                            <option <?= 20 . $i == date('Y') ? 'selected' : '' ?>>20<?= $i ?></option>
                                        <?php endfor ?>
                                    </select>
                                </div>

                                <div class="form-group col-2">
                                    <label for="monthFilter">Month</label>
                                    <select class="form-control" name="monthFilter" id="monthFilter">
                                        <?php
                                        $k = 1;
                                        for ($i = 1; $i <= count($select_month_filter); $i++) { ?>
                                            <option <?= $k == date('m') ? 'selected' : '' ?> value="<?= $k++ ?>"><?= $select_month_filter[$i] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group col-2">
                                    <label for="areaFilter">Area</label>
                                    <select class="form-control" name="areaFilter" id="areaFilter">
                                        <option value="0">All Plant</option>
                                        <?php
                                        foreach ($plant as $pl) { ?>
                                            <option value="<?= $pl->plant_id ?>"><?= $pl->plant_name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group col d-flex align-items-end justify-content-end">
                                    <span class="fw-bold fw-italic h1">Guard Tour Dashboard</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card3">
                    <div class="card-body">

                        <div style="position: absolute;left:50%;top:50%" class="row justify-content-center loader">
                            <div class="overlay" style="display:none" id="chartTrendPatrolPerPlant_overlay">
                                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                            </div>
                        </div>
                        <!-- <div class="row">
							<input type="hidden" value="<?= date('Y') ?>" id="valDatepickerYearTrendPatroli">
							<span style="cursor:pointer" id="datepickerYearTrendPatroli" class="commentsToggle text-primary">
								<i class="fa fa-ellipsis-v"></i>
							</span>
						</div> -->
                        <div class="justify-content-center">
                            <div class="col-lg-12">
                                <div class="chart">
                                    <div id="chartLinePatrolAllPerPlant" style="height: 380px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card3">
                    <div class="card-body">
                        <div style="position: absolute;left:50%;top:50%" class="row justify-content-center loader">
                            <div class="overlay" style="display:none" id="chartTrenPatrolAllPlant_overlay">
                                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                            </div>
                        </div>
                        <!-- <div class="row">
							<span style="cursor:pointer" class="commentsToggle text-primary">
								<i class="fa fa-ellipsis-v"></i>
							</span>
						</div> -->

                        <div class="justify-content-center">
                            <div class="chart">
                                <div id="chartTrenPatrolAllPlant" style="height: 380px;"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-12">
                <div class="card card3">
                    <div class="card-body">
                        <div style="position: absolute;left:50%;top:50%" class="row justify-content-center loader">
                            <div class="overlay" style="display:none" id="chartTrendPatrolHarian_overlay">
                                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                            </div>
                        </div>
                        <!-- <div class="row">
							<input type="hidden" value="<?= date('m') <= 9 ? date('m') : '0' .  date('m') ?>" id="valDatepickerMonthTrendPatroli">
							<span style="cursor:pointer" id="datepickerMonthTrendPatroli" class="text-primary commentsToggle">
								<i class="fa fa-ellipsis-v"></i>
							</span>
						</div> -->
                        <div class="chart">
                            <div id="patroliHarian" style="height: 300px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card card3">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div style="position: absolute;left:50%;top:50%" class="row justify-content-center loader">
                            <div class="overlay" style="display:none" id="chartPerformanceAllPlantADM_overlay">
                                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                            </div>
                        </div>
                        <!-- <div class="row">
							<input type="hidden" value="<?= date('Y') ?>" id="valDatepickerYearPerformPatroli">
							<span style="cursor:pointer" id="datepickerYearPerformPatroli" class=" text-primary commentsToggle">
								<i class="fa fa-ellipsis-v"></i>
							</span>
						</div> -->
                        <div class="justify-content-center">
                            <div class="col-lg-12">
                                <div class="chart">
                                    <div id="chartPerformanceAllLine" style="height: 380px;"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card3">
                    <div class="card-body">
                        <div style="position: absolute;left:50%;top:50%" class="row justify-content-center loader">
                            <div class="overlay" style="display:none" id="tahunPerformance_overlay">
                                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                            </div>
                        </div>
                        <!-- <div class="row">
							<input type="hidden" value="<?= date('m') <= 9 ? date('m') : '0' .  date('m') ?>" id="valDatepickerMonthPerformPatroli">
							<span style="cursor:pointer" id="datepickerMonthPerformPatroli" class="text-primary commentsToggle">
								<i class="fa fa-ellipsis-v"></i>
							</span>
						</div> -->
                        <div class="chart">
                            <div id="PerformancePatrolHarian" style="height: 380px;"></div>
                        </div>
                        <!-- /.chart-responsive -->
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card3">
                    <div class="card-body">
                        <div style="position: absolute;left:50%;top:50%" class="row justify-content-center loader">
                            <div class="overlay" style="display:block" id="chartPerformancePerPlant_overlay">
                                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                            </div>
                        </div>
                        <!-- <div class="row ">
							<span style="cursor:pointer" class="text-primary commentsToggle">
								<i class="fa fa-ellipsis-v"></i>
							</span>
						</div> -->
                        <div class="justify-content-center">
                            <div class="chart">
                                <div id="chartPerformanceAllBar" style="height: 380px;"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card card3">
                    <div class="card-body">
                        <div style="position: absolute;left:50%;top:50%" class="row justify-content-center loader">
                            <div class="overlay" style="display:none" id="chartTemuanADM_overlay">
                                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                            </div>
                        </div>

                        <div class="chart">
                            <div id="chartTemuanADM" style="height: 330px;"></div>
                        </div>
                    </div>
                </div>
                <!-- /.chart-responsive -->
            </div>
            <div class="col-md-6">
                <div class="card card3">
                    <div class="card-body">
                        <div style="position: absolute;left:50%;top:50%" class="row justify-content-center loader">
                            <div class="overlay" style="display:none" id="chartTemuanRegu_overlay">
                                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                            </div>
                        </div>
                        <div class="chart">
                            <div id="chartTemuanRegu" style="height: 330px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="row">
			<div class="col-md-6">
				<div class="card">
					<div class="card-body">
						<div style="position: absolute;left:50%;top:50%" class="row justify-content-center loader">
							<div class="overlay" style="display:block" id="chartTemuanByUser_overlay">
								<i class="fas fa-2x fa-sync-alt fa-spin"></i>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-inline justify-content-center">
								<select style="border-radius: 0px;" name="tahun_patrol" class="form-control boderSelect" id="tahun_patrol">
									<option value="2022">PLANT 1</option>
									<option value="2023">PLANT 2</option>
									<option value="2024">PLANT 3</option>
									<option value="2025">PLANT 4 LINE 1</option>
								</select>
								<select style="border-radius: 0px;" name="tahun_patrol" class="form-control boderSelect" id="tahun_patrol">
									<option value="2022">2022</option>
									<option value="2023">2023</option>
									<option value="2024">2024</option>
									<option value="2025">2025</option>
								</select>
								<button style="border-radius: 0px;padding: 7px;margin-top:0.3px;height:38px" class="btn btn-outline btn-sm btn-primary" type="button">Filter</button>
							</div>
						</div>

						<div class="chart">
							<div id="chartCloseTemuan" style="height: 300px;"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card">
					<div class="card-body">
						<div style="position: absolute;left:50%;top:50%" class="row justify-content-center loader">
							<div class="overlay" style="display:block" id="chartTemuanByUser_overlay">
								<i class="fas fa-2x fa-sync-alt fa-spin"></i>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-inline justify-content-center">
								<select style="border-radius: 0px;" name="tahun_patrol" class="form-control boderSelect" id="tahun_patrol">
									<option value="2022">JANUARI</option>
									<option value="2023">FEBRUARI</option>
									<option value="2024">MARET</option>
									<option value="2025">APRIL</option>
								</select>
								<select style="border-radius: 0px;" name="tahun_patrol" class="form-control boderSelect" id="tahun_patrol">
									<option value="2022">2022</option>
									<option value="2023">2023</option>
									<option value="2024">2024</option>
									<option value="2025">2025</option>
								</select>
								<button style="border-radius: 0px;padding: 7px;margin-top:0.3px;height:38px" class="btn btn-outline btn-sm btn-primary" type="button">Filter</button>
							</div>
						</div>

						<div class="chart">
							<div id="chartCloseTemuan2" style="height: 300px;"></div>
						</div>
					</div>
				</div>
			</div>
		</div> -->
    </div>


</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js" integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
<script src="{{ asset('assets/dist/js/highcharts.js') }}"></script>
<script src="{{ asset('assets/dist/js/exporting.js') }}"></script>
<script src="{{ asset('assets/dist/js/export-data.js') }}"></script>
<script src="{{ asset('assets/dist/js/accessibility.js') }}"></script>
<script src="{{ asset('assets/dist/js/vendor/chart.js/Chart.min.js ') }}"></script>
<script src="{{ asset('assets/dist/js/vendor/chart.js/chartjs-plugin-colorschemes.min.js') }}"></script>
<script>
    var pl = <?= json_encode($plant) ?>;
    $('.commentsToggle').click(function() {
        // $(this).siblings(".comments").toggleClass('hidden');
        $(this).siblings(".comments").toggle('slow');
    });


    function tanggal(ttlHari) {
        const tgl = [];
        for (var i = 1; i <= ttlHari; i++) {
            tgl.push(i);
        }
        return tgl;
    }

    function convertMonth(bln) {
        let bulan = null;
        switch (bln) {
            case '1':
                bulan = 'January';
                break;
            case '2':
                bulan = 'February';
                break;
            case '3':
                bulan = 'March';
                break;
            case '4':
                bulan = 'April';
                break;
            case '5':
                bulan = 'May';
                break;
            case '6':
                bulan = 'June';
                break;
            case '7':
                bulan = 'July';
                break;
            case '8':
                bulan = 'August';
                break;
            case '9':
                bulan = 'September';
                break;
            case '10':
                bulan = 'October';
                break;
            case '11':
                bulan = 'November';
                break;
            case '12':
                bulan = 'December';
                break;
        }
        return bulan;
    }
    const month = [
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'May',
        'Jun',
        'Jul',
        'Aug',
        'Sep',
        'Oct',
        'Nov',
        'Dec'
    ];


    var commonOptionsPerformanceADM = {
        colors: ['#f68936', '#70ba47', '#33b5e6', '#fd8f40', '#e7ca60', '#40abaf', '#f6f7f8', '#e9e9eb'],
        chart: {
            style: {
                // fontFamily: 'Roboto Light',
                fontWeight: 'normal',
                fontSize: '12px',
                // color: '#585858',
                color: 'red',
            }
        },
        title: {
            text: null
        },
        subtitle: {
            text: null
        },
        credits: {
            enabled: false
        },
        exporting: {
            enabled: false
        },
        xAxis: {
            title: {
                style: {
                    // color: "#bbb",
                }
            },
            labels: {
                style: {
                    // color: '#bbb'
                },
            },
            lineWidth: 1,
            tickLength: 0,

        },
        yAxis: {
            title: {
                style: {
                    // fontFamily: 'Roboto',
                    // color: "#bbb",
                }
            },
            // offset: -6,
            labels: {
                style: {
                    // color: '#bbb'
                },
                //format:'{value}K',
            },
            tickInterval: 100,
            // lineWidth: 1,
            // gridLineDashStyle: 'dash',
        },
        series: [{
            //backgroundColor: "rgba(0 ,0, 0, 1)",
        }],

        // Area Chart
        plotOptions: {
            series: {
                fillOpacity: 0.1
            },
            area: {
                lineWidth: 1,
                marker: {
                    lineWidth: 2,
                    symbol: 'circle',
                    fillColor: 'white',
                    radius: 5,
                },
                legend: {
                    radius: 2,
                }
            }
        },
        tooltip: {
            useHTML: true,
            shared: true,
            backgroundColor: '#5f5f5f',
            borderWidth: 0,
            style: {
                padding: 10,
                color: '#fefefe',
            }
        },
        legend: {
            itemStyle: {
                fontFamily: 'Roboto Light',
                fontWeight: 'normal',
                fontSize: '12',
                color: '#666666',
            },
            marker: {
                symbol: 'square',
                verticalAlign: 'middle',
                radius: '4',
            },
            symbolHeight: 6,
            symbolWidth: 6,
        },
    };
    $('#chartLinePatrolAllPerPlant').each(function() {
        $(this).highcharts(Highcharts.merge(commonOptionsPerformanceADM, {
            chart: {
                type: 'area',
                // backgroundColor: 'transparent'
            },
            title: {
                text: 'Trend Patroli',
                style: {
                    // color: '#FFF',
                    font: 'bold 18px "Trebuchet MS", Verdana, sans-serif'
                }
            },
            legend: {
                enabled: false,
                itemStyle: {
                    fontSize: '35px',
                    font: '35pt Trebuchet MS, Verdana, sans-serif',
                    // color: '#FFF'
                },
            },
            subtitle: {
                text: 'Periode ' + <?= date('Y') ?>,
                style: {
                    // color: '#FFF',
                    font: 'bold 14px "Trebuchet MS", Verdana, sans-serif'
                }
            },
            xAxis: {
                categories: month,
            },
            yAxis: {
                title: {
                    style: {
                        // fontFamily: 'Roboto',
                        // color: "#bbb",
                    }
                },
                tickInterval: 25,
                min: 0,
                title: {
                    text: 'TOTAL'
                },
                labels: {
                    style: {
                        // color: '#FFF',
                        font: '11px Trebuchet MS, Verdana, sans-serif'
                    }
                },
            },
            series: [{
                name: 'Forwards',
                color: '#f68936',
                marker: {
                    lineColor: '#f68936',
                    fillColor: 'white',
                },
                data: [],
            }]
        }))

    });


    function charTrendPatrolPerPlant(tahun) {
        // var tahun = dp.datepicker('getDate').getFullYear();
        // var tahun = $("#tahun_trend_patrol_Perplant").val();
        $.ajax({
            url: "{{ route('Dashboard.trendPatrolBulananPerPlant') }}",
            method: "POST",
            data: {
                plant_id: '',
                tahun: tahun,
                "_token": "{{ csrf_token() }}",
            },
            beforeSend: function() {
                document.getElementById("chartTrendPatrolPerPlant_overlay").style.display = "block";
            },
            complete: function() {
                document.getElementById("chartTrendPatrolPerPlant_overlay").style.display = "none";
            },
            success: function(e) {
                var chartPatrolAll = $('#chartLinePatrolAllPerPlant').highcharts();
                var data = JSON.parse(e);
                chartPatrolAll.series[0].update({
                    name: data[0].name,
                    data: data[0].data,
                    // color: "#" + Math.floor(Math.random() * 16777215).toString(16)
                });
                chartPatrolAll.setTitle(null, {
                    text: 'Periode ' + tahun
                })
                chartPatrolAll.redraw();
            }
        })
    }
    charTrendPatrolPerPlant($("#yearFilter").val());

    var charTotalPatrolAllBar;
    charTotalPatrolAllBar = new Highcharts.chart({
        chart: {
            renderTo: 'chartTrenPatrolAllPlant',
            type: 'column',
            backgroundColor: 'transparent'
        },
        legend: {
            itemStyle: {
                fontSize: '10px',
                font: '10pt Trebuchet MS, Verdana, sans-serif',
                // color: '#FFF'
            },
            symbolHeight: 10,
            symbolWidth: 10,
        },
        title: {
            text: 'Trend Patroli',
            style: {
                // color: '#FFF',
                fontWeight: 'bold',
                fontSize: '18px',
                fontFamily: 'Trebuchet MS, Verdana, sans-serif'
            }
        },
        subtitle: {
            text: 'Periode' + <?= date('Y') ?>,
            style: {
                // color: '#FFF',
                fontWeight: 'bold',
                fontSize: '14px',
                fontFamily: 'Trebuchet MS, Verdana, sans-serif'
            }
        },
        xAxis: {
            categories: month,
            crosshair: true,
            labels: {
                style: {
                    // color: '#FFF',
                    font: '11px Trebuchet MS, Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            tickInterval: 25,
            min: 0,
            max: 10,
            title: {
                text: 'TOTAL'
            },
            labels: {
                style: {
                    // color: '#FFF',
                    font: '11px Trebuchet MS, Verdana, sans-serif'
                }
            },
            // gridLineDashStyle: 'dash',
        },
        tooltip: {
            backgroundColor: '#5f5f5f',
            borderWidth: 0,
            style: {
                padding: 10,
                color: '#fefefe',
            },
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0,
                events: {
                    legendItemClick: function() {
                        return false; // <== returning false will cancel the default action
                    }
                },
            }
        },
        exporting: {
            buttons: {
                contextButton: {
                    enabled: false
                },
            }
        },
        series: []
    });

    function charTrendPatrolAllD(tahun, plant) {
        var chartPatrolAll = $('#chartTrenPatrolAllPlant').highcharts();
        $.ajax({
            url: "{{ route('Dashboard.trendPatrolAllPlant') }}",
            method: "POST",
            data: {
                tahun: tahun,
                plant_id: plant,
                "_token": "{{ csrf_token() }}",
            },
            beforeSend: function() {
                document.getElementById("chartTrenPatrolAllPlant_overlay").style.display = "block";
            },
            complete: function() {
                document.getElementById("chartTrenPatrolAllPlant_overlay").style.display = "none";
            },
            success: function(e) {
                var data = JSON.parse(e);
                // console.log(data);
                var seriesLength = chartPatrolAll.series.length;
                for (var i = seriesLength - 1; i > -1; i--) {
                    chartPatrolAll.series[i].remove();
                }

                let series = [];
                for (let i = 0; i < data.length; i++) {
                    let dataR = [{
                        name: "",
                        data: []
                    }]
                    chartPatrolAll.addSeries({
                        data: dataR
                    });
                }
                var maxValue = [];
                for (let i = 0; i < data.length; i++) {
                    chartPatrolAll.series[i].update({
                        name: data[i].plant,
                        data: data[i].data,
                        // color: "#" + Math.floor(Math.random() * 16777215).toString(16)
                    });

                    maxValue.push(Math.max.apply(null, data[i].data));
                }
                chartPatrolAll.setTitle(null, {
                    text: 'Periode ' + tahun
                })
                var maxUpdate = Math.max.apply(null, maxValue)
                chartPatrolAll.yAxis[0].update({
                    min: 0,
                    max: maxUpdate + 50
                });


                chartPatrolAll.redraw();
            }
        })
    }
    charTrendPatrolAllD($("#yearFilter").val(), 0);
    // tren harian
    Highcharts.chart({
        chart: {
            renderTo: 'patroliHarian',
            type: 'area',
            backgroundColor: 'transparent'
        },
        legend: {
            itemStyle: {
                fontSize: '10px',
                font: '10pt Trebuchet MS, Verdana, sans-serif',
                // color: '#FFF'
            },
            marker: {
                symbol: 'square',
                verticalAlign: 'middle',
                radius: '4',
            },
            symbolHeight: 10,
            symbolWidth: 10,
        },
        title: {
            text: 'Patroli Harian',
            style: {
                // color: '#FFF',
                font: 'bold 18px "Trebuchet MS", Verdana, sans-serif'
            }
        },
        subtitle: {
            text: 'Periode ',
            style: {
                // color: '#FFF',
                font: 'bold 14px "Trebuchet MS", Verdana, sans-serif'
            }
        },
        xAxis: {
            categories: tanggal(<?= 28 ?>),
            labels: {
                style: {
                    // color: '#FFF',
                    font: '11px Trebuchet MS, Verdana, sans-serif'
                }
            },
        },
        yAxis: {
            title: {
                text: 'Total',
                labels: {
                    style: {
                        // color: '#FFF',
                        font: '11px Trebuchet MS, Verdana, sans-serif'
                    }
                },
            },
            labels: {
                style: {
                    // color: '#FFF',
                    font: '11px Trebuchet MS, Verdana, sans-serif'
                }
            },
            // gridLineDashStyle: 'dash',
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">Tanggal {point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true,
            backgroundColor: '#5f5f5f',
            borderWidth: 0,
            style: {
                padding: 10,
                color: '#fefefe',
            }
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0,
            },
            series: {
                fillOpacity: 0.1,
                events: {
                    legendItemClick: function() {
                        return false; // <== returning false will cancel the default action
                    }
                },
            },
            area: {
                lineWidth: 1,
                marker: {
                    lineWidth: 2,
                    symbol: 'circle',
                    // fillColor: 'red',
                    radius: 6,
                },
                legend: {
                    radius: 2,
                }
            }
        },
        exporting: {
            buttons: {
                contextButton: {
                    enabled: false
                },
            }
        },
        series: []

    });

    function chartTrendPatroliHarian(tahun, bulan, plant) {
        $.ajax({
            url: "{{ route('Dashboard.trendPatrolHarian') }}",
            method: "POST",
            data: {
                tahun: tahun,
                bulan: bulan,
                plant_id: plant,
                "_token": "{{ csrf_token() }}",
            },
            beforeSend: function() {
                document.getElementById("chartTrendPatrolHarian_overlay").style.display = "block";
            },
            complete: function() {
                document.getElementById("chartTrendPatrolHarian_overlay").style.display = "none";

            },
            success: function(e) {
                var chartTrendPatrolHarian = $('#patroliHarian').highcharts();
                var bln = $("select[name=yearMonth] option:selected").text();

                var data = JSON.parse(e);
                var seriesLength = chartTrendPatrolHarian.series.length;
                for (var i = seriesLength - 1; i > -1; i--) {
                    chartTrendPatrolHarian.series[i].remove();
                }
                let series = [];
                for (let i = 0; i < data.length; i++) {
                    let dataR = [{
                        name: "",
                        data: []
                    }]
                    chartTrendPatrolHarian.addSeries({
                        data: dataR
                    });
                }

                for (var i = 0; i < data.length; i++) {
                    chartTrendPatrolHarian.series[i].update({
                        name: data[i].name,
                        data: data[i].data,
                        marker: {
                            lineColor: 'white',
                            // fillColor: 'gray',
                        },
                    });
                }
                chartTrendPatrolHarian.xAxis[0].update({
                    categories: tanggal(data[0].data.length)
                })
                chartTrendPatrolHarian.setTitle(null, {
                    text: 'Periode ' + convertMonth(bulan) + ' ' + tahun
                })
                chartTrendPatrolHarian.redraw();
            }
        })
    }
    chartTrendPatroliHarian($("#yearFilter").val(), $("#monthFilter").val(), 0);
    // end trend



    // start performance
    // performance patroli
    var charPerformancePatroliLine;
    charPerformancePatroliLine = new Highcharts.chart({
        chart: {
            renderTo: 'chartPerformanceAllLine',
            type: 'area',
            backgroundColor: 'transparent'
        },
        legend: {
            enabled: false,
        },
        title: {
            text: 'Performance Patroli',
            style: {
                // color: '#FFF',
                font: 'bold 18px "Trebuchet MS", Verdana, sans-serif'
            }
        },
        subtitle: {
            text: 'Periode ' + <?= date('Y') ?>,
            style: {
                // color: '#FFF',
                font: 'bold 14px "Trebuchet MS", Verdana, sans-serif'
            }
        },
        xAxis: {
            categories: month,
            crosshair: true,
            labels: {
                style: {
                    // color: '#FFF',
                    font: '11px Trebuchet MS, Verdana, sans-serif'
                }
            },
        },
        yAxis: {
            min: 0,
            max: 100,
            // tickInterval: 0.25,
            labels: {
                formatter: function() {
                    return this.value + '%'
                },
                style: {
                    // color: '#FFF',
                    font: '11px Trebuchet MS, Verdana, sans-serif'
                }
            },
            title: {
                text: 'TOTAL'
            },
            gridLineDashStyle: 'dash',
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true,
            valueSuffix: '%',
            backgroundColor: '#5f5f5f',
            style: {
                padding: 10,
                color: '#fefefe',
            }
        },
        plotOptions: {
            // column: {
            // 	pointPadding: 0.2,
            // 	borderWidth: 0,
            // 	// stacking: 'percent'
            // },
            area: {
                lineWidth: 1,
                marker: {
                    lineWidth: 2,
                    symbol: 'circle',
                    fillColor: 'white',
                    radius: 6,
                },
                legend: {
                    radius: 2,
                }
            }

        },
        exporting: {
            buttons: {
                contextButton: {
                    enabled: false
                },
            }
        },
        series: [{
            name: 'Performance',
            data: []
        }]
    });

    function charPerformancePatrolAllADM(tahun) {
        // var tahun = $("#tahun_performance_patrol_allplant").val();
        // var plant = $("#plant_patrol_performance_patrol_allplant").val();
        $.ajax({
            url: "{{ route('Dashboard.perforamancePatrolBulananPerPlant') }}",
            method: "POST",
            data: {
                tahun: tahun,
                plant_id: '',
                "_token": "{{ csrf_token() }}",
            },
            beforeSend: function() {
                document.getElementById("chartPerformanceAllPlantADM_overlay").style.display = "block";
            },
            complete: function() {
                document.getElementById("chartPerformanceAllPlantADM_overlay").style.display = "none";
            },
            success: function(e) {
                var chartPatrolAll = $('#chartPerformanceAllLine').highcharts();
                // console.log(e)
                var data = JSON.parse(e);
                chartPatrolAll.series[0].update({
                    name: data[0].name,
                    data: data[0].data,
                    marker: {
                        lineColor: 'white',
                        fillColor: '#70ba47',
                    },
                });
                chartPatrolAll.setTitle(null, {
                    text: 'Periode ' + tahun
                })
                chartPatrolAll.redraw();
            }
        })
    }
    charPerformancePatrolAllADM($("#yearFilter").val());

    var charPerformancePatrolAllBar;
    charPerformancePatrolAllBar = new Highcharts.chart({
        chart: {
            renderTo: 'chartPerformanceAllBar',
            type: 'line',
            backgroundColor: 'transparent'
        },
        title: {
            text: 'Performance Patroli',
            style: {
                // color: '#FFF',
                font: 'bold 18px "Trebuchet MS", Verdana, sans-serif'
            }
        },
        legend: {
            // enabled: false,
            itemStyle: {
                fontSize: '10px',
                font: '10pt Trebuchet MS, Verdana, sans-serif',
                // color: '#FFF'
            },
        },
        subtitle: {
            text: 'Periode ' + <?= date('Y') ?>,
            style: {
                // color: '#FFF',
                font: 'bold 14px "Trebuchet MS", Verdana, sans-serif'
            }
        },
        xAxis: {
            categories: month,
            crosshair: true,
            labels: {
                style: {
                    // color: '#FFF',
                    font: '11px Trebuchet MS, Verdana, sans-serif'
                }
            },
        },
        yAxis: {
            min: 0,
            max: 100,
            // tickInterval: 0.25,
            labels: {
                formatter: function() {
                    return this.value + '%'
                },
                style: {
                    // color: '#FFF',
                    font: '11px Trebuchet MS, Verdana, sans-serif'
                }
            },
            title: {
                text: 'TOTAL'
            },
            // gridLineDashStyle: 'dash',
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true,
            valueSuffix: '%',
            backgroundColor: '#5f5f5f',
            style: {
                padding: 10,
                color: '#fefefe',
            }
        },
        plotOptions: {
            series: {
                events: {
                    legendItemClick: function() {
                        return false; // <== returning false will cancel the default action
                    }
                },
            },
            column: {
                pointPadding: 0.2,
                borderWidth: 0,
            },

        },
        exporting: {
            buttons: {
                contextButton: {
                    enabled: false
                },
            }
        },
        series: []
    });

    function charPerformancePatrolAllD(tahun, plant) {
        // var tahun = $("#tahun_performance_patrol_Perplant").val();
        $.ajax({
            url: "{{ route('Dashboard.perforamancePatrolAllPlant') }}",
            method: "POST",
            data: {
                tahun: tahun,
                plant_id: plant,
                "_token": "{{ csrf_token() }}",
            },
            beforeSend: function() {
                document.getElementById("chartPerformancePerPlant_overlay").style.display = "block";
            },
            complete: function() {
                document.getElementById("chartPerformancePerPlant_overlay").style.display = "none";
            },
            success: function(e) {
                var chartPatrolAll = $('#chartPerformanceAllBar').highcharts();
                // console.log(e)
                var data = JSON.parse(e);
                var seriesLength = chartPatrolAll.series.length;
                for (var i = seriesLength - 1; i > -1; i--) {
                    chartPatrolAll.series[i].remove();
                }
                let series = [];
                for (let i = 0; i < data.length; i++) {
                    let dataR = [{
                        name: "",
                        data: []
                    }]
                    chartPatrolAll.addSeries({
                        data: dataR
                    });
                }
                for (let i = 0; i < data.length; i++) {
                    chartPatrolAll.series[i].update({
                        name: data[i].plant,
                        data: data[i].data
                    });
                }
                chartPatrolAll.setTitle(null, {
                    text: 'Periode ' + tahun
                })
                chartPatrolAll.redraw();
            }
        })
    }
    charPerformancePatrolAllD($("#yearFilter").val(), 0);


    function performanceHarian(tahun, bulan, plant) {
        $.ajax({
            url: "{{ route('Dashboard.perFormancePatrolHarian') }}",
            method: "POST",
            data: {
                tahun: tahun,
                bulan: bulan,
                plant_id: plant,
                "_token": "{{ csrf_token() }}",
            },
            beforeSend: function() {
                document.getElementById("tahunPerformance_overlay").style.display = "block";
            },
            complete: function() {
                document.getElementById("tahunPerformance_overlay").style.display = "none";
            },
            success: function(e) {
                var chartPatrolAll = $('#PerformancePatrolHarian').highcharts();
                // console.log(e)
                var data = JSON.parse(e);
                var seriesLength = chartPatrolAll.series.length;
                for (var i = seriesLength - 1; i > -1; i--) {
                    chartPatrolAll.series[i].remove();
                }
                let series = [];
                for (let i = 0; i < data.length; i++) {
                    let dataR = [{
                        name: "",
                        data: []
                    }]
                    chartPatrolAll.addSeries({
                        data: dataR
                    });
                }

                for (let i = 0; i < data.length; i++) {
                    chartPatrolAll.series[i].update({
                        name: data[i].name,
                        data: data[i].data
                    });
                }
                chartPatrolAll.setTitle(null, {
                    text: 'Periode ' + tahun
                })
                chartPatrolAll.xAxis[0].update({
                    labels: {
                        enabled: false
                    },
                    title: {
                        text: null
                    }
                });
                chartPatrolAll.setTitle(null, {
                    text: 'Periode ' + convertMonth(bulan) + ' ' + tahun
                })
                chartPatrolAll.redraw();
            }
        })
    }
    performanceHarian($("#yearFilter").val(), $("#monthFilter").val(), 0);
    Highcharts.chart({
        chart: {
            type: 'line',
            renderTo: 'PerformancePatrolHarian',
            backgroundColor: 'transparent'
        },
        title: {
            text: 'Performance Patroli Harian',
            style: {
                // color: '#FFF',
                font: 'bold 18px "Trebuchet MS", Verdana, sans-serif'
            }
        },
        legend: {
            // enabled: false,
            itemStyle: {
                fontSize: '10px',
                font: '10pt Trebuchet MS, Verdana, sans-serif',
                // color: '#FFF'
            },
        },
        subtitle: {
            text: 'Periode ' + <?= date('Y') ?>,
            style: {
                // color: '#FFF',
                font: 'bold 14px "Trebuchet MS", Verdana, sans-serif'
            }
        },
        xAxis: {
            // categories: tanggal(28)
        },
        yAxis: {
            min: 0,
            max: 100,
            // tickInterval: 0.25,
            labels: {
                formatter: function() {
                    return this.value + '%'
                },
                style: {
                    // color: '#FFF',
                    font: '11px Trebuchet MS, Verdana, sans-serif'
                }
            },
            title: {
                text: 'TOTAL'
            },
            // gridLineDashStyle: 'dash',
        },
        tooltip: {
            formatter: function() {
                var tooltip = '<span style="font-size:10px">Tanggal ' + `${this.x + 1}` + '</span><table><tbody>';
                $.each(this.points, function(i, point) {
                    tooltip += '<tr><td style="color:' + point.series.color + ';padding:0">' + point.series.name + ': </td><td style="padding:0"><b>' + point.y + '%</b></td></tr>'
                })
                tooltip += '</tbody></table>';
                return tooltip
            },
            shared: true,
            useHTML: true,
            valueSuffix: '%',
            backgroundColor: '#5f5f5f',
            style: {
                padding: 10,
                color: '#fefefe',
            }
        },
        plotOptions: {
            series: {
                events: {
                    legendItemClick: function() {
                        return false; // <== returning false will cancel the default action
                    }
                },
            },
            column: {
                pointPadding: 0.2,
                borderWidth: 0,
                // stacking: 'percent'
            }
        },
        exporting: {
            buttons: {
                contextButton: {
                    enabled: false
                },
            }
        },
        series: []

    });
    // end performance



    // start temuan patroli 

    function ajaxTemuanAdm(tahun) {
        $.ajax({
            url: "{{ route('Dashboard.temuanPatrolAllPlant') }}",
            method: "POST",
            data: {
                tahun: tahun,
                "_token": "{{ csrf_token() }}",
            },
            beforeSend: function() {
                document.getElementById("chartTemuanADM_overlay").style.display = "block";
            },
            complete: function() {
                document.getElementById("chartTemuanADM_overlay").style.display = "none";
            },
            success: function(e) {
                var chartPatrolAll = $('#chartTemuanADM').highcharts();
                var data = JSON.parse(e);
                chartPatrolAll.series[0].update({
                    name: 'Total',
                    data: data
                });
                chartPatrolAll.setTitle(null, {
                    text: 'Periode ' + tahun
                })
                chartPatrolAll.redraw();
            }
        })
    }
    ajaxTemuanAdm($("#yearFilter").val());

    Highcharts.chart('chartTemuanADM', {
        chart: {
            type: 'line',
            backgroundColor: 'transparent'
        },
        title: {
            text: 'Temuan Patroli',
            align: 'center',
            style: {
                // color: '#FFF',
                font: 'bold 18px "Trebuchet MS", Verdana, sans-serif'
            }
        },
        legend: {
            enabled: false,
            itemStyle: {
                fontSize: '10px',
                font: '10pt Trebuchet MS, Verdana, sans-serif',
                // color: '#FFF'
            },
        },
        subtitle: {
            text: "Periode 2023",
            style: {
                // color: '#FFF',
                font: 'bold 14px "Trebuchet MS", Verdana, sans-serif'
            }
        },
        xAxis: {
            categories: month,
            labels: {
                style: {
                    // color: '#FFF',
                    font: '11px Trebuchet MS, Verdana, sans-serif'
                }
            },
        },
        yAxis: {
            tickInterval: 1,
            min: 0,
            title: {
                text: 'Total'
            },
            labels: {
                style: {
                    // color: '#FFF',
                    font: '11px Trebuchet MS, Verdana, sans-serif'
                }
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
            },
            // gridLineDashStyle: 'dash',
        },

        tooltip: {
            headerFormat: '<b>{point.x}</b><br/>',
            pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}',
            backgroundColor: '#5f5f5f',
            style: {
                padding: 10,
                color: '#fefefe',
            }
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
            buttons: {
                contextButton: {
                    enabled: false
                },
            }
        },
        series: [{
            name: 'Total',
            data: []
        }]
    });


    function ajaxTemuanReguAdm(tahun, bulan) {
        $.ajax({
            url: "{{ route('Dashboard.temuanPerReguPlant') }}",
            method: "POST",
            data: {
                tahun: tahun,
                bulan: bulan,
                "_token": "{{ csrf_token() }}",
            },
            beforeSend: function() {
                document.getElementById("chartTemuanRegu_overlay").style.display = "block";
            },
            complete: function() {
                document.getElementById("chartTemuanRegu_overlay").style.display = "none";
            },
            success: function(e) {
                var chartPatrolAll = $('#chartTemuanRegu').highcharts();
                var data = JSON.parse(e);
                let regu = ['REGU A', 'REGU B', 'REGU C', 'REGU D'];
                for (let i = 0; i < data[0].length; i++) {
                    chartPatrolAll.series[i].update({
                        name: regu[i],
                        data: data[0][i]
                    });
                }
                chartPatrolAll.setTitle(null, {
                    text: 'Periode ' + convertMonth(bulan) + ' ' + tahun
                })
                chartPatrolAll.xAxis[0].update({
                    categories: data[1][0]
                });
                chartPatrolAll.redraw();
            }
        })
    }
    ajaxTemuanReguAdm($("#yearFilter").val(), $("#monthFilter").val());
    Highcharts.chart('chartTemuanRegu', {
        chart: {
            type: 'column',
            backgroundColor: 'transparent'
        },
        legend: {
            enabled: false,
            itemStyle: {
                fontSize: '10px',
                font: '10pt Trebuchet MS, Verdana, sans-serif',
                // color: '#FFF'
            },
        },
        title: {
            text: 'Temuan Patroli Per Regu',
            align: 'center',
            style: {
                // color: '#FFF',
                font: 'bold 18px "Trebuchet MS", Verdana, sans-serif'
            }
        },
        subtitle: {
            text: "Periode " + <?= date('Y') ?>,
            style: {
                // color: '#FFF',
                font: 'bold 14px "Trebuchet MS", Verdana, sans-serif'
            }
        },
        xAxis: {
            categories: <?= $plants ?>,
            labels: {
                style: {
                    // color: '#FFF',
                    font: '11px Trebuchet MS, Verdana, sans-serif'
                }
            },
        },
        yAxis: {
            tickInterval: 1,
            min: 0,
            title: {
                text: 'Total'
            },
            labels: {
                style: {
                    // color: '#FFF',
                    font: '11px Trebuchet MS, Verdana, sans-serif'
                }
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
            },
            // gridLineDashStyle: 'dash',
        },

        tooltip: {
            headerFormat: '<b>{point.x}</b><br/>',
            pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}',
            backgroundColor: '#5f5f5f',
            style: {
                padding: 10,
                color: '#fefefe',
            }
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
            buttons: {
                contextButton: {
                    enabled: false
                },
            }
        },
        series: [{
            name: 'GROUP A',
            data: []
        }, {
            name: 'GROUP B',
            data: []
        }, {
            name: 'GROUP C',
            data: []
        }, {
            name: 'GROUP D',
            data: []
        }]
    });
    // end temuan


    $("#areaFilter, #yearFilter, #monthFilter").change(function(e) {
        var year = $("#yearFilter").val();
        var month = $("#monthFilter").val();
        var area = $("#areaFilter").val();

        charTrendPatrolAllD(year, area);
        charTrendPatrolPerPlant(year);
        chartTrendPatroliHarian(year, month, area);
        charPerformancePatrolAllADM(year);
        charPerformancePatrolAllD(year, area);
        performanceHarian(year, month, area);
        ajaxTemuanAdm(year);
        ajaxTemuanReguAdm(year, month);
    })
</script>
@endsection