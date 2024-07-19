<?php 
	$single_id   =	get_the_ID();
	$user_id = get_post_field('post_author', $single_id);
	$args = array(
		'post_type' => 'property',
		'post_status' => 'publish',
		'posts_per_page' => 4,
		'meta_key' => 'prop_listing_total_views',
		'orderby' => 'meta_value_num',
		'order' => 'DESC',
        //'fields' => 'ids',
		'author' => $user_id,
	 );
	 $query = new WP_Query($args);
	 if($query->have_posts())
	 {
		
		 $listingz = new propertya_getlistings();
	 ?>
        <div class="sidebar-widget-seprator most-single-viewed">
                    <div class="sidebar-widget-header">
                      <h4><?php echo propertya_strings('prop_detail_sidebar_mview'); ?></h4>
                    </div>
                    <div class="sidebar-widget-body">
                            <ul class="widget-inner-container recently-added">
                            <?php    
							  while ($query->have_posts())
							  {
								 $query->the_post();
						  		 $property_id = get_the_ID();
								 $listingz->propertya_listings_most_viewed($property_id);  
							  }
							  wp_reset_postdata();
						    ?>
                            </ul>
                    </div>
                </div>
	 <?php
	 }