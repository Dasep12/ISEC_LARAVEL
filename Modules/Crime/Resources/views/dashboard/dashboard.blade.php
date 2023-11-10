@extends('crime::layouts.master')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>


<style>
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

<script src="https://code.highcharts.com/highcharts.js"></script>
<!-- <script src="https://code.highcharts.com/stock/highstock.js"></script> -->
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
<script src="https://code.highcharts.com/stock/modules/accessibility.js"></script>
<section class="content-header">
    <div class="container-fluid">

    </div>
</section>
<section class="content" style="">
    <div class="container-fluid ">
        <div class="row">
            <div class="col-lg-3">
                <select name="tahun" id="tahun" class="form-control">
                    <option value="">Pilih Tahun</option>
                    <?php for ($i = 2022; $i <= 2025; $i++) : ?>
                        <option <?= $i == date('Y') ? 'selected' : '' ?>><?= $i ?></option>
                    <?php endfor ?>
                </select>
            </div>
            <div class="col-lg-3 ml-2">
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

        <div class="row">
            <div class="col-lg-6">
                <div class="card cardIn">
                    <div class="card-body">
                        <div id="jakartaUtaraSetahun"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card cardIn2">
                    <div class="card-body">
                        <div id="KategoriJakutSetahun"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top:-20px!important">
            <div class="col-lg-8">
                <div class="card" id="mapJakut" style="height:420px">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card" style="height:420px">
                    <div id="kategoriJakut"></div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top:-20px!important">
            <div class="col-lg-8">
                <div class="card" id="mapKarawang" style="height:420px">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card" style="height:420px">
                    <div id="kategoriKarawang"></div>
                </div>
            </div>
        </div>
    </div>
</section>


<script src="{{ asset('assets/dist/js/jquery.dataTables.min.js') }} "></script>
<script src="{{ asset('geojson/jakarta-utara-geojson.js') }}"></script>
<script src="{{ asset('geojson/karawang_geo.js') }}"></script>
<script>
    var jakSetahun = Highcharts.chart({
        chart: {
            renderTo: 'jakartaUtaraSetahun',
            type: 'column',
            options3d: {
                // enabled: true,
                // alpha: 10,
                // beta: 25,
                // depth: 70
            }
        },

        title: {
            text: 'Trend Jakarta Utara',
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
        credits: {
            enabled: false
        },
        series: [{
            name: 'Penjaringan',
            data: [12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12]
        }, {
            name: 'Pademangan',
            data: [12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12]
        }, {
            name: 'Tanjung Priok',
            data: [12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12]
        }, {
            name: 'Cililincing',
            data: [12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12]
        }, {
            name: 'Koja',
            data: [12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12]
        }, {
            name: 'Kelapa Gading',
            data: [12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12]
        }]
    });
    var jakKategori = Highcharts.chart({
        chart: {
            renderTo: 'KategoriJakutSetahun',
            type: 'column',
            options3d: {
                enabled: true,
                alpha: 10,
                beta: 25,
                depth: 70
            }
        },

        title: {
            text: 'Trend Kategori Jakarta Utara',
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
        credits: {
            enabled: false
        },
        series: [{
            name: 'Kekerasan',
            data: [12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12]
        }, {
            name: 'Narkoba',
            data: [12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12]
        }, {
            name: 'Perjudian',
            data: [12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12]
        }, {
            name: 'Pencurian',
            data: [12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12]
        }, {
            name: 'Penggelapan',
            data: [12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12]
        }]
    });

    document.getElementById("mapJakut").innerHTML = "<div id='map'></div>";
    document.getElementById("mapKarawang").innerHTML = "<div id='map2'></div>";

    const map = L.map('mapJakut').setView([-6.125976186640234, 106.84136805372526], 12);

    const tiles = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '',
        background: 'red'
    }).addTo(map);

    // 
    // create a map in the "map" div, set the view to a given place and zoom
    var map2 = L.map('map2').setView([-6.271198565623721, 107.2924866375833], 9.85);

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

    // Karawang
    info2.update = function(props) {
        const contents = props ? `<b>${props.name}</b><br />${props.density} Case` : '';
        this._div.innerHTML = `<h4 class="tes">Karawang</h4>${contents}`;
    };

    // Jakut
    info.addTo(map);

    // Karawang
    info2.addTo(map2);


    // get color depending on population density value
    function getColor(d) {
        return d > 1000 ? '#800026' :
            d > 500 ? '#BD0026' :
            d > 200 ? '#E31A1C' :
            d > 100 ? '#FC4E2A' :
            d > 50 ? '#FD8D3C' :
            d > 20 ? '#FEB24C' :
            d > 10 ? '#FED976' : '#FFEDA0';
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
                    html: '<b  >' + feature.properties.name + '</b>',
                    iconSize: marker
                })
            }).addTo(map);
        }
    });
    // 

    // Karawang state kecamatan
    const geojson2 = L.geoJson(statesKarawang, {
        style,
        onEachFeature
    }).addTo(map2);

    L.geoJson(statesKarawang, {
        onEachFeature: function(feature, layer) {
            let marker = [90, 40];
            var label = L.marker(layer.getBounds().getCenter(), {
                icon: L.divIcon({
                    className: 'labels',
                    html: '<b >' + feature.properties.name + '</b>',
                    iconSize: marker
                })
            }).addTo(map2);
        }
    });


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
        const grades = [0, 10, 20, 30, 100, 200, 500, 1000];
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
        const grades = [0, 10, 20, 30, 100, 200, 500, 1000];
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


    var kategoriJakut = Highcharts.chart('kategoriJakut', {
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
            text: '',
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
                name: 'Perjudian',
                y: 76
            }, {
                name: 'Pencurian',
                y: 13
            }, {
                name: 'Penggelapan',
                y: 45
            }, {
                name: 'Narkoba',
                y: 45
            }, {
                name: 'Kekerasan',
                y: 45
            }]
        }]
    });
</script>
@endsection