<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */
global $nasa_opt, $woocommerce_loop;

$data_columns_small = 1;
$data_columns_tablet = 2;
$products_per_row = 4;
if (isset($nasa_opt['products_per_row']) && (int) $nasa_opt['products_per_row']) {
    $products_per_row = (int) $nasa_opt['products_per_row'];
}

$nasa_change_view = !isset($nasa_opt['enable_change_view']) || $nasa_opt['enable_change_view'] ?
    true : false;

$type_view = 'grid';
if (
    isset($nasa_opt['products_type_view']) &&
    in_array($nasa_opt['products_type_view'], array('grid', 'list'))
) {
    $type_view = $nasa_opt['products_type_view'];
}

/**
 * Loop in Short code
 */
if(isset($woocommerce_loop['is_shortcode']) && !$woocommerce_loop['is_shortcode']) {
    $type_view = 'grid';
    $products_per_row = isset($woocommerce_loop['columns']) ? $woocommerce_loop['columns'] : $products_per_row;
}

/**
 * Columns for desktop
 */
switch ($products_per_row):
    case 3:
        $type_view .= ' large-block-grid-3';
        break;

    case 5:
        $type_view .= ' large-block-grid-5';
        break;

    case 4:
    default:
        $type_view .= ' large-block-grid-4';
        break;
endswitch;

/**
 * Columns for mobile
 */
$products_per_row_small = isset($nasa_opt['products_per_row_small']) && (int) $nasa_opt['products_per_row_small'] ? (int) $nasa_opt['products_per_row_small'] : 1;
switch ($products_per_row_small):
    case 2:
        $type_view .= ' small-block-grid-2';
        $data_columns_small = '2';
        break;
    case 1:
    default:
        $type_view .= ' small-block-grid-1';
        $data_columns_small = '1';
        break;
endswitch;

/**
 * Columns for tablet
 */
$products_per_row_tablet = isset($nasa_opt['products_per_row_tablet']) && (int) $nasa_opt['products_per_row_tablet'] ? (int) $nasa_opt['products_per_row_tablet'] : 2;
switch ($products_per_row_tablet):
    case 3:
        $type_view .= ' medium-block-grid-3';
        $data_columns_tablet = '3';
        break;
    case 4:
        $type_view .= ' medium-block-grid-4';
        $data_columns_tablet = '4';
        break;
    case 2:
    default:
        $type_view .= ' medium-block-grid-2';
        $data_columns_tablet = '2';
        break;
endswitch;
?>

<div class="row">
    <div class="large-12 columns nasa-content-page-products">
        <ul class="products <?php echo esc_attr($type_view); ?>" data-columns_small="<?php echo esc_attr($data_columns_small); ?>" data-columns_medium="<?php echo esc_attr($data_columns_tablet); ?>">