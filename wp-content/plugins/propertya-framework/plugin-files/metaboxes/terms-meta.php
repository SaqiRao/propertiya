<?php
class listing_location_meta
{
	public $get_type;
	public function __construct($get_type) {
		if ( is_admin() ) {
			$this->get_type = $get_type;
			add_action( $this->get_type.'_add_form_fields',  array( $this, 'propertya_framework_create_location_fields'), 10, 1 );
			add_action( $this->get_type.'_edit_form_fields', array( $this, 'propertya_framework_edit_location_fields' ),  10, 2 );
			add_action( 'created_'.$this->get_type, array( $this, 'save_data' ), 10, 1 );
			add_action( 'edited_'.$this->get_type,  array( $this, 'save_data' ), 10, 1 );
			add_action( 'admin_enqueue_scripts', array( $this, 'load_wp_media_files' ) , 10, 1 );
		    add_action( 'admin_footer', array ( $this, 'add_script' ), 10, 1  );
			add_filter( 'manage_edit-'.$this->get_type.'_columns',array( $this, 'propertya_framework_term_meta_column' ),  10, 2 );
			add_action( 'manage_'.$this->get_type.'_custom_column', array( $this,'dwt_listing_location_term_meta_column_content'), 10, 3);
			add_filter('manage_edit-'.$this->get_type.'_columns',  array( $this,'dwt_listing_location_order') , 10, 3);
		}
	}
	public function load_wp_media_files() {
 		wp_enqueue_media();
	}
	// term meta cols
	public function propertya_framework_term_meta_column( $columns )
	{
		$columns['term_img'] = "Icon";
		unset($columns['description']);
		return $columns;
	}
	public function dwt_listing_location_term_meta_column_content( $value, $column_name, $tax_id )
	{
		 if ($column_name === 'term_img')
		 {
			$image_id = get_term_meta($tax_id, $this->get_type.'_term_meta_img', true );
			if ( $image_id ) {
				 echo wp_get_attachment_image ( $image_id, 'thumbnail' );
			}
			else
			{
				$img = SB_PLUGIN_URL . "libs/images/placeholder.png";
				return '<img src="'.esc_url($img).'">';
			}
		}
	}
	public function dwt_listing_location_order($columns)
	{
		  $new = array();
		  foreach($columns as $key => $title) {
			if ($key=='name') // Put the Thumbnail column before the Author column
			  $new['term_img'] = 'Icon';
			  $new[$key] = $title;
		  }
	 	 return $new;
	}
	public function propertya_framework_create_location_fields($taxonomy){ ?>
       <div class="form-field term-group">
         <label><?php echo esc_html__('Image', 'propertya-framework'); ?></label>
         <input type="hidden" id="<?php echo esc_attr($this->get_type); ?>_term_meta_img" name="<?php echo esc_attr($this->get_type); ?>_term_meta_img" class="custom_media_url" value="">
         <div id="loc-image-wrapper"></div>
         <p>
           <input type="button" class="btn-admin btn-add button-adimage_<?php echo esc_attr($this->get_type); ?>" value="<?php echo esc_attr__( 'Add Image', 'propertya-framework' ); ?>" />
           <input type="button" class="btn-admin btn-remove button-removeimg_<?php echo esc_attr($this->get_type); ?>" value="<?php echo esc_attr__( 'Remove Image', 'propertya-framework' ); ?>" />
        </p>
       </div>
 <?php
 }
	public function propertya_framework_edit_location_fields($term, $taxonomy){ ?>
   <tr class="form-field term-group-wrap">
     <th scope="row">
       <label><?php _e( 'Image', 'propertya-framework' ); ?></label>
     </th>
     <td>
       <?php $image_id = get_term_meta ($term->term_id,$this->get_type.'_term_meta_img', true ); ?>
       <input type="hidden" id="<?php echo esc_attr($this->get_type); ?>_term_meta_img" name="<?php echo esc_attr($this->get_type); ?>_term_meta_img" value="<?php echo $image_id; ?>">
       <div id="loc-image-wrapper">
         <?php if ( $image_id ) { ?>
           <?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
         <?php } ?>
       </div>
       <p>
         <input type="button" class="btn-admin btn-add button-adimage_<?php echo esc_attr($this->get_type); ?>"  value="<?php echo esc_attr__( 'Add Image', 'propertya-framework' ); ?>" />
         <input type="button" class="btn-admin btn-remove button-removeimg_<?php echo esc_attr($this->get_type); ?>" value="<?php echo esc_attr__( 'Remove Image', 'propertya-framework' ); ?>" />
       </p>
     </td>
   </tr>
 <?php
 }
	public function save_data( $term_id ) {
		if( isset( $_POST[$this->get_type.'_term_meta_img'] ) && '' !== $_POST[$this->get_type.'_term_meta_img'] )
		{
    		 $image = $_POST[$this->get_type.'_term_meta_img'];
    		 update_term_meta ( $term_id, $this->get_type.'_term_meta_img', $image );
   		}
		else
		{
     		update_term_meta ( $term_id, $this->get_type.'_term_meta_img', '' );
   		}
	}
	 public function add_script() { ?>
   <script>
     jQuery(document).ready( function($) {
	 $('body').on('click','.button-adimage_<?php echo esc_attr($this->get_type); ?>',function(){
         var is_meta_img = true;
           wp.media.editor.send.attachment = function(props, attachment){
             if (is_meta_img) {
               $('#<?php echo esc_attr($this->get_type); ?>_term_meta_img').val(attachment.id);
               $('#loc-image-wrapper').html('<img class="custom_meta_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
               $('#loc-image-wrapper .custom_meta_image').attr('src',attachment.url).css('display','block');
             } 
            }
         wp.media.editor.open();
         return false;
      });
     $('body').on('click','.button-removeimg_<?php echo esc_attr($this->get_type); ?>',function(){
       $('#<?php echo esc_attr($this->get_type); ?>_term_meta_img').val('');
       $('#loc-image-wrapper').html('<img class="custom_meta_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
     });
   });
 </script>
 <?php 
 }
}