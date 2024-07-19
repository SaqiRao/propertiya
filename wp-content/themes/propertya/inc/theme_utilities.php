<?php
// Submit Form Fields
if( !function_exists('propertya_breadcrumb') )
{
    function propertya_breadcrumb()
	{
        global $propertya_options;
		if(get_post_meta( get_the_ID(), 'show_page_bread', true )=="checked"){}else{
            $bread_type = 'one';
            if(isset($propertya_options['prop_selected_bread']) && $propertya_options['prop_selected_bread'] !="")
            {
                $bread_type = $propertya_options['prop_selected_bread'];
            }
            get_template_part( 'template-parts/breadcrumb/bread',$bread_type);
		}
    }
}

// Breadcrumb
if ( ! function_exists( 'propertya_breadcrumb_function' ) )
{	
	function propertya_breadcrumb_function()
	{
		global $propertya_options;
		
	 if(isset($propertya_options['prop_blog_post_title']) && $propertya_options['prop_blog_post_title'] !=""){
			$blog_title = $propertya_options['prop_blog_post_title'];
		}
		$string = '';
        
		if (is_category() ) 
		{
			$string =  esc_html__( 'Category', 'propertya' );	
		}
		else if( is_singular( 'property' ) )
		{
			$string	=	esc_html__( 'Listing Details', 'propertya' );	
		}
        
		else if (is_single()) 
		{
			$string =  esc_html__('Blog Details', 'propertya' );
		}
		elseif (is_page())
		{
			$string =   esc_html( get_the_title() );
		}
        
		elseif (is_tag())
		{
			$string =    esc_html( single_tag_title( "", false ) );
		}
		elseif (is_search()) 
		{
			$string =  esc_html( get_search_query() );	 
		}
		elseif (is_404()) 
		{
			$string =  esc_html__('Page not Found', 'propertya' ); 
		}
		elseif (is_author()) 
		{
			$string .=  esc_html__('Author', 'propertya' ); 
		}
        
		else if( is_tax() )
		{
			$string	=  esc_html( single_cat_title( "", false ) ); 
		}
		elseif (is_archive()) 
		{
			     $string =  esc_html__('Archive', 'propertya' ); 
		}
		else if( is_home() )
		{
			$string	=	 esc_html__($blog_title);	
		}
        if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))))
        {
            if( is_singular( 'product' ) )
            {
                $string	=	esc_html__( 'Product Details', 'propertya' );	
            }
            else if( is_cart() )
            {
                $string	=	esc_html__( 'Cart', 'propertya' );	
            }
            else if( is_checkout() )
            {
                $string	=	esc_html__( 'Checkout', 'propertya' );	
            }
            else if( is_product_category() )
            {
                 $string	=  esc_html( single_cat_title( "", false ) ); 
            }
            elseif (is_product_tag())
            {
                $string =    esc_html( single_tag_title( "", false ) );
            }
            else if( is_shop() )
            {
                 $string	=	 esc_html__( 'Shop', 'propertya' );	
            }
        }
		return $string;
	}
}

// Pagination
if ( ! function_exists( 'propertya_pagination' ) )
{
	function propertya_pagination($pages = '', $range = 2)
	{
		global $localization;
		if( is_singular() )
		return;
		$showitems = '';
		$showitems = ($range * 2) + 1;  
		global $paged;
		if(empty($paged)) $paged = 1;
		if($pages == '')
		{
			global $wp_query; 
			$pages = $wp_query->max_num_pages;
		
			if(!$pages)
				$pages = 1;		 
		}   
		if(1 != $pages)
		{
			echo '<div class="row">
        	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 margin-bottom-30">
			<nav><ul class="pagination justify-content-start">
			<li class="page-item disabled hidden-md-down d-none d-lg-block"><span class="page-link">'.$localization['page'].' '.$paged.' '.$localization['off'].' '.$pages.'</span></li>';
			 if (get_previous_posts_link())
			 {
				 get_previous_posts_link();
			 }
			for ($i=1; $i <= $pages; $i++)
			{
				if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
				{
					echo esc_html(($paged == $i))? '<li class="page-item active"><span class="page-link"><span class="sr-only"> '.esc_html($localization['page']).' </span>'.esc_html($i).'</span></li>' : '<li class="page-item"><a class="page-link" href="'.esc_url(get_pagenum_link($i)).'"><span class="sr-only">'.esc_html($localization['page']).' </span>'.esc_html($i).'</a></li>';
				}
			}
			echo '</ul></nav>
			</div>
        </div>';
		}
	}
}
// Redirect safe URL
if( !function_exists('propertya_redirect_url') )
{
    function propertya_redirect_url($url)
	{
		return '<script>window.location = "' . esc_url($url) .  '";</script>';	
	}
}
// get feature image
if ( ! function_exists( 'propertya_blogfeatured_img' ) )
{	
	function propertya_blogfeatured_img($post_id, $image_size )
	{
		return wp_get_attachment_image_src( get_post_thumbnail_id( esc_html( $post_id ) ), $image_size );	
	}
}

// get feature image
if ( ! function_exists( 'propertya_blogcomments_count' ) )
{	
	function propertya_blogcomments_count()
	{
		$num_comments = '';
		if ( comments_open() )
		{
			$num_comments = get_comments_number();
			if ( $num_comments == 0 ) 
			{
				$comments = esc_html__('No Comments','propertya');
			}
			elseif ( $num_comments > 1 ) {
				$comments = $num_comments . esc_html__(' Comments','propertya');
			}
			else {
				$comments = esc_html__('1 Comment','propertya');
			}
			return $comments;
		} 
	}
}


 // Modifying search form
add_filter('get_search_form', 'propertya_blog_search_form');
if ( ! function_exists( 'propertya_blog_search_form' ) ) 
{	
	function propertya_blog_search_form($text)
	{
		
		$text = str_replace('<label>', '<div class="realestate-search-blog"><div class="input-group stylish-input-group">', $text);
		$text = str_replace('</label>', '<span class="input-group-append"><button class="blog-search-btn" type="submit">  <i class="fa fa-search"></i> </button></span></div></div>', $text);
		$text = str_replace('<span class="screen-reader-text">'.esc_html__('Search for:','propertya').'</span>', '', $text);
		$text = str_replace('class="search-field"', 'class="form-control"', $text);
		return $text;	
	}
}
 // make URL
if (!function_exists('propertya_make_link'))
{
    function propertya_make_link($url, $text)
	{
        return wp_kses("<a href='" . esc_url($url) . "' target='_blank'>", propertya_required_tags()) . $text . wp_kses('</a>', propertya_required_tags());
    }
}

