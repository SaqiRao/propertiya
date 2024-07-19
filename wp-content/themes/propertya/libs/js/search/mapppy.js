function sb_classified_map_search(features_data) {
    var api_key = sb_map_global.mapbox_access_token;
    var latitude = sb_map_global.latitude;
    var longitude = sb_map_global.longitude;
    var map_style = 'mapbox://styles/mapbox/' + sb_map_global.map_style + '?optimize=true';
    var map_marker = sb_map_global.map_marker;
    var map_zoom = sb_map_global.map_zoom;
    if (typeof features_data !== 'object') {
        features_data = JSON.parse(features_data);
    }
    var map_bounds_data = [];
    for (var i = 0; i < features_data.length; i++) {
        map_bounds_data.push(features_data[i].geometry.coordinates);
    }
    var center_data = typeof features_data[0] !== 'undefined' && features_data[0] != '' ? features_data[0].geometry.coordinates : [latitude, longitude];
    mapboxgl.accessToken = api_key;
    var map = new mapboxgl.Map({
        container: 'buyent-map-search',
        style: map_style,
        center: center_data,
        minzoom: 3,
        maxzoom: 9,
        "transition": {
            "duration": 300,
            "delay": 0
        }
    });
    function rotateCamera(timestamp) {
        map.rotateTo((timestamp / 100) % 360, {duration: 0});
        requestAnimationFrame(rotateCamera);
    }
    map.on('load', function () {
        map.loadImage(map_marker,
                function (error, image) {
                    if (error)
                        throw error;
                    map.addImage('buyent-map-marker', image);
                });
        map.addSource('buyent-classified-search', {
            type: 'geojson',
            cluster: true,
            clusterMaxZoom: 14,
            clusterRadius: 50,
            data: {
                "type": "FeatureCollection",
                "crs": { "type": "name", "properties": { "name": "urn:ogc:def:crs:OGC:1.3:CRS84" }
                },
                "features": features_data,
            },
        });
        map.fitBounds(map.getBounds());
        map.addLayer({
            id: 'clusters',
            type: 'circle',
            source: 'buyent-classified-search',
            filter: ['has', 'point_count'],
            paint: {
                'circle-color': [ 'step', ['get', 'point_count'], '#51bbd6', 100, '#f1f075', 750, '#f28cb1' ],
                'circle-radius': [ 'step', ['get', 'point_count'], 20, 100, 30, 750, 40 ]
            }
        });
        map.addLayer({
            id: 'cluster-count',
            type: 'symbol',
            source: 'buyent-classified-search',
            filter: ['has', 'point_count'],
            layout: {
                'text-field': '{point_count_abbreviated}',
                'text-font': ['DIN Offc Pro Medium', 'Arial Unicode MS Bold'],
                'text-size': 12
            }
        });
        /*var myLayer = mapboxgl.mapbox.featureLayer().addTo(map);*/
        map.on('click', 'unclustered-point', function (e) {
            map.flyTo({ center: e.features[0].geometry.coordinates });
        });
        map.addLayer({
            "id": "unclustered-point",
            "source": "buyent-classified-search",
            filter: ['!', ['has', 'point_count']],
            "type": "symbol",
            "layout": { "icon-image": "buyent-map-marker" }
        });
        map.on('click', 'clusters', function (e) {
            var features = map.queryRenderedFeatures(e.point, { layers: ['clusters'] });
            var clusterId = features[0].properties.cluster_id;
            map.getSource('buyent-classified-search').getClusterExpansionZoom(
                    clusterId,
                    function (err, zoom) {
                        if (err)
                            return;
                        map.easeTo({ center: features[0].geometry.coordinates, zoom: zoom });
                    }
            );
        });
        /*When a click event occurs on a feature in the unclustered-point layer, open a popup at the location of the feature, with description HTML from its properties.*/
        map.on('click', 'unclustered-point', function (e) {
            var coordinates = e.features[0].geometry.coordinates.slice();
            var popup_html  = e.features[0].properties.html;
            while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
            }
            new mapboxgl.Popup({className: 'buyent-search-popup'}).setLngLat(coordinates).setHTML(popup_html).addTo(map);
        });
        map.on('mouseenter', 'clusters', function () { map.getCanvas().style.cursor = 'pointer'; });
        map.on('mouseleave', 'clusters', function () { map.getCanvas().style.cursor = ''; });
        /*map.resize();*/
    });

 
}