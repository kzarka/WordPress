<?php
/* ============================================================================ */
/* Remove - Add action, filter WooCommerce ==================================== */
/* ============================================================================ */

/**
 * Disable default Yith Woo wishlist button
 */
if (NASA_WISHLIST_ENABLE && function_exists('YITH_WCWL_Frontend')) {
    remove_action('init', array(YITH_WCWL_Frontend(), 'add_button'));
}

/*
 * Remove action woocommerce
 */
add_action('init', 'flozen_remove_action_woo');
if (!function_exists('flozen_remove_action_woo')) :
    function flozen_remove_action_woo() {
        if (!NASA_WOO_ACTIVED) {
            return;
        }
        
        global $nasa_opt, $yith_woocompare;
        
        /* UNREGISTRER DEFAULT WOOCOMMERCE HOOKS */
        remove_action('woocommerce_single_product_summary', 'woocommerce_breadcrumb', 20);
        remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
        remove_action('woocommerce_before_shop_loop', 'woocommerce_show_messages', 10);
        remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
        
        remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
        remove_action('woocommerce_before_single_product', 'woocommerce_output_all_notices', 10);
        
        remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
        
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
        
        if (isset($nasa_opt['disable-cart']) && $nasa_opt['disable-cart']) {
            remove_action('woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30);
            remove_action('woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30);
            remove_action('woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30);
        }
        
        // Remove compare default
        if ($yith_woocompare) {
            $nasa_compare = isset($yith_woocompare->obj) ? $yith_woocompare->obj : $yith_woocompare;
            remove_action('woocommerce_after_shop_loop_item', array($nasa_compare, 'add_compare_link'), 20);
            remove_action('woocommerce_single_product_summary', array($nasa_compare, 'add_compare_link'), 35);
        }
        
        /**
         * For content-product
         */
        remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
        remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail');
        remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title');
        
        /**
         * Shop page
         */
        remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
        remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

        remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
        remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
        
        /**
         * Sale-Flash
         */
        remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
        remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
        
        /**
         * Mini Cart
         */
        remove_action('woocommerce_widget_shopping_cart_total', 'woocommerce_widget_shopping_cart_subtotal', 10);
        
        /**
         * Remove wishlist btn in detail product
         */
        // if (NASA_WISHLIST_ENABLE) {
        //     add_filter('yith_wcwl_positions', 'flozen_remove_btn_wishlist_single_product');
        // }
        
        /**
         * For New version Yith Wishlist 3.0 or Higher
         */
        // if (NASA_WISHLIST_NEW_VER) {
        //     add_filter('yith_wcwl_loop_positions', 'flozen_remove_default_wishlist_button');
        // }
    }
endif;

/*
 * Add action woocommerce
 */
add_action('init', 'flozen_add_action_woo');
if (!function_exists('flozen_add_action_woo')) :
    function flozen_add_action_woo() {
        if (!NASA_WOO_ACTIVED) {
            return;
        }
        
        global $nasa_opt, $yith_woocompare, $loadmoreStyle;
        
        // add_action('nasa_root_cats', 'flozen_get_root_categories');
        add_action('nasa_child_cat', 'flozen_get_childs_category', 10, 2);
        
        // Results count in shop page
        $ajax_shop = true;
        if (
            (!isset($nasa_opt['shop_ajax_product']) || !$nasa_opt['shop_ajax_product']) ||
            get_option('woocommerce_shop_page_display', '') != '' || 
            get_option('woocommerce_category_archive_display', '') != ''
        ) :
            $ajax_shop = false;
        endif;
        
        $pagination_style = isset($nasa_opt['pagination_style']) ? $nasa_opt['pagination_style'] : 'style-2';
        
        if (!$ajax_shop) :
            $pagination_style = $pagination_style == 'style-2' ? 'style-2' : 'style-1';
        endif;
        
        if (in_array($pagination_style, $loadmoreStyle)) {
            add_action('nasa_shop_category_count', 'flozen_result_count', 20);
        } else {
            add_action('nasa_shop_category_count', 'woocommerce_result_count', 20);
        }
        
        add_action('nasa_change_view', 'flozen_nasa_change_view', 10, 3);
        
        add_action('woocommerce_archive_description', 'flozen_before_archive_description', 1);
        add_action('woocommerce_archive_description', 'flozen_get_cat_top', 5);
        add_action('woocommerce_archive_description', 'flozen_after_archive_description', 999);
        
        add_action('woocommerce_after_shop_loop', 'flozen_get_cat_bottom', 1000);

        add_action('woocommerce_after_cart', 'woocommerce_cross_sell_display');
        add_action('nasa_popup_woocommerce_after_cart', 'woocommerce_cross_sell_display');
        
        add_action('woocommerce_single_product_lightbox_summary', 'woocommerce_template_loop_rating', 10);
        add_action('woocommerce_single_product_lightbox_summary', 'woocommerce_template_single_price', 15);
        add_action('woocommerce_single_product_lightbox_summary', 'woocommerce_template_single_excerpt', 20);
        
        // Deal time for Quickview product
        if (!isset($nasa_opt['single-product-deal']) || $nasa_opt['single-product-deal']) {
            add_action('woocommerce_single_product_lightbox_summary', 'flozen_deal_time_quickview', 29);
        }
        
        if (!isset($nasa_opt['disable-cart']) || !$nasa_opt['disable-cart']) {
            add_action('woocommerce_single_product_lightbox_summary', 'woocommerce_template_single_add_to_cart', 30);
        }
        
        add_action('woocommerce_single_product_lightbox_summary', 'woocommerce_template_single_meta', 40);
        add_action('woocommerce_single_product_lightbox_summary', 'flozen_combo_in_quickview', 31);
        
        add_action('woocommerce_single_product_lightbox_summary', 'woocommerce_template_single_sharing', 50);
        
        add_action('nasa_single_product_layout', 'flozen_single_product_layout', 1);
        
        /**
         * Sale flash in Single
         */
        add_action('woocommerce_before_single_product_summary', 'flozen_add_custom_sale_flash', 11);
        
        add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
        add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 20);
        add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 25);
        
        // Deal time for Single product
        if (!isset($nasa_opt['single-product-deal']) || $nasa_opt['single-product-deal']) {
            add_action('woocommerce_single_product_summary', 'flozen_deal_time_single', 29);
        }
        
        /**
         * Add to wishlist in detail
         */
        add_action('woocommerce_single_product_summary', 'flozen_add_wishlist_compare_in_detail', 35);
        
        add_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 40);
        
        /**
         * add_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 1);
         */
        add_action('woocommerce_after_single_product_summary', 'woocommerce_template_single_meta', 11);
        
        /**
         * Add compare product
         */
        if ($yith_woocompare) {
            if (get_option('yith_woocompare_compare_button_in_products_list') == 'yes') {
                add_action('nasa_show_buttons_loop', 'flozen_add_compare_in_list', 50);
            }
        }
        
        add_action('nasa_show_buttons_loop', 'flozen_before_wrap', 10);
        add_action('nasa_show_buttons_loop', 'flozen_add_to_cart_btn', 10);
        if (!isset($nasa_opt['disable-quickview']) || !$nasa_opt['disable-quickview']) {
            add_action('nasa_show_buttons_loop', 'flozen_quickview_in_list', 20, 0);
        }
        add_action('nasa_show_buttons_loop', 'flozen_after_wrap', 30);
        
        add_action('nasa_show_buttons_loop', 'flozen_add_wishlist_in_list', 40);
        add_action('nasa_show_buttons_loop', 'flozen_bundle_in_list', 60, 1);
        
        /**
         * Notice in Archive Products Page | Single Product Page
         */
        add_action('woocommerce_before_main_content', 'woocommerce_output_all_notices', 10);
        
        // Nasa ADD BUTTON BUY NOW
        add_action('woocommerce_after_add_to_cart_button', 'flozen_add_buy_now_btn');
        
        // Nasa Add Custom fields
        add_action('woocommerce_after_add_to_cart_button', 'flozen_add_custom_field_detail_product', 25);
        
        // nasa_top_sidebar_shop
        add_action('nasa_top_sidebar_shop', 'flozen_top_sidebar_shop', 10, 1);
        add_action('nasa_sidebar_shop', 'flozen_side_sidebar_shop', 10 , 1);
        
        // for woo 3.3
        if (version_compare(WC()->version, '3.3.0', ">=")) {
            if (!isset($nasa_opt['show_uncategorized']) || !$nasa_opt['show_uncategorized']) {
                add_filter('woocommerce_product_subcategories_args', 'flozen_hide_uncategorized');
            }
        }
        
        /**
         * Share icon in Detail
         */
        add_action('woocommerce_share', 'flozen_before_woocommerce_share', 5);
        add_action('woocommerce_share', 'flozen_woocommerce_share', 10);
        add_action('woocommerce_share', 'flozen_after_woocommerce_share', 15);
        
        /**
         * Add src image large for variation
         */
        add_filter('woocommerce_available_variation', 'flozen_src_large_image_single_product');
        
        /**
         * Add class Sub Categories
         */
        add_filter('product_cat_class', 'flozen_add_class_sub_categories');
        
        /**
         * Filter redirect checkout buy now
         */
        add_filter('woocommerce_add_to_cart_redirect', 'flozen_buy_now_to_checkout');
        
        /**
         * Filter Single Stock
         */
        if (!isset($nasa_opt['enable_progess_stock']) || $nasa_opt['enable_progess_stock']) {
            add_filter('woocommerce_get_stock_html', 'flozen_single_stock', 10, 2);
        }
        
        /**
         * Mini Cart
         */
        add_action('woocommerce_widget_shopping_cart_total', 'flozen_widget_shopping_cart_subtotal', 10);
        
        /**
         * Disable redirect Search one product to single product
         */
        add_filter('woocommerce_redirect_single_search_result', '__return_false');
        
        /**
         * Support Yith WooCommerce Product Add-ons in Quick view
         */
        if (class_exists('YITH_WAPO')) {
            $yith_wapo = YITH_WAPO::instance();
            $yith_wapo_frontend = $yith_wapo->frontend;
            add_action('woocommerce_single_product_lightbox_summary', array($yith_wapo_frontend, 'check_variable_product'));
        }
    }
endif;
/* ========================================================================== */
/* END Remove - Add action, filter WooCommerce ============================== */
/* ========================================================================== */

/*
 * Add action woocommerce loop product
 */
add_action('init', 'flozen_add_action_woo_loop_product');
if (!function_exists('flozen_add_action_woo_loop_product')) :
    function flozen_add_action_woo_loop_product() {
        if (!NASA_WOO_ACTIVED) {
            return;
        }
        
        global $nasa_opt, $yith_woocompare;
        
        // For Product content
        add_action('nasa_get_content_products', 'flozen_get_content_products', 10, 1);
        
        add_action('woocommerce_before_shop_loop_item_title', 'flozen_open_before_shop_loop_item_title', 1);
        add_action('woocommerce_before_shop_loop_item_title', 'flozen_loop_product_content_thumbnail', 10);
        
        /**
         * Sale flash in grid
         */
        add_action('woocommerce_before_shop_loop_item_title', 'flozen_add_custom_sale_flash', 11);
        add_action('woocommerce_before_shop_loop_item_title', 'flozen_gift_featured', 20);
        
        /**
         * Time sale
         */
        add_action('woocommerce_before_shop_loop_item_title', 'flozen_loop_item_product_time_sale', 95);
        add_action('woocommerce_before_shop_loop_item_title', 'flozen_close_before_shop_loop_item_title', 100);
        
        add_action('woocommerce_shop_loop_item_title', 'flozen_open_shop_loop_item_title', 1);
        add_action('woocommerce_shop_loop_item_title', 'flozen_custom_content_nasa_core', 5);
        add_action('woocommerce_shop_loop_item_title', 'flozen_loop_product_cats');
        add_action('woocommerce_shop_loop_item_title', 'flozen_loop_product_content_title');
        add_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_rating');
        add_action('woocommerce_shop_loop_item_title', 'flozen_loop_product_price');
        add_action('woocommerce_shop_loop_item_title', 'flozen_loop_product_description', 15);
        add_action('woocommerce_shop_loop_item_title', 'flozen_close_shop_loop_item_title', 100);
        
        
        add_action('woocommerce_after_shop_loop_item_title', 'flozen_clear_box_shadow', 15);
        
        $style_item = isset($nasa_opt['loop_product_layout']) && $nasa_opt['loop_product_layout'] ? $nasa_opt['loop_product_layout'] : 'style-1';
        
        /**
         * Wishlist | Compare
         */
        if ($style_item == 'style-2') {
            add_action('woocommerce_after_shop_loop_item_title', 'flozen_open_wrap_btns', 20);
            add_action('woocommerce_after_shop_loop_item_title', 'flozen_add_wishlist_in_list', 30);

            if ($yith_woocompare && get_option('yith_woocompare_compare_button_in_products_list') == 'yes') {
                add_action('woocommerce_after_shop_loop_item_title', 'flozen_add_compare_in_list', 40);
            }

            if (isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile']) {
                add_action('woocommerce_after_shop_loop_item_title', 'flozen_quickview_in_list', 50, 0);
                add_action('woocommerce_after_shop_loop_item_title', 'flozen_add_to_cart_in_list', 60);
            }

            add_action('woocommerce_after_shop_loop_item_title', 'flozen_close_wrap_btns', 90);
        }
        
        /**
         * Part Hover show
         */
        add_action('woocommerce_after_shop_loop_item_title', 'flozen_open_wrap_more_hover', 100);
        
        if (!isset($nasa_opt['nasa_in_mobile']) || !$nasa_opt['nasa_in_mobile']) {
            switch ($style_item) {
                case 'style-2':
                    add_action('woocommerce_after_shop_loop_item_title', 'flozen_open_wrap_btns_noop', 110);
                    add_action('woocommerce_after_shop_loop_item_title', 'flozen_add_to_cart_in_list', 115);
                    add_action('woocommerce_after_shop_loop_item_title', 'flozen_quickview_in_list', 120, 0);
                    add_action('woocommerce_after_shop_loop_item_title', 'flozen_close_wrap_btns_noop', 200);
                    break;
                
                default :
                    flozen_add_group_btns_default();
                    break;
            }
            
        } else {
            if ($style_item == 'style-1') {
                flozen_add_group_btns_default();
            }
        }
        
        add_action('woocommerce_after_shop_loop_item_title', 'flozen_close_wrap_more_hover', 1000);
        
        /**
         * Custom filters woocommerce_post_class
         */
        add_filter('woocommerce_post_class', 'flozen_custom_woocommerce_post_class');
    }
endif;

