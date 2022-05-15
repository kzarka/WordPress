<?php
/**
 * The main template file.
 *
 * @package nasatheme
 */

$nasa_sidebar = isset($nasa_opt['blog_layout']) ? $nasa_opt['blog_layout'] : 'left';
if (!is_active_sidebar('blog-sidebar')) :
    $nasa_sidebar = 'no';
endif;

$sidebarClass = 'large-3 columns col-sidebar';
$mainClass = 'container-wrap';
switch ($nasa_sidebar):
    case 'right':
        $attr = 'large-9 desktop-padding-right-30 left columns';
        $mainClass .= ' page-right-sidebar';
        $sidebarClass .= ' right';
        break;
    
    case 'no':
        $attr = 'large-10 columns large-offset-1';
        $mainClass .= ' page-no-sidebar';
        break;
    
    case 'left':
    default:
        $attr = 'large-9 desktop-padding-left-30 right columns';
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
    <?php if($nasa_sidebar != 'no') : ?>
        <div class="div-toggle-sidebar nasa-blog-sidebar center">
            <a class="toggle-sidebar" href="javascript:void(0);">
                <i class="fa fa-bars"></i>
            </a>
        </div>
    <?php endif;?>
        
    <div class="row">
        <div id="content" class="<?php echo esc_attr($attr);?>">
            <div class="page-inner">
                <?php if (have_posts()) :
                    get_template_part('content', get_post_format());
                else :
                    get_template_part('no-results', 'index');
                endif; ?>
            </div>
        </div>

        <?php if($nasa_sidebar != 'no'):?>
            <div class="<?php echo esc_attr($sidebarClass); ?>">
                <?php get_sidebar(); ?>
            </div>
        <?php endif;?>
    </div>
</div>

<?php
get_footer();
