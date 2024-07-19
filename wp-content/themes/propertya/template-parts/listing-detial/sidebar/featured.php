<?php

	$property_id	=	get_the_ID();
	$args = array(
		'post_type' => 'property',
		'post_status' => 'publish',
		'post__not_in' => array($property_id),
		'posts_per_page' => 5,
        //'fields' => 'ids',
		'order' => 'DESC',
		'orderby' => 'date',
		'meta_query' => array(
			 array(
				'key' => 'prop_is_feature_listing',
				'value' => '1',
				'compare' => '='
    		 ),
			 array(
				'key' => 'prop_status',
				'value' => '1',
				'compare' => '='
    		 )
   		 ),
	 );
?>
<div class="sidebar-widget-seprator">
        <div class="sidebar-widget-header">
          <h4><?php echo esc_html(propertya_strings('prop_sidebar_featured')); ?></h4>
        </div>
    <div class="sidebar-widget-body">
            <div class="widget-inner-container">
            	<?php
					$listingz = new propertya_getlistings();
					echo ''.$listingz->propertya_listings_single_featuredslider($args,'grid1');
				?>
                </div>	
            </div>       
</div>