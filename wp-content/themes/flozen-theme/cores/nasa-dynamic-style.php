<?php
if (!function_exists('flozen_get_style_primary_color')) :

    function flozen_get_style_primary_color($color_primary = '', $return = true) {
        if (trim($color_primary) == '') {
            return '';
        }
        if ($return) {
            ob_start();
        }
        ?><style>
            /* Start override primary color =========================================== */
            body .primary-color,
            body .add-to-cart-grid .cart-icon strong,
            body .navigation-paging a,
            body .navigation-image a,
            body .logo a,
            body li.mini-cart .cart-icon strong,
            body .checkout-group h3,
            body .order-review h3,
            body .mini-cart-item .cart_list_product_price,
            body .remove:hover i,
            body .support-icon,
            body #order_review_heading,
            body .checkout-group h3,
            body a.shipping-calculator-button,
            body .widget_layered_nav li a:hover,
            body .widget_layered_nav_filters li a:hover,
            body .widget.widget_archive ul li a:hover,
            body .product_list_widget .text-info span,
            body .copyright-footer span,
            body #menu-shop-by-category li.active.menu-parent-item .nav-top-link::after,
            body .product_list_widget .product-title:hover,
            body .item-product-widget .product-meta .product-title a:hover,
            body .bread.nasa-breadcrumb-has-bg .row .breadcrumb-row a:hover,
            body .bread.nasa-breadcrumb-has-bg .columns .breadcrumb-row a:hover,
            body .group-blogs .blog_info .post-date span,
            body .header-type-1 .header-nav .nav-top-link:hover,
            body .widget_layered_nav li:hover a,
            body .widget_layered_nav_filters li:hover a,
            body .remove .pe-7s-close:hover,
            body .absolute-footer .left .copyright-footer span,
            body .service-block.style-1 .service-icon,
            body .service-block.style-2 .service-icon,
            body .service-block.style-3 .service-icon,
            body .service-block.style-4 .service-text,
            body .contact-information .contact-text strong,
            body .nav-wrapper .root-item a:hover,
            body .group-blogs .blog_info .read_more a:hover,
            body #top-bar .top-bar-nav li.color a,
            body .mini-cart .cart-icon:hover:before,
            body .absolute-footer li a:hover,
            body .nasa-recent-posts li .post-date,
            body .nasa-recent-posts .read-more a,
            body .team-member .member-details h3,
            body .shop_table .remove-product .pe-7s-close:hover,
            body .absolute-footer ul.menu li a:hover,
            body .nasa-pagination.style-1 .page-number li span.current,
            body .nasa-pagination.style-1 .page-number li a.current,
            body .nasa-pagination.style-1 .page-number li a.nasa-current,
            body .nasa-pagination.style-1 .page-number li a:hover,
            body #vertical-menu-wrapper li.root-item:hover > a,
            body .widget.woocommerce li.cat-item a.nasa-active,
            body .widget.widget_recent_entries ul li a:hover,
            body .widget.widget_recent_comments ul li a:hover,
            body .widget.widget_meta ul li a:hover,
            body .widget.widget_categories li a.nasa-active,
            body .widget.widget_archive li a.nasa-active,
            body .nasa-filter-by-cat.nasa-active,
            body .widget .nasa-tag-cloud-ul li a:hover,
            body .widget .nasa-tag-cloud-ul li a.nasa-active:hover,
            body .product-info .stock.in-stock,
            body #nasa-footer .nasa-contact-footer-custom h5,
            body #nasa-footer .nasa-contact-footer-custom h5 i,
            body .group-blogs .nasa-blog-info-slider .nasa-post-date,
            body li.menu-item.nasa-megamenu > .nav-dropdown > ul > li.menu-item a:hover,
            body .nasa-tag-cloud a.nasa-active:hover,
            body .html-text i,
            body .header-nav .active .nav-top-link,
            body ul li .nav-dropdown > ul > li:hover > a,
            body ul li .nav-dropdown > ul > li:hover > a:before,
            body ul li .nav-dropdown > ul > li .nav-column-links > ul > li a:hover,
            body ul li .nav-dropdown > ul > li .nav-column-links > ul > li:hover > a:before,
            body .topbar-menu-container ul li a:hover,
            body .header-account ul li a:hover,
            body .header-icons > li a:hover i,
            body .nasa-title span.nasa-first-word,
            body .nasa-tabs-content.nasa-slide-style .nasa-tabs li.active a h5,
            body .woocommerce-tabs.nasa-slide-style .nasa-tabs li.active a h5,
            body .nasa-sc-pdeal.nasa-sc-pdeal-block .nasa-sc-p-img .images-popups-gallery a.product-image .nasa-product-label-stock .label-stock,
            body .nasa-sc-pdeal.nasa-sc-pdeal-block .nasa-sc-p-info .nasa-sc-p-title h3 a:hover,
            body #nasa-footer .nasa-footer-contact .wpcf7-form label span.your-email:after,
            body #nasa-footer .widget_nav_menu ul li a:hover,
            body #nasa-footer .nasa-footer-bottom .widget_nav_menu ul li a:hover,
            body #nasa-footer .nasa-nav-sc-menu ul li a:hover,
            body #nasa-footer .nasa-footer-bottom .nasa-nav-sc-menu ul li a:hover,
            body .owl-carousel .owl-nav div:hover,
            body .item-product-widget.nasa-list-type-2 .product-meta .product-interactions .btn-wishlist:hover,
            body .item-product-widget.nasa-list-type-2 .product-meta .product-interactions .quick-view:hover,
            body .item-product-widget.nasa-list-type-2 .product-meta .product-title a:hover,
            body #nasa-wishlist-sidebar .wishlist_sidebar .wishlist_table tbody tr .product-wishlist-info .info-wishlist .nasa-wishlist-title a:hover,
            body #nasa-wishlist-sidebar .wishlist_sidebar .wishlist_table tbody tr .product-remove a:hover i,
            body #cart-sidebar .widget_shopping_cart_content .cart_list .mini-cart-item .mini-cart-info a:hover,
            body #cart-sidebar .widget_shopping_cart_content .cart_list .mini-cart-item .item-in-cart:hover i,
            body .nasa-table-compare tr.stock td span,
            body .nasa-wrap-table-compare .nasa-table-compare tr.stock td span,
            body .item-product-widget.nasa-list-type-extra .product-meta .product-interactions .btn-wishlist-main-list:hover .pe-icon,
            body .item-product-widget.nasa-list-type-extra .product-meta .product-interactions .btn-wishlist-main-list:hover .nasa-icon,
            body .item-product-widget.nasa-list-type-main .product-interactions .btn-wishlist:hover .pe-icon,
            body .item-product-widget.nasa-list-type-main .product-interactions .btn-wishlist:hover .nasa-icon,
            body .nasa-login-register-warper #nasa-login-register-form .nasa-switch-form a,
            body .vertical-menu-container #vertical-menu-wrapper li.root-item:hover > a,
            body .vertical-menu-container .vertical-menu-wrapper li.root-item:hover > a,
            body .vertical-menu-container #vertical-menu-wrapper li.root-item:hover > a > i,
            body .vertical-menu-container .vertical-menu-wrapper li.root-item:hover > a > i,
            body #cart-sidebar .wishlist_sidebar .wishlist_table tbody tr .product-wishlist-info .info-wishlist .add-to-cart-wishlist .button-in-wishlist:hover,
            body #nasa-wishlist-sidebar .wishlist_sidebar .wishlist_table tbody tr .product-wishlist-info .info-wishlist .add-to-cart-wishlist .button-in-wishlist:hover,
            body .product-item .product-img-wrap .nasa-product-content-nasa_label-wrap .nasa-product-content-child > a.nasa-active,
            body .nasa-compare-list-bottom .nasa-compare-mess,
            body .tparrows:hover:before,
            body .nasa-labels-filter-top .nasa-labels-filter-accordion .nasa-top-row-filter > li.nasa-active a,
            body .nasa-wrap-slick-slide-products-title .nasa-slide-products-title-item.slick-current > a,
            body .nasa-accordions-content .nasa-accordion-title a.active,
            body .widget.widget_product_categories li a:hover,
            body .widget.woocommerce.widget_product_categories li a:hover,
            body .widget.widget_product_categories li.current-cat > a,
            body .widget.woocommerce.widget_product_categories li.current-cat > a,
            body .widget.widget_product_categories li.current-cat .children a:hover,
            body .widget.woocommerce.widget_product_categories li.current-cat .children a:hover,
            body .widget li a:hover,
            body .widget.woocommerce li a:hover,
            body .nasa-products-special-deal.nasa-products-special-deal-multi-2 .nasa-list-stock-status span,
            body .product-info .variations .value .nasa-attr-ux_wrap .nasa-attr-ux.nasa-attr-ux-label.selected,
            body .nasa-add-to-cart-fixed .nasa-attr-ux-clone.nasa-attr-ux-label-clone.selected,
            body .nasa-attr-ux-item.nasa-attr-ux-nasa_label.nasa-active,
            body .nasa-attr-ux-item.nasa-attr-ux-select.nasa-active,
            body .grid-product-category .nasa-item-wrap:hover .nasa-view-more i,
            body .cart_totals .order-total td,
            body .shop_table tbody .product-subtotal,
            body #order_review .woocommerce-Price-amount,
            body .woocommerce-MyAccount-navigation.nasa-MyAccount-navigation .woocommerce-MyAccount-navigation-link a:hover:before,
            body .nasa-total-condition-desc .woocommerce-Price-amount,
            body .nasa-after-add-to-cart-subtotal-price,
            body .owl-carousel .owl-nav .owl-prev:hover:before,
            body .owl-carousel .owl-nav .owl-next:hover:before
            {
                color: <?php echo esc_attr($color_primary); ?>;
            }
            .blog_shortcode_item .blog_shortcode_text h3 a:hover,
            .main-navigation li.menu-item a:hover,
            .widget-area ul li a:hover,
            .entry-title a:hover,
            .progress-bar .bar-meter .bar-number,
            /* .product-item .info .name a:hover, */
            .wishlist_table td.product-name a:hover,
            .product_list_widget .text-info a:hover,
            .product-list .info .name:hover,
            .product-info .compare:hover,
            .product-info .compare:hover:before,
            .product-info .yith-wcwl-add-to-wishlist:hover:before,
            .product-info .yith-wcwl-add-to-wishlist:hover a,
            .product-info .yith-wcwl-add-to-wishlist:hover .feedback,
            .menu-item.nasa-megamenu > .nav-dropdown > ul > li.menu-item a:hover:before,
            #nasa-footer .widget_tag_cloud .nasa-tag-cloud a:hover,
            #nasa-footer .widget_tag_cloud .nasa-tag-cloud a.nasa-active,
            #nasa-footer .widget_tag_cloud .nasa-tag-products-cloud a:hover,
            #nasa-footer .widget_tag_cloud .nasa-tag-products-cloud a.nasa-active,
            ul.main-navigation li .nav-dropdown > ul > li .nav-column-links > ul > li a:hover,
            rev-btn.flozen-Button
            {
                color: <?php echo esc_attr($color_primary); ?> !important;
            }
            /* BACKGROUND */
            body .tabbed-content.pos_pills ul.tabs li.active a,
            body li.featured-item.style_2:hover a,
            body .nasa_hotspot,
            body .label-new.menu-item a:after,
            body .text-box-primary,
            body .navigation-paging a:hover,
            body .navigation-image a:hover,
            body .next-prev-nav .prod-dropdown > a:hover,
            body .widget_product_tag_cloud a:hover,
            body .nasa-tag-cloud a.nasa-active,
            body a.button.trans-button:hover,
            body .please-wait i,
            body .product-img .product-bg,
            body .post-item:hover .post-date,
            body .blog_shortcode_item:hover .post-date,
            body .group-slider .sliderNav a:hover,
            body .support-icon.square-round:hover,
            body .entry-header .post-date-wrapper,
            body .entry-header .post-date-wrapper:hover,
            body .widget_collapscat h3,
            body .header-nav .nav-top-link::before,
            body .sliderNav a span:hover,
            body .shop-by-category h3.section-title,
            body .custom-footer-1 .nasa-hr,
            body .widget_collapscat h2,
            body .shop-by-category h2.widgettitle,
            body .rev_slider_wrapper .type-label-2,
            body .nasa-hr.primary-color,
            body .products.list .product-interactions .yith-wcwl-add-button:hover,
            body .pagination-centered .page-numbers a:hover,
            body .pagination-centered .page-numbers span.current,
            body .cart-wishlist .mini-cart .cart-icon .products-number,
            body .load-more::before,
            body .products-arrow .next-prev-buttons .icon-next-prev:hover,
            body .widget_price_filter .ui-slider .ui-slider-handle:after,
            body .nasa-tabs-content .nasa-tabs li.active .nasa-hr,
            body .nasa-tabs-content .nasa-tabs li:hover .nasa-hr,
            body .nasa-tabs-content.nasa-classic-style.nasa-classic-2d.nasa-tab-primary-color .nasa-tabs .nasa-tab.active > a,
            body .nasa-tabs-content.nasa-classic-style.nasa-classic-2d.nasa-tab-primary-color .nasa-tabs .nasa-tab:hover > a,
            body .woocommerce-tabs .nasa-tabs li.active .nasa-hr,
            body .woocommerce-tabs .nasa-tabs li:hover .nasa-hr,
            body .collapses.active .collapses-title a:before,
            body .title-block span:after,
            body .mini-cart .products-number .nasa-sl,
            body .header-icons > li .products-number .nasa-sl,
            body .header-icons > li .wishlist-number .nasa-sl,
            body .header-icons > li .compare-number .nasa-sl,
            body .nasa-login-register-warper #nasa-login-register-form .login-register-close a:hover i:before,
            body .products-group.nasa-combo-slider .product-item.grid .nasa-product-bundle-btns .quick-view:hover,
            body .header-type-1 .nasa-header-icons-type-1 .header-icons > li.nasa-icon-mini-cart a .icon-nasa-cart-3,
            body .header-type-1 .nasa-header-icons-type-1 .header-icons > li.nasa-icon-mini-cart a:hover .icon-nasa-cart-3,
            body .header-type-1 .nasa-header-icons-type-1 .header-icons > li.nasa-icon-mini-cart a .icon-nasa-cart-3:hover:before,
            body .search-dropdown.nasa-search-style-3 .nasa-show-search-form .search-wrapper form .nasa-icon-submit-page:before,
            body .nasa-search-space.nasa-search-style-3 .nasa-show-search-form .search-wrapper form .nasa-icon-submit-page:before,
            body .product_list_widget .product-interactions .quick-view:hover,
            body #cart-sidebar.style-1 a.nasa-sidebar-return-shop:hover,
            body #nasa-wishlist-sidebar.style-1 a.nasa-sidebar-return-shop:hover,
            body .nasa-gift-featured-wrap .nasa-gift-featured-event:hover,
            body #nasa-popup .wpcf7 input[type="button"],
            body #nasa-popup .wpcf7 input[type="submit"],
            body #nasa-popup .wpcf7 input[type="button"]:hover,
            body #nasa-popup .wpcf7 input[type="submit"]:hover,
            body .nasa-products-special-deal .product-special-deals .product-deal-special-progress .deal-progress .deal-progress-bar,
            body .item-product-widget.row.nasa-list-type-1 .images .nasa-product-widget-image-wrap .product-interactions .quick-view:hover,
            body .product-item.style-2 .nasa-product-grid .product-interactions .add-to-cart-btn .add-to-cart-grid,
            body .nasa-products-special-deal.nasa-products-special-deal-multi-2 .product-item .nasa-product-grid .product-interactions .add-to-cart-btn .add-to-cart-grid,
            body .owl-carousel .owl-dots .owl-dot.active span,
            body .nasa-products-page-wrap .nasa-progress-bar-load-shop .nasa-progress-per,
            body .product-info .cart .single_add_to_cart_button:hover,
            body #nasa-footer .footer-contact .btn-submit-newsletters,
            body #nasa-footer .footer-light-2 .footer-contact .btn-submit-newsletters,
            body .easypin-marker > .nasa-marker-icon-wrap .nasa-marker-icon-bg,
            body .easypin-marker > .nasa-marker-icon-wrap .nasa-action-effect,
            body .vertical-menu.nasa-shortcode-menu .section-title,
            body .tp-bullets.custom .tp-bullet.selected,
            body #submit.small.nasa-button-banner,
            body button.small.nasa-button-banner,
            body .button.small.nasa-button-banner,
            body input[type="submit"].small.nasa-button-banner,
            body #nasa-footer .footer-light-2 .footer-contact .btn-submit-newsletters:hover,
            body .nasa-menu-vertical-header,
            body .nasa-add-to-cart-fixed .single_variation_wrap-clone .button.disabled:hover,
            body .nasa-product-stock-progress .nasa-product-stock-progress-bar,
            body .nasa-single-product-stock .nasa-product-stock-progress .nasa-product-stock-progress-bar,
            body .item-product-widget.row.nasa-list-type-1 .images .nasa-product-widget-image-wrap .product-interactions .quick-view:hover,
            body .nasa-deal-for-time,
            body .shortcode_tag_cloud .tag-cloud-link:hover,
            body .nasa-subtotal-condition,
            body .nasa-meta-categories
            {
                background-color: <?php echo esc_attr($color_primary); ?>;
            }
            body .product-item .product-img-wrap .nasa-product-grid .product-interactions .add-to-cart-btn .add-to-cart-grid .add_to_cart_text,
            body .nasa-meta-categories
            {
                color: #fff;
            }
            .button.trans-button.primary,
            button.primary-color,
            .newsletter-button-wrap .newsletter-button,
            body .nasa-static-sidebar .widget_shopping_cart_content .btn-mini-cart a,
            body .easypin-marker > .nasa-marker-icon-wrap .nasa-marker-icon-bg:hover,
            body .nasa-static-sidebar .widget_shopping_cart_content .btn-mini-cart a:hover
            {
                background-color: <?php echo esc_attr($color_primary); ?> !important;
            }
            body .search-dropdown .nasa-show-search-form .search-wrapper form select[name="product_cat"],
            body .nasa-search-space .nasa-show-search-form .search-wrapper form select[name="product_cat"]
            {
                background-image: linear-gradient(45deg, transparent 50%, <?php echo esc_attr($color_primary); ?> 50%), linear-gradient(135deg, <?php echo esc_attr($color_primary); ?> 50%, transparent 50%);
            }
            body .search-dropdown .nasa-show-search-form .search-wrapper form select[name="product_cat"]:focus,
            body .nasa-search-space .nasa-show-search-form .search-wrapper form select[name="product_cat"]:focus
            {
                background-image: linear-gradient(45deg, <?php echo esc_attr($color_primary); ?> 50%, transparent 50%), linear-gradient(135deg, transparent 50%, <?php echo esc_attr($color_primary); ?> 50%);
            }
            /* BORDER COLOR */
            body .text-bordered-primary,
            body .add-to-cart-grid.please-wait .cart-icon strong,
            body .navigation-paging a,
            body .navigation-image a,
            body .post.sticky,
            body .next-prev-nav .prod-dropdown > a:hover,
            body .iosSlider .sliderNav a:hover span,
            body .woocommerce-checkout form.login,
            body li.mini-cart .cart-icon strong,
            body .post-date,
            body .main-navigation .nav-dropdown ul,
            body .remove:hover i,
            body .support-icon.square-round:hover,
            body .widget_price_filter .ui-slider .ui-slider-handle,
            body h3.section-title span,
            body .social-icons .icon.icon_email:hover,
            body .button.trans-button.primary,
            body .seam_icon .seam,
            body .border_outner,
            body .pagination-centered .page-numbers a:hover,
            body .pagination-centered .page-numbers span.current,
            body .owl-carousel .owl-nav div:hover,
            body .products.list .product-interactions .yith-wcwl-wishlistexistsbrowse a,
            body li.menu-item.nasa-megamenu > .nav-dropdown > ul > li.menu-item.megatop > hr.hr-nasa-megamenu,
            body .owl-carousel .owl-dots .owl-dot.active span,
            body .tp-bullets.custom .tp-bullet.selected,
            body .products-arrow .next-prev-buttons .icon-next-prev:hover,
            body .search-dropdown .nasa-show-search-form .search-wrapper form .nasa-icon-submit-page,
            body .nasa-search-space .nasa-show-search-form .search-wrapper form .nasa-icon-submit-page,
            body .item-product-widget.nasa-list-type-2:hover,
            body .products-group.nasa-combo-slider .product-item.grid .nasa-product-bundle-btns .quick-view:hover,
            body .nasa-table-compare tr.stock td span,
            body .nasa-tabs-content.nasa-slide-style .nasa-tabs li.nasa-slide-tab,
            body .nasa-tabs-content.nasa-classic-style.nasa-classic-2d.nasa-tab-primary-color .nasa-tabs .nasa-tab.active > a,
            body .nasa-tabs-content.nasa-classic-style.nasa-classic-2d.nasa-tab-primary-color .nasa-tabs .nasa-tab:hover > a,
            body .woocommerce-tabs.nasa-slide-style .nasa-tabs li.nasa-slide-tab,
            body .nasa-wrap-table-compare .nasa-table-compare tr.stock td span,
            body .vertical-menu-container #vertical-menu-wrapper li.root-item:hover > a:before,
            body .vertical-menu-container .vertical-menu-wrapper li.root-item:hover > a:before,
            body .product_list_widget .product-interactions .quick-view:hover,
            body #cart-sidebar.style-1 a.nasa-sidebar-return-shop:hover,
            body #nasa-wishlist-sidebar.style-1 a.nasa-sidebar-return-shop:hover,
            body #cart-sidebar .widget_shopping_cart_content .btn-mini-cart .button,
            body .nasa-gift-featured-wrap .nasa-gift-featured-event:hover,
            body #nasa-wishlist-sidebar .wishlist_sidebar .wishlist_table tbody tr .product-wishlist-info .info-wishlist .add-to-cart-wishlist .button-in-wishlist:hover .add_to_cart_text,
            body .products.list .product-warp-item .group-btn-in-list-wrap .group-btn-in-list .product-interactions .add-to-cart-btn:hover .add-to-cart-grid .add_to_cart_text,
            body .nasa-title.hr-type-vertical .nasa-wrap,
            body .product-info .cart .single_add_to_cart_button:hover,
            body #nasa-footer .footer-contact .btn-submit-newsletters,
            body .easypin-marker > .nasa-marker-icon-wrap .nasa-marker-icon-bg,
            body .easypin-marker > .nasa-marker-icon-wrap .nasa-marker-icon,
            body .vertical-menu.nasa-shortcode-menu .section-title,
            body .nasa-products-special-deal.nasa-products-special-deal-multi-2 .nasa-main-special,
            body .nasa-slider-deal-vertical-extra-switcher.nasa-nav-4-items .item-slick.slick-current,
            body .nasa-slider-deal-vertical-extra-switcher.nasa-nav-4-items .item-slick:hover,
            body .vertical-menu-wrapper,
            body .nasa-attr-ux_wrap .nasa-attr-ux.nasa-attr-ux-color.selected,
            body .nasa-add-to-cart-fixed .nasa-attr-ux-clone.selected,
            body .nasa-attr-ux_wrap .nasa-attr-ux.selected .nasa-attr-bg-img,
            body .nasa-add-to-cart-fixed .nasa-attr-ux-clone.nasa-attr-ux-image-clone.selected .nasa-attr-bg-img,
            body .product-info .variations .value .nasa-attr-ux_wrap .nasa-attr-ux.nasa-attr-ux-label.selected,
            body .nasa-add-to-cart-fixed .nasa-attr-ux-clone.nasa-attr-ux-label-clone.selected,
            body .nasa-attr-ux-item.nasa-attr-ux-nasa_label.nasa-active,
            body .nasa-attr-ux-item.nasa-attr-ux-select.nasa-active,
            body .nasa-attr-ux-item.nasa-attr-ux-nasa_color.nasa-active,
            body .nasa-attr-ux-item.nasa-attr-ux-nasa_image.nasa-active img,
            body .nasa-marker-icon-wrap .icon-nasa-icons-plus,
            body .nasa-static-sidebar .wishlist_sidebar .wishlist_table .button-in-wishlist:hover
            {
                border-color: <?php echo esc_attr($color_primary); ?>;
            }
            .promo .sliderNav span:hover,
            .remove .pe-7s-close:hover
            {
                border-color: <?php echo esc_attr($color_primary); ?> !important;
            }
            body .tabbed-content ul.tabs li a:hover:after,
            body .tabbed-content ul.tabs li.active a:after
            {
                border-top-color: <?php echo esc_attr($color_primary); ?>;
            }
            .collapsing.categories.list li:hover,
            .please-wait,
            #menu-shop-by-category li.active
            {
                border-left-color: <?php echo esc_attr($color_primary); ?> !important;
            }
            body .nasa-slider-deal-vertical-extra-switcher.nasa-nav-4-items .item-slick.slick-current:before
            {
                border-right-color: <?php echo esc_attr($color_primary); ?>;
            }
            html body.nasa-rtl .nasa-slider-deal-vertical-extra-switcher.nasa-nav-4-items .item-slick.slick-current:after
            {
                border-left-color: <?php echo esc_attr($color_primary); ?>;
            }
            /* End Primary color =========================================== */
        </style>
        <?php
        if ($return) {
            $css = ob_get_clean();
    
            return flozen_convert_css($css);
        }
    }

