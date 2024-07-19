<?php
// Theme Typography Styling
if (!function_exists('propertya_typo'))
{
    function propertya_typo()
	{
		if ( ! class_exists( 'Redux' ) ) {
       		 return;
    	}
		$labelhex_code = $prop_label_label = $prop_label = $prop_status = $prop_status_label = ''; $active_clr  = $hover_clr   = $main_clr = $regular_clr = '';
		global $propertya_options;
		//theme primary color
        $main_clr = $propertya_options['prop_theme_clr'];
		//theme btn color
        $regular_clr = $propertya_options['prop_btn_plate']['regular'];
        $hover_clr   = $propertya_options['prop_btn_plate']['hover'];
        $active_clr  = $propertya_options['prop_btn_plate']['active'];
		// Property status color
		if(taxonomy_exists('property_status'))
		{
			$prop_status = get_terms( 'property_status' );
			if(is_array($prop_status) && count($prop_status) > 0)
			{
				foreach($prop_status as $term)
				{
					$term_id = $term->term_id;
					if(get_term_meta($term_id, 'status_title_color', true )!="")
					{
						$hex_code = get_term_meta($term_id, 'status_title_color', true );
						$prop_status_label .= "
						.badge-status-{$term_id} {
							background-color: {$hex_code};
						}";
					}
				}
			}
		}
		//top bars
		$top_1 = '';
		if($propertya_options['prop_show_topbar'] == true && isset($propertya_options['prop_topbar_style']) && $propertya_options['prop_topbar_style'] == 1)
		{
			$top_1= ".topbar-1 {
				background: {$propertya_options['prop_top_background']};
			}
			.topbar-1 ul li a{
				color: {$propertya_options['prop_top_nav_clr']};
			}
			.currency-dropdown .select2-container--classic .select2-selection--single .select2-selection__placeholder {
    			color: {$propertya_options['prop_top_nav_clr']};
            }
			.select2-container--classic .select2-selection--single .select2-selection__arrow b {
    			border-color: {$propertya_options['prop_top_nav_clr']} transparent transparent transparent;
			}";
		}
		// Property label texno
		if(taxonomy_exists('property_label'))
		{
			$prop_label = get_terms( 'property_label' );
			if(is_array($prop_label) && count($prop_label) > 0)
			{
				$term = '';
				foreach($prop_label as $term)
				{
					$term_id = $term->term_id;
					if(get_term_meta($term_id, 'labels_title_color', true )!="")
					{
						$labelhex_code = get_term_meta($term_id, 'labels_title_color', true );
						$prop_label_label .= "
						.badge-label-{$term_id} {
							background-color: {$labelhex_code};
						}";
					}
				}
			}
		}
		$trans_header = '';
		if(get_post_meta(get_the_ID(), 'show_trans_header', true )!="" && get_post_meta(get_the_ID(), 'primary_color', true )!="")
		{
			$color = get_post_meta(get_the_ID(), 'primary_color', true );
			$trans_header = ".sb-header.make-me-trans .sb-menu ul li a , .sb-header.nhome-3.make-me-trans .call-us .call-text p , .sb-header.nhome-3.make-me-trans .call-us .call-text h3 {
			color: {$color};}";
		}
        $body = '';
        if(is_rtl())
        {
            $body = 'body.rtl{
            font-family: "Tajawal", sans-serif;
            }';
        }
		
		$custom_css  = $body.$prop_label_label.$prop_status_label.$top_1.$trans_header."
			.full-brdc .newbrd ol li.clr-yal, .blog-read-more a, .blog-section-2 .blog-inner-box .blog-lower-box h2 a:hover, .blog-sidebar .widget ul li a:hover, .header-2 .sb-menu ul li.current-menu > a, .header-1 .sb-menu ul li:hover > a, .full-brdc .newbrd ol li a:hover,  blockquote::after, .ag-about .about-content .cal-action ul li i, .ag-about .about-content .cal-action ul li.border-li span , .clr-theme, .sec-heading p, .ag-about .about-content p.mytag, .ag-hero .search-data .search-box .search-inner label, .classic-search-bar  .search-inner label, .dark-footer .list li i , .card.ad-card-4 .list-inline .list-inline-item .clr-yal, .prop-location .clr-yal , .upper-contain .clr-yal , .w-exp .list-unstyled .list-inline-item .clr-blu , .property-data .text-inner p .clr-yal , .property-data .ul-text li a , .property-data .text-inner .main-reg-price , .cat-type-img .cat-type-title h4 a:hover , ul.category-list-data li a:hover, .card-agent-4 .card-body .card-title:hover, .card-agent-4 .card-body .agent-info ul li i, .card.agent-1 .clr-yal, .type-3-box a:hover, .clr-yal , .property-meta-relative .item-price , .card.ad-card-7 .property-meta-relative .item-price , .card.card-agent-2 .category , .packages-grid-content p , .packages-price{
    			color: {$main_clr} !important;
			}
			.homebg-top2 .nav-tabs .nav-link.active, .stv-radio-button:checked + label, .filters-nav li a.active-grid {
    			background:{$main_clr};
				border-color: {$main_clr};
			}
			
			.home-6-sec2 .pro-detail .icons {
				background:{$main_clr};
			}
			.no-container > .right-area > .inner-content .widget-inner-icon{
				background: {$main_clr}; 
				border: 1px solid {$main_clr};
			}
			.ag-about .about-content .cal-action ul li.border-li {
				border-left: 2px solid {$main_clr};
			}
			.ag-about .about-content .cal-action ul li.border-li span{
				border: 2px solid {$main_clr};
			}
			
			.home-6-sec2 .pro-detail {
				border-bottom: 3px solid {$main_clr};
			}
			
			.preloader-site .lds-ripple div {
    			border: 4px solid {$main_clr};
			}
			.heading-dots .h-dot.line-dot {
    			border-right: 40px solid {$main_clr};
			}
			.heading-dots .h-dot {
    			border-right: 3px solid {$main_clr};
			}
			
			.btn-face:hover, .btn-google:hover {
				border-color: {$regular_clr};
			}
          
			 .btn-theme, .realestate-search-blog .input-group .input-group-append .blog-search-btn, .page-item.active .page-link, .page-link:hover , .scroll-top, .modal-content .modal-from .modal-header , .walkscore-container .walkscore-score-div div , .agent-list1:hover .btn-light , .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button , .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt   {
				background: {$regular_clr}; 
				border: 1px solid {$regular_clr};
			 }
			 .btn-theme:focus, .btn-theme:hover , .btn-outline:hover, .header-1 .sb-menu > ul.auth-elements > li.submit-btn:last-child > a:hover , .scroll-top:hover ,  .nhome-3 .sb-menu > ul.auth-elements > li.submit-btn:last-child > a:hover , .woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover{
			    background-color: {$hover_clr};
				border-color: {$hover_clr};
			 }
			.btn-theme:active {
						  background-color: {$active_clr};
						
						  border-color: {$active_clr};
			}
			
			.btn-theme.btn-second {
				background-color: {$hover_clr};
				border-color: {$hover_clr};
			}
			
			.btn-theme.btn-second:hover {
				background: {$regular_clr}; 
				border: 1px solid {$regular_clr};
			}
			
			.ag-hero .search-data .search-box button , .classic-search-bar button , #breadcrumb-custom li a, #breadcrumb-custom li:nth-child(2n) a, .woocommerce .propertya-shop nav.woocommerce-pagination ul li a:focus, .woocommerce .propertya-shop nav.woocommerce-pagination ul li a:hover, .woocommerce .propertya-shop nav.woocommerce-pagination ul li span.current{
				background: {$regular_clr}; 
			}
			
			#breadcrumb-custom li:nth-child(even) a:before {
				border-color: {$regular_clr};
				border-left-color: transparent;
			}
			
			.ag-hero .search-data .search-box button:hover, .classic-search-bar button:hover {
				background: {$hover_clr}; 
			}
			
			.scrollprogress, .select2-container--classic .select2-results__option--highlighted[aria-selected], .property-detail-page  .flex-direction-nav a:hover , .walkscore-container .walkscore-score-div::after {
				background: {$regular_clr};	
			}
			.pretty input:checked ~ .state.p-primary label::after, .pretty.p-toggle .state.p-primary label::after, .featured-slider-prop .owl-nav .owl-next, .featured-slider-prop .owl-nav .owl-pre {
				background-color: {$regular_clr} !important;	
			}
#breadcrumb-custom li a::after {
 
    border-left-color: {$regular_clr};
}
";
		wp_add_inline_style('propertya-main', $custom_css);
	}
}
add_action('wp_enqueue_scripts', 'propertya_typo', 999);