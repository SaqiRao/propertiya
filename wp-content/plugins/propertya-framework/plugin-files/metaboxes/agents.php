<?php
class propertya_framework_agents {
	public function __construct()
	{
		if ( is_admin() ) {
			add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		}
	}
	public function init_metabox() {
		add_action( 'add_meta_boxes',        array( $this, 'propertya_framework_property_add_metabox_agent'));
		add_action( 'save_post',             array( $this, 'propertya_framework_property_save_metabox_agent' ), 10, 2 );
	}
	public function propertya_framework_property_add_metabox_agent() {
		add_meta_box(
			'agent_meta_fields',
			esc_html__( 'Agent Information', 'propertya-framework' ),
			array( $this, 'propertya_framework_render_metabox_agent' ),
			'property-agents',
			'advanced',
			'default'
		);
	}
	public function propertya_framework_render_metabox_agent( $post )
	{
		wp_nonce_field( 'agents_nonce_action', 'agents_nonce' );
		// Retrieve an existing value from the database.
		$agent_email = get_post_meta( $post->ID, 'agent_email', true );
		$agent_pos = get_post_meta( $post->ID, 'agent_pos', true );
		$agent_type = get_post_meta( $post->ID, 'agent_type', true );
		$agent_mobile = get_post_meta( $post->ID, 'agent_mobile', true );
		$agent_whats = get_post_meta( $post->ID, 'agent_whats', true );
		$agent_office = get_post_meta( $post->ID, 'agent_office', true );
		$agent_fax = get_post_meta( $post->ID, 'agent_fax', true );
		$agent_url = get_post_meta( $post->ID, 'agent_url', true );
		$agent_location = get_post_meta( $post->ID, 'agent_location', true );
		$agent_skype = get_post_meta( $post->ID, 'agent_skype', true );
		$agent_hours = get_post_meta( $post->ID, 'agent_hours', true );
		$agent_fb = get_post_meta( $post->ID, 'agent_fb', true );
		$agent_tw = get_post_meta( $post->ID, 'agent_tw', true );
		$agent_in = get_post_meta( $post->ID, 'agent_in', true );
		$agent_insta = get_post_meta( $post->ID, 'agent_insta', true );
		$agent_you = get_post_meta( $post->ID, 'agent_you', true );
		$agent_pin = get_post_meta( $post->ID, 'agent_pin', true );
		$agent_street_addr = get_post_meta( $post->ID, 'agent_street_addr', true );
		$agent_latt = get_post_meta( $post->ID, 'agent_latt', true );
		$agent_long = get_post_meta( $post->ID, 'agent_long', true );
		$agent_agency = get_post_meta( $post->ID, 'agent_agency_id', true );
		
		// Set default values.
		if( empty($agent_email) ) $agent_email = '';
		if( empty($agent_pos) ) $agent_pos = '';
		if( empty($agent_type) ) $agent_type = '';
		if( empty($agent_mobile) ) $agent_mobile = '';
		if( empty($agent_whats) ) $agent_whats = '';
		if( empty($agent_office) ) $agent_office = '';
		if( empty($agent_fax) ) $agent_fax = '';
		if( empty($agent_url) ) $agent_url = '';
		if( empty($agent_location) ) $agent_location = '';
		if( empty($agent_skype) ) $agent_skype = '';
		if( empty($agent_hours) ) $agent_hours = '';
		if( empty($agent_fb) ) $agent_fb = '';
		if( empty($agent_tw) ) $agent_tw = '';
		if( empty($agent_in) ) $agent_in = '';
		if( empty($agent_insta) ) $agent_insta = '';
		if( empty($agent_you) ) $agent_you = '';
		if( empty($agent_pin) ) $agent_pin = '';
		if( empty($agent_street_addr) ) $agent_street_addr = '';
		if( empty($agent_agency) ) $agent_agency = '';
		if( empty($agent_latt) ) $agent_latt = '';
		if( empty($agent_long) ) $agent_long = '';
		
?>
<div class="row">
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__('Email Address', 'propertya-framework' ) ?></label>
        <input type="text" class="admin-inputs" name="agent-email" value="<?php echo esc_attr($agent_email); ?>">
            <p class="description"><?php echo esc_html__( 'Messages from contact form on property details page, will be sent on this email address.', 'propertya-framework' ) ?></p>
        </div>
    </div>
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__('Position', 'propertya-framework' ) ?></label>
       <input type="text" class="admin-inputs" name="agent-pos" value="<?php echo esc_attr($agent_pos); ?>">
        <p class="description"><?php echo esc_html__( 'Eg: Founder & CEO.', 'propertya-framework' ) ?></p>
        </div>
    </div>
    <div class="clearfix"></div>
    
    <div class="col-6">
         <div class="form-group">
           <label><?php echo esc_html__('Agent Type','propertya-framework');?></label>
           <select class="custom-fields" name="agent-type" data-placeholder="<?php echo esc_attr__('Agent Type','propertya-framework');?>">
              <?php propertya_framework_terms_options('agent_types', $agent_type); ?>
			</select>
    		</div>
        </div>
        
        <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'Agent Location', 'propertya-framework' ) ?></label>
       <select class="custom-fields" name="agent-location" data-placeholder="<?php echo esc_attr__('Select Location','propertya-framework');?>">
              <?php propertya_framework_terms_options('agent_location' , $agent_location); ?>
			</select>
        </div>
    </div>
    
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'Mobile Number', 'propertya-framework' ) ?></label>
       <input type="text" class="admin-inputs" name="agent-mobile" value="<?php echo esc_attr($agent_mobile); ?>">
           
        </div>
    </div>
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'WhatsApp Number', 'propertya-framework' ) ?></label>
       <input type="text" class="admin-inputs" name="agent-whats" value="<?php echo esc_attr($agent_whats); ?>">
        </div>
    </div>
    <div class="col-6">
     <div class="form-group">
       <label><?php echo esc_html__( 'Office Number', 'propertya-framework' ) ?></label>
       <input type="text" class="admin-inputs" name="agent-office" value="<?php echo esc_attr($agent_office); ?>">
        </div>
    </div>
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'Fax Number ', 'propertya-framework' ) ?></label>
       <input type="text" class="admin-inputs" name="agent-fax" value="<?php echo esc_attr($agent_fax); ?>">
        </div>
    </div>
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'Website Url ', 'propertya-framework' ) ?></label>
       <input type="text" class="admin-inputs" name="agent-url" value="<?php echo esc_url($agent_url); ?>">
        </div>
    </div>
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'Skype', 'propertya-framework' ) ?></label>
       <input type="text" class="admin-inputs" name="agent-skype" value="<?php echo esc_attr($agent_skype); ?>">
        </div>
    </div>
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'Office Hours', 'propertya-framework' ) ?></label>
       <input type="text" class="admin-inputs" name="agent-hours" value="<?php echo esc_attr($agent_hours); ?>">
       <p class="description"><?php echo esc_html__( 'Eg: Monday - Friday, 9 AM - 9 PM', 'propertya-framework' ) ?></p>
        </div>
    </div>
    <div class="clearfix"></div>
    
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'Facebook URL', 'propertya-framework' ) ?></label>
        <input type="text" class="admin-inputs" name="agent-fb" value="<?php echo esc_url($agent_fb); ?>">
        </div>
    </div>
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'Twitter URL', 'propertya-framework' ) ?></label>
        <input type="text" class="admin-inputs" name="agent-tw" value="<?php echo esc_url($agent_tw); ?>">
        </div>
    </div>
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'LinkedIn URL ', 'propertya-framework' ) ?></label>
        <input type="text" class="admin-inputs" name="agent-in" value="<?php echo esc_url($agent_in); ?>">
        </div>
    </div>
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'Instagram URL ', 'propertya-framework' ) ?></label>
        <input type="text" class="admin-inputs" name="agent-insta" value="<?php echo esc_url($agent_insta); ?>">
        </div>
    </div>
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'Youtube URL', 'propertya-framework' ) ?></label>
        <input type="text" class="admin-inputs" name="agent-you" value="<?php echo esc_url($agent_you); ?>">
        </div>
    </div>
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'Pinterest URL', 'propertya-framework' ) ?></label>
        <input type="text" class="admin-inputs" name="agent-pin" value="<?php echo esc_url($agent_pin); ?>">
        </div>
    </div>
    <div class="clearfix"></div>
    
    <div class="col-12 clearfix">
         <div class="form-group">
           <label><?php echo esc_html__('Address','propertya-framework');?></label>
           <div class="get-loc">
           <input type="text" class="admin-inputs" id="property_address" name="agent-address" value="<?php echo esc_attr($agent_street_addr); ?>">
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
                    <input type="text" class="admin-inputs" name="agent-latt" id="property_latt" value="<?php echo esc_attr($agent_latt); ?>">
                    <p><?php echo esc_html__('Your location Latitude','propertya-framework');?></p>
                </div>
            </div>
            <div class="col-6 clearfix">
                <div class="form-group">
                    <label for="longitude">&nbsp;</label>
                    <input type="text" class="admin-inputs" name="agent-long" id="property_long" value="<?php echo esc_attr($agent_long); ?>">
                    <p><?php echo esc_html__('Your location Longitude','propertya-framework');?></p>
                </div>
            </div>
             <?php
		}
		?>
    <div class="clearfix"></div>
    <hr/>
    
    <div class="col-6">
     <div class="form-group">
      <label><?php echo esc_html__( 'Agencies', 'propertya-framework' ) ?></label>
      	    <select class="custom-fields" name="agent-agency" data-placeholder="<?php echo esc_attr__('Assign Agency','propertya-framework');?>">
              <?php propertya_framework_show_allagencies('agent-agency' , $agent_agency); ?>
			</select>
        </div>
    </div>
 </div>       
