<?php
class real_property_submission {
  public function __construct() {
    if ( is_admin() ) {
      add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
      add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
    }
  }
  public function init_metabox() {
    add_action( 'add_meta_boxes',        array( $this, 'propertya_framework_property_add_metabox'));
    add_action( 'save_post',             array( $this, 'propertya_framework_property_save_metabox' ), 10, 2 );
    add_action( 'admin_enqueue_scripts', array( $this, 'propertya_framework_property_load_scripts_styles' ) );
    add_action( 'admin_footer',          array( $this, 'propertya_framework_property_add_admin_js' )        );
  }
  public function propertya_framework_property_add_metabox() {
    add_meta_box(
      'prop_meta_fields',
      esc_html__( 'Property', 'propertya-framework' ),
      array( $this, 'propertya_framework_render_metabox' ),
      'property',
      'advanced',
      'default'
    );
  }
  public function propertya_framework_render_metabox( $post )
  {
    wp_nonce_field( 'property_nonce_action', 'property_nonce' );
    $options = $custom_currency = $meta_html = $meta = '';
    // Retrieve an existing value from the database.
    $selected_type = get_post_meta( $post->ID, 'prop_type', true );
    $selected_offer_type = get_post_meta( $post->ID, 'prop_offer_type', true );
    $selected_offer_label = get_post_meta( $post->ID, 'prop_offer_label', true );
    $selected_currency = get_post_meta( $post->ID, 'prop_currecny_type', true );
    $selected_price = get_post_meta( $post->ID, 'prop_first_price', true );
    $selected_price_optional = get_post_meta( $post->ID, 'prop_second_price', true );
    $selected_pricelabel_before = get_post_meta( $post->ID, 'prop_pricelabel_before', true );
    $selected_pricelabel_after = get_post_meta( $post->ID, 'prop_pricelabel_after', true );
    $selected_area_size = get_post_meta( $post->ID, 'prop_area_size', true );
    $selected_area_prefix = get_post_meta( $post->ID, 'prop_area_prefix', true );
    $selected_land_area = get_post_meta( $post->ID, 'prop_land_size', true );
    $selected_land_prefix = get_post_meta( $post->ID, 'prop_land_prefix', true );
    $selected_beds = get_post_meta( $post->ID, 'prop_beds_qty', true );
    $selected_baths = get_post_meta( $post->ID, 'prop_baths_qty', true );
    $selected_garages = get_post_meta( $post->ID, 'prop_garage_qty', true );
    $selected_years = get_post_meta( $post->ID, 'prop_year_build', true );
    $selected_address = get_post_meta( $post->ID, 'prop_street_addr', true );
    $selected_latt = get_post_meta( $post->ID, 'prop_latt', true );
    $selected_long = get_post_meta( $post->ID, 'prop_long', true );

    $selected_gallery = get_post_meta( $post->ID, 'prop_gallery', true );

    $selected_reference = propertya_framework_get_options('property_opt_id');
    if(get_post_meta( $post->ID, 'prop_refer', true ) !="")
    {
      $selected_reference = get_post_meta( $post->ID, 'prop_refer', true );
    }
    $selected_zipcode = get_post_meta( $post->ID, 'prop_zip', true );
    $selected_viewtype = get_post_meta( $post->ID, 'prop_viewtype', true );
    //floor plans
    $selected_plan = get_post_meta( $post->ID, 'prop_is_plans', true );
    $selected_floor_plans = get_post_meta( $post->ID, 'prop_floor_plans', true );
    //additional fields
    $selected_fields = get_post_meta( $post->ID, 'prop_is_additional_fields', true );
    $selected_fields_data = get_post_meta( $post->ID, 'prop_add_fields', true );
    //attachments
    $selected_attachments = get_post_meta( $post->ID, 'prop_attachments', true );
    //video & 360
    $selected_video = get_post_meta( $post->ID, 'prop_video', true );
    $selected_tour = get_post_meta( $post->ID, 'prop_virtual_tour', true );
    $selected_location = get_post_meta( $post->ID, 'prop_loc', true );
        $agent_property = get_post_meta( $post->ID, 'agent_property_id', true );
    
    // Set default values.
    if( empty( $custom_ ) ) $custom_ = '';
    if( empty( $selected_type ) ) $selected_type = '';
    if( empty( $selected_offer_type ) ) $selected_offer_type = '';
    if( empty( $selected_offer_label ) ) $selected_offer_label = '';
    if( empty( $selected_currency ) ) $selected_currency = '';
    if( empty( $selected_price ) ) $selected_price = '';
    if( empty( $selected_price_optional ) ) $selected_price_optional = '';
    if( empty( $selected_pricelabel_before ) ) $selected_pricelabel_before = '';
    if( empty( $selected_pricelabel_after ) ) $selected_pricelabel_after = '';
    if( empty( $selected_area_size ) ) $selected_area_size = '';
    if( empty( $selected_area_prefix ) ) $selected_area_prefix = '';
    if( empty( $selected_land_area ) ) $selected_land_area = '';
    if( empty( $selected_land_prefix ) ) $selected_land_prefix = '';
    if( empty( $selected_beds ) ) $selected_beds = '';
    if( empty( $selected_baths ) ) $selected_baths = '';
    if( empty( $selected_garages ) ) $selected_garages = '';
    if( empty( $selected_years ) ) $selected_years = '';
    if( empty( $selected_address ) ) $selected_address = '';
    if( empty( $selected_latt ) ) $selected_latt = '';
    if( empty( $selected_long ) ) $selected_long = '';
    if( empty( $selected_gallery ) ) $selected_gallery = '';
    if( empty( $selected_zipcode ) ) $selected_zipcode = '';
    if( empty( $selected_viewtype ) ) $selected_viewtype = '';
    if( empty( $selected_plan ) ) $selected_plan = '';
    if( empty( $selected_floor_plans ) ) $selected_floor_plans = '';
    if( empty( $selected_fields ) ) $selected_fields = '';
    if( empty( $selected_fields_data ) ) $selected_fields_data = '';
    if( empty( $selected_attachments ) ) $selected_attachments = '';
    if( empty( $selected_video ) ) $selected_video = '';
    if( empty( $selected_tour ) ) $selected_tour = '';
    if( empty( $selected_location ) ) $selected_location = '';
        if( empty($agent_property) ) $agent_property = '';
    if(class_exists('ACF'))
        {
            $selected_custom_data = propertya_framework_fields_by_listing_id($post->ID);
            if(is_array($selected_custom_data))
            {
                $cust_display = '';
                $fetch_custom_data = $selected_custom_data;
            }
        }

 if ($selected_gallery == "")
             {

              $selected_gallery1 = 1603;
              $selected_gallery_feature = get_post_thumbnail_id( $post );
   
                
               if($selected_gallery_feature != "" && $selected_gallery_feature != 0 ){

                $selected_gallery = $selected_gallery_feature . "," . $selected_gallery1;
                }

                else {
                 
                // $selected_gallery =  $selected_gallery1;


                }
                
                update_post_meta( $post->ID, 'prop_gallery', $selected_gallery);
                $selected_gallery = get_post_meta( $post->ID, 'prop_gallery',true);
             } 
//get currency
$selected_cur = '';
$custom_currency = propertya_framework_term_fetch('property_currency',0);
if(!empty($custom_currency) && count((array) $custom_currency) > 0 && !is_wp_error($custom_currency))
{
  $p_currency_sym = $p_currency_code = $options = '';
  foreach($custom_currency as $currency)
  {
    $selected_cur = '';
    if(!empty($selected_currency) && $selected_currency == $currency->slug)
    {
      $selected_cur = 'selected="selected"';
    }
    if(get_term_meta( $currency->term_id, 'p_currency_code', true ) !="")
    {
      $p_currency_code = get_term_meta( $currency->term_id, 'p_currency_code', true );
        $p_currency_sym = get_term_meta( $currency->term_id, 'p_currency_sym', true );
      $options .= '<option value="' . $currency->slug. '" '.$selected_cur.'>' . $p_currency_code .' ( ' . $p_currency_sym . ' )'. '</option>';
    }
    else
    {
      $options .= '<option value="' . $currency->slug. '" '.$selected_cur.'>' . $currency->name . '</option>';
    }
  }
}


?>

<div id="tabs">
    <ul>
        <li>
            <a href="#gi"><i class="dashicons-admin-home dashicons"></i> <?php echo esc_html__('General Information','propertya-framework');?></a>
        </li>
        <li>
            <a href="#b"><i class="dashicons-location dashicons"></i> <?php echo esc_html__('Map Settings','propertya-framework');?> </a>
        </li>
        <li>
            <a href="#p_gallery"><i class="dashicons-format-gallery dashicons"></i> <?php echo esc_html__('Property Gallery','propertya-framework');?></a>
        </li>
        <li>
            <a href="#p_settings"><i class=" dashicons-admin-settings dashicons"></i> <?php echo esc_html__('Property Settings','propertya-framework');?></a>
        </li>
        <li>
            <a href="#f_p"><i class=" dashicons-menu dashicons"></i> <?php echo esc_html__('Floor Plans','propertya-framework');?></a>
        </li>
        <li>
            <a href="#additional_fields"><i class="dashicons-plus dashicons"></i> <?php echo esc_html__('Additional Fields','propertya-framework');?></a>
        </li>
        <li>
            <a href="#additional_attachments"><i class="dashicons-images-alt2 dashicons"></i> <?php echo esc_html__('Attachments','propertya-framework');?></a>
        </li>
        <li>
            <a href="#p_video"><i class="dashicons-video-alt3 dashicons"></i> <?php echo esc_html__('Property Video','propertya-framework');?></a>
        </li>
       
    </ul>
  <div class="tabz-content">
    <div id="gi">
       <div class="row">
        <div class="col-6">
         <div class="form-group">
           <label><?php echo esc_html__('Property Type','propertya-framework');?></label>
           <select class="custom-fields" name="property-type" data-placeholder="<?php echo esc_attr__('Property Type','propertya-framework');?>">
              <?php propertya_framework_terms_options('property_type' , $selected_type); ?>
      </select>
        </div>
        </div>
        <div class="col-6">
           <div class="form-group">
             <label><?php echo esc_html__('Offer Type','propertya-framework');?></label>
             <select class="custom-fields" name="offer-type" data-placeholder="<?php echo esc_attr__('Offer Type','propertya-framework');?>">
              <?php propertya_framework_terms_options('property_status' , $selected_offer_type); ?>
      </select>
        </div>
        </div>
                <div class="col-6">
         <div class="form-group">
           <label><?php echo esc_html__('Label','propertya-framework');?></label>
           <select class="custom-fields" name="label-type" data-placeholder="<?php echo esc_attr__('Select Label','propertya-framework');?>">
             <?php propertya_framework_terms_options('property_label' , $selected_offer_label); ?>
      </select>
        </div>
        </div>
        <div class="col-6">
         <div class="form-group">
           <label><?php echo esc_html__('Currency Type','propertya-framework');?></label>
           <select class="custom-fields" name="currency-type" data-placeholder="<?php echo esc_attr__('Select Currency','propertya-framework');?>">
           <option value=""><?php echo esc_html__('Select an option','propertya-framework'); ?></option>
             <?php echo ($options); ?>
       </select>
       </div>
        </div>
        <div class="col-6">
           <div class="form-group">
           <label><?php echo esc_html__('Sale or Rent Price ( Only digits )','propertya-framework');?></label>
           <input type="text" class="admin-inputs" name="first-price" value="<?php echo esc_attr($selected_price); ?>">
        <p><?php echo esc_html__('Eg: 75000','propertya-framework');?></p>
        </div>
        </div>
        <div class="col-6">
           <div class="form-group">
           <label><?php echo esc_html__('Second Price (Optional)','propertya-framework');?></label>
           <input type="text" name="second-price-opt" class="admin-inputs" value="<?php echo esc_attr($selected_price_optional); ?>">
           <p><?php echo esc_html__('Eg: 3500','propertya-framework');?></p>
         </div>
        </div>
        <div class="col-6">
           <div class="form-group">
           <label><?php echo esc_html__('After Price Label','propertya-framework');?></label>
           <input type="text" name="after-price-lbl" class="admin-inputs" value="<?php echo esc_attr($selected_pricelabel_after); ?>">
            <p><?php echo esc_html__('Eg: Per Month','propertya-framework');?></p>
        </div>
        </div>
        <div class="col-6">
           <div class="form-group">
           <label><?php echo esc_html__('Area Size ( Only digits )','propertya-framework');?></label>
           <input type="text" name="area-size" class="admin-inputs"  value="<?php echo esc_attr($selected_area_size); ?>">
        <p><?php echo esc_html__('Eg: 2500','propertya-framework');?></p>
        </div>
        </div>
        <div class="col-6">
           <div class="form-group">
           <label> <?php echo esc_html__('Area Size Prefix','propertya-framework');?>  </label>
           <input type="text" name="area-unit" class="admin-inputs"  value="<?php echo esc_attr($selected_area_prefix); ?>">
           <p><?php echo esc_html__('Eg: Sq Ft','propertya-framework');?></p>
        </div>
        </div>
        <div class="clearfix"></div>
        
        <div class="col-6">
           <div class="form-group">
           <label><?php echo esc_html__('Land Area ( Only digits )','propertya-framework');?> </label>
           <input type="text" name="land-area-size" class="admin-inputs"  value="<?php echo esc_attr($selected_land_area); ?>">
        <p><?php echo esc_html__('Eg: 1300','propertya-framework');?></p>
        </div>
        </div>
        <div class="col-6">
           <div class="form-group">
            <label> <?php echo esc_html__('Land Area Prefix','propertya-framework');?>  </label>
            <input type="text" name="land-area-unit" class="admin-inputs"  value="<?php echo esc_attr($selected_land_prefix); ?>">
            <p><?php echo esc_html__('Eg: Sq Ft','propertya-framework');?></p>
        </div>
        </div>
        <div class="clearfix"></div>
    
        <div class="col-6">
           <div class="form-group">
           <label><?php echo esc_html__('Bedrooms','propertya-framework');?>  </label>
           <input type="text" class="admin-inputs" name="prop-beds"  value="<?php echo esc_attr($selected_beds); ?>">
        <p><?php echo esc_html__('Eg: 3','propertya-framework');?></p>
        </div>
        </div>
        <div class="col-6">
           <div class="form-group">
           <label ><?php echo esc_html__('Bathrooms','propertya-framework');?></label>
           <input type="text" class="admin-inputs" name="prop-baths"  value="<?php echo esc_attr($selected_baths); ?>">
        <p><?php echo esc_html__('Eg: 2','propertya-framework');?></p>
        </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-6">
           <div class="form-group">
           <label ><?php echo esc_html__('Garages','propertya-framework');?></label>
           <input type="text" class="admin-inputs" name="prop-grage"  value="<?php echo esc_attr($selected_garages); ?>">
           <p><?php echo esc_html__('Eg: 1','propertya-framework');?></p>
         </div>
        </div>
        <div class="col-6">
           <div class="form-group">
           <label><?php echo esc_html__('Year Built','propertya-framework');?></label>
           <input type="text" name="prop-build-year" class="admin-inputs prop-datepicker" data-min-view="months" data-view="months" data-date-format="MM yyyy"  value="<?php echo esc_attr($selected_years); ?>"  >
        </div>
        </div>
           <div class="clearfix"></div>
           <hr/>
       <div class="col-6">
           <div class="form-group">
               <label><?php echo esc_html__( 'Agents', 'propertya-framework' ) ?></label>
               <select class="custom-fields" name="agent-property" data-placeholder="<?php echo esc_attr__('Assign Agent','propertya-framework');?>">
                   <?php propertya_framework_show_allagents($agent_property); ?>
               </select>
           </div>
       </div>
        <div class="clearfix"></div>
    </div>
    </div>
    <div id="b">
       <div class="row">
       <div class="col-12">
         <div class="form-group">
           <label><?php echo esc_html__('Location','propertya-framework');?></label>
           <div class="get-loc">
           <input type="text" class="admin-inputs" id="property_address" name="property-address" value="<?php echo esc_attr($selected_address); ?>">
           <?php 
       if(!empty(propertya_framework_get_options('property_opt_enable_geo')) && !empty(propertya_framework_get_options('property_opt_api_settings')))
       {
       ?>
           <i class="detect-me dashicons dashicons-move"></i>
           <?php
       }
       ?>
           </div>
           <p><?php echo esc_html__('if donnot add address then map will not show on property detail page.','propertya-framework');?></p>
        </div>
        </div>
       <?php
      if(propertya_framework_get_options('property_opt_enable_map') == 1) { ?>
            <div class="col-12">
                 <div class="form-group">
                    <div id="property_map"></div>
                </div>
            </div>
        <?php
    }
    ?>
            <div class="col-6">
                <div class="form-group">
                    <label><?php echo esc_html__('Coordinates','propertya-framework');?>  </label>
                    <input type="text" class="admin-inputs" name="property-latt" id="property_latt" value="<?php echo esc_attr($selected_latt); ?>">
                    <p><?php echo esc_html__('Your location Latitude','propertya-framework');?></p>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="longitude">&nbsp;</label>
                    <input type="text" class="admin-inputs" name="property-long" id="property_long" value="<?php echo esc_attr($selected_long); ?>">
                    <p><?php echo esc_html__('Your location Longitude','propertya-framework');?></p>
                </div>
            </div>
        </div>
    </div>
  
    <div id="p_gallery">
       <div class="row">
        <div class="col-12">
         <div class="form-group">
             <label><?php echo esc_html__('Property Gallery','propertya-framework');?></label>
             <input id="selected_imgz_idz" type="hidden" name="selected_imgz_idz" value="<?php echo esc_attr($selected_gallery); ?>" />

             <span id="selected_imgz_html_render"><?php echo propertya_framework_prop_gallery($selected_gallery, $post->ID);?></span> <br>
             <input id="custom_gallery_btn" class="button button-primary button-large" type="button" value="<?php echo  esc_attr__( '+ Add Media', 'propertya-framework' ); ?>" />
             <p><?php echo esc_html__('Recommended Image Size is 750x450','propertya-framework');?></p>
           </div>
         </div>
        </div>   
    </div>
    <div id="p_settings">
        <div class="row">
          <div class="col-6">
                 <div class="form-group">
                   <label><?php echo esc_html__('Property Ref. No','propertya-framework');?></label>
                   <input type="text" class="admin-inputs" name="ref-id" readonly value="<?php echo esc_attr($selected_reference); ?>">
                   <p><?php echo esc_html__('Property ID will help to search property directly.','propertya-framework');?></p>
              </div>
             </div>
            <div class="col-6">
                 <div class="form-group">
                   <label><?php echo esc_html__('Zip or Postal Code','propertya-framework');?></label>
                   <input type="text" class="admin-inputs" name="prop-zip" value="<?php echo esc_attr($selected_zipcode); ?>">
                   <p><?php echo esc_html__('Your Zip code here.','propertya-framework');?></p>
              </div>
             </div>
              <div class="col-6">
                 <div class="form-group">
                 <label><?php echo esc_html__('Location','propertya-framework');?></label>
                  <select class="custom-fields" name="property-location" data-placeholder="<?php echo esc_attr__('Select Location','propertya-framework');?>">
               <?php propertya_framework_terms_options('property_location' , $selected_location) ?>
         </select>
            <p><?php echo esc_html__('Select your location','propertya-framework');?></p>
                 </div>
              </div>   
             
             <div class="col-6">
                 <div class="form-group">
                 <label><?php echo esc_html__('My Listing View?','propertya-framework');?></label>
                 <ul class="radio-list">
                     <li>
                         <label><input value="yes" type="radio" name="is-logged" <?php checked('yes',$selected_viewtype, true); ?>><?php echo esc_html__('Yes (Anyone can view my listing)','propertya-framework');?> </label>
                     </li>
                     <li>
                         <label><input value="no" type="radio" name="is-logged" <?php checked('no', $selected_viewtype, true); ?>><?php echo esc_html__('No (Only logged in user can can view)','propertya-framework');?></label>
                     </li>
                 </ul>
                 </div>
            </div>        
        </div>
    </div>
    <div id="f_p">
    <div class="col-12">
                 <div class="form-group">
                     <label><?php echo esc_html__('Floor Plans','propertya-framework');?></label>
                     <select id="is-plan" name="is-plan" class="custom-fields" data-placeholder="<?php echo esc_html__('Enable Floor Plans','propertya-framework');?>">
                          <option value="disabled" <?php echo $selected_plan == 'disabled' ? ' selected="selected"' : '';?>><?php echo esc_attr('Disabled','propertya-framework');?></option>
                          <option value="enabled" <?php echo $selected_plan == 'enabled' ? ' selected="selected"' : '';?>><?php echo esc_attr('Enabled','propertya-framework');?></option>
                    </select>
                    <p><?php echo __("Enable/Disable floor plans. <strong>Floor Plans will only shown when enabled.</strong>",'propertya-framework');?></p>
                 </div>
            </div>
        <div class="row wrapper" id="f_plans">
        <?php 
      $floor_plan_data = '';
      $floor_plan_data = json_decode( stripslashes( $selected_floor_plans) );
      if(!empty($floor_plan_data) && is_array($floor_plan_data) && count($floor_plan_data) > 0)
      {
        //$floor_plan_data = json_decode( stripslashes( $selected_floor_plans) );
        $check_length = 1;
        foreach($floor_plan_data as $plan)
        {
    ?>
               <div class="flor-plans" id="row<?php echo esc_attr($check_length); ?>">
                <div class="col-12">
                 <div class="form-group">
                   <label><?php echo esc_html__('Floor Name','propertya-framework');?></label>
                   <input type="text" class="admin-inputs" name="flr-name[]" value="<?php echo esc_attr($plan->prop_floor_name); ?>">
                    <p><?php echo esc_html__('Ground Floor','propertya-framework');?></p>
                 </div>
                </div>
                <div class="col-6">
                 <div class="form-group">
                   <label><label><?php echo esc_html__('Floor Price ( Only digits )','propertya-framework');?></label></label>
                   <input type="text" class="admin-inputs" name="flr-price[]" value="<?php echo esc_attr($plan->prop_floor_price); ?>">
                    <p><?php echo esc_html__('Eg: 2500','propertya-framework');?></p>
                 </div>
                </div>
                <div class="col-6">
                         <div class="form-group">
                           <label><?php echo esc_html__('Price Postfix','propertya-framework');?></label>
                           <input type="text" class="admin-inputs" name="flr-price-postfix[]" value="<?php echo esc_attr($plan->prop_floor_pprefix); ?>">
                            <p><?php echo esc_html__('Eg: Per Month','propertya-framework');?></p>
                         </div>
                        </div>
                <div class="col-6">
                 <div class="form-group">
                   <label><?php echo esc_html__('Floor Size ( Only digits )','propertya-framework');?></label>
                   <input type="text" class="admin-inputs"  name="flr-size[]" value="<?php echo esc_attr($plan->prop_floor_size); ?>">
                    <p><?php echo esc_html__('Eg: 1500','propertya-framework');?></p>
                 </div>
                </div>
                <div class="col-6">
                 <div class="form-group">
                   <label><?php echo esc_html__('Size Postfix','propertya-framework');?></label>
                   <input type="text" class="admin-inputs" name="flr-size-postfix[]" value="<?php echo esc_attr($plan->prop_floor_sprefix); ?>">
                    <p><?php echo esc_html__('Eg: Sq ft','propertya-framework');?></p>
                 </div>
                </div>
                <div class="col-6">
                 <div class="form-group">
                   <label><?php echo esc_html__('Bedrooms','propertya-framework');?></label>
                   <input type="text" class="admin-inputs" name="flr-beds[]" value="<?php echo esc_attr($plan->prop_floor_beds); ?>">
                    <p><?php echo esc_html__('Eg: 4','propertya-framework');?></p>
                 </div>
                </div>
                <div class="col-6">
                 <div class="form-group">
                   <label><?php echo esc_html__('Bathrooms','propertya-framework');?></label>
                   <input type="text" class="admin-inputs" name="flr-baths[]" value="<?php echo esc_attr($plan->prop_floor_baths); ?>">
                   <p><?php echo esc_html__('Eg: 2','propertya-framework');?></p>
                 </div>
                </div>
                <div class="col-12">
                 <div class="form-group">
                   <label><?php echo esc_html__('Description','propertya-framework');?></label>
                   <textarea cols="60" rows="3"  name="flr-desc[]"><?php echo esc_textarea($plan->prop_floor_desc); ?></textarea>
                 </div>
                </div>
                <div class="col-12">
                 <div class="form-group">
                   <label>Floor Plan Image</label>
                   <input class="button button-primary button-large floorplan_btn_click" type="button" data-activeplan="<?php echo esc_attr($check_length); ?>" value="<?php echo  esc_attr__( '+ Floor Image', 'propertya-framework' ); ?>" />
                   
                   <p>The recommended minimum width is 770px and height is flexible.</p>
                   <?php 
            $plan_images = $delete_btn = $img_url = $thumb = $plan_img_id = '';
           if(!empty($plan->prop_floor_img_id))
           {
             $plan_img_id = $plan->prop_floor_img_id;
             $thumb = wp_get_attachment_image_src($plan_img_id, 'medium');
             $img_url = esc_url($thumb[0]);
             $plan_images = '<div class="flr_pln_container rem_pln_container_'.$check_length.'"><span class="flp-del" data-imgplan="'.$check_length.'"><img id="'.$plan_img_id.'" src="'.$img_url.'" alt=""></span></div>';
           }
             ?>
                       <input  type="hidden" id="active_imgid_<?php echo esc_attr($check_length); ?>" name="floorplan_image_id[]" value="<?php echo esc_attr($plan_img_id); ?>" />
                       
                       <div id="plan_image_src_<?php echo esc_attr($check_length); ?>"><?php echo $plan_images; ?></div>
                 </div>
                 <input type="button" class="btn-admin btn-remove" value="DELETE " onclick="delete_row('row<?php echo($check_length);?>')">
      
                </div>
            </div>
        <?php  $check_length++;
        }
      }
      else
      {
      ?>
                <div class="flor-plans" id="row1">
                        <div class="col-12">
                         <div class="form-group">
                           <label><?php echo esc_html__('Floor Name','propertya-framework');?></label>
                           <input type="text" class="admin-inputs" name="flr-name[]">
                            <p><?php echo esc_html__('Ground Floor','propertya-framework');?></p>
                         </div>
                        </div>
                        <div class="col-6">
                         <div class="form-group">
                           <label><?php echo esc_html__('Floor Price ( Only digits )','propertya-framework');?></label>
                           <input type="text" class="admin-inputs" name="flr-price[]">
                            <p><?php echo esc_html__('Eg: 2500','propertya-framework');?></p>
                         </div>
                        </div>
                        <div class="col-6">
                                 <div class="form-group">
                                   <label><?php echo esc_html__('Price Postfix','propertya-framework');?></label>
                                   <input type="text" class="admin-inputs" name="flr-price-postfix[]" >
                                    <p><?php echo esc_html__('Eg: Per Month','propertya-framework');?></p>
                                 </div>
                                </div>
                        <div class="col-6">
                         <div class="form-group">
                           <label><?php echo esc_html__('Floor Size ( Only digits )','propertya-framework');?></label>
                           <input type="text" class="admin-inputs"  name="flr-size[]">
                            <p><?php echo esc_html__('Eg: 1500','propertya-framework');?></p>
                         </div>
                        </div>
                        <div class="col-6">
                         <div class="form-group">
                           <label><?php echo esc_html__('Size Postfix','propertya-framework');?></label>
                           <input type="text" class="admin-inputs" name="flr-size-postfix[]">
                            <p><?php echo esc_html__('Eg: Sq ft','propertya-framework');?></p>
                         </div>
                        </div>
                        <div class="col-6">
                         <div class="form-group">
                           <label><?php echo esc_html__('Bedrooms','propertya-framework');?></label>
                           <input type="text" class="admin-inputs" name="flr-beds[]">
                            <p><?php echo esc_html__('Eg: 4','propertya-framework');?></p>
                         </div>
                        </div>
                        <div class="col-6">
                         <div class="form-group">
                           <label><?php echo esc_html__('Bathrooms','propertya-framework');?></label>
                           <input type="text" class="admin-inputs" name="flr-baths[]">
                           <p><?php echo esc_html__('Eg: 2','propertya-framework');?></p>
                         </div>
                        </div>
                        <div class="col-12">
                         <div class="form-group">
                           <label><?php echo esc_html__('Description','propertya-framework');?></label>
                           <textarea cols="60" rows="3"  name="flr-desc[]"></textarea>
                         </div>
                        </div>
                        <div class="col-12">
                         <div class="form-group">
                           <label><?php echo esc_html__('Floor Plan Image','propertya-framework');?></label>
                           <input class="button button-primary button-large floorplan_btn_click" type="button" data-activeplan="1" value="<?php echo  esc_attr__( '+ Floor Image', 'propertya-framework' ); ?>">
                           <input type="hidden" id="active_imgid_1" name="floorplan_image_id[]" value="">
                           <p><?php echo esc_html__('The recommended minimum width is 770px and height is flexible.','propertya-framework');?></p>
                           <div id="plan_image_src_1"></div>
                         </div>
                        </div>
                    </div>
      <?php
      }
      ?>
        </div> 
       <input type="button" class="btn-admin btn-add " onclick="add_row();" value="<?php echo esc_attr__('+ Add More','propertya-framework');?>">
    </div>
    <div id="additional_fields">
                <div class="row">
                <div id="generate_fields">
                    <div class="col-12">
                         <div class="form-group">
                           <label><?php echo esc_html__('Additional Fields','propertya-framework');?></label>
                           <select class="custom-fields" name="addtional-fields" data-placeholder="<?php echo esc_html__('Enable Additional Fields','propertya-framework');?>" >
                              <option value="disabled" <?php echo $selected_fields == 'disabled' ? ' selected="selected"' : '';?>><?php echo esc_attr('Disabled','propertya-framework');?></option>
                              <option value="enabled" <?php echo $selected_fields == 'enabled' ? ' selected="selected"' : '';?>><?php echo esc_attr('Enabled','propertya-framework');?></option>
                        </select>
                        <p><?php echo __("Enable/Disable additional fields. <strong>Additional Fields will only shown when enabled.</strong>",'propertya-framework');?></p>
                         </div>
                        </div>
                        <?php
                        $fadd_fields_data = '';
                        $fadd_fields_data = json_decode( stripslashes($selected_fields_data));
                        if(!empty($fadd_fields_data) && is_array($fadd_fields_data) && count($fadd_fields_data) > 0)
                        {
                            $check_field_length = 1;
                            foreach($fadd_fields_data as $fields)
                            {
                        ?>
                        <div class="ad-fields" id="adf<?php echo esc_attr($check_field_length); ?>">   
                            <div class="col-6">
                                     <div class="form-group">
                                       <label><?php echo esc_html__('Title','propertya-framework');?></label>
                                       <input type="text" name="additiona-fields-title[]" class="admin-inputs" value="<?php echo esc_attr($fields->prop_add_key); ?>">
                                     </div>
                                    </div>
                            <div class="col-6">
                             <div class="form-group">
                               <label><?php echo esc_html__('Value','propertya-framework');?></label>
                               <input type="text" name="additiona-fields-value[]" class="admin-inputs" value="<?php echo esc_attr($fields->prop_add_val); ?>">
                             </div>
                            </div>
                            <button type="button" class="remove-field btn-danger btn-circle" onclick="delete_field_row('adf<?php echo($check_field_length);?>')"><i class="dashicons dashicons-no"></i></button>
                        </div>
                        <?php
                            $check_field_length++;
                            }
                        }
                        else
                        {
                        ?>
                        <div class="ad-fields" id="adf1">   
                            <div class="col-6">
                                     <div class="form-group">
                                       <label><?php echo esc_html__('Title','propertya-framework');?></label>
                                       <input type="text" name="additiona-fields-title[]" class="admin-inputs">
                                     </div>
                                    </div>
                            <div class="col-6">
                             <div class="form-group">
                               <label><?php echo esc_html__('Value','propertya-framework');?></label>
                               <input type="text" name="additiona-fields-value[]" class="admin-inputs">
                             </div>
                            </div>
                            <button type="button" class="remove-field btn-danger btn-circle" onclick="delete_field_row('adf1')"><i class="dashicons dashicons-no"></i></button>
                        </div>
                        <?php
                        }
                        ?>
                </div>
            </div>
            <input type="button" class="btn-admin btn-add" onclick="return add_fields();" value="<?php echo esc_attr__('+ Add More','propertya-framework');?>">
    </div>
    <div id="additional_attachments">
            <div class="row">
        <div class="col-12">
         <div class="form-group">
           <label><?php echo esc_html__('Attachments','propertya-framework');?></label>
           <input id="selected_attach_idz" type="hidden" name="selected_attach_idz" value="<?php echo esc_attr($selected_attachments); ?>" />
           <span id="selected_attach_html_render"><?php echo propertya_framework_prop_attachments($selected_attachments);?></span> <br>
           <input id="custom_attachment_btn" class="button button-primary button-large" type="button" value="<?php echo  esc_attr__( '+ Add Attachments', 'propertya-framework' ); ?>" />
                     <p><?php echo esc_html__('You can attach PDF files, Map images OR other documents to provide further details related to property.','propertya-framework');?></p>
           </div>
         </div>
        </div>
    </div>
    <div id="p_video">
        <div class="row">
             <div class="col-12">
                 <div class="form-group">
           <label><?php echo esc_html__('Video URL','propertya-framework');?></label>
           <input type="text" class="admin-inputs" name="video-url" value="<?php echo esc_url($selected_video); ?>">
            <p><?php echo esc_html__('Enter video link/url. Supported format: YouTube, Vimeo, SWF and MOV','propertya-framework');?></p>
            </div>
             </div>
             <div class="col-12">
                 <div class="form-group">
                 <label><?php echo esc_html__('360 Virtual Tour','propertya-framework');?>    </label>
                 <textarea cols="60" rows="3" name="virtual-tour"><?php echo ($selected_tour); ?></textarea>
               <p><?php echo esc_html__('Provide iframe embed code for the 360 virtual tour.','propertya-framework');?></p>
            </div>
             </div>
        </div>
    </div>                
  </div>
</div>
<?php
  }
  public function propertya_framework_property_save_metabox( $post_id, $post ) {
    // Add nonce for security and authentication.
    $nonce_name = ( isset($_POST['property_nonce']) ) ? $_POST['property_nonce'] : ' ';
    $nonce_action = 'property_nonce_action';
    $property_id = $post_id;
    // Check if a nonce is set.
    if ( ! isset( $nonce_name ) )
      return;

    // Check if a nonce is valid.
    if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) )
      return;

    // Check if the user has permissions to save data.
    if ( ! current_user_can( 'edit_post', $property_id ) )
      return;

    // Check if it's not an autosave.
    if ( wp_is_post_autosave( $property_id ) )
      return;

    // Check if it's not a revision.
    if ( wp_is_post_revision( $property_id ) )
      return;
        //assign listing to agent
        /*Make sure your data is set before trying to save it*/
        if (isset($_POST['agent-property']) && ($_POST['agent-property'] !='')){

         $post_author_id = get_post_field('post_author', $_POST['agent-property']);

            $my_post = array(
                'ID' => $property_id,
                'post_author' => $post_author_id,
                'post_type' => 'property',
            );
            /*unhook this function so it doesn't loop infinitely*/
            remove_action('save_post', array( $this, 'propertya_framework_property_save_metabox' ), 10, 2 );

            /*update the post, which calls save_post again*/
            wp_update_post($my_post);

            /*re-hook this function*/
            add_action('save_post', array( $this, 'propertya_framework_property_save_metabox' ), 10, 2 );
        }
    //sanatize fields
    $selected_type = isset( $_POST[ 'property-type' ] ) ? sanitize_text_field( $_POST[ 'property-type' ] ) : '';
    $selected_offer_type = isset( $_POST[ 'offer-type' ] ) ? sanitize_text_field( $_POST[ 'offer-type' ] ) : '';
    $selected_offer_label = isset( $_POST[ 'label-type' ] ) ? sanitize_text_field( $_POST[ 'label-type' ] ) : '';
    $selected_currency = isset( $_POST[ 'currency-type' ] ) ? sanitize_text_field( $_POST[ 'currency-type' ] ) : '';
    $selected_price = isset( $_POST[ 'first-price' ] ) ? sanitize_text_field( $_POST[ 'first-price' ] ) : '';
    $selected_price_optional = isset( $_POST[ 'second-price-opt' ] ) ? sanitize_text_field( $_POST[ 'second-price-opt' ] ) : '';
    $selected_pricelabel_before = isset( $_POST[ 'before-price-lbl' ] ) ? sanitize_text_field( $_POST[ 'before-price-lbl' ] ) : '';
    $selected_pricelabel_after = isset( $_POST[ 'after-price-lbl' ] ) ? sanitize_text_field( $_POST[ 'after-price-lbl' ] ) : '';
    $selected_area_size = isset( $_POST[ 'area-size' ] ) ? sanitize_text_field( $_POST[ 'area-size' ] ) : '';
    $selected_area_prefix = isset( $_POST[ 'area-unit' ] ) ? sanitize_text_field( $_POST[ 'area-unit' ] ) : '';
    $selected_land_area = isset( $_POST[ 'land-area-size' ] ) ? sanitize_text_field( $_POST[ 'land-area-size' ] ) : '';
    $selected_land_prefix = isset( $_POST[ 'land-area-unit' ] ) ? sanitize_text_field( $_POST[ 'land-area-unit' ] ) : '';
    $selected_beds = isset( $_POST[ 'prop-beds' ] ) ? sanitize_text_field( $_POST[ 'prop-beds' ] ) : '';
    $selected_baths = isset( $_POST[ 'prop-baths' ] ) ? sanitize_text_field( $_POST[ 'prop-baths' ] ) : '';
    $selected_garages = isset( $_POST[ 'prop-grage' ] ) ? sanitize_text_field( $_POST[ 'prop-grage' ] ) : '';
    $selected_years = isset( $_POST[ 'prop-build-year' ] ) ? sanitize_text_field( $_POST[ 'prop-build-year' ] ) : '';
    $selected_address = isset( $_POST[ 'property-address' ] ) ? sanitize_text_field( $_POST[ 'property-address' ] ) : '';
    $selected_latt = isset( $_POST[ 'property-latt' ] ) ? sanitize_text_field( $_POST[ 'property-latt' ] ) : '';
    $selected_long = isset( $_POST[ 'property-long' ] ) ? sanitize_text_field( $_POST[ 'property-long' ] ) : '';
        $selected_gallery1 = isset( $_POST[ 'selected_imgz_idz' ] ) ? sanitize_text_field( $_POST[ 'selected_imgz_idz' ] ) : '';
        $selected_gallery_feature = get_post_thumbnail_id( $post );


        if (str_contains($selected_gallery1, $selected_gallery_feature)) {
            $selected_gallery = isset( $_POST[ 'selected_imgz_idz' ] ) ? sanitize_text_field( $_POST[ 'selected_imgz_idz' ] ) : '';
        }else{

           if($selected_gallery_feature != "" && $selected_gallery_feature != 0 ){

            $selected_gallery = $selected_gallery_feature . "," . $selected_gallery1;
            }

            else {
             
             $selected_gallery =  $selected_gallery1;

            }
        }
