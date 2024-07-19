<?php
	$property_id	=	get_the_ID();
    if(empty(propertya_getselected_locations($property_id)))
	{
?>
<div class="sidebar-widget-seprator">
    <div class="sidebar-widget-header">
      <h4><?php echo esc_html(propertya_strings('prop_sidebar_addr')); ?></h4>
    </div>
    <div class="sidebar-widget-body">
            <div class="widget-inner-elements">
                <ul class="list-style-location">
                    <?php echo propertya_getselected_locations($property_id);?>
                </ul>
           </div>                                            
    </div>
</div>
<?php
	}