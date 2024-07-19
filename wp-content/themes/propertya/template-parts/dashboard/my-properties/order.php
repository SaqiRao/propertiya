<?php
$media = '';
if(propertya_strings('prop_pkg_type') != '' && propertya_strings('prop_pkg_type') == 'per-listing')
{
	if(isset($_GET['listing_id']) && $_GET['listing_id'] !="")
	{
		$author_post_id = $property_id = $listing_auth_id = '';
		$property_id = $_GET['listing_id'];
		if(get_post_meta($property_id, 'prop_payper_lisitng', true ) == "1" && get_post_meta($property_id, 'prop_is_feature_listing', true ) == "1")
		{
			echo propertya_redirect_url(esc_url(get_the_permalink($property_id))); 
			exit;
		}
		$user_id = get_current_user_id();
		if(get_user_meta( $user_id, 'prop_post_id', true) !="" && get_user_meta($user_id, 'user_role_type', true) !="")
		{
			$author_post_id = get_user_meta( $user_id, 'prop_post_id' , true );
			$listing_auth_id = get_post_field('post_author',$property_id);
		}
		if(!empty(get_post_status($_GET['listing_id'])) && $user_id == $listing_auth_id)
		{
			$heading_title = '';
			$checked = true;
			$is_featured = 0;
			if (get_post_meta($property_id, 'prop_payper_lisitng', true ) == "0")
			{
				$checked = false;
				$heading_title = esc_html__('Submission Fee','propertya');
			}
			else
			{
				$is_featured = 1;
				$heading_title = esc_html__('Featured Fee','propertya');
			}
?>

   <div class="row">
      <div class="col-lg-8 col-xl-8 col-md-8 col-sm-12">
         <div class="card">
         	 <div class="card-body">
             <div id="pre-loader" class="loading-req"></div>
                 <div class="status success">
                 		<ul id="breadcrumb-custom">
                          <li><a href="<?php echo esc_url(get_the_permalink().'?page-type=publish'); ?>"><span class="icon fas fa-list"> </span></a></li>
                          <li><a href="<?php echo esc_url(get_the_permalink($property_id)); ?>"><span class="icon icon-beaker"> </span> <?php echo propertya_title_limit(45,$property_id); ?></a></li>
						</ul>
                        <?php if(propertya_strings('prop_order_title')) { ?>
                        <h1><?php echo propertya_strings('prop_order_title'); ?></h1>
                        <?php } ?>
                        <?php if(propertya_strings('prop_order_editor') == true) { ?>
                        <?php echo propertya_strings('prop_order_editor'); ?>
                        <?php } ?>
                  </div>
             </div>
         </div>
      </div>
      <div class="col-lg-4 col-xl-4 col-md-4 col-sm-12 col-12">
         <div class="card">
         		  <?php
				  if(propertya_strings('prop_membership_currency') != '' &&  propertya_strings('prop_perlisting_price') !="") {
					$currecny = '';  
					$currecny = propertya_strings('prop_membership_currency');
				 ?>
                   <div class="pricingTable active">
                        <div class="pricingTable-header">
                            <h3 class="heading"><?php echo esc_html($heading_title); ?></h3>
                        </div>
                        <div class="pricing-content">
                            <ul>
                            	<?php 
								if (get_post_meta($property_id, 'prop_payper_lisitng', true ) == "0")
				  				{?>
                            	<li class="sub-price"><?php echo esc_html__('Submission Fee : ','propertya'); ?><span class="align-details"><sup><?php echo propertya_framework_get_currency_symbol($currecny) ; ?></sup> <?php echo propertya_strings('prop_perlisting_price'); ?></span></li>
                                <?php } ?>
                                <?php
								if(!empty(propertya_strings('prop_perlisting_expiry')))
								{
									if (get_post_meta($property_id, 'prop_payper_lisitng', true ) == "0")
									{
										if(propertya_strings('prop_perlisting_expiry') == '-1')
										{
											echo '<li> '.esc_html__('Duration :','propertya').' <span class="align-details">'.esc_html__('Never Expire','propertya').'</span></li>';
										}
										else
										{
												echo '<li> '.sprintf(__("Duration : %s Days",  'propertya'), '<span class="align-details">' .propertya_strings('prop_perlisting_expiry')) .'</span>'.'</li>';	
										}
									}
								}
                                if(!empty(propertya_strings('prop_perlisting_featured')) && !empty(propertya_strings('prop_perlisting_featured_expiry')))
								{
									if(propertya_strings('prop_perlisting_featured_expiry') == '-1')
									{
										echo '<li> '.esc_html__('Featured For :','propertya').' <span class="align-details">'.esc_html__('Forever','propertya').'</span></li>';
									}
									else
									{
											echo '<li> '.sprintf(__("Featured For : %s Days",  'propertya'), '<span class="align-details">' .propertya_strings('prop_perlisting_featured_expiry')) .'</span>'.'</li>';	
									}
									echo '<li>
											<div>
											  <div class="custom_checkbox">
										<div class="pretty p-default">
											<input class="check_featured" id="1" data-featp="'.propertya_strings('prop_perlisting_featured').'" type="checkbox" '.($checked=='true' ? 'checked disabled  readonly' : '').'>
											<div class="state p-primary">
												<label for="1">'.esc_html__('Featured Fee : ','propertya').'</label> 
											</div>
										</div>
										 <span class="align-details"><sup> '.propertya_framework_get_currency_symbol($currecny).'</sup> '.propertya_strings('prop_perlisting_featured').'</span>
									 </div>
											</div>
									 </li>';
								}
								?>
                            </ul>
                        </div>
                        <?php if (get_post_meta($property_id, 'prop_payper_lisitng', true ) == "0") { ?>
                        <div class="price-Value">
                            <span class="value">
                                <span class="currency"><sup><?php echo propertya_framework_get_currency_symbol($currecny); ?></sup></span>
                                <span class="atcive-pric"><?php echo propertya_strings('prop_perlisting_price'); ?></span>
                                <span class="month">/<?php echo esc_html__('Listing','propertya'); ?></span>
                            </span>
                        </div>
                        <?php } ?>
                        <h3 class="heading"><?php echo esc_html__('Select Payment','propertya'); ?></h3>
                       <?php if(propertya_strings('prop_enable_stripe') == true && propertya_strings('prop_stripe_pub_key') !="" && propertya_strings('prop_stripe_sec_key') !="") { ?>
                          <div id="stripe" class="stripe-button-theme">
                          	<img  src="<?php echo trailingslashit( get_template_directory_uri () ) . "libs/images/stripe-logo.png"; ?>" alt="<?php echo esc_attr(get_post_meta($media, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid">
                          </div>
                          <?php } ?>   
                           <?php if(propertya_strings('prop_enable_paypal') == true && propertya_strings('prop_enable_stripe') == true){ ?>
                          <div class="my-or text-center">
                          <?php echo esc_html__('-- OR --','propertya'); ?>
                          </div>
                          <?php } ?>
						 <?php if(propertya_strings('prop_enable_paypal') == true && propertya_strings('prop_pay_clientid') !="" && propertya_strings('prop_pay_secret') !="") { ?>
                        <div id="for-paypal">
                            <div class="paypal-button-theme mepay">
                            <img src="<?php echo trailingslashit( get_template_directory_uri () ) . "libs/images/paypal-p.png"; ?>" alt="<?php echo esc_attr(get_post_meta($media, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid">
                          	 <img src="<?php echo trailingslashit( get_template_directory_uri () ) . "libs/images/paypal-btn.png"; ?>" alt="<?php echo esc_attr(get_post_meta($media, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid">
                          </div>
                        </div>
                         <?php } ?>
                        <?php if(propertya_strings('prop_enable_razor') == true && propertya_strings('prop_razor_keyid') != '' && propertya_strings('prop_razor_secret') != ''){ ?>
                          <div class="my-or text-center">
                          <?php echo esc_html__('-- OR --','propertya'); ?>
                          </div>
                       
                       <div id="razorpays" class="razorpay-button-theme">
                          	<img  src="<?php echo trailingslashit( get_template_directory_uri () ) . "libs/images/razorpay-logo.png"; ?>" alt="<?php echo esc_attr(get_post_meta($media, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid">
                          </div>
                       
                          <?php } ?>
                    </div>
                  <?php } ?>  
         </div>
      </div>
      <form name="process_payment" method="post">
          <input type="hidden" name="listing_id" value="<?php echo esc_attr($property_id); ?>"/>
          <input type="hidden" name="submission_fee" value="<?php echo esc_attr(propertya_strings('prop_perlisting_price')); ?>"/>
          <input type="hidden" name="is_featuredz" value="<?php echo esc_attr($is_featured); ?>"/>
          <input type="hidden" name="auth_id" value="<?php echo esc_attr($listing_auth_id); ?>"/>
      </form>
   </div>
	<?php
		echo propertya_framework_selected_methods($property_id,$author_post_id);
	  }
		else
		{
			 echo propertya_redirect_url(home_url('/'));
			 exit; 
		}
	}
	else
	{
		echo propertya_redirect_url(home_url('/'));
		exit;
	}
}