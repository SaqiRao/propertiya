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
	$param = array('status' => 'approve','post_type' =>$post_type,'post_id' => $author_id, 'orderby' => 'post_date', 'order' => 'DESC', 'number' => $limit, 'offset' => $offset, 'parent' => 0);
	$comments = get_comments($param);
	$allowed_html = propertya_allowed_html();
	$ratings = array();
	$total_reviews = $recommendations = $total_average = '0';
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
	if (isset($limit) && $limit != "")
	{
		$pages = ceil($total_comments/$limit);
	}
?>
<div class="content-wrapper profile-review-page">
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
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <h4 class="card-title"><?php echo esc_html($localization['received']);?></h4>
              <div class="singleprofile-reviews">
              <?php
				  if(!empty($comments) && is_array($comments) && count($comments) > 0)
				  {
					$replier_msg = $reply_comment_id = $image_id = $commenter_dp = $type = $rated = $main_title = '';
                  	foreach ($comments as $comment)
					{
						$replier_msg = $reply_comment_id = '';
						$comment_id = $comment->comment_ID;
                        $profile_id = $comment->comment_post_ID;
						//to get user type
						$comment_author_id = get_post_field('post_author', $comment->user_id);
						if(get_user_meta($comment_author_id, 'user_role_type', true) !="")
						{
							$type = get_user_meta($comment_author_id, 'user_role_type', true);
						}
						$commenter_dp = esc_url(propertya_placeholder_images($type,$comment->user_id,'propertya-user-thumb'));
					   $main_title = get_comment_meta($comment->comment_ID, 'review_main_title', true );
					    //fetch owner replies of that post
					    $replies = get_comments(array('parent' => $comment->comment_ID, 'post_type' => $post_type, 'status' => 'approve', 'orderby' => 'comment_date', 'order' => 'DESC'));
						if(!empty($replies) && is_array($replies) && count($replies) > 0)
					    {
						   foreach ($replies as $reply)
						   {
							  $reply_comment_id = $reply->comment_ID;
							  $replier_msg = esc_html($reply->comment_content); 
						   }
					   }
					?>
                    <div class="profile-review-box">
                   	<div class="profile-review-box-info">
                            <div class="profile-review-title">
                            <div class="au-dp">
                             <a href="<?php echo esc_url($comment->comment_author_url); ?>"><img class="rounded-circle" src="<?php echo esc_url($commenter_dp); ?>" alt="<?php echo esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', TRUE)); ?>"></a></div>
                                <span><a href="<?php echo esc_url($comment->comment_author_url); ?>"><?php echo esc_html($comment->comment_author); ?></a> <?php echo esc_html__('posted a review on your profile', 'propertya'); ?>
                                </span>
                                <div class="timehour-ago">
                                <?php echo ' <i class="far fa-clock"></i>' . propertya_timeago($comment->comment_ID) . '' ?>
                                 <?php if(get_comment_meta($comment->comment_ID, 'review_'.$reference.'_recommend', true ) !="") { 
									$value = get_comment_meta($comment->comment_ID, 'review_'.$reference.'_recommend', true );
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
                  <?php if(get_comment_meta($comment->comment_ID, 'review_'.$reference.'_responsive', true )!="") {
					     $responsive =  get_comment_meta($comment->comment_ID, 'review_'.$reference.'_responsive', true );
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
                  <?php if(get_comment_meta($comment->comment_ID, 'review_'.$reference.'_communication', true )!="") {
					 $communication =  get_comment_meta($comment->comment_ID, 'review_'.$reference.'_communication', true ); 
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
                  <?php if(get_comment_meta($comment->comment_ID, 'review_'.$reference.'_expertise', true )!="") {
					 $expertise =  get_comment_meta($comment->comment_ID, 'review_'.$reference.'_expertise', true );  
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
                  <?php if(get_comment_meta($comment->comment_ID, 'review_'.$reference.'_services', true )!="") {
					$services =  get_comment_meta($comment->comment_ID, 'review_'.$reference.'_services', true );   
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
					if(get_comment_meta($comment->comment_ID, 'review_'.$reference.'_title', true )!="") { ?>
                                <h3 class="review-main-title"><?php echo esc_html(get_comment_meta($comment->comment_ID, 'review_'.$reference.'_title', true)); ?></h3>
                            <?php } ?> 
                            
                            	<p><?php echo esc_html($comment->comment_content); ?></p>
                                <div class="profile-review-reply-box collapsed" data-toggle="collapse"  data-target="#review-<?php echo esc_attr($comment_id); ?>">
                                	<p><?php echo esc_html__('Reply to this review', 'propertya'); ?> </p>
                                </div>
                                <div class="collapse" id="review-<?php echo esc_attr($comment_id); ?>">
                               		 <form name="prop_review_reply" class="profile-dashboard-review"  method="post" data-comment-id="<?php echo esc_attr($comment_id); ?>">
                                <div class="form-group">
                                    <textarea autocomplete="off" name="comments-review-reply" placeholder="<?php echo esc_attr__('Write a reply to this review', 'propertya'); ?>"  cols="10" class="form-control" rows="5"><?php echo esc_html($replier_msg); ?></textarea>
                                </div>
                                <input type="hidden" name="profile_id" value="<?php echo esc_attr($profile_id); ?>">
                                <input type="hidden" name="comment_id" value="<?php echo esc_attr($comment_id); ?>">
                                <input type="hidden" name="user_id" value="<?php echo esc_attr($owner_id); ?>">
                                <input type="hidden" name="reference_type" value="<?php echo esc_attr($post_type); ?>">
                                <input type="hidden" name="review_reply_id" value="<?php echo esc_attr($reply_comment_id); ?>">
                                <div class="form-group">
                                    <button type="submit" class="btn sonu-button-<?php echo esc_attr($comment_id); ?>  btn-sm btn-theme " data-comment-id="<?php echo esc_attr($comment_id); ?>"><?php echo esc_html__('Submit Reply','propertya'); ?></button>
                                </div>
                                </form>
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
                                        <h6 class="custom-alert__heading">'.esc_html__('No Review Received!', 'propertya').'</h6>
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