<?php
 /* Template Name: Compare Properties */ 
/**
 * The template for displaying Pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package propertya
 */
?>
<?php
if(in_array('propertya-framework/index.php', apply_filters('active_plugins', get_option('active_plugins'))))
{
     get_header(); 
     $comparison_ids = array();
     $localization   =   propertya_localization();
     if(!empty($_SESSION['compare_listings']) && is_array($_SESSION['compare_listings']) && count($_SESSION['compare_listings']) > 0)
     {
       $status = $type_term    = $offer_type  = $features_html  = $year = $grages = $baths = $beds = $land = $size = $pro_id = $type = $img_link =  $all_idz = $selected_pricelabel_after = $optional_price = $final_price = $get_all_prices = $title = $comp_beds =  $bedrooms = ''; 
        $allowed_html = propertya_allowed_html();
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
         if ( $results->have_posts() )
         {
             while ( $results->have_posts()) 
             {
                 $results->the_post();
                 $property_id = get_the_ID();
                 //price
                 $get_all_prices =  propertya_framework_fetch_price($property_id);
                 if(!empty($get_all_prices) && is_array($get_all_prices) && count($get_all_prices) > 0 && array_key_exists("main_price",$get_all_prices))
                 {
                       if (array_key_exists("optional_price",$get_all_prices))
                       {
                           $optional_price = $get_all_prices['optional_price'];
                       }
                       if (array_key_exists("after_prefix",$get_all_prices))
                       {
                           $selected_pricelabel_after = '<small>'.$get_all_prices['after_prefix'].'</small>';
                       }
                   $final_price = '
                       <div class="pricz">
                          <div class="zitem-price"><span class="clr-yal">'.$get_all_prices['main_price'].'</span> '. $selected_pricelabel_after.' </div>
                       </div>
                     ';
                 }
                 else
                 {
                     $final_price = '---';
                 }

                 //gallery
                 $all_idz = propertya_framework_fetch_gallery_idz($property_id);
                 if(!empty($all_idz) && is_array($all_idz))
                 {
                     $img_link .='<td class="border-top-0 w-25"> <div class="compare-img-box"> <a class="clr-black" href="'.esc_url(get_the_permalink($property_id)).'"><img class="img-fluid" src="'.esc_url(propertya_framework_img_src($all_idz,'propertya-blog-thumb')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'"></a>
                     <div class="compare-title">
                     <a href="'.esc_url(get_the_permalink($property_id)).'"><h1>'.get_the_title($property_id).'</h1></a></div>
                     </div>
                     <div class="compare-price">
                        '.$final_price .'
                     </div>
                     </td>';
                 }

                 //property type
                 if(get_post_meta($property_id, 'prop_type', true ) !="")
                 {
                     $prop_type   = get_post_meta( $property_id, 'prop_type', true );
                     $type_term    = propertya_get_term($prop_type,'property_type');
                     $type.='<td><a href="'.esc_url(get_term_link($type_term->slug, 'property_type')).'">'.esc_html($type_term->name).'</a></td>';
                 }
                 else
                 {
                      $type.='<td>---</td>';
                 }
                 //property id
                 if(get_post_meta($property_id, 'prop_refer', true ) !="")
                 {
                      $pro_id.='<td>'.get_post_meta($property_id, 'prop_refer', true ).'</td>';
                 }
                 else
                 {
                      $pro_id.='<td>---</td>';
                 }
                 //offer type
                 if(get_post_meta( $property_id, 'prop_offer_type', true ) !="")
                 {
                     $offer_type = get_post_meta( $property_id, 'prop_offer_type', true );
                     $type_term    = propertya_get_term($offer_type,'property_status');
                     $status.='<td class="off-type"><a href="'.esc_url(get_term_link($type_term->slug, 'property_status')).'">'.esc_html($type_term->name).'</a></td>';
                 }
                 else
                 {
                     $status.='<td>---</td>';
                 }

                 //property size
                 if(get_post_meta($property_id,'prop_area_size', true )!="")
                 {
                     $area_prefix = $area ='';
                     $area = number_format(get_post_meta($property_id,'prop_area_size', true ));
                     $area_prefix = get_post_meta($property_id,'prop_area_prefix', true );
                     $size.='<td>'. esc_html($area.' '.$area_prefix).'</td>';
                 }
                 else
                 {
                      $size.='<td>---</td>';
                 }
                 //property land
                 if(get_post_meta($property_id,'prop_land_size', true )!="")
                 {
                     $prop_land_prefix = $prop_land_size ='';
                     $prop_land_size = number_format(get_post_meta($property_id,'prop_land_size', true ));
                     $prop_land_prefix = get_post_meta($property_id,'prop_land_prefix', true );
                     $land.='<td>'. esc_html($prop_land_size.' '.$prop_land_prefix).'</td>';
                 }
                 else
                 {
                      $land.='<td>---</td>';
                 }
                 // bedrooms
                 if(get_post_meta($property_id,'prop_beds_qty', true )!="")
                 {
                      $beds.='<td>'. esc_html(sprintf('%02d',get_post_meta($property_id,'prop_beds_qty', true ))).'</td>';
                 }
                 else
                 {
                      $beds.='<td>---</td>';
                 }
                 // baths
                 if(get_post_meta($property_id,'prop_baths_qty', true )!="")
                 {
                      $baths.='<td>'. esc_html(sprintf('%02d',get_post_meta($property_id,'prop_baths_qty', true ))).'</td>';
                 }
                 else
                 {
                      $baths.='<td>---</td>';
                 }
                 // grages
                 if(get_post_meta($property_id,'prop_garage_qty', true )!="")
                 {
                      $grages.='<td>'. esc_html(sprintf('%02d',get_post_meta($property_id,'prop_garage_qty', true ))).'</td>';
                 }
                 else
                 {
                      $grages.='<td>---</td>';
                 }
                 // year build
                 if(get_post_meta($property_id,'prop_year_build', true )!="")
                 {
                      $year.='<td>'. esc_html(get_post_meta($property_id,'prop_year_build', true )).'</td>';
                 }
                 else
                 {
                      $year.='<td>---</td>';
                 }
                 //features
                 $features_list = array();
                 $features_list = wp_get_object_terms($property_id,array('property_feature'), array('orderby'=>'name','order'=> 'ASC'));
                 if(!empty($features_list) && is_array($features_list) && count($features_list) > 0)
                 {
                     if (!is_wp_error($features_list))
                     {
                         $features_html .= '<td><ul class="custom-list">';   
                         $anem_img = $img_atts = $image_id =  $feature_img = '';
                         foreach( $features_list as $features )
                         {
                             $anem_img = '';
                            if(get_term_meta($features->term_id, 'property_feature_term_meta_img', true )!="")
                            {
                                $image_id = get_term_meta($features->term_id, 'property_feature_term_meta_img', true);
                                $img_atts = wp_get_attachment_image_src($image_id, 'full');
                                $anem_img =   '<img src='.$img_atts[0].' alt="'.esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', TRUE)).'">';
                            }
                            $features_html .= ' <li>
                                '.$anem_img.'
                                <span>'.esc_html($features->name).'</span>
                            </li>';
                         }
                         $features_html .= '</ul></td>';   
                     }
                 }
             }
         }
         wp_reset_postdata(); 
         require trailingslashit(get_template_directory()) . 'template-parts/compare/compare-detial.php';
     }
     else
     {
       echo propertya_compare_msg();
       $_SESSION = array(); 
       unset($_SESSION['compare_listings']);
     }
}
?>
<?php get_footer(); ?>