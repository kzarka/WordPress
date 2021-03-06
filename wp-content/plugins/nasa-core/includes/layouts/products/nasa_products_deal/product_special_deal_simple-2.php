<?php
global $nasa_animated_products;
if (!isset($nasa_animated_products)) {
    $nasa_animated_products = isset($_REQUEST['effect-product']) && in_array($_REQUEST['effect-product'], array('hover-fade', 'hover-flip', 'hover-bottom-to-top', 'no')) ? $_REQUEST['effect-product'] : (isset($nasa_opt['animated_products']) ? $nasa_opt['animated_products'] : '');
    
    if ($nasa_animated_products == 'no') {
        $nasa_animated_products = '';
    }
}

$font_countdown = !isset($font_size_countdown) ? 'nasa-font-medium' : $font_size_countdown;
$arrows = isset($arrows) ? $arrows : 0;
$auto_slide = isset($auto_slide) ? $auto_slide : 'true';
?>

<div class="row nasa-relative nasa-slider-wrap nasa-slide-style-product-deal nasa-slide-special-product-deal">
    <?php if ($arrows == 1) : ?>
        <div class="nasa-nav-carousel-wrap">
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
    <?php endif; ?>
    
    <div class="large-12 columns group-slider">
        <div
            class="slider products-group nasa-slider owl-carousel products grid"
            data-autoplay="<?php echo esc_attr($auto_slide); ?>"
            data-loop="<?php echo $auto_slide == 'true' ? 'true' : 'false'; ?>"
            data-margin="20"
            data-columns="<?php echo (int) $columns_number; ?>"
            data-columns-small="<?php echo (int) $columns_number_small; ?>"
            data-columns-tablet="<?php echo (int) $columns_number_tablet; ?>"
            data-height-auto="false"
            data-disable-nav="true">
        <?php while ($specials->have_posts()) :
            $specials->the_post();
            global $product;

            $product_error = false;
            $productId = $product->get_id();
            $productType = $product->get_type();
            $postId = $productType == 'variation' ? wp_get_post_parent_id($productId) : $productId;
            if (!$postId) {
                $product_error = true;
            }

            /* Rating reviews */
            $productRating = $productType == 'variation' ? wc_get_product($postId) : $product;
            $average = !$product_error ? $productRating->get_average_rating() : 0;
            $count = !$product_error ? $productRating->get_review_count() : 0;
            $rating_html = wc_get_rating_html($average, $count);

            $stock_available = false;
            if ($statistic) :
                $total_sales = get_post_meta($productId, 'total_sales', true);
                $stock_sold = $total_sales ? round($total_sales) : 0;

                $stock = get_post_meta($productId, '_stock', true);
                $stock_available = $stock ? round($stock) : 0;

                $percentage = $stock_available > 0 ?
                    round($stock_sold / ($stock_available + $stock_sold) * 100) : 0;
            endif;

            $time_sale = get_post_meta($productId, '_sale_price_dates_to', true);
            $attachment_ids = $nasa_animated_products != '' ? $product->get_gallery_image_ids() : false;

            $product_link = $product_error ? '#' : get_the_permalink();
            $product_name = get_the_title() . ($product_error ? esc_html__(' - Has been error. You need rebuilt this product.', 'nasa-core') : '');
            ?>
            <div class="nasa-special-deal-item text-center">
                <div class="wow fadeInUp product-item-deal-simple<?php echo $nasa_animated_products ? ' ' . esc_attr($nasa_animated_products) : ''; ?>" data-wow-duration="1s" data-wow-delay="0ms">
                    
                    <div class="product-special-deals">
                        <!-- Image product -->
                        <div class="product-img margin-bottom-20">
                            <a href="<?php echo esc_url($product_link); ?>" title="<?php echo esc_attr($product_name); ?>">
                                <div class="main-img">
                                    <?php echo $product->get_image('nasa-large'); ?>
                                </div>
                                <?php
                                if ($attachment_ids) :
                                    $loop = 0;
                                    foreach ($attachment_ids as $attachment_id) :
                                        $image_link = wp_get_attachment_url($attachment_id);
                                        if (!$image_link):
                                            continue;
                                        endif;
                                        $loop++;
                                        printf('<div class="back-img back">%s</div>', wp_get_attachment_image($attachment_id, 'nasa-large'));
                                        if ($loop == 1):
                                            break;
                                        endif;
                                    endforeach;
                                endif;
                                ?>
                            </a>

                            <?php do_action('nasa_special_deal_simple_action'); ?>
                        </div>

                        <!-- Stock progress bar -->
                        <?php if ($stock_available) : ?>
                            <div class="product-deal-special-progress">
                                <div class="deal-stock-label">
                                    <span class="stock-available text-left"><?php echo esc_html__('Available:', 'nasa-core');?> <strong><?php echo esc_html($stock_available); ?></strong></span>
                                    <span class="stock-sold text-right"><?php echo esc_html__('Already Sold:', 'nasa-core');?> <strong><?php echo esc_html($stock_sold); ?></strong></span>
                                </div>
                                <div class="deal-progress">
                                    <span class="deal-progress-bar" style="<?php echo esc_attr('width:' . $percentage . '%'); ?>"><?php echo $percentage; ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Categories -->
                        <?php nasa_loop_product_cats(); ?>
                        
                        <!-- Name -->
                        <div class="product-deal-special-title">
                            <a href="<?php echo esc_url($product_link); ?>" title="<?php echo esc_attr($product_name); ?>">
                                <?php echo $product_name; ?>
                            </a>
                        </div>
                        
                        <!-- Rating -->
                        <?php echo $rating_html ? $rating_html : ''; ?>

                        <!-- Price -->
                        <div class="product-deal-special-price price">
                            <?php echo $product->get_price_html(); ?>
                        </div>

                        <!-- Schedule time -->
                        <div class="product-deal-special-countdown margin-top-15 <?php echo esc_attr($font_countdown); ?>">
                            <?php echo nasa_time_sale($time_sale); ?>
                        </div>

                    </div>
                </div>
            </div>
        <?php
        endwhile;
        wp_reset_postdata();
        ?>
        </div>
    </div>
</div>
