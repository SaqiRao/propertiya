<?php
// Fetch Terms
if ( ! function_exists( 'propertya_framework_terms_options' ) )
{
	function propertya_framework_terms_options($term_name, $selected_val = false)
	{
		$term_arg = get_terms( array(
			'taxonomy'   => $term_name,
			'hide_empty' => false,
			'parent'     => 0
		));
				echo '<option value="">' .esc_html__('Select an option','propertya-framework').'</option>';
		// Generate options
		propertya_framework_terms_hierarchy($term_name,$term_arg,$selected_val);
	}	
}
if ( ! function_exists( 'propertya_framework_terms_options_multiple' ) )
{
	function propertya_framework_terms_options_multiple($term_name, $selected_val = false)
	{
		$term_arg = get_terms( array(
			'taxonomy'   => $term_name,
			'hide_empty' => false,
			'parent'     => 0
		));
			echo '<option value="">' .esc_html__('Select an option','propertya-framework').'</option>';
		// Generate options
		propertya_framework_terms_hierarchy($term_name,$term_arg,$selected_val);
	}	
}
if ( ! function_exists( 'propertya_framework_terms_hierarchy' ) )
{
	function propertya_framework_terms_hierarchy( $term_name, $term_arg, $selected_val, $separator = " " )
	{
		if (!empty($term_arg) && count($term_arg) > 0)
		{
			foreach ($term_arg as $term)
			{
				if ($selected_val == $term->slug)
				{
					echo '<option value="' . $term->slug . '" selected="selected">' . $separator . $term->name . '</option>';
				}
				else
				{
					echo '<option value="' . $term->slug . '">' . $separator . $term->name . '</option>';
				}
				$check_childs = get_terms( array(
					'taxonomy'   => $term_name,
					'hide_empty' => false,
					'parent'     => $term->term_id
				) );
				if (!empty($check_childs) )
				{
					// recursive call if children found
					propertya_framework_terms_hierarchy( $term_name, $check_childs, $selected_val, "- " . $separator );
				}
			}
		}
	}
}





//Remove Unwanted MetaBox
add_action( 'add_meta_boxes', 'propertya_framework_remove_metabox', 100);
if ( ! function_exists( 'propertya_framework_remove_metabox' ) ) 
{
	function propertya_framework_remove_metabox()
	{
		remove_meta_box( 'property_typediv', 'property', 'side' );
		remove_meta_box( 'property_statusdiv', 'property', 'side' );
		remove_meta_box( 'tagsdiv-property_label', 'property', 'side' );
		remove_meta_box( 'tagsdiv-property_currency', 'property', 'side' );
		remove_meta_box( 'property_area_unitdiv', 'property', 'side' );
        remove_meta_box( 'property_locationdiv', 'property', 'side' );
		remove_meta_box( 'property_locationdiv', 'property-agency', 'side' );
		remove_meta_box( 'property_locationdiv', 'property-agents', 'side' );
		remove_meta_box( 'tagsdiv-agent_types', 'property-agents', 'side' );
		remove_meta_box( 'agency_locationdiv', 'property-agency', 'side' );
		remove_meta_box( 'agent_locationdiv', 'property-agency', 'side' );
        remove_meta_box( 'pageparentdiv', 'property', 'side' );
        remove_meta_box( 'postexcerpt', 'property', 'normal' );
        remove_meta_box( 'authordiv', 'property', 'normal' );
	}
}
// Get Generic Terms
if ( ! function_exists( 'propertya_framework_term_fetch' ) ) {	
function propertya_framework_term_fetch($taxonomy = 'category', $parent_of = 0, $child_of = 0 )
{
	$defaults = array(
			'taxonomy'               => $taxonomy,
			'orderby'                => 'name',
			'order'                  => 'ASC',
			'hide_empty'             => 0,
			'exclude'                => array(),
			'exclude_tree'           => array(),
			'number'                 => '',
			'offset'                 => '',
			'fields'                 => 'all',
			'name'                   => '',
			'slug'                   => '',
			'hierarchical'           => true,
			'search'                 => '',
			'name__like'             => '',
			'description__like'      => '',
			'pad_counts'             => false,
			'get'                    => '',
			'child_of'               => $child_of,
			'parent'                 => $parent_of,
			'childless'              => false,
			'cache_domain'           => 'core',
			'update_term_meta_cache' => true,
			'meta_query'             => ''
		);
		return get_terms( $defaults );
	 }
}


//get term id form slug
if ( ! function_exists( 'propertya_framework_get_slug_id' ) )
{
	function propertya_framework_get_slug_id($slug,$taxnomy_name)
	{
		if(!empty($slug) && !empty($taxnomy_name))
		{
			$fetch_id  = get_term_by( 'slug', $slug, $taxnomy_name);
			return $fetch_id->term_id;
		}
	}
}
// Get Price
if ( ! function_exists( 'propertya_framework_fetch_price' ) )
{
	function propertya_framework_fetch_price($property_id)
	{
		$optional_price = $selected_currency = $selected_pricelabel_after = $selected_pricelabel_before = $selected_price_optional = $selected_price = '';
        $selected_currency = '$';
        if(propertya_framework_get_options('prop_currency_mode') !="" && propertya_framework_get_options('prop_currency_mode') == 1 && propertya_framework_get_options('prop_single_currency') !='')
        {
            $selected_currency = propertya_framework_get_options('prop_single_currency');
        }
        else
        {
            $selected_currency = get_post_meta( $property_id, 'prop_currecny_type', true );
            $term_id = propertya_framework_get_slug_id($selected_currency,'property_currency'); 
            if(get_term_meta($term_id, 'p_currency_sym', true ) !="")
            {
                $selected_currency = get_term_meta($term_id, 'p_currency_sym', true );
            }
        }
		$selected_price = get_post_meta($property_id, 'prop_first_price', true );
		$selected_price_optional = get_post_meta($property_id, 'prop_second_price', true );
		$selected_pricelabel_before = get_post_meta($property_id, 'prop_pricelabel_before', true );
		$selected_pricelabel_after = get_post_meta($property_id, 'prop_pricelabel_after', true );
		$price_array = array();
		if(!empty($selected_price))
		{
			if (!empty( $selected_pricelabel_before )) {
				$price_array['before_prefix'] = $selected_pricelabel_before;
            }
			if (!empty( $selected_pricelabel_after )) {
				$price_array['after_prefix'] = '&#47;' . $selected_pricelabel_after;
            }
			if (!empty( $selected_price_optional )) {
				$price_array['optional_price'] =  propertya_framework_price_separator($selected_price_optional, $selected_currency);
			}
			$price_array['main_price'] = propertya_framework_price_separator($selected_price, $selected_currency);
		}
		return $price_array;
	}
}

//Price Separator
if ( ! function_exists( 'propertya_framework_price_separator' ) )
{
	function propertya_framework_price_separator($prop_price,$currency)
	{
		if(!empty($prop_price) && !empty($currency))
		{
			global $propertya_options;
			$price = '';
			$thousands_sep = ",";
			if(propertya_framework_get_options('property_opt_thousand_separator') !="")
			{
				$thousands_sep =  propertya_framework_get_options('property_opt_thousand_separator');
			}
			$decimals_separator = ".";
			if(propertya_framework_get_options('property_opt_decimals_separator') !="")
			{
				$decimals_separator =  propertya_framework_get_options('property_opt_decimals_separator');
			}
			$decimals = 0;
			if(propertya_framework_get_options('property_opt_decimals') !="")
			{
				$decimals =  propertya_framework_get_options('property_opt_decimals');
			}
			if (is_numeric($prop_price))
			{
				$currency_symbol = $exchange_rate = '';
				if (isset($_COOKIE['prop_currency_rate']) && $_COOKIE['prop_currency_rate'] != "") 
				{
					 $select_val = $_COOKIE['prop_currency_rate'];
					 $myVal = explode("-", $select_val);
					 $exchange_rate = ( isset($myVal[1])) ? $myVal[1] : "";
					 $currency_symbol = ( isset($myVal[0])) ? $myVal[0] : "";
					 $prop_price = $prop_price * $exchange_rate;
					 $currency = $currency_symbol;
					
				}
				 $price = number_format($prop_price, $decimals, $decimals_separator, $thousands_sep);
				 if(isset($price) && $price !="")
				 {
					if(propertya_framework_get_options('property_opt_currency_position') !="" && propertya_framework_get_options('property_opt_currency_position') =="before")
				 	{
						$price = $currency.' ' . $price;
				 	}
				 	else
				 	{
					 	$price = $price . ' '.$currency;
				 	}
				}
			}
			return $price;
		}
	}
}
//Fetch Selected Gallery For Admin Panel only
if ( ! function_exists( 'propertya_framework_prop_gallery' ))
{
	function propertya_framework_prop_gallery($gallery_id,$property_id = '')
	{

		if(empty($gallery_id)) return;
		$main_img = $thumb_imgs = $html = $media = '';
		$media = explode( ',', $gallery_id );	
		
		if(!empty($media) && count($media) > 0)
		{

           
			$html .= '<ul class="custom-meta-gallery">';
			foreach( $media as $m )
			{
				$attach_id = '';
				$attach_id =  $m;
				if($attach_id == 0){
					continue;
				}
				

                if(wp_attachment_is_image($attach_id))
                {
                    $thumb_imgs  = wp_get_attachment_image_src($attach_id, 'propertya-user-thumb');
                    $main_img = $thumb_imgs[0];
                }


                else
                {
                    global $propertya_options;
                    if (isset($propertya_options['prop_defualt_listing_image']['url']) && $propertya_options['prop_defualt_listing_image']['url'] != "")
                    {
                       $main_img = $propertya_options['prop_defualt_listing_image']['url'];
                    } 
                    else
                    {
                       $main_img = SB_THEMEURL_PLUGIN .  'libs/images/placeholder.png';
                    }
                }
				$thumb_imgs  = wp_get_attachment_image_src($attach_id, 'propertya-user-thumb');

				$html .= '<li class="sort_list_img" id="'.esc_attr($attach_id).'"><div class="custom-meta-gallery_container"><span class="img_suff"><i class="fas fa-arrows-alt shuffle-img"></i></span><span class="custom-gallery-del">
				 <img class="img-fluid" data-property-id="'.$property_id.'" id="' . esc_attr($attach_id) . '" src="'.esc_url($main_img).'" alt="'.esc_html__('image not found','dwt-listing').'" /></span></div></li>';
			}
			$html .= '</ul>';
		}
		return  $html;
	}
}

