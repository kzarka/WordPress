<?php
/**
 * Register Ajax Actions
 */
if (!function_exists('flozen_ajax_actions')) :
    function flozen_ajax_actions($ajax_actions = array()) {
        $ajax_actions[] = 'nasa_update_wishlist';
        $ajax_actions[] = 'nasa_remove_from_wishlist';
        $ajax_actions[] = 'live_search_products';

        return $ajax_actions;
    }
endif;

/**
 * Map short code for ajax
 */
if (!function_exists('flozen_init_map_shortcode')) :
    function flozen_init_map_shortcode() {
        if (class_exists('WPBMap')) {
            WPBMap::addAllMappedShortcodes();
        }
    }
endif;

// **********************************************************************//
//	Update wishlist - AJAX
// **********************************************************************//
add_action('wp_ajax_nasa_update_wishlist', 'flozen_update_wishlist');
add_action('wp_ajax_nopriv_nasa_update_wishlist', 'flozen_update_wishlist');
if (!function_exists('flozen_update_wishlist')) :
    function flozen_update_wishlist(){
        $json = array(
            'list' => '',
            'count' => 0
        );

        $json['list'] = flozen_mini_wishlist_sidebar(true);
        $json['status_add'] = 'true';
        $count = function_exists('yith_wcwl_count_products') ? yith_wcwl_count_products() : 0;
        $nasaSl = (int) $count > 9 ? '9+' : (int) $count;
        $json['count'] = apply_filters('nasa_mini_compare_total_items', $nasaSl);
        
        if (NASA_WISHLIST_NEW_VER && isset($_REQUEST['added']) && $_REQUEST['added']) {
            $json['mess'] = '<div id="yith-wcwl-message">' . esc_html__('Product Added!', 'flozen-theme') . '</div>';
        }

        die(json_encode($json));
    }
endif;

// **********************************************************************//
//	Add to wishlist - AJAX
// **********************************************************************//
add_action('wp_ajax_nasa_remove_from_wishlist', 'flozen_remove_from_wishlist');
add_action('wp_ajax_nopriv_nasa_remove_from_wishlist', 'flozen_remove_from_wishlist');
if (!function_exists('flozen_remove_from_wishlist')) :
    function flozen_remove_from_wishlist(){
        $json = array(
            'error' => '1',
            'list' => '',
            'count' => 0,
            'mess' => ''
        );

        if (!NASA_WISHLIST_ENABLE) {
            die(json_encode($json));
        }

        $detail = array();
        $detail['remove_from_wishlist'] = isset($_REQUEST['pid']) ? (int) $_REQUEST['pid'] : 0;
        $detail['wishlist_id'] = isset($_REQUEST['wishlist_id']) ? (int) $_REQUEST['wishlist_id'] : 0;
        $detail['pagination'] = isset($_REQUEST['pagination']) ? (int) $_REQUEST['pagination'] : 'no';
        $detail['per_page'] = isset($_REQUEST['per_page']) ? (int) $_REQUEST['per_page'] : 5;
        $detail['current_page'] = isset($_REQUEST['current_page']) ? (int) $_REQUEST['current_page'] : 1;
        $detail['user_id'] = is_user_logged_in() ? get_current_user_id() : false;
        
        $mess_success = '<div id="yith-wcwl-message">' . esc_html__('Product successfully removed!', 'flozen-theme') . '</div>';
        
        if (!NASA_WISHLIST_NEW_VER) {
            $nasa_wishlist = new YITH_WCWL($detail);
            $json['error'] = flozen_remove_wishlist_item($nasa_wishlist, true) ? '0' : '1';

            if ($json['error'] == '0') {
                $json['list'] = flozen_mini_wishlist_sidebar(true);

                $count = yith_wcwl_count_products();
                $nasaSl = (int) $count > 9 ? '9+' : (int) $count;
                $json['count'] = apply_filters('nasa_mini_compare_total_items', $nasaSl);
                $json['mess'] = $mess_success;
            }
        } else {
            try{
                YITH_WCWL()->remove($detail);
                $json['list'] = flozen_mini_wishlist_sidebar(true);
                $count = yith_wcwl_count_products();
                $nasaSl = (int) $count > 9 ? '9+' : (int) $count;
                $json['count'] = apply_filters('nasa_mini_compare_total_items', $nasaSl);
                $json['mess'] = $mess_success;
                $json['error'] = '0';
            }
            catch(Exception $e){
                $json['mess'] = $e->getMessage();
            }
        }

        die(json_encode($json));
    }
