<?php
global $propertya_options;
$grid_type = 'grid1';
if(isset($_GET['agency-layout']) && ($_GET['agency-layout']!=""))
{
    $grid_type = trim($_GET['agency-layout']);
}
else if(isset($params['layout-type']) && $params['layout-type'] != "")
{
    $grid_type = trim($params['layout-type']);
}
else
{
    if(isset($propertya_options['prop_ag_search_layout']) && $propertya_options['prop_ag_search_layout'] !="")
    {
        $grid_type = $propertya_options['prop_ag_search_layout'];
    }
}
$fetch_output = '';
$layout_type = new propertya_get_agencies();
while ($results->have_posts())
{
    $results->the_post();
    $property_id = get_the_ID();
    $function = "propertya_get_agencies_$grid_type";
    $fetch_output .= $layout_type->$function($property_id);
}
wp_reset_postdata();