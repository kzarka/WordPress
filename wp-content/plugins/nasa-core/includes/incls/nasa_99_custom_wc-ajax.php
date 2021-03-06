<?php
defined('ABSPATH') or die(); // Exit if accessed directly

if (class_exists('WC_AJAX')) :
    class NASA_WC_AJAX extends WC_AJAX {

        /**
         * Hook in ajax handlers.
         */
        public static function nasa_init() {
            add_action('init', array(__CLASS__, 'define_ajax'), 0);
            add_action('template_redirect', array(__CLASS__, 'do_wc_ajax'), 0);
            self::nasa_add_ajax_events();
        }

        /**
         * Hook in methods - uses WordPress ajax handlers (admin-ajax).
         */
        public static function nasa_add_ajax_events() {
            /**
             * Register ajax event
             */
            $ajax_events = array(
                'nasa_render_variables',
                'nasa_more_product',
                'nasa_custom_taxomomies_child',
                'nasa_viewed_sidebar_content'
            );

            foreach ($ajax_events as $ajax_event) {
                add_action('wp_ajax_woocommerce_' . $ajax_event, array(__CLASS__, $ajax_event));
                add_action('wp_ajax_nopriv_woocommerce_' . $ajax_event, array(__CLASS__, $ajax_event));

                // WC AJAX can be used for frontend ajax requests.
                add_action('wc_ajax_' . $ajax_event, array(__CLASS__, $ajax_event));
            }
        }
        
        /**
         * Viewed sidebar Content
         */
        public static function nasa_viewed_sidebar_content() {
            global $nasa_opt;
            
            $data = array('success' => '0', 'content' => '');
            
            if (!class_exists('WooCommerce') || (isset($nasa_opt['disable-viewed']) && $nasa_opt['disable-viewed'])) {
                wp_send_json($data);
                
                return;
            }
            
            $shortcode = apply_filters('nasa_shortcode_viewed_sidebar', '[nasa_products_viewed is_ajax="no" columns_number="1" columns_small="1" columns_number_tablet="1" default_rand="false" display_type="sidebar" animation="0"]');
            
            $data['content'] = do_shortcode($shortcode);
            if (!empty($data['content'])) {
                $data['success'] = '1';
            }
            
            wp_send_json($data);
        }

        /**
         * Render variations
         */
        public static function nasa_render_variables() {
            if (!isset($_POST['pids']) || empty($_POST['pids'])) {
                $data = array('empty' => '1');
            } else {
                $uxObject = Nasa_WC_Attr_UX::getInstance();
                $products = $uxObject->render_variables($_POST['pids']);
                if (!empty($products)) {
                    $data = array('empty' => '0', 'products' => $products);
                }
            }
            
            wp_send_json($data);
        }
        
        /**
         * Load more products
         */
        public static function nasa_more_product() {
            $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
            $post_per_page = isset($_REQUEST['post_per_page']) ? $_REQUEST['post_per_page'] : 10;
            $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
            $cat = (isset($_REQUEST['cat']) && $_REQUEST['cat'] != '') ? $_REQUEST['cat'] : null;
            
            $data = array('success' => '0');

            $loop = nasa_woocommerce_query($type, $post_per_page, $cat, $page);
            if ($loop->found_posts):
                global $nasa_opt;
            
                // Use in row_layout.php
                $columns_number = isset($_REQUEST['columns_number']) ?
                    $_REQUEST['columns_number'] : 5;
                $columns_number_tablet = isset($_REQUEST['columns_number_medium']) ?
                    $_REQUEST['columns_number_medium'] : 2;
                $columns_number_small = isset($_REQUEST['columns_number_small']) ?
                    $_REQUEST['columns_number_small'] : 1;
                $start_row = '';
                $end_row = '';
                
                ob_start();
                include NASA_CORE_PRODUCT_LAYOUTS . 'globals/row_layout.php';
                
                $data['content'] = ob_get_clean();
            endif;
            wp_reset_postdata();
            
            if (isset($data['content'])) {
                $data['success'] = '1';
            }
            
            wp_send_json($data);
        }
        
        /**
         * Render select Nasa Categories
         */
        public static function nasa_custom_taxomomies_child() {
            $key = isset($_REQUEST['key']) ? $_REQUEST['key'] : 0;
            $data = array('success' => false);

            if (!$key) {
                wp_send_json($data);
                
                return;
            }
            
            $slug = isset($_REQUEST['slug']) ? $_REQUEST['slug'] : null;
            $hide_empty = isset($_REQUEST['hide_empty']) ? $_REQUEST['hide_empty'] : '0';
            $count_items = isset($_REQUEST['show_count']) ? $_REQUEST['show_count'] : '0';
            $actived = isset($_REQUEST['actived']) ? $_REQUEST['actived'] : null;
            $data_select = isset($_REQUEST['select_text']) ? $_REQUEST['select_text'] : nasa_render_select_nasa_cats_empty();

            $emptySelect = $data_select;
            $content = '';
            if (!$slug) {
                $content .= '<option value="">' . $emptySelect . '</option>';

                $data = array(
                    'success' => true,
                    'content' => $content,
                    'empty' => true,
                    'has_active' => false
                );
            } else {
                $nasa_taxonomy = apply_filters('nasa_taxonomy_custom_cateogory', Nasa_WC_Taxonomy::$nasa_taxonomy);
                $currentTerm = get_term_by('slug', $slug, $nasa_taxonomy);

                if (isset($currentTerm->term_id)) {
                    $content .= '<option value="">' . $emptySelect . '</option>';

                    $childTerms = get_terms( 
                        array(
                            'taxonomy' => $nasa_taxonomy,
                            'parent' => $currentTerm->term_id,
                            'hide_empty' => $hide_empty,
                            'menu_order' => 'asc'
                        )
                    );

                    if ($childTerms) {
                        $hasActive = false;
                        foreach ($childTerms as $item) {
                            if ($actived && $item->slug == $actived) {
                                $hasActive = true;
                            }

                            $label = $count_items ? $item->name . ' (' . $item->count . ')' : $item->name;
                            $content .= '<option value="' . $item->slug . '">' . $label .  '</option>';
                        }

                        $data = array(
                            'success' => true,
                            'content' => $content,
                            'empty' => false,
                            'has_active' => $hasActive
                        );
                    } else {
                        $data = array(
                            'success' => true,
                            'content' => $content,
                            'empty' => true,
                            'has_active' => false
                        );
                    }
                }
            }
            
            wp_send_json($data);
        }
    }

    /**
     * Init NASA WC AJAX
     */
    if (isset($_REQUEST['wc-ajax'])) {
        add_action('init', 'nasa_init_wc_ajax');
        if (!function_exists('nasa_init_wc_ajax')) :
            function nasa_init_wc_ajax() {
                NASA_WC_AJAX::nasa_init();
            }
        endif;
    }

endif;
