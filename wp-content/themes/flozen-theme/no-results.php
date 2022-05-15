<?php
/**
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package nasatheme
 */
?>

<article id="post-0" class="post no-results not-found nasa-search-post-no-result">
    <header class="entry-header text-center">
        <i class="nasa-icon icon-nasa-if-search"></i>
        <h1 class="entry-title"><?php esc_html_e('Nothing Found', 'flozen-theme'); ?></h1>
    </header>

    <div class="entry-content text-center">
        <?php if (is_home() && current_user_can('publish_posts')) : ?>
            <p>
                <?php
                printf(wp_kses(__('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'flozen-theme'), array('a' => array('href' => array()))), esc_url(admin_url('post-new.php')));
                ?>
            </p>
        <?php elseif (is_search()) : ?>
            <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'flozen-theme'); ?></p>
            <?php get_search_form(); ?>
        <?php else : ?>
            <p><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'flozen-theme'); ?></p>
            <?php get_search_form(); ?>
        <?php endif; ?>
    </div>
</article>
