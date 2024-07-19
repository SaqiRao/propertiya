<?php 
	$property_id	=	get_the_ID();
	//additional fields
	$selected_fields_data = $selected_fields = '';
	if(get_post_meta( $property_id, 'prop_is_additional_fields', true ) !="" && get_post_meta( $property_id, 'prop_is_additional_fields', true ) == 'enabled')
	{
		$selected_fields = get_post_meta( $property_id, 'prop_is_additional_fields', true );
		$selected_fields_data = get_post_meta( $property_id, 'prop_add_fields', true );
		$fadd_fields_data = '';
        $fadd_fields_data = json_decode(stripslashes($selected_fields_data));
		if(!empty($fadd_fields_data) && is_array($fadd_fields_data) && count($fadd_fields_data) > 0)
		{
?>
<div class="widget-seprator additional-detail">
	<div class="widget-seprator-heading">
		<h3 class="sec-title"><i class="fas fa-list-ol"></i><?php echo esc_html(propertya_strings('prop_additional_details')); ?></h3>
	</div>
    <div class="listing-specs">
        <div class="row">
        	<?php 
				foreach($fadd_fields_data as $fields)
                {
				?>
                    <div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 col-12">
                        <div class="detail-type"><strong><?php echo esc_html($fields->prop_add_key); ?></strong><?php echo esc_html($fields->prop_add_val); ?></div>
                    </div>
           <?php
				}
			?>
       </div>
   </div>
</div>
<?php
		}
	}