// Header logged in & profile
if( !function_exists('propertya_auth_settings') )
{
    function propertya_auth_settings()
	{
		if(propertya_strings('prop_enable_registration') == true)
		{
			$local = propertya_localization();
			$signuplink = propertya_framework_get_link('page-signup.php');
			$signinlink = propertya_framework_get_link('page-signin.php');
			if (is_user_logged_in())
			{
				$image_id = '';
				$dashboard_page = '#';
				$dashboard_page = propertya_framework_get_link('page-dashboard.php');
				$type = '';
				$user_id = get_current_user_id();
				if(get_user_meta($user_id, 'user_role_type', true) !="")
				{
					$type = get_user_meta($user_id, 'user_role_type', true);	
				}
				$post_id = '';
				if(get_user_meta( $user_id, 'prop_post_id' , true ) !="")
				{
				    $post_id = get_user_meta( $user_id, 'prop_post_id' , true);
				}
				
				return '<li class="user-avatar-dp"><a class="aft-logged" href="javascript:void(0)" ><img src="'.esc_url(propertya_placeholder_images($type,$post_id,'propertya-user-thumb')).'" class="img-fluid" alt="'.esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', TRUE)).'"></a>
                      <ul class="my-custom-auth">
                        <li><a href="'.esc_url($dashboard_page).'"><i class="fas fa-home menu-icon"></i>'. $local['dashboard'].'</a></li>
                        <li><a href="'.esc_url($dashboard_page.'?page-type=my-profile').'"><i class="fas fa-user-circle"></i>'.esc_attr($local['profile']).'</a></li>
                        <li><a href="'.esc_url($dashboard_page.'?page-type=publish').'"><i class="fas fa-list"></i>'.esc_attr($local['my_properties']).'</a></li>
                        <li><a href="' . wp_logout_url(home_url('/')) . '"><i class="fas fa-sign-out-alt"></i>'.esc_attr($local['logout']).'</a></li>
                      </ul>
                    </li>';
			}
			else
			{
				return '<li class="user-avatar show-on-click"><a class="my-auth" href="javascript:void(0)" ><i class="fas fa-user"></i></a>
					<div class="auth-dropdown">
					  <div class="user-menu--dropdown">
							<div class="user-menu">
							  <div class="user-menu__signin-area">
								<div class="user-menu__title-text">'.esc_html__('Sign in or register to sync your favorite properties across devices','propertya').'</div>
								<a class=" btn btn-theme btn-block" href="'.esc_url($signinlink).'">'.esc_html__('Sign In','propertya').'</a>
								<div class="user-menu__new-account"><a href="'.esc_url($signuplink).'">'.esc_html__('Create new account','propertya').'</a></div>
							  </div>
							</div>
					  </div>
					</div>
				</li>';
			}
		}
	}
}
// Check Restricted Pages
if( !function_exists('propertya_restricted_pages') )
{
	function propertya_restricted_pages()
	{
		if (is_user_logged_in() && !current_user_can('administrator') && !( defined('DOING_AJAX') && DOING_AJAX ))
		{
			$redirect = add_query_arg('authorization', 'restricted', home_url('/'));
			wp_redirect( $redirect );
		}
	}
}
// Check Restricted Pages
if( !function_exists('propertya_check_auth') )
{
	function propertya_check_auth()
	{
		if (!is_user_logged_in() && !( defined('DOING_AJAX') && DOING_AJAX ))
		{
			$redirect = add_query_arg('authorization', 'restricted', home_url('/'));
			wp_redirect( $redirect );
			exit;
		}
	}
}

// Get Agents of Agency
if( !function_exists('propertya_get_agent_agency') )
{
	function propertya_get_agent_agency($user_id)
	{
		$get_args = propertya_framework_fetch_my_agents($user_id,'1', '', '');
		 $my_listings = new WP_Query($get_args);
		  $options = '';
		  if ( $my_listings->have_posts() )
		  {
			  $options = '';
			  while ($my_listings->have_posts())
			  {
					$my_listings->the_post();
					$agent_id	 =	get_the_ID();
					$user_id     =  get_post_field('post_author', $agent_id);
					$options .= '<option value="'.esc_attr($agent_id).'">'.get_the_title($agent_id).'</option>';
					
			  }
			wp_reset_postdata();  
		  }
		  return $options;
	}
}
//get term id form slug
if ( ! function_exists( 'propertya_get_term' ) )
{
	function propertya_get_term($slug,$taxnomy_name)
	{
		if(!empty($slug) && !empty($taxnomy_name))
		{
			return get_term_by( 'slug', $slug, $taxnomy_name);
		}
	}
}
//Property Views Single 
add_action('wp', 'propertya_count_property_views', 10);
if ( ! function_exists('propertya_count_property_views'))
{
	function propertya_count_property_views()
	{
		if (get_post_type(get_the_ID()) == 'property' && is_singular('property'))
		{	
			$property_id = get_the_ID();
			//daily count total
			if(intval(get_post_meta($property_id, 'prop_listing_total_views', true)!=""))
			{
				$view_count = get_post_meta($property_id, 'prop_listing_total_views', true);
				$view_count =  $view_count + 1;
				update_post_meta( $property_id, 'prop_listing_total_views', $view_count );
			}
			else
			{
				$view_count = 1;
				update_post_meta( $property_id, 'prop_listing_total_views', $view_count );
			}
			//stats
			$current_day =  date('Y-m-d',current_time('timestamp', 0));
			$count_by_date = get_post_meta($property_id, 'prop_listing_count_by_date', true);
			if($count_by_date =='' || !is_array($count_by_date))
			{
				$count_by_date         =   array();
				$count_by_date[$current_day] =   1;
			}
			else
			{
				if( !isset($count_by_date[$current_day] ) )
				{
					if( count($count_by_date) > 20 )
					{
						array_shift($count_by_date);
					}
					$count_by_date[$current_day]=1;
				}
				else
				{
					$count_by_date[$current_day]=intval($count_by_date[$current_day])+1;
				}
			}
			update_post_meta($property_id, 'prop_listing_count_by_date', $count_by_date);
		}
	}
}

//Fetch data for charts
if( !function_exists('propertya_chart_labels') )
{
    function propertya_chart_labels($property_id, $is_values = false,$cpt_type = '')
	{
		global $propertya_options;
		$get_array_keys = array();
		$result = array();
		if(empty($cpt_type))
		{
			$views_by_date = get_post_meta($property_id, 'prop_listing_count_by_date', true);
		}
		else
		{
			$views_by_date = get_post_meta($property_id, 'prop_'.$cpt_type.'_count_by_date', true);
		}
		if(!empty($views_by_date) && is_array($views_by_date) && count($views_by_date) > 0)
		{
			$days_to_show = 20;
			if(isset($propertya_options['prop_stats_days']) && $propertya_options['prop_stats_days'] !="")
			{
				$days_to_show = $propertya_options['prop_stats_days'];
			}
			if($is_values == true)
			{
				//get array values
				$get_array_keys = array_values($views_by_date);
			}
			else
			{
				//get array keys
				$get_array_keys = array_keys($views_by_date);
			}
			//get number of results to show from last
			$result = array_slice($get_array_keys, -1 * $days_to_show, $days_to_show, false);
			return json_encode($result);
		}
		else
		{
			return json_encode($result);
		}
	}
}

