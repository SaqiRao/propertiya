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
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
              <div class="card">
              	<div class="card-body">
                    <div class="admin-panel">
                        <form id="se" method="get" class="custom-style-search" action="<?php echo esc_url(get_the_permalink());?>?page-type=pending">
                         <input type="hidden" name="page-type" value="draft">
                          <div class="typeahead__container">
                            <div class="typeahead__field">
                                <div class="typeahead__query">
                                    <input class="prop_get_propz form-control for_dash" autocomplete="off" name="keyword" placeholder="<?php echo esc_attr($localization['a_listing']); ?>" value="<?php echo esc_attr($keyword);?>" type="search">
                                </div>
                                <div class="typeahead__button">
                                    <button type="submit">
                                        <i class="typeahead__search-icon"></i>
                                    </button>
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
                  <h4 class="card-title"><?php echo esc_html($localization['pending']);?></h4>
				  <?php
                        //pagination
						$per_page = 10;
						if(propertya_strings('prop_dash_listings') != "")
						{
							$per_page = propertya_strings('prop_dash_listings'); 
						}
                        $paged = 1;
                        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
                        $get_args = propertya_framework_fetch_user_listings('draft',$owner_id,$paged, $per_page, $keyword);
						$edit_slug = esc_url(get_the_permalink().'?page-type=submit-property');
                        $my_listings = new WP_Query( $get_args );
                        if ( $my_listings->have_posts() )
                        {
                  ?>
                        <div id="warning-messages" class="alert custom-alert custom-alert--info margin-bottom-30" role="alert">
                            <div class="custom-alert__top-side">
                                <span class="alert-icon custom-alert__icon  far fa-edit "></span>
                                    <div class="custom-alert__body">
                                            <h6 class="custom-alert__heading">
                                                 <?php echo esc_html($localization['approval']);?>
                                            </h6>
                                            <div class="custom-alert__content">
                                                <?php echo esc_html($localization['approval_notify']);?>
                                            </div>
                                    </div>
                             </div>
                        </div>
                  		<div class="table-responsive custom-tabel-label">
                            <table class="custom-tabel table-hover">
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
								 while ( $my_listings->have_posts() )
								 {
									$my_listings->the_post();
									$property_id	=	get_the_ID();
									$all_idz = '';
									$all_idz = propertya_framework_fetch_gallery_idz($property_id);
								?>
                                <tr data-row-id="<?php echo esc_attr($property_id); ?>">
                                	<td>
                                     <span class="admin-listing-img">
                                         <a href="<?php echo esc_url(get_the_permalink($property_id)); ?>">
                                                <img class="img-responsive" src="<?php echo propertya_framework_img_src($all_idz,'thumbnail'); ?>" alt="<?php echo esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)); ?>"></a>
                                     </span>
                                    </td>
                                    <td><a href="<?php echo esc_url(get_the_permalink($property_id)); ?>"><span class="admin-listing-title"><?php echo get_the_title($property_id); ?></span><span class="admin-listing-date"><i class="la la-calendar-o"></i>
                                      <?php echo get_the_date(get_option('date_format'),$property_id);?></span></a>
                                    </td>
                                    <td><?php echo propertya_framework_selected_cat($property_id); ?></td>
                                    <td><?php echo propertya_framework_selected_price($property_id); ?></td>
                                    <td><?php echo propertya_framework_expiry_date_only($property_id); ?></td>
                                    <td class="text-right">
                                        <div class="listing-actions">
											<?php echo propertya_specific_listing_actions($property_id,'is_edit');?>
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