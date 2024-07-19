<?php 
          $property_id  =       get_the_ID();
          $localization = propertya_localization();
?>
<div class="sidebar-widget-seprator">
        <?php
                $type = $posted_id = '';
                $whatsap = '';
                $post_author_id = get_post_field('post_author', $property_id);
                if(get_user_meta($post_author_id, 'user_role_type', true) !="")
                {   
                    $posted_id = get_user_meta($post_author_id, 'prop_post_id' , true );
                            $type = get_user_meta($post_author_id, 'user_role_type', true);
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

                    $whatsap = get_post_meta($posted_id, $reference.'_whats', true );
                        }?>    
        <div class="sidebar-widget-header">
          <h4><?php echo esc_html(propertya_strings('prop_sidebar_contact_seller')); ?></h4>
        </div>
        <div class="sidebar-widget-body">
                <div class="widget-inner-container">
               <form name="contact_author" method="POST" id="prop_contact_author">
                  <div class="theme-row">
                     <label><?php echo esc_html__('Your Name','propertya'); ?> <span class="req-mark">*</span></label>
                     <span class="wrap">
                        <input type="text" autocomplete="off" data-sanitize="trim" data-validation="required" data-validation-error-msg="<?php echo esc_attr($localization['all_fields_error']); ?>." name="c_username" class="form-control text">
                     </span> 
                  </div>
                  <div class="theme-row">
               <label><?php echo esc_html__('Email','propertya'); ?> <span class="req-mark">*</span></label>
               <span class="wrap">
               <input type="email" autocomplete="off" data-validation="email" data-validation-error-msg="<?php echo esc_attr($localization['all_fields_error']); ?>" data-sanitize="trim" class="form-control text" name="c_email" />
               </span> 
            </div>
                   <div class="theme-row">
               <span class="wrap for-my-phone">
               <input type="text" autocomplete="off" id="myphone" data-validation="required" data-validation-error-msg="<?php echo esc_attr($localization['all_fields_error']); ?>" data-sanitize="trim" class="form-control text" name="contact-no" />
               </span> 
            </div>
                  <div class="theme-row">
               <label><?php echo esc_html__('Your Message','propertya'); ?> <span class="req-mark">*</span></label>
               <span class="wrap">
               <textarea cols="10" rows="4" class="form-control" autocomplete="off" data-validation="required" data-validation-error-msg-required="<?php echo esc_attr($localization['all_fields_error']); ?>" data-sanitize="trim"  name="c_msg"></textarea>
               </span> 
            </div>
            <?php wp_nonce_field( 'prop-contactauthor-nonce', 'contactauthor_nonce' ); ?>
                    <input type="hidden" name="listing_id" value="<?php echo esc_attr($property_id); ?>">
                    <button type="submit" class="btn btn-danger btn-block sonu-button-contact"><?php echo esc_html__('Send Email','propertya'); ?></button>
                    <?php if(isset($whatsap) && $whatsap != '' && propertya_strings('prop_enable_wtsap') == true){?>
                        <a target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo esc_html($whatsap); ?>&amp;text=<?php echo propertya_strings('prop_wtsap_txt'); ?>" class="btn btn-block btn-whatsap"><i class=" fab fa-whatsapp mr-2"></i> WhatsApp</a>
                        <?php } ?>
            </form>
                </div>
        </div>
     </div>