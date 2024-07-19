<?php
namespace ElementorRealEstate\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Testimonials2 extends Widget_Base {
	
	public function get_name() {
		return 'testimonial-two';
	}
	
	public function get_title() {
		return __( 'Testimonials Modern', 'propertya-elementor' );
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
		
		$this->end_controls_section();
		
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
				'default' => [
					[
						'image' => 'Title Here',
						'list_content' => 'They Provide almost every type of logistic. Door to door delivery was awesome. It was awesome to work with them getting every single logistic facility.',
						'testi_name' => 'Name Here',
						'testi_type' => 'User Type Here'
					],
					[
						'image' => 'Title Here',
						'list_content' => 'They Provide almost every type of logistic. Door to door delivery was awesome. It was awesome to work with them getting every single logistic facility.',
						'testi_name' => 'Name Here',
						'testi_type' => 'User Type Here'
					],
					[
						'image' => 'Title Here',
						'list_content' => 'They Provide almost every type of logistic. Door to door delivery was awesome. It was awesome to work with them getting every single logistic facility.',
						'testi_name' => 'Name Here',
						'testi_type' => 'User Type Here'
					],
				],
				'title_field' => '{{{ testi_name }}}',
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'clients_query',
			[
				'label' => esc_html__( 'Our Clients/Partners', 'propertya-elementor' ),
			]
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'cleint_image',
			[
				'label' => __( 'Choose Image', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		
		$this->add_control(
			'cleint_list',
			[
				'label' => __( 'Ad Partners', 'propertya-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'default' => [
					[
						'cleint_image' => 'url here',
					],
					[
						'cleint_image' => 'url here',
					],
					[
						'cleint_image' => 'url here',
					],
					[
						'cleint_image' => 'url here',
					],
					[
						'cleint_image' => 'url here',
					],
				],
				'fields' => $repeater->get_controls(),
			]
		);
		$this->end_controls_section();
		
	}
		protected function render() {
		// get our input from the widget settings.
		$settings = $this->get_settings_for_display();
		$cleints_blocks = $blocks = $params = array();
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
		//cleints/partners
		if(!empty($settings['cleint_list']))
		{
			foreach (  $settings['cleint_list'] as $item ) {
				$cleints_blocks[] = array(
					'image' => $item['cleint_image']['url'] ? $item['cleint_image']['url'] : '',
				);
			}
		}
		
		$params['subtitle'] = $settings['heading_text'] ? $settings['heading_text'] : '';
		$params['maintitle'] = $settings['item_description'] ? $settings['item_description'] : '';
		$params['heading_style'] = $settings['heading_style'] ? $settings['heading_style'] : 'center';
		$params['blocks'] = $blocks;
		$params['cleints_blocks'] = $cleints_blocks;
			echo propertya_elementor_testimonials_2($params);
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			?>
            <script>

jQuery('.social-ads').owlCarousel({
    loop:true,
	autoplay:true,
	dots:false,
	autoplayTimeout:3000,
	smartSpeed:1200,
    nav:false,
			animateOut: 'fadeOut',
			animateIn: 'fadeIn',
    responsive:{
        0:{
            items:1,
        },
        500:{
            items:3,
        },
		800:{
            items:4,
        },
        1200:{
            items:5,
        }
    }
});

			</script>
            <?php
			}
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