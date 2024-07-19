<?php
global $localization;
global $messages;
global $propertya_options;
$user_id = get_current_user_id();
$type = $buyer_id = '';
if(get_user_meta( $user_id, 'prop_post_id', true) !="" && get_user_meta($user_id, 'user_role_type', true) !="")
{
    $buyer_id = get_user_meta( $user_id, 'prop_post_id' , true );
    $type = get_user_meta($user_id, 'user_role_type', true);
	$buyer_email = get_post_meta($buyer_id, 'buyer_email', true );
	$buyer_pos = get_post_meta( $buyer_id, 'buyer_pos', true );
	$buyer_type = get_post_meta($buyer_id, 'buyer_type', true );
	$buyer_mobile = get_post_meta($buyer_id, 'buyer_mobile', true );
	$buyer_whats = get_post_meta($buyer_id, 'buyer_whats', true );
	$buyer_office = get_post_meta($buyer_id, 'buyer_office', true );
	$buyer_fax = get_post_meta($buyer_id, 'buyer_fax', true );
	$buyer_url = get_post_meta($buyer_id, 'buyer_url', true );
	$buyer_location = get_post_meta($buyer_id, 'buyer_location', true );
	$buyer_skype = get_post_meta($buyer_id, 'buyer_skype', true );
	$buyer_hours = get_post_meta($buyer_id, 'buyer_hours', true );
	$buyer_fb = get_post_meta($buyer_id, 'buyer_fb', true );
	$buyer_tw = get_post_meta($buyer_id, 'buyer_tw', true );
	$buyer_in = get_post_meta($buyer_id, 'buyer_in', true );
	$buyer_insta = get_post_meta($buyer_id, 'buyer_insta', true );
	$buyer_you = get_post_meta($buyer_id, 'buyer_you', true );
	$buyer_pin = get_post_meta($buyer_id, 'buyer_pin', true );
	$buyer_street_addr = get_post_meta($buyer_id, 'buyer_street_addr', true );
	$buyer_latt = get_post_meta($buyer_id, 'buyer_latt', true );
	$buyer_long = get_post_meta($buyer_id, 'buyer_long', true );
	$buyer_agency = get_post_meta($buyer_id, 'buyer_buyer_id', true );
// Set default values.
if( empty($buyer_email) ) $buyer_email = '';
if( empty($buyer_pos) ) $buyer_pos = '';
if( empty($buyer_type) ) $buyer_type = '';
if( empty($buyer_mobile) ) $buyer_mobile = '';
if( empty($buyer_whats) ) $buyer_whats = '';
if( empty($buyer_office) ) $buyer_office = '';
if( empty($buyer_fax) ) $buyer_fax = '';
if( empty($buyer_url) ) $buyer_url = '';
if( empty($buyer_location) ) $buyer_location = '';
if( empty($buyer_skype) ) $buyer_skype = '';
if( empty($buyer_hours) ) $buyer_hours = '';
if( empty($buyer_fb) ) $buyer_fb = '';
if( empty($buyer_tw) ) $buyer_tw = '';
if( empty($buyer_in) ) $buyer_in = '';
if( empty($buyer_insta) ) $buyer_insta = '';
if( empty($buyer_you) ) $buyer_you = '';
if( empty($buyer_pin) ) $buyer_pin = '';
if( empty($buyer_street_addr) ) $buyer_street_addr = '';
if( empty($buyer_agency) ) $buyer_agency = '';
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
         	<form class="my-form" name="buyer_update" method="POST" id="buyer_update">
            <div class="card">
               <div class="card-body">
                  <h4 class="card-title"><?php echo esc_html($localization['account_settings']); ?></h4>
                  <div class="row">
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['display_name']); ?> <span class="req-mark">*</span></label>
                             <span class="wrap">
                             <input type="text" autocomplete="off" data-sanitize="trim" name="buyer-name" class="form-control text" data-validation="required" data-validation-error-msg-required="<?php echo esc_attr($messages['name_error']); ?>" value="<?php echo esc_attr(get_the_title($buyer_id)); ?>">
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['email']); ?> <span class="req-mark">*</span></label>
                             <span class="wrap">
                             <input type="text" data-validation="email" data-sanitize="trim" name="buyer-email" placeholder="Messages from contact page will be sent on this email address." class="form-control text" data-validation-error-msg="<?php echo esc_attr($messages['email_error']); ?>" value="<?php echo esc_attr($buyer_email); ?>">
                             </span> 
                          </div>
                      </div>
                      
      
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['my_mob']); ?><?php if($propertya_options['prop_buyer_fields']['ag_mob'] == 1) {  ?> <span class="req-mark">*</span> <?php } ?></label>
                             <span class="wrap">
                             <input type="text" autocomplete="off" data-sanitize="trim" name="buyer-mobile" value="<?php echo esc_attr($buyer_mobile); ?>" class="form-control text" <?php if($propertya_options['prop_buyer_fields']['ag_mob'] == 1) {  ?> data-validation="custom" data-validation-regexp="[0-9]" data-validation-error-msg="<?php echo esc_attr($messages['mob_error']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['my_whatsapp']); ?><?php if($propertya_options['prop_buyer_fields']['whats_app'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                             <span class="wrap">
                             <input type="text"  data-sanitize="trim" name="buyer-whats" value="<?php echo esc_attr($buyer_whats); ?>" class="form-control text" <?php if($propertya_options['prop_buyer_fields']['whats_app'] == 1) {  ?> data-validation="number" data-validation-allowing="number" data-validation-error-msg="<?php echo esc_attr($messages['whatsapp_error']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                  </div>
                <div class="theme-row">
                 <label><?php echo esc_html($localization['my_about_yourself']); ?> <?php if($propertya_options['prop_buyer_fields']['about_ag'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                 <span class="wrap">
                     <textarea class="form-control text" cols="60" rows="10" <?php if($propertya_options['prop_buyer_fields']['about_ag'] == 1) {  ?> data-validation="required" data-validation-error-msg="<?php echo esc_attr($messages['about_error']); ?>" <?php } ?>  name="about-buyer"><?php echo  esc_textarea(get_post_field('post_content', $buyer_id)); ?></textarea>
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
                             <label><?php echo esc_html($localization['my_fb']); ?><?php if($propertya_options['prop_buyer_fields']['ag_fb'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                             <span class="wrap">
                             <input type="text" placeholder="<?php echo esc_url('http://','propertya'); ?>" autocomplete="off" data-sanitize="trim" name="buyer-fb" value="<?php echo esc_url($buyer_fb); ?>" class="form-control text" <?php if($propertya_options['prop_buyer_fields']['ag_fb'] == 1) {  ?> data-validation="url" data-validation-error-msg="<?php echo esc_attr($messages['fb_error']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['my_tw']); ?><?php if($propertya_options['prop_buyer_fields']['ag_tw'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                             <span class="wrap">
                             <input type="text" placeholder="<?php echo esc_url('http://','propertya'); ?>" data-sanitize="trim" name="buyer-tw" value="<?php echo esc_url($buyer_tw); ?>" class="form-control text" <?php if($propertya_options['prop_buyer_fields']['ag_tw'] == 1) {  ?> data-validation="url" data-validation-error-msg="<?php echo esc_attr($messages['tw_error']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['my_ln']); ?> <?php if($propertya_options['prop_buyer_fields']['ag_link'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                             <span class="wrap">
                             <input type="text" placeholder="<?php echo esc_url('http://','propertya'); ?>" autocomplete="off" data-sanitize="trim" name="buyer-in" value="<?php echo esc_url($buyer_in); ?>" class="form-control text" <?php if($propertya_options['prop_buyer_fields']['ag_link'] == 1) {  ?> data-validation="url" data-validation-error-msg="<?php echo esc_attr($messages['ln_error']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['my_insta']); ?> <?php if($propertya_options['prop_buyer_fields']['ag_in'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                             <span class="wrap">
                             <input type="text" placeholder="<?php echo esc_url('http://','propertya'); ?>"  data-sanitize="trim" name="buyer-insta" value="<?php echo esc_url($buyer_insta); ?>" class="form-control text" <?php if($propertya_options['prop_buyer_fields']['ag_in'] == 1) {  ?> data-validation="url" data-validation-error-msg="<?php echo esc_attr($messages['insta_error']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                      
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['my_pint']); ?> <?php if($propertya_options['prop_buyer_fields']['ag_pin'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                             <span class="wrap">
                             <input type="text" placeholder="<?php echo esc_url('http://','propertya'); ?>" data-sanitize="trim" name="buyer-pin" value="<?php echo esc_url($buyer_pin); ?>" class="form-control text" <?php if($propertya_options['prop_buyer_fields']['ag_pin'] == 1) {  ?> data-validation="url" data-validation-error-msg="<?php echo esc_attr($messages['pin_error']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                  </div>
               </div>
            </div>
            <div class="card">
               <div class="card-body">
                  <h4 class="card-title"><?php echo esc_html($localization['buyer_loc']); ?></h4>
                          <div class="theme-row <?php echo esc_attr($check_class); ?>">
                             <label><?php echo esc_html($localization['my_addr']); ?> <?php if($propertya_options['prop_buyer_fields']['ag_addr'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                             <span class="wrap">
                             <input id="property_address" type="text" autocomplete="off" data-sanitize="trim" placeholder="<?php echo esc_attr__('Street no 12,Cardiff','propertya'); ?>" name="buyer-address" value="<?php echo esc_attr($buyer_street_addr); ?>" class="property_address form-control text" <?php if($propertya_options['prop_buyer_fields']['ag_addr'] == 1) {  ?> data-validation="required" data-validation-error-msg="<?php echo esc_attr($messages['addr_error']); ?>" <?php } ?>>
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
                             <input type="text" autocomplete="off" data-sanitize="trim" name="buyer-latt" id="property_latt" value="<?php echo esc_attr($buyer_latt); ?>" class="form-control text" placeholder="<?php echo esc_attr__('Your location Latitude','propertya');?>">
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label>&nbsp;</label>
                             <span class="wrap">
                             <input type="text" data-sanitize="trim" name="buyer-long" id="property_long" value="<?php echo esc_attr($buyer_long); ?>" class="form-control text" placeholder="<?php echo esc_attr__('Your location Longitude','propertya');?>">
                             </span> 
                          </div>
                      </div>
                  </div>
                    <?php } ?>
               </div>
            </div>
            <input type="hidden" name="buyer_id" id="buyer_id" value="<?php echo esc_attr($buyer_id); ?>">
            <?php wp_nonce_field( 'prop-buyer-up-nonce', 'buyer_up_nonce' ); ?>
            <button type="submit" class="btn btn-theme sonu-button" data-spinner-text="<?php echo esc_attr($localization['processing']); ?>"><?php echo esc_html($localization['save_changes']); ?></button>  
			</form>
         </div>
      </div>
   </div>
<?php
}
?>