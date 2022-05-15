<?php

/**
 * SMOF Interface
 *
 * @package     WordPress
 * @subpackage  SMOF
 * @since       1.4.0
 * @author      Syamil MJ
 */

/**
 * Admin Init
 *
 * @uses wp_verify_nonce()
 * @uses header()
 *
 * @since 1.0.0
 */
function flozen_optionsframework_admin_init() {
    // Rev up the Options Machine
    global $of_options, $options_machine, $smof_data, $smof_details;
    if (!isset($options_machine)) {
        $options_machine = new Flozen_Options_Machine($of_options);
    }

    do_action('optionsframework_admin_init_before', array(
        'of_options' => $of_options,
        'options_machine' => $options_machine,
        'smof_data' => $smof_data
    ));

    if (empty($smof_data['smof_init'])) { // Let's set the values if the theme's already been active
        flozen_of_save_options($options_machine->Defaults);
        flozen_of_save_options(date('r'), 'smof_init');
        $smof_data = flozen_of_get_options();
        $options_machine = new Flozen_Options_Machine($of_options);
    }

    do_action('optionsframework_admin_init_after', array(
        'of_options' => $of_options,
        'options_machine' => $options_machine,
        'smof_data' => $smof_data
    ));
}

/**
 * Create Options page
 *
 * @uses add_theme_page()
 * @uses add_action()
 *
 * @since 1.0.0
 */
function flozen_optionsframework_add_admin() {
    $titleOption = esc_html__('NasaTheme Options', 'flozen-theme');
    $of_page = add_theme_page(FLOZEN_ADMIN_THEMENAME, $titleOption, 'edit_theme_options', 'optionsframework', 'flozen_optionsframework_options_page');

    // Add framework functionaily to the head individually
    add_action("admin_print_scripts-$of_page", 'flozen_of_load_only');
    add_action("admin_print_styles-$of_page", 'flozen_of_style_only');
}

/**
 * Build Options page
 *
 * @since 1.0.0
 */
function flozen_optionsframework_options_page() {
    global $options_machine;
    include_once FLOZEN_ADMIN_PATH . 'front-end/options.php';
}

/**
 * Create Options page
 *
 * @uses wp_enqueue_style()
 *
 * @since 1.0.0
 */
function flozen_of_style_only() {
    wp_enqueue_style('nasa-theme-admin-style', FLOZEN_ADMIN_DIR_URI . 'assets/css/admin-style.css');
    wp_enqueue_style('jquery-ui-custom-admin', FLOZEN_ADMIN_DIR_URI . 'assets/css/jquery-ui-custom.css');

    if (!wp_style_is('wp-color-picker', 'registered')) {
        wp_register_style('wp-color-picker', FLOZEN_ADMIN_DIR_URI . 'assets/css/color-picker.min.css');
    }
    wp_enqueue_style('wp-color-picker');
    do_action('of_style_only_after');
}

/**
 * Create Options page
 *
 * @uses add_action()
 * @uses wp_enqueue_script()
 *
 * @since 1.0.0
 */
function flozen_of_load_only() {
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-sortable');
    wp_enqueue_script('jquery-ui-slider');
    wp_enqueue_script('jquery-input-mask', FLOZEN_ADMIN_DIR_URI . 'assets/js/jquery.maskedinput-1.2.2.js', array('jquery'));
    wp_enqueue_script('tipsy', FLOZEN_ADMIN_DIR_URI . 'assets/js/jquery.tipsy.js', array('jquery'));
    wp_enqueue_script('cookie', FLOZEN_ADMIN_DIR_URI . 'assets/js/cookie.js', 'jquery');
    wp_enqueue_script('smof', FLOZEN_ADMIN_DIR_URI . 'assets/js/smof.js', array('jquery'));


    // Enqueue colorpicker scripts for versions below 3.5 for compatibility
    if (!wp_script_is('wp-color-picker', 'registered')) {
        wp_register_script('iris', FLOZEN_ADMIN_DIR_URI . 'assets/js/iris.min.js', array('jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch'), false, 1);
        wp_register_script('wp-color-picker', FLOZEN_ADMIN_DIR_URI . 'assets/js/color-picker.min.js', array('jquery', 'iris'));
    }
    wp_enqueue_script('wp-color-picker');

    /**
     * Enqueue scripts for file uploader
     */
    if (function_exists('wp_enqueue_media')) {
        wp_enqueue_media();
    }

    do_action('of_load_only_after');
}

/**
 * Ajax Save Options
 *
 * @uses get_option()
 *
 * @since 1.0.0
 */
