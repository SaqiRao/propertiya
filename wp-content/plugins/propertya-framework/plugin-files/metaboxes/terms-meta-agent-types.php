<?php
class agents_meta_types {
	public function __construct() {
		if ( is_admin() ) {
			add_action( 'agent_types_add_form_fields',  array( $this, 'propertya_framework_agents_types_fields'), 10, 1 );
			add_action( 'agent_types_edit_form_fields', array( $this, 'propertya_framework_edit_agents_types_fields' ),  10, 2 );
			add_action( 'created_agent_types', array( $this, 'propertya_framework_types_save_data' ), 10, 1 );
			add_action( 'edited_agent_types',  array( $this, 'propertya_framework_types_save_data' ), 10, 1 );
			add_action( 'admin_enqueue_scripts', array( $this, 'propertya_framework_types_load_scripts_styles'));
			add_action( 'admin_footer',array( $this, 'propertya_framework_types_add_admin_js'));
		}
	}
	public function propertya_framework_agents_types_fields( $taxonomy ) {
		// Set default values.
		$agent_type_title_color = '';
		// Form fields.
		echo '<div class="form-field term-agent_type_title_color-wrap">';
		echo '	<label for="agent_type_title_color">' . esc_html__( 'Label Color', 'propertya-framework' ) . '</label>';
		echo '	<input type="text" id="agent_type_title_color" name="agent_type_title_color" class="agent_type_color_picker" value="' . esc_attr( $agent_type_title_color ) . '"><br>';
		echo '	<p class="description">' . esc_html__( 'The hex color of the label field.', 'propertya-framework' ) . '</p>';
		echo '</div>';
	}
	public function propertya_framework_edit_agents_types_fields( $term, $taxonomy ) {
		// Retrieve an existing value from the database.
		$agent_type_title_color = get_term_meta( $term->term_id, 'agent_type_title_color', true );
		// Set default values.
		if( empty( $agent_type_title_color ) ) $agent_type_title_color = '';
		// Form fields.
		echo '<tr class="form-field term-agent_type_title_color-wrap">';
		echo '<th scope="row">';
		echo '	<label for="agent_type_title_color">' . esc_html__( 'Label Color', 'propertya-framework' ) . '</label>';
		echo '</th>';
		echo '<td>';
		echo '	<input type="text" id="agent_type_title_color" name="agent_type_title_color" class="agent_type_color_picker" value="' . esc_attr( $agent_type_title_color ) . '"><br>';
		echo '	<p class="description">' . esc_html__( 'The hex color of the label field.', 'propertya-framework' ) . '</p>';
		echo '</td>';
		echo '</tr>';
	}
	public function propertya_framework_types_save_data( $term_id ) {
		// Sanitize user input.
		$label_new_title_color = isset( $_POST[ 'agent_type_title_color' ] ) ? sanitize_hex_color( $_POST[ 'agent_type_title_color' ] ) : '';
		// Update the meta field in the database.
		update_term_meta( $term_id, 'agent_type_title_color', $label_new_title_color );
	}
	public function propertya_framework_types_load_scripts_styles() {
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style( 'wp-color-picker' );
	}
	public function propertya_framework_types_add_admin_js() {
		?>
		<script>
			jQuery(document).ready(function($){
				$('.agent_type_color_picker').wpColorPicker();
			});
		</script>
		<?php
	}
}
new agents_meta_types;
//Custom column for Currency image Meta
function propertya_framework_agent_type_meta_column( $columns ){
	$columns['lab_bg'] = esc_html__( 'Background', 'propertya-framework' );
	unset($columns['description']);
	return $columns;
}
add_filter( "manage_edit-agent_types_columns", 'propertya_framework_agent_type_meta_column', 10);
function propertya_framework_agent_type_meta_column_content( $value, $column_name, $tax_id )
{
	$color = '';
	if(get_term_meta( $tax_id, 'agent_type_title_color', true ) !="")
	{
		$color = get_term_meta( $tax_id, 'agent_type_title_color', true );
	}
	echo '<div class="circle-admin" style="background-color:'.$color.'"></div>';
}
add_action( "manage_agent_types_custom_column", 'propertya_framework_agent_type_meta_column_content', 10, 3);
add_filter('manage_edit-agent_types_columns', 'propertya_framework_agent_type_order' , 10, 3);
function propertya_framework_agent_type_order($columns)
{
	 $new = array();
	 foreach($columns as $key => $title)
	 {
    	  if($key=='slug')
		  {
			  $new['lab_bg'] = esc_html__( 'Background', 'propertya-framework' );
		  }
		  $new[$key] = $title;
     }
	 return $new;
}