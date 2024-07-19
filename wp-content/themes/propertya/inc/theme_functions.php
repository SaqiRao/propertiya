<?php
// Submit Form Fields
if( !function_exists('propertya_form_fields') )
{
    function propertya_form_fields()
	{
	   $local = propertya_localization();
       $form_fields = array
	   (
	   		'property_type' => $local['property_type'],
			'offer_type' 	=> $local['offer_type'],
			'property_label' => $local['property_label'],
			'currecny_type' => $local['currecny_type'],
			'property_price' => $local['property_price'],
			'snd_price' 	=> $local['snd_price'],
			'before_price' => $local['before_price'],
			'after_price' => $local['after_price'],
			'property_area' => $local['property_area'],
			'area_prefix' => $local['area_prefix'],
			'land_area' => $local['land_area'],
			'land_area_prefix' => $local['land_area_prefix'],
			'bedrooms' => $local['bedrooms'],
			'bathrooms' => $local['bathrooms'],
			'grages' => $local['grages'],
			'yearbuild' => $local['yearbuild'],
			'amenities' => $local['amenities'],
			'video' => $local['video'],
			'virtual_tour' => $local['virtual_tour'],
			'desc' => $local['desc'],
			'gallery' => $local['gallery'],
			'zip_code' => $local['zip_code'],
			'street_location' => $local['street_location'],
			'map' => $local['map'],
			'coordinates' => $local['coordinates'],
			'location' => $local['location'],
			'floorplan' => $local['floorplan'],
			'additional_fields' => $local['additional_fields'],
			'attachments' => $local['attachments'],
	   );
	   return $form_fields;
    }
}
// Submit Form Fields
if( !function_exists('propertya_strings') )
{
    function propertya_strings($paramz)
	{
		global $propertya_options;
		if(isset($propertya_options[$paramz]) &&  $propertya_options[$paramz] !="")
		{
			return $propertya_options[$paramz];
		}
		else
		{
			return '';
		}
	}
}


// Site Main Logo
if (!function_exists('propertya_site_logo')) {

    function propertya_site_logo()
	{
		$image_id = '';
        $logo = trailingslashit(get_template_directory_uri()) . 'libs/images/logo.svg';
		$is_sticky = trailingslashit(get_template_directory_uri()) . 'libs/images/sticky-logo.png';
		$is_mobile = trailingslashit(get_template_directory_uri()) . 'libs/images/mobile-logo.png';
        global $propertya_options;
		if(get_post_meta( get_the_ID(), 'show_trans_header', true )!="")
		{
			 $logo = trailingslashit(get_template_directory_uri()) . 'libs/images/logo-white.svg';
			 if (isset($propertya_options["prop_trans_logo"]["url"]) && $propertya_options["prop_trans_logo"]["url"] != "")
			 {
            	$logo = $propertya_options["prop_trans_logo"]["url"];
       		 }
		}
		else
		{
			 if (isset($propertya_options["prop_main_logo"]["url"]) && $propertya_options["prop_main_logo"]["url"] != "") {
            	$logo = $propertya_options["prop_main_logo"]["url"];
       		 }
		}
        
		$stick_logo = $sticky_logo ='';
		if (isset($propertya_options["prop_sticky_logo"]["url"]) && $propertya_options["prop_sticky_logo"]["url"] != "")
		{
            $sticky_logo = $propertya_options["prop_sticky_logo"]["url"];
			$stick_logo = 'data-sticky-logo="'.$sticky_logo.'"';
			
        }
		else
		{
			$stick_logo = 'data-sticky-logo="'.$is_sticky.'"';
		}
		$is_mobile_logo = $mobile_logo ='';
		if (isset($propertya_options["prop_mobile_logo"]["url"]) && $propertya_options["prop_mobile_logo"]["url"] != "")
		{
            $mobile_logo = $propertya_options["prop_mobile_logo"]["url"];
			$is_mobile_logo = 'data-mobile-logo="'.$mobile_logo.'"';
        }
		else
		{
			$is_mobile_logo = 'data-mobile-logo="'.$is_mobile.'"';
		}
		return '<div class="logo" '.$stick_logo.' '.$is_mobile_logo.'>
                <a href="'.esc_url(home_url("/")).'"><img src="'.esc_url($logo).'" alt="'. esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', TRUE)).'"/></a>
			</div>';
    }
}
if (!function_exists('propertya_site_logo_only')) {

    function propertya_site_logo_only()
	{
		$image_id = '';
        $logo = trailingslashit(get_template_directory_uri()) . 'libs/images/logo.png';
        global $propertya_options;
        if (isset($propertya_options["prop_main_logo"]["url"]) && $propertya_options["prop_main_logo"]["url"] != "") {
            $logo = $propertya_options["prop_main_logo"]["url"];
        }
		return '<a href="'.esc_url(home_url("/")).'"><img class="logo-for-auth img-fluid mb-2 mb-md-2" src="'.esc_url($logo).'" alt="'. esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', TRUE)).'"/></a>';
    }

}

// Site Footer Logo
if (!function_exists('propertya_site_footer_logo')) {

    function propertya_site_footer_logo()
	{
        global $propertya_options;
		$image_id = '';
        $logo = trailingslashit(get_template_directory_uri()) . 'libs/images/logo-white.svg';
        if (isset($propertya_options["prop_footer_logo"]["url"]) && $propertya_options["prop_footer_logo"]["url"] != "") {
            $logo = $propertya_options["prop_footer_logo"]["url"];
        }
        return '<img src="' . esc_url($logo) . '" alt="'. esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', TRUE)).'" class="img-fluid" />';
    }
}

// site background image

