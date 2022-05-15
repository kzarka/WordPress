<?php
if (!function_exists('flozen_general_heading')) {
    add_action('init', 'flozen_general_heading');
    function flozen_general_heading() {
        /* ----------------------------------------------------------------------------------- */
        /* The Options Array */
        /* ----------------------------------------------------------------------------------- */
        // Set the Options Array
        global $of_options;
        if(empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("General", 'flozen-theme'),
            "target" => 'general',
            "type" => "heading"
        );

        if(get_option('nasatheme_imported') !== 'imported') {
            $of_options[] = array(
                "name" => esc_html__("Import Demo Content", 'flozen-theme'),
                "desc" => esc_html__("Click for import. Please ensure our plugins are activated before content is imported.", 'flozen-theme'),
                "id" => "demo_data",
                'href' => '#',
                "std" => "",
                "btntext" => esc_html__("Import Demo Content", 'flozen-theme'),
                "type" => "button"
            );
        }
        else {
            $of_options[] = array(
                "name" => esc_html__("Demo data imported", 'flozen-theme'),
                "std" => '<h3 style="background: #fff; margin: 0; padding: 5px 10px;">' . esc_html__("Demo data was imported. If you want import demo data again, You should need reset data of your site.", 'flozen-theme') . "</h3>",
                "type" => "info"
            );
        }

        $of_options[] = array(
            "name" => esc_html__("Site Layout", 'flozen-theme'),
            "desc" => esc_html__("Selects site layout.", 'flozen-theme'),
            "id" => "site_layout",
            "std" => "wide",
            "type" => "select",
            "options" => array(
                "wide" => esc_html__("Wide", 'flozen-theme'),
                "boxed" => esc_html__("Boxed", 'flozen-theme')
            ),
            'class' => 'nasa-theme-option-parent'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Add more width site (px)", 'flozen-theme'),
            "desc" => esc_html__("The max-width of your site will be INPUT + 1200 (pixel).", 'flozen-theme'),
            "id" => "plus_wide_width",
            "std" => "",
            "type" => "text"
        );

        $of_options[] = array(
            "name" => esc_html__("Site Background Color", 'flozen-theme'),
            "id" => "site_bg_color",
            "std" => "#eee",
            "type" => "color",
            'class' => 'nasa-site_layout nasa-site_layout-boxed nasa-theme-option-child'
        );

        $of_options[] = array(
            "name" => esc_html__("Site Background Image", 'flozen-theme'),
            "id" => "site_bg_image",
            "std" => FLOZEN_THEME_URI . "/assets/images/bkgd1.jpg",
            "type" => "media",
            'class' => 'nasa-site_layout nasa-site_layout-boxed nasa-theme-option-child'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Hide Login or Register menu", 'flozen-theme'),
            "desc" => esc_html__("Yes, Please!", 'flozen-theme'),
            "id" => "hide_tini_menu_acc",
            "std" => 0,
            "type" => "checkbox"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Login/Register by Ajax form", 'flozen-theme'),
            "id" => "login_ajax",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Mobile Menu Layout", 'flozen-theme'),
            "id" => "mobile_menu_layout",
            "std" => "light-new",
            "type" => "select",
            "options" => array(
                "light-new" => esc_html__("Light - Default", 'flozen-theme'),
                "light" => esc_html__("Light - 2", 'flozen-theme'),
                "dark" => esc_html__("Dark", 'flozen-theme')
            )
        );

        $of_options[] = array(
            "name" => esc_html__("Disable Transition Loading", 'flozen-theme'),
            "desc" => esc_html__("Yes, Please!", 'flozen-theme'),
            "id" => "disable_wow",
            "std" => 0,
            "type" => "checkbox"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Delay overlay items (ms)", 'flozen-theme'),
            "id" => "delay_overlay",
            "std" => "100",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Effect before load site", 'flozen-theme'),
            "id" => "effect_before_load",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("GDPR Options", 'flozen-theme'),
            "std" => "<h4>" . esc_html__("GDPR Options", 'flozen-theme') . "</h4>",
            "type" => "info"
        );
        
        $of_options[] = array(
            "name" => esc_html__("GDPR Notice", 'flozen-theme'),
            "id" => "nasa_gdpr_notice",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("GDPR Policies Link", 'flozen-theme'),
            "id" => "nasa_gdpr_policies",
            "std" => "https://policies.google.com",
            "type" => "text"
        );
        
        $of_options[] = array(
        "name" => esc_html__("Site Mode Options", 'flozen-theme'),
            "std" => "<h4>" . esc_html__("Site Mode Options", 'flozen-theme') . "</h4>",
            "type" => "info"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Site Offline", 'flozen-theme'),
            "id" => "site_offline",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Coming Soon Tittle", 'flozen-theme'),
            "id" => "coming_soon_title",
            "std" => "Comming Soon",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Coming Soon Info", 'flozen-theme'),
            "id" => "coming_soon_info",
            "std" => "Condimentum ipsum a adipiscing hac dolor set consectetur urna commodo elit parturient<br />a molestie ut nisl partu cl vallier ullamcorpe",
            "type" => "textarea"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Coming Soon Image", 'flozen-theme'),
            "id" => "coming_soon_img",
            "std" => FLOZEN_THEME_URI . "/assets/images/commingsoon.jpg",
            "type" => "media",
            // "mod" => "min"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Coming Soon Time", 'flozen-theme'),
            "id" => "coming_soon_time",
            "desc" => esc_html__("Please enter a time to return the site to Online (YYYY/mm/dd | YYYY-mm-dd).", 'flozen-theme'),
            "std" => "",
            "type" => "text"
        );
    }
}
