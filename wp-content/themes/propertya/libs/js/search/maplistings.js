
(function($) {

  "use strict";	

	if(typeof(get_strings) !== 'undefined' && get_strings !== null)

	{	

	

	

if ($('.my_range_slider').length > 0)

{

	$('.my_range_slider').nstSlider({

			"disable":true,

		  "left_grip_selector": ".leftGrip",

		  "value_changed_callback": function (cause, leftValue) {

			$(this).parent().find('.leftLabel').text(leftValue);

			$('input[name="distance"]').val(leftValue);

		  }

	});

	$('.nstSlider').nstSlider('disable');

}



$("#find_btn").on('click', function () {	

	$('.sonu-button').buttonLoader('start');

	$(".sonu-button").attr("disabled", true);

	if ("geolocation" in navigator){ 

		navigator.geolocation.getCurrentPosition(show_location, show_error, {enableHighAccuracy: true}); 

		

	}else{

		notify('info', get_strings.whoops, get_strings.geolocation);

	}

});	
var map_lat =  get_strings.map_latt;

		 var map_long = get_strings.map_long;
		
function show_location(position)

{

	    $('input[name="latt"]').val(position.coords.latitude);

		$('input[name="long"]').val(position.coords.longitude);

		$('.distance-slider').slideDown('slow');

        $('.sonu-button').buttonLoader('stop');

		$('.nstSlider').nstSlider('enable');

		$(".sonu-button").attr("disabled", false);

}	

//Error Callback

function show_error(error){

   switch(error.code) {

        case error.PERMISSION_DENIED:

			notify('info', get_strings.whoops, get_strings.p_denied);

            break;

        case error.POSITION_UNAVAILABLE:

			notify('info', get_strings.whoops, get_strings.p_unava);

            break;

        case error.TIMEOUT:

			notify('info', get_strings.whoops, get_strings.req_timeout);

            break;

        case error.UNKNOWN_ERROR:

			notify('info', get_strings.whoops, get_strings.unknow_error);

            break;

    }

	$('.sonu-button').buttonLoader('stop');

	$(".sonu-button").attr("disabled", false);

}



	

		 var chk_singlemapcontainer =  document.getElementById('mapid');

		 var map_lat =  get_strings.map_latt;

		 var map_long = get_strings.map_long;

		if (typeof(chk_singlemapcontainer) !== 'undefined' && chk_singlemapcontainer !== null && get_strings.is_map_enabled == 1)

		{

		
			if(get_strings.map_type == 'open_street')

			{
				listings_on_map(map_lat,map_long);
			}

			if(get_strings.map_type == 'mapbox')

			{

				listings_on_map_box(map_lat,map_long);

			}

	     }

		 

	

	/*Form search fields*/

	$('button[name=properties_search]').on('click', function () {

		$(".grid").height('auto');

        $('.fb-like-animation').show();

        $(".grid").html('');

		$("#listing_ajax_pagination").html('');

		var sort_by = $("#sort-by").val();

        $.post(get_strings.ajax_url, {action: 'prop_listing_search', collect_data: $("form#mylistings_search").serialize(),sort_by: sort_by}).done(function (response)

        {

           $('.fb-like-animation').hide();

           if (true === response.success) 

		   {

			   $('.fb-like-animation').hide();

			   $(".grid").html(response.data.listings);

			   $(".my-filer-tags").html(response.data.fliters);

			   $("#listing_ajax_pagination").html(response.data.pagination);

			   $('html, body').animate({

				 scrollTop: $(".my-loading-bar").offset().top

			   }, 200);

			   $('[data-toggle="tooltip"]').tooltip();

			   initialiceMasonry();

			   listings_map_regenrate(response.data.map_listings);

		   }

		   else

		   {

			   $(".my-filer-tags").html(response.data.fliters);

			   $(".grid").html(response.data.no_result);

			  listings_map_regenrate(response.data.map_listings);

		   }

        });

    });

	

		 

	

	$(document.body).on('click', '.get_title', function () {	

		$(".grid").height('auto');

        $('.fb-like-animation').show();

        $(".grid").html('');

		$("#listing_ajax_pagination").html('');

		var sort_by = $("#sort-by").val();

        $.post(get_strings.ajax_url, {action: 'prop_listing_search', collect_data: $("form#mylistings_search").serialize(),sort_by: sort_by}).done(function (response)

        {

           $('.fb-like-animation').hide();

           if (true === response.success) 

		   {

			   $('.fb-like-animation').hide();

			   $(".grid").html(response.data.listings);

			   $(".my-filer-tags").html(response.data.fliters);

			   $("#listing_ajax_pagination").html(response.data.pagination);

			   $('html, body').animate({

				 scrollTop: $(".page-template").offset().top

			   }, 200);

			   $('[data-toggle="tooltip"]').tooltip();

			   initialiceMasonry();

			   if(get_strings.map_type == 'open_street')

			   {
				   listings_map_regenrate(response.data.map_listings);
			   }
   
			   if(get_strings.map_type == 'mapbox')
   
			   {
				
				var img= response.data.imgg;
				var layer= response.data.layer;
				var zoom = response.data.zoom;
				 listings_mapbox_regenrate(response.data.mapbox_data,img,layer,zoom);
   
			   }
			   

		   }

		   else

		   {

			   $('.fb-like-animation').hide();

			   $(".my-filer-tags").html(response.data.fliters);

			   $(".grid").html(response.data.no_result);

			  listings_map_regenrate(response.data.map_listings);

		   }

        });

	}); 

	

	/*Sort by*/

	$(document.body).on('change', '#sort-by,#offer_type,#custom_locations,#property_type,#label_type,#currency_type', function () {

	    var sort_by = $("#sort-by").val();

		$(".grid").height('auto');

        $('.fb-like-animation').show();

        $(".grid").html('');

		$("#listing_ajax_pagination").html('');

		$('html, body').animate({

		 scrollTop: $(".my-loading-bar").offset().top

		}, 200);

        $.post(get_strings.ajax_url, {action: 'prop_listing_search', collect_data: $("form#mylistings_search").serialize(), sort_by: sort_by}).done(function (response)

        {

           $('.fb-like-animation').hide();

           if (true === response.success) 

		   {

			   $('.fb-like-animation').hide();

			   $(".grid").html(response.data.listings);

			   $(".my-filer-tags").html(response.data.fliters);

			   $("#listing_ajax_pagination").html(response.data.pagination);

			   $('[data-toggle="tooltip"]').tooltip();

			   initialiceMasonry();

			 
			   if(get_strings.map_type == 'open_street')

			   {
				   listings_map_regenrate(response.data.map_listings);
			   }
   
			   if(get_strings.map_type == 'mapbox')
   
			   {
				
				var img= response.data.imgg;
				var layer= response.data.layer;
				var zoom = response.data.zoom;
				 listings_mapbox_regenrate(response.data.mapbox_data,img,layer,zoom);
   
			   }
			   

		   }

		   else

		   {

			   $(".my-filer-tags").html(response.data.fliters);

			   $(".grid").html(response.data.no_result);

			   if(get_strings.map_type == 'open_street')

			   {
				   listings_map_regenrate(response.data.map_listings);
			   }
   
			   if(get_strings.map_type == 'mapbox')
   
			   {
				
				var img= response.data.imgg;
				var layer= response.data.layer;
				var zoom = response.data.zoom;
				 listings_mapbox_regenrate(response.data.mapbox_data,img,layer,zoom);
   
			   }

		   }

        });

	});

		 

/*Pagination*/

	$(document.body).on('click', '.fetch_result', function () {

        var page_no = $(this).attr("data-page-no");

        $(this).addClass("active");

        $(".fetch_result").not(this).removeClass("active");

		$(".grid").height('auto');

        $('.fb-like-animation').show();

        $(".grid").html('');

		$("#listing_ajax_pagination").html('');

		var sort_by = $("#sort-by").val();

		$('html, body').animate({

		 scrollTop: $(".page-template").offset().top

		}, 200);

		$.post(get_strings.ajax_url, {action: 'prop_listing_search', collect_data: $("form#mylistings_search").serialize(), page_no: page_no,sort_by: sort_by}).done(function (response)

        {

			if (true === response.success) 

			{

				$('.fb-like-animation').hide();

				$(".grid").html(response.data.listings);

				$(".my-filer-tags").html(response.data.fliters);

				$("#listing_ajax_pagination").html(response.data.pagination);

				$('[data-toggle="tooltip"]').tooltip();
				if(get_strings.map_type == 'open_street')

				{
					
					listings_map_regenrate(response.data.map_listings);
				}
	
				if(get_strings.map_type == 'mapbox')
	
				{
					
	             var img= response.data.imgg;
				 var layer= response.data.layer;
				 var zoom = response.data.zoom;
				  listings_mapbox_regenrate(response.data.mapbox_data,img,layer,zoom);
	
				}
				

			}

			else

		    {

			   $('.fb-like-animation').hide();

			   $(".my-filer-tags").html(response.data.fliters);

			   $(".grid").html(response.data.no_result);

			   listings_map_regenrate(response.data.map_listings);

		    }

		});

});



/*Reset All Filters*/

		$(document.body).on('click', '#reset_ajax_result', function () {

		$('.distance-slider').hide();

		$('input[type="text"]').val('');

		$('input[type="hidden"]').val('');

		$('input[type="search"]').val('');

		$('input[type="checkbox"]').removeAttr('checked');

		$('input[name="type-beds"][value=""]').prop('checked', true);

		$('input[name="type-bath"][value=""]').prop('checked', true);

		$('.search-selects').select2('destroy').val('').select2({width: '100%',theme: "classic",allowClear: true});

		$('.custom-locations').select2('destroy').val('').select2({width: '100%',theme: "classic",allowClear: true});

		$('.custom-locations').select2({

        allowClear: true, width: '100%',theme: "classic",

        ajax: {

            url: get_strings.ajax_url,

            dataType: 'json',

            delay: 250,

            data: function (params) {

                return {

                    q: params.term, // search query

                    action: 'prop_listing_locations',

                };

            },

            processResults: function (data, params) {

                var options = [];

                if (data) {

                    $.each(data, function (index, text) {

                        options.push({id: text[0], text: text[1]});

                    });

                }

                return {

                    results: options,

                };

            },

            cache: true

        },

        minimumInputLength: 1

    });

		$(".grid").height('auto');

        $('.fb-like-animation').show();

        $(".grid").html('');

		$(".my-filer-tags").html('');

		$("#listing_ajax_pagination").html('');

		$.post(get_strings.ajax_url, {action: 'prop_listing_search', collect_data: $("form#mylistings_search").serialize()}).done(function (response)

        {

           $('.fb-like-animation').hide();

           if (true === response.success) 

		   {

			   $('.fb-like-animation').hide();

			   $(".grid").html(response.data.listings);

			   $("#listing_ajax_pagination").html(response.data.pagination);

			   $('[data-toggle="tooltip"]').tooltip();

			   initialiceMasonry();

			   if(get_strings.map_type == 'open_street')

			   {
				   listings_map_regenrate(response.data.map_listings);
			   }
   
			   if(get_strings.map_type == 'mapbox')
   
			   {
				console.log("lllll");
				var img= response.data.imgg;
				var layer= response.data.layer;
				var zoom = response.data.zoom;
				 listings_mapbox_regenrate(response.data.mapbox_data,img,layer,zoom);
   
			   }
			   

		   }

		   else

		   {

			   $(".my-filer-tags").html(response.data.fliters);

			   $(".grid").html(response.data.no_result);

			   listings_map_regenrate(response.data.map_listings);
			   


		   }

        });

	});

	



/*Custom Locations*/

    $('.custom-locations').select2({

        allowClear: true, width: '100%',theme: "classic",

        ajax: {

            url: get_strings.ajax_url,

            dataType: 'json',

            delay: 250,

            data: function (params) {

                return {

                    q: params.term, // search query

                    action: 'prop_listing_locations',

                };

            },

            processResults: function (data, params) {

                var options = [];

                if (data) {

                    $.each(data, function (index, text) {

                        options.push({id: text[0], text: text[1]});

                    });

                }

                return {

                    results: options,

                };

            },

            cache: true

        },

        minimumInputLength: 1

    });





/*Ajax Suggestions*/

	if ($('.for_search_pages').is('.specific_search'))

    {

        $('.for_search_pages').typeahead({

            minLength: 1,

            hint: true,

            maxItem: 15,

            order: "asc",

            dynamic: true,

            delay: 200,

            compression: true,

            emptyTemplate: 'No result found ' + "{{query}}",

            source: {

                ajax: {type: "GET", url: get_strings.ajax_url, data: {q: '{{query}}', action: 'prop_listing_search_suggestions' }},

            },

        });

    }


 function listings_map_regenrate(listing_data)

  {
		var map_lats =  get_strings.map_latt;

		var map_longs = get_strings.map_long;

		if(map_lats && map_longs)
		{

		$('.left-area').html('');

		$('.left-area').html('<div id="mapid" class="map"></div>');

		var ajaxmap = L.map('mapid').setView([map_lats,map_longs], 13);

		L.tileLayer('//{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom: 18,}).addTo(ajaxmap);

		var listing_markers_ajax;

		if(listing_data.length > 0)

		{

			listing_markers_ajax = $.parseJSON(listing_data);

			if(listing_markers_ajax.length > 0)

				{

					var markerClusterss = L.markerClusterGroup();

					var pricing_html = '';

					var featured_html = '';

					var address_html = '';

					for (var i = 0; i < listing_markers_ajax.length; ++i)

					{

					var custom_icon = L.icon({

						iconUrl: get_strings.p_path+'libs/images/map-marker.png',
						iconSize: [50, 50],

					});

					if(listing_markers_ajax[i].pricings.length !=0)

					{

						pricing_html = '<div class="my-list2-pricing"><h3><span class="main-reg-price">'+listing_markers_ajax[i].pricings+'</h3></div>';

					}

					if(listing_markers_ajax[i].is_featured.length !=0)

					{

						featured_html = '<div class="featured-ribbon" data-toggle="tooltip" data-placement="top" data-original-title="'+listing_markers_ajax[i].is_featured+'"><div><i class="fas fa-star"></i></div></div>';

					}

					if(listing_markers[i].street_addr.length !=0)

					{

						address_html = '<p class="extrp"> <span> <i class="fas fa-location-arrow clr-yal"> </i></span>'+listing_markers[i].street_addr+'</p>';

					}

					var popup1 = '<div class="map-in-listings"><div class="list-thumbnail"><a href="' + listing_markers_ajax[i].url_link + '"><img class="img-fluid" src="' + listing_markers_ajax[i].img_url + '" alt=""></a>' + featured_html + '</div><div class="entry-header">'+pricing_html+'<h5 class="card-title"><a class="clr-black" href="' + listing_markers[i].url_link + '">' + listing_markers_ajax[i].title + ' </a></h5><div class="entry-meta">'+address_html+'</div></div></div>';

				var m = L.marker([listing_markers_ajax[i].lat, listing_markers_ajax[i].lng], {icon: custom_icon}).bindPopup(popup1, {minWidth: 270, maxWidth: 270});

				markerClusterss.addLayer(m);

				ajaxmap.fitBounds(markerClusterss.getBounds());

				ajaxmap.addLayer(markerClusterss);



				}

				}

		}

		}

		 }

function listings_mapbox_regenrate(listing_data, img,layer,zoom)

	{

		var map_lats =  get_strings.map_latt;

		var map_longs = get_strings.map_long;

			if(map_lats && map_longs)
			{
			

				$('.left-area').html('');
				$('.left-area').html('<div id="mapid" class="map"></div>');

				var chk_mapcontainer =  document.getElementById('mapid');
				
				var mydata  = {
					"type": "FeatureCollection",
					"crs": { "type": "name", "properties": { "name": "urn:ogc:def:crs:OGC:1.3:CRS84"} },
					"features" :
					listing_data
				
					};

				console.log(mydata);
				var center_data = typeof mydata[0] !== 'undefined' && mydata[0] != '' ? mydata[0].geometry.coordinates : [map_lats, map_longs];
				console.log("hi")
;		console.log(layer);
					var map_marker =   img;
					var map_layer_type = layer;
					var min_zoom= zoom;
				
				mapboxgl.accessToken = get_strings.acc_keyz;	
		
				const map = new mapboxgl.Map({
				container: chk_mapcontainer,// container id
				style: 'mapbox://styles/mapbox/'+map_layer_type+ '?optimize=true',// style URL
				center: center_data, // starting position [lng, lat]
				minzoom: min_zoom,
					});
				map.on('load', () => {
				map.loadImage(map_marker,
					function (error, image) {
						if (error)
							throw error;
						map.addImage('buyent-map-marker', image);
					});
	// Add the image to the map style.
				
				map.addSource('markers', {
					type: 'geojson',
					data: mydata,
					cluster: true,
					clusterMaxZoom: 14, // Max zoom to cluster points on
					clusterRadius: 50,
				
				});
		
				map.addLayer({
					id: 'clusters',
					type: 'circle',
					source: 'markers',
					filter: ['has', 'point_count'],
					paint: {
						"circle-color": [
							"step",
							["get", "point_count"],
							"#51bbd6",
							100,
							"#f1f075",
							750,
							"#f28cb1"
						],
						"circle-radius": [
							"step",
							["get", "point_count"],
							20,
							100,
							30,
							750,
							40
						]
					}
				});
		
				map.addLayer({
					id: "cluster-count",
					type: "symbol",
					source: "markers",
					filter: ["has", "point_count"],
					layout: {
						"text-field": "{point_count_abbreviated}",
						"text-font": ["DIN Offc Pro Medium", "Arial Unicode MS Bold"],
						"text-size": 14
					}
				});
				map.addLayer({
				
					"id": "unclustered-point",
					"source": "markers",
					filter: ['!', ['has', 'point_count']],
					"type": "symbol",
					"layout": { "icon-image": "buyent-map-marker" }
				}); 

			map.on('click', 'clusters', function (e) {
			var features = map.queryRenderedFeatures(e.point, { layers: ['clusters'] });
			var clusterId = features[0].properties.cluster_id;
			map.getSource('markers').getClusterExpansionZoom(
				clusterId,
				function (err, zoom) {
					if (err)
						return;
					map.easeTo({ center: features[0].geometry.coordinates, zoom: zoom });
				}
			);
			});

		map.on('click', 'unclustered-point', function (e) {

		var coordinates = e.features[0].geometry.coordinates.slice();
		var popup_html=e.features[0].properties.html 
		// $('#data').html(popup);
		while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
			coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
		}
		new mapboxgl.Popup({className: 'buyent-search-popup'}).setLngLat(coordinates).setHTML(popup_html).addTo(map);

		});
			map.on('mouseenter', 'clusters', function () { map.getCanvas().style.cursor = 'pointer'; });
			map.on('mouseleave', 'clusters', function () { map.getCanvas().style.cursor = ''; });
	});
 	}		
  }

var chk_singlemapcontainer =  document.getElementById('mapid');	 

function listings_on_map_box(map_lat,map_long)
{
		//console.log(listing_markers_map);
		console.log($('#map_typ').val());
		var mydata  = {
			"type": "FeatureCollection",
			"crs": { "type": "name", "properties": { "name": "urn:ogc:def:crs:OGC:1.3:CRS84"} },
			"features" :
				listing_markers_map
		
		};

	
	
	if(map_lat !=="" && map_long !=="")
		{
			var center_data = typeof mydata[0] !== 'undefined' && mydata[0] != '' ? mydata.features[0].geometry.coordinates : [map_lat, map_long];
			console.log(center_data);
			
			var map_marker =   $('#map_marker_img').val();
			var map_layer_type = $('#map_layer').val();
            var min_zoom= $('#map_zoom').val();

			if(map_layer_type == '' || min_zoom == '' )
			{
				alert("PLease select Mapbox options")
			}
			  console.log(map_layer_type);
			  console.log(min_zoom);

			  mapboxgl.accessToken = get_strings.acc_keyz;	
			
			    const map = new mapboxgl.Map({
				container: chk_singlemapcontainer,// container id
				style: 'mapbox://styles/mapbox/'+map_layer_type+ '?optimize=true', // style URL
				center: center_data, // starting position [lng, lat]
				minzoom: min_zoom,
               // maxzoom: 9, // starting zoom
			  });
			  map.on('load', () => {
				map.loadImage(map_marker,
					function (error, image) {
						if (error)
							throw error;
						map.addImage('buyent-map-marker', image);
					});	 
					// Add the image to the map style.	
			  map.addSource('markers', {
				type: 'geojson',
				data: mydata,
				cluster: true,
				clusterMaxZoom: 14, // Max zoom to cluster points on
				clusterRadius: 50,
			  });

			  map.addLayer({
				id: 'clusters',
				type: 'circle',
				source: 'markers',
				filter: ['has', 'point_count'],
				paint: {
					"circle-color": [
						"step",
						["get", "point_count"],
						"#51bbd6",
						100,
						"#f1f075",
						750,
						"#f28cb1"
					],
					"circle-radius": [
						"step",
						["get", "point_count"],
						20,
						100,
						30,
						750,
						40
					]
				}
			  });
			   
			map.addLayer({
				id: "cluster-count",
				type: "symbol",
				source: "markers",
				filter: ["has", "point_count"],
				layout: {
					"text-field": "{point_count_abbreviated}",
					"text-font": ["DIN Offc Pro Medium", "Arial Unicode MS Bold"],
					"text-size": 14
				}
			});
			map.addLayer({
			
				"id": "unclustered-point",
				"source": "markers",
				filter: ['!', ['has', 'point_count']],
				"type": "symbol",
				"layout": { "icon-image": "buyent-map-marker" }
			}); 

    map.on('click', 'clusters', function (e) {
	var features = map.queryRenderedFeatures(e.point, { layers: ['clusters'] });
	var clusterId = features[0].properties.cluster_id;
	map.getSource('markers').getClusterExpansionZoom(
			clusterId,
			function (err, zoom) {
				if (err)
					return;
				map.easeTo({ center: features[0].geometry.coordinates, zoom: zoom });
			}
	);
});

    map.on('click', 'unclustered-point', function (e) {

		var coordinates = e.features[0].geometry.coordinates.slice();
		var popup_html=e.features[0].properties.html 
		// $('#data').html(popup);
		while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
			coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
		}
		new mapboxgl.Popup({className: 'buyent-search-popup'}).setLngLat(coordinates).setHTML(popup_html).addTo(map);
	
});
   map.on('mouseenter', 'clusters', function () { map.getCanvas().style.cursor = 'pointer'; });
   map.on('mouseleave', 'clusters', function () { map.getCanvas().style.cursor = ''; });
	});

	
	}
}
	   
//=======================================================================================
	function listings_on_map(map_lat,map_long)

	{
			console.log($('#map_typ').val());
			   var single_detailmap = L.map(chk_singlemapcontainer).setView([map_lat,map_long], 13);

			   L.tileLayer('//{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom: 18,}).addTo(single_detailmap);

			   var markerClusters = L.markerClusterGroup();

			   var pricing_html = '';

			   var featured_html = '';

			   var address_html = '';

			   for (var i = 0; i < listing_markers.length; ++i)

			   {

					var custom_icon = L.icon({

						iconUrl: get_strings.p_path+'libs/images/map-marker.png',

						iconSize: [50, 50],

        			});

					if(listing_markers[i].pricings.length !=0)

					{

						pricing_html = '<div class="my-list2-pricing"><h3><span class="main-reg-price">'+listing_markers[i].pricings+'</h3></div>';

					}

					if(listing_markers[i].is_featured.length !=0)

					{

						featured_html = '<div class="featured-ribbon" data-toggle="tooltip" data-placement="top" data-original-title="'+listing_markers[i].is_featured+'"><div><i class="fas fa-star"></i></div></div>';

					}

					if(listing_markers[i].street_addr.length !=0)

					{

						address_html = '<p class="extrp"> <span> <i class="fas fa-location-arrow clr-yal"> </i></span>'+listing_markers[i].street_addr+'</p>';

					}

					var popup = '<div class="map-in-listings"><div class="list-thumbnail"><a href="' + listing_markers[i].url_link + '"><img class="img-fluid" src="' + listing_markers[i].img_url + '" alt=""></a>' + featured_html + '</div><div class="entry-header">'+pricing_html+'<h5 class="card-title"><a class="clr-black" href="' + listing_markers[i].url_link + '">' + listing_markers[i].title + ' </a></h5><div class="entry-meta">'+address_html+'</div></div></div>';

                var m = L.marker([listing_markers[i].lat, listing_markers[i].lng], {icon: custom_icon}).bindPopup(popup, {minWidth: 270, maxWidth: 270});

                markerClusters.addLayer(m);

                single_detailmap.fitBounds(markerClusters.getBounds());

                single_detailmap.addLayer(markerClusters);



			   }

	   }

	   

	   

/* Re-initialize*/

function initialiceMasonry()

{

	var $item = $('.grid');

    $item.imagesLoaded(function () {

		 $item.isotope();

		$item.masonry('reloadItems');

		$item.isotope('destroy');

        $item.isotope({

            itemSelector: '.grid-item',

            percentPosition: true,

            layoutMode: 'masonry',

            transitionDuration: '0.7s',

            masonry: {

                columnWidth: '.grid-item'

            }

        });

    });

}



	   

	}

})(jQuery);