if (!function_exists('propertya_site_footer_image')) {

    function propertya_site_footer_image()
	{
        global $propertya_options;
		$image_id = '';
        $img = trailingslashit(get_template_directory_uri()) . 'libs/images/footerbg.png';
        if (isset($propertya_options["prop_footer_background"]["url"]) && $propertya_options["prop_footer_background"]["url"] != "") {
            $img = $propertya_options["prop_footer_background"]["url"];
        }
         return '"' . esc_url( $img) . '"';
    }
}



// Submit Form Fields
if( !function_exists('propertya_placeholder_images') )
{
    function propertya_placeholder_images($type,$post_id = '',$thumbnail_size = '')
	{
		global $propertya_options;
		$field_name = 'prop_def_agency_placeholder';
		
		if($type == "agency")
		{
			$field_name = 'prop_def_agency_placeholder';
			$placeholder_img = trailingslashit(get_template_directory_uri()) . 'libs/images/agency-logo.png';
		}
		if($type == "agent")
		{
			$field_name = 'prop_def_agent_placeholder';
			$placeholder_img = trailingslashit(get_template_directory_uri()) . 'libs/images/agency.jpg';
		}
		
		if($type == "buyer")
		{
			$field_name = 'prop_def_buyer_logo';
			$placeholder_img = trailingslashit(get_template_directory_uri()) . 'libs/images/default-imag.jpg';
		}
		
		if(isset($post_id) && $post_id !="")
		{
			if(has_post_thumbnail($post_id))
			{
				$image = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), $thumbnail_size);
				return 	$placeholder_img = $image[0];
			}
			else
			{
				if(is_array($propertya_options[$field_name]) && $propertya_options[$field_name]["url"] !="")
				{
					$placeholder_img = $propertya_options[$field_name]["url"];
				}
			}
		}
		else
		{
			if(is_array($propertya_options[$field_name]) && $propertya_options[$field_name]["url"] !="")
			{
				$placeholder_img = $propertya_options['prop_def_agency_placeholder']["url"];
			}
		}
		return 	$placeholder_img;
	}
}

// Profile Cover Image
if( !function_exists('propertya_placeholder_cover') )
{
	function propertya_placeholder_cover($post_id)
	{
		global $propertya_options;
		$feat_image_url = $bg_img = $attachment_id = '';
		$placeholder_img = trailingslashit(get_template_directory_uri()) . 'libs/images/cover-image.jpg';
		if (isset($propertya_options["prop_profile_cover_image"]["url"]) && $propertya_options["prop_profile_cover_image"]["url"] != "")
		{
			if(get_post_meta($post_id, 'my_cover_featuredimg', true ) !="")
			{
				$attachment_id = get_post_meta($post_id, 'my_cover_featuredimg', true );
				$feat_image_url = wp_get_attachment_url($attachment_id);
				$placeholder_img = 'style="background-image: url('.$feat_image_url.'); -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; background-repeat: no-repeat; background-position: center center;"';
			}
			else
			{
				$placeholder_img = 'style="background-image: url('.$propertya_options["prop_profile_cover_image"]["url"].'); -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; background-repeat: no-repeat; background-position: center center;"';
			}
			
		}
		return $placeholder_img;
	}
}

// Profile Cover Image
if( !function_exists('propertya_placeholder_cover_thumbnail') )
{
	function propertya_placeholder_cover_thumbnail($post_id,$thumbnail_size)
	{
		$final_url = trailingslashit(get_template_directory_uri()) . 'libs/images/cover-image.jpg';
		if(get_post_meta($post_id, 'my_cover_featuredimg', true ) !="")
		{
			$attachment_id = get_post_meta($post_id, 'my_cover_featuredimg', true );
			$image_url =  wp_get_attachment_image_src($attachment_id, $thumbnail_size);
			if(!empty($image_url) && is_array($image_url))
			{
				$final_url = $image_url[0];
			}
		}
		else
		{
			$final_url = trailingslashit(get_template_directory_uri()) . 'libs/images/cover-image.jpg';
			if (isset($propertya_options["prop_profile_cover_image"]["url"]) && $propertya_options["prop_profile_cover_image"]["url"] != "")
			{
				$final_url = $propertya_options["prop_profile_cover_image"]["url"];
			}
			else
			{
				$final_url = $final_url; 
			}
		}
		return $final_url;
	}
}

// Return Responsive Image
if( !function_exists('propertya_responsive_images') )
{
	function propertya_responsive_images($post_id,$thumbnail_size,$type = '',$class = '')
	{
		global $propertya_options;
		$image_id = '';
		$field_name = 'prop_def_agency_placeholder';
		if($type == "agency")
		{
			$field_name = 'prop_def_agency_placeholder';
			$placeholder_img = trailingslashit(get_template_directory_uri()) . 'libs/images/agency-logo.png';
		}
		if($type == "agent")
		{
			$field_name = 'prop_def_agent_placeholder';
			$placeholder_img = trailingslashit(get_template_directory_uri()) . 'libs/images/agency.jpg';
		}
		if (has_post_thumbnail($post_id) )
		{
			return get_the_post_thumbnail($post_id, $thumbnail_size, array( 'class' => 'img-fluid '.$class.'' ));
		}
		else
		{
			if($propertya_options[$field_name] && $propertya_options[$field_name]["url"] !="")
			{
				$placeholder_img = $propertya_options[$field_name]["url"];
				return '<img src="'.esc_url($placeholder_img).'" alt="'.esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', TRUE)).'" class="img-fluid '.$class.'">';
			}
		}
	}
}

