<?php
$selected_terms = '';
global $propertya_options;
if (!empty($propertya_options["prop_getpop_loc"])) {
    $selected_terms = $propertya_options["prop_getpop_loc"];
}
?>
<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="propertya-footer-widgets top-locations">
        <h2><span><?php echo propertya_strings("prop_pop_loc"); ?></span></h2>
        <ul class="list">
            <?php
            if (!empty($selected_terms) && is_array($selected_terms) && count($selected_terms) > 0) {
                foreach ($selected_terms as $term) {
                    $term = get_term_by('id', absint($term), 'property_location');
                    if (is_object($term) && $term != '') {
                        ?>
                        <li>
                        <a href="<?php echo esc_url(get_term_link($term->slug, 'property_location')); ?>">
                        <i class="fa fa-angle-right"></i><?php echo esc_html($term->name); ?></a></li>
                        <?php
                    }
                }
            }
            ?>
        </ul>
    </div>
</div>