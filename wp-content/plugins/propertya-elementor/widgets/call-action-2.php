<?php
namespace ElementorRealEstate\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class CallAction_Two extends Widget_Base {
	
	public function get_name() {
		return 'call-action-two';
	}
	
	public function get_title() {
		return __( 'Call To Action 2', 'propertya-elementor' );
	}
	
	public function get_icon() {
		return 'eicon-image';
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
		
		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Content', 'propertya-elementor' ),
			]
		);
		$this->add_control(
			'tagline',
			[
				'label' => __( 'Tagline', 'propertya-elementor' ),
				'label_block' =>true,
				'default' => __( 'Subtitle Here', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);
		$this->add_control(
			'heading_text',
			[
				'label' => __( 'Main Heading', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'title' => __( 'To highligt heading use color tag eg: {color} Awesome </color>', 'propertya-elementor' ),
				'rows' => 3,
				'default' => __( 'Content goes here..', 'propertya-elementor' ),
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
				'default' => __( 'Content goes here..', 'propertya-elementor' ),
			]
		);
		
		$this->add_control(
			'main_btn_title',
			[
				'label' => __( 'Main Button Title', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Type your title here', 'propertya-elementor' ),
				'label_block' => true
			]
		);
		
		$this->add_control(
			'main_btn_link',
			[
				'label' => __( 'Main Button Link', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'propertya-elementor' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);
		
		$this->add_control(
			'second_btn_title',
			[
				'label' => __( 'Secondary Button Title', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Type your title here', 'propertya-elementor' ),
				'label_block' => true
			]
		);
		
		$this->add_control(
			'second_btn_link',
			[
				'label' => __( 'Secondary Button Link', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'propertya-elementor' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);
		$this->add_control(
			'image',
			[
				'label' => __( 'Image', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'description' => __( 'Recommended image size 250x300', 'propertya-elementor' ),
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_quersy',
			[
				'label' => esc_html__( 'Additional Information', 'propertya-elementor' ),
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
				'default' => __( 'Title Goes Here..' , 'propertya-elementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'list_content', [
				'label' => __( 'Content', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'Content gose here..' , 'propertya-elementor' ),
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
				'title_field' => '{{{ list_title }}}',
			]
		);
		$this->end_controls_section();	
	}
	
		protected function render() {
		// get our input from the widget settings.
		$blocks = array();
		$settings = $this->get_settings_for_display();
		$params['tagline'] = $settings['tagline'];
		$params['heading_text'] = $settings['heading_text'];
		$params['desc'] = $settings['item_description'];
		//main button
		$params['main_btn']['title'] = $settings['main_btn_title'];
		$params['main_btn']['link'] = $settings['main_btn_link']['url'];
		$params['main_btn']['is_external'] = $settings['main_btn_link']['is_external'];
		$params['main_btn']['nofollow'] = $settings['main_btn_link']['nofollow'];
		//second button
		$params['sec_btn']['title'] = $settings['second_btn_title'];
		$params['sec_btn']['link'] = $settings['second_btn_link']['url'];
		$params['sec_btn']['is_external'] = $settings['second_btn_link']['is_external'];
		$params['sec_btn']['nofollow'] = $settings['second_btn_link']['nofollow'];
		$params['image'] = $settings['image']['url'] ? $settings['image']['url'] : '';
		//additional information
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
		$params['blocks'] = $blocks;
			echo propertya_elementor_call_to_action_two($params);
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