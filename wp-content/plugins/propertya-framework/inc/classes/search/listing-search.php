<?php
// Ajax handler for Pagination
add_action( 'wp_ajax_prop_listing_search', 'propertya_framework_listing_search' );
add_action( 'wp_ajax_nopriv_prop_listing_search', 'propertya_framework_listing_search' );
if (!function_exists ( 'propertya_framework_listing_search' ))
{
	function propertya_framework_listing_search()
	{
		
		$params = array();
		parse_str($_POST['collect_data'], $params);
		
		$page_no = '';
        if (isset($_POST['page_no'])) {
            $page_no = $_POST['page_no'];
        } else {
            $page_no = 1;
        }
       
		$filter_html = '<div class="filter-tags"><ul class="filter-tags-list"><li class="filter-tags-render"><span class="filter-reset">'.esc_html__( 'Clear All', 'propertya-framework' ).':</span>'.esc_html__( 'Filters', 'propertya-framework' ).'<a href="javascript:void(0)" id="reset_ajax_result" class="filter-reset-btn">×</a></li></ul></div>';
		//Listing Title
        $title = '';
        if (isset($params['by_title']) && $params['by_title'] != "") {
            $title = $params['by_title'];
        }
		$by_author = '';
        if (isset($params['author']) && $params['author'] != "") {
            $by_author = $params['author'];
        }
		$by_location = '';
        if (isset($params['by_location']) && $params['by_location'] != "") {
			$by_location = array(
				array(
					'taxonomy' => 'agent_location',
					'field' => 'slug',
					'terms' => $params['by_location'],
				),
			);
        }
		//by type

		$by_type = '';
        if (isset($params['property-type']) && $params['property-type'] != "") {
            $by_type = array(
				array(
					'taxonomy' => 'property_type',
					'field' => 'slug',
					'terms' => $params['property-type'],
				),
			);
        }
       
        //by category type
        $category_type = '';
		if(!empty($cats))
		{
			$category_type =  array(
				'taxonomy' => 'prop-category',
				'field' => 'term_id',
				'terms' => array($cats),
			);
		}
		//by offer type
		$offer_type = '';
        if (isset($params['offer-type']) && $params['offer-type'] != "") {
            $offer_type = array(
				array(
					'taxonomy' => 'property_status',
					'field' => 'slug',
					'terms' => $params['offer-type'],
				),
			);
        }
		//currency type
		$currency_type = '';
        if (isset($params['currency-type']) && $params['currency-type'] != "") {
            $currency_type = array(
				array(
					'taxonomy' => 'property_currency',
					'field' => 'slug',
					'terms' => $params['currency-type'],
				),
			);
        }
        if (isset($params['list-type']) && $params['list-type'] != "") {
			$grid_type = $params['list-type'];
        }
		//bedrooms
		$beds = '';
        if (isset($params['type-beds']) && $params['type-beds'] != "") {
			$compare = '=';
			if(intval($params['type-beds'] == 5))
			{
				$compare = '>=';	
			}
            $beds = array(
				array(
					'key' => 'prop_beds_qty',
					'value' => intval($params['type-beds']),
					'compare' => $compare,
					'type' => 'NUMERIC',
				),
			);
        }
		//bathrooms
		$baths = '';
        if (isset($params['type-bath']) && $params['type-bath'] != "") {
			$compare_ststus = '=';
			if(intval($params['type-bath'] == 5))
			{
				$compare_ststus = '>=';	
			}
            $baths = array(
				array(
					'key' => 'prop_baths_qty',
					'value' => intval($params['type-bath']),
					'compare' => $compare_ststus,
					'type' => 'NUMERIC',
				),
			);
        }
		//price
		$price = $max_price = $min_price = '';
		if (!empty($params['min-price']) && !empty($params['max-price'])) {
			 $min_price = doubleval($params['min-price']);
             $max_price = doubleval($params['max-price']);
			 if ($min_price >= 0 && $min_price < $max_price )
			 {
				 $price = array(
					'key' => 'prop_first_price',
					'value' => array($min_price, $max_price),
					'type' => 'numeric',
					'compare' => 'BETWEEN',
    			 );
			 }
			 else
			 {
				 $price = array(
					'key' => 'prop_first_price',
					'value' => $min_price,
					'type' => 'numeric',
					'compare' => '>=',
    			 );
			 }
		}
		else if (!empty($params['min-price']))
		{
			$min_price = doubleval($params['min-price']);
			$price = array(
					'key' => 'prop_first_price',
					'value' => $min_price,
					'type' => 'numeric',
					'compare' => '>=',
    			 );
		}
		else if (!empty($params['max-price']))
		{
			$max_price = doubleval($params['max-price']);
			$price = array(
					'key' => 'prop_first_price',
					'value' => $max_price,
					'type' => 'numeric',
					'compare' => '<=',
    			 );
		}
		else
		{
			$price = '';
		}
		//Area 
		$area = $max_area = $min_area = '';
		if (!empty($params['min-area']) && !empty($params['max-area'])) {
			 $min_area = doubleval($params['min-area']);
             $max_area = doubleval($params['max-area']);
			 if ($min_area >= 0 && $min_area < $max_area )
			 {
				 $area = array(
					'key' => 'prop_area_size',
					'value' => array($min_area, $max_area),
					'type' => 'numeric',
					'compare' => 'BETWEEN',
    			 );
			 }
			 else
			 {
				 $area = array(
					'key' => 'prop_area_size',
					'value' => $min_area,
					'type' => 'numeric',
					'compare' => '>=',
    			 );
			 }
		}
		else if (!empty($params['min-area']))
		{
			$min_area = doubleval($params['min-area']);
			$area = array(
					'key' => 'prop_area_size',
					'value' => $min_area,
					'type' => 'numeric',
					'compare' => '>=',
    			 );
		}
		else if (!empty($params['max-area']))
		{
			$max_area = doubleval($params['max-area']);
			$area = array(
					'key' => 'prop_area_size',
					'value' => $max_area,
					'type' => 'numeric',
					'compare' => '<=',
    			 );
		}
		else
		{
			$area = '';
		}
		//features
		$more_features = '';
        if (isset($params['prop-amens']) && $params['prop-amens'] != "" && is_array($params['prop-amens'])) {
            $more_features = array(
				array(
					'taxonomy' => 'property_feature',
					'field' => 'slug',
					'terms' => $params['prop-amens'],
				),
			);
        }
		//label type
		$label_type = '';
        if (isset($params['label-type']) && $params['label-type'] != "") {
            $label_type = array(
				array(
					'taxonomy' => 'property_label',
					'field' => 'slug',
					'terms' => $params['label-type'],
				),
			);
        }
		//property ID
		$property_id = '';
        if (isset($params['by_id']) && $params['by_id'] != "") {
            $property_id = array(
				array(
					'key' => 'prop_refer',
					'value' => trim(sanitize_text_field($params['by_id'])),
					'compare' => '=',
					'type' => 'char',
				),
			);
        }
		//label type
		$custom_location = '';
        if (isset($params['location-by']) && $params['location-by'] != "") {
            $custom_location = array(
				array(
					'taxonomy' => 'property_location',
					'field' => 'slug',
					'terms' => trim(sanitize_text_field($params['location-by'])),
				),
			);
        }
		//near me
		$lat_lng_meta_query = $data_array = array();
		if (isset($params['latt']) && $params['latt'] != "" && isset($params['long']) && $params['long'] != "" && isset($params['distance']) && $params['distance'] != "")
		{
			$latt = $params['latt'];
			$long = $params['long'];
			$distance = $params['distance'];
			$data_array = array("latitude" => $latt, "longitude" => $long, "distance" => $distance);
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
			}
		}
		//sorting
		$order = 'DESC';
		$orderby = array(
		    'meta_value' => 'DESC',
			'post_date'      => 'DESC',
		);
		if (isset($_POST['sort_by']) && $_POST['sort_by'] != "") {
			
			$sort_type = $_POST['sort_by'];
			//oldest
			if($sort_type == 'oldest')
			{
				$orderby = array(
					'meta_value' => 'ID',
					'post_date'      => 'ASC',
				);
				$order = 'ASC';
			}
			//newset
			if($sort_type == 'newest')
			{
				$orderby = array(
					'meta_value' => 'DESC',
					'post_date'      => 'DESC',
				);
				$order = 'DESC';
			}
			//title asc
			if($sort_type == 'title-asc')
			{
				$orderby = array(
					'meta_value' => 'DESC',
					'title' => 'ASC'
				);
				$order = 'ASC';
			}
			//tile desc
			if($sort_type == 'title-desc')
			{
				$orderby = array(
					'meta_value' => 'DESC',
					'title' => 'DESC'
				);
				$order = 'DESC';
			}
			//price asc
			if($sort_type == 'price-asc')
			{
				$orderby = 'meta_value_num';	
				$order = 'ASC';
			}
			//price desc
			if($sort_type == 'price-desc')
			{
				$orderby = 'meta_value_num';

				$order = 'DESC';
			}	
		}
		if($sort_type == 'price-asc'  || $sort_type == 'price-desc'){
	    		$args	=	array
	    (
			's' => $title,
			'post_type' => 'property',
			'author' => $by_author,
			'post_status' => 'publish',
			'posts_per_page' => get_option('posts_per_page'),
			'paged' => $page_no,
            'fields' => 'ids',
			'meta_key' => 'prop_first_price',
	    	'meta_query'    => array(
				array(
					'key'       => 'prop_status',
					'value'     => '1',
					'compare'   => '=',
			),
			$lat_lng_meta_query,
			$beds,
			$baths,
			$price,
			$area,
			$property_id
		),
		'tax_query' => array(
			$by_location,
			$by_type,
			$offer_type,
			$category_type,
			$currency_type,
			$more_features,
			$label_type,
			$custom_location
		),
		'orderby'  => $orderby,
		'order'=> $order,
	);
	    	}
	    	else{
		$args	=	array
	    (

		's' => $title,
		'post_type' => 'property',
		'author' => $by_author,
		'post_status' => 'publish',
		'posts_per_page' => get_option('posts_per_page'),
		'paged' => $page_no,
            'fields' => 'ids',
		'meta_key' => 'prop_is_feature_listing',
		'meta_query'    => array(
			array(
				'key'       => 'prop_status',
				'value'     => '1',
				'compare'   => '=',
			),
			$lat_lng_meta_query,
			$beds,
			$baths,
			$price,
			$area,
			$property_id
		),
		'tax_query' => array(
			$by_location,
			$by_type,
			$offer_type,
			$currency_type,
			$more_features,
			$label_type,
			$custom_location
		),
		'orderby'  => $orderby,
		'order'=> $order,
	  );
	}
	   $results = new WP_Query( $args );
	   
	   $map_listings = $fetch_output = '';
       if ($results->have_posts())
	   {
		   if(!empty(propertya_framework_get_options('prop_listing_search_layout')) && propertya_framework_get_options('prop_listing_search_layout') == 'map')
		   {
		
		   	set_query_var('list-type', $grid_type);
			    require trailingslashit(get_template_directory()) . 'template-parts/search/property-search/grids/maps.php';
				$map_listings = '['.rtrim($map_listings, ',').']';	
	
            //mapbox
			while ($results->have_posts())
       {
			$results->the_post();

			$property_id = get_the_ID();
			$lat = get_post_meta( $property_id, 'prop_latt', true);
			$lng  =  get_post_meta( $property_id, 'prop_long', true);
			$all_idz = propertya_framework_fetch_gallery_idz($property_id);
			$url_link=esc_url(get_the_permalink($property_id));
			$featured_listing = '';

			if (get_post_meta($property_id, 'prop_is_feature_listing', true ) == "1")
			{
				$featured_listing = esc_html($localization['feat']);
			}
            $street_addr= get_post_meta($property_id, 'prop_street_addr', true );
            $title=propertya_title_limit(37,$property_id); 

			//price
			$get_all_prices =  propertya_framework_fetch_price($property_id);
				if(!empty($get_all_prices) && is_array($get_all_prices) && count($get_all_prices) > 0 && array_key_exists("main_price",$get_all_prices))
				{
					$selected_pricelabel_after = '';
					if (array_key_exists("optional_price",$get_all_prices))
					{
						$optional_price = $get_all_prices['optional_price'];
					}
					if (array_key_exists("after_prefix",$get_all_prices))
					{
						$selected_pricelabel_after = '<small>'.$get_all_prices['after_prefix'].'</small>';
					}
					$price_rent = $get_all_prices['main_price'] . $selected_pricelabel_after;
				}
				
			$map_data[] = array(
					"type" => "Feature",
					"properties" => array(
						"id" => $property_id,
						"html" => '<div class="map-in-listings">
						<div class="list-thumbnail"> 
					   <img class="img-fluid" src="'.esc_url(propertya_framework_img_src($all_idz,'propertya-blog-thumb')).'">
					  <a href= "'.$url_link.'" ></a>'.$featured_listing.'</div>
					  <div class="entry-header">
					  <div class="my-list2-pricing"><h3><span class="main-reg-price">'. $price_rent.'</h3></div>
					  
					  <h5 class="card-title"> <a class="clr-black" href= "'.$url_link.'">'. $title. '</a>
					  </h5></div>
					  <div class="entry-meta">'.$street_addr.'</div>
						</div>',
					),
					"geometry" => array(
					 "type" => "point",
					 "coordinates" => [$lat,$lng],
					   
					),
				);
        }//while	
		   }
		  else
		   {
		   		set_query_var('list-type', $grid_type);
				require trailingslashit(get_template_directory()) . 'template-parts/search/property-search/grids/grids.php';
				$map_listings = '';
		   }
		   $img= get_template_directory_uri()."\libs\images\map-marker.png";
		   $layer= $propertya_options['property_opt_mapbox_layer_selection'] ;
		   $zoom = $propertya_options['property_opt_mapbox_zoom_selection'];
		   $return = array('total_results' => $results->found_posts ,'pagination' => propertya_pagination_search($results, $page_no) , 'fliters' => $filter_html,  'listings' => $fetch_output , 'map_listings' => $map_listings,'mapbox_data'=> $map_data, 'imgg' => $img, 'layer' => $layer, 'zoom'=> $zoom);
		   wp_send_json_success($return);
		
	   }
	   else
	   {
		   $no_result = propertya_framework_no_result_found();
		  
		  $return = array('fliters' => $filter_html,  'no_result' => $no_result,'map_listings' => '0','total_results' => $results->found_posts);
		  

		  wp_send_json_error($return);

	   }
	}
}

