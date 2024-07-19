<?php
/**
 * propertya functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Propertya
 */
add_action( "after_setup_theme", "propertya_setup" );
if ( ! function_exists( "propertya_setup" ) )
{
    /*Theme Settings*/
    function propertya_setup()
    {
        /* Theme Settings */
        require trailingslashit( get_template_directory () ) . "inc/theme_settings.php";
        /* Custom Navigation Walker */
        require trailingslashit(get_template_directory()) . "inc/nav.php";
        /* Load Redux Options */
        require trailingslashit( get_template_directory () ) . "inc/options.php";
        /* Theme localization */
        require trailingslashit( get_template_directory () ) . "inc/localization.php";
        /* Theme Functions */
        require trailingslashit( get_template_directory () ) . "inc/theme_functions.php";
        /* Theme Utilities */
        require trailingslashit( get_template_directory () ) . "inc/theme_utilities.php";
        /* Theme Typo */
        require trailingslashit( get_template_directory () ) . "inc/typography.php";
        /* Theme Classes */
        require trailingslashit( get_template_directory () ) . "inc/classes/index.php";
        /* Theme TGM */
        require trailingslashit( get_template_directory () ) . "tgm/tgm-init.php";
        /* Theme WPML */
        require trailingslashit( get_template_directory () ) . "inc/wpml/wpml-functions.php";
		remove_theme_support( 'widgets-block-editor' );

    }
}
/* ------------------------------------------------ */
/* Enqueue scripts and styles. */
/* ------------------------------------------------ */
function enqueue_select2() {
   wp_enqueue_media();
  
                  
        if(propertya_strings('property_opt_enable_map') == '1')
            {
                
                if(!empty(propertya_strings('property_opt_map_selection')) && propertya_strings('property_opt_map_selection') == "open_street")
                {
                    wp_enqueue_style( 'leaflet',  SB_PLUGIN_URL . 'libs/css/leaflet.css' );
                    wp_enqueue_script( 'leaflet',  SB_PLUGIN_URL . 'libs/js/leaflet.js', false, false, true );
                    wp_enqueue_script( 'leaflet-search',  SB_PLUGIN_URL . 'libs/js/leaflet-search.js', false, false, true );
                }
                if(!empty(propertya_strings('property_opt_map_selection')) && propertya_strings('property_opt_map_selection') == "google_map")
                {
                    if(propertya_strings('property_opt_gmap_api_key') !='')
                    {
                          wp_enqueue_script( "google-map", "//maps.googleapis.com/maps/api/js?v=3&libraries=places&key=".propertya_strings('property_opt_gmap_api_key')."", false, false, true );
                    }
                }
                if(!empty(propertya_strings('property_opt_map_selection')) && propertya_strings('property_opt_map_selection') == "mapbox")
                {
                    wp_enqueue_script( 'mapbox',  SB_PLUGIN_URL . 'libs/css/mapbox/mapbox-gl.js', false, false, true );
                    wp_enqueue_script( 'mapbox-geocoder',  SB_PLUGIN_URL . 'libs/css/mapbox/geocoder.min.js', false, false, true );
                    wp_enqueue_style( 'mapbox',  SB_PLUGIN_URL . 'libs/css/mapbox/mapbox-gl.css' );
                    wp_enqueue_style( 'mapbox-geocoder',  SB_PLUGIN_URL . 'libs/css/mapbox/geocoder.css' );
                }
            }
}
add_action( 'admin_enqueue_scripts', 'enqueue_select2' );
add_action( "wp_enqueue_scripts", "propertya_scripts" );
function propertya_scripts()
{

    /* Enqueue scripts. */
    wp_enqueue_script( "popper", trailingslashit( get_template_directory_uri () ) . "libs/js/popper.min.js", false, false, true );
    if(is_rtl())
    {
        wp_enqueue_script( "bootstrap", trailingslashit( get_template_directory_uri () ) . "libs/js/rtl/bootstrap.min.js", false, false, true );
    }
    else
    {
        wp_enqueue_script( "bootstrap", trailingslashit( get_template_directory_uri () ) . "libs/js/bootstrap.min.js", false, false, true );
    }
    wp_enqueue_script( "sb-menu", trailingslashit( get_template_directory_uri () ) . "libs/js/sbmenu.js", false, false, true );
    wp_enqueue_script( "validate", trailingslashit( get_template_directory_uri () ) . "libs/js/jquery.validate.min.js", false, false, true );
    wp_enqueue_script( "plugins", trailingslashit( get_template_directory_uri () ) . "libs/js/plugins.js", false, false, true );
    //for admin panels
    if(is_singular( 'property' ) || is_page_template('page-dashboard.php')&& isset($_GET['page-type']) && $_GET['page-type'] == 'submit-property')
    {
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script( "propertya-submission", trailingslashit( get_template_directory_uri () )  . "libs/js/submission/submission.js", array("jquery"), false, true );
    }
    if(is_page_template('page-dashboard.php') && isset($_GET['page-type']) && $_GET['page-type'] == 'my-profile' || isset($_GET['page-type']) && $_GET['page-type'] == 'submit-property')
    {
        //if maps are enabled.
        if(in_array('propertya-framework/index.php', apply_filters('active_plugins', get_option('active_plugins'))))
        {
            if(propertya_strings('property_opt_enable_map') == '1')
            {
                if(!empty(propertya_strings('property_opt_map_selection')) && propertya_strings('property_opt_map_selection') == "open_street")
                {
                    wp_enqueue_style( 'leaflet',  SB_PLUGIN_URL . 'libs/css/leaflet.css' );
                    wp_enqueue_script( 'leaflet',  SB_PLUGIN_URL . 'libs/js/leaflet.js', false, false, true );
                    wp_enqueue_script( 'leaflet-search',  SB_PLUGIN_URL . 'libs/js/leaflet-search.js', false, false, true );
                }
                if(!empty(propertya_strings('property_opt_map_selection')) && propertya_strings('property_opt_map_selection') == "google_map")
                {
                    if(propertya_strings('property_opt_gmap_api_key') !='')
                    {
                          wp_enqueue_script( "google-map", "//maps.googleapis.com/maps/api/js?v=3&libraries=places&key=".propertya_strings('property_opt_gmap_api_key')."", false, false, true );
                    }
                }
                if(!empty(propertya_strings('property_opt_map_selection')) && propertya_strings('property_opt_map_selection') == "mapbox")
                {
                    wp_enqueue_script( 'mapbox',  SB_PLUGIN_URL . 'libs/css/mapbox/mapbox-gl.js', false, false, true );
                    wp_enqueue_script( 'mapbox-geocoder',  SB_PLUGIN_URL . 'libs/css/mapbox/geocoder.min.js', false, false, true );
                    wp_enqueue_style( 'mapbox',  SB_PLUGIN_URL . 'libs/css/mapbox/mapbox-gl.css' );
                    wp_enqueue_style( 'mapbox-geocoder',  SB_PLUGIN_URL . 'libs/css/mapbox/geocoder.css' );
                }
            }
        }
    }
    if(is_page_template('page-signup.php') || is_page_template('page-signin.php'))
    {
        wp_enqueue_script("hello",trailingslashit(get_template_directory_uri())."libs/js/hello.js", array("jquery"), false, true);
    }
    if(is_singular('property') && get_post_type(get_the_ID()) == 'property')
    {
        if(propertya_strings('property_opt_enable_map') == '1')
        {
            if(!empty(propertya_strings('property_opt_map_selection')) && propertya_strings('property_opt_map_selection') == "open_street")
            {
                wp_enqueue_style( 'leaflet',  SB_PLUGIN_URL . 'libs/css/leaflet.css' );
                wp_enqueue_script( 'leaflet',  SB_PLUGIN_URL . 'libs/js/leaflet.js', false, false, true );
                wp_enqueue_script( 'leaflet-search',  SB_PLUGIN_URL . 'libs/js/leaflet-search.js', false, false, true );
            }
            if(!empty(propertya_strings('property_opt_map_selection')) && propertya_strings('property_opt_map_selection') == "google_map")
            {
                if(propertya_strings('property_opt_gmap_api_key') !='')
                {
                      wp_enqueue_script( "google-map", "//maps.googleapis.com/maps/api/js?v=3&libraries=places&key=".propertya_strings('property_opt_gmap_api_key')."", false, false, true );
                }
            }
            if(!empty(propertya_strings('property_opt_map_selection')) && propertya_strings('property_opt_map_selection') == "mapbox")
            {
                wp_enqueue_script( 'mapbox',  SB_PLUGIN_URL . 'libs/css/mapbox/mapbox-gl.js', false, false, true );
                wp_enqueue_script( 'mapbox-geocoder',  SB_PLUGIN_URL . 'libs/css/mapbox/geocoder.min.js', false, false, true );
                wp_enqueue_style( 'mapbox',  SB_PLUGIN_URL . 'libs/css/mapbox/mapbox-gl.css' );
                wp_enqueue_style( 'mapbox-geocoder',  SB_PLUGIN_URL . 'libs/css/mapbox/geocoder.css' );
            }
        }
        wp_enqueue_style( "ntlTelInput", trailingslashit( get_template_directory_uri () )  . "libs/css/plugins/intlTelInput.min.css" );
        wp_enqueue_script("intlTelInput",trailingslashit(get_template_directory_uri())."libs/js/plugins/intlTelInput.min.js", array("jquery"), false, true);
        wp_enqueue_style( "flexslider", trailingslashit( get_template_directory_uri () )  . "libs/css/plugins/flexslider.css" );
        if(is_rtl())
        {
            wp_enqueue_style( "flexslider-rtl", trailingslashit( get_template_directory_uri () )  . "libs/css/plugins/flexslider-rtl.css" );
        }
        wp_enqueue_style( "fancybox", trailingslashit( get_template_directory_uri () )  . "libs/css/plugins/jquery.fancybox.min.css" );
        //changed
        wp_enqueue_script("flexslider2",trailingslashit(get_template_directory_uri())."libs/js/plugins/flexslider.js", array("jquery"), false, true);
        wp_enqueue_script("jquery-charts",trailingslashit(get_template_directory_uri())."libs/js/plugins/chart.min.js", array("jquery"), false, true);
        wp_enqueue_script("propertya-stats",trailingslashit(get_template_directory_uri())."libs/js/stats.js", array("jquery"), false, true);
        wp_enqueue_script("jquery-fancybox",trailingslashit(get_template_directory_uri())."libs/js/plugins/jquery.fancybox.min.js", array("jquery"), false, true);
    }
    if(is_singular('property-agency') && get_post_type(get_the_ID()) == 'property-agency' || is_singular('property-agents') && get_post_type(get_the_ID()) == 'property-agents' || is_singular('property-buyers') && get_post_type(get_the_ID()) == 'property-buyers' || isset($_GET['page-type']) && $_GET['page-type'] == 'dashboard' || is_page_template('page-dashboard.php') && empty($_GET['page-type']))
    {
        wp_enqueue_script("jquery-charts",trailingslashit(get_template_directory_uri())."libs/js/plugins/chart.min.js", array("jquery"), false, true);
        wp_enqueue_script("propertya-stats",trailingslashit(get_template_directory_uri())."libs/js/stats.js", array("jquery"), false, true);
        //if maps are enabled.
        if(in_array('propertya-framework/index.php', apply_filters('active_plugins', get_option('active_plugins'))))
        {
            if(propertya_strings('property_opt_enable_map') == '1')
            {
                if(!empty(propertya_strings('property_opt_map_selection')) && propertya_strings('property_opt_map_selection') == "open_street")
                {
                    wp_enqueue_style( 'leaflet',  SB_PLUGIN_URL . 'libs/css/leaflet.css' );
                    wp_enqueue_script( 'leaflet',  SB_PLUGIN_URL . 'libs/js/leaflet.js', false, false, true );
                    wp_enqueue_script( 'leaflet-search',  SB_PLUGIN_URL . 'libs/js/leaflet-search.js', false, false, true );
                }
                if(!empty(propertya_strings('property_opt_map_selection')) && propertya_strings('property_opt_map_selection') == "google_map")
                {
                    if(propertya_strings('property_opt_gmap_api_key') !='')
                    {
                         wp_enqueue_script( "google-map", "//maps.googleapis.com/maps/api/js?v=3&libraries=places&key=".propertya_strings('property_opt_gmap_api_key')."", false, false, true );
                    }
                }
                if(!empty(propertya_strings('property_opt_map_selection')) && propertya_strings('property_opt_map_selection') == "mapbox")
                {
                    wp_enqueue_script( 'mapbox',  SB_PLUGIN_URL . 'libs/css/mapbox/mapbox-gl.js', false, false, true );
                    wp_enqueue_script( 'mapbox-geocoder',  SB_PLUGIN_URL . 'libs/css/mapbox/geocoder.min.js', false, false, true );
                    wp_enqueue_style( 'mapbox',  SB_PLUGIN_URL . 'libs/css/mapbox/mapbox-gl.css' );
                    wp_enqueue_style( 'mapbox-geocoder',  SB_PLUGIN_URL . 'libs/css/mapbox/geocoder.css' );
                }
            }
        }

    }
    if( is_singular() && comments_open() && ( get_option( 'thread_comments' ) == 1) )
    {
        wp_enqueue_script("comment-reply", "", true);
    }
    wp_enqueue_script("isotope",trailingslashit(get_template_directory_uri())."libs/js/plugins/isotope.js", false, false, true);
    wp_enqueue_script("masonry");

    wp_enqueue_script( "chart-loader", trailingslashit(get_template_directory_uri())."libs/js/plugins/chart-loader.js", array("jquery"), false, true );
    wp_enqueue_script("select2-prop",trailingslashit(get_template_directory_uri())."libs/js/plugins/select2.js", array("jquery"), false, true);

    wp_enqueue_script( "propertya-custom", trailingslashit( get_template_directory_uri () )  . "libs/js/theme-custom.js", array("jquery"), false, true );
    if(is_page_template('page-agencies-search.php'))
    {
        wp_enqueue_script("propertya-agency",trailingslashit(get_template_directory_uri())."libs/js/search/agency.js", false, false, true);
    }
    if(is_page_template('page-agents-search.php'))
    {
        wp_enqueue_script("propertya-agent",trailingslashit(get_template_directory_uri())."libs/js/search/agent.js", false, false, true);
    }
    if(is_page_template('page-property-search.php') || is_tax(array('property_location', 'property_type', 'property_status', 'property_label')) || is_front_page())
    {
        if(!empty(propertya_strings('prop_listing_search_layout')) && propertya_strings('prop_listing_search_layout') == 'map')
        {
            //if maps are enabled.
            if(in_array('propertya-framework/index.php', apply_filters('active_plugins', get_option('active_plugins'))))
            {
                if(propertya_strings('property_opt_enable_map') == '1')
                {
                    if(!empty(propertya_strings('property_opt_map_selection')) && propertya_strings('property_opt_map_selection') == "open_street")
                    {
                        wp_enqueue_style( 'leaflet',  SB_PLUGIN_URL . 'libs/css/leaflet.css' );
                        wp_enqueue_script( 'leaflet',  SB_PLUGIN_URL . 'libs/js/leaflet.js', false, false, true );
                        wp_enqueue_script( 'leaflet-search',  SB_PLUGIN_URL . 'libs/js/leaflet-search.js', false, false, true );
                        wp_enqueue_script( 'leaflet-markercluster',  SB_PLUGIN_URL . 'libs/js/leaflet.markercluster.js', false, false, true );

                    }
                    if(!empty(propertya_strings('property_opt_map_selection')) && propertya_strings('property_opt_map_selection') == "google_map")
                    {
                        if(propertya_strings('property_opt_gmap_api_key') !='')
                        {
                             wp_enqueue_script( "google-map", "//maps.googleapis.com/maps/api/js?v=3&libraries=places&key=".propertya_strings('property_opt_gmap_api_key')."", false, false, true );
                        }
                    }
                    if(!empty(propertya_strings('property_opt_map_selection')) && propertya_strings('property_opt_map_selection') == "mapbox")
                    {
                        wp_enqueue_script( 'mapbox',  SB_PLUGIN_URL . 'libs/css/mapbox/mapbox-gl.js', false, false, true );
                        wp_enqueue_script( 'mapbox-geocoder',  SB_PLUGIN_URL . 'libs/css/mapbox/geocoder.min.js', false, false, true );
                        wp_enqueue_style( 'mapbox',  SB_PLUGIN_URL . 'libs/css/mapbox/mapbox-gl.css' );
                        wp_enqueue_style( 'mapbox-geocoder',  SB_PLUGIN_URL . 'libs/css/mapbox/geocoder.css' );
                    }
                }
            }
            wp_enqueue_script("propertya-search",trailingslashit(get_template_directory_uri())."libs/js/search/maplistings.js", false, false, true);
        }
        else
        {
            /*if(!empty(propertya_strings('prop_listing_search_layout')) && propertya_strings('prop_listing_search_layout') == 'modern')
            {
               wp_enqueue_script("perfectscrollbar",trailingslashit(get_template_directory_uri())."libs/js/plugins/perfectscrollbar.js", false, false, true);
            }*/
            //wp_enqueue_script("propertya-search",trailingslashit(get_template_directory_uri())."libs/js/search/listings.js", false, false, true);
        }
    }
    if(!is_page_template('page-agencies-search.php') && !is_page_template('page-agents-search.php'))
    {
        wp_enqueue_script("perfectscrollbar",trailingslashit(get_template_directory_uri())."libs/js/plugins/perfectscrollbar.js", false, false, true);
        wp_enqueue_script("propertya-search",trailingslashit(get_template_directory_uri())."libs/js/search/listings.js", false, false, true);
    }



  /* ------------------------------------------------ */
    /* Enqueue Google Fonts. */
    /* ------------------------------------------------ */

    if (!function_exists('propertya_google_fonts'))
    {
        function propertya_google_fonts()
        {
            $fonts_url = '';
            $source_sans = _x('on', 'Lato font: on or off', 'propertya');
            if ('off' !== $source_sans) {
                $font_families = array();
                if ('off' !== $source_sans) {
                    if(is_rtl())
                    {
                        $font_families[] = 'Tajawal:400,500,700';
                    }
                    else
                    {
                        $font_families[] = 'Lato:400,400i,700,700i,900';
                    }
                }
                $query_args = array(
                    'family' => urlencode(implode('%7C', $font_families)),
                    'subset' => urlencode('latin,latin-ext'),
                    'display' => urlencode('swap'),
                );
                $fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
            }
            return urldecode($fonts_url);
        }
    }
    /* Load the stylesheets. */
    wp_enqueue_style( "propertya-style", get_stylesheet_uri() );

    wp_enqueue_style( 'google-fonts', propertya_google_fonts(), array(), true);
    if(is_rtl())
    {
        wp_enqueue_style( "bootstrap", trailingslashit( get_template_directory_uri () )  . "libs/css/rtl/bootstrap-rtl.css" );
    }
    else
    {
        wp_enqueue_style( "bootstrap", trailingslashit( get_template_directory_uri () )  . "libs/css/bootstrap.min.css" );
    }
    wp_enqueue_style( "propertya-icons", trailingslashit( get_template_directory_uri () )  . "libs/css/theme-fonts.css" );
    wp_enqueue_style( "plugins", trailingslashit( get_template_directory_uri () )  . "libs/css/plugins.css" );
    //for admin panels
    if(is_page_template('page-dashboard.php'))
    {
        wp_enqueue_style( "propertya-dashboard", trailingslashit( get_template_directory_uri () )  . "libs/css/dashboard/dashboard.css" );
    }

    wp_enqueue_style( "select2-prop", trailingslashit( get_template_directory_uri () )  . "libs/css/plugins/select2.css" );
    wp_enqueue_style( "propertya-main", trailingslashit( get_template_directory_uri () )  . "libs/css/theme.css" );
    if(is_rtl())
    {
        wp_enqueue_style( "propertya-main-rtl", trailingslashit( get_template_directory_uri () )  . "libs/css/rtl/theme-rtl.css" );
        wp_enqueue_style( "propertya-responsive", trailingslashit( get_template_directory_uri () )  . "libs/css/rtl/responsive.css" );
    }
    else
    {
        wp_enqueue_style( "propertya-responsive", trailingslashit( get_template_directory_uri () )  . "libs/css/responsive.css" );
    }
}


