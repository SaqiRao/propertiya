<?php
namespace ElementorRealEstate\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Hero_Four extends Widget_Base {
	
	public function get_name() {
		return 'hero-four';
	}
	
	public function get_title() {
		return __( 'Hero Section 4', 'propertya-elementor' );
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
				'description' => __( 'Highligt heading use color tag eg: {color} Awesome </color>', 'propertya-elementor' ),
				'default' => __( 'Content goes here..', 'propertya-elementor' ),
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_filters',
			[
				'label' => esc_html__( 'Filters', 'propertya-elementor' ),
			]
		);
		
		$this->add_control(
            'btn_text',
            [
                'label' => __( 'Button Text', 'propertya-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Search', 'propertya-elementor' ),
				'description' => __( 'Only two filters are allowed in this widget', 'propertya-elementor' ),
            ]
        );
		
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
            'filter_type',
            [
                'label' => esc_html__( 'Filter Type', 'propertya-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' =>  $this->get_filter_fields(),
                'default' => 'text',
            ]
        );
		$repeater->add_control(
            'field_label',
            [
                'label' => __( 'Label', 'propertya-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
            ]
        );
		$repeater->add_control(
            'field_place',
            [
                'label' => __( 'Placeholder', 'propertya-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
				'conditions' => [
                    'terms' => [
                        [
                            'name' => 'filter_type',
                            'operator' => '!in',
                            'value' => [
                                'price',
								'area',
                            ],
                        ],
                    ],
                ],
            ]
        );
		$repeater->add_control(
            'min_label',
            [
                'label' => __( 'Min Placeholder', 'propertya-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
				'conditions' => [
                    'terms' => [
                        [
                            'name' => 'filter_type',
                            'operator' => 'in',
                            'value' => [
                                'price',
								'area',
                            ],
                        ],
                    ],
                ],
            ]
        );
		$repeater->add_control(
            'max_label',
            [
                'label' => __( 'Max Placeholder', 'propertya-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
				'conditions' => [
                    'terms' => [
                        [
                            'name' => 'filter_type',
                            'operator' => 'in',
                            'value' => [
                                'price',
								'area',
                            ],
                        ],
                    ],
                ],
            ]
        );
		
		$this->add_control(
			'list',
			[
				'label' => __( 'Select Filters', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'filter_type' => 'keyword',
						'field_label' => __( 'Explore', 'propertya-elementor' ),
						'field_place' => __( 'What are you looking for...', 'propertya-elementor' ),
					],
					[
						'filter_type' => 'type',
						'field_label' => __( 'Type', 'propertya-elementor' ),
						'field_place' => __( 'Select Type', 'propertya-elementor' ),
					],
				],
				'title_field' => '{{{ field_label }}}',
				
			]
		);
		
		$this->end_controls_section();
	}
	
		protected function render() {
		// get our input from the widget settings.
		$settings = $this->get_settings_for_display();
		$params['heading_text'] = $settings['heading_text'];
		$params['tagline'] = $settings['tagline'];
		$params['btn_text'] = $settings['btn_text'];
		$params['filter_array'] = $settings['list'];
		//main button
			echo propertya_elementor_hero4($params);
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