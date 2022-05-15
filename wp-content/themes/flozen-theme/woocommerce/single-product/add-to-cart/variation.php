<?php
/**
 * Single variation display
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.5.0
 */
defined('ABSPATH') || exit;
?>
<script type="text/template" id="tmpl-variation-template">
    <div class="woocommerce-variation-description">{{{data.variation.variation_description}}}</div>
    <div class="woocommerce-variation-price">{{{data.variation.price_html}}}</div>
            
    <div class="hidden-tag nasa-single-product-countdown bg-single-product-gray margin-right-10 rtl-margin-right-0 rtl-margin-left-10"><table class="margin-bottom-0"><tr><td class="nasa-single-label"><span class="nasa-bold"><?php echo esc_html__('Expires Times', 'flozen-theme'); ?></span></td><td class="nasa-single-content"><div class="nasa-detail-product-deal-countdown nasa-product-variation-countdown"></div></td></tr></table></div>
    
    <div class="woocommerce-variation-availability bg-single-product-gray margin-right-10 rtl-margin-right-0 rtl-margin-left-10">{{{data.variation.availability_html}}}</div>
</script>
<script type="text/template" id="tmpl-unavailable-variation-template">
    <p><?php _e('Sorry, this product is unavailable. Please choose a different combination.', 'flozen-theme'); ?></p>
</script>
