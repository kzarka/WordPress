<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package nasatheme
 */
$nasa_sidebar = isset($nasa_opt['blog_layout']) ? $nasa_opt['blog_layout'] : 'left';
if (!is_active_sidebar('blog-sidebar')) :
    $nasa_sidebar = 'no';
endif;

$sidebarClass = 'large-3 columns col-sidebar';
$mainClass = 'container-wrap nasa-results-page';
switch ($nasa_sidebar):
    case 'right':
        $attr = 'large-9 left columns desktop-padding-right-30';
        $mainClass .= ' page-right-sidebar';
        $sidebarClass .= ' right';
        break;
    
    case 'no':
        $attr = 'large-10 columns large-offset-1';
        $mainClass .= ' page-no-sidebar';
        break;
    
    case 'left':
    default:
        $attr = 'large-9 right columns desktop-padding-left-30';
        $mainClass .= ' page-left-sidebar';
        $sidebarClass .= ' left';
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
            <div class="page-inner margin-bottom-50">
                <?php if (have_posts()) : ?>
                    <header class="page-header">
                        <h1 class="page-title"><?php printf(esc_html__('Search Results for: %s', 'flozen-theme'), '<span>' . get_search_query() . '</span>'); ?></h1>
                    </header>
                <?php
                    get_template_part('content', get_post_format());
                    flozen_content_nav('nav-below');
                else :
                    get_template_part('no-results', 'search');
                endif;
                ?>
            </div>
        </div>

        <?php if ($nasa_sidebar != 'no'): ?>
            <div class="<?php echo esc_attr($sidebarClass); ?>">
                <?php get_sidebar(); ?>
            </div>
        <?php endif; ?>

    </div>	
</div>

<?php
get_footer();
