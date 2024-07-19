<?php
	/*
 	   Theme Settings.
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Leisure Sols, use a find and replace
	 * to change ''rane to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'propertya', trailingslashit( get_template_directory() ) . 'languages/' );
	// Content width
	if ( ! isset( $content_width ) ) {
		$content_width = 730;
	}
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	//add_theme_support( 'custom-header' );
	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

    add_theme_support( 'woocommerce' );
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

	// Theme editor style
	add_editor_style('editor.css');
	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-SB_TAMEER_IMAGES-post-thumbnails/
	 */
	paginate_comments_links();
	the_post_thumbnail();
	add_theme_support( 'post-thumbnails', array('post', 'property-agency', 'property-agents' , 'property-buyers') ); 
	
	//Thumbnails
	add_image_size( 'propertya-blog-thumb', 350, 245, true );
	add_image_size( 'propertya-small-thumb', 100,66, true );
	add_image_size( 'propertya-user-thumb', 120,120, true );
	add_image_size( 'propertya-primary-banner', 730,450, true );
	add_image_size( 'propertya-background', 375,300, true );
	add_image_size( 'propertya-extra-small', 190, 183, true );
    add_image_size( 'propertya-similar', 275, 234, true );
	
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'main_theme_menu'    => esc_html__( 'Propertya Menu', 'propertya' ),
	) );
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', ) );
	add_theme_support( 'customize-selective-refresh-widgets' );
	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	// Set up the WordPress core custom background feature.
    the_tags();
	add_theme_support( 'custom-background', apply_filters( 'propertya_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
	// Register side bar for widgets
	add_action( 'widgets_init', 'propertya_widgets_init' );
	if ( ! function_exists( 'propertya_widgets_init' ) ) {
		function propertya_widgets_init() {
			//Blog Sidebar		
			register_sidebar( array(
				'name' => esc_html__('Blog Sidebar', 'propertya'),
				'id' => 'sonu_blog_sidebar_realestate',
				'before_widget' => '<div class="widget"><div id="%1$s">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="widget-heading"><h2>',
				'after_title' => '</h2><div class="heading-dots clearfix">
										<span class="h-dot line-dot"></span>
										<span class="h-dot"></span>
										<span class="h-dot"></span>
										<span class="h-dot"></span>
                					</div></div>'
			) );
			//Agency Sidebar		
			register_sidebar(array(
				'name' => esc_html__('Agency Search Sidebar', 'propertya'),
				'id' => 'prop_ag_seach_bar',
				'before_widget' => '<div class="sidebar-widget"><div class="widget"><div id="%1$s">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="widget-heading"><h2>',
				'after_title' => '</h2></div></div>'
       	   ));
		
		   //Agents Sidebar		
			register_sidebar(array(
				'name' => esc_html__('Agents Search Sidebar', 'propertya'),
				'id' => 'prop_agents_seach_bar',
				'before_widget' => '<div class="sidebar-widget"><div class="widget"><div id="%1$s">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="widget-heading"><h2>',
				'after_title' => '</h2></div></div>'
       	   ));	
            
            //Property Sidebar		
            register_sidebar(array(
                'name' => esc_html__('Property Search Sidebar', 'propertya'),
                'id' => 'prop_property_seach_bar',
                'before_widget' => '<div class="sidebar-widget"><div class="widget"><div id="%1$s">',
                'after_widget' => '</div></div>',
                'before_title' => '<div class="widget-heading"><h2>',
                'after_title' => '</h2></div></div>'
           ));
            
            //Property Sidebar		
            register_sidebar(array(
                'name' => esc_html__('Home Ajax Search Sidebar', 'propertya'),
                'id' => 'prop_home_ajaxseach_bar',
                'before_widget' => '<div class="sidebar-widget"><div class="widget"><div id="%1$s">',
                'after_widget' => '</div></div>',
                'before_title' => '<div class="widget-heading"><h2>',
                'after_title' => '</h2></div></div>'
           ));
			
		}
	}