<article id="post-<?php echo absint($postId); ?>" <?php post_class(); ?>>
    <?php
    if (is_sticky() && is_home() && !is_paged()) :
        printf('<span class="sticky-post">%s</span>', esc_html__('Featured', 'flozen-theme'));
    endif;
    ?>
    
    <?php if (has_post_thumbnail()) : ?>
        <div class="entry-image nasa-blog-img">
            <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($title); ?>">
                <?php the_post_thumbnail('large'); ?>
                <div class="image-overlay"></div>
            </a>
        </div>
    <?php endif; ?>

    <header class="entry-header">
        <div class="row">

            <div class="large-12 columns">
                <h3 class="entry-title">
                    <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($title); ?>" rel="bookmark">
                        <?php echo flozen_str($title); ?>
                    </a>
                </h3>
            </div>

            <div class="large-12 columns text-left info-wrap margin-bottom-10">

                <?php if($show_author_info) : ?>
                    <a href="<?php echo esc_url($link_author); ?>" title="<?php echo esc_attr__('Posted By ', 'flozen-theme') . esc_attr($author); ?>">
                        <span class="meta-author inline-block">
                            <i class="pe-7s-user"></i> <?php esc_html_e('Posted by ', 'flozen-theme'); ?><?php echo flozen_str($author); ?>
                        </span>
                    </a>
                <?php endif; ?>

                <?php if($show_date_info) : ?>
                    <a href="<?php echo esc_url($link_date); ?>" title="<?php echo esc_attr__('Posts in ', 'flozen-theme') . esc_attr($date_post); ?>">
                        <span class="post-date inline-block">
                            <i class="pe-7s-date"></i>
                            <?php echo flozen_str($date_post); ?>
                        </span>
                    </a>
                <?php endif; ?>
            </div>

            <div class="large-12 columns">
                <div class="entry-summary">
                    <?php the_excerpt(); ?>
                </div>
            </div>

            <?php if($show_readmore) : ?>
                <div class="large-12 columns entry-readmore">
                    <a href="<?php echo esc_url($link); ?>">
                        <?php echo esc_html__('CONTINUE READING  &#10142;', 'flozen-theme'); ?>
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </header>

    <?php
    $tags_list = $show_tag_info ? get_the_tag_list('', esc_html__(', ', 'flozen-theme')) : false;
    if($show_cat_info || $tags_list) : ?>
        <footer class="entry-meta">
            <?php if ('post' == get_post_type()) : ?>
                <?php if ($show_cat_info) : ?>
                    <?php $categories_list = get_the_category_list(esc_html__(', ', 'flozen-theme')); ?>
                    <span class="cat-links">
                        <?php printf(esc_html__('Posted in %1$s', 'flozen-theme'), $categories_list); ?>
                    </span>
                <?php endif; ?>

                <?php if ($tags_list) : ?>
                    <?php if ($show_cat_info) : ?>
                        <span class="sep"> | </span>
                    <?php endif; ?>
                    <span class="tags-links">
                        <?php printf(esc_html__('Tagged %1$s', 'flozen-theme'), $tags_list); ?>
                    </span>
                <?php endif; ?>
            <?php endif; ?>
        </footer>
    <?php endif; ?>
</article>