if (isset($selected_gallery[0]) && $selected_gallery[0] === '0') {
                $selected_gallery = substr($selected_gallery, 2); // Remove the first character
           }
    $selected_reference = isset( $_POST[ 'ref-id' ] ) ? sanitize_text_field( $_POST[ 'ref-id' ] ) : '';
    $selected_zipcode = isset( $_POST[ 'prop-zip' ] ) ? sanitize_text_field( $_POST[ 'prop-zip' ] ) : '';
    $selected_viewtype = isset( $_POST[ 'is-logged' ] ) ? sanitize_text_field( $_POST[ 'is-logged' ] ) : 'yes';
    $selected_plan = isset( $_POST[ 'is-plan' ] ) ? sanitize_text_field( $_POST[ 'is-plan' ] ) : '';
    $selected_fields = isset( $_POST[ 'addtional-fields' ] ) ? sanitize_text_field( $_POST[ 'addtional-fields' ] ) : '';
    $selected_attachments = isset( $_POST[ 'selected_attach_idz' ] ) ? sanitize_text_field( $_POST[ 'selected_attach_idz' ] ) : '';
    $selected_video = isset( $_POST[ 'video-url' ] ) ? sanitize_text_field( $_POST[ 'video-url' ] ) : '';
    $selected_tour = isset( $_POST[ 'virtual-tour' ] ) ? ( $_POST[ 'virtual-tour' ] ) : '';
    $selected_location = isset( $_POST[ 'property-location' ] ) ? sanitize_text_field( $_POST[ 'property-location' ] ) : '';
        $agent_property = isset( $_POST[ 'agent-property' ] ) ? sanitize_text_field( $_POST[ 'agent-property' ] ) : '';
        // Update the meta field in the database.
    update_post_meta($property_id, 'prop_status', '1' );
        //package settings
        if(propertya_framework_get_options('prop_pkg_type') != '' && propertya_framework_get_options('prop_pkg_type') == 'per-listing')
        {
            if (get_post_meta($property_id, 'prop_payper_lisitng', true ) == "1"){}else
            {
                update_post_meta($property_id, 'prop_payper_lisitng', '0');
            }
        }
        else
        {
            update_post_meta($property_id, 'prop_payper_lisitng', '0');
        }
        if (get_post_meta($property_id, 'prop_is_feature_listing', true ) == "1")
        {
        }
        else
        {
            update_post_meta($property_id, 'prop_is_feature_listing', '0');
        }
    //type
    wp_set_object_terms($property_id, propertya_framework_get_ancestors($selected_type,'property_type'), 'property_type');
    update_post_meta($property_id, 'prop_type', $selected_type);
    //status
    wp_set_object_terms($property_id, $selected_offer_type, 'property_status');
    update_post_meta($property_id, 'prop_offer_type', $selected_offer_type);
    //labels
    wp_set_post_terms($property_id, $selected_offer_label, 'property_label');
    update_post_meta($property_id, 'prop_offer_label', $selected_offer_label);
    //currency
    wp_set_post_terms($property_id, $selected_currency, 'property_currency');
    update_post_meta($property_id, 'prop_currecny_type', $selected_currency);
    //price
    update_post_meta($property_id, 'prop_first_price', $selected_price);
    update_post_meta($property_id, 'prop_second_price', $selected_price_optional);
    update_post_meta($property_id, 'prop_pricelabel_before', $selected_pricelabel_before);
    update_post_meta($property_id, 'prop_pricelabel_after', $selected_pricelabel_after);
    //area
    update_post_meta($property_id, 'prop_area_size', $selected_area_size);
    update_post_meta($property_id, 'prop_area_prefix', $selected_area_prefix);
    //land
    update_post_meta($property_id, 'prop_land_size', $selected_land_area);
    update_post_meta($property_id, 'prop_land_prefix', $selected_land_prefix);
    //general
    update_post_meta($property_id, 'prop_beds_qty', $selected_beds);
    update_post_meta($property_id, 'prop_baths_qty', $selected_baths);
    update_post_meta($property_id, 'prop_garage_qty', $selected_garages);
    update_post_meta($property_id, 'prop_year_build', $selected_years);
    //maps & lat long
    update_post_meta($property_id, 'prop_street_addr', $selected_address);
    update_post_meta($property_id, 'prop_latt', $selected_latt);
    update_post_meta($property_id, 'prop_long', $selected_long);
    //gallery
    update_post_meta( $property_id, 'prop_gallery', $selected_gallery);
        update_post_meta($property_id, 'agent_property_id', $agent_property);
    //Property Reference ID & zipcode & logged in
    $selected_reference = '';
    if(isset($_POST['post_ID']) && $_POST['post_ID'] !="")
    {
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
    }
    update_post_meta( $property_id, 'prop_zip', $selected_zipcode);
    update_post_meta( $property_id, 'prop_viewtype', $selected_viewtype);
    //flor plans
    $plans = array();
    if(!empty($selected_plan) && $selected_plan == "enabled")
    {
      if(isset($_POST['flr-name']) && $_POST['flr-name'] != "")
      {
        for($i = 0; $i < count($_POST['flr-name']); $i++)
        {
          if(!empty($_POST['flr-name'][$i]))
          {
            $floor_name = isset( $_POST[ 'flr-name' ][$i] ) ? sanitize_text_field( $_POST[ 'flr-name' ][$i] ) : '';
            $floor_price = isset( $_POST[ 'flr-price' ][$i] ) ? sanitize_text_field( $_POST[ 'flr-price' ][$i] ) : '';
            $floor_pprefix = isset( $_POST[ 'flr-price-postfix' ][$i] ) ? sanitize_text_field( $_POST[ 'flr-price-postfix' ][$i] ) : '';
            $floor_size = isset( $_POST[ 'flr-size' ][$i] ) ? sanitize_text_field( $_POST[ 'flr-size' ][$i] ) : '';
            $floor_sprefix = isset( $_POST[ 'flr-size-postfix' ][$i] ) ? sanitize_text_field( $_POST[ 'flr-size-postfix' ][$i] ) : '';
            $floor_beds = isset( $_POST[ 'flr-beds' ][$i] ) ? sanitize_text_field( $_POST[ 'flr-beds' ][$i] ) : '';
            $floor_baths = isset( $_POST[ 'flr-baths' ][$i] ) ? sanitize_text_field( $_POST[ 'flr-baths' ][$i] ) : '';
            $floor_desc = isset( $_POST[ 'flr-desc' ][$i] ) ? sanitize_textarea_field( $_POST[ 'flr-desc' ][$i] ) : '';
            $floor_plan_image = isset( $_POST[ 'floorplan_image_id' ][$i] ) ? sanitize_text_field( $_POST[ 'floorplan_image_id' ][$i] ) : '';
            
            //plans array
            $plans[] = array(
              'prop_floor_name' => $floor_name,
              'prop_floor_price' => $floor_price,
              'prop_floor_pprefix' => $floor_pprefix,
              'prop_floor_size' => $floor_size,
              'prop_floor_sprefix' => $floor_sprefix,
              'prop_floor_beds' => $floor_beds,
              'prop_floor_baths' => $floor_baths,
              'prop_floor_desc' => $floor_desc,
              'prop_floor_img_id' => $floor_plan_image,
             );
          }
        }
        $final_plans_data = wp_json_encode($plans, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        update_post_meta($property_id, 'prop_is_plans', $selected_plan);
        update_post_meta($property_id, 'prop_floor_plans', $final_plans_data);
      }
      else
      {
        update_post_meta($property_id, 'prop_is_plans', 'disabled');
        update_post_meta($property_id, 'prop_floor_plans', '');
      }
    }
    else
    {
      update_post_meta($property_id, 'prop_is_plans', 'disabled');
    }
    //Additional fields
    $additional_plans = array();
    if(!empty($selected_fields) && $selected_fields == "enabled")
    {
      if(!empty($_POST['additiona-fields-title']) && !empty($_POST['additiona-fields-value']))
      {
        for($c = 0; $c < count($_POST['additiona-fields-title']); $c++)
        {
          $key = isset( $_POST[ 'additiona-fields-title' ][$c] ) ? sanitize_text_field( $_POST[ 'additiona-fields-title' ][$c] ) : '';
          $value = isset( $_POST[ 'additiona-fields-value' ][$c] ) ? sanitize_text_field( $_POST[ 'additiona-fields-value' ][$c] ) : '';
          $additional_plans[] = array(
            'prop_add_key' => $key,
            'prop_add_val' => $value,
          );
        }
        $final_additional_data = wp_json_encode($additional_plans, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        update_post_meta($property_id, 'prop_is_additional_fields', $selected_fields);
        update_post_meta($property_id, 'prop_add_fields', $final_additional_data);
      }
      else
      {
        update_post_meta($property_id, 'prop_is_additional_fields', 'disabled');
        update_post_meta($property_id, 'prop_add_fields', '');
      }
    }
    else
    {
      update_post_meta($property_id, 'prop_is_additional_fields', 'disabled');
    }
    //attachments
    update_post_meta( $property_id, 'prop_attachments', $selected_attachments);
    //video & 360
    update_post_meta( $property_id, 'prop_video', $selected_video);
    update_post_meta( $property_id, 'prop_virtual_tour', $selected_tour);
    //location
    wp_set_object_terms($property_id, propertya_framework_get_ancestors($selected_location,'property_location'), 'property_location');
    update_post_meta($property_id, 'prop_loc', $selected_location);
    

  }
  public function propertya_framework_property_load_scripts_styles() {
    
    if(propertya_framework_get_options('property_opt_enable_map') == 1)
    {
      if(!empty(propertya_framework_get_options('property_opt_map_selection')) && propertya_framework_get_options('property_opt_map_selection') == "open_street")
      {
        wp_enqueue_style( 'dwt_admin_leaflet',  SB_PLUGIN_URL .'libs/css/leaflet.css' );
        wp_enqueue_script( 'dwt_admin_leaflet_js',  SB_PLUGIN_URL . 'libs/js/leaflet.js', false, false, true );
        wp_enqueue_script( 'dwt_admin_leaflet_search',  SB_PLUGIN_URL . 'libs/js/leaflet-search.js', false, false, true );
      }
      if(!empty(propertya_framework_get_options('property_opt_map_selection')) && propertya_framework_get_options('property_opt_map_selection') == "google_map")
      {
        wp_enqueue_script( "google-map", "//maps.googleapis.com/maps/api/js?v=3&libraries=places&libraries=places&key=".propertya_strings('property_opt_gmap_api_key')."", false, false, true );
      }
    }
    wp_enqueue_style( "admin-datepicker", SB_PLUGIN_URL  . "libs/css/datepicker.min.css" );
    wp_enqueue_script( 'admin-datepicker',  SB_PLUGIN_URL . 'libs/js/datepicker.min.js', false, false, true );
    wp_enqueue_script( 'jquery-ui-tabs' );
  }
  public function propertya_framework_property_add_admin_js()
  {
  ?>
    <script type="text/javascript">
    function add_row()
    {
       $rowno=jQuery("#f_plans .flor-plans").length;
       $rowno=$rowno+1;
       jQuery("#f_plans").append('<div class="flor-plans" id="row'+$rowno+'"><div class="col-12"> <div class="form-group"> <label><?php echo esc_html__('Floor Name','propertya-framework');?></label> <input type="text" class="admin-inputs" name="flr-name[]"> <p><?php echo esc_html__('Ground Floor','propertya-framework');?></p></div></div><div class="col-6"> <div class="form-group"> <label><?php echo esc_html__('Floor Price ( Only digits )','propertya-framework');?></label> <input type="text" class="admin-inputs" name="flr-price[]"> <p><?php echo esc_html__('Eg: 2500','propertya-framework');?></p></div></div><div class="col-6"> <div class="form-group"> <label><?php echo esc_html__('Price Postfix','propertya-framework');?></label> <input type="text" class="admin-inputs" name="flr-price-postfix[]" > <p><?php echo esc_html__('Eg: Per Month','propertya-framework');?></p></div></div><div class="col-6"> <div class="form-group"> <label><?php echo esc_html__('Floor Size ( Only digits )','propertya-framework');?></label> <input type="text" class="admin-inputs" name="flr-size[]"> <p><?php echo esc_html__('Eg: 1500','propertya-framework');?></p></div></div><div class="col-6"> <div class="form-group"> <label><?php echo esc_html__('Size Postfix','propertya-framework');?></label> <input type="text" class="admin-inputs" name="flr-size-postfix[]"> <p><?php echo esc_html__('Eg: Sq ft','propertya-framework');?></p></div></div><div class="col-6"> <div class="form-group"> <label><?php echo esc_html__('Bedrooms','propertya-framework');?></label> <input type="text" class="admin-inputs" name="flr-beds[]"> <p><?php echo esc_html__('Eg: 4','propertya-framework');?></p></div></div><div class="col-6"> <div class="form-group"> <label><?php echo esc_html__('Bathrooms','propertya-framework');?></label> <input type="text" class="admin-inputs" name="flr-baths[]"> <p><?php echo esc_html__('Eg: 2','propertya-framework');?></p></div></div><div class="col-12"> <div class="form-group"> <label><?php echo esc_html__('Description','propertya-framework');?></label> <textarea cols="60" rows="3" name="flr-desc[]"></textarea> </div></div><div class="col-12"> <div class="form-group"><label><?php echo esc_html__('Floor Plan Image','propertya-framework');?></label><input class="button button-primary button-large floorplan_btn_click" type="button" data-activeplan="'+$rowno+'" value="<?php echo  esc_attr__( '+ Floor Image', 'propertya-framework' ); ?>"><input type="hidden" id="active_imgid_'+$rowno+'" name="floorplan_image_id[]" value=""><p><?php echo esc_html__('The recommended minimum width is 770px and height is flexible.','propertya-framework');?></p><div id="plan_image_src_'+$rowno+'"></div><input type="button" class="btn-admin btn-remove" value="DELETE" onclick=delete_row("row'+$rowno+'")></div></div>');
    }
    function delete_row(rowno)
    {
     jQuery('#'+rowno).remove();
    }
  
    function add_fields()
    {
       $fieldno=jQuery("#generate_fields .ad-fields").length;
       $fieldno = $fieldno+1;
       jQuery("#generate_fields ").append('<div class="ad-fields" id="adf'+$fieldno+'"><div class="col-6"> <div class="form-group"> <label><?php echo esc_html__('Title','propertya-framework');?></label> <input type="text" name="additiona-fields-title[]" class="admin-inputs"> </div></div><div class="col-6"> <div class="form-group"> <label><?php echo esc_html__('Value','propertya-framework');?></label> <input type="text" name="additiona-fields-value[]" class="admin-inputs"> </div></div><button type="button" class="remove-field btn-danger btn-circle" onclick=delete_field_row("adf'+$fieldno+'")><i class="dashicons dashicons-no"></i></button></div>');
    }
    function delete_field_row(fieldno)
    {
     jQuery('#'+fieldno).remove();
    }

      jQuery(document).ready(function($){
      "use strict";
      
      
      
      /*floor plan image*/
    var meta_floorplan_uploader;
    $(document.body).on('click', '.floorplan_btn_click', function(e){
        var active_click_id = $(this).attr("data-activeplan");  
                e.preventDefault();
                meta_floorplan_uploader = wp.media.frames.meta_floorplan_uploader = wp.media({
                        title: 'Select Floor Plan Images',
                        button: { text:  'Select Plan Image' },
                        library: { type: 'image' },
            multiple: false
                });
                meta_floorplan_uploader.on('select', function(){
                        var media_attachment = meta_floorplan_uploader.state().get('selection').first().toJSON();
            //console.log(media_attachment);
            var floorimageHTML = '';
                        $('#active_imgid_'+active_click_id).val(media_attachment.id);
            if (typeof media_attachment.sizes.thumbnail === 'undefined') {
                          //$('#plan_image_src_'+active_click_id).attr('src', media_attachment.url);
              floorimageHTML += '<div class="flr_pln_container rem_pln_container_'+active_click_id+'"><span class="flp-del" data-imgplan="'+active_click_id+'"><img id="'+media_attachment.id+'" src="'+media_attachment.url+'"></span></div>';
                        } else {
              //$('#plan_image_src_'+active_click_id).attr('src', media_attachment.sizes.thumbnail.url);
              floorimageHTML += '<div class="flr_pln_container rem_pln_container_'+active_click_id+'"><span class="flp-del" data-imgplan="'+active_click_id+'"><img id="'+media_attachment.id+'" src="'+ media_attachment.sizes.medium.url+'"></span></div>';
            }
            $("#plan_image_src_"+active_click_id).html(floorimageHTML);
            
                });
                meta_floorplan_uploader.open();
        });
    
    $(document.body).on('click', '.flp-del', function(event){
                event.preventDefault();
        var deleted_id = $(this).attr("data-imgplan");
                if (confirm('Are you sure you want to remove this image?')) {
            $('.rem_pln_container_'+deleted_id).remove();
               $('#active_imgid_'+deleted_id).val('');
                }
        });
        
      
      
      
      $('#tabs').tabs().addClass('ui-tabs-vertical ui-helper-clearfix');
      

      /*date picker*/
      $('.prop-datepicker').datepicker({
        language: {
        days: [admin_varible.Sunday, admin_varible.Monday, admin_varible.Tuesday, admin_varible.Wednesday, admin_varible.Thursday, admin_varible.Friday, admin_varible.Saturday],
        daysShort: [admin_varible.Sun, admin_varible.Mon, admin_varible.Tue, admin_varible.Wed, admin_varible.Thu, admin_varible.Fri, admin_varible.Sat],
        daysMin: [admin_varible.Su, admin_varible.Mo, admin_varible.Tu, admin_varible.We, admin_varible.Th, admin_varible.Fr, admin_varible.Sa],
        months: [admin_varible.January,admin_varible.February,admin_varible.March,admin_varible.April,admin_varible.May,admin_varible.June, admin_varible.July,admin_varible.August,admin_varible.September,admin_varible.October,admin_varible.November,admin_varible.December],
        monthsShort: [admin_varible.Jan, admin_varible.Feb, admin_varible.Mar, admin_varible.Apr, admin_varible.May, admin_varible.Jun, admin_varible.Jul, admin_varible.Aug, admin_varible.Sep, admin_varible.Oct, admin_varible.Nov, admin_varible.Dec],
        today: admin_varible.Today,
        clear: admin_varible.Clear,
      },
        timepicker: false
    });
      
      var chk_container =  document.getElementById('property_map');
      /*For geo api*/
      var ip_type =  admin_varible.is_geo_api;
      var goe_ip_type =  admin_varible.geo_api_type;
      if(typeof ip_type != 'undefined' && ip_type == 1 && goe_ip_type != 'undefined' && goe_ip_type != '')
      {
         $('.get-loc  i.detect-me').on('click', function(e) {
           e.preventDefault();
           if(goe_ip_type == "geo_ip")
           {
             $.getJSON('//geoip-db.com/json/geoip.php?jsonp=?') .done (function(location){
              $("#property_address").val(location.city + ", " + location.country_name );
              if(typeof document.getElementById('property_latt') != 'undefined')
              {
               document.getElementById('property_latt').value = location.latitude;
               document.getElementById('property_long').value = location.longitude;
              }
               if(admin_varible.is_map_enabled == 1  && admin_varible.map_type != ''  && admin_varible.map_type == 'open_street')
               {
                 mymap.setView(new L.LatLng(location.latitude, location.longitude), 13);
                 markerz.setLatLng([location.latitude, location.longitude]);
               }
               if(admin_varible.is_map_enabled == 1  && admin_varible.map_type != ''  && admin_varible.map_type == 'google_map')
               {
                  places_google_map(location.latitude,location.longitude);
               }
               $('.get-loc i.detect-me').fadeOut('slow');
            });
           }
           else
           {
                  $.get("//ipapi.co/json", function(location) {
                $("#property_address").val(location.city + ", " + location.country_name );
                document.getElementById('property_latt').value = location.latitude;
                document.getElementById('property_long').value = location.longitude;
                if(admin_varible.is_map_enabled == 1  && admin_varible.map_type != ''  && admin_varible.map_type == 'open_street')
                {
                 mymap.setView(new L.LatLng(location.latitude, location.longitude), 13);
                 markerz.setLatLng([location.latitude, location.longitude]);
                }
                if(admin_varible.is_map_enabled == 1  && admin_varible.map_type != ''  && admin_varible.map_type == 'google_map')
                {
                  places_google_map(location.latitude,location.longitude);
                }
                $('.get-loc i.detect-me').fadeOut('slow');
             }, "json");
           }
         });
       }  
      
      //alert(admin_varible.is_map_enabled);
      if (typeof(chk_container) != 'undefined' && chk_container != null && admin_varible.is_map_enabled == 1)
      {
        if($('#property_latt').val() !="" && $('#property_long').val())
        {
          var map_lat =  $('#property_latt').val();
          var map_long =  $('#property_long').val();
        }
        else
        {
          var map_lat =  admin_varible.map_latt;
          var map_long = admin_varible.map_long;
        }
        if(admin_varible.map_type == 'open_street')
        {
          var mymap = L.map(chk_container).setView([map_lat,map_long], 13);


$('a[href="#b"]').on( "click", function() {
 mymap.invalidateSize();
});
  
          L.tileLayer('//{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
          }).addTo(mymap);
          var custom_icon = L.icon({
            iconUrl: admin_varible.p_path+'libs/images/map-marker.png',
            iconSize: [50, 50],
              });
          var markerz = L.marker([map_lat,map_long],{draggable: true,icon: custom_icon}).addTo(mymap);
          var searchControl   = new L.Control.Search({
            url: '//nominatim.openstreetmap.org/search?format=json&q={s}',
            jsonpParam: 'json_callback',
            propertyName: 'display_name',
            propertyLoc: ['lat','lon'],
            marker: markerz,
            autoCollapse: true,
            autoType: true,
            minLength: 2,
            initial: false,
            collapsed: false
          });
          searchControl.on('search:locationfound', function(obj) {
            var lt  = obj.latlng + '';
            var res = lt.split( "LatLng(" );
            res = res[1].split( ")" );
            res = res[0].split( "," );
            document.getElementById('property_latt').value = res[0];
            document.getElementById('property_long').value = res[1];
          });
          mymap.addControl( searchControl );
          markerz.on('dragend', function (e) {
            document.getElementById('property_latt').value = markerz.getLatLng().lat;
            document.getElementById('property_long').value = markerz.getLatLng().lng;
          });
          
        }
        if(admin_varible.map_type == 'google_map')
        {
          google.maps.event.addDomListener(window, 'load', places_google_map(map_lat,map_long));
        }
      }
      function places_google_map(map_lat,map_long)
      {
        var map_center_positionr = new google.maps.LatLng(map_lat,map_long);
        var mapOptions = {
          zoom: 13,
          center: map_center_positionr,
          disableDefaultUI: false
        };
        var map = new google.maps.Map(chk_container, mapOptions);
        var get_markers = new google.maps.Marker({
          position: map_center_positionr,
          map: map,
          icon: admin_varible.p_path+'libs/images/map-marker.png',
          labelAnchor: new google.maps.Point(1, 1),
          draggable: true,
        });
        google.maps.event.addListener(get_markers, "mouseup", function (event) {
          var latitude = this.position.lat();
          var longitude = this.position.lng();
          $('#property_latt').val( this.position.lat() );
          $('#property_long').val( this.position.lng() );
        });
        var places_input =  document.getElementById('property_address');
        var autocomplete = new google.maps.places.Autocomplete(places_input);
        autocomplete.bindTo('bounds', map);
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
          var fetch_places = autocomplete.getPlace();
          //console.log(fetch_places);
          if (!fetch_places.geometry) {
            return;
          }
          if (fetch_places.geometry.viewport) {
            map.fitBounds(fetch_places.geometry.viewport);
          } else {
            map.setCenter(fetch_places.geometry.location);
            map.setZoom(13);
          }
          get_markers.setPosition(fetch_places.geometry.location);
          get_markers.setVisible(true);
          $('#property_latt').val( get_markers.getPosition().lat() );
          $('#property_long').val( get_markers.getPosition().lng() );
        });
      }

        
        
      
      
      /*property gallery here*/  
      var property_gallery_frame;
      $('#custom_gallery_btn').on('click', function(e){
      if ( property_gallery_frame ) {
          property_gallery_frame.open();
          return;
      }
      property_gallery_frame = wp.media.frames.property_gallery_frame = wp.media({
        title: admin_varible.select_imgz,
        library: { type: ['image/jpeg', 'image/png', 'image/gif'] },
        multiple: true
      });
      property_gallery_frame.states.add([
        new wp.media.controller.Library({
          library:    wp.media.query( property_gallery_frame.options.library ),
          multiple:   property_gallery_frame.options.multiple ? 'reset' : false,
          editable:   true,
          allowLocalEdits: true,
          displaySettings: true,
          displayUserSettings: true
        }),
      ]);
      var idsArray;
      var attachment;
      property_gallery_frame.on('open', function() {
        var selection = property_gallery_frame.state().get('selection');
        var library = property_gallery_frame.state('gallery-edit').get('library');
        var ids = $('#selected_imgz_idz').val();
        if (ids) {
          idsArray = ids.split(',');
          idsArray.forEach(function(id) {
            attachment = wp.media.attachment(id);
            attachment.fetch();
            selection.add( attachment ? [ attachment ] : [] );
          });
        }
      });
      var images;
      property_gallery_frame.on('select', function() {
      var imageIDArray = [];
      var imageHTML = '';
      var metadataString = '';
      images = property_gallery_frame.state().get('selection');
      imageHTML += '<ul class="custom-meta-gallery">';
      images.each(function(attachment) {
      console.debug(attachment.attributes);
      imageIDArray.push(attachment.attributes.id);
      if (typeof attachment.attributes.sizes.thumbnail === 'undefined') {
        imageHTML += '<li><div class="custom-meta-gallery_container"><span class="custom-gallery-del"><img id="'+attachment.attributes.id+'" src="'+attachment.attributes.url+' abc"></span></div></li>';
      }
      else
      {
        imageHTML += '<li><div class="custom-meta-gallery_container"><span class="custom-gallery-del"><img id="'+attachment.attributes.id+'" src="'+attachment.attributes.sizes.thumbnail.url+'"></span></div></li>';
      }
      });
      imageHTML += '</ul>';
      metadataString = imageIDArray.join(",");
      if (metadataString) {
        $("#selected_imgz_idz").val(metadataString);
        $("#selected_imgz_html_render").html(imageHTML);
        }
      });
      property_gallery_frame.open();
      });
    
      $(document.body).on('click', '.custom-gallery-del', function(e){
        e.preventDefault();
        if (confirm(admin_varible.img_del))
        {
          var removedImage = $(this).children('img').attr('id');
          var oldGallery = $("#selected_imgz_idz").val();
          var newGallery = oldGallery.replace(','+removedImage,'').replace(removedImage+',','').replace(removedImage,'');
          $(this).parents().eq(1).remove();
          $("#selected_imgz_idz").val(newGallery);
        }
      });
  
      /*For Attachments*/
        var property_attachment_frame;
      $('#custom_attachment_btn').on('click', function(e){
      if ( property_attachment_frame ) {
          property_attachment_frame.open();
          return;
      }
      property_attachment_frame = wp.media.frames.property_attachment_frame = wp.media({
          title: admin_varible.select_attachments,
          library: { type: ['application/pdf','image/jpeg', 'image/png', 'image/gif','application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document'] },
          multiple: true
      });
      property_attachment_frame.states.add([
        new wp.media.controller.Library({
          library:    wp.media.query( property_attachment_frame.options.library ),
          multiple:   property_attachment_frame.options.multiple ? 'reset' : false,
          editable:   true,
          allowLocalEdits: true,
          displaySettings: true,
          displayUserSettings: true
        }),
      ]);
      var idsArray_attac;
      var attachment;
      property_attachment_frame.on('open', function() {
        var selection = property_attachment_frame.state().get('selection');
        var library = property_attachment_frame.state('gallery-edit').get('library');
        var ids = $('#selected_attach_idz').val();
        if (ids) {
          idsArray_attac = ids.split(',');
          idsArray_attac.forEach(function(id) {
            attachment = wp.media.attachment(id);
            attachment.fetch();
            selection.add( attachment ? [ attachment ] : [] );
          });
        }
      });
      var attachment_img;
      property_attachment_frame.on('select', function() {
      var imageIDArray_attach = [];
      var imageHTML_attach = '';
      var metadataString_attach = '';
      attachment_img = property_attachment_frame.state().get('selection');
      imageHTML_attach += '<ul class="custom-meta-attachment">';
      attachment_img.each(function(attachment) {
      console.debug(attachment.attributes);
      imageIDArray_attach.push(attachment.attributes.id);
      if(attachment.attributes.type == 'application')
      {
        imageHTML_attach += '<li><div class="custom-meta-attachment_container"><div class="img-grid"><span class="custom-attach-del for-attach"><img id="'+attachment.attributes.id+'" src="'+attachment.attributes.icon+'"></span></div><div class="li-text"><p><strong data-name="title">'+attachment.attributes.title+'</strong></p><p><strong>File name:</strong><a data-name="filename" href="'+attachment.attributes.url+'" target="_blank">'+attachment.attributes.filename+'</a></p><p><strong>File size:</strong><span data-name="filesize">'+attachment.attributes.filesizeHumanReadable+'</span></p></div></li>';
      }
      else
      {
        if (typeof attachment.attributes.sizes.thumbnail === 'undefined') {
          imageHTML_attach += '<li><div class="custom-meta-attachment_container"><div class="img-grid"><span class="custom-attach-del"><img id="'+attachment.attributes.id+'" src="'+attachment.attributes.url+'"></span></div><div class="li-text"><p><strong data-name="title">'+attachment.attributes.title+'</strong></p><p><strong>File name:</strong><a data-name="filename" href="'+attachment.attributes.url+'" target="_blank">'+attachment.attributes.filename+'</a></p><p><strong>File size:</strong><span data-name="filesize">'+attachment.attributes.filesizeHumanReadable+'</span></p></div></li>';
        }
        else
        {
          imageHTML_attach += '<li><div class="custom-meta-attachment_container"><div class="img-grid"><span class="custom-attach-del"><img id="'+attachment.attributes.id+'" src="'+attachment.attributes.sizes.thumbnail.url+'"></span></div><div class="li-text"><p><strong data-name="title">'+attachment.attributes.title+'</strong></p><p><strong>File name:</strong><a data-name="filename" href="'+attachment.attributes.url+'" target="_blank">'+attachment.attributes.filename+'</a></p><p><strong>File size:</strong><span data-name="filesize">'+attachment.attributes.filesizeHumanReadable+'</span></p></div></li>';
        }
      }
      });
      imageHTML_attach += '</ul>';
      metadataString_attach = imageIDArray_attach.join(",");
      if (metadataString_attach) {
        $("#selected_attach_idz").val(metadataString_attach);
        $("#selected_attach_html_render").html(imageHTML_attach);
        }
      });
        property_attachment_frame.open();
      });
      $(document.body).on('click', '.custom-attach-del', function(e){
        e.preventDefault();
        if (confirm(admin_varible.img_del))
        {
          var removedImage_attach = $(this).attr("data-attach-id");
          var oldGallery_attach = $("#selected_attach_idz").val();
          var newGallery_attach = oldGallery_attach.replace(','+removedImage_attach,'').replace(removedImage_attach+',','').replace(removedImage_attach,'');
          $(this).parents().eq(2).remove();
          $("#selected_attach_idz").val(newGallery_attach);
        }
      });   
  });
    </script>
    <?php
  }
}