//Fatch Selected Attachments For Admin Panel only
if ( ! function_exists( 'propertya_framework_prop_attachments' ))
{
	function propertya_framework_prop_attachments($attachment_id,$property_id = '')
	{
		if(empty($attachment_id)) return;
		$thumb_imgs = $html = $media = '';
		$media = explode( ',', $attachment_id );	
		if(!empty($media) && count($media) > 0)
		{
			foreach( $media as $m )
			{
				$type_img = $attach_id = '';
				$attach_id =  $m;
				$html .= '<div class="uploading-attachments att_suff " id="'.$attach_id.'"> <img src="'.get_icon_for_attachment($attach_id).'" alt=""><span class="attachment-data"> <h4><a href="'.wp_get_attachment_url($attach_id).'" class="clr-black attachment-file-title" target="_blank">'. wp_trim_words(get_the_title($attach_id), 5, ' …' ).'</a></h4> <p> file size: '.size_format(filesize(get_attached_file($attach_id))).'</p> <a href="javascript:void(0)" class="btn-pro-clsoe-icon" data-id="'.$attach_id.'" data-property-id="'.$property_id.'"> <i class="fas fa-times-circle"></i></a> </span><span class="attach_suff"><i class="fas fa-arrows-alt shuffle-attachs"></i></span></div>';
			}
		}
		return  $html;
	}
}

//Fatch Property Gallery Images Ids
if ( ! function_exists( 'propertya_framework_fetch_gallery_idz' ) )
{
	function propertya_framework_fetch_gallery_idz($property_id)
	{
		$re_order =	get_post_meta( $property_id, 'prop_gallery', true );
   
		//$re_order =implode($re_order);
		if($re_order != "")
		{
			
			$images_ids  =   explode( ',', $re_order );

            if (is_array($images_ids) && isset($images_ids[0]) && $images_ids[0] === '0') {
              array_shift($images_ids); // Remove the first element
            }
			
			  return $images_ids;
			
			//return $re_order;
		}
		// else
		// {
		// 	global $wpdb;
		// 	$query	= "SELECT ID FROM $wpdb->posts WHERE post_type = 'attachment' AND post_parent = '" . $property_id . "'";
		// 	$results = $wpdb->get_results( $query, OBJECT );
			
		// 	return $results;
		// }
	}
}
// Return media
if ( ! function_exists('propertya_framework_img_src'))
{
	function propertya_framework_img_src($media,$thumbnail_size)
	{
        global $propertya_options;
      
		if( count((array)  $media ) > 0 )
		{
			
			$i	=	1;
			foreach( $media as $m )
			{
				
				if( $i > 1 ) break;
				$mid	=	'';
				if ( isset( $m->ID ) )
				{
					$mid	= 	$m->ID;
					
				}
				else
				{
					
					$mid	=	$m;	
					
				}
				if(wp_attachment_is_image($mid))
				{
					
					$image  = wp_get_attachment_image_src( $mid, $thumbnail_size);
					
					return $image[0];	
				}
				else
				{
					
                    if (isset($propertya_options['prop_defualt_listing_image']['url']) && $propertya_options['prop_defualt_listing_image']['url'] != "")
                    {
                        return $propertya_options['prop_defualt_listing_image']['url'];
                    } 
                    else
                    {
                        return SB_THEMEURL_PLUGIN .  'libs/images/no-image.png';
                    }
				}
			}
		}
		else
		{
            if (isset($propertya_options['prop_defualt_listing_image']['url']) && $propertya_options['prop_defualt_listing_image']['url'] != "")
            {
                return $propertya_options['prop_defualt_listing_image']['url'];
            } 
            else
            {
                return SB_THEMEURL_PLUGIN .  'libs/images/no-image.png';
            }
		}
	}
}

if ( ! function_exists( 'wp_body_open' ) ) {
    function wp_body_open() {
        do_action( 'wp_body_open' );
    }
}


// Show all agencies for admin only
if ( ! function_exists( 'propertya_framework_show_allagencies' ) )
{
	function propertya_framework_show_allagencies($id = false)
	{
		$args =	array
		(
			'post_type' => 'property-agency',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'order'=> 'DESC',
			'orderby' => 'date',
			'meta_query' => array(array('key'=>'agency_status','value' => 1,'compare' => '=')),
		);
		$all_agencies = new WP_Query($args);
		if ( $all_agencies->have_posts() )
		{
			 echo '<option value="">' .esc_html__('Select an option','propertya-framework').'</option>';
			 while ( $all_agencies->have_posts() )
			 {
				 $all_agencies->the_post();
				 $agency_id	=	get_the_ID();
				 if(!empty($id) && $id == $agency_id)
				 {
				 	echo '<option value="' . $agency_id . '" selected="selected">' .esc_attr(get_the_title($agency_id)). '</option>';
				 }
				 else
				 {
				 	echo '<option value="' . $agency_id  . '">' .esc_attr(get_the_title($agency_id)). '</option>';
				 }
			 }
		}
	}
}
// Show all agents for admin only
if ( ! function_exists( 'propertya_framework_show_allagents' ) )
{
    function propertya_framework_show_allagents($id = false)
    {
        $args =	array
        (
            'post_type' => 'property-agents',
            'posts_per_page' => -1,
            'order'=> 'DESC',
            'orderby' => 'date',
            'meta_query' => array(array('key'=>'agent_status','value' => 1,'compare' => '=')),
        );
        $all_agents = new WP_Query($args);
        if ( $all_agents->have_posts() )
        {
            echo '<option value="">' .esc_html__('Select an option','propertya-framework').'</option>';
            while ( $all_agents->have_posts() )
            {
                $all_agents->the_post();
                $agent_id	=	get_the_ID();
                $current_post_author_id = get_the_author_meta( 'ID' );
                if(!empty($id) && $id == $agent_id)
                {
                    echo '<option value="' . $current_post_author_id . '" selected="selected">' .esc_attr(get_the_title($agent_id)). '</option>';
                }
                else
                {
                    echo '<option value="' . $agent_id  . '">' .esc_attr(get_the_title($agent_id)). '</option>';
                }
            }
        }
    }
}


// Delete user from admin
if ( ! function_exists( 'propertya_framework_delete_user_admin' ) )
{
	function propertya_framework_delete_user_admin( $user_id ) {
	   // delete comment with that user id
		$c_args = array ('user_id' => $user_id,'post_type' => 'any','status' => 'all');
		$comments = get_comments($c_args);
		if(count((array) $comments) > 0 )
		{
			foreach($comments as $comment) :
				wp_delete_comment($comment->comment_ID, true);
			endforeach;
		}
		// delete user posts
		 $args = array ('numberposts' => -1,'post_type' => 'any','author' => $user_id);
		 $user_posts = get_posts($args);
		 // delete all the user posts
		 if(count((array) $user_posts) > 0 )
		 {
			 foreach ($user_posts as $user_post) {
				wp_delete_post($user_post->ID, true);
			 }
		 }
	}
}
add_action( 'delete_user', 'propertya_framework_delete_user_admin', 10 );


// Disable admin bar for all users
if ( ! function_exists( 'propertya_framework_bs_hide_admin_bar' ) )
{
	function propertya_framework_bs_hide_admin_bar()
	{
		if (!current_user_can('administrator') && !is_admin())
		{
			show_admin_bar(false);
   		}
	}
}
add_action('after_setup_theme', 'propertya_framework_bs_hide_admin_bar');


