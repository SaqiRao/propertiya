<?php
	$property_id	=	get_the_ID();
	$user_id = get_post_field('post_author', $property_id);
	$args = array(
		'post_type' => 'property',
		'post_status' => 'publish',
		'posts_per_page' => 5,
		'author' => $user_id,
        //'fields' => 'ids',
		'order' => 'DESC',
		'orderby' => 'date',
		'meta_query' => array(
			 array(
				'key' => 'prop_is_regular_listing',
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
          <h4><?php echo propertya_strings('prop_detail_sidebar_featured'); ?></h4>
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

<?php
// $args = array(
// 		'post_type' => 'property',
// 		'post_status' => 'publish',
// 		'posts_per_page' => 5,
// 		'author' => $user_id,
//         //'fields' => 'ids',
// 		'order' => 'DESC',
// 		'orderby' => 'date',
// 		'meta_query' => array(
// 			 array(
// 				'key' => 'prop_is_feature_listing',
// 				'value' => '1',
// 				'compare' => '='
//     		 ),
    		 
// 			 array(
// 				'key' => 'prop_status',
// 				'value' => '1',
// 				'compare' => '='
//     		 )
//    		 ),
// 	 );	