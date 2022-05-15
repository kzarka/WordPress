<?php
/*
 *
 * @package nasatheme - flozen-theme
 */

/* Define DIR AND URI OF THEME */
define('FLOZEN_THEME_PATH', get_template_directory());
define('FLOZEN_CHILD_PATH', get_stylesheet_directory());
define('FLOZEN_THEME_URI', get_template_directory_uri());

/* Global $content_width */
if (!isset($content_width)){
    $content_width = 1200; /* pixels */
}

/**
 * Options theme
 */
require_once FLOZEN_THEME_PATH . '/options/nasa-options.php';

add_action('after_setup_theme', 'flozen_setup');
if (!function_exists('flozen_setup')) :

    function flozen_setup() {
        load_theme_textdomain('flozen-theme', FLOZEN_THEME_PATH . '/languages');
        add_theme_support('woocommerce');
        add_theme_support('automatic-feed-links');

        add_theme_support('post-thumbnails');
        add_theme_support('title-tag');
        add_theme_support('custom-background');
        add_theme_support('custom-header');
        
        /**
         * For WP 5.8
         */
        remove_theme_support('widgets-block-editor');

        register_nav_menus(
            array(
                'primary' => esc_html__('Main Menu', 'flozen-theme')
            )
        );
        
        require_once FLOZEN_THEME_PATH . '/cores/nasa-custom-wc-ajax.php';
        require_once FLOZEN_THEME_PATH . '/cores/nasa-dynamic-style.php';
        require_once FLOZEN_THEME_PATH . '/cores/nasa-theme-options.php';
        require_once FLOZEN_THEME_PATH . '/cores/nasa-theme-functions.php';
        require_once FLOZEN_THEME_PATH . '/cores/nasa-woo-functions.php';
        require_once FLOZEN_THEME_PATH . '/cores/nasa-shop-ajax.php';
        require_once FLOZEN_THEME_PATH . '/cores/nasa-theme-headers.php';
        require_once FLOZEN_THEME_PATH . '/cores/nasa-theme-footers.php';
        require_once FLOZEN_THEME_PATH . '/cores/nasa-yith-wcwl-ext.php';
        require_once FLOZEN_THEME_PATH . '/cores/nasa-wishlist.php';
    }

endif;
