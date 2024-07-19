<?php
namespace ElementorRealEstate\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Blogs extends Widget_Base {
	
	public function get_name() {
		return 'all-blogs';
	}
	
	public function get_title() {
		return __( 'Blogs', 'propertya-elementor' );
	}
	
	public function get_icon() {
		return 'eicon-bullet-list';
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
	 
	public function get_customparant_terms($taxonomy)
	{
		$type = array();
		$terms = get_terms( array( 'taxonomy' => 'property_type', 'parent' => 0, 'hide_empty' => 0 ));
		$type = ['all' => 'All'];
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) )
		{
			foreach ( $terms as $term ) {
				$type[$term->term_id] = $term->name . ' (' . $term->count . ')';				
			}
		}
		return $type;
	}
	 
	 
	protected function register_controls() {
		$type = array();
		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Section Heading', 'propertya-elementor' ),
			]
		);
		$this->add_control(
			'heading_text',
			[
				'label' => __( 'Sub Title', 'propertya-elementor' ),
				'label_block' =>true,
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'item_description',
			[
				'label' => __( 'Main Title', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 4,
				'placeholder' => __( 'Type your description here', 'propertya-elementor' ),
			]
		);
		$this->add_control(
			'heading_style',
			[
				'label' => __( 'Heading Style', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'center',
				'label_block' =>true,
				'options' => [
					'center'  => __( 'Center', 'propertya-elementor' ),
					'left' => __( 'Left', 'propertya-elementor' ),
				],
			]
		);
		
		$this->add_control(
			'posts_per_page',
			[
				'label'   => __( 'Number of Blog Posts', 'propertya-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 6,
				'options' => [
					3  => __( 'Three', 'propertya-elementor' ),
					6  => __( 'Six', 'propertya-elementor' ),
					9  => __( 'Nine','propertya-elementor' ),
					12 => __( 'Twelve', 'propertya-elementor' ),
					15 => __( 'Fifteen', 'propertya-elementor' ),
					-1 => __( 'All', 'propertya-elementor' ),
				]
			]
		);
		$this->end_controls_section();
	}
	
		protected function render() {
		// get our input from the widget settings.
		$settings = $this->get_settings_for_display();
		$params['subtitle'] = $settings['heading_text'] ? $settings['heading_text'] : '';
		$params['maintitle'] = $settings['item_description'] ? $settings['item_description'] : '';
		$params['heading_style'] = $settings['heading_style'] ? $settings['heading_style'] : 'center';
		$params['no_of_post'] = $settings['posts_per_page'] ? (int)$settings['posts_per_page'] : 6;
		
			echo propertya_elementor_all_blogs($params);
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