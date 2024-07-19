<?php
// Ajax handler for property submission
add_action( 'wp_ajax_prop_agency_update', 'propertya_framework_prop_agency_update' );
if (!function_exists ( 'propertya_framework_prop_agency_update' ))
{
	function propertya_framework_prop_agency_update()
	{
		$params = array();
		parse_str($_POST['collect_data'], $params);
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin(get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		if(!wp_verify_nonce($params['agency_up_nonce'], 'prop-agency-up-nonce'))
		{
			 $return = array('message' => esc_html__('Invalid security token sent.', 'propertya-framework'));
      		 wp_send_json_error($return);
   		}
		else
		{
			//sanatize fields
			if(isset($params[ 'agency_id' ]) && $params['agency_id' ]!="")
			{
				$agency_id = $params[ 'agency_id' ];
				$desc = isset( $params[ 'about-agency' ] ) ? wp_kses_post( $params[ 'about-agency' ] ) : '';
				$agency_name = isset( $params[ 'agency-name' ] ) ? wp_kses_post( $params[ 'agency-name' ] ) : '';
				$agency_email = isset( $params[ 'agency-email' ] ) ? sanitize_email( $params[ 'agency-email' ] ) : '';
				$agency_mobile = isset( $params[ 'agency-mobile' ] ) ? sanitize_text_field( $params[ 'agency-mobile' ] ) : '';
				$agency_whats = isset( $params[ 'agency-whats' ] ) ? sanitize_text_field( $params[ 'agency-whats' ] ) : '';
				$agency_office = isset( $params[ 'agency-office' ] ) ? sanitize_text_field( $params[ 'agency-office' ] ) : '';
				$agency_fax = isset( $params[ 'agency-fax' ] ) ? sanitize_text_field( $params[ 'agency-fax' ] ) : '';
				$agency_licence = isset( $params[ 'agency-licence' ] ) ? sanitize_text_field( $params[ 'agency-licence' ] ) : '';
				$agency_tax = isset( $params['agency-tax']) ? sanitize_text_field( $params['agency-tax'] ) : '';
				$agency_url = isset( $params[ 'agency-url' ] ) ? sanitize_text_field( $params[ 'agency-url' ] ) : '';
				$agency_location = isset( $params[ 'agency-location' ] ) ? sanitize_text_field( $params[ 'agency-location' ] ) : '';
				$agency_fb = isset( $params[ 'agency-fb' ] ) ? sanitize_text_field( $params[ 'agency-fb' ] ) : '';
				$agency_tw = isset( $params[ 'agency-tw' ] ) ? sanitize_text_field( $params[ 'agency-tw' ] ) : '';
				$agency_in = isset( $params[ 'agency-in' ] ) ? sanitize_text_field( $params[ 'agency-in' ] ) : '';
				$agency_insta = isset( $params[ 'agency-insta' ] ) ? sanitize_text_field( $params[ 'agency-insta' ] ) : '';
				$agency_you = isset( $params[ 'agency-you' ] ) ? sanitize_text_field( $params[ 'agency-you' ] ) : '';
				$agency_pin = isset( $params[ 'agency-pin' ] ) ? sanitize_text_field( $params[ 'agency-pin' ] ) : '';
				$agency_street_addr = isset( $params[ 'agency-address' ] ) ? sanitize_text_field( $params[ 'agency-address' ] ) : '';
				$agency_latt = isset( $params[ 'agency-latt' ] ) ? sanitize_text_field( $params[ 'agency-latt' ] ) : '';
				$agency_long = isset( $params[ 'agency-long' ] ) ? sanitize_text_field( $params[ 'agency-long' ] ) : '';
				// Update the meta field in the database.
				$my_agency = array(
				  'ID'           => $agency_id,
				  'post_title'   => wp_strip_all_tags($agency_name),
				  'post_content' => $desc,
				  'post_author'   => get_current_user_id(),
				  'post_status'   => 'publish',
				  'post_type' 	=> 'property-agency'
  				);
  				wp_update_post($my_agency);
				update_post_meta($agency_id, 'agency_status', '1' );
				update_post_meta($agency_id, 'agency_email', $agency_email);
				update_post_meta($agency_id, 'agency_mobile', $agency_mobile );
				update_post_meta($agency_id, 'agency_whats', $agency_whats );
				update_post_meta($agency_id, 'agency_office', $agency_office );
				update_post_meta($agency_id, 'agency_fax', $agency_fax);
				update_post_meta($agency_id, 'agency_licence', $agency_licence );
				update_post_meta($agency_id, 'agency_tax', $agency_tax);
				update_post_meta($agency_id, 'agency_url', $agency_url);
				update_post_meta($agency_id, 'agency_fb', $agency_fb);
				update_post_meta($agency_id, 'agency_tw', $agency_tw);
				update_post_meta($agency_id, 'agency_in', $agency_in );
				update_post_meta($agency_id, 'agency_insta', $agency_insta);
				update_post_meta($agency_id, 'agency_you', $agency_you);
				update_post_meta($agency_id, 'agency_pin', $agency_pin);
				update_post_meta($agency_id, 'agency_street_addr', $agency_street_addr);
				update_post_meta($agency_id, 'agency_latt', $agency_latt);
				update_post_meta($agency_id, 'agency_long', $agency_long);
				//agency location
				wp_set_object_terms($agency_id, propertya_framework_get_ancestors($agency_location,'agency_location'), 'agency_location');
				update_post_meta($agency_id, 'agency_location', $agency_location);
				$return = array('message' => esc_html__('Account settings updated successfully.', 'propertya-framework' ),'link' => get_the_permalink($agency_id));
      		 	wp_send_json_success($return);
			}
			else
			{
				$return = array('message' => esc_html__('Something went wrong, please try again.', 'propertya-framework'));
      		 	wp_send_json_error($return);
			}
  		}
	}
}

// update my password
add_action( 'wp_ajax_prop_mypass_up', 'propertya_framework_prop_update_mypass' );
if (!function_exists ( 'propertya_framework_prop_update_mypass' ))
{
	function propertya_framework_prop_update_mypass()
	{
		$params = array();
		parse_str($_POST['collect_data'], $params);
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin(get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		if(!wp_verify_nonce($params['mypass_up_nonce'], 'prop-my_pass'))
		{
			 $return = array('message' => esc_html__('Invalid security token sent.', 'propertya-framework'));
      		 wp_send_json_error($return);
   		}
		else
		{
			$user_id = get_current_user_id();
			$user = get_user_by('ID',$user_id);
			if(!empty($params['my_previous_pass']) && !empty($params['my_new_pass']) && !empty($params['my_confirm_pass']))
			{
				if($params['my_new_pass'] == $params['my_confirm_pass'])
				{
					if($user && wp_check_password($params['my_previous_pass'], $user->data->user_pass, $user->ID ))
					{
						//setup new password
						wp_set_password($params['my_new_pass'], $user->ID);
						$return = array('message' => esc_html__('Your password has been changed successfully
.', 'propertya-framework' ));
						wp_send_json_success($return);
					}
					else
					{
						$return = array('message' => esc_html__('The old password you have entered is incorrect.', 'propertya-framework'));
						wp_send_json_error($return);
					}
				}
				else
				{
					$return = array('message' => esc_html__("The password and confirm password do not match
.", 'propertya-framework'));
      		 	wp_send_json_error($return);
				}
			}
			else
			{
				$return = array('message' => esc_html__('Something went wrong, please try again.', 'propertya-framework'));
      		 	wp_send_json_error($return);
			}
		}
	}
}

// delete my account
add_action( 'wp_ajax_prop_myacc_del', 'propertya_framework_prop_del_my_account' );
if (!function_exists ( 'propertya_framework_prop_del_my_account' ))
{
	function propertya_framework_prop_del_my_account()
	{
		$params = array();
		parse_str($_POST['collect_data'], $params);
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin(get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		if(!wp_verify_nonce($params['mypass_account_del_nonce'], 'prop-my_pass_dell'))
		{
			 $return = array('message' => esc_html__('Invalid security token sent.', 'propertya-framework'));
      		 wp_send_json_error($return);
   		}
		else
		{
			if(is_super_admin($params['active_user']))
			{
				$return = array('message' => esc_html__('You can not delete your account as Admin.', 'propertya-framework'));
      		 	wp_send_json_error($return);
			}
			else
			{
				// delete comment with that user id
				$c_args = array ('user_id' =>$params['active_user'],'post_type' => 'any','status' => 'all');
				$comments = get_comments($c_args);
				if(count((array) $comments) > 0 )
				{
					foreach($comments as $comment) :
						wp_delete_comment($comment->comment_ID, true);
					endforeach;
				}
				// delete user posts
				$args = array ('numberposts' => -1,'post_type' => 'any','author' => $params['active_user']);
				$user_posts = get_posts($args);
				// delete all the user posts
				if(count((array) $user_posts) > 0 )
				{
					foreach ($user_posts as $user_post)
					{
						wp_delete_post($user_post->ID, true);
					}
				}
				//now delete actual user
				if ( is_multisite() )
				{
					 wpmu_delete_user($params['active_user']);
				}
				wp_delete_user($params['active_user']);
				$return = array('message' => esc_html__('Your account has been deleted.', 'propertya-framework' ), 'link' => get_home_url());
				wp_send_json_success($return);
			}
		}
	}
}

// Set featured Image
add_action( 'wp_ajax_prop_myfeatured_img', 'propertya_framework_my_featured_img' );
if (!function_exists ( 'propertya_framework_my_featured_img' ))
{
	function propertya_framework_my_featured_img()
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
				$arr_img_ext = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif');
				if (in_array($_FILES['file']['type'], $arr_img_ext))
				{
					$user_id = get_current_user_id();
					$post_id = '';
					if(get_user_meta( $user_id, 'prop_post_id' , true ) !="")
					{
					  $post_id = get_user_meta( $user_id, 'prop_post_id' , true );
					}
					 $upload = wp_upload_bits($_FILES["file"]["name"], null, file_get_contents($_FILES["file"]["tmp_name"]));
					 $post_id = $post_id; //set post id to which you need to set post thumbnail
					 $filename = $upload['url'];
					 $wp_filetype = wp_check_filetype($filename, null);
					 $attachment = array(
						'post_mime_type' => $wp_filetype['type'],
						'post_title' => sanitize_file_name($filename),
						'post_content' => '',
						'post_status' => 'inherit'
    				);
					$old_thumb_id = '';
					$old_thumb_id = get_post_thumbnail_id($post_id);
					wp_delete_attachment($old_thumb_id, true);
					$attach_id = wp_insert_attachment( $attachment, $filename, $post_id );
					
   					require_once(ABSPATH . 'wp-admin/includes/image.php');
					//$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
					$attach_data = wp_generate_attachment_metadata( $attach_id, $upload['file'] );
					wp_update_attachment_metadata( $attach_id, $attach_data );
					$success = set_post_thumbnail( $post_id, $attach_id );
					if($success)
					{
						//get attach image url 
						$image_link = wp_get_attachment_image_src( $attach_id, 'full' );
						$return = array('message' => esc_html__('Image uploaded successfully.', 'propertya-framework' ), 'img_link' => $image_link[0]);
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


// Set Cover Image
add_action( 'wp_ajax_prop_myfeatured_cover', 'propertya_framework_my_featured_cover' );
if (!function_exists ( 'propertya_framework_my_featured_cover' ))
{
	function propertya_framework_my_featured_cover()
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
				
				$arr_img_ext = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif');
				if (in_array($_FILES['file']['type'], $arr_img_ext))
				{
					$user_id = get_current_user_id();
					$post_id = '';
					if(get_user_meta( $user_id, 'prop_post_id' , true ) !="")
					{
					  $post_id = get_user_meta( $user_id, 'prop_post_id' , true );
					}
					 $upload = wp_upload_bits($_FILES["file"]["name"], null, file_get_contents($_FILES["file"]["tmp_name"]));
					 $post_id = $post_id; //set post id to which you need to set post thumbnail
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
						//delete old attachment
						if(get_post_meta($post_id, 'my_cover_featuredimg', true ) !="")
						{
							$id_to_delete = get_post_meta($post_id, 'my_cover_featuredimg', true );
							wp_delete_attachment($id_to_delete, true);
						}
						update_post_meta($post_id, 'my_cover_featuredimg', $attach_id);
						//get attach image url 
						$image_link = wp_get_attachment_image_src( $attach_id, 'propertya-blog-thumb' );
						$return = array('message' => esc_html__('Image uploaded successfully.', 'propertya-framework' ), 'img_link' => $image_link[0]);
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

/*
	Agents Settings Starts Here
*/
// Ajax handler for property submission
add_action( 'wp_ajax_prop_agent_update', 'propertya_framework_prop_agent_update' );
if (!function_exists ( 'propertya_framework_prop_agent_update' ))
{
	function propertya_framework_prop_agent_update()
	{
		$params = array();
		parse_str($_POST['collect_data'], $params);
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin(get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		if(!wp_verify_nonce($params['agent_up_nonce'], 'prop-agent-up-nonce'))
		{
			 $return = array('message' => esc_html__('Invalid security token sent.', 'propertya-framework'));
      		 wp_send_json_error($return);
   		}
		else
		{
			//sanatize fields
			if(isset($params[ 'agent_id' ]) && $params['agent_id' ]!="")
			{
				$agent_id = $params[ 'agent_id' ];
				$desc = isset( $params[ 'about-agent' ] ) ? wp_kses_post( $params[ 'about-agent' ] ) : '';
				$agent_name = isset( $params[ 'agent-name' ] ) ? wp_kses_post( $params[ 'agent-name' ] ) : '';
				$agent_email = isset( $params[ 'agent-email' ] ) ? sanitize_text_field( $params[ 'agent-email' ] ) : '';
				$agent_pos = isset( $params[ 'agent_desgin' ] ) ? sanitize_text_field( $params[ 'agent_desgin' ] ) : '';
				$agent_type = isset( $params[ 'agent-type' ] ) ? sanitize_text_field( $params[ 'agent-type' ] ) : '';
				$agent_location = isset( $params[ 'agent-location' ] ) ? sanitize_text_field( $params[ 'agent-location' ] ) : '';
				$agent_mobile = isset( $params[ 'agent-mobile' ] ) ? sanitize_text_field( $params[ 'agent-mobile' ] ) : '';
				$agent_whats = isset( $params[ 'agent-whats' ] ) ? sanitize_text_field( $params[ 'agent-whats' ] ) : '';
				$agent_office = isset( $params[ 'agent-office' ] ) ? sanitize_text_field( $params[ 'agent-office' ] ) : '';
				$agent_fax = isset( $params[ 'agent-fax' ] ) ? sanitize_text_field( $params[ 'agent-fax' ] ) : '';
				$agent_url = isset( $params[ 'agent-url' ] ) ? sanitize_text_field( $params[ 'agent-url' ] ) : '';
				$agent_hours = isset( $params[ 'agent-hours' ] ) ? sanitize_text_field( $params['agent-hours' ] ) : '';
				$agent_skype = isset( $params[ 'agent-skype' ] ) ? sanitize_text_field( $params['agent-skype' ] ) : '';
				$agent_fb = isset( $params[ 'agent-fb' ] ) ? sanitize_text_field( $params[ 'agent-fb' ] ) : '';
				$agent_tw = isset( $params[ 'agent-tw' ] ) ? sanitize_text_field( $params[ 'agent-tw' ] ) : '';
				$agent_in = isset( $params[ 'agent-in' ] ) ? sanitize_text_field( $params[ 'agent-in' ] ) : '';
				$agent_insta = isset( $params[ 'agent-insta' ] ) ? sanitize_text_field( $params[ 'agent-insta' ] ) : '';
				$agent_you = isset( $params[ 'agent-you' ] ) ? sanitize_text_field( $params[ 'agent-you' ] ) : '';
				$agent_pin = isset( $params[ 'agent-pin' ] ) ? sanitize_text_field( $params[ 'agent-pin' ] ) : '';
				$agent_street_addr = isset( $params[ 'agent-address' ] ) ? sanitize_text_field( $params[ 'agent-address' ] ) : '';
				$agent_latt = isset( $params[ 'agent-latt' ] ) ? sanitize_text_field( $params[ 'agent-latt' ] ) : '';
				$agent_long = isset( $params[ 'agent-long' ] ) ? sanitize_text_field( $params[ 'agent-long' ] ) : '';
				
				// Update the meta field in the database.
				$my_agent = array(
				  'ID'           => $agent_id,
				  'post_title'   => wp_strip_all_tags($agent_name),
				  'post_content' => $desc,
				  'post_author'   => get_current_user_id(),
				  'post_status'   => 'publish',
				  'post_type' 	=> 'property-agents'
  				);
  				wp_update_post($my_agent);
				update_post_meta($agent_id, 'agent_status', '1' );
				update_post_meta($agent_id, 'agent_email', $agent_email);
				update_post_meta($agent_id, 'agent_pos', $agent_pos);
				//type
				wp_set_object_terms($agent_id, $agent_type, 'agent_types');
				update_post_meta($agent_id, 'agent_type', $agent_type);
				//location
				wp_set_object_terms($agent_id, propertya_framework_get_ancestors($agent_location,'agent_location'), 'agent_location');
				update_post_meta($agent_id, 'agent_location', $agent_location);
				
				update_post_meta($agent_id, 'agent_mobile', $agent_mobile );
				update_post_meta($agent_id, 'agent_whats', $agent_whats );
				update_post_meta($agent_id, 'agent_office', $agent_office );
				update_post_meta($agent_id, 'agent_fax', $agent_fax);
				update_post_meta($agent_id, 'agent_url', $agent_url);
				update_post_meta($agent_id, 'agent_hours', $agent_hours);
				update_post_meta($agent_id, 'agent_skype', $agent_skype );
				update_post_meta($agent_id, 'agent_fb', $agent_fb);
				update_post_meta($agent_id, 'agent_tw', $agent_tw);
				update_post_meta($agent_id, 'agent_in', $agent_in );
				update_post_meta($agent_id, 'agent_insta', $agent_insta);
				update_post_meta($agent_id, 'agent_you', $agent_you);
				update_post_meta($agent_id, 'agent_pin', $agent_pin);
				update_post_meta($agent_id, 'agent_street_addr', $agent_street_addr);
				update_post_meta($agent_id, 'agent_latt', $agent_latt);
				update_post_meta($agent_id, 'agent_long', $agent_long);
				//agency location
				
				$return = array('message' => esc_html__('Account settings updated successfully.', 'propertya-framework' ),'link' => get_the_permalink($agent_id));
      		 	wp_send_json_success($return);
			}
			else
			{
				$return = array('message' => esc_html__('Something went wrong, please try again.', 'propertya-framework'));
      		 	wp_send_json_error($return);
			}
  		}
	}
}


// Buyer Profile Update
add_action( 'wp_ajax_prop_buyer_update', 'propertya_framework_prop_buyer_update' );
if (!function_exists ( 'propertya_framework_prop_buyer_update' ))
{
	function propertya_framework_prop_buyer_update()
	{
		$params = array();
		parse_str($_POST['collect_data'], $params);
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin(get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		if(!wp_verify_nonce($params['buyer_up_nonce'], 'prop-buyer-up-nonce'))
		{
			 $return = array('message' => esc_html__('Invalid security token sent.', 'propertya-framework'));
      		 wp_send_json_error($return);
   		}
		else
		{
			//sanatize fields
			if(isset($params[ 'buyer_id' ]) && $params['buyer_id' ]!="")
			{
				$buyer_id = $params[ 'buyer_id' ];
				$desc = isset( $params[ 'about-buyer' ] ) ? wp_kses_post( $params[ 'about-buyer' ] ) : '';
				$buyer_name = isset( $params[ 'buyer-name' ] ) ? wp_kses_post( $params[ 'buyer-name' ] ) : '';
				$buyer_email = isset( $params[ 'buyer-email' ] ) ? sanitize_text_field( $params[ 'buyer-email' ] ) : '';
				$buyer_mobile = isset( $params[ 'buyer-mobile' ] ) ? sanitize_text_field( $params[ 'buyer-mobile' ] ) : '';
				$buyer_whats = isset( $params[ 'buyer-whats' ] ) ? sanitize_text_field( $params[ 'buyer-whats' ] ) : '';
				$buyer_fb = isset( $params[ 'buyer-fb' ] ) ? sanitize_text_field( $params[ 'buyer-fb' ] ) : '';
				$buyer_tw = isset( $params[ 'buyer-tw' ] ) ? sanitize_text_field( $params[ 'buyer-tw' ] ) : '';
				$buyer_in = isset( $params[ 'buyer-in' ] ) ? sanitize_text_field( $params[ 'buyer-in' ] ) : '';
				$buyer_insta = isset( $params[ 'buyer-insta' ] ) ? sanitize_text_field( $params[ 'buyer-insta' ] ) : '';
				$buyer_pin = isset( $params[ 'buyer-pin' ] ) ? sanitize_text_field( $params[ 'buyer-pin' ] ) : '';
				$buyer_street_addr = isset( $params[ 'buyer-address' ] ) ? sanitize_text_field( $params[ 'buyer-address' ] ) : '';
				$buyer_latt = isset( $params[ 'buyer-latt' ] ) ? sanitize_text_field( $params[ 'buyer-latt' ] ) : '';
				$buyer_long = isset( $params[ 'buyer-long' ] ) ? sanitize_text_field( $params[ 'buyer-long' ] ) : '';
				
				// Update the meta field in the database.
				$my_buyer = array(
				  'ID'           => $buyer_id,
				  'post_title'   => wp_strip_all_tags($buyer_name),
				  'post_content' => $desc,
				  'post_author'   => get_current_user_id(),
				  'post_status'   => 'publish',
				  'post_type' 	=> 'property-buyers'
  				);
  				wp_update_post($my_buyer);
				update_post_meta($buyer_id, 'buyer_status', '1' );
				update_post_meta($buyer_id, 'buyer_email', $buyer_email);
				update_post_meta($buyer_id, 'buyer_pos', $buyer_pos);
				update_post_meta($buyer_id, 'buyer_mobile', $buyer_mobile );
				update_post_meta($buyer_id, 'buyer_whats', $buyer_whats );
				update_post_meta($buyer_id, 'buyer_fb', $buyer_fb);
				update_post_meta($buyer_id, 'buyer_tw', $buyer_tw);
				update_post_meta($buyer_id, 'buyer_in', $buyer_in );
				update_post_meta($buyer_id, 'buyer_insta', $buyer_insta);
				update_post_meta($buyer_id, 'buyer_pin', $buyer_pin);
				update_post_meta($buyer_id, 'buyer_street_addr', $buyer_street_addr);
				update_post_meta($buyer_id, 'buyer_latt', $buyer_latt);
				update_post_meta($buyer_id, 'buyer_long', $buyer_long);
				//agency location
				$return = array('message' => esc_html__('Account settings updated successfully.', 'propertya-framework' ),'link' => get_the_permalink($buyer_id));
      		 	wp_send_json_success($return);
			}
			else
			{
				$return = array('message' => esc_html__('Something went wrong, please try again.', 'propertya-framework'));
      		 	wp_send_json_error($return);
			}
  		}
	}
}