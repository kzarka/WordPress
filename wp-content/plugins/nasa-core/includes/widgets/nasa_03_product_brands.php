<?php
if (class_exists('WC_Widget') && class_exists('YITH_WCBR')) {
    
    add_action('widgets_init', 'nasa_product_brands_widget');

    function nasa_product_brands_widget() {
        register_widget('Nasa_Product_Brands_Widget');
    }

    class Nasa_Product_Brands_Widget extends WC_Widget {
        
        const TAX_NAME = 'yith_product_brand';

        /**
         * Category ancestors
         *
         * @var array
         */
        public $brand_ancestors;

        /**
         * Current Category
         *
         * @var bool
         */
        public $current_brand;

        /**
         * Constructor
         */
        public function __construct() {
            $this->widget_cssclass = 'woocommerce widget_product_brands';
            $this->widget_description = esc_html__('Display product brands with Accordion.', 'nasa-core');
            $this->widget_id = 'nasa_product_brands';
            $this->widget_name = esc_html__('Nasa Product Brands', 'nasa-core');
            $this->settings = array(
                'title' => array(
                    'type' => 'text',
                    'std' => esc_html__('Product Brands', 'nasa-core'),
                    'label' => esc_html__('Title', 'nasa-core')
                ),
                'count' => array(
                    'type' => 'checkbox',
                    'std' => 0,
                    'label' => esc_html__('Show product counts', 'nasa-core')
                ),
                'accordion' => array(
                    'type' => 'checkbox',
                    'std' => 1,
                    'label' => esc_html__('Show as Accordion', 'nasa-core')
                ),
                'show_items' => array(
                    'type' => 'text',
                    'std' => 'All',
                    'label' => esc_html__('Show default numbers items', 'nasa-core')
                )
            );
            
            parent::__construct();
        }

        /**
         * Updates a particular instance of a widget.
         *
         * @see WP_Widget->update
         *
         * @param array $new_instance
         * @param array $old_instance
         *
         * @return array
         */
        public function update($new_instance, $old_instance) {
            $this->nasa_settings($new_instance);

            return parent::update($new_instance, $old_instance);
        }

        /**
         * form function.
         *
         * @see WP_Widget->form
         * @param array $instance
         */
        public function form($instance) {
            $this->nasa_settings($instance);

            if (empty($this->settings)) {
                return;
            }

            foreach ($this->settings as $key => $setting) {
                $value = isset($instance[$key]) ? $instance[$key] : $setting['std'];
                $_id = $this->get_field_id($key);
                $_name = $this->get_field_name($key);

                switch ($setting['type']) {

                    case 'text' :
                        ?>
                        <p>
                            <label for="<?php echo esc_attr($_id); ?>"><?php echo $setting['label']; ?></label>
                            <input class="widefat" id="<?php echo esc_attr($_id); ?>" name="<?php echo esc_attr($_name); ?>" type="text" value="<?php echo esc_attr($value); ?>" />
                        </p>
                        <?php
                        break;

                    case 'number' :
                        ?>
                        <p>
                            <label for="<?php echo esc_attr($_id); ?>"><?php echo $setting['label']; ?></label>
                            <input class="widefat" id="<?php echo esc_attr($_id); ?>" name="<?php echo esc_attr($_name); ?>" type="number" step="<?php echo esc_attr($setting['step']); ?>" min="<?php echo esc_attr($setting['min']); ?>" max="<?php echo esc_attr($setting['max']); ?>" value="<?php echo esc_attr($value); ?>" />
                        </p>
                        <?php
                        break;

                    case 'select' :
                        ?>
                        <p>
                            <label for="<?php echo esc_attr($_id); ?>"><?php echo $setting['label']; ?></label>
                            <select class="widefat" id="<?php echo esc_attr($_id); ?>" name="<?php echo esc_attr($_name); ?>">
                                <?php foreach ($setting['options'] as $o_key => $o_value): ?>
                                    <option value="<?php echo esc_attr($o_key); ?>" <?php selected($o_key, $value); ?>><?php echo esc_html($o_value); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </p>
                        <?php
                        break;

                    case 'checkbox' :
                        ?>
                        <p>
                            <input id="<?php echo esc_attr($_id); ?>" name="<?php echo esc_attr($_name); ?>" type="checkbox" value="1" <?php checked($value, 1); ?> />
                            <label for="<?php echo esc_attr($_id); ?>"><?php echo $setting['label']; ?></label>
                        </p>
                        <?php
                        break;

                    // Button chosen icon font
                    case 'icons':
                        echo $this->getTemplateAdminIcon($_name, $_id, $setting['label'], $value);
                        break;
                }
            }
        }
        
        public function getTemplateAdminIcon($_name, $_id, $label, $value) {
            $content = '<p>';
            $content .= '<a class="nasa-chosen-icon" data-fill="' . esc_attr($_id) . '">' . esc_html__('Click select icon for ', 'nasa-core') . '</a>';
            $content .= '<span id="ico-' . esc_attr($_id) . '">';
            if ($value):
                $content .= '<i class="' . esc_attr($value) . '"></i>';
                $content .= '<a href="javascript:void(0);" class="nasa-remove-icon" data-id="' . esc_attr($_id) . '">';
                $content .= '<i class="fa fa-remove"></i>';
                $content .= '</a>';
            endif;
            $content .= '</span>';
            $content .= '<label for="' . $_id . '">' . $label . '</label><br />';
            $content .= '<input class="widefat" id="' . esc_attr($_id) . '" name="' . $_name . '" type="hidden" readonly="true" value="' . esc_attr($value) . '" />';
            $content .= '</p>';

            return $content;
        }

        /**
         * Init settings after post types are registered.
         */
        public function nasa_settings($instance) {
            // Default setting color
            if (empty($instance)) {
                if ($default = get_option('widget_' . $this->widget_id, true)) {
                    foreach ($default as $v) {
                        $instance = $v;
                        break;
                    }
                }
            }

            $top_level = get_terms(apply_filters('woocommerce_product_attribute_terms', array(
                'taxonomy' => self::TAX_NAME,
                'hierarchical' => true,
                'hide_empty' => false
            )));
            
            if ($top_level) {
                foreach ($top_level as $v) {
                    // Change settings
                    $this->settings['brand_' . $v->slug] = array(
                        'type' => 'icons',
                        'std' => isset($instance['brand_' . $v->slug]) ? $instance['brand_' . $v->slug] : '',
                        'label' => '<b>' . $v->name . '</b>'
                    );
                }
            }
        }

        /**
         * widget function.
         *
         * @see WP_Widget
         *
         * @param array $args
         * @param array $instance
         *
         * @return void
         */
        public function widget($args, $instance) {
            global $wp_query, $post;
            $show_items = isset($instance['show_items']) ? (int) $instance['show_items'] : 0;
            
            $a = isset($instance['accordion']) ? $instance['accordion'] : $this->settings['accordion']['std'];
            $c = isset($instance['count']) ? $instance['count'] : $this->settings['count']['std'];
            $h = isset($instance['hierarchical']) ? $instance['hierarchical'] : 1;
            $o = 'name';
            $list_args = array('show_count' => $c, 'hierarchical' => $h, 'taxonomy' => self::TAX_NAME, 'hide_empty' => false);

            // Menu Order
            $list_args['menu_order'] = false;
            if ($o == 'order') {
                $list_args['menu_order'] = 'asc';
            } else {
                $list_args['orderby'] = 'title';
            }

            // Setup Current Category
            $this->current_brand = false;
            $this->brand_ancestors = array();

            if (is_tax(self::TAX_NAME)) {
                $this->current_brand = $wp_query->queried_object;
                $this->brand_ancestors = get_ancestors($this->current_brand->term_id, self::TAX_NAME);
            } elseif (is_singular('product')) {
                $product_brand = wc_get_product_terms($post->ID, self::TAX_NAME, array('orderby' => 'parent'));

                if ($product_brand) {
                    $this->current_brand = end($product_brand);
                    $this->brand_ancestors = get_ancestors($this->current_brand->term_id, self::TAX_NAME);
                }
            }
            
            $this->widget_start($args, $instance);
            
            $menu_cat = new Nasa_Product_Brand_List_Walker();
            $menu_cat->setIcons($instance);
            $menu_cat->setShowDefault($show_items);
            $list_args['walker'] = $menu_cat;
            $list_args['title_li'] = '';
            $list_args['pad_counts'] = 1;
            $list_args['show_option_none'] = esc_html__('No product categories exist.', 'nasa-core');
            $list_args['current_brand'] = $this->current_brand ? $this->current_brand->term_id : '';
            $list_args['current_brand_ancestors'] = $this->brand_ancestors;
            $accordion = $a ? ' nasa-accordion' : '';

            echo '<ul class="nasa-root-cat product-categories' . $accordion . '">';
            wp_list_categories(apply_filters('woocommerce_product_brands_widget_args', $list_args));

            if ($show_items && ($menu_cat->getTotalRoot() > $show_items)) {
                echo '<li class="nasa_show_manual"><a data-show="1" class="nasa-show" href="javascript:void(0);">' . esc_html__('+ Show more', 'nasa-core') . '</a><a data-show="0" class="nasa-hidden" href="javascript:void(0);">' . esc_html__('- Show less', 'nasa-core') . '</a></li>';
            }

            echo '</ul>';

            $this->widget_end($args);
        }

    }
}
