<?php
if (!class_exists('propertya_get_agencies'))
{
	 class propertya_get_agencies 
	 {
		//Agency style 1
		function propertya_get_agencies_grid1($agency_id,$col_size = '')
		{
			if ($col_size == 3){$col_size = 'col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12';} 
			else if ($col_size == 2){$col_size = 'col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12';}
			else if ($col_size == 12){$col_size = 'col-xl-12 col-md-12 col-sm-12 col-12';}
			else {$col_size = 'col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12';}
			$ratings = array();
			$badge_html = $ang_status = $is_featured = '';
			$badge_clr = $badge_txt = $badge = $location =  $star_ratings = $badge_limit = ''; 
			$badge_limit = 0;
			$badge_limit = propertya_strings('prop_ag_recommended_badge');
			$allowed_html = propertya_allowed_html();
			//featured
			if(get_post_meta($agency_id, 'agency_is_featured', true ) =="1")
			{
				$ang_status = '<span class="theme-custom-ribbon"> '.esc_html__('Featured','propertya').' </span>';
			}
			//ratings
			$ratings = propertya_reviews_stats_average($agency_id,'property-agency','agency');
			if(!empty($ratings) && is_array($ratings) )
			{
				if($ratings['rated_no_of_times'] >= $badge_limit)
				{
				$badge_html = '<div class="is_agen_recommended"><button class="btn" type="button" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_html__('Most Recommended','propertya').'"><i class="fas fa-shield-alt"></i></button></div>';
				$star_ratings = '<span class="ratings">'.wp_kses($ratings['total_stars'],$allowed_html).'<span class="rating-avg">'.$ratings['total_average'].'</span></span>';
				}
				else
				{
					$star_ratings = '<span class="ratings">'.wp_kses($ratings['total_stars'],$allowed_html).'<span class="rating-avg">'.$ratings['total_average'].'</span></span>';
				}
			}
			
			//address
			if(get_post_meta($agency_id, 'agency_street_addr', true )!="")
			{
				$location = '<p><i class="fas fa-location-arrow clr-yal"></i> '.esc_html(get_post_meta($agency_id, 'agency_street_addr', true )).'</p>';
			}
			//badge text
			if(get_post_meta($agency_id, 'agency_badge_txt', true ) !="" && get_post_meta($agency_id, 'agency_badge_clr', true )!="")
			{
				$badge_txt = get_post_meta($agency_id, 'agency_badge_txt', true );
				$badge_clr = get_post_meta($agency_id, 'agency_badge_clr', true );
				$badge = '<div class="is_agen_trusted"><button class="btn" type="button" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr($badge_txt).'"><i class="fas fa-thumbs-up"></i></button></div>';
				
				//wp_kses($badge,$allowed_html);
			}
			return '<div class="'.esc_attr($col_size).' margin-bottom-30 grid-item">
            <div class="bg-autoh2 bgclr-white agnc bx-shadow2">
			'.wp_kses($ang_status,$allowed_html).'
			'.wp_kses($badge_html,$allowed_html).'
              <div class="upper-contain">
				<div class="agen-thumb-img">
					<a href="'.esc_url(get_the_permalink($agency_id)).'">'.propertya_responsive_images($agency_id,'propertya-user-thumb','agency').'</a>
				</div>
				<div class="all-content-area text-center">
				 <h2 class="m-2">
					<a class="clr-black" href="'.esc_url(get_the_permalink($agency_id)).'">'.propertya_title_limit(45,$agency_id).'</a>
				</h2>
				'.wp_kses($location,$allowed_html).'
				'.$star_ratings.'
				'.propertya_framework_themesocial_shares($agency_id,'agency').'
				</div>
              </div>
              <div class="agent-detail"> <a href="'.esc_url(get_the_permalink($agency_id)).'">'.esc_html__('View Profile','propertya').' </a> </div>
            </div>
          </div>';
		}
		
		//Agency style 2
		function propertya_get_agencies_grid2($agency_id,$col_size = '')
		{
			if ($col_size == 3){$col_size = 'col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12';} 
			else if ($col_size == 2){$col_size = 'col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12';}
			else if ($col_size == 12){$col_size = 'col-xl-12 col-md-12 col-sm-12 col-12';}
			else {$col_size = 'col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12';}
			$ratings = array();
			$badge_html = $ang_status = $is_featured = '';
			$image_id = $number = $email = $badge_clr = $badge_txt = $badge = $location =  $star_ratings = $badge_limit = ''; 
			$badge_limit = propertya_strings('prop_ag_recommended_badge');
			$allowed_html = propertya_allowed_html();
			//featured
			if(get_post_meta($agency_id, 'agency_is_featured', true ) =="1")
			{
				$ang_status = '<span class="theme-custom-ribbon"> '.esc_html__('Featured','propertya').' </span>';
			}
			//ratings
			$ratings = propertya_reviews_stats_average($agency_id,'property-agency','agency');
			if(!empty($ratings) && is_array($ratings) && !empty($badge_limit) && $ratings['rated_no_of_times'] >= $badge_limit)
			{
				$badge_html = '<div class="is_agen_recommended"><button class="btn" type="button" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr__('Most Recommended','propertya').'"><i class="fas fa-shield-alt"></i></button></div>';
			}
			//address
			if(get_post_meta($agency_id, 'agency_street_addr', true )!="")
			{
				$location = '<li><i class="fas fa-location-arrow clr-yal"></i> '.esc_html(get_post_meta($agency_id, 'agency_street_addr', true )).'</li>';
			}
			//email
			if(get_post_meta($agency_id, 'agency_email', true )!="")
			{
				$email = '<li><i class="fas fa-at clr-yal"></i> '.esc_html(get_post_meta($agency_id, 'agency_email', true )).'</li>';
			}
			//mobile number
			if(get_post_meta($agency_id, 'agency_mobile', true )!="")
			{
				$number = '<li><i class="fas fa-phone-alt clr-yal"></i>'.esc_html(get_post_meta($agency_id, 'agency_mobile', true )).'</li>';
			}
			//ratings
			$ratings = propertya_reviews_stats_average($agency_id,'property-agency','agency');
			if(!empty($ratings) && is_array($ratings))
			{
				$star_ratings = '<span class="ratings">'.wp_kses($ratings['total_stars'],$allowed_html).'<span class="rating-avg">'.$ratings['total_average'].'</span></span>';
			}
			
			return '<div class="'.esc_attr($col_size).' grid-item">
              <div class="card card-agent-4">
                <div class="card-body">
                  
                  '.wp_kses($badge_html,$allowed_html).'
                 <div class="author "> <a href="'.esc_url(get_the_permalink($agency_id)).'">'.propertya_responsive_images($agency_id,'propertya-user-thumb','agency','avatar img-raised').'</a> </div>
				 '.$star_ratings.'
				  <h2 class="card-title"> <a class="clr-black" href="'.esc_url(get_the_permalink($agency_id)).'">'.propertya_title_limit(45,$agency_id).'</a></h2>
                
                  <div class="agent-info">
                    <ul>
                      '.wp_kses($number,$allowed_html).'
                      '.wp_kses($email,$allowed_html).'
                    </ul>
                  </div>
                  <div class="card-footer d-flex align-items-center">
                    
                    <div class="agent-profile d-flex justify-content-end flex-fill "> <a href="'.esc_url(get_the_permalink($agency_id)).'" class="clr-black"> '.esc_html__('View Profile','propertya').'</a> </div>
                  </div>
                </div>
              </div>
            </div>';
		}
		
		//Agency style 3
		function propertya_get_agencies_grid3($agency_id,$col_size = '')
		{
			if ($col_size == 3){$col_size = 'col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12';} 
			else if ($col_size == 2){$col_size = 'col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12';}
			else if ($col_size == 12){$col_size = 'col-xl-12 col-md-12 col-sm-12 col-12';}
			else {$col_size = 'col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12';}
			$ratings = array();
			$badge_html = $ang_status = $is_featured = '';
			$image_id = $badge_clr = $badge_txt = $badge = $location =  $star_ratings = $badge_limit = ''; 
			$allowed_html = propertya_allowed_html();
			//featured
			if(get_post_meta($agency_id, 'agency_is_featured', true ) =="1")
			{
				$ang_status = '<span class="theme-custom-ribbon"> '.esc_html__('Featured','propertya').' </span>';
			}
			//ratings
			$ratings = propertya_reviews_stats_average($agency_id,'property-agency','agency');
			if(!empty($ratings) && is_array($ratings) && $ratings['rated_no_of_times'] >= $badge_limit)
			{
				$star_ratings = '<span class="ratings">'.wp_kses($ratings['total_stars'],$allowed_html).'<span class="rating-avg">'.$ratings['total_average'].'</span></span>';
			}
			
			$cover_img = '';
			$cover_img = propertya_placeholder_cover_thumbnail($agency_id,'propertya-background');
			return '<div class="'.esc_attr($col_size).' grid-item">
			<div class="card agen-cards">
			
			'.wp_kses($ang_status,$allowed_html).'
				<img src="'.esc_url($cover_img).'" alt="'.esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', TRUE)).'" class="card-img">
				<div class="agen-card-content">
					<div class="card-body d-flex justify-content-end">
						<div class="avatar-group d-flex">
							<div class="avatar avatar-xs">
								<a href="'.esc_url(get_the_permalink($agency_id)).'">
								'.propertya_responsive_images($agency_id,'propertya-user-thumb','agency','avatar-img rounded-circle').'
								</a>
							</div>
						</div>
					</div>
					<div class="agen-card-area card-body">
						<small class="d-flex">'.wp_sprintf(esc_html__('Views : %s', 'propertya'), propertya_number_format_short(get_post_meta($agency_id, 'prop_agency_singletotal_views', true))).'</small>
						'.$star_ratings.'
						<h4><a href="'.esc_url(get_the_permalink($agency_id)).'">'.propertya_title_limit(24,$agency_id).'</a></h4>
					</div>
				</div>
			</div></div>';
		}
		
		//Agency style 4
		function propertya_get_agencies_grid4($agency_id,$col_size = '')
		{
			if ($col_size == 3){$col_size = 'col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12';} 
			else if ($col_size == 2){$col_size = 'col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12';}
			else if ($col_size == 12){$col_size = 'col-xl-12 col-md-12 col-sm-12 col-12';}
			else {$col_size = 'col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12';}
			$badge_limit = $badge_html  = $ang_status = $location =  $star_ratings = '';
			$allowed_html = propertya_allowed_html();
			//ratings
			$ratings = propertya_reviews_stats_average($agency_id,'property-agency','agency');
			if(!empty($ratings) && is_array($ratings) && $ratings['rated_no_of_times'] > 0)
			{
				$star_ratings = '<span class="ratings">'.wp_kses($ratings['total_stars'],$allowed_html).'</span>';
			}
			//featured
			if(get_post_meta($agency_id, 'agency_is_featured', true ) =="1")
			{
				$ang_status = '<span class="theme-custom-ribbon"> '.esc_html__('Featured','propertya').' </span>';
			}
			
			//recommended
			$badge_limit = propertya_strings('prop_ag_recommended_badge');
			$recommended = propertya_reviews_stats_average($agency_id,'property-agency','agency');
			if(!empty($recommended) && is_array($recommended) && !empty($badge_limit) && $recommended['rated_no_of_times'] >= $badge_limit)
			{
				$badge_html = '<div class="is_agen_recommended"><button class="btn" type="button" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr__('Most Recommended','propertya').'"><i class="fas fa-shield-alt"></i></button></div>';
			}
			
			return '<div class="'.esc_attr($col_size).' grid-item">
						<div class="minimal-agency-company">
						'.wp_kses($ang_status,$allowed_html).'
						'.wp_kses($badge_html,$allowed_html).'
						 <div class="minimal-agen-logo">
							<a href="'.esc_url(get_the_permalink($agency_id)).'">'.propertya_responsive_images($agency_id,'full','agency').'</a>
						 </div>
						 <h3><a href="'.esc_url(get_the_permalink($agency_id)).'">'.propertya_title_limit(25,$agency_id).'</a></h3>
						 '.$star_ratings.'
						</div>
			</div>';
		}
		
		//Agency style 5
		function propertya_get_agencies_grid5($agency_id,$col_size = '')
		{
			if ($col_size == 3){$col_size = 'col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12';} 
			else if ($col_size == 2){$col_size = 'col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12';}
			else if ($col_size == 12){$col_size = 'col-xl-12 col-md-12 col-sm-12 col-12';}
			else {$col_size = 'col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12';}
			$badge_limit = $badge_html  = $ang_status = $location =  $star_ratings = '';
			$allowed_html = propertya_allowed_html();
			$owner = get_post_field( 'post_author', $agency_id );
			//ratings
			$ratings = propertya_reviews_stats_average($agency_id,'property-agency','agency');
			if(!empty($ratings) && is_array($ratings) && $ratings['rated_no_of_times'] >= $badge_limit)
			{
				$star_ratings = '<span class="ratings">'.wp_kses($ratings['total_stars'],$allowed_html).'<span class="rating-avg">'.$ratings['total_average'].'</span></span>';
			}
			//featured
			if(get_post_meta($agency_id, 'agency_is_featured', true ) =="1")
			{
				$ang_status = '<span class="theme-custom-ribbon"> '.esc_html__('Featured','propertya').' </span>';
			}
			
			//recommended
			$badge_limit = propertya_strings('prop_ag_recommended_badge');
			$recommended = propertya_reviews_stats_average($agency_id,'property-agency','agency');
			if(!empty($recommended) && is_array($recommended) && !empty($badge_limit) && $recommended['rated_no_of_times'] >= $badge_limit)
			{
				$badge_html = '<div class="is_agen_recommended"><button class="btn" type="button" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr__('Most Recommended','propertya').'"><i class="fas fa-shield-alt"></i></button></div>';
			}
			//address
			if(get_post_meta($agency_id, 'agency_street_addr', true )!="")
			{
				$location = '<p class="text-center"><i class="fas fa-location-arrow clr-yal"></i> '.esc_html(get_post_meta($agency_id, 'agency_street_addr', true )).'</p>';
			}
			
			return '<div class="'.esc_attr($col_size).' grid-item margin-bottom-30">
			<div class="iner-feature d-flex flex-column justify-content-center text-center">
		   <div class="iner-top">
			<div class="verify-btn">
			'.wp_kses($ang_status,$allowed_html).'
			<span class="p-btns">
				<span class="badge badge-success">'.wp_sprintf(esc_html__('%s Listings', 'propertya'),propertya_count_listing($owner)).'</span>
			</span>   
			<div class="agn-logo mx-auto">
				<a href="'.esc_url(get_the_permalink($agency_id)).'">
				'.propertya_responsive_images($agency_id,'propertya-user-thumb','agency','img-fluid rounded-circle').'
				</a>
			</div>   
			   
		   </div>
		   </div>	
		   <div class="agency-detail padding-top-80 padding-bottom-30">
		  '.$star_ratings.'
            '.wp_kses($location,$allowed_html).'
			<h3 class="text-center"><a class="clr-black" href="'.esc_url(get_the_permalink($agency_id)).'">'.propertya_title_limit(45,$agency_id).'</a></h3>
		  </div>	  
             <div class="detail-btn"><a href="'.esc_url(get_the_permalink($agency_id)).'">'.esc_html__('View Profile','propertya').' </a></div>	
		   </div> </div>';
		}
		
		//Agency style 6
		function propertya_get_agencies_grid6($agency_id,$col_size = '')
		{
			if ($col_size == 3){$col_size = 'col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12';} 
			else if ($col_size == 2){$col_size = 'col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12';}
			else if ($col_size == 12){$col_size = 'col-xl-12 col-md-12 col-sm-12 col-12';}
			else {$col_size = 'col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12';}
			$badge_limit = $badge_html  = $ang_status = $location =  $star_ratings = '';
			$allowed_html = propertya_allowed_html();
			$owner = get_post_field( 'post_author', $agency_id );
			//ratings
			$ratings = propertya_reviews_stats_average($agency_id,'property-agency','agency');
			if(!empty($ratings) && is_array($ratings) && $ratings['rated_no_of_times'] >= $badge_limit)
			{
				$star_ratings = '<span class="ratings">'.wp_kses($ratings['total_stars'],$allowed_html).'<span class="rating-avg">'.$ratings['total_average'].'</span></span>';
			}
			//featured
			if(get_post_meta($agency_id, 'agency_is_featured', true ) =="1")
			{
				$ang_status = '<span class="ageny-6-label">'.esc_html__('Featured','propertya').'</span>';
			}
			
			//recommended
			$badge_limit = propertya_strings('prop_ag_recommended_badge');
			$recommended = propertya_reviews_stats_average($agency_id,'property-agency','agency');
			if(!empty($recommended) && is_array($recommended) && !empty($badge_limit) && $recommended['rated_no_of_times'] >= $badge_limit)
			{
				$badge_html = '<div class="is_agen_recommended"><button class="btn" type="button" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr__('Most Recommended','propertya').'"><i class="fas fa-shield-alt"></i></button></div>';
			}
			//address
			if(get_post_meta($agency_id, 'agency_street_addr', true )!="")
			{
				$location = '<p class="text-center"><i class="fas fa-location-arrow clr-yal"></i> '.esc_html(get_post_meta($agency_id, 'agency_street_addr', true )).'</p>';
			}
			return '<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 grid-item">
                        <div class="agency-grid-6">
                            '.wp_kses($ang_status,$allowed_html).'
							'.wp_kses($badge_html,$allowed_html).'
                            <div class="agency-grid-6-img">
                               <a class="clr-black" href="'.esc_url(get_the_permalink($agency_id)).'"> '.propertya_responsive_images($agency_id,'thumbnail','agency','').'</a>
                            </div>
                            <div class="agency-grid-6-content">
                                <span class="agency-grid-6-properties">'.wp_sprintf(esc_html__('%s Listings', 'propertya'),propertya_count_listing($owner)).'</span>
                                <h3><a class="clr-black" href="'.esc_url(get_the_permalink($agency_id)).'">'.propertya_title_limit(25,$agency_id).'</a></h3>
                            </div>
                        </div>
                    </div>';
		}
		
		//Agency List style 1
		function propertya_get_agencies_list1($agency_id)
		{
			$owner = get_post_field( 'post_author', $agency_id );
			$ratings = array();
			$badge_limit = $badge_html  = $ang_status = $location =  $star_ratings = '';
			$allowed_html = propertya_allowed_html();
			//ratings
			$ratings = propertya_reviews_stats_average($agency_id,'property-agency','agency');
			if(!empty($ratings) && is_array($ratings) && $ratings['rated_no_of_times'] > 0)
			{
				$star_ratings = '<span class="ratings">'.wp_kses($ratings['total_stars'],$allowed_html).' &nbsp; '.wp_sprintf(esc_html__('(%s Reviews)', 'propertya'), $ratings['rated_no_of_times']).'</span>';
			}
			//featured
			if(get_post_meta($agency_id, 'agency_is_featured', true ) =="1")
			{
				$ang_status ='<div class="real-ribbon real-ribbon-top-right text-primary" data-toggle="tooltip" data-placement="top" data-original-title="'.esc_attr__('Featured','propertya').'"><span class="bg-featured"><i class="fas fa-fire"></i></span></div>';
			}
            $direction = 'mr-3';
            $direction_2 = 'mr-2';
            $direction_3 = 'mr-4';
            $margin = 'ml-auto';
			if(is_rtl())
            {
                $direction = 'ml-3';
                $direction_2 = 'ml-2';
                $direction_3 = 'mr-4';
                $margin = 'mr-auto';
            }
			return '<div class="col-12 col-xl-12 col-sm-12 col-lg-12 grid-item">
			  <div class="card align-self-center">
				<div class="d-flex justify-content-center card-body p-3 align-self-center agen-list-1">
				 '.wp_kses($ang_status,$allowed_html).'
				 
					<div class="agen-list-img-box '.esc_attr($direction).'"> 
					<a href="'.esc_url(get_the_permalink($agency_id)).'">'.propertya_responsive_images($agency_id,'full','agency','').'</a>
					</div>
				  <div class="align-self-center"> 
					<h4><a href="'.esc_url(get_the_permalink($agency_id)).'">'.propertya_title_limit(25,$agency_id).'</a></h4>
					  <div class="rating-stars-container '.esc_attr($direction_2).'">
						'.$star_ratings.' 
					  </div>
				  </div>
				  <div class="align-self-center '.esc_attr($margin).'"> <a class="btn btn-light '.esc_attr($direction_3).'" href="'.esc_url(get_the_permalink($agency_id)).'">'.wp_sprintf(esc_html__('%s Properties', 'propertya'), propertya_count_listing($owner)).'</a> </div>
				</div>
			  </div>
			</div>';
		}
		
		//Agency List style 2
		function propertya_get_agencies_list2($agency_id)
		{
			$owner = get_post_field( 'post_author', $agency_id );
			$ratings = array();
			$overview = $email = $number = $badge_limit = $badge_html  = $ang_status = $location =  $star_ratings = '';
			$allowed_html = propertya_allowed_html();
			//address
			if(get_post_meta($agency_id, 'agency_street_addr', true )!="")
			{
				$location = '<li>
					<i class="clr-yal fa fa-map-marker-alt primary-icon"></i>
					<p>'.esc_html(get_post_meta($agency_id, 'agency_street_addr', true )).'</p>
				</li>';
			}
			//mobile number
			if(get_post_meta($agency_id, 'agency_mobile', true )!="")
			{
				$number = '<li><i class="fas fa-phone-alt clr-yal"></i><p><span class="click-reveal phonenumber">'.esc_html(get_post_meta($agency_id, 'agency_mobile', true )).'</span></p></li>';
			}
			//email
			if(get_post_meta($agency_id, 'agency_email', true )!="")
			{
				$email = '<li>
					<i class="clr-yal fa fa-map-marker-alt"></i>
					<p>'.esc_html(get_post_meta($agency_id, 'agency_email', true )).'</p>
				</li>';
			}
			//featured
			if(get_post_meta($agency_id, 'agency_is_featured', true ) =="1")
			{
				$ang_status = '<span class="theme-custom-ribbon"> '.esc_html__('Featured','propertya').' </span>';
			}
			//listings
			$listing_count = '<li><i class="clr-yal fas fa-layer-group"></i>
			<p>'.wp_sprintf(esc_html__('Total Listings : %s ', 'propertya'), propertya_count_listing($owner)).'</p>
			</li>';
			
			return '<div class="col-lg-12 col-sm-12 col-xl-12 col-12 grid-item ">
			<div class="row no-gutters agen-list-2">
			'.wp_kses($ang_status,$allowed_html).'
			<div class="col-12 col-md-5 col-sm-12 align-self-center">
				<div class="agen-list-2-thumbnail">
								<a href="'.esc_url(get_the_permalink($agency_id)).'">'.propertya_responsive_images($agency_id,'full','agency').'</a>
							</div>
						</div>
						<div class="col-md-7 col-sm-10 ag-content-area">
								<h3><a href="'.esc_url(get_the_permalink($agency_id)).'">'.propertya_title_limit(35,$agency_id).'</a></h3>
							<p class="mb-2 mt-2">'.wp_trim_words(get_the_content(), 12, '...' ).'</p>
							<ul class="short-desc">
							    '.$listing_count .'
								'.wp_kses($number,$allowed_html).'
								'.wp_kses($location,$allowed_html).'
							</ul>
					</div>	
				</div>
			</div>';
		}
		
		//Agency List style 3
		function propertya_get_agencies_list3($agency_id)
		{
			$owner = get_post_field( 'post_author', $agency_id );
			$ratings = array();
			$hours = $whats = $fax = $office  = $overview = $email = $number = $badge_limit = $badge_html  = $ang_status = $location =  $star_ratings = '';
			$allowed_html = propertya_allowed_html();
			//address
			if(get_post_meta($agency_id, 'agency_street_addr', true )!="")
			{
				$location = '<div class="ag-loc">
					<i class="clr-yal fa fa-map-marker-alt primary-icon"></i>
					<p>'.esc_html(get_post_meta($agency_id, 'agency_street_addr', true )).'</p>
				</div>';
			}
			//mobile number
			if(get_post_meta($agency_id, 'agency_mobile', true )!="")
			{
				$number = '<li><strong>'.esc_html__('Mobile','propertya').' : </strong>'.esc_html(get_post_meta($agency_id, 'agency_mobile', true )).'</li>';
			}
			//email
			if(get_post_meta($agency_id, 'agency_email', true )!="")
			{
				
				$email ='<li><strong>'.esc_html__('Email','propertya').' : </strong>'.esc_html(get_post_meta($agency_id, 'agency_email', true )).'</li>';
				
			}
			//office number
			if(get_post_meta($agency_id, 'agency_office', true )!="")
			{
				
				$office ='<li><strong>'.esc_html__('Office','propertya').' : </strong>'.esc_html(get_post_meta($agency_id, 'agency_office', true )).'</li>';
				
			}
			//fax number
			if(get_post_meta($agency_id, 'agency_fax', true )!="")
			{
				
				$fax ='<li><strong>'.esc_html__('Fax','propertya').' : </strong>'.esc_html(get_post_meta($agency_id, 'agency_fax', true )).'</li>';
				
			}
			//Whatsapp number
			if(get_post_meta($agency_id, 'agency_whats', true )!="")
			{
				
				$whats ='<li><strong>'.esc_html__('WhatsApp','propertya').' : </strong>'.esc_html(get_post_meta($agency_id, 'agency_whats', true )).'</li>';
				
			}
			//Working Hours
			if(get_post_meta($agency_id, 'agency_hours', true )!="")
			{
				
				$hours ='<li><strong>'.esc_html__('Working Hours','propertya').' : </strong>'.esc_html(get_post_meta($agency_id, 'agency_hours', true )).'</li>';
				
			}
			//featured
			if(get_post_meta($agency_id, 'agency_is_featured', true ) =="1")
			{
				$ang_status = '<span class="theme-custom-ribbon"> '.esc_html__('Featured','propertya').' </span>';
			}
			//listings
			$listing_count = '<li><i class="clr-yal far fa-bullseye-arrow"></i>
			<p>'.wp_sprintf(esc_html__('Total Listings : %s ', 'propertya'), propertya_count_listing($owner)).'</p>
			</li>';
			
			return '<div class="col-lg-12 col-sm-12 col-xl-12 col-12 grid-item ">
			<div class="row no-gutters agen-list-3">
			'.wp_kses($ang_status,$allowed_html).'
			<div class="col-12 col-md-4 col-sm-12 ag-3-col d-flex justify-content-center">
				<div class="agen-list-3-thumbnail  ">
								<a href="'.esc_url(get_the_permalink($agency_id)).'">'.propertya_responsive_images($agency_id,'full','agency').'</a>
							</div>
						</div>
						<div class="col-md-8 col-sm-12 ag-content-area">
								<h3><a href="'.esc_url(get_the_permalink($agency_id)).'">'.propertya_title_limit(35,$agency_id).'</a></h3>
								'.wp_kses($location,$allowed_html).'
							<p class="mb-2 mt-2">'.wp_trim_words(get_the_content(), 12, '...' ).'</p>
							<ul class="list-unstyled">
							  '.wp_kses($office,$allowed_html).'
							  '.wp_kses($number,$allowed_html).'
							  '.wp_kses($fax,$allowed_html).'
							  '.wp_kses($whats,$allowed_html).'
							  '.wp_kses($email,$allowed_html).'	
							  '.wp_kses($hours,$allowed_html).'	
                    		</ul>
					</div>	
				</div>
			</div>';
			
		}
		
	
		//Trusted Agencies
		function propertya_get_trusted_agencies($agency_id)
		{
			$owner = get_post_field( 'post_author', $agency_id );
			return '<li class="list-group-item">
				<div class="avatar avatar-online">
				<a href="'.esc_url(get_the_permalink($agency_id)).'">'.propertya_responsive_images($agency_id,'propertya-user-thumb','agency').'</a>
				</div>
				<div class="list-body">
				  <h6><a href="'.esc_url(get_the_permalink($agency_id)).'">'.propertya_title_limit(24,$agency_id).'</a></h6>
					<div class="list-meta">
					 <ul>
						<li class="list-meta-with-icons single-d-views">'.wp_sprintf(esc_html__('Listings : %s', 'propertya'), propertya_count_listing($owner)).'</li>
						<li class="list-meta-with-icons single-d-views">'.wp_sprintf(esc_html__('Views : %s', 'propertya'), propertya_number_format_short(get_post_meta($agency_id, 'prop_agency_singletotal_views', true))).' </li>
					 </ul>
					</div>
				</div>
			  </li>';
		}
		
		
		//Most Viewed Agencies
		function propertya_get_most_viewed_agencies($agency_id)
		{
			$ratings = array();
			$badge_html = $ang_status = $is_featured = '';
			$image_id = $badge_clr = $badge_txt = $badge = $location =  $star_ratings = $badge_limit = ''; 
			$allowed_html = propertya_allowed_html();
			//featured
			if(get_post_meta($agency_id, 'agency_is_featured', true ) =="1")
			{
				$ang_status = '<span class="theme-custom-ribbon"> '.esc_html__('Featured','propertya').' </span>';
			}
			//ratings
			$ratings = propertya_reviews_stats_average($agency_id,'property-agency','agency');
			if(!empty($ratings) && is_array($ratings) && $ratings['rated_no_of_times'] >= $badge_limit)
			{
				$star_ratings = '<span class="ratings">'.wp_kses($ratings['total_stars'],$allowed_html).'<span class="rating-avg">'.$ratings['total_average'].'</span></span>';
			}
			
			$cover_img = '';
			$cover_img = propertya_placeholder_cover_thumbnail($agency_id,'propertya-background');
			return '<div class="card agen-cards">
			'.wp_kses($ang_status,$allowed_html).'
				<img src="'.esc_url($cover_img).'" alt="'.esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', TRUE)).'" class="card-img">
				<div class="agen-card-content">
					<div class="card-body d-flex justify-content-end">
						<div class="avatar-group d-flex">
							<div class="avatar avatar-xs">
								<a href="'.esc_url(get_the_permalink($agency_id)).'">
								'.propertya_responsive_images($agency_id,'propertya-user-thumb','agency','avatar-img rounded-circle').'
								</a>
							</div>
						</div>
					</div>
					<div class="agen-card-area card-body">
						<small class="d-flex">'.wp_sprintf(esc_html__('Views : %s', 'propertya'), propertya_number_format_short(get_post_meta($agency_id, 'prop_agency_singletotal_views', true))).'</small>
						'.$star_ratings.'
						<h4><a href="'.esc_url(get_the_permalink($agency_id)).'">'.propertya_title_limit(24,$agency_id).'</a></h4>
					</div>
				</div>
			</div>';
		}
	 }
}