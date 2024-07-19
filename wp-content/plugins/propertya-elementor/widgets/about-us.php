<?php
namespace ElementorRealEstate\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class About_Us extends Widget_Base {
	
	public function get_name() {
		return 'about-us-one';
	}
	
	public function get_title() {
		return __( 'About Us', 'propertya-elementor' );
	}
	
	public function get_icon() {
		return 'eicon-posts-group';
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
				'label' => esc_html__( 'About Us Content', 'propertya-elementor' ),
			]
		);
		$this->add_control(
			'tagline', [
				'label' => __( 'Tagline', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		$this->add_control(
			'heading_text',
			[
				'label' => __( 'Main Heading', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'title' => __( 'To highligt heading use color tag eg: {color} Awesome </color>', 'propertya-elementor' ),
				'rows' => 3,
				'placeholder' => __( 'To highligt heading use color tag eg: {color} Awesome </color>', 'propertya-elementor' ),
			]
		);
		$this->add_control(
			'phone', [
				'label' => __( 'Phone No', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default' => __( '012-345-6789', 'propertya-elementor' ),
			]
		);
		$this->add_control(
			'email', [
				'label' => __( 'Email', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default' => __( 'your@email.com', 'propertya-elementor' ),
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
			'content',
			[
				'label' => __( 'Content', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'Your Content Here', 'propertya-elementor' ),
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
			'video_query',
			[
				'label' => esc_html__( 'Video Section', 'propertya-elementor' ),
			]
		);
		$this->add_control(
			'videolink', [
				'label' => __( 'Youtube Video Link', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		$this->add_control(
			'image_first',
			[
				'label' => __( 'First Image', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_control(
			'image_second',
			[
				'label' => __( 'Second Image', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->end_controls_section();
	}
	
		protected function render() {
		// get our input from the widget settings.
		$settings = $this->get_settings_for_display();
		$params['tagline'] = $settings['tagline'];
		$params['main_heading'] = $settings['heading_text'];
		$params['content'] = $settings['content'];
		$params['phone'] = $settings['phone'];
		$params['email'] = $settings['email'];
		//main button
		$params['main_btn']['title'] = $settings['main_btn_title'];
		$params['main_btn']['link'] = $settings['main_btn_link']['url'];
		$params['main_btn']['is_external'] = $settings['main_btn_link']['is_external'];
		$params['main_btn']['nofollow'] = $settings['main_btn_link']['nofollow'];
		//video
		$params['videolink'] = $settings['videolink'] ? $settings['videolink'] : '';
		$params['first_image'] = $settings['image_first']['url'] ? $settings['image_first']['url'] : '';
		$params['second_image'] = $settings['image_second']['url'] ? $settings['image_second']['url'] : '';
			echo propertya_elementor_about_us($params);
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