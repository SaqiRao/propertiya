<?php
if(!empty($params) && is_array($params))
{ 
	$grid_type = $params['layout'];
	//order
	$order = 'DESC';
    $order_by = 'date';
	if ($params['orderby'] == 'asc')
	{
		$order = 'ASC';
	}
	if ($params['orderby'] == 'desc')
	{
		$order = 'DESC';
	}
	if ($params['orderby'] == 'rand')
	{
		 $order_by = 'rand';
	}
	//listing type
	if ($params['listing_type'] == 'simple')
	{
		$listing_type = array(
			'key' => 'prop_is_feature_listing',
			'value' => 0,
			'compare' => '=',
   		 );
	}
	else if ($params['listing_type'] == 'featured')
	{
		$listing_type = array(
			'key' => 'prop_is_feature_listing',
			'value' => 1,
			'compare' => '=',
   		 );
	}
	else
	{
		$listing_type = '';
	} 
	
	//categories
	$cat_ids = '';
	$categories = array();
	if(!empty($params['categories']) && is_array($params['categories']) && count($params['categories']) > 0)
	{
		foreach ($params['categories'] as $cats)
		{
			if ($cats == 'all')
			{
				break;
			}
			else
			{
				$categories[] = $cats;
			}
		}
	}
	$cat_ids = implode(',', $categories);
	$category_type = '';
	if(!empty($categories) && is_array($categories))
	{
		$category_type =  array(
				'taxonomy' => 'property_type',
				'field' => 'term_id',
				'terms' => $categories,
		);
	}
	//by type
	$offer_type = '';
    if (isset($params['listing_status']) && $params['listing_status'] != "" && $params['listing_status'] != 'all') {
		$offer_type = array(
			array(
				'taxonomy' => 'property_status',
				'field' => 'term_id',
				'terms' => $params['listing_status'],
			),
		);
    }
	$custom_location = '';


if (isset($params['location_id']) && $params['location_id'] !== "") {
    $custom_location = array();    
    if (is_numeric($params['location_id'])) {
        $custom_location[] = array(
            'taxonomy' => 'property_location',
            'field' => 'term_id',
            'terms' => (int)$params['location_id'], // Convert to integer if it's numeric
        );
    } else {
        $custom_location[] = array(
            'taxonomy' => 'property_location',
            'field' => 'slug',
            'terms' => $params['location_id'],
        );
    }
}



		
	$args	=	array
	(
		'post_type' => 'property',
		'post_status' => 'publish',
		'posts_per_page' => $params['no_of_post'],
		'paged' => 1,
        'fields' => 'ids',
		'tax_query' => array(
        		$category_type,
				$offer_type,
				$custom_location
    	),
		'meta_query'    => array(
			array(
				'key'       => 'prop_status',
				'value'     => '1',
				'compare'   => '=',
			),
			$listing_type
		),
		'order'=> $order,
		'orderby' => $order_by,
	);
	$fetch_output = '';
	$results = new WP_Query( $args );
	if ($results->have_posts())
	{
		$layout_type = new propertya_getlistings();
		$function = "propertya_listings_$grid_type";
		while ($results->have_posts())
		{	
			$results->the_post();
			$property_id = get_the_ID();
			$fetch_output .= $layout_type->$function($property_id,$params['listing_column']);
		}
		wp_reset_postdata();
	}
}