//Fetch time hours
if( !function_exists('propertya_fetch_hours') )
{
    function propertya_fetch_hours($lower = 0, $upper = 86400, $step = 3600, $format = '' )
	{
		$times = array();
		if ( empty( $format ) ) {
			$format = 'g:i a';
		}
		foreach ( range( $lower, $upper, $step ) as $increment ) {
			$increment = gmdate( 'H:i', $increment );
	
			list( $hour, $minutes ) = explode( ':', $increment );
	
			$date = new DateTime( $hour . ':' . $minutes );
	
			$times[(string) $increment] = $date->format( $format );
		}
		return $times;
	}
}

if( !function_exists('propertya_timeago') )
{
	function propertya_timeago($comment_id = 0)
	{
		return sprintf( 
			_x( '%s ago', 'Human-readable time', 'propertya' ), 
			human_time_diff( 
				get_comment_date( 'U', $comment_id ), 
				current_time( 'timestamp' ) 
			) 
		);
	}
}
// get user registration date.
if( !function_exists('propertya_user_timeago') )
{
	function propertya_user_timeago($post_author_id)
	{
		return sprintf( 
			_x( '%s', 'Human-readable time', 'propertya' ), 
			human_time_diff( 
				strtotime(get_userdata($post_author_id)->user_registered), 
				current_time( 'timestamp' ) 
			) 
		);
	}
}
// get post description as per need. 
if( !function_exists('propertya_title_limit') )
{
	function propertya_title_limit($length = 30,$title_id ='')
	{
        $string = '';
		$mytitle = get_the_title($title_id);
        $contents = strip_tags(html_entity_decode($mytitle, ENT_QUOTES, "UTF-8"));
        $removeSpaces = str_replace(" ", "", $contents);
        $contents = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $contents);
        if (strlen($removeSpaces) > $length)
		{
            return mb_substr(str_replace("&nbsp;", "", $contents), 0, $length) . '...';
        } else {
            return str_replace("&nbsp;", "", $contents);
        }
    }
}
// Locations Trims. 
if( !function_exists('propertya_trim_locations') )
{
	function propertya_trim_locations($length = 20,$location='')
	{
        $string = '';
		$mytitle = $location;
        $contents = strip_tags(html_entity_decode($mytitle, ENT_QUOTES, "UTF-8"));
        $removeSpaces = str_replace(" ", "", $contents);
        $contents = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $contents);
        if (strlen($removeSpaces) > $length)
		{
            return mb_substr(str_replace("&nbsp;", "", $contents), 0, $length) . '...';
        } else {
            return str_replace("&nbsp;", "", $contents);
        }
    }
}
// Clean Titles. 
if( !function_exists('propertya_clean_titles') )
{
	function propertya_clean_titles($title_id)
	{
		$mytitle = $title_id;
        $contents = strip_tags(html_entity_decode($mytitle, ENT_QUOTES, "UTF-8"));
        $removeSpaces = str_replace(" ", "", $contents);
        $contents = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $contents);
		return  $contents;
	}
}


// get post description as per need. 
if( !function_exists('propertya_allowed_html') )
{
	function propertya_allowed_html()
	{
	
		$allowed_tags = array(
			'a' => array(
				'class' => array(),
				'href'  => array(),
				'rel'   => array(),
				'title' => array(),
			),
			
			'abbr' => array(
				'title' => array(),
			),
			'b' => array(),
			'blockquote' => array(
				'cite'  => array(),
			),
			'cite' => array(
				'title' => array(),
			),
			
			'code' => array(),
			'del' => array(
				'datetime' => array(),
				'title' => array(),
			),
			'button' => array(
				'class' => array(),
				'title' => array(),
				'style' => array(),
				'data-toggle' => array(),
				'data-placement' => array(),
				'data-original-title' => array(),
			),
			'dd' => array(),
			'div' => array(
				'class' => array(),
				'title' => array(),
				'style' => array(),
				'data-toggle' => array(),
				'data-placement' => array(),
				'data-original-title' => array(),
				
			),
			'dl' => array(),
			'dt' => array(),
			'em' => array(),
			'h1' => array(),
			'h2' => array(),
			'h3' => array(),
			'h4' => array(),
			'h5' => array(),
			'h6' => array(),
			'i' => array(),
			'img' => array(
				'alt'    => array(),
				'class'  => array(),
				'height' => array(),
				'src'    => array(),
				'width'  => array(),
			),
			'li' => array(
				'class' => array(),
				'href'  => array(),
			),
			'data-*' => array(
				'toggle' => array(),
			),
			'i' => array(
				'class' => array(),
			),
			'ol' => array(
				'class' => array(),
			),
			'p' => array(
				'class' => array(),
			),
			'q' => array(
				'cite' => array(),
				'title' => array(),
			),
			'span' => array(
				'class' => array(),
				'title' => array(),
				'style' => array(),
			),
			'strike' => array(),
			'strong' => array(),
			'ul' => array(
				'class' => array(),
			),
		);
		return $allowed_tags;
	}
}
// get post description as per need. 
if( !function_exists('propertya_min_max_latt_long') )
{
	function propertya_min_max_latt_long($data_arr)
	{
		$nearby_data = array();
		$distance = $original_long = $original_lat = '';
		if(!empty($data_arr))
		{
			$search_radius_type = 'km';
			$nearby_data = $data_arr;
			$original_lat = $nearby_data['latitude'];
			$original_long = $nearby_data['longitude'];
			$distance = intval($nearby_data['distance']);
			if ($search_radius_type == 'mile' && $distance > 0)
			{
                $distance = $distance * 1.609344;
            }
			$lat = $original_lat;
			$lon = $original_long;
			$distance = ($distance);
			$R = 6371;
			
			$maxLat = $lat + rad2deg($distance / $R);
            $minLat = $lat - rad2deg($distance / $R);
			
			$maxLon = $lon + rad2deg(asin($distance / $R) / @abs(@cos(deg2rad($lat))));
            $minLon = $lon - rad2deg(asin($distance / $R) / @abs(@cos(deg2rad($lat))));
			
			$data['radius'] = $R;
			$data['distance'] = $distance;
			$data['lat']['original'] = $original_lat;
			$data['long']['original'] = $original_long;
			
			$data['lat']['min'] = $minLat;
			$data['lat']['max'] = $maxLat;
			
			$data['long']['min'] = $minLon;
			$data['long']['max'] = $maxLon;
			return $data;
		}
	}
}

