<?php
if(in_array('propertya-framework/index.php', apply_filters('active_plugins',get_option('active_plugins'))))
{
get_header(); ?>
<?php
if (have_posts()): while ( have_posts()){the_post();
	get_template_part('template-parts/buyer-detial/style-type/classic');
}
else:
 get_template_part( 'template-parts/content', 'none' );
endif;
?>
<?php get_footer();
}
?>