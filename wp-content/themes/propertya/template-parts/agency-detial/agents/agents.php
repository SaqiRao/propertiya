<?php
 $agents = get_query_var('propsingle-agents');
 if(!empty($agents) && is_array($agents) && count($agents) > 0) 
 {
	 $my_agents = new propertya_get_agents();
?>
<div class="widget-seprator" id="p-agents">
	<?php if(!empty( propertya_strings('prop_settings_detail_agents'))) { ?>
	 <div class="widget-seprator-heading">
		<h3 class="sec-title"><?php echo propertya_strings('prop_settings_detail_agents'); ?></h3>
	</div>
    <?php } ?>
	<div class="row">
	<?php   
	foreach($agents as $agent)
	{
		 echo ' '. $my_agents->propertya_get_agents_type1($agent, 2);
	}  
	?>
	</div>
 </div>
<?php
 }