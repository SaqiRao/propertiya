<?php
add_action( 'widgets_init', function()
{
     register_widget( 'propertya_framework_blog_posts' );
});
if (! class_exists ( 'propertya_framework_blog_posts' )) {
class propertya_framework_blog_posts extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		// Instantiate the parent object
		parent::__construct( false, 'Recent Blog Posts' );
	}
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		global $post;
		if($instance['propertya_framework_post_no'] == "" )
		{
			$instance['propertya_framework_post_no']	=	5;	
		}
		$args = array( 'post_type' => 'post', 'posts_per_page' => $instance['propertya_framework_post_no'], 'orderby' => 'date', 'order' => 'DESC');
		$recent_posts = get_posts( $args );
	?>
    <div class="widget">
                           <div class="widget-heading">
                              <h2><?php echo esc_html( $instance['title'] ); ?></h2>
                              <div class="heading-dots clearfix">
										<span class="h-dot line-dot"></span>
										<span class="h-dot"></span>
										<span class="h-dot"></span>
										<span class="h-dot"></span>
                					</div>
                           </div>
                           <div class="recent-ads">
                           <?php foreach ( $recent_posts as $recent_post ): ?>
                              <div class="recent-ads-list">
                                 <div class="recent-ads-container">
                                 <?php
								 if ( has_post_thumbnail($recent_post->ID))
								 {
								 ?>	 
                                    <div class="recent-ads-list-image">
                                       <a href="<?php echo esc_url(get_the_permalink($recent_post->ID)); ?>" class="recent-ads-list-image-inner">
										<?php echo get_the_post_thumbnail($recent_post->ID, 'propertya-small-thumb'); ?>
                                       </a>
                                    </div>
                                 <?php } ?>	   
                                    <div class="recent-ads-list-content">
                                       <h3 class="recent-ads-list-title">
                                          <a href="<?php echo esc_url( get_the_permalink( $recent_post->ID ) ); ?>"><?php echo esc_html( get_the_title( $recent_post->ID ) ); ?></a>
                                       </h3>
                                       <span class="recent-ads-list-location">
                                       <?php
									     $category = '';
									  	 $category = get_the_category( $recent_post->ID );
										 if(!empty($category))
										 {
										
									   ?>
                                          <a href="<?php echo esc_url( get_category_link(  $category[0]->cat_ID ) ); ?>"><?php echo ''.$category[0]->cat_name; ?></a>
                                          <?php
										 }
										 ?>
                                       </span>
                                    </div>
                                 </div>
                              </div>
							<?php endforeach; ?>	  
                           </div>
                        </div>
    <?php
	}
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = esc_html__( 'Recent Blog Posts', 'propertya-framework' );
		}
		if ( isset( $instance[ 'propertya_framework_post_no' ] ) ) {
			$propertya_framework_post_no = $instance[ 'propertya_framework_post_no' ];
		}
		else {
			$propertya_framework_post_no = 5;
		}
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" >
            <?php echo esc_html__( 'Title:', 'propertya-framework' ); ?>
            </label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'propertya_framework_post_no' ) ); ?>">
			<?php esc_html__( 'How many posts to diplay:', 'propertya-framework' ); ?>
            </label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'propertya_framework_post_no' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'propertya_framework_post_no' ) ); ?>" type="text" value="<?php echo esc_attr( $propertya_framework_post_no ); ?>">
		</p>
		<?php 
	}
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['propertya_framework_post_no'] = ( ! empty( $new_instance['propertya_framework_post_no'] ) ) ? strip_tags( $new_instance['propertya_framework_post_no'] ) : '';
		return $instance;
	}
} // Recent Posts
}

