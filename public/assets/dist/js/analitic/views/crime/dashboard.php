<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
                <!-- <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Mst_Event') ?>">Master</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Mst_Event') ?>">Event</a></li>
                    <li class="breadcrumb-item"><a href="">Edit Event</a></li>
                </ol> -->
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row md-2">
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

        <div class="row">
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




        <div class="row">
            <div class="col-lg-12">
                <div class="card cardIn2 ">
                    <div class="card-body">
                        <div id="trendCrime"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="<?= base_url('assets/dist/js') ?>/highcharts.js"></script>
<script src="<?= base_url('assets/dist/js') ?>/modules/exporting.js"></script>
<script src="<?= base_url('assets/dist/js') ?>/modules/export-data.js"></script>
<script src="<?= base_url('assets/dist/js') ?>/modules/accessibility.js"></script>
<script src="<?= base_url('assets/dist/js') ?>/highcharts-3d.js"></script>
<script src="<?= base_url('assets/dist/js') ?>/modules/variable-pie.js"></script>
<script src="<?= base_url('assets/dist/js') ?>/modules/drilldown.js"></script>

<script src="https://unpkg.com/leaflet@1.9.0/dist/leaflet.js" integrity="sha256-oH+m3EWgtpoAmoBO/v+u8H/AdwB/54Gc/SgqjUKbb4Y=" crossorigin=""></script>




