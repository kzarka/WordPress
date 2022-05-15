<?php
/**
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     3.4.0
 */
if (!defined('ABSPATH')){
    exit; // Exit if accessed directly
}

global $nasa_opt, $wp_query;

$type_view = !isset($nasa_opt['products_type_view']) ?
    'grid' : ($nasa_opt['products_type_view'] == 'list' ? 'list' : 'grid');

$nasa_opt['products_per_row'] = isset($nasa_opt['products_per_row']) && (int) $nasa_opt['products_per_row'] ?
    (int) $nasa_opt['products_per_row'] : 4;
$nasa_opt['products_per_row'] = $nasa_opt['products_per_row'] > 5 || $nasa_opt['products_per_row'] < 3 ? 4 : $nasa_opt['products_per_row'];
$nasa_change_view = !isset($nasa_opt['enable_change_view']) || $nasa_opt['enable_change_view'] ? true : false;

$type_show = $type_view == 'grid' ? ($type_view . '-' . ((int) $nasa_opt['products_per_row'])) : 'list';

$nasa_cat_obj = $wp_query->get_queried_object();
$nasa_term_id = 0;
$nasa_type_page = 'product_cat';
$nasa_href_page = '';
if (isset($nasa_cat_obj->term_id) && isset($nasa_cat_obj->taxonomy)) {
    $nasa_term_id = (int) $nasa_cat_obj->term_id;
    $nasa_type_page = $nasa_cat_obj->taxonomy;
    $nasa_href_page = esc_url(get_term_link($nasa_cat_obj, $nasa_type_page));
}

$nasa_sidebar = isset($nasa_opt['category_sidebar']) ? $nasa_opt['category_sidebar'] : 'left-classic';
$nasa_has_get_sidebar = false;

$sidebar_name = flozen_get_sidebar_run();
if (!is_active_sidebar($sidebar_name)) :
    $nasa_sidebar = 'no';
endif;

$toggleSidebar = false;
$hasCustomFilter = false;
if (
    isset($nasa_opt['archive_product_nasa_custom_categories']) &&
    $nasa_opt['archive_product_nasa_custom_categories'] &&
    isset($nasa_opt['enable_nasa_custom_categories']) &&
    $nasa_opt['enable_nasa_custom_categories'] &&
    shortcode_exists('nasa_product_nasa_categories')
) :
    $toggleSidebar = true;
    $hasCustomFilter = true;
endif;

$hasSidebar = true;
$topSidebar = false;
$topSidebar2 = false;
$topbar_wrap_class = 'row filters-container nasa-filter-wrap';
$class_wrap_all = 'row fullwidth category-page nasa-category-page-wrap';
$attr = 'nasa-products-page-wrap ';
$toggle_class_wrap = 'large-3 columns hide-for-small';
switch ($nasa_sidebar):
    case 'right':
    case 'left':
        $attr .= 'large-12 columns has-sidebar nasa-with-sidebar-off-canvas';
        $topbar_wrap_class .= ' nasa-with-sidebar-off-canvas';
        break;
    
    case 'right-classic':
        $class_wrap_all .= ' nasa-with-sidebar-classic nasa-invisible';
        $attr .= 'large-9 columns left has-sidebar';
        $topbar_wrap_class .= ' top-bar-classic';
        $toggle_class_wrap .= ' right text-right';
        break;
    
    case 'no':
        $hasSidebar = false;
        $class_wrap_all .= ' nasa-with-sidebar-classic nasa-with-no-sidebar';
        $attr .= 'large-12 columns no-sidebar';
        break;
    
    case 'top':
        $hasSidebar = false;
        $topSidebar = true;
        $topbar_wrap_class .= ' top-bar-wrap-type-1';
        $attr .= 'large-12 columns no-sidebar top-sidebar';
        break;
    
    case 'top-2':
        $hasSidebar = false;
        $topSidebar2 = true;
        $topbar_wrap_class .= ' top-bar-wrap-type-2';
        $attr .= 'large-12 columns no-sidebar top-sidebar-2';
        break;
    
    case 'left-classic':
    default :
        $class_wrap_all .= ' nasa-with-sidebar-classic nasa-invisible';
        $attr .= 'large-9 columns right has-sidebar';
        $topbar_wrap_class .= ' top-bar-classic';
        $toggle_class_wrap .= ' left text-left';
        break;
endswitch;

$topbar_wrap_class .= (!$toggleSidebar && !$hasCustomFilter) ? ' nasa-empty-content' : '';

$nasa_recom_pos = isset($nasa_opt['recommend_product_position']) ? $nasa_opt['recommend_product_position'] : 'bot';

