<div class="article-layout article-list ">
    <div class="article-item odd">
        <div class="article-item-inner row text-left">
            <div class="col-sm-3">
                <a href="<?= esc_url( get_permalink() ); ?>">
                    <?php
                        $thumbnailId = get_post_meta(get_the_ID(), '_thumbnail_id', $single = true);
                        if($thumbnailId) {
                    ?>
                    <img class=" ls-is-cached lazyloaded" data-="" src="<?= wp_get_attachment_image_url($thumbnailId, $size = 'full', $icon = false) ?>" alt="Ladipiscing erat llentesque pellentesque eton">
                    <?php } else {?>
                        <img class=" ls-is-cached lazyloaded" data-="" src="<?= get_template_directory_uri() . '/app/images/no-img.jpg'; ?>" alt="Ladipiscing erat llentesque pellentesque eton">
                    <?php }?>
                </a>
            </div>
            <div class="article-intro col-sm-9">
                <div class="article-name">
                    <a href="<?= esc_url( get_permalink() ); ?>"><?= the_title(); ?></a>
                </div>
                <p class="articledate">
                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                    <time datetime="<?= get_the_date('Y/m/d H:i:s') ?>"><?= get_the_date('Y/m/d') ?></time> / by: <?php the_author_meta( 'user_nicename' , $author_id ); ?> 
                </p>
                <div class="intro-content" style="padding: 0 0 10px;">
                    <p><?=substr(get_the_content(), 0, 300) ?></p>
                </div>
                <a class="btn readmore-page" href="<?= esc_url( get_permalink() ); ?>">Read more <i class="fa fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
</div>