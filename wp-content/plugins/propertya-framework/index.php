<?php 
 /**
 * Plugin Name: Propertya Framework
 * Plugin URI: https://themeforest.net/user/scriptsbundle/
 * Description: This plugin is essential for the proper theme funcationality.
 * Version: 1.1.6
 * Author: Scripts Bundle
 * Author URI: https://themeforest.net/user/scriptsbundle/
 * License: GPL2
 * Text Domain: propertya-framework
 */
	/*Load text domain*/
	add_action( 'plugins_loaded', 'propertya_framework_load_plugin_textdomain',999 );
	function propertya_framework_load_plugin_textdomain()
	{
		load_plugin_textdomain( 'propertya-framework', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
	}	
	define('SB_PLUGIN_FRAMEWORK_PATH', plugin_dir_path(__FILE__));	
	define('SB_PLUGIN_PATH', plugin_dir_path(__FILE__));	
	define('SB_PLUGIN_URL', plugin_dir_url(__FILE__));
	define( 'SB_THEMEURL_PLUGIN', get_template_directory_uri () . '/' );
	
	if ( class_exists( 'Redux' ) ) {
       require SB_PLUGIN_PATH . 'redux-extensions/extensions-init.php';
    }

	//files include
	require SB_PLUGIN_PATH . 'functions.php';
	require SB_PLUGIN_PATH . 'plugin-files/cpt/property.php';
	require SB_PLUGIN_PATH . 'plugin-files/cpt/agencies.php';
	require SB_PLUGIN_PATH . 'plugin-files/cpt/agent.php';
	require SB_PLUGIN_PATH . 'plugin-files/cpt/buyer.php';
	require SB_PLUGIN_PATH . 'plugin-files/cpt/users.php';
	require SB_PLUGIN_PATH . 'plugin-files/cpt/invoice.php';
	require SB_PLUGIN_PATH . 'plugin-files/metaboxes/terms-meta.php';
	require SB_PLUGIN_PATH . 'plugin-files/metaboxes/terms-meta-currency.php';
	require SB_PLUGIN_PATH . 'plugin-files/metaboxes/terms-meta-label.php';
	require SB_PLUGIN_PATH . 'plugin-files/metaboxes/terms-meta-status.php';
	require SB_PLUGIN_PATH . 'plugin-files/metaboxes/terms-meta-agent-types.php';
	require SB_PLUGIN_PATH . 'plugin-files/metaboxes/submit-property.php';
	require SB_PLUGIN_PATH . 'plugin-files/metaboxes/agency.php';
	require SB_PLUGIN_PATH . 'plugin-files/metaboxes/agents.php';
	require SB_PLUGIN_PATH . 'plugin-files/metaboxes/buyers.php';
	require SB_PLUGIN_PATH . 'plugin-files/metaboxes/packages.php';
	require SB_PLUGIN_PATH . 'plugin-files/metaboxes/invoice.php';
	require SB_PLUGIN_PATH . 'plugin-files/classes/payments.php';
	require SB_PLUGIN_PATH . 'plugin-files/shortcodes/shortcode.php';
	require SB_PLUGIN_PATH . 'inc/utilities.php';
	require SB_PLUGIN_PATH . 'inc/emails.php';
	require SB_PLUGIN_PATH . 'inc/dashboard.php';
	require SB_PLUGIN_PATH . "inc/classes/index.php";
	//custom fields
	if(in_array('advanced-custom-fields/acf.php', apply_filters('active_plugins', get_option('active_plugins'))) && class_exists('ACF'))
	{
		require SB_PLUGIN_PATH . 'inc/classes/propertya_fields.php';
	}

	add_action( 'admin_enqueue_scripts', 'propertya_framework_scripts' );
	function propertya_framework_scripts()
	{
		/*Enqueue scripts in wp admin*/
		wp_enqueue_style( 'dwt_admin_select2',  plugin_dir_url( __FILE__ ) . 'libs/css/select2.min.css' );
		wp_enqueue_style( 'dwt_listing_admin_css',  plugin_dir_url( __FILE__ ) . 'libs/css/admin.css' );
		wp_enqueue_script( 'dwt_listing_admin_select2',  plugin_dir_url( __FILE__ ) . 'libs/js/select2.min.js', false, false, true );
		wp_enqueue_script( 'dwt_listing_custom_admin_js',  plugin_dir_url( __FILE__ ) . 'libs/js/custom_admin.js', false, false, true );
		wp_enqueue_script( 'admin-scrpt',  plugin_dir_url( __FILE__ ) . 'libs/js/admin-scrpt.js', false, false, true );
	}
	if ( class_exists( 'Redux' ) ) {
		if( get_option( 'propertya_options' ) == "" )
		{
			$theme_option_name	=	'propertya_options';
			// Header Options
			Redux::setOption($theme_option_name, 'prop_main_logo', array('url' => SB_THEMEURL_PLUGIN . 'libs/images/logo.svg'));
			Redux::setOption($theme_option_name, 'prop_trans_logo', array('url' => SB_THEMEURL_PLUGIN . 'libs/images/logo-white.svg'));
			Redux::setOption($theme_option_name, 'prop_mobile_logo', array('url' => SB_THEMEURL_PLUGIN . 'libs/images/mobile-logo.png'));
			Redux::setOption($theme_option_name, 'prop_site_spinner', '1' );
			Redux::setOption($theme_option_name, 'prop_theme_clr', '#2296f9' );
			Redux::setOption($theme_option_name, 'prop_btn_plate', array('regular' =>'#2296f9' ,'hover' => '#f71735' ,'active' => '#f71735'));
			Redux::setOption($theme_option_name, 'prop_selected_header', '2' );
			
			
			//Map settings
			Redux::setOption($theme_option_name, 'property_opt_enable_map', '1' );
            Redux::setOption($theme_option_name, 'prop_dashboard', '0' );
			Redux::setOption($theme_option_name, 'property_opt_map_selection', 'open_street' );
			Redux::setOption($theme_option_name, 'property_opt_gmap_api_key', '' );
			Redux::setOption($theme_option_name, 'property_opt_default_lat', '40.7127837' );
			Redux::setOption($theme_option_name, 'property_opt_default_long', '-74.00594130000002' );
			
			//Geo APi Settings
			Redux::setOption($theme_option_name, 'property_opt_enable_geo', '1' );
			Redux::setOption($theme_option_name, 'property_opt_api_settings', 'geo_ip' );
			
			//Price & Currency
			Redux::setOption($theme_option_name, 'property_opt_currency_position', 'before' );
			Redux::setOption($theme_option_name, 'property_opt_decimals', '0' );
			Redux::setOption($theme_option_name, 'property_opt_decimals_separator', '.' );
			Redux::setOption($theme_option_name, 'property_opt_thousand_separator', ',' );
            
            //Member Method
            Redux::setOption($theme_option_name, 'prop_membership_type', 'with-woo' );

            //topbar
			Redux::setOption($theme_option_name, 'prop_top_container', '1' );
			Redux::setOption($theme_option_name, 'prop_top_email', 'xyz@email.com' );
			Redux::setOption($theme_option_name, 'prop_top_contactno', '+44 7700 900573' );
			Redux::setOption($theme_option_name, 'prop_top_hours', 'Monday - Saturday 8AM - 7PM' );
			
			//Property Submission
			Redux::setOption($theme_option_name, 'property_approval', '45' );
			Redux::setOption($theme_option_name, 'property_approval', array('auto') );
			Redux::setOption($theme_option_name, 'prop_show_hide_fields', array('property_type' => '1','offer_type' 	=> '1','property_label' => '1','property_price' => '1','snd_price' 	=> '1','before_price' => '1','after_price' => '1','property_area' => '1','area_prefix' => '1','land_area' => '1','land_area_prefix' => '1','bedrooms' => '1','bathrooms' => '1','grages' => '1','yearbuild' => '1','video' => '1','virtual_tour' => '1','desc' => '1','gallery' => '1','zip_code' => '1','street_location' => '1','map' => '1','coordinates' => '1','location' => '1','floorplan' => '1','additional_fields' => '1','attachments' => '1'));
			Redux::setOption($theme_option_name, 'required_fields', array('property_type' => '1','offer_type' 	=> '1','property_label' => '0','property_price' => '1','snd_price' 	=> '0','before_price' => '0','after_price' => '0','property_area' => '1','area_prefix' => '1','land_area' => '1','land_area_prefix' => '1','bedrooms' => '1','bathrooms' => '1','grages' => '1','yearbuild' => '1','video' => '0','virtual_tour' => '0','desc' => '1','gallery' => '1','zip_code' => '0','street_location' => '0','map' => '0','coordinates' => '0','location' => '1','floorplan' => '0','additional_fields' => '0','attachments' => '0'));
			Redux::setOption($theme_option_name, 'prop_field_title', 'Property Title' );
			Redux::setOption($theme_option_name, 'prop_field_title_place', 'Detached house for sale' );
			Redux::setOption($theme_option_name, 'prop_desc_field', 'Property Description' );
			Redux::setOption($theme_option_name, 'prop_property_type', 'Property Type' );
			Redux::setOption($theme_option_name, 'property_type_place', 'Select Category' );
			Redux::setOption($theme_option_name, 'prop_offer_type', 'Offer Type' );
			Redux::setOption($theme_option_name, 'prop_offer_type_place', 'Listed In' );
			Redux::setOption($theme_option_name, 'prop_status_type', 'Property Status' );
			Redux::setOption($theme_option_name, 'prop_status_type_place', 'Select Property Status' );
			Redux::setOption($theme_option_name, 'prop_curr_type', 'Currency Type');
			Redux::setOption($theme_option_name, 'prop_curr_type_place', 'Select Currency');
			Redux::setOption($theme_option_name, 'prop_pri_type', 'Sale or Rent Price');
			Redux::setOption($theme_option_name, 'prop_pri_type_hint', '(Eg: 75000)');
			Redux::setOption($theme_option_name, 'prop_second_type', 'Second Price');
			Redux::setOption($theme_option_name, 'prop_second_type_hint', '(Optional)');
			Redux::setOption($theme_option_name, 'prop_after_type', 'After Price Label');
			Redux::setOption($theme_option_name, 'prop_after_hint', '(Eg: Per Month)');
			Redux::setOption($theme_option_name, 'prop_before_type', 'Price Prefix');
			Redux::setOption($theme_option_name, 'prop_before_hint', '(Eg: Start From)');
			Redux::setOption($theme_option_name, 'prop_a_size', 'Area Size' );
			Redux::setOption($theme_option_name, 'prop_a_size_hint', '( Only digits )' );
			Redux::setOption($theme_option_name, 'prop_a_size_place', 'Eg 2500' );
			Redux::setOption($theme_option_name, 'prop_a_prefix', 'Area Size Prefix' );
			Redux::setOption($theme_option_name, 'prop_a_prefix_hint', '( Eg: Sq Ft)' );
			Redux::setOption($theme_option_name, 'prop_l_area', 'Land Area' );
			Redux::setOption($theme_option_name, 'prop_l_area_hint', '( Only digits )' );
			Redux::setOption($theme_option_name, 'prop_l_area_place', 'Eg 1300' );
			Redux::setOption($theme_option_name, 'prop_a_land_prefix', 'Land Area Prefix' );
			Redux::setOption($theme_option_name, 'prop_a_land_hint', '( Eg: Sq Ft)' );
			Redux::setOption($theme_option_name, 'prop_a_bed_title', 'Bedrooms' );
			Redux::setOption($theme_option_name, 'prop_a_bed_place', '( Eg: 4)' );
			Redux::setOption($theme_option_name, 'prop_a_bath_title', 'Bathrooms');
			Redux::setOption($theme_option_name, 'prop_a_bath_place', '( Eg: 2)' );
			Redux::setOption($theme_option_name, 'prop_a_grage_title', 'Garages' );
			Redux::setOption($theme_option_name, 'prop_a_grage_place', '( Eg: 1)' );
			Redux::setOption($theme_option_name, 'prop_a_year_title', 'Year Built' );
			Redux::setOption($theme_option_name, 'prop_a_year_place', 'Eg: November 2010' );
			Redux::setOption($theme_option_name, 'prop_a_video_title', 'Video Link' );
			Redux::setOption($theme_option_name, 'prop_a_video_place', 'Youtube Video Link' );
			Redux::setOption($theme_option_name, 'prop_v_tour_title', '360° Virtual Tour' );
			Redux::setOption($theme_option_name, 'prop_v_tour_place', 'Copy/paste the iframe code of your 360° virtual tour.' );
		}
	}


//Get Template Slug
if( !function_exists('propertya_framework_get_options') )
{
	function propertya_framework_get_options($get_text)
	{

		 $propertya_options  =  get_option('propertya_options');
		
		
		if(isset($propertya_options[$get_text]) &&  $propertya_options[$get_text] !=""):
			return $propertya_options[$get_text];
		else:
			return false;
		endif;
	}
}
	
// Admin translated options	
if ( ! function_exists( 'propertya_framework_translated_words' ) )
{
	function propertya_framework_translated_words($hook)
	{
		wp_localize_script(
		'dwt_listing_custom_admin_js',
		'admin_varible',
		 array(
				'p_path' => plugin_dir_url( __FILE__ ),
				'timepicker' => esc_html__( 'Timepicker', 'propertya-framework' ),
				'Sunday' => esc_html__( 'Sunday', 'propertya-framework' ),
				'Monday' => esc_html__( 'Monday', 'propertya-framework' ),
				'Tuesday' => esc_html__( 'Tuesday', 'propertya-framework' ),
				'Wednesday' => esc_html__( 'Wednesday', 'propertya-framework' ),
				'Thursday' => esc_html__( 'Thursday', 'propertya-framework' ),
				'Friday' => esc_html__( 'Friday', 'propertya-framework' ),
				'Saturday' => esc_html__( 'Saturday', 'propertya-framework' ),
				'Sun' => esc_html__( 'Sun', 'propertya-framework' ),
				'Mon' => esc_html__( 'Mon', 'propertya-framework' ),
				'Tue' => esc_html__( 'Tue', 'propertya-framework' ),
				'Wed' => esc_html__( 'Wed', 'propertya-framework' ),
				'Thu' => esc_html__( 'Thu', 'propertya-framework' ),
				'Fri' => esc_html__( 'Fri', 'propertya-framework' ),
				'Sat' => esc_html__( 'Sat', 'propertya-framework' ),
				'Su' => esc_html__( 'Su', 'propertya-framework' ),
				'Mo' => esc_html__( 'Mo', 'propertya-framework' ),
				'Tu' => esc_html__( 'Tu', 'propertya-framework' ),
				'We' => esc_html__( 'We', 'propertya-framework' ),
				'Th' => esc_html__( 'Th', 'propertya-framework' ),
				'Fr' => esc_html__( 'Fr', 'propertya-framework' ),
				'Sa' => esc_html__( 'Sa', 'propertya-framework' ),
				'January' => esc_html__( 'January', 'propertya-framework' ),
				'February' => esc_html__( 'February', 'propertya-framework' ),
				'March' => esc_html__( 'March', 'propertya-framework' ),
				'April' => esc_html__( 'April', 'propertya-framework' ),
				'May' => esc_html__( 'May', 'propertya-framework' ),
				'June' => esc_html__( 'June', 'propertya-framework' ),
				'July' => esc_html__( 'July', 'propertya-framework' ),
				'August' => esc_html__( 'August', 'propertya-framework' ),
				'September' => esc_html__( 'September', 'propertya-framework' ),
				'October' => esc_html__( 'October', 'propertya-framework' ),
				'November' => esc_html__( 'November', 'propertya-framework' ),
				'December' => esc_html__( 'December', 'propertya-framework' ),
				'Jan' => esc_html__( 'Jan', 'propertya-framework' ),
				'Feb' => esc_html__( 'Feb', 'propertya-framework' ),
				'Mar' => esc_html__( 'Mar', 'propertya-framework' ),
				'Apr' => esc_html__( 'Apr', 'propertya-framework' ),
				'May' => esc_html__( 'May', 'propertya-framework' ),
				'Jun' => esc_html__( 'Jun', 'propertya-framework' ),
				'Jul' => esc_html__( 'July', 'propertya-framework' ),
				'Aug' => esc_html__( 'Aug', 'propertya-framework' ),
				'Sep' => esc_html__( 'Sep', 'propertya-framework' ),
				'Oct' => esc_html__( 'Oct', 'propertya-framework' ),
				'Nov' => esc_html__( 'Nov', 'propertya-framework' ),
				'Dec' => esc_html__( 'Dec', 'propertya-framework' ),
				'Today' => esc_html__( 'Today', 'propertya-framework' ),
				'Clear' => esc_html__( 'Clear', 'propertya-framework' ),
				'dateFormat' => esc_html__( 'dateFormat', 'propertya-framework' ),
				
			)
		);
	}
}
add_action('admin_enqueue_scripts', 'propertya_framework_translated_words');
// Enque Js Static Strings On Frontend
if ( ! function_exists( 'propertya_framework_static_strings' ) )
{
	function propertya_framework_static_strings()
	{
		 $geo_ip_type = '';
		 if(propertya_framework_get_options('property_opt_enable_geo') == true)
		 {
			 $geo_ip_type = propertya_framework_get_options('property_opt_api_settings');
		 }
		 $access_key = '';
		 if(propertya_framework_get_options('property_opt_map_selection') == 'mapbox')
		 {
			 $access_key = propertya_framework_get_options('property_opt_mapbox_api_key');
	     }
		 $gapi_key = '';
		 if(propertya_framework_get_options('property_opt_map_selection') == 'google_map')
		 {
			 $gapi_key = propertya_framework_get_options('property_opt_gmap_api_key');
	     }
		 $authorization = false; 
		 if (filter_input(INPUT_GET, 'authorization') === 'restricted' )
		 {
			$authorization = true; 
		 }
         $all_numbers = '';
         if(propertya_framework_get_options('prop_contact_number_selector') == false && !empty(propertya_framework_get_options('prop_contact_number_selective')))
         {
             $all_numbers = propertya_framework_get_options('prop_contact_number_selective');
         }
		 //for password reset
		 $reset = false;
		 $is_reset = false;
		 $user_id = $status_msg = '';
		 if(is_page_template('page-signin.php'))
		 {
			 if(!empty($_GET['key']) && !empty($_GET['login']))
			 {
				  $is_reset = true;
				  $reset = false;
				  $user = check_password_reset_key($_GET['key'], $_GET['login']);
				  $errors = new WP_Error();
				  if ( is_wp_error($user) )
				  {
					$reset = false;
					if ( $user->get_error_code() === 'expired_key')
					{
						$status_msg = esc_html__('Key is expired.', 'propertya-framework' );
					}  
					else
					{
						$status_msg = esc_html__('Key is not valid.', 'propertya-framework' );
					}
				  }
				  else
				  {
					$reset = true;
					$user_id = $user->ID;
				  	$status_msg = esc_html__('Choose your password.', 'propertya-framework' );
				  }
			 }
		 }
		 //user don't have any role
		 $dont_have_role = false;
		 if(is_page_template('page-dashboard.php') && is_user_logged_in())
		 {
			$user_id = get_current_user_id();
			if(get_user_meta($user_id, 'user_role_type',true)=="")
			{
				$dont_have_role = true;
			}
		 }
		 // single property
		$latt =  propertya_framework_get_options('property_opt_default_lat');
		$lon =  propertya_framework_get_options('property_opt_default_long');
		if (get_post_type(get_the_ID()) == 'property' && is_singular('property'))
		{	
			$property_id = get_the_ID();
			if(get_post_meta($property_id, 'prop_latt', true ) !="")
			{
				$latt = get_post_meta($property_id, 'prop_latt', true );
			}
			if(get_post_meta($property_id, 'prop_long', true ) !="")
			{
				$lon = get_post_meta($property_id, 'prop_long', true );
			}
		}
		 // single agency
		if (get_post_type(get_the_ID()) == 'property-agency' && is_singular('property-agency'))
		{	
			$agency_id = get_the_ID();
			if(get_post_meta($agency_id, 'agency_latt', true ) !="")
			{
				$latt = get_post_meta($agency_id, 'agency_latt', true );
			}
			if(get_post_meta($agency_id, 'agency_long', true ) !="")
			{
				$lon = get_post_meta($agency_id, 'agency_long', true );
			}
		}
        $rtl = 'false';
        if(is_rtl())
        {
            $rtl = 'true';
        }
        wp_localize_script(
			'propertya-custom',  // name of js file
			'get_strings',
			 array(
			 't_path' => get_template_directory_uri(),
				 'p_path' => plugin_dir_url(__FILE__),
				 'ajax_url' => esc_url(admin_url( 'admin-ajax.php' )),
				 'ajax_nonce' => wp_create_nonce('check-security'),
                 'no_r_for' => esc_html__( 'No result for ', 'propertya-framework' ),
				 'conf' => esc_html__( 'Confirmation!', 'propertya-framework' ),
				 'content' => esc_html__( 'Are you sure you want to do this?', 'propertya-framework' ),
				 'cong' => esc_html__( 'Congratulations!', 'propertya-framework' ),
                 'click_reveal' => esc_html__( 'Click to reveal!', 'propertya-framework' ),
                 'rtl' => $rtl,
				 'ok' => esc_html__( 'Yes', 'propertya-framework' ),
				 'cancle' => esc_html__( 'Cancel', 'propertya-framework' ),
				 'whoops' => esc_html__( 'Whoops!', 'propertya-framework' ),
				 'submission_fail' => esc_html__( 'Form submission failed!', 'propertya-framework' ),
				 'p_denied' => esc_html__( 'Permission denied by user.', 'propertya-framework' ),
				 'p_unava' => esc_html__( 'Location position unavailable.', 'propertya-framework' ),
				 'req_timeout' => esc_html__( 'Request timeout. Please refresh the page and try again.', 'propertya-framework' ),
				 'unknow_error' => esc_html__( 'Unknown error. Please refresh the page and try again.', 'propertya-framework' ),
				 'geolocation' => esc_html__( "Browser doesn't support geolocation!.", 'propertya-framework' ),
				 'ip_type' => $geo_ip_type,
				 'is_map_enabled' => propertya_framework_get_options('property_opt_enable_map'),
				  'map_type' => propertya_framework_get_options('property_opt_map_selection') ,
				  'map_latt' => esc_attr($latt), 
				  'map_long' => esc_attr($lon),
				  'gapp_keyz' => $gapi_key,
				  'acc_keyz' => $access_key,
				  'whoops' => esc_html__( 'Whoops!', 'propertya-framework' ),
				  'congratulations' => esc_html__('Congratulations!', 'propertya-framework'),
				  'social_logins' => propertya_framework_get_options('prop_enable_social'),
				  'fb_key' => propertya_framework_get_options('prop_fb_key'),
				  'google_key' => propertya_framework_get_options('prop_google_key'),
				  'redirect_url' => propertya_framework_get_options('prop_redirect_uri'),
				  'authorization' => $authorization,
				  'auth_warning' => esc_html__( 'Sorry, you are not allowed to access this page.', 'propertya-framework' ),
				  'is_reset' => $is_reset,
				  'reset_status' => array('status'=>$reset,'r_msg'=>$status_msg,"requested_id"=>$user_id),
				  'dont_have_role' => $dont_have_role,
                  'all_numbers' => $all_numbers
			)
		);

	}	 
	}
	add_action('wp_enqueue_scripts', 'propertya_framework_static_strings', 100);

	add_action('admin_enqueue_scripts', 'propertya_framework_map_strings', 100);
// Enque Js Static Strings On backend
if ( ! function_exists( 'propertya_framework_map_strings' ) )
{
	function propertya_framework_map_strings()
	{
		 $geo_ip_type = '';
		 if(propertya_framework_get_options('property_opt_enable_geo') == true)
		 {
			 $geo_ip_type = propertya_framework_get_options('property_opt_api_settings');
		 }
		 $access_key = '';
		 if(propertya_framework_get_options('property_opt_map_selection') == 'mapbox')
		 {
			 $access_key = propertya_framework_get_options('property_opt_mapbox_api_key');
	     }
		 $gapi_key = '';
		 if(propertya_framework_get_options('property_opt_map_selection') == 'google_map')
		 {
			 $gapi_key = propertya_framework_get_options('property_opt_gmap_api_key');
	     }
		 
		 // single property
		$latt =  propertya_framework_get_options('property_opt_default_lat');
		$lon =  propertya_framework_get_options('property_opt_default_long');
		if (get_post_type(get_the_ID()) == 'property' && is_singular('property'))
		{	
			$property_id = get_the_ID();
			if(get_post_meta($property_id, 'prop_latt', true ) !="")
			{
				$latt = get_post_meta($property_id, 'prop_latt', true );
			}
			if(get_post_meta($property_id, 'prop_long', true ) !="")
			{
				$lon = get_post_meta($property_id, 'prop_long', true );
			}
		}
		 // single agency
		if (get_post_type(get_the_ID()) == 'property-agency' && is_singular('property-agency'))
		{	
			$agency_id = get_the_ID();
			if(get_post_meta($agency_id, 'agency_latt', true ) !="")
			{
				$latt = get_post_meta($agency_id, 'agency_latt', true );
			}
			if(get_post_meta($agency_id, 'agency_long', true ) !="")
			{
				$lon = get_post_meta($agency_id, 'agency_long', true );
			}
		}
        $rtl = 'false';
        if(is_rtl())
        {
            $rtl = 'true';
        }
        wp_localize_script(
			'admin-scrpt',  // name of js file
			'get_map_string',
			 array(
			 
				 'is_map_enabled' => propertya_framework_get_options('property_opt_enable_map'),
				  'map_type' => propertya_framework_get_options('property_opt_map_selection') ,
				  'map_latt' => esc_attr($latt), 
				  'map_long' => esc_attr($lon),
				  'gapp_keyz' => $gapi_key,
				  'acc_keyz' => $access_key,
				  'google_key' => propertya_framework_get_options('prop_google_key'),
			)
		); 
	}
}
	//for stickey header
	function propertya_framework_sticky_header()
	{
		$sticky_header = 0;
		 if(propertya_framework_get_options('prop_sticky_header') == true)
		 {
			 $sticky_header = true;
	     }
		wp_localize_script(
			'sb-menu',  // name of js file
			'sb_menu_strings',
			 array(
				  'sticky_header' => $sticky_header,
			)
		);
	}
	add_action('wp_enqueue_scripts', 'propertya_framework_sticky_header', 100);


// Enque Submit Property
if(isset($_GET['page-type']) && $_GET['page-type'] == 'submit-property')
{
	if ( ! function_exists( 'propertya_framework_from_strings' ) )
	{
		function propertya_framework_from_strings()
		{
			 wp_localize_script(
				'propertya-submission',  // name of js file
				'form_strings',
				 array(
				 	 'conf' => esc_html__( 'Confirmation!', 'propertya-framework' ),
					 'content' => esc_html__( 'Are you sure you want to do this?', 'propertya-framework' ),
					 'ok' => esc_html__( 'Yes', 'propertya-framework' ),
				 	 'cancle' => esc_html__( 'Cancel', 'propertya-framework' ),
					 'media' => esc_html__( 'Select or Upload Media', 'propertya-framework' ),
					 'media_attach' => esc_html__( 'Select Attachments', 'propertya-framework' ),
					 'media_txt' => esc_html__( 'Use this media', 'propertya-framework' ),
					 'submission_fail' => esc_html__( 'Form submission failed!', 'propertya-framework' ),
					 'ajax_url' => esc_url(admin_url( 'admin-ajax.php' )),
					 'f_title' =>  propertya_framework_get_options('prop_a_fields_title'),
					 'f_value' =>  propertya_framework_get_options('prop_a_fields_value'),
					 'fp_title' =>  propertya_framework_get_options('prop_fplan_title'),
					 'fp_place' =>  propertya_framework_get_options('prop_fplan_title_place'),
					 'fp_price' =>  propertya_framework_get_options('prop_fplan_price'),
					 'fp_price_place' =>  propertya_framework_get_options('prop_fplan_price_place'),
					 'fp_price_prefix' =>  propertya_framework_get_options('prop_fplan_priceprefix_title'),
					 'fp_price_prefix_place' =>  propertya_framework_get_options('prop_fplan_priceprefix_place'),
					 'fp_floorsize' =>  propertya_framework_get_options('prop_fplan_size_title'),
					 'fp_floorsize_place' =>  propertya_framework_get_options('prop_fplan_size_place'),
					 'fp_floorsize_postfix' =>  propertya_framework_get_options('prop_fplan_sizepost_title'),
					 'fp_floorsize_postfix_place' =>  propertya_framework_get_options('prop_fplan_sizepost_place'),
					 'fp_bed' =>  propertya_framework_get_options('prop_fplan_bed_title'),
					 'fp_fp_bed_place' =>  propertya_framework_get_options('prop_fplan_bed_place'),
					 'fp_bath' =>  propertya_framework_get_options('prop_fplan_bath_title'),
					 'fp_bath_place' =>  propertya_framework_get_options('prop_fplan_bath_place'),
					 'fp_desc' =>  propertya_framework_get_options('prop_fplan_desc_title'),
					 'fp_img' =>  propertya_framework_get_options('prop_fplan_image_title'),
					 'fp_img_hint' =>  'The recommended minimum width is 770px and height is flexible.',
					 'fp_delete' =>  propertya_framework_get_options('prop_fplan_del_btn'),
					 'select_images' => esc_html__( 'Select Floor Plan Images', 'propertya-framework' ),
					 'select_plan_img' => esc_html__( 'Select Plan Image', 'propertya-framework' ),
					 'select_plan_del' => esc_html__( 'Delete Plan Image', 'propertya-framework' ),
					 
				)
			);
		}
		add_action('wp_enqueue_scripts', 'propertya_framework_from_strings', 100);
	}
}


// Payment Methods With Images
if (!function_exists('propertya_framework_payment_imgz'))
{
    function propertya_framework_payment_imgz($method_type = '')
	{
		$methods         =  array(1 => plugin_dir_url(__FILE__) . 'libs/images/stripe-logo.png',2 => plugin_dir_url( __FILE__ ) . 'libs/images/paypal.png',3 =>plugin_dir_url( __FILE__ ) . 'libs/images/razorpay-logo.png');
		 return  $final_val = isset( $methods[ $method_type ] ) ? $methods[ $method_type ] : '';
	}
}


//Remove Admin Bar for logged in users
function propertya_framework_hide_admin_bar($show)
{
	if ( ! current_user_can('administrator'))
	{
		return false;
	}
	return $show;
}
add_filter( 'show_admin_bar', 'propertya_framework_hide_admin_bar' );
//Remove Wp Access For users
function propertya_framework_dashboard_access_handler()
{
	if ( is_admin() && ! current_user_can( 'administrator' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) )
	{
		$redirect = add_query_arg('authorization', 'restricted', home_url('/'));
			wp_redirect( $redirect );
		exit;
	}
}
add_action( 'admin_init', 'propertya_framework_dashboard_access_handler' );
//Remove Defualt Css
add_action('get_header', 'propertya_framework_admin_login_header');
function propertya_framework_admin_login_header()
{
	remove_action('wp_head', '_admin_bar_bump_cb');
}

//Chats Stats

if ( ! function_exists( 'propertya_framework_chart_strings' ) )
{
	function propertya_framework_chart_strings()
	{
		if(is_singular('property') || is_singular('property-agents') || is_singular('property-agency') || is_singular('property-buyers') || isset($_GET['page-type']) && $_GET['page-type'] == 'dashboard' || is_page_template('page-dashboard.php') && empty($_GET['page-type']))
		{
			
			$property_id	=	get_the_ID();
			$view_key = '';
			if(is_singular('property-agents'))
			{
				$view_key = 'agent';
			}
			if(is_singular('property-agency'))
			{
				$view_key = 'agency';
			}
			if(is_singular('property-buyers'))
			{
				$view_key = 'buyer';
			}
			if(isset($_GET['page-type']) && $_GET['page-type'] == 'dashboard' || is_page_template('page-dashboard.php') && empty($_GET['page-type']))
			{
				if ( is_user_logged_in() )
				{
					$user_id = get_current_user_id();
					if(get_user_meta( $user_id, 'prop_post_id', true) !="" && get_user_meta($user_id, 'user_role_type', true) !="")
					{
						$author_id = get_user_meta( $user_id, 'prop_post_id' , true );
						$owner_id = get_post_field( 'post_author', $author_id );
						$property_id = $author_id;
						if(get_user_meta( $user_id, 'user_role_type', true) == 'agency')
						{
							$view_key = 'agency';
						}
						if(get_user_meta( $user_id, 'user_role_type', true) == 'agent')
						{
							$view_key = 'agent';
						}
						if(get_user_meta( $user_id, 'user_role_type', true) == 'buyer')
						{
							$view_key = 'buyer';
						}
					}
				}
			}
			global $propertya_options;
			$is_show = isset( $propertya_options['prop_layout_manager']['enabled']['views']) ? '1' : '0';
			$data = $labes = '';
			$chart_type = 'bar';
			if(isset($propertya_options['prop_chart_type']) && $propertya_options['prop_chart_type'] !="")
			{
				$chart_type = $propertya_options['prop_chart_type'];
			}
			$chart_bg =  isset($propertya_options['prop_chart_bg']['rgba']) ? $propertya_options['prop_chart_bg']['rgba'] : 'rgba(0,174,239,0.2)';
			$chart_border =  isset($propertya_options['prop_chart_border']) ? $propertya_options['prop_chart_border'] : '#00aeef';
			$labes = propertya_chart_labels($property_id,false,$view_key);
			$data = propertya_chart_labels($property_id, true,$view_key);
			 wp_localize_script(
				'propertya-stats',  // name of js file
				'chart_strings',
				 array(
				 	 'chart_type' => $chart_type,
					 'chart_bg' => $chart_bg,
					 'chart_border' => $chart_border,
					 'labelz' => $labes,
					 'stats_data' => $data,
					 'is_show' => $is_show,
				)
			);
		}
	}
	add_action('wp_enqueue_scripts', 'propertya_framework_chart_strings', 100);
}

//Yelp Included
add_action('wp', 'propertya_framework_chart_strings_yelp', 100);
if ( ! function_exists( 'propertya_framework_chart_strings_yelp' ) )
{
	function propertya_framework_chart_strings_yelp()
	{
		global $propertya_options;
		if(isset($propertya_options['prop_layout_manager']['enabled']['nearby']) && $propertya_options['prop_layout_manager']['enabled']['nearby']!="" && is_singular('property'))
		{
			$selected_long = $selected_latt = '';
			$property_id	=	get_the_ID();
			$selected_latt = get_post_meta($property_id, 'prop_latt', true );
		    $selected_long = get_post_meta($property_id, 'prop_long', true );
			if(!empty(propertya_framework_get_options('prop_yelp_api_key')) && !empty($selected_latt) && !empty($selected_long))
			{
				require SB_PLUGIN_PATH . "libs/yelp/yelp.php";
			}
		}
	}
}
// Get Specific Page Link
if (!function_exists('propertya_framework_get_link'))
{
    function propertya_framework_get_link($page_name)
	{
		if(!empty($page_name))
		{
			$archive_id = $archive_page = '';
			$archive_page = get_pages(
				array(
					'meta_key' => '_wp_page_template',
					'meta_value' => $page_name
				)
			);
			if(!empty($archive_page))
			{
				$archive_id = $archive_page[0]->ID;
				return  get_permalink( $archive_id );
			}
		}
	}
}
add_action('wp', 'prop_framework_get_fetch_api', 10);
if ( ! function_exists('prop_framework_get_fetch_api'))
{
	function prop_framework_get_fetch_api()
	{
		// propertya_framework_get_options
		if (propertya_framework_get_options('prop_enable_currency_switcher') == true && propertya_framework_get_options('prop_single_currency_code') != '' && propertya_framework_get_options('prop_enable_currency_api_key') != '' &&  propertya_framework_get_options('prop_opt_currency_switcher_languages') != '')
		{

			// if(false === ($rates = get_transient('prop_daily_conversion_rates') ))
			// {
			$rates =  get_transient('prop_daily_conversion_rates' );

				if(!empty($rates))
				{ 
				$currency_code = propertya_framework_get_options('prop_single_currency_code');
				$api_key = propertya_framework_get_options('prop_enable_currency_api_key');
				$cur_url = 'https://v6.exchangerate-api.com/v6/'.$api_key.'/latest/'.$currency_code.'';
				$response_json = file_get_contents($cur_url);
				// Continuing if we got a result
				if(false !== $response_json)
				{
					 try
					 {
						 $response = json_decode($response_json);
						 if('success' === $response->result)
						 {
							 set_transient('prop_daily_conversion_rates', $response->conversion_rates, 12 * HOUR_IN_SECONDS);
						 }
						 else
						 {
							throw new Exception(); 
						 }
					 }
					 catch(\Exception $e)
					 {
						  return false;
    				 }
				}
			}
		}
	}
}