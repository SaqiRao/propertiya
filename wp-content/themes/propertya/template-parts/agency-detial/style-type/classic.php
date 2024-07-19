<?php
	global $propertya_options;
	$agency_id	=	get_the_ID();
	$author_id = get_post_field( 'post_author', $agency_id );
	//get properties
	$image_id = '';
	$comments = $agents = $propes = array();
	$paged = 1;
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$args	=	array
	(
		'post_type' => 'property',
		'author' => $author_id,
		'post_status' => 'publish',
		'posts_per_page' => 20,
        'fields' => 'ids',
		'paged' => $paged,
		'meta_key' => 'prop_is_feature_listing',
		'orderby'  => array(
			'meta_value_num' => 'DESC',
			'post_date'      => 'DESC',
		),
		'meta_query'    => array(
			array(
				'key'       => 'prop_status',
				'value'     => '1',
				'compare'   => '=',
			),
		),
		'order'=> 'DESC',
	);
	 $query = new WP_Query( $args );
	 if($query->have_posts())
	 {
		 while ($query->have_posts())
         {
				$query->the_post();
				$property_idz	=	get_the_ID();
				$propes[] .= $property_idz;
		 }
		 wp_reset_postdata();
	 }
	 
	 //agents
	 $agent_args	=	array
	 (
		'post_type' => 'property-agents',
		'posts_per_page' => '2',
		'paged' => '1',
		'order'=> 'DESC',
		'orderby' => 'date',
        'fields' => 'ids',
		'meta_key' => 'agent_agency_id',
		'meta_value' => $agency_id,
		'meta_query'    => array(
			array(
				'key'       => 'agent_status',
				'value'     => '1',
				'compare'   => '=',
			),
		),
	 );
	 $agent_query = new WP_Query($agent_args);
	 if($agent_query->have_posts())
	 {
		 while ($agent_query->have_posts())
		 {
			 $agent_query->the_post();
			 $agent_idz	=	get_the_ID();
			 $agents[] .= $agent_idz;
		 }
		 wp_reset_postdata();
	 }
	 //reviews
	 $no_off = 5;
	 if(!empty(propertya_strings('prop_review_limit')))
	 {
		$no_off = propertya_strings('prop_review_limit');
	 }
	 $comments = get_comments(array('post_id' => $agency_id, 'orderby' => 'post_date' ,'order' => 'DESC', 'post_type' => 'property-agency',  'status'  => 'approve','parent'=>0, 'number' => $no_off));
	 