// Defualt Image. 
if (!function_exists('propertya_defualt_img_url'))
{
    function propertya_defualt_img_url()
	{
        global $propertya_options;

        if (isset($propertya_options['prop_defualt_listing_image']['url']) && $propertya_options['prop_defualt_listing_image']['url'] != "")
		{
           return $propertya_options['prop_defualt_listing_image']['url'];
		  
        } 
		else
		{
            return trailingslashit(get_template_directory_uri()) . 'libs/images/no-image.png';
        }
    }
}


//Property Views Multipost types 
add_action('wp', 'propertya_count_views_multi_type', 10);
if ( ! function_exists('propertya_count_views_multi_type'))
{
	function propertya_count_views_multi_type($type)
	{
		if (get_post_type(get_the_ID()) == 'property-agency' && is_singular('property-agency') || get_post_type(get_the_ID()) == 'property-agents' && is_singular('property-agents') || get_post_type(get_the_ID()) == 'property-buyers' && is_singular('property-buyers'))
		{
			$type =  get_post_type(get_the_ID());
			$post_id = get_the_ID();
			if(get_post_type(get_the_ID()) == 'property-agency' && is_singular('property-agency'))
			{
				$key = 'agency';
			}
			if(get_post_type(get_the_ID()) == 'property-agents' && is_singular('property-agents'))
			{
				$key = 'agent';
			}
			if(get_post_type(get_the_ID()) == 'property-buyers' && is_singular('property-buyers'))
			{
				$key = 'buyer';
			}
			//daily count total
			if(intval(get_post_meta($post_id, 'prop_'.$key.'_singletotal_views', true)!=""))
			{
				$view_count = get_post_meta($post_id, 'prop_'.$key.'_singletotal_views', true);
				$view_count =  $view_count + 1;
				update_post_meta( $post_id, 'prop_'.$key.'_singletotal_views', $view_count );
			}
			else
			{
				$view_count = 1;
				update_post_meta( $post_id, 'prop_'.$key.'_singletotal_views', $view_count );
			}
			//stats
			$current_day =  date('Y-m-d',current_time('timestamp', 0));
			$count_by_date = get_post_meta($post_id, 'prop_'.$key.'_count_by_date', true);
			if($count_by_date =='' || !is_array($count_by_date))
			{
				$count_by_date         =   array();
				$count_by_date[$current_day] =   1;
			}
			else
			{
				if( !isset($count_by_date[$current_day] ) )
				{
					if( count($count_by_date) > 20 )
					{
						array_shift($count_by_date);
					}
					$count_by_date[$current_day]=1;
				}
				else
				{
					$count_by_date[$current_day]=intval($count_by_date[$current_day])+1;
				}
			}
			update_post_meta($post_id, 'prop_'.$key.'_count_by_date', $count_by_date);
		}
	}
}

//Get Object Terms
if (!function_exists('propertya_getselected_locations'))
{
	function propertya_getselected_locations($id, $by = 'name')
	{
		$taxonomy = 'property_location';
		$terms = wp_get_post_terms($id, $taxonomy);
		$all_locations = array();
		$myparentID = '';
		foreach ($terms as $term) {
			if ($term->parent == 0) {
				$myparent = $term;
				$myparentID = $myparent->term_id;
				$all_locations[] = array('name' => $myparent->name, 'id' => $myparent->term_id);
				break;
			}
		}
	
		if ($myparentID != "")
		{
			$mychildID = '';
			foreach ($terms as $term) {
				if ($term->parent == $myparentID)
				{ 
					$child_term = $term; 
					$mychildID = $child_term->term_id;
					$all_locations[] = array('name' => $child_term->name, 'id' => $child_term->term_id);
					break;
				}
			}
			if ($mychildID != "") {
				$mychildchildID = '';
				foreach ($terms as $term) {
					if ($term->parent == $mychildID) { 
						$child_term = $term;
						$mychildchildID = $child_term->term_id;
						$all_locations[] = array('name' => $child_term->name, 'id' => $child_term->term_id);
						break;
					}
				}
				if ($mychildchildID != "") {
					foreach ($terms as $term) {
						if ($term->parent == $mychildchildID) { 
							$child_term = $term;
							$all_locations[] = array('name' => $child_term->name, 'id' => $child_term->term_id);
							break;
						}
					}
				}
			}
		}
		//return $locs;
		$location_html = '';
		if(get_post_meta($id, 'prop_street_addr', true )!="")
		{
			$location_html .= '<li><div class="widget-inner-icon"> <i class="fas fa-map-marker-alt"></i> </div><span> '.esc_html__('Address','propertya').' : </span> '.get_post_meta($id, 'prop_street_addr', true ).' </li>';
		}
		$asd = array(0=>propertya_strings('prop_loc_level1'),1=>propertya_strings('prop_loc_level2'),2=>propertya_strings('prop_loc_level3'),3=>propertya_strings('prop_loc_level4'));
		$icons = array(0=>'<i class="fas fa-globe-americas"></i>',1=>'<i class="fas fa-location-arrow"></i>',2=>'<i class="fas fa-building"></i>',3=>'<i class="fas fa-street-view"></i>');
		if (count($all_locations) > 0)
		{
			$limit = count((array) $all_locations) - 1;
			for ($i = $limit; $i >= 0; $i--)
			{
				$location_html .= '<li><div class="widget-inner-icon">'.$icons[$i].'</div><span> '.$asd[$i].' :</span> <a href="' . esc_url(get_term_link($all_locations[$i]['id'],'property_location')) . '">' . esc_html($all_locations[$i]['name']) . '</a></li>';
			}
		}
		return $location_html;
	}
}

