<?php
namespace ElementorRealEstate;
/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.2.0
 */
class Plugin {
	/**
	 * Instance
	 *
	 * @since 1.2.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Include Widgets files
	 *
	 */
	private function include_widgets_files() {
		require_once( __DIR__ . '/widgets/hero-1.php' );
		require_once( __DIR__ . '/widgets/hero-2.php' );
		require_once( __DIR__ . '/widgets/hero-3.php' );
		require_once( __DIR__ . '/widgets/hero-4.php' );
		require_once( __DIR__ . '/widgets/hero-5.php' );
		require_once( __DIR__ . '/widgets/hero-6.php' );
		require_once( __DIR__ . '/widgets/hero-7.php' );
		require_once( __DIR__ . '/widgets/hero-8.php' );
		require_once( __DIR__ . '/widgets/blocks.php' );
		require_once( __DIR__ . '/widgets/all-listings.php' );
        require_once( __DIR__ . '/widgets/modern-search.php' );
		require_once( __DIR__ . '/widgets/all-agencies.php' );
		require_once( __DIR__ . '/widgets/all-agents.php' );
		require_once( __DIR__ . '/widgets/all-types.php' );
		require_once( __DIR__ . '/widgets/all-types-2.php' );
		require_once( __DIR__ . '/widgets/all-types-3.php' );
		require_once( __DIR__ . '/widgets/blogs.php' );
		require_once( __DIR__ . '/widgets/testimonials.php' );
		require_once( __DIR__ . '/widgets/testimonials2.php' );
		require_once( __DIR__ . '/widgets/testimonials3.php' );
		require_once( __DIR__ . '/widgets/partners.php' );
		require_once( __DIR__ . '/widgets/funfacts-1.php' );
		require_once( __DIR__ . '/widgets/funfacts-2.php' );
		require_once( __DIR__ . '/widgets/how-it-works.php' );
		require_once( __DIR__ . '/widgets/our-services.php' );
		require_once( __DIR__ . '/widgets/about-us.php' );
		require_once( __DIR__ . '/widgets/locations.php' );
		require_once( __DIR__ . '/widgets/locations2.php' );
		require_once( __DIR__ . '/widgets/our-app.php' );
		require_once( __DIR__ . '/widgets/call-action-1.php' );
		require_once( __DIR__ . '/widgets/call-action-2.php' );
		require_once( __DIR__ . '/widgets/call-action-3.php' );
        require_once( __DIR__ . '/widgets/call-action-4.php' );
		require_once( __DIR__ . '/widgets/search-builder.php' );
		require_once( __DIR__ . '/widgets/search-builder-2.php' );
        require_once( __DIR__ . '/widgets/search-builder-home.php' );
		require_once( __DIR__ . '/widgets/contactus.php' );
		require_once( __DIR__ . '/widgets/inquiryform.php' );
        require_once( __DIR__ . '/widgets/packages.php' );
        require_once( __DIR__ . '/widgets/packages-classic.php' );
	}
	
	//Ad Shortcode Category
	public function add_elementor_widget_categories($category_manager)
	{
            $category_manager->add_category(
				'sonutheme',
				[
					'title' => __( 'Propertya Widgets', 'propertya-elementor' ),
					'icon' => 'fa fa-home',
				]
            );
    }
	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function register_widgets() {
		// Its is now safe to include Widgets files
		$this->include_widgets_files();

		// Register Widgets
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Hero_One());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Hero_Two());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Hero_Three());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Hero_Four());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Hero_Five());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Hero_Six());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Hero_Seven());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Hero_Eight());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Block());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Modern_Search());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\All_Listings());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\All_Agencies());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\All_Agents());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Types());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\AllTypes());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\AllTypes3());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Blogs());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Testimonials());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Testimonials2());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Testimonials3());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Partners());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\FunFacts1());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\FunFacts2());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\HowItWorks());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\OurServices());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\About_Us());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Locations());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Locations2());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\OurApps());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\CallAction_One());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\CallAction_Two());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\CallAction_Three());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\CallAction_Four());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\SearchBuilder());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\SearchBuilder_Two());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\SearchBuilder_Ajax());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\HowItWorks());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\ContactUs());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\inquiryForm());
        if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))))
        {
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Packages());
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\PackagesClassic());
        }
	}

	public function __construct() {
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
		add_action( 'elementor/elements/categories_registered',  [ $this, 'add_elementor_widget_categories' ]  );
	}
}

Plugin::instance();