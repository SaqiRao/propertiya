<?php
if(propertya_strings('property_opt_enable_map') == '1')
{
	$property_id	=	get_the_ID();
	$latt = '';
	$lon = '';
	$address = '';
	$latt = get_post_meta($property_id, 'prop_latt', true );
	$lon = get_post_meta($property_id, 'prop_long', true );
	$address = get_post_meta($property_id, 'prop_street_addr', true );
	if(!empty($latt) && !empty($lon))
	{
?>
<div class="widget-seprator">
    <div class="widget-seprator-heading">
         <h3 class="sec-title"><i class="fas fa-location-arrow"></i> <?php echo esc_html(propertya_strings('prop_address')); ?></h3>
             <div class="yelp-powered-by ">
             	<a href="//www.google.com/maps?daddr=<?php echo esc_attr($latt);?>,<?php echo esc_attr($lon);?>" target="_blank">
                	<div class="yelp-powered"><?php echo esc_html__('Get Directions','propertya'); ?></div>
                </a>
             </div>
    </div> 
    <input type="hidden" name="single-lat" id="single-lat" value=<?php echo $latt ;?>>
     <input type="hidden" name="single-lng" id="single-lng" value=<?php echo $lon ;?>>
    <div id="property_map_single"></div>

 </div>
 <?php
	}
}
    