if (!function_exists('flozen_add_group_btns_default')) :
    function flozen_add_group_btns_default() {
        /**
         * Open wrap buttons
         */
        add_action('woocommerce_before_shop_loop_item_title', 'flozen_open_wrap_btns_noop');

        /**
         * Buttons Add to cart
         */
        add_action('woocommerce_before_shop_loop_item_title', 'flozen_add_to_cart_in_list');

        /**
         * Buttons Wishlist
         */
        add_action('woocommerce_before_shop_loop_item_title', 'flozen_add_wishlist_in_list');

        /**
         * Buttons Quick view
         */
        add_action('woocommerce_before_shop_loop_item_title', 'flozen_quickview_in_list', 10, 0);

        /**
         * Buttons Compare
         */
        add_action('woocommerce_before_shop_loop_item_title', 'flozen_add_compare_in_list');

        /**
         * Close wrap buttons
         */
        add_action('woocommerce_before_shop_loop_item_title', 'flozen_close_wrap_btns_noop');
    }
endif;

/**
 * Custom woocommerce_post_class
 */
if (!function_exists('flozen_custom_woocommerce_post_class')) :
    function flozen_custom_woocommerce_post_class($classes) {
        global $nasa_opt, $product, $nasa_animated_products;
        
        $classes[] = 'product-item grid nasa-default-template';
        
        $classes[] = isset($nasa_opt['loop_product_layout']) && $nasa_opt['loop_product_layout'] ? $nasa_opt['loop_product_layout'] : 'style-1';
        
        if (!isset($nasa_opt['nasa_in_mobile']) || !$nasa_opt['nasa_in_mobile']) {
            $classes[] = 'wow fadeInUp';
        }
        
        if ($nasa_animated_products) {
            $classes[] = $nasa_animated_products;
        }
        
        if ("outofstock" == $product->get_stock_status()) {
            'out-of-stock';
        }
        
        if (!isset($nasa_opt['text_center_product']) || $nasa_opt['text_center_product']) {
            $classes[] = 'nasa-product-text-center';
        }
        
        return $classes;
    }
endif;

/**
 * product content open wrap more hover
 */
if (!function_exists('flozen_open_wrap_more_hover')) :
    function flozen_open_wrap_more_hover() {
        echo '<div class="nasa-product-more-hover"><div class="nasa-product-more-wrap-hover">';
    }
endif;

/**
 * product content close wrap more hover
 */
if (!function_exists('flozen_close_wrap_more_hover')) :
    function flozen_close_wrap_more_hover() {
        echo '</div></div>';
    }
endif;

/**
 * product content open wrap buttons Add To Cart | Quick view
 */
if (!function_exists('flozen_open_wrap_btns_noop')) :
    function flozen_open_wrap_btns_noop() {
        echo '<div class="nasa-product-grid nasa-btns-product-item"><div class="product-interactions">';
    }
endif;

/**
 * product content close wrap buttons Add To Cart | Quick view
 */
if (!function_exists('flozen_close_wrap_btns_noop')) :
    function flozen_close_wrap_btns_noop() {
        echo '</div></div>';
    }
endif;

/**
 * product content open wrap buttons Compare | Wishlist
 */
if (!function_exists('flozen_open_wrap_btns')) :
    function flozen_open_wrap_btns() {
        echo '<div class="nasa-product-grid nasa-product-btn-clone nasa-btns-product-item"><div class="product-interactions">';
    }
endif;

/**
 * product content close wrap buttons Compare | Wishlist
 */
if (!function_exists('flozen_close_wrap_btns')) :
    function flozen_close_wrap_btns() {
        echo '</div></div>';
    }
endif;

/**
 * product content open wrap image
 */
if (!function_exists('flozen_open_before_shop_loop_item_title')) :
    function flozen_open_before_shop_loop_item_title() {
        echo '<div class="product-img-wrap"><div class="product-inner">';
    }
endif;

/**
 * Time sale product grid
 */
if (!function_exists('flozen_loop_item_product_time_sale')) :
    function flozen_loop_item_product_time_sale() {
        global $product;
        
        $time_sale = false;
        
        if ($product->is_on_sale()) {
            $productId = $product->get_id();
            $time_from = get_post_meta($productId, '_sale_price_dates_from', true);
            $time_to = get_post_meta($productId, '_sale_price_dates_to', true);
            $time_sale = ((int) $time_to < NASA_TIME_NOW || (int) $time_from > NASA_TIME_NOW) ?
                false : (int) $time_to;
        }
        
        if ($time_sale) {
            echo flozen_time_sale($time_sale);
            
            return;
        }
        
        echo '<div class="nasa-sc-pdeal-countdown hidden-tag"></div>';
    }
endif;

/**
 * product content close wrap image
 */
if (!function_exists('flozen_close_before_shop_loop_item_title')) :
    function flozen_close_before_shop_loop_item_title() {
        echo '</div></div>';
    }
endif;

/**
 * product content open wrap info
 */
if (!function_exists('flozen_open_shop_loop_item_title')) :
    function flozen_open_shop_loop_item_title() {
        echo '<div class="product-info-wrap"><div class="info rtl-text-right">';
    }
endif;


/**
 * product content close wrap info
 */
if (!function_exists('flozen_close_shop_loop_item_title')) :
    function flozen_close_shop_loop_item_title() {
        echo '</div></div>';
    }
endif;

/**
 * product content close wrap info
 */
if (!function_exists('flozen_clear_box_shadow')) :
    function flozen_clear_box_shadow() {
        echo '<div class="nasa-clear-box-shadow"></div>';
    }
endif;

/**
 * product content group buttons in list
 */
if (!function_exists('flozen_btn_in_list')) :
    function flozen_btn_in_list() {
        echo '<!-- Clone Group btns for layout List -->' .
        '<div class="group-btn-in-list-wrap hidden-tag">' .
            '<div class="group-btn-in-list"></div>' .
        '</div>';
    }
endif;

/**
 * Grid Product stock
 */
if (!function_exists('flozen_custom_content_nasa_core')) :
    function flozen_custom_content_nasa_core() {
        echo apply_filters('nasa_custom_content_nasa_core', '');
    }
endif;

/**
 * Single Product stock
 */
if (!function_exists('flozen_single_stock')) :
    function flozen_single_stock($html, $product) {
        if ($html == '' || !$product) {
            return $html;
        }

        $productId = $product->get_id();
        $stock = get_post_meta($productId, '_stock', true);
        
        if (!$stock) {
            return $html;
        }
        
        $total_sales = get_post_meta($productId, 'total_sales', true);
        $stock_sold = $total_sales ? round($total_sales) : 0;
        $stock_available = $stock ? round($stock) : 0;
        $percentage = $stock_available > 0 ? round($stock_sold/($stock_available + $stock_sold) * 100) : 0;
        
        $new_html = '<div class="stock nasa-single-product-stock">';
        $new_html .= '<table class="margin-bottom-0"><tr><td class="nasa-single-label">';
        $new_html .= '<span class="nasa-bold">' . esc_html__('Sold Items', 'flozen-theme') . '</span>';
        $new_html .= '</td><td class="nasa-single-content">';
        $new_html .= '<span class="stock-sold">';
        $new_html .= sprintf(esc_html__('Hurry! only %s left in stock', 'flozen-theme'), '<span class="number-stock-color">' . $stock_available . '</span>');
        $new_html .= '</span>';
        $new_html .= '<div class="nasa-product-stock-progress">';
        $new_html .= '<span class="nasa-product-stock-progress-bar" style="width:' . $percentage . '%"></span>';
        $new_html .= '</div>';
        $new_html .= '</td></tr></table>';
        $new_html .= '</div>';
        
        return $new_html;
    }
endif;

/**
 * Buy Now button
 */
if (!function_exists('flozen_add_buy_now_btn')) :
    function flozen_add_buy_now_btn() {
        global $nasa_opt, $product;
        
        if (
            (isset($nasa_opt['disable-cart']) && $nasa_opt['disable-cart']) ||
            (isset($nasa_opt['enable_buy_now']) && !$nasa_opt['enable_buy_now']) ||
            'external' == $product->get_type() // Disable with External Product
        ) {
            return;
        }
        
        echo '<input type="hidden" name="nasa_buy_now" value="0" />';
        echo '<button class="nasa-buy-now">' . esc_html__('Buy Now', 'flozen-theme') . '</button>';
    }
endif;

/**
 * Redirect to Checkout page after click buy now
 */
if (!function_exists('flozen_buy_now_to_checkout')) :
    function flozen_buy_now_to_checkout($redirect_url) {
        if (isset($_REQUEST['nasa_buy_now']) && $_REQUEST['nasa_buy_now'] === '1') {
            $redirect_url = wc_get_checkout_url();
        }

        return $redirect_url;
    }
endif;

/**
 * Add class Sub Categories
 */
if (!function_exists('flozen_add_class_sub_categories')) :
    function flozen_add_class_sub_categories($classes) {
        $classes[] = 'product-warp-item';
        return $classes;
    }
endif;

/**
 * Override hover effect animated product
 */
add_action('wp_head', 'flozen_effect_animated_products');
if (!function_exists('flozen_effect_animated_products')) :
    function flozen_effect_animated_products() {
        if (!NASA_WOO_ACTIVED) {
            return;
        }

        $is_product = is_product();
        $is_product_cat = is_product_category();

        if ($is_product_cat || $is_product) {
            global $wp_query, $nasa_root_term_id;
            $effect_product = '';

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
                $effect_product = get_term_meta($term_id, 'cat_effect_hover', true);

                if (!$effect_product) {
                    if ($nasa_root_term_id) {
                        $term_id = $nasa_root_term_id;
                    } else {
                        $ancestors = get_ancestors($term_id, 'product_cat');
                        $term_id = $ancestors ? end($ancestors) : 0;
                        $GLOBALS['nasa_root_term_id'] = $term_id;
                    }

                    if ($term_id) {
                        $effect_product = get_term_meta($term_id, 'cat_effect_hover', true);
                    }
                }

                if ($effect_product) {
                    if ($effect_product == 'no') {
                        $GLOBALS['nasa_animated_products'] = '';
                    }
                    else {
                        $GLOBALS['nasa_animated_products'] = $effect_product;
                    }
                }
            }
        }
    }
endif;

/**
 * Deal time in Single product page
 */
if (!function_exists('flozen_deal_time_single')) :
    function flozen_deal_time_single() {
        global $product;
        
        if ($product->get_stock_status() == 'outofstock') {
            return;
        }
        
        $product_type = $product->get_type();
        
        if ($product_type != 'simple') {
            return;
        }
        
        $productId = $product->get_id();

        $time_from = get_post_meta($productId, '_sale_price_dates_from', true);
        $time_to = get_post_meta($productId, '_sale_price_dates_to', true);
        $time_sale = ((int) $time_to < NASA_TIME_NOW || (int) $time_from > NASA_TIME_NOW) ? false : (int) $time_to;
        if (!$time_sale) {
            return;
        }
        
        echo '<div class="nasa-wrap-deal-countdown bg-single-product-gray margin-top-20 margin-right-10 rtl-margin-right-0 rtl-margin-left-10"><table class="margin-bottom-0"><tr><td class="nasa-single-label"><span class="nasa-bold">' . esc_html__('Expires Times', 'flozen-theme') . '</span></td>';
        
        echo '<td class="nasa-single-content"><div class="nasa-detail-product-deal-countdown">';
        
        echo flozen_time_sale($time_sale);
        
        echo '</div></td></tr></table></div>';
    }
endif;

/**
 * Deal time in Quick view product
 */
if (!function_exists('flozen_deal_time_quickview')) :
    function flozen_deal_time_quickview() {
        global $product;
        
        if ($product->get_stock_status() == 'outofstock') {
            return;
        }
        
        $product_type = $product->get_type();
        
        if ($product_type != 'simple') {
            return;
        }
        
        $productId = $product->get_id();

        $time_from = get_post_meta($productId, '_sale_price_dates_from', true);
        $time_to = get_post_meta($productId, '_sale_price_dates_to', true);
        $time_sale = ((int) $time_to < NASA_TIME_NOW || (int) $time_from > NASA_TIME_NOW) ? false : (int) $time_to;
        if (!$time_sale) {
            return;
        }
        
        echo '<div class="nasa-wrap-deal-countdown bg-single-product-gray margin-top-20 margin-right-10 rtl-margin-right-0 rtl-margin-left-10"><table class="margin-bottom-0"><tr><td class="nasa-single-label"><span class="nasa-bold">' . esc_html__('Expires Times', 'flozen-theme') . '</span></td>';
        
        echo '<td class="nasa-single-content"><div class="nasa-quickview-product-deal-countdown">';
        
        echo flozen_time_sale($time_sale);
        
        echo '</div></td></tr></table></div>';
    }
endif;

if (!function_exists('flozen_src_large_image_single_product')) :
    function flozen_src_large_image_single_product($variation) {
        if (!isset($variation['image_single_page'])) {
            $image = wp_get_attachment_image_src($variation['image_id'], 'shop_single');
            $variation['image_single_page'] = isset($image[0]) ? $image[0] : '';
        }
        
        return $variation;
    }
endif;

if (!function_exists('flozen_result_count')) :
    function flozen_result_count() {
        if (! wc_get_loop_prop('is_paginated') || !woocommerce_products_will_display()) {
            return;
        }
        
        $total = wc_get_loop_prop('total');
        $per_page = wc_get_loop_prop('per_page');
        
        echo '<p class="woocommerce-result-count">';
        if ( $total <= $per_page || -1 === $per_page ) {
            printf(_n('Showing the single result', 'Showing all %d results', $total, 'flozen-theme'), $total);
	} else {
            $current = wc_get_loop_prop('current_page');
            $showed = $per_page * $current;
            if ($showed > $total) {
                $showed = $total;
            }
            
            printf(_n('Showing the single result', 'Showing %d results', $total, 'flozen-theme' ), $showed);
	}
        echo '</p>';
    }
endif;

