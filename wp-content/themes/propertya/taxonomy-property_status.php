<?php
if(in_array('propertya-framework/index.php', apply_filters('active_plugins',get_option('active_plugins'))))
{
	get_header();
	//pagination	
	if (get_query_var('paged'))
	{
		$paged = get_query_var('paged');
	} 
	else if (get_query_var('page'))
	{
		$paged = get_query_var('page');
	} 
	else
	{
		$paged = 1;
	}
	$args = propertya_framework_property_search($paged);
	$results = new WP_Query($args);
	//search layout type
	$layout_type = 'sidebar';
	$layout_type = propertya_strings('prop_listing_search_layout');
	require trailingslashit(get_template_directory()) . 'template-parts/search/property-search/search-with-' . $layout_type . '.php';
get_footer();
}