<?php
if(in_array('propertya-elementor/sonutheme-elementor.php', apply_filters('active_plugins',get_option('active_plugins'))))
{
if (!function_exists('propertya_framework_color_text'))
{
	function propertya_framework_color_text($str)
	{
		preg_match('~{color}([^{]*){/color}~i', $str, $match);
		if (isset($match[1]))
		{
			$search = "{color}" . $match[1] . "{/color}";
			$replace = '<span class="clr-theme">' . $match[1] . '</span>';
			$str = str_replace($search, $replace, $str);	
		}
		return $str;
	}
}
if (!function_exists('propertya_framework_section_headings'))
{
	function propertya_framework_section_headings($subtitle = '', $maintitle = '', $style = '')
	{
		if(!empty($subtitle) || !empty($maintitle))
		{
			$is_margin = $is_centered = $main_title = $sub_title = '';
			if(!empty($subtitle)) 
			{
				$sub_title = '<p>'.esc_html($subtitle).'</p>';
			}
			if(!empty($maintitle)) 
			{
				$main_title = '<h2>'.esc_html($maintitle).'</h2>';
			}
			$is_centered = 'text-center';
			$is_margin = 'mx-auto';
			if(!empty($style) && $style == 'left') 
			{
				$is_centered = '';
				$is_margin = '';
			}
			return '<div class="row sec-heading-zone">
								<div class="col '.esc_attr($is_centered).'">
									<div class="sec-heading '.esc_attr($is_margin).'">
										'.$sub_title.'
										'.$main_title.'
									</div>
								</div>
							</div>';
		}
	}
}
if (!function_exists('propertya_framework_render_filters'))
{
	function propertya_framework_render_filters($params)
	{
		$filters = '';
		if(!empty($params) && is_array($params) && count($params) > 0)
		{
			$fields = [
				'keyword' =>'by_title', 
				'type' => 'property-type', 
				'offer' =>'offer-type', 
				'label'=>'label-type', 
				'location' =>'location-by', 
				'currency' =>'currency-type',
				'bed'=>'type-beds', 
				'bath' =>'type-bath', 
        	];
			$filters = '';
			foreach ($params as $item )
			{
				 if($item['filter_type'] == "keyword")
				 {
					$filters .= '<div class="form-group">
								  <label>'.esc_html($item['field_label']).'</label>
								  <div class="typeahead__container custom-style-frontend">
								  <div class="typeahead__field">
								  <div class="typeahead__query">
								  <input type="text" class="prop_get_smple form-control is_smple" name="'.esc_attr($fields[$item['filter_type']]).'" autocomplete="off" value="" placeholder="'.esc_attr($item['field_place']).'">
								  </div>
								  </div>
								  </div>
							    </div>';
				 }
				 if($item['filter_type'] == "type")
				 {
					 $property_type = '';
					 propertya_framework_term_html('property_type' , $property_type);
					 $filters .= '<div class="form-group">
								  <label>'.esc_html($item['field_label']).'</label>
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
								'.$property_type.'
								  </select>
								  </div>';
				 }
				 if($item['filter_type'] == "offer")
				 {
					 $offer = '';
					 propertya_framework_term_html('property_status' , $offer);
					 $filters .= '<div class="form-group">
							  <label>'.esc_html($item['field_label']).'</label>
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
								'.$offer.'
								  </select>
								  </div>';
				 }
				 if($item['filter_type'] == "label")
				 {
					 $property_label = '';
					 propertya_framework_term_html('property_label' , $property_label);
					 $filters .= '<div class="form-group">
							  <label>'.esc_html($item['field_label']).'</label>
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
								'.$property_label.'
								  </select>
								  </div>';
				 }
				 if($item['filter_type'] == "location")
				 {
					 $property_location = '';
					 propertya_framework_term_html('property_location' , $property_location);
					 $filters .= '<div class="form-group">
							  <label>'.esc_html($item['field_label']).'</label>
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
								'.$property_location.'
								  </select>
								  </div>';
				 }
				 if($item['filter_type'] == "currency")
				 {
					$options = $selected_cur = '';
					$custom_currency = propertya_framework_term_fetch('property_currency',0);
					if(!empty($custom_currency) && count((array) $custom_currency) > 0 && !is_wp_error($custom_currency))
					{
						$p_currency_sym = $p_currency_code = $options = '';
						foreach($custom_currency as $currency)
						{
							$selected_cur = '';
							if(!empty($selected_currency) && $selected_currency == $currency->slug)
							{
								$selected_cur = 'selected="selected"';
							}
							if(get_term_meta( $currency->term_id, 'p_currency_code', true ) !="")
							{
								$p_currency_code = get_term_meta( $currency->term_id, 'p_currency_code', true );
								$p_currency_sym = get_term_meta( $currency->term_id, 'p_currency_sym', true );
								$options .= '<option value="' . $currency->slug. '" '.$selected_cur.'>' . $p_currency_code .' ( ' . $p_currency_sym . ' )'. '</option>';
							}
							else
							{
								$options .= '<option value="' . $currency->slug. '" '.$selected_cur.'>' . $currency->name . '</option>';
							}
						}
					}
					 $filters .= '<div class="form-group">
							  <label>'.esc_html($item['field_label']).'</label>
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
								  <option value="">' .esc_html__('Any','propertya-framework').'</option>
								'.$options.'
								  </select>
								  </div>';
				 }
				 if($item['filter_type'] == "bed")
				 {
					 $filters .= '<div class="form-group">
							  <label>'.esc_html($item['field_label']).'</label>
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
									<option value="">' .esc_html__('Any','propertya-framework').'</option>
									<option value="1">1+</option>
									<option value="2">2+</option>
									<option value="3">3+</option>
									<option value="4">4+</option>
									<option value="5">5+</option>
								</select>
								  </div>';
				 }
				 if($item['filter_type'] == "bath")
				 {
					 $offer = '';
					 propertya_framework_term_html('property_status' , $offer);
					 $filters .= '<div class="form-group">
							  <label>'.esc_html($item['field_label']).'</label>
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
									<option value="">' .esc_html__('Any','propertya-framework').'</option>
									<option value="1">1+</option>
									<option value="2">2+</option>
									<option value="3">3+</option>
									<option value="4">4+</option>
									<option value="5">5+</option>
								  </select>
								  </div>';
				 }
				 if($item['filter_type'] == "price" || $item['filter_type'] == "area")
				 {
					if($item['filter_type'] == "price")
					{
						$min = 'min-price';
						$max = 'max-price';
					}
					else
					{
						$min = 'min-area';
						$max = 'max-area';
					} 
					$filters .= '<div class="form-group">
					 <label>'.esc_html($item['field_label']).'</label>
					  <div class="input-group">
						<input type="text" class="form-control" name="'.esc_attr($min).'" placeholder="'.esc_attr($item['min_label']).'" value="">
						<div class="input-group-prepend input-group-append">
						  <span class="input-group-text">-</span>
						</div>
						<input type="text" class="form-control" name="'.esc_attr($max).'" placeholder="'.esc_attr($item['max_label']).'" value="">
					  </div>
				   </div>';
				 }
			}
		}
		return $filters;
	}
}
if (!function_exists('propertya_framework_render_filters_style_two'))
{
	function propertya_framework_render_filters_style_two($params)
	{
		$filters = '';
		if(!empty($params) && is_array($params) && count($params) > 0)
		{
			$fields = [
				'keyword' =>'by_title', 
				'type' => 'property-type', 
				'offer' =>'offer-type', 
				'label'=>'label-type', 
				'location' =>'location-by', 
				'currency' =>'currency-type',
				'bed'=>'type-beds', 
				'bath' =>'type-bath', 
        	];
			$filters = '';
			$count= 1;
			foreach ($params as $item )
			{
				$class= 'first';
				if($count == '2')
				{
					$class= 'second';
				}
				 if($item['filter_type'] == "keyword")
				 {
					$filters .= '<div class="input-field '.esc_attr($class).'">
								   <label class="mb-0">'.esc_html($item['field_label']).'</label>
								  <div class="typeahead__container custom-style-frontend">
								  <div class="typeahead__field">
								  <div class="typeahead__query">
								  <input type="text" class="prop_get_smple form-control is_smple" name="'.esc_attr($fields[$item['filter_type']]).'" autocomplete="off" value="" placeholder="'.esc_attr($item['field_place']).'">
								  </div>
								  </div>
								  </div>
							    </div>';
				 }
				 if($item['filter_type'] == "type")
				 {
					 $property_type = '';
					 propertya_framework_term_html('property_type' , $property_type);
					 $filters .= '<div class="input-field '.esc_attr($class).'">
								   <label class="mb-0">'.esc_html($item['field_label']).'</label>
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
								'.$property_type.'
								  </select>
								  </div>';
				 }
				 if($item['filter_type'] == "offer")
				 {
					 $offer = '';
					 propertya_framework_term_html('property_status' , $offer);
					 $filters .= '<div class="input-field '.esc_attr($class).'">
							   <label class="mb-0">'.esc_html($item['field_label']).'</label>
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
								'.$offer.'
								  </select>
								  </div>';
				 }
				 if($item['filter_type'] == "label")
				 {
					 $property_label = '';
					 propertya_framework_term_html('property_label' , $property_label);
					 $filters .= '<div class="input-field '.esc_attr($class).'">
							   <label class="mb-0">'.esc_html($item['field_label']).'</label>
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
								'.$property_label.'
								  </select>
								  </div>';
				 }
				 if($item['filter_type'] == "location")
				 {
					 $property_location = '';
					 propertya_framework_term_html('property_location' , $property_location);
					 $filters .= '<div class="input-field '.esc_attr($class).'">
							   <label class="mb-0">'.esc_html($item['field_label']).'</label>
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
								'.$property_location.'
								  </select>
								  </div>';
				 }
				 if($item['filter_type'] == "currency")
				 {
					$options = $selected_cur = '';
					$custom_currency = propertya_framework_term_fetch('property_currency',0);
					if(!empty($custom_currency) && count((array) $custom_currency) > 0 && !is_wp_error($custom_currency))
					{
						$p_currency_sym = $p_currency_code = $options = '';
						foreach($custom_currency as $currency)
						{
							$selected_cur = '';
							if(!empty($selected_currency) && $selected_currency == $currency->slug)
							{
								$selected_cur = 'selected="selected"';
							}
							if(get_term_meta( $currency->term_id, 'p_currency_code', true ) !="")
							{
								$p_currency_code = get_term_meta( $currency->term_id, 'p_currency_code', true );
								$p_currency_sym = get_term_meta( $currency->term_id, 'p_currency_sym', true );
								$options .= '<option value="' . $currency->slug. '" '.$selected_cur.'>' . $p_currency_code .' ( ' . $p_currency_sym . ' )'. '</option>';
							}
							else
							{
								$options .= '<option value="' . $currency->slug. '" '.$selected_cur.'>' . $currency->name . '</option>';
							}
						}
					}
					 $filters .= '<div class="input-field '.esc_attr($class).'">
							   <label class="mb-0">'.esc_html($item['field_label']).'</label>
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
								  <option value="">' .esc_html__('Any','propertya-framework').'</option>
								'.$options.'
								  </select>
								  </div>';
				 }
				 if($item['filter_type'] == "bed")
				 {
					 $filters .= '<div class="input-field '.esc_attr($class).'">
							   <label class="mb-0">'.esc_html($item['field_label']).'</label>
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
									<option value="">' .esc_html__('Any','propertya-framework').'</option>
									<option value="1">1+</option>
									<option value="2">2+</option>
									<option value="3">3+</option>
									<option value="4">4+</option>
									<option value="5">5+</option>
								</select>
								  </div>';
				 }
				 if($item['filter_type'] == "bath")
				 {
					 $offer = '';
					 propertya_framework_term_html('property_status' , $offer);
					 $filters .= '<div class="input-field '.esc_attr($class).'">
							   <label class="mb-0">'.esc_html($item['field_label']).'</label>
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
									<option value="">' .esc_html__('Any','propertya-framework').'</option>
									<option value="1">1+</option>
									<option value="2">2+</option>
									<option value="3">3+</option>
									<option value="4">4+</option>
									<option value="5">5+</option>
								  </select>
								  </div>';
				 }
				 if($item['filter_type'] == "price" || $item['filter_type'] == "area")
				 {
					if($item['filter_type'] == "price")
					{
						$min = 'min-price';
						$max = 'max-price';
					}
					else
					{
						$min = 'min-area';
						$max = 'max-area';
					} 
					$filters .= '<div class="input-field '.esc_attr($class).'">
					  <label class="mb-0">'.esc_html($item['field_label']).'</label>
					  <div class="input-group">
						<input type="text" class="form-control" name="'.esc_attr($min).'" placeholder="'.esc_attr($item['min_label']).'" value="">
						<div class="input-group-prepend input-group-append">
						  <span class="input-group-text">-</span>
						</div>
						<input type="text" class="form-control" name="'.esc_attr($max).'" placeholder="'.esc_attr($item['max_label']).'" value="">
					  </div>
				   </div>';
				 }
				 $count++;
				 if($count == 3)
				 {
					break; 
				 }
			}
		}
		return $filters;
	}
}
if (!function_exists('propertya_framework_render_filters_style_two'))
{
	function propertya_framework_render_filters_style_two($params)
	{
		$filters = '';
		if(!empty($params) && is_array($params) && count($params) > 0)
		{
			$fields = [
				'keyword' =>'by_title', 
				'type' => 'property-type', 
				'offer' =>'offer-type', 
				'label'=>'label-type', 
				'location' =>'location-by', 
				'currency' =>'currency-type',
				'bed'=>'type-beds', 
				'bath' =>'type-bath', 
        	];
			$filters = '';
			$count= 1;
			foreach ($params as $item )
			{
				$class= 'first';
				if($count == '2')
				{
					$class= 'second';
				}
				 if($item['filter_type'] == "keyword")
				 {
					$filters .= '<div class="input-field '.esc_attr($class).'">
								   <label class="mb-0">'.esc_html($item['field_label']).'</label>
								  <div class="typeahead__container custom-style-frontend">
								  <div class="typeahead__field">
								  <div class="typeahead__query">
								  <input type="text" class="prop_get_smple form-control is_smple" name="'.esc_attr($fields[$item['filter_type']]).'" autocomplete="off" value="" placeholder="'.esc_attr($item['field_place']).'">
								  </div>
								  </div>
								  </div>
							    </div>';
				 }
				 if($item['filter_type'] == "type")
				 {
					 $property_type = '';
					 propertya_framework_term_html('property_type' , $property_type);
					 $filters .= '<div class="input-field '.esc_attr($class).'">
								   <label class="mb-0">'.esc_html($item['field_label']).'</label>
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
								'.$property_type.'
								  </select>
								  </div>';
				 }
				 if($item['filter_type'] == "offer")
				 {
					 $offer = '';
					 propertya_framework_term_html('property_status' , $offer);
					 $filters .= '<div class="input-field '.esc_attr($class).'">
							   <label class="mb-0">'.esc_html($item['field_label']).'</label>
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
								'.$offer.'
								  </select>
								  </div>';
				 }
				 if($item['filter_type'] == "label")
				 {
					 $property_label = '';
					 propertya_framework_term_html('property_label' , $property_label);
					 $filters .= '<div class="input-field '.esc_attr($class).'">
							   <label class="mb-0">'.esc_html($item['field_label']).'</label>
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
								'.$property_label.'
								  </select>
								  </div>';
				 }
				 if($item['filter_type'] == "location")
				 {
					 $property_location = '';
					 propertya_framework_term_html('property_location' , $property_location);
					 $filters .= '<div class="input-field '.esc_attr($class).'">
							   <label class="mb-0">'.esc_html($item['field_label']).'</label>
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
								'.$property_location.'
								  </select>
								  </div>';
				 }
				 if($item['filter_type'] == "currency")
				 {
					$options = $selected_cur = '';
					$custom_currency = propertya_framework_term_fetch('property_currency',0);
					if(!empty($custom_currency) && count((array) $custom_currency) > 0 && !is_wp_error($custom_currency))
					{
						$p_currency_sym = $p_currency_code = $options = '';
						foreach($custom_currency as $currency)
						{
							$selected_cur = '';
							if(!empty($selected_currency) && $selected_currency == $currency->slug)
							{
								$selected_cur = 'selected="selected"';
							}
							if(get_term_meta( $currency->term_id, 'p_currency_code', true ) !="")
							{
								$p_currency_code = get_term_meta( $currency->term_id, 'p_currency_code', true );
								$p_currency_sym = get_term_meta( $currency->term_id, 'p_currency_sym', true );
								$options .= '<option value="' . $currency->slug. '" '.$selected_cur.'>' . $p_currency_code .' ( ' . $p_currency_sym . ' )'. '</option>';
							}
							else
							{
								$options .= '<option value="' . $currency->slug. '" '.$selected_cur.'>' . $currency->name . '</option>';
							}
						}
					}
					 $filters .= '<div class="input-field '.esc_attr($class).'">
							   <label class="mb-0">'.esc_html($item['field_label']).'</label>
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
								  <option value="">' .esc_html__('Any','propertya-framework').'</option>
								'.$options.'
								  </select>
								  </div>';
				 }
				 if($item['filter_type'] == "bed")
				 {
					 $filters .= '<div class="input-field '.esc_attr($class).'">
							   <label class="mb-0">'.esc_html($item['field_label']).'</label>
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
									<option value="">' .esc_html__('Any','propertya-framework').'</option>
									<option value="1">1+</option>
									<option value="2">2+</option>
									<option value="3">3+</option>
									<option value="4">4+</option>
									<option value="5">5+</option>
								</select>
								  </div>';
				 }
				 if($item['filter_type'] == "bath")
				 {
					 $offer = '';
					 propertya_framework_term_html('property_status' , $offer);
					 $filters .= '<div class="input-field '.esc_attr($class).'">
							   <label class="mb-0">'.esc_html($item['field_label']).'</label>
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
									<option value="">' .esc_html__('Any','propertya-framework').'</option>
									<option value="1">1+</option>
									<option value="2">2+</option>
									<option value="3">3+</option>
									<option value="4">4+</option>
									<option value="5">5+</option>
								  </select>
								  </div>';
				 }
				 if($item['filter_type'] == "price" || $item['filter_type'] == "area")
				 {
					if($item['filter_type'] == "price")
					{
						$min = 'min-price';
						$max = 'max-price';
					}
					else
					{
						$min = 'min-area';
						$max = 'max-area';
					} 
					$filters .= '<div class="input-field '.esc_attr($class).'">
					  <label class="mb-0">'.esc_html($item['field_label']).'</label>
					  <div class="input-group">
						<input type="text" class="form-control" name="'.esc_attr($min).'" placeholder="'.esc_attr($item['min_label']).'" value="">
						<div class="input-group-prepend input-group-append">
						  <span class="input-group-text">-</span>
						</div>
						<input type="text" class="form-control" name="'.esc_attr($max).'" placeholder="'.esc_attr($item['max_label']).'" value="">
					  </div>
				   </div>';
				 }
				 $count++;
				 if($count == 3)
				 {
					break; 
				 }
			}
		}
		return $filters;
	}
}
//Filters with cols
if (!function_exists('propertya_framework_render_filters_cols'))
{
	function propertya_framework_render_filters_cols($params , $show_labels = 'no')
	{

		$filters = '';
		if(!empty($params) && is_array($params) && count($params) > 0)
		{
			
			$fields = [
				'keyword' =>'by_title', 
				'type' => 'property-type', 
				'offer' =>'offer-type', 
				'label'=>'label-type', 
				'location' =>'location-by', 
				'currency' =>'currency-type',
				'bed'=>'type-beds', 
				'bath' =>'type-bath', 
        	];
			$filters = '';
			foreach ($params as $item )
			{
				 if($item['filter_type'] == "keyword")
				 {
					 $label = '<label>'.esc_html($item['field_label']).'</label>';
					 if(!empty($show_labels) && $show_labels == 'yes')
					 {
						 $label = '';
					 }
					$filters .= '<div class="col-xl-'.esc_attr($item['column_size']).' col-sm-12 col-12">
								<div class="form-group">
								  '.$label.'
								  <div class="typeahead__container custom-style-frontend">
								  <div class="typeahead__field">
								  <div class="typeahead__query">
								  <input type="text" class="prop_get_smple form-control is_smple" name="'.esc_attr($fields[$item['filter_type']]).'" autocomplete="off" value="" placeholder="'.esc_attr($item['field_place']).'">
								  </div>
								  </div>
								  </div>
							    </div></div>';
				 }
				 if($item['filter_type'] == "type")
				 {
					 $property_type = '';
					  $property_type  =  propertya_framework_term_html('property_type' , $property_type);
                   
                        
                  

					 $label = '<label>'.esc_html($item['field_label']).'</label>';
					 if(!empty($show_labels) && $show_labels == 'yes')
					 {
						 $label = '';
					 }
					 $filters .= '<div class="col-xl-'.esc_attr($item['column_size']).' col-sm-12 col-12"><div class="form-group">
								 '.$label.'
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
								'.$property_type.'
								  </select>
								  </div></div>';
				 }
				 if($item['filter_type'] == "offer")
				 {
					 $offer = '';
					  $offer =  propertya_framework_term_html('property_status' , $offer);
					 $label = '<label>'.esc_html($item['field_label']).'</label>';
					 if(!empty($show_labels) && $show_labels == 'yes')
					 {
						 $label = '';
					 }
					 $filters .= '<div class="col-xl-'.esc_attr($item['column_size']).' col-sm-12 col-12"><div class="form-group">
							  '.$label.'
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
								'.$offer.'
								  </select>
								  </div></div>';
				 }
				 if($item['filter_type'] == "label")
				 {
					 $property_label = '';
					 $property_label  =  propertya_framework_term_html('property_label' , $property_label);
					 $label = '<label>'.esc_html($item['field_label']).'</label>';
					 if(!empty($show_labels) && $show_labels == 'yes')
					 {
						 $label = '';
					 }
					 $filters .= '<div class="col-xl-'.esc_attr($item['column_size']).' col-sm-12 col-12"><div class="form-group">
							  '.$label.'
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
								'.$property_label.'
								  </select>
								  </div></div>';
				 }
				 if($item['filter_type'] == "location")
				 {
					 $property_location = '';
					$property_location  = propertya_framework_term_html('property_location' , $property_location);
					 $label = '<label>'.esc_html($item['field_label']).'</label>';
					 if(!empty($show_labels) && $show_labels == 'yes')
					 {
						 $label = '';
					 }
					 $filters .= '<div class="col-xl-'.esc_attr($item['column_size']).' col-sm-12 col-12"><div class="form-group">
							  '.$label.'
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
								'.$property_location.'
								  </select>
								  </div></div>';
				 }
				 if($item['filter_type'] == "currency")
				 {
					$options = $selected_cur = '';
					$custom_currency = propertya_framework_term_fetch('property_currency',0);
					if(!empty($custom_currency) && count((array) $custom_currency) > 0 && !is_wp_error($custom_currency))
					{
						$p_currency_sym = $p_currency_code = $options = '';
						foreach($custom_currency as $currency)
						{
							$selected_cur = '';
							if(!empty($selected_currency) && $selected_currency == $currency->slug)
							{
								$selected_cur = 'selected="selected"';
							}
							if(get_term_meta( $currency->term_id, 'p_currency_code', true ) !="")
							{
								$p_currency_code = get_term_meta( $currency->term_id, 'p_currency_code', true );
								$p_currency_sym = get_term_meta( $currency->term_id, 'p_currency_sym', true );
								$options .= '<option value="' . $currency->slug. '" '.$selected_cur.'>' . $p_currency_code .' ( ' . $p_currency_sym . ' )'. '</option>';
							}
							else
							{
								$options .= '<option value="' . $currency->slug. '" '.$selected_cur.'>' . $currency->name . '</option>';
							}
						}
					}
					 $filters .= '<div class="col-xl-'.esc_attr($item['column_size']).' col-sm-12 col-12"><div class="form-group">
							  '.$label.'
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
								  <option value="">' .esc_html__('Any','propertya-framework').'</option>
								'.$options.'
								  </select>
								  </div></div>';
				 }
				 if($item['filter_type'] == "bed")
				 {
					 $label = '<label>'.esc_html($item['field_label']).'</label>';
					 if(!empty($show_labels) && $show_labels == 'yes')
					 {
						 $label = '';
					 }
					 $filters .= '<div class="col-xl-'.esc_attr($item['column_size']).' col-sm-12 col-12"><div class="form-group">
							  '.$label.'
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
									<option value="">' .esc_html__('Any','propertya-framework').'</option>
									<option value="1">1+</option>
									<option value="2">2+</option>
									<option value="3">3+</option>
									<option value="4">4+</option>
									<option value="5">5+</option>
								</select>
								  </div></div>';
				 }
				 if($item['filter_type'] == "bath")
				 {
					 $offer = '';
					 propertya_framework_term_html('property_status' , $offer);
					 $label = '<label>'.esc_html($item['field_label']).'</label>';
					 if(!empty($show_labels) && $show_labels == 'yes')
					 {
						 $label = '';
					 }
					 $filters .= '<div class="col-xl-'.esc_attr($item['column_size']).' col-sm-12 col-12"><div class="form-group">
							  '.$label.'
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
									<option value="">' .esc_html__('Any','propertya-framework').'</option>
									<option value="1">1+</option>
									<option value="2">2+</option>
									<option value="3">3+</option>
									<option value="4">4+</option>
									<option value="5">5+</option>
								  </select>
								  </div></div>';
				 }
				 if($item['filter_type'] == "price" || $item['filter_type'] == "area")
				 {
					if($item['filter_type'] == "price")
					{
						$min = 'min-price';
						$max = 'max-price';
					}
					else
					{
						$min = 'min-area';
						$max = 'max-area';
					}
					$label = '<label>'.esc_html($item['field_label']).'</label>';
					 if(!empty($show_labels) && $show_labels == 'yes')
					 {
						 $label = '';
					 } 
					$filters .= '<div class="col-xl-'.esc_attr($item['column_size']).' col-sm-12 col-12"><div class="form-group">
					 '.$label.'
					  <div class="input-group">
						<input type="text" class="form-control" name="'.esc_attr($min).'" placeholder="'.esc_attr($item['min_label']).'" value="">
						<div class="input-group-prepend input-group-append">
						  <span class="input-group-text">-</span>
						</div>
						<input type="text" class="form-control" name="'.esc_attr($max).'" placeholder="'.esc_attr($item['max_label']).'" value="">
					  </div>
				   </div></div>';
				 }
			}
		}
		return $filters;
	}
}

//Hero Section 1
if( !function_exists('propertya_elementor_hero1') )
{
	function propertya_elementor_hero1($params)
	{
		$sec_btn = $main_btn = $desc = $main_heading = '';
		if(!empty($params['heading_text']))
		{
			$main_heading = '<h1 class="p-0 col-xl-9 col-lg-9 col-md-9 col-sm-12 t-center clr-white">'.propertya_framework_color_text($params['heading_text']).' </h1>';
		}
		if(!empty($params['desc']))
		{
			$desc = '<p class="col-xl-9 col-lg-9 col-md-12 col-sm-12 p-0 t-center margin-top-10 clr-white margin-bottom-20">'.propertya_framework_color_text($params['desc']).' </p>';
		}
		
		if(!empty($params['main_btn']) && is_array($params['main_btn']) && !empty($params['main_btn']['title']))
		{
			$target = $params['main_btn']['is_external'] ? ' target="_blank"' : '';
		    $nofollow = $params['main_btn']['nofollow'] ? ' rel="nofollow"' : '';
			$main_btn = '<a href="'.esc_url($params['main_btn']['link']).'" ' . $target . $nofollow . ' class="btn btn-theme br-flat text-capitalize">'.esc_html($params['main_btn']['title']).'</a>';
		}
		
		if(!empty($params['sec_btn']) && is_array($params['sec_btn']) && !empty($params['sec_btn']['title']))
		{
			$target = $params['sec_btn']['is_external'] ? ' target="_blank"' : '';
		    $nofollow = $params['sec_btn']['nofollow'] ? ' rel="nofollow"' : '';
			$sec_btn = '<a href="'.esc_url($params['sec_btn']['link']).'" ' . $target . $nofollow . ' class="btn btn-theme br-flat text-capitalize read-m border-0">'.esc_html($params['sec_btn']['title']).'</a>';
		}
		$direction = 'text-left';
        if(is_rtl())
        {
            $direction = 'text-right';
        }
		return '<section class="home-6-sec1  section-padding-120">
		  <div class="container">
			<div class="row">
			  <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
				<div class="m-heading '.esc_attr($direction).' padding-top-60 padding-bottom-120">
				'.$main_heading.'
				'.$desc.'
				  <div class="btn-div">
				  '.$main_btn.'
				  '.$sec_btn.'
				  </div>
				</div>
			  </div>
			</div>
		  </div>
		</section>';
	}
}

//Hero Section 2
if( !function_exists('propertya_elementor_hero2') )
{
	function propertya_elementor_hero2($params)
	{
		$meta_query = $top_title = $show_data = $background = $main_img = $sub_title = $sec_btn = $main_btn = $desc = $main_heading = '';
		$search_page = propertya_framework_get_link('page-property-search.php');
		if(!empty($params['sub_title']))
		{
			$sub_title = '<h1>'.esc_html($params['sub_title']).' </h1>';
		}
		if(!empty($params['heading_text']))
		{
			$main_heading = '<h2>'.propertya_framework_color_text($params['heading_text']).' </h2>';
		}
		if(!empty($params['desc']))
		{
			$desc = '<p>'.$params['desc'].' </p>';
		}
		if(!empty($params['image']))
		{
			$main_img = '<div class="sec-img">
							<img src="'.esc_url($params['image']).'" alt="" class="img-fluid">	   
  						</div>	';
		}
		if(!empty($params['background']))
		{
			$background = '<div class="build-bg">
    			<img src="'.esc_url($params['background']).'" alt="" class="img-fluid">	   
  			 </div>';
		}
		
		if(!empty($params['widget_type']) && $params['widget_type'] == 'agencies')
		{
			$search_page = propertya_framework_get_link('page-agencies-search.php');
		}
		else if(!empty($params['widget_type']) && $params['widget_type'] == 'agents')
		{
			$search_page = propertya_framework_get_link('page-agents-search.php');
		}
		else
		{
			$search_page = propertya_framework_get_link('page-property-search.php');
		}
		
		if(!empty($params['top_title']))
		{
			$top_title = '<h3>'.esc_html($params['top_title']).'</h3>';
		}
		if(!empty($params['selection_type']) && $params['selection_type']!="no")
		{
			$list = '';
			$post_type = 'property-agency';
			if($params['selection_type'] == 'agency')
			{
					$post_type = 'property-agency';
					$post_status = array(
						'key'       => 'agency_status',
						'value'     => '1',
						'compare'   => '=',
					);
			}
			else 
			{
				$post_type = 'property-agents';	
				$post_status = array(
						'key'       => 'agent_status',
						'value'     => '1',
						'compare'   => '=',
					);
			}
			
			if($params['selection_status'] == 'featured' && $params['selection_type'] == 'agency')
			{
				$meta_query = array(
					'key'       => 'agency_is_featured',
					'value'     => '1',
					'compare'   => '=',
				);
			}
			if($params['selection_status'] == 'featured' && $params['selection_type'] == 'agent')
			{
				$meta_query = array(
					'key'       => 'agent_is_featured',
					'value'     => '1',
					'compare'   => '=',
				);
			}
			
			if($params['selection_status'] == 'trusted' && $params['selection_type'] == 'agency')
			{
				$meta_query = array(
					'key'       => 'agency_is_trusted',
					'value'     => '1',
					'compare'   => '=',
				);
			}
			if($params['selection_status'] == 'trusted' && $params['selection_type'] == 'agent')
			{
				$meta_query = array(
					'key'       => 'agent_is_trusted',
					'value'     => '1',
					'compare'   => '=',
				);
			}
			$args	=	array
			(
				'post_type' => $post_type,
				'post_status' => 'publish',
				'posts_per_page' => $params['limit'],
				'meta_query'    => array(
				    $post_status,
					$meta_query,
				),
				'orderby'  => 'DATE',
				'order'=> 'DESC',
		  );
		  $results = new WP_Query( $args );
		  if ($results->have_posts())
		  {
			   $views = '';
			   $list.= '<ul class="list-unstyled">';
				while ($results->have_posts())
				{
					$results->the_post();
					$post_id = get_the_ID();
					if(intval(get_post_meta($post_id, 'prop_'.$params['selection_type'].'_singletotal_views', true)!=""))
					{
						$views = '<span class="myview">'.esc_html__("Views : ", 'propertya-framework').'  '.propertya_number_format_short(get_post_meta($post_id, 'prop_'.$params['selection_type'].'_singletotal_views', true)).'</span>';
					}
					$list.= '<li class="list-inline-item">
					<span>
						<a href="'.esc_url(get_the_permalink($post_id)).'">'.propertya_responsive_images($post_id,'propertya-user-thumb',$params['selection_type'],'img-fluid').'</a>
					</span>
					<b><a class="clr-black" href="'.esc_url(get_the_permalink($post_id)).'">'.propertya_title_limit(11,$post_id).'</a></b>
					'.$views.'
					</li>';
				}
				wp_reset_postdata();
				$list.= '</ul>';
		  }
			$show_data = '<div class="top-agencies">
				  '.$top_title.'
					  <div class="agencies">
						   '.$list.' 
					  </div>	 
				 </div>';
		}
		
		
		return '<section class="ag-hero">
<div class="container">
 <div class="row">
 <div class="col-12 ag-hero-inner">
  <div class="row">	 
  <div class="col-md-12 col-lg-8 mx-lg-auto col-xl-7 mx-xl-0">
   <div class="search-data ml-auto">
	'.$sub_title.'
	'.$main_heading.'
	 '.$desc.'
	 <form action="'.esc_url($search_page).'" method="get">
	  <div class="search-box">
		  <div class="search-inner left">
			<div class="input-field first">
            <label class="mb-0">'.esc_html__("Explore", 'propertya-framework').'</label>
            <div class="typeahead__container custom-style-frontend">
            <div class="typeahead__field">
                <div class="typeahead__query">
                    <input name="by_title" value="" autocomplete="off" type="search" class="for_single_pages form-control short-multi " placeholder="'.esc_attr__("What are you looking for...", 'propertya-framework').'">
                </div>
            </div>
        </div>
          </div>
		  <input type="hidden" name="widget_type" value="'.esc_attr($params['widget_type']).'">  
		  <button type="submit"><i class="fas fa-search"></i> '.esc_html__("Search", 'propertya-framework').' </button> 
		   </div>
	  </div> 
	  </form>
	  '.$show_data.' 
   </div>	 
  </div>
  <div class="col-lg-5">
  '.$main_img.'	  
  </div>
  </div>	  
</div>	  
   '.$background.'
 </div>	
</div>	
</section>	
<div class="clearfix"></div>';
	}
}

//Hero Section 3
if( !function_exists('propertya_elementor_hero3') )
{
	function propertya_elementor_hero3($params)
	{
		/*$filters = '';
		if(!empty($params['filter_array']) && is_array($params['filter_array']) && count($params['filter_array']) > 0)
		{
			$fields = [
				'keyword' =>'by_title', 
				'type' => 'property-type', 
				'offer' =>'offer-type', 
				'label'=>'label-type', 
				'location' =>'location-by', 
				'currency' =>'currency-type',
				'bed'=>'type-beds', 
				'bath' =>'type-bath', 
        ];
		
		//echo $html;
			$filters = '';
			foreach ( $params['filter_array'] as $item )
			{
				 if($item['filter_type'] == "keyword")
				 {
					$filters .= '<div class="form-group">
								  <label>'.esc_html($item['field_label']).'</label>
								  <input type="text" class="for_minimal_search form-control minimal_specific_search" name="'.esc_attr($fields[$item['filter_type']]).'" autocomplete="off" value="" placeholder="'.esc_attr($item['field_place']).'">
							    </div>';
				 }
				 if($item['filter_type'] == "type")
				 {
					 $property_type = '';
					 propertya_framework_term_html('property_type' , $property_type);
					 $filters .= '<div class="form-group">
								  <label>'.esc_html($item['field_label']).'</label>
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
								'.$property_type.'
								  </select>
								  </div>';
				 }
				 if($item['filter_type'] == "offer")
				 {
					 $offer = '';
					 propertya_framework_term_html('property_status' , $offer);
					 $filters .= '<div class="form-group">
							  <label>'.esc_html($item['field_label']).'</label>
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
								'.$offer.'
								  </select>
								  </div>';
				 }
				 if($item['filter_type'] == "label")
				 {
					 $property_label = '';
					 propertya_framework_term_html('property_label' , $property_label);
					 $filters .= '<div class="form-group">
							  <label>'.esc_html($item['field_label']).'</label>
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
								'.$property_label.'
								  </select>
								  </div>';
				 }
				 if($item['filter_type'] == "location")
				 {
					 $property_location = '';
					 propertya_framework_term_html('property_location' , $property_location);
					 $filters .= '<div class="form-group">
							  <label>'.esc_html($item['field_label']).'</label>
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
								'.$property_location.'
								  </select>
								  </div>';
				 }
				 if($item['filter_type'] == "currency")
				 {
					$options = $selected_cur = '';
					$custom_currency = propertya_framework_term_fetch('property_currency',0);
					if(!empty($custom_currency) && count((array) $custom_currency) > 0 && !is_wp_error($custom_currency))
					{
						$p_currency_sym = $p_currency_code = $options = '';
						foreach($custom_currency as $currency)
						{
							$selected_cur = '';
							if(!empty($selected_currency) && $selected_currency == $currency->slug)
							{
								$selected_cur = 'selected="selected"';
							}
							if(get_term_meta( $currency->term_id, 'p_currency_code', true ) !="")
							{
								$p_currency_code = get_term_meta( $currency->term_id, 'p_currency_code', true );
								$p_currency_sym = get_term_meta( $currency->term_id, 'p_currency_sym', true );
								$options .= '<option value="' . $currency->slug. '" '.$selected_cur.'>' . $p_currency_code .' ( ' . $p_currency_sym . ' )'. '</option>';
							}
							else
							{
								$options .= '<option value="' . $currency->slug. '" '.$selected_cur.'>' . $currency->name . '</option>';
							}
						}
					}
					 $filters .= '<div class="form-group">
							  <label>'.esc_html($item['field_label']).'</label>
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
								  <option value="">' .esc_html__('Any','propertya-framework').'</option>
								'.$options.'
								  </select>
								  </div>';
				 }
				 if($item['filter_type'] == "bed")
				 {
					 $filters .= '<div class="form-group">
							  <label>'.esc_html($item['field_label']).'</label>
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
									<option value="">' .esc_html__('Any','propertya-framework').'</option>
									<option value="1">1+</option>
									<option value="2">2+</option>
									<option value="3">3+</option>
									<option value="4">4+</option>
									<option value="5">5+</option>
								</select>
								  </div>';
				 }
				 if($item['filter_type'] == "bath")
				 {
					 $offer = '';
					 propertya_framework_term_html('property_status' , $offer);
					 $filters .= '<div class="form-group">
							  <label>'.esc_html($item['field_label']).'</label>
								  <select class="search-selects"  data-placeholder="'.esc_attr($item['field_place']).'" name="'.esc_attr($fields[$item['filter_type']]).'">
									<option value="">' .esc_html__('Any','propertya-framework').'</option>
									<option value="1">1+</option>
									<option value="2">2+</option>
									<option value="3">3+</option>
									<option value="4">4+</option>
									<option value="5">5+</option>
								  </select>
								  </div>';
				 }
				 if($item['filter_type'] == "price" || $item['filter_type'] == "area")
				 {
					if($item['filter_type'] == "price")
					{
						$min = 'min-price';
						$max = 'max-price';
					}
					else
					{
						$min = 'min-area';
						$max = 'max-area';
					} 
					$filters .= '<div class="form-group">
					 <label>'.esc_html($item['field_label']).'</label>
					  <div class="input-group">
						<input type="text" class="form-control" name="'.esc_attr($min).'" placeholder="'.esc_attr($item['min_label']).'" value="">
						<div class="input-group-prepend input-group-append">
						  <span class="input-group-text">-</span>
						</div>
						<input type="text" class="form-control" name="'.esc_attr($max).'" placeholder="'.esc_attr($item['max_label']).'" value="">
					  </div>
				   </div>';
				 }

			}
		}
		*/
		$search_page = '#';
		$main_btn = $meta_query = $top_title = $show_data = $background = $main_img = $sub_title = $sec_btn = $main_btn = $desc = $main_heading = '';
		$search_page = propertya_framework_get_link('page-property-search.php');
		if(!empty($params['heading_text']))
		{
			$main_heading = ' <h1 class="text-white">'.propertya_framework_color_text($params['heading_text']).'  </h1>';
		}
		if(!empty($params['desc']))
		{
			$desc = '<p class="lead">'.$params['desc'].' </p>';
		}
		if(!empty($params['main_btn']) && is_array($params['main_btn']) && !empty($params['main_btn']['title']))
		{
			$target = $params['main_btn']['is_external'] ? ' target="_blank"' : '';
		    $nofollow = $params['main_btn']['nofollow'] ? ' rel="nofollow"' : '';
			$main_btn = '<a href="'.esc_url($params['main_btn']['link']).'" ' . $target . $nofollow . ' class="btn btn-theme">'.esc_html($params['main_btn']['title']).'</a>';
		}
		return '<section class="hero-section-trans pt-100 background-img">
            <div class="container">
                <div class="row align-items-center justify-content-between pt-5 pb-5">
                    <div class="col-md-12 col-sm-12 col-lg-7 col-12">
                        <div class="hero-content-left text-white">
                           '.$main_heading.'
                            '.$desc.'
                            '.$main_btn.'
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-5 col-sm-12 col-12">
                        <div class="inner-column">
                            <h2>'.esc_html($params['tagline']).'</h2>
                            <div class="banner-form">
                                <form class="form-join" action="'.esc_url($search_page).'">
									'.propertya_framework_render_filters($params['filter_array']).'
									<div class="form-group  mb-0">
										<button class="btn btn-theme btn-block" type="submit">'.esc_html($params['btn_text']).'</button>
									</div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
    </section>';
	}
}

//Hero Section 4
if( !function_exists('propertya_elementor_hero4') )
{
	function propertya_elementor_hero4($params)
	{
		$main_heading = $desc = $search_page = '';
		$search_page = propertya_framework_get_link('page-property-search.php');
		if(!empty($params['heading_text']))
		{
			$main_heading = ' <h1 class="text-white">'.propertya_framework_color_text($params['heading_text']).'  </h1>';
		}
		if(!empty($params['tagline']))
		{
			$desc = '<p>'.esc_html($params['tagline']).' </p>';
		}
		return '<section class=" my-hero-four">
         <div class="container">
            <div class="row justify-content-center">
               <div class="col-lg-9 text-center">
                  <div class="hero-four-content">
					     '.$desc.'
                     	 '.$main_heading.'
                     </div>
					<form method="get" action="'.esc_url($search_page).'">
						<div class="classic-search-bar">
							  <div class="search-inner left">
							  '.propertya_framework_render_filters_style_two($params['filter_array']).'
							  <button type="submit"><i class="fas fa-search"></i> '.esc_html($params['btn_text']).' </button> 
							 </div>
						</div> 
					</form>
               </div>
            </div>
         </div>
      </section>';
	}
}

//Hero Section 5
if( !function_exists('propertya_elementor_hero5') )
{
	function propertya_elementor_hero5($params)
	{
		$img_html =  $main_heading = $desc = $search_page = '';
		$search_page = propertya_framework_get_link('page-property-search.php');
		if(!empty($params['heading_text']))
		{
			$main_heading = ' <h1>'.propertya_framework_color_text($params['heading_text']).'  </h1>';
		}
		if(!empty($params['tagline']))
		{
			$desc = '<p>'.esc_html($params['tagline']).' </p>';
		}
		if(!empty($params['image']))
		{
			$img_html = '<div class="hero-5-png">
								<img src="'.esc_url($params['image']).'" alt="" >
							</div>';
		}
		$count_html = '';
		if(!empty($params['listing_count']))
		{
			$final_data = '';
			$count_prop = wp_count_posts('property');
			$final_data = str_replace('%count%', '<span>' . $count_prop->publish . '</span>',$params['listing_count']);
			$count_html = '<p class="prop-stats">'.$final_data.'</p>';
		}
        $direction = 'text-left';
        if(is_rtl())
        {
            $direction = 'text-right';
        }
		return '<section class=" my-hero-four hero-type-5">
         <div class="container">
            <div class="row justify-content-start">
               <div class="col-lg-8 '.esc_attr($direction).'">
                  <div class="hero-four-content">
				  '.$count_html.'
				  '.$main_heading.'
                     '.$desc.'
					 <form method="get" action="'.esc_url($search_page).'">
						<div class="classic-search-bar">
							  <div class="search-inner left">
							  '.propertya_framework_render_filters_style_two($params['filter_array']).'
							  <button type="submit"><i class="fas fa-search"></i> '.esc_html($params['btn_text']).' </button> 
							 </div>
						</div> 
					</form>	
                  </div>
               </div>
            </div>
			'.$img_html.'
         </div>
      </section>';
	}
}

//Hero Section 6
if( !function_exists('propertya_elementor_hero6') )
{
	function propertya_elementor_hero6($params)
	{
		$agency_search = $property_search = $agent_search = $img_html =  $main_heading = $desc = $search_page = '';
		$property_search = propertya_framework_get_link('page-property-search.php');
		$agent_search = propertya_framework_get_link('page-agents-search.php');
		$agency_search = propertya_framework_get_link('page-agencies-search.php');
		$agency_location = $agent_types = $agent_location = '';
		if(!empty($params['heading_text']))
		{
			$main_heading = ' <h1>'.propertya_framework_color_text($params['heading_text']).'  </h1>';
		}
		if(!empty($params['tagline']))
		{
			$desc = '<p>'.esc_html($params['tagline']).' </p>';
		}
		$tab_end = $tab_start = $prop_tab_end = $agent_tab_end = $agent_tab_start = $agency_tab_start = $prop_tab_start = $prop_tab_end = '';
		if ( 'yes' === $params['show_property_tab'] || 'yes' === $params['show_agency_tab'] || 'yes' === $params['show_agent_tab'] )
		{
			$tab_start = '<div class="tab-content">';
			$tab_end = '</div>';
		}
		if ( 'yes' === $params['show_property_tab'] ) 
		{
			$prop_tab_start = '<li class="nav-item">
								<a class="nav-link active" data-toggle="tab" href="#all_listed_prop">'.esc_html($params['prop_tab_text']).'</a>
								</li>';
			$prop_tab_end = '<div class="tab-pane fade show active" id="all_listed_prop">
						<div class="d-flex flex-column flex-lg-row">
								<div class="herosearch-form">
									<form method="get" action="'.esc_url($property_search).'">
										<div class="search-form-inner">
											<div class="row">
											'.propertya_framework_render_filters_cols($params['filter_array']).'
											</div>
										</div>
										<div class="form-group text-right">
											<button type="submit" value="submit" class="btn btn-theme">'.esc_html($params['btn_text']).'</button>
										</div>
									</form>
								</div>
						</div>
					</div>';
		}
		if ( 'yes' === $params['show_agency_tab'] ) 
		{
			propertya_framework_term_html('agency_location' , $agency_location);
			$agency_tab_start = '<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#listed_agencies">'.esc_html($params['agency_tab_text']).'</a>
					</li>';
			$agency_tab_end = '<div class="tab-pane fade" id="listed_agencies">
						<div class="d-flex flex-column flex-lg-row">
								<div class="herosearch-form">
								<form method="get" action="'.esc_url($agency_search).'">
									<div class="search-form-inner">
										<div class="row">
											<div class="col-md-7">
												<div class="form-group">
											  		<label>'.esc_html($params['keyfield_label']).'</label>
													<div class="typeahead__container custom-style-frontend">
												 		<div class="typeahead__field">
													  <div class="typeahead__query">
															<span class="typeahead__cancel-button">×</span>
															<input type="text" class="agency_get_smple form-control is_agency_search" name="by_title" autocomplete="off" value="" placeholder="'.esc_attr($params['field_placeholder']).'">
													  </div>
												  </div>
											  		</div>
												</div>	
											</div>
											<div class="col-md-5">
												<div class="form-group">
											  		<label>'.esc_html($params['loc_field_label']).'</label>
													<select class="search-selects"  data-placeholder="'.esc_attr($params['loc_field_placeholder']).'" name="location">
														'.$agency_location.'
								  					</select>
												</div>	
											</div>
										</div>
									</div>
									<div class="form-group text-right">
                                   		 <button type="submit" value="submit" class="btn btn-theme">'.esc_html($params['agency_btn_text']).'</button>
                                 	</div>
									</form>		
								</div>			
						</div>
					</div>';
		}
		if ( 'yes' === $params['show_agent_tab'] ) 
		{
			propertya_framework_term_html('agent_location' , $agent_location);
		    propertya_framework_term_html('agent_types' , $agent_types);
			$agent_tab_start = '<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#listed_agents">'.esc_html($params['agent_tab_text']).'</a>
					</li>';
			$agent_tab_end = '<div class="tab-pane fade" id="listed_agents">
						<div class="d-flex flex-column flex-lg-row">
							<div class="herosearch-form">
								<form method="get" action="'.esc_url($agent_search).'">
										<div class="search-form-inner">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>'.esc_html($params['agkeyfield_label']).'</label>
														<div class="typeahead__container custom-style-frontend">
															<div class="typeahead__field">
														  <div class="typeahead__query">
																<span class="typeahead__cancel-button">×</span>
																<input type="text" class="agent_get_smple form-control is_ag_search" name="by_title" autocomplete="off" value="" placeholder="'.esc_attr($params['agfield_placeholder']).'">
														  </div>
													  </div>
														</div>
													</div>	
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label>'.esc_html($params['agtype_field_label']).'</label>
														<select class="search-selects"  data-placeholder="'.esc_attr($params['agtype_field_placeholder']).'" name="by_type">
															'.$agent_types.'
														</select>
													</div>	
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label>'.esc_html($params['agloc_field_label']).'</label>
														<select class="search-selects"  data-placeholder="'.esc_attr($params['agloc_field_placeholder']).'" name="by_location">
															'.$agent_location.'
														</select>
													</div>	
												</div>
											</div>
										</div>
										<div class="form-group text-right">
											 <button type="submit" value="submit" class="btn btn-theme">'.esc_html($params['agent_btn_text']).'</button>
										</div>
								</form>		
							</div>
						
						</div>
					</div>';
		}
		$direction = 'text-left';
        if(is_rtl())
        {
            $direction = 'text-right';
        }
return '<section class="homebg-top2">
	<div class="container">
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="m-heading '.esc_attr($direction).'">
		  '.$desc.'
          '.$main_heading.'
        </div>
		<div class="hero-five-tabs">
				 <ul class="nav nav-tabs" role="tablist">
					'.$prop_tab_start.'
					'.$agency_tab_start.'
					'.$agent_tab_start.'
				 </ul>
				  '.$tab_start.'
						'.$prop_tab_end.'
						'.$agency_tab_end.'
						'.$agent_tab_end.'
				    '.$tab_end.'
				</div>
      </div>
    </div>
  </div>
</section>';
	}
}

//Hero Section 7
if( !function_exists('propertya_elementor_hero7') )
{
	function propertya_elementor_hero7($params)
	{
		$search_page = '#';
		$main_btn = $meta_query = $top_title = $show_data = $background = $main_img = $sub_title = $sec_btn = $main_btn = $desc = $main_heading = '';
		$search_page = propertya_framework_get_link('page-property-search.php');
		if(!empty($params['heading_text']))
		{
			$main_heading = ' <h1 class="hero-title">'.propertya_framework_color_text($params['heading_text']).'  </h1>';
		}
		if(!empty($params['desc']))
		{
			$desc = '<p class="hero-tagline">'.$params['desc'].' </p>';
		}
		if(!empty($params['subtitle']))
		{
			$sub_title = '<h2>'.esc_html($params['subtitle']).' </h2>';
		}
		if(!empty($params['main_btn']) && is_array($params['main_btn']) && !empty($params['main_btn']['title']))
		{
			$target = $params['main_btn']['is_external'] ? ' target="_blank"' : '';
		    $nofollow = $params['main_btn']['nofollow'] ? ' rel="nofollow"' : '';
			$main_btn = '<a href="'.esc_url($params['main_btn']['link']).'" ' . $target . $nofollow . ' class="btn btn-theme btn-transparent">'.esc_html($params['main_btn']['title']).'</a>';
		}
		if(!empty($params['sec_btn']) && is_array($params['sec_btn']) && !empty($params['sec_btn']['title']))
		{
			$target = $params['sec_btn']['is_external'] ? ' target="_blank"' : '';
		    $nofollow = $params['sec_btn']['nofollow'] ? ' rel="nofollow"' : '';
			$sec_btn = '<a href="'.esc_url($params['sec_btn']['link']).'" ' . $target . $nofollow . ' class="btn btn-theme">'.esc_html($params['sec_btn']['title']).'</a>';
		}
		return '<div class="intro-hero-1">
<div class="hero-content-1">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xs-9 col-lg-9 col-12 col-md-12 col-sm-12  text-center">
		  	'.$sub_title.'
            '.$main_heading.'
            '.$desc.'
            <div class="intro-btn mt-20">
             '.$main_btn.'
			'.$sec_btn.'
            </div>
          </div>
        </div>
      </div>
    </div>
</div>';
	}
}

//Hero Section 8
if( !function_exists('propertya_elementor_hero8') )
{
	function propertya_elementor_hero8($params)
	{
		$search_page = '#';
		$main_btn = $meta_query = $top_title = $show_data = $background = $main_img = $sub_title = $sec_btn = $main_btn = $desc = $main_heading = '';
		$search_page = propertya_framework_get_link('page-property-search.php');
		if(!empty($params['heading_text']))
		{
			$main_heading = ' <h2>'.propertya_framework_color_text($params['heading_text']).'  </h2>';
		}
		if(!empty($params['desc']))
		{
			$desc = '<h3>'.$params['desc'].' </h3>';
		}
		return '<div class="home-hero-eight">
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-12 col-lg-7">
        <div class="heading-zones">
          '.$main_heading.'
          '.$desc.'
        </div>
        <form method="get" action="'.esc_url($search_page).'">
          <div class="hero-eight-filters justify-content-md-center">
            <div class="input-group">
				<div class="typeahead__container custom-style-frontend">
					<div class="typeahead__field">
						<div class="typeahead__query">
      						<input type="text" name="by_title"  autocomplete="off" class="prop_get_smple form-control is_smple" placeholder="'.esc_attr($params['place_text']).'">
						</div>
					</div>
					</div>
				<span class="input-group-append">
				  <button class="btn btn-white btn-lg get-my-location" type="button"><i class="fas fa-location-arrow"></i></button>
				 <button class="btn btn-theme" type="submit">'.esc_html($params['btn_text']).'</button>
				</span>
          </div>
		<div class="radius-dropdown none">
			<div class="radius-menu-dropdown">
			  <div class="radius-menu-dropdown-area">
				<div class="distance-slider price-range-slider ">
				  <label>'.esc_html__('Select Distance','propertya-framework').'</label>
				  <div class="my_distance_slider nstSlider" data-range_min="1" data-range_max="500" data-cur_min="20">
					<div class="bar"></div>
					<div class="leftGrip">
					  <div class="grip-label">
						<span class="leftLabel"></span> <span class="dis-km">'.esc_html__('KM','propertya-framework').'</span>
					  </div>
					</div>
				  </div>
				</div>
			  </div>
			</div>
		</div>
		<input type="hidden" name="latt" value="">
		<input type="hidden" name="long" value="">
		<input type="hidden" name="distance" value="">
       
      </div>
	   </form>
    </div>
  </div>
</div>
</div>';
	}
}

//Blocks
if( !function_exists('propertya_elementor_block') )
{
	function propertya_elementor_block($params)
	{
		$margin = $icon = $blocks_html = '';
		if(!empty($params['blocks']) && is_array($params['blocks']) && count($params['blocks']) > 0)
		{
			$count  = 1;
			foreach($params['blocks'] as $data)
			{
				if(!empty($data['icon']['value']))
				{
					$icon = '<i class="'.esc_attr($data['icon']['value']).'"></i>';
				}
				if ($count%3 == 0)
				{
					$margin = 'margin-bottom-30';
				}
				/*echo'<style>
				   .hover-class-'.esc_attr($count).':hover {
					background: url("'.$data['image'].'") no-repeat scroll center center / cover;
					color: #fff;
					border-radius: 4px;
					height: auto;
				  }
    			</style>';*/
				$blocks_html .= '<div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 '.esc_attr($margin).'">
					<div class="pro-detail hover-class-'.esc_attr($count).'">
					  <div class="parali"> <span class="icons">'.$icon.'</span>
						<h2 class="text-capitalize">'.esc_html($data['title']).'</h2>
						<p class="mb-0">'.$data['content'].'</p>
					  </div>
					</div>
				  </div>';
				$count++;	  
			}
		}
		
		return '<div class="home-6-sec2 ">
  <div class="container">
    <div class="row">
		'.$blocks_html.'
    </div>
  </div>
</div>';
	}
}


//All Listings
if( !function_exists('propertya_elementor_all_listings') )
{
	function propertya_elementor_all_listings($params)
	{
		
		$loadmore_btn = $heading_zone = '';
		require SB_PLUGIN_PATH . 'plugin-files/shortcodes/listings.php';
		if ($results->max_num_pages > 1 )
		{
			$loadmore_btn = '<div class="is-show-load-more fetch-more-records text-center">
						<button type="button" class="fetch_dynamic_results btn btn-theme sonu-button margin-bottom-30 margin-top-10" data-limit="'.esc_attr($params['no_of_post']).'" data-listingtype="'.esc_attr($params['listing_type']).'" data-orderby="'.esc_attr($params['orderby']).'" data-layouttype="'.esc_attr($params['layout']).'"  data-typestatus="'.esc_attr($params['listing_status']).'" data-locationid="'.esc_attr($params['location_id']).'" data-maxpages="'.esc_attr($results->max_num_pages).'" data-category="'.esc_attr($cat_ids).'" data-page="1" data-coltype="'.esc_attr($params['listing_column']).'">'.esc_html__('Load More','propertya-framework').'</button>
					</div>';
		}
		return '<section class="all-listings custom-padding">
					<div class="container">
						'.propertya_framework_section_headings($params['subtitle'],$params['maintitle'],$params['heading_style']).'
						<div class="row grids dynamic_loading">
						'.$fetch_output.'
						</div>
						'.$loadmore_btn.'
					</div>
		   	   </section>';
	}
}

//All Blogs
if( !function_exists('propertya_elementor_all_blogs') )
{
	function propertya_elementor_all_blogs($params)
	{
        $postion = 'pl-3';
        if(is_rtl())
        {
            $postion = 'pr-3';
        }
		$comments_count = $thumbnail = $blog_posts = $recent_posts = '';
		$args = array('post_status' => 'publish', 'numberposts' => $params['no_of_post']);
		$recent_posts = wp_get_recent_posts( $args );
		foreach( $recent_posts as $recent )
		{
			 $thumbnail = '';
			if ( has_post_thumbnail($recent["ID"]) ):
				$thumbnail = '<div class="image"><a href="'.esc_url(get_the_permalink($recent["ID"])).'">
						'.get_the_post_thumbnail($recent["ID"], 'propertya-blog-thumb') .' </a>				
				</div>';  
			endif;
			if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) :
				$comments_count .= '<div class="comment_count">
									   <span class="comment_count_in">
									   <i class="far fa-comment-alt"></i> '.propertya_blogcomments_count().'
									   </span>
						           </div>';
			 endif;
			$blog_posts .= '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 margin-bottom-30 grid-item">
			  <div class="blog-inner-box">
				'.$thumbnail.'
				<div class="blog-lower-box">
				'.$comments_count.'
				 <span class="blog-date">'.get_the_time( get_option( 'date_format' ), $recent["ID"]).'</span>
				   <h2><a href="'.esc_url(get_the_permalink($recent["ID"])).'">'.esc_html($recent["post_title"] ).'</a></h2>
				  <p>'. wp_trim_words( get_the_excerpt($recent["ID"]), 15 ).'</p>
				</div>
				 <div class="blog-read-more"> 
				 <a href="'.esc_url(get_the_permalink($recent["ID"])).'" class="clr-black">'.esc_html__('Read More','propertya-framework').'
				 <i class="fas fa-long-arrow-alt-right '.esc_attr($postion).'"></i></a> </div>
			  </div>
		</div>';
		}
		wp_reset_query();
		return '<section class="blog-section-2 custom-padding">
					<div class="container">
						'.propertya_framework_section_headings($params['subtitle'],$params['maintitle'],$params['heading_style']).'
						<div class="row">
							'.$blog_posts.'
						</div>
					</div>				
				</section>';
	}
}