new real_property_submission;
// Custom fields to this post type
add_filter( 'manage_property_posts_columns', 'propertya_framework_edit_prop_table' );
function propertya_framework_edit_prop_table($columns) {
 
  unset( $columns['taxonomy-property_currency'] );
    unset( $columns['taxonomy-property_feature'] );
  unset( $columns['taxonomy-property_area_unit'] );
  unset( $columns['taxonomy-property_type'] );
  
  $columns['prop_ref'] = esc_html__( 'Ref. No', 'propertya-framework' );
  $columns['prop_type'] = esc_html__( 'Type', 'propertya-framework' );
    $columns['prop_price'] = esc_html__( 'Price', 'propertya-framework' );
  $columns['prop_curr'] = esc_html__( 'Currency', 'propertya-framework' );
  $columns['prop_thumb'] = esc_html__( 'Thumbnail', 'propertya-framework' );
  $columns['prop_exp'] = esc_html__( 'Expiry', 'propertya-framework' );
  $new = array();
  foreach($columns as $key => $title)
   {
        if($key=='title')
      {
        $new['prop_ref'] = esc_html__( 'Ref. No', 'propertya-framework' );
        $new['prop_thumb'] = esc_html__( 'Thumbnail', 'propertya-framework' );
      }
      if($key=='author')
      {
        $new['prop_type'] = esc_html__( 'Type', 'propertya-framework' );
        $new['prop_curr'] = esc_html__( 'Currency', 'propertya-framework' );
        $new['prop_price'] = esc_html__( 'Price', 'propertya-framework' );
      }
      if($key=='taxonomy-property_label')
      {
       $new['prop_exp'] = esc_html__( 'Expiry', 'propertya-framework' ); 
      }
      $new[$key] = $title;
     }
  
   return $new;
}

