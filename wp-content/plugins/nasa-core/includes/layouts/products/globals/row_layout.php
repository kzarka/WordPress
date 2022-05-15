<?php
$_delay = $count = 0;
$_delay_item = (isset($nasa_opt['delay_overlay']) && (int) $nasa_opt['delay_overlay']) ? (int) $nasa_opt['delay_overlay'] : 100;

$columns_number = isset($columns_number) ? $columns_number : 5;
$columns_tablet = isset($columns_number_tablet) ? $columns_number_tablet : 2;
$columns_small = isset($columns_number_small) ? $columns_number_small : 1;
$class_item = 'columns';

// desktop columns
switch ($columns_number):
    case '2':
        $class_item .= ' large-6';
        break;
    case '3':
        $class_item .= ' large-4';
        break;
    case '4':
        $class_item .= ' large-3';
        break;
    case '5':
    default:
        $columns_number = 5;
        $class_item .= ' nasa-large-5-col-1';
        break;
endswitch;

// Tablet columns
switch ($columns_tablet):
    case '1':
        $class_item .= ' medium-12';
        break;
    case '3':
        $class_item .= ' medium-4';
        break;
    case '2':
    default:
        $class_item .= ' medium-6';
        break;
endswitch;

// Small columns
switch ($columns_small):
    case '2':
        $class_item .= ' small-6';
        break;
    case '1':
    default:
        $class_item .= ' small-12';
        break;
endswitch;

$class_item .= (isset($classDeal3) && $classDeal3) ? ' nasa-less-right nasa-less-left' : '';

$start_row = !isset($start_row) ? '<div class="row nasa-row-child-clear-none mobile-padding-left-5 mobile-padding-right-5">' : '';
$end_row = !isset($end_row) ? '</div>' : '';

echo $start_row;

while ($loop->have_posts()) :
    $loop->the_post();
    
    echo '<div class="product-warp-item ' . esc_attr($class_item) . '">';
    wc_get_template(
        'content-product.php',
        array(
            '_delay' => $_delay,
            'wrapper' => 'div'
        )
    );
    
    echo '</div>';
    $_delay += $_delay_item;
    $count++;
    
endwhile;

echo $end_row;

wp_reset_postdata();
