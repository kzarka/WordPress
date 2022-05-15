<?php
if (!function_exists('flozen_portfolio_heading')) {
    add_action('init', 'flozen_portfolio_heading');
    function flozen_portfolio_heading() {
        
        if(!defined('NASA_CORE_ACTIVED') || !NASA_CORE_ACTIVED) {
            return;
        }
        
        /* ----------------------------------------------------------------------------------- */
        /* The Options Array */
        /* ----------------------------------------------------------------------------------- */
        // Set the Options Array
        global $of_options;
        if(empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("Portfolio", 'flozen-theme'),
            "target" => 'portfolio',
            "type" => "heading"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Portfolio", 'flozen-theme'),
            "id" => "enable_portfolio",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Page view Portfolio", 'flozen-theme'),
            "desc" => esc_html__("Select page view Portfolio.", 'flozen-theme'),
            "id" => "nasa-page-view-portfolio",
            "type" => "select",
            "options" => flozen_pages_temp_portfolio()
        );
        
        $of_options[] = array(
            "name" => esc_html__("Recent", 'flozen-theme'),
            "id" => "recent_projects",
            "std" => 1,
            "type" => "switch"
        );
        $of_options[] = array(
            "name" => esc_html__("Comments", 'flozen-theme'),
            "id" => "portfolio_comments",
            "std" => 1,
            "type" => "switch"
        );
        $of_options[] = array(
            "name" => esc_html__("Limit per page", 'flozen-theme'),
            "id" => "portfolio_count",
            "std" => 10,
            "type" => "text"
        );
        $of_options[] = array(
            "name" => esc_html__("Category", 'flozen-theme'),
            "id" => "project_byline",
            "std" => 1,
            "type" => "switch"
        );
        $of_options[] = array(
            "name" => esc_html__("Name", 'flozen-theme'),
            "id" => "project_name",
            "std" => 1,
            "type" => "switch"
        );

        $of_options[] = array(
            "name" => esc_html__("Columns", 'flozen-theme'),
            "id" => "portfolio_columns",
            "std" => "5-cols",
            "type" => "select",
            "options" => array(
                "5-cols" => esc_html__("5 columns", 'flozen-theme'),
                "4-cols" => esc_html__("4 columns", 'flozen-theme'),
                "3-cols" => esc_html__("3 columns", 'flozen-theme'),
                "2-cols" => esc_html__("2 columns", 'flozen-theme')
            )
        );

        $of_options[] = array(
            "name" => esc_html__("Lightbox", 'flozen-theme'),
            "id" => "portfolio_lightbox",
            "std" => 1,
            "type" => "switch"
        );
    }
}
