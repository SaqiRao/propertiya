<?php
namespace ElementorRealEstate\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Hero_Two extends Widget_Base {
	
	public function get_name() {
		return 'hero-two';
	}
	
	public function get_title() {
		return __( 'Hero Section 2', 'propertya-elementor' );
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
			'widget_type',
			[
				'label' => __( 'Shortcode Type', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'agencies',
				'label_block' =>true,
				'description' => __( 'Select shortcode type to display on the frontend.', 'propertya-elementor' ),
				'options' => [
					'agencies'  => __( 'Agencies', 'propertya-elementor' ),
					'agents' => __( 'Agents', 'propertya-elementor' ),
					'properties' => __( 'Properties', 'propertya-elementor' ),
				],
			]
		);
		$this->add_control(
			'sub_title',
			[
				'label' => __( 'Sub Title', 'propertya-elementor' ),
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
			'image',
			[
				'label' => __( 'Front Image', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'description' => __( 'Recommended image size 350x230', 'propertya-elementor' ),
			]
		);
		$this->add_control(
			'background',
			[
				'label' => __( 'Background Image', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'description' => __( 'Transparent image recommended size 500x786', 'propertya-elementor' ),
			]
		);
		
		$this->add_control(
			'background_color',
			[
				'label' => __( 'Background Image Color', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => 'rgba(34, 150, 249, 0.7)',
				'scheme' => [
					'type' => \Elementor\Core\Schemes\Color::get_type(),
					'value' => \Elementor\Core\Schemes\Color::COLOR_1,				 
				],
				'selectors' => [
					'{{WRAPPER}} .build-bg' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();
		
		 $this->start_controls_section(
            'content_section',
            [
                'label'     => esc_html__( 'Other', 'propertya-elementor' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );
		
		$this->add_control(
			'selection_type',
			[
				'label' => __( 'Show Agencies/Agents', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'agency',
				'options' => [
				    'no'  => __( 'No', 'propertya-elementor' ),
					'agency'  => __( 'Agencies', 'propertya-elementor' ),
					'agent' => __( 'Agents', 'propertya-elementor' ),

				],
			]
		);
		
		 $this->add_control(
            'top_title',
            [
                'label'     => esc_html__( 'Title', 'propertya-elementor' ),
                'type'      => Controls_Manager::TEXT,
				'default' => esc_html__( 'Top Agencies', 'propertya-elementor' ),
				'condition' => [
                    'selection_type' => [ 'agency', 'agent' ]
                ],
            ]
        );
		
		$this->add_control(
			'selection_status',
			[
				'label' => __( 'Select Type', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'all',
				'options' => [
					'featured'  => __( 'Featured', 'propertya-elementor' ),
					'trusted' => __( 'Trusted', 'propertya-elementor' ),
					'all' => __( 'All', 'propertya-elementor' ),
				],
				'condition' => [
                    'selection_type' => [ 'agency', 'agent' ]
                ],
			]
		);
		
		 $this->add_control(
            'limit',
            [
                'label'     => esc_html__( 'Limit', 'propertya-elementor' ),
                'type'      => Controls_Manager::TEXT,
				'default' => '3',
                'description'   => esc_html__( 'Number of results to show.', 'propertya-elementor' ),
				'condition' => [
                    'selection_type' => [ 'agency', 'agent' ]
                ],
            ]
        );
			
	}
	
		protected function render() {
		// get our input from the widget settings.
		$settings = $this->get_settings_for_display();
		$params['widget_type'] = $settings['widget_type'];
		$params['sub_title'] = $settings['sub_title'];
		$params['heading_text'] = $settings['heading_text'];
		$params['desc'] = $settings['item_description'];
		$params['image'] = $settings['image']['url'] ? $settings['image']['url'] : '';
		$params['background'] = $settings['background']['url'] ? $settings['background']['url'] : '';
		$params['selection_type'] = $settings['selection_type'] ? $settings['selection_type'] : 'agencies';
		$params['top_title'] = $settings['top_title'];
		$params['selection_status'] = $settings['selection_status'] ? $settings['selection_status'] : 'all';
		$params['limit'] = $settings['limit'] ? $settings['limit'] : '3';
		
			echo propertya_elementor_hero2($params);
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