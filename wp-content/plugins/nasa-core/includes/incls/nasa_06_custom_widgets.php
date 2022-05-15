<?php
add_action('widgets_init', 'nasa_cat_sidebar_override', 999);
function nasa_cat_sidebar_override() {
    $sidebar_cats = get_option('nasa_sidebars_cats');
    
    if (!empty($sidebar_cats)) {
        foreach ($sidebar_cats as $sidebar) {
            if (isset($sidebar['slug'])) {
                $name = esc_html__('Products Category: ', 'nasa-core') . (isset($sidebar['name']) ? ($sidebar['name'] . ' (' . $sidebar['slug'] . ')') : $sidebar['slug']);
                register_sidebar(array(
                    'name'          => $name,
                    'id'            => $sidebar['slug'],
                    'before_widget' => '<div id="%1$s" class="widget %2$s"><a href="javascript:void(0);" class="nasa-toggle-widget"></a><div class="nasa-open-toggle">',
                    'before_title'  => '<h5 class="widgettitle">',
                    'after_title'   => '</h5>',
                    'after_widget'  => '</div></div>',
                ));
            }
        }
    }
}

/**
 * Includes Widgets
 */
nasa_includes_files(glob(NASA_CORE_PLUGIN_PATH . 'includes/widgets/nasa_*.php'));

/**
 * Function for widgets
 */
