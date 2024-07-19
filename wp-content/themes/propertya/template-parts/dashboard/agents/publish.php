<?php
	global $localization;
    $keyword = '';
	if(isset($_GET['keyword']) && $_GET['keyword'] !="")
	{
		$keyword = $_GET['keyword'];
	}
	$user_id = get_current_user_id();
?>
<div class="content-wrapper">
          <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
              <div class="card">
                <div class="admin-panel">
                	<form method="get" class="custom-style-search" action="<?php echo esc_url(get_the_permalink());?>?page-type=view-all-agents">
                    <input type="hidden" name="page-type" value="view-all-agents">
                      <div class="typeahead__container">
                        <div class="typeahead__field">
                            <div class="typeahead__query">
                                <input class="prop_agentz form-control for_dash" autocomplete="off" name="keyword" placeholder="<?php echo esc_attr($localization['search_agents']); ?>" value="<?php echo esc_attr($keyword);?>" type="search">
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
          <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title"><?php echo esc_html__('View All Agents','propertya'); ?></h4>
                  <?php
				  //pagination
				  $per_page = 12;
				  if(propertya_strings('prop_dash_agents') != "")
				  {
					$per_page = propertya_strings('prop_dash_agents'); 
				  }
				  $paged = 1;
                  $paged = (get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
				  $get_args = propertya_framework_fetch_my_agents($user_id,$paged, $per_page, $keyword);
				  $my_listings = new WP_Query($get_args);
                  if ( $my_listings->have_posts() )
                  {
				  ?>
                   <div class="row">
						<?php
                         while ($my_listings->have_posts())
                         {
                            $my_listings->the_post();
                            $agent_id	 =	get_the_ID();
							$user_id     =   get_post_field('post_author', $agent_id);
							$agent_mobile = esc_html__('N/A','propertya');
							if(get_post_meta($agent_id, 'agent_mobile',true ) !="")
							{
								$agent_mobile = get_post_meta($agent_id, 'agent_mobile',true);
							}
                            $owner = get_post_field( 'post_author', $agent_id );
                        ?>
                           <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                               <div class="agency_agents">
                                <ul class="icon">
                                    <li><a class="del-my-agent" href="javascript:void(0)" data-agent-id="<?php echo esc_attr($agent_id); ?>"><i class="la la-close"></i></a></li>
                                </ul>
                                <div class="agency_prof_img">
                                <a href="<?php echo esc_url(get_the_permalink($agent_id)); ?>"><?php echo propertya_framework_agent_feature_img($agent_id,'propertya-user-thumb');?></a>   
                                </div>
                                <div class="agency_agent_details">
                                    <h2 class="title"><a href="<?php echo esc_url(get_the_permalink($agent_id)); ?>"><?php echo get_the_title($agent_id); ?></a></h2>
                                    <?php
									$term = $agent_type = '';
									if(get_post_meta($agent_id, 'agent_type', true ) !="")
									{
										$agent_type =   get_post_meta($agent_id, 'agent_type', true );
										$term       =   get_term_by('slug', $agent_type, 'agent_types');
									?>	
                                    <span class="post text-warning"><?php echo esc_html($term->name); ?></span>
                                    <?php
									}
									?>
                                </div>
                                <ul class="agency_agent_details">
                                	<?php if(get_post_meta($agent_id, 'agent_email', true) !="") { ?>
                                    <li><span class="fas fa-envelope-open"></span> <?php echo get_post_meta($agent_id, 'agent_email', true); ?></li>
                                    <?php } ?>
                                    <li><span class="fas fa-mobile-alt"></span> <?php echo esc_html($agent_mobile); ?></li>
                                    <li><span class="fas fa-cog"></span> <?php echo wp_sprintf(esc_html__('Properties : %s', 'propertya'), propertya_count_listing($owner)) ?></li>
                                    <li><span class="fas fa-cog"></span><?php echo esc_html__('Allow Listings: ', 'propertya');
                                        $id = get_post_meta($agent_id, 'prop_user_id');
                                        $id = implode($id);
                                        $list = get_user_meta($id, 'prop_pack_totallistings');
                                        $list = implode($list);
                                        echo esc_html( $list); ?>
                                    </li>
                                </ul>
                            </div>
                           </div>
                         <?php
						 }
						 ?>
                   </div>
                   <?php
				   wp_reset_postdata();
				  }
				  else
				  {
					 get_template_part('template-parts/dashboard/agents/content', 'none'); 
				  }
				  ?>
                 <?php propertya_framework_prop_pagination($my_listings, true); ?>
                </div>
              </div>
            </div>
          </div>
        </div>