// Badword filter
if ( ! function_exists( 'propertya_framework_badwords_filter' ) )
{	 
	function propertya_framework_badwords_filter( $words = array(), $string = '', $replacement = '' )
	{
		foreach( $words as $word )
		{
			$string	=	str_replace($word, $replacement, $string);
		}
		return $string;
	}
}
//Selected Category
if ( ! function_exists( 'propertya_framework_selected_cat' ) )
{
	function propertya_framework_selected_cat($property_id)
	{
		$cats_html ='';
		if(!empty($property_id))
		{
			if(get_post_meta($property_id, 'prop_type', true ) !="")
			{
				$category_slug = get_post_meta($property_id, 'prop_type', true );
				$term = get_term_by('slug', $category_slug, 'property_type');
				
				if( $term !== false)
				{
					$link = get_term_link( $term->term_id );
					$cats_html .= '<a href="'.$link.'">'.esc_attr( $term->name ).'</a>';
				}
			}
		}
		return $cats_html;
	}
}
//Selected Price
if ( ! function_exists( 'propertya_framework_selected_price' ) )
{
	function propertya_framework_selected_price($property_id)
	{
		$get_all_prices = array();
		if(!empty($property_id))
		{
			$optional_price = $selected_pricelabel_after = '';
			$get_all_prices =  propertya_framework_fetch_price($property_id);
			if(is_array($get_all_prices) && count($get_all_prices) > 0 && array_key_exists("main_price",$get_all_prices))
			{
				if (array_key_exists("optional_price",$get_all_prices))
				{
				   $optional_price = '<br>' . $get_all_prices['optional_price'];
				}
				if (array_key_exists("after_prefix",$get_all_prices))
				{
				   $selected_pricelabel_after = $get_all_prices['after_prefix'];
				}
				return '<span class="r-price"><strong>' . $get_all_prices['main_price'] .'</strong>' . $optional_price .  $selected_pricelabel_after . '</span>';
			}
		}
	}
}
//Pagination frontend
if ( ! function_exists( 'propertya_framework_prop_pagination' ) )
{
	function propertya_framework_prop_pagination($max_num_pages = null, $echo = true ) {
		$current_page = $total_pages = ''; $pages = array();
		$total_pages = $max_num_pages->max_num_pages;
		$current_page = max(1, get_query_var('paged')); 
		$pages = paginate_links( [
		
				//'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
				'base' 		   => @add_query_arg('paged','%#%'),
				'format'       => '?paged=%#%',
				'current'      => $current_page,
				'total'        => $total_pages,
				'type'         => 'array',
				'show_all'     => false,
				'end_size'     => 3,
				'mid_size'     => 1,
				'prev_next'    => true,
				'prev_text'    => esc_html__( 'Prev', 'propertya-framework' ),
				'next_text'    =>esc_html__( 'Next', 'propertya-framework' ),
				'add_args'     => false,
				'add_fragment' => ''
			]
		);
		if ( is_array( $pages ) ) {
			$pagination = '<div class="admin-pagination"><div class="pagination"><ul class="pagination">';
			foreach ($pages as $page) {
							$pagination .= '<li class="page-item' . (strpos($page, 'current') !== false ? ' active' : '') . '"> ' . str_replace('page-numbers', 'page-link', $page) . '</li>';
					}
			$pagination .= '</ul></div></div>';
			if ( $echo ) {
				echo $pagination;
			} else {
				return $pagination;
			}
		}
		return null;
	}
}
//Pagination Reviews
if ( ! function_exists( 'propertya_framework_prop_pagination_reviews' ) )
{
	function propertya_framework_prop_pagination_reviews($max_num_pages = null, $echo = true, $paged = '' ) {
		$current_page = $total_pages = ''; $pages = array();
		$total_pages = $max_num_pages;
		$current_page = max(1,$paged); 
		$pages = paginate_links( [
		
				'base' 		   => @add_query_arg('paged','%#%'),
				'total'        => $total_pages,
				'format'       => '?paged=%#%',
				'current'      => $current_page,
				'type'         => 'array',
				'show_all'     => false,
				'end_size'     => 3,
				'mid_size'     =>1,
				'prev_next'    => true,
				'prev_text'    => esc_html__( 'Prev', 'propertya-framework' ),
				'next_text'    =>esc_html__( 'Next', 'propertya-framework' ),
				'add_args'     => false,
				'add_fragment' => ''
			]
		);
		if ( is_array( $pages ) ) {
			$pagination = '<div class="admin-pagination"><div class="pagination"><ul class="pagination">';
			foreach ($pages as $page) {
							$pagination .= '<li class="page-item' . (strpos($page, 'current') !== false ? ' active' : '') . '"> ' . str_replace('page-numbers', 'page-link', $page) . '</li>';
					}
			$pagination .= '</ul></div></div>';
			if ( $echo ) {
				echo $pagination;
			} else {
				return $pagination;
			}
		}
		return null;
	}
}


//Agent Featured Image frontend
if ( ! function_exists( 'propertya_framework_agent_feature_img' ) )
{
	function propertya_framework_agent_feature_img($agent_id,$thumb_size = '')
	{
		if(has_post_thumbnail($agent_id))
		{
			return the_post_thumbnail($thumb_size); //size of the thumbnail 
		}
		else
		{
			$defualt_img = trailingslashit( get_template_directory_uri()).'libs/images/default-imag.jpg';
			global $propertya_options;
			if(isset($propertya_options['prop_def_agent_logo']) && $propertya_options['prop_def_agent_logo']['url'] !="")
			{
				$defualt_img = $propertya_options['prop_def_agent_logo']['url'];
			} 
			return '<img src="'.esc_url($defualt_img).'" class="img-fluid" alt="'.get_the_title($agent_id).'">';
		}	
	}
}

//get selected terms all parents
if ( ! function_exists( 'propertya_framework_get_ancestors' ) )
{
	function propertya_framework_get_ancestors($slug,$taxnomy_name)
	{
		if(!empty($slug) && !empty($taxnomy_name))
		{
			$array = array();
			$fetch_id  = get_term_by( 'slug', $slug, $taxnomy_name);
			$term_id = $fetch_id->term_id;
			$ancestor_cat_ids = get_ancestors($term_id,$taxnomy_name);
			if(is_array($ancestor_cat_ids) && count($ancestor_cat_ids) > 0)
			{
				$array = array_values($ancestor_cat_ids);

			}
			//array_unshift($array,$term_id);
			 array_push($array,$term_id);
			return $array;
		}
	}
}

// Store User Package Against Package
if (!function_exists('propertya_framework_save_user_pkg'))
{
    function propertya_framework_save_user_pkg($user_id, $package_id)
	{
		if(!empty($user_id) && !empty($package_id))
		{
			$now = date('Y-m-d');
			$bump_listing = $featured_listing_expiry = $featured_listing = $listing_expiry = $regular_listing = $package_expiry = '';
			//get package detail
			$package_expiry = get_post_meta( $package_id, 'prop_package_expiry', true );
			$regular_listing = get_post_meta( $package_id, 'prop_regular_listing', true );
			$featured_listing = get_post_meta( $package_id, 'prop_featured_listing', true );
			$bump_listing =   get_post_meta( $package_id, 'prop_bump_listing', true );
			
			update_user_meta($user_id, 'prop_user_selected_pkg',$package_id);
			//regular listings
			if(!empty($regular_listing) && $regular_listing == '-1' )
			{
				  update_user_meta($user_id, 'prop_user_reg_listings', '-1');
			}
			else if( !empty($regular_listing) && is_numeric( $regular_listing ) &&  $regular_listing != 0 )
			{
			 	update_user_meta($user_id, 'prop_user_reg_listings', $regular_listing);
			}
			else
			{
				update_user_meta($user_id, 'prop_user_reg_listings', '');
			}
			//featured listings
			if(!empty($featured_listing) && $featured_listing == '-1' )
			{
				  update_user_meta($user_id, 'prop_user_feat_listings', '-1');
			}
			else if( !empty($featured_listing) && is_numeric( $featured_listing ) &&  $featured_listing != 0 )
			{
			 	update_user_meta($user_id, 'prop_user_feat_listings', $featured_listing);
			}
			else
			{
				update_user_meta($user_id, 'prop_user_feat_listings', '');
			}
			//bump listings
			if(!empty($bump_listing) && $bump_listing == '-1' )
			{
				  update_user_meta($user_id, 'prop_user_bump_listings', '-1');
			}
			else if( !empty($bump_listing) && is_numeric( $bump_listing ) &&  $bump_listing != 0 )
			{
			 	update_user_meta($user_id, 'prop_user_bump_listings', $bump_listing);
			}
			else
			{
				update_user_meta($user_id, 'prop_user_bump_listings', '');
			}
			//assign package days to user
			if( !empty($package_expiry) && $package_expiry == '-1' )
			{
				update_user_meta($user_id, 'prop_user_pkg_exp', '-1');
			}
			else
			{
				$date	=	date_create($now);
				date_add($date,date_interval_create_from_date_string("$package_expiry days"));
				$new_expiry	=	 date_format($date,"Y-m-d");
				update_user_meta($user_id, 'prop_user_pkg_exp', $new_expiry );
			}
			
		}
    }
}

//Fetch Childs Makes
if (!function_exists('propertya_framework_more_levels'))
{
   function propertya_framework_more_levels($request,$post_type,$extra_param = '') 
   {
      $childs  = $termchildren = $final_content = $params =  array();
      $data = '';
      $slug    = $request;
      $get_term = get_term_by('slug', $slug,$post_type);
      if(!empty($get_term) &&  count((array) $get_term) > 0)
      {
         $termchildren = get_terms(array('taxonomy'=> $get_term->taxonomy,'hide_empty' => false,'parent' => (int) $get_term->term_id) );   
         if(!empty($termchildren) && is_array($termchildren) && count($termchildren) > 0)
         {
            $data = '';
            if(empty($extra_param))
            {
                $data .= '<option value="">' . esc_html("Select an Option","propertya-framework"). '</option>';
            }
            foreach ($termchildren as $child)
            {
                if(!empty($extra_param))
                {
                    if ($extra_param == $child->slug)
                    {
                        $data .= '<option value="' . esc_html($child->slug) . '" selected="selected">' . esc_html($child->name) . '</option>';
                    }
                    else
                    {
                        $data .= '<option value="' .esc_html($child->slug) . '">' . esc_html($child->name). '</option>';
                    }
                }
                else
                {
                     $data .= '<option value="' .esc_html($child->slug) . '">' . esc_html($child->name). '</option>';
                }
            }
         }
      }
      return $data;
   }
}



//Get Property expiry date
if (!function_exists('propertya_framework_expiry_date_only'))
{
    function propertya_framework_expiry_date_only($property_id = '')
	{
        $total_listing_expir_days = $actual_listing_date = $now = $packg_id = $list_expir = $author_id = $listing_exp_days = '';
        if ($property_id == '')
		{
            return;
        }
        
        
         if (get_post_meta($property_id, 'prop_is_feature_listing', true) !="" && get_post_meta($property_id, 'prop_is_feature_listing', true) == '1' )
         {
                $featured_expiry_for = '';
                $featured_expiry_for = get_post_meta($property_id, 'prop_feature_listing_for', true);
                if(isset($featured_expiry_for) && $featured_expiry_for !="" && $featured_expiry_for !="0" && $featured_expiry_for !="-1")
                {
                    return date(get_option('date_format'), strtotime($featured_expiry_for));
                }
                else
                {
                    return esc_html__('Never Expire','propertya-framework');
                }
         }
        else
		{
            if(propertya_framework_get_options('prop_pkg_type')  != '' && propertya_framework_get_options('prop_perlisting_featured_expiry') == 'free')
            {
                return esc_html__('Never Expire','propertya-framework');
            }
            else
            {
			    //return get_post_meta($property_id, 'prop_expired',  true); 
			    return  esc_html__('N/A','propertya-framework');
            }
		}
    }
}



