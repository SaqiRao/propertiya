<section class="section-padding single-comparison">
   <div class="container">
    <div class="row sec-heading-zone">
        <div class="col ">
            <div class="sec-heading ">
                <p><?php echo propertya_strings('prop_compare_tagline'); ?></p>
                <h2><?php echo propertya_strings('prop_compare_heading'); ?></h2>
            </div>
        </div>
    </div>
      <div class="row">
          <div class="col-xl-12 col-12">
                <div class="compare-table table-responsive">
                   <table>
                      <tbody>
                         <tr class="no-stripe ">
                             <th><?php echo esc_html__('Specifications','propertya'); ?></th>
                             <?php echo propertya_params($img_link); ?>
                         </tr>
                          <tr>
                            <th><?php echo esc_html($localization['property_type']); ?></th>
                            <?php echo propertya_params($type); ?>
                         </tr>
                          <tr>
                            <th><?php echo esc_html($localization['status']); ?></th>
                            <?php echo propertya_params($status); ?>
                         </tr>
                          <tr>
                            <th><?php echo esc_html($localization['prop_id']); ?></th>
                            <?php echo propertya_params($pro_id); ?>
                         </tr>
                          <tr>
                            <th><?php echo esc_html($localization['prop_size']); ?></th>
                            <?php echo propertya_params($size); ?>
                         </tr>
                          <tr>
                            <th><?php echo esc_html($localization['land_area']); ?></th>
                            <?php echo propertya_params($land); ?>
                         </tr>
                          <tr>
                            <th><?php echo esc_html($localization['bedrooms']); ?></th>
                            <?php echo propertya_params($beds); ?>
                         </tr>
                           <tr>
                            <th><?php echo esc_html($localization['bathrooms']); ?></th>
                            <?php echo propertya_params($baths); ?>
                         </tr>
                          <tr>
                            <th><?php echo esc_html($localization['grages']); ?></th>
                            <?php echo propertya_params($grages); ?>
                         </tr>
                          <tr>
                            <th><?php echo esc_html($localization['yearbuild']); ?></th>
                            <?php echo propertya_params($year); ?>
                         </tr>
                         <tr class="other-features">
                            <th><?php echo esc_html__('Other Features','propertya'); ?></th>
                                <?php echo propertya_params($features_html); ?>
                         </tr>
                      </tbody>
                   </table>
                </div>
          </div>
      </div>
   </div>
</section>