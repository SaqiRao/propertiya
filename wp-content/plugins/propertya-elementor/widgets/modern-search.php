<?php
namespace ElementorRealEstate\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Modern_Search extends Widget_Base {
	
	public function get_name() {
		return 'search-with-filters';
	}
	
	public function get_title() {
		return __( 'Search With Filters', 'propertya-elementor' );
	}
	
	public function get_icon() {
		return 'eicon-post-list';
	}

	public function get_categories() {
		return [ 'sonutheme' ];
	}
	
	public function get_script_depends() {
		return [ '' ];
	}
	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */

	protected function register_controls() {
		$type = array();
		
		
	}
	
		protected function render() {
		// get our input from the widget settings.
		$settings = $this->get_settings_for_display();
        $args	=	array
        (
            'post_type' => 'property',
            'post_status' => 'publish',
            'posts_per_page' => get_option('posts_per_page'),
            'paged' => 1,
            'meta_key' => 'prop_is_feature_listing',
            'fields' => 'ids',
            'orderby'  => array(
                'meta_value' => 'DESC',
                'post_date'      => 'DESC',
            ),
            'meta_query'    => array(
                array(
                    'key'       => 'prop_status',
                    'value'     => '1',
                    'compare'   => '=',
                ),
            ),
            'order'=> 'DESC',
        );
        $results = new \WP_Query($args);
        $theme = wp_get_theme();
         require trailingslashit(get_template_directory()) . 'template-parts/search/property-search/search-with-modern.php';

        // if($theme->name == "Propertya Child"){
        // 	   require trailingslashit(get_stylesheet_directory()) . 'template-parts/search/property-search/search-with-modern.php';
        // }
        // else {
        // 	 require trailingslashit(get_template_directory()) . 'template-parts/search/property-search/search-with-modern.php';
        // }


       
		}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function content_template() {
			
	}
}