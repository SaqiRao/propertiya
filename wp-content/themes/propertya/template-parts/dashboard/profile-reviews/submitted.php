<?php
	global $localization;
    $value = $pages = $total_comments = $owner_id = $user_id = $author_id = $keyword = '';
	$replies = $comments = array();
	$user_id = get_current_user_id();
	$limit = 10;
	$paged = 1;
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$offset = ($paged * $limit) - $limit;
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
	$param = array('status' => 'approve', 'type__in' =>array('property-buyers', 'property-agents', 'property-agency' ),  'user_id' =>$author_id,  'orderby' => 'post_date', 'order' => 'DESC', 'number' => $limit, 'offset' => $offset, 'parent' => 0);
	$comments = get_comments($param);
	$total_comments = propertya_submitted_profile_reviews($author_id);
	if (isset($limit) && $limit != "")
	{
		$pages = ceil($total_comments/$limit);
	}
?>
<div class="content-wrapper profile-review-page">

          <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <h4 class="card-title"><?php echo esc_html($localization['submitted']);?></h4>
              <div class="singleprofile-reviews">
              <?php
				  if(!empty($comments) && is_array($comments) && count($comments) > 0)
				  {
					 $buyed = $value = $expertise = $communication = $responsive = $reference_type  = $replier_msg = $reply_comment_id = $image_id = $commenter_dp = $type = $rated = $main_title = '';
                  	foreach ($comments as $comment)
					{
						$replier_msg = $reply_comment_id = '';
						$comment_id = $comment->comment_ID;
                        $profile_id = $comment->comment_post_ID;
						//get reviewer id
						$get_reviewer_id = get_post_field('post_author', $profile_id);
						if(get_user_meta($get_reviewer_id, 'user_role_type', true) !="")
						{
							 $reference_type =  get_user_meta($get_reviewer_id, 'user_role_type', true);
						}
						//to get user type
						$comment_author_id = get_post_field('post_author', $comment->user_id);
						if(get_user_meta($comment_author_id, 'user_role_type', true) !="")
						{
							$type = get_user_meta($comment_author_id, 'user_role_type', true);
						}
						$commenter_dp = esc_url(propertya_placeholder_images($type,$comment->user_id,'propertya-user-thumb'));
					   $buyed = get_comment_meta($comment->comment_ID, 'review_'.$reference_type.'_buyed', true );
					   $main_title =  get_comment_meta($comment->comment_ID, 'review_'.$reference_type.'_title', true )
					    
					?>
                    <div class="profile-review-box" id="<?php echo esc_attr($comment_id); ?>">
                   	<div class="profile-review-box-info">
                            <div class="profile-review-title">
                            <div class="au-dp">
                             <a href="<?php echo esc_url($comment->comment_author_url); ?>"><img class="rounded-circle" src="<?php echo esc_url($commenter_dp); ?>" alt="<?php echo esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', TRUE)); ?>"></a></div>
                                <span><?php echo esc_html__('You have posted a review on', 'propertya'); ?> <a href="<?php echo esc_url(get_the_permalink($profile_id)); ?>" title="<?php echo get_the_title($profile_id); ?>"><?php echo get_the_title($profile_id); ?></a>
                                </span>
                                <span class="delete-my-sub-rev-profile" data-toggle="tooltip"  title="<?php echo esc_attr__('Delete', 'propertya'); ?>" href="javascript:void(0)" data-comment-id="<?php echo esc_attr($comment_id); ?>" data-profile-id="<?php echo esc_attr($profile_id); ?>"> <i class="fa fa-times" aria-hidden="true"></i></span>
                                <div class="timehour-ago">
                                <?php echo ' <i class="far fa-clock"></i>' . propertya_timeago($comment->comment_ID) . '' ?>
                                 <?php if(get_comment_meta($comment->comment_ID, 'review_'.$reference_type.'_recommend', true ) !="") { 
									$value = get_comment_meta($comment->comment_ID, 'review_'.$reference_type.'_recommend', true );
									if($value == 1)
									{
										$text = esc_html__('Recommended You','propertya');
										echo '<span class="profile-mark-as"><i class="highly-recommended far fa-thumbs-up"></i>'.$text.'</span>';
									}
									if($value == 0)
									{
										$text = esc_html__('Not Recommended','propertya');
										echo '<span class="profile-mark-as "><i class="nothighly-recommended far fa-thumbs-down"></i>'.$text.'</span>';
									}
									?>
                                    
                                    <?php
										}
									?>
                               </div>
                            </div>
                            <div class="profile-review-box-text " >
                            <div class="review-actions">
                        <div class="rating-stars-box w-100">
                  <?php if(get_comment_meta($comment->comment_ID, 'review_'.$reference_type.'_responsive', true )!="") {
					     $responsive =  get_comment_meta($comment->comment_ID, 'review_'.$reference_type.'_responsive', true );
				   ?>     
                  <div class="rating-stars">
                    <label><?php echo propertya_strings('prop_ag_rev_first'); ?></label>
                    <ul>
                    <?php
						for ($i = 1; $i <= 5; $i++)
						{
							if ($i <= $responsive)
							{
								echo '<li class="star colored-star"><i class="fa fa-star"></i></li>';
							} 
							else
							{
								echo '<li class="star"><i class="fa fa-star"></i></li>';
							}
						}
					?>	
                    </ul>
                  </div>
                  <?php } ?>
                  <?php if(get_comment_meta($comment->comment_ID, 'review_'.$reference_type.'_communication', true )!="") {
					 $communication =  get_comment_meta($comment->comment_ID, 'review_'.$reference_type.'_communication', true ); 
				   ?>
                  <div class="rating-stars">
                    <label><?php echo propertya_strings('prop_ag_rev_second'); ?></label>
                    <ul>
                    <?php
						for ($j = 1; $j <= 5; $j++)
						{
							if ($j <= $communication)
							{
								echo '<li class="star colored-star"><i class="fa fa-star"></i></li>';
							} 
							else
							{
								echo '<li class="star"><i class="fa fa-star"></i></li>';
							}
						}
					?>	
                    </ul>
                  </div>
                  <?php } ?>
                  <?php if(get_comment_meta($comment->comment_ID, 'review_'.$reference_type.'_expertise', true )!="") {
					 $expertise =  get_comment_meta($comment->comment_ID, 'review_'.$reference_type.'_expertise', true );  
				   ?>
                  <div class="rating-stars">
                    <label><?php echo propertya_strings('prop_ag_rev_third'); ?></label>
                    <ul>
                    <?php
						for ($k = 1; $k <= 5; $k++)
						{
							if ($k <= $expertise)
							{
								echo '<li class="star colored-star"><i class="fa fa-star"></i></li>';
							} 
							else
							{
								echo '<li class="star"><i class="fa fa-star"></i></li>';
							}
						}
					?>	
                    </ul>
                  </div>
                  <?php } ?>
                  <?php if(get_comment_meta($comment->comment_ID, 'review_'.$reference_type.'_services', true )!="") {
					$services =  get_comment_meta($comment->comment_ID, 'review_'.$reference_type.'_services', true );   
				  ?>
                  <div class="rating-stars">
                    <label><?php echo propertya_strings('prop_ag_rev_fourth'); ?></label>
                    <ul>
                    <?php
						for ($l = 1; $l <= 5; $l++)
						{
							if ($l <= $services)
							{
								echo '<li class="star colored-star"><i class="fa fa-star"></i></li>';
							} 
							else
							{
								echo '<li class="star"><i class="fa fa-star"></i></li>';
							}
						}
					?>	
                    </ul>
                  </div>
                  <?php } ?>
                </div>
                    </div>
                    <?php
					 if(get_comment_meta($comment->comment_ID, 'review_'.$reference_type.'_title', true )!="") { ?>
                                <h3 class="review-main-title"><?php echo esc_html(get_comment_meta($comment->comment_ID, 'review_'.$reference_type.'_title', true)); ?></h3>
                             <?php } ?> 
                            
                            	<p><?php echo esc_html($comment->comment_content); ?></p>
                                <div class="profile-review-reply-box collapsed" data-toggle="collapse"  data-target="#review-<?php echo esc_attr($comment_id); ?>">
                                    <p><i class="far fa-edit"></i> <?php echo esc_html__('Edit Review', 'propertya'); ?> </p>
                                </div>
                                <div class="collapse" id="review-<?php echo esc_attr($comment_id); ?>">
                                     <div class="profile-submitted-reviews">
                                         <form name="prop_updatemy_profilereply" class="prop_updatemy_profilereply"  method="post" data-comment-id="<?php echo esc_attr($comment_id); ?>">
                                         <div class="row">
                                         
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                    <div class="single-rating">
                                    <label><?php echo propertya_strings('prop_ag_rev_first'); ?></label>
                                    </div>
                                    <div class="rating-group">
                                    <label class="rating-label" for="one-star-res">
                                    <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
                                    </label>
                                    <input class="rating-group-input" name="responsiveness" id="one-star-res" value="1" type="radio" <?php checked( 1 == $responsive ); ?> />
                                    <label class="rating-label" for="two-star-res">
                                    <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
                                    </label>
                                    <input class="rating-group-input" name="responsiveness" id="two-star-res" value="2" type="radio" <?php checked( 2 == $responsive ); ?> />
                                    <label class="rating-label" for="three-star-res">
                                    <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
                                    </label>
                                    <input class="rating-group-input" name="responsiveness" id="three-star-res" value="3" type="radio" <?php checked( 3 == $responsive ); ?> />
                                    <label  class="rating-label" for="four-star-res">
                                    <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
                                    </label>
                                    <input class="rating-group-input" name="responsiveness" id="four-star-res" value="4" type="radio" <?php checked( 4 == $responsive ); ?> />
                                    <label  class="rating-label" for="five-star-res">
                                    <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
                                    </label>
                                    <input class="rating-group-input" name="responsiveness" id="five-star-res" value="5" type="radio" <?php checked( 5 == $responsive ); ?> />
                                    </div>
                                    </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <div class="single-rating">
                                        <label><?php echo propertya_strings('prop_ag_rev_second'); ?></label>
                                        </div>
                                        <div class="rating-group">
                                        <label class="rating-label" for="one-star-comm">
                                        <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
                                        </label>
                                        <input class="rating-group-input" name="communication" id="one-star-comm" value="1" type="radio" <?php checked( 1 == $communication ); ?> />
                                        <label class="rating-label" for="two-star-comm">
                                        <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
                                        </label>
                                        <input class="rating-group-input" name="communication" id="two-star-comm" value="2" type="radio" <?php checked( 2 == $communication ); ?> />
                                        <label class="rating-label" for="three-star-comm">
                                        <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
                                        </label>
                                        <input class="rating-group-input" name="communication" id="three-star-comm" value="3" type="radio" <?php checked( 3 == $communication ); ?>/>
                                        <label  class="rating-label" for="four-star-comm">
                                        <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
                                        </label>
                                        <input class="rating-group-input" name="communication" id="four-star-comm" value="4" type="radio" <?php checked( 4 == $communication ); ?>/>
                                        <label  class="rating-label" for="five-star-comm">
                                        <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
                                        </label>
                                        <input class="rating-group-input" name="communication" id="five-star-comm" value="5" type="radio" <?php checked( 5 == $communication ); ?>/>
                                        </div>
                                    </div>    
                                    </div>
                                    
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                    <div class="single-rating">
                                    <label><?php echo propertya_strings('prop_ag_rev_third'); ?></label>
                                    </div>
                                    <div class="rating-group">
                                    <label class="rating-label" for="one-star-exp">
                                    <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
                                    </label>
                                    <input class="rating-group-input" name="expertise" id="one-star-exp" value="1" type="radio" <?php checked( 1 == $expertise ); ?> />
                                    <label class="rating-label" for="two-star-exp">
                                    <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
                                    </label>
                                    <input class="rating-group-input" name="expertise" id="two-star-exp" value="2" type="radio"  <?php checked( 2 == $expertise ); ?>/>
                                    <label class="rating-label" for="three-star-exp">
                                    <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
                                    </label>
                                    <input class="rating-group-input" name="expertise" id="three-star-exp" value="3" type="radio" <?php checked( 3 == $expertise ); ?> />
                                    <label  class="rating-label" for="four-star-exp">
                                    <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
                                    </label>
                                    <input class="rating-group-input" name="expertise" id="four-star-exp" value="4" type="radio" <?php checked( 4 == $expertise ); ?> />
                                    <label  class="rating-label" for="five-star-exp">
                                    <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
                                    </label>
                                    <input class="rating-group-input" name="expertise" id="five-star-exp" value="5" type="radio" <?php checked( 5 == $expertise ); ?> />
                                    </div>
                                    </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                    <div class="single-rating">
                                    <label><?php echo propertya_strings('prop_ag_rev_fourth'); ?></label>
                                    </div>
                                    <div class="rating-group">
                                    <label class="rating-label" for="one-star-ser">
                                    <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
                                    </label>
                                    <input class="rating-group-input" name="services" id="one-star-ser" value="1" type="radio" <?php checked( 1 == $services ); ?> />
                                    <label class="rating-label" for="two-star-ser">
                                    <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
                                    </label>
                                    <input class="rating-group-input" name="services" id="two-star-ser" value="2" type="radio"  <?php checked( 2 == $services ); ?>/>
                                    <label class="rating-label" for="three-star-ser">
                                    <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
                                    </label>
                                    <input class="rating-group-input" name="services" id="three-star-ser" value="3" type="radio"  <?php checked( 3 == $services ); ?>/>
                                    <label  class="rating-label" for="four-star-ser">
                                    <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
                                    </label>
                                    <input class="rating-group-input" name="services" id="four-star-ser" value="4" type="radio" <?php checked( 4 == $services ); ?> />
                                    <label  class="rating-label" for="five-star-ser">
                                    <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
                                    </label>
                                    <input class="rating-group-input" name="services" id="five-star-ser" value="5" type="radio" <?php checked( 5 == $services ); ?> />
                                    </div>
                                    </div> 
                                    </div>
                                    
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                    <div class="single-rating">
                                    <label><?php echo propertya_strings('prop_ag_rev_recommend'); ?></label>
                                    </div>
                                    <div class="pretty p-default p-curve">
                                    <input type="radio" name="recommend" value="1" <?php checked( 1 == $value ); ?>/>
                                    <div class="state p-primary-o">
                                    <label><?php echo esc_html__('Yes','propertya'); ?></label>
                                    </div>
                                    </div>
                                    <div class="pretty p-default p-curve">
                                    <input type="radio" name="recommend" value="0"  <?php checked( 0 == $value ); ?>/>
                                    <div class="state p-primary-o">
                                    <label><?php echo esc_html__('No','propertya'); ?></label>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                    <div class="single-rating">
                                    <label><?php echo propertya_strings('prop_ag_rev_prop'); ?></label>
                                    </div>
                                    <div class="pretty p-default p-curve">
                                    <input type="radio" name="is-buy" value="1"  <?php checked( 1 == $buyed ); ?>/>
                                    <div class="state p-primary-o">
                                    <label><?php echo esc_html__('Yes','propertya'); ?></label>
                                    </div>
                                    </div>
                                    <div class="pretty p-default p-curve">
                                    <input type="radio" name="is-buy" value="0"  <?php checked( 0 == $buyed ); ?>/>
                                    <div class="state p-primary-o">
                                    <label><?php echo esc_html__('No','propertya'); ?></label>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                  <input type="text" placeholder="<?php echo esc_attr(propertya_strings('prop_ag_rev_title')); ?>" autocomplete="off" class="form-control text" name="review-title" value="<?php echo esc_attr($main_title); ?>"/>
                                 </div>
                              </div>
                                         
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">     
                                    <div class="form-group">
                                        <textarea autocomplete="off" name="review-msg" placeholder="<?php echo esc_attr__('Write a reply to this review', 'propertya'); ?>"  cols="10" class="form-control" rows="5"><?php echo esc_html($comment->comment_content); ?></textarea>
                                    </div>
                                    </div>
                                    <input type="hidden" name="profile_id" value="<?php echo esc_attr($profile_id); ?>">
                                    <input type="hidden" name="comment_id" value="<?php echo esc_attr($comment_id); ?>">
                                    <input type="hidden" name="user_id" value="<?php echo esc_attr($owner_id); ?>">
                                    <input type="hidden" name="reference_type" value="<?php echo esc_attr($reference_type); ?>">
                                    <input type="hidden" name="review_reply_id" value="<?php echo esc_attr($reply_comment_id); ?>">
                                     <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn sonu-button-<?php echo esc_attr($comment_id); ?>  btn-sm btn-theme " data-comment-id="<?php echo esc_attr($comment_id); ?>"><?php echo esc_html__('Submit Reply','propertya'); ?></button>
                                    </div>
                                    </div>
                                    
                                    </div>
                                    
                                    </form>
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php   
					}
					propertya_framework_prop_pagination_reviews($pages,true,$paged);
				  }
				  else
				  {
					  echo '<div class="alert custom-alert custom-alert--warning" role="alert">
							<div class="custom-alert__top-side">
								<div class="custom-alert__body">
									<h6 class="custom-alert__heading">'.esc_html__('No Review Submitted!', 'propertya').'</h6>
									<div class="custom-alert__content">'.esc_html__("All notification will be shown here.", 'propertya').'</div>
								</div>
							</div>
						</div>';
				  }
				  ?>
              </div>
            </div>
          </div>
</div>