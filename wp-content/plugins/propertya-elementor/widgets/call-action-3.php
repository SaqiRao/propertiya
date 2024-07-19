<?php
namespace ElementorRealEstate\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class CallAction_Three extends Widget_Base {
	
	public function get_name() {
		return 'call-action-three';
	}
	
	public function get_title() {
		return __( 'Call To Action 3', 'propertya-elementor' );
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
				'label' => esc_html__( 'Content', 'propertya-elementor' ),
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
		$this->end_controls_section();	
	}
	
		protected function render() {
		// get our input from the widget settings.
		$settings = $this->get_settings_for_display();
		$params['tagline'] = $settings['tagline'];
		$params['heading_text'] = $settings['heading_text'];
		$params['desc'] = $settings['item_description'];
		//main button
		$params['main_btn']['title'] = $settings['main_btn_title'];
		$params['main_btn']['link'] = $settings['main_btn_link']['url'];
		$params['main_btn']['is_external'] = $settings['main_btn_link']['is_external'];
		$params['main_btn']['nofollow'] = $settings['main_btn_link']['nofollow'];
		
			echo propertya_elementor_call_to_action_three($params);
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