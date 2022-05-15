<?php
$columns_number = (int) $columns_number < 2 || (int) $columns_number > 5 ? 5 : (int) $columns_number;
?>
<div class="row nasa-products-infinite-wrap">
    <div class="large-12 columns">
        <div class="products grid nasa-wrap-all-rows products-infinite nasa-products-infinite products-group"
            data-next-page="2"
            data-product-type="<?php echo $type; ?>"
            data-post-per-page="<?php echo $number; ?>"
            data-post-per-row="<?php echo $columns_number; ?>"
            data-post-per-row-medium="<?php echo $columns_number_tablet; ?>"
            data-post-per-row-small="<?php echo $columns_number_small; ?>"
            data-max-pages="<?php echo $loop->max_num_pages; ?>"
            data-cat="<?php echo esc_attr($cat); ?>">
            <?php include NASA_CORE_PRODUCT_LAYOUTS . 'globals/row_layout.php'; ?>
        </div>
    </div>
    
    <?php if ($loop->max_num_pages > 1) : ?>
        <div class="large-12 columns text-center margin-top-30 margin-bottom-20">
            <a href="javascript:void(0);" class="load-more-btn load-more" data-nodata="<?php esc_attr_e('All Products Loaded', 'nasa-core'); ?>">
                <span class="load-more-text">
                    <?php esc_html_e('Load More ...', 'nasa-core'); ?>
                </span>
            </a>
        </div>
    <?php endif; ?>
</div>
