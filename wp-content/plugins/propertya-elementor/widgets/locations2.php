<?php
namespace ElementorRealEstate\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Locations2 extends Widget_Base {
	
	public function get_name() {
		return 'prop-selective-locations2';
	}
	
	public function get_title() {
		return __( 'Locations Style 2', 'propertya-elementor' );
	}
	
	public function get_icon() {
		return 'eicon-sitemap';
	}

	public function get_categories() {
		return [ 'sonutheme' ];
	}
	
	public function get_script_depends() {
		return [ '' ];
	}
	
	 
	protected function register_controls() {
		
		$all_locations = array();
		propertya_framework_terms_array('property_location' , $all_locations);
		
		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Section Heading', 'propertya-elementor' ),
			]
		);
		$this->add_control(
            'hide_heading',
            [
                'label' => esc_html__( 'Hide Section Heading', 'propertya-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'propertya-elementor' ),
                'label_off' => esc_html__( 'No', 'propertya-elementor' ),
                'return_value' => 'none',
                'default' => 'no',
                'selectors' => [
                    '{{WRAPPER}} .sec-heading-zone' => 'display: {{VALUE}};',
                ],
            ]
        );
		$this->add_control(
			'heading_text',
			[
				'label' => __( 'Sub Title', 'propertya-elementor' ),
				'label_block' =>true,
				'default' => __( 'Subtitle Here', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'item_description',
			[
				'label' => __( 'Main Title', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 4,
				'default' => __( 'Main Heading Here', 'propertya-elementor' ),
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
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'location_query',
			[
				'label' => esc_html__( 'Locations', 'propertya-elementor' ),
			]
		);
		
		$repeater = new \Elementor\Repeater();
		
		$repeater->add_control(
			'location',
			[
				'label' => __( 'Select Locations', 'propertya-elementor' ),
				'label_block'=>true,
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => false,
				'options' => $all_locations,
			]
		);	
		$repeater->add_control(
			'image',
			[
				'label' => __( 'First Image', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'description' => __( 'Recommended image size 350x230', 'propertya-elementor' ),
			]
		);
		
		$this->add_control(
			'list',
			[
				'label' => __( 'Locations Grids', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ location }}}',
			]
		);
		$this->end_controls_section();
			
	}
	
		protected function render() {
		// get our input from the widget settings.
		$blocks = $params = array();
		$settings = $this->get_settings_for_display();
		$params['subtitle'] = $settings['heading_text'] ? $settings['heading_text'] : '';
		$params['maintitle'] = $settings['item_description'] ? $settings['item_description'] : '';
		$params['heading_style'] = $settings['heading_style'] ? $settings['heading_style'] : 'center';
		if(!empty($settings['list']))
		{
			foreach (  $settings['list'] as $item ) {
				$blocks[] = array(
					'location_id' => $item['location'],
					'image' => $item['image']['url'] ? $item['image']['url'] : '',
				);
			}
		}
		$params['locations'] = $blocks;
			echo propertya_elementor_selective_locations_style2($params);
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