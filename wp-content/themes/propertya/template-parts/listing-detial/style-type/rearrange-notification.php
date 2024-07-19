<?php
$property_id = get_the_ID();
$user_id = get_current_user_id();
global $propertya_options;
$media = propertya_framework_fetch_gallery_idz($property_id);
$selected_gallery = get_post_meta( $property_id, 'prop_gallery', true );
if (
    (get_post_field('post_author', $property_id) == $user_id || current_user_can('administrator')) &&
    get_post_meta($property_id, 'prop_status', true) == '1' &&
    is_array($media) && count($media) > 1) {  ?>
    <!-- Button trigger modal -->
    <div role="alert" class="alert alert-info alert-dismissible alert-outline">
        <!-- Button trigger modal -->
        <i class="fa fa-info-circle"></i>
        <button type="button" class="btn-transparent" data-toggle="modal" data-target="#sortable-images">
            <?php echo __('Rearrange the ad photos.', 'propertya');?>
        </button>
    </div>

    <?php
    global $propertya_options;
    $property_id	=	get_the_ID();
    $flip_it = 'text-left';
    if ( is_rtl() )
    {
        $flip_it = 'text-right';
    }
    ?>
    <!-- Modal -->
    <div class="modal fade sortable-images" id="sortable-images" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content <?php echo esc_attr( $flip_it ); ?>">
                <div class="modal-header">
                    <div class="modal-title"><?php echo __('Re-arrange your ad photo(s).','propertya'); ?></div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body <?php echo esc_attr( $flip_it ); ?>">
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <em><small><?php echo __('*First image will be main display image of this ad.','propertya'); ?></small></em>
                            <span id="selected_imgz_html_render"><?php echo propertya_framework_prop_gallery($selected_gallery,$property_id);?></span>
                            <input id="selected_imgz_idz" type="hidden" name="selected_imgz_idz" <?php if($propertya_options['prop_required_fields']['gallery'] == 1) {  ?> data-validation="required" data-validation-error-msg-required="<?php echo propertya_strings('prop_req_gallery'); ?>" <?php } ?> value="<?php echo esc_attr($selected_gallery); ?>" />
                            <input type="hidden" id="current_pid" value="<?php echo esc_attr( $property_id ); ?>" />
                            <input type="hidden" id="re-arrange-msg" value="<?php echo __( 'Ad photos has been re-arranged.', 'propertya' ); ?>" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-theme btn-block sonu-button" value="<?php echo __('Re-arrange','propertya' ); ?>" id="sb_sort_images" />
                </div>
            </div>
        </div>
    </div>
<?php } ?>