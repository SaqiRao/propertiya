<?php 
$property_id	=	get_the_ID();
$features_list = array();
$features_list = wp_get_object_terms($property_id,array('property_feature'), array('orderby'=>'name','order'=> 'ASC'));
if(!empty($features_list) && is_array($features_list) && count($features_list) > 0)
{
	 if (!is_wp_error($features_list))
	 {
?>
<div class="widget-seprator listing-features clearfix">
	<div class="widget-seprator-heading">
         <h3 class="sec-title"><i class="fas fa-list"></i> <?php echo esc_html(propertya_strings('prop_features')); ?></h3>
    </div>     
     <ul class="list-unstyled">
     <?php
	 $image_id =  $feature_img = '';
	 foreach( $features_list as $features )
	 {
	 ?>	 
         <li class="list-inline-item">
         <?php
		 if(get_term_meta($features->term_id, 'property_feature_term_meta_img', true )!="")
		 {
			$image_id = get_term_meta($features->term_id, 'property_feature_term_meta_img', true);
			echo wp_get_attachment_image($image_id, 'thumbnail');
		 }
		 ?>
		 <span><?php echo esc_html($features->name); ?></span>
         </li>
     <?php
	 }
	 ?>
     </ul>
</div>
<?php
	 }
}