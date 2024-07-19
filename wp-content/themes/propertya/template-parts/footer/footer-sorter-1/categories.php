<?php
$selected_terms = '';
global $propertya_options;
if (!empty($propertya_options["prop_getpop_catz"])) {
    $selected_terms = $propertya_options["prop_getpop_catz"];
}
?>
<div class=" col-lg-3 col-md-6 col-sm-6 col-xl-3 col-12">
    <div class="propertya-footer-widgets top-cats">
        <h2><span><?php echo propertya_strings("prop_pop_catz"); ?></span></h2>
        <ul class="list">
            <?php
            if (!empty($selected_terms) && is_array($selected_terms)) {
                foreach ($selected_terms as $term) {
                    $term = get_term_by('id', absint($term), 'property_type');
                    if (is_object($term) && $term != '') {
                        ?>
                        <li>
                        <a href="<?php echo esc_url(get_term_link($term->slug, 'property_type')); ?>">
                        <i class="fa fa-angle-right"></i><?php echo esc_html($term->name); ?></a></li>
                        <?php
                    }
                }
            }
            ?>
        </ul>
    </div>
</div> 
