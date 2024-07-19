<?php
namespace ElementorRealEstate\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class OurApps extends Widget_Base {
	
	public function get_name() {
		return 'our-apps';
	}
	
	public function get_title() {
		return __( 'Our Apps', 'propertya-elementor' );
	}
	
	public function get_icon() {
		return 'eicon-social-icons';
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
				'label' => esc_html__( 'App Content', 'propertya-elementor' ),
			]
		);
		$this->add_control(
			'tagline',
			[
				'label' => __( 'Tagline', 'propertya-elementor' ),
				'label_block' =>true,
				'default' => __( 'Subtitle Here', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);
		$this->add_control(
			'heading_text',
			[
				'label' => __( 'Main Heading', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'title' => __( 'To highligt heading use color tag eg: {color} Awesome </color>', 'propertya-elementor' ),
				'rows' => 3,
				'default' => __( 'Content goes here..', 'propertya-elementor' ),
				'placeholder' => __( 'To highligt heading use color tag eg: {color} Awesome </color>', 'propertya-elementor' ),
			]
		);
		$this->add_control(
			'item_description',
			[
				'label' => __( 'Description', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 10,
				'placeholder' => __( 'Type your description here', 'propertya-elementor' ),
				'default' => __( 'Content goes here..', 'propertya-elementor' ),
			]
		);
		
		$this->add_control(
			'main_btn_link',
			[
				'label' => __( 'IOS Store Link', 'propertya-elementor' ),
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
			'second_btn_link',
			[
				'label' => __( 'App Store Link', 'propertya-elementor' ),
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
			'image',
			[
				'label' => __( 'Image', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'description' => __( 'Recommended image size 250x300', 'propertya-elementor' ),
			]
		);
		$this->end_controls_section();
	}
	
		protected function render() {
		// get our input from the widget settings.
		$settings = $this->get_settings_for_display();
		$params['tagline'] = $settings['tagline'];
		$params['heading_text'] = $settings['heading_text'];
		$params['desc'] = $settings['item_description'];
		//main button
		$params['main_btn']['link'] = $settings['main_btn_link']['url'];
		$params['main_btn']['is_external'] = $settings['main_btn_link']['is_external'];
		$params['main_btn']['nofollow'] = $settings['main_btn_link']['nofollow'];
		//second button
		$params['sec_btn']['link'] = $settings['second_btn_link']['url'];
		$params['sec_btn']['is_external'] = $settings['second_btn_link']['is_external'];
		$params['sec_btn']['nofollow'] = $settings['second_btn_link']['nofollow'];
		$params['image'] = $settings['image']['url'] ? $settings['image']['url'] : '';
			echo propertya_elementor_our_apps($params);
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