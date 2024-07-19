<?php
if(is_page_template('page-signup.php') && propertya_strings('prop_enable_head_foot') == false || is_page_template('page-signin.php') && propertya_strings('prop_enable_head_foot') == false)
{
}
else
{
	echo propertya_site_footer();
}
?>


<?php wp_footer(); ?>
</body>
</html>