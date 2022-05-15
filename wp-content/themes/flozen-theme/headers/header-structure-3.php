<?php
$hotline_content = '';
if (isset($nasa_opt['hotline_content']) && $nasa_opt['hotline_content']) {
    $hotline_content = flozen_get_block($nasa_opt['hotline_content']);
}
?>

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
                <div class="large-12 columns">
                    <div class="row">
                        <!-- Hot-line -->
                        <div class="large-4 columns nasa-min-height rtl-right rtl-text-right">
                            <div class="hotline-wrapper nasa-fullwidth">
                                <?php echo flozen_str($hotline_content); ?>
                            </div>
                        </div>
                        
                        <!-- Logo -->
                        <div class="large-4 columns rtl-right text-center">
                            <div class="logo-wrapper nasa-fullwidth">
                                <?php echo flozen_logo(true); ?>
                            </div>
                        </div>
                        
                        <!-- Group icon header -->
                        <div class="large-4 columns rtl-left rtl-text-left">
                            <?php echo flozen_str($nasa_header_icons); ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main menu -->
            <div class="nasa-elements-wrap nasa-elements-wrap-main-menu nasa-hide-for-mobile nasa-elements-wrap-bg nasa-wrap-event-search">
                <div class="row">
                    <div class="large-12 columns">
                        <div class="wide-nav nasa-wrap-width-main-menu nasa-bg-wrap<?php echo esc_attr($menu_warp_class); ?>">
                            <div class="nasa-menus-wrapper-reponsive" data-padding_y="<?php echo absint($data_padding_y); ?>" data-padding_x="<?php echo absint($data_padding_x); ?>">
                                
                                <?php
                                $verticalMenu = flozen_get_vertical_menu(false);
                                if ($verticalMenu) :
                                    echo '<div id="nasa-menu-vertical-header" class="nasa-menu-vertical-header">';
                                    echo flozen_str($verticalMenu);
                                    echo '</div>';
                                endif;
                                ?>
                                
                                <?php flozen_get_main_menu(); ?>
                                
                                <!-- Search form in header -->
                                <a class="search-icon desk-search" href="javascript:void(0);" data-open="0" title="<?php echo esc_attr__('Search', 'flozen-theme'); ?>">
                                    <i class="nasa-icon icon-nasa-if-search"></i>
                                    <span class="nasa-label-search"><?php echo esc_html__('Search', 'flozen-theme'); ?></span>
                                </a>
                                
                                <!-- Search form in header -->
                                <div class="nasa-header-search-wrap nasa-hide-for-mobile">
                                    <?php echo flozen_search('icon'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php if(isset($show_cat_top_filter) && $show_cat_top_filter) : ?>
                <div class="nasa-top-cat-filter-wrap">
                    <?php echo flozen_get_all_categories(false, true); ?>
                    <a href="javascript:void(0);" title="<?php esc_attr_e('Close categories filter', 'flozen-theme'); ?>" class="nasa-close-filter-cat"><i class="pe-7s-close"></i></a>
                </div>
            <?php endif; ?>
        </header>
    </div>
</div>
