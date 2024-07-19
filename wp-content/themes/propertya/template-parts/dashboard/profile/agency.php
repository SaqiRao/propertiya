<?php
global $localization;
global $messages;
global $propertya_options;
$user_id = get_current_user_id();
$type = $agency_id = '';
if(get_user_meta( $user_id, 'prop_post_id', true) !="" && get_user_meta($user_id, 'user_role_type', true) !="")
{
	$agency_id = get_user_meta( $user_id, 'prop_post_id' , true );
	$type = get_user_meta($user_id, 'user_role_type', true);	

// Retrieve an existing value from the database.
$agency_email = get_post_meta($agency_id, 'agency_email', true );
$agency_mobile = get_post_meta($agency_id, 'agency_mobile', true );
$agency_whats = get_post_meta($agency_id, 'agency_whats', true );
$agency_office = get_post_meta($agency_id, 'agency_office', true );
$agency_fax = get_post_meta($agency_id, 'agency_fax', true );
$agency_licence = get_post_meta($agency_id, 'agency_licence', true );
$agency_tax = get_post_meta($agency_id, 'agency_tax', true );
$agency_url = get_post_meta($agency_id, 'agency_url', true );
$agency_location = get_post_meta($agency_id, 'agency_location', true );
$agency_fb = get_post_meta($agency_id, 'agency_fb', true );
$agency_tw = get_post_meta($agency_id, 'agency_tw', true );
$agency_in = get_post_meta($agency_id, 'agency_in', true );
$agency_insta = get_post_meta($agency_id, 'agency_insta', true );
$agency_pin = get_post_meta($agency_id, 'agency_pin', true );
$agency_street_addr = get_post_meta($agency_id, 'agency_street_addr', true );
$agency_latt = get_post_meta($agency_id, 'agency_latt', true );
$agency_long = get_post_meta($agency_id, 'agency_long', true );
// Set default values.
if( empty($agency_email) ) $agency_email = '';
if( empty($agency_mobile) ) $agency_mobile = '';
if( empty($agency_whats) ) $agency_whats = '';
if( empty($agency_office) ) $agency_office = '';
if( empty($agency_fax) ) $agency_fax = '';
if( empty($agency_licence) ) $agency_licence = '';
if( empty($agency_tax) ) $agency_tax = '';
if( empty($agency_url) ) $agency_url = '';
if( empty($agency_location) ) $agency_location = '';
if( empty($agency_fb) ) $agency_fb = '';
if( empty($agency_tw) ) $agency_tw = '';
if( empty($agency_in) ) $agency_in = '';
if( empty($agency_insta) ) $agency_insta = '';
if( empty($agency_pin) ) $agency_pin = '';
if( empty($agency_street_addr) ) $agency_street_addr = '';
if( empty($agency_latt) ) $agency_latt = '';
if( empty($agency_long) ) $agency_long = '';
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
         	<form class="my-form" name="agency_update" method="POST" id="agency_update">
            <div class="card">
               <div class="card-body">
                  <h4 class="card-title"><?php echo esc_html($localization['account_settings']); ?></h4>
                  <div class="row">
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['agency_name']); ?> <span class="req-mark">*</span></label>
                             <span class="wrap">
                             <input type="text" autocomplete="off" data-sanitize="trim" name="agency-name" class="form-control text" data-validation="required" data-validation-error-msg-required="<?php echo esc_attr($messages['name_error']); ?>" value="<?php echo esc_attr(get_the_title($agency_id)); ?>">
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['email']); ?> <span class="req-mark">*</span></label>
                             <span class="wrap">
                             <input type="text" data-validation="email" data-sanitize="trim" name="agency-email" placeholder="Messages from contact page will be sent on this email address." class="form-control text" data-validation-error-msg="<?php echo esc_attr($messages['email_error']); ?>" value="<?php echo esc_attr($agency_email); ?>">
                             </span> 
                          </div>
                      </div>
                      
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['my_mob']); ?><?php if($propertya_options['prop_agency_fields']['agency_mob'] == 1) {  ?> <span class="req-mark">*</span> <?php } ?></label>
                             <span class="wrap">
                             <input type="text" autocomplete="off" data-sanitize="trim" name="agency-mobile" value="<?php echo esc_attr($agency_mobile); ?>" class="form-control text" <?php if($propertya_options['prop_agency_fields']['agency_mob'] == 1) {  ?>  data-validation="custom" data-validation-regexp="[0-9]" data-validation-error-msg="<?php echo esc_attr($messages['mob_error']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['my_whatsapp']); ?><?php if($propertya_options['prop_agency_fields']['whats_app'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                             <span class="wrap">
                             <input type="text"  data-sanitize="trim" name="agency-whats" value="<?php echo esc_attr($agency_whats); ?>" class="form-control text" <?php if($propertya_options['prop_agency_fields']['whats_app'] == 1) {  ?> data-validation="number" data-validation-allowing="number" data-validation-error-msg="<?php echo esc_attr($messages['whatsapp_error']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['my_office']); ?><?php if($propertya_options['prop_agency_fields']['off_no'] == 1) {  ?> <span class="req-mark">*</span> <?php } ?></label>
                             <span class="wrap">
                             <input type="text" autocomplete="off" data-sanitize="trim" name="agency-office" value="<?php echo esc_attr($agency_office); ?>" class="form-control text" <?php if($propertya_options['prop_agency_fields']['off_no'] == 1) {  ?> data-validation="number" data-validation-allowing="number" data-validation-error-msg="<?php echo esc_attr($messages['office_no_error']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['my_fax']); ?><?php if($propertya_options['prop_agency_fields']['fax_no'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                             <span class="wrap">
                             <input type="text" data-sanitize="trim" name="agency-fax" value="<?php echo esc_attr($agency_fax); ?>" class="form-control text" <?php if($propertya_options['prop_agency_fields']['fax_no'] == 1) {  ?> data-validation="required" data-validation-error-msg="<?php echo esc_attr($messages['fax_error']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['my_agency_lic']); ?><?php if($propertya_options['prop_agency_fields']['agency_lic'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                             <span class="wrap">
                             <input type="text" autocomplete="off" data-sanitize="trim" name="agency-licence" value="<?php echo esc_attr($agency_licence); ?>" class="form-control text" <?php if($propertya_options['prop_agency_fields']['agency_lic'] == 1) {  ?> data-validation="required" data-validation-error-msg="<?php echo esc_attr($messages['license_error']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['my_taxno']); ?><?php if($propertya_options['prop_agency_fields']['tax_no'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                             <span class="wrap">
                             <input type="text" data-sanitize="trim" name="agency-tax" value="<?php echo esc_attr($agency_tax); ?>" class="form-control text" <?php if($propertya_options['prop_agency_fields']['tax_no'] == 1) {  ?> data-validation="required" data-validation-error-msg="<?php echo esc_attr($messages['tax_error']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['my_weburl']); ?> <?php if($propertya_options['prop_agency_fields']['web_url'] == 1) {  ?><span class="req-mark">*</span><?php } ?></label>
                             <span class="wrap">
                             <input type="text" placeholder="<?php echo esc_url('http://','propertya'); ?>" data-sanitize="trim" name="agency-url" value="<?php echo esc_attr($agency_url); ?>" class="form-control text" <?php if($propertya_options['prop_agency_fields']['web_url'] == 1) {  ?> data-validation="url" data-validation-error-msg="<?php echo esc_attr($messages['web_url_error']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                     <label><?php echo esc_html($localization['my_agency_loc']); ?><?php if($propertya_options['prop_agency_fields']['agency_loc'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                     <span class="wrap">
                     <select class="theme-selects" data-sanitize="trim" name="agency-location" data-placeholder="<?php echo esc_attr__('Select Location','propertya');?>" <?php if($propertya_options['prop_agency_fields']['agency_loc'] == 1) {  ?> data-validation="required" data-validation-error-msg="<?php echo esc_attr($messages['loc_error']); ?>" <?php } ?>>
             			 <?php propertya_framework_terms_options('agency_location' , $agency_location); ?>
					</select>
                     </span> 
                  </div>
                      </div>
                  </div>
                <div class="theme-row">
                 <label><?php echo esc_html($localization['my_about_agency']); ?> <?php if($propertya_options['prop_agency_fields']['about_agency'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                 <span class="wrap">
                     <textarea cols="60" class="form-control text" rows="10" <?php if($propertya_options['prop_agency_fields']['about_agency'] == 1) {  ?> data-validation="required" data-validation-error-msg="<?php echo esc_attr($messages['about_error']); ?>" <?php } ?>  name="about-agency"><?php echo  esc_textarea(get_post_field('post_content', $agency_id)); ?></textarea>
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
                             <label><?php echo esc_html($localization['my_fb']); ?><?php if($propertya_options['prop_agency_fields']['agency_fb'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                             <span class="wrap">
                             <input type="text" placeholder="<?php echo esc_url('http://','propertya'); ?>" autocomplete="off" data-sanitize="trim" name="agency-fb" value="<?php echo esc_url($agency_fb); ?>" class="form-control text" <?php if($propertya_options['prop_agency_fields']['agency_fb'] == 1) {  ?> data-validation="url" data-validation-error-msg="<?php echo esc_attr($messages['fb_error']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['my_tw']); ?><?php if($propertya_options['prop_agency_fields']['agency_tw'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                             <span class="wrap">
                             <input type="text" placeholder="<?php echo esc_url('http://','propertya'); ?>" data-sanitize="trim" name="agency-tw" value="<?php echo esc_url($agency_tw); ?>" class="form-control text" <?php if($propertya_options['prop_agency_fields']['agency_tw'] == 1) {  ?> data-validation="url" data-validation-error-msg="<?php echo esc_attr($messages['tw_error']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['my_ln']); ?> <?php if($propertya_options['prop_agency_fields']['agency_link'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                             <span class="wrap">
                             <input type="text" placeholder="<?php echo esc_url('http://','propertya'); ?>" autocomplete="off" data-sanitize="trim" name="agency-in" value="<?php echo esc_url($agency_in); ?>" class="form-control text" <?php if($propertya_options['prop_agency_fields']['agency_link'] == 1) {  ?> data-validation="url" data-validation-error-msg="<?php echo esc_attr($messages['ln_error']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['my_insta']); ?> <?php if($propertya_options['prop_agency_fields']['agency_in'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                             <span class="wrap">
                             <input type="text" placeholder="<?php echo esc_url('http://','propertya'); ?>"  data-sanitize="trim" name="agency-insta" value="<?php echo esc_url($agency_insta); ?>" class="form-control text" <?php if($propertya_options['prop_agency_fields']['agency_in'] == 1) {  ?> data-validation="url" data-validation-error-msg="<?php echo esc_attr($messages['insta_error']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['my_pint']); ?> <?php if($propertya_options['prop_agency_fields']['agency_pin'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                             <span class="wrap">
                             <input type="text" placeholder="<?php echo esc_url('http://','propertya'); ?>" data-sanitize="trim" name="agency-pin" value="<?php echo esc_url($agency_pin); ?>" class="form-control text" <?php if($propertya_options['prop_agency_fields']['agency_pin'] == 1) {  ?> data-validation="url" data-validation-error-msg="<?php echo esc_attr($messages['pin_error']); ?>" <?php } ?>>
                             </span> 
                          </div>
                      </div>
                  </div>
               </div>
            </div>
            <div class="card">
               <div class="card-body">
                  <h4 class="card-title"><?php echo esc_html($localization['agency_loc']); ?></h4>
                          <div class="theme-row <?php echo esc_attr($check_class); ?>">
                             <label><?php echo esc_html($localization['my_addr']); ?> <?php if($propertya_options['prop_agency_fields']['agency_addr'] == 1) {  ?> <span class="req-mark">*</span><?php } ?></label>
                             <span class="wrap">
                             <input id="property_address" type="text" autocomplete="off" data-sanitize="trim" placeholder="<?php echo esc_attr__('Street no 12,Cardiff','propertya'); ?>" name="agency-address" value="<?php echo esc_attr($agency_street_addr); ?>" class="property_address form-control text" <?php if($propertya_options['prop_agency_fields']['agency_addr'] == 1) {  ?> data-validation="required" data-validation-error-msg="<?php echo esc_attr($messages['addr_error']); ?>" <?php } ?>>
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
                             <input type="text" autocomplete="off" data-sanitize="trim" name="agency-latt" id="property_latt" value="<?php echo esc_attr($agency_latt); ?>" class="form-control text" placeholder="<?php echo esc_attr__('Your location Latitude','propertya');?>">
                             </span> 
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                          <div class="theme-row">
                             <label>&nbsp;</label>
                             <span class="wrap">
                             <input type="text" data-sanitize="trim" name="agency-long" id="property_long" value="<?php echo esc_attr($agency_long); ?>" class="form-control text" placeholder="<?php echo esc_attr__('Your location Longitude','propertya');?>">
                             </span> 
                          </div>
                      </div>
                  </div>
                    <?php } ?>
               </div>
            </div>
            <input type="hidden" name="agency_id" id="agency_id" value="<?php echo esc_attr($agency_id); ?>">
            <?php wp_nonce_field( 'prop-agency-up-nonce', 'agency_up_nonce' ); ?>
            <button type="submit" class="btn btn-theme btn-primary"><?php echo esc_html($localization['save_changes']); ?></button>  
			</form>
         </div>
      </div>
   </div>
<?php
}
?>