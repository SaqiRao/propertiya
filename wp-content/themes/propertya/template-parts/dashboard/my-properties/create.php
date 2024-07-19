<?php
   global $localization;
   global $propertya_options;
	$amen_idz = array();  
   $type  = $parent_category =$product_terms = $selected_desc  = $selected_title= $options = $custom_currency = $meta_html = $meta = ''; $user_id = $image_id = $property_id = $fetch_custom_data = $is_edit  =  $feature_checked = '';
   $class_three = $class_two = $class_one = 'none';
	$user_id = get_current_user_id();
	$is_edit = 'no';
   $custom_display = 'none';
   $featured_listings = get_user_meta(get_current_user_id(), 'prop_pack_featuredlistings', true);
     
	if( isset( $_GET['edit_property'] ) && $_GET['edit_property'] !="")
 	{

		$property_id	=	$_GET['edit_property'];
		$is_edit = 'yes';
		$post = get_post($property_id);
		$selected_title	=	$post->post_title;
		$selected_desc  = $post->post_content;
		// Retrieve an existing value from the database.
		$selected_type = get_post_meta( $property_id, 'prop_type', true );
		$selected_offer_type = get_post_meta( $property_id, 'prop_offer_type', true );
		$selected_offer_label = get_post_meta( $property_id, 'prop_offer_label', true );
		$selected_currency = get_post_meta( $property_id, 'prop_currecny_type', true );
		$selected_price = get_post_meta( $property_id, 'prop_first_price', true );
		$selected_price_optional = get_post_meta( $property_id, 'prop_second_price', true );
		$selected_pricelabel_before = get_post_meta( $property_id, 'prop_pricelabel_before', true );
		$selected_pricelabel_after = get_post_meta( $property_id, 'prop_pricelabel_after', true );
      //Feature Listing AdS
		 $featured_listings = get_user_meta(get_current_user_id(), 'prop_pack_featuredlistings', true);
      //print_r($featured_listings);
		$selected_area_size = get_post_meta( $property_id, 'prop_area_size', true );
		$selected_area_prefix = get_post_meta( $property_id, 'prop_area_prefix', true );
		$selected_land_area = get_post_meta( $property_id, 'prop_land_size', true );
		$selected_land_prefix = get_post_meta( $property_id, 'prop_land_prefix', true );
		$selected_beds = get_post_meta( $property_id, 'prop_beds_qty', true );
		$selected_baths = get_post_meta( $property_id, 'prop_baths_qty', true );
		$selected_garages = get_post_meta( $property_id, 'prop_garage_qty', true );
		$selected_years = get_post_meta( $property_id, 'prop_year_build', true );
		$selected_address = get_post_meta( $property_id, 'prop_street_addr', true );
		$selected_latt = get_post_meta( $property_id, 'prop_latt', true );
		$selected_long = get_post_meta( $property_id, 'prop_long', true );
		$selected_gallery = get_post_meta( $property_id, 'prop_gallery', true );

		$selected_reference = propertya_framework_get_options('property_opt_id');
		if(get_post_meta( $property_id, 'prop_refer', true ) !="")
		{
			$selected_reference = get_post_meta( $property_id, 'prop_refer', true );
		}
		$selected_zipcode = get_post_meta( $property_id, 'prop_zip', true );
		$selected_viewtype = get_post_meta( $property_id, 'prop_viewtype', true );
      // Feature Cheked
      $feature_checked = get_post_meta( $property_id, 'prop_is_feature_listing', true);

		$selected_plan = get_post_meta( $property_id, 'prop_is_plans', true );
		$selected_floor_plans = get_post_meta( $property_id, 'prop_floor_plans', true );
		//additional fields
		$selected_fields = get_post_meta( $property_id, 'prop_is_additional_fields', true );
		$selected_fields_data = get_post_meta( $property_id, 'prop_add_fields', true );
		//attachments
		$selected_attachments = get_post_meta( $property_id, 'prop_attachments', true );
	
		
		//video & 360
		$selected_video = get_post_meta( $property_id, 'prop_video', true );
		$selected_tour = get_post_meta( $property_id, 'prop_virtual_tour', true );
		$selected_location = get_post_meta( $property_id, 'prop_loc', true );
		//Amens
		$product_terms = wp_get_object_terms($property_id,  'property_feature' );
      if(class_exists('ACF'))
      {
         $selected_custom_data = propertya_framework_fields_by_listing_id($property_id);
         if(is_array($selected_custom_data) && !empty($selected_custom_data))
          {
            $custom_display = '';
            $fetch_custom_data = $selected_custom_data;
          }else{
            $custom_display = 'none';
          }
      }
		if ( ! empty( $product_terms ) )
		{
			if ( ! is_wp_error( $product_terms ) )
			{
				foreach( $product_terms as $term )
				{
					$amen_idz[] = intval( $term->term_id );
				}
			}
		}
	
	}
  
	else
	{
		 //create post
		 if (get_user_meta($user_id, 'prop_create_postid', true) != "")
		 {
      
			$property_id	=	get_user_meta($user_id, 'prop_create_postid', true);
			if ( 'draft' == get_post_status ( $property_id ) )
			{
        
         wp_trash_post($property_id);
				// /$property_id	=	$property_id;
         $mypost = array(
          'post_title' => '',
          'post_author'   => $user_id,
          'post_status'   => 'draft',
          'post_type'   => 'property'
         );
         $property_id =  wp_insert_post($mypost);
			}
			else
			{
				update_user_meta( $user_id, 'prop_create_postid', '');
				$mypost = array(
					'post_title' => '',
					'post_author'   => $user_id,
					'post_status'   => 'draft',
					'post_type' 	=> 'property'
				 );
				 $property_id =  wp_insert_post($mypost);
				 if($property_id)
				{
					$property_id	= $property_id;
					update_user_meta( $user_id, 'prop_create_postid', $property_id );
				}
			}
		 }
		 else
		 {
     
			 	$mypost = array(
					'post_title' => '',
					'post_author'   => $user_id,
					'post_status'   => 'draft',
					'post_type' 	=> 'property'
				 );
				$property_id =  wp_insert_post($mypost);
				if($property_id)
				{
					$property_id	= $property_id;
					update_user_meta( $user_id, 'prop_create_postid', $property_id );
				}
		 }
	}
	if( empty( $custom_ ) ) $custom_ = '';
	if( empty( $selected_type ) ) $selected_type = '';
	if( empty( $selected_offer_type ) ) $selected_offer_type = '';
	if( empty( $selected_offer_label ) ) $selected_offer_label = '';
	if( empty( $selected_currency ) ) $selected_currency = '';
	if( empty( $selected_price ) ) $selected_price = '';
	if( empty( $selected_price_optional ) ) $selected_price_optional = '';
	if( empty( $selected_pricelabel_before ) ) $selected_pricelabel_before = '';
	if( empty( $selected_pricelabel_after ) ) $selected_pricelabel_after = '';
	if( empty( $selected_area_size ) ) $selected_area_size = '';
	if( empty( $selected_area_prefix ) ) $selected_area_prefix = '';
	if( empty( $selected_land_area ) ) $selected_land_area = '';
	if( empty( $selected_land_prefix ) ) $selected_land_prefix = '';
	if( empty( $selected_beds ) ) $selected_beds = '';
	if( empty( $selected_baths ) ) $selected_baths = '';
	if( empty( $selected_garages ) ) $selected_garages = '';
	if( empty( $selected_years ) ) $selected_years = '';
	if( empty( $selected_address ) ) $selected_address = '';
	if( empty( $selected_latt ) ) $selected_latt = '';
	if( empty( $selected_long ) ) $selected_long = '';
	if( empty( $selected_gallery ) ) $selected_gallery = '';
	if( empty( $selected_zipcode ) ) $selected_zipcode = '';
	if( empty( $selected_viewtype ) ) $selected_viewtype = 'yes';
	if( empty( $selected_plan ) ) $selected_plan = '';
	if( empty( $selected_floor_plans ) ) $selected_floor_plans = '';
	if( empty( $selected_fields ) ) $selected_fields = '';
	if( empty( $selected_fields_data ) ) $selected_fields_data = '';
	if( empty( $selected_attachments ) ) $selected_attachments = '';
	if( empty( $selected_video ) ) $selected_video = '';
	if( empty( $selected_tour ) ) $selected_tour = '';
	if( empty( $selected_location ) ) $selected_location = '';
	$location_icon = $check_class = $my_id = '';
	if(propertya_strings('property_opt_enable_geo') == '1')
	{
		if(propertya_strings('property_opt_api_settings') == 'geo_ip' ||  propertya_strings('property_opt_api_settings') == 'ip_api')
		{
			$check_class = 'get-loc';
			$location_icon = '<i class="detect-me fas fa-location-arrow"></i>';
		}
	}
	//get currency
	$selected_cur = '';
    if(propertya_strings('prop_currency_mode') !="" && propertya_strings('prop_currency_mode') == 2)
    {
        $custom_currency = propertya_framework_term_fetch('property_currency',0);
        if(!empty($custom_currency) && count((array) $custom_currency) > 0 && !is_wp_error($custom_currency))
        {
            $p_currency_sym = $p_currency_code = $options = '';
            foreach($custom_currency as $currency)
            {
                $selected_cur = '';
                if(!empty($selected_currency) && $selected_currency == $currency->slug)
                {
                    $selected_cur = 'selected="selected"';
                }
                if(get_term_meta( $currency->term_id, 'p_currency_code', true ) !="")
                {
                    $p_currency_code = get_term_meta( $currency->term_id, 'p_currency_code', true );
                    $p_currency_sym = get_term_meta( $currency->term_id, 'p_currency_sym', true );
                    $options .= '<option value="' . $currency->slug. '" '.$selected_cur.'>' . $p_currency_code .' ( ' . $p_currency_sym . ' )'. '</option>';
                }
                else
                {
                    $options .= '<option value="' . $currency->slug. '" '.$selected_cur.'>' . $currency->name . '</option>';
                }
            }
        }	
    }
