<?php $localization = propertya_localization();?>
<div class="modal fade" id="check_userrole" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="modal-from new-my-pass" name="myuser_type" method="POST" id="myuser_type">
        <div class="modal-header">
          <h3 class="modal-title"><?php echo esc_html__('Select User Type', 'propertya'); ?></h3>
        </div>
        <div class="modal-body">
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
        <div class="theme-row">
                 <label><?php echo esc_html($localization['display_name']); ?>  <i class="far fa-question-circle" data-toggle="popover" data-placement="top" data-content="<?php echo esc_attr($localization['displayname_popover']); ?>"></i></label>
                 <span class="wrap">
                 <input type="text" autocomplete="off" data-sanitize="trim" name="displayname" class="form-control text" data-validation="required" data-validation-error-msg-required="<?php echo esc_attr($localization['all_fields_error']); ?>">
                 </span> 
              </div>        
           <span class="theme-txt"><?php echo __("<strong>Note:</strong> Please choose your type accordingly because you can't change your type after selection.", 'propertya'); ?></span>
        </div>
        <div class="modal-footer">
          <?php wp_nonce_field( 'prop-usertype-nonce', 'usertype_nonce' ); ?>
          <button type="submit" class="btn btn-theme btn-role" data-spinner-text="<?php echo esc_attr($localization['processing']); ?>"><?php echo esc_html__("Select Type", 'propertya'); ?></button>
        </div>
      </form>
    </div>
  </div>
</div>