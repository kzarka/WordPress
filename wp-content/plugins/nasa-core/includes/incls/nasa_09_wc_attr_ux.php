<?php
/**
 * Class Nasa Woocommerce attributies UX
 */
class Nasa_WC_Attr_UX extends Nasa_Abstract_WC_Attr_UX {

    protected static $instance = null;
    
    protected $_max_show = 0;
    
    protected $_content = '';
    
    protected $_key_cache = 'product_variable';
    
    /**
     * Support Multi Currencies
     * @var type 
     */
    protected $_currency = '';

    /**
     * Instance
     */
    public static function getInstance() {
        global $nasa_opt;
        
        if (isset($nasa_opt['enable_nasa_variations_ux']) && !$nasa_opt['enable_nasa_variations_ux']) {
            return null;
        }

        if (null == self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Class constructor.
     */
    public function __construct() {
        if (!class_exists('WooCommerce')) {
            return null;
        }
        
        global $nasa_opt;
        
        parent::__construct();
        
        $this->_max_show = (!isset($nasa_opt['limit_nasa_variations_ux']) || !(int) $nasa_opt['limit_nasa_variations_ux']) ? 5 : (int) $nasa_opt['limit_nasa_variations_ux'];
        
        add_filter('woocommerce_dropdown_variation_attribute_options_html', array($this, 'get_nasa_attr_ux_html'), 100, 2);
        add_filter('nasa_attr_ux_html', array($this, 'nasa_attr_ux_html'), 5, 4);
        add_action('nasa_static_content', array($this, 'nasa_static_enable_attr_ux'), 99);
        add_filter('woocommerce_available_variation', array($this, 'nasa_custom_variation'));
        
        /**
         * Get currency product
         */
        $this->_currency = get_woocommerce_currency();
        
        if (!isset($nasa_opt['load_variations_ux_ajax']) || $nasa_opt['load_variations_ux_ajax']) {
            add_action('woocommerce_after_shop_loop_item_title', array($this, 'add_product_type'), 999);
        } else {
            add_action('woocommerce_after_shop_loop_item_title', array($this, 'product_content_variations_color_label'), 999);
        }
    }
    
    /**
     * Ajax inputs value
     */
    public function nasa_static_enable_attr_ux() {
        echo '<input type="hidden" name="nasa_attr_ux" value="1" />';
        echo '<input type="hidden" name="add_to_cart_text" value="' . esc_html__('Add to cart', 'nasa-core') . '" />';
        echo '<input type="hidden" name="nasa_no_matching_variations" value="' . esc_html__('Sorry, no products matched your selection. Please choose a different combination.', 'nasa-core') . '" />';
    }
    
    /**
     * Image size for variations
     * Schedule time sale for variation
     * 
     * @param type $variation
     * @return type
     */
    public function nasa_custom_variation($variation) {
        if (!isset($variation['image_catalog'])) {
            $image = wp_get_attachment_image_src($variation['image_id'], 'shop_catalog');
            $variation['image_catalog'] = isset($image[0]) ? $image[0] : '';
        }
        
        if (!isset($variation['deal_time'])) {
            $time_from = get_post_meta($variation['variation_id'], '_sale_price_dates_from', true);
            $time_to = get_post_meta($variation['variation_id'], '_sale_price_dates_to', true);
            
            $arrayTime = array();
            if ($time_to) {
                $arrayTime['to'] = $time_to * 1000;
                $arrayTime['html'] = nasa_time_sale($time_to);
            }
            
            if ($time_from) {
                $arrayTime['from'] = $time_from * 1000;
            }
            
            $variation['deal_time'] = $arrayTime ? $arrayTime : false;
        }

        return $variation;
    }

    /**
     * 
     * @global type $product
     * @global type $nasa_termmeta
     * @return void
     */
    public function product_content_variations_color_label($return = false) {
        global $product;
        
        $product_type = $product->get_type();
        if ($product_type != 'variable') {
            return;
        }
        
        $productId = (int) $product->get_id();
        $this->_content = $this->get_cache_content($productId);
        if (!$this->_content) {
            $this->_content = '';
            
            $available_variations = $product->get_available_variations();
            if (empty($available_variations) && false !== $available_variations) {
                $this->set_cache_content($productId, $this->_content);
                return;
            }
            
            /**
             * Process Output
             */
            $outputs = $this->process_outputs();

            /**
             * Open Wrap variations
             */
            $this->_content .= '<div class="nasa-product-content-variable-warp" data-product_id="' . $productId . '" data-product_variations="' . htmlspecialchars(wp_json_encode($available_variations)) . '"><div class="nasa-inner-wrap">';
            
            /**
             * Selects variations
             */
            $this->select_render($productId, $outputs);
            
            /**
             * Custom variations
             */
            $this->custom_render($outputs);
            
            /**
             * Labels variations
             */
            $this->label_render($productId, $outputs);

            /**
             * Colors variations
             */
            $this->color_render($productId, $outputs);

            /**
             * Images variations
             */
            $this->image_render($productId, $outputs);

            /**
             * Close Wrap variations
             */
            $this->_content .= '</div></div>';
            
            /**
             * Cache file
             */
            $this->set_cache_content($productId, $this->_content);
        }
        
        if ($return) {
            return $this->_content;
        }
        
        echo $this->_content;
    }
    
    /**
     * Process Out put
     * 
     * @global type $nasa_termmeta
     * @global type $product
     * @return \type
     */
    protected function process_outputs() {
        global $product, $nasa_termmeta, $nasa_opt;
        
        $product_type = $product->get_type();
        if ($product_type != 'variable') {
            return;
        }
        
        $productId = $product->get_id();
        
        $nasa_colors = self::get_tax_color();
        $nasa_images = self::get_tax_images();
        $nasa_labels = self::get_tax_labels();
        $nasa_selects = $nasa_custom = $nasa_private_attr = null;
        
        if (isset($nasa_opt['enable_nasa_ux_select']) && $nasa_opt['enable_nasa_ux_select']) {
            $nasa_selects = self::get_tax_selects();
            $nasa_private_attr = get_post_meta($productId, '_product_attributes', true);
            if ($nasa_private_attr) {
                foreach ($nasa_private_attr as $objs) {
                    if (
                        isset($objs['is_taxonomy']) &&
                        !$objs['is_taxonomy'] &&
                        isset($objs['is_variation']) &&
                        $objs['is_variation']
                    ) {
                        if (!is_array($nasa_custom)) {
                            $nasa_custom = array();
                        }
                        
                        $nasa_custom[] = $objs['name'];
                    }
                }
            }
        }
        
        if (
            empty($nasa_colors) &&
            empty($nasa_labels) &&
            empty($nasa_images) &&
            empty($nasa_selects) &&
            empty($nasa_custom)) {
            return null;
        }

        $attributes = $product->get_variation_attributes();

        $outputs = array(
            self::_NASA_COLOR => array(),
            self::_NASA_LABEL => array(),
            self::_NASA_IMAGE => array(),
            self::_NASA_SELECT => array(),
            self::_NASA_ATTR_CUSTOM => array()
        );

        if (!isset($nasa_termmeta)) {
            $nasa_termmeta = array();
        }

        if (!isset($nasa_termmeta[$productId])) {
            $nasa_termmeta[$productId] = $outputs;
        }

        foreach ($attributes as $attribute_name => $options) {
            $attr_name = str_replace('pa_', '', $attribute_name);
            $default = $product->get_variation_default_attribute($attribute_name);

            /**
             * Init colors variations
             */
            if ($nasa_colors && in_array($attr_name, $nasa_colors)) {
                $k = 1;
                foreach ($options as $option) {
                    if (!isset($nasa_termmeta[$productId][self::_NASA_COLOR][$attr_name][$option])) {
                        if ($term = get_term_by('slug', $option, 'pa_' . $attr_name)) {
                            $active = $term->slug == $default ? true : false;
                            $term_meta = get_term_meta($term->term_id, self::_NASA_COLOR, true);
                            $term_meta = $term_meta ? $term_meta : $term->name;
                            $nasa_termmeta[$productId][self::_NASA_COLOR][$attr_name][$option] = $outputs[self::_NASA_COLOR][$attr_name][$option] = array('name' => $term->name, 'value' => $term_meta, 'active' => $active);

                            if ($this->_max_show && $k >= $this->_max_show) {
                                break;
                            }

                            $k++;
                        }
                    } else {
                        $outputs[self::_NASA_COLOR][$attr_name][$option] = $nasa_termmeta[$productId][self::_NASA_COLOR][$attr_name][$option];
                    }
                }
            }

            /**
             * Init images variations
             */
            if ($nasa_images && in_array($attr_name, $nasa_images)) {
                $k = 1;
                foreach ($options as $option) {
                    if (!isset($nasa_termmeta[$productId][self::_NASA_IMAGE][$attr_name][$option])) {
                        if ($term = get_term_by('slug', $option, 'pa_' . $attr_name)) {
                            $active = $term->slug == $default ? true : false;
                            $term_meta = get_term_meta($term->term_id, self::_NASA_IMAGE, true);
                            $nasa_termmeta[$productId][self::_NASA_IMAGE][$attr_name][$option] = $outputs[self::_NASA_IMAGE][$attr_name][$option] = array(
                                'name' => $term->name,
                                'value' => $term_meta,
                                'active' => $active
                            );

                            if ($this->_max_show && $k >= $this->_max_show) {
                                break;
                            }

                            $k++;
                        }
                    } else {
                        $outputs[self::_NASA_IMAGE][$attr_name][$option] = $nasa_termmeta[$productId][self::_NASA_IMAGE][$attr_name][$option];
                    }
                }
            }

            /**
             * Init labels variations
             */
            if ($nasa_labels && in_array($attr_name, $nasa_labels)) {
                $k = 1;
                foreach ($options as $option) {
                    if (!isset($nasa_termmeta[$productId][self::_NASA_LABEL][$attr_name][$option])) {
                        if ($term = get_term_by('slug', $option, 'pa_' . $attr_name)) {
                            $active = $term->slug == $default ? true : false;
                            $term_meta = get_term_meta($term->term_id, self::_NASA_LABEL, true);
                            $term_meta = $term_meta ? $term_meta : $term->name;
                            $nasa_termmeta[$productId][self::_NASA_LABEL][$attr_name][$option] = $outputs[self::_NASA_LABEL][$attr_name][$option] = array('name' => $term->name, 'value' => $term_meta, 'active' => $active);

                            if ($this->_max_show && $k >= $this->_max_show) {
                                break;
                            }

                            $k++;
                        }
                    } else {
                        $outputs[self::_NASA_LABEL][$attr_name][$option] = $nasa_termmeta[$productId][self::_NASA_LABEL][$attr_name][$option];
                    }
                }
            }

            /**
             * Init select variations
             */
            if ($nasa_selects && in_array($attr_name, $nasa_selects)) {
                $k = 1;
                foreach ($options as $option) {
                    if (!isset($nasa_termmeta[$productId][self::_NASA_SELECT][$attr_name][$option])) {
                        if ($term = get_term_by('slug', $option, 'pa_' . $attr_name)) {
                            $active = $term->slug == $default ? true : false;
                            $term_meta = get_term_meta($term->term_id, self::_NASA_SELECT, true);
                            $term_meta = $term_meta ? $term_meta : $term->name;
                            $nasa_termmeta[$productId][self::_NASA_SELECT][$attr_name][$option] = $outputs[self::_NASA_SELECT][$attr_name][$option] = array('name' => $term->name, 'value' => $term_meta, 'active' => $active);
                            if ($this->_max_show && $k >= $this->_max_show) {
                                break;
                            }

                            $k++;
                        }
                    } else {
                        $outputs[self::_NASA_SELECT][$attr_name][$option] = $nasa_termmeta[$productId][self::_NASA_SELECT][$attr_name][$option];
                    }
                }
            }
            
            /**
             * Init custom variations
             */
            if ($nasa_custom && in_array($attr_name, $nasa_custom)) {
                $k = 1;
                foreach ($options as $option) {
                    if (!isset($nasa_termmeta[$productId][self::_NASA_ATTR_CUSTOM][$attr_name][$option])) {
                        $active = $option == $default ? true : false;
                        $nasa_termmeta[$productId][self::_NASA_ATTR_CUSTOM][$attr_name][$option] = $outputs[self::_NASA_ATTR_CUSTOM][$attr_name][$option] = array('name' => $option, 'value' => $option, 'active' => $active);
                        if ($this->_max_show && $k >= $this->_max_show) {
                            break;
                        }

                        $k++;
                    } else {
                        $outputs[self::_NASA_ATTR_CUSTOM][$attr_name][$option] = $nasa_termmeta[$productId][self::_NASA_ATTR_CUSTOM][$attr_name][$option];
                    }
                }
            }
        }

        $GLOBALS['nasa_termmeta'] = $nasa_termmeta;
        
        return $outputs;
    }

    /**
     * Labels variations
     */
    protected function label_render($productId, $outputs) {
        if (!empty($outputs[self::_NASA_LABEL])) {
            $this->_content .= '<div class="nasa-product-content-' . self::_NASA_LABEL . '-wrap">';

            foreach ($outputs[self::_NASA_LABEL] as $attr_name => $objs) {
                $terms = wc_get_product_terms($productId, 'pa_' . $attr_name, array('fields' => 'all'));
                $array_keys = array_keys($objs);
                $this->_content .= '<div class="nasa-product-content-child nasa-product-content-' . sanitize_title($attr_name) . '-wrap-child" data-pa_name="' . sanitize_title($attr_name) . '">';
                $k = 1;
                foreach ($terms as $term) {
                    if (in_array($term->slug, $array_keys)) {
                        $this->_content .= sprintf(
                            '<a href="javascript:void(0);" class="nasa-attr-ux-item nasa-attr-ux-' . self::_NASA_LABEL . ' nasa-attr-ux-%s %s" data-value="%s" data-pa="%s" data-act="%s">%s</a>',
                            esc_attr($term->slug),
                            $objs[$term->slug]['active'] ? 'nasa-active' : '',
                            esc_attr($term->slug),
                            sanitize_title($attr_name),
                            $objs[$term->slug]['active'] ? '1' : '0',
                            $objs[$term->slug]['value']
                        );

                        if ($this->_max_show && $k >= $this->_max_show) {
                            break;
                        }
                        $k++;
                    }
                }

                $this->_content .= '</div>';
            }

            $this->_content .= '</div>';
        }
    }

    /**
     * Colors variations
     */
    protected function color_render($productId, $outputs) {
        if (!empty($outputs[self::_NASA_COLOR])) {
            $this->_content .= '<div class="nasa-product-content-' . self::_NASA_COLOR . '-wrap">';
            
            foreach ($outputs[self::_NASA_COLOR] as $attr_name => $objs) {
                $terms = wc_get_product_terms($productId, 'pa_' . $attr_name, array('fields' => 'all'));
                $array_keys = array_keys($objs);
                $this->_content .= '<div class="nasa-product-content-child nasa-product-content-' . sanitize_title($attr_name) . '-wrap-child" data-pa_name="' . sanitize_title($attr_name) . '">';
                $k = 1;
                foreach ($terms as $term) {
                    if (in_array($term->slug, $array_keys)) {
                        
                        $this->_content .= sprintf(
                            '<a href="javascript:void(0);" class="nasa-attr-ux-item nasa-attr-ux-' . self::_NASA_COLOR . ' nasa-attr-ux-%s' . ($objs[$term->slug]['active'] ? ' nasa-active' : '') . '" data-value="%s" data-pa="%s" data-act="%s"><span style="background-color:%s;"></span><span class="nasa-title-attr">%s</span></a>',
                            esc_attr($term->slug),
                            esc_attr($term->slug),
                            sanitize_title($attr_name),
                            $objs[$term->slug]['active'] ? '1' : '0',
                            $objs[$term->slug]['value'] ? esc_attr($objs[$term->slug]['value']) : $objs[$term->slug]['name'],
                            $objs[$term->slug]['name']
                        );
                        
                        if ($this->_max_show && $k >= $this->_max_show) {
                            break;
                        }
                        $k++;
                    }
                }
                
                $this->_content .= '</div>';
            }
            
            $this->_content .= '</div>';
        }
    }
    
    /**
     * Images variations
     */
    protected function image_render($productId, $outputs) {
        if (!empty($outputs[self::_NASA_IMAGE])) {
            $this->_content .= '<div class="nasa-product-content-' . self::_NASA_IMAGE . '-wrap">';
            
            foreach ($outputs[self::_NASA_IMAGE] as $attr_name => $objs) {
                $terms = wc_get_product_terms($productId, 'pa_' . $attr_name, array('fields' => 'all'));
                $array_keys = array_keys($objs);
                $this->_content .= '<div class="nasa-product-content-child nasa-product-content-' . sanitize_title($attr_name) . '-wrap-child slider nasa-slider owl-carousel" data-margin="0" data-margin-small="0" data-margin-medium="0" data-columns="3" data-columns-small="3" data-columns-tablet="3" data-autoplay="false" data-height-auto="false" data-disable-nav="false" data-mobile-nav="true" data-disable-drag="true" data-pa_name="' . sanitize_title($attr_name) . '">';
                $k = 1;
                foreach ($terms as $term) {
                    if (in_array($term->slug, $array_keys)) {
                        
                        $image = $this->get_image_preview($objs[$term->slug]['value'], false, 20, 20, $objs[$term->slug]['name']);
                        $this->_content .= sprintf(
                            '<a href="javascript:void(0);" class="nasa-attr-ux-item nasa-attr-ux-' . self::_NASA_IMAGE . ' nasa-attr-ux-%s' . ($objs[$term->slug]['active'] ? ' nasa-active' : '') . '" data-value="%s" data-pa="%s" data-act="%s"><span class="img-attr-wrap">%s</span></a>',
                            esc_attr($term->slug),
                            esc_attr($term->slug),
                            sanitize_title($attr_name),
                            $objs[$term->slug]['active'] ? '1' : '0',
                            $image
                        );
                        
                        if ($this->_max_show && $k >= $this->_max_show) {
                            break;
                        }
                        
                        $k++;
                    }
                }
                
                $this->_content .= '</div>';
            }
            
            $this->_content .= '</div>';
        }
    }
    
    /**
     * Selects variations
     */
    protected function select_render($productId, $outputs) {
        if (!empty($outputs[self::_NASA_SELECT])) {
            $this->_content .= '<div class="nasa-product-content-' . self::_NASA_SELECT . '-wrap">';

            foreach ($outputs[self::_NASA_SELECT] as $attr_name => $objs) {
                $terms = wc_get_product_terms($productId, 'pa_' . $attr_name, array('fields' => 'all'));
                $array_keys = array_keys($objs);
                $this->_content .= '<div class="nasa-product-content-child nasa-product-content-' . sanitize_title($attr_name) . '-wrap-child" data-pa_name="' . sanitize_title($attr_name) . '">';
                
                foreach ($terms as $term) {
                    if (in_array($term->slug, $array_keys)) {
                        $this->_content .= sprintf(
                            '<a href="javascript:void(0);" class="nasa-attr-ux-item nasa-attr-ux-' . self::_NASA_SELECT . ' nasa-attr-ux-%s' . ($objs[$term->slug]['active'] ? ' nasa-active' : '') . '" data-value="%s" data-pa="%s" data-act="%s">%s</a>',
                            esc_attr($term->slug),
                            esc_attr($term->slug),
                            sanitize_title($attr_name),
                            $objs[$term->slug]['active'] ? '1' : '0',
                            $objs[$term->slug]['value']
                        );
                    }
                }
                
                $this->_content .= '</div>';
            }
            
            $this->_content .= '</div>';
        }
    }
    
    /**
     * Custom variations
     */
    protected function custom_render($outputs) {
        if (!empty($outputs[self::_NASA_ATTR_CUSTOM])) {
            $this->_content .= '<div class="nasa-product-content-' . self::_NASA_ATTR_CUSTOM . '-wrap">';
            foreach ($outputs[self::_NASA_ATTR_CUSTOM] as $attr_name => $objs) {
                $this->_content .= '<div class="nasa-product-content-child nasa-product-content-' . sanitize_title($attr_name) . '-wrap-child nasa-attr_type_custom" data-pa_name="' . sanitize_title($attr_name) . '">';
                
                foreach ($objs as $key => $term) {
                    $this->_content .= sprintf(
                        '<a href="javascript:void(0);" class="nasa-attr-ux-item nasa-attr-ux-' . self::_NASA_ATTR_CUSTOM . ' nasa-attr-ux-%s' . ($term['active'] ? ' nasa-active' : '') . '" data-value="%s" data-pa="%s" data-act="%s">%s</a>',
                        esc_attr($term['value']),
                        esc_attr($term['value']),
                        sanitize_title($attr_name),
                        $term['active'] ? '1' : '0',
                        $term['value']
                    );
                }
                
                $this->_content .= '</div>';
            }
            
            $this->_content .= '</div>';
        }
    }
    
    /**
     * Filter function to add swatches bellow the default selector
     *
     * @param $html
     * @param $args
     *
     * @return string
     */
    public function get_nasa_attr_ux_html($html, $args) {
        $attr = self::get_tax_attribute($args['attribute']);

        // Return if this is normal attribute
        if (empty($attr)) {
            return $html;
        }

        if (!array_key_exists($attr->attribute_type, $this->types)) {
            return $html;
        }

        $options = $args['options'];
        $product = $args['product'];
        $attribute = $args['attribute'];
        $class = 'variation-selector variation-select-' . $attr->attribute_type;
        $nasa_attr_ux = '';

        if (empty($options) && !empty($product) && !empty($attribute)) {
            $attributes = $product->get_variation_attributes();
            $options = $attributes[$attribute];
        }

        if (!empty($options) && $product && taxonomy_exists($attribute)) {
            // Get terms if this is a taxonomy - ordered. We need the names too.
            $terms = wc_get_product_terms($product->get_id(), $attribute, array('fields' => 'all'));

            foreach ($terms as $term) {
                if (in_array($term->slug, $options)) {
                    $nasa_attr_ux .= apply_filters('nasa_attr_ux_html', '', $term, $attr, $args);
                }
            }
        }

        if (!empty($nasa_attr_ux)) {
            $class .= ' hidden-tag';

            $nasa_attr_ux = '<div class="nasa-attr-ux_wrap" data-attribute_name="attribute_' . sanitize_title($attribute) . '">' . $nasa_attr_ux . '</div>';
            $html = '<div class="' . esc_attr($class) . '">' . $html . '</div>' . $nasa_attr_ux;
        }

        return $html;
    }
    
    /**
     * Add product type
     */
    public function add_product_type() {
        global $product;
        if ($product->get_type() != 'variable') {
            return;
        }
        
        $product_id = $product->get_id();
        $content = $this->get_cache_content($product_id);
        
        echo $content ? $content : '<div class="nasa-product-variable-call-ajax no-process nasa-product-variable-' . esc_attr($product_id) . ' hidden-tag" data-product_id="' . esc_attr($product_id) . '"></div>';
    }
    
    /**
     * Render variable string to product
     */
    public function render_variables($pids = array()) {
        $products = array();
        
        if (empty($pids)) {
            return $products;
        }
        
        foreach ($pids as $pid) {
            $product = wc_get_product($pid);
            
            if ($product->get_type() == 'variable') {
                $GLOBALS['product'] = $product;
                
                $products[$pid] = $this->product_content_variations_color_label(true);
            }
        }
        
        return $products;
    }

    /**
     * Print HTML of a single swatch
     *
     * @param $html
     * @param $term
     * @param $attr
     * @param $args
     *
     * @return string
     */
    public function nasa_attr_ux_html($html, $term, $attr, $args) {
        $selected = sanitize_title($args['selected']) == $term->slug ? ' selected' : '';
        $name = esc_html(apply_filters('woocommerce_variation_option_name', $term->name));
        $term_meta = get_term_meta($term->term_id, $attr->attribute_type, true);
        switch ($attr->attribute_type) {
            case self::_NASA_COLOR:
                $html = sprintf(
                    '<a href="javascript:void(0);" class="nasa-attr-ux nasa-attr-ux-color nasa-attr-ux-%s' . $selected . '" title="%s" data-value="%s"><span class="nasa-attr-bg" style="background-color:%s;"></span><span class="nasa-attr-text">%s</span></a>',
                    esc_attr($term->slug),
                    esc_attr($name),
                    esc_attr($term->slug),
                    esc_attr($term_meta),
                    $name
                );
                break;

            case self::_NASA_LABEL:
                $label = $term_meta ? $term_meta : $name;
                $html = sprintf(
                    '<a href="javascript:void(0);" class="nasa-attr-ux nasa-attr-ux-label nasa-attr-ux-%s' . $selected . '" title="%s" data-value="%s"><span class="nasa-attr-bg"></span><span class="nasa-attr-text">%s</span></a>',
                    esc_attr($term->slug),
                    esc_attr($name),
                    esc_attr($term->slug),
                    esc_html($label)
                );
                break;
            
            case self::_NASA_IMAGE:
                $image = $this->get_image_preview($term_meta, false, 30, 30, $name);
                $html = sprintf(
                    '<a href="javascript:void(0);" class="nasa-attr-ux nasa-attr-ux-image nasa-attr-ux-%s' . $selected . '" title="%s" data-value="%s"><span class="nasa-attr-bg-img">%s</span><span class="nasa-attr-text">%s</span></a>',
                    esc_attr($term->slug),
                    esc_attr($name),
                    esc_attr($term->slug),
                    $image,
                    $name
                );
                break;
        }

        return $html;
    }
    
    /**
     * Set cache file for variation of Product
     * 
     * @global type $wp_filesystem
     * @global string $nasa_cache_dir
     * @param type $productId
     * @param type $content
     * @return boolean
     */
    protected function set_cache_content($productId, $content) {
        global $nasa_opt;
        if (isset($nasa_opt['nasa_cache_variables']) && !$nasa_opt['nasa_cache_variables']) {
            return false;
        }
        
        return Nasa_Caching::set_content($this->_key_cache_product($productId), $content, $this->_key_cache);
    }
    
    /**
     * Get cache variation of Product
     * 
     * @global type $nasa_opt
     * @global type $wp_filesystem
     * @global string $nasa_cache_dir
     * @param type $productId
     * @return boolean
     */
    protected function get_cache_content($productId) {
        global $nasa_opt;
        if (isset($nasa_opt['nasa_cache_variables']) && !$nasa_opt['nasa_cache_variables']) {
            return false;
        }
        
        return Nasa_Caching::get_content($this->_key_cache_product($productId), $this->_key_cache);
    }
    
    /**
     * Build key Cache
     */
    protected function _key_cache_product($productId) {
        return $productId . '_' . $this->_currency;
    }
}

/**
 * Instantiate Class
 */
add_action('init', array('Nasa_WC_Attr_UX', 'getInstance'));
