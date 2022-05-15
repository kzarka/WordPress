<?php
/**
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package nasatheme
 */

$nasa_sidebar = isset($nasa_opt['blog_layout']) ? $nasa_opt['blog_layout'] : 'left';
if (!is_active_sidebar('blog-sidebar')) :
    $nasa_sidebar = 'no';
endif;

$left = false;
$mainClass = 'container-wrap';
$sidebarClass = 'large-3 columns col-sidebar';
switch ($nasa_sidebar):
    case 'right':
        $attr = 'large-9 desktop-padding-right-30 left columns';
        $mainClass .= ' page-right-sidebar';
        $sidebarClass .= ' right desktop-padding-left-20';
        break;
    
    case 'no':
        $attr = 'large-10 columns large-offset-1';
        $mainClass .= ' page-no-sidebar';
        break;
    
    case 'left':
    default:
        $left = true;
        $attr = 'large-9 desktop-padding-left-30 right columns';
        $mainClass .= ' page-left-sidebar';
        $sidebarClass .= ' left desktop-padding-right-20';
        break;
endswitch;

if (isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile']) :
    $attr .= ' nasa-blog-in-mobile';
endif;

get_header();
?>

<div class="<?php echo esc_attr($mainClass); ?>">

    <?php if ($nasa_sidebar != 'no'): ?>
        <div class="div-toggle-sidebar nasa-blog-sidebar center">
            <a class="toggle-sidebar" href="javascript:void(0);">
                <i class="fa fa-bars"></i>
            </a>
        </div>
    <?php endif; ?>

    <div class="row">
        <div id="content" class="<?php echo esc_attr($attr); ?>">
            <?php if (have_posts()) : ?>
                <header class="page-header">
                    <h1 class="page-title">
                        <?php
                        if (is_category()) :
                            printf(esc_html__('Category Archives: %s', 'flozen-theme'), '<span>' . single_cat_title('', false) . '</span>');

                        elseif (is_tag()) :
                            printf(esc_html__('Tag Archives: %s', 'flozen-theme'), '<span>' . single_tag_title('', false) . '</span>');

                        elseif (is_author()) : the_post();
                            printf(esc_html__('Author Archives: %s', 'flozen-theme'), '<span class="vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '" title="' . esc_attr(get_the_author()) . '" rel="me">' . get_the_author() . '</a></span>');
                            rewind_posts();

                        elseif (is_day()) :
                            printf(esc_html__('Daily Archives: %s', 'flozen-theme'), '<span>' . get_the_date() . '</span>');

                        elseif (is_month()) :
                            printf(esc_html__('Monthly Archives: %s', 'flozen-theme'), '<span>' . get_the_date('F Y') . '</span>');

                        elseif (is_year()) :
                            printf(esc_html__('Yearly Archives: %s', 'flozen-theme'), '<span>' . get_the_date('Y') . '</span>');

                        elseif (is_tax('post_format', 'post-format-aside')) :
                            esc_html_e('Asides', 'flozen-theme');

                        elseif (is_tax('post_format', 'post-format-image')) :
                            esc_html_e('Images', 'flozen-theme');

                        elseif (is_tax('post_format', 'post-format-video')) :
                            esc_html_e('Videos', 'flozen-theme');

                        elseif (is_tax('post_format', 'post-format-quote')) :
                            esc_html_e('Quotes', 'flozen-theme');

                        elseif (is_tax('post_format', 'post-format-link')) :
                            esc_html_e('Links', 'flozen-theme');

                        else :
                            esc_html_e('', 'flozen-theme');

                        endif;
                        ?>
                    </h1>
                    <?php
                    if (is_category()) :
                        $category_description = category_description();
                        if (!empty($category_description)) :
                            echo apply_filters('category_archive_meta', '<div class="taxonomy-description">' . $category_description . '</div>');
                        endif;

                    elseif (is_tag()) :
                        $tag_description = tag_description();
                        if (!empty($tag_description)) :
                            echo apply_filters('tag_archive_meta', '<div class="taxonomy-description">' . $tag_description . '</div>');
                        endif;

                    endif;
                    ?>
                </header>

                <div class="page-inner">
                    <?php get_template_part('content', get_post_format()); ?>
                </div>
            <?php else : ?>
                <?php get_template_part('no-results', 'archive'); ?>
            <?php endif; ?>
        </div>

        <?php if ($nasa_sidebar != 'no') : ?>
            <div class="<?php echo esc_attr($sidebarClass); ?>">
                <?php get_sidebar(); ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php
get_footer();