$layout_style = '';
if(
    (isset($_REQUEST['layout-style']) && $_REQUEST['layout-style'] == 'masonry') ||
    (isset($nasa_opt['products_layout_style']) && $nasa_opt['products_layout_style'] == 'masonry-isotope')
) :
    $layout_style = ' nasa-products-masonry-isotope';
endif;

get_header('shop');
?>

<div class="<?php echo esc_attr($class_wrap_all); ?>">
    <?php if (in_array($nasa_sidebar, array('left-classic', 'right-classic', 'no'))) : ?>
        <!-- Change view && Order by -->
        <div class="order-change-view-wrap order-change-view-wrap-classic">
            <?php if ($nasa_change_view) : ?>
                <div class="nasa-change-view-layout-side-sidebar">
                    <?php // Change view ICONS
                    do_action('nasa_change_view', $nasa_change_view, $type_show, $nasa_sidebar);
                    ?>
                </div>
            <?php endif; ?>
            <div class="nasa-sort-bar-layout-side-sidebar">
                <ul class="sort-bar">
                    <?php if ($hasSidebar): ?>
                        <li class="li-toggle-sidebar">
                            <a class="toggle-sidebar" href="javascript:void(0);">
                                <i class="pe-7s-filter"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="nasa-filter-order filter-order">
                        <?php do_action('woocommerce_before_shop_loop'); ?>
                    </li>
                </ul>
            </div>
        </div>
    <?php endif; ?>
    
    <?php do_action('woocommerce_before_main_content'); ?>
    
    <?php
    /**
     * Hook: woocommerce_archive_description.
     *
     * @hooked woocommerce_taxonomy_archive_description - 10
     * @hooked woocommerce_product_archive_description - 10
     */
    do_action('woocommerce_archive_description');
    ?>
    
    <div class="large-12 columns">
        <div class="<?php echo esc_attr($topbar_wrap_class); ?>">
            <?php
            /**
             * Top Side bar Type 1
             */
            if($topSidebar) :
                $top_sidebar_wrap = $nasa_change_view ? 'large-10 ' : 'large-12 ';

                if(!isset($nasa_opt['showing_info_top']) || $nasa_opt['showing_info_top']) :
                    echo '<div class="showing_info_top hidden-tag">';
                    do_action('nasa_shop_category_count');
                    echo '</div>';
                endif;
                ?>

                <div class="<?php echo esc_attr($top_sidebar_wrap); ?>columns nasa-topbar-filter-wrap">
                    <div class="row">
                        <div class="large-10 medium-10 columns nasa-filter-action">
                            <div class="nasa-labels-filter-top">
                                <input name="nasa-labels-filter-text" type="hidden" value="<?php echo (!isset($nasa_opt['top_bar_archive_label']) || $nasa_opt['top_bar_archive_label'] == 'Filter by:') ? esc_attr__('Filter by:', 'flozen-theme') : esc_attr($nasa_opt['top_bar_archive_label']); ?>" />
                                <input name="nasa-widget-show-more-text" type="hidden" value="<?php echo esc_attr__('More +', 'flozen-theme'); ?>" />
                                <input name="nasa-widget-show-less-text" type="hidden" value="<?php echo esc_attr__('Less -', 'flozen-theme'); ?>" />
                                <input name="nasa-limit-widgets-show-more" type="hidden" value="<?php echo (!isset($nasa_opt['limit_widgets_show_more']) || (int) $nasa_opt['limit_widgets_show_more'] < 0) ? '2' : (int) $nasa_opt['limit_widgets_show_more']; ?>" />
                                
                                <a class="toggle-topbar-shop-mobile hidden-tag" href="javascript:void(0);">
                                    <i class="pe-7s-filter"></i><?php echo esc_attr__('&nbsp;Filters', 'flozen-theme'); ?>
                                </a>
                                <span class="nasa-labels-filter-accordion hidden-tag"></span>
                            </div>
                        </div>
                        
                        <div class="large-2 medium-2 columns nasa-sort-by-action right rtl-left">
                            <ul class="sort-bar nasa-float-none margin-top-0">
                                <li class="sort-bar-text nasa-order-label hidden-tag">
                                    <?php esc_html_e('Sort by', 'flozen-theme'); ?>
                                </li>
                                <li class="nasa-filter-order filter-order">
                                    <?php do_action('woocommerce_before_shop_loop'); ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <?php if($nasa_change_view) : ?>
                    <div class="large-2 columns nasa-topbar-change-view-wrap">
                        <?php /* Change view ICONS */
                        $type_sidebar = (!isset($nasa_opt['top_bar_cat_pos']) || $nasa_opt['top_bar_cat_pos'] == 'left-bar') ? 'top-push-cat' : 'no';
                        do_action('nasa_change_view', $nasa_change_view, $type_show, $type_sidebar); ?>
                    </div>
                <?php endif; ?>

                <?php
                /* Sidebar TOP */
                do_action('nasa_top_sidebar_shop');
                
                /**
                 * Custom nasa taxonomy
                 */
                flozen_nasa_custom_filter_taxonomies('large-12 medium-12 small-12 columns nasa-filter_custom_taxonomies margin-top-20');
                
            /**
             * Top Side bar type 2
             */
            elseif ($topSidebar2) :
                /**
                 * Custom nasa taxonomy
                 */
                flozen_nasa_custom_filter_taxonomies('large-12 medium-12 small-12 columns');
                ?>
            
                <div class="large-12 columns">
                    <div class="row">
                        <div class="large-4 medium-6 small-6 columns nasa-toggle-top-bar rtl-right">
                            <a class="nasa-toggle-top-bar-click" href="javascript:void(0);">
                                <i class="pe-7s-angle-down"></i> <?php esc_html_e('Filter', 'flozen-theme'); ?>
                            </a>
                        </div>
                        
                        <div class="large-4 columns nasa-topbar-change-view-wrap hide-for-medium hide-for-small text-center rtl-right">
                            <?php if($nasa_change_view) : ?>
                                <?php /* Change view ICONS */
                                do_action('nasa_change_view', $nasa_change_view, $type_show); ?>
                            <?php endif; ?>
                        </div>
                        
                        <div class="large-4 medium-6 small-6 columns nasa-sort-by-action nasa-clear-none text-right rtl-text-left">
                            <ul class="sort-bar nasa-float-none margin-top-0">
                                <li class="sort-bar-text nasa-order-label hidden-tag">
                                    <?php esc_html_e('Sort by: ', 'flozen-theme'); ?>
                                </li>
                                <li class="nasa-filter-order filter-order">
                                    <?php do_action('woocommerce_before_shop_loop'); ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="large-12 columns nasa-top-bar-2-content hidden-tag">
                    <?php do_action('nasa_top_sidebar_shop', '2'); ?>
                </div>
            
            <?php
            /**
             * TOGGLE Side bar in side (Off-Canvas)
             */
            elseif ($hasSidebar && in_array($nasa_sidebar, array('left', 'right'))) : ?>
                <div class="large-4 medium-6 small-6 columns nasa-toggle-layout-side-sidebar rtl-right rtl-text-right">
                    <div class="li-toggle-sidebar nasa-show-in-mobile">
                        <a class="toggle-sidebar-shop" href="javascript:void(0);">
                            <i class="pe-7s-filter"></i>&nbsp;&nbsp;<?php esc_html_e('Filter', 'flozen-theme'); ?>
                        </a>
                    </div>
                </div>
                
                <div class="large-4 columns hide-for-medium hide-for-small rtl-right nasa-change-view-layout-side-sidebar nasa-min-height">
                    <?php /* Change view ICONS */
                    do_action('nasa_change_view', $nasa_change_view, $type_show); ?>
                </div>
            
                <div class="large-4 medium-6 small-6 columns rtl-left rtl-text-left nasa-sort-bar-layout-side-sidebar nasa-clear-none nasa-min-height">
                    <ul class="sort-bar">
                        <li class="sort-bar-text nasa-order-label hidden-tag">
                            <?php esc_html_e('Sort by', 'flozen-theme'); ?>
                        </li>
                        <li class="nasa-filter-order filter-order">
                            <?php do_action('woocommerce_before_shop_loop'); ?>
                        </li>
                    </ul>
                </div>
            
                <?php
                /**
                 * Custom nasa taxonomy
                 */
                flozen_nasa_custom_filter_taxonomies('large-12 medium-12 small-12 nasa-filter_custom_taxonomies columns margin-top-30');
                ?>
            <?php
            
            /**
             * No | left-classic | right-classic side bar
             */
            elseif ($hasSidebar && in_array($nasa_sidebar, array('left-classic', 'right-classic'))) : ?>
                <?php if ($toggleSidebar) : ?>
                    <div class="<?php echo esc_attr($toggle_class_wrap); ?>">
                        <a href="javascript:void(0);" class="nasa-toogle-sidebar-classic nasa-hide-in-mobile rtl-text-right">
                            <span class="nasa-text-show">
                                <?php echo esc_html__('Show Menu', 'flozen-theme') ;?>
                            </span>
                            <span class="nasa-text-hide">
                                <?php echo esc_html__('Hide Menu', 'flozen-theme') ;?>
                            </span>
                        </a>
                    </div>
                <?php endif; ?>
                <?php
                /**
                 * Custom nasa taxonomy
                 */
                flozen_nasa_custom_filter_taxonomies('large-9 small-12 columns nasa-full-in-mobile');
                ?>
            <?php else : ?>
                <?php
                /**
                 * Custom nasa taxonomy
                 */
                flozen_nasa_custom_filter_taxonomies('large-12 small-12 columns nasa-full-in-mobile');
                ?>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="nasa-archive-product-content">
        <?php if($topSidebar && (!isset($nasa_opt['top_bar_cat_pos']) || $nasa_opt['top_bar_cat_pos'] == 'left-bar')) :
            $attr .= ' nasa-has-push-cat';
            $class_cat_top = 'nasa-push-cat-filter';
            if(isset ($_REQUEST['push_cat_filter']) && $_REQUEST['push_cat_filter']) :
                $class_cat_top .= ' nasa-push-cat-show';
                $attr .= ' nasa-push-cat-show';
            endif;
            ?>
            <div class="<?php echo esc_attr($class_cat_top); ?>"></div>
        <?php endif; ?>
        
        <div class="<?php echo esc_attr($attr); ?>">

            <?php if(!isset($nasa_opt['disable_ajax_product_progress_bar']) || $nasa_opt['disable_ajax_product_progress_bar'] != 1) : ?>
                <div class="nasa-progress-bar-load-shop"><div class="nasa-progress-per"></div></div>
            <?php endif; ?>

            <?php if($nasa_recom_pos !== 'bot' && defined('NASA_CORE_ACTIVED') && NASA_CORE_ACTIVED) : ?>
                <span id="position-nasa-recommend-product" class="hidden-tag"></span>
                <?php do_action('nasa_recommend_product', $nasa_term_id); ?>
            <?php endif; ?>

            <div class="nasa-archive-product-warp<?php echo esc_attr($layout_style); ?>">
                <?php
                if (woocommerce_product_loop()) :
                    // Content products in shop
                    if(NASA_WOO_ACTIVED && version_compare(WC()->version, '3.3.0', "<")) :
                        do_action('nasa_archive_get_sub_categories');
                    endif;
                    
                    woocommerce_product_loop_start();
                    do_action('nasa_get_content_products', $nasa_sidebar);
                    woocommerce_product_loop_end();
                else :
                    echo '<div class="row"><div class="large-12 columns">';
                    do_action('woocommerce_no_products_found');
                    echo '</div></div>';
                endif;
                ?>
            </div>
                
            <?php
            /**
             * Hook: woocommerce_after_shop_loop.
             *
             * @hooked woocommerce_pagination - 10
             */
            do_action('woocommerce_after_shop_loop');
            ?>

            <?php if($nasa_recom_pos == 'bot' && defined('NASA_CORE_ACTIVED') && NASA_CORE_ACTIVED) :?>
                <span id="position-nasa-recommend-product" class="hidden-tag"></span>
                <?php do_action('nasa_recommend_product', $nasa_term_id); ?>
            <?php endif; ?>
        </div>

        <?php /* Sidebar LEFT | RIGHT */
        if ($hasSidebar && !$topSidebar && !$topSidebar2) :
            do_action('nasa_sidebar_shop', $nasa_sidebar);
        endif;
        
        do_action('woocommerce_after_main_content');
        ?>
    </div>
