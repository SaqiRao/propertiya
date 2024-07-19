<?php
namespace ElementorRealEstate\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class CallAction_Four extends Widget_Base {
	
	public function get_name() {
		return 'call-action-four';
	}
	
	public function get_title() {
		return __( 'Hero Section 8', 'propertya-elementor' );
	}
	
	public function get_icon() {
		return 'eicon-image';
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
		
		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Hero Content', 'propertya-elementor' ),
			]
		);
		
		$this->add_control(
			'listing_count',
			[
				'label' => __( 'Tagline', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => __( 'Use %count% if want to show total properties', 'propertya-elementor' ),
				'default' => __( 'More than %count% properties listed', 'propertya-elementor' ),
				'label_block' => true
			]
		);
		$this->add_control(
			'heading_text',
			[
				'label' => __( 'Main Heading', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'title' => __( 'To highligt heading use color tag eg: {color} Awesome </color>', 'propertya-elementor' ),
				'rows' => 3,
				'description' => __( 'Highligt heading use color tag eg: {color} Awesome </color>', 'propertya-elementor' ),
				'default' => __( 'Content goes here..', 'propertya-elementor' ),
			]
		);
		$this->add_control(
			'item_description',
			[
				'label' => __( 'Description', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 7,
				'placeholder' => __( 'Type your description here', 'propertya-elementor' ),
				'default' => __( 'Content goes here..', 'propertya-elementor' ),
			]
		);
        $this->add_control(
			'main_btn_title',
			[
				'label' => __( 'Main Button Title', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Type your title here', 'propertya-elementor' ),
				'label_block' => true
			]
		);
		$this->add_control(
			'main_btn_link',
			[
				'label' => __( 'Main Button Link', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'propertya-elementor' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);
		$this->add_control(
			'second_btn_title',
			[
				'label' => __( 'Secondary Button Title', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Type your title here', 'propertya-elementor' ),
				'label_block' => true
			]
		);
		$this->add_control(
			'second_btn_link',
			[
				'label' => __( 'Secondary Button Link', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'propertya-elementor' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);
		
		$this->end_controls_section();
		
	}
	
		protected function render() {
		// get our input from the widget settings.
		$settings = $this->get_settings_for_display();
		$params['heading_text'] = $settings['heading_text'];
		$params['tagline'] = $settings['item_description'];
		$params['listing_count'] = $settings['listing_count'];
        //main button
		$params['main_btn']['title'] = $settings['main_btn_title'];
		$params['main_btn']['link'] = $settings['main_btn_link']['url'];
		$params['main_btn']['is_external'] = $settings['main_btn_link']['is_external'];
		$params['main_btn']['nofollow'] = $settings['main_btn_link']['nofollow'];
		//second button
		$params['sec_btn']['title'] = $settings['second_btn_title'];
		$params['sec_btn']['link'] = $settings['second_btn_link']['url'];
		$params['sec_btn']['is_external'] = $settings['second_btn_link']['is_external'];
		$params['sec_btn']['nofollow'] = $settings['second_btn_link']['nofollow'];
			echo propertya_elementor_hero9($params);
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