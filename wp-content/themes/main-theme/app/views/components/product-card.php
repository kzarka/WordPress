<?php 
global $product;
?>
<div class="row_items col-sm-6 px-0 col-md-<?php echo ceil(12/esc_attr( wc_get_loop_prop( 'columns' ) )); ?>">
    <div class="product-layout grid-style">
        <div class="product-thumb transition">
            <div class="item">
                <div class="item-inner">
                    <div class="image images-container">
                        <a href="/products/aopo-designs-woolrich-klettersack" class="product-image">
                            <?= woocommerce_get_product_thumbnail(); ?>
                        </a>
                        <div class="action-links">
                            <button class="btn-wishlist button btn-default wishlist-btn" data-product-handle="aopo-designs-woolrich-klettersack" type="button" data-toggle="tooltip" title="Add to Wish List" data-original-title="Add to Wish List">
                                <i class="ion-android-favorite-outline"></i>
                                <span>Add to Wish List</span>
                            </button>
                            <button class="button btn-compare" type="button" data-toggle="tooltip" title="View Details" onclick="window.top.location.href='/products/aopo-designs-woolrich-klettersack';">
                                <span>View Details</span>
                            </button>
                        </div>
                    </div>
                    <!-- image -->
                    <div class="caption">
                        <div class="ratings">
                            <div class="rating-box">
                                <span class="shopify-product-reviews-badge" data-id="516676321316"></span>
                            </div>
                        </div>
                        <h4 class="product-name">
                            <a href="<?= $product->get_permalink(); ?>"> <?= $product->post->post_title; ?> </a>
                        </h4>
                        <div class="product-des">Born to be worn. Clip on the worlds most wearable music player and take up to 240 songs with you anywhere. Choose from five colors including four new hues to...</div>
                        <div class="price-box">
                            <p class="regular-price">
                                <span class="price">
                                    <span class=money>$<?= $product->get_price(); ?></span>
                                </span>
                            </p>
                            <p class="old-price">
                                <span class="price"></span>
                            </p>
                        </div>
                        <button class="button btn-cart " type="button" data-toggle="tooltip" data-loading-text="Loading..." title="Add to Cart" onclick="cart.add('6908884713508');">
                            <span>Add to Cart</span>
                        </button>
                    </div>
                    <!-- caption -->
                </div>
            </div>
        </div>
        <!-- product-thumb -->
    </div>
</div>