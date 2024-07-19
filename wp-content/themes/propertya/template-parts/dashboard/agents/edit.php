
<?php
   global $localization;
   $user_id = get_current_user_id();
    $agency_id = '';
    $agent_agency_id='';
   if(get_user_meta( $user_id, 'prop_post_id' , true ) !="")
   {
	  $agency_id = get_user_meta( $user_id, 'prop_post_id' , true );
	 // $agent_agency_id = get_post_meta( $user_id, 'prop_post_id' , true );
   }
 $agent_agency_id = $_GET['id']  ;


?>
   <div class="row">
      <div class="col-lg-8 col-xl-8 col-md-8 col-sm-12">
         <div class="grid-margin">
         	<form class="my-form" name="agent_list" method="POST" id="agent_listing_edit">
            <div class="card">
               <div class="card-body">
                  <h4 class="card-title"><?php echo esc_html($localization['edit_new_agent']); ?></h4>
                  
                  <!-------------------------------------------------------------------->

                   <div class="theme-row">
                     <label><?php echo esc_html($localization['agent-listings']); ?> 
                        <?php

                       $listing= get_user_meta($user_id, 'prop_pack_totallistings');
                       $listing = implode($listing);
                       echo " (Max Allow Listing = " . $listing . ")" ;?>

                    </label>
                     <span class="wrap">
                     <input type="Number" min="1" data-sanitize="trim" name="list" value="" class="form-control text"> 
                     </span> 
                  </div>
                  
               </div>
            </div>
            <input type="hidden" name="usertype" id="usertype" value="agent">
            <input type="hidden" name="agency_id" id="agency_id" value="<?php echo esc_attr($agency_id); ?>">
            <input type="hidden" name="agency_agent_id" id="agency_agent_id" value="<?php echo esc_attr($agent_agency_id); ?>">
            <?php wp_nonce_field( 'prop-register-nonce', 'register_nonce' ); ?>
            <button type="submit" class="btn btn-theme btn-primary"><?php echo esc_html($localization['edit_new_agent']); ?></button>  
			</form>
         </div>
      </div>
     
         </div>
      </div>
   </div>