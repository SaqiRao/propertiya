<?php
if ( ! class_exists( 'Redux' ) ) {
    return;
}
// This is your option name where all the Redux data is stored.
$opt_name = "propertya_options";
$sample_patterns = $sampleHTML = '';
$theme = wp_get_theme(); // For use with some settings. Not necessary.
$currecnies = array();
if(in_array('propertya-framework/index.php', apply_filters('active_plugins', get_option('active_plugins'))))
{
    $currecnies = propertya_framework_get_currency();
}

$args = array(
    // TYPICAL -> Change these values as you need/desire
    'opt_name'             => $opt_name,
    'display_name'         => $theme->get('Name'),
    'display_version'      => $theme->get('Version'),
    'menu_type'            => 'submenu',
    'allow_sub_menu'       => true,
    'menu_title'           => esc_html__( 'Propertya Options', 'propertya' ),
    'page_title'           => esc_html__( 'Propertya Options', 'propertya' ),
    'google_api_key'       => '',
    'google_update_weekly' => false,
    'async_typography'     => true,
    'admin_bar'            => true,
    'admin_bar_icon'       => 'dashicons-portfolio',
    'admin_bar_priority'   => 50,
    'global_variable'      => '',
    'dev_mode'             => false,
    'update_notice'        => false,
    'customizer'           => false,
    // Enable basic customizer support
    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field
    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
    'page_parent'          => 'themes.php',
    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    'page_permissions'     => 'manage_options',
    // Permissions needed to access the options panel.
    'menu_icon'            => '',
    // Specify a custom URL to an icon
    'last_tab'             => '',
    // Force your panel to always open to a specific tab (by id)
    'page_icon'            => 'icon-themes',
    // Icon displayed in the admin panel next to your menu_title
    'page_slug'            => '',
    // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
    'save_defaults'        => true,
    // On load save the defaults to DB before user clicks save or not
    'default_show'         => false,
    // If true, shows the default value next to each field that is not the default value.
    'default_mark'         => '',
    // What to print by the field's title if the value shown is default. Suggested: *
    'show_import_export'   => true,
    // Shows the Import/Export panel when not used as a field.

    // CAREFUL -> These options are for advanced use only
    'transient_time'       => 600 * MINUTE_IN_SECONDS,
    'output'               => true,
    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
    'output_tag'           => true,
    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
    'database'             => '',
    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
    'use_cdn'              => true,
    // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

    // HINTS
    'hints'                => array(
        'icon'          => 'el el-question-sign',
        'icon_position' => 'right',
        'icon_color'    => 'lightgray',
        'icon_size'     => 'normal',
        'tip_style'     => array(
            'color'   => 'red',
            'shadow'  => true,
            'rounded' => false,
            'style'   => '',
        ),
        'tip_position'  => array(
            'my' => 'top left',
            'at' => 'bottom right',
        ),
        'tip_effect'    => array(
            'show' => array(
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'mouseover',
            ),
            'hide' => array(
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'click mouseleave',
            ),
        ),
    )
);
Redux::setArgs( $opt_name, $args );
/* Load Theme Functions */
Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'Theme Settings', 'propertya' ),
    'id'               => 'theme-settings',
    'desc'             => esc_html__( 'These are really basic fields to setup theme!', 'propertya' ),
    'customizer_width' => '400px',
    'icon'             => 'el el-wrench'
) );

Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'General Settings', 'propertya' ),
    'id'               => 'general-settings',
    'subsection'       => true,
    'customizer_width' => '450px',
    'desc'             =>'',
    'fields'           => array(
        array(
            'id'       => 'prop_site_spinner',
            'type'     => 'switch',
            'title'    => esc_html__( 'Show Site Preloader', 'propertya' ),
            'default'  => true,
            'desc'     => esc_html__( 'Trun on or off site loader.', 'propertya' ),
        ),

        array(
            'id' => 'prop_theme_clr',
            'type' => 'color',
            'title' => esc_html__('Theme Main (Primary) Color', 'propertya'),
            'subtitle' => esc_html__('Theme  main color (default: #2296f9) hover color as well.', 'propertya'),
            'transparent' => false,
            'default' => '#2296f9',
            'validate' => 'color',
        ),
        array(
            'id' => 'prop_btn_plate',
            'type' => 'link_color',
            'title' => esc_html__('Theme Buttons Colors', 'propertya'),
            'default' => array(
                'regular' => '#2296f9',
                'hover' => '#f71735',
                'active' => '#f71735',
            )
        ),
        array(
            'id'       => 'prop_demo',
            'type'     => 'switch',
            'title'    => esc_html__( 'Demo Mode', 'propertya' ),
            'default'  => false,
            'desc'     => esc_html__( "Only for demo purpose don't enable on your site.", 'propertya' ),
        ),
        array(
            'id'       => 'prop_dashboard',
            'type'     => 'switch',
            'title'    => esc_html__( 'Dashboard Menu', 'propertya' ),
            'default'  => false,
            'desc'     => esc_html__( "Only for demo purpose don't enable on your site.", 'propertya' ),
        ),



    )
) );

/* ------------------ Header  ----------------------- */
Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'Header Settings', 'propertya' ),
    'id'               => 'real-header',
    'subsection'       => true,
    'customizer_width' => '450px',
    'desc'             =>'',
    'icon' => 'el el-lock',
    'fields'     => array(

        array(
            'id'       => 'prop_selected_header',
            'type'     => 'image_select',
            'title'    => esc_html__( 'Header Layout', 'propertya' ),
            'desc'     => esc_html__( 'Select Header Layout you want to show.', 'propertya' ),
            'options'  => array(
                '1' => array(
                    'alt' => esc_html__('Header Layout 1','propertya'),
                    'img' => esc_url(trailingslashit( get_template_directory_uri () )) . 'libs/images/options/header1.png'
                ),
                '2' => array(
                    'alt' => esc_html__('Header Layout 2','propertya'),
                    'img' => esc_url(trailingslashit( get_template_directory_uri () )) . 'libs/images/options/header2.png'
                ),
            ),
            'default'  => '1'
        ),
        array(
            'id'       => 'prop_main_logo',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__( 'Logo', 'propertya' ),
            'compiler' => 'true',
            'desc'     => esc_html__( 'Upload main logo of your website.', 'propertya' ),
            'default'  => array( 'url' => trailingslashit( get_template_directory_uri () ) . 'libs/images/logo.svg' ),
        ),

        array(
            'id' => 'prop_top_pages',
            'type' => 'select',
            'multi'    => true,
            'data' => 'pages',
            'title' => esc_html__('Topbar Pages Link', 'propertya'),
            'default' => '',
            'sortable' => true,
        ),
        array(
            'id'       => 'prop_trans_logo',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__( 'Transparent Logo', 'propertya' ),
            'compiler' => 'true',
            'desc'     => esc_html__( 'Upload transparent logo of your website.', 'propertya' ),
            'default'  => array( 'url' => trailingslashit( get_template_directory_uri () ) . 'libs/images/logo-white.svg' ),
        ),

        array(
            'id'       => 'prop_mobile_logo',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__( 'Small Logo For Mobile Devices', 'propertya' ),
            'compiler' => 'true',
            'desc'     => esc_html__( 'Logo that shows at mobile resolution.', 'propertya' ),
            'default'  => array( 'url' => trailingslashit( get_template_directory_uri () ) . 'libs/images/mobile-logo.png' ),
        ),


        array(
            'id'       => 'prop_other_btn',
            'type'     => 'switch',
            'title'    => esc_html__( 'Show Search Button', 'propertya' ),
            'default'  => true,
        ),
        array(
            'id' => 'prop_anotherbtn_txt',
            'type' => 'text',
            'title' => esc_html__('Button Text', 'propertya'),
            'default' => esc_html__( 'Search Properties', 'propertya' ),
            'required' => array('prop_other_btn', '=', true),
        ),
        array(
            'id' => 'prop_anotherbtn_page',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('Select Page Link', 'propertya'),
            'desc' => esc_html__('Select page you want to show.', 'propertya'),
            'default' => '#',
            'required' => array('prop_other_btn', '=', true),
        ),
        array(
            'id'       => 'prop_add_btn',
            'type'     => 'switch',
            'title'    => esc_html__( 'Show Add Property Button', 'propertya' ),
            'default'  => false,
        ),
        array(
            'id' => 'prop_addbtn_txt',
            'type' => 'text',
            'title' => esc_html__('Button Text', 'propertya'),
            'default' => esc_html__( 'Add property', 'propertya' ),
            'required' => array('prop_add_btn', '=', true),
        ),

        array(
            'id' => 'prop_callus_txt',
            'type' => 'text',
            'title' => esc_html__('Button Text', 'propertya'),
            'default' => esc_html__( 'Call us', 'propertya' ),
            'required' => array('prop_selected_header', '=', '2'),
        ),
        array(
            'id' => 'prop_contact_no_txt',
            'type' => 'text',
            'title' => esc_html__('Contact Number/Anything', 'propertya'),
            'default' => esc_html__( '+92-123-4567', 'propertya' ),
            'required' => array('prop_selected_header', '=', '2'),
        ),
        array(
            'id'       => 'prop_contact_icon',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__( 'Icon', 'propertya' ),
            'compiler' => 'true',
            'desc'     => esc_html__( 'Icon for text. Recommended size 35x35', 'propertya' ),
            'default'  => array( 'url' => trailingslashit( get_template_directory_uri () ) . 'libs/images/phoneold.png' ),
            'required' => array('prop_selected_header', '=', '2'),
        ),


    )
) );

/* ------------------ Topbar Settings  ----------------------- */
Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'Topbar Settings', 'propertya' ),
    'id'               => 'real-topbar',
    'subsection'       => true,
    'customizer_width' => '450px',
    'desc'             =>'',
    'icon' => 'el el-lock',
    'fields'     => array(

        array(
            'id'       => 'prop_show_topbar',
            'type'     => 'switch',
            'title'    => esc_html__( 'Show Topbar', 'propertya' ),
            'default'  => true,
        ),

        array(
            'id'       => 'prop_top_background',
            'type'     => 'color',
            'title'    => esc_html__('Topbar Background Color', 'propertya'),
            'default'  => '#1B232F',
            'validate' => 'color',
            'transparent' => false,
            'required' => array('prop_show_topbar', '=', '1'),
        ),
        array(
            'id'       => 'prop_top_nav_clr',
            'type'     => 'color',
            'title'    => __('Topbar Menu Color', 'propertya'),
            'default'  => '#FFFFFF',
            'validate' => 'color',
            'transparent' => false,
            'required' => array('prop_show_topbar', '=', '1'),
        ),
        array(
            'id'       => 'prop_topbar_style',
            'type'     => 'button_set',
            'title'    => esc_html__( 'Topbar Layout', 'propertya' ),
            'desc'     => esc_html__( 'Select Topbar Layout you want to show.', 'propertya' ),
            'options' => array(
                '3' => 'Style 3',
            ),
            'default'  => '3',
            'required' => array('prop_show_topbar', '=', true),
        ),
        array(
            'id' => 'prop_top_email',
            'type' => 'text',
            'title' => esc_html__('Email Address', 'propertya'),
            'default' => esc_html__( 'xyz@email.com', 'propertya' ),
            'required' => array(
                array('prop_show_topbar','equals','1'),
                array('prop_topbar_style','!=','2'),
                array('prop_topbar_style','!=','shop')
            ),
        ),
        array(
            'id' => 'prop_top_contactno',
            'type' => 'text',
            'title' => esc_html__('Contact Number', 'propertya'),
            'default' => esc_html__( '+55 45 2458651', 'propertya' ),
            'required' => array(
                array('prop_show_topbar','equals','1'),
                array('prop_topbar_style','!=','2'),
                array('prop_topbar_style','!=','shop')
            ),
        ),
        array(
            'id' => 'prop_top_hours',
            'type' => 'text',
            'title' => esc_html__('Working Hours', 'propertya'),
            'default' => esc_html__( 'Monday - Saturday 8AM - 7PM', 'propertya' ),
            'required' => array(
                array('prop_show_topbar','equals','1'),
                array('prop_topbar_style','!=','2'),
                array('prop_topbar_style','!=','shop')
            ),
        ),
        array(
            'id' => 'prop_top_pages',
            'type' => 'select',
            'multi'    => true,
            'data' => 'pages',
            'title' => esc_html__('Topbar Pages Link', 'propertya'),
            'default' => '',
            'sortable' => true,
            'required' => array(
                array('prop_show_topbar','equals','1'),
            ),
        ),

    )

));

/* ------------------ Required Form Fields ----------------------- */
Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'Breadcrumbs', 'propertya' ),
    'id'               => 'prop_breads',
    'subsection'       => true,
    'customizer_width' => '450px',
    'icon' => 'el el-tasks',
    'fields'     => array(
        array(
            'id'       => 'prop_selected_bread',
            'type'     => 'image_select',
            'title'    => esc_html__( 'Breadcrumb Type', 'propertya' ),
            'desc'     => esc_html__( 'Select breadcrumb Layout you want to show.', 'propertya' ),
            'options'  => array(
                'one' => array(
                    'alt' => esc_html__('Minimal','propertya'),
                    'img' => esc_url(trailingslashit( get_template_directory_uri () )) . 'libs/images/options/minimal-bread.png'
                ),
                'two' => array(
                    'alt' => esc_html__('Classic','propertya'),
                    'img' => esc_url(trailingslashit( get_template_directory_uri () )) . 'libs/images/options/classic-bread.png'
                ),
            ),
            'default'  => 'two'
        ),
        array(
            'id'       => 'brop_breadcrumb_img',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__( 'Breadcrumb Background Image', 'propertya' ),
            'compiler' => 'true',
            'default'  => array( 'url' => trailingslashit( get_template_directory_uri () ) . 'libs/images/bread2.jpg' ),
            'required' => array('prop_selected_bread', '=', 'two'),
        ),
    )
) );

/* ------------------ Dashboard Settings ----------------------- */
Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'Dashboard Settings', 'propertya' ),
    'id'               => 'dashboard-settings',
    'desc'             => esc_html__( 'Here you can setup the dashboard settings', 'propertya' ),
    'customizer_width' => '400px',
    'icon'             => 'el el-user',
));


/* ------------------ Required Form Fields ----------------------- */
Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'Agency Profile Fields', 'propertya' ),
    'id'               => 'agency_required_fields',
    'subsection'       => true,
    'customizer_width' => '450px',
    'desc'             =>'',

    'fields'     => array(
        array(
            'id'       => 'prop_agency_fields',
            'type'     => 'checkbox',
            'title'    => esc_html__( 'Form Required Fields', 'propertya' ),
            'subtitle' => esc_html__( 'Select the Mandatory Fields for agency.', 'propertya' ),
            'desc'     => esc_html__( 'Select the Mandatory Fields for agency.', 'propertya' ),
            //'options'  => propertya_form_fields(),
            'options'  => array
            (
                'agency_mob' 	=> esc_html__('Mobile Number','propertya'),
                'whats_app' => esc_html__('WhatsApp Number','propertya'),
                'off_no' => esc_html__('Office Number','propertya'),
                'fax_no' => esc_html__('Fax Number','propertya'),
                'agency_lic' 	=> esc_html__('Agency License','propertya'),
                'tax_no' => esc_html__('Tax Number','propertya'),
                'web_url' => esc_html__('Website Url','propertya'),
                'agency_loc' => esc_html__('Agency Location','propertya'),
                'about_agency' => esc_html__('About Agency','propertya'),
                'agency_fb' => esc_html__('Facebook URL','propertya'),
                'agency_tw' => esc_html__('Twitter URL','propertya'),
                'agency_link' => esc_html__('LinkedIn URL','propertya'),
                'agency_in' => esc_html__('Instagram URL','propertya'),
                'agency_pin' => esc_html__('Pinterest URL','propertya'),
                'agency_addr' => esc_html__('Address','propertya'),
            ),
            'default'  => array(
                'agency_mob' 	=> '1',
                'whats_app' => '1',
                'off_no' => '1',
                'fax_no' => '0',
                'agency_lic' 	=> '0',
                'tax_no' => '0',
                'web_url' => '0',
                'agency_loc' => '1',
                'about_agency' => '1',
                'agency_fb' => '0',
                'agency_tw' => '0',
                'agency_link' => '0',
                'agency_in' => '0',
                'agency_pin' => '0',
                'agency_addr' => '1',
            )
        ),
    )
) );

/* ------------------ Agents Required Form Fields ----------------------- */
Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'Agent Profile Fields', 'propertya' ),
    'id'               => 'agent_required_fields',
    'subsection'       => true,
    'customizer_width' => '450px',
    'desc'             =>'',
    'fields'     => array(
        array(
            'id'       => 'prop_agent_fields',
            'type'     => 'checkbox',
            'title'    => esc_html__( 'Form Required Fields', 'propertya' ),
            'subtitle' => esc_html__( 'Select the Mandatory Fields for agent.', 'propertya' ),
            'desc'     => esc_html__( 'Select the Mandatory Fields for agent.', 'propertya' ),
            'options'  => array
            (
                'ag_mob' 	=> esc_html__('Mobile Number','propertya'),
                'ag_type' 	=> esc_html__('Agent Type','propertya'),
                'ag_loc' => esc_html__('Agency Location','propertya'),
                'whats_app' => esc_html__('WhatsApp Number','propertya'),
                'off_no' => esc_html__('Office Number','propertya'),
                'fax_no' => esc_html__('Fax Number','propertya'),
                'web_url' => esc_html__('Website Url','propertya'),
                'ag_hours' => esc_html__('Working Hours','propertya'),
                'ag_skype' => esc_html__('Skype','propertya'),
                'ag_pos' => esc_html__('Position','propertya'),
                'about_ag' => esc_html__('About Agent','propertya'),
                'ag_fb' => esc_html__('Facebook URL','propertya'),
                'ag_tw' => esc_html__('Twitter URL','propertya'),
                'ag_link' => esc_html__('LinkedIn URL','propertya'),
                'ag_in' => esc_html__('Instagram URL','propertya'),
                'ag_you' => esc_html__('Youtube URL','propertya'),
                'ag_pin' => esc_html__('Pinterest URL','propertya'),
                'ag_addr' => esc_html__('Address','propertya'),
            ),
            'default'  => array(
                'ag_mob' 	=> '1',
                'ag_type' 	=> '1',
                'ag_loc' => '1',
                'whats_app' => '1',
                'off_no' => '1',
                'fax_no' => '0',
                'web_url' => '0',
                'ag_hours' => '0',
                'ag_skype' => '0',
                'ag_pos' => '0',
                'about_ag' => '1',
                'ag_fb' => '0',
                'ag_tw' => '0',
                'ag_link' => '0',
                'ag_in' => '0',
                'ag_you' => '0',
                'ag_pin' => '0',
                'ag_addr' => '1',
            )
        ),
    )
));



