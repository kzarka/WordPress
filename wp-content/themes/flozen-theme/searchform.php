<?php
/**
 * The template for displaying search forms in nasatheme
 *
 * @package nasatheme
 */
$_id = rand();
$postType = apply_filters('nasa_search_post_type', 'post');
$classForm = 'nasa-ajaxsearchform nasa-search-desktop nasa-form-search-' . trim($postType);
$classInput = 'search-field search-input';
if ($postType === 'product') :
    $classInput .= ' live-search-input';
endif;
?>

<div class="search-wrapper nasa-ajaxsearchform-container <?php echo esc_attr($_id); ?>_container">
    <div class="nasa-search-form-warp">
        <form method="get" class="<?php echo esc_attr($classForm); ?>" action="<?php echo esc_url(home_url('/')); ?>">
            <div class="search-control-group control-group">
                <label class="sr-only screen-reader-text" for="nasa-input-<?php echo esc_attr($_id); ?>">
                    <?php esc_html_e('What are you looking for?', 'flozen-theme'); ?>
                </label>
                
                <?php
                /**
                 * Hook Hot keywords
                 */
                if ($postType === 'product') :
                    do_action('nasa_before_btn_submit_search');
                endif; ?>
                
                <input id="nasa-input-<?php echo esc_attr($_id); ?>" type="text" class="<?php echo esc_attr($classInput); ?>" value="<?php echo get_search_query(); ?>" name="s" placeholder="<?php esc_attr_e("Start typing ...", 'flozen-theme'); ?>" />
                
                <span class="nasa-icon-submit-page">
                    <input type="submit" name="page" value="search" />
                </span>
                <input type="hidden" name="post_type" value="<?php echo esc_attr($postType); ?>" />
            </div>
        </form>
    </div>
    
    <a href="javascript:void(0);" title="<?php esc_attr_e('Close search', 'flozen-theme'); ?>" class="nasa-close-search"><i class="pe-7s-close"></i></a>
</div>