// Specific listing actions
if( !function_exists('propertya_specific_listing_actions') )
{
    function propertya_specific_listing_actions($property_id,$is_edit = '')
	{
		$edit_slug = $return_html = '';
		$edit_slug = propertya_framework_get_link('page-dashboard.php').'?page-type=submit-property';
		if(propertya_strings('prop_membership_type') != '' && propertya_strings('prop_membership_type') == 'builtin' && propertya_strings('prop_pkg_type') != ''  && propertya_strings('prop_pkg_type') == 'per-listing')
		{
			$return_html = $link = '';
			$link = propertya_framework_get_link('page-dashboard.php')."?page-type=order-complete&listing_id=$property_id";
			if(!empty(propertya_strings('prop_perlisting_featured')) && !empty(propertya_strings('prop_perlisting_featured_expiry')))
			{
				if (get_post_meta($property_id, 'prop_is_feature_listing', true ) == "0" && get_post_meta($property_id, 'prop_payper_lisitng', true ) == "1")
				{
					$return_html.='<a data-toggle="tooltip" data-placement="top" title="'.esc_attr__('Mark As Featured','propertya').'" href="'. esc_url($link).'" class="btn btn-sm btn-default btn-featured"><i class="fas fa-star"></i></a> ';
				}
			}
			if (get_post_meta($property_id, 'prop_payper_lisitng', true ) == "0")
			{
		 		$return_html.='<a href="'.esc_url($link).'" class="btn btn-sm btn-default btn-pay"><i class="fa fa-credit-card"></i> '.esc_html__('Pay','propertya').'</a> ';
			}
			else
			{
				$return_html.='<a href="javascript:void(0)" class="btn btn-sm btn-default btn-paid"><i class="far fa-check-circle"></i> '.esc_html__('Paid','propertya').'</a> ';
			}
		}
		$expired = '<a class="dropdown-item expire-my-prop" href="javascript:void(0)" data-property-id="'. esc_attr($property_id).'"><i class="text-info far fa-trash-alt"></i> '.esc_html__('Expired','propertya').'</a>';
		if(!empty($is_edit))
		{
			$expired = '';
		}
		$return_html.='<span class="dropdown">
				<button class="btn btn-sm btn-default" type="button" id="dropdownMenuButton-'.$property_id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-h"></i>
				</button>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton-'.$property_id.'">
					<a class="dropdown-item" href="'.esc_url($edit_slug).'&edit_property='.esc_attr($property_id).'"><i class="text-warning fa fa-edit"></i> '.esc_html__('Edit','propertya').'</a>
					'.$expired.'
					<a class="dropdown-item delete-my-prop" href="javascript:void(0)" data-property-id="'. esc_attr($property_id).'"><i class="text-danger far fa-trash-alt"></i> '.esc_html__('Delete','propertya').'</a>
				</div>
			</span>';
		return	$return_html;	
	}
}

// Site Main Header
if( !function_exists('propertya_site_header') )
{
    function propertya_site_header()
	{
		$layout = 2;
		if(propertya_strings('prop_selected_header') !="")
		{
			$layout = propertya_strings('prop_selected_header');
		}
		if(propertya_strings('prop_show_topbar') !="" && propertya_strings('prop_show_topbar') =="1")
		{
			$topbar = propertya_strings('prop_topbar_style');
			echo get_template_part( 'template-parts/topbar/top', 1);
		}
		return  get_template_part( 'template-parts/header/header', $layout );
	}
}
// Site Main Header
if( !function_exists('propertya_site_footer') )
{
    function propertya_site_footer()
	{
		$layout = 1;
		if(propertya_strings('prop_footer_layout') !="")
		{
			$layout = propertya_strings('prop_footer_layout');
		}
		if(is_page_template('page-property-search.php') && !empty(propertya_strings('prop_listing_search_layout')) && propertya_strings('prop_listing_search_layout') == 'map')
		{
		}
		else
		{
			return  get_template_part( 'template-parts/footer/footer', $layout );
		}
	}
}

// Site Preloader
if( !function_exists('propertya_site_spinner') )
{
    function propertya_site_spinner()
	{
		global $propertya_options;
		if(isset($propertya_options['prop_site_spinner']) &&  $propertya_options['prop_site_spinner'] == true)
		{
			return '<div class="preloader-site"><div class="lds-ripple"><div></div><div></div></div></div>';
		}
	}
}

// Background Src
if( !function_exists('propertya_bg_src') )
{
    function propertya_bg_src($option_name)
	{
		$defual_img = trailingslashit(get_template_directory_uri()) . 'libs/images/defualt-935x754.png';
        global $propertya_options;
		if (isset($propertya_options['prop_auth_def_img']["url"]) && $propertya_options['prop_auth_def_img']["url"] != "") 		        {
            $defual_img = $propertya_options['prop_auth_def_img']["url"];
        }
        if (isset($propertya_options[$option_name]["url"]) && $propertya_options[$option_name]["url"] != "") {
            $defual_img = $propertya_options[$option_name]["url"];
        }
		return 'style=background-image:url('.$defual_img.')';
	}
}


// Fetch Yelp NearBy Data
if( !function_exists('propertya_get_yelp_data') )
{
	  function propertya_get_distance_between_ponits($lat1, $lon1, $lat2, $lon2)
	  {
		  if(isset($lat1) && isset($lon1) && isset($lat2) && isset($lon2))
		  {
		  	  $lon1 =floatval($lon1);
		      $lon2 = floatval($lon2);
			  $theta = $lon1 - $lon2;
			  $lat1 = floatval($lat1);
              $lat2 = floatval($lat2);
              $theta = floatval($theta);
			 // $theta = $lon1 - $lon2;

			  $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
			  $miles = acos($miles);
			  $miles = rad2deg($miles);
			  $miles = $miles * 60 * 1.1515;
			  $feet = $miles * 5280;
			  $yards = $feet / 3;
			  $kilometers = $miles * 1.60934;
			  $meters = $kilometers * 1000;
			  return compact('miles','feet','yards','kilometers');
		  }
	  }
}
  

