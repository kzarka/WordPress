<?php
/*
  Template name: Page Checkout
 */

get_header();
?>

<div class="container-wrap page-checkout">
    <div class="order-steps">
        <div class="row">
            <div class="large-12 columns">
                <?php if (function_exists('is_wc_endpoint_url')) : ?>
                    <?php if (!is_wc_endpoint_url('order-received')) : ?>
                        <div class="checkout-breadcrumb">
                            <div class="title-cart">
                                <a href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('Shopping Cart', 'flozen-theme'); ?>">
                                    <h1>01</h1>
                                    <h4><?php esc_html_e('Shopping Cart', 'flozen-theme'); ?></h4>
                                    <p><?php esc_html_e('Manage Your Items List', 'flozen-theme'); ?></p>
                                </a>
                                <span class="pe-7s-angle-right"></span>
                            </div>

                            <div class="title-checkout">
                                <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" title="<?php esc_attr_e('Checkout Details', 'flozen-theme'); ?>">
                                    <h1>02</h1>
                                    <h4><?php esc_html_e('Checkout Details', 'flozen-theme'); ?></h4>
                                    <p><?php esc_html_e('Checkout Your Items List', 'flozen-theme'); ?></p>
                                </a>
                                <span class="pe-7s-angle-right"></span>
                            </div>
                            
                            <div class="title-thankyou">
                                <h1>03</h1>
                                <h4><?php esc_html_e('Order Complete', 'flozen-theme'); ?></h4>
                                <p><?php esc_html_e('Review And Submit Your Order', 'flozen-theme'); ?></p>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="checkout-breadcrumb">
                            <div class="title-cart">
                                <h1>01</h1>
                                <a href="#">
                                    <h4><?php esc_html_e('Shopping Cart', 'flozen-theme'); ?></h4>
                                    <p><?php esc_html_e('Manage Your Items List', 'flozen-theme'); ?></p>
                                </a>
                                <span class="pe-7s-angle-right"></span>
                            </div>
                            <div class="title-checkout">
                                <h1>02</h1>
                                <a href="#">
                                    <h4><?php esc_html_e('Checkout Details', 'flozen-theme'); ?></h4>
                                    <p><?php esc_html_e('Checkout Your Items List', 'flozen-theme'); ?></p>
                                </a>
                                <span class="pe-7s-angle-right"></span>
                            </div>
                            <div class="title-thankyou nasa-complete">
                                <h1>03</h1>
                                <h4><?php esc_html_e('Order Complete', 'flozen-theme'); ?></h4>
                                <p><?php esc_html_e('Review And Submit Your Order', 'flozen-theme'); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php else : ?> 
                    <div class="checkout-breadcrumb">
                        <div class="title-cart">
                            <span>01</span>
                            <p><?php esc_html_e('Shopping Cart', 'flozen-theme'); ?></p>
                        </div>
                        <div class="title-checkout">
                            <span>02</span>
                            <p><?php esc_html_e('Checkout Details', 'flozen-theme'); ?></p>
                        </div>
                        <div class="title-thankyou">
                            <span>03</span>
                            <p><?php esc_html_e('Order Complete', 'flozen-theme'); ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="content" class="large-12 columns">
            <?php
            if (shortcode_exists('woocommerce_checkout')):
                global $post;
                echo !isset($post->post_content) || !has_shortcode($post->post_content, 'woocommerce_checkout') ? do_shortcode('[woocommerce_checkout]') : '';
            endif;
            
            while (have_posts()) :
                the_post();
                the_content();
            endwhile;
            ?>
        </div>
    </div>
</div>

<?php
get_footer();
