<?php
 $localization = propertya_localization();
?>
<div class="modal fade" id="mynewpass">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="modal-from new-my-pass" name="mynewPass" method="POST" id="mynewPass">
        <div class="modal-header">
          <h3 class="modal-title"><?php echo esc_html__('Reset Your Password', 'propertya'); ?></h3>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="theme-row">
            <label><?php echo esc_html($localization['new_pass']); ?><span class="req-mark">*</span></label>
            <span class="wrap">
            <input type="password" autocomplete="off" data-sanitize="trim" data-validation="length" data-validation-length="3-12" data-validation-error-msg="<?php echo esc_attr($localization['pass_required']); ?>" name="password" class="form-control text">
            </span> </div>
        </div>
        <div class="modal-footer">
          <?php wp_nonce_field( 'prop-new-nonce', 'pass_nonce' ); ?>
          <input type="hidden" name="requested_user_id" value="">
          <button type="submit" class="btn btn-theme btn-reset-new" data-spinner-text="<?php echo esc_attr($localization['processing']); ?>"><?php echo esc_html__("Change My Password", 'propertya'); ?></button>
        </div>
      </form>
    </div>
  </div>
</div>