<?php
	global $localization;
    $pages = $total_comments = $owner_id = $user_id = $author_id = $keyword = '';
	$replies = $comments = array();
	$user_id = get_current_user_id();
	$limit = 10;
	$paged = 1;
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$offset = ($paged * $limit) - $limit;
	if(get_user_meta( $user_id, 'prop_post_id', true) !="" && get_user_meta($user_id, 'user_role_type', true) !="")
	{
		$author_id = get_user_meta( $user_id, 'prop_post_id' , true );
		$owner_id = get_post_field( 'post_author', $author_id );
	}
	$param = array('status' => 'approve', 'post_type' => 'property', 'user_id' =>$author_id, 'orderby' => 'post_date', 'order' => 'DESC', 'number' => $limit, 'offset' => $offset, 'parent' => 0);
	$comments = get_comments($param);
	$total_comments =  propertya_submitted_reviews($author_id);
	if (isset($limit) && $limit != "")
	{
    	$pages = ceil($total_comments/$limit);
	}
?>
<div class="content-wrapper">
        <div class="row">
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12 col-12">
                <div class="dashboard-statistic-block">
                    <div class="icon gradient-s2">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div>
                        <h5><?php echo esc_html($localization['received']);?></h5>
                        <h2><?php echo esc_html(sprintf('%02d',$total_comments)); ?></h2>
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
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title"><?php echo esc_html($localization['submitted']);?></h4>
				  <?php
				  if(!empty($comments) && is_array($comments) && count($comments) > 0)
				  {
					$replier_msg = $reply_comment_id = $image_id = $commenter_dp = $type = $rated = $main_title = '';
                  	foreach ($comments as $comment)
					{
						$replier_msg = $reply_comment_id = '';
						$comment_id = $comment->comment_ID;
                        $property_id = $comment->comment_post_ID;
						//to get user type
						$comment_author_id = get_post_field('post_author', $comment->user_id);
						if(get_user_meta($comment_author_id, 'user_role_type', true) !="")
						{
							$type = get_user_meta($comment_author_id, 'user_role_type', true);
						}
						$commenter_dp = esc_url(propertya_placeholder_images($type,$comment->user_id,'propertya-user-thumb'));
					   $main_title = get_comment_meta($comment->comment_ID, 'review_main_title', true );
					   $rated = get_comment_meta( $comment->comment_ID, 'review_stars', true );
					?>
                    <div class="profile-review-box" id="<?php echo esc_attr($comment_id); ?>">
                   	<div class="profile-review-box-info">
                            <div class="profile-review-title">
                            <div class="au-dp">
                             <a href="<?php echo esc_url($comment->comment_author_url); ?>"><img class="rounded-circle" src="<?php echo esc_url($commenter_dp); ?>" alt="<?php echo esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', TRUE)); ?>"></a></div>
                                <span><?php echo esc_html__('You have posted a review on', 'propertya'); ?> <a href="<?php echo esc_url(get_the_permalink($property_id)); ?>" title="<?php echo get_the_title($property_id); ?>"><?php echo get_the_title($property_id); ?></a>
                                </span>
                                <span class="delete-my-sub-rev" data-toggle="tooltip"  title="<?php echo esc_attr__('Delete', 'propertya'); ?>" href="javascript:void(0)" data-comment-id="<?php echo esc_attr($comment_id); ?>" data-property-id="<?php echo esc_attr($property_id); ?>"> <i class="fa fa-times" aria-hidden="true"></i></span>
                                <span class="review-toggle-angle collapsed" data-toggle="collapse" data-target="#review-<?php echo esc_attr($comment_id); ?>">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                                <div class="profile-review-meta">
                                <ul>
                                    <li>
                                        <?php
                                        if ($rated != "") {
                                            ?>
                                            <span class="ratings">
                                                <?php
                                                for ($i = 1; $i <= 5; $i++) {
                                                    if ($i <= $rated) {
                                                        echo '<i class="fa fa-star color"></i>';
                                                    } else {
                                                        echo '<i class="fa fa-star"></i>';
                                                    }
                                                }
                                                ?>
                                                <i class="rating-counter"> (<?php echo esc_html($rated); ?>/<?php echo esc_html__('5', 'propertya'); ?>)</i>
                                            </span>
                                            <?php
                                        }
                                        ?>
                                    </li>
                                    <li><?php echo '<i class="far fa-clock"></i>' . propertya_timeago($comment->comment_ID); ?></li>
                                </ul>
                            </div>
                            </div>
                            <div class="profile-review-box-text collapse" id="review-<?php echo esc_attr($comment_id); ?>" >
                            	<p><?php echo esc_html($comment->comment_content); ?></p>
                                <div class="profile-review-reply-box">
                                	<p><i class="far fa-edit"></i> <?php echo esc_html__('Edit Review', 'propertya'); ?> </p>
                                </div>
                                <form name="prop_updatemy_reply" class="prop_updatemy_reply"  method="post" data-comment-id="<?php echo esc_attr($comment_id); ?>">
                                
                                <div class="single-rating">
          <label><?php echo esc_html($localization['rating']); ?></label>
        </div>
        						<div class="rating-group">
                                  <label class="rating-label" for="one-star">
                                      <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
                                  </label>
                                  
                                  <input class="rating-group-input" name="review-rating" id="one-star" value="1" <?php if(!empty($rated)){ checked( 1 == $rated );}else{echo "checked='checked'"; } ?> type="radio"  />
                                  <label class="rating-label" for="two-star">
                                      <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
                                  </label>
                                  <input class="rating-group-input" name="review-rating" id="two-star" value="2" <?php checked( 2 == $rated ); ?> type="radio" />
                                  <label class="rating-label" for="three-star">
                                      <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
                                  </label>
                                  <input class="rating-group-input" name="review-rating" id="three-star" value="3" <?php checked( 3 == $rated ); ?> type="radio" />
                                  <label  class="rating-label" for="four-star">
                                      <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
                                  </label>
                                  <input class="rating-group-input" name="review-rating" id="four-star" value="4" <?php checked( 4 == $rated ); ?> type="radio" />
                                  <label  class="rating-label" for="five-star">
                                      <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
                                  </label>
                                  <input class="rating-group-input" name="review-rating" id="five-star" <?php checked( 5 == $rated ); ?> value="5" type="radio" />
        </div>
                                
                                <div class="theme-row">
                                  <label><?php echo esc_html($localization['review_title']); ?> <span class="req-mark">*</span></label>
                                  <span class="wrap">
                                  <input type="text" autocomplete="off" class="form-control text" name="review-title" value="<?php echo esc_attr($main_title); ?>"/>
                                  </span> 
          						</div>
                                <div class="theme-row">
                                <label><?php echo esc_html($localization['your_review']); ?> <span class="req-mark">*</span></label>
                                    <textarea autocomplete="off" name="review-msg" placeholder="<?php echo esc_attr__('Write a reply to this review', 'propertya'); ?>"  cols="10" class="form-control" rows="5"><?php echo esc_html($comment->comment_content); ?></textarea>
                                </div>
                                <input type="hidden" name="property_id" value="<?php echo esc_attr($property_id); ?>">
                                <input type="hidden" name="comment_id" value="<?php echo esc_attr($comment_id); ?>">
                                <input type="hidden" name="user_id" value="<?php echo esc_attr($owner_id); ?>">
                                
                                <div class="form-group">
                                    <button type="submit" class="btn sonu-button-<?php echo esc_attr($comment_id); ?>  btn-sm btn-theme " data-comment-id="<?php echo esc_attr($comment_id); ?>"><?php echo esc_html__('Submit Reply','propertya'); ?></button>
                                </div>
                                </form>
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
        </div>