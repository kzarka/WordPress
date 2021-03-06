<?php

function flozen_get_content_custom_css($nasa_opt = array()) {

    ob_start();
    ?><style><?php
    echo '@charset "UTF-8";' . "\n";
    /**
     * Start font style
     */
    if ((!isset($nasa_opt['type_font_select']) || $nasa_opt['type_font_select'] == 'custom') && isset($nasa_opt['custom_font']) && $nasa_opt['custom_font'] && $nasa_opt['custom_font'] != 'NS-ProximaNova') :
        ?>
            body,
            p,
            h1, h2, h3, h4, h5, h6,
            #top-bar,
            .nav-dropdown,
            .top-bar-nav a.nav-top-link,
            .cart-count,
            .mini-cart .nav-dropdown-inner,
            .megatop > a,
            .header-nav li.root-item > a,
            .nasa-tabs .nasa-tab a,
            #vertical-menu-wrapper li.root-item > a,
            .service-title,
            .price,
            .amount,
            .banner .banner-content .banner-inner h1,
            .banner .banner-content .banner-inner h2,
            .banner .banner-content .banner-inner h3,
            .banner .banner-content .banner-inner h4,
            .banner .banner-content .banner-inner h5,
            .banner .banner-content .banner-inner h6
            {
                font-family: "<?php echo esc_attr(ucwords($nasa_opt['custom_font'])); ?>", helvetica, arial, sans-serif !important;
            }
        <?php
    elseif ($nasa_opt['type_font_select'] == 'google') :
        if (isset($nasa_opt['type_texts']) && $nasa_opt['type_texts'] != '') :
            ?>
                p,
                body,
                #top-bar,
                .nav-dropdown,
                .top-bar-nav a.nav-top-link
                {
                    font-family: "<?php echo esc_attr($nasa_opt['type_texts']); ?>", helvetica, arial, sans-serif !important;
                }
            <?php
        endif;

        if (isset($nasa_opt['type_nav']) && $nasa_opt['type_nav'] != '') :
            ?>
                .megatop > a,
                .nasa-tabs .nasa-tab a,
                .root-item a
                {
                    font-family: "<?php echo esc_attr($nasa_opt['type_nav']); ?>", helvetica, arial, sans-serif !important;
                }
            <?php
        endif;

        if (isset($nasa_opt['type_headings']) && $nasa_opt['type_headings'] != '') :
            ?>
                .service-title,
                h1, h2, h3, h4, h5, h6
                {
                    font-family: "<?php echo esc_attr($nasa_opt['type_headings']); ?>", helvetica, arial, sans-serif !important;
                }
            <?php
        endif;

        if (isset($nasa_opt['type_banner']) && $nasa_opt['type_banner'] != '') :
            ?>
                .banner .banner-content .banner-inner h1,
                .banner .banner-content .banner-inner h2,
                .banner .banner-content .banner-inner h3,
                .banner .banner-content .banner-inner h4,
                .banner .banner-content .banner-inner h5,
                .banner .banner-content .banner-inner h6
                {
                    font-family: "<?php echo esc_attr($nasa_opt['type_banner']); ?>", helvetica, arial, sans-serif !important;
                    letter-spacing: 0px;
                }
            <?php
        endif;
        
        if (isset($nasa_opt['type_price']) && $nasa_opt['type_price'] != '') :
            ?>
                .price,
                .amount
                {
                    font-family: "<?php echo esc_attr($nasa_opt['type_price']); ?>", helvetica, arial, sans-serif !important;
                }
            <?php
        endif;
    endif; // End font style

    if (isset($nasa_opt['max_height_logo']) && (int) $nasa_opt['max_height_logo']) :
        ?>
            body #masthead .logo-wrapper .logo a img
            {
                max-height: <?php echo absint($nasa_opt['max_height_logo']) . 'px'; ?>;
            }
        <?php
    endif;
    
    if (isset($nasa_opt['max_height_mobile_logo']) && (int) $nasa_opt['max_height_mobile_logo']) :
        ?>
            body .mobile-menu .logo-wrapper .header_logo,
            body .nasa-login-register-warper #nasa-login-register-form .nasa-form-logo-log .header_logo
            {
                max-height: <?php echo absint($nasa_opt['max_height_mobile_logo']) . 'px'; ?>;
            }
        <?php
    endif;
    
    if (isset($nasa_opt['max_height_sticky_logo']) && (int) $nasa_opt['max_height_sticky_logo']) :
        ?>
            body .fixed-already #masthead .logo-wrapper a img
            {
                max-height: <?php echo absint($nasa_opt['max_height_sticky_logo']) . 'px'; ?>;
            }
        <?php
    endif;

    if (isset($nasa_opt['site_layout']) && $nasa_opt['site_layout'] == 'boxed') :
        $nasa_opt['site_bg_image'] = isset($nasa_opt['site_bg_image']) && $nasa_opt['site_bg_image'] ? str_replace(
            array(
                '[site_url]',
                '[site_url_secure]',
            ), array(
                site_url('', 'http'),
                site_url('', 'https'),
            ), $nasa_opt['site_bg_image']
        ) : false;
        ?> 
            body.boxed,
            body
            {
            <?php if ($nasa_opt['site_bg_color']) : ?>
                background-color: <?php echo esc_attr($nasa_opt['site_bg_color']); ?>;
            <?php endif; ?>
            <?php if ($nasa_opt['site_bg_image']) : ?>
                background-image: url("<?php echo esc_url($nasa_opt['site_bg_image']); ?>");
            <?php endif; ?>
                background-attachment: fixed;
            }
        <?php
    endif;

    /* COLOR PRIMARY ================================================================ */
    if (isset($nasa_opt['color_primary'])) :
        echo flozen_get_style_primary_color($nasa_opt['color_primary']);
    endif;

    /* COLOR SECONDARY ============================================================== */
    if (isset($nasa_opt['color_secondary']) && $nasa_opt['color_secondary'] != '') :
        ?>
            a.secondary.trans-button,
            li.menu-sale a
            {
                color: <?php echo esc_attr($nasa_opt['color_secondary']); ?> !important;
            }
            body .label-sale.menu-item a:after,
            body .button.secondary,
            body .button.checkout,
            body #submit.secondary,
            body button.secondary,
            body .button.secondary,
            body input[type="submit"].secondary
            {
                background-color: <?php echo esc_attr($nasa_opt['color_secondary']); ?>;
            }
            body a.button.secondary,
            body .button.secondary
            {
                border-color: <?php echo esc_attr($nasa_opt['color_secondary']); ?>;
            }
            a.secondary.trans-button:hover
            {
                color: #FFF !important;
                background-color: <?php echo esc_attr($nasa_opt['color_secondary']); ?> !important;
            }
        <?php
    endif;

    /* COLOR SUCCESS ============================================================== */
    if (isset($nasa_opt['color_success']) && $nasa_opt['color_success'] != '') :
        ?>
            .nasa-compare-list-bottom .nasa-compare-mess
            {
                color: <?php echo esc_attr($nasa_opt['color_success']); ?> !important;
            }
            .woocommerce-message
            {
                background-color: <?php echo esc_attr($nasa_opt['color_success']); ?> !important;
            }
            body .label-popular.menu-item a:after,
            body .tooltip-new.menu-item > a:after
            {
                background-color: <?php echo esc_attr($nasa_opt['color_success']); ?>;
                border-color: <?php echo esc_attr($nasa_opt['color_success']); ?>;
            }
            body .nasa-compare-list-bottom .nasa-compare-mess
            {
                border-color: <?php echo esc_attr($nasa_opt['color_success']); ?>;
            }
            .tooltip-new.menu-item > a:before
            {
                border-top-color: <?php echo esc_attr($nasa_opt['color_success']) ?> !important;
            }
            body .added .nasa-icon,
            body .nasa-added .nasa-icon
            {
                color: <?php echo esc_attr($nasa_opt['color_success']); ?> !important;
            }
        <?php
    endif;

    /* COLOR SALE ============================================================== */
    if (isset($nasa_opt['color_sale_label']) && $nasa_opt['color_sale_label'] != '') :
        ?>
            body .badge.sale-label
            {
                background: <?php echo esc_attr($nasa_opt['color_sale_label']); ?>;
            }
        <?php
    endif;

    /* COLOR HOT ============================================================== */
    if (isset($nasa_opt['color_hot_label']) && $nasa_opt['color_hot_label'] != '') :
        ?>
            body .badge.hot-label
            {
                background: <?php echo esc_attr($nasa_opt['color_hot_label']); ?>;
            }
        <?php
    endif;

    /* COLOR PRICE ============================================================== */
    if (isset($nasa_opt['color_price_label']) && $nasa_opt['color_price_label'] != '') :
        ?>
            body .product-price, 
            body .price.nasa-sc-p-price,
            body .price,
            body .product-item .info .price,
            body .countdown .countdown-row .countdown-amount,
            body .columns.nasa-column-custom-4 .nasa-sc-p-deal-countdown .countdown-row.countdown-show4 .countdown-section .countdown-amount,
            body .item-product-widget .product-meta .price
            {
                color: <?php echo esc_attr($nasa_opt['color_price_label']); ?>;
            }
            .amount,
            .nasa-total-condition-desc .woocommerce-Price-amount,
            .nasa-after-add-to-cart-subtotal-price
            {
                color: <?php echo esc_attr($nasa_opt['color_price_label']); ?> !important;
            }
        <?php
    endif;
    
    /* COLOR Product Title ============================================================== */
    if (isset($nasa_opt['product_title_color']) && $nasa_opt['product_title_color'] != '') :
        ?>
            body .product-item .info .name a,
            body .nasa-products-special-deal .product-deal-special-title a,
            body .item-product-widget .product-meta .product-title,
            body .nasa-products-special-deal .product-deal-special-title a,
            body .nasa-search-space .tt-menu .item-search a p,
            body .nasa-static-sidebar .widget_shopping_cart_content .mini-cart-info a,
            body .nasa-static-sidebar .wishlist_sidebar .wishlist_table .nasa-wishlist-title,
            body .shop_table.cart td.product-name a
            {
                color: <?php echo esc_attr($nasa_opt['product_title_color']); ?>;
            }
        <?php
    endif;
    
    /* COLOR Product Title hover ================================================= */
    if (isset($nasa_opt['product_title_color_hover']) && $nasa_opt['product_title_color_hover'] != '') :
        ?>
            body .product-item .info .name a:hover,
            body .nasa-products-special-deal .product-deal-special-title a:hover,
            body .item-product-widget .product-meta .product-title:hover,
            body .nasa-products-special-deal .product-deal-special-title a:hover,
            body .nasa-search-space .tt-menu .item-search a:hover p,
            body .nasa-static-sidebar .widget_shopping_cart_content .mini-cart-info a:hover,
            body .nasa-static-sidebar .wishlist_sidebar .wishlist_table .nasa-wishlist-title a:hover,
            body .shop_table.cart td.product-name a:hover
            {
                color: <?php echo esc_attr($nasa_opt['product_title_color_hover']); ?>;
            }
        <?php
    endif;

    /* COLOR BUTTON ============================================================== */
    if (isset($nasa_opt['color_button']) && $nasa_opt['color_button'] != '') :
        ?> 
            form.cart .button,
            .cart-inner .button.secondary,
            .checkout-button,
            input#place_order,
            .btn-viewcart,
            input#submit,
            .add_to_cart,
            button,
            .button
            {
                background-color: <?php echo esc_attr($nasa_opt['color_button']); ?> !important;
            }
            form.cart .button[disabled],
            .cart-inner .button.secondary[disabled],
            .checkout-button[disabled],
            input#place_order[disabled],
            .btn-viewcart[disabled],
            input#submit[disabled],
            .add_to_cart[disabled],
            button[disabled],
            .button[disabled]
            {
                background-color: #aaaaaa !important;
                border-color: #aaaaaa !important;
            }
        <?php
    endif;

    /* COLOR Button HOVER ============================================================== */
    if (isset($nasa_opt['color_hover']) && $nasa_opt['color_hover'] != '') :
        ?>
            form.cart .button:hover,
            a.primary.trans-button:hover,
            .form-submit input:hover,
            #payment .place-order input:hover,
            input#submit:hover,
            .product-list .product-img .quick-view.fa-search:hover,
            .footer-type-2 input.button,
            button:hover,
            .button:hover,
            .cart-inner .button.secondary:hover,
            .checkout-button:hover,
            input#place_order:hover,
            .btn-viewcart:hover,
            input#submit:hover,
            .add_to_cart:hover
            {
                background-color: <?php echo esc_attr($nasa_opt['color_hover']); ?>!important;
            }
            body .product_list_widget .product-interactions .add-to-cart-grid:hover,
            body .product_list_widget .product-interactions .quick-view:hover
            {
                background-color: <?php echo esc_attr($nasa_opt['color_hover']); ?>;
                border-color: <?php echo esc_attr($nasa_opt['color_hover']); ?>;
            }
            .btn-viewcart:hover
            {
                color: #fff !important;
            }
        <?php
    endif;

    /* COLOR BORDER BUTTON ============================================================== */
    if (isset($nasa_opt['button_border_color']) && $nasa_opt['button_border_color'] != '') :
        ?>
            #submit, 
            button, 
            .button, 
            input[type="submit"],
            .widget.woocommerce li.nasa-li-filter-size a,
            .widget.widget_categories li.nasa-li-filter-size a,
            .widget.widget_archive li.nasa-li-filter-size a
            {
                border-color: <?php echo esc_attr($nasa_opt['button_border_color']); ?> !important;
            }
            body .products.list .product-item .product-interactions > div
            {
                border-color: <?php echo esc_attr($nasa_opt['button_border_color']); ?>;
            }
        <?php
    endif;

    /* COLOR BORDER BUTTON HOVER ============================================================== */
    if (isset($nasa_opt['button_border_color_hover']) && $nasa_opt['button_border_color_hover'] != '') :
        ?>
            #submit:hover, 
            button:hover, 
            .button:hover, 
            input[type="submit"]:hover,
            .products.list .product-item .product-interactions > div:hover,
            .widget.woocommerce li.nasa-li-filter-size.chosen a,
            .widget.woocommerce li.nasa-li-filter-size.nasa-chosen a,
            .widget.woocommerce li.nasa-li-filter-size:hover a,
            .widget.widget_categories li.nasa-li-filter-size.chosen a,
            .widget.widget_categories li.nasa-li-filter-size.nasa-chosen a,
            .widget.widget_categories li.nasa-li-filter-size:hover a,
            .widget.widget_archive li.nasa-li-filter-size.chosen a,
            .widget.widget_archive li.nasa-li-filter-size.nasa-chosen a,
            .widget.widget_archive li.nasa-li-filter-size:hover a
            {
                border-color: <?php echo esc_attr($nasa_opt['button_border_color_hover']); ?> !important;
            }
            body .products.list .product-item .product-interactions > div:hover
            {
                border-color: <?php echo esc_attr($nasa_opt['button_border_color_hover']); ?>;
            }
        <?php
    endif;

    /* COLOR TEXT BUTTON ============================================================== */
    if (isset($nasa_opt['button_text_color']) && $nasa_opt['button_text_color'] != '') :
        ?>
            #submit, 
            button, 
            .button, 
            input[type="submit"]
            {
                color: <?php echo esc_attr($nasa_opt['button_text_color']); ?> !important;
            }
        <?php
    endif;

    /* COLOR HOVER TEXT BUTTON ======================================================= */
    if (isset($nasa_opt['button_text_color_hover']) && $nasa_opt['button_text_color_hover'] != '') :
        ?>
            #submit:hover, 
            button:hover, 
            .button:hover, 
            input[type="submit"]:hover
            {
                color: <?php echo esc_attr($nasa_opt['button_text_color_hover']); ?> !important;
            }
            body .product_list_widget .product-interactions .quick-view:hover .nasa-icon-text,
            body .product_list_widget .product-interactions .quick-view:hover .pe-icon,
            body .product_list_widget .product-interactions .quick-view:hover .nasa-icon
            {
                color: <?php echo esc_attr($nasa_opt['button_text_color_hover']); ?>;
            }
        <?php
    endif;

    if (isset($nasa_opt['button_radius'])) :
        ?>
            body .products.list .product-item .info .product-interactions .add-to-cart-btn,
            body .products.list .product-interactions .add-to-cart-grid,
            body .product-item .product-deal-special-buttons .nasa-product-grid .product-interactions .add-to-cart-btn .add-to-cart-grid,
            body .widget .tagcloud a,
            body .products.grid .product-item .product-deals .info .nasa-deal-showmore a.button,
            body .products.grid .product-item .product-deals .info .nasa-deal-showmore button,
            body .wishlist_table .add_to_cart,
            body .yith-wcwl-add-button > a.button.alt,
            body #submit,
            body #submit.disabled,
            body #submit[disabled],
            body button,
            body button.disabled,
            body button[disabled],
            body .button,
            body .button.disabled,
            body .button[disabled],
            body input[type="submit"],
            body input[type="submit"].disabled,
            body input[type="submit"][disabled]
            {
                border-radius: <?php echo absint($nasa_opt['button_radius']); ?>px;
                -webkit-border-radius: <?php echo absint($nasa_opt['button_radius']); ?>px;
                -o-border-radius: <?php echo absint($nasa_opt['button_radius']); ?>px;
                -moz-border-radius: <?php echo absint($nasa_opt['button_radius']); ?>px;
            }
        <?php
    endif;

    if (isset($nasa_opt['button_border']) && (int) $nasa_opt['button_border']) :
        ?>
            body #submit, 
            body button, 
            body .button,
            body input[type="submit"]
            {
                border-width: <?php echo absint($nasa_opt['button_border']); ?>px;
            }
        <?php
    endif;

    if (isset($nasa_opt['input_radius'])) :
        ?>
            body textarea,
            body select,
            body input[type="text"],
            body input[type="password"],
            body input[type="date"], 
            body input[type="datetime"],
            body input[type="datetime-local"],
            body input[type="month"],
            body input[type="week"],
            body input[type="email"],
            body input[type="number"],
            body input[type="search"],
            body input[type="tel"],
            body input[type="time"],
            body input[type="url"],
            body .category-page .sort-bar .select-wrapper
            {
                border-radius: <?php echo absint($nasa_opt['input_radius']); ?>px;
                -webkit-border-radius: <?php echo absint($nasa_opt['input_radius']); ?>px;
                -o-border-radius: <?php echo absint($nasa_opt['input_radius']); ?>px;
                -moz-border-radius: <?php echo absint($nasa_opt['input_radius']); ?>px;
            }
        <?php
    endif;
    
    /* BG COLOR BUTTON BUY NOW ============================================== */
    if (isset($nasa_opt['buy_now_bg_color']) && $nasa_opt['buy_now_bg_color'] != '') :
        ?>
            body .cart button.nasa-buy-now
            {
                background-color: <?php echo esc_attr($nasa_opt['buy_now_bg_color']); ?> !important;
                border-color: <?php echo esc_attr($nasa_opt['buy_now_bg_color']); ?> !important;
            }
        <?php
    endif;
    
    /* BG COLOR BUTTON HOVER BUY NOW ======================================== */
    if (isset($nasa_opt['buy_now_bg_color_hover']) && $nasa_opt['buy_now_bg_color_hover'] != '') :
        ?>
            body .cart button.nasa-buy-now:hover
            {
                background-color: <?php echo esc_attr($nasa_opt['buy_now_bg_color_hover']); ?> !important;
                border-color: <?php echo esc_attr($nasa_opt['buy_now_bg_color_hover']); ?> !important;
            }
        <?php
    endif;
    
    /**
     * Color of header
     */
    $bg_color = (isset($nasa_opt['bg_color_header']) && $nasa_opt['bg_color_header']) ? $nasa_opt['bg_color_header'] : '';
    $text_color = (isset($nasa_opt['text_color_header']) && $nasa_opt['text_color_header']) ? $nasa_opt['text_color_header'] : '';
    $text_color_hover = (isset($nasa_opt['text_color_hover_header']) && $nasa_opt['text_color_hover_header']) ? $nasa_opt['text_color_hover_header'] : '';

    echo flozen_get_style_header_color($bg_color, $text_color, $text_color_hover);

    /**
     * Color of main menu
     */
    $bg_color = isset($nasa_opt['bg_color_main_menu']) ? $nasa_opt['bg_color_main_menu'] : '';
    $text_color = (isset($nasa_opt['text_color_main_menu']) && $nasa_opt['text_color_main_menu']) ? $nasa_opt['text_color_main_menu'] : '';
    $text_color_hover = (isset($nasa_opt['text_color_hover_main_menu']) && $nasa_opt['text_color_hover_main_menu']) ? $nasa_opt['text_color_hover_main_menu'] : '';

    echo flozen_get_style_main_menu_color($bg_color, $text_color, $text_color_hover);
    
    /**
     * Color of vertical menu
     */
    $bg_color = isset($nasa_opt['bg_color_vertical_menu']) ? $nasa_opt['bg_color_vertical_menu'] : '';
    $text_color = (isset($nasa_opt['text_color_vertical_menu']) && $nasa_opt['text_color_vertical_menu']) ? $nasa_opt['text_color_vertical_menu'] : '';
    $text_color_hover = (isset($nasa_opt['text_color_hover_vertical_menu']) && $nasa_opt['text_color_hover_vertical_menu']) ? $nasa_opt['text_color_hover_vertical_menu'] : '';

    echo flozen_get_style_vertical_menu_color($bg_color, $text_color, $text_color_hover);

    /**
     * Color of Top bar
     */
    if (!isset($nasa_opt['topbar_show']) || $nasa_opt['topbar_show']) {
        $bg_color = (isset($nasa_opt['bg_color_topbar']) && $nasa_opt['bg_color_topbar']) ? $nasa_opt['bg_color_topbar'] : '';
        $text_color = (isset($nasa_opt['text_color_topbar']) && $nasa_opt['text_color_topbar']) ? $nasa_opt['text_color_topbar'] : '';
        $text_color_hover = (isset($nasa_opt['text_color_hover_topbar']) && $nasa_opt['text_color_hover_topbar']) ? $nasa_opt['text_color_hover_topbar'] : '';

        echo flozen_get_style_topbar_color($bg_color, $text_color, $text_color_hover);
    }

    /**
     * Add width to site
     */
    if (isset($nasa_opt['plus_wide_width']) && (int) $nasa_opt['plus_wide_width'] > 0) :
        global $content_width;
        $content_width = !isset($content_width) ? 1200 : $content_width;
        $max_width = ($content_width + (int) $nasa_opt['plus_wide_width']);
        
        echo flozen_get_style_plus_wide_width($max_width);
    endif;
    
    /* Add custom here ================================== */
    /* HERE ============================================= */
    /* Add custom here ================================== */
    if (!isset($nasa_opt['disable_wow']) || !$nasa_opt['disable_wow']) :
        ?>
            .wow
            {
                visibility: hidden;
            }
        <?php
    endif;

    if (isset($nasa_opt['disable-quickview']) && $nasa_opt['disable-quickview']) :
        ?>
            body .product-item .product-img-wrap .nasa-product-grid .product-interactions .btn-compare
            {
                top: 55px;
            }
        <?php
    endif;
    
    ?></style><?php
    $css = ob_get_clean();
    
    return flozen_convert_css($css);
}