endif;

/**
 * CSS override color for main menu
 */
if (!function_exists('flozen_get_style_main_menu_color')) :

    function flozen_get_style_main_menu_color($bg_color = '', $text_color = '', $text_color_hover = '', $return = true) {
        if ($bg_color == '' && $text_color == '' && $text_color_hover == '') {
            return '';
        }

        if ($return) {
            ob_start();
        }
        ?><style>
            /* Start override main menu color =========================================== */
        <?php if ($bg_color != '') :
            $color_attr = ($bg_color != '0') ? $bg_color : 'transparent';
            ?>
                body .nasa-bg-dark,
                body .header-type-3 .nasa-elements-wrap
                {
                    background-color: <?php echo esc_attr($color_attr); ?>;
                }
                <?php
            endif;

            if ($text_color != '') :
                ?>
                body .nav-wrapper .root-item > a,
                body .nav-wrapper .root-item:hover > a,
                body .nav-wrapper .root-item.current-menu-ancestor > a,
                body .nav-wrapper .root-item.current-menu-item > a,
                body .nav-wrapper .root-item:hover > a:hover,
                body .nav-wrapper .root-item.current-menu-ancestor > a:hover,
                body .nav-wrapper .root-item.current-menu-item > a:hover,
                body .nasa-bg-dark .nav-wrapper .root-item > a,
                body .nasa-bg-dark .nav-wrapper .root-item:hover > a,
                body .nasa-bg-dark .nav-wrapper .root-item.current-menu-ancestor > a,
                body .nasa-bg-dark .nav-wrapper .root-item.current-menu-item > a,
                body .header-type-3 .search-icon
                {
                    color: <?php echo esc_attr($text_color); ?>;
                }
                body .nav-wrapper .root-item > a .nasa-text-menu:after,
                body .nasa-bg-dark .nav-wrapper .root-item:hover > a .nasa-text-menu:after,
                body .nasa-bg-dark .nav-wrapper .root-item.current-menu-ancestor > a .nasa-text-menu:after,
                body .nasa-bg-dark .nav-wrapper .root-item.current-menu-item > a .nasa-text-menu:after
                {
                    border-color: <?php echo esc_attr($text_color); ?>;
                }
                <?php
            endif;

            if ($text_color_hover != '') : ?>

            <?php
        endif;
        ?>
            /* End =========================================== */
        </style>
        <?php
        if ($return) {
            $css = ob_get_clean();
    
            return flozen_convert_css($css);
        }
    }

