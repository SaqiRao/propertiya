<?php
if(in_array('advanced-custom-fields/acf.php', apply_filters('active_plugins', get_option('active_plugins'))) && class_exists('ACF'))
	{
		// Ajax handler for property submission
		add_filter( 'acf/save_post', 'acf_clear_object_cache' );

		/**
		 * Intended to clear a post's cache
		 */
		function acf_clear_object_cache( $post_id ) {
			if ( empty( $_POST['acf'] ) ) {
				return;
			}
			
			// clear post related cache
			clean_post_cache( $post_id );
			
			// clear ACF cache
			$acf_cache_cleared = wp_cache_delete( 'acf-post', 'acf' );
			
			// clear all cache if no specific key/group is found
			if ( !$acf_cache_cleared ) {
				wp_cache_flush();
			}
		}
	}


add_action( 'wp_ajax_prop_submission', 'propertya_framework_prop_submission' );

if (!function_exists ( 'propertya_framework_prop_submission' ))
{
	function propertya_framework_prop_submission()
	{
		$params = array();
		$property_id = '';
		parse_str($_POST['collect_data'], $params);
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin( get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		if(!wp_verify_nonce($params['prop_nonce'], 'prop-submission-nonce'))
		{
			 $return = array('message' => esc_html__('Invalid security token sent.', 'propertya-framework'));
      		 wp_send_json_error($return);
   		}
		else
		{
			//sanatize fields
			$selected_title = isset( $params[ 'prop-title' ] ) ? sanitize_text_field( $params[ 'prop-title' ] ) : '';
			$selected_desc = isset( $params[ 'prop-desc' ] ) ? wp_kses_post( $params[ 'prop-desc' ] ) : '';
			$selected_type = isset( $params[ 'property-type' ] ) ? sanitize_text_field( $params[ 'property-type' ] ) : '';
			$selected_offer_type = isset( $params[ 'offer-type' ] ) ? sanitize_text_field( $params[ 'offer-type' ] ) : '';
			$selected_offer_label = isset( $params[ 'label-type' ] ) ? sanitize_text_field( $params[ 'label-type' ] ) : '';
			$selected_currency = isset( $params[ 'currency-type' ] ) ? sanitize_text_field( $params[ 'currency-type' ] ) : '';
			$selected_price = isset( $params[ 'first-price' ] ) ? sanitize_text_field( $params[ 'first-price' ] ) : '';
			$selected_price_optional = isset( $params[ 'second-price-opt' ] ) ? sanitize_text_field( $params[ 'second-price-opt' ] ) : '';
			$selected_pricelabel_before = isset( $params[ 'before-price-lbl' ] ) ? sanitize_text_field( $params[ 'before-price-lbl' ] ) : '';
			$selected_pricelabel_after = isset( $params[ 'after-price-lbl' ] ) ? sanitize_text_field( $params[ 'after-price-lbl' ] ) : '';
			$selected_area_size = isset( $params[ 'area-size' ] ) ? sanitize_text_field( $params[ 'area-size' ] ) : '';
			$selected_area_prefix = isset( $params[ 'area-unit' ] ) ? sanitize_text_field( $params[ 'area-unit' ] ) : '';
			$selected_land_area = isset( $params[ 'land-area-size' ] ) ? sanitize_text_field( $params[ 'land-area-size' ] ) : '';
			$selected_land_prefix = isset( $params[ 'land-area-unit' ] ) ? sanitize_text_field( $params[ 'land-area-unit' ] ) : '';
			$selected_beds = isset( $params[ 'prop-beds' ] ) ? sanitize_text_field( $params[ 'prop-beds' ] ) : '';
			$selected_baths = isset( $params[ 'prop-baths' ] ) ? sanitize_text_field( $params[ 'prop-baths' ] ) : '';
			$selected_garages = isset( $params[ 'prop-grage' ] ) ? sanitize_text_field( $params[ 'prop-grage' ] ) : '';
			$selected_years = isset( $params[ 'prop-build-year' ] ) ? sanitize_text_field( $params[ 'prop-build-year' ] ) : '';
			$selected_address = isset( $params[ 'property-address' ] ) ? sanitize_text_field( $params[ 'property-address' ] ) : '';
			$selected_latt = isset( $params[ 'property-latt' ] ) ? sanitize_text_field( $params[ 'property-latt' ] ) : '';
			$selected_long = isset( $params[ 'property-long' ] ) ? sanitize_text_field( $params[ 'property-long' ] ) : '';
			$selected_gallery = isset( $params[ 'selected_imgz_idz' ] ) ? sanitize_text_field( $params[ 'selected_imgz_idz' ] ) : '';
			$selected_reference = isset( $params[ 'ref-id' ] ) ? sanitize_text_field( $params[ 'ref-id' ] ) : '';
			$selected_zipcode = isset( $params[ 'prop-zip' ] ) ? sanitize_text_field( $params[ 'prop-zip' ] ) : '';
			$selected_viewtype = isset( $params[ 'is-logged' ] ) ? sanitize_text_field( $params[ 'is-logged' ] ) : 'yes';
			$selected_plan = isset( $params[ 'is-plan' ] ) ? sanitize_text_field( $params[ 'is-plan' ] ) : '';
			$selected_fields = isset( $params[ 'addtional-fields' ] ) ? sanitize_text_field( $params[ 'addtional-fields' ] ) : '';
			$selected_attachments = isset( $params[ 'selected_attach_idz' ] ) ? sanitize_text_field( $params[ 'selected_attach_idz' ] ) : '';
			$selected_video = isset( $params[ 'video-url' ] ) ? sanitize_text_field( $params[ 'video-url' ] ) : '';
			$selected_tour = isset( $params[ 'virtual-tour' ] ) ? ( $params[ 'virtual-tour' ] ) : '';
			$selected_location = isset( $params[ 'property-location' ] ) ? sanitize_text_field( $params[ 'property-location' ] ) : '';
			$selected_amens = isset( $params[ 'prop-amens' ] ) ? ( $params[ 'prop-amens' ] ) : '';
            $mark_as_featured = sanitize_text_field($params['is-featured'] === 'on') ? 'yes' : 'no';
            
            $agent_property = isset( $_POST[ 'agent-property' ] ) ? sanitize_text_field( $_POST[ 'agent-property' ] ) : '';
			if(empty($selected_title)){
				$return = array('message' => esc_html__( 'The Title field is required.', 'propertya-framework' ));
      			wp_send_json_error($return);	
			}
			
			$approval = 'publish';
			$success_msg =  esc_html__( 'Ad Posted Successfully.', 'propertya-framework' );
			if(!empty($params['property_id']))
			{
				$property_id = $params['property_id'];
				if(!empty($params['is_edit']) && $params['is_edit'] == 'yes')
				{
					$success_msg =  esc_html__( 'Ad Updated Successfully.', 'propertya-framework' );
					if(propertya_framework_get_options('property_approval_edit') == 'manual')
					{
						$approval = 'draft';
					}
				}
				else
				{
					$success_msg =  esc_html__( 'Ad Posted Successfully.', 'propertya-framework' );
					if(propertya_framework_get_options('property_approval') == 'manual')
					{
						$approval = 'draft';
					}
				}
				// delete_user_meta(get_current_user_id(), 'prop_create_postid');
			}
			
			// Bad words filteration
			$words		  =	explode( ',', propertya_framework_get_options('property_badwords') );
			$replace	  =	propertya_framework_get_options('property_badwords_replace');
			$final_desc	  =	propertya_framework_badwords_filter( $words, $selected_desc, $replace );
			$final_title  =	propertya_framework_badwords_filter( $words, $selected_title, $replace );
			
			//check id exist or not
			if(isset($property_id) && $property_id !="")
			{
				$my_post = array(
				  'ID'           => $property_id,
				  'post_title'   => wp_strip_all_tags($final_title),
				  'post_content' => $final_desc,
				  'post_status'   => $approval,
				  'post_type' 	=> 'property'
  				);
  				wp_update_post( $my_post );
			}
			 if($property_id)
			 {
				if(propertya_framework_get_options('prop_pkg_type') != '' && propertya_framework_get_options('prop_pkg_type') == 'per-listing')
				{
					if (get_post_meta($property_id, 'prop_payper_lisitng', true ) == "1"){}else
					{
						update_post_meta($property_id, 'prop_payper_lisitng', '0');
					}
				}
				else
				{
					update_post_meta($property_id, 'prop_payper_lisitng', '0');
				}
				update_post_meta($property_id, 'prop_package_type', propertya_framework_get_options('prop_pkg_type'));
				//Update the meta field in the database.
				update_post_meta($property_id, 'prop_status', '1');

			
				if (get_post_meta($property_id, 'prop_is_feature_listing', true ) == "1")
				{
				}
				else
				{
					update_post_meta($property_id, 'prop_is_feature_listing', '0');
				}
				//type
				wp_set_object_terms($property_id, propertya_framework_get_ancestors($selected_type,'property_type'), 'property_type');
				update_post_meta($property_id, 'prop_type', $selected_type);
				//status
				wp_set_object_terms($property_id, $selected_offer_type, 'property_status');
				update_post_meta($property_id, 'prop_offer_type', $selected_offer_type);
				//labels
				wp_set_post_terms($property_id, $selected_offer_label, 'property_label');
				update_post_meta($property_id, 'prop_offer_label', $selected_offer_label);
                 
                //currency
                if(propertya_framework_get_options('prop_currency_mode') !="" && propertya_framework_get_options('prop_currency_mode') == 2)
                {    
                    wp_set_post_terms($property_id, $selected_currency, 'property_currency');
                    update_post_meta($property_id, 'prop_currecny_type', $selected_currency);
                }
				//price
				update_post_meta($property_id, 'prop_first_price', $selected_price);
				update_post_meta($property_id, 'prop_second_price', $selected_price_optional);
				update_post_meta($property_id, 'prop_pricelabel_before', $selected_pricelabel_before);
				update_post_meta($property_id, 'prop_pricelabel_after', $selected_pricelabel_after);
				//area
				update_post_meta($property_id, 'prop_area_size', $selected_area_size);
				update_post_meta($property_id, 'prop_area_prefix', $selected_area_prefix);
				//land
				update_post_meta($property_id, 'prop_land_size', $selected_land_area);
				update_post_meta($property_id, 'prop_land_prefix', $selected_land_prefix);
				//general
				update_post_meta($property_id, 'prop_beds_qty', $selected_beds);
				update_post_meta($property_id, 'prop_baths_qty', $selected_baths);
				update_post_meta($property_id, 'prop_garage_qty', $selected_garages);
				update_post_meta($property_id, 'prop_year_build', $selected_years);
				//gallery
				
				update_post_meta( $property_id, 'prop_gallery', $selected_gallery);

				//maps & lat long
				update_post_meta($property_id, 'prop_street_addr', $selected_address);
				update_post_meta($property_id, 'prop_latt', $selected_latt);
				update_post_meta($property_id, 'prop_long', $selected_long);
				update_post_meta($property_id, 'prop_zip', $selected_zipcode);
				update_post_meta( $property_id, 'prop_viewtype', $selected_viewtype);
				update_post_meta($property_id, 'agent_property_id', $agent_property);
				//flor plans
				$plans = array();
				if(!empty($selected_plan) && $selected_plan == "enabled")
				{
					if(isset($params['flr-name']) && $params['flr-name'] != "")
					{
						for($i = 0; $i < count($params['flr-name']); $i++)
						{
							if(!empty($params['flr-name'][$i]))
							{
								$floor_name = isset( $params[ 'flr-name' ][$i] ) ? sanitize_text_field( $params[ 'flr-name' ][$i] ) : '';
								$floor_price = isset( $params[ 'flr-price' ][$i] ) ? sanitize_text_field( $params[ 'flr-price' ][$i] ) : '';
								$floor_pprefix = isset( $params[ 'flr-price-postfix' ][$i] ) ? sanitize_text_field( $params[ 'flr-price-postfix' ][$i] ) : '';
								$floor_size = isset( $params[ 'flr-size' ][$i] ) ? sanitize_text_field( $params[ 'flr-size' ][$i] ) : '';
								$floor_sprefix = isset( $params[ 'flr-size-postfix' ][$i] ) ? sanitize_text_field( $params[ 'flr-size-postfix' ][$i] ) : '';
								$floor_beds = isset( $params[ 'flr-beds' ][$i] ) ? sanitize_text_field( $params[ 'flr-beds' ][$i] ) : '';
								$floor_baths = isset( $params[ 'flr-baths' ][$i] ) ? sanitize_text_field( $params[ 'flr-baths' ][$i] ) : '';
								$floor_desc = isset( $params[ 'flr-desc' ][$i] ) ? sanitize_textarea_field( $params[ 'flr-desc' ][$i] ) : '';
								$floor_plan_image = isset($params[ 'floorplan_image_id'][$i]) ? sanitize_text_field( $params['floorplan_image_id'][$i] ) : '';
								//plans array
								$plans[] = array(
									'prop_floor_name' => $floor_name,
									'prop_floor_price' => $floor_price,
									'prop_floor_pprefix' => $floor_pprefix,
									'prop_floor_size' => $floor_size,
									'prop_floor_sprefix' => $floor_sprefix,
									'prop_floor_beds' => $floor_beds,
									'prop_floor_baths' => $floor_baths,
									'prop_floor_desc' => $floor_desc,
									'prop_floor_img_id' => $floor_plan_image,
								 );
							}
						}
						$final_plans_data = wp_json_encode($plans, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
						update_post_meta($property_id, 'prop_is_plans', $selected_plan);
						update_post_meta($property_id, 'prop_floor_plans', $final_plans_data);
					}
					else
					{
						update_post_meta($property_id, 'prop_is_plans', 'disabled');
						update_post_meta($property_id, 'prop_floor_plans', '');
					}
				}
				else
				{
					update_post_meta($property_id, 'prop_is_plans', 'disabled');
				}
				//Additional fields
				$additional_plans = array();
				if(!empty($selected_fields) && $selected_fields == "enabled")
				{
					if(!empty($params['additiona-fields-title']) && !empty($params['additiona-fields-value']))
					{
						for($c = 0; $c < count($params['additiona-fields-title']); $c++)
						{
							$key = isset( $params[ 'additiona-fields-title' ][$c] ) ? sanitize_text_field( $params[ 'additiona-fields-title' ][$c] ) : '';
							$value = isset( $params[ 'additiona-fields-value' ][$c] ) ? sanitize_text_field( $params[ 'additiona-fields-value' ][$c] ) : '';
							$additional_plans[] = array(
								'prop_add_key' => $key,
								'prop_add_val' => $value,
							);
						}
						$final_additional_data = wp_json_encode($additional_plans, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
						update_post_meta($property_id, 'prop_is_additional_fields', $selected_fields);
						update_post_meta($property_id, 'prop_add_fields', $final_additional_data);
					}
					else
					{
						update_post_meta($property_id, 'prop_is_additional_fields', 'disabled');
						update_post_meta($property_id, 'prop_add_fields', '');
					}
				}
				else
				{
					update_post_meta($property_id, 'prop_is_additional_fields', 'disabled');
				}
				//Amens
				if(!empty($selected_amens))
				{
					wp_set_object_terms( $property_id, $selected_amens, 'property_feature' );
				}
				
				//attachments
				update_post_meta( $property_id, 'prop_attachments', $selected_attachments);

				//video & 360
				update_post_meta( $property_id, 'prop_video', $selected_video);
				update_post_meta( $property_id, 'prop_virtual_tour', $selected_tour);
				//location
				wp_set_object_terms($property_id, propertya_framework_get_ancestors($selected_location,'property_location'), 'property_location');
				update_post_meta($property_id, 'prop_loc', $selected_location);
				

                //saving custom fields
			   if (isset($params['acf']) && $params['acf'] != '' && class_exists('ACF')) 
			   {
			       acf_clear_object_cache($property_id);
			       acf_update_values($params['acf'], $property_id);
			   }

                
                //check woocommrce
                if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))  && propertya_framework_get_options('prop_membership_type') == 'with-woo')
                {
                   //bypass update    
                   if(!empty($params['is_edit']) && $params['is_edit'] == 'no')
                   {
                        //check total listings
                        $total_listings = '';
                        if(get_user_meta(get_current_user_id(), 'prop_pack_totallistings', true) !="")
                        {
                            $total_listings = get_user_meta(get_current_user_id(), 'prop_pack_totallistings', true);
                            if( $total_listings > 0 && !is_super_admin( get_current_user_id() ) )
                            {
                                $total_listings	=	$total_listings - 1;
                                update_user_meta( get_current_user_id(), 'prop_pack_totallistings', $total_listings );
                            }
                        }
                        //listing expiry
                        $simple_listing_expiry = '';    
                        if(get_user_meta(get_current_user_id(), 'prop_pack_simple_expiry_for', true) !="")
                        {
                            $simple_listing_expiry = get_user_meta(get_current_user_id(), 'prop_pack_simple_expiry_for', true);
                            if(isset($simple_listing_expiry) && $simple_listing_expiry !="" && $simple_listing_expiry !="0" && $simple_listing_expiry =="-1")
                            {
                               update_post_meta($property_id, 'prop_regular_listing_expiry', '-1'); 
                            }
                            else
                            {
                                $now = date('Y-m-d');
                                $date	=	date_create($now);
                                date_add($date,date_interval_create_from_date_string("$simple_listing_expiry days"));
                                $ad_expiry_date	=	 date_format($date,"Y-m-d");
                                update_post_meta($property_id, 'prop_regular_listing_expiry_date', $ad_expiry_date );
                                update_post_meta($property_id, 'prop_regular_listing_expiry', $simple_listing_expiry );
                            }
                        }
                   }
                   
                   //featured listings
                   $expiry_days = $featured_listings = '';  
									 



                   if(get_user_meta(get_current_user_id(), 'prop_pack_featuredlistings', true) !="" && $mark_as_featured == 'yes' && get_post_meta($property_id, 'prop_is_feature_listing', true) =="0")
                   {

                       $featured_listings = get_user_meta(get_current_user_id(), 'prop_pack_featuredlistings', true);

                      


                       $expiry_days = get_user_meta(get_current_user_id(), 'prop_pack_exp_featured_for', true);
                     

                     
                       if($featured_listings > 0)
                       {       
                            if(isset($expiry_days) && $expiry_days !="" && $expiry_days !="0" && $expiry_days == '-1')
                            {

                                update_post_meta($property_id, 'prop_feature_listing_for', $expiry_days);
                            }
                            else
                            {
                               $now = date('Y-m-d');
                               $date	=	date_create($now);
                               date_add($date,date_interval_create_from_date_string("$expiry_days days"));
                               $featured_listing_exp_date	=	 date_format($date,"Y-m-d");
                               update_post_meta($property_id, 'prop_feature_listing_for', $featured_listing_exp_date);
                            }
                           update_post_meta($property_id, 'prop_is_feature_listing', 1);
                           update_post_meta($property_id, 'prop_feature_listing_date',date('Y-m-d'));
                           $featured_listings	=	$featured_listings - 1;
                           update_user_meta( get_current_user_id(), 'prop_pack_featuredlistings', $featured_listings );  
                       }
                       else
                       {
                           update_post_meta($property_id, 'prop_is_feature_listing', 0);  
                       }


                     }
                     ///*
                     else{

                    	update_post_meta($property_id, 'prop_is_feature_listing', 0);
                     }
                     ///*
                    $link = get_the_permalink($property_id); 
                     }
                    else if(propertya_framework_get_options('prop_pkg_type') != ''  && propertya_framework_get_options('prop_pkg_type') == 'per-listing')
				    {
                    //per listing check
					if (get_post_meta($property_id, 'prop_payper_lisitng', true )!="" && get_post_meta($property_id, 'prop_payper_lisitng', true ) == "1")
					{
						$link = get_the_permalink($property_id);
					}
					else
					{
						$link = propertya_framework_get_link('page-dashboard.php')."?page-type=order-complete&listing_id=$property_id";
					}
				}
				else
				{
					$link = get_the_permalink($property_id);
				}
				$return = array('message' => $success_msg,'referral' => $link);
      		 	wp_send_json_success($return);
			 }
  		}
	}
}



