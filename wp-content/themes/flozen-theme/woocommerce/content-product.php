<?php
/**
 *
 * The template for displaying product content within loops
 *
 * 
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.6.0
 */
global $product;
if (empty($product) || !$product->is_visible()) :
    return;
endif;

if(!isset($_delay)) :
    $_delay = 0;
endif;

if (!isset($wrapper) || $wrapper == 'li') :
    echo '<li class="product-warp-item">';
    echo '<hr class="nasa-hr-list-style hidden-tag" />';
endif;
?>

<div <?php wc_product_class('', $product); ?> data-wow-duration="1s" data-wow-delay="<?php echo esc_attr($_delay); ?>ms" data-wow="fadeInUp">
    <?php

    /**
     * Hook: woocommerce_before_shop_loop_item.
     *
     * @removed woocommerce_template_loop_product_link_open - 10
     */
    do_action('woocommerce_before_shop_loop_item');

    /**
     * Hook: woocommerce_before_shop_loop_item_title.
     *
     * @removed woocommerce_template_loop_product_thumbnail - 10
     * @removed woocommerce_show_product_loop_sale_flash - 10
     * 
     * @hooked flozen_open_before_shop_loop_item_title - 1
     * @hooked flozen_loop_product_content_thumbnail - 10
     * @hooked flozen_add_custom_sale_flash - 11
     * @hooked flozen_gift_featured - 20
     * @hooked flozen_loop_item_product_time_sale - 95
     * @hooked flozen_close_before_shop_loop_item_title - 100
     */
    do_action('woocommerce_before_shop_loop_item_title');

    /**
     * Hook: woocommerce_shop_loop_item_title.
     *
     * @removed woocommerce_template_loop_product_title - 10
     * 
     * @hooked flozen_open_shop_loop_item_title - 1
     * @hooked flozen_custom_content_nasa_core - 5
     * @hooked flozen_loop_product_cats - 10
     * @hooked flozen_loop_product_content_title - 10
     * @hooked woocommerce_template_loop_rating - 10
     * @hooked flozen_loop_product_price - 10
     * @hooked flozen_loop_product_description - 15
     * @hooked flozen_close_shop_loop_item_title - 100
     */
    do_action('woocommerce_shop_loop_item_title');

    /**
     * Hook: woocommerce_after_shop_loop_item_title.
     *
     * @removed woocommerce_template_loop_rating - 5
     * @removed woocommerce_template_loop_price - 10
     * 
     * All Devices
     * @hooked flozen_clear_box_shadow - 15
     * @hooked flozen_open_wrap_btns - 20
     * @hooked flozen_add_wishlist_in_list - 25
     * @hooked flozen_add_compare_in_list - 30
     * 
     * In Mobile
     * @hooked flozen_quickview_in_list - 35
     * @hooked flozen_add_to_cart_in_list - 35
     * 
     * All Devices
     * @hooked flozen_close_wrap_btns - 90
     * @hooked flozen_open_wrap_more_hover - 100
     * 
     * In Desktop
     * @hooked flozen_open_wrap_btns_noop - 110
     * @hooked flozen_add_to_cart_in_list - 115
     * @hooked flozen_quickview_in_list - 120
     * @hooked flozen_close_wrap_btns_noop - 200
     *
     * All Devices 
     * @hooked flozen_close_wrap_more_hover - 1000
     */
    do_action('woocommerce_after_shop_loop_item_title');

    /**
     * Hook: woocommerce_after_shop_loop_item.
     *
     * @removed woocommerce_template_loop_product_link_close - 5
     * @removed woocommerce_template_loop_add_to_cart - 10
     */
    do_action('woocommerce_after_shop_loop_item');
    ?>
</div>
<?php
if (!isset($wrapper) || $wrapper == 'li') :
    echo '</li>';
endif;