// Fetch Yelp NearBy Data
if( !function_exists('propertya_get_yelp_data') )
{
    function propertya_get_yelp_data($property_id,$selected_latt,$selected_long)
	{
		if(!empty($property_id) && !empty($selected_latt) && !empty($selected_long))
		{
			$yelp_terms_array = array (
				'active' => array('term_name'=>esc_html__('Active Life', 'propertya' ), 'yelp_icon' => 'fas fa-bicycle' ),
				'arts' => array( 'term_name' => esc_html__( 'Arts & Entertainment', 'propertya' ), 'yelp_icon' => 'fas fa-paint-brush' ),
				'auto' => array( 'term_name' => esc_html__( 'Automotive', 'propertya' ), 'yelp_icon' => 'fas fa-car' ),
				'beautysvc' => array( 'term_name' => esc_html__( 'Beauty & Spas', 'propertya' ), 'yelp_icon' => 'fas fa-spa' ),
				'education' => array( 'term_name' => esc_html__( 'Education', 'propertya' ), 'yelp_icon' => 'fas fa-graduation-cap' ),
				'eventservices' => array( 'term_name' => esc_html__( 'Event Planning & Services', 'propertya' ), 'yelp_icon' => 'fas fa-calendar-week' ),
				'financialservices' => array( 'term_name' => esc_html__( 'Financial Services', 'propertya' ), 'yelp_icon' => 'fas fa-cog' ),
				'food' => array( 'term_name' => esc_html__( 'Food', 'propertya' ), 'yelp_icon' => 'fas fa-utensils' ),
				'health' => array( 'term_name' => esc_html__( 'Health & Medical', 'propertya' ), 'yelp_icon' => 'fas fa-heartbeat' ),
				'homeservices' => array( 'term_name' => esc_html__( 'Home Services ', 'propertya' ), 'yelp_icon' => 'fas fa-user-cog' ),
				'hotelstravel' => array( 'term_name' => esc_html__( 'Hotels & Travel', 'propertya' ), 'yelp_icon' => 'fas fa-hotel' ),
				'localflavor' => array( 'term_name' => esc_html__( 'Local Flavor', 'propertya' ), 'yelp_icon' => 'fas fa-concierge-bell' ),
				'localservices' => array( 'term_name' => esc_html__( 'Local Services', 'propertya' ), 'yelp_icon' => 'fas fa-tools' ),
				'massmedia' => array( 'term_name' => esc_html__( 'Mass Media', 'propertya' ), 'yelp_icon' => 'fas fa-tv' ),
				'nightlife' => array( 'term_name' => esc_html__( 'Nightlife', 'propertya' ), 'yelp_icon' => 'fas fa-glass-cheers' ),
				'pets' => array( 'term_name' => esc_html__( 'Pets', 'propertya' ), 'yelp_icon' => 'fas fa-paw' ),
				'professional' => array( 'term_name' => esc_html__( 'Professional Services', 'propertya' ), 'yelp_icon' => 'fas fa-business-time' ),
				'publicservicesgovt' => array( 'term_name' => esc_html__( 'Public Services & Government', 'propertya' ), 'yelp_icon' => 'fas fa-fire' ),
				'realestate' => array( 'term_name' => esc_html__( 'Real Estate', 'propertya' ), 'yelp_icon' => 'fas fa-home' ),
				'religiousorgs' => array( 'term_name' => esc_html__( 'Religious Organizations', 'propertya' ), 'yelp_icon' => 'fas fa-praying-hands' ),
				'restaurants' => array( 'term_name' => esc_html__( 'Restaurants', 'propertya' ), 'yelp_icon' => 'fas fa-hamburger' ),
				'shopping' => array( 'term_name' => esc_html__( 'Shopping', 'propertya' ), 'yelp_icon' => 'fas fa-shopping-cart' ),
			);
			// get selected yelp terms
			 $fetch_data = $dynamic_response = array();
			 $dis_abbt =  $yelp_distance_unit = $page_html = $term_icon = $term_name = '';
			 //cache time
			 $hours = 6;
			 if(!empty(propertya_strings('prop_yelp_cache_limit')))
			 {
				 $hours = propertya_strings('prop_yelp_cache_limit');
			 }
			 if(false === ($page_html = get_transient('my_yelpdata_'.$property_id.'') ))
			 {
				 if(!empty(propertya_strings('prop_yelp_term')) && is_array(propertya_strings('prop_yelp_term')) && count(propertya_strings('prop_yelp_term')) > 0)
				 {
					 $yelp_distance_unit = 'kilometers';
					 $yelp_terms = propertya_strings('prop_yelp_term');
					 if(!empty(propertya_strings('yelp_dist_unit')))
					 {
						 $yelp_distance_unit = propertya_strings('yelp_dist_unit');
					 }
					 
					 
					 foreach($yelp_terms as $term)
					 {
						 //fetch name & icon form upper array
						 $term_name = $yelp_terms_array[$term]['term_name'];
						 $term_icon = $yelp_terms_array[$term]['yelp_icon'];
						 //call yelp api now
						 $dynamic_response = query_api($term, $selected_latt,$selected_long);
						 if(!empty($dynamic_response)  && count(array($dynamic_response)) > 0)
						 {
							if(isset($dynamic_response->businesses))
							{
								$page_html.= '<div class="yelp-container">';
								$page_html.= '<div class="my-yelp"><span class="yelp-custom-icons"><i class="'.$term_icon.'"></i></span>';
								$page_html.= ' <h4 class="yelp-main-term">'.$term_name.'</h4></div>';
								$fetch_data = $dynamic_response->businesses;
								foreach($fetch_data as $data)
								{
									$page_html.= '<div class="yelp-inner-loop"><span class="yelp-inner-title">'.$data->name.'</span>';
									$distacne = $second_long = $second_lat = '';
									if(isset($data->coordinates->latitude) && $data->coordinates->longitude)
									{
										$distance_unit = array(
											'miles' => array('dis_name'=>esc_html__('Miles', 'propertya' ), 'dis_abbt' =>esc_html__('mi', 'propertya' ) ),
											'feet' => array('dis_name'=>esc_html__('Feet', 'propertya' ), 'dis_abbt' =>esc_html__('ft', 'propertya' ) ),
											'yards' => array('dis_name'=>esc_html__('Yards', 'propertya' ), 'dis_abbt' =>esc_html__('yd', 'propertya' ) ),
											'kilometers' => array('dis_name'=>esc_html__('Kilometers', 'propertya' ), 'dis_abbt' =>esc_html__('km', 'propertya' ) ),
										 );
										$dis_abbt = $distance_unit[$yelp_distance_unit]['dis_abbt'];
										$second_lat = $data->coordinates->latitude;
										$second_long = $data->coordinates->longitude;
										$distacne = propertya_get_distance_between_ponits($selected_latt, $selected_long, $second_lat, $second_long);
										$page_html.= '<span class="yelp-place-distance"> ('.number_format($distacne[$yelp_distance_unit],2).' '.$dis_abbt.')</span>';
									}
									$page_html.= '<div class="yelp-stars yelp-rating" data-rating="'.$data->rating.'">
										  <i class="star-1">★</i>
										  <i class="star-2">★</i>
										  <i class="star-3">★</i>
										  <i class="star-4">★</i>
										  <i class="star-5">★</i>
									</div>
								</div>';
								}
								$page_html.= '</div>';
							}
						 }
					 }
				 }
				 set_transient('my_yelpdata_'.$property_id.'', $page_html, $hours * HOUR_IN_SECONDS);
			 }
			 return $page_html;
		}
	}
}



