(function($) {
    "use strict";	
	

    
var rtl_mode;
if($('input[name=is_rtl]').val() == 1)
{
    rtl_mode = true;
} else
{
    rtl_mode = false;
}   
    

$(".toggle-password").on('click', function (e) {
		e.preventDefault();	
		$(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("data-toggle"));
  if (input.attr("type") === "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});	
	

 $('[data-toggle="popover"]').popover(); 
 
 if($('.txt-dec').length > 0){
	$("a.txt-dec").YouTubePopUp( { autoplay: 0 } );
  }

if($('.ab1').length > 0){
$('.ab1').countUp({
            time: 1500,
        });
}
if($('.ag-counter').length > 0){
$('.ag-counter').countUp({
            time: 1500,
        });
}
 if($('.cl-class').length > 0){
	$(document).ready(function(){
		$(".menu-des a.cl-class").on('click', function (e) {
		e.preventDefault();	
		$( "a.cl-class" ).removeClass('acmenu-pro-6');	
		  $(this).addClass('acmenu-pro-6');
			event.preventDefault();
			$("html, body").animate({ scrollTop: $($(this).attr("href")).offset().top-100 }, 1200);
		});
	});
}
 

if ($('.featured-slider-prop').length)
{
	$('.featured-slider-prop').owlCarousel({
		dots: false,
		nav: true,
		rtl: rtl_mode,
		navText: ["<i class='fas fa-angle-left'></i>", "<i class='fas fa-angle-right'></i>"],
		animateOut: 'fadeOut',
		animateIn: 'fadeIn',
		items: 1,
	});
}

if ($('.full-width-testimonials').length)
{
	$('.full-width-testimonials').owlCarousel({
		dots: false,
		nav: true,
		rtl: rtl_mode,
		navText: ["<i class='fas fa-angle-left'></i>", "<i class='fas fa-angle-right'></i>"],
		items: 1,
	});
}
if ($(".custom-fields-theme-selects").length > 0) {
	$('.custom-fields-theme-selects').select2({width: '100%', theme: "classic"});
}


/*  Team-Slider-Owl-carousel  */
if($('.prop-types-carsol').length){
        $('.prop-types-carsol').owlCarousel({
			dots: false,
            loop:true,
            margin:30,
            nav:true,
            rtl: rtl_mode,
			smartSpeed:1200,
            navText: ["<i class='fas fa-angle-left'></i>", "<i class='fas fa-angle-right'></i>"],
            responsive: {
                0: {
                    items: 1,
                    center: false
                },
                480:{
                    items:1,
                    center: false
                },
                520:{
                    items:2,
                    center: false
                },
                600: {
                    items: 2,
                    center: false
                },
                768: {
                    items: 2
                },
                992: {
                    items: 3
                },
                1200: {
                    items: 4
                }
            }
        });
 }

$( window ).on( 'elementor/frontend/init', function() {
    elementorFrontend.hooks.addAction( 'frontend/element_ready/testimonial-one.default', function($scope, $){
       if ($('.full-width-testimonials').length)
		{
			$('.full-width-testimonials').owlCarousel({
				dots: false,
				nav: true,
				rtl: rtl_mode,
				navText: ["<i class='fas fa-angle-left'></i>", "<i class='fas fa-angle-right'></i>"],
				items: 1,
			});
		}
    });
 });



if($('.social-ads').length > 0){
$('.social-ads').owlCarousel({
    loop:true,
	autoplay:true,
	dots:false,
	autoplayTimeout:3000,
	smartSpeed:1200,
    nav:false,
    rtl: rtl_mode,
			animateOut: 'fadeOut',
			animateIn: 'fadeIn',
    responsive:{
        0:{
            items:1,
        },
        500:{
            items:3,
        },
		800:{
            items:4,
        },
        1200:{
            items:6,
        }
    }
});
}

if($('.testimonial-classic').length > 0){
$('.testimonial-classic').owlCarousel({
					loop:true,
					autoplay:true,
					dots:false,
					autoplayTimeout:5000,
					smartSpeed:1200,
					autoplayHoverPause:true,
					nav:false,
    rtl: rtl_mode,
					responsive:{
						0:{
							items:1,
						},
						500:{
							items:1,
						},
						800:{
							items:3,
						},
						1200:{
							items:3,
						}
					}
				});
				}


$( window ).on( 'elementor/frontend/init', function() {
    elementorFrontend.hooks.addAction( 'frontend/element_ready/partners-all.default', function($scope, $){
       if($('.social-ads').length > 0){
$('.social-ads').owlCarousel({
    loop:true,
	autoplay:true,
	dots:false,
	autoplayTimeout:3000,
	smartSpeed:1200,
    nav:false,
    rtl: rtl_mode,
			animateOut: 'fadeOut',
			animateIn: 'fadeIn',
    responsive:{
        0:{
            items:1,
        },
        500:{
            items:3,
        },
		800:{
            items:4,
        },
        1200:{
            items:6,
        }
    }
});
}
    });
 });


	

	
	if($('.floor-plan').length > 0){

$('.floor-plan li').first().addClass('open');
	$('.floor-plan li .floor-plan-content').first().css('display','block').slideDown(400);
    $('.floor-plan-title').on('click', function(event) {
        event.preventDefault();
        if ($(this).parents('li').hasClass('open')) {
            $(this).parents('li').removeClass('open').find('.floor-plan-content').slideUp(400);
        } else {
            $(this).parents('.floor-plan').find('.floor-plan-content').not($(this).parents('li').find('.floor-plan-content')).slideUp(400);
            $(this).parents('.floor-plan').find('> li').not($(this).parents('li')).removeClass('open');
            $(this).parents('li').addClass('open').find('.floor-plan-content').slideDown(400);
        }
    });
}


if ($('.myflex').is('.flexslider'))
{
	$('.flexslider').flexslider({
			animation: "slide",
			controlNav: "thumbnails",
            rtl: rtl_mode,
            
	});
}

 $('.show-on-click').on('click', function () {
    $('.auth-dropdown').css('display', 'block');
});			
$(document).mouseup(function (e){
	var drop_counter = $(".auth-dropdown");
	if (!drop_counter.is(e.target) && drop_counter.has(e.target).length === 0){
		drop_counter.fadeOut();
	}
}); 

	if ($(".preloader-site").length) {  
		$(window).on('load', function() {
			$('.preloader-site').fadeOut();
		});
	}
	
	   $(window).on('scroll', function () {
            if ($(this).scrollTop() > 300) {
                $('.scroll-top').fadeIn(300);
            } else {
                $('.scroll-top').fadeOut(300);
            }
        });
        $('.scroll-top').on('click', function (event) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: 0
            }, 1000);
        });
		
		
		
		$("input[name$='assign-listing']").on('click', function (event) {
			  var selected_radio = $(this).val();
			  if(selected_radio == 1)
			  {
				 $(".sel-agent").removeClass('none');
				 $(".just-agent").attr('data-validation','required');
			  }
			  else
			  {
				  $(".just-agent").attr('data-validation',''); 
			  }
		});
	
	
	
	 $('[data-toggle="tooltip"]').tooltip();
	
	$('.check_featured').on('change', function(){
		var featp = parseFloat($(this).attr("data-featp"));
		var sfee = parseFloat($('input:hidden[name=submission_fee]').val());
		this.value = this.checked ? 1 : 0;
		$('input[name=is_featuredz]').val(this.value);
		
		if( $(this).is(':checked') ) {
			var total = featp + sfee;
			$(".atcive-pric").html(total);
		}
		else
		{
			$(".atcive-pric").html(sfee);
		}
	});
    
    if($('input[name=is_rtl]').val() == 1)
    {
        var $container = $('.grid');
        $container.imagesLoaded(function(){
          $container.masonry({
            itemSelector : '.grid-item',
            percentPosition: true,
            layoutMode: 'masonry',
            transitionDuration: '0.7s',
            isOriginLeft : false,
          });
        });
    }
    else
    {
        var $container = $('.grid');
        $container.imagesLoaded(function(){
          $container.masonry({
            itemSelector : '.grid-item',
            percentPosition: true,
            layoutMode: 'masonry',
            transitionDuration: '0.7s',
          });
        });
    }
	
$('.theme-selects').select2({
	 width:'100%',
	 theme: "classic",
});
    

$('.wp-block-archives-dropdown select, .wp-block-categories select, .blog-sidebar .widget select, .woocommerce-ordering .orderby').select2({
	 width:'100%',
	 theme: "classic",
});


$('.sort-selects').select2({
	 width:'100%',
	 theme: "classic",
	 minimumResultsForSearch: -1
});

$('.theme-selects-group').select2({
	 width:'50%',
	 theme: "classic"
});

$('.search-selects').select2({
	 width:'100%',
	 theme: "classic",
	 allowClear: true
});

$('.woocommerce .propertya-shop-detail select').select2({
     
	 width:'100%',
	 theme: "classic",
    placeholder: 'Select an option'
});
    

// Expending/Collapsing advance search content
    $(document).on('click', '.show-additional-features', function () {
        if ($(this).find('.far').hasClass('fa-minus-circle')) {
            $(this).find('.far').removeClass('fa-minus-circle');
            $(this).find('.far').addClass('fa-plus-circle');
        } else {
            $(this).find('.far').removeClass('fa-plus-circle');
            $(this).find('.far').addClass('fa-minus-circle');
        }
    });



$('.prop-datepicker').datepicker({
	language: {
	days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
daysMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
months: ['January','February','March','April','May','June', 'July','August','September','October','November','December'],
monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
today: 'Today',
clear: 'Clear',
	},
	timepicker: false
});
	

	
	$('.sidebar').on('show.bs.collapse', '.collapse', function() {
      $('.sidebar').find('.collapse.show').collapse('hide');
    });
	
	$('[data-toggle="minimize"]').on("click", function() {
      $('body').toggleClass('sidebar-icon-only');
    });
	
	$('[data-toggle="offcanvas"]').on("click", function() {
      $('.sidebar-offcanvas').toggleClass('active')
    });
	

	
	if(typeof(get_strings) !== 'undefined' && get_strings !== null)
	{
		//custom field
		$('.get_custom_field').on('change', function () {
			$('.prop1 ').buttonLoader('start');	
				var cat_parent = $(this).val();

			$.post(get_strings.ajax_url, {action: 'prop_get_custom', cat_parent: cat_parent}).done(function (response) {
				$('.prop1').buttonLoader('stop');

				if (true === response.success) {
					$('.mx-custom-fields').css("display", "block");
					$('#dynamic-custom-fields').html(response.data.fields);
					if ($(".custom-fields-theme-selects").length > 0) {
						$('.custom-fields-theme-selects').select2({width: '100%', theme: "classic"});
					}
					if ($(".custom-range-slider").length > 0) {
						$(".custom-range-slider").ionRangeSlider({skin: "round"});
					}
				} else {
					$('.mx-custom-fields').buttonLoader("stop");
					$('.mx-custom-fields').css("display", "none");
				}
			});
		});

        
        if ($('.click-reveal').is('.phonenumber'))
        {	 
            $(document).ready(function() {
                var phonenumbers = [];
                $(".phonenumber").each(function(i) {
                    var text_string = get_strings.click_reveal;
                    var hashes = '***** ';
                    phonenumbers.push($(this).text());
                    var newcontent = $(this).text().substr(0, $(this).text().length - 4)  + hashes + text_string;
                    $(this).text(newcontent);
                    $(this).bind("click", function() {
                    if ($(this).text() == phonenumbers[i]) {
                        $(this).text(phonenumbers[i].substr(0, phonenumbers[i].length - 4) + hashes + text_string);
                    } else {
                    $(".phonenumber").each(function(x) {
                        if ($(this).text() == phonenumbers[x]) {
                           $(this).text(phonenumbers[x].substr(0, phonenumbers[x].length - 4)+ hashes + text_string);
                        }
                    });            
                    $(this).text(phonenumbers[i]);
                    }
                 });
                });
            });
        }
        
        var myinput = document.querySelector("#myphone");
        if(typeof(myinput) !== 'undefined' && myinput !== null)
	    {
           
           if(typeof(get_strings.all_numbers) !== 'undefined' && get_strings.all_numbers !== '')
           {
                window.intlTelInput(myinput, {
                    onlyCountries: [get_strings.all_numbers],
                    utilsScript: get_strings.t_path+"/libs/js/utils.js",
                });
           }
           else
           {
                window.intlTelInput(myinput, {
                    utilsScript: get_strings.t_path+"/libs/js/utils.js",
                });
           }
       }
     
		if ($('.my_distance_slider').length > 0)
		{
			$('.my_distance_slider').nstSlider({
				  "left_grip_selector": ".leftGrip",
				  "value_changed_callback": function (cause, leftValue) {
					$(this).parent().find('.leftLabel').text(leftValue);
					$('input[name="distance"]').val(leftValue);
				  }
			});
		}
		$(document.body).on('click', '.get-my-location', function(e){
				e.preventDefault();
				var button = $(this);
				button.find('i').addClass('fas fa-spin fa-spinner clr-white');
				button.attr("disabled", true);
				if ("geolocation" in navigator)
				{ 
					navigator.geolocation.getCurrentPosition(get_desired_location, show_error_codes, {enableHighAccuracy: true}); 
				}
				else{
					notify('info', get_strings.whoops, get_strings.geolocation);
					
				}
				return false;
			});	
		function get_desired_location(position)
		{
				$('.get-my-location').find('i').removeClass('fas fa-spin fa-spinner clr-white');
				$('.get-my-location').find('i').addClass('fas fa-location-arrow');
				$('input[name="latt"]').val(position.coords.latitude);
				$('input[name="long"]').val(position.coords.longitude);
				$('.radius-dropdown').slideDown('slow');
		}		
		function show_error_codes(error){
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
			$('.get-my-location').find('i').removeClass('fas fa-spin fa-spinner clr-white');
			$('.get-my-location').find('i').addClass('fas fa-location-arrow');
		}
		
		
		if(get_strings.authorization !="" && get_strings.authorization == 1)
		{
			notify('error', get_strings.whoops,get_strings.auth_warning);
		}
		
		if(get_strings.is_reset !="" && get_strings.is_reset == 1)
		{
			if(get_strings.reset_status.status == false)
			{
				notify('error', get_strings.whoops,get_strings.reset_status.r_msg);
			}
			else
			{
				notify('success', get_strings.congratulations,get_strings.reset_status.r_msg);
				$('input[name=requested_user_id]').val(get_strings.reset_status.requested_id);
				$('#mynewpass').modal('show'); 
			}
		}
		if(get_strings.dont_have_role !="" && get_strings.dont_have_role == 1)
		{
			$('#check_userrole').modal({backdrop: 'static', keyboard: false}); 
		}
		
		
		$('#asd').on('click', function(){
		$.post(get_strings.ajax_url,{action : 'prop_user_payments_paypal', collect_data:$( "form[name='paypal_form']").serialize()}).done( function(response) 
		{
			window.location.href = response;
			//alert(response);
		});
	});
		
		


$(document).on("change",".uploadFile", function()
    {
    	var uploadFile = $(this);
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
		if (files && files[0])
		{
			var file_cover = files[0];
			var form_data = new FormData();
			form_data.append('file', file_cover);
			form_data.append('action', 'prop_myfeatured_cover');
			$('input[name="mycover-img"]').prop('disabled', true);
			$('.my-cov-img').html('');
			$(".overlay-cover").show();
			$.ajax({
                url: get_strings.ajax_url,
                type: 'POST',
                contentType: false,
                processData: false,
                data: form_data,
                success: function (response)
				{
                    if (true === response.success) {
						$(".overlay-cover").hide();
						$('input[name="mycover-img"]').prop('disabled', false);
						notify('success', get_strings.congratulations, response.data.message);
						uploadFile.closest(".imgUp").find('.imagePreview').css({'background-image' : "url("+response.data.img_link+")",'background-size' : 'cover'});
					}
					else {
                         $(".overlay-cover").hide();
						 notify('error', get_strings.whoops, response.data.message); 
					}
                }
            });
		}
    });
	
/* My Featured Img */
function my_featured_img_readURL(input) {
    if (input.files && input.files[0])
	{
		var file_data = input.files[0];
		var form_data = new FormData();
		form_data.append('file', file_data);
		form_data.append('action', 'prop_myfeatured_img');
		$.ajax({
                url: get_strings.ajax_url,
                type: 'POST',
                contentType: false,
                processData: false,
                data: form_data,
                success: function (response)
				{
                    if (true === response.success) {
						$('.my-user-profile img, .nav-link img').attr('src', response.data.img_link);
                        notify('success', get_strings.congratulations, response.data.message);
					}
					else {
						 notify('error', get_strings.whoops, response.data.message); 
					}
                }
            });
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

	$(document.body).on('click', '.fav-prop', function(e){
		e.preventDefault();
		var button = $(this);
	    button.find('i').addClass('fas fa-spin fa-spinner');
		button.attr("disabled", true);
		var fav_listing = $(this).data("fav-id");
		$.post(get_strings.ajax_url,{action : 'prop_listing_bookmarks',fav_listing: fav_listing,security:get_strings.ajax_nonce}).done(function(response) 
		{
			 button.find('i').removeClass('fas fa-spin fa-spinner');
			 button.find('i').addClass('far fa-heart');
			 button.attr("disabled", false);
			 if ( true === response.success )
			 {
				 notify('success', get_strings.congratulations, response.data.message);
			 }
			 else{

			 	
			notify('error', get_strings.whoops, response.data.message);
			if(typeof(response.data.url) !== 'undefined' && response.data.url !== null )
			  {
				setTimeout(() => window.location.href = response.data.url, 2000);
			  }
			}
		});
		return false;
	});
        
        
$(document.body).on('click', '.fav-comp', function(e){
		e.preventDefault();
		var button = $(this);
	    button.find('i').addClass('fas fa-spin fa-spinner');
		button.attr("disabled", true);
		var compare_listing = $(this).data("compare-id");
		$.post(get_strings.ajax_url,{action : 'prop_listing_compare',compare_listing: compare_listing,security:get_strings.ajax_nonce}).done(function(response) 
		{
			 button.find('i').removeClass('fas fa-spin fa-spinner');
			 button.find('i').addClass('fas fa-random');
			 button.attr("disabled", false);
			 if ( true === response.success )
			 {
                 $("#compare-toolbox").addClass('toolbox-open');
				$(".dynamic_compare").html(response.data.compare_list);
			 }
			 else{
				$(".dynamic_compare").html(response.data.custom_msg);
			 }
		});
		return false;
});
        
        $(document.body).on('click', '.remove_compare_list', function(e){
            e.preventDefault();
            var button = $(this);
            button.find('i').removeClass('fas fa-times');
            button.find('i').addClass('fas fa-spin fa-spinner');
		    button.attr("disabled", true);
            var compare_listing = $(this).data("property-id");
            $.post(get_strings.ajax_url,{action : 'prop_listing_compare',compare_listing: compare_listing,security:get_strings.ajax_nonce}).done(function(response) 
            {
                 button.find('i').removeClass('fas fa-spin fa-spinner');
                 button.find('i').addClass('fas fa-times');
                 button.attr("disabled", false);
                 if ( true === response.success )
                 {
                     $("#compare-toolbox").addClass('toolbox-open');
                    $(".dynamic_compare").html(response.data.compare_list);
                 }
                 else{
				    $(".dynamic_compare").html(response.data.custom_msg);
                 }
            });
            return false;
        });

      // Toggles Theme Settings Tray
      $('#compare-toolbox .panel-heading').on('click', function() {
        $('#compare-toolbox').toggleClass('toolbox-open');
      });
      
        
     $(document.body).on('click', '.clear-all-compare', function(e){
        e.preventDefault();
        $.post(get_strings.ajax_url,{action : 'prop_listing_compare_clear'}).done(function(response) 
        {
            if ( true === response.success )
			 {
				$(".dynamic_compare").html(response.data.compare_list);
			 }
        });
     });


	

	$(document.body).on('click', '.track-reaction', function(e){
		  e.preventDefault();
		  var reaction_id = $(this).data("reaction");
          var c_id = $(this).data("cid");
		  var listing_id = $(this).data("listingid");
		  $(".reaction-loader-" + c_id).show();
		  $.post(get_strings.ajax_url,{action : 'prop_listing_reactions',r_id: reaction_id,c_id:c_id,security:get_strings.ajax_nonce,listing_id:listing_id}).done(function(response) 
		 {
			 $(".reaction-loader-" + c_id).hide();
			 if ( true === response.success )
			 {
				 $('.reaction-count-'+c_id+'-'+reaction_id).html('('+response.data.totalcount+')');
			 }
			 else{
				notify('error', get_strings.whoops, response.data.message); 
			 }
		 });
		 return false;
	});	

	
	
	$(document).on("change","#imageUpload", function()
    {
    	 my_featured_img_readURL(this);
    });	
		
	$(document.body).on("click",".fetch_dynamic_results", function()
	{
		var find_button = $(this);
		var data_div = $(this).parent().parent().find(".dynamic_loading");
		var button_div = $(this).parent().parent().find(".fetch-more-records");
		var page = parseInt($(this).attr("data-page"))+1;
		var record_limit = $(this).attr("data-limit");
		var listingtype = $(this).attr("data-listingtype");
		var orderby = $(this).attr("data-orderby");
		var layouttype = $(this).attr("data-layouttype");
		var typestatus = $(this).attr("data-typestatus");
		var location_id = $(this).attr("data-locationid");
		var category = $(this).attr("data-category");
		var max_pages = $(this).attr("data-maxpages");
		var col_type = $(this).attr("data-coltype");
		find_button.buttonLoader('start');
		find_button.attr("disabled", true);
		$.post(get_strings.ajax_url, {action: 'prop_loadmore_listings', page_no: page,limit:record_limit,type:listingtype,order:orderby,layout:layouttype,typestatus:typestatus,location_id:location_id,col_type:col_type,cats:category}).done(function (response)
        {
			find_button.buttonLoader('stop');
			find_button.attr("disabled", false);
			if (true === response.success) 
			{
				find_button.attr('data-page',page);
				data_div.append(response.data.listings);
				if (page == parseInt(max_pages))
				{
					button_div.remove();
				}
			}
			else
			{
				find_button.buttonLoader('stop');
			    find_button.attr("disabled", false);
			}
			
		});
	});
        
    /* Delete My Favourites */
	$(document.body).on('click', '.prop-woo-packs', function(e){
		e.preventDefault();
		 var package_id = $(this).attr("data-product-id");
         var qunatity = $(this).attr('data-product-qty');
         var pack_ref = $(this).attr('data-package-type');
         $(this).buttonLoader('start');
         $(this).attr("disabled", true);
         $.post(get_strings.ajax_url, {action: 'prop_package_cart', package_id: package_id,qunatity:qunatity,pack_ref:pack_ref,security:get_strings.ajax_nonce}).done(function (response)
         {
			$('.sonu-button-' +package_id+'').buttonLoader('stop');
			$('.sonu-button-' +package_id+'').attr("disabled", false);
			if (true === response.success) 
			{
                notify('success', get_strings.congratulations, response.data.message);
                window.location	=	response.data.referral;
			}
			else
			{
                notify('error', get_strings.whoops, response.data.message); 
			}
		});
        return false; 
	});

	$(document.body).on("click",".fetch_dynamic_agencies", function(e)
	{
		e.preventDefault();
		var pageag = parseInt($(this).attr("data-page"))+1;
		var record_limit = $(this).attr("data-limit");
		var listingtype = $(this).attr("data-listingtype");
		var orderby = $(this).attr("data-orderby");
		var layouttype = $(this).attr("data-layouttype");
		var category = $(this).attr("data-category");
		var max_pages = $(this).attr("data-maxpages");
		$('.agency-btnload').buttonLoader('start');
		$(".agency-btnload").attr("disabled", true);
		$.post(get_strings.ajax_url, {action: 'prop_loadmore_agencies', page_no: pageag,limit:record_limit,type:listingtype,order:orderby,layout:layouttype,cats:category}).done(function (response)
        {
			$('.agency-btnload').buttonLoader('stop');
			$(".agency-btnload").attr("disabled", false);
			if (true === response.success) 
			{
				$('.fetch_dynamic_agencies').attr('data-page',pageag);
				$(".dynamic_loading_agencies").append(response.data.listings);
				if (pageag == parseInt(max_pages))
				{
					
					$(".fetch-more-records").hide();
				}
				reloadMasonry();
			}
			else
			{
				$(".fetch-more-records").hide();
			}
		});
		return false; 
	});

	
	//load more agents
	$(document.body).on("click",".fetch_dynamic_agents", function(e)
	{
		e.preventDefault();
		var pageag = parseInt($(this).attr("data-page"))+1;
		var record_limit = $(this).attr("data-limit");
		var listingtype = $(this).attr("data-listingtype");
		var orderby = $(this).attr("data-orderby");
		var layouttype = $(this).attr("data-layouttype");
		var category = $(this).attr("data-category");
		var max_pages = $(this).attr("data-maxpages");
		$('.agent-btnload').buttonLoader('start');
		$(".agent-btnload").attr("disabled", true);
		$.post(get_strings.ajax_url, {action: 'prop_loadmore_agents', page_no: pageag,limit:record_limit,type:listingtype,order:orderby,layout:layouttype,cats:category}).done(function (response)
        {
			$('.agents-btnload').buttonLoader('stop');
			$(".agents-btnload").attr("disabled", false);
			if (true === response.success) 
			{
				$('.fetch_dynamic_agents').attr('data-page',pageag);
				$(".dynamic_loading_agents").append(response.data.listings);
				if (pageag == parseInt(max_pages))
				{
					
					$(".fetch-more-records").hide();
				}
				reloadMasonry();
			}
			else
			{
				$(".fetch-more-records").hide();
			}
		});
		return false; 
	});
	
	/* Delete My Favourites */
	$(document.body).on('click', '.delete-my-favourites', function(e){
		e.preventDefault();
		 var property_id = $(this).attr("data-property-id");
		 $.confirm({
				title: get_strings.conf,
				theme: 'material',
				animation: 'scale',
				content: get_strings.content,
				closeAnimation: 'scale',
				closeIcon: true,
				type: 'blue',
				buttons: {
					'confirm': {
						text: get_strings.ok, 
						action: function () {
							$.post(get_strings.ajax_url,	{action : 'remove_my_favourites', property_id:property_id,security:get_strings.ajax_nonce}).done( function(response) 
							{
								if ( true === response.success ) {
									$("#"+property_id).fadeOut("slow");
									notify('success', get_strings.congratulations, response.data.message);
								}
								else {
									notify('error', get_strings.whoops, response.data.message); 
								}
							});
						}
					},
					cancle: {
						text: get_strings.cancle,
					}
				}
			});
		 return false;			
	});
		
		
	/* Delete My Listings */
	  $('.delete-my-prop').on('click', function()
	  {
		  var property_id = $(this).attr("data-property-id")
		  $.confirm({
				title: get_strings.conf,
				theme: 'material',
				animation: 'scale',
				content: get_strings.content,
				closeAnimation: 'scale',
				closeIcon: true,
				type: 'blue',
				buttons: {
					'confirm': {
						text: get_strings.ok, 
						action: function () {
							$.post(get_strings.ajax_url,	{action : 'remove_my_prop', property_id:property_id,}).done( function(response) 
							{
								if ( true === response.success ) {
									
									notify('success', get_strings.congratulations, response.data.message);
								}
								else {
									notify('error', get_strings.whoops, response.data.message); 
								}
							});
						}
					},
					cancle: {
						text: get_strings.cancle,
					}
				}
			});
		  return false;			
	  });
	  
	  /* Expire My Listings */
	  $('.expire-my-prop').on('click', function()
	  {
		  var property_id = $(this).attr("data-property-id");
		  $.confirm({
				title: get_strings.conf,
				theme: 'material',
				animation: 'scale',
				content: get_strings.content,
				closeAnimation: 'scale',
				closeIcon: true,
				type: 'orange',
				buttons: {
					'confirm': {
						text: get_strings.ok, 
						action: function () {
							$.post(get_strings.ajax_url,	{action : 'expire_my_prop', property_id:property_id,}).done( function(response) 
							{
								if ( true === response.success ) {
									$("#"+property_id).fadeOut("slow");
									notify('success', get_strings.congratulations, response.data.message);
								}
								else {
									notify('error', get_strings.whoops, response.data.message); 
								}
							});
						}
					},
					cancle: {
						text: get_strings.cancle,
					}
				}
			});
		  return false;			
	  });


			  /* Active Expire My Listings STARTS */ 

				$('.reactive-my-listings').on('click', function()
				{
					var property_id = $(this).attr("data-property-id");
					$.confirm({
						title: get_strings.conf,
						theme: 'material',
						animation: 'scale',
						content: get_strings.content,
						closeAnimation: 'scale',
						closeIcon: true,
						type: 'blue',
						buttons: {
							'confirm': {
								text: get_strings.ok, 
								action: function () {
									$.post(get_strings.ajax_url,	{action : 'reactive_my_listings', property_id:property_id,}).done( function(response) 
									{
										if ( true === response.success ) {
											$("#"+property_id).fadeOut("slow");
											notify('success', get_strings.congratulations, response.data.message);
										}
										else {
											notify('error', get_strings.whoops, response.data.message); 
										}
									});
								}
							},
							cancle: {
								text: get_strings.cancle,
							}
						}
					});
					return false;			
				});
				/* Active Expire My Listings Ends */
			
			
			if ($('.for_single_pages').is('.short-multi'))
			{
			var type = $("input[name='widget_type']").val();
					$('.short-multi').typeahead({
							minLength: 1,
							hint: true,
							maxItem: 15,
							order: "asc",
							dynamic: true,
							delay: 200,
							emptyTemplate: get_strings.no_r_for + "{{query}}",
							source: {
									listings: {
											href: "{{link}}",
											display: ["with_title"],
											ajax: [{type: "GET", url: get_strings.ajax_url, data: {q: '{{query}}', type:type, action: 'fetch_suggestions_widget'}}, "data.listings"],
											template: '<span class="row">' + '<span class="search-avatar">' + '<img src="{{img}}" alt="{{with_title}}" >' + "</span>" + '<span class="l-title">{{with_title}} </span>' + "</span>",
									},
							},
					});
			}



	  
	  /* Delete Submitted Reviews */
	  $('.delete-my-sub-rev').on('click', function()
	  {
		  var property_id = $(this).attr("data-property-id");
		  var comment_id = $(this).attr("data-comment-id");
		  $.confirm({
				title: get_strings.conf,
				theme: 'material',
				animation: 'scale',
				content: get_strings.content,
				closeAnimation: 'scale',
				closeIcon: true,
				type: 'orange',
				buttons: {
					'confirm': {
						text: get_strings.ok, 
						action: function () {
							$.post(get_strings.ajax_url,	{action : 'delete_my_comment', property_id:property_id,comment_id:comment_id,security:get_strings.ajax_nonce}).done( function(response) 
							{
								if ( true === response.success ) {
									$("#"+comment_id).fadeOut("slow");
									notify('success', get_strings.congratulations, response.data.message);
								}
								else {
									notify('error', get_strings.whoops, response.data.message); 
								}
							});
						}
					},
					cancle: {
						text: get_strings.cancle,
					}
				}
			});
		  return false;			
	  });
	  
	  /* Delete Submitted Profile Reviews */
	  $('.delete-my-sub-rev-profile').on('click', function()
	  {
		  var profile_id = $(this).attr("data-profile-id");
		  var comment_id = $(this).attr("data-comment-id");
		  $.confirm({
				title: get_strings.conf,
				theme: 'material',
				animation: 'scale',
				content: get_strings.content,
				closeAnimation: 'scale',
				closeIcon: true,
				type: 'orange',
				buttons: {
					'confirm': {
						text: get_strings.ok, 
						action: function () {
							$.post(get_strings.ajax_url,	{action : 'delete_my_comment', profile_id:profile_id,comment_id:comment_id,security:get_strings.ajax_nonce}).done( function(response) 
							{
								if ( true === response.success ) {
									$("#"+comment_id).fadeOut("slow");
									notify('success', get_strings.congratulations, response.data.message);
								}
								else {
									notify('error', get_strings.whoops, response.data.message); 
								}
							});
						}
					},
					cancle: {
						text: get_strings.cancle,
					}
				}
			});
		  return false;			
	  });
	  
	  	/* Delete My Agents */
	  $('.del-my-agent').on('click', function()
	  {
		  var agent_id = $(this).attr("data-agent-id");
		  $.confirm({
				title: get_strings.conf,
				theme: 'material',
				animation: 'scale',
				content: get_strings.content,
				closeAnimation: 'scale',
				closeIcon: true,
				type: 'blue',
				buttons: {
					'confirm': {
						text: get_strings.ok, 
						action: function () {
							$.post(get_strings.ajax_url,	{action : 'remove_my_agents', agent_id:agent_id,}).done( function(response) 
							{
								if ( true === response.success ) {
									$.dialog({title:get_strings.cong,theme:'material',animation:'scale',type:'green',closeIcon: true,backgroundDismiss: true,content:response.data.message});
								}
								else {
									 $.dialog({title:get_strings.whoops,theme:'material',animation:'scale',type:'red',closeIcon: true,backgroundDismiss: true,content:response.data.message});
								}
							});
						}
					},
					cancle: {
						text: get_strings.cancle,
					}
				}
			});
		  return false;			
	  });
	  
	  
  	if ($('.for_single_pages').is('.short-multi'))
    {
		var type = $("input[name='widget_type']").val();
        $('.short-multi').typeahead({
            minLength: 1,
            hint: true,
            maxItem: 15,
            order: "asc",
            dynamic: true,
            delay: 200,
            emptyTemplate: get_strings.no_r_for + "{{query}}",
            source: {
                listings: {
                    href: "{{link}}",
                    display: ["with_title"],
                    ajax: [{type: "GET", url: get_strings.ajax_url, data: {q: '{{query}}', type:type, action: 'fetch_suggestions_widget'}}, "data.listings"],
                    template: '<span class="row">' + '<span class="search-avatar">' + '<img src="{{img}}" alt="{{with_title}}" >' + "</span>" + '<span class="l-title">{{with_title}} </span>' + "</span>",
                },
            },
        });
    }
	
	if ($('.prop_get_smple').is('.is_smple'))
    {
        $('.is_smple').typeahead({
            minLength: 1,
            hint: true,
            maxItem: 15,
            order: "asc",
            dynamic: true,
            delay: 200,
            emptyTemplate: get_strings.no_r_for + "{{query}}",
            source: {
                listings: {
                    href: "{{link}}",
                    display: ["with_title"],
                    ajax: [{type: "GET", url: get_strings.ajax_url, data: {q: '{{query}}',action: 'fetch_suggestions_shortcode'}}, "data.listings"],
                    template: '<span class="row">' + '<span class="search-avatar">' + '<img src="{{img}}" alt="{{with_title}}" >' + "</span>" + '<span class="l-title">{{with_title}} </span>' + "</span>",
                },
            },
        });
    }
	
	if ($('.agent_get_smple').is('.is_ag_search'))
    {
        $('.is_ag_search').typeahead({
            minLength: 1,
            hint: true,
            maxItem: 15,
            order: "asc",
            dynamic: true,
            delay: 200,
            emptyTemplate: get_strings.no_r_for + "{{query}}",
            source: {
                listings: {
                    href: "{{link}}",
                    display: ["with_title"],
                    ajax: [{type: "GET", url: get_strings.ajax_url, data: {q: '{{query}}',action: 'fetch_suggestions_shortcode_agents'}}, "data.listings"],
                    template: '<span class="row">' + '<span class="search-avatar">' + '<img src="{{img}}" alt="{{with_title}}" >' + "</span>" + '<span class="l-title">{{with_title}} </span>' + "</span>",
                },
            },
        });
    }
	
	if ($('.agency_get_smple').is('.is_agency_search'))
    {
        $('.is_agency_search').typeahead({
            minLength: 1,
            hint: true,
            maxItem: 15,
            order: "asc",
            dynamic: true,
            delay: 200,
            emptyTemplate: get_strings.no_r_for + "{{query}}",
            source: {
                listings: {
                    href: "{{link}}",
                    display: ["with_title"],
                    ajax: [{type: "GET", url: get_strings.ajax_url, data: {q: '{{query}}',action: 'fetch_suggestions_shortcode_agency'}}, "data.listings"],
                    template: '<span class="row">' + '<span class="search-avatar">' + '<img src="{{img}}" alt="{{with_title}}" >' + "</span>" + '<span class="l-title">{{with_title}} </span>' + "</span>",
                },
            },
        });
    }

		$('#sb_sort_images').on('click', function ()
		{
			$('.sonu-button').buttonLoader('start');
			$.post(get_strings.ajax_url,{action : 'sb_sort_images', ids: $('#selected_imgz_idz').val(), ad_id: $('#current_pid').val(), }).done(function (response)
			{   if (true === response.success) {
				notify('success', get_strings.congratulations, response.data.message);
				window.location.reload(true);
			}
			else {
				notify('error', get_strings.whoops, response.data.message);
			}
			});
		});
	  
	  if($('.prop_get_propz ').is('.for_dash'))
	  {
			$('.prop_get_propz').typeahead({
				minLength: 1,
				hint: true,
				maxItem: 15,
				order: "asc",
				dynamic: true,
				delay: 200,
				emptyTemplate: get_strings.no_r_for + "{{query}}",
				source: {
					listings: {
						display: ["with_title"],
						ajax: [{type: "post",url: get_strings.ajax_url,data:{ q: '{{query}}', action: 'my_propz', form:$( "form#se" ).serialize()}},"data.listings"],
						template:  '<span class="row">' +'<span class="search-avatar">' +'<img src="{{img}}" alt="{{with_title}}" >' +"</span>" +'<span class="l-title">{{with_title}} </span>'+"</span>",
					}
				},
			});
		}
		
		if($('.prop_agentz ').is('.for_dash'))
	    {
			$('.prop_agentz').typeahead({
				minLength: 1,
				hint: true,
				maxItem: 15,
				order: "asc",
				dynamic: true,
				delay: 200,
				emptyTemplate: get_strings.no_r_for + "{{query}}",
				source: {
					listings: {
						display: ["with_title"],
						ajax: [{type: "post",url: get_strings.ajax_url,data:{ q: '{{query}}', action: 'my_agentz'}},"data.listings"],
						template:  '<span class="row">' +'<span class="search-avatar my-agenz">' +'<img src="{{img}}" alt="{{with_title}}" >' +"</span>" +'<span class="l-title">{{with_title}} </span>'+"</span>",
					}
				},
			});
		}

		
		var myLanguage = {
		 	errorTitle: get_strings.submission_fail,
		};
		
		/*Dashboard Profile Review Reply */
		$(document.body).on('submit', '.profile-dashboard-review', function(e){
				e.preventDefault();
				var comment_id = $(this).attr("data-comment-id");
				$('.sonu-button-'+comment_id).buttonLoader('start');
				$(".sonu-button-"+comment_id).attr("disabled", true);	
				$.post(get_strings.ajax_url,{action : 'prop_profile_rating_reply', comment_id:comment_id, collect_data:$(this).serialize()}).done( function(response) 
				{
					$('.sonu-button-'+comment_id).buttonLoader('stop');
					$(".sonu-button-"+comment_id).attr("disabled", false);
					if (true === response.success) {
						notify('success', get_strings.congratulations, response.data.message);
						window.location.reload(true);
					}
					else {
						 notify('error', get_strings.whoops, response.data.message);
					}
				});
				
		});
		

		/*Dashboard Review Reply */
		$(document.body).on('submit', '.dashboard-review', function(e){
				e.preventDefault();
				var comment_id = $(this).attr("data-comment-id");
				$('.sonu-button-'+comment_id).buttonLoader('start');
				$(".sonu-button-"+comment_id).attr("disabled", true);	
				$.post(get_strings.ajax_url,{action : 'prop_listing_rating_reply', comment_id:comment_id, collect_data:$(this).serialize()}).done( function(response) 
				{
					$('.sonu-button-'+comment_id).buttonLoader('stop');
					$(".sonu-button-"+comment_id).attr("disabled", false);
					if (true === response.success) {
						notify('success', get_strings.congratulations, response.data.message);
						window.location.reload(true);
					}
					else {
						 notify('error', get_strings.whoops, response.data.message);
					}
				});
				
		});
		/*Dashboard Review Update */
		$(document.body).on('submit', '.prop_updatemy_reply', function(e){
			e.preventDefault();
			var comment_id = $(this).attr("data-comment-id");
			$('.sonu-button-'+comment_id).buttonLoader('start');
			$(".sonu-button-"+comment_id).attr("disabled", true);
			$.post(get_strings.ajax_url,{action : 'prop_update_submitted_reply', comment_id:comment_id, collect_data:$(this).serialize()}).done( function(response) 
				{
					$('.sonu-button-'+comment_id).buttonLoader('stop');
					$(".sonu-button-"+comment_id).attr("disabled", false);
					if (true === response.success) {
						notify('success', get_strings.congratulations, response.data.message);
						window.location.reload(true);
					}
					else {
						 notify('error', get_strings.whoops, response.data.message);
					}
				});
				
		});
		
		/*Dashboard Profile Submiited Review Update */
		$(document.body).on('submit', '.prop_updatemy_profilereply', function(e){
			e.preventDefault();
			var comment_id = $(this).attr("data-comment-id");
			$('.sonu-button-'+comment_id).buttonLoader('start');
			$(".sonu-button-"+comment_id).attr("disabled", true);
			$.post(get_strings.ajax_url,{action : 'prop_profile_update_submitted_reply', comment_id:comment_id, collect_data:$(this).serialize()}).done( function(response) 
				{
					$('.sonu-button-'+comment_id).buttonLoader('stop');
					$(".sonu-button-"+comment_id).attr("disabled", false);
					if (true === response.success) {
						notify('success', get_strings.congratulations, response.data.message);
						window.location.reload(true);
					}
					else {
						 notify('error', get_strings.whoops, response.data.message);
					}
				});
				
		});
		
		/*Sechudle a tour */
		$.validate({
				form : '#prop_schedule_tour',
				modules : 'sanitize',
				validateOnBlur : false, 
				errorMessagePosition : 'top',
				scrollToTopOnError : true, 
				language : myLanguage,
				onSuccess : function() {
				$('.sonu-button').buttonLoader('start');
				$(".sonu-button").attr("disabled", true);	
				$.post(get_strings.ajax_url,{action : 'prop_schedule_tour', collect_data:$( "form[name='schedule_tour']").serialize()}).done( function(response) 
				{
					$("#prop_schedule_tour")[0].reset();
					$('.sonu-button').buttonLoader('stop');
					$(".sonu-button").attr("disabled", false);
					if (true === response.success) {
						notify('success', get_strings.congratulations, response.data.message);
					}
					else {
						 notify('error', get_strings.whoops, response.data.message);
					}
				});
				  return false;
				}
			});	
		
		/*Single Pafe Sidebar Contact */
		$.validate({
				form : '#prop_contact_author',
				modules : 'sanitize',
				validateOnBlur : false, 
				errorMessagePosition : 'top',
				scrollToTopOnError : true, 
				language : myLanguage,
				onSuccess : function() {
				$('.sonu-button-contact').buttonLoader('start');
				$(".sonu-button-contact").attr("disabled", true);	
				$.post(get_strings.ajax_url,{action : 'prop_contact_author', collect_data:$( "form[name='contact_author']").serialize()}).done( function(response) 
				{
					
					$('.sonu-button-contact').buttonLoader('stop');
					$(".sonu-button-contact").attr("disabled", false);
					if (true === response.success) {
						$("#prop_contact_author")[0].reset();
						notify('success', get_strings.congratulations, response.data.message);
					}
					else {
						 notify('error', get_strings.whoops, response.data.message);
					}
				});
				  return false;
				}
			});	
			
			/*Single Page Sidebar Agent-User-Agency Contact */
			
		$.validate({
			    form : '#prop_singlecontact_author',
				validateOnBlur : false, 
				errorMessagePosition : 'top',
				scrollToTopOnError : true, 
				showErrorDialogs : false,
				language : myLanguage,
				onSuccess : function() {
				$('.sonu-button').buttonLoader('start');
				$(".sonu-button").attr("disabled", true);	
				$.post(get_strings.ajax_url,{action : 'prop_singlecontact_author', collect_data:$( "form[name='contact_author']").serialize()}).done( function(response) 
				{
					
					$('.sonu-button').buttonLoader('stop');
					$(".sonu-button").attr("disabled", false);
					if (true === response.success) {
						$("#prop_singlecontact_author")[0].reset();
						notify('success', get_strings.congratulations, response.data.message);
					}
					else {
						 notify('error', get_strings.whoops, response.data.message);
					}
				});
				  return false;
				}
			});	
			
		/*Listing Review */
		$.validate({
				form : '#prop_listing_rating',
				modules : 'sanitize',
				validateOnBlur : false, 
				errorMessagePosition : 'top',
				scrollToTopOnError : true, 
				language : myLanguage,
				onSuccess : function() {
				$('.review-button').buttonLoader('start');
				$(".review-button").attr("disabled", true);	
				$.post(get_strings.ajax_url,{action : 'prop_listing_rating', collect_data:$( "form[name='listing_rating']").serialize()}).done( function(response) 
				{
					$("#prop_listing_rating")[0].reset();
					$('.review-button').buttonLoader('stop');
					$(".review-button").attr("disabled", false);
					if (true === response.success) {
						notify('success', get_strings.congratulations, response.data.message);
						window.location.reload(true);
					}
					else {
						 notify('error', get_strings.whoops, response.data.message);
					}
				});
				  return false;
				}
			});
			
		/*Agency(Agent) Review */
		$.validate({
				form : '#agency_agent_rating',
				modules : 'sanitize',
				validateOnBlur : false, 
				errorMessagePosition : 'top',
				scrollToTopOnError : true, 
				language : myLanguage,
				onSuccess : function() {
				$('.review-button').buttonLoader('start');
				$(".review-button").attr("disabled", true);	
				$.post(get_strings.ajax_url,{action : 'agency_agent_rating', collect_data:$( "form[name='agency_agent_rating']").serialize()}).done( function(response) 
				{
					
					$('.review-button').buttonLoader('stop');
					$(".review-button").attr("disabled", false);
					if (true === response.success) {
						$("#agency_agent_rating")[0].reset();
						notify('success', get_strings.congratulations, response.data.message);
						window.location.reload(true);
					}
					else {
						 notify('error', get_strings.whoops, response.data.message);
					}
				});
				  return false;
				}
			});
			
		
		
		/*Agent Registration*/
		$.validate({
				form : '#agent_submission',
				modules : 'sanitize',
				validateOnBlur : false, 
				errorMessagePosition : 'top',
				scrollToTopOnError : true, 
				language : myLanguage,
				onSuccess : function() {
				$.post(get_strings.ajax_url,{action : 'prop_user_registration', collect_data:$( "form[name='agent_submission']").serialize()}).done( function(response) 
				{
					if (true === response.success) {
						notify('success', get_strings.congratulations, response.data.message);
						window.location.reload(true);
					}
					else {
						 notify('error', get_strings.whoops, response.data.message);
					}
				});
				  return false;
				}
			});
		$.validate({
				form : '#agent_listing_edit',
				modules : 'sanitize',
				validateOnBlur : false, 
				errorMessagePosition : 'top',
				scrollToTopOnError : true, 
				language : myLanguage,
				onSuccess : function() {
				$.post(get_strings.ajax_url,{action : 'prop_agent_list', collect_data:$( "form[name='agent_list']").serialize()}).done( function(response) 
				{
					if (true === response.success) {
						notify('success', get_strings.congratulations, response.data.message);
						window.location.reload(true);
					}
					else {
						 notify('error', get_strings.whoops, response.data.message);
					}
				});
				  return false;
				}
			});
			
		/*Agency Up*/	
		$.validate({
				form : '#agency_update',
				modules : 'sanitize',
				validateOnBlur : false, 
				errorMessagePosition : 'top',
				scrollToTopOnError : true, 
				language : myLanguage,
				onSuccess : function() {
				$('.sonu-button').buttonLoader('start');
				$(".sonu-button").attr("disabled", true);	
				$.post(get_strings.ajax_url,{action : 'prop_agency_update', collect_data:$( "form[name='agency_update']").serialize()}).done( function(response) 
				{
					$('.sonu-button').buttonLoader('stop');
					$(".sonu-button").attr("disabled", false);
					if (true === response.success) {
						console.log(response.data.message);
						notify('success', get_strings.congratulations, response.data.message);
						window.location.reload(true);
					}
					else {
						 notify('error', get_strings.whoops, response.data.message);
					}
				});
				  return false;
				}
			});	
			
		/*Agent Up*/	
		$.validate({
				form : '#agent_update',
				modules : 'sanitize',
				validateOnBlur : false, 
				errorMessagePosition : 'top',
				scrollToTopOnError : true, 
				language : myLanguage,
				onSuccess : function() {
				$('.sonu-button').buttonLoader('start');
				$(".sonu-button").attr("disabled", true);
				$.post(get_strings.ajax_url,{action : 'prop_agent_update', collect_data:$( "form[name='agent_update']").serialize()}).done( function(response) 
				{
					$('.sonu-button').buttonLoader('stop');
					$(".sonu-button").attr("disabled", false);
					if (true === response.success) {
						notify('success', get_strings.congratulations, response.data.message);
						window.location.reload(true);
					}
					else {
						notify('error', get_strings.whoops, response.data.message);
					}
				});
				  return false;
				}
			});
			
		/*Buyer Update*/	
		$.validate({
				form : '#buyer_update',
				modules : 'sanitize',
				validateOnBlur : false, 
				errorMessagePosition : 'top',
				scrollToTopOnError : true, 
				language : myLanguage,
				onSuccess : function() {
				$('.sonu-button').buttonLoader('start');
				$(".sonu-button").attr("disabled", true);	
				$.post(get_strings.ajax_url,{action : 'prop_buyer_update', collect_data:$( "form[name='buyer_update']").serialize()}).done( function(response) 
				{
					$('.sonu-button').buttonLoader('stop');
					$(".sonu-button").attr("disabled", false);
					if (true === response.success) {
						notify('success', get_strings.congratulations, response.data.message);
						window.location.reload(true);
					}
					else {
						notify('error', get_strings.whoops, response.data.message);
					}
				});
				  return false;
				}
			});
			/*User Registration*/
			$.validate({
				form : '#signupForm',
				modules : 'sanitize',
				validateOnBlur : false, 
				 showErrorDialogs : false, 
				language : myLanguage,
				onSuccess : function() {
				$('.sonu-button').buttonLoader('start');
				$(".sonu-button").attr("disabled", true);
				$.post(get_strings.ajax_url,{action : 'prop_user_registration', collect_data:$( "form[name='signupForm']").serialize()}).done( function(response) 
				{
					$('.sonu-button').buttonLoader('stop');
					$(".sonu-button").attr("disabled", false);
					if (true === response.success) {
						notify('success', get_strings.congratulations, response.data.message);
						window.location = response.data.page_link;
					}
					else {
						notify('error', get_strings.whoops, response.data.message);
					}
				});
				  return false;
				}
			});
			
			/*User Login*/
			$.validate({
				form : '#signinForm',
				modules : 'sanitize',
				validateOnBlur : false, 
				 showErrorDialogs : false, 
				language : myLanguage,
				onSuccess : function() {
				$('.sonu-button').buttonLoader('start');
				$(".sonu-button").attr("disabled", true);
				$.post(get_strings.ajax_url,{action : 'prop_user_login', collect_data:$( "form[name='signinForm']").serialize()}).done( function(response) 
				{
					$('.sonu-button').buttonLoader('stop');
					$(".sonu-button").attr("disabled", false);
					if (true === response.success) {
						notify('success', get_strings.congratulations, response.data.message);
						window.location = response.data.page_link;
					}
					else {
						notify('error', get_strings.whoops, response.data.message);
					}
				});
				  return false;
				}
			});
			
			/*Forgot Password*/
			$.validate({
				form : '#forgetPass',
				modules : 'sanitize',
				validateOnBlur : false, 
				showErrorDialogs : false, 
				language : myLanguage,
				onSuccess : function() {
				$('.btn-reset').buttonLoader('start');
				$(".btn-reset").attr("disabled", true);
				$.post(get_strings.ajax_url,{action : 'prop_forgot_pass', collect_data:$( "form[name='forgetPass']").serialize()}).done( function(response) 
				{
					$("#forgetPass")[0].reset();
        			
					$('.btn-reset').buttonLoader('stop');
					$(".btn-reset").attr("disabled", false);
					if (true === response.success) {
						$("#resetmypass").modal("hide");
						notify('success', get_strings.congratulations, response.data.message);
					}
					else {
						notify('error', get_strings.whoops, response.data.message);
					}
					
				});
				  return false;
				}
			});
			/*Reset My New Password */
			$.validate({
				form : '#mynewPass',
				modules : 'sanitize',
				validateOnBlur : false, 
				showErrorDialogs : false, 
				language : myLanguage,
				onSuccess : function() {
				$('.btn-reset-new').buttonLoader('start');
				$(".btn-reset-new").attr("disabled", true);
				$.post(get_strings.ajax_url,{action : 'prop_forgot_pass_new', collect_data:$( "form[name='mynewPass']").serialize()}).done( function(response) 
				{
					$("#mynewPass")[0].reset();
        			
					$('.btn-reset-new').buttonLoader('stop');
					$(".btn-reset-new").attr("disabled", false);
					if (true === response.success) {
						$("#mynewpass").modal("hide");
						notify('success', get_strings.congratulations, response.data.message);
					}
					else {
						notify('error', get_strings.whoops, response.data.message);
					}
				});
				  return false;
				}
			});
			/*User Roles Update */
			$.validate({
				form : '#myuser_type',
				modules : 'sanitize',
				validateOnBlur : false, 
				showErrorDialogs : false, 
				language : myLanguage,
				onSuccess : function() {
				$('.btn-role').buttonLoader('start');
				$(".btn-role").attr("disabled", true);
				$.post(get_strings.ajax_url,{action : 'prop_usertype_new', collect_data:$( "form[name='myuser_type']").serialize()}).done( function(response) 
				{
					$("#myuser_type")[0].reset();
        			
					$('.btn-role').buttonLoader('stop');
					$(".btn-role").attr("disabled", false);
					if (true === response.success) {
						$("#check_userrole").modal("hide");
						notify('success', get_strings.congratulations, response.data.message);
					  window.location = response.data.page_link;
					}
					else {
						notify('error', get_strings.whoops, response.data.message);
					}
				});
				  return false;
				}
			});
			/*Password update checker*/
			$.validate({
				form : '#pass_update',
				modules : 'sanitize',
				validateOnBlur : false, 
				errorMessagePosition : 'top',
				scrollToTopOnError : true, 
				language : myLanguage,
				onSuccess : function() {
				$.post(get_strings.ajax_url,{action : 'prop_mypass_up', collect_data:$( "form[name='pass_update']").serialize()}).done( function(response) 
				{
					
					if (true === response.success) {
						notify('success', get_strings.congratulations, response.data.message);
						window.location.reload(true);
					
					}
					else {
						 notify('error', get_strings.whoops, response.data.message);
					}
				});
				  return false;
				}
			});
			
			// /*Delete my prof*/
			// $.validate({
			// 	form : '#my_account_deletion',
			// 	modules : 'sanitize',
			// 	validateOnBlur : false, 
			// 	errorMessagePosition : 'top',
			// 	scrollToTopOnError : true, 
			// 	language : myLanguage,
			// 	onSuccess : function() {

			// 	//	alert();
			// 	// $.post(get_strings.ajax_url,{action : 'prop_myacc_del', collect_data:$( "form[name='my_account_deletion']").serialize()}).done( function(response) 
			// 	// {
			// 	// 	if (true === response.success) {
            //  //     notify('success', get_strings.congratulations, response.data.message);
			// 	//         window.location.reload(true);
			// 	// 	}
			// 	// 	else {
			// 	// 		  notify('error', get_strings.whoops, response.data.message);
			// 	// 	}
			// 	// });
			// 	//  return false;
			// 	// }
			//  // });
			


  /* Delete My Favourites */
	$(document.body).on('click', '.del-my-account', function(e){
		e.preventDefault();
		 
		 $.confirm({
				title: get_strings.conf,
				theme: 'material',
				animation: 'scale',
				content: get_strings.content,
				closeAnimation: 'scale',
				closeIcon: true,
				type: 'blue',
				buttons: {
					'confirm': {
						text: get_strings.ok, 
						action: function () {
							 $.post(get_strings.ajax_url,{action : 'prop_myacc_del', collect_data:$( "form[name='my_account_deletion']").serialize()}).done( function(response) 
							{
								if ( true === response.success ) {
									notify('success', get_strings.congratulations, response.data.message);
								}
								else 
								{
									notify('error', get_strings.whoops, response.data.message); 
								}
							});
							   window.setTimeout(function() {
                                    window.location = response;
                                }, 1500);
						}
					},
					cancle: {
						text: get_strings.cancle,
					}
				}
			});
		 return false;			
	});
		


			
		
		/*Checking Hello*/
		if (typeof hello != 'undefined')
		{
			if(typeof(get_strings.social_logins) !== 'undefined' && get_strings.social_logins !== null && get_strings.social_logins == 1)
			{
				$(document.body).on("click", '.btn-face', function ()
    			{
					hello.on('auth.login', function(auth)
					{
						console.log(auth);
						$('.fb-btn').buttonLoader('start');
						$(".fb-btn").attr("disabled", true);
						 hello(auth.network).api('me').then(function(r)
						 {
							 $.post(get_strings.ajax_url,{action : 'prop_user_registration_social',email:r.email,name:r.name,token:auth.access_token}).done( function(response) 
							 {
								$('.fb-btn').buttonLoader('stop');
								$(".fb-btn").attr("disabled", false);
								if (true === response.success) {
									notify('success', get_strings.congratulations, response.data.message);
									window.location = response.data.page_link;
								}
								else {
									notify('error', get_strings.whoops, response.data.message);
								}
							 });
							 // return false;
							
						 },function(e)
						 {
							$('.fb-btn').buttonLoader('stop');
							$(".fb-btn").attr("disabled", false);
							notify('error', get_strings.whoops, e.error.message);
    					 });
					});
					 return false;
				});
				
				$(document.body).on("click", '.btn-google', function ()
    			{
					hello.on('auth.login', function(auth)
					{
						//console.log(auth);
						$('.gog-btn').buttonLoader('start');
						$(".gog-btn").attr("disabled", true);
						 hello(auth.network).api('me').then(function(r)
						 {
                             var access_token = hello(auth.network).getAuthResponse().access_token;
                             var sb_network = hello(auth.network).getAuthResponse().network;
							 $.post(get_strings.ajax_url,{action : 'prop_user_registration_social',email:r.email,name:r.name,access_token:access_token,sb_network:sb_network}).done( function(response) 
							 {
							 	console.log(response);
								$('.gog-btn').buttonLoader('stop');
								$(".gog-btn").attr("disabled", false);
								if (true === response.success) {
									notify('success', get_strings.congratulations, response.data.message);
									window.location = response.data.page_link;
								}
								else {
									notify('error', get_strings.whoops, response.data.message);
								}
							 });
							 // return false;
							
						 },function(e)
						 {
							$('.gog-btn').buttonLoader('stop');
							$(".gog-btn").attr("disabled", false);
							notify('error', get_strings.whoops, e.error.message);
    					 });
					});
					 return false;
				});
				if(get_strings.fb_key !="" && get_strings.google_key =="")
				{
					hello.init({facebook: get_strings.fb_key}, 
					{
						redirect_uri: get_strings.redirect_url,
					});
				}
				else if(get_strings.google_key !="" && get_strings.fb_key =="")
				{
					hello.init({google: get_strings.google_key}, 
					{
						redirect_uri: get_strings.redirect_url,
					});
				}
				else
				{
					hello.init({facebook: get_strings.fb_key,google: get_strings.google_key,}, 
					{
						redirect_uri: get_strings.redirect_url,
					});
				}
			}
		}
		
		/*Location On Agency Agent Buyer Detail*/
		var chk_singlemapcontainer =  document.getElementById('detail_map_single');
		if (typeof(chk_singlemapcontainer) !== 'undefined' && chk_singlemapcontainer !== null && get_strings.is_map_enabled == 1)
		{
			var map_lat =  get_strings.map_latt;
			var map_long = get_strings.map_long;
			if(get_strings.map_type == 'open_street')
			{
					var single_detailmap = L.map(chk_singlemapcontainer).setView([map_lat,map_long], 13);
						L.tileLayer('//{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
						 maxZoom: 18,
					}).addTo(single_detailmap);
					var custom_icon = L.icon({
						iconUrl: get_strings.p_path+'libs/images/map-marker.png',
						iconSize: [50, 50],
        			});
					single_detailmap.scrollWheelZoom.disable();
					L.marker([map_lat,map_long],{draggable: false,icon: custom_icon}).addTo(single_detailmap); 
					single_detailmap.invalidateSize();
			}
			
			if(get_strings.map_type == 'google_map' && get_strings.gapp_keyz !='')
			{
				 google.maps.event.addDomListener(window, 'load', places_google_map_single(map_lat,map_long));
				 function places_google_map_single(map_lat,map_long)
				 {
					if(map_lat !=="" && map_long !=="")
					{
						var map_center_positionr = new google.maps.LatLng(map_lat,map_long);
						var mapOptions = {
							zoom: 13,
							center: map_center_positionr,
							disableDefaultUI: false
						};
						var map = new google.maps.Map(chk_singlemapcontainer, mapOptions);
						var get_markers = new google.maps.Marker({
							position: map_center_positionr,
							map: map,
							icon: get_strings.p_path+'libs/images/map-marker.png',
							labelAnchor: new google.maps.Point(1, 1),
							draggable: false,
							animation: google.maps.Animation.DROP,
						});
					}
				 }
			 }

			if(get_strings.map_type == 'mapbox')
			{
				 if (typeof(get_strings.acc_keyz) !== 'undefined' && get_strings.acc_keyz !== '')
				 {
					 places_mapbox_map_single(map_lat,map_long);
					 function places_mapbox_map_single(map_lat,map_long)
					 {
						if(map_lat !=="" && map_long !=="")
						{
							mapboxgl.accessToken = get_strings.acc_keyz;	
							var mapz = new mapboxgl.Map({
								container: chk_singlemapcontainer,
								style: 'mapbox://styles/mapbox/streets-v11',
								center: [map_long, map_lat],
								zoom: 13
							});
							var mapbox_marker = new mapboxgl.Marker({draggable: false, color: 'orange'}).setLngLat([map_long, map_lat]).addTo(mapz);
						}
					 }
				 }
			 }
		}
		
		/*Location On Single Detail*/
		var chk_mapcontainer =  document.getElementById('property_map_single');
		if (typeof(chk_mapcontainer) !== 'undefined' && chk_mapcontainer !== null && get_strings.is_map_enabled == 1)
		{
			 var map_lat =  get_strings.map_latt;
			 var map_long = get_strings.map_long;
			 //  var map_lat =  $("#single-lat").val();
			 // var map_long = $("#single-lng").val();
			 if(get_strings.map_type == 'open_street')
			 {
					var singlemap = L.map(chk_mapcontainer).setView([map_lat,map_long], 13);
						L.tileLayer('//{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
						 maxZoom: 18,
					}).addTo(singlemap);
					var custom_icon = L.icon({
						iconUrl: get_strings.p_path+'libs/images/map-marker.png',
						iconSize: [50, 50],
        			});
					singlemap.scrollWheelZoom.disable();
					L.marker([map_lat,map_long],{draggable: false,icon: custom_icon}).addTo(singlemap); 
					singlemap.invalidateSize();
			 }
			 if(get_strings.map_type == 'google_map' && get_strings.gapp_keyz !='')
			 {
				 google.maps.event.addDomListener(window, 'load', places_google_map_single(map_lat,map_long));
				 function places_google_map_single(map_lat,map_long)
				 {
					if(map_lat !=="" && map_long !=="")
					{
						var map_center_positionr = new google.maps.LatLng(map_lat,map_long);
						var mapOptions = {
							zoom: 13,
							center: map_center_positionr,
							disableDefaultUI: false
						};
						var map = new google.maps.Map(chk_mapcontainer, mapOptions);
						var get_markers = new google.maps.Marker({
							position: map_center_positionr,
							map: map,
							icon: get_strings.p_path+'libs/images/map-marker.png',
							labelAnchor: new google.maps.Point(1, 1),
							draggable: false,
							animation: google.maps.Animation.DROP,
						});
					}
				 }
			 }
			 if(get_strings.map_type == 'mapbox')
			 {
				 if (typeof(get_strings.acc_keyz) !== 'undefined' && get_strings.acc_keyz !== '')
				 {
					 places_mapbox_map_single(map_lat,map_long);
					 function places_mapbox_map_single(map_lat,map_long)
					 {
						if(map_lat !=="" && map_long !=="")
						{
							mapboxgl.accessToken = get_strings.acc_keyz;	
							var mapz = new mapboxgl.Map({
								container: chk_mapcontainer,
								style: 'mapbox://styles/mapbox/streets-v11',
								center: [map_long, map_lat],
								zoom: 9
							});
							var mapbox_marker = new mapboxgl.Marker({draggable: false, color: 'orange'}).setLngLat([map_long, map_lat]).addTo(mapz);
						}
					 }
				 }
			 }
		}
	
		/*Generate Maps*/
		var chk_container =  document.getElementById('property_map');
		if (typeof(chk_container) !== 'undefined' && chk_container !== null && get_strings.is_map_enabled == 1)
		{
			 var map_lat =  get_strings.map_latt;
			 var map_long = get_strings.map_long;
			 var listing_latt = parseFloat($('#property_latt').val());
        	 var listing_long = parseFloat($('#property_long').val());
			 if(listing_latt && listing_long)
			 {
				 map_lat = listing_latt;
				 map_long = listing_long;
			 }
					if(get_strings.map_type == 'open_street')
					{
						var mymap = L.map(chk_container).setView([map_lat,map_long], 13);
						L.tileLayer('//{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
						maxZoom: 18,
					}).addTo(mymap);
					var custom_icon = L.icon({
						iconUrl: get_strings.p_path+'libs/images/map-marker.png',
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
					if(get_strings.map_type == 'google_map' && get_strings.gapp_keyz !='')
					{
						google.maps.event.addDomListener(window, 'load', places_google_map(map_lat,map_long));
						//return false;
					}
					if(get_strings.map_type == 'mapbox')
					{
						if (typeof(get_strings.acc_keyz) !== 'undefined' && get_strings.acc_keyz !== '')
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
					icon: get_strings.p_path+'libs/images/map-marker.png',
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
					mapboxgl.accessToken = get_strings.acc_keyz;	
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
		
		
		/*get user current location*/
		if(typeof get_strings.ip_type != 'undefined' && get_strings.ip_type !="")
		{
		     $('.get-loc  i.detect-me').on('click', function(e) {
				 e.preventDefault();
				 $(this).addClass('fa-spinner fa-spin extra-spin');
				 $(this).removeClass('fa-location-arrow');
				 if(get_strings.ip_type == "geo_ip")
				 {

				 	 $.ajax({
						 url: "https://geoip-db.com/json/geoip.php?jsonp",
						 jsonpCallback: "callback",
						 dataType: "jsonp",
						 success: function( location ) {
							 $('#country').html(location.country_name);
							 $('#state').html(location.state);
							 $('#city').html(location.city);
							 $('#property_latt').html(location.latitude);
							 $('#property_long').html(location.longitude);
							 $('#ip').html(location.IPv4);
						 }
					 });
					 $.getJSON('https://geoip-db.com/json/geoip.php?jsonp=?') .done (function(location){
						$("#property_address").val(location.city + ", " + location.country_name );
						if (typeof(chk_container) !== 'undefined' && chk_container !== null && get_strings.is_map_enabled == 1)
						{
							  if(document.getElementById('property_latt') !== null || document.getElementById('property_latt') === undefined)
							  {
								  document.getElementById('property_latt').value = location.latitude;
							  }
							  if(document.getElementById('property_long') !== null || document.getElementById('property_long') === undefined)
							  {
								  document.getElementById('property_long').value = location.longitude;
							  }
							 if (get_strings.map_type == "open_street")
							 {
								 mymap.setView(new L.LatLng(location.latitude, location.longitude), 13);
                                 markerz.setLatLng([location.latitude, location.longitude]);
							 }
							 if(get_strings.map_type == 'google_map' && get_strings.gapp_keyz !='')
							 {
								google.maps.event.addDomListener(window, 'load', places_google_map(location.latitude,location.longitude));
							 }
							 if(get_strings.map_type == 'mapbox' && get_strings.acc_keyz !== '')
							 {
								 places_mapbox_map(location.latitude,location.longitude);
							 } 
						  }
						$('.get-loc i.detect-me').removeClass('fa-spinner fa-spin extra-spin');
						$('.get-loc i.detect-me').addClass('fa-location-arrow');
					});
				 }
				 else
				 {
					$.get("https://ipapi.co/json", function(location) {

						alerty('addd');
						  $("#property_address").val(location.city + ", " + location.country_name );
						 if (typeof(chk_container) !== 'undefined' && chk_container !== null && get_strings.is_map_enabled == 1)
						{
							 if(document.getElementById('property_latt') !== null || document.getElementById('property_latt') === undefined)
							 {
								  document.getElementById('property_latt').value = location.latitude;
							 }
							 if(document.getElementById('property_long') !== null || document.getElementById('property_long') === undefined)
							 {
								  document.getElementById('property_long').value = location.longitude;
							 }
							 if (get_strings.map_type == "open_street")
							 {
								 mymap.setView(new L.LatLng(location.latitude, location.longitude), 13);
                                 markerz.setLatLng([location.latitude, location.longitude]);
							 }
							 if(get_strings.map_type == 'google_map' && get_strings.gapp_keyz !='')
							 {
								google.maps.event.addDomListener(window, 'load', places_google_map(location.latitude,location.longitude));
							 }
							 if(get_strings.map_type == 'mapbox' && get_strings.acc_keyz !== '')
							 {
								 places_mapbox_map(location.latitude,location.longitude);
							 } 
						  }
						$('.get-loc i.detect-me').removeClass('fa-spinner fa-spin extra-spin');
						$('.get-loc i.detect-me').addClass('fa-location-arrow');
					 }, "json");
				 }
			 });
		}
		
		if($(".custom-meta-gallery").length > 0 ){
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
	}
	 
/*---- Mortgage Calculator  ----*/
function calculate(){
  var value = $('#input_value').val();
  var downPayment = $('#input_down_payment').val();
  var l = value-downPayment;
  var interest = $('#input_interest').val();
  if ($("#interest_option").val()=="Yearly")
  {
    var r = (interest/100)/12;
  }
  else if($("#interest_option").val()=="Monthly"){
    var r = interest/100;
  } 
  var duration = $('#input_duration').val();
  if ($("#term_option").val()=="Years")
  {
    var n = duration*12;
  }
  else if($("#term_option").val()=="Months")
  {
    var n = duration;
  } 
/*---- Basic Monthly Payment Calcutation  ----*/
  var P = l*r/ ( 1- Math.pow(1+r,-n) );
  var monthly_rate =  Math.round(r*100 * 100) / 100;
  var monthly_payment =Math.round(P * 100) / 100;
  var total_payment = Math.round(P*n * 100) / 100;
  var total_intrest = Math.round((P*n-l) * 100) / 100;
/*---- Producing results in Card ----*/
  $('.listing-specs').show();
  $('#p-remain-dept').html(l);
  $('#p-m-rate').html(monthly_rate);
  $('#p-pay-period').html(n);
  $('#p-monthly-total').html(monthly_payment);
  $('#p-total-pay').html(total_payment);
  $('#p-total-intrest').html(total_intrest);
}
$('#calculate').on('click', function () {
  calculate();
});

$('.prop-currency-switch').on('change', function () 
{
	 var curr_rate = $(this).val();
	 var date = new Date();
	 date.setTime(date.getTime()+(12 * 60 * 60 * 1000));
	 Cookies.set('prop_currency_rate', curr_rate, {expires:date});
	 window.location.reload();
});


/* Re-initialize*/
function reloadMasonry()
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
                columnWidth: '.grid-item',
                 originLeft: false
            }
        });
    });
}
//layout button 
$(".style-selec").on('click', function (e) {
		 $('.filters-nav li a').removeClass('active-grid').addClass("make-me-dark");
		 $(this).addClass('active-grid');
		 $('input[name="layout-type"]').val($(this).val());
		});
	


//IDX plugin
$(".dsidx-results").addClass("container custom-padding");
$(".dsidx-details").addClass("container custom-padding");
$(".dsidx-large-button").removeClass('dsidx-large-button').addClass("btn btn-theme");
$('#ddlTerms').select2({
	 width:'100%',
	 theme: "classic",
});
$("#btnCalculate").addClass("btn btn-theme");
$("#btnCancel").addClass("btn btn-theme btn-second");

$('#dsidx select').select2({
	 width:'100%',
	 theme: "classic",	
});


})(jQuery);