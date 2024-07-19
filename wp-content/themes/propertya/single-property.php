<?php
if(in_array('propertya-framework/index.php', apply_filters('active_plugins',get_option('active_plugins'))))
{
get_header(); ?>
<?php
$localization = propertya_localization();
if (have_posts()): while ( have_posts()){the_post();
   // echo 'prop style type is '.propertya_strings('prop_lp_style');
	if (propertya_strings('prop_lp_style') == 'elegent')
	{
		 get_template_part('template-parts/listing-detial/style-type/elegent');
	}
    else if (propertya_strings('prop_lp_style') == 'classic')
	{
		 get_template_part('template-parts/listing-detial/style-type/classic');
	}
    else
    {
        
    }
}
else:
 get_template_part( 'template-parts/content', 'none' );
endif;
?>
<?php get_footer();
}
?>