(function($) {
	"use strict";


	if( $( 'select' ).length > 0 ) {
		$( '.custom-fields' ).select2({ width:'100%',allowClear: true});
	}


	$('.admin-ul.for-featured input[type="radio"]').on('change', function () {
		var featured_val = $(this).val();
		if (featured_val == 1)
		{
			$("#featured-for").removeClass("none");
			$("input#featured_for_days").prop('required', true);
		} else
		{
			$("#featured-for").addClass("none");
			$("input#featured_for_days").prop('required', false);
		}
	});





	var meta_gallery_frame_brand;
	$('#dwt_listing_brand_btn').on('click', function(e){
		// sonu code here.
		if ( meta_gallery_frame_brand ) {
			meta_gallery_frame_brand.open();
			return;
		}
		// Sets up the media library frame
		meta_gallery_frame_brand = wp.media.frames.meta_gallery_frame_brand = wp.media({
			title: admin_varible.select_imgz,
			button: { text:  dwt_listing_b_logo_id.button },
			library: { type: 'image' },
			multiple: false
		});
		// Create Featured Gallery state. This is essentially the Gallery state, but selection behavior is altered.
		meta_gallery_frame_brand.states.add([
			new wp.media.controller.Library({
				priority:   20,
				toolbar:    'main-gallery',
				filterable: 'uploaded',
				library:    wp.media.query( meta_gallery_frame_brand.options.library ),
				multiple:   meta_gallery_frame_brand.options.multiple ? 'reset' : false,
				editable:   true,
				allowLocalEdits: true,
				displaySettings: true,
				displayUserSettings: true
			}),
		]);
		var idsArray;
		var attachmentz;
		meta_gallery_frame_brand.on('open', function() {
			var selection = meta_gallery_frame_brand.state().get('selection');
			var library = meta_gallery_frame_brand.state('gallery-edit').get('library');
			var ids = $('#dwt_listing_b_logo_id').val();
		});
		meta_gallery_frame_brand.on('ready', function() {
			$( '.media-modal' ).addClass( 'no-sidebar' );
		});
		var imagesz;
		// When an image is selected, run a callback.
		//meta_gallery_frame.on('update', function() {
		meta_gallery_frame_brand.on('select', function() {
			var imageIDArrayz = [];
			var imageHTMLz = '';
			var metadataStringz = '';
			imagesz = meta_gallery_frame_brand.state().get('selection');
			imageHTMLz += '<ul class="dwt_listing_gallery">';
			imagesz.each(function(attachmentz) {
				//sonu get image object
				console.debug(attachmentz.attributes);
				imageIDArrayz.push(attachmentz.attributes.id);
				imageHTMLz += '<li><div class="dwt_listing_gallery_container"><span class="dwt_listing_delete_icon_brand"><img id="'+attachmentz.attributes.id+'" src="'+attachmentz.attributes.url+'"></span></div></li>';
			});
			imageHTMLz += '</ul>';
			metadataStringz = imageIDArrayz.join(",");
			if (metadataStringz) {
				$("#dwt_listing_b_logo_id").val(metadataStringz);
				$("#dwt_listing_gall_render_html").html(imageHTMLz);
			}
		});
		// Finally, open the modal
		meta_gallery_frame_brand.open();
	});

	$(document.body).on('click', '.dwt_listing_delete_icon_brand', function(event){
		event.preventDefault();
		if (confirm(admin_varible.img_del))
		{
			var removedImagez = $(this).children('img').attr('id');
			var oldGalleryz = $("#dwt_listing_b_logo_id").val();
			var newGalleryz = oldGalleryz.replace(','+removedImagez,'').replace(removedImagez+',','').replace(removedImagez,'');
			$(this).parents().eq(1).remove();
			$("#dwt_listing_b_logo_id").val(newGalleryz);
		}
	});


	var meta_gallery_frame_event;
	$('#dwt_listing_event_button').on('click', function(e){
		if (meta_gallery_frame_event) {
			meta_gallery_frame_event.open();
			return;
		}
		meta_gallery_frame_event = wp.media.frames.meta_gallery_frame_event = wp.media({
			title: admin_varible.select_imgz,
			button: { text:  dwt_listing_event_idz.button },
			library: { type: 'image' },
			multiple: true
		});
		meta_gallery_frame_event.states.add([
			new wp.media.controller.Library({
				priority:   20,
				toolbar:    'main-gallery',
				filterable: 'uploaded',
				library:    wp.media.query( meta_gallery_frame_event.options.library ),
				multiple:   meta_gallery_frame_event.options.multiple ? 'reset' : false,
				editable:   true,
				allowLocalEdits: true,
				displaySettings: true,
				displayUserSettings: true
			}),
		]);
		var idsArray_events;
		var attachment_eventz;
		meta_gallery_frame_event.on('open', function() {
			var event_selection = meta_gallery_frame_event.state().get('selection');
			var library_event = meta_gallery_frame_event.state('gallery-edit').get('library');
			var event_ids = $('#dwt_listing_event_idz').val();
			if (event_ids) {
				idsArray_events = event_ids.split(',');
				idsArray_events.forEach(function(id) {
					attachment_eventz = wp.media.attachment(id);
					attachment_eventz.fetch();
					event_selection.add( attachment_eventz ? [ attachment_eventz ] : [] );
				});
			}
		});
		meta_gallery_frame_event.on('ready', function() {
			$( '.media-modal' ).addClass( 'no-sidebar' );
		});
		var images_event;
		meta_gallery_frame_event.on('select', function() {
			var imageIDArray = [];
			var imageHTML = '';
			var metadataString = '';
			images_event = meta_gallery_frame_event.state().get('selection');
			imageHTML += '<ul class="dwt_listing_gallery">';
			images_event.each(function(attachment_eventz) {
				console.debug(attachment_eventz.attributes);
				imageIDArray.push(attachment_eventz.attributes.id);
				imageHTML += '<li><div class="dwt_listing_gallery_container"><span class="dwt_event_delete_icon"><img id="'+attachment_eventz.attributes.id+'" src="'+attachment_eventz.attributes.sizes.thumbnail.url+'"></span></div></li>';
			});
			imageHTML += '</ul>';
			metadataString = imageIDArray.join(",");
			if (metadataString) {
				$("#dwt_listing_event_idz").val(metadataString);
				$("#dwt_listing_gall_render_event").html(imageHTML);
			}
		});
		meta_gallery_frame_event.open();
	});
	//custom field
	$('.get_custom_field').on('change', function () {
		var cat_parent = $(this).val();
		$(".overlay-cover").show();
		$(".get_custom_field").buttonLoader('start');
		$(".get_custom_field").attr("disabled", true);


		$.post(get_strings.ajax_url, {action: 'prop_get_custom', cat_parent: cat_parent}).done(function (response){

			$(".get_custom_field").buttonLoader('stop');
			$(".get_custom_field").attr("disabled", false);

			if (true === response.success) {
				$('.mx-custom-fields').css("display", "block");
				$('#dynamic-custom-fields').html(response.data.fields);
				$(".overlay-cover").hide();
				if ($(".custom-fields-theme-selects").length > 0) {
					$('.custom-fields-theme-selects').select2({width: '100%', theme: "classic"});
				}
				if ($(".custom-range-slider").length > 0) {
					$(".custom-range-slider").ionRangeSlider({skin: "round"});
				}
			} else {
				$('.mx-custom-fields').buttonLoader("hide");
				$('.mx-custom-fields').css("display", "none");
			}
		});
	});


	if(	$(".custom-meta-gallery").length > 0){
	$(".custom-meta-gallery").sortable({
		handle : '.shuffle-img',
		cancel:'',
		connectWith: ".sort_list_img",
		cursor: 'move',
		forcePlaceholderSize: true,
		update : function () {
			var orderz =  $(this).sortable('toArray').toString();
			$("#selected_imgz_idz").val(orderz);
		}
	});
}

	////
	
	$('#btnSubmit').on('click', function()
	{
		$.post(ajaxurl, {action: 'update_meta', }).done(function (response){

			if (true === response.success) {
				notify('success', get_strings.congratulations, response.data.message);
				window.location.reload(true);
				
			} else {
				
				notify('error', get_strings.whoops, response.data.message);

			}
		});
			
	
			
	
		});

  ////

})(jQuery);

function dwt_listing_fresh_install()
{
	var is_fresh_copy =	confirm("Are you installing it with fresh copy of WordPress? Please only select OK if it is fresh installation.");
	if( is_fresh_copy )
	{
		jQuery.ajax({
			type: "POST",
			url: ajaxurl,
			data: { action: 'demo_data_start' , is_fresh: 'yes' }
		}).done(function( msg ) {
		});

	}
}