endif;

/**
 * CSS override color for vertical menu
 */
if (!function_exists('flozen_get_style_vertical_menu_color')) :

    function flozen_get_style_vertical_menu_color($bg_color = '', $text_color = '', $text_color_hover = '', $return = true) {
        if ($bg_color == '' && $text_color == '' && $text_color_hover == '') {
            return '';
        }

        if ($return) {
            ob_start();
        }
        ?><style>
            /* Start override main menu color =========================================== */
        <?php if ($bg_color != '') :
            $color_attr = ($bg_color != '0') ? $bg_color : 'transparent';
            ?>
                body .header-type-3 .nasa-menu-vertical-header
                {
                    background-color: <?php echo esc_attr($color_attr); ?>;
                }
                body .header-type-3 .vertical-menu-wrapper
                {
                    border-color: <?php echo esc_attr($color_attr); ?>;
                }
                <?php
            endif;

            if ($text_color != '') :
                ?>
                body .nasa-vertical-header.vertical-menu .section-title
                {
                    color: <?php echo esc_attr($text_color); ?>;
                }
                <?php
            endif;

            if ($text_color_hover != '') : ?>

            <?php
        endif;
        ?>
            /* End =========================================== */
        </style>
        <?php
        if ($return) {
            $css = ob_get_clean();
    
            return flozen_convert_css($css);
        }
    }

