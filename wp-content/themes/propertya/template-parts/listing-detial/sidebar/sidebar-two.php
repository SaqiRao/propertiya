<?php
	$property_id	=	get_the_ID();
	global $propertya_options;
	$layout = '';
?>
<div class="single-sidebar">
<?php
$layout = $propertya_options['prop_listingsidebar']['enabled'];
if ($layout): foreach ($layout as $key => $value)
{
	
	switch ($key)
	{
		case 'address': get_template_part('template-parts/listing-detial/sidebar/address');
		break;

		case 'stats': get_template_part('template-parts/listing-detial/sidebar/stats');
			break;

		case 'featured': get_template_part('template-parts/listing-detial/sidebar/featured');
			break;

		case 'nearby': get_template_part('template-parts/listing-detial/sidebar/nearby');
			break;

		case 'slot1': get_template_part('template-parts/listing-detial/sidebar/advertizment1');
			break;

		case 'recently': get_template_part('template-parts/listing-detial/sidebar/recently');
			break; 
			
		case 'slot2': get_template_part('template-parts/listing-detial/sidebar/advertizment2');
			break;
			
		case 'calculator': get_template_part('template-parts/listing-detial/sidebar/calculator');
			break;	
	}
}
endif;
?>			
</div>