// Add the data to the custom columns for the post type:
add_action( 'manage_property_posts_custom_column' , 'propertya_framework_render_prop_table', 10, 2 );
function propertya_framework_render_prop_table( $column, $post_id ) {
        switch ( $column ) {
        case 'prop_price' :
     $selected_pricelabel_after = $optional_price  = $get_all_prices = '';
     $get_all_prices =  propertya_framework_fetch_price($post_id);
     if(count($get_all_prices) > 0 && array_key_exists("main_price",$get_all_prices))
     {
         if (array_key_exists("optional_price",$get_all_prices))
         {
           $optional_price = '<br>' . $get_all_prices['optional_price'];
         }
         if (array_key_exists("after_prefix",$get_all_prices))
         {
           $selected_pricelabel_after = $get_all_prices['after_prefix'];
         }
         echo '<strong>' . $get_all_prices['main_price'] .'</strong>' . $optional_price .  $selected_pricelabel_after.'';
     }
     break;
     case 'prop_thumb':
     $all_idz = '';
     $all_idz = propertya_framework_fetch_gallery_idz($post_id);
     echo '<img src="'.propertya_framework_img_src($all_idz,'thumbnail').'">';
     break;
     case 'prop_curr':
     $term_id = '';
     $selected_symbol =  $selected_currency = '';
     $selected_currency = get_post_meta( $post_id, 'prop_currecny_type', true );
     if(!empty($selected_currency)){
       $term_id = propertya_framework_get_slug_id($selected_currency,'property_currency'); 
       if(get_term_meta($term_id, 'p_currency_sym', true ) !="" && get_term_meta($term_id, 'p_currency_code', true ) !="")
       {
        $selected_currency = get_term_meta($term_id, 'p_currency_sym', true );
        $selected_symbol = get_term_meta($term_id, 'p_currency_code', true );
        echo $selected_symbol .' ' . '(' . $selected_currency . ')';
       }
     }
     break;
     case 'prop_ref':
     $selected_reference = $post_id;
     if(get_post_meta($post_id, 'prop_refer', true ) !="")
     {
      $selected_reference = get_post_meta($post_id, 'prop_refer', true );
     }
     echo esc_attr($selected_reference);
     break;
     case 'prop_type':
     if(get_post_meta($post_id, 'prop_type', true ) !="")
     {
      $fetch_name  = $prop_type = '';
      $prop_type = get_post_meta( $post_id, 'prop_type', true );
      $fetch_name  = get_term_by( 'slug', $prop_type, 'property_type');
      if(!empty($fetch_name))
      {
        echo $fetch_name->name;
      }
     }
     break;
     case 'prop_exp':
     echo propertya_framework_expiry_date_only($post_id);
     break;
    }
}

