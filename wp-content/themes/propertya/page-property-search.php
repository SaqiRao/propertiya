<?php
 /* Template Name: Property Search */ 
/**
 * The template for displaying Pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package propertya
 */
?>
<?php
get_header();
//pagination	
if (get_query_var('paged'))
{
    $paged = get_query_var('paged');
} else if (get_query_var('page'))
{
    $paged = get_query_var('page');
} else
{
    $paged = 1;
}
$title = '';
if (isset($_GET['by_title']) && $_GET['by_title'] != "")
{
    $title =  trim($_GET['by_title']);
}
//by type
$by_type = '';
if (isset($_GET['property-type']) && $_GET['property-type'] != "") {
	$by_type = array(
		array(
			'taxonomy' => 'property_type',
			'field' => 'slug',
			'terms' => trim($_GET['property-type']),
		),
	);
}
//by offer type
$offer_type = '';
if (isset($_GET['offer-type']) && $_GET['offer-type'] != "") {
	$offer_type = array(
		array(
			'taxonomy' => 'property_status',
			'field' => 'slug',
			'terms' => trim($_GET['offer-type']),
		),
	);
}
//label type
$label_type = '';
if (isset($_GET['label-type']) && $_GET['label-type'] != "") {
	$label_type = array(
		array(
			'taxonomy' => 'property_label',
			'field' => 'slug',
			'terms' => $_GET['label-type'],
		),
	);
}
//By Locations
$custom_location = '';
if (isset($_GET['location-by']) && $_GET['location-by'] != "") {
	$custom_location = array(
		array(
			'taxonomy' => 'property_location',
			'field' => 'slug',
			'terms' => trim(sanitize_text_field($_GET['location-by'])),
		),
	);
}
//currency type
$currency_type = '';
if (isset($_GET['currency-type']) && $_GET['currency-type'] != "") {
	$currency_type = array(
		array(
			'taxonomy' => 'property_currency',
			'field' => 'slug',
			'terms' =>  trim(sanitize_text_field($_GET['currency-type'])),
		),
	);
}
//price
$price = $max_price = $min_price = '';
if (!empty($_GET['min-price']) && !empty($_GET['max-price'])) {
	 $min_price = doubleval($_GET['min-price']);
	 $max_price = doubleval($_GET['max-price']);
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
else if (!empty($_GET['min-price']))
{
	$min_price = doubleval($_GET['min-price']);
	$price = array(
			'key' => 'prop_first_price',
			'value' => $min_price,
			'type' => 'numeric',
			'compare' => '>=',
		 );
}
else if (!empty($_GET['max-price']))
{
	$max_price = doubleval($_GET['max-price']);
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
if (!empty($_GET['min-area']) && !empty($_GET['max-area'])) {
	 $min_area = doubleval($_GET['min-area']);
	 $max_area = doubleval($_GET['max-area']);
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
else if (!empty($_GET['min-area']))
{
	$min_area = doubleval($_GET['min-area']);
	$area = array(
			'key' => 'prop_area_size',
			'value' => $min_area,
			'type' => 'numeric',
			'compare' => '>=',
		 );
}
else if (!empty($_GET['max-area']))
{
	$max_area = doubleval($_GET['max-area']);
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
//bedrooms
$beds = '';
if (isset($_GET['type-beds']) && $_GET['type-beds'] != "") {
	$compare = '=';
	if(intval($_GET['type-beds'] == 5))
	{
		$compare = '>=';	
	}
	$beds = array(
		array(
			'key' => 'prop_beds_qty',
			'value' => intval($_GET['type-beds']),
			'compare' => $compare,
			'type' => 'NUMERIC',
		),
	);
}
//bathrooms
$baths = '';
if (isset($_GET['type-bath']) && $_GET['type-bath'] != "") {
	$compare_ststus = '=';
	if(intval($_GET['type-bath'] == 5))
	{
		$compare_ststus = '>=';	
	}
	$baths = array(
		array(
			'key' => 'prop_baths_qty',
			'value' => intval($_GET['type-bath']),
			'compare' => $compare_ststus,
			'type' => 'NUMERIC',
		),
	);
}
//near me
$lat_lng_meta_query = $data_array = array();
if (isset($_GET['latt']) && $_GET['latt'] != "" && isset($_GET['long']) && $_GET['long'] != "" && isset($_GET['distance']) && $_GET['distance'] != "")
{
	$latt = $_GET['latt'];
	$long = $_GET['long'];
	$distance = $_GET['distance'];
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
//by author
$author_slug = '';
if (isset($_GET['property-author']) && $_GET['property-author'] != "")
{
	$author_slug = $_GET['property-author'];
}

	$args	=	array
	(
		's' => $title,
		'author' => $author_slug,
		'post_type' => 'property',
		'post_status' => 'publish',
		'posts_per_page' => '10',
		'paged' => $paged,
		'meta_key' => 'prop_is_feature_listing',
        'fields' => 'ids',
		'orderby'  => array(
			'meta_value' => 'DESC',
			'post_date'      => 'DESC',
		),
		'meta_query'    => array(
			array(
				'key'       => 'prop_status',
				'value'     => '1',
				'compare'   => '=',
			),
			$price,
			$area,
			$beds,
			$baths,
			$lat_lng_meta_query,
		),
		'tax_query' => array(
			$by_type,
			$offer_type,
			$label_type,
			$custom_location,
			$currency_type,
		),
		'order'=> 'DESC',
	);
	$results = new WP_Query( $args );
	//search layout type
	$layout_type = 'sidebar';
	$layout_type = propertya_strings('prop_listing_search_layout');
	require trailingslashit(get_template_directory()) . 'template-parts/search/property-search/search-with-' . $layout_type . '.php';
get_footer();
?>