<?php
   $localization = propertya_localization();
   $signuplink = $term_conditions = '#';
   $image_id = '';
   if(propertya_strings('prop_terms_page') != '')
   {
	  $term_conditions = esc_url(get_the_permalink(propertya_strings('prop_terms_page')));
   }
   $signuplink = propertya_framework_get_link('page-signup.php');

    // Email verificatioon  
    if( isset( $_GET['verification_key'] ) && $_GET['verification_key'] != ""  && get_current_user_id() == 0 )
    {
        $token  = $_GET['verification_key'];
        $token_url  =   explode( '-propertya-uid-', $token );
        $key    =   $token_url[0];
        $uid    =   $token_url[1];
        $token_db   =   get_user_meta( $uid, 'user_email_verification_token', true ); 
        if( $token_db != $key )
        {
            echo '<script>jQuery(document).ready(function($) { 
           
              notify("error", "Sorry","Invalid security token");

               });</script>';
        }
        else
        {
           
        update_user_meta($uid, 'user_email_verification_token', '');

        // Set the user's role (and implicitly remove the previous role).
        $user = new WP_User( $uid );
        $user->set_role( 'subscriber' );

         echo '<script>jQuery(document).ready(function($) { 
                    notify("success", "Congratulations","Your account has been verified");
             });</script>';
        }
    }
?>
<div class="clearfix"></div>
<div class="container-fluid auth-form-fields">
        <div class="row align-items-center">
            <div class="col-md-12 col-lg-7 creative-container d-flex justify-content-center align-items-center image-background" <?php echo (propertya_bg_src('prop_signin_bg')); ?>>
                <div class="creative-container-content">
					<?php if(propertya_strings('p_signin_first') != '') { ?>
                    <h3><?php echo propertya_strings('p_signin_first'); ?></h3>
                    <?php } ?>
                    <?php if(propertya_strings('p_signin_second') != '') { ?>
                    <h2><?php echo propertya_strings('p_signin_second'); ?></h2>
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
					<?php if(propertya_strings('prop_signin_form_txt') != '') { ?>
					<h1><?php echo propertya_strings('prop_signin_form_txt'); ?></h1>
                    <?php } ?>
                    <?php if(propertya_strings('prop_signin_slogan') != '') { ?>
                    	<p class="mt-1 mb-4 mb-md-6"><?php echo propertya_strings('prop_signin_slogan'); ?><br></p>
                    <?php } ?>
                    <form class="my-form" name="signinForm" method="POST" id="signinForm">
                    <div class="row">
            	<div class="col-md-12 col-lg-12 col-xl-12 col-12">
                  <div class="theme-row">
                     <label><?php echo esc_html($localization['email']); ?><span class="req-mark">*</span></label>
                     <span class="wrap">
                     <input type="email" autocomplete="off" data-validation="email" data-sanitize="trim" name="email" class="form-control text "  data-validation-error-msg-required="<?php echo esc_attr($localization['all_fields_error']); ?>">
                     </span> 
                  </div>
                  </div>
                  </div>
                  <div class="theme-row">
                     <label><?php echo esc_html($localization['pass']); ?> <span class="req-mark">*</span></label>
                     <span class="wrap">
                     <input type="password" autocomplete="off" data-sanitize="trim" data-validation="length" data-validation-length="3-12" data-validation-error-msg="<?php echo esc_attr($localization['all_fields_error']); ?>" name="password" class="form-control text">
                     </span> 
                  </div>
                  <div class="my-checkbox term-conditions">
                  <a href="javascript:void(0)" data-toggle="modal" data-target="#resetmypass"><?php echo esc_html__('Forgot password?', 'propertya'); ?></a>
			</div>
            
             <?php wp_nonce_field( 'prop-login-nonce', 'login_nonce' ); ?>     
           <button type="submit" class="btn btn-theme btn-block sonu-button" name="sigin" data-spinner-text="<?php echo esc_attr($localization['processing']); ?>"><?php echo esc_html($localization['log']); ?></button>
           
            <?php if(propertya_strings('prop_enable_social') == true) { ?>
            <div class="text-center w-full auth-or">
                <span class="txt1"><?php echo esc_html($localization['or_log']); ?></span>
            </div>
            <div class="social-log-area">
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
            <div class="dont-have">
            	<p><?php echo esc_html__("Don't have an account?",'propertya');?> <a href="<?php echo esc_url($signuplink); ?>"><?php echo esc_html__("Sign up now!",'propertya');?></a></p>
            </div>
            <?php } ?>
			</form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="resetmypass">
   						 <div class="modal-dialog">
        <div class="modal-content">
        <form class="modal-from" name="forgetPass" method="POST" id="forgetPass">
            <div class="modal-header">
                <h3 class="modal-title"><?php echo esc_html__('Forgot your password?', 'propertya'); ?></h3>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
                <div class="modal-body">
                        <div class="theme-row">
                         <label><?php echo esc_html($localization['email']); ?><span class="req-mark">*</span></label>
                         <span class="wrap">
                         <input autocomplete="off" data-validation="email" data-sanitize="trim" name="email" class="form-control text"  data-validation-error-msg-required="<?php echo esc_attr($localization['all_fields_error']); ?>">
                         </span> 
                      </div>
                   
                </div>
                <div class="modal-footer">
                    <?php wp_nonce_field( 'prop-reset-nonce', 'reset_nonce' ); ?>
                    <button type="submit" class="btn btn-theme btn-reset" data-spinner-text="<?php echo esc_attr($localization['processing']); ?>"><?php echo esc_html__("Reset My Password", 'propertya'); ?></button>
                </div>
            </form>
        </div>
    </div>
					</div>