// Get Listing Owner Details
if (!function_exists('propertya_reviews_average'))
{
    function propertya_reviews_average($property_id)
	 {
        $comments = '';
        $rated = $get_rating_avrage = '';
        $one_star = '';
        $two_star = '';
        $three_star = '';
        $four_star = '';
        $five_star = '';
        $star1 = $star2 = $star3 = $star4 = $star5 = 0;
        $comments = get_comments(array('post_id' => $property_id, 'post_type' => 'property', 'status' => 'approve', 'parent' => 0));
        if (count($comments) > 0) {
            $sum_of_rated = 0;
            $no_of_times_rated = 0;
            foreach ($comments as $comment) {
                if (get_comment_meta($comment->comment_ID, 'review_stars', true) != "") {
                    $rated = get_comment_meta($comment->comment_ID, 'review_stars', true);
                    if ($rated != "" && $rated > 0) {
                        $sum_of_rated += $rated;
                        $no_of_times_rated++;
                        //now rated percentage
                        if ($rated == 1) {
                            $star1++;
                        }
                        if ($rated == 2) {
                            $star2++;
                        }
                        if ($rated == 3) {
                            $star3++;
                        }
                        if ($rated == 4) {
                            $star4++;
                        }
                        if ($rated == 5) {
                            $star5++;
                        }
                    }
                }
            }
            //loop end get avrage value
            if ($rated != "" && $rated > 0) {
                $get_rating_avrage = round($sum_of_rated / $no_of_times_rated, 2);
                $get_rating_avrage1 = round($sum_of_rated / $no_of_times_rated, 1);
                $one_star = round(($star1 / $no_of_times_rated) * 100);
                $two_star = round(($star2 / $no_of_times_rated) * 100);
                $three_star = round(($star3 / $no_of_times_rated) * 100);
                $four_star = round(($star4 / $no_of_times_rated) * 100);
                $five_star = round(($star5 / $no_of_times_rated) * 100);
                $total_stars = explode(".", $get_rating_avrage1);
		


                $stars_html = '';
                $first_part = (isset($total_stars[0]) && $total_stars[0] > 0 && $total_stars[0] != "") ? $total_stars[0] : 0;
                $second_part = (isset($total_stars[1]) && $total_stars[1] > 0 && $total_stars[1] != "") ? $total_stars[1] : 0;
                for ($stars = 1; $stars <= 5; $stars++) {
                    if ($stars <= $first_part && $first_part > 0) {
                        $stars_html .= '<i class="fa fa-star color" aria-hidden="true"></i>';
                    } else if ($stars == $first_part + 1 && $second_part <= 5 && $second_part > 0) {
                        $stars_html .= '<i class="fa fa-star-half-o color" aria-hidden="true"></i>';
                    } else if ($stars == $first_part + 1 && $second_part > 5 && $second_part > 0) {
                        $stars_html .= '<i class="fa fa-star color" aria-hidden="true"></i>';
                    } else {
                        $stars_html .= '<i class="fa fa-star" aria-hidden="true"></i>';
                    }
                }
                if (strpos($get_rating_avrage, ".") !== false) {
                    $get_rating_avrage = $get_rating_avrage;
                } else {
                    $get_rating_avrage = $get_rating_avrage . '.0';
                }

                $array = array();
                $array['total_stars'] = $stars_html;
                $array['average'] = $get_rating_avrage;
                $array['rated_no_of_times'] = $no_of_times_rated;
                $array['ratings'] = array('star_1' => $one_star, 'star_2' => $two_star, 'star_3' => $three_star, 'star_4' => $four_star, 'star_5' => $five_star);
                //update avrage in post mera
                update_post_meta($property_id, 'listing_total_average', $get_rating_avrage);
                return $array;
            }
        }
    }

}

