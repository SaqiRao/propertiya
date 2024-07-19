<?php
class property_meta_status {
	public function __construct() {
		if ( is_admin() ) {
			add_action( 'property_status_add_form_fields',  array( $this, 'property_status_create_screen_fields'), 10, 1 );
			add_action( 'property_status_edit_form_fields', array( $this, 'property_status_edit_screen_fields' ),  10, 2 );
			add_action( 'created_property_status', array( $this, 'property_status_save_data' ), 10, 1 );
			add_action( 'edited_property_status',  array( $this, 'property_status_save_data' ), 10, 1 );
			add_action( 'admin_enqueue_scripts', array( $this, 'property_status_load_scripts_styles' ) );
			add_action( 'admin_footer',          array( $this, 'property_status_add_admin_js' )        );
		}
	}
	public function property_status_create_screen_fields( $taxonomy ) {
		// Set default values.
		$status_title_color = '';
		// Form fields.
		echo '<div class="form-field term-status_title_color-wrap">';
		echo '	<label for="status_title_color">' . esc_html__( 'Status Label Color', 'propertya-framework' ) . '</label>';
		echo '	<input type="text" id="status_title_color" name="status_title_color" class="status_color_picker" value="' . esc_attr( $status_title_color ) . '"><br>';
		echo '	<p class="description">' . esc_html__( 'The hex color of the label field.', 'propertya-framework' ) . '</p>';
		echo '</div>';
	}
	public function property_status_edit_screen_fields( $term, $taxonomy ) {
		// Retrieve an existing value from the database.
		$status_title_color = get_term_meta( $term->term_id, 'status_title_color', true );
		// Set default values.
		if( empty( $status_title_color ) ) $status_title_color = '';
		// Form fields.
		echo '<tr class="form-field term-status_title_color-wrap">';
		echo '<th scope="row">';
		echo '	<label for="status_title_color">' . esc_html__( 'Status Label Color', 'propertya-framework' ) . '</label>';
		echo '</th>';
		echo '<td>';
		echo '	<input type="text" id="status_title_color" name="status_title_color" class="status_color_picker" value="' . esc_attr( $status_title_color ) . '"><br>';
		echo '	<p class="description">' . esc_html__( 'The hex color of the label field.', 'propertya-framework' ) . '</p>';
		echo '</td>';
		echo '</tr>';
	}
	public function property_status_save_data( $term_id ) {
		// Sanitize user input.
		$label_new_title_color = isset( $_POST[ 'status_title_color' ] ) ? sanitize_hex_color( $_POST[ 'status_title_color' ] ) : '';
		// Update the meta field in the database.
		update_term_meta( $term_id, 'status_title_color', $label_new_title_color );
	}
	public function property_status_load_scripts_styles() {
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style( 'wp-color-picker' );
	}
	public function property_status_add_admin_js() {
		// Print js only once per page
		if ( did_action( 'property_meta_status_js' ) >= 1 ) {
			return;
		}
		?>
		<script type="text/javascript">
			jQuery(document).ready(function($){
				$('.status_color_picker').wpColorPicker();
			});
		</script>
		<?php
		do_action( 'property_meta_status_js', $this );
	}
}
new property_meta_status;
//Custom column for Currency image Meta
function propertya_framework_status_meta_column( $columns ){
	$columns['lab_bg'] = esc_html__( 'Background', 'propertya-framework' );
	unset($columns['description']);
	return $columns;
}
add_filter( "manage_edit-property_status_columns", 'propertya_framework_status_meta_column', 10);
function propertya_framework_status_meta_column_content( $value, $column_name, $tax_id )
{
	$color = '';
	if(get_term_meta( $tax_id, 'status_title_color', true ) !="")
	{
		$color = get_term_meta( $tax_id, 'status_title_color', true );
	}
	echo '<div class="circle-admin" style="background-color:'.$color.'"></div>';
}
add_action( "manage_property_status_custom_column", 'propertya_framework_status_meta_column_content', 10, 3);
add_filter('manage_edit-property_status_columns', 'propertya_framework_status_order' , 10, 3);
function propertya_framework_status_order($columns)
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