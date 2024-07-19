<?php
namespace ElementorRealEstate\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class All_Agencies extends Widget_Base {
	
	public function get_name() {
		return 'all-agencies';
	}
	
	public function get_title() {
		return __( 'All Agencies', 'propertya-elementor' );
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
			'section_query',
			[
				'label' => esc_html__( 'Section Heading', 'propertya-elementor' ),
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
				'label' => esc_html__( 'Agency Settings', 'propertya-elementor' ),
			]
		);
		
		$this->add_control(
			'type',
			[
				'label' => __( 'Agency Type', 'propertya-elementor' ),
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
				'default' => 'grid1',
				'options' => [
					'grid1'  => __( 'Agency Grid 1', 'propertya-elementor' ),
					'grid2' => __( 'Agency Grid 2', 'propertya-elementor' ),
					'grid3' => __( 'Agency Grid 3', 'propertya-elementor' ),
					'grid4' => __( 'Agency Grid 4', 'propertya-elementor' ),
					'grid5' => __( 'Agency Grid 5', 'propertya-elementor' ),
					'grid6' => __( 'Agency Grid 6', 'propertya-elementor' ),
				],
			]
		);
		
		
		$this->add_control(
			'posts_per_page',
			[
				'label'   => __( 'Number of Agencies', 'propertya-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 6,
				'options' => [
					3  => __( 'Three', 'propertya-elementor' ),
					6  => __( 'Six', 'propertya-elementor' ),
					8  => __( 'Eight','propertya-elementor' ),
					9  => __( 'Nine','propertya-elementor' ),
					12 => __( 'Twelve', 'propertya-elementor' ),
					15 => __( 'Fifteen', 'propertya-elementor' ),
					-1 => __( 'All', 'propertya-elementor' ),
				]
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
			echo propertya_elementor_all_agencies($params);
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