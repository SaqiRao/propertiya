<?php

 global $propertya_options;
	$newdistacne = $lat_lng_meta_query = $nearby_idz = $calculated_distance = array();
	$property_id	=	get_the_ID();
	$cacl_distance = $second_long = $second_lat = $selected_long = $selected_latt = '';
	if(get_post_meta($property_id, 'prop_latt', true ) !="" &&  get_post_meta($property_id, 'prop_long', true )!="")
	{
		$distance_unit = array(
			'miles' => array('dis_name'=>esc_html__('Miles', 'propertya' ), 'dis_abbt' =>esc_html__('mi', 'propertya' ) ),
			'kilometers' => array('dis_name'=>esc_html__('Kilometers', 'propertya' ), 'dis_abbt' =>esc_html__('km', 'propertya' ) ),
		 );

		$selected_distance_unit = '';
	 if (isset($propertya_options['propertya_listing_nearby_dest_in']) && $propertya_options['propertya_listing_nearby_dest_in'] != '') {
        $selected_distance_unit = $propertya_options['propertya_listing_nearby_dest_in'];
       
    }

		$nearby_distance = 100;
	 if (isset($propertya_options['propertya_listing_nearby_dest']) && $propertya_options['propertya_listing_nearby_dest'] != '') {
        $nearby_distance = $propertya_options['propertya_listing_nearby_dest'];
    }
    $nearby_post_per_page = 10;
   if (isset($propertya_options['propertya_listing_nearby_no_listings']) && $propertya_options['propertya_listing_nearby_no_listings'] != '') {
        $nearby_post_per_page = $propertya_options['propertya_listing_nearby_no_listings'];
    }
		$selected_latt = get_post_meta($property_id, 'prop_latt', true );
		$selected_long = get_post_meta($property_id, 'prop_long', true );
		$data_array = array("latitude" => $selected_latt, "longitude" => $selected_long, "distance" => $nearby_distance);
		$lats_longs = propertya_min_max_latt_long($data_array);
		if(is_array($lats_longs) && !empty($lats_longs) && count($lats_longs) > 0)
		{
				$lat_lng_meta_query[] = array(
                    'key' => 'prop_latt',
                    'value' => array($lats_longs['lat']['min'], $lats_longs['lat']['max']),
                    'compare' => 'BETWEEN',
                    'type' => 'DECIMAL',
                );
				$lat_lng_meta_query[] = array(
                    'key' => 'prop_long',
                    'value' => array($lats_longs['long']['min'], $lats_longs['long']['max']),
                    'compare' => 'BETWEEN',
                    'type' => 'DECIMAL',
                );
				add_filter('get_meta_sql', 'propertya_decimal_precision');
                if (!function_exists('propertya_decimal_precision'))
				{
                    function propertya_decimal_precision($array)
					{
                        $array['where'] = str_replace('DECIMAL', 'DECIMAL(10,3)', $array['where']);
                        return $array;
                    }
                }
				$args = array(
					'post_type' => 'property',
					'post_status' => 'publish',
					'post__not_in' => array($property_id),
					'posts_per_page' => $nearby_post_per_page,
					'order' => 'DESC',
					'orderby' => 'date',
                  //  'fields' => 'ids',
					'meta_query' => array(
						 array(
							'key' => 'prop_status',
							'value' => '1',
							'compare' => '='
						 ),
						 $lat_lng_meta_query,
					 ),
				 );
			  $query = new WP_Query( $args );
			  if($query->have_posts())
			  {
				  $listingz = new propertya_getlistings();
			  ?>	  
				<div class="sidebar-widget-seprator">
                    <div class="sidebar-widget-header">
                      <h4><?php echo esc_html(propertya_strings('prop_sidebar_nearby')); ?></h4>
                    </div>
                    <div class="sidebar-widget-body">
                            <ul class="widget-inner-container nearby-listing">
                            <?php    
							  while ($query->have_posts())
							  {
								   $query->the_post();
								   $new_property_idz = get_the_ID();
								   if (get_post_meta($new_property_idz, 'prop_latt', true) != "" && get_post_meta($new_property_idz, 'prop_long', true) != "")
								   {
									   $second_lat = get_post_meta($new_property_idz, 'prop_latt', true );
									   $second_long = get_post_meta($new_property_idz, 'prop_long', true );
									   $newdistacne = propertya_get_distance_between_ponits($selected_latt, $selected_long, $second_lat, $second_long);
									  $cacl_distance = round($newdistacne[$selected_distance_unit],1);
									  $dis_abbt = $distance_unit[$selected_distance_unit]['dis_abbt'];
									  $listingz->propertya_listings_nearby($new_property_idz,$cacl_distance,$dis_abbt); 
								   }
							  }
							   wp_reset_postdata();
							  ?>
                            </ul>
                     </div>
                </div>            
              <?php    
			  }
		}
	}