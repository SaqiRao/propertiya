<?php
class propertya_framework_packages {
  public function __construct() {
    if ( is_admin() ) {
      add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
      add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
    }
  }
  public function init_metabox() {
    add_action( 'add_meta_boxes', array( $this, 'add_metabox'  )        );
    add_action( 'save_post',      array( $this, 'save_metabox' ), 10, 2 );
  }
  public function add_metabox() {
    add_meta_box(
      'propertya_product',
      __( 'For Packages', 'propertya-framework' ),
      array( $this, 'render_metabox' ),
      'product',
      'normal',
      'high'
    );
  }
  public function render_metabox( $post ) {
    // Retrieve an existing value from the database.
    $package_type = get_post_meta( $post->ID, 'prop_package_type', true );
    $package_tagline = get_post_meta( $post->ID, 'prop_package_tagline', true );
    $package_expiry = get_post_meta( $post->ID, 'prop_package_expiry', true );
    $regular_listing = get_post_meta( $post->ID, 'prop_regular_listing', true );
    $listing_expiry = get_post_meta( $post->ID, 'prop_regular_listing_expiry', true );
    $featured_listing = get_post_meta( $post->ID, 'prop_featured_listing', true );
    $featured_listing_expiry = get_post_meta( $post->ID, 'prop_featured_listing_expiry', true );
    $bump_listing = get_post_meta( $post->ID, 'prop_bump_listing', true );
    $make_package_featured = get_post_meta( $post->ID, 'prop_make_package_featured', true );
    // Set default values.
    if( empty( $package_type ) ) $package_type = '';
        if( empty( $package_tagline ) ) $package_tagline = '';
    if( empty( $package_price ) ) $package_price = '';
    if( empty( $package_expiry ) ) $package_expiry = '';
    if( empty( $regular_listing ) ) $regular_listing = '';
    if( empty( $listing_expiry ) ) $listing_expiry = '';
    if( empty( $featured_listing ) ) $featured_listing = '';
    if( empty( $featured_listing_expiry ) ) $featured_listing_expiry = '';
      if( empty( $bump_listing ) ) $bump_listing = '';
    if( empty( $make_package_featured ) ) $make_package_featured = '';
    global $propertya_options;
    ?>
        <div class="custom-meta-fields required">
          <p class="label">
            <label><?php echo esc_html__( 'Package Tagline', 'propertya-framework' ); ?> <span class="required">*</span></label>
            <div class="input-wrap">
                <input class="text" name="package_tagline" value="<?php echo esc_attr($package_tagline); ?>" placeholder="<?php echo esc_html__( "Most Trending Listings Pack", 'propertya-framework' ); ?>" type="text">
            </div>
    </div>

        <div class="custom-meta-fields required">
          <p class="label">
            <label><?php echo esc_html__( 'Package Type', 'propertya-framework' ); ?> <span class="required">*</span></label>
            <?php echo esc_html__( "Select package type whether it's a paid package or free", 'propertya-framework' ); ?></p>
          <select class="select" name="package_type" tabindex="-1" aria-hidden="true">
            <option value="free" <?php selected( $package_type, 'free',true ); ?>><?php echo esc_html__( 'Free', 'propertya-framework' ); ?></option>
            <option value="paid" <?php selected( $package_type, 'paid',true); ?>><?php echo esc_html__( 'Paid', 'propertya-framework' ); ?></option>
          </select>
    </div>
        
        <div class="custom-meta-fields required">
          <p class="label">
            <label><?php echo esc_html__( 'Make Package Featured', 'propertya-framework' ); ?></label>
            <?php echo esc_html__( "Do you want to highlight this package.", 'propertya-framework' ); ?></p>
          <select class="select" name="make_package_featured" tabindex="-1" aria-hidden="true">
            <option value=""><?php echo esc_html__( 'Select an option', 'propertya-framework' ); ?></option>
            <option value="yes" <?php selected( $make_package_featured, 'yes',true); ?>><?php echo esc_html__( 'Yes', 'propertya-framework' ); ?></option>
            <option value="no" <?php selected( $make_package_featured, 'no',true); ?>><?php echo esc_html__( 'No', 'propertya-framework' ); ?></option>
          </select>
    </div>

        <div class="custom-meta-fields required">
          <p class="label">
            <label><?php echo esc_html__( 'Package Duration ( Days )', 'propertya-framework' ); ?> <span class="required">*</span></label>
            <?php echo esc_html__( "Expiry in days, -1 means never expired it.", 'propertya-framework' ); ?></p>
            <div class="input-wrap">
                <input class="text" name="package_expiry" value="<?php echo esc_attr($package_expiry); ?>" placeholder="<?php echo esc_html__( "Number of days eg 60.", 'propertya-framework' ); ?>" type="text">
            </div>
    </div>
        <div class="custom-meta-fields required">
          <p class="label">
            <label><?php echo esc_html__( 'Total Listings', 'propertya-framework' ); ?> </label>
            <?php echo esc_html__( "Total number of listings allowed in this package.", 'propertya-framework' ); ?></p>
            <div class="input-wrap">
                <input class="text" name="regular_listing" value="<?php echo esc_attr($regular_listing); ?>" placeholder="<?php echo esc_html__( "eg 10", 'propertya-framework' ); ?>" type="text">
            </div>
    </div>
        <div class="custom-meta-fields required">
          <p class="label">
            <label><?php echo esc_html__( 'Total Listings Expiry ( Days )', 'propertya-framework' ); ?> <span class="required">*</span></label>
            <?php echo esc_html__( "Expiry in days, -1 means never expired.", 'propertya-framework' ); ?></p>
            <div class="input-wrap">
                <input class="text" name="listing_expiry" value="<?php echo esc_attr($listing_expiry); ?>" placeholder="<?php echo esc_html__( "Number of days eg 60.", 'propertya-framework' ); ?>" type="text">
            </div>
    </div>
        <div class="custom-meta-fields required">
          <p class="label">
            <label><?php echo esc_html__( 'Featured Listing', 'propertya-framework' ); ?></label>
            <?php echo esc_html__( "Total number of featured listings.", 'propertya-framework' ); ?></p>
            <div class="input-wrap">
                <input class="text" name="featured_listing" value="<?php echo esc_attr($featured_listing); ?>" placeholder="<?php echo esc_html__( "eg 5", 'propertya-framework' ); ?>" type="text">
            </div>
    </div>
        <div class="custom-meta-fields required">
          <p class="label">
            <label><?php echo esc_html__( 'Featured For', 'propertya-framework' ); ?></label>
            <?php echo esc_html__( "Expiry in days, -1 means never expired unless used it.", 'propertya-framework' ); ?></p>
            <div class="input-wrap">
                <input class="text" name="featured_listing_expiry" value="<?php echo esc_attr($featured_listing_expiry); ?>" placeholder="<?php echo esc_html__( "number of days eg 7", 'propertya-framework' ); ?>" type="text">
            </div>
    </div>
<?php
  }

