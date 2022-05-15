<div class="<?php echo esc_attr($header_classes); ?>">
    <?php
    //!-- Top bar --
    do_action('nasa_topbar_header');
    
    //!-- Masthead --?>
    <div class="sticky-wrapper">
        <header id="masthead" class="site-header">
            <div class="row">
                <div class="large-12 columns header-container">
                    <!-- Mobile Menu -->
                    <div class="mobile-menu">
                        <?php flozen_mobile_header(); ?>
                    </div>
                </div>
            </div>

            <div class="row nasa-hide-for-mobile">
                <div class="large-12 columns nasa-wrap-event-search">
                    <div class="row nasa-elements-wrap">
                        <!-- Group icon header -->
                        <div class="large-4 columns nasa-min-height">
                            <!-- Search form in header -->
                            <a class="search-icon desk-search" href="javascript:void(0);" data-open="0" title="<?php echo esc_attr__('Search', 'flozen-theme'); ?>">
                                <i class="nasa-icon icon-nasa-if-search"></i>&nbsp;
                                <span class="nasa-label-search"><?php echo esc_html__('Search', 'flozen-theme'); ?></span>
                            </a>
                        </div>

                        <!-- Logo -->
                        <div class="large-4 columns text-center">
                            <div class="logo-wrapper nasa-fullwidth">
                                <?php echo flozen_logo(true); ?>
                            </div>
                        </div>

                        <!-- Group icon header -->
                        <div class="large-4 columns">
                            <?php echo flozen_str($nasa_header_icons); ?>
                        </div>
                    </div>
                    
                    <!-- Search form in header -->
                    <div class="nasa-header-search-wrap">
                        <?php echo flozen_search('icon'); ?>
                    </div>
                </div>
            </div>
            
            <!-- Main menu -->
            <?php if(!$fullwidth_main_menu) : ?>
            <div class="row">
                <div class="large-12 columns">
            <?php endif; ?>
                    <div class="nasa-elements-wrap nasa-elements-wrap-main-menu nasa-hide-for-mobile nasa-bg-dark text-center">
                        <div class="row">
                            <div class="large-12 columns">
                                <div class="wide-nav nasa-wrap-width-main-menu nasa-bg-wrap<?php echo esc_attr($menu_warp_class); ?>">
                                    <div class="nasa-menus-wrapper-reponsive" data-padding_y="<?php echo absint($data_padding_y); ?>" data-padding_x="<?php echo absint($data_padding_x); ?>">
                                        <?php flozen_get_main_menu(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php if(!$fullwidth_main_menu) : ?>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if(isset($show_cat_top_filter) && $show_cat_top_filter) : ?>
                <div class="nasa-top-cat-filter-wrap">
                    <?php echo flozen_get_all_categories(false, true); ?>
                    <a href="javascript:void(0);" title="<?php esc_attr_e('Close categories filter', 'flozen-theme'); ?>" class="nasa-close-filter-cat"><i class="pe-7s-close"></i></a>
                </div>
            <?php endif; ?>
        </header>
    </div>
</div>
