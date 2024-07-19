<?php
namespace ElementorRealEstate\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Partners extends Widget_Base {
	
	public function get_name() {
		return 'partners-all';
	}
	
	public function get_title() {
		return __( 'Partners Section', 'propertya-elementor' );
	}
	
	public function get_icon() {
		return 'eicon-slider-3d';
	}

	public function get_categories() {
		return [ 'sonutheme' ];
	}
	
	public function get_script_depends() {
		return [ '' ];
	}
	
	protected function register_controls() {
		
		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Blocks', 'propertya-elementor' ),
			]
		);
		
		
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		
		$this->add_control(
			'list',
			[
				'label' => __( 'Ad Partners', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
			]
		);

		$this->end_controls_section();
		
	}
		protected function render() {
		// get our input from the widget settings.
		$settings = $this->get_settings_for_display();
		$blocks = $params = array();
		if(!empty($settings['list']))
		{
			foreach (  $settings['list'] as $item ) {
				$blocks[] = array(
					'image' => $item['image']['url'] ? $item['image']['url'] : '',
				);
			}
		}
		$params['blocks'] = $blocks;
			echo propertya_elementor_partners($params);
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