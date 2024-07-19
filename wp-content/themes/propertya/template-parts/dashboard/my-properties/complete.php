<?php
if ( !is_user_logged_in() ) {
    wp_redirect( home_url('/') );
}
if(!empty($_GET['listing_id']) && !empty($_GET['token']) && !empty($_GET['PayerID']))
{
	echo '<div id="pre-loader" class="loading-req is-show-me"></div>';
	$property_id = $_GET['listing_id'];	
	$access_token = $_GET['token'];	
	$payer_id = $_GET['PayerID'];	
	$payment_execute = array(
		'payer_id' => $payer_id
	);
	$json    =   json_encode($payment_execute);
	$json_resp = array();
	$execaution_url = '';
		$related_data = array();
		$related_data = get_option('prop_paypal_data');
		if(!empty($related_data[$property_id]) && is_array($related_data[$property_id]))
		{
			$execaution_url = $related_data[$property_id]['capture_payemnt_url'];
			$access_token = $related_data[$property_id]['access_token'];
			$property_id  = $related_data[$property_id]['property_id'];
			$is_featured = $related_data[$property_id]['is_featured'];
			if(function_exists('propertya_framework_get_post_call_paypal'))
			{
				$json_resp  =   propertya_framework_get_post_call_paypal($execaution_url,$json,$access_token);
				//remove old options
				$related_data[$property_id]  =   array();
        		update_option ('prop_paypal_data',$related_data);
				if($json_resp['state']=='approved')
				{
					echo '<div id="pre-loader" class="loading-req"></div>';
					//store details
					if(isset($is_featured) && $is_featured == 1)
					{
						$featured_for = propertya_strings('prop_perlisting_featured_expiry');
                        if(isset($featured_for) && $featured_for !="" && $featured_for !="0" && $featured_for == '-1')
                        {
                            update_post_meta($property_id, 'prop_feature_listing_for', $featured_for);
                        }
                        else
                        {
                            $now = date('Y-m-d');
                            $date	=	date_create($now);
                            date_add($date,date_interval_create_from_date_string("$featured_for days"));
                            $featured_listing_exp_date	=	 date_format($date,"Y-m-d");
                            update_post_meta($property_id, 'prop_feature_listing_for', $featured_listing_exp_date);
                        }
						update_post_meta($property_id, 'prop_is_feature_listing', 1);
						update_post_meta($property_id, 'prop_feature_listing_date',date('Y-m-d'));
					}
					else
					{
						update_post_meta( $property_id, 'prop_is_feature_listing', 0);
					}
					//simple listing expiry
					$simple_listing_expiry = propertya_strings('prop_perlisting_expiry');
                    if(isset($simple_listing_expiry) && $simple_listing_expiry !="" && $simple_listing_expiry !="0" && $simple_listing_expiry =="-1")
                    {
                        update_post_meta($property_id, 'prop_regular_listing_expiry', '-1');
                    }
                    else
                    {
                        if (get_post_meta($property_id, 'prop_regular_listing_expiry', true) !="" && get_post_meta($property_id, 'prop_regular_listing_expiry', true) =="-1")
                        {}
                        else
                        {
                           $now = date('Y-m-d');
                           $date	=	date_create($now);
                           date_add($date,date_interval_create_from_date_string("$simple_listing_expiry days"));
                           $ad_expiry_date	=	 date_format($date,"Y-m-d");
                           update_post_meta($property_id, 'prop_regular_listing_expiry_date', $ad_expiry_date );    
                           update_post_meta($property_id, 'prop_regular_listing_expiry', $simple_listing_expiry ); 
                        }
                    }
					update_post_meta($property_id, 'prop_payper_lisitng', '1');
					//listing status after payments
					$approval = 'publish';
					if(propertya_strings('property_payment_approval') == 'manual')
					{
						$approval = 'draft';
					}
					$author_id = get_post_field('post_author',$property_id);
					$my_post = array(
						'ID'           => $property_id,
						'post_author'   => $author_id,
						'post_status'   => $approval,
						'post_type' 	=> 'property'
					);
					wp_update_post($my_post);
					$link = get_the_permalink($property_id);
					echo propertya_redirect_url(esc_url(get_the_permalink($property_id))); 
					//save transation record
					$transactionID = $json_resp['transactions'][0]['related_resources'][0]['sale']['id'];
					$total_amount =  $json_resp['transactions'][0]['amount']['total'];
				    $selected_currency  = $json_resp['transactions'][0]['amount']['currency'];
					$currency_symbol = propertya_framework_get_currency_symbol($selected_currency);
					$amountPaid = $currency_symbol.' '. $total_amount;
					$payment_type = 2;
					$paymentStatus = '1';
					$billing_type = esc_html__('Pay Per Listing', 'propertya');
					$paymentDate = date("Y-m-d H:i:s");
					propertya_framework_create_invoices($transactionID,$amountPaid,$payment_type,$paymentStatus,$paymentDate,$property_id,$author_id, $billing_type);
					echo propertya_redirect_url(esc_url(get_the_permalink($property_id))); 
					exit;
				}
			}
		}
}
else
{
	//echo '<div id="pre-loader" class="loading-req is-show-me"></div>';
	echo '<div class="alert custom-alert custom-alert--warning" role="alert">
	  <div class="custom-alert__top-side">
	  <span class="alert-icon custom-alert__icon  fas fa-exclamation-triangle"></span>
		<div class="custom-alert__body">
		  <h6 class="custom-alert__heading">
		   '.esc_html__('Whoops!', 'propertya').'
		  </h6>
		  <div class="custom-alert__content">
			'.esc_html__("Sorry, something went wrong. Please try again, or refresh the page.", 'propertya').'
		  </div>
		</div>
	  </div>
	</div>';
}