// Ajax handler for Suggestions
add_action( 'wp_ajax_prop_listing_search_suggestions', 'propertya_framework_listing_search_suggestions' );
add_action( 'wp_ajax_nopriv_prop_listing_search_suggestions', 'propertya_framework_listing_search_suggestions' );
if (!function_exists ( 'propertya_framework_listing_search_suggestions' ))
{
	function propertya_framework_listing_search_suggestions()
	{
		if (!empty($_GET['q']))
		{
			$return = array();
			$keyword = trim(sanitize_text_field(strtolower(esc_sql($_GET['q']))));
			$search_results = new WP_Query(array(
                's' => $keyword,
                'post_type' => 'property',
                'post_status' => 'publish',
                'posts_per_page' => 15,
                'fields' => 'ids',
				'meta_query'    => array(
				array(
						'key'       => 'prop_status',
						'value'     => '1',
						'compare'   => '=',
					),
				),
            ));
			if ($search_results->have_posts())
			{
				while ($search_results->have_posts())
				{
					 $search_results->the_post();
                     $property_id = get_the_ID();
					 $title = get_the_title($property_id);
					 $return[] = propertya_clean_titles($title);
				}
			}
            wp_reset_postdata();
			echo json_encode($return);
		}
		die();
	}
}


//Custom Locations

