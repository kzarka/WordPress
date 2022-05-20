<?php 
	if( get_option( 'sw_woocatalog_enable' ) === 'no' || !get_option( 'sw_woocatalog_enable' ) ){
		return;
	}
?>
<?php if ( class_exists( 'WooCommerce' ) && !sw_options( 'disable_cart' ) ) { ?>
<?php
	$autusin_page_header = ( get_post_meta( get_the_ID(), 'page_header_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_header_style', true ) : sw_options('header_style');
	if( $autusin_page_header == 'style5' || $autusin_page_header == 'style6' ){
		get_template_part( 'woocommerce/minicart-ajax-style3' ); 
	}elseif( $autusin_page_header == 'style3' || $autusin_page_header == 'style4' || $autusin_page_header == 'style7' || $autusin_page_header == 'style8' || $autusin_page_header == 'style10' || $autusin_page_header == 'style11' ){
		get_template_part( 'woocommerce/minicart-ajax-style2' ); 
	}else{
		get_template_part( 'woocommerce/minicart-ajax' ); 
	}	
?>
<?php } ?>