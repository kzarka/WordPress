<div id="product-<?php echo absint($product->get_id()); ?>" <?php post_class(); ?>>
    <?php if ($nasa_actsidebar && $nasa_sidebar != 'no') : ?>
        <div class="div-toggle-sidebar center">
            <a class="toggle-sidebar" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
        </div>
    <?php endif; ?>
    
    <div class="row nasa-product-details-page nasa-single-classic-layout">
        <div class="products-arrow">
            <?php do_action('next_prev_product'); ?>
        </div>

        <div class="<?php echo esc_attr($main_class); ?>" data-num_main="1" data-num_thumb="6" data-speed="300">
            <div class="row">
                <div class="large-6 small-12 columns product-gallery rtl-right"> 
                    <?php do_action('woocommerce_before_single_product_summary'); ?>
                </div>
                
                <div class="large-6 small-12 columns product-info summary entry-summary left rtl-left">
                    <?php do_action('woocommerce_single_product_summary'); ?>
                </div>
            </div>
            
            <?php do_action('woocommerce_after_single_product_summary'); ?>

        </div>

        <?php if ($nasa_actsidebar && $nasa_sidebar != 'no') : ?>
            <div class="<?php echo esc_attr($bar_class); ?>">     
                <?php dynamic_sidebar('product-sidebar'); ?>
            </div>
        <?php endif; ?>

    </div>
</div>
