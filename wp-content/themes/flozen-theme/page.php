<?php
/**
 * The template for displaying all pages.
 *
 * @package nasatheme
 */

/**
 * Check Comment open in page
 */
$comment_open = comments_open() || get_comments_number() ? true : false;

/**
 * Header Page
 */
get_header();

/* Hook Display popup window */
do_action('nasa_before_page_wrapper'); ?>

<?php if (has_excerpt()): ?>
    <div class="page-header">
        <?php the_excerpt(); ?>
    </div>
<?php endif; ?>

<div class="row nasa-page-default">
    <div class="large-12 left columns">
        <?php
        while (have_posts()) :
            the_post();
            get_template_part('content', 'page');
            if ($comment_open) :
                echo '<div class="nasa-clear-both padding-bottom-10"></div>';
                comments_template();
            endif;
        endwhile;
        ?>
    </div>
</div>

<?php
do_action('nasa_after_page_wrapper');

/**
 * Footer Page
 */
get_footer();
