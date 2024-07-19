<?php 
	$property_id	=	get_the_ID();
	$selected_attachments = array();
	if(get_post_meta( $property_id, 'prop_attachments', true ) !="")
	{
		$selected_attachments = get_post_meta( $property_id, 'prop_attachments', true );
?>
<div class="widget-seprator">
    <div class="widget-seprator-heading">
         <h3 class="sec-title"><i class="fas fa-folder-open"></i> <?php echo esc_html(propertya_strings('prop_attachs')); ?></h3>
    </div> 
   <?php echo propertya_framework_get_detail_attachments($selected_attachments);?> 	
</div>
<?php
}