//Mark As Featured
class property_meta_boxes_for_featured {

    public function __construct() {
        if (is_admin()) {
            add_action('load-post.php', array($this, 'init_metabox1'));
            add_action('load-post-new.php', array($this, 'init_metabox1'));
        }
    }
    public function init_metabox1() {

        add_action('add_meta_boxes', array($this, 'add_metabox_featured'));
        add_action('save_post', array($this, 'save_metabox_featured'), 10, 2);
    }

    public function add_metabox_featured() {
        add_meta_box(
                'listing_mark_featured', __('Mark Listing As Featured', 'propertya-framework'), array($this, 'render_metabox_featured'), 'property', 'side', 'high'
        );
    }

    public function render_metabox_featured($post) {
        // Add nonce for security and authentication.
        wp_nonce_field('listing_nonce_action1', 'listing_nonce1');
        $property_id = $post->ID;
        $class_featured = 'none';
        $expiry_date = $author_id = '';
        $checkedz = 0;
        if (get_post_meta($property_id, 'prop_is_feature_listing', true) != "" && get_post_meta($property_id, 'prop_is_feature_listing', true) == 1) {
            $checkedz = 1;
            $class_featured = '';
        } else {
            $checkedz = 0;
        }
        $author_id = 1;
        $expiry_date = get_post_meta($property_id, 'prop_feature_listing_for', true);
        // Form fields.
        echo '<table class="form-table"><tr>
        <td>
        <p class="description">' . esc_html__('Do you want to make this listing as featured!', 'propertya-framework') . '</p>
        <ul class="admin-ul for-featured">
          <li>
            <input id="not" class="custom-checkbox"  name="make_listing_featured"  value="0"  ' . checked(0, $checkedz, false) . '  type="radio">
            <label for="not"> ' . esc_html__('No', 'propertya-framework') . '</label>
          </li>
          <li>
            <input id="open" class="custom-checkbox"  name="make_listing_featured" value="1" ' . checked(1, $checkedz, false) . '  type="radio">
            <label for="open"> ' . esc_html__('Yes', 'propertya-framework') . '</label>
          </li>
        </ul>
          <div id="featured-for" class="' . $class_featured . '">
            <label class="claimer_contact_label">' . esc_html__('Featured For', 'propertya-framework') . '</label><br><br>
            <input type="text" id="featured_for_days" value="' . $expiry_date . '" name="featured_for_days">
            <p class="description">' . esc_html__('Expiry in days, -1 means never expired.', 'propertya-framework') . '</p>
            <strong><p class="description">' . esc_html__('Eg 20.', 'propertya-framework') . '</p></strong>
          </div>
        </td>
      </tr>
    </table>';
    }