// Get Listing Owner Details
if (!function_exists('propertya_reviews_stats_average'))
{
    function propertya_reviews_stats_average($single_id,$type,$reference)
	{
		 $comments = array();
		 $comments = get_comments(array('post_id' => $single_id, 'post_type' => $type, 'status' => 'approve', 'parent' => 0));
		$sum_of_recommend  = $sum_of_services = $sum_of_expertise = $sum_of_communication = $sum_of_responsive = 0;
		$no_of_times_rated = 0;
		$second_part = $first_part = $total_stars = $get_rating_avrage1 = $full_avg	= $total_average = $recommend = $services = $expertise = $communication = $responsive = '';
		if(!empty($comments) && is_array($comments) && count($comments) > 0)
		{
			foreach ($comments as $comment) 
			{
				//responsive
				if (get_comment_meta($comment->comment_ID, 'review_'.$reference.'_responsive', true) != "")
				{
				   $responsive = get_comment_meta($comment->comment_ID, 'review_'.$reference.'_responsive', true);
				   $sum_of_responsive += $responsive;
				}
				//communication
				if (get_comment_meta($comment->comment_ID, 'review_'.$reference.'_communication', true) != "")
				{
				   $communication = get_comment_meta($comment->comment_ID, 'review_'.$reference.'_communication', true);
				   $sum_of_communication += $communication;
				}
				//expertise
				if (get_comment_meta($comment->comment_ID, 'review_'.$reference.'_expertise', true) != "")
				{
				   $expertise = get_comment_meta($comment->comment_ID, 'review_'.$reference.'_expertise', true);
				   $sum_of_expertise += $expertise;
				}
				//services
				if (get_comment_meta($comment->comment_ID, 'review_'.$reference.'_services', true) != "")
				{
				   $services = get_comment_meta($comment->comment_ID, 'review_'.$reference.'_services', true);
				   $sum_of_services += $services;
				}
				//recommend
				if(get_comment_meta($comment->comment_ID, 'review_'.$reference.'_recommend', true) != "")
				{
				   $recommend = get_comment_meta($comment->comment_ID, 'review_'.$reference.'_recommend', true);
				   $sum_of_recommend += $recommend;
				}
				$no_of_times_rated++;
			}
			$get_responsive_avrage = '';
			if(!empty($sum_of_responsive))
			{
				$get_responsive_avrage    = round($sum_of_responsive/$no_of_times_rated,2);
			}
			$get_communication_avrage = '';
			if(!empty($sum_of_responsive))
			{
				$get_communication_avrage = round($sum_of_communication/$no_of_times_rated,2);
			}
			$get_expertise_avrage     = '';
			if(!empty($sum_of_responsive))
			{
				$get_expertise_avrage     = round($sum_of_expertise/$no_of_times_rated,2);
			}
			$get_services_avrage = '';
			if(!empty($sum_of_responsive))
			{
				$get_services_avrage     = round($sum_of_services/$no_of_times_rated,2);
			}
			//total stars & average
			$total_average = $get_responsive_avrage+$get_communication_avrage+$get_expertise_avrage+$get_services_avrage;
			$full_avg	=  round($total_average/4, 1);
			
			//for stars
			$get_rating_avrage1 = round($full_avg, 1);
			$total_stars = explode(".", $get_rating_avrage1);

			//making stars
			$stars_html = '';
			$first_part = (isset($total_stars[0]) && $total_stars[0] > 0 && $total_stars[0] != "") ? $total_stars[0] : 0;
			$second_part = (isset($total_stars[1]) && $total_stars[1] > 0 && $total_stars[1] != "") ? $total_stars[1] : 0;
			for ($stars = 1; $stars <= 5; $stars++) {
				if ($stars <= $first_part && $first_part > 0) {
					$stars_html .= '<i class="fas fa-star color" aria-hidden="true"></i>';
				} else if ($stars == $first_part + 1 && $second_part <= 5 && $second_part > 0) {
					$stars_html .= '<i class="fas fa-star-half-alt color" aria-hidden="true"></i>';
				} else if ($stars == $first_part + 1 && $second_part > 5 && $second_part > 0) {
					$stars_html .= '<i class="fas fa-star color" aria-hidden="true"></i>';
				} else {
					$stars_html .= '<i class="fas fa-star" aria-hidden="true"></i>';
				}
			}
			//responsive
			if (strpos($get_responsive_avrage, ".") !== false) {
				$get_responsive_avrage = $get_responsive_avrage;
			} else {
				$get_responsive_avrage = $get_responsive_avrage . '.0';
			}
			//communication
			if (strpos($get_communication_avrage, ".") !== false) {
				$get_communication_avrage = $get_communication_avrage;
			} else {
				$get_communication_avrage = $get_communication_avrage . '.0';
			}
			//expertise
			if (strpos($get_expertise_avrage, ".") !== false) {
				$get_expertise_avrage = $get_expertise_avrage;
			} else {
				$get_expertise_avrage = $get_expertise_avrage . '.0';
			}
			//services
			if (strpos($get_services_avrage, ".") !== false) {
				$get_services_avrage = $get_services_avrage;
			} else {
				$get_services_avrage = $get_services_avrage . '.0';
			}
			//total_average
			if (strpos($full_avg, ".") !== false) {
				$full_avg = $full_avg;
			} else {
				$full_avg = $full_avg . '.0';
			}
			//return 
			$array['rated_no_of_times'] = $no_of_times_rated;
			$array['total_average'] = $full_avg;
			$array['total_recommendations'] = $sum_of_recommend;
			$array['total_stars'] = $stars_html;
			$array['average_responsive'] = $get_responsive_avrage;
			$array['average_communication'] = $get_communication_avrage;
			$array['average_expertise'] = $get_expertise_avrage;
			$array['average_service'] = $get_services_avrage;
			
			return $array;
		}
	}
}


