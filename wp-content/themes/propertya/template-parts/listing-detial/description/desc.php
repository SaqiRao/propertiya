<?php 
	$property_id	=	get_the_ID();
?>
<div class="widget-seprator">
<div class="widget-seprator-heading">
     <h3 class="sec-title"><i class="fas fa-rss"></i> <?php echo esc_html(propertya_strings('prop_desc')); ?></h3>
</div>     
    <div class="post-excerpt post-desc">
		<?php the_content(); ?>
    </div>
    <?php echo propertya_framework_social_shares($property_id); ?>
</div>