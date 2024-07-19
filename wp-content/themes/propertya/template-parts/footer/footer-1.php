<?php global $propertya_options; ?>
<div class="dark-footer" style=background-image:url(<?php echo propertya_site_footer_image(); ?>)   class=img-fluid>

	<?php if(isset($propertya_options['prop_footer1_sorter']['enabled']) && $propertya_options['prop_footer1_sorter']['enabled'] !="")
	{
	?>	   
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <?php
				$layout = '';
                $layout = isset($propertya_options['prop_footer1_sorter']['enabled']) ? $propertya_options['prop_footer1_sorter']['enabled'] : '';
                if ($layout): foreach ($layout as $key => $value) {
                        switch ($key) {
                            case 'logo': get_template_part('template-parts/footer/footer-sorter-1/logo', '1');
                                break;

                            case 'countries': get_template_part('template-parts/footer/footer-sorter-1/countries');
                                break;

                            case 'cats': get_template_part('template-parts/footer/footer-sorter-1/categories');
                                break;

                            case 'links': get_template_part('template-parts/footer/footer-sorter-1/links');
                                break;
                        }
                    }
                endif;
                ?>
            </div>
        </div>
    </div>
    <?php
	}
	?>
    <div class="footer-copy">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-12">
                    <div class="footer-text"><?php echo propertya_footer_copyrights(); ?></div>				
                </div>
            </div>
        </div>
    </div>

</div>