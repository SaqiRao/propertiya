<?php 
// Register post  type and taxonomy
add_action( 'init', 'propertya_framework_custom_types_invoice',1);
function propertya_framework_custom_types_invoice() {
	// Register Post Type Agency
	$property_slug = 'listing-invoices';
	if ( class_exists( 'Redux' ) ) {
		$data = $property_slug_val = '';
		$data	=	get_option('dwt_listing_options');
		if(!empty($data))
		{
			if(isset($data['dwt_listing_listing_slug']) && $data['dwt_listing_listing_slug'] !="")
			{
				$property_slug_val = $data['dwt_listing_listing_slug'];
				if(!empty($property_slug_val))
				{
					$property_slug = trim($property_slug_val);
				}
			}
		}
	}
	$labels = array(
            'name' => esc_html__( 'Invoices','propertya-framework'),
            'singular_name' => esc_html__( 'Invoices','propertya-framework' ),
           
            'new_item' => esc_html__('New Invoices','propertya-framework'),
            'view_item' => esc_html__('View Invoices','propertya-framework'),
            'search_items' => esc_html__('Search Invoices','propertya-framework'),
            'not_found' =>  esc_html__('No Invoices found','propertya-framework'),
            'not_found_in_trash' => esc_html__('No Invoices found in Trash','propertya-framework'),
    );
    $args = array(
		'public' => true,
		'label'  =>  esc_html__( 'Invoices', 'propertya-framework' ),
		'labels'      => $labels,
		'show_ui' => true,
        'publicly_queryable' => true,
		'query_var' => true,
        'has_archive' => true,
		'capability_type' => 'post',
		'hierarchical' => true,
		'can_export' => true,
		'menu_icon' => 'dashicons-info',
		'capabilities' => array(
    			'create_posts' => false,
		),
		'map_meta_cap' => true,
		'supports'           => array('author'),
		'rewrite' => array('with_front' => false, 'slug' => $property_slug)
    );
    register_post_type( 'listing-invoices', $args);
}