<?php
namespace ElementorRealEstate\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class All_Listings extends Widget_Base {
	
	public function get_name() {
		return 'all-listings';
	}
	
	public function get_title() {
		return __( 'All Listings', 'propertya-elementor' );
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
		$type = ['all' => 'All'];
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) )
		{
			foreach ( $terms as $term ) {
				$type[$term->term_id] = $term->name . ' (' . $term->count . ')';				
			}
		}
		return $type;
	}
	 
	 
	protected function register_controls() {
		$type = array();
		
		$all_locations = array();
		propertya_framework_terms_array('property_location' , $all_locations);
		
		$all_ty = array();
		propertya_framework_terms_array('property_type' , $all_ty);
		
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
			'section_settings',
			[
				'label' => esc_html__( 'Listing Filters', 'propertya-elementor' ),
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
			'listing_type',
			[
				'label' => __( 'Listing Type', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'featured',
				'options' => [
					'all'  => __( 'All', 'propertya-elementor' ),
					'simple' => __( 'Simple', 'propertya-elementor' ),
					'featured' => __( 'Featured', 'propertya-elementor' ),
				],
			]
		);
		
		$this->add_control(
			'listing_order',
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
			'listing_layout',
			[
				'label' => __( 'Layout Type', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'type5',
				'options' => [
					'type1'  => __( 'Grid Style 1', 'propertya-elementor' ),
					'type2' => __( 'Grid Style 2', 'propertya-elementor' ),
					'type3' => __( 'Grid Style 3', 'propertya-elementor' ),
					'type4' => __( 'Grid Style 4', 'propertya-elementor' ),
					'type5' => __( 'Grid Style 5', 'propertya-elementor' ),
					'type6' => __( 'Grid Style 6', 'propertya-elementor' ),
					'type7' => __( 'Grid Style 7', 'propertya-elementor' ),
					'classic' => __( 'Classic List', 'propertya-elementor' ),
				],
			]
		);
		
		$this->add_control(
			'listing_status',
			[
				'label' => __( 'Offer Type', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'all',
				'options' =>  $this->get_customparant_terms('property_status')
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
					'3'  => __( '3 Columns', 'propertya-elementor' ),
					'2' => __( '2 Columns', 'propertya-elementor' ),
				],
				'condition' => [
					'listing_layout!' => 'classic',
				],
			   /*'conditions' => [
			   'terms' => [
					[
						'name' => 'listing_layout',
						'operator' => '!==',
						'value' => 'classic',
					],
				],
			],*/
			]
		);
		
		$this->add_control(
			'posts_per_page',
			[
				'label' => __( 'Number of Listings', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 60,
				'step' => 1,
				'default' => 6,
			]
		);
		
		$this->add_control(
			'location',
			[
				'label' => __( 'Select Locations', 'propertya-elementor' ),
				'label_block'=>true,
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => false,
				'options' => $all_locations,
				'description' => __( 'Show properties for a particular location', 'propertya-elementor' ),
			]
		);	
		
		$this->add_control(
			'categories',
			[
				'label' => __( 'Select Type', 'propertya-elementor' ),
				'label_block'=>true,
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $this->get_customparant_terms('property_type'),
				'default' => ['all'],
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
		$params['listing_type'] = $settings['listing_type'] ? $settings['listing_type'] : 'all';
		$params['orderby'] = $settings['listing_order'] ? $settings['listing_order'] : 'desc';
		$params['layout'] = $settings['listing_layout'] ? $settings['listing_layout'] : 'type5';
		$params['listing_status'] = $settings['listing_status'] ? $settings['listing_status'] : 'all';
		$params['location_id'] = $settings['location'] ? $settings['location'] : '';
		$params['no_of_post'] = $settings['posts_per_page'] ? (int)$settings['posts_per_page'] : 6;
		$params['listing_column'] = $settings['listing_column'] ? (int)$settings['listing_column'] : 3;
		$params['categories'] = $settings['categories'] ? $settings['categories'] : 'all';
		
			echo propertya_elementor_all_listings($params);
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