<?php
global $localization;
global $messages;
global $propertya_options;
$user_id = get_current_user_id();
$image_id = $all_idz = $type = $post_id = '';
if(get_user_meta( $user_id, 'prop_post_id' , true ) !="")
{
  $post_id = get_user_meta( $user_id, 'prop_post_id' , true );
}
if(get_user_meta($user_id, 'user_role_type', true) !="")
{
	$type = get_user_meta($user_id, 'user_role_type', true);	
}
if(!empty($type))
{
	$fb = get_post_meta($post_id, $type.'_fb', true );
	$tw = get_post_meta($post_id, $type.'_tw', true );
	$in = get_post_meta($post_id, $type.'_in', true );
	$insta = get_post_meta($post_id, $type.'_insta', true );
	$pin = get_post_meta($post_id, $type.'_pin', true );
}
if( empty($fb) ) $fb = '';
if( empty($tw) ) $tw = '';
if( empty($in) ) $in = '';
if( empty($insta) ) $insta = '';
if( empty($you) ) $you = '';
if( empty($pin) ) $pin = '';
if(isset($type) && $type == "agency")
{
	$reference = 'agency';
	$post_type = 'property-agency';
}
if(isset($type) && $type == "agent")
{
	$reference = 'agent';
	$post_type = 'property-agents';
}
if(isset($type) && $type == "buyer")
{
	$reference = 'buyer';
	$post_type = 'property-buyers';
}
 
