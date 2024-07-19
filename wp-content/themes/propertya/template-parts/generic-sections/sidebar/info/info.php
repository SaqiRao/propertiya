<?php 
	$single_id   =	get_the_ID();
	$reference = 'agency';
	if(is_singular('property-agency'))
	{
		$reference = 'agency';
	}
	if(is_singular('property-agents'))
	{
		$reference = 'agent';
	}
	if(is_singular('property-buyers'))
	{
		$reference = 'buyer';
	}
	$hours = $url = $tax = $licence = $fax = $whats = $email = $long =  $latt = '';
	$latt = get_post_meta($single_id, $reference.'_latt', true );
	$long = get_post_meta($single_id, $reference.'_long', true );
	$email = get_post_meta($single_id, $reference.'_email', true );
	$office = get_post_meta($single_id, $reference.'_office', true );
	$whats = get_post_meta($single_id, $reference.'_whats', true );
	$fax = get_post_meta($single_id, $reference.'_fax', true );
	$licence = get_post_meta($single_id, $reference.'_licence', true );
	$tax = get_post_meta($single_id, $reference.'_tax', true );
	$url = get_post_meta($single_id, $reference.'_url', true );
	$hours = get_post_meta($single_id, $reference.'_hours', true );
	global $localization;
?>
<div class="sidebar-widget-seprator single-ag-auth-contact">
                 <div class="sidebar-widget-header">
      				<h4><?php echo propertya_strings('prop_detail_sidebar_info'); ?></h4>
    			</div>
            <div class="sidebar-widget-body no-padding">
                <div class="listing-owner-wrapper">
                    <?php
					if(!empty($latt) && !empty($long) && propertya_strings('property_opt_enable_map') == '1') { ?>
                    <div id="detail_map_single"></div>
                    <?php } ?>  
                    </div>
                <div class="inside-custom-padding">   
                <?php echo propertya_framework_themesocial_shares($single_id,$reference); ?>
                   <ul class="widget-inner-container">
                   <?php if(!empty($hours)) { ?>
                     <li data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr($localization['working_hours']); ?>">
                      <div class="widget-inner-elements">
                        <div class="widget-inner-icon"> <i class="fas fa-business-time"></i> </div>
                        <div class="widget-inner-text"> <?php echo esc_html($hours); ?> </div>
                      </div>
                    </li>
                    <?php } ?>
                    <?php if(!empty($whats)) { ?>
                     <li data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr($localization['my_whatsapp']); ?>">
                      <div class="widget-inner-elements">
                        <div class="widget-inner-icon"> <i class="fab fa-whatsapp"></i> </div>
                        <div class="widget-inner-text"> <?php echo esc_html($whats); ?> </div>
                      </div>
                    </li>
                    <?php } ?>
                    <?php if(!empty($office)) { ?>
                     <li data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr($localization['my_office']); ?>">
                      <div class="widget-inner-elements">
                        <div class="widget-inner-icon"> <i class="fas fa-phone-alt"></i> </div>
                        <div class="widget-inner-text"> <?php echo esc_html($office); ?> </div>
                      </div>
                    </li>
                    <?php } ?>
                    <?php if(!empty($email)) { ?>
                     <li data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr($localization['email']); ?>">
                      <div class="widget-inner-elements">
                        <div class="widget-inner-icon"> <i class="fas fa-at"></i> </div>
                        <div class="widget-inner-text"> <?php echo sanitize_email($email); ?> </div>
                      </div>
                    </li>
                    <?php } ?>
                    <?php if(!empty($fax)) { ?>
                     <li data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr($localization['my_fax']); ?>">
                      <div class="widget-inner-elements">
                        <div class="widget-inner-icon"> <i class="fas fa-fax"></i> </div>
                        <div class="widget-inner-text"> <?php echo esc_html($fax); ?> </div>
                      </div>
                    </li>
                    <?php } ?>
                    <?php if(!empty($licence)) { ?>
                    <li data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr($localization['my_agency_lic']); ?>">
                      <div class="widget-inner-elements">
                        <div class="widget-inner-icon"> <i class="fas fa-lock"></i> </div>
                        <div class="widget-inner-text"> <?php echo esc_html($licence); ?> </div>
                      </div>
                    </li>
                    <?php } ?>
                    <?php if(!empty($tax)) { ?>
                     <li data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr($localization['my_taxno']); ?>">
                      <div class="widget-inner-elements">
                        <div class="widget-inner-icon"> <i class="fas fa-shield-alt"></i> </div>
                        <div class="widget-inner-text"> <?php echo esc_html($tax); ?> </div>
                      </div>
                    </li>
                    <?php } ?>
                    <?php if(!empty($url)) { ?>
                    <li data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr($localization['my_weburl']); ?>">
                      <div class="widget-inner-elements">
                        <div class="widget-inner-icon"> <i class="fas fa-external-link-alt"></i> </div>
                        <div class="widget-inner-text"> <a href="<?php echo esc_url($url); ?>" target="_blank"><?php echo esc_html__('View Website','propertya'); ?></a> </div>
                      </div>
                    </li>
                    <?php } ?> 
             </ul>
            <img alt="" src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?php echo esc_url(get_permalink($single_id)); ?>%2F&choe=UTF-8" title="<?php echo esc_attr(get_the_title($single_id)); ?>" />
              <div class="viewmore-button">
        		<a class="btn btn-outline btn-block" href="https://www.google.com/maps?daddr=<?php echo esc_attr($latt); ?>,<?php echo esc_attr($long); ?>" target="_blank"><?php echo esc_html($localization['get_directions']); ?></a>
    </div>     
                </div>
            </div>
        </div>