//Ajax based pagination
//Ajax based pagination
if (!function_exists('propertya_pagination_search'))
{
	function propertya_pagination_search($wp_query, $page = 0)
	{
		if ($wp_query->found_posts > 1) {
			$limit = $total_pages = '';
			$limit = get_option('posts_per_page');
			
			$total_pages = $wp_query->found_posts;
			
			$stages = 3;
			$page = $page;
			if ($page) {
				$start = ($page - 1) * $limit;
			} else {
				$start = 0;
			}
			
			// Initial page num setup
			if ($page == 0) {
				$page = 1;
			}
			$prev = $page - 1;
			$next = $page + 1;

			$lastpage = ceil($total_pages / $limit);
			$LastPagem1 = $lastpage - 1;

			$paginate = '';
			if ($lastpage > 1) {
				
				$paginate .= ' <ul class="pagination justify-content-start">';
				// Previous
				if ($page > 1) {
					
					$paginate .= '<li class="page-item fetch_result" data-page-no="' . $prev . '"><a class="page-link" href="javascript:void(0)">' . esc_html__('Previous', 'propertya') . '</a></li>';
				} else {
					
					$paginate .= '<li class="page-item disabled"><a href="javascript:void(0)" class="page-link" aria-label="' . esc_html__('Previous', 'propertya') . '"><span aria-hidden="true">' . esc_html__('Previous', 'propertya') . '</span></a></li>';
				}

				// Pages
				if ($lastpage < 7 + ($stages * 2)) { // Not enough pages to breaking it up
					for ($counter = 1; $counter <= $lastpage; $counter++) {
						if ($counter == $page) {
							$paginate .= '<li class="page-item fetch_result active" data-page-no=' . $counter . '><a href="javascript:void(0)" class="page-link">' . $counter . '</a></li>';
						} else {
							$paginate .= '<li class="page-item fetch_result" data-page-no=' . $counter . '><a href="javascript:void(0)" class="page-link">' . $counter . '</a></li>';
						}
					}
				} elseif ($lastpage > 5 + ($stages * 2)) { // Enough pages to hide a few?
					// Beginning only hide later pages
					if ($page < 1 + ($stages * 2)) {
						for ($counter = 1; $counter < 4 + ($stages * 2); $counter++) {
							if ($counter == $page) {
								$paginate .= '<li class="page-item fetch_result active" data-page-no=' . $counter . '><a href="javascript:void(0)" class="page-link">' . $counter . '</a></li>';
							} else {
								$paginate .= '<li class="page-item fetch_result" data-page-no=' . $counter . '><a href="javascript:void(0)" class="page-link">' . $counter . '</a></li>';
							}
						}
						$paginate .= '<li class="page-item disabled"><a href="javascript:void(0)" class="page-link">...</a></li>';
						$paginate .= '<li class="page-item fetch_result" data-page-no=' . $LastPagem1 . '><a href="javascript:void(0)" class="page-link">' . $LastPagem1 . '</a></li>';
						$paginate .= '<li class="page-item fetch_result" data-page-no=' . $lastpage . '><a href="javascript:void(0)" class="page-link">' . $lastpage . '</a></li>';
					}
					// Middle hide some front and some back
					elseif ($lastpage - ($stages * 2) > $page && $page > ($stages * 2)) {

						$paginate .= '<li class="page-item fetch_result" data-page-no="1"><a href="javascript:void(0)" class="page-link">1</a></li>';
						$paginate .= '<li class="page-item fetch_result" data-page-no="2"><a href="javascript:void(0)" class="page-link">2</a></li>';
						$paginate .= '<li class="page-item disabled"><a href="javascript:void(0)" class="page-link">...</a></li>';
						//$paginate.= "...";
						for ($counter = $page - $stages; $counter <= $page + $stages; $counter++) {
							if ($counter == $page) {
								$paginate .= '<li class="page-item fetch_result active" data-page-no=' . $counter . '><a href="javascript:void(0)" class="page-link">' . $counter . '</a></li>';
							} else {
								$paginate .= '<li class="page-item fetch_result" data-page-no=' . $counter . '><a href="javascript:void(0)" class="page-link">' . $counter . '</a></li>';
							}
						}
						//$paginate.= "...";
						$paginate .= '<li class="page-item disabled"><a href="javascript:void(0)" class="page-link">...</a></li>';
						$paginate .= '<li class="page-item fetch_result" data-page-no=' . $LastPagem1 . '><a href="javascript:void(0)" class="page-link">' . $LastPagem1 . '</a></li>';
						$paginate .= '<li class="page-item fetch_result" data-page-no=' . $lastpage . '><a href="javascript:void(0)" class="page-link">' . $lastpage . '</a></li>';
					}
					// End only hide early pages
					else {
						$paginate .= '<li class="page-item fetch_result" data-page-no="1"><a href="javascript:void(0)" class="page-link">1</a></li>';
						$paginate .= '<li class="page-item fetch_result" data-page-no="2"><a href="javascript:void(0)" class="page-link">2</a></li>';
						$paginate .= '<li class="page-item disabled"><a href="javascript:void(0)" class="page-link">...</a></li>';
						for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++) {
							if ($counter == $page) {
								$paginate .= '<li class="page-item fetch_result active" data-page-no=' . $counter . '><a class="page-link">' . $counter . '</a></li>';
							} else {
								$paginate .= '<li class="page-item fetch_result" data-page-no=' . $counter . '><a class="page-link">' . $counter . '</a></li>';
							}
						}
					}
				}
				// Next
				if ($page < $counter - 1) {
					$paginate .= '<li class="page-item fetch_result" data-page-no="' . $next . '"><a href="javascript:void(0)" class="page-link" aria-label="' . esc_html__('Next', 'propertya') . '"><span aria-hidden="true">' . esc_html__('Next', 'propertya') . ' </span></a></li>';
				} else {
					$paginate .= '<li class="page-item disabled"><a href="javascript:void(0)" class="page-link" aria-label="' . esc_html__('Next', 'propertya') . '"><span aria-hidden="true">' . esc_html__('Next', 'propertya') . '</span></a></li>';
				}
				$paginate .= "</ul>";
			}
			return $paginate;
		}
	}
}

