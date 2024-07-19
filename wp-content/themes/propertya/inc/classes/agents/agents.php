<?php
if (!class_exists('propertya_get_agents'))
{
	 class propertya_get_agents 
	 {
		//Agents Type 1
		function propertya_get_agents_type1($agent_id,$col_size = '')
		{
			if ($col_size == 3){$col_size = 'col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12';} 
			else if ($col_size == 4){$col_size = 'col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12';}
			else if ($col_size == 2){$col_size = 'col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12';}
			else if ($col_size == 12){$col_size = 'col-xl-12 col-md-12 col-sm-12 col-12';}
			else {$col_size = 'col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12';}
			$labels_html = $auth_status =  $badge_clr = $badge_txt = $my_type = $ang_status = $star_ratings = $email = $mobile =  $img_id = '';
			$ratings = array();
			$owner = get_post_field( 'post_author', $agent_id );
			$allowed_html = propertya_allowed_html();
			//contact no
			if(get_post_meta($agent_id, 'agent_mobile',true ) !="")
			{
				$mobile = '<div class="widget-inner-elements">
						<div class="widget-inner-icon"> <i class="fas fa-phone-alt"></i> </div>
						
						<div class="widget-inner-text"><a class="click-reveal phonenumber" href="tel:'.esc_attr(get_post_meta($agent_id, 'agent_mobile',true )).'" data-reaction="contact"> '.esc_attr(get_post_meta($agent_id, 'agent_mobile',true )).'</a></div>
					  </div>';
			}
			if(get_post_meta($agent_id, 'agent_email',true ) !="")
			{
				$email = '<div class="widget-inner-elements">
						<div class="widget-inner-icon"> <i class="fas fa-at"></i> </div>
						<div class="widget-inner-text">'.esc_attr(get_post_meta($agent_id, 'agent_email',true )).'</div>
					  </div>';
			}
			//ratings
			$ratings = propertya_reviews_stats_average($agent_id,'property-agents','agent');
			if(!empty($ratings) && is_array($ratings) && $ratings['rated_no_of_times'] > 0)
			{
				$star_ratings = '<div class="ratings">'.wp_kses($ratings['total_stars'],$allowed_html).'</div>';
			}
			//featured
			if(get_post_meta($agent_id, 'agent_is_featured', true ) =="1")
			{
				$ang_status = '<span class="theme-custom-ribbon"> '.esc_html__('Featured','propertya').' </span>';
			}
			//agent type
			if(get_post_meta($agent_id, 'agent_type', true ) !="")
			{
				
				$color = '';
				$agent_type =   get_post_meta($agent_id, 'agent_type', true );
				$term       =   get_term_by('slug', $agent_type, 'agent_types');
				if(get_term_meta( $term->term_id, 'agent_type_title_color', true ) !="")
				{
					$color = get_term_meta($term->term_id, 'agent_type_title_color', true );
				}
				$my_type    = '<span class="badge badge-agent-type" style="background-color:'.$color.'">'. esc_html($term->name).'</span>';
			}
			//trusted
			if(get_post_meta($agent_id, 'agent_is_trusted', true ) == "1" && get_post_meta($agent_id, 'agent_badge_txt', true ) !="" && get_post_meta($agent_id, 'agent_badge_clr', true )!="")
			{
				$badge_txt = get_post_meta($agent_id, 'agent_badge_txt', true );
				$badge_clr = get_post_meta($agent_id, 'agent_badge_clr', true );
				$auth_status = '<span class="badge badge-verified" style="background-color:'.$badge_clr.'">'. esc_html($badge_txt).'</span>';
			}
			if(!empty($auth_status) || !empty($my_type))
			{
				$labels_html = '<div class="d-flex flex-row agent-type">
				'.wp_kses($auth_status,$allowed_html).'
				'.wp_kses($my_type,$allowed_html).'
				</div>';	
			}
			return '<div class="'.esc_attr($col_size).' grid-item">
			<div class="card agent-1">
              <div class="card-image">
			  '.wp_kses($ang_status,$allowed_html).'
			  '.$labels_html.'
			  <a href="'.esc_url(get_the_permalink($agent_id)).'">
			  '.propertya_responsive_images($agent_id,'large','agent').'
			  </a> 
			  </div>
              <div class="card-body">
                <h2 class="card-title"> <a  class="clr-black" href="'.esc_url(get_the_permalink($agent_id)).'">'.propertya_title_limit(25,$agent_id).'</a> </h2>
                <span class="clr-yal">'.wp_sprintf(esc_html__('%s Properties', 'propertya'), propertya_count_listing($owner)).'</span>
                <div class="dropdown-divider"></div>
				<div class="agent-short-details">
					'.$mobile.'
					'.$email.' 
				</div>	
              </div>
            </div>
			</div>';
		}
		
		//Agents Type 2
		function propertya_get_agents_type2($agent_id,$col_size = '')
		{
			if ($col_size == 3){$col_size = 'col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12';} 
			else if ($col_size == 4){$col_size = 'col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12';}
			else if ($col_size == 2){$col_size = 'col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12';}
			else if ($col_size == 12){$col_size = 'col-xl-12 col-md-12 col-sm-12 col-12';}
			else {$col_size = 'col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12';}
			
			$agent_type =   get_post_meta($agent_id, 'agent_type', true );
			$term       =   get_term_by('slug', $agent_type, 'agent_types');
			$tw = $pin = $insta = $in = $tw = $fb = '';
			$fb = get_post_meta($agent_id, 'agent_fb', true );
			$tw = get_post_meta($agent_id, 'agent_tw', true );
			$in = get_post_meta($agent_id, 'agent_in', true );
		    $insta = get_post_meta($agent_id, 'agent_insta', true );
			$pin = get_post_meta($agent_id, 'agent_pin', true );
			if(!empty($fb))
			{
				$fb_link = '<li><a target="_blank" href="'.esc_url($fb).'"><i class="fab fa-facebook-f"></i></a></li>';
			}
			if(!empty($tw))
			{
				$tw_link = '<li><a target="_blank" href="'.esc_url($tw).'"><i class=" fab fa-twitter"></i></a></li>';
			}
			if(!empty($in))
			{
				$in_lin = '<li><a target="_blank" href="'.esc_url($in).'"><i class="fab fa-linkedin-in"></i></a></li>';
			}
			if(!empty($insta))
			{
				$insta_link = '<li><a target="_blank" href="'.esc_url($insta).'"><i class=" fab fa-instagram"></i></a></li>';
			}
			if(!empty($pin))
			{
				$pin_link ='<li><a target="_blank" href="'.esc_url($pin).'"><i class=" fab fa-pinterest-p"></i></a></li>';
			}
			$social_links = ''; 
			if(!empty($fb) || !empty($tw) || !empty($in) || !empty($insta) || !empty($pin))
			{
				$social_links = '<ul class="listing-owner-social">
				'.$fb_link.'
						'.$tw_link.'
						'.$in_lin.'
						'.$insta_link.'
						'.$pin_link.'
				</ul>';
			}
			
			return '<div class="'.esc_attr($col_size).' grid-item">
								<div class="card card-agent-2">
									<div class="card-image">
										<a href="'.esc_url(get_the_permalink($agent_id)).'">
			  								'.propertya_responsive_images($agent_id,'large','agent').'
			 							 </a>
									</div>
									<div class="card-body">
									<h6 class="category text-warning">'. esc_html($term->name).'</h6>
										<h5 class="card-title">
                                 			<a class="clr-black" href="'.esc_url(get_the_permalink($agent_id)).'">'.propertya_title_limit(25,$agent_id).'</a>
                            			</h5>
                            			'.$social_links.'
									</div>
								</div>
							</div>';
		}
		
		//Agents Type 2
		function propertya_get_agents_list1($agent_id,$col_size = '')
		{
			//address
			$location ='';
			if(get_post_meta($agent_id, 'agent_street_addr', true )!="")
			{
				$location = '<div class="agents-info"><span><i class="fas fa-location-arrow clr-yal"></i> '.esc_html(get_post_meta($agent_id, 'agent_street_addr', true )).'</span></div>';
			}
			//featured
			$ang_status = '';
			if(get_post_meta($agent_id, 'agent_is_featured', true ) =="1")
			{
				$ang_status ='<div class="real-ribbon real-ribbon-top-right text-primary" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr__('Featured','propertya').'"><span class="bg-featured"><i class="fas fa-fire"></i></span></div>';
			}
			$allowed_html = propertya_allowed_html();
			return '<div class="col-xl-12 col-lg-12 col-12 grid-item">
			<div class="agent-list1">
				'.wp_kses($ang_status,$allowed_html).'
                    <div class="thumb">
                      <a href="'.esc_url(get_the_permalink($agent_id)).'">
                        '.propertya_responsive_images($agent_id,'propertya-user-thumb','agent').'
                      </a>
                    </div>
                    <div class="agent-list1-area">
                      <div class="content">
                        <h4><a  class="clr-black" href="'.esc_url(get_the_permalink($agent_id)).'">'.propertya_title_limit(35,$agent_id).'</a></h4>
					 '.wp_kses($location,$allowed_html).'
                        
                      </div>
                      <div class="button-area">
                        <a class="btn btn-light" href="'.esc_url(get_the_permalink($agent_id)).'">View Details</a>
                      </div>
                    </div>
                  </div></div>';
				  
		}
		
	 }
}