//Testimonials
if( !function_exists('propertya_elementor_testimonials') )
{
	function propertya_elementor_testimonials($params)
	{
		$testimonials_html = '';
		if(!empty($params['blocks']) && is_array($params['blocks']) && count($params['blocks']) > 0)
		{
			foreach($params['blocks'] as $data)
			{
				$testimonials_html .= '<div class="item">
				<div class="row">
				  <div class="col-sm-12 col-md-4">
					<div class="iner-img"> 
						<img src="'.esc_url($data['image']).'" class="img-fluid img-full" alt=""/>
					</div>
				  </div>
				  <div class="col-sm-12 col-md-8 my-auto">
					<div class="testi-data">
					  <div class="testi-text clearfix">
						<p>'.esc_html($data['content']).'</p>
						<div class="clearfix"></div>
						<div class="comenter clearfix d-block">
						  <h3>'.esc_html($data['feedback']).'</h3>
						  <p class="mb-0">'.esc_html($data['type']).'</p>
						</div>
					  </div>
					</div>
				  </div>
				</div>
			  </div>';
			}
		}
		return '<div class="home-6-sec4 section-padding-60">
					<div class="container">
						<div class="testi-home6 full-width-testimonials owl-carousel owl-theme">
						  	'.$testimonials_html.'
						</div>
					</div>
				</div>';
	}
}