// **********************************************************************//
// ! Tiny account
// **********************************************************************//
if (!function_exists('flozen_tiny_account')) {

    function flozen_tiny_account($icon = false, $user = false, $redirect = false) {
        global $nasa_opt;
        if (isset($nasa_opt['hide_tini_menu_acc']) && $nasa_opt['hide_tini_menu_acc']) {
            return '';
        }
        
        $login_url = '#';
        $register_url = '#';
        $profile_url = '#';
        
        /* Active woocommerce */
        if (NASA_WOO_ACTIVED) {
            $myaccount_page_id = get_option('woocommerce_myaccount_page_id');
            if ($myaccount_page_id) {
                $login_url = get_permalink($myaccount_page_id);
                $register_url = $login_url;
                $profile_url = $login_url;
            }
        } else {
            $login_url = wp_login_url();
            $register_url = wp_registration_url();
            $profile_url = admin_url('profile.php');
        }

        $result = '<ul class="nasa-menus-account">';
        if (!NASA_CORE_USER_LOGGED && !$user) {
            global $nasa_opt;
            $login_ajax = (!isset($nasa_opt['login_ajax']) || $nasa_opt['login_ajax'] == 1) ? '1' : '0';
            $span = $icon ? '<i class="pe7-icon pe-7s-user"></i>' : '';
            $result .= '<li class="menu-item"><a class="nasa-login-register-ajax" data-enable="' . $login_ajax . '" href="' . esc_url($login_url) . '" title="' . esc_attr__('Login / Register', 'flozen-theme') . '">' . $span . '<span class="nasa-login-title">' . esc_html__('Login / Register', 'flozen-theme') . '</span></a></li>';
        } else {
            $span1 = $icon ? '<i class="nasa-icon pe-7s-user"></i>' : '';
            
            $menu_items = NASA_WOO_ACTIVED ? wc_get_account_menu_items() : false;
            $submenu = '';
            if ($menu_items) {
                $submenu .= '<ul class="sub-menu">';
                $current_user = wp_get_current_user();

                // Hello Account
                $submenu .= '<li class="nasa-subitem-acc nasa-hello-acc">' . sprintf(esc_html__('Hello, %s!', 'flozen-theme'), $current_user->display_name) . '</li>';
            
                foreach ($menu_items as $endpoint => $label) {
                    $submenu .= '<li class="nasa-subitem-acc ' . wc_get_account_menu_item_classes($endpoint) . '"><a href="' . esc_url(wc_get_account_endpoint_url($endpoint)) . '">' . esc_html($label) . '</a></li>';
                }
            
                $submenu .= '</ul>';
            }
            
            $result .= 
                '<li class="menu-item nasa-menu-item-account menu-item-has-children root-item">' .
                    '<a href="' . esc_url($profile_url) . '" title="' . esc_attr__('My Account', 'flozen-theme') . '">' . $span1 . esc_html__('My Account', 'flozen-theme') . '</a>' .
                    
                    $submenu .
                '</li>';
        }
        
        $result .= '</ul>';
        
        return apply_filters('nasa_tiny_account_ajax', $result);
    }

}

// **********************************************************************//
// Mini cart icon *******************************************************//
// **********************************************************************//
if (!function_exists('flozen_mini_cart')) {

    function flozen_mini_cart($show = true) {
        global $woocommerce, $nasa_opt, $nasa_mini_cart;
        
        if (!$woocommerce || (isset($nasa_opt['disable-cart']) && $nasa_opt['disable-cart'])) {
            return;
        }
        
        if (!$nasa_mini_cart) {
            $sl = $show ? '' : ' hidden-tag';
            
            $hasEmpty = $woocommerce->cart->cart_contents_count == 0 ? ' nasa-product-empty' : '';
            $icon_number = isset($nasa_opt['mini-cart-icon']) ? $nasa_opt['mini-cart-icon'] : '1';
            $nasaSl = $woocommerce->cart->cart_contents_count > 9 ? '9+' : $woocommerce->cart->cart_contents_count;

            switch ($icon_number) {
                case '1':
                    $icon_class = 'icon-nasa-cart-3';
                    break;
                case '2':
                    $icon_class = 'icon-nasa-cart-2';
                    break;
                case '3':
                    $icon_class = 'icon-nasa-cart-4';
                    break;
                case '4':
                    $icon_class = 'pe-7s-cart';
                    break;
                case '5':
                    $icon_class = 'fa fa-shopping-cart';
                    break;
                case '6':
                    $icon_class = 'fa fa-shopping-bag';
                    break;
                case '7':
                    $icon_class = 'fa fa-shopping-basket';
                    break;
                
                default:
                    $icon_class = 'icon-nasa-cart-4';
                    break;
            }
            
            $GLOBALS['nasa_mini_cart'] = 
            '<div class="mini-cart cart-inner mini-cart-type-full inline-block">' .
                '<a href="javascript:void(0);" class="cart-link" title="' . esc_attr__('Cart', 'flozen-theme') . '">' .
                    '<i class="nasa-icon cart-icon ' . $icon_class . '"></i>' .
                    '<span class="products-number' . $hasEmpty . $sl . '">' .
                        '<span class="nasa-sl">' .
                            apply_filters('nasa_mini_cart_total_items', $nasaSl) .
                        '</span>' .
                        '<span class="hidden-tag nasa-sl-label last">' . esc_html__('Items', 'flozen-theme') . '</span>' .
                    '</span>' .
                '</a>' .
            '</div>';
        }
        
        return $nasa_mini_cart ? apply_filters('nasa_mini_cart', $nasa_mini_cart) : '';
    }

}

// *************************************************************************//
// ! Add to cart Refresh mini cart content.
// *************************************************************************//
add_filter('woocommerce_add_to_cart_fragments', 'flozen_add_to_cart_refresh');
if (!function_exists('flozen_add_to_cart_refresh')) :
    function flozen_add_to_cart_refresh($fragments) {

        $fragments['.cart-inner'] = flozen_mini_cart();

        return $fragments;
    }
endif;

// **********************************************************************//
// ! Mini wishlist sidebar
// **********************************************************************//
if (!function_exists('flozen_mini_wishlist_sidebar')) {
    
    function flozen_mini_wishlist_sidebar($return = false) {
        if (!NASA_WOO_ACTIVED){
            return '';
        }
        
        global $nasa_opt;
        
        if (!NASA_WISHLIST_ENABLE && isset($nasa_opt['enable_nasa_wishlist']) && !$nasa_opt['enable_nasa_wishlist']) :
            return '';
        endif;
        
        if ($return) :
            ob_start();
        endif;
        
        $file = FLOZEN_CHILD_PATH . '/includes/nasa-sidebar-wishlist.php';
        include is_file($file) ? $file : FLOZEN_THEME_PATH . '/includes/nasa-sidebar-wishlist.php';
        
        if ($return) :
            $content = ob_get_clean();
            return $content;
        endif;
    }

}

// **********************************************************************//
// ! Add to cart in Mini wishlist sidebar
// **********************************************************************//
if (!function_exists('flozen_add_to_cart_in_wishlist')) :
    function flozen_add_to_cart_in_wishlist() {
        global $product, $nasa_opt;

        if (isset($nasa_opt['disable-cart']) && $nasa_opt['disable-cart']) {
            return '';
        }

        $title = $product->add_to_cart_text();
        $product_type = $product->get_type();
        $productId = $product->get_id();
        $enable_button_ajax = false;
        if ($product->is_in_stock() && $product->is_purchasable()) {
            if ($product_type == 'simple' || ($product_type == NASA_COMBO_TYPE && $product->all_items_in_stock())) {
                $ajaxAdd = get_option('woocommerce_enable_ajax_add_to_cart');
                $enable_button_ajax = 'yes' === $ajaxAdd ? true : false;
                $url = $enable_button_ajax ? 'javascript:void(0);' : esc_url($product->add_to_cart_url());
            } else {
                /**
                 * Bundle product
                 */
                if ($product_type == 'woosb') {
                    $url = '?add-to-cart=' . $productId;
                    if (get_option('yith_wcwl_remove_after_add_to_cart') == 'yes') {
                        $url .= '&remove_from_wishlist_after_add_to_cart=' . $productId;
                    }
                }
                /**
                 * Normal product
                 */
                else {
                    $url = esc_url($product->add_to_cart_url());
                }
            }
        }
        else {
            return '';
        }

        $addToCart = apply_filters(
            'woocommerce_loop_add_to_cart_link',
            sprintf(
                '<a href="%s" rel="nofollow" data-quantity="1" data-product_id="%s" data-product_sku="%s" class="button-in-wishlist small btn-from-wishlist %s product_type_%s add-to-cart-grid wishlist-fragment" data-type="%s" title="%s">%s</a>',
                $url, //link
                $productId, //product id
                esc_attr($product->get_sku()), //product sku
                $enable_button_ajax ? 'nasa_add_to_cart_from_wishlist' : '', //class name
                esc_attr($product_type), //product type
                esc_attr($product_type), //product type
                $title,
                $title
            ),
            $product
        );
        
        if ($product_type === 'variable') {
            $addToCart .= sprintf('<a href="javascript:void(0);" class="quick-view nasa-view-from-wishlist hidden-tag" data-prod="%s" data-from_wishlist="1">%s</a>', $productId, esc_html__('Quick View', 'flozen-theme'));
        }
        
        return $addToCart;
    }
endif;

/**
 * Custom icon cart in grid
 */
add_filter('woocommerce_loop_add_to_cart_link', 'flozen_custom_icon_add_to_cart');
if (!function_exists('flozen_custom_icon_add_to_cart')) :
    function flozen_custom_icon_add_to_cart($addToCart) {
        global $nasa_opt;
        
        $icon_number = isset($nasa_opt['cart-icon-grid']) ? $nasa_opt['cart-icon-grid'] : '2';
        $text_effect = 'nasa-text-effect-' . $icon_number;
        
        switch ($icon_number) {
            case '1':
                $icon_class = 'pe-7s-cart';
                break;
            case '3':
                $icon_class = 'icon-nasa-cart-2';
                break;
            case '4':
                $icon_class = 'icon-nasa-cart-4';
                break;
            case '5':
                $icon_class = 'fa fa-shopping-cart';
                break;
            case '6':
                $icon_class = 'fa fa-shopping-bag';
                break;
            case '7':
                $icon_class = 'fa fa-shopping-basket';
                break;
            case '8':
                $icon_class = 'fa fa-plus';
                break;
            
            case '2':
            default:
                return $addToCart;
        }
        
        $content = str_replace('icon-nasa-cart-3', $icon_class, $addToCart);
        
        if ($text_effect) {
            $content = str_replace('nasa-text-no-effect', $text_effect, $content);
        }
        
        return $content;
    }
endif;

// **********************************************************************//
// ! Add to cart button
// **********************************************************************//
if (!function_exists('flozen_add_to_cart_btn')):
    function flozen_add_to_cart_btn($echo = true, $customClass = '') {
        global $product, $nasa_opt;

        if (isset($nasa_opt['disable-cart']) && $nasa_opt['disable-cart']) {
            return '';
        }

        $productId = $product->get_id();
        $product_type = $product->get_type();
        $class_btn = $attributes = '';
        $ajaxAdd = get_option('woocommerce_enable_ajax_add_to_cart');
        
        $class_wrap = 'add-to-cart-btn btn-link add-to-cart-icon';
        if (isset($nasa_opt['disable-quickview']) && $nasa_opt['disable-quickview']) {
            $class_wrap .= ' nasa-disable-quickview';
        }
        
        if ($product->is_purchasable() && $product->is_in_stock()) {
            /**
             * Simple product
             */
            if ($product_type == 'simple') {
                $class_btn .= 'yes' === $ajaxAdd ? 'add_to_cart_button ajax_add_to_cart' : '';
            }
            
            /**
             * Variation product
             */
            if ($product_type == 'variation') {
                $attributes = ' data-variation="' . esc_attr(json_encode($product->get_variation_attributes())) . '"';
            }
            
            /**
             * Yith Bundle product
             */
            if ($product_type == NASA_COMBO_TYPE) {
                $class_btn .= 'yes' === $ajaxAdd ? 'add_to_cart_button nasa_bundle_add_to_cart' : 'add_to_cart_button';
                $attributes = ' data-type="' . esc_attr($product_type) . '"';
            }
        }
        
        if ('yes' !== get_option('woocommerce_enable_ajax_add_to_cart')) {
            $class_btn .= ' nasa-disable-ajax';
        }
        
        $class_btn .= $customClass != '' ? ' ' . $customClass : $customClass;
        $result = '';
        
        // add to cart text;
        $title = $product->add_to_cart_text();
        $result .= apply_filters(
            'woocommerce_loop_add_to_cart_link',
            sprintf(
                '<div class="%s">' .
                    '<a href="%s" rel="nofollow" data-quantity="1" data-product_id="%s" data-product_sku="%s" class="%s product_type_%s add-to-cart-grid nasa-text-no-effect" title="%s"' . $attributes . '>' .
                        '<i class="cart-icon nasa-icon icon-nasa-cart-3"></i>' .
                        '<span class="add_to_cart_text nasa-text">%s</span>' .
                    '</a>' .
                '</div>',
                esc_attr($class_wrap),
                esc_url($product->add_to_cart_url()), //link
                esc_attr($productId), //product id
                esc_attr($product->get_sku()), //product sku
                esc_attr($class_btn), //class name
                esc_attr($product_type), //product type
                esc_attr($title),
                $title
            ),
            $product
        );

        if (!$echo) {
            return $result;
        }
        
        echo flozen_str($result);
    }
endif;

// Product group button
if (!function_exists('flozen_product_group_button')):
    function flozen_product_group_button() {
        ob_start();
        $file = FLOZEN_CHILD_PATH . '/includes/nasa-product-buttons.php';
        include is_file($file) ? $file : FLOZEN_THEME_PATH . '/includes/nasa-product-buttons.php';

        return ob_get_clean();
    }
endif;

// **********************************************************************//
// ! Wishlist link
// **********************************************************************//
if (!function_exists('flozen_tini_wishlist')):
    function flozen_tini_wishlist($icon = false) {
        if (!NASA_WOO_ACTIVED || !NASA_WISHLIST_ENABLE) {
            return;
        }

        $tini_wishlist = '';
        $wishlist_page_id = get_option('yith_wcwl_wishlist_page_id');
        if (function_exists('icl_object_id')) {
            $wishlist_page_id = icl_object_id($wishlist_page_id, 'page', true);
        }
        $wishlist_page = get_permalink($wishlist_page_id);

        $span = $icon ? '<span class="icon-nasa-wishlist"></span>' : '';
        $tini_wishlist .= '<a href="' . esc_url($wishlist_page) . '" title="' . esc_attr__('Wishlist', 'flozen-theme') . '">' . $span . esc_html__('Wishlist', 'flozen-theme') . '</a>';

        return $tini_wishlist;
    }
endif;

// **********************************************************************//
// ! Wishlist link
// **********************************************************************//
if (!function_exists('flozen_icon_wishlist')):
    function flozen_icon_wishlist() {
        if (!NASA_WOO_ACTIVED) {
            return;
        }

        global $nasa_icon_wishlist;
        if (!isset($nasa_icon_wishlist)) {
            $show = defined('NASA_PLG_CACHE_ACTIVE') && NASA_PLG_CACHE_ACTIVE ? false : true;
            $count = flozen_get_count_wishlist($show);
            
            /**
             * Yith WooCommerce Wishlist
             */
            if (NASA_WISHLIST_ENABLE) {
                $href = '';
                $class = 'wishlist-link';
                
                if (defined('YITH_WCWL_PREMIUM')) {
                    $class .= ' wishlist-link-premium';
                    $wishlist_page_id = get_option('yith_wcwl_wishlist_page_id');
                    
                    if (function_exists('icl_object_id') && $wishlist_page_id) {
                        $wishlist_page_id = icl_object_id($wishlist_page_id, 'page', true);
                    }

                    $href = $wishlist_page_id ? get_permalink($wishlist_page_id) : home_url('/');
                }

                $nasa_icon_wishlist = 
                '<a class="' . $class . '" href="' . ($href != '' ? esc_url($href) : 'javascript:void(0);') . '" title="' . esc_attr__('Wishlist', 'flozen-theme') . '">' .
                    '<i class="nasa-icon icon-v2-nasa-wishlist"></i>' .
                    $count .
                '</a>';
            }
            
            /**
             * NasaTheme Wishlist
             */
            else {
                global $nasa_opt;

                if (isset($nasa_opt['enable_nasa_wishlist']) && !$nasa_opt['enable_nasa_wishlist']) {
                    return;
                }
                
                $class = 'wishlist-link nasa-wishlist-link';
                
                $nasa_icon_wishlist = 
                '<a class="' . $class . '" href="javascript:void(0);" title="' . esc_attr__('Wishlist', 'flozen-theme') . '">' .
                    '<i class="nasa-icon icon-v2-nasa-wishlist"></i>' .
                    $count .
                '</a>';
            }
            
            $GLOBALS['nasa_icon_wishlist'] = $nasa_icon_wishlist;
        }

        return isset($nasa_icon_wishlist) && $nasa_icon_wishlist ? $nasa_icon_wishlist : '';
    }
