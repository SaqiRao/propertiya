<?php
namespace ElementorRealEstate\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Testimonials extends Widget_Base {
	
	public function get_name() {
		return 'testimonial-one';
	}
	
	public function get_title() {
		return __( 'Testimonials', 'propertya-elementor' );
	}
	
	public function get_icon() {
		return 'eicon-comments';
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
				'label' => esc_html__( 'Testimonials', 'propertya-elementor' ),
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
		
		$repeater->add_control(
			'list_content', [
				'label' => __( 'Content', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'show_label' => true,
				'rows' => 10,
			]
		);
		
		$repeater->add_control(
			'testi_name', [
				'label' => __( 'Name', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		
		$repeater->add_control(
			'testi_type', [
				'label' => __( 'Type', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		
		$this->add_control(
			'list',
			[
				'label' => __( 'Testimonials Grids', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ testi_name }}}',
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
					'feedback' => $item['testi_name'],
					'type' => $item['testi_type'],
					'content' => $item['list_content'],
					'image' => $item['image']['url'] ? $item['image']['url'] : '',
				);
			}
		}
		$params['blocks'] = $blocks;
			echo propertya_elementor_testimonials($params);
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