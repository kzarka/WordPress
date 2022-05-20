<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */
 $autusin_product_class = ( sw_options( 'product_layout' ) == 'list' ) ? 'list' : 'grid';
?>
<ul  class="products-loop row <?php echo esc_attr(  $autusin_product_class ); ?> clearfix" >