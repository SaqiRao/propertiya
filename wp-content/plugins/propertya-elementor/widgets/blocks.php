<?php
namespace ElementorRealEstate\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Block extends Widget_Base {
	
	public function get_name() {
		return 'block-one';
	}
	
	public function get_title() {
		return __( 'Block Section', 'propertya-elementor' );
	}
	
	public function get_icon() {
		return 'eicon-tabs';
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
			'icon',
			[
				'label' => __( 'Icon', 'propertya-elementor' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid',
				],
			]
		);
		
		$repeater->add_control(
			'list_title', [
				'label' => __( 'Title', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Grid Title' , 'propertya-elementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'list_content', [
				'label' => __( 'Content', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'Content' , 'propertya-elementor' ),
				'show_label' => true,
				'rows' => 10,
			]
		);
		
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
				'label' => __( 'Block Grids', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ list_title }}}',
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
					'title' => $item['list_title'],
					'content' => $item['list_content'],
					'icon' => $item['icon'],
					'image' => $item['image']['url'] ? $item['image']['url'] : '',
				);
			}
		}
		$params['blocks'] = $blocks;
			echo propertya_elementor_block($params);
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