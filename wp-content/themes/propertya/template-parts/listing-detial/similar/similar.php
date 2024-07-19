<div class="widget-seprator similar-listings">
    <div class="widget-seprator-heading">
     	<h3 class="sec-title"><i class="fas fa-list-ol"></i> <?php echo esc_html(propertya_strings('prop_simi_listings')); ?></h3>
    </div> 
    <div class="my-similar-listings">
    	<?php 
			$property_id	=	get_the_ID();
			//get the taxonomy terms of custom post type
			$customTaxonomyTerms = array();
			$customTaxonomyTerms = wp_get_object_terms($property_id, 'property_type', array('fields' => 'ids'));
			if(!empty($customTaxonomyTerms ) && is_array($customTaxonomyTerms ) && count($customTaxonomyTerms ) > 0)
			{
				$no_off = 5;
				if(!empty(propertya_strings('prop_simi_listinglimits')))
				{
					$no_off = propertya_strings('prop_simi_listinglimits');
				}
				$listingz = new propertya_getlistings();
				$args = array(
					'post_type' => 'property',
					'post_status' => 'publish',
					'post__not_in' => array($property_id),
					'posts_per_page' => $no_off,
					'order' => 'DESC',
                    //'fields' => 'ids',
					'orderby' => 'date',
					'tax_query' => array(
						array(
							'taxonomy' => 'property_type',
							'field' => 'id',
							'terms' => $customTaxonomyTerms
						)
					),
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
					while ($query->have_posts())
					{
						$query->the_post();
						$property_id	=	get_the_ID();
						echo ' '. $listingz->propertya_similiar_listings($property_id);
					}
					wp_reset_postdata();
				}
			}
		?>
    </div>   
</div>