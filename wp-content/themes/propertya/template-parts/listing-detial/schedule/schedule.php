<?php 
	  $property_id	=	get_the_ID();
	  $localization = propertya_localization();
	  $hours = propertya_fetch_hours(0, 86400, 60 * 30, 'h:i A'); 
?>
<div class="widget-seprator schedule-tour">
    <div class="widget-seprator-heading">
     <h3 class="sec-title"><i class="fas fa-history"></i> <?php echo esc_html(propertya_strings('prop_tour_sch')); ?> </h3>
    </div> 
    <form name="schedule_tour" method="POST" id="prop_schedule_tour">
           <div class="row">
           <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="theme-row">
               <label><?php echo esc_html__('Type','propertya'); ?> <span class="req-mark">*</span></label>
               <span class="wrap">
               <select class="theme-selects" name="schedule_type">
                       <option value="in person">in person</option>
                       <option value="Video">Video</option>
               </select>
               </span> 
            </div>
        </div>                        
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="theme-row">
               <label><?php echo esc_html__('Date','propertya'); ?> <span class="req-mark">*</span></label>
               <span class="wrap">
               <input type="date" autocomplete="off" data-sanitize="trim" data-validation="required" data-validation-error-msg-required="<?php echo esc_attr($localization['all_fields_error']); ?>" class="form-control text" name="tour-date" />
               </span> 
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="theme-row">
               <label><?php echo esc_html__('Time','propertya'); ?> <span class="req-mark">*</span></label>
               <span class="wrap">
               <?php if(!empty($hours) && is_array($hours)) { ?>
               <select class="theme-selects" name="schedule_time">
               		   <?php foreach($hours as $seleted) { ?>
                       <option value="<?php echo esc_attr($seleted); ?>"><?php echo esc_html($seleted); ?></option>
                       <?php } ?>
               </select>
               <?php } ?>         
               </span> 
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="theme-row">
               <label><?php echo esc_html__('Your Name','propertya'); ?> <span class="req-mark">*</span></label>
               <span class="wrap">
               <input type="text" autocomplete="off" data-sanitize="trim" data-validation="required" data-validation-error-msg-required="<?php echo esc_attr($localization['all_fields_error']); ?>" class="form-control text"  name="your-name" />
               </span> 
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="theme-row">
               <label><?php echo esc_html__('Phone','propertya'); ?> <span class="req-mark">*</span></label>
               <span class="wrap">
               <input type="text" autocomplete="off" data-sanitize="trim" data-validation="required" data-validation-error-msg-required="<?php echo esc_attr($localization['all_fields_error']); ?>" class="form-control text" name="tour-contact" />
               </span> 
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="theme-row">
               <label><?php echo esc_html__('Email','propertya'); ?> <span class="req-mark">*</span></label>
               <span class="wrap">
               <input type="email" autocomplete="off" data-validation="email" data-validation-error-msg="<?php echo esc_attr($localization['all_fields_error']); ?>" data-sanitize="trim" class="form-control text" name="tour-email" />
               </span> 
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        	<div class="theme-row">
               <label><?php echo esc_html__('Your Message','propertya'); ?> <span class="req-mark">*</span></label>
               <span class="wrap">
               <textarea cols="10" autocomplete="off" class="form-control" data-validation="required" data-validation-error-msg-required="<?php echo esc_attr($localization['all_fields_error']); ?>" data-sanitize="trim" rows="5"  name="tour-msg"></textarea>
               </span> 
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <?php wp_nonce_field( 'prop-schedule-nonce', 'schedule_nonce' ); ?>
        <input type="hidden" name="listing_id" value="<?php echo esc_attr($property_id); ?>">
        <button type="submit" class="btn btn-theme sonu-button"><?php echo esc_html__('Send Email','propertya'); ?></button>
        </div>
    </div>
    </form>
</div>