add_action('wp_ajax_nopriv_prop_listing_locations', 'propertya_framework_listing_custom_locations');
add_action('wp_ajax_prop_listing_locations', 'propertya_framework_listing_custom_locations');
if (!function_exists ( 'propertya_framework_listing_custom_locations' ))
{
	function propertya_framework_listing_custom_locations()
	{
		$return = array();
		$search_param = trim(sanitize_text_field($_GET['q']));
		$get_locations = get_terms(array('taxonomy' => 'property_location', 'hide_empty' => false, 'name__like' => $search_param, 'fields' => 'all','number' => 10));
		if (!empty($get_locations)) {
			foreach ($get_locations as $loc) {
				$return[] = array($loc->slug, $loc->name . '       '. '('.$loc->count.')');
			}
		}
		echo json_encode($return);
		die;
	}
}

//Load More Results
add_action( 'wp_ajax_prop_loadmore_listings', 'propertya_framework_load_morelistings' );
add_action( 'wp_ajax_nopriv_prop_loadmore_listings', 'propertya_framework_load_morelistings' );
if (!function_exists ( 'propertya_framework_load_morelistings' ))
{
	function propertya_framework_load_morelistings()
	{
		global $paged;
		$page_no = '';
		$limit = $_POST['limit'] ? $_POST['limit'] : '6';
		$type = $_POST['type'] ? $_POST['type'] : 'all';
		$order_status = $_POST['order'] ? $_POST['order'] : 'desc';
		$layout = $_POST['layout'] ? $_POST['layout'] : 'type3';
		$status = $_POST['typestatus'] ? $_POST['typestatus'] : 'all';
		$cats = $_POST['cats'];
		$location_id = $_POST['location_id'] ? $_POST['location_id'] : '';
		$grid_type = $layout;
		$page_no =  $_POST['page_no'] ? $_POST['page_no'] : 1;
		$col_type = $_POST['col_type'] ? $_POST['col_type'] : '3';
		$offset = '';
		if($paged > 1)
		{
			$offset = ( $page_no - 1 ) * $limit;
		}
		//order
		$order = 'DESC';
		$order_by = 'date';
		if ($order_status == 'asc')
		{
			$order = 'ASC';
		}
		if ($order_status == 'desc')
		{
			$order = 'DESC';
		}
		if ($order_status == 'rand')
		{
			 $order_by = 'rand';
		}
		//listing type
		if ($type == 'simple')
		{
			$listing_type = array(
				'key' => 'prop_is_feature_listing',
				'value' => 0,
				'compare' => '=',
			 );
		}
		else if ($type == 'featured')
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
		
		$category_type = '';
		if(!empty($cats))
		{
			$category_type =  array(
				'taxonomy' => 'property_type',
				'field' => 'term_id',
				'terms' => array($cats),
			);
		}
		$offer_type = '';
		if(!empty($status))
		{
			$offer_type =  array(
				'taxonomy' => 'property_status',
				'field' => 'term_id',
				'terms' => array($status),
			);
		}
		
		$custom_location = '';
		if(!empty($location_id))
		{
			$custom_location =  array(
				'taxonomy' => 'property_location',
				'field' => 'term_id',
				'terms' => array($location_id),
			);
		}  
		
		$args	=	array
		(
			'post_type' => 'property',
			'post_status' => 'publish',
			'posts_per_page' =>-1,
			'offset'     =>  $offset,
            'fields' => 'ids',
			'paged' =>$page_no,
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
				$fetch_output .= $layout_type->$function($property_id,$col_type);
			}
			wp_reset_postdata();
			$return = array('listings' => $fetch_output);
			wp_send_json_success($return);
		}
		else
		{
			   $return = array('no_result' =>true);
			   wp_send_json_error($return);
		}
	}
}