/* ------------------ Buyer Required Form Fields ----------------------- */
Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'Buyer Profile Fields', 'propertya' ),
    'id'               => 'buyer_required_fields',
    'subsection'       => true,
    'customizer_width' => '450px',
    'desc'             =>'',
    'fields'     => array(
        array(
            'id'       => 'prop_buyer_fields',
            'type'     => 'checkbox',
            'title'    => esc_html__( 'Form Required Fields', 'propertya' ),
            'subtitle' => esc_html__( 'Select the Mandatory Fields for buyer.', 'propertya' ),
            'desc'     => esc_html__( 'Select the Mandatory Fields for buyer.', 'propertya' ),
            'options'  => array
            (
                'ag_mob' 	=> esc_html__('Mobile Number','propertya'),
                'whats_app' => esc_html__('WhatsApp Number','propertya'),
                'about_ag' => esc_html__('About Agent','propertya'),
                'ag_fb' => esc_html__('Facebook URL','propertya'),
                'ag_tw' => esc_html__('Twitter URL','propertya'),
                'ag_link' => esc_html__('LinkedIn URL','propertya'),
                'ag_in' => esc_html__('Instagram URL','propertya'),
                'ag_pin' => esc_html__('Pinterest URL','propertya'),
                'ag_addr' => esc_html__('Address','propertya'),
            ),
            'default'  => array(
                'ag_mob' 	=> '1',
                'whats_app' => '1',
                'about_ag' => '1',
                'ag_fb' => '0',
                'ag_tw' => '0',
                'ag_link' => '0',
                'ag_in' => '0',
                'ag_pin' => '0',
                'ag_addr' => '1',
            )
        ),
    )
));

Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Detail Page General Settings', "propertya" ),
    'id'         => 'prop_ag_details',
    'desc'       => '',
    'subsection' => true,
    'fields'     => array(

        array(
            'id' => 'p_menu_section',
            'type' => 'section',
            'title' => esc_html__('Menu Section Text', 'propertya'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ),

        array(
            'id' => 'prop_settings_detail_sections',
            'type' => 'text',
            'title' => esc_html__('Overview Menu', 'propertya'),'',
            'default' => esc_html__('Overview', 'propertya'),
        ),
        array(
            'id' => 'prop_settings_detail_menulistings',
            'type' => 'text',
            'title' => esc_html__('Listings Menu', 'propertya'),
            'default' => esc_html__('Listings', 'propertya'),
        ),
        array(
            'id' => 'prop_settings_detail_menuviews',
            'type' => 'text',
            'title' => esc_html__('Daily Views Menu', 'propertya'),
            'default' => esc_html__('Daily Views', 'propertya'),
        ),
        array(
            'id' => 'prop_settings_detail_menuagents',
            'type' => 'text',
            'title' => esc_html__('Agents Menu', 'propertya'),
            'default' => esc_html__('Agents', 'propertya'),
        ),
        array(
            'id' => 'prop_settings_detail_menureviews',
            'type' => 'text',
            'title' => esc_html__('Reviews Menu', 'propertya'),
            'default' => esc_html__('Reviews', 'propertya'),
        ),
        array(
            'id' => 'prop_settings_detail_reviews_menuwrite',
            'type' => 'text',
            'title' => esc_html__('Write a Review Menu', 'propertya'),
            'default' => esc_html__('Write a Review', 'propertya'),
        ),

        array(
            'id' => 'p_det_section',
            'type' => 'section',
            'title' => esc_html__('Sections Headings Text', 'propertya'),
            'indent' => true,
        ),

        array(
            'id' => 'prop_settings_detail_sections_detail',
            'type' => 'text',
            'title' => esc_html__('Overview Section', 'propertya'),'',
            'default' => esc_html__('Overview', 'propertya'),
        ),
        array(
            'id' => 'prop_settings_detail_listings',
            'type' => 'text',
            'title' => esc_html__('Listings Section', 'propertya'),
            'default' => esc_html__('Listings', 'propertya'),
        ),
        array(
            'id' => 'prop_settings_detail_uviews',
            'type' => 'text',
            'title' => esc_html__('Daily Views Section', 'propertya'),
            'default' => esc_html__('Daily Views', 'propertya'),
        ),
        array(
            'id' => 'prop_settings_detail_agents',
            'type' => 'text',
            'title' => esc_html__('Agents Section', 'propertya'),
            'default' => esc_html__('Agents', 'propertya'),
        ),

        array(
            'id' => 'prop_settings_detail_reviews_write',
            'type' => 'text',
            'title' => esc_html__('Write a Review Section', 'propertya'),
            'default' => esc_html__('Write a Review', 'propertya'),
        ),


        array(
            'id' => 'p_sidb_section',
            'type' => 'section',
            'title' => esc_html__('Sidebar Generic Sections', 'propertya'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ),

        array(
            'id' => 'prop_detail_sidebar_info',
            'type' => 'text',
            'title' => esc_html__('Contact Info Widget', 'propertya'),
            'default' => esc_html__('Contact Info', 'propertya'),
        ),

        array(
            'id' => 'prop_detail_sidebar_featured',
            'type' => 'text',
            'title' => esc_html__('Featured Listings Widget', 'propertya'),
            'default' => esc_html__('Featured Listings', 'propertya'),
        ),

        array(
            'id' => 'prop_detail_sidebar_banner',
            'type' => 'text',
            'title' => esc_html__('Advertizment Widget', 'propertya'),
            'default' => esc_html__('Advertizment', 'propertya'),
        ),

        array(
            'id' => 'prop_detail_sidebar_reviews',
            'type' => 'text',
            'title' => esc_html__('Reviews Widget', 'propertya'),
            'default' => esc_html__('Reviews', 'propertya'),
        ),

        array(
            'id' => 'prop_detail_sidebar_mview',
            'type' => 'text',
            'title' => esc_html__('Most Viewed Widget', 'propertya'),
            'default' => esc_html__('Most Viewed Listings', 'propertya'),
        ),



        array(
            'id' => 'p_side_sect',
            'type' => 'section',
            'title' => esc_html__('Sidebar Contact Form Settings', 'propertya'),
            'indent' => true,
        ),
        array(
            'id' => 'prop_profileauthor_sub',
            'type' => 'text',
            'title' => esc_html__('Contact Author Subject', 'propertya'),
            'default' => esc_html__("You have a new message from profile", 'propertya'),
        ),
        array(
            'id' => 'prop_profileauthor_messages',
            'type' => 'editor',
            'title' => esc_html__('Contact Author Message', 'propertya'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 30,
                'wpautop' => false,
            ),
            'desc' => esc_html__('%site_name% , %display_name%, %sender_name%,  %sender_email% , %sender_message%, %profile_link% will be translated accordingly.', 'propertya'),
            'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
    <!-- LOGO -->
    <tr>
        <td bgcolor='#3CBEB2' align='center'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#3CBEB2' align='center' style='padding: 0px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
                        <h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hello %display_name%,</h1> <img src='".trailingslashit( get_template_directory_uri () ) . "libs/images/logo-4.png"."' width='' height='' alt='' style='display: block; border: 0px;padding-top: 25px;' />
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0;  font-size: 18px !important;'>You've new Message from your profile page. </p>
                    </td>
                </tr>
                 <!-- COPY -->
				 <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
						 <p style='margin: 0;  font-size: 18px !important;  padding-bottom:5px;'> <strong style='color:#111111'>Profile Link</strong> : <a target='_blank' style='color: #3cbeb2;' href='%profile_link%'>%profile_link%</a></p>
                    </td>
                </tr>
                 <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
						 <p style='margin: 0;  font-size: 18px !important;  padding-bottom:5px;'> <strong style='color:#111111'>Sender Name</strong> : %sender_name%</p>
                        <p style='margin: 0;  font-size: 18px !important;  padding-bottom:5px;'> <strong style='color:#111111'>Sender Email</strong> : %sender_email%</p>
                    </td>
                </tr>
				 <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0; font-size: 18px !important; ' ><strong style='color: #111111;'>Message:</strong>  %sender_message% </p>
                    </td>
                </tr>
                
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                        <h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
                        <p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
                        <p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
                    </td>
                </tr>
            </table>
            
        </td>
    </tr>
</table>
</body>"
        ),

    )
));

Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Agency Detail Page', "propertya" ),
    'id'         => 'prop_ag_detail',
    'desc'       => '',
    'subsection' => true,
    'fields'     => array(
        array(
            'id' => 'prop_ag_detail_sections',
            'type' => 'sorter',
            'title' => esc_html__('Agency Detail Page', 'propertya'),'',
            'desc' => esc_html__('Organize how you want the layout to appear on main site', 'propertya'),'',
            'compiler' => 'true',
            'options' => array(
                'enabled' => array(
                    'over' => esc_html__('Overview', 'propertya'),
                    'props' => esc_html__('All Properties', 'propertya'),
                    'agents' => esc_html__('All Agents', 'propertya'),
                    'views' => esc_html__('Views', 'propertya'),
                    'review' => esc_html__('Reviews', 'propertya'),
                    'write_review' => esc_html__('Write A Reviews', 'propertya'),
                ),
                'disabled' => array(),
            ),
        ),
        array(
            'id' => 'prop_ag_detail_sidebar_agency',
            'type' => 'sorter',
            'title' => esc_html__('Agency Detail Page Sidebar', 'propertya'),'',
            'desc' => esc_html__('Organize how you want the layout to appear on sidebar', 'propertya'),'',
            'compiler' => 'true',
            'options' => array(
                'enabled' => array(
                    'info' => esc_html__('Contact Info', 'propertya'),
                    'featured' => esc_html__('Featured Listings', 'propertya'),
                    'slot1' => esc_html__('Advertizment 300x250', 'propertya'),
                    'score' => esc_html__('Reviews Score', 'propertya'),
                    'contact' => esc_html__('Contact Seller', 'propertya'),
                    'most' => esc_html__('Most Viewed', 'propertya'),
                    'slot2' => esc_html__('Advertizment 300x600', 'propertya'),
                ),
                'disabled' => array(),
            ),
        ),
    )
));


Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Agent Detail Page', "propertya" ),
    'id'         => 'prop_agent_detail',
    'desc'       => '',
    'subsection' => true,
    'fields'     => array(
        array(
            'id' => 'prop_agent_detail_sections',
            'type' => 'sorter',
            'title' => esc_html__('Agent Detail Page', 'propertya'),'',
            'desc' => esc_html__('Organize how you want the layout to appear on main site', 'propertya'),'',
            'compiler' => 'true',
            'options' => array(
                'enabled' => array(
                    'over' => esc_html__('Overview', 'propertya'),
                    'props' => esc_html__('All Properties', 'propertya'),
                    'views' => esc_html__('Views', 'propertya'),
                    'review' => esc_html__('Reviews', 'propertya'),
                    'write_review' => esc_html__('Write A Reviews', 'propertya'),
                ),
                'disabled' => array(),
            ),
        ),
        array(
            'id' => 'prop_agent_detail_sidebar_agency',
            'type' => 'sorter',
            'title' => esc_html__('Agent Detail Page Sidebar', 'propertya'),'',
            'desc' => esc_html__('Organize how you want the layout to appear on sidebar', 'propertya'),'',
            'compiler' => 'true',
            'options' => array(
                'enabled' => array(
                    'info' => esc_html__('Contact Info', 'propertya'),
                    'featured' => esc_html__('Featured Listings', 'propertya'),
                    'slot1' => esc_html__('Advertizment 300x250', 'propertya'),
                    'score' => esc_html__('Reviews Score', 'propertya'),
                    'contact' => esc_html__('Contact Seller', 'propertya'),
                    'most' => esc_html__('Most Viewed', 'propertya'),
                    'slot2' => esc_html__('Advertizment 300x600', 'propertya'),
                ),
                'disabled' => array(),
            ),
        ),
    )
));

Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Buyer Detail Page', "propertya" ),
    'id'         => 'prop_buyer_detail',
    'desc'       => '',
    'subsection' => true,
    'fields'     => array(
        array(
            'id' => 'prop_buyer_detail_sections',
            'type' => 'sorter',
            'title' => esc_html__('Buyer/Individual Profile Detail Page', 'propertya'),'',
            'desc' => esc_html__('Organize how you want the layout to appear on main site', 'propertya'),'',
            'compiler' => 'true',
            'options' => array(
                'enabled' => array(
                    'over' => esc_html__('Overview', 'propertya'),
                    'props' => esc_html__('All Properties', 'propertya'),
                    'views' => esc_html__('Views', 'propertya'),
                    'review' => esc_html__('Reviews', 'propertya'),
                    'write_review' => esc_html__('Write A Reviews', 'propertya'),
                ),
                'disabled' => array(),
            ),
        ),
        array(
            'id' => 'prop_buyer_detail_sidebar_agency',
            'type' => 'sorter',
            'title' => esc_html__('Buyer/Individual Profile Detail Page Sidebar', 'propertya'),'',
            'desc' => esc_html__('Organize how you want the layout to appear on sidebar', 'propertya'),'',
            'compiler' => 'true',
            'options' => array(
                'enabled' => array(
                    'info' => esc_html__('Contact Info', 'propertya'),
                    'featured' => esc_html__('Featured Listings', 'propertya'),
                    'slot1' => esc_html__('Advertizment 300x250', 'propertya'),
                    'score' => esc_html__('Reviews Score', 'propertya'),
                    'contact' => esc_html__('Contact Seller', 'propertya'),
                    'most' => esc_html__('Most Viewed', 'propertya'),
                    'slot2' => esc_html__('Advertizment 300x600', 'propertya'),
                ),
                'disabled' => array(),
            ),
        ),
    )
));



Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Reviews Settings', "propertya" ),
    'id'         => 'prop_ag_reviews',
    'desc'       => '',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'prop_allow_agencies_agents',
            'type'     => 'switch',
            'title'    => __( 'Allow Agencies & Agents?', 'propertya' ),
            'default'  => false,
            'desc'             => esc_html__( 'Allow Agencies & Agents To Post Reviews.', 'propertya' ),
        ),
        array(
            'id' => 'prop_ag_rev_first',
            'type' => 'text',
            'title' => esc_html__('First Feild Text', 'propertya'),
            'default' => esc_html__('Responsiveness', 'propertya'),
        ),
        array(
            'id' => 'prop_ag_rev_second',
            'type' => 'text',
            'title' => esc_html__('Second Field Text', 'propertya'),
            'default' => esc_html__('Professionalism & Communication', 'propertya'),
        ),
        array(
            'id' => 'prop_ag_rev_third',
            'type' => 'text',
            'title' => esc_html__('Third Field Text', 'propertya'),
            'default' => esc_html__('Market Expertise', 'propertya'),
        ),
        array(
            'id' => 'prop_ag_rev_fourth',
            'type' => 'text',
            'title' => esc_html__('Fourth Field Text', 'propertya'),
            'default' => esc_html__('Level of Services', 'propertya'),
        ),
        array(
            'id' => 'prop_ag_rev_recommend',
            'type' => 'text',
            'title' => esc_html__('Recommend Field Text', 'propertya'),
            'default' => esc_html__('Would you recommend this agent(agency) to a friend?', 'propertya'),
        ),
        array(
            'id' => 'prop_ag_rev_prop',
            'type' => 'text',
            'title' => esc_html__('Did You Purchase Field Text', 'propertya'),
            'default' => esc_html__('Did you purchase a property from this agent(agency)?', 'propertya'),
        ),
        array(
            'id' => 'prop_ag_rev_title',
            'type' => 'text',
            'title' => esc_html__('Title Field Text', 'propertya'),
            'default' => esc_html__('Title', 'propertya'),
        ),
        array(
            'id' => 'prop_ag_rev_reviews',
            'type' => 'text',
            'title' => esc_html__('Review Field Text', 'propertya'),
            'default' => esc_html__('Your Comment', 'propertya'),
        ),

        array(
            'id' => 'prop_ag_recommended_badge',
            'type' => 'text',
            'title' => esc_html__('Number of recommendations badge', 'propertya'),
            'desc'             => esc_html__( 'Show recommended badge on author profile after X numbers of recommendations by users', 'propertya' ),
            'subtitle' => esc_html__( 'This must be numeric.', 'propertya' ),
            'default' => 5 ,

        ),
    )
));



/* ------------------ Package Settings ----------------------- */
Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'Membership Settings', 'propertya' ),
    'id'               => 'pack-settings',
    'desc'             => esc_html__( 'Here you can setup packages settings', 'propertya' ),
    'customizer_width' => '600px',
    'icon'             => 'el el-fire',
    'fields'           => array(
        array(
            'id'       => 'prop_membership_type',
            'type'     => 'button_set',
            'title'    => esc_html__( 'Membership Type', 'propertya' ),
            'options'  => array(
                'builtin' => esc_html__( 'Built In System', 'propertya' ),
                'with-woo' => esc_html__( 'WooCommerce Packages', 'propertya' ),
            ),
            'default'  => 'with-woo'
        ),
        array(
            'id' => 'prop_pkg_page',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('Select Packages Page', 'propertya'),
            'default' => '#',
            'required' => array('prop_membership_type', '=', 'with-woo'),
        ),
        
        array(
            'id'       => 'prop_pkg_type',
            'type'     => 'button_set',
            'title'    => esc_html__( 'Package Type', 'propertya' ),
            'options'  => array(
                'free' => esc_html__( 'Free', 'propertya' ),
                'per-listing' => esc_html__( 'Per Listing', 'propertya' ),
            ),
            'required' => array( 'prop_membership_type', '=','builtin'),
            'default'  => 'free'
        ),
        array(
            'id'       => 'prop_woo_approval',
            'type'     => 'button_set',
            'title'    => esc_html__( 'Packages Order Approved By', 'propertya' ),
            'options'  => array(
                'auto-woo' => esc_html__( 'Auto Approve', 'propertya' ),
                'admin-woo' => esc_html__( 'Admin Approve', 'propertya' ),
            ),
            'required' => array( 'prop_membership_type', '=','with-woo'),
            'default'  => 'auto-woo'
        ),

        array(
            'id'       => 'property_approval',
            'type'     => 'select',
            'options'  => array('auto' => 'Auto Approved', 'manual' => 'Admin manual approval' ),
            'title'    => esc_html__( 'Property Submission Approval', 'propertya' ),
            'default'  => 'auto',
        ),
        array(
            'id'       => 'property_approval_edit',
            'type'     => 'select',
            'options'  => array('auto' => 'Auto Approved', 'manual' => 'Admin manual approval' ),
            'title'    => esc_html__( 'Property Edit/Update Approval', 'propertya' ),
            'default'  => 'auto',
        ),

        array(
            'id'       => 'property_payment_approval',
            'type'     => 'select',
            'options'  => array('auto' => 'Auto Approved', 'manual' => 'Admin manual approval' ),
            'title'    => esc_html__( 'Submission Approval After Payment', 'propertya' ),
            'default'  => 'auto',
        ),

        array(
            'id' => 'prop_membership_currency',
            'type' => 'select',
            'title' => esc_html__('Currency For Paid Submission', 'propertya') ,
            'options'	=> $currecnies,
            'required' => array( 'prop_pkg_type', '!=', array( 'free' ) ),
            'default'  =>  array('USD'),
        ) ,

        array(
            'id'       => 'prop_perlisting_price',
            'type'     => 'text',
            'title'    => esc_html__( 'Price for Submission', 'propertya' ),
            'subtitle' => esc_html__( 'This must be numeric.', 'propertya' ),
            'validate' => 'numeric',
            'default'  => '5',
            'required' => array( 'prop_pkg_type', '=', 'per-listing' ),
        ),
        array(
            'id'       => 'prop_perlisting_featured',
            'type'     => 'text',
            'title'    => esc_html__( 'Featured Listing Price', 'propertya' ),
            'subtitle' => esc_html__( 'This must be numeric.', 'propertya' ),
            'validate' => 'numeric',
            'default'  => '3',
            'required' => array( 'prop_pkg_type', '=', 'per-listing' ),
        ),
        array(
            'id'       => 'prop_perlisting_featured_expiry',
            'type'     => 'text',
            'title'    => esc_html__( 'Featured Listing Expiry ( Days )', 'propertya' ),
            'subtitle' => esc_html__( 'This must be numeric.', 'propertya' ),
            'validate' => 'numeric',
            'default'  => '-1',
            'desc'     => esc_html__( 'Expiry in days, -1 means never expired.', 'propertya' ),
            'required' => array( 'prop_pkg_type', '=', 'per-listing' ),
        ),
        array(
            'id'       => 'prop_perlisting_expiry',
            'type'     => 'text',
            'title'    => esc_html__( 'Listing Expiry ( Days )', 'propertya' ),
            'subtitle' => esc_html__( 'This must be numeric.', 'propertya' ),
            'validate' => 'numeric',
            'default'  => '-1',
            'desc'     => esc_html__( 'Expiry in days, -1 means never expired.', 'propertya' ),
            'required' => array( 'prop_pkg_type', '=', 'per-listing' ),
        ),

    )
));


Redux::setSection($opt_name, array(
    'title' => __("Stripe Settings", "propertya") ,
    'id' => 'api_stripe_sett',
    'icon' => 'el el-credit-card',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'prop_enable_stripe',
            'type'     => 'switch',
            'title'    => __( 'Enable Stripe?', 'propertya' ),
            'default'  => true,
            'desc'             => esc_html__( 'You can enable or disable Stripe payment buttons.', 'propertya' ),
        ),

        array(
            'id' => 'prop_stripe_pub_key',
            'type' => 'text',
            'title' => __('Stripe Publishable Key', 'propertya') ,
            'required' => array( 'prop_enable_stripe', '=',true),
        ) ,
        array(
            'id' => 'prop_stripe_sec_key',
            'type' => 'text',
            'title' => __('Stripe Secret Key', 'propertya') ,
            'required' => array( 'prop_enable_stripe', '=', true),
        ) ,
    )
));


Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Paypal Settings', "propertya" ),
    'id'         => 'prop_paypall',
    'desc'       => '',
    'icon' => 'el el-path',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'prop_enable_paypal',
            'type'     => 'switch',
            'title'    => esc_html__( 'Enable Paypal?', 'propertya' ),
            'default'  => true,
            'desc'             => esc_html__( 'You can enable or disable Paypal payment buttons.', 'propertya' ),
        ),
        array(
            'id'       => 'prop_paypal_mode',
            'type'     => 'button_set',
            'title'    => esc_html__( 'Paypal Mode', 'propertya' ),
            'options'  => array(
                'live' => esc_html__('Live', 'propertya' ),
                'sandbox' => esc_html__('Sandbox', 'propertya' ),
            ),
            'default'  => 'live',
        ),
        array(
            'id'       => 'prop_pay_clientid',
            'type'     => 'text',
            'title'    => esc_html__( 'Paypal Client Id', 'propertya' ),
            'desc'  => esc_html__( 'Enter you paypal client id here', 'propertya' ),

        ),
        array(
            'id'       => 'prop_pay_secret',
            'type'     => 'text',
            'title'    => esc_html__( 'Paypal Secret', 'propertya' ),
            'desc'  => esc_html__( 'Enter you paypal Secret id here', 'propertya' ),
        ),
    )
));

Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Razorpay Settings', "propertya" ),
    'id'         => 'prop_razor',
    'desc'       => '',
    'icon' => 'el el-path',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'prop_enable_razor',
            'type'     => 'switch',
            'title'    => esc_html__( 'Enable Razorpay?', 'propertya' ),
            'default'  => true,
            'desc'             => esc_html__( 'You can enable or disable Razorpay payment buttons.', 'propertya' ),
        ),
        array(
            'id'       => 'prop_razor_keyid',
            'type'     => 'text',
            'title'    => esc_html__( 'Razorpay Key Id', 'propertya' ),
            'desc'  => esc_html__( 'Enter you Razorpay Key ID here', 'propertya' ),

        ),
        array(
            'id'       => 'prop_razor_secret',
            'type'     => 'text',
            'title'    => esc_html__( 'Razorpay Key Secret', 'propertya' ),
            'desc'  => esc_html__( 'Enter you Razorpay Secret id here', 'propertya' ),
        ),
    )
));

Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Order Page', "propertya" ),
    'id'         => 'prop_order_pg',
    'desc'       => '',
    'icon' => 'el el-path',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'prop_order_title',
            'type'     => 'text',
            'title'    => esc_html__( 'Main Title', 'propertya' ),
            'default'  =>  esc_html__( 'You listing have been posted!', 'propertya' ),
        ),
        array(
            'id'               => 'prop_order_editor',
            'type'             => 'editor',
            'title'            => esc_html__('Editor Text', 'propertya'),
            'subtitle'         => esc_html__('Subtitle text would go here.', 'propertya'),
            'default'          => esc_html__('We just sent your receipt to your email address, and your items will be on their way shortly..', 'propertya'),
            'args'   => array(
                'teeny'            => true,
                'textarea_rows'    => 10,
                'media_buttons' => false,
                'wpautop' => false
            )
        ),

    )
));

Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Featured Listing Expiry', "propertya" ),
    'id'         => 'prop_expiry_emails',
    'desc'       => '',
    'icon' => 'el el-fire',
    'subsection' => true,
    'fields'     => array(
        array(
            'id' => 'prop_featured_subs',
            'type' => 'text',
            'title' => esc_html__('Featured Ad Expiry Subject', 'propertya'),
            'default' => esc_html__("Featured Property Expiry Notification", 'propertya'),
        ),
        array(
            'id' => 'prop_featured_messagess',
            'type' => 'editor',
            'title' => esc_html__('Featured Ad Expiry Message', 'propertya'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 30,
                'wpautop' => false,
            ),
            'desc' => esc_html__('%site_name% , %display_name%, %sender_name%,  %sender_email% , %sender_message%,  %listing_title%,  %listing_link% will be translated accordingly.', 'propertya'),
            'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
    <!-- LOGO -->
    <tr>
        <td bgcolor='#3CBEB2' align='center'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#3CBEB2' align='center' style='padding: 0px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
                    <img src='".trailingslashit( get_template_directory_uri () ) . "libs/images/logo-4.png"."' width='' height='' alt='' style='display: block; border: 0px;padding-bottom: 25px;' />
                        <h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hello %display_name%,</h1> 
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 20px 30px 15px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0;  font-size: 18px !important;'>Your featured ad has been expired! </p>
                    </td>
                </tr>
                 <!-- COPY -->
				 <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0;  font-size: 18px !important; padding-bottom:5px;'> <strong style='color:#111111'>Listing Title</strong> : %listing_title%</p>
						 <p style='margin: 0;  font-size: 18px !important;  padding-bottom:5px;'> <strong style='color:#111111'>Link</strong> : <a target='_blank' style='color: #3cbeb2;' href='%listing_link%'>%listing_link%</a></p>
                    </td>
                </tr>
                <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 10px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
                    </td>
                </tr>
                <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 10px 30px 20px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service.<br>Scriptsbundle Team</p>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                        <h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
                        <p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
                        <p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
                    </td>
                </tr>
            </table>
            
        </td>
    </tr>
</table>
</body>"
        ),

    )
));

Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Regular Listing Expiry', "propertya" ),
    'id'         => 'prop_expiry_regular',
    'desc'       => '',
    'icon' => 'el el-list-alt',
    'subsection' => true,
    'fields'     => array(

        array(
            'id'       => 'prop_expiry_status',
            'type'     => 'button_set',
            'title'    => esc_html__( 'Listing Expiry Type', 'propertya' ),
            'options'  => array(
                'trash' => esc_html__('Trash', 'propertya' ),
                'expired' => esc_html__('Expired', 'propertya' ),
            ),
            'default'  => 'expired',
            'desc' => esc_html__('Trash will delete the listing from the site permanently.', 'propertya'),
        ),

        array(
            'id' => 'prop_reg_subj',
            'type' => 'text',
            'title' => esc_html__('Regular Listing Expiry Subject', 'propertya'),
            'default' => esc_html__("Regular Listing Expiry Notification", 'propertya'),
        ),
        array(
            'id' => 'prop_reg_message',
            'type' => 'editor',
            'title' => esc_html__('Regular Listing Expiry Message', 'propertya'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 30,
                'wpautop' => false,
            ),
            'desc' => esc_html__('%site_name% , %display_name%, will be translated accordingly.', 'propertya'),
            'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
    <!-- LOGO -->
    <tr>
        <td bgcolor='#3CBEB2' align='center'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#3CBEB2' align='center' style='padding: 0px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
                    <img src='".trailingslashit( get_template_directory_uri () ) . "libs/images/logo-4.png"."' width='' height='' alt='' style='display: block; border: 0px;padding-bottom: 25px;' />
                        <h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hello %display_name%,</h1> 
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 20px 30px 15px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0;  font-size: 18px !important;'>Your listing has been expired & trashed! </p>
                    </td>
                </tr>
                 
                <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 10px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
                    </td>
                </tr>
                <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 10px 30px 20px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service.<br>Scriptsbundle Team</p>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                        <h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
                        <p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
                        <p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
                    </td>
                </tr>
            </table>
            
        </td>
    </tr>
</table>
</body>"
        ),

    )
));

Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Expiry Cron Jobs', "propertya" ),
    'id'         => 'prop_cron_jobs',
    'desc'       => '',
    'icon' => 'el el-cog',
    'subsection' => true,
    'fields'     => array(
        array(
            'id' => 'prop_regular_cron_switch',
            'type' => 'switch',
            'title' => esc_html__('Enable Regular Listings Cron Jobs', 'propertya'),
            'desc' => esc_html__('Note : This functionality works hiddenly check all the listings and trash/expires old listings. This option takes a lot of loads so anyone who wishes to choose this option must have a good server.', 'propertya'),
            'default' => false,
        ),
        array(
            'id' => 'prop_regular_cron_switch_interval',
            'type' => 'select',
            'required' => array('prop_regular_cron_switch', '=', true),
            'title' => esc_html__('Cron Interval', 'propertya'),
            'desc' => esc_html__('Cron job run after this Interval', 'propertya'),
            'options' => array('hourly' => 'Hourly', 'twicedaily' => 'Twice Daily', 'daily' => 'Daily'),
            'default' => 'daily',
        ),

        array(
            'id' => 'prop_featured_cron_switch',
            'type' => 'switch',
            'title' => esc_html__('Enable Featured Listings Cron Jobs', 'propertya'),
            'desc' => esc_html__('Note : This functionality works hiddenly check all the listings and trash/expires old listings. This option takes a lot of loads so anyone who wishes to choose this option must have a good server.', 'propertya'),
            'default' => false,
            'subtitle'  => esc_html__('Check featured listing expiry automatically', 'propertya'),
        ),
        array(
            'id' => 'prop_featured_cron_switch_interval',
            'type' => 'select',
            'required' => array('prop_featured_cron_switch', '=', true),
            'title' => esc_html__('Cron Interval', 'propertya'),
            'desc' => esc_html__('Cron job run after this Interval', 'propertya'),
            'options' => array('hourly' => 'Hourly', 'twicedaily' => 'Twice Daily', 'daily' => 'Daily'),
            'default' => 'daily',
        ),

    )
));


