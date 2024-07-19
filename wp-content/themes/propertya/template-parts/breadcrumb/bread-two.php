<?php 
	$localize = propertya_localization();
    global $propertya_options;
	if (propertya_strings('prop_lp_style') == 'elegent' || propertya_strings('prop_lp_style') == 'classic')
	if(is_singular('property-agency')  || is_singular( 'property-agents' ) || is_singular( 'property-buyers' ) || is_page_template('page-property-search.php') && !empty(propertya_strings('prop_listing_search_layout')) && propertya_strings('prop_listing_search_layout') == 'map' || is_page_template('page-property-search.php') && !empty(propertya_strings('prop_listing_search_layout')) && propertya_strings('prop_listing_search_layout') == 'modern')
	{}else
	{
        $bread_style = $bread_img = '';
        if (isset($propertya_options["brop_breadcrumb_img"]["url"]) && $propertya_options["brop_breadcrumb_img"]["url"] != "")
        {
            $bread_img = $propertya_options["brop_breadcrumb_img"]["url"];
            $bread_style =  'style="background-image:url('.$bread_img.')"';
        }
?>
<div class="clearfix"></div>
<div class="breadcroumb-area" <?php echo $bread_style; ?>>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcroumb-title text-center">
                    <h1><?php echo propertya_breadcrumb_function(); ?></h1>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
	}
    