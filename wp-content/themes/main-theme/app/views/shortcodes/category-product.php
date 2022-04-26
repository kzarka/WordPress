<?php $container = getViewArgs($args, 'container'); ?>
<?php $title = getViewArgs($args, 'title'); ?>
<?php $desc = getViewArgs($args, 'desc'); ?>
<?php $data = getViewArgs($args, 'data'); ?>
<?php
$code = md5(uniqid(rand(), true));

?>
<div class="shopify-section index-section">
    <div class="main-row  " data-section-id="<?= $code ?>">
        <div class="container">
            <div class="row">
                <div class="main-col col-sm-12 col-md-12">
                    <div class="row sub-row">
                        <div class="sub-col col-sm-12 col-md-12">
                            <div class="tt_tabsproduct_module tabs-category-slider " id="product_module<?= $code ?>">
                                <div class="module-title">
                                    <h2>
                                        <span>OUR PRODUCTS</span>
                                    </h2>
                                </div>
                                <div class="module-description">
                                    <p>Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum.</p>
                                </div>
                                <ul class="tab-heading tabs-categorys">
                                    <?php $count = 0; ?>
                                    <?php foreach ($data as $id => $value): ?>
                                    <li class="">
                                        <a data-toggle="pill" href="#tab-<?= $code ?>-<?= $count ?>">
                                            <span><?= get_term( $id , 'product_cat' )->name ?></span>
                                        </a>
                                    </li>
                                    <?php $count++; ?>
                                    <?php endforeach; ?>
                                </ul>
                                <div class="tt-product">
                                    <div class="tab-content">
                                        <?php $count = 0; ?>
                                        <?php foreach ($data as $id => $query): ?>
                                        <div class="tab-container-<?= $code ?> owl-carousel owl-theme tab-pane fade" id="tab-<?= $code ?>-<?= $count ?>">
                                            <?php if ( $query->have_posts() ): ?>
                                            <?php while ( $query->have_posts() ): ?>
                                            <?php $query->the_post(); ?>
                                            <div class="row_items">
                                                <div class="product-layout grid-style">
                                                    <div class="product-thumb transition">
                                                        <div class="item">
                                                            <div class="item-inner">
                                                                <div class="image images-container">
                                                                    <div class="label-product label_sale">
                                                                        <span>-33%</span>
                                                                    </div>
                                                                    <a href="<?php echo get_permalink( $query->post->ID ) ?>" class="product-image">
                                                                        <img id="2008661131300" class=" img-responsive  lazyload img-default-image img-cate-516683104292-1501181471034" src="//cdn.shopify.com/s/files/1/3012/8606/products/10-600x600_a19d3308-c9ac-40fa-ae8e-853a378e0592_100x100_crop_center.jpg?v=1519629467" srcset="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="//cdn.shopify.com/s/files/1/3012/8606/products/10-600x600_a19d3308-c9ac-40fa-ae8e-853a378e0592_400x400_crop_center.jpg?v=1519629467" data-srcset="//cdn.shopify.com/s/files/1/3012/8606/products/10-600x600_a19d3308-c9ac-40fa-ae8e-853a378e0592_300x300_crop_center.jpg?v=1519629467 360w, //cdn.shopify.com/s/files/1/3012/8606/products/10-600x600_a19d3308-c9ac-40fa-ae8e-853a378e0592_400x400_crop_center.jpg?v=1519629467 540w, //cdn.shopify.com/s/files/1/3012/8606/products/10-600x600_a19d3308-c9ac-40fa-ae8e-853a378e0592_500x500_crop_center.jpg?v=1519629467 720w, //cdn.shopify.com/s/files/1/3012/8606/products/10-600x600_a19d3308-c9ac-40fa-ae8e-853a378e0592_600x600_crop_center.jpg?v=1519629467 1024w" data-aspectratio="1/1" data-sizes="auto" alt="FOPO DESIGNS WOOLRICH KLETTERSACK">
                                                                        <img id="2008661196836" class=" img-responsive  lazyload img-r img-default-image img-cate-516683104292-1501181471034" src="//cdn.shopify.com/s/files/1/3012/8606/products/14-600x600_d4f6d321-f84e-4b64-8856-d6f46623dc3b_100x100_crop_center.jpg?v=1519629467" srcset="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="//cdn.shopify.com/s/files/1/3012/8606/products/14-600x600_d4f6d321-f84e-4b64-8856-d6f46623dc3b_400x400_crop_center.jpg?v=1519629467" data-srcset="//cdn.shopify.com/s/files/1/3012/8606/products/14-600x600_d4f6d321-f84e-4b64-8856-d6f46623dc3b_300x300_crop_center.jpg?v=1519629467 360w, //cdn.shopify.com/s/files/1/3012/8606/products/14-600x600_d4f6d321-f84e-4b64-8856-d6f46623dc3b_400x400_crop_center.jpg?v=1519629467 540w, //cdn.shopify.com/s/files/1/3012/8606/products/14-600x600_d4f6d321-f84e-4b64-8856-d6f46623dc3b_500x500_crop_center.jpg?v=1519629467 720w, //cdn.shopify.com/s/files/1/3012/8606/products/14-600x600_d4f6d321-f84e-4b64-8856-d6f46623dc3b_600x600_crop_center.jpg?v=1519629467 1024w" data-aspectratio="1/1" data-sizes="auto" alt="FOPO DESIGNS WOOLRICH KLETTERSACK">
                                                                    </a>
                                                                    <div class="action-links">
                                                                        <button class="btn-wishlist button btn-default wishlist-btn" data-product-handle="fopo-designs-woolrich-klettersack" type="button" data-toggle="tooltip" title="Add to Wish List" data-original-title="Add to Wish List">
                                                                            <i class="ion-android-favorite-outline"></i>
                                                                            <span>Add to Wish List</span>
                                                                        </button>
                                                                        <button class="button btn-compare" type="button" data-toggle="tooltip" title="View Details" onclick="window.top.location.href='/products/fopo-designs-woolrich-klettersack';">
                                                                            <span>View Details</span>
                                                                        </button>
                                                                        <button class="button btn-quickview quickview" type="button" title="Quick View" data-toggle="modal" data-target="#productModal" data-productinfo='{&quot;id&quot;:516683104292,&quot;title&quot;:&quot;FOPO DESIGNS WOOLRICH KLETTERSACK&quot;,&quot;handle&quot;:&quot;fopo-designs-woolrich-klettersack&quot;,&quot;description&quot;:&quot;\u003cstrong\u003eBorn to be worn.\u003c\/strong\u003e\u003cspan\u003e\u003c\/span\u003e\n\u003cp\u003eClip on the worlds most wearable music player and take up to 240 songs with you anywhere. Choose from five colors including four new hues to make your musical fashion statement.\u003c\/p\u003e\n\u003cp\u003e\u003cstrong\u003eRandom meets rhythm.\u003c\/strong\u003e\u003c\/p\u003e\n\u003cp\u003eWith iTunes autofill, iPod shuffle can deliver a new musical experience every time you sync. For more randomness, you can shuffle songs during playback with the slide of a switch.\u003c\/p\u003e\n\u003cstrong\u003eEverything is easy.\u003c\/strong\u003e\u003cspan\u003e\u003c\/span\u003e\n\u003cp\u003eCharge and sync with the included USB dock. Operate the iPod shuffle controls with one hand. Enjoy up to 12 hours straight of skip-free music playback.\u003c\/p\u003e\n\u003cp\u003e\u003cb\u003eIntel Core 2 Duo processor\u003c\/b\u003e\u003c\/p\u003e\n\u003cp\u003ePowered by an Intel Core 2 Duo processor at speeds up to 2.16GHz, the new MacBook is the fastest ever.\u003c\/p\u003e\n\u003cp\u003e\u003cb\u003e1GB memory, larger hard drives\u003c\/b\u003e\u003c\/p\u003e\n\u003cp\u003eThe new MacBook now comes with 1GB of memory standard and larger hard drives for the entire line perfect for running more of your favorite applications and storing growing media collections.\u003c\/p\u003e\n\u003cp\u003e\u003cb\u003eSleek, 1.08-inch-thin design\u003c\/b\u003e\u003c\/p\u003e\n\u003cp\u003eMacBook makes it easy to hit the road thanks to its tough polycarbonate case, built-in wireless technologies, and innovative MagSafe Power Adapter that releases automatically if someone accidentally trips on the cord.\u003c\/p\u003e\n\u003cp\u003e\u003cb\u003eBuilt-in iSight camera\u003c\/b\u003e\u003c\/p\u003e\n\u003cp\u003eRight out of the box, you can have a video chat with friends or family,2 record a video at your desk, or take fun pictures with Photo Booth\u003c\/p\u003e&quot;,&quot;published_at&quot;:&quot;2018-02-26T02:01:31-05:00&quot;,&quot;created_at&quot;:&quot;2018-02-26T02:08:51-05:00&quot;,&quot;vendor&quot;:&quot;Handa&quot;,&quot;type&quot;:&quot;Auto parts&quot;,&quot;tags&quot;:[&quot;auto&quot;,&quot;car&quot;,&quot;original&quot;,&quot;price_100-150&quot;,&quot;size_large&quot;,&quot;spare parts&quot;],&quot;price&quot;:10000,&quot;price_min&quot;:10000,&quot;price_max&quot;:10000,&quot;available&quot;:true,&quot;price_varies&quot;:false,&quot;compare_at_price&quot;:15000,&quot;compare_at_price_min&quot;:15000,&quot;compare_at_price_max&quot;:15000,&quot;compare_at_price_varies&quot;:false,&quot;variants&quot;:[{&quot;id&quot;:6908955787300,&quot;title&quot;:&quot;Default Title&quot;,&quot;option1&quot;:&quot;Default Title&quot;,&quot;option2&quot;:null,&quot;option3&quot;:null,&quot;sku&quot;:&quot;&quot;,&quot;requires_shipping&quot;:true,&quot;taxable&quot;:true,&quot;featured_image&quot;:null,&quot;available&quot;:true,&quot;name&quot;:&quot;FOPO DESIGNS WOOLRICH KLETTERSACK&quot;,&quot;public_title&quot;:null,&quot;options&quot;:[&quot;Default Title&quot;],&quot;price&quot;:10000,&quot;weight&quot;:0,&quot;compare_at_price&quot;:15000,&quot;inventory_management&quot;:null,&quot;barcode&quot;:&quot;&quot;}],&quot;images&quot;:[&quot;\/\/cdn.shopify.com\/s\/files\/1\/3012\/8606\/products\/10-600x600_a19d3308-c9ac-40fa-ae8e-853a378e0592.jpg?v=1519629467&quot;,&quot;\/\/cdn.shopify.com\/s\/files\/1\/3012\/8606\/products\/9-600x600_fa568c03-b09d-4d07-8f3e-7073a98286dc.jpg?v=1519629467&quot;,&quot;\/\/cdn.shopify.com\/s\/files\/1\/3012\/8606\/products\/13-600x600_e2c0d9e9-0178-41e0-8aef-c479f8d085ac.jpg?v=1519629467&quot;,&quot;\/\/cdn.shopify.com\/s\/files\/1\/3012\/8606\/products\/16-600x600_21b3ab32-0182-4d62-987f-ee5d6740b8e1.jpg?v=1519629467&quot;,&quot;\/\/cdn.shopify.com\/s\/files\/1\/3012\/8606\/products\/17-600x600_a4fafd6b-e9ea-462b-a68e-38f054ae6f1b.jpg?v=1519629467&quot;,&quot;\/\/cdn.shopify.com\/s\/files\/1\/3012\/8606\/products\/18-600x600_58475fd5-e37b-4ce8-9d8a-3e3ed125fcb6.jpg?v=1519629467&quot;,&quot;\/\/cdn.shopify.com\/s\/files\/1\/3012\/8606\/products\/15-600x600_2f2ff0cf-b0ae-4e73-85c1-c1a38976760a.jpg?v=1519629467&quot;,&quot;\/\/cdn.shopify.com\/s\/files\/1\/3012\/8606\/products\/14-600x600_d4f6d321-f84e-4b64-8856-d6f46623dc3b.jpg?v=1519629467&quot;],&quot;featured_image&quot;:&quot;\/\/cdn.shopify.com\/s\/files\/1\/3012\/8606\/products\/10-600x600_a19d3308-c9ac-40fa-ae8e-853a378e0592.jpg?v=1519629467&quot;,&quot;options&quot;:[&quot;Title&quot;],&quot;media&quot;:[{&quot;alt&quot;:null,&quot;id&quot;:793582305316,&quot;position&quot;:1,&quot;preview_image&quot;:{&quot;aspect_ratio&quot;:1.0,&quot;height&quot;:600,&quot;width&quot;:600,&quot;src&quot;:&quot;https:\/\/cdn.shopify.com\/s\/files\/1\/3012\/8606\/products\/10-600x600_a19d3308-c9ac-40fa-ae8e-853a378e0592.jpg?v=1519629467&quot;},&quot;aspect_ratio&quot;:1.0,&quot;height&quot;:600,&quot;media_type&quot;:&quot;image&quot;,&quot;src&quot;:&quot;https:\/\/cdn.shopify.com\/s\/files\/1\/3012\/8606\/products\/10-600x600_a19d3308-c9ac-40fa-ae8e-853a378e0592.jpg?v=1519629467&quot;,&quot;width&quot;:600},{&quot;alt&quot;:null,&quot;id&quot;:793582272548,&quot;position&quot;:2,&quot;preview_image&quot;:{&quot;aspect_ratio&quot;:1.0,&quot;height&quot;:600,&quot;width&quot;:600,&quot;src&quot;:&quot;https:\/\/cdn.shopify.com\/s\/files\/1\/3012\/8606\/products\/9-600x600_fa568c03-b09d-4d07-8f3e-7073a98286dc.jpg?v=1519629467&quot;},&quot;aspect_ratio&quot;:1.0,&quot;height&quot;:600,&quot;media_type&quot;:&quot;image&quot;,&quot;src&quot;:&quot;https:\/\/cdn.shopify.com\/s\/files\/1\/3012\/8606\/products\/9-600x600_fa568c03-b09d-4d07-8f3e-7073a98286dc.jpg?v=1519629467&quot;,&quot;width&quot;:600},{&quot;alt&quot;:null,&quot;id&quot;:793582338084,&quot;position&quot;:3,&quot;preview_image&quot;:{&quot;aspect_ratio&quot;:1.0,&quot;height&quot;:600,&quot;width&quot;:600,&quot;src&quot;:&quot;https:\/\/cdn.shopify.com\/s\/files\/1\/3012\/8606\/products\/13-600x600_e2c0d9e9-0178-41e0-8aef-c479f8d085ac.jpg?v=1519629467&quot;},&quot;aspect_ratio&quot;:1.0,&quot;height&quot;:600,&quot;media_type&quot;:&quot;image&quot;,&quot;src&quot;:&quot;https:\/\/cdn.shopify.com\/s\/files\/1\/3012\/8606\/products\/13-600x600_e2c0d9e9-0178-41e0-8aef-c479f8d085ac.jpg?v=1519629467&quot;,&quot;width&quot;:600},{&quot;alt&quot;:null,&quot;id&quot;:793582436388,&quot;position&quot;:4,&quot;preview_image&quot;:{&quot;aspect_ratio&quot;:1.0,&quot;height&quot;:600,&quot;width&quot;:600,&quot;src&quot;:&quot;https:\/\/cdn.shopify.com\/s\/files\/1\/3012\/8606\/products\/16-600x600_21b3ab32-0182-4d62-987f-ee5d6740b8e1.jpg?v=1519629467&quot;},&quot;aspect_ratio&quot;:1.0,&quot;height&quot;:600,&quot;media_type&quot;:&quot;image&quot;,&quot;src&quot;:&quot;https:\/\/cdn.shopify.com\/s\/files\/1\/3012\/8606\/products\/16-600x600_21b3ab32-0182-4d62-987f-ee5d6740b8e1.jpg?v=1519629467&quot;,&quot;width&quot;:600},{&quot;alt&quot;:null,&quot;id&quot;:793582469156,&quot;position&quot;:5,&quot;preview_image&quot;:{&quot;aspect_ratio&quot;:1.0,&quot;height&quot;:600,&quot;width&quot;:600,&quot;src&quot;:&quot;https:\/\/cdn.shopify.com\/s\/files\/1\/3012\/8606\/products\/17-600x600_a4fafd6b-e9ea-462b-a68e-38f054ae6f1b.jpg?v=1519629467&quot;},&quot;aspect_ratio&quot;:1.0,&quot;height&quot;:600,&quot;media_type&quot;:&quot;image&quot;,&quot;src&quot;:&quot;https:\/\/cdn.shopify.com\/s\/files\/1\/3012\/8606\/products\/17-600x600_a4fafd6b-e9ea-462b-a68e-38f054ae6f1b.jpg?v=1519629467&quot;,&quot;width&quot;:600},{&quot;alt&quot;:null,&quot;id&quot;:793582501924,&quot;position&quot;:6,&quot;preview_image&quot;:{&quot;aspect_ratio&quot;:1.0,&quot;height&quot;:600,&quot;width&quot;:600,&quot;src&quot;:&quot;https:\/\/cdn.shopify.com\/s\/files\/1\/3012\/8606\/products\/18-600x600_58475fd5-e37b-4ce8-9d8a-3e3ed125fcb6.jpg?v=1519629467&quot;},&quot;aspect_ratio&quot;:1.0,&quot;height&quot;:600,&quot;media_type&quot;:&quot;image&quot;,&quot;src&quot;:&quot;https:\/\/cdn.shopify.com\/s\/files\/1\/3012\/8606\/products\/18-600x600_58475fd5-e37b-4ce8-9d8a-3e3ed125fcb6.jpg?v=1519629467&quot;,&quot;width&quot;:600},{&quot;alt&quot;:null,&quot;id&quot;:793582403620,&quot;position&quot;:7,&quot;preview_image&quot;:{&quot;aspect_ratio&quot;:1.0,&quot;height&quot;:600,&quot;width&quot;:600,&quot;src&quot;:&quot;https:\/\/cdn.shopify.com\/s\/files\/1\/3012\/8606\/products\/15-600x600_2f2ff0cf-b0ae-4e73-85c1-c1a38976760a.jpg?v=1519629467&quot;},&quot;aspect_ratio&quot;:1.0,&quot;height&quot;:600,&quot;media_type&quot;:&quot;image&quot;,&quot;src&quot;:&quot;https:\/\/cdn.shopify.com\/s\/files\/1\/3012\/8606\/products\/15-600x600_2f2ff0cf-b0ae-4e73-85c1-c1a38976760a.jpg?v=1519629467&quot;,&quot;width&quot;:600},{&quot;alt&quot;:null,&quot;id&quot;:793582370852,&quot;position&quot;:8,&quot;preview_image&quot;:{&quot;aspect_ratio&quot;:1.0,&quot;height&quot;:600,&quot;width&quot;:600,&quot;src&quot;:&quot;https:\/\/cdn.shopify.com\/s\/files\/1\/3012\/8606\/products\/14-600x600_d4f6d321-f84e-4b64-8856-d6f46623dc3b.jpg?v=1519629467&quot;},&quot;aspect_ratio&quot;:1.0,&quot;height&quot;:600,&quot;media_type&quot;:&quot;image&quot;,&quot;src&quot;:&quot;https:\/\/cdn.shopify.com\/s\/files\/1\/3012\/8606\/products\/14-600x600_d4f6d321-f84e-4b64-8856-d6f46623dc3b.jpg?v=1519629467&quot;,&quot;width&quot;:600}],&quot;content&quot;:&quot;\u003cstrong\u003eBorn to be worn.\u003c\/strong\u003e\u003cspan\u003e\u003c\/span\u003e\n\u003cp\u003eClip on the worlds most wearable music player and take up to 240 songs with you anywhere. Choose from five colors including four new hues to make your musical fashion statement.\u003c\/p\u003e\n\u003cp\u003e\u003cstrong\u003eRandom meets rhythm.\u003c\/strong\u003e\u003c\/p\u003e\n\u003cp\u003eWith iTunes autofill, iPod shuffle can deliver a new musical experience every time you sync. For more randomness, you can shuffle songs during playback with the slide of a switch.\u003c\/p\u003e\n\u003cstrong\u003eEverything is easy.\u003c\/strong\u003e\u003cspan\u003e\u003c\/span\u003e\n\u003cp\u003eCharge and sync with the included USB dock. Operate the iPod shuffle controls with one hand. Enjoy up to 12 hours straight of skip-free music playback.\u003c\/p\u003e\n\u003cp\u003e\u003cb\u003eIntel Core 2 Duo processor\u003c\/b\u003e\u003c\/p\u003e\n\u003cp\u003ePowered by an Intel Core 2 Duo processor at speeds up to 2.16GHz, the new MacBook is the fastest ever.\u003c\/p\u003e\n\u003cp\u003e\u003cb\u003e1GB memory, larger hard drives\u003c\/b\u003e\u003c\/p\u003e\n\u003cp\u003eThe new MacBook now comes with 1GB of memory standard and larger hard drives for the entire line perfect for running more of your favorite applications and storing growing media collections.\u003c\/p\u003e\n\u003cp\u003e\u003cb\u003eSleek, 1.08-inch-thin design\u003c\/b\u003e\u003c\/p\u003e\n\u003cp\u003eMacBook makes it easy to hit the road thanks to its tough polycarbonate case, built-in wireless technologies, and innovative MagSafe Power Adapter that releases automatically if someone accidentally trips on the cord.\u003c\/p\u003e\n\u003cp\u003e\u003cb\u003eBuilt-in iSight camera\u003c\/b\u003e\u003c\/p\u003e\n\u003cp\u003eRight out of the box, you can have a video chat with friends or family,2 record a video at your desk, or take fun pictures with Photo Booth\u003c\/p\u003e&quot;}' data-original-title="Quick View">
                                                                            <span>Quick View</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <!-- image -->
                                                                <div class="caption">
                                                                    <div class="ratings">
                                                                        <div class="rating-box">
                                                                            <span class="shopify-product-reviews-badge" data-id="516683104292"></span>
                                                                        </div>
                                                                    </div>
                                                                    <h4 class="product-name">
                                                                        <a href="/products/fopo-designs-woolrich-klettersack">
                                                                            <?= the_title() ?>
                                                                        </a>
                                                                    </h4>
                                                                    <div class="product-des">Born to be worn. Clip on the worlds most wearable music player and take up to 240 songs with you anywhere. Choose from five colors including four new hues to...</div>
                                                                    <p class="rate-special"> -33% </p>
                                                                    <div class="price-box">
                                                                        <p class="special-price">
                                                                            <span class="price">
                                                                                <span class=money>$100.00</span>
                                                                            </span>
                                                                        </p>
                                                                        <p class="old-price">
                                                                            <span class="price">
                                                                                <span class=money>$150.00</span>
                                                                            </span>
                                                                        </p>
                                                                    </div>
                                                                    <button class="button btn-cart " type="button" data-toggle="tooltip" data-loading-text="Loading..." title="Add to Cart" onclick="cart.add('6908955787300');">
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
                                            <?php endwhile; ?>
                                            <?php wp_reset_postdata(); ?>
                                            <?php endif; ?>
                                            <div class="row_items"></div>
                                            <!-- productTabContent -->
                                        </div>
                                        <?php $count++; ?>
                                        <?php endforeach; ?>

                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $('a[href="#tab-<?= $code ?>-0"]').trigger("click");
                                    $(".tab-container-<?= $code ?>").owlCarousel({
                                        items: 4,
                                        loop: false,
                                        margin: 30,
                                        nav: true,
                                        dots: false,
                                        autoplay: false,
                                        autoplayTimeout: 1000,
                                        autoplayHoverPause: true,
                                        autoplaySpeed: 1000,
                                        navSpeed: 1000,
                                        dotsSpeed: 1000,
                                        lazyLoad: true,
                                        responsive: {
                                            0: {
                                                items: 1,
                                                nav: false,
                                                dots: false
                                            },
                                            480: {
                                                items: 2,
                                                nav: false,
                                                dots: false
                                            },
                                            768: {
                                                items: 2,
                                            },
                                            992: {
                                                items: 3
                                            },
                                            1200: {
                                                items: 4
                                            },
                                            1600: {
                                                items: 4
                                            }
                                        },
                                        onInitialized: function() {
                                            var count = $(".tab-container-<?= $code ?> .owl-item.active").length;
                                            if (count == 1) {
                                                $(".tab-container-<?= $code ?> .owl-item").removeClass('first');
                                                $(".tab-container-<?= $code ?> .owl-item.active").addClass('first');
                                            } else {
                                                $(".tab-container-<?= $code ?> .owl-item").removeClass('first');
                                                $(".tab-container-<?= $code ?> .owl-item.active:first").addClass('first');
                                            }
                                        },
                                        onTranslated: function() {
                                            var count = $(".tab-container-<?= $code ?> .owl-item.active").length;
                                            if (count == 1) {
                                                $(".tab-container-<?= $code ?> .owl-item").removeClass('first');
                                                $(".tab-container-<?= $code ?> .owl-item.active").addClass('first');
                                            } else {
                                                $(".tab-container-<?= $code ?> .owl-item").removeClass('first');
                                                $(".tab-container-<?= $code ?> .owl-item.active:first").addClass('first');
                                            }
                                        }
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style></style>
    <script type="text/javascript">
        $(document).ready(function() {
            mass.resizeGrid('#product_module<?= $code ?>', 1);
        });
        $(window).resize(function() {
            setTimeout(function() {
                mass.resizeGrid('#product_module<?= $code ?>', 1);
            }, 300);
        });
    </script>
</div>