endif;

/**
 * Remove Wishlist item
 */
if (!function_exists('flozen_remove_wishlist_item')) :
    function flozen_remove_wishlist_item($nasa_wishlist = null, $remove_force = false) {
        if (get_option('yith_wcwl_remove_after_add_to_cart') == 'yes' || $remove_force) {
            if (!$nasa_wishlist->details['user_id']){
                $wishlist = yith_getcookie('yith_wcwl_products');
                
                foreach($wishlist as $key => $item){
                    if ($item['prod_id'] == $nasa_wishlist->details['remove_from_wishlist']){
                        unset($wishlist[$key]);
                    }
                }
                
                yith_setcookie('yith_wcwl_products', $wishlist);

                return true;
            }

            return $nasa_wishlist->remove();
        }

        return true;
    }
endif;

/**
 * Search Hot keywords
 */
add_action('nasa_before_btn_submit_search', 'flozen_show_hot_keys');
if (!function_exists('flozen_show_hot_keys')) :
    function flozen_show_hot_keys() {
        global $nasa_opt;
        
        if (!isset($nasa_opt['hotkeys_search']) || trim($nasa_opt['hotkeys_search']) === '') {
            return;
        }
        
        echo '<div class="nasa-hotkeys-search">';
        echo '<label class="nasa-hotkeys-label">' . esc_html__('Hot Keywords:', 'flozen-theme') . '</label>';
        echo '<span>' . $nasa_opt['hotkeys_search'] . '</span>';
        echo '</div>';
    }
endif;

/**
 * Ajax search
 */
add_action('wp_ajax_nopriv_live_search_products', 'flozen_live_search_products');
add_action('wp_ajax_live_search_products', 'flozen_live_search_products');
if (!function_exists('flozen_live_search_products')) :
    function flozen_live_search_products() {
        global $nasa_opt, $woocommerce;

        $results = array();
        if (!$woocommerce || !isset($_GET['s']) || trim($_GET['s']) == '') {
            die(json_encode($results));
        }
        
        $limit = (isset($nasa_opt['limit_results_search']) && (int) $nasa_opt['limit_results_search'] > 0) ? (int) $nasa_opt['limit_results_search'] : 5;
        
        $data_store = WC_Data_Store::load('product');
        $products = $data_store->get_products(
            array(
                's' => $_REQUEST['s'],
                'status' => array('publish'),
                'limit' => $limit,
                'orderby' => 'relevance'
            )
        );
        
        if ($products) {
            foreach ($products as $product) {
                $title = $product->get_name();

                $results[] = array(
                    'title' => $title,
                    'url' => $product->get_permalink(),
                    'image' => $product->get_image(),
                    'price' => $product->get_price_html()
                );
            }
        }
        
        die(json_encode($results));
    }
endif;

