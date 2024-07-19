<?php
$local = propertya_localization();
$container= 'container';

if(is_page_template('page-dashboard.php'))
{
	$container = 'container-fluid';
}
$is_transparent = '';
if(get_post_meta( get_the_ID(), 'show_trans_header', true )!="")
{
	if ( wp_is_mobile() ) {
		$is_transparent = '';
	}
	else
	{
		$is_transparent = 'make-me-trans';	
	}
}
$class = '';
if ( is_user_logged_in() )
{
	$class = 'user-authorized-in';	
} 
?>
<div class="sb-header  header-1 <?php echo esc_attr($is_transparent); ?>">
		<div class="<?php echo esc_attr($container); ?>">
			<div class="sb-header-container">
                <?php echo propertya_site_logo(); ?>
				<div class="burger-menu">
					<div class="line-menu line-half first-line"></div>
					<div class="line-menu"></div>
					<div class="line-menu line-half last-line"></div>
				</div>
               <nav class="sb-menu menu-caret submenu-top-border submenu-scale">
                <ul class="menu-items">
					<?php propertya_main_menu( 'main_theme_menu' ); ?>
				
			 </ul>
                   <?php
                  if(in_array('propertya-framework/index.php', apply_filters('active_plugins', get_option('active_plugins'))))
                  {
                  ?>
                            <?php if (propertya_strings('prop_dashboard') == true) { ?>   
                            <ul class="auth-elements <?php echo esc_attr($class); ?>">
                                <?php
                                // login & profile
                                $custom_class = 'disable-registrations ';
                                $add_prop = propertya_framework_get_link('page-dashboard.php');
                                if(in_array('propertya-framework/index.php', apply_filters('active_plugins', get_option('active_plugins'))))
                                {
                                    echo propertya_auth_settings();
                                }
                                if(propertya_strings('prop_other_btn') == true)
                                {
                                    $page_url = '';
                                    if(!empty(propertya_strings('prop_anotherbtn_page')))
                                    {
                                        $page_url = propertya_strings('prop_anotherbtn_page');
                                    }
                                ?>
                                <li class="submit-btn <?php echo esc_attr($custom_class); ?>"><a class="btn btn-theme btn-second" href="<?php echo esc_url(get_the_permalink($page_url)); ?>"> <i class="fas fa-plus-circle h1-menu-plus clr-white "></i> <?php echo propertya_strings('prop_anotherbtn_txt'); ?></a></li>
                                <?php
                                }
                                if(propertya_strings('prop_add_btn') == true)
                                {
                                	?>
                                <li class="submit-btn <?php echo esc_attr($custom_class); ?>"><a class="btn btn-theme" href="<?php echo esc_url($add_prop .'?page-type=submit-property'); ?>"><i class="fas fa-plus-circle h1-menu-plus clr-white "></i><?php echo propertya_strings('prop_addbtn_txt'); ?></a></li>
                                <?php
                                }
                                ?>
                            </ul>
                            <?php } ?> 
                  <?php
                  }
                  ?>
              </nav>
			</div>
		</div>
	</div>
<div class="clearfix"></div>