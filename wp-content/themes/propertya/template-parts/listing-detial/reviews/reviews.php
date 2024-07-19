<?php
$property_id	=	get_the_ID();
$localization = propertya_localization();
$post_author_id = $posted_id = $all_idz = $image_id = '';
$post_author_id = get_post_field('post_author', $property_id);
$posted_id = get_user_meta($post_author_id, 'prop_post_id' , true );
$no_off = 5;
if(!empty(propertya_strings('prop_review_limit')))
{
	$no_off = propertya_strings('prop_review_limit');
}
$comments = $replies = array();
$comments = get_comments(array('post_id' => $property_id, 'orderby' => 'post_date' ,'order' => 'DESC', 'post_type' => 'property',  'status'  => 'approve','parent'=>0, 'number' => $no_off));
if(!empty($comments) && is_array($comments) && count($comments) > 0)
{
	foreach($comments as $comment)
	{
		$got_dislikes = $got_love = $got_likes = '';
		if(get_comment_meta($comment->comment_ID, 'review_like', true) !="")
		{
			$got_likes = '('.get_comment_meta($comment->comment_ID, 'review_like', true).')';	
		}
		if(get_comment_meta($comment->comment_ID, 'review_love', true) !="")
		{
			$got_love = '('.get_comment_meta($comment->comment_ID, 'review_love', true).')';	
		}
		if(get_comment_meta($comment->comment_ID, 'review_dislike', true) !="")
		{
			$got_dislikes = '('.get_comment_meta($comment->comment_ID, 'review_dislike', true).')';	
		}
		//to get user type
		$type = '';
		$comment_author_id = get_post_field('post_author', $comment->user_id);
		if(get_user_meta($comment_author_id, 'user_role_type', true) !="")
		{
			$type = get_user_meta($comment_author_id, 'user_role_type', true);	
		}
		
		//fetch replies of that post
		$replies = get_comments( array( 'parent' => $comment->comment_ID, 'status' => 'approve',  'orderby' => 'comment_date' , 'order' => 'DESC' ) );
?>
    <div class="widget-seprator my-reviews">
        <div class="review-card">
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
                            <?php 
                            if(get_comment_meta( $comment->comment_ID, 'review_stars', true ) !="")
                            {
                                $rated = get_comment_meta( $comment->comment_ID, 'review_stars', true );
                            ?>	
                            <div class="total-rating-stars">
                                <img src="<?php echo esc_url(get_template_directory_uri() . "/libs/images/icons/".$rated.'.png'); ?>" alt="<?php echo esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid">
                            </div>
                            <?php } ?>
                        </div>
                    </div>
            </div>
        </div>
    </div>
            <div class="author-review-content">
                <div class="review-content">
                    <div class="review-msg-body">
                        <h2 class="review-main-title"><?php echo esc_html(get_comment_meta( $comment->comment_ID, 'review_main_title', true )); ?></h2>
                            <p>
                                <?php echo esc_html($comment->comment_content); ?>
                            </p>
                    </div>
                    <?php
					if(!empty($replies) && is_array($replies) && count($replies) > 0 )
					{
						foreach($replies as $reply)
						{
						?>
                        	<div class="profile-review-reply-box">
                            	<h5> <strong><?php echo esc_html__('Author responded on','propertya'); ?></strong>  <span class="responded"><?php echo date_i18n( 'j F, Y',  strtotime( get_the_time($reply->comment_date) ) );?></span></h5>
                                <p class="profile-review-reply"><?php echo nl2br($reply->comment_content); ?></p>
                         	</div>
						<?php	
						}
					}
					?>
                </div>
            </div>
            <div class="review-actions">
                <div class="review-stats">
                    <div class="like">
                        <a href="javascript:void(0)" class="track-reaction" data-reaction="1" data-listingid="<?php echo esc_attr($property_id); ?>" data-cid="<?php echo esc_attr($comment->comment_ID); ?>"><i class="fas fa-thumbs-up"></i> <?php echo esc_html__('Like','propertya'); ?> <span class="reaction-count-<?php echo esc_attr($comment->comment_ID).'-1'; ?>"><?php echo esc_html($got_likes); ?></span></a>
                    </div>
                    
                    <div class="love ">
                        <a href="javascript:void(0)" class="track-reaction" data-reaction="2" data-listingid="<?php echo esc_attr($property_id); ?>" data-cid="<?php echo esc_attr($comment->comment_ID); ?>"><i class="fas fa-heart"></i> <?php echo esc_html__('Love','propertya'); ?> <span class="reaction-count-<?php echo esc_attr($comment->comment_ID).'-2'; ?>"><?php echo esc_html($got_love); ?></span></a>
                    </div>
                    
                     <img class="ajax-pre none reaction-loader-<?php echo esc_attr($comment->comment_ID); ?>" src="<?php echo esc_url(trailingslashit( get_template_directory_uri () ) . '/libs/images/loading-bar.gif'); ?>" alt="<?php echo esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)); ?>">
                    
                </div>
                <div class="review-actions-reply">
                    <div class="dislike">
                        <a href="javascript:void(0)" class="track-reaction" data-reaction="3" data-listingid="<?php echo esc_attr($property_id); ?>" data-cid="<?php echo esc_attr($comment->comment_ID); ?>"><i class="fas fa-thumbs-down"></i> <?php echo esc_html__('Dislike','propertya'); ?> <span class="reaction-count-<?php echo esc_attr($comment->comment_ID).'-3'; ?>"><?php echo esc_html($got_dislikes); ?></span></a>
                    </div>
                </div>
            </div>
         </div>
    </div>
<?php
	}
}