// Get Listing Owner Details
if (!function_exists('propertya_getlabels'))
{
    function propertya_getlabels($property_id)
	{
		$type_term    = $label_type_term    = $label_type = $offer_type = $return_html = '';
		if(get_post_meta( $property_id, 'prop_offer_type', true ) !="")
		{
			$offer_type = get_post_meta( $property_id, 'prop_offer_type', true );

			$type_term    = propertya_get_term($offer_type,'property_status');
			

			if(isset($type_term->term_id))
			{

				$return_html .= '<li class="list-inline-item">
                    <a class="badge badge-status-'.esc_attr($type_term->term_id).'" href="'. esc_url(get_term_link($type_term->term_id)).'">'.esc_attr($type_term->name).'</a>
                  </li>';
			}
			
		
	}
		if(get_post_meta( $property_id, 'prop_offer_label', true ) !="")
		{
			$label_type = get_post_meta( $property_id, 'prop_offer_label', true );
			$label_type_term    = propertya_get_term($label_type,'property_label');
			
			if(isset($label_type_term->term_id))
			{
				
			$return_html .= '<li class="list-inline-item">
                    <a class="badge badge-label-'.esc_attr($label_type_term->term_id).'" href="'. esc_url(get_term_link($label_type_term->term_id)).'">'.esc_attr($label_type_term->name).'</a>
                  </li>';
              }
		}
		return $return_html;
	}
}

// Views
if (!function_exists('propertya_number_format_short'))
{
    function propertya_number_format_short($n, $precision = 1)
	{
		if(empty($n))
		{
			$n = 0;
		}
        if ($n < 1000) {
            // 0 - 1000
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else if ($n >= 1000 && $n < 1000000) {
            // 1k-999k
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K+';
        } else if ($n >= 1000000 && $n < 1000000000) {
            // 1m-999m
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M+';
        } else if ($n >= 1000000000 && $n < 1000000000000) {
            // 1b-999b
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = 'B+';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T+';
        }
        // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
        // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ($precision > 0) {
            $dotzero = '.' . str_repeat('0', $precision);
            $commazero = ',' . str_repeat('0', $precision);
            $n_format = str_replace($dotzero, '', $n_format);
            $n_format = str_replace($commazero, '', $n_format);
        }
        return $n_format . $suffix;
    }
}


// Count User Total Listings
if (!function_exists('propertya_count_listing')) {

    function propertya_count_listing($user_id)
    {
        $count = 0;
        $args = array('post_type' => 'property', 'author' => $user_id, 'fields' => 'ids', 'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key' => 'prop_status',
                    'value' => '1',
                    'compare' => '=',
                ),
            ),
        );
        $query = new WP_Query($args);
        if ($query->have_posts())
		{
            return propertya_number_format_short($query->found_posts);
        } 
		else
		{
            return propertya_number_format_short($count);
        }
		wp_reset_postdata();
    }
}
// Count User Total On Dashboard
if (!function_exists('propertya_count_total_properties')) {

    function propertya_count_total_properties($user_id,$listing_status,$is_featured = '')
    {
		$meta_key = '';
		$featured = '';
		if(!empty($is_featured))
		{
			   $featured = array(
                    'key' => 'prop_is_feature_listing',
                    'value' => '1',
                    'compare' => '=',
                );
		}
		$value = 1;
        $count = 0;
		if($listing_status == 'expired')
		{
			$value = 0;
		}
        $args = array('post_type' => 'property', 'author' => $user_id, 'fields' => 'ids', 'post_status' => $listing_status,
            'meta_query' => array(
                array(
                    'key' => 'prop_status',
                    'value' => $value,
                    'compare' => '=',
                ),
				$featured
            ),
        );
        $query = new WP_Query($args);
        if ($query->have_posts())
		{
            return propertya_number_format_short($query->found_posts);
        } 
		else
		{
            return propertya_number_format_short($count);
        }
		wp_reset_postdata();
    }
}

// Count User Total Listings
if (!function_exists('propertya_social_icons'))
{
    function propertya_social_icons($option_key = '')
	{
        global $propertya_options;
        $social_icons = array('Facebook' => 'fab fa-facebook-f', 'Twitter' => 'fab fa-twitter', 'Linkedin' => 'fab fa-linkedin ', 'YouTube' => 'fab fa-youtube', 'Vimeo' => 'fab fa-vimeo ', 'Pinterest' => 'fab fa-pinterest ', 'Tumblr' => 'fab fa-tumblr ', 'Instagram' => 'fab fa-instagram', 'Reddit' => 'fab fa-reddit ', 'Flickr' => 'fab fa-flickr ', 'StumbleUpon' => 'fab fa-stumbleupon', 'Delicious' => 'fab fa-delicious ', 'dribble' => 'fab fa-dribbble ', 'behance' => 'fab fa-behance', 'DeviantART' => 'fab fa-deviantart',
        );
        $li_html = '';
        if (isset($propertya_options[$option_key])) {
            $icons = $propertya_options[$option_key];
            if (isset($icons) && count((array) $icons) > 0) {
                foreach ($icons as $key => $val) {
                    $fa_value = $social_icons[$key];
                    if ($fa_value != "" && $val != "") {
                        $li_html .= '<li><a href="' . esc_url($val) . '"><i class="' . esc_attr($fa_value) . '"></i></a></li>';
                    }
                }
            }
        }
        return $li_html;
    }
}
// Footer Copyrights
if (!function_exists('propertya_footer_copyrights'))
{
    function propertya_footer_copyrights()
	{
        global $propertya_options;
        $site_title = get_bloginfo('name');
        $home_link = home_url("/");
        $copyrights_text = '<p> &copy; ' . esc_html__("Copyright", "propertya") . ' ' . date("Y") . ' | ' . esc_html__("All Rights Reserved", "propertya") . ' ' . '<a href="' . esc_url($home_link) . '"> | ' . esc_html($site_title) . '</a></p>';
        if (isset($propertya_options["prop_footer_copyrights"]))
		{
            $copyrights_text = $propertya_options["prop_footer_copyrights"];
        }
        return $copyrights_text;
    }
}

