<?php
global $propertya_options;

$style_layout = get_query_var('list-type');

if((!empty($style_layout) && $style_layout =="grid") || $style_layout =="list")
{
    if ($style_layout =='list'){
     $grid_type = 'list3';
    }else{
        $grid_type= 'type3';
    }

}else
{
    $grid_type = 'type3';


     if(!empty($_GET['list-type'])  &&  $_GET['list-type']  ==   'grid'  )
    {
        $grid_type= 'type3';
    } elseif(!empty($_GET['list-type'])  &&  $_GET['list-type']  ==   'list' )
    {
        $grid_type= 'list3';
    }
     else
        {
            $grid_type = $propertya_options['prop_listing_search_grids'];
        }
    }
$map_listings = $fetch_output = '';
$layout_type = new propertya_getlistings();
while ($results->have_posts())
{
    $results->the_post();
    $property_id = get_the_ID();
    $function = "propertya_listings_$grid_type";
    $fetch_output .= $layout_type->$function($property_id,'2');
	//listing on maps
	if(!empty(propertya_strings('prop_listing_search_layout')) && propertya_strings('prop_listing_search_layout') == 'map')
	{
	    if (get_post_meta($property_id, 'prop_latt', true) != "" && get_post_meta($property_id, 'prop_long', true) != "")
		{
			$mapfunction = "propertya_listings_map_listings";
			$map_listings .= $layout_type->$mapfunction($property_id);
		}
	}
}
if(!empty(propertya_strings('prop_listing_search_layout')) && propertya_strings('prop_listing_search_layout') == 'map')
{

    
	return $map_listings;
}
wp_reset_postdata();