if (!function_exists('nasa_get_content_widget_price')) :

    function nasa_get_content_widget_price($argsIn = array(), $instanceIn = array(), $show = true) {
        $args = array(
            'widget_id' => $argsIn['widget_id'],
            'before_title' => str_replace('\\', '', $argsIn['before_title']),
            'after_title' => str_replace('\\', '', $argsIn['after_title'])
        );

        $instance = array(
            'title' => isset($instanceIn['title']) ? $instanceIn['title'] : esc_html__('Price', 'nasa-core'),
            'btn_filter' => isset($instanceIn['btn_filter']) ? $instanceIn['btn_filter'] : 0
        );

        $classWrap = !$show ? ' hidden-tag' : '';

        if (!is_post_type_archive('product') && !is_tax(get_object_taxonomies('product'))) {
            return
                '<div id="' . $args['widget_id'] . '-ajax-wrap" class="nasa-hide-price nasa-filter-price-widget-wrap' . esc_attr($classWrap) . '" data-instance="' . esc_attr(json_encode($instance)) . '" data-args="' . esc_attr(json_encode($args)) . '">' .
                    $args['before_title'] . $instance['title'] . $args['after_title'] .
                '</div>';
        }

        global $_chosen_attributes, $wp;

        $min_price = isset($_REQUEST['min_price']) ? $_REQUEST['min_price'] : '';
        $max_price = isset($_REQUEST['max_price']) ? $_REQUEST['max_price'] : '';
        $hasPrice = ($min_price || $max_price) ? '1' : '0';
        $class_reset = $hasPrice == '1' ? '' : ' hidden-tag';

        // Remember current filters/search
        $fields = ($search_query = get_search_query()) ? '<input type="hidden" name="s" value="' . esc_attr($search_query) . '" />' : '';

        $fields .= !empty($_REQUEST['post_type']) ? '<input type="hidden" name="post_type" value="' . esc_attr($_REQUEST['post_type']) . '" />' : '';

        $fields .= !empty($_REQUEST['product_cat']) ? '<input type="hidden" name="product_cat" value="' . esc_attr($_REQUEST['product_cat']) . '" />' : '';

        $fields .= !empty($_REQUEST['product_tag']) ? '<input type="hidden" name="product_tag" value="' . esc_attr($_REQUEST['product_tag']) . '" />' : '';

        $fields .= !empty($_REQUEST['orderby']) ? '<input type="hidden" name="orderby" value="' . esc_attr($_REQUEST['orderby']) . '" />' : '';

        if ($_chosen_attributes) {
            foreach ($_chosen_attributes as $attribute => $data) {
                $taxonomy_filter = 'filter_' . str_replace('pa_', '', $attribute);

                $fields .= '<input type="hidden" name="' . esc_attr($taxonomy_filter) . '" value="' . esc_attr(implode(',', $data['terms'])) . '" />';

                if ('or' == $data['query_type']) {
                    $fields .= '<input type="hidden" name="' . esc_attr(str_replace('pa_', 'query_type_', $attribute)) . '" value="or" />';
                }
            }
        }

        // Find min and max price in current result set
        $prices = nasa_get_filtered_price();
        $min = floor($prices->min_price);
        $max = ceil($prices->max_price);

        if ($min == $max) {
            return '<div id="' . $args['widget_id'] . '-ajax-wrap" class="nasa-hide-price nasa-filter-price-widget-wrap' . esc_attr($classWrap) . '" data-instance="' . esc_attr(json_encode($instance)) . '" data-args="' . esc_attr(json_encode($args)) . '">' .
                    $args['before_title'] . $instance['title'] . $args['after_title'] .
                    '</div>';
        }

        if ('' == get_option('permalink_structure')) {
            $form_action = remove_query_arg(array('page', 'paged'), add_query_arg($wp->query_string, '', home_url($wp->request)));
        } else {
            $form_action = preg_replace('%\/page/[0-9]+%', '', home_url(trailingslashit($wp->request)));
        }

        if (wc_tax_enabled() && 'incl' === get_option('woocommerce_tax_display_shop') && !wc_prices_include_tax()) {
            $tax_classes = array_merge(array(''), WC_Tax::get_tax_classes());
            $class_max = $max;

            foreach ($tax_classes as $tax_class) {
                if ($tax_rates = WC_Tax::get_rates($tax_class)) {
                    $class_max = $max + WC_Tax::get_tax_total(WC_Tax::calc_exclusive_tax($max, $tax_rates));
                }
            }

            $max = $class_max;
        }

        $res = '<div id="' . $args['widget_id'] . '-ajax-wrap" class="nasa-filter-price-widget-wrap' . esc_attr($classWrap) . '" data-instance="' . esc_attr(json_encode($instance)) . '" data-args="' . esc_attr(json_encode($args)) . '">';

        if ($instance['title'] != '') {
            $res .= $args['before_title'] . $instance['title'] . $args['after_title'];
        }

        $min_price = $min_price ? $min_price : apply_filters('woocommerce_price_filter_widget_min_amount', $min);
        $max_price = $max_price ? $max_price : apply_filters('woocommerce_price_filter_widget_max_amount', $max);
        
        /**
         * Round one more time
         */
        $data_min = floor($min);
        $data_max = ceil($max);

        $res .= '<form method="get" action="' . esc_url($form_action) . '">' .
                '<div class="price_slider_wrapper">' .
                '<div class="price_slider"></div>' .
                '<div class="price_slider_amount">' .
                '<input type="text" id="min_price" name="min_price" value="' . esc_attr($min_price) . '" data-min="' . esc_attr($data_min) . '" placeholder="' . esc_attr__('Min price', 'nasa-core') . '" />' .
                '<input type="text" id="max_price" name="max_price" value="' . esc_attr($max_price) . '" data-max="' . esc_attr($data_max) . '" placeholder="' . esc_attr__('Max price', 'nasa-core') . '" />' .
                '<div class="price_label">' .
                esc_html__('Price:', 'nasa-core') . ' <span class="from"></span> &mdash; <span class="to"></span>' .
                '</div>' .
                $fields .
                '<a href="javascript:void(0);" class="reset_price' . esc_attr($class_reset) . '">' . esc_html__('Reset', 'nasa-core') . '</a>' .
                '<div class="nasa-clear-both"></div>' .
                ($instance['btn_filter'] ? '<button type="submit" class="button">' . esc_html__('Filter', 'nasa-core') . '</button>' : '') .
                '</div>' .
                '</div>' .
                '<input type="hidden" class="nasa_hasPrice" name="nasa_hasPrice" value="' . esc_attr($hasPrice) . '" />' .
                '</form></div>';

        return $res;
    }

endif;

