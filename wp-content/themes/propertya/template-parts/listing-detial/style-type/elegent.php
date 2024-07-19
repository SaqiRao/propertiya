<?php
	$property_id	=	get_the_ID();
	$localization = propertya_localization();
	$mydate =  get_the_date(get_option('date_format'), $property_id);
	if(get_post_meta( $property_id, 'prop_viewtype',true) !="" && get_post_meta( $property_id, 'prop_viewtype',true) == 'yes' ||  is_user_logged_in() )
	{
?>
<section class="property-6 custom-padding property-detail-page">
	<div class="container">
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
    <?php
                if (get_post_status ($property_id) == 'draft'  || ($property_id) == 'pending'  ) { ?>
                	<div id="warning-messages" class="alert custom-alert m-0 custom-alert--info margin-bottom-30" role="alert">
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
		</div>
	</div>
  <div class="container">
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
        <div class="row">
          <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
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
         	 <div class="row listing-title-zone">
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <ul class="property-tags list-unstyled">
                <?php
				if(get_post_meta( $property_id, 'prop_offer_type', true ) !="")
				{
					$offer_type = get_post_meta( $property_id, 'prop_offer_type', true );
					$type_term    = propertya_get_term($offer_type,'property_status');
					$color = '';
				?>
                  <li class="list-inline-item">
                    <a class="badge badge-status-<?php echo esc_attr($type_term->term_id); ?>" href="<?php echo esc_url(get_term_link($type_term->term_id)); ?>"><?php echo esc_html($type_term->name); ?></a>
                  </li>
				<?php
				}
				if(get_post_meta( $property_id, 'prop_offer_label', true ) !="")
				{
					$label_type = get_post_meta( $property_id, 'prop_offer_label', true );
					$label_type_term    = propertya_get_term($label_type,'property_label');
				?>
                  <li class="list-inline-item">
                    <a class="badge badge-label-<?php echo esc_attr($label_type_term->term_id); ?>" href="<?php echo esc_url(get_term_link($label_type_term->term_id)); ?>"><?php echo esc_html($label_type_term->name); ?></a>
                  </li>
                <?php
				}
				?>
                </ul>
                <h1 class="card-title"><?php echo esc_html(get_the_title($property_id)); ?></h1>
                <div class="list-meta">
                            <ul>
                                <li>
                                    <span class="list-posted-date"><i class="far fa-clock clr-blu "> </i> <?php echo esc_html(date_i18n( get_option( 'date_format' ), strtotime($mydate))); ?></span>
                                </li>
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
                            </ul>
                        </div>
                
            
              </div>
            </div>
            <?php
			global $propertya_options;
			$layout = '';
         	$layout = isset( $propertya_options['prop_layout_manager']['enabled']) ? $propertya_options['prop_layout_manager']['enabled'] : '';
			//print_r($layout);
			 if ($layout): foreach ($layout as $key => $value) {
					switch ($key) {
						case 'slider': get_template_part('template-parts/listing-detial/slider/slider');
							break;

						case 'ad_slot_1': get_template_part('template-parts/listing-detial/advertisement/slot1');
							break;

						case 'desc': get_template_part('template-parts/listing-detial/description/desc');
							break;
							
						case 'shortinfo': get_template_part('template-parts/listing-detial/details/detail');
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

						case 'custom_fields': get_template_part('template-parts/listing-detial/custom-fields/custom-field');
							break;

					}
				}
			endif;
          ?>
          </div>
          <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
          	<?php get_template_part('template-parts/listing-detial/sidebar/sidebar'); ?>
          </div>
        </div>
      </div>
    </div> 
      <?php
        if (get_post_field('post_author', $property_id) == get_current_user_id() || is_super_admin(get_current_user_id()))
        {
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
</section>
<?php
	}
	else
	{
		echo propertya_framework_only_logged_in_user(); 
	}
?>