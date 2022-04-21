<?php while ( have_posts() ) : the_post(); ?>
<div id="" class="col-md-9 col-sm-12">
    <div class="article-container">
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
                    <time datetime="<?= get_the_date('Y/m/d H:i:s') ?>"><?= get_the_date('Y/m/d') ?></time> / by: elomus-theme Admin
                </p>
                <div class="intro-content" style="padding: 0 0 10px;">
                    <p><?= the_content() ?></p>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="comment-respond">
            <h3 class="comment-reply-title">Leave a comment </h3>
            <span class="email-notes">Your email address will not be published.</span>
            <form method="post" action="/blogs/news/ladipiscing-erat-llentesque-pellentesque-eton/comments#comment_form" id="comment_form" accept-charset="UTF-8" class="comment-form">
                <input type="hidden" name="form_type" value="new_comment">
                <input type="hidden" name="utf8" value="✓">
                <div class="row">
                    <div class="col-md-6">
                        <p>Your Name *</p>
                        <input type="text" name="comment[author]" id="CommentAuthor" placeholder="Your Name" value="" autocapitalize="words">
                    </div>
                    <div class="col-md-6">
                        <p>Email address *</p>
                        <input type="email" name="comment[email]" id="CommentEmail" placeholder="Email address" value="" autocorrect="off" autocapitalize="off">
                    </div>
                    <div class="col-md-12 comment-form-comment">
                        <p>Message</p>
                        <textarea cols="30" rows="10" name="comment[body]" id="CommentBody" placeholder="Message"></textarea>
                        <input type="submit" value="Post comment">
                    </div>
                </div>
                <p style="margin-top: 10px;">Please note, comments must be approved before they are published.</p>
            </form>
        </div>
    </div>
</div>
<?php endwhile; ?>