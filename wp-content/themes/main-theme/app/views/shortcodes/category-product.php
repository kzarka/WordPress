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
                                        <span><?= $title; ?></span>
                                    </h2>
                                </div>
                                <div class="module-description">
                                    <p><?= $desc; ?></p>
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
                                            <?php renderTemplate('components/loop-product-card', []); ?>
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