endif;

/**
 * CSS override color for header
 */
if (!function_exists('flozen_get_style_header_color')) :

    function flozen_get_style_header_color($bg_color = '', $text_color = '', $text_color_hover = '', $return = true) {
        if ($bg_color == '' && $text_color == '' && $text_color_hover == '') {
            return '';
        }

        if ($return) {
            ob_start();
        }
        ?><style>
            /* Start override header color =========================================== */
            <?php if ($bg_color != '') : ?>
                body #masthead
                {
                    background-color: <?php echo esc_attr($bg_color); ?>;
                }
            <?php
        endif;

        if ($text_color != '') :
            ?>
                body #masthead .header-icons > li a
                {
                    color: <?php echo esc_attr($text_color); ?>;
                }
                body .header-type-1 #masthead .nasa-header-icons-type-1 .header-icons > li .mini-cart .products-number span
                {
                    color: <?php echo esc_attr($text_color); ?> !important;
                }
                <?php
            endif;

            if ($text_color_hover != '') :
                ?>
                body #masthead .header-icons > li a:hover i,
                body #masthead .mini-cart .cart-icon:hover:before
                {
                    color: <?php echo esc_attr($text_color_hover); ?>;
                }
            <?php
        endif;
        ?>
            /* End =========================================== */
        </style>
        <?php
        if ($return) {
            $css = ob_get_clean();
    
            return flozen_convert_css($css);
        }
    }

