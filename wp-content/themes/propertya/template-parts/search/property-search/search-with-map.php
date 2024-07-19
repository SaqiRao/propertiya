

<?php
global $propertya_options;
    global $localization;
    $selected_offer_label = $selected_offer_type = $selected_type = '';
    //get currency
    $selected_cur = '';
if(propertya_strings('prop_currency_mode') !="" && propertya_strings('prop_currency_mode') == 2)
{
    $custom_currency = propertya_framework_term_fetch('property_currency',0);
    if(!empty($custom_currency) && count((array) $custom_currency) > 0 && !is_wp_error($custom_currency))
    {
        $p_currency_sym = $p_currency_code = $options = '';
        foreach($custom_currency as $currency)
        {
            $selected_cur = '';
            if(!empty($selected_currency) && $selected_currency == $currency->slug)
            {
                $selected_cur = 'selected="selected"';
            }
            if(get_term_meta( $currency->term_id, 'p_currency_code', true ) !="")
            {
                $p_currency_code = get_term_meta( $currency->term_id, 'p_currency_code', true );
                $p_currency_sym = get_term_meta( $currency->term_id, 'p_currency_sym', true );
                $options .= '<option value="' . $currency->slug. '" '.$selected_cur.'>' . $p_currency_code .' ( ' . $p_currency_sym . ' )'. '</option>';
            }
            else
            {
                $options .= '<option value="' . $currency->slug. '" '.$selected_cur.'>' . $currency->name . '</option>';
            }
        }
    }
}
$location_option = $term_ID = $term_idz = $tax_name = $term_id = $queried_object = '';
$queried_object = get_queried_object();
if (!empty($queried_object) && count((array) $queried_object) > 0)
{
    $term_id = $queried_object->term_id;
    $tax_name = $queried_object->taxonomy;
    if (!empty($term_id))
	{
        $term_idz = get_term_by('id', $term_id, $tax_name);
        $term_ID = $term_idz->term_id;
		$term_name = $term_idz->name;
        $selected_type = $term_idz->slug;
		$selected_offer_type = $term_idz->slug;
		$selected_offer_label = $term_idz->slug;
        //for location only
        if (is_tax('property_location')) {
           
            $location_option = '<option value="' . $selected_type . '" selected="selected">' . $term_name . '</option>';
        }
    }
}
//title
$title = '';
if (isset($_GET['by_title']) && $_GET['by_title'] != "")
{
    $title =  trim($_GET['by_title']);
}
//property type
if (isset($_GET['property-type']) && $_GET['property-type'] != "")
{
	$selected_type = trim($_GET['property-type']);
}
//offer type
if (isset($_GET['offer-type']) && $_GET['offer-type'] != "")
{
	$selected_offer_type = " " .trim($_GET['offer-type']);
   
}
//by location
if (isset($_GET['location-by']) && $_GET['location-by'] != "")
{
	 $get_valz = get_term_by('slug', trim($_GET['location-by']), 'property_location');
	 $final_slug = $get_valz->slug;
     $final_name = $get_valz->name;
     $location_option = '<option value="' . $final_slug . '" selected="selected">' . $final_name . '</option>';
}
//currency type
$selected_currency = $seleted_term = '';
if (isset($_GET['currency-type']) && $_GET['currency-type'] != "")
{
	$selected_currency = get_term_by('slug', trim($_GET['currency-type']), 'property_currency');
	if(!empty($selected_currency))
	{
		if(get_term_meta( $selected_currency->term_id, 'p_currency_code', true ) !="")
		{
			$p_currency_code = get_term_meta( $selected_currency->term_id, 'p_currency_code', true );
			$p_currency_sym = get_term_meta( $selected_currency->term_id, 'p_currency_sym', true );
			$options .= '<option value="' . $selected_currency->slug. '" selected="selected">' . $p_currency_code .' ( ' . $p_currency_sym . ' )'. '</option>';
		}
		else
		{
			$options .= '<option value="' . $selected_currency->slug. '" selected="selected">' . $selected_currency->name . '</option>';
		}
	}
}
//offer type
if (isset($_GET['label-type']) && $_GET['label-type'] != "")
{
	$selected_offer_label = trim($_GET['label-type']);
}
//price
$max_price = $min_price = '';
if (isset($_GET['min-price']) && $_GET['min-price'] != "")
{
	$min_price = doubleval($_GET['min-price']);
}
if (isset($_GET['max-price']) && $_GET['max-price'] != "")
{
	$max_price = doubleval($_GET['max-price']);
}
//Area 
$max_area = $min_area = '';
if (isset($_GET['min-area']) && $_GET['min-area'] != "")
{
	$min_area = doubleval($_GET['min-area']);
}
if (isset($_GET['max-area']) && $_GET['max-area'] != "")
{
	$max_area = doubleval($_GET['max-area']);
}
//Bedrooms
$beds = '';
if (isset($_GET['type-beds']) && $_GET['type-beds'] != "")
{
	$beds = $_GET['type-beds'];
}
//Bathroom
$baths = '';
if (isset($_GET['type-bath']) && $_GET['type-bath'] != "")
{
	$baths = $_GET['type-bath'];
}
$collapse_show = '';
if(!empty($beds) || !empty($baths) || !empty($min_area) || !empty($max_area) || !empty($min_price) || !empty($max_price))
{
	$collapse_show = 'show';
}
//near me
$none_class = 'none';
$current_min = 20;
$distance = $long = $latt = '';
if (isset($_GET['latt']) && $_GET['latt'] != "" && isset($_GET['long']) && $_GET['long'] != "" && isset($_GET['distance']) && $_GET['distance'] != "")
{
	$latt = $_GET['latt'];
	$long = $_GET['long'];
	$distance = $_GET['distance'];
	$current_min = $distance;
	$none_class = '';
}
//layout
// $grid_type = 'grid';
if (isset($_GET['list-type']) && $_GET['list-type'] == "list") {
    $grid_type = 'list';
}
else
{
  $grid_type = $propertya_options['prop_listing_search_grids'];
}
?>
<div class="no-container">
        <div class="left-area">
        	<div id="mapid" class="map"></div> 
         
        </div>
        <div class="right-area">
            <div class="inner-content">
                <div class="map-with-filters">
                <form method="post" id="mylistings_search">
                    <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-5 col-12">
                    <div class="form-group">
                    <select class="search-selects" id="offer_type"  data-placeholder="<?php echo esc_attr($localization['offer_type']); ?>" name="offer-type">
                    <?php propertya_framework_terms_options('property_status' , $selected_offer_type); ?>
                    </select>
                    </div>
                    </div>
                    <div class="col-xl-7 col-lg-7 col-md-6 col-12">
                        <div class="form-group">
                            <div class="typeahead__container">
                                <div class="typeahead__field">
                                    <div class="typeahead__query">
                                    <input name="by_title" value="<?php echo esc_attr($title); ?>" autocomplete="off" type="search" class="for_search_pages form-control specific_search" placeholder="<?php echo esc_attr__("Keyword (e.g 'office')", 'propertya'); ?>">
                                    </div>
                                    <div class="typeahead__button real-search-s">
                <button type="button" class="get_title">
                    <span class="typeahead__search-icon"><i class="fa fa-search"></i></span>
                </button>
            </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-1">
                    <div class="widget-inner-icon"><a class="show-additional-features-map" data-toggle="collapse" data-target="#mapfeatures-content"><i class="fas fa-sliders-h"></i>    </a> </div>
                    </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                             <div class="form-group">
                    <select class="search-selects"  data-placeholder="<?php echo esc_attr($localization['property_type']); ?>" name="property-type" id="property_type">
                    <?php propertya_framework_terms_options('property_type' , $selected_type); ?>
                    </select>
                    </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                             <div class="form-group">
        		 <select class="custom-locations" id="custom_locations"  data-placeholder="<?php echo esc_attr__("Location", 'propertya'); ?>" name="location-by">
                 <option value=""></option>
                 <?php echo ''.$location_option; ?>
                </select>
              </div>
                        </div>
                        <?php if(propertya_strings('prop_currency_mode') !="" && propertya_strings('prop_currency_mode') == 2) { ?>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                             <div class="form-group">
        		 <select class="search-selects"  data-placeholder="<?php echo esc_attr($localization['currecny_type']); ?>" name="currency-type" id="currency_type">
                  <option value=""><?php echo esc_html__('Select an option','propertya'); ?></option>
                   <?php echo ' ' .$options; ?>
                </select>
                </div>
                        </div>
                        <?php } ?>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                             <div class="form-group">
        		 <select class="search-selects"  data-placeholder="<?php echo esc_attr($localization['status']); ?>" name="label-type" id="label_type">
                  <?php propertya_framework_terms_options('property_label' , $selected_offer_label); ?>
                </select>              </div>
                        </div>
                    </div>        
                    <div id="mapfeatures-content" class="collapse <?php echo esc_attr($collapse_show); ?>">
                    
                    <div class="row">
                        <div class="col-xl-6">
                        <div class="form-group" >
                                         <label><?php echo esc_html($localization['price']); ?></label>

                  <div class="input-group" >
                    <input type="text" class="form-control" name="min-price" placeholder="<?php echo esc_attr__('Price From','propertya'); ?>" value="<?php echo esc_attr($min_price); ?>" >
                    <div class="input-group-prepend input-group-append">
                      <span class="input-group-text">-</span>
                    </div>
                    <input type="text" class="form-control" name="max-price" placeholder="<?php echo esc_attr__('Price To','propertya'); ?>" value="<?php echo esc_attr($max_price); ?>">
                    
                  </div>
               </div>
                        </div>
                        
                        
                         <div class="col-xl-6">
                       		 <div class="form-group" >
                 <label><?php echo esc_html($localization['property_area']); ?> <?php echo esc_html__('(Sqft)','propertya'); ?></label>
                  <div class="input-group" >
                    <input type="text" class="form-control" name="min-area" placeholder="<?php echo esc_attr__('Area From','propertya'); ?>" value="<?php echo esc_attr($min_area); ?>" >
                    <div class="input-group-prepend input-group-append">
                      <span class="input-group-text">-</span>
                    </div>
                    <input type="text" class="form-control" name="max-area" placeholder="<?php echo esc_attr__('Area To','propertya'); ?>" value="<?php echo esc_attr($max_area); ?>">
                  </div>
               </div>
                        </div>
                        
                        
                          <div class="col-6">
                        <div class="form-group label-bed"> 
                <label><i class="fas fa-bed"></i> <?php echo esc_html($localization['bedrooms']); ?></label>
                 <div class="stv-radio-buttons-wrapper">
                    <input type="radio" class="stv-radio-button" name="type-beds" value="" id="bed-any" <?php if(empty($beds)){echo "checked='checked'";} ?> />
                    <label for="bed-any"><?php echo esc_html__('Any','propertya'); ?></label>            
                    <input type="radio" class="stv-radio-button" name="type-beds" value="1" <?php checked( 1 == $beds ); ?> id="bed1" />
                    <label for="bed1"><?php echo esc_html__('1+','propertya'); ?></label>
                    <input type="radio" class="stv-radio-button" name="type-beds" value="2" <?php checked( 2 == $beds ); ?> id="bed2" />
                    <label for="bed2"><?php echo esc_html__('2+','propertya'); ?></label>
                    <input type="radio" class="stv-radio-button" name="type-beds" value="3" <?php checked( 3 == $beds ); ?> id="bed3" />
                    <label for="bed3"><?php echo esc_html__('3+','propertya'); ?></label>
                    <input type="radio" class="stv-radio-button" name="type-beds" value="4" <?php checked( 4 == $beds ); ?> id="bed4" />
                    <label for="bed4"><?php echo esc_html__('4+','propertya'); ?></label>
                    <input type="radio" class="stv-radio-button" name="type-beds" value="5" <?php checked( 5 == $beds ); ?> id="bed5" />
                    <label for="bed5"><?php echo esc_html__('5+','propertya'); ?></label>
				</div>
			 </div>
                        </div>
                        <div class="col-6">
                        <div class="form-group label-bath"> 
                <label><i class="fas fa-bath"></i> <?php echo esc_html($localization['bathrooms']); ?></label>
                <div class="stv-radio-buttons-wrapper">
                    <input type="radio" class="stv-radio-button" name="type-bath" value="" id="bath-any" <?php if(empty($baths)){echo "checked='checked'";} ?> />
                    <label for="bath-any"><?php echo esc_html__('Any','propertya'); ?></label>            
                    <input type="radio" class="stv-radio-button" name="type-bath" value="1" <?php checked( 1 == $baths ); ?> id="bath1" />
                    <label for="bath1"><?php echo esc_html__('1+','propertya'); ?></label>
                    <input type="radio" class="stv-radio-button" name="type-bath" value="2" <?php checked( 2 == $baths ); ?> id="bath2" />
                    <label for="bath2"><?php echo esc_html__('2+','propertya'); ?></label>
                    <input type="radio" class="stv-radio-button" name="type-bath" value="3" <?php checked( 3 == $baths ); ?> id="bath3" />
                    <label for="bath3"><?php echo esc_html__('3+','propertya'); ?></label>
                    <input type="radio" class="stv-radio-button" name="type-bath" value="4" <?php checked( 4 == $baths ); ?> id="bath4" />
                    <label for="bath4"><?php echo esc_html__('4+','propertya'); ?></label>
                    <input type="radio" class="stv-radio-button" name="type-bath" value="5" <?php checked( 5 == $baths ); ?> id="bath5" />
                    <label for="bath5"><?php echo esc_html__('5+','propertya'); ?></label>
				</div>
			 </div>
                        </div>
                                                
                    </div>
                    
                    <div class="d-flex justify-content-end search-map-btn">
                         <button type="button" name="properties_search" class="btn btn-theme"><?php echo esc_html__('Apply Filters', 'propertya'); ?></button>
                         
                <input type="hidden" name="list-type" value="<?php echo esc_attr($grid_type); ?>">
                    </div>
                    
                    
                  
                    </div>
                <input type="hidden" name="latt" value="<?php echo esc_attr($latt); ?>">
                <input type="hidden" name="long" value="<?php echo esc_attr($long); ?>">
                <input type="hidden" name="distance" value="<?php echo esc_attr($distance); ?>">


                </form>    
                </div>        
            <div class="data-with-result">          		
                   <div class="filter-sorting-bar d-flex flex-wrap justify-content-between align-items-center">
                    <h4>
                    <?php echo wp_sprintf(__('Showing 1 - %s of <span class="clr-yal"> %d Listings </span>', 'propertya'), get_option('posts_per_page'),esc_attr($results->found_posts)); ?>
                    </h4>
                    <div class=" d-flex d-block  align-items-center">
                    <span class="sort-label align-self-center"><?php echo esc_html__('Sort by', 'propertya'); ?>:</span>
                    <div class="short-by">                       
                    <select name="sort-by" id="sort-by" class="sort-selects" data-placeholder="Newest To Oldest">
                      <option value="newest"><?php echo esc_html__('Newest To Oldest', 'propertya'); ?></option>
                      <option value="oldest"><?php echo esc_html__('Oldest To New', 'propertya'); ?></option>
                      <option value="price-desc"><?php echo esc_html__('High to Low Price', 'propertya'); ?></option>
                      <option value="price-asc"><?php echo esc_html__('Low to High Price', 'propertya'); ?></option>
                      <option value="title-asc"><?php echo esc_html__('Alphabetically [a-z]', 'propertya'); ?></option>
                      <option value="title-desc"><?php echo esc_html__('Alphabetically [z-a]', 'propertya'); ?></option>
                    </select>
                    </div>
                    <ul class="filters-nav" role="tablist">
                    <li> 
                     <a href="<?php echo esc_url(get_the_permalink().$grid_type =  '?list-type=grid');?>" class="style-selec active-grid make-me-dark"><i  class="fas fa-th"></i></a>
                    </li>
                    <li>   <a href="<?php echo esc_url(get_the_permalink().$grid_type =  '?list-type=list');?>" class="style-selec make-me-dark"><i class="fas fa-bars"></i></a>
                     </li>
                    </ul>
                    </div>
                    </div>
                   <div class="my-filer-tags">
                    <?php
                    if (!empty($_GET)) {
                    echo '<div class="filter-tags"><ul class="filter-tags-list">
                    <li class="filter-tags-render">
                    <span class="filter-reset">'.esc_html__('Clear All', 'propertya').':</span>'.esc_html__('Filters', 'propertya').'
                    <a href="javascript:void(0)" id="reset_ajax_result" class="filter-reset-btn">×</a>
                    </li>
                    </ul></div>';
                    }
                    ?>
                    </div>
                   <div class="row grid">
                    <?php
                    $fetch_output = '';
                    if ($results->have_posts())
                    {
                     require trailingslashit(get_template_directory()) . "template-parts/search/property-search/grids/grids.php";
                     echo ' '.$fetch_output;
                    }
                    else
                    {
                    echo propertya_framework_no_result_found(); 
                    }
                    ?>
                    </div>
                   <div class="my-loading-bar">     
                    <article class="fb-like-animation post--is-loading">
                    <div class="post__loader">
                    <div class="loader__bar--1"></div>
                    <div class="loader__bar--2"></div>
                    <div class="loader__bar--3"></div>
                    <div class="loader__bar--4"></div>
                    <div class="loader__bar--5"></div>
                    <div class="loader__bar--6"></div>
                    <div class="loader__bar--7"></div>
                    <div class="loader__bar--8"></div>
                    <div class="loader__bar--9"></div>
                    <div class="loader__bar--10"></div>
                    <div class="loader__bar--11"></div>
                    <div class="loader__bar--12"></div>
                    </div>
                    </article>
                    <article class="fb-like-animation post--is-loading">
                    <div class="post__loader">
                    <div class="loader__bar--1"></div>
                    <div class="loader__bar--2"></div>
                    <div class="loader__bar--3"></div>
                    <div class="loader__bar--4"></div>
                    <div class="loader__bar--5"></div>
                    <div class="loader__bar--6"></div>
                    <div class="loader__bar--7"></div>
                    <div class="loader__bar--8"></div>
                    <div class="loader__bar--9"></div>
                    <div class="loader__bar--10"></div>
                    <div class="loader__bar--11"></div>
                    <div class="loader__bar--12"></div>
                    </div>
                    </article>
                    <article class="fb-like-animation post--is-loading">
                    <div class="post__loader">
                    <div class="loader__bar--1"></div>
                    <div class="loader__bar--2"></div>
                    <div class="loader__bar--3"></div>
                    <div class="loader__bar--4"></div>
                    <div class="loader__bar--5"></div>
                    <div class="loader__bar--6"></div>
                    <div class="loader__bar--7"></div>
                    <div class="loader__bar--8"></div>
                    <div class="loader__bar--9"></div>
                    <div class="loader__bar--10"></div>
                    <div class="loader__bar--11"></div>
                    <div class="loader__bar--12"></div>
                    </div>
                    </article>
                    <article class="fb-like-animation post--is-loading">
                    <div class="post__loader">
                    <div class="loader__bar--1"></div>
                    <div class="loader__bar--2"></div>
                    <div class="loader__bar--3"></div>
                    <div class="loader__bar--4"></div>
                    <div class="loader__bar--5"></div>
                    <div class="loader__bar--6"></div>
                    <div class="loader__bar--7"></div>
                    <div class="loader__bar--8"></div>
                    <div class="loader__bar--9"></div>
                    <div class="loader__bar--10"></div>
                    <div class="loader__bar--11"></div>
                    <div class="loader__bar--12"></div>
                    </div>
                    </article>
                    <article class="fb-like-animation post--is-loading">
                    <div class="post__loader">
                    <div class="loader__bar--1"></div>
                    <div class="loader__bar--2"></div>
                    <div class="loader__bar--3"></div>
                    <div class="loader__bar--4"></div>
                    <div class="loader__bar--5"></div>
                    <div class="loader__bar--6"></div>
                    <div class="loader__bar--7"></div>
                    <div class="loader__bar--8"></div>
                    <div class="loader__bar--9"></div>
                    <div class="loader__bar--10"></div>
                    <div class="loader__bar--11"></div>
                    <div class="loader__bar--12"></div>
                    </div>
                    </article>
                    <article class="fb-like-animation post--is-loading">
                    <div class="post__loader">
                    <div class="loader__bar--1"></div>
                    <div class="loader__bar--2"></div>
                    <div class="loader__bar--3"></div>
                    <div class="loader__bar--4"></div>
                    <div class="loader__bar--5"></div>
                    <div class="loader__bar--6"></div>
                    <div class="loader__bar--7"></div>
                    <div class="loader__bar--8"></div>
                    <div class="loader__bar--9"></div>
                    <div class="loader__bar--10"></div>
                    <div class="loader__bar--11"></div>
                    <div class="loader__bar--12"></div>
                    </div>
                    </article>
                    <article class="fb-like-animation post--is-loading">
                    <div class="post__loader">
                    <div class="loader__bar--1"></div>
                    <div class="loader__bar--2"></div>
                    <div class="loader__bar--3"></div>
                    <div class="loader__bar--4"></div>
                    <div class="loader__bar--5"></div>
                    <div class="loader__bar--6"></div>
                    <div class="loader__bar--7"></div>
                    <div class="loader__bar--8"></div>
                    <div class="loader__bar--9"></div>
                    <div class="loader__bar--10"></div>
                    <div class="loader__bar--11"></div>
                    <div class="loader__bar--12"></div>
                    </div>
                    </article>
                    </div>
                   <?php if(!empty(propertya_pagination_search($results))) { ?>
                     <div class="row">
                           <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 margin-bottom-30"> 
                             <div id="listing_ajax_pagination"><?php echo propertya_pagination_search($results); ?></div>
                          </div>
                     </div>
                  <?php } ?>				
           </div>
       </div>
        
        
    </div>
</div>