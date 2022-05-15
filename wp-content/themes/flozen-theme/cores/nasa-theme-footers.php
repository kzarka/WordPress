<?php

// **********************************************************************// 
// ! Footer Main
// **********************************************************************//
add_action('nasa_get_footer_theme', 'flozen_get_footer_theme');
if (!function_exists('flozen_get_footer_theme')) :
    function flozen_get_footer_theme() {
        global $nasa_opt;

        $file = FLOZEN_CHILD_PATH . '/footers/footer-main.php';
        include_once is_file($file) ? $file : FLOZEN_THEME_PATH . '/footers/footer-main.php';
    }
endif;

// **********************************************************************// 
// ! Footer Type
// **********************************************************************//
add_action('nasa_footer_layout_style', 'flozen_footer_layout_style_function');
if (!function_exists('flozen_footer_layout_style_function')) :
    function flozen_footer_layout_style_function() {
        global $nasa_opt, $wp_query, $nasa_root_term_id;
        
        $inMobile = isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile'] ? true : false;
        
        /**
         * Footer Desktop
         */
        $footer_slug = isset($nasa_opt['footer-type']) && $nasa_opt['footer-type'] != '' ?
            $nasa_opt['footer-type'] : '';
        if ($footer_slug == 'default') {
            $footer_slug = '';
        }
        
        /**
         * Footer Mobile
         */
        if ($inMobile && isset($nasa_opt['footer-mobile'])) {
            $footer_mobile = $nasa_opt['footer-mobile'];
            if ($footer_mobile == 'default') {
                $footer_mobile = $footer_slug;
            }
            
            $footer_slug = $footer_mobile;
        }
        
        $page_id = false;
        $footer_override = false;
        
        /*
         * Override Footer
         */
        $is_product = $is_product_cat = $is_product_taxonomy = $is_shop = false;
        $pageShop = 0;
        if (NASA_WOO_ACTIVED) {
            $is_product = is_product();
            $is_product_cat = is_product_category();
            $is_product_taxonomy = is_product_taxonomy();
            $is_shop = is_shop();

            $pageShop = wc_get_page_id('shop');
        }
        
        if ($is_shop || $is_product_cat || $is_product_taxonomy || $is_product) {
            $term_id = false;

            /**
             * Check Single product
             */
            if ($is_product) {
                if (!$nasa_root_term_id) {
                    $product_cats = get_the_terms($wp_query->get_queried_object_id(), 'product_cat');
                    if ($product_cats) {
                        foreach ($product_cats as $cat) {
                            $term_id = $cat->term_id;
                            break;
                        }
                    }
                } else {
                    $term_id = $nasa_root_term_id;
                }
            }

            /**
             * Check Category product
             */
            elseif ($is_product_cat) {
                $query_obj = $wp_query->get_queried_object();
                $term_id = isset($query_obj->term_id) ? $query_obj->term_id : false;
            }

            if ($term_id) {
                if ($inMobile) {
                    $footer_override = get_term_meta($term_id, 'cat_footer_mobile', true);
                }
                /* Desktop */
                else {
                    $footer_override = get_term_meta($term_id, 'cat_footer_type', true);
                }

                if (!$footer_override) {
                    if ($nasa_root_term_id) {
                        $term_id = $nasa_root_term_id;
                    } else {
                        $ancestors = get_ancestors($term_id, 'product_cat');
                        $term_id = $ancestors ? end($ancestors) : 0;
                        $GLOBALS['nasa_root_term_id'] = $term_id;
                    }
                    
                    if ($term_id) {
                        if ($inMobile) {
                            $footer_override = get_term_meta($term_id, 'cat_footer_mobile', true);
                        }
                        /* Desktop */
                        else {
                            $footer_override = get_term_meta($term_id, 'cat_footer_type', true);
                        }
                    }
                }
            }

            /**
             * Check shop page
             */
            elseif ($pageShop > 0) {
                $page_id = $pageShop;
            }
        }
        
        /**
         * Page
         */
        elseif (!$page_id) {
            $page_id = $wp_query->get_queried_object_id();
        }
        
        /**
         * Switch header structure
         */
        if ($page_id) {
            if ($inMobile) {
                $footer_override = get_post_meta($page_id, '_nasa_custom_footer_mobile', true);
            }
            
            /* Desktop */
            else {
                $footer_override = get_post_meta($page_id, '_nasa_custom_footer', true);
            }
        }
        
        if ($footer_override) {
            $footer_slug = $footer_override;
        }
        
        $args = array(
            'posts_per_page' => 1,
            'post_type' => 'footer',
            'post_status' => 'publish'
        );
        if ($footer_slug) {
            $args['name'] = $footer_slug;
        } else {
            return;
        }
        
        $footers_type = get_posts($args);
        $footer = isset($footers_type[0]) ? $footers_type[0] : null;
        $footer_id = isset($footer->ID) ? (int) $footer->ID : null;
        $footer_pageID = $footer_id;

        if (class_exists('SitePress') && function_exists('icl_object_id') && (int) $footer_id) {
            $footer_langID = icl_object_id($footer_id, 'footer', true);
            if ($footer_langID && $footer_langID != $footer_id) {
                $footerLang = get_post($footer_langID);
                $footer = $footerLang && $footerLang->post_status == 'publish' ? $footerLang : $footer;
                $footer_pageID = $footer_langID;
            }
        }

        /**
         * get_template_part('footers/default');
         */
        if ($footer && isset($footer->post_content)) {
            echo '<footer id="nasa-footer" class="footer-wrapper">';
            
            if ($footer_pageID) {
                $shortcodes_custom_css = get_post_meta($footer_pageID, '_wpb_shortcodes_custom_css', true);
                if (!empty($shortcodes_custom_css)) {
                    $shortcodes_custom_css = strip_tags($shortcodes_custom_css);
                    echo '<style type="text/css" data-type="vc_shortcodes-custom-css">';
                    echo flozen_str($shortcodes_custom_css);
                    echo '</style>';
                }
            }
            
            echo do_shortcode($footer->post_content);
            
            echo '</footer>';
        }
    }