// Ajax handler for Pagination
add_action( 'wp_ajax_prop_listing_search_home', 'propertya_framework_listing_search_home_based' );
add_action( 'wp_ajax_nopriv_prop_listing_search_home', 'propertya_framework_listing_search_home_based' );
if (!function_exists ( 'propertya_framework_listing_search_home_based' ))
{
	function propertya_framework_listing_search_home_based()
	{
		$params = array();
		parse_str($_POST['collect_data'], $params);
		$page_no = '';
        if (isset($_POST['page_no'])) {
            $page_no = $_POST['page_no'];
        } else {
            $page_no = 1;
        }
        
        $grid_type = $params['grid-type'];
        
		$filter_html = '<div class="filter-tags"><ul class="filter-tags-list"><li class="filter-tags-render"><span class="filter-reset">'.esc_html__( 'Clear All', 'propertya-framework' ).':</span>'.esc_html__( 'Filters', 'propertya-framework' ).'<a href="javascript:void(0)" id="reset_ajax_result_home" class="filter-reset-btn">×</a></li></ul></div>';
		//Listing Title
        $title = '';
        if (isset($params['by_title']) && $params['by_title'] != "") {
            $title = $params['by_title'];
        }
		$by_author = '';
        if (isset($params['author']) && $params['author'] != "") {
            $by_author = $params['author'];
        }
		$by_location = '';
        if (isset($params['by_location']) && $params['by_location'] != "") {
			$by_location = array(
				array(
					'taxonomy' => 'agent_location',
					'field' => 'slug',
					'terms' => $params['by_location'],
				),
			);
        }
		//by type
		$by_type = '';
        if (isset($params['property-type']) && $params['property-type'] != "") {
            $by_type = array(
				array(
					'taxonomy' => 'property_type',
					'field' => 'slug',
					'terms' => $params['property-type'],
				),
			);
        }
		//by offer type
		$offer_type = '';
        if (isset($params['offer-type']) && $params['offer-type'] != "") {
            $offer_type = array(
				array(
					'taxonomy' => 'property_status',
					'field' => 'slug',
					'terms' => $params['offer-type'],
				),
			);
        }
		//currency type
		$currency_type = '';
        if (isset($params['currency-type']) && $params['currency-type'] != "") {
            $currency_type = array(
				array(
					'taxonomy' => 'property_currency',
					'field' => 'slug',
					'terms' => $params['currency-type'],
				),
			);
        }
		//bedrooms
		$beds = '';
        if (isset($params['type-beds']) && $params['type-beds'] != "") {
			$compare = '=';
			if(intval($params['type-beds'] == 5))
			{
				$compare = '>=';	
			}
            $beds = array(
				array(
					'key' => 'prop_beds_qty',
					'value' => intval($params['type-beds']),
					'compare' => $compare,
					'type' => 'NUMERIC',
				),
			);
        }
		//bathrooms
		$baths = '';
        if (isset($params['type-bath']) && $params['type-bath'] != "") {
			$compare_ststus = '=';
			if(intval($params['type-bath'] == 5))
			{
				$compare_ststus = '>=';	
			}
            $baths = array(
				array(
					'key' => 'prop_baths_qty',
					'value' => intval($params['type-bath']),
					'compare' => $compare_ststus,
					'type' => 'NUMERIC',
				),
			);
        }
		//price
		$price = $max_price = $min_price = '';
		if (!empty($params['min-price']) && !empty($params['max-price'])) {
			 $min_price = doubleval($params['min-price']);
             $max_price = doubleval($params['max-price']);
			 if ($min_price >= 0 && $min_price < $max_price )
			 {
				 $price = array(
					'key' => 'prop_first_price',
					'value' => array($min_price, $max_price),
					'type' => 'numeric',
					'compare' => 'BETWEEN',
    			 );
			 }
			 else
			 {
				 $price = array(
					'key' => 'prop_first_price',
					'value' => $min_price,
					'type' => 'numeric',
					'compare' => '>=',
    			 );
			 }
		}
		else if (!empty($params['min-price']))
		{
			$min_price = doubleval($params['min-price']);
			$price = array(
					'key' => 'prop_first_price',
					'value' => $min_price,
					'type' => 'numeric',
					'compare' => '>=',
    			 );
		}
		else if (!empty($params['max-price']))
		{
			$max_price = doubleval($params['max-price']);
			$price = array(
					'key' => 'prop_first_price',
					'value' => $max_price,
					'type' => 'numeric',
					'compare' => '<=',
    			 );
		}
		else
		{
			$price = '';
		}
		//Area 
		$area = $max_area = $min_area = '';
		if (!empty($params['min-area']) && !empty($params['max-area'])) {
			 $min_area = doubleval($params['min-area']);
             $max_area = doubleval($params['max-area']);
			 if ($min_area >= 0 && $min_area < $max_area )
			 {
				 $area = array(
					'key' => 'prop_area_size',
					'value' => array($min_area, $max_area),
					'type' => 'numeric',
					'compare' => 'BETWEEN',
    			 );
			 }
			 else
			 {
				 $area = array(
					'key' => 'prop_area_size',
					'value' => $min_area,
					'type' => 'numeric',
					'compare' => '>=',
    			 );
			 }
		}
		else if (!empty($params['min-area']))
		{
			$min_area = doubleval($params['min-area']);
			$area = array(
					'key' => 'prop_area_size',
					'value' => $min_area,
					'type' => 'numeric',
					'compare' => '>=',
    			 );
		}
		else if (!empty($params['max-area']))
		{
			$max_area = doubleval($params['max-area']);
			$area = array(
					'key' => 'prop_area_size',
					'value' => $max_area,
					'type' => 'numeric',
					'compare' => '<=',
    			 );
		}
		else
		{
			$area = '';
		}
		//features
		$more_features = '';
        if (isset($params['prop-amens']) && $params['prop-amens'] != "" && is_array($params['prop-amens'])) {
            $more_features = array(
				array(
					'taxonomy' => 'property_feature',
					'field' => 'slug',
					'terms' => $params['prop-amens'],
				),
			);
        }
		//label type
		$label_type = '';
        if (isset($params['label-type']) && $params['label-type'] != "") {
            $label_type = array(
				array(
					'taxonomy' => 'property_label',
					'field' => 'slug',
					'terms' => $params['label-type'],
				),
			);
        }
		//property ID
		$property_id = '';
        if (isset($params['by_id']) && $params['by_id'] != "") {
            $property_id = array(
				array(
					'key' => 'prop_refer',
					'value' => trim(sanitize_text_field($params['by_id'])),
					'compare' => '=',
					'type' => 'char',
				),
			);
        }
		//label type
		$custom_location = '';
        if (isset($params['location-by']) && $params['location-by'] != "") {
            $custom_location = array(
				array(
					'taxonomy' => 'property_location',
					'field' => 'slug',
					'terms' => trim(sanitize_text_field($params['location-by'])),
				),
			);
        }
		//near me
		$lat_lng_meta_query = $data_array = array();
		if (isset($params['latt']) && $params['latt'] != "" && isset($params['long']) && $params['long'] != "" && isset($params['distance']) && $params['distance'] != "")
		{
			$latt = $params['latt'];
			$long = $params['long'];
			$distance = $params['distance'];
			$data_array = array("latitude" => $latt, "longitude" => $long, "distance" => $distance);
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
			}
		}
		//sorting
		$order = 'DESC';
		$orderby = array(
		    'meta_value' => 'DESC',
			'post_date'      => 'DESC',
		);
		if (isset($_POST['sort_by']) && $_POST['sort_by'] != "") {
			
			$sort_type = $_POST['sort_by'];
			//oldest
			if($sort_type == 'oldest')
			{
				$orderby = array(
					'meta_value' => 'ID',
					'post_date'      => 'ASC',
				);
				$order = 'ASC';
			}
			//newset
			if($sort_type == 'newest')
			{
				$orderby = array(
					'meta_value' => 'DESC',
					'post_date'      => 'DESC',
				);
				$order = 'DESC';
			}
			//title asc
			if($sort_type == 'title-asc')
			{
				$orderby = array(
					'meta_value' => 'DESC',
					'title' => 'ASC'
				);
				$order = 'ASC';
			}
			//tile desc
			if($sort_type == 'title-desc')
			{
				$orderby = array(
					'meta_value' => 'DESC',
					'title' => 'DESC'
				);
				$order = 'DESC';
			}
			//price asc
			if($sort_type == 'price-asc')
			{
				$orderby = 'meta_value_num';	
				$order = 'ASC';
			}
			//price desc
			if($sort_type == 'price-desc')
			{
				$orderby = 'meta_value_num';

				$order = 'DESC';
			}	
		}
		if($sort_type == 'price-asc' || $sort_type == 'price-desc'){
	    		$args	=	array
	    (
			's' => $title,
			'post_type' => 'property',
			'author' => $by_author,
			'post_status' => 'publish',
			'posts_per_page' => get_option('posts_per_page'),
			'paged' => $page_no,
            'fields' => 'ids',
			'meta_key' => 'prop_first_price',
	    	'meta_query'    => array(
				array(
					'key'       => 'prop_status',
					'value'     => '1',
					'compare'   => '=',
			),
			$lat_lng_meta_query,
			$beds,
			$baths,
			$price,
			$area,
			$property_id
		),
		'tax_query' => array(
			$by_location,
			$by_type,
			$offer_type,
			$currency_type,
			$more_features,
			$label_type,
			$custom_location
		),
		'orderby'  => $orderby,
		'order'=> $order,
	);
	    	}
	    	else{
		$args	=	array
	    (

		's' => $title,
		'post_type' => 'property',
		'author' => $by_author,
		'post_status' => 'publish',
		'posts_per_page' => get_option('posts_per_page'),
		'paged' => $page_no,
            'fields' => 'ids',
		'meta_key' => 'prop_is_feature_listing',
		'meta_query'    => array(
			array(
				'key'       => 'prop_status',
				'value'     => '1',
				'compare'   => '=',
			),
			$lat_lng_meta_query,
			$beds,
			$baths,
			$price,
			$area,
			$property_id
		),
		'tax_query' => array(
			$by_location,
			$by_type,
			$offer_type,
			$currency_type,
			$more_features,
			$label_type,
			$custom_location
		),
		'orderby'  => $orderby,
		'order'=> $order,
	  );
	}
	   $results = new WP_Query( $args );
	   $map_listings = $fetch_output = '';
       if ($results->have_posts())
	   {
		   require trailingslashit(get_template_directory()) . "template-parts/search/property-search/grids/home.php";
           $map_listings = '';
		   $return = array('total_results' => $results->found_posts ,'pagination' => propertya_pagination_search_home($results, $page_no) , 'fliters' => $filter_html,  'listings' => $fetch_output , 'map_listings' => $map_listings);
		   wp_send_json_success($return);
	   }
	   else
	   {
		   $no_result = propertya_framework_no_result_found();
		   $return = array('fliters' => $filter_html,  'no_result' => $no_result,'map_listings' => '0','total_results' => $results->found_posts);
		   wp_send_json_error($return);
	   }
	}
}