endif;

/**
 * Count mini wishlist icon
 */
if (!function_exists('flozen_get_count_wishlist')):
    function flozen_get_count_wishlist($show = true, $init_count = true) {
        if (!NASA_WOO_ACTIVED) {
            return '';
        }
        
        $count = 0;
        if (NASA_WISHLIST_ENABLE) {
            $count = $init_count ? yith_wcwl_count_products() : 0;
        } else {
            $show = true;
        }
        
        $hasEmpty = (int) $count == 0 ? ' nasa-product-empty' : '';
        $sl = $show ? '' : ' hidden-tag';
        $nasaSl = (int) $count > 9 ? '9+' : (int) $count;
        
        return 
            '<span class="nasa-wishlist-count wishlist-number' . $hasEmpty . '">' .
                '<span class="nasa-text hidden-tag">' .
                    esc_html__('Wishlist', 'flozen-theme') .
                '</span>' .
                '<span class="nasa-sl' . $sl . '">' .
                    apply_filters('nasa_mini_wishlist_total_items', $nasaSl) .
                '</span>' .
            '</span>';
    }
endif;

// **********************************************************************//
// ! Compare link
// **********************************************************************//
if (!function_exists('flozen_icon_compare')):

    function flozen_icon_compare() {
        if (!NASA_WOO_ACTIVED || !defined('YITH_WOOCOMPARE')) {
            return;
        }

        global $nasa_icon_compare, $nasa_opt;
        if (!$nasa_icon_compare) {
            global $yith_woocompare;
            
            if (!isset($nasa_opt['nasa-product-compare']) || $nasa_opt['nasa-product-compare']) {
                $view_href = isset($nasa_opt['nasa-page-view-compage']) && (int) $nasa_opt['nasa-page-view-compage'] ? get_permalink((int) $nasa_opt['nasa-page-view-compage']) : home_url('/');
                $class = 'nasa-show-compare';
            } else {
                $view_href = add_query_arg(array('iframe' => 'true'), $yith_woocompare->obj->view_table_url());
                $class = 'compare';
            }
            
            $show = defined('NASA_PLG_CACHE_ACTIVE') && NASA_PLG_CACHE_ACTIVE ? false : true;
            $count = flozen_get_count_compare($show);
            
            $GLOBALS['nasa_icon_compare'] = 
            '<span class="yith-woocompare-widget nasa_mini_compare">' .
                '<a href="' . esc_url($view_href) . '" title="' . esc_attr__('Compare', 'flozen-theme') . '" class="' . esc_attr($class) . '">' .
                    '<i class="nasa-icon icon-nasa-compare-1"></i>' .
                    $count .
                '</a>' .
            '</span>';
        }
        
        return $nasa_icon_compare ? $nasa_icon_compare : '';
    }

endif;

// **********************************************************************//
// ! Count compare
// **********************************************************************//
if (!function_exists('flozen_get_count_compare')):
    function flozen_get_count_compare($show = true) {
        if (!NASA_WOO_ACTIVED || !defined('YITH_WOOCOMPARE')) {
            return '';
        }
        
        global $yith_woocompare;
        
        $count = count($yith_woocompare->obj->products_list);
        $hasEmpty = (int) $count == 0 ? ' nasa-product-empty' : '';
        
        $sl = $show ? '' : ' hidden-tag';
        $nasaSl = (int) $count > 9 ? '9+' : (int) $count;
        
        return '<span class="nasa-compare-count compare-number' . $hasEmpty . '">' .
            '<span class="nasa-text hidden-tag">' . esc_html__('Compare ', 'flozen-theme') . ' </span>' .
            '<span class="nasa-sl' . $sl . '">' . apply_filters('nasa_mini_compare_total_items', $nasaSl) . '</span>' .
        '</span>';
    }
endif;

/**
 * Get Top Content category products page
 */
if (!function_exists('flozen_get_cat_top')) :

    function flozen_get_cat_top() {
        global $wp_query, $nasa_opt;
        
        $catId = null;
        $nasa_cat_obj = $wp_query->get_queried_object();
        if (isset($nasa_cat_obj->term_id) && isset($nasa_cat_obj->taxonomy)) {
            $catId = (int) $nasa_cat_obj->term_id;
        }

        $content = '<div class="nasa-cat-top">';
        $do_content = '';
        
        if ((int) $catId > 0) {
            $block = get_term_meta($catId, 'cat_top_content', true);
            
            if ($block === '-1') {
                return;
            }
            
            if ($block) {
                $do_content = flozen_get_block($block);
            }
        }

        if (trim($do_content) === '') {
            if (isset($nasa_opt['cat_top_content']) && $nasa_opt['cat_top_content'] != '') {
                $do_content = flozen_get_block($nasa_opt['cat_top_content']);
            }
        }

        if (trim($do_content) === '') {
            return;
        }

        $content .= $do_content . '</div>';

        echo flozen_str($content);
    }

endif;

/**
 * Get Bottom Content category products page
 */
if (!function_exists('flozen_get_cat_bottom')):

    function flozen_get_cat_bottom() {
        global $wp_query, $nasa_opt;
        
        $catId = null;
        $nasa_cat_obj = $wp_query->get_queried_object();
        if (isset($nasa_cat_obj->term_id) && isset($nasa_cat_obj->taxonomy)) {
            $catId = (int) $nasa_cat_obj->term_id;
        }
        
        $content = '<div class="nasa-cat-bottom padding-top-30 padding-bottom-50">';
        $do_content = '';
        
        if ((int) $catId > 0) {
            $block = get_term_meta($catId, 'cat_bottom_content', true);
            
            if ($block === '-1') {
                return;
            }
            
            if ($block) {
                $do_content = flozen_get_block($block);
            }
        }

        if (trim($do_content) === '') {
            if (isset($nasa_opt['cat_bottom_content']) && $nasa_opt['cat_bottom_content'] != '') {
                $do_content = flozen_get_block($nasa_opt['cat_bottom_content']);
            }
        }

        if (trim($do_content) === '') {
            return;
        }

        $content .= $do_content . '</div>';

        echo flozen_str($content);
    }

endif;

/**
 * Get product meta value
 */
if (!function_exists('flozen_get_product_meta_value')):

    function flozen_get_product_meta_value($post_id = 0, $field_id = null) {
        if (function_exists('nasa_get_product_meta_value')) {
            return nasa_get_product_meta_value($post_id, $field_id);
        }
        
        return null;
    }

endif;

/**
 * Add tab Accessories
 */
add_filter('woocommerce_product_tabs', 'flozen_accessories_product_tab');
if (!function_exists('flozen_accessories_product_tab')) :
    function flozen_accessories_product_tab($tabs) {
        global $product;
        if ($product && 'simple' === $product->get_type()) {
            
            $productIds = get_post_meta($product->get_id(), '_accessories_ids', true);
            if (!empty($productIds)) {
                $GLOBALS['accessories_ids'] = $productIds;
                $tabs['accessories_content'] = array(
                    'title'     => esc_html__('Bought Together', 'flozen-theme'),
                    'priority'  => 5,
                    'callback'  => 'flozen_accessories_product_tab_content'
                );
            }
        }
        
        return $tabs;
    }
endif;

/**
 * Content accessories of the current Product
 */
if (!function_exists('flozen_accessories_product_tab_content')) :
    function flozen_accessories_product_tab_content() {
        global $product, $accessories_ids, $nasa_opt;
        if (!$product || !$accessories_ids) {
            return;
        }
        
        $accessories = array();
        foreach ($accessories_ids as $accessories_id) {
            $product_acc = wc_get_product($accessories_id);
            
            if (is_object($product_acc) && $product_acc->get_status() === 'publish') {
                $type = $product_acc->get_type();
                if ($type !== 'simple' && $type !== 'variation') {
                    continue;
                }
                
                $accessories[] = $product_acc;
            }
        }
        
        if (empty($accessories)) {
            return;
        }
        
        $file = FLOZEN_THEME_PATH . '/includes/nasa-single-product-accessories-tab-content.php';
        include is_file($file) ? $file : FLOZEN_THEME_PATH . '/includes/nasa-single-product-accessories-tab-content.php';
    }
endif;

/**
 * Search by Categories
 */
add_action('nasa_search_by_cat', 'flozen_search_by_cat', 10, 1);
if (!function_exists('flozen_search_by_cat')):
    function flozen_search_by_cat($echo = true) {
        global $nasa_opt;
        
        $select = '';
        if (NASA_WOO_ACTIVED && (!isset($nasa_opt['search_by_cat']) || $nasa_opt['search_by_cat'] == 1)){
            $select .= '<select name="product_cat">';
            $select .= '<option value="">' . esc_html__('Categories', 'flozen-theme') . '</option>';
            
            $slug = get_query_var('product_cat');
            $nasa_catActive = $slug ? $slug : '';
            $nasa_terms = get_terms(apply_filters('woocommerce_product_attribute_terms', array(
                'taxonomy' => 'product_cat',
                'parent' => 0,
                'hide_empty' => false,
                'orderby' => 'name'
            )));
            
            if ($nasa_terms) {
                foreach ($nasa_terms as $v) {
                    $select .= '<option data-term_id="' . esc_attr($v->term_id) . '" value="' . esc_attr($v->slug) . '"' . (($nasa_catActive == $v->slug) ? ' selected' : '') . '>' . esc_attr($v->name) . '</option>';
                    flozen_get_child($v, $select, $nasa_catActive);
                }
            }
            
            $select .= '</select>';
        }
        
        if (!$echo){
            return $select;
        }
        
        echo flozen_str($select);
    }

endif;

if (!function_exists('flozen_get_child')):
    function flozen_get_child($obj = null, &$select = '', $nasa_catActive = '', $pad = '') {
        $childs = get_terms(apply_filters('woocommerce_product_attribute_terms', array(
            'taxonomy' => 'product_cat',
            'parent' => $obj->term_id,
            'hide_empty' => false,
            'orderby' => 'name'
        )));

        if (!empty($childs)){
            $pad .= '&nbsp;&nbsp;&nbsp;';
            foreach ($childs as $v){
                $select .= '<option data-term_id="' . esc_attr($v->term_id) . '" value="' . esc_attr($v->slug) . '"' . (($nasa_catActive == $v->slug) ? ' selected' : '') . '>' . $pad . esc_attr($v->name) . '</option>';
                flozen_get_child($v, $select, $nasa_catActive, $pad);
            }
        }
    }
endif;

// Nasa root categories in Shop Top bar
if (!function_exists('flozen_get_root_categories')):
    
    function flozen_get_root_categories() {
        global $nasa_opt;
        
        $content = '';
        
        if (isset($nasa_opt['top_filter_rootcat']) && !$nasa_opt['top_filter_rootcat']) {
            echo flozen_str($content);
            return;
        }
        
        if (!is_post_type_archive('product') && !is_tax(get_object_taxonomies('product'))) {
            echo flozen_str($content);
            return;
        }
        
        if (NASA_WOO_ACTIVED){
            $nasa_terms = get_terms(apply_filters('woocommerce_product_attribute_terms', array(
                'taxonomy' => 'product_cat',
                'parent' => 0,
                'hide_empty' => false,
                'orderby' => 'name'
            )));
            
            if ($nasa_terms) {
                $slug = get_query_var('product_cat');
                $nasa_catActive = $slug ? $slug : '';
                $content .= '<div class="nasa-transparent-topbar"></div>';
                $content .= '<div class="nasa-root-cat-topbar-warp hidden-tag"><ul class="nasa-root-cat product-categories">';
                $content .= '<li class="nasa_odd"><span class="nasa-root-cat-header">' . esc_html__('CATEGORIES', 'flozen-theme'). '</span></li>';
                $li_class = 'nasa_even';
                foreach ($nasa_terms as $v) {
                    $class_active = $nasa_catActive == $v->slug ? ' nasa-active' : '';
                    $content .= '<li class="cat-item cat-item-' . esc_attr($v->term_id) . ' cat-item-accessories root-item ' . $li_class . '">';
                    $content .= '<a href="' . esc_url(get_term_link($v)) . '" data-id="' . esc_attr($v->term_id) . '" class="nasa-filter-by-cat' . $class_active . '" title="' . esc_attr($v->name) . '" data-taxonomy="product_cat">' . esc_attr($v->name) . '</a>';
                    $content .= '</li>';
                    $li_class = $li_class == 'nasa_even' ? 'nasa_odd' : 'nasa_even';
                }
                
                $content .= '</ul></div>';
            }
        }
        
        $icon = $content != '' ? '<div class="nasa-icon-cat-topbar"><a href="javascript:void(0);"><i class="pe-7s-menu"></i><span class="inline-block">' . esc_html__('BROWSE', 'flozen-theme') . '</span></a></div>' : '';
        $content = $icon . $content;
        
        echo flozen_str($content);
    }

endif;

