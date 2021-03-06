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
<header id="header" class="header header-style2">
	<div class="header-top">
		<div class="container">
			<div class="row">
				<!-- Sidebar Top Menu -->
				<?php if (is_active_sidebar('header-right')) {?>
				<div class="left-header col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<?php dynamic_sidebar('header-right'); ?>
				</div>
				<?php }?>
				<!-- Sidebar Top Menu -->
				<?php if (is_active_sidebar('mid-header')) {?>
				<div class="mid-header col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<?php dynamic_sidebar('mid-header'); ?>
				</div>
				<?php }?>
				<!-- Sidebar Top Menu -->
				<?php if (is_active_sidebar('header-right2')) {?>
				<div class="right-header2 pull-right">
					<div class="sw-autusin-account pull-right">
						<i class="fa fa-user" aria-hidden="true"></i><span><?php esc_html_e( 'My Account', 'autusin' ) ?></span>	
						<div id="sidebar-top-right" class="sidebar-top-right">
							<?php dynamic_sidebar('header-right2'); ?>
						</div>						
					</div>
				</div>
				<?php }?>
				<?php if( !sw_options( 'disable_search' ) ) : ?>
				<div class="search-cate search-code pull-right">
					<div class="icon-search">
						<i class="fa fa-search"></i><span><?php esc_html_e( 'Search', 'autusin' ) ?></span>	
					</div>
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
				<?php endif; ?>
			</div>
		</div>		
	</div>
	<div class="header-mid">
		<div class="container">
			<!-- Logo -->
			<div class="top-header col-lg-3 col-md-3 col-sm-3 col-xs-12 pull-left">
				<div class="autusin-logo">
					<?php autusin_logo(); ?>
				</div>
			</div>
			<!-- Primary navbar -->
			<?php if ( has_nav_menu('primary_menu') ) { ?>
			<div id="main-menu" class="main-menu clearfix pull-left">
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
			<?php if( !sw_options( 'disable_cart' ) ) : ?>
				<?php get_template_part( 'woocommerce/minicart-ajax' ); ?>
			<?php endif; ?>
		</div>
	</div>
</header>