//Modern Testimonials
if( !function_exists('propertya_elementor_testimonials_2') )
{
	function propertya_elementor_testimonials_2($params)
	{
		$testimonials_html = '';
		if(!empty($params['blocks']) && is_array($params['blocks']) && count($params['blocks']) > 0)
		{
			foreach($params['blocks'] as $data)
			{
				$testimonials_html .= '<div class="col-lg-4 col-md-6 col-12">
					<div class="testimonials-item">
						  <div class="client-info">
								<div class="img">
								<img src="'.esc_url($data['image']).'" alt="">
								</div>
								<div class="client-title">
								<h4>'.esc_html($data['feedback']).'</h4>
								<span>'.esc_html($data['type']).'</span>
							</div>
						   </div>
						 <p>'.esc_html($data['content']).'</p>
					  <i class="fas fa-quote-left"></i>
					</div>
				</div>';
			}
		}
		$partners_html = '';
		if(!empty($params['cleints_blocks']) && is_array($params['cleints_blocks']) && count($params['cleints_blocks']) > 0)
		{
			$partners_html.= '<div class="row">
						  <div class="social-ads owl-carousel owl-theme">';
			foreach($params['cleints_blocks'] as $data)
			{
				$partners_html.= '<div class="item">
				  <div class="col-12 text-center">
					<div class="social-add">
					 <img src="'.esc_url($data['image']).'" alt="" class="img-fluid img-full">
					</div>
				  </div>
				</div>';
			}
			$partners_html.= ' </div>
						</div>';
		}
		return '<section class="testimonials-modern-1 section-padding">
					<div class="container">
						'.propertya_framework_section_headings($params['subtitle'],$params['maintitle'],$params['heading_style']).'
						<div class="row no-gutters">
							'.$testimonials_html.'
						</div>
						'.$partners_html.'
					</div>
				</section>';
	}
}

