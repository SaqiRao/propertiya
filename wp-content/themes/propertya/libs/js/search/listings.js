(function($) {
    "use strict";	
	
if(typeof(get_strings) !== 'undefined' && get_strings !== null)
{	
if ($('.my_range_slider').length > 0)
{
	$('.my_range_slider').nstSlider({
		  "left_grip_selector": ".leftGrip",
		  "value_changed_callback": function (cause, leftValue) {
			$(this).parent().find('.leftLabel').text(leftValue);
			$('input[name="distance"]').val(leftValue);
		  }
	});
}

   if ($('.bd-sidebar').is('.do-nicescroll')) 
   {
        const ps = new
                PerfectScrollbar('.do-nicescroll', {
                wheelSpeed: 2,
                wheelPropagation: false,
                minScrollbarLength: 30
         });
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
function show_location(position)
{
	    $('input[name="latt"]').val(position.coords.latitude);
		$('input[name="long"]').val(position.coords.longitude);
		$('.distance-slider').slideDown('slow');
        $('.sonu-button').buttonLoader('stop');
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

	/*Pagination*/
	$(document.body).on('click', '.fetch_result', function () {
        var page_no = $(this).attr("data-page-no");
        $(this).addClass("active");
        $(".fetch_result").not(this).removeClass("active");
		$(".grid.mysearch-page").height('auto');
        $('.fb-like-animation').show();
        $(".grid.mysearch-page").html('');
		$("#listing_ajax_pagination").html('');
		var sort_by = $("#sort-by").val();
		$('html, body').animate({
		 scrollTop: $(".search-section").offset().top
		}, 200);
		$.post(get_strings.ajax_url, {action: 'prop_listing_search', collect_data: $("form#mylistings_search").serialize(), page_no: page_no,sort_by: sort_by}).done(function (response)
        {
			if (true === response.success) 
			{
				$('.fb-like-animation').hide();
				$(".grid.mysearch-page").html(response.data.listings);
				$(".my-filer-tags").html(response.data.fliters);
				$("#listing_ajax_pagination").html(response.data.pagination);
                $(".filter-sorting-bar .clr-yal").html(response.data.total_results);
				$('[data-toggle="tooltip"]').tooltip();
				// $('.for_search_pages').action("javascript:void()");
				initialiceMasonry();
			}
			else
		    {
			   $('.fb-like-animation').hide();
			   $(".my-filer-tags").html(response.data.fliters);
			   $(".grid.mysearch-page").html(response.data.no_result);
               $(".filter-sorting-bar .clr-yal").html(response.data.total_results);
		    }
		});
	});
	
	/*Form search fields*/
	$('button[name=properties_search]').on('click', function () {
		$(".grid.mysearch-page").height('auto');
        $('.fb-like-animation').show();
        $(".grid.mysearch-page").html('');
		$("#listing_ajax_pagination").html('');
		var sort_by = $("#sort-by").val();
        $.post(get_strings.ajax_url, {action: 'prop_listing_search', collect_data: $("form#mylistings_search").serialize(),sort_by: sort_by}).done(function (response)
        {
           $('.fb-like-animation').hide();
           if (true === response.success) 
		   {
			   $('.fb-like-animation').hide();
			   $(".grid.mysearch-page").html(response.data.listings);
			   $(".my-filer-tags").html(response.data.fliters);
			   $("#listing_ajax_pagination").html(response.data.pagination);
               $(".filter-sorting-bar .clr-yal").html(response.data.total_results);
			   $('html, body').animate({
				 scrollTop: $(".search-section").offset().top
			   }, 200);
			   $('[data-toggle="tooltip"]').tooltip();
			   initialiceMasonry();
		   }
		   else
		   {
			   $(".my-filer-tags").html(response.data.fliters);
			  $(".grid.mysearch-page").html(response.data.no_result);
               $(".filter-sorting-bar .clr-yal").html(response.data.total_results);
		   }
        });
    });
	
	/*Sort by*/
	$(document.body).on('change', '#sort-by', function () {
	    var sort_by = $(this).val();
		$(".grid.mysearch-page").height('auto');
        $('.fb-like-animation').show();
        $(".grid.mysearch-page").html('');
		$("#listing_ajax_pagination").html('');
        $.post(get_strings.ajax_url, {action: 'prop_listing_search', collect_data: $("form#mylistings_search").serialize(), sort_by: sort_by}).done(function (response)
        {
           $('.fb-like-animation').hide();
           if (true === response.success) 
		   {
			   $('.fb-like-animation').hide();
			   $(".grid.mysearch-page").html(response.data.listings);
			   $(".my-filer-tags").html(response.data.fliters);
			   $("#listing_ajax_pagination").html(response.data.pagination);
               $(".filter-sorting-bar .clr-yal").html(response.data.total_results);
			   $('html, body').animate({
				 scrollTop: $(".search-section").offset().top
			   }, 200);
			   $('[data-toggle="tooltip"]').tooltip();
			   initialiceMasonry();
		   }
		   else
		   {
			   $(".my-filer-tags").html(response.data.fliters);
			   $(".grid.mysearch-page").html(response.data.no_result);
               $(".filter-sorting-bar .clr-yal").html(response.data.total_results);
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
		$('.search-selects').val(null).trigger('change');
		$('.custom-locations').val(null).trigger('change');
		$(".grid.mysearch-page").height('auto');
        $('.fb-like-animation').show();
        $(".grid.mysearch-page").html('');
		$(".my-filer-tags").html('');
		$("#listing_ajax_pagination").html('');
		$.post(get_strings.ajax_url, {action: 'prop_listing_search', collect_data: $("form#mylistings_search").serialize()}).done(function (response)
        {
           $('.fb-like-animation').hide();
           if (true === response.success) 
		   {
			   $('.fb-like-animation').hide();
			   $(".grid.mysearch-page").html(response.data.listings);
               $(".filter-sorting-bar .clr-yal").html(response.data.total_results);
			   $("#listing_ajax_pagination").html(response.data.pagination);
			   $('html, body').animate({
				 scrollTop: $(".search-section").offset().top
			   }, 200);
			   $('[data-toggle="tooltip"]').tooltip();
			   initialiceMasonry();
		   }
		   else
		   {
			   $(".my-filer-tags").html(response.data.fliters);
			   $(".grid.mysearch-page").html(response.data.no_result);
               $(".filter-sorting-bar .clr-yal").html(response.data.total_results);
		   }
        });
	});
    
    //for home search
    
    /*Pagination*/
	$(document.body).on('click', '.fetch_result_home', function () {
        var page_no = $(this).attr("data-page-no");
        $(this).addClass("active");
        $(".fetch_result_home").not(this).removeClass("active");
		$(".grid.mysearch-page").height('auto');
        $('.fb-like-animation').show();
        $(".grid.mysearch-page").html('');
		$("#listing_ajax_pagination").html('');
		var sort_by = $("#sort-by-home").val();
		$('html, body').animate({
		 scrollTop: $(".search-section").offset().top
		}, 200);
		$.post(get_strings.ajax_url, {action: 'prop_listing_search_home', collect_data: $("form#mylistings_search").serialize(), page_no: page_no,sort_by: sort_by}).done(function (response)
        {
			if (true === response.success) 
			{
				$('.fb-like-animation').hide();
				$(".grid.mysearch-page").html(response.data.listings);
				$(".my-filer-tags").html(response.data.fliters);
				$("#listing_ajax_pagination").html(response.data.pagination);
                $(".filter-sorting-bar .clr-yal").html(response.data.total_results);
				$('[data-toggle="tooltip"]').tooltip();
				initialiceMasonry();
			}
			else
		    {
			   $('.fb-like-animation').hide();
			   $(".my-filer-tags").html(response.data.fliters);
			   $(".grid.mysearch-page").html(response.data.no_result);
               $(".filter-sorting-bar .clr-yal").html(response.data.total_results);
		    }
		});
	});
	/*Form search fields*/
	$('button[name=properties_search_home]').on('click', function () {
		$(".grid.mysearch-page").height('auto');
        $('.fb-like-animation').show();
        $(".grid.mysearch-page").html('');
		$("#listing_ajax_pagination").html('');
		var sort_by = $("#sort-by-home").val();
        $.post(get_strings.ajax_url, {action: 'prop_listing_search_home', collect_data: $("form#mylistings_search").serialize(),sort_by: sort_by}).done(function (response)
        {
           $('.fb-like-animation').hide();
           if (true === response.success) 
		   {
			   $('.fb-like-animation').hide();
			   $(".grid.mysearch-page").html(response.data.listings);
			   $(".my-filer-tags").html(response.data.fliters);
			   $("#listing_ajax_pagination").html(response.data.pagination);
               $(".filter-sorting-bar .clr-yal").html(response.data.total_results);
			   $('html, body').animate({
				 scrollTop: $(".search-section").offset().top
			   }, 200);
			   $('[data-toggle="tooltip"]').tooltip();
			   initialiceMasonry();
		   }
		   else
		   {
			   $(".my-filer-tags").html(response.data.fliters);
			  $(".grid.mysearch-page").html(response.data.no_result);
               $(".filter-sorting-bar .clr-yal").html(response.data.total_results);
		   }
        });
    });
    
    /*Reset All Filters Home*/
		$(document.body).on('click', '#reset_ajax_result_home', function () {
		$('.distance-slider').hide();
		$('input[type="text"]').val('');
		//$('input[type="hidden"]').val('');
		$('input[type="search"]').val('');
		$('input[type="checkbox"]').removeAttr('checked');
		$('input[name="type-beds"][value=""]').prop('checked', true);
		$('input[name="type-bath"][value=""]').prop('checked', true);
		$('.search-selects').val(null).trigger('change');
		$('.custom-locations').val(null).trigger('change');
		$(".grid.mysearch-page").height('auto');
        $('.fb-like-animation').show();
        $(".grid.mysearch-page").html('');
		$(".my-filer-tags").html('');
		$("#listing_ajax_pagination").html('');
		$.post(get_strings.ajax_url, {action: 'prop_listing_search_home', collect_data: $("form#mylistings_search").serialize()}).done(function (response)
        {
           $('.fb-like-animation').hide();
           if (true === response.success) 
		   {
			   $('.fb-like-animation').hide();
			   $(".grid.mysearch-page").html(response.data.listings);
               $(".filter-sorting-bar .clr-yal").html(response.data.total_results);
			   $("#listing_ajax_pagination").html(response.data.pagination);
			   $('html, body').animate({
				 scrollTop: $(".search-section").offset().top
			   }, 200);
			   $('[data-toggle="tooltip"]').tooltip();
			   initialiceMasonry();
		   }
		   else
		   {
			   $(".my-filer-tags").html(response.data.fliters);
			   $(".grid.mysearch-page").html(response.data.no_result);
               $(".filter-sorting-bar .clr-yal").html(response.data.total_results);
		   }
        });
	});
    
    
    /*Sort by home*/
	$(document.body).on('change', '#sort-by-home', function () {
	    var sort_by = $(this).val();
		$(".grid.mysearch-page").height('auto');
        $('.fb-like-animation').show();
        $(".grid.mysearch-page").html('');
		$("#listing_ajax_pagination").html('');
        $.post(get_strings.ajax_url, {action: 'prop_listing_search_home', collect_data: $("form#mylistings_search").serialize(), sort_by: sort_by}).done(function (response)
        {
           $('.fb-like-animation').hide();
           if (true === response.success) 
		   {
			   $('.fb-like-animation').hide();
			   $(".grid.mysearch-page").html(response.data.listings);
			   $(".my-filer-tags").html(response.data.fliters);
			   $("#listing_ajax_pagination").html(response.data.pagination);
               $(".filter-sorting-bar .clr-yal").html(response.data.total_results);
			   $('html, body').animate({
				 scrollTop: $(".search-section").offset().top
			   }, 200);
			   $('[data-toggle="tooltip"]').tooltip();
			   initialiceMasonry();
		   }
		   else
		   {
			   $(".my-filer-tags").html(response.data.fliters);
			   $(".grid.mysearch-page").html(response.data.no_result);
               $(".filter-sorting-bar .clr-yal").html(response.data.total_results);
		   }
        });
		
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
        /*"language": {
            "errorLoading": function () {
                return search_strings.errorLoading;
            },
            "inputTooShort": function () {
                return search_strings.inputTooShort;
            },
            "searching": function () {
                return search_strings.searching;
            },
            "noResults": function () {
                return search_strings.noResults;
            }
        },*/
        minimumInputLength: 1
    });



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