//Ajax based pagination just home page
if (!function_exists('propertya_pagination_search_home'))
{
	function propertya_pagination_search_home($wp_query, $page = 0)
	{
		if ($wp_query->found_posts > 1) {
			$limit = $total_pages = '';
			$limit = get_option('posts_per_page');
			$total_pages = $wp_query->found_posts;
			$stages = 3;
			$page = $page;
			if ($page) {
				$start = ($page - 1) * $limit;
			} else {
				$start = 0;
			}
			// Initial page num setup
			if ($page == 0) {
				$page = 1;
			}
			$prev = $page - 1;
			$next = $page + 1;

			$lastpage = ceil($total_pages / $limit);
			$LastPagem1 = $lastpage - 1;

			$paginate = '';
			if ($lastpage > 1) {
				$paginate .= ' <ul class="pagination justify-content-start">';
				// Previous
				if ($page > 1) {
					$paginate .= '<li class="page-item fetch_result_home" data-page-no="' . $prev . '"><a class="page-link" href="javascript:void(0)">' . esc_html__('Previous', 'propertya') . '</a></li>';
				} else {

					$paginate .= '<li class="page-item disabled"><a href="javascript:void(0)" class="page-link" aria-label="' . esc_html__('Previous', 'propertya') . '"><span aria-hidden="true">' . esc_html__('Previous', 'propertya') . '</span></a></li>';
				}

				// Pages
				if ($lastpage < 7 + ($stages * 2)) { // Not enough pages to breaking it up
					for ($counter = 1; $counter <= $lastpage; $counter++) {
						if ($counter == $page) {
							$paginate .= '<li class="page-item fetch_result_home active" data-page-no=' . $counter . '><a href="javascript:void(0)" class="page-link">' . $counter . '</a></li>';
						} else {
							$paginate .= '<li class="page-item fetch_result_home" data-page-no=' . $counter . '><a href="javascript:void(0)" class="page-link">' . $counter . '</a></li>';
						}
					}
				} elseif ($lastpage > 5 + ($stages * 2)) { // Enough pages to hide a few?
					// Beginning only hide later pages
					if ($page < 1 + ($stages * 2)) {
						for ($counter = 1; $counter < 4 + ($stages * 2); $counter++) {
							if ($counter == $page) {
								$paginate .= '<li class="page-item fetch_result_home active" data-page-no=' . $counter . '><a href="javascript:void(0)" class="page-link">' . $counter . '</a></li>';
							} else {
								$paginate .= '<li class="page-item fetch_result_home" data-page-no=' . $counter . '><a href="javascript:void(0)" class="page-link">' . $counter . '</a></li>';
							}
						}
						$paginate .= '<li class="page-item disabled"><a href="javascript:void(0)" class="page-link">...</a></li>';
						$paginate .= '<li class="page-item fetch_result_home" data-page-no=' . $LastPagem1 . '><a href="javascript:void(0)" class="page-link">' . $LastPagem1 . '</a></li>';
						$paginate .= '<li class="page-item fetch_result_home" data-page-no=' . $lastpage . '><a href="javascript:void(0)" class="page-link">' . $lastpage . '</a></li>';
					}
					// Middle hide some front and some back
					elseif ($lastpage - ($stages * 2) > $page && $page > ($stages * 2)) {

						$paginate .= '<li class="page-item fetch_result_home" data-page-no="1"><a href="javascript:void(0)" class="page-link">1</a></li>';
						$paginate .= '<li class="page-item fetch_result_home" data-page-no="2"><a href="javascript:void(0)" class="page-link">2</a></li>';
						$paginate .= '<li class="page-item disabled"><a href="javascript:void(0)" class="page-link">...</a></li>';
						//$paginate.= "...";
						for ($counter = $page - $stages; $counter <= $page + $stages; $counter++) {
							if ($counter == $page) {
								$paginate .= '<li class="page-item fetch_result_home active" data-page-no=' . $counter . '><a href="javascript:void(0)" class="page-link">' . $counter . '</a></li>';
							} else {
								$paginate .= '<li class="page-item fetch_result_home" data-page-no=' . $counter . '><a href="javascript:void(0)" class="page-link">' . $counter . '</a></li>';
							}
						}
						//$paginate.= "...";
						$paginate .= '<li class="page-item disabled"><a href="javascript:void(0)" class="page-link">...</a></li>';
						$paginate .= '<li class="page-item fetch_result_home" data-page-no=' . $LastPagem1 . '><a href="javascript:void(0)" class="page-link">' . $LastPagem1 . '</a></li>';
						$paginate .= '<li class="page-item fetch_result_home" data-page-no=' . $lastpage . '><a href="javascript:void(0)" class="page-link">' . $lastpage . '</a></li>';
					}
					// End only hide early pages
					else {
						$paginate .= '<li class="page-item fetch_result_home" data-page-no="1"><a href="javascript:void(0)" class="page-link">1</a></li>';
						$paginate .= '<li class="page-item fetch_result_home" data-page-no="2"><a href="javascript:void(0)" class="page-link">2</a></li>';
						$paginate .= '<li class="page-item disabled"><a href="javascript:void(0)" class="page-link">...</a></li>';
						for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++) {
							if ($counter == $page) {
								$paginate .= '<li class="page-item fetch_result_home active" data-page-no=' . $counter . '><a class="page-link">' . $counter . '</a></li>';
							} else {
								$paginate .= '<li class="page-item fetch_result_home" data-page-no=' . $counter . '><a class="page-link">' . $counter . '</a></li>';
							}
						}
					}
				}
				// Next
				if ($page < $counter - 1) {
					$paginate .= '<li class="page-item fetch_result_home" data-page-no="' . $next . '"><a href="javascript:void(0)" class="page-link" aria-label="' . esc_html__('Next', 'propertya') . '"><span aria-hidden="true">' . esc_html__('Next', 'propertya') . ' </span></a></li>';
				} else {
					$paginate .= '<li class="page-item disabled"><a href="javascript:void(0)" class="page-link" aria-label="' . esc_html__('Next', 'propertya') . '"><span aria-hidden="true">' . esc_html__('Next', 'propertya') . '</span></a></li>';
				}
				$paginate .= "</ul>";
			}

			return $paginate;
		}
	}
}

if (!function_exists('propertya_no_result_found'))
{
	function propertya_no_result_found()
	{
        $image_id = '';
        $img_link = trailingslashit( get_template_directory_uri () ) ."libs/images/nothing-found.png";
        return '<img src="'.esc_url($img_link).'" alt="'.esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', TRUE)).'" class="img-fluid">';
    }
}

//Comments Callback
if ( !function_exists( 'propertya_custom_comments' ) )
{
    function propertya_custom_comments( $comment, $args, $depth )
	{
		$alt = $default = $comment_id = '';
        $GLOBALS['comment' ] = $comment;
        switch ( $comment->comment_type ) :
            case 'trackback' :
        ?>
                <div class="post pingback">
                    <p><?php esc_html__( 'Pingback:', 'propertya' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( esc_html__( '(Edit)', 'propertya' ), ' ' ); ?></p>
                </div>
                    <?php
                    break;
                	default :
                    ?>
                    <?php
                    if ( $depth > 1 ) {
                        echo '<div class="ml-5">';
                    }
                    ?>
    				<div class="real-comms" <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                        <div class="comment-user">
                            <div class="comm-avatar">
                             <?php 
                             if($comment->user_id)
                             { 
                                 echo get_avatar( $comment, null, $default, $alt, array( 'class' => array( 'd-flex','mx-auto' ) ) );
                             }
                             else
                             {
                                 echo get_avatar( $comment, 100 );
                             }
                             ?>
                            </div>
                            <span class="user-details"><span class="username"><?php echo get_comment_author_link(); ?> </span>
                            <span><?php echo esc_html__( 'on ', 'propertya' ); ?> </span>
                            <span><?php printf( esc_html( '%1$s', 'propertya' ), get_comment_date(), get_comment_time() );?></span>
                            <span>
                            <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args[ 'max_depth' ], 'add_below' => 'li-comment', 'reply_text' => '<i class="fa fa-reply pull-right"></i>' ) ), $comment_id ); ?>
                            </span>
                        </div>
                        <div class="comment-text">
                            <?php echo comment_text(); ?>
                        </div>
    				</div>
                <?php
                if ( $depth > 1 ) {
                    echo '</div>';
                }
                ?>
                <?php
                break;
        endswitch;
    }
} 

