<?php if ( have_posts() ) : ?>
<div id="content" class="col-md-9 col-sm-12 col-xs-12">
    <div class="article-page">
        <?php while ( have_posts() ) : the_post(); ?>
        <?php renderTemplate('pages/blog/partials/single', get_post_format()); ?>
        <?php endwhile; ?>
    </div>
    <!-- Custom pagination -->
    <?php renderTemplate('components/paginator'); ?>
</div>

<?php endif; ?>