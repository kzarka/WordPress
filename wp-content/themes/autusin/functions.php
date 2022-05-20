<?php 
/**
 * Variables
 */
use ElementorPro\Modules\ThemeBuilder\Module;
use ElementorPro\Modules\ThemeBuilder\Classes\Theme_Support;

require_once ( get_template_directory().'/lib/plugin-requirement.php' );			// Custom functions
if( class_exists( 'OCDI_Plugin' ) ) :
	require_once ( get_template_directory().'/lib/import/sw-import.php' );
endif;

//require_once ( get_template_directory().'/lib/activation.php' );	// Custom functions
require_once ( get_template_directory().'/lib/defines.php' );
require_once ( get_template_directory().'/lib/mobile-layout.php' );
require_once ( get_template_directory().'/lib/classes.php' );		// Utility functions
require_once ( get_template_directory().'/lib/utils.php' );			// Utility functions
require_once ( get_template_directory().'/lib/init.php' );			// Initial theme setup and constants
require_once ( get_template_directory().'/lib/cleanup.php' );		// Cleanup
require_once ( get_template_directory().'/lib/nav.php' );			// Custom nav modifications
require_once ( get_template_directory().'/lib/widgets.php' );		// Sidebars and widgets
require_once ( get_template_directory().'/lib/scripts.php' );		// Scripts and stylesheets
if( class_exists( 'WooCommerce' ) ){
	require_once ( get_template_directory().'/lib/plugins/currency-converter/currency-converter.php' ); // currency converter
	require_once ( get_template_directory().'/lib/woocommerce-hook.php' );	// Utility functions
	
	if( class_exists( 'WC_Vendors' ) ) :
		require_once ( get_template_directory().'/lib/wc-vendor-hook.php' );			/** WC Vendor **/
	endif;
	
	if( class_exists( 'WeDevs_Dokan' ) ) :
		require_once ( get_template_directory().'/lib/dokan-vendor-hook.php' );			/** Dokan Vendor **/
		remove_action( 'elementor/widgets/wordpress/widget_args', 'dokan_depricated_elementor_store_widgets', 10, 2 );
	endif;
	
	if( class_exists( 'WCMp' ) ) :
		require_once ( get_template_directory().'/lib/wc-marketplace-hook.php' );			/** WC MarketPlace Vendor **/
	endif;
}

add_filter( 'autusin_widget_register', 'autusin_add_custom_widgets' );
function autusin_add_custom_widgets( $autusin_widget_areas ){
	if( class_exists( 'sw_woo_search_widget' ) ){
		$autusin_widget_areas[] = array(
			'name' => esc_html__('Widget Search', 'autusin'),
			'id'   => 'search',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
		);
		$autusin_widget_areas[] = array(
			'name' => esc_html__('Widget Mobile Top', 'autusin'),
			'id'   => 'top-mobile',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
		);
	}
	return $autusin_widget_areas;
}

add_action( 'elementor/editor/after_enqueue_styles', 'sw_custom_style_elementor_backend' );
function sw_custom_style_elementor_backend(){
	$scheme = sw_options('scheme');
	wp_enqueue_style('sw-elementor-editor', get_template_directory_uri() . '/css/sw-elementor-editor.css', array(), null);	
	$mobile_css = get_template_directory_uri() . '/css/mobile/mobile-default.css';
	if ( $scheme ){
		$mobile_css = get_template_directory_uri() . '/css/mobile-'.$scheme.'.css';
	} 
	wp_enqueue_style('autusin-mobile', $mobile_css, array(), null);
}

add_action( 'elementor/theme/register_locations', 'autusin_location_action' );
function autusin_location_action( $location_manager ){
	$core_locations = $location_manager->get_core_locations();
	$overwrite_header_location = false;
	$overwrite_footer_location = false;

	foreach ( $core_locations as $location => $settings ) {
		if ( ! $location_manager->get_location( $location ) ) {
			if ( 'header' === $location ) {
				$overwrite_header_location = true;
			} elseif ( 'footer' === $location ) {
				$overwrite_footer_location = true;
			}
			$location_manager->register_core_location( $location, [
				'overwrite' => true,
			] );
		}
	}
	if ( $overwrite_header_location || $overwrite_footer_location ) {
		if( !autusin_mobile_check() ){
			$theme_builder_module = Module::instance();

			$conditions_manager = $theme_builder_module->get_conditions_manager();

			$headers = $conditions_manager->get_documents_for_location( 'header' );
			$footers = $conditions_manager->get_documents_for_location( 'footer' );
			
			$support = new Theme_Support();
			
			if ( ! empty( $headers ) || ! empty( $footers ) ) {
				add_action( 'get_header', [ $support, 'get_header' ] );
				add_action( 'get_footer', [ $support, 'get_footer' ] );
			}
		}
	}
	
}
remove_action( 'wp_body_open', 'wp_admin_bar_render', 0 );

/**
* Support SVG
**/
function certior_businessplus_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'certior_businessplus_mime_types');
add_filter('mime_types', 'certior_businessplus_mime_types');

function example_theme_support() {
    remove_theme_support( 'widgets-block-editor' );
}
add_action( 'after_setup_theme', 'example_theme_support' );