<?php 
	$single_id   =	get_the_ID();
	global $localization;
?>
<div class="sidebar-widget-seprator single-contact-agency-auths">
    <div class="sidebar-widget-header">
      <h4><?php echo esc_html__('Contact','propertya'); ?> <?php echo get_the_title($single_id); ?></h4>
    </div>
    <div class="sidebar-widget-body">
            <div class="widget-inner-container">
           <form name="contact_author" method="POST" id="prop_singlecontact_author">
              <div class="theme-row">
                 <label><?php echo esc_html__('Your Name','propertya'); ?> <span class="req-mark">*</span></label>
                 <span class="wrap">
                    <input type="text" autocomplete="off" data-sanitize="trim" data-validation="required" data-validation-error-msg="<?php echo esc_attr($localization['all_fields_error']); ?>" name="username" class="form-control text">
                 </span> 
              </div>
              <div class="theme-row">
           <label><?php echo esc_html__('Email','propertya'); ?> <span class="req-mark">*</span></label>
           <span class="wrap">
           <input type="email" autocomplete="off" data-validation="email" data-validation-error-msg="<?php echo esc_attr($localization['all_fields_error']); ?>" data-sanitize="trim" class="form-control text" name="email" />
           </span> 
        </div>
              <div class="theme-row">
           <label><?php echo esc_html__('Your Message','propertya'); ?> <span class="req-mark">*</span></label>
           <span class="wrap">
           <textarea cols="10" class="form-control" autocomplete="off" data-validation="required" data-validation-error-msg-required="<?php echo esc_attr($localization['all_fields_error']); ?>" data-sanitize="trim" rows="5"  name="msg"></textarea>
           </span> 
        </div>
        <?php wp_nonce_field( 'prop-single-profile-nonce', 'single_profile_nonce' ); ?>
        <input type="hidden" name="profile_id" value="<?php echo esc_attr($single_id); ?>">
        <button type="submit" class="btn btn-theme btn-block sonu-button" data-spinner-text="<?php echo esc_attr($localization['processing']); ?>"><?php echo esc_html__('Send Email','propertya'); ?></button>
        </form>
            </div>
    </div>
</div>