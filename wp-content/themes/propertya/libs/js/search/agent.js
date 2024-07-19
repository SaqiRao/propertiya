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
		$(".grid").height('auto');
        $('.fb-like-animation').show();
        $(".grid").html('');
		$("#listing_ajax_pagination").html('');
		var sort_by = $("#sort-by").val();
		$('html, body').animate({
		 scrollTop: $(".page-template").offset().top
		}, 200);
		$.post(get_strings.ajax_url, {action: 'prop_agent_search', collect_data: $("form#myagents_search").serialize(), page_no: page_no,sort_by: sort_by}).done(function (response)
        {
			
			if (true === response.success) 
			{
				$('.fb-like-animation').hide();
				$(".grid").html(response.data.listings);
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
               $(".filter-sorting-bar .clr-yal").html(response.data.total_results);
			   $(".grid").html(response.data.no_result);
               
		    }
		});
	});
	
	/*Form search fields*/
	$('button[name=agencies_search]').on('click', function () {
		$(".grid").height('auto');
        $('.fb-like-animation').show();
        $(".grid").html('');
		$("#listing_ajax_pagination").html('');
		var sort_by = $("#sort-by").val();
        $.post(get_strings.ajax_url, {action: 'prop_agent_search', collect_data: $("form#myagents_search").serialize(),sort_by: sort_by}).done(function (response)
        {
           $('.fb-like-animation').hide();
           if (true === response.success) 
		   {
			   $('.fb-like-animation').hide();
               $(".filter-sorting-bar .clr-yal").html(response.data.total_results);
			   $(".grid").html(response.data.listings);
			   $(".my-filer-tags").html(response.data.fliters);
			   $("#listing_ajax_pagination").html(response.data.pagination);
			   $('html, body').animate({
				 scrollTop: $(".page-template").offset().top
			   }, 200);
			   $('[data-toggle="tooltip"]').tooltip();
			   initialiceMasonry();
		   }
		   else
		   {
               $(".filter-sorting-bar .clr-yal").html(response.data.total_results);
			   $(".my-filer-tags").html(response.data.fliters);
			   $(".grid").html(response.data.no_result);
		   }
        });
    });
	
	/*Sort by*/
	$(document.body).on('change', '#sort-by', function () {
	    var sort_by = $(this).val();
		$(".grid").height('auto');
        $('.fb-like-animation').show();
        $(".grid").html('');
		$("#listing_ajax_pagination").html('');
        $.post(get_strings.ajax_url, {action: 'prop_agent_search', collect_data: $("form#myagents_search").serialize(), sort_by: sort_by}).done(function (response)
        {
           $('.fb-like-animation').hide();
           if (true === response.success) 
		   {
			   $('.fb-like-animation').hide();
               $(".filter-sorting-bar .clr-yal").html(response.data.total_results);
			   $(".grid").html(response.data.listings);
			   $(".my-filer-tags").html(response.data.fliters);
			   $("#listing_ajax_pagination").html(response.data.pagination);
			   $('html, body').animate({
				 scrollTop: $(".page-template").offset().top
			   }, 200);
			   $('[data-toggle="tooltip"]').tooltip();
			   initialiceMasonry();
		   }
		   else
		   {
               $(".filter-sorting-bar .clr-yal").html(response.data.total_results);
			   $(".my-filer-tags").html(response.data.fliters);
			   $(".grid").html(response.data.no_result);
		   }
        });
		
	});
	
	/*Reset All Filters*/
		$(document).on('click', '#reset_ajax_result', function () {
		$('.distance-slider').hide();	
		$('input[name="by_title"]').val('');
        $('input[name="by_location"]').val('');
		$('input[name="latt"]').val('');
		$('input[name="long"]').val('');
		$('input[name="distance"]').val('');
		$('input[type="hidden"]').val('');
		$('.search-selects').val(null).trigger('change');
		$(".grid").height('auto');
        $('.fb-like-animation').show();
        $(".grid").html('');
		$(".my-filer-tags").html('');
		$("#listing_ajax_pagination").html('');
		$.post(get_strings.ajax_url, {action: 'prop_agent_search', collect_data: $("form#myagents_search").serialize()}).done(function (response)
        {
           $('.fb-like-animation').hide();
           if (true === response.success) 
		   {
			   $('.fb-like-animation').hide();
               $(".filter-sorting-bar .clr-yal").html(response.data.total_results);
			   $(".grid").html(response.data.listings);
			   $("#listing_ajax_pagination").html(response.data.pagination);
			   $('html, body').animate({
				 scrollTop: $(".page-template").offset().top
			   }, 200);
			   $('[data-toggle="tooltip"]').tooltip();
			   initialiceMasonry();
		   }
		   else
		   {
               $(".filter-sorting-bar .clr-yal").html(response.data.total_results);
			   $(".my-filer-tags").html(response.data.fliters);
			   $(".grid").html(response.data.no_result);
		   }
        });
	});
	
	
	/*Ajax Suggestions*/
	if ($('.for_search_pages ').is('.specific_search'))
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
                ajax: {type: "GET", url: get_strings.ajax_url, data: {q: '{{query}}', action: 'prop_agent_search_suggestions' }},
            },
        });
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