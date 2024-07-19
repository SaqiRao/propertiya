<?php
$property_id	=	get_the_ID();
$localization = propertya_localization();
$iframe = $thumbnail = $video_id = $thumb_imgs  = $full_img  = $img  = $img_id	= $all_idz = '';
 $all_idz = propertya_framework_fetch_gallery_idz($property_id);

 if(is_array($all_idz) && count($all_idz) > 0 || get_post_meta($property_id, 'prop_video', true ) != "" )
 {
    $allowed_html = propertya_allowed_html();
    $featured_listing = '';
    if (get_post_meta($property_id, 'prop_is_feature_listing', true )!="" && get_post_meta($property_id, 'prop_is_feature_listing', true ) == "1")
    {
       $featured_listing = '<div class="ribbon ribbon-top-right"><span>'.esc_attr($localization['feat']).'</span></div>';
    }
?>
<div class="widget-seprator no-overflow">
    <?php echo wp_kses($featured_listing,$allowed_html); ?>
    <div class="myflex flexslider" >
        <ul class="slides">
        <?php
        
        if(is_array($all_idz) && count($all_idz) > 0)
        {
            
            foreach($all_idz as $images_ids)
            {
                $img_id	=	'';
                if (isset( $images_ids->ID))
                {
                    $img_id	= 	$images_ids->ID;

                }
                else
                {
                    $img_id	=	$images_ids;
                }
                $img  = wp_get_attachment_image_src($img_id, 'propertya-primary-banner');
                $full_img  = wp_get_attachment_image_src($img_id, 'full');
                $thumb_imgs  = wp_get_attachment_image_src($img_id, 'propertya-small-thumb');
                if(wp_attachment_is_image($img_id))
                {
                    
            ?>
                    <li data-thumb="<?php echo esc_url($thumb_imgs[0]); ?>"> <a href="<?php echo esc_url($full_img[0]); ?>" data-fancybox="group">  <img src="<?php echo esc_url( $img[0] ); ?>" alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', TRUE)); ?>" /> </a> </li>
            <?php
                }
               // else
              //  {
                  // echo"else";
                ?>
                    <!-- <li data-thumb="<?php echo esc_url(propertya_defualt_img_url()); ?>"> <a href="<?php echo esc_url(propertya_defualt_img_url()); ?>" data-fancybox="group"> <img src="<?php echo esc_url(propertya_defualt_img_url()); ?>" alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', TRUE)); ?>" /> </a> </li> -->
            <?php
                //}
            }
		}
        

        if( get_post_meta($property_id, 'prop_video', true ) != "" )
			{
				preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', get_post_meta($property_id, 'prop_video', true ), $match);
				if( isset( $match[1] ) && $match[1] != "" )
				{
					$video_id = $match[1];
					$thumbnail = trailingslashit( get_template_directory_uri () ) . "libs/images/video.png";
					$iframe = 'iframe';
					echo '<li data-thumb="'.esc_url($thumbnail).'"><'.$iframe.' width="730" height="413" src="https://www.youtube.com/embed/'. esc_attr($video_id ) . '" allowfullscreen></'.$iframe.'></li>'; 
				}
			}
			?>
        </ul>
    </div>
</div>
<?php
 }
else
                {
                    ?>
<div class="widget-seprator no-overflow">
    
    <div class="myflex flexslider" >
        <ul class="slides">
            <?php echo"hello";?>
            <li data-thumb="<?php echo esc_url(propertya_defualt_img_url()); ?>"> <a href="<?php echo esc_url(propertya_defualt_img_url()); ?>" data-fancybox="group"> <img src="<?php echo esc_url(propertya_defualt_img_url()); ?>" alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', TRUE)); ?>" /> </a> </li>
            </ul>
    </div>
</div>

                    <?php

                }