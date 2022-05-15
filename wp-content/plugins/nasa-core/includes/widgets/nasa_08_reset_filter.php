<?php

if (class_exists('WC_Widget')) {

    add_action('widgets_init', 'nasa_reset_filter_widget');
    function nasa_reset_filter_widget() {
        register_widget('Nasa_WC_Widget_Reset_Filters');
    }

    /**
     * Reset Filter Widget and related functions
     *
     * @author   NasaThemes
     * @category Widgets
     * @version  1.0.0
     * @extends  WC_Widget
     */
    class Nasa_WC_Widget_Reset_Filters extends WC_Widget {

        /**
         * Constructor.
         */
        public function __construct() {
            $this->widget_cssclass = 'woocommerce widget_reset_filters nasa-no-toggle';
            $this->widget_description = __('Display button reset filter.', 'nasa-core');
            $this->widget_id = 'nasa_woocommerce_reset_filter';
            $this->widget_name = __('Nasa Reset Filters', 'nasa-core');
            $this->settings = array(
                'title' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('Title', 'nasa-core'),
                ),
            );

            parent::__construct();
        }

        /**
         * Output widget.
         *
         * @see WP_Widget
         * @param array $args     Arguments.
         * @param array $instance Widget instance.
         */
        public function widget($args, $instance) {
            if (!is_shop() && !is_product_taxonomy()) {
                return;
            }

            $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
            $min_price = isset($_GET['min_price']) ? wc_clean(wp_unslash($_GET['min_price'])) : 0;
            $max_price = isset($_GET['max_price']) ? wc_clean(wp_unslash($_GET['max_price'])) : 0;
            $rating_filter = isset($_GET['rating_filter']) ? array_filter(array_map('absint', explode(',', wp_unslash($_GET['rating_filter'])))) : array();

            if (0 < count($_chosen_attributes) || 0 < $min_price || 0 < $max_price || !empty($rating_filter)) {
                global $wp, $wp_query;
                
                $title = isset($instance['title']) && $instance['title'] != '' ? $instance['title'] : esc_html__('Reset', 'nasa-core');
                
                if (get_option('permalink_structure') == '') {
                    $nasa_href_page = add_query_arg($wp->query_string, '', home_url($wp->request));
                } else {
                    $nasa_href_page = preg_replace('%\/page/[0-9]+%', '', home_url($wp->request . '/'));
                }
                
                $reset_arrays = array('min_price', 'max_price', 'rating_filter');
                $array_add = array();
                if (! empty($_GET) && count($_chosen_attributes)) {
                    foreach ($_GET as $key => $value) { // WPCS: input var ok, CSRF ok.
                        if (0 === strpos($key, 'filter_')) {
                            $attribute = wc_sanitize_taxonomy_name(str_replace('filter_', '', $key));
                            $reset_arrays[] = $key;
                            $reset_arrays[] = 'query_type_' . $attribute;
                        } else {
                            if (! in_array($key, $reset_arrays)) {
                                $array_add[$key] = $value;
                            }
                        }
                    }
                }
                
                $nasa_href_page = remove_query_arg($reset_arrays, add_query_arg($array_add, $nasa_href_page));
                
                $nasa_cat_obj = $wp_query->get_queried_object();
                if (isset($nasa_cat_obj->term_id) && isset($nasa_cat_obj->taxonomy)) {
                    $nasa_term_id = (int) $nasa_cat_obj->term_id;
                    $nasa_type_page = $nasa_cat_obj->taxonomy;
                } else {
                    $nasa_term_id = 0;
                    $nasa_type_page = 'product_cat';
                }

                $this->widget_start($args, $instance);

                echo '<a data-id="' . $nasa_term_id . '" data-taxonomy="' . $nasa_type_page . '" class="nasa-reset-filters-btn" href="' . $nasa_href_page . '" title="' . $title . '">' . $title . '</a>';

                $this->widget_end($args);
            }
        }
    }
}
