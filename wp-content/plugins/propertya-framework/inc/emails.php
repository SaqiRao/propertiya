<?php


// New User Registration Email For All
if (!function_exists('propertya_framework_new_user_email'))
{
    function propertya_framework_new_user_email($user_id, $password = '')
	{

      global $localization;
    global $propertya_options;


		if(!empty($user_id))
		{
			if(propertya_framework_get_options('prop_email_sendto_admin') == true)
			{
				
				//For Admin Only
				$to = get_option('admin_email');
				//$to = 'jssols76@gmail.com';
				$subject = propertya_framework_get_options('prop_new_user_admin_sub');
				$from = get_option('admin_email');
				$headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
				// Get User info
				$user_info = get_userdata($user_id);
				$user_type = '';
				if(get_user_meta($user_id, 'user_role_type', true)!="")
				{
					$user_type = get_user_meta($user_id, 'user_role_type', true);
				}
				$keywords = array('%site_name%', '%display_name%', '%email%', '%usertype%');
				$replaces = array(wp_specialchars_decode(get_bloginfo('name'),ENT_QUOTES), $user_info->display_name, $user_info->user_email,$user_type);
				$body = str_replace($keywords, $replaces, propertya_framework_get_options('prop_new_user_admin_message'));
				wp_mail($to, $subject, $body, $headers);
			}
			//For User Welcome Email
			if(propertya_framework_get_options('prop_email_sendto_user') == true)
			{
				$verification_link='';
				$user_infos = get_userdata($user_id);
				$to = $user_infos->user_email;
				//$to = 'jssols76@gmail.com';
				$subject = propertya_framework_get_options('prop_new_user_welcome_sub');
				$from = get_option('admin_email');
				$headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
				$keywords = array('%site_name%', '%display_name%', '%email%' , '%password%' ,'%verification_link%');
				$replaces = array(wp_specialchars_decode(get_bloginfo('name'),ENT_QUOTES), $user_infos->display_name, $user_infos->user_email,$password ,$verification_link);
				$body = str_replace($keywords, $replaces, propertya_framework_get_options('prop_new_user_welcome_message'));
                
              
				wp_mail($to, $subject, $body, $headers);
			
		}
	}
	}
}

//for verification mail

if (!function_exists('propertya_account_activation_email'))
{
    function propertya_account_activation_email($user_id)
	{
		if(!empty($user_id))
		{
		
			$user_infos = get_userdata($user_id);
			$to = $user_infos->user_email;
			$subject = propertya_framework_get_options('propertya_new_user_email_verification_sub');
			$from = get_option('admin_email');
			$headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
			$keywords = array('%site_name%', '%display_name%', '%verification_link%');
			$token = propertya_randomString(50);
			$sign_in_page = propertya_framework_get_link('page-signin.php');
			$verification_link = esc_url($sign_in_page) . '?verification_key=' . $token . '-propertya-uid-' . $user_id;
			$replaces = array(wp_specialchars_decode(get_bloginfo('name'),ENT_QUOTES), $user_infos->display_name,$verification_link);
			$body = str_replace($keywords, $replaces, propertya_framework_get_options('propertya_new_user_email_verification_message'));
			
			update_user_meta($user_id, 'user_email_verification_token', $token);
			wp_mail($to, $subject, $body, $headers);
		}
	}
}

// Send New Reset Password On Email
if (!function_exists('propertya_framework_forgotpass_email'))
{
    function propertya_framework_forgotpass_email($user_id, $reset_link)
	{
		if(!empty($user_id) && !empty($reset_link))
		{
			$user_infos = get_userdata($user_id);
			$to = $user_infos->user_email;
			//$to = 'jssols76@gmail.com';
			$subject = propertya_framework_get_options('prop_new_user_reset_sub');
			$from = get_option('admin_email');
			$headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
			$keywords = array('%site_name%', '%display_name%', '%reset_link%');
			$replaces = array(wp_specialchars_decode(get_bloginfo('name'),ENT_QUOTES), $user_infos->display_name,$reset_link);
			$body = str_replace($keywords, $replaces, propertya_framework_get_options('prop_new_user_reset_message'));;
             
            wp_mail($to, $subject, $body, $headers);
                
          }
      }      
	
}

