<?php get_header();
$image_id = '';
?>
<section class="error-page-section section-padding">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="error-page-content">
                        	<h1> <?php echo esc_html__( '404', 'propertya' ); ?> </h1>
                            <h2><?php echo esc_html__( 'Oops! Page Not Found', 'propertya' ); ?></h2>
                            <p><?php echo esc_html__( "We're sorry, but the page you were looking for doesn't exist.", 'propertya' ); ?></p>
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-theme"><i class="fas fa-home"></i>  <?php echo esc_html__('  Go to Home', 'propertya' ); ?></a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="error-thumbnail text-center">
                            <img src="<?php echo esc_url(trailingslashit(get_template_directory_uri())."libs/images/404.png"); ?>" alt="<?php echo esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </section>
<?php get_footer(); 