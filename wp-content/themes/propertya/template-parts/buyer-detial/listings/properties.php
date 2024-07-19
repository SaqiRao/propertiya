<?php
$propes = get_query_var('propsingle-propes');
if(!empty($propes) && is_array($propes) && count($propes) > 0) 
{
	 $listingz = new propertya_getlistings();
?>					 
	<div class="widget-seprator" id="p-listings">
    <?php if(!empty( propertya_strings('prop_settings_detail_listings'))) { ?>
		<div class="widget-seprator-heading">
			<h3 class="sec-title"><?php echo propertya_strings('prop_settings_detail_listings'); ?></h3>
		</div>
    <?php } ?>    
		<div class="agency-properties">
			<?php  
			foreach($propes as $props)
			{
				echo ''.$listingz->propertya_similiar_listings($props);
			}  
			?>
		</div>
	</div>
<?php
 }