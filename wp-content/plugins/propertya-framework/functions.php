<?php
class RealPage_Meta_Box {

	public function __construct() {

		if ( is_admin() ) {
			add_action( 'load-post.php',     array( $this, 'init_page_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_page_metabox' ) );
		}

	}

	public function init_page_metabox() {

		add_action( 'add_meta_boxes', array( $this, 'add_page_metabox'  )        );
		add_action( 'save_post',      array( $this, 'save_page_metabox' ), 10, 2 );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts_styles')  );
		add_action( 'admin_footer',          array( $this, 'color_field_js' )      );

	}

	public function add_page_metabox() {
		add_meta_box(
			'page_info',
			__( 'Page Settings', 'propertya-framework' ),
			array( $this, 'render_page_metabox' ),
			'page',
			'advanced',
			'default'
		);
	}

	public function render_page_metabox( $post ) {

		// Add nonce for security and authentication.
		wp_nonce_field( 'custom_page_nonce_action', 'custom_page_nonce' );
		// Retrieve an existing value from the database.
		echo $show_bread = get_post_meta( $post->ID, 'show_page_bread', true );
		echo $show_trans = get_post_meta( $post->ID, 'show_trans_header', true );
		echo $primary_color = get_post_meta( $post->ID, 'primary_color', true );

		// Set default values.
		if( empty( $show_bread ) ) $show_bread = '';
		if( empty( $show_trans ) ) $show_trans = '';
		if( empty( $primary_color ) ) $primary_color = '#fff';

		// Form fields.
		echo '<table class="form-table">';
		echo '	<tr>';
		echo '		<th><label for="breadcrumb">' . __( 'Breadcrumb', 'propertya-framework' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="checkbox" id="breadcrumb" name="show_bread" value="' . $show_bread . '" ' . checked( $show_bread, 'checked', false ) . '> ';
		echo '			<span class="description">' . __( 'Hide breadcrumb?', 'propertya-framework' ) . '</span>';
		echo '		</td>';
		echo '	</tr>';
		
		echo '	<tr>';
		echo '		<th><label for="trans_header">' . __( 'Transparent Header', 'propertya-framework' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="checkbox" id="trans_header" name="show_trans" value="' . $show_trans . '" ' . checked( $show_trans, 'show_trans', false ) . '> ';
		echo '			<span class="description">' . __( 'Mark Header As Transparent?', 'propertya-framework' ) . '</span>';
		echo '			<p class="description">' . __( 'Transparent Header will only work on home pages only', 'propertya-framework' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';
		
		echo '	<tr>';
		echo '		<th><label for="primary_color" >' . __( 'Transparent Menu Color', 'propertya-framework' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="text" id="primary_color" name="primary_color"  value="' . esc_attr__( $primary_color ) . '">';
		echo '			<p class="description">' . __( 'Select primary color', 'propertya-framework' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';
		
		echo '</table>';

	}

	public function save_page_metabox( $post_id, $post ) {
		// Sanitize user input.
		$show_bread = isset( $_POST[ 'show_bread' ] ) ? 'checked' : '0';
		$show_trans = isset( $_POST[ 'show_trans' ] ) ? 'checked' : '';
		$primary_color = isset( $_POST[ 'primary_color' ] ) ? sanitize_text_field( $_POST[ 'primary_color' ] ) : '';
		// Update the meta field in the database.
		update_post_meta( $post_id, 'show_page_bread', $show_bread );
		update_post_meta( $post_id, 'show_trans_header', $show_trans );
		update_post_meta( $post_id, 'primary_color', $primary_color );

	}
	
	public function load_scripts_styles() {

		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style( 'wp-color-picker' );

	}
	
	
	public function color_field_js() {

		// Print js only once per page
		if ( did_action( 'RealPage_Meta_Box_color_picker_js' ) >= 1 ) {
			return;
		}

		?>
		<script type="text/javascript">
			jQuery(document).ready(function($){
				$('#primary_color').wpColorPicker();
			});
		</script>
		<?php
		do_action( 'RealPage_Meta_Box_color_picker_js', $this );

	}
}
new RealPage_Meta_Box();

//woocommerce packages
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) || class_exists( 'WooCommerce' ))
{
    
   
/* 
 * Add New Product Type to Select Dropdown
 */
add_filter( 'product_type_selector', 'propertya_framework_add_custom_product_type' );
function propertya_framework_add_custom_product_type( $types ){
    $types[ 'propertya_packages' ] = 'Propertya Packages';
    return $types;
}
 
/* 
 * Add New Product Type Class
 */
add_action( 'init', 'propertya_framework_create_custom_product_type' );
function propertya_framework_create_custom_product_type(){
	if(class_exists('WC_Product')){
    class WC_Product_Custom extends WC_Product {
        public function get_type() {
            return 'propertya_packages';
        }
    }

}
}
/* 
 * Load New Product Type Class
 */
add_filter( 'woocommerce_product_class', 'propertya_framework_woocommerce_product_class', 10, 2 );
function propertya_framework_woocommerce_product_class( $classname, $product_type ) {
    if ( $product_type == 'propertya_packages' ) { 
        $classname = 'WC_Product_Custom';
    }
    return $classname;
}
    
    
add_action('admin_footer', 'propertya_framework_custom_product_admin_custom_js');
function propertya_framework_custom_product_admin_custom_js()
{
    if ('product' != get_post_type()) :
        return;
    endif;
    ?>
    <script type='text/javascript'>
        jQuery(document).ready(function () {
            //for Price tab
            jQuery('#propertya_product').hide();
            jQuery('.options_group.pricing').addClass('show_if_propertya_packages').show();
            //for Inventory tab
            jQuery('.inventory_options').addClass('show_if_propertya_packages').show();
            jQuery('#inventory_product_data ._manage_stock_field').addClass('show_if_propertya_packages').show();
            jQuery('#inventory_product_data ._sold_individually_field').parent().addClass('show_if_propertya_packages').show();
            jQuery('#inventory_product_data ._sold_individually_field').addClass('show_if_propertya_packages').show();
            jQuery('#product-type').on('change', function ()
            {
                if (jQuery(this).val() == 'propertya_packages')
                {
                   jQuery('#propertya_product').show();     
                }
                else
                {
                    jQuery('#propertya_product').hide();
                }
            });
            jQuery('#product-type').trigger('change');
        });
    </script>
    <?php
}
}