add_filter('pre_post_title', 'propertya_mask_empty');
add_filter('pre_post_content', 'propertya_mask_empty');
function propertya_mask_empty($value)
{
    if ( empty($value) ) {
        return ' ';
    }
    return $value;
}

add_filter('wp_insert_post_data', 'propertya_unmask_empty');
function propertya_unmask_empty($data)
{
    if ( ' ' == $data['post_title'] ) {
        $data['post_title'] = '';
    }
    return $data;
}
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))))
{
    function propertya_add_woo_bootstrap_input_classes( $args, $key, $value = null ) {
        // Start field type switch case
        switch ( $args['type'] ) {

            case "select" :  /* Targets all select input type elements, except the country and state select input types */
                $args['class'][] = 'form-group'; // Add a class to the field's html element wrapper - woocommerce input types (fields) are often wrapped within a <p></p> tag
                $args['input_class'] = array('form-control', 'input-lg'); // Add a class to the form input itself
                //$args['custom_attributes']['data-plugin'] = 'select2';
                $args['label_class'] = array('control-label');
                $args['custom_attributes'] = array( 'data-plugin' => 'select2', 'data-allow-clear' => 'true', 'aria-hidden' => 'true',  ); // Add custom data attributes to the form input itself
                break;

            case 'country' : /* By default WooCommerce will populate a select with the country names - $args defined for this specific input type targets only the country select element */
                $args['class'][] = 'form-group single-country';
                $args['label_class'] = array('control-label');
                break;

            case "state" : /* By default WooCommerce will populate a select with state names - $args defined for this specific input type targets only the country select element */
                $args['class'][] = 'form-group'; // Add class to the field's html element wrapper
                $args['input_class'] = array('form-control', 'input-lg'); // add class to the form input itself
                //$args['custom_attributes']['data-plugin'] = 'select2';
                $args['label_class'] = array('control-label');
                $args['custom_attributes'] = array( 'data-plugin' => 'select2', 'data-allow-clear' => 'true', 'aria-hidden' => 'true',  );
                break;
            case "password" :
            case "text" :
            case "email" :
            case "tel" :
            case "number" :
                $args['class'][] = 'form-group';
                //$args['input_class'][] = 'form-control input-lg'; // will return an array of classes, the same as bellow
                $args['input_class'] = array('form-control', 'input-lg');
                $args['label_class'] = array('control-label');
                break;
            case 'textarea' :
                $args['input_class'] = array('form-control', 'input-lg');
                $args['label_class'] = array('control-label');
                break;

            case 'checkbox' :
                break;

            case 'radio' :
                break;

            default :
                $args['class'][] = 'form-group';
                $args['input_class'] = array('form-control', 'input-lg');
                $args['label_class'] = array('control-label');
                break;
        }

        return $args;
    }
    add_filter('woocommerce_form_field_args','propertya_add_woo_bootstrap_input_classes',10,3);
    add_filter( 'woocommerce_single_product_carousel_options', 'propertya_woo_flexslider_options' );
    function propertya_woo_flexslider_options( $options ) {
        $options['directionNav'] = true;
        return $options;
    }
}
function general_admin_notice(){
    global $pagenow;
    if ( $pagenow == 'edit.php') {
         echo '<div class="notice notice-warning is-dismissible">
             <p>This notice appears on the settings page.</p>
             <button id="btnSubmit" >Update Listing</button>
    
         </div>';
    }
}
add_action('admin_notices', 'general_admin_notice');

function custom_footer_code() {
    ?>
    <button class="scroll-top scroll-to-target" data-target="html"><span class="fas fa-angle-up"></span></button>
    <?php get_template_part( 'template-parts/authorization/password', 'reset' ); ?>
    <?php get_template_part( 'template-parts/dashboard/role/assign', 'role' ); ?>
    <?php get_template_part( 'template-parts/compare/compare', 'listings' ); ?>

    <?php
    $rtl = 0;
    if ( is_rtl() ) {
        $rtl = 1;
    }
    ?>
    <input type="hidden" name="is_rtl" value="<?php echo esc_attr( $rtl ); ?>">
    <?php
}

add_action( 'wp_footer', 'custom_footer_code' );