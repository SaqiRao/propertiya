<?php
	global $localization;
    global $propertya_options;
    $owner_id = $user_id = $author_id = $keyword = '';
	$user_id = get_current_user_id();
	$post_type = 'property-agency';
	$reference = 'agency';
	if(get_user_meta( $user_id, 'prop_post_id', true) !="" && get_user_meta($user_id, 'user_role_type', true) !="")
	{
		$author_id = get_user_meta( $user_id, 'prop_post_id' , true );
		$owner_id = get_post_field( 'post_author', $author_id );
		
		if(get_user_meta( $user_id, 'user_role_type', true) == 'agency')
		{
			$post_type = 'property-agency';
			$reference = 'agency';
		}
		if(get_user_meta( $user_id, 'user_role_type', true) == 'agent')
		{
			$post_type = 'property-agents';
			$reference = 'agent';
		}
		if(get_user_meta( $user_id, 'user_role_type', true) == 'buyer')
		{
			$post_type = 'property-buyers';
			$reference = 'buyer';
		}
	}
	$allowed_html = propertya_allowed_html();
	$ratings = array();
	$total_comments = $total_reviews = $recommendations = $total_average = '0';
	$total_stars = 'N/A';
	$ratings = propertya_reviews_stats_average($author_id,$post_type,$reference);
	if(!empty($ratings) && is_array($ratings) && $ratings['rated_no_of_times'] > 0)
	{
		$total_average = $ratings['total_average'];
		$recommendations = $ratings['total_recommendations'];
		$total_reviews = $ratings['rated_no_of_times'];
		$total_stars = $ratings['total_stars'];
	}
	$total_comments = $total_reviews;
	$most_viewed = propertya_framework_fetchmost_viewed_listings($owner_id);
	$param = $comments = array();
	$param = array('status' => 'approve', 'post_type' =>array( 'property',$post_type), 'post_author__in' =>$owner_id, 'orderby' => 'post_date', 'order' => 'DESC', 'number' => 5, 'parent' => 0);
	$comments = get_comments($param);
    $is_show = 'col-xl-6 col-12';
    if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) && isset($propertya_options['prop_membership_type']) && $propertya_options['prop_membership_type'] == 'with-woo')
    {
        $is_show = 'col-xl-4 col-12';
    }
?>  
<div class="main-dashboard-area">
      <div class="row">
        <div class="col-md-12 grid-margin">

