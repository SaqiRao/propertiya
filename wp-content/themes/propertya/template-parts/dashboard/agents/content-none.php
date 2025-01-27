<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package dwt listing
 */
?>
<div class="alert custom-alert custom-alert--warning" role="alert">
  <div class="custom-alert__top-side">
    <div class="custom-alert__body">
      <h6 class="custom-alert__heading">
       <?php echo esc_html__('No Result Found.', 'propertya'); ?>
      </h6>
      <div class="custom-alert__content">
        <?php echo esc_html__("Sorry, You haven't added any agent yet!", 'propertya'); ?>
      </div>
    </div>
  </div>
</div>