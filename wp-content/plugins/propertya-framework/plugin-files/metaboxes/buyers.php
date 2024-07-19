<?php
class propertya_framework_buyers {
	public function __construct()
	{
		if ( is_admin() ) {
			add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		}
	}
	public function init_metabox() {
		add_action( 'add_meta_boxes',        array( $this, 'propertya_framework_property_add_metabox_buyer'));
		add_action( 'save_post',             array( $this, 'propertya_framework_property_save_metabox_buyer' ), 10, 2 );
	}
	public function propertya_framework_property_add_metabox_buyer() {
		add_meta_box(
			'buyer_meta_fields',
			esc_html__( 'Buyer Information', 'propertya-framework' ),
			array($this, 'propertya_framework_render_metabox_buyer' ),
			'property-buyers',
			'advanced',
			'default'
		);
	}
	public function propertya_framework_render_metabox_buyer( $post )
	{
		wp_nonce_field( 'buyer_nonce_action', 'buyer_nonce' );
		// Retrieve an existing value from the database.
		$buyer_email = get_post_meta( $post->ID, 'buyer_email', true );
		$buyer_mobile = get_post_meta( $post->ID, 'buyer_mobile', true );
		$buyer_whats = get_post_meta( $post->ID, 'buyer_whats', true );
		$buyer_fb = get_post_meta( $post->ID, 'buyer_fb', true );
		$buyer_tw = get_post_meta( $post->ID, 'buyer_tw', true );
		$buyer_in = get_post_meta( $post->ID, 'buyer_in', true );
		$buyer_insta = get_post_meta( $post->ID, 'buyer_insta', true );
		$buyer_pin = get_post_meta( $post->ID, 'buyer_pin', true );
		$buyer_street_addr = get_post_meta( $post->ID, 'buyer_street_addr', true );
		$buyer_latt = get_post_meta( $post->ID, 'buyer_latt', true );
		$buyer_long = get_post_meta( $post->ID, 'buyer_long', true );
		// Set default values.
		if( empty($buyer_email) ) $buyer_email = '';
		if( empty($buyer_mobile) ) $buyer_mobile = '';
		if( empty($buyer_whats) ) $buyer_whats = '';
		if( empty($buyer_fb) ) $buyer_fb = '';
		if( empty($buyer_tw) ) $buyer_tw = '';
		if( empty($buyer_in) ) $buyer_in = '';
		if( empty($buyer_insta) ) $buyer_insta = '';
		if( empty($buyer_pin) ) $buyer_pin = '';
		if( empty($buyer_street_addr) ) $buyer_street_addr = '';
		if( empty($buyer_latt) ) $buyer_latt = '';
		if( empty($buyer_long) ) $buyer_long = '';
		
?>
<div class="row">
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__('Email Address', 'propertya-framework' ) ?></label>
        <input type="text" class="admin-inputs" name="buyer-email" value="<?php echo esc_attr($buyer_email); ?>">
            <p class="description"><?php echo esc_html__( 'Messages from contact form on property details page, will be sent on this email address.', 'propertya-framework' ) ?></p>
        </div>
    </div>
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'Mobile Number', 'propertya-framework' ) ?></label>
       <input type="text" class="admin-inputs" name="buyer-mobile" value="<?php echo esc_attr($buyer_mobile); ?>">
           
