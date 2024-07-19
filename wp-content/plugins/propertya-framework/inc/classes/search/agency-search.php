<?php
// Ajax handler for Pagination
add_action( 'wp_ajax_prop_agency_search', 'propertya_framework_agency_search' );
add_action( 'wp_ajax_nopriv_prop_agency_search', 'propertya_framework_agency_search' );
if (!function_exists ( 'propertya_framework_agency_search' ))
{
	function propertya_framework_agency_search()
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
		$by_location = '';
        if (isset($params['by_location']) && $params['by_location'] != "") {
			$by_location = array(
				array(
					'taxonomy' => 'agency_location',
					'field' => 'slug',
					'terms' => $params['by_location'],
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
                    'key' => 'agency_latt',
                    'value' => array($lats_longs['lat']['min'], $lats_longs['lat']['max']),
                    'compare' => 'BETWEEN',
                    'type' => 'DECIMAL',
                );
				$lat_lng_meta_query[] = array(
                    'key' => 'agency_long',
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
			
		}
		$args	=	array
	    (
		's' => $title,
		'post_type' => 'property-agency',
		'post_status' => 'publish',
		'posts_per_page' => get_option('posts_per_page'),
		'paged' => $page_no,
        'fields' => 'ids',
		'meta_key' => 'agency_is_featured',
		'meta_query'    => array(
			array(
				'key'       => 'agency_status',
				'value'     => '1',
				'compare'   => '=',
			),
			$lat_lng_meta_query
		),
		'tax_query' => array(
			$by_location
		),
		'orderby'  => $orderby,
		'order'=> $order,
	  );
	  
	   $results = new WP_Query( $args );
	   $fetch_output = '';
       if ($results->have_posts())
	   {
		   require trailingslashit(get_template_directory()) . 'template-parts/search/agency-search/grids/grids.php';
		   $return = array('total_results' => $results->found_posts ,'pagination' => propertya_pagination_search($results, $page_no) , 'fliters' => $filter_html,  'listings' => $fetch_output, );
		   wp_send_json_success($return);
	   }
	   else
	   {
		   
		   $no_result = propertya_framework_no_result_found();
		   $return = array('fliters' => $filter_html,  'no_result' => $no_result,'total_results' => $results->found_posts);
		   wp_send_json_error($return);
	   }
	}
}


// Ajax handler for Suggestions
add_action( 'wp_ajax_prop_agency_search_suggestions', 'propertya_framework_agency_search_suggestions' );
add_action( 'wp_ajax_nopriv_prop_agency_search_suggestions', 'propertya_framework_agency_search_suggestions' );
if (!function_exists ( 'propertya_framework_agency_search_suggestions' ))
{
	function propertya_framework_agency_search_suggestions()
	{
		if (!empty($_GET['q']))
		{
			$return = array();
			$keyword = trim(strtolower(esc_sql($_GET['q'])));
			$search_results = new WP_Query(array(
                's' => $keyword,
                'post_type' => 'property-agency',
                'post_status' => 'publish',
                'posts_per_page' => 15,
                'fields' => 'ids',
				'meta_query'    => array(
				array(
						'key'       => 'agency_status',
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
                     $agency_id = get_the_ID();
					 $title = get_the_title($agency_id);
					 $return[] = propertya_clean_titles($title);
				}
				wp_reset_postdata();
			}
			echo json_encode($return);
		}
		die();
	}
}

//Load More Results
add_action( 'wp_ajax_prop_loadmore_agencies', 'propertya_framework_load_moreagencies' );
add_action( 'wp_ajax_nopriv_prop_loadmore_agencies', 'propertya_framework_load_moreagencies' );
if (!function_exists ( 'propertya_framework_load_moreagencies' ))
{
	function propertya_framework_load_moreagencies()
	{
		  
		global $paged;
		$page_no = '';
		$limit = $_POST['limit'] ? $_POST['limit'] : '6';
		$type = $_POST['type'] ? $_POST['type'] : 'all';
		$order_status = $_POST['order'] ? $_POST['order'] : 'desc';
		$layout = $_POST['layout'] ? $_POST['layout'] : 'grid1';
		$grid_type = $layout;
		$page_no =  $_POST['page_no'] ? $_POST['page_no'] : 1;
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
				'key' => 'agency_is_featured',
				'value' => 0,
				'compare' => '=',
			 );
		}
		else if ($type == 'featured')
		{
			$listing_type = array(
				'key' => 'agency_is_featured',
				'value' => 1,
				'compare' => '=',
			 );
		}
		else if ($type == 'trusted')
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
			'posts_per_page' =>$limit,
			'offset'     =>  $offset,
			'paged' =>$page_no,
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