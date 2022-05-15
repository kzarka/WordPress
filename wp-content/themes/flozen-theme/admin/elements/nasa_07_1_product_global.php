<?php
if (!function_exists('flozen_product_global_heading')) {
    add_action('init', 'flozen_product_global_heading');
    function flozen_product_global_heading() {
        /* ----------------------------------------------------------------------------------- */
        /* The Options Array */
        /* ----------------------------------------------------------------------------------- */
        // Set the Options Array
        global $of_options;
        if(empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("Product Global Options", 'flozen-theme'),
            "target" => 'product-global',
            "type" => "heading",
        );
        
        $of_options[] = array(
            "name" => esc_html__("Hover Product Grid effect", 'flozen-theme'),
            "id" => "animated_products",
            "std" => "hover-fade",
            "type" => "select",
            "options" => array(
                "hover-fade" => esc_html__("Fade", 'flozen-theme'),
                "hover-flip" => esc_html__("Flip Horizontal", 'flozen-theme'),
                "hover-bottom-to-top" => esc_html__("Bottom to top", 'flozen-theme'),
                "" => esc_html__("No effect", 'flozen-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Grid Product Layout", 'flozen-theme'),
            "id" => "loop_product_layout",
            "std" => "style-1",
            "type" => "select",
            "options" => array(
                "style-1" => esc_html__("Default", 'flozen-theme'),
                "style-2" => esc_html__("Style 2", 'flozen-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Text Center for Product Grid", 'flozen-theme'),
            "id" => "text_center_product",
            "std" => "1",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Categories In Grid", 'flozen-theme'),
            "id" => "grid_product_cat",
            "std" => "0",
            "type" => "switch"
        );

        $of_options[] = array(
            "name" => esc_html__("Catalog Mode", 'flozen-theme'),
            "id" => "disable-cart",
            "std" => "0",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Popup Your Order After Add to Cart", 'flozen-theme'),
            "id" => "after-add-to-cart",
            "std" => "0",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Icon Mini Cart in Header", 'flozen-theme'),
            "id" => "mini-cart-icon",
            "std" => "3",
            "type" => "images",
            "options" => array(
                // icon-nasa-cart-4 - default
                '3' => FLOZEN_ADMIN_DIR_URI . 'assets/images/mini-cart-3.jpg',
                // icon-nasa-cart-3
                '1' => FLOZEN_ADMIN_DIR_URI . 'assets/images/mini-cart-1.jpg',
                // icon-nasa-cart-2
                '2' => FLOZEN_ADMIN_DIR_URI . 'assets/images/mini-cart-2.jpg',
                // pe-7s-cart
                '4' => FLOZEN_ADMIN_DIR_URI . 'assets/images/mini-cart-4.jpg',
                // fa fa-shopping-cart
                '5' => FLOZEN_ADMIN_DIR_URI . 'assets/images/mini-cart-5.jpg',
                // fa fa-shopping-bag
                '6' => FLOZEN_ADMIN_DIR_URI . 'assets/images/mini-cart-6.jpg',
                // fa fa-shopping-basket
                '7' => FLOZEN_ADMIN_DIR_URI . 'assets/images/mini-cart-7.jpg'
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Icon Add To Cart in Grid", 'flozen-theme'),
            "id" => "cart-icon-grid",
            "std" => "2",
            "type" => "images",
            "options" => array(
                // icon-nasa-cart-3 - default
                '2' => FLOZEN_ADMIN_DIR_URI . 'assets/images/mini-cart-1.jpg',
                // pe-7s-cart
                '1' => FLOZEN_ADMIN_DIR_URI . 'assets/images/mini-cart-4.jpg',
                // icon-nasa-cart-2
                '3' => FLOZEN_ADMIN_DIR_URI . 'assets/images/mini-cart-2.jpg',
                // icon-nasa-cart-4
                '4' => FLOZEN_ADMIN_DIR_URI . 'assets/images/mini-cart-3.jpg',
                // fa fa-shopping-cart
                '5' => FLOZEN_ADMIN_DIR_URI . 'assets/images/mini-cart-5.jpg',
                // fa fa-shopping-bag
                '6' => FLOZEN_ADMIN_DIR_URI . 'assets/images/mini-cart-6.jpg',
                // fa fa-shopping-basket
                '7' => FLOZEN_ADMIN_DIR_URI . 'assets/images/mini-cart-7.jpg',
                // fa fa-plus
                '8' => FLOZEN_ADMIN_DIR_URI . 'assets/images/cart-plus.jpg',
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Hide quickview icon in loop products", 'flozen-theme'),
            "id" => "disable-quickview",
            "desc" => esc_html__("Yes, Please!", 'flozen-theme'),
            "std" => "0",
            "type" => "checkbox"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Style Quickview", 'flozen-theme'),
            "id" => "style_quickview",
            "std" => "sidebar",
            "type" => "select",
            "options" => array(
                'popup' => esc_html__('Popup Classical', 'flozen-theme'),
                'sidebar' => esc_html__('Sidebar holder', 'flozen-theme')
            ),
            
            'class' => 'nasa-theme-option-parent'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Number Show Quickview Thumbnail", 'flozen-theme'),
            "id" => "quick_view_item_thumb",
            "std" => "1-item",
            "type" => "select",
            "options" => array(
                '1-item' => esc_html__('Single Thumbnail', 'flozen-theme'),
                '2-items' => esc_html__('Double Thumbnails', 'flozen-theme')
            ),
            
            'class' => 'nasa-style_quickview nasa-style_quickview-sidebar nasa-theme-option-child'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Style cart sidebar", 'flozen-theme'),
            "id" => "style-cart",
            "std" => "style-1",
            "type" => "select",
            "options" => array(
                'style-1' => esc_html__('Light', 'flozen-theme'),
                'style-2' => esc_html__('Dark', 'flozen-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Style wishlist sidebar", 'flozen-theme'),
            "id" => "style-wishlist",
            "std" => "style-1",
            "type" => "select",
            "options" => array(
                'style-1' => esc_html__('Light', 'flozen-theme'),
                'style-2' => esc_html__('Dark', 'flozen-theme')
            )
        );
        
        if(defined('YITH_WCPB')) {
            // Enable Gift in grid
            $of_options[] = array(
                "name" => esc_html__("Promotion Gifts featured icon", 'flozen-theme'),
                "id" => "enable_gift_featured",
                "std" => 1,
                "type" => "switch"
            );

            // Enable effect Gift featured
            $of_options[] = array(
                "name" => esc_html__("Promotion Gifts effect featured icon", 'flozen-theme'),
                "id" => "enable_gift_effect",
                "std" => 0,
                "type" => "switch"
            );
        }

        // Options live search products
        $of_options[] = array(
            "name" => esc_html__("Live search products", 'flozen-theme'),
            "id" => "enable_live_search",
            "std" => 1,
            "type" => "switch"
        );
        
        // limit_results_search
        $of_options[] = array(
            "name" => esc_html__("Limit of Results Ajax search products", 'flozen-theme'),
            "id" => "limit_results_search",
            "std" => "5",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Suggested keywords", 'flozen-theme'),
            "desc" => 'Please input the Suggested keywords (ex: Accessories, Car, Technology)',
            "id" => "hotkeys_search",
            "std" => '',
            "type" => "textarea"
        );
        // End Options live search products
        
        $of_options[] = array(
            "name" => esc_html__("Ajax Shop", 'flozen-theme'),
            "id" => "shop_ajax_product",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Disable ajax Shop Progress bar loading", 'flozen-theme'),
            "id" => "disable_ajax_product_progress_bar",
            "desc" => esc_html__("Yes, Please!", 'flozen-theme'),
            "std" => 0,
            "type" => "checkbox"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Disable top level of categories follow current category archive (Use for Multi stores)", 'flozen-theme'),
            "desc" => esc_html__("Yes, Please!", 'flozen-theme'),
            "id" => "disable_top_level_cat",
            "std" => 0,
            "type" => "checkbox"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Show Uncategorized", 'flozen-theme'),
            "id" => "show_uncategorized",
            "desc" => esc_html__("Show Uncategorized", 'flozen-theme'),
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Disable Viewed products", 'flozen-theme'),
            "id" => "disable-viewed",
            "desc" => esc_html__("Yes, Please!", 'flozen-theme'),
            "std" => 0,
            "type" => "checkbox"
        );
        
        // limit_product_viewed
        $of_options[] = array(
            "name" => esc_html__("Limit of Viewed products", 'flozen-theme'),
            "id" => "limit_product_viewed",
            "std" => "12",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Style viewed icon", 'flozen-theme'),
            "id" => "style-viewed-icon",
            "std" => "style-1",
            "type" => "select",
            "options" => array(
                'style-1' => esc_html__('Light', 'flozen-theme'),
                'style-2' => esc_html__('Dark', 'flozen-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Style viewed sidebar", 'flozen-theme'),
            "id" => "style-viewed",
            "std" => "style-1",
            "type" => "select",
            "options" => array(
                'style-1' => esc_html__('Light', 'flozen-theme'),
                'style-2' => esc_html__('Dark', 'flozen-theme')
            )
        );
    }
}