</div>

<?php
$shop_ajax_product = true;
if(!isset($nasa_opt['shop_ajax_product']) || !$nasa_opt['shop_ajax_product'] || get_option('woocommerce_shop_page_display', '') != '' || get_option('woocommerce_category_archive_display', '') != '') :
    $shop_ajax_product = false;
endif;

if($shop_ajax_product) : ?>
    <div class="nasa-has-filter-ajax hidden-tag">
        <div class="current-cat hidden-tag">
            <a data-id="<?php echo absint($nasa_term_id); ?>" href="<?php echo esc_url($nasa_href_page); ?>" class="nasa-filter-by-cat" id="nasa-hidden-current-cat" data-taxonomy="<?php echo esc_attr($nasa_type_page); ?>" data-sidebar="<?php echo esc_attr($nasa_sidebar); ?>"></a>
        </div>
        <p>
            <?php esc_html_e('No products were found matching your selection.', 'flozen-theme'); ?>
        </p>
        <?php if ($s = get_search_query()): ?>
            <input type="hidden" name="nasa_hasSearch" id="nasa_hasSearch" value="<?php echo esc_attr($s); ?>" />
        <?php endif; ?>
        <?php if($nasa_has_get_sidebar) : ?>
            <input type="hidden" name="nasa_getSidebar" id="nasa_getSidebar" value="<?php echo esc_attr($nasa_sidebar); ?>" />
        <?php endif; ?>
            
        <?php
        // <!-- Current URL -->
        $slug_nopaging = flozen_nopaging_url();
        if ($slug_nopaging) :
            echo '<input type="hidden" name="nasa_current-slug" id="nasa_current-slug" value="' . esc_url($slug_nopaging) . '" />';
        endif;
        ?>
    </div>
<?php endif;

get_footer('shop');
