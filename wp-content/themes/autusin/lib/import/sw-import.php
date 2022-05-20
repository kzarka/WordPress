<?php 
function sw_import_files() { 
	return array(
		array(
			'import_file_name'             => 'Home',
			'page_title'				   => 'Home page 1',
			'header_title' 				   => 'Header style 1',
			'footer_title' 				   => 'Footer style 1',
			'site_url'					   => 'https://demo.wpthemego.com/themes/sw_autusin',
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/data.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/widgets.json',
			'local_import_page_file'       => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/demo-content-page.xml',
			'local_import_pagemenu_file'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/demo-content-pagemenu.xml',			
			'local_import_template_all_homepages' => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/demo-content-all-templates.xml',
			'local_import_template_homepage' => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/demo-content-homepage-templates.xml', 
			'local_import_revslider'  		 => array( 
				'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/slideshow1.zip',
				),
			'local_import_options'         => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/theme_options.txt',
					'option_name' => 'autusin_theme',
					),
				),
			'menu_locate'									 => array(
				'primary_menu' => 'Primary Menu',
				'vertical_menu' => 'Vertical Menu',
				'mobile_menu1' => 'Mobile Menu'
				),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-1/1.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'autusin' ),
			'preview_url'                  => esc_url( 'https://demo.wpthemego.com/themes/sw_autusin/' ),
			),

		array(
			'import_file_name'             => 'Home Page 2',
			'page_title'				   => 'Home Page 2',
			'header_title' 				   => 'Header style 2',
			'footer_title' 				   => 'Footer style 1',
			'site_url'					   => 'https://demo.wpthemego.com/themes/sw_autusin',
			'local_import_template_all_homepages' => trailingslashit( get_template_directory() ) . 'lib/import/demo-2/demo-content-all-templates.xml',
			'local_import_template_homepage' => trailingslashit( get_template_directory() ) . 'lib/import/demo-2/demo-content-homepage-templates.xml', 
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/data.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/widgets.json',
			'local_import_page_file'       => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/demo-content-page.xml',
			'local_import_pagemenu_file'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/demo-content-pagemenu.xml',			
			'local_import_revslider'  		 => array( 
				'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-2/slideshow1.zip',
				),
			'local_import_options'         => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-2/theme_options.txt',
					'option_name' => 'autusin_theme',
					),
				),
			'menu_locate'									 => array(
				'primary_menu' => 'Primary Menu',
				'vertical_menu' => 'Vertical Menu',
				'mobile_menu1' => 'Mobile Menu'
				),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-2/2.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'autusin' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_autusin/home-page-2' ),
			),

		array(
			'import_file_name'             => 'Home Page 3',
			'page_title'				   => 'Home Page 3',
			'header_title' 				   => 'Header style 3',
			'footer_title' 				   => 'Footer style 2',
			'site_url'					   => 'https://demo.wpthemego.com/themes/sw_autusin/demo2',
			'local_import_template_all_homepages' => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/demo-content-all-templates.xml',
			'local_import_template_homepage' => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/demo-content-homepage-templates.xml', 
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/data.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/widgets.json',
			'local_import_page_file'       => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/demo-content-page.xml',
			'local_import_pagemenu_file'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/demo-content-pagemenu.xml',
			'local_import_revslider'  		 => array( 
				'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/slideshow3.zip',
				),
			'local_import_options'         => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/theme_options.txt',
					'option_name' => 'autusin_theme',
					),
				),
			'menu_locate'									 => array(
				'primary_menu' => 'Primary Menu',
				'vertical_menu' => 'Vertical Menu',
				'mobile_menu1' => 'Mobile Menu'
				),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-3/3.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'autusin' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_autusin/demo2/' ),
			),

			array(
			'import_file_name'             => 'Home Page 4',
			'page_title'				   => 'Home Page 4',
			'header_title' 				   => 'Header style 4',
			'footer_title' 				   => 'Footer style 2',
			'site_url'					   => 'https://demo.wpthemego.com/themes/sw_autusin/demo2',
			'local_import_template_all_homepages' => trailingslashit( get_template_directory() ) . 'lib/import/demo-4/demo-content-all-templates.xml',
			'local_import_template_homepage' => trailingslashit( get_template_directory() ) . 'lib/import/demo-4/demo-content-homepage-templates.xml', 
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/data.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/widgets.json',
			'local_import_page_file'       => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/demo-content-page.xml',
			'local_import_pagemenu_file'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/demo-content-pagemenu.xml',
			'local_import_revslider'  		 => array( 
				'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-4/slideshow4.zip',
				),
			'local_import_options'         => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-4/theme_options.txt',
					'option_name' => 'autusin_theme',
					),
				),
			'menu_locate'									 => array(
				'primary_menu' => 'Primary Menu',
				'vertical_menu' => 'Vertical Menu',
				'mobile_menu1' => 'Mobile Menu'
				),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-4/4.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'autusin' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_autusin/demo2/home-page-4' ),
			),


			array(
			'import_file_name'             => 'Home Page 5',
			'page_title'				   => 'Home Page 5',
			'header_title' 				   => 'Header style 5',
			'footer_title' 				   => 'Footer style 5',
			'site_url'					   => 'https://demo.wpthemego.com/themes/sw_autusin/demo3',
			'local_import_template_all_homepages' => trailingslashit( get_template_directory() ) . 'lib/import/demo-5/demo-content-all-templates.xml',
			'local_import_template_homepage' => trailingslashit( get_template_directory() ) . 'lib/import/demo-5/demo-content-homepage-templates.xml', 
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-5/data.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-5/widgets.json',
			'local_import_page_file'       => trailingslashit( get_template_directory() ) . 'lib/import/demo-5/demo-content-page.xml',
			'local_import_pagemenu_file'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-5/demo-content-pagemenu.xml',
			'local_import_revslider'  		 => array( 
				'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-5/slideshow5.zip',
				),
			'local_import_options'         => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-5/theme_options.txt',
					'option_name' => 'autusin_theme',
					),
				),
			'menu_locate'									 => array(
				'primary_menu' => 'Primary Menu',
				'vertical_menu' => 'Vertical Menu',
				'mobile_menu1' => 'Mobile Menu'
				),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-5/5.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'autusin' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_autusin/demo3/' ),
			),

			array(
			'import_file_name'             => 'Home Page 6',
			'page_title'				   => 'Home Page 6',
			'header_title' 				   => 'Header style 6',
			'footer_title' 				   => 'Footer style 6',
			'site_url'					   => 'https://demo.wpthemego.com/themes/sw_autusin/demo3',
			'local_import_template_all_homepages' => trailingslashit( get_template_directory() ) . 'lib/import/demo-6/demo-content-all-templates.xml',
			'local_import_template_homepage' => trailingslashit( get_template_directory() ) . 'lib/import/demo-6/demo-content-homepage-templates.xml', 
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-5/data.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-5/widgets.json',
			'local_import_page_file'       => trailingslashit( get_template_directory() ) . 'lib/import/demo-5/demo-content-page.xml',
			'local_import_pagemenu_file'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-5/demo-content-pagemenu.xml',
			'local_import_revslider'  		 => array( 
				'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-6/slideshow6.zip',
				),
			'local_import_options'         => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-6/theme_options.txt',
					'option_name' => 'autusin_theme',
					),
				),
			'menu_locate'									 => array(
				'primary_menu' => 'Primary Menu',
				'vertical_menu' => 'Vertical Menu',
				'mobile_menu1' => 'Mobile Menu'
				),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-6/6.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'autusin' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_autusin/demo3/home-page-6' ),
			),

			array(
			'import_file_name'             => 'Home Page 7',
			'page_title'				   => 'Home Page 7',
			'header_title' 				   => 'Header style 7',
			'footer_title' 				   => 'Footer style 7',
			'site_url'					   => 'https://demo.wpthemego.com/themes/sw_autusin/demo4',
			'local_import_template_all_homepages' => trailingslashit( get_template_directory() ) . 'lib/import/demo-7/demo-content-all-templates.xml',
			'local_import_template_homepage' => trailingslashit( get_template_directory() ) . 'lib/import/demo-7/demo-content-homepage-templates.xml', 
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-7/data.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-7/widgets.json',
			'local_import_page_file'       => trailingslashit( get_template_directory() ) . 'lib/import/demo-7/demo-content-page.xml',
			'local_import_pagemenu_file'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-7/demo-content-pagemenu.xml',
			'local_import_revslider'  		 => array( 
				'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-7/slideshow7.zip',
				'slide2' => trailingslashit( get_template_directory() ) . 'lib/import/demo-7/slideshow7_1.zip',
				),
			'local_import_options'         => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-7/theme_options.txt',
					'option_name' => 'autusin_theme',
					),
				),
			'menu_locate'									 => array(
				'primary_menu' => 'Primary Menu',
				'vertical_menu' => 'Vertical Menu',
				'mobile_menu1' => 'Mobile Menu'
				),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-7/7.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'autusin' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_autusin/demo4/home-page-7' ),
			),

		array(
			'import_file_name'             => 'Home Page 8',
			'page_title'				   => 'Home Page 8',
			'header_title' 				   => 'Header style 8',
			'footer_title' 				   => 'Footer style 8',
			'site_url'					   => 'https://demo.wpthemego.com/themes/sw_autusin/demo4',
			'local_import_template_all_homepages' => trailingslashit( get_template_directory() ) . 'lib/import/demo-8/demo-content-all-templates.xml',
			'local_import_template_homepage' => trailingslashit( get_template_directory() ) . 'lib/import/demo-8/demo-content-homepage-templates.xml', 
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-7/data.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-7/widgets.json',
			'local_import_page_file'       => trailingslashit( get_template_directory() ) . 'lib/import/demo-7/demo-content-page.xml',
			'local_import_pagemenu_file'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-7/demo-content-pagemenu.xml',
			'local_import_revslider'  		 => array( 
				'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-8/slideshow8.zip',
				'slide2' => trailingslashit( get_template_directory() ) . 'lib/import/demo-8/slideshow_1.zip',
				),
			'local_import_options'         => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-8/theme_options.txt',
					'option_name' => 'autusin_theme',
					),
				),
			'menu_locate'									 => array(
				'primary_menu' => 'Primary Menu',
				'vertical_menu' => 'Vertical Menu',
				'mobile_menu1' => 'Mobile Menu'
				),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-8/8.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'autusin' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_autusin/demo4/' ),
			),

			array(
			'import_file_name'             => 'Home Page 9',
			'page_title'				   => 'Home Page 9',
			'header_title' 				   => 'Header style 9',
			'footer_title' 				   => 'Footer style 9',
			'site_url'					   => 'https://demo.wpthemego.com/themes/sw_autusin/demo4',
			'local_import_template_all_homepages' => trailingslashit( get_template_directory() ) . 'lib/import/demo-9/demo-content-all-templates.xml',
			'local_import_template_homepage' => trailingslashit( get_template_directory() ) . 'lib/import/demo-9/demo-content-homepage-templates.xml', 
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-7/data.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-7/widgets.json',
			'local_import_page_file'       => trailingslashit( get_template_directory() ) . 'lib/import/demo-7/demo-content-page.xml',
			'local_import_pagemenu_file'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-7/demo-content-pagemenu.xml',
			'local_import_revslider'  		 => array( 
				'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-9/slideshow9.zip',
				
				),
			'local_import_options'         => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-9/theme_options.txt',
					'option_name' => 'autusin_theme',
					),
				),
			'menu_locate'									 => array(
				'primary_menu' => 'Primary Menu',
				'vertical_menu' => 'Vertical Menu',
				'mobile_menu1' => 'Mobile Menu'
				),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-9/9.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'autusin' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_autusin/demo4/home-page-9' ),
			),

			array(
			'import_file_name'             => 'Home Page 10',
			'page_title'				   => 'Home Page 10',
			'header_title' 				   => 'Header style 10',
			'footer_title' 				   => 'Footer style 9',
			'site_url'					   => 'https://demo.wpthemego.com/themes/sw_autusin/demo4',
			'local_import_template_all_homepages' => trailingslashit( get_template_directory() ) . 'lib/import/demo-10/demo-content-all-templates.xml',
			'local_import_template_homepage' => trailingslashit( get_template_directory() ) . 'lib/import/demo-10/demo-content-homepage-templates.xml', 
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-7/data.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-7/widgets.json',
			'local_import_page_file'       => trailingslashit( get_template_directory() ) . 'lib/import/demo-7/demo-content-page.xml',
			'local_import_pagemenu_file'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-7/demo-content-pagemenu.xml',
			'local_import_revslider'  		 => array( 
				'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-10/slideshow10.zip',
				
				),
			'local_import_options'         => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-10/theme_options.txt',
					'option_name' => 'autusin_theme',
					),
				),
			'menu_locate'									 => array(
				'primary_menu' => 'Primary Menu',
				'vertical_menu' => 'Vertical Menu',
				'mobile_menu1' => 'Mobile Menu'
				),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-10/10.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'autusin' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_autusin/demo4/home-page-10' ),
			),
			array(
			'import_file_name'             => 'Home Page 11',
			'page_title'				   => 'Home Page 11',
			'header_title' 				   => 'Header style 10',
			'footer_title' 				   => 'Footer style 11',
			'site_url'					   => 'https://demo.wpthemego.com/themes/sw_autusin/demo5',
			'local_import_template_all_homepages' => trailingslashit( get_template_directory() ) . 'lib/import/demo-11/demo-content-all-templates.xml',
			'local_import_template_homepage' => trailingslashit( get_template_directory() ) . 'lib/import/demo-11/demo-content-homepage-templates.xml', 
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-11/data.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-11/widgets.json',
			'local_import_page_file'       => trailingslashit( get_template_directory() ) . 'lib/import/demo-11/demo-content-page.xml',
			'local_import_pagemenu_file'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-11/demo-content-pagemenu.xml',
			'local_import_revslider'  		 => array( 
				'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-11/slideshow11.zip',
				
				),
			'local_import_options'         => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-11/theme_options.txt',
					'option_name' => 'autusin_theme',
					),
				),
			'menu_locate'									 => array(
				'primary_menu' => 'Primary Menu',
				'vertical_menu' => 'Vertical Menu',
				'mobile_menu1' => 'Mobile Menu'
				),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-11/11.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'autusin' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_autusin/demo5/' ),
			),
				array(
			'import_file_name'             => 'Home Page 12',
			'page_title'				   => 'Home Page 12',
			'header_title' 				   => 'Header style 12',
			'footer_title' 				   => 'Footer style 12',
			'site_url'					   => 'https://demo.wpthemego.com/themes/sw_autusin/demo5',
			'local_import_template_all_homepages' => trailingslashit( get_template_directory() ) . 'lib/import/demo-12/demo-content-all-templates.xml',
			'local_import_template_homepage' => trailingslashit( get_template_directory() ) . 'lib/import/demo-12/demo-content-homepage-templates.xml', 
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-11/data.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-11/widgets.json',
			'local_import_page_file'       => trailingslashit( get_template_directory() ) . 'lib/import/demo-11/demo-content-page.xml',
			'local_import_pagemenu_file'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-11/demo-content-pagemenu.xml',
			'local_import_revslider'  		 => array( 
				'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-12/slideshow12.zip',
				
				),
			'local_import_options'         => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-12/theme_options.txt',
					'option_name' => 'autusin_theme',
					),
				),
			'menu_locate'									 => array(
				'primary_menu' => 'Primary Menu',
				'vertical_menu' => 'Vertical Menu',
				'mobile_menu1' => 'Mobile Menu'
				),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-12/12.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'autusin' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_autusin/demo5/home-page-12' ),
			),

			array(
			'import_file_name'             => 'Home Christmas',
			'page_title'				   => 'Home Page 13',
			'header_title' 				   => 'Header style 13',
			'footer_title' 				   => 'Footer style 8',
			'site_url'					   => 'https://demo.wpthemego.com/themes/sw_autusin/demo4',
			'local_import_template_all_homepages' => trailingslashit( get_template_directory() ) . 'lib/import/demo-christmas/demo-content-all-templates.xml',
			'local_import_template_homepage' => trailingslashit( get_template_directory() ) . 'lib/import/demo-christmas/demo-content-homepage-templates.xml', 
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-7/data.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-7/widgets.json',
			'local_import_page_file'       => trailingslashit( get_template_directory() ) . 'lib/import/demo-7/demo-content-page.xml',
			'local_import_pagemenu_file'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-7/demo-content-pagemenu.xml',
			'local_import_revslider'  		 => array( 
				'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-christmas/slider-home-13.zip',
				
				),
			'local_import_options'         => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-christmas/theme_options.txt',
					'option_name' => 'autusin_theme',
					),
				),
			'menu_locate'									 => array(
				'primary_menu' => 'Primary Menu',
				'vertical_menu' => 'Vertical Menu',
				'mobile_menu1' => 'Mobile Menu'
				),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-christmas/13.png',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'autusin' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_autusin/demo4/home-page-13' ),
			),

			array(
			'import_file_name'             => 'Home Page 13',
			'page_title'				   => 'Home Page 13',
			'header_title' 				   => 'Header style 13',
			'footer_title' 				   => 'Footer style 13',
			'site_url'					   => 'https://demo.wpthemego.com/themes/sw_autusin/demo6',
			'local_import_template_all_homepages' => trailingslashit( get_template_directory() ) . 'lib/import/demo-13/demo-content-all-templates.xml',
			'local_import_template_homepage' => trailingslashit( get_template_directory() ) . 'lib/import/demo-13/demo-content-homepage-templates.xml', 
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-13/data.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-13/widgets.json',
			'local_import_page_file'       => trailingslashit( get_template_directory() ) . 'lib/import/demo-13/demo-content-page.xml',
			'local_import_pagemenu_file'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-13/demo-content-pagemenu.xml',
			'local_import_revslider'  		 => array( 
				'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-13/slider-1.zip',
				
				),
			'local_import_options'         => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-13/theme_options.txt',
					'option_name' => 'autusin_theme',
					),
				),
			'menu_locate'									 => array(
				'primary_menu' => 'Primary Menu',
				'vertical_menu' => 'Vertical Menu',
				),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-13/13.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'autusin' ),
			'preview_url'                  => esc_url( 'https://demo.wpthemego.com/themes/sw_autusin/demo6/' ),
			),

			array(
			'import_file_name'             => 'Home Page 14',
			'page_title'				   => 'Home Page 14',
			'header_title' 				   => 'Header style 14',
			'footer_title' 				   => 'Footer style 14',
			'site_url'					   => 'https://demo.wpthemego.com/themes/sw_autusin/demo6',
			'local_import_template_all_homepages' => trailingslashit( get_template_directory() ) . 'lib/import/demo-14/demo-content-all-templates.xml',
			'local_import_template_homepage' => trailingslashit( get_template_directory() ) . 'lib/import/demo-14/demo-content-homepage-templates.xml', 
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-13/data.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-13/widgets.json',
			'local_import_page_file'       => trailingslashit( get_template_directory() ) . 'lib/import/demo-13/demo-content-page.xml',
			'local_import_pagemenu_file'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-13/demo-content-pagemenu.xml',
			'local_import_revslider'  		 => array( 
				'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-14/Slider--14.zip',
				
				),
			'local_import_options'         => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-14/theme_options.txt',
					'option_name' => 'autusin_theme',
					),
				),
			'menu_locate'									 => array(
				'primary_menu' => 'Primary Menu',
				'vertical_menu' => 'Vertical Menu',
				),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-14/14.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'autusin' ),
			'preview_url'                  => esc_url( 'https://demo.wpthemego.com/themes/sw_autusin/demo6/home-page-14' ),
			),

			array(
			'import_file_name'             => 'Home Page 15',
			'page_title'				   => 'Home Page 15',
			'header_title' 				   => 'Header style 15',
			'footer_title' 				   => 'Footer style 15',
			'site_url'					   => 'https://demo.wpthemego.com/themes/sw_autusin/demo6',
			'local_import_template_all_homepages' => trailingslashit( get_template_directory() ) . 'lib/import/demo-15/demo-content-all-templates.xml',
			'local_import_template_homepage' => trailingslashit( get_template_directory() ) . 'lib/import/demo-15/demo-content-homepage-templates.xml', 
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-13/data.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-13/widgets.json',
			'local_import_page_file'       => trailingslashit( get_template_directory() ) . 'lib/import/demo-13/demo-content-page.xml',
			'local_import_pagemenu_file'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-13/demo-content-pagemenu.xml',
			'local_import_revslider'  		 => array( 
				'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-15/Slider--15.zip',
				
				),
			'local_import_options'         => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-15/theme_options.txt',
					'option_name' => 'autusin_theme',
					),
				),
			'menu_locate'									 => array(
				'primary_menu' => 'Primary Menu',
				'vertical_menu' => 'Vertical Menu',
				),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-15/15.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'autusin' ),
			'preview_url'                  => esc_url( 'https://demo.wpthemego.com/themes/sw_autusin/demo6/home-page-15' ),
			),
			
	);
}
add_filter( 'pt-ocdi/import_files', 'sw_import_files' );