        </div>
    </div>
    <div class="clearfix"></div>
    
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'WhatsApp Number', 'propertya-framework' ) ?></label>
       <input type="text" class="admin-inputs" name="buyer-whats" value="<?php echo esc_attr($buyer_whats); ?>">
        </div>
    </div>    
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'Facebook URL', 'propertya-framework' ) ?></label>
        <input type="text" class="admin-inputs" name="buyer-fb" value="<?php echo esc_url($buyer_fb); ?>">
        </div>
    </div>
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'Twitter URL', 'propertya-framework' ) ?></label>
        <input type="text" class="admin-inputs" name="buyer-tw" value="<?php echo esc_url($buyer_tw); ?>">
        </div>
    </div>
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'LinkedIn URL ', 'propertya-framework' ) ?></label>
        <input type="text" class="admin-inputs" name="buyer-in" value="<?php echo esc_url($buyer_in); ?>">
        </div>
    </div>
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'Instagram URL ', 'propertya-framework' ) ?></label>
        <input type="text" class="admin-inputs" name="buyer-insta" value="<?php echo esc_url($buyer_insta); ?>">
        </div>
    </div>
    
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'Pinterest URL', 'propertya-framework' ) ?></label>
        <input type="text" class="admin-inputs" name="buyer-pin" value="<?php echo esc_url($buyer_pin); ?>">
        </div>
    </div>
    <div class="clearfix"></div>
    
    <div class="col-12 clearfix">
         <div class="form-group">
           <label><?php echo esc_html__('Address','propertya-framework');?></label>
           <div class="get-loc">
           <input type="text" class="admin-inputs" id="property_address" name="buyer-address" value="<?php echo esc_attr($buyer_street_addr); ?>">
           <?php 
		   if(!empty(propertya_framework_get_options('property_opt_enable_geo')) && !empty(propertya_framework_get_options('property_opt_api_settings')))
		   {
		   ?>
           <i class="detect-me dashicons dashicons-move"></i>
           <?php
		   }
		   ?>
           </div>
           <p><?php echo esc_html__('Map will shown on agent detail page.','propertya-framework');?></p>
    		</div>
        </div>
        <?php
	    if(propertya_framework_get_options('property_opt_enable_map') == 1) { ?>
            <div class="col-12 clearfix">
                 <div class="form-group">
                    <div id="property_map"></div>
                </div>
            </div>
       
        <div class="col-6 clearfix">
                <div class="form-group">
                    <label><?php echo esc_html__('Coordinates','propertya-framework');?>  </label>
                    <input type="text" class="admin-inputs" name="buyer-latt" id="property_latt" value="<?php echo esc_attr($buyer_latt); ?>">
                    <p><?php echo esc_html__('Your location Latitude','propertya-framework');?></p>
                </div>
            </div>
            <div class="col-6 clearfix">
                <div class="form-group">
                    <label for="longitude">&nbsp;</label>
                    <input type="text" class="admin-inputs" name="buyer-long" id="property_long" value="<?php echo esc_attr($buyer_long); ?>">
                    <p><?php echo esc_html__('Your location Longitude','propertya-framework');?></p>
                </div>
            </div>
             <?php
		}
		?>
    <div class="clearfix"></div>
 </div>       
