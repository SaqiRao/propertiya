<?php 
// Register post  type and taxonomy
add_action( 'init', 'propertya_framework_custom_types',1);
function propertya_framework_custom_types() {
	
	// Register Post Type Property
	$property_slug = 'property';
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
            'name' => esc_html__( 'Properties','propertya-framework'),
            'singular_name' => esc_html__( 'Property','propertya-framework' ),
            'add_new' => esc_html__('Add New Property','propertya-framework'),
            'add_new_item' => esc_html__('Add New','propertya-framework'),
            'edit_item' => esc_html__('Edit Property','propertya-framework'),
            'new_item' => esc_html__('New Property','propertya-framework'),
            'view_item' => esc_html__('View Property','propertya-framework'),
            'search_items' => esc_html__('Search Property','propertya-framework'),
            'not_found' =>  esc_html__('No Property found','propertya-framework'),
            'not_found_in_trash' => esc_html__('No Property found in Trash','propertya-framework'),
    );
    $args = array(
		'public' => true,
		'label'  =>  esc_html__( 'Properties', 'propertya-framework' ),
		'labels'      => $labels,
		'supports' => array('title','editor','thumbnail','revisions','author','page-attributes','excerpt'),
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
    register_post_type( 'property', $args );
	//Categories
	$final_slug = 'property_type';
	if ( class_exists( 'Redux' ) ) {
		$data = $cat_slug = '';
		$data	=	get_option('dwt_listing_options');
		if(!empty($data))
		{
			if(isset($data['dwt_listing_cat_slug']) && $data['dwt_listing_cat_slug'] !="")
			{
				$cat_slug = $data['dwt_listing_cat_slug'];
				if(!empty($cat_slug))
				{
					$final_slug = trim($cat_slug);
				}
			}
		}
	}
	//type
	$type = array(
			'name'              => __('Type','propertya-framework'),
			'add_new_item'      => __('Add New Type','propertya-framework'),
			'new_item_name'     => __('New Type','propertya-framework')
        );
	register_taxonomy('property_type',array('property'), array(
		'labels' => $type,
		'hierarchical' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => $final_slug ),
  ));
 // new listing_location_meta('category');
  //Tags
		$status = array(
			'name'              => esc_html__('Status','propertya-framework'),
			'add_new_item'      => esc_html__('Add New Status','propertya-framework'),
			'new_item_name'     => esc_html__('New Status','propertya-framework'),
		);
	
	register_taxonomy('property_status',array('property'), array(
	   'labels' => $status,
		'hierarchical' => true,
		'query_var' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'rewrite' => array( 'slug' => 'property_status'),
  ));
  //Features
	$features = array(
		'name'              => esc_html__('Features','propertya-framework'),
		'add_new_item'      => esc_html__('Add New Feature','propertya-framework'),
		'new_item_name'     => esc_html__('New Feature','propertya-framework')
	); 
	register_taxonomy('property_feature',array('property'), array(
	   'labels' => $features,
		'hierarchical' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'property_feature' ),
  ));
  //Labels
	$label = array(
			'name'              => esc_html__('Labels', 'propertya-framework'),
			'add_new_item'      => esc_html__('Add New Label','propertya-framework'),
			'new_item_name'     => esc_html__('New Label','propertya-framework')
	); 
	register_taxonomy('property_label',array('property'), array(
	   'labels' => $label,
		'hierarchical' => false,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'property_label' ),
  ));
  //Labels
	$currency  = array(
			'name'              => esc_html__('Currency', 'propertya-framework'),
			'add_new_item'      => esc_html__('Add New Currency','propertya-framework'),
			'new_item_name'     => esc_html__('New Currency','propertya-framework')
	); 
	register_taxonomy('property_currency',array('property'), array(
	   'labels' => $currency,
		'hierarchical' => false,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'property_currency' ),
  ));
  //Labels
	// $area_unit  = array(
	// 		'name'              => esc_html__('Area Unit', 'propertya-framework'),
	// 		'add_new_item'      => esc_html__('Add New Unit','propertya-framework'),
	// 		'new_item_name'     => esc_html__('New Area Unit','propertya-framework')
	// ); 
	// register_taxonomy('property_area_unit',array('property'), array(
	//    'labels' => $area_unit,
	// 	'hierarchical' => true,
	// 	'show_ui' => true,
	// 	'show_admin_column' => true,
	// 	'query_var' => true,
	// 	'rewrite' => array( 'slug' => 'property_area_unit' ),
 //  ));
  //Labels
	$currency  = array(
			'name'              => esc_html__('Currency', 'propertya-framework'),
			'add_new_item'      => esc_html__('Add New Currency','propertya-framework'),
			'new_item_name'     => esc_html__('New Currency','propertya-framework')
	); 
	register_taxonomy('property_currency',array('property'), array(
	   'labels' => $currency,
		'hierarchical' => false,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'property_currency' ),
  ));
  //Labels
	$locations  = array(
			'name' => esc_html__( 'Locations','propertya-framework'),
            'singular_name' => esc_html__( 'Locations','propertya-framework' ),
            'add_new' => esc_html__('Add New Location','propertya-framework'),
            'add_new_item' => esc_html__('Add New','propertya-framework'),
            'edit_item' => esc_html__('Edit Location','propertya-framework'),
            'new_item' => esc_html__('New Location','propertya-framework'),
            'view_item' => esc_html__('View Location','propertya-framework'),
            'search_items' => esc_html__('Search Location','propertya-framework'),
            'not_found' =>  esc_html__('No Location Found','propertya-framework'),
            'not_found_in_trash' => esc_html__('No Location found in Trash','propertya-framework'),
	); 
	register_taxonomy('property_location',array('property'), array(
	   'labels' => $locations,
		'hierarchical' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'location'),
  ));
  //Form Fields
    if(in_array('propertya-api/index.php', apply_filters('active_plugins', get_option('active_plugins'))))
    {    
       new listing_location_meta('property_type');   
    }
   new listing_location_meta('property_feature');
   new listing_location_meta('property_location');

}