if (!function_exists('nasa_get_filtered_price')) :

    function nasa_get_filtered_price() {
        global $wpdb;

        $args = WC()->query->get_main_query()->query_vars;
        $tax_query = isset($args['tax_query']) ? $args['tax_query'] : array();
        $meta_query = isset($args['meta_query']) ? $args['meta_query'] : array();

        if (!is_post_type_archive('product') && !empty($args['taxonomy']) && !empty($args['term'])) {
            $tax_query[] = array(
                'taxonomy' => $args['taxonomy'],
                'terms' => array($args['term']),
                'field' => 'slug',
            );
        }

        foreach ($meta_query + $tax_query as $key => $query) {
            if (!empty($query['price_filter']) || !empty($query['rating_filter'])) {
                unset($meta_query[$key]);
            }
        }

        $meta_query = new WP_Meta_Query($meta_query);
        $tax_query = new WP_Tax_Query($tax_query);
        $search = WC_Query::get_main_search_query_sql();

        $meta_query_sql = $meta_query->get_sql('post', $wpdb->posts, 'ID');
        $tax_query_sql = $tax_query->get_sql($wpdb->posts, 'ID');
        $search_query_sql = $search ? ' AND ' . $search : '';

        $sql = "
        SELECT min( min_price ) as min_price, MAX( max_price ) as max_price
        FROM {$wpdb->wc_product_meta_lookup}
        WHERE product_id IN (
                SELECT ID FROM {$wpdb->posts}
                " . $tax_query_sql['join'] . $meta_query_sql['join'] . "
                WHERE {$wpdb->posts}.post_type IN ('" . implode("','", array_map('esc_sql', apply_filters('woocommerce_price_filter_post_type', array('product')))) . "')
                AND {$wpdb->posts}.post_status = 'publish'
                " . $tax_query_sql['where'] . $meta_query_sql['where'] . $search_query_sql . '
        )';

        $sql = apply_filters('woocommerce_price_filter_sql', $sql, $meta_query_sql, $tax_query_sql);

        return $wpdb->get_row($sql); // WPCS: unprepared SQL ok.
    }

endif;