endif;

/**
 * Footer run static content
 */
add_action('wp_footer', 'flozen_run_static_content', 9);
if (!function_exists('flozen_run_static_content')) :
    function flozen_run_static_content() {
        do_action('nasa_before_static_content');
        do_action('nasa_static_content');
        do_action('nasa_after_static_content');
    }
endif;

// **********************************************************************// 
// flozen_static_content_before
// **********************************************************************//
add_action('nasa_static_content', 'flozen_static_content_before', 10);
if (!function_exists('flozen_static_content_before')) :
    function flozen_static_content_before() {
        echo '<a href="javascript:void(0);" id="nasa-back-to-top" data-wow="fadeIn" class="wow fadeIn hidden-tag"><i class="pe-7s-angle-up"></i></a>';
        
        echo '<!-- Start static content -->' .
            '<div class="static-position vendor_hidden">' .
                '<div class="nasa-check-reponsive nasa-desktop-check"></div>' .
                '<div class="nasa-check-reponsive nasa-taplet-check"></div>' .
                '<div class="nasa-check-reponsive nasa-mobile-check"></div>' .
                '<div class="nasa-check-reponsive nasa-switch-check"></div>' .
                '<div class="black-window hidden-tag"></div>' .
                '<div class="white-window hidden-tag"></div>' .
                '<div class="transparent-window hidden-tag"></div>' .
                '<div class="transparent-mobile hidden-tag"></div>' .
                '<div class="black-window-mobile"></div>';
    }
endif;

// **********************************************************************// 
// flozen_static_content_after
// **********************************************************************//
add_action('nasa_static_content', 'flozen_static_content_after', 999);
if (!function_exists('flozen_static_content_after')) :
    function flozen_static_content_after() {
        echo '</div><!-- End static content -->';
    }
