<?php
$id_sc = rand(0, 999999);
$arrows = isset($arrows) ? $arrows : 0;
$auto_slide = isset($auto_slide) ? $auto_slide : 'true';

$_delay = 0;
$_delay_item = (isset($nasa_opt['delay_overlay']) && (int) $nasa_opt['delay_overlay']) ? (int) $nasa_opt['delay_overlay'] : 100;

$data_margin = isset($data_margin) ? (int) $data_margin : 0;
$height_auto = !isset($height_auto) ? 'false' : $height_auto;
$dots = isset($dots) ? $dots : 'false';

add_filter('nasa_custom_content_nasa_core', 'nasa_grid_stock');
?>

<div class="nasa-warp-slide-nav-top title-align-left nasa-slider-wrap">
    <div class="margin-bottom-20">
        <div class="nasa-title">
            <h2 class="nasa-title-heading">
                <?php echo $title; ?>
            </h2>
            
            <div class="nasa-deal-for-time">
                <?php echo esc_html__('Ends in:') . nasa_time_sale($deal_time, false); ?>
            </div>
            
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
        </div>
        
        <?php if ($desc_shortcode) : ?>
            <p class="nasa-desc">
                <?php echo $desc_shortcode; ?>
            </p>
        <?php endif; ?>
    </div>
    
    <div class="nasa-relative nasa-clear-both nasa-slide-special-product-deal-for-time">
        <div class="group-slider">
            <div
                class="slider products-group nasa-slider owl-carousel products grid nasa-slider-grid"
                data-autoplay="<?php echo esc_attr($auto_slide); ?>"
                data-loop="<?php echo $auto_slide == 'true' ? 'true' : 'false'; ?>"
                data-margin="<?php echo $data_margin; ?>"
                data-margin-small="0"
                data-margin-medium="0"
                data-columns="<?php echo (int) $columns_number; ?>"
                data-columns-small="<?php echo (int) $columns_number_small; ?>"
                data-columns-tablet="<?php echo (int) $columns_number_tablet; ?>"
                data-height-auto="<?php echo esc_attr($height_auto); ?>"
                data-switch-tablet="<?php echo nasa_switch_tablet(); ?>"
                data-switch-desktop="<?php echo nasa_switch_desktop(); ?>"
                data-disable-nav="true">
            <?php while ($specials->have_posts()) : $specials->the_post();
                global $product;
                wc_get_template(
                    'content-product.php',
                    array(
                        '_delay' => $_delay,
                        'wrapper' => 'div'
                    )
                );

                $_delay += $_delay_item;
            endwhile;
            
            wp_reset_postdata();
            ?>
            </div>
        </div>
    </div>
</div>

<?php
remove_filter('nasa_custom_content_nasa_core', 'nasa_grid_stock');