//Classic Testimonials
if( !function_exists('propertya_elementor_testimonials_3') )
{
	function propertya_elementor_testimonials_3($params)
	{
		$testimonials_html = '';
		if(!empty($params['blocks']) && is_array($params['blocks']) && count($params['blocks']) > 0)
		{
			foreach($params['blocks'] as $data)
			{
				$testimonials_html .= '<div class="col-12">
					<blockquote>
					 '.esc_html($data['content']).'
					</blockquote>
					<div class="testimonialArrow"></div>
					<div>
					  <img class="user-avatar" src="'.esc_url($data['image']).'" alt="" width="86" height="86" />
					  <div class="author">
						<h3>'.esc_html($data['feedback']).'</h3>
						'.esc_html($data['type']).'
					  </div>
					</div>
     			 </div>
				 ';
			}
		}
		return '<section class="testimonials-classic-1 section-padding">
					<div class="container">
						'.propertya_framework_section_headings($params['subtitle'],$params['maintitle'],$params['heading_style']).'
						<div class="row">
							<div class="testimonial-classic owl-carousel owl-theme">
								'.$testimonials_html.'
							</div>	
						</div>
					</div>
				</section>';
	}
}

//All Partners
if( !function_exists('propertya_elementor_partners') )
{
	function propertya_elementor_partners($params)
	{
		$partners_html = '';
		if(!empty($params['blocks']) && is_array($params['blocks']) && count($params['blocks']) > 0)
		{
			foreach($params['blocks'] as $data)
			{
				$partners_html.= '<div class="item">
				  <div class="col-12 text-center">
					<div class="social-add">
					 <img src="'.esc_url($data['image']).'" alt="" class="img-fluid img-full">
					</div>
				  </div>
				</div>';
			}
		}
		return '<section class="about-section-2">
				  <div class="container">
					<div class="row">
					  <div class="social-ads  owl-carousel owl-theme ">
							'.$partners_html.'
					  </div>
					</div>
				  </div>
				</section>';		
	}
}

