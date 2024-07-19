(function($) {

$(document).ready(function(){	


var chk_container =  document.getElementById('property_map');
		if (typeof(chk_container) !== 'undefined' && chk_container !== null )
		{
			
			 var map_lat =  34.77;
			 var map_long = -74.00;
			 var listing_latt = parseFloat($('#property_latt').val());
        	 var listing_long = parseFloat($('#property_long').val());
			 if(listing_latt && listing_long)
			 {
				 map_lat = listing_latt;
				 map_long = listing_long;
			 }
					if(get_map_string.map_type == 'open_street')
					{
						var mymap = L.map(chk_container).setView([map_lat,map_long], 13);
						L.tileLayer('//{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
						maxZoom: 18,
					}).addTo(mymap);
					var custom_icon = L.icon({
						iconUrl: get_map_string.p_path+'libs/images/map-marker.png',
						iconSize: [50, 50],
        			});
					var markerz = L.marker([map_lat,map_long],{draggable: true,icon: custom_icon}).addTo(mymap);
					var searchControl 	=	new L.Control.Search({
						url: '//nominatim.openstreetmap.org/search?format=json&q={s}',
						jsonpParam: 'json_callback',
						propertyName: 'display_name',
						propertyLoc: ['lat','lon'],
						marker: markerz,
						autoCollapse: false,
						autoType: true,
						minLength: 2,
						initial: false,
						collapsed: false
					});
					searchControl.on('search:locationfound', function(obj) {
						console.log(obj.latlng);
						var lt	=	obj.latlng + '';
						var res = lt.split( "LatLng(" );
						res = res[1].split( ")" );
						res = res[0].split( "," );
						document.getElementById('property_latt').value = res[0];
						document.getElementById('property_long').value = res[1];
					});
					mymap.addControl( searchControl );
					markerz.on('dragend', function (e) {
					  document.getElementById('property_latt').value = markerz.getLatLng().lat;
					  document.getElementById('property_long').value = markerz.getLatLng().lng;
					});
				}
					if(get_map_string.map_type == 'google_map' && get_map_string.gapp_keyz !='')
					{
						google.maps.event.addDomListener(window, 'load', places_google_map(map_lat,map_long));
						//return false;
					}
					if(get_map_string.map_type == 'mapbox')
					{
						if (typeof(get_map_string.acc_keyz) !== 'undefined' && get_map_string.acc_keyz !== '')
						{
							places_mapbox_map(map_lat,map_long);
						}
					}
		}
		
		function places_google_map(map_lat,map_long)
		{
			if(map_lat !=="" && map_long !=="")
			{
				var map_center_positionr = new google.maps.LatLng(map_lat,map_long);
				var mapOptions = {
					zoom: 13,
					center: map_center_positionr,
					disableDefaultUI: false
				};
				var map = new google.maps.Map(chk_container, mapOptions);
				var get_markers = new google.maps.Marker({
					position: map_center_positionr,
					map: map,
					icon: get_map_string.p_path+'libs/images/map-marker.png',
					labelAnchor: new google.maps.Point(1, 1),
					draggable: true,
					animation: google.maps.Animation.DROP,
				});
				var  geocoder = new google.maps.Geocoder();
				google.maps.event.addListener(get_markers, "dragend", function (event) {
				geocoder.geocode({latLng: get_markers.getPosition()}, function(responses) {
					//console.log(google.maps.GeocoderStatus);
					 if (responses && responses.length > 0) {
						$('#property_address').val(responses[0].formatted_address);
						$('#property_latt').val( get_markers.getPosition().lat() );
						$('#property_long').val( get_markers.getPosition().lng() );
						return false;
					}	 
				 });
				});
				var places_input =  document.getElementById('property_address');
				var autocomplete = new google.maps.places.Autocomplete(places_input);
				autocomplete.bindTo('bounds', map);
				google.maps.event.addListener(autocomplete, 'place_changed', function() {
					var fetch_places = autocomplete.getPlace();
					//console.log(fetch_places);
					if (!fetch_places.geometry) {
						return;
					}
					if (fetch_places.geometry.viewport) {
						map.fitBounds(fetch_places.geometry.viewport);
					} else {
						map.setCenter(fetch_places.geometry.location);
						map.setZoom(13);
					}
					get_markers.setPosition(fetch_places.geometry.location);
					get_markers.setVisible(true);
					$('#property_latt').val( get_markers.getPosition().lat() );
					$('#property_long').val( get_markers.getPosition().lng() );
				});
			}
		}
			
	
		function places_mapbox_map(map_lat,map_long)
		{
			if(map_lat !=="" && map_long !=="")
			{
					mapboxgl.accessToken = get_map_string.acc_keyz;	
							var mapz = new mapboxgl.Map({
								container: chk_container,
								style: 'mapbox://styles/mapbox/streets-v11',
								center: [map_long, map_lat],
								zoom: 13
							});
							var mapbox_marker = new mapboxgl.Marker({draggable: true, color: 'orange'}).setLngLat([map_long, map_lat]).addTo(mapz);
							function onDragEnd() {
								var lngLat = mapbox_marker.getLngLat();
								document.getElementById('property_latt').value = lngLat.lat;
								document.getElementById('property_long').value = lngLat.lng;
							}
							mapbox_marker.on('dragend', onDragEnd);
							var geocoder = new MapboxGeocoder({
									accessToken: mapboxgl.accessToken,
									zoom: 13,
									marker: {
										color: 'orange',
										draggable: true
									},
									mapboxgl: mapboxgl
						  });
							mapz.addControl(geocoder);
								  mapz.on('load', function() {
								  geocoder.on('result', function(e) {
									  geocoder.mapMarker.on('dragend', function(e)
									  {
									  	 //console.log(e.target.getLngLat());
										 document.getElementById('property_latt').value = e.target.getLngLat().lat;
										 document.getElementById('property_long').value = e.target.getLngLat().lng;
								  	  });
									// console.log(e.result); 
								  document.getElementById('property_address').value = e.result.place_name;
								  document.getElementById('property_latt').value = e.result.center[1];
								  document.getElementById('property_long').value = e.result.center[0];
								  mapbox_marker.remove();
							  });
							});
			}
		}	

	});

	})(jQuery);	