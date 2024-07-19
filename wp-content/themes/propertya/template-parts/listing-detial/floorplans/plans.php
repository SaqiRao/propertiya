<?php 
	$property_id	=	get_the_ID();
	if(get_post_meta( $property_id, 'prop_is_plans', true ) !="" && get_post_meta( $property_id, 'prop_is_plans', true ) == 'enabled')
	{
		$selected_floor_plans = '';
		$selected_floor_plans = get_post_meta($property_id, 'prop_floor_plans', true );
?>
<div class="widget-seprator prop-floor-plans">
          <div class="widget-seprator-heading">
             <h3 class="sec-title"><i class="fal fa-bed-alt"></i> <?php echo esc_html(propertya_strings('prop_flrplans')); ?></h3>
          </div>
          <?php 
		  	$floor_plan_data = '';
			$floor_plan_data = json_decode( stripslashes( $selected_floor_plans) );
			if(!empty($floor_plan_data) && is_array($floor_plan_data) && count($floor_plan_data) > 0)
			{
		  ?> 
          <ul class="floor-plan">
			  <?php
              foreach($floor_plan_data as $plan)
              {
               ?>
                <li class="my-floor-plans">
                  <div class="floor-plan-title">
                  <strong><?php echo esc_html($plan->prop_floor_name); ?></strong>
                    <ul class="list-unstyled floor">
                      <li class="list-inline-item"><?php echo esc_html__('Rooms','propertya'); ?>: <span><strong><?php echo esc_html($plan->prop_floor_beds); ?></strong></span></li>
                      <li class="list-inline-item"><?php echo esc_html__('Bath','propertya'); ?>: <span><strong><?php echo esc_html($plan->prop_floor_baths); ?></strong></span></li>
                      <li class="list-inline-item"><?php echo esc_html__('Size','propertya'); ?>: <span><strong><?php echo esc_html($plan->prop_floor_size). ' '.esc_html($plan->prop_floor_sprefix); ?></strong></span></li>
                    </ul>
                    </div>
                    
                  <div class="floor-plan-content p-4">
                  <?php
				 $fullthumb = $img_url = $thumb = $plan_img_id = '';
				  if(!empty($plan->prop_floor_img_id))
				  {
                      if(wp_attachment_is_image($plan->prop_floor_img_id))
                      {

					   $plan_img_id = $plan->prop_floor_img_id;
					   $thumb = wp_get_attachment_image_src($plan_img_id, 'medium_large');
					   $fullthumb = wp_get_attachment_image_src($plan_img_id, 'full');
					   $img_url = $thumb[0];
				  ?>
                  <a href="<?php echo esc_url($fullthumb[0]); ?>" data-fancybox="images-single">	  
                   <img src="<?php echo esc_url($img_url); ?>" class="img-fluid img-full" alt="<?php echo esc_attr(get_post_meta($plan_img_id, '_wp_attachment_image_alt', TRUE)); ?>"/>
                   </a>
                   <?php 
                      }
                  } 
                      ?>
                   <?php 
				   if($plan->prop_floor_price !="") { ?>
                   <div class="flr-price-sec">
                   	<?php echo esc_html__('Price','propertya'); ?>:<strong><?php echo esc_html($plan->prop_floor_price). ' '.esc_html($plan->prop_floor_pprefix); ?></strong>
                   </div>
                   <?php } ?>
                   <p><?php echo esc_textarea($plan->prop_floor_desc); ?></p>
                  </div>
                </li>
              <?php
              }
              ?>
          </ul>
          <?php
			}
		  ?>
</div>
<?php
	}