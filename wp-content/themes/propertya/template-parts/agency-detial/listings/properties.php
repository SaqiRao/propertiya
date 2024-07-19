<?php
$propes = get_query_var('propsingle-propes');
if(!empty($propes) && is_array($propes) && count($propes) > 0) 
{
	 $listingz = new propertya_getlistings();
	
	 $search_page_link = propertya_framework_get_link('page-property-search.php');
	 $agency_id	=	get_the_ID();
	 $author_id = get_post_field( 'post_author', $agency_id );
	 $auth_name = basename(get_permalink($agency_id));
?>					 
	<div class="widget-seprator" id="p-listings">
    <?php if(!empty( propertya_strings('prop_settings_detail_listings'))) { ?>
		<div class="widget-seprator-heading">
			<h3 class="sec-title"><?php echo propertya_strings('prop_settings_detail_listings'); ?></h3>
		</div>
    <?php } ?>    
		<div class="agency-properties">
			<?php  
			foreach($propes as $props)
			{
				echo ''.$listingz->propertya_similiar_listings($props);
			}  
			?>
		</div>
        <div class="viewmore-button">
        		<a class="btn btn-outline btn-block" href="<?php echo esc_url($search_page_link).'?property-author='.$author_id.''; ?>" target="_blank"><?php echo esc_html__('View All Properties','propertya'); ?></a>
    </div>
	</div>
<?php
 }