<?php
	}
	public function propertya_framework_property_save_metabox_agent( $post_id, $post ) {
		// Add nonce for security and authentication.
		$nonce_name = ( isset($_POST['agents_nonce']) ) ? $_POST['agents_nonce'] : ' ';
		$nonce_action = 'agents_nonce_action';
		$agent_id = $post_id;
		// Check if a nonce is set.
		if ( ! isset( $nonce_name ) )
			return;

		// Check if a nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) )
			return;

		// Check if the user has permissions to save data.
		if ( ! current_user_can( 'edit_post', $agent_id ) )
			return;

		// Check if it's not an autosave.
		if ( wp_is_post_autosave( $agent_id ) )
			return;

		// Check if it's not a revision.
		if ( wp_is_post_revision( $agent_id ) )
			return;
		//sanatize fields
		$agent_email = isset( $_POST[ 'agent-email' ] ) ? sanitize_email( $_POST[ 'agent-email' ] ) : '';
		$agent_pos = isset( $_POST[ 'agent-pos' ] ) ? sanitize_text_field( $_POST[ 'agent-pos' ] ) : '';
		$agent_type = isset( $_POST[ 'agent-type' ] ) ? sanitize_text_field( $_POST[ 'agent-type' ] ) : '';
		$agent_mobile = isset( $_POST[ 'agent-mobile' ] ) ? sanitize_text_field( $_POST[ 'agent-mobile' ] ) : '';
		$agent_whats = isset( $_POST[ 'agent-whats' ] ) ? sanitize_text_field( $_POST[ 'agent-whats' ] ) : '';
		$agent_office = isset( $_POST[ 'agent-office' ] ) ? sanitize_text_field( $_POST[ 'agent-office' ] ) : '';
		$agent_fax = isset( $_POST[ 'agent-fax' ] ) ? sanitize_text_field( $_POST[ 'agent-fax' ] ) : '';
		$agent_skype = isset( $_POST[ 'agent-skype' ] ) ? sanitize_text_field( $_POST[ 'agent-skype' ] ) : '';
		$agent_hours = isset( $_POST['agent-hours']) ? sanitize_text_field( $_POST['agent-hours'] ) : '';
		$agent_url = isset( $_POST[ 'agent-url' ] ) ? sanitize_text_field( $_POST[ 'agent-url' ] ) : '';
		$agent_location = isset( $_POST[ 'agent-location' ] ) ? sanitize_text_field( $_POST[ 'agent-location' ] ) : '';
		$agent_fb = isset( $_POST[ 'agent-fb' ] ) ? sanitize_text_field( $_POST[ 'agent-fb' ] ) : '';
		$agent_tw = isset( $_POST[ 'agent-tw' ] ) ? sanitize_text_field( $_POST[ 'agent-tw' ] ) : '';
		$agent_in = isset( $_POST[ 'agent-in' ] ) ? sanitize_text_field( $_POST[ 'agent-in' ] ) : '';
		$agent_insta = isset( $_POST[ 'agent-insta' ] ) ? sanitize_text_field( $_POST[ 'agent-insta' ] ) : '';
		$agent_you = isset( $_POST[ 'agent-you' ] ) ? sanitize_text_field( $_POST[ 'agent-you' ] ) : '';
		$agent_pin = isset( $_POST[ 'agent-pin' ] ) ? sanitize_text_field( $_POST[ 'agent-pin' ] ) : '';
		$agent_agency = isset( $_POST[ 'agent-agency' ] ) ? sanitize_text_field( $_POST[ 'agent-agency' ] ) : '';
		$agent_street_addr = isset( $_POST[ 'agent-address' ] ) ? sanitize_text_field( $_POST[ 'agent-address' ] ) : '';
		$agent_latt = isset( $_POST[ 'agent-latt' ] ) ? sanitize_text_field( $_POST[ 'agent-latt' ] ) : '';
		$agent_long = isset( $_POST[ 'agent-long' ] ) ? sanitize_text_field( $_POST[ 'agent-long' ] ) : '';
		// Update the meta field in the database.
		update_post_meta($agent_id, 'agent_status', '1' );
		if (get_post_meta($agent_id, 'agent_is_featured', true ) == "1")
		{
		}
		else
		{
			update_post_meta($agent_id, 'agent_is_featured', '0');
		}
		if (get_post_meta($agent_id, 'agent_is_trusted', true ) == "1")
		{
		}
		else
		{
			update_post_meta($agent_id, 'agent_is_trusted', '0');
		}
		update_post_meta($agent_id, 'agent_email', $agent_email);
		update_post_meta($agent_id, 'agent_pos', $agent_pos);
		//type
		wp_set_object_terms($agent_id, $agent_type, 'agent_types');
		update_post_meta($agent_id, 'agent_type', $agent_type);
		//location
		wp_set_object_terms($agent_id, propertya_framework_get_ancestors($agent_location,'agent_location'), 'agent_location');
		update_post_meta($agent_id, 'agent_location', $agent_location);
		update_post_meta($agent_id, 'agent_mobile', $agent_mobile );
		update_post_meta($agent_id, 'agent_whats', $agent_whats );
		update_post_meta($agent_id, 'agent_office', $agent_office );
		update_post_meta($agent_id, 'agent_fax', $agent_fax);
		update_post_meta($agent_id, 'agent_url', $agent_url);
		update_post_meta($agent_id, 'agent_skype', $agent_skype );
		update_post_meta($agent_id, 'agent_hours', $agent_hours);
		
		update_post_meta($agent_id, 'agent_fb', $agent_fb);
		update_post_meta($agent_id, 'agent_tw', $agent_tw);
		update_post_meta($agent_id, 'agent_in', $agent_in );
		update_post_meta($agent_id, 'agent_insta', $agent_insta);
		update_post_meta($agent_id, 'agent_you', $agent_you);
		update_post_meta($agent_id, 'agent_pin', $agent_pin);
		update_post_meta($agent_id, 'agent_agency_id', $agent_agency);
		update_post_meta($agent_id, 'agent_street_addr', $agent_street_addr);
		update_post_meta($agent_id, 'agent_latt', $agent_latt);
		update_post_meta($agent_id, 'agent_long', $agent_long);
	}
}
new propertya_framework_agents;
// Custom fields to this post type
add_filter( 'manage_property-agents_posts_columns', 'propertya_framework_edit_agent_table' );
function propertya_framework_edit_agent_table($columns) {
	
	unset($columns['date']);
	$columns['agent_ref'] = esc_html__( 'Agent ID', 'propertya-framework' );
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
			  
			  $new['agent_ref'] = esc_html__('Agent ID', 'propertya-framework' );
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
add_action( 'manage_property-agents_posts_custom_column' , 'propertya_framework_render_agent_table', 10, 2 );
function propertya_framework_render_agent_table( $column, $post_id ) {
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
class propertya_framework_agents_sidebar 
{
	public function __construct() {
		if ( is_admin() ) {
			add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		}
	}
	public function init_metabox() {
		add_action( 'add_meta_boxes',        array( $this, 'propertya_framework_property_add_metabox_agent_sidebar'));
		add_action( 'save_post',             array( $this, 'propertya_framework_property_save_metabox_agent_sidebox' ), 10, 2 );
		add_action( 'admin_enqueue_scripts', array( $this, 'propertya_framework_scripts_styles'));
		add_action( 'admin_footer',          array( $this, 'propertya_framework_admin_js'));
	}
	public function propertya_framework_property_add_metabox_agent_sidebar() {
		add_meta_box(
			'agent_meta_fields_sidebar',
			 esc_html__( 'Agent Information', 'propertya-framework' ),
			array( $this, 'propertya_framework_render_metabox_agent_sidebox' ),
			'property-agents',
			'side',
			'high'
		);
	}
	public function propertya_framework_render_metabox_agent_sidebox($post)
	{
		wp_nonce_field( 'agent_nonce_action_sidebox', 'agent_nonce_sidebox' );
		// Retrieve an existing value from the database.
		$agent_is_featured = get_post_meta( $post->ID, 'agent_is_featured', true );
		$agent_is_trusted = get_post_meta( $post->ID, 'agent_is_trusted', true );
		$agent_badge_txt = get_post_meta( $post->ID, 'agent_badge_txt', true );
		$agent_badge_clr = get_post_meta( $post->ID, 'agent_badge_clr', true );
		// Set default values.
		if( empty($agent_is_trusted) ) $agent_is_trusted = '0';
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
                    <p><?php echo esc_html__('Do you want to make this agent trusted?', 'propertya-framework' ); ?></p>
                    <ul class="radio-lists">
                     <li>
                         <label><input value="1" type="radio" <?php checked('1',$agent_is_trusted,true); ?> name="is-trust"><?php echo esc_html__( 'Yes', 'propertya-framework' ); ?></label>
                     </li>
                     <li>
                         <label><input value="0" type="radio" <?php checked('0',$agent_is_trusted,true); ?> name="is-trust"><?php echo esc_html__( 'No', 'propertya-framework' ); ?></label>
                     </li>
                 </ul>
                    <div class="form-group">
                        <label><?php echo esc_html__('Badge Text','propertya-framework');?>  </label>
                        <input type="text" class="admin-inputs" name="badge-txt" value="<?php echo esc_attr($agent_badge_txt); ?>">
                        <p><?php echo esc_html__('Eg : Trusted Seller','propertya-framework');?></p>
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
	public function propertya_framework_property_save_metabox_agent_sidebox( $post_id, $post ) {
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
		$agent_is_trusted = isset( $_POST[ 'is-trust' ] ) ? sanitize_text_field( $_POST[ 'is-trust' ] ) : '';
		$agent_badge_txt = isset( $_POST[ 'badge-txt' ] ) ? sanitize_text_field( $_POST[ 'badge-txt' ] ) : '';
		$agent_badge_clr = isset( $_POST[ 'badge-clr' ] ) ? sanitize_text_field( $_POST[ 'badge-clr' ] ) : '';
		update_post_meta($post_id, 'agent_is_featured',$agent_is_featured);
		update_post_meta($post_id, 'agent_is_trusted',$agent_is_trusted);
		update_post_meta($post_id, 'agent_badge_txt',$agent_badge_txt);
		update_post_meta($post_id, 'agent_badge_clr',$agent_badge_clr);
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
new propertya_framework_agents_sidebar;