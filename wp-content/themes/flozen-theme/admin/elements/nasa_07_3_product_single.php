<?php
if (!function_exists('flozen_product_detail_heading')) {
    add_action('init', 'flozen_product_detail_heading');
    function flozen_product_detail_heading() {
        /* ----------------------------------------------------------------------------------- */
        /* The Options Array */
        /* ----------------------------------------------------------------------------------- */
        // Set the Options Array
        global $of_options;
        if(empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("Single Product Page", 'flozen-theme'),
            "target" => 'product-detail',
            "type" => "heading",
        );
        
        $of_options[] = array(
            "name" => esc_html__("Single Product Layout", 'flozen-theme'),
            "id" => "product_detail_layout",
            "std" => "new",
            "type" => "select",
            "options" => array(
                "new" => esc_html__("New layout (sidebar - holder)", 'flozen-theme'),
                "classic" => esc_html__("Classic layout (Sidebar - columns)", 'flozen-theme')
            ),
            
            'class' => 'nasa-theme-option-parent'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Images style show", 'flozen-theme'),
            "id" => "product_image_style",
            "std" => "scroll",
            "type" => "select",
            "options" => array(
                "scroll" => esc_html__("Scroll images", 'flozen-theme'),
                "slide" => esc_html__("Slide images", 'flozen-theme')
            ),
            
            'class' => 'nasa-theme-option-child nasa-theme-option-parent nasa-product_detail_layout nasa-product_detail_layout-new'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Thumbnail Layout", 'flozen-theme'),
            "id" => "product_thumbs_style",
            "std" => "ver",
            "type" => "select",
            "options" => array(
                "ver" => esc_html__("Vertical", 'flozen-theme'),
                "hoz" => esc_html__("Horizontal", 'flozen-theme')
            ),
            
            'class' => 'nasa-theme-option-child nasa-product_detail_layout nasa-product_detail_layout-classic'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Images number show", 'flozen-theme'),
            "id" => "product_image_layout",
            "std" => "single",
            "type" => "select",
            "options" => array(
                "double" => esc_html__("Double images", 'flozen-theme'),
                "single" => esc_html__("Single image", 'flozen-theme')
            ),
            
            'class' => 'nasa-theme-option-child nasa-product_detail_layout nasa-product_detail_layout-new nasa-product_image_style nasa-product_image_style-scroll'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Hover Zoom Image", 'flozen-theme'),
            "id" => "product-zoom",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Lightbox Image", 'flozen-theme'),
            "id" => "product-image-lightbox",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Focus Main Image After change variation", 'flozen-theme'),
            "id" => "enable_focus_main_image",
            "std" => "0",
            "type" => "switch"
        );

        $of_options[] = array(
            "name" => esc_html__("Product Sidebar", 'flozen-theme'),
            "id" => "product_sidebar",
            "std" => "left",
            "type" => "select",
            "options" => array(
                "left" => esc_html__("Left Sidebar", 'flozen-theme'),
                "right" => esc_html__("Right Sidebar", 'flozen-theme'),
                "no" => esc_html__("No sidebar", 'flozen-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Deal Time", 'flozen-theme'),
            "id" => "single-product-deal",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Buy Now", 'flozen-theme'),
            "id" => "enable_buy_now",
            "std" => "1",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Buy Now Background Color", 'flozen-theme'),
            "id" => "buy_now_bg_color",
            "std" => "",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Buy Now Background Color Hover", 'flozen-theme'),
            "id" => "buy_now_bg_color_hover",
            "std" => "",
            "type" => "color"
        );
        
        $options = array(
            "no" => esc_html__("Not Show", 'flozen-theme'),
            "ext" => esc_html__("Extends Desktop", 'flozen-theme')
        );
        
        if (class_exists('Nasa_Mobile_Detect')) {
            $options['btn'] = esc_html__("Only Show Buttons", 'flozen-theme');
        }
        
        $of_options[] = array(
            "name" => esc_html__("Sticky Add To Cart", 'flozen-theme'),
            "id" => "enable_fixed_add_to_cart",
            "std" => "0",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Sticky Add To Cart In Mobile", 'flozen-theme'),
            "id" => "mobile_fixed_add_to_cart",
            "std" => "no",
            "type" => "select",
            "options" => $options
        );
        
        $of_options[] = array(
            "name" => esc_html__("Stock Progress Bar", 'flozen-theme'),
            "id" => "enable_progess_stock",
            "std" => "1",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Technical Specifications", 'flozen-theme'),
            "id" => "enable_specifications",
            "std" => "1",
            "type" => "switch"
        );

        $of_options[] = array(
            "name" => esc_html__("Show the Specifications in the Desciption tab", 'flozen-theme'),
            "id" => "merge_specifi_to_desc",
            "std" => "1",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Tabs style", 'flozen-theme'),
            "id" => "tab_style_info",
            "std" => "2d-no-border",
            "type" => "select",
            "options" => array(
                "2d-no-border" => esc_html__("Classic 2D - No border", 'flozen-theme'),
                "2d" => esc_html__("Classic 2D", 'flozen-theme'),
                "3d" => esc_html__("Classic 3D", 'flozen-theme'),
                "slide" => esc_html__("Slide", 'flozen-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Tabs align", 'flozen-theme'),
            "id" => "tab_align_info",
            "std" => "center",
            "type" => "select",
            "options" => array(
                "center" => esc_html__("Center", 'flozen-theme'),
                "left" => esc_html__("Left", 'flozen-theme'),
                "right" => esc_html__("Right", 'flozen-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Number for relate products", 'flozen-theme'),
            "id" => "release_product_number",
            "std" => "12",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Columns Relate | Upsell Products", 'flozen-theme'),
            "id" => "relate_columns_desk",
            "std" => "5-cols",
            "type" => "select",
            "options" => array(
                "3-cols" => esc_html__("3 columns", 'flozen-theme'),
                "4-cols" => esc_html__("4 columns", 'flozen-theme'),
                "5-cols" => esc_html__("5 columns", 'flozen-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Columns Relate | Upsell Products for Mobile", 'flozen-theme'),
            "id" => "relate_columns_small",
            "std" => "2-cols",
            "type" => "select",
            "options" => array(
                "1-cols" => esc_html__("1 column", 'flozen-theme'),
                "2-cols" => esc_html__("2 columns", 'flozen-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Columns Relate | Upsell Products for Tablet", 'flozen-theme'),
            "id" => "relate_columns_tablet",
            "std" => "3-cols",
            "type" => "select",
            "options" => array(
                "1-col" => esc_html__("1 column", 'flozen-theme'),
                "2-cols" => esc_html__("2 columns", 'flozen-theme'),
                "3-cols" => esc_html__("3 columns", 'flozen-theme')
            )
        );
        
        // Enable AJAX add to cart buttons on Detail OR Quickview
        $of_options[] = array(
            "name" => esc_html__("Enable AJAX add to cart button on Detail And Quickview", 'flozen-theme'),
            "id" => "enable_ajax_addtocart",
            "std" => "1",
            "type" => "switch",
            "desc" => '<span class="nasa-warning red-color">' . esc_html__('Note: Consider disabling this feature if you are using a third-party plugin developed for the Add to Cart feature in the Single Product Page!', 'flozen-theme') . '</span>'
        );
        
        $of_options[] = array(
            "name" => esc_html__('Mobile Layout', 'flozen-theme'),
            "desc" => esc_html__('Note: Mobile layout for single product pages will hide all widgets and sidebar to increase performance.', 'flozen-theme'),
            "id" => "single_product_mobile",
            "std" => 0,
            "type" => "switch"
        );
    }
}
