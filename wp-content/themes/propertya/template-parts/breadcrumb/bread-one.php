<?php 
	$localize = propertya_localization();
	if (propertya_strings('prop_lp_style') == 'elegent' || propertya_strings('prop_lp_style') == 'classic')
	if(is_singular('property-agency')  || is_singular( 'property-agents' ) || is_singular( 'property-buyers' ) || is_page_template('page-property-search.php') && !empty(propertya_strings('prop_listing_search_layout')) && propertya_strings('prop_listing_search_layout') == 'map' || is_page_template('page-property-search.php') && !empty(propertya_strings('prop_listing_search_layout')) && propertya_strings('prop_listing_search_layout') == 'modern')
	{}else
	{
?>
<section class="full-brdc">
  <div class="container">
    <div class="col-xl-12 p-0">
      <nav aria-label="breadcrumb" class="newbrd">
        <ol class="breadcrumb px-0 mb-0">
          <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url( '/' )); ?>"><i class="fas fa-home"></i> <?php echo esc_attr($localize['home']); ?></a></li>
          <?php if( is_singular( 'property' ) )
		  {
			  $product_type = wp_get_object_terms(get_the_Id(),  'property_type' );
			if (!empty( $product_type ) )
			{
				if ( ! is_wp_error( $product_type ) )
				{
					foreach( $product_type as $term )
					{
						echo '<li class="breadcrumb-item " aria-current="page"><a href="' . esc_url( get_term_link( $term->slug, 'property_type' ) ) . '">' . esc_html( $term->name ) . '</a></li>'; 
					}
				}
			}
		  }
		  else
		  {
		  ?>	  
          <li class="breadcrumb-item clr-yal" aria-current="page"><?php echo propertya_breadcrumb_function(); ?></li>
          <?php
		  }
		  ?>
        </ol>
      </nav>
    </div>
  </div>
</section>
<?php
	}