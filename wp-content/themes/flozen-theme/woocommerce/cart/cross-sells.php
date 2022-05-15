<?php
/**
 * Cross-sells
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 4.4.0
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if ($cross_sells) :
    global $nasa_opt;

    $columns_desk = !isset($nasa_opt['relate_columns_desk']) || !(int) $nasa_opt['relate_columns_desk'] ? 3 : (int) $nasa_opt['relate_columns_desk'];
    
    $columns_tablet = !isset($nasa_opt['relate_columns_tablet']) || !(int) $nasa_opt['relate_columns_tablet'] ? 3 : (int) $nasa_opt['relate_columns_tablet'];
    $columns_small = !isset($nasa_opt['relate_columns_small']) || !(int) $nasa_opt['relate_columns_small'] ? 1 : (int) $nasa_opt['relate_columns_small'];
    
    $class_wrap = 'related products grid margin-bottom-40';
    
    if (isset($_REQUEST['nasa_action']) && $_REQUEST['nasa_action'] === 'nasa_after_add_to_cart') {
        $columns_desk = '4';
        $columns_tablet = '3';
        $columns_small = '2';
        $class_wrap = 'related products grid desktop-padding-bottom-30';
    }
    
    $_delay = 0;
    $_delay_item = (isset($nasa_opt['delay_overlay']) && (int) $nasa_opt['delay_overlay']) ? (int) $nasa_opt['delay_overlay'] : 100;
    
    $heading = apply_filters('woocommerce_product_cross_sells_products_heading', esc_html__('You may be interested in&hellip;', 'zella-theme'));
    ?>

    <div class="nasa-cross-sells cross-sells related-product margin-top-50">
        <div class="<?php echo esc_attr($class_wrap); ?>">
            <div class="row nasa-slider-wrap nasa-warp-slide-nav-side">
                <?php if ($heading) : ?>
                    <div class="large-12 columns">
                        <div class="nasa-slide-style-product-carousel">

                            <h4 class="nasa-shortcode-title-slider text-center">
                                <?php esc_html_e('You may be interested in&hellip;', 'flozen-theme') ?>
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
                <?php endif; ?>
                
                <div class="large-12 columns">
                    <div
                        class="nasa-slider owl-carousel products-group products grid nasa-slider-grid"
                        data-columns="<?php echo (int) $columns_desk; ?>"
                        data-columns-small="<?php echo (int) $columns_small; ?>"
                        data-columns-tablet="<?php echo (int) $columns_tablet; ?>"
                        data-margin="10"
                        data-margin-small="0"
                        data-margin-medium="0"
                        data-padding="0px"
                        data-switch-tablet="<?php echo flozen_switch_tablet(); ?>"
                        data-switch-desktop="<?php echo flozen_switch_desktop(); ?>"
                        data-disable-nav="<?php echo $heading ? 'true' : 'false'; ?>">
                        <?php
                        foreach ($cross_sells as $cross_sell) :
                            $post_object = get_post($cross_sell->get_id());
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
