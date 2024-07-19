<?php
global $localization;
global $messages;
global $propertya_options;
$user_id = get_current_user_id();
$type = $agent_id = '';
if(get_user_meta( $user_id, 'prop_post_id', true) !="" && get_user_meta($user_id, 'user_role_type', true) !="")
{
    $agent_id = get_user_meta( $user_id, 'prop_post_id' , true );
    $type = get_user_meta($user_id, 'user_role_type', true);
	$agent_email = get_post_meta($agent_id, 'agent_email', true );
	$agent_pos = get_post_meta( $agent_id, 'agent_pos', true );
	$agent_type = get_post_meta($agent_id, 'agent_type', true );
	$agent_mobile = get_post_meta($agent_id, 'agent_mobile', true );
	$agent_whats = get_post_meta($agent_id, 'agent_whats', true );
	$agent_office = get_post_meta($agent_id, 'agent_office', true );
	$agent_fax = get_post_meta($agent_id, 'agent_fax', true );
	$agent_url = get_post_meta($agent_id, 'agent_url', true );
	$agent_location = get_post_meta($agent_id, 'agent_location', true );
	$agent_skype = get_post_meta($agent_id, 'agent_skype', true );
	$agent_hours = get_post_meta($agent_id, 'agent_hours', true );
	$agent_fb = get_post_meta($agent_id, 'agent_fb', true );
	$agent_tw = get_post_meta($agent_id, 'agent_tw', true );
	$agent_in = get_post_meta($agent_id, 'agent_in', true );
	$agent_insta = get_post_meta($agent_id, 'agent_insta', true );
	$agent_you = get_post_meta($agent_id, 'agent_you', true );
	$agent_pin = get_post_meta($agent_id, 'agent_pin', true );
	$agent_street_addr = get_post_meta($agent_id, 'agent_street_addr', true );
	$agent_latt = get_post_meta($agent_id, 'agent_latt', true );
	$agent_long = get_post_meta($agent_id, 'agent_long', true );
	$agent_agency = get_post_meta($agent_id, 'agent_agent_id', true );
// Set default values.
if( empty($agent_email) ) $agent_email = '';
if( empty($agent_pos) ) $agent_pos = '';
if( empty($agent_type) ) $agent_type = '';
if( empty($agent_mobile) ) $agent_mobile = '';
if( empty($agent_whats) ) $agent_whats = '';
if( empty($agent_office) ) $agent_office = '';
if( empty($agent_fax) ) $agent_fax = '';
if( empty($agent_url) ) $agent_url = '';
if( empty($agent_location) ) $agent_location = '';
if( empty($agent_skype) ) $agent_skype = '';
if( empty($agent_hours) ) $agent_hours = '';
if( empty($agent_fb) ) $agent_fb = '';
if( empty($agent_tw) ) $agent_tw = '';
if( empty($agent_in) ) $agent_in = '';
if( empty($agent_insta) ) $agent_insta = '';
if( empty($agent_you) ) $agent_you = '';
if( empty($agent_pin) ) $agent_pin = '';
if( empty($agent_street_addr) ) $agent_street_addr = '';
if( empty($agent_agency) ) $agent_agency = '';
$location_icon = $check_class = $my_id = '';
if(propertya_strings('property_opt_enable_geo') == '1')
{
	if(propertya_strings('property_opt_api_settings') == 'geo_ip' ||  propertya_strings('property_opt_api_settings') == 'ip_api')
	{
		$check_class = 'get-loc';
		$location_icon = '<i class="detect-me fas fa-location-arrow"></i>';
	}
}
?>
<div class="row">
   	 <?php get_template_part( 'template-parts/dashboard/profile/info'); ?>
      <div class="col-lg-8 col-xl-8 col-md-8 col-sm-12">
         <div class="grid-margin">
         	<form class="my-form" name="agent_update" method="POST" id="agent_update">
            <div class="card">
               <div class="card-body">
                  <h4 class="card-title"><?php echo esc_html($localization['account_settings']); ?></h4>
                  <div class="row">
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['agent_name']); ?> <span class="req-mark">*</span></label>
                             <span class="wrap">
                             <input type="text" autocomplete="off" data-sanitize="trim" name="agent-name" class="form-control text" data-validation="required" data-validation-error-msg-required="<?php echo esc_attr($messages['name_error']); ?>" value="<?php echo esc_attr(get_the_title($agent_id)); ?>">
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['email']); ?> <span class="req-mark">*</span></label>
                             <span class="wrap">
                             <input type="text" data-validation="email" data-sanitize="trim" name="agent-email" placeholder="Messages from contact page will be sent on this email address." class="form-control text" data-validation-error-msg="<?php echo esc_attr($messages['email_error']); ?>" value="<?php echo esc_attr($agent_email); ?>">
                             </span> 
                          </div>
                      </div>
                      
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                     <label><?php echo esc_html($localization['agent_type']); ?><?php if($propertya_options['prop_agent_fields']['ag_type'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                     <span class="wrap">
                     <select class="theme-selects" data-sanitize="trim" name="agent-type" data-placeholder="<?php echo esc_attr__('Select Type','propertya');?>" <?php if($propertya_options['prop_agent_fields']['ag_type'] == 1) {  ?> data-validation="required" data-validation-error-msg="<?php echo esc_attr($messages['type_error']); ?>" <?php } ?>>
             			 <?php propertya_framework_terms_options('agent_types' , $agent_type); ?>
					</select>
                     </span> 
                  </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                     <label><?php echo esc_html($localization['agent_loc']); ?><?php if($propertya_options['prop_agent_fields']['ag_loc'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                     <span class="wrap">
                     <select class="theme-selects" data-sanitize="trim" name="agent-location" data-placeholder="<?php echo esc_attr__('Select Location','propertya');?>" <?php if($propertya_options['prop_agent_fields']['ag_loc'] == 1) {  ?> data-validation="required" data-validation-error-msg="<?php echo esc_attr($messages['loc_error']); ?>" <?php } ?>>
             			 <?php propertya_framework_terms_options('agent_location' , $agent_location); ?>
					</select>
                     </span> 
                  </div>
                      </div>
                      
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['my_mob']); ?><?php if($propertya_options['prop_agent_fields']['ag_mob'] == 1) {  ?> <span class="req-mark">*</span> <?php } ?></label>
                             <span class="wrap">
                             <input type="text" autocomplete="off" data-sanitize="trim" name="agent-mobile" value="<?php echo esc_attr($agent_mobile); ?>" class="form-control text" <?php if($propertya_options['prop_agent_fields']['ag_mob'] == 1) {  ?> data-validation="custom" data-validation-regexp="[0-9]" data-validation-error-msg="<?php echo esc_attr($messages['mob_error']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['my_whatsapp']); ?><?php if($propertya_options['prop_agent_fields']['whats_app'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                             <span class="wrap">
                             <input type="text"  data-sanitize="trim" name="agent-whats" value="<?php echo esc_attr($agent_whats); ?>" class="form-control text" <?php if($propertya_options['prop_agent_fields']['whats_app'] == 1) {  ?> data-validation="number" data-validation-allowing="number" data-validation-error-msg="<?php echo esc_attr($messages['whatsapp_error']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['my_office']); ?><?php if($propertya_options['prop_agent_fields']['off_no'] == 1) {  ?> <span class="req-mark">*</span> <?php } ?></label>
                             <span class="wrap">
                             <input type="text" autocomplete="off" data-sanitize="trim" name="agent-office" value="<?php echo esc_attr($agent_office); ?>" class="form-control text" <?php if($propertya_options['prop_agent_fields']['off_no'] == 1) {  ?> data-validation="number" data-validation-allowing="number" data-validation-error-msg="<?php echo esc_attr($messages['office_no_error']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['my_fax']); ?><?php if($propertya_options['prop_agent_fields']['fax_no'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                             <span class="wrap">
                             <input type="text" data-sanitize="trim" name="agent-fax" value="<?php echo esc_attr($agent_fax); ?>" class="form-control text" <?php if($propertya_options['prop_agent_fields']['fax_no'] == 1) {  ?> data-validation="required" data-validation-error-msg="<?php echo esc_attr($messages['fax_error']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['my_weburl']); ?> <?php if($propertya_options['prop_agent_fields']['web_url'] == 1) {  ?><span class="req-mark">*</span><?php } ?></label>
                             <span class="wrap">
                             <input type="text" placeholder="<?php echo esc_url('http://','propertya'); ?>" data-sanitize="trim" name="agent-url" value="<?php echo esc_attr($agent_url); ?>" class="form-control text" <?php if($propertya_options['prop_agent_fields']['web_url'] == 1) {  ?> data-validation="url" data-validation-error-msg="<?php echo esc_attr($messages['web_url_error']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                     <label><?php echo esc_html($localization['working_hours']); ?><?php if($propertya_options['prop_agent_fields']['ag_hours'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                     <span class="wrap">
                      <input type="text" placeholder="<?php echo esc_attr__( 'Eg: Monday - Friday, 9 AM - 9 PM', 'propertya'); ?>" data-sanitize="trim" name="agent-hours" value="<?php echo esc_attr($agent_hours); ?>" class="form-control text" <?php if($propertya_options['prop_agent_fields']['ag_hours'] == 1) {  ?> data-validation="required" data-validation-error-msg="<?php echo esc_attr($messages['working_hours']); ?>" <?php } ?>>
                     </span> 
                  </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['skype']); ?> <?php if($propertya_options['prop_agent_fields']['ag_skype'] == 1) {  ?><span class="req-mark">*</span><?php } ?></label>
                             <span class="wrap">
                             <input type="text" data-sanitize="trim" name="agent-skype" value="<?php echo esc_attr($agent_skype); ?>" class="form-control text" <?php if($propertya_options['prop_agent_fields']['ag_skype'] == 1) {  ?> data-validation="required" data-validation-error-msg="<?php echo esc_attr($messages['skype']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html__('Position', 'propertya' ); ?> <?php if($propertya_options['prop_agent_fields']['ag_skype'] == 1) {  ?><span class="req-mark">*</span><?php } ?></label>
                             <span class="wrap">
                             <input type="text" data-sanitize="trim" name="agent_desgin" placeholder="<?php echo esc_attr__( 'Eg: Founder & CEO.', 'propertya' ); ?>" value="<?php echo esc_attr($agent_pos); ?>" class="form-control text" <?php if($propertya_options['prop_agent_fields']['ag_skype'] == 1) {  ?> data-validation="required" data-validation-error-msg="<?php echo esc_attr($messages['position']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                  </div>
                <div class="theme-row">
                 <label><?php echo esc_html($localization['my_about_agent']); ?> <?php if($propertya_options['prop_agent_fields']['about_ag'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                 <span class="wrap">
                     <textarea cols="60" class="form-control text" <?php if($propertya_options['prop_agent_fields']['about_ag'] == 1) {  ?> data-validation="required" data-validation-error-msg="<?php echo esc_attr($messages['about_error']); ?>" <?php } ?>  name="about-agent"><?php echo  esc_textarea(get_post_field('post_content', $agent_id)); ?></textarea>
                 </span>
                </div>
               </div>
            </div>
            <div class="card">
               <div class="card-body">
                  <h4 class="card-title"><?php echo esc_html($localization['social_media']); ?></h4>
                  <div class="row">
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['my_fb']); ?><?php if($propertya_options['prop_agent_fields']['ag_fb'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                             <span class="wrap">
                             <input type="text" placeholder="<?php echo esc_url('http://','propertya'); ?>" autocomplete="off" data-sanitize="trim" name="agent-fb" value="<?php echo esc_url($agent_fb); ?>" class="form-control text" <?php if($propertya_options['prop_agent_fields']['ag_fb'] == 1) {  ?> data-validation="url" data-validation-error-msg="<?php echo esc_attr($messages['fb_error']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['my_tw']); ?><?php if($propertya_options['prop_agent_fields']['ag_tw'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                             <span class="wrap">
                             <input type="text" placeholder="<?php echo esc_url('http://','propertya'); ?>" data-sanitize="trim" name="agent-tw" value="<?php echo esc_url($agent_tw); ?>" class="form-control text" <?php if($propertya_options['prop_agent_fields']['ag_tw'] == 1) {  ?> data-validation="url" data-validation-error-msg="<?php echo esc_attr($messages['tw_error']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['my_ln']); ?> <?php if($propertya_options['prop_agent_fields']['ag_link'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                             <span class="wrap">
                             <input type="text" placeholder="<?php echo esc_url('http://','propertya'); ?>" autocomplete="off" data-sanitize="trim" name="agent-in" value="<?php echo esc_url($agent_in); ?>" class="form-control text" <?php if($propertya_options['prop_agent_fields']['ag_link'] == 1) {  ?> data-validation="url" data-validation-error-msg="<?php echo esc_attr($messages['ln_error']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['my_insta']); ?> <?php if($propertya_options['prop_agent_fields']['ag_in'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                             <span class="wrap">
                             <input type="text" placeholder="<?php echo esc_url('http://','propertya'); ?>"  data-sanitize="trim" name="agent-insta" value="<?php echo esc_url($agent_insta); ?>" class="form-control text" <?php if($propertya_options['prop_agent_fields']['ag_in'] == 1) {  ?> data-validation="url" data-validation-error-msg="<?php echo esc_attr($messages['insta_error']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['my_you']); ?> <?php if($propertya_options['prop_agent_fields']['ag_you'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                             <span class="wrap">
                             <input type="text" placeholder="<?php echo esc_url('http://','propertya'); ?>" autocomplete="off" data-sanitize="trim" name="agent-you" value="<?php echo esc_url($agent_you); ?>" class="form-control text" <?php if($propertya_options['prop_agent_fields']['ag_you'] == 1) {  ?> data-validation="url" data-validation-error-msg="<?php echo esc_attr($messages['you_error']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['my_pint']); ?> <?php if($propertya_options['prop_agent_fields']['ag_pin'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                             <span class="wrap">
                             <input type="text" placeholder="<?php echo esc_url('http://','propertya'); ?>" data-sanitize="trim" name="agent-pin" value="<?php echo esc_url($agent_pin); ?>" class="form-control text" <?php if($propertya_options['prop_agent_fields']['ag_pin'] == 1) {  ?> data-validation="url" data-validation-error-msg="<?php echo esc_attr($messages['pin_error']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                  </div>
               </div>
            </div>
            <div class="card">
               <div class="card-body">
                  <h4 class="card-title"><?php echo esc_html($localization['agent_loc']); ?></h4>
                          <div class="theme-row <?php echo esc_attr($check_class); ?>">
                             <label><?php echo esc_html($localization['my_addr']); ?> <?php if($propertya_options['prop_agent_fields']['ag_addr'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                             <span class="wrap">
                             <input id="property_address" type="text" autocomplete="off" data-sanitize="trim" placeholder="<?php echo esc_attr__('Street no 12,Cardiff','propertya'); ?>" name="agent-address" value="<?php echo esc_attr($agent_street_addr); ?>" class="property_address form-control text" <?php if($propertya_options['prop_agent_fields']['ag_addr'] == 1) {  ?> data-validation="required" data-validation-error-msg="<?php echo esc_attr($messages['addr_error']); ?>" <?php } ?>>
                             <?php echo ''.($location_icon); ?>
                             </span> 
                          </div>
                    <?php if(propertya_strings('property_opt_enable_map') == '1') { ?>      
                    <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    	<div id="property_map"></div>
                    </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['my_coord']); ?> </label>
                             <span class="wrap">
                             <input type="text" autocomplete="off" data-sanitize="trim" name="agent-latt" id="property_latt" value="<?php echo esc_attr($agent_latt); ?>" class="form-control text" placeholder="<?php echo esc_attr__('Your location Latitude','propertya');?>">
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label>&nbsp;</label>
                             <span class="wrap">
                             <input type="text" data-sanitize="trim" name="agent-long" id="property_long" value="<?php echo esc_attr($agent_long); ?>" class="form-control text" placeholder="<?php echo esc_attr__('Your location Longitude','propertya');?>">
                             </span> 
                          </div>
                      </div>
                  </div>
                    <?php } ?>
               </div>
            </div>
            <input type="hidden" name="agent_id" id="agent_id" value="<?php echo esc_attr($agent_id); ?>">
            <?php wp_nonce_field( 'prop-agent-up-nonce', 'agent_up_nonce' ); ?>
            <button type="submit" class="btn btn-theme btn-primary"><?php echo esc_html($localization['save_changes']); ?></button>  
			</form>
         </div>
      </div>
   </div>
<?php
}
?>