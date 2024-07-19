<?php 
	$single_id   =	get_the_ID();
	$type  = $reference = 'agency';
	if(is_singular('property-agency'))
	{
		$reference = 'agency';
		$post_type = 'property-agency';
	}
	if(is_singular('property-agents'))
	{
		$reference = 'agent';
		$post_type = 'property-agents';
	}
	if(is_singular('property-buyers'))
	{
		$reference = 'buyer';
		$post_type = 'property-buyers';
	}
	$comments = get_query_var('propsingle-comments');
	$text = $value = $services = $expertise = $communication = $responsive = $all_idz = $image_id = '';
	$img_type = 'like.png';
	if(!empty($comments) && is_array($comments) && count($comments) > 0)
	{
?>
<div class="single-detail-reviews" id="p-reviews">
	<?php
	$comment_author_id = '';
	foreach($comments as $comment)
	{
		$comment_author_id = get_post_field('post_author', $comment->user_id);
		if(get_user_meta($comment_author_id, 'user_role_type', true) !="")
		{
			$type = get_user_meta($comment_author_id, 'user_role_type', true);	
		}
		//fetch replies of that post
		$replies = get_comments( array( 'parent' => $comment->comment_ID, 'post_type' =>$post_type, 'status' => 'approve',  'orderby' => 'comment_date' , 'order' => 'DESC' ) );	
	?>	
        <div class="widget-seprator my-reviews review-recommended">
                <div class="review-card ">
                    <div class="single-listing-reviews">
                <div class="reviews-author-data">
                    <div class="reviews-author-avatar">
                        <img src="<?php echo esc_url(propertya_placeholder_images($type,$comment->user_id,'propertya-user-thumb')); ?>" alt="<?php echo esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid">
                    </div>
                <div class="reviews-author-details">
                        <div class="reviews-author-name">
                            <a href="<?php echo esc_url($comment->comment_author_url); ?>"><?php echo esc_html($comment->comment_author); ?></a>
                        </div>
                        <div class="review-stars-rating">
                                <div class="review-content-header">
                                <div class="review-author-review-count">
                                        <i class="far fa-clock"></i>
                                    </div>
                                   <div class="review-date-time">
                                        <span><?php echo propertya_timeago($comment->comment_ID); ?></span> 
                                    </div>
                                    <?php if(get_comment_meta($comment->comment_ID, 'review_'.$reference.'_recommend', true ) !="") { 
									$value = get_comment_meta($comment->comment_ID, 'review_'.$reference.'_recommend', true );
									if($value == 1)
									{
										$img_type = 'like.png';
										$text = esc_html__('Recommended','propertya');
									}
									if($value == 0)
									{
										$text = esc_html__('Not Recommended','propertya');
										$img_type = 'dislike.png';
									}
									?>
                                    <div class="total-rating-stars">
                                        <img data-toggle="tooltip" data-placement="top" data-original-title="<?php echo esc_attr($text); ?>" src="<?php echo esc_url(get_template_directory_uri() . "/libs/images/$img_type"); ?>" alt="<?php echo esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid">
                                    </div>
                                    <?php
										}
									?>
                                  </div>
                            </div>
                    </div>
                </div>
            </div>
                    <div class="author-review-content">
                        <div class="review-content">
                            <div class="review-msg-body">
                            <?php if(get_comment_meta($comment->comment_ID, 'review_'.$reference.'_title', true )!="") { ?>
                                <h2 class="review-main-title"><?php echo esc_html(get_comment_meta($comment->comment_ID, 'review_'.$reference.'_title', true)); ?></h2>
                            <?php } ?>    
                                <p><?php echo esc_html($comment->comment_content); ?></p>
                            </div>
                        </div>
                    </div>
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
							if(!empty($replies) && is_array($replies) && count($replies) > 0 )
							{
								foreach($replies as $reply)
								{
								?>
									<div class="profile-review-reply-box-new">
										<h5> <strong><?php echo esc_html__('Author responded on','propertya'); ?></strong>  <span class="responded"><?php echo date_i18n( 'j F, Y',  strtotime( get_the_time($reply->comment_date) ) );?></span></h5>
										<p class="profile-review-reply"><?php echo (nl2br($reply->comment_content)); ?></p>
									</div>
								<?php	
								}
							}
							?>
                 </div>
        </div>
    <?php
	}
	?>
</div>  
<?php
	}