/* ------------------Blog Settings ----------------------- */
Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Admin Options', 'propertya' ),
    'id'         => 'prop_admin_options',
    'desc'       => '',
    'icon' => 'el el-asl',
    'fields'     => array(
        array(
            'id'       => 'prop_woo_enable_packages',
            'type'     => 'switch',
            'title'    => esc_html__( 'Assign Free Package On Registration', 'propertya' ),
            'default'  => true,
        ),
        array(
            'id'    => 'prop_notification_packages',
            'type'  => 'info',
            'title' => esc_html__('Package Alert', 'propertya'),
            'style' => 'critical',
            'desc'  => esc_html__('This option will only work when ( WooCommerce Plugin ) is activeted & ( Propertya Packages ) are created.', 'propertya'),
            'required' => array( 'prop_woo_enable_packages', '=', true ),
        ),
        array(
            'id' => 'prop_listing_package_type',
            'type' => 'select',
            'data' => 'post',
            'args' => array(
                'post_type' => array('product') ,
                'post_status' => 'publish',
                'posts_per_page' => 20,
                'order'=> 'DESC',
                'orderby' => 'date',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_type',
                        'field' => 'slug',
                        'terms' => 'propertya_packages'
                    ),
                ),
            ) ,
            'title' => esc_html__('Select Package', 'propertya') ,
            'required' => array( 'prop_woo_enable_packages', '=', true ),
        ) ,

        array(
            'id'       => 'prop_contact_number_selector',
            'type'     => 'switch',
            'title'    => esc_html__( 'Show All Telephone Numbers', 'propertya' ),
            'on' => 'All Countires',
            'off' => 'Selective',
            'default'  => true,
            'desc' =>  esc_html__('Show all or selective country mobile number on listing contact forms.', 'propertya'),
        ),
        array(
            'id'		=> 'prop_contact_number_selective',
            'type'		=> 'select',
            'title'		=> esc_html__( 'Chart Type', 'propertya' ),
            'options'	=> array(
                'AD'=>'Andorra',
                'AE'=>'United Arab Emirates',
                'AF'=>'Afghanistan',
                'AG'=>'Antigua and Barbuda',
                'AI'=>'Anguilla',
                'AL'=>'Albania',
                'AM'=>'Armenia',
                'AO'=>'Angola',
                'AP'=>'Asia/Pacific Region',
                'AQ'=>'Antarctica',
                'AR'=>'Argentina',
                'AS'=>'American Samoa',
                'AT'=>'Austria',
                'AU'=>'Australia',
                'AW'=>'Aruba',
                'AX'=>'Aland Islands',
                'AZ'=>'Azerbaijan',
                'BA'=>'Bosnia and Herzegovina',
                'BB'=>'Barbados',
                'BD'=>'Bangladesh',
                'BE'=>'Belgium',
                'BF'=>'Burkina Faso',
                'BG'=>'Bulgaria',
                'BH'=>'Bahrain',
                'BI'=>'Burundi',
                'BJ'=>'Benin',
                'BL'=>'Saint Bartelemey',
                'BM'=>'Bermuda',
                'BN'=>'Brunei Darussalam',
                'BO'=>'Bolivia',
                'BQ'=>'Bonaire Saint Eustatius and Saba',
                'BR'=>'Brazil',
                'BS'=>'Bahamas',
                'BT'=>'Bhutan',
                'BV'=>'Bouvet Island',
                'BW'=>'Botswana',
                'BY'=>'Belarus',
                'BZ'=>'Belize',
                'CA'=>'Canada',
                'CC'=>'Cocos (Keeling) Islands',
                'CD'=>'Congo The Democratic Republic of the',
                'CF'=>'Central African Republic',
                'CG'=>'Congo',
                'CH'=>'Switzerland',
                'CI'=>'Cote d Ivoire',
                'CK'=>'Cook Islands',
                'CL'=>'Chile',
                'CM'=>'Cameroon',
                'CN'=>'China',
                'CO'=>'Colombia',
                'CR'=>'Costa Rica',
                'CU'=>'Cuba',
                'CV'=>'Cape Verde',
                'CW'=>'Curacao',
                'CX'=>'Christmas Island',
                'CY'=>'Cyprus',
                'CZ'=>'Czech Republic',
                'DE'=>'Germany',
                'DJ'=>'Djibouti',
                'DK'=>'Denmark',
                'DM'=>'Dominica',
                'DO'=>'Dominican Republic',
                'DZ'=>'Algeria',
                'EC'=>'Ecuador',
                'EE'=>'Estonia',
                'EG'=>'Egypt',
                'EH'=>'Western Sahara',
                'ER'=>'Eritrea',
                'ES'=>'Spain',
                'ET'=>'Ethiopia',
                'EU'=>'Europe',
                'FI'=>'Finland',
                'FJ'=>'Fiji',
                'FK'=>'Falkland Islands (Malvinas)',
                'FM'=>'Micronesia Federated States of',
                'FO'=>'Faroe Islands',
                'FR'=>'France',
                'GA'=>'Gabon',
                'GB'=>'United Kingdom',
                'GD'=>'Grenada',
                'GE'=>'Georgia',
                'GF'=>'French Guiana',
                'GG'=>'Guernsey',
                'GH'=>'Ghana',
                'GI'=>'Gibraltar',
                'GL'=>'Greenland',
                'GM'=>'Gambia',
                'GN'=>'Guinea',
                'GP'=>'Guadeloupe',
                'GQ'=>'Equatorial Guinea',
                'GR'=>'Greece',
                'GS'=>'South Georgia and the South Sandwich Islands',
                'GT'=>'Guatemala',
                'GU'=>'Guam',
                'GW'=>'Guinea-Bissau',
                'GY'=>'Guyana',
                'HK'=>'Hong Kong',
                'HM'=>'Heard Island and McDonald Islands',
                'HN'=>'Honduras',
                'HR'=>'Croatia',
                'HT'=>'Haiti',
                'HU'=>'Hungary',
                'ID'=>'Indonesia',
                'IE'=>'Ireland',
                'IL'=>'Israel',
                'IM'=>'Isle of Man',
                'IN'=>'India',
                'IO'=>'British Indian Ocean Territory',
                'IQ'=>'Iraq',
                'IR'=>'Iran Islamic Republic of',
                'IS'=>'Iceland',
                'IT'=>'Italy',
                'JE'=>'Jersey',
                'JM'=>'Jamaica',
                'JO'=>'Jordan',
                'JP'=>'Japan',
                'KE'=>'Kenya',
                'KG'=>'Kyrgyzstan',
                'KH'=>'Cambodia',
                'KI'=>'Kiribati',
                'KM'=>'Comoros',
                'KN'=>'Saint Kitts and Nevis',
                'KP'=>'Korea Democratic Peoples Republic of',
                'KR'=>'Korea Republic of',
                'KW'=>'Kuwait',
                'KY'=>'Cayman Islands',
                'KZ'=>'Kazakhstan',
                'LA'=>"Lao People's Democratic Republic",
                'LB'=>'Lebanon',
                'LC'=>'Saint Lucia',
                'LI'=>'Liechtenstein',
                'LK'=>'Sri Lanka',
                'LR'=>'Liberia',
                'LS'=>'Lesotho',
                'LT'=>'Lithuania',
                'LU'=>'Luxembourg',
                'LV'=>'Latvia',
                'LY'=>'Libyan Arab Jamahiriya',
                'MA'=>'Morocco',
                'MC'=>'Monaco',
                'MD'=>"Moldova' Republic of",
                'ME'=>'Montenegro',
                'MF'=>'Saint Martin',
                'MG'=>'Madagascar',
                'MH'=>'Marshall Islands',
                'MK'=>'Macedonia',
                'ML'=>'Mali',
                'MM'=>'Myanmar',
                'MN'=>'Mongolia',
                'MO'=>'Macao',
                'MP'=>'Northern Mariana Islands',
                'MQ'=>'Martinique',
                'MR'=>'Mauritania',
                'MS'=>'Montserrat',
                'MT'=>'Malta',
                'MU'=>'Mauritius',
                'MV'=>'Maldives',
                'MW'=>'Malawi',
                'MX'=>'Mexico',
                'MY'=>'Malaysia',
                'MZ'=>'Mozambique',
                'NA'=>'Namibia',
                'NC'=>'New Caledonia',
                'NE'=>'Niger',
                'NF'=>'Norfolk Island',
                'NG'=>'Nigeria',
                'NI'=>'Nicaragua',
                'NL'=>'Netherlands',
                'NO'=>'Norway',
                'NP'=>'Nepal',
                'NR'=>'Nauru',
                'NU'=>'Niue',
                'NZ'=>'New Zealand',
                'OM'=>'Oman',
                'PA'=>'Panama',
                'PE'=>'Peru',
                'PF'=>'French Polynesia',
                'PG'=>'Papua New Guinea',
                'PH'=>'Philippines',
                'PK'=>'Pakistan',
                'PL'=>'Poland',
                'PM'=>'Saint Pierre and Miquelon',
                'PN'=>'Pitcairn',
                'PR'=>'Puerto Rico',
                'PS'=>'Palestinian Territory',
                'PT'=>'Portugal',
                'PW'=>'Palau',
                'PY'=>'Paraguay',
                'QA'=>'Qatar',
                'RE'=>'Reunion',
                'RO'=>'Romania',
                'RS'=>'Serbia',
                'RU'=>'Russian Federation',
                'RW'=>'Rwanda',
                'SA'=>'Saudi Arabia',
                'SB'=>'Solomon Islands',
                'SC'=>'Seychelles',
                'SD'=>'Sudan',
                'SE'=>'Sweden',
                'SG'=>'Singapore',
                'SH'=>'Saint Helena',
                'SI'=>'Slovenia',
                'SJ'=>'Svalbard and Jan Mayen',
                'SK'=>'Slovakia',
                'SL'=>'Sierra Leone',
                'SM'=>'San Marino',
                'SN'=>'Senegal',
                'SO'=>'Somalia',
                'SR'=>'Suriname',
                'SS'=>'South Sudan',
                'ST'=>'Sao Tome and Principe',
                'SV'=>'El Salvador',
                'SX'=>'Sint Maarten',
                'SY'=>'Syrian Arab Republic',
                'SZ'=>'Swaziland',
                'TC'=>'Turks and Caicos Islands',
                'TD'=>'Chad',
                'TF'=>'French Southern Territories',
                'TG'=>'Togo',
                'TH'=>'Thailand',
                'TJ'=>'Tajikistan',
                'TK'=>'Tokelau',
                'TL'=>'Timor-Leste',
                'TM'=>'Turkmenistan',
                'TN'=>'Tunisia',
                'TO'=>'Tonga',
                'TR'=>'Turkey',
                'TT'=>'Trinidad and Tobago',
                'TV'=>'Tuvalu',
                'TW'=>'Taiwan',
                'TZ'=>"Tanzania' United Republic of",
                'UA'=>'Ukraine',
                'UG'=>'Uganda',
                'UM'=>'United States Minor Outlying Islands',
                'US'=>'United States',
                'UY'=>'Uruguay',
                'UZ'=>'Uzbekistan',
                'VA'=>'Holy See (Vatican City State)',
                'VC'=>'Saint Vincent and the Grenadines',
                'VE'=>'Venezuela',
                'VG'=>"Virgin Islands' British",
                'VI'=>"Virgin Islands' U.S.",
                'VN'=>'Vietnam',
                'VU'=>'Vanuatu',
                'WF'=>'Wallis and Futuna',
                'WS'=>'Samoa',
                'YE'=>'Yemen',
                'YT'=>'Mayotte',
                'ZA'=>'South Africa',
                'ZM'=>'Zambia',
                'ZW'=>'Zimbabwe',
            ),
            'default'	=> 'bar',
            'required' => array( 'prop_contact_number_selector', '=', false),
        ),
    )
) );


Redux::setSection($opt_name, array(
    'title' => esc_html__('Listing Detail', 'propertya'),
    'id' => 'prop_list_detail',
    'desc' => '',
    'icon' => 'el el-adjust-alt',
));

Redux::setSection($opt_name, array(
    'title' => esc_html__('Detail Page Settings', 'propertya'),
    'id' => 'prop-d-view',
    'desc' => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'prop_lp_style',
            'type' => 'image_select',
            'title' => esc_html__('Listing detail Page Style', 'propertya'),
            'options' => array(
                'elegent' => array(
                    'alt' => esc_html__('Elegent', 'propertya'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'libs/images/options/elegent.png'
                ),
                'classic' => array(
                    'alt' => esc_html__('Classic', 'propertya'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'libs/images/options/classic.png'
                ),
            ),
            'default' => 'classic'
        ),

        array(
            'id' => 'prop_layout_manager',
            'type' => 'sorter',
            'title' => esc_html__('Page Layout Manager', 'propertya'),
            'desc' => esc_html__('Organize how you want the layout to appear on the listing page', 'propertya'),
            'compiler' => 'true',
            'required' => array('prop_lp_style', '=', 'elegent'),
            'options' => array(
                'enabled' => array(
                    'slider' => esc_html__('Slider', 'propertya'),
                    'ad_slot_1' => esc_html__('Ad Slot 1', 'propertya'),
                    'desc' =>esc_html__('Description', 'propertya'),
                    'shortinfo' =>esc_html__('Details', 'propertya'),
                    'custom_fields' =>esc_html__('Custom Field', 'propertya'),
                    'additional' =>esc_html__('Additional Details', 'propertya'),
                    'additional-fields' =>esc_html__('additional fields', 'propertya'),
                    'addr' =>esc_html__('Address', 'propertya'),
                    'features' => esc_html__('Features', 'propertya'),
                    'plans' => esc_html__('Floor Plans', 'propertya'),
                    'attachments' =>esc_html__('Attachments', 'propertya'),
                    'nearby' =>esc_html__('Nearby', 'propertya'),
                    'walk' =>esc_html__('WalkScore', 'propertya'),
                    'tour' =>esc_html__('360° Virtual Tour', 'propertya'),
                    'views' =>esc_html__('Page Views', 'propertya'),
                    'schedule' =>esc_html__('Schedule a Tour', 'propertya'),
                    'similar' =>esc_html__('Similar Listings', 'propertya'),
                    'ad_slot_2' =>esc_html__('Ad Slot 2', 'propertya'),
                    'reviews_score' =>esc_html__('Reviews Score', 'propertya'),
                    'reviews' =>esc_html__('Reviews', 'propertya'),
                    'reviews_form' =>esc_html__('Review Form', 'propertya'),
                ),
                'disabled' => array(),
            ),
        ),
        array(
            'id' => 'prop_layout1_manager',
            'type' => 'sorter',
            'title' => esc_html__('Page Layout Manager', 'propertya'),
            'desc' => esc_html__('Organize how you want the layout to appear on the listing page', 'propertya'),
            'compiler' => 'true',
            'required' => array('prop_lp_style', '=', 'classic'),
            'options' => array(
                'enabled' => array(
                    'ad_slot_1' => esc_html__('Ad Slot 1', 'propertya'),
                    'desc' =>esc_html__('Description', 'propertya'),
                    'shortinfo' =>esc_html__('Details', 'propertya'),
                    'additional' =>esc_html__('Additional Details', 'propertya'),
                    'additional-fields' =>esc_html__('additional fields', 'propertya'),
                    'addr' =>esc_html__('Address', 'propertya'),
                    'features' => esc_html__('Features', 'propertya'),
                    'plans' => esc_html__('Floor Plans', 'propertya'),
                    'attachments' =>esc_html__('Attachments', 'propertya'),
                    'nearby' =>esc_html__('Nearby', 'propertya'),
                    'walk' =>esc_html__('WalkScore', 'propertya'),
                    'tour' =>esc_html__('360° Virtual Tour', 'propertya'),
                    'views' =>esc_html__('Page Views', 'propertya'),
                    'schedule' =>esc_html__('Schedule a Tour', 'propertya'),
                    'similar' =>esc_html__('Similar Listings', 'propertya'),
                    'ad_slot_2' =>esc_html__('Ad Slot 2', 'propertya'),
                    'reviews_score' =>esc_html__('Reviews Score', 'propertya'),
                    'reviews' =>esc_html__('Reviews', 'propertya'),
                    'reviews_form' =>esc_html__('Review Form', 'propertya'),
                    'custom_fields' =>esc_html__('Custom Field', 'propertya'),
                ),
                'disabled' => array(),
            ),
        ),
        array(
            'id' => 'dlisting_view_txt',
            'type' => 'section',
            'title' => esc_html__('Listing Sections Text', 'propertya'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id' => 'prop_desc',
            'type' => 'text',
            'title' => esc_html__('Description Section', 'propertya'),
            'default' => esc_html__('Description', 'propertya'),
        ),
        array(
            'id' => 'prop_details',
            'type' => 'text',
            'title' => esc_html__('Details Section', 'propertya'),
            'default' => esc_html__('Details', 'propertya'),
        ),
        array(
            'id' => 'prop_additional_details',
            'type' => 'text',
            'title' => esc_html__('Additional Details Section', 'propertya'),
            'default' => esc_html__('Additional Details', 'propertya'),
        ),
        array(
            'id' => 'prop_address',
            'type' => 'text',
            'title' => esc_html__('Address Section', 'propertya'),
            'default' => esc_html__('Address', 'propertya'),
        ),
        array(
            'id' => 'prop_features',
            'type' => 'text',
            'title' => esc_html__('Features Section', 'propertya'),
            'default' =>  esc_html__('Features', 'propertya'),
        ),
        array(
            'id' => 'prop_flrplans',
            'type' => 'text',
            'title' => esc_html__('Floor Plans Section', 'propertya'),
            'default' => esc_html__('Floor Plans', 'propertya'),
        ),
        array(
            'id' => 'prop_attachs',
            'type' => 'text',
            'title' => esc_html__('Attachments Section', 'propertya'),
            'default' => esc_html__('Attachments', 'propertya'),
        ),
        array(
            'id' => 'prop_yelpnear',
            'type' => 'text',
            'title' => esc_html__('Nearby Section', 'propertya'),
            'default' => esc_html__("What's NearBy", 'propertya'),
        ),
        array(
            'id' => 'prop_walkscore',
            'type' => 'text',
            'title' => esc_html__('WalkScore Section', 'propertya'),
            'default' => esc_html__('Walkscore', 'propertya'),
        ),
        array(
            'id' => 'prop_360',
            'type' => 'text',
            'title' => esc_html__('360° Virtual Tour Section', 'propertya'),
            'default' => esc_html__('360° Virtual Tour', 'propertya'),
        ),
        array(
            'id' => 'prop_page_views',
            'type' => 'text',
            'title' => esc_html__('Page Views Section', 'propertya'),
            'default' => esc_html__('Statistics', 'propertya'),
        ),
        array(
            'id' => 'prop_tour_sch',
            'type' => 'text',
            'title' => esc_html__('Schedule a Tour Section', 'propertya'),
            'default' => esc_html__('Schedule a Tour', 'propertya'),
        ),
        array(
            'id' => 'prop_simi_listings',
            'type' => 'text',
            'title' => esc_html__('Similar Listings Section', 'propertya'),
            'default' => esc_html__('Similar Listings', 'propertya'),
        ),
        array(
            'id' => 'prop_review_form',
            'type' => 'text',
            'title' => esc_html__('Review Forms Section', 'propertya'),
            'default' => esc_html__('Write a Review', 'propertya'),
        ),
        array(
            'id' => 'prop_custom_views',
            'type' => 'text',
            'title' => esc_html__('Custom Fields Section', 'propertya'),
            'default' => esc_html__('Custom info', 'propertya'),
        ),
        array(
            'id'       => 'prop_l_area_prefix',
            'type'     => 'text',
            'title'    => esc_html__( 'Land Area Prefix', 'propertya' ),
            'default'  => esc_html__( 'm&sup2;', 'propertya' ),
        ),
        array(
            'id'       => 'prop_l_area_Size',
            'type'     => 'text',
            'title'    => esc_html__( 'Area Size Prefix ', 'propertya' ),
            'default'  => esc_html__( 'm&sup2;', 'propertya' ),
        ),
        array(
            'id'       => 'prop_floor_name',
            'type'     => 'text',
            'title'    => esc_html__( 'Property Floor Name', 'propertya' ),
            'default'  => esc_html__( 'Ground Floor', 'propertya' ),
        ),
        array(
            'id'       => 'prop_floor_price',
            'type'     => 'text',
            'title'    => esc_html__( 'Property Floor Price', 'propertya' ),
            'default'  => esc_html__( '2500', 'propertya' ),
        ),
        array(
            'id'       => 'prop_price_postfix',
            'type'     => 'text',
            'title'    => esc_html__( 'Price Postfix', 'propertya' ),
            'default'  => esc_html__( 'Per Month', 'propertya' ),
        ),
        array(
            'id'       => 'prop_floor_size',
            'type'     => 'text',
            'title'    => esc_html__( 'Floor Size', 'propertya' ),
            'default'  => esc_html__( '1500', 'propertya' ),
        ),
        array(
            'id'       => 'prop_size_postfix',
            'type'     => 'text',
            'title'    => esc_html__( 'Size Postfix', 'propertya' ),
            'default'  => esc_html__( 'Squre Foot', 'propertya' ),
        ),
        array(
            'id'       => 'prop_floor_bed',
            'type'     => 'text',
            'title'    => esc_html__( 'Floor Bedrooms', 'propertya' ),
            'default'  => esc_html__( '2', 'propertya' ),
        ),
        array(
            'id'       => 'prop_floor_bath',
            'type'     => 'text',
            'title'    => esc_html__( 'Floor Bathrooms', 'propertya' ),
            'default'  => esc_html__( '2', 'propertya' ),
        ),
     


    )
));


 //////Listing nearby
 
Redux::set_section($opt_name, array(
    'title' => __('Near by Listing', 'propertya'),
    'id' => 'propertya_listing_nearby_location',
    'icon' => 'el el-wrench',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'propertya_listing_nearby_dest',
            'type' => 'text',
            'title' => esc_html__('Add Distance for Nearby Location', 'propertya'),
            'subtitle' => esc_html__('Enter only numberic values. Do not add distance units here', 'propertya'),
            'description' => esc_html__('Add Distance for Nearby Location', 'propertya') . '</a>',
            'default' => '100',
        ),
        array(
            'id' => 'propertya_listing_nearby_dest_in',
            'type' => 'select',
            'title' => __('Destination in ', 'propertya'),
            'subtitle' => __('Nearby Destination Calculate in', 'propertya'),
            'desc' => __('Nearby Destination', 'propertya'),
            'options' => array(
                'kilometers' => 'Kilometers',
                'miles' => 'Miles',
            ),
            'default' => 'kilometers',
        ),
        array(
            'id' => 'propertya_listing_nearby_no_listings',
            'type' => 'text',
            'title' => esc_html__('No. of Nearby Listings', 'propertya'),
            'subtitle' => esc_html__('Enter only numberic values', 'propertya'),
            'description' => esc_html__('No. of Nearby Listings', 'propertya') . '</a>',
            'default' => '5',
        ),
    )
));

Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Listing Page Sidebar', "propertya" ),
    'id'         => 'prop_lp_sidebar',
    'desc'       => '',
    'subsection' => true,
    'fields'     => array(
        array(
            'id' => 'prop_listingsidebar',
            'type' => 'sorter',
            'title' => esc_html__('Listing Page Sidebar', 'propertya'),'',
            'desc' => esc_html__('Organize how you want the layout to appear on sidebar', 'propertya'),'',
            'compiler' => 'true',
            'options' => array(
                'enabled' => array(
                    'card' => esc_html__('Profile Card', 'propertya'),
                    'address' => esc_html__('Listing Address', 'propertya'),
                    'stats' => esc_html__('Listing Stats', 'propertya'),
                    'featured' => esc_html__('Featured Listings', 'propertya'),
                    'contact' => esc_html__('Contact Form', 'propertya'),
                    'nearby' => esc_html__('Listing Nearby', 'propertya'),
                    'slot1' => esc_html__('Advertizment 300x250', 'propertya'),
                    'recently' => esc_html__('Recently Listed', 'propertya'),
                    'slot2' => esc_html__('Advertizment 300x600', 'propertya'),
                    'calculator' => esc_html__('Mortgage Calculator', 'propertya'),

                ),
                'disabled' => array(),
            ),
        ),array(
            'id'       => 'prop_enable_wtsap',
            'type'     => 'switch',
            'title'    => esc_html__( 'Enable whatsapp button on detail page', 'propertya' ),
            'default'  => true,
        ),
        array(
            'id' => 'prop_wtsap_txt',
            'type' => 'text',
            'title' => esc_html__('message', 'propertya'),
            'default' => esc_html__( 'Hello i am intrested in [ Rent Home ]', 'propertya' ),
            'desc' => esc_html__( 'Default message you want to show', 'propertya' ),
            'required' => array('prop_enable_wtsap', '=', true),
        ),
        array(
            'id' => 'prop_sidebar_addr',
            'type' => 'text',
            'title' => esc_html__('Listing Address Section', 'propertya'),
            'default' => esc_html__('Listing Address', 'propertya'),
        ),
        array(
            'id' => 'prop_sidebar_stats',
            'type' => 'text',
            'title' => esc_html__('Listing Stats Section', 'propertya'),
            'default' => esc_html__('Statics Info', 'propertya'),
        ),
        array(
            'id' => 'prop_sidebar_featured',
            'type' => 'text',
            'title' => esc_html__('Featured Listings Section', 'propertya'),
            'default' => esc_html__('Featured Listings', 'propertya'),
        ),
        array(
            'id' => 'prop_sidebar_contact_seller',
            'type' => 'text',
            'title' => esc_html__('Contact Seller Section', 'propertya'),
            'default' => esc_html__('Contact Seller', 'propertya'),
        ),
        array(
            'id' => 'prop_sidebar_nearby',
            'type' => 'text',
            'title' => esc_html__('Near By Listings Section', 'propertya'),
            'default' => esc_html__('Near By Listings', 'propertya'),
        ),
        array(
            'id' => 'prop_sidebar_banners',
            'type' => 'text',
            'title' => esc_html__('Advertizment Section', 'propertya'),
            'default' => esc_html__('Advertizment', 'propertya'),
        ),
        array(
            'id' => 'prop_sidebar_recently',
            'type' => 'text',
            'title' => esc_html__('Recently Listed Section', 'propertya'),
            'default' => esc_html__('Recently Listed', 'propertya'),
        ),
        array(
            'id' => 'prop_sidebar_mortgage',
            'type' => 'text',
            'title' => esc_html__('Mortgage Calculator Section', 'propertya'),
            'default' => esc_html__('Mortgage Calculator', 'propertya'),
        ),

        array(
            'id' => 'prop_contactauthor_sub',
            'type' => 'text',
            'title' => esc_html__('Contact Listing Author Subject', 'propertya'),
            'default' => esc_html__("You have a new message on  your listing", 'propertya'),
        ),
        array(
            'id' => 'prop_contactauthor_messages',
            'type' => 'editor',
            'title' => esc_html__('Contact Listing Author Message', 'propertya'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 30,
                'wpautop' => false,
            ),
            'desc' => esc_html__('%site_name% , %display_name%, %sender_name%,  %sender_email% , %sender_message%,  %listing_title%,  %listing_link% will be translated accordingly.', 'propertya'),
            'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
    <!-- LOGO -->
    <tr>
        <td bgcolor='#3CBEB2' align='center'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#3CBEB2' align='center' style='padding: 0px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
                        <h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hello %display_name%,</h1> <img src='".trailingslashit( get_template_directory_uri () ) . "libs/images/logo-4.png"."' width='' height='' alt='' style='display: block; border: 0px;padding-top: 25px;' />
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0;  font-size: 18px !important;'>You've new Message. </p>
                    </td>
                </tr>
                 <!-- COPY -->
				 <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0;  font-size: 18px !important; padding-bottom:5px;'> <strong style='color:#111111'>Listing Title</strong> : %listing_title%</p>
						 <p style='margin: 0;  font-size: 18px !important;  padding-bottom:5px;'> <strong style='color:#111111'>Link</strong> : <a target='_blank' style='color: #3cbeb2;' href='%listing_link%'>%listing_link%</a></p>
                    </td>
                </tr>
                 <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
						 <p style='margin: 0;  font-size: 18px !important;  padding-bottom:5px;'> <strong style='color:#111111'>Sender Name</strong> : %sender_name%</p>
                        <p style='margin: 0;  font-size: 18px !important;  padding-bottom:5px;'> <strong style='color:#111111'>Sender Email</strong> : %sender_email%</p>
                        <p style='margin: 0;  font-size: 18px !important;  padding-bottom:5px;'> <strong style='color:#111111'>Contact Number</strong> : %sender_number%</p>
                    </td>
                </tr>
				 <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0; font-size: 18px !important; ' ><strong style='color: #111111;'>Message:</strong>  %sender_message% </p>
                    </td>
                </tr>
                <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
                    </td>
                </tr>
                <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service.<br>Scriptsbundle Team</p>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                        <h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
                        <p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
                        <p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
                    </td>
                </tr>
            </table>
            
        </td>
    </tr>
</table>
</body>"
        ),
        array(
            'id'       => 'ploc-section',
            'type'     => 'section',
            'title'    => esc_html__( 'Location Level Section', 'propertya' ),
            'subtitle' => esc_html__( 'Location level text eg country,state town etc.', 'propertya' ),
            'indent'   => true,
        ),

        array(
            'id' => 'prop_loc_level1',
            'type' => 'text',
            'title' => esc_html__('Location Level 1', 'propertya'),
            'default' => esc_html__('Country', 'propertya'),
        ),

        array(
            'id' => 'prop_loc_level2',
            'type' => 'text',
            'title' => esc_html__('Location Level 2', 'propertya'),
            'default' => esc_html__('State', 'propertya'),
        ),
        array(
            'id' => 'prop_loc_level3',
            'type' => 'text',
            'title' => esc_html__('Location Level 3', 'propertya'),
            'default' => esc_html__('City', 'propertya'),
        ),
        array(
            'id' => 'prop_loc_level4',
            'type' => 'text',
            'title' => esc_html__('Location Level 4', 'propertya'),
            'default' => esc_html__('Town ', 'propertya'),
        ),


    )
));

Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Statistics Graph', "propertya" ),
    'id'         => 'prop_statistics_pg',
    'desc'       => '',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'prop_stats_days',
            'type'     => 'text',
            'title'    => esc_html__( 'Number Of Days', 'propertya' ),
            'desc'	=> esc_html__( 'How many days will shown on the chart!: .', 'propertya' ),
            'default'  =>  20,
        ),
        array(
            'id'		=> 'prop_chart_type',
            'type'		=> 'select',
            'title'		=> esc_html__( 'Chart Type', 'propertya' ),
            'options'	=> array(
                'bar'	=> esc_html__( 'Bar Chart', 'propertya' ),
                'line'			=> esc_html__( 'Line Chart', 'propertya' )
            ),
            'default'	=> 'bar',
        ),

        array(
            'id' => 'prop_chart_bg',
            'type' => 'color_rgba',
            'title' => __('Background Color For Chart', 'propertya'),
            'default' => array(
                'color' => '#00aeef',
                'alpha' => '0.2'
            ),
            'validate' => 'colorrgba',
            'desc'	=> esc_html__( 'Defualt color: rgba(0, 174, 239, 0.2)', 'propertya' ),
        ),

        array(
            'id' => 'prop_chart_border',
            'type' => 'color',
            'title' => esc_html__('Border Color', 'propertya'),
            'subtitle' => esc_html__('Graph Border Color (default: #00aeef).', 'propertya'),
            'transparent' => false,
            'default' => '#00aeef',
            'validate' => 'color',
        ),
    )
));

