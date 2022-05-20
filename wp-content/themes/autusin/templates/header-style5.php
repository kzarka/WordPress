<?php
/* 
** Content Header
*/
$autusin_page_header = get_post_meta( get_the_ID(), 'page_header_style', true );
$autusin_colorset = sw_options('scheme');
$autusin_logo = sw_options('sitelogo');
$sticky_menu 		= sw_options( 'sticky_menu' );
$autusin_page_header  = ( get_post_meta( get_the_ID(), 'page_header_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_header_style', true ) : sw_options('header_style');
$autusin_menu_item 	= ( sw_options( 'menu_number_item' ) ) ? sw_options( 'menu_number_item' ) : 9;
$autusin_more_text 	= ( sw_options( 'menu_more_text' ) )	 ? sw_options( 'menu_more_text' )		: esc_html__( 'See More', 'autusin' );
$autusin_less_text 	= sw_options( 'menu_less_text' )			 ? sw_options( 'menu_less_text' )		: esc_html__( 'See Less', 'autusin' );
?>
<header id="header" class="header header-style5">
	<div class="header-top">
		<div class="container">
			<div class="row">
				<!-- Sidebar Top Menu -->
				<?php if (is_active_sidebar('header-right')) {?>
				<div class="left-header col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<?php dynamic_sidebar('header-right'); ?>
				</div>
				<?php }?>
				<!-- Sidebar Top Menu -->
				<?php if( class_exists( 'WooCommerce' ) ) : ?>	
					<div class="right-header2 col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<?php dynamic_sidebar('header-right4'); ?>
						<?php if (is_active_sidebar('header-right2')) {?>
						<div class="sw-autusin-account pull-right">
							<i class="fa fa-user" aria-hidden="true"></i><span><?php esc_html_e( 'My Account', 'autusin' ) ?></span>
							<div id="sidebar-top-right" class="sidebar-top-right">
								<?php dynamic_sidebar('header-right2'); ?>
							</div>						
						</div>
						<?php }?>
					</div>
				<?php endif; ?>
			</div>
		</div>		
	</div>
	<div class="header-mid">
		<div class="container">
			<div class="row">				
				<!-- Logo -->
				<div class="left-header col-lg-3 col-md-3 col-sm-4 col-xs-12">
					<div class="autusin-logo">
						<?php autusin_logo(); ?>
					</div>
				</div>
				<!-- Sidebar Right -->
				<?php if( !sw_options( 'disable_cart' ) ) : ?>
					<?php get_template_part( 'woocommerce/minicart-ajax-style3' ); ?>
				<?php endif; ?>
				<div class="search-cate search-code col-lg-6 col-md-6 col-sm-5 col-xs-12 pull-right">
					<?php if( is_active_sidebar( 'search' ) && class_exists( 'sw_woo_search_widget' ) ): ?>
						<?php dynamic_sidebar( 'search' ); ?>
					<?php else : ?>
						<div class="widget autusin_top non-margin">
							<div class="widget-inner">
								<?php get_template_part( 'widgets/sw_top/searchcate' ); ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="header-bottom">
		<div class="container">
			<div class="row">
				<!-- Primary navbar -->
				<?php if ( has_nav_menu('primary_menu') ) { ?>
				<div id="main-menu" class="main-menu clearfix col-lg-8 col-md-8 col-sm-8 col-xs-12">
					<nav id="primary-menu" class="primary-menu">
						<div class="mid-header clearfix">
							<div class="navbar-inner navbar-inverse">
								<?php
								$autusin_menu_class = 'nav nav-pills';
								if ( 'mega' == sw_options('menu_type') ){
									$autusin_menu_class .= ' nav-mega';
								} else $autusin_menu_class .= ' nav-css';
								?>
								<?php wp_nav_menu(array('theme_location' => 'primary_menu', 'menu_class' => $autusin_menu_class)); ?>
							</div>
						</div>
					</nav>
				</div>			
				<?php } ?>
				<!-- /Primary navbar -->
				<!-- Sidebar Top Menu -->
				<?php if (is_active_sidebar('mid-header2')) {?>
				<div class="right-header col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<?php dynamic_sidebar('mid-header2'); ?>
				</div>
				<?php }?>
			</div>
		</div>
	</div>
</header>