    public function save_metabox_featured($post_id, $post) {
        // Add nonce for security and authentication.
        $nonce_name = ( isset($_POST['listing_nonce1']) ) ? $_POST['listing_nonce1'] : ' ';
        $nonce_action = 'listing_nonce_action1';
        $property_id = $post_id;

        // Check if a nonce is set.
        if (!isset($nonce_name))
            return;

        // Check if a nonce is valid.
        if (!wp_verify_nonce($nonce_name, $nonce_action))
            return;

        // Check if the user has permissions to save data.
        if (!current_user_can('edit_post', $property_id))
            return;

        // Check if it's not an autosave.
        if (wp_is_post_autosave($property_id))
            return;

        // Check if it's not a revision.
        if (wp_is_post_revision($property_id))
            return;
        // Sanitize user input.
        $is_featurez = isset($_POST['make_listing_featured']) ? sanitize_text_field($_POST['make_listing_featured']) : '';
        $is_featurez_days = isset($_POST['featured_for_days']) ? sanitize_text_field($_POST['featured_for_days']) : '';
        if (!empty($is_featurez) && $is_featurez == 1 && $is_featurez_days != "")
        {
            if(isset($is_featurez_days) && $is_featurez_days !="" && $is_featurez_days !="0" && $is_featurez_days == '-1')
            {
                update_post_meta($property_id, 'prop_feature_listing_for', $is_featurez_days);
            }
            else
            {
               $now = date('Y-m-d');
               $date  = date_create($now);
               date_add($date,date_interval_create_from_date_string("$is_featurez_days days"));
               $featured_listing_exp_date =  date_format($date,"Y-m-d");
               update_post_meta($property_id, 'prop_feature_listing_for', $featured_listing_exp_date); 
            }
            update_post_meta($property_id, 'prop_is_feature_listing', 1);
            if(get_post_meta($property_id, 'prop_feature_listing_date', true) !="")
            {}else{
            update_post_meta($property_id, 'prop_feature_listing_date',date('Y-m-d'));
            }
            
        }
        else
        {
            update_post_meta( $property_id, 'prop_is_feature_listing', 0);
        }
    }

}

new property_meta_boxes_for_featured;