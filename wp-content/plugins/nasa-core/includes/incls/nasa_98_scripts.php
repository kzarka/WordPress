<?php
/**
 * Send headers for Ajax Requests.
 */
function nasa_ajax_headers() {
    send_origin_headers();
    @header('Content-Type: text/html; charset=' . get_option('blog_charset'));
    @header('X-Robots-Tag: noindex');
    send_nosniff_header();
    wc_nocache_headers();
    status_header(200);
}

// **********************************************************************//
//	Support Multi currency - AJAX
// **********************************************************************//
if (class_exists('WCML_Multi_Currency')) :
    add_filter('wcml_multi_currency_ajax_actions', 'nasa_multi_currency_ajax', 10, 1);
    if (!function_exists('nasa_multi_currency_ajax')) :
        function nasa_multi_currency_ajax($ajax_actions) {
            return nasa_ajax_actions($ajax_actions);
        }
    endif;
endif;

/**
 * Register Ajax Actions
 * 
 * @param type $ajax_actions
 * @return string
 */
function nasa_ajax_actions($ajax_actions = array()) {
    // $ajax_actions[] = 'nasa_more_product';

    return $ajax_actions;
}