// Nasa childs category in Shop Top bar
if (!function_exists('flozen_get_childs_category')):
    
    function flozen_get_childs_category($term = null, $instance = array()) {
        $content = '';
        
        if (NASA_WOO_ACTIVED){
            global $wp_query;
            
            $term = $term == null ? $wp_query->get_queried_object() : $term;
            $parent_id = is_numeric($term) ? $term : (isset($term->term_id) ? $term->term_id : 0);
            
            $nasa_terms = get_terms(apply_filters('woocommerce_product_attribute_terms', array(
                'taxonomy' => 'product_cat',
                'parent' => $parent_id,
                'hierarchical' => true,
                'hide_empty' => false,
                'orderby' => 'name'
            )));
            
            if (!$nasa_terms) {
                $term_root = get_ancestors($parent_id, 'product_cat');
                $term_parent = isset($term_root[0]) ? $term_root[0] : 0;
                $nasa_terms = get_terms(apply_filters('woocommerce_product_attribute_terms', array(
                    'taxonomy' => 'product_cat',
                    'parent' => $term_parent,
                    'hierarchical' => true,
                    'hide_empty' => false,
                    'orderby' => 'name'
                )));
            }
            
            if ($nasa_terms) {
                $show = isset($instance['show_items']) ? (int) $instance['show_items'] : 0;
                $content .= '<ul class="nasa-children-cat product-categories nasa-product-child-cat-top-sidebar">';
                $items = 0;
                foreach ($nasa_terms as $v) {
                    $class_active = $parent_id == $v->term_id ? ' nasa-active' : '';
                    $class_li = ($show && $items >= $show) ? ' nasa-show-less' : '';
                    
                    $icon = '';
                    if (isset($instance['cat_' . $v->slug]) && trim($instance['cat_' . $v->slug]) != '') {
                        $icon = '<i class="' . $instance['cat_' . $v->slug] . '"></i>';
                        $icon .= '&nbsp;&nbsp;';
                    }
                    
                    $content .= '<li class="cat-item cat-item-' . esc_attr($v->term_id) . ' cat-item-accessories root-item' . $class_li . '">';
                    $content .= '<a href="' . esc_url(get_term_link($v)) . '" data-id="' . esc_attr($v->term_id) . '" class="nasa-filter-by-cat' . $class_active . '" title="' . esc_attr($v->name) . '" data-taxonomy="product_cat">';
                    $content .= '<div class="nasa-cat-warp">';
                    $content .= '<h5 class="nasa-cat-title">';
                    $content .= $icon . esc_attr($v->name);
                    $content .= '</h5>';
                    $content .= '</div>';
                    $content .= '</a>';
                    $content .= '</li>';
                    $items++;
                }
                
                if ($show && ($items > $show)) {
                    $content .= '<li class="nasa_show_manual"><a data-show="1" class="nasa-show" href="javascript:void(0);">' . esc_html__('+ Show more', 'flozen-theme') . '</a><a data-show="0" class="nasa-hidden" href="javascript:void(0);">' . esc_html__('- Show less', 'flozen-theme') . '</a></li>';
                }
                
                $content .= '</ul>';
            }
        }
        
        echo flozen_str($content);
    }

endif;

if (!function_exists('flozen_category_thumbnail')) :
    function flozen_category_thumbnail($category = null, $type = 'shop_thumbnail') {
        $small_thumbnail_size = apply_filters('single_product_small_thumbnail_size', $type);
        $thumbnail_id = function_exists('get_term_meta') ? get_term_meta($category->term_id, 'thumbnail_id', true) : get_woocommerce_term_meta($category->term_id, 'thumbnail_id', true);

        if ($thumbnail_id) {
            $imageArray = wp_get_attachment_image_src($thumbnail_id, $small_thumbnail_size);
            $image = isset($imageArray[0]) ? $imageArray[0] : wc_placeholder_img_src();
        } else {
            $image = wc_placeholder_img_src();
        }

        if ($image) {
            return '<img src="' . esc_url($image) . '" alt="' . esc_attr($category->name) . '" />';
        }

        return '';
    }
endif;

// Login Or Register Form
add_action('nasa_login_register_form', 'flozen_login_register_form', 10, 1);
if (!function_exists('flozen_login_register_form')) :
    function flozen_login_register_form($prefix = false) {
        global $nasa_opt;
        if (!NASA_WOO_ACTIVED) {
            return;
        }
        
        $file = FLOZEN_CHILD_PATH . '/includes/nasa-login-register-form.php';
        include is_file($file) ? $file : FLOZEN_THEME_PATH . '/includes/nasa-login-register-form.php';
    }
endif;

// get value custom field nasa-core
if (!function_exists('flozen_get_custom_field_value')) :
function flozen_get_custom_field_value($post_id, $field_id) {
    if (function_exists('nasa_get_product_meta_value')) {
            return nasa_get_product_meta_value($post_id, $field_id);
        }

        return null;
}
endif;

// Add action archive-product get content product.
if (!function_exists('flozen_get_content_products')) :
    function flozen_get_content_products($nasa_sidebar = 'top') {
        global $nasa_opt, $wp_query;

        $file = FLOZEN_CHILD_PATH . '/includes/nasa-get-content-products.php';
        include is_file($file) ? $file : FLOZEN_THEME_PATH . '/includes/nasa-get-content-products.php';
    }
endif;

// Number post_per_page shop/archive_product
add_filter('loop_shop_per_page', 'flozen_loop_shop_per_page', 20);
if (!function_exists('flozen_loop_shop_per_page')) :
    function flozen_loop_shop_per_page($post_per_page) {
        global $nasa_opt;
        return (isset($nasa_opt['products_pr_page']) && (int) $nasa_opt['products_pr_page']) ? (int) $nasa_opt['products_pr_page'] : get_option('posts_per_page');
    }
endif;

// Number relate products
add_filter('woocommerce_output_related_products_args', 'flozen_output_related_products_args');
if (!function_exists('flozen_output_related_products_args')) :
    function flozen_output_related_products_args($args) {
        global $nasa_opt;
        $args['posts_per_page'] = (isset($nasa_opt['release_product_number']) && (int) $nasa_opt['release_product_number']) ? (int) $nasa_opt['release_product_number'] : 12;
        return $args;
    }
endif;

// Compare list in bot site
add_action('nasa_show_mini_compare', 'flozen_show_mini_compare');
if (!function_exists('flozen_show_mini_compare')) :
    function flozen_show_mini_compare() {
        global $nasa_opt, $yith_woocompare;
        
        if (isset($nasa_opt['nasa-product-compare']) && !$nasa_opt['nasa-product-compare']) {
            echo '';
            return;
        }
        
        $nasa_compare = isset($yith_woocompare->obj) ? $yith_woocompare->obj : $yith_woocompare;
        if (!$nasa_compare) {
            echo '';
            return;
        }
        
        if (!isset($nasa_opt['nasa-page-view-compage']) || !(int) $nasa_opt['nasa-page-view-compage']) {
            $pages = get_pages(array(
                'meta_key' => '_wp_page_template',
                'meta_value' => 'page-view-compare.php'
            ));
            
            if ($pages) {
                foreach ($pages as $page) {
                    $nasa_opt['nasa-page-view-compage'] = (int) $page->ID;
                    break;
                }
            }
        }
        
        $view_href = isset($nasa_opt['nasa-page-view-compage']) && (int) $nasa_opt['nasa-page-view-compage'] ? get_permalink((int) $nasa_opt['nasa-page-view-compage']) : home_url('/');
        
        $nasa_compare_list = $nasa_compare->get_products_list();
        $max_compare = isset($nasa_opt['max_compare']) ? (int) $nasa_opt['max_compare'] : 4;
        
        $file = FLOZEN_CHILD_PATH . '/includes/nasa-mini-compare.php';
        include is_file($file) ? $file : FLOZEN_THEME_PATH . '/includes/nasa-mini-compare.php';
    }
endif;

/**
 * Default page compare
 */
if (!function_exists('flozen_products_compare_content')) :
    function flozen_products_compare_content() {
        global $nasa_opt, $yith_woocompare;
        
        if (isset($nasa_opt['nasa-product-compare']) && !$nasa_opt['nasa-product-compare']) {
            return '';
        }
        
        $nasa_compare = isset($yith_woocompare->obj) ? $yith_woocompare->obj : $yith_woocompare;
        if (!$nasa_compare) {
            return '';
        }
        
        ob_start();
        $file = FLOZEN_CHILD_PATH . '/includes/nasa-view-compare.php';
        include is_file($file) ? $file : FLOZEN_THEME_PATH . '/includes/nasa-view-compare.php';
        
        return ob_get_clean();
    }
endif;

/* ======================================================================= */
/* NEXT - PREV PRODUCTS */
/* ======================================================================= */
add_action('next_prev_product', 'flozen_next_product');
/* NEXT / PREV NAV ON PRODUCT PAGES */
if (!function_exists('flozen_next_product')) :
    function flozen_next_product() {
        $next_post = get_next_post(true, '', 'product_cat');
        if (is_a($next_post, 'WP_Post')) {
            $product_obj = new WC_Product($next_post->ID);
            $title = get_the_title($next_post->ID);
            $link = get_the_permalink($next_post->ID);
            ?>
            <div class="next-product next-prev-buttons">
                <a href="<?php echo esc_url($link); ?>" rel="next" class="icon-next-prev pe-7s-angle-right next" title="<?php echo esc_attr($title); ?>"></a>
                <div class="dropdown-wrap">
                    <a title="<?php echo esc_attr($title); ?>" href="<?php echo esc_url($link); ?>">
                        <div class="nasa-next-prev-img rtl-right">
                            <?php echo get_the_post_thumbnail($next_post->ID, apply_filters('single_product_small_thumbnail_size', 'shop_thumbnail')); ?>
                        </div>
                        
                        <div class="nasa-next-prev-info padding-left-20 rtl-padding-left-0 rtl-padding-right-20">
                            <span class="product-name"><?php echo flozen_str($title); ?></span>
                            <span class="price"><?php echo flozen_str($product_obj->get_price_html()); ?></span>
                        </div>
                    </a>
                </div>
            </div>
            <?php
        }
    }
endif;

add_action('next_prev_product', 'flozen_prev_product');
if (!function_exists('flozen_prev_product')) :
    function flozen_prev_product() {
        $prev_post = get_previous_post(true, '', 'product_cat');
        if (is_a($prev_post, 'WP_Post')) {
            $product_obj = new WC_Product($prev_post->ID);
            $title = get_the_title($prev_post->ID);
            $link = get_the_permalink($prev_post->ID);
            ?>
            <div class="prev-product next-prev-buttons">
                <a href="<?php echo esc_url($link); ?>" rel="prev" class="icon-next-prev pe-7s-angle-left prev" title="<?php echo esc_attr($title); ?>"></a>
                <div class="dropdown-wrap">
                    <a title="<?php echo esc_attr($title); ?>" href="<?php echo esc_url($link); ?>">
                        <div class="nasa-next-prev-img rtl-right">
                            <?php echo get_the_post_thumbnail($prev_post->ID, apply_filters('single_product_small_thumbnail_size', 'shop_thumbnail')); ?>
                        </div>
                        
                        <div class="nasa-next-prev-info padding-left-20 rtl-padding-left-0 rtl-padding-right-20">
                            <span class="product-name"><?php echo flozen_str($title); ?></span>
                            <span class="price"><?php echo flozen_str($product_obj->get_price_html()); ?></span>
                        </div>
                    </a>
                </div>
            </div>
            <?php
        }
    }
endif;

/* ==========================================================================
 * ADD VIDEO PLAY BUTTON ON PRODUCT DETAIL PAGE
 * ======================================================================= */
add_action('product_video_btn', 'flozen_product_video_btn_function');
if (!function_exists('flozen_product_video_btn_function')) {

    function flozen_product_video_btn_function() {
        $id = get_the_ID();
        $video_link = flozen_get_custom_field_value($id, '_product_video_link');
        if ($video_link) {
            ?>
            <a class="product-video-popup" title="<?php esc_attr_e('Play Video', 'flozen-theme'); ?>" href="<?php echo esc_url($video_link); ?>">
                <i class="icon-nasa-play nasa-icon"></i>
                <span class="nasa-play-video-text hidden-tag"><?php esc_html_e('Play Video', 'flozen-theme'); ?></span>
            </a>

            <?php
            $height = '800';
            $width = '800';
            $iframe_scale = '100%';
            $custom_size = flozen_get_custom_field_value($id, '_product_video_size');
            if ($custom_size) {
                $split = explode("x", $custom_size);
                $height = $split[0];
                $width = $split[1];
                $iframe_scale = ($width / $height * 100) . '%';
            }
            $style = '.has-product-video .mfp-iframe-holder .mfp-content{max-width: ' . $width . 'px;}';
            $style .= '.has-product-video .mfp-iframe-scaler{padding-top: ' . $iframe_scale . ';}';
            wp_add_inline_style('product_detail_css_custom', $style);
        }
    }
}

/**
 * flozen add wishlist button
 */
if (!function_exists('flozen_add_wishlist_button')) :
    function flozen_add_wishlist_button() {
        if (NASA_WISHLIST_ENABLE) {
            global $nasa_opt, $product, $yith_wcwl;
            if (!$yith_wcwl) {
                return;
            }
            $variation = false;
            $productId = $product->get_id();
            $productType = $product->get_type();
            if ($productType == 'variation') {
                $variation_product = $product;
                $productId = wp_get_post_parent_id($productId);
                $parentProduct = wc_get_product($productId);
                $productType = $parentProduct->get_type();
                
                $GLOBALS['product'] = $parentProduct;
                $variation = true;
            }

            ?>
            <a href="javascript:void(0);" class="btn-wishlist btn-link wishlist-icon tip-top" data-prod="<?php echo absint($productId); ?>" data-prod_type="<?php echo esc_attr($productType); ?>" data-original-product-id="<?php echo absint($productId); ?>" title="<?php esc_attr_e('Wishlist', 'flozen-theme'); ?>">
                <i class="nasa-icon icon-v2-nasa-wishlist"></i>
                <span class="hidden-tag nasa-icon-text nasa-text no-added">&nbsp;&nbsp;<?php esc_html_e('Wishlist', 'flozen-theme'); ?></span>
            </a>

            <?php if (isset($nasa_opt['optimize_wishlist_html']) && !$nasa_opt['optimize_wishlist_html']) : ?>
                <div class="add-to-link hidden-tag">
                    <?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
                </div>
            <?php endif; ?>

            <?php
            if ($variation) {
                $GLOBALS['product'] = $variation_product;
            }
        }
    }
endif;

/**
 * flozen add wishlist in Loop
 */
if (!function_exists('flozen_add_wishlist_in_list')) :
    function flozen_add_wishlist_in_list() {
        if (NASA_WISHLIST_IN_LIST) {
            flozen_add_wishlist_button();
        }
        
        if (function_exists('flozen_woo_wishlist')) :
            $nasa_wishlist = flozen_woo_wishlist();
            if ($nasa_wishlist) :
                $nasa_wishlist->btn_wishlist();
            endif;
        endif;
    }
endif;

/**
 * flozen add wishlist in Detail
 */
if (!function_exists('flozen_add_wishlist_compare_in_detail')) :
    function flozen_add_wishlist_compare_in_detail() {
        echo '<div class="product-interactions nasa-btn-single">';
            do_action('nasa_wishlist_compare_in_single');
            
            flozen_add_wishlist_button();
            
            if (get_option('yith_woocompare_compare_button_in_product_page') == 'yes') {
                flozen_add_compare_in_list();
            }
        echo '</div>';
    }
endif;

/**
 * flozen add wishlist | Compare in detail
 */

/*
 * flozen quickview in list
 */