endif;

// **********************************************************************// 
// flozen_static_for_mobile
// **********************************************************************//
add_action('nasa_static_content', 'flozen_static_for_mobile', 12);
if (!function_exists('flozen_static_for_mobile')) :

    function flozen_static_for_mobile() {
        global $nasa_opt;
        ?>
        <div class="warpper-mobile-search">
            <!-- for mobile -->
            <?php
            $search_form_file = FLOZEN_CHILD_PATH . '/includes/nasa-mobile-product-searchform.php';
            include is_file($search_form_file) ? $search_form_file : FLOZEN_THEME_PATH . '/includes/nasa-mobile-product-searchform.php';
            ?>
        </div>

        <div id="heading-menu-mobile" class="hidden-tag">
            <i class="fa fa-bars"></i><?php esc_html_e('Navigation','flozen-theme'); ?>
        </div>
        
        <?php if (!isset($nasa_opt['hide_tini_menu_acc']) || !$nasa_opt['hide_tini_menu_acc']) : ?>
            <div id="mobile-account" class="hidden-tag">
                <?php
                $mobile_acc_file = FLOZEN_CHILD_PATH . '/includes/nasa-mobile-account.php';
                include is_file($mobile_acc_file) ? $mobile_acc_file : FLOZEN_THEME_PATH . '/includes/nasa-mobile-account.php'; ?>
            </div>
        <?php endif;
    }

endif;

// **********************************************************************// 
// flozen_static_cart_sidebar
// **********************************************************************//
add_action('nasa_static_content', 'flozen_static_cart_sidebar', 13);
if (!function_exists('flozen_static_cart_sidebar')) :

    function flozen_static_cart_sidebar() {
        global $nasa_opt;
        if (!NASA_WOO_ACTIVED || (isset($nasa_opt['disable-cart']) && $nasa_opt['disable-cart'])) {
            return;
        }
        
        $nasa_cart_style = isset($nasa_opt['style-cart']) ? esc_attr($nasa_opt['style-cart']) : 'style-1'; ?>
        <div id="cart-sidebar" class="nasa-static-sidebar <?php echo esc_attr($nasa_cart_style); ?>">
            <div class="cart-close nasa-sidebar-close">
                <h3 class="nasa-tit-mycart nasa-sidebar-tit text-center"><?php echo esc_html__('My Cart', 'flozen-theme'); ?></h3>
                <a href="javascript:void(0);" title="<?php esc_attr_e('Close', 'flozen-theme'); ?>"><?php esc_html_e('Close','flozen-theme'); ?></a>
            </div>

            <div class="widget_shopping_cart_content">
                <input type="hidden" name="nasa-mini-cart-empty-content" />
            </div>
            
            <?php if (isset($_REQUEST['nasa_cart_sidebar']) && $_REQUEST['nasa_cart_sidebar'] == 1) : ?>
                <input type="hidden" name="nasa_cart_sidebar_show" value="1" />
            <?php endif; ?>
        </div>
        <?php
    }

endif;

