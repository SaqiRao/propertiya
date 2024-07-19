<?php if(!empty(get_the_content())) { ?>
<div class="widget-seprator" id="p-overview">
	<?php if(!empty( propertya_strings('prop_settings_detail_sections_detail'))) { ?>
    <div class="widget-seprator-heading">
         <h3 class="sec-title"><?php echo propertya_strings('prop_settings_detail_sections_detail'); ?></h3>
    <?php } ?>     
    </div>     
    <div class="post-excerpt post-desc">
        <?php the_content(); ?>  
    </div>
</div>
<?php } ?>