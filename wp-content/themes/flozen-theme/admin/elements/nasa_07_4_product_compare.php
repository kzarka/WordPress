<?php
if (!function_exists('flozen_product_compare_heading')) {
    add_action('init', 'flozen_product_compare_heading');
    function flozen_product_compare_heading() {
        /* ----------------------------------------------------------------------------------- */
        /* The Options Array */
        /* ----------------------------------------------------------------------------------- */
        // Set the Options Array
        global $of_options;
        if(empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("Compare and Wishlist", 'flozen-theme'),
            "target" => 'product-compare-wishlist',
            "type" => "heading",
        );
        
        global $yith_woocompare;
        if($yith_woocompare) {
            $of_options[] = array(
                "name" => esc_html__("Nasa compare products Extends Yith Plugin Compare", 'flozen-theme'),
                "id" => "nasa-product-compare",
                "std" => 1,
                "type" => "switch"
            );
            
            $of_options[] = array(
                "name" => esc_html__("Page view compare products", 'flozen-theme'),
                "id" => "nasa-page-view-compage",
                "type" => "select",
                "options" => flozen_pages_temp_compare()
            );

            $of_options[] = array(
                "name" => esc_html__("Max products compare", 'flozen-theme'),
                "id" => "max_compare",
                "std" => "4",
                "type" => "select",
                "options" => array("2" => "2", "3" => "3", "4" => "4")
            );
        } else {
            $of_options[] = array(
                "name" => esc_html__("Install Yith Plugin Compare, Please", 'flozen-theme'),
                "std" => '<h4 style="color: red">' . esc_html__("Please, Install Yith Plugin Compare!", 'flozen-theme') . "</h4>",
                "type" => "info"
            );
        }
        
        /**
         * Wishlist
         */
        $of_options[] = array(
            "name" => esc_html__("Wishlist Options", 'flozen-theme'),
            "std" => "<h4>" . esc_html__("Wishlist Options", 'flozen-theme') . "</h4>",
            "type" => "info"
        );
        
        if (NASA_WISHLIST_ENABLE) {
            $of_options[] = array(
                "name" => esc_html__("Optimize Yith Wishlist HTML", 'flozen-theme'),
                "id" => "optimize_wishlist_html",
                "std" => 1,
                "type" => "switch"
            );
        }
        
        /**
         * Nasa Wishlist
         */
        else {
            $of_options[] = array(
                "name" => esc_html__("NasaTheme Wishlist Feature", 'flozen-theme'),
                "id" => "enable_nasa_wishlist",
                "std" => 1,
                "type" => "switch"
            );
        }
    }
}
