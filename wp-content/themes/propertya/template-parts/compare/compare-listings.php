<?php
if(in_array('propertya-framework/index.php', apply_filters('active_plugins', get_option('active_plugins'))))
{
    if(propertya_strings('prop_show_compare_listing') !="" && propertya_strings('prop_show_compare_listing') =="1")
        {
?>    
<div id="compare-toolbox" class="">
    
<div class="panel">
<div class="panel-heading">
<span class="panel-icon">
<i class="fas fa-random"></i>
</span>
<span class="panel-title"><?php echo propertya_strings('prop_compare_heading'); ?></span>
</div>
<div class="panel-body ">  
    <div class="dynamic_compare">
        <?php
         $comparison_ids = array();
         
         if(!empty($_SESSION['compare_listings']) && is_array($_SESSION['compare_listings']) && count($_SESSION['compare_listings']) > 0)
         {
            foreach ($_SESSION['compare_listings'] as $compare_id)
            {
                 $comparison_ids[] = $compare_id;
            }
            // query
            $args = array(  
                'post_type' => 'property',
                'post_status' => 'publish',
                'posts_per_page' => 3,
                'post__in'=> $comparison_ids,
                 'fields' => 'ids',
                'orderby' => 'date', 
                'order' => 'DESC',
            );
             $results = new WP_Query( $args );
             $page_link = '#';
             if ( $results->have_posts() )
             {
                   $page_link = propertya_framework_get_link('page-compare.php');
                   
                 $all_idz = '';
                 $i = 1;
                 while ( $results->have_posts() ) 
                 {
                     $results->the_post();
                     $property_id = get_the_ID();
                     $all_idz = propertya_framework_fetch_gallery_idz($property_id);
                     if ($i == 2 || $i == 3){ echo'<div class="vsbox">vs</div>'; }
                     echo '<div class="compare-listings-box">
                          <a href="javascript:void(0)" class="remove_compare_list" data-property-id="'.esc_attr($property_id).'"><i class="fas fa-times"></i></a>
                          <a class="clr-black" href="'.esc_url(get_the_permalink($property_id)).'"> <img class="img-fluid" src="'.esc_url(propertya_framework_img_src($all_idz,'propertya-blog-thumb')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'"></a>
                        </div>';
                     $i++;
                 }
                 echo '<div class="compare-action-btns">
                    <a class="btn btn-theme btn-block btn-custom-sm" href="'.esc_url($page_link).'">'.esc_html__('Compare','propertya').'</a>
                    <a class="btn btn-warning btn-block btn-custom-sm clear-all-compare">'.esc_html__('Clear All','propertya').'</a>
                 </div>
                 ';
             }
             wp_reset_postdata(); 
         }
         else
         {
             echo propertya_strings('prop_empty_list');
         }
        ?>
    </div>
</div>
</div>
</div>
<?php
}
}
 //unset( $_SESSION[ 'compare_listings' ] );