<?php
 /* Template Name: Author Dashboard */ 
/**
 * The template for displaying Pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package propertya
 */
?>
<?php
if(in_array('propertya-framework/index.php', apply_filters('active_plugins', get_option('active_plugins'))))
{
propertya_check_auth();
get_header(); 
?>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper">
     <?php get_template_part( 'template-parts/dashboard/sidebar/sidebar' ); ?> 
      <div class="main-panel">
        <div class="content-wrapper">
            <button class="offcanvas btn panel-heading" data-toggle="offcanvas">
              <span class="panel-icon">
                <i class="fas fa-bars"></i>
              </span>
            </button>
        <?php get_template_part( 'template-parts/dashboard/content-area/main' ); ?>
        </div>
      </div>
    </div>
  </div>
<?php
}
else
{
wp_redirect(home_url('/'));
}
?>
<?php get_footer(); ?>