<?php
	$property_id	=	get_the_ID();
	$currency_sumbol = '$';
	if(!empty(propertya_strings('prop_mortgage_currency')))
	{
		$currency_sumbol = propertya_strings('prop_mortgage_currency');
	}
	//prices
	$mains_price = '';
	if(get_post_meta($property_id, 'prop_first_price', true ) !="")
	{
		$mains_price = get_post_meta($property_id, 'prop_first_price', true );
	}
?>
<div class="sidebar-widget-seprator mortgage-calculator">
        <div class="sidebar-widget-header">
          <h4><?php echo esc_html(propertya_strings('prop_sidebar_mortgage')); ?></h4>
        </div>
    <div class="sidebar-widget-body">
            <div class="widget-inner-container">
            <div class="theme-row">
            <label><?php echo esc_html(propertya_strings('prop_mortgage_initial')); ?> <i class="far fa-question-circle" data-toggle="popover" data-placement="top" data-content="<?php echo esc_attr(propertya_strings('prop_mortgage_initial_hint')); ?>"></i></label>
                <div class="custom-input-group input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><?php echo esc_html($currency_sumbol); ?></span>
                  </div>
                    <input type="number" id="input_value"  class="form-control" value="<?php echo esc_attr($mains_price); ?>">
                </div>
			</div>
            <div class="theme-row">
            <label><?php echo esc_html(propertya_strings('prop_mortgage_downpayment')); ?> <i class="far fa-question-circle" data-toggle="popover" data-placement="top" data-content="<?php echo esc_attr(propertya_strings('prop_mortgage_downpayment_hint')); ?>"></i></label>
                <div class="custom-input-group input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><?php echo esc_html($currency_sumbol); ?></span>
                  </div>
                    <input type="number" id="input_down_payment"  class="form-control">
                </div>
			</div>
            <div class="theme-row">
            <label><?php echo esc_html(propertya_strings('prop_mortgage_intrest')); ?> <i class="far fa-question-circle" data-toggle="popover" data-placement="top" data-content="<?php echo esc_attr(propertya_strings('prop_mortgage_intrest_hint')); ?>"></i></label>
            <div class="custom-input-group  input-group">
            <select id="interest_option" class="theme-selects-group form-control ">
                <option value="Yearly"><?php echo esc_html__('Yearly','propertya'); ?></option>
                <option value="Monthly"><?php echo esc_html__('Monthly','propertya'); ?></option>
              </select>
    		<input type="number" class="form-control" id="input_interest"  placeholder="<?php echo esc_attr__('Enter Percentage','propertya'); ?>" min="2.00" step="0.01">
  </div>
            </div>
            <div class="theme-row">
            <label><?php echo esc_html(propertya_strings('prop_mortgage_term')); ?> <i class="far fa-question-circle" data-toggle="popover" data-placement="top" data-content="<?php echo esc_attr(propertya_strings('prop_mortgage_term_hint')); ?>"></i></label>
                <div class="custom-input-group input-group">
                <select id="term_option" class="theme-selects-group form-control">
                    <option value="Years"><?php echo esc_html__('Years','propertya'); ?></option>
                    <option value="Months"><?php echo esc_html__('Months','propertya'); ?></option>
      			</select>
      			 <input type="number" class="form-control" id="input_duration"  placeholder="<?php echo esc_attr__('Enter Duration','propertya'); ?>" step="1">
                </div>
            </div>
 			<button id="calculate" type="button" class="btn btn-theme"><?php echo esc_html(propertya_strings('prop_mortgage_btn')); ?></button>
   
  </div>

  <div class="listing-specs none">
  	<p><?php echo esc_html__('The remaining dept is','propertya'); ?>: <strong><?php echo esc_html($currency_sumbol).'&nbsp;'; ?><span id="p-remain-dept"></span></strong></p>
    <p><?php echo esc_html__('The monthly rate is','propertya'); ?>: <strong><?php echo esc_html($currency_sumbol).'&nbsp;'; ?><span id="p-m-rate"></span></strong></p>
    <p><?php echo esc_html__('There are','propertya'); ?>: <strong><span id="p-pay-period"></span></strong> <?php echo esc_html__('Payment Periods','propertya'); ?></p>
    <p><?php echo esc_html__('The Monthly Payment','propertya'); ?>: <strong><?php echo esc_html($currency_sumbol).'&nbsp;'; ?><span id="p-monthly-total"></span></strong></p>
    <p><?php echo esc_html__('Total Payment','propertya'); ?>: <strong><?php echo esc_html($currency_sumbol).'&nbsp;'; ?><span id="p-total-pay"></span></strong></p>
    <p><?php echo esc_html__('Total Interest Payment','propertya'); ?>:<strong><?php echo esc_html($currency_sumbol).'&nbsp;'; ?><span id="p-total-intrest"></span></strong></p>

  </div>
                </div>	      
</div>