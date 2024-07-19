<?php
namespace ElementorRealEstate\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Hero_Eight extends Widget_Base {
	
	public function get_name() {
		return 'hero-eight';
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
	public function get_filter_fields()
	{
		$fields = array();
		return $fields = [
            'keyword' => esc_html__( 'Keyword', 'propertya-elementor' ), //input
            'type' => esc_html__( 'Type', 'propertya-elementor' ), //select
            'offer' => esc_html__( 'Offer Type', 'propertya-elementor' ), //select
            'label' => esc_html__( 'Label', 'propertya-elementor' ), //select
			'location' => esc_html__( 'Location', 'propertya-elementor' ), // select
			'currency' => esc_html__( 'Currency', 'propertya-elementor' ), // select
            'bed' => esc_html__( 'Bedrooms', 'propertya-elementor' ), //select
            'bath' => esc_html__( 'Bathrooms', 'propertya-elementor' ), //select
            'price' => esc_html__( 'Price', 'propertya-elementor' ), // input
            'area' => esc_html__( 'Area', 'propertya-elementor' ), // input
        ];
	}  
	protected function register_controls() {
		
		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Hero Content', 'propertya-elementor' ),
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
				'rows' => 10,
				'placeholder' => __( 'Type your description here', 'propertya-elementor' ),
			]
		);
		$this->add_control(
			'place_text',
			[
				'label' => __( 'Placeholder Field', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Type your title here', 'propertya-elementor' ),
				'label_block' => true,
				'default' => __( "Keyword (e.g office , landmark, project)", 'propertya-elementor' ),
			]
		);
		$this->add_control(
			'btn_text',
			[
				'label' => __( 'Search Button Text', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Type your title here', 'propertya-elementor' ),
				'label_block' => true,
				'default' => __( 'Search.', 'propertya-elementor' ),
			]
		);
		$this->end_controls_section();
	}
	
		protected function render() {
		// get our input from the widget settings.
		$settings = $this->get_settings_for_display();
		$params['heading_text'] = $settings['heading_text'];
		$params['desc'] = $settings['item_description'];
		$params['btn_text'] = $settings['btn_text'];
		$params['place_text'] = $settings['place_text'];
		//main button
			echo propertya_elementor_hero8($params);
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