//Return dynamic data
if (!function_exists('propertya_params'))
{
    function propertya_params($param)
    {
        if(!empty($param))
        {
          return $param;  
        }
    }
}

//Total Comments Count Received
if (!function_exists('propertya_received_reviews'))
{
    function propertya_received_reviews($user_id)
    {
		$comments = array();
		$total = '';
        $param = array('status' => 'approve', 'post_type' => 'property', 'post_author__in' => $user_id, 'parent' => 0);
        $comments = get_comments($param);
		if(!empty($comments) && is_array($comments) && count($comments) > 0)
		{
			$total = count($comments);
		}
		return propertya_number_format_short($total);
    }
}
//Total Comments Count By Profile Received
if (!function_exists('propertya_submitted_profile_reviews'))
{
    function propertya_submitted_profile_reviews($profile_id)
    {
		$comments = array();
		$total = '';
		$param = array('status' => 'approve', 'type__in' =>array('property-buyers', 'property-agents', 'property-agency' ),  'user_id' =>$profile_id, 'parent' => 0);
		
        $comments = get_comments($param);
		if(!empty($comments) && is_array($comments) && count($comments) > 0)
		{
			$total = count($comments);
		}
		return propertya_number_format_short($total);
    }
}
//Total Comments Count Submitted
if (!function_exists('propertya_submitted_reviews'))
{
    function propertya_submitted_reviews($user_id)
    {
		$comments = array();
		$total = '';
        $param = array('status' => 'approve', 'post_type' => 'property', 'user_id' => $user_id, 'parent' => 0);
		
        $comments = get_comments($param);
		if(!empty($comments) && is_array($comments) && count($comments) > 0)
		{
			$total = count($comments);
		}
		return propertya_number_format_short($total);
    }

}

//Check Featured Property 
add_action('wp', 'propertya_check_property_status', 10);
if ( ! function_exists('propertya_check_property_status'))
{
	function propertya_check_property_status()
	{
		if (get_post_type(get_the_ID()) == 'property' && is_singular('property'))
		{	
			$property_id = get_the_ID();
            // current time
            $now = date('Y-m-d');
            if (get_post_meta($property_id, 'prop_is_feature_listing', true) !="" && get_post_meta($property_id, 'prop_is_feature_listing', true) == '1' )
            {
                $featured_expiry_for = '';
                $featured_expiry_for = get_post_meta($property_id, 'prop_feature_listing_for', true);
                if(isset($featured_expiry_for) && $featured_expiry_for !="" && $featured_expiry_for !="0" && $featured_expiry_for !="-1")
                {
                    if ($now > $featured_expiry_for)
                    {
                       update_post_meta($property_id, 'prop_feature_listing_for', '');
                       update_post_meta($property_id, 'prop_is_feature_listing', 0);
                       update_post_meta($property_id, 'prop_feature_listing_date','');
                       // featured ad expiry email
                       propertya_framework_featured_ad_expiry($property_id);
                    }
                }
            }
            //check property expiry
            if (get_post_meta($property_id, 'prop_regular_listing_expiry', true) !="" && get_post_meta($property_id, 'prop_regular_listing_expiry_date', true) !="" && get_post_meta($property_id, 'prop_regular_listing_expiry', true) != '-1' )
            {
                $last_date = get_post_meta($property_id, 'prop_regular_listing_expiry_date', true);
                $nooff_days = get_post_meta($property_id, 'prop_regular_listing_expiry', true);
                $status = 'expired';
                if ($now > $last_date)
                {
                    if (!empty(propertya_strings('prop_expiry_status')))
                    {
                       $status = propertya_strings('prop_expiry_status'); 
                    }
                    if($status == 'expired')
                    {
                        $my_post = array(
                          'ID'           => $property_id,
                          'post_status'   => 'expired',
                          'post_type' 	=> 'property'
  				        );
  			           $post_id = wp_update_post( $my_post );
                       if (!is_wp_error($post_id))
                       {
                          update_post_meta($property_id, 'prop_status', '0');
				          update_post_meta($property_id, 'prop_expired', 'yes');
				          update_post_meta($property_id, 'prop_is_feature_listing', '0');
                          update_post_meta($property_id, 'prop_regular_listing_expiry_date', '');    
                          update_post_meta($property_id, 'prop_regular_listing_expiry', '');
                          propertya_framework_regular_ad_expiry($property_id);
                       }
                    }
                    else
                    {
                        update_post_meta($property_id, 'prop_status', '0');
				        update_post_meta($property_id, 'prop_expired', 'yes');
				        update_post_meta($property_id, 'prop_is_feature_listing', '0');
                        update_post_meta($property_id, 'prop_regular_listing_expiry_date', '');    
                        update_post_meta($property_id, 'prop_regular_listing_expiry', '');
                        wp_trash_post($property_id);
                        propertya_framework_regular_ad_expiry($property_id);
                    }
                }
            }
        }
    }
}

