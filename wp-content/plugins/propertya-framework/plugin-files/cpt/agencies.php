<?php 
// Register post  type and taxonomy
add_action( 'init', 'propertya_framework_custom_types_agencies',1);
function propertya_framework_custom_types_agencies() {
	// Register Post Type Agency
	$property_slug = 'agencies';
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
            'name' => esc_html__( 'Agencies','propertya-framework'),
            'singular_name' => esc_html__( 'Agencies','propertya-framework' ),
            'add_new' => esc_html__('Add New Agency','propertya-framework'),
            'add_new_item' => esc_html__('Add New','propertya-framework'),
            'edit_item' => esc_html__('Edit Agency','propertya-framework'),
            'new_item' => esc_html__('New Agency','propertya-framework'),
            'view_item' => esc_html__('View Agency','propertya-framework'),
            'search_items' => esc_html__('Search Agency','propertya-framework'),
            'not_found' =>  esc_html__('No Agency found','propertya-framework'),
            'not_found_in_trash' => esc_html__('No Agency found in Trash','propertya-framework'),
    );
    $args = array(
		'public' => true,
		'label'  =>  esc_html__( 'Agency', 'propertya-framework' ),
		'labels'      => $labels,
		'supports' => array('title','editor','thumbnail'),
		'show_ui' => true,
        'publicly_queryable' => true,
		'query_var' => true,
        'has_archive' => true,
		'capability_type' => 'post',
		'hierarchical' => true,
        'capabilities' => array(
            'create_posts' => false
        ),
		'map_meta_cap'    => true,
		'can_export' => true,
		'menu_icon' => 'dashicons-location',
		'rewrite' => array('with_front' => false, 'slug' => $property_slug)
    );
    register_post_type( 'property-agency', $args );
	//Agency Locations
	$locations  = array(
			'name' => esc_html__( 'Locations','propertya-framework'),
            'singular_name' => esc_html__( 'Locations','propertya-framework' ),
            'add_new' => esc_html__('Add New Location','propertya-framework'),
            'add_new_item' => esc_html__('Add New Location','propertya-framework'),
            'edit_item' => esc_html__('Edit Location','propertya-framework'),
            'new_item' => esc_html__('New Location','propertya-framework'),
            'view_item' => esc_html__('View Location','propertya-framework'),
            'search_items' => esc_html__('Search Location','propertya-framework'),
            'not_found' =>  esc_html__('No Location Found','propertya-framework'),
            'not_found_in_trash' => esc_html__('No Location found in Trash','propertya-framework'),
	); 
	register_taxonomy('agency_location',array('property-agency'), array(
	   'labels' => $locations,
		'hierarchical' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'agency-location'),
  ));
}