$auth_status = '';	
$allowed_html = propertya_allowed_html(); 
if(get_post_meta($agency_id, 'agency_badge_txt', true ) !="" && get_post_meta($agency_id, 'agency_badge_clr', true )!="")
{
	$badge_txt = get_post_meta($agency_id, 'agency_badge_txt', true );
	$badge_clr = get_post_meta($agency_id, 'agency_badge_clr', true );
	$auth_status = '<span class="badge badge-verified" style="background-color:'.$badge_clr.'">'. esc_html($badge_txt).'</span>';
}
$is_featured = '';
if(get_post_meta($agency_id, 'agency_is_featured', true ) !="" && get_post_meta($agency_id, 'agency_is_featured', true )=="1")
{ 
   $is_featured = '<div class="featured-ribbon" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr__('Featured','propertya').'">
					<div><i class="fas fa-star"></i></div>
				</div>';
}
$reference = 'agency';
$type = 'property-agency';
$ratings = array();
$ratings = propertya_reviews_stats_average($agency_id,$type,$reference);
$cover_img = '';
$cover_img = propertya_placeholder_cover($agency_id);
$search_page_link = propertya_framework_get_link('page-property-search.php');
$author_id = get_post_field( 'post_author', $agency_id );
$auth_name = basename(get_permalink($agency_id));
?>
<div class="single-agency-agents">
<div class="agency-agent-classic" <?php echo ' '.$cover_img;  ?>>
  <div class="container">
    <div class="row page-section ag-short-detail">
      <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3 col-12">
        <div class="ag-logo">
        <div class="image-container">
       	   <?php 
              echo wp_kses($is_featured,$allowed_html);
           ?>
         <img src="<?php echo esc_url(propertya_placeholder_images('agency',$agency_id,'large')); ?>" class="img-fluid img-full" alt="<?php echo esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', TRUE)); ?>"/>
        </div> 
    </div>
      </div>
      <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
        <div class="short-detail d-flex flex-column justify-content-end"> 
		  <div class="d-flex flex-row">
		  <?php 
              echo wp_kses($auth_status,$allowed_html);
           ?>
          </div> 
          <div class="list-heading">
            <h1><?php echo get_the_title($agency_id); ?></h1>
          </div>
          <div class="m-listing-addr">
            <?php if(get_post_meta($agency_id, 'agency_street_addr', true )!="") { ?>
            <i class="fas fa-location-arrow clr-yal"></i> <?php echo esc_html(get_post_meta($agency_id, 'agency_street_addr', true )); ?> 
            <?php } ?>
            <?php if(get_post_meta($agency_id, 'agency_latt', true )!="" && get_post_meta($agency_id, 'agency_long', true )!="") { ?>
            <a class="m-listing-map" href="https://www.google.com/maps?daddr=<?php echo esc_attr(get_post_meta($agency_id, 'agency_latt', true )); ?>,<?php echo esc_attr(get_post_meta($agency_id, 'agency_long', true )); ?>" target="_blank"><?php echo esc_html__('Get Directions','propertya');?></a>
            <?php } ?>
          </div>
          <div class="list-meta">
            <ul>
            <?php if(get_post_meta($agency_id, 'agency_mobile', true )!="") { ?>
              <li  class="single-d-mobile"> <span class="list-posted-date"><i class="fas fa-phone-alt clr-yal"></i> <a class="click-reveal phonenumber" href="javascript:void(0)"><?php echo esc_html(get_post_meta($agency_id, 'agency_mobile', true )); ?></a></span> </li>
            <?php } ?>  
             <?php
			 if(!empty($ratings) && is_array($ratings) && $ratings['rated_no_of_times'] > 0) { ?>
              <li class="single-d-rating"> <span class="ratings"> <?php echo wp_kses($ratings['total_stars'],$allowed_html) ; ?> <i class="rating-counter"> <?php echo wp_sprintf(esc_html__('(%d Ratings)', 'propertya'), $ratings['rated_no_of_times']); ?> </i> </span> </li>
             <?php } ?>
             <?php
			 if(intval(get_post_meta($agency_id, 'prop_'.$reference.'_singletotal_views', true)!="")) { ?>
              <li class="list-meta-with-icons single-d-views"><?php echo esc_html__('Views','propertya'); ?> : <?php echo propertya_number_format_short(get_post_meta($agency_id, 'prop_'.$reference.'_singletotal_views', true));?></li>
             <?php } ?> 
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-12 col-lg-2 col-sm-12 col-xs-12 d-flex flex-column justify-content-end">
        <div class="margin-from-top-minimal">
          <a class="btn btn-theme btn-trans" href="<?php echo esc_url($search_page_link).'?property-author='.$author_id.''; ?>" target="_blank"> <?php echo esc_html__('View Listings','propertya'); ?></a>
         </div>
      </div>
    </div>
  </div>
