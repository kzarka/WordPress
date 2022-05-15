<?php
/**
 * Related Products
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author 	WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.9.0
 */
if (!defined('ABSPATH')) :
    exit;
endif;

if ($related_products) :
    global $nasa_opt;

    $columns_desk = !isset($nasa_opt['relate_columns_desk']) || !(int) $nasa_opt['relate_columns_desk'] ? 3 : (int) $nasa_opt['relate_columns_desk'];
    $columns_tablet = !isset($nasa_opt['relate_columns_tablet']) || !(int) $nasa_opt['relate_columns_tablet'] ? 3 : (int) $nasa_opt['relate_columns_tablet'];
    $columns_small = !isset($nasa_opt['relate_columns_small']) || !(int) $nasa_opt['relate_columns_small'] ? 2 : (int) $nasa_opt['relate_columns_small'];
    
    $_delay = 0;
    $_delay_item = (isset($nasa_opt['delay_overlay']) && (int) $nasa_opt['delay_overlay']) ? (int) $nasa_opt['delay_overlay'] : 100;
    ?>
    <div class="related-product">
        <div class="related products grid margin-bottom-40">
            <div class="row nasa-warp-slide-nav-side nasa-slider-wrap">
                <div class="large-12 columns">
                    <div class="nasa-slide-style-product-carousel">
                        <h4 class="nasa-shortcode-title-slider text-center">
                            <?php echo apply_filters('woocommerce_product_related_products_heading', esc_html__('Related Products', 'flozen-theme')); ?>
                        </h4>
                        <div class="nasa-nav-carousel-wrap nasa-carousel-related text-right">
                            <div class="nasa-nav-carousel-prev nasa-nav-carousel-div">
                                <a class="nasa-nav-icon-slider" href="javascript:void(0);" data-do="prev">
                                    <span class="pe-7s-angle-left"></span>
                                </a>
                            </div>
                            <div class="nasa-nav-carousel-next nasa-nav-carousel-div">
                                <a class="nasa-nav-icon-slider" href="javascript:void(0);" data-do="next">
                                    <span class="pe-7s-angle-right"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="large-12 columns">
                    <div
                        class="nasa-slider owl-carousel products-group nasa-slider-grid"
                        data-columns="<?php echo absint($columns_desk); ?>"
                        data-columns-small="<?php echo absint($columns_small); ?>"
                        data-columns-tablet="<?php echo absint($columns_tablet); ?>"
                        data-margin="0"
                        data-margin-small="0"
                        data-margin-medium="0"
                        data-padding="0px"
                        data-switch-tablet="<?php echo flozen_switch_tablet(); ?>"
                        data-switch-desktop="<?php echo flozen_switch_desktop(); ?>"
                        data-disable-nav="true">
                        <?php
                        foreach ($related_products as $related_product) :
                            $post_object = get_post($related_product->get_id());
                            setup_postdata($GLOBALS['post'] = & $post_object);
                            // Product Item -->
                            wc_get_template('content-product.php', array(
                                '_delay' => $_delay,
                                'wrapper' => 'div',
                                'combo_show_type' => 'popup',
                                'disable_drag' => true
                            ));
                            // End Product Item -->
                            $_delay += $_delay_item;
                        endforeach;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php

endif;

wp_reset_postdata();