// Schedule A Tour
// Ajax handler for Register User
add_action( 'wp_ajax_prop_schedule_tour', 'propertya_framework_user_schedule_tour' );
add_action( 'wp_ajax_nopriv_prop_schedule_tour', 'propertya_framework_user_schedule_tour' );
if (!function_exists('propertya_framework_user_schedule_tour'))
{
    function propertya_framework_user_schedule_tour()
	{
		$params = array();
		parse_str($_POST['collect_data'], $params);
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin( get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		if(!wp_verify_nonce($params['schedule_nonce'], 'prop-schedule-nonce'))
		{
			 $return = array('message' => esc_html__('Invalid security token sent.', 'propertya-framework'));
      		 wp_send_json_error($return);
   		}
		else
		{
			$date = trim(sanitize_text_field($params['tour-date']));
			$type = trim(sanitize_text_field($params['tour_type']));
			$time = trim(sanitize_text_field($params['schedule_time']));
			$username = trim(sanitize_text_field($params['your-name']));
			$contactno = trim(sanitize_text_field($params['tour-contact']));
      		$email = trim(sanitize_email($params['tour-email']));
			$message = trim(sanitize_textarea_field( $params['tour-msg']));
			// if(empty($username) || empty($type) || empty($time) || empty($username) || empty($contactno) || empty($email) || empty($message)){
			// 	$return = array('message' => esc_html__( 'Please fill in the required fields.','propertya-framework' ));
   //    			wp_send_json_error($return);		
			// }
			$listing_id = $params['listing_id'];
			$user_id = get_post_field('post_author', $listing_id);
			$user_infos = get_userdata($user_id);
			$to = $user_infos->user_email;
			$subject = propertya_framework_get_options('prop_schedule_sub');
			$from = get_option('admin_email');
			$headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
			$keywords = array('%display_name%', '%listing_title%', '%listing_link%', '%meeting_date%', '%meeting_time%', '%sender_name%', '%sender_email%', '%sender_contactno%', '%sender_message%');
			$replaces = array($user_infos->display_name,get_the_title($listing_id),get_the_permalink($listing_id),$date,$type,$time,$username,$email,$contactno,$message);
			$body = str_replace($keywords, $replaces, propertya_framework_get_options('prop_schedule_message'));
			
			if(wp_mail($to, $subject, $body, $headers))
			{
				$return = array('message' => esc_html__( 'Your mail has been sent successfully.', 'propertya-framework' ));
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

// Single Listing Reviews
add_action( 'wp_ajax_prop_listing_rating', 'propertya_framework_user_rating' );
add_action('wp_ajax_nopriv_prop_listing_rating', 'propertya_framework_user_rating');
if (!function_exists('propertya_framework_user_rating'))
{
    function propertya_framework_user_rating()
	{
		$params = array();
		parse_str($_POST['collect_data'], $params);
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin( get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		if(!wp_verify_nonce($params['rating_nonce'], 'prop-rating-nonce'))
		{
			 $return = array('message' => esc_html__('Invalid security token sent.', 'propertya-framework'));
      		 wp_send_json_error($return);
   		}
		else
		{
			if (is_user_logged_in())
			{
				$author_link = '';
				$current_user = wp_get_current_user();
				$commenter_id = $current_user->ID;
				$user_email = $current_user->user_email; 
				$commenter_name = $current_user->display_name;
				$rating = trim(sanitize_text_field($params['review-rating']));
				$title = trim(sanitize_text_field($params['review-title']));
				$msg = trim(sanitize_textarea_field($params['review-msg']));
				$listing_id = $params['listing_id'];
				//get listing owner data
				$owner_post_id = $listing_owner_name = '';
				$listing_owner_id = get_post_field('post_author', $listing_id);
				if(empty($rating) || empty($title) || empty($msg)){
					$return = array('message' => esc_html__( 'Please fill in the required fields.','propertya-framework' ));
					wp_send_json_error($return);		
				}
				//owner can't post a review
				if ($listing_owner_id == $commenter_id)
				{
					$return = array('message' => esc_html__("Listing author can't post a review...", 'propertya-framework'));
					wp_send_json_error($return);
				}
				$user_type =  get_user_meta($commenter_id, 'user_role_type', true);				
				if(propertya_framework_get_options('prop_allow_agencies_agents') == true)
				{
					$owner_post_id = get_user_meta( $listing_owner_id, 'prop_post_id' , true );
					 $listing_owner_name = esc_attr(get_the_title($owner_post_id));
					
					 $commenter_id = get_user_meta( $commenter_id, 'prop_post_id' , true );
					 $author_link = get_the_permalink($commenter_id);
					 $commenter_name =  esc_attr(get_the_title($commenter_id));
					 
					 //check already posted comment
				 	 $args = array('type__in' => 'property','post_id' => $listing_id, 'user_id' => $commenter_id, 'number' => 1);
					 $usercomment = get_comments($args);
					 if(!empty($usercomment) && is_array($usercomment) && count($usercomment) > 0)
					 { 
						 $return = array('message' => esc_html__("You have already posted a review on this listing.", 'propertya-framework'));
						 wp_send_json_error($return);
					 }
					 // save user review
					 $comment_date =  date('Y-m-d H:i:s',current_time( 'timestamp', 0));
					 $comments_approval = '0';
					 if(!empty(propertya_framework_get_options('prop_review_approval')))
					 {
						$comments_approval = propertya_framework_get_options('prop_review_approval');
					 }
					 
					 $data = array(
						'comment_post_ID' => $listing_id,
						'comment_author'  => $commenter_name,
						'comment_author_email' => $user_email,
						'comment_author_url' => esc_url($author_link),
						'comment_content' => $msg,
						'comment_type' => 'property',
						'user_id' => $commenter_id,
						'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
						'comment_date' => $comment_date,
						'comment_approved' => $comments_approval,
					);
					$comment_id = wp_insert_comment($data);
					if ($comment_id)
					{
						//record leads
						propertya_framework_track_activity($listing_id, 'comments', 'yes', $comment_id);
						propertya_framework_track_activity($listing_id, 'rating', $rating, $comment_id);
						//save values
						update_comment_meta($comment_id, 'review_stars', $rating);
						update_comment_meta($comment_id, 'review_main_title', $title);
						//send email to listing owner about review
						if(!empty(propertya_framework_get_options('prop_email_on_comment')) && propertya_framework_get_options('prop_email_on_comment') == 1)
						{
							$subject = propertya_framework_get_options('prop_notification_sub');
							$from = get_option('admin_email');
							$headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
							$keywords = array('%display_name%', '%listing_title%', '%listing_link%','%sender_name%', '%rating_stars%', '%sender_review%');
							$replaces = array($listing_owner_name,get_the_title($listing_id),get_the_permalink($listing_id),$commenter_name,$rating,$msg);
							$body = str_replace($keywords, $replaces, propertya_framework_get_options('prop_notification_message'));
							wp_mail($to, $subject, $body, $headers);
						}
						$comment_status = wp_get_comment_status($comment_id);
						if ($comment_status == "approved")
						{
							$return = array('message' => esc_html__('Review posted successfully.','propertya-framework' ));
							wp_send_json_success($return);
						}
						else
						{
							$return = array('message' => esc_html__('Review posted successfully & waiting for admin approval.','propertya-framework' ));
							wp_send_json_success($return);
						}
					}
					else
					{
						$return = array('message' => esc_html__('There was an error while processing your request. Please, reload the page and try again.', 'propertya-framework'));
						wp_send_json_error($return);					
					}
				}
				else
				{
				   $return = array('message' => esc_html__("Agency & agents can't post a review.", 'propertya-framework'));
				   wp_send_json_error($return);
				}
				
			}
			else
			{
				$return = array('message' => esc_html__('You must be logged in to post a comment.', 'propertya-framework'));
				wp_send_json_error($return);
			}
		}
	}
}


// Contact Listing Author
add_action( 'wp_ajax_prop_contact_author', 'propertya_framework_user_contact_author' );
add_action( 'wp_ajax_nopriv_prop_contact_author', 'propertya_framework_user_contact_author' );
if (!function_exists('propertya_framework_user_contact_author'))
{
    function propertya_framework_user_contact_author()
	{
		$params = array();
		parse_str($_POST['collect_data'], $params);
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin( get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		if(!wp_verify_nonce($params['contactauthor_nonce'], 'prop-contactauthor-nonce'))
		{
			 $return = array('message' => esc_html__('Invalid security token sent.', 'propertya-framework'));
      		 wp_send_json_error($return);
   		}
		else
		{
            $username = trim(sanitize_text_field($params['c_username']));
            $email = trim(sanitize_email($params['c_email']));
            $message = trim(sanitize_textarea_field( $params['c_msg']));
            $contact = trim(sanitize_text_field( $params['contact-no']));
			if(empty($username) || empty($email) || empty($message) || empty($contact)){
				$return = array('message' => esc_html__( 'Please fill in the required fields.','propertya-framework' ));
      			wp_send_json_error($return);		
			}
			$listing_id = trim($params['listing_id']);
			$user_id = get_post_field('post_author', $listing_id);
			$user_infos = get_userdata($user_id);
			$to = $user_infos->user_email;
			$subject = propertya_framework_get_options('prop_contactauthor_sub');
			

			$from =  $username . '<' . get_option('admin_email') . '>';
			
			 $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
			$keywords = array('%display_name%', '%listing_title%', '%listing_link%', '%sender_name%', '%sender_email%', '%sender_number%', '%sender_message%');
			$replaces = array($user_infos->display_name,get_the_title($listing_id),get_the_permalink($listing_id),$username,$email,$contact,$message);
			$body = str_replace($keywords, $replaces, propertya_framework_get_options('prop_contactauthor_messages'));

// Send the email
      $res =  wp_mail($to, $subject, $message, $headers);
			
			if($res)
			{
				$return = array('message' => esc_html__( 'Your mail has been sent successfully.', 'propertya-framework' ));
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

// Single Agent Agency Reviews
add_action( 'wp_ajax_agency_agent_rating', 'propertya_framework_user_agency_agent_rating' );
if (!function_exists('propertya_framework_user_agency_agent_rating'))
{
    function propertya_framework_user_agency_agent_rating()
	{
		$params = array();
		parse_str($_POST['collect_data'], $params);
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin( get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		if(!wp_verify_nonce($params['single_rating_nonce'], 'prop-agency-agent-nonce'))
		{
			 $return = array('message' => esc_html__('Invalid security token sent.', 'propertya-framework'));
      		 wp_send_json_error($return);
   		}
		else
		{
			if (is_user_logged_in() )
			{
				$author_link = '';
				$current_user = wp_get_current_user();
				$commenter_id = $current_user->ID;
				$user_email = $current_user->user_email; 
				$commenter_name = $current_user->display_name;
				$responsiveness = trim(sanitize_text_field($params['responsiveness']));
				$communication = trim(sanitize_text_field($params['communication']));
				$expertise = trim(sanitize_text_field($params['expertise']));
				$services = trim(sanitize_text_field($params['services']));
				$recommend = trim(sanitize_text_field($params['recommend']));
				$buyed = trim(sanitize_text_field($params['is-buy']));
				$title = trim(sanitize_text_field($params['review-title']));
				$msg = trim(sanitize_textarea_field($params['review-msg']));
				$single_id = $params['single_id'];
				$reference = trim($params['reference']);
				if($reference == 'agency')
				{
					$post_type = 'property-agency';
				}
				if($reference == 'agent')
				{
					$post_type = 'property-agents';
				}
				if($reference == 'buyer')
				{
					$post_type = 'property-buyers';
				}
				//get listing owner data
				$owner_post_id = $listing_owner_name = '';
				$listing_owner_id = get_post_field('post_author', $single_id);
				if(empty($responsiveness) || empty($communication) || empty($expertise) || empty($services)  || empty($title) || empty($msg)){
					$return = array('message' => esc_html__( 'Please fill in the required fields.','propertya-framework' ));
					wp_send_json_error($return);		
				}
				//owner can't post a review
				if ($listing_owner_id == $commenter_id)
				{
					$return = array('message' => esc_html__("Author can't review his profile...", 'propertya-framework'));
					wp_send_json_error($return);
				}
				//only buyer can post a review
				$user_type =  get_user_meta($commenter_id, 'user_role_type', true);
				if(propertya_framework_get_options('prop_allow_agencies_agents') == true)
				{
					 $owner_post_id = get_user_meta( $listing_owner_id, 'prop_post_id' , true );
					 $listing_owner_name = esc_attr(get_the_title($owner_post_id));
					 $commenter_id = get_user_meta( $commenter_id, 'prop_post_id' , true );
					 $author_link = get_the_permalink($commenter_id);
					 $commenter_name =  esc_attr(get_the_title($commenter_id));
					
					 //check already posted comment
				 	 $args = array('type__in' => $post_type,'post_id' => $single_id, 'user_id' => $commenter_id, 'number' => 1);
					 $usercomment = get_comments($args);
					 if(!empty($usercomment) && is_array($usercomment) && count($usercomment) > 0)
					 { 
						 $return = array('message' => esc_html__("You have already posted a review.", 'propertya-framework'));
						 wp_send_json_error($return);
					 }
					 // save user review
					 $comment_date =  date('Y-m-d H:i:s',current_time( 'timestamp', 0));
					 $comments_approval = '0';
					 if(!empty(propertya_framework_get_options('prop_review_approval')))
					 {
						$comments_approval = propertya_framework_get_options('prop_review_approval');
					 }
					 $data = array(
						'comment_post_ID' => $single_id,
						'comment_author'  => $commenter_name,
						'comment_author_email' => $user_email,
						'comment_author_url' => esc_url($author_link),
						'comment_content' => $msg,
						'comment_type' => $post_type,
						'user_id' => $commenter_id,
						'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
						'comment_date' => $comment_date,
						'comment_approved' => $comments_approval,
					);
					$comment_id = wp_insert_comment($data);
					if ($comment_id)
					{
						//save values
						update_comment_meta($comment_id, 'review_'.$reference.'_responsive', $responsiveness);
						update_comment_meta($comment_id, 'review_'.$reference.'_communication', $communication);
						update_comment_meta($comment_id, 'review_'.$reference.'_expertise', $expertise);
						update_comment_meta($comment_id, 'review_'.$reference.'_services', $services);
						update_comment_meta($comment_id, 'review_'.$reference.'_recommend', $recommend);
						update_comment_meta($comment_id, 'review_'.$reference.'_buyed', $buyed);
						update_comment_meta($comment_id, 'review_'.$reference.'_title', $title);
						$comment_status = wp_get_comment_status($comment_id);
						if ($comment_status == "approved")
						{
							$return = array('message' => esc_html__('Review posted successfully.','propertya-framework' ));
							wp_send_json_success($return);
						}
						else
						{
							$return = array('message' => esc_html__('Review posted successfully & waiting for admin approval.','propertya-framework' ));
							wp_send_json_success($return);
						}
					}
					else
					{
						$return = array('message' => esc_html__('There was an error while processing your request. Please, reload the page and try again.', 'propertya-framework'));
						wp_send_json_error($return);
					}
				}
				else
				{
					$return = array('message' => esc_html__("Agency & agents can't post a review.", 'propertya-framework'));
				   wp_send_json_error($return);
				}
			}
			else
			{
				$return = array('message' => esc_html__('You must be logged in to post a comment.', 'propertya-framework'));
				wp_send_json_error($return);
			}
		}
	}
}


// Contact Profile Author
add_action( 'wp_ajax_prop_singlecontact_author', 'propertya_framework_user_contact_author_profile' );
add_action( 'wp_ajax_nopriv_prop_singlecontact_author', 'propertya_framework_user_contact_author_profile' );
if (!function_exists('propertya_framework_user_contact_author_profile'))
{
    function propertya_framework_user_contact_author_profile()
	{
		$params = array();
		parse_str($_POST['collect_data'], $params);
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin( get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		if(!wp_verify_nonce($params['single_profile_nonce'], 'prop-single-profile-nonce'))
		{
			 $return = array('message' => esc_html__('Invalid security token sent.', 'propertya-framework'));
      		 wp_send_json_error($return);
   		}
		else
		{
			$username = trim(sanitize_text_field($params['username']));
      		$email = trim(sanitize_email($params['email']));
			$message = trim(sanitize_textarea_field( $params['msg']));
			if(empty($username) || empty($email) || empty($message)){
				$return = array('message' => esc_html__( 'Please fill in the required fields.','propertya-framework' ));
      			wp_send_json_error($return);		
			}
			$profile_id = trim($params['profile_id']);
			$user_id = get_post_field('post_author', $profile_id);
			$user_infos = get_userdata($user_id);
			$to = $user_infos->user_email;
			$subject = propertya_framework_get_options('prop_profileauthor_sub');
			$from = get_option('admin_email');
			$headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
			$keywords = array('%display_name%', '%profile_link%', '%sender_name%', '%sender_email%', '%sender_message%');
			$replaces = array($user_infos->display_name,get_the_permalink($profile_id),$username,$email,$message);
			$body = str_replace($keywords, $replaces, propertya_framework_get_options('prop_profileauthor_messages'));
			if(wp_mail($to, $subject, $body, $headers))
			{
				$return = array('message' => esc_html__( 'Your mail has been sent successfully.', 'propertya-framework' ));
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


// Single Listing Reviews Reply
add_action( 'wp_ajax_prop_listing_rating_reply', 'propertya_framework_user_rating_reply' );
if (!function_exists('propertya_framework_user_rating_reply'))
{
    function propertya_framework_user_rating_reply()
	{
		$params = array();
		parse_str($_POST['collect_data'], $params);
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin( get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		else
		{
			if (is_user_logged_in())
			{
				$reply_review_id = $user_email = $user_email = $author_link = $commenter_name = $owner_post_id = '';
				$comment_id = sanitize_text_field($params['comment_id']);
				$property_id = sanitize_text_field($params['property_id']);
				$user_id = sanitize_text_field($params['user_id']);
				$reply_review_id = sanitize_text_field($params['review_reply_id']);
				$msg = trim(sanitize_textarea_field($params['comments-review-reply']));
				if(empty($msg))
				{
					$return = array('message' => esc_html__( 'The message field should not be left blank.', 'propertya-framework' ));
					wp_send_json_error($return);	
				}
				$owner_post_id = get_user_meta( $user_id, 'prop_post_id' , true );
				$commenter_name = esc_attr(get_the_title($owner_post_id));
				$author_link = get_the_permalink($owner_post_id);
				$author_obj = get_user_by('id', $user_id);
				$user_email = $user->user_email;
				if (isset($reply_review_id) && $reply_review_id != "")
				{
					 $commentarr['comment_post_ID'] = $property_id;
					 $commentarr['comment_ID'] = $reply_review_id;
					 $commentarr['comment_approved'] = 1;
					 $commentarr['comment_content'] = $msg;
					 wp_update_comment($commentarr);
					 $return = array('message' => esc_html__('Reply updated successfully.','propertya-framework' ));
					 wp_send_json_success($return);
				}
				else
				{
					// save user review
					$comment_date =  date('Y-m-d H:i:s',current_time( 'timestamp', 0));
					$data = array(
						'comment_post_ID' => $property_id,
						'comment_author'  => $commenter_name,
						'comment_author_email' => $user_email,
						'comment_author_url' => esc_url($author_link),
						'comment_content' => $msg,
						'comment_type' => 'property',
						'user_id' => $owner_post_id,
						'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
						'comment_date' => $comment_date,
						'comment_parent' => $comment_id,
						'comment_approved' => 1,
						);
					$comment_id = wp_insert_comment($data);
					if ($comment_id)
					{
						 $return = array('message' => esc_html__('Reply posted successfully.','propertya-framework' ));
						 wp_send_json_success($return);
					}
					else
					{
						$return = array('message' => esc_html__('There was an error while processing your request. Please, reload the page and try again.', 'propertya-framework'));
						wp_send_json_error($return);					
					}
				}
			}
			else
			{
				$return = array('message' => esc_html__('You must be logged in to post a comment.', 'propertya-framework'));
				wp_send_json_error($return);
			}
		}
	}
}



// Update Submitted Reviews
add_action( 'wp_ajax_prop_update_submitted_reply', 'propertya_framework_update_submitted_reply' );
if (!function_exists('propertya_framework_update_submitted_reply'))
{
    function propertya_framework_update_submitted_reply()
	{
		$params = array();
		parse_str($_POST['collect_data'], $params);
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin( get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		else
		{
			if (is_user_logged_in())
			{
				$author_link = '';
				$commenter_id = $params['user_id'];
				$rating = trim(sanitize_text_field($params['review-rating']));
				$title = trim(sanitize_text_field($params['review-title']));
				$msg = trim(sanitize_textarea_field($params['review-msg']));
				$listing_id = sanitize_text_field($params['property_id']);
				$comment_id = sanitize_text_field($params['comment_id']);
				//get listing owner data
				$owner_post_id = $listing_owner_name = '';
				$listing_owner_id = get_post_field('post_author', $listing_id);
				if(empty($rating)){
					$return = array('message' => esc_html__( 'Please choose a star.','propertya-framework' ));
					wp_send_json_error($return);		
				}
				if(empty($title)){
					$return = array('message' => esc_html__( 'Please fill in the title fields.','propertya-framework' ));
					wp_send_json_error($return);		
				}
				if(empty($msg)){
					$return = array('message' => esc_html__( 'Please fill in the message fields.','propertya-framework' ));
					wp_send_json_error($return);		
				}
				$commentarr['comment_post_ID'] = $listing_id;
				$commentarr['comment_ID'] = $comment_id;
				$commentarr['comment_approved'] = 1;
				$commentarr['comment_content'] = $msg;
				wp_update_comment($commentarr);
				//record leads
				propertya_framework_track_activity($listing_id, 'comments', 'yes', $comment_id);
				propertya_framework_track_activity($listing_id, 'rating', $rating, $comment_id);
				//save values
				update_comment_meta($comment_id, 'review_stars', $rating);
				update_comment_meta($comment_id, 'review_main_title', $title);
				$return = array('message' => esc_html__('Reply updated successfully.','propertya-framework' ));
			    wp_send_json_success($return);
			}
			else
			{
				$return = array('message' => esc_html__('You must be logged in to post a comment.', 'propertya-framework'));
				wp_send_json_error($return);
			}
		}
	}
}


// Single Profile Reviews Reply
add_action( 'wp_ajax_prop_profile_rating_reply', 'propertya_framework_user_profile_rating_reply' );
if (!function_exists('propertya_framework_user_profile_rating_reply'))
{
    function propertya_framework_user_profile_rating_reply()
	{
		$params = array();
		parse_str($_POST['collect_data'], $params);
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin( get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		else
		{
			if (is_user_logged_in())
			{
				$reply_review_id = $user_email = $user_email = $author_link = $commenter_name = $owner_post_id = '';
				$comment_id = sanitize_text_field($params['comment_id']);
				$profile_id = sanitize_text_field($params['profile_id']);
				$post_type = sanitize_text_field($params['reference_type']);
				$user_id = sanitize_text_field($params['user_id']);
				$reply_review_id = sanitize_text_field($params['review_reply_id']);
				$msg = trim(sanitize_textarea_field($params['comments-review-reply']));
				if(empty($msg))
				{
					$return = array('message' => esc_html__( 'The message field should not be left blank.', 'propertya-framework' ));
					wp_send_json_error($return);	
				}
				$owner_post_id = get_user_meta( $user_id, 'prop_post_id' , true );
				$commenter_name = esc_attr(get_the_title($owner_post_id));
				$author_link = get_the_permalink($owner_post_id);
				$author_obj = get_user_by('id', $user_id);
				$user_email = $user->user_email;
				if (isset($reply_review_id) && $reply_review_id != "")
				{
					 $commentarr['comment_post_ID'] = $profile_id;
					 $commentarr['comment_ID'] = $reply_review_id;
					 $commentarr['comment_approved'] = 1;
					 $commentarr['comment_content'] = $msg;
					 wp_update_comment($commentarr);
					 $return = array('message' => esc_html__('Reply updated successfully.','propertya-framework' ));
					 wp_send_json_success($return);
				}
				else
				{
					// save user review
					$comment_date =  date('Y-m-d H:i:s',current_time( 'timestamp', 0));
					$data = array(
						'comment_post_ID' => $profile_id,
						'comment_author'  => $commenter_name,
						'comment_author_email' => $user_email,
						'comment_author_url' => esc_url($author_link),
						'comment_content' => $msg,
						'comment_type' => $post_type,
						'user_id' => $owner_post_id,
						'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
						'comment_date' => $comment_date,
						'comment_parent' => $comment_id,
						'comment_approved' => 1,
						);
					$comment_id = wp_insert_comment($data);
					if ($comment_id)
					{
						 $return = array('message' => esc_html__('Reply posted successfully.','propertya-framework' ));
						 wp_send_json_success($return);
					}
					else
					{
						$return = array('message' => esc_html__('There was an error while processing your request. Please, reload the page and try again.', 'propertya-framework'));
						wp_send_json_error($return);					
					}
				}
			}
			else
			{
				$return = array('message' => esc_html__('You must be logged in to post a comment.', 'propertya-framework'));
				wp_send_json_error($return);
			}
		}
	}
}


// Update Profile Submitted Reviews
add_action( 'wp_ajax_prop_profile_update_submitted_reply', 'propertya_framework_update_submitted_reply_profile' );
if (!function_exists('propertya_framework_update_submitted_reply_profile'))
{
    function propertya_framework_update_submitted_reply_profile()
	{
		$params = array();
		parse_str($_POST['collect_data'], $params);
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin( get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		else
		{
			if (is_user_logged_in())
			{
				$author_link = '';
				$commenter_id = $params['user_id'];
				
				$responsiveness = trim(sanitize_text_field($params['responsiveness']));
				$communication = trim(sanitize_text_field($params['communication']));
				$expertise = trim(sanitize_text_field($params['expertise']));
				$services = trim(sanitize_text_field($params['services']));
				$recommend = trim(sanitize_text_field($params['recommend']));
				$buyed = trim(sanitize_text_field($params['is-buy']));
				$title = trim(sanitize_text_field($params['review-title']));
				$msg = trim(sanitize_textarea_field($params['review-msg']));
				$profile_id = sanitize_text_field($params['profile_id']);
				$comment_id = sanitize_text_field($params['comment_id']);
				$reference_type = trim(sanitize_textarea_field($params['reference_type']));
				//get listing owner data
				$owner_post_id = $listing_owner_name = '';
				$listing_owner_id = get_post_field('post_author', $profile_id);
				if(empty($title)){
					$return = array('message' => esc_html__( 'Please fill in the title fields.','propertya-framework' ));
					wp_send_json_error($return);		
				}
				if(empty($msg)){
					$return = array('message' => esc_html__( 'Please fill in the message fields.','propertya-framework' ));
					wp_send_json_error($return);		
				}
				$commentarr['comment_post_ID'] = $profile_id;
				$commentarr['comment_ID'] = $comment_id;
				$commentarr['comment_approved'] = 1;
				$commentarr['comment_content'] = $msg;
				wp_update_comment($commentarr);
				//save values
				update_comment_meta($comment_id, 'review_'.$reference_type.'_responsive', $responsiveness);
				update_comment_meta($comment_id, 'review_'.$reference_type.'_communication', $communication);
				update_comment_meta($comment_id, 'review_'.$reference_type.'_expertise', $expertise);
				update_comment_meta($comment_id, 'review_'.$reference_type.'_services', $services);
				update_comment_meta($comment_id, 'review_'.$reference_type.'_recommend', $recommend);
				update_comment_meta($comment_id, 'review_'.$reference_type.'_buyed', $buyed);
				update_comment_meta($comment_id, 'review_'.$reference_type.'_title', $title);
				$return = array('message' => esc_html__('Reply updated successfully.','propertya-framework' ));
			    wp_send_json_success($return);
			}
			else
			{
				$return = array('message' => esc_html__('You must be logged in to post a comment.', 'propertya-framework'));
				wp_send_json_error($return);
			}
		}
	}
}

// Featured Listing Expiry Email
if (!function_exists('propertya_framework_featured_ad_expiry'))
{
    function propertya_framework_featured_ad_expiry($property_id)
	{
        $listing_id = $property_id;
        $user_id = get_post_field('post_author', $listing_id);
        $user_infos = get_userdata($user_id);
        $post_author_id  =  '';
        if(get_user_meta($user_id, 'user_role_type', true) !="")
	    {
		   $post_author_id = get_user_meta($user_id, 'prop_post_id' , true );
           $type = get_user_meta($user_id, 'user_role_type', true);
           if(isset($type) && $type == "agency")
           {
            $reference = 'agency';
           }
           if(isset($type) && $type == "agent")
           {
            $reference = 'agent';
           }
           if(isset($type) && $type == "buyer")
           {
            $reference = 'buyer';
           }
           if( get_post_meta($post_author_id,  $reference.'_email', true ) !="")
           {
              $email = get_post_meta($post_author_id,  $reference.'_email', true );
           }
           else
           {
               $email = $user_infos->user_email; 
           }
        }
        else
        {
            $email = $user_infos->user_email;
        }
        $to =  $email;
        $subject = propertya_framework_get_options('prop_featured_subs');
        $from = get_option('admin_email');
        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
        $keywords = array('%display_name%', '%listing_title%', '%listing_link%');
        $replaces = array(get_the_title($post_author_id),get_the_title($listing_id),get_the_permalink($listing_id));
        $body = str_replace($keywords, $replaces, propertya_framework_get_options('prop_featured_messagess'));
        
        wp_mail($to, $subject, $body, $headers);
	}
}

// Regualr Listing Expiry Email
if (!function_exists('propertya_framework_regular_ad_expiry'))
{
    function propertya_framework_regular_ad_expiry($property_id)
	{
        $listing_id = $property_id;
        $user_id = get_post_field('post_author', $listing_id);
        $user_infos = get_userdata($user_id);
        if(get_user_meta($user_id, 'user_role_type', true) !="")
	    {
		   $post_author_id = get_user_meta($user_id, 'prop_post_id' , true );
           $type = get_user_meta($user_id, 'user_role_type', true);
           if(isset($type) && $type == "agency")
           {
            $reference = 'agency';
           }
           if(isset($type) && $type == "agent")
           {
            $reference = 'agent';
           }
           if(isset($type) && $type == "buyer")
           {
            $reference = 'buyer';
           }
           if( get_post_meta($post_author_id,  $reference.'_email', true ) !="")
           {
              $email = get_post_meta($post_author_id,  $reference.'_email', true );
           }
           else
           {
               $email = $user_infos->user_email; 
           }
        }
        else
        {
            $email = $user_infos->user_email;
        }
        $to =  $email;
        $subject = propertya_framework_get_options('prop_reg_subj');
        $from = get_option('admin_email');
        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
        $keywords = array('%display_name%');
        $replaces = array(get_the_title($post_author_id));
        $body = str_replace($keywords, $replaces, propertya_framework_get_options('prop_reg_message'));

        wp_mail($to, $subject, $body, $headers);
	}
}

/* Rearrange images */
add_action( 'wp_ajax_nopriv_sb_sort_images', 'propertya_sort_images' );
add_action('wp_ajax_sb_sort_images', 'propertya_sort_images');
if (!function_exists('propertya_sort_images')) {
    function propertya_sort_images()
    {
        $status = update_post_meta($_POST['ad_id'], 'prop_gallery', $_POST['ids']);
        if ($status == 1) {
            $return = array('message' => esc_html__('Image Sorting updated successfully.', 'propertya-framework'));
            wp_send_json_success($return);
        } else {
            $return = array('message' => esc_html__('Something Went Wrong.No sortation applied', 'propertya-framework'));
            wp_send_json_error($return);
        }
    }
}