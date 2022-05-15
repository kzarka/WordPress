<?php
/*
 * Get Header builder type
 */
function nasa_get_headers_options() {
    $headers_type = get_posts(array(
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'post_type' => 'header'
    ));
    $headers_option = array('' => esc_html__("Default", 'nasa-core'));
    if ($headers_type) {
        foreach ($headers_type as $value) {
            $headers_option[$value->post_name] = $value->post_title;
        }
    }
    
    return $headers_option;
}

/*
 * Get Footer builder type
 */
function nasa_get_footers_options() {
    $footers_type = get_posts(array(
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'post_type' => 'footer'
    ));
    $footers_option = array('' => esc_html__("Default", 'nasa-core'));
    if ($footers_type) {
        foreach ($footers_type as $value) {
            $footers_option[$value->post_name] = $value->post_title;
        }
    }
    
    return $footers_option;
}

/**
 * Get nasa blocks post type
 */
function nasa_get_blocks_options() {
    $block_type = get_posts(array(
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'post_type' => 'nasa_block'
    ));
    $arr_blocks = array('' => esc_html__("Default", 'nasa-core'));
    if (!empty($block_type)) {
        foreach ($block_type as $value) {
            $arr_blocks[$value->post_name] = $value->post_title;
        }
        
        $arr_blocks['-1'] = esc_html__('No, thanks!', 'nasa-core');
    }
    
    return $arr_blocks;
}

/**
 * Get menus
 */
function nasa_meta_getListMenus() {
    $menus = wp_get_nav_menus(array('orderby' => 'name'));
    $option_menu = array(
        '' => esc_html__('Default', 'nasa-core')
    );
    foreach ($menus as $menu_option) {
        $option_menu[$menu_option->term_id] = $menu_option->name;
    }
    
    $option_menu['-1'] = esc_html__("Don't show", 'nasa-core');

    return $option_menu;
}

/**
 * Delete cache shortcodes
 * @return boolean
 */
add_action('save_post', 'nasa_del_cache_shortcodes');
function nasa_del_cache_shortcodes() {
    if (!class_exists('Nasa_Caching')) {
        require_once NASA_CORE_PLUGIN_PATH . 'includes/incls/nasa_00_caching.php';
    }
    
    return Nasa_Caching::delete_cache('shortcodes');
}

/**
 * Delete cache variations
 * @return boolean
 */
function nasa_del_cache_variations() {
    return Nasa_Caching::delete_cache('product_variable');
}

/**
 * Clear all cache
 */
add_action('wp_ajax_nasa_clear_all_cache', 'nasa_manual_clear_cache');
function nasa_manual_clear_cache() {
    /**
     * Clear Transients deal ids
     */
    nasa_clear_transients_products_deal_ids();
    
    /**
     * Clear cache variations
     */
    $delete = nasa_del_cache_variations();
    
    /**
     * Clear cache short-codes
     */
    if ($delete) {
        $delete = nasa_del_cache_shortcodes();
    }
    
    if ($delete) {
        die('ok');
    }
    
    die('fail');
}

/**
 * Delete cache by product id
 * 
 * @param type $id
 * @return type
 */
function nasa_del_cache_by_product_id($id) {
    nasa_clear_transients_products_deal_ids();
    
    try {
        $currencies = function_exists('get_woocommerce_currencies') ? get_woocommerce_currencies() : null;
        if (!empty($currencies)) {
            foreach ($currencies as $key => $value) {
                $key_cache = $id . '_' . $key;
                Nasa_Caching::delete_cache_by_key($key_cache, 'product_variable');
            }
        }
        
        return true;
    } catch (Exception $e) {
        return false;
    }
}

/**
 * Clear Transients deal ids
 * 
 * @global type $wpdb
 */
function nasa_clear_transients_products_deal_ids() {
    global $wpdb;
    
    $wpdb->query('DELETE FROM ' . $wpdb->options . ' WHERE `option_name` LIKE "_transient_nasa_products_deal%" OR `option_name` LIKE "_transient_timeout_nasa_products_deal%"');
}

/**
 * Style | Script in Back End
 */
add_action('admin_enqueue_scripts', 'nasa_admin_style_script_fw');
function nasa_admin_style_script_fw() {
    wp_enqueue_style('nasa_back_end-css', NASA_CORE_PLUGIN_URL . 'admin/assets/nasa-core-style.css');
    wp_enqueue_script('nasa_back_end-script', NASA_CORE_PLUGIN_URL . 'admin/assets/nasa-core-script.js');
    $nasa_core_js = 'var ajax_admin_nasa_core="' . esc_url(admin_url('admin-ajax.php')) . '";';
    wp_add_inline_script('nasa_back_end-script', $nasa_core_js, 'before');
}
