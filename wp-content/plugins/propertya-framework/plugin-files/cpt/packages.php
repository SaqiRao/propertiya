<?php 
// Register post  type and taxonomy
add_action( 'init', 'propertya_framework_custom_packages',1);
function propertya_framework_custom_packages() {
	// Register Post Type Agents
	$property_slug = 'property-packages';
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
            'name' => esc_html__( 'Packages','propertya-framework'),
            'singular_name' => esc_html__( 'Packages','propertya-framework' ),
            'add_new' => esc_html__('Add New Package','propertya-framework'),
            'add_new_item' => esc_html__('Add New','propertya-framework'),
            'edit_item' => esc_html__('Edit Package','propertya-framework'),
            'new_item' => esc_html__('New Package','propertya-framework'),
            'view_item' => esc_html__('View Package','propertya-framework'),
            'search_items' => esc_html__('Search Package','propertya-framework'),
            'not_found' =>  esc_html__('No Package found','propertya-framework'),
            'not_found_in_trash' => esc_html__('No Package found in Trash','propertya-framework'),
    );
    $args = array(
		'public' => true,
		'label'  =>  esc_html__( 'Packages', 'propertya-framework' ),
		'labels'      => $labels,
		'supports' => array('title','editors','thumbnail'),
		'show_ui' => true,
        'publicly_queryable' => true,
		'query_var' => true,
        'has_archive' => true,
		'capability_type' => 'post',
		'hierarchical' => true,
		'map_meta_cap'    => true,
		'can_export' => true,
		'menu_icon' => 'dashicons-location',
		'rewrite' => array('with_front' => false, 'slug' => $property_slug)
    );
    register_post_type( 'property-packages', $args );
}