?>
<?php
$is_show = true;
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) && isset($propertya_options['prop_membership_type']) && $propertya_options['prop_membership_type'] == 'with-woo')
{
    if(get_user_meta($user_id, 'prop_user_package_id', true) !="")
    {
        $now = date('Y-m-d');
        //package expiry check
        if(get_user_meta($user_id, 'prop_pack_exp', true) !="")
        {
            //package expiry
            $expiry_date = get_user_meta($user_id, 'prop_pack_exp', true);
            $total_listings = get_user_meta($user_id, 'prop_pack_totallistings', true);
            if($total_listings == '-1' || $total_listings > 0)
            {
                if($expiry_date == '-1')
                {
                    $is_show = true;  
                }
                elseif ($now > $expiry_date)
                {
                     $is_show = false;
                     echo propertya_packages_notifications('expires');
                }
                else
                {
                    $is_show = true;
                }
            }
            else
            {
                $is_show = false;
                echo propertya_packages_notifications('listings');
            }
        }
    }
    else
    {
       $is_show = false; 
       echo propertya_packages_notifications('package');
    }
}
?>
<?php if($is_show == true) { ?>
<form class="my-form" name="prop_submission" method="POST" id="prop_submission">
   <div class="row">
      <div class="col-lg-8 col-xl-8 col-md-8 col-sm-12">
         <div class="form-posting-full">
            <div class="card">
               <div class="card-body">
                  <h4 class="card-title"><?php echo propertya_strings('prop_title_section'); ?></h4>
                  <div class="theme-row">
                     <label><?php echo propertya_strings('prop_field_title'); ?> *</label>
                     <span class="wrap">
                     <input type="text" data-sanitize="trim" name="prop-title" placeholder="<?php echo propertya_strings('prop_field_title_place'); ?>" value="<?php echo esc_attr($selected_title); ?>" class="form-control text" data-validation="required" data-validation-error-msg-required="<?php echo propertya_strings('prop_req_title'); ?>">
                     </span> 
                  </div>
                  <?php if($propertya_options['prop_show_hide_fields']['desc'] == 1) { ?>
                  <div class="theme-row">
                     <label for="message"><?php echo propertya_strings('prop_desc_field'); ?></label>
                     <span class="wrap"> 
                     <?php
                        wp_editor(  
                                stripslashes($selected_desc), 
                                'prop-desc', 
                                 array(
                                    'textarea_rows' =>  12,
                                    'textarea_name' =>  'prop-desc',
                                    'wpautop'       =>  true,
                                    'media_buttons' =>  false,
                                    'tabindex'      =>  '',
                                    'editor_css'    =>  '', 
                                    'editor_class'  => '', 
                                    'teeny'         => false, 
                                    'dfw'           => false, 
                                    'tinymce'       => true,
                                    'quicktags' => false
                                   ) 
                                );
                        ?>
                     </span>
                     <div class="clearfix"></div>
                  </div>
                  <?php } ?>

            <?php if($propertya_options['prop_show_hide_fields']['property_type'] == 1 || $propertya_options['prop_show_hide_fields']['offer_type'] == 1 ||  $propertya_options['prop_show_hide_fields']['property_label'] == 1 ) { ?>
               <h4 class="card-title"><?php echo propertya_strings('prop_type_section'); ?></h4>
               <?php if($propertya_options['prop_show_hide_fields']['property_type'] == 1) { ?>
                  <div class="theme-row">
                     <div class="prop1"></div>
                     <label for="e-mail"><?php echo propertya_strings('prop_property_type'); ?> *</label>
                     <span class="wrap">
                        <select class="theme-selects get_custom_field"  data-placeholder="<?php echo propertya_strings('property_type_place'); ?>" name="property-type" id="cat_parent" <?php if($propertya_options['prop_required_fields']['property_type'] == 1) {  ?> data-validation="required" data-validation-error-msg-required="<?php echo propertya_strings('prop_req_type'); ?>" <?php } ?>>
                           <?php propertya_framework_terms_options('property_type' , $selected_type); ?>
                        </select>
                     </span>
                  </div>
                 <?php } ?>
                 <?php if($propertya_options['prop_show_hide_fields']['offer_type'] == 1) { ?> 
                  <div class="theme-row">
                     <label for="e-mail"><?php echo propertya_strings('prop_offer_type'); ?></label>
                     <span class="wrap">
                        <select class="theme-selects" data-placeholder="<?php echo propertya_strings('prop_offer_type_place'); ?>" name="offer-type" <?php if($propertya_options['prop_required_fields']['offer_type'] == 1) {  ?> data-validation="required" data-validation-error-msg-required="<?php echo propertya_strings('prop_req_offer'); ?>" <?php } ?>>
                           <?php propertya_framework_terms_options('property_status' , $selected_offer_type); ?>
                        </select>
                     </span>
                  </div>
                  <?php } ?>
                  <?php if($propertya_options['prop_show_hide_fields']['property_label'] == 1) { ?>
                  <div class="theme-row">
                     <label for="e-mail"><?php echo propertya_strings('prop_status_type'); ?> </label>
                     <span class="wrap">
                        <select class="theme-selects"  data-placeholder="<?php echo propertya_strings('prop_status_type_place'); ?>" name="label-type" <?php if($propertya_options['prop_required_fields']['property_label'] == 1) {  ?> data-validation="required" data-validation-error-msg-required="<?php echo propertya_strings('prop_req_status'); ?>" <?php } ?>>
                          <?php propertya_framework_terms_options('property_label' , $selected_offer_label); ?>
                        </select>
                     </span>
                  </div>
                  <?php }
                  } ?>

               </div>
            </div>

            <?php if($propertya_options['prop_show_hide_fields']['prop_subcats'] == 1) { ?>
            <div class="card mx-custom-fields <?php echo esc_attr($custom_display); ?>" >
               <div class="card-body">
                  <h4 class="card-title"><?php echo propertya_strings('prop_customfields_section'); ?></h4>
                  <div class="row">
                     <div class="col-12">
                        <div id="dynamic-custom-fields">
                           <?php
                           
                             if($is_edit == 'yes' && $property_id!='' && class_exists('ACF'))
                             {
                                $custom_fields_html = apply_filters('propertya_framework_acf_frontend_html', '', $selected_custom_data);

                                echo $custom_fields_html ;
                                // echo propertya_strings('true', $custom_fields_html);
                             }
                            ?>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <?php } ?>
            <?php if($propertya_options['prop_show_hide_fields']['gallery'] == 1) { ?>
            <div class="card">
               <div class="card-body">
                  <h4 class="card-title"><?php echo propertya_strings('prop_gallery_section'); ?></h4>
                  <div class="row">
                     <div class="col-md-4 col-12">
                        <p class="theme-txt"><?php echo propertya_strings('prop_gallery_section_note'); ?></p>
                     </div>
                     <div class="col-md-8 col-12">
                     	
                         <div class="upload-btn-wrapper">
                        <button class="add-more-fields" id="button-id"><?php echo propertya_strings('prop_gallery_up_btn'); ?> </button>
                          <input id="gallery_files" type = "file" name ="files[]" accept = "image/*" class= "files-data form-control" multiple data-listing-id="<?php echo esc_attr($property_id) ?>" />
                           <input id="selected_imgz_idz" type="hidden" name="selected_imgz_idz" <?php if($propertya_options['prop_required_fields']['gallery'] == 1) {  ?> data-validation="required" data-validation-error-msg-required="<?php echo propertya_strings('prop_req_gallery'); ?>" <?php } ?> value="<?php echo esc_attr($selected_gallery); ?>" />
                        <div class="instruction">
                           <p class="theme-txt"><?php echo propertya_strings('prop_gallery_img_order'); ?></p>
                        </div>
                        
                        </div>
                        
                        <div class="temp_gallery_data"></div>
                        <span id="selected_imgz_html_render"><?php echo propertya_framework_prop_gallery($selected_gallery,$property_id);?></span>

                     </div>
                  </div>
               </div>
            </div>
            <?php } ?>
            <?php if($propertya_options['prop_show_hide_fields']['additional_fields'] == 1 || $propertya_options['prop_show_hide_fields']['property_area'] == 1 || $propertya_options['prop_show_hide_fields']['area_prefix'] == 1 || $propertya_options['prop_show_hide_fields']['land_area'] == 1 || $propertya_options['prop_show_hide_fields']['land_area_prefix'] == 1 || $propertya_options['prop_show_hide_fields']['bedrooms'] == 1 || $propertya_options['prop_show_hide_fields']['bathrooms'] == 1 || $propertya_options['prop_show_hide_fields']['grages'] == 1 || $propertya_options['prop_show_hide_fields']['yearbuild'] == 1) { ?>
            <div class="card">
               <div class="card-body">
                  <h4 class="card-title"><?php echo propertya_strings('prop_detail_section'); ?></h4>
                  <div class="row">


                     <?php if($propertya_options['prop_show_hide_fields']['property_area'] == 1) { ?>
                     <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="theme-row">
                           <label><?php echo propertya_strings('prop_a_size'); ?> <span class="meta"><?php echo propertya_strings('prop_a_size_hint'); ?></span></label>
                           <span class="wrap">
                           <input type="text" name="area-size" placeholder="<?php echo propertya_strings('prop_a_size_place'); ?>" value="<?php echo esc_attr($selected_area_size); ?>"  class="form-control text" <?php if($propertya_options['prop_required_fields']['property_area'] == 1) {  ?> data-validation="number" data-validation-allowing="number" data-validation-error-msg="<?php echo propertya_strings('prop_req_asize'); ?>" <?php } ?> />
                           </span> 
                        </div>
                     </div>
                     <?php } ?>
                     <?php if($propertya_options['prop_show_hide_fields']['area_prefix'] == 1) { ?>
                     <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="theme-row">
                           <label><?php echo propertya_strings('prop_a_prefix'); ?> <span class="meta"><?php echo propertya_strings('prop_a_prefix_hint'); ?></span></label>
                           <span class="wrap">
                           <input type="text" name="area-unit" value="<?php echo propertya_strings('prop_l_area_Size'); ?>" class="form-control text" <?php if($propertya_options['prop_required_fields']['area_prefix'] == 1) {  ?> data-validation="required" data-validation-error-msg-required="<?php echo propertya_strings('prop_req_asize_prefix'); ?>" <?php } ?> />
                           </span> 
                        </div>
                     </div>
                     <?php } ?>
                     <?php if($propertya_options['prop_show_hide_fields']['land_area'] == 1) { ?>
                     <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="theme-row">
                           <label><?php echo propertya_strings('prop_l_area'); ?> <span class="meta"><?php echo propertya_strings('prop_l_area_hint'); ?></span></label>
                           <span class="wrap">
                           <input type="text" name="land-area-size" placeholder="<?php echo propertya_strings('prop_l_area_place'); ?>" value="<?php echo esc_attr($selected_land_area); ?>"  class="form-control text" <?php if($propertya_options['prop_required_fields']['land_area'] == 1) {  ?> data-validation="number" data-validation-allowing="number" data-validation-error-msg="<?php echo propertya_strings('prop_req_lsize'); ?>" <?php } ?>/>
                           </span> 
                        </div>
                     </div>
                     <?php } ?>
                     <?php if($propertya_options['prop_show_hide_fields']['land_area_prefix'] == 1) { ?>
                     <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="theme-row">
                           <label><?php echo propertya_strings('prop_a_land_prefix'); ?> <span class="meta"><?php echo propertya_strings('prop_a_land_hint'); ?></span></label>
                           <span class="wrap">
                           <input type="text" name="land-area-unit" value="<?php echo propertya_strings('prop_l_area_Size'); ?>" class="form-control text" <?php if($propertya_options['prop_required_fields']['land_area_prefix'] == 1) {  ?> data-validation="required" data-validation-error-msg-required="<?php echo propertya_strings('prop_req_lsize_prefix'); ?>" <?php } ?>/>
                           </span> 
                        </div>
                     </div>
                     <?php } ?>
                     <?php if($propertya_options['prop_show_hide_fields']['bedrooms'] == 1) { ?>
                     <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="theme-row">
                           <label><?php echo propertya_strings('prop_a_bed_title'); ?> </label>
                           <span class="wrap">
                           <input type="text" name="prop-beds" placeholder="<?php echo propertya_strings('prop_a_bed_place'); ?>" value="<?php echo esc_attr($selected_beds); ?>"  class="form-control text" <?php if($propertya_options['prop_required_fields']['bedrooms'] == 1) {  ?> data-validation="number" data-validation-allowing="number" data-validation-error-msg="<?php echo propertya_strings('prop_req_bed'); ?>" <?php } ?>/>
                           </span> 
                        </div>
                     </div>
                     <?php } ?>
                     <?php if($propertya_options['prop_show_hide_fields']['bathrooms'] == 1) { ?>
                     <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="theme-row">
                           <label><?php echo propertya_strings('prop_a_bath_title'); ?></label>
                           <span class="wrap">
                           <input type="text" name="prop-baths" placeholder="<?php echo propertya_strings('prop_a_bath_place'); ?>" value="<?php echo esc_attr($selected_baths); ?>"  class="form-control text" <?php if($propertya_options['prop_required_fields']['bathrooms'] == 1) {  ?> data-validation="number" data-validation-allowing="number" data-validation-error-msg="<?php echo propertya_strings('prop_req_bath'); ?>" <?php } ?>/>
                           </span> 
                        </div>
                     </div>
                     <?php } ?>
                     <?php if($propertya_options['prop_show_hide_fields']['grages'] == 1) { ?>
                     <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="theme-row">
                           <label><?php echo propertya_strings('prop_a_grage_title'); ?></label>
                           <span class="wrap">
                           <input type="text" name="prop-grage" placeholder="<?php echo propertya_strings('prop_a_grage_place'); ?>" value="<?php echo esc_attr($selected_garages); ?>"  class="form-control text" <?php if($propertya_options['prop_required_fields']['grages'] == 1) {  ?> data-validation="number" data-validation-allowing="number"  data-validation-error-msg="<?php echo propertya_strings('prop_req_garages'); ?>" <?php } ?>>
                           </span> 
                        </div>
                     </div>
                     <?php } ?>
                     <?php if($propertya_options['prop_show_hide_fields']['yearbuild'] == 1) { ?>
                     <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="theme-row">
                           <label><?php echo propertya_strings('prop_a_year_title'); ?> </label>
                           <span class="wrap">
                           <input type="text" name="prop-build-year" placeholder="<?php echo propertya_strings('prop_a_year_place'); ?>" data-min-view="months" data-view="months" data-date-format="MM yyyy" value="<?php echo esc_attr($selected_years); ?>"  class="form-control prop-datepicker" <?php if($propertya_options['prop_required_fields']['yearbuild'] == 1) {  ?> data-validation="required" data-validation-error-msg-required="<?php echo propertya_strings('prop_req_built'); ?>" <?php } ?>/>
                           </span> 
                        </div>
                     </div>
                     <?php } ?>
                  </div>
               </div>
               <?php if($propertya_options['prop_show_hide_fields']['additional_fields'] == 1) { ?>
               <div class="card-body">
                  <h4 class="card-title"><?php echo propertya_strings('prop_addition_fields_section'); ?></h4>
                  <div class="theme-row">
                     <span class="wrap">
                        <select class="theme-selects add-features" name="addtional-fields">
                           <option value="disabled" <?php echo esc_html($selected_fields) == 'disabled' ? ' selected="selected"' : '';?>><?php echo esc_html__('Disabled','propertya');?></option>
                              <option value="enabled" <?php echo esc_html($selected_fields) == 'enabled' ? ' selected="selected"' : '';?>><?php echo esc_html__('Enabled','propertya');?></option>
                        </select>
                     </span>
                  </div>
                  <div id="generate_fields">
                 		<?php
                        $fadd_fields_data = '';
                        $fadd_fields_data = json_decode( stripslashes($selected_fields_data));
                        if(!empty($fadd_fields_data) && is_array($fadd_fields_data) && count($fadd_fields_data) > 0)
                        {
                            $check_field_length = 1;
							foreach($fadd_fields_data as $fields)
                            {
						?>						
                     	<div class="ad-fields" id="adf<?php echo esc_attr($check_field_length); ?>">
                        <div class="row ">
                           <div class="col-xl-5 col-lg-6 col-md-6 col-sm-12">
                              <div class="theme-row">
                                 <label><?php echo propertya_strings('prop_a_fields_title'); ?></label>
                                 <span class="wrap">
                                 <input type="text" name="additiona-fields-title[]" value="<?php echo esc_attr($fields->prop_add_key); ?>"  class="form-control text"/>
                                 </span> 
                              </div>
                           </div>
                           <div class="col-xl-5 col-lg-6 col-md-6 col-sm-12">
                              <div class="theme-row">
                                 <label><?php echo propertya_strings('prop_a_fields_value'); ?></label>
                                 <span class="wrap">
                                 <input type="text" name="additiona-fields-value[]" value="<?php echo esc_attr($fields->prop_add_val); ?>" class="form-control text"/>
                                 </span> 
                              </div>
                           </div>
                           <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 text-right">
                              <button type="button" class="square-btn mt-4 shuffle-fields info-z"><i class="fas fa-arrows-alt"></i></button>
                              <button type="button" class="square-btn mt-4 info-d" onclick="delete_field_row('adf<?php echo(esc_html($check_field_length));?>')"><i class="fas fa-times"></i></button> 
                           </div>
                        </div>
                     </div>
                       <?php
					   		$check_field_length++;
							}
						}
						else
						{
					  ?>
                      <div class="ad-fields" id="adf1">
                        <div class="row ">
                           <div class="col-xxl-5 col-xl-5 col-lg-4 col-md-6 col-sm-12">
                              <div class="theme-row">
                                 <label><?php echo propertya_strings('prop_a_fields_title'); ?></label>
                                 <span class="wrap">
                                 <input type="text" name="additiona-fields-title[]" value=""  class="form-control text"/>
                                 </span> 
                              </div>
                           </div>
                           <div class="col-xxl-5 col-xl-4 col-lg-4 col-md-6 col-sm-12">
                              <div class="theme-row">
                                 <label><?php echo propertya_strings('prop_a_fields_value'); ?></label>
                                 <span class="wrap">
                                 <input type="text" name="additiona-fields-value[]" value="" class="form-control text"/>
                                 </span> 
                              </div>
                           </div>
                           <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 col-sm-12 text-right">
                              <button type="button" class="square-btn mt-5 shuffle-fields info-z"><i class="fas fa-arrows-alt"></i></button>
                              <button type="button" class="square-btn mt-5 info-d" onclick="delete_field_row('adf1')"><i class="fas fa-times"></i></button> 
                           </div>
                        </div>
                     </div>
                     <?php
						}
					 ?>
                  </div>
                  <input type="button" class="add-more-fields btn-add" onclick="return add_fields();" value="<?php echo propertya_strings('prop_a_fields_btn'); ?>">
                  <input type="hidden" name="sortable_idz" id="sortable_idz" value="" /> 
               </div>
               <?php } ?>
            </div>
            <?php } ?>
            <?php if($propertya_options['prop_show_hide_fields']['amenities'] == 1) { ?>
            <div class="card">
               <div class="card-body">
                  <h4 class="card-title"><?php echo propertya_strings('prop_ammen_section'); ?></h4>
                  <div class="amen-features">
                  <?php
				     $amenz = propertya_framework_term_fetch('property_feature');
					 if(is_array($amenz) && count($amenz) > 0)
					 {
						 foreach($amenz as $amen)
						 {
							 if ( in_array( $amen->term_id, $amen_idz ) )
							 {
				  ?>
                  			 <div class="custom_checkbox">
                             
                                <div class="pretty p-default">
                                    <input type="checkbox" value="<?php echo esc_attr($amen->slug); ?>" name="prop-amens[]" id="<?php echo esc_attr($amen->term_id); ?>" checked  />
                                    <div class="state p-primary">
                                        <label for="<?php echo esc_attr($amen->term_id); ?>"><?php echo esc_html($amen->name); ?></label> 
                                    </div>
                                </div>
                             </div>
                  <?php
							 }
							 else
							 {
							 ?>
                             <div class="custom_checkbox">
                             <div class="pretty p-default">
                                    <input type="checkbox" value="<?php echo esc_attr($amen->slug); ?>" name="prop-amens[]" id="<?php echo esc_attr($amen->term_id); ?>"/>
                                    <div class="state p-primary">
                                        <label for="<?php echo esc_attr($amen->term_id); ?>"><?php echo esc_html($amen->name); ?></label> 
                                    </div>
                                </div>
                             </div>
                             <?php
							 }
							 ?>
                  <?php
						 }
					 }
				  ?>
                  </div>
               </div>
            </div>
            <?php } ?>
            <?php if($propertya_options['prop_show_hide_fields']['street_location'] == 1 || $propertya_options['prop_show_hide_fields']['map'] == 1 || $propertya_options['prop_show_hide_fields']['coordinates'] == 1 || $propertya_options['prop_show_hide_fields']['zip_code'] == 1 || $propertya_options['prop_show_hide_fields']['location'] == 1) { ?>
            <div class="card">
               <div class="card-body">
                  <h4 class="card-title"><?php echo propertya_strings('prop_loc_section'); ?></h4>
                  <?php if($propertya_options['prop_show_hide_fields']['street_location'] == 1) { ?>
                  <div class="theme-row get-loc">
                     <label><?php echo propertya_strings('prop_addr_field_txt'); ?></label>
                     <span class="wrap">
                     <input type="text" name="property-address" id="property_address" placeholder="<?php echo propertya_strings('prop_addr_field_place'); ?>" value="<?php echo esc_attr($selected_address); ?>"  class="form-control text" <?php if($propertya_options['prop_required_fields']['street_location'] == 1) {  ?> data-validation="required" data-validation-error-msg-required="<?php echo propertya_strings('prop_req_street_addr'); ?>" <?php } ?>/>
                     <?php echo ''.($location_icon); ?>
                     </span> 
                  </div>
                  <?php } ?>
                  <div class="row">
                 	 <?php if($propertya_options['prop_show_hide_fields']['map'] == 1 && propertya_strings('property_opt_enable_map') == '1') { ?>
                     <div class="col-md-8">
                     	<div class="submit-propert-map">
                            <div id="property_map"></div>
                        </div>
                     </div>
                     <div class="col-md-4 submit-propert-cord">
                        <div class="theme-row">
                           <label><?php echo propertya_strings('prop_addr_coordinates'); ?></label>
                           <span class="wrap">
                           	<input type="text" name="property-latt" id="property_latt" placeholder="<?php echo propertya_strings('prop_addr_latt'); ?>" value="<?php echo esc_attr($selected_latt); ?>" class="form-control text" <?php if($propertya_options['prop_required_fields']['coordinates'] == 1) {  ?> data-validation="required" data-validation-error-msg-required="<?php echo propertya_strings('prop_req_street_coord'); ?>" <?php } ?>/>
                           </span> 
                        </div>
                        <br>
                        <div class="theme-row">
                           <span class="wrap">
                           <input type="text" name="property-long" id="property_long" placeholder="<?php echo propertya_strings('prop_addr_long'); ?>" value="<?php echo esc_attr($selected_long); ?>" class="form-control text" <?php if($propertya_options['prop_required_fields']['coordinates'] == 1) {  ?> data-validation="required" data-validation-error-msg-required="<?php echo propertya_strings('prop_req_street_coord'); ?>" <?php } ?>/>
                           </span> 
                        </div>
                     </div>
 					<?php } ?>
                  </div>
                  <div class="row">
                     <?php if($propertya_options['prop_show_hide_fields']['zip_code'] == 1) { ?>
                     <div class="col-md-6">
                        <div class="theme-row">
                           <label><?php echo propertya_strings('prop_addr_zip'); ?></label>
                           <span class="wrap">
                           <input type="text" name="prop-zip" placeholder="<?php echo propertya_strings('prop_addr_zip_place'); ?>" value="<?php echo esc_attr($selected_zipcode); ?>"  class="form-control text" <?php if($propertya_options['prop_required_fields']['zip_code'] == 1) {  ?> data-validation="required" data-validation-error-msg-required="<?php echo propertya_strings('prop_req_zipcode'); ?>" <?php } ?> />
                           </span> 
                        </div>
                     </div>
                     <?php } ?>
                     <?php if($propertya_options['prop_show_hide_fields']['location'] == 1) { ?>
                     <div class="col-md-6">
                        <div class="theme-row">
                           <label><?php echo propertya_strings('prop_addr_country'); ?> </label>
                           <span class="wrap">
                              <select class="theme-selects"  data-placeholder="<?php echo propertya_strings('prop_addr_country_place'); ?>" name="property-location" <?php if($propertya_options['prop_required_fields']['location'] == 1) {  ?> data-validation="required" data-validation-error-msg-required="<?php echo propertya_strings('prop_req_custom_location'); ?>" <?php } ?>>
                                 <?php propertya_framework_terms_options('property_location' , $selected_location); ?>
                              </select>
                           </span>
                        </div>
                     </div>
                     <?php } ?>
                  </div>
               </div>
            </div>
            <?php } ?>
            <?php if($propertya_options['prop_show_hide_fields']['floorplan'] == 1) { ?>
            <div class="card">
               <div class="card-body">
                  <h4 class="card-title"><?php echo propertya_strings('prop_fplan_section'); ?></h4>
                  <div class="theme-row">
                     <span class="wrap">
                        <select class="theme-selects add-features" id="is-plan" name="is-plan">
                           <option value="disabled" <?php echo esc_attr($selected_plan) == 'disabled' ? ' selected="selected"' : '';?>><?php echo esc_html__('Disabled','propertya');?></option>
                              <option value="enabled" <?php echo esc_attr($selected_plan) == 'enabled' ? ' selected="selected"' : '';?>><?php echo esc_html__('Enabled','propertya');?></option>
                        </select>
                     </span>
                  </div>
                  <div id="f_plans">
                  <?php 
					$floor_plan_data = '';
					$floor_plan_data = json_decode( stripslashes( $selected_floor_plans) );
					if(!empty($floor_plan_data) && is_array($floor_plan_data) && count($floor_plan_data) > 0)
					{
						$check_length = 1;
						foreach($floor_plan_data as $plan)
						{
					?>
                     <div class="flor-plans" id="row<?php echo esc_attr($check_length); ?>">
                        <div class="row">
                           <div class="col-xl-12">
                              <div class="theme-row">
                                 <label><?php echo propertya_strings('prop_fplan_title'); ?></label>
                                 <span class="wrap">
                                 <input type="text" placeholder="<?php echo propertya_strings('prop_fplan_title_place'); ?>" class="form-control" name="flr-name[]" value="<?php echo esc_attr($plan->prop_floor_name); ?>">
                                 </span> 
                              </div>
                           </div>
                           <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                              <div class="theme-row">
                                 <label><?php echo propertya_strings('prop_fplan_price'); ?></label>
                                 <span class="wrap">
                                 <input type="text" placeholder="<?php echo propertya_strings('prop_fplan_price_place'); ?>" class="form-control" name="flr-price[]" value="<?php echo esc_attr($plan->prop_floor_price); ?>">
                                 </span> 
                              </div>
                           </div>
                           <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                              <div class="theme-row">
                                 <label><?php echo propertya_strings('prop_fplan_priceprefix_title'); ?></label>
                                 <span class="wrap">
                                 <input type="text" placeholder="<?php echo propertya_strings('prop_fplan_priceprefix_place'); ?>" class="form-control" name="flr-price-postfix[]" value="<?php echo esc_attr($plan->prop_floor_pprefix); ?>">
                                 </span>
                              </div>
                           </div>
                           <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                              <div class="theme-row">
                                 <label><?php echo propertya_strings('prop_fplan_size_title'); ?></label>
                                 <span class="wrap">
                                 <input placeholder="<?php echo propertya_strings('prop_fplan_size_place'); ?>" type="text" class="form-control"  name="flr-size[]" value="<?php echo esc_attr($plan->prop_floor_size); ?>">
                                 </span>
                              </div>
                           </div>
                           <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                              <div class="theme-row">
                                 <label><?php echo propertya_strings('prop_fplan_sizepost_title'); ?></label>
                                 <span class="wrap">
                                 <input type="text" placeholder="<?php echo propertya_strings('prop_fplan_sizepost_place'); ?>" class="form-control" name="flr-size-postfix[]" value="<?php echo esc_attr($plan->prop_floor_sprefix); ?>">
                                 </span>
                              </div>
                           </div>
                           <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                              <div class="theme-row">
                                 <label><?php echo propertya_strings('prop_fplan_bed_title'); ?></label>
                                 <span class="wrap">
                                 <input type="text" placeholder="<?php echo propertya_strings('prop_fplan_bed_place'); ?>" class="form-control" name="flr-beds[]" value="<?php echo esc_attr($plan->prop_floor_beds); ?>">
                                 </span>
                              </div>
                           </div>
                           <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                              <div class="theme-row">
                                 <label><?php echo propertya_strings('prop_fplan_bath_title'); ?></label>
                                 <span class="wrap">
                                 <input type="text" placeholder="<?php echo propertya_strings('prop_fplan_bath_place'); ?>" class="form-control" name="flr-baths[]" value="<?php echo esc_attr($plan->prop_floor_baths); ?>">
                                 </span>
                              </div>
                           </div>
                           <div class="col-xl-12">
                              <div class="theme-row">
                                 <label><?php echo propertya_strings('prop_fplan_desc_title'); ?></label>
                                 <span class="wrap">
                                 <textarea cols="30" class="form-control" rows="2"  name="flr-desc[]"><?php echo esc_textarea($plan->prop_floor_desc); ?></textarea>
                                 </span>
                              </div>
                           </div>
                           <div class="col-xl-12">
                              <div class="theme-row my-floor-plans">
                                 <label><?php echo propertya_strings('prop_fplan_image_title'); ?></label>
                                 
                                 <div class="floor-plan-avatar-upload">
                                   <?php
									 $show_delete = $image_id = $display_class= $plan_images = $delete_btn = $img_url = $thumb = $plan_img_id = '';
									if(!empty($plan->prop_floor_img_id))
									{
									   $plan_img_id = $plan->prop_floor_img_id;
									   if(wp_attachment_is_image($plan_img_id))
									   {
										   $thumb = wp_get_attachment_image_src($plan_img_id, 'propertya-user-thumb');
										   $img_url = $thumb[0];
										  
									   }
									   else
									   {
										  $plan_img_id =''; 
									   }
									   $display_class= 'show-me-plnimg';
									}
									 $show_delete = '';
									if(!empty($plan_img_id))
									{
										 $show_delete = '<span class="flr-plb-btn-cncle show_del_plan_'.esc_attr($check_length).' flp-del '.esc_attr($display_class).'" data-delflr-id="'.esc_attr($plan_img_id).'" data-imgplan="'.esc_attr($check_length).'" data-toggle="tooltip" data-original-title="'.esc_attr__('Delete Plan Image','propertya').'"><i class="fa fa-times"></i></span>';
									}
									
									
									?>
                                 
                                    <div class="floor-plan-avatar-edit">
                                        <input type='file' id="active_imgid_<?php echo esc_attr($check_length); ?>"  class="floorplan_btn_click" accept=".png, .jpg, .jpeg" data-activeplan="<?php echo esc_attr($check_length); ?>" data-property-id="<?php echo esc_attr($property_id); ?>" />
                                        <label for="active_imgid_<?php echo esc_attr($check_length); ?>" data-toggle="tooltip" data-original-title="<?php echo esc_attr__('Select Plan Image','propertya'); ?>" ></label>
                                        <input type="hidden" id="flor_uploaded_<?php echo esc_attr($check_length); ?>" name="floorplan_image_id[]" value="<?php echo esc_attr($plan_img_id); ?>">
                                    </div>
                                    <div class="avatar-preview">
                                        <div class="florplan-temp-loader florplan-pre-<?php echo esc_attr($check_length); ?> none"><i class="fas fa-spinner fa-spin"></i></div>
                                        <div><img id="plan_image_src_<?php echo esc_attr($check_length); ?>" src="<?php echo esc_url($img_url); ?>" class="img-fluid" alt="<?php echo esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', TRUE)); ?>"></div>
                                        <?php echo ' '.$show_delete; ?>
                                       
                                    </div>
                                </div>
                                 
                              </div>
                              
                              <input type="button" class="add-more-fields btn-remove" value="<?php echo propertya_strings('prop_fplan_del_btn'); ?>" onclick="delete_row('row<?php echo(esc_html($check_length));?>');">
                           </div>
                        </div>
                     </div>
                     <?php
						 $check_length++;
						}
					}
					else
					{
						$image_id = '';
					?>
                      <div class="flor-plans" id="row1">
                        <div class="row">
                           <div class="col-xl-12">
                              <div class="theme-row">
                                 <label><?php echo propertya_strings('prop_fplan_title'); ?></label>
                                 <span class="wrap">
                                 <input type="text" placeholder="<?php echo propertya_strings('prop_fplan_title_place'); ?>" class="form-control" name="flr-name[]" value="<?php  echo $propertya_options['prop_floor_name']; ?>">
                                 </span> 
                              </div>
                           </div>
                           <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                              <div class="theme-row">
                                 <label><?php echo propertya_strings('prop_fplan_price'); ?></label>
                                 <span class="wrap">
                                 <input type="text" placeholder="<?php echo propertya_strings('prop_fplan_price_place'); ?>" class="form-control" name="flr-price[]" value="<?php  echo $propertya_options['prop_floor_price']; ?>">
                                 </span> 
                              </div>
                           </div>
                           <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                              <div class="theme-row">
                                 <label><?php echo propertya_strings('prop_fplan_priceprefix_title'); ?></label>
                                 <span class="wrap">
                                 <input type="text" placeholder="<?php echo propertya_strings('prop_fplan_priceprefix_place'); ?>" class="form-control" name="flr-price-postfix[]" value="<?php  echo $propertya_options['prop_price_postfix']; ?>" >
                                 </span>
                              </div>
                           </div>
                           <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                              <div class="theme-row">
                                 <label><?php echo propertya_strings('prop_fplan_size_title'); ?></label>
                                 <span class="wrap">
                                 <input placeholder="<?php echo propertya_strings('prop_fplan_size_place'); ?>" type="text" class="form-control"  name="flr-size[]" value="<?php  echo $propertya_options['prop_floor_size']; ?>">
                                 </span>
                              </div>
                           </div>
                           <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                              <div class="theme-row">
                                 <label><?php echo propertya_strings('prop_fplan_sizepost_title'); ?></label>
                                 <span class="wrap">
                                 <input type="text" placeholder="<?php echo propertya_strings('prop_fplan_sizepost_place'); ?>" class="form-control" name="flr-size-postfix[]" value="<?php  echo $propertya_options['prop_size_postfix']; ?>">
                                 </span>
                              </div>
                           </div>
                           <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                              <div class="theme-row">
                                 <label><?php echo propertya_strings('prop_fplan_bed_title'); ?></label>
                                 <span class="wrap">
                                 <input type="text" placeholder="<?php echo propertya_strings('prop_fplan_bed_place'); ?>" class="form-control" name="flr-beds[]" value="<?php  echo $propertya_options['prop_floor_bed']; ?>">
                                 </span>
                              </div>
                           </div>
                           <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                              <div class="theme-row">
                                 <label><?php echo propertya_strings('prop_fplan_bath_title'); ?></label>
                                 <span class="wrap">
                                 <input type="text" placeholder="<?php echo propertya_strings('prop_fplan_bath_place'); ?>" class="form-control" name="flr-baths[]" value="<?php  echo $propertya_options['prop_floor_bath']; ?>">
                                 </span>
                              </div>
                           </div>
                           <div class="col-xl-12">
                              <div class="theme-row">
                                 <label><?php echo propertya_strings('prop_fplan_desc_title'); ?></label>
                                 <span class="wrap">
                                 <textarea cols="30" class="form-control" rows="4" name="flr-desc[]"></textarea>
                                 </span>
                              </div>
                           </div>
                           <div class="col-xl-12">
                              <div class="theme-row my-floor-plans">
                                 <label><?php echo propertya_strings('prop_fplan_image_title'); ?></label>
                                 
                                 
                               <div class="floor-plan-avatar-upload">
                                    <div class="floor-plan-avatar-edit">
                                        <input type='file' id="active_imgid_1"  class="floorplan_btn_click" accept=".png, .jpg, .jpeg" data-activeplan="1" data-property-id="<?php echo esc_attr($property_id); ?>" />
                                        <label for="active_imgid_1" data-toggle="tooltip" data-original-title="<?php echo esc_attr__('Select Plan Image','propertya'); ?>" ></label>
                                        <input type="hidden" id="flor_uploaded_1" name="floorplan_image_id[]" value="">
                                    </div>
                                    <div class="avatar-preview">
                                        <div class="florplan-temp-loader florplan-pre-1 none"><i class="fas fa-spinner fa-spin"></i></div>
                                        <div><img id="plan_image_src_1" src="" class="img-fluid" alt="<?php echo esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', TRUE)); ?>"></div>
                                        
                                        <span class="flr-plb-btn-cncle show_del_plan_1 flp-del" data-delflr-id="" data-imgplan="1" data-toggle="tooltip" data-original-title="<?php echo esc_attr__('Delete Plan Image','propertya'); ?>">
                                        <i class="fa fa-times"></i>
                                    </span>
                                        
                                    </div>
                                </div>
                                 
                                 
                              </div>
                           </div>
                        </div>
                     </div>
                    <?php
					}
					?>
                  </div>
                  <input type="button" class="add-more-fields btn-add" onclick="add_row();" value="<?php echo propertya_strings('prop_fplan_admore'); ?>">
               </div>
            </div>
            <?php } ?>
            <?php if($propertya_options['prop_show_hide_fields']['video'] == 1 || $propertya_options['prop_show_hide_fields']['virtual_tour'] == 1) { ?>
            <div class="card">
               <div class="card-body">
                  <h4 class="card-title"><?php echo propertya_strings('prop_video_section'); ?></h4>
                  <?php if($propertya_options['prop_show_hide_fields']['video'] == 1) { ?>
                  <div class="theme-row">
                     <label><?php echo propertya_strings('prop_a_video_title'); ?></label>
                     <span class="wrap">
                     <input type="text" name="video-url" placeholder="<?php echo propertya_strings('prop_a_video_place'); ?>" class="form-control text" <?php if($propertya_options['prop_required_fields']['video'] == 1) {  ?> data-validation="url" data-validation-error-msg="<?php echo propertya_strings('prop_req_video'); ?>" <?php } ?> value="<?php echo esc_url($selected_video); ?>">
                     </span>
                  </div>
                  <?php } ?>
                  <?php if($propertya_options['prop_show_hide_fields']['virtual_tour'] == 1) { ?>
                  <div class="theme-row">
                     <label><?php echo propertya_strings('prop_v_tour_title'); ?></label>
                     <span class="wrap">
                     <textarea cols="30" name="virtual-tour" class="form-control" placeholder="<?php echo propertya_strings('prop_v_tour_place'); ?>" rows="2" <?php if($propertya_options['prop_required_fields']['virtual_tour'] == 1) {  ?> data-validation="required" data-validation-error-msg-required="<?php echo propertya_strings('prop_req_tour'); ?>" <?php } ?>><?php echo esc_html($selected_tour); ?></textarea>
                     </span>
                  </div>
                  <?php } ?>
               </div>
            </div>
            <?php } ?>
            <?php if($propertya_options['prop_show_hide_fields']['attachments'] == 1) { ?>
            <div class="card">
               <div class="card-body">
                  <h4 class="card-title"><?php echo propertya_strings('prop_attach_section'); ?></h4>
                  <div class="row">
                     <div class="col-md-4">
                        <p class="theme-txt"><?php echo propertya_strings('prop_attach_section_note'); ?></p>
                     </div>
                     <div class="col-md-8">   
                        
                    <div class="upload-btn-wrapper">
                        <button class="add-more-fields" type="button"><?php echo propertya_strings('prop_attach_btn'); ?></button>
                        <input type="file" id="services_attachments" multiple name="services_attachments[]" accept= "application/pdf,image/jpeg, image/png, image/gif,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" data-property-id="<?php echo esc_attr($property_id) ?>"/>
                       <input id="selected_attach_idz" type="hidden" name="selected_attach_idz" <?php if($propertya_options['prop_required_fields']['attachments'] == 1) {  ?> data-validation="required" data-validation-error-msg-required="<?php echo propertya_strings('prop_req_attach'); ?>" <?php } ?> value="<?php echo esc_attr($selected_attachments); ?>" />
                    </div>
                    	<div class="temp_attachemts_data"></div>
                     	<span id="selected_attach_html_render"><?php echo propertya_framework_prop_attachments($selected_attachments,$property_id);?></span>
                     </div>
                  </div>
               </div>
            </div>
            <?php } ?>
            
            <?php
			if(get_user_meta($user_id, 'user_role_type', true) !="" && get_user_meta($user_id, 'user_role_type', true) =="agenccy")
			{
?>
            <div class="card assign-listing">
               <div class="card-body">
                  <h4 class="card-title"><?php echo propertya_strings('prop_contact_section'); ?></h4>
                  <h5>Do you want to assign this listing to your agents? </h5>
                  <div class="custom_radios">
                  
                   <div class="pretty p-default p-curve">
                        <input type="radio" name="assign-listing" checked value="0" autocomplete="off" />
                        <div class="state p-primary-o">
                            <label>No</label>
                        </div>
                    </div>
                  </div>
                  <div class="custom_radios">
                    <div class="pretty p-default p-curve">
                        <input type="radio" name="assign-listing"  value="1" autocomplete="off"/>
                        <div class="state p-primary-o">
                            <label>Yes (Choose agent from the list below)</label>
                        </div>
                    </div>
                  </div>
                  <div class="theme-row sel-agent none">
                     <label for="e-mail">Select Agent</label>
                     <span class="wrap">
                        <select class="theme-selects just-agent" data-placeholder="Select From Agents" data-validation="" name="select_agent"  data-validation-error-msg="No image selected">
                           <option value="" autocomplete="off">Select Agent</option>
                           <?php echo propertya_get_agent_agency($user_id); ?>
                        </select>
                     </span>
                  </div>
               </div>
            </div>
            <?php
			}
			?>
         </div>
      </div>
      <div class="col-lg-4 col-xl-4 col-md-4 col-sm-12">
         <div class="grid-margin">
            <div class="card">
               <?php if($propertya_options['prop_show_hide_fields']['currecny_type'] == 1 || $propertya_options['prop_show_hide_fields']['property_price'] == 1 || $propertya_options['prop_show_hide_fields']['snd_price'] == 1 || $propertya_options['prop_show_hide_fields']['after_price'] == 1 || $propertya_options['prop_show_hide_fields']['before_price'] == 1) { ?>
               <div class="card-panel">
                  <h4 class="card-title"><?php echo propertya_strings('prop_price_section'); ?></h4>
               </div>
               <div class="card-body">
                  <?php if(propertya_strings('prop_currency_mode') !="" && propertya_strings('prop_currency_mode') == 2) { ?>   
               	  <?php if($propertya_options['prop_show_hide_fields']['currecny_type'] == 1) { ?>
                  <div class="theme-row">
                     <label for="e-mail"> <?php echo propertya_strings('prop_curr_type'); ?> </label>
                     <span class="wrap">
                        <select class="theme-selects"  data-placeholder="<?php echo propertya_strings('prop_curr_type_place'); ?>" name="currency-type" <?php if($propertya_options['prop_required_fields']['currecny_type'] == 1) {  ?> data-validation="required" data-validation-error-msg-required="<?php echo propertya_strings('prop_req_currency'); ?>" <?php } ?>>
                           <option value=""><?php echo esc_html__('Select an option','propertya'); ?></option>
            			   <?php echo ''.($options); ?>
                        </select>
                     </span>
                  </div>
                  <?php } ?>
                  <?php } ?>
                  <?php if($propertya_options['prop_show_hide_fields']['property_price'] == 1) { ?>
                  <div class="theme-row">
                     <label for="e-mail"><?php echo propertya_strings('prop_pri_type'); ?> <span class="meta"><?php echo propertya_strings('prop_pri_type_hint'); ?></span></label>
                     <span class="wrap">
                     <input type="text" name="first-price"  value="<?php echo esc_attr($selected_price); ?>"  class="form-control text" <?php if($propertya_options['prop_required_fields']['property_price'] == 1) {  ?> data-validation="number" data-validation-allowing="number" data-validation-error-msg="<?php echo propertya_strings('prop_req_price'); ?>" <?php } ?>/>
                     </span>
                  </div>
                  <?php } ?>
                  <?php if($propertya_options['prop_show_hide_fields']['snd_price'] == 1) { ?>
                  <div class="theme-row">
                     <label for="e-mail"><?php echo propertya_strings('prop_second_type'); ?> <span class="meta"><?php echo propertya_strings('prop_second_type_hint'); ?></span></label>
                     <span class="wrap">
                     <input type="text" name="second-price-opt" value="<?php echo esc_attr($selected_price_optional); ?>"  class="form-control text" <?php if($propertya_options['prop_required_fields']['snd_price'] == 1) {  ?> data-validation="number" data-validation-allowing="number" data-validation-error-msg="<?php echo propertya_strings('prop_req_second'); ?>" <?php } ?>/>
                     </span>
                  </div>
                  <?php } ?>
                  <?php if($propertya_options['prop_show_hide_fields']['after_price'] == 1) { ?>
                  <div class="theme-row">
                     <label for="e-mail"><?php echo propertya_strings('prop_after_type'); ?> <span class="meta"><?php echo propertya_strings('prop_after_hint'); ?></span></label>
                     <span class="wraps">
                     <input type="text" name="after-price-lbl" value="<?php echo esc_attr($selected_pricelabel_after); ?>"  class="form-control text" <?php if($propertya_options['prop_required_fields']['after_price'] == 1) {  ?> data-validation="custom" data-validation-regexp="[a-zA-Z]+" data-validation-error-msg="<?php echo propertya_strings('prop_req_after'); ?>" <?php } ?>/>
                     </span>
                  </div>
                  <?php } ?>
               </div>
               <?php } ?>
            </div>
         </div>
         <div class="for-sp card is-sticky position-sticky">
               <div class="card-body">
                  <h4 class="card-title"><?php echo esc_html__('Listing Settings','propertya');?> </h4>
                  <div class="">
                     <?php

                      if(($featured_listings > 0) || ($feature_checked > 0) || ($featured_listings == -1 )){ ?>
                      <div class="custom_radioss">
                       <div class="pretty p-default p-curve">
                             <input type="checkbox" name="is-featured"  autocomplete="off" <?php checked('1',$feature_checked, true); ?> />
                            <div class="state p-primary-o">
                                <label><?php echo esc_html__('Mark This Listing As Featured!','propertya');?></label>
                            </div>
                        </div>
                      </div>
                   <?php }else{?>
                      <div class="custom_radioss">
                       <div class="pretty p-default p-curve">
                       <p class="feature_list">  <?php echo "Your Feature Listing are finished." ?></p>
                       </div>
                       </div>


                 <?php  } ?>



                      <div class="custom_radioss">
                       <div class="pretty p-default p-curve">
                             <input type="radio" name="is-logged" value="yes" autocomplete="off" <?php checked('yes',$selected_viewtype, true); ?> />
                            <div class="state p-primary-o">
                                <label><?php echo esc_html__('Yes (Anyone can view my listing)','propertya');?></label>
                            </div>
                        </div>
                      </div>
                      <div class="custom_radioss">
                        <div class="pretty p-default p-curve">
                            <input type="radio" name="is-logged" value="no" <?php checked('no',$selected_viewtype, true); ?>/>
                            <div class="state p-primary-o">
                                <label><?php echo esc_html__('No (Only logged in user can view)','propertya');?></label>
                            </div>
                        </div>
                      </div>
                  </div>
                  <button type="submit" class="btn btn-theme btn-block sonu-button"><?php echo propertya_strings('prop_form_submission_btn'); ?>
               </div>
            </div>
      </div>
   </div>
   <?php wp_nonce_field( 'prop-submission-nonce', 'prop_nonce' ); ?>
   <input type="hidden" name="property_id" id="property_id" value="<?php echo esc_attr($property_id); ?>">
   <input type="hidden" name="is_edit" id="is_edit" value="<?php echo esc_attr($is_edit); ?>">
   <button type="submit" class="btn btn-theme btn-primary "><?php echo propertya_strings('prop_form_submission_btn'); ?></button>  
</form>
<?php } ?>    