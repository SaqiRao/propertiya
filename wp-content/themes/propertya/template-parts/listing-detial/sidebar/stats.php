<?php
	$property_id	=	get_the_ID();
	global $localization;
	$get_percentage = array(); 
	$get_percentage = propertya_reviews_average($property_id);
?>
<div class="sidebar-widget-seprator stats-previews">
    <div class="sidebar-widget-header">
      <h4><?php echo esc_html(propertya_strings('prop_sidebar_stats')); ?></h4>
    </div>
    <div class="sidebar-widget-body">
      <ul class="widget-inner-container prop-statistics">
      	<?php if(intval(get_post_meta($property_id, 'prop_listing_total_views', true) !="")) {?>
        <li>
          <div class="widget-inner-elements">
            <div class="widget-inner-icon"> <i class="far fa-eye"></i> </div>
            <div class="widget-inner-text"><?php echo wp_sprintf(esc_html__('%s Views', 'propertya'), number_format(get_post_meta($property_id, 'prop_listing_total_views', true))); ?></div>
          </div>
        </li>
        <?php } ?>
        <li>
          <div class="widget-inner-elements">
            <div class="widget-inner-icon"> <i class="far fa-star"></i> </div>
            <div class="widget-inner-text">
             <?php 
			 if(!empty($get_percentage) && is_array($get_percentage) && count($get_percentage['ratings']) > 0)
			 {
			 	echo wp_sprintf(esc_html__('%s Rating', 'propertya'), $get_percentage['average']); 
			 }
			 else
			 {
				 echo wp_sprintf(esc_html__('%s Rating', 'propertya'), 0); 
			 }
			?>
             </div>
         </div>
        </li>
        <li>
          <div class="widget-inner-elements">
            <div class="widget-inner-icon"> <i class="far fa-bookmark"></i> </div>
            <div class="widget-inner-text"> 
			<?php 
			if(intval(get_post_meta($property_id, 'prop_bookmarks_counter', true) !="")) {
			echo wp_sprintf(esc_html__('%s Favorites', 'propertya'), number_format(get_post_meta($property_id, 'prop_bookmarks_counter', true)));
			}
			else
			{
				echo wp_sprintf(esc_html__('%s Favorites', 'propertya'),0);
			}
			?> 
            </div>
          </div>
        </li>
        <li>
          <div class="widget-inner-elements">
            <div class="widget-inner-icon"> <i class="fas fa-share"></i> </div>
            <div class="widget-inner-text"> 0 Share </div>
          </div>
        </li>
        <li>
          <div class="widget-inner-elements">
            <div class="widget-inner-icon"> <i class="far fa-comment-dots"></i> </div>
            <div class="widget-inner-text">
            <?php 
			 if(!empty($get_percentage) && is_array($get_percentage) && count($get_percentage['ratings']) > 0)
			 {
			 	echo wp_sprintf(esc_html__('%s Comments', 'propertya'), $get_percentage['rated_no_of_times']); 
			 }
			 else
			 {
				 echo wp_sprintf(esc_html__('%s Comments', 'propertya'), 0); 
			 }
			?>
             </div>
          </div>
        </li>
        <li>
          <div class="widget-inner-elements"> 
            <div class="widget-inner-icon"> <i class="far fa-thumbs-up"></i> </div>
            <div class="widget-inner-text"> 
			<?php 
			if(intval(get_post_meta($property_id, 'prop_totallikes', true) !="")) {
			echo wp_sprintf(esc_html__('%s Likes', 'propertya'), number_format(get_post_meta($property_id, 'prop_totallikes', true)));
			}
			else
			{
				echo wp_sprintf(esc_html__('%s Likes', 'propertya'),0);
			}
			?> 
            </div>
          </div>
        </li>
        <li>
          <div class="widget-inner-elements"> 
            <div class="widget-inner-icon"> <i class="far fa-heart"></i> </div>
            <div class="widget-inner-text"> 
			<?php 
			if(intval(get_post_meta($property_id, 'prop_totalloves', true) !="")) {
			echo wp_sprintf(esc_html__('%s Love', 'propertya'), number_format(get_post_meta($property_id, 'prop_totalloves', true)));
			}
			else
			{
				echo wp_sprintf(esc_html__('%s Love', 'propertya'),0);
			}
			?> 
            </div>
          </div>
        </li>
        <li>
          <div class="widget-inner-elements"> 
            <div class="widget-inner-icon"> <i class="far fa-thumbs-down"></i> </div>
            <div class="widget-inner-text"> 
			<?php 
			if(intval(get_post_meta($property_id, 'review_dislike', true) !="")) {
			echo wp_sprintf(esc_html__('%s Dislike', 'propertya'), number_format(get_post_meta($property_id, 'review_dislike', true)));
			}
			else
			{
				echo wp_sprintf(esc_html__('%s Dislike', 'propertya'),0);
			}
			?> 
            </div>
          </div>
        </li>
      </ul>
    </div>
</div>

