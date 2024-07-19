<?php 
$property_id	=	get_the_ID();
if(get_post_meta($property_id, 'prop_virtual_tour', true ) !="")
{ ?>
    <div class="widget-seprator clearfix">
	   <div class="widget-seprator-heading">
         <h3 class="sec-title"><i class="fas fa-cube"></i> <?php echo esc_html(propertya_strings('prop_360')); ?></h3>
        </div>     
     <?php
		echo get_post_meta($property_id, 'prop_virtual_tour', true);
	 ?>
</div>
<?php } ?>