// User Package History
if ( ! function_exists( 'propertya_user_pack_history' ) )
{  
	function propertya_user_pack_history($package_id,$user_id)
	{
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && $package_id !="" )
		{
            $never_expire = propertya_strings('prop_never_exp');
            $unlimited = propertya_strings('prop_pkg_unlimited');
            $days = propertya_strings('prop_pkg_daytxt');
			$options_html = '';
            //duration
            if(get_user_meta($user_id, 'prop_pack_exp', true) !="")
            {
                $package_expiry = get_user_meta($user_id, 'prop_pack_exp', true);
                if ($package_expiry == '-1')
                {
                    $options_html .= '<li class="packages-list"><span class="far fa-check-square"></span><strong>' . propertya_strings('prop_p_exp') . '</strong> : ' . esc_html($never_expire). '</li>';
                } 
                else
                {
                    $options_html .= '<li class="packages-list"><span class="far fa-check-square"></span><strong>' . esc_html__('Package Expiry','propertya') . '</strong> : ' . esc_html(date("F jS, Y", strtotime($package_expiry))). '</li>';
                }
            }
            //listings
            if(get_user_meta($user_id, 'prop_pack_totallistings', true) !="")
            {
                $regular_listing = get_user_meta($user_id, 'prop_pack_totallistings', true);
                if ($regular_listing == '-1')
                {
                    $options_html .= '<li class="packages-list"><span class="far fa-check-square"></span><strong>' . propertya_strings('prop_reg_listing') . '</strong> : ' . esc_html($unlimited). '</li>';
                } 
                else
                {
                   $options_html .= '<li class="packages-list"><span class="far fa-check-square"></span><strong>' .  propertya_strings('prop_reg_listing') . '</strong> : ' . esc_html($regular_listing) . '</li>';
                }
            }
            //regular listings expiry
            if (get_user_meta($user_id, 'prop_pack_simple_expiry_for', true) != "")
            {
                $listing_expiry = get_user_meta($user_id, 'prop_pack_simple_expiry_for', true);
							
                if ($listing_expiry == '-1')
                {
                    $options_html .= '<li class="packages-list"><span class="far fa-check-square"></span><strong>' . propertya_strings('prop_l_exp') . '</strong> : ' . esc_html($never_expire) . '</li>';
                } 
                else
                {
                    $options_html .= '<li class="packages-list"><span class="far fa-check-square"></span><strong>' . propertya_strings('prop_l_exp') . '</strong> : ' . esc_attr($listing_expiry) . ' ' . $days . '</li>';
                }
            }
            //featured listings
            if (get_user_meta($user_id, 'prop_pack_featuredlistings', true) != "")
            {
                $featured_listing = get_user_meta($user_id, 'prop_pack_featuredlistings', true);
                if ($featured_listing == '-1')
                {
                    $options_html .= '<li class="packages-list"><span class="far fa-check-square"></span><strong>' . propertya_strings('prop_feat_listing') . '</strong> : ' . esc_html($unlimited). '</li>';
                } 
                else
                {
                    $options_html .= '<li class="packages-list"><span class="far fa-check-square"></span><strong>' . propertya_strings('prop_feat_listing') . '</strong> : ' . esc_html($featured_listing) . '</li>';
                }
            }
			 //featured listings expiry
            if (get_user_meta($user_id, 'prop_pack_exp_featured_for', true) != "")
            {
                $featured_listing_expiry = get_user_meta($user_id, 'prop_pack_exp_featured_for', true);
                if ($featured_listing_expiry == '-1')
                {
                    $options_html .= '<li class="packages-list"><span class="far fa-check-square"></span><strong>' . propertya_strings('prop_feat_for') . '</strong> : ' . esc_html($never_expire) . '</li>';
                } 
                else
                {
                    $options_html .= '<li class="packages-list"><span class="far fa-check-square"></span><strong>' . propertya_strings('prop_feat_for') . '</strong> : ' . esc_attr($featured_listing_expiry) . ' ' . $days . '</li>';
                }
            }
            return '<ul class="list-group">'.$options_html.'</ul>';   
		}
	}
}
// Site Main Logo
if (!function_exists('propertya_listing_breadcrumb')) {

    function propertya_listing_breadcrumb($property_id)
	{
		$cond = $condition = $category = $bread_html = $all_cats = '';
		$all_cats = get_post_meta($property_id, 'prop_type', true);
		$search_page = propertya_framework_get_link('page-listing-search.php');
		$condition = get_post_meta($property_id, 'mw_condition', true);
		if(!empty($condition))
		{
			$cond = get_term_by('slug', $condition, 'prop-condition');
			if(!empty($cond))
			{
				$bread_html .='<li class="breadcrumb-item"><span class="mydata-attr" data-url="'.esc_url($search_page)."?condition[]=".$cond->slug.'">'.esc_html($cond->name).'</span></li>';
			}
		}
		if(!empty($all_cats) && is_array($all_cats) && count($all_cats) > 0)
		{
			foreach($all_cats as $catz)
			{
				$category = get_term_by('id', $catz, 'property_type');
				if(!empty($category))
				{
					$bread_html .='<li class="breadcrumb-item"><a href="'.esc_url($search_page)."?category=".$category->slug.'">'.esc_html($category->name).'</a></li>';
				}
			}
		}
		$bread =  '<ol class="breadcrumb">
				  <li class="breadcrumb-item"><a href="'. esc_url(home_url( '/' )).'"><i class="fas fa-home"></i> '.esc_html__('Home','propertya').'</a></li>
				  <li class="breadcrumb-item"><a href="'. esc_url($search_page).'">'.esc_html__('Back to results','propertya').'</a></li>
				  '.$bread_html.'
				  <li class="breadcrumb-item active" aria-current="page">'.esc_html(get_the_title($property_id)).'</li>
				</ol>';
		return $bread;
	}
}