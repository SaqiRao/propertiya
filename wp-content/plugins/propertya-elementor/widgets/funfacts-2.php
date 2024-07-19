<?php
namespace ElementorRealEstate\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class FunFacts2 extends Widget_Base {
	
	public function get_name() {
		return 'fun-two';
	}
	
	public function get_title() {
		return __( 'Minimal Funfacts', 'propertya-elementor' );
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
			'section_counter',
			[
				'label' => esc_html__( 'Funfacts Counter', 'propertya-elementor' ),
			]
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'funicon',
			[
				'label' => __( 'Choose Icon', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
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
				'default' => [
					[
						'funicon' => 'Title Here',
						'number' => '1700',
						'text' => 'Total Listings',
					],
					[
						'funicon' => 'Title Here',
						'number' => '1700',
						'text' => 'Total Listings',
					],
					[
						'funicon' => 'Title Here',
						'number' => '1700',
						'text' => 'Total Listings',
					],
					[
						'funicon' => 'Title Here',
						'number' => '1700',
						'text' => 'Total Listings',
					],
				],
				'title_field' => '{{{ text }}}',
			]
		);
		
		$this->end_controls_section();
			
	}
	
		protected function render() {
			// get our input from the widget settings.
			$settings = $this->get_settings_for_display();
			$blocks = array();
			if(!empty($settings['list']))
			{
				foreach (  $settings['list'] as $item ) {
					$blocks[] = array(
					    'icon_img' => $item['funicon']['url'] ? $item['funicon']['url'] : '',
						'number' => $item['number'] ? $item['number'] : '',
						'text' => $item['text'] ? $item['text'] : '',
					);
				}
			}
			$params['funfacts'] = $blocks;
			echo propertya_elementor_funfacts2($params);
		}

	protected function content_template() {
			
	}
}