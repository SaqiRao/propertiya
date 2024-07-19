<?php 
        $property_id    =       get_the_ID();
        $localization   =   propertya_localization();
?>
<div class="widget-seprator short-detail">
        <div class="widget-seprator-heading">
                <h3 class="sec-title"><i class="fas fa-align-left"></i><?php echo esc_html(propertya_strings('prop_details')); ?></h3>
        <span class="last-updated right-side"><strong><?php echo esc_html__('Last Updated On','propertya') ?>: </strong><span><?php the_modified_time('F jS, Y'); ?> <?php echo esc_html__('at','propertya') ?> <?php the_modified_time('g:i a'); ?></span></span>
        </div>
    <div class="listing-specs">
        <div class="row">
                <?php if(isset($property_id) && $property_id!="") { 
                        $selected_reference = propertya_framework_get_options('property_opt_id');
                        if(isset($selected_reference) && $selected_reference !="")
                        {
                                $updated_id = preg_replace( '/{ID}/', $property_id, $selected_reference );
                                update_post_meta($property_id, 'prop_refer', sanitize_text_field($updated_id));
                        }
                        else
                        {
                                update_post_meta($property_id, 'prop_refer', $property_id);
                        }
                }?>
                <?php if(get_post_meta($property_id, 'prop_refer', true ) !="") { ?>
            <div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 col-12">
                    <div class="detail-type"><strong><?php echo esc_html($localization['prop_id']); ?>:</strong><?php echo get_post_meta($property_id, 'prop_refer', true ); ?> </div>
            </div>
            <?php } if(get_post_meta($property_id, 'prop_offer_type', true ) !="") {
                                $offer_type   = get_post_meta( $property_id, 'prop_offer_type', true );
                                $type_term    = propertya_get_term($offer_type,'property_status');
                                $color = '';
                        ?>
            <div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 col-12">
                    <div class="detail-type"><strong><?php echo esc_html($localization['offer_type']); ?>:</strong><a  href="<?php echo esc_url(get_term_link($type_term->term_id)); ?>"><?php echo esc_html($type_term->name); ?></a></div>
            </div>
            <?php } if(get_post_meta($property_id, 'prop_type', true ) !="") {
                                $prop_type   = get_post_meta( $property_id, 'prop_type', true );
                                $type_term    = propertya_get_term($prop_type,'property_type');
                        ?>
            <div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 col-12">
                    <div class="detail-type"><strong><?php echo esc_html($localization['property_type']); ?>:</strong><a href="<?php echo esc_url(get_term_link($type_term->slug, 'property_type')); ?>"><?php echo esc_html($type_term->name); ?></a></div>
            </div>
            <?php }
                             $get_all_prices = '';
                                 $get_all_prices = propertya_framework_fetch_price($property_id);
                                 if(is_array($get_all_prices) && count($get_all_prices) > 0 && array_key_exists("main_price",$get_all_prices))
                                 {
                                          $selected_pricelabel_after = '';
                                         if (array_key_exists("after_prefix",$get_all_prices))
                                     {
                                           $selected_pricelabel_after = $get_all_prices['after_prefix'];
                                     }
                         ?>
            <div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 col-12">
                    <div class="detail-type"><strong><?php echo esc_html($localization['price']); ?>:</strong> <?php echo esc_html($get_all_prices['main_price']). $selected_pricelabel_after; ?> </div>
            </div>
            <?php } if(get_post_meta($property_id,'prop_currecny_type', true )!="")
                        {
                                 $selected_currency = $selected_symbol =  $selected_currency = $term_id = '';
                                 $selected_currency = get_post_meta($property_id, 'prop_currecny_type', true );
                                 $term_id = propertya_framework_get_slug_id($selected_currency,'property_currency'); 
                                 if(get_term_meta($term_id, 'p_currency_sym', true ) !="" && get_term_meta($term_id, 'p_currency_code', true ) !="")
                                 {
                                        $selected_currency = get_term_meta($term_id, 'p_currency_sym', true );
                                        $selected_symbol = get_term_meta($term_id, 'p_currency_code', true );
                         ?>
            <div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 col-12">
                    <div class="detail-type"><strong><?php echo esc_html($localization['currecny_type']); ?>:</strong><?php echo esc_html($selected_symbol .' ' . '(' . $selected_currency . ')'); ?></div>
            </div>
            <?php }} if(get_post_meta($property_id,'prop_beds_qty', true )!=""){ ?>
            <div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 col-12">
                    <div class="detail-type"><strong><?php echo esc_html($localization['bedrooms']); ?>:</strong><?php echo esc_html(get_post_meta($property_id,'prop_beds_qty', true )); ?></div>
            </div>
            <?php } if(get_post_meta($property_id,'prop_baths_qty', true )!=""){ ?>
            <div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 col-12">
                    <div class="detail-type"><strong><?php echo esc_html($localization['bathrooms']); ?>:</strong><?php echo esc_html(get_post_meta($property_id,'prop_baths_qty', true )); ?></div>
            </div>
            <?php } if(get_post_meta($property_id,'prop_garage_qty', true )!=""){ ?>
            <div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 col-12">
                    <div class="detail-type"><strong><?php echo esc_html($localization['grages']); ?>:</strong><?php echo esc_html(get_post_meta($property_id,'prop_garage_qty', true )); ?></div>
            </div>
            <?php } if(get_post_meta($property_id,'prop_year_build', true )!=""){ ?>
            <div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 col-12">
                    <div class="detail-type"><strong><?php echo esc_html($localization['yearbuild']); ?>:</strong><?php echo esc_html(get_post_meta($property_id,'prop_year_build', true )); ?></div>
            </div>
            <?php } if(get_post_meta($property_id,'prop_area_size', true )!=""){
                                $area_prefix = $area ='';
                                $area = number_format(get_post_meta($property_id,'prop_area_size', true ));
                                $area_prefix = get_post_meta($property_id,'prop_area_prefix', true );
                        ?>
            <div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 col-12">
                    <div class="detail-type"><strong><?php echo esc_html($localization['prop_size']); ?>:</strong><?php echo esc_html($area.' '.$area_prefix); ?></div>
            </div>
           <?php } if(get_post_meta($property_id,'prop_land_size', true )!=""){
                                $prop_land_prefix = $prop_land_size ='';
                                $prop_land_size = number_format(get_post_meta($property_id,'prop_land_size', true ));
                                $prop_land_prefix = get_post_meta($property_id,'prop_land_prefix', true );
                        ?>
            <div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 col-12">
                    <div class="detail-type"><strong><?php echo esc_html($localization['land_area']); ?>:</strong><?php echo esc_html($prop_land_size.' '.$prop_land_prefix); ?></div>
            </div>
            <?php }  ?>
       </div>
   </div>
</div>