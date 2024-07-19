<?php
$map_listings = $fetch_output = '';
$layout_type = new propertya_getlistings();
while ($results->have_posts())
{
    $results->the_post();
    $property_id = get_the_ID();
    $function = "propertya_listings_$grid_type";
    $fetch_output .= $layout_type->$function($property_id,'2');
}
wp_reset_postdata();