<?php
	}
	public function propertya_framework_property_save_metabox_buyer( $post_id, $post ) {
		// Add nonce for security and authentication.
		$nonce_name = ( isset($_POST['buyer_nonce']) ) ? $_POST['buyer_nonce'] : ' ';
		$nonce_action = 'buyer_nonce_action';
		$buyer_id = $post_id;
		// Check if a nonce is set.
		if ( ! isset( $nonce_name ) )
			return;

		// Check if a nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) )
			return;

		// Check if the user has permissions to save data.
		if ( ! current_user_can( 'edit_post', $buyer_id ) )
			return;

		// Check if it's not an autosave.
		if ( wp_is_post_autosave( $buyer_id ) )
			return;

		// Check if it's not a revision.
		if ( wp_is_post_revision( $buyer_id ) )
			return;
		//sanatize fields
		$buyer_email = isset( $_POST[ 'buyer-email' ] ) ? sanitize_email( $_POST[ 'buyer-email' ] ) : '';
		$buyer_mobile = isset( $_POST[ 'buyer-mobile' ] ) ? sanitize_text_field( $_POST[ 'buyer-mobile' ] ) : '';
		$buyer_whats = isset( $_POST[ 'buyer-whats' ] ) ? sanitize_text_field( $_POST[ 'buyer-whats' ] ) : '';
		$buyer_fb = isset( $_POST[ 'buyer-fb' ] ) ? sanitize_text_field( $_POST[ 'buyer-fb' ] ) : '';
		$buyer_tw = isset( $_POST[ 'buyer-tw' ] ) ? sanitize_text_field( $_POST[ 'buyer-tw' ] ) : '';
		$buyer_in = isset( $_POST[ 'buyer-in' ] ) ? sanitize_text_field( $_POST[ 'buyer-in' ] ) : '';
		$buyer_insta = isset( $_POST[ 'buyer-insta' ] ) ? sanitize_text_field( $_POST[ 'buyer-insta' ] ) : '';
		$buyer_pin = isset( $_POST[ 'buyer-pin' ] ) ? sanitize_text_field( $_POST[ 'buyer-pin' ] ) : '';
		$buyer_street_addr = isset( $_POST[ 'buyer-address' ] ) ? sanitize_text_field( $_POST[ 'buyer-address' ] ) : '';
		$buyer_latt = isset( $_POST[ 'buyer-latt' ] ) ? sanitize_text_field( $_POST[ 'buyer-latt' ] ) : '';
		$buyer_long = isset( $_POST[ 'buyer-long' ] ) ? sanitize_text_field( $_POST[ 'buyer-long' ] ) : '';
		// Update the meta field in the database.
		update_post_meta($buyer_id, 'buyer_status', '1' );
		if (get_post_meta($buyer_id, 'buyer_is_featured', true ) == "1")
		{
		}
		else
		{
			update_post_meta($buyer_id, 'buyer_is_featured', '0');
		}
		update_post_meta($buyer_id, 'buyer_email', $buyer_email);
		update_post_meta($buyer_id, 'buyer_mobile', $buyer_mobile );
		update_post_meta($buyer_id, 'buyer_whats', $buyer_whats );
		update_post_meta($buyer_id, 'buyer_fb', $buyer_fb);
		update_post_meta($buyer_id, 'buyer_tw', $buyer_tw);
		update_post_meta($buyer_id, 'buyer_in', $buyer_in );
		update_post_meta($buyer_id, 'buyer_insta', $buyer_insta);
		update_post_meta($buyer_id, 'buyer_pin', $buyer_pin);
		update_post_meta($buyer_id, 'buyer_street_addr', $buyer_street_addr);
		update_post_meta($buyer_id, 'buyer_latt', $buyer_latt);
		update_post_meta($buyer_id, 'buyer_long', $buyer_long);
	}
}
new propertya_framework_buyers;
// Custom fields to this post type
add_filter( 'manage_property-buyers_posts_columns', 'propertya_framework_edit_buyer_table' );
function propertya_framework_edit_buyer_table($columns) {
	
	unset($columns['date']);
	$columns['buyer_ref'] = esc_html__( 'Buyer ID', 'propertya-framework' );
	$columns['agent_thumb'] = esc_html__('Thumbnail', 'propertya-framework' );
    $columns['agent_properties'] = esc_html__('Listings', 'propertya-framework' );
	$columns['agent_mob'] = esc_html__( 'Mobile No', 'propertya-framework' );
	$new = array();
	foreach($columns as $key => $title)
	{
		  if($key=='title')
		  {
			$new['agent_thumb'] = esc_html__('Thumbnail', 'propertya-framework' );
		  }
    	  if($key=='taxonomy-property_location')
		  {
			  
			  $new['buyer_ref'] = esc_html__('Buyer ID', 'propertya-framework' );
			  $new[ 'title' ] = esc_html__('Agent', 'propertya-framework' );
			  $new[ 'agent_properties' ] = esc_html__('Listings', 'propertya-framework' );
			  $new[ 'agent_agents' ] = esc_html__('Agents', 'propertya-framework' );
		  }
		  if($key=='date')
		  {
			 $new[ 'agent_mob' ] =  esc_html__('Mobile No', 'propertya-framework' );
		  }
		  $new[$key] = $title;
    }
	return $new;
}
// Add the data to the custom columns for the post type:
add_action( 'manage_property-buyers_posts_custom_column' , 'propertya_framework_render_buyer_table', 10, 2 );
function propertya_framework_render_buyer_table( $column, $post_id ) {
        switch ( $column ) {
         case 'agent_mob' :
			echo  get_post_meta( $post_id, 'agent_mobile', true );
		 break;
		 case 'agent_thumb' :
		 if ( has_post_thumbnail() )
		 {
			echo the_post_thumbnail(array(64,64)); //size of the thumbnail 
		 }
		 else
		 {
			 $my_img = SB_PLUGIN_URL . "libs/images/placeholder.png";
			 echo '<img src="'.esc_url($my_img).'" width="64">';
		 }
		 break;
		 case 'agent_properties':
		 	 $user_id = get_post_field( 'post_author', $post_id );
			 echo count_user_posts($user_id , "property"  ) ;
		 break;
		 case 'agent_ref':
		 echo esc_attr($post_id);
		 break;
    }
}
//Sidebar meta
class propertya_framework_buyers_sidebar 
{
	public function __construct() {
		if ( is_admin() ) {
			add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		}
	}
	public function init_metabox() {
		add_action( 'add_meta_boxes',        array( $this, 'propertya_framework_property_add_metabox_buyer_sidebar'));
		add_action( 'save_post',             array( $this, 'propertya_framework_property_save_metabox_buyer_sidebox' ), 10, 2 );
		add_action( 'admin_enqueue_scripts', array( $this, 'propertya_framework_scripts_styles'));
		add_action( 'admin_footer',          array( $this, 'propertya_framework_admin_js'));
	}
	public function propertya_framework_property_add_metabox_buyer_sidebar() {
		add_meta_box(
			'buyer_meta_fields_sidebar',
			 esc_html__( 'Buyer Information', 'propertya-framework' ),
			array( $this, 'propertya_framework_render_metabox_buyer_sidebox' ),
			'property-buyers',
			'side',
			'high'
		);
	}
	public function propertya_framework_render_metabox_buyer_sidebox($post)
	{
		wp_nonce_field( 'agent_nonce_action_sidebox', 'agent_nonce_sidebox' );
		// Retrieve an existing value from the database.
		$agent_is_featured = get_post_meta( $post->ID, 'buyer_is_featured', true );
		$agent_badge_txt = get_post_meta( $post->ID, 'buyer_badge_txt', true );
		$agent_badge_clr = get_post_meta( $post->ID, 'buyer_badge_clr', true );
		// Set default values.
		if( empty($agent_is_featured) ) $agent_is_featured = '0';
		if( empty($agent_badge_txt) ) $agent_badge_txt = '';
		if( empty($agent_badge_clr) ) $agent_badge_clr = '';
	?>
        <table class="form-table">
            <tr>
                <td>
                <p><?php echo esc_html__('Do you want to make this agent featured!', 'propertya-framework' ); ?></p>
                <ul class="radio-lists">
                     <li>
                         <label><input value="1" type="radio" <?php checked('1',$agent_is_featured,true); ?> name="is-feat"><?php echo esc_html__( 'Yes', 'propertya-framework' ); ?></label>
                     </li>
                     <li>
                         <label><input value="0" type="radio" <?php checked('0',$agent_is_featured,true); ?> name="is-feat"><?php echo esc_html__( 'No', 'propertya-framework' ); ?></label>
                     </li>
                 </ul>
                </td>
            </tr>
            <tr>
                <td>
                    <p><?php echo esc_html__('Do you want to add additional badge for agent?', 'propertya-framework' ); ?></p><br>
                    <div class="form-group">
                        <label><?php echo esc_html__('Badge Text','propertya-framework');?>  </label>
                        <input type="text" class="admin-inputs" name="badge-txt" value="<?php echo esc_attr($agent_badge_txt); ?>">
                        <p><?php echo esc_html__('Eg : Verified','propertya-framework');?></p>
                    </div>
                    <div class="form-group">
                        <label><?php echo esc_html__('Badge Color','propertya-framework');?>  </label>
                        <input type="text" class="region_color_picker" name="badge-clr" value="<?php echo esc_attr($agent_badge_clr); ?>">
                        <p><?php echo esc_html__('The hex color of the badge field.','propertya-framework');?></p>
                    </div>
                </td>
             </tr>   
        </table>
    <?php
	}
	public function propertya_framework_property_save_metabox_buyer_sidebox( $post_id, $post ) {
		// Add nonce for security and authentication.
		$nonce_name = ( isset($_POST['agent_nonce_sidebox']) ) ? $_POST['agent_nonce_sidebox'] : ' ';
		$nonce_action = 'agent_nonce_action_sidebox';
		// Check if a nonce is set.
		if ( ! isset( $nonce_name ) )
			return;

		// Check if a nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) )
			return;

		// Check if the user has permissions to save data.
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return;

		// Check if it's not an autosave.
		if ( wp_is_post_autosave( $post_id ) )
			return;

		// Check if it's not a revision.
		if ( wp_is_post_revision( $post_id ) )
			return;
		//sanatize fields
		
		$agent_is_featured = isset( $_POST[ 'is-feat' ] ) ? sanitize_text_field( $_POST[ 'is-feat' ] ) : '';
		$agent_badge_txt = isset( $_POST[ 'badge-txt' ] ) ? sanitize_text_field( $_POST[ 'badge-txt' ] ) : '';
		$agent_badge_clr = isset( $_POST[ 'badge-clr' ] ) ? sanitize_text_field( $_POST[ 'badge-clr' ] ) : '';
		update_post_meta($post_id, 'buyer_is_featured',$agent_is_featured);
		update_post_meta($post_id, 'buyer_badge_txt',$agent_badge_txt);
		update_post_meta($post_id, 'buyer_badge_clr',$agent_badge_clr);
	}
	
	public function propertya_framework_scripts_styles() {
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style( 'wp-color-picker' );
	}
	
	public function propertya_framework_admin_js() {
		// Print js only once per page
		if ( did_action( 'propertya_framework_admin_js' ) >= 1 ) {
			return;
		}
		?>
		<script type="text/javascript">
			jQuery(document).ready(function($){
				$('.region_color_picker').wpColorPicker();
			});
		</script>
		<?php
		do_action( 'propertya_framework_admin_js', $this );
	}
}
new propertya_framework_buyers_sidebar;