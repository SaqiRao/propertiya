<?php
 /* Template Name: SignIn Page */ 
/**
 * The template for displaying Pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package propertya
 */
?>
<?php
propertya_restricted_pages();
get_header();
	get_template_part( 'template-parts/authorization/signin' ); 
get_footer();
?>