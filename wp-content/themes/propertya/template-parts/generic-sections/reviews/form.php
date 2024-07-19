<?php 
	$single_id   =	get_the_ID();
	$localization = propertya_localization();
	$reference = '';
	$type = '';
	if(is_singular('property-agency'))
	{
		$reference = 'agency';
		$type = 'property-agency';
	}
	if(is_singular('property-agents'))
	{
		$reference = 'agent';
		$type = 'property-agents';
	}
	if(is_singular('property-buyers'))
	{
		$reference = 'buyer';
		$type = 'property-buyers';
	}
?>
<div class="widget-seprator" id="p-write-review">
<?php if(!empty( propertya_strings('prop_settings_detail_reviews_write'))) { ?>
  <div class="widget-seprator-heading">
    <h3 class="sec-title"><?php echo propertya_strings('prop_settings_detail_reviews_write'); ?></h3>
  </div>
<?php } ?>  
  <form name="agency_agent_rating" method="POST" id="agency_agent_rating">
    <div class="row">
    
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
    	<div class="form-group">
        <div class="single-rating">
          <label><?php echo propertya_strings('prop_ag_rev_first'); ?></label>
        </div>
        <div class="rating-group">
          <label class="rating-label" for="one-star-res">
              <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
          </label>
          <input class="rating-group-input" name="responsiveness" id="one-star-res" value="1" type="radio" checked />
          <label class="rating-label" for="two-star-res">
              <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
          </label>
          <input class="rating-group-input" name="responsiveness" id="two-star-res" value="2" type="radio" />
          <label class="rating-label" for="three-star-res">
              <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
          </label>
          <input class="rating-group-input" name="responsiveness" id="three-star-res" value="3" type="radio" />
          <label  class="rating-label" for="four-star-res">
              <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
          </label>
          <input class="rating-group-input" name="responsiveness" id="four-star-res" value="4" type="radio" />
          <label  class="rating-label" for="five-star-res">
              <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
          </label>
          <input class="rating-group-input" name="responsiveness" id="five-star-res" value="5" type="radio" />
        </div>
        </div>
      </div>
      <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
      <div class="form-group">
        <div class="single-rating">
          <label><?php echo propertya_strings('prop_ag_rev_second'); ?></label>
        </div>
        <div class="rating-group">
          <label class="rating-label" for="one-star-comm">
              <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
          </label>
          <input class="rating-group-input" name="communication" id="one-star-comm" value="1" type="radio" checked />
          <label class="rating-label" for="two-star-comm">
              <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
          </label>
          <input class="rating-group-input" name="communication" id="two-star-comm" value="2" type="radio" />
          <label class="rating-label" for="three-star-comm">
              <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
          </label>
          <input class="rating-group-input" name="communication" id="three-star-comm" value="3" type="radio" />
          <label  class="rating-label" for="four-star-comm">
              <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
          </label>
          <input class="rating-group-input" name="communication" id="four-star-comm" value="4" type="radio" />
          <label  class="rating-label" for="five-star-comm">
              <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
          </label>
          <input class="rating-group-input" name="communication" id="five-star-comm" value="5" type="radio" />
        </div>
        </div>
      </div>
      
      <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
      <div class="form-group">
        <div class="single-rating">
          <label><?php echo propertya_strings('prop_ag_rev_third'); ?></label>
        </div>
        <div class="rating-group">
          <label class="rating-label" for="one-star-exp">
              <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
          </label>
          <input class="rating-group-input" name="expertise" id="one-star-exp" value="1" type="radio" checked />
          <label class="rating-label" for="two-star-exp">
              <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
          </label>
          <input class="rating-group-input" name="expertise" id="two-star-exp" value="2" type="radio" />
          <label class="rating-label" for="three-star-exp">
              <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
          </label>
          <input class="rating-group-input" name="expertise" id="three-star-exp" value="3" type="radio" />
          <label  class="rating-label" for="four-star-exp">
              <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
          </label>
          <input class="rating-group-input" name="expertise" id="four-star-exp" value="4" type="radio" />
          <label  class="rating-label" for="five-star-exp">
              <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
          </label>
          <input class="rating-group-input" name="expertise" id="five-star-exp" value="5" type="radio" />
        </div>
        </div>
      </div>
      <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
      <div class="form-group">
        <div class="single-rating">
          <label><?php echo propertya_strings('prop_ag_rev_fourth'); ?></label>
        </div>
        <div class="rating-group">
          <label class="rating-label" for="one-star-ser">
              <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
          </label>
          <input class="rating-group-input" name="services" id="one-star-ser" value="1" type="radio" checked />
          <label class="rating-label" for="two-star-ser">
              <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
          </label>
          <input class="rating-group-input" name="services" id="two-star-ser" value="2" type="radio" />
          <label class="rating-label" for="three-star-ser">
              <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
          </label>
          <input class="rating-group-input" name="services" id="three-star-ser" value="3" type="radio" />
          <label  class="rating-label" for="four-star-ser">
              <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
          </label>
          <input class="rating-group-input" name="services" id="four-star-ser" value="4" type="radio" />
          <label  class="rating-label" for="five-star-ser">
              <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
          </label>
          <input class="rating-group-input" name="services" id="five-star-ser" value="5" type="radio" />
        </div>
       </div> 
      </div>
      
     <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
     <div class="form-group">
        <div class="single-rating">
          <label><?php echo propertya_strings('prop_ag_rev_recommend'); ?></label>
        </div>
        <div class="pretty p-default p-curve">
        <input type="radio" name="recommend" value="1" checked/>
        <div class="state p-primary-o">
            <label><?php echo esc_html__('Yes','propertya'); ?></label>
        </div>
    </div>
    <div class="pretty p-default p-curve">
        <input type="radio" name="recommend" value="0" />
        <div class="state p-primary-o">
            <label><?php echo esc_html__('No','propertya'); ?></label>
        </div>
    </div>
        </div>
      </div>
      
       <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
       <div class="form-group">
        <div class="single-rating">
          <label><?php echo propertya_strings('prop_ag_rev_prop'); ?></label>
        </div>
        <div class="pretty p-default p-curve">
        <input type="radio" name="is-buy" value="1" checked />
        <div class="state p-primary-o">
            <label><?php echo esc_html__('Yes','propertya'); ?></label>
        </div>
    </div>
        <div class="pretty p-default p-curve">
        <input type="radio" name="is-buy" value="0" />
        <div class="state p-primary-o">
            <label><?php echo esc_html__('No','propertya'); ?></label>
        </div>
    </div>
        </div>
      </div>
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="theme-row">
          <label><?php echo propertya_strings('prop_ag_rev_title'); ?> <span class="req-mark">*</span></label>
          <span class="wrap">
          <input type="text" autocomplete="off" data-sanitize="trim" data-validation="required" data-validation-error-msg-required="<?php echo esc_attr($localization['all_fields_error']); ?>" class="form-control text" name="review-title" />
          </span> </div>
      </div>
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="theme-row">
          <label><?php echo propertya_strings('prop_ag_rev_reviews'); ?> <span class="req-mark">*</span></label>
          <span class="wrap">
          <textarea cols="10" class="form-control" autocomplete="off" data-validation="required" data-validation-error-msg-required="<?php echo esc_attr($localization['all_fields_error']); ?>" data-sanitize="trim" rows="5"  name="review-msg"></textarea>
          </span> </div>
      </div>
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-2">
        <?php wp_nonce_field( 'prop-agency-agent-nonce', 'single_rating_nonce' ); ?>
        <input type="hidden" name="single_id" value="<?php echo esc_attr($single_id); ?>">
        <input type="hidden" name="reference" value="<?php echo esc_attr($reference); ?>">
        <button type="submit" class="btn btn-theme review-button" data-spinner-text="<?php echo esc_attr($localization['processing']); ?>"><?php echo esc_html__('Submit Review','propertya'); ?></button>
      </div>
    </div>
  </form>
</div>