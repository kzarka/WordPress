<?php
if (!function_exists('flozen_header_footer_heading')) {
    add_action('init', 'flozen_header_footer_heading');
    function flozen_header_footer_heading() {
        /* ----------------------------------------------------------------------------------- */
        /* The Options Array */
        /* ----------------------------------------------------------------------------------- */
        // Set the Options Array
        global $of_options;
        if(empty($of_options)) {
            $of_options = array();
        }
        
        /**
         * Header Nasa Blocks
         */
        $block_type = get_posts(array(
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
            'post_type'         => 'nasa_block'
        ));
        $header_blocks = array('default' => esc_html__('Select the Static Block', 'flozen-theme'));
        if (!empty($block_type)) {
            foreach ($block_type as $key => $value) {
                $header_blocks[$value->post_name] = $value->post_title;
            }
        }
        
        $of_options[] = array(
            "name" => esc_html__("Header and Footer", 'flozen-theme'),
            "target" => 'header-footer',
            "type" => "heading"
        );

        $of_options[] = array(
            "name" => esc_html__("Header Option", 'flozen-theme'),
            "std" => "<h4>" . esc_html__("Header Option", 'flozen-theme') . "</h4>",
            "type" => "info"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Header type", 'flozen-theme'),
            "desc" => esc_html__("Select header type", 'flozen-theme'),
            "id" => "header-type",
            "std" => "3",
            "type" => "images",
            "options" => array(
                '1' => FLOZEN_ADMIN_DIR_URI . 'assets/images/header-1.jpg',
                '2' => FLOZEN_ADMIN_DIR_URI . 'assets/images/header-2.jpg',
                '3' => FLOZEN_ADMIN_DIR_URI . 'assets/images/header-3.jpg',
                'nasa-custom' => FLOZEN_ADMIN_DIR_URI . 'assets/images/header-builder.gif'
            ),
            
            'class' => 'nasa-header-type-select nasa-theme-option-parent'
        );
        
        $headers_type = get_posts(array(
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
            'post_type'         => 'header'
        ));
        $headers_option = array();
        $headers_option['default'] = esc_html__('Select the Header custom', 'flozen-theme');
        $header_selected = false;
        if (!empty($headers_type)) {
            foreach ($headers_type as $key => $value) {
                $header_selected = !$header_selected ? $value->post_name : $header_selected;
                $headers_option[$value->post_name] = $value->post_title;
            }
        }
        $of_options[] = array(
            "name" => esc_html__("Header Builder", 'flozen-theme'),
            "desc" => esc_html__("Select Header Builder", 'flozen-theme'),
            "id" => "header-custom",
            "type" => "select",
            'override_numberic' => true,
            "options" => $headers_option,
            'std' => $header_selected ? $header_selected : '',
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-nasa-custom nasa-header-custom'
        );
        
        $menus = wp_get_nav_menus(array('orderby' => 'name'));
        $option_menu = array('' => esc_html__('Select menu', 'flozen-theme'));
        if (!empty($menus)) {
            foreach ($menus as $menu_option) {
                $option_menu[$menu_option->term_id] = $menu_option->name;
            }
        }
        
        $of_options[] = array(
            "name" => esc_html__("Select vertical menu", 'flozen-theme'),
            "id" => "vertical_menu_selected",
            "std" => "",
            "type" => "select",
            'override_numberic' => true,
            "options" => $option_menu,
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-3'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Fullwidth Main Menu", 'flozen-theme'),
            "id" => "fullwidth_main_menu",
            "std" => 1,
            "type" => "switch",
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-2 nasa-fullwidth_main_menu'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Transparent header", 'flozen-theme'),
            "id" => "header_transparent",
            "std" => 0,
            "type" => "switch",
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-1 nasa-header-type-select-2 nasa-header-type-select-3 nasa-header_transparent'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Block Header transparent", 'flozen-theme'),
            "id" => "header-block",
            "type" => "select",
            "options" => $header_blocks,
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-1 nasa-header-type-select-2 nasa-header-type-select-3 nasa-header-block'
        );

        $of_options[] = array(
            "name" => esc_html__("Sticky", 'flozen-theme'),
            "id" => "fixed_nav",
            "std" => 0,
            "type" => "switch",
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-1 nasa-header-type-select-2 nasa-header-type-select-3 nasa-fixed_nav'
        );

        $of_options[] = array(
            "name" => esc_html__("Toggle Top Bar", 'flozen-theme'),
            "id" => "topbar_toggle",
            "std" => 0,
            "type" => "switch",
            'class' => 'hidden-tag nasa-topbar_toggle nasa-header-type-child nasa-header-type-select-1 nasa-header-type-select-2 nasa-header-type-select-3 nasa-fixed_nav'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Default Top Bar Show", 'flozen-theme'),
            "id" => "topbar_default_show",
            "std" => 1,
            "type" => "switch",
            'class' => 'hidden-tag nasa-topbar_df-show'
        );

        $of_options[] = array(
            "name" => esc_html__("Switch Languages - Requires WPML", 'flozen-theme'),
            "id" => "switch_lang",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Currency Switcher - Requires Package of WPML", 'flozen-theme'),
            "id" => "switch_currency",
            "std" => 0,
            "type" => "switch"
        );
        
        //(%symbol%) %code%
        $of_options[] = array(
            "name" => esc_html__("Format Currency", 'flozen-theme'),
            "desc" => esc_html__("Default (%symbol%) %code%. You can custom for this. Ex (%name% (%symbol%) - %code%)", 'flozen-theme'),
            "id" => "switch_currency_format",
            "std" => "",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Topbar Content", 'flozen-theme'),
            "desc" => esc_html__("Please Create Static Block and Selected here to use", 'flozen-theme'),
            "id" => "topbar_content",
            "type" => "select",
            "options" => $header_blocks,
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-1 nasa-header-type-select-2 nasa-header-type-select-3 nasa-topbar_content'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Hotline Content", 'flozen-theme'),
            "desc" => esc_html__("Please Create Static Block and Selected here to use", 'flozen-theme'),
            "id" => "hotline_content",
            "type" => "select",
            "options" => $header_blocks,
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-3 nasa-hotline_content'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Toggle Header Icons in Mobile", 'flozen-theme'),
            "id" => "topbar_mobile_icons_toggle",
            "std" => 0,
            "type" => "switch",
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-1 nasa-header-type-select-2 nasa-header-type-select-3 nasa-topbar_mobile_icons_toggle'
        );

        $of_options[] = array(
            "name" => esc_html__("Header Elements", 'flozen-theme'),
            "std" => "<h4>" . esc_html__("Header Elements", 'flozen-theme') . "</h4>",
            "type" => "info"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Topbar Background", 'flozen-theme'),
            "id" => "bg_color_topbar",
            "std" => "",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Topbar Text color", 'flozen-theme'),
            "id" => "text_color_topbar",
            "std" => "",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Topbar Text color hover", 'flozen-theme'),
            "id" => "text_color_hover_topbar",
            "std" => "",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Background color Header", 'flozen-theme'),
            "id" => "bg_color_header",
            "std" => "",
            "type" => "color",
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-1 nasa-header-type-select-2 nasa-header-type-select-3 nasa-bg_color_header'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Header Icons", 'flozen-theme'),
            "id" => "text_color_header",
            "std" => "",
            "type" => "color",
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-1 nasa-header-type-select-2 nasa-header-type-select-3 nasa-text_color_header'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Header Icons Hover", 'flozen-theme'),
            "id" => "text_color_hover_header",
            "std" => "",
            "type" => "color",
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-1 nasa-header-type-select-2 nasa-header-type-select-3 nasa-text_color_hover_header'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Main Menu Background Color", 'flozen-theme'),
            "id" => "bg_color_main_menu",
            "std" => "",
            "type" => "color",
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-2 nasa-header-type-select-3 nasa-bg_color_main_menu'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Main Menu Text Color", 'flozen-theme'),
            "id" => "text_color_main_menu",
            "std" => "",
            "type" => "color",
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-1 nasa-header-type-select-2 nasa-header-type-select-3 nasa-text_color_main_menu'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Vertical Menu Background Color", 'flozen-theme'),
            "id" => "bg_color_vertical_menu",
            "std" => "",
            "type" => "color",
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-3 nasa-bg_color_vertical_menu'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Vertical Menu Text Color", 'flozen-theme'),
            "id" => "text_color_vertical_menu",
            "std" => "",
            "type" => "color",
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-3 nasa-text_color_vertical_menu'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Footer Option", 'flozen-theme'),
            "std" => "<h4>" . esc_html__("Footer Option", 'flozen-theme') . "</h4>",
            "type" => "info"
        );

        $footers_type = get_posts(array(
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
            'post_type'         => 'footer'
        ));
        
        /**
         * Footer Desktop
         */
        $footers_option = $footers_mobile = array();
        $footers_option['default'] = esc_html__('Select the Footer type', 'flozen-theme');
        $footers_mobile['default'] = esc_html__('Extends from Desktop', 'flozen-theme');
        $footer_selected = false;
        if (!empty($footers_type)) {
            foreach ($footers_type as $key => $value) {
                $footer_selected = !$footer_selected ? $value->post_name : $footer_selected;
                $footers_option[$value->post_name] = $value->post_title;
                $footers_mobile[$value->post_name] = $value->post_title;
            }
        }
        
        /**
         * Footer Desktop
         */
        $of_options[] = array(
            "name" => esc_html__("Footer Layout", 'flozen-theme'),
            "id" => "footer-type",
            "type" => "select",
            'override_numberic' => true,
            "options" => $footers_option,
            'std' => $footer_selected ? $footer_selected : ''
        );
        
        /**
         * Footer Mobile
         */
        $of_options[] = array(
            "name" => esc_html__("Footer Mobile Layout", 'flozen-theme'),
            "id" => "footer-mobile",
            "type" => "select",
            'override_numberic' => true,
            "options" => $footers_mobile,
            'std' => ''
        );
    }
}
