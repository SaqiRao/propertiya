<?php
//user dash
// Fetuch user listings
if ( ! function_exists( 'propertya_framework_fetch_user_listings' ) )
{	 
	function propertya_framework_fetch_user_listings($listing_status, $owner_id, $paged, $per_page, $keyword = '', $is_featured = false, $is_expired = false)
	{
		   $value = 1;
			$featured = '';
			if(!empty($is_featured) && $is_featured == true)
			{
				   $featured = array(
						'key' => 'prop_is_feature_listing',
						'value' => '1',
						'compare' => '=',
					);
			}
			if(!empty($is_expired) && $is_expired == true)
			{
				 $value = 0;
			}
			$args	=	array
			(
			    's' => trim($keyword),
				'post_type' => 'property',
				'author' => $owner_id,
				'post_status' => $listing_status,
				'posts_per_page' => $per_page,
				'paged' => $paged,
				'order'=> 'DESC',
				'orderby' => 'date',
				'meta_query'    => array(
					array(
						'key'       => 'prop_status',
						'value'     => $value,
						'compare'   => '=',
					),
					$featured
				)
			);
			return $args;
	}
}


// Most Viewed Properties
if ( ! function_exists( 'propertya_framework_fetchmost_viewed_listings' ) )
{	 
	function propertya_framework_fetchmost_viewed_listings($owner_id, $most_viewed = false, $todays_trending = false)
	{
		$order_by = 'date';
		if ($most_viewed == true) 
		{
             $order_by = 'prop_listing_total_views';
        }
		
		$args	=	array
			(
				'post_type' => 'property',
				'author' => $owner_id,
				'post_status' => 'publish',
				'posts_per_page' => 4,
                'fields' => 'ids',
				'meta_key' => 'prop_listing_total_views',
				'order'=> 'DESC',
				'orderby' => 'meta_value_num',
				'meta_query'    => array(
					array(
						'key'       => 'prop_status',
						'value'     => 1,
						'compare'   => '=',
					),
				)
			);
			return $args;
	}
}


// Fetuch user favourites properties
if ( ! function_exists( 'propertya_framework_fetch_user_fav_listings' ) )
{	 
	function propertya_framework_fetch_user_fav_listings($owner_id, $paged, $per_page)
	{
		    $rows = '';
			global $wpdb;
			$args = $listing_idz = array();
			$rows = $wpdb->get_results("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$owner_id' AND meta_key LIKE 'prop_fav_listing_id%'");
			if(!empty($rows) && is_array($rows) && count($rows) > 0)
			{
				foreach ($rows as $row)
				{
					$listing_idz[] = $row->meta_value;
				}
				$args	=	array
				(
					'post_type' => 'property',
					'post__in' => $listing_idz,
					'post_status' => 'publish',
					'posts_per_page' => $per_page,
                    'fields' => 'ids',
					'paged' => $paged,
					'order'=> 'DESC',
					'orderby' => 'date',
					'meta_query'    => array(
						array(
							'key'       => 'prop_status',
							'value'     => 1,
							'compare'   => '=',
						),
					)
				);
			}
			return $args;
	}
}

// Fetuch user Invoice
if ( ! function_exists( 'propertya_framework_fetch_user_invocies' ) )
{	 
	function propertya_framework_fetch_user_invocies($owner_id, $paged, $per_page)
	{
			$args	=	array
			(
				'post_type' => 'listing-invoices',
				'post_status' => 'publish',
				'posts_per_page' => $per_page,
				'paged' => $paged,
				'order'=> 'DESC',
				'orderby' => 'date',
				'meta_query'    => array(
					array(
						'key'       => 'prop_inv_user_id',
						'value'     => $owner_id,
						'compare'   => '=',
					),
				)
			);
			return $args;
	}
}

// Delete Property
add_action('wp_ajax_remove_my_prop', 'propertya_framework_remove_my_listings');
if (!function_exists('propertya_framework_remove_my_listings'))
{ 
	function propertya_framework_remove_my_listings()
	{
		if(empty($_POST['property_id'])){
			$return = array('message' => esc_html__( 'An error occurred, please try again later.', 'propertya-framework' ));
			wp_send_json_error($return);	
		}
		else
		{
			if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin( get_current_user_id()))
			{
				$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
				wp_send_json_error($return);
			}
			$property_id =	$_POST['property_id'];
			if( wp_trash_post($property_id))
			{
				$return = array('message' => esc_html__( 'Property removed successfully.', 'propertya-framework' ));
				wp_send_json_success($return);	
			}
			else
			{
				$return = array('message' => esc_html__( 'Something went wrong please try later.', 'propertya-framework' ));
				wp_send_json_error($return);
			}
		}
		die();
	}
}

