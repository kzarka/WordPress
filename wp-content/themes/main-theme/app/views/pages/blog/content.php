<?php while ( have_posts() ) : the_post(); ?>
<div id="" class="col-md-9 col-sm-12">
    <div class="article-container">
        <div class="article-title">
            <h1><?= the_title() ?></h1>
        </div>
        <div class="article-date"> by: elomus-theme Admin - <time datetime="Wednesday, August 25, 2021 at 5:31 pm -0400"> 25/08/2021 </time>
        </div>
        <div class="article-description">
            <?= the_content() ?>
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