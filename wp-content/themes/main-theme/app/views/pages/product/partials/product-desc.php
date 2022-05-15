<?php 
global $product;
$tags = get_product_tags($product->post->ID);

?>
<div class="row">
    <div class="block-3 col-sm-12 product-info-detailed">
        <ul class="nav nav-tabs">
            <li role="presentation" class="active">
                <a href="#description" aria-controls="description" role="tab" data-toggle="tab">Description</a>
            </li>
            <li role="presentation" class="reviews">
                <a href="#reviews" aria-controls="reviews" role="tab" data-toggle="tab">Reviews</a>
            </li>
            <li role="presentation">
                <a href="#data" aria-controls="data" role="tab" data-toggle="tab">Custom Tab</a>
            </li>
            <li role="presentation">
                <a href="#tags" aria-controls="tags" role="tab" data-toggle="tab">Tags</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="mobtab" role="presentation">
                <a href="#description" aria-controls="description" role="tab" data-toggle="tab" class="active">Description</a>
            </div>
            <div role="tabpanel" class="tab-pane active" id="description">
                <?= $product->get_description(); ?>
            </div>
            <div class="mobtab" role="presentation">
                <a href="#reviews" aria-controls="reviews" role="tab" data-toggle="tab">Reviews</a>
            </div>
            <div role="tabpanel" class="tab-pane" id="reviews">
                <p></p>
                <div id="shopify-product-reviews" data-id="516676321316">
                    <style scoped="">
                        .spr-container {
                            padding: 24px;
                            border-color: #ECECEC;
                        }

                        .spr-review,
                        .spr-form {
                            border-color: #ECECEC;
                        }
                    </style>
                    <div class="spr-container">
                        <div class="spr-header">
                            <h2 class="spr-header-title">Customer Reviews</h2>
                            <div class="spr-summary">
                                <span class="spr-starrating spr-summary-starrating">
                                    <i class="spr-icon spr-icon-star"></i>
                                    <i class="spr-icon spr-icon-star"></i>
                                    <i class="spr-icon spr-icon-star"></i>
                                    <i class="spr-icon spr-icon-star"></i>
                                    <i class="spr-icon spr-icon-star"></i>
                                </span>
                                <span class="spr-summary-caption">
                                    <span class="spr-summary-actions-togglereviews">Based on 1 review</span>
                                </span>
                                <span class="spr-summary-actions">
                                    <a href="#" class="spr-summary-actions-newreview" onclick="SPR.toggleForm(516676321316);return false">Write a review</a>
                                </span>
                            </div>
                        </div>
                        <div class="spr-content">
                            <div class="spr-form" id="form_516676321316" style="display: none"></div>
                            <div class="spr-reviews" id="reviews_516676321316"></div>
                        </div>
                    </div>
                    <script type="application/ld+json">
                        {
                            "@context": "http://schema.org/",
                            "@type": "AggregateRating",
                            "reviewCount": "1",
                            "ratingValue": "5.0",
                            "itemReviewed": {
                                "@type": "Product",
                                "name": "AOPO DESIGNS WOOLRICH KLETTERSACK",
                                "offers": {
                                    "@type": "AggregateOffer",
                                    "lowPrice": "",
                                    "highPrice": "",
                                    "priceCurrency": ""
                                }
                            }
                        }
                    </script>
                </div>
                <p></p>
            </div>
            <div class="mobtab" role="presentation">
                <a href="#data" aria-controls="data" role="tab" data-toggle="tab">Custom Tab</a>
            </div>
            <div role="tabpanel" class="tab-pane" id="data"> You can add, text, html, images and videos as well to the tab from product settings area </div>
            <div class="mobtab" role="presentation">
                <a href="#tags" aria-controls="tags" role="tab" data-toggle="tab">Tags</a>
            </div>
            <div role="tabpanel" class="tab-pane" id="tags">
                <p class="tags">
                    <span>Tags: 
                    <?php foreach ($tags as $key => $tag): ?>
                    <a href="<?= get_tag_link($tag->term_id) ?>"><?= $tag->name ?></a>
                    <?php if ($key != count($tags) - 1): ?> , <?php endif; ?>
                    <?php endforeach; ?>
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>