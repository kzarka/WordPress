<?php
if (!function_exists('flozen_product_page_heading')) {
    add_action('init', 'flozen_product_page_heading');
    function flozen_product_page_heading() {
        /* ----------------------------------------------------------------------------------- */
        /* The Options Array */
        /* ----------------------------------------------------------------------------------- */
        // Set the Options Array
        global $of_options;
        if(empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("Archive Products Page", 'flozen-theme'),
            "target" => 'product-page',
            "type" => "heading",
        );
        
        $of_options[] = array(
            "name" => esc_html__("Shop sidebar", 'flozen-theme'),
            "id" => "category_sidebar",
            "std" => "left-classic",
            "type" => "select",
            "options" => array(
                "left-classic" => esc_html__("Left sidebar Classic", 'flozen-theme'),
                "left" => esc_html__("Left Sidebar Off-canvas", 'flozen-theme'),
                "right-classic" => esc_html__("Right Sidebar Classic", 'flozen-theme'),
                "right" => esc_html__("Right Sidebar Off-canvas", 'flozen-theme'),
                "top" => esc_html__("Top Bar", 'flozen-theme'),
                "top-2" => esc_html__("Top Bar Type 2", 'flozen-theme'),
                "no" => esc_html__("No Sidebar", 'flozen-theme')
            ),
            
            'class' => 'nasa-theme-option-parent'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Top Bar Label", 'flozen-theme'),
            "id" => "top_bar_archive_label",
            "std" => "Filter by:",
            "type" => "text",
            'class' => 'nasa-category_sidebar nasa-category_sidebar-top nasa-theme-option-child'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Top Bar Limit widgets to Show More", 'flozen-theme'),
            "id" => "limit_widgets_show_more",
            "std" => "4",
            "type" => "text",
            'class' => 'nasa-category_sidebar nasa-category_sidebar-top nasa-theme-option-child'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Position filter categories", 'flozen-theme'),
            "id" => "top_bar_cat_pos",
            "std" => "left-bar",
            "type" => "select",
            "options" => array(
                "top" => esc_html__("Top", 'flozen-theme'),
                "left-bar" => esc_html__("Left bar", 'flozen-theme')
            ),
            'class' => 'nasa-category_sidebar nasa-category_sidebar-top nasa-theme-option-child'
        );

        $of_options[] = array(
            "name" => esc_html__("Products Per Row", 'flozen-theme'),
            "id" => "products_per_row",
            "std" => "4-cols",
            "type" => "select",
            "options" => array(
                "3-cols" => esc_html__("3 column", 'flozen-theme'),
                "4-cols" => esc_html__("4 column", 'flozen-theme'),
                "5-cols" => esc_html__("5 column", 'flozen-theme'),
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Products Per Row for Mobile", 'flozen-theme'),
            "id" => "products_per_row_small",
            "std" => "1-col",
            "type" => "select",
            "options" => array(
                "1-cols" => esc_html__("1 column", 'flozen-theme'),
                "2-cols" => esc_html__("2 columns", 'flozen-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Products Per Row for Tablet", 'flozen-theme'),
            "id" => "products_per_row_tablet",
            "std" => "2-cols",
            "type" => "select",
            "options" => array(
                "1-col" => esc_html__("1 column", 'flozen-theme'),
                "2-cols" => esc_html__("2 columns", 'flozen-theme'),
                "3-cols" => esc_html__("3 columns", 'flozen-theme')
            )
        );

        $of_options[] = array(
            "name" => esc_html__("Products Per Page", 'flozen-theme'),
            "id" => "products_pr_page",
            "std" => "16",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Select type view", 'flozen-theme'),
            "id" => "products_type_view",
            "std" => "grid",
            "type" => "select",
            "options" => array(
                "grid" => esc_html__("Grid view default", 'flozen-theme'),
                "list" => esc_html__("List view default", 'flozen-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Top Info", 'flozen-theme'),
            "id" => "showing_info_top",
            "desc" => esc_html__("Note: don't using for Sidebar Off-canvas.", 'flozen-theme'),
            "std" => "1",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Change View", 'flozen-theme'),
            "id" => "enable_change_view",
            "std" => "1",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Layout style", 'flozen-theme'),
            "id" => "products_layout_style",
            "std" => "grid_row",
            "type" => "select",
            "options" => array(
                "grid-row" => esc_html__("Grid row", 'flozen-theme'),
                "masonry-isotope" => esc_html__("Masonry isotope", 'flozen-theme')
            )
        );

        $of_options[] = array(
            "name" => esc_html__("Pagination page style", 'flozen-theme'),
            "id" => "pagination_style",
            "std" => 'style-2',
            "type" => "select",
            "options" => array(
                "style-2" => esc_html__("Simple", 'flozen-theme'),
                "style-1" => esc_html__("Full", 'flozen-theme'),
                "infinite" => esc_html__("Infinite - Only using for Ajax", 'flozen-theme'),
                "load-more" => esc_html__("Load More - Only using for Ajax", 'flozen-theme')
            )
        );

        $of_options[] = array(
            "name" => esc_html__("Show title in-line", 'flozen-theme'),
            "id" => "cutting_product_name",
            "std" => "1",
            "type" => "switch"
        );

        $of_options[] = array(
            "name" => esc_html__("Top content Products page", 'flozen-theme'),
            "std" => "<h4>" . esc_html__("Top content Products page", 'flozen-theme') . "</h4>",
            "type" => "info"
        );
        
        $block_type = get_posts(array(
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
            'post_type'         => 'nasa_block'
        ));
        $arr_blocks = array('default' => esc_html__('Select the Static Block', 'flozen-theme'));
        if (!empty($block_type)) {
            foreach ($block_type as $value) {
                $arr_blocks[$value->post_name] = $value->post_title;
            }
        }

        $of_options[] = array(
            "name" => esc_html__("Category top content", 'flozen-theme'),
            "id" => "cat_top_content",
            "desc" => esc_html__("Please Create Static Block and Selected here to use.", 'flozen-theme'),
            "type" => "select",
            "options" => $arr_blocks
        );
        
        $of_options[] = array(
            "name" => esc_html__("Category bottom content", 'flozen-theme'),
            "id" => "cat_bottom_content",
            "desc" => esc_html__("Please Create Static Block and Selected here to use.", 'flozen-theme'),
            "type" => "select",
            "options" => $arr_blocks
        );
    }
}
