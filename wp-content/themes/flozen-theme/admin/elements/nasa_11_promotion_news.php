<?php
if (!function_exists('flozen_promotion_news_heading')) {
    add_action('init', 'flozen_promotion_news_heading');
    function flozen_promotion_news_heading() {
        /* ----------------------------------------------------------------------------------- */
        /* The Options Array */
        /* ----------------------------------------------------------------------------------- */
        // Set the Options Array
        global $of_options;
        if(empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("Promotion News", 'flozen-theme'),
            "target" => "promotion-news",
            "type" => "heading"
        );

        $of_options[] = array(
            "name" => esc_html__("Top bar Promotion News", 'flozen-theme'),
            "id" => "enable_post_top",
            "std" => 0,
            "type" => "switch"
        );

        $of_options[] = array(
            "name" => esc_html__("Type", 'flozen-theme'),
            "id" => "type_display",
            "std" => 'custom',
            "type" => "select",
            "options" => array(
                'custom' => esc_html__('Custom Content', 'flozen-theme'),
                'list-posts' => esc_html__('List posts', 'flozen-theme')
            ),
            'class' => 'type_promotion'
        );

        $of_options[] = array(
            "name" => esc_html__("Custom Content", 'flozen-theme'),
            "desc" => '<a href="javascript:void(0);" class="reset_content_custom"><b>Default value</b></a> for My content custom.<br /><a href="javascript:void(0);" class="restore_content_custom"><b>Restore text</b></a> for My content custom.<br />',
            "id" => "content_custom",
            "std" => '',
            'type' => 'textarea',
            'class' => 'hidden-tag nasa-custom_content'
        );

        $of_options[] = array(
            "name" => esc_html__("Category Post", 'flozen-theme'),
            "id" => "category_post",
            "std" => '',
            "type" => "select",
            "options" => flozen_get_cats_array(),
            'class' => 'hidden-tag nasa-list_post'
        );

        $of_options[] = array(
            "name" => esc_html__("Limit posts", 'flozen-theme'),
            "id" => "number_post",
            "std" => 4,
            "type" => "text",
            'class' => 'hidden-tag nasa-list_post'
        );

        $of_options[] = array(
            "name" => esc_html__("Slide Number display", 'flozen-theme'),
            "id" => "number_post_slide",
            "std" => 1,
            "type" => "text",
            'class' => 'hidden-tag nasa-list_post'
        );

        $of_options[] = array(
            "name" => esc_html__("Full Width", 'flozen-theme'),
            "id" => "enable_fullwidth",
            "std" => 1,
            "type" => "switch"
        );

        $of_options[] = array(
            "name" => esc_html__("Text promotion color", 'flozen-theme'),
            "id" => "t_promotion_color",
            "std" => "#333",
            "type" => "color"
        );

        $of_options[] = array(
            "name" => esc_html__("Background", 'flozen-theme'),
            "id" => "background_area",
            "std" => FLOZEN_ADMIN_DIR_URI . 'assets/images/promo_bg.jpg',
            "type" => "media"
        );
    }
}
