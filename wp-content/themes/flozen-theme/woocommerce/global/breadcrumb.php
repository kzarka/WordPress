<?php

/**
 * Shop breadcrumb
 *
 * @author 	WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */
if (!defined('ABSPATH')) :
    exit; // Exit if accessed directly
endif;

if (!empty($breadcrumb)) {
    global $post, $nasa_opt, $wp_query;
?>
    <div id="nasa-breadcrumb-site" class="<?php echo esc_attr($class_bread_wrap); ?>"<?php echo ('' !== $style_custom) ? ' style="' . esc_attr($style_custom) . '"' : ''; ?>>
        <div class="row">
            <div class="large-12 columns nasa-display-table">
                <div class="breadcrumb-row <?php echo esc_attr($bread_align); ?>"<?php if ($style_height): ?> style="<?php echo esc_attr($style_height); ?>"<?php endif; ?>>
                    <?php
                    /**
                     * Single Portfolio
                     */
                    if (is_singular('portfolio')) {
                        $breadcrumb = flozen_rebuilt_breadcrumb_portfolio($breadcrumb);
                    }

                    /**
                     * Archive Portfolio
                     */
                    else {
                        $queried_object = $wp_query->get_queried_object();

                        if(isset($queried_object->taxonomy) && $queried_object->taxonomy == 'portfolio_category') {
                            $breadcrumb = flozen_rebuilt_breadcrumb_portfolio($breadcrumb, false);
                        }
                    }

                    echo flozen_str($wrap_before);

                    $key = 0;
                    $sizeof = sizeof($breadcrumb);
                    foreach ($breadcrumb as $crumb) {
                        echo flozen_str($before);

                        echo (!empty($crumb[1]) && $sizeof !== $key + 1) ?
                            '<a href="' . esc_url($crumb[1]) . '" title="' . esc_attr($crumb[0]) . '">' .
                                esc_html($crumb[0]) .
                            '</a>' :
                            esc_html($crumb[0]);

                        echo flozen_str($after);

                        if ($sizeof !== $key + 1) {
                            echo flozen_str($delimiter);
                        }

                        $key++;
                    }

                    echo flozen_str($wrap_after);
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php
}
