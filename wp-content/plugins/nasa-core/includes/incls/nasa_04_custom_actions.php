<?php
add_action('init', 'nasa_custom_woo_actions');
function nasa_custom_woo_actions() {
    if (!defined('NASA_THEME_PREFIX') || NASA_THEME_PREFIX !== 'flozen') {
        return;
    }
    
    /**
     * Badges
     */
    add_action('nasa_special_deal_simple_action', 'flozen_add_custom_sale_flash');
    
    /**
     * Open wrap buttons
     */
    add_action('nasa_special_deal_simple_action', 'flozen_open_wrap_btns_noop');
    
    /**
     * Buttons Add to cart
     */
    add_action('nasa_special_deal_simple_action', 'flozen_add_to_cart_in_list');
    
    /**
     * Buttons Wishlist
     */
    add_action('nasa_special_deal_simple_action', 'flozen_add_wishlist_in_list');
    
    /**
     * Buttons Quick view
     */
    add_action('nasa_special_deal_simple_action', 'flozen_quickview_in_list');
    
    /**
     * Buttons Compare
     */
    add_action('nasa_special_deal_simple_action', 'flozen_add_compare_in_list');
    
    /**
     * Close wrap buttons
     */
    add_action('nasa_special_deal_simple_action', 'flozen_close_wrap_btns_noop');
    
}