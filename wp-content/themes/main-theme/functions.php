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

function getDataSlider($id) {
	$sa_pro_version = esc_attr(get_option('sap_valid_license'));
	wp_enqueue_script('jquery');
	wp_register_script('owl_carousel_js', SA_PLUGIN_PATH.'owl-carousel/owl.carousel.min.js', array('jquery'), '2.2.1', true);
	wp_enqueue_script('owl_carousel_js');
	wp_register_style('owl_carousel_css', SA_PLUGIN_PATH.'owl-carousel/owl.carousel.css', array(), '2.2.1.1', 'all');
	wp_enqueue_style('owl_carousel_css');
	wp_register_style('owl_theme_css', SA_PLUGIN_PATH.'owl-carousel/sa-owl-theme.css', array(), '2.0', 'all');
	wp_enqueue_style('owl_theme_css');
	wp_register_style('owl_animate_css', SA_PLUGIN_PATH.'owl-carousel/animate.min.css', array(), '2.0', 'all');
	wp_enqueue_style('owl_animate_css');
	wp_register_script('mousewheel_js', SA_PLUGIN_PATH.'js/jquery.mousewheel.min.js', array('jquery'), '3.1.13', true);
	wp_enqueue_script('mousewheel_js');
	if ($sa_pro_version) {
		// JAVASCRIPT/CSS FOR MAGNIFIC POPUP
		wp_register_script('magnific-popup_js', SA_PLUGIN_PATH.'magnific-popup/jquery.magnific-popup.min.js', array('jquery'), '1.1.0', true);
		wp_enqueue_script('magnific-popup_js');
		wp_register_style('magnific-popup_css', SA_PLUGIN_PATH.'magnific-popup/magnific-popup.css', array(), '1.1.0', 'all');
		wp_enqueue_style('magnific-popup_css');
		wp_register_script('owl_thumbs_js', SA_PLUGIN_PATH.'owl-carousel/owl.carousel2.thumbs.min.js', array('jquery'), '0.1.8', true);
		wp_enqueue_script('owl_thumbs_js');
	}

	// EXTRACT SHORTCODE ATTRIBUTES
	$data = [];
	$data['imgs'] = [];
	$output = '';
	if ($id == 0) {
		// SHORTCODE 'id' PARAMETER PROVIDED IS INVALID
		$output .= "<div id='sa_invalid_postid'>Slide Anything shortcode error: A valid ID has not been provided</div>\n";
	} else {
		$post_status = get_post_status($id);
		if ($post_status == 'publish') {
			$metadata = get_metadata('post', $id);
			$post_type = get_post_type($id);
		}
		if (($post_status != 'publish') || (count($metadata) == 0) || ($post_type != 'sa_slider')) {
			// SHORTCODE 'id' PARAMETER PROVIDED IS INVALID
			$output .= "<div id='sa_invalid_postid'>Slide Anything shortcode error: A valid ID has not been provided</div>\n";
		} else {
			// ### VALID 'id' PROVIDED - PROCESS SHORTCODE ###
			// GET SLIDE DATA FROM DATABASE AND SAVE IN ARRAY
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

			$slide_data['slide_duration'] = floatval($metadata['sa_slide_duration'][0]) * 1000;
			$slide_data['slide_transition'] = floatval($metadata['sa_slide_transition'][0]) * 1000;
			if (isset($metadata['sa_slide_by'][0]) && ($metadata['sa_slide_by'][0] != '')) {
				$slide_data['slide_by'] = $metadata['sa_slide_by'][0];
				if ($slide_data['slide_by'] == '0') {
					$slide_data['slide_by'] = 'page';
				}
			} else {
				$slide_data['slide_by'] = 1;
			}
			$slide_data['loop_slider'] = $metadata['sa_loop_slider'][0];
			if ($slide_data['loop_slider'] == '1') {
				$slide_data['loop_slider'] = 'true';
			} else {
				$slide_data['loop_slider'] = 'false';
			}
			$slide_data['stop_hover'] = $metadata['sa_stop_hover'][0];
			if ($slide_data['stop_hover'] == '1') {
				$slide_data['stop_hover'] = 'true';
			} else {
				$slide_data['stop_hover'] = 'false';
			}
			$slide_data['random_order'] = $metadata['sa_random_order'][0];
			if ($slide_data['random_order'] == '1') {
				$slide_data['random_order'] = 'true';
			} else {
				$slide_data['random_order'] = 'false';
			}
			$slide_data['reverse_order'] = $metadata['sa_reverse_order'][0];
			if ($slide_data['reverse_order'] == '1') {
				$slide_data['reverse_order'] = 'true';
			} else {
				$slide_data['reverse_order'] = 'false';
			}
			$slide_data['nav_arrows'] = $metadata['sa_nav_arrows'][0];
			if ($slide_data['nav_arrows'] == '1') {
				$slide_data['nav_arrows'] = 'true';
			} else {
				$slide_data['nav_arrows'] = 'false';
			}
			$slide_data['pagination'] = $metadata['sa_pagination'][0];
			if ($slide_data['pagination'] == '1') {
				$slide_data['pagination'] = 'true';
			} else {
				$slide_data['pagination'] = 'false';
			}
			$slide_data['mouse_drag'] = $metadata['sa_mouse_drag'][0];
			if ($slide_data['mouse_drag'] == '1') {
				$slide_data['mouse_drag'] = 'true';
			} else {
				$slide_data['mouse_drag'] = 'false';
			}
			$slide_data['touch_drag'] = $metadata['sa_touch_drag'][0];
			if ($slide_data['touch_drag'] == '1') {
				$slide_data['touch_drag'] = 'true';
			} else {
				$slide_data['touch_drag'] = 'false';
			}	
			if (isset($metadata['sa_mousewheel'])) {
				$slide_data['mousewheel'] = $metadata['sa_mousewheel'][0];
				if ($slide_data['mousewheel'] == '1') {
					$slide_data['mousewheel'] = 'true';
				} else {
					$slide_data['mousewheel'] = 'false';
				}
			} else {
				$slide_data['mousewheel'] = 'false';
			}
			if (isset($metadata['sa_click_advance'])) {
				$slide_data['click_advance'] = $metadata['sa_click_advance'][0];
				if ($slide_data['click_advance'] == '1') {
					$slide_data['click_advance'] = 'true';
				} else {
					$slide_data['click_advance'] = 'false';
				}
			} else {
				$slide_data['click_advance'] = 'false';
			}
			if (isset($metadata['sa_auto_height'])) {
				$slide_data['auto_height'] = $metadata['sa_auto_height'][0];
				if ($slide_data['auto_height'] == '1') {
					$slide_data['auto_height'] = 'true';
				} else {
					$slide_data['auto_height'] = 'false';
				}
			} else {
				$slide_data['auto_height'] = 'false';
			}
			if (($metadata['sa_slide_min_height_perc'][0] == '0') || ($metadata['sa_slide_min_height_perc'][0] == '0px')) {
				$slide_data['vert_center'] = 'false';
			} else {
				if (isset($metadata['sa_vert_center'])) {
					$slide_data['vert_center'] = $metadata['sa_vert_center'][0];
					if ($slide_data['vert_center'] == '1') {
						$slide_data['vert_center'] = 'true';
					} else {
						$slide_data['vert_center'] = 'false';
					}
				} else {
					$slide_data['vert_center'] = 'false';
				}
			}
			$slide_data['items_width1'] = $metadata['sa_items_width1'][0];
			$slide_data['items_width2'] = $metadata['sa_items_width2'][0];
			$slide_data['items_width3'] = $metadata['sa_items_width3'][0];
			$slide_data['items_width4'] = $metadata['sa_items_width4'][0];
			$slide_data['items_width5'] = $metadata['sa_items_width5'][0];
			$slide_data['items_width6'] = $metadata['sa_items_width6'][0];
			if ($slide_data['items_width6'] == '') {
				$slide_data['items_width6'] = $slide_data['items_width5'];
			}
			$slide_data['transition'] = $metadata['sa_transition'][0];
			$slide_data['background_color'] = $metadata['sa_background_color'][0];
			$slide_data['border_width'] = $metadata['sa_border_width'][0];
			$slide_data['border_color'] = $metadata['sa_border_color'][0];
			$slide_data['border_radius'] = $metadata['sa_border_radius'][0];
			$slide_data['wrapper_padd_top'] = $metadata['sa_wrapper_padd_top'][0];
			$slide_data['wrapper_padd_right'] = $metadata['sa_wrapper_padd_right'][0];
			$slide_data['wrapper_padd_bottom'] = $metadata['sa_wrapper_padd_bottom'][0];
			$slide_data['wrapper_padd_left'] = $metadata['sa_wrapper_padd_left'][0];
			$slide_data['slide_min_height_perc'] = $metadata['sa_slide_min_height_perc'][0];
			$slide_data['slide_padding_tb'] = $metadata['sa_slide_padding_tb'][0];
			$slide_data['slide_padding_lr'] = $metadata['sa_slide_padding_lr'][0];
			$slide_data['slide_margin_lr'] = $metadata['sa_slide_margin_lr'][0];
			$slide_data['slide_icons_location'] = $metadata['sa_slide_icons_location'][0];
			$slide_data['autohide_arrows'] = $metadata['sa_autohide_arrows'][0];
			if ($slide_data['autohide_arrows'] == '1') {
				$slide_data['autohide_arrows'] = 'true';
			} else {
				$slide_data['autohide_arrows'] = 'false';
			}
			$slide_data['dot_per_slide'] = '0';
			if (isset($metadata['sa_dot_per_slide'])) {
				$slide_data['dot_per_slide'] = $metadata['sa_dot_per_slide'][0];
				if ($slide_data['dot_per_slide'] != '1') {
					$slide_data['dot_per_slide'] = '0';
				}
			} else {
				$slide_data['dot_per_slide'] = '0';
			}
			$slide_data['slide_icons_visible'] = $metadata['sa_slide_icons_visible'][0];
			if ($slide_data['slide_icons_visible'] == '1') {
				$slide_data['slide_icons_visible'] = 'true';
			} else {
				$slide_data['slide_icons_visible'] = 'false';
			}
			$slide_data['slide_icons_color'] = $metadata['sa_slide_icons_color'][0];
			if ($slide_data['slide_icons_color'] != 'black') {
				$slide_data['slide_icons_color'] = 'white';
			}
			if (isset($metadata['sa_slide_icons_fullslide'][0]) &&
				 ($metadata['sa_slide_icons_fullslide'][0] == 1)) {
				$slide_data['slide_icons_fullslide'] = '1';
			} else {
				$slide_data['slide_icons_fullslide'] = '0';
			}
			// FETCH OTHER SETTINGS POST META
			$other_settings = '';
			if (isset($metadata['sa_other_settings'])) {
				$other_settings = $metadata['sa_other_settings'][0];
				if (isset($other_settings) && ($other_settings != '')) {
					$other_settings_arr = explode("|", $other_settings);
				}
			}
			// setting 1 - sa_window_onload
			$slide_data['sa_window_onload'] = '0';
			if (isset($other_settings_arr) && ($other_settings_arr[0] != '')) {
				$slide_data['sa_window_onload'] = $other_settings_arr[0];
			} else {
				if (isset($metadata['sa_window_onload'])) {
					$slide_data['sa_window_onload'] = $metadata['sa_window_onload'][0];
					if ($slide_data['sa_window_onload'] != '1') {
						$slide_data['sa_window_onload'] = '0';
					}
				}
			}
			// setting 2 - sa_strip_javascript
			$slide_data['strip_javascript'] = '0';
			if (isset($other_settings_arr) && ($other_settings_arr[1] != '')) {
				$slide_data['strip_javascript'] = $other_settings_arr[1];
			} else {
				if (isset($metadata['sa_strip_javascript'])) {
					$slide_data['strip_javascript'] = $metadata['sa_strip_javascript'][0];
					if ($slide_data['strip_javascript'] != '1') {
						$slide_data['strip_javascript'] = '0';
					}
				}
			}
			// setting 3 - sa_lazy_load_images
			$slide_data['lazy_load_images'] = '0';
			if (isset($other_settings_arr) && ($other_settings_arr[2] != '')) {
				$slide_data['lazy_load_images'] = $other_settings_arr[2];
			} else {
				if (isset($metadata['sa_lazy_load_images'])) {
					$slide_data['lazy_load_images'] = $metadata['sa_lazy_load_images'][0];
					if ($slide_data['lazy_load_images'] != '1') {
						$slide_data['lazy_load_images'] = '0';
					}
				}
			}
			// setting 4 - sa_ulli_containers
			$slide_data['ulli_containers'] = '0';
			if (isset($other_settings_arr) && ($other_settings_arr[3] != '')) {
				$slide_data['ulli_containers'] = $other_settings_arr[3];
			} else {
				if (isset($metadata['sa_ulli_containers'])) {
					$slide_data['ulli_containers'] = $metadata['sa_ulli_containers'][0];
					if ($slide_data['ulli_containers'] != '1') {
						$slide_data['ulli_containers'] = '0';
					}
				}
			}
			// setting 5 - sa_rtl_slider
			$slide_data['rtl_slider'] = '0';
			if (isset($other_settings_arr) && ($other_settings_arr[4] != '')) {
				$slide_data['rtl_slider'] = $other_settings_arr[4];
			}
			// setting 7 - bg_image_size
			$slide_data['bg_image_size'] = 'full';
			if (isset($other_settings_arr) && (count($other_settings_arr) > 6)) {
				if ($other_settings_arr[6] != '') {
					$slide_data['bg_image_size'] = $other_settings_arr[6];
				}
			}
			// setting 8 - disable_slide_ids
			$slide_data['disable_slide_ids'] = '0';
			if (isset($other_settings_arr) && (count($other_settings_arr) > 7)) {
				if ($other_settings_arr[7] != '') {
					$slide_data['disable_slide_ids'] = $other_settings_arr[7];
				}
			}
			// Start Position
			$slide_data['start_pos'] = 0;
			if (isset($metadata['sa_start_pos'])) {
				$slide_data['start_pos'] = $metadata['sa_start_pos'][0];
				if ($slide_data['start_pos'] != '') {
					$slide_data['start_pos'] = abs(intval($slide_data['start_pos']));
					if ($slide_data['start_pos'] > 0) {
						$slide_data['start_pos'] = $slide_data['start_pos'] - 1;
					}
				}
			}
			
			// hero slider and slider thumbnails
			$slide_data['hero_slider'] = '0';
			$slide_data['thumbs_active'] = '0';
			if ($sa_pro_version) {
				if (isset($metadata['sa_hero_slider'])) {
					$slide_data['hero_slider'] = $metadata['sa_hero_slider'][0];
					if ($slide_data['hero_slider'] != '1') {
						$slide_data['hero_slider'] = '0';
					}
				} else {
					$slide_data['hero_slider'] = '0';
				}
				if (isset($metadata['sa_thumbs_active'])) {
					$slide_data['thumbs_active'] = $metadata['sa_thumbs_active'][0];
					if ($slide_data['thumbs_active'] != '1') {
						$slide_data['thumbs_active'] = '0';
					}
				} else {
					$slide_data['thumbs_active'] = '0';
				}
				if (isset($metadata['sa_thumbs_location'])) {
					$slide_data['thumbs_location'] = $metadata['sa_thumbs_location'][0];
				} else {
					$slide_data['thumbs_location'] = 'inside_bottom';
				}
				if (isset($metadata['sa_thumbs_image_size'])) {
					$slide_data['thumbs_image_size'] = $metadata['sa_thumbs_image_size'][0];
				} else {
					$slide_data['thumbs_image_size'] = 'thumbnail';
				}
				if (isset($metadata['sa_thumbs_padding'])) {
					$slide_data['thumbs_padding'] = $metadata['sa_thumbs_padding'][0];
				} else {
					$slide_data['thumbs_padding'] = '3';
				}
				if (isset($metadata['sa_thumbs_width'])) {
					$slide_data['thumbs_width'] = $metadata['sa_thumbs_width'][0];
				} else {
					$slide_data['thumbs_width'] = '150';
				}
				if (isset($metadata['sa_thumbs_height'])) {
					$slide_data['thumbs_height'] = $metadata['sa_thumbs_height'][0];
				} else {
					$slide_data['thumbs_height'] = '85';
				}
				if (isset($metadata['sa_thumbs_opacity'])) {
					$slide_data['thumbs_opacity'] = $metadata['sa_thumbs_opacity'][0];
				} else {
					$slide_data['thumbs_opacity'] = '50';
				}
				if (isset($metadata['sa_thumbs_border_width'])) {
					$slide_data['thumbs_border_width'] = $metadata['sa_thumbs_border_width'][0];
				} else {
					$slide_data['thumbs_border_width'] = '0';
				}
				if (isset($metadata['sa_thumbs_border_color'])) {
					$slide_data['thumbs_border_color'] = $metadata['sa_thumbs_border_color'][0];
				} else {
					$slide_data['thumbs_border_color'] = '#ffffff';
				}
				if (isset($metadata['sa_thumbs_resp_tablet'])) {
					$slide_data['thumbs_resp_tablet'] = $metadata['sa_thumbs_resp_tablet'][0];
				} else {
					$slide_data['thumbs_resp_tablet'] = '75';
				}
				if (isset($metadata['sa_thumbs_resp_mobile'])) {
					$slide_data['thumbs_resp_mobile'] = $metadata['sa_thumbs_resp_mobile'][0];
				} else {
					$slide_data['thumbs_resp_mobile'] = '50';
				}
			}
			// showcase carousel
			$slide_data['showcase_slider'] = '0';
			if ($sa_pro_version) {
				if (isset($metadata['sa_showcase_slider'])) {
					$slide_data['showcase_slider'] = $metadata['sa_showcase_slider'][0];
					if ($slide_data['showcase_slider'] != '1') {
						$slide_data['showcase_slider'] = '0';
					}
				} else {
					$slide_data['showcase_slider'] = '0';
				}
				if (isset($metadata['sa_showcase_width'])) {
					$slide_data['showcase_width'] = $metadata['sa_showcase_width'][0];
				} else {
					$slide_data['showcase_width'] = '120';
				}
				if (isset($metadata['sa_showcase_tablet'])) {
					$slide_data['showcase_tablet'] = $metadata['sa_showcase_tablet'][0];
					if ($slide_data['showcase_tablet'] != '1') {
						$slide_data['showcase_tablet'] = '0';
					}
				} else {
					$slide_data['showcase_tablet'] = '0';
				}
				if (isset($metadata['sa_showcase_width_tab'])) {
					$slide_data['showcase_width_tab'] = $metadata['sa_showcase_width_tab'][0];
				} else {
					$slide_data['showcase_width_tab'] = '130';
				}
				if (isset($metadata['sa_showcase_mobile'])) {
					$slide_data['showcase_mobile'] = $metadata['sa_showcase_mobile'][0];
					if ($slide_data['showcase_mobile'] != '1') {
						$slide_data['showcase_mobile'] = '0';
					}
				} else {
					$slide_data['showcase_mobile'] = '0';
				}
				if (isset($metadata['sa_showcase_width_mob'])) {
					$slide_data['showcase_width_mob'] = $metadata['sa_showcase_width_mob'][0];
				} else {
					$slide_data['showcase_width_mob'] = '140';
				}
			}



			// REVERSE THE ORDER OF THE SLIDES IF 'Random Order' CHECKBOX IS CHECKED OR
			// RE-ORDER SLIDES IN A RANDOM ORDER IF 'Random Order' CHECKBOX IS CHECKED
			if (($slide_data['reverse_order'] == 'true') || ($slide_data['random_order'] == 'true')) {
				$reorder_arr = array();
				for ($i = 1; $i <= $slide_data['num_slides']; $i++) {
					$reorder_arr[$i-1]['num'] = $slide_data["slide".$i."_num"];
					$reorder_arr[$i-1]['content'] = $slide_data["slide".$i."_content"];
					$reorder_arr[$i-1]['image_id'] = $slide_data["slide".$i."_image_id"];
					$reorder_arr[$i-1]['image_pos'] = $slide_data["slide".$i."_image_pos"];
					$reorder_arr[$i-1]['image_size'] = $slide_data["slide".$i."_image_size"];
					$reorder_arr[$i-1]['image_repeat'] = $slide_data["slide".$i."_image_repeat"];
					$reorder_arr[$i-1]['image_color'] = $slide_data["slide".$i."_image_color"];
					$reorder_arr[$i-1]['link_url'] = $slide_data["slide".$i."_link_url"];
					$reorder_arr[$i-1]['link_target'] = $slide_data["slide".$i."_link_target"];
					if ($sa_pro_version) {
						$reorder_arr[$i-1]['popup_type'] = $slide_data["slide".$i."_popup_type"];
						$reorder_arr[$i-1]['popup_imageid'] = $slide_data["slide".$i."_popup_imageid"];
						$reorder_arr[$i-1]['popup_imagetitle'] = $slide_data["slide".$i."_popup_imagetitle"];
						$reorder_arr[$i-1]['popup_image'] = $slide_data["slide".$i."_popup_image"];
						$reorder_arr[$i-1]['popup_background'] = $slide_data["slide".$i."_popup_background"];
						$reorder_arr[$i-1]['popup_video_id'] = $slide_data["slide".$i."_popup_video_id"];
						$reorder_arr[$i-1]['popup_video_type'] = $slide_data["slide".$i."_popup_video_type"];
						$reorder_arr[$i-1]['popup_html'] = $slide_data["slide".$i."_popup_html"];
						$reorder_arr[$i-1]['popup_shortcode'] = $slide_data["slide".$i."_popup_shortcode"];
						$reorder_arr[$i-1]['popup_bgcol'] = $slide_data["slide".$i."_popup_bgcol"];
						$reorder_arr[$i-1]['popup_width'] = $slide_data["slide".$i."_popup_width"];
						$reorder_arr[$i-1]['popup_css_id'] = $slide_data["slide".$i."_popup_css_id"];
					}
				}
				if ($slide_data['random_order'] == 'true') {
					// SORT SLIDE ARRAY DATA IN A RANDOM ORDER
					shuffle($reorder_arr);
				} else {
					// REVERSE THE ORDER OF THE SLIDE DATA ARRAY
					$reverse_arr = array_reverse($reorder_arr);
					$reorder_arr = $reverse_arr;
				}
				for ($i = 1; $i <= $slide_data['num_slides']; $i++) {
					$slide_data["slide".$i."_num"] = $reorder_arr[$i-1]['num'];
					$slide_data["slide".$i."_content"] = $reorder_arr[$i-1]['content'];
					$slide_data["slide".$i."_image_id"] = $reorder_arr[$i-1]['image_id'];
					$slide_data["slide".$i."_image_pos"] = $reorder_arr[$i-1]['image_pos'];
					$slide_data["slide".$i."_image_size"] = $reorder_arr[$i-1]['image_size'];
					$slide_data["slide".$i."_image_repeat"] = $reorder_arr[$i-1]['image_repeat'];
					$slide_data["slide".$i."_image_color"] = $reorder_arr[$i-1]['image_color'];
					$slide_data["slide".$i."_link_url"] = $reorder_arr[$i-1]['link_url'];
					$slide_data["slide".$i."_link_target"] = $reorder_arr[$i-1]['link_target'];
					if ($sa_pro_version) {
						$slide_data["slide".$i."_popup_type"] = $reorder_arr[$i-1]['popup_type'];
						$slide_data["slide".$i."_popup_imageid"] = $reorder_arr[$i-1]['popup_imageid'];
						$slide_data["slide".$i."_popup_imagetitle"] = $reorder_arr[$i-1]['popup_imagetitle'];
						$slide_data["slide".$i."_popup_image"] = $reorder_arr[$i-1]['popup_image'];
						$slide_data["slide".$i."_popup_background"] = $reorder_arr[$i-1]['popup_background'];
						$slide_data["slide".$i."_popup_video_id"] = $reorder_arr[$i-1]['popup_video_id'];
						$slide_data["slide".$i."_popup_video_type"] = $reorder_arr[$i-1]['popup_video_type'];
						$slide_data["slide".$i."_popup_html"] = $reorder_arr[$i-1]['popup_html'];
						$slide_data["slide".$i."_popup_shortcode"] = $reorder_arr[$i-1]['popup_shortcode'];
						$slide_data["slide".$i."_popup_bgcol"] = $reorder_arr[$i-1]['popup_bgcol'];
						$slide_data["slide".$i."_popup_width"] = $reorder_arr[$i-1]['popup_width'];
						$slide_data["slide".$i."_popup_css_id"] = $reorder_arr[$i-1]['popup_css_id'];
					}
				}
			}

			// GENERATE HTML CODE FOR THE OWL CAROUSEL SLIDER
			$wrapper_style =  "background:".$slide_data['background_color']."; ";
			$wrapper_style .=  "border:solid ".$slide_data['border_width']."px ".$slide_data['border_color']."; ";
			$wrapper_style .=  "border-radius:".$slide_data['border_radius']."px; ";
			$wrapper_style .=  "padding:".$slide_data['wrapper_padd_top']."px ";
			$wrapper_style .= $slide_data['wrapper_padd_right']."px ";
			$wrapper_style .= $slide_data['wrapper_padd_bottom']."px ";
			$wrapper_style .= $slide_data['wrapper_padd_left']."px;";
			if ($slide_data['showcase_slider'] == '1') {
				$wrapper_style .= " overflow:hidden;";
			}
			$output .= "<div class='".$slide_data['slide_icons_color']."' style='".esc_attr($wrapper_style)."'>\n";
			$additional_classes = '';
			if ($slide_data['pagination'] == 'true') {
				if ($slide_data['autohide_arrows'] == 'true') {
					$additional_classes = "owl-pagination-true autohide-arrows";
				} else {
					$additional_classes = "owl-pagination-true";
				}
			} else {
				if ($slide_data['autohide_arrows'] == 'true') {
					$additional_classes = "autohide-arrows";
				}
			}
			// hero slider
			if ($slide_data['hero_slider'] == '1') {
				$additional_classes .= " sa_hero_slider";
			}
			$slider_style = "visibility:hidden;";
			// showcase slider
			if ($slide_data['showcase_slider'] == '1') {
				$left_perc = (intval($slide_data['showcase_width']) - 100) / 2;
				$slider_style .= " width:".$slide_data['showcase_width']."%;";
				$slider_style .= " left:-".$left_perc."%;";
				if ($slide_data['showcase_tablet'] == '1') {
					$left_perc_tab = (intval($slide_data['showcase_width_tab']) - 100) / 2;
					$slider_style .= " --widthtab:".$slide_data['showcase_width_tab']."%;";
					$slider_style .= " --lefttab:-".$left_perc_tab."%;";
					$additional_classes .= " showcase_tablet";
				} else {
					$additional_classes .= " showcase_hide_tablet";
				}
				if ($slide_data['showcase_mobile'] == '1') {
					$left_perc_mob = (intval($slide_data['showcase_width_mob']) - 100) / 2;
					$slider_style .= " --widthmob:".$slide_data['showcase_width_mob']."%;";
					$slider_style .= " --leftmob:-".$left_perc_mob."%;";
					$additional_classes .= " showcase_mobile";
				} else {
					$additional_classes .= " showcase_hide_mobile";
				}
			}
			$urrl = [];
			$content = [];
			for ($i = 1; $i <= $slide_data['num_slides']; $i++) {
				$urrl[] = wp_get_attachment_image_src($slide_data["slide".$i."_image_id"], 'full');
				$slide_content = $slide_data["slide".$i."_content"];
				$content[] = $slide_content;

			}
		
		}
	}
	$data['imgs'] = $urrl;
	$data['contents'] = $content;
	return $data;
}