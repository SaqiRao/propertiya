<?php 
	$property_id	=	get_the_ID();
	$latt = '';
	$lon = '';
	$address = '';
	$response = array();
	$latt = get_post_meta($property_id, 'prop_latt', true );
	$lon = get_post_meta($property_id, 'prop_long', true );
	$address = get_post_meta($property_id, 'prop_street_addr', true );
	if(!empty(propertya_strings('prop_walk_api_key')) && !empty($latt) && !empty($lon))
	{
?>

<div class="widget-seprator">
    <div class="widget-seprator-heading">
         <h3 class="sec-title"><i class="fas fa-star"></i> <?php echo esc_html(propertya_strings('prop_walkscore')); ?></h3>
             <div class="yelp-powered-by ">
                <div class="yelp-powered"><?php echo esc_html__('Powered by','propertya'); ?></div>
                <div class="walk-logo"></div>
             </div>
    </div> 
    	<?php $response = propertya_framework_getwalkscore($property_id, $latt,$lon,$address);
		if(!empty($response) && $response->status == 1)
		{
		?>
        <div class="walkscore-container">
            <div class="walkscore-score-div">
                <div> <strong><?php echo esc_html($response->walkscore); ?></strong> </div>  
            </div>
            <div class="walscore-details">
                <a href="<?php echo esc_url($response->ws_link); ?>" class="walscore-title">
                    <?php echo esc_html__('Walk Scores','propertya'); ?>
                </a>
                <span class="walkscore-desc">
                   <?php echo esc_html($response->description); ?>
                </span>							 		 
            </div>						 
            <a href="<?php echo esc_url($response->ws_link); ?>" class="btn btn-sm btn-label-brand btn-bold"><?php echo esc_html__('View More details','propertya'); ?></a>						 
        </div>
        <?php
		}
		else
		{
			echo propertya_framework_getwalkscore_exceptions($response->status);
		}
		?>    
</div>
<?php
	}
 