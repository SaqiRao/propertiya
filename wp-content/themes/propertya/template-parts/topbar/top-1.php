<?php 
$container_class = 'container';

?>
<div class="topbar-1">
    <div class="<?php echo esc_attr($container_class); ?>">
        <div class="row">
            <div class="col-md-8">
                <ul class="list-inline">
                    <?php if(!empty(prop_currency_switcher())) { ?>
                    <li class="list-inline-item currency-dropdown ">
                        <?php echo prop_currency_switcher(); ?>
                    </li>
                    <?php } ?>
                    <?php if(!empty(propertya_strings('prop_top_email'))) { ?>
                    <li class="list-inline-item"><a href="mailto:<?php echo esc_url(propertya_strings('prop_top_email')); ?>"><i class="far fa-paper-plane"></i> <?php echo esc_html(propertya_strings('prop_top_email')); ?></a></li>
                    <?php } ?>
                    <?php if(!empty(propertya_strings('prop_top_contactno'))) { ?>
                    <li class="list-inline-item"><a href="tel:<?php echo str_replace(" ", "", propertya_strings('prop_top_contactno')); ?>"><i class="fas fa-mobile-alt"></i> <?php echo esc_html(propertya_strings('prop_top_contactno')); ?></a></li>
                    <?php } ?>
                    <?php if(!empty(propertya_strings('prop_top_hours'))) { ?>    
                   <li class="list-inline-item">
                      <a href="javascript:void(0)"><i class="far fa-clock"></i> <?php echo esc_html(propertya_strings('prop_top_hours')); ?></a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <?php if(!empty(propertya_strings('prop_top_pages')) && is_array(propertya_strings('prop_top_pages')) && count(propertya_strings('prop_top_pages')) > 0) { ?>
                    <div class="col-md-4 ms-auto">
                        <ul class="list-inline float-end">
                            <?php
                             $pages = array();
                             $pages = propertya_strings('prop_top_pages');
                             foreach($pages as $page)
                             {
                             ?>  
                                <li class="list-inline-item"><a href="<?php echo esc_url(get_the_permalink($page)); ?>"><?php echo get_the_title($page); ?></a></li>
                            <?php
                             }
                             ?>
                        </ul>
                    </div>
                <?php               
                } 
                ?>
        </div>
    </div>
</div>