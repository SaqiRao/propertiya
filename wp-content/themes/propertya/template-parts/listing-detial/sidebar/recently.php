<?php
	$property_id	=	get_the_ID();
	$args = array(
		'post_type' => 'property',
		'post_status' => 'publish',
		'post__not_in' => array($property_id),
		'posts_per_page' => 3,
        //'fields' => 'ids',
		'order' => 'DESC',
		'orderby' => 'date',
		'meta_query' => array(
			 array(
				'key' => 'prop_status',
				'value' => '1',
				'compare' => '='
			 )
		 ),
	 );
	 $query = new WP_Query( $args );
	 if($query->have_posts())
	 {
		 $listingz = new propertya_getlistings();
	 ?>
        <div class="sidebar-widget-seprator">
            <div class="sidebar-widget-header">
              <h4><?php echo esc_html(propertya_strings('prop_sidebar_recently')); ?></h4>
            </div>
            <div class="sidebar-widget-body">
                    <ul class="widget-inner-container recently-added">
                    <?php    
					  while ($query->have_posts())
					  {
						   $query->the_post();
						   $property_id = get_the_ID();
						   $listingz->propertya_listings_recently($property_id); 
					  }
					  wp_reset_postdata();
					  ?>
                  </ul>
            </div>
        </div>
<?php
	 }