Redux::setSection( $opt_name, array(
    'title'  => esc_html__( 'Yelp Nearby Places', 'propertya' ),
    'id'     => 'prop_yelp',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'prop_yelp_api_key',
            'type'     => 'text',
            'title'    => esc_html__( 'Yelp API Key', 'propertya' ),
            'desc'     => wp_kses(__('How to Generate API Key! <a target="_blank" href="//www.yelp.com/developers/v3/manage_app">https://www.yelp.com/developers/v3/manage_app</a>', 'propertya'), ''),
        ),
        array(
            'id'       => 'prop_yelp_api_secret',
            'type'     => 'text',
            'title'    => esc_html__( 'Yelp API Key Secret', 'propertya' ),
            'desc'     => wp_kses(__('How to Generate API Key! <a target="_blank" href="//www.yelp.com/developers/v3/manage_app">https://www.yelp.com/developers/v3/manage_app</a>', 'propertya'), ''),
        ),
        array(
            'id'       => 'prop_yelp_term',
            'type'     => 'select',
            'multi'    => true,
            'title'    => esc_html__( 'Select Yelp Terms', 'propertya' ),
            'options'  => array (
                'active' => esc_html__('Active Life', 'propertya' ),
                'arts' => esc_html__('Arts & Entertainment', 'propertya' ),
                'auto' => esc_html__('Automotive', 'propertya' ),
                'beautysvc' => esc_html__('Beauty & Spas', 'propertya' ),
                'education' => esc_html__('Education', 'propertya' ),
                'eventservices' => esc_html__('Event Planning & Services', 'propertya' ),
                'financialservices' => esc_html__('Financial Services', 'propertya' ),
                'food' => esc_html__('Food', 'propertya' ),
                'health' => esc_html__('Health & Medical', 'propertya' ),
                'homeservices' => esc_html__('Home Services ', 'propertya' ),
                'hotelstravel' => esc_html__('Hotels & Travel', 'propertya' ),
                'localflavor' => esc_html__('Local Flavor', 'propertya' ),
                'localservices' => esc_html__('Local Services', 'propertya' ),
                'massmedia' => esc_html__('Mass Media', 'propertya' ),
                'nightlife' => esc_html__('Nightlife', 'propertya' ),
                'pets' => esc_html__('Pets', 'propertya' ),
                'professional' => esc_html__('Professional Services', 'propertya' ),
                'publicservicesgovt' => esc_html__('Public Services & Government', 'propertya' ),
                'realestate' => esc_html__('Real Estate', 'propertya' ),
                'religiousorgs' => esc_html__('Religious Organizations', 'propertya' ),
                'restaurants' => esc_html__('Restaurants', 'propertya' ),
                'shopping' => esc_html__('Shopping', 'propertya' ),
            ),
            'default' => array('hotelstravel', 'auto', 'shopping', 'realestate'),
        ),
        array(
            'id'       => 'prop_yelp_result_limit',
            'type'     => 'text',
            'title'    => esc_html__( 'Yelp Result Limit', 'propertya' ),
            'default' => 4,
        ),
        array(
            'id'       => 'yelp_dist_unit',
            'type'     => 'select',
            'multi'    => false,
            'title'    => esc_html__( 'Yelp Distance Unit', 'propertya' ),
            'options'  => array (
                'miles' => esc_html__( 'Miles', 'propertya' ),
                'feet' => esc_html__( 'Feet', 'propertya' ),
                'yards' => esc_html__( 'Yards', 'propertya' ),
                'kilometers' => esc_html__( 'Kilometers', 'propertya' ),
            ),
            'default' => 'kilometers',
        ),

        array(
            'id'    => 'yelp_notifiy',
            'type'  => 'info',
            'style' => 'critical',
            'title' => esc_html__('Yelp Fusion API Daily Access Limit!', 'propertya'),
            'icon'  => 'el el-question-sign',
            'desc'  => esc_html__( "Yelp has daily 5,000 API calls per 24 hours limit. You can cache yelp data by selecting number of hours per call. It will improve your web speed and response. ", 'propertya')
        ),
        array(
            'id'        => 'prop_yelp_cache_limit',
            'type'      => 'slider',
            'title'     => esc_html__('Yelp Data Cache Hours', 'propertya'),
            'subtitle'  => esc_html__('Data will be cache for.', 'propertya'),
            'desc'      => esc_html__('It means on a single API call data will be save for selected number of hours', 'propertya'),
            "default"   => 6,
            "min"       => 1,
            "step"      => 1,
            "max"       => 24,
            'display_value' => 'text'
        ),
    )
));

Redux::setSection( $opt_name, array(
    'title'  => esc_html__( 'Walkscore', 'propertya' ),
    'id'     => 'prop_walk',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'prop_walk_api_key',
            'type'     => 'text',
            'title'    => esc_html__( 'Yelp Walkscore API Key', 'propertya' ),
            'subtitle' => esc_html__('Walk Score is supported in the United States, Canada, Australia, and New Zealand.', 'propertya'),
            'desc'     => wp_kses(__('How to Generate API Key! <a target="_blank" href="https://www.walkscore.com/professional/api.php">https://www.walkscore.com/professional/api.php</a>', 'propertya'), ''),
        ),
    )
));
Redux::setSection( $opt_name, array(
    'title'  => esc_html__( 'Schedule A Tour', 'propertya' ),
    'id'     => 'prop_schedule',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(

        array(
            'id' => 'prop_schedule_sub',
            'type' => 'text',
            'title' => esc_html__('Schedule a Tour Subject', 'propertya'),
            'default' => esc_html__("Schedule a meeting?", 'propertya'),
        ),
        array(
            'id' => 'prop_schedule_message',
            'type' => 'editor',
            'title' => esc_html__('Schedule a Tour Message', 'propertya'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 30,
                'wpautop' => false,
            ),
            'desc' => esc_html__('%site_name% , %display_name%, %meeting_date%, %sender_name%,  %sender_email% ,  %sender_contactno%,  %sender_message%,  %listing_title%,  %listing_link% will be translated accordingly.', 'propertya'),
            'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
    <!-- LOGO -->
    <tr>
        <td bgcolor='#3CBEB2' align='center'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#3CBEB2' align='center' style='padding: 0px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
                        <h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hello %display_name%,</h1> <img src='".trailingslashit( get_template_directory_uri () ) . "libs/images/logo-4.png"."' width='' height='' alt='' style='display: block; border: 0px;padding-top: 25px;' />
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0;  font-size: 18px !important;'>You have been contacted for a meeting. </p>
                    </td>
                </tr>
                 <!-- COPY -->
				 <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0;  font-size: 18px !important; padding-bottom:5px;'> <strong style='color:#111111'>Listing Title</strong> : %listing_title%</p>
						 <p style='margin: 0;  font-size: 18px !important;  padding-bottom:5px;'> <strong style='color:#111111'>Link</strong> : <a target='_blank' style='color: #3cbeb2;' href='%listing_link%'>%listing_link%</a></p>
                    </td>
                </tr>
                 <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0;  font-size: 18px !important; padding-bottom:5px;'> <strong style='color:#111111'>Meeting Date</strong> : %meeting_date%</p>
						 <p style='margin: 0;  font-size: 18px !important; padding-bottom:5px;'> <strong style='color:#111111'>Meeting Time</strong> : %meeting_time%</p>
						 <p style='margin: 0;  font-size: 18px !important;  padding-bottom:5px;'> <strong style='color:#111111'>Sender Name</strong> : %sender_name%</p>
                        <p style='margin: 0;  font-size: 18px !important;  padding-bottom:5px;'> <strong style='color:#111111'>Your Email</strong> : %sender_email%</p>
						<p style='margin: 0;  font-size: 18px !important;  padding-bottom:5px;'> <strong style='color:#111111'>Contact Number</strong> : %sender_contactno%</p>
                    </td>
                </tr>
				 <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0; font-size: 18px !important; ' ><strong style='color: #111111;'>Message:</strong>  %sender_message% </p>
                    </td>
                </tr>
                <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
                    </td>
                </tr>
                <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service.<br>Scriptsbundle Team</p>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                        <h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
                        <p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
                        <p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
                    </td>
                </tr>
            </table>
            
        </td>
    </tr>
</table>
</body>"
        ),

    )
));

Redux::setSection( $opt_name, array(
    'title'  => esc_html__( 'Similar Listings', 'propertya' ),
    'id'     => 'prop_simi_limits',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'        => 'prop_simi_listinglimits',
            'type'      => 'slider',
            'title'     => esc_html__('Similar Listing Limit', 'propertya'),
            'subtitle'  => esc_html__('No of listings shown.', 'propertya'),
            "default"   => 5,
            "min"       => 1,
            "step"      => 1,
            "max"       => 20,
            'display_value' => 'text'
        ),
    )
));
Redux::setSection( $opt_name, array(
    'title'  => esc_html__( 'Mortgage Calculator', 'propertya' ),
    'id'     => 'prop_sidebar_mortgage',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'prop_mortgage_currency',
            'type' => 'text',
            'title' => esc_html__('Default Currency Symbol', 'propertya'),
            'default' => '$',
        ),

        array(
            'id' => 'prop_mortgage_initial',
            'type' => 'text',
            'title' => esc_html__('Initial Value Field', 'propertya'),
            'default' => esc_html__('Initial Value', 'propertya')
        ),

        array(
            'id' => 'prop_mortgage_initial_hint',
            'type' => 'text',
            'title' => esc_html__('Initial Value Field Hint', 'propertya'),
            'default' => esc_html__('Estimated property value or loan amount', 'propertya')
        ),

        array(
            'id' => 'prop_mortgage_downpayment',
            'type' => 'text',
            'title' => esc_html__('Down Payment Field', 'propertya'),
            'default' => esc_html__('Down Payment', 'propertya')
        ),

        array(
            'id' => 'prop_mortgage_downpayment_hint',
            'type' => 'text',
            'title' => esc_html__('Down Payment Field Hint', 'propertya'),
            'default' => esc_html__('Before the first payment period', 'propertya')
        ),

        array(
            'id' => 'prop_mortgage_intrest',
            'type' => 'text',
            'title' => esc_html__('Interest Rate Field', 'propertya'),
            'default' => esc_html__('Interest Rate', 'propertya')
        ),

        array(
            'id' => 'prop_mortgage_intrest_hint',
            'type' => 'text',
            'title' => esc_html__('Interest Rate Field Hint', 'propertya'),
            'default' => esc_html__('The average expected interest in % percentage', 'propertya')
        ),

        array(
            'id' => 'prop_mortgage_term',
            'type' => 'text',
            'title' => esc_html__(' Mortgage Term Field', 'propertya'),
            'default' => esc_html__('Loan or Mortgage term', 'propertya')
        ),

        array(
            'id' => 'prop_mortgage_term_hint',
            'type' => 'text',
            'title' => esc_html__('Mortgage Term Field Hint', 'propertya'),
            'default' => esc_html__('Repayment payment in years', 'propertya')
        ),

        array(
            'id' => 'prop_mortgage_btn',
            'type' => 'text',
            'title' => esc_html__('Button Text', 'propertya'),
            'default' => esc_html__('Generate Report', 'propertya')
        ),

    )
));

