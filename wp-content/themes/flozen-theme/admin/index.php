<?php

// In Admin
/*
 * Required Plugins use in theme
 * 
 */
require_once FLOZEN_THEME_PATH . '/admin/classes/class-tgm-plugin-activation.php';
add_action('tgmpa_register', 'flozen_register_required_plugins');
function flozen_register_required_plugins() {
    $plugins = array(
        array(
            'name' => esc_html__('WooCommerce', 'flozen-theme'),
            'slug' => 'woocommerce',
            'required' => true
        ),
        
        array(
            'name' => esc_html__('Nasa Core', 'flozen-theme'),
            'slug' => 'nasa-core',
            'source' => FLOZEN_THEME_PATH . '/admin/plugins/nasa-core_v1.3.2.zip',
            'required' => true,
            'version' => '1.3.2'
        ),
        
        array(
            'name' => esc_html__('WPBakery Page Builder', 'flozen-theme'),
            'slug' => 'js_composer',
            'source' => FLOZEN_THEME_PATH . '/admin/plugins/js_composer.zip',
            'required' => true,
            'version' => '6.9.0'
        ),
        
        array(
            'name' => esc_html__('YITH WooCommerce Compare', 'flozen-theme'),
            'slug' => 'yith-woocommerce-compare',
            'required' => false
        ),
        
        array(
            'name' => esc_html__('Contact Form 7', 'flozen-theme'),
            'slug' => 'contact-form-7',
            'required' => false
        ),
        
        array(
            'name' => esc_html__('Revolution Slider', 'flozen-theme'),
            'slug' => 'revslider',
            'source' => FLOZEN_THEME_PATH . '/admin/plugins/revslider.zip',
            'required' => false,
            'version' => '6.5.20'
        )
    );

    $config = array(
        'domain' => 'flozen-theme', // Text domain - likely want to be the same as your theme.
        'default_path' => '', // Default absolute path to pre-packaged plugins
        'parent_slug' => 'themes.php', // Default parent menu slug
        'menu' => 'install-required-plugins', // Menu slug
        'has_notices' => true, // Show admin notices or not
        'is_automatic' => false, // Automatically activate plugins after installation or not
        'message' => '', // Message to output right before the plugins table
    );

    tgmpa($plugins, $config);
}

/**
 * Update VC
 */
if (function_exists('vc_set_as_theme')) {
    add_action('vc_before_init', 'flozen_vc_set_as_theme');
    function flozen_vc_set_as_theme() {
        vc_set_as_theme();
    }
}

/*
 * Title	: SMOF
 * Description	: Slightly Modified Options Framework
 * Version	: 1.5.2
 * Author	: Syamil MJ
 * Author URI	: http://aquagraphite.com
 * License	: GPLv3 - http://www.gnu.org/copyleft/gpl.html

 * define( 'SMOF_VERSION', '1.5.2' );
 * Definitions
 *
 * @since 1.4.0
 */
$smof_output = '';

if (function_exists('wp_get_theme')) {
    if (is_child_theme()) {
        $temp_obj = wp_get_theme();
        $theme_obj = wp_get_theme($temp_obj->get('Template'));
    } else {
        $theme_obj = wp_get_theme();
    }

    $theme_name = $theme_obj->get('Name');
} else {
    $theme_data = wp_get_theme(FLOZEN_THEME_PATH . '/style.css');
    $theme_name = $theme_data['Name'];
}

if (!defined('FLOZEN_ADMIN_PATH')) {
    define('FLOZEN_ADMIN_PATH', FLOZEN_THEME_PATH . '/admin/');
}

if (!defined('FLOZEN_ADMIN_DIR_URI')) {
    define('FLOZEN_ADMIN_DIR_URI', FLOZEN_THEME_URI . '/admin/');
}

define('FLOZEN_ADMIN_THEMENAME', $theme_name);
define('FLOZEN_ADMIN_SUPPORT_FORUMS', 'https://demo.nasatheme.com/docs/flozen/');

define('FLOZEN_ADMIN_BACKUPS', 'backups');

/**
 * Functions Load
 *
 * @package     WordPress
 * @subpackage  SMOF
 * @since       1.4.0
 * @author      Syamil MJ
 */
require_once FLOZEN_THEME_PATH . '/admin/dynamic-style.php';
require_once FLOZEN_THEME_PATH . '/admin/functions/functions.interface.php';
require_once FLOZEN_THEME_PATH . '/admin/functions/functions.options.php';
require_once FLOZEN_THEME_PATH . '/admin/functions/functions.admin.php';

add_action('admin_head', 'flozen_optionsframework_admin_message');
add_action('admin_init', 'flozen_optionsframework_admin_init');
add_action('admin_menu', 'flozen_optionsframework_add_admin');

/**
 * Required Files
 *
 * @since 1.0.0
 */
require_once FLOZEN_THEME_PATH . '/admin/classes/class.options_machine.php';

/**
 * AJAX Saving Options
 *
 * @since 1.0.0
 */
add_action('wp_ajax_of_ajax_post_action', 'flozen_of_ajax_callback');

/**
 * Add editor style
 */
add_editor_style();
