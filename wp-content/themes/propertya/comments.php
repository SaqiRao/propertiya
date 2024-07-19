<?php
if ( post_password_required() )
return;
?>
	<div id="comments" class="">
        <?php if ( have_comments() ) : ?>
                    <div class="widget-seprator card-comments">
                        <div class="widget-seprator-heading">
                           <h3 class="sec-title"><i class="far fa-comments"></i> <?php echo (get_comments_number()) ? get_comments_number() : '';?> <?php echo esc_html__( 'Comments', 'propertya');?>
                        </div>
                        <?php wp_list_comments( array( 'callback' => 'propertya_custom_comments'));?>
                    </div>
       <?php endif; 
        if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
        ?>
        <p class="nocomments"><?php esc_html__( 'Comments are closed.', 'propertya' ); ?></p>
        <?php endif; 
		   $user_identity = '';
		   $aria_req = ( $req ? " aria-required='true'" : '' );
		   $args = array(
			'fields' => apply_filters(
				'comment_form_default_fields', array(
					'author' =>'
					<div class="theme-row">
					<label for="author">'. esc_html__( 'Your Name','propertya' ) . ( $req ? '<span class="required">*</span>' : '' )  .' </label>
					<span class="wrap">
					<input type="text" id="author" name="author" class="form-control" value="' .
						esc_attr( $commenter['comment_author'] ) . '" '. $aria_req . '>
					</span></div>',
					'email'  => '
					<div class="theme-row">
					<label for="email">'. esc_html__( 'Your Email', 'propertya' ) . ( $req ? '<span class="required">*</span>' : '' ). '</label>
					<span class="wrap">
					<input type="text" id="email" name="email" class="form-control" ' . $aria_req .' value="' . esc_attr(  $commenter['comment_author_email'] ) .'"></span></div>'
				)
			),
			'comment_field' => '
			   <div class="theme-row">
					<label for="comment">'. esc_html__( 'Your Comment', 'propertya' ) .'</label>
					<span class="wrap">
						<textarea id="comment" name="comment" class="form-control" rows="5"></textarea>
					</span>
			   </div>',
			   'comment_notes_after' => '',
			   'comment_notes_before' => '',
			   'logged_in_as' => '<p>'. sprintf(__( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>','propertya' ),admin_url( 'profile.php' ),$user_identity,wp_logout_url( apply_filters( 'the_permalink', get_permalink()))) . '</p>',
				'title_reply' => '',
				'class_submit' => 'btn btn-theme ',
				'label_submit' => esc_html__('Post Comment','propertya'),
		   );
		  if (!comments_open())
		  {
		  }
		  else
		  {
		  ?>
			<div class="widget-seprator comment-form-reply">
                <div class="widget-seprator-heading">
                     <h3 class="sec-title"><i class="far fa-comment-dots"></i> <?php echo esc_html__('Leave Your Comment','propertya'); ?></h3>
                </div>
				<?php comment_form($args ); ?>
			</div>
		  <?php 
		  }
		  ?>
	</div>