  public function save_metabox( $post_id, $post ) {

    // Check if the user has permissions to save data.
    if ( ! current_user_can( 'edit_post', $post_id ) )
      return;

    // Check if it's not an autosave.
    if ( wp_is_post_autosave( $post_id ) )
      return;

    // Check if it's not a revision.
    if ( wp_is_post_revision( $post_id ) )
      return;

    // Sanitize user input.
    $package_tagline = isset( $_POST[ 'package_tagline' ] ) ? sanitize_text_field( $_POST[ 'package_tagline' ] ) : '';
    $package_type = isset( $_POST[ 'package_type' ] ) ? sanitize_text_field( $_POST[ 'package_type' ] ) : '';
    $package_price = isset( $_POST[ 'package_price' ] ) ? sanitize_text_field( $_POST[ 'package_price' ] ) : '';
    $package_expiry = isset( $_POST[ 'package_expiry' ] ) ? sanitize_text_field( $_POST[ 'package_expiry' ] ) : '';
    $regular_listing = isset( $_POST[ 'regular_listing' ] ) ? sanitize_text_field( $_POST[ 'regular_listing' ] ) : '';
    $listing_expiry = isset( $_POST[ 'listing_expiry' ] ) ? sanitize_text_field( $_POST[ 'listing_expiry' ] ) : '';
    $featured_listing = isset( $_POST[ 'featured_listing' ] ) ? sanitize_text_field( $_POST[ 'featured_listing' ] ) : '';
    $featured_listing_expiry = isset( $_POST[ 'featured_listing_expiry' ] ) ? sanitize_text_field( $_POST[ 'featured_listing_expiry' ] ) : '';
    $bump_listing = isset( $_POST[ 'bump_listing' ] ) ? sanitize_text_field($_POST[ 'bump_listing' ]) : '';
    $make_package_featured = isset( $_POST[ 'make_package_featured' ] ) ? sanitize_text_field($_POST[ 'make_package_featured' ]) : '';
    // Update the meta field in the database.
        update_post_meta( $post_id, 'prop_package_tagline', $package_tagline);
    update_post_meta( $post_id, 'prop_package_type', $package_type );
    update_post_meta( $post_id, 'prop_package_price', $package_price );
    update_post_meta( $post_id, 'prop_package_expiry', $package_expiry );
    update_post_meta( $post_id, 'prop_regular_listing', $regular_listing );
    update_post_meta( $post_id, 'prop_regular_listing_expiry', $listing_expiry );
    update_post_meta( $post_id, 'prop_featured_listing', $featured_listing );
    update_post_meta( $post_id, 'prop_featured_listing_expiry', $featured_listing_expiry );
    update_post_meta( $post_id, 'prop_bump_listing', $bump_listing );
    update_post_meta( $post_id, 'prop_make_package_featured', $make_package_featured );
  }
}
new propertya_framework_packages;