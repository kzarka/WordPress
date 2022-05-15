<?php $container = getViewArgs($args, 'container'); ?>
<?php $query = getViewArgs($args, 'data'); ?>

<div class="container">
    <div class="row">
        <div class="main-col col-sm-12 col-md-12">
            <div class="row sub-row">
                <div class="sub-col col-sm-12 col-md-12">
                    <div id="blog_home" class="menu-recent">
                        <div class="">
                            <div class="articles-container owl-carousel owl-theme">
                                <?php if( $query->have_posts() ): ?>
                                <?php while ( $query->have_posts() ): ?>
                                <?php $query->the_post(); ?>
                                <div class="row_items">
                                    <div class="articles-inner item-inner">
                                        <div class="articles-image">
                                            <a class="" href="<?= the_permalink(); ?>">
                                                <?php if ( has_post_thumbnail() ) {
                                                the_post_thumbnail();
                                                } else { ?>
                                                <img src="/wp-content/uploads/woocommerce-placeholder-300x300.png">
                                                <?php } ?>
                                                
                                            </a>
                                        </div>
                                        <div class="aritcles-content text-center">
                                            <div class="articles-date">
                                                <time datetime="<?= get_the_date('Y/m/d H:i:s') ?>">
                                                    <span> <?= get_the_date('Y/m') ?> </time>
                                            </div>
                                            <a class="articles-name" href="<?= the_permalink(); ?>" title="<?= the_title(); ?>"><?= the_title(); ?></a>
                                            <p class="author"> by: <span> <?php the_author_meta( 'user_nicename' , $author_id ); ?> </span>
                                            </p>
                                            <div class="articles-intro">
                                                <p><?= the_excerpt(); ?></p>
                                            </div>
                                            <a class="read-more" href="<?= the_permalink(); ?>">Đọc tiếp</a>
                                        </div>
                                    </div>
                                </div>
                                <?php endwhile; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $(".articles-container").owlCarousel({
                                autoPlay: false,
                                items: 2,
                                margin: 30,
                                loop: false,
                                navSpeed: 1000,
                                dotsSpeed: 1000,
                                autoplaySpeed: 1000,
                                nav: false,
                                dots: false,
                                navText: [' < i class = "ion-chevron-left" > < /i>',' < i class = "ion-chevron-right" > < /i>'],
                                responsive: {
                                    0: {
                                        items: 1,
                                        nav: false
                                    },
                                    480: {
                                        items: 1,
                                        nav: false
                                    },
                                    768: {
                                        items: 1
                                    },
                                    992: {
                                        items: 2
                                    },
                                    1200: {
                                        items: 2
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