endif;

/**
 * CSS override color for TOP BAR
 */
if (!function_exists('flozen_get_style_topbar_color')) :

    function flozen_get_style_topbar_color($bg_color = '', $text_color = '', $text_color_hover = '', $return = true) {
        if ($bg_color == '' && $text_color == '' && $text_color_hover == '') {
            return '';
        }

        if ($return) {
            ob_start();
        }
        ?><style>
            /* Start override topbar color =========================================== */
            <?php if ($bg_color != '') : ?>
                body #top-bar,
                body .nasa-topbar-wrap.nasa-topbar-toggle .nasa-icon-toggle
                {
                    background-color: <?php echo esc_attr($bg_color); ?>;
                }
                body #top-bar,
                body .nasa-topbar-wrap.nasa-topbar-toggle .nasa-icon-toggle
                {
                    border-color: <?php echo esc_attr($bg_color); ?>;
                }
            <?php
        endif;

        if ($text_color != '') :
            ?>
                body #top-bar,
                body #top-bar .topbar-menu-container ul li a,
                body #top-bar .left-text,
                body .nasa-topbar-wrap.nasa-topbar-toggle .nasa-icon-toggle
                {
                    color: <?php echo esc_attr($text_color); ?>;
                }
                <?php
            endif;

            if ($text_color_hover != '') :
                ?>
                body #top-bar .topbar-menu-container ul li a:hover,
                body .nasa-topbar-wrap.nasa-topbar-toggle .nasa-icon-toggle:hover
                {
                    color: <?php echo esc_attr($text_color_hover); ?>;
                }
            <?php
        endif;
        ?>
            /* End =========================================== */
        </style>
        <?php
        if ($return) {
            $css = ob_get_clean();
    
            return flozen_convert_css($css);
        }
    }

