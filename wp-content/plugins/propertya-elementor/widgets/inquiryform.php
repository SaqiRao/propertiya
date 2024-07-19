<?php
namespace ElementorRealEstate\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class inquiryForm extends Widget_Base {
	
	public function get_name() {
		return 'inquiry-form';
	}
	
	public function get_title() {
		return __( 'Inquiry Form', 'propertya-elementor' );
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
		$form = array();
		$forms = get_posts(array(
            'post_type' => 'wpcf7_contact_form',
            'numberposts' => -1
        ));
		if(!empty($forms) && is_array($forms) && count($forms) > 0)
		{
			 foreach ($forms as $selected)
			 {
				 $form[$selected->post_title] = $selected->post_name;
			 }
		}
		
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
			'main_text',
			[
				'label' => __( 'Main Title', 'propertya-elementor' ),
				'label_block' =>true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' =>true,
				'default'=> 'Create Custom Capture Forms',
			]
		);
		$this->add_control(
			'item_description',
			[
				'label' => __( 'Description', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 4,
				'placeholder' => __( 'Type your description here', 'propertya-elementor' ),
				'default' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor Lorem ipsum dolor sit amet sonu Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo.',
			]
		);

		$this->add_control(
			'item_description2',
			[
				'label' => __( 'Description', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 4,
				'placeholder' => __( 'Type your description here', 'propertya-elementor' ),
				'default' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor Lorem ipsum dolor sit amet sonu.',
			]
		);
		
		$this->add_control(
			'main_btn_title',
			[
				'label' => __( 'Main Button Title', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Type your title here', 'propertya-elementor' ),
				'label_block' => true,
				'default' => "Explore More"
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
				'label_block' => true,
				'default' => "Read More",
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
			'form_heading',
			[
				'label' => __( 'Form Heading', 'propertya-elementor' ),
				'label_block' =>true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'default'=> 'Inquiry Form',
			]
		);
		$this->add_control(
			'email',
			[
				'label' => __( 'Email', 'propertya-elementor' ),
				'label_block' =>true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' =>true,
				'default'=> 'your@email.com',
			]
		);
		$this->add_control(
			'form_type',
			[
				'label' => __( 'Select Contact Form', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'label_block' =>true,
				'default' => 'inquiry-form',
				'options' => $form
			]
		);
		$this->end_controls_section();
		
	}
		protected function render() {
		// get our input from the widget settings.
		$settings = $this->get_settings_for_display();
		$params = array();

		$params['subtitle'] = $settings['heading_text'] ? $settings['heading_text'] : '';
		$params['maintext'] = $settings['main_text'] ? $settings['main_text'] : '';
		$params['maintitle'] = $settings['item_description'] ? $settings['item_description'] : '';
		$params['maintitle2'] = $settings['item_description2'] ? $settings['item_description2'] : '';
		$params['form_heading'] = $settings['form_heading'] ? $settings['form_heading'] : '';
		$params['form_type'] = $settings['form_type'] ? $settings['form_type'] : '';
		$params['email'] = $settings['email'] ? $settings['email'] : '';
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
			echo propertya_elementor_inquiryform($params);
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