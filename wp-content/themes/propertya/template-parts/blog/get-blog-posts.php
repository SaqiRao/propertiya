<?php
if (have_posts()): while ( have_posts() ){the_post();
?>
<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 margin-bottom-30 grid-item">
    <div <?php post_class() ?> id="post-<?php the_ID(); ?>">
      <div class="blog-inner-box">
      <?php if ( has_post_thumbnail() ):
	  echo '<div class="image"><a href="' . esc_url(get_the_permalink(get_the_ID())) . '"> ' . get_the_post_thumbnail(get_the_ID(), 'propertya-blog-thumb') . '</a></div>'; ?>
      <?php endif; ?>	  
        <div class="blog-lower-box">
        <?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
          <div class="comment_count">
           <span class="comment_count_in">
           <i class="far fa-comment-alt"></i> <?php echo propertya_blogcomments_count(); ?>
           </span>
           </div>
       <?php endif; ?>
          <span class="blog-date"><?php the_time( get_option( 'date_format' ) ); ?></span>
           <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
          <p><?php echo wp_trim_words( get_the_excerpt(), 7 ); ?></p>
        </div>
         <div class="blog-read-more"> 
         <a href="<?php the_permalink(); ?>" class="clr-black"><?php echo esc_html__('Read More','propertya'); ?>
         <i class="fas fa-long-arrow-alt-right pl-3"></i></a> </div>
      </div>
    </div>  
</div>
<?php
}
else:
 get_template_part( 'template-parts/blog/content', 'none' );
endif;