// Register Custom Status
function propertya_framework_custom_post_status() {
	register_post_status( 'expired', array(
		'label'                     => _x( 'Expired', 'property','propertya-framework'),
		'public'                    => true,
		'exclude_from_search'       => true,
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'label_count'               => _n_noop( 'Expired <span class="count">(%s)</span>', 'Expired <span class="count">(%s)</span>', 'propertya-framework'),
	) );
}
add_action( 'init', 'propertya_framework_custom_post_status' );
// Adding custom post status to WordPress status dropdown
function propertya_framework_custom_post_status_dropdown() {
    global $post;
    $complete = '';
    $label = '';    
    if($post->post_type == 'property'){
    	if($post->post_status == 'expired'){
            $complete = ' selected="selected"';
            $label = '<span id=\"post-status-display\"> '.esc_html__('Expired','propertya-framework').'</span>';
        }
	    ?>
	    <script>
	    jQuery(document).ready(function($){
	        $("select#post_status").append("<option value=\"expired\" <?php selected('expired', $post->post_status); ?>><?php echo esc_html__('Expired','propertya-framework'); ?></option>");
	    	$(".misc-pub-section label").append("<?php echo $label ?>");
	    });
	    </script>
	    <?php
	}
}
add_action( 'post_submitbox_misc_actions', 'propertya_framework_custom_post_status_dropdown');

// Adding custom post status to post type index
function propertya_framework_custom_post_archive_state( $states ) {
     global $post;
	 // no posts
	 if (!$post) return;
     $arg = get_query_var( 'post_status' );
    if(!empty($arg)) {
     if($arg != 'expired'){
          if($post->post_status == 'expired' && 'property' === $post->post_type){
               return array('Expired');
          }
     }
    }
    return $states;
}
add_filter( 'display_post_states', 'propertya_framework_custom_post_archive_state' );

// Adding custom post status to quick edit screen
function propertya_framework_custom_into_quick_edit() {
    global $post;
    // no posts
    if (!$post) return;
    if ( 'property' === $post->post_type ) { 
      echo "<script>
      jQuery(document).ready( function() {
        jQuery( 'select[name=\"_status\"]' ).append( '<option value=\"expired\">".esc_html__('Expired','propertya-framework')."</option>' );
      });
      </script>";
    }
}
add_action('admin_footer-edit.php','propertya_framework_custom_into_quick_edit');