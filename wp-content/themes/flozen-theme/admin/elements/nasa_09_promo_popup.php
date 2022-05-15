<?php

if (!function_exists('flozen_promo_popup_heading')) {
    add_action('init', 'flozen_promo_popup_heading');

    function flozen_promo_popup_heading() {
        /* ------------------------------------------ */
        /* The Options Array */
        /* ------------------------------------------ */
        // Set the Options Array
        global $of_options;
        if (empty($of_options)) {
            $of_options = array();
        }

        $of_options[] = array(
            "name" => esc_html__("Promo Popup", 'flozen-theme'),
            "target" => 'promo-popup',
            "type" => "heading"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Promo popup", 'flozen-theme'),
            "id" => "promo_popup",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Hide in Mobile (Width site <= 640px OR Mobile Layout)", 'flozen-theme'),
            "desc" => esc_html__("Yes, Please!", 'flozen-theme'),
            "id" => "disable_popup_mobile",
            "std" => 0,
            "type" => "checkbox"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Popup width", 'flozen-theme'),
            "id" => "pp_width",
            "std" => "734",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Popup height", 'flozen-theme'),
            "id" => "pp_height",
            "std" => "501",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Popup content", 'flozen-theme'),
            "id" => "pp_content",
            "std" => '<h3>Newsletter</h3><p>Be the first to know about our new arrivals, exclusive offers and the latest fashion update.</p>',
            "type" => "textarea"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Select contact form", 'flozen-theme'),
            "id" => "pp_contact_form",
            "type" => "select",
            'override_numberic' => true,
            "options" => flozen_get_contactForm7Items()
        );
        
        $of_options[] = array(
            "name" => esc_html__("Content Width", 'flozen-theme'),
            "id" => "pp_style",
            "std" => "simple",
            "type" => "select",
            "options" => array(
                "simple" => esc_html__("50%", 'flozen-theme'),
                "full" => esc_html__("Full Width", 'flozen-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Popup Background Color", 'flozen-theme'),
            "id" => "pp_background_color",
            "std" => "#fff",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Popup Background", 'flozen-theme'),
            "id" => "pp_background_image",
            "std" => FLOZEN_THEME_URI . '/assets/images/newsletter_bg.jpg',
            "type" => "media"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Delay time to show", 'flozen-theme'),
            "id" => "delay_promo_popup",
            "std" => 0,
            "type" => "text"
        );
    }

}

function flozen_get_contactForm7Items() {
    $items = array('default' => esc_html__('Select the Contact form', 'flozen-theme'));
    $contacts = array();
    
    if(class_exists('WPCF7_ContactForm')) {
        $contacts = get_posts(array(
            'posts_per_page' => -1,
            'post_type' => WPCF7_ContactForm::post_type
        ));

        if (!empty($contacts)) {
            foreach ($contacts as $value) {
                $items[$value->ID] = $value->post_title;
            }
        }
    }
    
    if(empty($contacts)) {
        $items = array('default' => esc_html__('You need install plugin Contact Form 7 and Create Newsletter form', 'flozen-theme'));
    }
    
    return $items;
}
