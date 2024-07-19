<?php
$local = propertya_localization();
$extra_front_padding = $image_id = $is_transparent = '';
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
$defual_img = trailingslashit(get_template_directory_uri()) . 'libs/images/phoneold.png';
global $propertya_options;
if (isset($propertya_options['prop_contact_icon']["url"]) && $propertya_options['prop_contact_icon']["url"] != "") 		
{
	$defual_img = $propertya_options['prop_contact_icon']["url"];
}
if(is_page_template('page-dashboard.php'))
{
	$extra_front_padding = 'extra-front-padding';
}
$class = '';
if ( is_user_logged_in() )
{
	$class = 'user-authorized-in';	
}
?>
<div class="sb-header  nhome-3 <?php echo esc_attr($is_transparent); ?> <?php echo esc_attr($extra_front_padding); ?>">
  <div class="container-fluid  px-0"> 
    <div class="sb-header-container">
    <?php if(propertya_strings('prop_callus_txt') !="" && propertya_strings('prop_contact_no_txt') !="") { ?> 
		<div class="call-us">
		 <div class="call-image">
		  <img src="<?php echo esc_url($defual_img); ?>" class="img-fluid" alt="<?php echo esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', TRUE)); ?>"/>	 
		 </div>
		 <div class="call-text">
		  <p><?php echo propertya_strings('prop_callus_txt'); ?>:</p>
		  <h3><?php echo propertya_strings('prop_contact_no_txt'); ?></h3>	 
		 </div>	
		</div>
       <?php } ?> 
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
					echo propertya_auth_settings();
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
                    <li class="submit-btn <?php echo esc_attr($custom_class); ?>"><a class="btn btn-theme btn-post" href="<?php echo esc_url($add_prop .'?page-type=submit-property'); ?>"><i class="fas fa-plus-circle h1-menu-plus clr-white "></i><?php echo propertya_strings('prop_addbtn_txt'); ?></a></li>
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