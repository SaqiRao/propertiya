<?php
namespace ElementorRealEstate\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class All_Agents extends Widget_Base {
	
	public function get_name() {
		return 'all-agents';
	}
	
	public function get_title() {
		return __( 'All Agents', 'propertya-elementor' );
	}
	
	public function get_icon() {
		return 'eicon-person';
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
		$type = array();
		$this->start_controls_section(
			'section_heading',
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
			'section_settings',
			[
				'label' => esc_html__( 'Agents Settings', 'propertya-elementor' ),
			]
		);
		$this->add_control(
            'show_loadmore',
            [
                'label' => esc_html__( 'Hide Load More Button', 'propertya-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'propertya-elementor' ),
                'label_off' => esc_html__( 'No', 'propertya-elementor' ),
                'return_value' => 'none',
                'default' => 'no',
                'selectors' => [
                    '{{WRAPPER}} .is-show-load-more' => 'display: {{VALUE}};',
                ],
            ]
        );
		$this->add_control(
			'type',
			[
				'label' => __( 'Agent Type', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'all',
				'options' => [
					'all'  => __( 'All', 'propertya-elementor' ),
					'simple' => __( 'Simple', 'propertya-elementor' ),
					'featured' => __( 'Featured', 'propertya-elementor' ),
					'trusted' => __( 'Trusted', 'propertya-elementor' ),
				],
			]
		);
		$this->add_control(
			'order',
			[
				'label' => __( 'OrderBy', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'desc'  => __( 'Latest', 'propertya-elementor' ),
					'asc' => __( 'Oldest', 'propertya-elementor' ),
					'rand' => __( 'Random', 'propertya-elementor' ),
				],
			]
		);
		$this->add_control(
			'layout',
			[
				'label' => __( 'Layout Type', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'type1',
				'options' => [
					'type1'  => __( 'Agent Style 1', 'propertya-elementor' ),
					'type2' => __( 'Agent Style 2', 'propertya-elementor' ),
					
				],
			]
		);
		$this->add_control(
			'listing_column',
			[
				'label' => __( 'Column Size', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '3',
				'description' => __( 'Use 2 columns only when using sidebar.', 'propertya-elementor' ),
				'options' => [
					'4'  => __( '4 Columns', 'propertya-elementor' ),
					'3'  => __( '3 Columns', 'propertya-elementor' ),
					'2' => __( '2 Columns', 'propertya-elementor' ),
				],
			]
		);
		$this->add_control(
			'posts_per_page',
			[
				'label'   => __( 'Number of Agents', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 6,
			]
		);
		$this->end_controls_section();	
	}
	
		protected function render() {
		// get our input from the widget settings.
		$settings = $this->get_settings_for_display();
		$params['subtitle'] = $settings['heading_text'] ? $settings['heading_text'] : '';
		$params['maintitle'] = $settings['item_description'] ? $settings['item_description'] : '';
		$params['heading_style'] = $settings['heading_style'] ? $settings['heading_style'] : 'center';
		$params['type'] = $settings['type'] ? $settings['type'] : 'all';
		$params['order'] = $settings['order'] ? $settings['order'] : 'desc';
		$params['layout'] = $settings['layout'] ? $settings['layout'] : 'grid1';
		$params['no_of_post'] = $settings['posts_per_page'] ? (int)$settings['posts_per_page'] : 6;
		$params['listing_column'] = $settings['listing_column'] ? (int)$settings['listing_column'] : 3;		
			echo propertya_elementor_all_agents($params);
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