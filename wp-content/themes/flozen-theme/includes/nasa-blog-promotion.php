<?php
$number_slide = (isset($nasa_opt['number_post_slide']) && (int) $nasa_opt['number_post_slide']) ? (int) $nasa_opt['number_post_slide'] : 1;

$style_bg = (isset($nasa_opt['background_area']) && $nasa_opt['background_area']) ? 'background: url(\'' . $nasa_opt['background_area'] . '\') center center no-repeat;' : '';

$style_bg = ($style_bg != '') ? ' style="' . esc_attr($style_bg) . '"' : '';

$style_color = (isset($nasa_opt['t_promotion_color']) && $nasa_opt['t_promotion_color']) ? 'color:' . $nasa_opt['t_promotion_color'] : '';

$style_color = ($style_color != '') ? ' style="' . esc_attr($style_color) . '"' : '';
?>

<div class="section-element nasa-promotion-news nasa-hide">
    <div class="nasa-wapper-promotion">
        <div class="nasa-content-promotion-news <?php echo (!isset($nasa_opt['enable_fullwidth']) || $nasa_opt['enable_fullwidth'] == 1) ? 'nasa-row fullwidth' : 'row'; ?>"<?php echo flozen_str($style_bg); ?>>
            <a href="javascript:void(0);" title="<?php echo esc_attr__('Close', 'flozen-theme'); ?>" class="nasa-promotion-close nasa-a-icon"><i class="pe-7s-close-circle"></i></a>

            <?php if ($content): ?>
                <div class="nasa-content-promotion-custom"<?php echo flozen_str($style_color); ?>>
                    <table><tr><td><?php echo flozen_str($content); ?></td></tr></table>
                </div>
            <?php elseif (!empty($posts)): ?>
                <div class="owl-carousel nasa-post-slider" data-show="<?php echo esc_attr($number_slide); ?>">
                    <?php foreach ($posts as $v): ?>
                        <div class="nasa-post-slider-item">
                            <a href="<?php echo esc_url(get_permalink($v->ID)); ?>" title="<?php echo esc_attr($v->post_title); ?>"<?php echo flozen_str($style_color); ?>><?php echo flozen_str($v->post_title); ?></a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php wp_reset_postdata(); ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="nasa-position-relative nasa-top-80"></div>

<a href="javascript:void(0);" title="<?php echo esc_attr__('Show', 'flozen-theme'); ?>" class="nasa-promotion-show">
    <i class="pe-7s-angle-down"></i>
</a>
