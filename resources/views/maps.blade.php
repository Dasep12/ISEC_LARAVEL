<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>

<body>
    <div class="card" id="mapJakut" style="height:600px">
    </div>
</body>
<script src="{{ asset('geojson/jabar.js') }}"></script>
<script>
    document.getElementById("mapJakut").innerHTML = "<div id='map'></div>";

    const map = L.map('mapJakut').setView([-6.609641013768763, 107.66407825334718], 9.4);
    const tiles = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '',
        background: 'red'
    }).addTo(map);
    const info = L.control();
    // Jakut
    info.onAdd = function(map) {
        this._div = L.DomUtil.create('div', 'info');
        this.update();
        return this._div;
    };

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

    function resetHighlight(e) {
        geojson.resetStyle(e.target);
        info.update();
    }

    function zoomToFeature(e) {
        map.fitBounds(e.target.getBounds());
    }

    function onEachFeature(feature, layer) {
        layer.on({
            mouseover: highlightFeature,
            mouseout: resetHighlight,
            click: zoomToFeature
        });
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

    const geojson = L.geoJson(jabar, {
        style,
        onEachFeature
    }).addTo(map);

    L.geoJson(jabar, {
        onEachFeature: function(feature, layer) {
            let marker = [90, 40];
            if (feature.properties.KABKOT == 'KARAWANG') {
                marker = [20, 10]
            } else if (feature.properties.KABKOT == 'BEKASI') {
                marker = [10, 10]
            } else if (feature.properties.kota == 'Jakarta Utara') {
                marker = [35, 20]
            }

            let area = "";
            if (feature.properties.KABKOT == 'KARAWANG') {
                area = feature.properties.KABKOT
            } else if (feature.properties.KABKOT == 'PURWAKARTA') {
                area = feature.properties.KABKOT
            } else if (feature.properties.KABKOT == 'BEKASI') {
                area = feature.properties.KABKOT
            }

            if (feature.properties.kota == 'Jakarta Utara') {
                area = feature.properties.kota
            }
            var label = L.marker(layer.getBounds().getCenter(), {
                icon: L.divIcon({
                    className: 'labels',
                    html: '<b  >' + area + '</b>',
                    iconSize: marker
                })
            }).addTo(map);
        }
    });
</script>

</html>