<?php
namespace ElementorRealEstate\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class SearchBuilder_Ajax extends Widget_Base {
	
	public function get_name() {
		return 'search-builder-home';
	}
	
	public function get_title() {
		return __( 'Home Search WIth Ajax', 'propertya-elementor' );
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
				'label_block'=>false,
            ]
        );
		$this->add_control(
            'layout_type',
            [
                'label' => __( 'Layout Type', 'propertya-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'list3',
				'options' => [
					'type1'  => 'Grid Style 1',
					'type2' => 'Grid Style 2',
					'type3' => 'Grid Style 3',
					'type4' =>'Grid Style 4',
					'type5' =>'Grid Style 5',
					'type6' =>'Grid Style 6',
					'type7' =>'Grid Style 7',
					'list1' => 'List Style 1',
					'list2' =>'List Style 2',
					'list3' => 'List Style 3',
					'list4' =>'List Style 4',
					'list5' =>'List Style 5',
				],
            ]
        );
        
        $this->add_control(
            'btncolumn_size',
            [
                'label' => __( 'Select Layout Type', 'propertya-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
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
        
		$this->add_control(
			'show_labels',
			[
				'label' => __( 'Hide Field Labels', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'propertya-elementor' ),
				'label_off' => __( 'Hide', 'propertya-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
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
                'default' => '3',
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
					[
						'filter_type' => 'offer',
						'field_label' => __( 'Status', 'propertya-elementor' ),
						'field_place' => __( 'Select Offer', 'propertya-elementor' ),
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
		$params['btn_text'] = $settings['btn_text'];
		$params['show_labels'] = $settings['show_labels'];
		$params['btncolumn_size'] = $settings['btncolumn_size'];
        $params['layout_type'] = $settings['layout_type'];
		$params['filter_array'] = $settings['list'];
			echo propertya_elementor_search_home_ajax($params);
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