//Funfacts
if( !function_exists('propertya_elementor_funfacts1') )
{
	function propertya_elementor_funfacts1($params)
	{
		$counter = $video_html = $tagline = $desc = $main_heading = '';
		if(!empty($params['main_heading']))
		{
			$main_heading = '<h2 class="my-2">'.propertya_framework_color_text($params['main_heading']).' </h2>';
		}
		if(!empty($params['tagline']))
		{
			$tagline = '<p class="mb-0 clr-white">'.esc_html($params['tagline']).' </p>';
		}
		if(!empty($params['description']))
		{
			$desc = '<p class="mt-2 clr-white">'.propertya_framework_color_text($params['description']).' </p>';
		}
		if(!empty($params['videolink']) && !empty($params['videobg']))
		{
			$video_html = '<div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
				<div class="video-img"> <img src="'.esc_url($params['videobg']).'" class="img-fluid" alt=""/>
				  <div class="v-icon"> <a class="txt-dec" href="'.esc_url($params['videolink']).'"> <img src="'.esc_url(SB_PLUGIN_URL . 'libs/images/videoicon.png').'" class="img-fluid" alt="agent"> </a> </div>
				</div>
			  </div>';
		}
		if(!empty($params['blocks']) && is_array($params['blocks']) && count($params['blocks']) > 0)
		{
			$counter.= '<div class="w-exp"><ul class="list-unstyled">';
			foreach($params['blocks'] as $data)
			{
				$counter.= '<li class="list-inline-item"> <span class="clr-blu"><span class="ab1">'.$data['number'].'</span><span>+</span></span>
                <p>'.esc_html($data['text']).'</p>
              </li>';
			}
			$counter.= '</ul></div>';
		}
		return '<section class="home-6-sec7">
				  <div class="container-fluid pr-0">
					<div class="row no-gutters">
					  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 align-self-center overlay-text">
						<div class="brs col-sm-12 col-md-12 col-lg-12 col-xl-9 float-right  align-items-center justify-content-center">
						  '.$tagline.'
						  '.$main_heading.'
						  '.$desc.'
						  '.$counter.'
						</div>
					  </div>
					  '.$video_html.'
					</div>
				  </div>
			 </section>';
	}
}

//Minimal Funfacts
if( !function_exists('propertya_elementor_funfacts2') )
{
	function propertya_elementor_funfacts2($params)
	{
		$fun_html = '';
		if(!empty($params['funfacts']) && is_array($params['funfacts']) && count($params['funfacts']) > 0)
		{
			foreach($params['funfacts'] as $fun)
			{
				$fun_html .= '<div class="col-sm-6 col-lg-3 margin-bottom-30 counter-inner">
					   <span><img src="'.esc_url($fun['icon_img']).'" class="img-fluid" alt=""></span>
					   <div class="min-cont">
					   <b><span class="ag-counter">'.$fun['number'].'</span><span>+</span></b><p>'.esc_html($fun['text']).'</p>
					   </div>
				</div>';
			}
		}
		return '<section class="mimimal-counter">
				 <div class="container">
					  <div class="border-counter">	 
						  <div class="row">
							  '.$fun_html.'
						  </div>
					  </div>	  
 				</div>	
			   </section>';
	}
}


//All Agencies
if( !function_exists('propertya_elementor_all_agencies') )
{
	function propertya_elementor_all_agencies($params)
	{
		$fetch_output = $loadmore_btn = $heading_zone = '';
		require SB_PLUGIN_PATH . 'plugin-files/shortcodes/agencies.php';
		if ($results->max_num_pages > 1 )
		{
			$margin_top = '';
			if(isset($params['layout']) && $params['layout'] == 'grid6')
			{
				$margin_top = 'margin-top-40';
			}
			$loadmore_btn = '<div class="fetch-more-records text-center '.esc_attr($margin_top).'">
						<button type="button" class="fetch_dynamic_agencies btn btn-theme agency-btnload margin-bottom-30 margin-top-10" data-limit="'.esc_attr($params['no_of_post']).'" data-listingtype="'.esc_attr($params['type']).'" data-orderby="'.esc_attr($params['order']).'" data-layouttype="'.esc_attr($params['layout']).'" data-maxpages="'.esc_attr($results->max_num_pages).'"  data-page="1">'.esc_html__('Load More','propertya-framework').'</button>
					</div>';
		}
		$is_border = '';
		$is_gutter = '';
		$dynamic_loading = 'grid dynamic_loading_agencies';
		$margin_bottom = '';
		$section_class = 'custom-padding';
		if(isset($params['layout']) && $params['layout'] == 'grid6')
		{
			$is_border = 'border-top-left';
			$is_gutter = 'no-gutters';
			$dynamic_loading = 'dynamic_loading_agencies';
			$section_class = 'section-padding';
		}

		return '<section class="all-agencies agency-1 agent-section '.esc_attr($section_class).'">
					<div class="container">
						'.propertya_framework_section_headings($params['subtitle'],$params['maintitle'],$params['heading_style']).'
						<div class="row '.esc_attr($is_gutter).' '.esc_attr($is_border).' '.esc_attr($dynamic_loading).' ">
						'.$fetch_output.'
						</div>
						'.$loadmore_btn.'
					</div>
		   	   </section>';
	}
}


//All Agents
if( !function_exists('propertya_elementor_all_agents') )
{
	function propertya_elementor_all_agents($params)
	{
		$fetch_output = $loadmore_btn = $heading_zone = '';
		require SB_PLUGIN_PATH . 'plugin-files/shortcodes/agents.php';
		if ($results->max_num_pages > 1 )
		{
			$loadmore_btn = '<div class="fetch-more-records text-center">
						<button type="button" class="fetch_dynamic_agents btn btn-theme agents-btnload" data-limit="'.esc_attr($params['no_of_post']).'" data-listingtype="'.esc_attr($params['type']).'" data-orderby="'.esc_attr($params['order']).'" data-layouttype="'.esc_attr($params['layout']).'" data-maxpages="'.esc_attr($results->max_num_pages).'"  data-page="1">'.esc_html__('Load More','propertya-framework').'</button>
					</div>';
		}
		return '<section class="all-agents agents-section custom-padding">
					<div class="container">
						'.propertya_framework_section_headings($params['subtitle'],$params['maintitle'],$params['heading_style']).'
						<div class="row grid dynamic_loading_agents">
						'.$fetch_output.'
						</div>
						'.$loadmore_btn.'
					</div>
		   	   </section>';
	}
}

//Categories with subcats
if( !function_exists('propertya_elementor_all_categories') )
{
	function propertya_elementor_all_categories($params)
	{
		//categories
		$sub_cats = $inner_childs = $return_html =  $cat_ids = '';
		$categories = array();
		
		
		if(!empty($params['types']) && is_array($params['types']) && count($params['types']) > 0)
		{
			$inner_childs = '';$term_img = $term_name = '';
			foreach($params['types'] as $data)
			{
				$inner_childs = ''; $term_img = $term_name = '';
				if(!empty($data['type_slug']))
				{
					$get_term = get_term_by('slug', $data['type_slug'], 'property_type');
					if(!empty($get_term) &&  count((array) $get_term) > 0)
					{
						$term_name = '<div class="cat-type-title">
							   <h4><a class="clr-black" href="'.esc_url(get_term_link($get_term->slug, 'property_type')).'">'.esc_html($get_term->name).'</a></h4>
							   </div>';
						$term_img = '<div class="img"><img src="'.esc_url($data['image']).'" alt=""></div>';
						//sub cats
						$sub_cats = get_terms( 'property_type', array( 'parent' => $get_term->term_id,  'hide_empty'    => false, 'number' => $params['no_of_post'] ) );
						if ( ! empty($sub_cats) ) {
					  $inner_childs .='<ul class="category-list-data">';
					  foreach( $sub_cats as $child )
					  {
						$inner_childs .='<li>
							<a href="'.esc_url(get_term_link($child->slug, 'property_type')).'">
							'.esc_html($child->name).'<span>('.esc_html($child->count).')</span>
							</a>
						</li>';  
					  }
					$inner_childs .='</ul>';
					$return_html .= '<div class="col-lg-3 col-md-6 col-12">
										<div class="all-type-cats">
											<div class="cat-type-img">
												'.$term_img.'
											     '.$term_name.'
										     </div>
										  '.$inner_childs.'
										  <div class="asd">
										  '.$term_img.'
										  </div>
										</div>
								 </div>';
				}
						  
					}
				}
			}
		}
		
		
		
	/*	if(!empty($params['categories']) && is_array($params['categories']) && count($params['categories']) > 0)
		{
			$inner_childs = '';
			foreach ($params['categories'] as $cats)
			{
				$term_img = '';
				$sub_cats = '';
				$inner_childs = '';
				$parent_term  = get_term_by('id', $cats, 'property_type');
				$image_id = get_term_meta($parent_term->term_id,'property_type_term_meta_img', true );
				if(isset($image_id) && $image_id !="")
				{
					$term_img = wp_get_attachment_image ( $image_id, 'thumbnail' );
				}
				else
				{
					$img = SB_PLUGIN_URL . "libs/images/placeholder.png";
					$term_img =  '<img src="'.esc_url($img).'">';
				}
				$sub_cats = get_terms( 'property_type', array( 'parent' => $cats,  'hide_empty'    => false, 'number'        => $params['no_of_post'] ) );
				if ( ! empty($sub_cats) ) {
					  $inner_childs .='<ul class="category-list-data">';
					  foreach( $sub_cats as $child )
					  {
						$inner_childs .='<li>
							<a href="'.esc_url(get_term_link($child->slug, 'property_type')).'">
							'.esc_html($child->name).'<span>('.esc_html($child->count).')</span>
							</a>
						</li>';  
					  }
					$inner_childs .='</ul>';
					$return_html .= '<div class="col-lg-3 col-md-6 col-12">
										<div class="all-type-cats">
										<div class="cat-type-img">
											<div class="img">
												'.$term_img.'
											</div>
											  <div class="cat-type-title">
											   <h4><a class="clr-black" href="'.esc_url(get_term_link($parent_term->slug, 'property_type')).'">'.esc_html($parent_term->name).'</a></h4>
											   </div>
										   </div>
										  '.$inner_childs.'
										  <div class="asd">
										  '.$term_img.'
										  </div>
										</div>
								 </div>';
				}
			}
		}
		*/
		return '<section class="all-types section-padding">
				<div class="container">
					'.propertya_framework_section_headings($params['subtitle'],$params['maintitle'],$params['heading_style']).'
					<div class="row no-gutters">
						'.$return_html.'								 
					 </div>
				</div>
			</section>';
	}
}

//Property Type With Slider
if(!function_exists('propertya_elementor_all_type_with_slide'))
{
	function propertya_elementor_all_type_with_slide($params)
	{
	
		$slider_html = '';
		if(!empty($params['types']) && is_array($params['types']) && count($params['types']) > 0)
		{
			foreach($params['types'] as $data)
			{
				if(!empty($data['type_slug']))
				{
					$get_term = get_term_by('slug', $data['type_slug'], 'property_type');
					if(!empty($get_term) &&  count((array) $get_term) > 0)
					{
						$slider_html .= '<div class="item">
									<div class="prop-card">
									<div class="featured-ribbon">
										<div><i class="fas fa-star"></i></div>
									</div>
									<a class="card bg-img-cover prop-card-min-height" href="'.esc_url(get_term_link($get_term->slug, 'property_type')).'" style="background-image: url('.esc_url($data['image']).');">
                <div class="card-body">
                  <span class="d-block font-weight-bold">'.wp_sprintf(__('%s Properties', 'propertya-framework'),$get_term->count).'</span>
                  <h3 class="text-white">'.esc_html($get_term->name).'</h3>
                </div>
                <div class="card-footer pt-0">
                  <span class="font-weight-bold">'.esc_html__('View Details','propertya-framework').'</span>
                </div>
				<div class="img-overlay-top"></div>
              </a>
				</div>
				</div>';
					}
				}
			}
		}
		
		return '<section class="all-types section-padding">
				<div class="container">
					'.propertya_framework_section_headings($params['subtitle'],$params['maintitle'],$params['heading_style']).'
					<div class="row">
						<div class="col-xl-12">
							<div class="prop-types-carsol owl-carousel owl-theme">
								'.$slider_html.'
							</div>
						</div>
					 </div>
				</div>
			</section>';
	}
}

//Property Type Categories Boex
if( !function_exists('propertya_elementor_all_type_cat_boxes') )
{
	function propertya_elementor_all_type_cat_boxes($params)
	{
		$slider_html = '';
		if(!empty($params['types']) && is_array($params['types']) && count($params['types']) > 0)
		{
			//$slider_html .= '<ul class="popular-categories">';
			foreach($params['types'] as $data)
			{
				if(!empty($data['type_slug']))
				{
					$get_term = get_term_by('slug', $data['type_slug'], 'property_type');
					if(!empty($get_term) &&  count((array) $get_term) > 0)
					{
						$slider_html .= '<div class="col-xl-3 col-lg-3 col-md-6 col-12 ">
						<div class="type-3-box">
						<a href="'.esc_url(get_term_link($get_term->slug, 'property_type')).'">
						<div class="cat-icons"><img src="'.esc_url($data['image']).'" alt=""></div>
						'.esc_html($get_term->name).'
						<span>('.wp_sprintf(__('%s Properties', 'propertya-framework'),$get_term->count).')</span>
						</a>
						</div>
						</div>';
					}
				}
			}
			//$slider_html .= '</ul>';
		}
		return '<section class="all-types custom-padding">
				<div class="container">
					'.propertya_framework_section_headings($params['subtitle'],$params['maintitle'],$params['heading_style']).'
					<div class="row">
							'.$slider_html.'
					 </div>
				</div>
			</section>';
	}
}

//How It Works One
if( !function_exists('propertya_elementor_how_it_works_one') )
{
	function propertya_elementor_how_it_works_one($params)
	{
		$fun_html = $blocks_html = $margin = $icon = $blocks_html = '';
		if(!empty($params['blocks']) && is_array($params['blocks']) && count($params['blocks']) > 0)
		{
			$count  = 1;
			foreach($params['blocks'] as $data)
			{
				if(!empty($data['icon']['value']))
				{
					$icon = '<i class="'.esc_attr($data['icon']['value']).'"></i>';
				}
				$blocks_html .= '<div class="col-lg-4 margin-bottom-30">
				   <div class="home-counts ">
					 <div class="counts-inner">
						'.$icon.'
						<span class="numbers">'.esc_html(sprintf('%02d', $count)).'</span>
					   </div> 
				   </div>
				  <div class="work-inner">
				   <div class="work-description">
					 <h4>'.esc_html($data['title']).'</h4> 
					 <p>'.$data['content'].'</p> 
				   </div>	  
				  </div>	 
				 </div>';
				$count++;	  
			}	
		}
		
		if(!empty($params['funfacts']) && is_array($params['funfacts']) && count($params['funfacts']) > 0 && $params['show_fun'] == 'yes')
		{
			foreach($params['funfacts'] as $fun)
			{
				
				$fun_html .= '<div class="col-sm-6 col-lg-3 margin-bottom-30 ">
				 <div class="counter-inner">
					   <span><img src="'.esc_url($fun['icon_img']).'" class="img-fluid" alt=""></span><b><span class="ag-counter">'.$fun['number'].'</span><span>+</span></b><p>'.esc_html($fun['text']).'</p>
				  </div>	
				</div>';
			}
		}
		
		return '<section class="home-work padding-top-80">
  <div class="container">
     '.propertya_framework_section_headings($params['subtitle'],$params['maintitle'],$params['heading_style']).'
	<div class="row">
	  '.$blocks_html.'	
   </div>	  
  </div>	 
	 
  <div class="container-fluid px-0 margin-top-50">
  <div class="border-counter">	
 <div class="container">	  
  <div class="row">
	'.$fun_html.'
  </div>
 </div>	 
  </div>	  
 </div>	 
 </section>	';
	}
}


//Our Services
if( !function_exists('propertya_elementor_our_services') )
{
	function propertya_elementor_our_services($params)
	{
		$fun_html = $blocks_html = $margin = $icon = $blocks_html = '';
		if(!empty($params['blocks']) && is_array($params['blocks']) && count($params['blocks']) > 0)
		{
			$count  = 1;
			foreach($params['blocks'] as $data)
			{
				if(!empty($data['icon']['value']))
				{
					$icon = '<i class="'.esc_attr($data['icon']['value']).'"></i>';
				}
				$blocks_html .= '<div class="col-xl-4 col-lg-4 col-sm-6 col-12">
				<div class="our-process-cycle">
					<img src="'.esc_url($data['image']).'" alt="">
					<h3>'.esc_html($data['title']).'</h3>
					<p>'.$data['content'].'</p>
					<span>'.esc_html(sprintf('%02d', $count)).'</span>
				</div>
			</div>';
				$count++;
			}	
		}
		return '<section class="our-services custom-padding">
				<div class="container">
					'.propertya_framework_section_headings($params['subtitle'],$params['maintitle'],$params['heading_style']).'
					<div class="row">
							'.$blocks_html.'
						</div>
				</div>
			</section>';
	}
}

