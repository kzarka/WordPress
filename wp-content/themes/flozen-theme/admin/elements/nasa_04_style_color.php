<?php
if (!function_exists('flozen_style_color_heading')) {
    add_action('init', 'flozen_style_color_heading');
    function flozen_style_color_heading() {
        /* ----------------------------------------------------------------------------------- */
        /* The Options Array */
        /* ----------------------------------------------------------------------------------- */
        // Set the Options Array
        global $of_options;
        if(empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("Style and Colors", 'flozen-theme'),
            "target" => 'style-color',
            "type" => "heading",
        );

        $of_options[] = array(
            "name" => esc_html__("Style and Colors Global Option", 'flozen-theme'),
            "std" => "<h4>" . esc_html__("Style and Colors Global Option", 'flozen-theme') . "</h4>",
            "type" => "info"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Primary Color", 'flozen-theme'),
            "desc" => esc_html__("Change primary color. Used for primary buttons, link hover, background, etc.", 'flozen-theme'),
            "id" => "color_primary",
            "std" => "",
            "type" => "color"
        );

        $of_options[] = array(
            "name" => esc_html__("Secondary Color", 'flozen-theme'),
            "id" => "color_secondary",
            "std" => "",
            "type" => "color"
        );

        $of_options[] = array(
            "name" => esc_html__("Success Color - Used for global success messages", 'flozen-theme'),
            "id" => "color_success",
            "std" => "",
            "type" => "color"
        );

        $of_options[] = array(
            "name" => esc_html__("Custom label Color", 'flozen-theme'),
            "id" => "color_hot_label",
            "std" => "",
            "type" => "color"
        );

        $of_options[] = array(
            "name" => esc_html__("Sale label Color", 'flozen-theme'),
            "id" => "color_sale_label",
            "std" => "",
            "type" => "color"
        );

        $of_options[] = array(
            "name" => esc_html__("Price Color", 'flozen-theme'),
            "id" => "color_price_label",
            "std" => "",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Color Product Title", 'flozen-theme'),
            "id" => "product_title_color",
            "std" => "",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Color Product Title - Hover", 'flozen-theme'),
            "id" => "product_title_color_hover",
            "std" => "",
            "type" => "color"
        );

        $of_options[] = array(
            "name" => esc_html__("Buttons Style and Color", 'flozen-theme'),
            "std" => "<h4>" . esc_html__("Buttons Style and Color", 'flozen-theme') . "</h4>",
            "type" => "info"
        );

        $of_options[] = array(
            "name" => esc_html__("Buttons Background Color", 'flozen-theme'),
            "id" => "color_button",
            "std" => "",
            "type" => "color"
        );

        $of_options[] = array(
            "name" => esc_html__("Buttons Background Color Hover", 'flozen-theme'),
            "desc" => esc_html__("Change background color hover for buttons. Default is primary color", 'flozen-theme'),
            "id" => "color_hover",
            "std" => "",
            "type" => "color"
        );

        $of_options[] = array(
            "name" => esc_html__("Buttons Border Color", 'flozen-theme'),
            "id" => "button_border_color",
            "std" => "",
            "type" => "color"
        );

        $of_options[] = array(
            "name" => esc_html__("Buttons Border Color Hover", 'flozen-theme'),
            "id" => "button_border_color_hover",
            "std" => "",
            "type" => "color"
        );

        $of_options[] = array(
            "name" => esc_html__("Buttons Text Color", 'flozen-theme'),
            "id" => "button_text_color",
            "std" => "",
            "type" => "color"
        );

        $of_options[] = array(
            "name" => esc_html__("Buttons Text Color Hover", 'flozen-theme'),
            "id" => "button_text_color_hover",
            "std" => "",
            "type" => "color"
        );
        $of_options[] = array(
            "name" => esc_html__("Buttons radius", 'flozen-theme'),
            "id" => "button_radius",
            "std" => "0",
            "step" => "1",
            "max" => '100',
            "type" => "sliderui"
        );

        $of_options[] = array(
            "name" => esc_html__("Buttons border", 'flozen-theme'),
            "id" => "button_border",
            "std" => "1",
            "step" => "1",
            "max" => '5',
            "type" => "sliderui"
        );

        $of_options[] = array(
            "name" => esc_html__("Inputs radius", 'flozen-theme'),
            "id" => "input_radius",
            "std" => "0",
            "step" => "1",
            "max" => "100",
            "type" => "sliderui"
        );
    }
}
