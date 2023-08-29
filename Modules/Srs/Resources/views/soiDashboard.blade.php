@extends('srs::layouts.template')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card cardIn2">
                    <div class="card-body">
                        <form id="form-filter" class="form-horizontal">
                            <div class="form-row">

                                <div class="form-group col-12 col-sm-2 col-md-2">
                                    <label for="areaFilter">Area</label>
                                    {!! $select_areas_filter !!}
                                </div>

                                <div class="form-group col-12 col-sm-2 col-md-2">
                                    <label for="yearFilter">Year</label>
                                    {!! $select_years_filter !!}
                                </div>

                                <div class="form-group col-12 col-sm-2 col-md-2">
                                    <label for="monthFilter">Month</label>
                                    {!! $select_months_filter !!}
                                </div>

                                <div class="form-group col d-flex align-items-center align-items-md-end justify-content-center justify-content-md-end">
                                    <span class="h1 ff-fugazone title-dashboard">Security Operational Index</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card cardIn2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-5 col-lg-5 pt-4 text-center">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <h2 class="text-white">Security Operational Index</h2>
                                    </div>
                                    <div class="col-sm-6 col-lg-6 p-3">
                                        <div class="info-box"  style="background:rgb(255 255 255 / 13%)">
                                            <span style="background:rgba(0, 176, 80, 1)" class="info-box-icon elevation-1">
                                                <img style="height:60%" src="{{ asset('assets/images/icon/people-white.png') }}" >
                                            </span>
                                            <div class="info-box-content  text-white">
                                                <span class="info-box-text">
                                                PEOPLE
                                                </span>
                                                <span id="avgPeople" class="info-box-number">
                                                    0.00
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-lg-6 p-3">
                                        <div class="info-box" style="background:rgb(255 255 255 / 13%)">
                                            <span style="background:rgba(0, 176, 240, 1)" class="info-box-icon elevation-1">
                                                <img style="height:60%" src="{{ asset('assets/images/icon/system-white.png') }}" >
                                            </span>
                                            <div class="info-box-content text-white">
                                                <span class="info-box-text">
                                                SYSTEM
                                                </span>
                                                <span id="avgSystem" class="info-box-number">
                                                    0.00
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-lg-6 p-3">
                                        <div class="info-box"  style="background:rgb(255 255 255 / 13%)">
                                            <span style="background:rgba(255, 0, 0, 1)" class="info-box-icon elevation-1">
                                                <img style="height:60%" src="{{ asset('assets/images/icon/device-white.png') }}" >
                                            </span>
                                            <div class="info-box-content  text-white">
                                                <span class="info-box-text">
                                                DEVICE
                                                </span>
                                                <span id="avgDevice" class="info-box-number">
                                                    0.00
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-lg-6 p-3">
                                        <div class="info-box"  style="background:rgb(255 255 255 / 13%)">
                                            <span style="background:rgba(112, 48, 160, 1)" class="info-box-icon elevation-1">
                                                <img style="height:60%" src="{{ asset('assets/images/icon/network-white.png') }}" >
                                            </span>
                                            <div class="info-box-content  text-white">
                                                <span class="info-box-text">
                                                NETWORKING
                                                </span>
                                                <span id="avgNetwork" class="info-box-number">
                                                    0.00
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-7 col-lg-7 text-white">
                                <canvas id="lineSoiAvgMonth"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 px-1" style="min-height: 300px">
                                <canvas id="lineSoiAvgAreaMonth"></canvas>
                            </div>
                            <div class="col-md-6 px-1" style="min-height: 300px">
                                <canvas id="lineSoiAvgAreaPillar"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row d-none">
            <div class="col-lg-12">
                <div class="card cardIn2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-7">
                                <canvas id="indexSoi"></canvas>
                            </div>

                            <div class="col-lg-5 pt-4 px-5 text-center">
                                <h5>Index Resiko ADM</h5>
                                <input id="indexSoiBg" class="form-control form-control-lg" type="text" placeholder="" disabled>

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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ asset('assets/vendor/chartjs/dist/chart.umd.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-annotation/2.1.0/chartjs-plugin-annotation.min.js" integrity="sha512-1uGDhRiDlpOPrTi54rJHu3oBLizqaadZDDft+j4fVeFih6eQBeRPJuuP3JcxIqJxIjzOmRq57XwwO4FT+/owIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script src="{{ asset('assets/vendor/chartjs/dist/chartjs-plugin-labels.min.js') }}"></script>

<script type="text/javascript">
    var field = [
        area = $("#areaFilter").val(),
        year = $("#yearFilter").val(),
        month = $("#monthFilter").val(),
    ]

    // LOADING
    loadingAllBox();
    function loadingAllBox() {
        var allBoxChart = document.querySelectorAll('#lineSoiAvgMonth, #lineSoiAvgAreaMonth, #lineSoiAvgAreaPillar');
        allBoxChart.forEach(function (el)
        {
            el.style.display = 'none';
            el.parentElement.insertAdjacentHTML('beforeend', animateLoading('loader-full'))
        });
    }
    
    function animateLoading(mode='') {
        return `
            <div class="loader w-100 justify-content-center py-3 `+mode+`">
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

    $("#areaFilter, #yearFilter, #monthFilter").change(function(e) {
        var field = [
            area = $("#areaFilter").val(),
            year = $("#yearFilter").val(),
            month = $("#monthFilter").val(),
        ]

        // LOADING
        loadingAllBox();

        lineSoiAvgMonth(field)
        soiAvgPilar(field)
        threatSoi(field)
        lineSoiAvgAreaMonth(field)
        lineSoiAvgAreaPillar(field)
    });

    // SOI AVERAGE MONTH LINE  //
    var lineSoiAvgMonthCtx = document.getElementById("lineSoiAvgMonth").getContext('2d');
    var soiAvgMonthChart = new Chart(lineSoiAvgMonthCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [
                {
                    label: 'PEOPLE',
                    data: [],
                    borderColor: "rgba(0, 176, 80, 1)",
                    backgroundColor: "rgba(0, 176, 80, 1)",
                },
                {
                    label: 'SYSTEM',
                    data: [],
                    borderColor: "rgba(0, 176, 240, 1)",
                    backgroundColor: "rgba(0, 176, 240, 1)",
                },
                {
                    label: 'DEVICE',
                    data: [],
                    borderColor:  "rgba(255, 0, 0, 1)",
                    backgroundColor:  "rgba(255, 0, 0, 1)",
                },
                {
                    label: 'NETWORKING',
                    data: [],
                    borderColor: "rgba(112, 48, 160, 1)",
                    backgroundColor: "rgba(112, 48, 160, 1)",
                },
            ],
        },
        options: {
            scales: {
                y: {
                    min: 0,
                    max: 5,
                    ticks: {
                        precision: 0,
                        callback: (yValue) => {
                            return Number(yValue).toFixed(2); // format to your liking
                        },
                        color: '#FFF',
                    },
                },
                x: {
                    ticks: {
                        color: '#FFF'
                    },
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: "#FFF"
                    },
                },
                filler: {
                    propagate: false
                },
                'samples-filler-analyser': {
                    target: 'chart-analyser'
                }
            },
            interaction: {
              intersect: false,
            },
        },
    });

    lineSoiAvgMonth(field)
    function lineSoiAvgMonth(field) {
        var lineSoiAvgMonthId = document.querySelector('#lineSoiAvgMonth');

        $.ajax({
            url: '{{ url('srs/dashboard_soi/soi_avg_month') }}',
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                area_filter: area,
                year_filter: year,
                month_filter: month,
            },
            cache: false,
            timeout: 10000,
            beforeSend: function() {
            },
            error: function(xhr, textStatus, errorThrown) {
                if (textStatus == 'timeout') {
                    lineSoiAvgMonthId.parentElement.innerHTML = "Error : Timeout for this call!";
                }
            },
            complete: function() {
                lineSoiAvgMonthId.parentElement.querySelector('.loader').remove();
                lineSoiAvgMonthId.style.display = 'block';
            },
            success: function(res) {
                var json = JSON.parse(res)
                
                soiAvgMonthChart.data.datasets = json;
                soiAvgMonthChart.update()
            }
        });
    }
    // SOI AVERAGE MONTH LINE  //

    // SOI AVERAGE PILAR
    soiAvgPilar(field);
    function soiAvgPilar(field) {
        $.ajax({
            url: '{{ url('srs/dashboard_soi/soi_avg_pilar') }}',
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                area_filter: area,
                year_filter: year,
                month_filter: month,
            },
            cache: false,
            beforeSend: function() {
                // $(".lds-ring").show();
                // document.getElementById("loader").style.display = "block";
            },
            complete: function() {
                // document.getElementById("loader").style.display = "none";
            },
            success: function(res) {
                var json = JSON.parse(res)

                $('#avgPeople, #avgSystem, #avgDevice, #avgNetwork').text('')
                $('#avgPeople').text(json[0].avg_people)
                $('#avgSystem').text(json[0].avg_system)
                $('#avgDevice').text(json[0].avg_device)
                $('#avgNetwork').text(json[0].avg_network)
            }
        });
    }
    // SOI AVERAGE PILAR

    // INDEX SOI
    const indexSoiCtx = document.getElementById("indexSoi");
    indexSoiCtx.height = 300;
    const indexSoiChart = new Chart(indexSoiCtx, {
        type: 'bubble',
        data: {
            datasets: [{
                label: 'Index Resiko',
                // data: [{
                //     r: 8,
                //     x: dataX,
                //     y: dataY
                // }],
                borderWidth: 1,
                backgroundColor: 'black',
                borderColor: 'white',
            }]
        },
        options: {
            responsive: true,
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

    threatSoi(field)
    function threatSoi(field) {
        $.ajax({
            url: '{{ url('srs/dashboard_soi/soi_threat_soi') }}',
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                area_filter: area,
                year_filter: year,
                month_filter: month,
            },
            cache: false,
            beforeSend: function() {
                // $(".lds-ring").show();
                // document.getElementById("loader").style.display = "block";
            },
            complete: function() {
                // document.getElementById("loader").style.display = "none";
            },
            success: function(res) {
                var json = JSON.parse(res)

                // INDEX BG SOI //
                const dataX = json[0].avg_soi;
                const dataY = json[0].max_iso;

                if((dataX <= 4 && dataY <= 2) || (dataX >= 4 && dataY >= 2))
                {
                    $('#indexSoiBg').attr('style','background-color: rgb(233 233 9 / 69%)') // yellow
                }
                
                if(dataX >= 4 && dataY <= 2)
                {
                    $('#indexSoiBg').attr('style','background-color: rgb(0 128 9 / 69%)') // green
                }
                
                if(dataX <= 4 && dataY >= 2)
                {
                    $('#indexSoiBg').attr('style','background-color: rgb(255 0 9 / 69%)') // red
                }
                // INDEX BG SOI //

                // indexSoiChart.destroy();
                
                var dataSrs = [{
                    r: 8,
                    x: parseFloat(dataX),
                    y: parseFloat(dataY)
                }];
                indexSoiChart.data.datasets[0].data = dataSrs;
                indexSoiChart.update();
            }
        });
    }
    
    // SOI AVARAGE AREA MONTH
    var lineSoiAvgAreaMonthCtx = document.getElementById("lineSoiAvgAreaMonth").getContext('2d');
    var lineSoiAvgAreaMonthChart = new Chart(lineSoiAvgAreaMonthCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        },
        options: {
            scales: {
                y: {
                    min: 0,
                    max: 5,
                    ticks: {
                        precision: 0,
                        callback: (yValue) => {
                            return Number(yValue).toFixed(2); // format to your liking
                        },
                        color: '#FFF',
                    },
                },
                x: {
                    ticks: {
                        color: '#FFF'
                    },
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: "#FFF"
                    },
                },
                filler: {
                    propagate: false
                },
                'samples-filler-analyser': {
                    target: 'chart-analyser'
                }
            },
            interaction: {
              intersect: false,
            },
        },
    });
    
    lineSoiAvgAreaMonth(field)
    function lineSoiAvgAreaMonth(field) {
        var lineSoiAvgAreaMonthId = document.querySelector('#lineSoiAvgAreaMonth');

        $.ajax({
            url: '{{ url('srs/dashboard_soi/soi_avg_area_month') }}',
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                area_filter: area,
                year_filter: year,
                month_filter: month,
            },
            cache: false,
            timeout: 10000,
            beforeSend: function() {
            },
            error: function(xhr, textStatus, errorThrown) {
                if (textStatus == 'timeout') {
                    lineSoiAvgAreaMonthId.parentElement.innerHTML = "Error : Timeout for this call!";
                }
            },
            complete: function() {
                lineSoiAvgAreaMonthId.parentElement.querySelector('.loader').remove();
                lineSoiAvgAreaMonthId.style.display = 'block';
            },
            success: function(res) {
                var json = JSON.parse(res)

                lineSoiAvgAreaMonthChart.data.datasets = json;
                lineSoiAvgAreaMonthChart.update()
            }
        });
    }
    // SOI AVARAGE AREA MONTH //

    // SOI AVARAGE AREA PILLAR
    var lineSoiAvgAreaPillarCtx = document.getElementById("lineSoiAvgAreaPillar").getContext('2d');
    var lineSoiAvgAreaPillarChart = new Chart(lineSoiAvgAreaPillarCtx, {
        type: 'line',
        options: {
            scales: {
                y: {
                    min: 0,
                    max: 5,
                    ticks: {
                        precision: 0,
                        callback: (yValue) => {
                            return Number(yValue).toFixed(2); // format to your liking
                        },
                        color: '#FFF',
                    },
                },
                x: {
                    ticks: {
                        color: '#FFF'
                    },
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: "#FFF"
                    },
                },
                filler: {
                    propagate: false
                },
                'samples-filler-analyser': {
                    target: 'chart-analyser'
                }
            },
            interaction: {
              intersect: false,
            },
        },
    });

    lineSoiAvgAreaPillar(field)
    function lineSoiAvgAreaPillar(field) {
        var lineSoiAvgAreaPillarId = document.querySelector('#lineSoiAvgAreaPillar');

        $.ajax({
            url: '{{ url('srs/dashboard_soi/soi_avg_area_pillar') }}',
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                area_filter: area,
                year_filter: year,
                month_filter: month,
            },
            cache: false,
            timeout: 10000,
            beforeSend: function() {
            },
            error: function(xhr, textStatus, errorThrown) {
                if (textStatus == 'timeout') {
                    lineSoiAvgAreaPillarId.parentElement.innerHTML = "Error : Timeout for this call!";
                }
            },
            complete: function() {
                console.log(lineSoiAvgAreaPillarId.parentElement)
                lineSoiAvgAreaPillarId.parentElement.querySelector('.loader').remove();
                lineSoiAvgAreaPillarId.style.display = 'block';
            },
            success: function(res) {
                var json = JSON.parse(res)
                
                lineSoiAvgAreaPillarChart.data.labels = json.area;
                lineSoiAvgAreaPillarChart.data.datasets = json.data;
                lineSoiAvgAreaPillarChart.update()
            }
        });
    }
    // SOI AVARAGE AREA PILLAR //
</script>
@endsection