<?php
namespace ElementorRealEstate\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Packages extends Widget_Base {
	
	public function get_name() {
		return 'woo-packages';
	}
	
	public function get_title() {
		return __( 'Membership Packages', 'propertya-elementor' );
	}
	
	public function get_icon() {
		return 'eicon-form-horizontal';
	}

	public function get_categories() {
		return [ 'sonutheme' ];
	}
	
	public function get_script_depends() {
		return [ '' ];
	}
	
	protected function register_controls() {
		
       $products = array(); 
       if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) || class_exists('WooCommerce'))
       {
           $args = array(
                'post_type' => 'product',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_type',
                        'field' => 'slug',
                        'terms' => 'propertya_packages'
                    ),
                ),
                'fields' => 'ids',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'order' => 'DESC',
                'orderby' => 'date'
            );
            $packages = new \WP_Query($args);
            if ($packages->have_posts())
            {
               while ($packages->have_posts())
               {
                    $packages->the_post();
                    $products[get_the_ID()] = get_the_title();
               }
               wp_reset_postdata();    
            }
       }
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
        $this->add_control(
			'package_style',
			[
				'label' => __( 'Packages Style', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'minimal',
				'label_block' =>true,
				'options' => [
					'minimal'  => __( 'Minimal', 'propertya-elementor' ),
					'classic' => __( 'Classic', 'propertya-elementor' ),
				],
			]
		);
		$this->end_controls_section();
        
        $this->start_controls_section(
			'section_settings',
			[
				'label' => esc_html__( 'Select Packages', 'propertya-elementor' ),
			]
		);
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
			'packages',
			[
				'label' => __( 'Select Package', 'propertya-elementor' ),
				'label_block'=>true,
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => false,
				'options' => $products,
			]
		);	
        $this->add_control(
			'list',
			[
				'label' => __( 'Select Packages', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ packages }}}',
			]
		);
		$this->end_controls_section();	
	}
		protected function render() {
		// get our input from the widget settings.
		$settings = $this->get_settings_for_display();
		$packs = $params = array();
        $params['subtitle'] = $settings['heading_text'] ? $settings['heading_text'] : '';
		$params['maintitle'] = $settings['item_description'] ? $settings['item_description'] : '';
		$params['heading_style'] = $settings['heading_style'] ? $settings['heading_style'] : 'center';
        $params['package_style'] = $settings['package_style'] ? $settings['package_style'] : 'minimal';
        if(!empty($settings['list']))
		{
			foreach (  $settings['list'] as $item ) {
			    $selected_package_id = $item['packages'];
			    if (product_exists($selected_package_id)) {
            $packs[] = array(
                'selected_pkg' => $selected_package_id,
            );
        } else {
            // Handle the case where the product doesn't exist, e.g., skip or log it
            // For example, you can use continue; to skip to the next iteration of the loop.
            continue;
        }
				
			}
		} 
	
        $params['packages'] = $packs;  
        echo propertya_elementor_packages($params);
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