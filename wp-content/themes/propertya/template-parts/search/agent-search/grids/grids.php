<?php
global $propertya_options;
$grid_type = 'type1';
if(isset($_GET['agent-layout']) && ($_GET['agent-layout']!=""))
{
    $grid_type = trim($_GET['agent-layout']);
}
else if(isset($params['layout-type']) && $params['layout-type'] != "")
{
    $grid_type = trim($params['layout-type']);
}
else
{
    if(isset($propertya_options['prop_agent_search_layout']) && $propertya_options['prop_agent_search_layout'] !="")
    {
        $grid_type = $propertya_options['prop_agent_search_layout'];
    }
}
$fetch_output = '';
$layout_type = new propertya_get_agents();
while ($results->have_posts())
{
    $results->the_post();
    $property_id = get_the_ID();
    $function = "propertya_get_agents_$grid_type";
    $fetch_output .= $layout_type->$function($property_id);
}
wp_reset_postdata();