add_action('wp_head', 'flozen_search_live_options', 0, 0);
if (!function_exists('flozen_search_live_options')) :
    function flozen_search_live_options() {
        global $nasa_opt;
        
        $enable = isset($nasa_opt['enable_live_search']) ? $nasa_opt['enable_live_search'] : true;
        if ($enable) {
            wp_enqueue_script('nasa-typeahead-js', FLOZEN_THEME_URI . '/assets/js/min/typeahead.bundle.min.js', array('jquery'), null, true);
            wp_enqueue_script('nasa-handlebars', FLOZEN_THEME_URI . '/assets/js/min/handlebars.min.js', array('nasa-typeahead-js'), null, true);
        }

        $search_options = array(
            'live_search_template' => 
                '<div class="item-search">' .
                    '<a href="{{url}}" class="nasa-link-item-search" title="{{title}}">' .
                        '{{{image}}}' .
                        '<div class="nasa-item-title-search">' .
                            '<p class="nasa-title-item">{{title}}</p>' .
                            '<div class="price">{{{price}}}</div>' .
                        '</div>' .
                    '</a>' .
                '</div>',
            'enable_live_search' => $enable,
            'limit_results' => (isset($nasa_opt['limit_results_search']) && (int) $nasa_opt['limit_results_search'] > 0) ? (int) $nasa_opt['limit_results_search'] : 5,
        );

        echo '<script>var search_options=' . ($enable ? json_encode($search_options) : '"0"') . ';</script>';
    }
endif;

// Login Ajax
add_action('wp_ajax_nopriv_nasa_process_login', 'flozen_process_login');
add_action('wp_ajax_nasa_process_login', 'flozen_process_login');
if (!function_exists('flozen_process_login')) :
    function flozen_process_login() {
        $mess = array('error' => '1', 'mess' => esc_html__('Error.', 'flozen-theme'), '_wpnonce' => '0');
        !empty($_REQUEST['data']) or die(json_encode($mess));
        
        $input = array();
        foreach ($_REQUEST['data'] as $values) {
            if (isset($values['name']) && isset($values['value'])) {
                $input[$values['name']] = $values['value'];
            }
        }

        if (isset($input['woocommerce-login-nonce'])) {
            $nonce_value = $input['woocommerce-login-nonce'];
        } else {
            $nonce_value = isset($input['_wpnonce']) ? $input['_wpnonce'] : '';
        }

        // Check _wpnonce
        if (!wp_verify_nonce($nonce_value, 'woocommerce-login')) {
            $mess['_wpnonce'] = 'error';
            die(json_encode($mess));
        }

        if (!empty($_REQUEST['login'])) {
            $creds    = array();
            $username = trim($input['nasa_username']);

            $validation_error = new WP_Error();
            $validation_error = apply_filters('woocommerce_process_login_errors', $validation_error, $input['nasa_username'], $input['nasa_username']);

            // Login error
            if ($validation_error->get_error_code()) {
                $mess['mess'] = '<strong>' . esc_html__('Error', 'flozen-theme') . ':</strong> ' . $validation_error->get_error_message();

                die(json_encode($mess));
            }

            // Require username
            if (empty($username)) {
                $mess['mess'] = '<strong>' . esc_html__('Error', 'flozen-theme') . ':</strong> ' . esc_html__('Username is required.', 'flozen-theme');

                die(json_encode($mess));
            }

            // Require Password
            if (empty($input['nasa_password'])) {
                $mess['mess'] = '<strong>' . esc_html__('Error', 'flozen-theme') . ':</strong> ' . esc_html__('Password is required.', 'flozen-theme');

                die(json_encode($mess));
            }

            if (is_email($username) && apply_filters('woocommerce_get_username_from_email', true)) {
                $user = get_user_by('email', $username);

                if (!isset($user->user_login)) {
                    // Email error
                    $mess['mess'] = '<strong>' . esc_html__('Error', 'flozen-theme') . ':</strong> ' . esc_html__('A user could not be found with this email address.', 'flozen-theme');

                    die(json_encode($mess));
                }

                $creds['user_login'] = $user->user_login;
            } else {
                $creds['user_login'] = $username;
            }

            $creds['user_password'] = $input['nasa_password'];
            $creds['remember'] = isset($input['nasa_rememberme']);
            $secure_cookie = is_ssl() ? true : false;
            $user = wp_signon(apply_filters('woocommerce_login_credentials', $creds), $secure_cookie);

            if (is_wp_error($user)) {
                // Other Error
                $message = $user->get_error_message();
                $mess['mess'] = str_replace(
                    '<strong>' . esc_html($creds['user_login']) . '</strong>',
                    '<strong>' . esc_html($username) . '</strong>',
                    $message
                );

                die(json_encode($mess));
            } else {
                // Login success
                $mess['error'] = '0';
                if (! empty($input['nasa_redirect'])) {
                    $redirect = $input['nasa_redirect'];
                } elseif (wp_get_referer()) {
                    $redirect = wp_get_referer();
                } else {
                    $redirect = NASA_WOO_ACTIVED ? wc_get_page_permalink('myaccount') : home_url('/');
                }

                $mess['mess'] = esc_html__('Login success.', 'flozen-theme');
                $mess['redirect'] = $redirect;
            }
        }

        die(json_encode($mess));
    }
