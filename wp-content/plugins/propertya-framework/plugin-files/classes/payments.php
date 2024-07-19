<?php
$razorpay_sdk = SB_PLUGIN_PATH.'libs/razorpay-php/Razorpay.php';
require_once($razorpay_sdk);          
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;


if( !function_exists('propertya_framework_selected_methods') )
{ 
	function propertya_framework_selected_methods($listing_id = '', $listing_auth_id = '')
	{
        
	  $featured_listing_price = $submission_price = $currecny =  $paypal_client_id =  '';
	  $currecny = propertya_framework_get_options('prop_membership_currency');
	  $submission_price = propertya_framework_get_options('prop_perlisting_price');
	  $featured_listing_price = propertya_framework_get_options('prop_perlisting_featured');
	  if (get_post_meta($listing_id, 'prop_payper_lisitng', true ) == "0")
	  {
		  $final_amount = $submission_price + $featured_listing_price;
	  }
	  else
	  {
	  	$final_amount = $submission_price;
	  }
	  $subm_txt =  esc_html__('Submission Fee','propertya-theme');
	   if(propertya_framework_get_options('prop_enable_paypal') == true && propertya_framework_get_options('prop_pay_clientid') !="" && propertya_framework_get_options('prop_pay_secret') !="") 
	   {
		  $paypal_client_id =  propertya_framework_get_options('prop_pay_clientid');
	  ?>
<script>
(function() {
	 "use strict";
	 
	  jQuery('.mepay').on('click', function(e) {
        e.preventDefault();
			  jQuery('#pre-loader').show();
			  jQuery.post(get_strings.ajax_url,{action:'prop_user_payments_paypal_perlisting',collect_data:jQuery( "form[name='process_payment']").serialize()}).done( function(response) 
			 {
				    jQuery('#pre-loader').hide();
				    if ( true === response.success )
					{
						window.location.href = response.data.referral_data;
					}
					else
					{
						notify('error', get_strings.whoops, response.data.message); 
					}
			 });
		});
	
})();
</script>
<?php
	}
if(propertya_framework_get_options('prop_enable_stripe') == true && propertya_framework_get_options('prop_stripe_pub_key') !="" && propertya_framework_get_options('prop_stripe_sec_key') !="") { ?>   
		<?php
		 wp_enqueue_script( 'stripe-checkout',  SB_PLUGIN_URL . 'libs/stripe/checkout.js', false, false, true ); ?> 
        <script>
        (function() {
			 "use strict";
			jQuery('#stripe').on('click', function(e){
				 e.preventDefault();
				 var total;
				 var listing_id = jQuery('input:hidden[name=listing_id]').val();
				 var is_feat = jQuery('input:hidden[name=is_featuredz]').val();
				 var is_paid = jQuery('input:hidden[name=is_paid]').val();
				 var handler = StripeCheckout.configure({
				 key: '<?php echo esc_attr(propertya_framework_get_options('prop_stripe_pub_key')); ?>',
				 token: function(token) {
					  jQuery('#pre-loader').show();
					jQuery.post(get_strings.ajax_url,{action:'prop_user_payments_stripe',stripeToken: token.id, stripeEmail: token.email, collect_data:jQuery( "form[name='process_payment']").serialize()}).done( function(response) 
					{
						jQuery('#pre-loader').hide();
						if (true === response.success) {
							notify('success', get_strings.congratulations,response.data.message);
							window.location	=	response.data.referral;
						}
						else {
							  notify('info', get_strings.whoops, response.data.message);
						}
					});
				}
			  });
			  handler.open({
				  name: '<?php echo $subm_txt; ?>',
				  zipcode: false,
				  currency: '<?php echo esc_attr($currecny); ?>',
				  locale: '<?php echo esc_attr(get_locale()); ?>',
		      });
			});
		})();	
        </script>
        <?php
 }
        if(propertya_framework_get_options('prop_enable_razor') == true && propertya_framework_get_options('prop_razor_keyid') !="" && propertya_framework_get_options('prop_razor_secret') !="")
        {
             wp_enqueue_script( 'razorpay-checkout',  SB_PLUGIN_URL . 'libs/razorpay/checkout.js', false, false, true );
        ?>
        <script>
            jQuery(document).on('click', '#razorpays', function (e) {
                 jQuery.post(get_strings.ajax_url,{action:'prop_razor_initialize',collect_data:jQuery( "form[name='process_payment']").serialize()}).done( function(row) 
                 {
                    if (true === row.success)
                    {
                        var options = {
                            "key": '<?php echo propertya_framework_get_options('prop_razor_keyid'); ?>',
                            "amount": row.data.amonut,
                            "currency": row.data.currency,
                            "name":  row.data.author_title,
                            "description": row.data.pay_per_listings,
                            "order_id": row.data.razorpayOrder,
                            "handler": function (response){
                               jQuery('#pre-loader').show();
                                jQuery.post(get_strings.ajax_url,{action:'prop_user_payments_razor',razorpay_payment_id: response.razorpay_payment_id, signature: response.razorpay_signature,order_id:row.data.razorpayOrder,total_amount:row.data.amonut, collect_data:jQuery( "form[name='process_payment']").serialize()}).done( function(response) 
                                {
                                    jQuery('#pre-loader').hide();
                                    if (true === response.success)
                                    {
                                        notify('success', get_strings.congratulations,response.data.message);
                                        window.location	=	response.data.referral;
                                    }
                                    else
                                    {
                                          notify('info', get_strings.whoops, response.data.message);
                                    }
                                });
                            },
                            "prefill": {
                                "name": row.data.author_title,
                                "email":row.data.email,
                                "contact": row.data.mobile
                            },
                            "notes": {
                                "address": row.data.address
                            },
                            "theme": {
                                "color":  row.data.color
                            }
                        };
                        var rzp1 = new Razorpay(options);
                         rzp1.open();
                    }
                    else 
                    {
                          notify('info', get_strings.whoops, response.data.message);
                    }
                });
            });
        </script>
        <?php
        }
 ?>
    <?php    
	}
}


