<?php
if (!class_exists('propertya_getlistings'))
{
	 class propertya_getlistings 
	 {
		//similiar listings
		function propertya_similiar_listings($property_id)
		{
			$selected_pricelabel_after =  $optional_price = $price_rent = $all_idz = '';
			$get_all_prices = array();
			$localization = propertya_localization();
			$all_idz = propertya_framework_fetch_gallery_idz($property_id);
			//prices
			$get_all_prices =  propertya_framework_fetch_price($property_id);
			if(!empty($get_all_prices) && is_array($get_all_prices) && count($get_all_prices) > 0 && array_key_exists("main_price",$get_all_prices))
			{
			   if (array_key_exists("optional_price",$get_all_prices))
			   {
				   $optional_price = $get_all_prices['optional_price'];
			   }
			   if (array_key_exists("after_prefix",$get_all_prices))
			   {
				   $selected_pricelabel_after = '<span class="clr-blu">'.$get_all_prices['after_prefix'].'</span>';
			   }
			  $price_rent = '<div class="main-rate mb-1"><span class="main-reg-pricing clr-blu">'.$get_all_prices['main_price'].' </span><span class="additional-price-tag">'.$selected_pricelabel_after.'</span></div>';
			}
			$street_addr = '';
			if(get_post_meta($property_id, 'prop_street_addr', true )!="")
			{
				$street_addr = '<p class="extrp"><span><i class="clr-blu fas fa-location-arrow"></i></span>'.get_post_meta($property_id, 'prop_street_addr', true ).'</p>';
			}
			//home features
			$author_dp = $type = $post_author = $home_features = $size = $baths = $rooms = '';
			$rooms =  get_post_meta($property_id,'prop_beds_qty', true );
			$baths =  get_post_meta($property_id,'prop_baths_qty', true );
			$size =  get_post_meta($property_id,'prop_area_size', true );
			if(!empty($rooms) || !empty($baths) || !empty($size))
			{
				$home_features .= '<div class="home-amenties">';
				if(!empty($rooms))
				{
					$home_features .= '<div class="rooms-row"> <span class="d-block  clr-black">'.esc_attr($localization['beds']).'</span> <span class="f-size-14 clr-p">'.esc_attr($rooms).'</span> </div>';
				}
				if(!empty($baths))
				{
					$home_features .= '<div class="rooms-beds"> <span class="d-block clr-black">'.esc_attr($localization['baths']).'</span> <span class="f-size-14 clr-p">'.esc_attr($baths).'</span> </div>';
				}
				if(!empty($size))
				{
					$home_features .= '<div class="rooms-size"> <span class="d-block clr-black">'.esc_attr($localization['size']).'</span> <span class="f-size-14 clr-p">'.esc_attr(number_format((float)$size)).' '.get_post_meta($property_id,'prop_area_prefix', true ).'</span> </div>';
				}
				$home_features .= '</div>';
			}
			//listing author dp
			$type = get_user_meta($post_author, 'user_role_type', true);
			$post_author = get_post_field('post_author', $property_id);
			if(get_user_meta($post_author, 'user_role_type', true) !="")
			{
				$post_id = get_user_meta( $post_author, 'prop_post_id' , true);
				$author_dp = '<div class="listing-author-dp">
							<a href="'.esc_url(get_the_permalink($post_id)).'"><img src="'.esc_url(propertya_placeholder_images($type,$post_id,'propertya-user-thumb')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'" class="img-fluid"></a>
						</div>';	
			}
			//featured listing
			$featured_listing = '';
			if (get_post_meta($property_id, 'prop_is_feature_listing', true ) == "1")
			{
				$featured_listing = '<div class="featured-ribbon" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['feat']).'">
					<div><i class="fas fa-star"></i></div>
				</div>';
			}
            $text_direction = 'text-left';
            $txt_dir = 'text-right';
            $margin = 'ml-3';
            if(is_rtl())
            {
                $text_direction = 'text-right';
                $margin = 'mr-3';
                $txt_dir = 'text-left';
            }
			return '<div class="main-div margin-bottom-30">
           		 <div class="row no-gutters">
              <div class="col-sm-12 col-md-5 col-lg-5 col-12">
                <div class="main-data ">
                  <div class="img-data">
				  <div class="my-prop-img p-relative">
				   <a href="'.esc_url(get_the_permalink($property_id)).'"><img src="'.esc_url(propertya_framework_img_src($all_idz,'propertya-similar')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'" class="img-fluid"></a>
				   <div class="img-overlay"></div>
				   </div>
				   </div>
                  <div class="h2-lies2 my-bookmarks">
                    <ul class="list-unstyled my-3 mx-3 '.esc_attr($txt_dir).'">
                      <li class="list-inline-item"> <button data-compare-id="'.esc_attr($property_id).'" class="btn d-flex justify-content-center align-items-center compare-prop" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['compare']).'"><i class="fas fa-random"></i></button> </li>
                      <li class="list-inline-item"> <button data-fav-id="'.esc_attr($property_id).'" class="btn d-flex justify-content-center align-items-center fav-prop" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['fav']).'"><i class="far fa-heart"></i></button> </li>
                    </ul>
                  </div>
                  <div class="d-btn">
                    <ul class="list-unstyled mb-3 '.esc_attr($margin).' '.esc_attr($text_direction).'">
                      '.propertya_getlabels($property_id).'
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-md-7 col-lg-7 col-12">
                <div class="listing-data d-flex  h-100">
				  '.$featured_listing.'
                  <div class="heaing-d align-self-center">
				  <div class="prop-cat">'.propertya_framework_selected_cat($property_id).' </div>
                    <h3 class="text-capitalize mb-2">
						<a href="'.esc_url(get_the_permalink($property_id)).'" class="clr-black">'.propertya_title_limit(45,$property_id).'</a>
					</h3>
					'.$price_rent.'
                    '.$street_addr.'
					<div class="home-amenties-features">
						'.$home_features.'
						'.$author_dp.'
            		</div>
                  </div>
                </div>
              </div>
            </div>
      		 </div>';
		}
		
		//map listings markers
		function propertya_listings_map_listings($property_id)
		{
			$selected_pricelabel_after =  $optional_price = $optional_price = $verified_listing = $category = $grage = $home_features = $size = $baths = $rooms = $labels = $featured_listing = $author_dp = $post_id = $type = $street_addr = $price_rent = $all_idz = '';
			$get_all_prices = array();
			$all_idz = propertya_framework_fetch_gallery_idz($property_id);
			$localization = propertya_localization();
			//prices
			$get_all_prices =  propertya_framework_fetch_price($property_id);
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
			//labels
			if(!empty(propertya_getlabels($property_id)))
			{
				$labels = '<div class="property-labels absolute-yes"><div class="label-badges"><ul class="list-unstyled">'.propertya_getlabels($property_id).'</ul></div></div>';	
			}
			//featured listing
			$featured_listing = '';
			if (get_post_meta($property_id, 'prop_is_feature_listing', true ) == "1")
			{
				$featured_listing = esc_html($localization['feat']);
			}
			return '{
					 "title":"'.propertya_title_limit(37,$property_id).'",
					 "url_link":"'.esc_url(get_the_permalink($property_id)).'",
					 "img_url":"'.esc_url(propertya_framework_img_src($all_idz,'propertya-blog-thumb')).'",
					 "pricings":"'.$price_rent.'",
					 "is_featured":"'.$featured_listing.'",
					 "street_addr":"'.get_post_meta($property_id, 'prop_street_addr', true ).'",
					 "lat":' . get_post_meta($property_id, 'prop_latt', true) . ',
					 "lng":' . get_post_meta($property_id, 'prop_long', true) . '
				},';
		}		
		//grid 1
		function propertya_listings_grid1($property_id)
		{
			$selected_pricelabel_after =  $optional_price = $price_rent = $all_idz = '';
			$get_all_prices = array();
			$localization = propertya_localization();
			$all_idz = propertya_framework_fetch_gallery_idz($property_id);
			//prices
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
			  $price_rent = '<div class="property-meta">
						<div class="item-price">'.$get_all_prices['main_price'].' '. $selected_pricelabel_after.' </div>
					</div>';
			}
			
			//featured listing
			$featured_listing = '';
			if (get_post_meta($property_id, 'prop_is_feature_listing', true ) == "1")
			{
				$featured_listing = '<div class="ribbon"><span>'.esc_attr($localization['feat']).'</span></div>';
			}
			return '<div class="card ad-card-2">
				<div class="card-image">
					 '.$featured_listing.'
					<div class="property-labels absolute-yes">
						<ul class="list-unstyled">
							'.propertya_getlabels($property_id).'
						</ul>
					</div>
					<!-- Image -->
					<img class="img-fluid" src="'.esc_url(propertya_framework_img_src($all_idz,'propertya-background')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'">
					'. $price_rent.'
					 <button data-compare-id="'.esc_attr($property_id).'" class="property-tools btn d-flex justify-content-center align-items-center compare-prop fav-comp" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['compare']).'"><i class="fas fa-random"></i></button>
					<button data-fav-id="'.esc_attr($property_id).'" class="property-tools btn d-flex justify-content-center align-items-center fav-prop" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['fav']).'"><i class="far fa-heart"></i></button>
					<h5 class="card-title">
						<a href="'.esc_url(get_the_permalink($property_id)).'">'.propertya_title_limit(25,$property_id).'</a>
					</h5>
					<div class="img-overlay"></div>
				</div>
			</div>';
		}
		//Slingle Listing sliders
		function propertya_listings_single_featuredslider($args,$grid_layout)
		{
			$slider_html = $start_div = $end_div = '';
			$featured_ads = new WP_Query($args);
			if ($featured_ads->have_posts())
			{
				$slider_html = '';
				$grid_layout = 'grid1';
				 while ($featured_ads->have_posts())
				 {
					$featured_ads->the_post();
					$property_id = get_the_ID();
					if ($grid_layout == 'grid1')
					{
						$slider_html .= $this->propertya_listings_grid1($property_id);
					}
				 }
				 wp_reset_postdata();
				 return '<div class="featured-slider-prop owl-carousel owl-theme">
				 	' . $slider_html . '
				 </div>';
			}
		}
		
		//Nearby Listings
		function propertya_listings_nearby($property_id,$final_distances,$dis_abbt)
		{
			$selected_pricelabel_after =  $optional_price = $ratings = $price_rent = $all_idz = '';
			$get_all_prices = array();	
			$all_idz = propertya_framework_fetch_gallery_idz($property_id);
			//prices
			$get_all_prices =  propertya_framework_fetch_price($property_id);
			if(!empty($get_all_prices) && is_array($get_all_prices) && count($get_all_prices) > 0 && array_key_exists("main_price",$get_all_prices))
			{
			 	 $price_rent = '<span class="main-pricing-area"> '.$get_all_prices['main_price'].' </span>';
						
			}
			$ad_ratings = $get_percentage = array();
			$get_percentage = propertya_reviews_average($property_id);
			if(!empty($get_percentage) && is_array($get_percentage) && count($get_percentage['ratings']) > 0)
			{
				 $ratings = '<span class="ratings">' . $get_percentage['total_stars'] . '</span> &nbsp; | &nbsp;';
			}
			echo '<li>
					<a href="'.esc_url(get_the_permalink($property_id)).'">
						<div class="listing-list-img">
							<img class="img-fluid" src="'.esc_url(propertya_framework_img_src($all_idz,'propertya-small-thumb')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'">
						</div>
					</a>
					<div class="listing-list-info">
						'.$price_rent.'
						<h5><a href="'.esc_url(get_the_permalink($property_id)).'">'.propertya_title_limit(35,$property_id).'</a></h5>
						<div class="listing-post-meta">
						   '.$ratings.'  <span class="measure-unit clr-blu"> '.$final_distances.' '.$dis_abbt.'</span>					
						</div>
					</div>
				</li>';
		}
		
		//Recent Listings
		function propertya_listings_recently($property_id)
		{
			$selected_pricelabel_after =  $optional_price = $ratings = $price_rent = $all_idz = '';
			$get_all_prices = array();	
			$all_idz = propertya_framework_fetch_gallery_idz($property_id);
			//prices
			$get_all_prices =  propertya_framework_fetch_price($property_id);
			if(!empty($get_all_prices) && is_array($get_all_prices) && count($get_all_prices) > 0 && array_key_exists("main_price",$get_all_prices))
			{
			 	 $price_rent = '<span class="main-price"> '.$get_all_prices['main_price'].' </span>';
						
			}
			$ad_ratings = $get_percentage = array();
			$get_percentage = propertya_reviews_average($property_id);
			if(!empty($get_percentage) && is_array($get_percentage) && count($get_percentage['ratings']) > 0)
			{
				 $ratings = '<span class="ratings">' . $get_percentage['total_stars'] . '</span> &nbsp; | &nbsp;';
			}
			echo '<li>
				<div class="recently-added-img"><a href="'.esc_url(get_the_permalink($property_id)).'">
				<img class="img-fluid" src="'.esc_url(propertya_framework_img_src($all_idz,'propertya-small-thumb')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'">
				</a>  
				</div>
				<div class="recently-added-desc">
					<h4><a href="'.esc_url(get_the_permalink($property_id)).'">'.propertya_title_limit(35,$property_id).'</a></h4>
					'.$price_rent.'
				</div>
			</li>';
		}
		
		//Most Viewed Listings
		function propertya_listings_most_viewed($property_id)
		{
			$selected_pricelabel_after =  $optional_price = $ratings = $price_rent = $all_idz = '';
			$get_all_prices = array();	
			$all_idz = propertya_framework_fetch_gallery_idz($property_id);
			//prices
			$get_all_prices =  propertya_framework_fetch_price($property_id);
			if(!empty($get_all_prices) && is_array($get_all_prices) && count($get_all_prices) > 0 && array_key_exists("main_price",$get_all_prices))
			{
			   if (array_key_exists("optional_price",$get_all_prices))
			   {
				   $optional_price = $get_all_prices['optional_price'];
			   }
			   if (array_key_exists("after_prefix",$get_all_prices))
			   {
				   $selected_pricelabel_after = '<span class="clr-blu">'.$get_all_prices['after_prefix'].'</span>';
			   }
			  $price_rent = '<div class="main-rate mb-1"><span class="main-reg-pricing clr-blu">'.$get_all_prices['main_price'].' </span><span class="additional-price-tag">'.$selected_pricelabel_after.'</span></div>';
			}
			
			
			$ad_ratings = $get_percentage = array();
			$get_percentage = propertya_reviews_average($property_id);
			if(!empty($get_percentage) && is_array($get_percentage) && count($get_percentage['ratings']) > 0)
			{
				 $ratings = '<span class="ratings">' . $get_percentage['total_stars'] . '</span> &nbsp; | &nbsp;';
			}
			echo '<li>
				<div class="recently-added-img"><a href="'.esc_url(get_the_permalink($property_id)).'">
				<img class="img-fluid" src="'.esc_url(propertya_framework_img_src($all_idz,'propertya-small-thumb')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'">
				</a>  
				</div>
				<div class="recently-added-desc">
					<h4><a href="'.esc_url(get_the_permalink($property_id)).'">'.propertya_title_limit(25,$property_id).'</a></h4>
					
					'.$price_rent.'
					
				</div>
			</li>';
		}
		
		//Type 1
		function propertya_listings_type1($property_id,$col_size = '')
		{
			if ($col_size == 3){$col_size = 'col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12';}
            else if ($col_size == 4){$col_size = 'col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12';}
			else if ($col_size == 2){$col_size = 'col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12';}
			else if ($col_size == 12){$col_size = 'col-xl-12 col-md-12 col-sm-12 col-12';}
			else {$col_size = 'col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12';}
			$selected_pricelabel_after =  $optional_price = $grage = $home_features = $size = $baths = $rooms = $labels = $featured_listing = $author_dp = $post_id = $type = $street_addr = $price_rent = $all_idz = '';
			$get_all_prices = array();
			$localization = propertya_localization();
			$allowed_html = propertya_allowed_html();
			$all_idz = propertya_framework_fetch_gallery_idz($property_id);
			//prices
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
			  $price_rent = '<div class="pricz">
						<div class="zitem-price"><span class="clr-yal">'.$get_all_prices['main_price'].'</span> '. $selected_pricelabel_after.' </div>
					</div>';
			}
			//featured listing
			if (get_post_meta($property_id, 'prop_is_feature_listing', true ) == "1")
			{
				$featured_listing = '<span class="theme-custom-ribbon">'.esc_attr($localization['feat']).'</span>';
			}
			//street address
			if(get_post_meta($property_id, 'prop_street_addr', true )!="")
			{
				$street_addr = '<p class="extrp"> <span> <i class="fas fa-location-arrow clr-yal"> </i></span>'.propertya_trim_locations(35,get_post_meta($property_id, 'prop_street_addr', true )).'</p>';
			}
			//listing author dp
			$post_author = get_post_field('post_author', $property_id);
			if(get_user_meta($post_author, 'user_role_type', true) !="")
			{
				$type = get_user_meta($post_author, 'user_role_type', true);
				$post_id = get_user_meta( $post_author, 'prop_post_id' , true);
				$author_dp = '<div class="meta">
							<a class="avater" href="'.esc_url(get_the_permalink($post_id)).'"><img src="'.esc_url(propertya_placeholder_images($type,$post_id,'propertya-user-thumb')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'" class="img-fluid"></a>
						</div>';	
			}
			//labels
			if(!empty(propertya_getlabels($property_id)))
			{
                $direction = 'text-left';
                if(is_rtl())
                {
                  $direction = 'text-right';  
                }
				$labels = '<div class="label-badges">
					    <ul class="list-unstyled '.esc_attr($direction).'">
						'.propertya_getlabels($property_id).'
                        </ul>
                    </div>';	
			}
			$rooms =  get_post_meta($property_id,'prop_beds_qty', true );
			$baths =  get_post_meta($property_id,'prop_baths_qty', true );
			$size =  get_post_meta($property_id,'prop_area_size', true );
			$grage =  get_post_meta($property_id,'prop_garage_qty', true );
			if(!empty($rooms) || !empty($baths) || !empty($size))
			{
				$home_features .= '<div class="home-amenties">';
				if(!empty($rooms))
				{
					$home_features .= '<div class="rooms-row"> <span class="d-block  clr-black">'.esc_attr($localization['beds']).'</span> <span class="f-size-14 clr-p">'.esc_attr($rooms).'</span> </div>';
				}
				if(!empty($baths))
				{
					$home_features .= '<div class="rooms-beds"> <span class="d-block clr-black">'.esc_attr($localization['baths']).'</span> <span class="f-size-14 clr-p">'.esc_attr($baths).'</span> </div>';
				}
				if(!empty($grage))
				{
					$home_features .= '<div class="rooms-size"> <span class="d-block clr-black">'.esc_attr($localization['grages']).'</span> <span class="f-size-14 clr-p">'.esc_attr(number_format($grage)).'</span> </div>';
				}
				if(!empty($size))
				{
					$home_features .= '<div class="rooms-size"> <span class="d-block clr-black">'.esc_attr($localization['size']).'</span> <span class="f-size-14 clr-p">'.esc_attr(number_format($size)).' '.get_post_meta($property_id,'prop_area_prefix', true ).'</span> </div>';
				}

				$home_features .= '</div>';
			}
			
			return '<div class="'.esc_attr($col_size).' grid-item mygrid-type-1">
            <div class="main-div margin-bottom-30">
                  <div class="main-data">
				    <div class="img-data">
					'.wp_kses($featured_listing,$allowed_html).'
					<a class="clr-black" href="'.esc_url(get_the_permalink($property_id)).'"><img class="img-fluid" src="'.esc_url(propertya_framework_img_src($all_idz,'propertya-blog-thumb')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'"></a>
					    '.$labels.'
						'.wp_kses($author_dp,$allowed_html).'
					</div>
                  </div>
                  <div class="listing-data">
				    <div class="heaing-d">
					'.wp_kses($price_rent,$allowed_html).'
                      <h3 class="text-capitalize">
					  <a class="clr-black" href="'.esc_url(get_the_permalink($property_id)).'">'.propertya_title_limit(30,$property_id).'</a> <i class="list-status ti-check"></i>
					  </h3>
					  '.wp_kses($street_addr,$allowed_html).'
                    </div>
					 <div class="detail-data">
					  '.$home_features.'
			        </div> 
                  </div>
            </div>
          </div>';
		}
		
		//Type 2
		function propertya_listings_type2($property_id,$col_size = '')
		{
			if ($col_size == 3){$col_size = 'col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12';} 
            else if ($col_size == 4){$col_size = 'col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12';}
			else if ($col_size == 2){$col_size = 'col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12';}
			else if ($col_size == 12){$col_size = 'col-xl-12 col-md-12 col-sm-12 col-12';}
			else {$col_size = 'col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12';}
			$selected_pricelabel_after =  $optional_price = $verified_listing = $category = $grage = $home_features = $size = $baths = $rooms = $labels = $featured_listing = $author_dp = $post_id = $type = $street_addr = $price_rent = $all_idz = '';
			$get_all_prices = array();
			$localization = propertya_localization();
			$allowed_html = propertya_allowed_html();
			$all_idz = propertya_framework_fetch_gallery_idz($property_id);
			//prices
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
			  $price_rent = '<div class="property-meta"><div class="item-price">'.$get_all_prices['main_price'].'&nbsp;'. $selected_pricelabel_after.'  </div></div>';
					
			}
			//featured listing
			$featured_listing = '';
			if (get_post_meta($property_id, 'prop_is_feature_listing', true ) == "1")
			{
				$featured_listing = '<div class="featured-ribbon" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['feat']).'">
					<div><i class="fas fa-star"></i></div>
				</div>';
			}
			//labels
			if(!empty(propertya_getlabels($property_id)))
			{
                $direction = 'text-left';
                if(is_rtl())
                {
                  $direction = 'text-right';  
                }
				$labels = '<div class="property-labels absolute-no"><div class="label-badges">
					    <ul class="list-unstyled '.esc_attr($direction).'">
						'.propertya_getlabels($property_id).'
                        </ul>
                    </div></div>';	
			}
			//category
			if(!empty(propertya_framework_selected_cat($property_id)))
			{
				$category = '<div class="propert-type"><span class="prop-category-sel">'.propertya_framework_selected_cat($property_id).'</span></div>';
			}
			//listing author dp
			$post_author = get_post_field('post_author', $property_id);
			if(get_user_meta($post_author, 'user_role_type', true) !="")
			{
				$type = get_user_meta($post_author, 'user_role_type', true);
				$post_id = get_user_meta( $post_author, 'prop_post_id' , true);
				$author_dp = '<div class="author">
							<a href="'.esc_url(get_the_permalink($post_id)).'"><img src="'.esc_url(propertya_placeholder_images($type,$post_id,'propertya-user-thumb')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'" class="avatar img-raised"></a>
						</div>';	
				//verified listing
				if(get_post_meta($post_id, $type.'_is_trusted', true ) == "1")
				{
					$verified_listing = '<div class="real-ribbon real-ribbon-top-left" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['verified_listing']).'"><span class="bg-trusted"><i class="fas fa-badge-check"></i></span></div>';
				}		
			}
			//posted date
			$mydate =  get_the_date(get_option('date_format'), $property_id);
			//street address
			if(get_post_meta($property_id, 'prop_street_addr', true )!="")
			{
				$street_addr = '<p class="prop-location">'.propertya_trim_locations(32,get_post_meta($property_id, 'prop_street_addr', true )).'</p>';
			}
			
			return '<div class="'.esc_attr($col_size).' grid-item">
			<div class="card ad-card-3">
                                    <div class="card-image">
									'.wp_kses($verified_listing,$allowed_html).'
                                    '.wp_kses($featured_listing,$allowed_html).'
                                    '.$price_rent.'    
                                <a class="clr-black" href="'.esc_url(get_the_permalink($property_id)).'"><img class="img-fluid" src="'.esc_url(propertya_framework_img_src($all_idz,'propertya-blog-thumb')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'"></a>
									'.$category.'
                                        <div class="img-overlay"></div>
                                    </div>
                                    <div class="card-body">
                                    '.wp_kses($author_dp,$allowed_html).'
                                         '.wp_kses($labels,$allowed_html).'
                                        <h6 class="category text-success">'. esc_html(date_i18n( get_option( 'date_format' ), strtotime($mydate))).'</h6>
										<h5 class="card-title">
                                 			<a class="clr-black" href="'.esc_url(get_the_permalink($property_id)).'">'.propertya_title_limit(28,$property_id).'</a> 
                            			</h5>
                                        '.wp_kses($street_addr,$allowed_html).'
                                    </div>
									</div>
                                </div>';
		}
		
		//Type 3
		function propertya_listings_type3($property_id,$col_size = '')
		{
			if ($col_size == 3){$col_size = 'col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12';}
            else if ($col_size == 4){$col_size = 'col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12';}
			else if ($col_size == 2){$col_size = 'col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12';}
			else if ($col_size == 12){$col_size = 'col-xl-12 col-md-12 col-sm-12 col-12';}
			else {$col_size = 'col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12';}
			$selected_pricelabel_after =  $optional_price = $optional_price = $verified_listing = $category = $grage = $home_features = $size = $baths = $rooms = $labels = $featured_listing = $author_dp = $post_id = $type = $street_addr = $price_rent = $all_idz = '';
			$get_all_prices = array();
			$localization = propertya_localization();
			$allowed_html = propertya_allowed_html();
			$all_idz = propertya_framework_fetch_gallery_idz($property_id);
			//prices
			$get_all_prices =  propertya_framework_fetch_price($property_id);
			if(!empty($get_all_prices) && is_array($get_all_prices) && count($get_all_prices) > 0 && array_key_exists("main_price",$get_all_prices))
			{
			   if (array_key_exists("optional_price",$get_all_prices))
			   {
				   $optional_price = $get_all_prices['optional_price'];
			   }
			   if(isset($optional_price) && $optional_price !="")
			   {
					if (array_key_exists("after_prefix",$get_all_prices))
					{
					   $selected_pricelabel_after = '<small>'.$optional_price  .$get_all_prices['after_prefix'].'</small>';
					}			      
			   }
			   else
			   {
				    if (array_key_exists("after_prefix",$get_all_prices))
					{
					   $selected_pricelabel_after = '<small class="no-block">'.$get_all_prices['after_prefix'].'</small>';
					}   
			   }
			   
			  $price_rent = '<div class="property-meta"><div class="item-price">'.$get_all_prices['main_price'].'&nbsp;'. $selected_pricelabel_after.'  </div></div>';
			}
			//featured listing
			if (get_post_meta($property_id, 'prop_is_feature_listing', true ) == "1")
			{
				$featured_listing = '<div class="featured-ribbon" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['feat']).'">
					<div><i class="fas fa-star"></i></div>
				</div>';
			}
			//posted date
			$mydate =  get_the_date(get_option('date_format'), $property_id);
			
			//street address
			if(get_post_meta($property_id, 'prop_street_addr', true )!="")
			{
				$street_addr = '<p class="prop-location">'.propertya_trim_locations(32,get_post_meta($property_id, 'prop_street_addr', true )).'</p>';
			}
			$features_html = '';
			//features
			$features_list = array();
			$features_list = wp_get_object_terms($property_id,array('property_feature'), array('orderby'=>'name','order'=> 'ASC'));
			if(!empty($features_list) && is_array($features_list) && count($features_list) > 0)
			{
				 if (!is_wp_error($features_list))
				 {
					 $image_id =  $feature_img = '';
					 $features_html .= '<ul class="facilities-list clearfix">';
					 $i = 0;
					 $img = '';
					 foreach( $features_list as $features )
					 {
                         $img = '';
						 if(get_term_meta($features->term_id, 'property_feature_term_meta_img', true )!="")
						 {
							$image_id = get_term_meta($features->term_id, 'property_feature_term_meta_img', true);
							$img = wp_get_attachment_image($image_id, 'thumbnail');
						 }
						 $features_html .= '<li>'.$img.' '.esc_html($features->name).'</li>';
						 $i++;
						 if($i ==  5) break;
					 }
					 $features_html .= '</ul>';
				 }
			}
			//labels
			if(!empty(propertya_getlabels($property_id)))
			{
                $direction = 'text-left';
                if(is_rtl())
                {
                  $direction = 'text-right';  
                }
				$labels = '<div class="property-labels absolute-yes"><div class="label-badges">
					    <ul class="list-unstyled '.esc_attr($direction).'">
						'.propertya_getlabels($property_id).'
                        </ul>
                    </div></div>';	
			}
			return '<div class="'.esc_attr($col_size).' grid-item mygrid-type-3">
			<div class="card ad-card-1">
                                    <div class="card-image">
                                    	'.wp_kses($featured_listing,$allowed_html).'
                                        '.wp_kses($labels,$allowed_html).'
                                        <a class="clr-black" href="'.esc_url(get_the_permalink($property_id)).'"><img class="img-fluid" src="'.esc_url(propertya_framework_img_src($all_idz,'propertya-blog-thumb')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'"></a>
                                        '.$price_rent.'
										<!-- Property Tools -->
                                        <button class="property-tools fav-prop" data-toggle="tooltip" data-placement="top"  data-original-title="'.esc_attr($localization['fav']).'" data-fav-id="'.esc_attr($property_id).'"> <i class="fas fa-heart"></i> </button>
                                        <button class="property-tools fav-comp" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['compare']).'" data-compare-id="'.esc_attr($property_id).'"> <i class="fas fa-random"></i> </button>
                                        <div class="img-overlay"></div>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="category text-success">'. esc_html(date_i18n( get_option( 'date_format' ), strtotime($mydate))).'</h6>
                                        <h5 class="card-title">
                                 			<a class="clr-black" href="'.esc_url(get_the_permalink($property_id)).'">'.propertya_title_limit(27,$property_id).'</a>
                            			</h5>
                                        '.wp_kses($street_addr,$allowed_html).'
										'.$features_html.'
                                    </div>
                                </div>
			</div>';
		}
		
		//Type 4
		function propertya_listings_type4($property_id,$col_size = '')
		{
			if ($col_size == 3){$col_size = 'col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12';}
            else if ($col_size == 4){$col_size = 'col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12';}
			else if ($col_size == 2){$col_size = 'col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12';}
			else if ($col_size == 12){$col_size = 'col-xl-12 col-md-12 col-sm-12 col-12';}
			else {$col_size = 'col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12';}
			$selected_pricelabel_after =  $optional_price = $optional_price = $verified_listing = $category = $grage = $home_features = $size = $baths = $rooms = $labels = $featured_listing = $author_dp = $post_id = $type = $street_addr = $price_rent = $all_idz = '';
			$get_all_prices = array();
			$localization = propertya_localization();
			$allowed_html = propertya_allowed_html();
			$all_idz = propertya_framework_fetch_gallery_idz($property_id);
			//prices
			$get_all_prices =  propertya_framework_fetch_price($property_id);
			if(!empty($get_all_prices) && is_array($get_all_prices) && count($get_all_prices) > 0 && array_key_exists("main_price",$get_all_prices))
			{
				$selected_pricelabel_after = '';
				if (array_key_exists("after_prefix",$get_all_prices))
				{
				   $selected_pricelabel_after = '<small class="no-block">'.$get_all_prices['after_prefix'].'</small>';
				}   
			  $price_rent = '<div class="property-meta-relative"><div class="item-price">'.$get_all_prices['main_price'].'&nbsp;'. $selected_pricelabel_after.'  </div></div>';
			}
			//featured listing
			if (get_post_meta($property_id, 'prop_is_feature_listing', true ) == "1")
			{
				$featured_listing = '<div class="featured-ribbon" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['feat']).'">
					<div><i class="fas fa-star"></i></div>
				</div>';
			}
			//posted date
			$mydate =  get_the_date(get_option('date_format'), $property_id);
			//street address
			if(get_post_meta($property_id, 'prop_street_addr', true )!="")
			{
				$street_addr = '<p class="prop-location"><i class="clr-yal fas fa-location-arrow"></i> '.propertya_trim_locations(30,get_post_meta($property_id, 'prop_street_addr', true )).'</p>';
			}
			//labels
			if(!empty(propertya_getlabels($property_id)))
			{
				$labels = '<div class="property-labels absolute-yes"><div class="label-badges">
					    <ul class="list-unstyled">
						'.propertya_getlabels($property_id).'
                        </ul>
                    </div></div>';	
			}
			//category
			if(!empty(propertya_framework_selected_cat($property_id)))
			{
				$category = '<div class="propert-type"><span class="prop-category-sel">'.propertya_framework_selected_cat($property_id).'</span></div>';
			}
			$rooms =  get_post_meta($property_id,'prop_beds_qty', true );
			$baths =  get_post_meta($property_id,'prop_baths_qty', true );
			$size  =  get_post_meta($property_id,'prop_area_size', true );
			$grage =  get_post_meta($property_id,'prop_garage_qty', true );
			if(!empty($rooms) || !empty($baths) || !empty($grage))
			{
				$home_features .= '<ul class="list-inline">';
				if(!empty($rooms))
				{ 
					$home_features .= '<li class="list-inline-item"><i class=" clr-yal fas fa-bed"></i>'.esc_attr($rooms). ' '.esc_attr($localization['beds']).'</li>';
				}
				if(!empty($baths))
				{
					$home_features .= '<li class="list-inline-item"><i class=" clr-yal fas fa-bath"></i>'.esc_attr($baths) .' '. esc_attr($localization['baths']).'</li>';
				}
				if(!empty($grage))
				{
					$home_features .= '<li class="list-inline-item"><i class=" clr-yal fas fa-warehouse"></i>' .esc_attr(number_format($grage)) .' '.esc_attr($localization['grages']) .'</li>';
				}
				$home_features .= '</ul>';
			}
			return '<div class="'.esc_attr($col_size).' grid-item">
					<div class="card ad-card-4">
					<div class="card-header">
					'.$price_rent.'
					<button class="property-tools fav-prop" data-toggle="tooltip" data-placement="top"  data-original-title="'.esc_attr($localization['fav']).'" data-fav-id="'.esc_attr($property_id).'"> <i class="fas fa-heart"></i> </button>
					<button class="property-tools fav-comp" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['compare']).'" data-compare-id="'.esc_attr($property_id).'"> <i class="fas fa-random"></i> </button>
					</div>
					<div class="card-image">
					'.wp_kses($featured_listing,$allowed_html).'
					'.wp_kses($labels,$allowed_html).'
					<img class="img-fluid" src="'.esc_url(propertya_framework_img_src($all_idz,'propertya-blog-thumb')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'">
					'.$category.'
					<div class="img-overlay"></div>
					</div>
					<div class="card-body">
					'.wp_kses($street_addr,$allowed_html).'
					<h5 class="card-title">
						<a class="clr-black" href="'.esc_url(get_the_permalink($property_id)).'">'.propertya_title_limit(27,$property_id).'</a>
					</h5>
					 '.$home_features.'
					</div></div>
				</div>';
		}
		
		//Type 5
		function propertya_listings_type5($property_id,$col_size = '')
		{
			if ($col_size == 3){$col_size = 'col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12';} 
            else if ($col_size == 4){$col_size = 'col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12';}
			else if ($col_size == 2){$col_size = 'col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12';}
			else if ($col_size == 12){$col_size = 'col-xl-12 col-md-12 col-sm-12 col-12';}
			else {$col_size = 'col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12';}
			$selected_pricelabel_after =  $optional_price = $rating_html = $optional_price = $verified_listing = $category = $grage = $home_features = $size = $baths = $rooms = $labels = $featured_listing = $author_dp = $post_id = $type = $street_addr = $price_rent = $all_idz = '';
			$get_all_prices = array();
			$localization = propertya_localization();
			$allowed_html = propertya_allowed_html();
			$all_idz = propertya_framework_fetch_gallery_idz($property_id);
			//prices
			$get_all_prices =  propertya_framework_fetch_price($property_id);
			if(!empty($get_all_prices) && is_array($get_all_prices) && count($get_all_prices) > 0 && array_key_exists("main_price",$get_all_prices))
			{
				$selected_pricelabel_after = '';
				if (array_key_exists("after_prefix",$get_all_prices))
				{
				   $selected_pricelabel_after = '<small class="no-block">'.$get_all_prices['after_prefix'].'</small>';
				}   
			  $price_rent = '<div class="property-meta-relative"><div class="item-price">'.$get_all_prices['main_price'].'&nbsp;'. $selected_pricelabel_after.'  </div></div>';
			}
			//featured listing
			if (get_post_meta($property_id, 'prop_is_feature_listing', true ) == "1")
			{
				$featured_listing = '<div class="featured-ribbon" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['feat']).'">
					<div><i class="fas fa-star"></i></div>
				</div>';
			}
			//posted date
			$mydate =  get_the_date(get_option('date_format'), $property_id);
			//street address
			if(get_post_meta($property_id, 'prop_street_addr', true )!="")
			{
				$street_addr = '<p class="prop-location"><i class="clr-yal fas fa-location-arrow"></i> '.propertya_trim_locations(32,get_post_meta($property_id, 'prop_street_addr', true )).'</p>';
			}
			//labels
			if(!empty(propertya_getlabels($property_id)))
			{
				$labels = '<div class="property-labels absolute-yes"><div class="label-badges">
					    <ul class="list-unstyled">
						'.propertya_getlabels($property_id).'
                        </ul>
                    </div></div>';	
			}
			//category
			if(!empty(propertya_framework_selected_cat($property_id)))
			{
				$category = '<div class="propert-type"><span class="prop-category-sel">'.propertya_framework_selected_cat($property_id).'</span></div>';
			}
			//ratings
			$get_percentage = array();
			$get_percentage = propertya_reviews_average($property_id);
			if(!empty($get_percentage) && is_array($get_percentage) && count($get_percentage['ratings']) > 0 && !empty($get_percentage['rated_no_of_times']) && $get_percentage['rated_no_of_times'] > 0)
			{
				$rating_html = '<div class="listing-rating">
						<span class="ratings"> 
						'.wp_sprintf(__('%s (%d Reviews)', 'propertya'), $get_percentage['total_stars'],$get_percentage['rated_no_of_times']).'
					</span></div>';
			}
			//listing author dp
			$post_author = get_post_field('post_author', $property_id);
			if(get_user_meta($post_author, 'user_role_type', true) !="")
			{
				$type = get_user_meta($post_author, 'user_role_type', true);
				$post_id = get_user_meta( $post_author, 'prop_post_id' , true);
				//verified listing
				if(get_post_meta($post_id, $type.'_is_trusted', true ) == "1")
				{
					$verified_listing = '<div class="is-verified"><i class="fas fa-check"></i></div>';
				}
				$author_dp = '<div class="card5-author-thumb">
				<a href="'.esc_url(get_the_permalink($post_id)).'">
					'.$verified_listing.'
					<img src="'.esc_url(propertya_placeholder_images($type,$post_id,'propertya-user-thumb')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'" class="mg-fluid mx-auto">
				</a>
				</div>';		
			}
			//category
			if(!empty(propertya_framework_selected_cat($property_id)))
			{
				$category = '<h6 class="category text-success">'.propertya_framework_selected_cat($property_id).'</h6>';
			}
			return '<div class="'.esc_attr($col_size).' grid-item mygrid-type-5">
			<div class="card ad-card-5">
                                    <div class="card-image">
                                    	'.wp_kses($featured_listing,$allowed_html).'
                                        '.wp_kses($labels,$allowed_html).'
                                        <a class="clr-black" href="'.esc_url(get_the_permalink($property_id)).'"><img class="img-fluid" src="'.esc_url(propertya_framework_img_src($all_idz,'propertya-blog-thumb')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'"></a>                                        
										<div class="img-overlay"></div>
								'.$author_dp.'
								'.$rating_html.'
                                    </div>
                                    <div class="card-body">
                                        '.$category.'
                                        <h5 class="card-title">
                                 			<a class="clr-black" href="'.esc_url(get_the_permalink($property_id)).'">'.propertya_title_limit(27,$property_id).'</a>
                            			</h5>
                                       '.wp_kses($street_addr,$allowed_html).'
                                    </div>
                                    <div class="card-footer">
                                    '.$price_rent.'
									<div class="listing-option-list">
                                        <button class="property-tools fav-prop" data-toggle="tooltip" data-placement="top"  data-original-title="'.esc_attr($localization['fav']).'" data-fav-id="'.esc_attr($property_id).'"> <i class="fas fa-heart"></i> </button>
                                        <button class="property-tools fav-comp" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['compare']).'" data-compare-id="'.esc_attr($property_id).'"> <i class="fas fa-random"></i> </button>
                                    </div>
                                    </div>
                                </div>
			</div>';
		}
		
		//Type 6
		function propertya_listings_type6($property_id,$col_size = '')
		{
			if ($col_size == 3){$col_size = 'col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12';} 
           else if ($col_size == 4){$col_size = 'col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12';}
			else if ($col_size == 2){$col_size = 'col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12';}
			else if ($col_size == 12){$col_size = 'col-xl-12 col-md-12 col-sm-12 col-12';}
			else {$col_size = 'col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12';}
			$selected_pricelabel_after =  $optional_price = $rating_html = $optional_price = $verified_listing = $category = $grage = $home_features = $size = $baths = $rooms = $labels = $featured_listing = $author_dp = $post_id = $type = $street_addr = $price_rent = $all_idz = '';
			$get_all_prices = array();
			$localization = propertya_localization();
			$allowed_html = propertya_allowed_html();
			$all_idz = propertya_framework_fetch_gallery_idz($property_id);
			//prices
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
			  $price_rent = '<div class="property-meta">
						<div class="item-price">'.$get_all_prices['main_price'].' '. $selected_pricelabel_after.' </div>
					</div>';
			}
			//featured listing
			$featured_listing = '';
			if (get_post_meta($property_id, 'prop_is_feature_listing', true ) == "1")
			{
				$featured_listing = '<div class="ribbon"><span>'.esc_attr($localization['feat']).'</span></div>';
			}
			 return '<div class="'.esc_attr($col_size).' grid-item mygrid-type-6">
			 <div class="card ad-card-2">
				<div class="card-image">
					 '.$featured_listing.'
					<div class="property-labels absolute-yes">
						<ul class="list-unstyled">
							'.propertya_getlabels($property_id).'
						</ul>
					</div>
					<!-- Image -->
					<a class="clr-black" href="'.esc_url(get_the_permalink($property_id)).'"><img class="img-fluid" src="'.esc_url(propertya_framework_img_src($all_idz,'propertya-blog-thumb')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'"></a>
					'. $price_rent.'
					 <button data-compare-id="'.esc_attr($property_id).'" class="property-tools fav-comp btn d-flex justify-content-center align-items-center compare-prop" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['compare']).'"><i class="fas fa-random"></i></button>
					<button data-fav-id="'.esc_attr($property_id).'" class="property-tools btn d-flex justify-content-center align-items-center fav-prop" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['fav']).'"><i class="far fa-heart"></i></button>
					<h5 class="card-title">
						<a href="'.esc_url(get_the_permalink($property_id)).'">'.propertya_title_limit(30,$property_id).'</a>
					</h5>
					<div class="img-overlay"></div>
				</div>
			</div>
		  </div>';
		}
		
		//Type 7
		function propertya_listings_type7($property_id,$col_size = '')
		{
			if ($col_size == 3){$col_size = 'col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12';} 
            else if ($col_size == 4){$col_size = 'col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12';}
			else if ($col_size == 2){$col_size = 'col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12';}
			else if ($col_size == 12){$col_size = 'col-xl-12 col-md-12 col-sm-12 col-12';}
			else {$col_size = 'col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12';}
			$selected_pricelabel_after =  $optional_price = $rating_html = $optional_price = $verified_listing = $category = $grage = $home_features = $size = $baths = $rooms = $labels = $featured_listing = $author_dp = $post_id = $type = $street_addr = $price_rent = $all_idz = '';
			$get_all_prices = array();
			$localization = propertya_localization();
			$allowed_html = propertya_allowed_html();
			$all_idz = propertya_framework_fetch_gallery_idz($property_id);
			//labels
			if(!empty(propertya_getlabels($property_id)))
			{
                $direction = 'text-left';
                if(is_rtl())
                {
                  $direction = 'text-right';  
                }
				$labels = '<div class="property-labels absolute-yes"><div class="label-badges">
					    <ul class="list-unstyled '.esc_attr($direction).'">
						'.propertya_getlabels($property_id).'
                        </ul>
                    </div></div>';	
			}
			//featured listing
			$featured_listing = '';
			if (get_post_meta($property_id, 'prop_is_feature_listing', true ) == "1")
			{
				$featured_listing = '<div class="ribbon"><span>'.esc_attr($localization['feat']).'</span></div>';
			}
			//ratings
			$get_percentage = array();
			$get_percentage = propertya_reviews_average($property_id);
			if(!empty($get_percentage) && is_array($get_percentage) && count($get_percentage['ratings']) > 0 && !empty($get_percentage['rated_no_of_times']) && $get_percentage['rated_no_of_times'] > 0)
			{
				$rating_html = '<span class="ratings"> 
									'.wp_sprintf(__('%s (%d Reviews)', 'propertya'), $get_percentage['total_stars'],$get_percentage['rated_no_of_times']).'</span>';
			}
			//prices
			$get_all_prices =  propertya_framework_fetch_price($property_id);
			if(!empty($get_all_prices) && is_array($get_all_prices) && count($get_all_prices) > 0 && array_key_exists("main_price",$get_all_prices))
			{
				$selected_pricelabel_after = '';
				if (array_key_exists("after_prefix",$get_all_prices))
				{
				   $selected_pricelabel_after = '<small class="no-block">'.$get_all_prices['after_prefix'].'</small>';
				}   
			  $price_rent = '<div class="property-meta-relative"><div class="item-price">'.$get_all_prices['main_price'].'&nbsp;'. $selected_pricelabel_after.'  </div></div>';
			}
			//listing author dp
			$post_author = get_post_field('post_author', $property_id);
			if(get_user_meta($post_author, 'user_role_type', true) !="")
			{
				$type = get_user_meta($post_author, 'user_role_type', true);
				$post_id = get_user_meta( $post_author, 'prop_post_id' , true);
				//verified listing
				if(get_post_meta($post_id, $type.'_is_trusted', true ) == "1")
				{
					$verified_listing = '<div class="is-verified"><i class="fas fa-check"></i></div>';
				}
				 $author_dp ='<div class="author">
			                  '.$verified_listing.'
							<a href="'.esc_url(get_the_permalink($post_id)).'">
							<img src="'.esc_url(propertya_placeholder_images($type,$post_id,'propertya-user-thumb')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'" class="avatar img-raised"></a>
				</div>';		
			}
			
			return '<div class="'.esc_attr($col_size).' grid-item">
			<div class="card ad-card-7">
              <div class="card-image">
                <a class="clr-black" href="'.esc_url(get_the_permalink($property_id)).'"><img class="img-fluid" src="'.esc_url(propertya_framework_img_src($all_idz,'propertya-blog-thumb')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'"></a>
 '.wp_kses($labels,$allowed_html).'
 '.wp_kses($featured_listing,$allowed_html).'

                         <div class="img-overlay"></div>
                          </div>
                          <div class="card-body d-flex flex-column justify-content-center text-center">
                          '.$author_dp.'
                              <h5 class="card-title">
                       			<a class="clr-black" href="'.esc_url(get_the_permalink($property_id)).'">'.propertya_title_limit(100,$property_id).'</a>
                  		  	</h5>
					               '.$price_rent.'                                       
                          </div>
                      </div>
			</div>';
		}
		
		//List 1
		function propertya_listings_list1($property_id)
		{
			$selected_pricelabel_after =  $optional_price = $optional_price = $price_rent = $all_idz = '';
			$get_all_prices = array();
			$localization = propertya_localization();
			$all_idz = propertya_framework_fetch_gallery_idz($property_id);
			$allowed_html = propertya_allowed_html();
			//prices
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
			  $price_rent = '<h3><span class="main-reg-price">'.$get_all_prices['main_price'].'</span> '. $selected_pricelabel_after.'</h3>';
			}
			//home features
			$street_addr = $labels =  $author_dp = $type = $post_author = $home_features = $size = $baths = $rooms = '';
			//featured listing
			$featured_listing = '';
			if (get_post_meta($property_id, 'prop_is_feature_listing', true ) == "1")
			{
				$featured_listing = '<div class="ribbon"><span>'.esc_attr($localization['feat']).'</span></div>';
			}
			//labels
			if(!empty(propertya_getlabels($property_id)))
			{
                $text_direction = 'text-left';
                if(is_rtl())
                {
                    $text_direction = 'text-right';
                }
				$labels = '<div class="property-labels absolute-no"><div class="label-badges">
					    <ul class="list-unstyled '.esc_attr($text_direction).'">
						'.propertya_getlabels($property_id).'
                        </ul>
                    </div></div>';	
			}
			//street address
			if(get_post_meta($property_id, 'prop_street_addr', true )!="")
			{
				$street_addr = '<p class="extrp"> <span> <i class="fas fa-location-arrow clr-yal"> </i></span>'.get_post_meta($property_id, 'prop_street_addr', true ).'</p>';
			}
			//listing author dp
			$post_author = get_post_field('post_author', $property_id);
			$verified_listing = '';
			if(get_user_meta($post_author, 'user_role_type', true) !="")
			{
				$type = get_user_meta($post_author, 'user_role_type', true);
				$post_id = get_user_meta( $post_author, 'prop_post_id' , true);
				//verified listing
				if(get_post_meta($post_id, $type.'_is_trusted', true ) == "1")
				{
					$verified_listing = '<div class="is-verified"><i class="fas fa-check"></i></div>';
				}
				 $author_dp ='<div class="author">
			                  '.$verified_listing.'
							<a href="'.esc_url(get_the_permalink($post_id)).'">
							<img src="'.esc_url(propertya_placeholder_images($type,$post_id,'propertya-user-thumb')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'" class="avatar img-raiseds" ></a>
				</div>';		
			}
			return '<div class="col-xl-12 col-lg-12 col-md-12 col-12 grid-item">
					<div class="my-list1">
						'.$featured_listing.'
						<div class="my-img-container">
							<a class="clr-black" href="'.esc_url(get_the_permalink($property_id)).'"><img class="img-fluid" src="'.esc_url(propertya_framework_img_src($all_idz,'propertya-blog-thumb')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'"></a>
						</div>
						<div class="my-content-area align-self-center">
						'.wp_kses($labels,$allowed_html).'
						<h5 class="card-title">
							<a class="clr-black" href="'.esc_url(get_the_permalink($property_id)).'">'.propertya_title_limit(45,$property_id).'</a>
						</h5>
						'.wp_kses($street_addr,$allowed_html).'
						<div class="pricing-area">
							 '.$price_rent.'     
							'.$author_dp.'
						</div>
						</div>
					</div>
				</div>';	
		}
		
		//List 2
		function propertya_listings_list2($property_id)
		{
			$selected_pricelabel_after =  $optional_price = $optional_price = $verified_listing = $category = $grage = $home_features = $size = $baths = $rooms = $labels = $featured_listing = $author_dp = $post_id = $type = $street_addr = $price_rent = $all_idz = $count = '';
			$get_all_prices = array();
			$localization = propertya_localization();
			$allowed_html = propertya_allowed_html();
			$all_idz = propertya_framework_fetch_gallery_idz($property_id);

			if (!is_null($all_idz) && is_array($all_idz)) {
		     $count = count($all_idz);
		} else {
		    // Handle the case when $all_idz is null or not an array
		    $count = 0;
		}
			//prices
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
			  $price_rent = '<h3><span class="main-reg-price">'.$get_all_prices['main_price'].'</span> '. $selected_pricelabel_after.'</h3>';
			}
			//featured listing
			if (get_post_meta($property_id, 'prop_is_feature_listing', true ) == "1")
			{
				$featured_listing = '<div class="featured-ribbon" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['feat']).'">
					<div><i class="fas fa-star"></i></div>
				</div>';
			}
			//posted date
			$mydate =  get_the_date(get_option('date_format'), $property_id);
			//street address
			if(get_post_meta($property_id, 'prop_street_addr', true )!="")
			{
				$street_addr = '<p class="extrp"> <span> <i class="fas fa-location-arrow clr-yal"> </i></span>'.get_post_meta($property_id, 'prop_street_addr', true ).'</p>';
			}
			//labels
			if(!empty(propertya_getlabels($property_id)))
			{
				$labels = '<div class="property-labels absolute-yes"><div class="label-badges">
					    <ul class="list-unstyled">
						'.propertya_getlabels($property_id).'
                        </ul>
                    </div></div>';	
			}
			//category
			if(!empty(propertya_framework_selected_cat($property_id)))
			{
				$category = '<div class="propert-type"><span class="prop-category-sel">'.propertya_framework_selected_cat($property_id).'</span></div>';
			}
			
			//home features
			$author_dp = $type = $post_author = $home_features = $size = $baths = $rooms = '';
			$rooms =  get_post_meta($property_id,'prop_beds_qty', true );
			$baths =  get_post_meta($property_id,'prop_baths_qty', true );
			$size =  get_post_meta($property_id,'prop_area_size', true );
			if(!empty($rooms) || !empty($baths) || !empty($size))
			{
				$home_features .= '<div class="home-amenties">';
				if(!empty($rooms))
				{
					$home_features .= '<div class="rooms-row"> <span class="d-block  clr-black">'.esc_attr($localization['beds']).'</span> <span class="f-size-14 clr-p">'.esc_attr($rooms).'</span> </div>';
				}
				if(!empty($baths))
				{
					$home_features .= '<div class="rooms-beds"> <span class="d-block clr-black">'.esc_attr($localization['baths']).'</span> <span class="f-size-14 clr-p">'.esc_attr($baths).'</span> </div>';
				}
				if(!empty($size))
				{
					$home_features .= '<div class="rooms-size"> <span class="d-block clr-black">'.esc_attr($localization['size']).'</span> <span class="f-size-14 clr-p">'.esc_attr(number_format($size)).' '.get_post_meta($property_id,'prop_area_prefix', true ).'</span> </div>';
				}
				$home_features .= '</div>';
			}
			//listing author dp
			$verified_listing = '';
			$post_author = get_post_field('post_author', $property_id);
			if(get_user_meta($post_author, 'user_role_type', true) !="")
			{
				$type = get_user_meta($post_author, 'user_role_type', true);
				$post_id = get_user_meta( $post_author, 'prop_post_id' , true);
				//verified listing
				if(get_post_meta($post_id, $type.'_is_trusted', true ) == "1")
				{
					$verified_listing = '<div class="is-verified"><i class="fas fa-check"></i></div>';
				}
				$author_dp = '<div class="listing-author-dp">
				'.$verified_listing.'
							<a href="'.esc_url(get_the_permalink($post_id)).'"><img src="'.esc_url(propertya_placeholder_images($type,$post_id,'propertya-user-thumb')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'" class="img-fluid"></a>
						</div>';	
			}
			//featured listing
			$featured_listing = '';
			if (get_post_meta($property_id, 'prop_is_feature_listing', true ) == "1")
			{
				$featured_listing = '<div class="featured-ribbon" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['feat']).'">
					<div><i class="fas fa-star"></i></div>
				</div>';
			}
			//posted date
			$mydate =  get_the_date(get_option('date_format'), $property_id);
			// get directions
			$lon =  $get_directions =  $latt = '';
			$latt = get_post_meta($property_id, 'prop_latt', true );
			$lon = get_post_meta($property_id, 'prop_long', true );
			if(!empty($latt) && !empty($lon))
			{
				$get_directions = '<a class="explore-nearby" href="//www.google.com/maps?daddr='.esc_attr($latt).','.esc_attr($lon).'" target="_blank"><i class="fas fa-map-signs"></i> '.esc_html__('Get Directions','propertya').'
           </a>';
			}
			return '<div class="col-xl-12 col-lg-12 col-md-12 col-12 grid-item">
						<div class="card my-list2">
						<div class="card-header">
							<h5 class="card-title">
								<a class="clr-black" href="'.esc_url(get_the_permalink($property_id)).'">'.propertya_title_limit(20,$property_id).'</a>
							
							</h5>
							'.wp_kses($street_addr,$allowed_html).'
							'.wp_kses($get_directions,$allowed_html).'
            '.$featured_listing.'
						</div>
					    <div class="card-body">
						<div class="row">
                        <div class="col-lg-5 col-md-5">
							<div class="my-list2-img-cont">
							
                               <a class="clr-black" href="'.esc_url(get_the_permalink($property_id)).'"><img class="img-fluid" src="'.esc_url(propertya_framework_img_src($all_idz,'propertya-blog-thumb')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'"></a>
							   '.wp_kses($labels,$allowed_html).'
							 <button data-compare-id="'.esc_attr($property_id).'" class="property-tools fav-comp btn d-flex justify-content-center align-items-center compare-prop" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['compare']).'"><i class="fas fa-random"></i></button>
					<button data-fav-id="'.esc_attr($property_id).'" class="property-tools btn d-flex justify-content-center align-items-center fav-prop" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['fav']).'"><i class="far fa-heart"></i></button>
					<div class="total-img-count">
                  		<span><i class="fas fa-camera"></i> '.$count.'</span>
                	</div>
							   </div> 
                        </div>
                        <div class="col-lg-7 col-md-7">
						<div class="my-list2-pricing">
                            '.$price_rent.'
						</div>
							<p>'.wp_trim_words(get_the_excerpt($property_id), 15, '...' ).'</p>
												<div class="home-amenties-features">
						'.$home_features.'
						'.$author_dp.'
            		</div>
												<div class="posted-date">'.wp_sprintf(__('Listed on %s', 'propertya'), esc_html(date_i18n( get_option( 'date_format' ), strtotime($mydate)))).'</div>
											</div>
                        </div>
                    </div>
				   </div>
			</div>';
		}
		
		//List 3
		function propertya_listings_list3($property_id)
		{
			$selected_pricelabel_after =  $optional_price = $rating_html = $optional_price = $verified_listing = $category = $grage = $home_features = $size = $baths = $rooms = $labels = $featured_listing = $author_dp = $post_id = $type = $street_addr = $price_rent = $all_idz =  $count ='';
			$get_all_prices = array();
			$localization = propertya_localization();
			$allowed_html = propertya_allowed_html();
			$all_idz = propertya_framework_fetch_gallery_idz($property_id);
			if (!is_null($all_idz) && is_array($all_idz)) {
              $count = count($all_idz);
			}
			else
			{
				$count = 0;
			}
			//prices
			$get_all_prices =  propertya_framework_fetch_price($property_id);
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
			  $price_rent = '<h3><span class="main-reg-price">'.$get_all_prices['main_price'].'</span> '. $selected_pricelabel_after.'</h3>';
			}
			//featured listing
			if (get_post_meta($property_id, 'prop_is_feature_listing', true ) == "1")
			{
				$featured_listing = '<div class="featured-ribbon" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['feat']).'">
					<div><i class="fas fa-star"></i></div>
				</div>';
			}
			//posted date
			$mydate =  get_the_date(get_option('date_format'), $property_id);
			//street address
			if(get_post_meta($property_id, 'prop_street_addr', true )!="")
			{
				$street_addr = '<p class="extrp"> <span> <i class="fas fa-location-arrow clr-yal"> </i></span>'.get_post_meta($property_id, 'prop_street_addr', true ).'</p>';
			}
			//labels
			if(!empty(propertya_getlabels($property_id)))
			{
				$labels = '<div class="property-labels absolute-yes"><div class="label-badges">
					    <ul class="list-unstyled">
						'.propertya_getlabels($property_id).'
                        </ul>
                    </div></div>';	
			}

			//category
			if(!empty(propertya_framework_selected_cat($property_id)))
			{
				$category = '<div class="propert-type"><span class="prop-category-sel">'.propertya_framework_selected_cat($property_id).'</span></div>';
			}

			//ratings
			$get_percentage = array();
			$get_percentage = propertya_reviews_average($property_id);
			if(!empty($get_percentage) && is_array($get_percentage) && count($get_percentage['ratings']) > 0 && !empty($get_percentage['rated_no_of_times']) && $get_percentage['rated_no_of_times'] > 0)
			{
				$rating_html = '<span class="ratings"> 
									'.wp_sprintf(__('%s (%d Reviews)', 'propertya'), $get_percentage['total_stars'],$get_percentage['rated_no_of_times']).'</span>';
			}
			//listing author dp
			$autho_contact =  $post_author_name = $verified_listing = '';
			$post_author = get_post_field('post_author', $property_id);
			if(get_user_meta($post_author, 'user_role_type', true) !="")
			{
				$type = get_user_meta($post_author, 'user_role_type', true);
				$post_id = get_user_meta( $post_author, 'prop_post_id' , true);
				$post_author_name = '<a href="'.esc_url(get_the_permalink($post_id)).'">'.get_the_title($post_id).'</a>';
				if(get_post_meta($post_id, $type.'_mobile', true )!="")
				{
					// $autho_contact = '<li class="my-contact"><span data-toggle="tooltip" data-placement="top" data-original-title=" href=tel:'.esc_attr(get_post_meta($post_id, $type.'_mobile', true )).'"><i class="fas fa-phone"></i></span></li>';
				$autho_contact = '<li class="my-contact"><a href="tel:' . esc_attr(get_post_meta($post_id, $type.'_mobile', true )) . '" data-toggle="tooltip" data-placement="top" data-original-title="'. esc_attr(get_post_meta($post_id, $type.'_mobile', true )) .'">
						  <i class="fas fa-phone"></i>
						</a></li>';
				}
			}
			//home features
			$author_dp = $type = $post_author = $home_features = $size = $baths = $rooms = '';
			$rooms =  get_post_meta($property_id,'prop_beds_qty', true );
			$baths =  get_post_meta($property_id,'prop_baths_qty', true );
			$size =  get_post_meta($property_id,'prop_area_size', true );
			$grage =  get_post_meta($property_id,'prop_garage_qty', true );
			if(!empty($rooms) || !empty($baths) || !empty($size) || !empty($grage))
			{
				$home_features .= '<div class="home-statistics-features"><ul>';
				if(!empty($size))
				{
					$home_features .= '<li>
							<i class="fas fa-clone"></i>
							<span>'.esc_html(number_format($size)).' '.get_post_meta($property_id,'prop_area_prefix', true ).'</span>
					</li>';				}
				if(!empty($grage))
				{
					$home_features .= '<li class="my-right">
							<i class="fas fa-warehouse"></i>
							<span>'.esc_html(sprintf('%02d', $grage)).'</span>
					</li>';
				}
				if(!empty($baths))
				{
					$home_features .= '<li class="my-right">
							<i class="fas fa-bath"></i>
							<span>'.esc_html(sprintf('%02d', $baths)).'</span>
					</li>';
				}
				if(!empty($rooms))
				{
					
					$home_features .= '<li class="my-right">
							<i class="fas fa-bed"></i>
							<span>'.esc_html(sprintf('%02d', $rooms)).'</span>
					</li>';
				}
				
				$home_features .= '</div></ul>';
			}
			return '<div class="col-xl-12 col-lg-12 col-md-12 col-12 grid-item">
			<div class="my-list3">
								<div class="my-list3-img-container">
									<a href="'.esc_url(get_the_permalink($property_id)).'"><img class="img-fluid " src="'.esc_url(propertya_framework_img_src($all_idz,'propertya-background')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'"></a>
									'.wp_kses($labels,$allowed_html).'
									
									<button data-compare-id="'.esc_attr($property_id).'" class="property-tools btn d-flex justify-content-center align-items-center compare-prop fav-comp" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['compare']).'"><i class="fas fa-random"></i></button>
					<button data-fav-id="'.esc_attr($property_id).'" class="property-tools btn d-flex justify-content-center align-items-center fav-prop" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['fav']).'"><i class="far fa-heart"></i></button>
					<div class="total-img-count">
                  		<span><i class="fas fa-camera"></i> '.$count.'</span>
                	</div>
								</div>
								<div class="my-list3-info-content ">
								'.wp_kses($featured_listing,$allowed_html).'
									<div class="my-list3-info-content-inner">
										<div class="my-list2-pricing">
											'.$price_rent.'
										</div>

										<h5 class="card-title">
											<a class="clr-black" href="'.esc_url(get_the_permalink($property_id)).'">'.propertya_title_limit(45,$property_id).'</a>										
										</h5>
										'.wp_kses($street_addr,$allowed_html).'
										'.$home_features.'										
										</div>									
									<div class="marketed-by">
										<ul>
											<li>
											<strong>'.esc_html__('Posted by','propertya').' : </strong>'.$post_author_name.'
											</li>
											'.$autho_contact.'
										</ul>
									</div>
								</div>
							</div>
							</div>';
		}
		
		//List 4
		function propertya_listings_list4($property_id)
		{
			$selected_pricelabel_after =  $optional_price = $price_rent = $all_idz = '';
			$get_all_prices = array();
			$localization = propertya_localization();
			$all_idz = propertya_framework_fetch_gallery_idz($property_id);
			//prices
			$get_all_prices =  propertya_framework_fetch_price($property_id);
			if(!empty($get_all_prices) && is_array($get_all_prices) && count($get_all_prices) > 0 && array_key_exists("main_price",$get_all_prices))
			{
			   if (array_key_exists("optional_price",$get_all_prices))
			   {
				   $optional_price = $get_all_prices['optional_price'];
			   }
			   if (array_key_exists("after_prefix",$get_all_prices))
			   {
				   $selected_pricelabel_after = '<span class="clr-blu">'.$get_all_prices['after_prefix'].'<span>';
			   }
			  $price_rent = '<div class="main-rate mb-1"><span class="main-reg-pricing clr-blu">'.$get_all_prices['main_price'].' </span><span class="additional-price-tag">'.$selected_pricelabel_after.'</span></div>';
			}
			$street_addr = '';
			if(get_post_meta($property_id, 'prop_street_addr', true )!="")
			{
				$street_addr = '<p class="extrp"><span><i class="clr-blu fas fa-location-arrow"></i></span>'.propertya_trim_locations(32,get_post_meta($property_id, 'prop_street_addr', true )).'</p>';
			}
			//home features
			$verified_listing = $author_dp = $type = $post_author = $home_features = $size = $baths = $rooms = '';
			$rooms =  get_post_meta($property_id,'prop_beds_qty', true );
			$baths =  get_post_meta($property_id,'prop_baths_qty', true );
			$size =  get_post_meta($property_id,'prop_area_size', true );
			if(!empty($rooms) || !empty($baths) || !empty($size))
			{
				$home_features .= '<div class="home-amenties">';
				if(!empty($rooms))
				{
					$home_features .= '<div class="rooms-row"> <span class="d-block  clr-black">'.esc_attr($localization['beds']).'</span> <span class="f-size-14 clr-p">'.esc_html(sprintf('%02d', $rooms)).'</span> </div>';
				}
				if(!empty($baths))
				{
					$home_features .= '<div class="rooms-beds"> <span class="d-block clr-black">'.esc_attr($localization['baths']).'</span> <span class="f-size-14 clr-p">'.esc_html(sprintf('%02d', $baths)).'</span> </div>';
				}
				if(!empty($size))
				{
					$home_features .= '<div class="rooms-size"> <span class="d-block clr-black">'.esc_attr($localization['size']).'</span> <span class="f-size-14 clr-p">'.esc_attr(number_format($size)).' '.get_post_meta($property_id,'prop_area_prefix', true ).'</span> </div>';
				}
				$home_features .= '</div>';
			}
			//listing author dp
			$post_author = get_post_field('post_author', $property_id);
			if(get_user_meta($post_author, 'user_role_type', true) !="")
			{
				$type = get_user_meta($post_author, 'user_role_type', true);
				$post_id = get_user_meta( $post_author, 'prop_post_id' , true);
				//verified listing
				if(get_post_meta($post_id, $type.'_is_trusted', true ) == "1")
				{
					$verified_listing = '<div class="is-verified"><i class="fas fa-check"></i></div>';
				}
				$author_dp = '<div class="listing-author-dp">
				'.$verified_listing.'
							<a href="'.esc_url(get_the_permalink($post_id)).'"><img src="'.esc_url(propertya_placeholder_images($type,$post_id,'propertya-user-thumb')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'" class="img-fluid"></a>
						</div>';	
			}
			//featured listing
			$featured_listing = '';
			if (get_post_meta($property_id, 'prop_is_feature_listing', true ) == "1")
			{
				$featured_listing = '<div class="featured-ribbon" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['feat']).'">
					<div><i class="fas fa-star"></i></div>
				</div>';
			}
            $text_direction = 'text-left';
            $txt_dir = 'text-right';
            $margin = 'ml-3';
            if(is_rtl())
            {
                $text_direction = 'text-right';
                $margin = 'mr-3';
                $txt_dir = 'text-left';
            }
			return '<div class="col-xl-12 col-lg-12 col-md-12 col-12 grid-item">
			<div class="main-div margin-bottom-30">
           		 <div class="row no-gutters">
              <div class="col-sm-12 col-md-5 col-lg-5 col-12">
                <div class="main-data ">
                  <div class="img-data">
				  <div class="my-prop-img p-relative">
				   <a href="'.esc_url(get_the_permalink($property_id)).'"><img src="'.esc_url(propertya_framework_img_src($all_idz,'propertya-background')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'" class="img-fluid"></a>
				   <div class="img-overlay"></div>
				   </div>
				 	
				   </div>
                  <div class="h2-lies2 my-bookmarks">
                    <ul class="list-unstyled my-3 mx-3 '.esc_attr($txt_dir).'">
                      <li class="list-inline-item"> <button data-compare-id="'.esc_attr($property_id).'" class="btn d-flex justify-content-center align-items-center compare-prop" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['compare']).'"><i class="fas fa-random"></i></button> </li>
                      <li class="list-inline-item"> <button data-fav-id="'.esc_attr($property_id).'" class="btn d-flex justify-content-center align-items-center fav-prop" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['fav']).'"><i class="far fa-heart"></i></button> </li>
                    </ul>
                  </div>
                  <div class="d-btn">
                    <ul class="list-unstyled mb-3 '.esc_attr($margin).' '.esc_attr($text_direction).'">
                      '.propertya_getlabels($property_id).'
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-md-7 col-lg-7 col-12">
                <div class="listing-data d-flex  h-100">
				  '.$featured_listing.'
                  <div class="heaing-d align-self-center">
				  <div class="prop-cat">'.propertya_framework_selected_cat($property_id).' </div>
                    <h3 class="text-capitalize">
						<a href="'.esc_url(get_the_permalink($property_id)).'" class="clr-black">'.propertya_title_limit(45,$property_id).'</a>
					</h3>
					'.$price_rent.'
                    '.$street_addr.'
					<div class="home-amenties-features">
						'.$home_features.'
						'.$author_dp.'
            		</div>
                  </div>
                </div>
              </div>
            </div>
      		 </div></div>';
		}
		
		//List 5
		function propertya_listings_list5($property_id)
		{
			$selected_pricelabel_after =  $optional_price = $rating_html = $optional_price = $verified_listing = $category = $grage = $home_features = $size = $baths = $rooms = $labels = $featured_listing = $author_dp = $post_id = $type = $street_addr = $price_rent = $all_idz = '';
			$get_all_prices = array();
			$localization = propertya_localization();
			$allowed_html = propertya_allowed_html();
			$all_idz = propertya_framework_fetch_gallery_idz($property_id);
			//prices
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
			  $price_rent = ' <div class="price-tag"><h3><span class="main-reg-price">'.$get_all_prices['main_price'].'</span> '. $selected_pricelabel_after.'</h3></div>';
			}
			//featured listing
			if (get_post_meta($property_id, 'prop_is_feature_listing', true ) == "1")
			{
				$featured_listing = '<div class="featured-ribbon" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['feat']).'">
					<div><i class="fas fa-star"></i></div>
				</div>';
			}
			//posted date
			$mydate =  get_the_date(get_option('date_format'), $property_id);
			//street address
			if(get_post_meta($property_id, 'prop_street_addr', true )!="")
			{
				$street_addr = '<p class="extrp"> <span> <i class="fas fa-location-arrow clr-yal"> </i></span>'.get_post_meta($property_id, 'prop_street_addr', true ).'</p>';
			}
			//labels
			if(!empty(propertya_getlabels($property_id)))
			{
				$labels = '<div class="property-labels absolute-no"><div class="label-badges">
					    <ul class="list-unstyled">
						'.propertya_getlabels($property_id).'
                        </ul>
                    </div></div>';	
			}
			//category
			if(!empty(propertya_framework_selected_cat($property_id)))
			{
				$category = '<li><i class="fas fa-cog"></i> '.propertya_framework_selected_cat($property_id).' </li>';
			}
			
			//listing author dp
			$autho_contact =  $post_author_name = $verified_listing = '';
			$post_author = get_post_field('post_author', $property_id);
			if(get_user_meta($post_author, 'user_role_type', true) !="")
			{
				$type = get_user_meta($post_author, 'user_role_type', true);
				$post_id = get_user_meta( $post_author, 'prop_post_id' , true);
				$post_author_name = '<div class="detail-button"> '.esc_html__('Listed by','propertya').' :  <a href="'.esc_url(get_the_permalink($post_id)).'">'.get_the_title($post_id).'</a> </div>';
			}
			
			//description
			$description = '';
			if(!empty(get_the_content($property_id)))
			{
				$description = '<p> '.wp_trim_words(get_the_excerpt($property_id), 12, '...' ).'</p>';
			}
			$features_html = '';
			//features
			$features_list = array();
			$features_list = wp_get_object_terms($property_id,array('property_feature'), array('orderby'=>'name','order'=> 'ASC'));
			if(!empty($features_list) && is_array($features_list) && count($features_list) > 0)
			{
				 if (!is_wp_error($features_list))
				 {
					$img = $image_id =  $feature_img = '';
					 $features_html .= '<ul class="facilities-list clearfix">';
					 $i = 0;
					 foreach( $features_list as $features )
					 {
                         $img = '';
						 if(get_term_meta($features->term_id, 'property_feature_term_meta_img', true )!="")
						 {
							$image_id = get_term_meta($features->term_id, 'property_feature_term_meta_img', true);
							$img = wp_get_attachment_image($image_id, 'thumbnail');
						 }
						 $features_html .= '<li>'.$img.' '.esc_html($features->name).'</li>';
						 $i++;
						 if($i ==  6) break;
					 }
					  $features_html .= '</ul>';
				 }
			}
			
			return '<div class="col-xl-12 col-lg-12 col-md-12 col-12 grid-item">
						<div class="my-list5">
							<div class="my-list5-container">
                                       <div class="my-list5-img">
                                          <a href="'.esc_url(get_the_permalink($property_id)).'"><img src="'.esc_url(propertya_framework_img_src($all_idz,'propertya-background')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'" class="img-fluid"></a>
                                            '.$price_rent.'
                                       </div>
                                       <div class="short-description-1 clearfix">
										 '.wp_kses($featured_listing,$allowed_html).' 
										  '.wp_kses($labels,$allowed_html).' 
										  <h5 class="card-title">
											<a class="clr-black" href="'.esc_url(get_the_permalink($property_id)).'">'.propertya_title_limit(45,$property_id).'</a>										
										</h5>
										 '.$street_addr.'
										 '.$features_html.'       
                                       </div>
                                       <div class="my-list5-info-meta">
                                          <ul>
                                             '.$category.'
                                             <li> <i class="far fa-clock"></i> '.esc_html(date_i18n( get_option( 'date_format' ), strtotime($mydate))).' </li>
                                             <li class="views"> <i class="far fa-eye"></i>  '.wp_sprintf(__('%s Views', 'propertya'), propertya_number_format_short(intval(get_post_meta($property_id, 'prop_listing_total_views', true)))).' </li>
                                          </ul>
                                         '.$post_author_name .'
                                       </div>
                                    </div>
						</div>
					</div>';
		}
		
		//Classic List
		function propertya_listings_classic($property_id)
		{
			$selected_pricelabel_after =  $optional_price = $price_rent = $all_idz = '';
			//prices
			$get_all_prices = array();
			$all_idz = propertya_framework_fetch_gallery_idz($property_id);
			$allowed_html = propertya_allowed_html();
			$get_all_prices =  propertya_framework_fetch_price($property_id);
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
			  $price_rent = '<h4><span class="main-reg-price">'.$get_all_prices['main_price'].'</span> '. $selected_pricelabel_after.'</h4>';
			}
			$localization = propertya_localization();
			$size = $baths = $rooms = $home_features = '';
			$rooms =  get_post_meta($property_id,'prop_beds_qty', true );
			$baths =  get_post_meta($property_id,'prop_baths_qty', true );
			$size =  get_post_meta($property_id,'prop_area_size', true );
			if(!empty($rooms) || !empty($baths) || !empty($size))
			{
				if(!empty($rooms))
				{
					$home_features .='<li class="list-inline-item"><span>'.esc_html(sprintf('%02d', $rooms)).'</span><span class="text">'.esc_attr($localization['beds']).'</span></li>';
					
				}
				if(!empty($baths))
				{
					
					$home_features .='<li class="list-inline-item"><span>'.esc_html(sprintf('%02d', $baths)).'</span><span class="text">'.esc_attr($localization['baths']).'</span></li>';
				}
			}
			//description
			$description = '';
			if(!empty(get_the_content($property_id)))
			{
				$description = '<p class="p-inner"> '.wp_trim_words(get_the_excerpt($property_id), 6, '...' ).'</p>';
			}
			//offer type
			$type_term    = $type = $offer_type = '' ;
			// if(get_post_meta( $property_id, 'prop_offer_type', true ) !="")
			// {
			// 	$offer_type = get_post_meta( $property_id, 'prop_offer_type', true );
			// 	$type_term    = propertya_get_term($offer_type,'property_status');
				
			// 	$type = ' <li class="list-inline-item"><span class="text"><a href="'. esc_url(get_term_link($type_term->term_id)).'">'.esc_attr($type_term->name).'</a></span></li> ';
			// }
			if(get_post_meta( $property_id, 'prop_offer_type', true ) !="")
			{
				$offer_type = get_post_meta( $property_id, 'prop_offer_type', true );
				$type_term    = propertya_get_term($offer_type,'property_status');
				
				if (!is_wp_error($type_term)  && !empty($type_term)) {
				
				$type = ' <li class="list-inline-item"><span class="text"><a href="'. esc_url(get_term_link($type_term->term_id)).'">'.esc_attr($type_term->name).'</a></span></li> ';
				}
			}
			// street address
			$street_addr = '';
			if(get_post_meta($property_id, 'prop_street_addr', true )!="")
			{
				$street_addr = '<p class="extrp"><span><i class="clr-yal fas fa-location-arrow"></i></span>'.get_post_meta($property_id, 'prop_street_addr', true ).'</p>';
			}
			//listing author dp
			$author_dp = '';
			$post_author = get_post_field('post_author', $property_id);
			if(get_user_meta($post_author, 'user_role_type', true) !="")
			{
				$types = get_user_meta($post_author, 'user_role_type', true);
				$post_id = get_user_meta( $post_author, 'prop_post_id' , true);
				$author_dp = '<div class="images-link">
							<span class="img-span">
							<a href="'.esc_url(get_the_permalink($post_id)).'"><img src="'.esc_url(propertya_placeholder_images($types,$post_id,'propertya-user-thumb')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'" class="img-fluid rounded"></a>
						</span>
						<span class="text-span">
					  		<b><a href="'.esc_url(get_the_permalink($post_id)).'">'.propertya_title_limit(15,$post_id).'</a></b>
					 	</span>
						</div> ';		
			}
			return '<div class="col-sm-6 col-lg-6 col-xl-6 col-md-12 col-12 margin-bottom-30 grid-item">
			 <div class="property-main">
			  <div class="row no-gutters">
				  <div class="col-md-4 col-lg-4">
					<div class="property-img">
					<a href="'.esc_url(get_the_permalink($property_id)).'"><img class="img-fluid rounded main-img" src="'.esc_url(propertya_framework_img_src($all_idz,'propertya-extra-small')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'"></a>
					 <button data-compare-id="'.esc_attr($property_id).'" class="property-tools btn d-flex justify-content-center align-items-center compare-prop" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['compare']).'"><i class="fas fa-random"></i></button>
					<button data-fav-id="'.esc_attr($property_id).'" class="property-tools btn d-flex justify-content-center align-items-center fav-prop" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['fav']).'"><i class="far fa-heart"></i></button>
					'.$author_dp.'
					</div> 
				  </div>
				  <div class="col-md-8 col-lg-8">
				   <div class="property-data">
					<div class="text-inner"> 
					  '.$price_rent.'
					 <h3><a class="clr-black" href="'.esc_url(get_the_permalink($property_id)).'">'.propertya_title_limit(28,$property_id).'</a>	</h3>
					 '.$street_addr.'
					 '.$description.'	
					</div>     
					 <div class="ul-text">
					  <ul class="list-unstyled">
						 '.$home_features.'
						 '.$type.'
					  </ul>	 
					 </div>  
				   </div>
				  </div>
			  </div>	 
			 </div>  
			</div>';
		}


         //List 6
         function propertya_listings_list6($property_id)
         {
             $selected_pricelabel_after =  $optional_price = $optional_price = $verified_listing = $category = $grage = $home_features = $size = $baths = $rooms = $labels = $featured_listing = $author_dp = $post_id = $type = $street_addr = $price_rent = $all_idz = '';
             $get_all_prices = array();
             $localization = propertya_localization();
             $allowed_html = propertya_allowed_html();
             $all_idz = propertya_framework_fetch_gallery_idz($property_id);
             //prices
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
                 $price_rent = '<h3><span class="main-reg-price">'.$get_all_prices['main_price'].'</span> '. $selected_pricelabel_after.'</h3>';
             }
             //featured listing
             if (get_post_meta($property_id, 'prop_is_feature_listing', true ) == "1")
             {
                 $featured_listing = '<div class="featured-ribbon" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['feat']).'">
					<div><i class="fas fa-star"></i></div>
				</div>';
             }
             //posted date
             $mydate =  get_the_date(get_option('date_format'), $property_id);
             //street address
             if(get_post_meta($property_id, 'prop_street_addr', true )!="")
             {
                 $street_addr = '<p class="extrp"> <span> <i class="fas fa-location-arrow clr-yal"> </i></span>'.get_post_meta($property_id, 'prop_street_addr', true ).'</p>';
             }
             //labels
             if(!empty(propertya_getlabels($property_id)))
             {
                 $labels = '<div class="property-labels absolute-yes"><div class="label-badges">
					    <ul class="list-unstyled">
						'.propertya_getlabels($property_id).'
                        </ul>
                    </div></div>';
             }
             //category
             if(!empty(propertya_framework_selected_cat($property_id)))
             {
                 $category = '<div class="propert-type"><span class="prop-category-sel">'.propertya_framework_selected_cat($property_id).'</span></div>';
             }

             //home features
             $author_dp = $type = $post_author = $home_features = $size = $baths = $rooms = '';
             $rooms =  get_post_meta($property_id,'prop_beds_qty', true );
             $halfrooms =  get_post_meta($property_id,'prop_req_registered_title', true );
             $size =  get_post_meta($property_id,'prop_area_size', true );
             $l_size =  get_post_meta($property_id,'prop_land_size', true );
             if(!empty($rooms) || !empty($baths) || !empty($size))
             {
                 $home_features .= '<div class="home-amenties">';
                 if(!empty($size))
                 {
                     $home_features .= '<div class="rooms-size"> <span class="d-block clr-black">'.esc_attr($localization['size']).'</span> <span class="f-size-14 clr-p">'.esc_attr(number_format($size)).' '.get_post_meta($property_id,'prop_area_prefix', true ).'</span> </div>';
                 }
                 if(!empty($l_size))
                 {
                     $home_features .= '<div class="land-size"> <span class="d-block clr-black">'.esc_attr($localization['land_area']).'</span> <span class="f-size-14 clr-p">'.esc_attr(number_format($size)).' '.get_post_meta($property_id,'prop_land_prefix', true ).'</span> </div>';
                 }
                 if(!empty($rooms))
                 {
                     $home_features .= '<div class="rooms-row"> <span class="d-block  clr-black">'.esc_attr($localization['full_rooms']).'</span> <span class="f-size-14 clr-p">'.esc_attr($rooms).'</span> </div>';
                 }
                 if(!empty($halfrooms))
                 {
                     $home_features .= '<div class="half-rooms"> <span class="d-block clr-black">'.esc_attr($localization['half_rooms']).'</span> <span class="f-size-14 clr-p">'.esc_attr($halfrooms).'</span> </div>';
                 }

                 $home_features .= '</div>';
             }
             //listing author dp
             $verified_listing = '';
             $post_author = get_post_field('post_author', $property_id);
             if(get_user_meta($post_author, 'user_role_type', true) !="")
             {
                 $type = get_user_meta($post_author, 'user_role_type', true);
                 $post_id = get_user_meta( $post_author, 'prop_post_id' , true);
                 //verified listing
                 if(get_post_meta($post_id, $type.'_is_trusted', true ) == "1")
                 {
                     $verified_listing = '<div class="is-verified"><i class="fas fa-check"></i></div>';
                 }
//                 $author_dp = '<div class="listing-author-dp">
//				'.$verified_listing.'
//							<a href="'.esc_url(get_the_permalink($post_id)).'"><img src="'.esc_url(propertya_placeholder_images($type,$post_id,'propertya-user-thumb')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'" class="img-fluid"></a>
//						</div>';
             }
             //featured listing
             $featured_listing = '';
             if (get_post_meta($property_id, 'prop_is_feature_listing', true ) == "1")
             {
                 $featured_listing = '<div class="featured-ribbon" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['feat']).'">
					<div><i class="fas fa-star"></i></div>
				</div>';
             }
             //posted date
             $mydate =  get_the_date(get_option('date_format'), $property_id);
             // get directions
             $lon =  $get_directions =  $latt = '';
             $latt = get_post_meta($property_id, 'prop_latt', true );
             $lon = get_post_meta($property_id, 'prop_long', true );
             if(!empty($latt) && !empty($lon))
             {
                 $get_directions = '<a class="explore-nearby" href="//www.google.com/maps?daddr='.esc_attr($latt).','.esc_attr($lon).'" target="_blank"><i class="fas fa-map-signs"></i> '.esc_html__('Get Directions','propertya').'
</a>';
             }
             return '<div class="col-xl-12 col-lg-12 col-md-12 col-12 grid-item">
						<div class="card my-list2">
						<div class="card-header">
							<h5 class="card-title">
								<a class="clr-black" href="'.esc_url(get_the_permalink($property_id)).'">'.propertya_title_limit(45,$property_id).'</a>
							
							</h5>
							'.wp_kses($street_addr,$allowed_html).'
							'.wp_kses($get_directions,$allowed_html).'
               '.$featured_listing.'
						</div>
					    <div class="card-body">
						<div class="row">
                        <div class="col-lg-5 col-md-5">
							<div class="my-list2-img-cont">
                               <a class="clr-black" href="'.esc_url(get_the_permalink($property_id)).'"><img class="img-fluid" src="'.esc_url(propertya_framework_img_src($all_idz,'propertya-blog-thumb')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'"></a>
							   '.wp_kses($labels,$allowed_html).'
							 <button data-compare-id="'.esc_attr($property_id).'" class="property-tools fav-comp btn d-flex justify-content-center align-items-center compare-prop" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['compare']).'"><i class="fas fa-random"></i></button>
					<button data-fav-id="'.esc_attr($property_id).'" class="property-tools btn d-flex justify-content-center align-items-center fav-prop" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($localization['fav']).'"><i class="far fa-heart"></i></button>
					<div class="total-img-count">
                  		<span><i class="fas fa-camera"></i> '.count($all_idz).'</span>
                	</div>
							   </div> 
                        </div>
                        <div class="col-lg-7 col-md-7">
						<div class="my-list2-pricing">
                            '.$price_rent.'
						</div>
							<p>'.wp_trim_words(get_the_excerpt($property_id), 15, '...' ).'</p>
												<div class="home-amenties-features">
						'.$home_features.'
						'.$author_dp.'
            		</div>
												<div class="posted-date">'.wp_sprintf(__('Listed on %s', 'propertya'), get_the_date(get_option('date_format'), $property_id)).'</div>
											</div>
                        </div>
                    </div>
				   </div>
			</div>';
         }

	 }
}