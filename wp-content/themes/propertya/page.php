<?php get_header();
if (have_posts())
{
	the_post();
	$post	=	get_post();
     if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))))
	 {
		  the_content(); 
	 }
     else if( preg_match( '/elementor/', apply_filters('the_content',$post->post_content)))
     {
         the_content();
     }
	 else
	 {
     ?>
         <section class="custom-padding blog-detail-page blog-detail-section-2 real-static-page">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <?php
                        get_template_part( 'template-parts/blog/blog-detial/content-page', 'area');
                    ?>
                    </div>
                </div>
            </div>
        </section>
         <?php
	 }
}
?>
<?php 
get_footer(); ?>