// **********************************************************************// 
// flozen_static_wishlist_sidebar
// **********************************************************************//
add_action('nasa_static_content', 'flozen_static_wishlist_sidebar', 14);
if (!function_exists('flozen_static_wishlist_sidebar')) :

    function flozen_static_wishlist_sidebar() {
        if (!NASA_WOO_ACTIVED) {
            return;
        }
        
        global $nasa_opt;
        
        if (NASA_WISHLIST_ENABLE) {
            echo '<input type="hidden" name="nasa_yith_wishlist_actived" value="1" />';
        }
        
        if (!NASA_WISHLIST_ENABLE) {
            if (isset($nasa_opt['enable_nasa_wishlist']) && !$nasa_opt['enable_nasa_wishlist']) {
                return;
            }
            
            $nasa_wishlist = function_exists('flozen_woo_wishlist') ? flozen_woo_wishlist() : null;
            if ($nasa_wishlist) {
                echo '<input type="hidden" name="nasa_wishlist_cookie_name" value="' . $nasa_wishlist->get_cookie_name() . '" />';
            }
        }
        
        global $nasa_opt;
        $nasa_wishlist_style = isset($nasa_opt['style-wishlist']) ? esc_attr($nasa_opt['style-wishlist']) : 'style-1'; ?>
        <div id="nasa-wishlist-sidebar" class="nasa-static-sidebar <?php echo esc_attr($nasa_wishlist_style); ?>">
            <div class="wishlist-close nasa-sidebar-close">
                <a href="javascript:void(0);" title="<?php esc_attr_e('Close', 'flozen-theme'); ?>"><?php esc_html_e('Close', 'flozen-theme'); ?></a>
            </div>
            
            <?php echo flozen_loader_html('nasa-wishlist-sidebar-content'); ?>
        </div>
        <?php
    }

endif;

// **********************************************************************// 
// flozen_static_login_register
// **********************************************************************//
add_action('nasa_static_content', 'flozen_static_login_register', 16);
if (!function_exists('flozen_static_login_register')) :

    function flozen_static_login_register() {
        global $nasa_opt;
        
        if (!NASA_CORE_USER_LOGGED && shortcode_exists('woocommerce_my_account') && (!isset($nasa_opt['login_ajax']) || $nasa_opt['login_ajax'] == 1)) : ?>
            <div class="nasa-login-register-warper">
                <div id="nasa-login-register-form">
                    <div class="nasa-form-logo-log nasa-no-fix-size-retina">
                        <?php echo flozen_logo(); ?>
                    </div>

                    <div class="login-register-close">
                        <a class="login-register-close" href="javascript:void(0);" title="<?php esc_attr_e('Close', 'flozen-theme'); ?>"><i class="pe-7s-angle-up"></i></a>
                    </div>
                    <div class="nasa-message margin-top-20"></div>
                    <div class="nasa-form-content">
                        <?php do_action('nasa_login_register_form', true); ?>
                    </div>
                </div>
            </div>
        <?php
        endif;
    }

endif;

// **********************************************************************// 
// flozen_static_quick_sidebar
// **********************************************************************//
add_action('nasa_static_content', 'flozen_static_quickview_sidebar', 16);
if (!function_exists('flozen_static_quickview_sidebar')) :

    function flozen_static_quickview_sidebar() {
        global $nasa_opt;
        if ((isset($nasa_opt['style_quickview']) && $nasa_opt['style_quickview'] == 'sidebar') || (isset($_REQUEST['quickview']) && $_REQUEST['quickview'] == 'sidebar')) : ?>
        <div id="nasa-quickview-sidebar" class="nasa-static-sidebar style-1">
            <div class="nasa-quickview-fog hidden-tag"></div>
            <div class="quickview-close nasa-sidebar-close hidden-tag">
                <h3 class="nasa-tit-quickview"><?php echo esc_html__('Quickview', 'flozen-theme'); ?></h3>
                <a href="javascript:void(0);" title="<?php esc_attr_e('Close', 'flozen-theme'); ?>"><?php esc_html_e('Close', 'flozen-theme'); ?></a>
            </div>
            
            <?php echo flozen_loader_html('nasa-quickview-sidebar-content', false); ?>
        </div>
        <?php
        endif;
    }

endif;

