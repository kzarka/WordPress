<?php
if (!function_exists('flozen_type_heading')) {
    add_action('init', 'flozen_type_heading');
    function flozen_type_heading() {
        /* ----------------------------------------------------------------------------------- */
        /* The Options Array */
        /* ----------------------------------------------------------------------------------- */
        // Set the Options Array
        global $of_options;
        if(empty($of_options)) {
            $of_options = array();
        }
        
        $google_fonts = flozen_get_fonts();
        $custom_fonts = flozen_get_custom_fonts();
        
        $of_options[] = array(
            "name" => esc_html__("Fonts", 'flozen-theme'),
            "target" => 'fonts',
            "type" => "heading"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Font use in site", 'flozen-theme'),
            "id" => "type_font_select",
            "std" => "custom",
            "type" => "select",
            "options" => array(
                "custom" => esc_html__("Custom Font", 'flozen-theme'),
                "google" => esc_html__("Google Font", 'flozen-theme'),
                "" => esc_html__("Default Font", 'flozen-theme')
            ),
            'class' => 'nasa-type-font'
        );

        $of_options[] = array(
            "name" => esc_html__("Heading fonts (H1, H2, H3, H4, H5, H6)", 'flozen-theme'),
            "id" => "type_headings",
            "std" => "Nunito Sans",
            "type" => "select_google_font",
            "preview" => array(
                "text" => '<strong>' . esc_html__("NasaTheme", 'flozen-theme') . '</strong><br /><span style="font-size:60%!important">' . esc_html__("UPPERCASE TEXT", 'flozen-theme') . '</span>',
                "size" => "30px"
            ),
            "options" => $google_fonts,
            'class' => 'hidden-tag nasa-type-font-glb nasa-type-font-google'
        );

        $of_options[] = array(
            "name" => esc_html__("Text fonts (paragraphs, buttons, sub-navigations)", 'flozen-theme'),
            "id" => "type_texts",
            "std" => "Nunito Sans",
            "type" => "select_google_font",
            "preview" => array(
                "text" => esc_html__("Lorem ipsum dosectetur adipisicing elit, sed do.Lorem ipsum dolor sit amet, consectetur Nulla fringilla purus at leo dignissim congue. Mauris elementum accumsan leo vel tempor. Sit amet cursus nisl aliquam. Aliquam et elit eu nunc rhoncus viverra quis at felis..", 'flozen-theme'),
                "size" => "14px"
            ),
            "options" => $google_fonts,
            'class' => 'hidden-tag nasa-type-font-glb nasa-type-font-google'
        );

        $of_options[] = array(
            "name" => esc_html__("Main navigation", 'flozen-theme'),
            "id" => "type_nav",
            "std" => "Nunito Sans",
            "type" => "select_google_font",
            "preview" => array(
                "text" => "<span style='font-size:45%'>" . esc_html__("THIS IS THE TEXT.", 'flozen-theme') . "</span>",
                "size" => "30px"
            ),
            "options" => $google_fonts,
            'class' => 'hidden-tag nasa-type-font-glb nasa-type-font-google'
        );

        $of_options[] = array(
            "name" => esc_html__("Banner font", 'flozen-theme'),
            "id" => "type_banner",
            "std" => "Nunito Sans",
            "type" => "select_google_font",
            "preview" => array(
                "text" => esc_html__("This is the text.", 'flozen-theme'),
                "size" => "30px"
            ),
            "options" => $google_fonts,
            'class' => 'hidden-tag nasa-type-font-glb nasa-type-font-google'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Price font", 'flozen-theme'),
            "id" => "type_price",
            "std" => "Nunito Sans",
            "type" => "select_google_font",
            "preview" => array(
                "text" => esc_html__("$999.", 'flozen-theme'),
                "size" => "30px"
            ),
            "options" => $google_fonts,
            'class' => 'hidden-tag nasa-type-font-glb nasa-type-font-google'
        );

        $of_options[] = array(
            "name" => esc_html__("Character Sub-sets", 'flozen-theme'),
            "id" => "type_subset",
            "std" => array("latin"),
            "type" => "multicheck",
            "options" => array(
                "latin"         => esc_html__("Latin", 'flozen-theme'),
                "arabic"        => esc_html__("Arabic", 'flozen-theme'),
                "cyrillic"      => esc_html__("Cyrillic", 'flozen-theme'),
                "cyrillic-ext"  => esc_html__("Cyrillic Extended", 'flozen-theme'),
                "greek"         => esc_html__("Greek", 'flozen-theme'),
                "greek-ext"     => esc_html__("Greek Extended", 'flozen-theme'),
                "vietnamese"    => esc_html__("Vietnamese", 'flozen-theme'),
                "latin-ext"     => esc_html__("Latin Extended", 'flozen-theme')
            ),
            'class' => 'hidden-tag nasa-type-font-glb nasa-type-font-google'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Upload Your Custom font", 'flozen-theme'),
            "std" => "",
            "type" => "nasa_upload_custom_font",
            'class' => 'hidden-tag nasa-type-font-glb nasa-type-font-custom'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Select custom font", 'flozen-theme'),
            "id" => "custom_font",
            "std" => "NS-ProximaNova",
            "type" => "select",
            "options" => $custom_fonts,
            'class' => 'hidden-tag nasa-type-font-glb nasa-type-font-custom'
        );
    }
}