/* ------------------ Search Sections ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Search Pages', 'propertya'),
    'id' => 'prop_search_pages',
    'desc' => '',
    'icon' => 'el el-star-empty',
    'fields' => array(
    )
));
/* ------------------ Agency Search Page ----------------------- */
Redux::setSection( $opt_name, array(
    'title'  => esc_html__( 'Agency Search Page', 'propertya' ),
    'id'     => 'prop_agency_search_page',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'prop_ag_search_layout',
            'type' => 'image_select',
            'title' => esc_html__('Agency Layout Styles', 'propertya'),
            'options' => array(
                'grid1' => array(
                    'alt' => esc_html__('Grid 1', 'propertya'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'libs/images/options/agency-1.png'
                ),
                'grid2' => array(
                    'alt' => esc_html__('Grid 2', 'propertya'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'libs/images/options/agency-2.png'
                ),
                'grid3' => array(
                    'alt' => esc_html__('Grid 3', 'propertya'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'libs/images/options/agency-3.png'
                ),
                'grid4' => array(
                    'alt' => esc_html__('Grid 4', 'propertya'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'libs/images/options/agency-4.png'
                ),
                'list1' => array(
                    'alt' => esc_html__('List 1', 'propertya'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'libs/images/options/agency-5.png'
                ),
                'list2' => array(
                    'alt' => esc_html__('List 2', 'propertya'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'libs/images/options/agency-6.png'
                ),
                'list3' => array(
                    'alt' => esc_html__('List 3', 'propertya'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'libs/images/options/agency-7.png'
                ),


            ),
            'default' => 'list2'
        ),

    )
));
/* ------------------ Agency Search Page ----------------------- */
Redux::setSection( $opt_name, array(
    'title'  => esc_html__( 'Agents Search Page', 'propertya' ),
    'id'     => 'prop_agent_search_page',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'prop_agent_search_layout',
            'type' => 'image_select',
            'title' => esc_html__('Agents Layout Styles', 'propertya'),
            'options' => array(
                'type1' => array(
                    'alt' => esc_html__('Grid 1', 'propertya'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'libs/images/options/agent-1.png'
                ),
                'type2' => array(
                    'alt' => esc_html__('Grid 2', 'propertya'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'libs/images/options/agent-2.png'
                ),

                'list1' => array(
                    'alt' => esc_html__('List 1', 'propertya'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'libs/images/options/agent-list-1.png'
                ),

            ),
            'default' => 'type1'
        ),
    )
));
/* ------------------ Agency Search Page ----------------------- */
Redux::setSection( $opt_name, array(
    'title'  => esc_html__( 'Property Search Page', 'propertya' ),
    'id'     => 'prop_listing_search_page',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(

        array(
            'id' => 'prop_listing_search_layout',
            'type' => 'image_select',
            'title' => esc_html__('Search Page Layout', 'propertya'),
            'desc' => esc_html__('Select search page layout type.', 'propertya'),
            'options' => array(
                'sidebar' => array(
                    'alt' => esc_html__('With Sidebar', 'propertya'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'libs/images/options/search_04.png',
                ),
                'map' => array(
                    'alt' => esc_html__('With Map', 'propertya'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'libs/images/options/search_05.png',
                ),
                'modern' => array(
                    'alt' => esc_html__('Modern', 'propertya'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'libs/images/options/search_03.png',
                ),
            ),
            'default' => 'sidebar'
        ),
        array(
            'id' => 'prop_listing_search_grids',
            'type' => 'image_select',
            'title' => esc_html__('Select Layout Type', 'propertya'),
            'desc' => esc_html__('Select search page layout type.', 'propertya'),
            'options' => array(
                'type1' => array(
                    'alt' => esc_html__('Grid Style 1', 'propertya'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'libs/images/options/p1.png',
                ),
                'type2' => array(
                    'alt' => esc_html__('Grid Style 2', 'propertya'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'libs/images/options/p2.png'
                ),
                'type3' => array(
                    'alt' => esc_html__('Grid Style 3', 'propertya'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'libs/images/options/p3.png'
                ),
                'type4' => array(
                    'alt' => esc_html__('Grid Style 4', 'propertya'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'libs/images/options/p4.png'
                ),
                'type5' => array(
                    'alt' => esc_html__('Grid Style 5', 'propertya'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'libs/images/options/p5.png'
                ),
                'type6' => array(
                    'alt' => esc_html__('Grid Style 6', 'propertya'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'libs/images/options/p6.png'
                ),
                'type7' => array(
                    'alt' => esc_html__('Grid Style 7', 'propertya'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'libs/images/options/p7.png'
                ),
                'list1' => array(
                    'alt' => esc_html__('List Style 1', 'propertya'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'libs/images/options/l1.png'
                ),
                'list2' => array(
                    'alt' => esc_html__('List Style 2', 'propertya'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'libs/images/options/l2.png'
                ),
                'list3' => array(
                    'alt' => esc_html__('List Style 3', 'propertya'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'libs/images/options/l3.png'
                ),
                'list4' => array(
                    'alt' => esc_html__('List Style 4', 'propertya'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'libs/images/options/l4.png'
                ),
                'list5' => array(
                    'alt' => esc_html__('List Style 5', 'propertya'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'libs/images/options/l5.png'
                ),
                'list6' => array(
                    'alt' => esc_html__('List Style 6', 'propertya'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'libs/images/options/l2.png'
                ),
            ),
            'default' => 'type3'
        ),
        array(
            'id' => 'prop_search_nearme',
            'type' => 'switch',
            'title' => esc_html__('Search By Near Me', 'propertya'),
            'default' => 1,
            'on' => esc_html__('Enabled', 'propertya'),
            'off' => esc_html__('Disabled', 'propertya'),
        ),
        array(
            'id' => 'prop_search_bytitle',
            'type' => 'switch',
            'title' => esc_html__('Search By Keyword', 'propertya'),
            'default' => 1,
            'on' => esc_html__('Enabled', 'propertya'),
            'off' => esc_html__('Disabled', 'propertya'),
        ),
        array(
            'id' => 'prop_search_bytype',
            'type' => 'switch',
            'title' => esc_html__('Search By Type', 'propertya'),
            'default' => 1,
            'on' => esc_html__('Enabled', 'propertya'),
            'off' => esc_html__('Disabled', 'propertya'),
        ),
        array(
            'id' => 'prop_search_byoffer',
            'type' => 'switch',
            'title' => esc_html__('Search By Offer Type', 'propertya'),
            'default' => 1,
            'on' => esc_html__('Enabled', 'propertya'),
            'off' => esc_html__('Disabled', 'propertya'),
        ),
        array(
            'id' => 'prop_search_bystatus',
            'type' => 'switch',
            'title' => esc_html__('Search By Status', 'propertya'),
            'default' => 1,
            'on' => esc_html__('Enabled', 'propertya'),
            'off' => esc_html__('Disabled', 'propertya'),
        ),
        array(
            'id' => 'prop_search_bylocation',
            'type' => 'switch',
            'title' => esc_html__('Search By Location', 'propertya'),
            'default' => 1,
            'on' => esc_html__('Enabled', 'propertya'),
            'off' => esc_html__('Disabled', 'propertya'),
        ),
        array(
            'id' => 'prop_search_byid',
            'type' => 'switch',
            'title' => esc_html__('Search By ID', 'propertya'),
            'default' => 1,
            'on' => esc_html__('Enabled', 'propertya'),
            'off' => esc_html__('Disabled', 'propertya'),
        ),
        array(
            'id' => 'prop_search_currency',
            'type' => 'switch',
            'title' => esc_html__('Search By Currency Type', 'propertya'),
            'default' => 1,
            'on' => esc_html__('Enabled', 'propertya'),
            'off' => esc_html__('Disabled', 'propertya'),
        ),
        array(
            'id' => 'prop_search_price',
            'type' => 'switch',
            'title' => esc_html__('Search By Price', 'propertya'),
            'default' => 1,
            'on' => esc_html__('Enabled', 'propertya'),
            'off' => esc_html__('Disabled', 'propertya'),
        ),
        array(
            'id' => 'prop_search_area',
            'type' => 'switch',
            'title' => esc_html__('Search By Area', 'propertya'),
            'default' => 1,
            'on' => esc_html__('Enabled', 'propertya'),
            'off' => esc_html__('Disabled', 'propertya'),
        ),
        array(
            'id' => 'prop_search_beds',
            'type' => 'switch',
            'title' => esc_html__('Search By Bedrooms', 'propertya'),
            'default' => 1,
            'on' => esc_html__('Enabled', 'propertya'),
            'off' => esc_html__('Disabled', 'propertya'),
        ),
        array(
            'id' => 'prop_search_baths',
            'type' => 'switch',
            'title' => esc_html__('Search By Bathrooms', 'propertya'),
            'default' => 1,
            'on' => esc_html__('Enabled', 'propertya'),
            'off' => esc_html__('Disabled', 'propertya'),
        ),
        array(
            'id' => 'prop_search_filters',
            'type' => 'switch',
            'title' => esc_html__('Search By Features ', 'propertya'),
            'default' => 1,
            'on' => esc_html__('Enabled', 'propertya'),
            'off' => esc_html__('Disabled', 'propertya'),
        ),

    )
));

/* ------------------ Advertisement Sections ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Advertisement', 'propertya'),
    'id' => 'prop_advert',
    'desc' => '',
    'icon' => 'el el-star-empty',
    'fields' => array(
        array(
            'id' => 'prop_listing_slot_1',
            'type' => 'textarea',
            'title' => esc_html__('Advertisement', 'propertya'),
            'subtitle' => esc_html__('720x90 or 468x60', 'propertya'),
            'desc' => esc_html__('Advertisement slot 1', 'propertya'),
            'default' => '<img class="img-fluid center-block" alt="' . esc_html__('Advertisement', 'propertya') . '" src="' . trailingslashit(get_template_directory_uri()) . 'libs/images/banner-1.png"> ',
        ),
        array(
            'id' => 'prop_listing_slot_2',
            'type' => 'textarea',
            'title' => esc_html__('Advertisement', 'propertya'),
            'subtitle' => esc_html__('720x90 or 468x60', 'propertya'),
            'desc' => esc_html__('Advertisement slot 2', 'propertya'),
            'default' => '<img class="img-fluid center-block alt="' . esc_html__('Advertisement', 'propertya') . '" src="' . trailingslashit(get_template_directory_uri()) . 'libs/images/banner-1.png"> ',
        ),
        array(
            'id' => 'prop_listing_slot_3',
            'type' => 'textarea',
            'title' => esc_html__('Banner 300x250', 'propertya'),
            'subtitle' => esc_html__('300x250', 'propertya'),
            'desc' => esc_html__('Advertisement Banner 300x250', 'propertya'),
            'default' => '<img class="img-fluid center-block alt="' . esc_html__('Advertisement', 'propertya') . '" src="' . trailingslashit(get_template_directory_uri()) . 'libs/images/300x250.jpg"> ',
        ),
        array(
            'id' => 'prop_listing_slot_4',
            'type' => 'textarea',
            'title' => esc_html__('Banner 300x600', 'propertya'),
            'subtitle' => esc_html__('300x600', 'propertya'),
            'desc' => esc_html__('Advertisement Banner 300x600', 'propertya'),
            'default' => '<img class="img-fluid center-block alt="' . esc_html__('Advertisement', 'propertya') . '" src="' . trailingslashit(get_template_directory_uri()) . 'libs/images/300-X-600.jpg"> ',
        ),

    )
));

/* ------------------ Listing Comments Reviews ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Listing Reviews', 'propertya'),
    'id' => 'prop_reviews',
    'desc' => '',
    'icon' => 'el el-star-empty',
    'fields' => array(
        array(
            'id' => 'prop_email_on_comment',
            'type' => 'switch',
            'title' => esc_html__('Send Email On Review', 'propertya'),
            'subtitle' => esc_html__('Send email when there is a new comment', 'propertya'),
            'default' => false,
        ),
        array(
            'id' => 'prop_reply_on_comment',
            'type' => 'switch',
            'title' => esc_html__('Send Email On Review Reply', 'propertya'),
            'subtitle' => esc_html__('Send email on reply', 'propertya'),
            'default' => false,
        ),
        array(
            'id' => 'prop_review_approval',
            'type' => 'button_set',
            'title' => esc_html__('Reviews Approved By', 'propertya'),
            'options' => array(
                '1' => esc_html__('Auto Approve', 'propertya'),
                '0' => esc_html__('Admin Approve', 'propertya'),
            ),
            'default' => '1'
        ),

        array(
            'id'        => 'prop_review_limit',
            'type'      => 'slider',
            'title'     => esc_html__('Reviews Limit On Listing Page', 'propertya'),
            "default"   => 5,
            "min"       => 1,
            "step"      => 1,
            "max"       => 30,
            'display_value' => 'text'
        ),

    )
));

Redux::setSection( $opt_name, array(
    'title'  => esc_html__( 'Reviews Email Templates', 'propertya' ),
    'id'     => 'prop_schedules',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(

        array(
            'id' => 'prop_notification_sub',
            'type' => 'text',
            'title' => esc_html__('Review Notification Subject', 'propertya'),
            'default' => esc_html__("New Review On Listing", 'propertya'),
        ),
        array(
            'id' => 'prop_notification_message',
            'type' => 'editor',
            'title' => esc_html__('Review Notification Message', 'propertya'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 30,
                'wpautop' => false,
            ),
            'desc' => esc_html__('%site_name% , %display_name%, %sender_name%, %rating_stars%,  %sender_review%,  %listing_title%,  %listing_link% will be translated accordingly.', 'propertya'),
            'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
    <tr>
        <td bgcolor='#3CBEB2' align='center'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#3CBEB2' align='center' style='padding: 0px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
                        <h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hello %display_name%,</h1> <img src='".trailingslashit( get_template_directory_uri () ) . "libs/images/logo-4.png"."' width='' height='' alt='' style='display: block; border: 0px;padding-top: 25px;' />
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0;  font-size: 18px !important;'>You have a new review on your listing. </p>
                    </td>
                </tr>
                 <!-- COPY -->
				 <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0;  font-size: 18px !important; padding-bottom:5px;'> <strong style='color:#111111'>Listing Title</strong> : %listing_title%</p>
						 <p style='margin: 0;  font-size: 18px !important;  padding-bottom:5px;'> <strong style='color:#111111'>Link</strong> : <a target='_blank' style='color: #3cbeb2;' href='%listing_link%'>%listing_link%</a></p>
                    </td>
                </tr>
                 <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
						 <p style='margin: 0;  font-size: 18px !important;  padding-bottom:5px;'> <strong style='color:#111111'>Sender Name</strong> : %sender_name%</p>
						<p style='margin: 0;  font-size: 18px !important;  padding-bottom:5px;'> <strong style='color:#111111'>Rating Stars</strong> : %rating_stars%</p>
                    </td>
                </tr>
				 <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0; font-size: 18px !important; ' ><strong style='color: #111111;'>Message:</strong>  %sender_review% </p>
                    </td>
                </tr>
                <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
                    </td>
                </tr>
                <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service.<br>Scriptsbundle Team</p>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                        <h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
                        <p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
                        <p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
                    </td>
                </tr>
            </table>
            
        </td>
    </tr>
</table>
</body>"
        ),

    )
));

/* ------------------URL Rewriting Settings ----------------------- */
Redux::setSection($opt_name, array(
    'title' => __('URL Rewriting', 'propertya'),
    'id' => 'prop_url_rewriting',
    'desc' => '',
    'icon' => 'el el-cogs',
    'fields' => array(
        array(
            'id' => 'prop_url_rewriting_enable',
            'type' => 'switch',
            'title' => __('Property Ads', 'propertya'),
            'default' => false,
        ),
        array(
            'id' => 'prop_ad_slug',
            'type' => 'text',
            'title' => __('Property ad slug', 'propertya'),
            'required' => array('prop_url_rewriting_enable', '=', '1'),
            'default' => "",
        ),
        array(
            'id' => 'prop_url_rewriting_enable_cat',
            'type' => 'switch',
            'title' => __('Ads Category', 'propertya'),
            'default' => false,
        ),
        array(
            'id' => 'prop_cat_slug',
            'type' => 'text',
            'title' => __('Property category slug', 'propertya'),
            'subtitle' => __('Make it final before go live', 'propertya'),
            'desc' => __('After changing slug the pervious link will be throw 404 page not found.', 'propertya'),
            'required' => array('prop_url_rewriting_enable_cat', '=', '1'),
            'default' => "",
        ),
        array(
            'id' => 'prop_url_rewriting_enable_location',
            'type' => 'switch',
            'title' => __('Ads Location', 'propertya'),
            'default' => false,
        ),
        array(
            'id' => 'prop_ad_location_slug',
            'type' => 'text',
            'title' => __('Property Ad location slug', 'propertya'),
            'subtitle' => __('Make it final before go live', 'propertya'),
            'desc' => __('After changing slug the pervious link will be throw 404 page not found.', 'propertya'),
            'required' => array('prop_url_rewriting_enable_location', '=', '1'),
            'default' => "",
        ),
        array(
            'id' => 'prop_url_rewriting_enable_ad_tags',
            'type' => 'switch',
            'title' => __('Ads Tags', 'propertya'),
            'default' => false,
        ),
        array(
            'id' => 'prop_ad_tags_slug',
            'type' => 'text',
            'title' => __('Property Ad Tags slug', 'propertya'),
            'subtitle' => __('Make it final before go live', 'propertya'),
            'desc' => __('After changing slug the pervious link will be throw 404 page not found.', 'propertya'),
            'required' => array('prop_url_rewriting_enable_ad_tags', '=', '1'),
            'default' => "",
        ),
            array(
            'id' => 'prop_agent_url_rewriting_enable',
            'type' => 'switch',
            'title' => __('Agents Ads', 'propertya'),
            'default' => false,
        ),
        array(
            'id' => 'prop_agent_ad_slug',
            'type' => 'text',
            'title' => __('Agent ad slug', 'propertya'),
            'required' => array('prop_agent_url_rewriting_enable', '=', '1'),
            'default' => "",
        ),

        array(
            'id' => 'prop_agent_url_rewriting_enable_typ',
            'type' => 'switch',
            'title' => __('Agents Category', 'propertya'),
            'default' => false,
        ),
        array(
            'id' => 'prop_agent_typ_slug',
            'type' => 'text',
            'title' => __('agent type slug', 'propertya'),
            'subtitle' => __('Make it final before go live', 'propertya'),
            'desc' => __('After changing slug the pervious link will be throw 404 page not found.', 'propertya'),
            'required' => array('prop_agent_url_rewriting_enable_typ', '=', '1'),
            'default' => "",
        ),
        array(
            'id' => 'prop_agent_url_rewriting_enable_location',
            'type' => 'switch',
            'title' => __('Agets Location', 'propertya'),
            'default' => false,
        ),
        array(
            'id' => 'prop_agent_ad_location_slug',
            'type' => 'text',
            'title' => __('Property Ad location slug', 'propertya'),
            'subtitle' => __('Make it final before go live', 'propertya'),
            'desc' => __('After changing slug the pervious link will be throw 404 page not found.', 'propertya'),
            'required' => array('prop_agent_url_rewriting_enable_location', '=', '1'),
            'default' => "",
        ),
      array(
            'id' => 'agency_url_rewriting_enable',
            'type' => 'switch',
            'title' => __('Agency Ads', 'propertya'),
            'default' => false,
        ),
        array(
            'id' => 'agency_ad_slug',
            'type' => 'text',
            'title' => __('Agency ad slug', 'propertya'),
            'required' => array('agency_url_rewriting_enable', '=', '1'),
            'default' => "",
        ),

        array(
            'id' => 'agency_url_rewriting_enable_loc',
            'type' => 'switch',
            'title' => __('Agency Location', 'propertya'),
            'default' => false,
        ),
        array(
            'id' => 'agency_loc_slug',
            'type' => 'text',
            'title' => __('agency Location slug', 'propertya'),
            'subtitle' => __('Make it final before go live', 'propertya'),
            'desc' => __('After changing slug the pervious link will be throw 404 page not found.', 'propertya'),
            'required' => array('agency_url_rewriting_enable_loc', '=', '1'),
            'default' => "",
        ),  
    )
));


/* ------------------ Price & Currency Settings ----------------------- */
Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Price & Currency', 'propertya' ),
    'id'         => 'prop_price_curr',
    'desc'       => '',
    'icon' => 'el el-globe',
    'fields'     => array(
        array(
            'id'       => 'prop_currency_mode',
            'type'     => 'button_set',
            'title'    => __('Currency Mode', 'propertya'),
            'desc'     => __('Select currency type.', 'propertya'),
            //Must provide key => value pairs for options
            'options' => array(
                '1' => 'Single Currency',
                '2' => 'Multi Currency',
            ),
            'default' => '1'
        ),
        array(
            'id' => 'prop_single_currency',
            'type' => 'text',
            'title' => esc_html__('Currency Symbol ', 'propertya'),
            'desc'  => esc_html__( 'Use currency symbol only eg ($)', 'propertya' ),
            'default' => '$',
            // 'required' => array('prop_currency_mode', '=', 1),
        ),
        array(
            'id' => 'property_opt_currency_default',
            'type' => 'select',
            'data' => 'terms',
            'args' => array('taxonomies' => 'property_currency', 'hide_empty' => false),
            'title' => esc_html__('Default Selected Currency', 'propertya'),
            'subtitle' => esc_html__('While posting ad in multi-currency', 'propertya'),
            'default' => '',
            'required' => array('prop_currency_mode', '=', 2),
        ),
        array(
            'id'       => 'prop_enable_currency_switcher',
            'type'     => 'switch',
            'title'    => esc_html__( 'Enable Currency Switcher', 'propertya' ),
            'default'  => false,
        ),
        array(
            'id' => 'prop_single_currency_code',
            'type' => 'text',
            'title' => esc_html__('Default Currency Code', 'propertya'),
            'default' => 'USD',
            'desc'  => esc_html__( 'Currency Code is required for currency switcher eg : USD', 'propertya' ),
        ),
        array(
            'id'       => 'prop_enable_currency_api_key',
            'type'     => 'text',
            'title'    => esc_html__( 'ExchangeRate-API Key', 'propertya' ),
            'default'  => '',
            'required' => array('prop_enable_currency_switcher', '=', '1'),
            'desc'  =>  sprintf( __( '<a href="%s">Get API Key</a>', 'propertya' ), 'https://www.exchangerate-api.com/'),
        ),
        array(
            'id'        => 'prop_opt_currency_switcher_languages',
            'type'      => 'text',
            'title'     => esc_html__( 'Select Currencies', 'propertya' ),
            'default'   => 'EUR|AUD|PKR|INR|TRY|BOB',
            'required' => array('prop_enable_currency_switcher', '=', '1'),
            'desc'  =>  sprintf( __( 'Use | sign to ad more currencies eg: EUR|AUD|PKR|INR|TRY|BOB <a href="%s">All Supported Currencies</a>', 'propertya' ), 'https://www.exchangerate-api.com/docs/supported-currencies'),
        ),
        array(
            'id'        => 'property_opt_currency_position',
            'type'      => 'select',
            'title'     => esc_html__( 'Where to Show the currency?', 'propertya' ),
            'options'   => array(
                'before'    => esc_html__( 'Before', 'propertya' ),
                'after'         => esc_html__( 'After', 'propertya' )
            ),
            'default'   => 'before',
        ),
        array(
            'id'        => 'property_opt_decimals',
            'type'      => 'select',
            'title'     => esc_html__( 'Number of decimal points?', 'propertya' ),
            'options'   => array(
                '0' => '0',
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7',
                '8' => '8',
                '9' => '9',
                '10' => '10',
            ),
            'default'   => '0',
        ),
        array(
            'id' => 'property_opt_decimals_separator',
            'type' => 'text',
            'title' => esc_html__('Decimals Separator', 'propertya'),
            'desc'  => esc_html__( 'Provide the decimal point separator eg: .', 'propertya' ),
            'default' => '.',
        ),
        array(
            'id' => 'property_opt_thousand_separator',
            'type' => 'text',
            'title' => esc_html__('Thousands Separator', 'propertya'),
            'desc'  => esc_html__( 'Provide the Thousands point separator eg: ,', 'propertya' ),
            'default' => ',',
        ),
        array(
            'id'       => 'property_opt_id',
            'type'     => 'text',
            'title'    => esc_html__( 'Property Ref. No', 'propertya' ),
            'default'  => 'RH-{ID}-Sonu' ,
            'desc'     => '<strong>Important: </strong>' . esc_html__( 'Please use {ID} in your pattern as it will be replaced by the Property ID.', 'propertya' ),
        ),
    )
) );

/* ------------------ Dashboard Settings ----------------------- */
Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'Authorization', 'propertya' ),
    'id'               => 'dashboard-auth',
    'desc'             => esc_html__( 'Here you can setup authorization page settings', 'propertya' ),
    'customizer_width' => '400px',
    'icon'             => 'el el-torso',
    'fields'     => array(
        array(
            'id'       => 'prop_enable_registration',
            'type'     => 'switch',
            'title'    => esc_html__( 'Enable Frontend Registration', 'propertya' ),
            'default'  => true,
        ),
        array(
            'id'       => 'prop_enable_head_foot',
            'type'     => 'switch',
            'title'    => __( 'Enable Header & Footer', 'propertya' ),
            'default'  => false,
            'desc'             => esc_html__( 'You can enable or disable header & footer on sign up/sign in page.', 'propertya' ),
        ),
        array(
            'id' => 'prop_terms_page',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('Term of Services Page Link', 'propertya'),
            'desc' => esc_html__('Select page you want to show.', 'propertya'),
            'default' => '#',
        ),
        array(
            'id'       => 'prop_success_page',
            'type'     => 'select',
            'data'     => 'pages',
            'multi'    => false,
            'title'    => esc_html__( 'Author Dashboard Page', 'propertya' ),
            'desc' => esc_html__('Redirect user after successful login & registration.', 'propertya'),
        ),
        array(
            'id'       => 'prop_auth_def_img',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__('Defualt Image', 'propertya' ),
            'compiler' => 'true',
            'default'  => array( 'url' => trailingslashit( get_template_directory_uri () ) . 'libs/images/defualt-935x754.png' ),
        ),
    )

));

/* ------------------ Sign Up Page  ----------------------- */
Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'Sign Up Page', 'propertya' ),
    'id'               => 'real-singup',
    'subsection'       => true,
    'customizer_width' => '450px',
    'desc'             =>'',
    'icon' => 'el el-unlock',
    'fields'     => array(
        array(
            'id'       => 'psection-start',
            'type'     => 'section',
            'title'    => esc_html__( 'Background Image Section', 'propertya' ),
            'subtitle' => esc_html__( 'Select background image & text.', 'propertya' ),
            'indent'   => true,
        ),
        array(
            'id'       => 'prop_signup_bg',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__( 'Background Image', 'propertya' ),
            'compiler' => 'true',
            'default'  => array( 'url' => trailingslashit( get_template_directory_uri () ) . 'libs/images/signup.jpg' ),
        ),
        array(
            'id'       => 'p_signup_first',
            'type'     => 'text',
            'title'    => esc_html__( 'Tagline Title', 'propertya' ),
            'default' => esc_html__( 'Pakistan’s smarter', 'propertya' ),
        ),
        array(
            'id'       => 'p_signup_second',
            'type'     => 'text',
            'title'    => esc_html__( 'Main Title', 'propertya' ),
            'default' => esc_html__( 'Largest Property Buying & Selling Hub', 'propertya' ),
        ),
        array(
            'id'     => 'psection-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),

        array(
            'id'       => 'prsection-start',
            'type'     => 'section',
            'title'    => esc_html__( 'Form Section', 'propertya' ),
            'indent'   => true,
        ),

        array(
            'id' => 'prop_signup_form_txt',
            'type' => 'text',
            'title' => esc_html__('Form Text', 'propertya'),
            'default' => esc_html__( 'Register With Us', 'propertya' ),
        ),
        array(
            'id' => 'prop_signup_slogan',
            'type' => 'text',
            'title' => esc_html__('Slogan Text', 'propertya'),
            'default' => esc_html__('Sign up to use your dashboard its fast and free. Showcase your brand, enhance your listings and much more.', 'propertya'),
        ),
        array(
            'id'     => 'prsection-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),


    )
) );
/* ------------------ Sign In Page  ----------------------- */
Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'Sign In Page', 'propertya' ),
    'id'               => 'real-singin',
    'subsection'       => true,
    'customizer_width' => '450px',
    'desc'             =>'',
    'icon' => 'el el-lock',
    'fields'     => array(



        array(
            'id'       => 'psection-startin',
            'type'     => 'section',
            'title'    => esc_html__( 'Background Image Section', 'propertya' ),
            'subtitle' => esc_html__( 'Select background image & text.', 'propertya' ),
            'indent'   => true,
        ),
        array(
            'id'       => 'prop_signin_bg',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__( 'Background Image', 'propertya' ),
            'compiler' => 'true',
            'default'  => array( 'url' => trailingslashit( get_template_directory_uri () ) . 'libs/images/signup.jpg' ),
        ),
        array(
            'id'       => 'p_signin_first',
            'type'     => 'text',
            'title'    => esc_html__( 'Tagline Title', 'propertya' ),
            'default' => esc_html__( 'Pakistan’s smarter', 'propertya' ),
        ),
        array(
            'id'       => 'p_signin_second',
            'type'     => 'text',
            'title'    => esc_html__( 'Main Title', 'propertya' ),
            'default' => esc_html__( 'Largest Property Buying & Selling Hub', 'propertya' ),
        ),
        array(
            'id'     => 'psection-endin',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),

        array(
            'id'       => 'prsection-start',
            'type'     => 'section',
            'title'    => esc_html__( 'Form Section', 'propertya' ),
            'indent'   => true,
        ),

        array(
            'id' => 'prop_signin_form_txt',
            'type' => 'text',
            'title' => esc_html__('Form Text', 'propertya'),
            'default' => esc_html__( 'Sign In & Access Your Account', 'propertya' ),
        ),
        array(
            'id' => 'prop_signin_slogan',
            'type' => 'text',
            'title' => esc_html__('Slogan Text', 'propertya'),
            'default' => esc_html__('Sign up to use your dashboard its fast and free. Showcase your brand, enhance your listings and much more.', 'propertya'),
        ),
        array(
            'id'     => 'prssection-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),

        array(
            'id' => 'prop_signin_page',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('Select Sign In Page', 'propertya'),
            'desc' => esc_html__('Select page you want to show.', 'propertya'),
            'default' => '#',
            'required' => array('prop_other_btn', '=', true),
        ),
    )
) );

/* ------------------ Social Logins  ----------------------- */
Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'Social Authentication', 'propertya' ),
    'id'               => 'prop_social',
    'subsection'       => true,
    'customizer_width' => '450px',
    'desc'             =>'',
    'icon' => 'el el-lock',
    'fields'     => array(
        array(
            'id'       => 'prop_enable_social',
            'type'     => 'switch',
            'title'    => esc_html__( 'Enable Social Login & Registration', 'propertya' ),
            'default'  => false,
        ),
        array(
            'id' => 'prop_fb_key',
            'type' => 'text',
            'title' => esc_html__('Facebook Client ID', 'propertya'),
            'desc' => sprintf(__( '<a href="%s">How to Make</a>', 'propertya' ), esc_url('https://developers.facebook.com/?advanced_app_create=true')),
            'required' => array( 'prop_enable_social', '=', true ),
        ),
        array(
            'id' => 'prop_google_key',
            'type' => 'text',
            'title' => esc_html__('Google Client ID', 'propertya'),
            'desc' => sprintf(__( '<a href="%s">How to Make</a>', 'propertya' ), esc_url('https://developers.google.com/identity/sign-in/web/sign-in')),
            'required' => array( 'prop_enable_social', '=', true ),
        ),
        array(
            'id' => 'prop_redirect_uri',
            'type' => 'text',
            'title' => esc_html__('Redirect URI', 'propertya'),
            'desc' => esc_html__('Must be same URI while creating apps, it will be your web url.', 'propertya'),
            'required' => array( 'prop_enable_social', '=', true ),
        ),
    )
) );


/* ------------------ Social Logins  ----------------------- */
Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'Email Templates', 'propertya' ),
    'id'               => 'prop_register_email',
    'subsection'       => true,
    'customizer_width' => '450px',
    'desc'             =>'',
    'icon' => 'el el-lock',
    'fields'     => array(
        array(
            'id'       => 'prop_email_onregister',
            'type'     => 'switch',
            'title'    => esc_html__( 'Send Email On Registration', 'propertya' ),
            'default'  => true,
            'desc'     => esc_html__( 'So you want to send email on the time of registration.', 'propertya' ),
        ),
        array(
            'id'       => 'prop_email_sendto_admin',
            'type'     => 'switch',
            'title'    => esc_html__( 'Send Email To Admin On Registration', 'propertya' ),
            'default'  => true,
            'desc'     => esc_html__( 'So you want to send email on the time of registration.', 'propertya' ),
            'required' => array(array('prop_email_onregister','equals','1')),
        ),
        array(
            'id' => 'prop_new_user_admin_sub',
            'type' => 'text',
            'title' => esc_html__('New User Email Template Subject For Admin', 'propertya'),
            'default' => esc_html__('New User Registration', 'propertya'),
            'required' => array( array('prop_email_onregister','equals','1'), array('prop_email_sendto_admin','equals','1')),
        ),
        array(
            'id' => 'prop_new_user_admin_message',
            'type' => 'editor',
            'title' => esc_html__('New User Email Template For Admin', 'propertya'),
            'required' => array( array('prop_email_onregister','equals','1'), array('prop_email_sendto_admin','equals','1')),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 20,
                'wpautop' => false,
            ),
            'desc' => esc_html__('%site_name% , %display_name%, %email% will be translated accordingly.', 'propertya'),
            'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
    <!-- LOGO -->
    <tr>
        <td bgcolor='#3CBEB2' align='center'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#3CBEB2' align='center' style='padding: 0px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
                        <h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hello Admin,</h1> <img src='".trailingslashit( get_template_directory_uri () ) . "libs/images/logo-4.png"."' width='' height='' alt='Your Logo Here' style='display: block; border: 0px;padding-top: 25px;' />
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0;  font-size: 18px !important;'>New user has registered on your site. </p>
                    </td>
                </tr>
                 
                <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
                    </td>
                </tr>
                <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service,<br>Scriptsbundle Team</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                        <h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
                        <p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
                        <p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
                    </td>
                </tr>
            </table>
            
        </td>
    </tr>
</table>
</body>"
        ),

        array(
            'id'       => 'prop_email_sendto_user',
            'type'     => 'switch',
            'title'    => esc_html__( 'Send Welocme Email To User On Registration', 'propertya' ),
            'default'  => true,
            'desc'     => esc_html__( 'So you want to send welcome eamil on the time of registration to user.', 'propertya' ),
            'required' => array(array('prop_email_onregister','equals','1')),
        ),

        array(
            'id' => 'prop_new_user_welcome_sub',
            'type' => 'text',
            'title' => esc_html__('Welcome Email Template Subject For Users', 'propertya'),
            'default' => esc_html__("We're Happy To Have You With Us", 'propertya'),
            'required' => array( array('prop_email_onregister','equals','1'), array('prop_email_sendto_user','equals','1')),
        ),
        array(
            'id' => 'prop_new_user_welcome_message',
            'type' => 'editor',
            'title' => esc_html__('Welcome Email Template For Users', 'propertya'),
            'required' => array( array('prop_email_onregister','equals','1'), array('prop_email_sendto_user','equals','1')),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 20,
                'wpautop' => false,
            ),
            'desc' => esc_html__('%site_name% , %display_name%, %email%, %password% will be translated accordingly.', 'propertya'),
            'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
    <!-- LOGO -->
    <tr>
        <td bgcolor='#3CBEB2' align='center'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#3CBEB2' align='center' style='padding: 0px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
                        <h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hello %display_name%,</h1> <img src='".trailingslashit( get_template_directory_uri () ) . "libs/images/logo-4.png"."' width='' height='' alt='' style='display: block; border: 0px;padding-top: 25px;' />
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0;  font-size: 18px !important;'>Welcome! We're glad you're here! You've successfully registered. </p>
                    </td>
                </tr>
                 <!-- COPY -->
                 <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0;  font-size: 18px !important; padding-bottom:5px;'> <strong style='color:#111111'>Your Username</strong> : %display_name%</p>
                        <p style='margin: 0;  font-size: 18px !important;  padding-bottom:5px;'> <strong style='color:#111111'>Your Email</strong> : %email%</p>
						<p style='margin: 0;  font-size: 18px !important;  padding-bottom:5px;'> <strong style='color:#111111'>Your Password</strong> : %password%</p>
                    </td>
                </tr>
                <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
                    </td>
                </tr>
                <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service.<br>Scriptsbundle Team</p>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                        <h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
                        <p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
                        <p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
                    </td>
                </tr>
            </table>
            
        </td>
    </tr>
</table>
</body>"
        ),

        //verification
        array(
            'id'       => 'propertya_new_user_email_verification',
            'type'     => 'switch',
            'title'    => esc_html__( 'Email Verification on Register', 'propertya' ),
            'default'  => false,
            'desc'     => esc_html__( 'Turn on this option if you want to have email verified at the time of registration.', 'propertya' ),
        ),
        array(
            'id' => 'propertya_new_user_email_verification_sub',
            'type' => 'text',
            'title' => esc_html__('Email Verification Template Subject', 'propertya'),
            'default' => esc_html__("Email Verification Subject", 'propertya'),
            'required' => array( array('propertya_new_user_email_verification','equals','1')),
        ),
        array(
            'id' => 'propertya_new_user_email_verification_message',
            'type' => 'editor',
            'title' => esc_html__('Email Verification Template Body ', 'propertya'),
            'required' => array( array('propertya_new_user_email_verification','equals','1')),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 20,
                'wpautop' => false,
            ),
            'desc' => esc_html__('%site_name% , %display_name%, %verification_link% will be translated accordingly.', 'propertya'),
            'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
                <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                    <!-- LOGO -->
                    <tr>
                        <td bgcolor='#3CBEB2' align='center'>
                            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                                <tr>
                                    <td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor='#3CBEB2' align='center' style='padding: 0px 10px 0px 10px;'>
                            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                                <tr>
                                    <td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
                                         <img src='".trailingslashit( get_template_directory_uri () ) . "/images/logo-dashboard.png"."' width='' height='' alt='' style='display: block; border: 0px;padding-top: 25px;' /><h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hi, %display_name%!</h1>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
                            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                                <tr>
                                    <td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
                                        <p style='margin: 0;  font-size: 18px !important;'>We have sent you this email in response to your registration on  <strong>%site_name%</strong> </p>
                                    </td>
                                </tr>
                                  <tr>
                                    <td bgcolor='#ffffff' align='left'>
                                        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                            <tr>
                                                <td bgcolor='#ffffff' align='center' style='padding: 20px 30px 20px 30px;'>
                                                    <table border='0' cellspacing='0' cellpadding='0'>
                                                        <tr>
                                                            <td align='center' style='border-radius: 3px;' bgcolor='#3CBEB2'><a href='%verification_link%' target='_blank' style='font-size: 20px; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid #3cbeb2; display: inline-block;'>Verify My Account</a>
                                                            </td>
                                                            
                                                        </tr>
                                                        <tr>
                                    <td bgcolor='#ffffff' align='left' style='padding: 20px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                                        <p style='margin: 0; font-size: 18px !important;' ><strong>Copyable Link :</strong> %verification_link%</p>
                                    </td>
                                </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr> <!-- COPY -->
                                <tr>
                                    <td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                                        <p style='margin: 0; font-size: 18px !important;' >We recommend that you keep your password secure and not share it with anyone. If you feel your password has been compromised, you can change it by going to your My Profile Page and clicking on the Change Password.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                                        <p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                                        <p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service.<br>Scriptsbundle Team</p>
                
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
                            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                                <tr>
                                    <td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                                        <h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
                                        <p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
                            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                                <tr>
                                    <td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
                                        <p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
                                    </td>
                                </tr>
                            </table>
                            
                        </td>
                    </tr>
                </table>
                </body>"
        ),





























        array(
            'id' => 'prop_new_user_reset_sub',
            'type' => 'text',
            'title' => esc_html__('Reset Password Template Subject', 'propertya'),
            'default' => esc_html__("Forgot Your Password", 'propertya'),
        ),
        array(
            'id' => 'prop_new_user_reset_message',
            'type' => 'editor',
            'title' => esc_html__('Reset Password Template For Users', 'propertya'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 20,
                'wpautop' => false,
            ),
            'desc' => esc_html__('%site_name% , %display_name%, %reset_link% will be translated accordingly.', 'propertya'),
            'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
    <!-- LOGO -->
    <tr>
        <td bgcolor='#3CBEB2' align='center'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#3CBEB2' align='center' style='padding: 0px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
                        <h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hi, %display_name%!</h1> <img src='".trailingslashit( get_template_directory_uri () ) . "libs/images/logo-4.png"."' width='' height='' alt='' style='display: block; border: 0px;padding-top: 25px;' />
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0;  font-size: 18px !important;'>We have sent you this email in response to your request to reset your password on <strong>%site_name%</strong> </p>
                    </td>
                </tr>
                  <tr>
                    <td bgcolor='#ffffff' align='left'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                            <tr>
                                <td bgcolor='#ffffff' align='center' style='padding: 20px 30px 20px 30px;'>
                                    <table border='0' cellspacing='0' cellpadding='0'>
                                        <tr>
                                            <td align='center' style='border-radius: 3px;' bgcolor='#3CBEB2'><a href='%reset_link%' target='_blank' style='font-size: 20px; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid #3cbeb2; display: inline-block;'>Reset My Password</a>
											</td>
											
                                        </tr>
										<tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 20px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0; font-size: 18px !important;' ><strong>Copyable Link :</strong> %reset_link%</p>
                    </td>
                </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr> <!-- COPY -->
				<tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0; font-size: 18px !important;' >We recommend that you keep your password secure and not share it with anyone. If you feel your password has been compromised, you can change it by going to your My Profile Page and clicking on the Change Email Password.</p>
                    </td>
                </tr>
                <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
                    </td>
                </tr>
                <tr>
                    <td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                        <p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service.<br>Scriptsbundle Team</p>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
                        <h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
                        <p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                <tr>
                    <td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
                        <p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
                    </td>
                </tr>
            </table>
            
        </td>
    </tr>
</table>
</body>"
        ),

    )
) );


/* ------------------ Price & Currency Settings ----------------------- */
Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Submit Property', 'propertya' ),
    'id'         => 'property_submit',
    'desc'       => '',
    'icon' => 'el el-globe',

) );

Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'General Settings', 'propertya' ),
    'id'         => 'property_general',
    'desc'       => '',
    'icon' => 'el el-cogs',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'property_title_lmt',
            'type'     => 'text',
            'title'    => esc_html__( 'Title Limit During Submission', 'propertya' ),
            'subtitle' => esc_html__( 'This must be numeric.', 'propertya' ),
            'desc'     => esc_html__( 'Total number of characters', 'propertya' ),
            'validate' => 'numeric',
            'default'  => '45',
        ),

        array(
            'id'       => 'property_badwords',
            'type'     => 'textarea',
            'title'    => esc_html__( 'Bad Words Filter', 'propertya' ),
            'subtitle' => esc_html__( 'comma separated', 'propertya' ),
            'placeholder'   => esc_html__( 'word1,word2', 'propertya' ),
            'desc'     => esc_html__( 'This words will be removed from Listings Title and Description', 'propertya' ),
            'default'  => '',
        ),
        array(
            'id'       => 'property_badwords_replace',
            'type'     => 'text',
            'title'    => esc_html__( 'Bad Words Replace Word', 'propertya' ),
            'desc'     => esc_html__( 'This words will be replace with above bad words list from Listings Title and Description', 'propertya' ),
            'default'  => '',
        ),

    )
));


