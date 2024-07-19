<?php
namespace ElementorRealEstate\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Hero_Six extends Widget_Base {
	
	public function get_name() {
		return 'hero-six';
	}
	
	public function get_title() {
		return __( 'Hero Section 6', 'propertya-elementor' );
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
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Content goes here..', 'propertya-elementor' ),
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
			'show_property_tab',
			[
				'label' => __( 'Show Property Tab', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'propertya-elementor' ),
				'label_off' => __( 'Hide', 'propertya-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		
		$this->add_control(
            'prop_tab_text',
            [
                'label' => __( 'Tab Text', 'propertya-elementor' ),
                'type' => Controls_Manager::TEXT,
				'label_block'=>true,
				'condition' => [
					'show_property_tab' => 'yes',
				],
            ]
        );
		
		$this->add_control(
			'show_agency_tab',
			[
				'label' => __( 'Show Agency Tab', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'propertya-elementor' ),
				'label_off' => __( 'Hide', 'propertya-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		
		$this->add_control(
            'agency_tab_text',
            [
                'label' => __( 'Tab Text', 'propertya-elementor' ),
                'type' => Controls_Manager::TEXT,
				'label_block'=>true,
				'condition' => [
					'show_agency_tab' => 'yes',
				],
            ]
        );
		
		$this->add_control(
			'show_agent_tab',
			[
				'label' => __( 'Show Agent Tab', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'propertya-elementor' ),
				'label_off' => __( 'Hide', 'propertya-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		
		$this->add_control(
            'agent_tab_text',
            [
                'label' => __( 'Tab Text', 'propertya-elementor' ),
                'type' => Controls_Manager::TEXT,
				'label_block'=>true,
				'condition' => [
					'show_agent_tab' => 'yes',
				],
            ]
        );
		
		$this->end_controls_section();
		$this->start_controls_section(
			'section_filters',
			[
				'label' => esc_html__( 'Property Filters', 'propertya-elementor' ),
			]
		);
		
		$this->add_control(
            'btn_text',
            [
                'label' => __( 'Button Text', 'propertya-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Search', 'propertya-elementor' ),
				'label_block'=>true,
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
            'column_size',
            [
                'label' => __( 'Column Size', 'propertya-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '4',
				'options' => [
					'1'  => 1,
					'2' => 2,
					'3' => 3,
					'4' => 4,
					'5' => 5,
					'6' => 6,
					'7' => 7,
					'8' => 8,
					'9' => 9,
					'10' => 10,
					'11' => 11,
					'12' => 12,
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
		$this->start_controls_section(
            'agency_section',
            [
                'label'     => esc_html__( 'Agency Filters', 'propertya-elementor' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );
		$this->add_control(
            'agency_btn_text',
            [
                'label' => __( 'Button Text', 'propertya-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Search', 'propertya-elementor' ),
				'label_block'=>true,
            ]
        );
		$this->add_control(
            'keyfield_label',
            [
                'label'     => esc_html__('Title Field label', 'propertya-elementor'),
                'type'      => Controls_Manager::TEXT,
				'label_block'=>true,
				'default' => esc_html__('Title Here', 'propertya-elementor'),
            ]
        );
		$this->add_control(
            'field_placeholder',
            [
                'label'     => esc_html__('Title Field Placeholder', 'propertya-elementor'),
                'type'      => Controls_Manager::TEXT,
				'default' => esc_html__('Placeholder Here', 'propertya-elementor'),
				'label_block'=>true,
            ]
        );
		$this->add_control(
            'loc_field_label',
            [
                'label'     => esc_html__('Location Field Label', 'propertya-elementor'),
                'type'      => Controls_Manager::TEXT,
				'label_block'=>true,
				'default' => esc_html__('Title Here', 'propertya-elementor'),
            ]
        );
		$this->add_control(
            'loc_field_placeholder',
            [
                'label'     => esc_html__('Location Field Placeholder', 'propertya-elementor'),
                'type'      => Controls_Manager::TEXT,
				'label_block'=>true,
				'default' => esc_html__('Placeholder Here', 'propertya-elementor'),
            ]
        );
		$this->end_controls_section();
		$this->start_controls_section(
            'agent_section',
            [
                'label'     => esc_html__( 'Agents Filters', 'propertya-elementor' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );
		$this->add_control(
            'agent_btn_text',
            [
                'label' => __( 'Button Text', 'propertya-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Search', 'propertya-elementor' ),
				'label_block'=>true,
            ]
        );
		$this->add_control(
            'agkeyfield_label',
            [
                'label'     => esc_html__('Title Field label', 'propertya-elementor'),
                'type'      => Controls_Manager::TEXT,
				'label_block'=>true,
				'default' => esc_html__('Title Here', 'propertya-elementor'),
            ]
        );
		$this->add_control(
            'agfield_placeholder',
            [
                'label'     => esc_html__('Title Field Placeholder', 'propertya-elementor'),
                'type'      => Controls_Manager::TEXT,
				'default' => esc_html__('Placeholder Here', 'propertya-elementor'),
				'label_block'=>true,
            ]
        );
		$this->add_control(
            'agtype_field_label',
            [
                'label'     => esc_html__('Agent Type Field Label', 'propertya-elementor'),
                'type'      => Controls_Manager::TEXT,
				'label_block'=>true,
				'default' => esc_html__('Title Here', 'propertya-elementor'),
            ]
        );
		$this->add_control(
            'agtype_field_placeholder',
            [
                'label'     => esc_html__('Agent Type Field Placeholder', 'propertya-elementor'),
                'type'      => Controls_Manager::TEXT,
				'label_block'=>true,
				'default' => esc_html__('Placeholder Here', 'propertya-elementor'),
            ]
        );
		$this->add_control(
            'agloc_field_label',
            [
                'label'     => esc_html__('Location Field Label', 'propertya-elementor'),
                'type'      => Controls_Manager::TEXT,
				'label_block'=>true,
				'default' => esc_html__('Title Here', 'propertya-elementor'),
            ]
        );
		$this->add_control(
            'agloc_field_placeholder',
            [
                'label'     => esc_html__('Location Field Placeholder', 'propertya-elementor'),
                'type'      => Controls_Manager::TEXT,
				'label_block'=>true,
				'default' => esc_html__('Placeholder Here', 'propertya-elementor'),
            ]
        );
		$this->end_controls_section();
		
	}
	
		protected function render() {
		// get our input from the widget settings.
		$settings = $this->get_settings_for_display();
		$params['heading_text'] = $settings['heading_text'];
		$params['tagline'] = $settings['tagline'];
		
		$params['show_property_tab'] = $settings['show_property_tab'];
		$params['show_agency_tab'] = $settings['show_agency_tab'];
		$params['show_agent_tab'] = $settings['show_agent_tab'];
		
		$params['prop_tab_text'] = $settings['prop_tab_text'] ? $settings['prop_tab_text'] : esc_html__( 'Properties', 'propertya-elementor' );
		$params['agency_tab_text'] = $settings['agency_tab_text'] ? $settings['agency_tab_text'] : esc_html__( 'Find Agencies', 'propertya-elementor' );
		$params['agent_tab_text'] = $settings['agent_tab_text'] ? $settings['agent_tab_text'] : esc_html__( 'Find Agents', 'propertya-elementor' );
		
		//agecny tab fields
		$params['keyfield_label'] = $settings['keyfield_label'];
		$params['field_placeholder'] = $settings['field_placeholder'];
		$params['loc_field_label'] = $settings['loc_field_label'];
		$params['loc_field_placeholder'] = $settings['loc_field_placeholder'];
		$params['agency_btn_text'] = $settings['agency_btn_text'];
		
		//agent tab fields
		$params['agkeyfield_label'] = $settings['agkeyfield_label'];
		$params['agfield_placeholder'] = $settings['agfield_placeholder'];
		$params['agtype_field_label'] = $settings['agtype_field_label'];
		$params['agtype_field_placeholder'] = $settings['agtype_field_placeholder'];
		$params['agloc_field_label'] = $settings['agloc_field_label'];
		$params['agloc_field_placeholder'] = $settings['agloc_field_placeholder'];
		$params['agent_btn_text'] = $settings['agent_btn_text'];
		
		$params['btn_text'] = $settings['btn_text'];
		$params['filter_array'] = $settings['list'];
		//main button
			echo propertya_elementor_hero6($params);
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