//About Us
if( !function_exists('propertya_elementor_about_us') )
{
	function propertya_elementor_about_us($params)
	{
		$main_btn = $contact_details = $video_html = $second_image = $content = $first_image = $main_heading = $tagline = '';
		if(!empty($params['tagline']))
		{
			$tagline = '<p class="mytag">'.esc_html($params['tagline']).'</p>';
		}
		if(!empty($params['main_heading']))
		{
			$main_heading = '<h3>'.propertya_framework_color_text($params['main_heading']).'</h3>	';
		}
		if(!empty($params['content']))
		{
			$content = $params['content'];
		}
		if(!empty($params['first_image']))
		{
			$first_image = '<div class="video-1"><img src="'.esc_url($params['first_image']).'" class="img-fluid" alt=""></div>';
		}
		if(!empty($params['second_image']))
		{
			$second_image = '<div class="video-2"><img src="'.esc_url($params['second_image']).'" class="img-fluid" alt=""></div>';
		}
		if(!empty($params['videolink']))
		{
			$video_html = '<div class="play-btn"><div class="play-inner"><a class="txt-dec count-vid" href="'.esc_url($params['videolink']).'"><i class="fas fa-play"></i></a></div></div>';
		}
		
		if(!empty($params['phone']) || !empty($params['email']))
		{
			$or = $phone = $email = $contact_details = '';
			if(!empty($params['phone']))
			{
				$phone = '<li class="list-inline-item">
				   <i class="fas fa-mobile-alt"></i>
				   <div class="est"><div class="ext-det">'.esc_html__('Contact No','propertya-framework').':</div><b>'.esc_html($params['phone']).'</b></div>
		   		  </li>';
			}
			if(!empty($params['email']))
			{
				$email = '<li class="list-inline-item">
				   <i class="far fa-envelope-open"></i>
				   <div class="est"><div class="ext-det">'.esc_html__('Email Address','propertya-framework').':</div><b>'.esc_html($params['email']).'</b></div>
		   		  </li>';
			}
				$contact_details = '<ul class="list-unstyled">
					'.$phone.'
					'.$email.'
				</ul>';
		}
		if(!empty($params['main_btn']) && is_array($params['main_btn']) && !empty($params['main_btn']['title']))
		{
			$target = $params['main_btn']['is_external'] ? ' target="_blank"' : '';
		    $nofollow = $params['main_btn']['nofollow'] ? ' rel="nofollow"' : '';
			$main_btn = '<div class="read-more"><a href="'.esc_url($params['main_btn']['link']).'" ' . $target . $nofollow . ' class="btn btn-theme">'.esc_html($params['main_btn']['title']).'</a></div>';
		}

		return '<section class="ag-about padding-top-80 padding-bottom-50 margin-top-50">
 <div class="container">
  <div class="row no-gutters margin-bottom-30">
   <div class="col-lg-9 mx-lg-auto col-xl-6">
    <div class="video-top">	   
	<div class="about-video">
	'.$first_image.'
	'.$second_image.'
	'.$video_html.'
	</div>   
    </div>		
   </div>	  
   <div class="col-lg-9 mx-lg-auto col-xl-6">
	<div class="about-content">
	'.$tagline.'
	'.$main_heading.'	
	'.$content.'
	<div class="cal-action">
	   '.$contact_details.'  
		'.$main_btn.'
	</div>	
	</div>
   </div>	  
  </div>
 </div>	
</section>';
	}
}

//Locations
if( !function_exists('propertya_elementor_selective_locations') )
{
	function propertya_elementor_selective_locations($params)
	{
		$details = $locations_html = $img_url = '';
		if(!empty($params['locations']) && is_array($params['locations']) && count($params['locations']) > 0)
		{
			foreach($params['locations'] as $data)
			{
				$term_detail = get_term_by('slug', $data['location_id'], 'property_location');
				if (!empty($term_detail->slug))
				{
					$details = '<div class="text-over">
						<span class="texti"><a href="'.get_term_link($term_detail->slug, 'property_location').'">'.esc_html($term_detail->name).'</a></span><span class="arw"><a href="'.get_term_link($term_detail->slug, 'property_location').'"><i class="fa fa-angle-right" aria-hidden="true"></i></a></span>
						<p>'.wp_sprintf(__('%s Properties', 'propertya-framework'),$term_detail->count).'</p>   
					</div>';
					if(!empty($data['image']))
					{
						$img_url = '<a href="'.get_term_link($term_detail->slug, 'property_location').'" class="image-link"> <img src="'.esc_url($data['image']).'" class="img-fluid rounded" alt="">  </a>';
					}
					$locations_html.= '<div class="col-sm-6 col-lg-3 col-12 margin-bottom-30">
						<div class="city-inner">
							'.$img_url.'
							'.$details.'	  
						</div>
					</div>';
				}
			}
		}
		return '<section class="city-property custom-padding">
				<div class="container">
					'.propertya_framework_section_headings($params['subtitle'],$params['maintitle'],$params['heading_style']).'
					<div class="row">
      					'.$locations_html.'
					</div>	
				</div>
			</section>';	
	}
}

//Locations Style 2
if( !function_exists('propertya_elementor_selective_locations_style2') )
{
	function propertya_elementor_selective_locations_style2($params)
	{
		$details = $locations_html = $img_url = '';
		if(!empty($params['locations']) && is_array($params['locations']) && count($params['locations']) > 0)
		{
			foreach($params['locations'] as $data)
			{
				$term_detail = get_term_by('slug', $data['location_id'], 'property_location');
				if (!empty($term_detail->slug))
				{
					$details = '<div class="country-description-overlay">
					   <div class="country-description">
							<h2 class="country-name">'.esc_html($term_detail->name).'</h2>
							<p class="country-ads"> '.wp_sprintf(__('%s Properties', 'propertya-framework'),$term_detail->count).' </p>
					   </div>
					</div>';
					if(!empty($data['image']))
					{
						$img_url = '<div class="country-images"><img src="'.esc_url($data['image']).'" class="img-fluid" alt=""></div>';
					}
					
					$locations_html.= '<div class="col-xl-4 col-sm-12 col-lg-4 col-xs-12 col-md-6"><a href="'.get_term_link($term_detail->slug, 'property_location').'">
					
					<div class="country-box">
						'.$img_url.'
						'.$details.'
					 </div>
					  </a></div>';
				}
			}
		}
		return '<section class="cities-section custom-padding">
				<div class="container">
					'.propertya_framework_section_headings($params['subtitle'],$params['maintitle'],$params['heading_style']).'
					<div class="row">
      					'.$locations_html.'
					</div>	
				</div>
			</section>';	
	}
}
//Our Apps
if( !function_exists('propertya_elementor_our_apps') )
{
	function propertya_elementor_our_apps($params)
	{
		$img_html = $tagline = $sec_btn = $main_btn = $desc = $main_heading = '';
		if(!empty($params['heading_text']))
		{
			$main_heading = '<h2 class="col-md-10 no-padding">'.propertya_framework_color_text($params['heading_text']).'</h2>';
		}
		if(!empty($params['desc']))
		{
			$desc = '<p class="margin-top-10">'.propertya_framework_color_text($params['desc']).' </p>';
		}
		if(!empty($params['tagline']))
		{
			$tagline = '<p class="app-tag">'.esc_html($params['tagline']).' </p>';
		}
		
		if(!empty($params['main_btn']) && is_array($params['main_btn']) && !empty($params['main_btn']['link']))
		{
			$target = $params['main_btn']['is_external'] ? ' target="_blank"' : '';
		    $nofollow = $params['main_btn']['nofollow'] ? ' rel="nofollow"' : '';
			$main_btn = '<div class="apple-div padding-top-20"> 
              <a href="'.esc_url($params['main_btn']['link']).'" ' . $target . $nofollow . ' class="btn app-download-button1"> <span class="app-store-btn1"> <i class="fab fa-apple"></i> <span> <span>'.esc_html__('Get It On','propertya-framework').'</span> <span>'.esc_html__('Apple Store','propertya-framework').' </span> </span> </span> </a> 
            </div>';
			
		}
		if(!empty($params['sec_btn']) && is_array($params['sec_btn']) && !empty($params['sec_btn']['link']))
		{
			$target = $params['sec_btn']['is_external'] ? ' target="_blank"' : '';
		    $nofollow = $params['sec_btn']['nofollow'] ? ' rel="nofollow"' : '';
			$sec_btn = '<div class="and-div padding-top-20"> 
              <a href="'.esc_url($params['sec_btn']['link']).'" ' . $target . $nofollow . '  class="btn app-download-button1"> <span class="app-store-btn1"> <i class="fab fa-google-play"></i> <span> <span>'.esc_html__('Get It On','propertya-framework').'</span> <span>'.esc_html__('Play Store','propertya-framework').' </span> </span> </span> </a> 
            </div>';
		}
		if(!empty($params['image']))
		{
			$img_html = '<div class="mobi-1"> <img src="'.esc_url($params['image']).'" class="img-fluid" alt=""/> </div>';
		}
return '<section class="main-home-sec7 custom-padding parallex">
    <div class="container">
      <div class="row margin-bottom-30">
        <div class="col-sm-12 col-md-12 col-lg-7 col-12">
          <div class="hading">
            '.$tagline.'
            '.$main_heading.'
            <div class="clearfix"></div>
            '.$desc.'
          </div>
          <div class="col-xs12 col-sm-12 col-md-12 col-12 no-padding ">
            '.$main_btn.'
			'.$sec_btn.'
          </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-5 col-12">
	     '.$img_html.'
        </div>
      </div>
    </div>
  </section>';
	}
}
//Call to action 1
if( !function_exists('propertya_elementor_call_to_action_one') )
{
	function propertya_elementor_call_to_action_one($params)
	{
		$img_html = $tagline = $sec_btn = $main_btn = $desc = $main_heading = '';
		if(!empty($params['heading_text']))
		{
			$main_heading = '<h4>'.propertya_framework_color_text($params['heading_text']).'</h4>';
		}
		if(!empty($params['desc']))
		{
			$desc = '<p>'.esc_html($params['desc']).' </p>';
		}
		if(!empty($params['tagline']))
		{
			$tagline = '<h5>'.esc_html($params['tagline']).' </h5>';
		}
		
		if(!empty($params['main_btn']) && is_array($params['main_btn']) && !empty($params['main_btn']['title']))
		{
			$target = $params['main_btn']['is_external'] ? ' target="_blank"' : '';
		    $nofollow = $params['main_btn']['nofollow'] ? ' rel="nofollow"' : '';
			$main_btn = '<a href="'.esc_url($params['main_btn']['link']).'" ' . $target . $nofollow . ' class="btn btn-theme">'.esc_html($params['main_btn']['title']).'</a>';
		}
		if(!empty($params['sec_btn']) && is_array($params['sec_btn']) && !empty($params['sec_btn']['title']))
		{
			$target = $params['sec_btn']['is_external'] ? ' target="_blank"' : '';
		    $nofollow = $params['sec_btn']['nofollow'] ? ' rel="nofollow"' : '';
			$sec_btn = '<a href="'.esc_url($params['sec_btn']['link']).'" ' . $target . $nofollow . ' class="btn btn-theme  btn-second">'.esc_html($params['sec_btn']['title']).'</a>';
		}
		return '<div class="section-padding-extra text-center call-actionz">
         <div class="container">
            <div class="row">
               <div class="col-xs-12 col-sm-12 col-md-12">
                 <div class="parallex-text">
                  '.$tagline.'
                  '.$main_heading.'
                   '.$desc.'
				   '.$main_btn.'
				   '.$sec_btn.'
                  </div>
               </div>
            </div>
         </div>
      </div>';
	}
}
//Call to action 2
if( !function_exists('propertya_elementor_call_to_action_two') )
{
	function propertya_elementor_call_to_action_two($params)
	{
		$img_html = $tagline = $sec_btn = $main_btn = $desc = $main_heading = '';
		if(!empty($params['tagline']))
		{
			$tagline = '<span>'.esc_html($params['tagline']).' </span>';
		}
		if(!empty($params['heading_text']))
		{
			$main_heading = '<h2>'.propertya_framework_color_text($params['heading_text']).'</h2>';
		}
		if(!empty($params['desc']))
		{
			$desc = '<p>'.esc_html($params['desc']).' </p>';
		}
		if(!empty($params['main_btn']) && is_array($params['main_btn']) && !empty($params['main_btn']['title']))
		{
			$target = $params['main_btn']['is_external'] ? ' target="_blank"' : '';
		    $nofollow = $params['main_btn']['nofollow'] ? ' rel="nofollow"' : '';
			$main_btn = '<a href="'.esc_url($params['main_btn']['link']).'" ' . $target . $nofollow . ' class="btn btn-theme">'.esc_html($params['main_btn']['title']).'</a>';
		}
		if(!empty($params['sec_btn']) && is_array($params['sec_btn']) && !empty($params['sec_btn']['title']))
		{
			$target = $params['sec_btn']['is_external'] ? ' target="_blank"' : '';
		    $nofollow = $params['sec_btn']['nofollow'] ? ' rel="nofollow"' : '';
			$sec_btn = '<a href="'.esc_url($params['sec_btn']['link']).'" ' . $target . $nofollow . ' class="btn btn-theme  btn-second">'.esc_html($params['sec_btn']['title']).'</a>';
		}
		if(!empty($params['image']))
		{
			$img_html = '<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12  align-self-center ">
			<div class="margin-bottom-30 ">
			 <img src="'.esc_url($params['image']).'" class="img-fluid poly-shadow" alt="">
			 </div>
      		</div>';
		}
		$icon = $blocks_html = '';
		if(!empty($params['blocks']) && is_array($params['blocks']) && count($params['blocks']) > 0)
		{
			foreach($params['blocks'] as $data)
			{
				if(!empty($data['icon']['value']))
				{
					$icon = esc_attr($data['icon']['value']);
				}
				$blocks_html .= '<div class="col col-xl-6 additional-feature mb-4">
					<div class="d-flex align-items-center mb-2">
						<span class="'.esc_attr($icon).' rounded mr-3 icon icon-color-2"></span>
						<h5 class="mb-0">'.esc_html($data['title']).'</h5>
					</div>
					<p>'.$data['content'].'</p>
				</div>';
			}
		}
		return '<section class="about-section-2 custom-padding">
		  <div class="container">
			<div class="row">
			  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 my-auto">
				<div class="brs margin-bottom-30 ">
				   '.$tagline.'
				   '.$main_heading.'
				   '.$desc.'
					<div class="row">
						'.$blocks_html.'
					</div>
				   '.$main_btn.'
				   '.$sec_btn.'
				  </div>
			  </div>
			  '.$img_html.'
			</div>
		  </div>
		</section>';
	}
}
//Call to action 3
if( !function_exists('propertya_elementor_call_to_action_three') )
{
	function propertya_elementor_call_to_action_three($params)
	{
		$img_html = $tagline = $sec_btn = $main_btn = $desc = $main_heading = '';
		if(!empty($params['tagline']))
		{
			$tagline = '<span class="heading-6">'.esc_html($params['tagline']).' </span>';
		}
		if(!empty($params['heading_text']))
		{
			$main_heading = '<h2>'.propertya_framework_color_text($params['heading_text']).'</h2>';
		}
		if(!empty($params['desc']))
		{
			$desc = '<p class="d-block">'.esc_html($params['desc']).' </p>';
		}
		if(!empty($params['main_btn']) && is_array($params['main_btn']) && !empty($params['main_btn']['title']))
		{
			$target = $params['main_btn']['is_external'] ? ' target="_blank"' : '';
		    $nofollow = $params['main_btn']['nofollow'] ? ' rel="nofollow"' : '';
			$main_btn = '<a href="'.esc_url($params['main_btn']['link']).'" ' . $target . $nofollow . ' class="btn btn-theme">'.esc_html($params['main_btn']['title']).'</a>';
		}
        $text = 'text-md-left';
        if(is_rtl())
        {
            $text = 'text-md-right';
        }
		return '<section class="section-lg">
        <div class="parallax-content">
          <div class="container">
            <div class="row row-30 text-center '.esc_attr($text).'">
              <div class="col-md-10 col-lg-7">
			    '.$tagline.'
                '.$main_heading.'
				'.$desc.'
				'.$main_btn.'
              </div>
            </div>
          </div>
        </div>
      </section>';
	}
}
    
    
//Hero Section 5
if( !function_exists('propertya_elementor_hero9') )
{
	function propertya_elementor_hero9($params)
	{
		$main_btn = $sec_btn = $img_html =  $main_heading = $desc = $search_page = '';
		$search_page = propertya_framework_get_link('page-property-search.php');
		if(!empty($params['heading_text']))
		{
			$main_heading = ' <h1>'.propertya_framework_color_text($params['heading_text']).'  </h1>';
		}
		if(!empty($params['tagline']))
		{
			$desc = '<p>'.esc_html($params['tagline']).' </p>';
		}
		$count_html = '';
		if(!empty($params['listing_count']))
		{
			$final_data = '';
			$count_prop = wp_count_posts('property');
			$final_data = str_replace('%count%', '<span>' . $count_prop->publish . '</span>',$params['listing_count']);
			$count_html = '<p class="prop-stats">'.$final_data.'</p>';
		}
        if(!empty($params['main_btn']) && is_array($params['main_btn']) && !empty($params['main_btn']['title']))
		{
			$target = $params['main_btn']['is_external'] ? ' target="_blank"' : '';
		    $nofollow = $params['main_btn']['nofollow'] ? ' rel="nofollow"' : '';
			$main_btn = '<a href="'.esc_url($params['main_btn']['link']).'" ' . $target . $nofollow . ' class="btn btn-theme">'.esc_html($params['main_btn']['title']).'</a>';
		}
		if(!empty($params['sec_btn']) && is_array($params['sec_btn']) && !empty($params['sec_btn']['title']))
		{
			$target = $params['sec_btn']['is_external'] ? ' target="_blank"' : '';
		    $nofollow = $params['sec_btn']['nofollow'] ? ' rel="nofollow"' : '';
			$sec_btn = '<a href="'.esc_url($params['sec_btn']['link']).'" ' . $target . $nofollow . ' class="btn btn-theme  btn-second">'.esc_html($params['sec_btn']['title']).'</a>';
		}
        $direction = 'text-left';
        if(is_rtl())
        {
            $direction = 'text-right';
        }
		return '<section class="my-hero-four hero-type-modern">
         <div class="container">
            <div class="row justify-content-start">
               <div class="col-lg-8 '.esc_attr($direction).'">
                  <div class="hero-four-content">
				  '.$count_html.'
				  '.$main_heading.'
                   '.$desc.'
				   '.$main_btn.'
                   '.$sec_btn.'
                  </div>
               </div>
            </div>
         </div>
      </section>';
	}
}

