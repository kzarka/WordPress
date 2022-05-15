<?php 
global $product;
?>
<div class="row_items">
    <div class="product-layout grid-style">
        <div class="product-thumb transition">
            <div class="item">
                <div class="item-inner">
                    <div class="image images-container">
                        <?php if ($product->get_sale_price()): ?>
                        <div class="label-product label_sale">
                            <span>-<?= ceil(($product->get_regular_price() - $product->get_sale_price())/$product->get_regular_price()*100) ?>%</span>
                        </div>
                        <?php endif; ?>
                        <a href="<?= $product->get_permalink(); ?>" class="product-image">
                            <?= woocommerce_get_product_thumbnail(); ?>
                        </a>
                        <div class="action-links" style="display: none;">
                            <button class="btn-wishlist button btn-default wishlist-btn" type="button" data-toggle="tooltip" title="Add to Wish List" data-original-title="Add to Wish List">
                                <i class="ion-android-favorite-outline"></i>
                                <span>Add to Wish List</span>
                            </button>
                            <button class="button btn-compare" type="button" data-toggle="tooltip" title="View Details" onclick="window.top.location.href='<?= $product->get_permalink(); ?>';">
                                <span>View Details</span>
                            </button>
                        </div>
                    </div>
                    <!-- image -->
                    <div class="caption">
                        <div class="ratings">
                            <div class="rating-box">
                                <span class="shopify-product-reviews-badge"></span>
                            </div>
                        </div>
                        <h4 class="product-name">
                            <a href="<?= $product->get_permalink(); ?>"> <?= $product->post->post_title; ?> </a>
                        </h4>
                        <?php if ($product->get_short_description()): ?>
                        <div class="product-des"><?= $product->get_short_description(); ?></div>
                        <?php endif; ?>
                        <?php if ($product->get_sale_price()): ?>
                        <p class="rate-special">
                            -<?= ceil(($product->get_regular_price() - $product->get_sale_price())/$product->get_regular_price()*100) ?>% 
                        </p>
                        <?php endif; ?>
                        <div class="price-box">
                            <p class="regular-price">
                                <span class="price">
                                    <span class=money><?= wc_price( $product->get_price() ); ?></span>
                                </span>
                            </p>
                            <?php if ($product->get_sale_price()): ?>
                            <p class="old-price">
                                <span class="price"><?= wc_price( $product->get_regular_price() ); ?></span>
                            </p>
                            <?php endif; ?>
                        </div>
                        <button class="button btn-cart " type="button" data-toggle="tooltip" data-loading-text="Loading..." title="Chi tiết" onclick="location.href='<?= $product->get_permalink(); ?>'">
                            <span>Chi tiết</span>
                        </button>
                    </div>
                    <!-- caption -->
                </div>
            </div>
        </div>
        <!-- product-thumb -->
    </div>
</div>