// **********************************************************************// 
// flozen_static_compare_sidebar
// **********************************************************************//
add_action('nasa_static_content', 'flozen_static_compare_sidebar', 17);
if (!function_exists('flozen_static_compare_sidebar')) :

    function flozen_static_compare_sidebar() {
        global $yith_woocompare;
        
        if ($yith_woocompare) {
            $nasa_compare = isset($yith_woocompare->obj) ?
                $yith_woocompare->obj : $yith_woocompare;
            
            if (isset($nasa_compare->cookie_name)) {
                echo '<input type="hidden" name="nasa_woocompare_cookie_name" value="' . $nasa_compare->cookie_name . '" />';
            }
        }
        ?>
        <div class="nasa-compare-list-bottom">
            <div id="nasa-compare-sidebar-content" class="nasa-relative">
                <div class="nasa-loader"></div>
            </div>
            <p class="nasa-compare-mess nasa-compare-success hidden-tag"></p>
            <p class="nasa-compare-mess nasa-compare-exists hidden-tag"></p>
        </div>
        <?php
    }

endif;

// **********************************************************************// 
// flozen_static_menu_vertical_mobile
// **********************************************************************//
add_action('nasa_static_content', 'flozen_static_menu_vertical_mobile', 19);
if (!function_exists('flozen_static_menu_vertical_mobile')) :

    function flozen_static_menu_vertical_mobile() {
        global $nasa_opt;
        
        $class = isset($nasa_opt['mobile_menu_layout']) ? 
            'nasa-' . $nasa_opt['mobile_menu_layout'] : 'nasa-light-new';
        ?>
        <div id="nasa-menu-sidebar-content" class="<?php echo esc_attr($class); ?>">
            <div class="nasa-mobile-nav-wrap">
                <div id="mobile-navigation"></div>
            </div>
        </div>
        <?php
    }

endif;

// **********************************************************************// 
// Top Categories filter
// **********************************************************************//
add_action('nasa_static_content', 'flozen_static_top_cat_filter', 20);
if (!function_exists('flozen_static_top_cat_filter')) :

    function flozen_static_top_cat_filter() {
        ?>
        <div class="nasa-top-cat-filter-wrap-mobile nasa-light">
            <h3 class="nasa-tit-filter-cat"><?php echo esc_html__("Categories", 'flozen-theme'); ?></h3>
            
            <div id="nasa-mobile-cat-filter">
                <div class="nasa-loader"></div>
            </div>
            
            <a href="javascript:void(0);" title="<?php esc_attr_e('Close categories filter', 'flozen-theme'); ?>" class="nasa-close-filter-cat"><i class="pe-7s-close"></i></a>
        </div>
        <?php
    }

endif;

