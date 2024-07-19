<?php
 /* Template Name: Agents Search */ 
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
$by_location = '';
if (isset($_GET['by_location']) && $_GET['by_location'] != "") {
	$by_location = array(
		array(
			'taxonomy' => 'agent_location',
			'field' => 'slug',
			'terms' => $_GET['by_location'],
		),
	);
}
$by_type = '';
if (isset($_GET['by_type']) && $_GET['by_type'] != "") {
	$by_type = array(
		array(
			'taxonomy' => 'agent_types',
			'field' => 'slug',
			'terms' => $_GET['by_type'],
		),
	);
}
	$args	=	array
	(
		's' => $title,
		'post_type' => 'property-agents',
		'post_status' => 'publish',
		'posts_per_page' => get_option('posts_per_page'),
		'paged' => $paged,
        'fields' => 'ids',
		'meta_key' => 'agent_is_featured',
		'orderby'  => array(
			'meta_value' => 'DESC',
			'post_date'      => 'DESC',
		),
		'meta_query'    => array(
			array(
				'key'       => 'agent_status',
				'value'     => '1',
				'compare'   => '=',
			),
		),
		'tax_query' => array(
			$by_location,
			$by_type
		),
		'order'=> 'DESC',
	);
	$results = new WP_Query( $args );
	require trailingslashit(get_template_directory()) . 'template-parts/search/agent-search/search-with-sidebar.php';
get_footer();
?>