//Total Comments Count Submitted
if (!function_exists('propertya_compare_msg'))
{
    function propertya_compare_msg()
    {
        
        return '<section class="section-padding single-comparison">
               <div class="container">
                <div class="row sec-heading-zone">
                    <div class="col">
                        <div class="sec-heading">
                            <p>'.propertya_strings('prop_compare_tagline').'</p>
                            <h2>'.propertya_strings('prop_compare_heading').'</h2>
                        </div>
                    </div>
                </div>
                  <div class="row">
                      <div class="col-xl-12 col-12">
                        <div class="alert custom-alert custom-alert--danger mb-0" role="alert">
                            <div class="custom-alert__top-side">
                                <span class="alert-icon custom-alert__icon  fas fa-exclamation-triangle"></span>
                                    <div class="custom-alert__body">
                                            <h6 class="custom-alert__heading"> '.esc_html__('Whoops!','propertya').'</h6>
                                            <div class="custom-alert__content">
                                              '.propertya_strings('prop_empty_msg').'                             
                                            </div>
                                    </div>
                             </div>
                        </div>
                      </div>
                  </div>
                  </div>
                  </section>';
    }
}
//Total Comments Count Submitted
if (!function_exists('propertya_packages_notifications'))
{
    function propertya_packages_notifications($type)
    {
        $link = '#';
        global $propertya_options;
        if(isset($propertya_options['prop_pkg_page']) && $propertya_options['prop_pkg_page'] !="")
        {
            $link = esc_url( get_page_link($propertya_options['prop_pkg_page']));
        }
        $anchor = esc_html__( 'Select Package', 'propertya' );
        $url = $link;
        if($type == 'expires')
        {
            return "<div class='alert custom-alert custom-alert--danger margin-bottom-30' role='alert'>
                  <div class='custom-alert__top-side'>
                    <span class='alert-icon custom-alert__icon fas fa-exclamation-triangle'></span>
                    <div class='custom-alert__body'>
                      <h6 class='custom-alert__heading'> ".esc_html__('Package Expired','propertya')." </h6>
                      <div class='custom-alert__content'>
                      ".esc_html__('Your package is expired! You will not be able to continue listings unless you renew your package.','propertya')."
                      ".sprintf( '<a href="%s">%s</a>', $url, $anchor )."
                      </div>
                    </div>
                  </div>
                </div>";
        }
        if($type == 'listings')
        {
            return "<div class='alert custom-alert custom-alert--info margin-bottom-30' role='alert'>
                  <div class='custom-alert__top-side'>
                    <span class='alert-icon custom-alert__icon fas fa-exclamation-triangle'></span>
                    <div class='custom-alert__body'>
                      <h6 class='custom-alert__heading'> ".esc_html__('Notification','propertya')." </h6>
                      <div class='custom-alert__content'>
                      ".esc_html__('Your listings are expired! You will not be able to continue listings unless you renew your package.','propertya')."
                      ".sprintf( '<a href="%s">%s</a>', $url, $anchor )."
                      </div>
                    </div>
                  </div>
                </div>";
        }
        if($type == 'package')
        {
            return "<div class='alert custom-alert custom-alert--info margin-bottom-30' role='alert'>
                  <div class='custom-alert__top-side'>
                    <span class='alert-icon custom-alert__icon fas fa-exclamation-triangle'></span>
                    <div class='custom-alert__body'>
                      <h6 class='custom-alert__heading'> ".esc_html__('Notification','propertya')." </h6>
                      <div class='custom-alert__content'>
                      ".esc_html__('You dont have any package please select a package to submit listings.','propertya')."
                      ".sprintf( '<a href="%s">%s</a>', $url, $anchor )."
                      </div>
                    </div>
                  </div>
                </div>";
        }
        if($type == 'reviews')
        {
            return "<div class='alert custom-alert custom-alert--info' role='alert'>
                  <div class='custom-alert__top-side'>
                    <span class='alert-icon custom-alert__icon fas fa-exclamation-triangle'></span>
                    <div class='custom-alert__body'>
                     
                      <div class='custom-alert__content'>
                      ".esc_html__("You don't have any review yet!. Your review score will be here. ",'propertya')."
                      </div>
                    </div>
                  </div>
                </div>";
        }
        if($type == 'activities')
        {
            return "<div class='alert custom-alert custom-alert--info' role='alert'>
                  <div class='custom-alert__top-side'>
                    <span class='alert-icon custom-alert__icon fas fa-exclamation-triangle'></span>
                    <div class='custom-alert__body'>
                      <div class='custom-alert__content'>
                      ".esc_html__("Your recent reviews or feedback will be shown here.",'propertya')."
                      </div>
                    </div>
                  </div>
                </div>";
        }
        if($type == 'listing')
        {
            return "<div class='alert custom-alert custom-alert--info' role='alert'>
                  <div class='custom-alert__top-side'>
                    <span class='alert-icon custom-alert__icon fas fa-exclamation-triangle'></span>
                    <div class='custom-alert__body'>
                      <div class='custom-alert__content'>
                      ".esc_html__("Sorry! You have no listing yet! Most viewed listings will be shown here.",'propertya')."
                      </div>
                    </div>
                  </div>
                </div>";
        }
        if($type == 'noplan')
        {
            return "<div class='alert custom-alert custom-alert--info' role='alert'>
                  <div class='custom-alert__top-side'>
                    <span class='alert-icon custom-alert__icon fas fa-exclamation-triangle'></span>
                    <div class='custom-alert__body'>
                      <div class='custom-alert__content'>
                      ".esc_html__('You dont have any package please select a package to submit listings.','propertya')."
                      ".sprintf( '<a href="%s">%s</a>', $url, $anchor )."
                      </div>
                    </div>
                  </div>
                </div>";
        }
    }
}


//showing pending properties to user

if (!function_exists('propertya_access_to_user'))
{
     function propertya_access_to_user($query)
     { 
        if (isset($_GET['post_type']) && $_GET['post_type'] == "property" && isset($_GET['p'])) {
            $post_author = '';
            $property_id = $_GET['p'];
            $post_author = get_post_field('post_author', $property_id);
             if (is_user_logged_in() && get_current_user_id() == $post_author)
             {
                $query->set('post_status', array('publish', 'draft','pending'));
                return $query;
             }
             else
             {
                return $query;
             }

        }
     }
}
add_filter('pre_get_posts', 'propertya_access_to_user');



//if currency exhchanger is enabled


if (!function_exists('prop_currency_switcher'))
{
    function prop_currency_switcher()
    {

		
		if(in_array('propertya-framework/index.php', apply_filters('active_plugins', get_option('active_plugins'))))
		{
			if (propertya_strings('prop_enable_currency_switcher') == true && propertya_strings('prop_enable_currency_api_key') != '' &&  propertya_strings('prop_opt_currency_switcher_languages') != '')
			{
				$selected = $options = '';
				$rates =  get_transient('prop_daily_conversion_rates' );
				if(!empty($rates))
				{ 
					$money_sumbol = '';
					$stdclass = json_decode(json_encode($rates), true);
					$currencies = propertya_strings('prop_opt_currency_switcher_languages');
					$myArray = explode('|', $currencies);
					$select_val = '';
					if (isset($_COOKIE['prop_currency_rate']) && $_COOKIE['prop_currency_rate'] != "") {
						$select_val = $_COOKIE['prop_currency_rate'];
					}
					$myVal = explode("-", $select_val);
					$select_val = ( isset($myVal[1])) ? $myVal[1] : "";
					if(is_array($myArray))
					{
						foreach($myArray as $value)
						{
							$selected = '';
							if(array_key_exists($value,$stdclass))
							{
								$money_sumbol = propertya_framework_get_currency_symbol($value);						
							  if ($select_val == $stdclass[$value]){
								  $selected = 'selected="selected"';
							  }

							  $options.= '<option value="'.esc_attr($money_sumbol.'-'.$stdclass[$value]).'" '.$selected.'>'.esc_html($value).'</option>';
							}
						}
					}
					return '<select class="prop-currency-switch theme-selects" name="prop-currency" data-placeholder="'.esc_html__('Currency','propertya').'">
							<option value="">&nbsp;</option>
								'.$options.'
							</select>';
				}
			}
		}
	}
}
if ( ! function_exists( 'wp_return_echo' ) ) 
{
	function wp_return_echo($echo)
	{
		return $echo;
	}
}