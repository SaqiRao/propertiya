<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme Propertya - Real Estate WordPress Theme for publication on ThemeForest
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 *
 * Depending on your implementation, you may want to change the include call:
 *
 * Parent Theme:
 * require_once get_template_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Child Theme:
 * require_once get_stylesheet_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Plugin:
 * require_once dirname( __FILE__ ) . '/path/to/class-tgm-plugin-activation.php';
 */
require_once get_template_directory() . '/tgm/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'propertya_register_required_plugins' );
function propertya_register_required_plugins() {
	$plugins = array(
	    array(
			'name'               => esc_html__( 'Elementor', 'propertya'), 
			'slug'               => 'elementor',
			'source'             => '',
			'required'           => true, 
			'version'            => '',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => esc_url( 'https://downloads.wordpress.org/plugin/elementor.3.9.2.zip'
			 ),
			'is_callable'        => '',
		),
		array(
			'name'               => esc_html__( 'Redux Framework', 'propertya'), 
			'slug'               => 'redux-framework',
			'source'             => '',
			'required'           => true, 
			'version'            => '',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => esc_url( 'https://downloads.wordpress.org/plugin/redux-framework.4.3.21.zip'
			 ),
			'is_callable'        => '',
		),


        array(
            'name' 				 => esc_html__('Woocommerce', 'propertya'),
            'slug'				 => 'woocommerce', 
            'source'			 => '', 
            'required'			 => true, 
            'version'			 => '', 
            'force_activation'	 => false,
            'force_deactivation' => false, 
            'external_url'		 => esc_url('https://downloads.wordpress.org/plugin/woocommerce.7.2.2.zip'),
            'is_callable'		 => '',
        ),
		array(
			'name'               => esc_html__( 'Propertya Elementor Widgets', 'propertya' ), 
			'slug'               => 'propertya-elementor',
			'source'             => get_template_directory() . '/required-plugins/propertya-elementor.zip',
			'required'           => true,
			'version'            => '1.1.4',
			'force_activation'   => false, 
			'force_deactivation' => false, 
			'external_url'       => '', 
			'is_callable'        => '',
		),
		array(
			'name'               => esc_html__( 'Propertya Framework', 'propertya' ),
			'slug'               => 'propertya-framework',
			'source'             => get_template_directory() . '/required-plugins/propertya-framework.zip',
			'required'           => true,
			'version'            => '1.1.4',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => '',
			'is_callable'        => '',
		),
        array(
            'name' => esc_html__('Contact Form 7', 'propertya'),
            'slug' => 'contact-form-7',
            'source' => '', 
            'required' => true, 
            'version' => '', 
            'force_activation' => false, 
            'force_deactivation' => false,
            'external_url' => esc_url('https://downloads.wordpress.org/plugin/contact-form-7.5.7.2.zip'), 
            'is_callable' => '',
        ),
	);

	$config = array(
		'id'           => 'propertya',       
		'default_path' => '',                     
		'menu'         => 'tgmpa-install-plugins', 
		'has_notices'  => true,                    
		'dismissable'  => false,                   
		'dismiss_msg'  => '',                  
		'is_automatic' => false,                  
		'message'      => '',                 
	);
	propertya_tgmpa( $plugins, $config );
}