//Trusted Agencies
add_action( 'widgets_init', function()
{
     register_widget( 'propertya_framework_trusted_agencies' );
});
if (! class_exists ( 'propertya_framework_trusted_agencies' ))
{
	class propertya_framework_trusted_agencies extends WP_Widget
	{
		function __construct()
		{
			parent::__construct( false, 'Trusted Agencies' );
		}
		//render html
		public function widget( $args, $instance ) {
		if($instance['propertya_framework_post_no'] == "" )
		{
			$instance['propertya_framework_post_no']	=	5;	
		}
	?>
    <div class="sidebar-widget my-trusted-agencies">
          	<div class="widget">
           	 <div class="widget-heading">
              <h2><?php echo esc_html( $instance['title'] ); ?></h2>
            </div>
            
            <?php
			$args	=	array
			(
				'post_type' => 'property-agency',
				'post_status' => 'publish',
				'posts_per_page' => $instance['propertya_framework_post_no'],
				'paged' => 1,
				'meta_query'    => array(
					array(
						'key'       => 'agency_status',
						'value'     => '1',
						'compare'   => '=',
					),
					array(
						'key'       => 'agency_is_trusted',
						'value'     => '1',
						'compare'   => '=',
					),
				),
				'orderby'=> 'DATE',
				'order'=> 'DESC',
			);
			$results = new WP_Query( $args );
			if($results->have_posts())
			{
			?>	
               <ul class="list-group list-group-flush">
					  <?php
                          $fetch_output = '';
                          $layout_type = new propertya_get_agencies();
                          while ($results->have_posts())
                          {
                            $results->the_post();
                            $agency_id = get_the_ID();
                            $function = "propertya_get_trusted_agencies";
                            $fetch_output .= $layout_type->$function($agency_id);
                          }
                          wp_reset_postdata();
                          echo $fetch_output;
                      ?>
                          
               </ul>
         	<?php
			}
			?>
            </div>
          </div>
     <?php
	 }
	 
	    //form fields
	    public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = esc_html__( 'Trusted Agencies', 'propertya-framework' );
		}
		if ( isset( $instance[ 'propertya_framework_post_no' ] ) ) {
			$propertya_framework_post_no = $instance[ 'propertya_framework_post_no' ];
		}
		else {
			$propertya_framework_post_no = 5;
		}
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" >
            <?php echo esc_html__( 'Title:', 'propertya-framework' ); ?>
            </label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
        
        
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'propertya_framework_post_no' ) ); ?>">
			<?php esc_html__( 'How many posts to diplay:', 'propertya-framework' ); ?>
            </label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'propertya_framework_post_no' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'propertya_framework_post_no' ) ); ?>" type="text" value="<?php echo esc_attr( $propertya_framework_post_no ); ?>">
		</p>
		<?php 
	}
		
		// update
		public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['propertya_framework_post_no'] = ( ! empty( $new_instance['propertya_framework_post_no'] ) ) ? strip_tags( $new_instance['propertya_framework_post_no'] ) : '';
		return $instance;
	}
	}
}


//Simple or Featured Listings
add_action( 'widgets_init', function()
{
     register_widget( 'propertya_framework_featured_listings' );
});
if (! class_exists ( 'propertya_framework_featured_listings' ))
{
	class propertya_framework_featured_listings extends WP_Widget
	{
		function __construct()
		{
			parent::__construct( false, 'Simple or Featured Listings' );
		}
		//render html
		public function widget( $args, $instance ) {
		if($instance['propertya_framework_post_no'] == "" )
		{
			$instance['propertya_framework_post_no']	=	5;	
		}
		$type = 'simple';
		if(isset($instance['type']) && $instance[ 'type' ] !="")
		{
			$type = $instance['type'];
		}
	?>
    <div class="sidebar-widget simple-or-feat">
          	<div class="widget">
           	 <div class="widget-heading">
              <h2><?php echo esc_html( $instance['title'] ); ?></h2>
            </div>
            
            <?php
			$featured_listings = '';
			if($type == 'featured')
			{
				$featured_listings = array(
						'key'       => 'prop_is_feature_listing',
						'value'     => '1',
						'compare'   => '=',
					);
			}
			$args	=	array
			(
				'post_type' => 'property',
				'post_status' => 'publish',
				'posts_per_page' => $instance['propertya_framework_post_no'],
				'paged' => 1,
                'fields' => 'ids',
				'meta_query'    => array(
					array(
						'key'       => 'prop_status',
						'value'     => '1',
						'compare'   => '=',
					),
					$featured_listings
				),
				'orderby'=> 'DATE',
				'order'=> 'DESC',
			);
			$results = new WP_Query( $args );
			if($results->have_posts())
			{
			?>	
               <ul class="widget-inner-container recently-added">
					  <?php
                          $fetch_output = '';
                          $layout_type = new propertya_getlistings();
                          while ($results->have_posts())
                          {
                            $results->the_post();
                            $property_id = get_the_ID();
                            $function = "propertya_listings_most_viewed";
                            $fetch_output .= $layout_type->$function($property_id);
                          }
                          wp_reset_postdata();
                          echo $fetch_output;
                      ?>
                          
               </ul>
         	<?php
			}
			?>
            </div>
          </div>
     <?php
	 }
	 
	    //form fields
	    public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = esc_html__( 'Trusted Agencies', 'propertya-framework' );
		}
		if ( isset( $instance[ 'propertya_framework_post_no' ] ) ) {
			$propertya_framework_post_no = $instance[ 'propertya_framework_post_no' ];
		}
		else {
			$propertya_framework_post_no = 5;
		}
		
		if(isset($instance['type']) && $instance[ 'type' ] !=""){
			$type = $instance[ 'type' ];
		}
		else
		{
			$type = 'simple';
		}
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" >
            <?php echo esc_html__( 'Title:', 'propertya-framework' ); ?>
            </label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>" >
        <?php echo esc_html__( 'Select Listing Type:', 'propertya-framework' ); ?>
        </label> 
        <select id="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>" class="widefat">
    <option <?php selected($type, 'simple'); ?> value="simple"><?php echo esc_html__( 'Simple', 'propertya-framework' ); ?></option>
    <option <?php selected($type, 'featured'); ?> value="featured"><?php echo esc_html__( 'Featured', 'propertya-framework' ); ?></option> 
</select>
</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'propertya_framework_post_no' ) ); ?>">
			<?php esc_html__( 'How many posts to diplay:', 'propertya-framework' ); ?>
            </label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'propertya_framework_post_no' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'propertya_framework_post_no' ) ); ?>" type="text" value="<?php echo esc_attr( $propertya_framework_post_no ); ?>">
		</p>
		<?php 
	}
		
		// update
		public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['type'] = ( ! empty( $new_instance['type'] ) ) ? strip_tags( $new_instance['type'] ) : '';
		$instance['propertya_framework_post_no'] = ( ! empty( $new_instance['propertya_framework_post_no'] ) ) ? strip_tags( $new_instance['propertya_framework_post_no'] ) : '';
		return $instance;
	}
	}
}