endif;

/**
 * CSS override Add more width site
 */
if (!function_exists('flozen_get_style_plus_wide_width')) :

    function flozen_get_style_plus_wide_width($max_width = '', $return = true) {
        if ($max_width == '') {
            return '';
        }

        if ($return) {
            ob_start();
        }
        ?><style>
            /* Start override topbar color =========================================== */
            <?php if ($max_width != '') : ?>
                html body .row,
                html body.boxed #wrapper,
                html body .nav-wrapper .menu-item.nasa-megamenu.fullwidth > .nav-dropdown > ul,
                html body.boxed .nav-wrapper .menu-item.nasa-megamenu.fullwidth > .nav-dropdown > ul,
                body .nasa-add-to-cart-fixed .nasa-wrap-content-inner
                {
                    max-width: <?php echo flozen_str($max_width); ?>px;
                }
                html body .nav-wrapper .menu-item.nasa-megamenu.fullwidth > .nav-dropdown,
                html body.boxed .nav-wrapper .menu-item.nasa-megamenu.fullwidth > .nav-dropdown
                {
                    left: -<?php echo flozen_str((5402 - $max_width) / 2); ?>px;
                }
                @media all and (min-width: 1200px) and (max-width: <?php echo flozen_str($max_width); ?>px) {
                    html body .nav-wrapper .menu-item.nasa-megamenu.fullwidth > .nav-dropdown,
                    html body.boxed .nav-wrapper .menu-item.nasa-megamenu.fullwidth > .nav-dropdown
                    {
                        max-width: <?php echo flozen_str($max_width); ?>px;
                        width: auto;
                        left: 0;
                        right: 0;
                    }
                }
            <?php endif; ?>
            /* End =========================================== */
        </style>
        <?php
        if ($return) {
            $css = ob_get_clean();
    
            return flozen_convert_css($css);
        }
    }