/* ------------------ Show & Hide Form Fields ----------------------- */
Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'Show & Hide Fields', 'propertya' ),
    'id'               => 'show-hide',
    'subsection'       => true,
    'customizer_width' => '450px',
    'desc'             =>'',
    'icon' => 'el el-globe',
    'fields'     => array(
        array(
            'id'       => 'prop_show_hide_fields',
            'type'     => 'checkbox',
            'title'    => esc_html__( 'Multi Checkbox Option', 'propertya' ),
            'subtitle' => esc_html__( 'No validation can be done on this field type', 'propertya' ),
            'desc'     => esc_html__( 'This is the description field, again good for additional info.', 'propertya' ),
            //'options'  => propertya_form_fields(),
            'options'  => array
            (
                'property_type' => esc_html__('Property Type','propertya'),
                'offer_type' 	=> esc_html__('Offer Type','propertya'),
                'property_label' => esc_html__('Label','propertya'),
                'currecny_type' => esc_html__('Currency Type','propertya'),
                'property_price' => esc_html__('Property Price','propertya'),
                'snd_price' 	=> esc_html__('Second Price (Optional)','propertya'),
                'after_price' => esc_html__('After Price Label','propertya'),
                'property_area' => esc_html__('Area Size','propertya'),
                'area_prefix' => esc_html__('Area Size Prefix ','propertya'),
                'land_area' => esc_html__('Land Area','propertya'),
                'land_area_prefix' => esc_html__('Land Area Prefix','propertya'),
                'bedrooms' => esc_html__('Bedrooms','propertya'),
                'bathrooms' => esc_html__('Bathrooms','propertya'),
                'grages' => esc_html__('Garages','propertya'),
                'yearbuild' => esc_html__('Year Built','propertya'),
                'amenities' => esc_html__('Amenities and Features','propertya'),
                'video' => esc_html__('Video URL','propertya'),
                'virtual_tour' => esc_html__('360 Virtual Tour Iframe','propertya'),
                'desc' => esc_html__('Description Box','propertya'),
                'gallery' => esc_html__('Gallery','propertya'),
                'zip_code' => esc_html__('Zipcode','propertya'),
                'street_location' => esc_html__('Street Address','propertya'),
                'map' => esc_html__('Map','propertya'),
                'location' => esc_html__('Location (Country / State / Town)','propertya'),
                'floorplan' => esc_html__('Floor Plans','propertya'),
                'additional_fields' => esc_html__('Additional Fields','propertya'),
                'attachments' => esc_html__('Attachments','propertya'),
                'prop_subcats' => esc_html__('Custom Fields','propertya'),
                'prop_stats' => esc_html__('Statistics','propertya'),
            ),
            'default'  => array(
                'property_type' => '1',
                'offer_type' 	=> '1',
                'property_label' => '1',
                'currecny_type' => '1',
                'property_price' => '1',
                'snd_price' 	=> '1',
                'after_price' => '1',
                'property_area' => '1',
                'area_prefix' => '1',
                'land_area' => '1',
                'land_area_prefix' => '1',
                'bedrooms' => '1',
                'bathrooms' => '1',
                'grages' => '1',
                'yearbuild' => '1',
                'amenities' => '1',
                'video' => '1',
                'virtual_tour' => '1',
                'desc' => '1',
                'gallery' => '1',
                'zip_code' => '1',
                'street_location' => '1',
                'map' => '1',
                'location' => '1',
                'floorplan' => '1',
                'additional_fields' => '1',
                'attachments' => '1',
                'prop_subcats' => '1',
                'prop_stats' => '1',
            )
        ),
    )
) );
/* ------------------ Required Form Fields ----------------------- */
Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'Required Form Fields', 'propertya' ),
    'id'               => 'required_fields',
    'subsection'       => true,
    'customizer_width' => '450px',
    'desc'             =>'',
    'icon' => 'el el-globe',
    'fields'     => array(
        array(
            'id'       => 'prop_required_fields',
            'type'     => 'checkbox',
            'title'    => esc_html__( 'Form Required Fields', 'propertya' ),
            'subtitle' => esc_html__( 'Select the Mandatory Fields for property submission.', 'propertya' ),
            'desc'     => esc_html__( 'Select the Mandatory Fields for property submission.', 'propertya' ),
            //'options'  => propertya_form_fields(),
            'options'  => array
            (
                'property_type' => esc_html__('Property Type','propertya'),
                'offer_type' 	=> esc_html__('Offer Type','propertya'),
                'property_label' => esc_html__('Label','propertya'),
                'currecny_type' => esc_html__('Currency Type','propertya'),
                'property_price' => esc_html__('Property Price','propertya'),
                'snd_price' 	=> esc_html__('Second Price (Optional)','propertya'),
                'after_price' => esc_html__('After Price Label','propertya'),
                'property_area' => esc_html__('Area Size','propertya'),
                'area_prefix' => esc_html__('Area Size Prefix ','propertya'),
                'land_area' => esc_html__('Land Area','propertya'),
                'land_area_prefix' => esc_html__('Land Area Prefix','propertya'),
                'bedrooms' => esc_html__('Bedrooms','propertya'),
                'bathrooms' => esc_html__('Bathrooms','propertya'),
                'grages' => esc_html__('Garages','propertya'),
                'yearbuild' => esc_html__('Year Built','propertya'),
                'amenities' => esc_html__('Amenities and Features','propertya'),
                'video' => esc_html__('Video URL','propertya'),
                'virtual_tour' => esc_html__('360 Virtual Tour Iframe','propertya'),
                'desc' => esc_html__('Description Box','propertya'),
                'gallery' => esc_html__('Gallery','propertya'),
                'zip_code' => esc_html__('Zipcode','propertya'),
                'street_location' => esc_html__('Street Address','propertya'),
                'map' => esc_html__('Map','propertya'),
                'coordinates' => esc_html__('Coordinates','propertya'),
                'location' => esc_html__('Location (Country / State / Town)','propertya'),
                //'floorplan' => esc_html__('Floor Plans','propertya'),
                //'additional_fields' => esc_html__('Additional Fields','propertya'),
                'attachments' => esc_html__('Attachments','propertya'),
                'prop_subcats' => esc_html__('Custom Fields','propertya'),
            ),
            'default'  => array(
                'property_type' => '1',
                'offer_type' 	=> '1',
                'property_label' => '0',
                'property_price' => '1',
                'currecny_type' => '1',
                'snd_price' 	=> '0',
                'after_price' => '0',
                'property_area' => '1',
                'area_prefix' => '1',
                'land_area' => '1',
                'land_area_prefix' => '1',
                'bedrooms' => '1',
                'bathrooms' => '1',
                'grages' => '1',
                'yearbuild' => '1',
                'video' => '0',
                'virtual_tour' => '0',
                'desc' => '1',
                'gallery' => '1',
                'zip_code' => '0',
                'street_location' => '0',
                'map' => '0',
                'coordinates' => '0',
                'location' => '1',
                //'floorplan' => '0',
                //'additional_fields' => '0',
                'attachments' => '0',
                'prop_subcats' => '1',
            )
        ),
    )
) );

Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Form Fields Text', 'propertya' ),
    'id'         => 'dwt_listing_form_fields',
    'desc'       => '',
    'icon' => 'el el-cogs',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'p_listing_title',
            'type'     => 'section',
            'indent'   => true,
        ),
        array(
            'id'       => 'prop_field_title',
            'type'     => 'text',
            'title'    => esc_html__( 'Property Field Title', 'propertya' ),
            'default'  => esc_html__('Property Title','propertya')
        ),
        array(
            'id'       => 'prop_field_title_place',
            'type'     => 'text',
            'title'    => esc_html__( 'Property Field Placeholder', 'propertya' ),
            'default'  => esc_html__('Detached house for sale','propertya')
        ),
        array(
            'id'       => 'prop_desc_field',
            'type'     => 'text',
            'title'    => esc_html__( 'Property Description Box', 'propertya' ),
            'default'  => esc_html__('Property Description','propertya')
        ),
        array(
            'id'       => 'prop_cat1_title',
            'type'     => 'text',
            'title'    => esc_html__( '1st Level Category Title', 'propertya' ),
            'default'  => esc_html__('Make','propertya')
        ),

        array(
            'id'       => 'prop_cat2_title',
            'type'     => 'text',
            'title'    => esc_html__( '2nd Level Category Title', 'propertya' ),
            'default'  => esc_html__('Area','propertya')
        ),

        array(
            'id'       => 'prop_cat3_title',
            'type'     => 'text',
            'title'    => esc_html__( '3rd Level Category Title', 'propertya' ),
            'default'  => esc_html__('Varient','propertya')
        ),

        array(
            'id'       => 'prop_cat4_title',
            'type'     => 'text',
            'title'    => esc_html__( '4th Level Category Title', 'propertya' ),
            'default'  => esc_html__('Trim','propertya')
        ),

        array(
            'id'     => 'p_section-end',
            'type'   => 'section',
            'indent' => false,
        ),


        array(
            'id'       => 'prop_prop_type',
            'type'     => 'section',
            'title'    => esc_html__( 'Property Type Field', 'propertya' ),
            'indent'   => true,
        ),


        array(
            'id'       => 'prop_property_type',
            'type'     => 'text',
            'title'    => esc_html__('Property Type', 'propertya' ),
            'default'  => esc_html__( 'Property Type', 'propertya' ),
        ),
        array(
            'id'       => 'property_type_place',
            'type'     => 'text',
            'title'    => esc_html__( 'Placeholder', 'propertya' ),
            'default'  => esc_html__( 'Select Category', 'propertya' ),
        ),

        array(
            'id'     => 'd_t-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id'       => 'd_cat_title',
            'type'     => 'section',
            'title'    => esc_html__( 'Offer Type Field', 'propertya' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id'       => 'prop_offer_type',
            'type'     => 'text',
            'title'    => esc_html__('Offer Type', 'propertya' ),
            'default'  => esc_html__( 'Offer Type', 'propertya' ),
        ),
        array(
            'id'       => 'prop_offer_type_place',
            'type'     => 'text',
            'title'    => esc_html__( 'Placeholder', 'propertya' ),
            'default'  => esc_html__( 'Listed In', 'propertya' ),
        ),
        array(
            'id'     => 'd_cat-end',
            'type'   => 'section',
            'indent' => false,
        ),
        array(
            'id'       => 'd_contact_title',
            'type'     => 'section',
            'title'    => esc_html__( 'Label Type Field', 'propertya' ),
            'indent'   => true,
        ),
        array(
            'id'       => 'prop_status_type',
            'type'     => 'text',
            'title'    => esc_html__('Label', 'propertya' ),
            'default'  => esc_html__( 'Property Status', 'propertya' ),
        ),
        array(
            'id'       => 'prop_status_type_place',
            'type'     => 'text',
            'title'    => esc_html__( 'Placeholder', 'propertya' ),
            'default'  => esc_html__( 'Select Property Status', 'propertya' ),
        ),
        array(
            'id'     => 'd_contact-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id'       => 'd_curr_title',
            'type'     => 'section',
            'title'    => esc_html__( 'Currency Type Field', 'propertya' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id'       => 'prop_curr_type',
            'type'     => 'text',
            'title'    => esc_html__('Label', 'propertya' ),
            'default'  => esc_html__( 'Currency Type', 'propertya' ),
        ),
        array(
            'id'       => 'prop_curr_type_place',
            'type'     => 'text',
            'title'    => esc_html__( 'Placeholder', 'propertya' ),
            'default'  => esc_html__('Select Currency', 'propertya' ),
        ),

        array(
            'id'     => 'curr_web-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),

        array(
            'id'       => 'pp_f',
            'type'     => 'section',
            'title'    => esc_html__( 'Property Price Section', 'propertya' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),

        array(
            'id'       => 'prop_pri_type',
            'type'     => 'text',
            'title'    => esc_html__('Label', 'propertya' ),
            'default'  => esc_html__( 'Sale or Rent Price', 'propertya' ),
        ),
        array(
            'id'       => 'prop_pri_type_hint',
            'type'     => 'text',
            'title'    => esc_html__( 'Hint Text', 'propertya' ),
            'default'  => esc_html__('(Eg: 75000)', 'propertya' ),
        ),
        array(
            'id'       => 'prop_second_type',
            'type'     => 'text',
            'title'    => esc_html__('Second Price Field Label', 'propertya' ),
            'default'  => esc_html__( 'Second Price', 'propertya' ),
        ),
        array(
            'id'       => 'prop_second_type_hint',
            'type'     => 'text',
            'title'    => esc_html__( 'Second Price Field Hint', 'propertya' ),
            'default'  => esc_html__('(Optional)', 'propertya' ),
        ),
        array(
            'id'       => 'prop_after_type',
            'type'     => 'text',
            'title'    => esc_html__('After Price Label', 'propertya' ),
            'default'  => esc_html__( 'After Price Label', 'propertya' ),
        ),
        array(
            'id'       => 'prop_after_hint',
            'type'     => 'text',
            'title'    => esc_html__( 'After Price Field Hint', 'propertya' ),
            'default'  => esc_html__('(Eg: Per Month)', 'propertya' ),
        ),
        array(
            'id'       => 'prop_before_type',
            'type'     => 'text',
            'title'    => esc_html__('Before Price Label', 'propertya' ),
            'default'  => esc_html__( 'Price Prefix', 'propertya' ),
        ),
        array(
            'id'       => 'prop_before_hint',
            'type'     => 'text',
            'title'    => esc_html__( 'Before Price Field Hint', 'propertya' ),
            'default'  => esc_html__('(Eg: Start From)', 'propertya' ),
        ),
        array(
            'id'     => 'd_pricing_range-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id'       => 'd_b_hour',
            'type'     => 'section',
            'title'    => esc_html__( 'Area Size Field Section', 'propertya' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),

        array(
            'id'       => 'prop_a_size',
            'type'     => 'text',
            'title'    => esc_html__( 'Area Size', 'propertya' ),
            'default'  => esc_html__( 'Area Size', 'propertya' ),
        ),
        array(
            'id'       => 'prop_a_size_hint',
            'type'     => 'text',
            'title'    => esc_html__( 'Area Size Field Hint', 'propertya' ),
            'default'  => esc_html__('( Only digits )', 'propertya' ),
        ),

        array(
            'id'       => 'prop_a_size_place',
            'type'     => 'text',
            'title'    => esc_html__( 'Placeholder Field', 'propertya' ),
            'default'  => esc_html__('Eg 2500', 'propertya' ),
        ),

        array(
            'id'     => 'd_b_hour-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),


        array(
            'id'       => 'd_video_title',
            'type'     => 'section',
            'title'    => __( 'Area Prefix Field Section', 'propertya' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),

        array(
            'id'       => 'prop_a_prefix',
            'type'     => 'text',
            'title'    => esc_html__( 'Area Prefix', 'propertya' ),
            'default'  => esc_html__( 'Area Size Prefix', 'propertya' ),
        ),
        array(
            'id'       => 'prop_a_prefix_hint',
            'type'     => 'text',
            'title'    => esc_html__( 'Area Prefix Field Hint', 'propertya' ),
            'default'  => esc_html__('( Eg: Sq Ft)', 'propertya' ),
        ),
        array(
            'id'     => 'd_video-end',
            'type'   => 'section',
            'indent' => false,
        ),

        array(
            'id'       => 'd_tags_title',
            'type'     => 'section',
            'title'    => esc_html__( 'Land Area Field Section', 'propertya' ),
            'indent'   => true,
        ),

        array(
            'id'       => 'prop_l_area',
            'type'     => 'text',
            'title'    => esc_html__( 'Land Area', 'propertya' ),
            'default'  => esc_html__( 'Land Area', 'propertya' ),
        ),
        array(
            'id'       => 'prop_l_area_hint',
            'type'     => 'text',
            'title'    => esc_html__( 'Land Area Field Hint', 'propertya' ),
            'default'  => esc_html__('( Only digits )', 'propertya' ),
        ),

        array(
            'id'       => 'prop_l_area_place',
            'type'     => 'text',
            'title'    => esc_html__( 'Placeholder Field', 'propertya' ),
            'default'  => esc_html__('Eg 1300', 'propertya' ),
        ),
        array(
            'id'     => 'd_tags-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),

        array(
            'id'       => 'd_lp',
            'type'     => 'section',
            'title'    => __( 'Land Prefix Field Section', 'propertya' ),
            'indent'   => true,
        ),

        array(
            'id'       => 'prop_a_land_prefix',
            'type'     => 'text',
            'title'    => esc_html__( 'Land Prefix', 'propertya' ),
            'default'  => esc_html__( 'Land Area Prefix', 'propertya' ),
        ),
        array(
            'id'       => 'prop_a_land_hint',
            'type'     => 'text',
            'title'    => esc_html__( 'Land Prefix Field Hint', 'propertya' ),
            'default'  => esc_html__('( Eg: Sq Ft)', 'propertya' ),
        ),

        array(
            'id'     => 'd_coupn-end',
            'type'   => 'section',
            'indent' => false,
        ),


        array(
            'id'       => 'd_geo_fields',
            'type'     => 'section',
            'title'    => esc_html__( 'Property detail Fields', 'propertya' ),
            'indent'   => true,
        ),

        array(
            'id'       => 'prop_a_bed_title',
            'type'     => 'text',
            'title'    => esc_html__( 'Bedrooms Field Title', 'propertya' ),
            'default'  => esc_html__('Bedrooms', 'propertya' ),
        ),
        array(
            'id'       => 'prop_a_bed_place',
            'type'     => 'text',
            'title'    => esc_html__( 'Bedrooms Field Placeholder', 'propertya' ),
            'default'  => esc_html__('( Eg: 4)', 'propertya' ),
        ),
        array(
            'id'       => 'prop_a_bath_title',
            'type'     => 'text',
            'title'    => esc_html__( 'Bedroom Field Title', 'propertya' ),
            'default'  => esc_html__('Bathrooms', 'propertya' ),
        ),
        array(
            'id'       => 'prop_a_bath_place',
            'type'     => 'text',
            'title'    => esc_html__( 'Bedroom Field Placeholder', 'propertya' ),
            'default'  => esc_html__('( Eg: 2)', 'propertya' ),
        ),
        array(
            'id'       => 'prop_a_grage_title',
            'type'     => 'text',
            'title'    => esc_html__( 'Garage Field Title', 'propertya' ),
            'default'  => esc_html__('Garages', 'propertya' ),
        ),
        array(
            'id'       => 'prop_a_grage_place',
            'type'     => 'text',
            'title'    => esc_html__( 'Garages Field Placeholder', 'propertya' ),
            'default'  => esc_html__('( Eg: 1)', 'propertya' ),
        ),
        array(
            'id'       => 'prop_a_year_title',
            'type'     => 'text',
            'title'    => esc_html__( 'Year Field Title', 'propertya' ),
            'default'  => esc_html__('Year Built ', 'propertya' ),
        ),
        array(
            'id'       => 'prop_a_year_place',
            'type'     => 'text',
            'title'    => esc_html__( 'Year Field Placeholder', 'propertya' ),
            'default'  => esc_html__('Eg: November 2010', 'propertya' ),
        ),

        array(
            'id'       => 'prop_a_video_title',
            'type'     => 'text',
            'title'    => esc_html__( 'Video Field Title', 'propertya' ),
            'default'  => esc_html__('Video Link', 'propertya' ),
        ),
        array(
            'id'       => 'prop_a_video_place',
            'type'     => 'text',
            'title'    => esc_html__( 'Video Field Placeholder', 'propertya' ),
            'default'  => esc_html__('Youtube Video Link', 'propertya' ),
        ),

        array(
            'id'       => 'prop_v_tour_title',
            'type'     => 'text',
            'title'    => esc_html__( 'Virtual Tour Field Title', 'propertya' ),
            'default'  => esc_html__('360° Virtual Tour', 'propertya' ),
        ),
        array(
            'id'       => 'prop_v_tour_place',
            'type'     => 'text',
            'title'    => esc_html__( 'Virtual Tour Field Placeholder', 'propertya' ),
            'default'  => esc_html__('Copy/paste the iframe code of your 360° virtual tour.', 'propertya' ),
        ),

        array(
            'id'     => 'd_geo-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id'       => 'd_fields',
            'type'     => 'section',
            'title'    => esc_html__( 'Additional Fields Section', 'propertya' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),

        array(
            'id'       => 'prop_a_fields_title',
            'type'     => 'text',
            'title'    => esc_html__( 'Title Field', 'propertya' ),
            'default'  => esc_html__( 'Title', 'propertya' ),
        ),
        array(
            'id'       => 'prop_a_fields_value',
            'type'     => 'text',
            'title'    => esc_html__( 'Value Field', 'propertya' ),
            'default'  => esc_html__( 'Value', 'propertya' ),
        ),
        array(
            'id'       => 'prop_a_fields_btn',
            'type'     => 'text',
            'title'    => esc_html__( 'Add More Button', 'propertya' ),
            'default'  => esc_html__( '+ Add More', 'propertya' ),
        ),


        array(
            'id'     => 'ad-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),

        array(
            'id'       => 'd_brand_title',
            'type'     => 'section',
            'title'    => __( 'Property Location Fields Section', 'propertya' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),

        array(
            'id'       => 'prop_addr_field_txt',
            'type'     => 'text',
            'title'    => esc_html__( 'Address Field', 'propertya' ),
            'default'  => esc_html__( 'Address', 'propertya' ),
        ),
        array(
            'id'       => 'prop_addr_field_place',
            'type'     => 'text',
            'title'    => esc_html__( 'Placeholder', 'propertya' ),
            'default'  => esc_html__( 'Enter your property address', 'propertya' ),
        ),

        array(
            'id'       => 'prop_addr_coordinates',
            'type'     => 'text',
            'title'    => esc_html__( 'Coordinates Field Title', 'propertya' ),
            'default'  => esc_html__( 'Coordinates', 'propertya' ),
        ),

        array(
            'id'       => 'prop_addr_latt',
            'type'     => 'text',
            'title'    => esc_html__( 'Latitude (for Google Maps) Field Title', 'propertya' ),
            'default'  => esc_html__( 'Latitude', 'propertya' ),
        ),

        array(
            'id'       => 'prop_addr_long',
            'type'     => 'text',
            'title'    => esc_html__( 'Latitude (for Google Maps) Field Title', 'propertya' ),
            'default'  => esc_html__( 'Longitude ', 'propertya' ),
        ),

        array(
            'id'       => 'prop_addr_zip',
            'type'     => 'text',
            'title'    => esc_html__( 'Zip Code Field Title', 'propertya' ),
            'default'  => esc_html__( 'Zip or Postal Code ', 'propertya' ),
        ),

        array(
            'id'       => 'prop_addr_zip_place',
            'type'     => 'text',
            'title'    => esc_html__( 'Zip Code Placeholder', 'propertya' ),
            'default'  => esc_html__( 'Eg: 10048', 'propertya' ),
        ),

        array(
            'id'       => 'prop_addr_country',
            'type'     => 'text',
            'title'    => esc_html__( 'Neighborhood/Country Field Title', 'propertya' ),
            'default'  => esc_html__( 'Country', 'propertya' ),
        ),

        array(
            'id'       => 'prop_addr_country_place',
            'type'     => 'text',
            'title'    => esc_html__( 'Neighborhood/Country Placeholder', 'propertya' ),
            'default'  => esc_html__( 'Eg: England', 'propertya' ),
        ),

        array(
            'id'       => 'd_contact_field',
            'type'     => 'section',
            'title'    => esc_html__( 'Floor Plan Field Section', 'propertya' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),

        array(
            'id'       => 'prop_fplan_title',
            'type'     => 'text',
            'title'    => esc_html__('Floor Name Title', 'propertya'),
            'default'  => esc_html__('Floor Name', 'propertya' ),
        ),
        array(
            'id'       => 'prop_fplan_title_place',
            'type'     => 'text',
            'title'    => esc_html__('Floor Name Placeholder', 'propertya'),
            'default'  => esc_html__( 'Ground Floor', 'propertya' ),
        ),

        array(
            'id'       => 'prop_fplan_price',
            'type'     => 'text',
            'title'    => esc_html__( 'Floor Price Title', 'propertya' ),
            'default'  => esc_html__( 'Floor Price ( Only digits )', 'propertya' ),
        ),
        array(
            'id'       => 'prop_fplan_price_place',
            'type'     => 'text',
            'title'    => esc_html__( 'Floor Price Placeholder', 'propertya' ),
            'default'  => esc_html__( 'Eg: 2500', 'propertya' ),
        ),
        array(
            'id'       => 'prop_fplan_priceprefix_title',
            'type'     => 'text',
            'title'    => esc_html__( 'Floor Price Prefix Title', 'propertya' ),
            'default'  => esc_html__( 'Price Postfix', 'propertya' ),
        ),
        array(
            'id'       => 'prop_fplan_priceprefix_place',
            'type'     => 'text',
            'title'    => esc_html__( 'Floor Price Prefix Placeholder', 'propertya' ),
            'default'  => esc_html__( 'Eg: Per Month', 'propertya' ),
        ),

        array(
            'id'       => 'prop_fplan_size_title',
            'type'     => 'text',
            'title'    => esc_html__( 'Floor Size Title', 'propertya' ),
            'default'  => esc_html__( 'Floor Size ( Only digits )', 'propertya' ),
        ),
        array(
            'id'       => 'prop_fplan_size_place',
            'type'     => 'text',
            'title'    => esc_html__( 'Floor Size Placeholder', 'propertya' ),
            'default'  => esc_html__( 'Eg: 1500', 'propertya' ),
        ),
        array(
            'id'       => 'prop_fplan_sizepost_title',
            'type'     => 'text',
            'title'    => esc_html__( 'Size Postfix Title', 'propertya' ),
            'default'  => esc_html__( 'Size Postfix', 'propertya' ),
        ),
        array(
            'id'       => 'prop_fplan_sizepost_place',
            'type'     => 'text',
            'title'    => esc_html__( 'Size Postfix Placeholder', 'propertya' ),
            'default'  => esc_html__( 'Eg: Sq Ft', 'propertya' ),
        ),
        array(
            'id'       => 'prop_fplan_bed_title',
            'type'     => 'text',
            'title'    => esc_html__( 'Bedrooms Title', 'propertya' ),
            'default'  => esc_html__( 'Bedrooms', 'propertya' ),
        ),
        array(
            'id'       => 'prop_fplan_bed_place',
            'type'     => 'text',
            'title'    => esc_html__( 'Bedrooms Placeholder', 'propertya' ),
            'default'  => esc_html__( 'Eg: 4', 'propertya' ),
        ),
        array(
            'id'       => 'prop_fplan_bath_title',
            'type'     => 'text',
            'title'    => esc_html__( 'Bathrooms Title', 'propertya' ),
            'default'  => esc_html__( 'Bathrooms', 'propertya' ),
        ),
        array(
            'id'       => 'prop_fplan_bath_place',
            'type'     => 'text',
            'title'    => esc_html__( 'Bathrooms Placeholder', 'propertya' ),
            'default'  => esc_html__( 'Eg: 2', 'propertya' ),
        ),

        array(
            'id'       => 'prop_fplan_desc_title',
            'type'     => 'text',
            'title'    => esc_html__( 'Floor Plan Description Title', 'propertya' ),
            'default'  => esc_html__( 'Description', 'propertya' ),
        ),

        array(
            'id'       => 'prop_fplan_image_title',
            'type'     => 'text',
            'title'    => esc_html__( 'Floor Plan Image Field Title', 'propertya' ),
            'default'  => esc_html__( 'Floor Plan Image', 'propertya' ),
        ),

        array(
            'id'       => 'prop_fplan_admore',
            'type'     => 'text',
            'title'    => esc_html__( 'Floor Plan Add More Button', 'propertya' ),
            'default'  => esc_html__( '+ Add More', 'propertya' ),
        ),
        array(
            'id'       => 'prop_fplan_del_btn',
            'type'     => 'text',
            'title'    => esc_html__( 'Floor Plan Delete Button', 'propertya' ),
            'default'  => esc_html__( 'Delete', 'propertya' ),
        ),

        array(
            'id'       => 'd_other_fields',
            'type'     => 'section',
            'title'    => esc_html__( 'Form Section Titles', 'propertya' ),
            'indent'   => true,
        ),

        array(
            'id'       => 'prop_title_section',
            'type'     => 'text',
            'title'    => esc_html__( 'Title & Description Section Heading', 'propertya' ),
            'default'  => esc_html__( 'Add Property Page', 'propertya' ),
        ),

        array(
            'id'       => 'prop_type_section',
            'type'     => 'text',
            'title'    => esc_html__( 'Category & Type Section Heading', 'propertya' ),
            'default'  => esc_html__( 'Property Type & Status', 'propertya' ),
        ),
        array(
            'id'       => 'prop_customfields_section',
            'type'     => 'text',
            'title'    => esc_html__( 'Custom Fields', 'propertya' ),
            'default'  => esc_html__( 'Custom fields', 'propertya' ),
        ),

        array(
            'id'       => 'prop_price_section',
            'type'     => 'text',
            'title'    => esc_html__( 'Property Price Section Heading', 'propertya' ),
            'default'  => esc_html__( 'Property Price & Currency', 'propertya' ),
        ),

        array(
            'id'       => 'prop_gallery_section',
            'type'     => 'text',
            'title'    => esc_html__( 'Gallery Media Section Heading', 'propertya' ),
            'default'  => esc_html__( 'Property Media', 'propertya' ),
        ),

        array(
            'id'       => 'prop_gallery_section_note',
            'type'     => 'text',
            'title'    => esc_html__( 'Gallery Media Note', 'propertya' ),
            'default'  => esc_html__( 'You can select multiple images to upload at one time.', 'propertya' ),
        ),

        array(
            'id'       => 'prop_gallery_img_order',
            'type'     => 'text',
            'title'    => esc_html__( 'Gallery Images Order', 'propertya' ),
            'default'  => esc_html__( 'Change images order with Drag & Drop.', 'propertya' ),
        ),

        array(
            'id'       => 'prop_gallery_up_btn',
            'type'     => 'text',
            'title'    => esc_html__( 'Gallery Upload Button', 'propertya' ),
            'default'  => esc_html__( 'Select Images', 'propertya' ),
        ),

        array(
            'id'       => 'prop_detail_section',
            'type'     => 'text',
            'title'    => esc_html__( 'Property Details Section Heading', 'propertya' ),
            'default'  => esc_html__( 'Property Details', 'propertya' ),
        ),

        array(
            'id'       => 'prop_addition_fields_section',
            'type'     => 'text',
            'title'    => esc_html__( 'Additional Fields Section Heading', 'propertya' ),
            'default'  => esc_html__( 'Additional Features', 'propertya' ),
        ),
        array(
            'id'       => 'prop_ammen_section',
            'type'     => 'text',
            'title'    => esc_html__( 'Amenities and Features Section Heading', 'propertya' ),
            'default'  => esc_html__( 'Amenities and Features', 'propertya' ),
        ),
        array(
            'id'       => 'prop_loc_section',
            'type'     => 'text',
            'title'    => esc_html__( 'Property Location Section Heading', 'propertya' ),
            'default'  => esc_html__( 'Property Location', 'propertya' ),
        ),
        array(
            'id'       => 'prop_fplan_section',
            'type'     => 'text',
            'title'    => esc_html__( 'Floor Plans Section Heading', 'propertya' ),
            'default'  => esc_html__( 'Floor Plans', 'propertya' ),
        ),
        array(
            'id'       => 'prop_video_section',
            'type'     => 'text',
            'title'    => esc_html__( 'Video Section Heading', 'propertya' ),
            'default'  => esc_html__( 'Video Option', 'propertya' ),
        ),
        array(
            'id'       => 'prop_attach_section',
            'type'     => 'text',
            'title'    => esc_html__( 'Attachments Section Heading', 'propertya' ),
            'default'  => esc_html__( 'Attachments', 'propertya' ),
        ),
        array(
            'id'       => 'prop_attach_section_note',
            'type'     => 'text',
            'title'    => esc_html__( 'Attachments Note', 'propertya' ),
            'default'  => esc_html__( 'You can attach PDF files, Map images OR other documents to provide further details related to property.', 'propertya' ),
        ),
        array(
            'id'       => 'prop_attach_btn',
            'type'     => 'text',
            'title'    => esc_html__( 'Attachments Button', 'propertya' ),
            'default'  => esc_html__( '+ Add Attachments', 'propertya' ),
        ),
        array(
            'id'       => 'prop_contact_section',
            'type'     => 'text',
            'title'    => esc_html__( 'Contact Information Section Heading', 'propertya' ),
            'default'  => esc_html__( 'Contact Information', 'propertya' ),
        ),

        array(
            'id'       => 'prop_form_submission_btn',
            'type'     => 'text',
            'title'    => esc_html__( 'Form Submission Button', 'propertya' ),
            'default'  => esc_html__( 'Save & Preview', 'propertya' ),
        ),

        array(
            'id'     => 'd_other_fields-end',
            'type'   => 'section',
            'indent' => false,
        ),


    )

));


Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Required Fields Alerts', 'propertya' ),
    'id'         => 'prop_r_messages',
    'desc'       => '',
    'icon' => 'el el-cogs',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'prop_req_title',
            'type'     => 'text',
            'title'    => esc_html__( 'Property Title Field', 'propertya' ),
            'default'  => esc_html__( 'Title is required.', 'propertya' ),
        ),
        array(
            'id'       => 'prop_req_type',
            'type'     => 'text',
            'title'    => esc_html__( 'Property Type Field', 'propertya' ),
            'default'  => esc_html__( 'Property type is required.', 'propertya' ),
        ),
        array(
            'id'       => 'prop_req_offer',
            'type'     => 'text',
            'title'    => esc_html__( 'Offer Type Field', 'propertya' ),
            'default'  => esc_html__( 'Offer type is not selected.', 'propertya' ),
        ),
        array(
            'id'       => 'prop_req_status',
            'type'     => 'text',
            'title'    => esc_html__( 'Label Field', 'propertya' ),
            'default'  => esc_html__( 'Status is required.', 'propertya' ),
        ),
        array(
            'id'       => 'prop_req_currency',
            'type'     => 'text',
            'title'    => esc_html__( 'Currency Type Field', 'propertya' ),
            'default'  => esc_html__( 'Select any currency.', 'propertya' ),
        ),
        array(
            'id'       => 'prop_req_price',
            'type'     => 'text',
            'title'    => esc_html__( 'Property Price Field', 'propertya' ),
            'default'  => esc_html__( 'Only digits are allowed in price.', 'propertya' ),
        ),
        array(
            'id'       => 'prop_req_second',
            'type'     => 'text',
            'title'    => esc_html__( 'Second Price Field', 'propertya' ),
            'default'  => esc_html__( 'Only digits are allowed in (optional) price.', 'propertya' ),
        ),
        array(
            'id'       => 'prop_req_after',
            'type'     => 'text',
            'title'    => esc_html__( 'After Price Field', 'propertya' ),
            'default'  => esc_html__( 'Only characters are allowed in price postfix.', 'propertya' ),
        ),
        array(
            'id'       => 'prop_req_before',
            'type'     => 'text',
            'title'    => esc_html__( 'Before Price Field', 'propertya' ),
            'default'  => esc_html__( 'Only characters are allowed in price prefix.', 'propertya' ),
        ),
        array(
            'id'       => 'prop_req_asize',
            'type'     => 'text',
            'title'    => esc_html__( 'Area Size Field', 'propertya' ),
            'default'  => esc_html__( 'Only digits are allowed in area size.', 'propertya' ),
        ),
        array(
            'id'       => 'prop_req_asize_prefix',
            'type'     => 'text',
            'title'    => esc_html__( 'Area Size Prefix Field', 'propertya' ),
            'default'  => esc_html__( 'Area prefix is required.', 'propertya' ),
        ),
        array(
            'id'       => 'prop_req_lsize',
            'type'     => 'text',
            'title'    => esc_html__( 'Land Area Field', 'propertya' ),
            'default'  => esc_html__( 'Only digits are allowed in land area.', 'propertya' ),
        ),
        array(
            'id'       => 'prop_req_lsize_prefix',
            'type'     => 'text',
            'title'    => esc_html__( 'Land Area Prefix Field', 'propertya' ),
            'default'  => esc_html__( 'Land prefix is required.', 'propertya' ),
        ),
        array(
            'id'       => 'prop_req_bed',
            'type'     => 'text',
            'title'    => esc_html__( 'Bedrooms Field', 'propertya' ),
            'default'  => esc_html__( 'Only digits are allowed in bedrooms.', 'propertya' ),
        ),
        array(
            'id'       => 'prop_req_bath',
            'type'     => 'text',
            'title'    => esc_html__( 'Bathrooms Field', 'propertya' ),
            'default'  => esc_html__( 'Only digits are allowed in bathrooms.', 'propertya' ),
        ),
        array(
            'id'       => 'prop_req_garages',
            'type'     => 'text',
            'title'    => esc_html__( 'Garages Field', 'propertya' ),
            'default'  => esc_html__( 'Only digits are allowed in garage.', 'propertya' ),
        ),
        array(
            'id'       => 'prop_req_built',
            'type'     => 'text',
            'title'    => esc_html__( 'Year Built Field', 'propertya' ),
            'default'  => esc_html__( 'Built year is required.', 'propertya' ),
        ),
        array(
            'id'       => 'prop_req_video',
            'type'     => 'text',
            'title'    => esc_html__( 'Video URL Field', 'propertya' ),
            'default'  => esc_html__( 'Youtube video is required.', 'propertya' ),
        ),
        array(
            'id'       => 'prop_req_tour',
            'type'     => 'text',
            'title'    => esc_html__( '360 Virtual Tour Iframe Field', 'propertya' ),
            'default'  => esc_html__( 'Virtual tour iframe is required.', 'propertya' ),
        ),
        array(
            'id'       => 'prop_req_zipcode',
            'type'     => 'text',
            'title'    => esc_html__( 'Zipcode Field', 'propertya' ),
            'default'  => esc_html__( 'Zip or Postal code is required.', 'propertya' ),
        ),
        array(
            'id'       => 'prop_req_street_addr',
            'type'     => 'text',
            'title'    => esc_html__( 'Street Address Field', 'propertya' ),
            'default'  => esc_html__( 'Street address is required.', 'propertya' ),
        ),
        array(
            'id'       => 'prop_req_street_coord',
            'type'     => 'text',
            'title'    => esc_html__( 'Coordinates Field', 'propertya' ),
            'default'  => esc_html__( 'Latitude and longitude are required.', 'propertya' ),
        ),
        array(
            'id'       => 'prop_req_custom_location',
            'type'     => 'text',
            'title'    => esc_html__( 'Location Field', 'propertya' ),
            'default'  => esc_html__( 'Neighborhood is required.', 'propertya' ),
        ),
        array(
            'id'       => 'prop_req_gallery',
            'type'     => 'text',
            'title'    => esc_html__( 'Gallery Media', 'propertya' ),
            'default'  => esc_html__( 'Property images are required.', 'propertya' ),
        ),
        array(
            'id'       => 'prop_req_attach',
            'type'     => 'text',
            'title'    => esc_html__( 'Attachments Fields', 'propertya' ),
            'default'  => esc_html__( 'Attachments are required.', 'propertya' ),
        ),
    )
));
/* ------------------ Maps Settings ----------------------- */
Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Map Settings', 'propertya' ),
    'id'         => 'dwt-map-settings',
    'desc'       => '',
    'icon' => 'el el-globe',
    'fields'     => array(
        array(
            'id'       => 'property_opt_enable_map',
            'type'     => 'switch',
            'title'    => esc_html__( 'Enable Map', 'propertya' ),
            'default'  => true,
            'desc'     => esc_html__( 'Trun on or off Maps.', 'propertya' ),
        ),
        array(
            'id'       => 'property_opt_map_selection',
            'type'     => 'select',
            'title'    => esc_html__( 'Select Map Type ', 'propertya' ),
            'options'  => array(
                'open_street' => 'Open Street',
                'mapbox' => 'Mapbox',
                // 'google_map' => 'Google Maps',
            ),
            'required' => array( 'property_opt_enable_map', '=', true ),
            'default'  => 'open_street',
        ),

//===================================================================================================
        array(
            'id'       => 'property_opt_mapbox_layer_selection',
            'type'     => 'select',
            'title'    => esc_html__( 'Layer ', 'propertya' ),
            'options'  => array(
               'streets-v12'   => 'streets-v12',
                'streets-v11'  =>  'streets-v11',
                'light-v10'     =>  'light-v10',
                'dark-v10'     =>  'dark-v10',
                'satellite-v9'  =>   'satellite-v9',
                'satellite-streets-v11' => 'satellite-streets-v11',
                'outdoors-v11'    =>  'outdoors-v11',
                'navigation-day-v1'  =>  'navigation-day-v1',
                'navigation-night-v1' => 'navigation-night-v1'
                        ),
            
            'required' => array('property_opt_map_selection', '=', 'mapbox' ),
            'subtitle' => esc_html__( 'for mapbox.', 'propertya' ),
            'placeholder'  => 'Select Style',
            'default'  => 'streets-v12',
            
            
        ),

        array(
            'id'       => 'property_opt_mapbox_zoom_selection',
            'type'     => 'select',
            'title'    => esc_html__( 'Zoom ', 'propertya' ),
            'options'  => array(
               '3'     =>  '3',
               '5'     =>  '5',
               '10'     =>  '10',
               '13'     =>  '13'
            ),
            'required' => array( 'property_opt_map_selection', '=', 'mapbox' ),
            'subtitle' => esc_html__( 'for mapbox.', 'propertya' ),
            'placeholder'  => 'Min Zoom',
            'default'  => '3',
            ),
//===============================================================================================
        array(
            'id'    => 'property_opt_options_notification',
            'type'  => 'info',
            'style' => 'warning',
            'required' => array( 'property_opt_map_selection', '=', 'google_map' ),
            'title' => esc_html__( 'Google Notification.', 'propertya' ),
            'desc'  => esc_html__( 'Google <strong>maps & places</strong> will only works when you have an API key.<a href="https://developers.google.com/places/web-service/usage-and-billing" target="_blank">Google Notification</a>', 'propertya' )
        ),
        array(
            'id'       => 'property_opt_gmap_api_key',
            'type'     => 'text',
            'title'    => esc_html__( 'Google Map API Key', 'propertya' ),
            'desc' => 'https://developers.google.com/maps/documentation/javascript/get-api-key' , esc_html__( 'How to Find it' , 'propertya'  ),
            'required' => array( 'property_opt_map_selection', '=', 'google_map' ),
            'subtitle' => esc_html__( 'Google Map & search only works when you entered Google API Key', 'propertya' ),
            'default'  => '',
        ),
        array(
            'id'       => 'property_opt_mapbox_api_key',
            'type'     => 'text',
            'title'    => esc_html__( 'Mapbox Access Token', 'propertya' ),
            'desc' => 'https://account.mapbox.com/access-tokens/' , esc_html__( 'How to Find it' , 'propertya'  ),
            'required' => array( 'property_opt_map_selection', '=', 'mapbox' ),
            'subtitle' => esc_html__( 'Mapbox only works when you access Token Key', 'propertya' ),
            'default'  => '',
        ),
        array(
            'id'       => 'property_opt_default_lat',
            'type'     => 'text',
            'title'    => esc_html__( 'Latitude', 'propertya' ),
            'subtitle' => esc_html__( 'for default map.', 'propertya' ),
            'required' => array( 'property_opt_enable_map', '=', true ),
            'default'  => '40.7127837' ,
        ),
        array(
            'id'       => 'property_opt_default_long',
            'type'     => 'text',
            'title'    => esc_html__( 'Longitude', 'propertya' ),
            'subtitle' => esc_html__( 'for default map.', 'propertya' ),
            'required' => array( 'property_opt_enable_map', '=', true ),
            'default'  => '-74.00594130000002' ,
        ),

    )
) );
/* ------------------ Geo APi Settings ----------------------- */
Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Geo IP Settings', 'propertya' ),
    'id'         => 'dwt-geo-settings',
    'desc'       => '',
    'icon' => 'el el-map-marker',
    'fields'     => array(
        array(
            'id'       => 'property_opt_enable_geo',
            'type'     => 'switch',
            'title'    => esc_html__( 'Enable GeoLocation', 'propertya' ),
            'default'  => true,
            'desc'     => esc_html__( 'Trun on or off GeoLocation Api.', 'propertya' ),
        ),
        array(
            'id'       => 'property_opt_api_settings',
            'type'     => 'select',
            'title'    => esc_html__( 'Select API Type for Current location ', 'propertya' ),
            'subtitle' => esc_html__( 'For location detection', 'propertya' ),
            'desc'     => esc_html__('Above API options are used to identify visitors current location by their ip address.', 'propertya'),
            'options'  => array(
                'geo_ip' => 'Geo IP DB',
                'ip_api' => 'IP API',
            ),
            'required' => array( 'property_opt_enable_geo', '=', true ),
            'default'  => 'geo_ip',
        ),
    )
) );

/* ------------------Blog Settings ----------------------- */
Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Blog Settings', 'propertya' ),
    'id'         => 'sb-blog-settings',
    'desc'       => '',
    'icon' => 'el el-edit',
    'fields'     => array(
        array(
            'id'       => 'prop_blog_post_title',
            'type'     => 'text',
            'title'    => esc_html__( 'Blog Page Title', 'propertya' ),
            'desc'     => '',
            'default'  => esc_html__('Latest News & Trends', 'propertya'),
        ),


        array(
            'id'       => 'prop_blog_layout',
            'type'     => 'sorter',
            'title'    => 'Blog Post Layout Manager',
            'desc'     => 'Organize how you want the layout to appear on the blog page',
            'compiler' => 'true',
            'options'  => array(
                'enabled'  => array('content' => 'Content Area ','sidebar'  => 'Sidebar'),
            ),
        ),

        array(
            'id'       => 'prop_p_blog_singlelayout',
            'type'     => 'sorter',
            'title'    => 'Blog Detail Layout Manager',
            'desc'     => 'Organize how you want the layout to appear on the blog page',
            'compiler' => 'true',
            'options'  => array(
                'enabled'  => array('singlepost' => 'Post Detail ','singlesidebar'  => 'Sidebar'),
            ),
        ),
    )
) );

