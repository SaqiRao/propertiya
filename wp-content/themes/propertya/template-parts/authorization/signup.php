<?php
   $localization = propertya_localization();
   $term_conditions = '#';
   $image_id = '';
   if(propertya_strings('prop_terms_page') != '')
   {
	  $term_conditions = get_the_permalink(propertya_strings('prop_terms_page'));
   }
?>
<div class="clearfix"></div>
<div class="container-fluid auth-form-fields">
        <div class="row align-items-center">
            <div class="col-md-12 col-lg-7 creative-container just-for-signup d-flex justify-content-center align-items-center image-background" <?php echo (propertya_bg_src('prop_signup_bg')); ?>>
                <div class="creative-container-content">
					<?php if(propertya_strings('p_signup_first') != '') { ?>
                    <h3><?php echo propertya_strings('p_signup_first'); ?></h3>
                    <?php } ?>
                    <?php if(propertya_strings('p_signup_second') != '') { ?>
                    <h2><?php echo propertya_strings('p_signup_second'); ?></h2>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-12 col-lg-4 mx-auto">
                <div class="login-form mt-5 mt-md-0">
                    <?php 
					if(is_page_template('page-signup.php') && propertya_strings('prop_enable_head_foot') == false || is_page_template('page-signin.php') && propertya_strings('prop_enable_head_foot') == false)
					{
						echo propertya_site_logo_only();
					}
					?>
                    <?php if(propertya_strings('prop_signup_form_txt') != '') { ?>
					<h1><?php echo propertya_strings('prop_signup_form_txt'); ?></h1>
                    <?php } ?>
                    <?php if(propertya_strings('prop_signup_slogan') != '') { ?>
                    	<p class="mt-1 mb-4 mb-md-6"><?php echo propertya_strings('prop_signup_slogan'); ?><br></p>
                    <?php } ?>
                    <form class="my-form" name="signupForm" method="POST" id="signupForm">
                    
                    <div class="theme-row">
                     <label><?php echo esc_html($localization['user_type']); ?> <span class="req-mark">*</span></label>
                     <span class="wrap">
                     <select class="form-control theme-selects" data-sanitize="trim" name="usertype" data-placeholder="<?php echo esc_attr__('Select User Type','propertya');?>" data-validation="required" data-validation-error-msg-required="<?php echo esc_attr($localization['all_fields_error']); ?>">
                         <option value="agency"><?php echo esc_html__('Agency','propertya');?></option>
             			 <option value="agent"><?php echo esc_html__('Agent','propertya');?></option>
                         <option value="buyer"><?php echo esc_html__('Buyer/Individual','propertya');?></option>
					</select>
                     </span> 
                  </div>
                    
                    <div class="row">
            	<div class="col-md-12 col-lg-6 col-xl-6 col-12">
                  <div class="theme-row">
                     <label><?php echo esc_html($localization['username']); ?> <span class="req-mark">*</span></label>
                     <span class="wrap">
                     <input type="text" autocomplete="off" data-sanitize="trim" name="username" class="form-control text" data-validation="required" data-validation-error-msg-required="<?php echo esc_attr($localization['all_fields_error']); ?>">
                     </span> 
                  </div>
                  </div>
                  <div class="col-md-12 col-lg-6 col-xl-6 col-12">
                  <div class="theme-row">
                     <label><?php echo esc_html($localization['display_name']); ?>  <i class="far fa-question-circle" data-toggle="popover" data-placement="top" data-content="<?php echo esc_attr($localization['displayname_popover']); ?>"></i></label>
                     <span class="wrap">
                     <input type="text" autocomplete="off" data-sanitize="trim" name="displayname" class="form-control text" data-validation="required" data-validation-error-msg-required="<?php echo esc_attr($localization['all_fields_error']); ?>">
                     </span> 
                  </div>
                  </div>
                  
                  </div>
                  
                  <div class="theme-row">
                     <label><?php echo esc_html($localization['email']); ?> <span class="req-mark">*</span></label>
                     <span class="wrap">
                     <input type="email" autocomplete="off" data-validation="email" data-sanitize="trim" name="email" class="form-control text" data-validation-error-msg="<?php echo esc_attr($localization['all_fields_error']); ?>">
                     </span> 
                  </div>
                  
                  <div class="theme-row">
                     <label><?php echo esc_html($localization['pass']); ?> <span class="req-mark">*</span></label>
                     <span class="wrap">
                     <input type="password" id="password-field" autocomplete="off" data-sanitize="trim" data-validation="length" data-validation-length="3-12" data-validation-error-msg="<?php echo esc_attr($localization['all_fields_error']); ?>" name="password" class="form-control text">
                     </span> 
                     <div data-toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></div>
                  </div>
                  
                  <div class="my-checkbox  term-conditions ">
				<div class="pretty p-default">
                    <input type="checkbox" data-validation="required" />
                    <div class="state p-primary">
                        <label></label> 
                    </div>
    			</div>
    <?php echo wp_sprintf(__( 'I agree to the <a href="%s">terms of service</a>', 'propertya' ), esc_url($term_conditions));?>
			</div>
             <?php wp_nonce_field( 'prop-register-nonce', 'register_nonce' ); ?>     
           <button type="submit" class="btn btn-theme btn-block sonu-button" name="signup" data-spinner-text="<?php echo esc_attr($localization['processing']); ?>"><?php echo esc_html($localization['signup']); ?> </button>
            <?php if(propertya_strings('prop_enable_social') == true) { ?>
            <div class="text-center w-full auth-or">
                <span class="txt1"><?php echo esc_html($localization['or_reg']); ?></span>
            </div>
            <div class="social-log-area is-signup">
                    <?php if(propertya_strings('prop_fb_key') !='') { ?>
                 <button type="button" class="btn-face fb-btn m-b-10" data-spinner-text="<?php echo esc_attr($localization['processing']); ?>" onclick="hello('facebook').login({scope:'email'})" >
                    <i class="fab fa-facebook-f"></i>
                        <?php echo esc_html($localization['fb']); ?>
                    </button>
                    <?php } ?>
                    <?php if(propertya_strings('prop_google_key') !='') { ?>
                    <button type="button" class="btn-socialz gog-btn btn-google m-b-10" data-spinner-text="<?php echo esc_attr($localization['processing']); ?>" onclick="hello('google').login({scope: 'email'})">
                    <img src="<?php echo esc_url(trailingslashit( get_template_directory_uri () )."libs/images/icon-google.webp"); ?>" alt="<?php echo esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', TRUE)); ?>">
                        <?php echo esc_html($localization['google']); ?>
                    </button>
                    <?php } ?>
            </div>
            <?php } ?>
			</form>
                </div>
            </div>
        </div>
    </div>