$ratings = array();
$ratings = propertya_reviews_stats_average($post_id,$post_type,$reference);
$allowed_html = propertya_allowed_html();
$class= 'mt-3';
?>
<div class="col-lg-4 col-xl-4 col-md-4 col-sm-12">
     <div class="grid-margin">
        <div class="card">
           <div class="card-body">
              <h4 class="card-title"><?php echo esc_html($localization['my_profile']); ?></h4>
                <div class="text-center">
                   <div class="my-user-profile">
                      <div class="mb-3"> 
                      <img src="<?php echo esc_url(propertya_placeholder_images($type,$post_id,'full')); ?>" alt="<?php echo esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid"> </div>
                      <h3 class="username mb-2"><?php echo esc_html(get_the_title($post_id)); ?></h3>
                      <?php if(get_post_meta($post_id, $type.'_street_addr', true ) !="") { ?>
                      <p class="mb-1 text-muted"><?php echo esc_html(get_post_meta($post_id, $type.'_street_addr', true )); ?></p>
                      <?php } ?>
                      <?php if(!empty($ratings) && is_array($ratings) && $ratings['rated_no_of_times'] > 0) { $class= ''; ?>
                      <div class="text-center mb-4"> 
                      	<span class="ratings"> <?php echo wp_kses($ratings['total_stars'],$allowed_html) ; ?></span>
                      </div>
                      <?php } ?>
                      <div class="my-socials <?php echo esc_attr($class); ?>">
                        <?php if($fb !="") { ?> 
                         
                         <a href="<?php echo esc_url($fb); ?>" class="theme-social-btns theme-social-round mfb shadow fab fa-facebook-f"></a>
                         <?php } ?>
                         <?php if($tw !="") { ?>
                         <a href="<?php echo esc_url($tw); ?>" class="theme-social-btns theme-social-round mtwitter shadow fab fa-twitter"></a>
                         <?php } ?>
                         <?php if($in !="") { ?>
                         <a href="<?php echo esc_url($in); ?>" class="theme-social-btns theme-social-round mlinkedin shadow fab fa-linkedin-in"></a>
                         <?php } ?>
                         <?php if($insta !="") { ?>
                         <a href="<?php echo esc_url($insta); ?>" class="theme-social-btns theme-social-round shadow minsta fab fa-instagram"></a>
                         <?php } ?>
                         
                         <?php if($pin !="") { ?>
                         <a href="<?php echo esc_url($pin); ?>" class="theme-social-btns theme-social-round shadow  mpin fab fa-pinterest"></a>
                         <?php } ?>
                      </div>
                   </div>
                </div>
           </div>
        </div> 
        <div class="card my-featured-img">
           <div class="card-body">
              <h4 class="card-title"><?php echo esc_html($localization['feat_img']); ?></h4>
                <div class="avatar-upload">
                    <form class="fileUpload" enctype="multipart/form-data">
                        <div class="avatar-edit">
                            <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
                            <label for="imageUpload"></label>
                        </div>
                        <div class="avatar-preview">
                            <div id="imagePreview" style="background-image: url(<?php echo esc_url(propertya_placeholder_images($type)); ?>);">
                            </div>
                        </div>
                    </form>    
                </div>
           </div>
        </div> 
        
        <div class="card cover-featured-img">
           <div class="card-body">
              <h4 class="card-title"><?php echo esc_html__('Cover Image','propertya'); ?></h4>
                   <form class="fileuploadcover" enctype="multipart/form-data">
                  <div class="imgUp">
                    <div class="imagePreview">
                    <?php
                    if(get_post_meta($post_id, 'my_cover_featuredimg', true ) !="")
                    {
                        $attach_id = get_post_meta($post_id, 'my_cover_featuredimg', true );
                        
                        echo '<div class="my-cov-img">' . wp_get_attachment_image($attach_id, array('345', '230')) . '</div>';
                    }
                   ?>
                    <div class="overlay-cover">
                        <div class="overlay-content">
                         <img src="<?php echo esc_url(trailingslashit( get_template_directory_uri () ) . "libs/images/home-loading.gif"); ?>" alt="<?php echo esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', TRUE)); ?>"/>
                        </div>
                    </div>
                    </div>
                    <label class="btn btn-theme btn-block"><i class="fas fa-upload"></i> <?php echo esc_html__('Upload','propertya'); ?>
                        <input name="mycover-img" type="file" class="cover-button uploadFile" value="<?php echo esc_attr__('Upload','propertya'); ?>" accept=".png, .jpg, .jpeg">
                    </label>
                  </div>
                  </form>
           </div>
        </div>
        <div class="card change-my-pass">
           <div class="card-body">
              <h4 class="card-title"><?php echo esc_html($localization['edit_pass']); ?></h4>
              <form class="my-form" name="pass_update" method="POST" id="pass_update">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['current_pass']); ?> <span class="req-mark">*</span></label>
                             <span class="wrap">
                             <input type="password" autocomplete="off" data-sanitize="trim" name="my_previous_pass" class="form-control text" data-validation="required" data-validation-error-msg-required="<?php echo esc_attr($messages['all_fields_error']); ?>">
                             </span> 
                          </div>
                      </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['new_pass']); ?> <span class="req-mark">*</span></label>
                             <span class="wrap">
                             <input type="password" autocomplete="off" data-sanitize="trim" name="my_new_pass" class="form-control text" data-validation="required" data-validation-error-msg-required="<?php echo esc_attr($messages['all_fields_error']); ?>">
                             </span> 
                          </div>
                      </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                          <div class="theme-row">
                             <label><?php echo esc_html($localization['conf_pass']); ?> <span class="req-mark">*</span></label>
                             <span class="wrap">
                             <input type="password" autocomplete="off" data-sanitize="trim" name="my_confirm_pass" class="form-control text" data-validation="required" data-validation-error-msg-required="<?php echo esc_attr($messages['all_fields_error']); ?>">
                             </span> 
                          </div>
                      </div>
                </div>
                <div class="save-act-btn">
                    <button type="submit" class="btn btn-theme btn-primary"><?php echo esc_html($localization['change_pass_btn']); ?></button>  
                </div>
                <?php wp_nonce_field( 'prop-my_pass', 'mypass_up_nonce' ); ?>  
              </form>
           </div>
        </div>
        <div class="card del-my-account">
           <div class="card-body">
              <h4 class="card-title"><?php echo esc_html($localization['accn_delete']); ?></h4>
              <form class="my-form" name="my_account_deletion" method="POST" id="my_account_deletion">
                <p class="acl-del"><?php echo esc_html($localization['accn_delete_msg']); ?></p>
                <div class="save-act-btn">
                    <button type="submit" class="del-my-account btn btn-theme btn-danger"><?php echo esc_html($localization['accn_delete_btn']); ?></button>
                     <i class="fas fa-exclamation-triangle" aria-hidden="true"></i>  
                </div>
                <?php wp_nonce_field( 'prop-my_pass_dell', 'mypass_account_del_nonce' ); ?> 
                <input type="hidden" name="active_user" value="<?php echo esc_attr($user_id); ?>"> 
              </form>
           </div>
        </div>    
     </div>
</div>