<?php
namespace ElementorRealEstate\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class ContactUs extends Widget_Base {
	
	public function get_name() {
		return 'contact-us';
	}
	
	public function get_title() {
		return __( 'Contact Us', 'propertya-elementor' );
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
				'default'=> 'Get In Touch',
			]
		);
		$this->add_control(
			'item_description',
			[
				'label' => __( 'Description', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 4,
				'placeholder' => __( 'Type your description here', 'propertya-elementor' ),
			]
		);
		$this->add_control(
			'form_heading',
			[
				'label' => __( 'Form Heading', 'propertya-elementor' ),
				'label_block' =>true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'default'=> 'Reach Us Quickly',
			]
		);
		$this->add_control(
			'form_type',
			[
				'label' => __( 'Select Contact Form', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'label_block' =>true,
				'options' => $form
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
			'additional_info',
			[
				'label' => esc_html__( 'Additional Info', 'propertya-elementor' ),
			]
		);
		
		$this->add_control(
			'headoffice',
			[
				'label' => __( 'Main Title', 'propertya-elementor' ),
				'label_block' =>true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' =>true,
				'default'=> 'Get In Touch',
			]
		);
		
		$this->add_control(
			'location',
			[
				'label' => __( 'Location', 'propertya-elementor' ),
				'label_block' =>true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' =>true,
				'default'=> 'Your Location Here.',
			]
		);
		
		$this->add_control(
			'contact',
			[
				'label' => __( 'Contact No', 'propertya-elementor' ),
				'label_block' =>true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' =>true,
				'default'=> '+92 2 1234 4567',
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
		

		$this->end_controls_section();
		
	}
		protected function render() {
		// get our input from the widget settings.
		$settings = $this->get_settings_for_display();
		$params = array();

		$params['subtitle'] = $settings['heading_text'] ? $settings['heading_text'] : '';
		$params['maintext'] = $settings['main_text'] ? $settings['main_text'] : '';
		$params['maintitle'] = $settings['item_description'] ? $settings['item_description'] : '';
		$params['form_heading'] = $settings['form_heading'] ? $settings['form_heading'] : '';
		$params['form_type'] = $settings['form_type'] ? $settings['form_type'] : '';
		$params['headoffice'] = $settings['headoffice'] ? $settings['headoffice'] : '';
		$params['contact'] = $settings['contact'] ? $settings['contact'] : '';
		$params['location'] = $settings['location'] ? $settings['location'] : '';
		$params['email'] = $settings['email'] ? $settings['email'] : '';
			echo propertya_elementor_contactus($params);
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