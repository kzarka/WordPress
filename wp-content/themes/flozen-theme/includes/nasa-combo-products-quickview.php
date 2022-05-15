<?php
// Exit if accessed directly
if (!defined('ABSPATH')) :
    exit;
endif;

if (!$product->is_purchasable()) :
    return;
endif;

$bundled_items = $product->get_bundled_items();
if ($bundled_items) : ?>
    <hr class="nasa-single-hr">
    <h3 class="nasa-gift-label"><?php echo esc_html__('Bundle product for ', 'flozen-theme'); ?><span class="nasa-gift-count">(<?php echo count($bundled_items) . ' ' . esc_html__('items', 'flozen-theme'); ?>)</span></h3>
    <div id="nasa-slider-gifts-product-quickview" class="nasa-slider owl-carousel products-group" data-columns="3" data-columns-small="2" data-columns-tablet="2" data-margin="10px" data-disable-nav="true">
        <?php foreach ($bundled_items as $bundled_item) :
            $bundled_product = $bundled_item->get_product();
            $bundled_post = get_post(yit_get_base_product_id($bundled_product));
            $quantity = $bundled_item->get_quantity();
            ?>
            <div class="nasa-gift-product-quickview-item">
                <a href="<?php echo esc_url($bundled_product->get_permalink()); ?>" title="<?php echo esc_attr($bundled_product->get_title()); ?>">
                    <div class="nasa-bundled-item-image"><?php echo flozen_str($bundled_product->get_image()); ?></div>
                    <h5><?php echo flozen_str($quantity . ' x ' . $bundled_product->get_title()); ?></h5>
                </a>
                
                <?php
                if ($bundled_product->has_enough_stock($quantity) && $bundled_product->is_in_stock()) :
                    echo '<div class="nasa-label-stock nasa-item-instock">' . esc_html__('In stock', 'flozen-theme') . '</div>';
                else :
                    echo '<div class="nasa-label-stock nasa-item-outofstock">' . esc_html__('Out of stock', 'flozen-theme') . '</div>';
                endif;
                ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php
endif;
