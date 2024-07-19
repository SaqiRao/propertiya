<?php
//Ad slots 
global $propertya_options; 
if( isset( $propertya_options['prop_listing_slot_4'] ) && $propertya_options['prop_listing_slot_4'] != "")
{
?>
<div class="sidebar-widget-seprator">
        <div class="sidebar-widget-header">
          <h4><?php echo esc_html(propertya_strings('prop_detail_sidebar_banner')); ?></h4>
        </div>
        
        <div class="sidebar-widget-body">
                <div class="widget-inner-container">
                	<div class="sidebar-banners">
                		<?php  echo ' '.$propertya_options['prop_listing_slot_4']; ?>
                    </div>
                </div>
        </div>
    </div>
<?php
}