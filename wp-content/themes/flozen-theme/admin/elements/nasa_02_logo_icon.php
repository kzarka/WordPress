<?php
if (!function_exists('flozen_logo_icon_heading')) {
    add_action('init', 'flozen_logo_icon_heading');
    function flozen_logo_icon_heading() {
        /* ----------------------------------------------------------------------------------- */
        /* The Options Array */
        /* ----------------------------------------------------------------------------------- */
        // Set the Options Array
        global $of_options;
        if(empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("Logo and Favicon", 'flozen-theme'),
            "target" => 'logo-icons',
            "type" => "heading"
        );

        $of_options[] = array(
            "name" => esc_html__("Logo", 'flozen-theme'),
            "id" => "site_logo",
            "std" => FLOZEN_THEME_URI . "/assets/images/logo.png",
            "type" => "media"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Retina Logo", 'flozen-theme'),
            "id" => "site_logo_retina",
            "std" => FLOZEN_THEME_URI . "/assets/images/logo-retina.png",
            "type" => "media"
        );

        $of_options[] = array(
            "name" => esc_html__("Max height logo", 'flozen-theme'),
            "id" => "max_height_logo",
            "std" => "40px",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Max height logo in Mobile", 'flozen-theme'),
            "id" => "max_height_mobile_logo",
            "std" => "25px",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Max height logo in header Sticky", 'flozen-theme'),
            "id" => "max_height_sticky_logo",
            "std" => "25px",
            "type" => "text"
        );

        $of_options[] = array(
            "name" => esc_html__("Favicon", 'flozen-theme'),
            "desc" => esc_html__("Add your custom Favicon image. 16x16 32x32 64x64 .ico or .png required. (Recommend 16x16 *.ico)", 'flozen-theme'),
            "id" => "site_favicon",
            "std" => "",
            "type" => "media"
        );
    }
}