// ================ Variation content widget
if (!function_exists('nasa_get_content_widget_variation')) :

    function nasa_get_content_widget_variation($args, $instance) {
        $hide_widget = false;
        $hide_empty = isset($instance['hide_empty']) && $instance['hide_empty'] ? true : false;
        $var_exist = $hide_empty ? false : true;

        $taxonomy = isset($instance['attribute']) ? wc_attribute_taxonomy_name($instance['attribute']) : '';

        if (!taxonomy_exists($taxonomy)) {
            $hide_widget = true;
            return array(
                'hide_widget' => $hide_widget,
                'content' => ''
            );
        }

        $content = '<div id="' . esc_attr($args['widget_id']) . '-ajax-wrap" class="nasa-filter-variations-widget-wrap">';

        $query_type = isset($instance['query_type']) ? $instance['query_type'] : 'or';
        $get_terms_args = array('taxonomy' => $taxonomy, 'hide_empty' => false);
        $orderby = wc_attribute_orderby($taxonomy);

        switch ($orderby) {
            case 'name' :
                $get_terms_args['orderby'] = 'name';
                $get_terms_args['menu_order'] = false;
                break;
            case 'id' :
                $get_terms_args['orderby'] = 'id';
                $get_terms_args['order'] = 'ASC';
                $get_terms_args['menu_order'] = false;
                break;
            case 'menu_order' :
                $get_terms_args['menu_order'] = 'ASC';
                break;
        }

        global $nasa_opt;

        $terms = get_terms(apply_filters('woocommerce_product_attribute_terms', $get_terms_args));

        $hasResult = false;
        $count_terms = $terms ? count($terms) : 0;
        if (0 < $count_terms) {
            $term_counts = nasa_get_filtered_term_product_counts(wp_list_pluck($terms, 'term_id'), $taxonomy, $query_type);

            $filter_name = 'filter_' . str_replace('pa_', '', $taxonomy);
            $current_filter = array();
            if (isset($_REQUEST[$filter_name]) && $_REQUEST[$filter_name] != '') {
                $current_filter = is_array($_REQUEST[$filter_name]) ? $_REQUEST[$filter_name] : explode(',', wc_clean($_REQUEST[$filter_name]));
            }

            $current_filter = array_map('sanitize_title', $current_filter);
            $vari_type = 'default';
            $taxonomyObj = null;
            $color_size = true;

            $color_switch = 'color';
            $label_switch = 'label';
            $image_switch = 'image';
            $nasa_attr_ux_exist = class_exists('Nasa_Abstract_WC_Attr_UX');
            if ($nasa_attr_ux_exist) {
                $taxonomyObj = Nasa_Abstract_WC_Attr_UX::get_tax_attribute($taxonomy);
                $color_switch = Nasa_Abstract_WC_Attr_UX::_NASA_COLOR;
                $label_switch = Nasa_Abstract_WC_Attr_UX::_NASA_LABEL;
                $image_switch = Nasa_Abstract_WC_Attr_UX::_NASA_IMAGE;
            }

            $class_ul = ' small-block-grid-1 medium-block-grid-4 large-block-grid-7';

            if ($taxonomyObj && isset($taxonomyObj->attribute_type)) {
                switch ($taxonomyObj->attribute_type) {
                    case $color_switch:
                        $vari_type = 'color';
                        break;

                    case $label_switch:
                        $vari_type = 'size';
                        break;

                    case $image_switch:
                        $vari_type = 'image';
                        $class_ul = ' small-block-grid-3 medium-block-grid-4 large-block-grid-5';
                        break;

                    default :
                        $color_size = false;
                        break;
                }
            }

            $show_items = isset($instance['show_items']) ? (int) $instance['show_items'] : 0;

            // Current term
            $queryObj = get_queried_object();
            $current_term_slug = absint((is_tax() && isset($queryObj->slug)) ? $queryObj->slug : 0);

            $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
            $content_li = '';

            foreach ($terms as $k => $term) {
                $count = isset($term_counts[$term->term_id]) ? $term_counts[$term->term_id] : 0;
                $term_meta = $color_size ? get_term_meta($term->term_id, $taxonomyObj->attribute_type, true) : null;
                $content_text = '<span class="nasa-text-variation nasa-text-variation-' . $vari_type . '">';
                $content_text .= ($vari_type == 'size' && trim($term_meta) != '') ? $term_meta : $term->name;
                $content_text .= '</span>';

                /* ======= Link ========================= */
                $current_filter_term = $current_filter;
                $current_values = isset($_chosen_attributes[$taxonomy]['terms']) ? $_chosen_attributes[$taxonomy]['terms'] : array();
                $option_is_set = in_array($term->slug, $current_values);

                if (!in_array($term->slug, $current_filter_term)) {
                    $current_filter_term[] = $term->slug;
                }
                $link = nasa_get_page_base_url($taxonomy);

                // Add current filters to URL.
                foreach ($current_filter_term as $key => $value) {
                    // Exclude query arg for current term archive term
                    if ($value === $current_term_slug) {
                        unset($current_filter_term[$key]);
                    }

                    // Exclude self so filter can be unset on click.
                    if ($option_is_set && $value === $term->slug) {
                        unset($current_filter_term[$key]);
                    }
                }

                if (!empty($current_filter_term)) {
                    $link = add_query_arg($filter_name, implode(',', $current_filter_term), $link);

                    // Add Query type Arg to URL
                    if ('or' === $query_type && !(1 === sizeof($current_filter_term) && $option_is_set)) {
                        $link = add_query_arg('query_type_' . sanitize_title(str_replace('pa_', '', $taxonomy)), 'or', $link);
                    }
                }

                if ($count > 0 || $option_is_set) {
                    $link = esc_url(apply_filters('woocommerce_layered_nav_link', $link, $term, $taxonomy));
                }
                /* ======= End Link ========================= */

                // Current Filter = this widget
                if (isset($current_filter) && is_array($current_filter) && in_array($term->slug, $current_filter)) {
                    $class = ' chosen nasa-chosen';
                    $aclass = ' nasa-filter-var-chosen';
                } else {
                    $class = $aclass = '';
                }

                $countClss = 'count';
                if ($vari_type != '') {
                    $class .= ' nasa-li-filter-' . $vari_type;
                    $aclass .= ' nasa-filter-' . $vari_type;
                    $countClss .= ' nasa-count-filter-' . $vari_type;
                }

                if ($count) {
                    $hasResult = true;
                    $var_exist = true;
                } else if (!$count && $hide_empty) {
                    $class .= ' nasa-empty-hidden';
                    $show_items = $show_items > 0 ? $show_items += 1 : $show_items;
                }

                $attr = esc_attr(sanitize_title(str_replace('pa_', '', $term->taxonomy)));
                $liClass = ($k % 2 == 0) ? 'nasa-odd' : 'nasa-even';

                $liClass .= ' no-hidden';
                $style = ($vari_type == 'color') ? ' style="background:' . esc_attr($term_meta) . '"' : '';

                $liClass .= ($show_items > 0 && $k >= $show_items) ? ' nasa-show-less' : '';

                $content_li .= '<li class="' . $liClass . $class . ' nasa-attr-' . $attr . ' nasa_' . $attr . '_' . esc_attr($term->term_id) . '">';

                $content_li .= '<a class="nasa-filter-by-variations' . $aclass . '" ' .
                        'data-term_id="' . esc_attr($term->term_id) . '" ' .
                        'data-term_slug="' . esc_attr($term->slug) . '" ' .
                        'data-attr="' . $attr . '" ' .
                        'data-type="' . esc_attr($query_type) . '" ' .
                        'href="' . ($link ? esc_attr($link) : 'javascript:void(0);') . '">';

                $content_li .= $vari_type == 'color' ? '<span class="nasa-filter-color-span" ' . $style . '></span>' : '';

                if ($vari_type == 'image' && $nasa_attr_ux_exist) {
                    $content_li .= '<span class="nasa-filter-image-border"><span class="nasa-filter-image-span">' . Nasa_Abstract_WC_Attr_UX::get_image_preview($term_meta, false, 28, 28) . '</span></span>';
                }

                $content_li .= $content_text;
                $content_li .= isset($instance['count']) && $instance['count'] ? ' <span class="' . $countClss . '">(' . $count . ')</span>' : '';
                $content_li .= '</a></li>';
            }

            $hide_widget = !$hasResult && $hide_empty ? true : false;
            if (!$hide_widget && !$var_exist) {
                $hide_widget = true;
            }

            if ($hide_widget) {
                return array('hide_widget' => $hide_widget, 'content' => '');
            }

            $content_ul = '<ul class="nasa-variations-' . $vari_type . $class_ul . '">';

            $fadeIn = (isset($instance['effect']) && $instance['effect'] == 'fade') ? '1' : '0';
            $content_li .= ($show_items && ($count_terms > $show_items)) ?
                '<li class="nasa_show_manual" data-fadein="' . $fadeIn . '">' .
                    '<a data-show="1" class="nasa-show" href="javascript:void(0);">' .
                        esc_html__('+ Show more', 'nasa-core') .
                    '</a>' .
                    '<a data-show="0" class="nasa-hidden" href="javascript:void(0);">' .
                        esc_html__('- Show less', 'nasa-core') .
                    '</a>' .
                '</li>' : '';

            $content .= $content_ul . $content_li . '</ul></div>';

            return array('hide_widget' => $hide_widget, 'content' => $content);
        }

        return array('hide_widget' => true, 'content' => '');
    }