endif;

// Register Ajax
add_action('wp_ajax_nopriv_nasa_process_register', 'flozen_process_register');
add_action('wp_ajax_nasa_process_register', 'flozen_process_register');
if (!function_exists('flozen_process_register')) :
    function flozen_process_register() {
        !empty($_REQUEST['data']) or die;
        $mess = array('error' => '1', 'mess' => esc_html__('Error.', 'flozen-theme'), '_wpnonce' => '0');
        $input = array();
        foreach ($_REQUEST['data'] as $values) {
            if (isset($values['name']) && isset($values['value'])) {
                $input[$values['name']] = $values['value'];
            }
        }

        if (isset($input['woocommerce-register-nonce'])) {
            $nonce_value = $input['woocommerce-register-nonce'];
        } else {
            $nonce_value = isset($input['_wpnonce']) ? $input['_wpnonce'] : '';
        }
        
        // Check _wpnonce
        if (!wp_verify_nonce($nonce_value, 'woocommerce-register')) {
            $mess['_wpnonce'] = 'error';
            die(json_encode($mess));
        }

        if (! empty($_REQUEST['register'])) {
            $username = 'no' === get_option('woocommerce_registration_generate_username') ? $input['nasa_username'] : '';
            $password = 'no' === get_option('woocommerce_registration_generate_password') ? $input['nasa_password'] : '';
            $email    = $input['nasa_email'];

            $validation_error = new WP_Error();
            $validation_error = apply_filters('woocommerce_process_registration_errors', $validation_error, $username, $password, $email);

            if ($validation_error->get_error_code()) {
                $mess['mess'] = $validation_error->get_error_message();
                die(json_encode($mess));
            }

            // Anti-spam trap
            if (! empty($input['nasa_email_2'])) {
                $mess['mess'] = esc_html__('Anti-spam field was filled in.', 'flozen-theme');
                die(json_encode($mess));
            }

            $new_customer = wc_create_new_customer(sanitize_email($email), wc_clean($username), $password);

            if (is_wp_error($new_customer)) {
                $mess['mess'] = $new_customer->get_error_message();
                die(json_encode($mess));
            }

            if (apply_filters('woocommerce_registration_auth_new_customer', true, $new_customer)) {
                wc_set_customer_auth_cookie($new_customer);
            }

            // Register success.
            $mess['error'] = '0';
            $mess['mess'] = esc_html__('Register success.', 'flozen-theme');
            $mess['redirect'] = apply_filters('woocommerce_registration_redirect', wp_get_referer() ? wp_get_referer() : (NASA_WOO_ACTIVED ? wc_get_page_permalink('myaccount') : home_url('/')));
        }

        die(json_encode($mess));
    }
endif;

// **********************************************************************//
//	Support Multi currency - AJAX
// **********************************************************************//
if (class_exists('WCML_Multi_Currency')) :
    add_filter('wcml_multi_currency_ajax_actions', 'flozen_multi_currency_ajax', 10, 1);
    if (!function_exists('flozen_multi_currency_ajax')) :
        function flozen_multi_currency_ajax($ajax_actions) {
            return flozen_ajax_actions($ajax_actions);
        }
    endif;
endif;
