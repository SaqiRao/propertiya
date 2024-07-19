<?php
	global $localization;
	$title = '';
	if (isset($_GET['by_title']) && $_GET['by_title'] != "")
	{
		$title =  trim($_GET['by_title']);
	}
	$location = '';
	if (isset($_GET['by_location']) && $_GET['by_location'] != "")
	{
		$location =  trim($_GET['by_location']);
	}
    $layout_type = '';
    if(isset($_GET['agency-layout']) && ($_GET['agency-layout']!=""))
    {
        $layout_type = trim($_GET['agency-layout']);
    }
?>
<section class="agency-1 agent-section overflow-x">
  <div class="container">
    <div class="row">
      <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
        <aside class="agency-sidebar custom-padding">
          <div class="sidebar-widget">
            <div class="widget-heading">
              <h2><?php echo esc_html__('Find Agencies','propertya'); ?></h2>
            </div>
            <div class="form-submit">
              <form method="post" id="myagencies_search">
                  <div class="form-group near-mee">
                   <button class="btn btn-outline btn-block sonu-button" type="button" id="find_btn" data-spinner-text="<?php echo esc_attr($localization['processing']);?>"><i class="far fa-compass"></i> &nbsp; <?php echo esc_html($localization['near_me']);?></button>
                   </div>
               <div class="distance-slider price-range-slider none">
              <label><?php echo esc_html__('Select Distance','propertya'); ?></label>
              <div class="my_range_slider nstSlider" data-range_min="1" data-range_max="500" data-cur_min="20">
                <div class="bar"></div>
                <div class="leftGrip">
                  <div class="grip-label">
                    <span class="leftLabel"></span> <span class="dis-km"><?php echo esc_html__('KM','propertya'); ?></span>
                  </div>
                </div>
              </div>
            </div>  
               <div class="form-group">
                  <div class="typeahead__container">
            <div class="typeahead__field">
                <div class="typeahead__query">
                    <input name="by_title" value="<?php echo esc_attr($title); ?>" autocomplete="off" type="search" class="for_search_pages form-control specific_search" placeholder="<?php echo esc_attr__('Search By Name', 'propertya'); ?>" >
                </div>
            </div>
        </div>
        		</div>
               <div class="form-group">
                <select data-placeholder="<?php echo esc_attr__('Search By Location', 'propertya'); ?>" name="by_location" class="theme-selects form-control">
                    <?php propertya_framework_terms_options('agency_location' , $location); ?>
                </select>
               </div>
                <input type="hidden" name="latt" value="">
                <input type="hidden" name="long" value="">
                <input type="hidden" name="distance" value="">
                <input type="hidden" name="layout-type" value="<?php echo esc_attr($layout_type); ?>">
                <button type="button" name="agencies_search" class="btn btn-theme btn-block"><?php echo esc_html__('Search', 'propertya'); ?></button>
              </form>
            </div>
          </div>
          <?php
		  if (is_active_sidebar('prop_ag_seach_bar'))
		  {
			  dynamic_sidebar('prop_ag_seach_bar');
		  }
		  ?>
        </aside>
      </div>
      <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 ag-content custom-padding">
      <div class="row">
      	<div class="col-12 col-xl-12 col-md-12 col-sm-12">
        <div class="filter-sorting-bar d-flex flex-wrap justify-content-between align-items-center">
            <h4>
               <?php echo wp_sprintf(__('<span class="clr-yal"> %d </span> Results Found ', 'propertya'),esc_attr($results->found_posts)); ?>
            </h4>
            <div class=" d-flex d-block">
              <span class="sort-label align-self-center"><?php echo esc_html__('Sort by', 'propertya'); ?>:</span>
              <div class="short-by">
                <select name="sort-by" id="sort-by" class="sort-selects" data-placeholder="Newest To Oldest">
                      <option value="newest"><?php echo esc_html__('Newest To Oldest', 'propertya'); ?></option>
                      <option value="oldest"><?php echo esc_html__('Oldest To New', 'propertya'); ?></option>
                      <option value="title-asc"><?php echo esc_html__('Alphabetically [a-z]', 'propertya'); ?></option>
                      <option value="title-desc"><?php echo esc_html__('Alphabetically [z-a]', 'propertya'); ?></option>
                    </select>
              </div>
            </div>
		</div>
        <div class="my-filer-tags">
      <?php
       if (!empty($_GET)) {
           echo '<div class="filter-tags"><ul class="filter-tags-list">
          <li class="filter-tags-render">
            <span class="filter-reset">'.esc_html__('Clear All', 'propertya').':</span>'.esc_html__('Filters', 'propertya').'
            <a href="javascript:void(0)" id="reset_ajax_result" class="filter-reset-btn">×</a>
          </li>
        </ul></div>';
       }
       ?>
       </div>
		</div>
	  </div>
        <div class="row grid">
        <?php
		 $fetch_output = '';
		 if ($results->have_posts())
		 {
			 require trailingslashit(get_template_directory()) . "template-parts/search/agency-search/grids/grids.php";
			 echo ' '.$fetch_output;
		 }
		 else
		 {
			echo propertya_framework_no_result_found(); 
		 }
		 ?>
       </div>
       <div class="my-loading-bar">     
          <article class="fb-like-animation post--is-loading">
            <div class="post__loader">
              <div class="loader__bar--1"></div>
              <div class="loader__bar--2"></div>
              <div class="loader__bar--3"></div>
              <div class="loader__bar--4"></div>
              <div class="loader__bar--5"></div>
              <div class="loader__bar--6"></div>
              <div class="loader__bar--7"></div>
              <div class="loader__bar--8"></div>
              <div class="loader__bar--9"></div>
              <div class="loader__bar--10"></div>
              <div class="loader__bar--11"></div>
              <div class="loader__bar--12"></div>
            </div>
          </article>
          <article class="fb-like-animation post--is-loading">
            <div class="post__loader">
              <div class="loader__bar--1"></div>
              <div class="loader__bar--2"></div>
              <div class="loader__bar--3"></div>
              <div class="loader__bar--4"></div>
              <div class="loader__bar--5"></div>
              <div class="loader__bar--6"></div>
              <div class="loader__bar--7"></div>
              <div class="loader__bar--8"></div>
              <div class="loader__bar--9"></div>
              <div class="loader__bar--10"></div>
              <div class="loader__bar--11"></div>
              <div class="loader__bar--12"></div>
            </div>
          </article>
          <article class="fb-like-animation post--is-loading">
            <div class="post__loader">
              <div class="loader__bar--1"></div>
              <div class="loader__bar--2"></div>
              <div class="loader__bar--3"></div>
              <div class="loader__bar--4"></div>
              <div class="loader__bar--5"></div>
              <div class="loader__bar--6"></div>
              <div class="loader__bar--7"></div>
              <div class="loader__bar--8"></div>
              <div class="loader__bar--9"></div>
              <div class="loader__bar--10"></div>
              <div class="loader__bar--11"></div>
              <div class="loader__bar--12"></div>
            </div>
          </article>
          <article class="fb-like-animation post--is-loading">
            <div class="post__loader">
              <div class="loader__bar--1"></div>
              <div class="loader__bar--2"></div>
              <div class="loader__bar--3"></div>
              <div class="loader__bar--4"></div>
              <div class="loader__bar--5"></div>
              <div class="loader__bar--6"></div>
              <div class="loader__bar--7"></div>
              <div class="loader__bar--8"></div>
              <div class="loader__bar--9"></div>
              <div class="loader__bar--10"></div>
              <div class="loader__bar--11"></div>
              <div class="loader__bar--12"></div>
            </div>
          </article>
          <article class="fb-like-animation post--is-loading">
            <div class="post__loader">
              <div class="loader__bar--1"></div>
              <div class="loader__bar--2"></div>
              <div class="loader__bar--3"></div>
              <div class="loader__bar--4"></div>
              <div class="loader__bar--5"></div>
              <div class="loader__bar--6"></div>
              <div class="loader__bar--7"></div>
              <div class="loader__bar--8"></div>
              <div class="loader__bar--9"></div>
              <div class="loader__bar--10"></div>
              <div class="loader__bar--11"></div>
              <div class="loader__bar--12"></div>
            </div>
          </article>
          <article class="fb-like-animation post--is-loading">
            <div class="post__loader">
              <div class="loader__bar--1"></div>
              <div class="loader__bar--2"></div>
              <div class="loader__bar--3"></div>
              <div class="loader__bar--4"></div>
              <div class="loader__bar--5"></div>
              <div class="loader__bar--6"></div>
              <div class="loader__bar--7"></div>
              <div class="loader__bar--8"></div>
              <div class="loader__bar--9"></div>
              <div class="loader__bar--10"></div>
              <div class="loader__bar--11"></div>
              <div class="loader__bar--12"></div>
            </div>
          </article>
          <article class="fb-like-animation post--is-loading">
            <div class="post__loader">
              <div class="loader__bar--1"></div>
              <div class="loader__bar--2"></div>
              <div class="loader__bar--3"></div>
              <div class="loader__bar--4"></div>
              <div class="loader__bar--5"></div>
              <div class="loader__bar--6"></div>
              <div class="loader__bar--7"></div>
              <div class="loader__bar--8"></div>
              <div class="loader__bar--9"></div>
              <div class="loader__bar--10"></div>
              <div class="loader__bar--11"></div>
              <div class="loader__bar--12"></div>
            </div>
          </article>
      </div>
	  <?php if(!empty(propertya_pagination_search($results))) { ?>
         <div class="row">
               <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 margin-bottom-30"> 
                 <div id="listing_ajax_pagination"><?php echo propertya_pagination_search($results); ?></div>
              </div>
         </div>
      <?php } ?>         
      </div>
    </div>
  </div>
</section>