// Set Cover Image
// Set Cover Image
add_action( 'wp_ajax_prop_gallery_images', 'propertya_framework_my_gallery' );
if (!function_exists ( 'propertya_framework_my_gallery' ))
{
	function propertya_framework_my_gallery()
	{
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin(get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		else
		{
			if (!empty($_FILES)) {
			$property_id = $_POST['property_id'];	
			$galleryz = $list_creatz = array();
            $has_gallery = false;
            $mediaz = '';

            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';
            $uploaded_file_size = $actual_size = $display_size = $size_arr = $allowed_file_types = $uploaded_file_type = '';
            $files = $_FILES["files"];
			$data = '';
            foreach ($files['name'] as $key => $value) {
                if ($files['name'][$key]) {
                    $file = array(
                        'name' => $files['name'][$key],
                        'type' => $files['type'][$key],
                        'tmp_name' => $files['tmp_name'][$key],
                        'error' => $files['error'][$key],
                        'size' => $files['size'][$key]
                    );
                    $uploaded_file_type = $files['type'][$key];
                    $uploaded_file_size = $files['size'][$key];
                    $allowed_file_types = array('image/jpg', 'image/jpeg', 'image/png');
                    if (!in_array($uploaded_file_type, $allowed_file_types))
					{
						$return = array('message' => esc_html__( 'Sorry, only JPG, JPEG, and PNG files are allowed.', 'propertya-framework' ));
						wp_send_json_error($return);
                    }
                    // Check max image limit
                    $media = '';
                    $media = get_attached_media('image', $property_id);
                    $list_creatz = array();
                 
                    $_FILES = array("files" => $file);
                    foreach ($_FILES as $file => $array) {
                        $attachment_id = media_handle_upload('files', $property_id);
                        if (is_wp_error($attachment_id)) {
							$return = array('message' => esc_html__( 'Sorry, this file type is not permitted for security reason.', 'propertya-framework' ));
						wp_send_json_error($return);
							
                        } else {
                        	
                            if ((get_post_meta($property_id, 'prop_gallery', true) != "")) {
                                $imgaes = '';
                                $imgaes = get_post_meta($property_id, 'prop_gallery', true);
                                $imgaes = $imgaes . ',' . $attachment_id;
                                update_post_meta($property_id, 'prop_gallery', $imgaes);
                            } else {
                                update_post_meta($property_id, 'prop_gallery', $attachment_id);
                            }
                        }
                    }
                }
            }
				$all_idz = '';
				$all_idz = propertya_framework_fetch_gallery_idz($property_id);
				 if(is_array($all_idz) && count($all_idz) > 0)
				 {
					$data .= '<ul class="custom-meta-gallery">';
					foreach($all_idz as $images_ids)
            		{
						$img_id	=	'';
						if (isset( $images_ids->ID))
						{
							$img_id	= 	$images_ids->ID;
						}
						else
						{
							$img_id	=	$images_ids;
						}
						 $thumb_imgs  = wp_get_attachment_image_src($img_id, 'propertya-user-thumb');
						 $data .= '<li class="sort_list_img" id="'.$img_id.'"><div class="custom-meta-gallery_container"><span class="img_suff"><i class="fas fa-arrows-alt shuffle-img"></i></span><span class="custom-gallery-del">
				 	<img data-prop-id="'.$property_id.'" id="'.$img_id.'" src="'.esc_url($thumb_imgs[0]).'" alt=""></span></div></li>';
					}
					$data .= '</ul>';
					$selected_attachments = '';
				    $selected_attachments = get_post_meta( $property_id, 'prop_gallery', true );
					$return = array('referral_data' => $data, 'selected_attachments' => $selected_attachments);
					wp_send_json_success($return);
				 }
			}
		}
	}
}

// Property Gallery Attachments
add_action( 'wp_ajax_prop_gallery_attachments', 'propertya_framework_my_gallery_attachments' );
if (!function_exists ( 'propertya_framework_my_gallery_attachments' ))
{
	function propertya_framework_my_gallery_attachments()
	{
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin(get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		else
		{
			if (!empty($_FILES)) {
			$property_id = $_POST['property_id'];	
			$galleryz = $list_creatz = array();
            $has_gallery = false;
            $mediaz = '';

            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';
            $uploaded_file_size = $actual_size = $display_size = $size_arr = $allowed_file_types = $uploaded_file_type = '';
            $files = $_FILES["files"];
			$data = '';
            foreach ($files['name'] as $key => $value) {
                if ($files['name'][$key]) {
                    $file = array(
                        'name' => $files['name'][$key],
                        'type' => $files['type'][$key],
                        'tmp_name' => $files['tmp_name'][$key],
                        'error' => $files['error'][$key],
                        'size' => $files['size'][$key]
                    );
                    $uploaded_file_type = $files['type'][$key];
                    $uploaded_file_size = $files['size'][$key];
                    $allowed_file_types = array('image/jpg', 'image/jpeg', 'image/png','application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/pdf');
                    if (!in_array($uploaded_file_type, $allowed_file_types)) {
						
						$return = array('message' => esc_html__( 'Sorry, only JPG, JPEG ,PDF , DOC and DOCX files are allowed.', 'propertya-framework' ));
						wp_send_json_error($return);
                    }
                    // Check max image limit
                    $media = '';
                    $media = get_attached_media('image', $property_id);
                    $list_creatz = array();
                    $_FILES = array("files" => $file);
                    foreach ($_FILES as $file => $array) {
                        $attachment_id = media_handle_upload('files', $property_id);
                        if (is_wp_error($attachment_id)) {
                            $return = array('message' => esc_html__( 'Sorry, this file type is not permitted for security reason.', 'propertya-framework' ));
						wp_send_json_error($return);
                        } else {
                            if (get_post_meta($property_id, 'prop_attachments', true) != "") {
                                $imgaes = '';
                                $imgaes = get_post_meta($property_id, 'prop_attachments', true);
                                
                                $imgaes = $imgaes . ',' . $attachment_id;
                                update_post_meta($property_id, 'prop_attachments', $imgaes);
                            } else {
                                update_post_meta($property_id, 'prop_attachments', $attachment_id);
                            }
                        }
                    }
                }
            }
				$selected_attachments = '';
				$selected_attachments = get_post_meta( $property_id, 'prop_attachments', true );
				if(!empty($selected_attachments))
				{
					$media = explode(',', $selected_attachments);
					if(!empty($media) && count($media) > 0)
					{
						foreach( $media as $m )
						{
							$type_img = $attach_id = '';
							$attach_id =  $m;
							$data .= '<div class="uploading-attachments att_suff" id="'.$attach_id.'"> <img src="'.get_icon_for_attachment($attach_id).'" alt=""><span class="attachment-data"> <h4><a href="'.wp_get_attachment_url($attach_id).'" class="clr-black attachment-file-title" target="_blank">'. wp_trim_words(get_the_title($attach_id), 5, ' …' ).'</a></h4> <p> file size: '.size_format(filesize(get_attached_file($attach_id))).'</p> <a href="javascript:void(0)" class="btn-pro-clsoe-icon" data-id="'.$attach_id.'" data-property-id="'.$property_id.'"> <i class="fas fa-times-circle"></i></a> </span><span class="attach_suff"><i class="fas fa-arrows-alt shuffle-attachs"></i></span></div>';
						}
					}
					$return = array('referral_data' => $data, 'selected_attachments' => $selected_attachments);
					wp_send_json_success($return);	
				}
			}
		}
	}
}

// Delete Selected Attachments
add_action( 'wp_ajax_prop_delete_selected_attachment', 'propertya_framework_del_my_attachments' );
if (!function_exists ( 'propertya_framework_del_my_attachments' ))
{
	function propertya_framework_del_my_attachments()
	{
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin(get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		else
		{
			$attachment_id = $_POST['attachment_id'];
			$property_id = $_POST['property_id'];
			if(!empty($attachment_id))
			{
				wp_delete_attachment($attachment_id, true);
				if (get_post_meta($property_id, 'prop_attachments', true) != "") {
					$ids = get_post_meta($property_id, 'prop_attachments', true);
					$res = str_replace($attachment_id, "", $ids);
					$res = str_replace(',,', ",", $res);
					$img_ids = trim($res, ',');
					update_post_meta($property_id, 'prop_attachments', $img_ids);
				}
				$selected_attachments = '';
				$selected_attachments = get_post_meta($property_id, 'prop_attachments', true);
				$return = array('selected_attachments' => $selected_attachments);
				wp_send_json_success($return);	
			}
		}
	}
}


// Delete Selected Gallery Images
add_action( 'wp_ajax_prop_delete_selected_gallery_attachment', 'propertya_framework_del_mygallery_attachments' );
if (!function_exists ( 'propertya_framework_del_mygallery_attachments' ))
{
	function propertya_framework_del_mygallery_attachments()
	{
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin(get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		else
		{
			$attachment_id = $_POST['attachment_id'];
			$property_id = $_POST['property_id'];
			if(!empty($attachment_id))
			{
				wp_delete_attachment($attachment_id, true);
				if (get_post_meta($property_id, 'prop_gallery', true) != "") {
					$ids = get_post_meta($property_id, 'prop_gallery', true);
					$res = str_replace($attachment_id, "", $ids);
					$res = str_replace(',,', ",", $res);
					$img_ids = trim($res, ',');
					update_post_meta($property_id, 'prop_gallery', $img_ids);
				}
				$selected_attachments = '';
				$selected_attachments = get_post_meta($property_id, 'prop_gallery', true);
				$return = array('selected_attachments' => $selected_attachments);
				wp_send_json_success($return);	
			}
		}
	}
}

// Set FloorPlan Image
add_action( 'wp_ajax_prop_myplans_img', 'propertya_framework_myfloor_plans_img' );
if (!function_exists ( 'propertya_framework_myfloor_plans_img' ))
{
	function propertya_framework_myfloor_plans_img()
	{
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin(get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		else
		{
			if(!empty($_FILES))
			{
				$property_id = $_POST['property_id'];
				$arr_img_ext = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif');
				if (in_array($_FILES['flrplan-upload']['type'], $arr_img_ext))
				{
					$post_id = '';
					$upload = wp_upload_bits($_FILES["flrplan-upload"]["name"], null, file_get_contents($_FILES["flrplan-upload"]["tmp_name"]));
					if (isset($upload['error']) && $upload['error']) {
         				$return = array('message' => esc_html__('Sorry, there was an error in uploading the file.', 'propertya-framework'));
					wp_send_json_error($return);
    				}
					 $post_id = ' '; //set post id to which you need to set post thumbnail
					 $filename = $upload['url'];
					 $wp_filetype = wp_check_filetype($filename, null);
					 $attachment = array(
						'post_mime_type' => $wp_filetype['type'],
						'post_title' => sanitize_file_name($filename),
						'post_content' => '',
						'post_status' => 'inherit',
    				);
					$attach_id = wp_insert_attachment( $attachment, $filename, $post_id );
					if($attach_id)
					{
						require_once(ABSPATH . 'wp-admin/includes/image.php');
						$attachment_data = wp_generate_attachment_metadata( $attach_id, $upload['file'] );
     					wp_update_attachment_metadata( $attach_id,  $attachment_data );
						//get attach image url 
						$img_link = wp_get_attachment_image_src( $attach_id, 'propertya-user-thumb' );
						$return = array('img_link' => $img_link[0], 'attach_id' => $attach_id);
						wp_send_json_success($return);
					}
					else
					{
						$return = array('message' => esc_html__('An unexpected error occurred while uploading your image, please try again later.', 'propertya-framework'));
					wp_send_json_error($return);
					}
				}
				else
				{
					$return = array('message' => esc_html__('Sorry, only JPG, JPEG, and PNG files are allowed.', 'propertya-framework'));
					wp_send_json_error($return);
				}
			}
			else
			{
				$return = array('message' => esc_html__( 'Please select an image to upload.', 'propertya-framework' ));
				wp_send_json_error($return);
			}
		}
	}
}

// Delete Floorplan Attachments
add_action( 'wp_ajax_prop_delete_flr_pln_attachment', 'propertya_framework_del_floorplans_attachments' );
if (!function_exists ( 'propertya_framework_del_floorplans_attachments' ))
{
	function propertya_framework_del_floorplans_attachments()
	{
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin(get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		else
		{
			$attachment_id = $_POST['attachment_id'];
			if(!empty($attachment_id))
			{
				wp_delete_attachment($attachment_id, true);
				$return = array('selected_attachments' => '');
				wp_send_json_success($return);	
			}
		}
	}
}