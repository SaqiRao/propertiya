<?php
$property_id	=	get_the_ID();
$localization = propertya_localization();
$ad_ratings = $get_percentage = array();
$image_id = '';
$get_percentage = propertya_reviews_average($property_id);
if(!empty($get_percentage) && is_array($get_percentage) && count($get_percentage['ratings']) > 0)
{
?>
<div class="widget-seprator">
  <div class="widget-seprator-heading">
    <h3 class="sec-title"><span class="clr-blu"><?php echo esc_html($get_percentage['average']); ?></span> <?php echo esc_html__('Average Based On','propertya'); ?> <span class="clr-blu">(<?php echo esc_html($get_percentage['rated_no_of_times']); ?>)</span> <?php echo esc_html__('Ratings','propertya'); ?></h3>
  </div>
  <div class="review-details">
  	<?php 
	$ad_ratings = array_reverse($get_percentage['ratings']);
	$i = 5; 
	foreach($ad_ratings as $key=>$val)
	{
	?>
  		<div class="my-single-reviews d-flex">
            	<div class="review-percentage align-self-center ">
                <img src="<?php echo esc_url(get_template_directory_uri() . "/libs/images/icons/".$i.".png"); ?>" alt="<?php echo esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid"> 
                </div>
                <div class="review-percentage align-self-center flex-grow-1 bar-margin">
                    <div class="progress stars-<?php echo esc_attr($i); ?>">
                    	<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo esc_attr($val); ?>" aria-valuemin="0" aria-valuemax="100" style="max-width:<?php echo esc_attr($val); ?>%"></div>
  					</div>
                </div>
                <div class="review-percentage align-self-center">
                	<?php echo esc_html($val); ?>%
                </div>
         </div>
    <?php
	$i--;
	}
	?>
  </div>
</div>  
<?php
}