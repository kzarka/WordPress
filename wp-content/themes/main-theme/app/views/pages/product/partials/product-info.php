<?php 
global $product;
$attachment_ids = $product->get_gallery_image_ids();
$tags = get_product_tags($product->post->ID);
?>
<div class="row">
    <div id="content" class="col-sm-12">
        <div class="row">
            <div class="col-sm-6 block-1 owl-style2">
                <input type="hidden" id="check-use-zoom" value="1">
                <input type="hidden" id="light-box-position" value="1">
                <input type="hidden" id="product-identify" value="516676321316">
                <div class="lightbox-container"></div>
                <div class="product-zoom-image">
                    <?php if (get_the_post_thumbnail_url($product->post->ID, 'post-thumbnail')): ?>
                    <div class="main-image" id="product-cloud-zoom" style="background-image: url(<?=  get_the_post_thumbnail_url($product->post->ID, 'post-thumbnail') ?>);background-repeat: no-repeat;background-size: contain;">
                    </div>
                    <?php else: ?>
                    <div class="main-image" id="product-cloud-zoom" style="background-image: url(/wp-content/uploads/woocommerce-placeholder-300x300.png);background-repeat: no-repeat;background-size: contain">
                    </div>
                    <?php endif; ?>
                </div>
                <div class="additional-images owl-carousel owl-theme  owl-style3">
                    <?php if (get_the_post_thumbnail_url($product->post->ID, 'post-thumbnail')): ?>
                    <div class="item">
                        <a href="javascript:void(0)" class="cloud-zoom-gallery sub-image" id="product-image-options-" data-src="<?= get_the_post_thumbnail_url($product->post->ID ); ?>" title="AOPO DESIGNS WOOLRICH KLETTERSACK">
                            <img src="<?= get_the_post_thumbnail_url( $product->post->ID, 'thumbnail' ); ?>" title="AOPO DESIGNS WOOLRICH KLETTERSACK" alt="AOPO DESIGNS WOOLRICH KLETTERSACK">
                        </a>
                    </div>
                    <?php endif; ?>
                    <?php foreach( $attachment_ids as $attachment_id ): ?>
                    <div class="item">
                        <a href="javascript:void(0)" class="cloud-zoom-gallery sub-image" id="product-image-options-" data-src="<?= wp_get_attachment_url( $attachment_id ); ?>" title="AOPO DESIGNS WOOLRICH KLETTERSACK">
                            <img src="<?= wp_get_attachment_url( $attachment_id, 'medium' ); ?>" title="AOPO DESIGNS WOOLRICH KLETTERSACK" alt="AOPO DESIGNS WOOLRICH KLETTERSACK">
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
                <!-- end wrapper-img-additional -->
            </div>
            <div class="col-sm-6 block-2 product-info-main">
                <h2 class="product-name" itemprop="name"><?= $product->post->post_title; ?></h2>
                <div class="ratings">
                    <div class="rating-box">
                        <span class="shopify-product-reviews-badge" data-id="516676321316"></span>
                    </div>
                </div>
                <!-- end-rating -->
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
                <div class="box-options">
                    <ul class="list-unstyled">
                        <li>Thương hiệu: <a href="/collections/vendors?q=Toyoto" title="<?= get_product_brand_slug($product->post->ID) ?>"><?= get_product_brand_name($product->post->ID) ?></a>
                        </li>
                        <link itemprop="availability" href="http://schema.org/InStock">
                        <li>Availability: 
                            <?php if ($product->is_in_stock()): ?>
                            <span style="" class="ex-text"> Còn hàng </span>
                            <?php else: ?>
                            <span style="" class="ex-text"> Hết hàng </span>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>
                <div class="short-des">
                    <p class="intro"> <?= $product->get_short_description(); ?> </p>
                </div>
                <div id="product">
                    <form method="post" action="/cart/add" id="form_buy" accept-charset="UTF-8" class="shopify-product-form" enctype="multipart/form-data" name="form_buy">
                        <input type="hidden" name="form_type" value="product">
                        <input type="hidden" name="utf8" value="✓">
                        <div class="form-group" style="display:none">
                            <select name="id" id="productSelect" class="form-control">
                                <option selected="selected" data-sku="" value="6908884713508">Default Title - $150.00 USD</option>
                            </select>
                        </div>
                        <div class="form-group" style="display: none;">
                            <div>
                                <span id="variantQuantity" class="variant-quantity"></span>
                            </div>
                            <label class="control-label" for="Quantity">Qty:</label>
                            <div class="quantity-box">
                                <input type="text" name="quantity" value="1" size="2" id="Quantity" onkeyup="updatecartsticky(1)" class="form-control">
                                <input type="button" id="minus" value="-" class="form-control">
                                <input type="button" id="plus" value="+" class="form-control">
                            </div>
                            <button class="btn-wishlist button btn-default wishlist-btn" data-product-handle="aopo-designs-woolrich-klettersack" type="button" data-toggle="tooltip" title="Add to Wish List" data-original-title="Add to Wish List">
                                <i class="ion-android-favorite-outline"></i>
                                <span>Add to Wish List</span>
                            </button>
                            <button class="button button-cart btn" type="button" id="button-cart" data-loading-text="Loading..."> Add to Cart </button>
                            <div data-shopify="payment-button" data-has-selling-plan="false" class="shopify-payment-button">
                                <button class="shopify-payment-button__button shopify-payment-button__button--unbranded shopify-payment-button__button--hidden" disabled="disabled" aria-hidden="true">&nbsp;</button>
                                <button class="shopify-payment-button__more-options shopify-payment-button__button--hidden" disabled="disabled" aria-hidden="true">&nbsp;</button>
                            </div>
                        </div>
                    </form>
                    <!-- end-button -->
                </div>
                <div class="clearfix"></div>
                <div>
                    <a href="#">
                        <img data-src="//cdn.shopify.com/s/files/1/3012/8606/files/trust-badge.png?v=1624807369" class="lazyload img-responsive">
                    </a>
                </div>
                <p class="short-des">Tags: 
                    <?php foreach ($tags as $key => $tag): ?>
                    <a href="<?= get_tag_link($tag->term_id) ?>"><?= $tag->name ?></a>
                    <?php if ($key != count($tags) - 1): ?> , <?php endif; ?>
                    <?php endforeach; ?>
                </p>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.additional-images').owlCarousel({
        nav: true,
        dots: false,
        navSpeed: 1000,
        margin: 30,
        responsive:{
        0 : {
            items: 1,
            nav: false,
            dots: true
        },
        480 : {
            items: 2,
            nav: false,
            dots: true
        },
        768:{
          items: 3
        },
        992:{
          items: 4
        },
        1200:{
          items: 4
        }
        }
    });

    $('.additional-images').on('click', '.cloud-zoom-gallery.sub-image', function () {
        let src = $(this).data('src');
        $('.product-zoom-image').find('.main-image').css('background-image', 'url(' + src + ')');
    })
</script>