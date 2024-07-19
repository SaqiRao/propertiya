<?php
	$local = propertya_localization();
	propertya_localization_msgs();
	$user_id = get_current_user_id();
?>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item prop-dash">
            <a class="nav-link" href="<?php echo esc_url(get_the_permalink().'?page-type=dashboard'); ?>">
              <i class="fas fa-home menu-icon"></i>
              <span class="menu-title"><?php echo esc_html($local['dashboard']); ?></span>
            </a>
          </li>
          <li class="nav-item prop-profile">
            <a class="nav-link" href="<?php echo esc_url(get_the_permalink().'?page-type=my-profile'); ?>">
              <i class="far fa-user-circle menu-icon"></i>
              <span class="menu-title"><?php echo esc_html($local['profile']); ?></span>
            </a>
          </li>
          <li class="nav-item prop-sub">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="fas fa-list menu-icon"></i>
              <span class="menu-title"><?php echo esc_html($local['my_properties']); ?></span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink().'?page-type=submit-property'); ?>"><?php echo esc_html($local['ad_property']); ?></a></li>
                <li class="nav-item"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink().'?page-type=publish'); ?>"><?php echo esc_html($local['pub']); ?></a></li>
                <li class="nav-item"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink().'?page-type=pending'); ?>"><?php echo esc_html($local['pend']); ?></a></li>
                <li class="nav-item"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink().'?page-type=featured'); ?>"><?php echo esc_html($local['feat']); ?></a></li>
                <li class="nav-item"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink().'?page-type=expired'); ?>"><?php echo esc_html($local['exp']); ?></a></li>
              </ul>
            </div>
          </li>
          <?php 
        
          if(get_user_meta($user_id, 'user_role_type', true) !="" && get_user_meta($user_id, 'user_role_type', true) == "agency" || is_super_admin()) {  ?>
          <li class="nav-item prop-sub">
            <a class="nav-link" data-toggle="collapse" href="#ui-agents" aria-expanded="false" aria-controls="ui-agents">
              <i class="far fa-user menu-icon"></i>
              <span class="menu-title"><?php echo esc_html($local['agents']); ?></span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-agents">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink().'?page-type=add-agents'); ?>"><?php echo esc_html($local['add_new_agent']); ?></a></li>
                <li class="nav-item"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink().'?page-type=view-all-agents'); ?>"><?php echo esc_html($local['view_all_agent']); ?></a></li>
                
                <li class="nav-item"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink().'?page-type=edit-agents'); ?>"><?php echo esc_html($local['edit_agent_list']); ?></a></li>

               

              </ul>
            </div>
          </li>
          <?php } ?>
          <li class="nav-item prop-sub">
            <a class="nav-link" data-toggle="collapse" href="#ui-reviews-prfile" aria-expanded="false" aria-controls="ui-reviews-prfile">
              <i class="far fa-star menu-icon"></i>
              <span class="menu-title"><?php echo esc_html($local['profile_reviews']); ?></span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-reviews-prfile">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink().'?page-type=profile-received-reviews'); ?>"><?php echo esc_html($local['received']); ?></a></li>
                <li class="nav-item"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink().'?page-type=profile-submitted-reviews'); ?>"><?php echo esc_html($local['submitted']); ?></a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item prop-sub">
            <a class="nav-link" data-toggle="collapse" href="#ui-reviews" aria-expanded="false" aria-controls="ui-reviews">
              <i class="far fa-comments menu-icon"></i>
              <span class="menu-title"><?php echo esc_html($local['reviews']); ?></span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-reviews">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink().'?page-type=received-reviews'); ?>"><?php echo esc_html($local['received']); ?></a></li>
                <li class="nav-item"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink().'?page-type=submitted-reviews'); ?>"><?php echo esc_html($local['submitted']); ?></a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo esc_url(get_the_permalink().'?page-type=favourites'); ?>">
              <i class="far fa-heart menu-icon"></i>
              <span class="menu-title"><?php echo esc_html($local['favorites']); ?></span>
            </a>
          </li>
          <?php
		  if(propertya_strings('prop_pkg_type') != '' && propertya_strings('prop_pkg_type') == 'per-listing') { ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo esc_url(get_the_permalink().'?page-type=invoices'); ?>">
              <i class="far fa-file-alt menu-icon"></i>
              <span class="menu-title"><?php echo esc_html($local['invoices']); ?></span>
            </a>
          </li>
         <?php } ?> 
          <li class="nav-item">
            <a class="nav-link" href="<?php echo wp_logout_url(home_url('/')); ?>">
              <i class="fas fa-sign-out-alt menu-icon"></i>
              <span class="menu-title"><?php echo esc_html__("Logout", 'propertya'); ?></span>
            </a>
          </li>    

           
           </ul>
      </nav>