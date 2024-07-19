<?php if( !session_id() ){session_start();}else{}?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
<?php wp_head(); ?>
</head>
<?php

$active_class = '';
if (class_exists('Redux'))
{
	$active_class = 'is-active-plug';
}
?>
<body <?php body_class(array(esc_attr($active_class))); ?>>
<?php wp_body_open(); ?>
<?php
echo propertya_site_spinner();
if(is_page_template('page-signup.php') && propertya_strings('prop_enable_head_foot') == false || is_page_template('page-signin.php') && propertya_strings('prop_enable_head_foot') == false)
{
}
else
{
	echo propertya_site_header();
	if(wp_basename(is_page_template('page-signup.php')) || wp_basename(is_page_template('page-signin.php')) || wp_basename(is_page_template('page-dashboard.php')) || is_singular('property') && propertya_strings('prop_lp_style') == 'classic'){}
	else
	{
		echo propertya_breadcrumb();
	}
}