	
 if(typeof(form_strings) !== 'undefined' && form_strings !== null)
{
	(function($) {
		"use strict";
			var myLanguage = {
			 errorTitle: form_strings.submission_fail,
			};	
			$.validate({
				form : '#prop_submission',
				modules : 'sanitize',
				validateHiddenInputs : true,
				validateOnBlur : false, 
				errorMessagePosition : 'top',
				scrollToTopOnError : true, 
				language : myLanguage,
				onSuccess : function() {
				var desc = tinyMCE.get('prop-desc').getContent();
				$('.sonu-button').buttonLoader('start');
				$(".sonu-button").attr("disabled", true);	
				$.post(form_strings.ajax_url,{action : 'prop_submission', collect_data:$( "form[name='prop_submission']").serialize()+"&prop-desc="+desc}).done( function(response) 
				{
					$('.sonu-button').buttonLoader('stop');
					$(".sonu-button").attr("disabled", false);
					if (true === response.success) {
						$( "form[name='prop_submission']")[0].reset();
						notify('success', get_strings.congratulations,response.data.message);
						window.location	=	response.data.referral;
					}
					else {
						  	notify('info', get_strings.whoops, response.data.message);
					}
				});
				  return false;
				}
			});
			$("#generate_fields").sortable({ 
				handle : '.shuffle-fields',
				cancel:'',
				connectWith: ".row", 
				cursor: 'move', 
				forcePlaceholderSize: true,
				update : function () { 
				var order =  $(this).sortable('toArray').toString();
					$("#sortable_idz").val(order);
				} 
			});
			
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
			$("#selected_attach_html_render").sortable({ 
				handle : '.shuffle-attachs',
				cancel:'',
				tolerance: "pointer",
				connectWith: ".att_suff", 
				cursor: 'move', 
				forcePlaceholderSize: true,
				update : function () { 
				var orderzz =  $(this).sortable('toArray').toString();
					$("#selected_attach_idz").val(orderzz);
				} 
			});

		
$(document).ready( function() {
	
$(document.body).on('change', '.floorplan_btn_click', function(e){
	e.preventDefault();
	var active_click_id = $(this).attr("data-activeplan");
	var property_id = $(this).attr('data-property-id');
	var attachment_file = $('#active_imgid_'+active_click_id)[0].files[0];
	$('.florplan-pre-'+active_click_id).show();
	var form_data = new FormData();
	form_data.append('flrplan-upload', attachment_file);
	form_data.append('property_id', property_id);
	form_data.append('action', 'prop_myplans_img');
	$.ajax({
		url: form_strings.ajax_url,
		type: 'POST',
		contentType: false,
		processData: false,
		data: form_data,
		success: function (response)
		{
			if (true === response.success) {
				$('.florplan-pre-'+active_click_id).hide();
				$('#plan_image_src_'+active_click_id).attr('src', response.data.img_link);
				$('#flor_uploaded_'+active_click_id).val(response.data.attach_id);
				$('.show_del_plan_'+active_click_id).attr('data-delflr-id', response.data.attach_id);
				$('.show_del_plan_'+active_click_id).show();
			}
			else {
				  $('.florplan-pre-'+active_click_id).hide();
				  $('.show_del_plan_'+active_click_id).hide();
				  $('.show_del_plan_'+active_click_id).attr('data-delflr-id', '');
				  notify('error', form_strings.whoops, response.data.message); 
			}
		}
	});
});
 /* Delete FloorPlan Images*/
$(document.body).on('click', '.flp-del', function(e){
			e.preventDefault();
			var attachment_id = $(this).attr("data-delflr-id");
			var loop_id = $(this).attr("data-imgplan");
			$.confirm({
			title: form_strings.conf,
			icon: 'fa fa-question',
			theme: 'material',
			closeIcon: true,
			type: 'orange',
			animation: 'scale',
			content: form_strings.content,
			buttons: {
				'confirm': {
						text: form_strings.ok,
						action: function () { 
							$.post(form_strings.ajax_url,{action : 'prop_delete_flr_pln_attachment', attachment_id:attachment_id}).done( function(response) 
							{
							if (true === response.success) {
								$('#plan_image_src_'+loop_id).attr('src','');
								$('#flor_uploaded_'+loop_id).val(response.data.selected_attachments);
								$('.show_del_plan_'+loop_id).hide();
				  				$('.show_del_plan_'+loop_id).attr('data-delflr-id', '');
							}
							else {
								  notify('info', get_strings.whoops, response.data.message);
							}
						});
						}
				},
				cancle: {
						text: form_strings.cancle,
					},
			}
		});
});

	 /* Gallery files*/
	$(document.body).on('change', '#gallery_files', function (e) {
		 e.preventDefault;
		 $("#selected_imgz_html_render").html('');
		 var fd = new FormData();
		 var files_datas = $('#gallery_files');
		 var listing_id = $(this).attr('data-listing-id');
		 $.each($(files_datas), function(i, obj) {
            $.each(obj.files,function(j,file){
                fd.append('files[' + j + ']', file);
            })
        });
		var total_images = document.getElementById("gallery_files").files.length;
		var imageHTML = '';
		imageHTML += '<ul class="custom-meta-gallery only-with-preview ">';
		for(var i=0;i<total_images;i++)
		{
			imageHTML +='<li class="sort_list_img"><div class="custom-meta-gallery_container "><span class="loading-center"><i class="fas fa-spinner fa-spin"></i> </span><div class="pre-temp-img"><img class="img-fluid" src='+URL.createObjectURL(event.target.files[i])+' alt=""></div></div><div class="img-overlay"></div></li>';
		}
		imageHTML += '</ul>';
		$(".temp_gallery_data").html(imageHTML);
		fd.append('property_id', listing_id);	
		fd.append('action', 'prop_gallery_images');
		$.ajax({
                url: form_strings.ajax_url,
                type: 'POST',
                contentType: false,
                processData: false,
                data: fd,
                success: function (response)
				{
                    if (true === response.success) {
						$(".temp_gallery_data").html('');
						$("#selected_imgz_html_render").html(response.data.referral_data);
						$("#selected_imgz_idz").val(response.data.selected_attachments);
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
					else {
						 $(".temp_gallery_data").html('');
						 notify('error', get_strings.whoops, response.data.message); 
					}
                }
            });
	});
	
	function formatFileSize(bytes,decimalPoint) {
	"use strict";
   if(bytes == 0) return '0 Bytes';
   var k = 1000,
       dm = decimalPoint || 2,
       sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
       i = Math.floor(Math.log(bytes) / Math.log(k));
   return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}
	
 /* Attachments*/	
	$(document.body).on('change', '#services_attachments', function (e) {
		 e.preventDefault;
		 $("#selected_attach_html_render").html('');
		 var fd_attach = new FormData();
		 var files_dataa = $('#services_attachments');
		 var listing_id = $(this).attr('data-property-id');
		 	$.each($(files_dataa), function(i, obj) {
            $.each(obj.files,function(j,file){
                fd_attach.append('files[' + j + ']', file);
            })
        });
		var total_file=document.getElementById("services_attachments").files.length;
		for(var i=0;i<total_file;i++)
		{
			var ext = e.target.files[i]['name'].split('.').pop().toLowerCase();
			$(".temp_attachemts_data").append('<div class="uploading-attachments temp-atatchment"><img src='+get_strings.t_path+'/libs/images/icons/'+ext+'.svg'+'><i class="fas fa-spinner fa-spin"></i> <span class="attachment-data"> <h4> '+e.target.files[i]['name']+'</h4> <p>'+formatFileSize(e.target.files[i]['size'])+'</p>  </span></div>');
		}
		fd_attach.append('property_id', listing_id);	
		fd_attach.append('action', 'prop_gallery_attachments');
		$.ajax({
                url: form_strings.ajax_url,
                type: 'POST',
                contentType: false,
                processData: false,
                data: fd_attach,
                success: function (response)
				{
                    if (true === response.success) {
						$(".temp_attachemts_data").html('');
						$("#selected_attach_html_render").html(response.data.referral_data);
						$("#selected_attach_idz").val(response.data.selected_attachments);
					}
					else {
						$(".temp_attachemts_data").html('');
						 notify('error', get_strings.whoops, response.data.message); 
					}
                }
            });
		
		
	});
	
	$(document).on('click', '.custom-gallery-del', function(e){
		var attachment_id = $(e.target).children('img').attr('id');
		var property_id = $(e.target).children('img').attr("data-property-id");



		e.preventDefault();
		$.confirm({
			title: form_strings.conf,
			icon: 'fa fa-question',
			theme: 'material',
			closeIcon: true,
			type: 'orange',
			animation: 'scale',
			content: form_strings.content,
			buttons: {
				'confirm': {
						text: form_strings.ok,
						action: function () { 
							$.post(form_strings.ajax_url,{action : 'prop_delete_selected_gallery_attachment', attachment_id:attachment_id, property_id:property_id}).done( function(response) 
							{
							if (true === response.success) {
								$("#"+attachment_id).remove();
								// $("#selected_imgz_idz").val(response.data.selected_attachments);
							}
							else {
								  notify('info', get_strings.whoops, response.data.message);
							}
						});
						}
				},
				cancle: {
						text: form_strings.cancle,
					},
			}
		});
	});
	/*For Attachments*/
	$(document.body).on('click', '.btn-pro-clsoe-icon', function(e){
		e.preventDefault();
		var attachment_id = $(this).attr("data-id");
		var property_id = $(this).attr("data-property-id");
		$.confirm({
			title: form_strings.conf,
			icon: 'fa fa-question',
			theme: 'material',
			closeIcon: true,
			type: 'orange',
			animation: 'scale',
			content: form_strings.content,
			buttons: {
				'confirm': {
						text: form_strings.ok,
						action: function () { 
						$.post(form_strings.ajax_url,{action : 'prop_delete_selected_attachment', attachment_id:attachment_id, property_id:property_id}).done( function(response) 
						{
							if (true === response.success) {
								$("#"+attachment_id).remove();
								$("#selected_attach_idz").val(response.data.selected_attachments);
							}
							else {
								  notify('info', get_strings.whoops, response.data.message);
							}
						});
							
						}
				},
				cancle: {
						text: form_strings.cancle,
					},
			}
		});
	});
	
	
});
			
	})(jQuery);
	
	
	function add_fields()
	{
		"use strict";
		 var fieldno;
		 fieldno =jQuery("#generate_fields .ad-fields").length;
		 fieldno  = fieldno+1;
		 jQuery("#generate_fields").append('<div class="ad-fields" id=adf'+fieldno+'> <div class="row"> <div class="col-xxl-5 col-xl-5 col-lg-4 col-md-6 col-sm-12"> <div class="theme-row"> <label for="name">'+form_strings.f_title+'</label> <span class="wrap"> <input type="text" name="additiona-fields-title[]" value="" class="form-control text"/> </span> </div></div><div class="col-xxl-5 col-xl-5 col-lg-4 col-md-6 col-sm-12"> <div class="theme-row"> <label for="name">'+form_strings.f_value+'</label> <span class="wrap"> <input type="text" name="additiona-fields-value[]" value="" class="form-control text"/> </span> </div></div><div class="col-xl-2 col-xxl-2 col-lg-4 col-md-6 col-sm-12 text-right"><button type="button" class="square-btn mt-5 shuffle-fields info-z"><i class="fas fa-arrows-alt"></i></button> <button type="button" class="square-btn mt-5 info-d" onclick=delete_field_row("adf'+fieldno+'")><i class="fas fa-times"></i></button></div></div></div>');
	}
	function delete_field_row(fieldno)
	{
		"use strict";
		jQuery('#'+fieldno).remove();
	}
	//floor plans
	function add_row()
	{
		"use strict";
		 var rowno;
		 rowno = jQuery("#f_plans .flor-plans").length;
		 rowno = rowno+1;
		 jQuery("#f_plans").append('<div class="flor-plans" id="row'+rowno+'"><div class="row"><div class="col-xl-12"> <div class="theme-row"> <label>'+form_strings.fp_title+'</label> <span class="wrap"> <input type="text" placeholder="'+form_strings.fp_place+'" class="form-control" name="flr-name[]"> </span> </div> </div> <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12"> <div class="theme-row"> <label>'+form_strings.fp_price+'</label> <span class="wrap"> <input type="text" placeholder="'+form_strings.fp_price_place+'" class="form-control" name="flr-price[]"> </span> </div> </div> <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12"> <div class="theme-row"> <label>'+form_strings.fp_price_prefix+'</label> <span class="wrap"> <input type="text" placeholder="'+form_strings.fp_price_prefix_place+'" class="form-control" name="flr-price-postfix[]"></span></div></div><div class="col-xl-6 col-lg-6 col-md-6 col-sm-12"> <div class="theme-row"> <label>'+form_strings.fp_floorsize+'</label> <span class="wrap"> <input placeholder="'+form_strings.fp_floorsize_place+'" type="text" class="form-control" name="flr-size[]"> </span> </div> </div> <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12"> <div class="theme-row"> <label>'+form_strings.fp_floorsize_postfix+'</label> <span class="wrap"> <input type="text" placeholder="'+form_strings.fp_floorsize_postfix_place+'" class="form-control" name="flr-size-postfix[]"> </span> </div> </div> <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12"> <div class="theme-row"> <label>'+form_strings.fp_bed+'</label> <span class="wrap"> <input type="text" placeholder="'+form_strings.fp_fp_bed_place+'" class="form-control" name="flr-beds[]"> </span> </div> </div> <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12"> <div class="theme-row"> <label>'+form_strings.fp_bath+'</label> <span class="wrap"> <input type="text" placeholder="'+form_strings.fp_bath_place+'" class="form-control" name="flr-baths[]"> </span> </div> </div> <div class="col-xl-12"> <div class="theme-row"> <label>'+form_strings.fp_desc+'</label> <span class="wrap"> <textarea class="form-control cols="30" rows="4" name="flr-desc[]"></textarea> </span> </div> </div> <div class="col-xl-12"> <div class="theme-row my-floor-plans"> <label>'+form_strings.fp_img+'</label><div class="floor-plan-avatar-upload"><div class="floor-plan-avatar-edit"><input type="file" id="active_imgid_'+rowno+'"  class="floorplan_btn_click" accept=".png, .jpg, .jpeg" data-activeplan="'+rowno+'" /><label for="active_imgid_'+rowno+'" data-toggle="tooltip" data-original-title="'+form_strings.select_plan_img+'" ></label><input type="hidden" id="flor_uploaded_'+rowno+'" name="floorplan_image_id[]" value=""></div><div class="avatar-preview"><div class="florplan-temp-loader florplan-pre-'+rowno+' none"><i class="fas fa-spinner fa-spin"></i></div><div><img id="plan_image_src_'+rowno+'" src="" class="img-fluid" alt=""></div><span class="flr-plb-btn-cncle show_del_plan_'+rowno+' flp-del" data-delflr-id="" data-imgplan="'+rowno+'" data-toggle="tooltip" data-original-title="'+form_strings.fp_delete+'"><i class="fa fa-times"></i></span></div></div></div><input type="button" class="add-more-fields btn-remove info-d" value="'+form_strings.fp_delete+'" onclick=delete_row("row'+rowno+'")></div></div></div>');
		 jQuery('[data-toggle="tooltip"]').tooltip();
	}
	function delete_row(rowno)
	{
		"use strict";
		jQuery('#'+rowno).remove();
	}
}