/* ------------------ Packages Text Settings ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Packages Text', 'propertya'),
    'id' => 'dwt_listing_pkg_txt',
    'desc' => '',
    'icon' => 'el el-text-height',
    'fields' => array(
        array(
            'id' => 'd_pakge_indent',
            'type' => 'section',
            'indent' => true,
        ),
        array(
            'id' => 'prop_p_exp',
            'type' => 'text',
            'title' => esc_html__('Package Expiry Title', 'propertya'),
            'default' => 'Duration',
        ),
        array(
            'id' => 'prop_reg_listing',
            'type' => 'text',
            'title' => esc_html__('Total Listings Title', 'propertya'),
            'default' => 'Max. Listings',
        ),
        array(
            'id' => 'prop_l_exp',
            'type' => 'text',
            'title' => esc_html__('Listing Expiry Title', 'propertya'),
            'default' => 'Listing Expiry',
        ),
        array(
            'id' => 'prop_feat_listing',
            'type' => 'text',
            'title' => esc_html__('Featured Listing Title', 'propertya'),
            'default' => 'Featured Listings',
        ),
        array(
            'id' => 'prop_feat_for',
            'type' => 'text',
            'title' => esc_html__('Featured For Title', 'propertya'),
            'default' => 'Featured For',
        ),
        array(
            'id' => 'prop_pkg_daytxt',
            'type' => 'text',
            'title' => esc_html__('Days Option Text', 'propertya'),
            'default' => 'Days',
        ),
        array(
            'id' => 'prop_pkg_unlimited',
            'type' => 'text',
            'title' => esc_html__('Unlimited Option Text', 'propertya'),
            'default' => 'Unlimited',
        ),
        array(
            'id' => 'prop_never_exp',
            'type' => 'text',
            'title' => esc_html__('Never Expire Option Text', 'propertya'),
            'default' => 'Never Expire',
        ),
    )
));


/* ------------------ Pagination Settings ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__("Pagination Settings", "propertya") ,
    'id' => 'app_g_pagination',
    'desc' => '',
    'icon' => 'el el-adjust-alt',
    'fields' => array(
        array(
            'id'    => 'prop_p_notification',
            'type'  => 'info',
            'style' => 'info',
            'icon'  => 'el el-info-circle',
            'title' => esc_html__( 'User Personal Dashboard.', 'propertya' ),
            'desc'  => esc_html__( 'Pagination settings for user personal profile.', 'propertya' )
        ),
        array(
            'id'       => 'prop_dash_listings',
            'type'     => 'spinner',
            'title'    => esc_html__( 'Dashboad Listings', 'propertya' ),
            'desc' 	   => esc_html__('Number of listings shown per page.', 'propertya') ,
            'default' => '10',
            'min'     => '1',
            'step'    => '1',
            'max'     => '30',
        ),
        array(
            'id'       => 'prop_dash_agents',
            'type'     => 'spinner',
            'title'    => esc_html__( 'Dashboad Agents', 'propertya' ),
            'desc' 	   => esc_html__('Number of agents shown per page.', 'propertya') ,
            'default' => '12',
            'min'     => '1',
            'step'    => '1',
            'max'     => '32',
        ),
    )
));
/* ------------------ Placeholder Images ----------------------- */
Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'Placeholder Images', 'propertya' ),
    'id'               => 'prop_gen_place',
    'subsection'       => false,
    'customizer_width' => '450px',
    'desc'             =>'',
    'fields'           => array(
        array(
            'id'       => 'prop_def_buyer_logo',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__( 'Default Buyer/individual Image', 'propertya' ),
            'compiler' => 'true',
            'desc'     => esc_html__( 'Select default Buyer/individual image.', 'propertya'),
            'default'  => array( 'url' => trailingslashit( get_template_directory_uri()) . 'libs/images/default-imag.jpg' ),
        ),
        array(
            'id'       => 'prop_def_agency_placeholder',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__( 'Agency Placeholder Image', 'propertya' ),
            'compiler' => 'true',
            'desc'     => esc_html__( 'Set default placeholder image for agencies.', 'propertya'),
            'default'  => array( 'url' => trailingslashit( get_template_directory_uri()) . 'libs/images/agency-logo.png' ),
        ),
        array(
            'id'       => 'prop_def_agent_placeholder',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__( 'Agent Placeholder Image', 'propertya' ),
            'compiler' => 'true',
            'desc'     => esc_html__( 'Set default placeholder image for agents.', 'propertya'),
            'default'  => array( 'url' => trailingslashit( get_template_directory_uri()) . 'libs/images/agency.jpg' ),
        ),
        array(
            'id'       => 'prop_profile_cover_image',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__( 'Profile detail Cover Image', 'propertya' ),
            'compiler' => 'true',
            'desc'     => esc_html__( 'Set default placeholder image for cover image.', 'propertya'),
            'default'  => array( 'url' => trailingslashit( get_template_directory_uri()) . 'libs/images/cover-image.jpg' ),
        ),
        array(
            'id' => 'prop_defualt_listing_image',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Default Listing Image', 'propertya'),
            'compiler' => 'true',
            'desc' => esc_html__('If there is no image of listing then this will be shown.', 'propertya'),
            'subtitle' => esc_html__('Dimensions: 300 x 225', 'propertya'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'libs/images/no-image.png'),
        ),
        array(
            'id'       => 'prop_room_logo',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__( 'Default Bed Icon', 'propertya' ),
            'compiler' => 'true',
            'desc'     => esc_html__( 'Select default Room Icon.', 'propertya'),
            'default'  => array( 'url' => trailingslashit( get_template_directory_uri()) . 'libs/images/bed.png' ),
        ),
        array(
            'id'       => 'prop_type_logo',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__( 'Default type Icon', 'propertya' ),
            'compiler' => 'true',
            'desc'     => esc_html__( 'Select default Property Type Icon.', 'propertya'),
            'default'  => array( 'url' => trailingslashit( get_template_directory_uri()) . 'libs/images/bed.png' ),
        ),
        array(
            'id'       => 'prop_bath_logo',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__( 'Default Bath Icon', 'propertya' ),
            'compiler' => 'true',
            'desc'     => esc_html__( 'Select default Bath Icon.', 'propertya'),
            'default'  => array( 'url' => trailingslashit( get_template_directory_uri()) . 'libs/images/bathroom.png' ),
        ),
        array(
            'id'       => 'prop_garage_logo',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__( 'Default Garage Icon', 'propertya' ),
            'compiler' => 'true',
            'desc'     => esc_html__( 'Select default Garage Icon.', 'propertya'),
            'default'  => array( 'url' => trailingslashit( get_template_directory_uri()) . 'libs/images/car.png' ),
        ),
        array(
            'id'       => 'prop_prop_logo',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__( 'Default area Icon', 'propertya' ),
            'compiler' => 'true',
            'desc'     => esc_html__( 'Select default area Icon.', 'propertya'),
            'default'  => array( 'url' => trailingslashit( get_template_directory_uri()) . 'libs/images/area.png' ),
        ),
        array(
            'id'       => 'prop_land_logo',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__( 'Default land Icon', 'propertya' ),
            'compiler' => 'true',
            'desc'     => esc_html__( 'Select default land Icon.', 'propertya'),
            'default'  => array( 'url' => trailingslashit( get_template_directory_uri()) . 'libs/images/size.png' ),
        ),
    )
) );