<?php
                // if(propertya_framework_get_options('propertya_new_user_email_verification') != null && propertya_framework_get_options('propertya_new_user_email_verification') == true)
                // {
                //     $user_id= get_current_user_id();
                //     $stored_dateTime = get_user_meta($user_id,'_verify_email_resend_time', true);
                //     $now = time();
                //     $currentDateTime = date('d-m-Y H:i:s', $now);
                    
                //     $date1 = strtotime($currentDateTime); 
                //     $date2 = strtotime($stored_dateTime);
                    
                //     $diff = abs($date2 - $date1);  
  
  

                    // $years = floor($diff / (365*60*60*24));  
                    // $months = floor(($diff - $years * 365*60*60*24)  / (30*60*60*24));  
                    // $days = floor(($diff - $years * 365*60*60*24 -  $months*30*60*60*24)/ (60*60*24)); 
                    // $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)  / (60*60));  
                    // $minutes = floor(($diff - $years * 365*60*60*24  - $months*30*60*60*24 - $days*60*60*24  - $hours*60*60)/ 60);
                    // $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24  - $hours*60*60 - $minutes*60));
                    

                    // if(strtotime($currentDateTime) > strtotime($stored_dateTime) )
                    // {
                    //     $resent_msg = '<a href="javascript:void(0)" class="register_email_again"> '.esc_html__('Resend Email?','propertya').'</a>';
                    // }
                    // else
                    // {
                    //     $resent_msg = esc_html__('Resend again in ','propertya'). $minutes.esc_html__(' minutes ','propertya'). $seconds.esc_html__(' seconds','propertya');
                    // }
                    
                    // $is_verified = get_user_meta( $user_id, 'is_email_verified', true );
                    // if($is_verified != 1 || $is_verified == '')
                    // {
                        ?>
                       <!--  <div class="propertya-alert alert alert-danger alert-dismissible fade show" role="alert">
                            <div class="propertya-alert-box">
                                <span class="icon-info">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M14.8 4.613l6.701 11.161c.963 1.603.49 3.712-1.057 4.71a3.213 3.213 0 0 1-1.743.516H5.298C3.477 21 2 19.47 2 17.581c0-.639.173-1.264.498-1.807L9.2 4.613c.962-1.603 2.996-2.094 4.543-1.096c.428.276.79.651 1.057 1.096zm-2.22.839a1.077 1.077 0 0 0-1.514.365L4.365 16.98a1.17 1.17 0 0 0-.166.602c0 .63.492 1.14 1.1 1.14H18.7c.206 0 .407-.06.581-.172a1.164 1.164 0 0 0 .353-1.57L12.933 5.817a1.12 1.12 0 0 0-.352-.365zM12 17a1 1 0 1 1 0-2a1 1 0 0 1 0 2zm0-9a1 1 0 0 1 1 1v4a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1z" fill="#626262"/></svg>
                                </span>
                                <div class="text-info">
                                    <h5>
                                    <?php #echo esc_html__('Your email address is not verified','propertya'); ?> 
                                    </h5>
                                    <p>
                                        <?php #echo esc_html__('A verification link has been sent to your email. ','propertya'); ?>
                                        <?php #echo wp_return_echo($resent_msg); ?>
                                    </p>
                                    </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div> -->
                        <?php
                //     }
                // }
                ?>




          <div class="d-flex justify-content-between flex-wrap">
            <div class="d-flex align-items-end flex-wrap">
              <div class="mr-md-3 mr-xl-4">
                <h2><?php echo esc_html($localization['welcome']); ?></h2>
                <p class="mb-md-0 text-muted mb-0 hover-cursor dashboard-breadcrumb"><a href="<?php echo esc_url( home_url( '/' )); ?>"><?php echo esc_html($localization['home']); ?></a>&nbsp;&nbsp;/&nbsp; <?php echo esc_html($localization['dashboard']); ?></p>
              </div>
            </div>
            <div class="d-flex justify-content-between align-items-end flex-wrap">
              <a target="_blank" class="dash-btns mr-3 mt-2 mt-xl-0" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo esc_attr('View Profile','propertya'); ?>" href="<?php echo esc_url(get_the_permalink($author_id)); ?>">
                <i class="far fa-paper-plane text-muted"></i>
              </a>
              <a target="_blank" class="dash-btns mt-2 mt-xl-0" href="<?php echo esc_url(get_the_permalink().'?page-type=submit-property'); ?>" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo esc_attr($localization['ad_property']); ?>">
                <i class="far fa-edit text-muted"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
          <div class="row">
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12 col-12">
                <div class="dashboard-statistic-block">
                    <div class="icon gradient-1">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div>
                        <h5><?php echo esc_html($localization['total_published']);?></h5>
                        <h2><?php echo esc_html(sprintf('%02d', propertya_count_total_properties($owner_id, 'publish'))); ?></h2>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12 col-12">
                <div class="dashboard-statistic-block">
                    <div class="icon gradient-9">
                       <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div>
                        <h5><?php echo esc_html($localization['total_pending']);?></h5>
                        <h2><?php echo esc_html(sprintf('%02d', propertya_count_total_properties($owner_id, 'draft'))); ?></h2>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12 col-12">
                <div class="dashboard-statistic-block">
                    <div class="icon gradient-4">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <div>
                        <h5><?php echo esc_html($localization['total_featured']);?></h5>
                        <h2><?php echo esc_html(sprintf('%02d', propertya_count_total_properties($owner_id, 'publish','is_featured'))); ?></h2>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12 col-12">
                <div class="dashboard-statistic-block">
                    <div class="icon gradient-5">
                        <i class="fas fa-recycle"></i>
                    </div>
                    <div>
                        <h5><?php echo esc_html($localization['total_expired']);?></h5>
                        <h2><?php echo esc_html(sprintf('%02d', propertya_count_total_properties($owner_id, 'expired'))); ?></h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
			<div class="col-md-3 col-xs-12 col-lg-3 col-sm-12 col-12">
                <div class="dashboard-statistic-block">
                    <div class="icon gradient-s6">
                        <i class="far fa-bell"></i>
                    </div>
                    <div>
                        <h5><?php echo esc_html($localization['total_reviews']);?></h5>
                        <h2><?php echo esc_html(sprintf('%02d',$total_reviews)); ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12 col-12">
                <div class="dashboard-statistic-block">
                    <div class="icon gradient-s8">
                        <i class="far fa-paper-plane"></i>
                    </div>
                    <div>
                        <h5><?php echo esc_html($localization['total_avg']);?></h5>
                        <h2><?php echo esc_html($total_average); ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12 col-12">
                <div class="dashboard-statistic-block">
                    <div class="icon gradient-s7">
                       <i class="far fa-thumbs-up"></i>
                    </div>
                    <div>
                        <h5><?php echo esc_html($localization['recommendations']);?></h5>
                        <h2><?php echo esc_html(sprintf('%02d',$recommendations)); ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12 col-12">
                <div class="dashboard-statistic-block">
                    <div class="icon gradient-s5">
                        <i class="far fa-star"></i>
                    </div>
                    <div>
                        <h5><?php echo esc_html($localization['total_stars']);?></h5>
                        <span class="ratings"><?php echo wp_kses($total_stars,$allowed_html) ; ?></span>
                    </div>
                </div>
            </div>
        </div>
          <div class="row">
            <div class="col-md-8 col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <?php if(!empty( propertya_strings('prop_settings_detail_uviews'))) { ?>
                  	<p class="card-title"><?php echo propertya_strings('prop_settings_detail_uviews'); ?></p>
                  <?php } ?>  
                    <div class="chart-box"><canvas id="bar-chart" height="167"></canvas></div>
                </div>
              </div>
            </div>
            <div class="col-md-4 col-12 grid-margin single-review-stats">
              <div class="card">
                <div class="card-body">
                <?php
				 if(!empty($ratings) && is_array($ratings) && $ratings['rated_no_of_times'] > 0) { 
				 ?>
                  <p class="card-title"> <?php echo esc_html($ratings['rated_no_of_times']) . '&nbsp;'. esc_html(propertya_strings('prop_detail_sidebar_reviews')); ?></p>
                  <?php
				    $recommendations =$fourth_bar = $third_bar =  $sec_bar   =  $firs_bar = '';
				    $firs_bar = 	round($ratings['average_responsive']*100/5);
					$sec_bar   = 	round($ratings['average_communication']*100/5);
					$third_bar = 	round($ratings['average_expertise']*100/5);
					$fourth_bar = 	round($ratings['average_service']*100/5);
					$recommendations = round($ratings['total_recommendations']*100/$ratings['rated_no_of_times']);
				  ?>
                  <div class="text-center">
                    <div class="d-inline align-baseline display-2"><?php echo esc_html($ratings['total_average']); ?><span class="full-rating">/5</span></div>
                    <div class="align-baselines">
                    <span class="ratings"><?php echo wp_kses($ratings['total_stars'],$allowed_html) ; ?></span>
                    </div>
                </div>
                <div class="pt-3"> <label class="text-medium text-sm"><?php echo propertya_strings('prop_ag_rev_first'); ?> </label><span class="review-count-stats"><?php echo esc_html($ratings['average_responsive']); ?></span>
                    <div class="progress margin-bottom-1x">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo esc_attr($firs_bar); ?>%;" aria-valuenow="<?php echo esc_attr($firs_bar); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div> <label class="text-medium text-sm"><?php echo propertya_strings('prop_ag_rev_second'); ?></label><span class="review-count-stats"><?php echo esc_html($ratings['average_communication']); ?></span>
                    <div class="progress margin-bottom-1x">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo esc_attr($sec_bar); ?>%;" aria-valuenow="<?php echo esc_attr($sec_bar); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div> <label class="text-medium text-sm"><?php echo propertya_strings('prop_ag_rev_third'); ?></label> <span class="review-count-stats"><?php echo esc_html($ratings['average_expertise']); ?></span>
                    <div class="progress margin-bottom-1x">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo esc_attr($third_bar); ?>%;" aria-valuenow="<?php echo esc_attr($third_bar); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div> <label class="text-medium text-sm"><?php echo propertya_strings('prop_ag_rev_fourth'); ?></label> <span class="review-count-stats"><?php echo esc_html($ratings['average_service']); ?></span>
                    <div class="progress margin-bottom-1x">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo esc_attr($fourth_bar); ?>%;" aria-valuenow="<?php echo esc_attr($fourth_bar); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div> <label class="text-medium text-sm"><?php echo esc_html__('Recommendations','propertya'); ?></label> <span class="review-count-stats"><?php echo esc_html($ratings['total_recommendations']); ?></span>
                    <div class="progress mb-2">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo esc_attr($recommendations); ?>%;" aria-valuenow="<?php echo esc_attr($recommendations); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <?php
				 }
                else
                {
                    echo '<p class="card-title"> '.esc_html(propertya_strings('prop_detail_sidebar_reviews')).'</p>';
                    echo propertya_packages_notifications('reviews');   
                }
                ?>
                </div>
              </div>
            </div>
          </div>
          <div class="row most-viewed-listings">
          <div class="<?php echo esc_attr($is_show); ?> grid-margin">
              <div class="card">
                <div class="card-body">
                  	<p class="card-title"><?php echo esc_html($localization['recent_act']); ?></p>
                 <?php
				  if(!empty($comments) && is_array($comments) && count($comments) > 0)
				  {
				 ?>
                        <?php
						$image_id = '';
						foreach ($comments as $comment)
						{
							$comment->comment_post_ID;
							$commenter_dp = esc_url(propertya_placeholder_images($reference,$comment->user_id,'propertya-user-thumb'));
						?>
                        <div class="d-flex flex-row comment-row">
                            <div class="p-2"><span class="round"><img src="<?php echo esc_url($commenter_dp); ?>" alt="<?php echo esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', TRUE)); ?>" ></span></div>
                            <div class="comment-text w-100">
                                <h5><a class="clr-black" href="<?php echo esc_url($comment->comment_author_url); ?>"><?php echo esc_html($comment->comment_author); ?></a>  <small><?php echo esc_html__('posted a review ', 'propertya'); ?></small></h5>
                                <p>
								<?php echo esc_html(mb_strimwidth($comment->comment_content, 0,60, '...')); ?></p>
                                <div class="comment-footer">
                                <span><a target="_blank" class="text-muted" href="<?php echo esc_url(get_the_permalink($comment->comment_post_ID)); ?>"><i class="view-link far fas fa-external-link-alt"></i> <?php echo esc_html__('View More', 'propertya'); ?></a></span>
                                    <span class="text-muted"><i class="time-clock far fa-clock"></i> <?php echo propertya_timeago($comment->comment_ID) ; ?></span> 
                                    
                                    </div>
                            </div>
                        </div>
                        <?php
						}
						?>
                   <?php
				  }
                  else
                  {
                    echo propertya_packages_notifications('activities');   
                  }
				  ?>
                </div>
              </div>
            </div>
            <div class="<?php echo esc_attr($is_show); ?> grid-margin">
              <div class="card">
                <div class="card-body">
                  <p class="card-title"><?php echo esc_html__('Most Viewed Properties','propertya'); ?></p>
                  <?php
				  $most_listings = new WP_Query( $most_viewed );
				  if ( $most_listings->have_posts() )
				  {
					  $allowed_html = propertya_allowed_html();
				  ?>	  
                  	<div class="row">
                    <?php
								 while ( $most_listings->have_posts() )
								 {
									$most_listings->the_post();
									$property_id	=	get_the_ID();
									$all_idz = '';
									$all_idz = propertya_framework_fetch_gallery_idz($property_id);
									//description
									$description = '';
									if(!empty(get_the_content($property_id)))
									{
										$description = '<p> '.mb_strimwidth(get_the_excerpt($property_id), 0,55, '...').'</p>';
									}
									$mydate =  get_the_date(get_option('date_format'), $property_id);
									//prices
									$get_all_prices =  propertya_framework_fetch_price($property_id);
									if(!empty($get_all_prices) && is_array($get_all_prices) && count($get_all_prices) > 0 && array_key_exists("main_price",$get_all_prices))
									{
										 $price_rent = '<span class="main-price"> '.$get_all_prices['main_price'].' </span>';
									}
                                    $text_direction = 'mr-sm-3 mb-2 mb-sm-0';  
                                    if(is_rtl())
                                    {
                                        $text_direction = 'ml-sm-3 mb-2 mb-sm-0'; 
                                    }
								?>
                  					 <div class="col-xl-12 col-12 ">
                   					<div class="media flex-column flex-sm-row mt-0  justify-content-center">
                        <div class="<?php echo esc_attr($text_direction); ?>">
                            <div class="card-img-actions"> <a href="#" data-abc="true"> <img src="<?php echo propertya_framework_img_src($all_idz,'propertya-user-thumb'); ?>" class="img-fluid img-preview" alt="<?php echo esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)); ?>"> </a> </div>
                        </div>
                        <div class="media-body">
                         <h4 class="media-title"><a class="clr-black" href="<?php echo esc_url(get_the_permalink($property_id)); ?>"><?php echo propertya_title_limit(35,$property_id); ?></a></h4>
                           <ul class="list-inline  text-muted">
                                <li class="list-inline-item"> <i class="far fa-clock"></i> <?php echo esc_html(date_i18n( get_option( 'date_format' ), strtotime($mydate))); ?> </li>
                                <li class="list-inline-item"><i class="far fa-eye"></i> <?php echo wp_sprintf(esc_html__('%s Views', 'propertya'), number_format(get_post_meta($property_id, 'prop_listing_total_views', true))); ?></li>
                            </ul>
                             <?php echo wp_kses($price_rent,$allowed_html);  ?>
                        </div>
                    </div>
                    				 </div>
                    			<?php
								 }
								 wp_reset_postdata();
								 ?>
                	</div>
                 <?php
				  }
                  else
                  {
                    echo propertya_packages_notifications('listing');   
                  }    
				  ?>
                </div>
              </div>
            </div>
            <?php
              if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) && isset($propertya_options['prop_membership_type']) && $propertya_options['prop_membership_type'] == 'with-woo') { ?>
            <div class="<?php echo esc_attr($is_show); ?> grid-margin h-100">
              <div class="card h-100">
                <div class="card-body">
                      <p class="card-title"><?php echo esc_html__('Plan Details','propertya'); ?> 
                        <?php if(get_user_meta($user_id, 'prop_user_package_id', true ) != "")
                        {
                            $link = '#';
                            $package_id = get_user_meta($user_id, 'prop_user_package_id', true );
                            global $propertya_options;
                            if(isset($propertya_options['prop_pkg_page']) && $propertya_options['prop_pkg_page'] !="")
                            {
                                $link =  get_page_link($propertya_options['prop_pkg_page']);
                            }
                        ?>       
                       <a class="view_more_packages" href="<?php echo esc_url($link); ?>"> <?php echo esc_html__('View Packages','propertya'); ?></a> 
                      </p>
                    <?php echo propertya_user_pack_history($package_id,$user_id); ?>
                    <?php }
                          else
                          {
                            echo propertya_packages_notifications('noplan');   
                          }
                    ?>  
                  </div>
                </div>
              </div>    
            <?php } ?>
          </div>
</div>          
