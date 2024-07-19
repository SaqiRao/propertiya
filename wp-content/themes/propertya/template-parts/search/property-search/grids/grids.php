    <?php
global $propertya_options;

$style_layout = get_query_var('list-type');

if((!empty($style_layout) && $style_layout =="grid") || $style_layout =="list")
{
    if ($style_layout =='list'){
     $grid_type = 'list3';
    }else{
        $grid_type= 'type3';
    }

}else
{
    $grid_type = 'type3';


     if(!empty($_GET['list-type'])  &&  $_GET['list-type']  ==   'grid'  )
    {
        $grid_type= 'type3';
    } elseif(!empty($_GET['list-type'])  &&  $_GET['list-type']  ==   'list' )
    {
        $grid_type= 'list3';
    }
     else
        {
            $grid_type = $propertya_options['prop_listing_search_grids'];
        }
    }

$page_type = 'sidebar';
$col_size = '2';
$page_type = propertya_strings('prop_listing_search_layout');
if(!empty($page_type) && $page_type == 'modern')
{
    $col_size = '3';
}
else
{
  $col_size = '2';
}



$map_listings = $fetch_output = '';
$layout_type = new propertya_getlistings();
$my_ma_data =  "";

while ($results->have_posts())
{
    $results->the_post();
    
    $p_id=get_the_ID();
   
    $function = "propertya_listings_$grid_type";
    $fetch_output .= $layout_type->$function( $p_id,$col_size);
   
    $lat = get_post_meta( $p_id, 'prop_latt', true);
    $long  =  get_post_meta( $p_id, 'prop_long', true);
   
	//listing on maps
	if(!empty(propertya_strings('prop_listing_search_layout')) && propertya_strings('prop_listing_search_layout') == 'map')
	{
	    if (get_post_meta( $p_id, 'prop_latt', true) != "" && get_post_meta( $p_id, 'prop_long', true) != "")
		{
			$mapfunction = "propertya_listings_map_listings";
			$map_listings .= $layout_type->$mapfunction( $p_id);   
		}
	}


$all_idz = propertya_framework_fetch_gallery_idz($p_id);
$street_addr= get_post_meta($p_id, 'prop_street_addr', true );
$title=propertya_title_limit(20,$p_id); 

$url_link=esc_url(get_the_permalink($p_id));

//price
$get_all_prices =  propertya_framework_fetch_price($p_id);
    if(!empty($get_all_prices) && is_array($get_all_prices) && count($get_all_prices) > 0 && array_key_exists("main_price",$get_all_prices))
    {
       
        $selected_pricelabel_after = '';
        if (array_key_exists("optional_price",$get_all_prices))
        {
            $optional_price = $get_all_prices['optional_price'];
        }
        if (array_key_exists("after_prefix",$get_all_prices))
        {
            $selected_pricelabel_after = '<small>'.$get_all_prices['after_prefix'].'</small>';
        }
        $price_rent = $get_all_prices['main_price'] . $selected_pricelabel_after;
    }
    else
    {
         $price_rent = 0;
    }
//featured listing
$featured_listing = '';
//$mapbox_data[]='';
if (get_post_meta($p_id, 'prop_is_feature_listing', true ) == "1")
{
    $featured_listing = esc_html($localization['feat']);
}
if($propertya_options['property_opt_map_selection']=='mapbox')
{
   $mapbox_data[] = array(
    "type" => "Feature",
    "properties" => array(
        "id" => $p_id,
        "html" => '<div class="map-in-listings">
        <div class="list-thumbnail"> 
       <img class="img-fluid" src="'.esc_url(propertya_framework_img_src($all_idz,'propertya-blog-thumb')).'">
      <a href= "'.$url_link.'" ></a>'.$featured_listing.'</div>
      <div class="entry-header">
      <div class="my-list2-pricing"><h3><span class="main-reg-price">'. $price_rent.'</h3></div>
      
      <h5 class="card-title"> <a class="clr-black" href= "'.$url_link.'">'. $title. '</a>
      </h5></div>
      <div class="entry-meta">'.$street_addr.'</div>
        </div>',
    ),
    "geometry" => array(
     "type" => "point",
     "coordinates" => [$lat,$long],
       
    ),
);

}
}
$map_data='';
if(!empty(propertya_strings('prop_listing_search_layout')) && propertya_strings('prop_listing_search_layout') == 'map')
{
    if($propertya_options['property_opt_map_selection']=='mapbox')
{
            $map_data   =  json_encode($mapbox_data);
        ?>
        <input type ="hidden" id="map_marker_img" name="img" value=<?php echo get_template_directory_uri()."\libs\images\map-marker.png"?>>
        <input type ="hidden" id="map_layer" name="layer" value=<?php  echo $propertya_options['property_opt_mapbox_layer_selection'] ?>>
        <input type ="hidden" id="map_zoom" name="zoom" value=<?php echo $propertya_options['property_opt_mapbox_zoom_selection']?>>
        <input type ="hidden" id="map_typ" name="typ" value=<?php echo $propertya_options['property_opt_map_selection']?>>

        <?php
            
        echo '<script> var listing_markers_map ='.$map_data .'; </script>';
}
  
        echo '<script> var listing_markers = ['.$map_listings.']; </script>';
  
	
   

}
wp_reset_postdata();