// Expire My Property
add_action('wp_ajax_expire_my_prop', 'propertya_framework_expire_my_listings');
if (!function_exists('propertya_framework_expire_my_listings'))
{ 
	function propertya_framework_expire_my_listings()
	{
		if(empty($_POST['property_id'])){
			$return = array('message' => esc_html__( 'An error occurred, please try again later.', 'propertya-framework' ));
			wp_send_json_error($return);	
		}
		else
		{
			if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin( get_current_user_id()))
			{
				$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
				wp_send_json_error($return);
			}
			$property_id =	$_POST['property_id'];
			$my_post = array(
				  'ID'           => $property_id,
				  'post_status'   => 'expired',
				  'post_type' 	=> 'property'
  				);
  			$post_id = wp_update_post( $my_post );
			if ( is_wp_error($post_id))
			{
				$return = array('message' => esc_html__( 'Something went wrong please try later.', 'propertya-framework' ));
				wp_send_json_error($return);
			}
			else
			{
				update_post_meta($property_id, 'prop_status', '0');
				update_post_meta($property_id, 'prop_expired', 'yes');
				update_post_meta($property_id, 'prop_is_feature_listing', '0');
             // update_post_meta($property_id, 'prop_regular_listing_expiry_date', '');    
                update_post_meta($property_id, 'prop_regular_listing_expiry', '');
				$return = array('message' => esc_html__( 'Property expired successfully.', 'propertya-framework' ));
				wp_send_json_success($return);	
			}
		}
		die();
	}
}


// Reactive My Property
add_action('wp_ajax_reactive_my_listings', 'propertya_framework_reactive_my_listings');
if (!function_exists('propertya_framework_reactive_my_listings'))
{ 
	function propertya_framework_reactive_my_listings()
	{
		if(empty($_POST['property_id'])){
			$return = array('message' => esc_html__( 'An error occurred, please try again later.', 'propertya-framework' ));
			wp_send_json_error($return);	
		}
		else
		{
			if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin( get_current_user_id()))
			{
				$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
				wp_send_json_error($return);
			}
			$property_id =	$_POST['property_id'];
			$my_post = array(
				  'ID'           => $property_id,
				  'post_status'   => 'publish',
				  'post_type' 	=> 'property'
  				);
			
  			$post_id = wp_update_post( $my_post );

			if ( is_wp_error($post_id))
			{
				$return = array('message' => esc_html__( 'Something went wrong please try later.', 'propertya-framework' ));
				wp_send_json_error($return);
			}
			else
			{
			 $user_id = get_current_user_id();
			 $listing_expiry = get_user_meta($user_id, 'prop_pack_simple_expiry_for', true);
			 $next_due_date = date('d/m/Y', strtotime("+$listing_expiry days"));
				update_post_meta($property_id, 'prop_status', '1');
				update_post_meta($property_id, 'prop_expired',  $next_due_date);
				update_post_meta($property_id, 'prop_is_feature_listing', '0');
               // update_post_meta($property_id, 'prop_regular_listing_expiry_date', '');    
                update_post_meta($property_id, 'prop_regular_listing_expiry', '');
		 	 $return = array('message' => esc_html__( 'Property reactive successfully.', 'propertya-framework' ));
				wp_send_json_success($return);	
			}
		}
		die();
	}
}


// Search Suggestions My Property
add_action('wp_ajax_my_propz', 'propertya_framework_my_propz');
if (!function_exists('propertya_framework_my_propz'))
{
	function propertya_framework_my_propz()
	{
		$user_id = get_current_user_id();
		$params = array();
		parse_str($_POST['form'], $params);
		if(!empty($_POST['q']))
		{
			$tags = $all_listings = $cat_array = array();
			$keyword = trim($_POST['q']);
			$status = true;
			$search_results = new WP_Query( 
			array
			(
			    's' => trim($keyword),
				'post_type' => 'property',
				'author' => $user_id,
				'post_status' =>$params['page-type'],
				'posts_per_page' => 15,
				'paged' => 1,
                'fields' => 'ids',
				'order'=> 'DESC',
				'orderby' => 'date',
				'meta_query'    => array(
					array(
						'key'       => 'prop_status',
						'value'     => '1',
						'compare'   => '=',
					),
				)
			));
			if( $search_results->have_posts() )
			{
				while( $search_results->have_posts() )
				{
				 	$search_results->the_post();
                    $property_id = get_the_ID();
					$all_idz = '';
					$all_idz = propertya_framework_fetch_gallery_idz($property_id);
					$all_listings[] = array( "id"  => $property_id,"with_title" =>get_the_title($property_id),"img"=> propertya_framework_img_src($all_idz,'thumbnail'),'link' => get_the_permalink($property_id));
				}
				wp_reset_postdata();
				echo json_encode(array(
					"status" => true,
					"error"  => '',
					"data"   => array(
						"listings"      => $all_listings,
					)
				));
			}
			else
			{
				echo json_encode(array(
					"status" => false,
					"error"  => '',
					"data"   => array()
				));
			}
			die();
		}
	}
}

