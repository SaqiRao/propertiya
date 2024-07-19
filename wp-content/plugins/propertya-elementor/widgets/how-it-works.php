<?php
namespace ElementorRealEstate\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class HowItWorks extends Widget_Base {
	
	public function get_name() {
		return 'how-it-works';
	}
	
	public function get_title() {
		return __( 'How It Works 1', 'propertya-elementor' );
	}
	
	public function get_icon() {
		return 'eicon-number-field';
	}

	public function get_categories() {
		return [ 'sonutheme' ];
	}
	
	public function get_script_depends() {
		return [ '' ];
	}
	
	protected function register_controls() {
		
		$this->start_controls_section(
			'section_heading',
			[
				'label' => esc_html__( 'Section Heading', 'propertya-elementor' ),
			]
		);
		$this->add_control(
			'heading_text',
			[
				'label' => __( 'Sub Title', 'propertya-elementor' ),
				'label_block' =>true,
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);
		$this->add_control(
			'item_description',
			[
				'label' => __( 'Main Title', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 4,
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
				
		$this->add_control(
			'list',
			[
				'label' => __( 'Block Grids', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'icon' => 'fas fa-star',
						'list_title' => 'Title Gose Here',
						'list_content' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor Aenean massa.',
					],
					[
						'icon' => 'fas fa-star',
						'list_title' => 'Title Gose Here',
						'list_content' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor Aenean massa.',
					],
					[
						'icon' => 'fas fa-star',
						'list_title' => 'Title Gose Here',
						'list_content' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor Aenean massa.',
					],
				],
				'title_field' => '{{{ list_title }}}',
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_counter',
			[
				'label' => esc_html__( 'Funfacts Counter', 'propertya-elementor' ),
			]
		);
		
		$this->add_control(
			'show_fun',
			[
				'label' => __( 'Do you want to show funfacts?', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'yes',
				'label_block' =>true,
				'options' => [
					'yes'  => __( 'Yes', 'propertya-elementor' ),
					'no' => __( 'No', 'propertya-elementor' ),
				],
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
				'default' => '450',
			]
		);
		$repeater->add_control(
			'text', [
				'label' => __( 'Text', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default' => 'Total Listings',
			]
		);
		
		$this->add_control(
			'lists',
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
		$facts = $blocks = $params = array();
		if(!empty($settings['list']))
		{
			foreach (  $settings['list'] as $item ) {
				$blocks[] = array(
					'title' => $item['list_title'],
					'content' => $item['list_content'],
					'icon' => $item['icon'],
				);
			}
		}
		if(!empty($settings['lists']))
		{
			foreach (  $settings['lists'] as $items ) {
				$facts[] = array(
						'icon_img' => $items['funicon']['url'] ? $items['funicon']['url'] : '',
						'number' => $items['number'] ? $items['number'] : '',
						'text' => $items['text'] ? $items['text'] : '',
				);
			}
		}
		$params['subtitle'] = $settings['heading_text'] ? $settings['heading_text'] : '';
		$params['maintitle'] = $settings['item_description'] ? $settings['item_description'] : '';
		$params['heading_style'] = $settings['heading_style'] ? $settings['heading_style'] : 'center';
		$params['blocks'] = $blocks;
		$params['show_fun'] = $settings['show_fun'] ? $settings['show_fun'] : 'yes';
		$params['funfacts'] = $facts;
			echo propertya_elementor_how_it_works_one($params);
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