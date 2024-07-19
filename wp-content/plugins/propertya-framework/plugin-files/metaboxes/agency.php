<?php
class propertya_framework_agency {
	public function __construct() {
		if ( is_admin() ) {
			add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		}
	}
	public function init_metabox() {
		add_action( 'add_meta_boxes',        array( $this, 'propertya_framework_property_add_metabox_agency'));
		add_action( 'save_post',             array( $this, 'propertya_framework_property_save_metabox_agency' ), 10, 2 );
	}
	public function propertya_framework_property_add_metabox_agency() {
		add_meta_box(
			'agency_meta_fields',
			esc_html__( 'Agency Related Information', 'propertya-framework' ),
			array( $this, 'propertya_framework_render_metabox_agency' ),
			'property-agency',
			'advanced',
			'default'
		);
	}
	public function propertya_framework_render_metabox_agency( $post )
	{
		wp_nonce_field( 'agency_nonce_action', 'agency_nonce' );
		// Retrieve an existing value from the database.
		$agency_email = get_post_meta( $post->ID, 'agency_email', true );
		$agency_mobile = get_post_meta( $post->ID, 'agency_mobile', true );
		$agency_whats = get_post_meta( $post->ID, 'agency_whats', true );
		$agency_office = get_post_meta( $post->ID, 'agency_office', true );
		$agency_fax = get_post_meta( $post->ID, 'agency_fax', true );
		$agency_licence = get_post_meta( $post->ID, 'agency_licence', true );
		$agency_tax = get_post_meta( $post->ID, 'agency_tax', true );
		$agency_url = get_post_meta( $post->ID, 'agency_url', true );
		$agency_location = get_post_meta( $post->ID, 'agency_location', true );
		$agency_hours = get_post_meta( $post->ID, 'agency_hours', true );
		$agency_fb = get_post_meta( $post->ID, 'agency_fb', true );
		$agency_tw = get_post_meta( $post->ID, 'agency_tw', true );
		$agency_in = get_post_meta( $post->ID, 'agency_in', true );
		$agency_insta = get_post_meta( $post->ID, 'agency_insta', true );
		$agency_you = get_post_meta( $post->ID, 'agency_you', true );
		$agency_pin = get_post_meta( $post->ID, 'agency_pin', true );
		$agency_street_addr = get_post_meta( $post->ID, 'agency_street_addr', true );
		$agency_latt = get_post_meta( $post->ID, 'agency_latt', true );
		$agency_long = get_post_meta( $post->ID, 'agency_long', true );

		// Set default values.
		if( empty($agency_email) ) $agency_email = '';
		if( empty($agency_mobile) ) $agency_mobile = '';
		if( empty($agency_whats) ) $agency_whats = '';
		if( empty($agency_office) ) $agency_office = '';
		if( empty($agency_fax) ) $agency_fax = '';
		if( empty($agency_licence) ) $agency_licence = '';
		if( empty($agency_tax) ) $agency_tax = '';
		if( empty($agency_url) ) $agency_url = '';
		if( empty($agency_location) ) $agency_location = '';
		if( empty($agency_hours) ) $agency_hours = '';
		if( empty($agency_fb) ) $agency_fb = '';
		if( empty($agency_tw) ) $agency_tw = '';
		if( empty($agency_in) ) $agency_in = '';
		if( empty($agency_insta) ) $agency_insta = '';
		if( empty($agency_you) ) $agency_you = '';
		if( empty($agency_pin) ) $agency_pin = '';
		if( empty($agency_street_addr) ) $agency_street_addr = '';
		if( empty($agency_latt) ) $agency_latt = '';
		if( empty($agency_long) ) $agency_long = '';
?>


<div class="row">
    <div class="col-12">
     <div class="form-group">
      <label><?php echo esc_html__('Email Address', 'propertya-framework' ) ?></label>
        <input type="text" class="admin-inputs" name="agency-email" value="<?php echo esc_attr($agency_email); ?>">
            <p class="description"><?php echo esc_html__( 'Enter email address messages from contact form on property details page, will be sent on this email address.', 'propertya-framework' ) ?></p>
        </div>
    </div>
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'Mobile Number', 'propertya-framework' ) ?></label>
       <input type="text" class="admin-inputs" name="agency-mobile" value="<?php echo esc_attr($agency_mobile); ?>">
           
