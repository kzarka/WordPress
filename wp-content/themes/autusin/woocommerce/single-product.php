<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php get_header(); ?>

<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
	<div class="autusin_breadcrumbs">
		<div class="container">
			<?php
				if (!is_front_page() ) {
					if (function_exists('autusin_breadcrumb')){
						autusin_breadcrumb('<div class="breadcrumbs custom-font theme-clearfix">', '</div>');
					} 
				} 
			?>
		</div>
	</div>
<?php endif; ?>

<?php 
	$autusin_single_style = sw_options( 'product_single_style' );
	if( empty( $autusin_single_style ) || $autusin_single_style == 'default' ){ 
		get_template_part( 'woocommerce/content-single-product' );
	}
	else{
		get_template_part( 'woocommerce/content-single-product-' . $autusin_single_style );
	}
?>

<?php get_footer(); ?>
