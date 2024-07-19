<?php
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) || class_exists( 'WooCommerce' ))
{
//user profile backend fields
    add_action('show_user_profile', 'propertya_framework_extra_profile_fields');
    add_action( 'edit_user_profile', 'propertya_framework_extra_profile_fields' );
    function propertya_framework_extra_profile_fields($user) { ?>
<h3><?php echo esc_html__( 'Package Information', 'propertya-framework' ); ?></h3>
<table class="form-table">
  <tr>
    <th><label><?php echo esc_html__('Package Name', 'propertya-framework'); ?></label></th>
    <td>
      <?php
		 $package_id = '';
		 if( get_user_meta($user->ID, 'prop_user_package_id', true ) != "" )
		 {
			  $package_id = get_user_meta($user->ID, 'prop_user_package_id', true );
		 }
		$args	=	array(
		'post_type' => 'product',
		'tax_query' => array(
		 'relation' => 'OR',
				array(	
				   'taxonomy' => 'product_type',
				   'field' => 'slug',
				   'terms' => 'propertya_packages'
				),
			),
        'fields' => 'ids',    
		'post_status' => 'publish',
		'posts_per_page' => 20,
		'order'=> 'DESC',
		'orderby' => 'date'
		);
		$packages = new WP_Query($args);
		if ($packages->have_posts())
		{
		?>
        	<select class="admin-select" name="select_page">
            	<option value=""><?php echo esc_html__('Select an option', 'propertya-framework'); ?></option>
            	<?php
				while ( $packages->have_posts() )
				{
					$packages->the_post();
				?>	
                    <option value="<?php echo get_the_ID(); ?>" <?php if($package_id == get_the_ID()){ echo 'selected';}  ?>><?php echo get_the_title(); ?></option>
                <?php
				}
				?>
            </select>
            <input type="hidden" name="package_id" value="<?php echo esc_attr($package_id); ?>">
        <?php
		wp_reset_postdata();
		}
?>
      <br /><br />
      <p class="description"><?php echo esc_html__('User selected package', 'propertya-framework'); ?></p>
    </td>
  </tr>
</table>
<?php }
add_action( 'personal_options_update', 'propertya_framework_my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'propertya_framework_my_save_extra_profile_fields' );
function propertya_framework_my_save_extra_profile_fields($user_id) {
  if ( !current_user_can('edit_user',$user_id))
      return false;
	  if(isset($_POST['select_page']) && $_POST['select_page'] !="")
	  {
          propertya_framework_store_user_package($user_id,$_POST['select_page'] );
	  }
	  else
	  {
		 update_user_meta($user_id, 'prop_user_package_id',''); 
	  }
}
}