// Search Suggestions My Agents
add_action('wp_ajax_my_agentz', 'propertya_framework_my_agentzz');
if (!function_exists('propertya_framework_my_agentzz'))
{
	function propertya_framework_my_agentzz()
	{
		$user_id = get_current_user_id();
		if(!empty($_POST['q']))
		{
			$tags = $all_listings = $cat_array = array();
			$keyword = trim($_POST['q']);
			$status = true;
			$agency_id = '';
		    if(get_user_meta( $user_id, 'prop_post_id' , true ) !="")
		    {
			  $agency_id = get_user_meta( $user_id, 'prop_post_id' , true );
		    }
			$search_results = new WP_Query( 
			array
			(
				's' => trim($keyword),
			   	'post_type' => 'property-agents',
				'posts_per_page' => 15,
				'order'=> 'DESC',
				'orderby' => 'date',
				'meta_key' => 'agent_agency_id',
				'meta_value' => $agency_id
			));
			if( $search_results->have_posts() )
			{
				$featured_img_url = '';
				while( $search_results->have_posts() )
				{
				 	$search_results->the_post();
					$agent_id	=	get_the_ID();
					if(has_post_thumbnail($agent_id))
					{
						$featured_img_url = get_the_post_thumbnail_url($agent_id,'thumb');
					}
					else
					{
						$featured_img_url = trailingslashit( get_template_directory_uri()).'libs/images/default-imag.jpg';
						global $propertya_options;
						if(isset($propertya_options['prop_def_agent_logo']) && $propertya_options['prop_def_agent_logo']['url'] !="")
						{
							$featured_img_url = $propertya_options['prop_def_agent_logo']['url'];
						}
					}
					
					$all_listings[] = array( "id"  => $agent_id, "with_title" => get_the_title($agent_id),"img"=>($featured_img_url),'link' => get_the_permalink($agent_id));
				}
				wp_reset_postdata();
				echo json_encode(array(
					"status" => true,
					"error"  => '',
					"data"   => array(
						"listings"      => $all_listings,
					)
				));
			}
			else
			{
				echo json_encode(array(
					"status" => false,
					"error"  => '',
					"data"   => array()
				));
			}
			die();
		}
	}
}

/*Fetch My  Agents*/
if ( ! function_exists( 'propertya_framework_fetch_my_agents' ) )
{	 
	function propertya_framework_fetch_my_agents($user_id , $paged, $per_page, $keyword = '')
	{
		$user_id = get_current_user_id();
		if(get_userdata($user_id))
		{
			$agency_id = '';
		    if(get_user_meta( $user_id, 'prop_post_id' , true ) !="")
		    {
			  $agency_id = get_user_meta( $user_id, 'prop_post_id' , true );
		    }
			$args	=	array
			(
				's' => trim($keyword),
			   	'post_type' => 'property-agents',
				'posts_per_page' => $per_page,
				'paged' => $paged,
				'order'=> 'DESC',
				'orderby' => 'date',
				'meta_key' => 'agent_agency_id',
				'meta_value' => $agency_id
			);
			return $args;
		}
	}
}

// Delete My Agent
add_action('wp_ajax_remove_my_agents', 'propertya_framework_remove_my_agentz');
if (!function_exists('propertya_framework_remove_my_agentz'))
{ 
	function propertya_framework_remove_my_agentz()
	{
		if(empty($_POST['agent_id'])){
			$return = array('message' => esc_html__( 'An error occurred, please try again later.', 'propertya-framework' ));
			wp_send_json_error($return);	
		}
		else
		{
			if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin( get_current_user_id()))
			{
				$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
				wp_send_json_error($return);
			}
			$agent_id =	$_POST['agent_id'];
			$user_id = '';
			if(get_post_meta( $agent_id, 'prop_user_id' , true ) !="")
		    {
			  $user_id = get_post_meta( $agent_id, 'prop_user_id' , true );
		    }
			if( wp_delete_post($agent_id,true))
			{
				//delete current user as well
    			wp_delete_user($user_id);
				$return = array('message' => esc_html__( 'Agent deleted successfully.', 'propertya-framework' ));
				wp_send_json_success($return);	
			}
			else
			{
				$return = array('message' => esc_html__( 'Something went wrong please try later.', 'propertya-framework' ));
				wp_send_json_error($return);
			}
		}
		die();
	}
}

// Remove Fav bookmark listings
add_action('wp_ajax_remove_my_favourites', 'propertya_framework_remove_my_bookmarks');
if (!function_exists('propertya_framework_remove_my_bookmarks'))
{ 
	function propertya_framework_remove_my_bookmarks()
	{
		if(!wp_verify_nonce($_POST['security'], 'check-security'))
		{
			$return = array('message' => esc_html__('Invalid security token sent.', 'propertya-framework'));
			wp_send_json_error($return);
		}
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin( get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		if(empty($_POST['property_id'])){
			$return = array('message' => esc_html__( 'An error occurred, please try again later.', 'propertya-framework' ));
			 wp_send_json_error($return);	
		}
		else
		{
			$property_id = $_POST['property_id'];
			if (delete_user_meta(get_current_user_id(), 'prop_fav_listing_id' . $property_id) == $property_id)
			{
				$return = array('message' => esc_html__( 'Remove from favorites.', 'propertya-framework' ));
				wp_send_json_success($return);	
			}
			else
			{
				$return = array('message' => esc_html__( 'Something went wrong please try later.', 'propertya-framework' ));
				wp_send_json_error($return);
			}
		}
		die();
	}
}