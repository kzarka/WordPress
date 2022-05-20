<?php 
/* 
** Content Header
*/
$autusin_page_header = get_post_meta( get_the_ID(), 'page_header_style', true );
$autusin_colorset  	= sw_options('scheme');
$autusin_logo 				= sw_options('sitelogo');
$sticky_menu 			= sw_options( 'sticky_menu' );
$autusin_page_header = ( get_post_meta( get_the_ID(), 'page_header_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_header_style', true ) : sw_options('header_style'); 
$autusin_menu_item 	= ( sw_options( 'menu_number_item' ) ) ? sw_options( 'menu_number_item' ) : 9;
$autusin_more_text 	= ( sw_options( 'menu_more_text' ) )	 ? sw_options( 'menu_more_text' )		: esc_html__( 'See More', 'autusin' );
$autusin_less_text 	= ( sw_options( 'menu_less_text' ) )	 ? sw_options( 'menu_less_text' )		: esc_html__( 'See Less', 'autusin' );
?>
<header id="header" class="header header-style1">
	<div class="header-mid">
		<div class="container">
			<div class="row">
				<!-- Logo -->
				<div class="mid-header col-lg-2 col-md-3 col-sm-3 col-xs-12 pull-left">
					<div class="autusin-logo">
						<?php autusin_logo(); ?>
					</div>
				</div>
				<!-- Primary navbar -->
				<?php if ( has_nav_menu('primary_menu') ) { ?>
				<div id="main-menu" class="main-menu pull-left clearfix">
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
				<!-- Sidebar Right -->
				<?php if( !sw_options( 'disable_cart' ) ) : ?>
					<?php get_template_part( 'woocommerce/minicart-ajax' ); ?>
				<?php endif; ?>
				<?php if (is_active_sidebar('bottom-header')) {?>
				<div class="bottom-header pull-right">
					<?php dynamic_sidebar('bottom-header'); ?>
				</div>
				<?php }?>
			</div>
		</div>
	</div>
</header>