endif;

// **********************************************************************// 
// ! Dynamic - css
// **********************************************************************//
add_action('wp_enqueue_scripts', 'flozen_add_dynamic_css', 999);
if (!function_exists('flozen_add_dynamic_css')) :

    function flozen_add_dynamic_css() {
        global $nasa_upload_dir;
        
        $upload_dir = !isset($nasa_upload_dir) ? wp_upload_dir() : $nasa_upload_dir;
        $dynamic_path = $upload_dir['basedir'] . '/nasa-dynamic';
        
        if (is_file($dynamic_path . '/dynamic.css')) {
            global $nasa_opt;
            $version = isset($nasa_opt['nasa_dynamic_t']) ? $nasa_opt['nasa_dynamic_t'] : null;
            
            // Dynamic Css
            wp_enqueue_style('flozen-style-dynamic', flozen_remove_protocol($upload_dir['baseurl']) . '/nasa-dynamic/dynamic.css', array('flozen-style'), $version, 'all');
        }
    }

endif;

// **********************************************************************// 
// ! Dynamic - Page override primary color - css
// **********************************************************************//
add_action('wp_enqueue_scripts', 'flozen_page_override_style', 1000);
if (!function_exists('flozen_page_override_style')) :

    function flozen_page_override_style() {
        if (!wp_style_is('flozen-style-dynamic')) {
            return;
        }

        global $wp_query, $nasa_opt, $content_width;
        $objectId = $wp_query->get_queried_object_id();
        $dinamic_css = '';
        if ('page' === get_post_type() && $objectId) {

            /**
             * color_primary
             */
            $flag_override_color = get_post_meta($objectId, '_nasa_pri_color_flag', true);
            $color_primary_css = $page_css = '';
            if ($flag_override_color) :
                $color_primary = get_post_meta($objectId, '_nasa_pri_color', true);
                $color_primary_css = $color_primary ? flozen_get_style_primary_color($color_primary) : '';
            endif;

            /**
             * color for header
             */
            $bg_color = get_post_meta($objectId, '_nasa_bg_color_header', true);
            $text_color = get_post_meta($objectId, '_nasa_text_color_header', true);
            $text_color_hover = get_post_meta($objectId, '_nasa_text_color_hover_header', true);
            $page_css .= flozen_get_style_header_color($bg_color, $text_color, $text_color_hover);

            /**
             * color for top bar
             */
            if (!isset($nasa_opt['topbar_show']) || $nasa_opt['topbar_show']) {
                $bg_color = get_post_meta($objectId, '_nasa_bg_color_topbar', true);
                $text_color = get_post_meta($objectId, '_nasa_text_color_topbar', true);
                $text_color_hover = get_post_meta($objectId, '_nasa_text_color_hover_topbar', true);
                $page_css .= flozen_get_style_topbar_color($bg_color, $text_color, $text_color_hover);
            }

            /**
             * color for main menu
             */
            $bg_color = get_post_meta($objectId, '_nasa_bg_color_main_menu', true);
            $text_color = get_post_meta($objectId, '_nasa_text_color_main_menu', true);
            $text_color_hover = get_post_meta($objectId, '_nasa_text_color_hover_main_menu', true);
            $page_css .= flozen_get_style_main_menu_color($bg_color, $text_color, $text_color_hover);
            
            /**
             * color for Vertical menu
             */
            $bg_color = get_post_meta($objectId, '_nasa_bg_color_vertical_menu', true);
            $text_color = get_post_meta($objectId, '_nasa_text_color_vertical_menu', true);
            $text_color_hover = get_post_meta($objectId, '_nasa_text_color_hover_vertical_menu', true);
            $page_css .= flozen_get_style_vertical_menu_color($bg_color, $text_color, $text_color_hover);

            /**
             * Add width to site
             */
            $max_width = '';
            $plus_option = get_post_meta($objectId, '_nasa_plus_wide_option', true);
            switch ($plus_option) {
                case '1':
                    $plus_width = get_post_meta($objectId, '_nasa_plus_wide_width', true);
                    break;

                case '-1':
                    $plus_width = 0;
                    break;

                case '':
                default :
                    $plus_width = '';
                    break;
            }
            if($plus_width !== '' && (int) $plus_width >= 0) {
                $content_width = !isset($content_width) ? 1200 : $content_width;
                $max_width = ($content_width + (int) $plus_width);
            }
            $page_css .= flozen_get_style_plus_wide_width($max_width);

            $dinamic_css = $color_primary_css . $page_css;
        }
        
        /**
         * Override primary color for root category product
         */
        else {
            $current_cat = null;
            $is_product_cat = $is_product = false;
            if (NASA_WOO_ACTIVED) {
                $is_product_cat = is_product_category();
                $is_product = is_product();
            }
            
            $rootCatId = 0;
            if($is_product) {
                global $post;
                $product_cats = get_the_terms($post->ID, 'product_cat');
                if ($product_cats) {
                    foreach ($product_cats as $cat) {
                        $current_cat = $cat;
                        if ($cat->parent == 0) {
                            break;
                        }
                    }
                }
            }
            elseif($is_product_cat) {
                $current_cat = $wp_query->get_queried_object();
            }

            if($current_cat && isset($current_cat->term_id)) {
                if(isset($current_cat->parent) && $current_cat->parent == 0) {
                    $rootCatId = $current_cat->term_id;
                } else {
                    $ancestors = get_ancestors($current_cat->term_id, 'product_cat');
                    $rootCatId = end($ancestors);
                }
            }
            
            if($rootCatId) {
                $cat_color = get_term_meta($rootCatId, 'cat_primary_color');
                $color_primary = isset($cat_color[0]) && $cat_color[0] ? $cat_color[0] : '';
                $dinamic_css = $color_primary ? flozen_get_style_primary_color($color_primary) : '';
            }
        }
        
        /**
         * Css inline override
         */
        if ($dinamic_css != '') {
            wp_add_inline_style('flozen-style-dynamic', $dinamic_css);
        }
    }

endif;
