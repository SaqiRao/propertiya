<?php
if(!empty($params) && is_array($params))
{ 
	$grid_type = $params['layout'];
	//order
	$order = 'DESC';
    $order_by = 'date';
	if ($params['order'] == 'asc')
	{
		$order = 'ASC';
	}
	if ($params['order'] == 'desc')
	{
		$order = 'DESC';
	}
	if ($params['order'] == 'rand')
	{
		 $order_by = 'rand';
	}
	//listing type
	if ($params['type'] == 'simple')
	{
		$listing_type = array(
			'key' => 'agency_is_featured',
			'value' => 0,
			'compare' => '=',
   		 );
	}
	else if ($params['type'] == 'featured')
	{
		$listing_type = array(
			'key' => 'agency_is_featured',
			'value' => 1,
			'compare' => '=',
   		 );
	}
	else if ($params['type'] == 'trusted')
	{
		$listing_type = array(
			'key' => 'agency_is_trusted',
			'value' => 1,
			'compare' => '=',
   		 );
	}
	else
	{
		$listing_type = '';
	} 
	
	$args	=	array
	(
		'post_type' => 'property-agency',
		'post_status' => 'publish',
		'posts_per_page' => $params['no_of_post'],
		'paged' => 1,
		'meta_query'    => array(
			array(
				'key'       => 'agency_status',
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
		$layout_type = new propertya_get_agencies();
		$function = "propertya_get_agencies_$grid_type";
		while ($results->have_posts())
		{
			$results->the_post();
			$agency_id = get_the_ID();
			$fetch_output .= $layout_type->$function($agency_id,'3');
		}
		wp_reset_postdata();
	}
}