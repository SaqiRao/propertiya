<?php
	global $localization;
    global $propertya_options;
    $user_id='';
    $agency_id='';
// Ajax handler for Register User
add_action( 'wp_ajax_prop_user_registration', 'propertya_framework_user_registration' );
add_action( 'wp_ajax_nopriv_prop_user_registration', 'propertya_framework_user_registration' );
if (!function_exists ( 'propertya_framework_user_registration' ))
{
	function propertya_framework_user_registration()
	{
		$params = array();
		parse_str($_POST['collect_data'], $params);
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin( get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		if(!wp_verify_nonce($params['register_nonce'], 'prop-register-nonce'))
		{
			 $return = array('message' => esc_html__('Invalid security token sent.', 'propertya-framework'));
      		 wp_send_json_error($return);
   		}
		else
		{
			$username = trim(sanitize_text_field($params['username']));
			$displayname = trim(sanitize_text_field($params['displayname']));
      		$email = trim(sanitize_email($params['email']));
			$password = trim(sanitize_text_field( $params['password'] ));
			$user_role_type = trim(sanitize_text_field($params['usertype']));
			$agency_id = trim(sanitize_text_field($params['agency_id']));
			$agent_type = trim(sanitize_text_field($params['agent-type']));
			$agenct_mobile = trim(sanitize_text_field($params['agent-mobile']));
			$allow_listing= trim(sanitize_text_field($params['list']));
			if(empty($username)){
				$return = array('message' => esc_html__( 'Please enter a username.', 'propertya-framework' ));
      			wp_send_json_error($return);	
			}
			if(empty($displayname)){
				$return = array('message' => esc_html__( 'Display name is required.', 'propertya-framework' ));
      			wp_send_json_error($return);	
			}
			if(empty($user_role_type)){
				$return = array('message' => esc_html__( 'User type is required.', 'propertya-framework' ));
      			wp_send_json_error($return);	
			}
			if(empty($password)){
				$return = array('message' => esc_html__( 'Please choose a password with at least 3-12 characters.', 'propertya-framework' ));
      			wp_send_json_error($return);	
			}
			// if(empty($allow_listing)){
			// 	$return = array('message' => esc_html__( 'Please choose a listing for agent.', 'propertya-framework' ));
   //    			wp_send_json_error($return);	
			// }

			if ( !is_email( $email ) ) {
				$return = array('message' => esc_html__( 'Please enter a valid email address.', 'propertya-framework' ));
      			wp_send_json_error($return);	
			}
			if( email_exists($email) == false )
			{
				$user_name	=	explode('@', $email);
				$u_name	=	propertya_framework_check_user_name($user_name[0]);
				$user_id  = wp_create_user($u_name,$password, $email);

             if(!empty(get_user_meta($agency_id,'agency_agent',true)))
             {
             	add_user_meta($agency_id,'agency_agent',$user_id,false );
             }
             else
             {
             	update_user_meta($agency_id,'agency_agent',$user_id );
             }
				

				if (!is_wp_error($user_id) )
				{
					wp_update_user(array('ID' =>$user_id,'display_name'=>$username));
			
					if(!empty($user_role_type))
					{
						
					   if(empty($agency_id) )
                         {
                         	//if free package assign option is enabled
	                        if(!empty(propertya_framework_get_options('prop_woo_enable_packages')) && propertya_framework_get_options('prop_woo_enable_packages') == true && in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' )) ))
	                        {
	                            if(!empty(propertya_framework_get_options('prop_listing_package_type')))
	                            {
	                                $product_id = propertya_framework_get_options('prop_listing_package_type');
	                                propertya_framework_store_user_package($user_id, $product_id);
	                            }
	                        } 
                        }
                     else
                      {
                    	$agency_user_id= get_current_user_id();
                        $product_id=  get_user_meta($agency_user_id, 'prop_user_package_id');
                        $product_id= implode( $product_id);
                           
                           $regular_listing_expiry = $listing_featured_expiry = $pkg_exp = $featured_listing = $regular_listing = $listing_expiry = '';

                            $pkg_exp=get_user_meta($agency_user_id, 'prop_pack_exp');
				            $regular_listing = get_user_meta($agency_user_id, 'prop_pack_totallistings');
				            $regular_listing_expiry = get_user_meta($agency_user_id, 'prop_pack_simple_expiry_for');
                            $pkg_exp= implode($pkg_exp);
                             $regular_listing=implode($regular_listing);

                           //  0 when no listing allowed
                       if($allow_listing > 0)
                         {
                            if ($allow_listing > $regular_listing)
                            {
			                    wp_delete_user( $user_id);
				            	$return = array('message' => esc_html__( 'Upgrade your Package to Add new agent.', 'propertya-framework' ));
  		                         wp_send_json_error($return);
				               } 

				                update_user_meta($user_id, 'prop_user_package_id', $product_id);
                   //assign simple listings
				             if (!empty($regular_listing) && $regular_listing == '-1')
					            {
					                update_user_meta($user_id, 'prop_pack_totallistings', '-1');  
					            } 
					            else if (!empty($regular_listing) && is_numeric($regular_listing) && $regular_listing != 0)
					            {
					            	if($regular_listing >= $allow_listing)
					            	{
					            		(update_user_meta($user_id, 'prop_pack_totallistings', $allow_listing));
					               (update_user_meta($agency_user_id, 'prop_pack_totallistings',$regular_listing - $allow_listing));

					            	}
					            	else 
					            	{
					            		wp_delete_user( $user_id);
					            		$return = array('message' => esc_html__( 'Upgrade your Package to Add new agent.', 'propertya-framework' ));
      		                          	wp_send_json_error($return);
					            	}
					                
					            }
					            else
					            {
					                (update_user_meta($user_id, 'prop_pack_totallistings', $allow_listing));
					                (update_user_meta($agency_user_id, 'prop_pack_totallistings',$regular_listing - $allow_listing));
					            }

					 //assign package days to user
						      if (!empty($pkg_exp) && $pkg_exp == '-1')
					            {
					                update_user_meta($user_id, 'prop_pack_exp', '-1');
					            } 
					            else 
					            {
					                $new_expiry = date('Y-m-d', strtotime("+$pkg_exp days"));
					               (update_user_meta($user_id, 'prop_pack_exp', $pkg_exp));
					            }

                    }
                }

                        
						//send email
						if(propertya_framework_get_options('prop_email_onregister') == true)
						{
							propertya_framework_new_user_email($user_id,$password);
						}
						propertya_framework_assign_role_type($username,$user_id,$user_role_type,$password,$agency_id,$agent_type,$agenct_mobile, $email, $displayname);
					}
           		}
				else
				{
					$return = array('message' => esc_html__( 'There was an error while processing your request. Please, reload the page and try again.', 'propertya-framework' ));
      				wp_send_json_error($return);	
				}
			}
			else
			{
				$return = array('message' => esc_html__( 'This email is already registered, please choose another one.', 'propertya-framework' ));
      			wp_send_json_error($return);
			}
  		}
	}
	
}

add_action( 'wp_ajax_prop_agent_list', 'propertya_framework_agent_listing' );
add_action( 'wp_ajax_nopriv_prop_agent_list', 'propertya_framework_agent_listing' );
if (!function_exists ( 'propertya_framework_agent_listing' ))
{
	function propertya_framework_agent_listing()
	{
		
		$params = array();
			parse_str($_POST['collect_data'], $params);

		
		
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin( get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		if(!wp_verify_nonce($params['register_nonce'], 'prop-register-nonce'))
		{
			 $return = array('message' => esc_html__('Invalid security token sent.', 'propertya-framework'));
      		 wp_send_json_error($return);
   		}
		else
		{

			 $agency_user=$params['agency_id'];  //agency id
			 $agency_user_id= get_current_user_id();
			  $regular_listing = get_user_meta( $agency_user_id, 'prop_pack_totallistings');
			  $regular_listing=implode($regular_listing);
			 $allow_listing= trim(sanitize_text_field($params['list']));


        

       

          if(empty($allow_listing)){
				$return = array('message' => esc_html__( 'Please Enter Listings', 'propertya-framework' ));
      			wp_send_json_error($return);	
			}
              $user_id = $params['agency_agent_id'];
             
            

             $my_agent = get_post_meta($user_id, 'prop_user_id', true);

            
              //get_user_meta( $agency_user, 'agency_agent');
              //$user_id = implode( $user_id);
               if($user_id == "")
               {
                     $return = array('message' => esc_html__( 'Add agent first.', 'propertya-framework' ));
  		            wp_send_json_error($return);
               }
              
             if($regular_listing >= $allow_listing)
            	{
            		
            		$list = get_user_meta($my_agent, 'prop_pack_totallistings');
            		$list = implode($list);

                
                 
            	      update_user_meta($my_agent, 'prop_pack_totallistings', $allow_listing);
                     
                      $newlist = '';
	
                       if($allow_listing > $list)
                       {
                       		
                               
                         $newlist = $allow_listing - $list;

                       	 update_user_meta($agency_user_id, 'prop_pack_totallistings',$regular_listing - $newlist);

                       	 
                       	 $return = array('message' => esc_html__( 'Agent Listing Updated', 'propertya-framework' ));
  		                         wp_send_json_success($return);
                       }
                       elseif($allow_listing < $list)
                       {
                       		
                       	$newlist = $list - $allow_listing;
                       	 update_user_meta($agency_user_id, 'prop_pack_totallistings',$regular_listing + $newlist);
                       	 $return = array('message' => esc_html__( 'Agent Listing Updated', 'propertya-framework' ));
  		                         wp_send_json_success($return);
                       }
                       elseif($allow_listing == $list)
                       {
                       
                       	 //update_user_meta($agency_user_id, 'prop_pack_totallistings', $regular_listing);
                       	 $return = array('message' => esc_html__( 'Agent Listing Updated', 'propertya-framework' ));
  		                         wp_send_json_success($return);
                       }

                    

                      
            	}
            	 if ($allow_listing > $regular_listing)
                            {
			                  
				            	$return = array('message' => esc_html__( 'Upgrade your Package to update listing.', 'propertya-framework' ));
  		                         wp_send_json_error($return);
				               } 


		
	}
	
	}
}

// Assign Related Role & Type
if (!function_exists ( 'propertya_framework_assign_role_type' ))
{
	function propertya_framework_assign_role_type($username,$user_id,$user_role_type, $password, $agency_id = '' , $agent_type = '' , $agenct_mobile = '', $user_mail = '', $displayname = '')
	{
		if(!empty($username) && !empty($user_id) && !empty($user_role_type) && !empty($password))
		{
			if($user_role_type == 'agent')
			{
				$post_type = 'property-agents';
				$status =    'agent_status';
				$email =     'agent_email';
			}
			if($user_role_type == 'agency')
			{
				$post_type = 'property-agency';
				$status =    'agency_status';
				$email =    'agency_email';
			}
			if($user_role_type == 'buyer')
			{
				$post_type = 'property-buyers';
				$status =    'buyer_status';
				$email =    'buyer_email';
			}
			
			if(isset($post_type) && $post_type !="")
			{
				$new_post = array(
				  'post_title'      => $displayname,
				  'post_type'       => $post_type ,
				  'post_status'     => 'publish',
				  'post_author' => $user_id, 
				);
				$inserted_id =  wp_insert_post($new_post);
				update_post_meta($inserted_id, $status, '1');
				if (get_post_meta($inserted_id, $user_role_type.'_is_featured', true ) == "1")
				{
				}
				else
				{
					update_post_meta($inserted_id, $user_role_type.'_is_featured', '0');
				}
				update_post_meta($inserted_id, 'prop_user_id', $user_id);
				//get user email
				$user_email = get_the_author_meta( 'user_email', $user_id );
				update_post_meta($inserted_id, $email, $user_email);
				// update against current user
				update_user_meta($user_id, 'prop_post_id', $inserted_id);
				update_user_meta($user_id, 'user_role_type', $user_role_type);
				
				//if agency from frontend
				if(isset($agency_id) && $agency_id !="")
				{
					update_post_meta($inserted_id, 'agent_agency_id', $agency_id);
					update_post_meta($inserted_id, 'agent_mobile', $agenct_mobile );
					//type
					wp_set_object_terms($inserted_id, $agent_type, 'agent_types');
					update_post_meta($inserted_id, 'agent_type', $agent_type);
					$return = array('message' => esc_html__( 'Agent registered successfully.', 'propertya-framework' ));
      				wp_send_json_success($return);
				}
				else
				{
					wp_clear_auth_cookie();
					if(propertya_framework_get_options('propertya_new_user_email_verification') == true)
					    {
					    	 $user = array();
					    	 $user = new WP_User($user_id);
                              foreach ($user->roles as $role) {
                                $user->remove_role($role);
                              }
                              //
                             propertya_account_activation_email($user_id);
                             $return = array('message' => esc_html__( 'A verification link has been sent to your email account.', 'propertya-framework'), 'page_link' => esc_url(get_home_url()));
      				         wp_send_json_success($return);
					    }
					    else
					    {

							propertya_framework_auto_logged($user_mail,$password,true);
				        }
					    
				}
       	    }
		}
	}
}


// Auto Logged In Users
if (!function_exists ( 'propertya_framework_auto_logged' ))
{
	function propertya_framework_auto_logged($user_mail, $password, $remember,$message = false)
	{
		$info = array();
		$info['user_login'] = $user_mail;
		$info['user_password'] = $password;
		$info['remember'] = true;

		$user_signon = wp_signon($info,false);
$token=''; 
		if(propertya_framework_get_options('propertya_new_user_email_verification') !== null && propertya_framework_get_options('propertya_new_user_email_verification') == true)
		{
			$user_id = $user_signon->ID;
			$db_verificaion_key = get_user_meta($user_id, 'user_email_verification_token', $token);
			$verificaton_key = isset( $_GET['verification_key']) ?  $_GET['verification_key'] : '';
         $user = new WP_User( $uid );
      //  $user->set_role( 'subscriber' );
			if(  $user->get_role() == 'null' ){
					$return = array('message' => esc_html__( 'Please verify your email first', 'propertya-framework' ));
	      		wp_send_json_error($return);
			}
		}
		if ( is_wp_error($user_signon) )
		{
			$return = array('message' => esc_html__( 'Wrong username or password.', 'propertya-framework' ));
      		wp_send_json_error($return);
		} else 
			{
				propertya_framework_page_redirect($message);
			}
   	    die();
	}
}

// Registration With Social
add_action( 'wp_ajax_prop_user_registration_social', 'propertya_framework_user_registration_social' );
add_action( 'wp_ajax_nopriv_prop_user_registration_social', 'propertya_framework_user_registration_social' );
if (!function_exists ( 'propertya_framework_user_registration_social'))
{
	function propertya_framework_user_registration_social()
	{
        if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin( get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
        
       $network = (isset($_POST['sb_network'])) ? $_POST['sb_network'] : '';
       $response_response = false;
       $user_name = "";
       if($network == 'facebook')
       {
            $access_token = (isset($_POST['access_token'])) ? $_POST['access_token'] : '';
            $token_verify = wp_remote_get("https://graph.facebook.com/me?fields=name,email&access_token=$access_token");
            if(isset($token_verify['response']['code']) && $token_verify['response']['code'] == '200')
            {
                $info = (json_decode($token_verify['body']));
                if(isset($_POST['email']) && isset($token_verify['body']))
                {
                    if(isset($info->email) && $info->email == $_POST['email'])
                    {
                        $user_name = $info->email;
                        $response_response = true;
                    }
                }
            }
       }
       else if($network == 'google')
       {
            $access_token = (isset($_POST['access_token'])) ? $_POST['access_token'] : '';
            $token_verify = wp_remote_get("https://www.googleapis.com/oauth2/v1/tokeninfo?access_token=$access_token");
            if(isset($token_verify['response']['code']) && $token_verify['response']['code'] == '200')
            {
                $info = (json_decode($token_verify['body']));
                if(isset($_POST['email']) && isset($token_verify['body']))
                {
                    if(isset($info->email) && $info->email == $_POST['email'])
                    {
                        $user_name = $info->email;
                        $response_response = true;
                    }
                }
            }
       }       
       if($response_response == false)
       { 
            $return = array('message' => esc_html__( 'Request timeout.', 'propertya-framework' ));
			wp_send_json_error($return);
       }
        
        
		if(!empty($_POST['name']) && !empty($_POST['email']))
		{
			$username = trim(sanitize_text_field($_POST['name']));
      		$email = trim(sanitize_email($_POST['email']));
			if(email_exists($email) == false)
			{
				$password = wp_generate_password(5, false);
				$user_name	=	explode('@',$email);
				$u_name	=	propertya_framework_check_user_name($user_name[0]);
				$user_id  = wp_create_user($u_name,$password,$email);
				if (!is_wp_error($user_id) )
				{
					wp_update_user(array('ID' =>$user_id,'display_name'=>$username));
					wp_clear_auth_cookie();
					//send email
					if(propertya_framework_get_options('prop_email_onregister') == true)
					{
						propertya_framework_new_user_email($user_id,$password);
					}
                    //if free package assign option is enabled
                    if(!empty(propertya_framework_get_options('prop_woo_enable_packages')) && propertya_framework_get_options('prop_woo_enable_packages') == true && in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' )) ))
                    {
                        if(!empty(propertya_framework_get_options('prop_listing_package_type')))
                        {
                            $product_id = propertya_framework_get_options('prop_listing_package_type');
                            propertya_framework_store_user_package($user_id, $product_id);
                        }
                    }
					// now logged in current user
					propertya_framework_auto_logged($email,$password,true);
				}
				else
				{
					$return = array('message' => esc_html__( 'There was an error while processing your request. Please, reload the page and try again.', 'propertya-framework' ));
      				wp_send_json_error($return);	
					die();
				}
			}
			else
			{
				$user = get_user_by('email',$email);
				$user_id = $user->ID;
				$my_password = $user->data->user_pass;
				wp_set_current_user($user_id);
				wp_set_auth_cookie($user_id);
				propertya_framework_page_redirect(true);
				die();
			}
		}
		else
		{
			$return = array('message' => esc_html__( 'Something went wrong. Please try again later.', 'propertya-framework' ));
      		wp_send_json_error($return);
		}
	}
}

// Check username
if (! function_exists ( 'propertya_framework_check_user_name' ))
{
	function propertya_framework_check_user_name( $username = '' )
	{
		if ( username_exists( $username ) )
		{
			$random = rand();
			$username	=	$username . '-' . $random;
			propertya_framework_check_user_name($username);		
		}
		return $username;
	}
}
// Page Redirection After Looged In Or Register
if (! function_exists ( 'propertya_framework_page_redirect' ))
{
	function propertya_framework_page_redirect($action_type = '')
	{
		$page_redirection = '';
		$page_redirection = propertya_framework_get_link('page-dashboard.php');
		if(propertya_framework_get_options('prop_success_page') !="")
		{
			$page_link = '';
			$page_link = propertya_framework_get_options('prop_success_page');
			$page_redirection = get_the_permalink($page_link);
		}
		if(!empty($action_type) && $action_type == true)
		{
			$msg = esc_html__( 'Logged in successfully redirecting...', 'propertya-framework');
		}
		else
		{
			$msg = esc_html__( 'User registered successfully redirecting...', 'propertya-framework');
		}
		$return = array('message' => $msg,'page_link' => esc_url($page_redirection));
		wp_send_json_success($return);
		die();
	}
}
// Ajax handler for Login User
add_action( 'wp_ajax_prop_user_login', 'propertya_framework_user_login' );
add_action( 'wp_ajax_nopriv_prop_user_login', 'propertya_framework_user_login' );
if (!function_exists ( 'propertya_framework_user_login' ))
{
	function propertya_framework_user_login()
	{
		$params = array();
		parse_str($_POST['collect_data'], $params);
		/*if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin( get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}*/
		if(!wp_verify_nonce($params['login_nonce'], 'prop-login-nonce'))
		{
			 $return = array('message' => esc_html__('Invalid security token sent.', 'propertya-framework'));
      		 wp_send_json_error($return);
   		}
		else
		{
			$email = trim(sanitize_email($params['email']));
			$password = trim(sanitize_text_field( $params['password'] ));

			// Check the e-mail address
			if(empty($email))
			{
				$return = array('message' => esc_html__( 'Please type your e-mail address.', 'propertya-framework' ));
      			wp_send_json_error($return);	
			}
			if(empty($password)){
				$return = array('message' => esc_html__( 'Please choose a password with at least 3-12 characters.', 'propertya-framework' ));
      			wp_send_json_error($return);	
			}
			if ( !is_email( $email ) ) {
				$return = array('message' => esc_html__( 'Please enter a valid email address.', 'propertya-framework' ));
      			wp_send_json_error($return);	
			}
			if(!email_exists($email)) {
				$return = array('message' => esc_html__( 'There is no user registered with that email address.', 'propertya-framework' ));
      			wp_send_json_error($return);	
       		}
			wp_clear_auth_cookie();
			propertya_framework_auto_logged($email,$password,true,true);
			die();
		}
	}
}

// Ajax handler for Forget Password
add_action( 'wp_ajax_prop_forgot_pass', 'propertya_framework_user_forgot_pass' );
add_action( 'wp_ajax_nopriv_prop_forgot_pass', 'propertya_framework_user_forgot_pass' );
if (!function_exists ( 'propertya_framework_user_forgot_pass' ))
{
	function propertya_framework_user_forgot_pass()
	{
		$params = array();
		parse_str($_POST['collect_data'], $params);
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin( get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		if(!wp_verify_nonce($params['reset_nonce'], 'prop-reset-nonce'))
		{
			 $return = array('message' => esc_html__('Invalid security token sent.', 'propertya-framework'));
      		 wp_send_json_error($return);
   		}
		else
		{
      		$email = trim(sanitize_email($params['email']));
			if(empty($email))
			{
				$return = array('message' => esc_html__( 'Please type your e-mail address.', 'propertya-framework' ));
      			wp_send_json_error($return);	
			}
			else if ( !is_email( $email ) )
			{
				$return = array('message' => esc_html__( 'Please enter a valid e-mail address.', 'propertya-framework' ));
      			wp_send_json_error($return);	
			}
			else if(!email_exists($email)) {
				$return = array('message' => esc_html__( 'There is no user registered with that email address.', 'propertya-framework' ));
      			wp_send_json_error($return);	
       		}
			else
			{
				$user = get_user_by('email', $email);
				$user_email = $user->user_login;
				$reset_key = get_password_reset_key($user);
				$signinlink = propertya_framework_get_link('page-signin.php');
				$reset_link = $signinlink.'?action=rp&key='.$reset_key.'&login='.rawurlencode($user_email);
				propertya_framework_forgotpass_email($user->ID,$reset_link);
				$return = array('message' => esc_html__( 'Check your e-mail for the confirmation link.', 'propertya-framework' ));
				wp_send_json_success($return);
				die();
			}
		}
	}
}

// Ajax handler for Reset New Password
add_action( 'wp_ajax_prop_forgot_pass_new', 'propertya_framework_user_forgot_pass_new' );
add_action( 'wp_ajax_nopriv_prop_forgot_pass_new', 'propertya_framework_user_forgot_pass_new' );
if (!function_exists ( 'propertya_framework_user_forgot_pass_new' ))
{
	function propertya_framework_user_forgot_pass_new()
	{
		$params = array();
		parse_str($_POST['collect_data'], $params);
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin( get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		if(!wp_verify_nonce($params['pass_nonce'], 'prop-new-nonce'))
		{
			 $return = array('message' => esc_html__('Invalid security token sent.', 'propertya-framework'));
      		 wp_send_json_error($return);
   		}
		else
		{
			if(!empty($params['requested_user_id']))
			{
				$password = trim(sanitize_text_field( $params['password'] ));
				$user_id = $params['requested_user_id'];
				if(empty($password)){
					$return = array('message' => esc_html__( 'Please choose a password with at least 3-12 characters.', 'propertya-framework' ));
					wp_send_json_error($return);	
				}
				wp_set_password($password, $user_id);
				$return = array('message' => esc_html__( 'Your password has been changed. You can now log in with your new credentials.', 'propertya-framework' ));
				wp_send_json_success($return);	
			}
			else
			{
				$return = array('message' => esc_html__( 'Something went wrong. Please try again later.', 'propertya-framework' ));
      		wp_send_json_error($return);
			}
		}
	}
}

// Social Logins Assign Roles
add_action( 'wp_ajax_prop_usertype_new', 'propertya_framework_usertype_registration' );
if (!function_exists ( 'propertya_framework_usertype_registration' ))
{
	function propertya_framework_usertype_registration()
	{
		$params = array();
		parse_str($_POST['collect_data'], $params);
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin( get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		if(!wp_verify_nonce($params['usertype_nonce'], 'prop-usertype-nonce'))
		{
			 $return = array('message' => esc_html__('Invalid security token sent.', 'propertya-framework'));
      		 wp_send_json_error($return);
   		}
		else
		{
			$user_role_type = trim(sanitize_text_field($params['usertype']));
			$displayname = trim(sanitize_text_field($params['displayname']));
			if(empty($user_role_type)){
				$return = array('message' => esc_html__( 'User type is required.', 'propertya-framework' ));
      			wp_send_json_error($return);	
			}
			if(empty($displayname)){
				$return = array('message' => esc_html__( 'Display name is required.', 'propertya-framework' ));
      			wp_send_json_error($return);	
			}
			$user_mail='';
			$current_user = wp_get_current_user();
			if(!empty($current_user))
			{
				$username = $current_user->display_name;
				$user_id =  $current_user->ID;
				$user_email =  $current_user->user_email;
				//time to assgin admin a role
				propertya_framework_assign_selected_roles($username,$user_id,$user_role_type,$user_mail,$displayname);
				//redirect back
				$page_redirection = propertya_framework_get_link('page-dashboard.php');
				$return = array('message' => esc_html__( 'Redirecting please wait...', 'propertya-framework'),'page_link' => esc_url($page_redirection));
				wp_send_json_success($return);
			}
			else
			{
				$return = array('message' => esc_html__( 'Something went wrong. Please try again later.', 'propertya-framework' ));
      			wp_send_json_error($return); 
			}
  		}
	}
}

