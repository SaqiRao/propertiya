<?php
   global $localization;
   $user_id = get_current_user_id();
    $agency_id = '';
   if(get_user_meta( $user_id, 'prop_post_id' , true ) !="")
   {
	  $agency_id = get_user_meta( $user_id, 'prop_post_id' , true );
   }
?>
   <div class="row">
      <div class="col-lg-8 col-xl-8 col-md-8 col-sm-12">
         <div class="grid-margin">
         	<form class="my-form" name="agent_submission" method="POST" id="agent_submission">
            <div class="card">
               <div class="card-body">
                  <h4 class="card-title"><?php echo esc_html($localization['add_new_agent']); ?></h4>
                  <div class="theme-row">
                     <label><?php echo esc_html($localization['username']); ?> <span class="req-mark">*</span></label>
                     <span class="wrap">
                     <input type="text" autocomplete="off" data-sanitize="trim" name="username" class="form-control text" data-validation="required" data-validation-error-msg-required="<?php echo esc_attr($localization['u_required']); ?>">
                     </span> 
                  </div>
                  <div class="theme-row">
                     <label><?php echo esc_html($localization['display_name']); ?>  <i class="far fa-question-circle" data-toggle="popover" data-placement="top" data-content="<?php echo esc_attr($localization['displayname_popover']); ?>"></i></label>
                     <span class="wrap">
                     <input type="text" autocomplete="off" data-sanitize="trim" name="displayname" class="form-control text" data-validation="required" data-validation-error-msg-required="<?php echo esc_attr($localization['all_fields_error']); ?>">
                     </span> 
                  </div>
                  <div class="theme-row">
                     <label><?php echo esc_html($localization['email']); ?> <span class="req-mark">*</span></label>
                     <span class="wrap">
                     <input type="text" data-validation="email" data-sanitize="trim" name="email" class="form-control text" data-validation-error-msg="<?php echo esc_attr($localization['email_required']); ?>">
                     </span> 
                  </div>
                  <div class="theme-row">
                     <label><?php echo esc_html($localization['agent_type']); ?> <span class="req-mark">*</span></label>
                     <span class="wrap">
                     <select class="theme-selects" data-sanitize="trim" name="agent-type" data-placeholder="<?php echo esc_attr__('Select Agent Type','propertya');?>" data-validation="required" data-validation-error-msg-required="<?php echo esc_attr($localization['agent_type_req']); ?>">
             			 <?php propertya_framework_terms_options('agent_types', ''); ?>
					</select>
                     </span> 
                  </div>
                  <div class="theme-row">
                     <label><?php echo esc_html($localization['contact_num']); ?></label>
                     <span class="wrap">
                     <input type="text" data-sanitize="trim" name="agent-mobile" class="form-control text">
                     </span> 
                  </div>
                  <div class="theme-row">
                     <label><?php echo esc_html($localization['pass']); ?> <span class="req-mark">*</span></label>
                     <span class="wrap">
                     <input type="password" data-sanitize="trim" name="password" value="" class="form-control text" data-validation="length" data-validation-length="3-12" data-validation-error-msg="<?php echo esc_attr($localization['pass_required']); ?>"> 
                     </span> 
                  </div>
                  <!-------------------------------------------------------------------->
                   <div class="theme-row">
                     <label><?php echo esc_html($localization['agent-listings']); ?> 
                     <?php
                       $listing= get_user_meta($user_id, 'prop_pack_totallistings');
                       $listing = implode($listing);
                      
                       if(empty($listing))
                       {
                           echo "  (Listing = 0)" ;
                       }
                       else {
                       echo " (Max Allow Listing = " . $listing . ")" ;}?></label> 
                     <span class="wrap">
                     <input type="Number" min="1" data-sanitize="trim" name="list" value="" class="form-control text"> 
                     </span> 
                  </div>
                  <div class="my-checkbox">
                      <input class="magic-checkbox" type="checkbox" name="send_email" id="send_email" value="yes">
  					  <label for="send_email"><?php echo esc_html($localization['snd_email']); ?></label>
                  </div>
               </div>
            </div>
            <input type="hidden" name="usertype" id="usertype" value="agent">
            <input type="hidden" name="agency_id" id="agency_id" value="<?php echo esc_attr($agency_id); ?>">
            <?php wp_nonce_field( 'prop-register-nonce', 'register_nonce' ); ?>
            <button type="submit" class="btn btn-theme btn-primary"><?php echo esc_html($localization['add_new_agent']); ?></button>  
			</form>
         </div>
      </div>
      <div class="col-lg-4 col-xl-4 col-md-4 col-sm-12">
         <div class="grid-margin">
            <div class="card">
               <div class="card-body">
                  <h4 class="card-title"><?php echo esc_html($localization['my_agents']); ?></h4>
                  <?php
				  $get_args = propertya_framework_fetch_my_agents($user_id,'1','6','');
				  $my_listings = new WP_Query($get_args);
                  if ( $my_listings->have_posts() )
                  {
                      $margin = 'ml-auto';
                      if(is_rtl())
                      {
                          $margin = 'mr-auto';
                      }
				  ?>	  
                    <div class="my-agent-list">
                        <div class="list-group list-group-flush ">
                        <?php
                         while ($my_listings->have_posts())
                         {
                            $my_listings->the_post();
                            $agent_id	 =	get_the_ID();
                        ?>
                            <div class="list-group-item d-flex  align-items-center">
                                <div class="m-r-20">
                                    <div class="avatar avatar-sm">
                                   	 <?php echo propertya_framework_agent_feature_img($agent_id,'propertya-user-thumb');?>
                                    </div>
                                </div>
                                <div class="mu-agen-detail">
                                    <h4><a href="<?php echo esc_url(get_the_permalink($agent_id)); ?>"><?php echo get_the_title($agent_id); ?></a></h4>
                                    <?php
									$term = $agent_type = '';
									if(get_post_meta($agent_id, 'agent_type', true ) !="")
									{
										$agent_type =   get_post_meta($agent_id, 'agent_type', true );
										$term       =   get_term_by('slug', $agent_type, 'agent_types');
									?>	
                                    <div class="text-muted"><?php echo esc_html($term->name); ?></div>
                                    <?php
									}
									?>
                                </div>
                                <div class="<?php echo esc_attr($margin); ?>">
                                    <a href="<?php echo esc_url(get_the_permalink($agent_id)); ?>" class="btn btn-white"><?php echo esc_html__('View','propertya'); ?></a>
                                </div>
                            </div>
                        <?php
						 }
						 wp_reset_postdata();
						 ?>
                        </div>
                    </div>
                  <?php
				  }
				  else
				  {
					 get_template_part('template-parts/dashboard/agents/content', 'none'); 
				  }
				  ?>
               </div>
            </div>      
         </div>
      </div>
   </div>