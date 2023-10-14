@extends('srs::layouts.template')

@section('content')
<!-- loading -->
<div class="row d-none align-items-center justify-content-center" id="loader" style="position:absolute;left:0;z-index:9999;width:100%;height:100%;">
    <div class="spinner-grow text-primary " role="status">
        <span class="sr-only">Loading...</span>
    </div>
    <div class="spinner-grow text-secondary ml-1" role="status">
        <span class="sr-only">Loading...</span>
    </div>
    <div class="spinner-grow text-success ml-1 " role="status">
        <span class="sr-only">Loading...</span>
    </div>
    <div class="spinner-grow text-danger ml-1" role="status">
        <span class="sr-only">Loading...</span>
    </div>
    <div class="spinner-grow text-warning ml-1" role="status">
        <span class="sr-only">Loading...</span>
    </div>
    <div class="spinner-grow text-info ml-1" role="status">
        <span class="sr-only">Loading...</span>
    </div>
    <div class="spinner-grow text-dark ml-1" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- loading -->

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
                <!-- <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="Mst_Event">Master</a></li>
                    <li class="breadcrumb-item"><a href="Mst_Event">Event</a></li>
                    <li class="breadcrumb-item"><a href="">Edit Event</a></li>
                </ol> -->
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 filter sticky-top-OFF">
                <div class="card cardIn2">
                    <div class="card-body">
                        <form id="form-filter" class="form-horizontal">
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="area">Area</label>
                                    {!! $select_area_filter !!}
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="yearFilter">Year</label>
                                    {!! $select_year_filter !!}
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="monthFilter">Month</label>
                                    {!! $select_month_filter !!}
                                </div>

                                <div class="form-group col d-flex align-items-end justify-content-end">
                                    <span class="h2 ff-fugazone title-dashboard">Human Intelligence</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
            <div class="row">
                    <div class="col-lg-12">
                        <div class="card cardIn2">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-sm-4 col-md-4 mb-5 mb-md-0">
                                                <canvas id="grapSoi" style="width:350px; height:350px"></canvas>
                                            </div>

                                            <div class="col-sm-4 col-md-4 px-3 mt-1 mt-md-0 mx-auto-OFF py-4-OFF px-5-OFF text-center" style="min-height: 350px;">
                                                <h5>Index Resiko ADM</h5>
                                                <input id="indexSoi" class="form-control form-control-lg text-center" type="text" placeholder="" disabled>

                                                <div id="isoDesc" class="card mt-3" style="display: none;">
                                                    <div class="card-body">
                                                        <dl class="row text-white text-left">
                                                            <dt class="col-sm-1">-</dt>
                                                            <dd class="col-sm-11">Masyarakat Sunter tidak kondusif (pandemic ke endemic) dan program CSR - External</dd>

                                                            <dt class="col-sm-1">-</dt>
                                                            <dd class="col-sm-11">Narkoba (Pembubaran kampung Bahari) - External</dd>
                                                            
                                                            <dt class="col-sm-1">-</dt>
                                                            <dd class="col-sm-11">Pembangunan KAP 2 - Internal</dd>
                                                            
                                                            <dt class="col-sm-1">-</dt>
                                                            <dd class="col-sm-11">Serangan Ransomware - Internal</dd>
                                                        </dl>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-4 col-lg-4" style="min-height: 350px;">
                                                <canvas id="barDonatAll"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-8 col-lg-8">
                        <div class="card" style="height: 330px;">
                            <div class="card-body">
                                <canvas id="barLine"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-lg-4">
                        <div class="card" style="height: 330px;">
                            <div class="card-body">
                                <canvas id="barDonatPlant" style="margin-top:-16px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="card" style="height: 390px;">
                            <div class="card-body text-center">
                                <h5>Risk Source</h5>
                                <canvas id="rsoChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card" style="height: 390px;">
                            <div class="card-body text-center">
                                <h5>Target Assets</h5>
                                <canvas id="assetChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card" style="height: 390px;">
                            <div class="card-body text-center">
                                <h5>Risk</h5>
                                <canvas id="riskChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="detailGrap" tabindex="-1" role="dialog" aria-labelledby="detailGrapLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:70%;max-width:none;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailGrapLabel">Graphic Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <h3 id="labels"></h3>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailGrapSmall" tabindex="-1" role="dialog" aria-labelledby="detailGrapSmallLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:50%;max-width:none;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailGrapSmallLabel">Graphic Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <h3 id="labels"></h3>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="topIndexSmall" tabindex="-1" role="dialog" aria-labelledby="topIndexSmallLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:50%;max-width:none;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="topIndexSmallLabel">Graphic Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <h3 id="labels"></h3>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailGrapSmall2" tabindex="-1" role="dialog" aria-labelledby="detailGrapSmall2Label" aria-hidden="true">
    <div class="modal-dialog" style="width:50%;max-width:none;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailGrapSmall2Label">Graphic Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <h3 id="labels"></h3>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/vendor/chartjs/dist/chart.umd.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-annotation/2.1.0/chartjs-plugin-annotation.min.js" integrity="sha512-1uGDhRiDlpOPrTi54rJHu3oBLizqaadZDDft+j4fVeFih6eQBeRPJuuP3JcxIqJxIjzOmRq57XwwO4FT+/owIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script src="{{ asset('assets/vendor/chartjs/dist/chartjs-plugin-labels.min.js'); }}"></script>

