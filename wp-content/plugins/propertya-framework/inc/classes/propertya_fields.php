<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Classified
 * @subpackage Wp_Classified/admin
 * @author     ScriptsBundle 
 */
class Sb_Acf_Fields {
    public function __construct() {
        add_action('property_type_add_form_fields', array($this, 'propertya_framework_acf_field_term_meta_cat_template'), 10, 1);
        add_action('property_type_edit_form_fields', array($this, 'propertya_framework_acf_field_term_meta_cat_template'), 10, 1);
        add_action('edit_property_type', array($this, 'propertya_framework_acf_save_term_meta_cat_template'));
        add_action('create_property_type', array($this, 'propertya_framework_acf_save_term_meta_cat_template'));
        add_filter('propertya_framework_acf_template_fields', array($this, 'propertya_framework_acf_template_fields'), 10, 1);
        add_filter('propertya_framework_backend_fields_html', array($this, 'propertya_framework_acf_backend_fields_html_callback'), 10, 3);
        add_filter('propertya_framework_acf_frontend_html', array($this, 'propertya_framework_acf_show_frontend_fields_callback'), 10, 5);
        add_filter('propertya_change_acf_format', array($this, 'propertya_change_acf_format'));
    }

    function propertya_framework_acf_show_frontend_fields_callback($html_data = '', $fields_data = array(), $post_id = 0, $col = 'col-6', $cus_type = 'default') 
    {
		$html_data = '';
        if (isset($fields_data) && is_array($fields_data) && sizeof($fields_data) > 0) 
        {
			ob_start();
            foreach ($fields_data as $field_key => $field_val) 
            {

                $col_class = 'col-lg-6 col-md-6 col-sm-12 col-12';
                if ($col == 'col-12') 
                {
                    $col_class = 'col-lg-12 col-md-12 col-sm-12 col-12';
                }
                $acf_data = get_post_meta($post_id, $field_val['name'], true);
                if (isset($acf_data) && $acf_data != '') 
                {
                    $field_val['value'] = $acf_data;
                }
                if (isset($field_val['in_search']) && $field_val['in_search'] !== 1 && $cus_type == 'search-page') 
                {
                    continue;
                }
                $form_class = 'form-group';
                if (isset($field_val['type']) && $field_val['type'] == 'select') {
                    $field_val['class'] = $field_val['class'] . ' custom-fields-theme-selects';
                } elseif (isset($field_val['type']) && $field_val['type'] == 'checkbox') {
                    $field_val['class'] = $field_val['class'];
                    $col_class = 'col-lg-6 col-md-6 col-sm-6 col-12';
                } 
				elseif (isset($field_val['type']) &&  $field_val['type'] == 'radio') {
                    $field_val['class'] = $field_val['class'];
                    $col_class = 'col-lg-6 col-md-6 col-sm-6 col-12';
                } 
				elseif (isset($field_val['type']) && $field_val['type'] == 'true_false') {
                    $field_val['class'] = $field_val['class'];
                } else {
                    $field_val['class'] = $field_val['class'] . ' form-control';
                }
                if ((isset($field_val['type']) && $field_val['type'] == 'textarea')) 
                {
                    $col_class = 'col-lg-12 col-md-12 col-sm-12 col-12';
                }
                if (isset($field_val['type']) && $field_val['type'] == 'range') {
                    $col_class = 'col-lg-6 col-md-12 col-sm-12 col-12';
                }
                $required_html = '';
                if ($cus_type != 'search-page') 
                {
                    if (isset($field_val['required']) && $field_val['required']) 
                    {
                        $required_html = ' <small>*</small>';
                    }
                }
                $lbl_cls = '';
                $chkbox_lbl = false;
                if ($field_val['type'] == 'checkbox') {
                    $lbl_cls = ' class="style-h4s" ';
                    $chkbox_lbl = true;
                }
                ?>
				
				 <div class="<?php echo esc_attr($col_class); ?>">
					 <div class="<?php echo esc_attr($form_class); ?>">
						 <?php if(isset($field_val['label']) && $field_val['label']!='') {?>
						<label> 
							<?php
							echo esc_html($field_val['label']);
							echo $required_html;
							?>
						</label>
						<?php } ?> 
						 <?php
						 if ($cus_type == 'search-page') 
						 {
                            do_action('acf/render_field', $field_val);
                         } 
						else 
						{
							if($field_val['type'] == 'true_false')
							{
							?>
								<div class="pretty p-icon p-toggle p-plain prop-true-false">
									
									<input type="checkbox" name="acf[<?php echo esc_attr($field_val['key']); ?>]" autocomplete="off" value="1" />
									<div class="state p-success-o p-off">
										<i class="icon fas fa-thumbs-up"></i>
										<label>
											<?php
												if($field_val['ui'] == 1 && $field_val['ui_on_text']!='')
												{
													echo $field_val['ui_on_text'];
												}
											?>
										</label>
									</div>
									<div class="state p-danger-o p-on">
										<i class="icon fas fa-thumbs-down"></i>
										<label>
											<?php
												if($field_val['ui'] == 1 && $field_val['ui_off_text']!='')
												{
													echo $field_val['ui_off_text'];
												}
											?>
										</label>
									</div>
								</div>
							</div></div>
						 	<?php
								
								continue;
							}
							if($field_val['type'] == 'range')
							{
								$m_to = $m_from = $mil_values  = $selected_range  = '';
								if(!empty($field_val['value']))
								{
									$selected_range     = $field_val['value'];
									$mil_values  = explode(";", $selected_range);
									$m_from      = $mil_values[0]; 
									$m_to        = $mil_values[1];
								}
								else
								{
									$m_from      = $field_val['default_value']; 
								}
							?>
								<input type="text" class="custom-range-slider" name="acf[<?php echo esc_attr($field_val['key']); ?>]" value=""
									data-type="double"
									data-min="<?php echo esc_attr($field_val['min']); ?>"
									data-max="<?php echo esc_attr($field_val['max']); ?>"
									data-step="<?php echo esc_attr($field_val['step']); ?>"
									data-from="<?php echo esc_attr($m_from); ?>"
					   				data-to="<?php echo esc_attr($m_to); ?>"
									data-grid="true"
								/>
						 </div></div>
							<?php
								continue;
							}
							if($field_val['type'] == 'button_group')
							{
								$selected_vals = $checked = '';
								$all_data_group = $field_val['choices'];
								if(is_array($all_data_group) && !empty($all_data_group) && count($all_data_group) > 0)
								{	
									if(isset($field_val['value']) && $field_val['value'] !='')
									{
										$selected_vals = array($field_val['value']);
									}
							?>	
								<ul class="list-inline prop-btn-grp">
									<?php foreach( $all_data_group as $k=>$data ):
									$checked = '';
									if (!empty($selected_vals) && in_array( $k, $selected_vals ) )
									{
											$checked = "checked='checked'";
									}
									?>
									<li class="list-inline-item">
										<div class="pretty p-switch">
											<input type="radio" name="acf[<?php echo esc_attr($field_val['key']); ?>]" value="<?php echo esc_attr($k); ?>" <?php echo esc_attr($checked); ?>/>
											<div class="state p-primary">
												<label><?php echo esc_html($data); ?></label>
											</div>
										</div>
                    				</li>
									<?php endforeach; ?>
								</ul>
						 	</div></div>
							<?php
								}
								continue;
							}
							//if field has no label
							if($field_val['label']=='') {
								$field_val['type'] = 'hidden';
							}
							if($field_val['type'] == 'radio')
							{
								$selected_vals = $checked = '';
								$all_data = $field_val['choices'];
								if(is_array($all_data) && !empty($all_data) && count($all_data) > 0)
								{
									if(isset($field_val['value']) && $field_val['value'] !='')
									{
										$selected_vals = array($field_val['value']);
									}
							?>	
								<ul class="list-inline prop-custom-radio">
									<?php foreach( $all_data as $k=>$data ):
									if (!empty($selected_vals) && in_array( $k, $selected_vals ) )
									{
											$checked = "checked='checked'";
									}
									else
									{
										$checked = "";
									}
									?>
									<li class="list-inline-item">
										<div class="pretty p-svg p-curve">
											<input type="radio" name="acf[<?php echo esc_attr($field_val['key']); ?>]" value="<?php echo esc_attr($k); ?>" <?php echo esc_attr($checked); ?>/>
											<div class="state p-primary">
												<svg class="svg svg-icon" viewBox="0 0 20 20">
													<path d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z" style="stroke: white;fill:white;"></path>
												</svg>
												<label><?php echo esc_html($data); ?></label>
											</div>
										</div>
                    				</li>
									<?php endforeach; ?>
								</ul>
						 	</div></div>
							<?php
								}
								continue;
							}
							if($field_val['type'] == 'checkbox')
							{
								$selected_vals = $checked = '';
								$all_data_check = $field_val['choices'];
								if(is_array($all_data_check) && !empty($all_data_check) && count($all_data_check) > 0)
								{	
									if(!empty($field_val['value']) && is_array($field_val['value']) && count($field_val['value']) > 0 )
									{
										$selected_vals = $field_val['value'];
									}
							?>	
								<ul class="list-inline prop-custom-check">
									<?php 
									foreach( $all_data_check as $k=>$data ):
									if (!empty($selected_vals) && in_array( $k, $selected_vals ) )
									{
										
											$checked = "checked='checked'";
									}
									else
									{
										$checked = "";
									}
									?>
									<li class="list-inline-item">
										<div class="pretty p-svg p-curve">
											<input type="checkbox" name="acf[<?php echo esc_attr($field_val['key']); ?>][]" value="<?php echo esc_attr($k); ?>" <?php echo esc_attr($checked); ?>/>
											<div class="state p-primary">
												<svg class="svg svg-icon" viewBox="0 0 20 20">
													<path d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z" style="stroke: white;fill:white;"></path>
												</svg>
												<label><?php echo esc_html($data); ?></label>
											</div>
										</div>
                    				</li>
									<?php endforeach; ?>
								</ul>
						 	</div></div>
							<?php
								}
								continue;
							}
							$multiselect='';
							if($field_val['type'] == 'select')
							{ 
								$make_multi = '';
								if($field_val['multiple'] && $field_val['multiple'] == 1){
									 $multiselect= 'multiple';
									 $make_multi = '[]';
									}
								$selected_value = ($field_val['value']);
								$all_data_check = $field_val['choices'];
								  if(is_array($all_data_check) && !empty($all_data_check) && count($all_data_check) > 0)
								  {
								  ?>
									<select class="custom-fields-theme-selects sonuu" <?php echo esc_attr($multiselect); ?> data-sanitize="trim" data-placeholder="" name="<?php echo esc_attr($field_val['prefix']); ?>[<?php echo esc_attr($field_val['key']); ?>]<?php echo $make_multi;?>" >
										<?php 
												foreach( $all_data_check as $k=>$data ): ?>
											<?php 
													$is_selected = '';
													if($field_val['multiple'] && $field_val['multiple'] == 1){
														
														$multiselect= 'multiple';

														$is_selected = (in_array($k, $selected_value)) ? 'selected="selected"' : '';

													}
													else{
														$is_selected = ($selected_value == $k) ? 'selected="selected"' : '';
													}
											?>
										 <option value="<?php echo esc_attr($k); ?>" <?php echo $is_selected; ?>><?php echo esc_html($data); ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							 <?php
							  }
							  continue;
							}
                            echo create_field($field_val);
                       }
						 ?>
					 </div>	 
				</div>	 
                <?php
            }
			 $html_data = ob_get_contents();
        	 ob_end_clean();
			 return '<div class="row">' . $html_data . '</div>';
        }
        else
		{
			return '';
		}
    }

