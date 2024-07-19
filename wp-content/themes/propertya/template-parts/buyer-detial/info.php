<?php 
	$agency_id   =	get_the_ID();
	$agency_street_addr = $agency_email = $agency_mobile = $agency_whats = $agency_office = $agency_fax = $agency_licence = $agency_tax = $agency_url = $agency_location = $agency_fb = $agency_tw = $agency_in = $agency_insta = $agency_you = $agency_pin = '';
	$agency_email = get_post_meta($agency_id, 'agency_email', true );
	$agency_mobile = get_post_meta($agency_id, 'agency_mobile', true );
	$agency_whats = get_post_meta($agency_id, 'agency_whats', true );
	$agency_office = get_post_meta($agency_id, 'agency_office', true );
	$agency_fax = get_post_meta($agency_id, 'agency_fax', true );
	$agency_licence = get_post_meta($agency_id, 'agency_licence', true );
	$agency_tax = get_post_meta($agency_id, 'agency_tax', true );
	$agency_url = get_post_meta($agency_id, 'agency_url', true );
	$agency_location = get_post_meta($agency_id, 'agency_location', true );
	$agency_fb = get_post_meta($agency_id, 'agency_fb', true );
	$agency_tw = get_post_meta($agency_id, 'agency_tw', true );
	$agency_in = get_post_meta($agency_id, 'agency_in', true );
	$agency_insta = get_post_meta($agency_id, 'agency_insta', true );
	$agency_pin = get_post_meta($agency_id, 'agency_pin', true );
	$agency_street_addr = get_post_meta( $agency_id, 'agency_street_addr', true ); 
	if(!empty($agency_mobile) || !empty($agency_whats) || !empty($agency_office) || !empty($agency_fax) || !empty($agency_licence) || !empty($agency_tax) || !empty($agency_url) || !empty($agency_street_addr)) { ?>
    <div class="elements-seprator" id="des">
        <div class="elements-heading">
             <h3> Contact Info</h3>
        </div>     
        <div class="detail-info">
		  
	  <ul class="list-unstyled agt-info">
       <?php if(!empty($agency_street_addr)) { ?>
	   <li class="list-inline-item  w-50 float-left">
		<span class="icon-spn float-left"><i class="fal fa-location-arrow clr-yal pr-1"> </i></span> 
		<span class="float-left">
		 <p class="top-tittle text-capitalize mb-0">Location Address</p>
		 <h3 class="bottom-tittle"><?php echo esc_html($agency_street_addr); ?></h3>	
		</span>   
	   </li>
       <?php } ?>	  
	   <?php if(!empty($agency_office)) { ?>  
	   <li class="list-inline-item w-50 float-left">
		<span class="icon-spn float-left"><i class=" fal fa-phone-rotary clr-yal pr-1"> </i></span> 
		<span class="float-left">
		 <p class="top-tittle text-capitalize mb-0">Office Number</p>
		 <h3 class="bottom-tittle"><?php echo esc_html($agency_office); ?></h3>	
		</span>   
	   </li>
	   <?php } ?>
       <?php if(!empty($agency_mobile)) { ?>
	   <li class="list-inline-item w-50 float-left">
		<span class="icon-spn float-left"><i class="fal fa-mobile-android clr-yal pr-1 "> </i></span> 
		<span class="float-left">
		 <p class="top-tittle text-capitalize mb-0">Contact Number</p>
		 <h3 class="bottom-tittle"><a class="click-reveal phonenumber" href="javascript:void(0)"><?php echo esc_html($agency_mobile); ?></a></h3>	
		</span>   
	   </li>
       <?php } ?>
       <?php if(!empty($agency_whats)) { ?>
       <li class="list-inline-item w-50 float-left">
		<span class="icon-spn float-left"><i class="fab fa-whatsapp clr-yal pr-1 "> </i></span> 
		<span class="float-left">
		 <p class="top-tittle text-capitalize mb-0">WhatsApp</p>
		 <h3 class="bottom-tittle"><?php echo esc_html($agency_whats); ?></h3>	
		</span>   
	   </li>	
	   <?php } ?> 
	   <?php if(!empty($agency_fax)) { ?>  
	   <li class="list-inline-item w-50 float-left">
		<span class="icon-spn float-left"><i class="fal fa-fax clr-yal pr-1 "> </i></span> 
		<span class="float-left">
		 <p class="top-tittle text-capitalize mb-0">Fax Number </p>
		 <h3 class="bottom-tittle"><?php echo esc_html($agency_fax); ?></h3>	
		</span>   
	   </li>
	   <?php } ?>  
	   <?php if(!empty($agency_licence)) { ?>  
	   <li class="list-inline-item w-50 float-left">
		<span class="icon-spn float-left"><i class="fal fa-lock-alt clr-yal pr-1"> </i></span> 
		<span class="float-left">
		 <p class="top-tittle text-capitalize mb-0">Agency License</p>
		 <h3 class="bottom-tittle"><?php echo esc_html($agency_licence); ?></h3>	
		</span>   
	   </li>	  
	   <?php } ?>
       <?php if(!empty($agency_tax)) { ?>  
	   <li class="list-inline-item w-50 float-left">
		<span class="icon-spn float-left"><i class="far fa-shield-alt clr-yal pr-1"> </i></span> 
		<span class="float-left">
		 <p class="top-tittle text-capitalize mb-0">Tax Number </p>
		 <h3 class="bottom-tittle"><?php echo esc_html($agency_tax); ?></h3>	
		</span>   
	   </li>	  
		<?php } ?>  
          <?php if(!empty($agency_url)) { ?>
          <li class="list-inline-item w-50 float-left">
		<span class="icon-spn float-left"><i class="far fa-external-link clr-yal pr-1"> </i></span> 
		<span class="float-left">
		 <p class="top-tittle text-capitalize mb-0">Website Link</p>
		 <h3 class="bottom-tittle"><a href="<?php echo esc_url($agency_url); ?>">View Link</a></h3>	
		</span>   
	   </li>	
		 <?php } ?> 
	  </ul>
	  </div>
    </div>
<?php
}
?>