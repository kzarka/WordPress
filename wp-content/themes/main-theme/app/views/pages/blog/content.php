<?php while ( have_posts() ) : the_post(); ?>
<div id="" class="col-md-9 col-sm-12">
    <div class="article-container">
        <div class="article-title">
            <h1><?= the_title() ?></h1>
        </div>
        <div class="article-date" style="width: 100%;"> Tác giả: <?= get_the_author() ?> - <time datetime="<?= get_the_date('Y/m/d H:i:s') ?>"> <?= get_the_date('Y/m/d') ?> </time>
        </div>
        <div class="article-description">
            <?= the_content() ?>
        </div>
        <div class="clear"></div>
    </div>
</div>
<?php endwhile; ?>