<script>
    Highcharts.chart('karawangSetahun', {
        chart: {
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
            text: 'Jumlah Kasus Periode 2022'
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            gridLineColor: '#ffffff'
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
            },
            // gridLineColor: '#ffffff'
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
        series: [{
            name: 'KEKERASAN',
            data: [2, 3, 4, 5, 6, 3, 7, 7, 9, 7, 11, 14]
        }, {
            name: 'NARKOBA',
            data: [2, 3, 4, 5, 6, 3, 7, 7, 9, 7, 11, 14]
        }, {
            name: 'PERJUDIAN',
            data: [2, 3, 4, 5, 6, 3, 7, 7, 9, 7, 11, 14]
        }, {
            name: 'PENCURIAN',
            data: [2, 3, 4, 5, 6, 3, 7, 7, 9, 7, 11, 14]
        }, {
            name: 'PENGGELAPAN',
            data: [2, 3, 4, 5, 6, 3, 7, 7, 9, 7, 11, 14]
        }, {
            type: 'spline',
            // options3d: {
            //     enabled: true,
            //     alpha: 0,
            //     beta: 0,
            //     depth: 0
            // },
            name: 'Total',
            data: [10, 15, 20, 25, 30, 15, 35, 35, 45, 35, 55, 70],
            center: [1, 1],
            // size: 200,
            showInLegend: false,
            dataLabels: {
                enabled: false
            },
            marker: {
                lineWidth: 2,
                lineColor: Highcharts.getOptions().colors[3],
                fillColor: 'white'
            }
        }]
    });

    Highcharts.chart('jakartaUtaraSetahun', {
        chart: {
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
            text: 'Jumlah Kasus Periode 2022'
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            gridLineColor: '#ffffff'
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
            },
            // gridLineColor: '#ffffff'
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
        series: [{
            name: 'KEKERASAN',
            data: [2, 3, 4, 5, 6, 3, 7, 7, 9, 7, 11, 14]
        }, {
            name: 'NARKOBA',
            data: [2, 3, 4, 5, 6, 3, 7, 7, 9, 7, 11, 14]
        }, {
            name: 'PERJUDIAN',
            data: [2, 3, 4, 5, 6, 3, 7, 7, 9, 7, 11, 14]
        }, {
            name: 'PENCURIAN',
            data: [2, 3, 4, 5, 6, 3, 7, 7, 9, 7, 11, 14]
        }, {
            name: 'PENGGELAPAN',
            data: [2, 3, 4, 5, 6, 3, 7, 7, 9, 7, 11, 14]
        }, {
            type: 'spline',
            // options3d: {
            //     enabled: true,
            //     alpha: 0,
            //     beta: 0,
            //     depth: 0
            // },
            name: 'Total',
            data: [10, 15, 20, 25, 30, 15, 35, 35, 45, 35, 55, 70],
            center: [1, 1],
            // size: 200,
            showInLegend: false,
            dataLabels: {
                enabled: false
            },
            marker: {
                lineWidth: 2,
                lineColor: Highcharts.getOptions().colors[3],
                fillColor: 'white'
            }
        }]
    });



    Highcharts.chart('CrimeperAreaJakut', {
        title: {
            text: 'Index Crime Per Area Jakarta Utara',
            align: 'center'
        },
        subtitle: {
            text: 'Periode 2022'
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
        },
        yAxis: {
            max: 150,
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
            },
        },
        series: [{
            type: 'column',
            name: 'PENJARINGAN',
            data: [2, 3, 4, 5, 6, 3, 7, 7, 9, 7, 11, 14]
        }, {
            type: 'column',
            name: 'CILINCING',
            data: [2, 3, 4, 5, 6, 3, 7, 7, 9, 7, 11, 14]
        }, {
            type: 'column',
            name: 'KOJA',
            data: [2, 3, 4, 5, 6, 3, 7, 7, 9, 7, 11, 14]
        }, {
            type: 'column',
            name: 'PADEMANGAN',
            data: [2, 3, 4, 5, 6, 3, 7, 7, 9, 7, 11, 14]
        }, {
            type: 'column',
            name: 'TANJUNG PRIOK',
            data: [2, 3, 4, 5, 6, 3, 7, 7, 9, 7, 11, 14]
        }, {
            type: 'column',
            name: 'KELAPA GADING',
            data: [2, 3, 4, 5, 6, 3, 7, 7, 9, 7, 11, 14]
        }, {
            type: 'spline',
            name: 'TOTAL',
            data: [2, 3, 4, 5, 6, 3, 7, 7, 9, 7, 11, 14],
            marker: {
                lineWidth: 2,
                lineColor: Highcharts.getOptions().colors[3],
                fillColor: 'white'
            }
        }]
    });

    Highcharts.chart('CrimeperAreaKarawang', {
        title: {
            text: 'Index Crime Per Area Karawang',
            align: 'center'
        },
        subtitle: {
            text: 'Periode 2022'
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
        },
        yAxis: {
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
        series: [{
            type: 'column',
            options3d: {
                enabled: true,
                alpha: 10,
                beta: 25,
                depth: 70
            },
            name: 'TELUK JAMBE BARAT',
            data: [2, 3, 4, 5, 6, 3, 7, 7, 9, 7, 11, 14]
        }, {
            type: 'column',
            options3d: {
                enabled: true,
                alpha: 10,
                beta: 25,
                depth: 70
            },
            name: 'TELUK JAMBE TIMUR',
            data: [2, 3, 4, 5, 6, 3, 7, 7, 9, 7, 11, 14]
        }, {
            type: 'column',
            options3d: {
                enabled: true,
                alpha: 10,
                beta: 25,
                depth: 70
            },
            name: 'KLARI',
            data: [2, 3, 4, 5, 6, 3, 7, 7, 9, 7, 11, 14],
            type: 'column',

            name: 'CIAMPEL',
            data: [2, 3, 4, 5, 6, 3, 7, 7, 9, 7, 11, 14]
        }, {
            type: 'column',
            name: 'MAJALAYA',
            data: [2, 3, 4, 5, 6, 3, 7, 7, 9, 7, 11, 14]
        }, {
            type: 'column',
            name: 'KARAWANG TIMUR',
            data: [2, 3, 4, 5, 6, 3, 7, 7, 9, 7, 11, 14]
        }, {
            type: 'column',
            name: 'KARAWANG BARAT',
            data: [2, 3, 4, 5, 6, 3, 7, 7, 9, 7, 11, 14]
        }, {
            type: 'spline',
            name: 'TOTAL',
            data: [2, 3, 4, 5, 6, 3, 7, 7, 9, 7, 11, 14],
            marker: {
                lineWidth: 2,
                lineColor: Highcharts.getOptions().colors[3],
                fillColor: 'white'
            }
        }]
    });



    Highcharts.chart('trendCrime', {

        chart: {
            type: 'column'
        },

        title: {
            text: 'Trend Index Crime Selama 3 Bulan'
        },

        subtitle: {
            text: 'Periode 2022'
        },

        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical'
        },

        xAxis: {
            categories: ['Januari', 'Februari', 'Februari'],
            labels: {
                x: -10
            }
        },

        yAxis: {
            allowDecimals: false,
            title: {
                text: 'Total'
            }
        },

        series: [{
            name: 'Pencurian',
            data: [38, 51, 34]
        }, {
            name: 'Perjudian',
            data: [31, 26, 27]
        }, {
            name: 'Narkoba',
            data: [38, 42, 41]
        }],

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        align: 'center',
                        verticalAlign: 'bottom',
                        layout: 'horizontal'
                    },
                    yAxis: {
                        labels: {
                            align: 'left',
                            x: 0,
                            y: -5
                        },
                        title: {
                            text: null
                        }
                    },
                    subtitle: {
                        text: null
                    },
                    credits: {
                        enabled: false
                    }
                }
            }]
        }
    });
</script>