    function propertya_framework_acf_backend_fields_html_callback($html_data = '', $fields_data = array(), $post_id = 0) {
        ob_start();
        if (isset($fields_data) && is_array($fields_data) && sizeof($fields_data) > 0) {
            foreach ($fields_data as $field_key => $field_val) {
                $acf_data = get_post_meta($post_id, $field_val['name'], true);

                if (isset($acf_data) && $acf_data != '') {
                    $field_val['value'] = $acf_data;
                }
                ?>
                <tr class="classified-custom-fields">
                    <th> <?php echo ($field_val['label']); ?> </th>
                    <td>
                        <?php
                        //do_action('acf/render_field', $field_val);
                        echo create_field($field_val);
                        ?>
                    </td>
                </tr>
                <?php
            }
        }
        $html_data = ob_get_contents();
        ob_end_clean();
        return $html_data;
    }

    function propertya_framework_acf_save_term_meta_cat_template($term_id) {

        if (!isset($_POST['cat_template_nonce_val']) || !wp_verify_nonce($_POST['cat_template_nonce_val'], basename(__FILE__)))
            return;

        $old_template_value = get_term_meta($term_id, 'propertya_acf_template', true);
        $new_template_value = isset($_POST['propertya_acf_template']) ? $_POST['propertya_acf_template'] : '';

        if ($old_template_value && '' === $new_template_value)
            delete_term_meta($term_id, 'propertya_acf_template');
        else if ($old_template_value !== $new_template_value)
            update_term_meta($term_id, 'propertya_acf_template', $new_template_value);
    }

