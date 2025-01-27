<?php get_header(); ?>
<?php
if (have_posts()): while ( have_posts()){the_post();
?>
<section class="blog-detail-page blog-detail-section-2">
    <div class="container">
     <div class="row">
        <?php
		 global $propertya_options;
	     $layout = '';
         $layout = isset( $propertya_options['prop_p_blog_singlelayout']['enabled']) ? $propertya_options['prop_p_blog_singlelayout']['enabled'] : '';
            if ($layout): foreach ($layout as $key=>$value) {
                switch($key) {
                    case 'singlepost': get_template_part( 'template-parts/blog/blog-detial/content', 'area');
                    break;
             
                    case 'singlesidebar': get_template_part( 'template-parts/blog/blog-detial/sidebar','blog');
                    break;
                }
            }
            else:
                get_template_part( 'template-parts/blog/blog-detial/content', 'area');
                get_template_part( 'template-parts/blog/blog-detial/sidebar', 'blog');
            endif;
        ?>
        </div>
    </div>
</section>
<?php
}
else:
 get_template_part( 'template-parts/content', 'none' );
endif;
?>
<?php get_footer(); ?>