</div>
<div class="agency-6">
  <div class="agt-8-taber">
    <div class="container">
      <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9 col-12">
          <div class="menu-des d-flex">
            <ul class="list-unstyled ssg">
             <?php if(!empty(get_the_content($agency_id)) && isset( $propertya_options['prop_ag_detail_sections']['enabled']) &&  !empty($propertya_options['prop_ag_detail_sections']['enabled']['over'])) { ?>
              <li class="list-inline-item"><a href="#p-overview" class="cl-class acmenu-pro-6"><?php echo propertya_strings('prop_settings_detail_sections'); ?></a></li>
             <?php } ?>  
             <?php if(!empty($propes) && is_array($propes) && count($propes) > 0 && isset( $propertya_options['prop_ag_detail_sections']['enabled']) &&  !empty($propertya_options['prop_ag_detail_sections']['enabled']['props']))  { ?>
              <li class="list-inline-item"><a href="#p-listings" class="cl-class"><?php echo propertya_strings('prop_settings_detail_menulistings'); ?></a></li>
              <?php } ?>
              <?php if(!empty($agents) && is_array($agents) && count($agents) > 0 && isset( $propertya_options['prop_ag_detail_sections']['enabled']) &&  !empty($propertya_options['prop_ag_detail_sections']['enabled']['agents']))  { ?>
              <li class="list-inline-item"><a href="#p-agents" class="cl-class"><?php echo propertya_strings('prop_settings_detail_menuagents'); ?></a></li>
              <?php } ?>
              <?php if(isset( $propertya_options['prop_ag_detail_sections']['enabled']) &&  !empty($propertya_options['prop_ag_detail_sections']['enabled']['views'])) { ?>
              <li class="list-inline-item"><a href="#p-views" class="cl-class"><?php echo propertya_strings('prop_settings_detail_menuviews'); ?></a></li>
               <?php } ?>
               <?php if(!empty($comments) && is_array($comments) && count($comments) > 0 && isset( $propertya_options['prop_ag_detail_sections']['enabled']) &&  !empty($propertya_options['prop_ag_detail_sections']['enabled']['review'])) { ?>
              <li class="list-inline-item"><a href="#p-reviews" class="cl-class"><?php echo propertya_strings('prop_settings_detail_menureviews'); ?></a></li>
               <?php } ?>
               <?php if(isset( $propertya_options['prop_ag_detail_sections']['enabled']) &&  !empty($propertya_options['prop_ag_detail_sections']['enabled']['write_review'])) { ?> 
              <li class="list-inline-item"><a href="#p-write-review" class="cl-class"><?php echo propertya_strings('prop_settings_detail_reviews_menuwrite'); ?></a></li>
              <?php } ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<section class="custom-padding">
    <div class="container">
        <div class="row">
             <div class="col-xl-8 col-lg-8 col-sm-12 col-md-12 col-12">
             <?php
				$layout = '';
				$layout = isset( $propertya_options['prop_ag_detail_sections']['enabled']) ? $propertya_options['prop_ag_detail_sections']['enabled'] : '';
				 if ($layout): foreach ($layout as $key => $value)
				 {
						set_query_var( 'propsingle-propes', $propes );
						set_query_var( 'propsingle-agents', $agents );
						set_query_var( 'propsingle-comments', $comments );
						switch ($key)
						{
							case 'over': get_template_part('template-parts/agency-detial/overview/overview');
							break;
							
							case 'props': get_template_part('template-parts/agency-detial/listings/properties');
							break;
							
							case 'agents': get_template_part('template-parts/agency-detial/agents/agents');
							break;
														
							case 'views': get_template_part('template-parts/agency-detial/views/views');
							break;
							
							case 'review': get_template_part('template-parts/generic-sections/reviews/reviews');
							break;
							
							case 'write_review': get_template_part('template-parts/generic-sections/reviews/form');
							break;
						}
				 }
				endif;
             ?> 
             </div>
             <div class="col-xl-4 col-lg-4 col-sm-12 col-md-12 col-12">
             	<div class="single-sidebar">
                <?php
				$sidebar_layout = '';
				$sidebar_layout = isset( $propertya_options['prop_ag_detail_sidebar_agency']['enabled']) ? $propertya_options['prop_ag_detail_sidebar_agency']['enabled'] : '';
				 if ($sidebar_layout): foreach ($sidebar_layout as $key => $value)
				 {
					switch ($key)
					{
						case 'info': get_template_part('template-parts/generic-sections/sidebar/info/info');
						break;
						
						case 'featured': get_template_part('template-parts/generic-sections/sidebar/featured/featured');
						break;
						
						case 'slot1': get_template_part('template-parts/generic-sections/sidebar/advertizment/advertizment1');
						break;
						
						case 'score': get_template_part('template-parts/generic-sections/sidebar/score/score');
						break;
						
						case 'contact': get_template_part('template-parts/generic-sections/sidebar/contact/contact');
						break;
													
						case 'most': get_template_part('template-parts/generic-sections/sidebar/most/most');
						break;
						
						case 'slot2': get_template_part('template-parts/generic-sections/sidebar/advertizment/advertizment2');
						break;
					}
				 }
				endif;
				 ?>
        		</div>
             </div>
        </div>
    </div>
</section>