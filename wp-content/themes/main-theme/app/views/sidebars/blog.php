<aside id="column-left" class="col-sm-12 col-md-3">
    <div class="layernavigation-module">
        <div class="panel panel-default">
            <div class="panel-heading layered-heading"> News </div>
            <div class="layered">
                <div class="list-group">
                    <!--Blog search start-->
                    <div class="filter-attribute-container filter-attribute-remove-container">
                        <div id="search" class="blog input-group">
                            <form action="" id="search-form" method="get" id="blog-search">
                                <input type="hidden" name="type" value="post" />
                                <input type="text" name="s" id="text-search" value="<?php echo get_search_query(); ?>" placeholder="Search all articles..." class="form-control input-lg" aria-label="Search all articles..." />
                                <span class="input-group-btn">
                                    <button type="submit" form="blog-search" class="btn btn-default btn-lg">&nbsp;</button>
                                </span>
                            </form>
                        </div>
                    </div>
                    <!-- Shows a link menu selected from settings -->
                    <div class="filter-attribute-container filter-categories">
                        <label>Chuyên Muc</label>
                        <div class="list-group-item">
                            <div id="filter-group0">
                                <?php $cats = get_the_category(); // category object
                                    $top_cat_obj = array();
                                    $i=0;
                                    foreach($cats as $cat) {
                                        if ($cat->parent == 0 && $i < 10) {
                                            $top_cat_obj[] = $cat;
                                            $i++;
                                        }
                                    }
                                ?>
                                <?php foreach($top_cat_obj as $top_cat) { 
                                    ?>
                                    <a class="a-filter add-filter" href="<?= get_category_link($top_cat->term_id) ?>"><?= $top_cat->name ?></a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!--Sidebar recent articles -->
                    <div id="blog-sidebar" class="filter-attribute-container">
                        <label>Bài viết mới </label>
                        <div class="article-page">
                        <?php
                            $args = array(
                                'post_status' => 'publish',
                                'posts_per_page' => 2,
                                'post_type'   => 'post',
                                'orderby' => 'date',
                                'order' => 'DESC',
                            );
                            $the_query = new WP_Query( $args );

                        ?>
                        <?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                            <div class="intro-content">
                                <div class="article-name">
                                    <h4>
                                        <a href="<?= esc_url( get_permalink() ); ?>"><?= the_title() ?></a>
                                    </h4>
                                </div>
                                <p class="articledate">
                                    <time datetime="2021-08-25 17:31:39 -0400"><?= get_the_date() ?></time>
                                    <strong>Tác Giả:</strong> <?= get_the_author() ?>
                                </p>
                            </div>
                        <?php endwhile; ?>
                        <?php endif; wp_reset_postdata();?>
                        </div>
                    </div>
                    <!--Sidebar tags section -->
                    <div class="filter-attribute-container">
                        <label>Tags Cloud</label>
                        <div class="list-group-item">
                            <div id="filter-group4">
                                <div class="tagcloud05">
                                    <ul></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Sidebar image section -->
                    <div class="banner-static static-sidebar">
                        <div class="image">
                            <a href="/blogs/news">
                                <img src="//cdn.shopify.com/s/files/1/3012/8606/files/img2-top-aero4.jpg?v=1520592793" alt="#" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside>