<?php
//Reviews Reactions
add_action('wp_ajax_prop_listing_reactions', 'propertya_framework_save_reaction');
add_action('wp_ajax_nopriv_prop_listing_reactions', 'propertya_framework_save_reaction');
if (!function_exists('propertya_framework_save_reaction'))
{
    function propertya_framework_save_reaction()
	{
		if(!wp_verify_nonce($_POST['security'], 'check-security'))
		{
			$return = array('message' => esc_html__('Invalid security token sent.', 'propertya-framework'));
			wp_send_json_error($return);
		}
        if (!is_user_logged_in())
		{
			$return = array('message' => esc_html__("You need to log in.", 'propertya-framework'));
			wp_send_json_error($return);
		}
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin( get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		if(!empty($_POST['r_id']) && !empty($_POST['r_id']) && !empty($_POST['listing_id']))
		{
			$reaction_id = intval($_POST['r_id']);
			$comment_id  = intval($_POST['c_id']);
			$listing_id  = intval($_POST['listing_id']);
			//if already reacted
			 if (get_user_meta(get_current_user_id(), 'prop_reaction_comment_id'.$comment_id, true) == $comment_id) 			 			 {
				$return = array('message' => esc_html__( 'You have already reacted to this review.', 'propertya-framework' ));
				wp_send_json_error($return); 
			 }
			 else
			 {
				update_user_meta(get_current_user_id(), 'prop_reaction_comment_id'.$comment_id,$comment_id);
				if ($reaction_id == 1)
				{
					 $like_count = get_comment_meta($comment_id, 'review_like', true);
					 if(empty($like_count))
					 {
						$like_count = 1; 
					 }
					 else
					 {
						 $like_count = $like_count + 1; 
					 }
					 update_comment_meta($comment_id, 'review_like', $like_count);
					 propertya_framework_track_activity($listing_id, 'like', '1');
					 $return = array('totalcount'=>$like_count);
					 //total likes
					 $counter = get_post_meta($listing_id, 'prop_totallikes', true);
					 if(!empty($counter))
					 {
						$counter = $counter + 1;
					 }
					 else
					 {
						$counter = 1;
					 }
					 update_post_meta($listing_id, 'prop_totallikes',$counter);
					 wp_send_json_success($return);
				}
				if ($reaction_id == 2)
				{
					 $love_count = get_comment_meta($comment_id, 'review_love', true);
					 if(empty($love_count))
					 {
						$love_count = 1; 
					 }
					 else
					 {
						 $love_count = $love_count + 1; 
					 }
					 update_comment_meta($comment_id, 'review_love', $love_count);
					 propertya_framework_track_activity($listing_id, 'like', '2');
					 $return = array('totalcount'=>$love_count);
					 //total loves
					 $counter = get_post_meta($listing_id, 'prop_totalloves', true);
					 if(!empty($counter))
					 {
						$counter = $counter + 1;
					 }
					 else
					 {
						$counter = 1;
					 }
					 update_post_meta($listing_id, 'prop_totalloves',$counter);
					 wp_send_json_success($return);
				}
				if ($reaction_id == 3)
				{
					 $dislike_count = get_comment_meta($comment_id, 'review_dislike', true);
					 if(empty($dislike_count))
					 {
						$dislike_count = 1; 
					 }
					 else
					 {
						 $dislike_count = $dislike_count + 1; 
					 }
					 update_comment_meta($comment_id, 'review_dislike', $dislike_count);
					 propertya_framework_track_activity($listing_id, 'like', '3');
					 $return = array('totalcount'=>$dislike_count);
					 //total loves
					 $counter = get_post_meta($listing_id, 'prop_totaldislike', true);
					 if(!empty($counter))
					 {
						$counter = $counter + 1;
					 }
					 else
					 {
						$counter = 1;
					 }
					 update_post_meta($listing_id, 'prop_totaldislike',$counter);
					 wp_send_json_success($return);
				}
				
			 }
		}
		else
		{
			$return = array('message' => esc_html__('There was an error while processing your request. Please, reload the page and try again.', 'propertya-framework'));
			wp_send_json_error($return);
		}
    }
}

//Bookmark Listings
add_action('wp_ajax_prop_listing_bookmarks', 'propertya_framework_save_bookmarks');
add_action('wp_ajax_nopriv_prop_listing_bookmarks', 'propertya_framework_save_bookmarks');
if (!function_exists('propertya_framework_save_bookmarks'))
{
    function propertya_framework_save_bookmarks()
	{
		global $propertya_options;
		if(!wp_verify_nonce($_POST['security'], 'check-security'))
		{
			$return = array('message' => esc_html__('Invalid security token sent.', 'propertya-framework'));
			wp_send_json_error($return);
		}
        if (!is_user_logged_in())
		{
             $page_id='';
			 $page_id = $propertya_options['prop_signin_page'];
			 $pagelink = get_permalink($page_id);
			 $return = array('message' => esc_html__("You need to log in.", 'propertya-framework') ,'url' => get_permalink($page_id));
			 
			    wp_send_json_error($return);
			
		}
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin( get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		if(!empty($_POST['fav_listing']))
		{
			$property_id = $_POST['fav_listing'];
			$counter = '';
			if (get_user_meta(get_current_user_id(), 'prop_fav_listing_id' . $property_id, true) == $property_id)
			{
				$return = array('message' => esc_html__('You have bookmark this listing already.','propertya-framework'));
			wp_send_json_error($return);
        	} 
			else 
			{
				$counter = get_post_meta($property_id, 'prop_bookmarks_counter', true);
				if(!empty($counter))
				{
					$counter = $counter + 1;
				}
				else
				{
					$counter = 1;
				}
				update_post_meta($property_id, 'prop_bookmarks_counter',$counter);
				update_user_meta(get_current_user_id(), 'prop_fav_listing_id'.$property_id,$property_id);
				$return = array('message' => esc_html__('Added to your favorites.', 'propertya-framework'));
			    wp_send_json_success($return);
			}
		}
		else
		{
			$return = array('message' => esc_html__('There was an error while processing your request. Please, reload the page and try again.', 'propertya-framework'));
			wp_send_json_error($return);
		}
	}
}

//Multiple Widget Search Suggestions
add_action('wp_ajax_nopriv_fetch_suggestions_widget', 'propertya_framework_live_suggestions_widgets');
add_action('wp_ajax_fetch_suggestions_widget', 'propertya_framework_live_suggestions_widgets');
if (!function_exists('propertya_framework_live_suggestions_widgets'))
{
    function propertya_framework_live_suggestions_widgets()
	{
		if (!empty($_GET['q']) && !empty($_GET['type']))
		{
			$type = $_GET['type'];
			if($type == 'agencies')
			{
				$post_type = 'property-agency';
				$meta_query = array(
						'key'       => 'agency_status',
						'value'     => '1',
						'compare'   => '=',
					);
			}
			else if($type == 'agents')
			{
				$post_type = 'property-agents';
				$meta_query = array(
						'key'       => 'agent_status',
						'value'     => '1',
						'compare'   => '=',
					);
			}
			else
			{
				$post_type = 'property';
				$meta_query = array(
						'key'       => 'prop_status',
						'value'     => '1',
						'compare'   => '=',
					);
			}
			
            $tags = $all_listings = $cat_array = array();
            $keyword = strtolower($_GET['q']);
            $status = true;
            $search_results = new WP_Query(array(
                's' =>trim(sanitize_text_field($keyword)),
                'post_type' => $post_type,
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1,
                'posts_per_page' => 15,
				'meta_query'    => array(
					$meta_query
				)
            ));
			if ($search_results->have_posts())
			{
                while ($search_results->have_posts())
				{
					$search_results->the_post();
					$featured_img_url = get_the_post_thumbnail_url($search_results->post->ID,'propertya-user-thumb'); 
					$all_listings[] = array( "id"  => $search_results->post->ID,"with_title" =>$search_results->post->post_title,"img"=> esc_url($featured_img_url),'link' => get_the_permalink($search_results->post->ID));
				}
				 wp_reset_postdata();
			}
			echo json_encode(array(
                "status" => $status,
                "error" => '',
                "data" => array(
                    "listings" => $all_listings,
                )
            ));
		}
		else
		{
			echo json_encode(array(
                "status" => false,
                "error" => '',
                "data" => array()
            ));
		}
		die();
	}
}

//Simple Search Suggestions
add_action('wp_ajax_nopriv_fetch_suggestions_shortcode', 'propertya_framework_live_suggestions_shortcode');
add_action('wp_ajax_fetch_suggestions_shortcode', 'propertya_framework_live_suggestions_shortcode');
if (!function_exists('propertya_framework_live_suggestions_shortcode'))
{
    function propertya_framework_live_suggestions_shortcode()
	{
		if (!empty($_GET['q']))
		{
			$post_type = 'property';
			$meta_query = array(
					'key'       => 'prop_status',
					'value'     => '1',
					'compare'   => '=',
			);
            $tags = $all_listings = $cat_array = array();
            $keyword = strtolower($_GET['q']);
            $status = true;
            $search_results = new WP_Query(array(
                's' =>trim(sanitize_text_field($keyword)),
                'post_type' => $post_type,
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1,
                'posts_per_page' => 15,
                'fields' => 'ids',
				'meta_query'    => array(
					$meta_query
				)
            ));
			if ($search_results->have_posts())
			{
                while ($search_results->have_posts())
				{
					$search_results->the_post();
                    $property_id = get_the_ID();
					$all_idz = '';
					$all_idz = propertya_framework_fetch_gallery_idz($property_id);
					$all_listings[] = array( "id"  => $property_id,"with_title" =>get_the_title($property_id),"img"=> propertya_framework_img_src($all_idz,'thumbnail'),'link' => get_the_permalink($property_id));
				}
			}
             wp_reset_postdata();
			echo json_encode(array(
                "status" => $status,
                "error" => '',
                "data" => array(
                    "listings" => $all_listings,
                )
            ));
		}
		else
		{
			echo json_encode(array(
                "status" => false,
                "error" => '',
                "data" => array()
            ));
		}
		die();
	}
}
//Simple Search Suggestions Agents
add_action('wp_ajax_nopriv_fetch_suggestions_shortcode_agents', 'propertya_framework_live_suggestions_shortcode_agents');
add_action('wp_ajax_fetch_suggestions_shortcode_agents', 'propertya_framework_live_suggestions_shortcode_agents');
if (!function_exists('propertya_framework_live_suggestions_shortcode_agents'))
{
    function propertya_framework_live_suggestions_shortcode_agents()
	{
		if (!empty($_GET['q']))
		{
			$post_type = 'property-agents';
			$meta_query = array(
					'key'       => 'agent_status',
					'value'     => '1',
					'compare'   => '=',
			);
            $tags = $all_listings = $cat_array = array();
            $keyword = strtolower($_GET['q']);
            $status = true;
            $search_results = new WP_Query(array(
                's' =>trim(sanitize_text_field($keyword)),
                'post_type' => $post_type,
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1,
                'posts_per_page' => 15,
                'fields' => 'ids',
				'meta_query'    => array(
					$meta_query
				)
            ));
			if ($search_results->have_posts())
			{
                while ($search_results->have_posts())
				{
					$search_results->the_post();
                    $agent_id = get_the_ID();
					$featured_img_url = '';
                    $featured_img_url = esc_url(propertya_placeholder_images('agent',$agent_id,'propertya-user-thumb'));
					$all_listings[] = array( "id"  => $agent_id,"with_title" =>get_the_title($agent_id),"img"=> $featured_img_url,'link' => get_the_permalink($agent_id));
				}
			}
            wp_reset_postdata();
			echo json_encode(array(
                "status" => $status,
                "error" => '',
                "data" => array(
                    "listings" => $all_listings,
                )
            ));
		}
		else
		{
			echo json_encode(array(
                "status" => false,
                "error" => '',
                "data" => array()
            ));
		}
		die();
	}
}

//Simple Search Suggestions Agents
add_action('wp_ajax_nopriv_fetch_suggestions_shortcode_agency', 'propertya_framework_live_suggestions_shortcode_agency');
add_action('wp_ajax_fetch_suggestions_shortcode_agency', 'propertya_framework_live_suggestions_shortcode_agency');
if (!function_exists('propertya_framework_live_suggestions_shortcode_agency'))
{
    function propertya_framework_live_suggestions_shortcode_agency()
	{
		if (!empty($_GET['q']))
		{
			$post_type = 'property-agency';
			$meta_query = array(
					'key'       => 'agency_status',
					'value'     => '1',
					'compare'   => '=',
			);
            $tags = $all_listings = $cat_array = array();
            $keyword = strtolower($_GET['q']);
            $status = true;
            $search_results = new WP_Query(array(
                's' =>trim(sanitize_text_field($keyword)),
                'post_type' => $post_type,
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1,
                'posts_per_page' => 15,
                'fields' => 'ids',
				'meta_query'    => array(
					$meta_query
				)
            ));
			if ($search_results->have_posts())
			{
                while ($search_results->have_posts())
				{
					$search_results->the_post();
                    $agency_id = get_the_ID();
                    $featured_img_url = '';
                    $featured_img_url = esc_url(propertya_placeholder_images('agency',$agency_id,'propertya-user-thumb'));
					$all_listings[] = array( "id"  => $agency_id,"with_title" =>get_the_title($agency_id),"img"=> $featured_img_url,'link' => get_the_permalink($agency_id));
				}
				 wp_reset_postdata();
			}
			echo json_encode(array(
                "status" => $status,
                "error" => '',
                "data" => array(
                    "listings" => $all_listings,
                )
            ));
		}
		else
		{
			echo json_encode(array(
                "status" => false,
                "error" => '',
                "data" => array()
            ));
		}
		die();
	}
}


// Remove My Submitted Reviews
add_action('wp_ajax_delete_my_comment', 'propertya_framework_delete_submitted_comments');
if (!function_exists('propertya_framework_delete_submitted_comments'))
{
    function propertya_framework_delete_submitted_comments()
    {
		if(!wp_verify_nonce($_POST['security'], 'check-security'))
		{
			$return = array('message' => esc_html__('Invalid security token sent.', 'propertya-framework'));
			wp_send_json_error($return);
		}
        if (!is_user_logged_in())
		{
			$return = array('message' => esc_html__("You need to log in.", 'propertya-framework'));
			wp_send_json_error($return);
		}
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin( get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		if(!empty($_POST['comment_id']))
		{
			$comment_id = $_POST['comment_id'];
			wp_delete_comment($comment_id, true);
			$return = array('message' => esc_html__('Submitted review removed successfully.', 'propertya-framework'));
			wp_send_json_success($return);
		}
		else
		{
			$return = array('message' => esc_html__('There was an error while processing your request. Please, reload the page and try again.', 'propertya-framework'));
			wp_send_json_error($return);
		}
    }
}


// Enable Cron Jobs to expire simple listings
add_action('init', 'propertya_framework_register_daily_check',10,2);
if (!function_exists('propertya_framework_register_daily_check'))
{
    function propertya_framework_register_daily_check()
    {
        $job = 'daily';
        $is_active_job = propertya_framework_get_options('prop_regular_cron_switch');
        $job = propertya_framework_get_options('prop_regular_cron_switch_interval');
        if(!empty($is_active_job) && $is_active_job == true)
        {
            if ( !wp_next_scheduled( 'delete_property_revisions' ) )
            {
                wp_schedule_event(time(), $job, 'delete_property_revisions');
            }
        }
    }
}
add_action('delete_property_revisions', 'propertya_framework_delete_all_property_revisions');
if (!function_exists('propertya_framework_delete_all_property_revisions'))
{
    function propertya_framework_delete_all_property_revisions()
    {
        $args = array(
            'post_type' => 'property',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'meta_query'    => array(
                array(
                    'key'       => 'prop_status',
                    'value'     => '1',
                    'compare'   => '=',
                ),
            ),
	   );
       $results = new WP_Query( $args );
       if ( $results->have_posts() )
       {
           $nooff_days = $last_date = '';
           $status = 'expired';
           $now = date('Y-m-d');
           while ( $results->have_posts() )
           {
                $results->the_post();
                $property_id = get_the_ID();
                //check property expiry
                if (get_post_meta($property_id, 'prop_regular_listing_expiry', true) !="" && get_post_meta($property_id, 'prop_regular_listing_expiry_date', true) !="" && get_post_meta($property_id, 'prop_regular_listing_expiry', true) != '-1' )
                {
                    $last_date = get_post_meta($property_id, 'prop_regular_listing_expiry_date', true);
                    $nooff_days = get_post_meta($property_id, 'prop_regular_listing_expiry', true);
                    //$now = '2020-07-06';
                    if ($now > $last_date)
                    {
                        if (!empty(propertya_framework_get_options('prop_expiry_status')))
                        {
                          $status = propertya_framework_get_options('prop_expiry_status'); 
                        }
                        if($status == 'expired')
                        {
                            $my_post = array(
                              'ID'           => $property_id,
                              'post_status'   => 'expired',
                              'post_type' 	=> 'property'
                            );
                           $post_id = wp_update_post( $my_post );
                           if (!is_wp_error($post_id))
                           {
                              update_post_meta($property_id, 'prop_status', '0');
                              update_post_meta($property_id, 'prop_expired', 'yes');
                              update_post_meta($property_id, 'prop_is_feature_listing', '0');
                              update_post_meta($property_id, 'prop_regular_listing_expiry_date', '');    
                              update_post_meta($property_id, 'prop_regular_listing_expiry', '');
                              propertya_framework_regular_ad_expiry($property_id);
                           }
                        }
                        else
                        {
                            update_post_meta($property_id, 'prop_status', '0');
                            update_post_meta($property_id, 'prop_expired', 'yes');
                            update_post_meta($property_id, 'prop_is_feature_listing', '0');
                            update_post_meta($property_id, 'prop_regular_listing_expiry_date', '');    
                            update_post_meta($property_id, 'prop_regular_listing_expiry', '');
                            wp_trash_post($property_id);
                            propertya_framework_regular_ad_expiry($property_id);
                        }
                    }
                }
           }
       }
       wp_reset_postdata();
    }
}
register_deactivation_hook( __FILE__, 'propertya_framework_regular_deactivate' ); 
function propertya_framework_regular_deactivate() {
    $timestamp = wp_next_scheduled( 'delete_property_revisions' );
    wp_unschedule_event( $timestamp, 'delete_property_revisions' );
}


// Enable Cron Jobs to expire featured listings
add_action('init', 'propertya_framework_register_daily_check_featured',10,2);
if (!function_exists('propertya_framework_register_daily_check_featured'))
{
    function propertya_framework_register_daily_check_featured()
    {
        $job = 'daily';
        $is_active_job = propertya_framework_get_options('prop_featured_cron_switch');
        $job = propertya_framework_get_options('prop_featured_cron_switch_interval');
        if(!empty($is_active_job) && $is_active_job == true)
        {
            if ( !wp_next_scheduled( 'delete_featured_listings' ) )
            {
                wp_schedule_event(time(), $job, 'delete_featured_listings');
            }
        }
    }
}
add_action('delete_featured_listings', 'propertya_framework_delete_featured_listings');
if (!function_exists('propertya_framework_delete_featured_listings'))
{
    function propertya_framework_delete_featured_listings()
    {
        $args = array(
            'post_type' => 'property',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'meta_query'    => array(
                array(
                    'key'       => 'prop_is_feature_listing',
                    'value'     => '1',
                    'compare'   => '=',
                ),
            ),
	   );
       $results = new WP_Query( $args );
       if ( $results->have_posts() )
       {
           $now = date('Y-m-d');
           while ( $results->have_posts() )
           {
                $results->the_post();
                $property_id = get_the_ID();
                if (get_post_meta($property_id, 'prop_is_feature_listing', true) !="" && get_post_meta($property_id, 'prop_is_feature_listing', true) == '1' )
                {
                    $featured_expiry_for = '';
                    $featured_expiry_for = get_post_meta($property_id, 'prop_feature_listing_for', true);
                    if(isset($featured_expiry_for) && $featured_expiry_for !="" && $featured_expiry_for !="0" && $featured_expiry_for !="-1")
                    {
                        if ($now < $featured_expiry_for)
                        {
                           update_post_meta($property_id, 'prop_feature_listing_for', '');
                           update_post_meta($property_id, 'prop_is_feature_listing', 0);
                           update_post_meta($property_id, 'prop_feature_listing_date','');
                           // featured ad expiry email
                           propertya_framework_featured_ad_expiry($property_id);
                        }
                    }
                }
           }
       }
       wp_reset_postdata();
    }
}
register_deactivation_hook( __FILE__, 'propertya_framework_featured_cron_deactivate' ); 
function propertya_framework_featured_cron_deactivate() {
    $timestamp = wp_next_scheduled( 'delete_featured_listings' );
    wp_unschedule_event( $timestamp, 'delete_featured_listings' );
}




//Compare Listings
add_action('wp_ajax_prop_listing_compare', 'propertya_framework_compare_listings');
add_action('wp_ajax_nopriv_prop_listing_compare', 'propertya_framework_compare_listings');
if (!function_exists('propertya_framework_compare_listings'))
{
    function propertya_framework_compare_listings()
	{
		if(!wp_verify_nonce($_POST['security'], 'check-security'))
		{
			$return = array('message' => esc_html__('Invalid security token sent.', 'propertya-framework'));
			wp_send_json_error($return);
		}
		if(!empty($_POST['compare_listing']))
		{
            
            $compare_listing = (int)$_POST['compare_listing'];
            
            
                 session_start();
                
                 if (!isset($_SESSION['compare_listings']))
                 {
                     $_SESSION['compare_listings'] = array();
                 }
                 if( is_array( $_SESSION[ 'compare_listings' ] ) && !empty($_SESSION[ 'compare_listings' ] ) && in_array( $compare_listing, $_SESSION[ 'compare_listings' ] ))
                 {
                     if (($key = array_search($compare_listing,  $_SESSION[ 'compare_listings' ])) !== false) {
                      unset($_SESSION['compare_listings'][$key]);
                     }
                 }
                 else if(!empty($_SESSION[ 'compare_listings' ] ) && count($_SESSION[ 'compare_listings' ] ) >= 3)
                 {
                     $return = array('message' => esc_html__('There was an error while processing your request. Please, reload the page and try again.', 'propertya-framework'));
			         wp_send_json_error($return);
                 }
                 else
                 {
                    array_push($_SESSION['compare_listings'], $compare_listing);
                 }
            
                $custom_msg = $all_idz = $compare_list = '';
                if(!empty($_SESSION['compare_listings']) && is_array($_SESSION['compare_listings']) && count($_SESSION['compare_listings']) > 0)
                {
               $i = 1;
               $page_link = propertya_framework_get_link('page-compare.php');
               foreach($_SESSION['compare_listings'] as $property_id)
               {
                   $all_idz = '';
                   $all_idz = propertya_framework_fetch_gallery_idz($property_id);
                   if ($i == 2 || $i == 3){ $compare_list .='<div class="vsbox">vs</div>'; }
                   $compare_list .='<div class="compare-listings-box">
                    <a href="javascript:void(0)" class="remove_compare_list" data-property-id="'.esc_attr($property_id).'"><i class="fas fa-times"></i></a>
                     <a class="clr-black" href="'.esc_url(get_the_permalink($property_id)).'"><img class="img-fluid" src="'.esc_url(propertya_framework_img_src($all_idz,'propertya-blog-thumb')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'"></a>
                    </div>';
                   
                   $i++;
                   
               }
               $compare_list .='<div class="compare-action-btns"><a class="btn btn-theme btn-block btn-custom-sm" href="'.esc_url($page_link).'">'.esc_html__('Compare','propertya-framework').'</a>
                    <a class="btn btn-warning btn-block btn-custom-sm clear-all-compare">'.esc_html__('Clear All','propertya-framework').'</a></div>';
                $return = array('compare_list' => $compare_list);
                wp_send_json_success($return);  
            }
            else
            {
                $return = array('custom_msg' => propertya_framework_get_options('prop_empty_list'));
                wp_send_json_error($return);  
            }

        }
        else
		{
			$return = array('message' => esc_html__('There was an error while processing your request. Please, reload the page and try again.', 'propertya-framework'));
			wp_send_json_error($return);
		}
    }
}


//Clear All Compare Listings
add_action('wp_ajax_prop_listing_compare_clear', 'propertya_framework_compare_listings_clearall');
add_action('wp_ajax_nopriv_prop_listing_compare_clear', 'propertya_framework_compare_listings_clearall');
if (!function_exists('propertya_framework_compare_listings_clearall'))
{
    function propertya_framework_compare_listings_clearall()
	{
        //if( !session_id() )
        //{
            session_start();
            unset($_SESSION['compare_listings']);
            $compare_list = array();
            $return = array('compare_list' => $compare_list);
            wp_send_json_success($return);  
       // }
    }
}



// update Meta
add_action('wp_ajax_update_meta', 'propertya_framework_update_meta');
if (!function_exists('propertya_framework_update_meta'))
{ 
	function propertya_framework_update_meta()
	{

        $args = array(
            'post_type' => 'property',
            'posts_per_page' => -1,
            'fields' => 'ids',
           
	   );
       $query = new WP_Query($args); 
           while ( $query->have_posts() )
           {
                $query->the_post();
                $property_id = get_the_ID();
                $postmeta = get_post_meta( $property_id , 'prop_is_feature_listing', true);
                if($postmeta  == 0  || $postmeta  == ""){

                    update_post_meta( $property_id , 'prop_is_feature_listing', 0);
                }    
           }
    }
} 
//custom fields
add_action('wp_ajax_prop_get_custom', 'propertya_framework_get_custom');
add_action('wp_ajax_nopriv_prop_get_custom', 'propertya_framework_get_custom');
if (!function_exists('propertya_framework_get_custom'))
{
    function propertya_framework_get_custom()
    {
        if (!empty($_POST['cat_parent']))
        {
            $col = ''; $cus_type =  $selected_type = $result = '';
            $category_details = array();
            $parent_category = $_POST['cat_parent'];
            $category_details = get_term_by('slug',$parent_category, 'property_type');
            if(!empty($category_details))
            {
                if(isset($_POST['is_search']) && $_POST['is_search'] == 1)
                {
                    $col = 'col-12';
                    $cus_type = 'search-page';
                }
                $selected_type = $category_details->term_id;
                $custom_fields_html = '';
                $fields_data = array();
                
                $template_group_key = apply_filters('propertya_framework_acf_get_group_key', '',$selected_type);

                
                if (isset($template_group_key) && $template_group_key != '' && class_exists('ACF')) {
                    $fields_data = acf_get_fields($template_group_key);
                    $custom_fields_html = apply_filters('propertya_framework_acf_frontend_html', '', $fields_data, 0, $col, $cus_type);
                    if(!empty($custom_fields_html))
                    {
                        $return = array('fields' => $custom_fields_html);
                        wp_send_json_success($return);
                    }
                    else
                    {
                        return false;
                        die();
                    }
                }
            }
            else
            {
                $return = array('fields' => '');
                wp_send_json_error($return);
            }
        }
    }
}



// Search By Categories
add_action('wp_ajax_prop_get_search_cats', 'propertya_framework_get_search_categories');
add_action('wp_ajax_nopriv_prop_get_search_cats', 'propertya_framework_get_search_categories');
if (!function_exists('propertya_framework_get_search_categories'))
{
    function propertya_framework_get_search_categories()
    {
        if (!empty($_POST['make_id']))
        {
            $childs  = $termchildren = $final_content = $params =  array();
            $cat_slug = $_POST['make_id'];
            $remove = $to_parent = $data = '';
            $get_term = get_term_by('slug', $cat_slug,'property_type');
            if(!empty($get_term) &&  count((array) $get_term) > 0)
            {
                
                $data = '';
                $termchildren = get_terms(array('taxonomy'=> $get_term->taxonomy,'hide_empty' => false,'parent' => (int) $get_term->term_id) );
                if(!empty($termchildren) && is_array($termchildren) && count($termchildren) > 0)
                {
                    foreach ($termchildren as $child)
                    {
                        $data .= '<li>
                                    <div class="pretty p-svg p-curve">
                                        <input class="make-check" type="radio" value="'.esc_attr($child->slug).'" />
                                        <div class="state p-primary">
                                            <svg class="svg svg-icon" viewBox="0 0 20 20">
                                        <path d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z" style="stroke: white;fill:white;"></path>
                                    </svg>
                                            <label>'. esc_html($child->name).'</label>
                                        </div>
                                    </div>
                                </li>';
                    }
                
                    //
                    $to_parent = get_term_by('id',$get_term->parent,'property_type');
                    if(empty($to_parent->slug))
                    {
                        $slug = '';
                    }
                    else
                    {
                        $slug = $to_parent->slug;
                    }
                    $remove = '<span class="cat-tag">
                      <span class="cat-content">'.$get_term->name.'</span>
                      <span class="cat-rm-lnk" data-term-parent="'.esc_attr($slug).'" data-term-slug="'.esc_attr($get_term->slug).'">x</span>
                    </span>';
                    $return = array('result' => $data, 'selected_tag' => $remove);
                    wp_send_json_success($return);
                }
                else
                {
                     $to_parent = get_term_by('id',$get_term->parent,'property_type');
                    if(empty($to_parent->slug))
                    {
                        $slug = '';
                    }
                    else
                    {
                        $slug = $to_parent->slug;
                    }
                     $remove = '<span class="cat-tag">
                      <span class="cat-content">'.$get_term->name.'</span>
                      <span class="cat-rm-lnk" data-term-parent="'.esc_attr($slug).'" data-term-slug="'.esc_attr($get_term->slug).'">x</span>
                     </span>';
                     $return = array('result' => $data, 'selected_tag' => $remove);
                     wp_send_json_error($return);
                }
            }
        }
    }
}


// Search By Categories
add_action('wp_ajax_prop_return_parents_cats', 'propertya_framework_return_parents_cats');
add_action('wp_ajax_nopriv_prop_return_parents_cats', 'propertya_framework_return_parents_cats');
if (!function_exists('propertya_framework_return_parents_cats'))
{
    function propertya_framework_return_parents_cats()
    {
        if (!empty($_POST['cat_slug']))
        {
            $type = 'property_type';
            $class_name = 'make-check';
            if(!empty($_POST['type']))
            {
                $type = $_POST['type'];
                $class_name = 'loc-check';
            }
            $cat_slug = $_POST['cat_slug'];
            $data = '';
            $get_term = get_term_by('slug', $cat_slug,$type);
            if(!empty($get_term) &&  count((array) $get_term) > 0)
            {
               $termchildren = get_terms(array('taxonomy'=> $get_term->taxonomy,'hide_empty' => false,'parent' =>$get_term->parent) );
               if(!empty($termchildren) && is_array($termchildren) && count($termchildren) > 0)
               {
                    $data = '';
                    foreach ($termchildren as $child)
                    {
                        $data .= '<li>
                                    <div class="pretty p-svg p-curve">
                                        <input class="'.$class_name.'" type="radio" value="'.esc_attr($child->slug).'" />
                                        <div class="state p-primary">
                                            <svg class="svg svg-icon" viewBox="0 0 20 20">
                                        <path d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z" style="stroke: white;fill:white;"></path>
                                    </svg>
                                            <label>'. esc_html($child->name).'</label>
                                        </div>
                                    </div>
                                </li>';
                    }
                    $return = array('result' => $data);
                    wp_send_json_success($return);
               }
               else
               {
                 $return = array('result' => $data);
                 wp_send_json_error($return);
               }
            }
        }
    }
}
//Woocommerce Packages To Cart
add_action('wp_ajax_prop_package_cart', 'propertya_framework_package_to_cart');
add_action('wp_ajax_nopriv_prop_package_cart', 'propertya_framework_package_to_cart');
if (!function_exists('propertya_framework_package_to_cart'))
{
    function propertya_framework_package_to_cart()
	{
		if(!wp_verify_nonce($_POST['security'], 'check-security'))
		{
			$return = array('message' => esc_html__('Invalid security token sent.', 'propertya-framework'));
			wp_send_json_error($return);
		}
        if (!is_user_logged_in())
		{
			$return = array('message' => esc_html__("You need to log in.", 'propertya-framework'));
			wp_send_json_error($return);
		}
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin( get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
        $link = '#';
        $renewal_cart = new WC_Cart();
        $link =  WC()->cart->get_cart_url();
        $package_id = $_POST['package_id'];
        $qunatity = $_POST['qunatity'];
        $package_type = $_POST['pack_ref'];
        //for free packages only
        if(!empty($package_type) && $package_type == 'free')
        {
            $user_id = get_current_user_id();
            propertya_framework_store_user_package($user_id, $package_id);
            $renewal_cart->empty_cart();
            update_user_meta($user_id, 'prop_is_free_pgk',$package_id);
            $submit_page = propertya_framework_get_link('page-dashboard.php').'?page-type=submit-property';
            $return = array('message' => esc_html__('Package has been added.','propertya-framework'),'referral' =>$submit_page);
            wp_send_json_success($return); 
        }
        else
        {
           if(!empty($package_id) && !empty($qunatity) && !empty($package_type))
            {
                // Add product to cart
                $renewal_cart->add_to_cart($package_id,1);
                $return = array('message' => esc_html__('Package has been added to your cart.','propertya-framework'),'referral' =>$link);
                wp_send_json_success($return); 
            }
            else
            {
                $return = array('message' => esc_html__('There was an error while processing your request. Please, reload the page and try again.', 'propertya-framework'));
                wp_send_json_error($return);
            } 
        }
    }
}

if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))))
{
    // After Successfull payment
    add_action('woocommerce_order_status_completed', 'propertya_framework_after_buy_package', 10, 1);
    if (!function_exists('propertya_framework_after_buy_package')) 
    {
        function propertya_framework_after_buy_package($order_id)
        {
            $product_type = $order = $items = array();
            $order = new WC_Order($order_id);
            $user_id = $order->get_user_id();
            $items = $order->get_items();
            if(!empty($items) && count($items) > 0)
            {
                 foreach ($items as $item)
                 {
                     $product_id = $item['product_id'];
                     $product_type = wc_get_product($product_id);
                     if ($product_type->get_type() == 'propertya_packages') 
                     {
                         propertya_framework_store_user_package($user_id, $product_id);
                     }
                 }
            }
        }
    }

    //For Auto Approval order
    add_filter('woocommerce_thankyou', 'propertya_framework_approve_order_auto', 10, 4);
    if (!function_exists('propertya_framework_approve_order_auto'))
    {
        function propertya_framework_approve_order_auto($order_id)
        {
            $approval_type =  'auto-woo';
            if(!empty(propertya_framework_get_options('prop_woo_approval')))
            {
                $approval_type =  propertya_framework_get_options('prop_woo_approval');
            }
            $order = new WC_Order($order_id);
            if ($order->has_status('processing') || $order->has_status('on-hold')) 
            {
                if ($approval_type == 'auto-woo')
                {
                    $order->update_status('completed');
                }
            }
        }
    }
    // Store User Package Details
    if (!function_exists('propertya_framework_store_user_package'))
    {
        function propertya_framework_store_user_package($user_id, $product_id)
        {
            $regular_listing_expiry = $listing_featured_expiry = $pkg_exp = $featured_listing = $regular_listing = $listing_expiry = '';
            $pkg_exp = get_post_meta($product_id, 'prop_package_expiry', true);
            $regular_listing = get_post_meta($product_id, 'prop_regular_listing', true);
            $regular_listing_expiry = get_post_meta($product_id, 'prop_regular_listing_expiry', true);
            $featured_listing = get_post_meta($product_id, 'prop_featured_listing', true);
            $listing_featured_expiry = get_post_meta($product_id, 'prop_featured_listing_expiry', true);

            update_user_meta($user_id, 'prop_user_package_id', $product_id);
            //assign simple listings
            if (!empty($regular_listing) && $regular_listing == '-1')
            {
                update_user_meta($user_id, 'prop_pack_totallistings', '-1');  
            } 
            else if (!empty($regular_listing) && is_numeric($regular_listing) && $regular_listing != 0)
            {
                update_user_meta($user_id, 'prop_pack_totallistings', $regular_listing);
            }
            else
            {
                update_user_meta($user_id, 'prop_pack_totallistings', $regular_listing);
            }

            //assign featured listings
            if (!empty($featured_listing) && $featured_listing == '-1')
            {
                update_user_meta($user_id, 'prop_pack_featuredlistings', '-1');
            } 
            else if (!empty($featured_listing) && is_numeric($featured_listing) && $featured_listing != 0)
            {
                update_user_meta($user_id, 'prop_pack_featuredlistings', $featured_listing);
            }
            else
            {
                update_user_meta($user_id, 'prop_pack_featuredlistings', $$featured_listing);
            }

            //assign package days to user
            if (!empty($pkg_exp) && $pkg_exp == '-1')
            {
                update_user_meta($user_id, 'prop_pack_exp', '-1');
            } 
            else 
            {
                $new_expiry = date('Y-m-d', strtotime("+$pkg_exp days"));
                update_user_meta($user_id, 'prop_pack_exp', $new_expiry);
            }

            //featured listing expiry
            if (!empty($listing_featured_expiry) && $listing_featured_expiry == '-1')
            {
                update_user_meta($user_id, 'prop_pack_exp_featured_for', '-1');
            } 
            else
            {
                update_user_meta($user_id, 'prop_pack_exp_featured_for', $listing_featured_expiry);
            }
             //simple listing expiry
            if (!empty($regular_listing_expiry) && $regular_listing_expiry == '-1')
            {
                update_user_meta($user_id, 'prop_pack_simple_expiry_for', '-1');
            } 
            else
            {
                update_user_meta($user_id, 'prop_pack_simple_expiry_for', $regular_listing_expiry);
            }
        }
    }
}

