<?php
$property_id	=	get_the_ID();
$localization = propertya_localization();
?>
<div class="widget-seprator">
  <div class="widget-seprator-heading">
    <h3 class="sec-title"><i class="fas fa-comment-dots"></i> <?php echo esc_html(propertya_strings('prop_review_form')); ?></h3>
  </div>
  <form name="listing_rating" method="POST" id="prop_listing_rating">
    <div class="row">
      <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
        <div class="single-rating">
          <label><?php echo esc_html($localization['rating']); ?></label>
        </div>
        <div class="rating-group">
          <label class="rating-label" for="one-star">
              <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
          </label>
          <input class="rating-group-input" name="review-rating" id="one-star" value="1" type="radio" checked />
          <label class="rating-label" for="two-star">
              <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
          </label>
          <input class="rating-group-input" name="review-rating" id="two-star" value="2" type="radio" />
          <label class="rating-label" for="three-star">
              <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
          </label>
          <input class="rating-group-input" name="review-rating" id="three-star" value="3" type="radio" />
          <label  class="rating-label" for="four-star">
              <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
          </label>
          <input class="rating-group-input" name="review-rating" id="four-star" value="4" type="radio" />
          <label  class="rating-label" for="five-star">
              <i class="rating-star-icon rating-star-icon--star fa fa-star"></i>
          </label>
          <input class="rating-group-input" name="review-rating" id="five-star" value="5" type="radio" />
        </div>
      </div>
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="theme-row">
          <label><?php echo esc_html($localization['review_title']); ?> <span class="req-mark">*</span></label>
          <span class="wrap">
          <input type="text" autocomplete="off" data-sanitize="trim" data-validation="required" data-validation-error-msg-required="<?php echo esc_attr($localization['all_fields_error']); ?>" class="form-control text" name="review-title" />
          </span> </div>
      </div>
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="theme-row">
          <label><?php echo esc_html($localization['your_review']); ?> <span class="req-mark">*</span></label>
          <span class="wrap">
          <textarea cols="10" class="form-control text" autocomplete="off" data-validation="required" data-validation-error-msg-required="<?php echo esc_attr($localization['all_fields_error']); ?>" data-sanitize="trim" rows="6"  name="review-msg"></textarea>
          </span> </div>
      </div>
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-3">
        <?php wp_nonce_field( 'prop-rating-nonce', 'rating_nonce' ); ?>
        <input type="hidden" name="listing_id" value="<?php echo esc_attr($property_id); ?>">
        <button type="submit" class="btn btn-theme review-button"><?php echo esc_html__('Submit Review','propertya'); ?></button>
      </div>
    </div>
  </form>
</div>