//Search Builder
if( !function_exists('propertya_elementor_search_builder') )
{
	function propertya_elementor_search_builder($params)
	{
		$property_search = propertya_framework_get_link('page-property-search.php');
		$class = 'with-labels';
		if($params['show_labels'] == 'yes')
		{
			$class = '';
		}
		$section_title = '';
		if(!empty($params['sec_text']))
		{
			$section_title = '<div class="col-12 col-xl-12 col-lg-12">
					<h3>'.esc_html($params['sec_text']).'</h3>
			</div>';
		}
		return '<div class="advanced-search-builder">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-12 p-5 shadow-sm bg-white my-from-padding">
                        <form method="get" action="'.esc_url($property_search).'">
                            <div class="row"> 
                                '.$section_title.'
                                '.propertya_framework_render_filters_cols($params['filter_array'], $params['show_labels']).'
                                <div class="col-md-12 col-sm-12 col-lg-'.esc_attr($params['btncolumn_size']).' col-12 col-xl-'.esc_attr($params['btncolumn_size']).'">
                                    <div class="form-group">
                                        <button type="submit" class="btn '.esc_attr($class).' btn-theme btn-block">'.esc_html($params['btn_text']).'</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>';
	}
}
//Search Builder 2
if( !function_exists('propertya_elementor_search_builder2') )
{
	function propertya_elementor_search_builder2($params)
	{
		$property_search = '#';
		$property_search = propertya_framework_get_link('page-property-search.php');
		$class = 'with-labels';
		if($params['show_labels'] == 'yes')
		{
			$class = '';
		}
		
		return '<div class="search-bar2">
				<div class="search-style-2">
				<form method="get" action="'.esc_url($property_search).'">
				  <div class="container">
					<div class="row">
					'.propertya_framework_render_filters_cols($params['filter_array'], $params['show_labels']).'	  
						<div class="col-md-6 col-sm-6 col-lg-'.esc_attr($params['btncolumn_size']).' col-12 col-xl-'.esc_attr($params['btncolumn_size']).'">
							<div class="form-group">
								<button type="submit" class="btn '.esc_attr($class).' btn-theme btn-block">'.esc_html($params['btn_text']).'</button>
							</div>
						</div>
					 </div>
				  </div>
				</form>  
			   </div>
			 </div>';
	}
}

//Search Builder 2
if( !function_exists('propertya_elementor_contactus') )
{
	function propertya_elementor_contactus($params)
	{
		$contac_us_from = $do_shortcode = '';
		if ($details = get_page_by_path($params['form_type'], OBJECT, 'wpcf7_contact_form'))
		{
			$from_id = $details->ID;
			if(!empty($from_id) && $from_id != 0)
			{
				 $do_shortcode = '[contact-form-7 id="'.esc_attr($from_id).'" title="'.get_the_title($from_id).'"]';
				 $contac_us_from = do_shortcode($do_shortcode);
			}
		}
		$email = $contact =  $location = $headoffice = '';
		if(!empty($params['headoffice']))
		{
			$headoffice = '<h6><strong>'.esc_html($params['headoffice']).'</strong></h6>';
		}
		if(!empty($params['location']))
		{
			$location = '<p>'.esc_html($params['location']).'</p>';
		}
		if(!empty($params['contact']))
		{
			$contact = '<li><span>'.esc_html__('Phone','propertya-framework').' : </span>'.esc_html($params['contact']).'</li>';
		}
		if(!empty($params['email']))
		{
			$email = '<li><span>'.esc_html__('Email','propertya-framework').' : <a href="mailto:'.$params['email'].'">'.esc_html($params['email']).'</a></span><li>';
		}
		return '<section class="section-padding contact-us">
        <div class="container">
        <div class="row">
                <div class="col-xl-5 col-md-5 col-12 main-info-area">
                  <div class="sec-heading">
										<p>'.esc_html($params['subtitle']).'</p>
										<h2>'.esc_html($params['maintext']).'</h2>
									</div>
					<p>'.esc_html($params['maintitle']).'</p>					
                    <div class="footer-address">
                        '.$headoffice.'
                        '.$location.'
                        <ul>
                            '.$contact.'
                            '.$email.'
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-7">
                	<h5>'.esc_html($params['form_heading']).'</h5>
 					'.$contac_us_from.'
            	</div>
            </div>
			</div>
    </section>';
	}
}

  
    //Search Builder 2
if( !function_exists('propertya_elementor_search_home_ajax') )
{
	function propertya_elementor_search_home_ajax($params)
	{

		$class = 'with-labels';
		if($params['show_labels'] == 'yes')
		{
			$class = '';
		}
        $grid_type = 'list1';
        if(!empty($params['layout_type']))
        {
           $grid_type = $params['layout_type'];
        }
        $args	=	array
        (
            'post_type' => 'property',
            'post_status' => 'publish',
            'posts_per_page' => get_option('posts_per_page'),
            'paged' => 1,
            'meta_key' => 'prop_is_feature_listing',
           // 'fields' => 'ids',
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
        $results = new \WP_Query($args);
        ?>
            <div class="clearfix"></div>
            <div class="home-seemless-search search-bar2 position-sticky">
				<div class="search-style-2">
				<form method="post" id="mylistings_search">
				  <div class="container">
					<div class="row">
					<?php echo propertya_framework_render_filters_cols($params['filter_array'], $params['show_labels']); ?> 
						<div class="col-md-6 col-sm-6 col-lg-<?php echo esc_attr($params['btncolumn_size']); ?> col-12 col-xl-<?php echo esc_attr($params['btncolumn_size']);?>">
							<div class="form-group">
                                <input type="hidden" name="grid-type" value="<?php echo esc_attr($grid_type); ?>">
								<button type="button" name="properties_search_home" class="btn <?php echo esc_attr($class); ?> btn-theme btn-block"><?php echo esc_html($params['btn_text']); ?></button>
							</div>
						</div>
					 </div>
				  </div>
				</form>  
			   </div>
			 </div>
             <section class="home-based-search search-section custom-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-8 col-lg-12 col-md-12 col-12">
                            <div class="row">
                                <div class="col-12 col-xl-12 col-md-12 col-sm-12">
                                    <div class="filter-sorting-bar d-flex flex-wrap justify-content-between align-items-center">
                                        <h4>
                                            <?php echo wp_sprintf(__('<span class="clr-yal"> %d </span> Results Found ', 'propertya-framework'),esc_attr($results->found_posts)); ?>
                                        </h4>
                                        <ul class="filters-nav" role="tablist">
					 <li><button type="button" name="layout-type" value="grid" class="active-grid sel-class"><i class="fas fa-th"></i></button></li>
					 <li><button type="button"  name="layout-type" value="list" class="make-me-dark sel-class"><i class="fas fa-bars"></i></button></li>
				</ul>
                                        <div class=" d-flex d-block">
                                          <span class="sort-label align-self-center"><?php echo esc_html__('Short by', 'propertya-framework'); ?>:</span>
                                          <div class="short-by">
                                            <select name="sort-by" id="sort-by-home" class="sort-selects" data-placeholder="Newest To Oldest">
                                              <option value="newest"><?php echo esc_html__('Newest To Oldest', 'propertya-framework'); ?></option>
                                              <option value="oldest"><?php echo esc_html__('Oldest To New', 'propertya-framework'); ?></option>
                                              <option value="title-asc"><?php echo esc_html__('Alphabetically [a-z]', 'propertya-framework'); ?></option>
                                              <option value="title-desc"><?php echo esc_html__('Alphabetically [z-a]', 'propertya-framework'); ?></option>
                                            </select>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="my-filer-tags"></div>
                                </div>
                            </div>
                                <div class="row grid mysearch-page">
                                    <?php
                                     $fetch_output = '';
                                     if ($results->have_posts())
                                     {
                                         require trailingslashit(get_template_directory()) . "template-parts/search/property-search/grids/home.php";
                                         echo ' '.$fetch_output;
                                     }
                                     else
                                     {
                                        echo propertya_framework_no_result_found(); 
                                     }
                                    wp_reset_postdata();
                                     ?>
                                </div> 
                                <div class="my-loading-bar">     
                                  <article class="fb-like-animation post--is-loading">
                                    <div class="paramsost__loader">
                                      <div class="loader__bar--1"></div>
                                      <div class="loader__bar--2"></div>
                                      <div class="loader__bar--3"></div>
                                      <div class="loader__bar--4"></div>
                                      <div class="loader__bar--5"></div>
                                      <div class="loader__bar--6"></div>
                                      <div class="loader__bar--7"></div>
                                      <div class="loader__bar--8"></div>
                                      <div class="loader__bar--9"></div>
                                      <div class="loader__bar--10"></div>
                                      <div class="loader__bar--11"></div>
                                      <div class="loader__bar--12"></div>
                                    </div>
                                  </article>
                                  <article class="fb-like-animation post--is-loading">
                                    <div class="post__loader">
                                      <div class="loader__bar--1"></div>
                                      <div class="loader__bar--2"></div>
                                      <div class="loader__bar--3"></div>
                                      <div class="loader__bar--4"></div>
                                      <div class="loader__bar--5"></div>
                                      <div class="loader__bar--6"></div>
                                      <div class="loader__bar--7"></div>
                                      <div class="loader__bar--8"></div>
                                      <div class="loader__bar--9"></div>
                                      <div class="loader__bar--10"></div>
                                      <div class="loader__bar--11"></div>
                                      <div class="loader__bar--12"></div>
                                    </div>
                                  </article>
                                  <article class="fb-like-animation post--is-loading">
                                    <div class="post__loader">
                                      <div class="loader__bar--1"></div>
                                      <div class="loader__bar--2"></div>
                                      <div class="loader__bar--3"></div>
                                      <div class="loader__bar--4"></div>
                                      <div class="loader__bar--5"></div>
                                      <div class="loader__bar--6"></div>
                                      <div class="loader__bar--7"></div>
                                      <div class="loader__bar--8"></div>
                                      <div class="loader__bar--9"></div>
                                      <div class="loader__bar--10"></div>
                                      <div class="loader__bar--11"></div>
                                      <div class="loader__bar--12"></div>
                                    </div>
                                  </article>
                                  <article class="fb-like-animation post--is-loading">
                                    <div class="post__loader">
                                      <div class="loader__bar--1"></div>
                                      <div class="loader__bar--2"></div>
                                      <div class="loader__bar--3"></div>
                                      <div class="loader__bar--4"></div>
                                      <div class="loader__bar--5"></div>
                                      <div class="loader__bar--6"></div>
                                      <div class="loader__bar--7"></div>
                                      <div class="loader__bar--8"></div>
                                      <div class="loader__bar--9"></div>
                                      <div class="loader__bar--10"></div>
                                      <div class="loader__bar--11"></div>
                                      <div class="loader__bar--12"></div>
                                    </div>
                                  </article>
                                  <article class="fb-like-animation post--is-loading">
                                    <div class="post__loader">
                                      <div class="loader__bar--1"></div>
                                      <div class="loader__bar--2"></div>
                                      <div class="loader__bar--3"></div>
                                      <div class="loader__bar--4"></div>
                                      <div class="loader__bar--5"></div>
                                      <div class="loader__bar--6"></div>
                                      <div class="loader__bar--7"></div>
                                      <div class="loader__bar--8"></div>
                                      <div class="loader__bar--9"></div>
                                      <div class="loader__bar--10"></div>
                                      <div class="loader__bar--11"></div>
                                      <div class="loader__bar--12"></div>
                                    </div>
                                  </article>
                                  <article class="fb-like-animation post--is-loading">
                                    <div class="post__loader">
                                      <div class="loader__bar--1"></div>
                                      <div class="loader__bar--2"></div>
                                      <div class="loader__bar--3"></div>
                                      <div class="loader__bar--4"></div>
                                      <div class="loader__bar--5"></div>
                                      <div class="loader__bar--6"></div>
                                      <div class="loader__bar--7"></div>
                                      <div class="loader__bar--8"></div>
                                      <div class="loader__bar--9"></div>
                                      <div class="loader__bar--10"></div>
                                      <div class="loader__bar--11"></div>
                                      <div class="loader__bar--12"></div>
                                    </div>
                                  </article>
                                  <article class="fb-like-animation post--is-loading">
                                    <div class="post__loader">
                                      <div class="loader__bar--1"></div>
                                      <div class="loader__bar--2"></div>
                                      <div class="loader__bar--3"></div>
                                      <div class="loader__bar--4"></div>
                                      <div class="loader__bar--5"></div>
                                      <div class="loader__bar--6"></div>
                                      <div class="loader__bar--7"></div>
                                      <div class="loader__bar--8"></div>
                                      <div class="loader__bar--9"></div>
                                      <div class="loader__bar--10"></div>
                                      <div class="loader__bar--11"></div>
                                      <div class="loader__bar--12"></div>
                                    </div>
                                  </article>
      </div>
                                <?php if(!empty(propertya_pagination_search($results))) { ?>
                                     <div class="row">
                                           <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 margin-bottom-30"> 
                                             <div id="listing_ajax_pagination"><?php echo propertya_pagination_search_home($results); ?></div>
                                          </div>
                                     </div>
                                  <?php } ?> 
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-12 col-12 seemles-home-sidebar">
                            <?php
                              if (is_active_sidebar('prop_home_ajaxseach_bar'))
                              {
                                  dynamic_sidebar('prop_home_ajaxseach_bar');
                              }
                            ?>
                        </div>
                    </div>
                </div>
             </section>
<?php
	}
}
 //inquiry form
if( !function_exists('propertya_elementor_inquiryform') )
{
	function propertya_elementor_inquiryform($params)
	{
		$inquiry_form = $do_shortcode = '';
		if ($details = get_page_by_path($params['form_type'], OBJECT, 'wpcf7_contact_form'))
		{
			$from_id = $details->ID;
			if(!empty($from_id) && $from_id != 0)
			{
				 $do_shortcode = '[contact-form-7 id="'.esc_attr($from_id).'" title="'.get_the_title($from_id).'"]';
				 $inquiry_form = do_shortcode($do_shortcode);
			}
		}
		$main_btn = $sec_btn = $email  = $headoffice = '';
		if(!empty($params['headoffice']))
		{
			$headoffice = '<h6><strong>'.esc_html($params['headoffice']).'</strong></h6>';
		}
		if(!empty($params['email']))
		{
			$email = '<li><span>'.esc_html__('Email','propertya-framework').' : <a href="mailto:'.$params['email'].'">'.esc_html($params['email']).'</a></span><li>';
		}

		if(!empty($params['main_btn']) && is_array($params['main_btn']) && !empty($params['main_btn']['title']))
		{
			$target = $params['main_btn']['is_external'] ? ' target="_blank"' : '';
		    $nofollow = $params['main_btn']['nofollow'] ? ' rel="nofollow"' : '';
			$main_btn = '<a href="'.esc_url($params['main_btn']['link']).'" ' . $target . $nofollow . ' class="btn btn-theme br-flat text-capitalize">'.esc_html($params['main_btn']['title']).'</a>';
		}
		if(!empty($params['sec_btn']) && is_array($params['sec_btn']) && !empty($params['sec_btn']['title']))
		{
			$target = $params['sec_btn']['is_external'] ? ' target="_blank"' : '';
		    $nofollow = $params['sec_btn']['nofollow'] ? ' rel="nofollow"' : '';
			$sec_btn = '<a href="'.esc_url($params['sec_btn']['link']).'" ' . $target . $nofollow . ' class="btn btn-theme btn-second">'.esc_html($params['sec_btn']['title']).'</a>';
		}
		return '<section class="section-padding contact-us">
        <div class="container">
        <div class="row">
                <div class="col-xl-5 col-md-5 col-12 inquiry-info-area">
                		<div class="sec-heading">
							<p>'.esc_html($params['subtitle']).'</p>
							<h2>'.esc_html($params['maintext']).'</h2>
						</div>
						<p>'.esc_html($params['maintitle']).'</p>
						<p>'.esc_html($params['maintitle2']).'</p>
						<div class="btn-div padding-top-60">
				  		'.$main_btn.'
				  		'.$sec_btn.'
				  		</div>
                </div>
                <div class="col-md-7">
               		 <div class="inquiry_form">
               	 		<h2>'.esc_html($params['form_heading']).'</h2>
 						'.$inquiry_form.'
            		</div>
            	</div>
            </div>
			</div>
    </section>';
	}
}   

//Packages
if( !function_exists('propertya_elementor_packages') )
{
	function propertya_elementor_packages($params)
	{
        if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))))
        {
        	
            $product = array();
            $packages_html =  $packtype = $featured_listing_expiry = $featured_listing = $listing_expiry = $regular_listing = $options_html = $package_expiry = $make_it_featured = $packages_html  = $package_id = '';
            $never_expire = propertya_strings('prop_never_exp');
            $unlimited = propertya_strings('prop_pkg_unlimited');
            $days = propertya_strings('prop_pkg_daytxt');
            $action_button = '#';
             $no_gutter = '';
            if($params['package_style'] == 'minimal')
            {
                $no_gutter = 'no-gutters';
            }
            if(!empty($params['packages']) && is_array($params['packages']) && count($params['packages']) > 0)
            {
                foreach($params['packages'] as $data)
                {
                    $packtype = $featured_listing_expiry = $featured_listing = $listing_expiry = $regular_listing = $options_html = $package_expiry = $make_it_featured = $package_id = '';
                    if(!empty($data['selected_pkg']))
                    {
                        $package_id = $data['selected_pkg'];
                        $product = new WC_Product($package_id);
                        if ( $product )
                        {
                            //package type
                            if (get_post_meta($package_id, 'prop_package_type', true) != "")
                            {
                                $packtype = get_post_meta($package_id, 'prop_package_type', true);
                            }
                            //hot package
                            if (get_post_meta($package_id, 'prop_make_package_featured', true) != "" && get_post_meta($package_id, 'prop_make_package_featured', true) == 'yes')
                            {
                                $make_it_featured = "hot-package";
                            }
                            //duration
                            if (get_post_meta($package_id, 'prop_package_expiry', true) != "")
                            {
                                $package_expiry = get_post_meta($package_id, 'prop_package_expiry', true);
                                if ($package_expiry == '-1')
                                {
                                    $options_html .= '<li class="packages-list"><span class="far fa-check-square"></span>' . propertya_strings('prop_p_exp') . ' : ' . esc_html($never_expire). '</li>';
                                } 
                                else
                                {
                                    $options_html .= '<li class="packages-list"><span class="far fa-check-square"></span>' . propertya_strings('prop_p_exp') . ' : ' . esc_html($package_expiry) . ' ' . $days . '</li>';
                                }
                            }
                            //regular listings
                            if (get_post_meta($package_id, 'prop_regular_listing', true) != "")
                            {
                                $regular_listing = get_post_meta($package_id, 'prop_regular_listing', true);
                                if ($regular_listing == '-1')
                                {
                                    $options_html .= '<li class="packages-list"><span class="far fa-check-square"></span>' . propertya_strings('prop_reg_listing') . ' : ' . esc_html($unlimited). '</li>';
                                } 
                                else
                                {
                                    $options_html .= '<li class="packages-list"><span class="far fa-check-square"></span>' . propertya_strings('prop_reg_listing') . ' : ' . esc_html($regular_listing) . '</li>';
                                }
                            }
                            //regular listings expiry
                            if (get_post_meta($package_id, 'prop_regular_listing_expiry', true) != "")
                            {
                                $listing_expiry = get_post_meta($package_id, 'prop_regular_listing_expiry', true);
                                if ($listing_expiry == '-1')
                                {
                                    $options_html .= '<li class="packages-list"><span class="far fa-check-square"></span>' . propertya_strings('prop_l_exp') . ' : ' . esc_html($never_expire) . '</li>';
                                } 
                                else
                                {
                                    $options_html .= '<li class="packages-list"><span class="far fa-check-square"></span>' . propertya_strings('prop_l_exp') . ' : ' . esc_attr($listing_expiry) . ' ' . $days . '</li>';
                                }
                            }
                            //featured listings
                            if (get_post_meta($package_id, 'prop_featured_listing', true) != "")
                            {
                                $featured_listing = get_post_meta($package_id, 'prop_featured_listing', true);
                                if ($featured_listing == '-1')
                                {
                                    $options_html .= '<li class="packages-list"><span class="far fa-check-square"></span>' . propertya_strings('prop_feat_listing') . ' : ' . esc_html($unlimited). '</li>';
                                } 
                                else
                                {
                                    $options_html .= '<li class="packages-list"><span class="far fa-check-square"></span>' . propertya_strings('prop_feat_listing') . ' : ' . esc_html($featured_listing) . '</li>';
                                }
                            }
                            //featured listings expiry
                            if (get_post_meta($package_id, 'prop_featured_listing_expiry', true) != "")
                            {
                                $featured_listing_expiry = get_post_meta($package_id, 'prop_featured_listing_expiry', true);
                                if ($featured_listing_expiry == '-1')
                                {
                                    $options_html .= '<li class="packages-list"><span class="far fa-check-square"></span>' . propertya_strings('prop_feat_for') . ' : ' . esc_html($never_expire) . '</li>';
                                } 
                                else
                                {
                                    $options_html .= '<li class="packages-list"><span class="far fa-check-square"></span>' . propertya_strings('prop_feat_for') . ' : ' . esc_attr($featured_listing_expiry) . ' ' . $days . '</li>';
                                }
                            }
                            if(is_user_logged_in())
                            {
                                $user_id = get_current_user_id();
                                if(get_user_meta($user_id, 'prop_is_free_pgk', true ) !="" && get_user_meta($user_id, 'prop_is_free_pgk', true ) == $package_id )
                                {
                                    $action_button = '<button class="btn btn-theme btn-block " disabled>'.esc_html__('Already Used','propertya-framework').'</button>';
                                }
                                else
                                {
                                    $action_button = '<button class="btn btn-theme btn-block prop-woo-packs sonu-button-'.esc_attr($package_id).'" data-product-id="' . esc_attr($package_id) . '" data-product-qty="1"  data-package-type="' . esc_attr($packtype) . '">'.esc_html__('Choose plan','propertya-framework').'</button>';
                                }
                            }
                            else
                            {
                                //cart button link
                                $action_button = '<button class="btn btn-theme btn-block prop-woo-packs sonu-button-'.esc_attr($package_id).'" data-product-id="' . esc_attr($package_id) . '" data-product-qty="1"  data-package-type="' . esc_attr($packtype) . '">'.esc_html__('Choose plan','propertya-framework').'</button>';
                            }
                            //tagline
                            $tagline = ''; 
                            if (get_post_meta($package_id, 'prop_package_tagline', true) != "")
                            {
                               $tagline = '<p class="text-warning">'.get_post_meta($package_id, 'prop_package_tagline', true).'</p>'; 
                            }
                            $packages_html .='<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 margin-bottom-30">
                            <div class="packages-grid '.esc_attr($make_it_featured).'">
                                <div class="packages-grid-content">
                                    <h3>'.get_the_title($package_id).'</h3>
                                    '.$tagline.'
                                    <div class="packages-price text-warning">
                                        <span class="packages-currency">
                                        '.$product->get_price_html().'
                                        </span>
                                    </div>
                                    <ul class="packages-features">
                                        '.$options_html.'
                                    </ul>
                                    '.$action_button.'
                                </div>
                            </div>
                        </div>';
                        }
                    }
                }
            }
            return '<section class="custom-woo-packages custom-padding">
                    <div class="container">
                        '.propertya_framework_section_headings($params['subtitle'],$params['maintitle'],$params['heading_style']).'
                        <div class="row '.esc_attr($no_gutter).'">
                            '.$packages_html.'
                        </div>
                    </div>
                </section>';
        }
	}
}

