<div class="<?php echo esc_attr($header_classes); ?>">
    <?php //!-- Top bar --
    do_action('nasa_topbar_header', true);
    //!-- End Top bar --
    
    //!-- Masthead --?>
    <div class="sticky-wrapper">
        <header id="masthead" class="site-header">
            <div class="row">
                <div class="large-4 medium-4 small-4 columns mini-icon-mobile elements-wrapper rtl-right rtl-text-right">
                    <a href="javascript:void(0);" class="nasa-icon nasa-mobile-menu_toggle mobile_toggle nasa-mobile-menu-icon pe-7s-menu"></a>
                    <a class="nasa-icon icon pe-7s-search mobile-search" href="javascript:void(0);"></a>
                </div>

                <!-- Logo -->
                <div class="large-4 medium-4 small-4 columns logo-wrapper elements-wrapper rtl-right text-center">
                    <?php echo flozen_logo(true); ?>
                </div>

                <div class="large-4 medium-4 small-4 columns elements-wrapper rtl-left rtl-text-left">
                    <?php
                    /**
                     * product_cat: false
                     * cart: true
                     * compare: false
                     * wishlist: true
                     * search: false
                     */
                    echo flozen_header_icons(false, true, false, true, false); ?>
                </div>
            </div>
            
            <div class="hidden-tag">
                <?php
                flozen_get_main_menu();
                if ($vertical) :
                    flozen_get_vertical_menu();
                endif;
                
                echo flozen_get_all_categories(false, true);
                ?>
            </div>
        </header>
    </div>
</div>