endif;

/*
 * Get term count variations
 */
if (!function_exists('nasa_get_filtered_term_product_counts')) :

    function nasa_get_filtered_term_product_counts($term_ids, $taxonomy, $query_type) {
        global $wpdb;

        $meta_query = WC_Query::get_main_meta_query();
        $tax_query = WC_Query::get_main_tax_query();

        if ('or' === $query_type) {
            foreach ($tax_query as $key => $query) {
                if (isset($query['taxonomy']) && $taxonomy === $query['taxonomy']) {
                    unset($tax_query[$key]);
                }
            }
        }

        $meta_query = new WP_Meta_Query($meta_query);
        $tax_query = new WP_Tax_Query($tax_query);
        $meta_query_sql = $meta_query->get_sql('post', $wpdb->posts, 'ID');
        $tax_query_sql = $tax_query->get_sql($wpdb->posts, 'ID');

        // Generate query
        $query = array();
        $query['select'] = 'SELECT COUNT(DISTINCT ' . $wpdb->posts . '.ID) as term_count, terms.term_id as term_count_id';

        $query['from'] = 'FROM ' . $wpdb->posts;

        $query['join'] = 'INNER JOIN ' . $wpdb->term_relationships . ' AS term_relationships ON ' . $wpdb->posts . '.ID = term_relationships.object_id ' .
                'INNER JOIN ' . $wpdb->term_taxonomy . ' AS term_taxonomy USING(term_taxonomy_id) ' .
                'INNER JOIN ' . $wpdb->terms . ' AS terms USING(term_id) ' .
                $tax_query_sql['join'] . $meta_query_sql['join'];

        $query['where'] = 'WHERE ' . $wpdb->posts . '.post_type LIKE "product" ' .
                'AND ' . $wpdb->posts . '.post_status LIKE "publish" ' .
                $tax_query_sql['where'] . $meta_query_sql['where'] . ' ' .
                'AND terms.term_id IN (' . implode(',', array_map('absint', $term_ids)) . ')';

        // For search case
        if (isset($_GET['s']) && $_GET['s']) {
            $s = esc_sql(str_replace(array("\r", "\n"), '', stripslashes($_GET['s'])));

            $query['where'] .= ' AND (' . $wpdb->posts . '.post_title LIKE "%' . $s . '%" OR ' . $wpdb->posts . '.post_excerpt LIKE "%' . $s . '%" OR ' . $wpdb->posts . '.post_content LIKE "%' . $s . '%")';
        }

        $query['group_by'] = "GROUP BY terms.term_id";
        $queryString = implode(' ', apply_filters('woocommerce_get_filtered_term_product_counts_query', $query));
        $results = $wpdb->get_results($queryString);

        return wp_list_pluck($results, 'term_count', 'term_count_id');
    }