//Packages Classic
if( !function_exists('propertya_elementor_packages_classic') )
{
	function propertya_elementor_packages_classic($params)
	{
        if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))))
        {
            $packages_html = $short_desc = $heading = '';
            $product = array();
            $packtype = $featured_listing_expiry = $featured_listing = $listing_expiry = $regular_listing = $options_html = $package_expiry = $make_it_featured = $packages_html  = $package_id = '';
            $never_expire = propertya_strings('prop_never_exp');
            $unlimited = propertya_strings('prop_pkg_unlimited');
            $days = propertya_strings('prop_pkg_daytxt');
            $action_button = '#';
             $no_gutter = '';
            if(!empty($params['subtitle']) || !empty($params['maintitle']))
            {
                $is_margin = $is_centered = $main_title = $sub_title = '';
                if(!empty($params['subtitle'])) 
                {
                    $sub_title = '<p>'.esc_html($params['subtitle']).'</p>';
                }
                if(!empty($params['maintitle'])) 
                {
                    $main_title = '<h2>'.esc_html($params['maintitle']).'</h2>';
                }
                $heading = '<div class="sec-heading">'.$sub_title.''.$main_title.'</div>';
            }
            if(!empty($params['short_desc']))
            {
                  $short_desc = '<p class="font-small">'.esc_html($params['short_desc']).'</p>'; 
            }
            $product = array();
            if(!empty($params['packages']) && is_array($params['packages']) && count($params['packages']) > 0)
            {
                foreach($params['packages'] as $data)
                {
                    $packtype = $featured_listing_expiry = $featured_listing = $listing_expiry = $regular_listing = $options_html = $package_expiry = $make_it_featured = $package_id = '';
                    if(!empty($data['selected_pkg']))
                    {
                        $package_id = $data['selected_pkg'];
                        $product = new WC_Product($package_id);
                        if ( $product )
                        {
                            //package type
                            if (get_post_meta($package_id, 'prop_package_type', true) != "")
                            {
                                $packtype = get_post_meta($package_id, 'prop_package_type', true);
                            }
                            //hot package
                            if (get_post_meta($package_id, 'prop_make_package_featured', true) != "" && get_post_meta($package_id, 'prop_make_package_featured', true) == 'yes')
                            {
                                $make_it_featured = "hot-package";
                            }
                            //duration
                            if (get_post_meta($package_id, 'prop_package_expiry', true) != "")
                            {
                                $package_expiry = get_post_meta($package_id, 'prop_package_expiry', true);
                                if ($package_expiry == '-1')
                                {
                                    $options_html .= '<li class="packages-list"><span class="far fa-check-square"></span>' . propertya_strings('prop_p_exp') . ' : ' . esc_html($never_expire). '</li>';
                                } 
                                else
                                {
                                    $options_html .= '<li class="packages-list"><span class="far fa-check-square"></span>' . propertya_strings('prop_p_exp') . ' : ' . esc_html($package_expiry) . ' ' . $days . '</li>';
                                }
                            }
                            //regular listings
                            if (get_post_meta($package_id, 'prop_regular_listing', true) != "")
                            {
                                $regular_listing = get_post_meta($package_id, 'prop_regular_listing', true);
                                if ($regular_listing == '-1')
                                {
                                    $options_html .= '<li class="packages-list"><span class="far fa-check-square"></span>' . propertya_strings('prop_reg_listing') . ' : ' . esc_html($unlimited). '</li>';
                                } 
                                else
                                {
                                    $options_html .= '<li class="packages-list"><span class="far fa-check-square"></span>' . propertya_strings('prop_reg_listing') . ' : ' . esc_html($regular_listing) . '</li>';
                                }
                            }
                            //regular listings expiry
                            if (get_post_meta($package_id, 'prop_regular_listing_expiry', true) != "")
                            {
                                $listing_expiry = get_post_meta($package_id, 'prop_regular_listing_expiry', true);
                                if ($listing_expiry == '-1')
                                {
                                    $options_html .= '<li class="packages-list"><span class="far fa-check-square"></span>' . propertya_strings('prop_l_exp') . ' : ' . esc_html($never_expire) . '</li>';
                                } 
                                else
                                {
                                    $options_html .= '<li class="packages-list"><span class="far fa-check-square"></span>' . propertya_strings('prop_l_exp') . ' : ' . esc_attr($listing_expiry) . ' ' . $days . '</li>';
                                }
                            }
                            //featured listings
                            if (get_post_meta($package_id, 'prop_featured_listing', true) != "")
                            {
                                $featured_listing = get_post_meta($package_id, 'prop_featured_listing', true);
                                if ($featured_listing == '-1')
                                {
                                    $options_html .= '<li class="packages-list"><span class="far fa-check-square"></span>' . propertya_strings('prop_feat_listing') . ' : ' . esc_html($unlimited). '</li>';
                                } 
                                else
                                {
                                    $options_html .= '<li class="packages-list"><span class="far fa-check-square"></span>' . propertya_strings('prop_feat_listing') . ' : ' . esc_html($featured_listing) . '</li>';
                                }
                            }
                            //featured listings expiry
                            if (get_post_meta($package_id, 'prop_featured_listing_expiry', true) != "")
                            {
                                $featured_listing_expiry = get_post_meta($package_id, 'prop_featured_listing_expiry', true);
                                if ($featured_listing_expiry == '-1')
                                {
                                    $options_html .= '<li class="packages-list"><span class="far fa-check-square"></span>' . propertya_strings('prop_feat_for') . ' : ' . esc_html($never_expire) . '</li>';
                                } 
                                else
                                {
                                    $options_html .= '<li class="packages-list"><span class="far fa-check-square"></span>' . propertya_strings('prop_feat_for') . ' : ' . esc_attr($featured_listing_expiry) . ' ' . $days . '</li>';
                                }
                            }
                            if(is_user_logged_in())
                            {
                                $user_id = get_current_user_id();
                                if(get_user_meta($user_id, 'prop_is_free_pgk', true ) !="" && get_user_meta($user_id, 'prop_is_free_pgk', true ) == $package_id )
                                {
                                    $action_button = '<button class="btn btn-theme btn-block " disabled>'.esc_html__('Already Used','propertya-framework').'</button>';
                                }
                                else
                                {
                                    $action_button = '<button class="btn btn-theme btn-block prop-woo-packs sonu-button-'.esc_attr($package_id).'" data-product-id="' . esc_attr($package_id) . '" data-product-qty="1"  data-package-type="' . esc_attr($packtype) . '">'.esc_html__('Choose plan','propertya-framework').'</button>';
                                }
                            }
                            else
                            {
                                //cart button link
                                $action_button = '<button class="btn btn-theme btn-block prop-woo-packs sonu-button-'.esc_attr($package_id).'" data-product-id="' . esc_attr($package_id) . '" data-product-qty="1"  data-package-type="' . esc_attr($packtype) . '">'.esc_html__('Choose plan','propertya-framework').'</button>';
                            }
                            //tagline
                            $tagline = ''; 
                            if (get_post_meta($package_id, 'prop_package_tagline', true) != "")
                            {
                               $tagline = '<p class="text-warning">'.get_post_meta($package_id, 'prop_package_tagline', true).'</p>'; 
                            }
                            $packages_html .='<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 margin-bottom-30">
                            <div class="packages-grid '.esc_attr($make_it_featured).'">
                                <div class="packages-grid-content">
                                    <h3>'.get_the_title($package_id).'</h3>
                                    '.$tagline.'
                                    <div class="packages-price text-warning">
                                        <span class="packages-currency">
                                        '.$product->get_price_html().'
                                        </span>
                                    </div>
                                    <ul class="packages-features">
                                        '.$options_html.'
                                    </ul>
                                    '.$action_button.'
                                </div>
                            </div>
                        </div>';
                        }
                    }
                }
            }
            return '<section class="custom-padding packages-classic">
            <div class="container">
                <div class="row">
                    <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12 align-self-center">
                           '.$heading.'
                           '.$short_desc.'
                    </div>
            <!-- Block 10 end -->
            <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12">
                <div class="row no-gutters">
                    '.$packages_html.'
                </div>
            </div>
        </div>
			</div>
        </section>';
        }
    }
}
}
function product_exists($product_id) {
    return wc_get_product($product_id) ? true : false;
}