        </div>
    </div>
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'WhatsApp Number', 'propertya-framework' ) ?></label>
       <input type="text" class="admin-inputs" name="agency-whats" value="<?php echo esc_attr($agency_whats); ?>">
        </div>
    </div>
    <div class="col-6">
     <div class="form-group">
       <label><?php echo esc_html__( 'Office Number', 'propertya-framework' ) ?></label>
       <input type="text" class="admin-inputs" name="agency-office" value="<?php echo esc_attr($agency_office); ?>">
        </div>
    </div>
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'Fax Number ', 'propertya-framework' ) ?></label>
       <input type="text" class="admin-inputs" name="agency-fax" value="<?php echo esc_attr($agency_fax); ?>">
        </div>
    </div>
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'Agency License', 'propertya-framework' ) ?></label>
       <input type="text" class="admin-inputs" name="agency-licence" value="<?php echo esc_attr($agency_licence); ?>">
        </div>
    </div>
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__('Tax Number ', 'propertya-framework' ) ?></label>
       <input type="text" class="admin-inputs" name="agency-tax" value="<?php echo esc_attr($agency_tax); ?>">
        </div>
    </div>
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'Website Url ', 'propertya-framework' ) ?></label>
       <input type="text" class="admin-inputs" name="agency-url" value="<?php echo esc_url($agency_url); ?>">
        </div>
    </div>
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'Agency Location', 'propertya-framework' ) ?></label>
       <select class="custom-fields" name="agency-location" data-placeholder="<?php echo esc_attr__('Select Location','propertya-framework');?>">
              <?php propertya_framework_terms_options('agency_location' , $agency_location); ?>
			</select>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'Office Hours', 'propertya-framework' ) ?></label>
       <input type="text" class="admin-inputs" name="agency-hours" value="<?php echo esc_attr($agency_hours); ?>">
       <p class="description"><?php echo esc_html__( 'Eg: Monday - Friday, 9 AM - 9 PM', 'propertya-framework' ) ?></p>
        </div>
    </div>
     <div class="clearfix"></div>
    
    
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'Facebook URL', 'propertya-framework' ) ?></label>
        <input type="text" class="admin-inputs" name="agency-fb" value="<?php echo esc_url($agency_fb); ?>">
        </div>
    </div>
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'Twitter URL', 'propertya-framework' ) ?></label>
        <input type="text" class="admin-inputs" name="agency-tw" value="<?php echo esc_url($agency_tw); ?>">
        </div>
    </div>
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'LinkedIn URL ', 'propertya-framework' ) ?></label>
        <input type="text" class="admin-inputs" name="agency-in" value="<?php echo esc_url($agency_in); ?>">
        </div>
    </div>
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'Instagram URL ', 'propertya-framework' ) ?></label>
        <input type="text" class="admin-inputs" name="agency-insta" value="<?php echo esc_url($agency_insta); ?>">
        </div>
    </div>
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'Youtube URL', 'propertya-framework' ) ?></label>
        <input type="text" class="admin-inputs" name="agency-you" value="<?php echo esc_url($agency_you); ?>">
        </div>
    </div>
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'Pinterest URL', 'propertya-framework' ) ?></label>
        <input type="text" class="admin-inputs" name="agency-pin" value="<?php echo esc_url($agency_pin); ?>">
        </div>
    </div>
    
     <div class="col-12">
         <div class="form-group">
           <label><?php echo esc_html__('Address','propertya-framework');?></label>
           <div class="get-loc">
           <input type="text" class="admin-inputs" id="property_address" name="agency-address" value="<?php echo esc_attr($agency_street_addr); ?>">
           <?php 
		   if(!empty(propertya_framework_get_options('property_opt_enable_geo')) && !empty(propertya_framework_get_options('property_opt_api_settings')))
		   {
		   ?>
           <i class="detect-me dashicons dashicons-move"></i>
           <?php
		   }
		   ?>
           </div>
           <p><?php echo esc_html__('if you dont add address then map will not show on property detail page.','propertya-framework');?></p>
    		</div>
        </div>
       <?php
	    if(propertya_framework_get_options('property_opt_enable_map') == 1) { ?>
            <div class="col-12">
                 <div class="form-group">
                    <div id="property_map"></div>
                </div>
            </div>
        <?php
		}
		?>
        <div class="col-6">
                <div class="form-group">
                    <label><?php echo esc_html__('Coordinates','propertya-framework');?>  </label>
                    <input type="text" class="admin-inputs" name="agency-latt" id="property_latt" value="<?php echo esc_attr($agency_latt); ?>">
                    <p><?php echo esc_html__('Your location Latitude','propertya-framework');?></p>
                </div>
            </div>
        <div class="col-6">
                <div class="form-group">
                    <label for="longitude">&nbsp;</label>
                    <input type="text" class="admin-inputs" name="agency-long" id="property_long" value="<?php echo esc_attr($agency_long); ?>">
                    <p><?php echo esc_html__('Your location Longitude','propertya-framework');?></p>
                </div>
            </div>
 </div>       
