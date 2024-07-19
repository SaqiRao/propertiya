<?php
	global $localization;
    $owner_id = $user_id = $author_id = $keyword = '';
	if(isset($_GET['keyword']) && $_GET['keyword'] !="")
	{
		$keyword = $_GET['keyword'];
	}
	$user_id = get_current_user_id();
	if(get_user_meta( $user_id, 'prop_post_id', true) !="" && get_user_meta($user_id, 'user_role_type', true) !="")
	{
		$author_id = get_user_meta( $user_id, 'prop_post_id' , true );
		$owner_id = get_post_field( 'post_author', $author_id );
	}
?>
<div class="content-wrapper">

        <div class="row">
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12 col-12">
                <div class="dashboard-statistic-block">
                    <div class="icon gradient-1">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div>
                        <h5><?php echo esc_html($localization['total_published']);?></h5>
                        <h2><?php echo esc_html(sprintf('%02d', propertya_count_total_properties($owner_id, 'publish'))); ?></h2>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12 col-12">
                <div class="dashboard-statistic-block">
                    <div class="icon gradient-9">
                       <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div>
                        <h5><?php echo esc_html($localization['total_pending']);?></h5>
                        <h2><?php echo esc_html(sprintf('%02d', propertya_count_total_properties($owner_id, 'draft'))); ?></h2>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12 col-12">
                <div class="dashboard-statistic-block">
                    <div class="icon gradient-4">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <div>
                        <h5><?php echo esc_html($localization['total_featured']);?></h5>
                        <h2><?php echo esc_html(sprintf('%02d', propertya_count_total_properties($owner_id, 'publish','is_featured'))); ?></h2>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12 col-12">
                <div class="dashboard-statistic-block">
                    <div class="icon gradient-5">
                        <i class="fas fa-recycle"></i>
                    </div>
                    <div>
                        <h5><?php echo esc_html($localization['total_expired']);?></h5>
                        <h2><?php echo esc_html(sprintf('%02d', propertya_count_total_properties($owner_id, 'expired'))); ?></h2>
                    </div>
                </div>
            </div>
        </div>
              
          <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
              <div class="card">
                <div class="card-body">
                <div class="admin-panel">
                	<form id="se" method="get" class="custom-style-search" action="<?php echo esc_url(get_the_permalink());?>?page-type=publish">
                     <input type="hidden" name="page-type" value="publish">
                      <div class="typeahead__container">
                        <div class="typeahead__field">
                            <div class="typeahead__query">
                                <input class="prop_get_propz form-control for_dash" autocomplete="off" name="keyword" placeholder="<?php echo esc_attr($localization['a_listing']); ?>" value="<?php echo esc_attr($keyword);?>" type="search">
                            </div>
                        </div>
                      </div>
                    </form>  
                </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title"><?php echo esc_html($localization['featured']);?></h4>
				  <?php
                        //pagination
						$per_page = 10;
						if(propertya_strings('prop_dash_listings') != "")
						{
							$per_page = propertya_strings('prop_dash_listings'); 
						}
                        $paged = 1;
                        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
                        $get_args = propertya_framework_fetch_user_listings('publish',$owner_id,$paged, $per_page, $keyword,true);
                        $my_listings = new WP_Query( $get_args );
                        if ( $my_listings->have_posts() )
                        {
                  ?>
                  		<div class="table-responsive custom-tabel-label">
                            <table class="custom-tabel">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th><?php echo esc_html($localization['listing']);?></th>
                                        <th><?php echo esc_html($localization['listed_in']);?></th>
                                        <th><?php echo esc_html($localization['price']);?></th>
                                        <th><?php echo esc_html($localization['my_expiry']);?></th>
                                        <th><?php echo esc_html($localization['action']);?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $user_id = get_current_user_id();
                                $listing_expiry = get_user_meta($user_id, 'prop_pack_simple_expiry_for', true);
                                 $next_due_date = date('d/m/Y', strtotime("+$listing_expiry days"));
								 while ( $my_listings->have_posts() )
								 {
									$my_listings->the_post();
									$property_id	=	get_the_ID();
									$all_idz = '';
									$all_idz = propertya_framework_fetch_gallery_idz($property_id);
								?>
                                <tr id="<?php echo esc_attr($property_id); ?>" data-row-id="<?php echo esc_attr($property_id); ?>">
                                	<td>
                                     <span class="admin-listing-img">
                                         <a href="<?php echo esc_url(get_the_permalink($property_id)); ?>">
                                                <img class="img-responsive" src="<?php echo propertya_framework_img_src($all_idz,'thumbnail'); ?>" alt="<?php echo esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)); ?>"></a>
                                     </span>
                                    </td>
                                    <td><a href="<?php echo esc_url(get_the_permalink($property_id)); ?>"><span class="admin-listing-title"><?php echo get_the_title($property_id); ?> </span><span class="text-warnings admin-listing-date">
                                      <?php echo get_the_date(get_option('date_format'),$property_id);?></span></a> 
                                    
                                     <?php if (get_post_meta($property_id, 'prop_is_feature_listing', true ) == "1") { ?>
                                      <span class="paid-btnz">
                                          <div class="circle-featured-border"></div> <span><?php echo esc_html__('Featured','propertya'); ?></span>
                                      </span>
                                     <?php } ?>
                                    </td>
                                    <td><?php echo propertya_framework_selected_cat($property_id); ?></td>
                                    <td><?php echo propertya_framework_selected_price($property_id); ?></td>
                                    <td><?php echo  get_post_meta($property_id, 'prop_expired',  true); ?></td>
                                    <td class="text-right">
                                        <div class="listing-actions">
											<?php echo propertya_specific_listing_actions($property_id);?>
                                        </div>       
                                    </td>
                                </tr>
                                <?php
								 }
								  wp_reset_postdata();
								?>
                              </tbody>
                            </table>
                       </div>
                  <?php
						}
						else
						{
							get_template_part('template-parts/dashboard/my-properties/content', 'none'); 
						}
				   ?>
                   <?php propertya_framework_prop_pagination($my_listings, true); ?>
                </div>
              </div>
            </div>
          </div>
        </div>