// Ajax handler for razorpay payments
add_action( 'wp_ajax_prop_razor_initialize', 'propertya_framework_pay_razor_initialize' );
if (!function_exists ( 'propertya_framework_pay_razor_initialize' ))
{
	function propertya_framework_pay_razor_initialize()
	{
        $args = $params = array();
		parse_str($_POST['collect_data'], $params);
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin( get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		else
		{
            $api = new Api(propertya_framework_get_options('prop_razor_keyid'), propertya_framework_get_options('prop_razor_secret'));
            $featured_listing_price = propertya_framework_get_options('prop_perlisting_featured');
            $submission_price = propertya_framework_get_options('prop_perlisting_price');
            $currency = propertya_framework_get_options('prop_membership_currency');
            $color = '#2296f9';
            $color = propertya_framework_get_options('prop_theme_clr');
            $property_id = $params['listing_id'];
            $author_id = $params['auth_id'];
            $is_featuredz = $params['is_featuredz'];
            if(isset($is_featuredz) && $is_featuredz == 1)
            {
                if (get_post_meta($property_id, 'prop_payper_lisitng', true ) == "1" && get_post_meta($property_id, 'prop_is_feature_listing', true ) == "0")
                {
                    $grand_total = $featured_listing_price;
                }
                else
                {
                    $grand_total = $submission_price + $featured_listing_price;
                }
            }
            else
            {
                $grand_total = $submission_price;
            }
            $orderData = [
                'receipt'         => $property_id,
                'amount'          => $grand_total * 100, // 2000 rupees in paise
                'currency'        => $currency,
                'payment_capture' => 1 // auto capture
            ];
            $razorpayOrder = $api->order->create($orderData);
            $razorpayOrderId = $razorpayOrder['id'];
            $amount = $orderData['amount'];
            //return data
            $post_author_id = get_post_field('post_author', $property_id);
            $mobile = $email = $author_title = $type = $author_title = '';
            if(get_user_meta($post_author_id, 'user_role_type', true) !="")
            {
                $posted_id = get_user_meta($post_author_id, 'prop_post_id' , true );
                $type = get_user_meta($post_author_id, 'user_role_type', true);
                $author_title = get_the_title($posted_id);
                $email = get_post_meta($posted_id, $type.'_email', true );
                $mobile = get_post_meta($posted_id, $type.'_mobile', true );
                $address = get_post_meta($posted_id, $type.'_street_addr', true );
            }
            $pay_per_listings = esc_html__('Pay Per Listing','propertya-framework');
            $return = array('razorpayOrder' => $razorpayOrderId,'amonut' => $amount,'currency' => $currency,'author_title' => $author_title,'pay_per_listings'=>$pay_per_listings,'email'=>$email,'mobile'=>$mobile,'address'=>$address,'color'=>$color);
            wp_send_json_success($return);
        }
    }
}


// Ajax handler for razorpay payments
add_action( 'wp_ajax_prop_user_payments_razor', 'propertya_framework_pay_razor' );
if (!function_exists ( 'propertya_framework_pay_razor' ))
{
	function propertya_framework_pay_razor()
	{
        $args = $params = array();
		parse_str($_POST['collect_data'], $params);
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin( get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		else
		{
            if (!empty($_POST['razorpay_payment_id']) && !empty($_POST['signature']) && !empty($_POST['order_id']))
            {
                $error = '';
                $success = false;
                $currency = propertya_framework_get_options('prop_membership_currency');
                $api = new Api(propertya_framework_get_options('prop_razor_keyid'), propertya_framework_get_options('prop_razor_secret'));
                $razorpay_payment_id = $_POST['razorpay_payment_id'];
                $signature = $_POST['signature'];
                $order_id = $_POST['order_id'];
                $grand_amonut = $_POST['total_amount'];
                // store temprary data
                try
                {
                    $attributes = array(
                        'razorpay_order_id' => $order_id,
                        'razorpay_payment_id' => $razorpay_payment_id,
                        'razorpay_signature' => $signature
                    );
                    $api->utility->verifyPaymentSignature($attributes);
                    $success = true;
                }
                 catch(SignatureVerificationError $e)
                 {
                    $success = false;
                    $error = $e->getMessage();
                 }
                if ($success === true)
                {
                    $property_id = $params['listing_id'];
					$author_id = $params['auth_id'];
                    $is_featuredz = $params['is_featuredz'];
                   
                    //store details
					if(isset($is_featuredz) && $is_featuredz == 1)
					{
                        $featured_for = propertya_framework_get_options('prop_perlisting_featured_expiry');
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
					$simple_listing_expiry = propertya_framework_get_options('prop_perlisting_expiry');
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
					if(propertya_framework_get_options('property_payment_approval') == 'manual')
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
                    //save transation record
                    $transactionID = $razorpay_payment_id;
                    $total_amount =  number_format($grand_amonut / 100,2);
                    $selected_currency  = $currency;
                    $currency_symbol = propertya_framework_get_currency_symbol($selected_currency);
                    $amountPaid = $currency_symbol.' '. $total_amount;
                    $payment_type = 3;
                    $paymentStatus = '1';
                    $billing_type = esc_html__('Pay Per Listing', 'propertya-framework');
                    $paymentDate = date("Y-m-d H:i:s");
                    propertya_framework_create_invoices($transactionID,$amountPaid,$payment_type,$paymentStatus,$paymentDate,$property_id,$author_id, $billing_type);
                    $return = array('message' => esc_html__('Transaction completed successfully redirecting please wait...', 'propertya-framework'),'referral' => $link);
				    wp_send_json_success($return);
                }
                else
                {
                     $return = array('message' =>$error);
      				 wp_send_json_error($return);
                }
                die();
            }
            else
            {
                $return = array('message' => esc_html__( 'There was an error while processing your request. Please, reload the page and try again.', 'propertya-framework' ));
      		    wp_send_json_error($return);
            }
            
        }
    }
}


// Ajax handler for stripe payments
add_action( 'wp_ajax_prop_user_payments_stripe', 'propertya_framework_pay_stripe' );
if (!function_exists ( 'propertya_framework_pay_stripe' ))
{
	function propertya_framework_pay_stripe()
	{
		$args = $params = array();
		parse_str($_POST['collect_data'], $params);
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin( get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		else
		{
			$submission_price = $simple_listing_expiry = $featured_for = $currency_symbol = $paymentStatus =  $feat_price =  $paidCurrency =  $amountPaid =  $transactionID  = '';
			$price    = propertya_framework_get_options('prop_perlisting_price');
			$featured_price    = propertya_framework_get_options('prop_perlisting_featured');
			$currency = propertya_framework_get_options('prop_membership_currency');
			$submission_price = propertya_framework_get_options('prop_perlisting_price');
			$featured_listing_price = propertya_framework_get_options('prop_perlisting_featured');
			$sec_key  = propertya_framework_get_options('prop_stripe_sec_key');
			$currency_symbol = propertya_framework_get_currency_symbol($currency);
			$simple_listing_expiry = propertya_framework_get_options('prop_perlisting_expiry');
			$featured_for = propertya_framework_get_options('prop_perlisting_featured_expiry');
			if(!empty($price) && !empty($currency))
			{
				$stripe_sdk = SB_PLUGIN_PATH.'libs/stripe/init.php';
				require_once($stripe_sdk);
				$stripe = array(
					"secret_key" => propertya_framework_get_options('prop_stripe_sec_key'),
					"publishable_key" => propertya_framework_get_options('prop_stripe_pub_key'),
				);
				\Stripe\Stripe::setApiKey($stripe['secret_key']);
				$curl = new \Stripe\HttpClient\CurlClient([CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2]);
				\Stripe\ApiRequestor::setHttpClient($curl);
				\Stripe\Stripe::setVerifySslCerts(false);
				try 
				{
					$property_id = $params['listing_id'];
					$author_id = $params['auth_id'];
					// Unique order ID 
   				    $orderID = strtoupper(str_replace('.','',uniqid('', true)));
					$is_featuredz = $params['is_featuredz'];
					if(isset($is_featuredz) && $is_featuredz == 1)
					{
						if (get_post_meta($property_id, 'prop_payper_lisitng', true ) == "1" && get_post_meta($property_id, 'prop_is_feature_listing', true ) == "0")
						{
							$grand_total = $featured_listing_price;
						}
						else
						{
							$grand_total = $submission_price + $featured_listing_price;
						}
					}
					else
					{
						$grand_total = $submission_price;
					}
					
					if( $currency == 'JPY')
					{
						$total_amonut = $grand_total;
					}
					else
					{
						$total_amonut = (number_format($grand_total, 2, '.', '') * 100);
					}
					$customer = \Stripe\Customer::create(array(
						"email" => $_POST['stripeEmail'],
						"source" => $_POST['stripeToken']
					));
					$charge = \Stripe\Charge::create(array(
						"amount" => $total_amonut,
						'customer' => $customer->id,
						"currency" => $currency,
						"receipt_email" =>$_POST['stripeEmail'],
						'metadata' => array(
							'Order ID' =>$orderID
						)
       				 ));
					 // get payment details
					$paymenyResponse = $charge->jsonSerialize();
					if($paymenyResponse['amount_refunded'] == 0 && empty($paymenyResponse['failure_code']) && $paymenyResponse['paid'] == 1 && $paymenyResponse['captured'] == 1)
					{
						// transaction details
						$final_amonut = $paid_amonut = '';
						$paid_amonut = $paymenyResponse['amount'];
						$final_amonut = ($paid_amonut / 100);
						$transactionID  = $paymenyResponse['balance_transaction'];
						$amountPaid = $currency_symbol.' '. $final_amonut;
						$payment_type = 1;
						$billing_type = esc_html__('Pay Per Listing', 'propertya-framework');
						if($paymenyResponse['status'] == 'succeeded')
						{
							$paymentStatus = '1';
						}
						$paymentDate = date("Y-m-d H:i:s");
						propertya_framework_create_invoices($transactionID,$amountPaid,$payment_type,$paymentStatus,$paymentDate,$property_id,$author_id, $billing_type);
						//store details
						if(isset($is_featuredz) && $is_featuredz == 1)
						{
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
                        $simple_listing_expiry = propertya_framework_get_options('prop_perlisting_expiry');
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
						if(propertya_framework_get_options('property_payment_approval') == 'manual')
						{
							$approval = 'draft';
						}
						$my_post = array(
						  'ID'           => $property_id,
						  'post_author'   => $author_id,
						  'post_status'   => $approval,
						  'post_type' 	=> 'property'
  						);
  						wp_update_post($my_post);
						$link = get_the_permalink($property_id);
						$return = array('message' => esc_html__('Transaction completed successfully redirecting please wait...', 'propertya-framework'), 'referral' => $link);
						wp_send_json_success($return);
						die();
					}
				}
				catch(Exception $e)
				{
					$return = array('message' => $e->getMessage());
      				wp_send_json_error($return);
				}
			}
		}
		die();
	}
}

//Record Invoices
if( !function_exists('propertya_framework_create_invoices') )
{ 
	function propertya_framework_create_invoices($transactionID,$amountPaid,$payment_type,$paymentStatus,$paymentDate,$property_id,$author_id,$billing_type)
	{
		$my_post = array(
			'post_title'    => wp_strip_all_tags($transactionID),
            'post_status'	=> 'publish',
            'post_type'     => 'listing-invoices',
			'post_author'   =>  $author_id,
        );
        $new_post_id =  wp_insert_post($my_post);
		update_post_meta( $new_post_id, 'prop_inv_user_id', $author_id);
		update_post_meta( $new_post_id, 'prop_inv_pkg_type', $billing_type);
		update_post_meta( $new_post_id, 'prop_inv_listing_id', $property_id);
		update_post_meta( $new_post_id, 'prop_inv_pay_type', $payment_type);
		update_post_meta( $new_post_id, 'prop_inv_transaction_id', $transactionID);
		update_post_meta( $new_post_id, 'prop_inv_paidcurrency', $amountPaid);
		update_post_meta( $new_post_id, 'prop_inv_status', $paymentStatus);
		update_post_meta( $new_post_id, 'prop_inv_date', $paymentDate);
	}
}

// Ajax handler for stripe payments
add_action( 'wp_ajax_prop_user_payments_paypal_perlisting', 'propertya_framework_pay_paypallive' );
if (!function_exists ( 'propertya_framework_pay_paypallive' ))
{
	function propertya_framework_pay_paypallive()
	{
		$args = $params = array();
		parse_str($_POST['collect_data'], $params);
		if(propertya_framework_get_options('prop_demo') == 1 && !is_super_admin( get_current_user_id()))
		{
			$return = array('message' => esc_html__( 'Disable for Demo.', 'propertya-framework' ));
			wp_send_json_error($return);
		}
		else
		{
			$property_id = intval($params['listing_id']);
			$author_id = intval($params['auth_id']);
			$submission_fee = intval($params['submission_fee']);
			$is_featuredz = $params['is_featuredz'];
			$currecny = propertya_framework_get_options('prop_membership_currency');
			$submission_price = propertya_framework_get_options('prop_perlisting_price');
			$featured_listing_price = propertya_framework_get_options('prop_perlisting_featured');
			$client_id = propertya_framework_get_options('prop_pay_clientid');
			$client_secret = propertya_framework_get_options('prop_pay_secret');
			
			if(isset($is_featuredz) && $is_featuredz == 1)
			{
				if (get_post_meta($property_id, 'prop_payper_lisitng', true ) == "1" && get_post_meta($property_id, 'prop_is_feature_listing', true ) == "0")
				{
					$grand_total = $featured_listing_price;
				}
				else
				{
					$grand_total = $submission_price + $featured_listing_price;
				}
			}
			else
			{
				$grand_total = $submission_price;
			}
			//paypal settings
     		$enviornment = 'sandbox';
			$enviornment = propertya_framework_get_options('prop_paypal_mode');
			$env_host = 'https://api.sandbox.paypal.com';
			if($enviornment == 'live')
			{
				$env_host = 'https://api.paypal.com';
			}
			$main_url                =   $env_host.'/v1/oauth2/token'; 
			//grant token
			$access_token = '';
			if(function_exists('propertya_framework_get_access_token_paypal'))
			{
           		 $access_token  =   propertya_framework_get_access_token_paypal($main_url,$client_id,$client_secret);
       		}
			//create payment
			$request_url                =   $env_host.'/v1/payments/payment';
			$cancel_link = propertya_framework_get_link('page-dashboard.php')."?page-type=order-complete&listing_id=$property_id";
			$return_link = propertya_framework_get_link('page-dashboard.php')."?page-type=process-payemnts&listing_id=$property_id";
			$payment = array(
				'intent' => 'sale',
				'redirect_urls' => array(
					'return_url' => $return_link,
					'cancel_url' => $cancel_link
				),
				'payer' => array("payment_method" => "paypal"),
			);
			//Create Payment Object
			$payment['transactions'][0] = array(
			'amount' => array(
				'total' => $grand_total,
				'currency' => $currecny,
				'details' => array(
					'subtotal' => $grand_total,
					'tax' => '0.00',
					'shipping' => '0.00'
					)
				),
			'description' => $description
			);
			if(isset($is_featuredz) && $is_featuredz == 1)
			{
				if (get_post_meta($property_id, 'prop_payper_lisitng', true ) == "1" && get_post_meta($property_id, 'prop_is_feature_listing', true ) == "0")
				{
					$payment['transactions'][0]['item_list']['items'][] = array(
						'quantity' => '1',
						'name' => esc_html__('Featured Listing Price','propertya-framework'),
						'price' => $featured_listing_price,
						'currency' => $currecny,
						'sku' => $property_id,
					);
				}
				else
				{
					$payment['transactions'][0]['item_list']['items'][] = array(
						'quantity' => '1',
						'name' => esc_html__('Submission Fee','propertya-framework'),
						'price' => $submission_price,
						'currency' => $currecny,
						'sku' => $property_id,
					);
					$payment['transactions'][0]['item_list']['items'][] = array(
						'quantity' => '1',
						'name' => esc_html__('Featured Listing','propertya-framework'),
						'price' => $featured_listing_price,
						'currency' => $currecny,
						'sku' => $property_id,
					);
				}
			}
			else
			{
				$payment['transactions'][0]['item_list']['items'][] = array(
					'quantity' => '1',
					'name' => esc_html__('Submission Fee','propertya-framework'),
					'price' => $submission_price,
					'currency' => $currecny,
					'sku' => $property_id,
				);
			}
			
			$json       =   json_encode($payment);
			$json_resp = array();
			if(function_exists('propertya_framework_get_post_call_paypal'))
			{
				$json_resp  =   propertya_framework_get_post_call_paypal($request_url, $json,$access_token);
			}
			if($json_resp['state'])
			{
				$capture_payemnt_url = $final_url = '';
				foreach ($json_resp['links'] as $link)
				{
					if($link['rel'] == 'execute')
					{
					  $capture_payemnt_url = $link['href'];
					}
					else if($link['rel'] == 'approval_url')
					{
						$current_url       = $link['href'];
					}
				}
				//save settings to options
				$final_data = $payment_options = array();
				$payment_options['capture_payemnt_url']     =   $capture_payemnt_url;
				$payment_options['access_token']     =           $access_token;
				$payment_options['property_id']     =           $property_id;
				$payment_options['is_featured']     =           $is_featuredz;
				$final_data[$property_id]   =   $payment_options;
				update_option('prop_paypal_data',$final_data);
				$return = array('referral_data' => $current_url);
				wp_send_json_success($return);
				die();
			}
			else
			{
					$return = array('message' => $json_resp['message']);
					wp_send_json_error($return);
			}
		}
	}
}

// Get Paypal Access Token
if (!function_exists ( 'propertya_framework_get_access_token_paypal' ))
{
	function propertya_framework_get_access_token_paypal($main_url,$client_id,$client_secret)
	{
		$params = array(
                'method' => 'POST',
                'timeout' => 45,
                'redirection' => 5,
                'httpversion' => '1.0',
                'sslverify' => false,
                'blocking' => true,
                'body' =>  'grant_type=client_credentials',
                'headers' => [
                      'Authorization' => 'Basic ' . base64_encode($client_id . ':' . $client_secret),
                      'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
                ],
        );
		$access_token = '';
		$response = wp_remote_post( $main_url, $params ); 
		if ( is_wp_error( $response ) )
		{
		   $error_message = $response->get_error_message();
		  // die($error_message);
		}
		else
		{
			 $response_body = wp_remote_retrieve_body( $response );
             $result = json_decode( $response_body, true );
             $access_token =  $result['access_token'];
		}
		return $access_token;
	}
}

// Post Call For Paypal Payments
if (!function_exists ( 'propertya_framework_get_post_call_paypal' ))
{
	function propertya_framework_get_post_call_paypal($request_url,$json,$access_token)
	{
		$params = array(
                'method' => 'POST',
                'timeout' => 45,
                'redirection' => 5,
                'httpversion' => '1.0',
                'sslverify' => false,
                'blocking' => true,
                'body' =>  $json,
                'headers' => [
                      'Authorization' =>'Bearer '.$access_token,
					  'Accept'        =>'application/json',
                      'Content-Type'  =>'application/json'
                ],
        );
		$result = array();
		$response = wp_remote_post($request_url, $params);
		if ( is_wp_error( $response ) )
		{
		   $error_message = $response->get_error_message();
		   die($error_message);
		}
		else
		{
			$response_body = wp_remote_retrieve_body( $response );
			$result = json_decode( $response_body, true );
		} 
		return $result;
	}
}