if (!function_exists('flozen_quickview_in_list')) :
    function flozen_quickview_in_list($echo = true) {
        global $nasa_opt;
        if (isset($nasa_opt['disable-quickview']) && $nasa_opt['disable-quickview']) {
            return;
        }
        
        $class_wrap = 'quick-view btn-link quick-view-icon tip-top';
        if (isset($nasa_opt['disable-cart']) && $nasa_opt['disable-cart']) {
            $class_wrap .= ' nasa-disable-cart';
        }
        
        global $product;
        $type = $product->get_type();
        
        $quick_view = '<a href="javascript:void(0);" class="' . $class_wrap . '" data-prod="' . absint($product->get_id()) . '" title="' . ($type !== 'woosb' ? esc_attr__('Quick View', 'flozen-theme') : esc_attr__('View', 'flozen-theme')) . '" data-product_type="' . esc_attr($type) . '" data-href="' . get_the_permalink() . '"><span class="nasa-quickview-content">';
        $quick_view .= '<i class="nasa-icon pe-icon pe-7s-look"></i>';
        $quick_view .= '<span class="nasa-icon-text nasa-text">' . ($type !== 'woosb' ? esc_html__('Quick View', 'flozen-theme') : esc_html__('View', 'flozen-theme')) . '</span>';
        $quick_view .= '</span></a>';
        
        if (!$echo) {
            return $quick_view;
        }
        
        echo flozen_str($quick_view);
    }
endif;

/*
 * flozen add to cart in list
 */
if (!function_exists('flozen_add_to_cart_in_list')) :
    function flozen_add_to_cart_in_list() {
        flozen_add_to_cart_btn();
    }
endif;

/*
 * flozen gift icon in list
 */
if (!function_exists('flozen_bundle_in_list')) :
    function flozen_bundle_in_list($combo_show_type) {
        global $product;
        if (!defined('YITH_WCPB') || $product->get_type() != NASA_COMBO_TYPE) {
            return;
        }
        ?>
        <a href="javascript:void(0);" class="btn-combo-link btn-link gift-icon tip-top" data-prod="<?php echo absint($product->get_id()); ?>" title="<?php esc_attr_e('Promotion Gifts', 'flozen-theme'); ?>" data-show_type="<?php echo esc_attr($combo_show_type); ?>">
            <span class="pe-icon pe-7s-gift"></span>
            <span class="hidden-tag nasa-icon-text"><?php esc_html_e('Promotion Gifts', 'flozen-theme'); ?></span>
        </a>
        <?php
    }
endif;

/*
 * Nasa Gift icon Featured
 */
if (!function_exists('flozen_gift_featured')) :
    function flozen_gift_featured() {
        global $product, $nasa_opt;
        
        if (isset($nasa_opt['enable_gift_featured']) && !$nasa_opt['enable_gift_featured']) {
            return;
        }
        
        $product_type = $product->get_type();
        if (!defined('YITH_WCPB') || $product_type != NASA_COMBO_TYPE) {
            return;
        }
        
        $class_effect = isset($nasa_opt['enable_gift_effect']) && $nasa_opt['enable_gift_effect'] == 1 ? '' : ' nasa-transition';
        
        echo 
        '<div class="nasa-gift-featured-wrap">' .
            '<div class="nasa-gift-featured">' .
                '<div class="gift-icon">' .
                    '<a href="javascript:void(0);" class="nasa-gift-featured-event' . $class_effect . '" title="' . esc_attr__('View the promotion gifts', 'flozen-theme') . '">' .
                        '<span class="pe-icon pe-7s-gift"></span>' .
                        '<span class="hidden-tag nasa-icon-text">' . 
                            esc_html__('Promotion Gifts', 'flozen-theme') . 
                        '</span>' .
                    '</a>' .
                '</div>' .
            '</div>' .
        '</div>';
    }
endif;

/*
 * flozen add compare in list
 */
if (!function_exists('flozen_add_compare_in_list')) :
    function flozen_add_compare_in_list() {
        global $yith_woocompare, $product, $nasa_opt;
        if (!$yith_woocompare) {
            return;
        }
        
        $productId = $product->get_id();
        
        $class = 'btn-compare btn-link compare-icon';
        $nasa_compare = (!isset($nasa_opt['nasa-product-compare']) || $nasa_opt['nasa-product-compare']) ?
            true : false;
        
        if ($nasa_compare) {
            $class .= ' nasa-compare';
        }
        ?>
        <a href="javascript:void(0);" class="<?php echo esc_attr($class); ?>" data-prod="<?php echo absint($productId); ?>" title="<?php esc_attr_e('Compare', 'flozen-theme'); ?>">
            <i class="nasa-icon icon-nasa-compare-1"></i>
            <span class="hidden-tag nasa-icon-text">&nbsp;&nbsp;<?php esc_html_e('Compare', 'flozen-theme'); ?></span>
        </a>
        
        <?php if (!$nasa_compare) : ?>
            <div class="add-to-link woocommerce-compare-button hidden-tag">
                <?php echo do_shortcode('[yith_compare_button]'); ?>
            </div>
        <?php endif;
    }
endif;

/*
 * flozen add compare in detail
 */
if (!function_exists('flozen_add_compare_in_detail')) :
    function flozen_add_compare_in_detail() {
        echo '<div class="product-interactions">';
        flozen_add_compare_in_list();
        echo '</div>';
    }
endif;

if (!function_exists('flozen_single_availability')) :
    function flozen_single_availability() {
        global $product;
        // Availability
        $availability = $product->get_availability();

        if ($availability['availability']) :
            echo apply_filters('woocommerce_stock_html', '<p class="stock ' . esc_attr($availability['class']) . '">' . wp_kses(__('<span>Availability:</span> ', 'flozen-theme'), array('span' => array())) . esc_html($availability['availability']) . '</p>', $availability['availability']);
        endif;
    }
endif;

// custom fields product
if (!function_exists('flozen_add_custom_field_detail_product')) :
    function flozen_add_custom_field_detail_product() {
        global $product, $product_lightbox;
        if ($product_lightbox) {
            $product = $product_lightbox;
        }
        
        $product_type = $product->get_type();
        // 'woosb' Bundle product
        if (in_array($product_type, array('external', 'woosb')) || (!defined('YITH_WCPB') && $product_type == NASA_COMBO_TYPE)) {
            return;
        }
        
        global $nasa_opt;

        $nasa_btn_ajax_value = ('yes' === get_option('woocommerce_enable_ajax_add_to_cart') && (!isset($nasa_opt['enable_ajax_addtocart']) || $nasa_opt['enable_ajax_addtocart'] == '1')) ? '1' : '0';
        echo '<div class="nasa-custom-fields hidden-tag">';
        echo '<input type="hidden" name="nasa-enable-addtocart-ajax" value="' . $nasa_btn_ajax_value . '" />';
        echo '<input type="hidden" name="data-product_id" value="' . esc_attr($product->get_id()) . '" />';
        echo '<input type="hidden" name="data-type" value="' . esc_attr($product_type) . '" />';
        $nasa_has_wishlist = (isset($_REQUEST['nasa_wishlist']) && $_REQUEST['nasa_wishlist'] == '1') ? '1' : '0';
        echo '<input type="hidden" name="data-from_wishlist" value="' . esc_attr($nasa_has_wishlist) . '" />';
        echo '</div>';
    }
endif;

if (!function_exists('flozen_single_hr')) :
    function flozen_single_hr() {
        echo '<hr class="nasa-single-hr" />';
    }
endif;

/**
 * Before - After wrap extra buttons (quick view - wishlist - combo)
 */
if (!function_exists('flozen_before_wrap_extra_btn')) :
    function flozen_before_wrap_extra_btn() {
        echo '<div class="nasa-wrap-extra-btns"><div class="nasa-inner-extra-btns">';
    }
endif;

if (!function_exists('flozen_after_wrap_extra_btn')) :
    function flozen_after_wrap_extra_btn() {
        echo '</div></div>';
    }
endif;

/**
 * Toggle coupon
 */
if (!function_exists('flozen_wrap_coupon_toggle')) :
    function flozen_wrap_coupon_toggle($content) {
        return '<div class="nasa-toggle-coupon-checkout">' . $content . '</div>';
    }
endif;

/**
 * Images in content product
 */
if (!function_exists('flozen_loop_product_content_thumbnail')) :
    function flozen_loop_product_content_thumbnail() {
        global $product, $nasa_animated_products;
        
        $nasa_link = $product->get_permalink(); // permalink
        $nasa_title = $product->get_name(); // Title
        
        $attachment_ids = false;
        $sizeLoad = 'shop_catalog';
        
        /**
         * Mobile detect
         */
        if ($nasa_animated_products != '' && (!isset($nasa_opt['nasa_in_mobile']) || !$nasa_opt['nasa_in_mobile'])) {
            $attachment_ids = $product->get_gallery_image_ids();
        }
        
        $image_size = apply_filters('single_product_archive_thumbnail_size', $sizeLoad);
        $main_img = $product->get_image($image_size);
        
        $class_wrap = 'product-img';
        if (!$attachment_ids) {
            $class_wrap .= ' nasa-no-effect';
        }
        ?>

        <div class="<?php echo esc_attr($class_wrap); ?>">
            <a href="<?php echo esc_url($nasa_link); ?>" title="<?php echo esc_attr($nasa_title); ?>">
                <div class="main-img">
                    <?php echo flozen_str($main_img); ?>
                </div>
                <?php if ($attachment_ids) :
                    foreach ($attachment_ids as $attachment_id) :
                        $image_link = wp_get_attachment_url($attachment_id);
                        if (!$image_link):
                            continue;
                        endif;
                        printf('<div class="back-img back">%s</div>', wp_get_attachment_image($attachment_id, $image_size));
                        break;
                    endforeach;
                endif; ?>
            </a>
        </div>
    <?php
    }
endif;

/**
 * Buttons in content product
 */
if (!function_exists('flozen_loop_product_content_btns')) :
    function flozen_loop_product_content_btns() {
        echo '<div class="nasa-product-grid nasa-btns-product-item">';
        echo flozen_product_group_button();
        echo '</div>';
    }
endif;

/**
 * Buttons in content product
 */
if (!function_exists('flozen_loop_product_cart_quickview')) :
    function flozen_loop_product_cart_quickview() {
        echo '<div class="nasa-product-grid nasa-btns-product-item">';
        echo flozen_product_group_button();
        echo '</div>';
    }
endif;

/**
 * Categories in content product
 */
if (!function_exists('flozen_loop_product_cats')) :
    function flozen_loop_product_cats() {
        global $nasa_opt, $product;
        
        if (!isset($nasa_opt['grid_product_cat']) || !$nasa_opt['grid_product_cat']) {
            return;
        }
        
        echo '<div class="nasa-list-category">';
        echo wc_get_product_category_list($product->get_id(), ', ');
        echo '</div>';
    }
endif;

/**
 * Title in content product
 */
if (!function_exists('flozen_loop_product_content_title')) :
    function flozen_loop_product_content_title() {
        global $product, $nasa_opt;
        
        $nasa_link = $product->get_permalink(); // permalink
        $nasa_title = $product->get_name(); // Title
        $class_title = (!isset($nasa_opt['cutting_product_name']) || $nasa_opt['cutting_product_name'] == '1') ? ' nasa-show-one-line' : '';
        ?>
        <div class="name<?php echo esc_attr($class_title); ?>">
            <a href="<?php echo esc_url($nasa_link); ?>" title="<?php echo esc_attr($nasa_title); ?>">
                <?php echo flozen_str($nasa_title); ?>
            </a>
        </div>
    <?php
    }
endif;

/**
 * Price in content product
 */
if (!function_exists('flozen_loop_product_price')) :
    function flozen_loop_product_price() {
        echo '<div class="price-wrap">';
        woocommerce_template_loop_price();
        echo '</div>';
    }
endif;

/**
 * Description in content product
 */
if (!function_exists('flozen_loop_product_description')) :
    function flozen_loop_product_description() {
        global $post;
        echo 
        '<div class="info_main product-des-wrap">' .
            '<hr class="nasa-list-hr hidden-tag" />' .
            '<div class="product-des">' .
                apply_filters('woocommerce_short_description', $post->post_excerpt) .
            '</div>' .
        '</div>';
        
        echo '<div class="nasa-product-list nasa-btns-product-item hidden-tag"></div>';
    }
endif;

if (!function_exists('flozen_combo_tab')) :
    function flozen_combo_tab($nasa_viewmore = true) {
        global $woocommerce, $nasa_opt, $product;

        if (!$woocommerce || !$product || $product->get_type() != NASA_COMBO_TYPE || !$combo = $product->get_bundled_items()) {
            return false;
        }

        $file = FLOZEN_CHILD_PATH . '/includes/nasa-combo-products-in-detail.php';
        $file = is_file($file) ? $file : FLOZEN_THEME_PATH . '/includes/nasa-combo-products-in-detail.php';
        ob_start();
        include $file;

        return ob_get_clean();
    }
endif;

/**
 * nasa product budles in quickview
 */
if (!function_exists('flozen_combo_in_quickview')) :
    function flozen_combo_in_quickview() {
        global $woocommerce, $nasa_opt, $product;

        if (!$woocommerce || !$product || $product->get_type() != NASA_COMBO_TYPE || !($combo = $product->get_bundled_items())) {
            echo '';
            return;
        }
        
        $file = FLOZEN_CHILD_PATH . '/includes/nasa-combo-products-quickview.php';
        $file = is_file($file) ? $file : FLOZEN_THEME_PATH . '/includes/nasa-combo-products-quickview.php';

        include $file;
    }
endif;

/**
 * Top side bar shop
 */
if (!function_exists('flozen_top_sidebar_shop')) :
    function flozen_top_sidebar_shop($type = '') {
        $type_top = !$type ? '1' : $type;
        $class = 'nasa-relative hidden-tag';
        $class .= $type_top == '1' ? ' large-12 columns nasa-top-sidebar' : ' nasa-top-sidebar-' . $type_top;
        $sidebar_run = flozen_get_sidebar_run();
        ?>

        <div class="<?php echo esc_attr($class); ?>">
            <?php
            if (is_active_sidebar($sidebar_run)) :
                dynamic_sidebar($sidebar_run);
            endif;
            ?>
        </div>
    <?php
    }
endif;

/**
 * Side bar shop
 */
if (!function_exists('flozen_side_sidebar_shop')) :
    function flozen_side_sidebar_shop($nasa_sidebar = 'left') {
        $sidebar_run = flozen_get_sidebar_run();
        
        switch ($nasa_sidebar) :
            case 'right' :
                $class = 'nasa-side-sidebar nasa-sidebar-right';
                break;
            
            case 'left-classic' :
                $class = 'large-3 left columns col-sidebar';
                break;
            
            case 'right-classic' :
                $class = 'large-3 right columns col-sidebar';
                break;
            
            case 'left' :
            default:
                $class = 'nasa-side-sidebar nasa-sidebar-left';
                break;
        endswitch;
        ?>
        
        <div class="<?php echo esc_attr($class); ?>">
            <?php
            if (is_active_sidebar($sidebar_run)) :
                dynamic_sidebar($sidebar_run);
            endif;
            ?>
        </div>
    <?php
    }
