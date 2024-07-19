<?php
class property_meta_currency {
	public function __construct() {
		if ( is_admin() ) {
			add_action( 'property_currency_add_form_fields',  array( $this, 'create_screen_fields'), 10, 1 );
			add_action( 'property_currency_edit_form_fields', array( $this, 'edit_screen_fields' ),  10, 2 );
			add_action( 'created_property_currency', array( $this, 'save_data' ), 10, 1 );
			add_action( 'edited_property_currency',  array( $this, 'save_data' ), 10, 1 );
		}
	}
	public function create_screen_fields( $taxonomy ) {
		// Set default values.
		$p_currency_code = '';
		$p_currency_sym = '';
		// Form fields.
		echo '<div class="form-field term-rcrm_meta_price-wrap">';
		echo '	<label for="p_currency_code">' . esc_html__( 'Currency Code', 'propertya-framework' ) . '</label>';
		echo '	<input type="text" id="p_currency_code" name="p_currency_code" placeholder="' . esc_attr__( 'AUD', 'propertya-framework' ) . '" value="' . esc_attr( $p_currency_code ) . '">';
		echo '</div>';

		echo '<div class="form-field term-p_currency_sym-wrap">';
		echo '	<label for="p_currency_sym">' . esc_html__( 'Currency Symbol', 'propertya-framework' ) . '</label>';
		echo '	<input type="text" id="p_currency_sym" name="p_currency_sym" placeholder="' . esc_attr__( '$', 'propertya-framework' ) . '" value="' . esc_attr( $p_currency_sym ) . '">';
		echo '</div>';
	}
	public function edit_screen_fields( $term, $taxonomy ) {
		// Retrieve an existing value from the database.
		$p_currency_code = get_term_meta( $term->term_id, 'p_currency_code', true );
		$p_currency_sym = get_term_meta( $term->term_id, 'p_currency_sym', true );
		// Set default values.
		if( empty( $p_currency_code ) ) $p_currency_code = '';
		if( empty( $p_currency_sym ) ) $p_currency_sym = '';
		// Form fields.
		echo '<tr class="form-field term-rcrm_meta_price-wrap">';
		echo '<th scope="row">';
		echo '	<label for="p_currency_code">' . esc_html__( 'Currency Code', 'propertya-framework' ) . '</label>';
		echo '</th>';
		echo '<td>';
		echo '	<input type="text" id="p_currency_code" name="p_currency_code" placeholder="' . esc_attr__( 'AUD', 'propertya-framework' ) . '" value="' . esc_attr( $p_currency_code ) . '">';
		echo '</td>';
		echo '</tr>';

		echo '<tr class="form-field term-p_currency_sym-wrap">';
		echo '<th scope="row">';
		echo '	<label for="p_currency_sym">' . esc_html__( 'Currency Symbol', 'propertya-framework' ) . '</label>';
		echo '</th>';
		echo '<td>';
		echo '	<input type="text" id="p_currency_sym" name="p_currency_sym" placeholder="' . esc_attr__( '$', 'propertya-framework' ) . '" value="' . esc_attr( $p_currency_sym ) . '">';
		echo '</td>';
		echo '</tr>';
	}
	public function save_data( $term_id ) {
		// Sanitize user input.
		$new_meta_price = isset( $_POST[ 'p_currency_code' ] ) ? sanitize_text_field( $_POST[ 'p_currency_code' ] ) : '';
		$new_meta_icon = isset( $_POST[ 'p_currency_sym' ] ) ? sanitize_text_field( $_POST[ 'p_currency_sym' ] ) : '';
		// Update the meta field in the database.
		update_term_meta( $term_id, 'p_currency_code', $new_meta_price );
		update_term_meta( $term_id, 'p_currency_sym', $new_meta_icon );
	}
}
new property_meta_currency;
//Custom column for Currency image Meta
function propertya_framework_currency_meta_column( $columns ){
	$columns['curr_code'] = 'Code';
	$columns['curr_sym'] = 'Symbol';
	unset($columns['description']);
	return $columns;
}
add_filter( "manage_edit-property_currency_columns", 'propertya_framework_currency_meta_column', 10);
function propertya_framework_currency_meta_column_content( $value, $column_name, $tax_id )
{
	 if ($column_name === 'curr_code')
	 {
		echo get_term_meta( $tax_id, 'p_currency_code', true );
	 }
	 if ($column_name === 'curr_sym')
	 {
		echo get_term_meta( $tax_id, 'p_currency_sym', true );
	 }
}
add_action( "manage_property_currency_custom_column", 'propertya_framework_currency_meta_column_content', 10, 3);
add_filter('manage_edit-property_currency_columns', 'propertya_framework_currency_order' , 10, 3);
function propertya_framework_currency_order($columns)
{
	 $new = array();
	 foreach($columns as $key => $title)
	 {
    	  if($key=='slug')
		  {
			  $new['curr_code'] = 'Code';
			  $new['curr_sym'] = 'Symbol';
		  }
		  $new[$key] = $title;
     }
	 return $new;
}