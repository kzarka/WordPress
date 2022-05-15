<?php
if (!function_exists('flozen_breadcrumb_heading')) {
    add_action('init', 'flozen_breadcrumb_heading');
    function flozen_breadcrumb_heading() {
        /* ----------------------------------------------------------------------------------- */
        /* The Options Array */
        /* ----------------------------------------------------------------------------------- */
        // Set the Options Array
        global $of_options;
        if(empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("Breadcrumb", 'flozen-theme'),
            "target" => 'breadcumb',
            "type" => "heading"
        );

        $of_options[] = array(
            "name" => esc_html__("Show breadcrumb", 'flozen-theme'),
            "desc" => esc_html__("Show breadcrumb", 'flozen-theme'),
            "id" => "breadcrumb_show",
            "std" => 1,
            "type" => "switch",
            'class' => 'nasa-breadcrumb-flag-option'
        );

        $of_options[] = array(
            "name" => esc_html__("Breadcrumb type", 'flozen-theme'),
            "id" => "breadcrumb_type",
            "std" => "default",
            "type" => "select",
            "options" => array(
                "default" => esc_html__("Without Background", 'flozen-theme'),
                "has-background" => esc_html__("With Background", 'flozen-theme')
            ),
            'class' => 'hidden-tag nasa-breadcrumb-type-option'
        );

        $of_options[] = array(
            "name" => esc_html__("Background image", 'flozen-theme'),
            "id" => "breadcrumb_bg",
            "std" => FLOZEN_ADMIN_DIR_URI . 'assets/images/breadcrumb-bg.jpg',
            "type" => "media",
            'class' => 'hidden-tag nasa-breadcrumb-bg-option'
        );
        
        /*
        $of_options[] = array(
            "name" => esc_html__("Parallax", 'flozen-theme'),
            "id" => "breadcrumb_bg_lax",
            "std" => 1,
            "type" => "switch",
            'class' => 'hidden-tag nasa-breadcrumb-bg-lax'
        ); */

        $of_options[] = array(
            "name" => esc_html__("Background color", 'flozen-theme'),
            "id" => "breadcrumb_bg_color",
            "std" => "",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Text Color", 'flozen-theme'),
            "id" => "breadcrumb_color",
            "std" => "",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Text Align", 'flozen-theme'),
            "id" => "breadcrumb_align",
            "std" => "text-center",
            "type" => "select",
            "options" => array(
                "text-center" => esc_html__("Center", 'flozen-theme'),
                "text-left" => esc_html__("Left", 'flozen-theme'),
                "text-right" => esc_html__("Right", 'flozen-theme')
            ),
            'class' => 'hidden-tag nasa-breadcrumb-align-option'
        );

        $of_options[] = array(
            "name" => esc_html__("Height (px)", 'flozen-theme'),
            "id" => "breadcrumb_height",
            "std" => "",
            "type" => "text"
        );
    }
}