//Get Property expiry date
if (!function_exists('propertya_framework_get_currency'))
{
    function propertya_framework_get_currency()
	{
			return array (
				'ALL' => 'Albania Lek',
				'AFN' => 'Afghanistan Afghani',
				'ARS' => 'Argentina Peso',
				'AWG' => 'Aruba Guilder',
				'AUD' => 'Australia Dollar',
				'AZN' => 'Azerbaijan New Manat',
				'BSD' => 'Bahamas Dollar',
				'BBD' => 'Barbados Dollar',
				'BDT' => 'Bangladeshi taka',
				'BYR' => 'Belarus Ruble',
				'BZD' => 'Belize Dollar',
				'BMD' => 'Bermuda Dollar',
				'BOB' => 'Bolivia Boliviano',
				'BAM' => 'Bosnia and Herzegovina Convertible Marka',
				'BWP' => 'Botswana Pula',
				'BGN' => 'Bulgaria Lev',
				'BRL' => 'Brazil Real',
				'BND' => 'Brunei Darussalam Dollar',
				'KHR' => 'Cambodia Riel',
				'CAD' => 'Canada Dollar',
				'KYD' => 'Cayman Islands Dollar',
				'CLP' => 'Chile Peso',
				'CNY' => 'China Yuan Renminbi',
				'COP' => 'Colombia Peso',
				'CRC' => 'Costa Rica Colon',
				'HRK' => 'Croatia Kuna',
				'CUP' => 'Cuba Peso',
				'CZK' => 'Czech Republic Koruna',
				'DKK' => 'Denmark Krone',
				'DOP' => 'Dominican Republic Peso',
				'XCD' => 'East Caribbean Dollar',
				'EGP' => 'Egypt Pound',
				'SVC' => 'El Salvador Colon',
				'EEK' => 'Estonia Kroon',
				'EUR' => 'Euro Member Countries',
				'FKP' => 'Falkland Islands (Malvinas) Pound',
				'FJD' => 'Fiji Dollar',
				'GHC' => 'Ghana Cedis',
				'GIP' => 'Gibraltar Pound',
				'GTQ' => 'Guatemala Quetzal',
				'GGP' => 'Guernsey Pound',
				'GYD' => 'Guyana Dollar',
				'HNL' => 'Honduras Lempira',
				'HKD' => 'Hong Kong Dollar',
				'HUF' => 'Hungary Forint',
				'ISK' => 'Iceland Krona',
				'INR' => 'India Rupee',
				'IDR' => 'Indonesia Rupiah',
				'IRR' => 'Iran Rial',
				'IMP' => 'Isle of Man Pound',
				'ILS' => 'Israel Shekel',
				'JMD' => 'Jamaica Dollar',
				'JPY' => 'Japan Yen',
				'JEP' => 'Jersey Pound',
				'KZT' => 'Kazakhstan Tenge',
				'KPW' => 'Korea (North) Won',
				'KRW' => 'Korea (South) Won',
				'KGS' => 'Kyrgyzstan Som',
				'LAK' => 'Laos Kip',
				'LVL' => 'Latvia Lat',
				'LBP' => 'Lebanon Pound',
				'LRD' => 'Liberia Dollar',
				'LTL' => 'Lithuania Litas',
				'MKD' => 'Macedonia Denar',
				'MYR' => 'Malaysia Ringgit',
				'MUR' => 'Mauritius Rupee',
				'MXN' => 'Mexico Peso',
				'MNT' => 'Mongolia Tughrik',
				'MZN' => 'Mozambique Metical',
				'NAD' => 'Namibia Dollar',
				'NPR' => 'Nepal Rupee',
				'ANG' => 'Netherlands Antilles Guilder',
				'NZD' => 'New Zealand Dollar',
				'NIO' => 'Nicaragua Cordoba',
				'NGN' => 'Nigeria Naira',
				'NOK' => 'Norway Krone',
				'OMR' => 'Oman Rial',
				'PKR' => 'Pakistan Rupee',
				'PAB' => 'Panama Balboa',
				'PYG' => 'Paraguay Guarani',
				'PEN' => 'Peru Nuevo Sol',
				'PHP' => 'Philippines Peso',
				'PLN' => 'Poland Zloty',
				'QAR' => 'Qatar Riyal',
				'RON' => 'Romania New Leu',
				'RUB' => 'Russia Ruble',
				'SHP' => 'Saint Helena Pound',
				'SAR' => 'Saudi Arabia Riyal',
				'RSD' => 'Serbia Dinar',
				'SCR' => 'Seychelles Rupee',
				'SGD' => 'Singapore Dollar',
				'SBD' => 'Solomon Islands Dollar',
				'SOS' => 'Somalia Shilling',
				'ZAR' => 'South Africa Rand',
				'LKR' => 'Sri Lanka Rupee',
				'SEK' => 'Sweden Krona',
				'CHF' => 'Switzerland Franc',
				'SRD' => 'Suriname Dollar',
				'SYP' => 'Syria Pound',
				'TWD' => 'Taiwan New Dollar',
				'THB' => 'Thailand Baht',
				'TTD' => 'Trinidad and Tobago Dollar',
				'TRY' => 'Turkey Lira',
				'TRL' => 'Turkey Lira',
				'TVD' => 'Tuvalu Dollar',
				'UAH' => 'Ukraine Hryvna',
				'GBP' => 'United Kingdom Pound',
				'USD' => 'United States Dollar',
				'UYU' => 'Uruguay Peso',
				'UZS' => 'Uzbekistan Som',
				'VEF' => 'Venezuela Bolivar',
				'VND' => 'Viet Nam Dong',
				'YER' => 'Yemen Rial',
				'ZWD' => 'Zimbabwe Dollar'
        );
	}
}


if (!function_exists('propertya_framework_get_currency_symbol'))
{
	function propertya_framework_get_currency_symbol( $currency = '' ) {
		if ( ! $currency ) {
			$currency = propertya_framework_get_currency();
		}
	
		$symbols         =  array(
				'AED' => '&#x62f;.&#x625;',
				'AFN' => '&#x60b;',
				'ALL' => 'L',
				'AMD' => 'AMD',
				'ANG' => '&fnof;',
				'AOA' => 'Kz',
				'ARS' => '&#36;',
				'AUD' => '&#36;',
				'AWG' => 'Afl.',
				'AZN' => 'AZN',
				'BAM' => 'KM',
				'BBD' => '&#36;',
				'BDT' => '&#2547;&nbsp;',
				'BGN' => '&#1083;&#1074;.',
				'BHD' => '.&#x62f;.&#x628;',
				'BIF' => 'Fr',
				'BMD' => '&#36;',
				'BND' => '&#36;',
				'BOB' => 'Bs.',
				'BRL' => '&#82;&#36;',
				'BSD' => '&#36;',
				'BTC' => '&#3647;',
				'BTN' => 'Nu.',
				'BWP' => 'P',
				'BYR' => 'Br',
				'BYN' => 'Br',
				'BZD' => '&#36;',
				'CAD' => '&#36;',
				'CDF' => 'Fr',
				'CHF' => '&#67;&#72;&#70;',
				'CLP' => '&#36;',
				'CNY' => '&yen;',
				'COP' => '&#36;',
				'CRC' => '&#x20a1;',
				'CUC' => '&#36;',
				'CUP' => '&#36;',
				'CVE' => '&#36;',
				'CZK' => '&#75;&#269;',
				'DJF' => 'Fr',
				'DKK' => 'DKK',
				'DOP' => 'RD&#36;',
				'DZD' => '&#x62f;.&#x62c;',
				'EGP' => 'EGP',
				'ERN' => 'Nfk',
				'ETB' => 'Br',
				'EUR' => '&euro;',
				'FJD' => '&#36;',
				'FKP' => '&pound;',
				'GBP' => '&pound;',
				'GEL' => '&#x20be;',
				'GGP' => '&pound;',
				'GHS' => '&#x20b5;',
				'GIP' => '&pound;',
				'GMD' => 'D',
				'GNF' => 'Fr',
				'GTQ' => 'Q',
				'GYD' => '&#36;',
				'HKD' => '&#36;',
				'HNL' => 'L',
				'HRK' => 'kn',
				'HTG' => 'G',
				'HUF' => '&#70;&#116;',
				'IDR' => 'Rp',
				'ILS' => '&#8362;',
				'IMP' => '&pound;',
				'INR' => '&#8377;',
				'IQD' => '&#x639;.&#x62f;',
				'IRR' => '&#xfdfc;',
				'IRT' => '&#x062A;&#x0648;&#x0645;&#x0627;&#x0646;',
				'ISK' => 'kr.',
				'JEP' => '&pound;',
				'JMD' => '&#36;',
				'JOD' => '&#x62f;.&#x627;',
				'JPY' => '&yen;',
				'KES' => 'KSh',
				'KGS' => '&#x441;&#x43e;&#x43c;',
				'KHR' => '&#x17db;',
				'KMF' => 'Fr',
				'KPW' => '&#x20a9;',
				'KRW' => '&#8361;',
				'KWD' => '&#x62f;.&#x643;',
				'KYD' => '&#36;',
				'KZT' => 'KZT',
				'LAK' => '&#8365;',
				'LBP' => '&#x644;.&#x644;',
				'LKR' => '&#xdbb;&#xdd4;',
				'LRD' => '&#36;',
				'LSL' => 'L',
				'LYD' => '&#x644;.&#x62f;',
				'MAD' => '&#x62f;.&#x645;.',
				'MDL' => 'MDL',
				'MGA' => 'Ar',
				'MKD' => '&#x434;&#x435;&#x43d;',
				'MMK' => 'Ks',
				'MNT' => '&#x20ae;',
				'MOP' => 'P',
				'MRO' => 'UM',
				'MUR' => '&#x20a8;',
				'MVR' => '.&#x783;',
				'MWK' => 'MK',
				'MXN' => '&#36;',
				'MYR' => '&#82;&#77;',
				'MZN' => 'MT',
				'NAD' => '&#36;',
				'NGN' => '&#8358;',
				'NIO' => 'C&#36;',
				'NOK' => '&#107;&#114;',
				'NPR' => '&#8360;',
				'NZD' => '&#36;',
				'OMR' => '&#x631;.&#x639;.',
				'PAB' => 'B/.',
				'PEN' => 'S/',
				'PGK' => 'K',
				'PHP' => '&#8369;',
				'PKR' => '&#8360;',
				'PLN' => '&#122;&#322;',
				'PRB' => '&#x440;.',
				'PYG' => '&#8370;',
				'QAR' => '&#x631;.&#x642;',
				'RMB' => '&yen;',
				'RON' => 'lei',
				'RSD' => '&#x434;&#x438;&#x43d;.',
				'RUB' => '&#8381;',
				'RWF' => 'Fr',
				'SAR' => '&#x631;.&#x633;',
				'SBD' => '&#36;',
				'SCR' => '&#x20a8;',
				'SDG' => '&#x62c;.&#x633;.',
				'SEK' => '&#107;&#114;',
				'SGD' => '&#36;',
				'SHP' => '&pound;',
				'SLL' => 'Le',
				'SOS' => 'Sh',
				'SRD' => '&#36;',
				'SSP' => '&pound;',
				'STD' => 'Db',
				'SYP' => '&#x644;.&#x633;',
				'SZL' => 'L',
				'THB' => '&#3647;',
				'TJS' => '&#x405;&#x41c;',
				'TMT' => 'm',
				'TND' => '&#x62f;.&#x62a;',
				'TOP' => 'T&#36;',
				'TRY' => '&#8378;',
				'TTD' => '&#36;',
				'TWD' => '&#78;&#84;&#36;',
				'TZS' => 'Sh',
				'UAH' => '&#8372;',
				'UGX' => 'UGX',
				'USD' => '&#36;',
				'UYU' => '&#36;',
				'UZS' => 'UZS',
				'VEF' => 'Bs F',
				'VES' => 'Bs.S',
				'VND' => '&#8363;',
				'VUV' => 'Vt',
				'WST' => 'T',
				'XAF' => 'CFA',
				'XCD' => '&#36;',
				'XOF' => 'CFA',
				'XPF' => 'Fr',
				'YER' => '&#xfdfc;',
				'ZAR' => '&#82;',
				'ZMW' => 'ZK',
		);
	   return  $currency_symbol = isset( $symbols[ $currency ] ) ? $symbols[ $currency ] : '';
	}
}



