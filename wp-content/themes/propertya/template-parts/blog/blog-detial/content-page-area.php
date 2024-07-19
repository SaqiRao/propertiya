<div class="blog-detail-main-area">
            <h1 class="blg-main-title"><?php the_title(); ?></h1>
         	 <div class="post-excerpt post-desc">
    			<?php the_content(); ?>
                <div class="clearfix"></div>
				<?php
                    wp_link_pages( array(
                    'before'      => '<div class="page_with_pagination"><div class="page-links">','after' => '</div></div>','next_or_number' => 'number','link_before' => '<span class="no">','link_after'  => '</span>') );
                ?>
                <?php comments_template( '', true ); ?>
   			</div> 
        </div>  