// **********************************************************************// 
// flozen_static_config_info
// **********************************************************************//
add_action('nasa_static_content', 'flozen_static_config_info', 21);
if (!function_exists('flozen_static_config_info')) :

    function flozen_static_config_info() {
        global $nasa_opt, $loadmoreStyle;
        
        $inMobile = isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile'] ? true : false;
        
        if (isset($nasa_opt['pagination_style']) && in_array($nasa_opt['pagination_style'], $loadmoreStyle)) {
            echo '<input type="hidden" name="nasa_loadmore_style" value="' . $nasa_opt['pagination_style'] . '" />';
        }
        
        /**
         * Sticky add to cart in Desktop
         */
        if (isset($nasa_opt['enable_fixed_add_to_cart']) && $nasa_opt['enable_fixed_add_to_cart']) {
            echo '<!-- Enable Fixed add to cart single product -->';
            echo '<input type="hidden" name="nasa_fixed_single_add_to_cart" value="1" />';
        }
        
        /**
         * Sticky add to cart in mobile
         */
        if (!isset($nasa_opt['mobile_fixed_add_to_cart'])) {
            $nasa_opt['mobile_fixed_add_to_cart'] = 'no';
        }
        echo '<!-- Fixed add to cart single product in Mobile layout -->';
        echo '<input type="hidden" name="nasa_fixed_mobile_single_add_to_cart_layout" value="' . esc_attr($nasa_opt['mobile_fixed_add_to_cart']) . '" />';
        
        /**
         * Mobile Detect
         */
        if ($inMobile) {
            echo '<!-- In Mobile -->';
            echo '<input type="hidden" name="nasa_mobile_layout" value="1" />';
        }
        
        /**
         * Pop-up After add to cart
         */
        if (!$inMobile && isset($nasa_opt['after-add-to-cart']) && $nasa_opt['after-add-to-cart']) {
            echo '<!-- Show popup after Add To Cart -->';
            echo '<input type="hidden" name="nasa-after-add-to-cart" value="1" />';
        }
        ?>
        
        <input type="hidden" name="nasa_currency_pos" value="<?php echo get_option('woocommerce_currency_pos'); ?>" />
        <input type="hidden" name="nasa_logout_menu" value="<?php echo wp_logout_url(get_home_url()); ?>" />

        <!-- Enable countdown -->
        <input type="hidden" name="nasa-count-down-enable" value="1" />
        
        <!-- width toggle Add To Cart | Quick View -->
        <input type="hidden" name="nasa-toggle-width-add-to-cart" value="<?php echo apply_filters('nasa_toggle_width_add_to_cart', 100); ?>" />

        <!-- Enable WOW -->
        <input type="hidden" name="nasa-enable-wow" value="<?php echo (!isset($nasa_opt['disable_wow']) || !$nasa_opt['disable_wow']) ? '1' : '0'; ?>" />

        <!-- Enable Portfolio -->
        <input type="hidden" name="nasa-enable-portfolio" value="<?php echo (isset($nasa_opt['enable_portfolio']) && $nasa_opt['enable_portfolio'] == 1) ? '1' : '0'; ?>" />

        <!-- Enable gift effect -->
        <input type="hidden" name="nasa-enable-gift-effect" value="<?php echo (isset($nasa_opt['enable_gift_effect']) && $nasa_opt['enable_gift_effect'] == 1) ? '1' : '0'; ?>" />
        
        <!-- Enable focus main image -->
        <input type="hidden" name="nasa-enable-focus-main-image" value="<?php echo (isset($nasa_opt['enable_focus_main_image']) && $nasa_opt['enable_focus_main_image'] == 1) ? '1' : '0'; ?>" />
        
        <!-- Select option to quickview -->
        <input type="hidden" name="nasa-disable-quickview-ux" value="<?php echo (isset($nasa_opt['disable-quickview']) && $nasa_opt['disable-quickview'] == 1) ? '1' : '0'; ?>" />
        
        <!-- Close popup string -->
        <input type="hidden" name="nasa-close-string" value="<?php echo esc_attr__('Close (Esc)', 'flozen-theme'); ?>" />

        <p class="hidden-tag" id="nasa-empty-result-search"><?php esc_html_e('Sorry. No results match your search.', 'flozen-theme'); ?></p>
        
        <!-- Less Total Count items Wishlist - Compare - (9+) -->
        <input type="hidden" name="nasa_less_total_items" value="<?php echo apply_filters('nasa_less_total_items', '1'); ?>" />

        <?php
        $shop_url   = NASA_WOO_ACTIVED ? wc_get_page_permalink('shop') : '';
        $base_url   = home_url('/');
        $friendly   = preg_match('/\?post_type\=/', $shop_url) ? '0' : '1';
        if (preg_match('/\?page_id\=/', $shop_url)){
            $friendly = '0';
            $shop_url = $base_url . '?post_type=product';
        }
        
        echo '<input type="hidden" name="nasa-shop-page-url" value="' . esc_url($shop_url) . '" />';
        echo '<input type="hidden" name="nasa-base-url" value="' . esc_url($base_url) . '" />';
        echo '<input type="hidden" name="nasa-friendly-url" value="' . esc_attr($friendly) . '" />';
        
        if (defined('NASA_PLG_CACHE_ACTIVE') && NASA_PLG_CACHE_ACTIVE) :
            echo '<input type="hidden" name="nasa-caching-enable" value="1" />';
        endif;
        
        if (isset($_GET) && !empty($_GET)) {
            echo '<div class="hidden-tag nasa-value-gets">';
            foreach ($_GET as $key => $value) {
                if (!in_array($key, array('add-to-cart'))) {
                    echo '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
                }
            }
            echo '</div>';
        }
    }

