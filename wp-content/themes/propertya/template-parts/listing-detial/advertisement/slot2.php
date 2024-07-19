<?php 
global $propertya_options; 
//Ad slots
if( isset( $propertya_options['prop_listing_slot_2'] ) && $propertya_options['prop_listing_slot_2'] != "")
{
?>
	<div class="banner-lists">
		<?php echo ' '.$propertya_options['prop_listing_slot_2']; ?>
	</div>
	<div class="clearfix"></div>
<?php
}