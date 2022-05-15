<?php
/**
 * The template for displaying search forms mobile in nasatheme
 *
 * @package     nasatheme
 * @version     1.0.0
 */

$_id = rand();
?>
<div class="search-wrapper nasa-ajaxsearchform-container <?php echo esc_attr($_id); ?>_container">
    <form method="get" class="nasa-ajaxsearchform nasa-search-mobile" action="<?php echo esc_url(home_url('/')) ?>">
        <div class="search-control-group control-group">
            <label class="hidden-tag"><?php esc_html_e('What are you looking for?', 'flozen-theme'); ?></label>
            <input id="nasa-input-<?php echo esc_attr($_id); ?>" type="text" class="search-field search-input live-search-input" value="<?php echo get_search_query();?>" name="s" placeholder="<?php esc_attr_e("Start typing ...", 'flozen-theme'); ?>" />
            <input type="hidden" class="search-param" name="post_type" value="product" />
            <div class="nasa-vitual-hidden">
                <input type="submit" name="page" value="search" />
            </div>
        </div>
    </form>
</div>