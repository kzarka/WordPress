<?php
$is_product = NASA_WOO_ACTIVED ? is_product() : false;
if ($is_product) :
    return;
endif;

$is_cart = true;
if (!NASA_WOO_ACTIVED || (isset($nasa_opt['disable-cart']) && $nasa_opt['disable-cart'])) {
    $is_cart = false;
}

if (NASA_WOO_ACTIVED) {
    $link_shop = wc_get_page_permalink('shop');
} else {
    $link_shop = home_url('/');
}
?>

<ul class="nasa-bottom-bar-icons">
    <li class="nasa-bot-item">
        <a class="nasa-bot-icons nasa-bot-icon-shop" href="<?php echo esc_url($link_shop); ?>" title="<?php echo esc_attr__('Shop', 'flozen-theme'); ?>">
            <i class="nasa-icon pe-7s-home"></i>
            <?php echo esc_html__('Shop', 'flozen-theme'); ?>
        </a>
    </li>
    
    <li class="nasa-bot-item nasa-bot-item-sidebar hidden-tag">
        <a class="nasa-bot-icons nasa-bot-icon-sidebar" href="javascript:void(0);" title="<?php echo esc_attr__('Filters', 'flozen-theme'); ?>">
            <i class="nasa-icon pe-7s-filter"></i>
            <?php echo esc_html__('Filters', 'flozen-theme'); ?>
        </a>
    </li>
    
    <li class="nasa-bot-item">
        <a class="nasa-bot-icons nasa-bot-icon-categories filter-cat-icon-mobile" href="javascript:void(0);" title="<?php echo esc_attr__('Categories', 'flozen-theme'); ?>">
            <i class="nasa-icon pe-7s-keypad"></i>
            <?php echo esc_html__('Categories', 'flozen-theme'); ?>
        </a>
    </li>
    
    <li class="nasa-bot-item nasa-bot-item-search hidden-tag">
        <a class="nasa-bot-icons nasa-bot-icon-search botbar-mobile-search" href="javascript:void(0);" title="<?php echo esc_attr__('Search', 'flozen-theme'); ?>">
            <i class="nasa-icon pe-7s-search"></i>
            <?php echo esc_html__('Search', 'flozen-theme'); ?>
        </a>
    </li>
    
    <?php
    /**
     * Cart bottom bar
     */
    if ($is_cart) :
        $icon_number = isset($nasa_opt['mini-cart-icon']) ? $nasa_opt['mini-cart-icon'] : '1';
        $icon_class = 'nasa-icon';
        switch ($icon_number) :
            case '2':
                $icon_class .= ' nasa-font-icon icon-nasa-cart-2';
                break;
            case '3':
                $icon_class .= ' nasa-font-icon icon-nasa-cart-4';
                break;
            case '4':
                $icon_class .= ' pe-7s-cart';
                break;
            case '5':
                $icon_class .= ' fa fa-shopping-cart';
                break;
            case '6':
                $icon_class .= ' fa fa-shopping-bag';
                break;
            case '7':
                $icon_class .= ' fa fa-shopping-basket';
                break;
            case '1':
            default:
                $icon_class .= ' nasa-font-icon icon-nasa-cart-3';
                break;
        endswitch; ?>
        <li class="nasa-bot-item">
            <a class="nasa-bot-icons nasa-bot-icon-cart botbar-cart-link" href="javascript:void(0);" title="<?php echo esc_attr__('Cart', 'flozen-theme'); ?>">
                <i class="<?php echo esc_attr($icon_class); ?>"></i>
                <?php echo esc_html__('Cart', 'flozen-theme'); ?>
            </a>
        </li>
    <?php endif; ?>
</ul>
