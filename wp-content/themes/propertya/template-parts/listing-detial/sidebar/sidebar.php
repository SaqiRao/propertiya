<?php
	$property_id	=	get_the_ID();
	global $propertya_options;
	$layout = '';
?>
<?php
$selected_pricelabel_after = $optional_price = '';
$get_all_prices =  propertya_framework_fetch_price($property_id);
if(!empty($get_all_prices) && is_array($get_all_prices) && count($get_all_prices) > 0 && array_key_exists("main_price",$get_all_prices))
 {
       if (array_key_exists("optional_price",$get_all_prices))
       {
           $optional_price = '<span>'.$get_all_prices['optional_price'].'</span>';
       }
       if (array_key_exists("after_prefix",$get_all_prices))
       {
           $selected_pricelabel_after = '<span class="clr-blu">'.$get_all_prices['after_prefix'].'</span>';
       }
	   $smal_top = '';
	   if(empty($optional_price) && empty($optional_price))
	   {
		  $smal_top = 'small-with-top'; 
	   }
	   echo '<div class="project-price service '.esc_attr($smal_top).'">
  <div class="card-body">
    <div class="row">
      <div class="col">
        <div class="price"><h3>'. esc_html($get_all_prices['main_price']) .'</h3> <span class="optional_price"> '.$optional_price .' ' . $selected_pricelabel_after.' </span></div>
      </div>
      <div class="feature"> <i class="fas fa-wallet"></i> </div>
    </div>
  </div>
</div>';
 }
?>
<div class="single-sidebar">
<?php
$layout = $propertya_options['prop_listingsidebar']['enabled'];
if ($layout): foreach ($layout as $key => $value)
{
	switch ($key)
	{
		case 'card': get_template_part('template-parts/listing-detial/sidebar/profile');
			break;
			
		case 'address': get_template_part('template-parts/listing-detial/sidebar/address');
		break;

		case 'stats': get_template_part('template-parts/listing-detial/sidebar/stats');
			break;

		case 'featured': get_template_part('template-parts/listing-detial/sidebar/featured');
			break;

		case 'contact': get_template_part('template-parts/listing-detial/sidebar/contact');
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