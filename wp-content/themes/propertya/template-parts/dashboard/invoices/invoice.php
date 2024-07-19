<?php
	global $localization;
    $owner_id = $user_id = $author_id = $keyword = '';
	$my_invoices = array();
	$user_id = get_current_user_id();
	if(get_user_meta( $user_id, 'prop_post_id', true) !="" && get_user_meta($user_id, 'user_role_type', true) !="")
	{
		$author_id = get_user_meta( $user_id, 'prop_post_id' , true );
		$owner_id = get_post_field( 'post_author', $author_id );
	}

?>
<div class="content-wrapper">
        
          <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title"><?php echo esc_html($localization['invoice_order_history']);?></h4>
				  <?php
                        //pagination
						$per_page = 10;
						if(propertya_strings('prop_dash_listings') != "")
						{
							$per_page = propertya_strings('prop_dash_listings'); 
						}
                        $paged = 1;
                        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
                        $get_args = propertya_framework_fetch_user_invocies($owner_id,$paged,$per_page);
                        $my_invoices = new WP_Query( $get_args );
                        if ( $my_invoices->have_posts() )
                        {
                  ?>
                  		<div class="table-responsive custom-tabel-label">
                            <table class="custom-tabel">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th><?php echo esc_html($localization['invoice_prop_id']);?></th>
                                        <th><?php echo esc_html($localization['invoice_transaction']);?></th>
                                        <th><?php echo esc_html($localization['invoice_status']);?></th>
                                        <th><?php echo esc_html($localization['invoice_total']);?></th>
                                        <th><?php echo esc_html($localization['invoice_method']);?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
								 while ( $my_invoices->have_posts() )
								 {
									$my_invoices->the_post();
									$invoice_id	=	get_the_ID();
									$image_id = $all_idz = '';
									$property_id = get_post_meta( $invoice_id, 'prop_inv_listing_id', true);
									$all_idz = propertya_framework_fetch_gallery_idz($property_id);
								?>
                                <tr id="<?php echo esc_attr($invoice_id); ?>" data-row-id="<?php echo esc_attr($invoice_id); ?>">
                                	<td>
                                     <span class="admin-listing-img">
                                         <a href="<?php echo esc_url(get_the_permalink($property_id)); ?>">
                                                <img class="img-responsive" src="<?php echo propertya_framework_img_src($all_idz,'thumbnail'); ?>" alt="<?php echo esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)); ?>"></a>
                                     </span>
                                    </td>
                                    <td>
                                    <span class="text-warnings admin-listing-date">
                                      <?php echo esc_html($property_id);?></span>
                                    <a href="<?php echo esc_url(get_the_permalink(get_post_meta( $invoice_id, 'prop_inv_listing_id', true ))); ?>"><span class="admin-listing-title"><?php echo esc_html__( 'View Property', 'propertya' ); ?> </span></a> 
                                    </td>
                                    <td><strong><?php echo get_the_title($invoice_id); ?></strong>
                                    <?php
									if(get_post_meta( $invoice_id, 'prop_inv_date', true ) !="")
									{
                                     echo '<div class="purchaed-date"> '.esc_html__( 'Purchase Date', 'propertya' ).' : '. wp_date(get_option('date_format'), strtotime(get_post_meta( $invoice_id, 'prop_inv_date', true ))). '</div>';
									}
                                    ?>
                                    </td>
                                    <td>
                                    <?php
									if(get_post_meta( $invoice_id, 'prop_inv_status', true )!="" && get_post_meta( $invoice_id, 'prop_inv_status', true )=="1")														                                    {
										echo '<span class="paid-btnz">
                                          <div class="circle-featured-border is-trans-complete"></div> <span>'.esc_html__( 'Paid', 'propertya' ).'</span>';
								    }
									?>
                                    </td>
                                    <td><?php echo esc_html(get_post_meta( $invoice_id, 'prop_inv_paidcurrency', true )); ?></td>
                                    <td>
                                    <?php 
									if(get_post_meta( $invoice_id, 'prop_inv_pay_type', true ) !="")
									{
										$type_id = '';
										$type_id =  get_post_meta( $invoice_id, 'prop_inv_pay_type', true );
										echo '<img src='.propertya_framework_payment_imgz($type_id).' alt="'.esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', TRUE)).'">';
									}
									?>
                                    </td>
                                </tr>
                                <?php
								 }
								  wp_reset_postdata();
								?>
                              </tbody>
                            </table>
                       </div>
                  <?php
						}
						else
						{
							get_template_part('template-parts/dashboard/invoices/content', 'none'); 
						}
				   ?>
                   <?php propertya_framework_prop_pagination($my_invoices, true); ?>
                </div>
              </div>
            </div>
          </div>
        </div>