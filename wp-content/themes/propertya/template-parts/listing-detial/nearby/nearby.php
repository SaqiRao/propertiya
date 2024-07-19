<?php if(!empty(propertya_strings('prop_yelp_api_key')) && !empty(propertya_strings('prop_yelp_api_secret')))
 {
	  $selected_long = $selected_latt ='';
	  $property_id	=	get_the_ID(); 
	  $selected_latt = get_post_meta($property_id, 'prop_latt', true );
	  $selected_long = get_post_meta($property_id, 'prop_long', true );
	  if(!empty($selected_latt) && !empty($selected_latt))
	  {
	   ?>
        <div class="widget-seprator nearby">
        	<div class="widget-seprator-heading">
             <h3 class="sec-title"><i class="fas fa-compass"></i> <?php echo esc_html(propertya_strings('prop_yelpnear')); ?></h3>
              <div class="yelp-powered-by ">
				<div class="yelp-powered"><?php echo esc_html__('Powered by','propertya'); ?></div>
                <div class="yelp-logo"></div>
             </div>
            </div> 
			<div class="yelp-data-container">
            	<?php echo propertya_get_yelp_data($property_id,$selected_latt,$selected_long); ?>
            </div>
      </div>      
<?php 
	  }
}