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

function getDataSlider($attr) {
	extract(shortcode_atts(array(
		'id' => 0,
	), $atts));
	$output = array();
	if ($id == 0) {
		// SHORTCODE 'id' PARAMETER PROVIDED IS INVALID
		$output = [];
	} else {
		$post_status = get_post_status($id);
		if ($post_status == 'publish') {
			$metadata = get_metadata('post', $id);
			$post_type = get_post_type($id);
		}
		if (($post_status != 'publish') || (count($metadata) == 0) || ($post_type != 'sa_slider')) {
			// SHORTCODE 'id' PARAMETER PROVIDED IS INVALID
			$output = ['trash' => true];
		} else {
			$slide_data = array();
			$slide_data['num_slides'] = $metadata['sa_num_slides'][0];
			$slide_data['shortcodes'] = $metadata['sa_shortcodes'][0];
			if ($slide_data['shortcodes'] == '1') {
				$slide_data['shortcodes'] = 'true';
			} else {
				$slide_data['shortcodes'] = 'false';
			}
			$slide_data['css_id'] = $metadata['sa_css_id'][0];
			for ($i = 1; $i <= $slide_data['num_slides']; $i++) {
				$slide_data["slide".$i."_num"] = $i;
				// apply 'the_content' filter to slide content to process any shortcodes
				if ($slide_data['shortcodes'] == 'true') {
					$slide_data["slide".$i."_content"] = do_shortcode($metadata["sa_slide".$i."_content"][0]);
				} else {
					$slide_data["slide".$i."_content"] = $metadata["sa_slide".$i."_content"][0];
				}
				$slide_image_data = '';
				if (isset($metadata["sa_slide".$i."_image_data"])) {
					$slide_image_data = $metadata["sa_slide".$i."_image_data"][0];
				}
				if (isset($slide_image_data) && ($slide_image_data != '')) {
					$data_arr = explode("~", $slide_image_data);
					$slide_data["slide".$i."_image_id"] = $data_arr[0];
					$slide_data["slide".$i."_image_pos"] = $data_arr[1];
					$slide_data["slide".$i."_image_size"] = $data_arr[2];
					$slide_data["slide".$i."_image_repeat"] = $data_arr[3];
					$slide_data["slide".$i."_image_color"] = $data_arr[4];
				} else {
					$slide_data["slide".$i."_image_id"] = $metadata["sa_slide".$i."_image_id"][0];
					$slide_data["slide".$i."_image_pos"] = $metadata["sa_slide".$i."_image_pos"][0];
					$slide_data["slide".$i."_image_size"] = $metadata["sa_slide".$i."_image_size"][0];
					$slide_data["slide".$i."_image_repeat"] = $metadata["sa_slide".$i."_image_repeat"][0];
					$slide_data["slide".$i."_image_color"] = $metadata["sa_slide".$i."_image_color"][0];
				}
				$slide_data["slide".$i."_link_url"] = $metadata["sa_slide".$i."_link_url"][0];
				$slide_data["slide".$i."_link_target"] = $metadata["sa_slide".$i."_link_target"][0];
				if ($slide_data["slide".$i."_link_target"] == '') {
					$slide_data["slide".$i."_link_target"] = '_self';
				}
				if ($sa_pro_version) {
					// ### PRO VERSION - GET POPUP DATA ###
					$slide_data["slide".$i."_popup_type"] = "NONE";
					$slide_data["slide".$i."_popup_imageid"] = "";
					$slide_data["slide".$i."_popup_imagetitle"] = "";
					$slide_data["slide".$i."_popup_video_id"] = "";
					$slide_data["slide".$i."_popup_video_type"] = "";
					$slide_data["slide".$i."_popup_html"] = "";
					$slide_data["slide".$i."_popup_shortcode"] = "";
					$slide_data["slide".$i."_popup_bgcol"] = "#ffffff";
					$slide_data["slide".$i."_popup_width"] = "600";
					if (isset($metadata["sa_slide".$i."_popup_type"])) {
						$slide_data["slide".$i."_popup_type"] = $metadata["sa_slide".$i."_popup_type"][0];
					}
					if (isset($metadata["sa_slide".$i."_popup_imageid"])) {
						$slide_data["slide".$i."_popup_imageid"] = $metadata["sa_slide".$i."_popup_imageid"][0];
					}
					if (isset($metadata["sa_slide".$i."_popup_imagetitle"])) {
						$slide_data["slide".$i."_popup_imagetitle"] = $metadata["sa_slide".$i."_popup_imagetitle"][0];
					}
					$slide_data["slide".$i."_popup_image"] = '';
					$slide_data["slide".$i."_popup_background"] = 'no';
					if ($slide_data["slide".$i."_popup_type"] == 'IMAGE') {
						if (($slide_data["slide".$i."_popup_imageid"] != '') && ($slide_data["slide".$i."_popup_imageid"] != 0)) {
							$popup_full_images = wp_get_attachment_image_src($slide_data["slide".$i."_popup_imageid"], 'full');
							$slide_data["slide".$i."_popup_image"] = $popup_full_images[0];
							$slide_data["slide".$i."_popup_background"] = $metadata["sa_slide".$i."_popup_background"][0];
							if ($slide_data["slide".$i."_popup_background"] == '') {
								$slide_data["slide".$i."_popup_background"] = 'no';
							}
						}
					}
					if (isset($metadata["sa_slide".$i."_popup_video_id"])) {
						$slide_data["slide".$i."_popup_video_id"] = $metadata["sa_slide".$i."_popup_video_id"][0];
					}
					if (isset($metadata["sa_slide".$i."_popup_video_type"])) {
						$slide_data["slide".$i."_popup_video_type"] = $metadata["sa_slide".$i."_popup_video_type"][0];
					}
					if (isset($metadata["sa_slide".$i."_popup_html"])) {
						$slide_data["slide".$i."_popup_html"] = $metadata["sa_slide".$i."_popup_html"][0];
					}
					if (isset($metadata["sa_slide".$i."_popup_shortcode"])) {
						$slide_data["slide".$i."_popup_shortcode"] = $metadata["sa_slide".$i."_popup_shortcode"][0];
					}
					if (isset($metadata["sa_slide".$i."_popup_bgcol"])) {
						$slide_data["slide".$i."_popup_bgcol"] = $metadata["sa_slide".$i."_popup_bgcol"][0];
					}
					if (isset($metadata["sa_slide".$i."_popup_width"])) {
						$slide_data["slide".$i."_popup_width"] = $metadata["sa_slide".$i."_popup_width"][0];
					}
					if ($slide_data["slide".$i."_popup_type"] == 'HTML') {
						$slide_data["slide".$i."_popup_css_id"] = $slide_data['css_id']."_popup".$i;
					} else {
						$slide_data["slide".$i."_popup_css_id"] = '';
					}
				}
			}

			$output['popup_full_images'] = $popup_full_images;
		}

	}
	return $output;
}