//Most Viewed Agencies
add_action( 'widgets_init', function()
{
     register_widget( 'propertya_framework_most_viewed_agencies' );
});

if (! class_exists ( 'propertya_framework_most_viewed_agencies' ))
{
	class propertya_framework_most_viewed_agencies extends WP_Widget
	{
		function __construct()
		{
			parent::__construct( false, 'Most Viewed Agencies' );
		}
		//render html
		public function widget( $args, $instance ) {
		if($instance['propertya_framework_post_no'] == "" )
		{
			$instance['propertya_framework_post_no']	=	5;	
		}
		?>
        <div class="sidebar-widget agen-most-viewed">
          	<div class="widget">
           	 <div class="widget-heading">
              <h2><?php echo esc_html( $instance['title'] ); ?></h2>
            </div>
            <?php
			$args	=	array
			(
				'post_type' => 'property-agency',
				'post_status' => 'publish',
				'posts_per_page' => $instance['propertya_framework_post_no'],
				'paged' => 1,
				'meta_key' => 'prop_agency_singletotal_views',
				'meta_query'    => array(
					array(
						'key'       => 'agency_status',
						'value'     => '1',
						'compare'   => '=',
					),
				),
				'orderby'=> 'meta_value_num',
				'order'=> 'DESC',
			);
			$results = new WP_Query( $args );
			if($results->have_posts())
			{
				  $fetch_output = '';
				  $layout_type = new propertya_get_agencies();
				  while ($results->have_posts())
				  {
						$results->the_post();
						$agency_id = get_the_ID();
						$function = "propertya_get_most_viewed_agencies";
						$fetch_output .= $layout_type->$function($agency_id);
				  }
				  wp_reset_postdata();
				  echo $fetch_output;
			}
			?>
            </div>
          </div>
        <?php
	}
	
	//form fields
	    public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = esc_html__( 'Most Viewed Agencies', 'propertya-framework' );
		}
		if ( isset( $instance[ 'propertya_framework_post_no' ] ) ) {
			$propertya_framework_post_no = $instance[ 'propertya_framework_post_no' ];
		}
		else {
			$propertya_framework_post_no = 5;
		}
		
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" >
            <?php echo esc_html__( 'Title:', 'propertya-framework' ); ?>
            </label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
        
			<label for="<?php echo esc_attr( $this->get_field_id( 'propertya_framework_post_no' ) ); ?>">
			<?php esc_html__( 'How many posts to diplay:', 'propertya-framework' ); ?>
            </label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'propertya_framework_post_no' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'propertya_framework_post_no' ) ); ?>" type="text" value="<?php echo esc_attr( $propertya_framework_post_no ); ?>">
		</p>
		<?php 
	}
		
		// update
		public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['propertya_framework_post_no'] = ( ! empty( $new_instance['propertya_framework_post_no'] ) ) ? strip_tags( $new_instance['propertya_framework_post_no'] ) : '';
		return $instance;
	}
}
}