endif;

/**
 * Return the currently viewed term slug.
 * @return int
 */
if (!function_exists('nasa_get_current_term_slug')) :

    function nasa_get_current_term_slug() {
        return absint(is_tax() ? get_queried_object()->slug : 0);
    }

endif;

/**
 * Get current page URL for layered nav items.
 * @return string
 */
if (!function_exists('nasa_get_page_base_url')) :

    function nasa_get_page_base_url($taxonomy) {
        if (defined('SHOP_IS_ON_FRONT')) {
            $link = home_url();
        } elseif (is_post_type_archive('product') || is_page(wc_get_page_id('shop'))) {
            $link = get_post_type_archive_link('product');
        } elseif (is_product_category()) {
            $link = get_term_link(get_query_var('product_cat'), 'product_cat');
        } elseif (is_product_tag()) {
            $link = get_term_link(get_query_var('product_tag'), 'product_tag');
        } else {
            $queried_object = get_queried_object();
            $link = get_term_link($queried_object, $queried_object->taxonomy);
        }

        /**
         * Custom taxonomy
         */
        if (class_exists('Nasa_WC_Taxonomy')) {
            $nasa_taxonomy = apply_filters('nasa_taxonomy_custom_cateogory', Nasa_WC_Taxonomy::$nasa_taxonomy);
            if (isset($_REQUEST[$nasa_taxonomy])) {
                $link = add_query_arg($nasa_taxonomy, wc_clean(wp_unslash($_REQUEST[$nasa_taxonomy])), $link);
            }
        }

        // Min
        if (isset($_REQUEST['min_price'])) {
            $link = add_query_arg('min_price', wc_clean(wp_unslash($_REQUEST['min_price'])), $link);
        }

        // Max
        if (isset($_REQUEST['max_price'])) {
            $link = add_query_arg('max_price', wc_clean(wp_unslash($_REQUEST['max_price'])), $link);
        }

        // Orderby
        if (isset($_REQUEST['orderby'])) {
            $link = add_query_arg('orderby', wc_clean(wp_unslash($_REQUEST['orderby'])), $link);
        }

        /**
         * Search Arg.
         * To support quote characters, first they are decoded from &quot; entities, then URL encoded.
         */
        if (get_search_query()) {
            $link = add_query_arg('s', rawurlencode(wp_specialchars_decode(get_search_query())), $link);
        }

        // Post Type Arg
        if (isset($_REQUEST['post_type'])) {
            $link = add_query_arg('post_type', wc_clean(wp_unslash($_REQUEST['post_type'])), $link);
            
            // Prevent post type and page id when pretty permalinks are disabled.
            if ( is_shop() ) {
                $link = remove_query_arg('page_id', $link);
            }
        }

        // Min Rating Arg
        if (isset($_REQUEST['rating_filter'])) {
            $link = add_query_arg('rating_filter', wc_clean(wp_unslash($_REQUEST['rating_filter'])), $link);
        }

        // All current filters
        if ($_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes()) {
            $taxonomy = wc_attribute_taxonomy_slug($taxonomy);
            
            foreach ($_chosen_attributes as $name => $data) {
                $filter_name = wc_attribute_taxonomy_slug($name);
                if ($taxonomy == $filter_name) {
                    continue;
                }
                
                if (!empty($data['terms'])) {
                    $link = add_query_arg('filter_' . $filter_name, implode(',', $data['terms']), $link);
                }
                if ('or' === $data['query_type']) {
                    $link = add_query_arg('query_type_' . $filter_name, 'or', $link);
                }
            }
        }

        return $link;
    }

endif;

/**
 * Remove defaults widgets of Woocommerce
 */
add_action('init', 'nasa_remove_default_wg_woo');
if (!function_exists('nasa_remove_default_wg_woo')) :

    function nasa_remove_default_wg_woo() {
        global $nasa_opt;

        if ((!isset($nasa_opt['disable_ajax_product']) || !$nasa_opt['disable_ajax_product'])) {
            unregister_widget('WC_Widget_Price_Filter');
            unregister_widget('WC_Widget_Layered_Nav');
            unregister_widget('WC_Widget_Layered_Nav_Filters');
            unregister_widget('WC_Widget_Rating_Filter');
            unregister_widget('WC_Widget_Product_Search');
        }
    }

endif;
