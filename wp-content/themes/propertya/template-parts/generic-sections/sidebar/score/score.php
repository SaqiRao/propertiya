<?php 
	$single_id   =	get_the_ID();
	$reference = 'agency';
	$type = 'property-agency';
	if(is_singular('property-agency'))
	{
		$type = 'property-agency';
		$reference = 'agency';
	}
	if(is_singular('property-agents'))
	{
		$type = 'property-agents';
		$reference = 'agent';
	}
	if(is_singular('property-buyers'))
	{
		$type = 'property-buyers';
		$reference = 'buyer';
	}
	$allowed_html = propertya_allowed_html();
	$ratings = array();
	$ratings = propertya_reviews_stats_average($single_id,$type,$reference);
	$recommendations = $fourth_bar = $third_bar = $sec_bar   = $firs_bar = '';
	if(!empty($ratings) && is_array($ratings) && $ratings['rated_no_of_times'] > 0)
	{
		$firs_bar = 	round($ratings['average_responsive']*100/5);
		$sec_bar   = 	round($ratings['average_communication']*100/5);
		$third_bar = 	round($ratings['average_expertise']*100/5);
		$fourth_bar = 	round($ratings['average_service']*100/5);
		$recommendations = round($ratings['total_recommendations']*100/$ratings['rated_no_of_times']);
?>
<div class="sidebar-widget-seprator single-review-stats">
    <div class="sidebar-widget-header">
      <h4>
	  <?php echo esc_html($ratings['rated_no_of_times']) . '&nbsp;'. esc_html(propertya_strings('prop_detail_sidebar_reviews')); ?>
	 </h4>
    </div>
    <div class="sidebar-widget-body">
      <div class="widget-inner-container">
      <div class="text-center">
                    <div class="d-inline align-baseline display-2"><?php echo esc_html($ratings['total_average']); ?><span class="full-rating">/5</span></div>
                    <div class="align-baselines">
                    <span class="ratings"><?php echo wp_kses($ratings['total_stars'],$allowed_html) ; ?></span>
                    </div>
                </div>
                <div class="pt-3"> <label class="text-medium text-sm"><?php echo propertya_strings('prop_ag_rev_first'); ?> </label><span class="review-count-stats"><?php echo esc_html($ratings['average_responsive']); ?></span>
                    <div class="progress margin-bottom-1x">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo esc_attr($firs_bar); ?>%;" aria-valuenow="<?php echo esc_attr($firs_bar); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div> <label class="text-medium text-sm"><?php echo propertya_strings('prop_ag_rev_second'); ?></label><span class="review-count-stats"><?php echo esc_html($ratings['average_communication']); ?></span>
                    <div class="progress margin-bottom-1x">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo esc_attr($sec_bar); ?>%;" aria-valuenow="<?php echo esc_attr($sec_bar); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div> <label class="text-medium text-sm"><?php echo propertya_strings('prop_ag_rev_third'); ?></label> <span class="review-count-stats"><?php echo esc_html($ratings['average_expertise']); ?></span>
                    <div class="progress margin-bottom-1x">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo esc_attr($third_bar); ?>%;" aria-valuenow="<?php echo esc_attr($third_bar); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div> <label class="text-medium text-sm"><?php echo propertya_strings('prop_ag_rev_fourth'); ?></label> <span class="review-count-stats"><?php echo esc_html($ratings['average_service']); ?></span>
                    <div class="progress margin-bottom-1x">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo esc_attr($fourth_bar); ?>%;" aria-valuenow="<?php echo esc_attr($fourth_bar); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div> <label class="text-medium text-sm"><?php echo esc_html__('Recommendations','propertya'); ?></label> <span class="review-count-stats"><?php echo esc_html($ratings['total_recommendations']); ?></span>
                    <div class="progress mb-2">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo esc_attr($recommendations); ?>%;" aria-valuenow="<?php echo esc_attr($recommendations); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <div class="pt-2">
                <div class="viewmore-button">
        		<a class="btn btn-outline btn-block" href="http://localhost/real-estate/agencies/muhammad-umair-2/"><?php echo wp_sprintf(esc_html__('View All %s', 'propertya'), propertya_strings('prop_detail_sidebar_reviews')); ?></a>
    </div>
                </div>
      </div>
    </div>
</div>
<?php
	}
	
	