    function propertya_framework_acf_field_term_meta_cat_template($taxonomy) {

        $all_acf_template = $this->sb_load_all_acf_groups();
        $template_html = '';
        $stored_val = '';
        if (isset($taxonomy->term_id) && !empty($taxonomy->term_id)) {
            $stored_val = get_term_meta($taxonomy->term_id, 'propertya_acf_template', true);
            $stored_val = isset($stored_val) && $stored_val != '' ? $stored_val : '';
        }
        if (isset($all_acf_template) && !empty($all_acf_template) && is_array($all_acf_template) && sizeof($all_acf_template) > 0) 
        {
            foreach ($all_acf_template as $key => $value) 
            {
                $selected_val = $stored_val == $key ? ' selected="selected" ' : '';
                $template_html .= ' <option ' . $selected_val . 'value="' . $key . '"> ' . $value . ' </option> ';
            }
        }
        ?>
        <tr class="form-field term-parent-wrap">
            <th scope="row"><label for="parent"><?php _e('Select Template', 'propertya-framework'); ?></label></th>
            <td>
                <select name="propertya_acf_template">	
                    <option value=""><?php echo __('Select An Option', 'propertya-framework'); ?></option>
                    <option value="no_temp"><?php echo __('No Template', 'propertya-framework'); ?></option>
                    <?php echo ($template_html); ?>	
                </select>  
                <p class="description"><?php echo __('You can assign this template each level category.', 'propertya-framework'); ?></p>
                <br />
            </td>
        </tr>
        <?php wp_nonce_field(basename(__FILE__), 'cat_template_nonce_val'); ?>
        <?php
    }
	 function sb_load_all_acf_groups() 
	 {
        $fieldGroup = acf_get_field_groups();
        $groups_arra = array();
        if (isset($fieldGroup) && !empty($fieldGroup) && is_array($fieldGroup)) 
        {
            foreach ($fieldGroup as $each_group) 
            {
                if (isset($each_group['location']) && isset($each_group['location'][0][0]['param']) && $each_group['location'][0][0]['param'] == 'cat-custom-template') 
                 {
                    $groups_arra[$each_group['key']] = $each_group['title'];
                }
            }
        }
        return $groups_arra;
    }
}