endif;

/**
 * Bottom Bar menu
 */
add_action('nasa_static_content', 'flozen_bottom_bar_menu', 22);
if (!function_exists('flozen_bottom_bar_menu')):
    function flozen_bottom_bar_menu() {
        global $nasa_opt;
        
        if (isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile']) {
            $file = FLOZEN_CHILD_PATH . '/includes/nasa-mobile-bottom-bar.php';
            include is_file($file) ? $file : FLOZEN_THEME_PATH . '/includes/nasa-mobile-bottom-bar.php';
        }
    }
endif;

/**
 * Global wishlist template
 */
add_action('nasa_static_content', 'flozen_global_wishlist', 25);
if (!function_exists('flozen_global_wishlist')):
    function flozen_global_wishlist() {
        global $nasa_opt;
        
        if (NASA_WISHLIST_ENABLE && 
            (!isset($nasa_opt['optimize_wishlist_html']) || $nasa_opt['optimize_wishlist_html'])
        ) {
            $file = FLOZEN_CHILD_PATH . '/includes/nasa-global-wishlist.php';
            include is_file($file) ? $file : FLOZEN_THEME_PATH . '/includes/nasa-global-wishlist.php';
        }
    }
endif;

/**
 * GDPR Message
 */
add_action('nasa_static_content', 'flozen_gdpr_notice', 30);
if (!function_exists('flozen_gdpr_notice')) :
    function flozen_gdpr_notice() {
        global $nasa_opt;
        
        if (!isset($nasa_opt['nasa_gdpr_notice']) || !$nasa_opt['nasa_gdpr_notice'])  {
            return;
        }

        $enable = !isset($_COOKIE['nasa_gdpr_notice']) || !$_COOKIE['nasa_gdpr_notice'] ? true : false;
        if (!$enable) {
            return;
        }
        
        $file = FLOZEN_CHILD_PATH . '/includes/nasa-gdpr-notice.php';
        include is_file($file) ? $file : FLOZEN_THEME_PATH . '/includes/nasa-gdpr-notice.php';
    }
endif;

/**
 * Template variation for quick-view product variable
 */
add_action('nasa_after_static_content', 'flozen_script_template_variation_quickview');
if (!function_exists('flozen_script_template_variation_quickview')) :
    function flozen_script_template_variation_quickview() {
        global $nasa_opt;
        
        if (isset($nasa_opt['disable-quickview']) && $nasa_opt['disable-quickview']) {
            return;
        }
        echo 
        '<script type="text/template" id="tmpl-variation-template-nasa">' .
            '<div class="woocommerce-variation-description">{{{data.variation.variation_description}}}</div>' .
            '<div class="woocommerce-variation-price">{{{data.variation.price_html}}}</div>' .

            '<div class="hidden-tag nasa-quickview-product-countdown bg-single-product-gray margin-right-10 rtl-margin-right-0 rtl-margin-left-10"><table class="margin-bottom-0"><tr><td class="nasa-single-label"><span class="nasa-bold">' . esc_html__('Expires Times', 'flozen-theme') . '</span></td><td class="nasa-single-content">' .
                
                '<div class="nasa-quickview-product-deal-countdown nasa-product-variation-countdown"></div>' .
                
            '</td></tr></table></div>' .

            '<div class="woocommerce-variation-availability bg-single-product-gray margin-right-10 rtl-margin-right-0 rtl-margin-left-10">{{{data.variation.availability_html}}}</div>' .
        '</script>' .
        '<script type="text/template" id="tmpl-unavailable-variation-template-nasa">' .
            '<p>' . esc_html__('Sorry, this product is unavailable. Please choose a different combination.', 'flozen-theme') . '</p>' .
        '</script>';
    }
endif;
