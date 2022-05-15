<?php

/**
 * VC SETUP
 */
add_action('init', 'flozen_vc_setup');
if (!function_exists('flozen_vc_setup')) :

    function flozen_vc_setup() {
        if (!class_exists('WPBakeryVisualComposerAbstract')){
            return;
        }

        // **********************************************************************// 
        // ! Row (add fullwidth, parallax option)
        // **********************************************************************//
        vc_add_param('vc_row', array(
            "type" => 'checkbox',
            "heading" => esc_html__("Fullwidth ?", 'flozen-theme'),
            "param_name" => "fullwidth",
            "value" => array(
                esc_html__('Yes, please', 'flozen-theme') => '1'
            )
        ));
        
        //Add param from tab element
        vc_add_param('vc_tta_tabs', array(
            "type" => "dropdown",
            "heading" => esc_html__("Style", 'flozen-theme'),
            "param_name" => "tabs_display_type",
            "value" => array(
                esc_html__('Classic 2D - No border', 'flozen-theme') => '2d-no-border',
                esc_html__('Classic 2D - Has BG color', 'flozen-theme') => '2d-has-bg',
                esc_html__('Classic 2D', 'flozen-theme') => '2d',
                esc_html__('Classic 3D', 'flozen-theme') => '3d',
                esc_html__('Slide', 'flozen-theme') => 'slide'
            ),
            "std" => '2d-no-border'
        ));
        
        vc_add_param('vc_tta_tabs', array(
            "type" => "colorpicker",
            "heading" => esc_html__("Tabs Background color", 'flozen-theme'),
            "param_name" => "tabs_bg_color",
            "std" => '#efefef',
            "dependency" => array(
                "element" => "tabs_display_type",
                "value" => array(
                    "2d-has-bg"
                )
            )
        ));
        
        vc_add_param('vc_tta_tabs', array(
            "type" => "colorpicker",
            "heading" => esc_html__("Tabs text color", 'flozen-theme'),
            "param_name" => "tabs_text_color",
            "std" => '',
            "dependency" => array(
                "element" => "tabs_display_type",
                "value" => array(
                    "2d-has-bg"
                )
            )
        ));
        
        vc_add_param('vc_tta_accordion', array(
            "type" => 'checkbox',
            "heading" => esc_html__("Hide First Section ?", 'flozen-theme'),
            "param_name" => "accordion_hide_first",
            "value" => array(
                esc_html__('Yes, please', 'flozen-theme') => '1'
            )
        ));
        
        //Add param from section tab element
        vc_add_param('vc_tta_section', array(
            "type" => "textfield",
            "heading" => esc_html__("Add Icon NasaTheme (Using for Section of Tabs)", 'flozen-theme'),
            "param_name" => "section_nasa_icon",
            "std" => '',
            'readonly' => 1,
            'description' => '<a class="nasa-chosen-icon" data-fill="section_nasa_icon" href="javascript:void(0);">Click Here to Add Icon NasaTheme</a>'
        ));
        
        // Add param from columns element
        vc_add_param('vc_column', array(
            "type" => "dropdown",
            "heading" => esc_html__("Width full side", 'flozen-theme'),
            "param_name" => "width_side",
            'value' => array(
                esc_html__('None', 'flozen-theme') => '',
                esc_html__('Full width to left', 'flozen-theme') => 'left',
                esc_html__('Full width to right', 'flozen-theme') => 'right'
            ),
            'std' => '',
            "description" => esc_html__('Only use for Visual Composer Template.', 'flozen-theme'),
        ));
    }

endif;

if (!function_exists('flozen_loader_html')) :
    function flozen_loader_html($id_attr = null, $relative = true) {
        $id = $id_attr != null ? ' id="' . esc_attr($id_attr) . '"' : '';
        $class = $relative ? ' class="nasa-relative"' : '';
        return 
            '<div' . $id . $class . '>' .
                '<div class="nasa-loader"></div>' .
            '</div>';
    }
endif;
