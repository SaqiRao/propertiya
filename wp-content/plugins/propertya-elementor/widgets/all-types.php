<?php
namespace ElementorRealEstate\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Types extends Widget_Base {
	
	public function get_name() {
		return 'all-types';
	}
	
	public function get_title() {
		return __( 'All Types', 'propertya-elementor' );
	}
	
	public function get_icon() {
		return 'eicon-post-list';
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
	 
	public function get_customparant_terms($taxonomy)
	{
		$type = array();
		$terms = get_terms( array( 'taxonomy' => $taxonomy, 'parent' => 0, 'hide_empty' => 0 ));
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) )
		{
			foreach ( $terms as $term ) {
				$type[$term->slug] = $term->name . ' (' . $term->count . ')';				
			}
		}
		return $type;
	}	 
	 
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

		$this->add_control(
			'posts_per_page',
			[
				'label' => __( 'Sub Category Limit', 'propertya-elementor' ),
				'label_block' =>true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 4,
			]
		);	
		$this->end_controls_section();
		
		$this->start_controls_section(
			'types_selection',
			[
				'label' => esc_html__( 'Select Property Types', 'propertya-elementor' ),
			]
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'categories',
			[
				'label' => __( 'Select Type', 'propertya-elementor' ),
				'label_block'=>true,
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => false,
				'options' =>  $this->get_customparant_terms('property_type'),
				'default' => ['all'],
			]
		);
		$repeater->add_control(
			'image',
			[
				'label' => __( 'Icon', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'description' => __( 'Recommended icon size 128x128', 'propertya-elementor' ),
			]
		);
		$this->add_control(
			'list',
			[
				'label' => __( 'Select Types', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ categories }}}',
			]
		);
		
		$this->end_controls_section();
		
	}
	
		protected function render() {
		// get our input from the widget settings.
		$blocks = array();
		$settings = $this->get_settings_for_display();
		$params['subtitle'] = $settings['heading_text'] ? $settings['heading_text'] : '';
		$params['maintitle'] = $settings['item_description'] ? $settings['item_description'] : '';
		$params['heading_style'] = $settings['heading_style'] ? $settings['heading_style'] : 'center';
		$params['no_of_post'] = $settings['posts_per_page'] ? (int)$settings['posts_per_page'] : 4;
		if(!empty($settings['list']))
		{
			foreach (  $settings['list'] as $item ) {
				$blocks[] = array(
					'type_slug' => $item['categories'],
					'image' => $item['image']['url'] ? $item['image']['url'] : '',
				);
			}
		}
		$params['types'] = $blocks;
			echo propertya_elementor_all_categories($params);
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