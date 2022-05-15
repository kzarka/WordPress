<?php
// Auto load includes files function
function nasa_includes_files($files = array()) {
    if (!empty($files)) {
        foreach ($files as $file) {
            require_once $file;
        }
    }
}

/**
 * Mobile Detect
 */
require_once NASA_CORE_PLUGIN_PATH . 'nasa_mobile_detect.php';

/**
 * Abstract files
 */
nasa_includes_files(glob(NASA_CORE_PLUGIN_PATH . 'abstracts/nasa_*.php'));

/*
 * Back-end
 */
if (NASA_CORE_IN_ADMIN) {
    nasa_includes_files(glob(NASA_CORE_PLUGIN_PATH . 'admin/incls/nasa_*.php'));
}

/**
 * Includes Short-codes
 */
nasa_includes_files(glob(NASA_CORE_PLUGIN_PATH . 'includes/shortcodes/nasa_*.php'));

/*
 * Front-end
 */
add_action('after_setup_theme', 'nasa_setup');
function nasa_setup() {
    global $nasa_opt;
    
    $arrays = array(
        'vetical-menu' => esc_html__('Vertical Menu', 'nasa-core')
    );
    
    if (isset($nasa_opt['nasa_top_menu']) && $nasa_opt['nasa_top_menu']) {
        $arrays['topbar-menu'] = esc_html__('Top Menu - Only show level 1', 'nasa-core');
    }
    
    register_nav_menus($arrays);
    
    // Includes shortcode and custom
    nasa_includes_files(glob(NASA_CORE_PLUGIN_PATH . 'includes/incls/nasa_*.php'));
    // Include custom post-type
    nasa_includes_files(glob(NASA_CORE_PLUGIN_PATH . 'post_type/incls/nasa_*.php'));
}

/**
 * Script nasa-core
 */
add_action('wp_enqueue_scripts', 'nasa_core_scripts_libs', 11);
function nasa_core_scripts_libs() {
    global $nasa_opt;
    
    /**
     * Magnigic popup
     */
    if (!wp_script_is('jquery-magnific-popup')) {
        wp_enqueue_script('jquery-magnific-popup', NASA_CORE_PLUGIN_URL . 'assets/js/min/jquery.magnific-popup.min.js', array('jquery'), null, true);
    }
    
    /**
     * Countdown
     */
    if (!wp_script_is('countdown')) {
        wp_enqueue_script('countdown', NASA_CORE_PLUGIN_URL . 'assets/js/min/countdown.min.js', array('jquery'), null, true);
        wp_localize_script(
            'countdown', 'nasa_countdown_l10n',
            array(
                'days'      => esc_html__('Days', 'nasa-core'),
                'months'    => esc_html__('Months', 'nasa-core'),
                'weeks'     => esc_html__('Weeks', 'nasa-core'),
                'years'     => esc_html__('Years', 'nasa-core'),
                'hours'     => esc_html__('Hours', 'nasa-core'),
                'minutes'   => esc_html__('Mins', 'nasa-core'),
                'seconds'   => esc_html__('Secs', 'nasa-core'),
                'day'       => esc_html__('Day', 'nasa-core'),
                'month'     => esc_html__('Month', 'nasa-core'),
                'week'      => esc_html__('Week', 'nasa-core'),
                'year'      => esc_html__('Year', 'nasa-core'),
                'hour'      => esc_html__('Hour', 'nasa-core'),
                'minute'    => esc_html__('Min', 'nasa-core'),
                'second'    => esc_html__('Sec', 'nasa-core')
            )
        );
    }
    
    /**
     * Owl-Carousel
     */
    if (!wp_script_is('owl-carousel')) {
        wp_enqueue_script('owl-carousel', NASA_CORE_PLUGIN_URL . 'assets/js/min/owl.carousel.min.js', array('jquery'), null, true);
    }
    
    /**
     * Slick slider
     */
    if (!wp_script_is('jquery-slick')) {
        wp_enqueue_script('jquery-slick', NASA_CORE_PLUGIN_URL . 'assets/js/min/jquery.slick.min.js', array('jquery'), null, true);
    }
    
    /**
     * Select2
     */
    if (class_exists('WooCommerce') && !wp_script_is('select2')) {
        wp_enqueue_script('select2', WC()->plugin_url() . '/assets/js/select2/select2.full.min.js', array('jquery'), null, true);
        wp_enqueue_style('select2');
    }
    
    /**
     * Pin products banner
     */
    wp_enqueue_script('jquery-easing', NASA_CORE_PLUGIN_URL . 'assets/js/min/jquery.easing.min.js', array('jquery'), null, true);
    wp_enqueue_script('jquery-easypin', NASA_CORE_PLUGIN_URL . 'assets/js/min/jquery.easypin.min.js', array('jquery'), null, true);
    
    /**
     * 360 Degree Product Viewer
     */
    if (!isset($nasa_opt['product_360_degree']) || $nasa_opt['product_360_degree']) {
        wp_enqueue_script('jquery-threesixty', NASA_CORE_PLUGIN_URL . 'assets/js/min/threesixty.min.js', array('jquery'), null, true);
    }
}
    
/**
 * Script nasa-core
 */
add_action('wp_enqueue_scripts', 'nasa_core_scripts_ready', 999);
function nasa_core_scripts_ready() {
    wp_enqueue_script('nasa-core-functions-js', NASA_CORE_PLUGIN_URL . 'assets/js/min/nasa.functions.min.js', array('jquery'), null, true);
    wp_enqueue_script('nasa-core-js', NASA_CORE_PLUGIN_URL . 'assets/js/min/nasa.script.min.js', array('jquery'), null, true);
    
    /**
     * Define ajax options
     */
    if (!defined('NASA_AJAX_OPTIONS')) {
        define('NASA_AJAX_OPTIONS', true);
        
        $ajax_params_options = array(
            'ajax_url' => admin_url('admin-ajax.php')
        );
        
        if (class_exists('WooCommerce')) {
            $ajax_params_options['wc_ajax_url'] = WC_AJAX::get_endpoint('%%endpoint%%');
        }
        
        $ajax_params = 'var nasa_ajax_params=' . json_encode($ajax_params_options) . ';';
        wp_add_inline_script('nasa-core-functions-js', $ajax_params, 'before');
    }
}

/**
 * Add class woo actived for body
 */
add_filter('body_class', 'nasa_add_body_classes');
function nasa_add_body_classes($classes) {
    if (class_exists('WooCommerce') && !in_array('nasa-woo-actived', $classes)) {
        $classes[] = 'nasa-woo-actived';
    }
    
    return $classes;
}