new Sb_Acf_Fields();

/*
 * 
 * Adding a custom template for acf
 */

class propertya_framework_cat_template extends ACF_Location {
    public function initialize() {
        $this->name = 'cat-custom-template';
        $this->label = __("Propertya Category Template", 'propertya-framework');
    }
    public function get_values($rule) {
        $choices = array();
        $choices['cat-template'] = __("Propertya Category Template", 'propertya-framework');
        return $choices;
    }
}
add_action('acf/init', 'propertya_framework_register_acf_cat_template');
function propertya_framework_register_acf_cat_template() 
{
    if (function_exists('acf_register_location_type')) 
    {
        acf_register_location_type('propertya_framework_cat_template');
    }
}

add_action('acf/render_field_settings', 'propertya_framework_acf_render_field_settings');
function propertya_framework_acf_render_field_settings($field) 
{
    acf_render_field_setting($field, array(
        'label' => __('Display in search', 'propertya-framework'),
        'instructions' => __('Enable/Disable this field to show in search page.', 'propertya-framework'),
        'name' => 'in_search',
        'type' => 'true_false',
        'ui' => 1,
        ), true);
}

// to get group key
add_filter('propertya_framework_acf_get_group_key', 'propertya_framework_acf_get_template_key_callback', 10, 2);
if (!function_exists('propertya_framework_acf_get_template_key_callback')) 
{
    function propertya_framework_acf_get_template_key_callback($template_group_key = '', $term_id = '') 
    {
		$temp_data = get_option('propertya_options') ;
        $cat_template_type = isset($temp_data['cat_template_type']) && $temp_data['cat_template_type'] != '' ? $temp_data['cat_template_type'] : 'hierarchal';
        if ($term_id == '') 
        {
            return $template_group_key;
        }
        $template_group_key = get_term_meta($term_id, 'propertya_acf_template', true);
        if ($template_group_key == 'no_temp') 
        {
            return '';
        }
        if ($template_group_key == '' && $cat_template_type == 'hierarchal') 
        {
            $term_parents = get_ancestors($term_id, 'prop_type');
            if (isset($term_parents) && !empty($term_parents) && sizeof($term_parents) > 0) 
            {
                foreach ($term_parents as $each_parent) 
                {
                    $template_group_key = get_term_meta($each_parent, 'propertya_acf_template', true);
                    $term_id = $each_parent;
                    if ($template_group_key != '') 
                    {
                        break;
                    }
                }
                if ($template_group_key == '') 
                {
                    $template_group_key = apply_filters('propertya_framework_acf_get_group_key', '', $term_id);
                }
            }
        }
        return $template_group_key;
    }
}
//Selected Fields Against Category Id
if (!function_exists('propertya_framework_fields_by_listing_id')) {

    function propertya_framework_fields_by_listing_id($property_id = '') {

        $cats_value = get_post_meta($property_id, 'prop_type', true);
        $current_term = get_term_by( 'slug', $cats_value, 'property_type' );
		$cats_value = $current_term->term_id;
        $cats_value = isset($cats_value) && $cats_value != '' ? $cats_value : array();
        $fields_data = array();
        $template_group_key = apply_filters('propertya_framework_acf_get_group_key', '', $cats_value);
            if (isset($template_group_key) && $template_group_key != '' && class_exists('ACF')) {
                $fields_data = acf_get_fields($template_group_key);
                if ($property_id != '') {
                    foreach ($fields_data as $field_key => $field_val) {
                        $acf_data = get_post_meta($property_id, $field_val['name'], true);
                        if (isset($acf_data) && $acf_data != '') {
                            //$field_val['value'] = $acf_data;
                            $fields_data[$field_key]['value'] = $acf_data;
                        }
                    }
                }
            }
        return $fields_data;
    }
}