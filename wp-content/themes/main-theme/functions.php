<?php
/**
 * Functions and definitions
 *
 */

/*
 * Let WordPress manage the document title.
 */
add_theme_support( 'title-tag' );

/*
 * Enable support for Post Thumbnails on posts and pages.
 */
add_theme_support( 'post-thumbnails' );

/*
 * Switch default core markup for search form, comment form, and comments
 * to output valid HTML5.
 */
add_theme_support( 'html5', array(
	'search-form',
	'comment-form',
	'comment-list',
	'gallery',
	'caption',
) );

/** 
 * Include primary navigation menu
 */
function untheme_nav_init() {
	register_nav_menus( array(
		'menu-1' => 'Primary Menu',
	) );
}
add_action( 'init', 'untheme_nav_init' );

/**
 * Register widget area.
 *
 */
function untheme_widgets_init() {
	register_sidebar( array(
		'name'          => 'Sidebar',
		'id'            => 'sidebar-1',
		'description'   => 'Add widgets',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'untheme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function untheme_scripts() {
	wp_enqueue_style( 'untheme-custom-style', get_template_directory_uri() . '/assets/css/menu.css' );
	wp_enqueue_style( 'untheme-custom-style12', get_template_directory_uri() . '/assets/css/blog.css' );
	wp_enqueue_style( 'untheme-custom-style2', get_template_directory_uri() . '/assets/css/custom.css' );
	wp_enqueue_style( 'untheme-custom-filter', get_template_directory_uri() . '/assets/css/filter.css' );
	wp_enqueue_style( 'untheme-style', get_template_directory_uri() . '/assets/css/plugin.min.css' );
	wp_enqueue_style( 'untheme-style2', get_template_directory_uri() . '/assets/css/theme.css' );
	wp_enqueue_style( 'untheme-abc-style', get_template_directory_uri() . '/assets/css/stylesheet.css' );
	wp_enqueue_style( 'untheme-abc-style2', get_template_directory_uri() . '/assets/css/font.css' );
	wp_enqueue_style( 'untheme-abc-style2233', get_template_directory_uri() . '/assets/css/slideshow.css' );


	wp_enqueue_script( 'untheme-scripts', get_template_directory_uri() . '/assets/js/scripts.js' );
	wp_enqueue_script( 'jquery-scripts-2', get_template_directory_uri() . '/assets/js/jquery.min.js' );
	wp_enqueue_script( 'jquery-scripts-22', get_template_directory_uri() . '/assets/js/jquery-ui.min.js' );
	wp_enqueue_script( 'jquery-scripts-2222', get_template_directory_uri() . '/assets/js/jquery.magnific-popup.min.js' );
	wp_enqueue_script( 'jquery-scripts-223', get_template_directory_uri() . '/assets/js/jquery.nivo.slider.js' );
	wp_enqueue_script( 'jquery-scripts-422', get_template_directory_uri() . '/assets/js/bootstrap.min.js' );
	wp_enqueue_script( 'jquery-scripts-1', get_template_directory_uri() . '/assets/js/custommenu.js' );
	wp_enqueue_script( 'jquery-scripts-3', get_template_directory_uri() . '/assets/js/mobile_menu.js' );
	wp_enqueue_script( 'jquery-scripts-4', get_template_directory_uri() . '/assets/js/common.js' );
}
add_action( 'wp_enqueue_scripts', 'untheme_scripts' );

function untheme_create_post_custom_post() {
	register_post_type('custom_post', 
		array(
		'labels' => array(
			'name' => __('Custom Post', 'untheme'),
		),
		'public'       => true,
		'hierarchical' => true,
		'supports'     => array(
			'title',
			'editor',
			'excerpt',
			'custom-fields',
			'thumbnail',
		), 
		'taxonomies'   => array(
				'post_tag',
				'category',
		) 
	));
}
add_action('init', 'untheme_create_post_custom_post'); // Add our work type

// autoload
require get_template_directory() . '/vendor/autoload.php';
new App\Loader;