<script type="text/javascript">
    var field = [
        areaFilter = $("#areaFilter").val(),
        yearFilter = $("#yearFilter").val(),
        monthFilter = $("#monthFilter").val(),
        detailGrapBody = $("#detailGrap .modal-body"),
        topIndexSmallBody = $("#topIndexSmall .modal-body"),
        currYear = '{!! date('Y') !!}',
        currMonth = '{!! date('m') !!}',
    ]
    var sticky = $('.filter')
    
    // Fungsi multiple modal untuk scrollable
    $('.modal').on("hidden.bs.modal", function (e) {
        if ($('.modal:visible').length) {
            $('body').addClass('modal-open');
        }
    });

    $(window).on('scroll', function() {
        var scroll = $(window).scrollTop(),
        stickyTop = sticky.offset().top,
        stickyBottom = sticky.offset().top + sticky.outerHeight();

        if(stickyTop >= 95)
        {
            sticky.find('.card-body').attr('style', 'padding: 0.5rem 1.25rem !important')
            // sticky.find('.card').attr('style', "background-color: #ffffff !important")
        }
        if(stickyTop <= 95)
        {
            sticky.find('.card-body').removeAttr('style')
        }
    })

    // LOADING
	loadingAllBox();
    function loadingAllBox() {
        var allBoxChart = document.querySelectorAll('#grapSoi, #barDonatAll, #indexSoi, #barLine, #barDonatPlant, #rsoChart, #assetChart, #riskChart');
        allBoxChart.forEach(function (el)
        {
            el.style.display = 'none';
            el.parentElement.insertAdjacentHTML('beforeend', animateLoading('loader-full'))
        });
    }
    
    function animateLoading(mode='') {
        return `
            <div class="loader d-flex w-100 justify-content-center py-3 `+mode+`">
                <div class="spinner-grow text-primary " role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-secondary ml-1" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-success ml-1 " role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-danger ml-1" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-warning ml-1" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-info ml-1" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-dark ml-1" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        `;
    }
    // LOADING //

    function getColorRand(length) {
        let randomColors = [];
        for (let i = 0; i < length; i++) {
            var num = Math.round(0xffffff * Math.random());
            var r = num >> 16;
            var g = num >> 8 & 255;
            var b = num & 255;
            // randomColors.push('rgb(' + Math.floor(Math.random() * 255) + ', ' + Math.floor(Math.random() * 255) + ', ' + Math.floor(Math.random() * 255) + ',' +  '0.5)');
            randomColors.push('rgb(' + (r + i) + ', ' + g + ', ' + b + ',' +  '0.5)');
        }
        return randomColors;
    }

    $(document).ready(function() {
        soiIndexResiko(soiChart)
        daughnutMonhtly(dougnutChartAll)
        daughnutPlant(dougnutChartPlant)
        riskTransSource(rsoChart)
		srsTargetAssets(assetChart)
		srsRisks(riskChart)
    });


    const ctxSoi = document.getElementById("grapSoi");
    ctxSoi.width = 350;
    ctxSoi.height = 350;
    const soiChart = new Chart(ctxSoi, {
        type: 'bubble',
        data: {
            // labels: ['January', 'Fabruary', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                label: 'Index Resiko',
                
                borderWidth: 1,
                backgroundColor: 'black',
                borderColor: 'white',
            }]
        },
        options: {
            responsive: false,
            maintainAspectRatio: false,
            // aspectRatio: 2.5,
            scales: {
                y: {
                    title: {
                        display: true,
                        text: 'Threat',
                        fontStyle: "bold",
                        font: {
                            family: 'Comic Sans MS',
                            size: 14,
                            weight: 'bold',
                            lineHeight: 1.2,
                        },
                        color: '#FFF',
                    },
                    ticks: {
                        precision: 0,
                        color: '#FFF'
                    },
                    position: 'right',
                    min: 0.0,
                    max: 5.0,
                    beginAtZero: true
                },
                x: {
                    reverse: true,
                    title: {
                        display: true,
                        text: 'Security Operational Index',
                        fontStyle: "bold",
                        font: {
                            family: 'Comic Sans MS',
                            size: 14,
                            weight: 'bold',
                            lineHeight: 1.2,
                        },
                        color: '#FFF',
                    },
                    ticks: {
                        precision: 0,
                        color: '#FFF'
                    },
                    min: 0.0,
                    max: 5.0,
                    beginAtZero: true
                }
            },
            plugins: {
                tooltip: {
            callbacks: {
                label: function(item) {
                    return ` SOI: ${item.raw.x}, THREAT: ${item.raw.y}`
                }
            }
        },
                autocolors: false,
                annotation: {
                    annotations: {
                        box1: {
                            type: 'box',
                            xMin: 0,
                            xMax: 4,
                            yMin: 0,
                            yMax: 2,
                            backgroundColor: 'rgba(255, 255, 23, 0.5)', // yellow bottom right
                            borderColor: 'white'
                        },
                        box2: {
                            type: 'box',
                            xMin: 5,
                            xMax: 4,
                            yMin: 5,
                            yMax: 2,
                            backgroundColor: 'rgba(255, 255, 23, 0.5)', // yellow top right
                            borderColor: 'white'
                        },
                        box3: {
                            type: 'box',
                            xMin: 0,
                            xMax: 4,
                            yMin: 2,
                            yMax: 5,
                            backgroundColor: 'rgba(255, 0, 0, 0.3)', // red right
                            borderColor: 'white'
                        },
                        box4: {
                            type: 'box',
                            xMin: 5,
                            xMax: 4,
                            yMin: 0,
                            yMax: 2,
                            backgroundColor: 'rgba(0, 255, 0, 0.3)', // green left
                            borderColor: 'white'
                        }
                    }
                },
                datalabels: {
                    color: '#FFF',
                },
                legend: {
                    display: false
                },
            }
        }
    });

    // RISK SOURCE //
    // var dataRiskSource = ;
    // var setsRiskSource = [{
    //     label: dataRiskSource.map(function(v){return v.label}),
    //     data: dataRiskSource.map(function(v){return v.data})
    // }];
    var ctxRso = document.getElementById("rsoChart");
    ctxRso.height = 250;
    var ict_unit = [];
    var efficiency = [];
    var coloR = [];
    var dynamicColors = function() {
        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);
        return "rgb(" + r + "," + g + "," + b + ")";
    };
    // var data = setsRiskSource[0].label
    // for (var i in data) {
    //     ict_unit.push("ICT Unit " + data[i].ict_unit);
    //     efficiency.push(data[i].efficiency);
    //     coloR.push(dynamicColors());
    // }
    var rsoChart = new Chart(ctxRso, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                axis: 'y',
                label: '',
                data: [],
                fill: false,
                minBarLength: 2,
                barThickness: 20,
                maxBarThickness: 20,
                backgroundColor: coloR,
                borderWidth: 1
            }]
        },

        options: {
            indexAxis: 'y',
            scales: {
                x: {
                    display: false
                },
                y: {
                    ticks: {
                        font: {
                            size: 10,
                        },
                        color: '#FFF'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                datalabels: {
                    color: '#FFF'
                }
            },
        },
        plugins: [ChartDataLabels],
    });
    // RISK SOURCE //

    // TARGET ASSETS //
    var ctxAsset = document.getElementById("assetChart");
    ctxAsset.height = 250;
    var assetChart = new Chart(ctxAsset, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                axis: 'y',
                label: '',
                data: [],
                fill: false,
                minBarLength: 2,
                barThickness: 20,
                maxBarThickness: 20,
                // backgroundColor: coloR,
                backgroundColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 205, 86, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(201, 203, 207, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsiveAnimationDuration: 5000,
            indexAxis: 'y',
            scales: {
                x: {
                    display: false,
                },
                y: {
                    ticks: {
                        font: {
                            size: 10,
                        },
                        color: '#FFF'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false,
                    "labels": {
                        "fontSize": 20,
                        color: '#FFF'
                    }
                },
                datalabels: {
                    color: '#FFF'
                }
            }
        },
        plugins: [ChartDataLabels],
    });
    // TARGET ASSETS //

    // RISK //
    var ctxRis = document.getElementById("riskChart");
    ctxRis.height = 250;
    var ict_unit = [];
    var efficiency = [];
    var coloR = [];
    var dynamicColors = function() {
        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);
        return "rgb(" + r + "," + g + "," + b + ")";
    };
    // var data = setRisk[0].data;
    // for (var i in data) {
    //     ict_unit.push("ICT Unit " + data[i].ict_unit);
    //     efficiency.push(data[i].efficiency);
    //     coloR.push(dynamicColors());
    // }
    var riskChart = new Chart(ctxRis, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                axis: 'y',
                label: '',
                data: [],
                fill: false,
                minBarLength: 2,
                barThickness: 20,
                maxBarThickness: 20,
                // backgroundColor: coloR,
                backgroundColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 205, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(201, 203, 207, 1)'
                ],
                borderWidth: 1
            }]
        },

        options: {
            responsiveAnimationDuration: 5000,
            indexAxis: 'y',
            scales: {
                x: {
                    display: false
                },
                y: {
                    ticks: {
                        font: {
                            size: 10,
                        },
                        color: '#FFF'
                    },
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                datalabels: {
                    color: '#FFF',
                    // margin: 5
                }
            },
        },
        plugins: [ChartDataLabels],
    });
    // RISK //

    // line charts all area 
    var ctxLine = document.getElementById("barLine").getContext('2d');
    const bgGradient = ctxLine.createLinearGradient(0, 0, 0, 400);
    bgGradient.addColorStop(0.6, 'rgba(20, 180, 60, 1)');
    bgGradient.addColorStop(0.4, 'rgba(90, 160, 90, 0.2)');
    bgGradient.addColorStop(0.1, 'blue');

    var lineChart = new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                pointStyle: 'circle',
                pointRadius: 8,
                label: '',
                data: [],
                // backgroundColor: coloR,
                fill: true,
                backgroundColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 205, 86, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(201, 203, 207, 1)'
                ],
                tension: 0.1,
                segment: {
                    borderColor: 'red',
                    // backgroundColor: bgGradient,
                    backgroundColor: 'rgba(201, 90, 80, 0.3)',
                },
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    ticks: {
                        font: {
                            size: 10,
                        },
                        color: '#FFF'
                    },
                },
                y: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        precision: 0,
                        color: '#FFF'
                    },
                    min: 0
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                datalabels: {
                    color: '#000'
                }
            },
        }
    })

    // DOUGHNUT HUMINT TOTAL //
    var ctxDoughnutAll = document.getElementById("barDonatAll").getContext('2d');
    const centerText = {
        // id = 'centerText',
        afterDatasetsDraw(chart, args, pluginOptions) {
            var {
                ctx,
                data
            } = chart;
            var count = data.datasets[0].dataDUmmy;
            var total = 0;
            for (var t in count) {
                if (count.hasOwnProperty(t)) {
                   total += parseFloat( count[t] );
                }
            }
            // const text = data.datasets[0].data[0] + "\n";
            // const text = count.reduce((a, b) => a + b) + "\n";
            ctx.save();
            const x = (chart.getDatasetMeta(0).data[0].x)
            const y = (chart.getDatasetMeta(0).data[0].y)
            ctx.textAlign = 'center';
            ctx.font = 'bold 18px sans-serif';
            ctx.fillStyle = 'white';
            ctx.fillText(total, x, y)
        }
    }
    const doughnutLabelsLine = {
        id: 'doughnutLabelsLine',
        afterDraw(chart, args, options) {
            const {
                ctx,
                chartArea: {
                    top,
                    bottom,
                    left,
                    right,
                    width,
                    height
                }
            } = chart;
            chart.data.datasets.forEach((dataset, i) => {
                chart.getDatasetMeta(i).data.forEach((datapoint, index) => {
                    // console.log(datapoint.startAngle);
                    const {
                        x,
                        y
                    } = datapoint.tooltipPosition();
                    // } = datapoint.startAngle();
                    // ctx.fillStyle = 'black';
                    // ctx.fillRect(x, y, 2, 2)

                    const halfwidth = width / 2;
                    const halfheight = height / 2;
                    const xLine = x >= halfwidth ? x + -10 : x - 15;
                    const yLine = y >= halfheight ? y + -4 : y - 4;
                    const extraLine = x >= halfwidth ? -5 : 30;

                    // const xLine = x >= halfwidth ? x + 15 : x - 15;
                    // const yLine = y >= halfheight ? y + 15 : y - 15;
                    // const extraLine = x >= halfwidth ? 15 : -15;
                    ctx.beginPath();
                    ctx.moveTo(x, y);
                    // ctx.lineTo(xLine, yLine);
                    // ctx.lineTo(xLine + extraLine, yLine);
                    ctx.lineTo(x, y);
                    ctx.lineTo(x, y);
                    // ctx.strokeStyle = 'black';
                    ctx.strokeStyle = dougnutChartAll.data.datasets[0].backgroundColor;
                    ctx.stroke();

                    // text
                    const textWidth = ctx.measureText(chart.data.labels[index]).width;
                    const textPosition = x >= halfwidth ? 'left' : 'right';
                    ctx.font = 'bold 10px Arial';
                    ctx.textBaseLine = 'middle';
                    ctx.textAlign = textPosition;
                    ctx.fillStyle = '#FFF';
                    ctx.fillText(`${chart.data.labels[index]} (${dougnutChartAll.data.datasets[0].dataDUmmy[index]})`, xLine + extraLine, yLine);
                })
            })
        }
    }
    var n = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
    var m = "{{ date('m'); }}";
    var dougnutChartAll = new Chart(ctxDoughnutAll, {
        type: 'doughnut',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                data: [30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30],
                dataDUmmy: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                backgroundColor: [
                    n[0] == m ? 'rgb(255,51,51)' : 'rgb(51,51,153)',
                    n[1] == m ? 'rgb(255,51,51)' : 'rgb(51,51,153)',
                    n[2] == m ? 'rgb(255,51,51)' : 'rgb(51,51,153)',
                    n[3] == m ? 'rgb(255,51,51)' : 'rgb(51,51,153)',
                    n[4] == m ? 'rgb(255,51,51)' : 'rgb(51,51,153)',
                    n[5] == m ? 'rgb(255,51,51)' : 'rgb(51,51,153)',
                    n[6] == m ? 'rgb(255,51,51)' : 'rgb(51,51,153)',
                    n[7] == m ? 'rgb(255,51,51)' : 'rgb(51,51,153)',
                    n[8] == m ? 'rgb(255,51,51)' : 'rgb(51,51,153)',
                    n[9] == m ? 'rgb(255,51,51)' : 'rgb(51,51,153)',
                    n[10] == m ? 'rgb(255,51,51)' : 'rgb(51,51,153)',
                    n[11] == m ? 'rgb(255,51,51)' : 'rgb(51,51,153)',
                ],
                borderColor: ['#FFF'],
                cutout: '50%',
                borderRadius: 5,
                // backgroundColor: bgGradient2,
                // backgroundColor: 'rgba(20, 90, 80, 0.9)',
            }, ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: 20
            },
            plugins: {
                legend: {
                    display: false,
                    labels: {
                        color: "#FFF"
                    }
                },
                tooltip: {
                    enabled: false
                },
                datalabels: {
                    anchor: 'end',
                    color: '#FFF',
                }
            },

        },
        plugins: [centerText, doughnutLabelsLine]
    })
    var ySelected = "{!! date('Y') !!}";
    // bgDoughnut(y, m, ySelected);
    $("select[name=year_filter").on('change', function() {
        years2 = $("select[name=year_filter] option:selected").val();
        // bgDoughnut(y, m, years2);
        dougnutChartAll.data.datasets[0].backgroundColor = [
            n[0] == m ? 'rgb(255,51,51)' : 'rgb(51,51,153)',
            n[1] == m ? 'rgb(255,51,51)' : 'rgb(51,51,153)',
            n[2] == m && years2 == ySelected ? 'rgb(255,51,51)' : 'rgb(51,51,153)',
            n[3] == m ? 'rgb(255,51,51)' : 'rgb(51,51,153)',
            n[4] == m ? 'rgb(255,51,51)' : 'rgb(51,51,153)',
            n[5] == m ? 'rgb(255,51,51)' : 'rgb(51,51,153)',
            n[6] == m ? 'rgb(255,51,51)' : 'rgb(51,51,153)',
            n[7] == m ? 'rgb(255,51,51)' : 'rgb(51,51,153)',
            n[8] == m ? 'rgb(255,51,51)' : 'rgb(51,51,153)',
            n[9] == m ? 'rgb(255,51,51)' : 'rgb(51,51,153)',
            n[10] == m ? 'rgb(255,51,51)' : 'rgb(51,51,153)',
            n[11] == m ? 'rgb(255,51,51)' : 'rgb(51,51,153)',
        ];
        dougnutChartAll.update();
    })
    Chart.defaults.color = '#FFF';

    // PLANT DOUGHNUT //
    var ctxDoughnutPlant = document.getElementById("barDonatPlant").getContext('2d');
    var dougnutChartPlant = new Chart(ctxDoughnutPlant, {
        type: 'polarArea',
        data: {
            labels: [],
            datasets: [{
                backgroundColor: [
                    "rgba(46, 204, 113, 1)",
                    "rgba(52, 152, 219, 1)",
                    "rgba(80, 165, 20, 1)",
                    "rgba(155, 89, 182, 0.9)",
                    "rgba(20, 90, 80, 0.9)",
                    "rgba(231, 20, 60, 0.9)",
                    "rgba(200, 76, 20, 0.9)",
                ],
                data: [],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                r: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        display: false,
                    },
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: "right",
                    "labels": {
                        "fontSize": 20,
                        color: '#FFF'
                    }
                },
                datalabels: {
                    color: '#ffffff',

                }
            },
        },
        plugins: [ChartDataLabels]
    })
    // PLANT DOUGHNUT //

    // SOI DETAIL //
    document.getElementById("grapSoi").onclick = function(evt) {
        var grapSoiId = document.querySelector('#grapSoi');
        var activePoints = soiChart.getElementsAtEventForMode(evt, 'point', soiChart.options);
        var firstPoint = activePoints[0];

        if(firstPoint)
        {
            var label = soiChart.data.labels[firstPoint.index];
            var data = soiChart.data.datasets[0].data[0];

            var area = $("#areaFilter").val();
            var year = $("#yearFilter").val();
            var month = $("#monthFilter").val();

            $("#detailGrapSmall .modal-body").html(animateLoading());
            $("#detailGrapSmall").modal();

            $.ajax({
                url: "{{ url('srs/dashboard_humint_v2/grap_trend_soi') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    area_fil: area,
                    year_fil: year,
                    month_fil: month,
                },
                cache: false,
                timeout: 10000,
                beforeSend: function() {
                },
                error: function(xhr, textStatus, errorThrown) {
                    if (textStatus == 'timeout') {
                        grapSoiId.parentElement.innerHTML = "Error : Timeout for this call!";
                    }
                },
                complete: function() {
                    grapSoiId.parentElement.querySelector('.loader').remove();
                    grapSoiId.style.display = 'block';
                },
                success: function(res) {
                    var dataJson = JSON.parse(res)
                    
                    $("#detailGrapSmall .modal-body").html("");
                        $("#detailGrapSmall").modal();
                        $('#detailGrapSmallLabel').text('Trend Index Resiko')

                        $("#detailGrapSmall .modal-body").append(`
                            <div class="row">
                                <div class="col-12 pb-3 mt-4">
                                    <div class="row">
                                        <!--<div class="col-md-12 pb-3 mb-3 border-bottom">
                                            <span class="h5">Trend Index Resiko</span>
                                        </div>-->
                                        <div class="col-md-12" style="height:250px;">
                                            <canvas id="trendGrapSoi"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);

                        // TREND SOI YEAR //
                        var trendSoi = document.getElementById("trendGrapSoi").getContext('2d');
                        var monthList = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
                        var trendSoiChart = new Chart(trendSoi, {
                            type: 'line',
                            data: {
                                labels: monthList,
                                datasets: [{
                                        pointStyle: 'circle',
                                        pointRadius: 4,
                                        label: 'SOI',
                                        data: dataJson.data_soi,
                                        // fill: true,
                                        // tension: 0.1,
                                        // segment: {
                                        borderColor: 'rgba(99, 131, 255, 1)',
                                        backgroundColor: 'rgba(99, 131, 255, 0.8)',
                                        // },
                                        borderWidth: 1,
                                    },
                                    {
                                        pointStyle: 'circle',
                                        pointRadius: 4,
                                        label: 'Threat',
                                        data: dataJson.data_index,
                                        // fill: true,
                                        // tension: 0.1,
                                        // segment: {
                                        borderColor: 'rgba(255, 165, 0, 1)',
                                        backgroundColor: 'rgb(255 165 0)',
                                        // },
                                        borderWidth: 1,
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    x: {
                                        ticks: {
                                            font: {
                                                size: 13,
                                            },
                                            color: '#FFF'
                                        },
                                    },
                                    y: {
                                        grid: {
                                            display: true
                                        },
                                        ticks: {
                                            precision: 0,
                                            color: '#FFF'
                                        },
                                        min: 0,
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: true
                                    },
                                    datalabels: {
                                        color: '#FFF'
                                    },
                                    annotation: {
                                        annotations: {
                                            line1: {
                                              type: 'line',
                                              yMin: 2.00,
                                              yMax: 2.00,
                                              borderColor: 'rgb(255 202 104)',
                                              borderWidth: 2,
                                            },
                                            line2: {
                                              type: 'line',
                                              yMin: 4.00,
                                              yMax: 4.00,
                                              borderColor: 'rgb(145 162 227)',
                                              borderWidth: 2,
                                            }
                                        }
                                    }
                                },
                            }
                        });
                        // TREND SOI YEAR //

                        document.getElementById("trendGrapSoi").onclick = function(evt) {
                            var activePoints = trendSoiChart.getElementsAtEventForMode(evt, 'point', trendSoiChart.options);
                            var firstPoint = activePoints[0];

                            if (firstPoint) {
                                var label = trendSoiChart.data.labels[firstPoint.index];
                                var data = trendSoiChart.data.datasets[0].data[0];
                                
                                topIndexSmallBody.html("");
                                $("#topIndexSmall").modal();
                                $('#topIndexSmallLabel').text('Top Index');

                                if (firstPoint.datasetIndex == 1) {
                                    $.ajax({
                                        url: '{{ url('srs/dashboard_humint/grap_top_index') }}',
                                        type: 'POST',
                                        data: {
                                            _token: "{{ csrf_token() }}",
                                            area_fil: areas,
                                            year_fil: years,
                                            month_fil: label,
                                        },
                                        cache: false,
                                        beforeSend: function() {
                                            // document.getElementById("loader").style.display = "block";
                                        },
                                        complete: function() {
                                            // document.getElementById("loader").style.display = "none";
                                        },
                                        success: function(res) {

                                            $("#topIndexSmall .modal-body").append(res);
                                        }
                                    });
                                }
                            }
                        }
                }
            });
        }
    }
    // SOI DETAIL //
    
    // FUNCTION INDEX RESIKO
    function soiIndexResiko(soiChart) {
		var grapSoiId = document.querySelector('#grapSoi')
		var indexSoiId = document.querySelector('#indexSoi')

        $.ajax({
            url: '{{ url('srs/dashboard_humint_v2/soiIndexResiko') }}',
            type: 'POST',
            data: {
				_token: "{{ csrf_token() }}",
                area_fil: areaFilter,
                year_fil: yearFilter,
                month_fil: monthFilter,
            },
            cache: false,
            timeout: 10000,
            beforeSend: function() {
            },
            error: function(xhr, textStatus, errorThrown) {
                if (textStatus == 'timeout') {
                    grapSoiId.parentElement.innerHTML = "Error : Timeout for this call!";
                    indexSoiId.parentElement.innerHTML = "Error : Timeout for this call!";
                }
            },
            complete: function() {
                grapSoiId.parentElement.querySelector('.loader').remove();
                grapSoiId.style.display = 'block';
                indexSoiId.parentElement.querySelector('.loader').remove();
                indexSoiId.style.display = 'block';
            },
            success: function(res) {
                var json = JSON.parse(res)
                var dataX = json.data_soi;
                var dataY = json.data_index;

                var dataSrs = [{
                    r: 8,
                    x: dataX,
                    y: dataY
                }];
				
                soiChart.data.datasets[0].data = dataSrs;
                soiChart.update();
                
                // INDEX BG SOI
                if((dataX <= 4 && dataY <= 2) || (dataX >= 4 && dataY >= 2))
                {
                    $('#indexSoi').attr('style','background-color: rgb(233 233 9 / 69%);color:#ffffff') // yellow
                    $('#indexSoi').val('Medium')
                }
                
                if(dataX >= 4 && dataY <= 2)
                {
                    $('#indexSoi').attr('style','background-color: rgb(0 128 9 / 69%);color:#ffffff') // green
                    $('#indexSoi').val('Low')
                }
                
                if(dataX <= 4 && dataY >= 2)
                {
                    $('#indexSoi').attr('style','background-color: rgb(255 0 9 / 69%);color:#ffffff') // red
                    $('#indexSoi').val('High')
                }
                // INDEX BG SOI //
            }
        });
    }
    // FUNCTION INDEX RESIKO //
    
    // FUNCTION SOI MONTH
    function daughnutMonhtly(dougnutChartAll) {
		var barDonatAllId = document.querySelector('#barDonatAll')
		var barLineId = document.querySelector('#barLine')

        $.ajax({
            url: '{{ url('menu/srsMonth') }}',
            type: 'POST',
            data: {
				_token: "{{ csrf_token() }}",
                area_fil: areaFilter,
                year_fil: yearFilter,
                month_fil: monthFilter,
            },
            cache: false,
            timeout: 10000,
            beforeSend: function() {
            },
            error: function(xhr, textStatus, errorThrown) {
                if (textStatus == 'timeout') {
                    barDonatAllId.parentElement.innerHTML = "Error : Timeout for this call!";
                    barLineId.parentElement.innerHTML = "Error : Timeout for this call!";
                }
            },
            complete: function() {
                barDonatAllId.parentElement.querySelector('.loader').remove();
                barDonatAllId.style.display = 'block';
                barLineId.parentElement.querySelector('.loader').remove();
                barLineId.style.display = 'block';
            },
            success: function(res) {
                var json = JSON.parse(res)

                dougnutChartAll.data.datasets[0].dataDUmmy = json;
                dougnutChartAll.update();

                lineChart.data.datasets[0].data = json;
                lineChart.update();

            }
        });
    }
    // FUNCTION SOI MONTH //

    // FUNCTION PLANT DOUGHNUT
    function daughnutPlant(dougnutChartPlant) {
		var barDonatPlantId = document.querySelector('#barDonatPlant')

        $.ajax({
            url: "{{ url('srs/dashboard_humint_v2/humintTransPlant') }}",
            type: 'POST',
            data: {
				_token: "{{ csrf_token() }}",
                area_fil: areaFilter,
                year_fil: yearFilter,
                month_fil: monthFilter,
            },
            cache: false,
			timeout: 10000,
            beforeSend: function() {
            },
            error: function(xhr, textStatus, errorThrown) {
                if (textStatus == 'timeout') {
                    barDonatPlantId.parentElement.innerHTML = "Error : Timeout for this call!";
                }
            },
            complete: function() {
                barDonatPlantId.parentElement.querySelector('.loader').remove();
                barDonatPlantId.style.display = 'block';
            },
            success: function(res) {
                var json = JSON.parse(res)

                dougnutChartPlant.data.labels = json.plant;
                dougnutChartPlant.data.datasets[0].data = json.total;
                dougnutChartPlant.update();
            }
        });
    }
    // FUNCTION PLANT DOUGHNUT //

    // FUNCTION RISK SORUCE
    function riskTransSource(rsoChart) {
		var rsoChartId = document.querySelector('#rsoChart')

        $.ajax({
            url: '{{ url('srs/dashboard_humint_v2/riskTransSource') }}',
            type: 'POST',
            data: {
				_token: "{{ csrf_token() }}",
                area_fil: areaFilter,
                year_fil: yearFilter,
                month_fil: monthFilter,
            },
            cache: false,
            timeout: 10000,
            beforeSend: function() {
            },
            error: function(xhr, textStatus, errorThrown) {
                if (textStatus == 'timeout') {
                    rsoChartId.parentElement.innerHTML = "Error : Timeout for this call!";
                }
            },
            complete: function() {
                rsoChartId.parentElement.querySelector('.loader').remove();
                rsoChartId.style.display = 'block';
            },
            success: function(res) {
                var json = JSON.parse(res)
                console.log(json)

                dataRiskSource = json;
                setRiskSource = [{
                    label: dataRiskSource.map(function(v) {
                        return v.label
                    }),
                    data: dataRiskSource.map(function(v) {
                        return v.total
                    })
                }];

                for (var i in setRiskSource[0].label) {
                    ict_unit.push("ICT Unit " + setRiskSource[0].label[i].ict_unit);
                    efficiency.push(setRiskSource[0].label[i].efficiency);
                    coloR.push(dynamicColors());
                }

                rsoChart.data.datasets[0].data = setRiskSource[0].data;
                rsoChart.data.datasets[0].backgroundColor = coloR;
                rsoChart.data.labels = setRiskSource[0].label
                rsoChart.update();
                
                // DETAIL RISK SOURCE //
                document.getElementById("rsoChart").onclick = function(evt) {
                    var detailGrapId = document.querySelector('#detailGrap')
                    var detailGrapBodyModal = document.querySelector('#detailGrap .modal-body')

                    var activePoints = rsoChart.getElementsAtEventForMode(evt, 'point', rsoChart.options);
                    var firstPoint = activePoints[0];

                    if(firstPoint) {
                        var label = rsoChart.data.labels[firstPoint.index];
                        var id = dataRiskSource[firstPoint.index].id;
                        var category = dataRiskSource[firstPoint.index].label;

                        var area = $("#areaFilter").val()
                        var year = $("#yearFilter").val()
                        var month = $("#monthFilter").val()
                        var labelTitle = label;

                        detailGrapBodyModal.innerHTML = animateLoading();
                        $("#detailGrap").modal();
                        $('#detailGrapLabel').text(labelTitle)

                        $.ajax({

                            url: "{{ url('/srs/dashboard_v2/grap_detail_risk_source') }}",
                            type: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}",
                                area_fil: area,
                                year_fil: year,
                                month_fil: month,
                                id_fil: id,
                            },
                            cache: false,
                            timeout: 10000,
                            beforeSend: function() {
                            },
                            error: function(xhr, textStatus, errorThrown) {
                                if (textStatus == 'timeout') {
                                    detailGrapBodyModal.innerHTML = "Error : Timeout for this call!";
                                }
                            },
                            complete: function() {
                                detailGrapId.querySelector('.loader').remove();
                            },
                            success: function(res) {

                                var dataJson = JSON.parse(res)

                                detailGrapBody.append(`
                                    <div class="row py-3 mb-5">
                                        <div class="col-md-5 pr-5">
                                            <canvas id="detailRiSoSub1"></canvas>
                                        </div>
                                        <div class="col-md-7" style="height:300px;">
                                            <canvas id="riskSourceSub1Month"></canvas>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 border-top py-3">
                                            <div class="col-md-12 mb-3">
                                                <span id="riskSourceSub2Title" class="h5 mb-5"></span>
                                            </div>
                                            <div class="row">
                                                <div style="height:300px;" class="col-md-5 pr-5">
                                                    <canvas id="riskSourceSub2"></canvas>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="row">
                                                        <div style="height:300px;" class="col-md-12">
                                                            <canvas id="riSoSub2Month"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `);

                                // RISK SOURCE SUB 1 MONTH //
                                var riskSoSub1Month = document.getElementById("riskSourceSub1Month").getContext('2d');
                                const bgGradient = riskSoSub1Month.createLinearGradient(0, 0, 0, 400);
                                bgGradient.addColorStop(0.6, 'rgba(20, 180, 60, 1)');
                                bgGradient.addColorStop(0.4, 'rgba(90, 160, 90, 0.2)');
                                bgGradient.addColorStop(0.1, 'blue');
                                
                                var riSoMthChart = new Chart(riskSoSub1Month, {
                                    type: 'line',
                                    data: {
                                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                                        datasets: [{
                                            pointStyle: 'circle',
                                            pointRadius: 8,
                                            label: '',
                                            data: dataJson.data_riso,
                                            fill: true,
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 1)',
                                                'rgba(255, 205, 86, 1)',
                                                'rgba(54, 162, 235, 1)',
                                                'rgba(255, 159, 64, 1)',
                                                'rgba(75, 192, 192, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(201, 203, 207, 1)'
                                            ],
                                            tension: 0.1,
                                            segment: {
                                                borderColor: 'red',
                                                backgroundColor: 'rgba(201, 90, 80, 0.3)',
                                            },
                                            borderWidth: 1,
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        scales: {
                                            x: {
                                                ticks: {
                                                    font: {
                                                        size: 13,
                                                    },
                                                    color: '#FFF'
                                                },
                                            },
                                            y: {
                                                grid: {
                                                    display: false
                                                },
                                                ticks: {
                                                    precision: 0,
                                                    color: '#FFF'
                                                },
                                                min: 0,
                                            }
                                        },
                                        plugins: {
                                            legend: {
                                                display: false
                                            },
                                            datalabels: {
                                                color: '#FFF'
                                            }
                                        },
                                    }
                                });
                                // RISK SOURCE SUB 1 MONTH //

                                // LIST EVENT
                                document.getElementById("riskSourceSub1Month").onclick = function(evt) {
                                    var activePoints = riSoMthChart.getElementsAtEventForMode(evt, 'point', riSoMthChart.options);
                                    var firstPoint = activePoints[0];

                                    if(firstPoint)
                                    {
                                        var data = riSoMthChart.data.datasets[0].data[0];
                                        var label = riSoMthChart.data.labels[firstPoint.index];

                                        topIndexSmallBody.html(animateLoading());
                                        $("#topIndexSmall").modal();
                                        $('#topIndexSmallLabel').text(category+' - '+label);

                                        $.ajax({
                                            url: '{{ url('srs/dashboard_v2/detail_event_list') }}',
                                            type: 'POST',
                                            data: {
                                                _token: "{{ csrf_token() }}",
                                                area_fil: area,
                                                year_fil: year,
                                                month_fil: (firstPoint.index+1), // label
                                                risksource_id: id,
                                            },
                                            cache: false,
                                            timeout: 10000,
                                            beforeSend: function() {
                                            },
                                            complete: function() {
                                                topIndexSmallBody.find('.loader').remove();
                                            },
                                            error: function(xhr, textStatus, errorThrown) {
                                                if (textStatus == 'timeout') {
                                                    topIndexSmallBody.find('.loader').remove();
                                                    topIndexSmallBody.append("Error : Timeout for this call!");
                                                }
                                            },
                                            success: function(res) {
                                                topIndexSmallBody.append(res);
                                            }
                                        });
                                    }
                                }
                                // LIST EVENT //

                                // RISK SOURCE SUB 1 //
                                var dataRiSoSub1 = dataJson.data_riso_sub1
                                var setRiSoSub1 = [{
                                    label: dataRiSoSub1.map(function(v){return v.label}),
                                    data: dataRiSoSub1.map(function(v){return v.data})
                                }];
                                var riSoSub1 = document.getElementById("detailRiSoSub1");
                                riSoSub1.height = 300;
                                var ict_unit = [];
                                var efficiency = [];
                                var coloR = [];
                                var dynamicColors = function() {
                                    var r = Math.floor(Math.random() * 255);
                                    var g = Math.floor(Math.random() * 255);
                                    var b = Math.floor(Math.random() * 255);
                                    return "rgb(" + r + "," + g + "," + b + ")";
                                };
                                var data = setRiSoSub1[0].data;
                                for (var i in data) {
                                    ict_unit.push("ICT Unit " + data[i].ict_unit);
                                    efficiency.push(data[i].efficiency);
                                    coloR.push(dynamicColors());
                                }
                                var riSoMntChart = new Chart(riSoSub1, {
                                    type: 'bar',
                                    data: {
                                        labels: setRiSoSub1[0].label,
                                        datasets: [
                                            {
                                                axis: 'y',
                                                label: '',
                                                data: setRiSoSub1[0].data,
                                                fill: false,
                                                minBarLength: 2,
                                                barThickness: 20,
                                                maxBarThickness: 20,
                                                // backgroundColor: coloR,
                                                backgroundColor: [
                                                    'rgba(255, 99, 132, 1)',
                                                    'rgba(255, 159, 64, 1)',
                                                    'rgba(255, 205, 86, 1)',
                                                    'rgba(75, 192, 192, 1)',
                                                    'rgba(54, 162, 235, 1)',
                                                    'rgba(153, 102, 255, 1)',
                                                    'rgba(153, 102, 255, 1)',
                                                    'rgba(201, 203, 207, 1)'
                                                ],
                                                borderWidth: 1
                                            },
                                        ]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: true,
                                        responsiveAnimationDuration: 5000,
                                        indexAxis: 'y',
                                        scales: {
                                            x: {
                                                display: false
                                            },
                                            y: {
                                                ticks: {
                                                    font: {
                                                        size: 13,
                                                    },
                                                    color: '#FFF'
                                                },
                                            }
                                        },
                                        plugins: {
                                            legend: {
                                                display: false
                                            },
                                            datalabels: {
                                                color: '#FFF',
                                                // margin: 5
                                            }
                                        },
                                    },
                                    plugins: [ChartDataLabels],
                                });
                                // RISK SOURCE SUB 1 //

                                // RISK SOURCE SUB 1 MONTH //
                                document.getElementById("detailRiSoSub1").onclick = function(evt) {
                                    var activePoints = riSoMntChart.getElementsAtEventForMode(evt, 'point', riSoMntChart.options);
                                    var firstPoint = activePoints[0];

                                    if(firstPoint) {
                                        var label = riSoMntChart.data.labels[firstPoint.index];
                                        var id = dataRiSoSub1[firstPoint.index].id;
                                        var category = dataRiSoSub1[firstPoint.index].label;

                                        var area = $("#areaFilter").val()
                                        var year = $("#yearFilter").val()
                                        var month = $("#monthFilter").val()
                                        var labelTitle = label;

                                        $('#detailGrapLabel').text(labelTitle)
                                        $('#riskSourceSub1Month').parent().append(animateLoading('loader-full'))

                                        $.ajax({
                                            url: '{{ url('srs/dashboard_v2/grap_detail_risk_source') }}',
                                            type: 'POST',
                                            data: {
                                                _token: "{{ csrf_token() }}",
                                                area_fil: area,
                                                year_fil: year,
                                                month_fil: month,
                                                id_fil: id,
                                            },
                                            cache: false,
                                            beforeSend: function() {;
                                            },
                                            complete: function() {
                                                detailGrapBody.find('.loader').remove();
                                            },
                                            success: function(res) {
                                                var dataJson = JSON.parse(res)

                                                // GRAFIS LINE ALL MONTH //
                                                riSoMthChart.data.datasets[0].data = dataJson.data_riso_sub1_month;
                                                riSoMthChart.update();
                                                // GRAFIS LINE ALL MONTH //

                                                // RISK SOURCE PIE SUB 2 //
                                                dataRiSoSub2 = dataJson.data_riso_sub2
                                                setRiSoSub2 = [{
                                                    label: dataRiSoSub2.map(function(v){return v.label}),
                                                    data: dataRiSoSub2.map(function(v){return v.data})
                                                }];
                                                riSoSub2Chart.data.labels = setRiSoSub2[0].label;
                                                riSoSub2Chart.data.datasets[0].data = setRiSoSub2[0].data;
                                                riSoSub2Chart.update();
                                                // RISK SOURCE PIE SUB 2 //

                                                // RISK SOURCE MONTH SUB 2 //
                                                riSoSub2MonthChart.data.datasets[0].data = [];
                                                riSoSub2MonthChart.update(); // clear data

                                                // LIST EVENT
                                                document.getElementById("riskSourceSub1Month").onclick = function(evt) {
                                                    var activePoints = riSoMthChart.getElementsAtEventForMode(evt, 'point', riSoMthChart.options);
                                                    var firstPoint = activePoints[0];
                                                    var topIndexSmallBody = $("#topIndexSmall .modal-body")

                                                    if(firstPoint)
                                                    {
                                                        var data = riSoMthChart.data.datasets[0].data[0];
                                                        var label = riSoMthChart.data.labels[firstPoint.index];

                                                        topIndexSmallBody.html(animateLoading());
                                                        $("#topIndexSmall").modal();
                                                        $('#topIndexSmallLabel').text(category+' - '+label);

                                                        $.ajax({
                                                            url: '{{ url('srs/dashboard_v2/detail_event_list') }}',
                                                            type: 'POST',
                                                            data: {
                                                                _token: "{{ csrf_token() }}",
                                                                area_fil: area,
                                                                year_fil: year,
                                                                month_fil: (firstPoint.index+1), // label
                                                                risksource_sub1_id: id,
                                                            },
                                                            cache: false,
                                                            timeout: 10000,
                                                            beforeSend: function() {
                                                            },
                                                            complete: function() {
                                                                topIndexSmallBody.find('.loader').remove();
                                                            },
                                                            error: function(xhr, textStatus, errorThrown) {
                                                                if (textStatus == 'timeout') {
                                                                    topIndexSmallBody.find('.loader').remove();
                                                                    topIndexSmallBody.append("Error : Timeout for this call!");
                                                                }
                                                            },
                                                            success: function(res) {
                                                                topIndexSmallBody.append(res);
                                                            }
                                                        });
                                                    }
                                                }
                                                // LIST EVENT //

                                                document.getElementById("riskSourceSub2").onclick = function(evt) {
                                                    var activePoints = riSoSub2Chart.getElementsAtEventForMode(evt, 'point', riSoSub2Chart.options);
                                                    var firstPoint = activePoints[0];
                                                    var label = riSoSub2Chart.data.labels[firstPoint.index];
                                                    var value = riSoSub2Chart.data.datasets[firstPoint.datasetIndex].data[firstPoint.index];
                                                    var category = label

                                                    var area = $("#areaFilter").val()
                                                    var year = $("#yearFilter").val()
                                                    var month = $("#monthFilter").val()
                                                    var id = dataRiSoSub2[firstPoint.index].id;
                                                    var labelTitle = label;

                                                    $('#riskSourceSub2Title').text(labelTitle)
                                                    $('#riSoSub2Month').parent().append(animateLoading('loader-full'))

                                                    $.ajax({
                                                        url: '{{ url('srs/dashboard_v2/grap_detail_risk_source') }}',
                                                        type: 'POST',
                                                        data: {
                                                            _token: "{{ csrf_token() }}",
                                                            area_fil: area,
                                                            year_fil: year,
                                                            month_fil: month,
                                                            id_fil: id,
                                                        },
                                                        cache: false,
                                                        beforeSend: function() {
                                                        },
                                                        complete: function() {
                                                            detailGrapBody.find('.loader').remove();
                                                        },
                                                        success: function(res) {
                                                            var dataJson = JSON.parse(res)

                                                            // GRAFIS LINE ALL MONTH //
                                                            riSoSub2MonthChart.data.datasets[0].data = dataJson.data_riso_sub2_month;
                                                            riSoSub2MonthChart.update();
                                                            // GRAFIS LINE ALL MONTH //

                                                            // LIST EVENT
                                                            document.getElementById("riSoSub2Month").onclick = function(evt) {
                                                                var activePoints = riSoSub2MonthChart.getElementsAtEventForMode(evt, 'point', riSoSub2MonthChart.options);
                                                                var firstPoint = activePoints[0];

                                                                if(firstPoint)
                                                                {
                                                                    var data = riSoSub2MonthChart.data.datasets[0].data[0];
                                                                    var label = riSoSub2MonthChart.data.labels[firstPoint.index];

                                                                    topIndexSmallBody.html(animateLoading());
                                                                    $("#topIndexSmall").modal();
                                                                    $('#topIndexSmallLabel').text(category+' - '+label);

                                                                    $.ajax({
                                                                        url: '{{ url('srs/dashboard_v2/detail_event_list') }}',
                                                                        type: 'POST',
                                                                        data: {
                                                                            _token: "{{ csrf_token() }}",
                                                                            area_fil: area,
                                                                            year_fil: year,
                                                                            month_fil: (firstPoint.index+1), // label
                                                                            risksource_sub2_id: id,
                                                                        },
                                                                        cache: false,
                                                                        timeout: 10000,
                                                                        beforeSend: function() {
                                                                        },
                                                                        complete: function() {
                                                                            topIndexSmallBody.find('.loader').remove();
                                                                        },
                                                                        error: function(xhr, textStatus, errorThrown) {
                                                                            if (textStatus == 'timeout') {
                                                                                topIndexSmallBody.find('.loader').remove();
                                                                                topIndexSmallBody.append("Error : Timeout for this call!");
                                                                            }
                                                                        },
                                                                        success: function(res) {
                                                                            topIndexSmallBody.append(res);
                                                                        }
                                                                    });
                                                                }
                                                            }
                                                            // LIST EVENT //
                                                        }
                                                    })
                                                }
                                                // RISK SOURCE MONTH SUB 2 //
                                            }
                                        })
                                    }
                                }
                                // RISK SOURCE SUB 1 MONTH //

                                // RISK SOURCE PIE SUB 2 //
                                dataRiSoSub2 = dataJson.data_riso_sub2
                                setRiSoSub2 = [{
                                    label: dataRiSoSub2.map(function(v){return v.label}),
                                    data: dataRiSoSub2.map(function(v){return v.data})
                                }];
                                var colorRand = getColorRand(setRiSoSub2[0].label.length);
                                var riSoSub2 = document.getElementById("riskSourceSub2").getContext('2d');
                                var riSoSub2Chart = new Chart(riSoSub2, {
                                    type: 'pie',
                                    data: {
                                        labels: [],
                                        datasets: [
                                            {
                                                data: [],
                                                hoverOffset: 10,
                                                backgroundColor: colorRand,
                                            }
                                        ]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        layout: {
                                            padding: {
                                                top: 10,
                                                bottom: 5,
                                                left: 5,
                                                // right: 5,
                                            }
                                        },
                                        plugins: {
                                            legend: {
                                                display: true,
                                                position: 'right',
                                                labels: {
                                                    boxWidth: 10
                                                }
                                            },
                                            title: {
                                                display: false,
                                                text: 'Chart.js Pie Chart'
                                            },
                                            labels: [
                                                {
                                                    render: (args) => {
                                                        return `${args.value}`
                                                    },
                                                    fontColor: '#fff',
                                                },
                                            ],
                                        },
                                    },
                                })
                                // RISK SOURCE PIE SUB 2 //

                                // RISK SOURCE SUB 2 MONTH //
                                var riSoSub2Month = document.getElementById("riSoSub2Month").getContext('2d');
                                const bgMSub2 = riSoSub2Month.createLinearGradient(0, 0, 0, 400);
                                bgMSub2.addColorStop(0.6, 'rgba(20, 180, 60, 1)');
                                bgMSub2.addColorStop(0.4, 'rgba(90, 160, 90, 0.2)');
                                bgMSub2.addColorStop(0.1, 'blue');
                                var riSoSub2MonthChart = new Chart(riSoSub2Month, {
                                    type: 'line',
                                    data: {
                                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                                        datasets: [{
                                            pointStyle: 'circle',
                                            pointRadius: 8,
                                            label: '',
                                            data: [],
                                            fill: true,
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 1)',
                                                'rgba(255, 205, 86, 1)',
                                                'rgba(54, 162, 235, 1)',
                                                'rgba(255, 159, 64, 1)',
                                                'rgba(75, 192, 192, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(201, 203, 207, 1)'
                                            ],
                                            tension: 0.1,
                                            segment: {
                                                borderColor: 'red',
                                                backgroundColor: 'rgba(201, 90, 80, 0.3)',
                                            },
                                            borderWidth: 1,
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        scales: {
                                            x: {
                                                ticks: {
                                                    font: {
                                                        size: 13,
                                                    },
                                                    color: '#FFF'
                                                },
                                            },
                                            y: {
                                                grid: {
                                                    display: false
                                                },
                                                ticks: {
                                                    precision: 0,
                                                    color: '#FFF'
                                                },
                                                min: 0,
                                            }
                                        },
                                        plugins: {
                                            legend: {
                                                display: false
                                            },
                                            datalabels: {
                                                color: '#FFF'
                                            }
                                        },
                                    }
                                });
                                // RISK SOURCE SUB 2 MONTH //
                            }
                        });
                    }
                }
                // DETAIL RISK SOURCE //
            }
        });
    }
	// FUNCTION RISK SORUCE //
    
	// FUNCTION TARGET ASSETS
    function srsTargetAssets(assetChart) {
		var assetChartId = document.querySelector('#assetChart');

        $.ajax({
            url: '{{ url('menu/srsTargetAssets') }}',
            type: 'POST',
            data: {
				_token: "{{ csrf_token() }}",
                area_fil: areaFilter,
                year_fil: yearFilter,
                month_fil: monthFilter,
            },
            cache: false,
            timeout: 10000,
            beforeSend: function() {
            },
            error: function(xhr, textStatus, errorThrown) {
                if (textStatus == 'timeout') {
                    assetChartId.parentElement.innerHTML = "Error : Timeout for this call!";
                }
            },
            complete: function() {
                assetChartId.parentElement.querySelector('.loader').remove();
                assetChartId.style.display = 'block';
            },
            success: function(res) {
                var json = JSON.parse(res)

                var dataAssets = json;
                var datasetsAssets = [{
                    label: dataAssets.map(function(v) {
                        return v.label
                    }),
                    data: dataAssets.map(function(v) {
                        return v.total
                    })
                }];

                assetChart.data.datasets[0].data = datasetsAssets[0].data;
                // rsoChart.data.datasets[0].backgroundColor = coloR;
                assetChart.data.labels = datasetsAssets[0].label
                assetChart.update();

                // DETAIL TARGET ASSETS //
                document.getElementById("assetChart").onclick = function(evt) {
                    var activePoints = assetChart.getElementsAtEventForMode(evt, 'point', assetChart.options);
                    var firstPoint = activePoints[0];

                    if(firstPoint) {
                        var label = assetChart.data.labels[firstPoint.index];
                        var id = dataAssets[firstPoint.index].id;
                        var value = assetChart.data.datasets[firstPoint.datasetIndex].data[firstPoint.index];
                        var category = label;

                        var area = $("#areaFilter").val()
                        var year = $("#yearFilter").val()
                        var month = $("#monthFilter").val()
                        var labelTitle = label;

                        detailGrapBody.html(animateLoading());
                        $("#detailGrap").modal();
                        $('#detailGrapLabel').text(labelTitle)

                        $.ajax({
                            url: '{{ url('srs/dashboard_v2/grap_detail_assets') }}',
                            type: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}",
                                area_fil: areaFilter,
                                year_fil: yearFilter,
                                month_fil: monthFilter,
                                label_fil: label,
                                id_fil: id,
                            },
                            cache: false,
                            beforeSend: function() {
                            },
                            complete: function() {
                                detailGrapBody.find('.loader').remove();
                            },
                            success: function(res) {
                                var dataJson = JSON.parse(res)

                                $("#detailGrap .modal-body").append(`
                                    <div class="row py-3 mb-5">
                                        <div class="col-md-5 pr-5">
                                            <canvas id="detailAssetsSub1"></canvas>
                                        </div>
                                        <div class="col-md-7" style="height:300px;">
                                            <canvas id="detailAssets"></canvas>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 border-top py-3">
                                            <div class="col-md-12 mb-3">
                                                <span id="assetsSub2Title" class="h5 mb-5"></span>
                                            </div>
                                            <div class="row">
                                                <div style="height:300px;" class="col-md-5 pr-5">
                                                    <canvas id="detailAssetsSub2"></canvas>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="row">
                                                        <div style="height:300px;" class="col-md-12">
                                                            <canvas id="assetsSub2Month"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `);

                                // DETAIL ASSETS MONTH //
                                var detailAssets = document.getElementById("detailAssets").getContext('2d');
                                const bgGradient = detailAssets.createLinearGradient(0, 0, 0, 400);
                                bgGradient.addColorStop(0.6, 'rgba(20, 180, 60, 1)');
                                bgGradient.addColorStop(0.4, 'rgba(90, 160, 90, 0.2)');
                                bgGradient.addColorStop(0.1, 'blue');
                                
                                var assetsMonthChart = new Chart(detailAssets, {
                                    type: 'line',
                                    data: {
                                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                                        datasets: [{
                                            pointStyle: 'circle',
                                            pointRadius: 8,
                                            label: '',
                                            data: dataJson.data_detail_assets,
                                            fill: true,
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 1)',
                                                'rgba(255, 205, 86, 1)',
                                                'rgba(54, 162, 235, 1)',
                                                'rgba(255, 159, 64, 1)',
                                                'rgba(75, 192, 192, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(201, 203, 207, 1)'
                                            ],
                                            tension: 0.1,
                                            segment: {
                                                borderColor: 'red',
                                                backgroundColor: 'rgba(201, 90, 80, 0.3)',
                                            },
                                            borderWidth: 1,
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        scales: {
                                            x: {
                                                ticks: {
                                                    font: {
                                                        size: 13,
                                                    },
                                                    color: '#FFF'
                                                },
                                            },
                                            y: {
                                                grid: {
                                                    display: false
                                                },
                                                ticks: {
                                                    precision: 0,
                                                    color: '#FFF'
                                                },
                                                min: 0,
                                            }
                                        },
                                        plugins: {
                                            legend: {
                                                display: false
                                            },
                                            datalabels: {
                                                color: '#FFF'
                                            }
                                        },
                                    }
                                });
                                // DETAIL ASSETS MONTH //

                                // DETAIL TARGET ASSSES SUB 1 //
                                var assetsSub1 = dataJson.data_detail_assetssub
                                var setAssetsSub1 = [{
                                    label: assetsSub1.map(function(v){return v.label}),
                                    data: assetsSub1.map(function(v){return v.data})
                                }];
                                var ctxAssetsSub1 = document.getElementById("detailAssetsSub1");
                                ctxAssetsSub1.height = 300;
                                var ict_unit = [];
                                var efficiency = [];
                                var coloR = [];
                                var dynamicColors = function() {
                                    var r = Math.floor(Math.random() * 255);
                                    var g = Math.floor(Math.random() * 255);
                                    var b = Math.floor(Math.random() * 255);
                                    return "rgb(" + r + "," + g + "," + b + ")";
                                };
                                // var data = dataJson.data_detail_assetssub;
                                var data = setAssetsSub1[0].data
                                for (var i in data) {
                                    ict_unit.push("ICT Unit " + data[i].ict_unit);
                                    efficiency.push(data[i].efficiency);
                                    coloR.push(dynamicColors());
                                }
                                var assetsSub1Chart = new Chart(ctxAssetsSub1, {
                                    type: 'bar',
                                    data: {
                                        // labels: dataJson.data_detail_assetssub_label,
                                        labels: setAssetsSub1[0].label,
                                        datasets: [{
                                            axis: 'y',
                                            label: '',
                                            data: setAssetsSub1[0].data,
                                            fill: false,
                                            minBarLength: 2,
                                            barThickness: 20,
                                            maxBarThickness: 20,
                                            // backgroundColor: coloR,
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 1)',
                                                'rgba(255, 159, 64, 1)',
                                                'rgba(255, 205, 86, 1)',
                                                'rgba(75, 192, 192, 1)',
                                                'rgba(54, 162, 235, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(201, 203, 207, 1)'
                                            ],
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: true,
                                        responsiveAnimationDuration: 5000,
                                        indexAxis: 'y',
                                        scales: {
                                            x: {
                                                display: false
                                            },
                                            y: {
                                                ticks: {
                                                    font: {
                                                        size: 13,
                                                    },
                                                    color: '#FFF'
                                                },
                                            }
                                        },
                                        plugins: {
                                            legend: {
                                                display: false
                                            },
                                            datalabels: {
                                                color: '#FFF',
                                                // margin: 5
                                            }
                                        },
                                    },
                                    plugins: [ChartDataLabels],
                                });
                                // ASSETS DETAIL SUB 1 //

                                // LIST EVENT
                                document.getElementById("detailAssets").onclick = function(evt) {
                                    var activePoints = assetsMonthChart.getElementsAtEventForMode(evt, 'point', assetsMonthChart.options);
                                    var firstPoint = activePoints[0];
                                    var topIndexSmallBody = $("#topIndexSmall .modal-body")

                                    if(firstPoint)
                                    {
                                        var label = assetsMonthChart.data.labels[firstPoint.index];
                                        var data = assetsMonthChart.data.datasets[0].data[0];

                                        topIndexSmallBody.html(animateLoading());
                                        $("#topIndexSmall").modal();
                                        $('#topIndexSmallLabel').text(category+' - '+label);

                                        $.ajax({
                                            url: '{{ url('srs/dashboard_v2/detail_event_list') }}',
                                            type: 'POST',
                                            data: {
                                                _token: "{{ csrf_token() }}",
                                                area_fil: areaFilter,
                                                year_fil: yearFilter,
                                                month_fil: (firstPoint.index+1), // label
                                                asset_id: id,
                                            },
                                            cache: false,
                                            timeout: 10000,
                                            beforeSend: function() {
                                            },
                                            complete: function() {
                                                topIndexSmallBody.find('.loader').remove();
                                            },
                                            error: function(xhr, textStatus, errorThrown) {
                                                if (textStatus == 'timeout') {
                                                    topIndexSmallBody.find('.loader').remove();
                                                    topIndexSmallBody.append("Error : Timeout for this call!");
                                                }
                                            },
                                            success: function(res) {
                                                topIndexSmallBody.append(res);
                                            }
                                        });
                                    }
                                }
                                // LIST EVENT //

                                // GRAP ASSETS MONTH SUB 1 //
                                document.getElementById("detailAssetsSub1").onclick = function(evt) {
                                    var activePoints = assetsSub1Chart.getElementsAtEventForMode(evt, 'point', assetsSub1Chart.options);
                                    var firstPoint = activePoints[0];
                                    var label = assetsSub1Chart.data.labels[firstPoint.index];
                                    var value = assetsSub1Chart.data.datasets[firstPoint.datasetIndex].data[firstPoint.index];
                                    var id = assetsSub1[firstPoint.index].id;
                                    var category = label;

                                    var area = $("#areaFilter").val()
                                    var year = $("#yearFilter").val()
                                    var month = $("#monthFilter").val()
                                    var labelTitle = label;

                                    $('#detailGrapLabel').text(labelTitle)
                                    $('#detailAssets').parent().append(animateLoading('loader-full'))

                                    $.ajax({
                                        url: '{{ url('srs/dashboard_v2/grap_detail_assets') }}',
                                        type: 'POST',
                                        data: {
                                            _token: "{{ csrf_token() }}",
                                            area_fil: areaFilter,
                                            year_fil: yearFilter,
                                            month_fil: monthFilter,
                                            // label_fil: label,
                                            id_fil: id,
                                        },
                                        cache: false,
                                        beforeSend: function() {
                                        },
                                        complete: function() {
                                            detailGrapBody.find('.loader').remove();
                                        },
                                        success: function(res) {
                                            var dataJson = JSON.parse(res)

                                            // GRAFIS LINE ALL MONTH //
                                            assetsMonthChart.data.datasets[0].data = dataJson.data_assets_month_sub1;
                                            assetsMonthChart.update();
                                            // GRAFIS LINE ALL MONTH //

                                            // ASSETS DETAIL SUB 2 //
                                            var dataAssetsSub2 = dataJson.data_detail_assetssub2
                                            var setAssetsSub2 = [{
                                                label: dataAssetsSub2.map(function(v){return v.label}),
                                                data: dataAssetsSub2.map(function(v){return v.data})
                                            }];
                                            assetsSub2Chart.data.labels = setAssetsSub2[0].label;
                                            assetsSub2Chart.data.datasets[0].data = setAssetsSub2[0].data;
                                            assetsSub2Chart.update();
                                            // ASSETS DETAIL SUB 2 //

                                            // LIST EVENT
                                            document.getElementById("detailAssets").onclick = function(evt) {
                                                var activePoints = assetsMonthChart.getElementsAtEventForMode(evt, 'point', assetsMonthChart.options);
                                                var firstPoint = activePoints[0];

                                                if(firstPoint)
                                                {
                                                    var label = assetsMonthChart.data.labels[firstPoint.index];
                                                    var data = assetsMonthChart.data.datasets[0].data[0];

                                                    topIndexSmallBody.html(animateLoading());
                                                    $("#topIndexSmall").modal();
                                                    $('#topIndexSmallLabel').text(category+' - '+label);

                                                    $.ajax({
                                                        url: '{{ url('srs/dashboard_v2/detail_event_list') }}',
                                                        type: 'POST',
                                                        data: {
                                                            _token: "{{ csrf_token() }}",
                                                            area_fil: areaFilter,
                                                            year_fil: yearFilter,
                                                            month_fil: (firstPoint.index+1), // label
                                                            asset_sub1_id: id,
                                                        },
                                                        cache: false,
                                                        timeout: 10000,
                                                        beforeSend: function() {
                                                        },
                                                        complete: function() {
                                                            topIndexSmallBody.find('.loader').remove();
                                                        },
                                                        error: function(xhr, textStatus, errorThrown) {
                                                            if (textStatus == 'timeout') {
                                                                topIndexSmallBody.find('.loader').remove();
                                                                topIndexSmallBody.append("Error : Timeout for this call!");
                                                            }
                                                        },
                                                        success: function(res) {
                                                            topIndexSmallBody.append(res);
                                                        }
                                                    });
                                                }
                                            }
                                            // LIST EVENT //

                                            // GRAP ASSETS MONTH SUB 2 //
                                            $('#assetsSub2Title').text('')
                                            assetsSub2MonthChart.data.datasets[0].data = [];
                                            assetsSub2MonthChart.update();
                                            document.getElementById("detailAssetsSub2").onclick = function(evt) {
                                                var activePoints = assetsSub2Chart.getElementsAtEventForMode(evt, 'point', assetsSub2Chart.options);
                                                var firstPoint = activePoints[0];
                                                var label = assetsSub2Chart.data.labels[firstPoint.index];
                                                var value = assetsSub2Chart.data.datasets[firstPoint.datasetIndex].data[firstPoint.index];

                                                var area = $("#areaFilter").val()
                                                var year = $("#yearFilter").val()
                                                var month = $("#monthFilter").val()
                                                var id = dataAssetsSub2[firstPoint.index].id;
                                                var labelTitle = label;

                                                $('#assetsSub2Title').text(labelTitle)
                                                $('#assetsSub2Month').parent().append(animateLoading('loader-full'))

                                                $.ajax({
                                                    url: '{{ url('srs/dashboard_v2/grap_detail_assets') }}',
                                                    type: 'POST',
                                                    data: {
                                                        _token: "{{ csrf_token() }}",
                                                        area_fil: areaFilter,
                                                        year_fil: yearFilter,
                                                        month_fil: monthFilter,
                                                        id_fil: id,
                                                    },
                                                    cache: false,
                                                    beforeSend: function() {
                                                    },
                                                    complete: function() {
                                                        detailGrapBody.find('.loader').remove();
                                                    },
                                                    success: function(res) {
                                                        var dataJson = JSON.parse(res)

                                                        // GRAFIS LINE ALL MONTH //
                                                        assetsSub2MonthChart.data.datasets[0].data = dataJson.data_assets_month_sub2;
                                                        assetsSub2MonthChart.update();
                                                        // GRAFIS LINE ALL MONTH //

                                                        // LIST EVENT 2
                                                        document.getElementById("assetsSub2Month").onclick = function(evt) {
                                                            var activePoints = assetsSub2MonthChart.getElementsAtEventForMode(evt, 'point', assetsSub2MonthChart.options);
                                                            var firstPoint = activePoints[0];

                                                            if(firstPoint)
                                                            {
                                                                var label = assetsSub2MonthChart.data.labels[firstPoint.index];
                                                                var data = assetsSub2MonthChart.data.datasets[0].data[0];

                                                                topIndexSmallBody.html(animateLoading());
                                                                $("#topIndexSmall").modal();
                                                                $('#topIndexSmallLabel').text(category+' - '+label);

                                                                $.ajax({
                                                                    url: '{{ url('srs/dashboard_v2/detail_event_list') }}',
                                                                    type: 'POST',
                                                                    data: {
                                                                        _token: "{{ csrf_token() }}",
                                                                        area_fil: areaFilter,
                                                                        year_fil: yearFilter,
                                                                        month_fil: (firstPoint.index+1), // label
                                                                        asset_sub2_id: id,
                                                                    },
                                                                    cache: false,
                                                                    timeout: 10000,
                                                                    beforeSend: function() {
                                                                    },
                                                                    complete: function() {
                                                                        topIndexSmallBody.find('.loader').remove();
                                                                    },
                                                                    error: function(xhr, textStatus, errorThrown) {
                                                                        if (textStatus == 'timeout') {
                                                                            topIndexSmallBody.find('.loader').remove();
                                                                            topIndexSmallBody.append("Error : Timeout for this call!");
                                                                        }
                                                                    },
                                                                    success: function(res) {
                                                                        topIndexSmallBody.append(res);
                                                                    }
                                                                });
                                                            }
                                                        }
                                                        // LIST EVENT 2 //
                                                    }
                                                })
                                            }
                                            // GRAP ASSETS MONTH SUB 2 //
                                        }
                                    })
                                }
                                // GRAP ASSETS MONTH SUB 1 //

                                // ASSETS DETAIL SUB 2 //
                                var dataAssetsSub2 = dataJson.data_detail_assetssub2
                                var setAssetsSub2 = [{
                                    label: dataAssetsSub2.map(function(v){return v.label}),
                                    data: dataAssetsSub2.map(function(v){return v.data})
                                }];
                                var colorRand = getColorRand(setAssetsSub2[0].label.length);
                                var assetsSub2 = document.getElementById("detailAssetsSub2").getContext('2d');
                                var assetsSub2Chart = new Chart(assetsSub2, {
                                    type: 'pie',
                                    data: {
                                        labels: [],
                                        datasets: [
                                            {
                                                data: [],
                                                hoverOffset: 10,
                                                backgroundColor: colorRand,
                                                // spacing: 0,
                                                // borderAlign: 'center',
                                                // offset: 3,
                                            }
                                        ]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        layout: {
                                            padding: {
                                                top: 10,
                                                bottom: 5,
                                                left: 5,
                                                // right: 5,
                                            }
                                        },
                                        plugins: {
                                            legend: {
                                                display: true,
                                                position: 'right',
                                                labels: {
                                                    boxWidth: 10
                                                }
                                            },
                                            title: {
                                                display: false,
                                                text: 'Chart.js Pie Chart'
                                            },
                                            labels: [
                                                // render: (args) => {
                                                //     return `${args.label}\n(${args.value})`
                                                // },
                                                // {
                                                //     render: (args) => {
                                                //         return `${args.label}`
                                                //     },
                                                //     position: 'outside',
                                                //     fontColor: '#fff',
                                                //     fontSize: 12,
                                                //     arc: true,
                                                //     // textMargin: 18,
                                                //     // showZero: true,
                                                //     // overlap: true,
                                                // },
                                                {
                                                    render: (args) => {
                                                        return `${args.value}`
                                                    },
                                                    fontColor: '#fff',
                                                },
                                            ],
                                        },
                                    },
                                })
                                // ASSETS DETAIL SUB 2 //

                                // ASSETS SUB 2 MONTH //
                                var assetsSub2Month = document.getElementById("assetsSub2Month").getContext('2d');
                                const bgMSub2 = assetsSub2Month.createLinearGradient(0, 0, 0, 400);
                                bgMSub2.addColorStop(0.6, 'rgba(20, 180, 60, 1)');
                                bgMSub2.addColorStop(0.4, 'rgba(90, 160, 90, 0.2)');
                                bgMSub2.addColorStop(0.1, 'blue');
                                var assetsSub2MonthChart = new Chart(assetsSub2Month, {
                                    type: 'line',
                                    data: {
                                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                                        datasets: [{
                                            pointStyle: 'circle',
                                            pointRadius: 8,
                                            label: '',
                                            data: [],
                                            fill: true,
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 1)',
                                                'rgba(255, 205, 86, 1)',
                                                'rgba(54, 162, 235, 1)',
                                                'rgba(255, 159, 64, 1)',
                                                'rgba(75, 192, 192, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(201, 203, 207, 1)'
                                            ],
                                            tension: 0.1,
                                            segment: {
                                                borderColor: 'red',
                                                backgroundColor: 'rgba(201, 90, 80, 0.3)',
                                            },
                                            borderWidth: 1,
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        scales: {
                                            x: {
                                                ticks: {
                                                    font: {
                                                        size: 13,
                                                    },
                                                    color: '#FFF'
                                                },
                                            },
                                            y: {
                                                grid: {
                                                    display: false
                                                },
                                                ticks: {
                                                    precision: 0,
                                                    color: '#FFF'
                                                },
                                                min: 0,
                                            }
                                        },
                                        plugins: {
                                            legend: {
                                                display: false
                                            },
                                            datalabels: {
                                                color: '#FFF'
                                            }
                                        },
                                    }
                                });
                                // ASSETS SUB 2 MONTH //
                            }
                        });
                    }
                };
                // DETAIL TARGET ASSETS //
            }
        });
    }
	// FUNCTION TARGET ASSETS //

	// FUNCTION RISK //
    function srsRisks(riskChart) {
		var riskChartId = document.querySelector('#riskChart')

        $.ajax({
            url: '{{ url('menu/srsRisk') }}',
            type: 'POST',
            data: {
				_token: "{{ csrf_token() }}",
                area_fil: areaFilter,
                year_fil: yearFilter,
                month_fil: monthFilter,
            },
            cache: false,
			timeout: 10000,
            beforeSend: function() {
            },
            error: function(xhr, textStatus, errorThrown) {
                if (textStatus == 'timeout') {
                    riskChartId.parentElement.innerHTML = "Error : Timeout for this call!";
                }
            },
            complete: function() {
                riskChartId.parentElement.querySelector('.loader').remove();
                riskChartId.style.display = 'block';
            },
            success: function(res) {
                var json = JSON.parse(res)

                var dataRisk = json
                var setRisk = [{
                    label: dataRisk.map(function(v) {
                        return v.label
                    }),
                    data: dataRisk.map(function(v) {
                        return v.total
                    })
                }];

                riskChart.data.labels = setRisk[0].label
                riskChart.data.datasets[0].data = setRisk[0].data
                riskChart.update();

                // DETAIL RISK //
                document.getElementById("riskChart").onclick = function(evt) {
                    var activePoints = riskChart.getElementsAtEventForMode(evt, 'point', riskChart.options);
                    var firstPoint = activePoints[0];

                    if(firstPoint) {
                        var label = riskChart.data.labels[firstPoint.index];
                        var id = dataRisk[firstPoint.index].id;
                        var category = label;

                        var area = $("#areaFilter").val()
                        var year = $("#yearFilter").val()
                        var month = $("#monthFilter").val()
                        var labelTitle = label;

                        detailGrapBody.html(animateLoading());
                        $('#detailGrapLabel').text(labelTitle)
                        $("#detailGrap").modal();

                        $.ajax({
                            url: '{{ url('srs/dashboard_v2/grap_detail_risk') }}',
                            type: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}",
                                area_fil: areaFilter,
                                year_fil: yearFilter,
                                month_fil: monthFilter,
                                id_fil: id,
                            },
                            cache: false,
                            beforeSend: function() {
                            },
                            complete: function() {
                                detailGrapBody.find('.loader').remove();
                            },
                            success: function(res) {
                                var dataJson = JSON.parse(res)

                                $("#detailGrap .modal-body").append(`
                                    <div class="row py-3 mb-5">
                                        <div class="col-md-5 pr-5">
                                            <canvas id="detailRiskSub1"></canvas>
                                        </div>
                                        <div class="col-md-7" style="height:300px;">
                                            <canvas id="detailRisk"></canvas>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 border-top py-3">
                                            <div class="col-md-12 mb-3">
                                                <span id="riskSub2Title" class="h5 mb-5"></span>
                                            </div>
                                            <div class="row">
                                                <div style="height:300px;" class="col-md-5 pr-5">
                                                    <canvas id="riskSub2"></canvas>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="row">
                                                        <div style="height:300px;" class="col-md-12">
                                                            <canvas id="riskSub2Month"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `);

                                // RISK MONTH //
                                var detailRisk = document.getElementById("detailRisk").getContext('2d');
                                const bgGradient = detailRisk.createLinearGradient(0, 0, 0, 400);
                                bgGradient.addColorStop(0.6, 'rgba(20, 180, 60, 1)');
                                bgGradient.addColorStop(0.4, 'rgba(90, 160, 90, 0.2)');
                                bgGradient.addColorStop(0.1, 'blue');
                                
                                var riskMonthChart = new Chart(detailRisk, {
                                    type: 'line',
                                    data: {
                                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                                        datasets: [{
                                            pointStyle: 'circle',
                                            pointRadius: 8,
                                            label: '',
                                            data: dataJson.data_risk_month,
                                            fill: true,
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 1)',
                                                'rgba(255, 205, 86, 1)',
                                                'rgba(54, 162, 235, 1)',
                                                'rgba(255, 159, 64, 1)',
                                                'rgba(75, 192, 192, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(201, 203, 207, 1)'
                                            ],
                                            tension: 0.1,
                                            segment: {
                                                borderColor: 'red',
                                                backgroundColor: 'rgba(201, 90, 80, 0.3)',
                                            },
                                            borderWidth: 1,
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        scales: {
                                            x: {
                                                ticks: {
                                                    font: {
                                                        size: 13,
                                                    },
                                                    color: '#FFF'
                                                },
                                            },
                                            y: {
                                                grid: {
                                                    display: false
                                                },
                                                ticks: {
                                                    color: '#FFF',
                                                    precision: 0,
                                                },
                                                min: 0,
                                            },
                                        },
                                        plugins: {
                                            legend: {
                                                display: false
                                            },
                                            datalabels: {
                                                color: '#FFF'
                                            }
                                        },
                                    }
                                });
                                // RISK MONTH //

                                // RISK SUB 1 //
                                var dataRiSub1 = dataJson.data_risk_sub1
                                var setRiSub1 = [{
                                    label: dataRiSub1.map(function(v){return v.label}),
                                    data: dataRiSub1.map(function(v){return v.data})
                                }];

                                var ctxRisSub = document.getElementById("detailRiskSub1");
                                // ctxRisSub.height = 100;
                                var ict_unit = [];
                                var efficiency = [];
                                var coloR = [];
                                var dynamicColors = function() {
                                    var r = Math.floor(Math.random() * 255);
                                    var g = Math.floor(Math.random() * 255);
                                    var b = Math.floor(Math.random() * 255);
                                    return "rgb(" + r + "," + g + "," + b + ")";
                                };
                                var data = setRiSub1[0].data;
                                for (var i in data) {
                                    ict_unit.push("ICT Unit " + data[i].ict_unit);
                                    efficiency.push(data[i].efficiency);
                                    coloR.push(dynamicColors());
                                }
                                var risMntChart = new Chart(ctxRisSub, {
                                    type: 'bar',
                                    data: {
                                        labels: setRiSub1[0].label,
                                        datasets: [{
                                            axis: 'y',
                                            label: '',
                                            data: setRiSub1[0].data,
                                            fill: false,
                                            minBarLength: 2,
                                            barThickness: 20,
                                            maxBarThickness: 20,
                                            // backgroundColor: coloR,
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 1)',
                                                'rgba(255, 159, 64, 1)',
                                                'rgba(255, 205, 86, 1)',
                                                'rgba(75, 192, 192, 1)',
                                                'rgba(54, 162, 235, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(201, 203, 207, 1)'
                                            ],
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsiveAnimationDuration: 5000,
                                        indexAxis: 'y',
                                        scales: {
                                            x: {
                                                display: false
                                            },
                                            y: {
                                                ticks: {
                                                    font: {
                                                        size: 13,
                                                    },
                                                    color: '#FFF'
                                                },
                                            }
                                        },
                                        plugins: {
                                            legend: {
                                                display: false
                                            },
                                            datalabels: {
                                                color: '#FFF',
                                                // margin: 5
                                            }
                                        },
                                    },
                                    plugins: [ChartDataLabels],
                                });
                                // RISK SUB 1 //

                                // LIST EVENT
                                document.getElementById("detailRisk").onclick = function(evt) {
                                    var activePoints = riskMonthChart.getElementsAtEventForMode(evt, 'point', riskMonthChart.options);
                                    var firstPoint = activePoints[0];

                                    if(firstPoint)
                                    {
                                        var data = riskMonthChart.data.datasets[0].data[0];
                                        var label = riskMonthChart.data.labels[firstPoint.index];

                                        topIndexSmallBody.html(animateLoading());
                                        $("#topIndexSmall").modal();
                                        $('#topIndexSmallLabel').text(category+' - '+label);

                                        $.ajax({
                                            url: '{{ url('srs/dashboard_v2/detail_event_list') }}',
                                            type: 'POST',
                                            data: {
                                                _token: "{{ csrf_token() }}",
                                                area_fil: areaFilter,
                                                year_fil: yearFilter,
                                                month_fil: (firstPoint.index+1), // label
                                                risk_id: id,
                                            },
                                            cache: false,
                                            timeout: 10000,
                                            beforeSend: function() {
                                            },
                                            complete: function() {
                                                topIndexSmallBody.find('.loader').remove();
                                            },
                                            error: function(xhr, textStatus, errorThrown) {
                                                if (textStatus == 'timeout') {
                                                    topIndexSmallBody.find('.loader').remove();
                                                    topIndexSmallBody.append("Error : Timeout for this call!");
                                                }
                                            },
                                            success: function(res) {
                                                topIndexSmallBody.append(res);
                                            }
                                        });
                                    }
                                }
                                // LIST EVENT //

                                // RISK SUB 1 MONTH //
                                document.getElementById("detailRiskSub1").onclick = function(evt) {
                                    var activePoints = risMntChart.getElementsAtEventForMode(evt, 'point', risMntChart.options);
                                    var firstPoint = activePoints[0];

                                    if(firstPoint) {
                                        var label = risMntChart.data.labels[firstPoint.index];
                                        var id = dataRiSub1[firstPoint.index].id;
                                        var category = label;

                                        var area = $("#areaFilter").val()
                                        var year = $("#yearFilter").val()
                                        var month = $("#monthFilter").val()
                                        var labelTitle = label;

                                        $('#detailGrapLabel').text(labelTitle)
                                        $('#detailRisk').parent().append(animateLoading('loader-full'))

                                        $.ajax({
                                            url: '{{ url('srs/dashboard_v2/grap_detail_risk') }}',
                                            type: 'POST',
                                            data: {
                                                _token: "{{ csrf_token() }}",
                                                area_fil: areaFilter,
                                                year_fil: yearFilter,
                                                month_fil: monthFilter,
                                                id_fil: id,
                                            },
                                            cache: false,
                                            beforeSend: function() {
                                            },
                                            complete: function() {
                                                detailGrapBody.find('.loader').remove();
                                            },
                                            success: function(res) {
                                                var dataJson = JSON.parse(res)

                                                // GRAFIS LINE ALL MONTH //
                                                riskMonthChart.data.datasets[0].data = dataJson.data_risk_sub1_month;
                                                riskMonthChart.update();
                                                // GRAFIS LINE ALL MONTH //

                                                // RISK SUB 2 PIE //
                                                dataRiSub2 = dataJson.data_risk_sub2
                                                setRisSub2 = [{
                                                    label: dataRiSub2.map(function(v){return v.label}),
                                                    data: dataRiSub2.map(function(v){return v.data})
                                                }];
                                                risSub2Chart.data.labels = setRisSub2[0].label;
                                                risSub2Chart.data.datasets[0].data = setRisSub2[0].data;
                                                risSub2Chart.update();
                                                // RISK SUB 2 PIE //

                                                // RISK SUB 2 MONTH //
                                                $('#riskSub2Title').text('') // remove current title
                                                risSub2MonthChart.data.datasets[0].data = [];
                                                risSub2MonthChart.update(); // clear data

                                                // LIST EVENT
                                                document.getElementById("detailRisk").onclick = function(evt) {
                                                    var activePoints = riskMonthChart.getElementsAtEventForMode(evt, 'point', riskMonthChart.options);
                                                    var firstPoint = activePoints[0];

                                                    if(firstPoint)
                                                    {
                                                        var data = riskMonthChart.data.datasets[0].data[0];
                                                        var label = riskMonthChart.data.labels[firstPoint.index];

                                                        topIndexSmallBody.html(animateLoading());
                                                        $("#topIndexSmall").modal();
                                                        $('#topIndexSmallLabel').text(category+' - '+label);

                                                        $.ajax({
                                                            url: '{{ url('srs/dashboard_v2/detail_event_list') }}',
                                                            type: 'POST',
                                                            data: {
                                                                _token: "{{ csrf_token() }}",
                                                                area_fil: area,
                                                                year_fil: year,
                                                                month_fil: (firstPoint.index+1), // label
                                                                risk_sub1_id: id,
                                                            },
                                                            cache: false,
                                                            timeout: 10000,
                                                            beforeSend: function() {
                                                            },
                                                            complete: function() {
                                                                topIndexSmallBody.find('.loader').remove();
                                                            },
                                                            error: function(xhr, textStatus, errorThrown) {
                                                                if (textStatus == 'timeout') {
                                                                    topIndexSmallBody.find('.loader').remove();
                                                                    topIndexSmallBody.append("Error : Timeout for this call!");
                                                                }
                                                            },
                                                            success: function(res) {
                                                                topIndexSmallBody.append(res);
                                                            }
                                                        });
                                                    }
                                                }
                                                // LIST EVENT //

                                                document.getElementById("riskSub2").onclick = function(evt) {
                                                    var activePoints = risSub2Chart.getElementsAtEventForMode(evt, 'point', risSub2Chart.options);
                                                    var firstPoint = activePoints[0];

                                                    if(firstPoint) {
                                                        var label = risSub2Chart.data.labels[firstPoint.index];
                                                        var value = risSub2Chart.data.datasets[firstPoint.datasetIndex].data[firstPoint.index];
                                                        var labelTitle = label;
                                                        var category = label;

                                                        var area = $("#areaFilter").val()
                                                        var year = $("#yearFilter").val()
                                                        var month = $("#monthFilter").val()
                                                        var id = dataRiSub2[firstPoint.index].id;

                                                        $('#riskSub2Title').text(labelTitle)
                                                        $('#riskSub2Month').parent().append(animateLoading('loader-full'))

                                                        $.ajax({
                                                            url: '{{ url('srs/dashboard_v2/grap_detail_risk') }}',
                                                            type: 'POST',
                                                            data: {
                                                                _token: "{{ csrf_token() }}",
                                                                area_fil: area,
                                                                year_fil: year,
                                                                month_fil: month,
                                                                id_fil: id,
                                                            },
                                                            cache: false,
                                                            beforeSend: function() {
                                                            },
                                                            complete: function() {
                                                                detailGrapBody.find('.loader').remove();
                                                            },
                                                            success: function(res) {
                                                                var dataJson = JSON.parse(res)

                                                                // GRAFIS LINE ALL MONTH //
                                                                risSub2MonthChart.data.datasets[0].data = dataJson.data_risk_sub2_month;
                                                                risSub2MonthChart.update();
                                                                // GRAFIS LINE ALL MONTH //

                                                                // LIST EVENT 2
                                                                document.getElementById("riskSub2Month").onclick = function(evt) {
                                                                    var activePoints = risSub2MonthChart.getElementsAtEventForMode(evt, 'point', risSub2MonthChart.options);
                                                                    var firstPoint = activePoints[0];

                                                                    if(firstPoint)
                                                                    {
                                                                        var data = risSub2MonthChart.data.datasets[0].data[0];
                                                                        var label = risSub2MonthChart.data.labels[firstPoint.index];

                                                                        topIndexSmallBody.html(animateLoading());
                                                                        $("#topIndexSmall").modal();
                                                                        $('#topIndexSmallLabel').text(category+' - '+label);

                                                                        $.ajax({
                                                                            url: '{{ url('srs/dashboard_v2/detail_event_list') }}',
                                                                            type: 'POST',
                                                                            data: {
                                                                                _token: "{{ csrf_token() }}",
                                                                                area_fil: area,
                                                                                year_fil: year,
                                                                                month_fil: (firstPoint.index+1), // label
                                                                                risk_sub2_id: id,
                                                                            },
                                                                            cache: false,
                                                                            timeout: 10000,
                                                                            beforeSend: function() {
                                                                            },
                                                                            complete: function() {
                                                                                topIndexSmallBody.find('.loader').remove();
                                                                            },
                                                                            error: function(xhr, textStatus, errorThrown) {
                                                                                if (textStatus == 'timeout') {
                                                                                    topIndexSmallBody.find('.loader').remove();
                                                                                    topIndexSmallBody.append("Error : Timeout for this call!");
                                                                                }
                                                                            },
                                                                            success: function(res) {
                                                                                topIndexSmallBody.append(res);
                                                                            }
                                                                        });
                                                                    }
                                                                }
                                                                // LIST EVENT 2 //
                                                            }
                                                        })
                                                    }
                                                }
                                                // RISK SUB 2 MONTH //
                                            }
                                        })
                                    }
                                }
                                // RISK SUB 1 MONTH //
                                
                                // RISK PIE SUB 2 //
                                var dataRiSub2 = dataJson.data_risk_sub2
                                var setRisSub2 = [{
                                    label: dataRiSub2.map(function(v){return v.label}),
                                    data: dataRiSub2.map(function(v){return v.data})
                                }];
                                var colorRand = getColorRand(setRisSub2[0].label.length);
                                var risSub2 = document.getElementById("riskSub2").getContext('2d');
                                var risSub2Chart = new Chart(risSub2, {
                                    type: 'pie',
                                    data: {
                                        labels: [],
                                        datasets: [
                                            {
                                                data: [],
                                                hoverOffset: 10,
                                                backgroundColor: colorRand,
                                            }
                                        ]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        layout: {
                                            padding: {
                                                top: 10,
                                                bottom: 5,
                                                left: 5,
                                                // right: 5,
                                            }
                                        },
                                        plugins: {
                                            legend: {
                                                display: true,
                                                position: 'right',
                                                labels: {
                                                    boxWidth: 10
                                                }
                                            },
                                            title: {
                                                display: false,
                                                text: 'Chart.js Pie Chart'
                                            },
                                            labels: [
                                                {
                                                    render: (args) => {
                                                        return `${args.value}`
                                                    },
                                                    fontColor: '#fff',
                                                },
                                            ],
                                        },
                                    },
                                })
                                // RISK PIE SUB 2 //

                                // RISK MONTH SUB 2 //
                                var risSub2Month = document.getElementById("riskSub2Month").getContext('2d');
                                const bgMSub2 = risSub2Month.createLinearGradient(0, 0, 0, 400);
                                bgMSub2.addColorStop(0.6, 'rgba(20, 180, 60, 1)');
                                bgMSub2.addColorStop(0.4, 'rgba(90, 160, 90, 0.2)');
                                bgMSub2.addColorStop(0.1, 'blue');

                                var risSub2MonthChart = new Chart(risSub2Month, {
                                    type: 'line',
                                    data: {
                                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                                        datasets: [{
                                            pointStyle: 'circle',
                                            pointRadius: 8,
                                            label: '',
                                            data: [],
                                            fill: true,
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 1)',
                                                'rgba(255, 205, 86, 1)',
                                                'rgba(54, 162, 235, 1)',
                                                'rgba(255, 159, 64, 1)',
                                                'rgba(75, 192, 192, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(201, 203, 207, 1)'
                                            ],
                                            tension: 0.1,
                                            segment: {
                                                borderColor: 'red',
                                                backgroundColor: 'rgba(201, 90, 80, 0.3)',
                                            },
                                            borderWidth: 1,
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        scales: {
                                            x: {
                                                ticks: {
                                                    font: {
                                                        size: 13,
                                                    },
                                                    color: '#FFF'
                                                },
                                            },
                                            y: {
                                                grid: {
                                                    display: false
                                                },
                                                ticks: {
                                                    precision: 0,
                                                    color: '#FFF'
                                                },
                                                min: 0,
                                            }
                                        },
                                        plugins: {
                                            legend: {
                                                display: false
                                            },
                                            datalabels: {
                                                color: '#FFF'
                                            }
                                        },
                                    }
                                });
                                // RISK MONTH SUB 2 //
                            }
                        });
                    }
                };
                // DETAIL RISK //
            }
        });
    }
    // FUNCTION RISK //
    
    // DETAIL EVENT
    $(document).on('click', '.detail-list-event', function (e){
        var detailGrapSmall2 = $('#detailGrapSmall2');
        var detailGrapSmall2Body = $('#detailGrapSmall2 .modal-body');
        var detailGrapSmall2Label = $('#detailGrapSmall2Label');
        const id = $(this).data('id')
        console.log(id)
        
        detailGrapSmall2Body.html(animateLoading());
        detailGrapSmall2.modal();
        detailGrapSmall2Label.text('Detail Event');

        $.ajax({
            url: '{{ url('srs/humint_source/detail') }}',
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
            },
            cache: false,
            beforeSend: function() {
            },
            complete: function() {
                detailGrapSmall2Body.find('.loader').remove();
            },
            error: function(xhr, textStatus, errorThrown) {
                if (textStatus == 'timeout') {
                    detailGrapSmall2Body.find('.loader').remove();
                    detailGrapSmall2Body.append("Error : Timeout for this call!");
                }
            },
            success : function(data){
                detailGrapSmall2Body.html(data);//menampilkan data ke dalam modal
            }
        });
    })
    // DETAIL EVENT //

    // ALL CHART WHEN UPDATE FILTER //
    $("#areaFilter, #yearFilter, #monthFilter").change(function(e) {
        var field = [
            areaFilter = $("#areaFilter").val(),
            yearFilter = $("#yearFilter").val(),
            monthFilter = $("#monthFilter").val(),
            currYear = '{!! date('Y') !!}',
            currMonth = '{!! date('m') !!}',
        ]
        
        // LOADING
        loadingAllBox();
        // LOADING
        
        soiIndexResiko(soiChart)
        daughnutMonhtly(dougnutChartAll)
        daughnutPlant(dougnutChartPlant)
        riskTransSource(rsoChart)
		srsTargetAssets(assetChart)
		srsRisks(riskChart)
        
        // var area = $("#areaFilter").val()
        // var year = $("#yearFilter").val()
        // var month = $("#monthFilter").val()

        // // SOI Deskripsi
        // if(year == '2022' && month.length == 0)
        // {
        //     $('#isoDesc').show()
        // }
        // else
        // {
        //     $('#isoDesc').hide()
        // }

        // $.ajax({
        //     url: "{{ url('srs/dashboard_humint_v2/grap_srs') }}",
        //     type: 'POST',
        //     data: {
        //         _token: "{{ csrf_token() }}",
        //         area_fil: area,
        //         year_fil: year,
        //         month_fil: month,
        //     },
        //     cache: false,
        //     beforeSend: function() {
        //         // $(".lds-ring").show();
        //         document.getElementById("loader").style.display = "block";
        //     },
        //     complete: function() {
        //         document.getElementById("loader").style.display = "none";
        //     },
        //     success: function(res) {
        //         var json = JSON.parse(res)
        //         console.log(json)
                
        //         // SOI //
        //         var dataSrs = [{
        //             r: 8,
        //             x: parseFloat(json.data_soi[0].avg_soi),
        //             y: parseFloat(json.data_index[0].max_iso)
        //         }];
        //         soiChart.data.datasets[0].data = dataSrs;
        //         soiChart.update();

        //         // INDEX BG SOI //
        //         const dataX = json.data_soi[0].avg_soi;
        //         const dataY = json.data_index[0].max_iso;

        //         if((dataX <= 4 && dataY <= 2) || (dataX >= 4 && dataY >= 2))
        //         {
        //             $('#indexSoi').attr('style','background-color: rgb(233 233 9 / 69%)') // yellow
        //         }
                
        //         if(dataX >= 4 && dataY <= 2)
        //         {
        //             $('#indexSoi').attr('style','background-color: rgb(0 128 9 / 69%)') // green
        //         }
                
        //         if(dataX <= 4 && dataY >= 2)
        //         {
        //             $('#indexSoi').attr('style','background-color: rgb(255 0 9 / 69%)') // red
        //         }
        //         // INDEX BG SOI //

        //         // SOI AVG PILAR //
        //         $('#avgPeople, #avgSystem, #avgDevice, #avgNetwork').text('')
        //         $('#avgPeople').text(json.grap_soi_avgpilar[0].avg_people)
        //         $('#avgSystem').text(json.grap_soi_avgpilar[0].avg_system)
        //         $('#avgDevice').text(json.grap_soi_avgpilar[0].avg_device)
        //         $('#avgNetwork').text(json.grap_soi_avgpilar[0].avg_network)
        //         // SOI AVG PILAR //
        //         // SOI //

        //         // RISK SOURCE //
        //         dataRiskSource = json.data_risk_source;
        //         setRiskSource = [{
        //             label: dataRiskSource.map(function(v){return v.label}),
        //             data: dataRiskSource.map(function(v){return v.data})
        //         }];
        //         rsoChart.data.datasets[0].data = setRiskSource[0].data;
        //         rsoChart.data.labels = setRiskSource[0].label
        //         rsoChart.update();
        //         // RISK SOURCE //

        //         // RISK //
        //         dataRisk = json.data_risk;
        //         setRisk = [{
        //             label: dataRisk.map(function(v){return v.label}),
        //             data: dataRisk.map(function(v){return v.data})
        //         }];
        //         riskChart.data.labels = setRisk[0].label
        //         riskChart.data.datasets[0].data = setRisk[0].data
        //         riskChart.update();
        //         // RISK //

        //         // TARGET ASSETS //
        //         dataAssets = json.data_target_assets;
        //         datasetsAssets = [{
        //             label: dataAssets.map(function(v){return v.label}),
        //             data: dataAssets.map(function(v){return v.data})
        //         }];
        //         assetChart.data.datasets[0].data = datasetsAssets[0].data;
        //         assetChart.data.labels =  datasetsAssets[0].label
        //         assetChart.update();
        //         // TARGET ASSETS //

        //         // GRAFIS ALL PLANT //
        //         resAreaPolar = json.data_trans_area;
        //         dataAreaPolar = [{
        //             label: resAreaPolar.map(function(v){return v.label}),
        //             data: resAreaPolar.map(function(v){return v.total})
        //         }];
        //         dougnutChartPlant.data.labels = dataAreaPolar[0].label;
        //         dougnutChartPlant.data.datasets[0].data = dataAreaPolar[0].data;
        //         dougnutChartPlant.update();
        //         // dougnutChartPlant.data.datasets[0].data = json.data_trans_area;
        //         // dougnutChartPlant.update();
        //         // GRAFIS ALL PLANT //

        //         // GRAFIS LINE ALL MONTH //
        //         lineChart.data.datasets[0].data = json.data_trans_month;
        //         lineChart.update();
        //         // GRAFIS LINE ALL MONTH //

        //         // GRAFIS DOUGHNUT PER MONTH //
        //         dougnutChartAll.data.datasets[0].dataDUmmy = json.data_trans_month;
        //         dougnutChartAll.update();
        //         // GRAFIS DOUGHNUT PER MONTH //
        //     }
        // });
    })
</script>
@endsection