<?php
	$property_id	=	get_the_ID();
	global $localization;
	$allowed_html = propertya_allowed_html();
	//to get user type
	$badge_html = $ang_status = $badge_txt =  $badge_clr = $auth_status = $image_id = $post_author_id = $type = '';
	$post_author_id = get_post_field('post_author', $property_id);
	if(get_user_meta($post_author_id, 'user_role_type', true) !="")
	{
		$posted_id = get_user_meta($post_author_id, 'prop_post_id' , true );
		$type = get_user_meta($post_author_id, 'user_role_type', true);	
		if( empty($fb) ) $fb = '';
		if( empty($tw) ) $tw = '';
		if( empty($in) ) $in = '';
		if( empty($insta) ) $insta = '';
		if( empty($you) ) $you = '';
		if( empty($you) ) $pin = '';
		if($type == 'agency' || $type == 'agent' || $type == 'buyer')
		{
			$fb = get_post_meta($posted_id, $type.'_fb', true );
			$tw = get_post_meta($posted_id, $type.'_tw', true );
			$in = get_post_meta($posted_id, $type.'_in', true );
			$insta = get_post_meta($posted_id, $type.'_insta', true );
			$you = get_post_meta($posted_id, $type.'_you', true );
			$pin = get_post_meta($posted_id, $type.'_pin', true );
		}
	if(get_post_meta($posted_id, 'agency_badge_txt', true ) !="" && get_post_meta($posted_id, 'agency_badge_clr', true )!="")
	{
		$badge_txt = get_post_meta($posted_id, 'agency_badge_txt', true );
		$badge_clr = get_post_meta($posted_id, 'agency_badge_clr', true );
		$auth_status = '<span class="badge badge-verified" style="background-color:'.$badge_clr.'">'. esc_html($badge_txt).'</span>';
	}
	if(get_post_meta($posted_id, 'agency_is_featured', true ) =="1")
	{
		$ang_status = '<div class="is_agen_featured"><button class="btn" type="button" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr__('Featured','propertya').'"><i class="fas fa-fire"></i></button></div>';
	}
	$ratings = array();
	if(isset($type) && $type == "agency")
	{
		$reference = 'agency';
		$post_type = 'property-agency';
	}
	if(isset($type) && $type == "agent")
	{
		$reference = 'agent';
		$post_type = 'property-agents';
	}
	if(isset($type) && $type == "buyer")
	{
		$reference = 'buyer';
		$post_type = 'property-buyers';
	}
	$badge_limit = ''; 
	$badge_limit = propertya_strings('prop_ag_recommended_badge');
	$ratings = propertya_reviews_stats_average($posted_id,$post_type,$reference);
	if(!empty($ratings) && is_array($ratings) && !empty($badge_limit) && $ratings['rated_no_of_times'] >= $badge_limit)
	{
		$badge_html = '<div class="is_agen_recommended"><button class="btn" type="button" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr__('Most Recommended','propertya').'"><i class="fas fa-thumbs-up"></i></button></div>';
	}
?>
<div class="">
        <div class="sidebar-widget-body">
            <div class="listing-owner-wrapper">
                <div class="listing-owner-avatar">
                    <?php echo wp_kses($ang_status,$allowed_html) ; ?>
                    <?php echo wp_kses($badge_html,$allowed_html) ; ?>
                    <a href="<?php echo esc_url(get_the_permalink($posted_id)); ?>"><img src="<?php echo esc_url(propertya_placeholder_images($type,$posted_id,'full')); ?>" class="img-fluid mx-auto d-block" alt="<?php echo esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', TRUE)); ?>"></a>
                </div>
                	<div class="listing-owner-content">
                     <?php if(!empty($ratings) && is_array($ratings) && $ratings['rated_no_of_times'] > 0) { ?>
                     	<span class="ratings"> <?php echo wp_kses($ratings['total_stars'],$allowed_html) ; ?><span class="rating-counter"> (<?php echo esc_html($ratings['total_average']); ?>)</span></span>
                     <?php } ?>
                        <h4><a href="<?php echo esc_url(get_the_permalink($posted_id)); ?>"><?php echo get_the_title($posted_id); ?></a></h4>
                        <span class="review_time"><?php echo esc_html($localization['member_since']); ?>: <?php echo propertya_user_timeago($post_author_id); ?> </span>
                         <?php 
							echo wp_kses($auth_status,$allowed_html);
						 ?>
                    </div>
                </div>
            <?php if(!empty($fb) || !empty($tw) || !empty($in) || !empty($insta) || !empty($you) || !empty($pin))
			{
			?>	    
            <ul class="listing-owner-social">
            	<?php if(!empty($fb)) { ?><li><a href="<?php echo esc_url($fb); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a></li><?php } ?>
                <?php if(!empty($tw)) { ?><li><a href="<?php echo esc_url($tw); ?>" target="_blank"><i class="fab fa-twitter"></i></a></li><?php } ?>
                <?php if(!empty($in)) { ?><li><a href="<?php echo esc_url($in); ?>" target="_blank"><i class="fab fa-linkedin"></i></a></li><?php } ?>
                <?php if(!empty($insta)) { ?><li><a href="<?php echo esc_url($insta); ?>" target="_blank"><i class="fab fa-dribbble"></i></a></li><?php } ?>
                <?php if(!empty($you)) { ?><li><a href="<?php echo esc_url($you); ?>" target="_blank"><i class="fab fa-youtube"></i></a></li><?php } ?>
                <?php if(!empty($pin)) { ?><li><a href="<?php echo esc_url($pin); ?>" target="_blank"><i class="fab fa-pinterest-p"></i></a></li><?php } ?>
            </ul>
            <?php 
			}
			?>
            <ul class="widget-inner-container">
            	<?php if(get_post_meta($posted_id, $type.'_street_addr', true ) !="") { ?>
                <li>
                  <div class="widget-inner-elements">
                    <div class="widget-inner-icon"> <i class="fas fa-location-arrow"></i> </div>
                    <div class="widget-inner-text"> <?php echo esc_html(get_post_meta($posted_id,  $type.'_street_addr', true )); ?> </div>
                  </div>
            	</li>
                <?php } 
				if(get_post_meta($posted_id, $type.'_mobile', true ) !="") { ?>
                <li>
                  <div class="widget-inner-elements">
                    <div class="widget-inner-icon"><i class="fas fa-phone-alt"></i> </div>
                    <div class="widget-inner-text">
					<a class="click-reveal phonenumber" href="tel:<?php echo esc_html(get_post_meta($posted_id, $type.'_mobile', true )); ?>" data-listing-id="<?php echo esc_attr($property_id); ?>" data-reaction="contact"><?php echo esc_html(get_post_meta($posted_id, $type.'_mobile', true )); ?></a>
                  </div>
                  </div>
            	</li>
                <?php }
				if(get_post_meta($posted_id, $type.'_email', true )!="")
				{
				 ?>
                <li>
                  <div class="widget-inner-elements">
                    <div class="widget-inner-icon"> <i class="fas fa-at"></i> </div>
                    <div class="widget-inner-text" data-reaction="email" data-listing-id="<?php echo esc_attr($property_id); ?>"> <?php echo esc_html(get_post_meta($posted_id, $type.'_email', true )); ?> </div>
                  </div>
            	</li>
                <?php }
				if(get_post_meta($posted_id, $type.'_url', true )!="")
				{
				?>
                <li>
                  <div class="widget-inner-elements">
                    <div class="widget-inner-icon"> <i class="fas fa-external-link-square-alt"></i> </div>
                    <div class="widget-inner-text" > <a data-reaction="web" data-listing-id="<?php echo esc_attr($property_id); ?>" href="<?php echo esc_url(get_post_meta($posted_id, $type.'_url', true )); ?>" target="_blank"><?php echo esc_html__('View Website','propertya'); ?></a> </div> 
                  </div>
            	</li>
                <?php } ?>
            </ul>
            <div class="viewmore-button">
        		<a class="btn btn-outline btn-block" href="<?php echo esc_url(get_post_permalink($posted_id)); ?>"><?php echo esc_html__('View More','propertya'); ?></a>
    </div>
    
        </div>
        
    </div>
<?php
	}