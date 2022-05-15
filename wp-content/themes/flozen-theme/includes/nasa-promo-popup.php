<?php
$background_image = isset($nasa_opt['pp_background_image']) && $nasa_opt['pp_background_image'] != '' ?
    $nasa_opt['pp_background_image'] : FLOZEN_THEME_URI . '/assets/images/newsletter_bg.jpg';
$background_color = isset($nasa_opt['pp_background_color']) ? $nasa_opt['pp_background_color'] : 'transparent';
$pp_style = isset($nasa_opt['pp_style']) && $nasa_opt['pp_style'] == 'full' ? 'full' : 'simple';
$class_content = 'columns large-6 medium-12 small-12 nasa-pp-right';
$class_content .= $pp_style == 'full' ? ' large-12' : ' large-6 right';
?>
<style>
#nasa-popup {
    width: <?php echo isset($nasa_opt['pp_width']) ? (int) $nasa_opt['pp_width'] : 734; ?>px;
    background-repeat: no-repeat;
    background-size: auto;
    background-color: <?php echo esc_attr($background_color); ?>;
    <?php
    if ($background_image) :
        echo 'background-image: url("' . esc_url($background_image) . '");';
    endif;
    ?>
}
#nasa-popup,
#nasa-popup .nasa-popup-wrap {
    height: <?php echo isset($nasa_opt['pp_height']) ? (int) $nasa_opt['pp_height'] : 501; ?>px;
}
.nasa-pp-left {
    min-height: 1px;
}
</style>
<div id="nasa-popup" class="white-popup-block mfp-hide mfp-with-anim zoom-anim-dialog">
    <div class="row">
        <?php if($pp_style == 'simple'): ?>
            <div class="columns large-6 medium-12 small-12 nasa-pp-left"></div>
        <?php endif; ?>
        <div class="<?php echo esc_attr($class_content); ?>">
            <div class="nasa-popup-wrap nasa-relative">
                <div class="nasa-popup-wrap-content">
                    <?php
                    /**
                     * Content description
                     */
                    echo isset($nasa_opt['pp_content']) ? do_shortcode($nasa_opt['pp_content']) : '';
                    
                    /**
                     * Content contact form 7
                     */
                    echo (isset($nasa_opt['pp_contact_form']) && (int) $nasa_opt['pp_contact_form'] && shortcode_exists('contact-form-7')) ? do_shortcode('[contact-form-7 id="' . ((int) $nasa_opt['pp_contact_form']) . '"]') : '';
                    ?>
                </div>
                <hr class="nasa-popup-hr" />
                <p class="checkbox-label align-center">
                    <input id="showagain" class="showagain" type="checkbox" value="do-not-show" name="showagain" />
                    <label for="showagain">
                        <?php esc_html_e("Don't show this popup again", 'flozen-theme'); ?>
                    </label>
                </p>
            </div>
        </div>
    </div>
</div>