<?php
	}
	public function propertya_framework_property_save_metabox_agency( $post_id, $post ) {
		// Add nonce for security and authentication.
		$nonce_name = ( isset($_POST['agency_nonce']) ) ? $_POST['agency_nonce'] : ' ';
		$nonce_action = 'agency_nonce_action';
		$agency_id = $post_id;
		// Check if a nonce is set.
		if ( ! isset( $nonce_name ) )
			return;

		// Check if a nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) )
			return;

		// Check if the user has permissions to save data.
		if ( ! current_user_can( 'edit_post', $agency_id ) )
			return;

		// Check if it's not an autosave.
		if ( wp_is_post_autosave( $agency_id ) )
			return;

		// Check if it's not a revision.
		if ( wp_is_post_revision( $agency_id ) )
			return;
		//sanatize fields
		
		$agency_email = isset( $_POST[ 'agency-email' ] ) ? sanitize_email( $_POST[ 'agency-email' ] ) : '';
		$agency_mobile = isset( $_POST[ 'agency-mobile' ] ) ? sanitize_text_field( $_POST[ 'agency-mobile' ] ) : '';
		$agency_whats = isset( $_POST[ 'agency-whats' ] ) ? sanitize_text_field( $_POST[ 'agency-whats' ] ) : '';
		$agency_office = isset( $_POST[ 'agency-office' ] ) ? sanitize_text_field( $_POST[ 'agency-office' ] ) : '';
		$agency_fax = isset( $_POST[ 'agency-fax' ] ) ? sanitize_text_field( $_POST[ 'agency-fax' ] ) : '';
		$agency_licence = isset( $_POST[ 'agency-licence' ] ) ? sanitize_text_field( $_POST[ 'agency-licence' ] ) : '';
		$agency_tax = isset( $_POST['agency-tax']) ? sanitize_text_field( $_POST['agency-tax'] ) : '';
		$agency_url = isset( $_POST[ 'agency-url' ] ) ? sanitize_text_field( $_POST[ 'agency-url' ] ) : '';
		$agency_location = isset( $_POST[ 'agency-location' ] ) ? sanitize_text_field( $_POST[ 'agency-location' ] ) : '';
		$agency_hours = isset( $_POST['agency-hours']) ? sanitize_text_field( $_POST['agency-hours'] ) : '';
		$agency_fb = isset( $_POST[ 'agency-fb' ] ) ? sanitize_text_field( $_POST[ 'agency-fb' ] ) : '';
		$agency_tw = isset( $_POST[ 'agency-tw' ] ) ? sanitize_text_field( $_POST[ 'agency-tw' ] ) : '';
		$agency_in = isset( $_POST[ 'agency-in' ] ) ? sanitize_text_field( $_POST[ 'agency-in' ] ) : '';
		$agency_insta = isset( $_POST[ 'agency-insta' ] ) ? sanitize_text_field( $_POST[ 'agency-insta' ] ) : '';
		$agency_you = isset( $_POST[ 'agency-you' ] ) ? sanitize_text_field( $_POST[ 'agency-you' ] ) : '';
		$agency_pin = isset( $_POST[ 'agency-pin' ] ) ? sanitize_text_field( $_POST[ 'agency-pin' ] ) : '';
		$agency_street_addr = isset( $_POST[ 'agency-address' ] ) ? sanitize_text_field( $_POST[ 'agency-address' ] ) : '';
		$agency_latt = isset( $_POST[ 'agency-latt' ] ) ? sanitize_text_field( $_POST[ 'agency-latt' ] ) : '';
		$agency_long = isset( $_POST[ 'agency-long' ] ) ? sanitize_text_field( $_POST[ 'agency-long' ] ) : '';
		// Update the meta field in the database.
		update_post_meta($agency_id, 'agency_status', '1' );
		if (get_post_meta($agency_id, 'agency_is_featured', true ) == "1")
		{
		}
		else
		{
			update_post_meta($agency_id, 'agency_is_featured', '0');
		}
		if (get_post_meta($agency_id, 'agency_is_trusted', true ) == "1")
		{
		}
		else
		{
			update_post_meta($agency_id, 'agency_is_trusted', '0');
		}
		update_post_meta($agency_id, 'agency_email', $agency_email);
		update_post_meta($agency_id, 'agency_mobile', $agency_mobile );
		update_post_meta($agency_id, 'agency_whats', $agency_whats );
		update_post_meta($agency_id, 'agency_office', $agency_office );
		update_post_meta($agency_id, 'agency_fax', $agency_fax);
		update_post_meta($agency_id, 'agency_licence', $agency_licence );
		update_post_meta($agency_id, 'agency_tax', $agency_tax);
		update_post_meta($agency_id, 'agency_url', $agency_url);
		update_post_meta($agency_id, 'agency_fb', $agency_fb);
		update_post_meta($agency_id, 'agency_tw', $agency_tw);
		update_post_meta($agency_id, 'agency_in', $agency_in );
		update_post_meta($agency_id, 'agency_insta', $agency_insta);
		update_post_meta($agency_id, 'agency_you', $agency_you);
		update_post_meta($agency_id, 'agency_pin', $agency_pin);
		update_post_meta($agency_id, 'agency_street_addr', $agency_street_addr);
		update_post_meta($agency_id, 'agency_latt', $agency_latt);
		update_post_meta($agency_id, 'agency_long', $agency_long);
		update_post_meta($agency_id, 'agency_hours', $agency_hours);
		//Agency location
		wp_set_object_terms($agency_id, propertya_framework_get_ancestors($agency_location,'agency_location'), 'agency_location');
		update_post_meta($agency_id, 'agency_location', $agency_location);
	}
}
new propertya_framework_agency;
// Custom fields to this post type
add_filter( 'manage_property-agency_posts_columns', 'propertya_framework_edit_agency_table' );
function propertya_framework_edit_agency_table($columns) {
	
	 unset($columns['date']);
		$columns['agency_ref']          = esc_html__( 'Agency ID', 'propertya-framework' );
		$columns['agency_thumb']        = esc_html__('Thumbnail', 'propertya-framework' );
	    $columns['agency_properties']   = esc_html__('Properties', 'propertya-framework' );
		$columns['agency_agents']       = esc_html__( 'Agents', 'propertya-framework' );
		$columns['agency_mob']          = esc_html__( 'Mobile No', 'propertya-framework' );
	    $new = array();
	foreach($columns as $key => $title)
	{
		  if($key=='title')
		  {
			$new['agency_thumb']        = esc_html__('Thumbnail', 'propertya-framework' );  
		  }
    	  if($key=='taxonomy-property_location')
		  {
			  
			  $new['agency_ref']         = esc_html__('Agency ID', 'propertya-framework' );
			  $new[ 'title' ]            = esc_html__('Agency', 'propertya-framework' );
			  $new[ 'agency_properties'] = esc_html__('Properties', 'propertya-framework' );
			  $new[ 'agency_agents' ]    = esc_html__('Agents', 'propertya-framework' );
		  }
		  if($key=='date')
		  {
			 $new[ 'agency_mob' ]        =  esc_html__('Mobile No', 'propertya-framework' );
		  }
		  $new[$key] = $title;
    }
	return $new;
}
// Add the data to the custom columns for the post type:
add_action( 'manage_property-agency_posts_custom_column' , 'propertya_framework_render_agency_table', 10, 2 );
function propertya_framework_render_agency_table( $column, $post_id ) {
        switch ( $column ) {
         case 'agency_mob' :
			echo  get_post_meta( $post_id, 'agency_mobile', true );
		 break;
		 case 'agency_thumb' :
		 if ( has_post_thumbnail() )
		 {
			echo the_post_thumbnail(array(64,64)); //size of the thumbnail 
		 }
		 else
		 {
			 $my_img = SB_PLUGIN_URL . "libs/images/placeholder.png";
			 echo '<img alt="" src="'.esc_url($my_img).'" width="64">';
			 
		 }
		 break;
		 case 'agency_properties':
		 	 $user_id = get_post_field( 'post_author', $post_id );
			 echo count_user_posts($user_id , "property"  ) ;
		 break;
		  case 'agency_agents':
		     global $wpdb;
		     $user_id = get_post_field( 'post_author', $post_id );
			 $agency_id = '';
			 if(get_user_meta( $user_id, 'prop_post_id' , true ) !="")
		     {
			    $agency_id = get_user_meta( $user_id, 'prop_post_id' , true );
		     }
			 $total_free = $wpdb->get_var(( "SELECT COUNT(*) FROM $wpdb->postmeta WHERE meta_key = 'agent_agency_id' AND  meta_value = '$agency_id'"));
			 echo esc_attr($total_free);
			 
			// echo $listing_count;
			 /*$posts = get_posts(array(
				'post_type'     => 'property-agents',
				'meta_key'      => 'agent_agency_id',
				'meta_value'    => $agency_id
    		 ));
			 echo count($posts);*/
		 break;
		 case 'agency_ref':
		 echo esc_attr($post_id);
		 break;
    }
}
//Sidebar meta
class propertya_framework_agency_sidebar 
{
	public function __construct() {
		if ( is_admin() ) {
			add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		}
	}
	public function init_metabox() {
		add_action( 'add_meta_boxes',        array( $this, 'propertya_framework_property_add_metabox_agency_sidebar'));
		add_action( 'save_post',             array( $this, 'propertya_framework_property_save_metabox_agency_sidebox' ), 10, 2 );
		add_action( 'admin_enqueue_scripts', array( $this, 'propertya_framework_scripts_styles'));
		add_action( 'admin_footer',          array( $this, 'propertya_framework_admin_js'));
	}
	public function propertya_framework_property_add_metabox_agency_sidebar() {
		add_meta_box(
			'agency_meta_fields_sidebar',
			 esc_html__( 'Agency Information', 'propertya-framework' ),
			array( $this, 'propertya_framework_render_metabox_agency_sidebox' ),
			'property-agency',
			'side',
			'high'
		);
	}
	public function propertya_framework_render_metabox_agency_sidebox($post)
	{
		wp_nonce_field( 'agency_nonce_action_sidebox', 'agency_nonce_sidebox' );
		// Retrieve an existing value from the database.
		$agency_is_featured = get_post_meta( $post->ID, 'agency_is_featured', true );
		$agency_is_trusted  = get_post_meta( $post->ID, 'agency_is_trusted', true );
		$agency_badge_txt   = get_post_meta( $post->ID, 'agency_badge_txt', true );
		$agency_badge_clr   = get_post_meta( $post->ID, 'agency_badge_clr', true );
		// Set default values.
		if( empty($agency_is_trusted) ) $agency_is_trusted = '0';
		if( empty($agency_is_featured) ) $agency_is_featured = '0';
		if( empty($agency_badge_txt) ) $agency_badge_txt = '';
		if( empty($agency_badge_clr) ) $agency_badge_clr = '';
	?>
        <table class="form-table">
            <tr>
                <td>
                <p><?php echo esc_html__('Do you want to make this agency featured!', 'propertya-framework' ); ?></p>
                <ul class="radio-lists">
                     <li>
                         <label><input value="1" type="radio" <?php checked('1',$agency_is_featured,true); ?> name="is-feat"><?php echo esc_html__( 'Yes', 'propertya-framework' ); ?></label>
                     </li>
                     <li>
                         <label><input value="0" type="radio" <?php checked('0',$agency_is_featured,true); ?> name="is-feat"><?php echo esc_html__( 'No', 'propertya-framework' ); ?></label>
                     </li>
                 </ul>
                </td>
            </tr>
            <tr>
                <td>
                    <p><?php echo esc_html__('Do you want to make this agency trusted?', 'propertya-framework' ); ?></p>
                    <ul class="radio-lists">
                     <li>
                         <label><input value="1" type="radio" <?php checked('1',$agency_is_trusted,true); ?> name="is-trust"><?php echo esc_html__( 'Yes', 'propertya-framework' ); ?></label>
                     </li>
                     <li>
                         <label><input value="0" type="radio" <?php checked('0',$agency_is_trusted,true); ?> name="is-trust"><?php echo esc_html__( 'No', 'propertya-framework' ); ?></label>
                     </li>
                 </ul>
                 
                    <div class="form-group">
                        <label><?php echo esc_html__('Badge Text','propertya-framework');?>  </label>
                        <input type="text" class="admin-inputs" name="badge-txt" value="<?php echo esc_attr($agency_badge_txt); ?>">
                        <p><?php echo esc_html__('Eg : Trusted Seller','propertya-framework');?></p>
                    </div>
                    <div class="form-group">
                        <label><?php echo esc_html__('Badge Color','propertya-framework');?>  </label>
                        <input type="text" class="region_color_picker" name="badge-clr" value="<?php echo esc_attr($agency_badge_clr); ?>">
                        <p><?php echo esc_html__('The hex color of the badge field.','propertya-framework');?></p>
                    </div>
                </td>
             </tr>   
        </table>
    <?php
	}
	public function propertya_framework_property_save_metabox_agency_sidebox( $post_id, $post ) {
		// Add nonce for security and authentication.
		$nonce_name = ( isset($_POST['agency_nonce_sidebox']) ) ? $_POST['agency_nonce_sidebox'] : ' ';
		$nonce_action = 'agency_nonce_action_sidebox';
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
		
		$agency_is_featured = isset( $_POST[ 'is-feat' ] ) ? sanitize_text_field( $_POST[ 'is-feat' ] ) : '';
		$agency_is_trusted = isset( $_POST[ 'is-trust' ] ) ? sanitize_text_field( $_POST[ 'is-trust' ] ) : '';
		$agency_badge_txt = isset( $_POST[ 'badge-txt' ] ) ? sanitize_text_field( $_POST[ 'badge-txt' ] ) : '';
		$agency_badge_clr = isset( $_POST[ 'badge-clr' ] ) ? sanitize_text_field( $_POST[ 'badge-clr' ] ) : '';
		update_post_meta($post_id, 'agency_is_featured',$agency_is_featured);
		update_post_meta($post_id, 'agency_is_trusted',$agency_is_trusted);
		update_post_meta($post_id, 'agency_badge_txt',$agency_badge_txt);
		update_post_meta($post_id, 'agency_badge_clr',$agency_badge_clr);
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
new propertya_framework_agency_sidebar;