Redux::setSection( $opt_name, array(
    'title'  => esc_html__( 'Compare Listings', 'propertya' ),
    'id'     => 'prop_compare',
    'desc'   => '',
    'subsection' => false,
    'fields' => array(
       array(
            'id'       => 'prop_show_compare_listing',
            'type'     => 'switch', 
            'title'    => __('Compare Listing Enable', 'redux-framework-demo'),
            'subtitle' => __('Look, it\'s on!', 'redux-framework-demo'),
            'default'  => true,
        ),
        array(
            'id'       => 'prop_compare_tagline',
            'type'     => 'text',
            'title'    => esc_html__( 'Tagline', 'propertya' ),
            'default' => esc_html__('Spot the difference', 'propertya'),
        ),
        array(
            'id'       => 'prop_compare_heading',
            'type'     => 'text',
            'title'    => esc_html__( 'Heading', 'propertya' ),
            'default' => esc_html__('Compare Properties', 'propertya'),
        ),
        array(
            'id'       => 'prop_empty_list',
            'type'     => 'text',
            'title'    => esc_html__( 'Empty List Message', 'propertya' ),
            'default' => esc_html__('Add properties to compare.', 'propertya'),
        ),
        array(
            'id'       => 'prop_empty_msg',
            'type'     => 'text',
            'title'    => esc_html__( 'Empty Page Message', 'propertya' ),
            'default' => esc_html__('Please select more than one property to compare.', 'propertya'),
        ),

    )
));


/* -> START Basic Fields */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Footer Settings', 'propertya'),
    'id' => 'footer-settings',
    'subsection' => false,
    'customizer_width' => '450px',
    'fields' => array(
        array(
            'id' => 'prop_footer_layout',
            'type' => 'image_select',
            'title' => esc_html__('Footer Layout', 'propertya'),
            'desc' => esc_html__('Select footer Layout you want to show.', 'propertya'),
            'options' => array(
                '1' => array(
                    'alt' => esc_html__('Layout Type 1', 'propertya'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'libs/images/options/footer.png'
                ),
            ),
            'default' => '1'
        ),
        array(
            'id' => 'prop_footer_logo',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Footer Logo', 'propertya'),
            'compiler' => 'true',
            'desc' => esc_html__('Upload main logo of the website.', 'propertya'),
            'default' =>array( 'url' => trailingslashit( get_template_directory_uri () ) . 'libs/images/logo-white.png' ),
        ),

        // adding background image for footer
 array(
            'id' => 'prop_footer_background',
            'type' => 'media',
             'url' => true,
            'title' => esc_html__('Footer Background Image', 'propertya'),
             'compiler' => 'true',
            'desc' => esc_html__('Select footer Image you want to show.', 'propertya'),
            'default' =>array( 'url' => trailingslashit( get_template_directory_uri () ) . 'libs/images/footerbg.png' ),
        ),

        // end
        array(
            'id' => 'prop_footer_text',
            'type' => 'textarea',
            'title' => esc_html__('Footer Text', 'propertya'),
            'subtitle' => esc_html__('All HTML will be stripped', 'propertya'),
            'desc' => esc_html__('This is the description field, again good for additional info.', 'propertya'),
            'validate' => 'no_html',
        ),
        array(
            'id' => 'prop_pop_loc',
            'type' => 'text',
            'title' => esc_html__('Popular Locations', 'propertya'),
            'desc' => esc_html__('Enter section title here', 'propertya'),
            'required' => array('prop_footer_layout', '=', '1'),
            'default' => esc_html__('Popular Locations', 'propertya'),
        ),
        array(
            'id' => 'prop_getpop_loc',
            'type' => 'select',
            'title' => __('Select Locations', 'propertya'),
            'multi' => true,
            'data' => 'terms',
            'args' => array(
                'taxonomies' => array('property_location'), 'hide_empty' => false,
            ),
            'required' => array('prop_footer_layout', '=', '1'),
        ),
        array(
            'id' => 'prop_pop_catz',
            'type' => 'text',
            'title' => esc_html__('Top Categories', 'propertya'),
            'desc' => esc_html__('Enter section title here', 'propertya'),
            'required' => array('prop_footer_layout', '=', '1'),
            'default' => esc_html__('Featured Categories', 'propertya'),
        ),
        array(
            'id' => 'prop_getpop_catz',
            'type' => 'select',
            'title' => __('Select Type', 'propertya'),
            'multi' => true,
            'sortable' => true,
            'data' => 'terms',
            'args' => array('taxonomies' => array('property_type'), 'hide_empty' => false,),
            'required' => array('prop_footer_layout', '=', '1'),
        ),
        array(
            'id' => 'prop_footer_link_txt',
            'type' => 'text',
            'title' => esc_html__('Links Title', 'propertya'),
            'desc' => esc_html__('Enter section title here', 'propertya'),
            'default' => esc_html__('Qucik Links', 'propertya'),
        ),
        array(
            'id' => 'prop_footer_pages',
            'type' => 'select',
            'data' => 'pages',
            'multi' => true,
            'title' => esc_html__('Quick Links', 'propertya'),
            'desc' => esc_html__('Select the links for the footer.', 'propertya'),
        ),

        array(
            'id' => 'prop_footer-address',
            'type' => 'sortable',
            'title' => esc_html__('Address Info', 'propertya'),
            'desc' => esc_html__('Leave empty if you don\' want to show.', 'propertya'),
            'label' => true,
            'options' => array(
                'address' => '#',
                'email' => '#',
                'phone' => '#',
                'clock' => '#',
            ),
            'default' => array('address' => esc_html__('B-Floor,Arcade Model Town, USA', 'propertya'), 'email' => 'contact@scriptsbundle.com', 'phone' => '(0092)+ 124 45 78 678 ', 'clock' => esc_html__('Mon - Sun: 8:00 - 16:00', 'propertya')),
            'required' => array('prop_footer_layout', '=', '3'),
        ),
        array(
            'id' => 'prop_footer_copyrights',
            'type' => 'editor',
            'title' => esc_html__('Copy Rights Text', 'propertya'),
            'default' => esc_html__('Copyright 2020 &copy; Theme Created By ScriptsBundle, All Rights Reserved.', 'propertya'),
            'args' => array(
                'wpautop' => false,
                'media_buttons' => false,
                'textarea_rows' => 4,
                'teeny' => false,
                'quicktags' => false,
            )
        ),

        array(
            'id' => 'prop_footer_social_media',
            'type' => 'sortable',
            'title' => esc_html__('Social Media', 'propertya'),
            'desc' => esc_html__('Social Icons For Foter. You can sort it out as you want.', 'propertya'),
            'label' => true,
            'options' => array(
                'Facebook' => '',
                'Twitter' => '',
                'Linkedin' => '',
                'YouTube' => '',
                'Vimeo' => '',
                'Pinterest' => '',
                'Tumblr' => '',
                'Instagram' => '',
                'Reddit' => '',
                'Flickr' => '',
                'StumbleUpon' => '',
                'Delicious' => '',
                'dribble' => '',
                'behance' => '',
                'DeviantART' => '',
            ),
            'default' => array('Facebook' => '#', 'Twitter' => '#', 'Linkedin' => '#', 'Instagram' => '#', 'YouTube' => '#'),
        ),
        array(
            'id' => 'prop_footer1_sorter',
            'type' => 'sorter',
            'title' => 'Footer Layout Manager',
            'desc' => 'Organize how you want the layout to appear on the homepage',
            'compiler' => 'true',
            'options' => array(
                'enabled' => array('logo' => 'Your Details ', 'countries' => 'Popular Countries', 'cats' => 'Categories', 'links' => 'Quick Links'),
            ),
            'required' => array('prop_footer_layout', '=', '1'),
        ),
    )
));

/*
 * WPML Settings
 */
if (function_exists('icl_object_id')) {
    Redux::setSection($opt_name, array(
        'title' => esc_html__('WPML Settings', 'propertya'),
        'id' => 'prop-wpml',
        'desc' => '',
        'icon' => 'el el-globe-alt',
        'fields' => array(
            array(
                'id' => 'prop_duplicate_post',
                'type' => 'switch',
                'title' => esc_html__('Duplicate Posts', 'propertya'),
                'subtitle' => __('Enable this option to duplicate posts in all others languages after successfully publish.', 'propertya'),
                'desc' => esc_html__('Note : Disable means the posts publish only in the current language.', 'propertya'),
                'default' => false,
            ),
            array(
                'id' => 'prop_display_post',
                'type' => 'switch',
                'title' => esc_html__('Display Posts', 'propertya'),
                'subtitle' => __('Enable this option to display all others languages posts in current language.', 'propertya'),
                'desc' => esc_html__('Note : Disable means to display only current language posts.', 'propertya'),
                'default' => false,
            ),
            array(
                'id' => 'prop_lang_switcher',
                'type' => 'switch',
                'title' => esc_html__('Language Switcher on Topbar', 'propertya'),
                'subtitle' => __('Enable this option to display language switcher on topbar.', 'propertya'),
                'default' => false,
            ),
            array(
                'id' => 'prop_menu_lang_switch',
                'type' => 'switch',
                'title' => esc_html__('Language Switcher in Menu', 'propertya'),
                'subtitle' => __('Enable this option to Show language switcher in menu.', 'propertya'),
                'default' => false,
            ),
        )
    ));
}