endif;

/**
 * Get sidebar run in archive products page
 */
if (!function_exists('flozen_get_sidebar_run')) :
    function flozen_get_sidebar_run() {
        global $nasa_sidebar_name;
        
        if (!isset($nasa_sidebar_name)) {
            $sidebar_run = 'shop-sidebar';
            
            if (is_tax('product_cat')) {
                global $wp_query;
                $query_obj = $wp_query->get_queried_object();
                $sidebar_cats = get_option('nasa_sidebars_cats');

                if (isset($sidebar_cats[$query_obj->slug])) {
                    $sidebar_run = $query_obj->slug;
                }

                else {
                    global $nasa_root_term_id;

                    if (!$nasa_root_term_id) {
                        $ancestors = get_ancestors($query_obj->term_id, 'product_cat');
                        $nasa_root_term_id = $ancestors ? end($ancestors) : 0;
                    }

                    if ($nasa_root_term_id) {
                        $GLOBALS['nasa_root_term_id'] = $nasa_root_term_id;
                        $rootTerm = get_term_by('term_id', $nasa_root_term_id, 'product_cat');
                        if ($rootTerm && isset($sidebar_cats[$rootTerm->slug])) {
                            $sidebar_run = $rootTerm->slug;
                        }
                    }
                }
            }
            
            $nasa_sidebar_name = $sidebar_run;
            $GLOBALS['nasa_sidebar_name'] = $nasa_sidebar_name;
        }
        
        return $nasa_sidebar_name;
    }
endif;

/**
 * Sale flash | Badges
 */
if (!function_exists('flozen_add_custom_sale_flash')) :
    function flozen_add_custom_sale_flash() {
        global $product;
        
        $badges = '';
        $nasa_badges_hot = flozen_get_custom_field_value($product->get_id(), '_bubble_hot');
        if ($nasa_badges_hot):
            $badges .= '<div class="badge hot-label">' . $nasa_badges_hot . '</div>';
        endif;

        if ($product->is_on_sale()):
            
            $product_type = $product->get_type();
            if ($product_type == 'variable') :
                $badges .= '<div class="badge sale-label"><span class="sale-label-text sale-variable">' . esc_html__('SALE', 'flozen-theme') . '</span></div>';
            else :
                $price = '';
                $maximumper = 0;
                $regular_price = $product->get_regular_price();
                $sales_price = $product->get_sale_price();
                
                if (is_numeric($sales_price)) :
                    $percentage = $regular_price ? round(((($regular_price - $sales_price) / $regular_price) * 100), 0) : 0;
                    if ($percentage > $maximumper) :
                        $maximumper = $percentage;
                    endif;
                    
                    $badges .= '<div class="badge sale-label"><span class="sale-label-text">' . esc_html__('SALE', 'flozen-theme') . '</span>' . '-' . $price . sprintf(esc_html__('%s', 'flozen-theme'), $maximumper . '%') . '</div>';
                endif;
            endif;
        endif;
        
        $stock_status = $product->get_stock_status();
        if ($stock_status == "outofstock"):
            $badges .= '<div class="badge out-of-stock-label">' . esc_html__('Sold Out', 'flozen-theme') . '</div>';
        endif;
        
        if ('' !== $badges) :
            echo '<div class="nasa-badges-wrap">' . $badges . '</div>';
        endif;
    }
endif;

/**
 * Get All categories product filter in top
 */
if (!function_exists('flozen_get_all_categories')) :
    function flozen_get_all_categories($only_show_child = false, $main = false, $hierarchical = true, $order = 'order') {
        if (!NASA_WOO_ACTIVED || !class_exists('Nasa_Product_Cat_List_Walker')) {
            return;
        }
        
        if (!$only_show_child) {
            global $nasa_top_filter;
        }
        
        if (!isset($nasa_top_filter)) {
            global $nasa_opt, $wp_query, $post;

            $current_cat = false;
            $cat_ancestors = array();
            
            $rootId = 0;
            
            /**
             * post type page
             */
            if (
                isset($nasa_opt['disable_top_level_cat']) &&
                $nasa_opt['disable_top_level_cat'] &&
                isset($post->ID) &&
                $post->post_type == 'page'
            ) {
                $current_slug = get_post_meta($post->ID, '_nasa_root_category', true);
                
                if ($current_slug) {
                    $current_cat = get_term_by('slug', $current_slug, 'product_cat');
                    if ($current_cat && isset($current_cat->term_id)) {
                        $cat_ancestors = get_ancestors($current_cat->term_id, 'product_cat');
                    }
                }
            }
            
            /**
             * Archive product category
             */
            elseif (is_tax('product_cat')) {
                $current_cat = $wp_query->queried_object;
                $cat_ancestors = get_ancestors($current_cat->term_id, 'product_cat');
            }
            
            /**
             * Single product page
             */
            elseif (is_singular('product')) {
                $productId = isset($wp_query->queried_object->ID) ? $wp_query->queried_object->ID : $post->ID;
                
                $product_category = wc_get_product_terms($productId, 'product_cat', array(
                    'orderby' => 'parent',
                    'order'   => 'DESC'
                ));
                
                if ($product_category) {
                    $main_term = apply_filters('woocommerce_product_categories_widget_main_term', $product_category[0], $product_category);
                    $current_cat = $main_term;
                    $cat_ancestors = get_ancestors($main_term->term_id, 'product_cat');
                }
            }
            
            if ($only_show_child && $current_cat && $current_cat->term_id) {
                $terms_chilren = get_terms(apply_filters('woocommerce_product_attribute_terms', array(
                    'taxonomy' => 'product_cat',
                    'parent' => $current_cat->term_id,
                    'hierarchical' => $hierarchical,
                    'hide_empty' => false
                )));

                if (! $terms_chilren) {
                    $term_root = get_ancestors($current_cat->term_id, 'product_cat');
                    $rootId = isset($term_root[0]) ? $term_root[0] : $rootId;
                } else {
                    $rootId = $current_cat->term_id;
                }
            }
            
            elseif ((isset($nasa_opt['disable_top_level_cat']) && $nasa_opt['disable_top_level_cat'])) {
                $rootId = $cat_ancestors ? end($cat_ancestors) : ($current_cat ? $current_cat->term_id : $rootId);
            }
            
            $menu_cat = new Nasa_Product_Cat_List_Walker();
            $args = array(
                'taxonomy' => 'product_cat',
                'show_count' => 0,
                'hierarchical' => 1,
                'hide_empty' => false
            );
            
            $args['menu_order'] = false;
            if ($order == 'order') {
                $args['menu_order'] = 'asc';
            } else {
                $args['orderby'] = 'title';
            }
            
            $args['walker'] = $menu_cat;
            $args['title_li'] = '';
            $args['pad_counts'] = 1;
            $args['show_option_none'] = esc_html__('No product categories exist.', 'flozen-theme');
            $args['current_category'] = $current_cat ? $current_cat->term_id : '';
            $args['current_category_ancestors'] = $cat_ancestors;
            $args['child_of'] = $rootId;
            
            if (version_compare(WC()->version, '3.3.0', ">=") && (!isset($nasa_opt['show_uncategorized']) || !$nasa_opt['show_uncategorized'])) {
                $args['exclude'] = get_option('default_product_cat');
            }

            $nasa_top_filter = '<ul class="nasa-top-cat-filter product-categories nasa-accordion">';
            
            ob_start();
            wp_list_categories(apply_filters('woocommerce_product_categories_widget_args', $args));
            $nasa_top_filter .= ob_get_clean();
            
            $nasa_top_filter .= '<li class="nasa-current-note"></li>';
            $nasa_top_filter .= '</ul>';
            
            if (!$only_show_child) {
                $GLOBALS['nasa_top_filter'] = $nasa_top_filter;
            }
        }
        
        $result = $nasa_top_filter;
        if ($main) {
            $result = '<div id="nasa-main-cat-filter">' . $result . '</div>';
        }
        
        return $result;
    }
endif;

/**
 * flozen_nasa_change_view
 */
if (!function_exists('flozen_nasa_change_view')) :
    function flozen_nasa_change_view($nasa_change_view = true, $type_show = 'grid-4', $nasa_sidebar = 'no') {
        if (!$nasa_change_view) :
            return;
        endif;
        ?>
        <div class="filter-tabs">
            <span class="change-view-label">
                <?php echo esc_html__('Show', 'flozen-theme'); ?>
            </span>
            
            <a href="javascript:void(0);" class="nasa-change-layout productGrid grid-3<?php echo ('grid-3' == $type_show) ? ' active' : ''; ?>" data-columns="3">
                <?php echo esc_html__('3', 'flozen-theme'); ?>
            </a>
            
            <a href="javascript:void(0);" class="nasa-change-layout productGrid grid-4<?php echo ('grid-4' == $type_show) ? ' active' : ''; ?>" data-columns="4">
                <?php echo esc_html__('4', 'flozen-theme'); ?>
            </a>
            
            <a href="javascript:void(0);" class="nasa-change-layout productGrid grid-5<?php echo ('grid-5' == $type_show) ? ' active' : ''; ?>" data-columns="5">
                <?php echo esc_html__('5', 'flozen-theme'); ?>
            </a>
            
            <a href="javascript:void(0);" class="nasa-change-layout productList list<?php echo ('list' == $type_show) ? ' active' : ''; ?>" data-columns="1">
                <?php echo esc_html__('List', 'flozen-theme'); ?>
            </a>
        </div>
        <?php
    }
endif;

/**
 * Remove wishlit btn in detail product
 */
if (!function_exists('flozen_remove_btn_wishlist_single_product')) :
    function flozen_remove_btn_wishlist_single_product($hook) {
        $hook['add-to-cart'] = array('hook' => '', 'priority' => 0);
        return $hook;
    }
endif;

/**
 * For New version Yith Wishlist 3.0 or Higher
 */
if (!function_exists('flozen_remove_default_wishlist_button')) :
    function flozen_remove_default_wishlist_button($positions) {
        $positions = array();
        
        return $positions;
    }
endif;

/**
 * flozen_single_product_layout
 */
if (!function_exists('flozen_single_product_layout')) :
    function flozen_single_product_layout() {
        global $product, $nasa_opt;

        /**
         * Layout: New | Classic
         */
        $layout = 'new';
        
        /**
         * From NasaTheme Options
         */
        if (isset($nasa_opt['product_detail_layout']) && in_array($nasa_opt['product_detail_layout'], array('classic', 'new'))) {
            $layout = $nasa_opt['product_detail_layout'];
        }
        
        /**
         * From REQUEST
         */
        if (isset($_REQUEST['layout']) && in_array($_REQUEST['layout'], array('classic', 'new'))) {
            $layout = $_REQUEST['layout'];
        }

        /**
         * Image Layout Style
         */
        $image_layout = 'single';
        $image_style = 'slide';
        
        if ($layout == 'new') {
            /**
             * Image style slide or scroll
             */
            $image_style = (isset($nasa_opt['product_image_style']) && $nasa_opt['product_image_style'] == 'slide') ? 'slide' : 'scroll';
            
            if (isset($_REQUEST['image-style']) && in_array($_REQUEST['image-style'], array('slide', 'scroll'))) {
                $image_style = $_REQUEST['image-style'];
            }
            
            /**
             * Image layout Single or Double
             */
            if ($image_style === 'scroll') {
                $image_layout = (!isset($nasa_opt['product_image_layout']) || $nasa_opt['product_image_layout'] == 'single') ? 'single' : 'double';

                if (isset($_REQUEST['image-layout']) && in_array($_REQUEST['image-layout'], array('double', 'single'))) {
                    $image_layout = $_REQUEST['image-layout'];
                }
            }
        }

        $nasa_sidebar = isset($nasa_opt['product_sidebar']) ? $nasa_opt['product_sidebar'] : 'no';
        
        $in_mobile = false;
        if (isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile'] && isset($nasa_opt['single_product_mobile']) && $nasa_opt['single_product_mobile']) {
            $nasa_actsidebar = false;
            $in_mobile = true;
        } else {
            $nasa_actsidebar = is_active_sidebar('product-sidebar');
        }

        // Check $_GET['sidebar']
        if (isset($_REQUEST['sidebar'])):
            switch ($_REQUEST['sidebar']) :
                case 'right' :
                    $nasa_sidebar = 'right';
                    break;

                case 'left' :
                    $nasa_sidebar = 'left';
                    break;

                case 'no' :
                default:
                    $nasa_sidebar = 'no';
                    break;
            endswitch;
        endif;

        // Class
        switch ($nasa_sidebar) :
            case 'right' :
                if ($layout == 'classic') {
                    $main_class = 'large-9 columns left';
                    $bar_class = 'large-3 columns col-sidebar product-sidebar-right desktop-padding-left-30 right';
                } else {
                    $main_class = 'large-12 columns';
                    $bar_class = 'nasa-side-sidebar nasa-sidebar-right';
                }

                break;

            case 'no' :
                $main_class = 'large-12 columns';
                $bar_class = '';
                break;

            default:
            case 'left' :
                if ($layout == 'classic') {
                    $main_class = 'large-9 columns right';
                    $bar_class = 'large-3 columns col-sidebar product-sidebar-left desktop-padding-right-30 left';
                }  else {
                    $main_class = 'large-12 columns';
                    $bar_class = 'nasa-side-sidebar nasa-sidebar-left';
                }

                break;

        endswitch;
        
        $main_class .= ' nasa-single-product-' . $image_style;
        $main_class .= $image_style == 'scroll' && $image_layout == 'double' ? ' nasa-single-product-2-columns' : '';
        
        $main_class .= $in_mobile ? ' nasa-single-product-in-mobile' : '';
        
        $file = FLOZEN_CHILD_PATH . '/includes/nasa-single-product-' . $layout . '.php';
        $file = is_file($file) ? $file : FLOZEN_THEME_PATH . '/includes/nasa-single-product-' . $layout . '.php';
        
        include_once $file;
    }
endif;


if (!function_exists('flozen_product_show_reviews')) :
    function flozen_product_show_reviews() {
        if (comments_open()) {
            global $wpdb, $post;

            $count = $wpdb->get_var($wpdb->prepare("
                SELECT COUNT(meta_value) FROM $wpdb->commentmeta
                LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
                WHERE meta_key = %s
                AND comment_post_ID = %s
                AND comment_approved = %s
                AND meta_value > %s", 'rating', $post->ID, '1', '0'
            ));

            $rating = $wpdb->get_var($wpdb->prepare("
                SELECT SUM(meta_value) FROM $wpdb->commentmeta
                LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
                WHERE meta_key = %s
                AND comment_post_ID = %s
                AND comment_approved = %s", 'rating', $post->ID, '1'
            ));

            if ($count > 0) {
                $average = number_format($rating / $count, 2);

                echo '<a href="#tab-reviews" class="scroll-to-reviews"><div class="star-rating tip-top"><span style="width:' . ($average * 16) . 'px"><span class="rating"><span>' . $average . '</span><span class="hidden">' . absint($count) . '</span></span> ' . esc_html__('out of 5', 'flozen-theme') . '</span></div></a>';
            }
        }
    }
