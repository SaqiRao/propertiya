<?php 
// Register post  type and taxonomy
add_action( 'init', 'propertya_framework_custom_types_agents',1);
function propertya_framework_custom_types_agents() {
	// Register Post Type Agents
	$property_slug = 'agent';
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
            'name' => esc_html__( 'Agents','propertya-framework'),
            'singular_name' => esc_html__( 'Agents','propertya-framework' ),
            'add_new' => esc_html__('Add New Agent','propertya-framework'),
            'add_new_item' => esc_html__('Add New','propertya-framework'),
            'edit_item' => esc_html__('Edit Agent','propertya-framework'),
            'new_item' => esc_html__('New Agent','propertya-framework'),
            'view_item' => esc_html__('View Agent','propertya-framework'),
            'search_items' => esc_html__('Search Agent','propertya-framework'),
            'not_found' =>  esc_html__('No Agent found','propertya-framework'),
            'not_found_in_trash' => esc_html__('No Agent found in Trash','propertya-framework'),
    );
    $args = array(
		'public' => true,
		'label'  =>  esc_html__( 'Agents', 'propertya-framework' ),
		'labels'      => $labels,
		'supports' => array('title','editor','thumbnail'),
		'show_ui' => true,
        'publicly_queryable' => true,
		'query_var' => true,
        'has_archive' => true,
		'capability_type' => 'post',
		'hierarchical' => true,
		'map_meta_cap'    => true,
        'capabilities' => array(
            'create_posts' => false
        ),
		'can_export' => true,
		'menu_icon' => 'dashicons-location',
		'rewrite' => array('with_front' => false, 'slug' => $property_slug)
    );
    register_post_type( 'property-agents', $args );
	
	//Labels
	$types = array(
			'name'              => esc_html__('Types', 'propertya-framework'),
			'add_new_item'      => esc_html__('Add New Agent Type','propertya-framework'),
			'new_item_name'     => esc_html__('New Agent Type','propertya-framework')
	); 
	register_taxonomy('agent_types',array('property-agents'), array(
	   'labels' => $types,
		'hierarchical' => false,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'agent_types' ),
  ));
  //Agent Locations
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
	register_taxonomy('agent_location',array('property-agents'), array(
	   'labels' => $locations,
		'hierarchical' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'agent-location'),
  ));
}