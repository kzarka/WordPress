<?php

if (class_exists('WC_Widget')) {

    add_action('widgets_init', 'nasa_product_filter_price_list_widget');
    function nasa_product_filter_price_list_widget() {
        register_widget('Nasa_WC_Widget_Price_Filter_List');
    }

    class Nasa_WC_Widget_Price_Filter_List extends WC_Widget {

        /**
         * Constructor
         */
        public function __construct() {
            $this->widget_cssclass = 'woocommerce widget_price_filter_list nasa-any-filter';
            $this->widget_description = esc_html__('Display a list of prices to filter products.', 'nasa-core');
            $this->widget_id = 'nasa_woocommerce_price_filter_list';
            $this->widget_name = esc_html__('Nasa Product Price Filter (list)', 'nasa-core');
            $this->settings = array(
                'title' => array(
                    'type' => 'text',
                    'std' => esc_html__('Filter by price', 'nasa-core'),
                    'label' => esc_html__('Title', 'nasa-core')
                ),
                'price_range_size' => array(
                    'type' => 'number',
                    'step' => 1,
                    'min' => 1,
                    'max' => '',
                    'std' => 50,
                    'label' => esc_html__('Price range size', 'nasa-core')
                ),
                'max_price_ranges' => array(
                    'type' => 'number',
                    'step' => 1,
                    'min' => 1,
                    'max' => '',
                    'std' => 10,
                    'label' => esc_html__('Max price ranges', 'nasa-core')
                ),
                'hide_empty_ranges' => array(
                    'type' => 'checkbox',
                    'std' => 1,
                    'label' => esc_html__('Hide empty price ranges', 'nasa-core')
                ),
                'hide_decimal' => array(
                    'type' => 'checkbox',
                    'std' => 1,
                    'label' => esc_html__('Hide decimal price', 'nasa-core')
                )
            );

            parent::__construct();
        }

        /**
         * widget function.
         *
         * @see WP_Widget
         * @param array $args
         * @param array $instance
         */
        public function widget($args, $instance) {
            if (!is_shop() && !is_product_taxonomy()) {
                return;
            }

            global $wp;
            extract($args);

            $min_price = isset($_GET['min_price']) ? wc_clean(wp_unslash($_GET['min_price'])) : '';
            $max_price = isset($_GET['max_price']) ? wc_clean(wp_unslash($_GET['max_price'])) : '';

            if (get_option('permalink_structure') == '') {
                $link = remove_query_arg(array('page', 'paged', 'product-page'), add_query_arg($wp->query_string, '', home_url($wp->request)));
            } else {
                $link = preg_replace('%\/page/[0-9]+%', '', home_url($wp->request . '/'));
            }
            
            if (!empty($_GET)) {
                foreach ($_GET as $key => $value) {
                    if (!in_array($key, array('min_price', 'max_price', 'paging-style'))) {
                        $link = add_query_arg($key, esc_attr($value), $link);
                    }
                }
            }

            $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
            if ($_chosen_attributes) {
                foreach ($_chosen_attributes as $attribute => $data) {
                    $taxonomy_filter = 'filter_' . str_replace('pa_', '', $attribute);
                    $link = add_query_arg(esc_attr($taxonomy_filter), esc_attr(implode(',', $data['terms'])), $link);

                    if ('or' == $data['query_type']) {
                        $link = add_query_arg(esc_attr(str_replace('pa_', 'query_type_', $attribute)), 'or', $link);
                    }
                }
            }

            // Find min and max price in current result set
            $prices = nasa_get_filtered_price();
            $min = floor($prices->min_price);
            $max = ceil($prices->max_price);

            if ($min == $max) {
                return;
            }
            
            $price_range_size = isset($instance['price_range_size']) ? $instance['price_range_size'] : 50;
            $max_price_ranges = isset($instance['max_price_ranges']) ? $instance['max_price_ranges'] : 10;
            $hide_empty_ranges = isset($instance['hide_empty_ranges']) ? $instance['hide_empty_ranges'] : 0;
            $hide_decimal = isset($instance['hide_decimal']) ? $instance['hide_decimal'] : 0;

            $this->widget_start($args, $instance);

            // Apply WooCommerce filters on min and max prices (required for updating currency-switcher prices)
            $min = apply_filters('woocommerce_price_filter_widget_min_amount', $min);
            $max_unfiltered = $max;
            $max = apply_filters('woocommerce_price_filter_widget_max_amount', $max);

            $count = 0;
            // If the filtered max-price (see above) is different from the original price (currency-switcher used) - apply "woocommerce_price_filter_widget_max_amount" filter to adapt price-range to the different prices
            if ($max_unfiltered != $max) {
                $range_size = round(apply_filters('woocommerce_price_filter_widget_max_amount', intval($price_range_size)), 0);
            } else {
                $range_size = intval($price_range_size);
            }
            $max_ranges = (intval($max_price_ranges) - 1);

            // Price descimals
            $wc_price_args = (!$hide_decimal) ? array() : array('decimals' => 0);

            $output = '<ul class="nasa-price-filter-list">';

            $output .= strlen($min_price) > 0 ?
                '<li class="nasa-all-price"><a class="nasa-filter-by-price-list" href="' . esc_url($link) . '"><span class="nasa-filter-price-text">' . esc_html__('All', 'nasa-core') . '</span></a></li>' : 
                '<li class="nasa-active nasa-all-price"><span class="nasa-filter-price-text">' . esc_html__('All', 'nasa-core') . '</span></li>';

            for ($range_min = 0; $range_min < ($max + $range_size); $range_min += $range_size) {
                $range_max = $range_min + $range_size;

                // Hide empty price ranges?
                if (intval($hide_empty_ranges)) {
                    // Are there products in this price range?
                    if ($min > $range_max || ($max + $range_size) < $range_max || $range_min == $max) {
                        continue;
                    }
                }

                $count++;

                $min_price_output = wc_price($range_min, $wc_price_args);

                if ($count == $max_ranges) {
                    $price_output = '<span class="nasa-filter-price-text">' . $min_price_output . esc_html__('+', 'nasa-core') . '</span>';

                    if ($range_min != $min_price) {
                        $url = add_query_arg(array('min_price' => $range_min, 'max_price' => $max), $link);
                        $output .= '<li><a class="nasa-filter-by-price-list" href="' . esc_url($url) . '" data-min="' . intval($range_min) . '" data-max="' . intval($range_max) . '">' . $price_output . '</a></li>';
                    } else {
                        $output .= '<li class="nasa-active">' . $price_output . '</li>';
                    }

                    break; // Max price ranges limit reached, break loop
                } else {
                    $price_output = '<span class="nasa-filter-price-text">' . $min_price_output . ' - ' . wc_price($range_min + $range_size, $wc_price_args) . '</span>';

                    if ($range_min != $min_price || $range_max != $max_price) {
                        $url = add_query_arg(array('min_price' => $range_min, 'max_price' => $range_max), $link);
                        $output .= '<li><a class="nasa-filter-by-price-list" href="' . esc_url($url) . '" data-min="' . intval($range_min) . '" data-max="' . intval($range_max) . '">' . $price_output . '</a></li>';
                    } else {
                        $output .= '<li class="nasa-active">' . $price_output . '</li>';
                    }
                }
            }

            $output .= '</ul>';

            echo $output;
            $this->widget_end($args);
        }

    }
}
