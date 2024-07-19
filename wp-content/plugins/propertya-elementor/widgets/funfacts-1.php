<?php
namespace ElementorRealEstate\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class FunFacts1 extends Widget_Base {
	
	public function get_name() {
		return 'fun-one';
	}
	
	public function get_title() {
		return __( 'Funfacts 1', 'propertya-elementor' );
	}
	
	public function get_icon() {
		return 'eicon-counter';
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
				'label' => esc_html__( 'Funfacts Content', 'propertya-elementor' ),
			]
		);
		$this->add_control(
			'tagline', [
				'label' => __( 'Tagline', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		$this->add_control(
			'heading_text',
			[
				'label' => __( 'Main Heading', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'title' => __( 'To highligt heading use color tag eg: {color} Awesome </color>', 'propertya-elementor' ),
				'rows' => 3,
				'placeholder' => __( 'To highligt heading use color tag eg: {color} Awesome </color>', 'propertya-elementor' ),
			]
		);

		$this->add_control(
			'item_description',
			[
				'label' => __( 'Description', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 10,
				'placeholder' => __( 'Type your description here', 'propertya-elementor' ),
			]
		);
		
		$this->add_control(
			'videolink', [
				'label' => __( 'Youtube Video Link', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		
		$this->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_counter',
			[
				'label' => esc_html__( 'Funfacts Counter', 'propertya-elementor' ),
			]
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'number', [
				'label' => __( 'Number', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'text', [
				'label' => __( 'Text', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		
		$this->add_control(
			'list',
			[
				'label' => __( 'FunFact Counter', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
			]
		);
		
		$this->end_controls_section();
			
	}
	
		protected function render() {
			// get our input from the widget settings.
			$settings = $this->get_settings_for_display();
			$blocks = array();
			$params['tagline'] = $settings['tagline'];
			$params['main_heading'] = $settings['heading_text'];
			$params['description'] = $settings['item_description'];
			$params['videolink'] = $settings['videolink'] ? $settings['videolink'] : '';
			$params['videobg'] = $settings['image']['url'] ? $settings['image']['url'] : '';
			if(!empty($settings['list']))
			{
				foreach (  $settings['list'] as $item ) {
					$blocks[] = array(
						'number' => $item['number'] ? $item['number'] : '',
						'text' => $item['text'] ? $item['text'] : '',
					);
				}
			}
			$params['blocks'] = $blocks;
				echo propertya_elementor_funfacts1($params);
		}

	protected function content_template() {
			
	}
}