// Get Specific Page Link
if (!function_exists('propertya_framework_social_shares'))
{
    function propertya_framework_social_shares($id)
	{
		if(!empty($id))
		{
			$theme_name  = wp_get_theme();
			$url = esc_url(get_the_permalink($id));
			$title = htmlspecialchars(urlencode(html_entity_decode(get_the_title($id), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');
			$img_url = '';
			$thumb = wp_get_attachment_image_src(get_post_thumbnail_id($id),'full');
			if(!empty($thumb) && is_array($thumb))
			{
				$img_url = $thumb[0];
			}
			return '<div class="socials-link">
                <ul class="list-unstyled f-size-14">
                  <li class="list-inline-item f-size-14 "><a class="clr-fb" href="http://www.facebook.com/sharer.php?u='.$url.'" target="_blank"><i class="fab fa-facebook-f"></i>Facebook </a></li>
                  <li class="list-inline-item f-size-14"><a class="clr-twitter" href="https://twitter.com/share?url='.$url.'&text='.$title.'&hashtags='.$theme_name.'" target="_blank"><i class="fab fa-twitter"></i> Twitter </a></li>
                  <li class="list-inline-item f-size-14"><a class="clr-linkin" href="https://www.linkedin.com/shareArticle?mini=true&url='.$url.'&title='.$title.'" target="_blank"><i class="fab fa-linkedin-in"></i> LinkedIn </a></li>
                  <li class="list-inline-item f-size-14"><a class="clr-pinterest" href="https://pinterest.com/pin/create/button/?url='.$url.'&media='.$img_url.'&description='.$title.'" target="_blank"><i class="fab fa-pinterest-p"></i>Pinterest </a></li>
                </ul>
            </div>';
		}
	}
}
add_action('user_register','propertya_on_registration_funtion');
if (! function_exists ( 'propertya_on_registration_funtion' )) {
	function propertya_on_registration_funtion($user_id){
		

		update_user_meta( $user_id, 'is_phone_verified', 0 );
		update_user_meta( $user_id, 'is_payment_verified', 0 );
		//update_user_meta( $user_id, 'is_profile_completed', 0 );
		update_user_meta( $user_id, 'is_email_verified', 0 );
	}
}
// Assign Related Roles
if (!function_exists ( 'propertya_framework_assign_selected_roles' ))
{
	function propertya_framework_assign_selected_roles($username,$user_id,$user_role_type,$user_mail,$displayname)
	{
		if(!empty($username) && !empty($user_id) && !empty($user_role_type))
		{
			if($user_role_type == 'agent')
			{
				$post_type = 'property-agents';
				$status =    'agent_status';
				$email =     'agent_email';
			}
			if($user_role_type == 'agency')
			{
				$post_type = 'property-agency';
				$status =    'agency_status';
				$email =    'agency_email';
			}
			if($user_role_type == 'buyer')
			{
				$post_type = 'property-buyers';
				$status =    'buyer_status';
				$email =    'buyer_email';
			}
			
			if(isset($post_type) && $post_type !="")
			{
				$new_post = array(
				  'post_title'      => $displayname,
				  'post_type'       => $post_type ,
				  'post_status'     => 'publish',
				  'post_author' => $user_id, 
				);
				$inserted_id =  wp_insert_post($new_post);
				update_post_meta($inserted_id, $status, '1');
				if (get_post_meta($inserted_id, $user_role_type.'_is_featured', true ) == "1")
				{
				}
				else
				{
					update_post_meta($inserted_id, $user_role_type.'_is_featured', '0');
				}  
				update_post_meta($inserted_id, 'prop_user_id', $user_id);
				//get user email
				$user_email = get_the_author_meta( 'user_email', $user_id );
				update_post_meta($inserted_id, $email, $user_email);
				// update against current user
				update_user_meta($user_id, 'prop_post_id', $inserted_id);
				update_user_meta($user_id, 'user_role_type', $user_role_type);
       	    }
		}
	}
}

// Assign Role To Admin
if(in_array('propertya_framework/index.php', apply_filters('active_plugins', get_option('active_plugins'))))
{
	add_action('init','propertya_framework_assign_role');
	if (!function_exists('propertya_framework_assign_role'))
	{
		function propertya_framework_assign_role()
		{
			if (is_super_admin() && is_user_logged_in())
			{
				 $current_user = wp_get_current_user();
				 $username = $current_user->display_name;
				 $user_id =  $current_user->ID;
				 $user_email =  $current_user->user_email;
				 if(get_user_meta($user_id, 'user_role_type', true) =="")
				 {
					 //time to assgin admin a role
					 propertya_framework_assign_selected_roles($username,$user_id,'agency',$user_mail);
				 }
			 }
		}
	}
}
// Walkscore Api
/*if ( ! function_exists( 'propertya_framework_getwalkscore' ) ) 
{
	function propertya_framework_getwalkscore($is_transit = false, $is_walscore = false ,$lat = '',$lon ='')
	{
		//if(!empty($lat) && !empty($lon))
		//{
			
			$status_descriptions = array(
			  1 => 'Walk shed successfully returned.',
			  2 => 'Walk shed unavailable.',
			  30 => 'Invalid latitude/longitude.',
			  31 => 'Walk Score API internal error.',
			  40 => 'Your WSAPIKEY is invalid.',
			  41 => 'Your daily API quota has been exceeded.',
    		);
			
			$lat = '47.6085';
  $lon = '-122.3295';
		    if($is_transit == true)
			{
		 		$transit_url =		"http://transit.walkscore.com/transit/score/?lat=$lat&lon=$lon&city=&state=&wsapikey=5825b4ee1dbf24496437cabd8415ee71";
				$score    = wp_remote_get($transit_url, array('timeout' => 180));
				$response = wp_remote_retrieve_body($score);
				$json = json_decode($response);
				 print_r($response);
				//return $json->status;
				return $response->status_description = $status_descriptions[$response->status];
			//	$score->status_description = $status_descriptions[$score->status];
				//print_r($score);
			}
			
		//}
	}
}
*/

//if ( ! function_exists( 'propertya_framework_getwalkscore' ) ) 
//{
//
//    function propertya_framework_getwalkscore($property_id, $latt,$lon)
//	{
//		$results = array();
//		global $propertya_options;
//		if(isset($propertya_options['prop_layout_manager']['enabled']['walk']) && $propertya_options['prop_layout_manager']['enabled']['walk']!="" && is_singular('property') && !empty($latt) && !empty($lon))
//		{
//			//print_r(get_transient('my_realwalkscore_'.$property_id));
//			
//			//if (false === (get_transient('my_realwalkscore_'.$property_id.'') ))
//			//{
//			$address = 'Vaughan';
//			$address = stripslashes($address);
//        	$address = urlencode( $address );
//
//	//$asd = '5825b4ee1dbf24496437cabd8415ee71';
//
//        $url = "http://api.walkscore.com/score?format=json&address=$address";
//        $url .= "&lat=$latt&lon=$lon&wsapikey=5825b4ee1dbf24496437cabd8415ee71";
//		
//		
//        $response = wp_remote_get( $url, array( 'timeout' => 120 ) );
//        if ( is_array( $response ) ) {
//            $body   = wp_remote_retrieve_body($response); // use the content
//            $walkscore = json_decode( $body ); // json decode
//			print_r($walkscore);
//			set_transient('my_realwalkscore_'.$property_id.'', $walkscore, 36 * 7 * HOUR_IN_SECONDS);
//			//print_r($walkscore);
//            print '<div class="walkscore_details"><img src="https://cdn.walk.sc/images/api-logo.png" alt="walkscore">';
//            print '<span>' . $walkscore->walkscore . ' / ' . $walkscore->description;
//            print ' <a href="' . $walkscore->ws_link . '" target="_blank">' . __('more details here', 'houzez') . '</a> </span></div>';
//		}
//			
//			
//			//if (false === ( $results = get_transient('my_walkscore_'.$property_id.'') ))
//			//{
//				/*$address = stripslashes('14 St James’s Square, London');
//				$api_key = 'g9e8ab0f84b9441bfb18b53b651034066';
//				$address = urlencode($address);
//				$results = wp_remote_get("http://api.walkscore.com/score?format=json&address=$address&lat=$latt&lon=$lon&wsapikey=$api_key", array( 'timeout' => 120 ));
//				if (!empty($results) && is_array($results) && count($results) > 0)
//				{
//					$get_body   = wp_remote_retrieve_body($results);
//					$walkscore = json_decode($get_body,true); 
//				}*/
//				//set_transient('my_walkscore_'.$property_id.'', $results, 36 * 7 * HOUR_IN_SECONDS);
//		//	}
//		//}
//        	
//		}
//    }
//
//}


//Get Walkscore Api Score
if ( ! function_exists( 'propertya_framework_getwalkscore' ) ) 
{
    function propertya_framework_getwalkscore($property_id, $latt,$lon,$street_address)
	{
		$walkscore = $results = array();
		global $propertya_options;
		if(isset($propertya_options['prop_layout_manager']['enabled']['walk']) && $propertya_options['prop_layout_manager']['enabled']['walk']!="" && is_singular('property') && !empty($latt) && !empty($lon))
		{
			if(isset($propertya_options['prop_walk_api_key']) && $propertya_options['prop_walk_api_key'] !="")
			{
				if(false === ($walkscore = get_transient('my_walkscore_'.$property_id.'') ))
				{
					$address = '';
					$address = $street_address;
					$address = stripslashes($address);
					$address = urlencode( $address );
					$key = $propertya_options['prop_walk_api_key'];
					$url = "http://api.walkscore.com/score?format=json&address=$address&lat=$latt&lon=$lon&wsapikey=$key";
					 $response = wp_remote_get( $url, array( 'timeout' => 120 ) );
					 if (!empty($response) && is_array( $response ) )
					 {
						$body   = wp_remote_retrieve_body($response); // use the content
						$walkscore = json_decode($body);
					 }
					 set_transient('my_walkscore_'.$property_id.'', $walkscore, 24 * HOUR_IN_SECONDS);
				}
				return $walkscore;
			}
		}
	}
}
//Walkscore Exception Handling
if ( ! function_exists( 'propertya_framework_getwalkscore_exceptions' ) ) 
{
    function propertya_framework_getwalkscore_exceptions($respose_code)
	{
		$status_descriptions = array(
		  2  => esc_html__( 'Score is being calculated and is not currently available.', 'propertya-framework' ),
		  30 => esc_html__( 'Invalid latitude/longitude.', 'propertya-framework' ),
		  40 => esc_html__( 'Your WSAPIKEY is invalid.', 'propertya-framework' ),
		  41 => esc_html__( 'Your daily API quota has been exceeded.', 'propertya-framework' ),
		  42 => esc_html__( 'Your IP address has been blocked.', 'propertya-framework' ),
		);
		return '<div class="alert custom-alert custom-alert--warning" role="alert">
		  <div class="custom-alert__top-side">
			<div class="custom-alert__body">
			  <h6 class="custom-alert__heading">
			    '.esc_html__('Whoops!.', 'propertya-framework').'
			  </h6>
			  <div class="custom-alert__content">
				'.$status_descriptions[$respose_code].'
			  </div>
			</div>
		  </div>
		</div>';
	}
}

//generate random strng for verification

if (!function_exists('propertya_randomString')) {

    function propertya_randomString($length = 50)
    {
        $str = "";
        $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }

}

//Get Attachment Types
function get_icon_for_attachment($attach_id)
{
  $type = '';
  $base = get_template_directory_uri() . "/libs/images/icons/";
  $type = get_post_mime_type($attach_id);
  //print_r($type);
 	 switch ($type) {
		case 'image/jpeg':
		return $base . "jpg.svg"; break;
		case 'image/jpg':
		return $base . "jpg.svg"; break;
		case 'image/png':
		  return $base . "png.svg"; break;
		case 'application/msword':
		return $base . "doc.svg"; break;
		case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
		return $base . "doc.svg"; break;
		case 'application/pdf':
		return $base . "pdf.svg"; break;
		default:
		return $base . "file.svg";
  }
}


//Fatch Selected Attachments For Admin Panel only
if ( ! function_exists( 'propertya_framework_get_detail_attachments' ))
{
	function propertya_framework_get_detail_attachments($attachment_id)
	{
		if(empty($attachment_id)) return;
		$thumb_imgs = $result = $media = '';
		$media = explode(',', $attachment_id);	
		if(!empty($media) && count($media) > 0)
		{
			$my_type = '';
			foreach( $media as $m )
			{
				$type_img = $attach_id = '';
				$attach_id =  $m;
				$my_type = get_post_mime_type($attach_id);
				$data_attr = '';
				if($my_type == 'image/jpeg' || $my_type == 'image/jpg' || $my_type == 'image/png')
				{
					$data_attr = 'data-fancybox=images';
				}
				$result .= '<div class="attachments-container">
				<div class="attachment-type">
					<img  src="'.get_icon_for_attachment($attach_id).'" class="img-fluid" alt="">  
				</div>				
				<a '.esc_attr($data_attr).' href="'.wp_get_attachment_url($attach_id).'" class="attachment-file-title" target="_blank">
					'.get_the_title($attach_id).'
				</a>
                <span class="fize-size">'.esc_html__('File Size', 'propertya-framework').': '.size_format(filesize(get_attached_file($attach_id))).'</span>						
				<div class="attachment-download">
					<a '.esc_attr($data_attr).' href="'.wp_get_attachment_url($attach_id).'" target="_blank">
						<i class="fas fa-download"></i>
					</a>
				</div>				
			</div>';
			}
		}
		return  $result;
	}
}


// Track User Activity
if (!function_exists('propertya_framework_track_activity'))
{
    function propertya_framework_track_activity($property_id, $activity_type, $value, $comment_id = '')
	{
        //global $dwt_listing_options;

        //if leads tracking is enabled
       // if (isset($dwt_listing_options['dwt_listing_enable_leads']) && $dwt_listing_options['dwt_listing_enable_leads'] == '1'//) {
            $user_id = get_current_user_id();
            if ($value != "") {
                $date = date('Y-m-d H:i:s',current_time( 'timestamp', 0));
                if ($user_id != "") {
                    if (isset($comment_id) && $comment_id != "") {
                        add_post_meta($property_id, '_activity_' . $activity_type . '_userid_' . $user_id . $comment_id, $date . '_' . $value);
                    } else {
                        add_post_meta($property_id, '_activity_' . $activity_type . '_userid_' . $user_id, $date . '_' . $value);
                    }
                } else {
                    add_post_meta($property_id, '_activity_' . $activity_type . '_userid_unknown', $date . '_' . $value);
                }
            }
        }
   // }

}


// Theme Social Share
if (!function_exists('propertya_framework_themesocial_shares'))
{
    function propertya_framework_themesocial_shares($id,$type)
	{
		if(!empty($id))
		{
			$theme_name  = wp_get_theme();
			$url = urlencode(get_permalink($id));
			$title = htmlspecialchars(urlencode(html_entity_decode(get_the_title($id), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');
			$img_url = '';
			$thumb = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'full');
			if(!empty($thumb) && is_array($thumb))
			{
				$img_url = $thumb[0];
			}
			$pin_link = $insta_link = $in_lin = $tw_link = $fb_link = $pin = $you = $insta = $in = $tw = $fb = '';
			$key = 'agent';
			if($type == 'agency')
			{
				$key = 'agency';
			}
			
			$fb = get_post_meta($id, $key.'_fb', true );
			$tw = get_post_meta($id, $key.'_tw', true );
			$in = get_post_meta($id, $key.'_in', true );
			$insta = get_post_meta($id, $key.'_insta', true );
			$pin = get_post_meta($id, $key.'_pin', true );
			if(!empty($fb))
			{
				$fb_link = '<li><a target="_blank" href="http://www.facebook.com/sharer.php?u='.$url.'"><i class="fab fa-facebook-f"></i></a></li>';
			}
			if(!empty($tw))
			{
				$tw_link = '<li><a target="_blank" href="https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$tw.'&amp;via='.$title.'"><i class=" fab fa-twitter"></i></a></li>';
			}
			if(!empty($in))
			{
				$in_lin = '<li><a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url='.$in.'&title='.$title.'"><i class="fab fa-linkedin-in"></i></a></li>';
			}
			if(!empty($insta))
			{
				$insta_link = '<li><a target="_blank" href="https://www.instagram.com/?url='.esc_url($insta).'"><i class=" fab fa-instagram"></i></a></li>';
			}
			if(!empty($pin))
			{
					$pinterestURL = 'https://pinterest.com/pin/create/button/?url='.esc_url($pin).'&amp;media='.$img_url.'&amp;description='.get_the_content($id);
				
				$pin_link ='<li><a target="_blank" href="'.esc_url($pinterestURL).'"><i class=" fab fa-pinterest-p"></i></a></li>';
			}
			if(!empty($fb) || !empty($tw) || !empty($in) || !empty($insta) || !empty($pin))
			{
				return '<ul class="listing-owner-social">
						'.$fb_link.'
						'.$tw_link.'
						'.$in_lin.'
						'.$insta_link.'
						'.$pin_link.'
					    </ul>';
			}
		}
	}
}

// Theme Social Share
if (!function_exists('propertya_framework_no_result_found'))
{
    function propertya_framework_no_result_found()
	{
		return '<div class="col-xl-12 col-lg-12 col-sm-12 col-12"><div class="nothing-found"><h3>'.esc_html__('Sorry!!! No Record Found','propertya-framework').'</h3>
           <img src="'.esc_url(SB_PLUGIN_URL."libs/images/nothing-found.png").'" alt="" class="img-fluid"></div></div>';
	}
}

if (!function_exists('propertya_framework_only_logged_in_user'))
{
    function propertya_framework_only_logged_in_user()
	{
		return '<section class="error-page-section section-padding not-authorized">
				<div class="container">
					<div class="row align-items-center">
					<div class="col-lg-7 col-12">
						<div class="error-page-content">
							<h2>Oops! You Are Not Authorized</h2>
							<p>Sorry!!! Only Logged In Users Can View This Page</p>
							<a href="'. esc_url( home_url( '/' ) ).'" class="btn btn-theme"><i class="fas fa-home"></i>  '.esc_html__('  Go to Home', 'propertya-framework' ).'</a>
						</div>
					</div>
					<div class="col-lg-5 col-12">
						<div class="error-thumbnail text-right">
							<img alt="" class="img-fluid" src="'.esc_url(SB_PLUGIN_URL."libs/images/authorized.png").'">
						</div>
					</div>
				   </div>
			   </div>
		</section>';
	}
}


//Terms for shortcode
if ( ! function_exists( 'propertya_framework_term_html' ) )
{
	function propertya_framework_term_html($term_name, &$data)
	{
			$term_arg = get_terms( array(
				'taxonomy'   => $term_name,
				'hide_empty' => false,
			));

		return	propertya_framework_term_html_child($term_name,'0',$term_arg,$data);
	}
}
if ( ! function_exists( 'propertya_framework_term_html_child' ) )
{
	function propertya_framework_term_html_child( $term_name, $term_parent = '', $term_arg, &$data, $separator = " " )
	{
		if (!empty($term_arg) && is_array($term_arg) && count($term_arg) > 0)
		{
			$data.= '<option value="">' .esc_html__('Select an option','propertya-framework').'</option>';
			foreach ($term_arg as $term)
			{
				if ( $term->parent == $term_parent )
				{
					$data.= '<option value="' . $term->slug . '">' . $separator . $term->name . ' (' . $term->count . ')'. '</option>';
					propertya_framework_term_html_child( $term_name, $term->term_id , $term_arg, $data, "- " . $separator );
				}
			}
			
			
		}
		return $data ;
	}
}





//Terms for shortcode
if ( ! function_exists( 'propertya_framework_terms_array' ) )
{
	function propertya_framework_terms_array($term_name, &$data)
	{
			$term_arg = get_terms( array(
				'taxonomy'   => $term_name,
				'hide_empty' => false,
			));
			propertya_framework_terms_array_childs($term_name,'0',$term_arg,$data);
	}
}
if ( ! function_exists( 'propertya_framework_terms_array_childs' ) )
{
	function propertya_framework_terms_array_childs( $term_name, $term_parent = '', $term_arg='', & $data ='', $separator = " " )
	{
		if (!empty($term_arg) && is_array($term_arg) && count($term_arg) > 0)
		{
			foreach ($term_arg as $term)
			{
				if ( $term->parent == $term_parent )
				{
					$data[ $term->slug ] = $separator . $term->name  . ' (' . $term->count . ')';
					propertya_framework_terms_array_childs( $term_name, $term->term_id , $term_arg, $data, "- " . $separator );
				}
			}
		}
	}
}

//Search on Taxnomy Page
if ( ! function_exists( 'propertya_framework_property_search' ) )
{
	function propertya_framework_property_search($paged)
	{
		$tax_query = '';
        $custom_location = '';
        $queried_object = get_queried_object();
	
        if (!empty($queried_object) && count((array)$queried_object) > 0)
		{
            $term_id = $queried_object->term_id;
            $tax_name = $queried_object->taxonomy;
            if (!empty($term_id))
			{
                $term_idz = get_term_by('id', $term_id, $tax_name);
                $termName = $term_idz->name;
                $term_id = $term_idz->term_id;
            }
			$tax_query = array(
                array(
                    'taxonomy' => $tax_name,
                    'field' => 'term_id',
                    'terms' => array($term_id, $tax_name),
                ),
            );
		}
		$args	=	array
		(
			'post_type' => 'property',
			'post_status' => 'publish',
			'posts_per_page' => get_option('posts_per_page'),
			'paged' => $paged,
			'tax_query' => array(
                $tax_query,
            ),
            'fields' => 'ids',
			'meta_key' => 'prop_is_feature_listing',
			'orderby'  => array(
				'meta_value' => 'DESC',
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
		return $args;
	}
}
if ( ! function_exists( 'propertya_generate_code_registeration' ) ) 
{
	function propertya_generate_code_registeration($user_id)
	{
		if(propertya_framework_get_options('propertya_new_user_email_verification') !== null && propertya_framework_get_options('propertya_new_user_email_verification') == true)
		{
			print_r("");
			die;
			$code = '';
			$length = 30;
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			for ($i = 0; $i < $length; $i++) {
				$code .= $characters[rand(0, $charactersLength - 1)];
			}

			$string = array('id'=>$user_id, 'code'=>$code);

			//update_user_meta($user_id, '_propertya_account_activated', 0);
			update_user_meta($user_id, '_user_activation_code', $code);

			$signinlink = get_home_url();
			$verification_link = esc_url($signinlink.'?activation_key=' .base64_encode( serialize($string)));

			propertya_account_activation_email($user_id,$verification_link);

		}
			
	}
}

add_action('wp_ajax_propertya_resend_activation_email', 'propertya_resend_activation_email');
if ( ! function_exists( 'propertya_resend_activation_email' ) ) 
{
	function propertya_resend_activation_email()
	{
		$user_id = get_current_user_id();
		if(isset($user_id) && $user_id != '')
		{
			$now = time();
			$startDateTime = date('d-m-Y H:i:s', $now);

			$stored_dateTime = date('d-m-Y H:i:s',strtotime('+6 minutes',strtotime($startDateTime)));
			update_user_meta($user_id, '_verify_email_resend_time', $stored_dateTime);
			propertya_generate_code_registeration($user_id);
			$return = array('message' => esc_html__( 'Activation email sent.', 'propertya_framework' ));
			wp_send_json_success($return);
		}
		else
		{
			$return = array('message' => esc_html__( 'Activation email is not sent. Please contact admin', 'propertya_framework' ));
			wp_send_json_error($return);
		}
	}
}
//New Code Rewrite URL
add_filter('register_post_type_args', 'propertya_register_post_type_args', 10, 2);
if (!function_exists('propertya_register_post_type_args')) {

    function propertya_register_post_type_args($args, $post_type) {
    		$propertya_framework_get_options = get_option('propertya_options');
    		
    	if(isset($propertya_framework_get_options['prop_url_rewriting_enable']) !="" && $propertya_framework_get_options['prop_url_rewriting_enable'] == 1 && $propertya_framework_get_options['prop_ad_slug'] !=''){

            if ($post_type === 'property') {
                $old_slug = 'property';
                if (get_option('prop_ad_old_slug') != "") {
                    $old_slug = get_option('prop_ad_old_slug');
                }
                $args['rewrite']['slug'] = $propertya_framework_get_options['prop_ad_slug'];
                update_option('prop_ad_old_slug', $propertya_framework_get_options['prop_ad_slug']);
                if (($current_rules = get_option('rewrite_rules'))) {
                    foreach ($current_rules as $key => $val) {
                        if (strpos($key, $old_slug) !== false) {
                            add_rewrite_rule(str_ireplace($old_slug, $propertya_framework_get_options['prop_ad_slug'], $key), $val, 'top');
                        }
                    }
                   // flush_rewrite_rules();
                }
            }
        }
      flush_rewrite_rules();
        return $args;
    }

}

//location
add_filter('register_taxonomy_args', 'propertya_register_location_args', 10, 2);
if (!function_exists('propertya_register_location_args')) {

    function propertya_register_location_args($args, $taxonomy) {
    		$propertya_framework_get_options = get_option('propertya_options');
    		
    	if(isset($propertya_framework_get_options['prop_url_rewriting_enable_location']) !="" && $propertya_framework_get_options['prop_url_rewriting_enable_location'] == 1 && $propertya_framework_get_options['prop_ad_location_slug'] !=''){

            if ($taxonomy == 'property_location') {
            	
                $old_slug = 'location';
                if (get_option('prop_ad_location_old_slug') != "") {
                    $old_slug = get_option('prop_ad_location_old_slug');
                    
                }
                $args['rewrite']['slug'] = $propertya_framework_get_options['prop_ad_location_slug'];
                update_option('prop_ad_location_old_slug', $propertya_framework_get_options['prop_ad_location_slug']);
                if (($current_rules = get_option('rewrite_rules'))) {
                	
                    foreach ($current_rules as $key => $val) {
                        if (strpos($key, $old_slug) !== false) {
                        	;
                            add_rewrite_rule(str_ireplace($old_slug, $propertya_framework_get_options['prop_ad_location_slug'], $key), $val, 'top');
                           
                        }
                    }
                   // flush_rewrite_rules();
                }
            }
        }
      flush_rewrite_rules();
        return $args;
    }

}
//category
add_filter('register_taxonomy_args', 'propertya_register_type_args', 10, 2);
if (!function_exists('propertya_register_type_args')) {

    function propertya_register_type_args($args, $taxonomy) {
    		$propertya_framework_get_options = get_option('propertya_options');
    		
    	if(isset($propertya_framework_get_options['prop_url_rewriting_enable_cat']) !="" && $propertya_framework_get_options['prop_url_rewriting_enable_cat'] == 1 && $propertya_framework_get_options['prop_cat_slug'] !=''){

            if ($taxonomy == 'property_type') {
            	
                $old_slug = 'property_type';
                if (get_option('prop_ad_type_old_slug') != "") {
                    $old_slug = get_option('prop_ad_type_old_slug');
                    
                }
                $args['rewrite']['slug'] = $propertya_framework_get_options['prop_cat_slug'];
                update_option('prop_ad_type_old_slug', $propertya_framework_get_options['prop_cat_slug']);
                if (($current_rules = get_option('rewrite_rules'))) {
                	
                    foreach ($current_rules as $key => $val) {
                        if (strpos($key, $old_slug) !== false) {
                        	;
                            add_rewrite_rule(str_ireplace($old_slug, $propertya_framework_get_options['prop_cat_slug'], $key), $val, 'top');
                           
                        }
                    }
                   // flush_rewrite_rules();
                }
            }
        }
      flush_rewrite_rules();
        return $args;
    }

}
//labels
add_filter('register_taxonomy_args', 'propertya_register_tag_args', 10, 2);
if (!function_exists('propertya_register_tag_args')) {

    function propertya_register_tag_args($args, $taxonomy) {
    		$propertya_framework_get_options = get_option('propertya_options');
    		
    	if(isset($propertya_framework_get_options['prop_url_rewriting_enable_ad_tags']) !="" && $propertya_framework_get_options['prop_url_rewriting_enable_ad_tags'] == 1 && $propertya_framework_get_options['prop_ad_tags_slug'] !=''){

            if ($taxonomy == 'property_label') {
            	
                $old_slug = 'property_label';
                if (get_option('prop_ad_label_old_slug') != "") {
                    $old_slug = get_option('prop_ad_label_old_slug');
                   
                }
                $args['rewrite']['slug'] = $propertya_framework_get_options['prop_ad_tags_slug'];
                update_option('prop_ad_label_old_slug', $propertya_framework_get_options['prop_ad_tags_slug']);
                if (($current_rules = get_option('rewrite_rules'))) {
                	
                    foreach ($current_rules as $key => $val) {
                        if (strpos($key, $old_slug) !== false) {
                        	;
                            add_rewrite_rule(str_ireplace($old_slug, $propertya_framework_get_options['prop_ad_tags_slug'], $key), $val, 'top');
                           
                        }
                    }
                   // flush_rewrite_rules();
                }
            }
        }
      flush_rewrite_rules();
        return $args;
    }

}
/*======================================================================================================*/

// for agents ads
add_filter('register_post_type_args', 'agent_register_post_type_args', 10, 2);
if (!function_exists('agent_register_post_type_args')) {

    function agent_register_post_type_args($args, $post_type) {

    	$propertya_framework_get_options = get_option('propertya_options');

    	
	if(isset($propertya_framework_get_options['prop_agent_url_rewriting_enable']) !="" && $propertya_framework_get_options['prop_agent_url_rewriting_enable'] == 1 && $propertya_framework_get_options['prop_agent_ad_slug'] !=''){

            if ($post_type === 'property-agents') {
                $old_slug = 'agent';
                if (get_option('prop_agent_ad_old_slug') != "") {
                    $old_slug = get_option('prop_agent_ad_old_slug');
                    
                }
                
                $args['rewrite']['slug'] = $propertya_framework_get_options['prop_agent_ad_slug'];
                update_option('prop_agent_ad_old_slug', $propertya_framework_get_options['prop_agent_ad_slug']);
                if (($current_rules = get_option('rewrite_rules'))) {
                    foreach ($current_rules as $key => $val) {
                        if (strpos($key, $old_slug) !== false) {
                            add_rewrite_rule(str_ireplace($old_slug, $propertya_framework_get_options['prop_agent_ad_slug'], $key), $val, 'top');
                            
                        }
                     }
                       //flush_rewrite_rules();
                    
                }
            }
        }
        flush_rewrite_rules();
         return $args;
        
    	}
    }
  
// agent category
add_filter('register_taxonomy_args', 'propertya_register_agent_cat_args', 10, 2);
if (!function_exists('propertya_register_agent_cat_args')) {

    function propertya_register_agent_cat_args($args, $taxonomy) {
    		$propertya_framework_get_options = get_option('propertya_options');
    		
    	if(isset($propertya_framework_get_options['prop_agent_url_rewriting_enable_typ']) !="" && $propertya_framework_get_options['prop_agent_url_rewriting_enable_typ'] == 1 && $propertya_framework_get_options['prop_agent_typ_slug'] !=''){

            if ($taxonomy == 'agent_types') {
            	
                $old_slug = 'agent_types';
                if (get_option('agent_typ_old_slug') != "") {
                    $old_slug = get_option('agent_typ_old_slug');
                    
                }
                $args['rewrite']['slug'] = $propertya_framework_get_options['prop_agent_typ_slug'];
                update_option('agent_typ_old_slug', $propertya_framework_get_options['prop_agent_typ_slug']);
                if (($current_rules = get_option('rewrite_rules'))) {
                	
                    foreach ($current_rules as $key => $val) {
                        if (strpos($key, $old_slug) !== false) {
                        	;
                            add_rewrite_rule(str_ireplace($old_slug, $propertya_framework_get_options['prop_agent_typ_slug'], $key), $val, 'top');
                           
                        }
                    }
                   // flush_rewrite_rules();
                }
            }
        }
      flush_rewrite_rules();
        return $args;
    }

}
// agent loc
add_filter('register_taxonomy_args', 'propertya_register_agent_loc_args', 10, 2);
if (!function_exists('propertya_register_agent_loc_args')) {

    function propertya_register_agent_loc_args($args, $taxonomy) {
    		$propertya_framework_get_options = get_option('propertya_options');
    		
    	if(isset($propertya_framework_get_options['prop_agent_url_rewriting_enable_location']) !="" && $propertya_framework_get_options['prop_agent_url_rewriting_enable_location'] == 1 && $propertya_framework_get_options['prop_agent_ad_location_slug'] !=''){

            if ($taxonomy == 'agent_location') {
            	
                $old_slug = 'agent_location';
                if (get_option('agent_loc_old_slug') != "") {
                    $old_slug = get_option('agent_loc_old_slug');
                    
                }
                $args['rewrite']['slug'] = $propertya_framework_get_options['prop_agent_ad_location_slug'];
                update_option('agent_loc_old_slug', $propertya_framework_get_options['prop_agent_ad_location_slug']);
                if (($current_rules = get_option('rewrite_rules'))) {
                	
                    foreach ($current_rules as $key => $val) {
                        if (strpos($key, $old_slug) !== false) {
                        	
                            add_rewrite_rule(str_ireplace($old_slug, $propertya_framework_get_options['prop_agent_ad_location_slug'], $key), $val, 'top');
                          
                        }
                    }
                   // flush_rewrite_rules();
                }
            }
        }
      flush_rewrite_rules();
        return $args;
    }

}
/* =============================================================================================================*/
  //agency ads
add_filter('register_post_type_args', 'agency_register_post_type_args', 10, 2);
if (!function_exists('agency_register_post_type_args')) {

    function agency_register_post_type_args($args, $post_type) {

    	$propertya_framework_get_options = get_option('propertya_options');
    	 // for agency

        	if(isset($propertya_framework_get_options['agency_url_rewriting_enable']) !="" && $propertya_framework_get_options['agency_url_rewriting_enable'] == 1 && $propertya_framework_get_options['agency_ad_slug'] !=''){

            if ($post_type === 'property-agency') {
                $old_slug = 'agency';
                if (get_option('agency_ad_old_slug') != "") {
                    $old_slug = get_option('agency_ad_old_slug');
                }
                $args['rewrite']['slug'] = $propertya_framework_get_options['agency_ad_slug'];
                update_option('agency_ad_old_slug', $propertya_framework_get_options['agency_ad_slug']);
                if (($current_rules = get_option('rewrite_rules'))) {
                    foreach ($current_rules as $key => $val) {
                        if (strpos($key, $old_slug) !== false) {
                            add_rewrite_rule(str_ireplace($old_slug, $propertya_framework_get_options['agency_ad_slug'], $key), $val, 'top');
                        }
                    }
                    //flush_rewrite_rules();
                }
            }
        }
        flush_rewrite_rules();
         return $args;
    }
}

// agency loc add
add_filter('register_taxonomy_args', 'propertya_register_agency_loc_args', 10, 2);
if (!function_exists('propertya_register_agency_loc_args')) {

    function propertya_register_agency_loc_args($args, $taxonomy) {
    		$propertya_framework_get_options = get_option('propertya_options');
    		
    	if(isset($propertya_framework_get_options['agency_url_rewriting_enable_loc'] )!="" && $propertya_framework_get_options['agency_url_rewriting_enable_loc'] == 1 && $propertya_framework_get_options['agency_loc_slug'] !=''){

            if ($taxonomy == 'agency_location') {
            	
                $old_slug = 'agency_location';
                if (get_option('agency_old_slug') != "") {
                    $old_slug = get_option('agency_old_slug');
                    
                }
                $args['rewrite']['slug'] = $propertya_framework_get_options['agency_loc_slug'];
                update_option('agency_old_slug', $propertya_framework_get_options['agency_loc_slug']);
                if (($current_rules = get_option('rewrite_rules'))) {
                	
                    foreach ($current_rules as $key => $val) {
                        if (strpos($key, $old_slug) !== false) {
                        	;
                            add_rewrite_rule(str_ireplace($old_slug, $propertya_framework_get_options['agency_loc_slug'], $key), $val, 'top');
                           
                        }
                    }
                   // flush_rewrite_rules();
                }
            }
        }
      flush_rewrite_rules();
        return $args;
    }

}
//Privious Code Rewrite URL
// add_filter('register_post_type_args', 'propertya_register_post_type_args', 10, 2);
// if (!function_exists('propertya_register_post_type_args')) {
//     function propertya_register_post_type_args($args, $post_type) {
//     	if(propertya_framework_get_options('prop_url_rewriting_enable') !="" && propertya_framework_get_options('prop_url_rewriting_enable') == 1 && propertya_framework_get_options('prop_ad_slug') !=''){

//             if ($post_type === 'property') {
//                 $old_slug = 'property';
//                 if (get_option('prop_ad_old_slug') != "") {
//                     $old_slug = get_option('prop_ad_old_slug');
//                 }
//                 $args['rewrite']['slug'] = propertya_framework_get_options('prop_ad_slug');
//                 update_option('prop_ad_old_slug', propertya_framework_get_options('prop_ad_slug'));
//                 if (($current_rules = get_option('rewrite_rules'))) {
//                     foreach ($current_rules as $key => $val) {
//                         if (strpos($key, $old_slug) !== false) {
//                             add_rewrite_rule(str_ireplace($old_slug, propertya_framework_get_options('prop_ad_slug'), $key), $val, 'top');
//                         }
//                     }
//                     flush_rewrite_rules();
//                 }
//             }
//         }

//         return $args;
//     }

// }