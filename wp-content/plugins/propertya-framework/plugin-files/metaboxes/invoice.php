<?php
// Custom fields to this post type
add_filter( 'manage_listing-invoices_posts_columns', 'propertya_framework_edit_invoice_table' );
function propertya_framework_edit_invoice_table($columns) {
	
	unset($columns['date']);
	unset( $columns['title']  );
	$columns['inv_trans'] = esc_html__('Transaction ID', 'propertya-framework' );
	$columns['inv_price'] = esc_html__('Price', 'propertya-framework' );
    $columns['inv_bill'] =esc_html__('Billing Type', 'propertya-framework' );
	$columns['inv_method'] = esc_html__( 'Method', 'propertya-framework' );
	$columns['inv_status'] = esc_html__( 'Status', 'propertya-framework' );
	$columns['inv_listingid'] = esc_html__( 'Property ID', 'propertya-framework' );
	$columns['inv_purchase_date'] = esc_html__( 'Purchase Date', 'propertya-framework' );
	$new = array();
	foreach($columns as $key => $title)
	{
		  $new[$key] = $title;
    }
	return $new;
}
// Add the data to the custom columns for the post type:
add_action( 'manage_listing-invoices_posts_custom_column' , 'propertya_framework_render_inv_table', 10, 2 );
function propertya_framework_render_inv_table( $column, $post_id ) {
        switch ( $column ) {
		case 'inv_trans' :
			echo '<strong> '.get_post_meta( $post_id, 'prop_inv_transaction_id', true ).' </strong>';
		 break;	
         case 'inv_price' :
			echo  get_post_meta( $post_id, 'prop_inv_paidcurrency', true );
		 break;
		 case 'inv_bill' :
			echo  get_post_meta( $post_id, 'prop_inv_pkg_type', true );
		 break;
		 case 'inv_method' :
		 if(get_post_meta( $post_id, 'prop_inv_pay_type', true ) !="")
		 {
			$type_id = '';
			$type_id =  get_post_meta( $post_id, 'prop_inv_pay_type', true );
			echo '<img src='.propertya_framework_payment_imgz($type_id).' alt="">';
		 }
		 break;
		 case 'inv_method' :
			echo  get_post_meta( $post_id, 'prop_inv_pkg_type', true );
		 break;
		 case 'inv_status' :
		 	if(get_post_meta( $post_id, 'prop_inv_status', true )!="")
			{
				if(get_post_meta( $post_id, 'prop_inv_status', true ) == '1')
				{
					echo '<span>'.esc_html__( 'Paid', 'propertya-framework' ).'</span>';
					echo '<div class="circle-admin-border" style="border:2px solid #73d500"></div>';
				}
			}
		 break;
		 case 'inv_listingid' :
			echo  get_post_meta( $post_id, 'prop_inv_listing_id', true );
			echo  '<div class="row-action">
    <span class="view-listing">
        <a href="'.esc_url(get_the_permalink(get_post_meta( $post_id, 'prop_inv_listing_id', true ))).'">'.esc_html__( 'View Listing', 'propertya-framework' ).'</a>
    </span>
</div>';
		 break;
		 case 'inv_purchase_date' :
		 if(get_post_meta( $post_id, 'prop_inv_date', true ) !=""){
			echo  date(get_option('date_format'), strtotime(get_post_meta( $post_id, 'prop_inv_date', true )));
		 }
		 break;
    }
}

add_filter( 'manage_edit-listing-invoices_sortable_columns', 'smashing_realestate_sortable_columns');
function smashing_realestate_sortable_columns( $columns ) {
  $columns['inv_price'] = 'price';
  $columns['inv_listingid'] = 'listing_id';
  $columns['inv_status'] = 'status';
  $columns['inv_purchase_date'] = 'date';
  return $columns;
}

function smashing_posts_orderby( $query ) {
  if( ! is_admin() || ! $query->is_main_query() ) {
    return;
  }
  
  if ( 'price' == $query->get( 'orderby') ) {
		 $query->set( 'orderby', 'meta_value' );
   		 $query->set( 'meta_key', 'prop_inv_paidcurrency' );
  }
  if( 'listing_id' == $query->get( 'orderby')) {
		$query->set('meta_key','prop_inv_listing_id');
		$query->set('orderby','meta_value');
  }
  if( 'status' == $query->get( 'orderby')) {
		$query->set('meta_key','prop_inv_status');
		$query->set('orderby','meta_value');
  }
  if( 'date' == $query->get( 'orderby')) {
		$query->set('meta_key','prop_inv_date');
		$query->set('orderby','date');
  }

}
add_action( 'pre_get_posts', 'smashing_posts_orderby' );