function flozen_of_ajax_callback() {
    global $options_machine, $of_options;

    $nonce = $_POST['security'];

    if (!wp_verify_nonce($nonce, 'of_ajax_nonce')) {
        die('-1');
    }

    //get options array from db
    $all = flozen_of_get_options();

    $save_type = $_POST['type'];

    switch ($save_type) {
        case 'upload':
            $clickedID = $_POST['data']; // Acts as the name
            $filename = $_FILES[$clickedID];
            $filename['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $filename['name']);

            $override['test_form'] = false;
            $override['action'] = 'wp_handle_upload';
            $uploaded_file = wp_handle_upload($filename, $override);

            // $upload_tracking[] = $clickedID;

            // update $options array w/ image URL
            // preserve current data
            $upload_image = $all;

            $upload_image[$clickedID] = $uploaded_file['url'];
            flozen_of_save_options($upload_image);
            
            // Is the Response
            echo !empty($uploaded_file['error']) ? 
                'Upload Error: ' . $uploaded_file['error'] : $uploaded_file['url'];
            break;
        
        case 'image_reset':
            $id = $_POST['data']; // Acts as the name

            $delete_image = $all; //preserve rest of data
            $delete_image[$id] = ''; //update array key with empty value	 
            flozen_of_save_options($delete_image);
            break;
        
        case 'backup_options':
            $backup = $all;
            $backup['backup_log'] = date('r');

            flozen_of_save_options($backup, FLOZEN_ADMIN_BACKUPS);
            nasa_theme_rebuilt_css_dynamic();
            flozen_save_option_woo_customize();
            
            die('1');
            break;
        
        case 'restore_options':
            $smof_data = flozen_of_get_options(FLOZEN_ADMIN_BACKUPS);
            flozen_of_save_options($smof_data);
            nasa_theme_rebuilt_css_dynamic();
            flozen_save_option_woo_customize();
            
            die('1');
            break;
        
        case 'import_options':
            $smof_data = json_decode($_POST['data'], true);
            flozen_of_save_options($smof_data);
            nasa_theme_rebuilt_css_dynamic();
            flozen_save_option_woo_customize();
            
            die('1');
            break;
        
        case 'save':
            wp_parse_str(stripslashes($_POST['data']), $smof_data);
            unset($smof_data['security']);
            unset($smof_data['of_save']);
            flozen_of_save_options($smof_data);
            nasa_theme_rebuilt_css_dynamic();
            flozen_save_option_woo_customize();

            die('1');
            break;
        
        case 'reset':
            flozen_of_save_options($options_machine->Defaults);
            nasa_theme_rebuilt_css_dynamic();
            flozen_save_option_woo_customize();
            
            die('1'); //options reset
            break;
        
        default:
            die();
    }
}

/**
 * Rebuilt dynamic style site
 * @global type $wp_filesystem
 */
function nasa_theme_rebuilt_css_dynamic() {
    global $wp_filesystem, $nasa_upload_dir;
    
    $upload_dir = !isset($nasa_upload_dir) ? wp_upload_dir() : $nasa_upload_dir;
    $dynamic_path = $upload_dir['basedir'] . '/nasa-dynamic';
    
    // Initialize the WP filesystem, no more using 'file-put-contents' function
    if (empty($wp_filesystem)) {
        require_once ABSPATH . '/wp-admin/includes/file.php';
        WP_Filesystem();
    }
            
    if(!$wp_filesystem->is_dir($dynamic_path)) {
        if (!wp_mkdir_p($dynamic_path)){
            return true;
        }
    }
    // get the upload directory and make a dynamic.css file
    $filename = $dynamic_path . '/dynamic.css';
    
    $data = get_theme_mods();
    $css = flozen_get_content_custom_css($data);
    if (!$wp_filesystem->put_contents($filename, $css, FS_CHMOD_FILE)) {
        return true;
    }
    
    set_theme_mod('nasa_dynamic_t', NASA_TIME_NOW);
    
    return false;
}

function flozen_save_option_woo_customize() {
    if (!NASA_WOO_ACTIVED) {
        return;
    }
    $columns = get_option('woocommerce_catalog_columns', 4);
    
    $data = get_theme_mods();
    if (isset($data['products_per_row']) && (int) $data['products_per_row'] != $columns) {
        update_option('woocommerce_catalog_columns', (int) $data['products_per_row']);
    }
}

add_action('customize_save_after', 'flozen_sync_option_theme');
function flozen_sync_option_theme() {
    if (!NASA_WOO_ACTIVED) {
        return;
    }
    $columns = get_option('woocommerce_catalog_columns', 4);
    $data = get_theme_mods();
    if (!isset($data['products_per_row']) || (int) $data['products_per_row'] != $columns) {
        set_theme_mod('products_per_row', $columns . '-cols');
    }
}