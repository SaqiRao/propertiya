<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
    <div class="content-area custom-padding entry-left">
    	<div class="blog-detail-main-area">
            <h1 class="blg-main-title"><?php the_title(); ?></h1>
            <div class="post-detail-commenting-meta">
            <ul class="list-unstyled">
            <li class="list-inline-item blg-pdate">
						<span class="meta-icon ">
							<span class="screen-reader-text"><?php esc_html__( 'Post date', 'propertya' ); ?></span>
							<i class="far fa-calendar-alt"></i>
						</span>
						<span class="meta-text posted-date">
							<a href="<?php the_permalink(); ?>"><?php the_time( get_option( 'date_format' ) ); ?></a>
						</span>
					</li>
            <li class="list-inline-item blg-auth">
						<span class="meta-icon">
							<span class="screen-reader-text"><?php esc_html__( 'Post author', 'propertya' ); ?></span>
							<i class="far fa-user"></i>
						</span>
						<span class="meta-text">
							<?php
								printf(__( 'By %s', 'propertya' ),'<a class="clr-blu" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author_meta( 'display_name' ) ) . '</a>');
							?>
						</span>
					</li>
                    <li class="list-inline-item blg-cats">
						<span class="meta-icon">
							<span class="screen-reader-text"><?php esc_html__( 'Categories', 'propertya' ); ?></span>
							<i class="far fa-clock"></i>
						</span>
						<span class="meta-text">
							<?php _ex( 'In', 'A string that is output before one or more categories', 'propertya' ); ?> <?php the_category( ', ' ); ?>
						</span>
					</li>
                    <li class="list-inline-item blg-comments">
						<span class="meta-icon">
							<i class="far fa-comment-dots"></i>
						</span>
						<span class="meta-text">
							<?php comments_popup_link(); ?>
						</span>
					</li>
                    </ul>
            
            </div>
            <?php
				if(in_array('propertya-framework/index.php', apply_filters('active_plugins', get_option('active_plugins'))))
				{ 
					echo propertya_framework_social_shares(get_the_ID());
				}
				?>
            <?php if ( has_post_thumbnail() ):
			echo '<div class="blog-featured-img">'.get_the_post_thumbnail(get_the_ID(), 'propertya-primary-banner').'</div>'; endif; ?>	 
         	 <div class="post-excerpt post-desc">
    			<?php the_content(); ?>
				<?php
                    wp_link_pages( array(
                    'before'      => '<div class="page_with_pagination"><div class="page-links">','after' => '</div></div>','next_or_number' => 'number','link_before' => '<span class="no">','link_after'  => '</span>') );
                ?>
                <div class="clearfix"></div>
                <?php comments_template( '', true ); ?>
   			</div> 
        </div>  
    </div>
    
</div>