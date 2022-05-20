<?php 
/*
** Mobile Layout 
*/


/*
** Check Header Mobile or Desktop
*/
function autusin_header_check(){ 	
	if( get_post_meta( get_the_ID(), 'page_header_hide', true ) && ( is_page() || is_single() ) ){
		return ;
	}
	$mobile_header = ( get_post_meta( get_the_ID(), 'page_mobile_header', true ) != '' && is_page() ) ? get_post_meta( get_the_ID(), 'page_mobile_header', true ) : sw_options( 'mobile_header_style' );
	$page_header   = ( get_post_meta( get_the_ID(), 'page_header_style', true ) != '' && ( is_page() || is_single() ) ) ? get_post_meta( get_the_ID(), 'page_header_style', true ) : sw_options('header_style');
	$header_style  = ( $page_header ) ? $page_header : 'style1';
	$elementor_enable = sw_options('enable_elementor');
	/* 
	** Display header or not 
	*/
	if( get_post_meta( get_the_ID(), 'page_header_hide', true ) ) :
		return ;
	endif;
	if( autusin_mobile_check() ):
		$header_mobile_elementor = sw_options('mobile_header');
		if( defined( 'ELEMENTOR_VERSION' ) && \Elementor\Plugin::$instance->documents->get( $header_mobile_elementor ) ){
			echo \Elementor\Plugin::$instance->frontend->get_builder_content( $header_mobile_elementor );
		}else{
			get_template_part( 'mlayouts/header', $mobile_header );
		}
	else: 
		if( !empty( $elementor_enable ) && $elementor_enable ){
			get_header(); 
		}else{
			get_template_part( 'templates/header', $page_header );
		}
	endif;
}
/*
** Check Content Page Mobile or Desktop
*/
function autusin_pagecontent_check(){
	$mobile_content = sw_options( 'mobile_content' );

	if( autusin_mobile_check() && $mobile_content != '' && is_front_page() ):
		if( defined( 'ELEMENTOR_VERSION' ) && \Elementor\Plugin::$instance->documents->get( $mobile_content ) ){
			echo \Elementor\Plugin::$instance->frontend->get_builder_content( $mobile_content );
		}else{
			echo sw_get_the_content_by_id( $mobile_content );
		}
	else: 
		the_content();
	endif;
}
/*
** Check Footer Mobile or Desktop
*/
function autusin_footer_check(){
	if( get_post_meta( get_the_ID(), 'page_footer_hide', true ) && ( is_page() || is_single() ) ){
		return ;
	}
	$mobile_footer = ( get_post_meta( get_the_ID(), 'page_mobile_footer', true ) != '' && ( is_page() || is_single() ) ) ? get_post_meta( get_the_ID(), 'page_mobile_footer', true ) : sw_options( 'mobile_footer_style' );
	$elementor_enable = sw_options('enable_elementor');
	if( autusin_mobile_check() && $mobile_footer != '' ):
		$footer_mobile_elementor = sw_options('mobile_footer');
		if( defined( 'ELEMENTOR_VERSION' ) && \Elementor\Plugin::$instance->documents->get( $footer_mobile_elementor ) ){
			echo \Elementor\Plugin::$instance->frontend->get_builder_content( $footer_mobile_elementor );
		}else{
			get_template_part( 'mlayouts/footer', $mobile_footer );
		}
	else: 
		if( !empty( $elementor_enable ) && $elementor_enable ){
			get_footer();
		}else{
			get_template_part( 'templates/footer' );
		}
	endif;
}



/*
** Check Product Listing Mobile or Desktop
*/
function autusin_product_listing_check(){
	if( autusin_mobile_check() ) :
		get_template_part('mlayouts/archive','product-mobile');
	else: 
		 wc_get_template( 'archive-product.php' );
	endif;
}

/*
** Check Product Listing Mobile or Desktop
*/
function autusin_blog_listing_check(){
	if( autusin_mobile_check()  ) :
		get_template_part('mlayouts/archive', 'mobile');
	else: 
		get_template_part( 'templates/content' );
	endif;		
}

/*
** Check Product Detail Mobile or Desktop
*/
function autusin_product_detail_check(){
	if( autusin_mobile_check()  ) :
		get_template_part('mlayouts/single','product');
	else: 
		 wc_get_template( 'single-product.php' );
	endif;
}

/*
** Check Product Detail Mobile or Desktop
*/
function autusin_content_detail_check(){
	if( autusin_mobile_check() ) :
		get_template_part('mlayouts/single','mobile');
	else: 
		 get_template_part('templates/content', 'single');
	endif;		
}

/*
** Product Meta
*/
if( !function_exists( 'autusin_mobile_check' ) ){
	function autusin_mobile_check(){
		global $sw_detect;
		if( class_exists( 'Mobile_Detect' ) ) {
			$sw_detect = new Mobile_Detect; 
		}
		$sw_demo   		  = get_option( 'sw_mdemo' );
		$mobile_check   = sw_options( 'mobile_enable' );
		
		if( $sw_demo == 1 ) :
			return true;
		endif;
		
		if( !empty( $sw_detect ) && $mobile_check && $sw_detect->isMobile() && !$sw_detect->isTablet() ) :
			return true;
		else: 
			return false;
		endif;
		return false;
	}
}

/*
** Number of post for a WordPress archive page
*/
function autusin_Per_category_basis($query){
    if ( ( $query->is_category ) ) {
        /* set post per page */
        if ( is_archive() && autusin_mobile_check() ){
            $query->set('posts_per_page', 3);
        }
    }
    return $query;

}
add_filter('pre_get_posts', 'autusin_Per_category_basis');

add_filter( 'elementor/theme/get_location_templates/template_id', 'sw_custom_template_include' );
function sw_custom_template_include( $theme_template_id ){
	if( ( is_post_type_archive( 'product' ) || is_singular( 'product' ) || is_tax( 'product_cat' ) || is_tax( 'product_brand' ) ) && autusin_mobile_check() ){
		$theme_template_id = 0;
	}
	return $theme_template_id;
}