endif;

/**
 * Archive Sub-categories
 */
add_action('nasa_archive_get_sub_categories', 'nasa_archive_get_sub_categories');
if (!function_exists('nasa_archive_get_sub_categories')) :
    function nasa_archive_get_sub_categories() {
        $GLOBALS['nasa_cat_loop_delay'] = 0;
        
        echo '<div class="nasa-archive-sub-categories-wrap">';
        woocommerce_product_subcategories(array(
            'before' => '<div class="row"><div class="large-12 columns"><h3>' . esc_html__('Subcategories: ', 'flozen-theme') . '</h3></div></div><div class="row">',
            'after' => '</div><div class="row"><div class="large-12 columns margin-bottom-20 margin-top-20 text-center"><hr class="margin-left-20 margin-right-20" /></div></div>'
        ));
        echo '</div>';
    }
endif;

/**
 * Hide Uncategorized
 */
if (!function_exists('flozen_hide_uncategorized')) :
    function flozen_hide_uncategorized($args) {
        $args['exclude'] = get_option('default_product_cat');
        return $args;
    }
endif;

/**
 * Pagination product pages
 */
if (!function_exists('flozen_get_pagination_ajax')) :
    function flozen_get_pagination_ajax(
        $total = 1,
        $current = 1,
        $type = 'list',
        $prev_text = 'PREV', 
        $next_text = 'NEXT',
        $end_size = 3, 
        $mid_size = 3,
        $prev_next = true,
        $show_all = false
    ) {

        if ($total < 2) {
            return;
        }

        if ($end_size < 1) {
            $end_size = 1;
        }

        if ($mid_size < 0) {
            $mid_size = 2;
        }

        $r = '';
        $page_links = array();

        // PREV Button
        if ($prev_next && $current && 1 < $current){
            $page_links[] = '<a class="nasa-prev prev page-numbers" data-page="' . ((int)$current - 1) . '" href="javascript:void(0);">' . $prev_text . '</a>';
        }

        // PAGE Button
        $moreStart = false;
        $moreEnd = false;
        for ($n = 1; $n <= $total; $n++){
            $page = number_format_i18n($n);
            if ($n == $current){
                $page_links[] = '<a class="nasa-current current page-numbers" data-page="' . $page . '" href="javascript:void(0);">' . $page . '</a>';
            }
            
            else {
                if ($show_all || ($current && $n >= $current - $mid_size && $n <= $current + $mid_size)) {
                    $page_links[] = '<a class="nasa-page page-numbers" data-page="' . $page . '" href="javascript:void(0);">' . $page . "</a>";
                }
                
                elseif ($n == 1 || $n == $total) {
                    $page_links[] = '<a class="nasa-page page-numbers" data-page="' . $page . '" href="javascript:void(0);">' . $page . "</a>";
                }
                
                elseif (!$moreStart && $n <= $end_size + 1) {
                    $moreStart = true;
                    $page_links[] = '<span class="nasa-page-more">' . esc_html__('...', 'flozen-theme') . '</span>';
                }
                
                elseif (!$moreEnd && $n > $total - $end_size - 1) {
                    $moreEnd = true;
                    $page_links[] = '<span class="nasa-page-more">' . esc_html__('...', 'flozen-theme') . '</span>';
                }
            }
        }

        // NEXT Button
        if ($prev_next && $current && ($current < $total || -1 == $total)){
            $page_links[] = '<a class="nasa-next next page-numbers" data-page="' . ((int)$current + 1)  . '" href="javascript:void(0);">' . $next_text . '</a>';
        }
        // DATA Return
        switch ($type) {
            case 'array' :
                return $page_links;

            case 'list' :
                $r .= '<ul class="page-numbers nasa-pagination-ajax"><li>';
                $r .= implode('</li><li>', $page_links);
                $r .= '</li></ul>';
                break;

            default :
                $r = implode('', $page_links);
                break;
        }

        return $r;
    }
endif;

/**
 * No paging url
 */
if (!function_exists('flozen_nopaging_url')) :
    function flozen_nopaging_url() {
        global $wp;

        if (!$wp->request) {
            return false;
        }

        $current_url = home_url($wp->request);
        $pattern = '/page(\/)*([0-9\/])*/i';
        $nopaging_url = preg_replace($pattern, '', $current_url);

        return trailingslashit($nopaging_url);
    }
endif;

/**
 * Before Share WooCommerce
 */
if (!function_exists('flozen_before_woocommerce_share')) :
    function flozen_before_woocommerce_share() {
        echo '<hr class="nasa-single-hr" /><div class="nasa-single-share">';
    }
endif;

/**
 * Custom Share WooCommerce
 */
if (!function_exists('flozen_woocommerce_share')) :
    function flozen_woocommerce_share() {
        echo shortcode_exists('nasa_share') ? do_shortcode('[nasa_share]') : '';
    }
endif;

/**
 * After Share WooCommerce
 */
if (!function_exists('flozen_after_woocommerce_share')) :
    function flozen_after_woocommerce_share() {
        echo '</div>';
    }
endif;

/**
 * before Wrap
 */
if (!function_exists('flozen_before_wrap')) :
    function flozen_before_wrap() {
        echo '<div class="nasa-wrap">';
    }
endif;

/**
 * after Wrap
 */
if (!function_exists('flozen_after_wrap')) :
    function flozen_after_wrap() {
        echo '</div>';
    }
endif;

/**
 * Custom nasa taxonomy
 */
if (!function_exists('flozen_nasa_custom_filter_taxonomies')) :
    function flozen_nasa_custom_filter_taxonomies($customClass = '') {
        global $nasa_opt;
        
        if (
            (!isset($nasa_opt['archive_product_nasa_custom_categories']) || $nasa_opt['archive_product_nasa_custom_categories']) &&
            isset($nasa_opt['enable_nasa_custom_categories']) && $nasa_opt['enable_nasa_custom_categories'] &&
            shortcode_exists('nasa_product_nasa_categories')
        ) :
            $class = $customClass ? $customClass : 'large-9 small-12 columns';
            $max_level = isset($nasa_opt['max_level_nasa_custom_categories']) ? (int) $nasa_opt['max_level_nasa_custom_categories'] : 3;
            echo '<div class="' . esc_attr($class) . '">';
            echo do_shortcode('[nasa_product_nasa_categories deep_level="' . esc_attr($max_level) . '"]');
            echo '</div>';
        endif;
    }
endif;

/**
 * Compatible WooCommerce_Advanced_Free_Shipping
 * Only with one Rule "subtotal >= Rule"
 */
add_action('nasa_subtotal_free_shipping', 'flozen_subtotal_free_shipping');
if (!function_exists('flozen_subtotal_free_shipping')) :
    function flozen_subtotal_free_shipping($return = false) {
        $content = '';
        
        /**
         * Check active plug-in WooCommerce || WooCommerce_Advanced_Free_Shipping
         */
        if (!NASA_WOO_ACTIVED || !class_exists('WooCommerce_Advanced_Free_Shipping') || !function_exists('WAFS')) {
            return $content;
        }

        /**
         * Check setting plug-in
         */
        $wafs = WAFS();
        if (!isset($wafs->was_method)) {
            $wafs->wafs_free_shipping();
        }
        
        $wafs_method = isset($wafs->was_method) ? $wafs->was_method : null;
        if (!$wafs_method || $wafs_method->hide_shipping === 'no' || $wafs_method->enabled === 'no') {
            return $content;
        }

        /**
         * Check only 1 post wafs inputed
         */
        $wafs_posts = get_posts(array(
            'posts_per_page'    => 2,
            'post_status'       => 'publish',
            'post_type'         => 'wafs'
        ));
        if (count($wafs_posts) !== 1) {
            return $content;
        }

        /**
         * Check only 1 rule on 1 post inputed
         */
        $wafs_post = $wafs_posts[0];
        $condition_groups = get_post_meta($wafs_post->ID, '_wafs_shipping_method_conditions', true);
        if (count($condition_groups) !== 1) {
            return;
        }
        $condition_group = $condition_groups[0];
        if (count($condition_group) !== 1) {
            return $content;
        }

        /**
         * Check rule is subtotal
         */
        $value = 0;
        foreach ($condition_group as $condition) {
            if ($condition['condition'] !== 'subtotal' || $condition['operator'] !== '>=' || !$condition['value']) {
                return $content;
            }

            $value = $condition['value'];
            break;
        }

        $subtotalCart = WC()->cart->subtotal;
        $spend = 0;
        
        /**
         * Check free shipping
         */
        if ($subtotalCart < $value) {
            $spend = $value - $subtotalCart;
            $per = intval(($subtotalCart/$value)*100);
            
            $content .= '<div class="nasa-total-condition-wrap">';
            
            $content .= '<div class="nasa-total-condition" data-per="' . $per . '">' .
                '<span class="nasa-total-condition-hin">' . $per . '%</span>' .
                '<div class="nasa-subtotal-condition">' . $per . '%</div>' .
            '</div>';
            
            $allowed_html = array(
                'strong' => array(),
                'a' => array(
                    'class' => array(),
                    'href' => array(),
                    'title' => array()
                ),
                'span' => array(
                    'class' => array()
                ),
                'br' => array()
            );
            
            $content .= '<div class="nasa-total-condition-desc">' .
            sprintf(
                wp_kses(__('Spend %s more to reach <strong>FREE SHIPPING!</strong> <a class="nasa-close-magnificPopup hide-in-cart-sidebar" href="%s" title="Continue Shopping">Continue Shopping</a><br /><span class="hide-in-cart-sidebar">to add more products to your cart and receive free shipping for order %s.</span>', 'flozen-theme'), $allowed_html),
                wc_price($spend),
                esc_url(get_permalink(wc_get_page_id('shop'))),
                wc_price($value)
            ) . 
            '</div>';
            
            $content .= '</div>';
        }
        /**
         * Congratulations! You've got free shipping!
         */
        else {
            $content .= '<div class="nasa-total-condition-wrap">';
            $content .= '<div class="nasa-total-condition-desc">';
            $content .= sprintf(
                esc_html__("Congratulations! You get free shipping with your order greater %s.", 'flozen-theme'),
                wc_price($value)
            );
            $content .= '</div>';
            $content .= '</div>';
        }
        
        if (!$return) {
            echo flozen_str($content);
            
            return;
        }
        
        return $content;
    }
endif;

/**
 * Add Free_Shipping to Cart page
 */
add_action('woocommerce_cart_contents', 'flozen_subtotal_free_shipping_in_cart');
if (!function_exists('flozen_subtotal_free_shipping_in_cart')) :
    function flozen_subtotal_free_shipping_in_cart() {
        $content = flozen_subtotal_free_shipping(true);
        
        if ($content !== '') {
            echo '<tr class="nasa-no-border"><td colspan="6" class="nasa-subtotal_free_shipping">' . flozen_str($content) . '</td></tr>';
        }
    }
endif;

/**
 * Before account Navigation
 */
add_action('woocommerce_before_account_navigation', 'flozen_before_account_nav');
if (!function_exists('flozen_before_account_nav')) :
    function flozen_before_account_nav() {
        global $nasa_opt;
        
        if (!NASA_WOO_ACTIVED || !NASA_CORE_USER_LOGGED || (isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile'])) {
            return;
        }
        
        $current_user = wp_get_current_user();
        $logout_url = wp_logout_url(home_url('/'));
        ?>
        <div class="account-nav-wrap vertical-tabs">
            <div class="account-nav account-user hide-for-small">
                <?php echo get_avatar($current_user->ID, 60); ?>
                <span class="user-name">
                    <?php echo esc_attr($current_user->display_name); ?>
                </span>
                <span class="logout-link">
                    <a href="<?php echo esc_url($logout_url); ?>" title="<?php esc_attr_e('Logout', 'flozen-theme'); ?>">
                        <?php esc_html_e('Logout', 'flozen-theme'); ?>
                    </a>
                </span>
            </div>
    <?php
    }
endif;

/**
 * After account Navigation
 */
add_action('woocommerce_after_account_navigation', 'flozen_after_account_nav');
if (!function_exists('flozen_after_account_nav')) :
    function flozen_after_account_nav() {
        global $nasa_opt;
        if (!NASA_WOO_ACTIVED || !NASA_CORE_USER_LOGGED || (isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile'])) {
            return;
        }
        ?>
        </div>
    <?php
    }
endif;

add_action('woocommerce_account_dashboard', 'flozen_account_dashboard_nav');
if (!function_exists('flozen_account_dashboard_nav')) :
    function flozen_account_dashboard_nav() {
        if (!NASA_WOO_ACTIVED || !NASA_CORE_USER_LOGGED) {
            return;
        }
        
        $menu_items = wc_get_account_menu_items();
        if (empty($menu_items)) {
            return;
        }
        ?>
        <nav class="woocommerce-MyAccount-navigation nasa-MyAccount-navigation">
            <ul>
                <?php foreach ($menu_items as $endpoint => $label) : ?>
                    <li class="<?php echo wc_get_account_menu_item_classes($endpoint); ?>">
                        <a href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>"><?php echo esc_html($label); ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    <?php
    }
endif;

/**
 * Custom shopping cart page when empty
 */
add_filter('wc_empty_cart_message', 'flozen_empty_cart_message');
if (!function_exists('flozen_empty_cart_message')) :
    function flozen_empty_cart_message($mess) {
        $mess .= '<span class="nasa-extra-empty">' . esc_html__('Before proceed to checkout you must add some products to shopping cart.', 'flozen-theme') . '</span>';
        $mess .= '<span class="nasa-extra-empty">' . esc_html__('You will find a lot of interesting products on our "Shop" page.', 'flozen-theme') . '</span>';

        return $mess;
    }
endif;

/**
 * Custom subtotal in widget cart
 */
if (!function_exists('flozen_widget_shopping_cart_subtotal')) :
    function flozen_widget_shopping_cart_subtotal() {
        echo '<span class="total-price-label">' . esc_html__('Subtotal', 'flozen-theme') . '</span>';
        echo '<span class="total-price right">' . WC()->cart->get_cart_subtotal() . '</span>';
    }
endif;

/**
 * Before archive short description
 */
if (!function_exists('flozen_before_archive_description')) :
    function flozen_before_archive_description() {
        echo '<div class="large-12 columns nasa_shop_description">';
    }
endif;

/**
 * After archive short description
 */
if (!function_exists('flozen_after_archive_description')) :
    function flozen_after_archive_description() {
        echo '</div>';
    }
endif;
