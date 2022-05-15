<?php
if (!function_exists('flozen_blog_heading')) {
    add_action('init', 'flozen_blog_heading');
    function flozen_blog_heading() {
        /* ======================================================================= */
        /* The Options Array */
        /* ======================================================================= */
        global $of_options;
        if(empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("Blog", 'flozen-theme'),
            "target" => 'blog',
            "type" => "heading"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Single Blog layout", 'flozen-theme'),
            "id" => "single_blog_layout",
            "std" => "left",
            "type" => "select",
            "options" => array(
                "left" => esc_html__("Left sidebar", 'flozen-theme'),
                "right" => esc_html__("Right sidebar", 'flozen-theme'),
                "no" => esc_html__("No sidebar (Centered)", 'flozen-theme')
            )
        );

        $of_options[] = array(
            "name" => esc_html__("Blog layout", 'flozen-theme'),
            "id" => "blog_layout",
            "std" => "left",
            "type" => "select",
            "options" => array(
                "left" => esc_html__("Left sidebar", 'flozen-theme'),
                "right" => esc_html__("Right sidebar", 'flozen-theme'),
                "no" => esc_html__("No sidebar (Centered)", 'flozen-theme')
            )
        );

        $of_options[] = array(
            "name" => esc_html__("Blog style", 'flozen-theme'),
            "id" => "blog_type",
            "std" => "blog-standard",
            "type" => "select",
            "options" => array(
                "blog-standard" => esc_html__("Standard", 'flozen-theme'),
                "masonry-isotope" => esc_html__("Masonry isotope", 'flozen-theme'),
                "blog-grid" => esc_html__("Grid", 'flozen-theme'),
                "blog-list" => esc_html__("List", 'flozen-theme')
            )
        );
        
        /* ======================================================================= */
        
        $of_options[] = array(
            "name" => esc_html__("Masonry isotope - Grid - Blog style", 'flozen-theme'),
            "std" => "<h4>" . esc_html__("Masonry isotope - Grid - Blog style", 'flozen-theme') . "</h4>",
            "type" => "info"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Columns in desktop", 'flozen-theme'),
            "id" => "masonry_blogs_columns_desk",
            "std" => "3-cols",
            "type" => "select",
            "options" => array(
                "2-cols" => esc_html__("2 columns", 'flozen-theme'),
                "3-cols" => esc_html__("3 columns", 'flozen-theme'),
                "4-cols" => esc_html__("4 columns", 'flozen-theme'),
                "5-cols" => esc_html__("5 columns", 'flozen-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Columns in mobile", 'flozen-theme'),
            "id" => "masonry_blogs_columns_small",
            "std" => "1-col",
            "type" => "select",
            "options" => array(
                "1-cols" => esc_html__("1 column", 'flozen-theme'),
                "2-cols" => esc_html__("2 columns", 'flozen-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Columns in Tablet", 'flozen-theme'),
            "id" => "masonry_blogs_columns_tablet",
            "std" => "2-cols",
            "type" => "select",
            "options" => array(
                "1-col" => esc_html__("1 column", 'flozen-theme'),
                "2-cols" => esc_html__("2 columns", 'flozen-theme'),
                "3-cols" => esc_html__("3 columns", 'flozen-theme')
            )
        );
        
        /* ======================================================================= */
        
        $of_options[] = array(
            "name" => esc_html__("Standard - Blog style", 'flozen-theme'),
            "std" => "<h4>" . esc_html__("Standard - Blog style", 'flozen-theme') . "</h4>",
            "type" => "info"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Parallax effect", 'flozen-theme'),
            "id" => "blog_parallax",
            "std" => 0,
            "type" => "switch"
        );
        
        /* ======================================================================= */
        
        $of_options[] = array(
            "name" => esc_html__("Meta Info - Blog style", 'flozen-theme'),
            "std" => "<h4>" . esc_html__("Meta Info - Blog style", 'flozen-theme') . "</h4>",
            "type" => "info"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Author info", 'flozen-theme'),
            "id" => "show_author_info",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Datetime info", 'flozen-theme'),
            "id" => "show_date_info",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Categories info", 'flozen-theme'),
            "id" => "show_cat_info",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Tags info", 'flozen-theme'),
            "id" => "show_tag_info",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Readmore", 'flozen-theme'),
            "id" => "show_readmore_blog",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Short description (Only use for Blog Grid layout)", 'flozen-theme'),
            "id" => "show_desc_blog",
            "std" => 1,
            "type" => "switch"
        );
        
        /* ======================================================================= */
        
        $of_options[] = array(
            "name" => esc_html__("Single Blog page", 'flozen-theme'),
            "std" => "<h4>" . esc_html__("Single Blog page", 'flozen-theme') . "</h4>",
            "type" => "info"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Related", 'flozen-theme'),
            "id" => "relate_blogs",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Number for relate blog", 'flozen-theme'),
            "id" => "relate_blogs_number",
            "std" => "10",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Columns Relate in desktop", 'flozen-theme'),
            "id" => "relate_blogs_columns_desk",
            "std" => "3-cols",
            "type" => "select",
            "options" => array(
                "3-cols" => esc_html__("3 columns", 'flozen-theme'),
                "4-cols" => esc_html__("4 columns", 'flozen-theme'),
                "5-cols" => esc_html__("5 columns", 'flozen-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Columns Relate in mobile", 'flozen-theme'),
            "id" => "relate_blogs_columns_small",
            "std" => "1-col",
            "type" => "select",
            "options" => array(
                "1-cols" => esc_html__("1 column", 'flozen-theme'),
                "2-cols" => esc_html__("2 columns", 'flozen-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Columns Relate in Tablet", 'flozen-theme'),
            "id" => "relate_blogs_columns_tablet",
            "std" => "2-cols",
            "type" => "select",
            "options" => array(
                "1-col" => esc_html__("1 column", 'flozen-theme'),
                "2-cols" => esc_html__("2 columns", 'flozen-theme'),
                "3-cols" => esc_html__("3 columns", 'flozen-theme')
            )
        );
    }
}
