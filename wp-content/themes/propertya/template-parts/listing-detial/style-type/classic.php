<?php
    $property_id    =   get_the_ID();
    $localization = propertya_localization();
    $mydate =  get_the_date(get_option('date_format'), $property_id);
    $text_direction = 'text-lg-left';
    $text_padding = 'pr-lg-4';
    $pr = 'pr-lg-0 padding-left-30';
    $border = 'ml-auto border-left';
    $whatsap= '';
    
    if(is_rtl())
    {
        $text_direction = 'text-lg-right';
        $text_padding = 'pl-lg-4'; 
        $pr = 'pl-lg-0 padding-right-30';
        $border = 'mr-auto border-right';
    }
    if(get_post_meta( $property_id, 'prop_viewtype',true) !="" && get_post_meta( $property_id, 'prop_viewtype',true) == 'yes' ||  is_user_logged_in() )
    {
?>
<div style="background-color: #0c1722;">
<div class="container">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
             <?php
                if (get_post_status ($property_id) == 'draft'  || ($property_id) == 'pending'  ) { ?>
            <div id="warning-messages" class="alert custom-alert m-0 custom-alert--info " role="alert">
                <div class="custom-alert__top-side">
                   <span class="alert-icon custom-alert__icon  far fa-edit "></span>
                       <div class="custom-alert__body">
                           <h6 class="custom-alert__heading">
                                <?php echo esc_html($localization['approval']);?>
                           </h6>
                           <div class="custom-alert__content">
                               <?php echo esc_html($localization['approval_notify']);?>
                            </div>
                       </div>
                </div>
            </div>
        <?php } ?>
        </div>
         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
        <?php
                if (get_post_status ($property_id) == 'expired' ) { ?>
                    <div class="alert custom-alert custom-alert--danger margin-bottom-20" role="alert">
                        <div class="custom-alert__top-side">
                            <span class="alert-icon custom-alert__icon  fas fa-exclamation-triangle"></span>
                                <div class="custom-alert__body">
                                        <h6 class="custom-alert__heading">
                                            <?php echo esc_html__('Notification!','propertya'); ?>
                                        </h6>
                                        <div class="custom-alert__content">
                                        <?php echo esc_html__('This listing has been expired.','propertya'); ?>
                                        </div>
                                </div>
                         </div>
                    </div>
              <?php } ?>  
          </div>
    </div>
</div>
</div>

<div class="listing-detail-stater">
      <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
            <?php
            $selected_pricelabel_after = $optional_price = '';
            $get_all_prices =  propertya_framework_fetch_price($property_id);
            if(!empty($get_all_prices) && is_array($get_all_prices) && count($get_all_prices) > 0 && array_key_exists("main_price",$get_all_prices))
            {
                   if (array_key_exists("optional_price",$get_all_prices))
                   {
                       $optional_price = '<span class="optional_price">'.$get_all_prices['optional_price'].'</span>';
                   }
                   if (array_key_exists("after_prefix",$get_all_prices))
                   {
                       $selected_pricelabel_after = '<span class="clr-blu">'.$get_all_prices['after_prefix'].'</span>';
                   }
                  echo '<div class="price"><h3>'.esc_html($get_all_prices['main_price']).'</h3> <span class="optional_price">'.$optional_price .' ' . $selected_pricelabel_after.'</span> </span></div>';
            }
        ?>
        </div>
        <div class="order-lg-1 <?php echo esc_attr($text_padding); ?> text-center <?php echo esc_attr($text_direction); ?>">
          <h1 class="text-light"><?php echo esc_html(get_the_title($property_id)); ?></h1>
            <div class="list-meta-two">
                <ul>
                    <li><span class="list-posted-date"><?php echo esc_html(date_i18n( get_option( 'date_format' ), strtotime($mydate))); ?></span></li>
                <?php
                 $get_percentage = array();
                 $get_percentage = propertya_reviews_average($property_id);
                if(!empty($get_percentage) && is_array($get_percentage) && count($get_percentage['ratings']) > 0 && !empty($get_percentage['rated_no_of_times']) && $get_percentage['rated_no_of_times'] > 0)
                {
                 ?>
                <li>
                    <span class="ratings"> <?php echo '' . $get_percentage['total_stars']; ?>
                    <span class="rating-counter"> (<?php echo esc_html($get_percentage['rated_no_of_times']); ?> <?php echo esc_html__('Ratings', 'propertya'); ?>)</span> </span>
                </li>
                <?php } ?>
                <li class="list-meta-with-icons"><a href="javascript:void(0)" class="fav-comp  compare-prop" data-compare-id="<?php echo esc_attr($property_id); ?>" ><i class="fas fa-random"></i> <?php echo esc_attr($localization['compare']); ?></a></li>
                <li class="list-meta-with-icons"><a class="fav-prop" href="javascript:void(0)" data-fav-id="<?php echo esc_attr($property_id); ?>"><i class="far fa-heart"></i> <?php echo esc_attr($localization['fav']); ?></a></li>
                <li class="list-meta-with-icons"><?php echo wp_sprintf(esc_html__('Views : %s ', 'propertya'), number_format(get_post_meta($property_id, 'prop_listing_total_views', true))); ?></li>  
                <li class="list-meta-with-icons"><a onclick="window.print(); "><i class="fas fa-print"></i>Print</a></li>
                </ul>   
            </div>
        </div>
      </div>
</div> 
<div class="listing-info-content">
    <div class="container">
        <div class="main-dis-area">
            <div class="row">
            <div class="col-lg-8 pt-2 pt-lg-4 pb-4 mb-lg-3">
                  
                    <?php
                    $property_id    =   get_the_ID();
                    $localization = propertya_localization();
                    $iframe = $thumbnail = $video_id = $thumb_imgs  = $full_img  = $img  = $img_id  = $all_idz = '';
                    $video = get_post_meta($property_id, 'prop_video', true );
                   
                     $all_idz = propertya_framework_fetch_gallery_idz($property_id);
                     
                     if(is_array($all_idz) && count($all_idz) > 0 ||  $video != "" )
                     {
                      

                        $allowed_html = propertya_allowed_html();
                        $featured_listing = '';
                        if (get_post_meta($property_id, 'prop_is_feature_listing', true )!="" && get_post_meta($property_id, 'prop_is_feature_listing', true ) == "1")
                        {
                           
                           $featured_listing = '<div class="ribbon ribbon-top-right"><span>'.esc_attr($localization['feat']).'</span></div>';
                        }
                    ?>
    <?php echo wp_kses($featured_listing,$allowed_html); ?>
    <div class="myflex flexslider mb-0">
        <ul class="slides">
        <?php
        if(is_array($all_idz) && count($all_idz) > 0)
        {
         
            foreach($all_idz as $images_ids)
            {
                $img_id =   '';
                if (isset( $images_ids->ID))
                {
                    $img_id =   $images_ids->ID;
                }
                else
                {
                    $img_id =   $images_ids;
                }
              
                $img  = wp_get_attachment_image_src($img_id, 'propertya-primary-banner');
                $full_img  = wp_get_attachment_image_src($img_id, 'full');
                $thumb_imgs  = wp_get_attachment_image_src($img_id, 'propertya-small-thumb');
                if(wp_attachment_is_image($img_id))
                { 
             ?>
             <li data-thumb="<?php echo esc_url($thumb_imgs[0]); ?>"> <a href="<?php echo esc_url($full_img[0]); ?>" data-fancybox="group"> 
                     <img src="<?php echo  esc_url( $img[0] ); ?>"alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', TRUE)); ?>" /> </a> </li>
            <?php
                    
                }
               
             /*  else
               {
                    
               ?>
                         
                    <li data-thumb="<?php echo esc_url(propertya_defualt_img_url()); ?>"> <a href="<?php echo esc_url(propertya_defualt_img_url()); ?>" data-fancybox="group"> <img src="<?php echo   esc_url(propertya_defualt_img_url()); ?>" alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', TRUE)); ?>" /> </a> </li> -->
             <?php
                     
                }*/
            }
        }
        //else{
          
              ?>
                
            <!-- <li data-thumb="<?php echo esc_url(propertya_defualt_img_url()); ?>"> <a href="<?php echo esc_url(propertya_defualt_img_url()); ?>" data-fancybox="group"> <img src="<?php echo esc_url(propertya_defualt_img_url()); ?>" alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', TRUE)); ?>" /> </a> </li> -->
            <?php
       // }
        if(get_post_meta($property_id, 'prop_video', true ) != "" )
            {
                preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', get_post_meta($property_id, 'prop_video', true ), $match);
                if(isset( $match[1] ) && $match[1] != "" )
                {
                    $video_id = $match[1];
                    $thumbnail = trailingslashit( get_template_directory_uri () ) . "libs/images/video.png";
                    $iframe = 'iframe';
                   
                    echo '<li data-thumb="'.esc_url($thumbnail).'"><'.$iframe.' width="730" height="413" src="https://www.youtube.com/embed/'. esc_attr($video_id ) . '" allowfullscreen></'.$iframe.'></li>'; 
                }
            }
            ?>
        </ul>
    </div>

<?php
 } //}
 // mycode
 else{
  
    ?> 

    <div class="myflex flexslider mb-0"> 
        <ul class="slides"> 
    <li data-thumb="<?php  esc_url(propertya_defualt_img_url()); ?>"> <a href="<?php echo esc_url(propertya_defualt_img_url()); ?>" data-fancybox="group"> <img src="<?php echo esc_url(propertya_defualt_img_url()); ?>" alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', TRUE)); ?>" /> </a> </li></ul></div>
   <?php
// }
}

 if (is_array($all_idz) && count($all_idz) > 1) {
               
                if($all_idz[0] == 0 && $all_idz[1] == "" && $video == "")
                {
                     ?> 

    <div class="myflex flexslider mb-0"> 
        <ul class="slides"> 
    <li data-thumb="<?php  esc_url(propertya_defualt_img_url()); ?>"> <a href="<?php echo esc_url(propertya_defualt_img_url()); ?>" data-fancybox="group"> <img src="<?php echo esc_url(propertya_defualt_img_url()); ?>" alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', TRUE)); ?>" /> </a> </li></ul></div>
   <?php  
                }}

        ?>

            </div>
            <div class="col-xl-4 col-lg-4 col-12">
                <div class="custom-sidebar-padding h-100 <?php echo esc_attr($border); ?>">
                <?php

                $type = $posted_id = '';
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
                        ?> 
                        
                        
                         <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="clearfix space-4"><p class="space-3"><b><?php echo esc_html__('This property is marketed by','propertya'); ?></b></p>
                                    <div class="agent-title">
                                    <div class="agent-photo"><img src="<?php echo esc_url(propertya_placeholder_images($type,$posted_id,'propertya-user-thumb')); ?>" alt=""></div>
                                    <div class="agent-details">
                                        <h4><a href="<?php echo esc_url(get_the_permalink($posted_id)); ?>"><?php echo get_the_title($posted_id); ?></a></h4>
                                        <span><?php echo esc_html($localization['member_since']); ?>: <?php echo propertya_user_timeago($post_author_id); ?></span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <?php if(get_post_meta($posted_id, $type.'_mobile', true ) !="") { ?>
                                <a class="click-reveal phonenumber btn ctn-btn-click btn-shadow btn-block" href="tel:<?php echo esc_html(get_post_meta($posted_id, $type.'_mobile', true )); ?>" data-listing-id="<?php echo esc_attr($property_id); ?>" data-reaction="contact"><?php echo esc_html(get_post_meta($posted_id, $type.'_mobile', true )); ?></a>
                                <?php } ?>    
                              </div>
                        <form name="contact_author" method="POST" id="prop_contact_author">
                          <div class="theme-row">
                             <span class="wrap">
                                <input type="text" autocomplete="off" placeholder="<?php echo esc_attr__('Your Name','propertya'); ?>" data-sanitize="trim" data-validation="required" data-validation-error-msg="<?php echo esc_attr($localization['all_fields_error']); ?>." name="c_username" class="form-control text">
                             </span> 
                          </div>
                          <div class="theme-row">
                       <span class="wrap">
                       <input type="email" autocomplete="off" placeholder="<?php echo esc_attr__('Email','propertya'); ?>" data-validation="email" data-validation-error-msg="<?php echo esc_attr($localization['all_fields_error']); ?>" data-sanitize="trim" class="form-control text" name="c_email" />
                       </span> 
                    </div>
                     <div class="theme-row">
                       <span class="wrap for-my-phone">
                       <input type="text" autocomplete="off" id="myphone" data-validation="required" data-validation-error-msg="<?php echo esc_attr($localization['all_fields_error']); ?>" data-sanitize="trim" class="form-control text" name="contact-no" />
                       </span> 
                    </div>
                          <div class="theme-row">
                       <span class="wrap">
                       <textarea cols="20" rows="2" placeholder="<?php echo esc_attr__('Your Message','propertya'); ?>" class="form-control" autocomplete="off" data-validation="required" data-validation-error-msg-required="<?php echo esc_attr($localization['all_fields_error']); ?>" data-sanitize="trim"  name="c_msg"></textarea>
                       </span> 
                    </div>
                    <?php wp_nonce_field( 'prop-contactauthor-nonce', 'contactauthor_nonce' ); ?>
                    <input type="hidden" name="listing_id" value="<?php echo esc_attr($property_id); ?>">
                    <button type="submit" class="btn btn-danger btn-block sonu-button-contact"><?php echo esc_html__('Request Info','propertya'); ?></button>
                    <?php if(isset($whatsap) && $whatsap != '' && propertya_strings('prop_enable_wtsap') == true){?>
                        <a target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo esc_html($whatsap); ?>&amp;text=<?php echo propertya_strings('prop_wtsap_txt') . "[" . esc_html(get_the_title($property_id)) . "]"; ?>" class="btn btn-block btn-whatsap"><i class=" fab fa-whatsapp mr-2"></i> WhatsApp</a>
                        <?php } ?>
                    </form>
                    </div>
                 </div> 
                 
                 
                 
                <?php
               
                }
                ?>
            </div>
            </div>   
        </div>
        </div>
        <div class="special-features">
            <div class="slide-property-first">
                <div class="row">
                    <?php
                    global $propertya_options;
                    $type_image = $propertya_options['prop_type_logo']["url"];
                    $bed_image = $propertya_options['prop_room_logo']["url"];
                    $bath_image = $propertya_options['prop_bath_logo']["url"];
                    $garage_image = $propertya_options['prop_garage_logo']["url"];
                    $prop_image = $propertya_options['prop_prop_logo']["url"];
                    $land_image = $propertya_options['prop_land_logo']["url"];

                    if(get_post_meta($property_id, 'prop_type', true ) !="") {
                        $prop_type   = get_post_meta( $property_id, 'prop_type', true );
                        $type_term    = propertya_get_term($prop_type,'property_type');
                        ?>
                        <div class="col-xs-6 col-lg-2 col-md-6 col-12">
                            <div class="s-box">
                                <div class="icon">
                                    <img src="<?php echo esc_url($type_image); ?>" class="img-fluid" alt="<?php echo  trailingslashit( get_template_directory_uri () ) . "libs/images/bed.png"; ?>"/>
                                </div>
                                <div class="info">
                                    <h4><?php echo esc_html($localization['property_type']); ?></h4>
                                    <a href="<?php echo esc_url(get_term_link($type_term->slug, 'property_type')); ?>"><?php echo esc_html($type_term->name); ?></a>
                                </div>
                            </div>
                        </div>
                    <?php } if(get_post_meta($property_id,'prop_area_size', true )!=""){
                        $area_prefix = $area ='';
                        $area = number_format(get_post_meta($property_id,'prop_area_size', true ));
                        $area_prefix = get_post_meta($property_id,'prop_area_prefix', true );
                        ?>
                        <div class="col-xs-6 col-lg-2 col-md-6 col-12">
                            <div class="s-box">
                                <div class="icon">
                                    <img src="<?php echo esc_url($prop_image); ?>" class="img-fluid" alt="<?php echo  trailingslashit( get_template_directory_uri () ) . "libs/images/area.png"; ?>"/>
                                </div>
                                <div class="info">
                                    <h4><?php echo esc_html($localization['prop_size']); ?></h4>
                                    <p><?php echo esc_html($area.' '.$area_prefix); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } if(get_post_meta($property_id,'prop_land_size', true )!=""){
                        $prop_land_prefix = $prop_land_size ='';
                        //$prop_land_size = number_format(get_post_meta($property_id,'prop_land_size', true ));
                         $prop_land_size = get_post_meta($property_id,'prop_land_size', true );

                        $prop_land_prefix = get_post_meta($property_id,'prop_land_prefix', true );
                        ?>
                        <div class="col-xs-6 col-lg-2 col-md-6 col-12">
                            <div class="s-box">
                                <div class="icon">
                                    <img src="<?php echo esc_url($land_image); ?>" class="img-fluid" alt="<?php echo  trailingslashit( get_template_directory_uri () ) . "libs/images/size.png"; ?>"/>
                                </div>
                                <div class="info">
                                    <h4><?php echo esc_html($localization['land_area']); ?></h4>
                                    <p><?php echo esc_html($prop_land_size.' '.$prop_land_prefix); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } if(get_post_meta($property_id,'prop_beds_qty', true )!=""){ ?>
                        <div class="col-xs-6 col-lg-2 col-md-6 col-12">
                            <div class="s-box">
                                <div class="icon">
                                    <img src="<?php echo esc_url($bed_image); ?>" class="img-fluid" alt="<?php echo  trailingslashit( get_template_directory_uri () ) . "libs/images/bed.png"; ?>"/>
                                </div>
                                <div class="info">
                                    <h4><?php echo esc_html($localization['bedrooms']); ?></h4>
                                    <p><?php echo esc_html(sprintf('%02d',get_post_meta($property_id,'prop_beds_qty', true ))); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php }
                    if(get_post_meta($property_id,'prop_year_build', true )!=""){ ?>
                        <div class="col-xs-6 col-lg-2 col-md-6 col-12">
                            <div class="s-box">
                                <div class="icon">
                                    <img src="<?php echo  trailingslashit( get_template_directory_uri () ) . "libs/images/calendar.png"; ?>" alt="">
                                </div>
                                <div class="info">
                                    <h4><?php echo esc_html($localization['yearbuild']); ?></h4
                                    <p><?php echo esc_html(get_post_meta($property_id,'prop_year_build', true )); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
       </div>                       
    </div>   
        <div class="listing-ext-content property-6">
             <div class="container">
                 <div class="row">
                      <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                          <div class="make-me-white">
                            <?php
                            global $propertya_options;
                            get_template_part('template-parts/listing-detial/style-type/rearrange', 'notification');
                            $layout = '';
                            $layout = isset( $propertya_options['prop_layout1_manager']['enabled']) ? $propertya_options['prop_layout1_manager']['enabled'] : '';
                            //print_r($layout);
                             if ($layout): foreach ($layout as $key => $value) {
                            switch ($key) {
                                case 'desc': get_template_part('template-parts/listing-detial/description/desc');
                                    break;

                                case 'shortinfo': get_template_part('template-parts/listing-detial/details/detail');
                                    break;

                                case 'custom_fields': get_template_part('template-parts/listing-detial/custom-fields/custom-field');
                                    break;

                                case 'additional': get_template_part('template-parts/listing-detial/additional/additional');
                                    break;

                                case 'addr': get_template_part('template-parts/listing-detial/location/location');
                                    break;

                                case 'features': get_template_part('template-parts/listing-detial/features/features');
                                    break;

                                case 'plans': get_template_part('template-parts/listing-detial/floorplans/plans');
                                    break;

                                case 'attachments': get_template_part('template-parts/listing-detial/attachments/attachments');
                                    break;

                                case 'nearby': get_template_part('template-parts/listing-detial/nearby/nearby');
                                    break;

                                case 'walk': get_template_part('template-parts/listing-detial/walkscore/walkscore');
                                    break;

                                case 'tour': get_template_part('template-parts/listing-detial/tour/tour');
                                    break;

                                case 'views': get_template_part('template-parts/listing-detial/stats/stats');
                                    break;

                                case 'schedule': get_template_part('template-parts/listing-detial/schedule/schedule');
                                    break;

                                case 'ad_slot_2': get_template_part('template-parts/listing-detial/advertisement/slot2');
                                    break;

                                case 'similar': get_template_part('template-parts/listing-detial/similar/similar');
                                    break;

                                case 'ad_slot_2': get_template_part('template-parts/listing-detial/video/video');
                                    break;

                                case 'reviews_score': get_template_part('template-parts/listing-detial/reviews/score');
                                    break;

                                case 'reviews': get_template_part('template-parts/listing-detial/reviews/reviews');
                                    break;

                                case 'reviews_form': get_template_part('template-parts/listing-detial/reviews/form');
                                    break;

                                }
                            }
                            endif;
                            ?>
                          </div>
                     </div>
                     <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                        <?php get_template_part('template-parts/listing-detial/sidebar/sidebar','two'); ?>
                     </div>
                     <?php
                    if (get_post_field('post_author', $property_id) == get_current_user_id() || is_super_admin(get_current_user_id()))
                    {
                        $user_id='';
                        $user_id=get_post_field('post_author', $property_id);
                        $edit_slug = propertya_framework_get_link('page-dashboard.php').'?page-type=submit-property';
                        echo '<div class="sticky-button-edit" data-toggle="tooltip" data-placement="top"  title="'.esc_attr__('Edit', 'propertya').'">
                            <a href="'.esc_url($edit_slug).'&edit_property='.esc_attr($property_id).'" > 
                             <i class="far fa-edit"></i></a>
                        </div>';
                        //mark as featured
                        if (get_post_meta($property_id, 'prop_is_feature_listing', true ) == "0" && get_post_meta($property_id, 'prop_payper_lisitng', true ) == "1")
                        {
                            $link = propertya_framework_get_link('page-dashboard.php')."?page-type=order-complete&listing_id=$property_id";
                            echo '<div class="sticky-button-featured" data-toggle="tooltip" data-placement="top" title="'.esc_attr__('Mark As Featured','propertya').'">
                            <a href="'.esc_url($link).'" > 
                             <i class="fas fa-star"></i></a>
                        </div>'; 
                        }
                    }
                    ?>
                 </div>     
            
            </div>
        </div>
    </div>
</div>
<?php
    }
    else
    {
        echo propertya_framework_only_logged_in_user(); 
    }